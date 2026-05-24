<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CompressStat extends Model
{
    protected $fillable = [
        'original_size',
        'compressed_size',
        'total_files',
        'compression_ratio'
    ];
}