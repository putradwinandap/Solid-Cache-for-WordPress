<?php

namespace PtrSoc\Application\Services;

use PtrSoc\Domain\Contracts\Cache;

class CacheService
{
    public function __construct(private Cache $driver) {}

    public function remember(string $key, callable $callback, string $group = '', int $ttl = 3600)
    {
        if ($this->driver->has($key, $group)) {
            return $this->driver->get($key, $group);
        }

        $value = $callback();
        $this->driver->set($key, $value, $group, $ttl);
        return $value;
    }

    public function fragment(string $key, callable $fallback, string $group = '', int $ttl = 3600): void
    {
        if ($this->driver->has($key, $group)) {
            echo $this->driver->get($key, $group);
            return;
        }

        ob_start();

        if ($fallback) {
            $fallback();
        }

        $output = ob_get_clean();
        $this->driver->set($key, $output, $group, $ttl);
        echo $output;
    }
}
