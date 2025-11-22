<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class UsersReportExport implements FromCollection, WithHeadings, WithMapping, WithTitle, WithStyles
{
    protected $users;

    public function __construct($users)
    {
        $this->users = $users;
    }

    public function collection()
    {
        return $this->users;
    }

    public function headings(): array
    {
        return [
            'Name',
            'Email',
            'Department',
            'Job Title',
            'Office Location',
            'Type',
            'Status',
            'Roles',
            'Is Admin',
            'Created Date',
            'Last Login',
        ];
    }

    public function map($user): array
    {
        return [
            $user->name,
            $user->email,
            $user->department ? $user->department->name : '-',
            $user->jobTitle ? $user->jobTitle->title : '-',
            $user->officeLocation ? $user->officeLocation->name : '-',
            $user->is_ldap_user ? 'LDAP' : 'Local',
            $user->is_active ? 'Active' : 'Inactive',
            $user->roles->pluck('name')->implode(', '),
            $user->is_admin ? 'Yes' : 'No',
            $user->created_at->format('Y-m-d'),
            $user->last_login_at ? $user->last_login_at->format('Y-m-d H:i:s') : 'Never',
        ];
    }

    public function title(): string
    {
        return 'Users Report';
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }
}
