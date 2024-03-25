<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Models\Material;
use App\Models\Proses;
use App\Models\Tonase;
use App\Models\Operator;
use App\Models\Stockraw;
use App\Models\Wip;
use App\Models\Target;


class Laporan extends Model
{
    use HasFactory;

    public function material(){
        return $this->belongsTo(Material::class,'id_material');
    }
    public function proses(){
        return $this->belongsTo(Proses::class,'id_proses');
    }
    public function tonase(){
        return $this->belongsTo(Tonase::class,'id_tonase');
    }
    public function operator(){
        return $this->belongsTo(Operator::class,'id_operator');
    }
    public function stockraw(){
        return $this->belongsTo(Stockraw::class,'id_stock_raw');
    }
    public function wip(){
        return $this->belongsTo(Stockraw::class,'id_wip');
    }
    public function target()
    {
        return $this->hasOne(Target::class, 'id_material', 'id_material')
                ->where('id_proses', $this->id_proses);
    }
    protected $table='laporan_produksi';
    protected $primaryKey='id_laporan_produksi';

    protected $fillable = [
        'id_laporan_produksi',
        'tanggal',
        'id_material',
        'id_proses',
        'id_stock_raw',
        'jumlah_sheet',
        'id_operator',
        'id_tonase',
        'jam_mulai',
        'jam_selesai',
        'jumlah_jam',
        'jumlah_ok',
        'jumlah_ng',
        'keterangan',
    ];
}
