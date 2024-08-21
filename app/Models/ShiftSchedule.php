<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShiftSchedule extends Model
{
    protected $table = 'shift_schedules';
    protected $fillable = [ 'id_employees', 'shift_date','id_ca', ];
    public function employee()
    {
        return $this->belongsTo(Employee::class, 'id_employees');
    }

    public function schedule()
    {
        return $this->belongsTo(Schedule::class, 'id_ca');
    }
}
