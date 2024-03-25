<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Models\Material;

class Notgood extends Model
{
    use HasFactory;

    public function material(){
        return $this->belongsTo(Material::class,'id_material');
    }
    protected $table='notgood';
    protected $primaryKey='id_notgood';

    protected $fillable = [
        'id_notgood',
        'id_material',
        'jumlah_ng',
        'keterangan',
    ];
}
