<?php

namespace App\Http\Controllers\Canteen;

use App\Http\Controllers\Controller;
use App\Models\CanteenProductCategory;
use Illuminate\Http\Request;

class CanteenProductCategoryController extends Controller
{
    public function index()
    {
        $categories = CanteenProductCategory::orderBy('name')->get();
        return view('canteen.categories.index', compact('categories'));
    }

    public function create()
    {
        return view('canteen.categories.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100|unique:canteen_product_categories,name',
            'description' => 'nullable|string|max:255',
        ]);

        CanteenProductCategory::create([
            'name' => $request->name,
            'description' => $request->description,
        ]);

        return redirect()->route('canteen.product_categories.index')
                         ->with('success', 'Kategori berhasil ditambahkan.');
    }

    public function show(CanteenProductCategory $canteenProductCategory)
    {
        return view('canteen.categories.show', compact('canteenProductCategory'));
    }

    public function edit(CanteenProductCategory $canteenProductCategory)
    {
        return view('canteen.categories.edit', compact('canteenProductCategory'));
    }

    public function update(Request $request, CanteenProductCategory $canteenProductCategory)
    {
        $request->validate([
            'name' => 'required|string|max:100|unique:canteen_product_categories,name,' . $canteenProductCategory->id,
            'description' => 'nullable|string|max:255',
        ]);

        $canteenProductCategory->update([
            'name' => $request->name,
            'description' => $request->description,
        ]);

        return redirect()->route('canteen.product_categories.index')
                         ->with('success', 'Kategori berhasil diperbarui.');
    }

    public function destroy(CanteenProductCategory $canteenProductCategory)
    {
        $canteenProductCategory->delete();

        return redirect()->route('canteen.product_categories.index')
                         ->with('success', 'Kategori berhasil dihapus.');
    }
}
