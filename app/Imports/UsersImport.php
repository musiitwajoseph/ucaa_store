<?php

namespace App\Imports;

use App\Models\User;
use App\Models\Department;
use App\Models\JobTitle;
use App\Models\OfficeLocation;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UsersImport implements ToModel, WithHeadingRow, WithValidation, SkipsEmptyRows, SkipsOnFailure
{
    use SkipsFailures;

    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        // Generate code if not provided
        $code = !empty($row['code']) ? $row['code'] : 'USR-' . strtoupper(Str::random(6));

        // Look up foreign keys
        $departmentId = null;
        if (!empty($row['department_code'])) {
            $department = Department::where('code', $row['department_code'])->first();
            $departmentId = $department ? $department->id : null;
        }

        $jobTitleId = null;
        if (!empty($row['job_title_code'])) {
            $jobTitle = JobTitle::where('code', $row['job_title_code'])->first();
            $jobTitleId = $jobTitle ? $jobTitle->id : null;
        }

        $officeLocationId = null;
        if (!empty($row['office_location_code'])) {
            $officeLocation = OfficeLocation::where('code', $row['office_location_code'])->first();
            $officeLocationId = $officeLocation ? $officeLocation->id : null;
        }

        return new User([
            'code' => $code,
            'first_name' => $row['first_name'],
            'last_name' => $row['last_name'],
            'email' => $row['email'],
            'username' => $row['username'] ?? null,
            'password' => Hash::make($row['password'] ?? 'password123'),
            'phone' => $row['phone'] ?? null,
            'mobile' => $row['mobile'] ?? null,
            'employee_id' => $row['employee_id'] ?? null,
            'department_id' => $departmentId,
            'job_title_id' => $jobTitleId,
            'office_location_id' => $officeLocationId,
            'is_active' => isset($row['is_active']) ? filter_var($row['is_active'], FILTER_VALIDATE_BOOLEAN) : true,
            'is_admin' => isset($row['is_admin']) ? filter_var($row['is_admin'], FILTER_VALIDATE_BOOLEAN) : false,
            'is_ldap_user' => false,
            'created_by' => auth()->id(),
        ]);
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            'first_name' => 'required|string|max:100',
            'last_name' => 'required|string|max:100',
            'email' => 'required|email|max:100|unique:users,email',
            'username' => 'nullable|string|max:50|unique:users,username',
            'code' => 'nullable|string|max:20|unique:users,code',
            'phone' => 'nullable|string|max:20',
            'mobile' => 'nullable|string|max:20',
            'employee_id' => 'nullable|string|max:50',
            'department_code' => 'nullable|string',
            'job_title_code' => 'nullable|string',
            'office_location_code' => 'nullable|string',
            'is_active' => 'nullable',
            'is_admin' => 'nullable',
        ];
    }

    /**
     * @return array
     */
    public function customValidationMessages()
    {
        return [
            'first_name.required' => 'First name is required',
            'last_name.required' => 'Last name is required',
            'email.required' => 'Email is required',
            'email.email' => 'Invalid email format',
            'email.unique' => 'Email already exists',
            'username.unique' => 'Username already exists',
            'code.unique' => 'User code already exists',
        ];
    }
}
