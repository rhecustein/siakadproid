<?php

namespace App\Http\Controllers\Finance;

use App\Http\Controllers\Controller;
use App\Models\BankAccount;
use Illuminate\Http\Request;

class BankAccountController extends Controller
{
    public function index()
    {
        $accounts = BankAccount::orderBy('bank_name')->paginate(10);
        return view('admin.masters.bank_accounts.index', compact('accounts'));
    }

    public function create()
    {
        return view('admin.masters.bank_accounts.create');
    }

    //edit
   public function edit(BankAccount $bankAccount)
    {
        return view('admin.masters.bank_accounts.edit', [
            'account' => $bankAccount,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'account_number' => 'required|unique:bank_accounts',
            'account_holder' => 'required|string|max:100',
            'bank_name' => 'required|string|max:100',
            'bank_code' => 'nullable|string|max:20',
            'school' => 'nullable|string|max:100',
            'online_payment' => 'boolean',
            'for_students' => 'boolean',
            'for_teachers' => 'boolean',
            'for_male' => 'boolean',
            'for_female' => 'boolean',
            'can_pay_bills' => 'boolean',
            'can_save' => 'boolean',
            'can_donate' => 'boolean',
            'is_active' => 'boolean',
        ]);

        BankAccount::create($request->all());

        return redirect()->route('finance.bank-accounts.index')->with('success', 'Bank account created.');
    }
}


