<?php

namespace App\Http\Controllers\Finance;

use App\Http\Controllers\Controller;
use App\Models\BillType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
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

        // Tambahkan filter jika diperlukan di tampilan Anda
        // Misalnya:
        // ->when($request->status, fn ($q) => $q->where('is_active', $request->status === 'active'))

        $billTypes = $query->orderBy('name')->paginate(10)->withQueryString();

        // Menghitung data untuk count cards
        $totalBillTypes = BillType::count();
        $activeBillTypes = BillType::where('is_active', true)->count();
        // Asumsi ada kolom is_online_payment dan is_monthly di tabel bill_types
        $onlinePaymentBillTypes = BillType::where('is_online_payment', true)->count();
        $monthlyBillTypes = BillType::where('is_monthly', true)->count();

        return view('admin.masters.bill-types.index', compact('billTypes', 'totalBillTypes', 'activeBillTypes', 'onlinePaymentBillTypes', 'monthlyBillTypes'));
    }

    public function create()
    {
        return view('admin.masters.bill-types.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name'              => 'required|string|max:100|unique:bill_types,name',
            'code'              => 'required|string|max:50|unique:bill_types,code',
            'description'       => 'nullable|string',
            'is_online_payment' => 'boolean', // Asumsi ini ada dari form
            'is_monthly'        => 'boolean', // Asumsi ini ada dari form
            'is_active'         => 'boolean', // is_active harus ada di form
        ]);

        // Karena checkbox tidak terkirim jika tidak dicentang, atur nilai default
        $validatedData['is_online_payment'] = $request->has('is_online_payment');
        $validatedData['is_monthly']        = $request->has('is_monthly');
        $validatedData['is_active']         = $request->has('is_active');

        $validatedData['uuid'] = Str::uuid();

        BillType::create($validatedData);

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
        $validatedData = $request->validate([
            'name'              => ['required', 'string', 'max:100', Rule::unique('bill_types', 'name')->ignore($billType->id)],
            'code'              => ['required', 'string', 'max:50', Rule::unique('bill_types', 'code')->ignore($billType->id)],
            'description'       => 'nullable|string',
            'is_online_payment' => 'boolean',
            'is_monthly'        => 'boolean',
            'is_active'         => 'boolean',
        ]);

        // Atur nilai boolean dari checkbox karena tidak terkirim jika tidak dicentang
        $validatedData['is_online_payment'] = $request->has('is_online_payment');
        $validatedData['is_monthly']        = $request->has('is_monthly');
        $validatedData['is_active']         = $request->has('is_active');

        $billType->update($validatedData);

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