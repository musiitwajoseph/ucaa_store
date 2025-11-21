<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use LdapRecord\Laravel\Auth\LdapAuthenticatable;
use LdapRecord\Laravel\Auth\AuthenticatesWithLdap;

class User extends Authenticatable implements LdapAuthenticatable
{
    use HasFactory, Notifiable, AuthenticatesWithLdap;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        // Basic Information
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
        
        // Organization Information
        'department',
        'job_title',
        'employee_id',
        'manager_id',
        'office_location',
        
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
