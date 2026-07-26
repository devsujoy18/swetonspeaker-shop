<?php

namespace App\Support;

use Illuminate\Support\Str;

class ImageUrl
{
    public static function mainSite(?string $path = null): string
    {
        $host = rtrim((string) config('app.img_host'), '/');

        if ($path === null || $path === '') {
            return $host.'/';
        }

        return $host.'/'.ltrim($path, '/');
    }

    public static function upload(?string $path): string
    {
        if (! $path) {
            return self::placeholder();
        }

        if (Str::startsWith($path, ['http://', 'https://', '//'])) {
            return $path;
        }

        return self::mainSite('uploads/'.ltrim($path, '/'));
    }

    public static function thumbnail(?string $path): string
    {
        if (! $path) {
            return self::placeholder();
        }

        return self::upload('thumbnails/'.ltrim($path, '/'));
    }

    public static function placeholder(): string
    {
        return asset('image/buy.jpg');
    }
}
