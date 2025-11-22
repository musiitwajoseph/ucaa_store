<?php

namespace App\Imports;

use App\Models\JobTitle;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Illuminate\Support\Str;

class JobTitlesImport implements ToModel, WithHeadingRow, WithValidation, SkipsEmptyRows, SkipsOnFailure
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
        $code = !empty($row['code']) ? $row['code'] : 'JOB-' . strtoupper(Str::random(6));

        return new JobTitle([
            'code' => $code,
            'title' => $row['title'],
            'description' => $row['description'] ?? null,
            'level' => $row['level'] ?? null,
            'is_active' => isset($row['is_active']) ? filter_var($row['is_active'], FILTER_VALIDATE_BOOLEAN) : true,
            'created_by' => auth()->id(),
        ]);
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            'title' => 'required|string|max:100',
            'code' => 'nullable|string|max:20|unique:job_titles,code',
            'description' => 'nullable|string',
            'level' => 'nullable|string|max:50',
            'is_active' => 'nullable',
        ];
    }

    /**
     * @return array
     */
    public function customValidationMessages()
    {
        return [
            'title.required' => 'Job title is required',
            'code.unique' => 'Job title code already exists',
        ];
    }
}
