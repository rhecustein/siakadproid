<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BillGroup extends Model
{
    protected $fillable = [
        'type',
        'name',
        'level_id',
        'school_id',
        'academic_year',
        'gender',
        'tagihan_count',
        'amount_per_tagihan',
        'start_date',
        'end_date',
        'description',
    ];

    // Relasi ke Level (Kelas)
    public function level()
    {
        return $this->belongsTo(Level::class);
    }

    // Relasi ke School (Sekolah)
    public function school()
    {
        return $this->belongsTo(School::class);
    }

    // Daftar tipe tagihan yang diizinkan
    public const TYPES = [
        'spp' => 'SPP Sekolah',
        'pondokan' => 'Biaya Pondokan',
        'makan' => 'Konsumsi Harian',
        'asrama' => 'Asrama / Penginapan',
        'infaq_rutin' => 'Infaq Rutin',
        'laundry' => 'Laundry Santri',
        'daftar_ulang' => 'Daftar Ulang Tahunan',
        'ujian' => 'Ujian Tengah/Akhir',
        'ekskul' => 'Ekstrakurikuler',
        'study_tour' => 'Study Tour',
        'pakaian' => 'Seragam / Jas',
        'buku' => 'Buku / Kitab',
        'kegiatan' => 'Kegiatan Lainnya',
        'tahfidz' => 'Program Tahfidz',
        'pembangunan' => 'Donasi Pembangunan',
        'kesehatan' => 'Kesehatan / Klinik',
        'perpustakaan' => 'Perpustakaan',
        'akomodasi' => 'Akomodasi Santri',
        'infaq_sukarela' => 'Infaq Sukarela',
        'lainnya' => 'Lainnya',
    ];
    public function type()
    {
        return $this->belongsTo(\App\Models\BillType::class, 'bill_type_id');
    }

}
