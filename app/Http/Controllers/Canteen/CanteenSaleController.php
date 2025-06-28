<?php

namespace App\Http\Controllers\Canteen;

use App\Http\Controllers\Controller;
use App\Models\Canteen;
use App\Models\CanteenProduct;
use App\Models\CanteenSale;
use App\Models\CanteenSaleItem;
use App\Models\Wallet;
use App\Models\WalletTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CanteenSaleController extends Controller
{
    // Daftar transaksi penjualan
    public function index()
    {
        $sales = CanteenSale::with('items.product')->latest()->get();
        return view('canteen.sales.index', compact('sales'));
    }

    // Form transaksi POS
    public function create()
    {
        $canteens = Canteen::all();
        $products = CanteenProduct::where('is_active', true)->get();
        return view('canteen.sales.create', compact('canteens', 'products'));
    }

    // Simpan transaksi penjualan
    public function store(Request $request)
    {
        $validated = $request->validate([
            'canteen_id' => 'required|exists:canteens,id',
            'buyer_type' => 'required|in:student,parent,guest',
            'buyer_id' => 'nullable|integer',
            'payment_method' => 'required|in:wallet,cash',
            'auth_method' => 'required|in:rfid,fingerprint,manual',
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:canteen_products,id',
            'items.*.quantity' => 'required|integer|min:1',
        ]);

        DB::beginTransaction();
        try {
            $total = 0;
            foreach ($validated['items'] as $item) {
                $product = CanteenProduct::find($item['product_id']);
                $total += $item['quantity'] * $product->price;
            }

            if ($validated['payment_method'] === 'wallet') {
                $wallet = Wallet::where('user_id', $validated['buyer_id'])->firstOrFail();
                if ($wallet->balance < $total) {
                    return back()->withErrors(['saldo' => 'Saldo tidak cukup']);
                }
                $wallet->balance -= $total;
                $wallet->save();

                WalletTransaction::create([
                    'wallet_id' => $wallet->id,
                    'amount' => -$total,
                    'description' => 'Pembelian di kantin',
                ]);
            }

            $sale = CanteenSale::create([
                'canteen_id' => $validated['canteen_id'],
                'buyer_type' => $validated['buyer_type'],
                'buyer_id' => $validated['buyer_id'],
                'payment_method' => $validated['payment_method'],
                'auth_method' => $validated['auth_method'],
                'total_amount' => $total,
                'paid' => true,
                'cashier_id' => auth()->id(),
                'transaction_time' => now(),
            ]);

            foreach ($validated['items'] as $item) {
                $product = CanteenProduct::find($item['product_id']);
                $quantity = $item['quantity'];
                $subtotal = $quantity * $product->price;

                CanteenSaleItem::create([
                    'canteen_sale_id' => $sale->id,
                    'canteen_product_id' => $product->id,
                    'quantity' => $quantity,
                    'price' => $product->price,
                    'subtotal' => $subtotal,
                ]);

                $product->stock -= $quantity;
                $product->save();
            }

            DB::commit();
            return redirect()->route('canteen-sales.index')->with('success', 'Transaksi berhasil disimpan.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Transaksi gagal: ' . $e->getMessage()]);
        }
    }

    // Detail transaksi
    public function show($id)
    {
        $sale = CanteenSale::with('items.product')->findOrFail($id);
        return view('canteen.sales.show', compact('sale'));
    }

    // Hapus transaksi
    public function destroy($id)
    {
        $sale = CanteenSale::findOrFail($id);
        $sale->items()->delete();
        $sale->delete();
        return redirect()->route('canteen-sales.index')->with('success', 'Transaksi berhasil dihapus.');
    }
}
