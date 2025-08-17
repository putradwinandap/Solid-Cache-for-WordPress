<?php

namespace PtrSoc\Infrastructure\WordPress;

use PtrSoc\Domain\Contracts\Cache;

final class CacheFactory
{
    public static function make(CacheConfig $config): Cache
    {
        $driver = $config->driver();

        switch ($driver) {
            case 'disk':
                return new Drivers\DiskCache();
            case 'wp_object_cache':
                return new Drivers\WpObjectCache();
            default:
                throw new \InvalidArgumentException("Unsupported cache driver: {$driver}");
        }
    }
}
