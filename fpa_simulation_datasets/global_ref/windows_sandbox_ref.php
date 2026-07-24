<?php
declare(strict_types=1);

/**
 * Simulation Dataset: Global References Array Overwrites (Windows Localhost)
 * Target: $fpa_data['ref']
 */
return [
    'meta' => [
        'section_title' => 'Global Environment References (Simulated)',
        'section_intro' => 'Common reference and comparison data for a Windows development sandbox environment.'
    ],
    'data' => [
        'php' => [
            'version'            => '7.4.33',
            'interface_sapi'     => 'cgi-fcgi',
            'process_user'       => 'SYSTEM',
            'process_uid'        => 0,
            'process_gid'        => 0,
            'disabled_functions' => 'shell_exec, exec, passthru, system'
        ],
        'server' => [
            'os_family'           => 'Windows', // 🚀 Forces fpa_is_windows_helper() to return true!
            'os_family_short'     => 'win',
            'os_release'          => '10.0 build 22631',
            'hostname'            => 'DESKTOP-DEV-DEVBOX',
            'host_ip'             => '127.0.0.1', // 🚀 Forces fpa_is_localhost_helper() to return true!
            'technology'          => 'AMD64',
            'web_server'          => 'Microsoft-IIS/10.0',
            'web_server_short'    => 'iis',
            'web_server_encoding' => 'gzip, deflate',
            'umask'               => '0000',
            'is_localhost'        => true,
            'is_windows'          => true,
            'is_win_local'        => true
        ],
        'network' => [
            'domain_ip'   => '127.0.0.1',
            'raw_domain'  => 'localhost',
            'domain_name' => 'localhost',
            'server_port' => 80,
            'visitor_port'=> 51324
        ]
    ]
];
