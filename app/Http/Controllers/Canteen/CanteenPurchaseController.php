<?php

namespace App\Http\Controllers\Canteen;

use App\Http\Controllers\Controller;
use App\Models\Canteen;
use App\Models\CanteenProduct;
use App\Models\CanteenSupplier;
use App\Models\CanteenPurchase;
use App\Models\CanteenPurchaseItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CanteenPurchaseController extends Controller
{
    // Daftar pembelian
    public function index()
    {
        $purchases = CanteenPurchase::with('supplier', 'canteen')->latest()->get();
        return view('canteen.purchases.index', compact('purchases'));
    }

    // Form tambah pembelian
    public function create()
    {
        $canteens = Canteen::all();
        $suppliers = CanteenSupplier::all();
        $products = CanteenProduct::all();
        return view('canteen.purchases.create', compact('canteens', 'suppliers', 'products'));
    }

    // Simpan pembelian baru
    public function store(Request $request)
    {
        $validated = $request->validate([
            'canteen_id' => 'required|exists:canteens,id',
            'supplier_id' => 'required|exists:canteen_suppliers,id',
            'note' => 'nullable|string',
            'status' => 'required|in:draft,approved,received',
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:canteen_products,id',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.unit_price' => 'required|numeric|min:0',
        ]);

        DB::beginTransaction();
        try {
            $purchase = CanteenPurchase::create([
                'canteen_id' => $validated['canteen_id'],
                'supplier_id' => $validated['supplier_id'],
                'note' => $validated['note'] ?? null,
                'status' => $validated['status'],
                'created_by' => auth()->id(),
                'total_price' => 0,
            ]);

            $total = 0;
            foreach ($validated['items'] as $item) {
                $subtotal = $item['quantity'] * $item['unit_price'];
                $total += $subtotal;

                CanteenPurchaseItem::create([
                    'canteen_purchase_id' => $purchase->id,
                    'canteen_product_id' => $item['product_id'],
                    'quantity' => $item['quantity'],
                    'unit_price' => $item['unit_price'],
                    'subtotal' => $subtotal,
                ]);

                if ($validated['status'] === 'received') {
                    $product = CanteenProduct::find($item['product_id']);
                    $product->stock += $item['quantity'];
                    $product->save();
                }
            }

            $purchase->update(['total_price' => $total]);

            DB::commit();
            return redirect()->route('canteen-purchases.index')->with('success', 'Pembelian berhasil disimpan.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Gagal menyimpan pembelian: ' . $e->getMessage()]);
        }
    }

    // Tampilkan detail pembelian
    public function show($id)
    {
        $purchase = CanteenPurchase::with('items.product', 'supplier', 'canteen')->findOrFail($id);
        return view('canteen.purchases.show', compact('purchase'));
    }

    // Hapus pembelian
    public function destroy($id)
    {
        $purchase = CanteenPurchase::findOrFail($id);
        $purchase->items()->delete();
        $purchase->delete();
        return redirect()->route('canteen-purchases.index')->with('success', 'Data pembelian berhasil dihapus.');
    }
}
