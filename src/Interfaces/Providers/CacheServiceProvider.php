<?php

namespace PtrSoc\Interfaces\Providers;

use PtrSoc\Domain\Contracts\Cache;
use PtrSoc\Application\Services\CacheService;

class CacheServiceProvider
{
    public function __construct(private Cache $driver)
    {
        
    }

    public function register()
    {
        add_action('init', function () {
            $driver = $this->driver;
            $service = new CacheService($driver);
            global $ptr_soc;
            $ptr_soc = $service;
        });
    }
}
