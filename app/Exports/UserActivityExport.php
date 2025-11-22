<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class UserActivityExport implements FromCollection, WithHeadings, WithMapping, WithTitle, WithStyles
{
    protected $activities;

    public function __construct($activities)
    {
        $this->activities = $activities;
    }

    public function collection()
    {
        return $this->activities;
    }

    public function headings(): array
    {
        return [
            'Date/Time',
            'User',
            'Event',
            'Model Type',
            'Model ID',
            'IP Address',
            'User Agent',
        ];
    }

    public function map($activity): array
    {
        return [
            $activity->created_at->format('Y-m-d H:i:s'),
            $activity->user ? $activity->user->name : 'System',
            ucfirst($activity->event),
            class_basename($activity->auditable_type ?? 'Unknown'),
            $activity->auditable_id ?? '-',
            $activity->ip_address ?? '-',
            $activity->user_agent ?? '-',
        ];
    }

    public function title(): string
    {
        return 'User Activity Report';
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }
}
