<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Models\Material;
use App\Models\Proses;
use App\Models\Laporan;

class Wip extends Model
{
    use HasFactory;

    public function material(){
        return $this->belongsTo(Material::class,'id_material');
    }
    public function proses(){
        return $this->belongsTo(Proses::class,'id_proses');
    }
    public function laporan(){
        return $this->hasOne(Laporan::class,'id_laporan_produksi');
    }
    protected $table='work_in_progress';
    protected $primaryKey='id_wip';

    protected $fillable = [
        'id_wip',
        'id_material',
        'kg_perpart',
        'jumlah_part',
        'last_produksi',
        'id_proses',
    ];
}
