<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Application Version
    |--------------------------------------------------------------------------
    |
    | This value represents the current version of the application.
    | Use Semantic Versioning (SemVer): MAJOR.MINOR.PATCH
    |
    | MAJOR: Incompatible API changes
    | MINOR: New functionality in a backwards compatible manner
    | PATCH: Backwards compatible bug fixes
    |
    */

    'current' => env('APP_VERSION', '1.0.0'),

    /*
    |--------------------------------------------------------------------------
    | Version Release Date
    |--------------------------------------------------------------------------
    |
    | The date when the current version was released.
    |
    */

    'release_date' => env('APP_VERSION_DATE', '2025-11-22'),

    /*
    |--------------------------------------------------------------------------
    | Version Display Format
    |--------------------------------------------------------------------------
    |
    | How the version should be displayed in the UI.
    | Options: 'short' (1.0.0), 'full' (v1.0.0), 'detailed' (Version 1.0.0)
    |
    */

    'display_format' => env('APP_VERSION_FORMAT', 'short'),

    /*
    |--------------------------------------------------------------------------
    | Show Version in Footer
    |--------------------------------------------------------------------------
    |
    | Whether to display the version number in the application footer.
    |
    */

    'show_in_footer' => env('APP_VERSION_SHOW_FOOTER', true),

    /*
    |--------------------------------------------------------------------------
    | Show Version in Dashboard
    |--------------------------------------------------------------------------
    |
    | Whether to display the version number in the dashboard.
    |
    */

    'show_in_dashboard' => env('APP_VERSION_SHOW_DASHBOARD', true),

    /*
    |--------------------------------------------------------------------------
    | Version History
    |--------------------------------------------------------------------------
    |
    | Track major version changes and their release notes.
    |
    */

    'history' => [
        '1.0.0' => [
            'date' => '2025-11-22',
            'type' => 'major',
            'changes' => [
                'Initial release',
                'User management system',
                'Role-based access control (RBAC)',
                'Department and job title management',
                'Office location management',
                'Audit trail system',
                'Comprehensive reporting',
                'Profile management',
                'Notification system',
            ],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Environment-Specific Versioning
    |--------------------------------------------------------------------------
    |
    | Different version formats for different environments.
    |
    */

    'environment_suffix' => [
        'local' => '-dev',
        'testing' => '-test',
        'staging' => '-staging',
        'production' => '',
    ],
];
