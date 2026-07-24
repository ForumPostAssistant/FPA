<?php
declare(strict_types=1);

/**
 * Simulation Dataset: Pristine Apache Handler (mod_php)
 * Target: $fpa_data['httpserver']['data']
 */
return [
    'web_server'          => 'Apache/2.4.58 (Ubuntu) OpenSSL/3.0.13 Mod_PHP/7.4',
    'web_server_short'    => 'apache',
    'web_server_version'  => '2.4.58',
    'process_user'        => 'www-data',
    'is_htaccess_enabled' => true,
    'has_mod_rewrite'      => true,
    'has_gzip_compression' => true,
    'has_cache_headers'    => true,
    'loaded_modules'      => ['core_module', 'mod_authz_core', 'mod_deflate', 'mod_expires', 'mod_headers', 'mod_rewrite'],
    'fpm_pool_metrics'    => null, // Native Apache handler has no FPM pool daemon
    'notes'               => 'Pristine Apache non-isolated monolithic module architecture verified.',
    'web_server_encoding' => 'gzip, deflate, br',
    'umask'               => '0022'
];
