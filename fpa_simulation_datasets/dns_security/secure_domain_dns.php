<?php
declare(strict_types=1);

/**
 * Simulation Dataset: Secure DNS Trust
 * Target: $fpa_data['dns_security']['data']
 */
return [
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
