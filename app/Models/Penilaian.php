<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penilaian extends Model
{
    use HasFactory;
    protected $table = 'penilaian';
    protected $fillable = ['user_id', 'alternatif_id', 'total_nilai', 'nik'];

    public function detailPenilaian()
    {
        return $this->hasMany(DetailPenilaian::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function alternatif()
    {
        return $this->belongsTo(Alternatif::class);
    }
}
