<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Models\Material;
use App\Models\Proses;
use App\Models\Laporan;

class Target extends Model
{
    use HasFactory;

    public function material(){
        return $this->belongsTo(Material::class,'id_material');
    }
    public function proses(){
        return $this->belongsTo(Proses::class,'id_proses');
    }
    public function laporanProduksi()
    {
        return $this->hasOne(Laporan::class, 'id_material');
    }
    protected $table='minimaltarget';
    protected $primaryKey='id_minimaltarget';

    protected $fillable = [
        'id_minimaltarget',
        'id_material',
        'id_proses',
        'minimal_target',
    ];
}
