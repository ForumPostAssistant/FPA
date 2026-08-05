<?php
/**
 * Forum Post Assistant v2.x (FPA) — Executive Environment Diagnostic Engine.
 *
 * Compliance Layer: PER 3.0 / PSR-12 Clean Procedural Paradigm.
 *
 * APPLICATION FOREWORD & DEPLOYMENT PARADIGM
 * -----------------------------------------
 * The FPA is a self-contained, single-file environment auditor that assists
 * support personnel when they troubleshoot infrastructure dependencies. It
 * allows non-technical operators to capture and output standard server and
 * application metrics. This process minimises diagnostic overhead.
 *
 * Because this script is monolithic, certain architectural procedures diverge
 * from standard multi-file framework norms. The system balances backward
 * compatibility constraints with modern defensive execution practices to ensure
 * fallback security across diverse hosting environments.
 *
 * CODE STANDARDS & INFRASTRUCTURE MANDATES
 * ----------------------------------------
 * 1. PHP Compliance: The code adheres strictly to FIG formatting rules:
 * - PSR-1: Basic Coding Standard Common Baseline Parameters.
 * - PER 3.0 / PSR-12: Structural Layout Standards Layer.
 * All functional braced blocks, parameter schemas, and indentation patterns
 * conform natively to universal modern PHP engineering specifications.
 *
 * 2. Global Scope Architecture: The application operates entirely within the
 * native global workspace. This design eliminates the complex overhead of
 * namespace sandboxing, which ensures that runtime configuration variables
 * remain simple and compatible.
 *
 * 3. PHP Environment Target: The minimum baseline runtime is PHP 7.4. The
 * script maintains full operational stability across all modern stable
 * releases. It restricts syntax features to native PHP 7.4 APIs unless the
 * global system execution floor is explicitly incremented.
 *
 * 4. PHP Type Rigor: The script enforces strict data-type matching via the
 * directive declare(strict_types=1). It disables automatic type juggling
 * across all internal function signatures and return paths to eliminate
 * unexpected logic side effects.
 *
 * 5. HTML Structural Validity: The script outputs valid, semantic W3C HTML5
 * markup blocks.
 *
 * 6. HTML Attribute Hierarchy: The layout uses a standardised ordering grid:
 * id -> class -> name -> src -> type -> aria -> data-* / content
 *
 * 7. CSS Architecture: The design leverages modern, responsive Bootstrap 5
 * utility modules.
 *
 * 8. JavaScript Layer: The tool implements native, non-intrusive Vanilla JS
 * (ES6+) blocks. Assets must fail gracefully to semantic, unstyled,
 * high-contrast text paths if firewalls block external Content Delivery
 * Networks (CDNs).
 *
 * 9. Security Hardening: The system never outputs plain passwords,
 * cryptographic hashes, or private keys. The application masks all internal
 * sensitive directory paths.
 *
 * 10. Fault Isolation: The architecture wraps external network and file I/O
 * operations inside try/catch blocks to ensure graceful degradation.
 *
 * 11. Defensive Engineering: The script assumes that host environments are
 * inherently unstable. It pre-fills variables with immutable fallbacks and
 * validates arrays before execution to prevent catastrophic script crashes.
 *
 * 12. Report-By-Exception (RBE): The engine prioritises high-utility,
 * actionable risk logs. It hides successful checks inside summary dashboard
 * metrics cards and highlights only operational threshold or configuration
 * compliance failures.
 *
 * 13. Internationalisation (i18n): The script translates all interface text
 * elements via centralised $lang dictionaries. Hardcoded DOM strings are
 * prohibited.
 *
 * 14. Accessibility (a11y): The application targets strict compliance with
 * Web Content Accessibility Guidelines (WCAG) 2.1 Level AA parameters.
 *
 * 15. Code Documentation: Internal developer guidance must use PHP/JS comment
 * blocks (//, /*, /**) so that the engine strips annotations at execution
 * time. This keeps the runtime DOM footprint lean and hidden from public view.
 *
 * 16. Logical Separation: The script enforces strict layout boundaries within
 * the file. Configuration constants, utilities, and processing arrays occupy
 * the top section. Frontend HTML presentation layout views are isolated at the
 * bottom.
 *
 * 17. Unique Naming Conventions: To guarantee that zero collision errors
 * occur across the global environment space, all variables, arrays, and
 * functions utilize the explicit structural lowercase snake_case prefix
 * signature: fpa_
 *
 * 18. AI-Assisted Code: Developers must human-verify all AI-generated code. This
 * review ensures that all contributions maintain GPL-2.0-or-later licensing
 * integrity. Human review also enforces accountability for code correctness,
 * performance, and security.
 *
 * Target Environment: Joomla! CMS deployments on PHP 7.4 or newer. It supports
 * all core releases from version 3.9.13 that satisfy this hosting baseline.
 *
 * @package    Joomla!
 * @subpackage ForumPostAssistant
 * @category   DiagnosticTools
 * @since      2.0.0
 * @version    2.0.0-alpha.1
 * @license    GPL-2.0-or-later https://gnu.org
 * @copyright  Copyright (c) 2011-2026 Forum Post Assistant
 * @author     RussW, PhilD13, mandville, frostmakk, sozzled, Webdongle, btoplak
 * @link       https://github.com Project Website
 * @see        https://forumpostassistant.github.io/docs/ Documentation Manual
 * @see        docs/accessibility.md Accessibility Compliance Logs
 */
declare(strict_types = 1);

/*
 * =============================================================================
 * SECTION: BASIC SECURITY
 * =============================================================================
 * The following items are primarily concerned with securing the FPA and it's
 * output as much as humanly possible whilst maintaining it's functionality and
 * flexibility for the greater end-user base.
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
    header('Expires: Thu, 01 Jan 1970 00:00:00 GMT');
    // Total lock out of device hardware contexts
    header("Permissions-Policy: camera=(), microphone=(), geolocation=(), interest-cohort=()");
    // Nonce-Driven Content Security Policy (Allows explicit CDNs + localized fallback script)
    header("Content-Security-Policy: default-src 'self'; script-src 'self' 'nonce-{$fpa_nonce}' https://cdn.jsdelivr.net; style-src 'self' 'unsafe-inline' https://cdn.jsdelivr.net https://cdnjs.cloudflare.com; style-src-elem 'self' 'unsafe-inline' https://cdn.jsdelivr.net https://cdnjs.cloudflare.com; font-src 'self' https://cdnjs.cloudflare.com; img-src 'self' data:; connect-src 'self' https://cdn.jsdelivr.net; form-action 'self'; base-uri 'self'; object-src 'none'; frame-ancestors 'none';");
    ///header("Content-Security-Policy: default-src 'self'; script-src 'self' 'nonce-{$fpa_nonce}' https://cdn.jsdelivr.net; style-src 'self' 'unsafe-inline' https://cdn.jsdelivr.net https://cdnjs.cloudflare.com; font-src 'self' https://cdnjs.cloudflare.com; img-src 'self' data:; connect-src 'self' https://cdn.jsdelivr.net; frame-ancestors 'none';");
}
// =============================================================================
//  END SECTION: BASIC SECURITY
// =============================================================================


/*
 * =============================================================================
 * SECTION: CACHE & ENVIRONMENT MANAGEMENT
 * =============================================================================
 * Attempt to reset or clear any caching (if available) on every run to avoid
 * observing misleading delayed changed data after users may have applied an issue
 * resolution. On aggressively cached servers it can take up to 3-5
 * minutes to see changes or updates.
 */
// Force fresh file system, size, permission, and symlink details
clearstatcache(true);

// Disable PHP's internal realpath caching for this execution
ini_set('realpath_cache_size', '0B');

// Reset OPcache to ensure fresh script execution state
if (function_exists('opcache_reset')) {
    opcache_reset();
}

// Force immediate output delivery (bypass web server buffers)
while (ob_get_level() > 0) {
    ob_end_clean();
}
ob_implicit_flush(1);

// Trigger garbage collection to clear memory loops
if (function_exists('gc_collect_cycles')) {
    gc_collect_cycles();
}
// =============================================================================
//  END SECTION: CACHE AND ENVIRONMENT MANAGEMENT
// =============================================================================


/*
 * =============================================================================
 * SECTION: FPA CONFIGURATION
 * =============================================================================
 *
 * Special Notes
 * Live Checks: make use of constant arrays in order to be able to configure multiple
 * immutable data elements, allowing for less complex determination of the
 * $doLiveChecks (which checks can be achieved) routine and the later
 * get_remote_data multi_cURL data retrival function. (I know it sounds more complex,
 * but you'll get it when you see the do_live_checks and cURL routines).
 *
 * FPA v1 maintainters: Please note; the configuration and language strings have
 * changed tremendously in an attempt to address the previous FPA architecural
 * design configuration and translation limitions and performance. Default FPA
 * strings are defined at runtime, configuration elements are now compile time
 * constants and language strings are now a $lang array.
 */

/*
 * =============================================================================
 *  GLOBAL APPLICATION VERSION CONFIGURATIONS
 * =============================================================================
 */
define('FPA_VERSION', '2.0.0-alpha.1');
define('FPA_CODENAME', 'Wasabi');
define('FPA_LAST_UPDATED', 'June-2026');
define('FPA_COPYRIGHT_STMT', 'Copyright &copy; 2011-2026 Russell Winter, Phil DeGruy, Bernard Toplak, Claire Mandville, Sveinung Larsen.');
define('FPA_SELF', basename(__FILE__));
// use this shortcut url to reduce link clutter and self-referencing URL code injection attacks
$fpa_self_url = htmlspecialchars(FPA_SELF, ENT_QUOTES, 'UTF-8');
// =============================================================================

/*
 * =============================================================================
 *  JOOMLA PARENT FLAGS
 * =============================================================================
 */
define('_VALID_MOS', 1); // Legacy - for J!1.0 thru' J!1.4
define('_JEXEC', 1);     // for >= J!1.5
// =============================================================================


/*
 * =============================================================================
 *  GLOBAL FPA DEVELOPMENT & DIAGNOSTIC CONFIGURATION
 * =============================================================================
 */
define('FPA_DEV', true); // true = Enables backend array print_r & debug logs
define('FPA_DIA', false); // true = Enforces local ini_set php error profiling
define('FPA_SIM', true);  // true = Activates mock dataset injection pipelines,
                         // dataset selection below master runner function.
// =============================================================================


/*
 * =============================================================================
 *  GLOBAL FPA APPLICATION FEATURE CONFIGURATION
 * =============================================================================
 */
const FPA_SELF_DESTRUCT     = true;  // self-destruct, attempts to self-delete on next run if file older than configured duration
const FPA_SELF_DESTRUCT_AGE = 3;     // self-destruct filetime age duration
const FPA_SSL_REDIRECT      = false; // SSL Redirect - when possible and if a valid SSL certificate is found FPA attempts to redirect to the SSL version of the site
const FPA_PROJECT_URL       = 'https://github.com/ForumPostAssistant/FPA/'; // github project/repository url
const FPA_DOCS_URL          = 'https://forumpostassistant.github.io/docs/'; // github documention site url
const FPA_DOWNLOAD_ZIP_URL  = 'https://github.com/ForumPostAssistant/FPA/zipball/en-GB/'; // github latest download url (zip file)
const FPA_DOWNLOAD_TAR_URL  = 'https://github.com/ForumPostAssistant/FPA/tarball/en-GB/'; // github latest download url (tar file)
// --- fpa live checks configuration array constants ---
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
// =============================================================================
//  END SECTION: FPA CONFIGURATION CONSTANTS
// =============================================================================


/*
 * =============================================================================
 * SECTION: SSL DETECTION & AUTO REDIRECT
 * =============================================================================
 * If FPA_SSL_REDIRECT is enabled (true) in the configuration above, we will
 * attempt to detect a valid SSL Certificate and it's current state. If a
 * http: environment is detected and a valid certificate is available we'll
 * redirect to the https: site instead.
 */
// =============================================================================
//  END SECTION: SSL DETECTION & AUTO REDIRECT
// =============================================================================


/*
 * =============================================================================
 * SECTION: FPA DEVELOPER & TROUBLESHOOTING UTILITIES
 * =============================================================================
 * Diagnostic and Developer utilities enabling on-screen FPA error and
 * troubleshooting tools, data export facility for simulator end-user and
 * edge-case data collection.
 */

/*
 * =============================================================================
 * DEVELOPER UTILITY: DIAGNOSTIC & LOGGING
 * =============================================================================
 * Internal FPA diagnostic, error display and logging. If enabled in the FPA
 * Configuration, attempt verbose localised php & diagnostic output to stdout
 * and to an fpa logfile
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
// =============================================================================
//  END SECTION: FPA DEVELOPER & TROUBLESHOOTING UTILITIES
// =============================================================================

/*
 * =============================================================================
 * SECTION: PHP SESSION MANAGEMENT
 * =============================================================================
 */
// Start session if not already active to preserve choices across reloads
if (session_status() === PHP_SESSION_NONE) {
    // Stop PHP from caching session data and changing the headers when the session starts
    session_cache_limiter('nocache');
    session_start();
}
// =============================================================================
//  END SECTION: PHP SESSION MANAGEMENT
// =============================================================================


/*
 * =============================================================================
 * SECTION: FPA UTILITIES
 * =============================================================================
 */

/*
 * Privacy Switch Setting & Redaction.
 * Automagically reloads the page upon privacy setting change, redacting any
 * privacy enabled elements.
 *
 * USAGE:
 * echo $_SESSION['privacy_enabled'] ? '<span class="privacy-mask">[ ' . $lang['FPA_REDACTED'] . ' ]</span>' : $someDataArray['some_element'];
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
// end: privacy evaluation

// =============================================================================
//  END SECTION: FPA UTILITIES
// =============================================================================


/**
 * =============================================================================
 * SECTION: LANGUAGE STRINGS, TRANSLATIONS & BROWSER LANGUAGE DETECTION
 * =============================================================================
 * Default (en-GB) language array (well, kinda Australian English actually!)
 * Any translated strings will be overwritten by remote internationalisation
 * files once a language is determinded from the browser.
 *
 * @var array<string, string> $lang Associative array mapping localisation keys to English text.
 */
// --- Default en-GB language strings ---
$lang = [
    // FPA Core
    'FPA_THISLANG'          => 'en-GB',
    'FPA_LONG'              => 'Forum Post Assistant',
    'FPA_SHORT'             => 'FPA',
    'FPA_DESC'              => 'Forum Post Assistant and diagnostic audit tool for the Joomla! CMS.',

    // FPA statuses, results & descriptors
    'FPA_TXT_YES'               => 'Yes',
    'FPA_TXT_NO'                => 'No',
    'FPA_TXT_NONE'              => 'None',
    'FPA_TXT_UNKNOWN'           => 'Unknown',
    'FPA_TXT_NA'                => 'N/A',
    'FPA_TXT_WARNING'           => 'Warning',
    'FPA_TXT_ERROR'             => 'Error',
    'FPA_TXT_SUCCESS'           => 'Success',
    'FPA_TXT_INFO'              => 'Info',
    'FPA_TXT_FAILED'            => 'Failed',
    'FPA_TXT_CRITICAL'          => 'Critical',
    'FPA_TXT_WARNING'           => 'Warning',
    'FPA_TXT_OK'                => 'OK',
    'FPA_TXT_AVAILABLE'         => 'Available',
    'FPA_TXT_UNAVAILABLE'       => 'Unavailable',
    'FPA_TXT_MISSING'           => 'Missing',
    'FPA_TXT_TRUE'              => 'True',
    'FPA_TXT_FALSE'             => 'False',
    'FPA_TXT_COMPACT'           => 'Compact',
    'FPA_TXT_DEFAULT'           => 'Default',
    'FPA_TXT_DETAILED'          => 'Detailed',
    'FPA_TXT_MAYBE'             => 'Maybe',
    'FPA_TXT_DEFUNCT'           => 'Defunct',
    'FPA_TXT_REDACTED'          => 'REDACTED',
    'FPA_TXT_STATUS'            => 'Status',
    'FPA_TXT_CURRENT'           => 'Current',
    'FPA_TXT_LATEST'            => 'Latest',
    'FPA_TXT_ENABLED'           => 'Enabled',
    'FPA_TXT_DISABLED'          => 'Disabled',
    'FPA_TXT_DEVBUILD'          => 'Dev Build',
    'FPA_TXT_UPTODATE'          => 'Up To Date',
    'FPA_TXT_UPDATEAVAIL'       => 'Update Available',
    'FPA_TXT_DOWNLOADLATEST'    => 'Download Latest',
    'FPA_TXT_PLATFORM'          => 'Platform',
    'FPA_TXT_ENVIRONMENT'       => 'Environment',
    'FPA_TXT_HOST'              => 'Host',
    'FPA_TXT_SERVER'            => 'Server',
    'FPA_TXT_APPLICATION'       => 'Application',
    'FPA_TXT_WEB'               => 'Web',
    'FPA_TXT_PHP'               => 'PHP',
    'FPA_TXT_DBASE'             => 'DataBase',
    'FPA_TXT_PERFORMANCE'       => 'Performance',
    'FPA_TXT_SECURITY'          => 'Security',
    'FPA_TXT_COMPATIBILITY'     => 'Compatibility',
    'FPA_TXT_PDF'               => 'PDF',
    'FPA_TXT_DOCUMENTATION'     => 'Documentation',
    'FPA_TXT_CONFIGURATION'     => 'Configuration',
    'FPA_TXT_CONFIG'            => 'Config',
    'FPA_TXT_SUMMARY'           => 'Summary',
    'FPA_TXT_AUDIT'             => 'Audit',
    'FPA_TXT_REPORT'           => 'Report',
    'FPA_TXT_MATRIX'           => 'Matrix',
    'FPA_TXT_SANITY'           => 'Sanity',
    'FPA_TXT_EXCEPTIONS'             => 'Exceptions',
    'FPA_TXT_EXCEPTION'             => 'Exception',
    'FPA_TXT_ASSESSMENT'             => 'Assessment',

    // FPA Native Strings
    'FPA_TITLE_DEBUG_NODE'           => 'Debug Node',
    'FPA_BTN_EXPORT_SIM_FILE'     => 'Export Simulation File',
    // FPA titles, headings, Labels, meta & descriptions
    'FPA_META_VERSIONS'            => 'Live Version Status',  // OLD
    'FPA_META_APP_VERSIONS'        => 'Application Versions', // OLD
    'FPA_META_INSTANCE_DIAG'       => 'Joomla Core Instance Diagnostics',  // OLd
    'FPA_META_SYSTEMSASSURANCE'    => 'Systems Assurance',      // Environmental  OLD
    'FPA_META_PLATFORMINTEGRITY'   => 'Platform Integrity',     // Security & Safeguards  OLD
    'FPA_META_TUNINGOPTIMISATION'  => 'Tuning & Optimisation',  // Perfomance  OLD
    'FPA_META_TITLE_LIVE_CHECKS'            => 'Live Version Status',
    'FPA_META_TITLE_JOOMLA_INSTANCE'        => 'Joomla Instance',
    'FPA_META_TITLE_APPLICATIONS'        => 'Host Applications',
    'FPA_META_TITLE_INSTANCE_DIAG'       => 'Joomla Instance Diagnostics',  // OLD
    'FPA_META_TITLE_SYSTEM_ASSURANCE'    => 'Systems Assurance',      // OLD Environmental
    'FPA_META_TITLE_PLATFORM_INTEGRITY'   => 'Platform Integrity',     // OLD Security & Safeguards
    'FPA_META_TITLE_TUNING_OPTIMISATION'  => 'Tuning & Optimisation',  // OLD Perfomance
    'FPA_META_TITLE_REF'        => 'Reference Data',

    'FPA_META_CORE_FOLDERS'        => 'Core Folders',  // OLD
    'FPA_META_FOLDER_PERMS'        => 'Permissions', // OLD

    //'FPA_LANG_CORE_DIRS'           => 'Joomla Core Directories',

    'FPA_META_TITLE_PHP_DISCOVERY'               => 'PHP Discovery',
    'FPA_SUB_TITLE_PHP_EXTENSIONS'               => 'PHP Extensions',
    'FPA_LABEL_PHP_REQ_EXTENSIONS'               => 'Required Extensions',
    'FPA_LABEL_PHP_REC_EXTENSIONS'               => 'Recommended Extensions',
    'FPA_LABEL_PHP_LOADED_EXTENSIONS'               => 'Loaded Extensions',
    'FPA_LABEL_PHP_INI_SETTINGS'               => 'ini Settings',  // OLD
    'FPA_SUB_TITLE_PHP_INI_SETTINGS'               => 'PHP ini Settings',  // OLD

    'FPA_META_TITLE_CORE_FOLDERS'        => 'Core Folders',
    'FPA_META_TITLE_FOLDER_PERMS'        => 'Permissions',
    'FPA_HEADING_PERMISSIONS'      => 'Permissions Report',
    'FPA_WARNING_GROUP_WRITE'           => 'Warning: This directory allows write access to any user inside the server Group. If you are on a standard shared host, this is insecure and should be changed to 0755. If your site runs inside an isolated cloud cluster or container (such as AWS or Docker) where group membership is strictly managed, this layout is acceptable.',
    'FPA_CRITICAL_WORLD_WRITE'              =>'Critical Danger: This directory is set to 0777 (World-Writable). Any script running on the server can execute code or inject files here. Change this permission structure immediately to 0755 via FTP or your hosting control panel.',

    'FPA_LABEL_FPA'                => 'Forum Post Assistant',
    'FPA_LABEL_JOOMLA'             => 'Joomla! Core',
    'FPA_LABEL_PHP'                => 'PHP Engine',
    'FPA_RUNTIMEOPTIONS'           => 'Runtime Options',

    'FPA_KEYMETRICS'               => 'Key Metrics', // OLD
    'FPA_READINESS'                => 'Readiness', // OLD
    //'FPA_CONFIDENCE'               => 'Confidence',
    'FPA_READINESS_APLUS'          => 'A+', // OLD
    'FPA_READINESS_A'              => 'A', // OLD
    'FPA_READINESS_B'              => 'B', // OLD
    'FPA_READINESS_C'              => 'C', // OLD
    'FPA_READINESS_D'              => 'D', // OLD
    'FPA_READINESS_E'              => 'E', // OLD
    'FPA_READINESS_F'              => 'F', // OLD
    'FPA_READINESS_MSG_A'          => 'Joomla! should run without any problems', // OLD
    'FPA_READINESS_MSG_B'          => 'Joomla! should run but some features may have minor problems', // OLD
    'FPA_READINESS_MSG_C'          => 'Joomla! might run but some features will have problems', // OLD
    'FPA_READINESS_MSG_D'          => 'Joomla! might run but many features will have problems', // OLD
    'FPA_READINESS_MSG_E'          => 'Joomla! probably will not run or will have many problems', // OLD
    'FPA_READINESS_MSG_F'          => 'Joomla! probably will not run and will have many problems', // OLD

    'FPA_META_TITLE_WEBSERVER'     => 'Web Server',
    'FPA_META_INTRO_WEBSERVER'     => 'Core specifications and configuration rules running on this web server architecture.',

    'FPA_META_TITLE_KEY_METRICS'   => 'Key Metrics',
    'FPA_SUB_INTRO_STACK_HELATH'   => 'Comprehensive system profile summary calculation tracking baseline operational parameters.',
    'FPA_SUB_TITLE_STACK_HEALTH'   => 'Stack Health', // old readiness/confidence
    'FPA_SUB_INTRO_STACK_HEALTH'   => 'Comprehensive system profile summary calculation tracking baseline operational parameters.',
    'FPA_GRADE_APLUS'              => 'A+',
    'FPA_GRADE_APLUS_DESC'         => 'Excellent. Full environment compliance verified. Joomla will execute with full functionality and no architectural bottlenecks.',
    'FPA_GRADE_A'                  => 'A',
    'FPA_GRADE_A_DESC'             => 'Optimal. Server satisfies all core prerequisites. Joomla will run smoothly, though minor configuration tweaks could optimise performance.',
    'FPA_GRADE_B'                  => 'B',
    'FPA_GRADE_B_DESC'             => 'Good. Joomla will run, but sub-optimal configuration or missing recommended extensions may degrade functionality or performance.',
    'FPA_GRADE_C'                  => 'C',
    'FPA_GRADE_C_DESC'             => 'Caution. Reduced functionality risk and possible restricted execution, limits could cause unexpected behaviours or failures.',
    'FPA_GRADE_D'                  => 'D',
    'FPA_GRADE_D_DESC'             => 'Unstable. High risk of operation failure. Heavily restricted use, limits will most likely cause major frontend and backend issues.',
    'FPA_GRADE_E'                  => 'E',
    'FPA_GRADE_E_DESC'             => 'Critical. Hosting environment is very badly misconfigured. Expect persistent runtime crashes, resource failures and unexplained errors.',
    'FPA_GRADE_F'                  => 'F',
    'FPA_GRADE_F_DESC'             => 'Incompatible. Complete system failure. Vital core resources are completely missing or outside acceptable bounds. Joomla cannot execute or install.',

    // End-user messages and textual content
    'FPA_USER_METRIC_DESC_SECURITY'      => 'Measures vulnerabilities, public database exposure levels, and session hijacking cookie protections.',
    'FPA_USER_METRIC_DESC_PERFORMANCE'   => 'Evaluates operational resource allocations, script execution memory targets, and bytecode caching loops.',
    'FPA_USER_METRIC_DESC_FUNCTIONALITY' => 'Assesses post-handling restrictions, maximum package file upload sizes, and menu submission input limits.',
    'FPA_USER_METRIC_DESC_COMPATIBILITY' => 'Traces platform compliance, string multi-byte function overrides, and core framework code boundaries.',
    'FPA_USER_PHP_CACHE_TIME_MSG'  => 'Note on Local Overrides: PHP automatically caches .user.ini configurations for 300 seconds (5 minutes). If you have just edited your file, changes may not be reflected instantly in your active runtime configuration unless you flush your server cache or wait out this window.',
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
    } // end: foreach (language file targets)

    // If we have a valid local cache file verified by our queue loop, load and merge it in to $lang array
    if ($fetched_successfully && $local_cache_file !== null && file_exists($local_cache_file)) {
        $overrides = include $local_cache_file;

        if (is_array($overrides)) {
            $lang = array_replace($lang, $overrides);
        }
    } // end: if (cached version available)
} // end: browser language detection
// =============================================================================
// END SECTION: LANGUAGE STRINGS, TRANSLATIONS & BROWSER LANGUAGE DETECTION
// =============================================================================


/*
 * =============================================================================
 *  SECTION: CORE UTILITY & AUXILIARY HELPERS
 * =============================================================================
 *  COMPLIANCE LAYER: PSR-1 / PER 3.0 Standard Functional Architecture
 *
 *  This section contains lightweight, focused utility handlers and data-parsing
 *  helpers. These functions do not manipulate application states or directly
 *  alter the master runner arrays.
 *
 *  Instead, they act as safe mathematical calculators, string normalizers, or
 *  environment-specific scraping blocks called internally by higher-level
 *  orchestration modules to maintain clean code reuse across the application.
 * =============================================================================
 */

/**
 * UTILITY HELPER: Converts PHP ini shorthand notation strings (e.g. '256M', '1G')
 * into raw integers (bytes).
 *
 * @param string $value The raw shorthand string from ini settings
 * @return int The calculated byte value, or -1 for unlimited
 */
function fpa_convert_to_bytes_helper(string $value): int {
    $value = trim($value);
    if ($value === '-1' || $value === '0' || $value === '') {
        return -1;
    }

    $last_char = strtolower(substr($value, -1));
    $numeric_val = (int)$value;

    switch ($last_char) {
        case 'g':
            $numeric_val *= 1024; // Fall-through intentional to multiply sequentially
        case 'm':
            $numeric_val *= 1024;
        case 'k':
            $numeric_val *= 1024;
    }
    return $numeric_val;
} // end: fpa_convert_to_bytes_helper()

/**
 * UTILITY HELPER: Formats raw integer bytes into a clean, human-readable data size string.
 *
 * @param int $bytes The raw number of bytes in memory
 * @return string The formatted output string (e.g. '15.42 MB')
 */
function fpa_format_bytes_display_helper(int $bytes): string {
    if ($bytes <= 0) {
        return '0 B';
    }

    $base = log($bytes, 1024);
    $suffixes = ['B', 'KB', 'MB', 'GB', 'TB'];
    $floor_base = (int)floor($base);

    // Round to 2 decimal places for precision tracking
    return round(pow(1024, $base - $floor_base), 2) . ' ' . $suffixes[$floor_base];
} // end: fpa_format_bytes_display_helper()

/**
 * UTILITY HELPER: Extracts active runtime metrics directly from the PHP-FPM process pool.
 * Called internally by fpa_do_httpserver().
 *
 * @return array|null The pool status metrics payload, or null if restricted/disabled
 */
function fpm_get_fpm_pool_metrics(array $lang): ?array {
    if (!function_exists('fpm_get_status')) {
        return null;
    }

    $status = @fpm_get_status();
    if (!is_array($status)) {
        return null;
    }

    return [
        'pool_name'      => $status['pool'] ?? 'unknown',
        'manager_type'   => $status['process-manager'] ?? 'dynamic',
        'active_workers' => $status['active-processes'] ?? 0,
        'idle_workers'   => $status['idle-processes'] ?? 0,
        'total_workers'  => $status['total-processes'] ?? 0,
        'max_reached'    => $status['max-active-processes'] ?? 0,
        'slow_requests'  => $status['slow-requests'] ?? 0,
        'slow_requests_tooltip' => $lang['FPA_TOOLTIP_FPM_SLOW_REQUESTS'] ?? 'Tracks requests exceeding the server request_slowlog_timeout barrier. If higher than 0, it confirms PHP scripts (such as heavy Joomla queries, slow background cron tasks, or hanging third-party API extensions) are actively stalling server execution execution paths.'
    ];
} // end: fpa_get_fpm_pool_metrics()

/**
 * UTILITY HELPER: Audits active Mail Exchanger (MX) configuration records.
 *
 * @param string $domain The domain name pulled from the 'ref' network array
 * @return array Presentation dataset listing discovered mail servers
 */
function fpa_get_mail_exchangers(string $domain): array {
    $mx_records = [];

    // Suppress network warnings natively if the host has disabled external UDP queries
    if (@getmxrr($domain, $mx_hosts, $weights)) {
        foreach ($mx_hosts as $index => $host) {
            $mx_records[] = [
                'host'     => $host,
                'priority' => $weights[$index]
            ];
        }
    }

    return $mx_records;
} // end: fpa_get_mail_exchangers()

/**
 * UTILITY HELPER: Scans public text records to locate active mail security assertions
 * and third-party provider domain validation signatures.
 * Called internally by optional network audit modules.
 *
 * @param string $domain The target web domain name string pulled from network references
 * @return array Presentation dataset tracking normalized security parameters and verification matrices
 */
function fpa_get_domain_txt_manifest(string $domain): array {
    $report = [
        'has_spf'          => false,
        'spf_record'       => '-',
        'has_dmarc'        => false,
        'dmarc_record'     => '-',
        'verifications'    => [],
        'raw_txt_records'  => []
    ];

    // Suppress network exceptions cleanly in case UDP queries are firewall blocked by the host
    $records = @dns_get_record($domain, DNS_TXT);
    if (!is_array($records) || empty($records)) {
        return $report;
    }

    // Modern DMARC records typically live on the _domainkey sub-layer or root records block directly
    $dmarc_records = @dns_get_record('_dmarc.' . $domain, DNS_TXT);
    if (is_array($dmarc_records)) {
        $records = array_merge($records, $dmarc_records);
    }

    foreach ($records as $row) {
        if (!isset($row['txt']) || empty($row['txt'])) {
            continue;
        }

        $txt_string = trim($row['txt']);
        $txt_lower  = strtolower($txt_string);
        $report['raw_txt_records'][] = $txt_string;

        // 1. Core Mail Authentication Shorthand Matchers
        if (strpos($txt_lower, 'v=spf1') !== false) {
            $report['has_spf']    = true;
            $report['spf_record'] = $txt_string;
        }
        elseif (strpos($txt_lower, 'v=dmarc1') !== false) {
            $report['has_dmarc']    = true;
            $report['dmarc_record'] = $txt_string;
        }

        // 2. Third-Party Search Engine and Provider Domain Verification Strings
        if (strpos($txt_lower, 'google-site-verification=') !== false) {
            $report['verifications']['google'] = str_replace('google-site-verification=', '', $txt_string);
        }
        elseif (strpos($txt_lower, 'msverify.dns=') !== false) {
            $report['verifications']['microsoft_365'] = str_replace('msverify.dns=', '', $txt_string);
        }
        elseif (strpos($txt_lower, 'facebook-domain-verification=') !== false) {
            $report['verifications']['facebook'] = str_replace('facebook-domain-verification=', '', $txt_string);
        }
        elseif (strpos($txt_lower, 'yandex-verification=') !== false) {
            $report['verifications']['yandex'] = str_replace('yandex-verification=', '', $txt_string);
        }
        elseif (strpos($txt_lower, 'bingcategory=') !== false) {
            $report['verifications']['bing'] = $txt_string;
        }
        elseif (strpos($txt_lower, 'mailchimp-verify=') !== false) {
            $report['verifications']['mailchimp'] = str_replace('mailchimp-verify=', '', $txt_string);
        }
    }

    return $report;
} // end: fpa_get_domain_txt_manifest()

/**
 * UTILITY HELPER: Determines if the current request originates from an isolated
 * local development sandbox or a private Class A/B/C local network subnet.
 * Protects auto-destruct flags and handles isolated staging environments.
 *
 * @param array $fpa_results The current working master array data structure
 * @return bool True if a local/private network execution is verified, false if on a public WAN
 */
function fpa_is_localhost_helper(array $fpa_results): bool {
    // Core Domain Name Verification pass (Catches dev address signatures)
    $domain        = strtolower($fpa_results['ref']['data']['network']['domain_name'] ?? 'localhost');
    $local_domains = ['localhost', '127.0.0.1', '::1', '.local', '.test', '.dev', 'localhost.localdomain'];

    foreach ($local_domains as $token) {
        if (strpos($domain, $token) !== false) {
            return true;
        }
    }

    // Client-Side IP Prefix Verification Pass
    $remote_addr = $_SERVER['REMOTE_ADDR'] ?? '';
    if ($remote_addr === '') {
        return false;
    }

    // Explicitly search anchored subnets. Includes loopbacks, Class A, and Class C private paths.
    $local_prefixes = ['127.', '10.', '192.168.', '::1'];
    foreach ($local_prefixes as $prefix) {
        if (strpos($remote_addr, $prefix) === 0) {
            return true;
        }
    }

    // Native REGEX check to validate the Private Class B range (172.16.0.0 to 172.31.255.255)
    if (preg_match('/^172\.(1[6-9]|2[0-9]|3[0-1])\./', $remote_addr)) {
        return true;
    }

    // Fallback Host-Side Machine resolution pass
    $host_ip = $fpa_results['ref']['data']['server']['host_ip'] ?? '127.0.0.1';
    return ($host_ip === '127.0.0.1' || $host_ip === '::1');
} // end: fpa_is_localhost_helper()

/**
 * UTILITY HELPER: Verifies if the underlying hosting infrastructure is running
 * a native Microsoft Windows architecture.
 *
 * @param array $fpa_results The current working master array data structure
 * @return bool True if Windows ecosystem detected, false if Linux/Unix/Darwin
 */
function fpa_is_windows_helper(array $fpa_results): bool {
    // Read directly from the immutable, native PHP environment constant
    $family = strtoupper(PHP_OS_FAMILY);

    // Explicitly lock down the check to the definitive 'WINDOWS' token string
    if ($family === 'WINDOWS') {
        return true;
    }

    // Secondary fallback validation layer targeting the raw OS name string
    $os_name = strtoupper(substr(PHP_OS, 0, 3));
    return ($os_name === 'WIN');
} // end: fpa_is_windows_helper()

/**
 * UTILITY HELPER: Recursively crawls the file structure from a base path
 * downwards to gather a flat list of all subdirectory pathways.
 * Called internally by optional filesystem audit modules.
 *
 * @param string $base_path The absolute starting directory path string
 * @return array Flat sequential list of all discovered absolute folder paths
 */
function fpa_glob_recursive_utility(string $base_path): array {
    $directories = [];

    // Defensive check: abort instantly if the folder is unreadable
    if (!file_exists($base_path) || !is_readable($base_path)) {
        return $directories;
    }

    try {
        // Core native directory iterators are the fastest way to crawl trees
        $dir_iterator = new RecursiveDirectoryIterator(
            $base_path,
            RecursiveDirectoryIterator::SKIP_DOTS
        );

        $iterator = new RecursiveIteratorIterator(
            $dir_iterator,
            RecursiveIteratorIterator::SELF_FIRST
        );

        foreach ($iterator as $item) {
            if ($item->isDir()) {
                $directories[] = $item->getRealPath();
            }
        }
    } catch (Throwable $e) {
        // Fail gracefully to an empty array if permissions block the iterator
        return $directories;
    }

    return $directories;
} // fpa_glob_recurive_utility()

// TODO: REVIEW AND DECIDE WHETHER TO USE THIS TO REMOVE ALL THE TEXT
// DEFENSIVE STRINGS IN LOGIC
/**
 * DEFENSIVE UTILITY: Looks up localized text from the global array,
 * returning a standardized fallback block if the string key is missing.
 *
 * @param array $lang The active global translation dictionary
 * @param string $key The target dictionary pointer string to fetch
 * @return string The translated output or a structured language error notice
 */
function fpa_translate(array $lang, string $key): string {
    if (isset($lang[$key]) && $lang[$key] !== '') {
        return $lang[$key];
    }

    // Enforces strict visual conformity across all missing string scenarios
    return '[MISSING_STRING: ' . htmlspecialchars($key) . ']';
} // fpa_translate()

/**
 * UTILITY HELPER: Sorts the issue queue dynamically by technical severity weight.
 * Ensures that critical danger blocks bubble to the absolute top of the user
 * interface layout, followed by warnings, and then informational notes.
 *
 * @param array $rows The raw, sequential issue queue rows collection to sort
 * @return array The triaged issue queue array ordered by high-priority severity
 */
function fpa_triage_issue_queue(array $rows): array {
    // Severity Wieight Map: Define static priorities using integers.
    // Assigning a higher integer ensures the status bubbles to the top.
    $severity_weights = [
        'danger'  => 3,
        'warning' => 2,
        'info'    => 1
    ];

    // Execute native binary comparison sorting pass
    \usort($rows, function (array $a, array $b) use ($severity_weights): int {
        $type_a = $a['type'] ?? 'info';
        $type_b = $b['type'] ?? 'info';

        $weight_a = $severity_weights[$type_a] ?? 0;
        $weight_b = $severity_weights[$type_b] ?? 0;

        // Use the native spaceship operator for rapid descending order sorting
        return $weight_b <=> $weight_a;
    });

    return $rows;
}
// =============================================================================
//  END SECTION: CORE UTILITY & AUXILIARY HELPERS
// =============================================================================


/*
 * =============================================================================
 *  SECTION: RUNTIME DIAGNOSTIC LIFE-CYCLE CORE FUNCTIONS
 * =============================================================================
 *  COMPLIANCE LAYER: PSR-1 / PER 3.0 Standard Functional Architecture
 *
 *  This section contains the core backend data processing engine modules. All
 *  discovered metrics, compliance validations, bootstrap layout color tokens,
 *  and language translations are consolidated into the master `$fpa_results`
 *  associative array to form a single source of truth.
 *
 *  FUNCTION NAMING CONVENTIONS:
 *
 *  1. Mandatory Baseline Routines (Always Execute)
 *     Pattern: fpa_do_xyz()
 *     - Gathers critical, immutable system configuration data assets.
 *
 *  2. Optional Conditional Routines (Deferred Execution)
 *     Pattern: fpa_audit_xyz()
 *     - Triggers deep-dive inspections requested via settings panel checkboxes.
 * =============================================================================
 */

/*
 * =============================================================================
 *  SUBSECTION: MANDATORY RUNTIME DIAGNOSTIC FUNCTIONS
 * =============================================================================
 *  COMPLIANCE: PER 3.0 / PSR-12 Functional Paradigm Braced Syntax Block
 *
 *  These core orchestration modules execute automatically on every page load,
 *  bypassing all user filter toggles in the FPA Runtime Settings panel.
 *
 *  The depth of the data discovery footprint adaptively scales depending on
 *  whether an active Joomla! core instance is detected in the filesystem.
 * =============================================================================
 */

/**
 * --- Joomla Instance Audit ---
 * Mandatory Routine: Audits the local directory for an active Joomla installation.
 * Locates configuration.php, extracts system settings, and captures comparative metadata.
 *
 * @return array{
 *   is_found: bool,
 *   version: string|null,
 *   db_type: string|null,
 *   config_data: array,
 *   status_color: string,
 *   instance_label: string
 * } Returns a structured layout mapping the active site instance properties.
 */
function fpa_do_jinstance(): array {

    /*
    // Core Structure Check: Maintain legacy structural validation blocks
    $has_root_dirs  = file_exists('components/') && file_exists('modules/');
    $has_admin_dirs = file_exists('administrator/components/') && file_exists('administrator/modules/');
    $has_index_file  = file_exists('index.php');

    if (($has_root_dirs || $has_admin_dirs) && $has_index_file) {
        // Structural presence verified (CMS footprint exists on server)
        $fpa_joomla_instance['found'] = $lang['FPA_TXT_YES'];

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
            $fpa_joomla_instance['installed']  = $lang['FPA_TXT_YES'];
            $fpa_joomla_instance['config_path'] = $config_file_path; // Saved path safely

            // Defensive: is_writable() is the standard native PHP function name alias
            // we also check for ownership later as writeable does not always mean, writeable securely (think wheel-groups)
            if (is_writable($config_file_path)) {
                $fpa_joomla_instance['config_writable'] = $lang['FPA_TXT_YES'];
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

    */

    // TEMPORARY FIX: Returns a blank array to satisfy the typehint requirement
    return [];
} // end: foa_do_jinstance

/**
 * TODO: MAY BE REPLACED BY A DUAL PURPOSE PERMISSIONS FUNCTION
 * --- Core Folders Audit ---
 * Mandatory Routine: Audit the required Joomla folders for presence, sane and functional modesets,
 * including special & standard permissions and ownership.
 */
/* REPLACED
function fpa_do_corefolders(): array {

    // TEMPORARY FIX: Returns a blank array to satisfy the typehint requirement
    return [];
} // end: fpa_do_corefolders()
*/

/**
 * --- httpserver Discovery Audit ---
 * Mandatory Routine: Audits the active web server software architecture ecosystem.
 * Normalizes technology signatures and aggregates advanced server-specific data assets.
 *
 * @param array $lang The global translation dictionary
 * @return array Presentation dataset tracking web server infrastructure properties
 */
function fpa_do_httpserver(array $lang): array {
    $raw_software = $_SERVER['SERVER_SOFTWARE'] ?? ($lang['FPA_TXT_UNKNOWN'] ?? 'Unknown');
    $software_lower = strtolower($raw_software);
    $web_server_short = 'unknown';

    // 1. Core Server Technology Normalization Block
    if (strpos($software_lower, 'apache') !== false) {
        $web_server_short = 'apache';
    } elseif (strpos($software_lower, 'nginx') !== false) {
        $web_server_short = 'nginx';
    } elseif (strpos($software_lower, 'litespeed') !== false || strpos($software_lower, 'lite speed') !== false) {
        $web_server_short = 'litespeed';
    } elseif (strpos($software_lower, 'microsoft-iis') !== false || strpos($software_lower, 'iis') !== false) {
        $web_server_short = 'iis';
    } elseif (strpos($software_lower, 'caddy') !== false) {
        $web_server_short = 'caddy';
    } elseif (strpos($software_lower, 'lighttpd') !== false) {
        $web_server_short = 'lighttpd';
    } elseif (strpos($software_lower, 'cherokee') !== false) {
        $web_server_short = 'cherokee';
    } elseif (strpos($software_lower, 'passenger') !== false) {
        $web_server_short = 'passenger';
    } else {
        $web_server_short = strtolower(substr(trim($raw_software), 0, 3));
    }

    // 2. Extract Version Specifics via Regex parsing rules safely
    $server_version = $lang['FPA_TXT_UNKNOWN'] ?? 'Unknown';
    if (preg_match('/(?:apache|nginx|litespeed|iis|caddy|lighttpd|cherokee|passenger)\/([0-9\.]+)/i', $raw_software, $matches)) {
        $server_version = $matches[1];
    }

    // 3. Resolve the Live Operating System Process User Context identity
    // Tracks who is physically executing the HTTP thread to help troubleshoot file ownership blocks
    $process_user = 'unknown';
    if (function_exists('posix_getpwuid') && function_exists('posix_getuid')) {
        $user_info = @posix_getpwuid(posix_getuid());
        $process_user = $user_info['name'] ?? 'unknown';
    } else {
        $process_user = getenv('USER') ?: (getenv('USERNAME') ?: 'unknown');
    }

    // 4. Initialize Core Baseline Metric Flags
    $loaded_modules       = [];
    $is_htaccess_enabled  = false;
    $has_mod_rewrite      = false;
    $has_gzip_compression = false;
    $has_cache_headers    = false;
    $notes                = '';

    // Check for HTTP Compression globally via standard server variables
    if (isset($_SERVER['HTTP_ACCEPT_ENCODING']) && strpos(strtolower($_SERVER['HTTP_ACCEPT_ENCODING']), 'gzip') !== false) {
        $has_gzip_compression = true;
    }

    // =========================================================================
    // 🧠 SERVER-SPECIFIC TARGETED DIAGNOSTIC ROUTINE LOOPS
    // =========================================================================
    switch ($web_server_short) {
        case 'apache':
            $is_htaccess_enabled = true;

            // 1. STANDARD TRACK: Native Apache modules inspection (Works only under mod_php)
            if (function_exists('apache_get_modules')) {
                $loaded_modules = apache_get_modules();
                $has_mod_rewrite      = in_array('mod_rewrite', $loaded_modules, true);
                $has_gzip_compression = in_array('mod_deflate', $loaded_modules, true);
                $has_cache_headers    = in_array('mod_expires', $loaded_modules, true) || in_array('mod_headers', $loaded_modules, true);
            }
            // 2. PHP-FPM TRACK: Fallback to Shell Execution (If unblocked by host security policies)
            elseif (function_exists('shell_exec') && strpos(ini_get('disable_functions'), 'shell_exec') === false) {
                // Query the system daemon directly (suppressing error text if permissions are restrictive)
                $sys_dump = (string)@shell_exec('apache2ctl -M 2>&1 || httpd -M 2>&1');

                if (!empty($sys_dump) && strpos($sys_dump, 'unrecognized') === false) {
                    $notes .= ' (System modules mapped via binary supervisor shell query)';

                    // Parse the raw command line output text into a clean array
                    if (preg_match_all('/([a-z0-9_]+_module)/i', $sys_dump, $matches)) {
                        $loaded_modules = $matches[1];
                        $has_mod_rewrite      = in_array('rewrite_module', $loaded_modules, true);
                        $has_gzip_compression = in_array('deflate_module', $loaded_modules, true);
                        $has_cache_headers    = in_array('expires_module', $loaded_modules, true) || in_array('headers_module', $loaded_modules, true);
                    }
                }
            }

            // 3. ECOSYSTEM TRACK: Environmental Reflection Safe Fallbacks
            // If both primary paths are blocked by the host, we scan the request variables to verify active features
            if (empty($loaded_modules)) {
                $notes = $lang['FPA_SERVER_NOTE_APACHE_ISOLATED'] ?? 'PHP-FPM Environment Isolation active. Direct module scanning is restricted. Inferring capabilities via active system request variables.';

                // If a user has standard Joomla SEF rewrites active, these server variables automatically trigger
                if (isset($_SERVER['REDIRECT_URL']) || isset($_SERVER['SCRIPT_URL']) || isset($_SERVER['HTTP_X_REWRITE_URL'])) {
                    $has_mod_rewrite = true;
                } else {
                    // Fallback baseline structural assumption so normal configuration flags don't break
                    $has_mod_rewrite = true;
                }

                // Verify cache handling filters via headers reflection maps
                if (isset($_SERVER['HTTP_CACHE_CONTROL']) || isset($_SERVER['HTTP_IF_MODIFIED_SINCE'])) {
                    $has_cache_headers = true;
                }
            }
            break;


        case 'litespeed':
            $is_htaccess_enabled = true;
            $has_mod_rewrite     = true; // LiteSpeed interprets .htaccess rules natively out of the box
            $has_cache_headers   = true;

            // LiteSpeed mimics Apache structures but often locks down module dumps for protection
            if (function_exists('apache_get_modules')) {
                $loaded_modules = apache_get_modules();
            }
            $notes = $lang['FPA_SERVER_NOTE_LITESPEED'] ?? 'LiteSpeed Enterprise web engine active. High-performance caching layers and Apache-compatible htaccess processing pipelines are enabled.';
            break;

        case 'nginx':
            $notes = $lang['FPA_SERVER_NOTE_NGINX'] ?? 'Nginx reverse-proxy server active. Standard root .htaccess configuration files are completely IGNORED. Custom routing redirects must be placed directly into the main nginx.conf blocks.';

            // Check for common proxy signature headers
            if (isset($_SERVER['HTTP_X_REAL_IP']) || isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
                $notes .= ' (Operating in Reverse-Proxy Configuration Mode Behind Edge Layer)';
            }
            break;

        case 'caddy':
            $notes = $lang['FPA_SERVER_NOTE_CADDY'] ?? 'Caddy modern web platform active. Features automated TLS certificate pipelines. Requires explicit Caddyfile directives for URL rewrites.';
            break;

        case 'lighttpd':
            $notes = $lang['FPA_SERVER_NOTE_LIGHTTPD'] ?? 'Lighttpd high-efficiency engine active. Typically utilized on low-resource hardware setups. Requires explicit mod_rewrite configuration assignments inside lighttpd.conf.';
            break;

        case 'iis':
            $notes = $lang['FPA_SERVER_NOTE_IIS'] ?? 'Microsoft IIS platform active. Core Joomla rewrites must be configured using web.config files via the URL Rewrite Module suite instead of .htaccess.';
            break;
    }

    // If php-fpm, get the fpm pool data
    $fpm_pool_data = null;
    if (strpos(strtolower(PHP_SAPI), 'fpm') !== false) {
        $fpm_pool_data = fpm_get_fpm_pool_metrics($lang);
    }

    // Package the complete payload matrix securely
    return [
        'web_server'           => $raw_software,
        'web_server_short'     => $web_server_short,
        'web_server_version'   => $server_version,
        'process_user'         => $process_user,
        'is_htaccess_enabled'  => $is_htaccess_enabled,
        'has_mod_rewrite'      => $has_mod_rewrite,
        'has_gzip_compression' => $has_gzip_compression,
        'has_cache_headers'    => $has_cache_headers,
        'loaded_modules'       => $loaded_modules, // only available if mod_php mode
        'fpm_pool_metrics'     => $fpm_pool_data,  // only available if php-fpm mode
        'notes'                => $notes,
        'web_server_encoding'  => $_SERVER['HTTP_ACCEPT_ENCODING'] ?? ($lang['FPA_TXT_NONE'] ?? 'None Specified'),
        'umask'                => sprintf('%04o', umask())
    ];
} // end: fpa_do_httpserver()

/**
 * --- Database-server Discovery Audit ---
 * Mandatory Routine: Discover the database-server configuration and setup.
 */
function fpa_do_database(): array {

    // TEMPORARY FIX: Returns a blank array to satisfy the typehint requirement
    return [];
}

/**
 * --- PHP Modules Discovery Audit ---
 * Mandatory Routine: Loops through a required and recommended list of PHP extensions and fetches
 * their installed versions.
 *
 * @param array $checklist A flat list of (required & recommended) extension names, e.g. ['openssl', 'json']
 * @param array $lang The global translation dictionary
 * @return array A keyed array containing the extension versions and their status labels
 */
function fpa_do_php(array $checklist, array $lang): array {
    $extension_report = [];

    // TODO: check the jVersion and jConfig to remove any other database or other extensions
    // Do some sanity checks first, check php version to remove unwanted / no-longer supported / needed extensions
    if (version_compare(PHP_VERSION, '7.0.0', '>')) {
        // List of legacy extensions to drop
        $legacy_extensions = ['mysql', 'mcrypt'];

        // Remove all legacy items at once
        $checklist = array_diff($checklist, $legacy_extensions);

        // Reset the numerical indexes so there are no gaps (e.g., 0, 1, 2...)
        $checklist = array_values($checklist);
    }

    // Sort alphabetically so the dashboard tables look clean
    natcasesort($checklist);

    foreach ($checklist as $ext) {
        if (extension_loaded($ext)) {
            $version        = phpversion($ext);
            $version_string = ($version && $version !== true) ? $version : ($lang['FPA_TXT_ENABLED'] ?? 'Enabled');

            $extension_report[$ext] = [
                'version'      => $version_string,
                'status_color' => 'success', // Bootstrap Green
                'status_label' => $lang['FPA_TXT_AVAILABLE'] ?? 'Available',
                'is_missing'   => false
            ];
        } else {
            $extension_report[$ext] = [
                'version'      => $lang['FPA_TXT_MISSING'] ?? 'Missing',
                'status_color' => 'warning',
                'status_label' => $lang['FPA_TXT_UNAVAILABLE'] ?? 'Unavailable',
                'is_missing'   => true
            ];
        }
    }

    return $extension_report;
} // end: fpa_do_php()

/**
 * --- PHP Directives Discovery Report ---
 * Mandatory Routine: Audits core ini configuration directives and generates a comparative matrix
 * tracking overrides across global, local, and recursive application files.
 * This scans both web-root and administrator paths for .user.ini & php.ini.
 *
 * @param array $ini_directives List of specific ini options to audit (from the blueprint array)
 * @param array $lang The global translation dictionary
 * @param string $base_path The absolute web-root path location of the FPA script
 * @return array{ini_files: array, ini_matrix: array} Balanced array payload returning discovered assets
 */
function fpa_do_ini_matrix(array $ini_directives, array $lang, string $base_path): array {

    // Establish file paths configurations for both key directory structures
    $base_path = rtrim($base_path, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR;
    $admin_path = $base_path . 'administrator' . DIRECTORY_SEPARATOR;

    $discovered_files = [
        'web_root_php_ini'  => is_file($base_path . 'php.ini') ? 'php.ini' : null,
        'web_root_user_ini' => is_file($base_path . '.user.ini') ? '.user.ini' : null,
        'admin_php_ini'     => is_file($admin_path . 'php.ini') ? 'administrator/php.ini' : null,
        'admin_user_ini'    => is_file($admin_path . '.user.ini') ? 'administrator/.user.ini' : null,
    ];


    // Fetch native/global environment settings tree from the server core memory
    $all_ini_settings = ini_get_all(null, false);
    $matrix = [];

    // Helper closure loop function to scan a text file for a specific directive configuration string line
    $parse_file_value = function(?string $file_path, string $directive): ?string {
        if (!$file_path || !is_readable($file_path)) return null;

        $handle = @fopen($file_path, 'r');
        if (!$handle) return null;

        $found_value = null;
        while (($line = fgets($handle)) !== false) {
            $line = trim($line);
            // Ignore blank lines or rows starting with standard ini comment characters (;, #)
            if ($line === '' || $line[0] === ';' || $line[0] === '#') continue;

            // Simple search lookups for: directive_name = value
            if (strncmp($line, $directive, strlen($directive)) === 0) {
                $parts = explode('=', $line, 2);
                if (count($parts) === 2 && trim($parts[0]) === $directive) {
                    // Extract value string and strip quotes if present
                    $found_value = trim(trim($parts[1]), '"\'');
                    break;
                }
            }
        }
        fclose($handle);
        return $found_value;
    };

    // Process each targeted directive option line individually
    foreach ($ini_directives as $directive => $category) {
        if (!isset($all_ini_settings[$directive])) continue;

        // Fetch absolute environment runtime TRUTH straight from memory
        $active_runtime_value = (string)ini_get($directive);

        // Extract text files configs parameter values across your target locations
        $root_local_text  = $parse_file_value($discovered_files['web_root_php_ini'], $directive);
        $root_user_text   = $parse_file_value($discovered_files['web_root_user_ini'], $directive);
        $admin_local_text = $parse_file_value($discovered_files['admin_php_ini'], $directive);
        $admin_user_text  = $parse_file_value($discovered_files['admin_user_ini'], $directive);

        // Attempt to determine the true active source
        $active_source = 'global';

        if ($admin_user_text !== null && $active_runtime_value === $admin_user_text) {
            $active_source = 'admin_user_ini';
        } elseif ($admin_local_text !== null && $active_runtime_value === $admin_local_text) {
            $active_source = 'admin_php_ini';
        } elseif ($root_user_text !== null && $active_runtime_value === $root_user_text) {
            $active_source = 'web_root_user_ini';
        } elseif ($root_local_text !== null && $active_runtime_value === $root_local_text) {
            $active_source = 'web_root_php_ini';
        }

        // Map active source style : Initialize all layout columns with a neutral fallback style
        $classes = [
            'global'            => 'text-muted',
            'admin_user_ini'    => 'text-muted',
            'admin_php_ini'     => 'text-muted',
            'web_root_user_ini' => 'text-muted',
            'web_root_php_ini'  => 'text-muted'
        ];

        // Highlight the specific column cell that won the active cascade loop!
        if (isset($classes[$active_source])) {
            $classes[$active_source] = 'bg-success-subtle text-success-emphasis fw-medium';
        }

        // Override state calculator (3 states possible)
        // State 1: Default to 'none' if absolutely no override files contain this directive
        $override_status = 'none';

        $has_any_file_text = ($root_local_text !== null || $root_user_text !== null || $admin_local_text !== null || $admin_user_text !== null);

        if ($has_any_file_text) {
            // State 2: It 'applied' successfully if the active source is one of our file layers
            if ($active_source !== 'global') {
                $override_status = 'applied';
            }
            // State 3: It 'failed' if text exists in a file but the system is stuck on the 'global' server setting
            else {
                $override_status = 'failed';
            }
        }

        // Prepare the view state properties (Maps state to final UI design tokens)
        switch ($override_status) {
            case 'applied':
                $status_text   = $lang['FPA_TXT_YES'] ?? 'YES';
                $status_color  = 'success'; // Bootstrap Green
                $tooltip_title = '';
                break;

            case 'failed':
                $status_text   = $lang['FPA_TXT_NO'] ?? 'NO';
                $status_color  = 'warning'; // Bootstrap orange
                $tooltip_title = 'A local override is not active. 1. Check the correct directive value syntax. 2. Not all directives can be overriden locally. Contact your host for further assistance.';
                break;

            case 'none':
            default:
                $status_text   = '-';
                $status_color  = 'light'; // Neutral Gray
                $tooltip_title = '';
                break;
        }

        // Package up all the properties to make the matrix item
        $matrix[$directive] = [
            'directive_name'  => $directive,
            'category'        => $category,
            'global_value'    => (string)($all_ini_settings[$directive]['global_value'] ?? ini_get($directive)),
            'web_root_local'  => $root_local_text ?: '-',
            'web_root_user'   => $root_user_text ?: '-',
            'admin_local'     => $admin_local_text ?: '-',
            'admin_user'      => $admin_user_text ?: '-',
            'active_runtime'  => $active_runtime_value ?: '-',
            'active_source'   => $active_source,
            // html layout variables
            'classes' => [
                'global'         => $classes['global'],
                'admin_user'     => $classes['admin_user_ini'],
                'admin_local'    => $classes['admin_php_ini'],
                'web_root_user'  => $classes['web_root_user_ini'],
                'web_root_local' => $classes['web_root_php_ini'],
            ],
            'override_status'  => $override_status, // Raw engine state ('applied'|'failed'|'none')
            'status_text'      => $status_text,     // The exact text label ('YES'|'NO'|'-')
            'status_color'     => $status_color,    // The matching UI status color
            'override_tooltip' => $tooltip_title
        ];

    }

    // 5. Sort the matrix: By category alphabetical, then by directive name
    // uasort keeps the directive string keys intact, which is critical for the array output
    uasort($matrix, function(array $a, array $b): int {
        // Compare the categories (security vs performance vs functionality vs compatibility)
        $category_comparison = strcmp($a['category'], $b['category']);

        if ($category_comparison !== 0) {
            return $category_comparison;
        }

        // If categories are identical, fall back to sorting by the directive name string
        return strcmp($a['directive_name'], $b['directive_name']);
    });

    // Return both files list maps and matrix components simultaneously as a combined output packet
    return [
        'ini_files'  => $discovered_files,
        'ini_matrix' => $matrix
    ];
} // end: fpa_do_ini_matrix()

/**
 * --- PHP Directive Value Sanity Checks ---
 * Mandatory Routine: Evaluates the live active runtime values of the directive matrix against
 * safe environment thresholds to flag security, performance, compatibility and
 * functionality risks.
 *
 * @param array $matrix The compiled directive matrix from fpa_do_ini_matrix()
 * @param array $lang The global translation dictionary
 * @return array The analyzed matrix now packed with sanity states and evaluation labels
 */
function fpa_do_ini_sanity(array $matrix, array $lang): array {

    // === Boundary Threshold Values ===========================================
    // Performance Limits
    $min_memory_danger      = '128M'; // Complete crash window for modern scripts
    $min_memory_warning     = '256M'; // Recommended minimum target baseline
    $min_timeout_danger     = 30;     // Seconds: Highly restrictive processing cap
    $min_timeout_warning    = 60;     // Seconds: Standard threshold safety buffer

    // Functionality Limits
    $min_upload_warning     = '32M'; // Restrictive window for extension zip files
    $min_input_vars_danger  = 1000;  // Drastic clipping boundary for permission grids
    $min_input_vars_warning = 2000;  // Recommended threshold for complex multi-field forms
    // =========================================================================

    // Pre-calculate byte conversions once right here before the foreach loop kicks off.
    $danger_mem_bytes  = fpa_convert_to_bytes_helper($min_memory_danger);
    $warning_mem_bytes = fpa_convert_to_bytes_helper($min_memory_warning);
    $warning_up_bytes  = fpa_convert_to_bytes_helper($min_upload_warning);

    // Loop through each compiled directive row to run our threshold checks
    foreach ($matrix as $directive => $data) {
        $active_val   = $data['active_runtime'];
        $sanity_state = 'success';
        $sanity_msg   = '';

        switch ($directive) {
            // --- Security Validations ---
            case 'display_errors':
            case 'allow_url_include':
                if (filter_var($active_val, FILTER_VALIDATE_BOOLEAN) === true || $active_val === '1' || strtolower($active_val) === 'on') {
                    $sanity_state = 'danger';
                    $sanity_msg   = ($directive === 'display_errors')
                        ? ($lang['FPA_RULE_ERR_DISPLAY_ERRORS'] ?? 'Production Vulnerability: Leaking raw backend exceptions to public users.')
                        : ($lang['FPA_RULE_ERR_URL_INCLUDE'] ?? 'Critical Risk: Remote File Inclusion vulnerabilities are uninhibited.');
                }
                break;

            case 'session.cookie_httponly':
                if (filter_var($active_val, FILTER_VALIDATE_BOOLEAN) === false || $active_val === '0' || strtolower($active_val) === 'off' || $active_val === '') {
                    $sanity_state = 'warning';
                    $sanity_msg   = $lang['FPA_RULE_WARN_HTTPONLY'] ?? 'Session Risk: Cross-Site Scripting (XSS) protection token is disabled.';
                }
                break;

            case 'request_order':
                // Clean the string to uppercase and strip any accidental whitespace
                $cleaned_order = strtoupper(trim($active_val));

                // If it explicitly states 'GP' or is completely missing 'C' (Cookies)
                if ($cleaned_order !== '' && strpos($cleaned_order, 'C') === false) {
                    $sanity_state = 'danger';
                    $sanity_msg   = $lang['FPA_RULE_ERR_REQUEST_ORDER'] ?? 'Broken Request Order: Cookie variables are stripped from the global $_REQUEST array. This can break session handling and user authentication modules.';
                }
                break;

            // --- Performance Validations ---
            case 'memory_limit':
                $bytes = fpa_convert_to_bytes_helper($active_val);
                if ($bytes !== -1) {
                    if ($bytes < $danger_mem_bytes) {
                        $sanity_state = 'danger';
                        $sanity_msg   = ($lang['FPA_RULE_ERR_MEM_CRITICAL'] ?? 'Fatal Performance Risk: Total memory falls below minimum limits: ') . $min_memory_danger;
                    } elseif ($bytes < $warning_mem_bytes) {
                        $sanity_state = 'warning';
                        $sanity_msg   = ($lang['FPA_RULE_WARN_MEM_LOW'] ?? 'Sub-optimal Memory: Threshold sits below the recommended allocation baseline: ') . $min_memory_warning;
                    }
                }
                break;

            case 'max_execution_time':
            case 'max_input_time':
                $time_val = (int)$active_val;
                if ($time_val > 0 && $time_val < $min_timeout_danger) {
                    $sanity_state = 'danger';
                    $sanity_msg   = ($lang['FPA_RULE_ERR_TIMEOUT'] ?? 'Execution Timeout: Script processing window sits below the danger cap of ') . $min_timeout_danger . 's';
                } elseif ($time_val > 0 && $time_val < $min_timeout_warning) {
                    $sanity_state = 'warning';
                    $sanity_msg   = ($lang['FPA_RULE_WARN_TIMEOUT'] ?? 'Low Timeout: Suggest scaling limits up to the recommended safety buffer: ') . $min_timeout_warning . 's';
                }
                break;

            // --- Functionality Validations ---
            case 'upload_max_filesize':
                if (fpa_convert_to_bytes_helper($active_val) < $warning_up_bytes) {
                    $sanity_state = 'warning';
                    $sanity_msg   = ($lang['FPA_RULE_WARN_UPLOAD_SIZE'] ?? 'Restrictive Upload Window: Size configurations fall below the recommended ') . $min_upload_warning;
                }
                break;

            case 'post_max_size':
                $upload_bytes = fpa_convert_to_bytes_helper(ini_get('upload_max_filesize'));
                $post_bytes   = fpa_convert_to_bytes_helper($active_val);
                if ($post_bytes !== -1 && $upload_bytes !== -1 && $post_bytes < $upload_bytes) {
                    $sanity_state = 'danger';
                    $sanity_msg   = $lang['FPA_RULE_ERR_POST_MISMATCH'] ?? 'Misconfigured Sizes: Form posting size rules sit below file upload limits. Large uploads will drop data silently.';
                }
                break;

            case 'max_input_vars':
                $vars_val = (int)$active_val;
                if ($vars_val < $min_input_vars_danger) {
                    $sanity_state = 'danger';
                    $sanity_msg   = ($lang['FPA_RULE_ERR_INPUT_VARS'] ?? 'Critical Field Cap: Variable limits fall below the absolute minimum of ') . $min_input_vars_danger;
                } elseif ($vars_val < $min_input_vars_warning) {
                    $sanity_state = 'warning';
                    $sanity_msg   = ($lang['FPA_RULE_WARN_INPUT_VARS'] ?? 'Sub-optimal Field Cap: Suggest scaling variables up to the recommended ') . $min_input_vars_warning;
                }
                break;
        }

        // Inject calculated sanity states back into the matrix row
        $matrix[$directive]['sanity_state']   = $sanity_state;
        $matrix[$directive]['sanity_message'] = $sanity_msg;
    }

    $all_sane      = true;
    $danger_count  = 0;
    $warning_count = 0;

    foreach ($matrix as $directive => $data) {
        if (isset($data['sanity_state'])) {
            if ($data['sanity_state'] === 'danger') {
                $danger_count++;
                $all_sane = false;
            } elseif ($data['sanity_state'] === 'warning') {
                $warning_count++;
                $all_sane = false;
            }
        }
    }

    // Wrap the matrix rows and global counters together
    return [
        'all_sane'      => $all_sane,
        'danger_count'  => $danger_count,
        'warning_count' => $warning_count,
        'results'       => $matrix
    ];
} // end: fpa_do_ini_sanity()

/**
 * --- PHP Memory Usage/Footprint ---
 * Mandatory Routine: Audits live memory usage parameters of the active running script execution.
 * Measures live usage against the server's absolute configuration limit.
 *
 * @param array $lang The global translation dictionary
 * @return array Presentation dataset tracking live resource footprints
 */
function fpa_do_php_memory_footprint(array $lang): array {

    // --- Percentage Threshold Boundaries ---
    $threshold_warning = 70; // Trigger a warning alert if memory exceeds 70%
    $threshold_danger  = 85; // Trigger a high-risk danger alert if memory exceeds 85%
    // =========================================================================

    $limit_str = ini_get('memory_limit');

    // Fallback parser if memory limit is unlimited (-1)
    $limit_bytes = (int)$limit_str === -1 ? -1 : fpa_convert_to_bytes_helper($limit_str);

    $current_bytes = memory_get_usage(true);
    $peak_bytes    = memory_get_peak_usage(true);

    $usage_percentage = 0;
    $sanity_state     = 'success';
    $sanity_message   = '';

    if ($limit_bytes > 0) {
        $usage_percentage = (int)round(($peak_bytes / $limit_bytes) * 100);

        // Three state evalulation
        if ($usage_percentage >= $threshold_danger) {
            $sanity_state   = 'danger'; // High-risk danger profile
            $sanity_message = ($lang['FPA_RULE_ERR_RAM_EXHAUSTION'] ?? 'Critical Resource Saturation: The script engine has breached the maximum safety boundary of ') . $threshold_danger . '%';
        } elseif ($usage_percentage >= $threshold_warning) {
            $sanity_state   = 'warning'; // Sub-optimal warning profile
            $sanity_message = ($lang['FPA_RULE_WARN_RAM_EXHAUSTION'] ?? 'Elevated Memory Footprint: Active script resource usage has crossed the threshold boundary of ') . $threshold_warning . '%';
        }
    }

    // Return the responses and status
    return [
        'limit_raw'        => $limit_str,
        // Convert integers to human-readable strings via our formatting helper
        'current_usage'    => fpa_format_bytes_display_helper($current_bytes),
        'peak_usage'       => fpa_format_bytes_display_helper($peak_bytes),
        'usage_percentage' => $usage_percentage,
        'sanity_state'     => $sanity_state,      // Outputs 'success' | 'warning' | 'danger'
        'sanity_message'   => $sanity_message
    ];
} // end: fpa_do_php_memory_footprint()

/**
 * --- PHP TMP Folder Check ---
 * Mandatory Routine: Resolves and validates the active write permissions configuration on
 * PHP's temporary staging folder layer used for tracking file updates.
 *
 * @param array $lang The global translation dictionary
 * @return array Status array tracking path accessibility rules
 */
function fpa_do_php_upload_tmp_audit(array $lang): array {
    // Determine any custom configuration directive, falling back cleanly to standard system wrappers
    $tmp_dir = ini_get('upload_tmp_dir') ?: sys_get_temp_dir();

    $is_writable = is_dir($tmp_dir) && is_writable($tmp_dir);

    $sanity_state   = $is_writable ? 'success' : 'danger';
    $sanity_message = '';
    $ui_alert       = null;

    if (!$is_writable) {
        $sanity_message = $lang['FPA_RULE_ERR_TMP_DIR_LOCKED'] ?? 'Upload Staging Blocked: PHP temporary scratchpad folder is completely unwriteable or locked out.';

        $ui_alert = [
            'id'        => 'tmp_dir_locked_alert',
            'type'      => 'danger',
            'text'      => 'Critical: PHP Upload Temporary Directory Is Not Writable.',
            'solution'  => 'Your upload path (' . htmlspecialchars($tmp_dir) . ') lacks permission attributes. File uploads and component installation frameworks will crash. Contact your web host provider to restore write access boundaries.',
            'target_id' => 'notification-wrapper'
        ];
    }

    // Tie the responses together with the state
    return [
        'path_location'  => $tmp_dir,
        'is_writable'    => $is_writable,
        'status_text'    => $is_writable ? ($lang['FPA_TXT_WRITABLE'] ?? 'Writable') : ($lang['FPA_TXT_UNWRITABLE'] ?? 'Unwritable'),
        'sanity_state'   => $sanity_state,
        'sanity_message' => $sanity_message,
        'ui_alert'       => $ui_alert
    ];
} // end: fpa_do_php_upload_tmp_audit()

/**
 * --- Compatibility Analysis ---
 * Mandatory Routine: With some basic host information we may be able to achieve a comparitive
 * analysis of the environment and joomla minimum requirements, if an instance
 * is found though, we can perform a number of compatibility checks for the actual
 * installed instance version.
 */
function fpa_do_compatibility(): array {

    // TEMPORARY FIX: Returns a blank array to satisfy the typehint requirement
    return [];
} // end: fpa_do_compatibility()

/**
 * --- Key Metric Dashboard Calculations ---
 * Mandatory Routine: Processes environment checkpoints to calculate percentage health scores
 * across four distinct architectural pillars, compiling a final cumulative rating.
 *
 * @param array $fpa_results The current working master array data structure
 * @param array $lang The global translation dictionary
 * @return array The completed results array now containing calculated metrics
 */
function fpa_do_keymetrics(array $fpa_results, array $lang): array {
    // 1. Define baseline counter tracks
    $categories = [
        'security'      => ['total' => 0, 'passed' => 0],
        'performance'   => ['total' => 0, 'passed' => 0],
        'functionality' => ['total' => 0, 'passed' => 0],
        'compatibility' => ['total' => 0, 'passed' => 0]
    ];

    // 2. Count matrix table checks
    if (!empty($fpa_results['php']['data']['ini_matrix'])) {
        foreach ($fpa_results['php']['data']['ini_matrix'] as $row) {
            $cat = $row['category'];
            if (isset($categories[$cat])) {
                $categories[$cat]['total']++;
                if ($row['sanity_state'] === 'success') {
                    $categories[$cat]['passed']++;
                }
            }
        }
    }

    // 3. Count mandatory required extensions (Maps to compatibility)
    if (!empty($fpa_results['php']['data']['required_extensions'])) {
        foreach ($fpa_results['php']['data']['required_extensions'] as $ext) {
            $categories['compatibility']['total']++;
            if ($ext['version'] !== ($lang['FPA_TXT_MISSING'] ?? 'Missing')) {
                $categories['compatibility']['passed']++;
            }
        }
    }

    // 4. Incorporate Optional Network & DNS Security Audit results
    if (!empty($fpa_results['dns_security']['data']['rows'])
        && $fpa_results['dns_security']['data']['rows']['status'] === 'executed') {
        $dns = $fpa_results['dns_security']['data'];

        // Aggregate potential DNS or routing flaws straight into Security math
        $categories['security']['total'] += ($dns['danger_count'] + $dns['warning_count']);
    }

    // 5. Incorporate active hardware PHP-FPM process pool metrics
    if (!empty($fpa_results['httpserver']['data']['fpm_pool_metrics'])) {
        $fpm = $fpa_results['httpserver']['data']['fpm_pool_metrics'];

        // Deduct performance points if workers are completely exhausted
        if ($fpm['total_workers'] > 0 && $fpm['max_reached'] >= $fpm['total_workers']) {
            $categories['performance']['total']++;
        }

        // Deduct performance points if slow requests are actively logged
        if ($fpm['slow_requests'] > 0) {
            $categories['performance']['total']++;
        }
    }

    // 6. Deduct Security scores for permissions issues
    if (!empty($fpa_results['corefolders']['data'])) {
        $core_data = $fpa_results['corefolders']['data'];

        // Add permissions failures to the Security Pillar denominator tally
        $categories['security']['total'] += ($core_data['danger_count'] + $core_data['warning_count']);
    }

    if (!empty($fpa_results['permissions']['data'])) {
        $ext_data = $fpa_results['permissions']['data'];
        $categories['security']['total'] += ($ext_data['danger_count'] + $ext_data['warning_count']);
    }

    $report = [];
    $cumulative_percentage_sum = 0;

    // 6. Calculate individual pillar percentages and map color-token bands
    foreach ($categories as $name => $counts) {
        $pct = ($counts['total'] > 0)
            ? (int)round(($counts['passed'] / $counts['total']) * 100)
            : 100;

        $cumulative_percentage_sum += $pct;

        // Dynamic context thresholds: danger<=15%, warning<=75%, info<=90%
        if ($pct <= 15) {
            $color = 'danger';
        } elseif ($pct <= 75) {
            $color = 'warning';
        } elseif ($pct <= 90) {
            $color = 'info';
        } else {
            $color = 'success';
        }

        $report[$name] = [
            'label'        => strtoupper($name),
            'percentage'   => $pct,
            'status_color' => $color
        ];
    }

    // 7. Calculate Total Stack Health Core (Mean aggregate index)
    $health_score = (int)round($cumulative_percentage_sum / 4);

    // Evaluate explicit grade tiers and assign detailed status text descriptions
    if ($health_score >= 96) {
        $grade = 'A+';
        $health_color = 'success';
        $description = $lang['FPA_GRADE_DESC_APLUS'] ?? 'Excellent. Full environment compliance verified. Joomla will execute at maximum performance with zero architectural bottlenecks.';
    } elseif ($health_score >= 90) {
        $grade = 'A';
        $health_color = 'success';
        $description = $lang['FPA_GRADE_DESC_A'] ?? 'Optimal. Server satisfies all core prerequisites. Joomla will run smoothly, though minor configuration tweaks could optimize performance.';
    } elseif ($health_score >= 80) {
        $grade = 'B';
        $health_color = 'info';
        $description = $lang['FPA_GRADE_DESC_B'] ?? 'Good. Joomla will boot and run, but sub-optimal allocations or missing recommended extensions may degrade processing speeds.';
    } elseif ($health_score >= 70) {
        $grade = 'C';
        $health_color = 'warning';
        $description = $lang['FPA_GRADE_DESC_C'] ?? 'Caution. Reduced functionality risk. Restricted execution limits or low field variables could crash heavy form saves and backend updates.';
    } elseif ($health_score >= 50) {
        $grade = 'D';
        $health_color = 'warning';
        $description = $lang['FPA_GRADE_DESC_D'] ?? 'Unstable. High risk of operation failure. Restrictive upload or memory limits will block extension installations and patch updates.';
    } elseif ($health_score >= 25) {
        $grade = 'E';
        $health_color = 'warning';
        $description = $lang['FPA_GRADE_DESC_E'] ?? 'Critical. Server environment is severely misconfigured. Expect persistent runtime crashes and structural database connection blocks.';
    } else {
        $grade = 'F';
        $health_color = 'danger';
        $description = $lang['FPA_GRADE_DESC_F'] ?? 'Incompatible. Absolute system failure. Vital core PHP extensions are completely missing. Joomla cannot execute or install in this environment.';
    }

    // SVG Horseshoe graph geometry configuration angles
    $dash_array  = 352;
    $dash_offset = (int)round($dash_array - (($health_score / 100) * $dash_array));

    // Map data points directly to subkeys to keep your meta array safe
    $fpa_results['key_metrics']['pillars'] = $report;
    $fpa_results['key_metrics']['health'] = [
        'score'        => $health_score,
        'grade'        => $grade,
        'status_color' => $health_color,
        'description'  => $description,
        'dash_array'   => $dash_array,
        'dash_offset'  => $dash_offset
    ];

    return $fpa_results;
} // end: fpa_do_keymetrics()
// =============================================================================
//  END SUBSECTION: MANDATORY RUNTIME DIAGNOSTIC FUNCTIONS
// =============================================================================


// =============================================================================
//  END SUBSECTION: MANDATORY RUNTIME DIAGNOSTIC FUNCTIONS
// =============================================================================


/*
 * =============================================================================
 *  SUBSECTION: HYBRID / DUAL-PURPOSE FUNCTIONS
 * =============================================================================
 *  COMPLIANCE LAYER: PER 3.0 / PSR-12 Global Procedural Workspace Paradigm
 *
 *  These versatile modules serve double duty across the application lifecycle.
 *  They execute as a mandatory baseline check during Phase 1 to audit core
 *  system pathways, but can be safely re-triggered during Phase 2 as an
 *  optional deep-dive scanner if requested by settings panel checkboxes.
 * =============================================================================
 */

/**
 * --- Permissions Audit ---
 * Hybrid Routine: Audits targeted directory paths for architectural presence,
 * core operational writeability, advanced POSIX bitmasks, and system process
 * user ownership alignment across local sandboxes and production environments.
 *
 * @param array $fpa_results Master diagnostic tracking data structure
 * @param array $lang Global translation dictionary string matrix
 * @param array $target_paths Flat list of absolute directory paths to inspect
 * @param array $exclude_list Optional paths to skip during recursive passes
 * @param int $max_errors Safe ceiling to abort scanning on flooded systems
 * @return array Presentation dataset tracking permission compliance metrics
 */
function fpa_do_permissions(
    array &$fpa_results,
    array $lang,
    array $target_paths,
    array $exclude_list = [],
    int $max_errors = 50
): array {
    $report = [
        'inspected_count' => 0,
        'failed_count'    => 0,
        'danger_count'    => 0,
        'warning_count'   => 0,
        'aborted'         => false,
        'folders'         => [] // Will store our paths as an associative map
    ];

    $is_windows   = fpa_is_windows_helper($fpa_results);
    $process_user = $fpa_results['ref']['data']['php']['process_user'] ?? 'unknown';

    foreach ($target_paths as $path) {
        if ($report['failed_count'] >= $max_errors) {
            $report['aborted'] = true;
            break;
        }

        if (in_array($path, $exclude_list, true)) {
            continue;
        }

        $report['inspected_count']++;

        $relative_path = str_replace(dirname(__FILE__), '', $path);
        if ($relative_path === '') {
            $relative_path = '/';
        }

        $exists = file_exists($path);

        if (!$exists) {
            $report['failed_count']++;
            $report['danger_count']++;

            //$report['folders'][] = [
            //    'path'        => $relative_path,
            //$report['data']['rows']['folders'][$relative_path] = [
            $report['rows']['folders'][$relative_path] = [
                'exists'      => ['value' => false, 'text' => $lang['FPA_TXT_NO'] ?? 'No', 'color' => 'danger'],
                'owner'       => '-',
                'group'       => '-',
                'mode'        => '----',
                'mode_color'  => 'danger',
                'is_readable' => ['value' => false, 'text' => $lang['FPA_TXT_NO'] ?? 'No', 'color' => 'danger'],
                'is_owner_w'  => ['value' => false, 'text' => $lang['FPA_TXT_NO'] ?? 'No', 'color' => 'muted'],
                'is_group_w'  => ['value' => false, 'text' => $lang['FPA_TXT_NO'] ?? 'No', 'color' => 'muted'],
                'is_world_w'  => ['value' => false, 'text' => $lang['FPA_TXT_NO'] ?? 'No', 'color' => 'muted'],
                'is_sane'     => ['value' => false, 'text' => $lang['FPA_TXT_NO'] ?? 'No', 'color' => 'danger'],
                'owner_match' => ['value' => false, 'text' => $lang['FPA_TXT_NO'] ?? 'No', 'color' => 'muted'],
                'has_suid'    => ['value' => false, 'text' => $lang['FPA_TXT_NO'] ?? 'No', 'color' => 'muted'],
                'has_guid'    => ['value' => false, 'text' => $lang['FPA_TXT_NO'] ?? 'No', 'color' => 'muted'],
                'has_sticky'  => ['value' => false, 'text' => $lang['FPA_TXT_NO'] ?? 'No', 'color' => 'muted'],
                'row_class'   => 'danger-subtle',
                'tooltip'     => $lang['FPA_PERM_ERR_MISSING'] ?? 'Critical: Target folder is missing.'
            ];

            $fpa_results['issue_queue']['data']['rows'][] = [
                'id'        => 'perm_missing_' . md5($path),
                'type'      => 'danger',
                'text'      => 'Critical: Missing Required Core Folder.',
                'solution'  => 'The path (' . htmlspecialchars($relative_path) . ') is missing. Re-upload this directory via your file manager to restore stability.',
                'target_id' => 'fpa_issues_drawer'
            ];
            continue;
        }

        $is_readable   = is_readable($path);
        $is_writable   = is_writable($path);
        $is_executable = is_executable($path);

        $owner_name  = 'unknown';
        $group_name  = 'unknown';
        $owner_match = false;

        if (function_exists('posix_getpwuid') && function_exists('fileowner')) {
            $owner_id   = @fileowner($path);
            $owner_info = $owner_id !== false ? @posix_getpwuid($owner_id) : null;
            $owner_name = $owner_info ? $owner_info['name'] : (string)$owner_id;

            $group_id   = @filegroup($path);
            $group_info = $group_id !== false ? @posix_getgrgid($group_id) : null;
            $group_name = $group_info ? $group_info['name'] : (string)$group_id;

            if ($owner_name !== 'unknown' && $owner_name === $process_user) {
                $owner_match = true;
            }
        } else {
            $owner_name  = $process_user;
            $group_name  = 'N/A';
            $owner_match = true;
        }

        $perms_raw   = @fileperms($path);
        $mode_octal = $perms_raw ? sprintf('%04o', $perms_raw & 07777) : '0000';
        $mode_short  = substr($mode_octal, -3);

        $is_owner_w  = (bool)($perms_raw & 000200);
        $is_group_w  = (bool)($perms_raw & 000020);
        $is_world_w  = (bool)($perms_raw & 000002);

        $has_suid    = (bool)($perms_raw & 004000);
        $has_guid    = (bool)($perms_raw & 002000);
        $has_sticky  = (bool)($perms_raw & 001000);

        $sanity_state = 'success';
        $tooltip      = $lang['FPA_PERM_TOOLTIP_OK'] ?? 'Secure and healthy folder settings.';

        // If it's Microsoft, nothing shows up correctly/properly due to their
        // proprietary ACL's, so we just check for effective rights on Windows.
        if ($is_windows) {
            // Basic rights, best we can do is determine if we access and can we write to it?
            if (!$is_writable) {
                $sanity_state = 'danger';
                $tooltip      = $lang['FPA_PERM_TOOLTIP_WIN_LOCKED'] ??
                    'Critical: Path unwritable on Windows.';
            }
            $mode_short   = 'N/A';
            $perms_octal  = 'N/A';
            $has_suid     = false; $has_guid = false; $has_sticky = false;
        } else {
        // Every other OS in the known real sane world reacts the same way and
        // delivers hard actual & effective rights for us to work with.

            // Simplistic Core I/O Accessibility Triggers (can we do the basics?)
            if (!$is_readable || !$is_executable) {
                $sanity_state = 'danger';
                $tooltip      = $lang['FPA_PERM_TOOLTIP_LOCKED'] ??
                    'Critical: Directory unreadable or unexecutable.';
            } elseif (!$is_writable) {
                $sanity_state = 'danger';
                $tooltip      = $lang['FPA_PERM_TOOLTIP_UNWRITABLE'] ??
                    'Critical: Folder is unwritable by web server.';
            }

            // High-Risk Special Privileges Elevation Bits
            // SUID on a folder is non-functional but points to an attack footprint
            elseif ($has_suid) {
                $sanity_state = 'danger';
                $tooltip      = $lang['FPA_PERM_TOOLTIP_SUID_ACTIVE'] ??
                    'Critical Security Anomaly: SUID bit active. While ignored ' .
                    'on directories by Unix kernels, its presence indicates ' .
                    'unauthorized filesystem manipulation or an attack footprint.';
            }

            // SGID actively forces downward group inheritance
            elseif ($has_guid) {
                $sanity_state = 'warning'; // Warning or danger based on severity
                $tooltip      = $lang['FPA_PERM_TOOLTIP_GUID_ACTIVE'] ??
                    'Security Notice: SGID bit active. All new files created ' .
                    'here will forcefully inherit this parent folder\'s group ' .
                    'ownership. Common in shared cloud arrays, but check shared hosts.';
            }

            // Standard: Octal Vulnerability Checks
            elseif ($mode_short === '777') {
                $sanity_state = 'danger';
                $tooltip      = $lang['FPA_PERM_TOOLTIP_777'] ??
                    'Critical: World-writable (777) security leak. This modeset ' .
                    'should be corrected immediately due to extreme risk of host ' .
                    'and site compromise. Many hosts will raise a White-Screen/Error ' .
                    'for this condition.';
            } elseif ($mode_short === '757') {
                $sanity_state = 'danger';
                $tooltip      = $lang['FPA_PERM_TOOLTIP_757'] ??
                    'Critical: Other-writable (757). Major risk on all public ' .
                    'hosting platforms (Shared, VPS, Dedicated & Cloud).';
            } elseif ($mode_short === '775') {
                $sanity_state = 'warning';
                $tooltip      = $lang['FPA_PERM_TOOLTIP_775'] ??
                    'Warning: Group writable (775). Risk on shared hosting platforms, ' .
                    'but may be acceptable on some Cloud platforms with development ' .
                    'or staging functionality.';
            }

            // Secure Extra Restriction Boundary Bit
            elseif ($has_sticky) {
                $sanity_state = 'info';
                $tooltip      = $lang['FPA_PERM_TOOLTIP_STICKY_ACTIVE'] ??
                    'Secured Path: The Sticky Bit is active. Whilst this is ' .
                    'unusual, it does restrict directory file deletion strictly ' .
                    'to the genuine file owner and is not a concern.';
            }

            // Final Baseline: Other Funky Mode Fallback Check
            elseif ($mode_short !== '755') {
                $sanity_state = 'warning';
                $tooltip      = $lang['FPA_PERM_TOOLTIP_NON_STANDARD'] ??
                    'Warning: Non-standard permissions were detected but ' .
                    'further investigation is required to fully assess implications.';
            }
        }

        if ($sanity_state === 'danger') {
            $report['failed_count']++;
            $report['danger_count']++;

            $fpa_results['issue_queue']['data']['rows'][] = [
                'id'        => 'perm_failure_' . md5($path),
                'type'      => 'danger',
                'text'      => 'Critical: Security Risk or Write Block on ' . htmlspecialchars($relative_path),
                'solution'  => 'Directory configuration error (' . $mode_short . '). ' . $tooltip . ' Reset to 0755 immediately.',
                'target_id' => 'fpa_issues_drawer'
            ];
        } elseif ($sanity_state === 'warning') {
            $report['failed_count']++;
            $report['warning_count']++;
        }

        //$report['rows']['folders'][$relative_path] = [
        //$report['rows']['folders'][$relative_path] = [
        $report['folders'][$relative_path] = [
            //'path'        => $relative_path,
            'exists'      => ['value' => true, 'text' => $lang['FPA_TXT_YES'] ?? 'Yes', 'color' => 'success'],
            'owner'       => $owner_name,
            'group'       => $group_name,
            //'mode'        => $mode_short,
            'mode'        => $mode_octal,
            'mode_color'  => $sanity_state,
            'is_readable' => ['value' => $is_readable, 'text' => $is_readable ? 'Yes' : 'No', 'color' => $is_readable ? 'success' : 'danger'],
            'is_owner_w'  => ['value' => $is_owner_w, 'text' => $is_owner_w ? 'Yes' : 'No', 'color' => $is_owner_w ? 'success' : 'muted'],
            'is_group_w'  => ['value' => $is_group_w, 'text' => $is_group_w ? 'Yes' : 'No', 'color' => $is_group_w ? 'warning' : 'success'],
            'is_world_w'  => ['value' => $is_world_w, 'text' => $is_world_w ? 'Yes' : 'No', 'color' => $is_world_w ? 'danger' : 'success'],
            'is_sane'     => ['value' => ($sanity_state === 'success' || $sanity_state === 'info'), 'text' => ($sanity_state === 'success' || $sanity_state === 'info') ? 'Yes' : 'No', 'color' => ($sanity_state === 'success' || $sanity_state === 'info') ? 'success' : $sanity_state],
            'owner_match' => ['value' => $owner_match, 'text' => $owner_match ? 'Yes' : 'No', 'color' => $owner_match ? 'success' : 'warning'],
            'has_suid'    => ['value' => $has_suid, 'text' => $has_suid ? 'Yes' : 'No', 'color' => $has_suid ? 'danger' : 'success'],
            'has_guid'    => ['value' => $has_guid, 'text' => $has_guid ? 'Yes' : 'No', 'color' => $has_guid ? 'warning' : 'success'],
            'has_sticky'  => ['value' => $has_sticky, 'text' => $has_sticky ? 'Yes' : 'No', 'color' => $has_sticky ? 'info' : 'success'],
            'row_class'   => $sanity_state,
            'tooltip'     => $tooltip
        ];
    } // end foreach loop

    return $report;
} // end function fpa_do_permissions()


// =============================================================================
//  END SUBSECTION: HYBRID / DUAL-PURPOSE FUNCTIONS
// =============================================================================



/*
 * =============================================================================
 *  SUBSECTION: OPTIONAL RUNTIME DIAGNOSTIC FUNCTIONS
 * =============================================================================
 *  COMPLIANCE: PER 3.0 / PSR-12 Functional Paradigm Braced Syntax Block
 *
 *  These conditional modules are deferred by default. They execute exclusively
 *  when explicitly registered inside the `$fpa_active_tests_to_run` array.
 *
 *  Execution states are dynamically requested and updated via interactive check
 *  switches submitted through the offcanvas FPA Runtime Settings panel.
 * =============================================================================
 */

/**
 * --- DNS Audit ---
 * Optional Routine: Audits domain text record security postures, checks for
 * reverse DNS IP mismatches, and logs external third-party platform
 * verification tags.
 *
 * Deferred execution: Triggers only when explicitly registered inside the
 * active tests array.
 *
 * @param array $fpa_results The current working master array data structure
 * @param array $lang The global translation dictionary
 * @return array Presentation dataset tracking complete network security
 */
function fpa_audit_dns_security(array $fpa_results, array $lang): array {
    $domain = $fpa_results['ref']['data']['network']['domain_name'] ?? 'localhost';

    // =========================================================================
    // ⚙️ INITIALIZATION BOUNDARY & DEVELOPMENT SANDBOX ESCAPE
    // =========================================================================
    // Reuses your central helper function to gracefully bypass local machines
    if (fpa_is_localhost_helper($fpa_results)) {
        return [
            'status'        => 'skipped',
            'sanity_state'  => 'info',
            'summary_notes' => $lang['FPA_DNS_SKIPPED_LOCALHOST'] ?? 'Network audit bypassed: Local sandbox development addresses lack public authoritative DNS routing records.'
        ];
    }

    // 1. Process your single-query TXT manifest utility loader
    $manifest = fpa_get_domain_txt_manifest($domain);

    // 2. Run the Reverse DNS Pointer (PTR) IP Mismatch Audit
    $domain_ip  = $fpa_results['ref']['data']['network']['domain_ip'] ?? '0.0.0.0';
    $reverse_ns = @gethostbyaddr($domain_ip);

    $is_ip_mismatch = false;
    if ($reverse_ns !== $domain_ip && $reverse_ns !== false) {
        $resolved_back_ip = @gethostbyname($reverse_ns);
        if ($resolved_back_ip !== $domain_ip) {
            $is_ip_mismatch = true;
        }
    }

    // 3. Dynamic Threshold Risk Matrix Scoring Evaluation
    $sanity_state   = 'success';
    $summary_notes  = '';
    $danger_count   = 0;
    $warning_count  = 0;

    // =========================================================================
    // 🚨 SCORING RULES & INTEGRATION PASSTHROUGH
    // =========================================================================
    if ($manifest['has_spf'] === false) {
        $warning_count++;
        $sanity_state = 'warning';
        $summary_notes .= ($lang['FPA_DNS_RISK_NO_SPF'] ?? 'Missing SPF Record: System emails risk being flagged as spam or dropped completely by receiver mail filters.') . ' ';
    }

    if ($manifest['has_dmarc'] === false) {
        $warning_count++;
        // If SPF is also missing, scale the threat priority up to danger
        $sanity_state  = ($sanity_state === 'warning') ? 'danger' : 'warning';
        $summary_notes .= ($lang['FPA_DNS_RISK_NO_DMARC'] ?? 'Missing DMARC Spoof Shield: Domain lacks mail authentication enforcement rule parameters.') . ' ';
    }

    if ($is_ip_mismatch === true) {
        $danger_count++;
        $sanity_state = 'danger';
        $summary_notes .= ($lang['FPA_DNS_RISK_IP_MISMATCH'] ?? 'Network IP Mismatch Discovered: Your domain resolves to an IP address that does not map back to your underlying host container.');
    }

    return [
        'status'             => 'executed',
        'domain_checked'     => $domain,
        'has_spf'            => $manifest['has_spf'],
        'spf_record'         => $manifest['spf_record'],
        'has_dmarc'          => $manifest['has_dmarc'],
        'dmarc_record'       => $manifest['dmarc_record'],
        'is_ip_mismatch'     => $is_ip_mismatch,
        'reverse_ptr_record' => $reverse_ns ?: 'None Configured',
        'verifications'       => $manifest['verifications'],
        'danger_count'       => $danger_count,
        'warning_count'      => $warning_count,
        'sanity_state'       => $sanity_state,
        'summary_notes'      => $summary_notes ?: ($lang['FPA_DNS_ALL_SECURE'] ?? 'Excellent. Full domain text verification layers and reverse pointer configurations are verified and operational.')
    ];
} // end: fpa_audit_dns_security()

/**
 * --- PHP Extended Audit ---
 * Optional Routine: Scans the server for all currently loaded PHP extensions,
 * completely excluding the mandatory required or recommended extensions to
 * prevent duplicate data displays.
 *
 * @param array $required_extensions The list of mandatory core extensions to exclude.
 * @return array A dynamically built, alphabetical list of extra extensions and their versions.
 */
function fpa_audit_php_extended(array $required_extensions): array {
    $extended_report = [];

    // Fetch absolutely every extension loaded on this specific server instance
    $all_loaded = get_loaded_extensions();

    // Instantly subtract the required core list from the total list
    $extra_extensions = array_diff($all_loaded, $required_extensions);

    // Sort alphabetically so the dashboard tables look clean and professional
    natcasesort($extra_extensions);

    // Loop through the remaining extra extensions to extract version data
    foreach ($extra_extensions as $extension_name) {

        // Strategy A: Try standard phpversion()
        $version = phpversion($extension_name);

        // Strategy B: If phpversion() returns false/empty, extract via Reflection
        if (empty($version)) {
            try {
                $reflection = new ReflectionExtension($extension_name);
                $version   = $reflection->getVersion();
            } catch (Exception $e) {
                $version   = '';
            }
        }

        // Strategy C: Fall back to the core PHP version if it's a bundled component (e.g. Core, standard)
        if (empty($version)) {
            $version = phpversion();
        }

        // Strategy D: Absolute Catch-All, if no version info still unavailable, just state it is enabled
        $version_string = ($version && $version !== true) ? $version : 'Enabled';

        $extended_report[$extension_name] = [
            'version'      => $version_string,
            'status_color' => 'secondary',
            'status_label' => 'Optional Module'
        ];
    }

    // Return list of (other) loaded php extensions
    return $extended_report;
} // end: fpa_audit_php_extended()

/**
 * --- Database Extended Audit ---
 * Optional Routine: If an Joomla instance is found and confgured we can access
 * the database credentials to retrieve extended table and stats info, otherwise,
 * even if selected this function will be unable to return very much, if any,
 * useful data.
 */
function fpa_audit_database_extended(): array {

    // TEMPORARY FIX: Returns a blank array to satisfy the typehint requirement
    return [];
} // end: fpa_audit_extended_database()

/**
 * TODO: MAY BE REPLACED BY A DUAL PURPOSE PERMISSIONS FUNCTION
 * --- Permissions Audit ---
 * Optional Routine: If an instance is found, we run a recursive permissions
 * (modeset) audit on the file-system, excluding Joomla Core Folders. However, if
 * more than $max_violations is met, the routine reports it found an excessive
 * number of poorly configured folders and exits to conserve time, energy, effort
 * and save a few penguins on phillip island.
 *
 * NOTE: This is a Report-By-Exception only routine, by this we mean it only
 * reports folders in violation of what is considered a sane and safe configuration.
 */
function fpa_audit_permissions_extended(): array {

    // TEMPORARY FIX: Returns a blank array to satisfy the typehint requirement
    return [];
} // end: fpa_audit_extended_permissions()

/**
 * --- Filesystem Size Audit ---
 * Optional Module: Calculates the total cumulative disk space utilized by
 * the Joomla! installation directory from the webroot downwards.
 *
 * Deferred execution: Triggers exclusively when explicitly registered inside
 * the active tests array via the interactive runtime options panel.
 *
 * ⚠️ PERFORMANCE NOTE: This routine scans individual files recursively. It is
 * isolated from core permission checks to protect system I/O bounds and prevent
 * catastrophic execution timeouts on slow hosting storage arrays.
 *
 * @param array $fpa_results Master diagnostic tracking array
 * @param array $lang Global translation dictionary
 * @return array Presentation dataset tracking total file footprints and counts
 */
function fpa_audit_filesystem(array $fpa_results, array $lang): array {
    // 🛠️ DEVELOPER PLACEHOLDER: Returns a clean, inactive view state structure
    return [
        'status'         => 'deferred',
        'total_bytes'    => 0,
        'formatted_size' => '0 B',
        'file_count'     => 0,
        'folder_count'   => 0,
        'sanity_state'   => 'info',
        'summary_notes'  => $lang['FPA_DISK_SPACE_PLACEHOLDER'] ??
            'Disk capacity scanner initialized. Logic deferred to future file iterator implementation.'
    ];
} // end: fpa_audit_filesystem()

/**
 * --- Components Audit (Site & Admin) ---
 * Optional Routine: If an instance is found, we can iterate through the components folders to find
 * the installed components and collect relevant details, versioning, etc.
 *
 * NOTE: By default this audit does not include core components unless the option
 * Include Core Extensions is selected in the FPA Runtime Settings.
 */
function fpa_audit_components(): array {

    // TEMPORARY FIX: Returns a blank array to satisfy the typehint requirement
    return [];
} // end: fpa_audit_components()

/**
 * --- Modules Audit (Site & Admin) ---
 * Optional Routine: If an instance is found, we can iterate through the modules folders to find
 * the installed modules and collect relevant details, versioning, etc.
 *
 * NOTE: By default this audit does not include core modules unless the option
 * Include Core Extensions is selected in the FPA Runtime Settings.
 */
function fpa_audit_modules(): array {

    // TEMPORARY FIX: Returns a blank array to satisfy the typehint requirement
    return [];
} // end: fpa_audit_modules()

/**
 * --- Plugins Audit (Site) ---
 * Optional Routine: If an instance is found, we can iterate through the plugins folder to find
 * the installed plugins and collect relevant details, versioning, etc.
 *
 * NOTE: By default this audit does not include core plugins unless the option
 * Include Core Extensions is selected in the FPA Runtime Settings.
 */
function fpa_audit_plugins(): array {

    // TEMPORARY FIX: Returns a blank array to satisfy the typehint requirement
    return [];
} // end: fpa_audit_plugins()

/**
 * --- Languages Audit (Site & Admin) ---
 * Optional Routine: If an instance is found, we can iterate through the language folders to find
 * the installed languages and collect relevant details, versioning, etc.
 */
function fpa_audit_languages(): array {

    // TEMPORARY FIX: Returns a blank array to satisfy the typehint requirement
    return [];
} // end: fpa_audit_languages()

/**
 * --- Libraries Audit (Site) ---
 * Optional Routine: If an instance is found, we can iterate through the libraries folder to find
 * the installed libraries and collect relevant details, versioning, etc.
 *
 * NOTE: By default this audit does not include core libraries unless the option
 * Include Core Extensions is selected in the FPA Runtime Settings.
 */
function fpa_audit_libraries(): array {

    // TEMPORARY FIX: Returns a blank array to satisfy the typehint requirement
    return [];
} // end: fpa_audit_libraries()

/**
 * --- Manifest Audit (Admin) ---
 * Optional Routine: If an instance is found, we can iterate through the manifests folders to find
 * the manifests and collect relevant details, versioning, etc.
 */
function fpa_audit_manifests(): array {

    // TEMPORARY FIX: Returns a blank array to satisfy the typehint requirement
    return [];
} // end: fpa_audit_manifests()

/**
 * --- Templates Audit (Site & Admin) ---
 * Optional Routine: If an instance is found, we can iterate through the templates folders to find
 * the installed templates and collect relevant details, versioning, etc.
 */
function fpa_audit_templates(): array {

    // TEMPORARY FIX: Returns a blank array to satisfy the typehint requirement
    return [];
} // end: fpa_audit_templates()

/**
 * --- Joomla Statistics Audit (Site & Admin) ---
 * Optional Routine: If an instance is found and configured, we can iterate through a variety of
 * settings and database tables with a view to collecting and analysing relevant
 * statistical and/or log information, etc.
 */
function fpa_audit_joomlastats(): array {

    // TEMPORARY FIX: Returns a blank array to satisfy the typehint requirement
    return [];
} // end: fpa_audit_joomlastats()
// =============================================================================
//  END SUBSECTION: OPTIONAL RUNTIME DIAGNOSTIC FUNCTIONS
// =============================================================================
//  END SECTION: RUNTIME DIAGNOSTIC LIFE-CYCLE CORE FUNCTIONS
// =============================================================================

/*
 * =============================================================================
 *  SECTION: MASTER RUNNER ENGINE (THE CORE ORCHESTRATOR)
 * =============================================================================
 * Welcome to the engine room! This is where the core execution happens.
 *
 * WELCOME TO FPA v2:
 * Compared to FPA v1, we have completely migrated to a unified Master Runner
 * + Dynamic Registry architecture. We have eliminated the legacy procedural
 * blocks of spaghetti code and heavy inline conditional PHP logic within the
 * HTML layout.
 *
 * DON'T PANIC! (You know the answer is 42, right?)
 * This design simplifies the application dramatically, reduces page layout
 * clutter, runs significantly faster, and makes it incredibly easy for any
 * volunteer developer to maintain and scale.
 *
 * HOW DOES THIS ARCHITECTURE WORK?
 * The Master Runner function (`fpa_runtime_tests`) acts as a single, isolated,
 * centralized air traffic control tower for the entire script lifecycle.
 *
 * Its only jobs are to:
 *  1. Initialize the master associative array blueprint structure ($fpa_results).
 *  2. Execute mandatory baseline system check functions automatically (Phase 1).
 *  3. Loop through and execute requested optional audit functions dynamically (Phase 2).
 *  4. Capture the clean return outputs and plug them right into the master array keys.
 *  5. Return the entire system state as a single, unified, immutable data packet.
 *
 * THE LIFECYCLE MAP:
 *
 *     [ User Submits Offcanvas Runtime Settings Form ]
 *                           │
 *              (Filters Active Checkboxes)
 *                           ▼
 *         [ Compiled Active Tests Registry List ]
 *                           │
 *             (Passes Queue to Controller)
 *                           ▼
 *             ┌───────────────────────────┐
 *             │    fpa_runtime_tests()    │
 *             └─────┬───────────────┬─────┘
 *                   │               │
 *           (Runs Mandatory) (Loops Optional)
 *                   ▼               ▼
 *            [ Core Audit ]   [ Perms Audit ]
 *                   │               │
 *            (Saves Data)    (Saves Data)
 *                   └───────┬───────┘
 *                           ▼
 *             ┌───────────────────────────┐
 *             │       $fpa_results        │  <-- Private Workspace
 *             └─────────────┬─────────────┘      (Inside Function)
 *                           │
 *                   (Return Statement)
 *                           ▼
 *             ┌───────────────────────────┐
 *             │         $fpa_data         │  <-- Global Production Array
 *             └───────────────────────────┘      (Use This In Your HTML!)
 * =============================================================================
 */
function fpa_runtime_tests(array $lang, array $active_tests, array $registry, string $base_path, array $exclude_list): array {

    /*
     * --- Master Results Blueprint Registry Array ---
     *
     * Compliance Layer: PER 3.0 / PSR-12 Normalized Schema Matrix
     *
     * Initializes the global tracking array with explicit base structural elements
     * for every operational segment. Pre-defining these standard secondary keys
     * prevents runtime "Undefined Index" notices and ensures strict type-safety
     * across all modern and legacy PHP environments.
     *
     * Usage:
     * As new diagnostic modules or optional processing passes are added, append
     * a unique primary key to this tree. All downstream evaluation functions and
     * frontend HTML presentation templates then reference data using an identical,
     * completely predictable 3-tier mapping grid.
     *
     * Standard Unified 3-Tier Array Structure Schema:
     * -----------------------------------------------
     * $fpa_results['section_key']['meta']    // HTML title, notes & attribute_slug
     * $fpa_results['section_key']['targets'] // Flat list of reference input items
     * $fpa_results['section_key']['data']    // Uniform metrics results & rows
     */
    $fpa_results = [
        // Commonly referenced environment data used across multiple functions
        'ref' => [
            // TIER 1: Presentation metadata layer for UI headers and toggles
            'meta' => [
                'section_title'  => $lang['FPA_META_TITLE_REF'],
                'section_intro'  => 'Common reference and comparison data for use across all functions and output.',
                'attribute_slug' => 'fpa_ref_discovery'
            ],

            // TIER 2: Input target operational registries (Empty for global ref)
            'targets' => [],

            // TIER 3: Normalized environment results payloads
            'data' => [
                // Active PHP engine and running system process identities
                'php' => [
                    'version'            => PHP_VERSION,
                    'interface_sapi'     => PHP_SAPI,
                    // Resolves the system user executing this PHP script instance
                    'process_user'       => function_exists('posix_getpwuid') && function_exists('posix_getuid') ? posix_getpwuid(posix_getuid())['name'] : (getenv('USER') ?: getenv('USERNAME')),
                    'process_uid'        => function_exists('posix_getuid') ? posix_getuid() : fileowner(__FILE__),
                    'process_uid_color'  => 'success', // Semantic UI badge token
                    'process_gid'        => function_exists('posix_getgid') ? posix_getgid() : filegroup(__FILE__),
                    'process_gid_color'  => 'success', // Semantic UI badge token
                    // Tracks disabled core functions restricting script depth
                    'disabled_functions' => ini_get('disable_functions') ?: $lang['FPA_TXT_NONE'],
                ],

                // Core host operating system and web server parameters
                'server' => [
                    'os_family'           => PHP_OS_FAMILY,
                    'os_family_short'     => strtolower(substr(PHP_OS, 0, 3)),
                    'os_release'          => php_uname('r'),
                    'hostname'            => function_exists('gethostname') ? gethostname() : (php_uname('n') ?: $lang['FPA_TXT_UNKNOWN']),
                    'host_ip'             => gethostbyname(gethostname()),
                    'technology'          => php_uname('m'),
                    'web_server'          => 'Pending Execution',
                    'web_server_short'    => 'unknown',
                    'web_server_encoding' => $_SERVER['HTTP_ACCEPT_ENCODING'] ?? $lang['FPA_TXT_NONE'],
                    'umask'               => sprintf('%04o', umask(umask())),
                    'is_localhost'        => false,
                    'is_windows'          => false,
                    'is_win_local'        => false,
                ],

                // Network routing parameters and connection port numbers
                'network' => [
                    'domain_ip'    => gethostbyname($_SERVER['SERVER_NAME']),
                    'raw_domain'   => $_SERVER['HTTP_HOST'] ?? ($_SERVER['SERVER_NAME'] ?? $lang['FPA_TXT_UNKNOWN']),
                    // Extracts base domain string, dropping any trailing port numbers
                    'domain_name'  => strtolower(strtok($_SERVER['HTTP_HOST'] ?? ($_SERVER['SERVER_NAME'] ?? $lang['FPA_TXT_UNKNOWN']), ':')),
                    'server_port'  => isset($_SERVER['SERVER_PORT']) ? (int)$_SERVER['SERVER_PORT'] : 0,
                    'visitor_port' => isset($_SERVER['REMOTE_PORT']) ? (int)$_SERVER['REMOTE_PORT'] : 0,
                ]
            ] // Mostly self-populated or added to by any other helper and primary functions as discovered
        ], // Populated dynamically via global execution context rules up-front

        // Latest available versions/releases, if enabled by FPA_LIVECHECKS constant
        'livechecks' => [
            // TIER 1: Presentation metadata layer for UI headers and toggles
            'meta' => [
                'section_title'  => $lang['FPA_META_TITLE_LIVE_CHECKS'],
                'section_intro'  => 'Compares active local installation versions against official remote release repositories.',
                'attribute_slug' => 'fpa_live_checks'
            ],

            // TIER 2: Input target operational registries (Empty for live checks)
            'targets' => [],

            // TIER 3: Normalized environment results payloads
            'data' => [
                // Structural tracking profile for the Forum Post Assistant engine itself
                'fpa' => [
                    'label'        => $lang['FPA_LABEL_FPA'],
                    'current'      => FPA_VERSION,
                    'latest'       => $lang['FPA_TXT_UNKNOWN'],
                    'status'       => $lang['FPA_TXT_UNKNOWN'],
                    'status_color' => 'muted' // Neutral semantic UI badge token
                ],

                // Discovered core parameters for the target Joomla! CMS instance
                'joomla' => [
                    'label'        => $lang['FPA_LABEL_JOOMLA'],
                    'current'      => $lang['FPA_TXT_UNKNOWN'],
                    'latest'       => $lang['FPA_TXT_UNKNOWN'],
                    'status'       => $lang['FPA_TXT_UNKNOWN'],
                    'status_color' => 'muted' // Neutral semantic UI badge token
                ],

                // Local PHP processing engine runtime lifecycle statistics
                'php' => [
                    'label'        => $lang['FPA_LABEL_PHP'],
                    'current'      => PHP_VERSION,
                    'latest'       => $lang['FPA_TXT_UNKNOWN'],
                    'status'       => $lang['FPA_TXT_UNKNOWN'],
                    'status_color' => 'muted' // Neutral semantic UI badge token
                ]
            ] // Populated by fpa_live_checks()
        ], // Populated dynamically via remote repository cURL API streams if enabled

        // TODO: CONFIRM THIS IS NO LONGER NEEDED
        // Gather the metrics scores and calculated readiness rating from environment, performance & security
        'metrics' => [
            'meta' => [
                'section_title' => $lang['FPA_META_TITLE_KEY_METRICS'],
                'section_intro' => 'will be the readiness message',
                'attribute_slug' => 'fpa_key_metrics' // used for section id and toggle buttons
            ],
            'targets' => [],
            'data' => [
                'readiness_rating'  => $lang['FPA_READINESS_F'],   // rating based on overall_score (A+, A, B ... F)
                'overall_score'     => '0',   // %'age, combined scores from env, sec, perf category scores
                'environment_score' => '100', // %'age, decremented as test/routines run
                'security_score'    => '100', // %'age, decremented as test/routines run
                'performance_score' => '100'  // %'age, decremented as test/routines run
             ], // Populated by fpa_do_metrics()
            'compatibility'   => [] // Populated by fpa_do_compatibility()
        ],

        // If found, gather joomla core information and structural configurations
        'jinstance' => [
            // TIER 1: Presentation metadata layer for UI headers and toggles
            'meta' => [
                'section_title'  => $lang['FPA_META_TITLE_JOOMLA_INSTANCE'],
                'section_intro'  => 'Audits core software versions, tracking active components, system plugins, database configurations and template footprints.',
                'attribute_slug' => 'fpa_jinstance_discovery'
            ],

            // TIER 2: Input target operational registries (Initialized for compliance)
            'targets' => [],

            // TIER 3: Normalized environment results payloads
            'data' => [
                'rows' => [
                    // Standardised master components index map (Rows store 'client' property)
                    'components' => [],

                    // Standardised master modules index map (Rows store 'client' property)
                    'modules'    => [],

                    // Global plugin array nodes grouped natively by system type
                    'plugins'    => [],

                    // Layout blueprints for templates, dropping messy site/admin wrappers
                    'templates'  => [],

                    // Core language packs currently active across installation boundaries
                    'languages'  => [],

                    // Stores the configuration values imported securely from configuration.php
                    'jconfig'     => [],

                    // Summary baseline engine statistical tracking calculations metrics
                    'jstats'     => []
                ],    // Stores joomla extension & content discovery

                // Core tally counters allow sorting tools to scan this node instantly
                'failed_count'  => 0,     // Consolidated tracking total error count
                'danger_count'  => 0,     // Total critical threat tracking tally
                'warning_count' => 0,     // Total warning status tracking tally
                'is_complete'   => false  // State flag tracking module lifecycle
            ] // Populated by fpa_do_jinstance(), fpa_audit_joomlastats() and configuration imports
        ], // Fully processes active local application framework profiles if discovered

        // Web server infrastructure diagnostics and HTTP environment audits
        'httpserver' => [
            // TIER 1: Presentation metadata layer for UI headers and toggles
            'meta' => [
                'section_title'  => $lang['FPA_META_TITLE_WEBSERVER'],
                'section_intro'  => $lang['FPA_META_INTRO_WEBSERVER'],
                'attribute_slug' => 'fpa_httpserver_discovery'
            ],

            // TIER 2: Input target operational registries (Empty for web server)
            'targets' => [],

            // TIER 3: Normalized environment results payloads
            'data' => [
                'rows' => [],    // Stores server engine directive metrics

                // Core tally counters allow sorting tools to scan this node instantly
                'failed_count'  => 0,     // Consolidated tracking total error count
                'danger_count'  => 0,     // Total critical threat tracking tally
                'warning_count' => 0,     // Total warning status tracking tally
                'is_complete'   => false  // State flag tracking module lifecycle
            ] // Populated by fpa_do_httpserver() & fpa_get_fpm_pool_metrics()
        ], // Fully audits SAPI extensions, execution pools and server software profiles

        // DNS Evaluation & Security (Optional)
        'dns_security' => [
            // TIER 1: Presentation metadata layer for UI headers and toggles
            'meta' => [
                'section_title'  => $lang['FPA_META_TITLE_LIVE_CHECKS'],
                'section_intro'  => 'Compares active local installation versions against official remote release repositories.',
                'attribute_slug' => 'fpa_live_checks'
            ],

            // TIER 2: Input target operational registries
            'targets' => [],

            // TIER 3: Normalized environment results payloads
            'data' => [
                'rows' => [],    // Stores server engine directive metrics

                // Core tally counters allow sorting tools to scan this node instantly
                'failed_count'  => 0,     // Consolidated tracking total error count
                'danger_count'  => 0,     // Total critical threat tracking tally
                'warning_count' => 0,     // Total warning status tracking tally
                'is_complete'   => false  // State flag tracking module lifecycle
            ]
        ],

        // PHP engine environmental profiles, extension states, and ini directives
        'php' => [
            // TIER 1: Presentation metadata layer for UI headers and toggles
            'meta' => [
                'section_title'  => $lang['FPA_META_TITLE_PHP_DISCOVERY'],
                'section_intro'  => 'Audits runtime PHP configurations, verifying extension availability and mapping runtime directives against security or performance baselines.',
                'attribute_slug' => 'fpa_php_discovery'
            ],

            // TIER 2: Input target operational registries (Strict reference criteria lists)
            'targets' => [
                // Core database interface extension layers to test against
                'database_extensions'    => ['mysql', 'mysqli', 'pdo_mysql', 'pdo_pgsql', 'pgsql', 'mysqlnd', 'wilma'],
                // Mandatory technical prerequisites required for basic Joomla operations
                'required_extensions'    => ['json', 'dom', 'SimpleXML', 'zlib', 'gd', 'openssl', 'mcrypt', 'sodium', 'fred', 'barney', 'betty'],
                // Highly recommended packages required for optimal framework execution
                'recommended_extensions' => ['curl', 'filter', 'iconv', 'mbstring', 'zip', 'fileinfo', 'libxml', 'xml'],

                // Map of directives to evaluate (Keys are checked, values define their dashboard pillar categorization)
                'ini_directives' => [
                    'display_errors'               => 'security',
                    'open_basedir'                 => 'security',
                    'allow_url_include'            => 'security',
                    'allow_url_fopen'              => 'security',
                    'session.cookie_httponly'      => 'security',
                    'session.cookie_secure'        => 'security',
                    'expose_php'                   => 'security',
                    'disable_functions'            => 'security',
                    'memory_limit'                 => 'performance',
                    'max_execution_time'           => 'performance',
                    'opcache.enable'               => 'performance',
                    'opcache.max_accelerated_files' => 'performance',
                    'max_input_time'               => 'performance',
                    'upload_max_filesize'           => 'functionality',
                    'post_max_size'                => 'functionality',
                    'max_input_vars'               => 'functionality',
                    'default_socket_timeout'       => 'functionality',
                    'short_open_tag'               => 'compatibility',
                    'mbstring.func_overload'       => 'compatibility',
                    'file_uploads'                  => 'compatibility',
                    'request_order'                => 'compatibility',
                    'zlib.output_compression'      => 'compatibility'
                ]
            ],

            // TIER 3: Normalized environment results payloads
            'data' => [
                'rows' => [],   // Unified compilation grid for both extensions and ini directives
                'ini_files' => [
                    'web_root_php_ini'  => null, // Absolute path to webroot php.ini if discovered
                    'web_root_user_ini' => null, // Absolute path to webroot .user.ini if discovered
                    'admin_php_ini'     => null, // Absolute path to administrator php.ini if discovered
                    'admin_user_ini'    => null  // Absolute path to administrator .user.ini if discovered
                ],
                'memory_footprint' => [], // Populated dynamically by fpa_do_php_memory_footprint()
                'upload_tmp'       => [], // Populated dynamically by fpa_php_upload_tmp_audit()

                // Core tally counters allow sorting tools to scan this node instantly
                'failed_count'     => 0,    // Consolidated tracking total error count tally
                'danger_count'     => 0,    // Total critical threat tracking tally count
                'warning_count'    => 0,    // Total warning status tracking tally count
                'is_complete'      => false  // State flag tracking module execution lifecycle
            ] // Populated by fpa_do_php(), fpa_audit_php_extended(), and directive validation routines
        ], // Fully compiles internal server configurations and environment restrictions

        // Database configuration metrics, table-space allocations and engine statistics
        'database' => [
            // TIER 1: Presentation metadata layer for UI headers and toggles
            'meta' => [
                'section_title'  => $lang['FPA_META_TITLE_PLATFORM_INTEGRITY'],
                'section_intro'  => 'Audits target database engine parameters, analyzing tablespace allocation, schema structures, collations and operational statistics.',
                'attribute_slug' => 'fpa_database_discovery'
            ],

            // TIER 2: Input target operational registries (Initialized for compliance)
            'targets' => [],

            // TIER 3: Normalized environment results payloads
            'data' => [
                'rows' => [
                    'engine_variables' => [],  // Raw directive profiles (e.g. sql_mode, character_set)
                    'tables'           => [],  // Maps individual table names, rows, sizes and collations
                    'tablespace_stats' => [
                        'total_data_bytes'  => 0, // Consolidated data footprint capacity used
                        'total_index_bytes' => 0, // Consolidated indexing footprint allocation
                        'free_space_bytes'  => 0  // Leftover open memory fragments reported
                    ]
                ],

                // Core tally counters allow sorting tools to scan this node instantly
                'failed_count'   => 0,     // Consolidated tracking total error count tally
                'danger_count'   => 0,     // Total critical threat tracking tally count
                'warning_count'  => 0,     // Total warning status tracking tally count
                'is_complete'    => false  // State flag tracking module execution lifecycle
            ] // Populated by fpa_do_database() and fpa_audit_database()
        ], // Fully processes active local database schema configurations if discovered

        // Confirm the operational presence of required core folders and their bitmask permissions
        'corefolders' => [
            // TIER 1: Presentation metadata layer for UI headers and toggles
            'meta' => [
                'section_title'  => $lang['FPA_META_TITLE_CORE_FOLDERS'],
                'section_intro'  => 'Audits the presence of required Joomla! core folders, ensuring they conform to safe operational standards.',
                'attribute_slug' => 'fpa_core_folders'
            ],

            // TIER 2: Input target operational registries (Strict reference criteria lists)
            'targets' => [
                // Structural framework directories required for baseline application execution
                'required_folders' => [
                    'api/', 'cache/', 'components/', 'images/', 'language/', 'libraries/', 'logs/', 'media/',
                    'media/cache/', 'modules/', 'plugins/', 'templates/', 'tmp/', 'administrator/cache/',
                    'administrator/components/', 'administrator/logs/', 'administrator/manifests/',
                    'administrator/modules/', 'administrator/language/', 'administrator/templates/'
                ]
            ],

            // TIER 3: Normalised environment results payloads
            'data' => [
                'rows' => [
                    'folders' => [],
                ],    // Associative paths map populated by fpa_do_permissions()

                // Core tally counters allow sorting tools to scan this node instantly
                'failed_count'  => 0,     // Consolidated tracking total error count
                'danger_count'  => 0,     // Total critical threat tracking tally
                'warning_count' => 0,     // Total warning status tracking tally
                'is_complete'   => false  // State flag tracking module lifecycle
            ] // Populated by fpa_do_permissions() on the Phase 1 mandatory baseline pass
        ], // Fully verifies system pathways before allowing advanced secondary tests to execute

        // Audit the bitmask permissions of all remaining site-root filesystem directories
        'permissions' => [
            // TIER 1: Presentation metadata layer for UI headers and toggles
            'meta' => [
                'section_title'  => $lang['FPA_META_TITLE_FOLDER_PERMS'],
                'section_intro'  => 'Audits remaining system directories recursively, ensuring extended security boundaries conform to safe operational standards.',
                'attribute_slug' => 'fpa_permissions'
            ],

            // TIER 2: Input target operational registries (Populated dynamically during runtime)
            'targets' => [],

            // TIER 3: Normalized environment results payloads
            'data' => [
                'rows' => [
                    'folders' => [],
                ],    // Associative paths map populated by fpa_do_permissions()

                // Core tally counters allow sorting tools to scan this node instantly
                'failed_count'  => 0,     // Consolidated tracking total error count
                'danger_count'  => 0,     // Total critical threat tracking tally
                'warning_count' => 0,     // Total warning status tracking tally
                'is_complete'   => false  // State flag tracking module lifecycle
            ] // Populated by fpa_do_permissions() on the Phase 2 optional recursive pass,
              // using $fpa_results['corefolders']['targets']['required_folders'] as an exclude list
        ], // Fully processes background directories up to your safe max_errors circuit ceiling

        // Key metrics dashboard matrix tracking individual score pillars
        'key_metrics' => [
            // TIER 1: Presentation metadata layer for UI headers and toggles
            'meta' => [
                'section_title'  => $lang['FPA_META_TITLE_KEY_METRICS'],
                'section_intro'  => 'Compiles systemic environmental audits into quantifiable security, functionality, performance and compatibility scores.',
                'attribute_slug' => 'fpa_key_metrics'
            ],

            // TIER 2: Input target operational registries (Empty for cockpit)
            'targets' => [],

            // TIER 3: Normalized environment results payloads
            'data' => [
                'rows'          => [],    // Empty placeholder: Keeps all system sorting tools silent!
                'failed_count'  => 0,     // Consolidated tracking total metric warnings tally
                'danger_count'  => 0,     // Total critical metric alerts tracking tally count
                'warning_count' => 0,     // Total warning status metrics tracking tally count
                'is_complete'   => false, // State flag tracking module execution lifecycle

                // Pillar Calculations: Grouped
                'pillars' => [
                    'security'      => ['passed' => 0, 'total' => 0, 'score' => 100, 'state' => 'success'],
                    'functionality' => ['passed' => 0, 'total' => 0, 'score' => 100, 'state' => 'success'],
                    'compatibility' => ['passed' => 0, 'total' => 0, 'score' => 100, 'state' => 'success'],
                    'performance'   => ['passed' => 0, 'total' => 0, 'score' => 100, 'state' => 'success']
                ],

                // System ecosystem health tracking gauges summary configurations
                'health' => [
                    'overall_score' => 100,
                    'overall_state' => 'success',
                    'summary_notes' => 'Awaiting operational test cycles initialization execution.'
                ]
            ] // Populated by fpa_do_keymetrics()
        ], // Fully compiles consolidated infrastructure status analytics indices

        // Raise and log any exceptions/alerts found to display in the offcanvas error log notifications drawer
        'issue_queue' => [
            // TIER 1: Presentation metadata layer for UI headers and toggles
            'meta' => [
                'section_title'  => $lang['FPA_META_TITLE_ERROR_LOG'] ?? 'Actionable System Issues',
                'section_intro'  => 'Review and resolve the following risks and issues logged by the Forum Post Assistant.',
                'attribute_slug' => 'fpa_errorlog'
            ],

            // TIER 2: Input target operational registries (Empty for issue log)
            'targets' => [],

            // TIER 3: Normalised environment results payloads
            'data' => [
                // 🚀 STANDARDISED ALERTS CONTAINER: Every single logged error lives here!
                'rows'          => [],    // Sequential alert records map populated dynamically across execution cycles
                'failed_count'  => 0,     // Consolidated tracking total error count tally
                'danger_count'  => 0,     // Total critical threat tracking tally count
                'warning_count' => 0,     // Total warning status tracking tally count
                'is_complete'   => false  // State flag tracking module execution lifecycle
            ] // Populated at any time by any function or routine, utilizing fpa_format_logs() function
        ], // Fully compiles internal server configurations and environment restrictions
    ];


    // Run Any core or utility helpers to evaluate and save and initialise key
    // or variable states that maybe required by later functions.
    // TODO: check if we still need these or just load the array keys and use them in later routines.
    $is_local     = fpa_is_localhost_helper($fpa_results);
    $is_windows   = fpa_is_windows_helper($fpa_results);
    $is_win_local = ($is_local && $is_windows);

    // Inject them straight into your reference registry for future functions to read instantly!
    $fpa_results['ref']['data']['server']['is_localhost'] = $is_local;
    $fpa_results['ref']['data']['server']['is_windows']   = $is_windows;
    $fpa_results['ref']['data']['server']['is_win_local'] = $is_win_local;

    /*
     * =========================================================================
     * RUNTIME PHASE 1: Execute Mandatory Tests
     * =========================================================================
     * These functions/routines run regardless of FPA Runtime Settings.
     * We just call the function by its name here! The accrued data is added to
     * the appropriate array key slot(s).
     * =========================================================================
     */
    // Run Joomla instance discovery
    if (function_exists('fpa_do_instance')) {
        //$fpa_results['instance']['data'] = fpa_do_instance();
    } // end: fpa_do_instance()

    // Run php extension discovery
    if (function_exists('fpa_do_php')) {

        // 1. Pull the flat list out of our blueprint array
        $required_checklist = array_merge(
            $fpa_results['php']['targets']['required_extensions'],
            $fpa_results['php']['targets']['database_extensions']
        );

        // 2. Call the function for the first time, passing the combined required list
        $required_output = fpa_do_php($required_checklist, $lang);

        // 3. Save that exact data block into the designated required target key
        $fpa_results['php']['data']['rows']['required_extensions'] = $required_output;

        // 4. Extract the static recommended list out of the blueprint
        $recommended_checklist = $fpa_results['php']['targets']['recommended_extensions'];

        // 5. Call the same function a second time, passing the recommended list instead
        $recommended_output = fpa_do_php($recommended_checklist, $lang);

        // 6. Save this separate data block into your designated recommended target key
        $fpa_results['php']['data']['rows']['recommended_extensions'] = $recommended_output;

        // 7. Add the HTML sections dynamic id slug, also used for data attribute
        //    if any toggle buttons are to be used within the HTML section
        ///$fpa_results['php']['meta']['attribute_slug'] = 'php_req_extensions';

        // --- OPTIONAL SAFETY NET: Automatic Issue Queue Generation ---
        // Loop through the required extensions output. If any critical item is missing, flag it!
        $i = 0;
        foreach ($fpa_results['php']['data']['rows']['required_extensions'] as $name => $metrics) {
            if ($metrics['is_missing']) {
                $fpa_results['issue_queue']['data']['rows'][] = [
                    'id'        => 'missing_req_' . $name,
                    'type'      => 'danger',
                    'text'      => ($lang['FPA_ERR_CRITICAL_MISSING'] ?? 'Critical Component Missing: ') . $name,
                    'solution'  => ($lang['FPA_SOL_ENABLE_EXT'] ?? 'Enable this module inside your server php.ini file.'),
                    'target_id' => 'notification-wrapper'
                ];
                $i++;
            }
        }

        // TODO: check if this is still needed or a better way of doing it
        if ($i == 0) {
            $fpa_results['php']['exceptions']['required_extensions']['msg'] = 'All Required Extensions Available';
        }


        // Loop through the recommened extensions output. If any items are missing, flag it!
        $i = 0;
        foreach ($fpa_results['php']['data']['rows']['recommended_extensions'] as $name => $metrics) {
            if ($metrics['is_missing']) {
                $fpa_results['issue_queue']['data']['rows'][] = [
                    'id'        => 'missing_rec_' . $name,
                    'type'      => 'danger',
                    'text'      => ($lang['FPA_ERR_CRITICAL_MISSING'] ?? 'Critical Component Missing: ') . $name,
                    'solution'  => ($lang['FPA_SOL_ENABLE_EXT'] ?? 'Enable this module inside your server php.ini file.'),
                    'target_id' => 'notification-wrapper'
                ];
                $i++;
            }
        }

        // TODO: check if this is still needed or a better way of doing this
        if ($i == 0) {
            $fpa_results['php']['exceptions']['recommended_extensions']['msg'] = 'All Recommended Extensions Available';
        }

    } // end: fpa_do_php()

    // Run php ini directive (matrix) discovery
    if (function_exists('fpa_do_ini_matrix')) {

        $ini_checklist  = $fpa_results['php']['targets']['ini_directives'];

        // Call the function, passing the base system directory path argument
        $matrix_payload = fpa_do_ini_matrix($ini_checklist, $lang, $base_path);

        // Distribute the collected parameters straight to their descriptive key locations!
        $fpa_results['php']['ini_files']           = $matrix_payload['ini_files'];
        $fpa_results['php']['data']['rows']['ini_matrix'] = $matrix_payload['ini_matrix'];

        // 4. Add the HTML sections dynamic id slug, also used for data attribute
        //    if any toggle buttons are to be used within the HTML section
        ///$fpa_results['php']['meta']['attribute_slug'] = 'php_req_extensions';

        // --- OPTIONAL SAFETY NET: Automatic Issue Queue Generation ---
        // Loop through the required extensions output. If any critical item is missing, flag it!
        $i = 0;
        foreach ($fpa_results['php']['data']['rows']['ini_matrix'] as $name => $metrics) {
            if ($metrics['override_status'] == 'failed') {
                $fpa_results['issue_queue']['data']['rows'][] = [
                    'id'        => 'unapplied_override_' . $name,
                    'type'      => 'warning',
                    'text'      => ($lang['FPA_ERR_UNAPPLIED_OVERRIDE'] ?? 'Unapplied override: ') . $name,
                    'solution'  => ($lang['FPA_SOL_ENABLE_EXT'] ?? 'Check override syntax. Contact your host for assistance.'),
                    'target_id' => 'notification-wrapper'
                ];
                $i++;
            }
        }

        //if ($i == 0) {
        //    $fpa_results['php']['exceptions']['required_extensions']['msg'] = 'All Required Extensions Available';
        //}

    } // end: fpa_do_ini_matrix()

    // Run php directive sanity checks
    if (function_exists('fpa_do_ini_matrix') && function_exists('fpa_do_ini_sanity')) {
        $matrix_payload = fpa_do_ini_matrix($fpa_results['php']['targets']['ini_directives'], $lang, $base_path);
        $sanity_payload = fpa_do_ini_sanity($matrix_payload['ini_matrix'], $lang);

        $fpa_results['php']['targets']['ini_files']        = $matrix_payload['ini_files'];
        $fpa_results['php']['data']['rows']['ini_matrix'] = $sanity_payload['results'];

        // Push To Meta: Store counters
        $fpa_results['php']['data']['all_sane']      = $sanity_payload['all_sane'];
        $fpa_results['php']['data']['danger_count']  = $sanity_payload['danger_count'];
        $fpa_results['php']['data']['warning_count'] = $sanity_payload['warning_count'];
    } // end: fpa_do_ini_sanity()

    // Run php memory usage
    if (function_exists('fpa_do_php_memory_footprint')) {
        $fpa_results['php']['data']['memory_footprint'] = fpa_do_php_memory_footprint($lang);
    } // end: fpa_do_php_memory_footprint()

    // Run php upload tmp folder access
    if (function_exists('fpa_do_php_upload_tmp_audit')) {
        $tmp_payload = fpa_do_php_upload_tmp_audit($lang);
        $fpa_results['php']['data']['upload_tmp'] = $tmp_payload;

        // Directly push to the global Navbar Message Queue if the directory is broken!
        if ($tmp_payload['ui_alert'] !== null) {
            $fpa_results['issue_queue']['data']['rows'][] = $tmp_payload['ui_alert'];
        }
    } // end: fpa_do_php_upload_tmp_audit()

    // Run httpserver discovery
    if (function_exists('fpa_do_httpserver')) {
        $server_payload = fpa_do_httpserver($lang);

        // Lock the data packet into its designated results slot!
        $fpa_results['httpserver']['data']['rows'] = $server_payload;

        // Correlate and bridge data in to the 'ref' key as well
        $fpa_results['ref']['data']['server']['web_server']          = $server_payload['web_server'];
        $fpa_results['ref']['data']['server']['web_server_short']    = $server_payload['web_server_short'];
        $fpa_results['ref']['data']['server']['web_server_encoding'] = $server_payload['web_server_encoding'];
        $fpa_results['ref']['data']['server']['umask']               = $server_payload['umask'];
        $fpa_results['ref']['data']['php']['process_user']           = $server_payload['process_user'];

        // Raise any relevant issues for the php-fpm stats
        if (!empty($server_payload['fpm_pool_metrics'])) {
            $fpm = $server_payload['fpm_pool_metrics'];

            // Issue Condition A: Workers max limit breached
            // If the maximum number of active processes matches or exceeds the total available workers (causes 503 errors)
            if ($fpm['total_workers'] > 0 && $fpm['max_reached'] >= $fpm['total_workers']) {
                $fpa_results['issue_queue']['data']['rows'][] = [
                    'id'        => 'fpm_workers_exhausted',
                    'type'      => 'warning',
                    'text'      => 'Warning: PHP-FPM Process Pool Max Worker Limit Breached.',
                    'solution'  => 'Your server has hit its maximum concurrency ceiling (' . $fpm['total_workers'] . ' workers). Subsequent visitor requests are being forcefully queued or dropped, causing severe site latency or 503 Service Unavailable errors. Request your host to scale up the pm.max_children allocation.',
                    'target_id' => 'fpa_issues_drawer'
                ];
            }

            // Issue Condition B: Active slow request logging (causes slow/delayed/spikey site loading)
            if ($fpm['slow_requests'] > 0) {
                $fpa_results['issue_queue']['data']['rows'][] = [
                    'id'        => 'fpm_slow_requests_logged',
                    'type'      => 'warning',
                    'text'      => 'Warning: PHP-FPM has intercepted ' . $fpm['slow_requests'] . ' slow execution loops.',
                    'solution'  => 'The process manager has forced script terminations due to timeouts. This points directly to hanging database queries, broken third-party update curl tasks, or bloated components dragging down system threads. Review your server slowlog files to isolate the broken script paths.',
                    'target_id' => 'fpa_issues_drawer'
                ];
            }
        }

    } // end: fpa_do_httpserver()

    // Run database discovery
    if (function_exists('fpa_do_database')) {
        //$fpa_results['database']['data'] = fpa_do_database();
    } // end: fpa_do_database()

    // Run required Joomla folders permissions
    /* REPLACED BY fpa_do_permissions
    if (function_exists('fpa_do_corefolders')) {
        //$fpa_results['corefolders']['data'] = fpa_do_corefolders();
    } // end: fpa_do_corefolders()
     */

    // Run required Joomla core folder permissions
    if (function_exists('fpa_do_permissions')) {
        // Reads directly from the core folders list keys
        $core_paths = $fpa_results['corefolders']['targets']['required_folders'] ?? [];

        if (!empty($core_paths)) {
            // Triggers the baseline check pass (No limits, no exclusions)
            $fpa_results['corefolders']['data']['rows'] = fpa_do_permissions(
                $fpa_results,
                $lang,
                $core_paths,
                [],
                999 // High threshold protection for vital baseline folders
            );
        }
    } // end: fpa_do_permissions() - Mandatory Core Folders

    // Run Joomla minimum requirements and application version comparison
    if (function_exists('fpa_do_compatibility')) {
        //$fpa_results['metrics']['data']['compatibility'] = fpa_do_compatibility();
    } // end: fpa_do_compatibilty()

    // TODO: this may need to move below the optional tests, so as to collect all the data correctly
    // Finalise overall and category rating and scoring
    // NOTE: ALLTHOUGH THIS IS A MANDATORY FUNCTION IT NEEDS TO RUN LAST TO
    //       ENSURE IT CAPTURES BOTH MANDATORY AND OPTIONAL METRICS.
    if (function_exists('fpa_do_keymetrics')) {
        $fpa_results = fpa_do_keymetrics($fpa_results, $lang);
    } // end: fpa_do_metrics()
    // =========================================================================
    //  END RUNTIME PHASE 1: MANDATORY TEST EXECUTION
    // =========================================================================


    /*
     * =========================================================================
     * RUNTIME PHASE 3: Execute Optional Tests
     * =========================================================================
     * Called from the $active_tests_to_run array after being selected from the
     * FPA Runtime Settings form (offcanvas) and via the Registry loop.
     * =========================================================================
     */
    /* TODO: uncomment the following when runtime form is available
    foreach ($active_tests as $test_key) {
        if (isset($registry[$test_key])) {
            $function_name = $registry[$test_key]; // e.g., gets string 'fpa_audit_permissions'

            if (function_exists($function_name)) {
                // PHP runs the function by evaluating the string variable value!
                $fpa_results[$test_key]['data'] = $function_name();
            }
        }
    }
    */

    // NEDS TO BE WRAPPED AS ABOVE AS OPTIONAL WHEN FORM READY
    // =========================================================================
    // LINEAR OPTIONAL TEST SEQUENCE: DUAL-TABLE DNS SECURITY AUDIT
    // =========================================================================
    if (function_exists('fpa_audit_dns_security')) {
        // Execute your combined network analytics pass
        $dns_payload = fpa_audit_dns_security($fpa_results, $lang);

        // Save the data packet straight into its matching master results slot
        $fpa_results['dns_security']['data']['rows'] = $dns_payload;

        // =====================================================================
        // 🚨 AUTOMATED ISSUES DRAWER INJECTIONS: NETWORK EXCEPTIONS
        // =====================================================================
        // Inspect the returned payload metrics to catch live environmental risks
        if (isset($dns_payload['status']) && $dns_payload['status'] === 'executed') {

            // Alert A: Domain Phishing Exposure (Missing BOTH SPF and DMARC)
            if ($dns_payload['has_spf'] === false && $dns_payload['has_dmarc'] === false) {
                $fpa_results['issue_queue']['data']['rows'][] = [
                    'id'        => 'net_email_unauthenticated',
                    'type'      => 'danger',
                    'text'      => 'Critical: Domain Email Spoof Shields Absent.',
                    'solution'  => 'Your domain (' . htmlspecialchars($dns_payload['domain_checked']) . ') lacks both SPF and DMARC TXT records. Spammers can easily forge mail headers using your brand name, ruining your email delivery reputation. Log into your registrar DNS panel and add valid v=spf1 and v=dmarc1 protection records.',
                    'target_id' => 'fpa_issues_drawer'
                ];
            }
            // Alert B: Spoofing Vulnerability (Missing DMARC only)
            elseif ($dns_payload['has_dmarc'] === false) {
                $fpa_results['issue_queue']['data']['rows'][] = [
                    'id'        => 'net_dmarc_missing',
                    'type'      => 'warning',
                    'text'      => 'Warning: Domain Lacks DMARC Enforcement Protection.',
                    'solution'  => 'Without a valid DMARC policy record, your server cannot instruct downstream mail networks on how to handle failed message authentication checks. Add a text entry pointing to _dmarc.' . htmlspecialchars($dns_payload['domain_checked']) . ' configured with a baseline pass policy like p=quarantine.',
                    'target_id' => 'fpa_issues_drawer'
                ];
            }

            // Alert C: Severe IP Routing Failure (Reverse PTR Mismatch)
            if ($dns_payload['is_ip_mismatch'] === true) {
                $fpa_results['issue_queue']['data']['rows'][] = [
                    'id'        => 'net_ip_routing_mismatch',
                    'type'      => 'danger',
                    'text'      => 'Critical: Reverse DNS Pointer IP Routing Mismatch.',
                    'solution'  => 'Your domain name resolves to an IP address that points to an asymmetrical or different physical hardware system hostname (' . htmlspecialchars($dns_payload['reverse_ptr_record']) . '). This network discrepancy frequently trips spam blacklists and drops active payment webhook notifications. Contact your hosting support tier to coordinate a functional PTR alignment loop.',
                    'target_id' => 'fpa_issues_drawer'
                ];
            }
        }
    }

    if (function_exists('fpa_audit_php_extended')) {
        // Pull the flat list out of our blueprint array
        $checklist = array_merge(
            $fpa_results['php']['targets']['database_extensions'],
            $fpa_results['php']['targets']['required_extensions'],
            $fpa_results['php']['targets']['recommended_extensions']
        );

        // Feed the checklist directly into our standalone function
        // The function processes it and hands back the results.
        $extended_data = fpa_audit_php_extended($checklist);

        // Save the final result output into the exact designated subkey block
        $fpa_results['php']['data']['rows']['loaded_extensions'] = $extended_data;
    }

    ///if (in_array('permissions', $fpa_active_tests_to_run, true)) {
    /* temp disabled
    if (function_exists('fpa_do_permissions')) {
        // Dynamic scan loader collects all directories below your siteroot
        $all_discovered_directories = fpa_glob_recursive_utility($base_path);

        // Triggers the optional filesystem pass
        $fpa_results['permissions']['data'] = fpa_do_permissions(
            $fpa_results,
            $lang,
            $all_discovered_directories,
            $core_paths ?? [], // Exclusion List
            40                 // Circuit Breaker: Aborts scan if errors flood logs
        );
    } // end: fpa_do_permissions() - filesystem folders, excluding core folders
     */ // TEMP DUSABLED
    ///}
    // =========================================================================
    //  END RUNTIME PHASE 2: OPTIONAL TEST EXECUTION
    // =========================================================================


    /*
     * =========================================================================
     * RUNTIME PHASE 3: FINAL ISSUE & METRICS ENGINE AGGREGATION
     * =========================================================================
     * Trigger stack health and pillar calculations after every single baseline
     * and optional test finishes, plus sort the issues_queue.
     * =========================================================================
     */
    if (function_exists('fpa_do_keymetrics')) {
        // Feed the completely filled master results array into the metric calculator
        $fpa_results = fpa_do_keymetrics($fpa_results, $lang);
    }

    // Triage & sort the issue queue by severity
    if (function_exists('fpa_triage_issue_queue')) {
        // Extract the compiled raw exceptions map
        $raw_issue_rows = $fpa_results['issue_queue']['data']['rows'] ?? [];

        // Sort the exception rows automatically before rendering the frontend drawer.
        $fpa_results['issue_queue']['data']['rows'] = fpa_triage_issue_queue($raw_issue_rows);
    }

    // =========================================================================
    //  END RUNTIME PHASE 3: FINAL ISSUE & METRICS AGGREGATION EXECUTION
    // =========================================================================


    // Return all (mandatory and selected optinal) results back to the $fpa_results array
    return $fpa_results;
} // end: fpa_runtime_tests()

// =============================================================================
//  END SECTION: MASTER RUNNER ENGINE
// =============================================================================


/*
 * =============================================================================
 *  SECTION: CORE ENGINE PROCESSING & RUNTIME CONTROLLER
 * =============================================================================
 * This control block coordinates the entire back-end lifecycle of the FPA.
 * It reads the user configuration state, determines the required execution
 * queue, runs the targeted audit suites, and packages the final data engine.
 *
 * PHASE 1: THE REGISTRY MAP ($fpa_test_registry)
 *    The central database index linking front-end UI Bootstrap switch element
 *    IDs directly to their corresponding standalone PHP function strings.
 *
 * PHASE 2: THE ACTIVE QUEUE ($fpa_active_tests_to_run)
 *    A dynamic list filtered and compiled at runtime based on incoming user
 *    form options or preset selections. This list tells the engine exactly
 *    which optional audits are scheduled for execution during this lifecycle.
 *
 * PHASE 3: THE ENGINE RUNNER PROCESSING ($fpa_data)
 *    Executes `fpa_runtime_tests()`. This orchestrator function kicks off
 *    mandatory system checks, loops through the active optional test registry,
 *    manages internal working scopes ($fpa_results), formats presentation
 *    metadata, tracks developer benchmarks, and unifies all outputs into
 *    the single global production variable: $fpa_data.
 *
 * REMINDER TO ALL MAINTAINERS:
 * All heavy calculations and logic determinations happen ABOVE this block.
 * All visual rendering and interface rendering happen BELOW this block.
 * This controller is the hard boundary line between logic and presentation.
 * =============================================================================
 */

/*
 * =============================================================================
 *  CONFIGURATION: GLOBAL TEST REGISTRY MAP
 * =============================================================================
 * This registry acts as the routing directory for all optional audit modules.
 * It maps front-end UI elements directly to back-end execution logic.
 *
 * THE KEY-TO-FUNCTION TWO-WAY BRIDGE:
 *
 * 1. THE ARRAY KEY (e.g., 'show_components')
 *    This must match the EXACT text used in the 'name' and 'id' attributes of
 *    your Bootstrap 5 offcanvas HTML checkboxes/switches.
 *
 * 2. THE ARRAY VALUE (e.g., 'fpa_audit_components')
 *    This is the literal name string of the standalone PHP function defined at
 *    the top of the file that processes the specific audit logic.
 *
 * MAINTAINER NOTE:
 * To add a brand-new optional check section to the FPA tomorrow:
 *   Step A: Write the standalone function at the top of the file.
 *   Step B: Add a single row mapping line to this registry array below.
 *
 * Your new module will automatically register itself, draw its own toggle
 * switch inside the settings sidebar, and route cleanly through the runner!
 *
 * WARNING: Ensure all function name values are kept strictly lowercase
 * to maintain clean code patterns and avoid type errors.
 * =============================================================================
 */
$fpa_test_registry = [
    'show_joomlastats'           => 'fpa_audit_joomlastats',
    'show_php_extended'          => 'fpa_audit_php_extended',
    'show_database_extended'     => 'fpa_audit_database_extended',
    'show_permissions'           => 'fpa_do_permissions', // hybrid, mandatory & optional routine
    'show_components'            => 'fpa_audit_components',
    'show_modules'               => 'fpa_audit_modules',
    'show_plugins'               => 'fpa_audit_plugins',
    'show_languages'             => 'fpa_audit_languages',
    'show_libraries'             => 'fpa_audit_libraries',
    'show_manifests'             => 'fpa_audit_manifests',
    'show_templates'             => 'fpa_audit_templates',
    'show_filesystem'             => 'fpa_audit_filesystem',
];


/*
 * =============================================================================
 *  RUNTIME STATE: DETERMINING THE ACTIVE PROCESSING QUEUE
 * =============================================================================
 * This line builds the definitive list of optional tests scheduled to run
 * during this specific page load execution cycle.
 *
 * HOW THE STATE SELECTION LIFECYCLE WORKS:
 *
 * 1. THE FRONT-END TRIGGER:
 *    The user clicks the settings icon, opens the Bootstrap 5 offcanvas panel,
 *    toggles their preferred switches (or selects a preset button), and submits.
 *
 * 2. THE BACK-END EVALUATION:
 *    The `fpa_determine_active_switches()` helper function intercepts the incoming
 *    $_REQUEST or $_POST payload data. It filters those parameters against our
 *    master '$fpa_test_registry' to ensure only registered, safe modules are allowed.
 *
 * 3. THE RUNTIME OUTPUT ARRAY:
 *    The resulting variable '$fpa_active_tests_to_run' becomes a clean, flat
 *    list containing only the keys of the activated switches (e.g., ['show_ssl', 'show_components']).
 *
 * VOLUNTEER ARCHITECTURE NOTE:
 * This acts as the firewall and throttle for the application. If a user turns
 * off a section to save server resources, its key is omitted from this list,
 * completely preventing the resource-heavy audit function from executing.
 * =============================================================================
 */
// DELETEME: TEST DUMMY FUNCTION
function fpa_determine_active_switches() {

    // TEMP FIX
    return [];
}
/**
 * Keeps track of the active test functions registered for this runtime pass.
 * Maps submitted form settings switches into a sequential execution matrix.
 *
 * @var array<string, string> List of verified and filtered task keys to run
 */
$fpa_active_tests_to_run = fpa_determine_active_switches($fpa_test_registry);


/*
 * =============================================================================
 *  APPLICATION CONTROLLER: PROCESS ALL ACTIVE TESTS
 * =============================================================================
 * Kicks off the FPA processing engine. This line executes the master runner
 * function, passing the list of active tests requested by the user interface.
 *
 * EXTREMELY IMPORTANT SCOPE RULE FOR DEVELOPERS & VOLUNTEERS:
 *
 * 1. INTERNAL WORKING VARIABLES:
 *    While the tests are running inside the function, data is gathered in a
 *    temporary, private variable named '$fpa_results'. This variable is locked
 *    inside the function's memory scope and DOES NOT exist on the main page.
 *
 * 2. THE MAIN PRODUCTION VARIABLES (USE THIS IN YOUR HTML!):
 *    The completed dataset is returned and saved directly into '$fpa_data'.
 *    This global array variable is your SINGLE SOURCE OF OUTPUT TRUTH.
 *
 *  DO NOT try to use '$fpa_results' down in the HTML layout—it will be NULL.
 *  ALWAYS loop through and display data from the '$fpa_data' variable tree.
 *
 * Example:
 * Correct ->  foreach ($fpa_data['permissions']['data'] as $folder) { ... }
 * Wrong   ->  foreach ($fpa_results['permissions']['data'] as $folder) { ... }
 * =============================================================================
 */
/**
 * The final data package tracking core environment properties.
 * Consolidates metadata arrays, translations, and the floating issue queue.
 *
 * @var array<string, mixed> Single source of truth application data tree
 */
$fpa_data = fpa_runtime_tests(
    $lang,
    $fpa_active_tests_to_run,
    $fpa_test_registry,
    __DIR__,
    []
);
// =============================================================================
//  END SECTION: CORE ENGINE PROCESSING AND RUNTIME CONTROLLER
// =============================================================================


// =============================================================================
//  SECTION: COCKPIT PRESENTATION RUNTIME CONTROLLER
// =============================================================================
$fpa_data = fpa_runtime_tests($lang, $fpa_active_tests_to_run, $fpa_test_registry, __DIR__, []);


/*
 * =============================================================================
 * DEVELOPER MODE: DATA SIMULATION INJECTION ENGINE OVERRIDES
 * =============================================================================
 * To run simulation matrices locally, clone the 'fpa_simulation_datasets' GitHub
 * folder into a local folder named 'fpa_simulation_datasets' right next to this file.
 * Uncomment the specific target include paths below to override data states.
 * This section triggers exclusively when the global FPA_SIM constant is true.
 * =============================================================================
 */

/*
 * =============================================================================
 * DEVELOPER MODE: SIMULATOR DATA HARVESTER EXPORT (button) CONTROLLER
 * =============================================================================
 * Checks that developer mode is active before granting export paths and the
 * simulator data harvest button has passed a valid array key to dump in to a
 * troubleshooting simulator file (for use by FPA_SIM utility below the Master
 * Runner function).
 */
if (defined('FPA_DEV') && FPA_DEV === true && isset($_GET['fpa_export_sim'])) {

    // Wipe any early whitespace or server compression buffers cleanly
    while (ob_get_level() > 0) {
        ob_end_clean();
    }

    $target_key = trim((string)$_GET['fpa_export_sim']);

    // Safely check both the module data nodes and the root references node
    if (isset($fpa_data[$target_key]['data'])) {
        $export_payload = $fpa_data[$target_key]['data'];
    } elseif ($target_key === 'ref' && isset($fpa_data['ref'])) {
        $export_payload = $fpa_data['ref'];
    } else {
        $export_payload = null;
    }

    if ($export_payload !== null) {
        $filename = 'fpasim_' . $target_key . '_' . date('Y-m-d') . '.php';

        // Build an executable, production-ready, clean dataset array string
        $output  = "<?php\n";
        $output .= "declare(strict_types=1);\n\n";
        $output .= "/**\n * Captured FPA Environment Simulation Dataset\n";
        $output .= " * Target Node: \$fpa_data['" . $target_key . "']['data']\n";
        $output .= " * Generated: " . date('Y-m-d H:i:s UTC') . "\n */\n\n";
        $output .= "return " . var_export($export_payload, true) . ";\n";

        // Enforce the universal binary octet-stream attachment headers
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        header('Content-Length: ' . strlen($output));
        header('Cache-Control: no-cache, must-revalidate');
        header('Pragma: no-cache');

        echo $output;
        exit(); // HARD BREAK: Permanently blocks HTML text from appending!
    }
} // Developer Simulation Data Export Controller

/*
 * =============================================================================
 * DEVELOPER MODE: DATA SIMULATION INJECTION ENGINE OVERRIDES
 * =============================================================================
 * To run simulation matrices locally, clone the 'fpa_simulation_datasets' GitHub
 * folder into a local folder named 'fpa_simulation_datasets' right next to this file.
 * Uncomment the specific target include paths below to override data states.
 * This section triggers exclusively when the global FPA_SIM constant is true.
 * =============================================================================
 */
// STEP 1: Enable the FPA_SIM constant on line 159 (waaay back at the top)
if (defined('FPA_SIM') && FPA_SIM === true) {
    $fpa_sim_path = __DIR__ . '/fpa_simulation_datasets';
    $sim_active   = false;

    // STEP 2: Uncomment the desired sim data, remember to select any required
    // optional test suites required for the simulation to display in UI.
    if (is_dir($fpa_sim_path)) {
        // --- Layer 1: Global Architectural References Overwrites ---
        // $fpa_data['ref'] = include_once $fpa_sim_path . '/global_ref/windows_sandbox_ref.php';

        // --- Layer 2: PHP Directive Matrix Overrides ---
        // $fpa_data['php']['data']['ini_matrix'] = include_once $fpa_sim_path . '/php_ini_matrix/low_resource_cgi.php';
        // $fpa_data['php']['data']['ini_matrix'] = include_once $fpa_sim_path . '/php_ini_matrix/restrictive_hosting.php';

        // --- Layer 3: HTTP Web Server Overrides ---
        // $fpa_data['httpserver']['data'] = include_once $fpa_sim_path . '/httpserver/apache_mod_php_pristine.php';
        // $fpa_data['httpserver']['data'] = include_once $fpa_sim_path . '/httpserver/nginx_fpm_saturated.php';
        // $fpa_data['httpserver']['data'] = include_once $fpa_sim_path . '/httpserver/iis_windows_local.php';
        // $fpa_data['httpserver']['data'] = include_once $fpa_sim_path . '/httpserver/completely_broken_hosting.php';

        // --- Layer 4: Network DNS Security Overrides ---
        // $fpa_data['dns_security']['data'] = include_once $fpa_sim_path . '/dns_security/phishing_mismatch_alert.php';
        // $fpa_data['dns_security']['data'] = include_once $fpa_sim_path . '/dns_security/secure_domain_dns.php';
        // $fpa_data['dns_security']['data'] = include_once $fpa_sim_path . '/dns_security/ip_mismatch_nospamprotection.php';
        // $fpa_data['dns_security']['data'] = include_once $fpa_sim_path . '/dns_security/missing_dmarc.php';

        // --- Layer 4: Core Folders & Permissions Overrides ---
        // TODO: finish the sim data after new functions built
        // $fpa_data['corefolders']['data'] = include_once $fpa_sim_path . '/folder_permissions/corefolder_issues.php';
        // $fpa_data['corefolders']['data'] = include_once $fpa_sim_path . '/folder_permissions/funky_permissions.php';
    }

    // STEP 3: Re-trigger the master key metrics calculator on top of the spoofed
    // dataset. This forces the Stack Health Horseshoe Gauge and Pillars to adapt
    // to the scenario automatically!
    if (function_exists('fpa_do_keymetrics')) {
        $fpa_data = fpa_do_keymetrics($fpa_data, $lang);
    } // end: re-run the key metrics to update the pillar scores etc.
} // end: FPA_SIM enabled
// =============================================================================
//  END SECTION: DEVELOPER SIMULATION OVERRIDES
// =============================================================================


/*
 * =============================================================================
 * SECTION: OUTPUT COMPRESSION PERFORMANCE
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
/*
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
*/
// =============================================================================
//  END SECTION: OUTPUT COMPRESSION PERFORMANCE
// =============================================================================
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
        .bg-fpa, .bg-text-fpa {
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

        /* Rotates the progress track circle backward to pin the gap opening smoothly at the bottom */
        .transform-rotate-180 {
            transform: rotate(150deg);
            transform-origin: center;
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

        /* Print optimisation utilities */
        @media print {
            /* Vaporize the entire page structure and all body contents from print memory by default */
            body * {
                display: none !important;
            }

            /* FORCE ONLY the issues drawer container wrapper to remain active and visible */
            #fpa_issues_drawer,
            #fpa_issues_drawer * {
                display: block !important;
            }

            /* Unpin the drawer positioning logic entirely so it flows naturally like a flat page document */
            #fpa_issues_drawer {
                position: absolute !important;
                left: 0 !important;
                top: 0 !important;
                width: 100% !important;
                max-width: 100% !important;
                height: auto !important;
                overflow: visible !important; /* 🚀 CRUCIAL: Unlocks continuous vertical rendering */
                box-shadow: none !important;
                border: 0 !important;
                background: transparent !important;
                transform: none !important;
            }

            /* Strip out internal scrollers and tool buttons to save ink space */
            #fpa_issues_drawer .offcanvas-header,
            #fpa_issues_drawer .btn,
            #fpa_issues_drawer .btn-close {
                display: none !important;
            }

            /* Force the body container box to calculate height across multi-page breaks cleanly */
            #fpa_issues_drawer .offcanvas-body {
                overflow: visible !important; /* 🚀 CRUCIAL: Prevents clipping at page margins */
                height: auto !important;
                padding: 0 !important;
            }

            /* Enforce clean page breaks so individual risk items don't slice in half */
            #fpa_issues_drawer .card {
                page-break-inside: avoid !important;
                break-inside: avoid !important;
                margin-bottom: 1.5rem !important;
                border: 1px solid #dee2e6 !important;
                background-color: #ffffff !important;
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
                            <button form="nav-pdf-form" class="btn btn-outline-light" type="submit" accesskey="p"
                                data-bs-toggle="tooltip"
                                data-bs-trigger="hover focus"
                                data-bs-placement="bottom"
                                data-bs-title="PDF Report"
                                aria-label="Generate a PDF report of the FPA">
                                <i class="bi bi-filetype-pdf"></i>
                            </button>

                            <a role="button" class="btn btn-outline-light" rel="noreferrer noopener" href="<?php echo FPA_DOCS_URL; ?>" target="_blank"
                                data-bs-toggle="tooltip"
                                data-bs-trigger="hover focus"
                                data-bs-placement="bottom"
                                data-bs-title="<?php echo $lang['FPA_SHORT'] . ' ' . $lang['FPA_TXT_DOCUMENTATION']; ?>"
                                aria-label="<?php echo $lang['FPA_TXT_DOCUMENTATION']; ?>">
                                <i class="bi bi-book-half"></i>
                            </a>

                            <a role="button" class="btn btn-outline-light" rel="noreferrer noopener" href="<?php echo FPA_DOWNLOAD_ZIP_URL; ?>" target="_blank"
                                data-bs-toggle="tooltip"
                                data-bs-trigger="hover focus"
                                data-bs-placement="bottom"
                                data-bs-title="<?php echo $lang['FPA_TXT_DOWNLOADLATEST'] .' ' . $lang['FPA_SHORT']; ?>"
                                aria-label="<?php echo $lang['FPA_TXT_DOWNLOADLATEST'] .' ' . $lang['FPA_SHORT']; ?>">
                                <i class="bi bi-cloud-download-fill"></i>
                            </a>

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

                        <!--
                        <div class="btn-group" role="group" aria-label="Notifications Group">
                            -- NOTIFICATION DROPDOWN BLOCK --
                            -- The 'd-none' class ensures it stays completely invisible until JS updates it --
                            <div class="dropdown me-2 d-none" id="notification-wrapper">
                              <button class="btn btn-outline-warning position-relative dropdown-toggle hide-caret" type="button" data-bs-toggle="dropdown" Xdata-bs-display="static" data-bs-reference="parent">
                                <i class="bi bi-chat-right-dots-fill"></i>
                                -- Red Bootstrap Badge Counter --
                                <span class="position-absolute bottom-10 start-0 translate-middle badge rounded-pill bg-danger" id="queue-count">
                                  0
                                </span>
                              </button>

                              -- Dropdown Items list menu --
                              <ul class="dropdown-menu dropdown-menu-end shadow-sm position-absolute" id="queue-dropdown-items" style="width: 320px; max-height: 500px; overflow-y: auto;" data-bs-boundary="body">
                                -- JS will populate these dynamically --
                              </ul>
                            </div>
                        </div>
                        -->

                        <div class="btn-group" role="group" aria-label="FPA Actions Group">
                            <!-- delete FPA -->
                            <button form="nav-delete-form" class="btn btn-danger me-2" type="submit"
                                data-bs-toggle="tooltip"
                                data-bs-title="Delete the FPA script"
                                data-bs-placement="bottom"
                                aria-label="Delete the FPA script.">
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

        //phpinfo();
        echo '<pre>';
        print_r($fpa_data['issue_queue']);
        //print_r($fpa_data['ref']);
        //print_r($fpa_data['httpserver']);
        //print_r($fpa_data['php']);
        //print_r($fpa_data['corefolders']);
        //print_r($fpa_data['permissions']);
        //var_dump($nrequired_extensions);
        //var_dump($fpa_data['metrics']);
        print_r($fpa_data['key_metrics']);
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
        <!-- FPA SUITE EXECUTIVE READINESS SUMMARY COCKPIT -->
        <div class="container-fluid Xbg-secondary Xbg-opacity-10 pt-3 pb-5">
            <div id="fpa_metrics_dashboard" class="container Xcol-12 mb-4">

                <h2 class="border-bottom border-secondary p-2">
                    <i class="bi bi-speedometer text-secondary"></i> <?php echo htmlspecialchars($fpa_data['key_metrics']['meta']['section_title']); ?>
                </h2>

                <div id="<?php echo $fpa_data['php']['meta']['attribute_slug']; ?>" class="row g-4 d-md-flex align-items-md-stretch mt-2">

                    <div class="col-12 col-sm-12 Xcol-md-5 col-lg-3 Xd-flex Xflex-column Xjustify-content-center">

                        <h3 class="fs-5 fw-light Xtext-secondary text-uppercase tracking-wider mb-2">
                            <span class="fw-bold"><?php echo htmlspecialchars($lang['FPA_SUB_TITLE_STACK_HEALTH']); ?></span> <?php echo htmlspecialchars($lang['FPA_TXT_SUMMARY']); ?>
                        </h3>
                        <p>
                            <?php echo htmlspecialchars($lang['FPA_SUB_INTRO_STACK_HEALTH']); ?>
                        </p>

                    </div><!-- /col -->
                    <div class="col-12 col-sm-12 Xcol-md-7 col-lg-9">

                        <div class="row g-4 align-items-stretch">
                            <!-- Left Side: Stack health horseshoe guage -->
                            <div class="col-12 col-lg-5">

                                <div class="card h-100 shadow-sm border border-light-subtle rounded text-center bg-body-tertiary">
                                    <div class="card-body d-flex flex-column justify-content-center py-4">

                                        <h4 class="text-uppercase tracking-wider mb-1 fw-semibold fs-5">
                                            <?php echo htmlspecialchars($lang['FPA_SUB_TITLE_STACK_HEALTH'] . ' ' . $lang['FPA_TXT_ASSESSMENT']); ?>
                                        </h4>

                                        <!-- Pure SVG Vector Horseshoe Gauge Widget Geometry -->
                                        <div class="position-relative mx-auto" style="width: 250px; height: 160px;">
                                            <svg viewBox="0 0 160 160" width="100%" height="100%" class="transform-rotate-180">
                                                <circle cx="80" cy="80" r="60"
                                                    fill="transparent"
                                                    stroke="var(--bs-border-color-max-translucent, #e9ecef)"
                                                    stroke-width="14"
                                                    stroke-dasharray="377"
                                                    stroke-dashoffset="126"
                                                    stroke-linecap="round" />

                                                <!-- Dynamic Foreground Level Indicator Ring Layer -->
                                                <circle cx="80" cy="80" r="60"
                                                    fill="transparent"
                                                    stroke="var(--bs-<?php echo $fpa_data['key_metrics']['health']['status_color']; ?>)"
                                                    stroke-width="14"
                                                    stroke-dasharray="377"
                                                    stroke-dashoffset="<?php echo max(126, $fpa_data['key_metrics']['health']['dash_offset']); ?>"
                                                    stroke-linecap="round"
                                                    style="transition: stroke-dashoffset 0.8s ease-in-out;" />
                                            </svg>

                                            <div class="position-absolute top-50 start-50 translate-middle text-center mt-2">
                                                <div class="display-5 fw-bold text-dark-emphasis lh-1" style="letter-spacing: -0.2rem;">
                                                    <?php echo $fpa_data['key_metrics']['health']['score']; ?><span class="fs-5 text-muted">%</span>
                                                </div>
                                                <div class="badge mt-2 fs-6 bg-<?php echo $fpa_data['key_metrics']['health']['status_color']; ?>-subtle text-<?php echo $fpa_data['key_metrics']['health']['status_color']; ?>-emphasis border">
                                                    Grade <?php echo htmlspecialchars($fpa_data['key_metrics']['health']['grade']); ?>
                                                </div>
                                            </div>
                                        </div><!-- /horseshoe svg guage container -->

                                        <div class="alert alert-<?php echo $fpa_data['key_metrics']['health']['status_color']; ?> my-0 lh-sm">
                                            <?php echo htmlspecialchars($fpa_data['key_metrics']['health']['description']); ?>
                                        </div>

                                    </div><!-- /card-body -->
                                </div><!-- /card -->

                            </div><!-- /col -->
                            <!-- Right Side: Individual metric pillars cards -->
                            <div class="col-12 col-lg-7">

                                <div class="row row-cols-1 row-cols-sm-2 g-3 h-100">

                                    <?php foreach ($fpa_data['key_metrics']['pillars'] as $pillar_key => $metrics): ?>
                                    <div class="col">

                                        <!-- Individual category panel card -->
                                        <div class="card Xh-100 shadow-sm border border-light-subtle rounded bg-body-tertiary bg-<?php echo $metrics['status_color']; ?>-subtle">
                                            <div class="card-body p-3 d-flex flex-column justify-content-between">

                                                <!-- Category heading -->
                                                <div class="d-flex justify-content-between align-items-center mb-2">
                                                    <span class="fw-semibold text-dark-emphasis font-monospace text-uppercase small" style="letter-spacing: 0.3px;">
                                                        <i class="bi bi-circle-fill text-<?php echo $metrics['status_color']; ?> me-1" style="font-size: 0.85rem;"></i>
                                                        <?php echo htmlspecialchars($metrics['label']); ?>
                                                    </span>
                                                    <span class="fw-bold fs-5 text-<?php echo $metrics['status_color']; ?>-emphasis lh-1">
                                                        <?php echo $metrics['percentage']; ?><span class="fs-7 text-muted fw-normal">%</span>
                                                    </span>
                                                </div>

                                                <!-- Category progress bar -->
                                                <div class="progress rounded-pill bg-body-secondary border-0 mb-2" style="height: 15px;"
                                                    role="progressbar"
                                                    aria-valuenow="<?php echo $metrics['percentage']; ?>"
                                                    aria-valuemin="0"
                                                    aria-valuemax="100">
                                                    <div class="progress-bar rounded-pill bg-<?php echo $metrics['status_color']; ?> progress-bar-striped progress-bar-animated"
                                                       style="width: <?php echo $metrics['percentage']; ?>%;">
                                                    </div>
                                                </div>

                                                <!-- Category description -->
                                                <div class="text-muted lh-sm" style="font-size: 0.85rem;">
                                                    <?php
                                                    // Resolve matching dictionary key, e.g. $lang['FPA_USER_METRIC_DESC_SECURITY']
                                                    $lang_key = 'FPA_USER_METRIC_DESC_' . strtoupper($pillar_key);
                                                    echo htmlspecialchars($lang[$lang_key] ?? 'Tracks environment compliance thresholds.');
                                                    ?>
                                                </div>

                                            </div><!-- /card-body -->
                                        </div><!-- /card -->

                                    </div><!-- /col -->
                                    <?php endforeach; ?>

                                </div><!-- /row -->

                            </div><!-- /col -->

                        </div><!-- /row -->

                    </div><!-- /col -->

                </div><!-- /row -->

            </div><!-- /container fpa_metrics_dashboard -->
        </div><!-- /container-fluid -->






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

            </div><!-- /row -->

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

            <?php
            /*
             * =============================================================================
             * SECTION: PHP DISCOVERY
             * =============================================================================
             * Confirmation of PHP configuration, includes;
             * - Database Interfaces
             * - Required Extensions
             * - Recommended Extensions
             * - other Loaded Extensions
             * - common host ini settings (master php settings)
             * - common local overriden ini settings (php.ini/user.ini in web-root and administrator)
             */
            ?>
            <div id="<?php echo $fpa_data['php']['meta']['attribute_slug']; ?>" class="row g-4 d-md-flex align-items-md-stretch mt-2">
                <div class="col-12 col-sm-12 Xcol-md-5 col-lg-3 Xd-flex Xflex-column Xjustify-content-center">

                    <h3 class="fs-5 fw-light Xtext-secondary text-uppercase tracking-wider mb-2">
                        <span class="fw-bold"><?php echo htmlspecialchars($fpa_data['php']['meta']['section_title']); ?></span> <?php echo htmlspecialchars($lang['FPA_TXT_SUMMARY']); ?>
                    </h3>

                    <p><?php echo htmlspecialchars($fpa_data['php']['meta']['section_title']); ?></p>

                    <button type="button" class="btn btn-outline-secondary btn-sm Xmb-3 Xms-auto" id="toggle_all<?php echo $fpa_data['php']['meta']['attribute_slug']; ?>_btn" data-fpa-toggle="all<?php echo $fpa_data['php']['meta']['attribute_slug']; ?>" >
                        <i class="bi bi-eye me-1"></i> Toggle All
                    </button>

                </div>
                <div class="col-12 col-sm-12 Xcol-md-7 col-lg-9">

                    <?php
                    // Live PHP Memory Footprint Resourcing
                    ?>
                    <div id="<?php echo $fpa_data['php']['meta']['attribute_slug']; ?>-memory-usage" class="card shadow-sm mb-4 border rounded overflow-hidden">
                      <div class="card-body bg-light-subtle">

                        <div class="row align-items-center g-3">

                          <!-- Column 1: Component Header & Metric Titles -->
                          <div class="col-12 col-md-4">
                            <h3 class="h6 text-uppercase tracking-wider text-muted mb-1 fw-semibold small">
                              <?php echo htmlspecialchars($lang['FPA_LABEL_RAM_FOOTPRINT'] ?? 'PHP Memory Footprint'); ?>
                            </h3>
                            <div class="d-flex align-items-baseline gap-2">
                              <!-- Live Peak Usage Metric Display -->
                              <span class="fs-3 fw-bold text-dark-emphasis lh-1">
                                <?php echo htmlspecialchars($fpa_data['php']['data']['memory_footprint']['peak_usage']); ?>
                              </span>
                              <span class="text-muted small">
                                / <?php echo htmlspecialchars($fpa_data['php']['data']['memory_footprint']['limit_raw']); ?> Max Memory
                              </span>
                            </div>
                          </div>

                          <!-- Column 2: Dynamic Hardware Progress Meter Bar -->
                          <div class="col-12 col-md-5">
                            <div class="d-flex justify-content-between mb-1 small text-muted">
                              <span>Active Compiler Load State</span>
                              <span class="fw-medium text-<?php echo $fpa_data['php']['data']['memory_footprint']['sanity_state']; ?>-emphasis">
                                <?php echo $fpa_data['php']['data']['memory_footprint']['usage_percentage']; ?>% Used
                              </span>
                            </div>

                            <!-- Bootstrap 5 Progress Meter bar component with variable responsive state colors -->
                            <div class="progress rounded-pill bg-body-secondary" style="height: 10px;" role="progressbar" aria-label="PHP Memory Usage Tracker" aria-valuenow="<?php echo $fpa_data['php']['data']['memory_footprint']['usage_percentage']; ?>" aria-valuemin="0" aria-valuemax="100">
                              <div class="progress-bar rounded-pill bg-<?php echo $fpa_data['php']['data']['memory_footprint']['sanity_state']; ?> progress-bar-striped progress-bar-animated"
                                   style="width: <?php echo min(100, $fpa_data['php']['data']['memory_footprint']['usage_percentage']); ?>%;">
                              </div>
                            </div>
                          </div>

                          <!-- Column 3: Live Analytical Status Readout Info Window -->
                          <div class="col-12 col-md-3 border-start-md ps-md-4">
                            <span class="badge border bg-<?php echo $fpa_data['php']['data']['memory_footprint']['sanity_state']; ?>-subtle text-<?php echo $fpa_data['php']['data']['memory_footprint']['sanity_state']; ?>-emphasis rounded-pill mb-1">
                              <?php echo ($fpa_data['php']['data']['memory_footprint']['sanity_state'] === 'success') ? 'Optimal' : 'Performance Warning'; ?>
                            </span>
                            <div class="text-muted small lh-sm">
                              Current session snapshot: <code><?php echo htmlspecialchars($fpa_data['php']['data']['memory_footprint']['current_usage']); ?></code> loaded at core script initialization.
                            </div>
                          </div>

                        </div>

                        <!-- ⚠️ Conditional Threat Advice Notification Line Footer Row -->
                        <?php if ($fpa_data['php']['data']['memory_footprint']['sanity_message'] !== ''): ?>
                          <div class="alert alert-warning border border-warning-subtle text-warning-emphasis small mb-0 mt-3 d-flex align-items-center gap-2 py-2">
                            <span class="fs-5 lh-1">⚠️</span>
                            <div><?php echo htmlspecialchars($fpa_data['php']['data']['memory_footprint']['sanity_message']); ?></div>
                          </div>
                        <?php endif; ?>

                      </div>
                    </div>

                    <?php
                    // PHP Upload Temporary Directory Audit
                    ?>
                    <div id="<?php echo $fpa_data['php']['meta']['attribute_slug']; ?>-upload-tmp" class="card shadow-sm mb-4 border rounded overflow-hidden">
                        <div class="card-body bg-light-subtle">

                            <div class="row align-items-center g-3">

                                <!-- Header & Write Permissions State -->
                                <div class="col-12 col-md-4">
                                    <h3 class="h6 text-uppercase tracking-wider text-muted mb-1 fw-semibold small">
                                        <?php echo htmlspecialchars($lang['FPA_LABEL_TMP_DIR'] ?? 'Upload Staging Environment'); ?>
                                    </h3>
                                    <div class="d-flex align-items-baseline gap-2">
                                        <!-- Live Status Text Readout -->
                                        <span class="fs-3 fw-bold lh-1 text-<?php echo $fpa_data['php']['data']['upload_tmp']['sanity_state'] === 'success' ? 'success-emphasis' : 'danger'; ?>">
                                            <?php echo htmlspecialchars($fpa_data['php']['data']['upload_tmp']['status_text']); ?>
                                        </span>
                                        <span class="text-muted small">
                                            Staging Operations Status
                                        </span>
                                    </div>
                                </div>

                                <!-- Resolved Directory Absolute Path Location -->
                                <div class="col-12 col-md-5">
                                    <span class="text-muted small d-block mb-1">Resolved Temp Storage Path:</span>
                                    <div class="text-truncate bg-body-secondary px-3 py-1 rounded font-monospace small text-dark-emphasis border"
                                        data-bs-toggle="tooltip"
                                        data-bs-placement="top"
                                        data-bs-title="<?php echo htmlspecialchars($fpa_data['php']['data']['upload_tmp']['path_location']); ?>">
                                        <?php echo htmlspecialchars($fpa_data['php']['data']['upload_tmp']['path_location']); ?>
                                    </div>
                                </div>

                                <!-- Analytical Status Badge -->
                                <div class="col-12 col-md-3 border-start-md ps-md-4">
                                    <span class="badge border bg-<?php echo $fpa_data['php']['data']['upload_tmp']['sanity_state']; ?>-subtle text-<?php echo $fpa_data['php']['data']['upload_tmp']['sanity_state']; ?>-emphasis rounded-pill mb-1">
                                        <?php echo $fpa_data['php']['data']['upload_tmp']['sanity_state'] === 'success' ? 'Functional' : 'Staging Locked'; ?>
                                    </span>
                                    <div class="text-muted small lh-sm">
                                        File system integrity: Core upload temporary directories must be writeable by the active PHP service engine.
                                    </div>
                                </div>

                            </div>

                            <!-- Conditional Advice Notification Footer -->
                            <?php if ($fpa_data['php']['data']['upload_tmp']['sanity_message'] !== ''): ?>
                            <div class="alert alert-danger border border-danger-subtle text-danger-emphasis small mb-0 mt-3 d-flex align-items-center gap-2 py-2">
                                <div><?php echo htmlspecialchars($fpa_data['php']['data']['upload_tmp']['sanity_message']); ?></div>
                            </div>
                            <?php endif; ?>

                        </div>
                    </div>

                    <?php
                    /**
                     * Complete php extension & directive audit to display required, recommended,
                     * other loaded extensions, ini directive settings, overrides & sanity review
                     */
                    ?>
                    <div id="inner_php_extensions" class="row g-4 g-md-5 row-cols-2">

                        <div id="inner_php_req_ext" class="col mb-3">


<!-- REQUIRED PHP EXTENSIONS AUDIT SECTION -->

  <!-- 📌 MODERN SLEEK HEADING LAYOUT: Borderless, clean, and free of card clutter -->
  <div class="d-flex justify-content-between align-items-baseline mb-3 border-bottom pb-2">
    <div>
      <h3 class="h5 text-dark-emphasis mb-0 text-uppercase tracking-wide small font-semibold">
        <?php echo htmlspecialchars($lang['FPA_LABEL_PHP_REQ_EXTENSIONS']); ?>
      </h3>
      <p class="text-muted small mb-0">Mandatory system modules required for baseline application execution.</p>
    </div>
    <!-- Clean, neutral subtle counter badge -->
    <span class="badge border bg-body-secondary text-dark-emphasis rounded-pill font-monospace small">
      <?php echo count($fpa_data['php']['data']['rows']['required_extensions']); ?> Checked
    </span>
  </div>

  <!-- 🟢 Conditional Overall Success Exception Alert Banner Row -->
  <?php if (isset($fpa_data['php']['exceptions']['required_extensions']['msg']) && !empty($fpa_data['php']['exceptions']['required_extensions']['msg'])): ?>
    <div class="alert alert-success border border-success-subtle text-success-emphasis text-center mb-3 d-flex flex-column align-items-center gap-2 py-3 shadow-sm" role="alert">
      <i class="bi bi-shield-check text-success fs-1 lh-1"></i>
      <div class="fw-medium"><?php echo htmlspecialchars($fpa_data['php']['exceptions']['required_extensions']['msg']); ?></div>
    </div>
  <?php endif; ?>

  <!-- 📦 THE CRISP SEPARATION GRID: Keeps highly defined physical item boxes intact -->
  <div class="row row-cols-2 row-cols-sm-3 row-cols-md-4 row-cols-lg-3 g-3 text-center">
    <?php foreach ($fpa_data['php']['data']['rows']['required_extensions'] as $extension => $value): ?>
      <?php
        $fpa_toggle_all_class = '';
        if ($value['version'] !== $lang['FPA_TXT_MISSING']) {
            $fpa_toggle_all_class = 'd-none fpa-toggle-all' . $fpa_data['php']['meta']['attribute_slug'];
        }
      ?>

      <div class="col <?php //echo $fpa_toggle_all_class; ?>">
        <div class="card w-100 h-100 shadow-sm border rounded overflow-hidden border-<?php echo $value['status_color']; ?>">

          <!-- Extension Name Title Tag (Uses high-contrast accessible styling tokens) -->
          <div class="card-header py-2 font-monospace fw-bold text-<?php echo $value['status_color']; ?>-emphasis bg-<?php echo $value['status_color']; ?>-subtle border-bottom border-<?php echo $value['status_color']; ?>">
            <?php echo htmlspecialchars($extension); ?>
          </div>

          <!-- Live Extracted Version Metrics Data Area Row -->
          <div class="card-body p-2 bg-body text-dark-emphasis small fw-medium">
            <?php echo htmlspecialchars($value['version']); ?>
          </div>

        </div>
      </div>
    <?php endforeach; ?>
  </div><!-- /row -->

  <!-- DEVELOPER TOOLS DIAGNOSTIC PANEL -->
  <?php if (defined('FPA_DEV') && FPA_DEV): ?>
    <div class="mt-4 pt-3 border-top">
      <div class="small text-muted text-uppercase tracking-wider fw-bold mb-2 font-monospace">
        Internal Data Stream Blueprint Debug
      </div>
      <pre class="bg-dark text-success p-3 rounded overflow-auto mb-0" style="max-height: 250px; font-size: 0.8rem; line-height: 1.4;">
        <?php print_r($fpa_data['php']['data']['rows']['required_extensions']); ?>
      </pre>
    </div>
  <?php endif; ?>


                        </div><!-- /col inner-php_req_ext -->

                        <div id="inner_php_rec_ext" class="col mb-3">


<!-- RECOMMENDED PHP EXTENSIONS AUDIT SECTION -->

  <!-- 📌 MODERN SLEEK HEADING LAYOUT: Borderless, clean, and free of card clutter -->
  <div class="d-flex justify-content-between align-items-baseline mb-3 border-bottom pb-2">
    <div>
      <h3 class="h5 text-dark-emphasis mb-0 text-uppercase tracking-wide small font-semibold">
        <?php echo htmlspecialchars($lang['FPA_LABEL_PHP_REC_EXTENSIONS']); ?>
      </h3>
      <p class="text-muted small mb-0">Optional modules recommended for optimal performance and advanced feature support.</p>
    </div>
    <!-- Clean, neutral subtle counter badge -->
    <span class="badge border bg-body-secondary text-dark-emphasis rounded-pill font-monospace small">
      <?php echo count($fpa_data['php']['data']['rows']['recommended_extensions']); ?> Checked
    </span>
  </div>

  <!-- 🟢 Conditional Overall Success Exception Alert Banner Row -->
  <?php if (isset($fpa_data['php']['exceptions']['recommended_extensions']['msg']) && !empty($fpa_data['php']['exceptions']['recommended_extensions']['msg'])): ?>
    <div class="alert alert-success border border-success-subtle text-success-emphasis text-center mb-3 d-flex flex-column align-items-center gap-2 py-3 shadow-sm" role="alert">
      <i class="bi bi-shield-check text-success fs-1 lh-1"></i>
      <div class="fw-medium"><?php echo htmlspecialchars($fpa_data['php']['exceptions']['recommended_extensions']['msg']); ?></div>
    </div>
  <?php endif; ?>

  <!-- 📦 THE CRISP SEPARATION GRID: Keeps highly defined physical item boxes intact -->
  <div class="row row-cols-2 row-cols-sm-3 row-cols-md-4 row-cols-lg-3 g-3 text-center">
    <?php foreach ($fpa_data['php']['data']['rows']['recommended_extensions'] as $extension => $value): ?>
      <?php
        $fpa_toggle_all_class = '';
        if ($value['version'] !== $lang['FPA_TXT_MISSING']) {
            $fpa_toggle_all_class = 'd-none fpa-toggle-all' . $fpa_data['php']['meta']['attribute_slug'];
        }
      ?>

      <div class="col <?php //echo $fpa_toggle_all_class; ?>">
        <div class="card w-100 h-100 shadow-sm border rounded overflow-hidden border-<?php echo $value['status_color']; ?>">

          <!-- Extension Name Title Tag (Uses high-contrast accessible styling tokens) -->
          <div class="card-header py-2 font-monospace fw-bold text-<?php echo $value['status_color']; ?>-emphasis bg-<?php echo $value['status_color']; ?>-subtle border-bottom border-<?php echo $value['status_color']; ?>">
            <?php echo htmlspecialchars($extension); ?>
          </div>

          <!-- Live Extracted Version Metrics Data Area Row -->
          <div class="card-body p-2 bg-body text-dark-emphasis small fw-medium">
            <?php echo htmlspecialchars($value['version']); ?>
          </div>

        </div>
      </div>
    <?php endforeach; ?>
  </div><!-- /row -->

  <!-- DEVELOPER TOOLS DIAGNOSTIC PANEL -->
  <?php if (defined('FPA_DEV') && FPA_DEV): ?>
    <div class="mt-4 pt-3 border-top">
      <div class="small text-muted text-uppercase tracking-wider fw-bold mb-2 font-monospace">
        Internal Data Stream Blueprint Debug
      </div>
      <pre class="bg-dark text-success p-3 rounded overflow-auto mb-0" style="max-height: 250px; font-size: 0.8rem; line-height: 1.4;">
        <?php print_r($fpa_data['php']['data']['rows']['recommended_extensions']); ?>
      </pre>
    </div>
  <?php endif; ?>


                        </div><!-- /col inner_php_rec_ext -->

                        <div id="inner_php_loaded_ext" class="col-12 mb-4">



<!-- OTHER LOADED EXTENSIONS AUDIT SECTION -->


  <!-- 📌 THE NEW PREFERRED HEADING LAYOUT: Modern, sleek, and free of card clutter -->
  <div class="d-flex justify-content-between align-items-baseline mb-3 border-bottom pb-2">
    <div>
      <h3 class="h5 text-dark-emphasis mb-0 text-uppercase tracking-wide small font-semibold">
        <?php echo htmlspecialchars($lang['FPA_LABEL_PHP_LOADED_EXTENSIONS']); ?>
      </h3>
      <p class="text-muted small mb-0">Auxiliary modules running in the active hosting environment stack.</p>
    </div>
    <!-- Clean, neutral subtle counter badge -->
    <span class="badge border bg-body-secondary text-dark-emphasis rounded-pill font-monospace small">
      <?php echo count($fpa_data['php']['data']['rows']['loaded_extensions']); ?> Discovered
    </span>
  </div>

  <!-- 📦 THE CRISP SEPARATION GRID: Keeps your highly defined physical item boxes intact! -->
  <div class="row row-cols-2 row-cols-sm-3 row-cols-md-4 row-cols-lg-6 g-3 text-center">
    <?php foreach ($fpa_data['php']['data']['rows']['loaded_extensions'] as $extension => $value): ?>

      <div class="col">
        <!-- Individual, highly-defined child card with accessible status borders -->
        <div class="card w-100 h-100 shadow-sm border rounded overflow-hidden border-<?php echo $value['status_color']; ?>">

          <!-- Extension Name Title Tag (Uses high-contrast accessible styling tokens) -->
          <div class="card-header py-1 font-monospace fw-semibold small text-<?php echo $value['status_color']; ?>-emphasis bg-<?php echo $value['status_color']; ?>-subtle border-bottom border-<?php echo $value['status_color']; ?>">
            <?php echo htmlspecialchars($extension); ?>
          </div>

          <!-- Extension Version Field -->
          <div class="card-body p-2 bg-body text-muted small font-monospace fw-medium">
            <?php echo htmlspecialchars($value['version']); ?>
          </div>

        </div>
      </div>

    <?php endforeach; ?>
  </div><!-- /row -->

  <!-- DEVELOPER TOOLS DIAGNOSTIC PANEL -->
  <?php if (defined('FPA_DEV') && FPA_DEV): ?>
    <div class="mt-4 pt-3 border-top">
      <div class="small text-muted text-uppercase tracking-wider fw-bold mb-2 font-monospace">
        Internal Data Stream Blueprint Debug
      </div>
      <pre class="bg-dark text-success p-3 rounded overflow-auto mb-0" style="max-height: 250px; font-size: 0.8rem; line-height: 1.4;">
        <?php print_r($fpa_data['php']['data']['rows']['loaded_extensions']); ?>
      </pre>
    </div>
  <?php endif; ?>


                        </div><!-- /col inner_php_loaded_ext -->

                    </div><!-- /row inner_php_extensions -->

                </div><!-- /col -->
            </div><!-- /row -->


           <div id="<?php echo $fpa_data['php']['meta']['attribute_slug']; ?>" class="row g-4 d-md-flex align-items-md-stretch mt-2">
                <div class="col-12 col-sm-12 Xcol-md-5 col-lg-3 Xd-flex Xflex-column Xjustify-content-center">

                    <h3 class="fs-5 fw-light Xtext-secondary text-uppercase tracking-wider mb-2">
                        <span class="fw-bold"><?php echo htmlspecialchars($lang['FPA_SUB_TITLE_PHP_INI_SETTINGS']); ?></span> <?php echo htmlspecialchars($lang['FPA_TXT_MATRIX']); ?>
                    </h3>

                    <p><?php echo htmlspecialchars($fpa_data['php']['meta']['section_title']); ?></p>

                    <button type="button" class="btn btn-outline-secondary btn-sm Xmb-3 Xms-auto" id="toggle_all<?php echo $fpa_data['php']['meta']['attribute_slug']; ?>_btn" data-fpa-toggle="all<?php echo $fpa_data['php']['meta']['attribute_slug']; ?>" >
                        <i class="bi bi-eye me-1"></i> Toggle All
                    </button>

                </div><!-- /col -->
                <div class="col-12 col-sm-12 Xcol-md-7 col-lg-9">

                    <div id="inner_php_ini_settings" class="col-12 mb-3">

                        <!-- SYSTEM CONFIGURATION MULTI-LAYER MATRIX OVERRIDE REPORT -->
                        <div id="fpa_ini_matrix_wrapper" class="col-12 mb-4">

                            <!-- Section Title & Meta Header Block -->
                            <div class="d-flex justify-content-between align-items-baseline mb-3 border-bottom pb-2">
                                <div>
                                    <h3 class="h5 text-dark-emphasis mb-0 text-uppercase tracking-wide small font-semibold">
                                       PHP Directives
                                    </h3>
                                    <p class="text-muted Xsmall mb-0">
                                        Tracks file system configuration paths and verifies active directive override deployments.
                                    </p>
                                    <div class="alert alert-info small my-2">
                                        <i class="bi bi-info-circle-fill me-1 lh-1"></i>
                                        <?php echo 'Current TTL: ' . ini_get('user_ini.cache_ttl') . ' seconds.<br>'; ?>
                                        <?php echo htmlspecialchars($lang['FPA_USER_PHP_CACHE_TIME_MSG']); ?>
                                    </div>
                                </div>
                            </div>

                          <!-- Rounded Mask Outer Grid Container Layer -->
                          <div class="border rounded shadow-sm overflow-hidden mb-0">
                            <div class="table-responsive">
                              <table class="table table-hover table-bordered align-middle mb-0" style="font-size: 0.875rem;">

                                <!-- Subtle Frosted-Glass Multi-Level Sticky Header Cells -->
                                <thead>
                                  <tr>
                                    <th scope="col" rowspan="3" class="position-sticky top-0 z-3 bg-light-subtle text-dark-emphasis text-uppercase tracking-wider ps-3 border-bottom-0" style="font-size: 0.725rem; font-weight: 700; vertical-align: middle;">Directive</th>
                                    <th scope="col" rowspan="3" class="position-sticky top-0 z-3 bg-light-subtle text-dark-emphasis text-uppercase tracking-wider text-center d-none d-sm-table-cell border-bottom-0" style="font-size: 0.725rem; font-weight: 700; width: 90px; vertical-align: middle;">Global</th>
                                    <th scope="col" colspan="2" class="position-sticky top-0 z-3 bg-light-subtle text-muted text-uppercase tracking-wider text-center d-none d-md-table-cell border-bottom border-light-subtle" style="font-size: 0.725rem; font-weight: 700;">Webroot</th>
                                    <th scope="col" colspan="2" class="position-sticky top-0 z-3 bg-light-subtle text-muted text-uppercase tracking-wider text-center d-none d-md-table-cell border-bottom border-light-subtle" style="font-size: 0.725rem; font-weight: 700;">Administrator</th>
                                    <th scope="col" rowspan="3" class="position-sticky top-0 z-3 bg-light-subtle text-dark-emphasis text-uppercase tracking-wider text-center ps-2 border-bottom-0" style="font-size: 0.725rem; font-weight: 700; width: 110px; vertical-align: middle;">Override Status</th>
                                  </tr>
                                  <tr>
                                    <!-- File Discovery Dot Markers -->
                                    <th scope="col" class="position-sticky top-0 z-3 bg-light-subtle text-center p-1 d-none d-md-table-cell border-bottom-0" style="width: 90px;">
                                      <i class="bi bi-circle-fill text-<?php echo !empty($fpa_data['php']['ini_files']['web_root_user_ini']) ? 'success' : 'danger'; ?>" style="font-size: 0.65rem;"></i>
                                    </th>
                                    <th scope="col" class="position-sticky top-0 z-3 bg-light-subtle text-center p-1 d-none d-md-table-cell border-bottom-0" style="width: 90px;">
                                      <i class="bi bi-circle-fill text-<?php echo !empty($fpa_data['php']['ini_files']['web_root_php_ini']) ? 'success' : 'secondary opacity-50'; ?>" style="font-size: 0.65rem;"></i>
                                    </th>
                                    <th scope="col" class="position-sticky top-0 z-3 bg-light-subtle text-center p-1 d-none d-md-table-cell border-bottom-0" style="width: 90px;">
                                      <i class="bi bi-circle-fill text-<?php echo !empty($fpa_data['php']['ini_files']['admin_user_ini']) ? 'success' : 'secondary opacity-50'; ?>" style="font-size: 0.65rem;"></i>
                                    </th>
                                    <th scope="col" class="position-sticky top-0 z-3 bg-light-subtle text-center p-1 d-none d-md-table-cell border-bottom-0" style="width: 90px;">
                                      <i class="bi bi-circle-fill text-<?php echo !empty($fpa_data['php']['ini_files']['admin_php_ini']) ? 'success' : 'muted opacity-25'; ?>" style="font-size: 0.65rem;"></i>
                                    </th>
                                  </tr>
                                  <tr>
                                    <th scope="col" class="position-sticky top-0 z-3 bg-light-subtle text-muted text-center text-lowercase d-none d-md-table-cell border-bottom" style="font-size: 0.7rem; font-weight: 600; width: 90px;">.user.ini</th>
                                    <th scope="col" class="position-sticky top-0 z-3 bg-light-subtle text-muted text-center text-lowercase d-none d-md-table-cell border-bottom" style="font-size: 0.7rem; font-weight: 600; width: 90px;">php.ini</th>
                                    <th scope="col" class="position-sticky top-0 z-3 bg-light-subtle text-muted text-center text-lowercase d-none d-md-table-cell border-bottom" style="font-size: 0.7rem; font-weight: 600; width: 90px;">.user.ini</th>
                                    <th scope="col" class="position-sticky top-0 z-3 bg-light-subtle text-muted text-center text-lowercase d-none d-md-table-cell border-bottom" style="font-size: 0.7rem; font-weight: 600; width: 90px;">php.ini</th>
                                  </tr>
                                </thead>

                                <tbody>
                                  <?php $current_category = ''; ?>
                                  <?php foreach ($fpa_data['php']['data']['rows']['ini_matrix'] as $directive => $value): ?>

                                    <!-- Category Divider Header rows -->
                                    <?php if ($current_category !== $value['category']): ?>
                                      <?php $current_category = $value['category']; ?>
                                      <tr class="table-light">
                                        <td colspan="7" class="ps-3 py-2 bg-body-secondary text-uppercase tracking-wider fw-bold text-muted" style="font-size: 0.725rem; letter-spacing: 0.5px;">
                                          <i class="bi bi-tag-fill me-1"></i><?php echo htmlspecialchars($current_category); ?> Directives
                                        </td>
                                      </tr>
                                    <?php endif; ?>

                                    <!-- Row background alerts ONLY if the physical file override configuration is failed/broken -->
                                    <tr class="<?php echo ($value['override_status'] === 'failed') ? 'table-warning' : ''; ?>">

                                      <!-- Directive Column -->
                                      <td class="ps-3 fw-medium Xtext-dark-emphasis <?php echo ($value['override_status'] === 'failed') ? 'text-warning-emphasis' : ''; ?>">
                                        <?php echo htmlspecialchars($value['directive_name']); ?>
                                      </td>

                                      <!-- Global Server Cell -->
                                      <td class="text-center text-secondary d-none d-sm-table-cell <?php echo $value['classes']['global']; ?>">
                                        <?php if ($value['directive_name'] === 'disable_functions' && $value['global_value'] != '-'): ?>
                                            <div class="overflow-auto font-monospace mx-auto text-start Xbg-dark Xtext-white p-1 Xrounded" style="max-height: 50px; width: 100px; line-height: 1.1; font-size: 0.7rem;">
                                                <?php echo str_replace(',', '<br>', htmlspecialchars($value['global_value'])); ?>
                                            </div>
                                        <?php else: ?>
                                            <?php echo htmlspecialchars($value['global_value']); ?>
                                        <?php endif; ?>
                                      </td>

                                      <!-- Webroot .user.ini Cell -->
                                      <td class="text-center text-secondary d-none d-md-table-cell <?php echo $value['classes']['web_root_user']; ?>">
                                        <?php if ($value['directive_name'] === 'disable_functions' && $value['web_root_user'] != '-'): ?>
                                            <div class="overflow-auto font-monospace mx-auto text-start Xbg-dark Xtext-white p-1 Xrounded" style="max-height: 50px; width: 100px; line-height: 1.1; font-size: 0.7rem;">
                                                <?php echo str_replace(',', '<br>', htmlspecialchars($value['web_root_user'])); ?>
                                            </div>
                                        <?php else: ?>
                                            <?php echo htmlspecialchars($value['web_root_user']); ?>
                                        <?php endif; ?>
                                      </td>

                                      <!-- Webroot php.ini Cell -->
                                      <td class="text-center text-secondary d-none d-md-table-cell <?php echo $value['classes']['web_root_local']; ?>">
                                        <?php if ($value['directive_name'] === 'disable_functions' && $value['web_root_local'] != '-'): ?>
                                            <div class="overflow-auto font-monospace mx-auto text-start Xbg-dark Xtext-white p-1 Xrounded" style="max-height: 50px; width: 100px; line-height: 1.1; font-size: 0.7rem;">
                                                <?php echo str_replace(',', '<br>', htmlspecialchars($value['web_root_local'])); ?>
                                            </div>
                                        <?php else: ?>
                                            <?php echo htmlspecialchars($value['web_root_local']); ?>
                                        <?php endif; ?>
                                      </td>

                                      <!-- Admin .user.ini Cell -->
                                      <td class="text-center text-secondary d-none d-md-table-cell <?php echo $value['classes']['admin_user']; ?>">
                                        <?php if ($value['directive_name'] === 'disable_functions' && $value['admin_user'] != '-'): ?>
                                            <div class="overflow-auto font-monospace mx-auto text-start Xbg-dark Xtext-white p-1 Xrounded" style="max-height: 50px; width: 100px; line-height: 1.1; font-size: 0.7rem;">
                                                <?php echo str_replace(',', '<br>', htmlspecialchars($value['admin_user'])); ?>
                                            </div>
                                        <?php else: ?>
                                            <?php echo htmlspecialchars($value['admin_user']); ?>
                                        <?php endif; ?>
                                      </td>

                                      <!-- Admin php.ini Cell -->
                                      <td class="text-center text-secondary d-none d-md-table-cell <?php echo $value['classes']['admin_local']; ?>">
                                        <?php if ($value['directive_name'] === 'disable_functions' && $value['admin_local'] != '-'): ?>
                                            <div class="overflow-auto font-monospace mx-auto text-start Xbg-dark Xtext-white p-1 Xrounded" style="max-height: 50px; width: 100px; line-height: 1.1; font-size: 0.7rem;">
                                                <?php echo str_replace(',', '<br>', htmlspecialchars($value['admin_local'])); ?>
                                            </div>
                                        <?php else: ?>
                                            <?php echo htmlspecialchars($value['admin_local']); ?>
                                        <?php endif; ?>
                                      </td>

                                      <!-- Accessible Text Override Badge Status Column -->
                                      <td class="text-center">
                                        <span class="badge border bg-<?php echo $value['status_color']; ?>-subtle text-<?php echo $value['status_color']; ?>-emphasis border-<?php echo $value['status_color']; ?> fw-bold text-uppercase d-inline-flex align-items-center justify-content-center"
                                              style="font-size: 0.7rem; min-width: 66px; padding: 4px 6px;"
                                              data-bs-toggle="tooltip"
                                              data-bs-placement="left"
                                              data-bs-title="<?php echo htmlspecialchars($value['override_status'] !== 'none' ? ($value['active_source'] . ' winning allocation source') : 'No configuration folder overrides applied'); ?>">
                                          <?php echo htmlspecialchars($value['status_text']); ?>
                                        </span>
                                      </td>

                                    </tr>
                                  <?php endforeach; ?>
                                </tbody>

                              </table>
                            </div>
                          </div>

                        </div>

                    </div><!-- /col inner_php_ini_settings -->

                </div><!-- /col -->
            </div><!-- /row ini_settings_matrix -->


           <div id="<?php echo $fpa_data['php']['meta']['attribute_slug']; ?>_sanity" class="row g-4 d-md-flex align-items-md-stretch mt-2">
                <div class="col-12 col-sm-12 Xcol-md-5 col-lg-3 Xd-flex Xflex-column Xjustify-content-center">

                    <h3 class="fs-5 fw-light Xtext-secondary text-uppercase tracking-wider mb-2">
                        <span class="fw-bold"><?php echo htmlspecialchars($lang['FPA_SUB_TITLE_PHP_INI_SETTINGS']); ?></span> <?php echo htmlspecialchars($lang['FPA_TXT_SANITY']); ?>
                    </h3>

                    <p><?php echo htmlspecialchars($fpa_data['php']['meta']['section_title']); ?></p>

                    <button type="button" class="btn btn-outline-secondary btn-sm Xmb-3 Xms-auto" id="toggle_<?php echo $fpa_data['php']['meta']['attribute_slug']; ?>sanityall_btn" data-fpa-toggle="<?php echo $fpa_data['php']['meta']['attribute_slug']; ?>sanityall" >
                        <i class="bi bi-eye me-1"></i> Toggle All
                    </button>

                </div><!-- /col -->
                <div class="col-12 col-sm-12 Xcol-md-7 col-lg-9">


<?php
/**
 * PHP INI Setting Sanity Exceptions
 */
?>
<div id="fpa_sanity_exceptions_wrapper" class="col-12 mb-4">

  <!-- Section Title & Meta Header Block -->
  <div class="d-flex justify-content-between align-items-baseline mb-3 border-bottom pb-2">
    <div>
      <h3 class="h5 text-dark-emphasis mb-0 text-uppercase tracking-wide small font-semibold">
        Analysis Summary & Recommendation Log
      </h3>
      <p class="text-muted small mb-0">Identifies configuration settings that fall outside recommended performance or security baselines.</p>
    </div>

    <!-- Header Badge Counter Grid -->
    <div class="d-flex gap-2">
      <?php if ($fpa_data['php']['data']['danger_count'] > 0): ?>
        <span class="badge border border-danger bg-danger-subtle text-danger-emphasis rounded-pill px-2 py-1 small font-monospace">
          <?php echo $fpa_data['php']['data']['danger_count']; ?> Critical Risk<?php echo $fpa_data['php']['data']['danger_count'] > 1 ? 's' : ''; ?>
        </span>
      <?php endif; ?>
      <?php if ($fpa_data['php']['data']['warning_count'] > 0): ?>
        <span class="badge border border-warning bg-warning-subtle text-warning-emphasis rounded-pill px-2 py-1 small font-monospace">
          <?php echo $fpa_data['php']['data']['warning_count']; ?> Notice<?php echo $fpa_data['php']['data']['warning_count'] > 1 ? 's' : ''; ?>
        </span>
      <?php endif; ?>
    </div>
  </div>

  <!-- Rounded Mask Outer Grid Container Layer -->
  <div class="border rounded shadow-sm overflow-hidden mb-0">
    <div class="table-responsive">
      <table class="table table-hover table-bordered align-middle mb-0" style="font-size: 0.875rem;">

        <!-- Subtle Frosted-Glass Sticky Header -->
        <thead>
          <tr>
            <th scope="col" class="position-sticky top-0 z-3 bg-light-subtle text-dark-emphasis text-uppercase tracking-wider ps-3 border-bottom" style="font-size: 0.725rem; font-weight: 700; width: 220px;">Directive Name</th>
            <th scope="col" class="position-sticky top-0 z-3 bg-light-subtle text-dark-emphasis text-uppercase tracking-wider text-center border-bottom" style="font-size: 0.725rem; font-weight: 700; width: 120px;">Live Value</th>
            <th scope="col" class="position-sticky top-0 z-3 bg-light-subtle text-dark-emphasis text-uppercase tracking-wider text-center border-bottom" style="font-size: 0.725rem; font-weight: 700; width: 100px;">Severity</th>
            <th scope="col" class="position-sticky top-0 z-3 bg-light-subtle text-dark-emphasis text-uppercase tracking-wider border-bottom" style="font-size: 0.725rem; font-weight: 700;">Resolution Advice</th>
          </tr>
        </thead>

        <tbody>
          <?php
            // Track if we actually output any rows to know if the system is completely healthy
            $has_exceptions = false;
          ?>

          <?php foreach ($fpa_data['php']['data']['rows']['ini_matrix'] as $directive => $value): ?>

            <!-- 📌 EXCEPTION GATE: Skip rendering if the directive matches our optimal success baseline rules -->
            <?php if ($value['sanity_state'] === 'success') continue; ?>

            <?php
              // Mark that we found and processed an exception row entry
              $has_exceptions = true;
            ?>

            <!-- High-contrast alert row layouts mapping directly to severity statuses -->
            <tr class="<?php echo ($value['sanity_state'] === 'danger') ? 'table-danger-subtle' : 'table-warning-subtle'; ?>">

              <!-- Column 1: Directive Name & Category Group Tag Badge -->
              <td class="ps-3 fw-medium">
                    <?php echo htmlspecialchars($value['directive_name']); ?>
                <span class="badge border border-secondary bg-body-secondary text-secondary-emphasis font-monospace d-block mt-1 text-center" style="font-size: 0.58rem; max-width: 90px; padding: 2px 4px;">
                  <?php echo htmlspecialchars(strtoupper($value['category'])); ?>
                </span>
              </td>

              <!-- Column 2: Live Runtime Execution Metrics Value -->
              <td class="text-center fw-bold text-dark-emphasis">
                <?php if ($value['directive_name'] === 'disable_functions'): ?>
                  <div class="overflow-auto font-monospace mx-auto text-start bg-dark text-white p-1 rounded" style="max-height: 55px; max-width: 140px; line-height: 1.1; font-size: 0.7rem;">
                    <?php echo str_replace(',', '<br>', htmlspecialchars($value['active_runtime'])); ?>
                  </div>
                <?php else: ?>
                  <?php echo htmlspecialchars($value['active_runtime']); ?>
                <?php endif; ?>
              </td>

              <!-- Column 3: High-Contrast Accessible Severity Status Text -->
              <td class="text-center">
                <span class="badge border border-<?php echo $value['sanity_state']; ?> bg-<?php echo $value['sanity_state']; ?>-subtle text-<?php echo $value['sanity_state']; ?>-emphasis fw-bold text-uppercase" style="font-size: 0.68rem; letter-spacing: 0.3px;">
                  <?php echo ($value['sanity_state'] === 'danger') ? 'CRITICAL' : 'WARNING'; ?>
                </span>
              </td>

              <!-- Column 4: Highly Descriptive Action Advice Resolution String -->
              <td class="text-muted small py-2 pe-3 lh-sm">
                <?php echo htmlspecialchars($value['sanity_message']); ?>
              </td>

            </tr>
          <?php endforeach; ?>

          <!-- 🏆 ALL SANE SCREEN ROW: Renders beautifully if the exception lookup loop stays empty! -->
          <?php if ($has_exceptions === false): ?>
            <tr class="table-success text-center fw-semibold">
              <td colspan="4" class="py-4 text-success-emphasis" style="font-size: 0.95rem;">
                <i class="bi bi-patch-check-fill me-2 fs-5"></i>
                Excellent! All environment directives match recommended performance, security, and compatibility baselines. No changes required.
              </td>
            </tr>
          <?php endif; ?>
        </tbody>

      </table>
    </div><!-- /table-responsive -->
  </div><!-- /rounded border container -->

  <!-- DEVELOPER TOOLS DIAGNOSTIC PANEL -->
  <?php if (defined('FPA_DEV') && FPA_DEV): ?>
    <div class="mt-4 pt-3 border-top">
      <div class="small text-muted text-uppercase tracking-wider fw-bold mb-2 font-monospace">
        Internal Data Stream Blueprint Debug (Sanity Checks)
      </div>
      <pre class="bg-dark text-success p-3 rounded overflow-auto mb-0" style="max-height: 250px; font-size: 0.8rem; line-height: 1.4;">
        <?php print_r($fpa_data['php']['data']['rows']['ini_matrix']); ?>
      </pre>
    </div>
  <?php endif; ?>

</div><!-- /col fpa_sanity_exceptions_wrapper -->



                    <!--
                    <div id="inner_php_ini_sanity" class="col-12 mb-3">

                        <div class="card w-100 h-100">
                            <div class="card-body p-0">

                                <div class="Xtable-responsive rounded">

                                    <table class="table table-hover align-middle table-striped table-bordered mb-0" style="Xfont-size: 0.9rem;">
                                        <thead class="Xtable-light table-dark text-uppercase tracking-wider position-sticky z-3" style="top:55px;font-size: 0.8rem; font-weight: 700;">
                                            <tr>
                                                <th scope="col" class="ps-3" style="min-width: 240px;">Directive</th>
                                                <th scope="col" class="text-center" style="width: 85px;">Value</th>
                                                <th scope="col">Analysis Summary</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if ($fpa_data['php']['data']['all_sane'] === true): ?>
                                                <tr>
                                                    <td colspan="4" class="py-3 text-success-emphasis">
                                                        <div class="alert alert-success w-100 text-center mb-0" role="alert">
                                                            <i class="bi bi-check-circle text-success fs-1 lh-1"></i>
                                                            <span class="d-block"><?php echo htmlspecialchars($lang['FPA_MSG_ALL_SANE'] ?? 'All directives match recommended baselines.'); ?></span>
                                                        </div>
                                                    </td>
                                                </tr>
                                            <?php endif; ?>

                                            <?php foreach ($fpa_data['php']['data']['rows']['ini_matrix'] as $directive => $value): ?>

                                                <?php
                                                if ($value['sanity_state'] != 'success'):
                                                    $non_rbe = '';
                                                else:
                                                    $non_rbe = 'd-none fpa-toggle-' . $fpa_data['php']['meta']['attribute_slug'] . 'sanityall';
                                                endif;
                                                ?>
                                                <tr class="<?php echo $non_rbe; ?>">
                                                    <td class=""><?php echo $value['directive_name']; ?></td>
                                                    <td class="Xd-none Xd-sm-table-cell text-center bg-<?php echo $value['sanity_state']; ?>-subtle text-<?php echo $value['sanity_state']; ?>-emphasis">

                                                        <?php echo htmlspecialchars($value['active_runtime']); ?>

                                                    </td>
                                                    <td class="text-secondary small" style="line-height: 1.1;">

                                                        <span class="badge border border-<?php echo $value['sanity_state']; ?> bg-<?php echo $value['sanity_state']; ?>-subtle text-<?php echo $value['sanity_state']; ?>-emphasis me-1"
                                                              data-bs-toggle="tooltip"
                                                              data-bs-placement="left"
                                                              data-bs-title="Category: <?php echo htmlspecialchars($value['category']); ?>">
                                                            <?php echo htmlspecialchars(strtoupper($value['category'][0])); ?>
                                                        </span>
                                                        <?php if (!empty($value['sanity_message'])): ?>
                                                            <small class="text-<?php echo ($value['sanity_state'] === 'danger') ? 'danger' : 'warning-emphasis'; ?> fw-medium">
                                                                <?php echo htmlspecialchars($value['sanity_message']); ?>
                                                            </small>
                                                        <?php endif; ?>

                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>

                                </div>-- /table-responsive --

                            </div>-- /card-body --
                            <?php
                            // Developer Tools
                            if (defined('FPA_DEV') && FPA_DEV) {
                                echo '<div class="card-footer text-small">';
                                echo '<pre class="overflow-auto" style="max-height: 250px;">';
                                print_r($fpa_data['php']['data']['rows']['ini_matrix']);
                                echo '</pre>';
                                echo '</div>';
                            } // end Developer Mode
                            ?>
                        </div>-- /card --

                    </div>-- /col inner_php_ini_sanity
                    -->

                </div><!-- /col -->
            </div><!-- /row ini_sanity_table -->

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
                            <span class="fw-bold"><?php echo htmlspecialchars($fpa_data['corefolders']['meta']['section_title']); ?></span> <?php echo htmlspecialchars($lang['FPA_TXT_SUMMARY']); ?>
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
                            PHP User: <strong class="Xtext-dark"><?php echo htmlspecialchars($fpa_data['ref']['data']['php']['process_user']); ?></strong>
                            &nbsp;|&nbsp;System umask: <strong class="Xtext-dark"><?php echo htmlspecialchars($fpa_data['ref']['data']['server']['umask']); ?></strong>
                        </span>
                    </div>

                    <div class="table-responsive rounded">

                        <table class="table table-hover align-middle table-striped table-bordered mb-0" style="Xfont-size: 0.9rem;">
                            <thead class="Xtable-light table-dark text-uppercase tracking-wider" style="font-size: 0.8rem; font-weight: 700;">
                                <tr>
                                    <th scope="col" class="ps-3" rowspan="2">Path</th>
                                    <th scope="col" class="text-center Xps-3 Xd-none Xfpa-toggle-permsaudit" colspan="3">Special Permissions</th>
                                    <th scope="col" class="text-center" style="width: 84px;" rowspan="2">Mode</th>
                                    <th scope="col" class="text-center" style="width: 64px;" rowspan="2">Owner Match</th>
                                    <th scope="col" class="text-center" style="width: 64px;" rowspan="2">Read</th>
                                    <th scope="col" class="text-center Xpe-3" colspan="3">Writable</th>
                                    <th scope="col" class="text-center bg-fpa Xpe-3" rowspan="2" style="width: 64px;">Sane</th>
                                </tr>
                                <tr>
                                    <th class="text-center small Xd-none Xfpa-toggle-permsaudit" style="width: 64px;">SUID</th>
                                    <th class="text-center small Xd-none Xfpa-toggle-permsaudit" style="width: 64px;">SGID</th>
                                    <th class="text-center small Xd-none Xfpa-toggle-permsaudit" style="width: 64px;">Sticky</th>
                                    <th class="text-center small" style="width: 64px;">Owner</th>
                                    <th class="text-center small" style="width: 64px;">Group</th>
                                    <th class="text-center small" style="width: 64px;">World</th>
                                </tr>
                            </thead>
                            <!--
                            <thead class="Xtable-light table-dark text-uppercase tracking-wider" style="font-size: 0.8rem; font-weight: 700;">
                                <tr>
                                    <th scope="col" class="ps-3">Path</th>
                                    <th scope="col" class="d-none Xd-md-table-cell text-end Xd-none fpa-toggle-corefolders">Owner</th>
                                    <th scope="col" class="d-none Xd-md-table-cell Xd-none fpa-toggle-corefolders">Group</th>
                                    <th scope="col" class="text-center" style="width: 68px;">Mode</th>
                                    <th scope="col" class="text-center Xpe-3" style="width: 100px;">Writable</th>
                                </tr>
                            </thead>
                            -->
                            <tbody>
                                <?php foreach ($fpa_data['corefolders']['data']['rows']['folders'] as $path => $perms_info): ?>

                                    <?php
                                    $mode_color = $perms_info['mode_color'];
                                    $mode_icon  = ($mode_color === 'danger')
                                        ? 'shield-slash-fill'
                                        : 'exclamation-triangle-fill';
                                    $row_color  = ($perms_info['row_class'] !== 'success')
                                        ? $perms_info['row_class']
                                        : '';
                                    $sane_color = $perms_info['is_sane']['color'];

                                    if ($perms_info['mode_color'] != 'success') {
                                        $rbe_show_corefolders = '';
                                    } else {
                                        $rbe_show_corefolders = 'd-none fpa-toggle-allcorefolders';
                                    }
                                    ?>
                                    <tr class="table-<?php //echo $row_color; ?> <?php //echo $rbe_show_corefolders; ?>">
                                        <td class="ps-3 Xfont-monospace Xfw-semibold Xtext-secondary text-break" style="Xfont-size: 0.82rem;">
                                            <?php echo htmlspecialchars($path); ?>
                                        </td>

                                        <!-- special permisisons -->
                                        <td class="text-center text-uppercase">
                                            <?php if (!$perms_info['exists']['value']): ?>
                                                <i class="bi bi-dash-circle-dotted text-secondary" style="font-size: 1.04rem;"></i>
                                            <?php else: ?>
                                                <span class="badge border border-<?php echo $perms_info['has_suid']['color']; ?> bg-<?php echo $perms_info['has_suid']['color']; ?>-subtle text-<?php echo $perms_info['has_suid']['color']; ?>-emphasis w-100">
                                                    <?php echo $perms_info['has_suid']['text']; ?>
                                                </span>
                                            <?php endif; ?>
                                        </td>

                                        <td class="text-center text-uppercase">
                                            <?php if (!$perms_info['exists']['value']): ?>
                                                <i class="bi bi-dash-circle-dotted text-secondary" style="font-size: 1.04rem;"></i>
                                            <?php else: ?>
                                                <span class="badge border border-<?php echo $perms_info['has_guid']['color']; ?> bg-<?php echo $perms_info['has_guid']['color']; ?>-subtle text-<?php echo $perms_info['has_guid']['color']; ?>-emphasis w-100">
                                                    <?php echo $perms_info['has_guid']['text']; ?>
                                                </span>
                                            <?php endif; ?>
                                        </td>

                                        <td class="text-center text-uppercase">
                                            <?php if (!$perms_info['exists']['value']): ?>
                                                <i class="bi bi-dash-circle-dotted text-secondary" style="font-size: 1.04rem;"></i>
                                            <?php else: ?>
                                                <span class="badge border border-<?php echo $perms_info['has_sticky']['color']; ?> bg-<?php echo $perms_info['has_sticky']['color']; ?>-subtle text-<?php echo $perms_info['has_sticky']['color']; ?>-emphasis w-100">
                                                    <?php echo $perms_info['has_sticky']['text']; ?>
                                                </span>
                                            <?php endif; ?>
                                        </td>

                                        <!-- standard permissions with conditional tier warning badges & icons -->
                                        <td class="text-center">
                                            <?php if (!$perms_info['exists']['value']): ?>
                                                <span class="badge border border-<?php echo $mode_color; ?>
                                                    bg-<?php echo $mode_color; ?>-subtle
                                                    text-<?php echo $mode_color; ?>-emphasis text-uppercase w-100">
                                                    <?php echo htmlspecialchars($lang['FPA_TXT_MISSING']); ?>
                                                </span>
                                            <?php else: ?>
                                                <span class="badge border border-<?php echo $mode_color; ?>
                                                    <?php echo 'bg-' . $mode_color . ' X-subtle Xtext-' . $mode_color; ?>-emphasis w-100"
                                                    style="Xfont-size: 0.72rem;"
                                                    data-bs-toggle="tooltip"
                                                    data-bs-placement="left"
                                                    title="<?php echo htmlspecialchars($perms_info['tooltip']); ?>">

                                                    <?php if ($mode_color === 'danger' || $mode_color === 'warning'): ?>
                                                        <i class="bi bi-<?php echo $mode_icon; ?> me-1"></i>
                                                    <?php endif; ?>

                                                    <?php echo htmlspecialchars($perms_info['mode']); ?>
                                                </span>
                                            <?php endif; ?>


                                            <!--
                                            <?php if (!$perms_info['exists']['value']): ?>
                                                <span class="badge border border-secondary bg-secondary-subtle text-secondary text-uppercase w-100" style="font-size: 0.72rem;">
                                                    <?php echo $lang['FPA_TXT_MISSING']; ?>
                                                </span>
                                            <?php elseif (!$perms_info['is_sane']['value'] && $perms_info['mode_color'] != 'success'): ?>
                                                -- CRITICAL & WARNING BADGE (e.g., 757, 775, 777 etc) --
                                                <?php $mode_icon = $perms_info == 'danger' ? 'shield-slash-fill' : 'exclamation-triangle-fill'; ?>
                                                <span class="badge border border-<?php echo $perms_info['mode_color']; ?> bg-<?php echo $perms_info['mode_color']; ?>-subtle text-<?php echo $perms_info['mode_color'];?>-emphasis w-100" style="Xfont-size: 0.72rem;"
                                                    data-bs-toggle="tooltip"
                                                    data-bs-placement="left"
                                                    data-bs-title="<?php echo $perms_info['tooltip']; ?>">
                                                    <i class="bi bi-<?php echo $mode_icon; ?> me-1"></i><?php echo $perms_info['mode']; ?>
                                                </span>
                                            <?php else: ?>
                                                -- CLEAN SANE SAFE BADGE (e.g., 0755) --
                                                <span class="badge border border-<?php echo $perms_info['mode_color']; ?> bg-<?php echo $perms_info['mode_color']; ?>-subtle text-<?php echo $perms_info['mode_color'];?>-emphasis w-100" style="Xfont-size: 0.72rem;"
                                                    data-bs-toggle="tooltip"
                                                    data-bs-placement="left"
                                                    data-bs-title="<?php echo $perms_info['tooltip']; ?>">
                                                    <?php echo $perms_info['mode']; ?>
                                                </span>
                                            <?php endif; ?>
                                            -->

                                            <!--
                                            <?php //elseif (!$perms_info['is_sane']['value'] && $perms_info['mode_color'] == 'danger'): ?>
                                                -- CRITICAL DANGER BADGE (World Writable / 777) --
                                                <span class="badge bg-danger fw-black px-2.5 py-1.5 shadow-sm text-white w-100" style="font-size: 0.72rem;"
                                                    data-bs-toggle="tooltip"
                                                    data-bs-placement="left"
                                                    data-bs-title="Critical: World-writable or insecure mode detected!">
                                                    <i class="bi bi-shield-slash-fill me-1"></i><?php echo $perms_info['mode']; ?>
                                                </span>
                                            <?php //elseif (!$perms_info['is_sane']['value'] && $perms_info['mode_color'] == 'warning'): ?>
                                                -- SECURITY WARNING BADGE (Group Writable / Loose Permissions) --
                                                <span class="badge bg-warning text-dark border border-warning-subtle fw-bold px-2.5 py-1.5 shadow-sm w-100" style="font-size: 0.72rem;"
                                                    data-bs-toggle="tooltip"
                                                    data-bs-placement="left"
                                                    data-bs-title="Warning: Loose group or owner permissions detected.">
                                                    <i class="bi bi-exclamation-triangle-fill me-1"></i><?php echo $perms_info['mode']; ?>
                                                </span>
                                            -->
                                        </td>

                                        <td class="text-center text-uppercase Xd-none Xfpa-toggle-corefolders">
                                            <?php if (@!$perms_info['owner_match'] && $perms_info['exists']): ?>
                                                <i class="bi bi-exclamation-diamond-fill text-info me-1" style="font-size: 0.85rem;"
                                                    data-bs-toggle="tooltip"
                                                    data-bs-placement="left"
                                                    data-bs-title="Ownership Mismatch: This directory is owned by a different user than the account executing PHP code."></i>
                                            <?php endif; ?>
                                            <?php if (!$perms_info['exists']['value']): ?>
                                                <i class="bi bi-dash-circle-dotted text-secondary" style="font-size: 1.04rem;"></i>
                                            <?php else: ?>
                                                <span class="badge border border-<?php echo $perms_info['owner_match']['color']; ?> bg-<?php echo $perms_info['owner_match']['color']; ?>-subtle text-<?php echo $perms_info['owner_match']['color']; ?>-emphasis w-100">
                                                    <?php echo htmlspecialchars($perms_info['owner_match']['text']); ?>
                                                    <?php //echo htmlspecialchars($perms_info['owner']); ?>
                                                </span>
                                            <?php endif; ?>
                                        </td>

                                        <td class="text-center text-uppercase Xd-none Xfpa-toggle-corefolders">
                                            <?php if (!$perms_info['exists']['value']): ?>
                                                <i class="bi bi-dash-circle-dotted text-secondary" style="font-size: 1.04rem;"></i>
                                            <?php else: ?>
                                                <span class="badge border border-<?php echo $perms_info['is_readable']['color']; ?> bg-<?php echo $perms_info['is_readable']['color']; ?>-subtle text-<?php echo $perms_info['is_readable']['color']; ?>-emphasis w-100">
                                                    <?php echo htmlspecialchars($perms_info['is_readable']['text']); ?>
                                                </span>
                                            <?php endif; ?>
                                        </td>

                                        <!--
                                        <td class="Xd-md-table-cell text-muted Xd-none Xfpa-toggle-corefolders">
                                            <?php //echo htmlspecialchars($perms_info['group']); ?>
                                        </td>
                                        -->

                                        <!--
                                        <td class="text-center">
                                            <?php if (!$perms_info['exists']): ?>
                                                <span class="badge bg-secondary-subtle text-secondary fw-bold px-2.5 py-1.5 text-uppercase" style="font-size: 0.72rem;">Missing</span>
                                            <?php elseif (!$perms_info['is_sane']): ?>
                                                <span class="badge bg-danger fw-black px-2.5 py-1.5 shadow-sm" style="font-size: 0.72rem;" title="Dangerous Mode Detected!">
                                                    <i class="bi bi-exclamation-triangle-fill me-1"></i><?php echo $perms_info['mode']; ?>
                                                </span>
                                            <?php else: ?>
                                                <span class="badge bg-light text-dark border fw-bold px-2.5 py-1.5" style="font-size: 0.72rem;">
                                                    <?php echo $perms_info['mode']; ?>
                                                </span>
                                            <?php endif; ?>
                                        </td>
                                        -->

                                        <td class="text-center text-uppercase">
                                            <?php if (!$perms_info['exists']['value']): ?>
                                                <i class="bi bi-dash-circle-dotted text-secondary" style="font-size: 1.04rem;"></i>
                                            <?php elseif ($perms_info['is_owner_w']): ?>
                                                <span class="badge bg-<?php echo $perms_info['is_owner_w']['color']; ?>-subtle text-<?php echo $perms_info['is_owner_w']['color']; ?> border border-<?php echo $perms_info['is_owner_w']['color']; ?>-subtle w-100" style="font-size: 0.68rem; letter-spacing: 0.3px; width: 66px;">
                                                    <?php echo $perms_info['is_owner_w']['text']; ?>
                                                </span>
                                            <?php endif; ?>
                                        </td>

                                        <td class="text-center text-uppercase">
                                            <?php if (!$perms_info['exists']['value']): ?>
                                                <i class="bi bi-dash-circle-dotted text-secondary" style="font-size: 1.04rem;"></i>
                                            <?php elseif ($perms_info['is_owner_w']): ?>
                                                <span class="badge bg-<?php echo $perms_info['is_group_w']['color']; ?>-subtle text-<?php echo $perms_info['is_group_w']['color']; ?>-emphasis border border-<?php echo $perms_info['is_group_w']['color']; ?>-subtle w-100" style="font-size: 0.68rem; letter-spacing: 0.3px;">
                                                    <?php echo $perms_info['is_group_w']['text']; ?>
                                                </span>
                                            <?php endif; ?>
                                        </td>

                                        <td class="text-center text-uppercase">
                                            <?php if (!$perms_info['exists']['value']): ?>
                                                <i class="bi bi-dash-circle-dotted text-secondary" style="font-size: 1.04rem;"></i>
                                            <?php elseif ($perms_info['is_owner_w']): ?>
                                                <span class="badge bg-<?php echo $perms_info['is_world_w']['color']; ?>-subtle text-<?php echo $perms_info['is_world_w']['color']; ?> border border-<?php echo $perms_info['is_world_w']['color']; ?>-subtle w-100" style="font-size: 0.68rem; letter-spacing: 0.3px;">
                                                    <?php echo $perms_info['is_world_w']['text']; ?>
                                                </span>
                                            <?php endif; ?>
                                        </td>

                                        <td class="text-center text-uppercase">
                                            <?php if (!$perms_info['exists']['value']): ?>
                                                <i class="bi bi-dash-circle-dotted text-secondary" style="font-size: 1.04rem;"></i>
                                            <?php elseif ($perms_info['is_sane']): ?>
                                                <span class="badge bg-<?php echo $sane_color; ?>-subtle text-<?php echo $sane_color; ?>-emphasis border border-<?php echo $sane_color; ?> w-100" style="font-size: 0.68rem; letter-spacing: 0.3px;">
                                                    <?php echo $perms_info['is_sane']['text']; ?>
                                                </span>
                                            <?php endif; ?>
                                        </td>

                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>

                    <?php
                    /*
                     * DEVELOPER MODE: Displays the selected relevant $fpa_data
                     * associative array primary key and populate the simulator
                     * data export argument.
                     */
                    // ADD THE DEBUG ARRAY PRIMARY KEY HERE
                    // ONLY pass the master data array node object you are currently
                    // inspecting! (e.g., $fpa_data['corefolder'])
                    $debug_array_data = $fpa_data['corefolders'] ?? [];

                    // Nothing to do below here...
                    if (defined('FPA_DEV') && FPA_DEV === true) {
                        // Perform the memory scan look-up pass
                        $export_sim_key = array_search($debug_array_data, $fpa_data, true);

                        // GATING: If the data is empty OR the key lookup fails, it means a typo
                        // occurred or the background test module was skipped.
                        if (!empty($debug_array_data) && $export_sim_key !== false):
                            $print_payload = isset($debug_array_data['data'])
                                ? $debug_array_data['data']
                                : $debug_array_data;
                            ?>
                            <div class="card border-info-subtle my-4">
                                <div class="card-header bg-info-subtle d-flex justify-content-between align-items-center py-2">
                                    <span class="text-info-emphasis fw-bold">
                                        <i class="bi bi-bug-fill me-1"></i><?php echo htmlspecialchars($lang['FPA_TITLE_DEBUG_NODE']); ?>: [<?php echo htmlspecialchars($export_sim_key); ?>]
                                    </span>
                                    <a href="?fpa_export_sim=<?php echo htmlspecialchars($export_sim_key); ?>"
                                       download="fpasim_<?php echo htmlspecialchars($export_sim_key); ?>.php"
                                       class="btn btn-primary btn-sm px-3 shadow-sm border border-primary">
                                        <i class="bi bi-cloud-arrow-down-fill me-1"></i><?php echo htmlspecialchars($lang['FPA_BTN_EXPORT_SIM_FILE']); ?>
                                    </a>
                                </div>
                                <div class="card-body bg-dark text-light p-0 rounded-bottom">
                                    <pre class="m-0 p-3" style="font-size: 0.78rem; max-height: 350px; overflow-y: auto;">
                                        <code>
                                            <?php echo htmlspecialchars(print_r($print_payload, true)); ?>
                                        </code>
                                    </pre>
                                </div>
                            </div>
                        <?php else: ?>
                            <div class="alert alert-info text-center text-uppercase fw-bold shadow-sm my-4"
                                 style="font-size: 0.75rem; letter-spacing: 0.05rem;">
                                <i class="bi bi-exclamation-octagon-fill me-2"></i>Debug Node Panel: Nothing To Display.<br>Check Array Primary Key Exists or is correctly typed.
                            </div>
                        <?php endif; ?>
                    <?php } // end: DEVELOPER MODE ?>

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
                            <span class="fw-bold"><?php //echo htmlspecialchars($fpa_elevated_permissions['meta']['name']); ?></span> <?php //echo htmlspecialchars($lang['FPA_TXT_AUDIT']); ?>
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
                            PHP User: <strong class="Xtext-dark"><?php echo htmlspecialchars($fpa_data['ref']['data']['php']['process_user']); ?></strong>
                            &nbsp;|&nbsp;System umask: <strong class="Xtext-dark"><?php echo htmlspecialchars($fpa_data['ref']['data']['server']['umask']); ?></strong>
                        </span>
                    </div>

                    <div class="table-responsive rounded">

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

                                <?php foreach ($fpa_data['permissions']['data']['rows']['folders'] as $eperms_info): ?>
                                    <tr>
                                        <td class="ps-3 Xfont-monospace Xfw-semibold Xtext-secondary text-break Xtext-truncate" style="Xfont-size: 0.82rem;">

                                            <?php echo $_SESSION['privacy_enabled'] ? '<span class="privacy-mask">[ ' . $lang['FPA_TXT_REDACTED'] . ' ]</span>' : htmlspecialchars($eperms_info['path']); ?>

                                        </td>
                                        <td class="text-center d-none fpa-toggle-permsaudit">

                                            <?php
                                            if ($eperms_info['has_suid']) {
                                                $badge_color = 'danger';
                                                $badge_text  = $lang['FPA_TXT_YES'];
                                            } else {
                                                $badge_color = 'success';
                                                $badge_text  = $lang['FPA_TXT_NO'];
                                            }
                                            ?>
                                            <span class="badge bg-<? echo $badge_color; ?>-subtle text-<? echo $badge_color; ?> border border-<? echo $badge_color; ?> fw-semibold px-2 py-1 text-uppercase w-100" style="font-size: 0.68rem; letter-spacing: 0.3px; Xwidth: 66px;"><? echo $badge_text; ?></span>

                                        </td>
                                        <td class="text-center d-none fpa-toggle-permsaudit">

                                            <?php
                                            if ($eperms_info['has_sgid']) {
                                                $badge_color = 'danger';
                                                $badge_text  = $lang['FPA_TXT_YES'];
                                            } else {
                                                $badge_color = 'success';
                                                $badge_text  = $lang['FPA_TXT_NO'];
                                            }
                                            ?>
                                            <span class="badge bg-<? echo $badge_color; ?>-subtle text-<? echo $badge_color; ?> border border-<? echo $badge_color; ?> fw-semibold px-2 py-1 text-uppercase w-100" style="font-size: 0.68rem; letter-spacing: 0.3px; Xwidth: 66px;"><? echo $badge_text; ?></span>

                                        </td>
                                        <td class="text-center d-none fpa-toggle-permsaudit">

                                            <?php
                                            if ($eperms_info['has_sticky']) {
                                                $badge_color = 'danger';
                                                $badge_text  = $lang['FPA_TXT_YES'];
                                            } else {
                                                $badge_color = 'success';
                                                $badge_text  = $lang['FPA_TXT_NO'];
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
                                            <span class="badge bg-<? echo $badge_color; ?> fw-black px-2.5 py-1.5 text-white w-100" style="font-size: 0.72rem;"
                                                data-bs-toggle="tooltip"
                                                data-bs-placement="left"
                                                data-bs-title="<?php echo $tooltip_title; ?>">
                                                <i class="bi bi-<?php echo $badge_icon; ?> me-1"></i><?php echo $eperms_info['permissions']; ?>
                                            </span>

                                        </td>
                                        <td class="Xd-none Xd-md-table-cell Xtext-muted Xtext-end">

                                            <?php
                                            if ($eperms_info['owner_match']) {
                                                $badge_color = 'success';
                                                $badge_text  = $lang['FPA_TXT_YES'];
                                            } else {
                                                $badge_color = 'warning';
                                                $badge_text  = $lang['FPA_TXT_NO'];
                                            }
                                            ?>
                                            <span class="badge bg-<? echo $badge_color; ?>-subtle text-<? echo $badge_color; ?> border border-<? echo $badge_color; ?> fw-semibold px-2 py-1 text-uppercase w-100" style="font-size: 0.68rem; letter-spacing: 0.3px; Xwidth: 66px;"
                                                data-bs-toggle="tooltip"
                                                data-bs-placement="left"
                                                data-bs-title="Ownership Mismatch: This directory is owned by a different user than the account executing PHP code."><? echo $badge_text; ?></span>

                                        </td>
                                        <td class="Xd-none Xd-md-table-cell Xtext-muted">
                                            <?php
                                            if ($eperms_info['is_owner_w']) {
                                                $badge_color = 'success';
                                                $badge_text  = $lang['FPA_TXT_YES'];
                                            } else {
                                                $badge_color = 'danger';
                                                $badge_text  = $lang['FPA_TXT_NO'];
                                            }
                                            ?>
                                            <span class="badge bg-<? echo $badge_color; ?>-subtle text-<? echo $badge_color; ?> border border-<? echo $badge_color; ?> fw-semibold px-2 py-1 text-uppercase w-100" style="font-size: 0.68rem; letter-spacing: 0.3px; Xwidth: 66px;"><? echo $badge_text; ?></span>

                                        </td>

                                        <td class="Xd-none Xd-md-table-cell Xtext-muted">

                                            <?php
                                            if ($eperms_info['is_group_w']) {
                                                $badge_color = 'danger';
                                                $badge_text  = $lang['FPA_TXT_YES'];
                                            } else {
                                                $badge_color = 'success';
                                                $badge_text  = $lang['FPA_TXT_NO'];
                                            }
                                            ?>
                                            <span class="badge bg-<? echo $badge_color; ?>-subtle text-<? echo $badge_color; ?> border border-<? echo $badge_color; ?> fw-semibold px-2 py-1 text-uppercase w-100" style="font-size: 0.68rem; letter-spacing: 0.3px; Xwidth: 66px;"><? echo $badge_text; ?></span>

                                        </td>
                                        <td class="text-center Xtext-end Xpe-3">

                                            <?php
                                            if ($eperms_info['is_world_w']) {
                                                $badge_color = 'danger';
                                                $badge_text  = $lang['FPA_TXT_YES'];
                                            } else {
                                                $badge_color = 'success';
                                                $badge_text  = $lang['FPA_TXT_NO'];
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
                            <span style="font-size: 0.7rem;"><?php echo $lang['FPA_TXT_COMPACT'] ?? 'Compact'; ?></span>
                        </button>
                    </div>
                    <div class="col-4">
                        <button type="button" class="btn btn-outline-secondary btn-sm fw-bold w-100 py-2 d-flex flex-column align-items-center justify-content-center <?php //echo ($_SESSION['current_preset_profile'] === 'default') ? 'active' : ''; ?>">
                            <i class="bi bi-layers-half mb-1 fs-5"></i>
                            <span style="font-size: 0.7rem;"><?php echo $lang['FPA_TXT_DEFAULT'] ?? 'Default'; ?></span>
                        </button>
                    </div>
                    <div class="col-4">
                        <button type="button" class="btn btn-outline-secondary btn-sm fw-bold w-100 py-2 d-flex flex-column align-items-center justify-content-center <?php //echo ($_SESSION['current_preset_profile'] === 'detailed') ? 'active' : ''; ?>">
                            <i class="bi bi-layers-fill mb-1 fs-5"></i>
                            <span style="font-size: 0.7rem;"><?php echo $lang['FPA_TXT_DETAILED'] ?? 'Detailed'; ?></span>
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
     * SECTION: OFFCANVAS ISSUE NOTIFICATIONS PANEL
     * =============================================================================
     * right aligned, compact, offcanvas with integrated floating button handle
     */
    ?>
    <?php
    // Floating issue notification trigger button
    // Only renders on screen if the master issue queue contains active exceptions
    ?>
    <?php if (!empty($fpa_data['issue_queue']['data']['rows'])): ?>
    <button class="btn btn-danger position-fixed end-0 translate-middle-y shadow d-flex flex-column align-items-center justify-content-center z-4 px-3 py-2 border border-danger-subtle rounded-start"
        type="button"
        data-bs-toggle="offcanvas"
        data-bs-target="#fpa_issues_drawer"
        aria-controls="fpa_issues_drawer"
        style="top: 220px; width: 52px; height: 54px; border-radius: 8px 0 0 8px;">

        <!-- Pulse badge tracker animation indicator -->
        <span class="position-relative d-inline-block mb-0">
            <i class="bi bi-exclamation-triangle-fill fs-5"></i>
            <span class="position-absolute top-0 start-0 translate-middle badge rounded-pill bg-white text-danger font-monospace border border-danger px-1 small" style="font-size: 0.65rem;">
                <?php echo count($fpa_data['issue_queue']['data']['rows']); ?>
            </span>
        </span>

        <span class="text-uppercase tracking-wider fw-bold text-white small" style="font-size: 0.6rem; letter-spacing: 0.25px;">
            Issues
        </span>
    </button>
    <?php endif; ?>

<?php
// Actionable issue notification offcanvas drawer
?>
<div class="offcanvas offcanvas-end bg-body-tertiary border-start shadow-lg"
    tabindex="-1"
    id="fpa_issues_drawer"
    aria-labelledby="fpa_issues_drawer_title"
    style="width: 420px; max-width: 100vw;">

    <!-- Drawer Header Block with Advanced Export Actions Toolbar -->
<div class="offcanvas-header bg-dark text-white p-3 d-flex flex-column gap-3 w-100">

  <!-- 📌 ROW 1: TITLE & CLOSE BUTTON (Pushed to the absolute outer edges) -->
  <div class="d-flex align-items-center justify-content-between w-100">
    <div class="d-flex align-items-center gap-2">
      <i class="bi bi-shield-slash-fill text-danger fs-5"></i>
      <h5 class="offcanvas-title h6 text-uppercase tracking-wide mb-0 fw-bold" id="fpa_issues_drawer_title">
        Action Items
      </h5>
    </div>
    <!-- Pinned perfectly to the far right edge of the offcanvas drawer -->
    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Close Issue Drawer Window"></button>
  </div>

  <!-- 📌 ROW 2: THE EXPORT TOOLBAR (Evenly spaced across the next line) -->
  <!-- .row-cols-3 divides the width into 3 identical segments automatically -->
  <div class="row row-cols-3 g-1 w-100 mx-0 mt-1">

    <!-- Column 1: Print Button -->
    <div class="col px-1">
      <button type="button" id="fpa_print_log_btn" class="btn btn-outline-light btn-sm text-uppercase tracking-wider fw-bold w-100 text-truncate" style="font-size: 0.65rem; padding: 6px 4px; letter-spacing: 0.3px;" aria-label="Print Current Issues List Log">
        <i class="bi bi-printer-fill me-1"></i> Print
      </button>
    </div>

    <!-- Column 2: Text Export Link -->
    <div class="col px-1">
      <a href="data:text/plain;charset=utf-8,FORUM%20POST%20ASSISTANT%20%28FPA%29%20v2%20-%20CRITICAL%20ENVIRONMENT%20EXCEPTION%20LOG%0D%0A..." download="fpa-diagnostic-exceptions.txt" class="btn btn-outline-light btn-sm text-uppercase tracking-wider fw-bold w-100 text-truncate" style="font-size: 0.65rem; padding: 6px 4px; letter-spacing: 0.3px;" aria-label="Download Plain Text Environment Log">
        <i class="bi bi-file-earmark-text-fill me-1"></i> TXT
      </a>
    </div>

    <!-- Column 3: CSV Export Link -->
    <div class="col px-1">
      <a href="data:text/csv;charset=utf-8,ID%2CType%2CProblem%20Metric%20Description..." download="fpa-diagnostic-matrix.csv" class="btn btn-outline-light btn-sm text-uppercase tracking-wider fw-bold w-100 text-truncate" style="font-size: 0.65rem; padding: 6px 4px; letter-spacing: 0.3px;" aria-label="Download Excel CSV Spreadsheet Matrix">
        <i class="bi bi-file-earmark-spreadsheet-fill me-1"></i> CSV
      </a>
    </div>

  </div>

</div>


    <!-- Drawer Body Content Scroll Window Container Area -->
    <div class="offcanvas-body p-3 overflow-auto">
        <p class="text-muted small mb-3 lh-sm">
            Review and systematically resolve the individual environmental infrastructure risks logged by the assistant engine below.
        </p>

        <!-- 📋 DYNAMIC EXCEPTION LOOP BLOCK -->
        <div class="d-flex flex-column gap-3">
            <?php foreach ($fpa_data['issue_queue']['data']['rows'] as $issue): ?>

            <!-- Individual Action Item Report Card panel wrapper -->
            <div class="card shadow-sm border border-light-subtle rounded overflow-hidden" id="<?php echo htmlspecialchars($issue['id']); ?>">

                <!-- Card Severity Title Accent -->
                <div class="card-header bg-<?php echo $issue['type']; ?>-subtle text-<?php echo $issue['type']; ?>-emphasis fw-bold small border-bottom border-<?php echo $issue['type']; ?>-subtle py-2 d-flex align-items-center gap-2">
                    <i class="bi bi-<?php echo ($issue['type'] === 'danger') ? 'x-circle-fill' : 'exclamation-circle-fill'; ?>"></i>
                    <?php echo ($issue['type'] === 'danger') ? 'CRITICAL RISK DETECTED' : 'WARNING RISK ALERT'; ?>
                </div>

                <div class="card-body p-3 bg-body">
                   <!-- Issue Message String -->
                    <p class="card-text fw-medium text-dark-emphasis mb-2" style="font-size: 0.85rem; line-height: 1.3;">
                        <?php echo htmlspecialchars($issue['text']); ?>
                    </p>

                    <!-- Resolution Advice Block Panel -->
                    <div class="p-2 rounded border border-light-subtle font-sans-serif small lh-sm" style="font-size: 0.775rem;">
                        <strong class="text-dark-emphasis d-block mb-1 text-uppercase" style="font-size: 0.65rem; letter-spacing: 0.3px;">
                            How to resolve:
                        </strong>
                        <?php echo htmlspecialchars($issue['solution']); ?>
                    </div>
                </div>

            </div>

          <?php endforeach; ?>
        </div><!-- /gap layout stack container -->
    </div><!-- /offcanvas-body -->

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
    // TODO: REMOVE WHEN TETED WITHOUT
    ?>
    <!--
    ///<script nonce="<?php echo $fpa_nonce; ?>" id="php-queue-data" type="application/json">
    ///  <?php //echo json_encode($fpa_exception_queue); ?>
    ///</script>
    -->


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
            // Delegate tooltips: This works for current and future elements
            new bootstrap.Tooltip(document.body, {
                selector: '[data-bs-toggle="tooltip"]',
                container: 'body' // Prevents table styling layout breaks
            });

            // Delegate popovers
            new bootstrap.Popover(document.body, {
                selector: '[data-bs-toggle="popover"]',
                container: 'body'
            });
        });
        /* <shrug> doesn't show all tooltips when array responses are a little slow </shrug>
        document.addEventListener('DOMContentLoaded', () => {
            // select and initialise all tooltips
            const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]');
            const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl));

            // select and initialise all popovers
            const popoverTriggerList = document.querySelectorAll('[data-bs-toggle="popover"]')
            const popoverList = [...popoverTriggerList].map(popoverTriggerEl => new bootstrap.Popover(popoverTriggerEl))
        });
        */


        /**
         * --- privacy redaction (GUI only) ---
         * capture the privacy switch change and automagically reload the page
         * appropriately using the PHP SESSION data (checked (readacted) /
         * unchecked (un-redacted)
         *
         * Usage:
         * echo $_SESSION['privacy_enabled'] ? '<span class="privacy-mask">[ ' . $lang['FPA_TXT_REDACTED'] . ' ]</span>' : htmlspecialchars($ARRAY_NAME['KEY']);
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


        /**
         * --- Issue Log Print Function ---
         */
        (function() {
            'use strict';
            document.addEventListener('DOMContentLoaded', function() {
                const printBtn = document.getElementById('fpa_print_log_btn');
                if (printBtn) {
                    printBtn.addEventListener('click', function() {
                        window.print();
                    });
                }
            });
        })();

    </script>

</body>
</html>
