<?php

namespace App\Http\Controllers\Finance;

use App\Http\Controllers\Controller;
use App\Models\JournalEntry;
use App\Models\JournalEntryLine;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class JournalEntryController extends Controller
{
    /**
     * Tampilkan daftar jurnal.
     */
    public function index(Request $request)
    {
        $journals = JournalEntry::with('lines')
            ->when($request->date, fn($q) => $q->where('date', $request->date))
            ->orderByDesc('date')
            ->paginate(20);

        return view('finance.journal_entries.index', compact('journals'));
    }

    /**
     * Tampilkan form buat jurnal baru.
     */
    public function create()
    {
        return view('finance.journal_entries.create');
    }

    /**
     * Simpan jurnal ke database.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'date' => ['required', 'date'],
            'description' => ['required', 'string'],
            'lines' => ['required', 'array', 'min:2'],
            'lines.*.account_code' => ['required', 'string', 'max:20'],
            'lines.*.account_name' => ['required', 'string'],
            'lines.*.debit' => ['nullable', 'numeric'],
            'lines.*.credit' => ['nullable', 'numeric'],
            'lines.*.note' => ['nullable', 'string'],
        ]);

        $totalDebit = collect($data['lines'])->sum('debit');
        $totalCredit = collect($data['lines'])->sum('credit');

        if (round($totalDebit, 2) !== round($totalCredit, 2)) {
            return back()->withErrors(['lines' => 'Jumlah debit dan kredit harus seimbang.'])->withInput();
        }

        DB::transaction(function () use ($data) {
            $journal = JournalEntry::create([
                'date' => $data['date'],
                'description' => $data['description'],
                'created_by' => auth()->id(),
            ]);

            foreach ($data['lines'] as $line) {
                $journal->lines()->create([
                    'account_code' => $line['account_code'],
                    'account_name' => $line['account_name'],
                    'debit' => $line['debit'] ?? 0,
                    'credit' => $line['credit'] ?? 0,
                    'note' => $line['note'] ?? null,
                ]);
            }
        });

        return redirect()->route('journal-entries.index')->with('success', 'Jurnal berhasil disimpan.');
    }

    /**
     * Tampilkan detail jurnal.
     */
    public function show(JournalEntry $journalEntry)
    {
        $journalEntry->load('lines');
        return view('finance.journal_entries.show', compact('journalEntry'));
    }

    // Tidak mendukung edit/hapus untuk menjaga integritas audit
    public function edit(JournalEntry $journalEntry) { abort(403); }
    public function update(Request $request, JournalEntry $journalEntry) { abort(403); }
    public function destroy(JournalEntry $journalEntry) { abort(403); }
}
