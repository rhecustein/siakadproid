<?php

namespace App\Http\Controllers\Canteen;

use App\Http\Controllers\Controller;
use App\Models\CanteenPurchase;
use App\Models\CanteenPurchaseItem;
use App\Models\CanteenProduct;
use Illuminate\Http\Request;

class CanteenPurchaseItemController extends Controller
{
    // Edit item pembelian
    public function edit($id)
    {
        $item = CanteenPurchaseItem::with('product', 'purchase')->findOrFail($id);
        $products = CanteenProduct::all();
        return view('canteen.purchase_items.edit', compact('item', 'products'));
    }

    // Update item pembelian
    public function update(Request $request, $id)
    {
        $item = CanteenPurchaseItem::findOrFail($id);

        $validated = $request->validate([
            'canteen_product_id' => 'required|exists:canteen_products,id',
            'quantity' => 'required|integer|min:1',
            'unit_price' => 'required|numeric|min:0',
        ]);

        $subtotal = $validated['quantity'] * $validated['unit_price'];
        $validated['subtotal'] = $subtotal;

        $item->update($validated);

        // Perbarui total harga pembelian
        $purchase = $item->purchase;
        $purchase->total_price = $purchase->items()->sum('subtotal');
        $purchase->save();

        return redirect()->route('canteen-purchases.show', $purchase->id)->with('success', 'Item pembelian berhasil diperbarui.');
    }

    // Hapus item pembelian
    public function destroy($id)
    {
        $item = CanteenPurchaseItem::findOrFail($id);
        $purchaseId = $item->canteen_purchase_id;
        $item->delete();

        // Update total harga setelah hapus
        $purchase = CanteenPurchase::findOrFail($purchaseId);
        $purchase->total_price = $purchase->items()->sum('subtotal');
        $purchase->save();

        return redirect()->route('canteen-purchases.show', $purchaseId)->with('success', 'Item pembelian berhasil dihapus.');
    }
}
