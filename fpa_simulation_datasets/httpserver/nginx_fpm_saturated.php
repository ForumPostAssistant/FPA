<?php
declare(strict_types=1);

/**
 * Simulation Dataset: Nginx Reverse-Proxy + Saturated PHP-FPM Pool
 * Target: $fpa_data['httpserver']['data']
 */
return [
    'web_server'          => 'nginx/1.25.4',
    'web_server_short'    => 'nginx',
    'web_server_version'  => '1.25.4',
    'process_user'        => 'nginx',
    'is_htaccess_enabled' => false, // ⚠️ Nginx completely ignores .htaccess files
    'has_mod_rewrite'      => false, // Nginx handles rewrites inside server configuration blocks
    'has_gzip_compression' => true,
    'has_cache_headers'    => true,
    'loaded_modules'      => [],
    'fpm_pool_metrics'    => [
        'pool_name'      => 'www_production',
        'manager_type'   => 'static',
        'active_workers' => 20,
        'idle_workers'   => 0,
        'total_workers'  => 20,
        'max_reached'    => 20, // ⚠️ Critical: Max children hit, queuing subsequent visits
        'slow_requests'  => 142, // ⚠️ Critical: PHP-FPM is throwing heavy script timeout blocks
        'slow_requests_tooltip' => '142 scripts exceeded request_slowlog_timeout barriers.'
    ],
    'notes'               => 'Nginx reverse proxy operating with an exhausted, saturated backend processing pool.',
    'web_server_encoding' => 'gzip, br',
    'umask'               => '0002'
];
