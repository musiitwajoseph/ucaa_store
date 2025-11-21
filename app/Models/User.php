<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use LdapRecord\Laravel\Auth\LdapAuthenticatable;
use LdapRecord\Laravel\Auth\AuthenticatesWithLdap;
use App\Traits\Auditable;

class User extends Authenticatable implements LdapAuthenticatable
{
    use HasFactory, Notifiable, AuthenticatesWithLdap, Auditable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        // Basic Information
        'code',
        'name',
        'first_name',
        'last_name',
        'email',
        'username',
        'password',
        
        // LDAP Fields
        'guid',
        'domain',
        'ldap_dn',
        'ldap_synced_at',
        
        // Contact Information
        'phone',
        'mobile',
        'address',
        'city',
        'state',
        'country',
        'postal_code',
        
        // Organization Information (Foreign Keys)
        'department_id',
        'job_title_id',
        'office_location_id',
        'employee_id',
        'manager_id',
        
        // Profile Information
        'avatar',
        'bio',
        'date_of_birth',
        'gender',
        
        // Account Status
        'status',
        'is_active',
        'is_admin',
        'is_ldap_user',
        'email_verified_at',
        'last_login_at',
        'last_login_ip',
        
        // Preferences
        'locale',
        'timezone',
        'theme',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'guid',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'last_login_at' => 'datetime',
            'ldap_synced_at' => 'datetime',
            'date_of_birth' => 'date',
            'is_active' => 'boolean',
            'is_admin' => 'boolean',
            'is_ldap_user' => 'boolean',
        ];
    }

    /**
     * Get the full name of the user.
     */
    public function getFullNameAttribute(): string
    {
        return trim("{$this->first_name} {$this->last_name}") ?: $this->name;
    }

    /**
     * Get the user's initials.
     */
    public function getInitialsAttribute(): string
    {
        $firstInitial = $this->first_name ? substr($this->first_name, 0, 1) : '';
        $lastInitial = $this->last_name ? substr($this->last_name, 0, 1) : '';
        
        return strtoupper($firstInitial . $lastInitial) ?: strtoupper(substr($this->name, 0, 2));
    }

    /**
     * Get the user's avatar URL.
     */
    public function getAvatarUrlAttribute(): string
    {
        if ($this->avatar) {
            return asset('storage/' . $this->avatar);
        }
        
        // Default avatar with initials
        return 'https://ui-avatars.com/api/?name=' . urlencode($this->fullName) . '&color=7F9CF5&background=EBF4FF';
    }

    /**
     * Check if the user is an administrator.
     */
    public function isAdmin(): bool
    {
        return (bool) $this->is_admin;
    }

    /**
     * Check if the user is active.
     */
    public function isActive(): bool
    {
        return (bool) $this->is_active;
    }

    /**
     * Check if the user authenticates via LDAP.
     */
    public function isLdapUser(): bool
    {
        return (bool) $this->is_ldap_user;
    }

    /**
     * Scope a query to only include active users.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope a query to only include admin users.
     */
    public function scopeAdmins($query)
    {
        return $query->where('is_admin', true);
    }

    /**
     * Scope a query to only include LDAP users.
     */
    public function scopeLdapUsers($query)
    {
        return $query->where('is_ldap_user', true);
    }

    /**
     * Get the manager of this user.
     */
    public function manager()
    {
        return $this->belongsTo(User::class, 'manager_id');
    }

    /**
     * Get the subordinates of this user.
     */
    public function subordinates()
    {
        return $this->hasMany(User::class, 'manager_id');
    }

    /**
     * Get all attachments uploaded by this user.
     */
    public function uploadedAttachments()
    {
        return $this->hasMany(Attachment::class, 'uploaded_by');
    }

    /**
     * Get the user's department.
     */
    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    /**
     * Get the user's job title.
     */
    public function jobTitle()
    {
        return $this->belongsTo(JobTitle::class);
    }

    /**
     * Get the user's office location.
     */
    public function officeLocation()
    {
        return $this->belongsTo(OfficeLocation::class);
    }

    /**
     * Get all roles assigned to the user.
     */
    public function roles()
    {
        return $this->belongsToMany(Role::class, 'role_user')
                    ->withPivot('assigned_by', 'assigned_at')
                    ->withTimestamps();
    }

    /**
     * Check if user has a specific role.
     */
    public function hasRole($roleCode)
    {
        return $this->roles()->where('code', $roleCode)->exists();
    }

    /**
     * Check if user has any of the given roles.
     */
    public function hasAnyRole($roles)
    {
        return $this->roles()->whereIn('code', (array) $roles)->exists();
    }

    /**
     * Check if user has all of the given roles.
     */
    public function hasAllRoles($roles)
    {
        $roles = (array) $roles;
        return $this->roles()->whereIn('code', $roles)->count() === count($roles);
    }

    /**
     * Assign a role to the user.
     */
    public function assignRole($role)
    {
        if (is_string($role)) {
            $role = Role::where('code', $role)->firstOrFail();
        }

        if (!$this->roles()->where('role_id', $role->id)->exists()) {
            $this->roles()->attach($role->id, [
                'assigned_by' => auth()->id(),
                'assigned_at' => now(),
            ]);
        }

        return $this;
    }

    /**
     * Remove a role from the user.
     */
    public function removeRole($role)
    {
        if (is_string($role)) {
            $role = Role::where('code', $role)->firstOrFail();
        }

        $this->roles()->detach($role->id);

        return $this;
    }

    /**
     * Sync user roles.
     */
    public function syncRoles($roles)
    {
        $roleIds = collect($roles)->map(function ($role) {
            if (is_string($role)) {
                return Role::where('code', $role)->firstOrFail()->id;
            }
            return is_object($role) ? $role->id : $role;
        })->toArray();

        $syncData = [];
        foreach ($roleIds as $roleId) {
            $syncData[$roleId] = [
                'assigned_by' => auth()->id(),
                'assigned_at' => now(),
            ];
        }

        $this->roles()->sync($syncData);

        return $this;
    }

    /**
     * Check if user has a specific permission through any of their roles.
     */
    public function hasPermission($permission)
    {
        // Check direct permissions first
        if ($this->hasDirectPermission($permission)) {
            return true;
        }

        // Check role permissions
        return $this->roles->contains(function ($role) use ($permission) {
            return $role->hasPermission($permission);
        });
    }

    /**
     * Get all direct permissions assigned to the user.
     */
    public function permissions()
    {
        return $this->belongsToMany(Permission::class, 'permission_user')
                    ->withPivot('assigned_by', 'assigned_at')
                    ->withTimestamps();
    }

    /**
     * Check if user has a direct permission (not through a role).
     */
    public function hasDirectPermission($permission)
    {
        if (is_string($permission)) {
            return $this->permissions()->where('code', $permission)->exists();
        }
        
        return $this->permissions()->where('id', $permission->id)->exists();
    }

    /**
     * Give a direct permission to the user.
     */
    public function givePermission($permission)
    {
        if (is_string($permission)) {
            $permission = Permission::where('code', $permission)->firstOrFail();
        }

        if (!$this->permissions()->where('permission_id', $permission->id)->exists()) {
            $this->permissions()->attach($permission->id, [
                'assigned_by' => auth()->id(),
                'assigned_at' => now(),
            ]);
        }
        
        return $this;
    }

    /**
     * Revoke a direct permission from the user.
     */
    public function revokePermission($permission)
    {
        if (is_string($permission)) {
            $permission = Permission::where('code', $permission)->firstOrFail();
        }

        $this->permissions()->detach($permission->id);
        
        return $this;
    }

    /**
     * Sync direct permissions for the user.
     */
    public function syncPermissions($permissions)
    {
        $permissionIds = collect($permissions)->map(function ($permission) {
            if (is_string($permission)) {
                return Permission::where('code', $permission)->firstOrFail()->id;
            }
            return is_object($permission) ? $permission->id : $permission;
        })->toArray();

        $syncData = [];
        foreach ($permissionIds as $permissionId) {
            $syncData[$permissionId] = [
                'assigned_by' => auth()->id(),
                'assigned_at' => now(),
            ];
        }

        $this->permissions()->sync($syncData);

        return $this;
    }

    /**
     * Get all permissions (both from roles and direct).
     */
    public function getAllPermissions()
    {
        // Get direct permissions
        $directPermissions = $this->permissions;

        // Get permissions from roles
        $rolePermissions = $this->roles->flatMap(function ($role) {
            return $role->permissions;
        });

        // Merge and remove duplicates
        return $directPermissions->merge($rolePermissions)->unique('id');
    }

    /**
     * Update the last login timestamp and IP.
     */
    public function updateLastLogin(string $ip): void
    {
        $this->update([
            'last_login_at' => now(),
            'last_login_ip' => $ip,
        ]);
    }

    /**
     * Sync user data from LDAP.
     */
    public function syncFromLdap(array $ldapData): void
    {
        $this->update([
            'ldap_synced_at' => now(),
            // Add more LDAP field mappings as needed
        ]);
    }
}
