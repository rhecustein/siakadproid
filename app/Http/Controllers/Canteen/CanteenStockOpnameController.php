<?php

namespace App\Http\Controllers\Canteen;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CanteenStockOpname;
use App\Models\CanteenProduct;
use Illuminate\Support\Facades\Auth;

class CanteenStockOpnameController extends Controller
{
    public function index(Request $request)
    {
        $opnames = CanteenStockOpname::with(['product', 'creator'])
            ->when($request->date, fn($q) => $q->whereDate('opname_date', $request->date))
            ->when($request->q, fn($q) => $q->whereHas('product', fn($p) =>
                $p->where('name', 'like', '%' . $request->q . '%')))
            ->latest()
            ->paginate(10);

        return view('canteen.stock_opname.index', compact('opnames'));
    }


    public function create()
    {
        $products = CanteenProduct::orderBy('name')->get();
        return view('canteen.stock_opname.create', compact('products'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'opname_date' => 'required|date',
            'system_stock' => 'required|integer|min:0',
            'real_stock' => 'required|integer|min:0',
            'note' => 'nullable|string|max:255',
        ]);

        $difference = $request->real_stock - $request->system_stock;

        CanteenStockOpname::create([
            'product_id'   => $request->product_id,
            'opname_date'  => $request->opname_date,
            'system_stock' => $request->system_stock,
            'real_stock'   => $request->real_stock,
            'difference'   => $difference,
            'note'         => $request->note,
            'created_by'   => Auth::id()
        ]);

        return redirect()->route('canteen.stock-opname.index')->with('success', 'Stok opname berhasil disimpan.');
    }

    public function show($id)
    {
        $opname = CanteenStockOpname::with(['product', 'creator'])->findOrFail($id);
        return view('canteen.stock_opname.show', compact('opname'));
    }

    public function destroy($id)
    {
        $opname = CanteenStockOpname::findOrFail($id);
        $opname->delete();

        return redirect()->route('canteen.stock-opname.index')->with('success', 'Data stok opname dihapus.');
    }
}
