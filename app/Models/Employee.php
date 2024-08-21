<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Employee extends Model
{
    use HasFactory;
    protected $fillable = [
        // 'user_id',
        'department_id',
        'designation_id',
        'employe_name',
        'unsigned_name',
        'unique_id',
        'timekeeping_code',
        'avatar',
        'email',
        'phone',
        'address',
        'dob',
        'gender',
        'religion',
        'marital',
        'status',
        'start_date',
        'end_date',
        'start_probation',
        'end_probation'
    ];
// Define relationships
    public function user(): BelongsTo {
        return $this->belongsTo(User::class);
    }

    public function department(): BelongsTo {
        return $this->belongsTo(Department::class);
    }

    public function designation(): BelongsTo {
        return $this->belongsTo(Designation::class);
    }

    public function attendances(): HasMany {
        return $this->hasMany(Attendance::class); // Replace 'Attendance' with your actual attendance model name
    }

    public function schedule(): BelongsTo {
        return $this->belongsTo(Schedule::class); // Replace 'Attendance' with your actual attendance model name
    }

    public function departs(): HasMany {
        return $this->hasMany(Depart::class);
    }

    public function check(): HasMany {
        return $this->hasMany(Check::class);
    }

    public function salary(): HasOne {
        return $this->hasOne(Salary::class);
    }

    public function leaves(): HasMany {
        return $this->hasMany(Leave::class);
    }

    public function allowances(): HasMany {
        return $this->hasMany(Allowance::class);
    }

    public function lateTime(): HasMany {
        return $this->hasMany(LateTime::class);
    }

    public function overTime(): HasMany {
        return $this->hasMany(OverTime::class);
    }

    public function payrolls(): HasMany {
        return $this->hasMany(Payroll::class);
    }
    public function shiftSchedules()
    {
        return $this->hasMany(ShiftSchedule::class, 'id_employees');
    }
    public function employeeSalaries()
    {
        return $this->hasMany(EmployeeSalary::class, 'employee_id');
    }
    

}

