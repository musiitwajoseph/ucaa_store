<?php

namespace App\Traits;

use App\Models\AuditLog;
use Illuminate\Support\Facades\Auth;

trait Auditable
{
    /**
     * Boot the auditable trait.
     */
    protected static function bootAuditable()
    {
        // Track creation
        static::created(function ($model) {
            $model->auditCreation();
        });

        // Track updates
        static::updated(function ($model) {
            $model->auditUpdate();
        });

        // Track deletion
        static::deleted(function ($model) {
            $model->auditDeletion();
        });

        // Track restoration (soft delete)
        if (method_exists(static::class, 'restored')) {
            static::restored(function ($model) {
                $model->auditRestoration();
            });
        }
    }

    /**
     * Log the creation event.
     */
    protected function auditCreation()
    {
        AuditLog::create([
            'auditable_type' => get_class($this),
            'auditable_id' => $this->id,
            'event' => 'created',
            'user_id' => Auth::id(),
            'new_values' => $this->getAuditableAttributes(),
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
            'url' => request()->fullUrl(),
        ]);
    }

    /**
     * Log the update event.
     */
    protected function auditUpdate()
    {
        $changes = $this->getChanges();
        
        // Don't log if only timestamps changed
        if (empty($changes) || (count($changes) <= 2 && isset($changes['updated_at']))) {
            return;
        }

        AuditLog::create([
            'auditable_type' => get_class($this),
            'auditable_id' => $this->id,
            'event' => 'updated',
            'user_id' => Auth::id(),
            'old_values' => $this->getOriginal(),
            'new_values' => $this->getAttributes(),
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
            'url' => request()->fullUrl(),
        ]);
    }

    /**
     * Log the deletion event.
     */
    protected function auditDeletion()
    {
        AuditLog::create([
            'auditable_type' => get_class($this),
            'auditable_id' => $this->id,
            'event' => 'deleted',
            'user_id' => Auth::id(),
            'old_values' => $this->getAuditableAttributes(),
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
            'url' => request()->fullUrl(),
        ]);
    }

    /**
     * Log the restoration event.
     */
    protected function auditRestoration()
    {
        AuditLog::create([
            'auditable_type' => get_class($this),
            'auditable_id' => $this->id,
            'event' => 'restored',
            'user_id' => Auth::id(),
            'new_values' => $this->getAuditableAttributes(),
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
            'url' => request()->fullUrl(),
        ]);
    }

    /**
     * Get auditable attributes.
     */
    protected function getAuditableAttributes()
    {
        $attributes = $this->getAttributes();
        
        // Exclude certain attributes from audit
        $excluded = ['password', 'remember_token', 'created_at', 'updated_at'];
        
        return array_diff_key($attributes, array_flip($excluded));
    }

    /**
     * Get all audit logs for this model.
     */
    public function auditLogs()
    {
        return $this->morphMany(AuditLog::class, 'auditable')->latest();
    }

    /**
     * Get recent changes.
     */
    public function recentChanges($limit = 10)
    {
        return $this->auditLogs()->with('user')->limit($limit)->get();
    }
}
