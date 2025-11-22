<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PublicHoliday;
use Carbon\Carbon;

class PublicHolidaysSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * Seeds Uganda public holidays and internal company holidays
     */
    public function run(): void
    {
        $currentYear = date('Y');
        
        $holidays = [
            // Uganda Public Holidays (Fixed dates)
            [
                'name' => 'New Year\'s Day',
                'date' => "{$currentYear}-01-01",
                'type' => 'public',
                'description' => 'First day of the year',
                'display_message' => 'Happy New Year! Wishing you a prosperous year ahead. Office closed.',
                'notification_start_date' => "{$currentYear}-12-28",
                'notification_end_date' => "{$currentYear}-01-02",
                'show_on_dashboard' => true,
                'is_recurring' => true,
                'reminder_days' => 2,
            ],
            [
                'name' => 'NRM Liberation Day',
                'date' => "{$currentYear}-01-26",
                'type' => 'public',
                'description' => 'Celebrating the National Resistance Movement\'s victory',
                'is_recurring' => true,
                'reminder_days' => 1,
            ],
            [
                'name' => 'International Women\'s Day',
                'date' => "{$currentYear}-03-08",
                'type' => 'public',
                'description' => 'Celebrating women\'s achievements',
                'is_recurring' => true,
                'reminder_days' => 1,
            ],
            [
                'name' => 'Labour Day',
                'date' => "{$currentYear}-05-01",
                'type' => 'public',
                'description' => 'International Workers\' Day',
                'is_recurring' => true,
                'reminder_days' => 1,
            ],
            [
                'name' => 'Martyrs Day',
                'date' => "{$currentYear}-06-03",
                'type' => 'public',
                'description' => 'Honoring the Uganda Martyrs',
                'is_recurring' => true,
                'reminder_days' => 1,
            ],
            [
                'name' => 'National Heroes Day',
                'date' => "{$currentYear}-06-09",
                'type' => 'public',
                'description' => 'Honoring national heroes',
                'is_recurring' => true,
                'reminder_days' => 1,
            ],
            [
                'name' => 'Independence Day',
                'date' => "{$currentYear}-10-09",
                'type' => 'public',
                'description' => 'Uganda\'s Independence from British rule',
                'is_recurring' => true,
                'reminder_days' => 2,
            ],
            [
                'name' => 'Christmas Day',
                'date' => "{$currentYear}-12-25",
                'type' => 'public',
                'description' => 'Christian celebration of Jesus Christ\'s birth',
                'display_message' => 'Merry Christmas! May this festive season bring you joy and happiness. Office closed Dec 25-26.',
                'notification_start_date' => "{$currentYear}-12-20",
                'notification_end_date' => "{$currentYear}-12-27",
                'show_on_dashboard' => true,
                'is_recurring' => true,
                'reminder_days' => 3,
            ],
            [
                'name' => 'Boxing Day',
                'date' => "{$currentYear}-12-26",
                'type' => 'public',
                'description' => 'Day after Christmas',
                'display_message' => 'Happy Boxing Day! Enjoy the extended holiday. Office remains closed.',
                'notification_start_date' => "{$currentYear}-12-20",
                'notification_end_date' => "{$currentYear}-12-27",
                'show_on_dashboard' => true,
                'is_recurring' => true,
                'reminder_days' => 3,
            ],

            // Religious Holidays (Variable dates - these are estimates for 2025-2026)
            [
                'name' => 'Good Friday',
                'date' => '2025-04-18',
                'type' => 'religious',
                'description' => 'Christian observance of Jesus Christ\'s crucifixion',
                'is_recurring' => false, // Date changes yearly
                'reminder_days' => 2,
            ],
            [
                'name' => 'Easter Monday',
                'date' => '2025-04-21',
                'type' => 'religious',
                'description' => 'Day after Easter Sunday',
                'display_message' => 'Happy Easter! Wishing you a blessed holiday weekend.',
                'notification_start_date' => '2025-04-16',
                'notification_end_date' => '2025-04-21',
                'show_on_dashboard' => true,
                'is_recurring' => false,
                'reminder_days' => 2,
            ],
            [
                'name' => 'Eid al-Fitr',
                'date' => '2025-03-30',
                'type' => 'religious',
                'description' => 'End of Ramadan (Islamic)',
                'is_recurring' => false, // Islamic calendar varies
                'reminder_days' => 1,
            ],
            [
                'name' => 'Eid al-Adha',
                'date' => '2025-06-06',
                'type' => 'religious',
                'description' => 'Festival of Sacrifice (Islamic)',
                'is_recurring' => false,
                'reminder_days' => 1,
            ],

            // 2026 Variable holidays
            [
                'name' => 'Good Friday',
                'date' => '2026-04-03',
                'type' => 'religious',
                'description' => 'Christian observance of Jesus Christ\'s crucifixion',
                'is_recurring' => false,
                'reminder_days' => 2,
            ],
            [
                'name' => 'Easter Monday',
                'date' => '2026-04-06',
                'type' => 'religious',
                'description' => 'Day after Easter Sunday',
                'is_recurring' => false,
                'reminder_days' => 2,
            ],

            // Internal Company Holidays
            [
                'name' => 'Company Foundation Day',
                'date' => "{$currentYear}-07-15",
                'type' => 'internal',
                'description' => 'Anniversary of company founding',
                'is_recurring' => true,
                'reminder_days' => 3,
            ],
            [
                'name' => 'Staff Appreciation Day',
                'date' => "{$currentYear}-11-15",
                'type' => 'internal',
                'description' => 'Special day to appreciate staff contributions',
                'display_message' => 'Thank you for your dedication and hard work! Join us for the Staff Appreciation celebration.',
                'notification_start_date' => "{$currentYear}-11-08",
                'notification_end_date' => "{$currentYear}-11-15",
                'show_on_dashboard' => true,
                'is_recurring' => true,
                'reminder_days' => 5,
            ],
            [
                'name' => 'Year End Break Start',
                'date' => "{$currentYear}-12-24",
                'type' => 'internal',
                'description' => 'Start of year-end company break',
                'display_message' => 'Year End Break begins! Complete all pending tasks. Office reopens January 2nd.',
                'notification_start_date' => "{$currentYear}-12-15",
                'notification_end_date' => "{$currentYear}-12-24",
                'show_on_dashboard' => true,
                'is_recurring' => true,
                'reminder_days' => 5,
            ],
        ];

        foreach ($holidays as $holiday) {
            PublicHoliday::updateOrCreate(
                [
                    'name' => $holiday['name'],
                    'date' => $holiday['date']
                ],
                $holiday
            );
        }

        $this->command->info('Public holidays seeded successfully!');
        $this->command->info('Total holidays: ' . count($holidays));
    }
}
