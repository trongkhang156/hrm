@extends('layouts.admin')
@section('title')
{{ __('Update Employee') }}
@endsection
@section('header')
@endsection
@section('content')
<section class="row">
   <div class="col-12">
   <form method="POST" action="{{ Auth::user()->role->slug === 'super-admin' ? route('employee.update', $employee->id) : (Auth::user()->role->slug === 'administrator' ? route('admin.employee.update', $employee->id) : route('hr.employee.update', $employee->id)) }}">
      @csrf
      @method('PUT')
      <div class="row g-3">
         <div class="col-6">
            <div class="card flex-fill">
               <div class="card-header">
                  <h5 class="card-title mb-0">{{ __('Thông tin nhân viên') }}</h5>
               </div>
               <div class="card-body">
                  <div class="row g-3">
                     <div class="col-6">
                        <label for="employeeId">{{ __('Mã nhân viên') }}</label>
                        <div class="input-group">
                           <button type="button" class="btn btn-secondary btn-sm" id="generate">
                           <i class="fas fa-arrows-rotate"></i>
                           </button>
                           <input type="text" name="unique_id" id="employeeId" class="form-control" value="{{ $employee->unique_id }}" />
                        </div>
                     </div>
                     <div class="col-6">
                        <label for="timekeeping_code">{{ __('Mã chấm công') }}</label>
                        <div class="input-group">
                           <input type="text" name="timekeeping_code" id="timekeeping_code" class="form-control" value="{{ $employee->timekeeping_code }}" />
                        </div>
                     </div>
                     <div class="col-6">
                        <label for="employe_name">{{ __('Tên') }}</label>
                        <input type="text" name="employe_name" id="employe_name" class="form-control" value="{{ $employee->employe_name }}" />
                     </div>
                     <div class="col-6">
                        <label for="unsigned_name">{{ __('Tên không dấu') }}</label>
                        <input type="text" name="unsigned_name" id="unsigned_name" class="form-control" value="{{ $employee->unsigned_name }}" required />
                     </div>
                     <div class="col-12">
                        <label for="email">{{ __('Email') }}</label>
                        <input type="email" name="email" id="email" class="form-control" placeholder="@inan.com.vn" value="{{ $employee->email }}" required />
                     </div>
                     <div class="col-6">
                        <label for="phone">{{ __('Số điện thoại') }}</label>
                        <input type="tel" name="phone" class="form-control" id="phone" maxlength="19" value="{{ $employee->phone }}" />
                     </div>
                     <div class="col-6">
                        <label for="dob">{{ __('Ngày/ tháng/ năm sinh') }}</label>
                        <input type="date" name="dob" class="form-control" id="dob" value="{{ $employee->dob }}" />
                     </div>
                     <div class="col-6">
                        <label for="address">{{ __('Địa chỉ') }}</label>
                        <input name="address" class="form-control" id="address" value="{{ $employee->address }}" />
                     </div>
                     <div class="col-6">
                        <label for="gender">{{ __('Giới tính') }}</label>
                        <select name="gender" class="form-control" id="gender">
                           <option value="">{{ __('-- Chọn --') }}</option>
                           <option value="1" {{ $employee->gender == 1 ? 'selected' : '' }}>{{ __('Nam') }}</option>
                           <option value="2" {{ $employee->gender == 2 ? 'selected' : '' }}>{{ __('Nữ') }}</option>
                           <option value="3" {{ $employee->gender == 3 ? 'selected' : '' }}>{{ __('Khác') }}</option>
                        </select>
                     </div>
                     <div class="col-6">
                        <label for="marital">{{ __('Tình trạng hôn nhân') }}</label>
                        <select name="marital" class="form-control" id="marital">
                           <option value="">{{ __('-- Chọn --') }}</option>
                           <option value="1" {{ $employee->marital == 1 ? 'selected' : '' }}>{{ __('Đã kết hôn') }}</option>
                           <option value="2" {{ $employee->marital == 2 ? 'selected' : '' }}>{{ __('Độc thân') }}</option>
                        </select>
                     </div>
                  </div>
               </div>
            
            </div>
            <div class="card flex-fill">
               <div class="card-header">
                  <h5 class="card-title mb-0">{{ __('Thông tin nghề nghiệp') }}</h5>
               </div>
               <div class="card-body">
                  <div class="row g-3">
                     <div class="col-12">
                        <label for="status">{{ __('Trạng thái') }}</label>
                        <select name="status" class="form-control" id="status">
                           <option value="">{{ __('-- Chọn --') }}</option>
                           <option value="1" {{ $employee->status == 1 ? 'selected' : '' }}>{{ __('Đang làm') }}</option>
                           <option value="2" {{ $employee->status == 2 ? 'selected' : '' }}>{{ __('Thử việc') }}</option>
                           <option value="3" {{ $employee->status == 3 ? 'selected' : '' }}>{{ __('Nghỉ việc') }}</option>
                        </select>
                     </div>
                     <div class="col-6">
                        <label for="department">{{ __('Phòng ban') }}</label>
                        <select name="department_id" class="form-control" id="department">
                        @foreach ($departments as $department)
                        <option value="{{ $department->id }}" {{ $employee->department_id == $department->id ? 'selected' : '' }}>{{ $department->title }}</option>
                        @endforeach
                        </select>
                     </div>
                     <div class="col-6">
                        <label for="designation">{{ __('Chức vụ') }}</label>
                        <select name="designation_id" class="form-control" id="designation">
                        @foreach ($designations as $designation)
                        <option value="{{ $designation->id }}" {{ $employee->designation_id == $designation->id ? 'selected' : '' }}>{{ $designation->title }}</option>
                        @endforeach
                        </select>
                     </div>
                     <div class="col-6">
                        <label for="start_date">{{ __('Ngày vào làm') }}</label>
                        <input type="date" name="start_date" class="form-control" id="start_date" value="{{ $employee->start_date }}" />
                     </div>
                     <div class="col-6">
                        <label for="end_date">{{ __('Ngày nghỉ việc') }}</label>
                        <input type="date" name="end_date" class="form-control" id="end_date" value="{{ $employee->end_date }}" />
                     </div>
                     <div class="col-6">
                        <label for="start_probation">{{ __('Ngày thử việc') }}</label>
                        <input type="date" name="start_probation" class="form-control" id="start_probation" value="{{ $employee->start_probation }}" />
                     </div>
                     <div class="col-6">
                        <label for="end_probation">{{ __('Ngày kết thúc thử việc') }}</label>
                        <input type="date" name="end_probation" class="form-control" id="end_probation" value="{{ $employee->end_probation }}" />
                     </div>
                  </div>
               </div>
            </div>
            <!-- Phần cập nhật lương -->
            <div class="card flex-fill">
               <div class="card-header">
                  <h5 class="card-title mb-0">{{ __('Lương') }}</h5>
               </div>
               <div class="card-body">
                  <div class="row g-3">
                     <!-- Lương cơ bản -->
                     <div class="card flex-fill">
                        <div class="card-header">
                           <h5 class="card-title mb-0">{{ __('Lương cơ bản') }}</h5>
                        </div>
                        <div class="card-body">
                           <div class="row g-3">
                              @foreach ($config as $index => $configsalary)
                              @if ($configsalary->type == 1)
                              <div class="col-6">
                                 <label for="config_salary_{{ $configsalary->id }}">{{ $configsalary->name }}</label>
                                 <input type="number" id="config_salary_{{ $configsalary->id }}" name="config_salary[{{ $configsalary->id }}]" class="form-control" value="{{ old('config_salary.' . $configsalary->id, $employeeSalaries[$configsalary->id] ?? 0) }}" />
                              </div>
                              @endif
                              @endforeach
                           </div>
                        </div>
                     </div>
                     <div class="card flex-fill">
                        <div class="card-header">
                           <h5 class="card-title mb-0">{{ __('Phụ cấp') }}</h5>
                        </div>
                        <div class="card-body">
                           <div class="row g-3">
                              @foreach ($config as $configsalary)
                              @if ($configsalary->type == 2)
                              <div class="col-6">
                                 <label for="config_salary_{{ $configsalary->id }}">{{ $configsalary->name }}</label>
                                 <input type="number" id="config_salary_{{ $configsalary->id }}" name="config_salary[{{ $configsalary->id }}]" class="form-control" value="{{ old('config_salary.' . $configsalary->id, $employeeSalaries[$configsalary->id] ?? 0) }}" />
                              </div>
                              @endif
                              @endforeach
                           </div>
                        </div>
                     </div>
                     <!-- Giảm trừ -->
                     <div class="card flex-fill">
                        <div class="card-header">
                           <h5 class="card-title mb-0">{{ __('Giảm trừ') }}</h5>
                        </div>
                        <div class="card-body">
                           <div class="row g-3">
                              @foreach ($config as $configsalary)
                              @if ($configsalary->type == 3)
                              <div class="col-6">
                                 <label for="config_salary_{{ $configsalary->id }}">{{ $configsalary->name }}</label>
                                 <input type="number" id="config_salary_{{ $configsalary->id }}" name="config_salary[{{ $configsalary->id }}]" class="form-control" value="{{ old('config_salary.' . $configsalary->id, $employeeSalaries[$configsalary->id] ?? 0) }}" />
                              </div>
                              @endif
                              @endforeach
                           </div>
                        </div>
                     </div>
                  </div>
              
               </div>
               
            </div>
            
         </div>
         <div class="card-footer sticky-footer">
    <div class="row">
        <div class="col-6 d-grid">
            <a href="{{ Auth::user()->role->slug === 'super-admin' ? route('employee.index') : (Auth::user()->role->slug === 'administrator' ? route('admin.employee.index') : route('hr.employee.index') ) }}" class="btn btn-outline-secondary">
                <i class="align-middle me-1" data-feather="arrow-left"></i>
                <span class="ps-1">{{ __('Hủy') }}</span>
            </a>
        </div>
        <div class="col-6 d-grid">
            <button type="submit" class="btn btn-outline-secondary">
                <i class="align-middle me-1" data-feather="plus"></i>
                <span class="ps-1">{{ __('Lưu') }}</span>
            </button>
        </div>
    </div>
</div>

   </form>
   </div>
</section>
@endsection
@section('script')
<script>
   var imgInp = document.getElementById("imageInput");
   var dummy = document.getElementById("dummy");
   imgInp.onchange = evt => {
       const [file] = imgInp.files
       if (file) {
           dummy.src = URL.createObjectURL(file)
       }
   }
</script>
@endsection