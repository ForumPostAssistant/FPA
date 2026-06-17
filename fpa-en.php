<?php
/**
 * English (en) HTML5 page shell for Forum Post Assistant.
 *
 * Application foreword and notes
 * -----------------------------
 * As you may have noticed, the FPA is quite a large standalone PHP application and unique diagnostic tool to assist
 * forum support staff in troubleshooting end-user Joomla! issues and errors. It enables less technical users to view
 * and produce consistant technical information of their server, application and instance, saving time and reducing
 * frustration on both parties. As such, many of its methods could be construed as breaking traditional conventions and
 * norms. Where possible, we try to maintain up-to-date best practices, but by its very nature, old or non-standard
 * practices, formatting, and methods may occasionally be employed to ensure backward compatibility and functionality.
 *
 * Code standards
 * --------------
 * 1.  PHP: PSR-12.
 * 2.  PHP: Minimum 7.4; stay compatible with current stable PHP releases. Use syntax and APIs supported in 7.4 unless
 *     the documented minimum is raised.
 * 3.  PHP: strict_types. In an effort to produce cleaner and more robust runtime code, we have implemented this PHP
 *     directive. PHP now enforces strict data type matching for function arguments and return values. Type juggling
 *     (automatic type casting) is disabled, forcing the engine to throw a TypeError if a value does not exactly
 *     match the declared type hint. Watch your single, double, and boolean quoting.
 * 4.  Defensive Programming: Due to the nature of the fpa operating in differing, unknown and potentially problematic
 *     environments, we operate on the Defensive Programming principle of assuming that anything that can go wrong will
 *     go wrong. Therefore, where possible pre-fill elements with defaults, validate return data before using and create
 *     routines that fail gracefully rather than crashing catastrophically.
 * 5.  HTML: HTML5.
 * 6.  HTML: Attribute Ordering. While this offers no performance gain, our preferred hierarchy is:
 *     id, class, name, src, type, aria, data/content
 * 7.  CSS: Modern CSS (Level 3 modules and newer where appropriate).
 * 8.  JavaScript & Assets: Vanilla JS (ES6+ preferred). Remote CDNs are permitted for performance, but
 *     core asset delivery must include a local fallback or fail gracefully if an internet connection is unavailable.
 * 9.  Security: Never output raw passwords, hashes, or secret keys. All sensitive system paths must be masked.
 * 10. Error Handling: Wrap environment-sensitive diagnostics in try/catch blocks to ensure graceful degradation.
 * 11. Internationalisation: All UI text must utilise the core translation arrays; do not hardcode text strings directly
 *     into the DOM.
 * 12. Accessibility: Endeavor to adhere to WCAG 2.1 Level AA.
 * 13. Commenting: In an effort to improve maintainability, DOM cleanliness, performance, and security, we comment
 *     extensively. While HTML comments are acceptable, PHP/JS comment styles are preferred for larger blocks as
 *     they are stripped out at execution and are not visible in the frontend at runtime.
 * 14. Logical Separation: Even though it is one file, maintain a strict logical separation. Structural logic, utility
 *     functions, configuration, and data processing arrays sit at the top of the file. The visual UI/HTML rendering
 *     sections sit at the bottom.
 * 15. Namespace Simulation: To avoid variable or function name collisions, prefix all global helper functions, classes,
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
 * @license GPL-2.0-or-later https://www.gnu.org/licenses/gpl-2.0-standalone.html
 * @copyright Copyright (c) 2011-2026 Forum Post Assistant
 * @author RussW
 * @author PhilD13
 * @link https://github.com/ForumPostAssistant/FPA/ Project website
 * @see https://forumpostassistant.github.io/docs/ Further documentation
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

define ('_VALID_MOS', 1);                  // for J!1.0
define ('_JEXEC', 1);                      // for J!1.5, J!1.6 thru J!6.0

// --- fpa feature configuration ---
const FPA_DEV = false;                     // developer-mode, displays raw array data on screen
const FPA_DIA = true;                     // diagnostic-mode, turns on PHP logging errors, display errors and logs error to a file
const FPA_SELF_DESTRUCT = true;           // self-destruct, attempts to self-delete on next run if file older than configured duration
const FPA_SELF_DESTRUCT_AGE = 3;          // self-destruct filetime age duration
const FPA_SSL_REDIRECT = true;            // SSL Redirect - when possible and if a valid SSL certificate is found FPA attempts to redirect to the SSL version of the site

// --- fpa live checks configuration array constants ---
const FPA_LIVE_CHECK = [                  // enable live latest FPA version check
    'enabled' => true,
    'format'  => 'json',
    'url'     => 'https://api.github.com/repos/ForumPostAssistant/FPA/releases/latest'
];

const FPA_LIVE_CHECK_JOOMLA = [           // enable live latest Joomla! version check
    'enabled' => true,
    'format'  => 'xml',
    'url'     => 'https://update.joomla.org/core/extension.xml'
];

const FPA_LIVE_CHECK_PHP = [              // enable live latest Joomla! version check
    'enabled' => true,
    'format'  => 'json',
    'url'     => 'https://php.net/releases/active.php'
];

const FPA_LIVE_CHECK_DBASE = [            // enable live latest dataBase version check (not implemented yet - TODO: need to workout how to determine DB type first)
    'enabled' => false,
    'format'  => 'json',
    'url'     => 'https://php.net/releases/active.php'
];

const FPA_LIVE_CHECK_VEL = [              // enable live VEL check (not implemented yet) TODO: need to check how to exclude this from $latestVersions array
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
    'FPA_MAYBE'             => 'Maybe',
    'FPA_DEFUNCT'           => 'Defunct',
    'FPA_STATUS'            => 'Status',
    'FPA_CURRENT'           => 'Current',
    'FPA_LATEST'            => 'Latest',
    'FPA_DEVBUILD'          => 'Dev Build',
    'FPA_UPTODATE'          => 'Up To Date',
    'FPA_UPDATEAVAIL'       => 'Update Available',
    'FPA_PLATFORM'          => 'Platform',
    'FPA_ENVIRONMENT'       => 'Environment',
    'FPA_HOST'              => 'Host',
    'FPA_SERVER'            => 'Server',
    'FPA_APPLICATION'       => 'Application',
    'FPA_WEB'               => 'Web',
    'FPA_PHP'               => 'PHP',
    'FPA_DBASE'             => 'DataBase',

    // FPA titles, headings & descriptions
    'FPA_RUNTIMEOPTIONS'    => 'Runtime Options',
    'FPA_KEYMETRICS'        => 'Key Metrics',
    'FPA_CONFIDENCE'        => 'Confidence',
    'FPA_CONFIGURATION'     => 'Configuration',
    'FPA_CONFIG'            => 'Config',
    'FPA_COREDIR_TITLE'     => 'Core Directory Permissions'

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

// dynamically generate the reduced 172.16.0.0/12 private range to ksave memory & cycles
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
 * --- Safely escape and echo a language string ---
 * Use this function to echo language strings as a belt and braces protection
 * against user contributed translations maicious code injections
 *
 * e.g: fpaLang('FPA_LONG');  -  "Forum Post Assistant"
 *
 * @param string $key The key from the translation array.
 * @return void
 */
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
 * Pre-Defined arrays used by the fpa at various points in the script execution.
 *
 */
$latestVersions['ARRNAME'] = 'Latest Versions';
$joomlaConfig['ARRNAME']    = 'Joomla! Config';
$appVersions['ARRANME']    =  'Application Versions';
// directories to be tested for permissions
$folders['ARRNAME']        = 'Joomla Core Directories';
$folders[]                 = 'images/';
$folders[]                 = 'components/';
$folders[]                 = 'modules/';
$folders[]                 = 'plugins/';
$folders[]                 = 'language/';
$folders[]                 = 'templates/';
$folders[]                 = 'cache/';
$folders[]                 = 'logs/';
$folders[]                 = 'tmp/';
$folders[]                 = 'administrator/components/';
$folders[]                 = 'administrator/modules/';
$folders[]                 = 'administrator/language/';
$folders[]                 = 'administrator/templates/';
$folders[]                 = 'administrator/logs/';
$folders[]                 = 'api/';





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
        :root {
            --fpa-primary-color: #660066;
            --fpa-primary-text: #ffffff; /* accessible text contrast for fpa-primary-color backgrounds */
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

        /* optimize layout width for laptops & larger monitors to improve screen real-estate for technical/diagnostic views */
        @media (min-width: 1200px) {
            .container {
                max-width: 1240px; /* desktop standard (Up from 1140px) */
            }
        }

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

                <a class="navbar-brand fw-semibold d-flex align-items-center gap-2" href="<?php echo $fpaSelfUrl; ?>">
                    <span class="text-white-50 fw-bold d-none d-md-block" aria-hidden="true"><i class="bi bi-chat-right-dots"></i></span>
                    <span class="d-none d-md-block"><?php fpaLang('FPA_LONG'); ?></span>
                    <span class="d-sm-block d-md-none"><?php fpaLang('FPA_SHORT'); ?>
                </a>

                <div class="navbar-nav ms-md-auto">

                    <div class="btn-toolbar Xms-md-auto" role="toolbar" aria-label="Toolbar with button groups">

                        <div class="btn-group me-2" role="group" aria-label="Privacy Group" data-bs-toggle="popover" data-bs-trigger="hover focus" data-bs-placement="bottom" data-bs-title="Data Privacy" data-bs-content="Enable or Disable data privacy protection.">
                            <input type="radio" class="btn-check" name="privacyBtnRadio" id="privacyBtnRadioOn" autocomplete="off" checked>
                            <label class="btn btn-outline-light text-success" for="privacyBtnRadioOn">On</label>

                            <input type="radio" class="btn-check" name="privacyBtnRadio" id="privacyBtnRadioOff" autocomplete="off">
                            <label class="btn btn-outline-light text-warning" for="privacyBtnRadioOff">Off</label>
                        </div>

                        <div class="btn-group me-2" role="group" aria-label="Tools Group" data-bs-toggle="popover" data-bs-trigger="focus" data-bs-title="FPA Support & Tools" data-bs-content="Housekeeping and support tools for the Forum Post Assistant.">
                            <button type="button" class="btn btn-outline-light"><i class="bi bi-filetype-pdf"></i></button>
                            <button type="button" class="btn btn-outline-light"><i class="bi bi-book-half"></i></button>
                            <button type="button" class="btn btn-outline-light"><i class="bi bi-cloud-download-fill"></i></button>
                        </div>

                        <div id="themeSwitcher" class="btn-group me-2" role="group" aria-label="Options Group">
                            <button class="btn btn-outline-light" type="button" data-bs-toggle="collapse" data-bs-target="#runtimeOptionPanel" aria-expanded="true" aria-controls="runtimeOptionPanel"><i class="bi bi-sliders"></i></button>
                            <button class="btn btn- btn-outline-light dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false" id="XthemeSwitcher">
                                <i class="theme-icon-active bi bi-sun-fill" aria-hidden="true"></i>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end">
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

                        <div class="btn-group" role="group" aria-label="Third group">
                            <a href="#" role="button" class="btn btn-danger" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-title="Delete the FPA script."><i class="bi bi-trash3-fill"></i></a>
                        </div>
                    </div>

                </div> <!--/btn-toolbar-->

            </div><!--/nav container-->

            <!--
            <div id="navSubBar" class="d-none d-md-block Xbg-secondary opacity-75 text-white py-2 Xborder-top Xborder-dark w-100">
                <div class="container-fluid text-center">
                    <small class="opacity-75">🚀 Limited Offer: Get 50% off your first month with code HALFOFF!</small>
                </div>
            </div>--/navSubBar-->

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
        //var_dump($folders);
        echo '</pre>';

        //echo sys_get_temp_dir();
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
        <div id="runtimeOptionPanel" class="container p-2 p-md-3 my-3 collapse">

            <div class="row align-items-end">
                <div class="col-12 col-md-9 me-auto">

                    <h2 class="border-bottom">
                        <i class="bi bi-sliders text-secondary"></i> <?php fpaLang('FPA_RUNTIMEOPTIONS'); ?>
                    </h2>
                    <p>
                        Not all issues require complete information disclosure or full diagnosis routines, therefore you may choose to run preset reports, or if required, manually select which area or feature to include in the report.
                    </p>

                </div>
                <div class="col-12 col-md-auto align-self-end">

                    <div class="btn-group mb-2 align-self-end" role="group" aria-label="Runtime Option Group">
                        <input id="runtimePresetBtn" class="btn-check" name="runtimeOption" type="radio" autocomplete="off" aria-expanded="true" aria-controls="runtimeOptionPreset" data-bs-toggle="collapse" data-bs-target="#runtimeOptionPreset" checked>
                        <label class="btn btn-outline-secondary" for="runtimePresetBtn">Preset</label>

                        <input id="runtimeManualBtn" class="btn-check" name="runtimeOption" type="radio" autocomplete="off" aria-expanded="false" aria-controls="runtimeOptionManual" data-bs-toggle="collapse" data-bs-target="#runtimeOptionManual">
                        <label class="btn btn-outline-secondary" for="runtimeManualBtn">Manual</label>
                    </div>

                </div>
            </div>

            <div id="runtimeOptionCollapseGroup">

                <div class="collapse show" data-bs-parent="#runtimeOptionCollapseGroup" id="runtimeOptionPreset">
                    <div class="border rounded-2 p-3">
                        <h2 class="h5">Preset Runtime Options</h2>

                        <div class="row">
                            <div class="col-6 col-lg-2 mb-3 position-relative">
                                <i class="bi bi-info-circle-fill d-block fs-4 m-2 position-absolute" style="top:-20px;right:-5px;z-index:1;" aria-hidden="true"></i>
                                <a href="#" class="card border basicPreset actionable w-100 text-center pb-2 shadow-sm"><i class="bi bi-grid-1x2 d-block fs-1" aria-hidden="true"></i>Basic</a>
                            </div>
                            <div class="col-6 col-lg-2 mb-3 position-relative">
                                <i class="bi bi-info-circle-fill d-block fs-4 m-2 position-absolute" style="top:-20px;right:-5px;z-index:1;" aria-hidden="true"></i>
                                <a href="#" class="card border defaultPreset actionable w-100 text-center pb-2 shadow-sm"><i class="bi bi-grid-1x2-fill d-block fs-1" aria-hidden="true"></i>Default</a>
                            </div>
                            <div class="col-6 col-lg-2 mb-3 position-relative">
                                <i class="bi bi-info-circle-fill d-block fs-4 m-2 position-absolute" style="top:-20px;right:-5px;z-index:1;" aria-hidden="true"></i>
                                <a href="#" class="card border enhancedPreset actionable w-100 text-center pb-2 shadow-sm"><i class="bi bi-grid-1x2 d-block fs-1" aria-hidden="true"></i>Enhanced</a>
                            </div>
                            <div class="col-6 col-lg-2 mb-3 position-relative">
                                <i class="bi bi-info-circle-fill d-block fs-4 m-2 position-absolute" style="top:-20px;right:-5px;z-index:1;" aria-hidden="true"></i>
                                <a href="#" class="card border maximumPreset actionable w-100 text-center pb-2 shadow-sm"><i class="bi bi-grid-1x2 d-block fs-1" aria-hidden="true"></i>Maximum</a>
                            </div>
                            <div class="col-md-12 col-lg-4 order-first">
                                <p class="presetHelp">This is just some dummy descriptive text.</p>
                                <p class="basicPresetHelp d-none">this is for the basic preset</p>
                                <p class="defaultPresetHelp d-none">this is for the default preset</p>
                                <p class="enhancedPresetHelp d-none">this is for the enhanced preset</p>
                                <p class="maximumPresetHelp d-none">this is for the maximum preset</p>
                            </div>
                        </div><!--/row-->
                    </div>
                </div>

                <div class="collapse" data-bs-parent="#runtimeOptionCollapseGroup" id="runtimeOptionManual">
                    <div class="border rounded-2 p-3">
                        <h2 class="h5"><i class="bi bi-gear-wide text-secondary"></i> Manual Runtime Options</h2>
                        <p>will contain manual runtime settings</p>
                        <div class="row">
                            <div class="col-12">
                                fpaPresetOptionsManual
                            </div>
                        </div><!--/row-->
                    </div>
                </div>

            </div><!--/runtimeOptionGroup-->

        </div><!--/container runtimeOptionPanel-->


        <?php
        /**
         * Key Metrics Panel
         * This panel provides a quick snapshot of key or important elements that will effect all installations, allowing
         * an instant determination that minimum core requirements are met and offering a confidence level in the basic host,
         * environment and instance configutation.
         *
         */
        ?>
        <div id="keyMetricsPanel" class="container p-2 p-md-3 my-3">
            <div class="row">
                <div class="col-12">

                    <h2 class="border-bottom">
                        <i class="bi bi-speedometer text-secondary"></i> <?php fpaLang('FPA_KEYMETRICS'); ?>
                    </h2>
                    <p>
                        Not all issues require complete information disclosure or full diagnosis routines, therefore you may choose to run preset reports, or if required, manually select which area or feature to include in the report.
                    </p>

                </div>
                <div class="col-12 col-lg-4">

                    <div id="confidenceCard" class="card border-secondary w-100 Xh-100 mb-3">
                        <div class="card-header text-bg-secondary text-center">
                            <h3 class="fw-bold fs-4">Confidence</h3>
                        </div>
                        <div class="card-body px-1">

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

                                    <span class="text-success" style="font-size: 9em; font-weight: 700;">A+</span>

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
                        <div class="card-footer">

                            footer

                        </div>
                    </div><!--/confidenceCard-->

                </div>
                <div class="col-12 col-lg-8 mb-3">

                    <div class="row row-cols-1 row-cols-md-2 g-4">
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
                    </div><!--/row-->

                </div>
            </div><!--/row-->
        </div><!--/container keyMetricsPanel-->




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


    <?php
    /**
     * external resources, scripts and fpa specific functions
     * Note: All Javascript needs to be within a script tag containing the $fpaNonce to conform to the Content Security Policy (CSP)
     *
     */
    ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous" nonce="<?php echo $fpaNonce; ?>"></script>

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


        /**
         * runtimeOptionPanel, located at the top of the page is opened via a button on the main navbar, this function
         * scrolls the page back to the top to view the panel if the runtimeOptionPanel is initiated after scrolling.
         *
         */
        var optionCollapseEl = document.getElementById('runtimeOptionPanel');
        optionCollapseEl.addEventListener('show.bs.collapse', function () {
            window.scrollTo({ top: 0, behavior: 'smooth' });
        });


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

    </script>

</body>
</html>
