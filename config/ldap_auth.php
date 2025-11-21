<?php

return [
    /*
    |--------------------------------------------------------------------------
    | LDAP Authentication Connection
    |--------------------------------------------------------------------------
    |
    | The LDAP connection to use for authentication and importing.
    |
    */

    'connection' => env('LDAP_CONNECTION', 'default'),

    /*
    |--------------------------------------------------------------------------
    | LDAP Authentication Provider
    |--------------------------------------------------------------------------
    |
    | The LDAP authentication provider to use for authenticating users.
    |
    */

    'provider' => LdapRecord\Laravel\Auth\DatabaseUserProvider::class,

    /*
    |--------------------------------------------------------------------------
    | LDAP Authentication Rules
    |--------------------------------------------------------------------------
    |
    | Rules that are applied to users attempting to authenticate.
    |
    */

    'rules' => [
        // OnlyActiveUsers::class,
    ],

    /*
    |--------------------------------------------------------------------------
    | LDAP Authentication Database Synchronization
    |--------------------------------------------------------------------------
    |
    | Settings for synchronizing LDAP users into the local database.
    |
    */

    'sync_attributes' => [
        // LDAP Attribute => Database Column
        'cn' => 'name',
        'givenname' => 'first_name',
        'sn' => 'last_name',
        'mail' => 'email',
        'samaccountname' => 'username',
        'telephonenumber' => 'phone',
        'mobile' => 'mobile',
        'department' => 'department',
        'title' => 'job_title',
        'employeeid' => 'employee_id',
        'physicaldeliveryofficename' => 'office_location',
        'distinguishedname' => 'ldap_dn',
        'objectguid' => 'guid',
    ],

    /*
    |--------------------------------------------------------------------------
    | LDAP Password Sync
    |--------------------------------------------------------------------------
    |
    | When enabled, passwords will be synced to your database on successful
    | authentication. This allows users to login without LDAP in case
    | of an LDAP outage or for users that have been disabled.
    |
    */

    'password_sync' => env('LDAP_PASSWORD_SYNC', false),

    /*
    |--------------------------------------------------------------------------
    | Login Fallback
    |--------------------------------------------------------------------------
    |
    | When login fallback is enabled, users can login with their database
    | password if LDAP authentication fails. This is useful for local
    | administrators or when LDAP is temporarily unavailable.
    |
    */

    'login_fallback' => env('LDAP_LOGIN_FALLBACK', false),

    /*
    |--------------------------------------------------------------------------
    | LDAP Locate Users By
    |--------------------------------------------------------------------------
    |
    | This value is the attribute to locate users by in your LDAP directory.
    |
    */

    'locate_users_by' => 'samaccountname',

    /*
    |--------------------------------------------------------------------------
    | Bind Users To Credentials
    |--------------------------------------------------------------------------
    |
    | If enabled, users will be bound to their credentials with the
    | given attribute during authentication.
    |
    */

    'bind_users_by' => 'distinguishedname',

    /*
    |--------------------------------------------------------------------------
    | LDAP User Model
    |--------------------------------------------------------------------------
    |
    | The model that represents your LDAP users.
    |
    */

    'model' => LdapRecord\Models\ActiveDirectory\User::class,

    /*
    |--------------------------------------------------------------------------
    | LDAP User Database Model
    |--------------------------------------------------------------------------
    |
    | The Eloquent model that LDAP users will be synchronized to.
    |
    */

    'database' => [
        'model' => App\Models\User::class,
        'password_column' => 'password',
    ],

    /*
    |--------------------------------------------------------------------------
    | Domain Verification
    |--------------------------------------------------------------------------
    |
    | When enabled, usernames that contain an "@" symbol will have their
    | domain validated to ensure it matches the configured domains.
    |
    */

    'domain_verification' => env('LDAP_DOMAIN_VERIFICATION', false),

    /*
    |--------------------------------------------------------------------------
    | LDAP User Resolver
    |--------------------------------------------------------------------------
    |
    | The class responsible for resolving LDAP users from their credentials.
    |
    */

    'resolver' => LdapRecord\Laravel\Auth\UserResolver::class,

    /*
    |--------------------------------------------------------------------------
    | Username Attribute
    |--------------------------------------------------------------------------
    |
    | This value is the name of the database column that will be used
    | to locate users for authentication.
    |
    */

    'username' => 'email',

    /*
    |--------------------------------------------------------------------------
    | Import LDAP Users on Login
    |--------------------------------------------------------------------------
    |
    | When enabled, LDAP users will be imported into your database
    | on successful authentication if they don't already exist.
    |
    */

    'import' => env('LDAP_IMPORT_USERS', true),
];
