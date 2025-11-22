<?php

namespace App\Helpers;

use App\Models\AuditLog;
use Illuminate\Support\Facades\Auth;

class AuditHelper
{
    /**
     * Log a custom audit event.
     */
    public static function log($event, $description, $auditable = null, $data = [])
    {
        return AuditLog::create([
            'user_id' => Auth::id(),
            'event' => $event,
            'auditable_type' => $auditable ? get_class($auditable) : null,
            'auditable_id' => $auditable ? $auditable->id : null,
            'old_values' => $data['old'] ?? null,
            'new_values' => $data['new'] ?? null,
            'url' => request()->fullUrl(),
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
            'description' => $description,
        ]);
    }

    /**
     * Log a login event.
     */
    public static function logLogin($user)
    {
        return self::log('logged_in', "User logged in", $user);
    }

    /**
     * Log a logout event.
     */
    public static function logLogout($user)
    {
        return self::log('logged_out', "User logged out", $user);
    }

    /**
     * Log a failed login attempt.
     */
    public static function logFailedLogin($email)
    {
        return AuditLog::create([
            'user_id' => null,
            'event' => 'login_failed',
            'auditable_type' => null,
            'auditable_id' => null,
            'old_values' => null,
            'new_values' => ['email' => $email],
            'url' => request()->fullUrl(),
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
            'description' => "Failed login attempt for: {$email}",
        ]);
    }

    /**
     * Log a permission denied event.
     */
    public static function logPermissionDenied($permission, $resource = null)
    {
        return self::log(
            'permission_denied',
            "Access denied to {$permission}" . ($resource ? " for {$resource}" : ''),
            null,
            ['permission' => $permission, 'resource' => $resource]
        );
    }

    /**
     * Log an export event.
     */
    public static function logExport($type, $format)
    {
        return self::log('exported', "Exported {$type} as {$format}");
    }

    /**
     * Log a download event.
     */
    public static function logDownload($filename)
    {
        return self::log('downloaded', "Downloaded file: {$filename}");
    }

    /**
     * Log a bulk action.
     */
    public static function logBulkAction($action, $count, $type)
    {
        return self::log(
            'bulk_' . $action,
            "Bulk {$action} {$count} {$type}",
            null,
            ['count' => $count, 'type' => $type]
        );
    }

    /**
     * Get audit logs for a specific model.
     */
    public static function getLogsForModel($model)
    {
        return AuditLog::where('auditable_type', get_class($model))
            ->where('auditable_id', $model->id)
            ->with('user')
            ->latest()
            ->get();
    }

    /**
     * Get recent activity.
     */
    public static function getRecentActivity($limit = 20)
    {
        return AuditLog::with('user', 'auditable')
            ->latest()
            ->limit($limit)
            ->get();
    }

    /**
     * Get activity for a specific user.
     */
    public static function getUserActivity($userId, $limit = 50)
    {
        return AuditLog::where('user_id', $userId)
            ->with('auditable')
            ->latest()
            ->limit($limit)
            ->get();
    }
}
