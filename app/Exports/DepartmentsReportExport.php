<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class DepartmentsReportExport implements FromCollection, WithHeadings, WithMapping, WithTitle, WithStyles
{
    protected $departments;

    public function __construct($departments)
    {
        $this->departments = $departments;
    }

    public function collection()
    {
        return $this->departments;
    }

    public function headings(): array
    {
        return [
            'Department Name',
            'Code',
            'Description',
            'User Count',
            'Status',
            'Created By',
            'Created Date',
            'Updated Date',
        ];
    }

    public function map($dept): array
    {
        return [
            $dept->name,
            $dept->code,
            $dept->description,
            $dept->users_count,
            $dept->is_active ? 'Active' : 'Inactive',
            $dept->creator ? $dept->creator->name : '-',
            $dept->created_at->format('Y-m-d'),
            $dept->updated_at->format('Y-m-d'),
        ];
    }

    public function title(): string
    {
        return 'Departments Report';
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }
}
