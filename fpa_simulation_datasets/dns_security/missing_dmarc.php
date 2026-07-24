<?php
declare(strict_types=1);

/**
 * Simulation Dataset: Missing DMARC
 * Target: $fpa_data['dns_security']['data']
 */
return [
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
