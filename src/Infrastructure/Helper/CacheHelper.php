<?php

if (!function_exists('ptrCache')) {
    function ptrCache()
    {
        global $ptr_soc;

        // Jika service aktif dan punya method fragment, kembalikan langsung
        if (
            isset($ptr_soc) &&
            is_object($ptr_soc) &&
            method_exists($ptr_soc, 'fragment') &&
            method_exists($ptr_soc, 'remember')
        ) {
            return $ptr_soc;
        }

        // Fallback ke class anon yang aman
        return new class {
            public function remember(string $key, callable $cb, string $group = '', int $ttl = 3600)
            {
                return $cb(); // langsung jalankan
            }

            public function fragment(string $key, callable $cb, string $group = '', int $ttl = 3600): void
            {
                $cb(); // langsung output
            }
        };
    }
}
