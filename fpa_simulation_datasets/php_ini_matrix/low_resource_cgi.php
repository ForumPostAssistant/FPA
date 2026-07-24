<?php
declare(strict_types=1);

/**
 * Simulation Dataset: Restricted CGI Shared Hosting Stack
 * Target: $fpa_data['php']['data']['ini_matrix']
 */
return [
    'memory_limit' => [
        'directive_name' => 'memory_limit',
        'global_value'   => '64M',
        'web_root_user'  => '128M',
        'active_runtime' => '64M', // ⚠️ Local override failed to apply
        'sanity_state'   => 'danger',
        'sanity_message' => 'Critical Memory: Server threshold falls below minimum execution targets.',
        'status_color'   => 'danger',
        'status_text'    => 'LOW',
        'category'       => 'performance',
        'classes'        => ['global' => 'text-danger', 'web_root_user' => 'text-muted']
    ],
    'max_execution_time' => [
        'directive_name' => 'max_execution_time',
        'global_value'   => '30',
        'web_root_user'  => '30',
        'active_runtime' => '30',
        'sanity_state'   => 'warning',
        'sanity_message' => 'Low Timeout: Large extension installations or updates may time out.',
        'status_color'   => 'warning',
        'status_text'    => 'LOW',
        'category'       => 'performance',
        'classes'        => ['global' => 'text-warning', 'web_root_user' => 'text-muted']
    ],
    'upload_max_filesize' => [
        'directive_name' => 'upload_max_filesize',
        'global_value'   => '2M',
        'web_root_user'  => '2M',
        'active_runtime' => '2M',
        'sanity_state'   => 'warning',
        'sanity_message' => 'Restrictive Uploads: Joomla core patch files exceed this limit.',
        'status_color'   => 'warning',
        'status_text'    => 'LOW',
        'category'       => 'functionality',
        'classes'        => ['global' => 'text-warning', 'web_root_user' => 'text-muted']
    ],
    'override_status' => 'failed'
];
