<?php
/**
 * English (en-GB) HTML5 page shell for Forum Post Assistant.
 *
 * Application foreword and notes
 * -----------------------------
 * As you may have noticed, the FPA is quite a large standalone PHP application and a unique diagnostic tool to assist
 * forum support staff in troubleshooting end-user Joomla! issues and errors. It enables less technical users to view
 * and produce consistent technical information regarding their server, application, and instance, saving time and reducing
 * frustration for both parties. As such, many of its methods could be construed as breaking traditional conventions and
 * norms. Where possible, we try to maintain up-to-date best practices, but by its very nature, old or non-standard
 * practices, formatting, and methods may occasionally be employed to ensure backward compatibility and functionality.
 *
 * Code standards & best practices
 * -------------------------------
 * 1.  PHP: PSR-12 compliant formatting.
 * 2.  PHP: Minimum 7.4; stay compatible with current stable PHP releases. Use syntax and APIs supported in 7.4 unless
 *     the documented minimum is raised.
 * 3.  PHP: strict_types. In an effort to produce cleaner and more robust runtime code, we have implemented this PHP
 *     directive. PHP now enforces strict data type matching for function arguments and return values. Type juggling
 *     (automatic type casting) is disabled, forcing the engine to throw a TypeError if a value does not exactly
 *     match the declared type hint. Watch your single and double quoting, as well as strict boolean expressions.
 * 4.  HTML: W3C valid HTML5 structure.
 * 5.  HTML: Attribute Ordering. While this offers no performance gain, our preferred hierarchy is:
 *     id, class, name, src, type, aria, data/content
 * 6.  CSS: Modern CSS (Level 3 modules and newer where appropriate).
 * 7.  JavaScript & Assets: Vanilla JS (ES6+ preferred). Remote CDNs are permitted for performance, but
 *     visual UI layouts must fail gracefully to semantic unstyled text if an internet connection is unavailable.
 * 8.  Security: Never output raw passwords, hashes, or secret keys. All sensitive system paths must be masked.
 * 9.  Error Handling: Wrap environment-sensitive diagnostics in try/catch blocks to ensure graceful degradation.
 * 10. Defensive Programming: Due to the nature of the FPA operating in differing, unknown, and potentially problematic
 *     environments, we operate on the Defensive Programming principle of assuming that anything that can go wrong will
 *     go wrong. Therefore, where possible, pre-fill elements with defaults, validate return data before using, and create
 *     routines that fail gracefully rather than crashing catastrophically.
 * 11. Report-By-Exception (RBE): Where feasible and sensible, display or report only exceptions/errors/issues instead
 *     of long lists of good/pass/success results. If all results are good, then simply display a single message reflecting
 *     this status.
 * 12. Internationalisation: All UI text must utilise the core translation arrays; do not hardcode text strings directly
 *     into the DOM.
 * 13. Accessibility: Endeavor to adhere to WCAG 2.1 Level AA guidelines.
 * 14. Commenting: In an effort to improve maintainability, DOM cleanliness, performance, and security, we comment
 *     extensively. While HTML comments are acceptable, PHP/JS comment styles are preferred for larger blocks as
 *     they are stripped out at execution and are not visible in the frontend at runtime.
 * 15. Logical Separation: Even though it is one file, maintain a strict logical separation. Structural logic, utility
 *     functions, configuration, and data processing arrays sit at the top of the file. The visual UI/HTML rendering
 *     sections sit at the bottom.
 * 16. Namespace Simulation: To avoid variable or function name collisions, prefix all global helper functions, classes,
 *     and global variables with fpa_ (e.g., fpa_get_server_info()).
 * 17. Naming Conventions (Case Style): To maximize readability for non-professional developers, volunteer contributors,
 *     and non-native English speakers, all global variables, tracking arrays, and freestanding helper functions must
 *     strictly utilise lowercase snake_case (e.g., $fpa_system_reference, $fpa_issue_queue). This reduces capitalisation
 *     typos, lowers cognitive load, and maintains a uniform file style.
 *
 * Target environment: Joomla! CMS sites on PHP 7.4 or newer (all known Joomla! versions (from v3.9.13) meeting that requirement).
 * Contributors include RussW, PhilD13, mandville, frostmakk, sozzled, Webdongle, and btoplak.
 *
 * @package Joomla!
 * @subpackage ForumPostAssistant
 * @category DiagnosticTools
 * @since 2.0.0
 * @version 2.0.0-alpha.1
 * @license GPL-2.0-or-later https://gnu.org
 * @copyright Copyright (c) 2011-2026 Forum Post Assistant
 * @author RussW
 * @author PhilD13
 * @link https://github.com Project website
 * @see https://github.io Further documentation
 * @see docs/accessibility.md WCAG 2.1 Level AA guidelines
 *
 */
declare(strict_types = 1);



/*
 * =============================================================================
 * SECTION: SECURITY
 * =============================================================================
 * The following items are primarily concerned with securing the FPA and it's
 * output as much as humanly possible whilst maintaining it's functionality and
 * flexibility for the greater end-user base.
 *
 */
// Generate a runtime cryptographic nonce for secure inline execution checks
$fpa_nonce = bin2hex(random_bytes(16));

// Implement a variety of headers and policies
if (!headers_sent()) {
    // Strict anti-clickjacking baseline
    header('X-Frame-Options: SAMEORIGIN');
    // Prevent the browser from guessing media mime-types
    header('X-Content-Type-Options: nosniff');
    // Absolute referrer leak protection
    header('Referrer-Policy: no-referrer');
    // Force browser cache expiration of sensitive system audit outputs
    header('Cache-Control: no-store, no-cache, must-revalidate, max-age=0');
    header('Pragma: no-cache');
    // Total lock out of device hardware contexts
    header("Permissions-Policy: camera=(), microphone=(), geolocation=(), interest-cohort=()");
    // Nonce-Driven Content Security Policy (Allows explicit CDNs + localized fallback script)
    header("Content-Security-Policy: default-src 'self'; script-src 'self' 'nonce-{$fpa_nonce}' https://cdn.jsdelivr.net; style-src 'self' 'unsafe-inline' https://cdn.jsdelivr.net https://cdnjs.cloudflare.com; font-src 'self' https://cdnjs.cloudflare.com; img-src 'self' data:; connect-src 'self' https://cdn.jsdelivr.net; frame-ancestors 'none';");
}




/*
 * =============================================================================
 * SECTION: FPA CONFIGURATION
 * =============================================================================
 *
 * Special Notes
 * Live Checks: make use of constant arrays in order to be able to configure multiple immutable data elements, allowing
 * for less complex determination of the $doLiveChecks (which checks can be achieved) routine and the later getRemoteData
 * multi_cURL dataa retrival function. (I know it sounds more complex, but you'll get it when you see the doLiveCheck and
 * cURL routines)
 *
 * FPA v1 maintainters, please note; the configuration and language strings have changed tremendously in an attempt to
 * address the previous FPA architecural design configuration and translation limitions and performance. Default FPA strings
 * are defined at runtime, configuration elements are now compile time constants and language strings are now a $lang array.
 *
 */
// --- fpa & Joomla! parent flag and constants ---
define ('FPA_VERSION', '2.0.0-alpha.1');
define ('FPA_CODENAME', 'Wasabi');
define ('FPA_LAST_UPDATED', 'June-2026');
define ('FPA_COPYRIGHT_STMT', ' Copyright &copy; 2011-'. date("Y").  ' Russell Winter, Phil DeGruy, Bernard Toplak, Claire Mandville, Sveinung Larsen.');
define ('FPA_SELF', basename(__FILE__));  // take in to account renamed FPA, ensure all local links still work

// use this shortcut url to reduce link clutter and self-referencing URL code injection attacks
$fpa_self_url = htmlspecialchars(FPA_SELF, ENT_QUOTES, 'UTF-8');

// joomla parent flags
define ('_VALID_MOS', 1);              // for J!1.0
define ('_JEXEC', 1);                  // for J!1.5, J!1.6 thru J!6.0

// --- fpa feature configuration ---
const FPA_DEV = false; // developer-mode, displays raw array data on screen
const FPA_DIA = true;  // diagnostic-mode, turns on PHP logging errors, display errors and logs error to a file
const FPA_SELF_DESTRUCT = true; // self-destruct, attempts to self-delete on next run if file older than configured duration
const FPA_SELF_DESTRUCT_AGE = 3; // self-destruct filetime age duration
const FPA_SSL_REDIRECT = false; // SSL Redirect - when possible and if a valid SSL certificate is found FPA attempts to redirect to the SSL version of the site
const FPA_PROJECT_URL = 'https://github.com/ForumPostAssistant/FPA/'; // github project/repository url
const FPA_DOCS_URL = 'https://forumpostassistant.github.io/docs/'; // github documention site url
const FPA_DOWNLOAD_ZIP_URL = 'https://github.com/ForumPostAssistant/FPA/zipball/en-GB/'; // github latest download url (zip file)
const FPA_DOWNLOAD_TAR_URL = 'https://github.com/ForumPostAssistant/FPA/tarball/en-GB/'; // github latest download url (tar file)

// --- fpa live checks configuration array constants ---
// enable live latest FPA version check
const FPA_LIVE_CHECK = [
    'enabled' => true,
    'format'  => 'json',
    'url'     => 'https://api.github.com/repos/ForumPostAssistant/FPA/releases/latest'
];
// enable live latest Joomla! version check
const FPA_LIVE_CHECK_JOOMLA = [
    'enabled' => true,
    'format'  => 'xml',
    'url'     => 'https://update.joomla.org/core/extension.xml'
];
// enable live latest Joomla! version check
const FPA_LIVE_CHECK_PHP = [
    'enabled' => true,
    'format'  => 'json',
    'url'     => 'https://php.net/releases/active.php'
];
// enable live latest dataBase version check (not implemented yet - TODO: need to workout how to determine DB type first)
const FPA_LIVE_CHECK_DBASE = [
    'enabled' => false,
    'format'  => 'json',
    'url'     => 'https://php.net/releases/active.php'
];
// enable live VEL check (not implemented yet) TODO: need to check how to exclude this from $latestVersions array
const FPA_LIVE_CHECK_VEL = [
    'enabled' => false,
    'format'  => 'xml',
    'url'     => 'https://extensions.joomla.org/vel-feed'
];






/*
 * =============================================================================
 * SECTION: SSL DETECTION & AUTO REDIRECT
 * =============================================================================
 * If FPA_SSL_REDIRECT is enabled (true) in the configuration above, we will
 * attempt to detect a valid SSL Certificate and it's current state. If a
 * http: environment is detected and a valid certificate is available we'll
 * redirect to the https: site instead.
 */
// initiate the ssl details array, will be merged in to $fpa_security later

/**
 * DISABLED CONST NOT_SURE_IF_WORKING TODO: need to test online to see if working
 * TODO: update localhost detection to comprehensive one below
 */
$fpa_ssl = [];
if (defined('FPA_SSL_REDIRECT') && FPA_SSL_REDIRECT) {

    /**
     * Detect and audit the SSL Certificate state of the current running environment.
     *
     * @return array Contain keys: [is_valid, is_localhost, error, details]
     */
    function fpa_audit_ssl(): array {
        $host = $_SERVER['HTTP_HOST'] ?? 'localhost';

        // Strip port numbers from host if present (e.g. domain.com:8080)
        $host_clean = parse_url('http://' . $host, PHP_URL_HOST);

        $result = [
            'is_valid'     => false,
            'is_localhost' => false,
            'error'        => null,
            'details'      => []
        ];

        // Instantly exclude local environments
        $local_hosts = ['localhost', '127.0.0.1', '[::1]'];
        // TESTING
        //$local_hosts = ['000.000.000.000', 'russw.dev'];

        if (in_array($host_clean, $local_hosts) || substr($host_clean, -6) === '.local') {
            $result['is_localhost'] = true;
            $result['error']        = 'Localhost environment detected.';
            return $result;
        }

        // Build a strict TLS verification stream envelope
        $context = stream_context_create([
            'ssl' => [
                'capture_peer_cert' => true,  // Extract the raw cert resource
                'verify_peer'       => true,  // Enforce trust chain validation
                'verify_peer_name'  => true,  // Enforce domain name matching
                'allow_self_signed' => false, // Disallow untrusted certs
            ]
        ]);

        // Attempt a brief loopback connection to port 443
        // We use a short 3-second timeout so pages don't hang if a firewall blocks it.
        $remote_socket = "tls://{$host_clean}:443";
        $client = @stream_socket_client(
            $remote_socket,
            $errno,
            $errstr,
            3,
            STREAM_CLIENT_CONNECT,
            $context
        );

        if (!$client) {
            $result['error'] = "SSL Handshake failure: {$errstr} (Code: {$errno})";
            return $result;
        }

        // Retrieve and parse the verified certificate data parameter
        $params = stream_context_get_options($context);
        if (isset($params['ssl']['peer_certificate'])) {
            $cert_resource = $params['ssl']['peer_certificate'];
            $cert_info = openssl_x509_parse($cert_resource);

            if ($cert_info) {
                $result['is_valid'] = true;
                $result['details'] = [
                    'subject' => $cert_info['subject']['CN'] ?? 'Unknown',
                    'issuer'  => $cert_info['issuer']['CN'] ?? 'Unknown',
                    'valid_from' => date('Y-m-d H:i:s', $cert_info['validFrom_time_t']),
                    'valid_to'   => date('Y-m-d H:i:s', $cert_info['validTo_time_t']),
                    'days_left'  => ceil(($cert_info['validTo_time_t'] - time()) / 86400)
                ];
            }
        }

        fclose($client);
        return $result;

    }

    // Check if the user is already on https: and only run the certificate audit if not
    $is_https = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') || ($_SERVER['SERVER_PORT'] == 443);

    if ($is_https) {
        // The server is already secure! You can grab basic details instantly:
        $fpa_ssl['ssl_status'] = [
            'is_valid'     => true,
            'is_localhost' => false,
            'redirected' => false,
            'error'        => null,
            'details'      => [
                'protocol' => $_SERVER['SSL_PROTOCOL'] ?? 'xTLSv1.3', // Native server variable
                'cipher'   => $_SERVER['SSL_CIPHER'] ?? 'Unknown'
            ]
        ];
    } else {
        // User is on HTTP! Run the loopback audit function to check if we can redirect them
        $ssl_audit = fpa_audit_ssl();

        // Add the clean data object right into your primary reference array
        $fpa_ssl['ssl_status'] = $ssl_audit;


        /**
         * check for an http: connection and redirect to https:, if possible
         */
        $is_http = (empty($_SERVER['HTTPS']) || $_SERVER['HTTPS'] === 'off');

        if ($is_http) {
            if ($ssl_audit['is_valid']) {
                // Safe to redirect: A valid certificate exists, and it's not localhost!
                $fpa_ssl['redirected'] = true;
                $secure_url = "https://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
                header("Location: " . $secure_url, true, 301);
                exit();
            } else {
                // Enforce fallback: No cert found or on localhost.
                // We add an alert notification straight to our UI issue queue array!
                if (!$ssl_audit['is_localhost']) {
                    $fpa_exception_queue[] = [
                        'category'        => 'SSL Warning',
                        'type'      => 'warning',
                        'text'      => 'Insecure Connection Detected.',
                        'solution'  => 'Your browser session is unencrypted. The system searched for a valid SSL Certificate to secure your session automatically, but encountered an error: ' . $ssl_audit['error'],
                        'target_id' => 'notification-wrapper'
                    ];
                }
            }
        }

    } // if user is_https

} // end FPA_SSL_REDIRECT






/*
 * =============================================================================
 * SECTION: FPA TROUBLESHOOTING
 * =============================================================================
 * Internal FPA diagnostic, error display and logging
 * if enabled in the FPA Configuration, attempt verbose localised php & diagnostic
 * output to stdout and to an fpa logfile
 */
if (defined('FPA_DIA') && FPA_DIA) {
    error_reporting(E_ALL);
    ini_set('display_errors', '1');
    ini_set('display_startup_errors', '1');
    ini_set('log_errors', '1');

    // create an fpa logfile (grouped by year-month-day to avoid infinite files)
    $fpa_log_file = "./fpa_" . date('Y-m-d') . "_log";

    // direct all standard PHP errors to the fpa logfile automatically
    ini_set('error_log', $fpa_log_file);

    // append a session initialization header to mark the debug timeline
    $fpa_log_message = "--- FPA Diagnostic Session Started: " . date('l jS F Y h:i:s A') . " ---" . PHP_EOL;
    // error_log($fpalogMessage, 3, $fpaLogfile);
} else {
    // re-enforce a strict production privacy baseline
    // ie: no code errors will bleed onto (stdout) the public screen
    ini_set('display_errors', '0');
    ini_set('display_startup_errors', '0');
}












/*
 * =============================================================================
 * SECTION: PHP SESSION MANAGEMENT
 * =============================================================================
 */
// Start session if not already active to preserve choices across reloads
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}


/**
 * Privacy Switch Setting & Redaction.
 * Automagically reloads the page upon privacy setting change, redacting any
 * privacy enabled elements.
 *
 * USAGE:
 * echo $_SESSION['privacy_enabled'] ? '<span class="privacy-mask">[ ' . $lang['FPA_REDACTED'] . ' ]</span>' : $someDataArray['some_element'];
 *
 */
// Default layout setting if no choice has been made yet
if (!isset($_SESSION['privacy_enabled'])) {
    $_SESSION['privacy_enabled'] = true;
}

// Background handler processing the switch toggles
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['privacy_ajax'])) {
    $_SESSION['privacy_enabled'] = ($_POST['privacy'] === '1');

    header('Content-Type: application/json');
    echo json_encode(['success' => true]);
    exit;
}

// Value to render the switch graphic in its proper initial position on reload
$is_privacy_checked = $_SESSION['privacy_enabled'] ? 'checked' : '';




/*
 * =============================================================================
 * SECTION: LANGUAGE STRINGS & TRANSLATIONS
 * =============================================================================
 * Default (en-GB) language array (well, kinda Australian English actually!)
 * any translated strings will be overwritten by remote internationalisation
 * files once a language is determinded from the browser.
 *
 * @var array<string, string> $lang Associative array mapping localisation keys to English text.
 */
// --- default en-GB language strings ---
$lang = [
    // FPA Core
    'FPA_THISLANG'          => 'en-GB',
    'FPA_LONG'              => 'Forum Post Assistant',
    'FPA_SHORT'             => 'FPA',
    'FPA_DESC'              => 'Forum Post Assistant and diagnostic audit tool for the Joomla! CMS.',

    // FPA statuses, results & descriptors
    'FPA_YES'               => 'Yes',
    'FPA_NO'                => 'No',
    'FPA_NONE'              => 'None',
    'FPA_UNKNOWN'           => 'Unknown',
    'FPA_NA'                => 'N/A',
    'FPA_WARNING'           => 'Warning',
    'FPA_ERROR'             => 'Error',
    'FPA_SUCCESS'           => 'Success',
    'FPA_INFO'              => 'Info',
    'FPA_FAILED'            => 'Failed',
    'FPA_OK'                => 'OK',
    'FPA_TRUE'              => 'True',
    'FPA_FALSE'             => 'False',
    'FPA_COMPACT'           => 'Compact',
    'FPA_DEFAULT'           => 'Default',
    'FPA_DETAILED'          => 'Detailed',
    'FPA_MAYBE'             => 'Maybe',
    'FPA_DEFUNCT'           => 'Defunct',
    'FPA_REDACTED'          => 'REDACTED',
    'FPA_STATUS'            => 'Status',
    'FPA_CURRENT'           => 'Current',
    'FPA_LATEST'            => 'Latest',
    'FPA_ENABLED'           => 'Enabled',
    'FPA_DISABLED'          => 'Disabled',
    'FPA_DEVBUILD'          => 'Dev Build',
    'FPA_UPTODATE'          => 'Up To Date',
    'FPA_UPDATEAVAIL'       => 'Update Available',
    'FPA_DOWNLOADLATEST'    => 'Download Latest',
    'FPA_PLATFORM'          => 'Platform',
    'FPA_ENVIRONMENT'       => 'Environment',
    'FPA_HOST'              => 'Host',
    'FPA_SERVER'            => 'Server',
    'FPA_APPLICATION'       => 'Application',
    'FPA_WEB'               => 'Web',
    'FPA_PHP'               => 'PHP',
    'FPA_DBASE'             => 'DataBase',
    'FPA_PERFORMANCE'       => 'Performance',
    'FPA_SECURITY'          => 'Security',
    'FPA_PDF'               => 'PDF',
    'FPA_DOCUMENTATION'     => 'Documentation',
    'FPA_CONFIGURATION'     => 'Configuration',
    'FPA_CONFIG'            => 'Config',
    'FPA_SUMMARY'           => 'Summary',
    'FPA_AUDIT'             => 'Audit',

    // FPA titles, headings, Labels, meta & descriptions
    'FPA_META_VERSIONS'            => 'Live Version Status',
    'FPA_META_APP_VERSIONS'        => 'Application Versions',
    'FPA_META_INSTANCE_DIAG'       => 'Joomla Core Instance Diagnostics',
    'FPA_META_SYSTEMSASSURANCE'    => 'Systems Assurance',      // Environmental
    'FPA_META_PLATFORMINTEGRITY'   => 'Platform Integrity',     // Security & Safeguards
    'FPA_META_TUNINGOPTIMISATION'  => 'Tuning & Optimisation',  // Perfomance
    'FPA_META_CORE_FOLDERS'        => 'Core Folders',
    'FPA_META_FOLDER_PERMS'        => 'Permissions',
    'FPA_HEADING_PERMISSIONS'      => 'Permissions Report',
    //'FPA_LANG_CORE_DIRS'           => 'Joomla Core Directories',
    'FPA_LABEL_FPA'                => 'Forum Post Assistant',
    'FPA_LABEL_JOOMLA'             => 'Joomla! Core',
    'FPA_LABEL_PHP'                => 'PHP Application Engine',
    'FPA_RUNTIMEOPTIONS'           => 'Runtime Options',
    'FPA_KEYMETRICS'               => 'Key Metrics',
    'FPA_READINESS'                => 'Readiness',
    //'FPA_CONFIDENCE'               => 'Confidence',


    'FPA_READINESS_APLUS'          => 'A+',
    'FPA_READINESS_A'              => 'A',
    'FPA_READINESS_B'              => 'B',
    'FPA_READINESS_C'              => 'C',
    'FPA_READINESS_D'              => 'D',
    'FPA_READINESS_E'              => 'E',
    'FPA_READINESS_F'              => 'F',
    'FPA_READINESS_MSG_A'          => 'Joomla! should run without any problems',
    'FPA_READINESS_MSG_B'          => 'Joomla! should run but some features may have minor problems',
    'FPA_READINESS_MSG_C'          => 'Joomla! might run but some features will have problems',
    'FPA_READINESS_MSG_D'          => 'Joomla! might run but many features will have problems',
    'FPA_READINESS_MSG_E'          => 'Joomla! probably will not run or will have many problems',
    'FPA_READINESS_MSG_F'          => 'Joomla! probably will not run and will have many problems',
    // End-user messages and textual content
];


/**
 * --- Browser Language Detection & Automated Translation Engine ---
 *
 * Evaluates the client's browser language configuration to fetch, validate,
 * and merge matching localisation assets from the remote FPA repository.
 *
 * - Attempts to locate the exact regional dialect file (e.g., fr-CA.php) first.
 * - If the specific dialect is missing, falls back to the primary regional variant (e.g., fr-FR.php).
 * - Securely screens the downloaded asset payload for any malicious string tokens.
 * - Caches validated assets in the server's temporary directory for 24 hours to prevent network lag.
 * - Merges the translation matrix into the default array, allowing partial files to fail gracefully
 *   back to built-in en-GB default strings.
 *
 * File Naming Architecture:
 * Must strictly follow RFC 3066 specification guidelines:
 * Formula: [ISO 639-1 Language Code (lowercase)] + "-" + [ISO 3166-1 Country Code (uppercase)] + ".php"
 * Examples: en-GB.php, fr-FR.php, fr-CA.php, de-DE.php
 *
 * @global array $lang Intercepts and overrides the primary translation registry variable.
 */
// Capture the primary language tag along with any regional sub-tags
$raw_http_lang = $_SERVER['HTTP_ACCEPT_LANGUAGE'] ?? 'en-GB';

// Split by comma to grab the first preferred language preference string
$primary_lang_block = explode(',', $raw_http_lang);
$preferred_lang = $primary_lang_block[0] ?? 'en-GB';

// Clean out potential malicious characters to make file system operations safe
$browser_lang = preg_replace('/[^a-zA-Z\-_]/', '', $preferred_lang);

// Standardise the casing format to match Joomla's official repository structures (e.g., 'fr-FR')
if (strpos($browser_lang, '-') !== false) {
    list($lang_code, $region_code) = explode('-', $browser_lang, 2);
    $lang_code    = strtolower($lang_code);
    $region_code  = strtoupper($region_code);

    $browser_lang = "{$lang_code}-{$region_code}"; // e.g., 'fr-CA'

    // Map the fallback to the matching primary regional country variant (e.g., 'fr-FR')
    $base_fallback = "{$lang_code}-" . strtoupper($lang_code);
} else {
    // If the browser only sends 'fr', automatically map it directly to Joomla's 'fr-FR' asset target
    $lang_code     = strtolower($browser_lang);
    $browser_lang  = "{$lang_code}-" . strtoupper($lang_code);
    $base_fallback = $browser_lang;
}

// Only attempt translation if the user is not using the built-in English base
if ($browser_lang !== 'en-GB') {
    // Create an ordered queue matching RFC3066 naming standards
    $file_targets   = [];
    $file_targets[] = "{$browser_lang}.php"; // First choice: e.g., 'fr-CA.php'

    if ($browser_lang !== $base_fallback) {
        $file_targets[] = "{$base_fallback}.php"; // Fallback choice: e.g., 'fr-FR.php'
    }

    $local_cache_file      = null;
    $fetched_successfully = false;

    // Loop through our targets (will break early as soon as one successfully loads or downloads)
    foreach ($file_targets as $remote_file_name) {
        $local_cache_file = sys_get_temp_dir() . "/fpa_version2_lang_{$remote_file_name}";
        $cache_lifetime  = 86400; // 24 hours in seconds

        // If a valid cache file already exists locally, skip network checks entirely
        if (file_exists($local_cache_file) && (time() - filemtime($local_cache_file) <= $cache_lifetime)) {
            $fetched_successfully = true;
            break;
        }

        // If cache is missing or stale, attempt to fetch this specific file from GitHub
        $github_url = "https://raw.githubusercontent.com/ForumPostAssistant/FPA/refs/heads/v2-dev/lang/{$remote_file_name}";

        $ch = curl_init();
        curl_setopt_array($ch, [
            CURLOPT_URL            => $github_url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT        => 4,
            CURLOPT_USERAGENT      => 'ForumPostAssistant-Client/2.0',
            CURLOPT_FOLLOWLOCATION => true,
        ]);

        $raw_payload = curl_exec($ch);
        $http_code   = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        // PHP7.x cross-version handle cleanup as PHP8+ utilises a garbage collector
        if (PHP_VERSION_ID < 80000) {
            curl_close($ch);
        }

        // START: CODE/PAYLOAD HARDENING INTEGRITY LAYER
        if ($http_code === 200 && !empty($raw_payload)) {

            // Check for malicious file include backdoors or remote system command injection attempts
            $dangerous_tokens = ['eval', 'system', 'exec', 'passthru', 'shell_exec', '$_POST', '$_GET', '$_REQUEST'];
            $is_payload_safe = true;

            foreach ($dangerous_tokens as $token) {
                if (stripos($raw_payload, $token) !== false) {
                    $is_payload_safe = false;
                    break;
                }
            }

            // Ensure the downloaded file is structured purely as a clean array return statement
            if ($is_payload_safe && strpos($raw_payload, '<?php') === 0 && strpos($raw_payload, 'return [') !== false) {
                if (@file_put_contents($local_cache_file, $raw_payload) !== false) {
                    $fetched_successfully = true;
                    break; // Successfully got a file, break out of fallback loop!
                }
            }
        }
        // END: CODE/PAYLOAD HARDENING INTEGRITY LAYER
    }

    // If we have a valid local cache file verified by our queue loop, load and merge it in to $lang array
    if ($fetched_successfully && $local_cache_file !== null && file_exists($local_cache_file)) {
        $overrides = include $local_cache_file;

        if (is_array($overrides)) {
            $lang = array_replace($lang, $overrides);
        }
    }
}




/*
 * =============================================================================
 * SECTION: FPA HELPERS, UTILITIES & FUNCTIONS
 * =============================================================================
 * Helper utilities used for validation and qualification throughout the fpa to
 * confirm environmental elements and/or any required host settings are in place
 * or available prior to execution.
 *
 */

/**
 * --- Detect Localhost & Windows Hosts ---
 * Validates if the request originates from a local/private subnet to safely
 * disable _FPA_AUTO_DESTRUCT due to never changing file "modified" date on local
 * copy and paste and handle Windows file permission quirks gracefully (preventing
 * false-alarm 777 errors).
 *
 * Environment Variables Generated:
 * @var bool $isLocalhost  True if the client IP matches a loopback or private subnet (10.*, 192.168.*, etc.).
 */
$local_ip_prefixes = [
    '127.',        // Loopback IPv4
    '10.',         // Private Class A
    '192.168.',    // Private Class C
    '::1',         // Loopback IPv6
];

// dynamically generate the reduced 172.16.0.0/12 private range to save memory
for ($i = 16; $i <= 31; $i++) {
    $local_ip_prefixes[] = '172.' . $i . '.';
}

$is_localhost = false;
$remote_addr  = $_SERVER['REMOTE_ADDR'] ?? '';

// perform safe, prefix-anchored matching
if ($remote_addr !== '') {
    foreach ($local_ip_prefixes as $prefix) {
        // enforce that the IP address MUST start with the prefix (position 0)
        if (strpos($remote_addr, $prefix) === 0) {
            $is_localhost = true;
            break;
        }
    }
}


/**
 * --- Windows localhost detection ---
 * Detects if the loacalhost is Windows in preparation to handle Windows file
 * permission quirks gracefully (preventing false-alarm 777 errors).
 *
 * Environment Variables Generated:
 * @var bool $isWindows    True if the underlying hosting server is running on a Windows operating system.
 * @var bool $isWinLocal   True ONLY when running on a local development setup using a Windows environment.
 */
$is_windows  = (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN');
$is_win_local = ($is_localhost && $is_windows);


/**
 * Privacy - data masking
 *
 * USAGE:
 *
 *
 */
/* TODO: check this later, if its worth doing compared to existing methos
function maskData($realValue, $mask = '••••••••') {
    return $_SESSION['privacy_enabled'] ? $mask : $realValue;
}
*/


/**
 * --- Safely escape and echo a language string ---
 * Use this function to echo language strings as a belt and braces protection
 * against user contributed translations maicious code injections
 *
 * e.g: fpaLang('FPA_LONG');  -  "Forum Post Assistant"
 *
 * @param string $key The key from the translation array.
 * @return void
 */
/* TODO: not sure this is worth the hassle */
/*
function fpa_lang(string $key): void
{
    global $lang;

    // Fallback to the key name if the translation doesn't exist
    $text = $lang[$key] ?? $key;

    echo htmlspecialchars($text, ENT_QUOTES, 'UTF-8');
}
*/



/*
 * =============================================================================
 * SECTION: REQUIRED ARRAYS
 * =============================================================================
 * Predefined arrays used by the fpa at various points in the script execution.
 *
 * Why Predefine Arrays and keys where possible? (I know, it's a pain-in-the-A)
 * Where possible it is both quicker for performance and significantly better for
 * code quality to predefine arrays and all their expected keys at the very
 * beginning. This practice also adheres to safer, defensive fallback defaults
 * reducing unexpected warnings and assisting with debugging.
 * PHP calculates the exact memory footprint needed once at the start of execution
 * instead of pausing execution to recalculate and copy the old array. As we use
 * quite a few arrays, this can be costly.
 */
// Initialize an empty issues queue
// this is updated throughout the fpa script adding any discovered issues
//
// if ($some_error_crieria) {
//    $fpa_exception_queue[] = [
//        'type'        => 'danger', // Bootstrap color code
//        'text'        => 'Graphical metrics are enabled but data source is unavailable.',
//        'solution'    => 'Disable Graphical Metrics or upload a valid system data log source file.',
//        'target_id'   => 'show_graphics' // Matches the ID of the checkbox in your offcanvas layout!
//    ];
// }
$fpa_exception_queue = [];

// --- Basic Live Version Checks ---
$fpa_latest_versions = [
    'meta' => [
        'name' => 'FPA_META_VERSIONS' // Language Key: e.g., 'Live Version Status'
    ],
    'fpa' => [
        'label'   => 'FPA_LABEL_FPA', // Language Key: 'Forum Post Assistant'
        'current' => FPA_VERSION,     // Linked to your core constant flag
        'latest'  => 'Unknown',
        'status'  => 'Unknown'
    ],
    'joomla' => [
        'label'   => 'FPA_LABEL_JOOMLA', // Language Key: 'Joomla! Core'
        'current' => '5.1.2',            // Populated by your version parsing loop
        'latest'  => 'Unknown',
        'status'  => 'Unknown'
    ],
    'php' => [
        'label'   => 'FPA_LABEL_PHP', // Language Key: 'PHP Application Engine'
        'current' => PHP_VERSION,
        'latest'  => 'Unknown',
        'status'  => 'Unknown'
    ]
];

// --- Primary Application Versions ---
$fpa_app_versions = [
    'meta' => [
        'name' => 'FPA_META_APP_VERSIONS' // Language Key: 'Application Versions'
    ],
    'targets' => [] // Populated dynamically with environment metadata during runtime
];

// --- Core Joomla Structure Diagnostics ---
$fpa_joomla_instance = [
    'meta' => [
        'name' => 'FPA_META_INSTANCE_DIAG' // Language Key: 'Joomla Core Instance Diagnostics'
    ],
    'found'              => $lang['FPA_NO'],
    'installed'          => $lang['FPA_NO'],
    'config_override'     => $lang['FPA_UNKNOWN'],
    'config_path'         => $lang['FPA_UNKNOWN'],
    'config_writable'     => $lang['FPA_UNKNOWN'],
    'config_world_w'      => $lang['FPA_UNKNOWN'],
    'config_mode'         => $lang['FPA_UNKNOWN'],
    'config_owner'        => $lang['FPA_UNKNOWN'],
    'config_group'        => $lang['FPA_UNKNOWN'],
    'config_owner_match'  => $lang['FPA_UNKNOWN'],
    'readiness_grade'    => $lang['FPA_UNKNOWN'],
    'readiness_score'    => $lang['FPA_UNKNOWN'],
    'jconfig'             => []
];

// --- Environment Rating Metrics (Enhances and adds to v1 Confidence Rating) ---
$fpa_environment = [
    'meta' => [
        'name' => $lang['FPA_META_SYSTEMSASSURANCE'] // Language Key: 'Environment Metrics'
    ],
    'score'           => 100, // Starts perfect, drops as vulnerabilities are found
    'phpProcessUser'  => $lang['FPA_UNKNOWN'],
    'umask'           => '0000',
    'sslActive'       => false,
    'displayErrors'   => false
];

// --- Security Rating Metrics (New in FPA v2, adds to Confidence Rating) ---
$fpa_security = [
    'meta' => [
        'name' => $lang['FPA_META_PLATFORMINTEGRITY'] // Language Key: 'Security & Hardening Metrics'
    ],
    'score'            => 100, // Starts perfect, drops as vulnerabilities are found
    'phpProcessUser'   => $lang['FPA_UNKNOWN'],
    'sslActive'        => false,
    'displayErrors'    => false
];

// --- Host, PHP & Instance Performance Rating Metrics (New in FPA v2, adds to Confidence Rating) ---
$fpa_performance = [
    'meta' => [
        'name' => $lang['FPA_META_TUNINGOPTIMISATION'] // Language Key: 'Performance Metrics'
    ],
    'score'            => 100, // Starts perfect, drops as bottlenecks are found
    'memoryLimit'      => $lang['FPA_UNKNOWN'],
    'maxExecutionTime' => 0,
    'opcacheEnabled'   => false,
    'gzipEnabled'      => false
];

// --- Directories To Be Tested For Sane Permissions ---
$fpa_joomla_folders = [
    'meta' => [
        'name'            => $lang['FPA_META_CORE_FOLDERS'],
        'php_user'        => $lang['FPA_UNKNOWN'],
        'php_uid'         => $lang['FPA_UNKNOWN'],
        'umask'           => $lang['FPA_UNKNOWN']
    ],
    'folders' => [
        'api/' => [
            'owner'       => 'unknown',
            'group'       => 'unknown',
            'perms'       => '0000',
            'writable'    => false,
            'required'    => true,
            'exists'      => false,
            'sane'        => true,
            'warning'     => false,
            'owner_match' => true
        ],
        'cache/' => [ // Core caching
            'owner'       => 'unknown',
            'group'       => 'unknown',
            'perms'       => '0000',
            'writable'    => false,
            'required'    => true,
            'exists'      => false,
            'sane'        => true,
            'warning'     => false,
            'owner_match' => true
        ],
        'components/' => [ // Must be writable for extensions
            'owner'       => 'unknown',
            'group'       => 'unknown',
            'perms'       => '0000',
            'writable'    => false,
            'required'    => true,
            'exists'      => false,
            'sane'        => true,
            'warning'     => false,
            'owner_match' => true
        ],
        'images/' => [ // Must be writable for media uploads
            'owner'       => 'unknown',
            'group'       => 'unknown',
            'perms'       => '0000',
            'writable'    => false,
            'required'    => true,
            'exists'      => false,
            'sane'        => true,
            'warning'     => false,
            'owner_match' => true
        ],
        'language/' => [
            'owner'       => 'unknown',
            'group'       => 'unknown',
            'perms'       => '0000',
            'writable'    => false,
            'required'    => true,
            'exists'      => false,
            'sane'        => true,
            'warning'     => false,
            'owner_match' => true
        ],
        'libraries/' => [
            'owner'       => 'unknown',
            'group'       => 'unknown',
            'perms'       => '0000',
            'writable'    => false,
            'required'    => true,
            'exists'      => false,
            'sane'        => true,
            'warning'     => false,
            'owner_match' => true
        ],
        'logs/' => [
            'owner'       => 'unknown',
            'group'       => 'unknown',
            'perms'       => '0000',
            'writable'    => false,
            'required'    => true,
            'exists'      => false,
            'sane'        => true,
            'warning'     => false,
            'owner_match' => true
        ],
        'media/' => [
            'owner'       => 'unknown',
            'group'       => 'unknown',
            'perms'       => '0000',
            'writable'    => false,
            'required'    => true,
            'exists'      => false,
            'sane'        => true,
            'warning'     => false,
            'owner_match' => true
        ],
        'media/cache/' => [
            'owner'       => 'unknown',
            'group'       => 'unknown',
            'perms'       => '0000',
            'writable'    => false,
            'required'    => true,
            'exists'      => false,
            'sane'        => true,
            'warning'     => false,
            'owner_match' => true
        ],
        'modules/' => [
            'owner'       => 'unknown',
            'group'       => 'unknown',
            'perms'       => '0000',
            'writable'    => false,
            'required'    => true,
            'exists'      => false,
            'sane'        => true,
            'warning'     => false,
            'owner_match' => true
        ],
        'plugins/' => [
            'owner'       => 'unknown',
            'group'       => 'unknown',
            'perms'       => '0000',
            'writable'    => false,
            'required'    => true,
            'exists'      => false,
            'sane'        => true,
            'warning'     => false,
            'owner_match' => true
        ],
        'templates/' => [
            'owner'       => 'unknown',
            'group'       => 'unknown',
            'perms'       => '0000',
            'writable'    => false,
            'required'    => true,
            'exists'      => false,
            'sane'        => true,
            'warning'     => false,
            'owner_match' => true
        ],
        'tmp/' => [ // Extension installation
            'owner'       => 'unknown',
            'group'       => 'unknown',
            'perms'       => '0000',
            'writable'    => false,
            'required'    => true,
            'exists'      => false,
            'sane'        => true,
            'warning'     => false,
            'owner_match' => true
        ],
        'administrator/cache/' => [
            'owner'       => 'unknown',
            'group'       => 'unknown',
            'perms'       => '0000',
            'writable'    => false,
            'required'    => true,
            'exists'      => false,
            'sane'        => true,
            'warning'     => false,
            'owner_match' => true
        ],
        'administrator/components/' => [
            'owner'       => 'unknown',
            'group'       => 'unknown',
            'perms'       => '0000',
            'writable'    => false,
            'required'    => true,
            'exists'      => false,
            'sane'        => true,
            'warning'     => false,
            'owner_match' => true
        ],
        'administrator/logs/' => [
            'owner'       => 'unknown',
            'group'       => 'unknown',
            'perms'       => '0000',
            'writable'    => false,
            'required'    => true,
            'exists'      => false,
            'sane'        => true,
            'warning'     => false,
            'owner_match' => true
        ],
        'administrator/manifests/' => [
            'owner'       => 'unknown',
            'group'       => 'unknown',
            'perms'       => '0000',
            'writable'    => false,
            'required'    => true,
            'exists'      => false,
            'sane'        => true,
            'warning'     => false,
            'owner_match' => true
        ],
        'administrator/modules/' => [
            'owner'       => 'unknown',
            'group'       => 'unknown',
            'perms'       => '0000',
            'writable'    => false,
            'required'    => true,
            'exists'      => false,
            'sane'        => true,
            'warning'     => false,
            'owner_match' => true
        ],
        'administrator/language/' => [
            'owner'       => 'unknown',
            'group'       => 'unknown',
            'perms'       => '0000',
            'writable'    => false,
            'required'    => true,
            'exists'      => false,
            'sane'        => true,
            'warning'     => false,
            'owner_match' => true
        ],
        'administrator/templates/' => [
            'owner'       => 'unknown',
            'group'       => 'unknown',
            'perms'       => '0000',
            'writable'    => false,
            'required'    => true,
            'exists'      => false,
            'sane'        => true,
            'warning'     => false,
            'owner_match' => true
        ]

    ]
];

// Elevated Permisisons Folder Checks
//$elevatedFolders = [];

// --- folder permissions results arrays ---
// The exceptions arrays will be populated by the fpa_XXXXXXXXXXXXX function,
// containing the following elements;
//
// exceptions
// --------- path           (string)  (relative to siteroot)
// --------- exists         (boolean) (path is present, only displayed for $JoomlaFolders)
// --------- owner          (string)  (name or uid, if no posix or is windows)
// --------- group          (string)  (name or uid, if no posix or is windows)
// --------- mode           (string)  (integer converted to octal)
// --------- is_readable    (boolean) (readable by the owner/phpuser)
// --------- is_owner_w     (boolean) (owner writable?)
// --------- is_group_w     (boolean) (group writable?)
// --------- is_world_w     (boolean) (world writable?)
// --------- sane           (boolean) (secure & safe?)
// --------- owner_match    (boolean) (owner and php process user the same?)
// --------- has_suid       (boolean) (set User ID on?)
// --------- has_guid       (boolean) (set Group ID on?)
// --------- has_sticky     (boolean) (Sticky Bit on?)

// extended folder elevated permissions (exceptions only) - discovered from file-system, excluding $fpa_joomla_folders array
$fpa_elevated_permissions = [
    'meta' => [
        'name'        => $lang['FPA_META_FOLDER_PERMS'],
    ],
    'folders'         => []
];




/*
 * =============================================================================
 * SECTION: CENTRAL FPA UTILITY & REFERENCES
 * =============================================================================
 * Initialize a central reference table once at script initialization to reduce
 * expensive system calls and improve consistency.
 *
 */
$php_process_user = $lang['FPA_UNKNOWN'];
if (function_exists('posix_getpwuid') && function_exists('posix_geteuid')) {
    $process_info     = posix_getpwuid(posix_geteuid());
    $php_process_user = $process_info['name'] ?? $lang['FPA_UNKNOWN'];
} elseif (function_exists('get_current_user')) {
    $php_process_user = get_current_user();
}


$fpa_reference = [
    'php' => [
        'version'        => PHP_VERSION,
        'interface_sapi' => PHP_SAPI, // e.g. cgi-fcgi, fpm-fcgi, apache2handler
        'process_user'   => function_exists('posix_getpwuid') && function_exists('posix_getuid')
                            ? posix_getpwuid(posix_getuid())['name']
                            : (getenv('USER') ?: getenv('USERNAME')),
        'process_uid'    => function_exists('posix_getuid') ? posix_getuid() : fileowner(__FILE__),
        'process_gid'    => function_exists('posix_getgid') ? posix_getgid() : filegroup(__FILE__),
        'disabled_functions' => ini_get('disable_functions') ?: $lang['FPA_NONE'],
    ],
    'server' => [
        'os_family'      => PHP_OS_FAMILY, // Returns "Windows", "Linux", "Darwin", etc.
	    'os_family_short'       => strtolower(substr( PHP_OS, 0, 3)), // WIN, DAR, LIN, SOL
        'os_release'     => php_uname('r'),
        'hostname'     => function_exists('gethostname') ? gethostname() : (php_uname('n') ?: $lang['FPA_UNKNOWN']),
        'host_ip' => gethostbyname(gethostname()),
        'technology'     => php_uname('m'),
        'web_server'       => $_SERVER['SERVER_SOFTWARE'] ?? $lang['FPA_UNKNOWN'],
	'web_server_short'      => strtolower(substr( $_SERVER['SERVER_SOFTWARE'], 0, 3 )), // apa = Apache, mic = Microsoft IIS, lit = LiteSpeed etc
    'web_server_encoding' => $_SERVER["HTTP_ACCEPT_ENCODING"],
        'umask'          => sprintf('%04o', umask()), // e.g. "0022"


        //'site_domain' => strtolower($_SERVER['HTTP_HOST'] ?? ($_SERVER['SERVER_NAME'] ?? $lang['FPA_UNKNOWN'])),
    ],
    'environment' => [
        'max_execution'  => (int)ini_get('max_execution_time'),
        'memory_limit'   => ini_get('memory_limit'),
        'safe_mode_alt'  => (bool)ini_get('open_basedir'), // True if directory jail restrictions exist
    ]
];

/**
 * --- Get Networking Information ---
 * collect and aggregate the network environment and infrastructure tier of the
 * host and domain, then append it to the $fpa_reference array (above) under the
 * $fpa_reference['site'] key
 *
 * @return array The compiled system network architecture identity.
 *
 */
function fpa_get_network_environment(array $fpa_ref): array
{
    global $lang; // access the current language array

    // --- Existing Network Variable Extractions ---
    $raw_domain = $_SERVER['HTTP_HOST'] ?? ($_SERVER['SERVER_NAME'] ?? $lang['FPA_UNKNOWN']);
    $domain_name = strtolower(strtok($raw_domain, ':'));
    //$server_hostname = function_exists('gethostname') ? gethostname() : (php_uname('n') ?: $lang['FPA_UNKNOWN']);
    $server_port  = isset($_SERVER['SERVER_PORT']) ? (int)$_SERVER['SERVER_PORT'] : 0;
    $visitor_port = isset($_SERVER['REMOTE_PORT']) ? (int)$_SERVER['REMOTE_PORT'] : 0;
    //$server_software = $_SERVER['SERVER_SOFTWARE'] ?? 'Unknown';

    // --- Attempt Proxy & Reverse Pathway Detection ---
    $proxy_detected = 'Direct Connection';

    // Scan headers for active signatures
    if (isset($_SERVER['HTTP_CF_RAY']) || isset($_SERVER['HTTP_CF_CONNECTING_IP'])) {
        $proxy_detected = 'Cloudflare Reverse Proxy'; // 👈 Cloudflare confirmed
    } elseif (isset($_SERVER['HTTP_X_SUCURI_CLIENTIP'])) {
        $proxy_detected = 'Sucuri Firewall Proxy';
    } elseif (isset($_SERVER['HTTP_X_FORWARDED_FOR']) || isset($_SERVER['HTTP_VIA'])) {
        $proxy_detected = 'Generic Reverse Proxy / Load Balancer';
    }

    // --- Infrastructure Tier Inference Engine ---
    // this is a little bit of guess-work, absolutely no science involved
    $infra_tier = 'VPS / Cloud / Dedicated (Private Node)'; // Default baseline assumption

    // Check for known Shared Hosting cluster hostname structures
    if (preg_match('/(shared|hcp|cpanel|plesk|box|cluster|grid|sgvps|unified|hostgator|bluehost|secureserver)/i', $fpa_ref['server']['hostname'])) {
        $infra_tier = 'Shared Hosting (Inferred via Node Identity)';
    }

    // Check environment user accounts
    // On isolated private VPS nodes, PHP often runs as 'root', 'ubuntu', 'vagrant', or 'admin'
    // On shared platforms, users are allocated random string hashes (e.g., 'u38291aa')
    // TODO: change to use $fpa_reference user
    ///$system_user = function_exists('posix_getpwuid') && function_exists('posix_getuid')
    ///               ? posix_getpwuid(posix_getuid())['name']
    ///               : (getenv('USER') ?: 'unknown');

    if ($infra_tier !== 'Shared Hosting (Inferred via Node Identity)') {
        if (preg_match('/^(root|ubuntu|debian|centos|admin|apache|www-data)$/', $fpa_ref['php']['process_user'])) {
             $infra_tier = 'VPS / Cloud Server Infrastructure (Dedicated OS Image)';
        } else {
             // Randomly generated hosting usernames imply shared isolation partitions
             $infra_tier = 'Shared Hosting (Inferred via System Isolation User)';
        }
    }

    // Check available execution utilities
    // Shared environments strictly disable low-level hardware or loop control execution parameters
    $disabled_functions = explode(',', ini_get('disable_functions') ?: '');
    $disabled_functions = array_map('trim', $disabled_functions);

    if (in_array('shell_exec', $disabled_functions) || in_array('exec', $disabled_functions)) {
        $infra_tier = 'Shared Hosting (Confirmed via Function Disabling)';
    }

    return [
        'domain_name'      => $domain_name,
        'domain_ip' => gethostbyname($_SERVER['SERVER_NAME']),
        //'server_hostname'  => $server_hostname,
        'server_port'      => $server_port,
        'visitor_port'     => $visitor_port,
        'proxy_layer'      => $proxy_detected,
        'infrastructure'   => $infra_tier,
        //'system_user'      => $system_user,
        //'server_software'  => $server_software
    ];
}
// run the networking function and append to the $fpa_reference array, also
// using the existing $fpa_reference keys ini [php] & [server]
$fpa_reference['site'] = fpa_get_network_environment($fpa_reference);



/*
    $phpenv['phpVERSION'] = phpversion();
    $system['sysPLATFUL'] = php_uname('a');
    $system['sysPLATOS'] = php_uname('s');
    $system['sysPLATREL'] = php_uname('r');
    $system['sysPLATFORM'] = php_uname('v');
    $system['sysPLATNAME'] = php_uname('n');
    $system['sysPLATTECH'] = php_uname('m');
    $system['sysSERVNAME'] = $_SERVER['SERVER_NAME'];
    $system['sysSERVIP'] = gethostbyname($_SERVER['SERVER_NAME']);
    $system['sysSERVSIG'] = $_SERVER['SERVER_SOFTWARE'];
    $system['sysENCODING'] = $_SERVER["HTTP_ACCEPT_ENCODING"];
    $system['sysCURRUSER'] = get_current_user(); // current process user
    $system['sysSERVIP'] = gethostbyname($_SERVER['SERVER_NAME']);

	$phpenv['phpERRORDISPLAY']  = ini_get( 'display_errors' );
	$phpenv['phpERRORREPORT']   = ini_get( 'error_reporting' );
	$fpa['ORIGphpMEMLIMIT']     = ini_get( 'memory_limit' );
	$fpa['ORIGphpMAXEXECTIME']  = ini_get( 'max_execution_time' );
	$phpenv['phpERRLOGFILE']    = ini_get( 'error_log' );
	$system['sysSHORTOS']       = strtoupper( substr( PHP_OS, 0, 3 ) ); // WIN, DAR, LIN, SOL
	$system['sysSHORTWEB']      = strtoupper( substr( $_SERVER['SERVER_SOFTWARE'], 0, 3 ) ); // APA = Apache, MIC = MS IIS, LIT = LiteSpeed etc

*/

/*
 * =============================================================================
 * SECTION: FPA SPECIAL FEATURES
 * =============================================================================
 * Custom FPA admin & security features (if enabled/true in the config
 * constants)
 *
 */

/**
 * FPA Self Destruct
 *  - deletes FPA if _FPA_SELF_DESTRUCT_AGE exceeded
 *  - if _FPA_DEV or _FPA_DIA are defined/TRUE then self-destruction won't happen
 */
// Self Desruct: Delete fpa (& diagnostic logfiles, if found) on next run if
// filetime date exceeds configured age


/**
 * FPA SSL Redirect
 * - redirects to the SSL site if available
 *  - if _FPA_DEV or _FPA_DIA are defined/TRUE then redirection won't happen
 */
// SSL Redirect : redirect to the ssl site, if available


/**
 * LiveChecks
 * Dynamically queries official remote repositories (GitHub, Joomla, PHP, etc.)
 * to fetch latest software versions and security advisories.
 *
 * doLiveChecks requires cURL and either json or simpleXML to function corectly.
 * - Validate local required PHP extensions (curl, json, simplexml) against each
 *   feed's required 'format' before adding to $doLiveChecks.
 * - complies with later 'curl_multi' requirements to fire all active HTTP requests
 *   in parallel later, ensuring total page wait time equals only the single
 *   slowest feed.
 */




/*
 * =============================================================================
 * SECTION: JOOMLA INSTANCE DETECTION
 * =============================================================================
 * Validates the presence of an active Joomla! core environment structure.
 * - confirms the presence of known files and folders
 * - separately inspects configuration definitions (defines.php) to isolate custom
 *   file targets.
 */
/*
$joomlaInstance = [
    'found'             => $lang['FPA_NO'],
    'installed'         => $lang['FPA_NO'],
    'configOverride'     => false,
    'configPath'         => $lang['FPA_UNKNOWN'],
    'configWritable'     => $lang['FPA_NO'],
    'configMode'         => $lang['FPA_UNKNOWN'],
    'configOwner'        => $lang['FPA_UNKNOWN'],
    'configGroup'        => $lang['FPA_UNKNOWN'],
    'phpProcessUser'    => $lang['FPA_UNKNOWN'],
    'ownershipConflict'  => false
];
*/

// Core Structure Check: Maintain legacy structural validation blocks
$has_root_dirs  = file_exists('components/') && file_exists('modules/');
$has_admin_dirs = file_exists('administrator/components/') && file_exists('administrator/modules/');
$has_index_file  = file_exists('index.php');

if (($has_root_dirs || $has_admin_dirs) && $has_index_file) {
    // Structural presence verified (CMS footprint exists on server)
    $fpa_joomla_instance['found'] = $lang['FPA_YES'];

    // Separate Installation Check: Determine JPATH_CONFIGURATION path rules
    // Establish the absolute runtime baseline representing JPATH_ROOT
    $jpath_root = rtrim(str_replace('\\', '/', __DIR__), '/');
    $config_search_path = $jpath_root; // Default configuration home directory

    // Check for custom overrides mapped via local defines.php scripts
    $defines_targets = [
        'includes/defines.php',
        'administrator/includes/defines.php',
        'defines.php'
    ];

    // Find the configuration.php loction via the defines.php
    foreach ($defines_targets as $target_file) {
        if (file_exists($target_file) && is_readable($target_file)) {
            $file_content = file_get_contents($target_file);

            // Catch native format: define('JPATH_CONFIGURATION', JPATH_ROOT . '/custom');
            // Or modern format:   \define('JPATH_CONFIGURATION', JPATH_ROOT . '/custom');
            $pattern = '/\\\\?define\s*\(\s*[\'"]JPATH_CONFIGURATION[\'"]\s*,\s*(.*?)\s*\)\s*;/i';

            if (preg_match($pattern, $file_content, $matches)) {
                $raw_expression = trim($matches[1]);

                // If it isn't strictly assigning to JPATH_ROOT, evaluate the value
                if ($raw_expression !== 'JPATH_ROOT' && $raw_expression !== '\\JPATH_ROOT') {

                    // Clean up common syntax to safely evaluate the text expression string
                    $clean_expression = str_replace(['JPATH_ROOT', '\\JPATH_ROOT', 'DIRECTORY_SEPARATOR', '.', '"', "'", ' '], ['', '', '/', '', '', '', ''], $raw_expression);
                    $clean_expression = '/' . trim($clean_expression, '/');

                    // Build absolute system override target path
                    $config_search_path = rtrim($jpath_root . $clean_expression, '/');

                    // FIXED: Aligned array keys with initialization block
                    $fpa_joomla_instance['config_override'] = true;
                    break;
                }
            }
        }
    }

    // Final Verification: Check if the configuration target file exists and is active
    $config_file_path = $config_search_path . '/configuration.php';

    if (file_exists($config_file_path) && is_readable($config_file_path) && filesize($config_file_path) > 0) {
        $fpa_joomla_instance['installed']  = $lang['FPA_YES'];
        $fpa_joomla_instance['config_path'] = $config_file_path; // Saved path safely

        // Defensive: is_writable() is the standard native PHP function name alias
        // we also check for ownership later as writeable does not always mean, writeable securely (think wheel-groups)
        if (is_writable($config_file_path)) {
            $fpa_joomla_instance['config_writable'] = $lang['FPA_YES'];
        }

        // Get the configuration file permissions (Cleaned up redundant file_exists checks)
        // Bitwise AND mask isolates ONLY the lower 9 permission bits (ignores file-type flags)
        // and forces a zero-padded, 4-digit octal string output (e.g., '0644')
        $fpa_joomla_instance['config_mode'] = sprintf('%04o', fileperms($config_file_path) & 0777);

        // Obtain the configuration file owner and group
        if (function_exists('posix_getpwuid') && function_exists('posix_getgrgid') && !$is_windows) {
            // Fetch raw system info blocks safely
            $owner_info = posix_getpwuid(fileowner($config_file_path));
            $group_info = posix_getgrgid(filegroup($config_file_path));

            // Defensive: Use Null Coalescing (??) to grab the string name or fall back to numeric ID
            $fpa_joomla_instance['config_owner'] = $owner_info['name'] ?? fileowner($config_file_path);
            $fpa_joomla_instance['config_group'] = $group_info['name'] ?? filegroup($config_file_path);
        } else {
            // Windows fallback
            $fpa_joomla_instance['config_owner'] = fileowner($config_file_path);
            $fpa_joomla_instance['config_group'] = filegroup($config_file_path);
        }

        // discover who is currently executing this PHP script run
        // on some shared servers, wheel-groups may be used, potentially allowing other wheel-group members cross-account
        // access to writeable files, here we check that the executing user is the ownership user
        $php_process_user = 'Unknown';
        if (function_exists('posix_getpwuid') && function_exists('posix_geteuid') && !$is_windows) {
            $process_info = posix_getpwuid(posix_geteuid());
            $php_process_user = $process_info['name'] ?? 'Unknown';
        } else {
            $php_process_user = get_current_user(); // Fallback identification method
        }

        // perform a defensive cross-check evaluation
        $fpa_joomla_instance['config_owner_match'] = true;

        if ($fpa_joomla_instance['config_owner'] !== $php_process_user && $php_process_user !== 'Unknown') {
            // flag an ownership conflict alert if names do not match
            $fpa_joomla_instance['config_owner_match'] = false;
        }

        // save the process user name to the array for display on the dashboard
        // - moved to $fpa_reference array
        ///$fpa_joomla_security['php_process_user'] = $php_process_user;

    }
}




/*
 * SECTION: IMPORT JOOMLA CONFIGURATION
 */
if ($fpa_joomla_instance['config_path'] &&
    is_readable($fpa_joomla_instance['config_path']) &&
    filesize($fpa_joomla_instance['config_path']) > 0) {
    $includeconfig = require_once($fpa_joomla_instance['config_path']);
    $fpa_joomla_instance['jconfig'] = new JConfig();
}



/*
 * CORE FOLDER & PERMISSIONS CHECK
 */

// clear filesystem stats
clearstatcache();

// Define your framework base root folder path
// =========================================================================
// 1. ANCHOR BASE PATH TO SCRIPT POSITION (Joomla Root)
// =========================================================================
$base_path = __DIR__;



// =========================================================================
// 2. DISCOVER ACTIVE PHP PROCESS SYSTEM USER
// =========================================================================
$php_process_user = 'unknown';
if (function_exists('posix_getpwuid') && function_exists('posix_geteuid')) {
    $process_info = posix_getpwuid(posix_geteuid());
    $php_process_user = $process_info['name'] ?? 'unknown';
} elseif (function_exists('get_current_user')) {
    $php_process_user = get_current_user();
}




// =========================================================================
// 4. LIVE RELATIVE PROCESSING LOOP (UPDATED FOR DANGER & WARNING TIERS)
// =========================================================================
foreach ($fpa_joomla_folders['folders'] as $path => &$details) {
    $full_path = $base_path . '/' . $path;

    if (file_exists($full_path) && is_dir($full_path)) {
        $details['exists'] = true;

        // 1. Read octal numeric modes (e.g. 0755)
        $file_perms = fileperms($full_path);
        $details['perms'] = substr(sprintf('%o', $file_perms), -4); // e.g., "0755"

        // 2. Check writable engine flag status
        $details['writable'] = is_writable($full_path);

        // 3. SECURE PERMISSION ANALYSIS ENGINE
        // Split the 4-digit octal string into individual position characters
        $digits = str_split($details['perms']); // [0, Owner, Group, World]
        $owner_bit = isset($digits[1]) ? (int)$digits[1] : 0;
        $group_bit = isset($digits[2]) ? (int)$digits[2] : 0;
        $world_bit = isset($digits[3]) ? (int)$digits[3] : 0;

        // CRITICAL DANGER CHECK: World-Writable (Ends in 7 or 6) or global 777
        if ($world_bit === 7 || $world_bit === 6 || $details['perms'] === '0777') {
            $details['sane']    = false;
            $details['warning'] = false; // Danger takes priority
        }
        // WARNING CHECK: Group-Writable (x7x) (REMOVED)or Loose Owner configurations (7xx)
        elseif ($group_bit === 7) {
        //elseif ($groupBit === 7 || $ownerBit === 7) {
            $details['sane']    = true;  // Not critically broken/world-open
            $details['warning'] = true;  // Flag as a configuration warning
        } else {
            $details['sane']    = true;
            $details['warning'] = false; // Safe standard compliance mode (e.g., 0755)
        }

        // 4. Resolve OS profile statistics info via POSIX helper extensions
        if (function_exists('posix_getpwuid')) {
            $owner_data = posix_getpwuid(fileowner($full_path));
            $details['owner'] = $owner_data['name'] ?? 'unknown';

            $group_data = posix_getgrgid(filegroup($full_path));
            $details['group'] = $group_data['name'] ?? 'unknown';

            if ($php_process_user !== 'unknown' && $details['owner'] !== 'unknown') {
                $details['owner_match'] = ($details['owner'] === $php_process_user);
            }
        }
    }
}
unset($details);


/*
 * =========================================================================
 * 4. ELEVATED PERMISSIONS TESTS
 * =========================================================================
 * Iterate through the file-system folders checking for insecure and dangerous
 * standard and special mode permissions, exits upon finding $max_violations of
 * folders with elevated permissions to save excessive runtime with a massive
 * error list output
 */
function fpa_audit_permissions(string $base_path, array $exclude_list, array $ref): array {

    $fpa_elevated_permissions['folders'] = []; // output array
    $max_violations = 20; // number of exceptions before exiting

    // Identify the environment user running this PHP process (e.g. www-data)
    // TODO: check if needed still, if using $ref array for comparison data
    // Fallback securely to the file owner of the script if POSIX isn't available
    //$php_user_uid = function_exists('posix_getuid') ? posix_getuid() : fileowner(__FILE__);
    $php_process_user = 'unknown';
    $php_process_uid  = 'unknown';
    if (function_exists('posix_getpwuid') && function_exists('posix_geteuid')) {
        $process_info     = posix_getpwuid(posix_geteuid());
        $php_process_user = $process_info['name'] ?? 'unknown';
        $php_process_uid = $process_info['uid'] ?? 'unknown';
    } elseif (function_exists('get_current_user')) {
        $php_process_user = get_current_user();
        $php_process_uid = get_current_user();
    }

    // Ensure directory path trailing slash is structured uniformly
    $base_path = rtrim($base_path, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR;

    if (!is_dir($base_path)) {
        return [];
    }

    // Instantiate a recursive directory scanner
    $directory = new RecursiveDirectoryIterator($base_path, RecursiveDirectoryIterator::SKIP_DOTS);
    $iterator  = new RecursiveIteratorIterator($directory, RecursiveIteratorIterator::SELF_FIRST);

    foreach ($iterator as $item) {
        // Enforce the execution break instantly if limits are reached
        if (count($fpa_elevated_permissions['folders']) >= $max_violations) {
            break;
        }

        // Only scan directories
        if ($item->isDir()) {
            $real_path = $item->getRealPath();

            // Use the existing $real_path variable safely
            $full_path = is_dir($real_path) ? realpath($real_path) : realpath($base_path . $real_path);

            // Evaluate path boundaries against the exclusions dictionary
            foreach ($exclude_list as $folder_key => $folder_data) {
                // Combine base path with the exclusion key (e.g., "/var/www/html/" . "administrator/")
                $clean_excluded = realpath($base_path . $folder_key);

                if ($clean_excluded && ($full_path === $clean_excluded)) {
                    continue 2; // Only skip if it is exactly the core folder itself
                }
            }

            // Extract UNIX mode permissions
            $perms = $item->getPerms();

            /**
             * Check the Standard Modes/Permissions
             * Owner | Group | World
             *
             */
            // Check if the folder is Owner-Writable (e.g. 2xx, 3xx, 6xx, 7xx)
            $is_owner_writable = (bool)($perms & 0x0080);

            // Check if the folder is Group-Writable (e.g. x2x, x3x, x6x, x7x)
            $is_group_writable = (bool)($perms & 0x0010);

            // Check if the folder is World-Writable (e.g. xx2, xx3, xx6, xx7)
            $is_world_writable = (bool)($perms & 0x0002);

            /**
             * Check the Special Modes/Permissions
             * 4000 = SUID
             * 2000 = SGID
             * 1000 = Sticky Bit
             *
             */
            // If an executable file inside a folder has this bit active, it runs with the
            // privileges of the file owner (often root) rather than the user executing it.
            $has_suid         = (bool)($perms & 0x0800);

            // Files created inside directories with this bit active inherit the group
            // configuration of the parent folder rather than the group of the creating user.
            $has_sgid         = (bool)($perms & 0x0400);

            // Restricts deletion privileges. In a directory with the sticky bit set,
            // a user can only delete or rename files they personally own.
            $has_sticky_bit    = (bool)($perms & 0x0200);

            // Test ownership matches
            $folder_owner_uid = $item->getOwner();
            $owner_match      = ($folder_owner_uid === $ref['php']['process_uid']);

            // Audit if folder permissions cross standard 755 boundaries or set & sticky bits
            if ($is_world_writable || $is_group_writable || !$owner_match || $has_suid || $has_sgid || $has_sticky_bit) {

                // Calculate the relative path by removing the basePath string
                $relative_path = str_replace($base_path, '', $real_path). '/';

                $fpa_elevated_permissions['folders'][] = [
                    'path'        => $relative_path,
                    'permissions' => substr(sprintf('%o', $perms), -4), // e.g. "0777"
                    'is_owner_w'  => $is_owner_writable,
                    'is_group_w'  => $is_group_writable,
                    'is_world_w'  => $is_world_writable,
                    'owner_match' => $owner_match,
                    'owner_uid'   => $folder_owner_uid,
                    'process_uid' => $php_process_uid,
                    'has_suid'    => $has_suid, // Set UserID bit
                    'has_sgid'    => $has_sgid, // Set GroupID bit
                    'has_sticky'  => $has_sticky_bit // Sticky Bit Set
                ];
            }
        }
    }

    return $fpa_elevated_permissions['folders'];
}


// --- Dynamic Workflow Execution & Arguments ---
// TODO: try to remove the need to enter the site root in the arguments
$site_root = __DIR__;
$exclude_list     = $fpa_joomla_folders['folders'] ?? [];
$fpa_elevated_permissions['folders'] = fpa_audit_permissions($site_root, $exclude_list, $fpa_reference);


// Only raise a single $fpa_exception_queue entry if $fpa_elevated_permissions is NOT empty
if (!empty($fpa_elevated_permissions['folders'])) {
    $fpa_exception_queue[] = [
        'category'    => 'Elevated Permissions',
        'type'        => 'danger', // Bootstrap color code / severity: dager/warning/info
        'text'        => 'At least one folder has elevated permissions or Set bits.',
        'solution'    => 'Reset permissions or Set bits to the system default.',
        'target_id'   => 'elevatedPermissions' // Matches the ID of the desired UI Panel element
    ];
}




/*
 * =============================================================================
 * SECTION: SYSTEM ASSESSMENT & GRADE CALCULATION
 * =============================================================================
 * Consolidates all gathered server and CMS metrics, processes risk scores,
 * and determines the final environmental Confidence Rating.
 *
 * ARRAYS IN USE:
 * - $joomlaInstance  : Read core targets (configPath) & writes final outputs (readinessGrade, readinessScore).
 * - $fpaEnvironment  : Read/writes server application configurations.
 * - $fpaSecurity     : Read/writes server infrastructure protection and permission configurations.
 * - $fpaPerformance  : Read/writes server environment processing and baseline bottleneck limits.
 * - $lang            : Pulls multi-language translation strings for user interface fallback.
 */

// Only execute the assessment if a valid Joomla installation was actually verified
if ($fpa_joomla_instance['found'] === $lang['FPA_YES'] && $fpa_joomla_instance['installed'] === $lang['FPA_YES']) {

    // 1. SECURITY & HARDENING ASSESSMENT
    // -------------------------------------------------------------------------
    $raw_perms = fileperms($fpa_joomla_instance['config_path']);
    $fpa_joomla_instance['config_mode'] = sprintf('%04o', $raw_perms & 0777);

    // Risk: Check for dangerously loose (World-Writable) permissions
    if (($raw_perms & 0002) !== 0) {
        $fpa_joomla_instance['is_world_writable'] = true;
        $fpa_security['score'] -= 40;
    }

    // Capture file owners and check identity alignment against the PHP process
    if (function_exists('posix_getpwuid') && !$is_windows) {
        $owner_info = posix_getpwuid(fileowner($fpa_joomla_instance['config_path']));
        $fpa_joomla_instance['config_owner'] = $owner_info['name'] ?? fileowner($fpa_joomla_instance['config_path']);

        $processInfo = posix_getpwuid(posix_geteuid());
        $fpa_security['php_process_user'] = $process_info['name'] ?? 'Unknown';
    } else {
        $fpa_joomla_instance['config_owner'] = fileowner($fpa_joomla_instance['config_path']);
        $fpa_security['php_process_pser']    = get_current_user();
    }

    // Risk: Flag an ownership mismatch conflict
    if ($fpa_joomla_instance['config_owner'] !== $fpa_security['php_process_user'] && $fpa_security['php_process_user'] !== 'Unknown') {
        $fpa_joomla_instance['config_owner_conflict'] = true;
        $fpa_security['score'] -= 20;
    }

    // Risk: Production display_errors is active
    if (filter_var(ini_get('display_errors'), FILTER_VALIDATE_BOOLEAN) || ini_get('display_errors') === '1') {
        $fpa_security['display_errors'] = true;
        $fpa_security['score'] -= 15;
    }

    $fpa_security['score'] = max(0, $fpa_security['score']);


    // 2. PERFORMANCE & BOTTLENECK ASSESSMENT
    // -------------------------------------------------------------------------
    $fpa_performance['memory_limit']       = ini_get('memory_limit');
    $fpa_performance['max_execution_time'] = (int) ini_get('max_execution_time');
    $fpa_performance['opcache_enabled']    = function_exists('opcache_get_status') && opcache_get_status(false) !== false;

    // Risk: Zend OPcache is completely disabled
    if (!$fpa_performance['opcache_enabled']) {
        $fpa_performance['score'] -= 30;
    }

    // Risk: Server timeout threshold is too restrictive
    if ($fpa_performance['max_execution_time'] > 0 && $fpa_performance['max_execution_time'] < 60) {
        $fpa_performance['score'] -= 20;
    }

    $fpa_performance['score'] = max(0, $fpa_performance['score']);


    // 3. ENVIRONMENT ASSESSMENT
    // -------------------------------------------------------------------------
    $fpa_environment['memory_limit']       = ini_get('memory_limit');
    $fpa_environment['max_execution_time'] = (int) ini_get('max_execution_time');
    $fpa_environment['opcache_enabled']    = function_exists('opcache_get_status') && opcache_get_status(false) !== false;


    if (function_exists('umask')) {
        try {
            // Calling umask() with no arguments fetches the active system state
            // without altering or mutating server parameters.
            $raw_mask = @umask();

            if ($raw_mask !== false && $raw_mask !== null) {
                // Convert integer to a standard 4-character octal string format (e.g., 0022)
                $fpa_environment['umask'] = str_pad(decoct($raw_mask), 4, '0', STR_PAD_LEFT);
            } else {
                $fpa_environment['umask'] = 'unknown (execution failed)';
            }
        } catch (\Throwable $e) {
            $fpa_environment['umask'] = 'restricted (exception caught)';
        }
    } else {
        // Graceful fallback for hardened servers or Windows runtime setups
        $fpa_environment['umask'] = 'unavailable (disabled/unsupported)';
    }

    // Risk: Zend OPcache is completely disabled
    if (!$fpa_environment['opcache_enabled']) {
        $fpa_environment['score'] -= 30;
    }

    // Risk: Server timeout threshold is too restrictive
    if ($fpa_environment['max_execution_time'] > 0 && $fpa_environment['max_execution_time'] < 60) {
        $fpa_environment['score'] -= 20;
    }

    $fpa_environment['score'] = max(0, $fpa_environment['score']);


    // 3. OVERALL ENVIRONMENT CONFIDENCE GRADE MAPPING
    // -------------------------------------------------------------------------
    $overall_score = (int) round(($fpa_security['score'] + $fpa_performance['score'] + $fpa_environment['score']) / 3);

    // TESTING ONLY
    ///$overallScore = 100;

    if ($overall_score >= 97) {
        $fpa_readiness_grade   = $lang['FPA_READINESS_APLUS']; // 97-100
        $fpa_readiness_color   = 'success';
        $fpa_readiness_summary = $lang['FPA_READINESS_MSG_A'];
    } elseif ($overall_score >= 90) {
        $fpa_readiness_grade   = $lang['FPA_READINESS_A']; // 90-96
        $fpa_readiness_color   = 'success';
        $fpa_readiness_summary = $lang['FPA_READINESS_MSG_A'];
    } elseif ($overall_score >= 80) {
        $fpa_readiness_grade   = $lang['FPA_READINESS_B']; // 80-95
        $fpa_readiness_color   = 'info';
        $fpa_readiness_summary = $lang['FPA_READINESS_MSG_B'];
    } elseif ($overall_score >= 70) {
        $fpa_readiness_grade   = $lang['FPA_READINESS_C']; // 70-94
        $fpa_readiness_color   = 'warning';
        $fpa_readiness_summary = $lang['FPA_READINESS_MSG_C'];
    } elseif ($overall_score >= 50) {
        $fpa_readiness_grade   = $lang['FPA_READINESS_D']; // 50-69
        $fpa_readiness_color   = 'warning';
        $fpa_readiness_summary = $lang['FPA_READINESS_MSG_D'];
    } elseif ($overall_score >= 25) {
        $fpa_readiness_grade   = $lang['FPA_READINESS_E']; // 25-49
        $fpa_readiness_color   = 'danger';
        $fpa_readiness_summary = $lang['FPA_READINESS_MSG_E'];
    } else {
        $fpa_readiness_grade   = $lang['FPA_READINESS_F']; // 0-24
        $fpa_readiness_color   = 'danger';
        $fpa_readiness_summary = $lang['FPA_READINESS_MSG_F'];
    }

    // Bind results back to the tracking data parameters for UI consumption
    $fpa_joomla_instance['readiness_grade'] = $fpa_readiness_grade;
    $fpa_joomla_instance['readiness_score'] = $overall_score;



}

/**
 * function to render ratings progress bars from the above test routines
 * TODO: need a better comment
 */
function render_score_bar($score_value) {
    // Ensure the value stays between 0 and 100
    $score_value = max(0, min(100, (int)$score_value));

    // Set the threshold for switching text placement
    $threshold = 10;

    // Define Bootstrap's theme colors to match the gradient transitions accurately
    $danger  = '#dc3545'; // Red
    $warning = '#ffc107'; // Yellow
    $info    = '#0dcaf0'; // Cyan
    $success = '#198754'; // Green

    // Define the full 0-100 linear gradient map
    $gradient = "linear-gradient(to right, $danger 5%, $warning 70%, $info 80%, $success 95%)";

    if ($score_value < $threshold) {
        // Classes for LOW percentages (text placed outside)
        // 'me-5' ensures the text has physical space to live without clipping outside the parent card

        // add a left border when the rating is 0 (zero)
        $border_class = ($score_value < 1) ? 'border-start border-danger border-2 rounded' : '';

        $parent_class = 'overflow-visible me-5 ';
        $bar_class    = 'position-relative overflow-visible bg-transparent';
        $text_class   = 'position-absolute top-50 start-100 translate-middle-y ps-2 fw-bold text-dark ' . $border_class;
    } else {
        // Classes for HIGH percentages (text placed inside at the end)
        $parent_class = '';
        $bar_class    = 'text-end Xd-flex Xjustify-content-end Xalign-items-center bg-transparent';
        $text_class   = 'pe-2 fw-bold text-white';
    }

    // Output the HTML
    // 1. We put the full gradient on the '.progress' container.
    // 2. We add a linear-gradient track mask on the '.progress' to shade the UNFILLED portion grey.
    return '
    <div class="progress rounded ' . $parent_class . ' w-100" role="progressbar" aria-valuenow="' . $score_value . '" aria-valuemin="0" aria-valuemax="100"
         style="background: linear-gradient(to right, transparent ' . $score_value . '%, var(--bs-secondary-bg) ' . $score_value . '%), ' . $gradient . ';">
      <div class="progress-bar progress-bar-striped rounded ' . $bar_class . '" style="width: ' . $score_value . '%">
        <span class="' . $text_class . '">' . $score_value . '%</span>
      </div>
    </div>';
}




/*
 * =============================================================================
 * SECTION: PERFORMANCE
 * =============================================================================
 * attempt to compress the page output for better performance
 * try;
 * 1. brotli
 * 2. gzip/deflate
 * 3. server default
 *
 * Note: keep this as the final item before the output starts
 */
// Check if native Zlib compression is already globally enabled on the server
if (function_exists('brotli_compress') && isset($_SERVER['HTTP_ACCEPT_ENCODING']) && str_contains($_SERVER['HTTP_ACCEPT_ENCODING'], 'br')) {

    // Check if transparent brotli compression is already running via php.ini
    if (!ini_get('brotli.output_compression') || strtolower(ini_get('brotli.output_compression')) === 'off') {
        // Fallback buffer if ini_set fails or is restricted
        if (@ini_set('brotli.output_compression', 'On') === false) {
            ob_start('ob_brotlihandler'); // Custom extension buffer handler
        } else {
            ob_start();
        }
    } else {
        ob_start();
    }

} else if (!ini_get('zlib.output_compression') || strtolower(ini_get('zlib.output_compression')) === 'off') {

    // Secondary Fallback to standard Gzip/Deflate
    if (@ini_set('zlib.output_compression', 'On') === false) {
        ob_start('ob_gzhandler');
    } else {
        ob_start();
    }

} else {
    // Default system buffering baseline
    ob_start();
}
?>

<!DOCTYPE html>
<html lang="<?php echo $lang['FPA_THISLANG']; ?>" data-bs-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
    <meta name="color-scheme" content="light dark">
    <meta name="description" content="<?php echo $lang['FPA_DESC']; ?>">

    <title><?php echo $lang['FPA_LONG']; ?></title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.13.1/font/bootstrap-icons.min.css" integrity="sha512-t7Few9xlddEmgd3oKZQahkNI4dS6l80+eGEzFQiqtyVYdvcSG2D3Iub77R20BdotfRPA9caaRkg1tyaJiPmO0g==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <style>
        :root {
            --fpa-primary-color: #660066;
            --fpa-primary-text: #ffffff;
        }
        :target {
            scroll-margin-top: 50px; /* add a space before target id's when scrolling */
        }
        .card.readiness-card {
            box-shadow: rgba(0, 0, 0, 0.09) 0px 2px 1px,
                        rgba(0, 0, 0, 0.09) 0px 4px 2px,
                        rgba(0, 0, 0, 0.09) 0px 8px 4px,
                        rgba(0, 0, 0, 0.09) 0px 16px 8px,
                        rgba(0, 0, 0, 0.09) 0px 32px 16px !important;
        }
        /* custom fpa css */
        .text-fpa {
            color: var(--fpa-primary-color) !important;
        }
        .bg-fpa {
            background-color: var(--fpa-primary-color) !important;
            color: var(--fpa-primary-text) !important; /* force text to remain readable/accessible */
        }
        .collapse {
          transition: opacity 0.2s ease-in-out;
        }
        .collapsing {
          opacity: 0;
          transition: height 0.2s ease, opacity 0.2s ease !important;
        }
        .collapse.show {
          opacity: 1;
        }
        .card.actionable {
              transition: all 0.3s ease-in-out;
        }
        .card.actionable:hover {
            color: var(--bs-secondary)!important;
            border-color: var(--bs-secondary)!important;
            transform: translateY(-2px);
            box-shadow: var(--bs-box-shadow) !important;
            transition: all 0.3s ease-in-out;
        }
        .form-switch-success {
            --bs-primary: var(--bs-success) !important;
            --bs-focus-ring-color: rgba(25, 135, 84, 0.25) !important;
        }

        /* preset options hover help text */
        .row:has(.card.basicPreset:hover) .presetHelp,
        .row:has(.card.defaultPreset:hover) .presetHelp,
        .row:has(.card.enhancedPreset:hover) .presetHelp,
        .row:has(.card.maximumPreset:hover) .presetHelp {
            display: none !important;
            transition: display 0.3s ease-in-out;
        }
        .row:has(.card.basicPreset:hover) .basicPresetHelp {
            display: block !important;
            transition: display 0.3s ease-in-out;
        }
        .row:has(.card.defaultPreset:hover) .defaultPresetHelp {
            display: block !important;
            transition: display 0.3s ease-in-out;
        }
        .row:has(.card.enhancedPreset:hover) .enhancedPresetHelp {
            display: block !important;
            transition: display 0.3s ease-in-out;
        }
        .row:has(.card.maximumPreset:hover) .maximumPresetHelp {
            display: block !important;
            transition: display 0.3s ease-in-out;
        }

        .style-label {
            font-size: 0.72rem;
            font-weight: 500;
            cursor: pointer;
            padding-top: 2px;
        }

        .privacy-mask {
            color: var(--bs-info-text-emphasis) !important;
            background-color: rgba(var(--bs-info-rgb), 0.15) !important;
            padding: 2px 5px ;
            font-size: 0.8rem;
        }

        /* The semi-circle viewing window */
        .gauge-wrapper {
            position: relative;
            width: 125px;
            height: 62px; /* Exactly half the width */
            overflow: hidden;
        }

        /* The physical track ring */
        .gauge-body {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 200%; /* Forms a perfect circle inside the hidden overflow */
            border: 16px solid var(--bs-primary); /* Bootstrap 5 theme-aware gray track --bs-secondary-bg */
            border-bottom-color: transparent;
            border-right-color: transparent;
            border-radius: 50%;
            transform: rotate(45deg); /* Baseline start at 0% */
        }

        /* The dynamic colored fill indicator */
        .gauge-fill {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 200%;
            border: 16px solid var(--bs-secondary-bg); /* Bootstrap primary colored indicator --bs-primary */
            border-bottom-color: transparent;
            border-right-color: transparent;
            border-radius: 50%;
            transform-origin: center center;
            transform: rotate(45deg); /* Default 0% position */
            transition: transform 0.4s ease-out; /* Smooth movement transition animation */
        }


        /* message queue */
        .extra-small-text { font-size: 0.78rem; line-height: 1.25; }
        .notification-card-link:hover { background-color: rgba(0,0,0,0.02); }
        .dropdown-toggle.hide-caret::after {
            display: none !important;
        }

        /* WCAG 2.1 AA: visible keyboard focus (2.4.7); prefers-reduced-motion */
        a:focus-visible,
        button:focus-visible,
        input:focus-visible,
        select:focus-visible,
        textarea:focus-visible {
            outline: 3px solid #0a58ca;
            outline-offset: 2px;
        }

        @media (prefers-reduced-motion: reduce) {
            *,
            *::before,
            *::after {
                animation-duration: 0.01ms !important;
                animation-iteration-count: 1 !important;
                transition-duration: 0.01ms !important;
                scroll-behavior: auto !important;
            }
        }

        /* Optimised container sizes for dashboard style screen real-estate, reduced container margins */
        @media (min-width: 576px) { /* small devices (landscape phones) */
          .container {
            max-width: 560px; /* Default is 540px */
          }
        }
        @media (min-width: 768px) { /* medium devices (tablets) */
          .container {
            max-width: 752px; /* Default is 720px */
          }
        }
        @media (min-width: 992px) { /* large devices (desktops) */
          .container {
            max-width: 980px; /* Default is 960px */
          }
        }
        @media (min-width: 1200px) { /* large monitors (medium laptops and monitors) */
            .container {
                max-width: 1240px; /* default is 1140px */
            }
        }
        @media (min-width: 1400px) { /* larger monitors (large laptops and desktops) */
            .container {
                max-width: 1440px; /* default is 1320px */
            }
        }
    </style>

</head>
<body class="d-flex flex-column min-vh-100">

    <a class="visually-hidden-focusable position-absolute top-0 start-0 z-3 btn btn-primary m-2" href="#main">Skip to content</a>

    <header>

        <nav class="navbar navbar-expand-md navbar-dark bg-dark bg-fpa fixed-top d-flex flex-column shadow Xshadow-fpa Xpb-0 w-100" aria-label="Primary">
            <div class="container">

                <a class="navbar-brand fw-semibold d-flex align-items-center gap-2" href="<?php echo $fpa_self_url; ?>" aria-label="<?php echo $lang['FPA_LONG']; ?>">
                    <span class="text-white-50 fw-bold d-none d-md-block" aria-hidden="true"><i class="bi bi-chat-right-dots"></i></span>
                    <span class="d-none d-md-block"><?php echo $lang['FPA_LONG']; ?></span>
                    <span class="d-sm-block d-md-none"><?php echo $lang['FPA_SHORT']; ?>
                </a>

                <div class="navbar-nav ms-md-auto">

                    <div class="btn-toolbar Xms-md-auto" role="toolbar" aria-label="FPA tools & options toolbar groups">

                        <?php
                        /**
                         * Toolbar forms
                         * FPA navigation option & action forms for the tools & options groups toolbar
                         */
                        ?>
                        <form class="d-none" method="post" action="<?php echo $fpa_self_url; ?>" name="nav-pdf-form" id="nav-pdf-form">
                            <input type="hidden" name="doPDF" value="1" />
                        </form>

                        <form class="d-none" method="post" action="<?php echo $fpa_self_url; ?>" name="nav-delete-form" id="nav-delete-form">
                            <input type="hidden" name="act" value="delete" />
                        </form>

                        <ul class="navbar-nav">
                            <li class="nav-item px-3 py-0 border-start border-secondary">
                                <!-- Sensitive data privacy switch -->
                                <form class="m-0 p-0" method="post" id="nav-privacy-form">
                                    <div class="form-check form-switch p-0 d-flex flex-column align-items-center form-switch-success">
                                        <label class="form-check-label m-0 text-white" for="nav-privacy-switch" style="font-size: 0.75rem;">
                                            Privacy
                                        </label>
                                        <input class="form-check-input m-0" type="checkbox" role="switch" name="privacy" id="nav-privacy-switch" <?php echo $is_privacy_checked; ?>>
                                    </div>
                                </form>
                            </li>
                        </ul>

                        <div class="btn-group me-2" role="group" aria-label="FPA Tools Group">
                            <!-- FPA options & tools -->
                            <button form="nav-pdf-form" class="btn btn-outline-light" type="submit" accesskey="p" data-bs-toggle="tooltip" data-bs-trigger="hover focus" data-bs-placement="bottom" data-bs-title="PDF Report" aria-label="Generate a PDF report of the FPA">
                                <i class="bi bi-filetype-pdf"></i>
                            </button>

                            <a role="button" class="btn btn-outline-light" rel="noreferrer noopener" href="<?php echo FPA_DOCS_URL; ?>" target="_blank" data-bs-toggle="tooltip" data-bs-trigger="hover focus" data-bs-placement="bottom" data-bs-title="<?php echo $lang['FPA_SHORT'] . ' ' . $lang['FPA_DOCUMENTATION']; ?>" aria-label="<?php echo $lang['FPA_DOCUMENTATION']; ?>">
                                <i class="bi bi-book-half"></i>
                            </a>

                            <a role="button" class="btn btn-outline-light" rel="noreferrer noopener" href="<?php echo FPA_DOWNLOAD_ZIP_URL; ?>" target="_blank" data-bs-toggle="tooltip" data-bs-trigger="hover focus" data-bs-placement="bottom" data-bs-title="<?php echo $lang['FPA_DOWNLOADLATEST'] .' ' . $lang['FPA_SHORT']; ?>" aria-label="<?php echo $lang['FPA_DOWNLOADLATEST'] .' ' . $lang['FPA_SHORT']; ?>">
                                <i class="bi bi-cloud-download-fill"></i>
                            </a>

                            <!--
                            <button class="btn btn-outline-light" type="button" data-bs-toggle="collapse" data-bs-target="#runtimeOptionPanel" aria-expanded="<?php echo $_SESSION['options_panel_open'] ? 'true' : 'false'; ?>" aria-controls="runtimeOptionPanel" aria-label="FPA Runtime Options">
                                <span data-bs-toggle="tooltip" data-bs-trigger="hover focus" data-bs-placement="bottom" data-bs-title="FPA Runtime Options.">
                                    <i class="bi bi-sliders"></i>
                                </span>
                            </button>
                            -->

                            <!--
                            <button class="btn btn-outline-light" type="button" data-bs-toggle="collapse" data-bs-target="#runtimeOptionPanel" aria-expanded="<?php echo $_SESSION['options_panel_open'] ? 'true' : 'false'; ?>" aria-controls="runtimeOptionPanel" aria-label="FPA Runtime Options">
                                <span data-bs-toggle="tooltip" data-bs-trigger="hover focus" data-bs-placement="bottom" data-bs-title="FPA Runtime Options.">
                                    <i class="bi bi-sliders"></i>
                                </span>
                            </button>
                            -->
                        </div>

                        <div id="themeSwitcher" class="btn-group me-2" role="group" aria-label="Theme Switcher Group">
                            <!-- switch themes -->
                            <button class="btn btn- btn-outline-light dropdown-toggle hide-caret" type="button" data-bs-toggle="dropdown" aria-expanded="false" aria-label="Switch Theme">
                                <i class="theme-icon-active bi bi-sun-fill" aria-hidden="true"></i>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end position-absolute">
                                <li>
                                    <button class="dropdown-item" type="button" data-theme-value="light">
                                        <i class="bi bi-sun-fill me-2 opacity-50" aria-hidden="true"></i> Light
                                    </button>
                                </li>
                                <li>
                                    <button class="dropdown-item" type="button" data-theme-value="dark">
                                        <i class="bi bi-moon-stars-fill me-2 opacity-50" aria-hidden="true"></i> Dark
                                    </button>
                                </li>
                                <li>
                                    <button class="dropdown-item" type="button" data-theme-value="auto">
                                        <i class="bi bi-circle-half me-2 opacity-50" aria-hidden="true"></i> Auto
                                    </button>
                                </li>
                            </ul>
                        </div>

                        <div class="btn-group" role="group" aria-label="Notifications Group">
                            <!-- NOTIFICATION DROPDOWN BLOCK -->
                            <!-- The 'd-none' class ensures it stays completely invisible until JS updates it -->
                            <div class="dropdown me-2 d-none" id="notification-wrapper">
                              <button class="btn btn-outline-warning position-relative dropdown-toggle hide-caret" type="button" data-bs-toggle="dropdown" Xdata-bs-display="static" data-bs-reference="parent">
                                <i class="bi bi-chat-right-dots-fill"></i>
                                <!-- Red Bootstrap Badge Counter -->
                                <span class="position-absolute bottom-10 start-0 translate-middle badge rounded-pill bg-danger" id="queue-count">
                                  0
                                </span>
                              </button>

                              <!-- Dropdown Items list menu -->
                              <ul class="dropdown-menu dropdown-menu-end shadow-sm position-absolute" id="queue-dropdown-items" style="width: 320px; max-height: 500px; overflow-y: auto;" data-bs-boundary="body">
                                <!-- JS will populate these dynamically -->
                              </ul>
                            </div>
                        </div>

                        <div class="btn-group" role="group" aria-label="FPA Actions Group">
                            <!-- delete FPA -->
                            <button form="nav-delete-form" class="btn btn-danger me-2" type="submit" data-bs-toggle="tooltip" data-bs-title="Delete the FPA script" data-bs-placement="bottom" aria-label="Delete the FPA script.">
                                <i class="bi bi-trash3-fill"></i>
                            </button>
                        </div>

                    </div><!--/btn-toolbar-->

                </div><!--/navbar-->

            </div><!--/nav container-->

            <!--
            <div id="navSubBar" class="d-none d-md-block Xbg-secondary opacity-75 text-white py-2 Xborder-top Xborder-dark w-100">
                <div class="container-fluid text-center">
                    <small class="opacity-75">🚀 Limited Offer: Get 50% off your first month with code HALFOFF!</small>
                </div>
            </div>--/navSubBar
            -->

        </nav>

    </header>


    <main id="main" class="flex-grow-1" tabindex="-1" style="margin-top: 56px;">

        <!-- TESTING -->
        <?php
        //echo $doLiveChecks;
        //if ($doLiveChecks) { echo 'DO LIVE CHECKS'; }

        //$processInfo = posix_getpwuid(posix_geteuid());
        //var_dump($processInfo);

        //echo '-[ ' . get_current_user() . ']-';

        echo '<pre>';
        //var_dump($fpa_reference);
        //var_dump($fpa_active_feeds);
        //var_dump($do_live_checks);
        //var_dump($fpa_latest_versions);
        //var_dump($fpa_joomla_folders);
        //var_dump($fpa_joomla_instance);
        //var_dump($fpa_exception_queue);
        //var_dump($fpa_security);
        //var_dump($fpa_ssl);
        //var_dump($fpa_environment);
        //var_dump($fpa_elevated_permissions);
        echo '</pre>';
        // echo $configFilePath;

        //echo sys_get_temp_dir();
        //echo $is_privacy_checked ;
        //echo $_SESSION['privacy_enabled'] ? '<span class="privacy-mask">[ ' . $lang['FPA_REDACTED'] . ' ]</span>' : $fpa_joomla_instance['config_path'];
        ?>
        <!-- TESTING -->



        <?php
        /*
         * =============================================================================
         * SECTION: KEY METRICS PANEL
         * =============================================================================
         * Provides a quick dashboard style rating of important elements of the
         * overall host, application, security and Joomla! environment and configuration
         * offering a simple at-a-glance view to the user.
         *
         * Options:
         * option to enable a more grpahical view of the statistics/ratings can
         * found in the FPA Settings (navbar icon > offcanvas configuration panel)
         *
         * Default Textual View
         * + Graphical View (optional)
         */
        ?>
        <div class="container-fluid bg-secondary bg-opacity-10 pt-3 pb-5">

            <?php
            // include if GRAPHICAL METRICS
            // TODO: change the bar colours though
            // Sample Rating value (Replace with your database rating variable)
            $score_value = $fpa_joomla_instance['readiness_score'];

            // Mathematical scale transform calculation: Maps 0-100 straight to 45-225 degrees
            $degreesRotation = 45 + ($score_value * 1.8);
            ?>

            <div id="keyMetricsPanel" class="container my-4 pt-0">

                <h2 class="border-bottom border-secondary p-2">
                    <i class="bi bi-speedometer text-secondary"></i> <?php echo htmlspecialchars($lang['FPA_KEYMETRICS']); ?>
                </h2>

                <!-- Combined flex row on MD+, standard stacked row on SM and below -->
                <div class="row g-4 d-md-flex align-items-md-stretch mt-2">


                    <!-- TEXT COLUMN -->
                    <!-- Full width below MD (col-12) | Takes up remaining space next to cards on LG+ (col-lg) -->
                    <div class="col-12 col-sm-12 Xcol-md-5 col-lg d-flex flex-column Xjustify-content-center">

                        <div class="pe-xl-3 mb-2 mb-md-0">

                            <h3 class="fs-5 fw-light Xtext-secondary text-uppercase tracking-wider mb-2">
                                <span class="fw-bold"><?php echo htmlspecialchars($lang['FPA_READINESS']); ?></span> <?php echo htmlspecialchars($lang['FPA_SUMMARY']); ?>
                            </h3>

                            <p class="Xtext-secondary Xsmall Xmb-0">
                                <?php echo htmlspecialchars($fpa_readiness_summary); ?>
                            </p>
                        </div>

                    </div>

                    <!-- CARDS CONTAINER COLUMN -->
                    <!-- Full width below MD (col-12) | 50% width on MD | 75% width on LG+ (col-lg-9) -->
                    <div class="col-12 col-sm-12 Xcol-md-7 col-lg-9">
                        <!-- Inner Grid: 1 column on XS | 2 columns on SM and MD | 4 columns straight across on LG -->
                        <div class="row row-cols-2 Xrow-cols-sm-2 row-cols-lg-4 g-4 h-100">

                            <!-- CARD 1 -->
                            <div class="col-">
                                <div class="card readiness-card h-100 shadow-sm text-center border-<?php echo $fpa_readiness_color; ?> Xbg-<?php echo $fpa_readiness_color; ?>-subtle" style="border-left-width: 10px;">
                                    <div class="card-body p-3 d-flex flex-column justify-content-between">

                                        <div class="d-flex justify-content-center align-items-baseline Xmt-2">

                                            <!--  if not using graphical UI setting
                                            <span class="text-<?php //echo $fpa_readiness_color; ?> fw-semibold" style="font-size: 4em; Xfont-weight: 700; line-height: 1;"><?php //echo $fpa_joomla_instance['readinessGrade']; ?></span>
                                            -->

                                            <!-- TODO : if GraphicalUI option selected -->
                                            <div class="d-flex flex-column align-items-center">
                                                <!-- The Semi-Circle Gauge -->
                                                <div class="gauge-wrapper mb-1">
                                                    <div class="gauge-body border-<?php echo $fpa_readiness_color; ?>"></div>
                                                    <div class="gauge-fill" style="transform: rotate(<?php echo $degreesRotation; ?>deg);"></div>
                                                </div>

                                                <!-- Centred Rating Value Label Display -->
                                                <div class="text-center Xmt-2 position-absolute" style="top: 35%;">
                                                    <span class="fs-3 fw-bold tracking-tight"><?php echo $score_value; ?>%</span>
                                                </div>
                                            </div>


                                            <!--
                                            <span class="fs-3 fw-bold tracking-tight">42%</span>
                                            <span class="badge bg-success-subtle text-success ms-2 font-monospace" style="font-size: 0.7rem;">-3%</span>
                                            -->
                                        </div>
                                        <h3 class="fs-6 Xtext-center fw-bold text-uppercase m-0" style="Xfont-size: 0.7rem;"><?php echo $lang['FPA_READINESS']; ?></h3>

                                    </div>
                                </div>
                            </div>

                            <!-- CARD 2 -->
                            <div class="col">
                                <div class="card readiness-card h-100 shadow-sm border-warning bg-warning-subtle" style="border-left-width: 10px;">
                                    <div class="card-body p-3 d-flex flex-column justify-content-between">

                                        <div class="d-flex align-items-baseline mt-2">
                                            <span class="fs-3 fw-bold tracking-tight"><?php echo $fpa_environment['score']; ?>%</span>
                                            <span class="badge bg-success-subtle text-success ms-2 font-monospace" style="font-size: 0.7rem;">Stable</span>
                                        </div>
                                        <small class="fw-semibold text-uppercase d-block" style="font-size: 0.7rem;"><?php echo $fpa_environment['meta']['name']; ?></small>
                                        <?php echo render_score_bar($fpa_environment['score']); ?>
                                    </div>
                                </div>
                            </div>

                            <!-- CARD 3 -->
                            <div class="col">
                                <div class="card readiness-card h-100 shadow-sm border-warning bg-warning-subtle" style="border-left-width: 10px;">
                                    <div class="card-body p-3 d-flex flex-column justify-content-between">

                                        <div class="d-flex align-items-baseline mt-2">
                                            <span class="fs-3 fw-bold tracking-tight"><?php echo $fpa_performance['score']; ?>%</span>
                                            <span class="badge bg-danger-subtle text-danger ms-2 font-monospace" style="font-size: 0.7rem;">+14%</span>
                                        </div>
                                        <small class="fw-semibold text-uppercase d-block" style="font-size: 0.7rem;">Tuning & Optimisation<?php //echo $fpaPerformance['meta']['name']; ?></small>
                                        <?php echo render_score_bar($fpa_performance['score']); ?>
                                    </div>
                                </div>
                            </div>

                            <!-- CARD 4 -->
                            <div class="col">
                                <div class="card readiness-card h-100 shadow-sm border-info bg-info-subtle" style="border-left-width: 10px;">
                                    <div class="card-body p-3 d-flex flex-column justify-content-between">

                                        <div class="d-flex align-items-baseline mt-2">
                                            <span class="fs-3 fw-bold tracking-tight"><?php echo $fpa_security['score']; ?>%</span>
                                            <span class="badge bg-success-subtle text-success ms-2 font-monospace" style="font-size: 0.7rem;">+2%</span>
                                        </div>
                                        <small class="fw-semibold text-uppercase d-block" style="font-size: 0.7rem;"><?php echo $fpa_security['meta']['name']; ?></small>
                                        <?php echo render_score_bar($fpa_security['score']); ?>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                </div><!-- /row -->

            </div><!-- /container #keyMetricsPanel -->

        </div><!--/container-fluid-->




        <?php
        /*
         * =============================================================================
         * SECTION: ENVIRONMENT SNAPSHOT
         * =============================================================================
         * This panel provides a quick snapshot of the host, application and Joomla!
         * environment elements and configuration that may effect the Joomla! instance
         * features or functions.
         */
        ?>
        <div id="envSnapshotPanel" class="container pt-5 mb-3">

            <h2 class="border-bottom border-secondary p-2">
                <i class="bi bi-box-fill text-secondary"></i> Environment Snapshot
            </h2>

        </div>




        <?php
        /*
         * =============================================================================
         * SECTION: DISCOVERY PANEL
         * =============================================================================
         * This panel provides a more detailed view the Joomla! environment elements and configuration
         */
        ?>
        <div id="applicationDiscovery" class="container pt-5 mb-3">

            <h2 class="border-bottom border-secondary p-2">
                <i class="bi bi-pc-display text-secondary"></i> Discovery Report
            </h2>

            <div id="instanceDiscovery" class="row g-4 d-md-flex align-items-md-stretch mt-2">

                <div class="col-12 col-sm-12 Xcol-md-5 col-lg-3 d-flex flex-column Xjustify-content-center">
                    instanceDiscovery text
                </div>
                <div class="col-12 col-sm-12 Xcol-md-7 col-lg-9">

                    <div class="card w-100 h-100">
                        <div class="card-header">
                            instanceDiscovery content
                        </div>
                        <div class="card-body">
                            body text
                        </div>
                    </div>

                </div>

                </div>
                <div id="configDiscovery" class="row g-4 d-md-flex align-items-md-stretch mt-2">

                <div class="col-12 col-sm-12 Xcol-md-5 col-lg-3 d-flex flex-column Xjustify-content-center">
                    configDiscovery text
                </div>
                <div class="col-12 col-sm-12 Xcol-md-7 col-lg-9">

                    <div class="card w-100 h-100">
                        <div class="card-header">
                            configeDiscovery content
                        </div>
                        <div class="card-body">
                            body text
                        </div>
                    </div>

                </div>

            </div><!-- /row -->

        </div><!-- /container #discoveryReport -->






        <?php
        /*
         * =============================================================================
         * SECTION: PERMISISONS AUDITS
         * =============================================================================
         * audit the joomla core directories/folders and/or the extended
         * directories/folders for sane special and standard mode/permissions,
         * including looking for ownership and read/write issues
         */
        ?>
        <div class="container pt-5 mb-3" id="permissionsPanel">

            <h2 class="border-bottom border-secondary p-2">
                <i class="bi bi-shield-lock-fill text-secondary"></i> <?php echo htmlspecialchars($lang['FPA_HEADING_PERMISSIONS']); ?>
            </h2>


            <?php
            /**
             * --- Joomla Core Folders Permisisons Audit ---
             * traverse the known joomla core folders looking for insecure, dangerous or
             * potentially troublesome folder modes (permissions)
             *
             * Report-By-Exception:
             * only display those folders/direcotires with exceptions
             * - use the Taggle All button to display all folders regardless of status
             *
             * Usage:
             * fpa_audit_permissions(array_to_use, array_to_exclude, num_exceptions, extended_data_toggle_key);
             *
             * Arguments:
             * - array_to_use:              $fpa_joomla_folders
             * - array_to_exclude:          none, when running $fpa_joomla_folders
             *                              to avoid duplication with Joomla Core Folders audit
             * - num_exceptions:            0, unused, max. number of exceptions before exiting
             * - extended_data_toggle_key:  corepermissions, must be unique to each use of the function,
             *                              used to show/hide extended data and will be prepended with;
             *                              all, for the -Toggle All- option button
             */
            ?>
            <!-- Combined flex row on MD+, standard stacked row on SM and below -->
            <div id="standardPermissions" class="row g-4 d-md-flex align-items-md-stretch mt-2">

                <!-- TEXT COLUMN -->
                <!-- Full width below MD (col-12) | Takes up remaining space next to cards on LG+ (col-lg) -->
                <div class="col-12 col-sm-12 Xcol-md-5 col-lg d-flex flex-column Xjustify-content-center">

                    <div class="pe-xl-3 mb-2 mb-md-0">
                        <h3 class="fs-5 fw-light Xtext-secondary text-uppercase tracking-wider mb-2">
                            <span class="fw-bold"><?php echo htmlspecialchars($fpa_joomla_folders['meta']['name']); ?></span> <?php echo htmlspecialchars($lang['FPA_SUMMARY']); ?>
                        </h3>
                        <p class="text-secondary Xsmall Xmb-0">
                            Joomla! required folders audit, including prescence, ownership, prescence, standard and permission (mode) exception report displays up to 10 folders not conforming to normal or excepted sane standard and special permissions.
                        </p>

                        <button type="button" class="btn btn-outline-secondary btn-sm Xmb-3 Xms-auto" id="toggle_corefolders_btn" data-fpa-toggle="corefolders">
                            <i class="bi bi-eye me-1"></i> Toggle Advanced
                        </button>

                        <button type="button" class="btn btn-outline-secondary btn-sm Xmb-3 Xms-auto" id="toggle_allcorefolders_btn" data-fpa-toggle="allcorefolders">
                            <i class="bi bi-eye me-1"></i> Toggle All
                        </button>
                    </div>

                </div>

                <!-- CARDS CONTAINER COLUMN -->
                <!-- Full width below MD (col-12) | 50% width on MD | 75% width on LG+ (col-lg-9) -->
                <div class="col-12 col-sm-12 Xcol-md-7 col-lg-9">

                    <div class="d-flex flex-wrap">
                        <span class="badge bg-body-tertiary text-secondary border fw-medium font-monospace ms-auto mb-2" style="font-size: 0.72rem;">
                            PHP User: <strong class="Xtext-dark"><?php echo htmlspecialchars($fpa_reference['php']['process_user']); ?></strong>
                            &nbsp;|&nbsp;System umask: <strong class="Xtext-dark"><?php echo htmlspecialchars($fpa_reference['server']['umask']); ?></strong>
                        </span>
                    </div>

                    <div class="table-responsive">

                        <table class="table table-hover align-middle table-striped table-bordered mb-0" style="Xfont-size: 0.9rem;">
                            <thead class="Xtable-light table-dark text-uppercase tracking-wider" style="font-size: 0.8rem; font-weight: 700;">
                                <tr>
                                    <th scope="col" class="ps-3">Path</th>
                                    <th scope="col" class="d-none Xd-md-table-cell text-end Xd-none fpa-toggle-corefolders">Owner</th>
                                    <th scope="col" class="d-none Xd-md-table-cell Xd-none fpa-toggle-corefolders">Group</th>
                                    <th scope="col" class="text-center" style="width: 68px;">Mode</th>
                                    <th scope="col" class="text-center Xpe-3" style="width: 100px;">Writable</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($fpa_joomla_folders['folders'] as $path => $perms_info): ?>

                                    <?php
                                    if ($perms_info['perms'] != '0755') {
                                        $non_rbe = '';
                                    } else {
                                        $non_rbe = 'd-none fpa-toggle-allcorefolders';
                                    }
                                    ?>
                                    <tr class="<?php echo $non_rbe; ?>">
                                        <td class="ps-3 Xfont-monospace Xfw-semibold Xtext-secondary text-break" style="Xfont-size: 0.82rem;">
                                            <?php echo htmlspecialchars($path); ?>
                                        </td>


                                        <td class="d-none Xd-md-table-cell text-muted text-end Xd-none fpa-toggle-corefolders">
                                            <?php if (@!$perms_info['owner_match'] && $perms_info['exists']): ?>
                                                <i class="bi bi-exclamation-diamond-fill text-info me-1" style="font-size: 0.85rem;" data-bs-toggle="tooltip" data-bs-placement="left" data-bs-title="Ownership Mismatch: This directory is owned by a different user than the account executing PHP code."></i>
                                            <?php endif; ?>
                                            <span class="<?php echo !$perms_info['owner_match'] ? 'text-secondary fw-medium' : ''; ?>">
                                                <?php echo htmlspecialchars($perms_info['owner']); ?>
                                            </span>
                                        </td>

                                        <td class="d-none Xd-md-table-cell text-muted Xd-none fpa-toggle-corefolders">
                                            <?php echo htmlspecialchars($perms_info['group']); ?>
                                        </td>

                                        <!--
                                        <td class="text-center">
                                            <?php if (!$perms_info['exists']): ?>
                                                <span class="badge bg-secondary-subtle text-secondary fw-bold px-2.5 py-1.5 text-uppercase" style="font-size: 0.72rem;">Missing</span>
                                            <?php elseif (!$perms_info['sane']): ?>
                                                <span class="badge bg-danger fw-black px-2.5 py-1.5 shadow-sm" style="font-size: 0.72rem;" title="Dangerous Mode Detected!">
                                                    <i class="bi bi-exclamation-triangle-fill me-1"></i><?php echo $perms_info['perms']; ?>
                                                </span>
                                            <?php else: ?>
                                                <span class="badge bg-light text-dark border fw-bold px-2.5 py-1.5" style="font-size: 0.72rem;">
                                                    <?php echo $perms_info['perms']; ?>
                                                </span>
                                            <?php endif; ?>
                                        </td>
                                        -->

                                        <!-- Permissions Column with Conditional Tier Warning Badges -->
                                        <td class="text-center">
                                            <?php if (!$perms_info['exists']): ?>
                                                <span class="badge bg-secondary-subtle text-secondary fw-bold px-2.5 py-1.5 text-uppercase w-100" style="font-size: 0.72rem;">
                                                    Missing
                                                </span>
                                            <?php elseif (!$perms_info['sane']): ?>
                                                <!-- CRITICAL DANGER BADGE (World Writable / 777) -->
                                                <span class="badge bg-danger fw-black px-2.5 py-1.5 shadow-sm text-white w-100" style="font-size: 0.72rem;" data-bs-toggle="tooltip" data-bs-placement="left" data-bs-title="Critical: World-writable or insecure mode detected!">
                                                    <i class="bi bi-shield-slash-fill me-1"></i><?php echo $perms_info['perms']; ?>
                                                </span>


                                                <!-- TESTING issues -->
                                                <?php
                                                $fpa_exception_queue[] = [
                                                    'category'    => 'Permissions',
                                                    'type'        => 'danger', // Bootstrap color code
                                                    'text'        => 'At least one folder has world writable permissions.',
                                                    'solution'    => 'Reset permissions to to the system default (usually 755).',
                                                    'target_id'   => 'standardPermissions' // Matches the ID of the checkbox in your offcanvas layout!
                                                ];
                                                ?>
                                                <!-- TESTING issues -->

                                            <?php elseif (isset($perms_info['warning']) && $perms_info['warning']): ?>
                                                <!-- SECURITY WARNING BADGE (Group Writable / Loose Permissions) -->
                                                <span class="badge bg-warning text-dark border border-warning-subtle fw-bold px-2.5 py-1.5 shadow-sm w-100" style="font-size: 0.72rem;" data-bs-toggle="tooltip" data-bs-placement="left" data-bs-title="Warning: Loose group or owner permissions detected.">
                                                    <i class="bi bi-exclamation-triangle-fill me-1"></i><?php echo $perms_info['perms']; ?>
                                                </span>

                                                <!-- TESTING issues -->
                                                <?php
                                                $fpa_exception_queue[] = [
                                                    'category'    => 'Permissions',
                                                    'type'        => 'warning', // Bootstrap color code
                                                    'text'        => 'At least one folder has group writable permissions.',
                                                    'solution'    => 'Reset permissions to to the system default (usually 755).',
                                                    'target_id'   => 'standardPermissions' // Matches the ID of the checkbox in your offcanvas layout!
                                                ];
                                                ?>
                                                <!-- TESTING issues -->

                                            <?php else: ?>
                                                <!-- CLEAN STANDARD SAFE BADGE (e.g., 0755) -->
                                                <span class="badge bg-light text-dark border fw-bold px-2.5 py-1.5 w-100" style="font-size: 0.72rem;">
                                                    <?php echo $perms_info['perms']; ?>
                                                </span>
                                            <?php endif; ?>
                                        </td>

                                        <td class="text-center Xtext-end Xpe-3">
                                            <?php if (!$perms_info['exists']): ?>
                                                <i class="bi bi-dash-circle-dotted text-secondary" style="font-size: 1.04rem;"></i>
                                            <?php elseif ($perms_info['writable']): ?>

                                                <?php
                                                    // warn about being writable if perms aren't sane, else success
                                                    if (!$perms_info['sane'] || (isset($perms_info['warning']) && $perms_info['warning'])) {
                                                        $writable_color = "warning";
                                                    } else {
                                                        $writable_color = "success";
                                                    }
                                                ?>
                                                <!--<i class="bi bi-check-square-fill text-<?php echo $writable_color; ?> fs-5"></i>-->
                                                <span class="badge bg-<?php echo $writable_color; ?>-subtle text-<?php echo $writable_color; ?> border border-<?php echo $writable_color; ?>-subtle fw-semibold px-2 py-1 text-uppercase Xw-100" style="font-size: 0.68rem; letter-spacing: 0.3px; width: 66px;"><?php echo $lang['FPA_YES']; ?></span>
                                            <?php else: ?>
                                                <!--<i class="bi bi-x-square-fill text-danger fs-5"></i>-->
                                                <span class="badge bg-<?php echo $writable_color; ?>-subtle text-<?php echo $writable_color; ?> border border<?php echo $writable_color; ?>-subtle fw-semibold px-2 py-1 text-uppercase Xw-100" style="font-size: 0.68rem; letter-spacing: 0.3px; width: 66px;"><?php echo $lang['FPA_NO']; ?></span>

                                                <!-- TESTING issues -->
                                                <?php
                                                $fpa_exception_queue[] = [
                                                    'type'        => 'warning', // Bootstrap color code
                                                    'text'        => 'At least one folder is not writable to your account user.',
                                                    'solution'    => 'Reset permissions to to the system default (usually 755).',
                                                    'target_id'   => 'standardPermissions' // Matches the ID of the checkbox in your offcanvas layout!
                                                ];
                                                ?>
                                                <!-- TESTING issues -->

                                            <?php endif; ?>

                                        </td>

                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>

                </div>

            </div><!-- /row #standardPermissions -->


            <?php
            /**
             * --- Extended Folder Elevated Permisisons Audit ---
             * traverse the joomla directory structure looking for insecure, dangerous or
             * potentially troublesome folder modes (permissions)
             *
             * Report-By-Exception:
             * only display those folders/direcotires with exceptions
             * - if more exceptions found than num_exceptions; exit, dispay current exception
             *   list, post informational message stating excessive exceptions
             *
             * Usage:
             * fpa_audit_permissions(array_to_use, array_to_exclude, num_exceptions, extended_data_toggle_key);
             *
             * Arguments:
             * - array_to_use:              $fpa_elevated_permissions
             * - array_to_exclude:          $fpa_joomla_folders, when running $fpa_elevated_permissions
             *                              to avoid duplication with Joomla Core Folders audit
             * - num_exceptions:            10, 15, 25 etc, max. number of exceptions before exiting
             * - extended_data_toggle_key:  elevatedpermissions, must be unique to each use of the
             *                              function, used to show/hide extended data, the -Toggle All-
             *                              option is NOT available for elevated permisisons
             */
            ?>
            <!-- Combined flex row on MD+, standard stacked row on SM and below -->
            <div id="elevatedPermissions" class="row g-4 d-md-flex align-items-md-stretch mt-2">

                <!-- TEXT COLUMN -->
                <!-- Full width below MD (col-12) | Takes up remaining space next to cards on LG+ (col-lg) -->
                <div class="col-12 col-sm-12 Xcol-md-5 col-lg d-flex flex-column Xjustify-content-center">

                    <div class="pe-xl-3 mb-2 mb-md-0">
                        <h3 class="fs-5 fw-light Xtext-secondary text-uppercase tracking-wider mb-2">
                            <span class="fw-bold"><?php echo htmlspecialchars($fpa_elevated_permissions['meta']['name']); ?></span> <?php echo htmlspecialchars($lang['FPA_AUDIT']); ?>
                        </h3>
                        <p class="text-secondary Xsmall Xmb-0">
                            Extended folder permission (mode) exception report displays up to 10 folders not conforming to normal or excepted sane standard and special permissions.
                        </p>
                        <button type="button" class="btn btn-outline-secondary btn-sm Xmb-3 Xms-auto" id="toggle_permsaudit_btn" data-fpa-toggle="permsaudit">
                            <i class="bi bi-eye me-1"></i> Toggle Advanced
                        </button>
                    </div>

                </div>

                <!-- CARDS CONTAINER COLUMN -->
                <!-- Full width below MD (col-12) | 50% width on MD | 75% width on LG+ (col-lg-9) -->
                <div class="col-12 col-sm-12 Xcol-md-7 col-lg-9">

                    <div class="d-flex flex-wrap">
                        <span class="badge bg-body-tertiary text-secondary border fw-medium font-monospace ms-auto mb-2" style="font-size: 0.72rem;">
                            PHP User: <strong class="Xtext-dark"><?php echo htmlspecialchars($fpa_reference['php']['process_user']); ?></strong>
                            &nbsp;|&nbsp;System umask: <strong class="Xtext-dark"><?php echo htmlspecialchars($fpa_reference['server']['umask']); ?></strong>
                        </span>
                    </div>

                    <div class="table-responsive">

                        <table class="table table-hover align-middle table-striped table-bordered mb-0" style="Xfont-size: 0.9rem;">
                            <thead class="Xtable-light table-dark text-uppercase tracking-wider" style="font-size: 0.8rem; font-weight: 700;">
                                <tr>
                                    <th scope="col" class="ps-3" rowspan="2">Path</th>
                                    <th scope="col" class="text-center Xps-3 d-none fpa-toggle-permsaudit" colspan="3">Special Permissions</th>
                                    <th scope="col" class="text-center" style="width: 84px;" rowspan="2">Mode</th>
                                    <th scope="col" class="text-center" style="width: 75px;" rowspan="2">Owner Match</th>
                                    <th scope="col" class="text-center Xpe-3" colspan="3">Writable</th>
                                </tr>
                                <tr>
                                    <th class="text-center small d-none fpa-toggle-permsaudit" style="width: 64px;">SUID</th>
                                    <th class="text-center small d-none fpa-toggle-permsaudit" style="width: 64px;">SGID</th>
                                    <th class="text-center small d-none fpa-toggle-permsaudit" style="width: 64px;">Sticky</th>
                                    <th class="text-center small" style="width: 64px;">Owner</th>
                                    <th class="text-center small" style="width: 64px;">Group</th>
                                    <th class="text-center small" style="width: 64px;">World</th>
                                </tr>
                            </thead>
                            <tbody>

                                <?php foreach ($fpa_elevated_permissions['folders'] as $eperms_info): ?>
                                    <tr>
                                        <td class="ps-3 Xfont-monospace Xfw-semibold Xtext-secondary text-break Xtext-truncate" style="Xfont-size: 0.82rem;">

                                            <?php echo $_SESSION['privacy_enabled'] ? '<span class="privacy-mask">[ ' . $lang['FPA_REDACTED'] . ' ]</span>' : htmlspecialchars($eperms_info['path']); ?>

                                        </td>
                                        <td class="text-center d-none fpa-toggle-permsaudit">

                                            <?php
                                            if ($eperms_info['has_suid']) {
                                                $badge_color = 'danger';
                                                $badge_text  = $lang['FPA_YES'];
                                            } else {
                                                $badge_color = 'success';
                                                $badge_text  = $lang['FPA_NO'];
                                            }
                                            ?>
                                            <span class="badge bg-<? echo $badge_color; ?>-subtle text-<? echo $badge_color; ?> border border-<? echo $badge_color; ?> fw-semibold px-2 py-1 text-uppercase w-100" style="font-size: 0.68rem; letter-spacing: 0.3px; Xwidth: 66px;"><? echo $badge_text; ?></span>

                                        </td>
                                        <td class="text-center d-none fpa-toggle-permsaudit">

                                            <?php
                                            if ($eperms_info['has_sgid']) {
                                                $badge_color = 'danger';
                                                $badge_text  = $lang['FPA_YES'];
                                            } else {
                                                $badge_color = 'success';
                                                $badge_text  = $lang['FPA_NO'];
                                            }
                                            ?>
                                            <span class="badge bg-<? echo $badge_color; ?>-subtle text-<? echo $badge_color; ?> border border-<? echo $badge_color; ?> fw-semibold px-2 py-1 text-uppercase w-100" style="font-size: 0.68rem; letter-spacing: 0.3px; Xwidth: 66px;"><? echo $badge_text; ?></span>

                                        </td>
                                        <td class="text-center d-none fpa-toggle-permsaudit">

                                            <?php
                                            if ($eperms_info['has_sticky']) {
                                                $badge_color = 'danger';
                                                $badge_text  = $lang['FPA_YES'];
                                            } else {
                                                $badge_color = 'success';
                                                $badge_text  = $lang['FPA_NO'];
                                            }
                                            ?>
                                            <span class="badge bg-<? echo $badge_color; ?>-subtle text-<? echo $badge_color; ?> border border-<? echo $badge_color; ?> fw-semibold px-2 py-1 text-uppercase w-100" style="font-size: 0.68rem; letter-spacing: 0.3px; Xwidth: 66px;"><? echo $badge_text; ?></span>

                                        </td>
                                        <td class="text-center">

                                            <?php
                                            if ($eperms_info['is_world_w'] || $eperms_info['is_group_w']) {

                                                if ($eperms_info['is_world_w']) {
                                                    $badge_color   = 'danger';
                                                    $badge_icon    = 'shield-slash-fill';
                                                    $tooltip_title = 'Critical: World-writable or insecure mode detected!';
                                                } elseif ($eperms_info['is_group_w']) {
                                                    $badge_color   = 'warning';
                                                    $badge_icon    = 'exclamation-triangle-fill';
                                                    $tooltip_title = 'Warning: Loose Group-writable or insecure mode detected!';
                                                }

                                            } else {
                                                $badge_color   = 'success';
                                                $badge_icon    = 'check-circle';
                                                $tooltip_title = 'No World or Group open rights detected!';
                                            }
                                            ?>
                                            <span class="badge bg-<? echo $badge_color; ?> fw-black px-2.5 py-1.5 text-white w-100" style="font-size: 0.72rem;" data-bs-toggle="tooltip" data-bs-placement="left" data-bs-title="<?php echo $tooltip_title; ?>">
                                                <i class="bi bi-<?php echo $badge_icon; ?> me-1"></i><?php echo $eperms_info['permissions']; ?>
                                            </span>

                                        </td>
                                        <td class="Xd-none Xd-md-table-cell Xtext-muted Xtext-end">

                                            <?php
                                            if ($eperms_info['owner_match']) {
                                                $badge_color = 'success';
                                                $badge_text  = $lang['FPA_YES'];
                                            } else {
                                                $badge_color = 'warning';
                                                $badge_text  = $lang['FPA_NO'];
                                            }
                                            ?>
                                            <span class="badge bg-<? echo $badge_color; ?>-subtle text-<? echo $badge_color; ?> border border-<? echo $badge_color; ?> fw-semibold px-2 py-1 text-uppercase w-100" style="font-size: 0.68rem; letter-spacing: 0.3px; Xwidth: 66px;" data-bs-toggle="tooltip" data-bs-placement="left" data-bs-title="Ownership Mismatch: This directory is owned by a different user than the account executing PHP code."><? echo $badge_text; ?></span>

                                        </td>
                                        <td class="Xd-none Xd-md-table-cell Xtext-muted">
                                            <?php
                                            if ($eperms_info['is_owner_w']) {
                                                $badge_color = 'success';
                                                $badge_text  = $lang['FPA_YES'];
                                            } else {
                                                $badge_color = 'danger';
                                                $badge_text  = $lang['FPA_NO'];
                                            }
                                            ?>
                                            <span class="badge bg-<? echo $badge_color; ?>-subtle text-<? echo $badge_color; ?> border border-<? echo $badge_color; ?> fw-semibold px-2 py-1 text-uppercase w-100" style="font-size: 0.68rem; letter-spacing: 0.3px; Xwidth: 66px;"><? echo $badge_text; ?></span>

                                        </td>

                                        <td class="Xd-none Xd-md-table-cell Xtext-muted">

                                            <?php
                                            if ($eperms_info['is_group_w']) {
                                                $badge_color = 'danger';
                                                $badge_text  = $lang['FPA_YES'];
                                            } else {
                                                $badge_color = 'success';
                                                $badge_text  = $lang['FPA_NO'];
                                            }
                                            ?>
                                            <span class="badge bg-<? echo $badge_color; ?>-subtle text-<? echo $badge_color; ?> border border-<? echo $badge_color; ?> fw-semibold px-2 py-1 text-uppercase w-100" style="font-size: 0.68rem; letter-spacing: 0.3px; Xwidth: 66px;"><? echo $badge_text; ?></span>

                                        </td>
                                        <td class="text-center Xtext-end Xpe-3">

                                            <?php
                                            if ($eperms_info['is_world_w']) {
                                                $badge_color = 'danger';
                                                $badge_text  = $lang['FPA_YES'];
                                            } else {
                                                $badge_color = 'success';
                                                $badge_text  = $lang['FPA_NO'];
                                            }
                                            ?>
                                            <span class="badge bg-<? echo $badge_color; ?>-subtle text-<? echo $badge_color; ?> border border-<? echo $badge_color; ?> fw-semibold px-2 py-1 text-uppercase w-100" style="font-size: 0.68rem; letter-spacing: 0.3px; Xwidth: 66px;"><? echo $badge_text; ?></span>

                                        </td>

                                    </tr>
                                <?php endforeach; ?>

                            </tbody>
                        </table>

                    </div><!-- /table-responsive -->

                </div><!-- /col -->

            </div><!-- /row #elevatedPermissions-->

        </div><!--/container #permissionPanel-->


    </main><!-- /main -->




    <?php
    /*
     * =============================================================================
     * SECTION: FOOTER
     * =============================================================================
     * copyright, versioning, notifications & any legals
     */
    ?>
    <footer class="border-top py-3 mt-5 bg-body-tertiary">

        <div class="container small text-body-secondary">
            <p class="p-0 m-0 small text-center">
                <?php echo $lang['FPA_LONG']; ?> v<?php echo FPA_VERSION .' ('. FPA_CODENAME .') '. FPA_COPYRIGHT_STMT; ?><br />
                <?php echo '[ Language : ' . $lang['FPA_THISLANG'] . ' ] [ Updated : ' . FPA_LAST_UPDATED . ' ]'; ?><br />
                <a href="docs/accessibility.md" class="link-secondary">Accessibility (WCAG 2.1 AA)</a>
            </p>
        </div>

    </footer><!-- /footer -->



    <?php
    /*
     * =============================================================================
     * SECTION: OFFCANVAS SETTINGS PANEL
     * =============================================================================
     * right aligned, compact, offcanvas with integrated floating button handle
     */
    ?>
    <div class="offcanvas offcanvas-end shadow" tabindex="-1" id="settingsOffcanvas" aria-labelledby="settingsOffcanvasLabel" style="width: 340px; visibility: visible;">

        <!-- Floating button handle (moves natively with the canvas) -->
        <button class="btn btn-primary bg-fpa position-absolute d-flex align-items-center justify-content-center shadow-sm"
                type="button"
                data-bs-toggle="offcanvas"
                data-bs-target="#settingsOffcanvas"
                aria-controls="settingsOffcanvas"
                style="top: 120px; left: -52px; width: 52px; height: 54px; border-color: var(--fpa-primary-color); border-radius: 8px 0 0 8px; border-right: 0; z-index: 1060;">
            <i class="bi bi-gear-wide-connected fs-3"></i>
        </button>

        <!-- Header -->
        <div class="offcanvas-header bg-fpa border-bottom py-2 px-3">
            <h6 class="offcanvas-title fw-bold text-uppercase tracking-wider m-0" id="settingsOffcanvasLabel">
               <?php echo $lang['FPA_RUNTIMEOPTIONS']; ?>
            </h6>
            <button type="button" class="btn-close text-reset btn-sm" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>

        <!-- Body -->
        <div class="offcanvas-body d-flex flex-column justify-content-between p-3" style="overflow-y: auto;">

            <!-- Top Section: Preset profile buttons & option switches -->
            <div>
                <!-- Preset Profiles -->
                <small class="text-muted fw-bold d-block text-uppercase mb-2" style="font-size: 0.72rem; letter-spacing: 0.5px;">Profiles</small>
                <div class="row g-2 mb-3">
                    <div class="col-4">
                        <button type="button" class="btn btn-outline-secondary btn-sm fw-bold w-100 py-2 d-flex flex-column align-items-center justify-content-center <?php //echo ($_SESSION['current_preset_profile'] === 'compact') ? 'active' : ''; ?>">
                            <i class="bi bi-layers mb-1 fs-5"></i>
                            <span style="font-size: 0.7rem;"><?php echo $lang['FPA_COMPACT'] ?? 'Compact'; ?></span>
                        </button>
                    </div>
                    <div class="col-4">
                        <button type="button" class="btn btn-outline-secondary btn-sm fw-bold w-100 py-2 d-flex flex-column align-items-center justify-content-center <?php //echo ($_SESSION['current_preset_profile'] === 'default') ? 'active' : ''; ?>">
                            <i class="bi bi-layers-half mb-1 fs-5"></i>
                            <span style="font-size: 0.7rem;"><?php echo $lang['FPA_DEFAULT'] ?? 'Default'; ?></span>
                        </button>
                    </div>
                    <div class="col-4">
                        <button type="button" class="btn btn-outline-secondary btn-sm fw-bold w-100 py-2 d-flex flex-column align-items-center justify-content-center <?php //echo ($_SESSION['current_preset_profile'] === 'detailed') ? 'active' : ''; ?>">
                            <i class="bi bi-layers-fill mb-1 fs-5"></i>
                            <span style="font-size: 0.7rem;"><?php echo $lang['FPA_DETAILED'] ?? 'Detailed'; ?></span>
                        </button>
                    </div>
                </div>

                <!-- GROUP 1: Joomla element display settings -->
                <small class="text-muted fw-bold d-block text-uppercase mb-1" style="font-size: 0.72rem; letter-spacing: 0.5px;">1. System Settings</small>
                <div class="Xbg-light p-2 rounded border mb-3">
                    <div class="row g-1">
                        <div class="col-6"><div class="form-check form-switch m-0"><input class="form-check-input" type="checkbox" id="sw1" checked><label class="form-check-label text-truncate w-100 fallback-sm style-label" for="sw1">Live Engine</label></div></div>
                        <div class="col-6"><div class="form-check form-switch m-0"><input class="form-check-input" type="checkbox" id="sw2"><label class="form-check-label text-truncate w-100 fallback-sm style-label" for="sw2">Debug Mode</label></div></div>
                        <div class="col-6"><div class="form-check form-switch m-0"><input class="form-check-input" type="checkbox" id="sw3" checked><label class="form-check-label text-truncate w-100 fallback-sm style-label" for="sw3">Auto Cache</label></div></div>
                        <div class="col-6"><div class="form-check form-switch m-0"><input class="form-check-input" type="checkbox" id="sw4"><label class="form-check-label text-truncate w-100 fallback-sm style-label" for="sw4">Strict Sync</label></div></div>
                        <div class="col-6"><div class="form-check form-switch m-0"><input class="form-check-input" type="checkbox" id="sw5" checked><label class="form-check-label text-truncate w-100 fallback-sm style-label" for="sw5">SSL Force</label></div></div>
                        <div class="col-6"><div class="form-check form-switch m-0"><input class="form-check-input" type="checkbox" id="sw6"><label class="form-check-label text-truncate w-100 fallback-sm style-label" for="sw6">Dev Tools</label></div></div>
                    </div>
                </div>

                <!-- GROUP 2: General display options -->
                <small class="text-muted fw-bold d-block text-uppercase mb-1" style="font-size: 0.72rem; letter-spacing: 0.5px;">2. Display Options</small>
                <div class="Xbg-light p-2 rounded border mb-3">
                    <div class="row g-1">
                        <div class="col-6"><div class="form-check form-switch m-0"><input class="form-check-input" type="checkbox" id="sw7" checked><label class="form-check-label text-truncate w-100 fallback-sm style-label" for="sw7">Dark Theme</label></div></div>
                        <div class="col-6"><div class="form-check form-switch m-0"><input class="form-check-input" type="checkbox" id="sw8" checked><label class="form-check-label text-truncate w-100 fallback-sm style-label" for="sw8">Fluid Grid</label></div></div>
                        <div class="col-6"><div class="form-check form-switch m-0"><input class="form-check-input" type="checkbox" id="sw9"><label class="form-check-label text-truncate w-100 fallback-sm style-label" for="sw9">Compact UI</label></div></div>
                        <div class="col-6"><div class="form-check form-switch m-0"><input class="form-check-input" type="checkbox" id="sw10" checked><label class="form-check-label text-truncate w-100 fallback-sm style-label" for="sw10">Animations</label></div></div>
                        <div class="col-6"><div class="form-check form-switch m-0"><input class="form-check-input" type="checkbox" id="sw11"><label class="form-check-label text-truncate w-100 fallback-sm style-label" for="sw11">Tooltips</label></div></div>
                        <div class="col-6"><div class="form-check form-switch m-0"><input class="form-check-input" type="checkbox" id="sw12" checked><label class="form-check-label text-truncate w-100 fallback-sm style-label" for="sw12">High Contrast</label></div></div>
                    </div>
                </div>

                <!-- GROUP 3: Fileters & logging -->
                <small class="text-muted fw-bold d-block text-uppercase mb-1" style="font-size: 0.72rem; letter-spacing: 0.5px;">3. Filters & Logging</small>
                <div class="Xbg-light p-2 rounded border mb-3">
                    <div class="row g-1">
                        <div class="col-6"><div class="form-check form-switch m-0"><input class="form-check-input" type="checkbox" id="sw13" checked><label class="form-check-label text-truncate w-100 fallback-sm style-label" for="sw13">Log Queries</label></div></div>
                        <div class="col-6"><div class="form-check form-switch m-0"><input class="form-check-input" type="checkbox" id="sw14"><label class="form-check-label text-truncate w-100 fallback-sm style-label" for="sw14">Track Errors</label></div></div>
                        <div class="col-6"><div class="form-check form-switch m-0"><input class="form-check-input" type="checkbox" id="sw15" checked><label class="form-check-label text-truncate w-100 fallback-sm style-label" for="sw15">Deep Audit</label></div></div>
                        <div class="col-6"><div class="form-check form-switch m-0"><input class="form-check-input" type="checkbox" id="sw16" checked><label class="form-check-label text-truncate w-100 fallback-sm style-label" for="sw16">Metrics API</label></div></div>
                        <div class="col-6"><div class="form-check form-switch m-0"><input class="form-check-input" type="checkbox" id="sw17"><label class="form-check-label text-truncate w-100 fallback-sm style-label" for="sw17">Geo Filters</label></div></div>
                        <div class="col-6"><div class="form-check form-switch m-0"><input class="form-check-input" type="checkbox" id="sw18"><label class="form-check-label text-truncate w-100 fallback-sm style-label" for="sw18">IP Masking</label></div></div>
                    </div>
                </div>
            </div>

            <!-- Bottom Section: Sticky submit form actions -->
            <div class="pt-2 border-top mt-2">
                <small class="text-muted fw-bold d-block text-uppercase mb-1" style="font-size: 0.72rem; letter-spacing: 0.5px;">Apply Profile</small>
                <div class="btn-group w-100" role="group">

                    <button type="submit" form="runtime-profile" name="action" value="fpa" class="btn btn-outline-success py-2 btn-sm d-flex flex-column align-items-center">
                        <i class="bi bi-pc-display-horizontal mb-0 fs-5"></i>
                        <span style="Xfont-size: 0.68rem; font-weight: 600;"><?php echo $lang['FPA_SHORT'] ?? 'FPA'; ?></span>
                    </button>

                    <button type="submit" form="runtime-profile" name="action" value="post" class="btn btn-outline-success py-2 btn-sm d-flex flex-column align-items-center">
                        <i class="bi bi-file-post mb-0 fs-5"></i>
                        <span style="Xfont-size: 0.68rem; font-weight: 600;"><?php echo $lang['FPA_POST'] ?? 'Post'; ?></span>
                    </button>

                    <button type="submit" form="runtime-profile" name="action" value="post" class="btn btn-outline-success py-2 btn-sm d-flex flex-column align-items-center">
                        <i class="bi bi-file-post mb-0 fs-5"></i>
                        <span style="Xfont-size: 0.68rem; font-weight: 600;"><?php echo $lang['FPA_TEXT'] ?? 'Text'; ?></span>
                    </button>

                </div>
            </div>

        </div>

    </div><!-- /offcanvas -->




    <?php
    /*
     * =============================================================================
     * SECTION: EXTERNAL JS, INTENRAL SCRIPTS & RESOURCES
     * =============================================================================
     * All Javascript needs to be within a script tag containing the $fpa_nonce
     * to conform to the Content Security Policy (CSP)
     */
    ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous" nonce="<?php echo $fpa_nonce; ?>"></script>


    <?php
    /**
     * --- fpa-exception-queue data bridge ---
     * php array to json output bridge for the fpa-exception-queue JS to read
     *
     * Usage:
     * none; data bridging for queue array conversion before passing to
     * display function (below)
     *
     */
    ?>
    <script nonce="<?php echo $fpa_nonce; ?>" id="php-queue-data" type="application/json">
      <?php echo json_encode($fpa_exception_queue); ?>
    </script>


    <script nonce="<?php echo $fpa_nonce; ?>">

        /**
         * --- bootstrap dark/light theme changer ---
         * the theme selection is stored in localStorage for persistence
         *
         * Usage:
         * select light, dark, auto from navbar icon dropdown
         *
         */
        (() => {
            'use strict'

            // Fetch stored preference or default to 'auto'
            const getStoredTheme = () => localStorage.getItem('theme') || 'auto'

            // Apply the actual theme setting to the documentElement
            const setTheme = theme => {
                if (theme === 'auto') {
                    const isSystemDark = window.matchMedia('(prefers-color-scheme: dark)').matches
                    document.documentElement.setAttribute('data-bs-theme', isSystemDark ? 'dark' : 'light')
                } else {
                    document.documentElement.setAttribute('data-bs-theme', theme)
                }
            }

            // Sync visual active states inside the dropdown list
            const showActiveTheme = (theme) => {
                const switcher = document.querySelector('#themeSwitcher')
                if (!switcher) return

                const activeItem = switcher.querySelector(`[data-theme-value="${theme}"]`)

                // Clear active class from all options
                switcher.querySelectorAll('[data-theme-value]').forEach(element => {
                    element.classList.remove('active')
                })

                // Highlight chosen preference
                if (activeItem) {
                    activeItem.classList.add('active')
                }
            }

            // Initialize theme on initial load
            const initialTheme = getStoredTheme()
            setTheme(initialTheme)
            showActiveTheme(initialTheme)

            // Listen for system appearance updates while in 'auto' mode
            window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', () => {
                const storedTheme = getStoredTheme()
                if (storedTheme === 'auto') {
                    setTheme('auto')
                }
            })

            // Bind click event handlers to all dropdown switch items
            document.addEventListener('DOMContentLoaded', () => {
                document.querySelectorAll('[data-theme-value]').forEach(toggle => {
                    toggle.addEventListener('click', () => {
                        const theme = toggle.getAttribute('data-theme-value')
                        localStorage.setItem('theme', theme)
                        setTheme(theme)
                        showActiveTheme(theme)
                    })
                })
            })
        })()


        /**
         * --- fpa exceptions message queue ---
         * generates and adds an exception message (list item) to the fpa_exception_queue
         * - if no exceptions, no icon in the navbar
         * - if exceptions, adds icon to the navbar, displays number of exceptions
         *   and provides a dropdown list of clickable notifications that scroll to
         *   the appropriate on-page section
         *
         * Usage:
         * $fpa_exception_queue[] = [
         *     'category'  => 'Permissions',
         *     'type'     => 'warning', // Bootstrap color (danger, warning, info)
         *     'text'     => 'At least one folder has group writable permissions.',
         *     'solution' => 'Reset permissions to to the system default (usually 755).',
         *     'target_id' => 'permissionsPanel' // Matches the ID of the checkbox in your offcanvas layout!
         *  ];
         *
         */
        document.addEventListener("DOMContentLoaded", () => {
            const rawData = document.getElementById("php-queue-data").textContent;
            const fpa_exception_queue = JSON.parse(rawData || "[]");

            const wrapper = document.getElementById("notification-wrapper");
            const countBadge = document.getElementById("queue-count");
            const itemsContainer = document.getElementById("queue-dropdown-items");

            if (fpa_exception_queue.length === 0) return;

            countBadge.textContent = fpa_exception_queue.length;

            let listHtml = '';
            fpa_exception_queue.forEach(issue => {
            // Generate a list item that functions as a rich link card
            listHtml += `
                <li class="border-bottom">
                    <a href="#${issue.target_id}" class="dropdown-item p-3 text-wrap notification-card-link" data-target="${issue.target_id}">
                        <div class="d-flex align-items-start">
                            <span class="badge bg-${issue.type} me-1 mt-0 small">&nbsp;</span>
                        <div>
                        <div class="small mb-1 lh-sm"><strong>${issue.category}:</strong> ${issue.text}</div>
                        <div class="text-muted extra-small-text p-2 rounded border border-light">
                            <strong> <i class="bi bi-magic me-1"></i>Action:</strong> ${issue.solution}
                        </div>
                        </div>
                        </div>
                    </a>
                </li>
            `;
            });

            itemsContainer.innerHTML = listHtml;
            wrapper.classList.remove("d-none");

            // Hook up the smart scroll helper function (scrolls to section showing the exception)
            initNotificationScroller();
        });


        /**
         * --- bootstrap and popper utilities ---
         * select and initialise all bootstrap utilites, such as tooltips & popovers
         *
         * Usage:
         * add standard bootstrap tooltip & popover options to an element
         *
         */
        document.addEventListener('DOMContentLoaded', () => {
            // select and initialise all tooltips
            const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]');
            const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl));

            // select and initialise all popovers
            const popoverTriggerList = document.querySelectorAll('[data-bs-toggle="popover"]')
            const popoverList = [...popoverTriggerList].map(popoverTriggerEl => new bootstrap.Popover(popoverTriggerEl))
        });


        /**
         * --- privacy redaction (GUI only) ---
         * capture the privacy switch change and automagically reload the page
         * appropriately using the PHP SESSION data (checked (readacted) /
         * unchecked (un-redacted)
         *
         * Usage:
         * echo $_SESSION['privacy_enabled'] ? '<span class="privacy-mask">[ ' . $lang['FPA_REDACTED'] . ' ]</span>' : htmlspecialchars($ARRAY_NAME['KEY']);
         *
         */
        document.addEventListener('DOMContentLoaded', function () {
            const privacySwitch = document.getElementById('nav-privacy-switch');

            privacySwitch.addEventListener('change', function () {
                // Acquire the current state of the switch toggle
                const formData = new FormData();
                formData.append('privacy_ajax', '1');
                formData.append('privacy', this.checked ? '1' : '0');

                // Send the switch toggle change to PHP silently
                fetch('<?php echo $fpa_self_url; ?>', {
                    method: 'POST',
                    body: formData,
                    headers: { 'X-Requested-With': 'XMLHttpRequest' }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Instantly refresh the page to pull the redacted HTML output
                        window.location.reload();
                    }
                })
                .catch(error => console.error('Network security error:', error));
            });
        });


        /**
         * --- data-fpa-toggle ---
         * show/hide advanced or extended data in sections, row, cell, div
         *
         * Usage:
         * 1. add data-fpa-toggle="<your-trigger-word>" EG: permsaudit, to a button
         * 2. add the classes d-none fpa-toggle-<your-trigger-word> EG: permsaudit to the element(s) to show/hide
         *
         */
        document.addEventListener('DOMContentLoaded', function() {
            // Gather all elements acting as toggle triggers across the entire page
            const toggleButtons = document.querySelectorAll('[data-fpa-toggle]');

            toggleButtons.forEach(function(button) {
                button.addEventListener('click', function() {
                    // Identify the target namespace (e.g. "permissions" or "server")
                    const targetToken = this.getAttribute('data-fpa-toggle');

                    // Locate all table components tied to this specific namespace
                    const targetCells = document.querySelectorAll('.fpa-toggle-' + targetToken);

                    targetCells.forEach(function(cell) {
                        cell.classList.toggle('d-none');
                    });

                    // Locate and swap the icon component safely inside the clicked button
                    const icon = this.querySelector('.bi');
                    if (icon) {
                        if (icon.classList.contains('bi-eye')) {
                            icon.classList.remove('bi-eye');
                            icon.classList.add('bi-eye-slash');
                        } else {
                            icon.classList.remove('bi-eye-slash');
                            icon.classList.add('bi-eye');
                        }
                    }
                });
            });
        });

    </script>

</body>
</html>
