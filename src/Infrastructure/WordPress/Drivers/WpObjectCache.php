<?php

namespace PtrSoc\Infrastructure\WordPress\Drivers;

use PtrSoc\Domain\Contracts\Cache;

class WpObjectCache implements Cache
{
    public function get(string $key, string $group = '', $default = null)
    {
        $value = wp_cache_get($key, $group);
        return $value === false ? $default : $value;
    }

    public function set(string $key, $value, string $group = '', int $ttl = 0): bool
    {
        return wp_cache_set($key, $value, $group, $ttl);
    }

    public function delete(string $key, string $group = ''): bool
    {
        return wp_cache_delete($key, $group);
    }

    public function flush(string $group = ''): bool
    {
        if ($group) {
            return wp_cache_flush_group($group);
        }

        return wp_cache_flush();
    }

    public function has(string $key, string $group = ''): bool
    {
        return wp_cache_get($key, $group) !== false;
    }
}
