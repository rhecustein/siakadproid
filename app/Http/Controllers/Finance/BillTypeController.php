<?php

namespace App\Http\Controllers\Finance;

use App\Http\Controllers\Controller;
use App\Models\BillType;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BillTypeController extends Controller
{
    public function index(Request $request)
    {
        $query = BillType::query();

        if ($search = $request->get('search')) {
            $query->where('name', 'like', "%{$search}%")
                  ->orWhere('code', 'like', "%{$search}%");
        }

        $billTypes = $query->orderBy('name')->paginate(10)->withQueryString();

        return view('admin.masters.bill-types.index', compact('billTypes'));
    }

    public function create()
    {
        return view('admin.masters.bill-types.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'        => 'required|string|max:100|unique:bill_types',
            'code'        => 'required|string|max:50|unique:bill_types',
            'description' => 'nullable|string',
            'is_active'   => 'nullable|boolean',
        ]);

        $validated['uuid'] = Str::uuid();
        $validated['is_active'] = $request->has('is_active');

        BillType::create($validated);

        return redirect()
            ->route('finance.bill-types.index')
            ->with('success', 'Jenis tagihan berhasil ditambahkan.');
    }

    public function edit(BillType $billType)
    {
        return view('admin.masters.bill-types.edit', compact('billType'));
    }

    public function update(Request $request, BillType $billType)
    {
        $validated = $request->validate([
        'name'        => 'required|string|max:100|unique:bill_types,name,' . $billType->id,
        'code'        => 'required|string|max:50|unique:bill_types,code,' . $billType->id,
        'description' => 'nullable|string',
        ]);

        $validated['is_active'] = $request->has('is_active') ? 1 : 0;

        $billType->update($validated);

        return redirect()
            ->route('finance.bill-types.index')
            ->with('success', 'Jenis tagihan berhasil diperbarui.');
    }

    public function destroy(BillType $billType)
    {
        $billType->delete();

        return redirect()
            ->route('finance.bill-types.index')
            ->with('success', 'Jenis tagihan berhasil dihapus.');
    }
}
