<?php
require_once __DIR__ . '/vendor/autoload.php';

use PtrSoc\Infrastructure\WordPress\CacheConfig;
use PtrSoc\Infrastructure\WordPress\CacheFactory;
use PtrSoc\Interfaces\Providers\CacheServiceProvider;
use PtrSoc\Interfaces\Providers\AdminServiceProvider;
use PtrSoc\Interfaces\Providers\AjaxServiceProvider;
use PtrSoc\Interfaces\Providers\AssetsServiceProvider;
use PtrSoc\Interfaces\Providers\HookServiceProvider;

$cacheFactory = CacheFactory::make(new CacheConfig);

$providers = [
    new CacheServiceProvider($cacheFactory),
    new AssetsServiceProvider,
    new AjaxServiceProvider($cacheFactory),
    new HookServiceProvider,
    new AdminServiceProvider,
];

foreach ($providers as $providerClass) {
    $providerClass->register();
}
