<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class PublicHoliday extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'date',
        'type',
        'description',
        'display_message',
        'notification_start_date',
        'notification_end_date',
        'show_on_dashboard',
        'is_recurring',
        'is_active',
        'reminder_days',
    ];

    protected $casts = [
        'date' => 'date',
        'notification_start_date' => 'date',
        'notification_end_date' => 'date',
        'is_recurring' => 'boolean',
        'is_active' => 'boolean',
        'show_on_dashboard' => 'boolean',
        'reminder_days' => 'integer',
    ];

    /**
     * Scope for active holidays
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope for upcoming holidays
     */
    public function scopeUpcoming($query, $days = 30)
    {
        $now = now();
        $endDate = $now->copy()->addDays($days);
        
        return $query->where(function($q) use ($now, $endDate) {
            // For recurring holidays, compare month and day only
            $q->where(function($sq) use ($now, $endDate) {
                $sq->where('is_recurring', true)
                   ->where(function($ssq) use ($now, $endDate) {
                       // Build date with current year for comparison
                       $ssq->whereRaw("DATEFROMPARTS(YEAR(GETDATE()), MONTH(date), DAY(date)) >= ?", [$now->format('Y-m-d')])
                           ->whereRaw("DATEFROMPARTS(YEAR(GETDATE()), MONTH(date), DAY(date)) <= ?", [$endDate->format('Y-m-d')]);
                   });
            })
            // For non-recurring holidays, use exact date
            ->orWhere(function($sq) use ($now, $endDate) {
                $sq->where('is_recurring', false)
                   ->where('date', '>=', $now)
                   ->where('date', '<=', $endDate);
            });
        })->orderByRaw('CASE WHEN is_recurring = 1 THEN DATEFROMPARTS(YEAR(GETDATE()), MONTH(date), DAY(date)) ELSE date END');
    }

    /**
     * Scope for today's holidays
     */
    public function scopeToday($query)
    {
        $today = today();
        return $query->where(function($q) use ($today) {
            // For recurring holidays, match month and day only
            $q->where(function($sq) use ($today) {
                $sq->where('is_recurring', true)
                   ->whereRaw('MONTH(date) = ?', [$today->month])
                   ->whereRaw('DAY(date) = ?', [$today->day]);
            })
            // For non-recurring holidays, match exact date
            ->orWhere(function($sq) use ($today) {
                $sq->where('is_recurring', false)
                   ->whereDate('date', $today);
            });
        });
    }

    /**
     * Scope for holidays requiring reminder today
     */
    public function scopeNeedingReminderToday($query)
    {
        $today = today();
        return $query->active()
                     ->where(function($q) use ($today) {
                         $q->where(function($sq) use ($today) {
                             // Use notification date range if specified
                             $sq->whereNotNull('notification_start_date')
                                ->whereNotNull('notification_end_date')
                                ->whereDate('notification_start_date', '<=', $today)
                                ->whereDate('notification_end_date', '>=', $today);
                         })
                         ->orWhere(function($sq) use ($today) {
                             // Fallback to reminder_days logic
                             $sq->whereNull('notification_start_date')
                                ->where(function($ssq) use ($today) {
                                    // For recurring holidays, calculate with current year
                                    $ssq->where(function($sssq) use ($today) {
                                        $sssq->where('is_recurring', true)
                                             ->whereRaw('DATEDIFF(day, GETDATE(), DATEFROMPARTS(YEAR(GETDATE()), MONTH(date), DAY(date))) = reminder_days');
                                    })
                                    // For non-recurring, use exact date
                                    ->orWhere(function($sssq) use ($today) {
                                        $sssq->where('is_recurring', false)
                                             ->whereRaw('DATEDIFF(day, GETDATE(), date) = reminder_days');
                                    })
                                    // Or if it's today
                                    ->orWhere(function($sssq) use ($today) {
                                        $sssq->where('is_recurring', true)
                                             ->whereRaw('MONTH(date) = ?', [$today->month])
                                             ->whereRaw('DAY(date) = ?', [$today->day]);
                                    })
                                    ->orWhere(function($sssq) use ($today) {
                                        $sssq->where('is_recurring', false)
                                             ->whereDate('date', $today);
                                    });
                                });
                         });
                     });
    }

    /**
     * Scope for holidays to display on dashboard
     */
    public function scopeForDashboard($query)
    {
        $today = today();
        return $query->active()
                     ->where('show_on_dashboard', true)
                     ->where(function($q) use ($today) {
                         $q->where(function($sq) use ($today) {
                             // Show if within notification date range
                             $sq->whereNotNull('notification_start_date')
                                ->whereNotNull('notification_end_date')
                                ->whereDate('notification_start_date', '<=', $today)
                                ->whereDate('notification_end_date', '>=', $today);
                         })
                         ->orWhere(function($sq) use ($today) {
                             // Or show if within reminder_days period
                             $sq->whereNull('notification_start_date')
                                ->where(function($ssq) use ($today) {
                                    // For recurring holidays
                                    $ssq->where(function($sssq) use ($today) {
                                        $sssq->where('is_recurring', true)
                                             ->whereRaw('DATEFROMPARTS(YEAR(GETDATE()), MONTH(date), DAY(date)) >= GETDATE()')
                                             ->whereRaw('DATEDIFF(day, GETDATE(), DATEFROMPARTS(YEAR(GETDATE()), MONTH(date), DAY(date))) <= reminder_days');
                                    })
                                    // For non-recurring holidays
                                    ->orWhere(function($sssq) use ($today) {
                                        $sssq->where('is_recurring', false)
                                             ->where('date', '>=', $today)
                                             ->whereRaw('DATEDIFF(day, GETDATE(), date) <= reminder_days');
                                    });
                                });
                         });
                     })
                     ->orderByRaw('CASE WHEN is_recurring = 1 THEN DATEFROMPARTS(YEAR(GETDATE()), MONTH(date), DAY(date)) ELSE date END');
    }

    /**
     * Check if holiday is today
     */
    public function isToday()
    {
        return $this->date->isToday();
    }

    /**
     * Get days until holiday
     */
    public function daysUntil()
    {
        if ($this->is_recurring) {
            // For recurring holidays, use current year
            $holidayThisYear = Carbon::create(now()->year, $this->date->month, $this->date->day);
            return today()->diffInDays($holidayThisYear, false);
        }
        
        return today()->diffInDays($this->date, false);
    }

    /**
     * Get the holiday date with current year for recurring holidays
     */
    public function getDisplayDate()
    {
        if ($this->is_recurring) {
            return Carbon::create(now()->year, $this->date->month, $this->date->day);
        }
        
        return $this->date;
    }

    /**
     * Get appropriate greeting message
     */
    public function getGreetingMessage()
    {
        $greetings = [
            'New Year\'s Day' => 'Happy New Year! May this year bring you joy, success, and prosperity.',
            'Easter Monday' => 'Happy Easter! May this day bring you peace and renewal.',
            'Labour Day' => 'Happy Labour Day! Celebrating the dignity of work and workers everywhere.',
            'Martyrs Day' => 'Remembering the Uganda Martyrs and their courage and faith.',
            'National Heroes Day' => 'Honoring our national heroes who fought for our freedom.',
            'Independence Day' => 'Happy Independence Day Uganda! Celebrating our freedom and unity.',
            'Christmas Day' => 'Merry Christmas! Wishing you joy, peace, and love this festive season.',
            'Boxing Day' => 'Happy Boxing Day! Enjoy this time with family and friends.',
            'Eid al-Fitr' => 'Eid Mubarak! May this blessed occasion bring happiness and prosperity.',
            'Eid al-Adha' => 'Eid Mubarak! Wishing you peace and blessings on this holy day.',
        ];

        return $greetings[$this->name] ?? "Happy {$this->name}! Wishing you a wonderful day.";
    }

    /**
     * Get reminder message
     */
    public function getReminderMessage()
    {
        // Use custom display message if provided
        if ($this->display_message) {
            return $this->display_message;
        }

        $days = $this->daysUntil();
        
        if ($days == 0) {
            return "Today is {$this->name}. " . $this->getGreetingMessage();
        } elseif ($days == 1) {
            return "Tomorrow is {$this->name}. The office will be closed.";
        } else {
            return "{$this->name} is coming up in {$days} days (" . $this->date->format('l, F j, Y') . "). The office will be closed.";
        }
    }

    /**
     * Get display message for dashboard
     */
    public function getDashboardMessage()
    {
        if ($this->display_message) {
            return $this->display_message;
        }

        $days = $this->daysUntil();
        
        if ($days == 0) {
            return "<strong>{$this->name}</strong> - Today! " . $this->getGreetingMessage();
        } elseif ($days == 1) {
            return "<strong>{$this->name}</strong> - Tomorrow (" . $this->date->format('M d') . ")";
        } else {
            return "<strong>{$this->name}</strong> - " . $this->date->format('M d, Y') . " ({$days} days)";
        }
    }
}
