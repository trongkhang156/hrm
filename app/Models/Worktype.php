<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Worktype extends Model
{
    use HasFactory;

    // Define the table associated with the model
    protected $table = 'worktypes';
    public function parent()
    {
        return $this->belongsTo(Worktype::class, 'parent_id');
    }
    // Define the fillable attributes
    protected $fillable = [
        'name', 
        'type', 
        'max', 
        'parent_id', 
        'is_delete'
    ];


   
}
