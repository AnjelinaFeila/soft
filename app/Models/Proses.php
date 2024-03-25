<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Models\Laporan_produksi;
use App\Models\Wip;
use App\Models\Notgood;

class Proses extends Model
{
    use HasFactory;

    public function Laporan_produksi(){
        return $this->hasOne(Laporan_produksi::class,'id_proses');
    }
    public function Wip(){
        return $this->hasOne(Wip::class,'id_proses');
    }
    public function Notgood(){
        return $this->hasOne(Notgood::class,'id_proses');
    }
    protected $table='proses';
    protected $primaryKey='id_proses';

    protected $fillable = [
        'id_proses',
        'nama_proses',
    ];
}
