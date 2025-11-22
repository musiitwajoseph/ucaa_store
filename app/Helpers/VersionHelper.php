<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Config;

class VersionHelper
{
    /**
     * Get the current application version.
     *
     * @return string
     */
    public static function current(): string
    {
        return Config::get('version.current', '1.0.0');
    }

    /**
     * Get the formatted version string.
     *
     * @param string|null $format
     * @return string
     */
    public static function formatted(?string $format = null): string
    {
        $version = self::current();
        $format = $format ?? Config::get('version.display_format', 'short');
        $env = app()->environment();
        $suffix = Config::get("version.environment_suffix.{$env}", '');

        return match($format) {
            'full' => "v{$version}{$suffix}",
            'detailed' => "Version {$version}{$suffix}",
            'short' => "{$version}{$suffix}",
            default => "{$version}{$suffix}",
        };
    }

    /**
     * Get the version release date.
     *
     * @return string
     */
    public static function releaseDate(): string
    {
        return Config::get('version.release_date', now()->format('Y-m-d'));
    }

    /**
     * Get the version history.
     *
     * @return array
     */
    public static function history(): array
    {
        return Config::get('version.history', []);
    }

    /**
     * Get changelog for a specific version.
     *
     * @param string|null $version
     * @return array|null
     */
    public static function changelog(?string $version = null): ?array
    {
        $version = $version ?? self::current();
        return Config::get("version.history.{$version}");
    }

    /**
     * Get all version numbers.
     *
     * @return array
     */
    public static function allVersions(): array
    {
        return array_keys(self::history());
    }

    /**
     * Check if version should be shown in footer.
     *
     * @return bool
     */
    public static function showInFooter(): bool
    {
        return Config::get('version.show_in_footer', true);
    }

    /**
     * Check if version should be shown in dashboard.
     *
     * @return bool
     */
    public static function showInDashboard(): bool
    {
        return Config::get('version.show_in_dashboard', true);
    }

    /**
     * Compare version numbers.
     *
     * @param string $version1
     * @param string $version2
     * @return int Returns -1 if v1 < v2, 0 if equal, 1 if v1 > v2
     */
    public static function compare(string $version1, string $version2): int
    {
        return version_compare($version1, $version2);
    }

    /**
     * Check if current version is greater than or equal to specified version.
     *
     * @param string $version
     * @return bool
     */
    public static function isAtLeast(string $version): bool
    {
        return self::compare(self::current(), $version) >= 0;
    }

    /**
     * Get version badge HTML.
     *
     * @param string|null $class
     * @return string
     */
    public static function badge(?string $class = 'badge bg-primary'): string
    {
        $version = self::formatted('full');
        return "<span class=\"{$class}\">{$version}</span>";
    }

    /**
     * Get build information.
     *
     * @return array
     */
    public static function buildInfo(): array
    {
        return [
            'version' => self::current(),
            'formatted' => self::formatted(),
            'release_date' => self::releaseDate(),
            'environment' => app()->environment(),
            'php_version' => PHP_VERSION,
            'laravel_version' => app()->version(),
        ];
    }
}
