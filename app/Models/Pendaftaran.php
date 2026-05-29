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

        /**
         * FILE
         */
        'pas_foto',
        'kk',
        'ijazah',
        'skl',
        'kip',

        /**
         * FILE SIZE
         */
        'pas_foto_original_size',
        'pas_foto_compressed_size',

        'kk_original_size',
        'kk_compressed_size',

        'ijazah_original_size',
        'ijazah_compressed_size',

        'skl_original_size',
        'skl_compressed_size',

        'kip_original_size',
        'kip_compressed_size',

        /**
         * OTHER
         */
        'mitra_pendaftaran',
        'status',
    ];

    protected $casts = [
        'tanggal_lahir' => 'date',
    ];

    public function getPasFotoUrlAttribute()
    {
        return $this->pas_foto ? asset('storage/' . $this->pas_foto) : null;
    }
}