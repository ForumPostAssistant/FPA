<?php
declare(strict_types=1);

/**
 * Simulation Dataset: httpserver & network Array Overwrites
 * Target: $fpa_data['httpserver']['data'] & $fpa_data['dns_security']['data']
 */
// STEP 1: Select the environment profile scenario you want to test!
$scenario = 'critical_failure'; // Options: 'pristine_apache', 'nginx_proxy', 'critical_failure'

    switch ($scenario) {
        case 'pristine_apache':
            return [
                // Overwrite HTTP Server parameters for a healthy Apache build
                $fpa_data['httpserver']['data'] = [
                    'web_server'          => 'Apache/2.4.58 (Ubuntu) OpenSSL/3.0.13',
                    'web_server_short'    => 'apache',
                    'web_server_version'  => '2.4.58',
                    'process_user'        => 'www-data',
                    'is_htaccess_enabled' => true,
                    'has_mod_rewrite'      => true,
                    'has_gzip_compression' => true,
                    'has_cache_headers'    => true,
                    'loaded_modules'      => ['core_module', 'mod_authz_core', 'mod_deflate', 'mod_expires', 'mod_headers', 'mod_rewrite'],
                    'fpm_pool_metrics'    => [
                        'pool_name'      => 'www',
                        'manager_type'   => 'dynamic',
                        'active_workers' => 2,
                        'idle_workers'   => 8,
                        'total_workers'  => 10,
                        'max_reached'    => 4,
                        'slow_requests'  => 0,
                        'slow_requests_tooltip' => 'No active timeout delays.'
                    ],
                    'notes'               => 'Apache optimized production stack verified.',
                    'web_server_encoding' => 'gzip, deflate, br',
                    'umask'               => '0022'
                ];

                // Overwrite DNS network targets for an elite secure domain
                $fpa_data['dns_security']['data'] = [
                    'status'             => 'executed',
                    'domain_checked'     => 'joomlasite.org',
                    'has_spf'            => true,
                    'spf_record'         => 'v=spf1 include:_://google.com ~all',
                    'has_dmarc'          => true,
                    'dmarc_record'       => 'v=DMARC1; p=quarantine; pct=100;',
                    'is_ip_mismatch'     => false,
                    'reverse_ptr_record' => 'web01.hostingprovider.net',
                    'verifications'      => ['google' => 'abc123xyz', 'microsoft_365' => 'ms456'],
                    'danger_count'       => 0,
                    'warning_count'      => 0,
                    'sanity_state'       => 'success',
                    'summary_notes'      => 'Excellent. Core trust vectors verified.'
                ];
            ];
            break;

        case 'nginx_proxy':
            return [
                // Overwrite parameters to test an Nginx reverse-proxy setup
                $fpa_data['httpserver']['data'] = [
                    'web_server'          => 'nginx/1.25.4',
                    'web_server_short'    => 'nginx',
                    'web_server_version'  => '1.25.4',
                    'process_user'        => 'nginx',
                    'is_htaccess_enabled' => false, // ⚠️ Alert: Nginx ignores .htaccess
                    'has_mod_rewrite'      => false,
                    'has_gzip_compression' => true,
                    'has_cache_headers'    => true,
                    'loaded_modules'      => [],
                    'fpm_pool_metrics'    => [
                        'pool_name'      => 'joomla_pool',
                        'manager_type'   => 'ondemand',
                        'active_workers' => 5,
                        'idle_workers'   => 15,
                        'total_workers'  => 20,
                        'max_reached'    => 12,
                        'slow_requests'  => 2, // ⚠️ Warning trigger count
                        'slow_requests_tooltip' => 'Slow requests intercepted.'
                    ],
                    'notes'               => 'Nginx reverse-proxy mode active behind edge layer.',
                    'web_server_encoding' => 'gzip',
                    'umask'               => '0002'
                ];

                $fpa_data['dns_security']['data'] = [
                    'status'             => 'executed',
                    'domain_checked'     => 'testsite.com',
                    'has_spf'            => true,
                    'spf_record'         => 'v=spf1 ip4:192.0.2.1 -all',
                    'has_dmarc'          => false, // ⚠️ Warning: DMARC missing
                    'is_ip_mismatch'     => false,
                    'reverse_ptr_record' => '://testsite.com',
                    'verifications'      => [],
                    'danger_count'       => 0,
                    'warning_count'      => 1,
                    'sanity_state'       => 'warning',
                    'summary_notes'      => 'Missing DMARC Spoof Shield protection parameters.'
                ];
            ];
            break;

        case 'critical_failure':
            return [
                // Overwrite variables to simulate a completely broken hosting environment
                $fpa_data['httpserver']['data'] = [
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

                $fpa_data['dns_security']['data'] = [
                    'status'             => 'executed',
                    'domain_checked'     => 'brokenroot.net',
                    'has_spf'            => false, // ⚠️ Danger: High spam risk
                    'spf_record'         => '-',
                    'has_dmarc'          => false, // ⚠️ Danger: No spoof protections
                    'is_ip_mismatch'     => true,  // ⚠️ Danger: Severe routing error
                    'reverse_ptr_record' => '://hackerserver.com',
                    'verifications'      => [],
                    'danger_count'       => 2,
                    'warning_count'      => 1,
                    'sanity_state'       => 'danger',
                    'summary_notes'      => 'Severe network IP routing mismatches and mail authentication flaws discovered.'
                ];
            ];
            break;
    }
