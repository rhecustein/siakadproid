<?php

namespace App\Http\Controllers\Canteen;

use App\Http\Controllers\Controller;
use App\Models\Canteen;
use App\Models\CanteenPurchaseRequest;
use Illuminate\Http\Request;

class CanteenPurchaseRequestController extends Controller
{
    public function index(Request $request)
    {
        $query = CanteenPurchaseRequest::with(['canteen', 'user']);

        if ($request->filled('search')) {
            $query->where('description', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $requests = $query->latest()->get();

        return view('canteen.requests.index', compact('requests'));
    }

    public function create()
    {
        $canteens = Canteen::all();
        return view('canteen.requests.create', compact('canteens'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'canteen_id'     => 'required|exists:canteens,id',
            'description'    => 'nullable|string',
            'requested_date' => 'required|date',
            'quantity'       => 'required|integer|min:1',
            'total_price'    => 'required|numeric|min:0',
        ]);

        $validated['requester_id'] = auth()->id();
        $validated['status'] = 'pending';

        CanteenPurchaseRequest::create($validated);

        return redirect()->route('canteen.purchase_requests.index')->with('success', 'Permintaan pembelian berhasil dikirim.');
    }

    public function edit($id)
    {
        $requestItem = CanteenPurchaseRequest::findOrFail($id);
        $canteens = Canteen::all();
        return view('canteen.requests.edit', compact('requestItem', 'canteens'));
    }

    public function update(Request $request, $id)
    {
        $requestItem = CanteenPurchaseRequest::findOrFail($id);

        $validated = $request->validate([
            'description'    => 'nullable|string',
            'status'         => 'required|in:pending,approved,rejected',
            'requested_date' => 'required|date',
            'quantity'       => 'required|integer|min:1',
            'total_price'    => 'required|numeric|min:0',
        ]);

        $requestItem->update($validated);

        return redirect()->route('canteen.purchase_requests.index')->with('success', 'Permintaan diperbarui.');
    }

    public function destroy($id)
    {
        $requestItem = CanteenPurchaseRequest::findOrFail($id);
        $requestItem->delete();

        return redirect()->route('canteen.purchase_requests.index')->with('success', 'Permintaan dihapus.');
    }

    public function show($id)
    {
        $requestItem = CanteenPurchaseRequest::with(['canteen', 'user'])->findOrFail($id);
        return view('canteen.requests.show', compact('requestItem'));
    }

    public function approve($id)
    {
        $requestItem = CanteenPurchaseRequest::findOrFail($id);

        if ($requestItem->status === 'pending') {
            $requestItem->update(['status' => 'approved']);
            return redirect()->route('canteen.purchase_requests.index')->with('success', 'Permintaan berhasil disetujui.');
        }

        return redirect()->route('canteen.purchase_requests.index')->with('error', 'Permintaan tidak valid atau sudah diproses.');
    }
}
