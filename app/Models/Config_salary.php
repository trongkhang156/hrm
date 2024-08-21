<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Config_salary extends Model
{

    use HasFactory;

    protected $fillable = [ 'created_at', 'updated_at', 'is_active','name','display_order'];
}
