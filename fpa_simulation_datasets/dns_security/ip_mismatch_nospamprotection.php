<?php
declare(strict_types=1);

/**
 * Simulation Dataset: IP Mismatch, missing SPF & DMARC
 * Target: $fpa_data['dns_security']['data']
 */
return [
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
