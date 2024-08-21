<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Datamita extends Model
{
    protected $table = 'datamitas';
    public $timestamps = false;

    protected $fillable = [
        'MaChamCong', 'NgayCham', 'GioCham','KieuCham','NguonCham','MaSoMay','TenMay','created_at','updated_at'
    ];
}
