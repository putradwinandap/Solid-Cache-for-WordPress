<?php

namespace PtrSoc\Interfaces\WordPress\Ajax\Handlers;

use PtrSoc\Interfaces\WordPress\Ajax\AbstractAjaxHandler;
use PtrSoc\Domain\Contracts\Cache;

class FlushCache extends AbstractAjaxHandler
{
    public function __construct(private Cache $cache) {}

    public function action(): string
    {
        return 'ptrsoc_flush_cache';
    }

    public function callback(): void
    {
        error_log('Flushing cache via AJAX handler');
        $this->cache->flush();
        wp_send_json_success(['message' => __('Cache flushed successfully.', PTRSOC_TEXTDOMAIN)]);
    }
}
