<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WargaTerpilih extends Model
{
    use HasFactory;
    protected $table = 'warga_terpilih';

    protected $fillable = [
        'alternatif_id',
        'ranking',
        'total_nilai',
    ];

    public function alternatif()
    {
        return $this->belongsTo(Alternatif::class);
    }
}
