<?php

namespace PtrSoc\Infrastructure\WordPress;

final class CacheConfig
{
    public function driver(): string
    {
        return 'disk';
    }
}
