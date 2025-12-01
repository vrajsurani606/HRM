<?php

if (!function_exists('storage_asset')) {
    /**
     * Generate a URL for a file stored in the public storage directory.
     * This helper handles the correct path for subdirectory installations.
     *
     * @param string $path
     * @return string
     */
    function storage_asset($path)
    {
        return asset('public/storage/' . ltrim($path, '/'));
    }
}
