<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Employee;
use App\Models\EmployeeSalary; // Add this import
use App\Models\Config_salary; // Update the model name to match the correct model name
use App\Http\Requests\StoreEmployeeRequest;
use App\Http\Requests\UpdateEmployeeRequest;
use App\Models\Designation;
use App\Models\Schedule;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $employees = Employee::all();
        return view('admin.employee.index', compact('employees'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $departments = Department::all();
        $designations = Designation::all();
        $config1 = Config_salary::all(); // Ensure this model exists and is correctly named

        return view('admin.employee.create', compact('departments', 'designations', 'config1'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreEmployeeRequest $request)
    {
        // Create the employee
        $employee = Employee::create($request->only([
            'unique_id',
            'timekeeping_code',
            'employe_name',
            'unsigned_name',
            'email',
            'phone',
            'dob',
            'address',
            'gender',
            'marital',
            'status',
            'department_id',
            'designation_id',
            'start_date',
            'end_date',
            'start_probation',
            'end_probation',
        ]));

        // Save salary configurations
        if ($request->has('config_salary')) {
            $configSalaries = Config_salary::all(); // Fetch all configuration options

            foreach ($configSalaries as $index => $configSalary) {
            
                if (isset($request->config_salary[$index])) {
                    EmployeeSalary::create([
                        'id_config' => $configSalary->id,
                        'employee_id' => $employee->id,
                        'amount' => $request->config_salary[$index],
                    ]);
                }
            }
        }

        return back()->with('success', 'Employee created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $employee = Employee::findOrFail($id);
        $departments = Department::all();
        $designations = Designation::all();
        $schedules = Schedule::all();
        return view('admin.employee.show', compact('employee', 'departments', 'designations'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $employee = Employee::findOrFail($id);
        $departments = Department::all();
        $designations = Designation::all();
        $config = Config_salary::all(); // Lấy thông tin cấu hình lương
        $employeeSalaries = EmployeeSalary::where('employee_id', $id)->pluck('amount', 'id_config')->toArray();

        return view('admin.employee.edit', compact('employee', 'departments', 'designations', 'config', 'employeeSalaries'));
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateEmployeeRequest $request, Employee $employee)
{
    // Update employee data
    $employee->update($request->only([
        'unique_id',
        'timekeeping_code',
        'employe_name',
        'unsigned_name',
        'email',
        'phone',
        'dob',
        'address',
        'gender',
        'marital',
        'status',
        'department_id',
        'designation_id',
        'start_date',
        'end_date',
        'start_probation',
        'end_probation',
    ]));

    // Clear existing salaries for the employee
    EmployeeSalary::where('employee_id', $employee->id)->delete();

    // Check if there are any salary configurations in the request
    if ($request->has('config_salary')) {
        foreach ($request->config_salary as $configId => $amount) {
            // Validate amount to be numeric
            if (is_numeric($amount)) {
                EmployeeSalary::create([
                    'id_config' => $configId,
                    'employee_id' => $employee->id,
                    'amount' => $amount,
                ]);
            }
        }
    }

    return back()->with('success', 'Employee updated successfully');
}


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Employee $employee)
    {
        // Remove associated salaries
        EmployeeSalary::where('employee_id', $employee->id)->delete();

        $employee->delete();
        return back()->with('success', 'Employee deleted successfully');
    }
}
