<?php

namespace App\Http\Controllers\Canteen;

use App\Http\Controllers\Controller;
use App\Models\Canteen;
use App\Models\CanteenProduct;
use App\Models\CanteenProductCategory;
use Illuminate\Http\Request;

class CanteenProductController extends Controller
{
    public function index(Request $request)
    {
        $query = CanteenProduct::with(['category']);

        if ($request->filled('category')) {
            $query->whereHas('category', function ($q) use ($request) {
                $q->where('id', $request->category);
            });
        }

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('sku', 'like', '%' . $request->search . '%')
                  ->orWhere('barcode', 'like', '%' . $request->search . '%');
            });
        }

        $products = $query->orderBy('name')->get();
        $allCategories = CanteenProductCategory::pluck('name', 'id');
        $total = $query->count();

        return view('canteen.products.index', compact('products', 'total', 'allCategories'));
    }

    public function create()
    {
        $canteens = Canteen::pluck('name', 'id');
        $categories = CanteenProductCategory::pluck('name', 'id');
        return view('canteen.products.create', compact('canteens', 'categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'canteen_id'      => 'required|exists:canteens,id',
            'category_id'     => 'required|exists:canteen_product_categories,id',
            'name'            => 'required|string|max:255',
            'sku'             => 'required|string|max:100|unique:canteen_products,sku',
            'barcode'         => 'nullable|string|max:100|unique:canteen_products,barcode',
            'price'           => 'required|numeric|min:0',
            'stock'           => 'required|integer|min:0',
            'reorder_point'   => 'nullable|integer|min:0',
            'unit'            => 'required|string|max:50',
            'description'     => 'nullable|string',
            'is_active'       => 'boolean',
        ]);

        $validated['is_active'] = $request->has('is_active');

        CanteenProduct::create($validated);
        return redirect()->route('canteen.products.index')->with('success', 'Produk berhasil ditambahkan.');
    }

    public function edit(CanteenProduct $product)
    {
        $canteens = Canteen::pluck('name', 'id');
        $categories = CanteenProductCategory::pluck('name', 'id');
        return view('canteen.products.edit', compact('product', 'canteens', 'categories'));
    }

    public function update(Request $request, CanteenProduct $product)
    {
        $validated = $request->validate([
            'canteen_id'      => 'required|exists:canteens,id',
            'category_id'     => 'required|exists:canteen_product_categories,id',
            'name'            => 'required|string|max:255',
            'sku'             => 'required|string|max:100|unique:canteen_products,sku,' . $product->id,
            'barcode'         => 'nullable|string|max:100|unique:canteen_products,barcode,' . $product->id,
            'price'           => 'required|numeric|min:0',
            'stock'           => 'required|integer|min:0',
            'reorder_point'   => 'nullable|integer|min:0',
            'unit'            => 'required|string|max:50',
            'description'     => 'nullable|string',
            'is_active'       => 'boolean',
        ]);

        $validated['is_active'] = $request->has('is_active');

        $product->update($validated);
        return redirect()->route('canteen.products.index')->with('success', 'Produk berhasil diperbarui.');
    }

    public function destroy(CanteenProduct $product)
    {
        $product->delete();
        return redirect()->route('canteen.products.index')->with('success', 'Produk berhasil dihapus.');
    }
}
