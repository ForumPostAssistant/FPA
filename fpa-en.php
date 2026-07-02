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
$fpaNonce = bin2hex(random_bytes(16));

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
    header("Content-Security-Policy: default-src 'self'; script-src 'self' 'nonce-{$fpaNonce}' https://cdn.jsdelivr.net; style-src 'self' 'unsafe-inline' https://cdn.jsdelivr.net https://cdnjs.cloudflare.com; font-src 'self' https://cdnjs.cloudflare.com; img-src 'self' data:; connect-src 'self' https://cdn.jsdelivr.net; frame-ancestors 'none';");

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
$fpaSelfUrl = htmlspecialchars(FPA_SELF, ENT_QUOTES, 'UTF-8');

// joomla parent flags
define ('_VALID_MOS', 1);              // for J!1.0
define ('_JEXEC', 1);                  // for J!1.5, J!1.6 thru J!6.0

// --- fpa feature configuration ---
const FPA_DEV = false; // developer-mode, displays raw array data on screen
const FPA_DIA = true;  // diagnostic-mode, turns on PHP logging errors, display errors and logs error to a file
const FPA_SELF_DESTRUCT = true; // self-destruct, attempts to self-delete on next run if file older than configured duration
const FPA_SELF_DESTRUCT_AGE = 3; // self-destruct filetime age duration
const FPA_SSL_REDIRECT = true; // SSL Redirect - when possible and if a valid SSL certificate is found FPA attempts to redirect to the SSL version of the site
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
    $fpaLogfile = "./fpa_" . date('Y-m-d') . "_log";

    // direct all standard PHP errors to the fpa logfile automatically
    ini_set('error_log', $fpaLogfile);

    // append a session initialization header to mark the debug timeline
    $fpalogMessage = "--- FPA Diagnostic Session Started: " . date('l jS F Y h:i:s A') . " ---" . PHP_EOL;
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
$isPrivacyChecked = $_SESSION['privacy_enabled'] ? 'checked' : '';




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

    // FPA titles, headings, Labels, meta & descriptions
    'FPA_META_VERSIONS'            => 'Live Version Status',
    'FPA_META_APP_VERSIONS'        => 'Application Versions',
    'FPA_META_INSTANCE_DIAG'       => 'Joomla Core Instance Diagnostics',
    'FPA_META_SYSTEMSASSURANCE'    => 'Systems Assurance',      // Environmental
    'FPA_META_PLATFORMINTEGRITY'   => 'Platform Integrity',     // Security & Safeguards
    'FPA_META_TUNINGOPTIMISATION'  => 'Tuning & Optimisation',  // Perfomance
    'FPA_META_CORE_FOLDERS'        => 'Core Folders',
    'FPA_HEADING_PERMISSIONS'      => 'Permissions Report',
    'FPA_LANG_CORE_DIRS'           => 'Joomla Core Directories',
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
$rawHttpLang = $_SERVER['HTTP_ACCEPT_LANGUAGE'] ?? 'en-GB';

// Split by comma to grab the first preferred language preference string
$primaryLangBlock = explode(',', $rawHttpLang);
$preferredLang = $primaryLangBlock[0] ?? 'en-GB';

// Clean out potential malicious characters to make file system operations safe
$browserLang = preg_replace('/[^a-zA-Z\-_]/', '', $preferredLang);

// Standardise the casing format to match Joomla's official repository structures (e.g., 'fr-FR')
if (strpos($browserLang, '-') !== false) {
    list($langCode, $regionCode) = explode('-', $browserLang, 2);
    $langCode    = strtolower($langCode);
    $regionCode  = strtoupper($regionCode);

    $browserLang = "{$langCode}-{$regionCode}"; // e.g., 'fr-CA'

    // Map the fallback to the matching primary regional country variant (e.g., 'fr-FR')
    $baseFallback = "{$langCode}-" . strtoupper($langCode);
} else {
    // If the browser only sends 'fr', automatically map it directly to Joomla's 'fr-FR' asset target
    $langCode     = strtolower($browserLang);
    $browserLang  = "{$langCode}-" . strtoupper($langCode);
    $baseFallback = $browserLang;
}

// Only attempt translation if the user is not using the built-in English base
if ($browserLang !== 'en-GB') {
    // Create an ordered queue matching RFC3066 naming standards
    $fileTargets   = [];
    $fileTargets[] = "{$browserLang}.php"; // First choice: e.g., 'fr-CA.php'

    if ($browserLang !== $baseFallback) {
        $fileTargets[] = "{$baseFallback}.php"; // Fallback choice: e.g., 'fr-FR.php'
    }

    $localCacheFile = null;
    $fetchedSuccessfully = false;

    // Loop through our targets (will break early as soon as one successfully loads or downloads)
    foreach ($fileTargets as $remoteFileName) {
        $localCacheFile = sys_get_temp_dir() . "/fpa_version2_lang_{$remoteFileName}";
        $cacheLifetime  = 86400; // 24 hours in seconds

        // If a valid cache file already exists locally, skip network checks entirely
        if (file_exists($localCacheFile) && (time() - filemtime($localCacheFile) <= $cacheLifetime)) {
            $fetchedSuccessfully = true;
            break;
        }

        // If cache is missing or stale, attempt to fetch this specific file from GitHub
        $githubUrl = "https://raw.githubusercontent.com/ForumPostAssistant/FPA/refs/heads/v2-dev/lang/{$remoteFileName}";

        $ch = curl_init();
        curl_setopt_array($ch, [
            CURLOPT_URL            => $githubUrl,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT        => 4,
            CURLOPT_USERAGENT      => 'ForumPostAssistant-Client/2.0',
            CURLOPT_FOLLOWLOCATION => true,
        ]);

        $rawPayload = curl_exec($ch);
        $httpCode   = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        // PHP7.x cross-version handle cleanup as PHP8+ utilises a garbage collector
        if (PHP_VERSION_ID < 80000) {
            curl_close($ch);
        }

        // START: CODE/PAYLOAD HARDENING INTEGRITY LAYER
        if ($httpCode === 200 && !empty($rawPayload)) {

            // Check for malicious file include backdoors or remote system command injection attempts
            $dangerousTokens = ['eval', 'system', 'exec', 'passthru', 'shell_exec', '$_POST', '$_GET', '$_REQUEST'];
            $isPayloadSafe = true;

            foreach ($dangerousTokens as $token) {
                if (stripos($rawPayload, $token) !== false) {
                    $isPayloadSafe = false;
                    break;
                }
            }

            // Ensure the downloaded file is structured purely as a clean array return statement
            if ($isPayloadSafe && strpos($rawPayload, '<?php') === 0 && strpos($rawPayload, 'return [') !== false) {
                if (@file_put_contents($localCacheFile, $rawPayload) !== false) {
                    $fetchedSuccessfully = true;
                    break; // Successfully got a file, break out of fallback loop!
                }
            }
        }
        // END: CODE/PAYLOAD HARDENING INTEGRITY LAYER
    }

    // If we have a valid local cache file verified by our queue loop, load and merge it in to $lang array
    if ($fetchedSuccessfully && $localCacheFile !== null && file_exists($localCacheFile)) {
        $overrides = include $localCacheFile;

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
$localIpPrefixes = [
    '127.',        // Loopback IPv4
    '10.',         // Private Class A
    '192.168.',    // Private Class C
    '::1',         // Loopback IPv6
];

// dynamically generate the reduced 172.16.0.0/12 private range to save memory
for ($i = 16; $i <= 31; $i++) {
    $localIpPrefixes[] = '172.' . $i . '.';
}

$isLocalhost = false;
$remoteAddr  = $_SERVER['REMOTE_ADDR'] ?? '';

// perform safe, prefix-anchored matching
if ($remoteAddr !== '') {
    foreach ($localIpPrefixes as $prefix) {
        // enforce that the IP address MUST start with the prefix (position 0)
        if (strpos($remoteAddr, $prefix) === 0) {
            $isLocalhost = true;
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
$isWindows  = (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN');
$isWinLocal = ($isLocalhost && $isWindows);


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
/* not sure this is worth the hassle */
function fpaLang(string $key): void
{
    global $lang;

    // Fallback to the key name if the translation doesn't exist
    $text = $lang[$key] ?? $key;

    echo htmlspecialchars($text, ENT_QUOTES, 'UTF-8');
}




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
//    $exceptionQueue[] = [
//        'type'        => 'danger', // Bootstrap color code
//        'text'        => 'Graphical metrics are enabled but data source is unavailable.',
//        'solution'    => 'Disable Graphical Metrics or upload a valid system data log source file.',
//        'target_id'   => 'show_graphics' // Matches the ID of the checkbox in your offcanvas layout!
//    ];
// }
$exceptionQueue = [];

// --- Basic Live Version Checks ---
$latestVersions = [
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
$appVersions = [
    'meta' => [
        'name' => 'FPA_META_APP_VERSIONS' // Language Key: 'Application Versions'
    ],
    'targets' => [] // Populated dynamically with environment metadata during runtime
];

// --- Core Joomla Structure Diagnostics ---
$joomlaInstance = [
    'meta' => [
        'name' => 'FPA_META_INSTANCE_DIAG' // Language Key: 'Joomla Core Instance Diagnostics'
    ],
    'found'               => $lang['FPA_NO'],
    'installed'           => $lang['FPA_NO'],
    'configOverride'       => false,
    'configPath'           => $lang['FPA_UNKNOWN'],
    'configMode'           => $lang['FPA_UNKNOWN'],
    'configOwner'          => $lang['FPA_UNKNOWN'],
    'configGroup'          => $lang['FPA_UNKNOWN'],
    'configWritable'       => $lang['FPA_NO'],
    'configWorldWritable'  => false,
    'configOwnerConflict'   => false
];

// --- Environment Rating Metrics (Enhances and adds to v1 Confidence Rating) ---
$fpaEnvironment = [
    'meta' => [
        'name' => $lang['FPA_META_SYSTEMSASSURANCE'] // Language Key: 'Environment Metrics'
    ],
    'score'           => 100, // Starts perfect, drops as vulnerabilities are found
    'phpProcessUser'  => $lang['FPA_UNKNOWN'],
    'umask'           => '00',
    'sslActive'       => false,
    'displayErrors'   => false
];

// --- Security Rating Metrics (New in FPA v2, adds to Confidence Rating) ---
$fpaSecurity = [
    'meta' => [
        'name' => $lang['FPA_META_PLATFORMINTEGRITY'] // Language Key: 'Security & Hardening Metrics'
    ],
    'score'            => 100, // Starts perfect, drops as vulnerabilities are found
    'phpProcessUser'   => $lang['FPA_UNKNOWN'],
    'sslActive'        => false,
    'displayErrors'    => false
];

// --- Host, PHP & Instance Performance Rating Metrics (New in FPA v2, adds to Confidence Rating) ---
$fpaPerformance = [
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
$joomlaFolders = [
    'meta' => [
        'name'         => $lang['FPA_META_CORE_FOLDERS'],
        'php_user'     => 'unknown',
    ],
    'targets' => [
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
$hasRootDirs  = file_exists('components/') && file_exists('modules/');
$hasAdminDirs = file_exists('administrator/components/') && file_exists('administrator/modules/');
$hasIndexFile = file_exists('index.php');

if (($hasRootDirs || $hasAdminDirs) && $hasIndexFile) {
    // Structural presence verified (CMS footprint exists on server)
    $joomlaInstance['found'] = $lang['FPA_YES'];

    // Separate Installation Check: Determine JPATH_CONFIGURATION path rules
    // Establish the absolute runtime baseline representing JPATH_ROOT
    $jpathRoot = rtrim(str_replace('\\', '/', __DIR__), '/');
    $configSearchPath = $jpathRoot; // Default configuration home directory

    // Check for custom overrides mapped via local defines.php scripts
    $definesTargets = [
        'includes/defines.php',
        'administrator/includes/defines.php',
        'defines.php'
    ];

    foreach ($definesTargets as $targetFile) {
        if (file_exists($targetFile) && is_readable($targetFile)) {
            $fileContent = file_get_contents($targetFile);

            // Catch native format: define('JPATH_CONFIGURATION', JPATH_ROOT . '/custom');
            // Or modern format:   \define('JPATH_CONFIGURATION', JPATH_ROOT . '/custom');
            $pattern = '/\\\\?define\s*\(\s*[\'"]JPATH_CONFIGURATION[\'"]\s*,\s*(.*?)\s*\)\s*;/i';

            if (preg_match($pattern, $fileContent, $matches)) {
                $rawExpression = trim($matches[1]);

                // If it isn't strictly assigning to JPATH_ROOT, evaluate the value
                if ($rawExpression !== 'JPATH_ROOT' && $rawExpression !== '\\JPATH_ROOT') {

                    // Clean up common syntax to safely evaluate the text expression string
                    $cleanExpression = str_replace(['JPATH_ROOT', '\\JPATH_ROOT', 'DIRECTORY_SEPARATOR', '.', '"', "'", ' '], ['', '', '/', '', '', '', ''], $rawExpression);
                    $cleanExpression = '/' . trim($cleanExpression, '/');

                    // Build absolute system override target path
                    $configSearchPath = rtrim($jpathRoot . $cleanExpression, '/');

                    // FIXED: Aligned array keys with initialization block
                    $joomlaInstance['configOverride'] = true;
                    break;
                }
            }
        }
    }

    // Final Verification: Check if the configuration target file exists and is active
    $configFilePath = $configSearchPath . '/configuration.php';

    if (file_exists($configFilePath) && is_readable($configFilePath) && filesize($configFilePath) > 0) {
        $joomlaInstance['installed']  = $lang['FPA_YES'];
        $joomlaInstance['configPath'] = $configFilePath; // Saved path safely

        // Defensive: is_writable() is the standard native PHP function name alias
        // we also check for ownership later as writeable does not always mean, writeable securely (think wheel-groups)
        if (is_writable($configFilePath)) {
            $joomlaInstance['configWritable'] = $lang['FPA_YES'];
        }

        // Get the configuration file permissions (Cleaned up redundant file_exists checks)
        // Bitwise AND mask isolates ONLY the lower 9 permission bits (ignores file-type flags)
        // and forces a zero-padded, 4-digit octal string output (e.g., '0644')
        $joomlaInstance['configMode'] = sprintf('%04o', fileperms($configFilePath) & 0777);

        // Obtain the configuration file owner and group
        if (function_exists('posix_getpwuid') && function_exists('posix_getgrgid') && !$isWindows) {
            // Fetch raw system info blocks safely
            $ownerInfo = posix_getpwuid(fileowner($configFilePath));
            $groupInfo = posix_getgrgid(filegroup($configFilePath));

            // Defensive: Use Null Coalescing (??) to grab the string name or fall back to numeric ID
            $joomlaInstance['configOwner'] = $ownerInfo['name'] ?? fileowner($configFilePath);
            $joomlaInstance['configGroup'] = $groupInfo['name'] ?? filegroup($configFilePath);
        } else {
            // Windows fallback
            $joomlaInstance['configOwner'] = fileowner($configFilePath);
            $joomlaInstance['configGroup'] = filegroup($configFilePath);
        }

        // discover who is currently executing this PHP script run
        // on some shared servers, wheel-groups may be used, potentially allowing other wheel-group members cross-account
        // access to writeable files, here we check that the executing user is the ownership user
        $phpProcessUser = 'Unknown';
        if (function_exists('posix_getpwuid') && function_exists('posix_geteuid') && !$isWindows) {
            $processInfo = posix_getpwuid(posix_geteuid());
            $phpProcessUser = $processInfo['name'] ?? 'Unknown';
        } else {
            $phpProcessUser = get_current_user(); // Fallback identification method
        }

        // perform a defensive cross-check evaluation
        $joomlaInstance['configOwnerConflict'] = false;

        if ($joomlaInstance['configOwner'] !== $phpProcessUser && $phpProcessUser !== 'Unknown') {
            // flag an ownership conflict alert if names do not match
            $joomlaInstance['configOwnerConflict'] = true;
        }

        // save the process user name to the array for display on the dashboard
        $joomlaSecurity['phpProcessUser'] = $phpProcessUser;

    }
}



/*
 * FOLDER & PERMISSIONS CHECK
 */
// Define your framework base root folder path
// =========================================================================
// 1. ANCHOR BASE PATH TO SCRIPT POSITION (Joomla Root)
// =========================================================================
$basePath = __DIR__;

// =========================================================================
// 2. DISCOVER ACTIVE PHP PROCESS SYSTEM USER
// =========================================================================
$phpUser = 'unknown';
if (function_exists('posix_getpwuid') && function_exists('posix_geteuid')) {
    $processInfo = posix_getpwuid(posix_geteuid());
    $phpUser = $processInfo['name'] ?? 'unknown';
} elseif (function_exists('get_current_user')) {
    $phpUser = get_current_user();
}




// =========================================================================
// 4. LIVE RELATIVE PROCESSING LOOP (UPDATED FOR DANGER & WARNING TIERS)
// =========================================================================
foreach ($joomlaFolders['targets'] as $path => &$details) {
    $fullPath = $basePath . '/' . $path;

    if (file_exists($fullPath) && is_dir($fullPath)) {
        $details['exists'] = true;

        // 1. Read octal numeric modes (e.g. 0755)
        $filePerms = fileperms($fullPath);
        $details['perms'] = substr(sprintf('%o', $filePerms), -4); // e.g., "0755"

        // 2. Check writable engine flag status
        $details['writable'] = is_writable($fullPath);

        // 3. SECURE PERMISSION ANALYSIS ENGINE
        // Split the 4-digit octal string into individual position characters
        $digits = str_split($details['perms']); // [0, Owner, Group, World]
        $ownerBit = isset($digits[1]) ? (int)$digits[1] : 0;
        $groupBit = isset($digits[2]) ? (int)$digits[2] : 0;
        $worldBit = isset($digits[3]) ? (int)$digits[3] : 0;

        // CRITICAL DANGER CHECK: World-Writable (Ends in 7 or 6) or global 777
        if ($worldBit === 7 || $worldBit === 6 || $details['perms'] === '0777') {
            $details['sane'] = false;
            $details['warning'] = false; // Danger takes priority
        }
        // WARNING CHECK: Group-Writable (x7x) (REMOVED)or Loose Owner configurations (7xx)
        elseif ($groupBit === 7) {
        //elseif ($groupBit === 7 || $ownerBit === 7) {
            $details['sane'] = true;     // Not critically broken/world-open
            $details['warning'] = true;  // Flag as a configuration warning
        } else {
            $details['sane'] = true;
            $details['warning'] = false; // Safe standard compliance mode (e.g., 0755)
        }

        // 4. Resolve OS profile statistics info via POSIX helper extensions
        if (function_exists('posix_getpwuid')) {
            $ownerData = posix_getpwuid(fileowner($fullPath));
            $details['owner'] = $ownerData['name'] ?? 'unknown';

            $groupData = posix_getgrgid(filegroup($fullPath));
            $details['group'] = $groupData['name'] ?? 'unknown';

            if ($phpUser !== 'unknown' && $details['owner'] !== 'unknown') {
                $details['owner_match'] = ($details['owner'] === $phpUser);
            }
        }
    }
}
unset($details);




// =========================================================================
// 4. ELEVATED PERMISSIONS TESTS
// =========================================================================
// exits upon finding 10 folders with elevated permissions to save excessive runtime with a massive error list
function auditDirectoryPermissions(string $basePath, array $excludeList): array {
    $elevatedFolders = [];
    $maxViolations = 10;

    // 1. Identify the environment user running this PHP process (e.g. www-data)
    // Fallback securely to the file owner of the script if POSIX isn't available
    $phpUserUid = function_exists('posix_getuid') ? posix_getuid() : fileowner(__FILE__);

    // Ensure directory path trailing slash is structured uniformly
    $basePath = rtrim($basePath, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR;

    if (!is_dir($basePath)) {
        return [];
    }

    // 2. Instantiate a recursive directory scanner
    $directory = new RecursiveDirectoryIterator($basePath, RecursiveDirectoryIterator::SKIP_DOTS);
    $iterator  = new RecursiveIteratorIterator($directory, RecursiveIteratorIterator::SELF_FIRST);

    foreach ($iterator as $item) {
        // Enforce the execution breaker instantly if limits are reached
        if (count($elevatedFolders) >= $maxViolations) {
            break;
        }

        // Only scan directories
        if ($item->isDir()) {
            $realPath = $item->getRealPath();

            // 👇 UPDATED: Check the array keys ($folderKey) instead of nested array values
            foreach ($excludeList as $folderKey => $folderData) {
                // Combine the site root with the target key (e.g., "/var/www/html/" + "api/")
                $cleanExcluded = realpath($basePath . $folderKey);

                if ($cleanExcluded && (strpos($realPath, $cleanExcluded) === 0)) {
                    continue 2; // Path is in the exclude list; skip checking this folder
                }
            }



            // Check if this path matches or resides inside an entry in the exclude list
            /*
            foreach ($excludeList as $excluded) {
                $cleanExcluded = realpath($excluded);
                if ($cleanExcluded && (strpos($realPath, $cleanExcluded) === 0)) {
                    continue 2; // Skip checking this folder and move to next file item
                }
            }
            */

            /*
            foreach ($excludeList as $excluded) {
                if (isset($excluded['path'])) {
                    $cleanExcluded = realpath($excluded['path']);
                    if ($cleanExcluded && (strpos($realPath, $cleanExcluded) === 0)) {
                        continue 2; // Path is excluded; skip checking this folder
                    }
                }
            }
            */


            // 3. Extract UNIX mode permissions
            $perms = $item->getPerms();

            /**
             * Check the Standard Modes/Permissions
             * Owner | Group | World
             */
            // Check if the folder is World-Writable (e.g. xx2, xx3, xx6, xx7)
            $isWorldWritable = (bool)($perms & 0x0002);

            // Check if the folder is Group-Writable (e.g. x2x, x3x, x6x, x7x)
            $isGroupWritable = (bool)($perms & 0x0010);

            /**
             * Check the Special Modes/Permissions
             * 4000 = SUID
             * 2000 = SGID
             * 1000 = Sticky Bit
             */
            // If an executable file inside a folder has this bit active, it runs with the
            // privileges of the file owner (often root) rather than the user executing it.
            $hasSUID         = (bool)($perms & 0x0800);

            // Files created inside directories with this bit active inherit the group
            // configuration of the parent folder rather than the group of the creating user.
            $hasSGID         = (bool)($perms & 0x0400);

            // Restricts deletion privileges. In a directory with the sticky bit set,
            // a user can only delete or rename files they personally own.
            $hasStickyBit    = (bool)($perms & 0x0200);

            // 4. Test ownership matches
            $folderOwnerUid = $item->getOwner();
            $ownerMismatch  = ($folderOwnerUid !== $phpUserUid);

            // 5. Audit if folder permissions cross standard 755 boundaries or set & sticky bits
            if ($isWorldWritable || $isGroupWritable || $ownerMismatch || $hasSUID || $hasSGID || $hasStickyBit) {

                // Calculate the relative path by removing the basePath string
                $relativePath = str_replace($basePath, '', $realPath). '/';

                $elevatedFolders[] = [
                    'path'          => $relativePath,
                    'permissions'   => substr(sprintf('%o', $perms), -4), // e.g. "0777"
                    'is_world_w'    => $isWorldWritable,
                    'is_group_w'    => $isGroupWritable,
                    'uid_mismatch'  => $ownerMismatch,
                    'has_suid'      => $hasSUID, // Set UserID bit set
                    'has_sgid'      => $hasSGID, // Set GroupID bit set
                    'has_sticky'    => $hasStickyBit // Sticky Bit Set
                ];
            }
        }
    }

    return $elevatedFolders;
}

// --- Dynamic Workflow Execution Example ---
//$excludeList     = $joomlaFolders['targets'] ?? [];
//$elevatedFolders = auditDirectoryPermissions('.', $excludeList);

// Extract the targets array which now holds the nested path sub-arrays
$siteRoot = __DIR__;
$excludeList     = $joomlaFolders['targets'] ?? [];
$elevatedFolders = auditDirectoryPermissions($siteRoot, $excludeList);


// Only raise a single exceptionQueue entry if $elevatedFolders is not empty
if (!empty($elevatedFolders)) {
    $exceptionQueue[] = [
        'category'    => 'Elevated Permissions',
        'type'        => 'danger', // Bootstrap color code
        'text'        => 'At least one folder has elevated permissions or Set bits.',
        'solution'    => 'Reset permissions or Set bits to the system default.',
        'target_id'   => 'elevatedPermissions' // Matches the ID of the UI Panel
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
if ($joomlaInstance['found'] === $lang['FPA_YES'] && $joomlaInstance['installed'] === $lang['FPA_YES']) {

    // 1. SECURITY & HARDENING ASSESSMENT
    // -------------------------------------------------------------------------
    $rawPerms = fileperms($joomlaInstance['configPath']);
    $joomlaInstance['configMode'] = sprintf('%04o', $rawPerms & 0777);

    // Risk: Check for dangerously loose (World-Writable) permissions
    if (($rawPerms & 0002) !== 0) {
        $joomlaInstance['isWorldWritable'] = true;
        $fpaSecurity['score'] -= 40;
    }

    // Capture file owners and check identity alignment against the PHP process
    if (function_exists('posix_getpwuid') && !$isWindows) {
        $ownerInfo = posix_getpwuid(fileowner($joomlaInstance['configPath']));
        $joomlaInstance['configOwner'] = $ownerInfo['name'] ?? fileowner($joomlaInstance['configPath']);

        $processInfo = posix_getpwuid(posix_geteuid());
        $fpaSecurity['phpProcessUser'] = $processInfo['name'] ?? 'Unknown';
    } else {
        $joomlaInstance['configOwner']    = fileowner($joomlaInstance['configPath']);
        $fpaSecurity['phpProcessUser'] = get_current_user();
    }

    // Risk: Flag an ownership mismatch conflict
    if ($joomlaInstance['configOwner'] !== $fpaSecurity['phpProcessUser'] && $fpaSecurity['phpProcessUser'] !== 'Unknown') {
        $joomlaInstance['configOwnerConflict'] = true;
        $fpaSecurity['score'] -= 20;
    }

    // Risk: Production display_errors is active
    if (filter_var(ini_get('display_errors'), FILTER_VALIDATE_BOOLEAN) || ini_get('display_errors') === '1') {
        $fpaSecurity['displayErrors'] = true;
        $fpaSecurity['score'] -= 15;
    }

    $fpaSecurity['score'] = max(0, $fpaSecurity['score']);


    // 2. PERFORMANCE & BOTTLENECK ASSESSMENT
    // -------------------------------------------------------------------------
    $fpaPerformance['memoryLimit']      = ini_get('memory_limit');
    $fpaPerformance['maxExecutionTime'] = (int) ini_get('max_execution_time');
    $fpaPerformance['opcacheEnabled']   = function_exists('opcache_get_status') && opcache_get_status(false) !== false;

    // Risk: Zend OPcache is completely disabled
    if (!$fpaPerformance['opcacheEnabled']) {
        $fpaPerformance['score'] -= 30;
    }

    // Risk: Server timeout threshold is too restrictive
    if ($fpaPerformance['maxExecutionTime'] > 0 && $fpaPerformance['maxExecutionTime'] < 30) {
        $fpaPerformance['score'] -= 20;
    }

    $fpaPerformance['score'] = max(0, $fpaPerformance['score']);


    // 3. ENVIRONMENT ASSESSMENT
    // -------------------------------------------------------------------------
    $fpaEnvironment['memoryLimit']      = ini_get('memory_limit');
    $fpaEnvironment['maxExecutionTime'] = (int) ini_get('max_execution_time');
    $fpaEnvironment['opcacheEnabled']   = function_exists('opcache_get_status') && opcache_get_status(false) !== false;


    if (function_exists('umask')) {
        try {
            // Calling umask() with no arguments fetches the active system state
            // without altering or mutating server parameters.
            $raw_mask = @umask();

            if ($raw_mask !== false && $raw_mask !== null) {
                // Convert integer to a standard 4-character octal string format (e.g., 0022)
                $fpaEnvironment['umask'] = str_pad(decoct($raw_mask), 4, '0', STR_PAD_LEFT);
            } else {
                $fpaEnvironment['umask'] = 'unknown (execution failed)';
            }
        } catch (\Throwable $e) {
            $fpaEnvironment['umask'] = 'restricted (exception caught)';
        }
    } else {
        // Graceful fallback for hardened servers or Windows runtime setups
        $fpaEnvironment['umask'] = 'unavailable (disabled/unsupported)';
    }

    // Risk: Zend OPcache is completely disabled
    if (!$fpaEnvironment['opcacheEnabled']) {
        $fpaEnvironment['score'] -= 30;
    }

    // Risk: Server timeout threshold is too restrictive
    if ($fpaEnvironment['maxExecutionTime'] > 0 && $fpaEnvironment['maxExecutionTime'] < 30) {
        $fpaEnvironment['score'] -= 20;
    }

    $fpaEnvironment['score'] = max(0, $fpaEnvironment['score']);


    // 3. OVERALL ENVIRONMENT CONFIDENCE GRADE MAPPING
    // -------------------------------------------------------------------------
    $overallScore = (int) round(($fpaSecurity['score'] + $fpaPerformance['score'] + $fpaEnvironment['score']) / 3);

    // TESTING ONLY
    ///$overallScore = 100;

    if ($overallScore >= 97) {
        $fpaReadinessGrade   = $lang['FPA_READINESS_APLUS']; // 97-100
        $fpaReadinessColor   = 'success';
        $fpaReadinessSummary = $lang['FPA_READINESS_MSG_A'];
    } elseif ($overallScore >= 90) {
        $fpaReadinessGrade   = $lang['FPA_READINESS_A']; // 90-96
        $fpaReadinessColor   = 'success';
        $fpaReadinessSummary = $lang['FPA_READINESS_MSG_A'];
    } elseif ($overallScore >= 80) {
        $fpaReadinessGrade   = $lang['FPA_READINESS_B']; // 80-95
        $fpaReadinessColor   = 'info';
        $fpaReadinessSummary = $lang['FPA_READINESS_MSG_B'];
    } elseif ($overallScore >= 70) {
        $fpaReadinessGrade   = $lang['FPA_READINESS_C']; // 70-94
        $fpaReadinessColor   = 'warning';
        $fpaReadinessSummary = $lang['FPA_READINESS_MSG_C'];
    } elseif ($overallScore >= 50) {
        $fpaReadinessGrade   = $lang['FPA_READINESS_D']; // 50-69
        $fpaReadinessColor   = 'warning';
        $fpaReadinessSummary = $lang['FPA_READINESS_MSG_D'];
    } elseif ($overallScore >= 25) {
        $fpaReadinessGrade   = $lang['FPA_READINESS_E']; // 25-49
        $fpaReadinessColor   = 'danger';
        $fpaReadinessSummary = $lang['FPA_READINESS_MSG_E'];
    } else {
        $fpaReadinessGrade   = $lang['FPA_READINESS_F']; // 0-24
        $fpaReadinessColor   = 'danger';
        $fpaReadinessSummary = $lang['FPA_READINESS_MSG_F'];
    }

    // Bind results back to the tracking data parameters for UI consumption
    $joomlaInstance['readinessGrade'] = $fpaReadinessGrade;
    $joomlaInstance['readinessScore'] = $overallScore;



}

/**
 * function to render ratings progress bars from the above test routines
 * TODO: need a better comment
 */
function renderProgressBar($ratingValue) {
    // Ensure the value stays between 0 and 100
    $ratingValue = max(0, min(100, (int)$ratingValue));

    // Set the threshold for switching text placement
    $threshold = 10;

    // Define Bootstrap's theme colors to match the gradient transitions accurately
    $danger  = '#dc3545'; // Red
    $warning = '#ffc107'; // Yellow
    $info    = '#0dcaf0'; // Cyan
    $success = '#198754'; // Green

    // Define the full 0-100 linear gradient map
    $gradient = "linear-gradient(to right, $danger 5%, $warning 70%, $info 80%, $success 95%)";

    if ($ratingValue < $threshold) {
        // Classes for LOW percentages (text placed outside)
        // 'me-5' ensures the text has physical space to live without clipping outside the parent card

        // add a left border when the rating is 0 (zero)
        $borderClass = ($ratingValue < 1) ? 'border-start border-danger border-2 rounded' : '';

        $parentClass = 'overflow-visible me-5 ';
        $barClass    = 'position-relative overflow-visible bg-transparent';
        $textClass   = 'position-absolute top-50 start-100 translate-middle-y ps-2 fw-bold text-dark ' . $borderClass;
    } else {
        // Classes for HIGH percentages (text placed inside at the end)
        $parentClass = '';
        $barClass    = 'text-end Xd-flex Xjustify-content-end Xalign-items-center bg-transparent';
        $textClass   = 'pe-2 fw-bold text-white';
    }

    // Output the HTML
    // 1. We put the full gradient on the '.progress' container.
    // 2. We add a linear-gradient track mask on the '.progress' to shade the UNFILLED portion grey.
    return '
    <div class="progress rounded ' . $parentClass . ' w-100" role="progressbar" aria-valuenow="' . $ratingValue . '" aria-valuemin="0" aria-valuemax="100"
         style="background: linear-gradient(to right, transparent ' . $ratingValue . '%, var(--bs-secondary-bg) ' . $ratingValue . '%), ' . $gradient . ';">
      <div class="progress-bar progress-bar-striped rounded ' . $barClass . '" style="width: ' . $ratingValue . '%">
        <span class="' . $textClass . '">' . $ratingValue . '%</span>
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
<html lang="<?php fpaLang('FPA_THISLANG'); ?>" data-bs-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
    <meta name="color-scheme" content="light dark">
    <meta name="description" content="<?php fpaLang('FPA_DESC'); ?>">

    <title><?php fpaLang('FPA_LONG'); ?></title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.13.1/font/bootstrap-icons.min.css" integrity="sha512-t7Few9xlddEmgd3oKZQahkNI4dS6l80+eGEzFQiqtyVYdvcSG2D3Iub77R20BdotfRPA9caaRkg1tyaJiPmO0g==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <style>
        :root, [data-bs-theme=light] {}
        :root, [data-bs-theme=dark] {}
        :root {
            --fpa-primary-color: #660066;
            --fpa-primary-text: #ffffff; /* accessible text contrast for fpa-primary-color backgrounds */
        }
        :target {
            scroll-margin-top: 50px;
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
        /* small devices (landscape phones) */
        @media (min-width: 576px) {
          .container {
            max-width: 560px; /* Default is 540px */
          }
        }

        /* medium devices (tablets) */
        @media (min-width: 768px) {
          .container {
            max-width: 752px; /* Default is 720px */
          }
        }

        /* large devices (desktops) */
        @media (min-width: 992px) {
          .container {
            max-width: 980px; /* Default is 960px */
          }
        }

        /* large monitors (laptops and monitors) */
        @media (min-width: 1200px) {
            .container {
                max-width: 1240px; /* desktop standard (Up from 1140px) */
            }
        }
        /* larger monitors (large monitors) */
        @media (min-width: 1400px) {
            .container {
                max-width: 1440px; /* larger laptop/desktop (Up from 1320px) */
            }
        }
    </style>

</head>
<body class="d-flex flex-column min-vh-100">

    <a class="visually-hidden-focusable position-absolute top-0 start-0 z-3 btn btn-primary m-2" href="#main">Skip to content</a>

    <header>

        <nav class="navbar navbar-expand-md navbar-dark bg-dark bg-fpa fixed-top d-flex flex-column shadow Xshadow-fpa Xpb-0 w-100" aria-label="Primary">
            <div class="container">

                <a class="navbar-brand fw-semibold d-flex align-items-center gap-2" href="<?php echo $fpaSelfUrl; ?>" aria-label="<?php fpaLang('FPA_LONG'); ?>">
                    <span class="text-white-50 fw-bold d-none d-md-block" aria-hidden="true"><i class="bi bi-chat-right-dots"></i></span>
                    <span class="d-none d-md-block"><?php fpaLang('FPA_LONG'); ?></span>
                    <span class="d-sm-block d-md-none"><?php fpaLang('FPA_SHORT'); ?>
                </a>

                <div class="navbar-nav ms-md-auto">

                    <div class="btn-toolbar Xms-md-auto" role="toolbar" aria-label="FPA tools & options toolbar groups">

                        <?php
                        /**
                         * Toolbar forms
                         * FPA navigation option & action forms for the tools & options groups toolbar
                         */
                        ?>
                        <form class="d-none" method="post" action="<?php echo $fpaSelfUrl; ?>" name="nav-pdf-form" id="nav-pdf-form">
                            <input type="hidden" name="doPDF" value="1" />
                        </form>

                        <form class="d-none" method="post" action="<?php echo $fpaSelfUrl; ?>" name="nav-delete-form" id="nav-delete-form">
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
                                        <input class="form-check-input m-0" type="checkbox" role="switch" name="privacy" id="nav-privacy-switch" <?php echo $isPrivacyChecked; ?>>
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

        echo '<pre>';
        //var_dump($activeFeeds);
        //var_dump($doLiveChecks);
        //var_dump($latestVersions);
        //var_dump($joomlaFolders);
        //var_dump($joomlaInstance);
        var_dump($exceptionQueue);
        //var_dump($fpaSecurity);
        //var_dump($fpaEnvironment);
        var_dump($elevatedFolders);
        echo '</pre>';
        // echo $configFilePath;

        //echo sys_get_temp_dir();
        //echo $isPrivacyChecked ;
        //echo $_SESSION['privacy_enabled'] ? '<span class="privacy-mask">[ ' . $lang['FPA_REDACTED'] . ' ]</span>' : $joomlaInstance['configPath'];
    ?>
    <!-- /TESTING -->


        <?php
        /**
         * Runtime Options Panel
         * This panel is controlled by the nav toolbar icon and is hidden by defaault to conserve report screen realestate,
         * especially immediately after the FPA report being run and producing the additional post content.
         *
         */
        ?>
<div id="runtimeOptionPanel" class="container p-0 my-4 collapse">
    <!-- Main Card Body Container -->
    <div class="card border-secondary shadow overflow-hidden">

        <!-- Header Panel Section -->
        <div class="card-header bg-dark text-white Xbg-text-dark border-secondary Xbg-opacity-10 Xbg-white Xp-3 Xp-md-4">
            <div class="row align-items-center">
                <div class="col-12 col-md-9">
                    <h2 class="mb-2 d-flex align-items-center gap-2 Xbg-text-white">
                        <i class="bi bi-sliders text-secondary"></i> <?php echo $lang['FPA_RUNTIMEOPTIONS']; ?>
                    </h2>
                    <p class="small mb-0">
                        Not all issues require complete information disclosure or full diagnosis routines, therefore you may choose to run preset reports, or if required, manually select which area or feature to include in the report.
                    </p>
                </div>
            </div>
        </div>
        <div class="card-body p-3 p-md-4 bg-transparent">

            <!-- 1. PRESETS SECTION -->
            <div class="mb-4">

                <h3 class="tracking-wider fs-5 mb-3 d-block">Preset Profiles</h3>

                <div class="btn-group Xbtn-group-lg d-flex d-md-inline-flex w-100 w-md-auto" role="group" aria-label="Preset Profiles">

                    <button type="button" class="btn btn-outline-secondary fw-bold flex-fill px-4 py-3 <?php echo ($_SESSION['current_preset_profile'] === 'compact') ? 'active' : ''; ?>">
                        <i class="bi bi-layers mb-0 d-block fs-1"></i>
                        <?php echo $lang['FPA_COMPACT'] ?? 'Compact'; ?>
                    </button>

                    <button type="button" class="btn btn-outline-secondary fw-bold flex-fill px-4 py-3 <?php echo ($_SESSION['current_preset_profile'] === 'default') ? 'active' : ''; ?>">
                        <i class="bi bi-layers-half mb-0 d-block fs-1"></i>
                        <?php echo $lang['FPA_DEFAULT'] ?? 'Default'; ?>
                    </button>

                    <button type="button" class="btn btn-outline-secondary fw-bold flex-fill px-4 py-3 <?php echo ($_SESSION['current_preset_profile'] === 'detailed') ? 'active' : ''; ?>">
                        <i class="bi bi-layers-fill mb-0 d-block fs-1"></i>
                        <?php echo $lang['FPA_DETAILED'] ?? 'Detailed'; ?>
                    </button>

                </div>

            </div>

            <!-- 2. Custom PROFILE MODIFIERS SECTION -->
            <div class="mt-4">
                <div class="d-flex align-items-center mb-3">

                    <h3 class="tracking-wider fs-5 m-0">Profile Modifiers</h3>
                    <span id="custom-badge" class="badge bg-warning text-dark ms-2 d-none">Customised</span>

                </div>

                <!-- Structured Option Switch Column Rows -->
                <div class="row row-cols-1 row-cols-md-3 g-4 Xg-3">

                    <div class="col Xcol-12 Xcol-md-4">

                        <div class="card Xp-3 bg-text-dark Xbg-opacity-5 Xrounded Xborder border-secondary border-opacity-50 h-100">
                            <div class="card-body">

                                <div class="form-check form-switch mb-2">
                                    <input class="form-check-input" type="checkbox" form="runtime-profile" role="switch" id="switch-show-components" checked>
                                    <label class="form-check-label" for="switch-show-components">Show Components</label>
                                </div>

                                <div class="form-check form-switch mb-2">
                                    <input class="form-check-input" type="checkbox" form="runtime-profile" name="show_modules" value="true" role="switch" id="switch-show-modules" checked>
                                    <label class="form-check-label" for="switch-show-modules">Show Modules</label>
                                </div>

                                <div class="form-check form-switch mb-2">
                                    <input class="form-check-input" type="checkbox" form="runtime-profile" name="show_plugins" value="true" role="switch" id="switch-show-plugins" checked>
                                    <label class="form-check-label" for="switch-show-plugins">Show Plugins</label>
                                </div>

                                <div class="form-check form-switch mb-2">
                                    <input class="form-check-input" type="checkbox" form="runtime-profile" name="show_libraries" value="true" role="switch" id="switch-libraries">
                                    <label class="form-check-label" for="switch-libraries">Show Libraries</label>
                                </div>

                                <div class="form-check form-switch mb-2">
                                    <input class="form-check-input" type="checkbox" form="runtime-profile" name="show_languages" value="true" role="switch" id="switch-show-languages">
                                    <label class="form-check-label" for="switch-show-languages">Show Languages</label>
                                </div>

                                <div class="form-check form-switch mb-2">
                                    <input class="form-check-input" type="checkbox" form="runtime-profile" name="show_templates" value="true" role="switch" id="switch-show-templates" checked>
                                    <label class="form-check-label" for="switch-show-templates">Show Templates</label>
                                </div>

                                <div class="form-check form-switch mb-2">
                                    <input class="form-check-input" type="checkbox" form="runtime-profile" name="show_database" value="true" role="switch" id="switch-show-database" checked>
                                    <label class="form-check-label" for="switch-show-database">Show Database</label>
                                </div>

                            </div>
                        </div>

                    </div><!-- /column1 -->
                    <div class="col Xcol-12 Xcol-md-4">

                        <div class="card Xp-3 bg-text-dark Xbg-opacity-5 Xrounded Xborder border-secondary border-opacity-50 h-100">
                            <div class="card-body">

                                <div class="form-check form-switch mb-2">
                                    <input class="form-check-input" type="checkbox" form="runtime-profile" name="show_extended_host" value="true" role="switch" id="switch-extended-host">
                                    <label class="form-check-label" for="switch-extended-host">Extended Host</label>
                                </div>

                                <div class="form-check form-switch mb-2">
                                    <input class="form-check-input" type="checkbox" form="runtime-profile" name="show_extended_php" value="true" role="switch" id="switch-extended-php">
                                    <label class="form-check-label" for="switch-extended-php">Extended PHP</label>
                                </div>

                                <div class="form-check form-switch mb-2">
                                    <input class="form-check-input" type="checkbox" form="runtime-profile" name="show_extended_applications" value="true" role="switch" id="switch-extend-applications">
                                    <label class="form-check-label" for="switch-extended-applications">Extended Applications</label>
                                </div>

                                <div class="form-check form-switch mb-2">
                                    <input class="form-check-input" type="checkbox" form="runtime-profile" name="show_extended_database" value="true" role="switch" id="switch-extended-database">
                                    <label class="form-check-label" for="switch-extended-database">Extended DataBase</label>
                                </div>

                                <div class="form-check form-switch mb-2">
                                    <input class="form-check-input" type="checkbox" form="runtime-profile" name="show_extended_permissions" value="true" role="switch" id="switch-extended-permissions">
                                    <label class="form-check-label" for="switch-extended-permisisons">Extended Permissions</label>
                                </div>

                            </div>
                            <div class="card-footer bg-transparent border-top-0 Xpx-1 Xpy-3">

                                <div class="form-check form-switch Xmb-3">
                                    <input class="form-check-input" type="checkbox" form="runtime-profile" name="show_core_extensions" value="true" role="switch" id="switch-show-core-extensions">
                                    <label class="form-check-label" for="switch-show-core-extensions">Show Core Extensions</label>
                                </div>

                            </div>
                        </div>

                    </div><!-- /column2 -->
                    <div class="col Xcol-12 Xcol-md-4">

                        <div class="card Xp-3 bg-text-dark Xbg-opacity-5 Xrounded Xborder border-secondary border-opacity-50 h-100">
                            <div class="card-body">

                                <div class="form-check form-switch mb-2">
                                    <input class="form-check-input" type="checkbox" form="runtime-profile" name="include_content_stats" value="true" role="switch" id="switch-include-content-stats">
                                    <label class="form-check-label" for="switch-include-content-stats">Include Content Stats</label>
                                </div>

                                <div class="form-check form-switch mb-2">
                                    <input class="form-check-input" type="checkbox" form="runtime-profile" name="include_perf_stats" value="true" role="switch" id="switch-include-performance">
                                    <label class="form-check-label" for="switch-include-performance">Include Performance Stats</label>
                                </div>

                                <div class="form-check form-switch mb-2">
                                    <input class="form-check-input" type="checkbox" form="runtime-profile" name="include_security_review" value="true" role="switch" id="switch-include-security-review">
                                    <label class="form-check-label" for="switch-include-security-review">Include Security Review</label>
                                </div>

                                <div class="form-check form-switch mb-2">
                                    <input class="form-check-input" type="checkbox" form="runtime-profile" name="include_graphics" value="true" role="switch" id="switch-show-graphics">
                                    <label class="form-check-label" for="switch-show-graphics">Show Graphics</label>
                                </div>

                            </div>
                            <div class="card-footer bg-transparent border-top-0 Xpx-1 Xpy-3">

                                <p class="small fw-bold Xmt-3 mb-0">White screen or memory errors?</p>
                                <div class="form-check form-switch Xmb-3">
                                    <input class="form-check-input" type="checkbox" form="runtime-profile" name="increase_runtime" value="true" role="switch" id="switch-increase-runtime">
                                    <label class="form-check-label" for="switch-eruntime">Increase Runtime</label>
                                </div>

                            </div>
                        </div>

                    </div><!-- /column3 -->
                </div><!-- /row -->
            </div>

            <div class="d-flex justify-content-center justify-content-md-end mt-4">
                <div class="btn-group">

                    <button type="submit" form="runtime-profile" name="action" value="fpa" class="btn btn-outline-primary Xflex-fill">
                        <i class="bi bi-pc-display-horizontal mb-0 Xd-block fs-3"></i>
                        <?php echo $lang['FPA_SHORT'] ?? 'FPA'; ?>
                    </button>

                    <button type="submit" form="runtime-profile" name="action" value="post" class="btn btn-outline-primary Xflex-fill">
                        <i class="bi bi-file-post mb-0 Xd-block fs-4"></i>
                        <?php echo $lang['FPA_POST'] ?? 'Post'; ?>
                    </button>

                    <button type="submit" form="runtime-profile" name="action" value="text" class="btn btn-outline-primary Xflex-fill">
                        <i class="bi bi-filetype-txt mb-0 Xd-block fs-3"></i>
                        <?php echo $lang['FPA_TEXT'] ?? 'Text'; ?>
                    </button>

                </div>
            </div>

        </div><!-- /card-body -->
    </div><!-- /card -->
</div><!--/container runtimeOptionPanel-->



<!-- TESTING -->




        <?php
        /**
         * Key Metrics Panel
         * This panel provides a quick snapshot of key or important elements that will effect all installations, allowing
         * an instant determination that minimum core requirements are met and offering a confidence level in the basic host,
         * environment and instance configutation.
         *
         */
        ?>

<div class="container-fluid bg-secondary bg-opacity-10 pt-3 pb-5 border-bottom">

    <?php
    // include if GRAPHICAL METRICS
    // TODO: change the bar colours though
    // Sample Rating value (Replace with your database rating variable)
    $ratingValue = $joomlaInstance['readinessScore'];

    // Mathematical scale transform calculation: Maps 0-100 straight to 45-225 degrees
    $degreesRotation = 45 + ($ratingValue * 1.8);
    ?>

    <div class="container my-4 pt-0" id="keyMetricsPanel">

        <h2 class="Xfs-3 Xbg-secondary border-bottom border-secondary p-2 Xmb-4 Xfw-light" style="X--bs-bg-opacity: .08;" XXclass="h3 border-bottom fw-light">
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
                        <?php echo htmlspecialchars($fpaReadinessSummary); ?>
                    </p>
                </div>

            </div>

            <!-- CARDS CONTAINER COLUMN -->
            <!-- Full width below MD (col-12) | 50% width on MD | 75% width on LG+ (col-lg-9) -->
            <div class="col-12 col-sm-12 Xcol-md-7 col-lg-9">
                <!-- Inner Grid: 1 column on XS | 2 columns on SM and MD | 4 columns straight across on LG -->
                <div class="row row-cols-2 Xrow-cols-sm-2 row-cols-lg-4 g-3 h-100">

                    <!-- CARD 1 -->
                    <div class="col-">
                        <div class="card h-100 shadow-sm text-center border-<?php echo $fpaReadinessColor; ?> Xbg-<?php echo $fpaReadinessColor; ?>-subtle" style="border-left-width: 10px;">
                            <div class="card-body p-3 d-flex flex-column justify-content-between">

                                <div class="d-flex justify-content-center align-items-baseline Xmt-2">

                                    <!--  if not using graphical UI setting
                                    <span class="text-<?php echo $fpaReadinessColor; ?> fw-semibold" style="font-size: 4em; Xfont-weight: 700; line-height: 1;"><?php echo $joomlaInstance['readinessGrade']; ?></span>
                                    -->

                                    <!-- TODO : if GraphicalUI option selected -->
                                    <div class="d-flex flex-column align-items-center">
                                        <!-- The Semi-Circle Gauge -->
                                        <div class="gauge-wrapper mb-1">
                                            <div class="gauge-body border-<?php echo $fpaReadinessColor; ?>"></div>
                                            <div class="gauge-fill" style="transform: rotate(<?php echo $degreesRotation; ?>deg);"></div>
                                        </div>

                                        <!-- Centred Rating Value Label Display -->
                                        <div class="text-center Xmt-2 position-absolute" style="top: 35%;">
                                            <span class="fs-3 fw-bold tracking-tight"><?php echo $ratingValue; ?>%</span>
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
                        <div class="card h-100 shadow-sm border-warning bg-warning-subtle" style="border-left-width: 10px;">
                            <div class="card-body p-3 d-flex flex-column justify-content-between">

                                <div class="d-flex align-items-baseline mt-2">
                                    <span class="fs-3 fw-bold tracking-tight"><?php echo $fpaEnvironment['score']; ?>%</span>
                                    <span class="badge bg-success-subtle text-success ms-2 font-monospace" style="font-size: 0.7rem;">Stable</span>
                                </div>
                                <small class="fw-semibold text-uppercase d-block" style="font-size: 0.7rem;"><?php echo $fpaEnvironment['meta']['name']; ?></small>
                                <?php echo renderProgressBar($fpaEnvironment['score']); ?>
                            </div>
                        </div>
                    </div>

                    <!-- CARD 3 -->
                    <div class="col">
                        <div class="card h-100 shadow-sm border-warning bg-warning-subtle" style="border-left-width: 10px;">
                            <div class="card-body p-3 d-flex flex-column justify-content-between">

                                <div class="d-flex align-items-baseline mt-2">
                                    <span class="fs-3 fw-bold tracking-tight"><?php echo $fpaPerformance['score']; ?>%</span>
                                    <span class="badge bg-danger-subtle text-danger ms-2 font-monospace" style="font-size: 0.7rem;">+14%</span>
                                </div>
                                <small class="fw-semibold text-uppercase d-block" style="font-size: 0.7rem;">Tuning & Optimisation<?php //echo $fpaPerformance['meta']['name']; ?></small>
                                <?php echo renderProgressBar($fpaPerformance['score']); ?>
                            </div>
                        </div>
                    </div>

                    <!-- CARD 4 -->
                    <div class="col">
                        <div class="card h-100 shadow-sm border-info bg-info-subtle" style="border-left-width: 10px;">
                            <div class="card-body p-3 d-flex flex-column justify-content-between">

                                <div class="d-flex align-items-baseline mt-2">
                                    <span class="fs-3 fw-bold tracking-tight"><?php echo $fpaSecurity['score']; ?>%</span>
                                    <span class="badge bg-success-subtle text-success ms-2 font-monospace" style="font-size: 0.7rem;">+2%</span>
                                </div>
                                <small class="fw-semibold text-uppercase d-block" style="font-size: 0.7rem;"><?php echo $fpaSecurity['meta']['name']; ?></small>
                                <?php echo renderProgressBar($fpaSecurity['score']); ?>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>

</div><!--/container-fluid-->

<!-- TESTING -->










        <!--
        <div id="runtimeOptionPanel" class="container p-2 p-md-3 my-3 collapse">

            <div class="row align-items-end">

                <div class="col-12 col-md-9 me-auto">

                    <h2 class="border-bottom">
                        <i class="bi bi-sliders text-secondary"></i> <?php echo $lang['FPA_RUNTIMEOPTIONS']; ?>
                    </h2>
                    <p>
                        Not all issues require complete information disclosure or full diagnosis routines, therefore you may choose to run preset reports, or if required, manually select which area or feature to include in the report.
                    </p>

                </div>
                <div class="col-12">

                    -- PRESETS --
                    <div>
                        <h5 class="m-0 me-2">1. Preset Configurations</h5>
                    </div>

                    -- Manual Configuration Form Group --
                    <div class="d-flex align-items-center mb-2">
                        <h5 class="m-0 me-2">2. Manual Modifiers</h5>
                    </div>

                </div>-- /col--
            </div>

        </div>--/container runtimeOptionPanel-->



        <?php
        /**
         * Key Metrics Panel
         * This panel provides a quick snapshot of key or important elements that will effect all installations, allowing
         * an instant determination that minimum core requirements are met and offering a confidence level in the basic host,
         * environment and instance configutation.
         *
         */
        ?>
        <?php
        // include if GRAPHICAL METRICS
        // TODO: change the bar colours though
        // Sample Rating value (Replace with your database rating variable)
        $ratingValue = $joomlaInstance['readinessScore'];

        // Mathematical scale transform calculation: Maps 0-100 straight to 45-225 degrees
        $degreesRotation = 45 + ($ratingValue * 1.8);
        ?>
<!--
        <div id="keyMetricsPanelOLD" class="container p-2 p-md-3 my-3">
            <div class="row gx-5">
                <div class="col-12">

                    <h2 class="border-bottom">
                        <i class="bi bi-speedometer text-secondary"></i> <?php fpaLang('FPA_KEYMETRICS'); ?>
                    </h2>
                    <p>
                        Not all issues require complete information disclosure or full diagnosis routines, therefore you may choose to run preset reports, or if required, manually select which area or feature to include in the report.
                    </p>

                </div>

                -- TESTING --
                </div>
                <div class="row">

                    <div class="col-12 col-sm-6 col-lg-3 mb-4">

                        <div class="card border-warning text-center w-100 h-100" style="border-left-width: 10px;">
                            <div class="card-body Xd-flex Xflex-column">
                                <h5 class="card-title fw-bold">Confidence</h5>
                                <span class="text-<?php echo $fpaReadinessColor; ?>" style="font-size: 9em; font-weight: 700; line-height: 1;"><?php echo $joomlaInstance['readinessGrade']; ?></span>
                            </div>
                        </div>

                    </div>-- /confidence --

                    <div class="col-12 col-sm-6 col-lg-3 mb-4">

                        <div class="card border-warning bg-warning-subtle w-100 h-100 mb-3" style="border-left-width: 10px;">
                            <div class="card-body d-flex flex-column">
                            <h5 class="card-title fw-bold"><?php echo $fpaEnvironment['meta']['name']; ?></h5>
                                <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card’s content.</p>
                                <div class="mt-auto">
                                    <?php echo renderProgressBar($fpaEnvironment['score']); ?>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="col-12 col-sm-6 col-lg-3 mb-4">

                        <div class="card border-success bg-success-subtle w-100 h-100 mb-3" style="border-left-width: 10px;">
                            <div class="card-body d-flex flex-column">
                            <h5 class="card-title fw-bold"><?php echo $fpaSecurity['meta']['name']; ?></h5>
                                <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card’s content.</p>
                                <div class="mt-auto">
                                    <?php echo renderProgressBar($fpaSecurity['score']); ?>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="col-12 col-sm-6 col-lg-3 mb-4">

                        <div class="card border-danger bg-danger-subtle w-100 h-100 mb-3" style="border-left-width: 10px;">
                            <div class="card-body d-flex flex-column">
                            <h5 class="card-title fw-bold"><?php echo $fpaPerformance['meta']['name']; ?></h5>
                                <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card’s content.</p>
                                <div class="mt-auto">
                                    <?php echo renderProgressBar($fpaPerformance['score']); ?>
                                </div>
                            </div>
                        </div>

                    </div>

                </div>
                <div class="row">
                -- TESTING --

                <div class="col-12 col-lg-4 p-3 border border-3 rounded">

                    <div id="confidenceCard" class="card border Xborder-3 w-100 Xh-100 mb-3">
                        <div class="card-header text-center Xborder-3">
                            <h3 class="fw-bold fs-4">Confidence</h3>
                        </div>
                        <div class="card-body p-0 pt-2">

                            <ul class="nav nav-tabs nav-justified" id="myTab" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link active" id="rating-tab" data-bs-toggle="tab" data-bs-target="#rating-tab-pane" type="button" role="tab" aria-controls="rating-tab-pane" aria-selected="true">Rating</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="rating-detail-tab" data-bs-toggle="tab" data-bs-target="#rating-detail-tab-pane" type="button" role="tab" aria-controls="rating-detail-tab-pane" aria-selected="false">Criteria</button>
                                </li>
                            </ul>
                            <div class="tab-content overflow-y-auto" style="height: 220px;" id="myTabContent">
                                <div class="tab-pane text-center fade show active" id="rating-tab-pane" role="tabpanel" aria-labelledby="rating-tab" tabindex="0">

                                    <span class="text-<?php echo $fpaReadinessColor; ?>" style="font-size: 9em; font-weight: 700;"><?php echo $joomlaInstance['readinessGrade']; ?></span>

                                    -- TESTING --



<div class="d-flex flex-column align-items-center my-3">
    -- The Semi-Circle Gauge --
    <div class="gauge-wrapper">
        <div class="gauge-body"></div>
        <div class="gauge-fill" style="transform: rotate(<?php echo $degreesRotation; ?>deg);"></div>
    </div>

    -- Centred Rating Value Label Display --
    <div class="text-center mt-2">
        <span class="fs-4 fw-bold text-primary"><?php echo $ratingValue; ?></span>
        <span class="small text-secondary d-block">Overall Score</span>
    </div>
</div>

                                    -- TESTING --

                                </div>
                                <div id="rating-detail-tab-pane" class="tab-pane fade" role="tabpanel" aria-labelledby="rating-detail-tab" tabindex="0">

                                    <ul class="list-group list-group-flush">
                                        <li class="list-group-item">An item</li>
                                        <li class="list-group-item">A second item</li>
                                        <li class="list-group-item">A third item</li>
                                        <li class="list-group-item">An item</li>
                                        <li class="list-group-item">A second item</li>
                                        <li class="list-group-item">A third item</li>
                                    </ul>

                                </div>
                            </div>

                        </div>
                        <div class="card-footer Xborder-3">

                            <p class="text-center lead mb-1"><?php echo $fpaReadinessMessge; ?></p>
                            <div class="">
                                <?php echo renderProgressBar($joomlaInstance['readinessScore']); ?>
                            </div>


                        </div>
                    </div>--/readinessCard--


                    <?php
                    /**
                     * --- Render Rating Progress Bars ---
                     *
                     */
                    ?>
                    <div id="environmentRating" class="mb-3 border border-3 rounded p-3 pb-2">
                        <h3 class="small text-center"><?php echo $fpaEnvironment['meta']['name']; ?></h3>
                        <?php echo renderProgressBar($fpaEnvironment['score']); ?>
                    </div>-- /environmentRating --

                    <div id="securityRating" class="mb-3 border border-3 rounded p-3 pb-2">
                        <h3 class="small text-center"><?php echo $fpaSecurity['meta']['name']; ?></h3>
                        <?php echo renderProgressBar($fpaSecurity['score']); ?>
                    </div>--/ securityRating --

                    <div id="performanceRating" class="mb-3 border border-3 rounded p-3 pb-2">
                        <h3 class="small text-center"><?php echo $fpaPerformance['meta']['name']; ?></h3>
                        <?php echo renderProgressBar($fpaPerformance['score']); ?>
                    </div>--/ performanceRating --


                </div>
                <div class="col-12 col-lg-8 mb-3">

                    <div class="row row-cols-1 row-cols-md-2 g-4">

                            -- TESTING --
                        <div class="col-md-4">

                            <div class="card border-warning bg-warning-subtle w-100 h-100 mb-3" style="border-left-width: 10px;">
                                <div class="card-body d-flex flex-column">
                                <h5 class="card-title fw-bold"><?php echo $fpaEnvironment['meta']['name']; ?></h5>
                                    <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card’s content.</p>
                                    <div class="mt-auto">
                                        <?php echo renderProgressBar($fpaPerformance['score']); ?>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <div class="col-md-4">

                            <div class="card border-success bg-success-subtle w-100 h-100 mb-3" style="border-left-width: 10px;">
                                <div class="card-body d-flex flex-column">
                                <h5 class="card-title fw-bold"><?php echo $fpaSecurity['meta']['name']; ?></h5>
                                    <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card’s content.</p>
                                    <div class="mt-auto">
                                        <?php echo renderProgressBar($fpaSecurity['score']); ?>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <div class="col-md-4">

                            <div class="card border-danger bg-danger-subtle w-100 h-100 mb-3" style="border-left-width: 10px;">
                                <div class="card-body d-flex flex-column">
                                <h5 class="card-title fw-bold"><?php echo $fpaPerformance['meta']['name']; ?></h5>
                                    <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card’s content.</p>
                                    <div class="mt-auto">
                                        <?php echo renderProgressBar($fpaPerformance['score']); ?>
                                    </div>
                                </div>
                            </div>

                        </div>
                            -- TESTING --

                        <div class="col">

                            <div class="card border w-100 h-100 mb-3">
                                <div class="card-header fw-bold"><?php fpaLang('FPA_HOST'); ?></div>
                                <div class="card-body">
                                    <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card’s content.</p>
                                </div>
                            </div>

                        </div>
                        <div class="col">

                            <div class="card border w-100 h-100 mb-3">
                                <div class="card-header fw-bold">PHP</div>
                                <div class="card-body">
                                    <p class="card-text">Some quick example text to build on the card.</p>
                                </div>
                            </div>

                        </div>
                        <div class="col">

                            <div class="card border w-100 h-100 mb-3">
                                <div class="card-header fw-bold">dataBase</div>
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item">An item</li>
                                    <li class="list-group-item">A second item</li>
                                    <li class="list-group-item">A third item</li>
                                </ul>
                            </div>

                        </div>
                        <div class="col">

                            <div class="card border w-100 h-100 mb-3">
                                <div class="card-header fw-bold">Web Server</div>
                                <div class="card-body">
                                    <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card’s content.</p>
                                </div>
                            </div>

                        </div>
                        <div class="col">

                            <div class="card border w-100 h-100 mb-3">
                                <div class="card-header fw-bold">Joomla!</div>
                                <div class="card-body">
                                    <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card’s content.</p>
                                </div>
                            </div>

                        </div>
                        <div class="col">

                            <div class="card border w-100 h-100 mb-3">
                                <div class="card-header">Header</div>
                                <div class="card-body">
                                    <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card’s content.</p>
                                </div>
                            </div>

                        </div>
                    </div>--/row--

                </div>
            </div>--/row--
        </div>-- /container keyMetricsPanelOLD -->




        <?php
        /**
         * Environment Snapshot Panel
         * This panel provides a quick snapshot of the host, application and Joomla! environment elements and configuration
         * that may effect the Joomla! instance features or functions.
         */
        ?>
        <div id="envSnapshotPanel" class="container py-4 py-md-5">
            <h2><i class="bi bi-box-fill text-secondary"></i> Environment Snapshot</h2>
        </div>




        <?php
        /**
         * Discovery Panel
         * This panel provides a more detailed view the Joomla! environment elements and configuration
         */
        ?>
        <div class="container py-4 py-md-5">
            <h2><i class="bi bi-pc-display text-secondary"></i> Discovery Report</h2>
        </div>







<div class="container pt-5 mb-3" id="permissionsPanel">

    <h2 class="Xfs-3 Xbg-secondary border-bottom border-secondary p-2 Xmb-4 Xfw-light" style="X--bs-bg-opacity: .08;" XXclass="h3 border-bottom fw-light">
        <i class="bi bi-shield-lock-fill text-secondary"></i> <?php echo htmlspecialchars($lang['FPA_HEADING_PERMISSIONS']); ?>
    </h2>

    <!-- Combined flex row on MD+, standard stacked row on SM and below -->
    <div id="standardPermissions" class="row g-4 d-md-flex align-items-md-stretch mt-2">

        <!-- TEXT COLUMN -->
        <!-- Full width below MD (col-12) | Takes up remaining space next to cards on LG+ (col-lg) -->
        <div class="col-12 col-sm-12 Xcol-md-5 col-lg d-flex flex-column Xjustify-content-center">

            <div class="pe-xl-3 mb-2 mb-md-0">
                <h3 class="fs-5 fw-light Xtext-secondary text-uppercase tracking-wider mb-2">
                    <span class="fw-bold"><?php echo htmlspecialchars($joomlaFolders['meta']['name']); ?></span> <?php echo htmlspecialchars($lang['FPA_SUMMARY']); ?>
                </h3>
                <p class="text-secondary Xsmall Xmb-0">
                    <?php echo $fpaReadinessSummary; ?>
                </p>
            </div>

        </div>

        <!-- CARDS CONTAINER COLUMN -->
        <!-- Full width below MD (col-12) | 50% width on MD | 75% width on LG+ (col-lg-9) -->
        <div class="col-12 col-sm-12 Xcol-md-7 col-lg-9">

            <div class="d-flex flex-wrap">
                <span class="badge bg-body-tertiary text-secondary border fw-medium font-monospace ms-auto mb-2" style="font-size: 0.72rem;">
                    PHP User: <strong class="Xtext-dark"><?php echo htmlspecialchars($fpaSecurity['phpProcessUser']); ?></strong>
                    &nbsp;|&nbsp;System umask: <strong class="Xtext-dark"><?php echo htmlspecialchars($fpaEnvironment['umask']); ?></strong>
                </span>
            </div>

            <div class="table-responsive">

                <table class="table table-hover align-middle table-striped table-bordered mb-0" style="Xfont-size: 0.9rem;">
                    <thead class="Xtable-light table-dark text-uppercase tracking-wider" style="font-size: 0.8rem; font-weight: 700;">
                        <tr>
                            <th scope="col" class="ps-3">Path</th>
                            <th scope="col" class="d-none d-md-table-cell text-end">Owner</th>
                            <th scope="col" class="d-none d-md-table-cell">Group</th>
                            <th scope="col" class="text-center" style="width: 68px;">Mode</th>
                            <th scope="col" class="text-center Xpe-3" style="width: 100px;">Writable</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($joomlaFolders['targets'] as $path => $permsInfo): ?>
                            <tr>
                                <td class="ps-3 Xfont-monospace Xfw-semibold Xtext-secondary text-break" style="Xfont-size: 0.82rem;">
                                    <?php echo htmlspecialchars($path); ?>
                                </td>


                                <td class="d-none d-md-table-cell text-muted text-end">
                                    <?php if (@!$permsInfo['owner_match'] && $permsInfo['exists']): ?>
                                        <i class="bi bi-exclamation-diamond-fill text-info me-1" style="font-size: 0.85rem;" data-bs-toggle="tooltip" data-bs-placement="left" data-bs-title="Ownership Mismatch: This directory is owned by a different user than the account executing PHP code."></i>
                                    <?php endif; ?>
                                    <span class="<?php echo !$permsInfo['owner_match'] ? 'text-secondary fw-medium' : ''; ?>">
                                        <?php echo htmlspecialchars($permsInfo['owner']); ?>
                                    </span>
                                </td>

                                <td class="d-none d-md-table-cell text-muted">
                                    <?php echo htmlspecialchars($permsInfo['group']); ?>
                                </td>

                                <!--
                                <td class="text-center">
                                    <?php if (!$permsInfo['exists']): ?>
                                        <span class="badge bg-secondary-subtle text-secondary fw-bold px-2.5 py-1.5 text-uppercase" style="font-size: 0.72rem;">Missing</span>
                                    <?php elseif (!$permsInfo['sane']): ?>
                                        <span class="badge bg-danger fw-black px-2.5 py-1.5 shadow-sm" style="font-size: 0.72rem;" title="Dangerous Mode Detected!">
                                            <i class="bi bi-exclamation-triangle-fill me-1"></i><?php echo $permsInfo['perms']; ?>
                                        </span>
                                    <?php else: ?>
                                        <span class="badge bg-light text-dark border fw-bold px-2.5 py-1.5" style="font-size: 0.72rem;">
                                            <?php echo $permsInfo['perms']; ?>
                                        </span>
                                    <?php endif; ?>
                                </td>
                                -->

                                <!-- Permissions Column with Conditional Tier Warning Badges -->
                                <td class="text-center">
                                    <?php if (!$permsInfo['exists']): ?>
                                        <span class="badge bg-secondary-subtle text-secondary fw-bold px-2.5 py-1.5 text-uppercase w-100" style="font-size: 0.72rem;">
                                            Missing
                                        </span>
                                    <?php elseif (!$permsInfo['sane']): ?>
                                        <!-- CRITICAL DANGER BADGE (World Writable / 777) -->
                                        <span class="badge bg-danger fw-black px-2.5 py-1.5 shadow-sm text-white w-100" style="font-size: 0.72rem;" data-bs-toggle="tooltip" data-bs-placement="left" data-bs-title="Critical: World-writable or insecure mode detected!">
                                            <i class="bi bi-shield-slash-fill me-1"></i><?php echo $permsInfo['perms']; ?>
                                        </span>


                                        <!-- TESTING issues -->
                                        <?php
                                        $exceptionQueue[] = [
                                            'category'    => 'Permissions',
                                            'type'        => 'danger', // Bootstrap color code
                                            'text'        => 'At least one folder has world writable permissions.',
                                            'solution'    => 'Reset permissions to to the system default (usually 755).',
                                            'target_id'   => 'standardPermissions' // Matches the ID of the checkbox in your offcanvas layout!
                                        ];
                                        ?>
                                        <!-- TESTING issues -->

                                    <?php elseif (isset($permsInfo['warning']) && $permsInfo['warning']): ?>
                                        <!-- SECURITY WARNING BADGE (Group Writable / Loose Permissions) -->
                                        <span class="badge bg-warning text-dark border border-warning-subtle fw-bold px-2.5 py-1.5 shadow-sm w-100" style="font-size: 0.72rem;" data-bs-toggle="tooltip" data-bs-placement="left" data-bs-title="Warning: Loose group or owner permissions detected.">
                                            <i class="bi bi-exclamation-triangle-fill me-1"></i><?php echo $permsInfo['perms']; ?>
                                        </span>

                                        <!-- TESTING issues -->
                                        <?php
                                        $exceptionQueue[] = [
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
                                            <?php echo $permsInfo['perms']; ?>
                                        </span>
                                    <?php endif; ?>
                                </td>

                                <td class="text-center Xtext-end Xpe-3">
                                    <?php if (!$permsInfo['exists']): ?>
                                        <i class="bi bi-dash-circle-dotted text-secondary" style="font-size: 1.04rem;"></i>
                                    <?php elseif ($permsInfo['writable']): ?>

                                        <?php
                                            // warn about being writable if perms aren't sane, else success
                                            if (!$permsInfo['sane'] || (isset($permsInfo['warning']) && $permsInfo['warning'])) {
                                                $writableColor = "warning";
                                            } else {
                                                $writableColor = "success";
                                            }
                                        ?>
                                        <!--<i class="bi bi-check-square-fill text-<?php echo $writableColor; ?> fs-5"></i>-->
                                        <span class="badge bg-<?php echo $writableColor; ?>-subtle text-<?php echo $writableColor; ?> border border-<?php echo $writableColor; ?>-subtle fw-semibold px-2 py-1 text-uppercase Xw-100" style="font-size: 0.68rem; letter-spacing: 0.3px; width: 66px;"><?php echo $lang['FPA_YES']; ?></span>
                                    <?php else: ?>
                                        <!--<i class="bi bi-x-square-fill text-danger fs-5"></i>-->
                                        <span class="badge bg-danger-subtle text-danger border border-danger-subtle fw-semibold px-2 py-1 text-uppercase Xw-100" style="font-size: 0.68rem; letter-spacing: 0.3px; width: 66px;"><?php echo $lang['FPA_NO']; ?></span>

                                        <!-- TESTING issues -->
                                        <?php
                                        $exceptionQueue[] = [
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

    </div>

    <!-- Combined flex row on MD+, standard stacked row on SM and below -->
    <div id="elevatedPermissions" class="row g-4 d-md-flex align-items-md-stretch mt-2">

        <!-- TEXT COLUMN -->
        <!-- Full width below MD (col-12) | Takes up remaining space next to cards on LG+ (col-lg) -->
        <div class="col-12 col-sm-12 Xcol-md-5 col-lg d-flex flex-column Xjustify-content-center">

            <div class="pe-xl-3 mb-2 mb-md-0">
                <h3 class="fs-5 fw-light Xtext-secondary text-uppercase tracking-wider mb-2">
                    <span class="fw-bold"><?php echo htmlspecialchars($joomlaFolders['meta']['name']); ?></span> <?php echo htmlspecialchars($lang['FPA_SUMMARY']); ?>
                </h3>
                <p class="text-secondary Xsmall Xmb-0">
                    <?php echo $fpaReadinessSummary; ?>
                </p>
            </div>

        </div>

        <!-- CARDS CONTAINER COLUMN -->
        <!-- Full width below MD (col-12) | 50% width on MD | 75% width on LG+ (col-lg-9) -->
        <div class="col-12 col-sm-12 Xcol-md-7 col-lg-9">

            <div class="d-flex flex-wrap">
                <span class="badge bg-body-tertiary text-secondary border fw-medium font-monospace ms-auto mb-2" style="font-size: 0.72rem;">
                    PHP User: <strong class="Xtext-dark"><?php echo htmlspecialchars($fpaSecurity['phpProcessUser']); ?></strong>
                    &nbsp;|&nbsp;System umask: <strong class="Xtext-dark"><?php echo htmlspecialchars($fpaEnvironment['umask']); ?></strong>
                </span>
            </div>

            <div class="table-responsive">

                <table class="table table-hover align-middle table-striped table-bordered mb-0" style="Xfont-size: 0.9rem;">
                    <thead class="Xtable-light table-dark text-uppercase tracking-wider" style="font-size: 0.8rem; font-weight: 700;">
                        <tr>
                            <th scope="col" class="ps-3" rowspan="2">Path</th>
                            <th scope="col" class="text-center Xps-3" colspan="3">Special Permissions</th>
                            <th scope="col" class="text-center" style="width: 84px;" rowspan="2">Mode</th>
                            <th scope="col" class="text-center" style="width: 68px;" rowspan="2">Owner Mismatch</th>
                            <th scope="col" class="text-center Xpe-3" colspan="2">Writable</th>
                        </tr>
                        <tr>
                            <th class="text-center small" style="width: 84px;">SUID</th>
                            <th class="text-center small" style="width: 84px;">GUID</th>
                            <th class="text-center small" style="width: 84px;">Sticky</th>
                            <th class="text-center small" style="width: 84px;">Group</th>
                            <th class="text-center small" style="width: 84px;">World</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($elevatedFolders as $epermsInfo): ?>
                            <tr>
                                <td class="ps-3 Xfont-monospace Xfw-semibold Xtext-secondary text-break" style="Xfont-size: 0.82rem;">
                                    <?php echo htmlspecialchars($epermsInfo['path']); ?>
                                </td>

                                <td class="text-center">
                                    <?php
                                    if ($epermsInfo['has_suid']) {
                                        $badgeColor = 'danger';
                                        $badgeText  = $lang['FPA_YES'];
                                    } else {
                                        $badgeColor = 'success';
                                        $badgeText  = $lang['FPA_NO'];
                                    }
                                    ?>
                                    <span class="badge bg-<? echo $badgeColor; ?>-subtle text-<? echo $badgeColor; ?> border border-<? echo $badgeColor; ?> fw-semibold px-2 py-1 text-uppercase Xw-100" style="font-size: 0.68rem; letter-spacing: 0.3px; width: 66px;"><? echo $badgeText; ?></span>
                                </td>
                                <td class="text-center">
                                    <?php
                                    if ($epermsInfo['has_sgid']) {
                                        $badgeColor = 'danger';
                                        $badgeText  = $lang['FPA_YES'];
                                    } else {
                                        $badgeColor = 'success';
                                        $badgeText  = $lang['FPA_NO'];
                                    }
                                    ?>
                                    <span class="badge bg-<? echo $badgeColor; ?>-subtle text-<? echo $badgeColor; ?> border border-<? echo $badgeColor; ?> fw-semibold px-2 py-1 text-uppercase Xw-100" style="font-size: 0.68rem; letter-spacing: 0.3px; width: 66px;"><? echo $badgeText; ?></span>
                                </td>
                                <td class="text-center">
                                    <?php
                                    if ($epermsInfo['has_sticky']) {
                                        $badgeColor = 'danger';
                                        $badgeText  = $lang['FPA_YES'];
                                    } else {
                                        $badgeColor = 'success';
                                        $badgeText  = $lang['FPA_NO'];
                                    }
                                    ?>
                                    <span class="badge bg-<? echo $badgeColor; ?>-subtle text-<? echo $badgeColor; ?> border border-<? echo $badgeColor; ?> fw-semibold px-2 py-1 text-uppercase Xw-100" style="font-size: 0.68rem; letter-spacing: 0.3px; width: 66px;"><? echo $badgeText; ?></span>
                                </td>

                                <td class="text-center">
                                    <?php
                                    if ($epermsInfo['is_world_w'] || $epermsInfo['is_group_w']) {

                                        if ($epermsInfo['is_world_w']) {
                                           $badgeColor    = 'danger';
                                            $badgeIcon    = 'shield-slash-fill';
                                            $tooltipTitle = 'Critical: World-writable or insecure mode detected!';
                                        } elseif ($epermsInfo['is_group_w']) {
                                            $badgeColor   = 'warning';
                                            $badgeIcon    = 'exclamation-triangle-fill';
                                            $tooltipTitle = 'Warning: Loose Group-writable or insecure mode detected!';
                                        }

                                    } else {
                                        $badgeColor = 'success';
                                        $badgeIcon  = 'check-circle';
                                        $tooltipTitle = 'No World or Group open rights detected!';
                                    }
                                    ?>
                                        <span class="badge bg-<? echo $badgeColor; ?> fw-black px-2.5 py-1.5 text-white w-100" style="font-size: 0.72rem;" data-bs-toggle="tooltip" data-bs-placement="left" data-bs-title="<?php echo $tooltipTitle; ?>">
                                            <i class="bi bi-<?php echo $badgeIcon; ?> me-1"></i><?php echo $epermsInfo['permissions']; ?>
                                        </span>


                                </td>



                                <td class="d-none d-md-table-cell text-muted text-end">
                                    <?php if (@!$permsInfo['owner_match'] && $permsInfo['exists']): ?>
                                        <i class="bi bi-exclamation-diamond-fill text-info me-1" style="font-size: 0.85rem;" data-bs-toggle="tooltip" data-bs-placement="left" data-bs-title="Ownership Mismatch: This directory is owned by a different user than the account executing PHP code."></i>
                                    <?php endif; ?>
                                    <span class="<?php echo !$permsInfo['owner_match'] ? 'text-secondary fw-medium' : ''; ?>">
                                        <?php echo htmlspecialchars($permsInfo['owner']); ?>
                                    </span>
                                </td>

                                <td class="d-none d-md-table-cell text-muted">
                                    <?php echo htmlspecialchars($permsInfo['group']); ?>
                                </td>

                                <!--
                                <td class="text-center">
                                    <?php if (!$permsInfo['exists']): ?>
                                        <span class="badge bg-secondary-subtle text-secondary fw-bold px-2.5 py-1.5 text-uppercase" style="font-size: 0.72rem;">Missing</span>
                                    <?php elseif (!$permsInfo['sane']): ?>
                                        <span class="badge bg-danger fw-black px-2.5 py-1.5 shadow-sm" style="font-size: 0.72rem;" title="Dangerous Mode Detected!">
                                            <i class="bi bi-exclamation-triangle-fill me-1"></i><?php echo $permsInfo['perms']; ?>
                                        </span>
                                    <?php else: ?>
                                        <span class="badge bg-light text-dark border fw-bold px-2.5 py-1.5" style="font-size: 0.72rem;">
                                            <?php echo $permsInfo['perms']; ?>
                                        </span>
                                    <?php endif; ?>
                                </td>
                                -->

                                <!-- Permissions Column with Conditional Tier Warning Badges --
                                <td class="text-center">
                                    <?php if (!$permsInfo['exists']): ?>
                                        <span class="badge bg-secondary-subtle text-secondary fw-bold px-2.5 py-1.5 text-uppercase w-100" style="font-size: 0.72rem;">
                                            Missing
                                        </span>
                                    <?php elseif (!$permsInfo['sane']): ?>
                                        -- CRITICAL DANGER BADGE (World Writable / 777) --
                                        <span class="badge bg-danger fw-black px-2.5 py-1.5 shadow-sm text-white w-100" style="font-size: 0.72rem;" data-bs-toggle="tooltip" data-bs-placement="left" data-bs-title="Critical: World-writable or insecure mode detected!">
                                            <i class="bi bi-shield-slash-fill me-1"></i><?php echo $permsInfo['perms']; ?>
                                        </span>


                                        -- TESTING issues --
                                        <?php
                                        $exceptionQueue[] = [
                                            'category'    => 'Permissions',
                                            'type'        => 'danger', // Bootstrap color code
                                            'text'        => 'At least one folder has world writable permissions.',
                                            'solution'    => 'Reset permissions to to the system default (usually 755).',
                                            'target_id'   => 'permissionsPanel' // Matches the ID of the checkbox in your offcanvas layout!
                                        ];
                                        ?>
                                        -- TESTING issues --

                                    <?php elseif (isset($permsInfo['warning']) && $permsInfo['warning']): ?>
                                        -- SECURITY WARNING BADGE (Group Writable / Loose Permissions) --
                                        <span class="badge bg-warning text-dark border border-warning-subtle fw-bold px-2.5 py-1.5 shadow-sm w-100" style="font-size: 0.72rem;" data-bs-toggle="tooltip" data-bs-placement="left" data-bs-title="Warning: Loose group or owner permissions detected.">
                                            <i class="bi bi-exclamation-triangle-fill me-1"></i><?php echo $permsInfo['perms']; ?>
                                        </span>

                                        -- TESTING issues --
                                        <?php
                                        $exceptionQueue[] = [
                                            'category'    => 'Permissions',
                                            'type'        => 'warning', // Bootstrap color code
                                            'text'        => 'At least one folder has group writable permissions.',
                                            'solution'    => 'Reset permissions to to the system default (usually 755).',
                                            'target_id'   => 'permissionsPanel' // Matches the ID of the checkbox in your offcanvas layout!
                                        ];
                                        ?>
                                        -- TESTING issues --

                                    <?php else: ?>
                                        -- CLEAN STANDARD SAFE BADGE (e.g., 0755) --
                                        <span class="badge bg-light text-dark border fw-bold px-2.5 py-1.5 w-100" style="font-size: 0.72rem;">
                                            <?php echo $permsInfo['perms']; ?>
                                        </span>
                                    <?php endif; ?>
                                </td>
                                -->


                                <td class="text-center Xtext-end Xpe-3">
                                    <?php if (!$permsInfo['exists']): ?>
                                        <i class="bi bi-dash-circle-dotted text-secondary" style="font-size: 1.04rem;"></i>
                                    <?php elseif ($permsInfo['writable']): ?>

                                        <?php
                                            // warn about being writable if perms aren't sane, else success
                                            if (!$permsInfo['sane'] || (isset($permsInfo['warning']) && $permsInfo['warning'])) {
                                                $writableColor = "warning";
                                            } else {
                                                $writableColor = "success";
                                            }
                                        ?>
                                        <!--<i class="bi bi-check-square-fill text-<?php echo $writableColor; ?> fs-5"></i>-->
                                        <span class="badge bg-<?php echo $writableColor; ?>-subtle text-<?php echo $writableColor; ?> border border-<?php echo $writableColor; ?>-subtle fw-semibold px-2 py-1 text-uppercase Xw-100" style="font-size: 0.68rem; letter-spacing: 0.3px; width: 66px;"><?php echo $lang['FPA_YES']; ?></span>
                                    <?php else: ?>
                                        <!--<i class="bi bi-x-square-fill text-danger fs-5"></i>-->
                                        <span class="badge bg-danger-subtle text-danger border border-danger-subtle fw-semibold px-2 py-1 text-uppercase Xw-100" style="font-size: 0.68rem; letter-spacing: 0.3px; width: 66px;"><?php echo $lang['FPA_NO']; ?></span>

                                        <!-- TESTING issues -->
                                        <?php
                                        $exceptionQueue[] = [
                                            'type'        => 'warning', // Bootstrap color code
                                            'text'        => 'At least one folder is not writable to your account user.',
                                            'solution'    => 'Reset permissions to to the system default (usually 755).',
                                            'target_id'   => 'permissionsPanel' // Matches the ID of the checkbox in your offcanvas layout!
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

    </div><!--/elevatedPermissions-->

</div><!--/permissionPanel-->



    </main>




    <?php
    /**
     * Footer
     * All the usuals, copyright, versioning, general info etc etc
     */
    ?>
    <footer class="border-top py-3 mt-auto bg-body-tertiary">

        <div class="container small text-body-secondary">
            <p class="p-0 m-0 small text-center">
                <?php fpaLang('FPA_LONG'); ?> v<?php echo FPA_VERSION .' ('. FPA_CODENAME .') '. FPA_COPYRIGHT_STMT; ?><br />
                <?php echo '[ Language : '?><?php fpaLang('FPA_THISLANG'); ?><?php echo' ] [ Updated : '. FPA_LAST_UPDATED .' ]'; ?><br />
                <a href="docs/accessibility.md" class="link-secondary">Accessibility (WCAG 2.1 AA)</a>
            </p>
        </div>

    </footer>


    <!-- Right-aligned Compact Offcanvas with Integrated Floating Handle -->
    <div class="offcanvas offcanvas-end shadow" tabindex="-1" id="settingsOffcanvas" aria-labelledby="settingsOffcanvasLabel" style="width: 340px; visibility: visible;">

        <!-- FLOATING HANDLE BUTTON (Moves natively with the canvas) -->
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

            <!-- Top Section: Presets & 18 Switches -->
            <div>
                <!-- Preset Profiles Section -->
                <small class="text-muted fw-bold d-block text-uppercase mb-2" style="font-size: 0.72rem; letter-spacing: 0.5px;">Profiles</small>
                <div class="row g-2 mb-3">
                    <div class="col-4">
                        <button type="button" class="btn btn-outline-secondary btn-sm fw-bold w-100 py-2 d-flex flex-column align-items-center justify-content-center <?php echo ($_SESSION['current_preset_profile'] === 'compact') ? 'active' : ''; ?>">
                            <i class="bi bi-layers mb-1 fs-5"></i>
                            <span style="font-size: 0.7rem;"><?php echo $lang['FPA_COMPACT'] ?? 'Compact'; ?></span>
                        </button>
                    </div>
                    <div class="col-4">
                        <button type="button" class="btn btn-outline-secondary btn-sm fw-bold w-100 py-2 d-flex flex-column align-items-center justify-content-center <?php echo ($_SESSION['current_preset_profile'] === 'default') ? 'active' : ''; ?>">
                            <i class="bi bi-layers-half mb-1 fs-5"></i>
                            <span style="font-size: 0.7rem;"><?php echo $lang['FPA_DEFAULT'] ?? 'Default'; ?></span>
                        </button>
                    </div>
                    <div class="col-4">
                        <button type="button" class="btn btn-outline-secondary btn-sm fw-bold w-100 py-2 d-flex flex-column align-items-center justify-content-center <?php echo ($_SESSION['current_preset_profile'] === 'detailed') ? 'active' : ''; ?>">
                            <i class="bi bi-layers-fill mb-1 fs-5"></i>
                            <span style="font-size: 0.7rem;"><?php echo $lang['FPA_DETAILED'] ?? 'Detailed'; ?></span>
                        </button>
                    </div>
                </div>

                <!-- GROUP 1: SYSTEM SETTINGS -->
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

                <!-- GROUP 2: DISPLAY OPTIONS -->
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

                <!-- GROUP 3: FILTERS & LOGGING -->
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

            <!-- Bottom Section: Sticky Form Submit Actions -->
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
    </div>


    <?php
    /**
     * external resources, scripts and fpa specific functions
     * Note: All Javascript needs to be within a script tag containing the $fpaNonce to conform to the Content Security Policy (CSP)
     *
     */
    ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous" nonce="<?php echo $fpaNonce; ?>"></script>

<!-- 📦 SAFE DATA BRIDGE: Safely output PHP array to JSON for JS to read -->
<script nonce="<?php echo $fpaNonce; ?>" id="php-queue-data" type="application/json">
  <?php echo json_encode($exceptionQueue); ?>
</script>

    <script nonce="<?php echo $fpaNonce; ?>">

        /**
         * bootstrap dark/light theme changer
         * the theme selection is stored in localStorage for persistence
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



document.addEventListener("DOMContentLoaded", () => {
    const rawData = document.getElementById("php-queue-data").textContent;
    const exceptionQueue = JSON.parse(rawData || "[]");

    const wrapper = document.getElementById("notification-wrapper");
    const countBadge = document.getElementById("queue-count");
    const itemsContainer = document.getElementById("queue-dropdown-items");

    if (exceptionQueue.length === 0) return;

    countBadge.textContent = exceptionQueue.length;

    let listHtml = '';
    exceptionQueue.forEach(issue => {
    // Generate a secure list item that functions as a rich link card
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

    // Hook up our smart scroll helper function
    initNotificationScroller();
});





        /**
         * runtimeOptionPanel, located at the top of the page is opened via a button on the main navbar, this function
         * scrolls the page back to the top to view the panel if the runtimeOptionPanel is initiated after scrolling.
         *
         */
        /// var optionCollapseEl = document.getElementById('runtimeOptionPanel');
        /// optionCollapseEl.addEventListener('show.bs.collapse', function () {
        ///     window.scrollTo({ top: 0, behavior: 'smooth' });
        /// });


        /**
         * select and initialise all bootstrap utilites, such as tooltips & popovers
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
         * privacy redaction function to capture the privacy switch change and
         * automagically reload the page appropriately using the PHP SESSION
         * data (checked (readacted) / unchecked (un-redacted)
         *
         */
        document.addEventListener('DOMContentLoaded', function () {
            const privacySwitch = document.getElementById('nav-privacy-switch');

            privacySwitch.addEventListener('change', function () {
                // 1. Package the current state of the switch toggle
                const formData = new FormData();
                formData.append('privacy_ajax', '1');
                formData.append('privacy', this.checked ? '1' : '0');

                // 2. Transmit the configuration change to PHP silently
                fetch('<?php echo $fpaSelfUrl; ?>', {
                    method: 'POST',
                    body: formData,
                    headers: { 'X-Requested-With': 'XMLHttpRequest' }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // 3. SECURE RELOAD: Instantly refresh the page to pull the redacted HTML from the server
                        window.location.reload();
                    }
                })
                .catch(error => console.error('Network security error:', error));
            });
        });
        /*
        document.addEventListener('DOMContentLoaded', function () {
            const privacySwitch = document.getElementById('nav-privacy-switch');

            privacySwitch.addEventListener('change', function () {
                // 1. Prepare form data payload dynamically
                const formData = new FormData();
                formData.append('privacy_ajax', '1');
                formData.append('privacy', this.checked ? '1' : '0');

                // 2. Transmit the state to the backend silently
                fetch('<?php echo $fpaSelfUrl; ?>', {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        console.log('Privacy preference saved:', data.state);
                        // Pro tip: You can call a custom function here to instantly
                        // hide/blur your text data fields on the page layout!
                    }
                })
                .catch(error => console.error('Error saving preference:', error));
            });
        });
        */
    </script>

</body>
</html>
