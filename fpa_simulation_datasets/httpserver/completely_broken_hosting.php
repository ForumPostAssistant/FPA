<?php
declare(strict_types=1);

/**
 * Simulation Dataset: Variety of broken hosting variables
 * Target: $fpa_data['httpserver']['data']
 */
return [
    'web_server'          => 'Apache/2.2.34 (OldSystem)',
    'web_server_short'    => 'apache',
    'web_server_version'  => '2.2.34',
    'process_user'        => 'root', // ⚠️ Danger: Bad execution permissions
    'is_htaccess_enabled' => true,
    'has_mod_rewrite'      => false, // ⚠️ Danger: SEF URLs will break
    'has_gzip_compression' => false,
    'has_cache_headers'    => false,
    'loaded_modules'      => [],
    'fpm_pool_metrics'    => [
        'pool_name'      => 'www',
        'manager_type'   => 'static',
        'active_workers' => 5,
        'idle_workers'   => 0,
        'total_workers'  => 5,
        'max_reached'    => 5, // ⚠️ Danger: Max children hit!
        'slow_requests'  => 47, // ⚠️ Danger: Server is stalling heavily
        'slow_requests_tooltip' => 'Critical timeout thresholds breached.'
    ],
    'notes'               => 'Warning: Unstable and insecure legacy engine configuration.',
    'web_server_encoding' => 'None Specified',
    'umask'               => '0000' // ⚠️ Danger: Highly insecure fallback mask
];
