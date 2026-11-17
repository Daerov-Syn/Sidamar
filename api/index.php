<?php

// Set tanda serverless Vercel
$_SERVER['VERCEL'] = '1';
$_ENV['VERCEL'] = '1';

// Pastikan direktori runtime dan cache di /tmp tersedia
$runtimeDirs = [
    '/tmp/views',
    '/tmp/storage/framework/views',
    '/tmp/storage/framework/cache/data',
    '/tmp/storage/framework/sessions',
    '/tmp/storage/logs',
    '/tmp/storage/app/private',
    '/tmp/storage/app/public',
];

foreach ($runtimeDirs as $dir) {
    if (!is_dir($dir)) {
        @mkdir($dir, 0755, true);
    }
}

// Forward request ke public/index.php Laravel
require __DIR__ . '/../public/index.php';
