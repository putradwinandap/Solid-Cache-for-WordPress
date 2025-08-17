<?php

namespace PtrSoc\Interfaces\WordPress\Assets;

class AdminAssets
{

    public function register()
    {
        add_action('admin_enqueue_scripts', [$this, 'styles']);
        add_action('admin_enqueue_scripts', [$this, 'scripts']);
    }

    public function styles()
    {
        wp_enqueue_style('ptrsoc-css', PTRSOC_URL . '/assets/css/admin.css', '', PTRSOC_VERSION, 'all');
    }

    public function scripts()
    {

        wp_enqueue_script('ptrsoc-js', PTRSOC_URL . '/assets/js/admin.js', ['jquery'], PTRSOC_VERSION);
        wp_localize_script(
            'ptrsoc-js',
            'ptrSoc',
            [
                'url' => admin_url('admin-ajax.php', 'relative'),
                'nonce' => wp_create_nonce('ptrsoc_nonce'),
                'flushCacheTitle' => __('Flush Cache', PTRSOC_TEXTDOMAIN),
                'confirmFlush' => __('Are you sure you want to flush the cache? This action cannot be undone.', PTRSOC_TEXTDOMAIN),
                'errorMessage' => __('An error occurred while flushing the cache.', PTRSOC_TEXTDOMAIN),
                'loading' => __('Loading...', PTRSOC_TEXTDOMAIN),
            ]
        );
    }
}
