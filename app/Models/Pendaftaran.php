<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pendaftaran extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_lengkap',
        'nisn',
        'tempat_lahir',
        'tanggal_lahir',
        'asal_sekolah',
        'jenis_kelamin',
        'nomor_hp',
        'email',
        'kompetensi_keahlian',
        'alamat_lengkap',
        'pas_foto',
        'mitra_pendaftaran',
        'status',
        'kk',
        'ijazah',
        'skl',
        'kip',
    ];

    protected $casts = [
        'tanggal_lahir' => 'date',
    ];

    public function getPasFotoUrlAttribute()
    {
        return $this->pas_foto ? asset('storage/' . $this->pas_foto) : null;
    }
}