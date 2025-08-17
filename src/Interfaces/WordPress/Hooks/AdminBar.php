<?php

namespace PtrSoc\Interfaces\WordPress\Hooks;

class AdminBar
{

    public function register()
    {
        add_action('admin_bar_menu', [$this, 'flushCache'], 100);
    }

    public function flushCache($admin_bar)
    {
        if (! current_user_can('manage_options')) {
            return; // hanya admin
        }

        $admin_bar->add_node([
            'id'    => 'flush-cache-parent',
            'title' => 'Solid Cache',
            'href'  => false,
            'meta'  => [
                'title' => 'Cache Tools',
            ],
        ]);

        $admin_bar->add_node([
            'id'     => 'ptrsoc-flush-cache',
            'parent' => 'flush-cache-parent',
            'title'  => __('Flush Cache', PTRSOC_TEXTDOMAIN),
            'href'   => wp_nonce_url(admin_url('admin-post.php?action=ptrsoc_flush_cache'), 'ptrsoc_nonce'),
            'meta'   => [
                'title' => 'Flush all caches',
            ],
        ]);
    }
}
