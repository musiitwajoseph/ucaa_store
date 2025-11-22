<?php

namespace App\Http\Controllers;

use App\Models\AuditLog;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AuditLogController extends Controller
{
    /**
     * Display audit logs.
     */
    public function index(Request $request)
    {
        // If it's a DataTables AJAX request
        if ($request->ajax()) {
            $query = AuditLog::with('user')->latest();

            // Apply filters
            if ($request->filled('user_id')) {
                $query->where('user_id', $request->user_id);
            }

            if ($request->filled('event')) {
                $query->where('event', $request->event);
            }

            if ($request->filled('date_from')) {
                $query->whereDate('created_at', '>=', $request->date_from);
            }

            if ($request->filled('date_to')) {
                $query->whereDate('created_at', '<=', $request->date_to);
            }

            if ($request->filled('search.value')) {
                $search = $request->input('search.value');
                $query->where(function ($q) use ($search) {
                    $q->where('description', 'like', "%{$search}%")
                        ->orWhere('url', 'like', "%{$search}%")
                        ->orWhere('ip_address', 'like', "%{$search}%")
                        ->orWhereHas('user', function($q) use ($search) {
                            $q->where('name', 'like', "%{$search}%");
                        });
                });
            }

            $totalRecords = AuditLog::count();
            $filteredRecords = $query->count();

            // Pagination
            $start = $request->input('start', 0);
            $length = $request->input('length', 10);
            
            $logs = $query->skip($start)->take($length)->get();

            $data = $logs->map(function ($log) {
                $badgeClass = match($log->event) {
                    'created' => 'bg-success',
                    'updated' => 'bg-info',
                    'deleted' => 'bg-danger',
                    'logged_in' => 'bg-primary',
                    'logged_out' => 'bg-secondary',
                    'exported' => 'bg-warning',
                    default => 'bg-secondary'
                };

                return [
                    'timestamp' => '<span class="d-block">' . $log->created_at->format('M d, Y') . '</span><span class="text-muted small">' . $log->created_at->format('h:i A') . '</span>',
                    'user' => $log->user ? '<span class="fw-semibold">' . $log->user->name . '</span>' : '<span class="text-muted">System</span>',
                    'event' => '<span class="badge ' . $badgeClass . '">' . ucfirst(str_replace('_', ' ', $log->event)) . '</span>',
                    'description' => '<span class="d-block">' . \Str::limit($log->description ?? 'N/A', 60) . '</span>' . 
                                   ($log->auditable_type ? '<small class="text-muted">' . class_basename($log->auditable_type) . '</small>' : ''),
                    'ip_address' => $log->ip_address,
                    'action' => '<a href="' . route('audit-logs.show', $log->id) . '" class="btn btn-sm btn-light"><i class="ph-eye"></i></a>',
                ];
            });

            return response()->json([
                'draw' => intval($request->input('draw')),
                'recordsTotal' => $totalRecords,
                'recordsFiltered' => $filteredRecords,
                'data' => $data
            ]);
        }

        // Get filter options
        $users = User::select('id', 'name')->orderBy('name')->get();
        $events = AuditLog::select('event')->distinct()->pluck('event');
        $modelTypes = AuditLog::select('auditable_type')->distinct()->whereNotNull('auditable_type')->pluck('auditable_type');

        // Get statistics
        $stats = [
            'total_logs' => AuditLog::count(),
            'today_logs' => AuditLog::whereDate('created_at', today())->count(),
            'unique_users' => AuditLog::distinct('user_id')->count('user_id'),
            'events_count' => AuditLog::distinct('event')->count('event'),
        ];

        return view('audit-logs.index', compact('users', 'events', 'modelTypes', 'stats'));
    }

    /**
     * Show a specific audit log.
     */
    public function show($id)
    {
        $log = AuditLog::with('user', 'auditable')->findOrFail($id);
        
        return view('audit-logs.show', compact('log'));
    }

    /**
     * Show audit logs for a specific model.
     */
    public function forModel(Request $request)
    {
        $type = $request->get('type');
        $id = $request->get('id');

        if (!$type || !$id) {
            abort(400, 'Missing type or id parameter');
        }

        $logs = AuditLog::where('auditable_type', $type)
            ->where('auditable_id', $id)
            ->with('user')
            ->latest()
            ->paginate(20);

        return view('audit-logs.model', compact('logs', 'type', 'id'));
    }

    /**
     * Get activity statistics.
     */
    public function statistics()
    {
        // Activity by event type
        $eventStats = AuditLog::select('event', DB::raw('count(*) as count'))
            ->groupBy('event')
            ->orderByDesc('count')
            ->get();

        // Activity by user (top 10)
        $userStats = AuditLog::select('user_id', DB::raw('count(*) as count'))
            ->whereNotNull('user_id')
            ->groupBy('user_id')
            ->orderByDesc('count')
            ->take(10)
            ->with('user:id,name')
            ->get();

        // Activity by day (last 30 days) - SQL Server compatible
        $dailyStats = AuditLog::select(DB::raw('CAST(created_at AS DATE) as date'), DB::raw('count(*) as count'))
            ->where('created_at', '>=', now()->subDays(30))
            ->groupBy(DB::raw('CAST(created_at AS DATE)'))
            ->orderBy('date')
            ->get();

        // Activity by model type
        $modelStats = AuditLog::select('auditable_type', DB::raw('count(*) as count'))
            ->whereNotNull('auditable_type')
            ->groupBy('auditable_type')
            ->orderByDesc('count')
            ->get()
            ->map(function ($item) {
                $item->model_name = class_basename($item->auditable_type);
                return $item;
            });

        return view('audit-logs.statistics', compact('eventStats', 'userStats', 'dailyStats', 'modelStats'));
    }

    /**
     * Clear old audit logs.
     */
    public function clear(Request $request)
    {
        $request->validate([
            'days' => 'required|integer|min:1',
        ]);

        $deletedCount = AuditLog::where('created_at', '<', now()->subDays($request->days))->delete();

        return redirect()->back()->with('success', "Deleted {$deletedCount} audit logs older than {$request->days} days.");
    }
}

