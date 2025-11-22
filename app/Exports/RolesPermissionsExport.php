<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class RolesPermissionsExport implements FromCollection, WithHeadings, WithMapping, WithTitle, WithStyles
{
    protected $roles;

    public function __construct($roles)
    {
        $this->roles = $roles;
    }

    public function collection()
    {
        return $this->roles;
    }

    public function headings(): array
    {
        return [
            'Role Name',
            'Description',
            'Status',
            'Permissions Count',
            'Users Count',
            'Permissions',
            'Created Date',
        ];
    }

    public function map($role): array
    {
        return [
            $role->name,
            $role->description,
            $role->is_active ? 'Active' : 'Inactive',
            $role->permissions_count,
            $role->users_count,
            $role->permissions->pluck('name')->implode(', '),
            $role->created_at->format('Y-m-d'),
        ];
    }

    public function title(): string
    {
        return 'Roles & Permissions';
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }
}
