<?php

namespace PtrSoc\Application\Services;

use PtrSoc\Domain\Contracts\Cache;

/**
 * CacheService for caching data and fragments
 */
class CacheService
{
    /**
     * CacheService constructor.
     *
     * @param Cache $driver Implementation of the cache driver used.
     */
    public function __construct(private Cache $driver) {}

    /**
     * Fetch data from cache if it exists, otherwise store the result of the callback to cache.
     *
     * @param string   $key       Unique cache key
     * @param callable $callback  Callback to generate data if cache is empty.
     * @param string   $group     (Optional) Group cache for namespace separation.
     * @param int      $ttl       (Optional) Time to live for cache in seconds.
     *
     * @return mixed Returns the cached value or the result of the callback.
     */
    public function remember(string $key, callable $callback, string $group = '', int $ttl = 3600)
    {
        if ($this->driver->has($key, $group)) {
            return $this->driver->get($key, $group);
        }

        $value = $callback();
        $this->driver->set($key, $value, $group, $ttl);
        return $value;
    }

    /**
     * Render HTML fragments with cache.
     *
     * If the fragment is already in the cache, it is displayed immediately.
     * Otherwise, run the callback, cache the result, and then display it.
     *
     * @param string   $key       Unique cache key
     * @param callable $callback  Callback that produces HTML output.
     * @param string   $group     (Optional) Group cache for namespace separation.
     * @param int      $ttl       (Optional) Time to live for cache in seconds.
     *
     * @return void
     */
    public function fragment(string $key, callable $callback, string $group = '', int $ttl = 3600): void
    {
        if ($this->driver->has($key, $group)) {
            echo $this->driver->get($key, $group);
            return;
        }

        ob_start();

        if ($callback) {
            $callback();
        }

        $output = ob_get_clean();
        $this->driver->set($key, $output, $group, $ttl);
        echo $output;
    }
}
