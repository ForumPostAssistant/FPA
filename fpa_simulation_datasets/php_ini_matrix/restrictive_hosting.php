<?php
declare(strict_types=1);
namespace ForumPostAssistant\Simulation;

/**
 * Simulation Dataset: Restricted Shared Hosting Profiler Matrix.
 * Targets: $fpa_data['php']['data']['ini_matrix']
 */
return [
    'memory_limit' => [
        'directive_name' => 'memory_limit',
        'global_value'   => '64M',
        'web_root_user'  => '64M',
        'active_runtime' => '64M',
        'sanity_state'   => 'danger',
        'sanity_message' => 'Critical Memory: Server threshold falls below minimum execution targets.',
        'status_color'   => 'danger',
        'status_text'    => 'LOW',
        'category'       => 'performance',
        'classes'        => ['global' => 'text-danger', 'web_root_user' => 'text-danger']
    ],
    'upload_max_filesize' => [
        'directive_name' => 'upload_max_filesize',
        'global_value'   => '2M',
        'web_root_user'  => '2M',
        'active_runtime' => '2M',
        'sanity_state'   => 'warning',
        'sanity_message' => 'Restrictive Uploads: File size configurations fall below baseline targets.',
        'status_color'   => 'warning',
        'status_text'    => 'LOW',
        'category'       => 'functionality',
        'classes'        => ['global' => 'text-warning', 'web_root_user' => 'text-warning']
    ]
];
