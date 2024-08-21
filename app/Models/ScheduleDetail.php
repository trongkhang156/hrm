<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ScheduleDetail extends Model
{
    protected $table = 'schedule_details';

    protected $fillable = [
        'idcong', 'id_ca', 'starttime', 'endtime','is_overtime', 'break_time'
    ];
    public function worktype()
    {
        return $this->belongsTo(Worktype::class, 'idcong');
    }
}
