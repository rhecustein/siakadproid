<?php

namespace App\Http\Controllers\Admission;

use App\Http\Controllers\Controller;
use App\Models\AdmissionPayment;
use Illuminate\Http\Request;

class AdmissionPaymentController extends Controller
{
    // Show all admission payments
    public function index()
    {
        $payments = AdmissionPayment::with('admission')->latest()->get();
        return view('admissions.admission_payments.index', compact('payments'));
    }
}
