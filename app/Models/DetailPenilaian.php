<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailPenilaian extends Model
{
    use HasFactory;

    protected $table = 'detail_penilaian';
    protected $fillable = ['penilaian_id', 'kriteria_id', 'crips_id'];

    public function penilaian()
    {
        return $this->belongsTo(Penilaian::class);
    }

    public function kriteria()
    {
        return $this->belongsTo(Kriteria::class);
    }

    public function crips()
    {
        return $this->belongsTo(Crips::class);
    }
}
