<?php

namespace App\Http\Controllers;

use App\Models\PublicHoliday;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PublicHolidayController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:public-holidays-view')->only(['index', 'show']);
        $this->middleware('permission:public-holidays-create')->only(['create', 'store']);
        $this->middleware('permission:public-holidays-edit')->only(['edit', 'update']);
        $this->middleware('permission:public-holidays-delete')->only(['destroy']);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $holidays = PublicHoliday::query();

            return datatables()->eloquent($holidays)
                ->addColumn('date_formatted', function($holiday) {
                    $displayDate = $holiday->getDisplayDate();
                    $formatted = $displayDate->format('l, F j, Y');
                    if ($holiday->is_recurring) {
                        $formatted .= ' <small class="text-muted">(Recurring)</small>';
                    }
                    return $formatted;
                })
                ->addColumn('type_badge', function($holiday) {
                    $colors = [
                        'public' => 'primary',
                        'religious' => 'info',
                        'internal' => 'warning'
                    ];
                    $color = $colors[$holiday->type] ?? 'secondary';
                    return '<span class="badge bg-'.$color.'">'.ucfirst($holiday->type).'</span>';
                })
                ->addColumn('status', function($holiday) {
                    return $holiday->is_active
                        ? '<span class="badge bg-success">Active</span>'
                        : '<span class="badge bg-danger">Inactive</span>';
                })
                ->addColumn('recurring', function($holiday) {
                    return $holiday->is_recurring
                        ? '<span class="badge bg-success">Yes</span>'
                        : '<span class="badge bg-secondary">No</span>';
                })
                ->addColumn('days_until', function($holiday) {
                    $days = $holiday->daysUntil();
                    if ($days < 0) {
                        return '<span class="text-muted">Past</span>';
                    } elseif ($days == 0) {
                        return '<span class="badge bg-success">Today</span>';
                    } elseif ($days == 1) {
                        return '<span class="badge bg-warning">Tomorrow</span>';
                    } else {
                        return '<span class="text-muted">'.$days.' days</span>';
                    }
                })
                ->addColumn('notification_period', function($holiday) {
                    if ($holiday->notification_start_date && $holiday->notification_end_date) {
                        return '<small class="text-muted">'.
                               $holiday->notification_start_date->format('M d').' - '.
                               $holiday->notification_end_date->format('M d').'</small>';
                    }
                    return '<span class="text-muted">-</span>';
                })
                ->addColumn('dashboard', function($holiday) {
                    return $holiday->show_on_dashboard
                        ? '<span class="badge bg-success">Yes</span>'
                        : '<span class="badge bg-secondary">No</span>';
                })
                ->addColumn('actions', function($holiday) {
                    $actions = '<div class="dropdown">
                        <button type="button" class="btn btn-sm btn-light" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="ph-dots-three-vertical"></i>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end">';
                    
                    if (Auth::user()->can('public-holidays-edit')) {
                        $actions .= '<li>
                            <a class="dropdown-item" href="'.route('public-holidays.edit', $holiday).'">
                                <i class="ph-pencil me-2"></i> Edit
                            </a>
                        </li>';
                    }
                    
                    if (Auth::user()->can('public-holidays-delete')) {
                        if (Auth::user()->can('public-holidays-edit')) {
                            $actions .= '<li><hr class="dropdown-divider"></li>';
                        }
                        $actions .= '<li>
                            <a class="dropdown-item text-danger" href="#" onclick="event.preventDefault(); deleteHoliday('.$holiday->id.');">
                                <i class="ph-trash me-2"></i> Delete
                            </a>
                        </li>';
                    }
                    
                    $actions .= '</ul></div>';
                    return $actions;
                })
                ->rawColumns(['date_formatted', 'type_badge', 'status', 'recurring', 'days_until', 'notification_period', 'dashboard', 'actions'])
                ->make(true);
        }

        $stats = [
            'total' => PublicHoliday::count(),
            'upcoming' => PublicHoliday::upcoming(90)->count(),
            'today' => PublicHoliday::today()->count(),
        ];

        return view('public-holidays.index', compact('stats'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('public-holidays.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'date' => 'required|date',
            'type' => 'required|in:public,religious,internal',
            'description' => 'nullable|string',
            'display_message' => 'nullable|string',
            'notification_start_date' => 'nullable|date|before_or_equal:notification_end_date',
            'notification_end_date' => 'nullable|date|after_or_equal:notification_start_date',
            'show_on_dashboard' => 'boolean',
            'is_recurring' => 'boolean',
            'is_active' => 'boolean',
            'reminder_days' => 'required|integer|min:0|max:30',
        ]);

        $validated['is_recurring'] = $request->has('is_recurring');
        $validated['is_active'] = $request->has('is_active');
        $validated['show_on_dashboard'] = $request->has('show_on_dashboard');

        PublicHoliday::create($validated);

        return redirect()->route('public-holidays.index')
            ->with('success', 'Holiday created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(PublicHoliday $publicHoliday)
    {
        return view('public-holidays.show', compact('publicHoliday'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PublicHoliday $publicHoliday)
    {
        return view('public-holidays.edit', compact('publicHoliday'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PublicHoliday $publicHoliday)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'date' => 'required|date',
            'type' => 'required|in:public,religious,internal',
            'description' => 'nullable|string',
            'display_message' => 'nullable|string',
            'notification_start_date' => 'nullable|date|before_or_equal:notification_end_date',
            'notification_end_date' => 'nullable|date|after_or_equal:notification_start_date',
            'show_on_dashboard' => 'boolean',
            'is_recurring' => 'boolean',
            'is_active' => 'boolean',
            'reminder_days' => 'required|integer|min:0|max:30',
        ]);

        $validated['is_recurring'] = $request->has('is_recurring');
        $validated['is_active'] = $request->has('is_active');
        $validated['show_on_dashboard'] = $request->has('show_on_dashboard');

        $publicHoliday->update($validated);

        return redirect()->route('public-holidays.index')
            ->with('success', 'Holiday updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PublicHoliday $publicHoliday)
    {
        $publicHoliday->delete();

        return redirect()->route('public-holidays.index')
            ->with('success', 'Holiday deleted successfully.');
    }
}
