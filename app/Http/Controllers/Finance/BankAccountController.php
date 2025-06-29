<?php

namespace App\Http\Controllers\Finance;

use App\Http\Controllers\Controller;
use App\Models\BankAccount;
use App\Models\School;
use Illuminate\Http\Request;

class BankAccountController extends Controller
{
    public function index()
    {
        // Eager load relasi 'school' jika ada dan digunakan di tampilan
        $accounts = BankAccount::with('school')->orderBy('bank_name')->paginate(10);

        // Menghitung data untuk count cards
        $totalAccounts = BankAccount::count();
        $activeAccounts = BankAccount::where('is_active', true)->count();
        $onlinePaymentAccounts = BankAccount::where('online_payment', true)->count();
        $donationAccounts = BankAccount::where('can_donate', true)->count();

        // Melewatkan semua variabel yang diperlukan ke view
        return view('admin.masters.bank_accounts.index', compact('accounts', 'totalAccounts', 'activeAccounts', 'onlinePaymentAccounts', 'donationAccounts'));
    }

    public function create()
    {
        $schools = School::all(); // Ambil semua sekolah untuk dropdown
        return view('admin.masters.bank_accounts.create', compact('schools'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'account_number' => 'required|string|max:50|unique:bank_accounts,account_number',
            'account_holder' => 'required|string|max:100',
            'bank_name' => 'required|string|max:100',
            'bank_code' => 'nullable|string|max:20',
            'school_id' => 'nullable|exists:schools,id', // Gunakan school_id jika ada relasi
            'online_payment' => 'boolean',
            'can_pay_bills' => 'boolean', // can_pay_bills, can_save, can_donate sesuai Blade
            'can_save' => 'boolean',
            'can_donate' => 'boolean',
            'is_active' => 'boolean',
            // 'for_students', 'for_teachers', 'for_male', 'for_female' -- tidak ada di Blade yang baru
            // Jika kolom ini ada di database dan diperlukan, tambahkan ke fillable model BankAccount
            // dan validasi di sini jika datanya akan dikirim dari form
        ]);

        // Berikan nilai default untuk boolean jika tidak ada di request
        $validatedData['online_payment'] = $validatedData['online_payment'] ?? false;
        $validatedData['can_pay_bills'] = $validatedData['can_pay_bills'] ?? false;
        $validatedData['can_save'] = $validatedData['can_save'] ?? false;
        $validatedData['can_donate'] = $validatedData['can_donate'] ?? false;
        $validatedData['is_active'] = $validatedData['is_active'] ?? false; // Default false jika tidak dicentang

        BankAccount::create($validatedData); // Menggunakan $validatedData

        return redirect()->route('finance.bank-accounts.index')->with('success', 'Rekening bank berhasil ditambahkan.');
    }

    public function edit(BankAccount $bankAccount) // Menggunakan Route Model Binding
    {
        $schools = School::all(); // Ambil semua sekolah untuk dropdown
        return view('admin.masters.bank_accounts.edit', [
            'account' => $bankAccount,
            'schools' => $schools,
        ]);
    }

    public function update(Request $request, BankAccount $bankAccount) // Menggunakan Route Model Binding
    {
        $validatedData = $request->validate([
            'account_number' => ['required', 'string', 'max:50', Rule::unique('bank_accounts', 'account_number')->ignore($bankAccount->id)],
            'account_holder' => 'required|string|max:100',
            'bank_name' => 'required|string|max:100',
            'bank_code' => 'nullable|string|max:20',
            'school_id' => 'nullable|exists:schools,id',
            'online_payment' => 'boolean',
            'can_pay_bills' => 'boolean',
            'can_save' => 'boolean',
            'can_donate' => 'boolean',
            'is_active' => 'boolean',
        ]);

        // Berikan nilai default untuk boolean jika tidak ada di request (checkbox tidak terkirim jika tidak dicentang)
        $validatedData['online_payment'] = $request->has('online_payment');
        $validatedData['can_pay_bills'] = $request->has('can_pay_bills');
        $validatedData['can_save'] = $request->has('can_save');
        $validatedData['can_donate'] = $request->has('can_donate');
        $validatedData['is_active'] = $request->has('is_active');


        $bankAccount->update($validatedData);

        return redirect()->route('finance.bank-accounts.index')->with('success', 'Rekening bank berhasil diperbarui.');
    }

    public function destroy(BankAccount $bankAccount) // Menggunakan Route Model Binding
    {
        try {
            $bankAccount->delete();
            return redirect()->route('finance.bank-accounts.index')->with('success', 'Rekening bank berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->route('finance.bank-accounts.index')->with('error', 'Gagal menghapus rekening bank: ' . $e->getMessage());
        }
    }
}