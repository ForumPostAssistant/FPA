<?php
declare(strict_types=1);

/**
 * Simulation Dataset: Severe DNS Trust and Reverse Pointer Failures
 * Target: $fpa_data['dns_security']['data']
 */
return [
    'status'             => 'executed',
    'domain_checked'     => 'compromisedbrand.com',
    'has_spf'            => false, // ⚠️ High phishing threat
    'spf_record'         => '-',
    'has_dmarc'          => false, // ⚠️ Mail spoof shields totally absent
    'dmarc_record'       => '-',
    'is_ip_mismatch'     => true,  // ⚠️ Critical: Server routing mismatch detected
    'reverse_ptr_record' => 'relay04.unverifiedhostingserver.ru',
    'verifications'      => [],
    'danger_count'       => 2,
    'warning_count'      => 1,
    'sanity_state'       => 'danger',
    'summary_notes'      => 'Asymmetric reverse network pointer discrepancies and empty mail trust parameters discovered.'
];
