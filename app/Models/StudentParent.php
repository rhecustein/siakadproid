<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;

class StudentParent extends Model
{
    use HasFactory;
    // use SoftDeletes; // Uncomment this line if you use SoftDeletes on StudentParent model

    // --- PENTING: Gunakan 'parents' sebagai nama tabel seperti yang Anda minta ---
    protected $table = 'parents';

    protected $fillable = [
        'uuid',
        'user_id',
        'name',
        'gender',
        'relationship',
        'phone',
        'email',
        'address',
        'is_active',
        // Tambahkan 'nik' jika Anda memilikinya di tabel 'parents'
        'nik', // Jika ada kolom NIK di tabel parents
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    // Trait untuk bootable methods jika diperlukan (UUID generation)
    protected static function booted()
    {
        static::creating(function ($parent) {
            if (empty($parent->uuid)) { // Menggunakan empty() lebih fleksibel
                $parent->uuid = (string) Str::uuid();
            }
        });
    }

    // Relasi ke akun pengguna (User)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi ke Wallet (dompet kantin)
    // Asumsi: Wallet terhubung ke 'owner_id' dan 'owner_type' (polimorfik)
    // Jika tidak polimorfik dan terhubung langsung ke user_id:
    // public function wallet() { return $this->hasOne(Wallet::class, 'user_id', 'user_id'); }
    // Jika tidak polimorfik dan terhubung langsung ke parent_id:
    // public function wallet() { return $this->hasOne(Wallet::class, 'parent_id', 'id'); }
    public function wallet()
    {
        return $this->morphOne(Wallet::class, 'owner');
    }

    /**
     * Relasi ke siswa-siswa yang terkait dengan orang tua ini.
     * Menggunakan foreign key 'parent_id' di tabel 'students'.
     */
    public function children()
    {
        return $this->hasMany(Student::class, 'parent_id', 'id');
    }

    // Catatan: Jika ada relasi 'students()' dan 'children()' yang keduanya hasMany ke Student,
    // pilih salah satu atau bedakan tujuannya. Saya akan menyarankan menggunakan 'children()' saja
    // untuk konsistensi dengan Blade Anda.
    // Jika 'students()' sebelumnya adalah relasi utama:
    // public function students() { return $this->hasMany(Student::class, 'parent_id'); }
}