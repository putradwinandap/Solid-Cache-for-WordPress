<?php

namespace PtrSoc\Interfaces\Providers;

use PtrSoc\Domain\Contracts\Cache;
use PtrSoc\Interfaces\WordPress\Ajax\AjaxRouter;
use PtrSoc\Interfaces\WordPress\Ajax\Handlers\FlushCache;

class AjaxServiceProvider
{

    public function __construct(private Cache $cache) {}

    public function register()
    {
        $routes = [];

        $routes[] = new FlushCache($this->cache);

        $ajaxRouter = new AjaxRouter($routes);
        $ajaxRouter->register();
    }
}
