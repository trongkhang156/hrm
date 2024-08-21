<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeeSalary extends Model
{
    use HasFactory;

    protected $table = 'employee_salaries';

    // Define the fillable attributes for mass assignment
    protected $fillable = [
        'id_config',
        'employee_id',
        'amount'
    ];

    // Optionally, you can define relationships here
    public function configSalary()
    {
        return $this->belongsTo(ConfigSalary::class, 'id_config');
    }

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id');
    }
}
