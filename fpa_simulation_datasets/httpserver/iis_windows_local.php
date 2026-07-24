<?php
declare(strict_types=1);

/**
 * Simulation Dataset: Microsoft IIS Local Windows Testing Engine
 * Target: $fpa_data['httpserver']['data']
 */
return [
    'web_server'          => 'Microsoft-IIS/10.0',
    'web_server_short'    => 'iis',
    'web_server_version'  => '10.0',
    'process_user'        => 'IUSR',
    'is_htaccess_enabled' => false, // IIS uses web.config instead of .htaccess
    'has_mod_rewrite'      => true,  // Handled by the native IIS URL Rewrite Module
    'has_gzip_compression' => true,
    'has_cache_headers'    => false,
    'loaded_modules'      => ['StaticCompressionModule', 'DynamicCompressionModule', 'RewriteModule'],
    'fpm_pool_metrics'    => null, // FastCGI handles process pooling internally on IIS
    'notes'               => 'Windows local loopback platform detected. Requires web.config rule arrays.',
    'web_server_encoding' => 'gzip, deflate',
    'umask'               => '0000' // Windows handles execution permissions using explicit ACL descriptors
];
