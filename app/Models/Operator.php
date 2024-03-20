<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Models\Laporan;

class Operator extends Model
{
    use HasFactory;

    public function laporan(){
        return $this->hasOne(Laporan::class,'id_operator');
    }
    protected $table='operator';
    protected $primaryKey='id_operator';

    protected $fillable = [
        'id_operator',
        'nama_operator',
        'contact',
    ];
}
