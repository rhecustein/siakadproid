<?php

namespace App\Http\Controllers\Canteen;

use App\Http\Controllers\Controller;
use App\Models\CanteenSaleItem;
use App\Models\CanteenProduct;
use App\Models\CanteenSale;
use Illuminate\Http\Request;

class CanteenSaleItemController extends Controller
{
    // Edit item penjualan
    public function edit($id)
    {
        $item = CanteenSaleItem::with('product', 'sale')->findOrFail($id);
        $products = CanteenProduct::all();
        return view('canteen.sale_items.edit', compact('item', 'products'));
    }

    // Update item penjualan
    public function update(Request $request, $id)
    {
        $item = CanteenSaleItem::findOrFail($id);
        $sale = $item->sale;

        $validated = $request->validate([
            'canteen_product_id' => 'required|exists:canteen_products,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $product = CanteenProduct::findOrFail($validated['canteen_product_id']);
        $subtotal = $validated['quantity'] * $product->price;

        $item->update([
            'canteen_product_id' => $product->id,
            'quantity' => $validated['quantity'],
            'price' => $product->price,
            'subtotal' => $subtotal,
        ]);

        $sale->total_amount = $sale->items()->sum('subtotal');
        $sale->save();

        return redirect()->route('canteen-sales.show', $sale->id)->with('success', 'Item penjualan diperbarui.');
    }

    // Hapus item penjualan
    public function destroy($id)
    {
        $item = CanteenSaleItem::findOrFail($id);
        $saleId = $item->canteen_sale_id;
        $item->delete();

        $sale = CanteenSale::findOrFail($saleId);
        $sale->total_amount = $sale->items()->sum('subtotal');
        $sale->save();

        return redirect()->route('canteen-sales.show', $saleId)->with('success', 'Item penjualan dihapus.');
    }
}
