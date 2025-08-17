<?php

namespace PtrSoc\Infrastructure\WordPress\Drivers;

use PtrSoc\Domain\Contracts\Cache;

class DiskCache implements Cache
{
    protected string $baseDir;

    public function __construct()
    {
        $cacheDir = WP_CONTENT_DIR . '/cache';

        if (!is_dir($cacheDir)) {
            wp_mkdir_p($cacheDir);
        }

        $this->baseDir = trailingslashit($cacheDir) . 'ptr_soc_cache/';

        // Pastikan folder ptr_soc_cache ada
        if (!is_dir($this->baseDir)) {
            wp_mkdir_p($this->baseDir);
        }
    }

    public function get(string $key, string $group = '', $default = null)
    {
        $file = $this->getFilePath($key, $group);
        if (!file_exists($file)) return $default;

        $data = json_decode(file_get_contents($file), true);

        if (isset($data['ttl']) && time() > $data['ttl']) {
            unlink($file);
            return $default;
        }

        return $data['value'] ?? $default;
    }

    public function set(string $key, $value, string $group = '', int $ttl = 0): bool
    {
        $file = $this->getFilePath($key, $group);

        if (!is_dir(dirname($file))) {
            wp_mkdir_p(dirname($file));
        }

        $expire = $ttl > 0 ? time() + $ttl : 0;

        $data = [
            'value' => $value,
            'ttl'   => $expire
        ];

        return file_put_contents($file, json_encode($data)) !== false;
    }

    public function delete(string $key, string $group = ''): bool
    {
        $file = $this->getFilePath($key, $group);
        return file_exists($file) ? unlink($file) : true;
    }

    public function flush(string $group = ''): bool
    {
        $dir = $this->baseDir;

        $slugGroup = trim($group);
        if ($slugGroup) {
            $slugGroup = md5($slugGroup);
            $dir .= $slugGroup . '/';
        }

        return $this->deleteDirectory($dir);
    }

    public function has(string $key, string $group = ''): bool
    {
        return $this->get($key, $group, null) !== null;
    }

    protected function deleteDirectory(string $dir): bool
    {
        if (!is_dir($dir)) {
            return true;
        }

        $files = array_diff(scandir($dir), ['.', '..']);
        foreach ($files as $file) {
            $filePath = $dir . '/' . $file;
            if (is_dir($filePath)) {
                $this->deleteDirectory($filePath);
            } else {
                unlink($filePath);
            }
        }

        return rmdir($dir);
    }

    protected function getFilePath(string $key, string $group): string
    {
        $slugKey = trim($key);
        $slugKey = md5($slugKey);

        $dir = $this->baseDir;

        $slugGroup = trim($group);
        if ($slugGroup) {
            $slugGroup = md5($slugGroup);
            $dir .= $slugGroup . '/';
        }

        return $dir . $slugKey . '.cache.json';
    }
}
