<?php

namespace App\Http\Controllers\Canteen;

use App\Http\Controllers\Controller;
use App\Models\CanteenProduct;
use App\Models\CanteenProductStock;
use Illuminate\Http\Request;

class CanteenProductStockController extends Controller
{
    // Tampilkan daftar riwayat stok produk
    public function index()
    {
        $stocks = CanteenProductStock::with('product')->latest()->get();
        return view('canteen.stocks.index', compact('stocks'));
    }

    // Form penyesuaian stok
    public function create()
    {
        $products = CanteenProduct::all();
        return view('canteen.stocks.create', compact('products'));
    }

    // Simpan penyesuaian stok
    public function store(Request $request)
    {
        $validated = $request->validate([
            'canteen_product_id' => 'required|exists:canteen_products,id',
            'stock_in' => 'nullable|integer|min:0',
            'stock_out' => 'nullable|integer|min:0',
            'stock_type' => 'required|in:initial,purchase,sale,adjustment',
            'reference_type' => 'nullable|string',
            'reference_id' => 'nullable|integer',
            'note' => 'nullable|string',
        ]);

        $validated['created_by'] = auth()->id();

        $stock = CanteenProductStock::create($validated);

        // Update stok pada produk terkait
        $product = $stock->product;
        $product->stock += $validated['stock_in'] ?? 0;
        $product->stock -= $validated['stock_out'] ?? 0;
        $product->save();

        return redirect()->route('canteen-product-stocks.index')->with('success', 'Penyesuaian stok berhasil disimpan.');
    }

    // Tidak diperlukan edit/update untuk histori stok karena sifatnya pencatatan transaksi

    // Hapus entri penyesuaian stok
    public function destroy($id)
    {
        $stock = CanteenProductStock::findOrFail($id);
        $product = $stock->product;

        // Kembalikan stok seperti semula
        $product->stock -= $stock->stock_in;
        $product->stock += $stock->stock_out;
        $product->save();

        $stock->delete();

        return redirect()->route('canteen-product-stocks.index')->with('success', 'Riwayat stok berhasil dihapus.');
    }
}
