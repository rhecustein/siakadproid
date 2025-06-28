<?php

namespace App\Http\Controllers\Canteen;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CanteenPurchase;
use App\Models\CanteenPurchaseItem;
use App\Models\CanteenProduct;
use App\Models\CanteenSupplier;
use App\Models\CanteenStockMovement;
use Illuminate\Support\Facades\DB;

class CanteenShoppingListController extends Controller
{
    public function index(Request $request)
    {
        $purchases = CanteenPurchase::with(['supplier', 'items.product'])
            ->where('status', 'approved')
            ->when($request->date, fn($q) => $q->whereDate('created_at', $request->date))
            ->latest()
            ->get();

        return view('canteen.shopping_list.index', compact('purchases'));
    }

    public function show($id)
    {
        $purchase = CanteenPurchase::with(['supplier', 'items.product'])->findOrFail($id);
        return view('canteen.shopping_list.show', compact('purchase'));
    }

    public function create()
    {
        $suppliers = CanteenSupplier::orderBy('name')->get();
        $products = CanteenProduct::orderBy('name')->get();
        return view('canteen.purchases.create', compact('suppliers', 'products'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'supplier_id' => 'required|exists:canteen_suppliers,id',
            'tanggal' => 'required|date',
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:canteen_products,id',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.unit_price' => 'required|numeric|min:0',
        ]);

        DB::beginTransaction();
        try {
            $total = 0;
            foreach ($request->items as $item) {
                $total += $item['quantity'] * $item['unit_price'];
            }

            $purchase = CanteenPurchase::create([
                'canteen_id' => 1, // sesuaikan jika multi kantin
                'supplier_id' => $request->supplier_id,
                'total_price' => $total,
                'status' => $request->action === 'approve' ? 'approved' : 'draft',
                'note' => $request->note,
                'created_by' => auth()->id(),
                'created_at' => $request->tanggal,
            ]);

            foreach ($request->items as $item) {
                CanteenPurchaseItem::create([
                    'canteen_purchase_id' => $purchase->id,
                    'canteen_product_id' => $item['product_id'],
                    'quantity' => $item['quantity'],
                    'unit_price' => $item['unit_price'],
                    'subtotal' => $item['quantity'] * $item['unit_price'],
                ]);
            }

            DB::commit();
            return redirect()->route('canteen.shopping-list.index')->with('success', 'Pembelian berhasil disimpan.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->with('error', 'Gagal menyimpan pembelian: ' . $e->getMessage());
        }
    }

    public function edit($id)
    {
        $purchase = CanteenPurchase::with('items')->findOrFail($id);
        if ($purchase->status !== 'draft') {
            return redirect()->route('canteen.shopping-list.index')->with('error', 'Hanya pembelian draft yang bisa diedit.');
        }

        $suppliers = CanteenSupplier::orderBy('name')->get();
        $products = CanteenProduct::orderBy('name')->get();
        return view('canteen.purchases.edit', compact('purchase', 'suppliers', 'products'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'supplier_id' => 'required|exists:canteen_suppliers,id',
            'tanggal' => 'required|date',
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:canteen_products,id',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.unit_price' => 'required|numeric|min:0',
        ]);

        $purchase = CanteenPurchase::with('items')->findOrFail($id);
        if ($purchase->status !== 'draft') {
            return redirect()->route('canteen.shopping-list.index')->with('error', 'Hanya pembelian draft yang bisa diupdate.');
        }

        DB::beginTransaction();
        try {
            $total = 0;
            foreach ($request->items as $item) {
                $total += $item['quantity'] * $item['unit_price'];
            }

            $purchase->update([
                'supplier_id' => $request->supplier_id,
                'total_price' => $total,
                'note' => $request->note,
                'status' => $request->action === 'approve' ? 'approved' : 'draft',
                'created_at' => $request->tanggal,
            ]);

            $purchase->items()->delete();

            foreach ($request->items as $item) {
                CanteenPurchaseItem::create([
                    'canteen_purchase_id' => $purchase->id,
                    'canteen_product_id' => $item['product_id'],
                    'quantity' => $item['quantity'],
                    'unit_price' => $item['unit_price'],
                    'subtotal' => $item['quantity'] * $item['unit_price'],
                ]);
            }

            DB::commit();
            return redirect()->route('canteen.shopping-list.index')->with('success', 'Pembelian berhasil diperbarui.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->with('error', 'Gagal update pembelian: ' . $e->getMessage());
        }
    }

    public function markAsReceived($id)
    {
        $purchase = CanteenPurchase::with('items.product')->findOrFail($id);

        if ($purchase->status !== 'approved') {
            return redirect()->back()->with('error', 'Transaksi tidak dapat diproses. Status harus "approved".');
        }

        DB::beginTransaction();
        try {
            foreach ($purchase->items as $item) {
                $product = $item->product;
                if (!$product) {
                    throw new \Exception('Produk tidak ditemukan untuk item ID: ' . $item->id);
                }

                $product->stock += $item->quantity;
                $product->save();

                CanteenStockMovement::create([
                    'canteen_product_id' => $product->id,
                    'type' => 'in',
                    'quantity' => $item->quantity,
                    'unit_price' => $item->unit_price,
                    'reference_type' => 'purchase',
                    'reference_id' => $purchase->id,
                    'moved_at' => now(),
                ]);
            }

            $purchase->update([
                'status' => 'received',
                'received_date' => now(),
            ]);

            DB::commit();
            return redirect()->route('canteen.shopping-list.index')->with('success', 'Pembelian berhasil diterima & stok diperbarui.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Gagal memproses pembelian: ' . $e->getMessage());
        }
    }
}
