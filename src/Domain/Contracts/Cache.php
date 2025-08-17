<?php
namespace PtrSoc\Domain\Contracts;

interface Cache
{
    public function get(string $key, string $group = '', $default = null);
    public function set(string $key, $value, string $group = '', int $ttl = 0): bool;
    public function delete(string $key, string $group = ''): bool;
    public function flush(string $group = ''): bool;
    public function has(string $key, string $group = ''): bool;
}