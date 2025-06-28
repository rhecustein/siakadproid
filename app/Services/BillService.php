<?php

namespace App\Services;

use App\Models\Bill;
use App\Models\BillGroup;
use App\Models\BillItem;
use App\Models\Student;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class BillService
{
    /**
     * Generate tagihan untuk banyak siswa dari 1 grup
     *
     * @param BillGroup $group
     * @param \Illuminate\Support\Collection|array $students
     * @param array $options = ['bill_type_id' => null]
     * @return int Jumlah tagihan yang berhasil dibuat
     */
    public static function generateForStudents(BillGroup $group, $students, array $options = [])
    {
        DB::beginTransaction();

        try {
            $generated = 0;
            $startDate = $group->start_date
                ? Carbon::parse($group->start_date)->startOfMonth()
                : now()->startOfMonth();

            foreach ($students as $student) {
                $exists = Bill::where('student_id', $student->id)
                    ->where('bill_group_id', $group->id)
                    ->exists();

                if ($exists) continue;

                $total = ($group->tagihan_count ?? 1) * ($group->amount_per_tagihan ?? 0);

                $bill = Bill::create([
                    'student_id'     => $student->id,
                    'bill_group_id'  => $group->id,
                    'bill_type_id'   => $options['bill_type_id'] ?? $group->bill_type_id,
                    'title'          => $group->name ?? 'Tagihan',
                    'total_amount'   => $total,
                    'status'         => 'unpaid',
                    'start_date'     => $startDate->copy(),
                    'due_date'       => $startDate->copy(),
                ]);

                if ($group->tagihan_count && $group->amount_per_tagihan) {
                    for ($i = 0; $i < $group->tagihan_count; $i++) {
                        BillItem::create([
                            'bill_id'   => $bill->id,
                            'name'      => "Tagihan Bulan ke-" . ($i + 1),
                            'label'     => "Tagihan Bulan ke-" . ($i + 1),
                            'amount'    => $group->amount_per_tagihan,
                            'status'    => 'unpaid',
                            'due_date'  => $startDate->copy()->addMonths($i)->startOfMonth(),
                        ]);
                    }
                } else {
                    BillItem::create([
                        'bill_id'   => $bill->id,
                        'name'      => $group->name ?? 'Tagihan',
                        'label'     => $group->name ?? 'Tagihan',
                        'amount'    => $group->amount_per_tagihan ?? 0,
                        'status'    => 'unpaid',
                        'due_date'  => $startDate->copy(),
                    ]);
                }

                $generated++;
            }

            DB::commit();
            return $generated;

        } catch (\Throwable $e) {
            DB::rollBack();
            throw $e;
        }
    }
}
