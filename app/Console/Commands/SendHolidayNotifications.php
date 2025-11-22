<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\PublicHoliday;
use App\Models\User;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\DB;

class SendHolidayNotifications extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'holidays:notify {--test : Send test notification}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send notifications for upcoming and current public holidays';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Checking for holidays requiring notifications...');

        // Get holidays that need reminders today or are happening today
        $holidays = PublicHoliday::needingReminderToday()->get();

        if ($holidays->isEmpty()) {
            $this->info('No holidays require notifications today.');
            return 0;
        }

        $this->info("Found {$holidays->count()} holiday(s) requiring notifications.");

        foreach ($holidays as $holiday) {
            $this->sendHolidayNotification($holiday);
        }

        $this->info('Holiday notifications sent successfully!');
        return 0;
    }

    /**
     * Send notification for a specific holiday
     */
    private function sendHolidayNotification(PublicHoliday $holiday)
    {
        $daysUntil = $holiday->daysUntil();
        $isToday = $holiday->isToday();

        $this->info("Processing: {$holiday->name} (" . $holiday->date->format('Y-m-d') . ")");

        // Get all active users
        $users = User::where('is_active', true)->get();

        foreach ($users as $user) {
            // Create notification in database
            DB::table('notifications')->insert([
                'id' => \Illuminate\Support\Str::uuid(),
                'type' => 'App\\Notifications\\HolidayNotification',
                'notifiable_type' => 'App\\Models\\User',
                'notifiable_id' => $user->id,
                'data' => json_encode([
                    'message' => $holiday->getReminderMessage(),
                    'holiday_name' => $holiday->name,
                    'holiday_date' => $holiday->date->format('Y-m-d'),
                    'days_until' => $daysUntil,
                    'is_today' => $isToday,
                    'type' => $holiday->type,
                    'greeting' => $isToday ? $holiday->getGreetingMessage() : null,
                    'urgency' => $isToday ? 'high' : 'medium',
                ]),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        $this->info("  ✓ Sent to {$users->count()} users");
    }
}
