<?php
    /**
     * @package Joomla!
     * @subpackage Forum Post Assistant
     * @category Diagnostic Tool
     * @version 1.6.0
     * @since 24/06/2011
     * @author RussW
     * @author PhilD
     * @copyright 2011-present, GNU GPLv3 or later license
     * @see https://forumpostassistant.github.io/docs/
     * @internal Supports: J4.x, J3.x, J2,5, J1.7, J1.6, J1.5, J1.0
     * @internal Contributors : @RussW, @PhilD13, @mandville, @Frostmakk, @sozzled, @Webdongle, @botplak
     *
     * UI/UX overhauled
     * @RussW 05/20202
     * docblock updated from the dark-ages
     * @RussW 08/06/2020
     *
     * Remember to revision and last updated date below
     *
     */
	define ( '_RES', 'Forum Post Assistant' );
    define ( '_RES_VERSION', '1.6.0' );
    define ( '_RES_CODENAME', 'rhytidectomy' );
    define ( '_RES_LAST_UPDATED', '27-May-2020' );
	define ( '_RES_RELEASE', 'Alpha' );              // can be Alpha, Beta, RC, Final
	define ( '_RES_LANG', 'en-GB' );                 // Country/Language Code
	define ( '_RES_COPYRIGHT_STMT', ' Copyright &copy; 2011-'. @date("Y").  ' Russell Winter, Phil DeGruy, Bernard Toplak, Claire Mandville, Sveinung Larsen. <br>' );


    /**
     * Keyboard Access Keys:
     * a screan reader accessible only note regarding this information is located just
     * inside the body so it is read to the user before any menu or page informatin is.
     *
     * d = delete, g = generate post,  o = FPA options, n = night mode, l = light mode, v = run VEL, f = re-run default FPA
     *
     * Chrome
     * Windows/Linux - [alt]+ accesskey
     * Mac/OSX - [control]+[alt]+ accesskey
     * Firefox
     * Windows/Linux - [alt]+[shift]+ accesskey
     * Mac/OSX - [control]+[alt]+ accesskey
     * Safari
     * [control]+[alt]+ accesskey
     * Edge/IE
     * [alt]+ accesskey
     *
     */

    /**
     * for edit changelog see https://github.com/ForumPostAssistant/FPA/pulls?q=is%3Apr+is%3Aclosed
     *
     * TODO/WISHLIST:
     * @RussW - add expoert to .csv on tabular data/lists
     * @RussW - add FPA Guided Tour
     * @RussW - split fpa post content to multiple textareas/posts if exceeds 20k characters
     *
     */

    /**
     * attempt to GZip the page output for performance
     * added @RussW 27/05/2020
     * added testing for zlib otherwise conflicts with gzip
     * updated @RussW 29/05/2020
     *
     */
    if ( ini_get( 'zlib.output_compression' ) != '1' AND substr_count($_SERVER['HTTP_ACCEPT_ENCODING'], 'gzip') ) {
        ob_start('ob_gzhandler');
    } else {
        ob_start();
    }

    /** SET THE FPA DEFAULTS *****************************************************************/
     #define ( '_FPA_DEV', TRUE );                 // developer-mode, displays raw array data
     #define ( '_FPA_DIAG', TRUE );                // diagnostic-mode, turns on PHP logging errors, display errors and logs error to a file


    /**
     * DISABLE/ENABLE FPA SPECIAL FEATURES
     * comment-out to disable individual features
     *
     * FPA Self Destruct
     *  - deletes FPA if _FPA_SELF_DESTRUCT_AGE exceeded
     *  - if _FPA_DEV or _FPA_DIAG are defined/TRUE then self-destruction won't happen
     *
     * FPA SSL Redirect
     * - redirects to the SSL site if available
     *  - if _FPA_DEV or _FPA_DIAG are defined/TRUE then redirection won't happen
     *
     * LiveChecks require cURL to function (tested below)
     * - each LiveCheck also has it's own resource requirement criteria to run
     * - this is tested for within each unique LiveCheck function
     *
     */
    define ( '_FPA_SELF', basename($_SERVER['PHP_SELF']) );  // DONT DISABLE SEVERAL FUNCTIONS RELY ON THIS : take in to account renamed FPA, ensure all local links work

    define ( '_FPA_SELF_DESTRUCT', TRUE);         // self-destruct, attempts to self-delete on next run if file older than configured duration
    #define ( '_FPA_SSL_REDIRECT', TRUE);          // self-destruct, attempts to self-delete on next run if file older than configured duration
    define ( '_LIVE_CHECK_FPA', TRUE );           // enable live latest FPA version check
    define ( '_LIVE_CHECK_JOOMLA', TRUE );        // enable live latest Joomla! version check
    #define ( '_LIVE_CHECK_VEL', TRUE );           // enable live VEL check



    /**
     * Check for a localhost before doing anything
     *
     * if on a reserved subnet, then don't use _FPA_AUTO_DESTRUCT function
     * due to never changing "modified" date on copy n paste
     *
     * if a windows development environment is "localhost" then default permisisons are always
     * elevated (777) show a notice to the user that this is normal
     * added @RussW 05/05/2020
     * updated @RussW 08/06/2020 to search array of known reserved ip addresses
     *
     */


    /**
     * set the list of 'localhost' possibilities to be chcked for
     * added @russW 08/06/2020
     */
    $maskLOCAL = array('127.0',
                    '10.',
                    '192.168.',
                    '172.16',
                    '172.17.',
                    '172.18.',
                    '172.19.',
                    '172.20.',
                    '172.21.',
                    '172.22.',
                    '172.23.',
                    '172.24.',
                    '172.25.',
                    '172.26.',
                    '172.27.',
                    '172.28.',
                    '172.29.',
                    '172.30.',
                    '172.31.',
                    '::1'
                    );

    $isLOCALHOST = 0;
    $isWINLOCAL  = 0;
    foreach ($maskLOCAL as $checkLOCALHOST) {

        if ( strpos( $_SERVER['REMOTE_ADDR'], $checkLOCALHOST, 0 ) !== FALSE ) {
            $isLOCALHOST = 1;
            break;
        } // found one of the reserved ip addresses

    } // end foreach through reserved ip address & SERVER_NAME check


    // check for windows to show local permission message
    if ( $isLOCALHOST == 1 AND strtoupper( substr( PHP_OS, 0, 3 ) ) == 'WIN' ) {
        $isWINLOCAL = 1;
    }



    /**
     * FPA Self Destruct
     * comment-out _FPA_SELF_DESTRUCT in Default Settings to disable
     * (there is no need to comment-out the _FPA_SELF_DESTRUCT_AGE constant)
     *
     * if enabled, checks the FPA file date and if over _FPA_SELF_DESTRUCT_AGE days old then run the self-delete script
     * - if $isLOCAL = 1 : don't even access the _FPA_SEF_DESTRUCT routine
     *   as local file modified dates are not udpated when copied and will keep being deleted (thanks @sozzled)
     *
     * CONSTANTS are used throughout this feature as a security measure because they cannot be overriden at runtime
     * added @RussW 30/05/2020
     *
     */
    define ( '_FPA_SELF_DESTRUCT_AGE', 5 );       // age of FPA file before _FPA_SELF_DESTRUCT runs (set as CONSTANT so it can't be changed/overridden at runtime)
    if ( defined('_FPA_SELF_DESTRUCT') AND $isLOCALHOST == 0 AND ( !defined('_FPA_DEV') AND !defined('_FPA_DIAG') ) ) {

        if ( file_exists( _FPA_SELF ) ) {
            $fileinfo = stat( _FPA_SELF );
        }

        // only try and delete the file if we can get the 'last modified' date
        if ( !empty($fileinfo) ) {

            $fileMTime = date( 'd-m-Y', $fileinfo['mtime'] );
            $today     = date( 'd-m-Y' );

            $thisDate = new DateTime($today);
            $fileDate = new DateTime($fileMTime);
            $interval = $thisDate->diff($fileDate);
            $fileAge  = $interval->days;
            //var_dump($interval);

            // if all the criteria satisfied, define the _FPA_SELF_DESTRUCT_DOIT constant
            if ( $fileAge > _FPA_SELF_DESTRUCT_AGE AND $interval->invert == 1) {
                define ('_FPA_SELF_DESTRUCT_DOIT', TRUE);

            } else {
                $fpaEXPIRENOTICE = '<span class="d-print-none d-inline-block mx-auto small text-center text-info" data-html2canvas-ignore="true">As a security measure, this copy of FPA will expire and be deleted in <strong>'. ( (int)_FPA_SELF_DESTRUCT_AGE - $fileAge) .'</strong> days.</span>';
            }

        }
    } else {
        $fpaEXPIRENOTICE = '';
    } // if _FPA_SELF_DESTRUCT defined



    /**
     * SSL check and redirect
     *
     * redirects to the SSL site if is SSL capable
     * added @RussW 31/05/2020
     *
     */
    function has_ssl( $domain ) {

        $res = false;
        $stream = @stream_context_create( array( 'ssl' => array( 'capture_peer_cert' => true ) ) );
        $socket = @stream_socket_client( 'ssl://' . $domain . ':443', $errno, $errstr, 30, STREAM_CLIENT_CONNECT, $stream );

        // If we got an ssl certificate we check here, if the certificate domain matches the website domain.
        if ( $socket ) {
            $cont = stream_context_get_params( $socket );
            $cert_ressource = $cont['options']['ssl']['peer_certificate'];
            $cert = openssl_x509_parse( $cert_ressource );

            // Expected name has format "/CN=*.yourdomain.com"
            $namepart = explode( '=', $cert['name'] );

            // We want to correctly confirm the certificate even for subdomains like "www.yourdomain.com"
            if ( count( $namepart ) == 2 ) {
                $cert_domain  = trim( $namepart[1], '*. ' );
                $check_domain = substr( $domain, -strlen( $cert_domain ) );
                $res          = ($cert_domain == $check_domain);
            }
        }

        return $res;
    }
    if ( defined('_FPA_SSL_REDIRECT') AND ( !defined('_FPA_DEV') AND !defined('_FPA_DIAG') ) ) {
        $checkSSL = has_ssl($_SERVER['HTTP_HOST']);
    }
    $pageURL = $_SERVER['HTTP_HOST'] . _FPA_SELF;
    // do the rediect
    if (is_bool(@$checkSSL) === true AND @$_SERVER['HTTPS'] != 'on') {
        header("Location: https://$pageURL");
        exit;
    }



    /**
     * check for cURL availability
     * (required for LiveChecks to function)
     *
     * - check cURL is not in php disabled_functions
     * - check there is a cURL module loaded
     * - check the curl_exec function is available
     * - DISABLE if doIT = 1 (no point in LiveChecks when generating post content)
     * added @RussW - 27/05/2020
     *
     */
    $canDOLIVE = '0';
    if (
        ( defined('_LIVE_CHECK_FPA')
          OR defined('_LIVE_CHECK_JOOMLA')
          OR defined('_LIVE_CHECK_VEL')
        )
         AND stristr(ini_get('disable_functions'), 'curl') == FALSE
         AND extension_loaded('curl')
         AND function_exists('curl_exec')
         AND @$_POST['doIT'] != 1) {
            $canDOLIVE = '1';
    } // $canDOLIVE



	/** SET THE JOOMLA! PARENT FLAG AND CONSTANTS ********************************************/
	define ( '_VALID_MOS', 1 );               // for J!1.0
	define ( '_JEXEC', 1 );                   // for J!1.5, J!1.6, J!1.7, J!2.5, J!3.0, J!4.0


	// Define some basic assistant information
	define ( '_LICENSE_LINK', '<a href="https://www.gnu.org/licenses/" target="_blank" rel="noopener noreferrer">https://www.gnu.org/licenses/</a>' ); // link to GPL license
	define ( '_LICENSE_FOOTER', ' The FPA comes with ABSOLUTELY NO WARRANTY. <br> This is free software,
	and covered under the GNU GPLv3 or later license. You are welcome to redistribute it under certain conditions.
	For details read the LICENSE.txt file included in the download package with this script.
    A copy of the license may also be obtained at ' );
	define ( '_RES_FPALINK', 'https://github.com/ForumPostAssistant/FPA/tarball/en-GB/' ); // where to get the latest 'Final Releases'
    // @RussW updated 23/05/2020
    define ( '_RES_FPALATEST', 'Download the latest FPA release (tar.gz)' );
	define ( '_RES_FPALINK2', 'https://github.com/ForumPostAssistant/FPA/zipball/en-GB/' ); // where to get the latest 'Final Releases'
    // @RussW updated 23/05/2020
    define ( '_RES_FPALATEST2', 'Download the latest FPA release (zip)' );

	/** DEFINE LANGUAGE STRINGS **************************************************************/
	define ( '_PHP_DISERR', 'Display PHP Errors Enabled' );
	define ( '_PHP_ERRREP', 'PHP Error Reporting Enabled' );
	define ( '_PHP_LOGERR', 'PHP Errors Being Logged To File' );
    // section titles & developer-mode array names
    // updated @RussW 29/05/2020
	define ( '_FPA_SNAP_TITLE', 'Environment Snapshot' );
	define ( '_FPA_INST_TITLE', 'Application Instance' );
	define ( '_FPA_SYS_TITLE', 'System Environment' );
	define ( '_FPA_PHP_TITLE', 'PHP Environment' );
	define ( '_FPA_PHPEXT_TITLE', 'PHP Extensions' );
	define ( '_FPA_PHPREQ_TITLE', 'PHP Requirements' );
	define ( '_FPA_APAMOD_TITLE', 'Apache Modules' );
	define ( '_FPA_APAREQ_TITLE', 'Apache Requirements' );
	define ( '_FPA_DB_TITLE', 'Database Instance' );
	define ( '_FPA_TABLE', 'Tables' );
	define ( '_FPA_DBTBL_TITLE', 'Table Structure' );
	define ( '_FPA_PERMCHK_TITLE', 'Permissions Checks' );
	define ( '_FPA_COREDIR_TITLE', 'Core Folders' );
	define ( '_FPA_ELEVPERM_TITLE', 'Elevated Permissions' );
	define ( '_FPA_EXTCOM_TITLE', 'Components' );
	define ( '_FPA_EXTMOD_TITLE', 'Modules' );
	define ( '_FPA_EXTPLG_TITLE', 'Plugins' );
	define ( '_FPA_TMPL_TITLE', 'Templates' );
	define ( '_FPA_EXTLIB_TITLE', 'Libraries' );
	// snapshot definitions
	define ( '_FPA_SUPPHP', 'PHP Supports');
	define ( '_FPA_SUPSQL', 'Database Supports');
	define ( '_FPA_BADPHP', 'Known Buggy PHP');
	define ( '_FPA_BADZND', 'Known Buggy Zend');
	// slow screen message
    // @RussW _FPA_SLOWGENPOST to be removed 23/05/2020
    define ( '_FPA_SLOWGENPOST', 'Generating Post Output...' );
    // @RussW _FPA_SLOWRUNTEST to be removed 23/05/2020
    define ( '_FPA_SLOWRUNTEST', 'Hang on while we run some tests...' );
    // remove script notice content - Phil 4-17-12
    // @RussW _FPA_DELNOTE_LN1 to be removed 23/05/2020
	define ( '_FPA_DELNOTE_LN1', '<h5 class="text-danger">** SECURITY NOTICE **</h5>' );
    // @RussW updated 23/05/2020
    define ( '_FPA_DELNOTE_LN2', '<p class="small">The FPA script may contain private information that could be used to obtain information by others to compromise your website. We recommend that you remove the FPA script after you use it.</p>' );
    // @RussW updated 23/05/2020
    define ( '_FPA_DELNOTE_LN3', '<p class="text-danger">After use, please delete the FPA script.</p>' );
    // dev/diag-mode content
	define ( '_FPA_DEVMI', 'developer-mode-information' );
    define ( '_FPA_ELAPSE', 'elapse-runtime' );
    // @RussW removed uppercase 27/05/2020
	define ( '_FPA_DEVENA', 'Developer Mode Enabled' );
	define ( '_FPA_DEVDSC', 'This means that a variety of additional information will be displayed on-screen to assist with troubleshooting this script.' );
    // @RussW typo fixed & removed uppercase 27/05/2020
    define ( '_FPA_DIAENA', 'Diagnostic Mode Enabled' );
	define ( '_FPA_DIADSC', 'This means that all php and script errors will be displayed on-screen and logged out to a file named' );
    // @RussW _FPA_DIAERR to be removed 27/05/2020
    define ( '_FPA_DIAERR', 'Last DIGNOSTIC MODE Error' );
	define ( '_FPA_SPNOTE', 'Special Note' );
	// user post form content
	define ( '_FPA_INSTRUCTIONS', 'Instructions' );
	define ( '_FPA_INS_1', 'Enter your problem description <em>(optional)</em>' );
	define ( '_FPA_INS_2', 'Enter any error messages you see <em>(optional)</em>' );
	define ( '_FPA_INS_3', 'Enter any actions taken to resolve the issue <em>(optional)</em>' );
	define ( '_FPA_INS_4', 'Select detail level options of output <em>(optional)</em>' );
    // @RussW updated 23/05/2020
    define ( '_FPA_INS_5', 'Click the <span class="text-success">Click Here To Generate Post</span> button to build the post content' );
    // @RussW updated 23/05/2020
    define ( '_FPA_INS_6', 'Copy the contents of the <span class="text-dark">Post Content</span> box and paste it into a post following the instructions provided' );
    // @RussW updated 23/05/2020
    define ( '_FPA_INS_7', '<p class="text-muted">To copy the contents of the Post Detail box:</p>
            <ol>
            <li class="pb-1">Click the <span class="badge badge-warning">Copy Post Content To Clipboard</span> button</li>
            <li class="text-muted p-1">Login to the Joomla! Forum and start a new post or reply</li>
            <li class="pb-1">Use <strong>CTRL-v</strong> to paste the copied text into your forum post/reply</li>
            <li class="pb-1"><em>Disable smilies to prevent charcters being converted by the forums software</em></li>
            </ol>
            <p class="xsmall py-1 my-1"><i class="fas fa-info-circle text-info"></i> In the event that the "Copy Post Content To Clipboard" button does not work, <strong>click inside the Post Content textarea</strong>, then <strong>press CTRL-a (or Command-a)</strong> to select all the content, then <strong>press CTRL-c (Command-c)</strong> to copy the content and use <strong>CRTL-v (Command-v)</strong> to paste the copied content in to your forum post</p>');
    // @RussW added 23/05/2020
    define ( '_FPA_INS_8', '<p class="text-center">Your site has many extensions installed, the post output exceededs the forum post limit. <strong>Please run the FPA twice</strong> and make two seperate posts/replies.</p><ol><li>First run without the plugins selected</li><li>Run again with only the plugins selected</li></ol>');
	define ( '_FPA_POST_NOTE', 'Leave ALL fields blank/empty to simply post diagnostic information.' );
	define ( '_FPA_PROB_DSC', 'Problem Description' );
	define ( '_FPA_PROB_MSG', 'Log/Error Message' );
	define ( '_FPA_PROB_ACT', 'Actions Taken To Resolve' );
	define ( '_FPA_PROB_CRE', 'Actions To ReCreate Issue' );
	define ( '_FPA_OPT', 'Optional Settings' );
	define ( '_FPA_SHOWELV', 'Show elevated folder permissions' );
	define ( '_FPA_SHOWDBT', 'Show database table statistics' );
	define ( '_FPA_SHOWCOM', 'Show Components' );
	define ( '_FPA_SHOWMOD', 'Show Modules' );
	define ( '_FPA_SHOWLIB', 'Show Libraries' );
	define ( '_FPA_SHOWPLG', 'Show Plugins' );
	define ( '_FPA_SHOWCEX', 'Show Core Extensions' );
	define ( '_FPA_INFOPRI', 'Information Privacy' );
	define ( '_FPA_STRICT', 'Strict' );
	define ( '_FPA_PRIVNON', 'None' );
	define ( '_FPA_PRIVNONNOTE', 'No elements are masked' );
	define ( '_FPA_PRIVPAR', 'Partial' );
	define ( '_FPA_PRIVPARNOTE', 'Some elements are masked' );
	define ( '_FPA_PRIVSTR', 'Strict' );
	define ( '_FPA_PRIVSTRNOTE', 'All indentifiable elements are masked' );
	define ( '_FPA_CLICK', 'Click Here To Generate Post' );
	define ( '_FPA_OUTMEM', 'Out of Memory');
	define ( '_FPA_OUTTIM', 'Execution Time-Outs' );
	define ( '_FPA_INCPOPS', 'Temporarily increase PHP Memory and Execution Time' );
	define ( '_FPA_POSTD', 'Your Forum Post Content' );

	/** common screen and post output strings ************************************************/
	define ( '_FPA_APP', 'Joomla!' );
	define ( '_FPA_INSTANCE', 'Instance' );
	define ( '_FPA_PLATFORM', 'Platform' );
	define ( '_FPA_DB', 'Database');
	define ( '_FPA_SYS', 'System' );
	define ( '_FPA_SERV', 'Server' );
	define ( '_FPA_CLNT', 'Client' );
	define ( '_FPA_HNAME', 'Hostname' );
	define ( '_FPA_DISC', 'Discovery' );
	define ( '_FPA_LEGEND', 'Legends and Settings' );
	define ( '_FPA_GOOD', 'OK/GOOD' );
	define ( '_FPA_WARNINGS', 'WARNINGS' );
	define ( '_FPA_ALERTS', 'ALERTS' );
	define ( '_FPA_SITE', 'Site' );
	define ( '_FPA_ADMIN', 'Admin' );
	define ( '_FPA_BY', 'by' );
	define ( '_FPA_OR', 'or' );
	define ( '_FPA_OF', 'of' );
	define ( '_FPA_TO', 'to' );
	define ( '_FPA_FOR', 'for' );
	define ( '_FPA_IS', 'is' );
	define ( '_FPA_AT', 'at' );
	define ( '_FPA_IN', 'in' );
	define ( '_FPA_BUT', 'but' );
	define ( '_FPA_LAST', 'Last' );
	define ( '_FPA_NONE', 'None' );
	define ( '_FPA_DEF', 'default' );
	define ( '_FPA_Y', 'Yes' );
	define ( '_FPA_N', 'No' );
	define ( '_FPA_FIRST', 'First' );
	define ( '_FPA_M', 'Maybe' );
	define ( '_FPA_MDB', 'Yes - MariaDB Used' );
	define ( '_FPA_U', 'Unknown' );
	define ( '_FPA_K', 'Known' );
	define ( '_FPA_E', 'Exists' );
	define ( '_FPA_JCORE', 'Core' );
	define ( '_FPA_3PD', '3rd Party' );
	define ( '_FPA_TESTP', 'tests performed' );
	define ( '_FPA_DNE', 'Does Not Exist' );
	define ( '_FPA_F', 'Found' );
	define ( '_FPA_NF', 'Not Found' );
	define ( '_FPA_OPTS', 'Options' );
	define ( '_FPA_CF', 'Config' );
	define ( '_FPA_CFG', 'Configuration' );
	define ( '_FPA_YC', 'Configured' );
	define ( '_FPA_NC', 'Not Configured' );
	define ( '_FPA_ECON', 'Connection Error' );
	define ( '_FPA_CON', 'Connect' );
	define ( '_FPA_YCON', 'Connected' );
	define ( '_FPA_CONT', 'Connection Type' );
	define ( '_FPA_NCON', 'Not Connected' );
	define ( '_FPA_SUP', 'support' );
	define ( '_FPA_YSUP', 'supported' );
	define ( '_FPA_DROOT', 'Doc Root' );
	define ( '_FPA_NSUP', 'not supported' );
	define ( '_FPA_NOA', 'Not Attempted' );
	define ( '_FPA_NER', 'No Errors Reported' );
	define ( '_FPA_ER', 'Error(s) Reported' );
	define ( '_FPA_ERR', 'error' );
	define ( '_FPA_ERRS', 'errors' );
	define ( '_FPA_YMATCH', 'Matches' );
	define ( '_FPA_NMATCH', 'Mis-Match' );
	define ( '_FPA_NACOMP', 'Appear Incomplete' );
	define ( '_FPA_YACOMP', 'Appear Complete' );
	define ( '_FPA_SEC', 'Security' );
	define ( '_FPA_FEAT', 'Features' );
	define ( '_FPA_PERF', 'Performance' );
	define ( '_FPA_NA', 'N/A' );
	define ( '_FPA_CRED', 'Credentials' );
	define ( '_FPA_CREDPRES', 'Credentials Present' );
	define ( '_FPA_HOST', 'Host' );
	define ( '_FPA_TEC', 'Technology' );
	define ( '_FPA_WSVR', 'Web Server' );
	define ( '_FPA_HIDDEN', 'protected' );
	define ( '_FPA_PASS', 'Password' );
	define ( '_FPA_USER', 'Username' );
    define ( '_FPA_USR', 'User' );
    // @RussW updated 23/05/2020
	define ( '_FPA_TNAM', 'Name' );
	define ( '_FPA_TSIZ', 'Size' );
	define ( '_FPA_TENG', 'Engine' );
	define ( '_FPA_TCRE', 'Created' );
	define ( '_FPA_TUPD', 'Updated' );
	define ( '_FPA_TCKD', 'Checked' );
	define ( '_FPA_TCOL', 'Collation' );
	define ( '_FPA_CHARS', 'Character Set' );
	define ( '_FPA_TFRA', 'Fragment Size' );
	define ( '_FPA_AUTH', 'Author' );
	define ( '_FPA_ADDR', 'Address' );
	define ( '_FPA_STATUS', 'Status' );
	define ( '_FPA_TYPE', 'Type' );
	define ( '_FPA_TREC', 'Rcds' );  // Number of table records
	define ( '_FPA_TAVL', 'Avg. Length' );
	define ( '_FPA_MODE', 'Mode' );
	define ( '_FPA_WRITABLE', 'Writable' );
	define ( '_FPA_RO', 'Read-Only' );
	define ( '_FPA_FOLDER', 'Folder' );
	define ( '_FPA_FILE', 'File' );
	define ( '_FPA_OWNER', 'Owner' );
	define ( '_FPA_GROUP', 'Group' );
	define ( '_FPA_VER', 'Version' );
	define ( '_FPA_CRE', 'Created' );
	define ( '_FPA_LOCAL', 'Local' );
	define ( '_FPA_REMOTE', 'Remote' );
	define ( '_FPA_SECONDS', 'seconds' );
	define ( '_FPA_TBL', 'Table' );
	define ( '_FPA_STAT', 'Statistics' );
	define ( '_FPA_BASIC', 'Basic' );
	define ( '_FPA_DETAILED', 'Detailed' );
	define ( '_FPA_ENVIRO', 'Environment' );
	define ( '_FPA_VALID', 'Valid' );
	define ( '_FPA_NVALID', 'Not Valid' );
	define ( '_FPA_EN', 'Enabled' );
	define ( '_FPA_DI', 'Disabled' );
	define ( '_FPA_NO', 'No' );
	define ( '_FPA_STATS', 'statistics');
	define ( '_FPA_POTOI', 'Potential Ownership Issues' );
	define ( '_FPA_POTME', 'Potential Missing Extensions' );
	define ( '_FPA_POTMM', 'Potential Missing Modules' );
	define ( '_FPA_DBCONNNOTE', 'may not be an error, check with host for remote access requirements.' );
	define ( '_FPA_DBCREDINC', 'Credentials incomplete or not available');
	define ( '_FPA_MISSINGCRED', 'Missing credentials detected' );
	define ( '_FPA_NODISPLAY', 'Nothing to display.' );
	define ( '_FPA_EMPTY', 'could be empty' );
	define ( '_FPA_UINC', 'increased by user, was' );
	define ( '_PHP_VERLOW', 'PHP version too low' );
	define ( '_FPA_SHOW', 'Show' );
	define ( '_FPA_HIDE', 'Hide' );
	define ( 'act', '');
	define ( '_FPA_MVFW', 'More than one instance of version.php found!' );
	define ( '_FPA_MVFWF', 'Multiple found' );
	define ( '_FPA_DIR_UNREADABLE', 'A directory is <b>NOT READABLE</b> and cannot be checked!');
	define ( '_FPA_DI_PHP_FU', 'Disabled Functions' );
	define ( '_FPA_FDSKSP', 'Free Disk Space' );
	define ( '_FPA_NIMPLY', 'Not implemented for' );
 	define ( '_FPA_PGSQL', 'PostgreSQL' );
 	define ( '_FPA_PMISS', 'Password missing' );
 	define ( '_FPA_DEFI', 'Defines' );
 	define ( '_FPA_DEFIPA', 'Site and Admin config paths not equal' );
 	define ( '_FPA_CONF_PREF_TABLE', '#of Tables with config prefix' );
 	define ( '_FPA_OTHER_TABLE', '#of other Tables' );
 	define ( '_FPA_MSSQL_SUPP', 'Microsoft SQL Server is not supported by the FPA' );
    define ( '_FPA_MYSQLI_CONN', 'PHP function mysqli_connect not found.' );
    // @RussW new 05/2020
    define ( '_FPA_DASHBOARD', 'Dashboard' );
    define ( '_FPA_DASHBOARD_CONFIDENCE_TITLE', 'Confidence' );
    define ( '_FPA_DASHBOARD_CONFIDENCE_NOTE', 'An initial <em>basic confidence audit</em> has been performed to determine if the minimum requirements and best practices have been met to ensure the successful operation of the latest version of Joomla! and it\'s standard functions.');
    define ( '_FPA_DISCOVERY_REPORT', 'Discovery Report' );
    define ( '_FPA_PERMOWN', 'Permissions & Ownership' );
    define ( '_FPA_CNF_A', 'Joomla! should run without any problems' );
    define ( '_FPA_CNF_B', 'Joomla! should run but some features may have minor problems' );
    define ( '_FPA_CNF_C', 'Joomla! might run but some features will have problems' );
    define ( '_FPA_CNF_D', 'Joomla! might run but many features will have problems' );
    define ( '_FPA_CNF_E', 'Joomla! probably will not run or will have many problems' );
    define ( '_FPA_CNF_F', 'Joomla! probably will not run and will have many problems' );

    define ( '_VER_CHECK_ATOLD', 'is out of date' );
    define ( '_VER_CHECK_ATCUR', 'is up to date' );
    define ( '_VER_CHECK_ATDEV', 'is a development version' );

    define ( '_FPA_WIN_LOCALHOST', '<span class="d-inline-block text-dark py-1"><span class="badge badge-info">Note:</span> Elevated permissions are expected on Windows localhost development environments.</span>' );

    define ( '_FPA_JDISCLAIMER', 'Forum Post Assistant (FPA) is not affiliated with or endorsed by The Joomla! Project<sup>&trade;</sup>. Use of the Joomla!<sup>&reg;</sup> name, symbol, logo, and related trademarks is licensed by Open Source Matters, Inc.' );
	/** END LANGUAGE STRINGS *****************************************************************/



    /**
     * delete script
     *
     * attempts to delete file from site. If it fails then message to manually delete the file is presented.
     * fixed undefined index when server uses E_STRICT - PhilD 9-20-12
     * @PhilD 8/07/12
     * @RussW updated 21/05/2020
     * @RussW 30/05/2020
     * added FPA Self Destruct feature, updated to use global file path & $_POST
     *
     */
    if ( ( isset($_POST['act']) AND $_POST['act']  == 'delete' ) OR ( defined('_FPA_SELF_DESTRUCT') AND defined('_FPA_SELF_DESTRUCT_DOIT') ) ) {
        $host        = $_SERVER['HTTP_HOST'];
        $uri         = rtrim( dirname($_SERVER['PHP_SELF'] ), '/\\');
        $extra       = ''; // add index (or other) page if desired

        // try to set script to 777 to make sure we have permission to delete
        @chmod(_FPA_SELF, 0777);  // octal; correct value of mode

        // Delete the file.
        @unlink(_FPA_SELF);

        // Message and link to home page of site.
        // if SSL return to https:// otherwise http://
        if ( @$_SERVER['HTTPS'] == 'on' ? $hostPrefix = 'https://' : $hostPrefix = 'http://');
        $page = $hostPrefix . $host . $uri . $extra;

        // Something went wrong and the script was not deleted so it must be removed manually so we tell the user to do so - PhilD 8-07-12
        if ( file_exists(_FPA_SELF) ) {
            @chmod(_FPA_SELF, 0644);  // octal; correct value of mode

            echo '<div id="deleteMessage" style="padding:20px;border:1px solid #e99002;background-color:#fff8ee;margin:0 auto;margin-top:50px;margin-bottom:20px;max-width:70%;position:relative;z-index:9999;top:10%;font-family:sans-serif, arial;" align="center">';
            echo '<h1 style="color:#e99002;font-size:44px;">SOMETHING WENT WRONG!</h1>';
            if ( defined('_FPA_SELF_DESTRUCT_DOIT') ) {
                echo '<h2 style="color:#43ac6a;">As a security measure, FPA attempted to self-delete itself due to the time it has been present on the server, but was not successful.</h2>';
                echo '<p style="color:#e99002;font-size:20px;margin:0 auto;max-width:80%;">Please remove the file manually using FTP or through your hosting File Manager, or upload a new copy to continue using it.</p>';

            } else {
                echo '<h1 style="color:#e99002;font-size:44px;">SOMETHING WENT WRONG!</h1>';
                echo '<p style="color:#e99002;font-size:30px;">We could not delete the FPA file ('. _FPA_SELF .').</p>';
                echo '<p style="color:#e99002;font-size:20px;margin:0 auto;max-width:80%;">For your website security, please remove the file <em style="color:#f04124;">'. _FPA_SELF .'</em> manually using FTP or through your hosting File Manager.</p>';
            }

        } else {
            echo '<div id="deleteMessage" style="padding:20px;border:1px solid #43ac6a;background-color:#effff5;margin:0 auto;margin-top:50px;margin-bottom:20px;max-width:70%;position:relative;z-index:9999;top:10%;font-family:sans-serif, arial;" align="center">';
            if ( defined('_FPA_SELF_DESTRUCT_DOIT') ) {
                echo '<h2 style="color:#43ac6a;">As a security measure, this copy of FPA has been self-deleted due to the time it has been present on the server.</h2>';
                echo '<p style="color:#e99002;font-size:20px;margin:0 auto;max-width:80%;">You will need to upload another copy of FPA to continue.</p>';
            } else {
                echo '<h1 style="color:#43ac6a;">Thank You For Using The FPA.</h1>';
            }
        }

        echo '<p><a href="'. $page .'">Go to your Home Page.</a></p>';
        echo '</div>';
        exit;

    } // end delete script



    /**
     * darkmode template
     *
     * use the bootswatch cyborg BS4 theme instead of the Yeti theme
     * use PHP_SESSION to maintain the users choice
     * added @RussW 31/05/2020
     *
     */
    session_start();
    if ( @$_POST['darkmode'] == '0' )  {
        $_SESSION['darkmode'] = '0';
        $darkmode             = '0';

    } elseif ( @$_POST['darkmode'] == '1' )  {
        $_SESSION['darkmode'] = '1';
        $darkmode             = '1';

    } elseif ( isset($_SESSION['darkmode']) )  {
        $darkmode             = $_SESSION['darkmode'];
        $_SESSION['darkmode'] = $_SESSION['darkmode'];

    } elseif ( !isset($_SESSION['darkmode']) OR ( $_SESSION['darkmode'] != '1' OR @$_POST['darkmode'] != '1' ) )  {
        //session_start();
        $_SESSION['darkmode'] = '0';
        $darkmode             = '0';
    }
    // unset($_SESSION['darkmode']);
    // session_destroy();

    // TESTING PRIVACY
    // setup the default runtime parameters and collect the POST data changes, if any
    if ( !$_SESSION ) {
        session_start();
    }

    if ( @$_POST['showProtected'] == 0 ) {
        $_SESSION['privacy'] = 0;
        $showProtected       = 0;

    } elseif ( @$_POST['showProtected'] == 1 ) {
        $_SESSION['privacy'] = 1;
        $showProtected       = 1;

    } elseif ( isset($_SESSION['privacy']) ) {
        $_SESSION['privacy'] = $_SESSION['privacy'];
        $showProtected       = $_SESSION['privacy'];

    } elseif ( !isset($_SESSION['privacy']) OR ( $_SESSION['privacy'] != 1 OR !isset($_POST['showProtected']) OR @$_POST['showProtected'] != 1 OR $showProtected != 1 ) )  {
        $_SESSION['privacy'] = 0;
        $showProtected       = 0;

	} else {
        $showProtected       = 0;
        $_SESSION['privacy'] = 0;

    }

    // hardened server and no explicit choice
    if ( extension_loaded('suhosin') AND !isset($_POST['showProtected']) ) {
        $showProtected       = 1;
        $_SESSION['privacy'] = 1;
    }
    //unset($_SESSION['privacy']);
    //unset($_SESSION);
    //session_destroy();

    /*
	// setup the default runtime parameters and collect the POST data changes, if any
	if ( @$_POST['showProtected'] ) {
		$showProtected  = @$_POST['showProtected'];

	} else {
		$showProtected = 2; // default (limited privacy masking)
    }
    */

	if ( @$_POST['showElevated'] == 0 AND  @$_POST['doIT'] == 1   ) {
		$showElevated  = 0;

	} else {
		$showElevated = 1; // default 1(show) changed default to 1 Phil 4-20-12
	}

	if ( @$_POST['showTables'] == 0 AND  @$_POST['doIT'] == 1   ) {
		$showTables  = 0;

	} else {
		$showTables = 1;
	}

	if ( @$_POST['showComponents'] == 0 AND  @$_POST['doIT'] == 1   ) {
		$showComponents  = 0;

	} else {
		$showComponents = 1; // default 0 (hide) changed default to 1 Phil 4-20-12
	}

	if ( @$_POST['showModules'] == 0 AND  @$_POST['doIT'] == 1   ) {
		$showModules  = 0;

	} else {
		$showModules = 1; // default 0 (hide) changed default to 1 Phil 4-20-12
	}

	if ( @$_POST['showLibraries'] == 0 AND  @$_POST['doIT'] == 1  ) {
		$showLibraries  = 0;

	} else {
		$showLibraries = 1;
	}

	if ( @$_POST['showPlugins'] == 0 AND  @$_POST['doIT'] == 1  ) {
		$showPlugins  = 0;

	} else {
		$showPlugins = 1; // default 0(hide) changed default to 1 Phil 4-20-12
	}

	if ( @$_POST['showCoreEx'] == 0 AND  @$_POST['doIT'] == 1 ) {
        $showCoreEx  = 0;

	} else {
		$showCoreEx = 1;
	}



	/** TIMER-POPS ***************************************************************************/
	// mt_get: returns the current microtime
	function mt_get(){
		global $mt_time;
		list($usec, $sec) = explode(" ", microtime());
		return ((float)$usec + (float)$sec);
	}

	// mt_start: starts the microtime counter
	function mt_start(){
		global $mt_time; $mt_time = mt_get();
	}

	// mt_end: calculates the elapsed time
	function mt_end($len=3){
		global $mt_time;
		$time_end = mt_get();
		return round($time_end - $mt_time, $len);

	}
	// actually start the timer-pop
	mt_start();



	// build the initial arrays used throughout fpa/bra
	$fpa['ARRNAME']         = _RES;
	$fpa['diagLOG']         = 'fpa-Diag.log';
	$snapshot['ARRNAME']        = _FPA_SNAP_TITLE;
	$instance['ARRNAME']        = _FPA_INST_TITLE;
	$system['ARRNAME']          = _FPA_SYS_TITLE;
	$phpenv['ARRNAME']          = _FPA_PHP_TITLE;
	$phpenv['phpLASTERR']       = '';
	$phpextensions['ARRNAME']   = _FPA_PHPEXT_TITLE;
	$phpreq['ARRNAME']          = _FPA_PHPREQ_TITLE;
	$phpreq['libxml']           = '';
	$phpreq['xml']              = '';
	$phpreq['zlib']             = '';
	$phpreq['zip']              = '';
	$phpreq['openssl']          = '';
	$phpreq['curl']             = '';
	$phpreq['iconv']            = '';
	$phpreq['mbstring']         = '';
	$phpreq['mysql']            = '';
	$phpreq['mysqli']           = '';
	$phpreq['pdo_mysql']        = '';
	$phpreq['mcrypt']           = '';
	$apachemodules['ARRNAME']   = _FPA_APAMOD_TITLE;
	$apachereq['ARRNAME']       = _FPA_APAREQ_TITLE;
	$apachereq['mod_rewrite']   = '';
	$apachereq['mod_expires']   = '';
	$apachereq['mod_deflate']   = '';
	$apachereq['mod_security']  = '';
	$apachereq['mod_evasive']   = '';
	$apachereq['mod_dosevasive'] = '';
	$apachereq['mod_ssl']       = '';
	$apachereq['mod_qos']       = '';
	$apachereq['mod_userdir']  = '';
	$database['ARRNAME']        = _FPA_DB_TITLE;
	$tables['ARRNAME']          = _FPA_DBTBL_TITLE;
	$modecheck['ARRNAME']       = _FPA_PERMCHK_TITLE;
	// folders to be tested for permissions
	$folders['ARRNAME']         = _FPA_COREDIR_TITLE;
	$folders[]                  = 'images/';
	$folders[]                  = 'components/';
	$folders[]                  = 'modules/';
	$folders[]                  = 'plugins/';               // J!1.5 and above | either / or
	$folders[]                  = 'mambots/';               // J!1.0 only
	$folders[]                  = 'language/';
	$folders[]                  = 'templates/';
	$folders[]                  = 'cache/';
	$folders[]                  = 'logs/';
	$folders[]                  = 'tmp/';
	$folders[]                  = 'administrator/components/';
	$folders[]                  = 'administrator/modules/';
	$folders[]                  = 'administrator/language/';
	$folders[]                  = 'administrator/templates/';
	$folders[]                  = 'sites/';                 // nooku only?
	$folders[]                  = 'administrator/logs/';
	$elevated['ARRNAME']        = _FPA_ELEVPERM_TITLE;
	$component['ARRNAME']       = _FPA_EXTCOM_TITLE;
	$module['ARRNAME']          = _FPA_EXTMOD_TITLE;
	$plugin['ARRNAME']          = _FPA_EXTPLG_TITLE;
	$template['ARRNAME']        = _FPA_TMPL_TITLE;
	$library['ARRNAME']         = _FPA_EXTLIB_TITLE;



	// build the developer-mode function to display the raw arrays
	function showDev( &$section ) {
		if ( defined( '_FPA_DEV' ) ) {
            echo '<div class="row"><div class="col-12">';
			echo '<div class="card border border-warning mb-3 w-100">';
			echo '<div class="card-header bg-warning text-white">';
			echo '<span class="text-dark">['. _FPA_DEVMI .']</span><br />';
			echo @$section['ARRNAME'] .' Array :';
			echo '</div>';

            echo '<div class="card-body small p-2">';
            echo '<pre class="xsmall m-0">';
                print_r ( $section );
            echo '<pre>';
			echo '<p class="m-0"><em>'. _FPA_ELAPSE .': <strong>'. mt_end() .'</strong> '. _FPA_SECONDS .'</em></p>';
			echo '</div>';
            echo '</div>';
			echo '</div></div>';
		} // end if _FPA_DEV defined
	} // end developer-mode function



	/** DETERMINE SOME SETTINGS BEFORE FPA MIGHT PLAY WITH THEM ******************************/
	$phpenv['phpERRORDISPLAY']  = ini_get( 'display_errors' );
	$phpenv['phpERRORREPORT']   = ini_get( 'error_reporting' );
	$fpa['ORIGphpMEMLIMIT']     = ini_get( 'memory_limit' );
	$fpa['ORIGphpMAXEXECTIME']  = ini_get( 'max_execution_time' );
	$phpenv['phpERRLOGFILE']    = ini_get( 'error_log' );
	$system['sysSHORTOS']       = strtoupper( substr( PHP_OS, 0, 3 ) ); // WIN, DAR, LIN, SOL
	$system['sysSHORTWEB']      = strtoupper( substr( $_SERVER['SERVER_SOFTWARE'], 0, 3 ) ); // APA = Apache, MIC = MS IIS, LIT = LiteSpeed etc



	// if the user see's Out Of Memory or Execution Timer pops, double the current memory_limit and max_execution_time
	if ( @$_POST['increasePOPS'] == 1 ) {
		ini_set ( 'memory_limit', (rtrim($fpa['ORIGphpMEMLIMIT'],"M")*2)."M" );
		ini_set ( 'max_execution_time', ($fpa['ORIGphpMAXEXECTIME']*2) );
	}



	/**
     * DETERMINE IF THERE IS A KNOWN ERROR ALREADY
     *
	 * here we try and determine if there is an existing php error log file, if there is we
	 * then look to see how old it is, if it's less than one day old, lets see if what the last
	 * error this and try and auto-enter that as the problem description
	 */
	// is there an existing php error-log file?
	if ( file_exists( $phpenv['phpERRLOGFILE'] ) ) {
		// when was the file last modified?
		$phpenv['phpLASTERRDATE'] = @date ("dS F Y H:i:s.", filemtime( $phpenv['phpERRLOGFILE'] ));

		// determine the number of seconds for one day
		$age = 86400;
		// $age = strtotime('tomorrow') - time();
		// get the modified time in seconds
		$file_time = filemtime( $phpenv['phpERRLOGFILE'] );
		// get the current time in seconds
		$now_time = time();

        /**
         * if the file was modified less than one day ago, grab the last error entry
         * Changed this section to get rid of the "Strict Standards: Only variables should be passed by reference" error
         * Phil - 9-20-12
         *
         */
		if ( $now_time - $file_time < $age ) {
            /**
             * !FIXME memory allocation error on large php_error file - RussW
             * replaced these two lines with code below - Phil 09-23-12
             *  $lines = file( $phpenv['phpERRLOGFILE'] );
             *  $phpenv['phpLASTERR'] = array_pop( $lines );
             *
             * Begin the fix for the memory allocation error on large php_error file
             * Solution is to read the file line by line; not reading the whole file in memory.
             * I just open a kind of a pointer to it, then seek it char by char.
             * This is a more efficient way to work with large files.   - Phil 09-23-12
             *
             */
            $line = '';

            $f = fopen(($phpenv['phpERRLOGFILE']), 'r');
            $cursor = -1;

            fseek($f, $cursor, SEEK_END);
            $char = fgetc($f);

            // Trim trailing newline chars of the file
            while ($char === "\n" || $char === "\r") {
                fseek($f, $cursor--, SEEK_END);
                $char = fgetc($f);
            }

            // Read until the start of file or first newline char
            while ($char !== false && $char !== "\n" && $char !== "\r") {
                // Prepend the new char
                $line = $char . $line;
                fseek($f, $cursor--, SEEK_END);
                $char = fgetc($f);
            }

            $phpenv['phpLASTERR'] = $line;
        }
    } // End Fix for memory allocation error when reading php_error file



	/**
     * DETERMINE INSTANCE STATUS & VERSIONING
     *
	 * here we check for known files to determine if an instance even exists, then we look for
	 * the version and configuration files. some differ between between versions, so we have a
	 * bit of jiggling to do.
	 * to try and avoid "white-screens" fpa no-longer "includes" these files, but merely tries
	 * to open and read them, although this is slower, it improves the reliability of fpa.
     *
	 */

    /**
     * is an instance present?
     *
     * this is a two-fold sanity check, we look two pairs of known folders, only one pair need exist
     * this caters for the potential of missing folders, but is not exhaustive or too time consuming
     *
     */
    if ( ( file_exists( 'components/' ) AND file_exists( 'modules/' ) ) OR ( file_exists( 'administrator/components/' ) AND file_exists( 'administrator/modules/' ) ) ) {
        $instance['instanceFOUND'] = _FPA_Y;

    } else {
        $instance['instanceFOUND'] = _FPA_N;
    }



    /**
     * what version is the instance?
     *
     */
    // >= J3.8.0
    if ( file_exists( 'libraries/src/Version.php' ) ) {
        $instance['cmsVFILE'] = 'libraries/src/Version.php';

    // >= J3.6.3
    } elseif ( file_exists( 'libraries/cms/version/version.php' ) AND !file_exists( 'libraries/platform.php' ) ) {
        $instance['cmsVFILE'] = 'libraries/cms/version/version.php';

    // J2.5 & J3.0 libraries/joomla/platform.php files
    } elseif ( file_exists( 'libraries/cms/version/version.php' ) AND file_exists( 'libraries/platform.php' ) ) {
        $instance['cmsVFILE'] = 'libraries/cms/version/version.php';

    // J1.7 includes/version.php & libraries/joomla/platform.php files
    } elseif ( file_exists( 'includes/version.php' ) AND file_exists( 'libraries/platform.php' ) ) {
        $instance['cmsVFILE'] = 'includes/version.php';

    // J1.6 libraries/joomla/version.php & joomla.xml files
    } elseif ( file_exists( 'libraries/joomla/version.php' ) AND file_exists( 'joomla.xml' ) ) {
        $instance['cmsVFILE'] = 'libraries/joomla/version.php';

    // J1.5 & Nooku Server libraries/joomla/version.php & koowa folder
    } elseif ( file_exists( 'libraries/joomla/version.php' ) AND file_exists( 'libraries/koowa/koowa.php' ) ) {
        $instance['cmsVFILE'] = 'libraries/joomla/version.php';

    // J1.5 libraries/joomla/version.php & xmlrpc folder
    } elseif ( file_exists( 'libraries/joomla/version.php' ) AND file_exists( 'xmlrpc/' ) ) {
        $instance['cmsVFILE'] = 'libraries/joomla/version.php';

    // J1.0 includes/version.php & mambots folder
    } elseif ( file_exists( 'includes/version.php' ) AND file_exists( 'mambots/' ) ) {
        $instance['cmsVFILE'] = 'includes/version.php';

    // fpa could find the required files to determine version(s)
    } else {
        $instance['cmsVFILE'] = _FPA_N;
    }



    /**
     * Detect multiple instances of version file
     *
     */
    if ( file_exists( 'libraries/src/Version.php' ) ) {
        $vFile1 = 1;
    } else {
        $vFile1 = 0;}
    if ( file_exists( 'libraries/cms/version/version.php' ) ) {
        $vFile2 = 1;
    } else {
        $vFile2 = 0;}
    if ( file_exists( 'includes/version.php' ) ) {
        $vFile3 = 1;
    } else {
        $vFile3 = 0;}
    if ( file_exists( 'libraries/joomla/version.php' ) ) {
        $vFile4 = 1;
    } else {
        $vFile4 = 0;}
    $vFileSum = $vFile1 + $vFile2 + $vFile3 + $vFile4;



    /**
     * what version is the framework? (J!1.7 & above)
     *
     */
    // J1.7 libraries/joomla/platform.php
    if ( file_exists( 'libraries/platform.php' ) ) {
        $instance['platformVFILE'] = 'libraries/platform.php';

    // J1.5 Nooku Server libraries/koowa/koowa.php
    } elseif ( file_exists( 'libraries/koowa/koowa.php' ) ) {
        $instance['platformVFILE'] = 'libraries/koowa/koowa.php';

    // J3.7
    } elseif ( file_exists( 'libraries/joomla/platform.php' ) ) {
        $instance['platformVFILE'] = 'libraries/joomla/platform.php';

    } else {
        $instance['platformVFILE'] = _FPA_N;
    }



    // read the cms version file into $cmsVContent (all versions)
    if ( $instance['cmsVFILE'] != _FPA_N ) {
        $cmsVContent = file_get_contents( $instance['cmsVFILE'] );
            // find the basic cms information
            preg_match ( '#\$PRODUCT\s*=\s*[\'"](.*)[\'"]#', $cmsVContent, $cmsPRODUCT );
            preg_match ( '#\$RELEASE\s*=\s*[\'"](.*)[\'"]#', $cmsVContent, $cmsRELEASE );
            preg_match ( '#\$(?:DEV_LEVEL|MAINTENANCE)\s*=\s*[\'"](.*)[\'"]#', $cmsVContent, $cmsDEVLEVEL );
            preg_match ( '#\$(?:DEV_STATUS|STATUS)\s*=\s*[\'"](.*)[\'"]#', $cmsVContent, $cmsDEVSTATUS );
            preg_match ( '#\$(?:CODENAME|CODE_NAME)\s*=\s*[\'"](.*)[\'"]#', $cmsVContent, $cmsCODENAME );
            preg_match ( '#\$(?:RELDATE|RELEASE_DATE)\s*=\s*[\'"](.*)[\'"]#', $cmsVContent, $cmsRELDATE );

                // Joomla 3.5 - 3.9
                if (empty($cmsPRODUCT))
                {
                    preg_match ( '#const\s*PRODUCT\s*=\s*[\'"](.*)[\'"]#', $cmsVContent, $cmsPRODUCT );
                    preg_match ( '#const\s*RELEASE\s*=\s*[\'"](.*)[\'"]#', $cmsVContent, $cmsRELEASE );
                    preg_match ( '#const\s*DEV_LEVEL\s*=\s*[\'"](.*)[\'"]#', $cmsVContent, $cmsDEVLEVEL );
                    preg_match ( '#const\s*DEV_STATUS\s*=\s*[\'"](.*)[\'"]#', $cmsVContent, $cmsDEVSTATUS );
                    preg_match ( '#const\s*CODENAME\s*=\s*[\'"](.*)[\'"]#', $cmsVContent, $cmsCODENAME );
                    preg_match ( '#const\s*RELDATE\s*=\s*[\'"](.*)[\'"]#', $cmsVContent, $cmsRELDATE );
                    preg_match ( '#const\s*MAJOR_VERSION\s*=\s*(.*);#', $cmsVContent, $cmsMAJOR_VERSION );
                }

                // Joomla 4
                if (empty($cmsRELEASE))
                {
                    preg_match ( '#const\s*PRODUCT\s*=\s*[\'"](.*)[\'"]#', $cmsVContent, $cmsPRODUCT );
                    preg_match ( '#const\s*DEV_STATUS\s*=\s*[\'"](.*)[\'"]#', $cmsVContent, $cmsDEVSTATUS );
                    preg_match ( '#const\s*CODENAME\s*=\s*[\'"](.*)[\'"]#', $cmsVContent, $cmsCODENAME );
                    preg_match ( '#const\s*RELDATE\s*=\s*[\'"](.*)[\'"]#', $cmsVContent, $cmsRELDATE );
                    preg_match ( '#const\s*EXTRA_VERSION\s*=\s*[\'"](.*)[\'"]#', $cmsVContent, $EXTRA_VERSION );
                    preg_match ( '#const\s*MAJOR_VERSION\s*=\s*(.*);#', $cmsVContent, $cmsMAJOR_VERSION );
                    preg_match ( '#const\s*MINOR_VERSION\s*=\s*(.*);#', $cmsVContent, $cmsMINOR_VERSION );
                    preg_match ( '#const\s*PATCH_VERSION\s*=\s*(.*);#', $cmsVContent, $cmsPATCH_VERSION );
                    $cmsRELEASE[1] = $cmsMAJOR_VERSION[1] . '.' . $cmsMINOR_VERSION[1];
                    if (strlen($EXTRA_VERSION[1]) > 0) {
                        $cmsDEVLEVEL[1] = $cmsPATCH_VERSION[1]. '-' . $EXTRA_VERSION[1] ;
                    } else {
                        $cmsDEVLEVEL[1] = $cmsPATCH_VERSION[1] ;
                    }
                }

                if (empty($cmsMAJOR_VERSION))
                {
                    $cmsMAJOR_VERSION[1] = '0' ;
                }

                $instance['cmsMAJORVERSION'] = $cmsMAJOR_VERSION[1];
                $instance['cmsPRODUCT'] = $cmsPRODUCT[1];
                $instance['cmsRELEASE'] = $cmsRELEASE[1];
                $instance['cmsDEVLEVEL'] = $cmsDEVLEVEL[1];
                $instance['cmsDEVSTATUS'] = $cmsDEVSTATUS[1];
                $instance['cmsCODENAME'] = $cmsCODENAME[1];
                $instance['cmsRELDATE'] = $cmsRELDATE[1];
    }



    // read the platform version file into $platformVContent (J!1.7 & above only)
    if ( $instance['platformVFILE'] != _FPA_N ) {

        $platformVContent = file_get_contents( $instance['platformVFILE'] );

        // find the basic platform information
        if ( $instance['platformVFILE'] == 'libraries/koowa/koowa.php' ) {

            // Nooku platform based
            preg_match ( '#VERSION.*=\s[\'|\"](.*)[\'|\"];#', $platformVContent, $platformRELEASE );
            preg_match ( '#VERSION.*=\s[\'|\"].*-(.*)-.*[\'|\"];#', $platformVContent, $platformDEVSTATUS );

                $instance['platformPRODUCT'] = 'Nooku';
                $instance['platformRELEASE'] = $platformRELEASE[1];
                $instance['platformDEVSTATUS'] = $platformDEVSTATUS[1];

        } else {

            // default to the Joomla! platform, as it is most common at the momemt
            preg_match ( '#PRODUCT\s*=\s*[\'"](.*)[\'"]#', $platformVContent, $platformPRODUCT );
            preg_match ( '#RELEASE\s*=\s*[\'"](.*)[\'"]#', $platformVContent, $platformRELEASE );
            preg_match ( '#MAINTENANCE\s*=\s*[\'"](.*)[\'"]#', $platformVContent, $platformDEVLEVEL );
            preg_match ( '#STATUS\s*=\s*[\'"](.*)[\'"]#', $platformVContent, $platformDEVSTATUS );
            preg_match ( '#CODE_NAME\s*=\s*[\'"](.*)[\'"]#', $platformVContent, $platformCODENAME );
            preg_match ( '#RELEASE_DATE\s*=\s*[\'"](.*)[\'"]#', $platformVContent, $platformRELDATE );

                // Joomla 3.5 - 3.9
                if (empty($platformPRODUCT))
                {
                    preg_match ( '#const\s*PRODUCT\s*=\s*[\'"](.*)[\'"]#', $cmsVContent, $cmsPRODUCT );
                    preg_match ( '#const\s*RELEASE\s*=\s*[\'"](.*)[\'"]#', $cmsVContent, $cmsRELEASE );
                    preg_match ( '#const\s*MAINTENANCE\s*=\s*[\'"](.*)[\'"]#', $cmsVContent, $cmsDEVLEVEL );
                    preg_match ( '#const\s*STATUS\s*=\s*[\'"](.*)[\'"]#', $cmsVContent, $cmsDEVSTATUS );
                    preg_match ( '#const\s*CODE_NAME\s*=\s*[\'"](.*)[\'"]#', $cmsVContent, $cmsCODENAME );
                    preg_match ( '#const\s*RELEASE_DATE\s*=\s*[\'"](.*)[\'"]#', $cmsVContent, $cmsRELDATE );
                }

                $instance['platformPRODUCT'] = $platformPRODUCT[1];
                $instance['platformRELEASE'] = $platformRELEASE[1];
                $instance['platformDEVLEVEL'] = $platformDEVLEVEL[1];
                $instance['platformDEVSTATUS'] = $platformDEVSTATUS[1];
                $instance['platformCODENAME'] = $platformCODENAME[1];
                $instance['platformRELDATE'] = $platformRELDATE[1];
        }

    }



    /**
     * is Joomla! installed/configured?
     *
     * determine exactly where the REAL configuration file is, it might not be the one in the "/" folder
     *
     */
    if ( @$instance['cmsRELEASE'] == '1.0' ) {

        if ( file_exists( 'configuration.php' ) ) {
            $instance['configPATH'] = 'configuration.php';
        }

    } elseif ( @$instance['cmsRELEASE'] == '1.5' ) {
        $instance['configPATH'] = 'configuration.php';

    } elseif ( @$instance['cmsRELEASE'] >= '1.6' ) {

        if ( file_exists( 'defines.php' ) OR file_exists( 'administrator\defines.php' )) {
            $instance['definesEXIST'] = _FPA_Y;

            // look for a 'defines' override file in the "/" folder.
            if ( file_exists( 'defines.php' ) ) {

                $cmsOverride = file_get_contents( 'defines.php' );
                preg_match ( '#JPATH_CONFIGURATION\s*\S*\s*[\'"](.*)[\'"]#', $cmsOverride, $cmsOVERRIDEPATH );

                if ( file_exists( @$cmsOVERRIDEPATH[1] . '\configuration.php' ) ) {
                    $instance['configPATH'] = $cmsOVERRIDEPATH[1] . '\configuration.php';
                    $instance['configSiteDEFINE'] = _FPA_Y;
                } else {
                    $instance['configPATH'] = 'configuration.php';
                    $instance['configSiteDEFINE'] = _FPA_Y;
                }

            } else {
                $instance['configPATH'] = 'configuration.php';
                $instance['configSiteDEFINE'] = _FPA_N ;
            }

            if ( file_exists( 'administrator\defines.php' ) ) {

                $cmsAdminOverride = file_get_contents( 'administrator\defines.php' );
                preg_match ( '#JPATH_CONFIGURATION\s*\S*\s*[\'"](.*)[\'"]#', $cmsAdminOverride, $cmsADMINOVERRIDEPATH );

                if ( file_exists( @$cmsOVERRIDEPATH[1] . '\configuration.php' ) ) {
                    $instance['configADMINPATH'] = $cmsADMINOVERRIDEPATH[1] . '\configuration.php';
                    $instance['configAdminDEFINE'] = _FPA_Y;

                } else {
                    $instance['configADMINPATH'] = 'configuration.php';
                    $instance['configAdminDEFINE'] = _FPA_Y;
                }

            } else {
                $instance['configAdminDEFINE'] = _FPA_N;
                $instance['configADMINPATH'] = 'configuration.php';
            }

            if (( $instance['configPATH'] <> $instance['configADMINPATH'] ) OR ($instance['configSiteDEFINE'] <> $instance['configAdminDEFINE'] )) {
                $instance['equalPATH'] = _FPA_N;

            } else {
                $instance['equalPATH'] = _FPA_Y;
            }

        } else {
            $instance['configPATH'] = 'configuration.php';
            $instance['definesEXIST'] = _FPA_N;
            $instance['equalPATH'] = _FPA_Y;
        }

    } else {
        $instance['configPATH'] = 'configuration.php';
    }


    // check the configuration file (all versions)
    if ( file_exists( $instance['configPATH'] ) ) {
        $instance['instanceCONFIGURED'] = _FPA_Y;

        // determine it's ownership and mode
        if ( is_writable( $instance['configPATH'] ) ) {
            $instance['configWRITABLE']	= _FPA_Y;

        } else {
            $instance['configWRITABLE']	= _FPA_N;
        }

        $instance['configMODE'] = substr( sprintf('%o', fileperms( $instance['configPATH'] ) ),-3, 3 );

        if ( function_exists( 'posix_getpwuid' ) AND $system['sysSHORTOS'] != 'WIN' ) { // gets the UiD and converts to 'name' on non Windows systems
            $instance['configOWNER'] = posix_getpwuid( fileowner( $instance['configPATH'] ) );
            $instance['configGROUP'] = posix_getgrgid( filegroup( $instance['configPATH'] ) );

        } else { // only get the UiD for Windows, not 'name'
            $instance['configOWNER']['name'] = fileowner( $instance['configPATH'] );
            $instance['configGROUP']['name'] = filegroup( $instance['configPATH'] );
        }



        /**
         * if present, is the configuration file valid?
         *
         * added code to fix the config version mis-match on 2.5 versions of Joomla - 4-8-12 - Phil
         * reworked code block to better determine version in 1.7 - 3.0+ versions of Joomla - 8-06-12 - Phil
         *
         */
        $cmsCContent = file_get_contents( $instance['configPATH'] );

        // >= 3.8.0
        if ( preg_match ( '#(public)#', $cmsCContent ) AND file_exists( 'libraries/src/Version.php' ) ) {
            $instance['configVALIDFOR'] = $instance['cmsRELEASE'];
            $instance['cmsVFILE'] = 'libraries/src/Version.php';
            $instance['instanceCFGVERMATCH'] = _FPA_Y;

        // >= 3.6.3
        } elseif ( preg_match ( '#(public)#', $cmsCContent ) AND $instance['platformVFILE'] == _FPA_N AND file_exists( 'libraries/cms/version/version.php' ) ) {
            $instance['configVALIDFOR'] = $instance['cmsRELEASE'];
            $instance['cmsVFILE'] = 'libraries/cms/version/version.php';
            $instance['instanceCFGVERMATCH'] = _FPA_Y;

        //for 3.0
        } elseif ( preg_match ( '#(public)#', $cmsCContent ) AND $instance['platformVFILE'] != _FPA_N ) {
            $instance['configVALIDFOR'] = $instance['cmsRELEASE'];
            $instance['cmsVFILE'] = 'libraries/cms/version/version.php';
            $instance['instanceCFGVERMATCH'] = _FPA_Y;

        //for 2.5
        } elseif ( preg_match ( '#(public)#', $cmsCContent ) AND substr( $instance['platformRELEASE'],0,2 ) == '11' ) {
            $instance['configVALIDFOR'] = $instance['cmsRELEASE'];
            $instance['cmsVFILE'] = 'libraries/cms/version/version.php';
            $instance['instanceCFGVERMATCH'] = _FPA_Y;

        //for 1.7
        } elseif ( preg_match ( '#(public)#', $cmsCContent ) AND $instance['platformVFILE'] != _FPA_N  AND $instance['cmsVFILE'] != 'libraries/cms/version/version.php') {
            $instance['cmsVFILE'] = 'includes/version.php';
            $instance['configVALIDFOR'] = $instance['cmsRELEASE'];
            $instance['instanceCFGVERMATCH'] = _FPA_Y;

        //for 1.6
        } elseif ( preg_match ( '#(public)#', $cmsCContent ) AND $instance['platformVFILE'] == _FPA_N ) {
            $instance['configVALIDFOR'] = '1.6';
            $instance['instanceCFGVERMATCH'] = _FPA_Y;

        // for 1.5
        } elseif ( preg_match ( '#(var)#', $cmsCContent ) ) {
            $instance['configVALIDFOR'] = '1.5';
            $instance['instanceCFGVERMATCH'] = _FPA_Y;

        // for 1.0
        } elseif ( preg_match ( '#(\$mosConfig_)#', $cmsCContent ) ) {
            $instance['configVALIDFOR'] = '1.0';
            $instance['instanceCFGVERMATCH'] = _FPA_Y;

        } else {
            $instance['configVALIDFOR'] = _FPA_U;
        }


        // fpa found a configuration.php but couldn't determine the version, is it valid?
        if ( $instance['configVALIDFOR'] == _FPA_U ) {

            if ( filesize( $instance['configPATH'] ) < 512 ) {
                    $instance['configSIZEVALID'] = _FPA_N;
            }
        }


        // check if the configuration.php version matches the discovered version
        if ( $instance['configVALIDFOR'] != _FPA_U AND $instance['cmsVFILE'] != _FPA_N ) {

            // set defaults for the configuration's validity and a sanity score of zero
            $instance['configSANE'] = _FPA_N;
            $instance['configSANITYSCORE'] = 0;


            // !TODO add white-space etc checks
            // do some configuration.php sanity/validity checks
            if ( filesize( $instance['configPATH'] ) > 512 ) {
                $instance['cfgSANITY']['configSIZEVALID'] = _FPA_Y;
            }

            // !TODO FINISH  white-space etc checks
            $instance['cfgSANITY']['configNOTDIST']  = _FPA_Y;   // is not the distribution example
            $instance['cfgSANITY']['configNOWSPACE'] = _FPA_Y;  // no white-space
            $instance['cfgSANITY']['configOPTAG']    = _FPA_Y;     // has php open tag
            $instance['cfgSANITY']['configCLTAG']    = _FPA_Y;     // has php close tag
            $instance['cfgSANITY']['configJCONFIG']  = _FPA_Y;   // has php close tag

            // run through the sanity checks, if sane ( =Yes ) increment the score by 1 (should total 6)
            foreach ( $instance['cfgSANITY'] as $i => $sanityCHECK ) {

                if ( $instance['cfgSANITY'][$i] == _FPA_Y ) {
                    $instance['configSANITYSCORE'] = $instance['configSANITYSCORE'] +1;
                }

            }

            // if the configuration file is sane, set it as valid
            if ( $instance['configSANITYSCORE'] == '6' ) {
                $instance['configSANE'] = _FPA_Y;   // configuration appears valid?
            }

        } else {
            $instance['instanceCFGVERMATCH'] = _FPA_U;
        }



        /**
         * include configuration.php
         *
         */
        if ( $instance['configVALIDFOR'] != _FPA_U ) {
            ini_set( 'display_errors', 1 );
            $includeconfig = require_once($instance['configPATH']);
            $config = new JConfig();

            if ( defined( '_FPA_DIAG' ) ) {
                ini_set( 'display_errors', 1 );

            } else {
                ini_set( 'display_errors', 0 );
            }

            $instance['configERRORREP'] = $config->error_reporting;
            $instance['configDBTYPE'] = $config->dbtype;
            $instance['configDBHOST'] = $config->host;
            $instance['configDBNAME'] = $config->db;
            $instance['configDBPREF'] = $config->dbprefix;
            $instance['configDBUSER'] = $config->user;
            $instance['configDBPASS'] = $config->password;

            switch ($config->offline) {
                case true:
                    $instance['configOFFLINE'] = 'true';
                    break;
                case false:
                    $instance['configOFFLINE'] = 'false';
                    break;
                default:
                    $instance['configOFFLINE'] = $config->offline;
            }

            switch ($config->sef) {
                case true:
                    $instance['configSEF'] = 'true';
                    break;
                case false:
                    $instance['configSEF'] = 'false';
                    break;
                default:
                    $instance['configSEF'] = $config->sef;
            }

            switch ($config->gzip) {
                case true:
                    $instance['configGZIP'] = 'true';
                    break;
                case false:
                    $instance['configGZIP'] = 'false';
                    break;
                default:
                    $instance['configGZIP'] = $config->gzip;
            }

            switch ($config->caching) {
                case true:
                    $instance['configCACHING'] = 'true';
                    break;
                case false:
                    $instance['configCACHING'] = 'false';
                    break;
                default:
                    $instance['configCACHING'] = $config->caching;
            }

            switch ($config->debug) {
                case true:
                    $instance['configSITEDEBUG'] = 'true';
                    break;
                case false:
                    $instance['configSITEDEBUG'] = 'false';
                    break;
                default:
                    $instance['configSITEDEBUG'] = $config->debug;
            }

            if ( isset($config->shared_session ))
            {
                switch ($config->shared_session)
                {
                    case true:
                        $instance['configSHASESS'] = 'true';
                        break;
                    case false:
                        $instance['configSHASESS'] = 'false';
                        break;
                    default:
                        $instance['configSHASESS'] = $config->shared_session;
                }
            }
            else
            {
                $instance['configSHASESS'] = _FPA_NA;
            }

            if ( isset($config->cache_platformprefix ))
            {
                switch ($config->cache_platformprefix)
                {
                    case true:
                        $instance['configCACHEPLFPFX'] = 'true';
                        break;
                    case false:
                        $instance['configCACHEPLFPFX'] = 'false';
                        break;
                    default:
                        $instance['configCACHEPLFPFX'] = $config->cache_platformprefix;
                }
            }
            else
            {
                $instance['configCACHEPLFPFX'] = _FPA_NA;
            }

            if ( isset($config->ftp_enable ))
            {
                switch ($config->ftp_enable)
                {
                    case true:
                        $instance['configFTP'] = 'true';
                        break;
                    case false:
                        $instance['configFTP'] = 'false';
                        break;
                    default:
                        $instance['configFTP'] = $config->ftp_enable;
                }
            }
            else
            {
                $instance['configFTP'] = _FPA_NA;
            }

            if ( isset($config->debug_lang ))
            {
                switch ($config->debug_lang)
                {
                    case true:
                        $instance['configLANGDEBUG'] = 'true';
                        break;
                    case false:
                        $instance['configLANGDEBUG'] = 'false';
                        break;
                    default:
                        $instance['configLANGDEBUG'] = $config->debug_lang;
                }
            }
            else
            {
                $instance['configLANGDEBUG'] = _FPA_NA;
            }

            if ( isset($config->sef_suffix ))
            {
                switch ($config->sef_suffix)
                {
                    case true:
                        $instance['configSEFSUFFIX'] = 'true';
                        break;
                    case false:
                        $instance['configSEFSUFFIX'] = 'false';
                        break;
                    default:
                        $instance['configSEFSUFFIX'] = $config->sef_suffix;
                }
            }
            else
            {
                $instance['configSEFSUFFIX'] = _FPA_NA;
            }

            if ( isset($config->sef_rewrite ))
            {
                switch ($config->sef_rewrite)
                {
                    case true:
                        $instance['configSEFRWRITE'] = 'true';
                        break;
                    case false:
                        $instance['configSEFRWRITE'] = 'false';
                        break;
                    default:
                        $instance['configSEFRWRITE'] = $config->sef_rewrite;
                }
            }
            else
            {
                $instance['configSEFRWRITE'] = _FPA_NA;
            }

            if ( isset($config->proxy_enable ))
            {
                switch ($config->proxy_enable)
                {
                    case true:
                        $instance['configPROXY'] = 'true';
                        break;
                    case false:
                        $instance['configPROXY'] = 'false';
                        break;
                    default:
                        $instance['configPROXY'] = $config->proxy_enable;
                }
            }
            else
            {
                $instance['configPROXY'] = _FPA_NA;
            }

            if ( isset($config->unicodeslugs ))
            {
                switch ($config->unicodeslugs)
                {
                    case true:
                        $instance['configUNICODE'] = 'true';
                        break;
                    case false:
                        $instance['configUNICODE'] = 'false';
                        break;
                    default:
                        $instance['configUNICODE'] = $config->unicodeslugs;
                }
            }
            else
            {
                $instance['configUNICODE'] = _FPA_NA;
            }

            if ( isset($config->force_ssl ))
            {
                $instance['configSSL'] = $config->force_ssl;
            }
            else
            {
                $instance['configSSL'] = _FPA_NA;
            }

            if ( isset($config->session_handler ))
            {
                $instance['configSESSHAND'] = $config->session_handler;
            }
            else
            {
                $instance['configSESSHAND'] = _FPA_NA;
            }

            if ( isset($config->lifetime ))
            {
                $instance['configLIFETIME'] = $config->lifetime;
            }
            else
            {
                $instance['configLIFETIME'] = _FPA_NA;
            }

            if ( isset($config->cachetime ))
            {
                $instance['configCACHETIME'] = $config->cachetime;
            }
            else
            {
                $instance['configCACHETIME'] = _FPA_NA;
            }

            if ( isset($config->live_site ))
            {
                $instance['configLIVESITE'] = $config->live_site;
            }
            else
            {
                $instance['configLIVESITE'] = _FPA_NA;
            }

            if ( isset($config->cache_handler ))
            {
                $instance['configCACHEHANDLER'] = $config->cache_handler;
            }
            else
            {
                $instance['configCACHEHANDLER'] = _FPA_NA;
            }

            if ( isset($config->access ))
            {
                $instance['configACCESS'] = $config->access;
            }
            else
            {
                $instance['configACCESS'] = _FPA_NA;
            }

        }

        if ($instance['configDBTYPE'] == 'mysql' and $instance['cmsMAJORVERSION'] == '4') {
            $instance['configDBTYPE'] = 'pdomysql';
        }

        // J!1.0 assumed 'mysql' with no variable, so we'll just add it
        if ($instance['configDBTYPE'] == _FPA_N and $instance['configVALIDFOR'] == '1.0') {
            $instance['configDBTYPE'] = 'mysql';
        }

        // look to see if we are using a remote or local MySQL server
        if ( strpos($instance['configDBHOST'] , 'localhost' ) === 0  OR strpos($instance['configDBHOST'] , '127.0.0.1' ) === 0 ) {
            $database['dbLOCAL'] = _FPA_Y;

        } else {
            $database['dbLOCAL'] = _FPA_N;
        }

        // check if all the DB credentials are complete
        if ( @$instance['configDBTYPE'] AND $instance['configDBHOST'] AND $instance['configDBNAME'] AND $instance['configDBPREF'] AND $instance['configDBUSER'] AND $instance['configDBPASS'] ) {
            $instance['configDBCREDOK'] = _FPA_Y;

        } else if ( @$instance['configDBTYPE'] AND $instance['configDBHOST'] AND $instance['configDBNAME'] AND $instance['configDBPREF'] AND $instance['configDBUSER'] AND $database['dbLOCAL'] = _FPA_Y ){
            $instance['configDBCREDOK'] = _FPA_PMISS;

        } else {
            $instance['configDBCREDOK'] = _FPA_N;
        }

        // looking for htaccess (Apache and some others) or web.config (IIS)
        if ( $system['sysSHORTWEB'] != 'MIC' ) {

            // htaccess files
            if ( file_exists( '.htaccess' ) ) {
                $instance['configSITEHTWC'] = _FPA_Y;

            } else {
                $instance['configSITEHTWC'] = _FPA_N;
            }

            if ( file_exists( 'administrator/.htaccess' ) ) {
                $instance['configADMINHTWC'] = _FPA_Y;

            } else {
                $instance['configADMINHTWC'] = _FPA_N;

            }

        } else {

            // web.config file
            if ( file_exists( 'web.config' ) ) {
                $instance['configSITEHTWC'] = _FPA_Y;
                $instance['configADMINHTWC'] = _FPA_NA;

            } else {
                $instance['configSITEHTWC'] = _FPA_N;
                $instance['configADMINHTWC'] = _FPA_NA;
            }
        }

    } else { // no configuration.php found

		$instance['instanceCONFIGURED'] = _FPA_N;
        $instance['configVALIDFOR'] = _FPA_U;

	}



    /**
     * DETERMINE SYSTEM ENVIRONMENT & SETTINGS
     *
     * here we try to determine the hosting enviroment and configuration
     * to try and avoid "white-screens" fpa tries to check for function availability before
     * using any function, but this does mean it has grown in size quite a bit and unfortunately
     * gets a little messy in places.
     *
     */

    // what server and os is the host?
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

    // !TESTME for WIN IIS7?
    // $system['sysSERVIP'] =  $_SERVER['LOCAL_ADDR'];

    if ( $system['sysSHORTOS'] != 'WIN' ) {

        $system['sysEXECUSER'] = @$_ENV['USER']; // user that executed this script

            if ( !@$_ENV['USER'] ) {
                $system['sysEXECUSER'] = $system['sysCURRUSER'];
            }

        $system['sysDOCROOT'] = $_SERVER['DOCUMENT_ROOT'];

    } else {
        $localpath = getenv( 'SCRIPT_NAME' );
        $absolutepath = str_replace( '\\', '/', realpath( basename( getenv( 'SCRIPT_NAME' ) ) ) );
        $system['sysDOCROOT'] = substr( $absolutepath, 0, strpos( $absolutepath, $localpath ) );
        $system['sysEXECUSER'] = $system['sysCURRUSER']; // Windows work-around for not using EXEC User (this limits the cpability of discovering SU Environments though)
    }

    // looking for the Apache "suExec" Utility
    if ( function_exists( 'exec' ) AND $system['sysSHORTOS'] != 'WIN' ) { // find the owner of the current process running this script
        $system['sysWEBOWNER'] = exec("whoami");

    } elseif ( function_exists( 'passthru' ) AND $system['sysSHORTOS'] != 'WIN' ) {
        $system['sysWEBOWNER'] = passthru("whoami");

    } else {
        $system['sysWEBOWNER'] = _FPA_NA;  // we'll have to give up if we can't 'exec' or 'passthru' something, this occurs with Windows and some more secure environments
    }

    // find the system temp directory
    if ( version_compare( PHP_VERSION, '5.2.1', '>=' ) ) {
        $system['sysSYSTMPDIR'] = sys_get_temp_dir();

        // is the system /tmp writable to this user?
        if ( is_writable( sys_get_temp_dir() ) ) {
            $system['sysTMPDIRWRITABLE'] = _FPA_Y;

        } else {
            $system['sysTMPDIRWRITABLE'] = _FPA_N;
        }

    } else {
        $system['sysSYSTMPDIR'] = _FPA_U;
        $system['sysTMPDIRWRITABLE'] = _FPA_U;
    }



    /**
     * DETERMINE PHP ENVIRONMENT & SETTINGS
     *
     * here we try to determine the php enviroment and configuration
     * to try and avoid "white-screens" fpa tries to check for function availability before
     * using any function, but this does mean it has grown in size quite a bit and unfortunately
     * gets a little messy in places.
     *
     */

    // general php related settings?
    if ( version_compare( PHP_VERSION, '5.0', '>=' ) ) {
        $phpenv['phpSUPPORTSMYSQLI'] = _FPA_Y;

    } elseif ( version_compare( PHP_VERSION, '4.4.9', '<=' ) ) {
        $phpenv['phpSUPPORTSMYSQLI'] = _FPA_N;

    } else {
        $phpenv['phpSUPPORTSMYSQLI'] = _FPA_U;
    }

    if ( version_compare( PHP_VERSION, '7.0', '>=' ) ) {
        $phpenv['phpSUPPORTSMYSQL'] = _FPA_N;

    } elseif ( version_compare( PHP_VERSION, '5.9.9', '<=' ) ) {
        $phpenv['phpSUPPORTSMYSQL'] = _FPA_Y;

    } else {
        $phpenv['phpSUPPORTSMYSQL'] = _FPA_U;
    }

    // find the current php.ini file
    if ( version_compare( PHP_VERSION, '5.2.4', '>=' ) ) {
        $phpenv['phpINIFILE']       = php_ini_loaded_file();

    } else {
        $phpenv['phpINIFILE']       = _FPA_U;
    }

    // find the other loaded php.ini file(s)
    if (version_compare(PHP_VERSION, '4.3.0', '>=')) {
        $phpenv['phpINIOTHER']      = php_ini_scanned_files();

    } else {
        $phpenv['phpINIOTHER'] = _FPA_U;
    }

    // determine the rest of the normal PHP settings
    $phpenv['phpREGGLOBAL']         = ini_get( 'register_globals' );
    $phpenv['phpMAGICQUOTES']       = ini_get( 'magic_quotes_gpc' );
    $phpenv['phpSAFEMODE']          = ini_get( 'safe_mode' );
    $phpenv['phpMAGICQUOTES']       = ini_get( 'magic_quotes_gpc' );
    $phpenv['phpSESSIONPATH']       = session_save_path();
    $phpenv['phpOPENBASE']          = ini_get( 'open_basedir' );

    // is the session_save_path writable?
    if (is_writable( session_save_path() ) ) {
            $phpenv['phpSESSIONPATHWRITABLE'] = _FPA_Y;

        } else {
            $phpenv['phpSESSIONPATHWRITABLE'] = _FPA_N;
        }


    // input and upload related settings
    $phpenv['phpUPLOADS']           = ini_get( 'file_uploads' );
    $phpenv['phpMAXUPSIZE']         = ini_get( 'upload_max_filesize' );
    $phpenv['phpMAXPOSTSIZE']       = ini_get( 'post_max_size' );
    $phpenv['phpMAXINPUTTIME']      = ini_get( 'max_input_time' );
    $phpenv['phpMAXEXECTIME']       = ini_get( 'max_execution_time' );
    $phpenv['phpMEMLIMIT']          = ini_get( 'memory_limit' );
    $phpenv['phpDISABLED']          = ini_get( 'disable_functions' );
    $phpenv['phpURLFOPEN']          = ini_get( 'allow_url_fopen' );

    // API and ownership related settings
    $phpenv['phpAPI']               = php_sapi_name();

    // looking for php to be installed as a CGI or CGI/Fast
    if (substr($phpenv['phpAPI'], 0, 3) == 'cgi') {
        $phpenv['phpCGI'] = _FPA_Y;

        // looking for the Apache "suExec" utility
        if ( ( $system['sysCURRUSER'] === $system['sysWEBOWNER'] ) AND ( substr($phpenv['phpAPI'], 0, 3) == 'cgi' ) ) {
            $phpenv['phpAPACHESUEXEC'] = _FPA_Y;
            $phpenv['phpOWNERPROB'] = _FPA_N;

        } else {
            $phpenv['phpAPACHESUEXEC'] = _FPA_N;
            $phpenv['phpOWNERPROB'] = _FPA_M;
        }

        // looking for the "phpsuExec" utility
        if ( ( $system['sysCURRUSER'] === $system['sysEXECUSER'] ) AND ( substr($phpenv['phpAPI'], 0, 3) == 'cgi' ) ) {
            $phpenv['phpPHPSUEXEC'] = _FPA_Y;
            $phpenv['phpOWNERPROB'] = _FPA_N;

        } else {
            $phpenv['phpPHPSUEXEC'] = _FPA_N;
            $phpenv['phpOWNERPROB'] = _FPA_M;
        }

    } else {
        $phpenv['phpCGI'] = _FPA_N;
        $phpenv['phpAPACHESUEXEC'] = _FPA_N;
        $phpenv['phpPHPSUEXEC'] = _FPA_N;
        $phpenv['phpOWNERPROB'] = _FPA_M;
    }



    /**
     * WARNING WILL ROBINSON! ****************************************************************
     * THIS IS A TEST FEATURE AND AS SUCH NOT GUARANTEED TO BE 100% ACCURATE
     * try and cater for custom "su" environments, like cluster, grid and cloud computing.
     * this would include weird ownership combinations that allow group access to non-owner files
     * (like GoDaddy and a couple of grid and cloud providers I know of)
     *
     * took out this part: AND ( $instance['configWRITABLE'] == _FPA_Y )  as Joomla sets config file
     * to 444 so is read only permissions. Also changed this section:
     * ( $system['sysCURRUSER'] != $instance['configOWNER']['name'] from != to ==
     * If config owner is same as current user then we are probably using a custom "su" enviroment
     * such as LiteSpeed uses - 4-8-12 - Phil
     *
     */

    if ( ( $instance['instanceCONFIGURED'] == _FPA_Y ) AND ( @$phpenv['phpAPI'] == 'litespeed' ) AND ( $system['sysCURRUSER'] == $instance['configOWNER']['name'] ) AND ( ( substr( $instance['configMODE'],0 ,1 ) < '6' ) OR ( substr( $instance['configMODE'],1 ,1 ) < '6' ) OR ( substr( $instance['configMODE'],2 ,1 ) <= '6' ) ) ) {
        /** changed from maybe to yes - 4-8-12 - Phil **/
        $phpenv['phpCUSTOMSU'] = _FPA_Y;
        $phpenv['phpOWNERPROB'] = _FPA_N;

    } elseif( ( $instance['instanceCONFIGURED'] == _FPA_Y ) AND ( $system['sysCURRUSER'] == $instance['configOWNER']['name'] ) AND ( ( substr( $instance['configMODE'],0 ,1 ) < '6' ) OR ( substr( $instance['configMODE'],1 ,1 ) < '6' ) OR ( substr( $instance['configMODE'],2 ,1 ) <= '6' ) ) ) {
        /** changed from maybe to yes - 4-8-12 - Phil **/
        $phpenv['phpCUSTOMSU'] = _FPA_Y;
        $phpenv['phpOWNERPROB'] = _FPA_N;

    } else {
        $phpenv['phpCUSTOMSU'] = _FPA_N;
        $phpenv['phpOWNERPROB'] = _FPA_M;
    }
    /*****************************************************************************************/
    /** THIS IS A TEST FEATURE AND AS SUCH NOT GUARANTEED TO BE 100% ACCURATE ****************/
    /*****************************************************************************************/


    // get all the PHP loaded extensions and versions
    foreach ( get_loaded_extensions() as $i => $ext ) {
        $phpextensions[$ext]    = phpversion($ext);
    }

    $phpextensions['Zend Engine'] = zend_version();



    /**
     * DETERMINE APACHE ENVIRONMENT & SETTINGS ***********************************************
     * here we try to determine the php enviroment and configuration
     * to try and avoid "white-screens" fpa tries to check for function availability before
     * using any function, but this does mean it has grown in size quite a bit and unfortunately
     * gets a little messy in places.
     */

    // general apache loaded modules?
    if ( function_exists( 'apache_get_version' ) ) {  // for Apache module interface

        foreach ( apache_get_modules() as $i => $modules ) {

            $apachemodules[$i] = ( $modules );  // show the version of loaded extensions

        }

        // include the Apache version
        $apachemodules[] = apache_get_version();

    } else {  // for Apache cgi interface

        // !TESTME Does this work in cgi or cgi-fcgi
        /**
        * BERNARD: commented out
        * @todo: find out if this is even used on the webpage
        */
        #print_r( get_extension_funcs( "cgi-fcgi" ) );
    }
    // !TODO see if there are IIS specific functions/modules



    /**
     * COMPLETE MODE (PERMISSIONS) CHECKS ON KNOWN FOLDERS
     *
     * test the mode and writability of known folders from the $folders array
     * to try and avoid "white-screens" fpa tries to check for function availability before
     * using any function, but this does mean it has grown in size quite a bit and unfortunately
     * gets a little messy in places.
     *
     */

    // build the mode-set details for each folder
    if ( $instance['instanceFOUND'] == _FPA_Y ) {

        foreach ( $folders as $i => $show ) {

            if ( $show != $folders['ARRNAME'] ) { // ignore the ARRNAME

                if ( file_exists( $show ) ) {
                    $modecheck[$show]['mode'] = substr( sprintf('%o', fileperms( $show ) ),-3, 3 );

                    if ( is_writable( $show ) ) {
                        $modecheck[$show]['writable'] = _FPA_Y;

                    } else {
                        $modecheck[$show]['writable'] = _FPA_N;
                    }


                    if ( function_exists( 'posix_getpwuid' ) AND $system['sysSHORTOS'] != 'WIN' ) {
                        $modecheck[$show]['owner'] = posix_getpwuid( fileowner( $show ) );
                        $modecheck[$show]['group'] = posix_getgrgid( filegroup( $show ) );

                    } else { // non-posix compatible hosts
                        $modecheck[$show]['owner']['name'] = fileowner( $show );
                        $modecheck[$show]['group']['name'] = filegroup( $show );
                    }

                } else {
                    $modecheck[$show]['mode'] = '---';
                    $modecheck[$show]['writable'] = '-';
                    $modecheck[$show]['owner']['name'] = '-';
                    $modecheck[$show]['group']['name'] = _FPA_DNE;
                }

            }

        }



        // !CLEANME this needs to be done a little smarter
        // here we take the folders array and unset folders that aren't relevant to a specific release
        function filter_folders( $folders, $instance ) {
            GLOBAL $folders;

            if ( $instance['cmsRELEASE'] != '1.0' ) {           // ignore the folders for J!1.0
                unset ( $folders[4] );

            } elseif ( $instance['cmsRELEASE'] == '1.0' ) {     // ignore folders for J1.5 and above
                unset ( $folders[3] );
                unset ( $folders[8] );
                unset ( $folders[9] );
                unset ( $folders[12] );
            }

            if ( $instance['platformPRODUCT'] != 'Nooku' ) {    // ignore the Nooku sites folder if not Nooku
                unset ( $folders[14] );
            }
        }

        // !FIXME need to fix warning in array_filter ( '@' work-around )
        // new filtered list of folders to check permissions on, based on the installed release
        @array_filter( $folders, filter_folders( $folders, $instance ) );

    }
    unset ( $key, $show );



    /**
     * getDirectory FUNCTION TO RECURSIVELY READ THROUGH LOOKING FOR PERMISSIONS
     *
     * this is used to read the directory structure and return a list of folders with 'elevated'
     * mode-sets ( -7- or --7 ) ignoring the first position as defaults folders are normally 755.
     * $dirCount is applied when the folder list is excessive to reduce unnecessary processing
     * on really sites with 00's or 000's of badly configured folder modes. Limited to displaying
     * the first 10 only.
     */
    if ( $showElevated == '1' ) {

        $dirCount = 0;

        function getDirectory( $path = '.', $level = 0 ) {
            global $elevated, $dirCount;

            // directories to ignore when listing output. Many hosts
            $ignore = array( '.', '..' );

            // open the directory to the handle $dh
            if ( !$dh = @opendir( $path ) ) {
                // Bernard: if a folder is NOT readable, without this check we get endless loop
                echo '<div class="alert" style="padding:25px;"><span class="alert-text" style="font-size:x-large;">'._FPA_DIR_UNREADABLE.': <b>'.$path.'</b></span></div>';
                return FALSE;
            }


            // loop through the directory
            while ( false !== ( $file = readdir( $dh ) ) ) {

                // check that this file is not to be ignored
                if ( !in_array( $file, $ignore ) ) {

                    if ( $dirCount < '10' ) { // 10 or more folder will cancel the processing

                        // its a directory, so we need to keep reading down...
                        if ( is_dir( "$path/$file" ) ) {

                            $dirName = $path .'/'. $file;
                            $dirMode = substr( sprintf( '%o', fileperms( $dirName ) ),-3, 3 );

                                // looking for --7 or -7- or -77 (default folder permissions are usually 755)
                                if ( substr( $dirMode,1 ,1 ) == '7' OR substr( $dirMode,2 ,1 ) == '7' ) {
                                    $elevated[''. str_replace( './','', $dirName ) .'']['mode'] = $dirMode;

                                    if ( is_writable( $dirName ) ) {
                                        $elevated[''. str_replace( './','', $dirName ) .'']['writable'] = _FPA_Y;

                                    } else {  // custom ownership or setUiD/GiD in-effect
                                        $elevated[''. str_replace( './','', $dirName ) .'']['writable'] = _FPA_N;
                                    }
                                    $dirCount++;
                                }

                                // re-call this same function but on a new directory.
                                getDirectory ( "$path/$file", ( $level +1 ) );

                        }

                    }

                }

            }
            // Close the directory handle
            closedir( $dh );
        }

        // Fixed Warning: Illegal string offset 'mode' on line 1476
        // Warning: Illegal string offset 'writable' on line 1477 - Phil 09-20-12
        if (isset( $dirCount) == '0' ) {
            $elevated['None'] = _FPA_NONE;
            $elevated['None']['mode'] = '-';
            $elevated['None']['writable'] = '-';
        }

        // now call the function to read from the selected folder ( '.' current location of FPA script )
        getDirectory( '.' );
        ksort( $elevated );

    } // end showElevated



    /**
     * DETERMINE THE DATABASE TYPE AND IF WE CAN CONNECT
     *
     */
    $dbPrefExist = _FPA_N;
    $dbPrefLen = @strlen($instance['configDBPREF']);
    $postgresql = _FPA_N;
    $confPrefTables = 0;
    $notconfPrefTables = 0;

    if ( $instance['instanceCONFIGURED'] == _FPA_Y AND ($instance['configDBCREDOK'] == _FPA_Y OR $instance['configDBCREDOK'] == _FPA_PMISS)) {
        $database['dbDOCHECKS'] = _FPA_Y;

        // try and connect to the database server and table-space, using the database_host variable in the configuration.php
        // for J!1.0, it's not in the config, so we have assumed mysql, as mysqli wasn't available during it's support life-time
        if ( $instance['configDBTYPE'] == 'mysql' ) {

            if (@function_exists('mysql_connect')) {
                $dBconn = @mysql_connect( $instance['configDBHOST'], $instance['configDBUSER'], $instance['configDBPASS'] );
                $database['dbERROR'] = mysql_errno() .':'. mysql_error();

                @mysql_select_db( $instance['configDBNAME'], $dBconn );
                $sql    = "select name,type,enabled from ".$instance['configDBPREF']."extensions where type='plugin' or type='component' or type='module' or type='template' or type='library'";
                $result = @mysql_query($sql);

                if ($result <> false) {
                    if (mysql_num_rows($result) > 0) {

                        for ($exset = array ();
                        $row = mysql_fetch_array($result);
                        $exset[] = $row);
                    }
                    $sql = "select template, max(home) as home from ".$instance['configDBPREF']."template_styles group by template";
                    $result = @mysql_query($sql);

                    if (mysql_num_rows($result) > 0) {

                        for ($tmpldef = array ();
                        $row = mysql_fetch_array($result);
                        $tmpldef[] = $row);
                    }
                }

            if ( $dBconn ) {
                @mysql_select_db( $instance['configDBNAME'], $dBconn );
                $database['dbERROR'] = @mysql_errno() .':'. @mysql_error();

                // if we can connect, try and collect some details
                $database['dbHOSTSERV']     = mysql_get_server_info( $dBconn );      // SQL server version
                $database['dbHOSTINFO']     = mysql_get_host_info( $dBconn );        // connection type to dB
                $database['dbHOSTPROTO']    = mysql_get_proto_info( $dBconn );       // server protocol type
                $database['dbHOSTCLIENT']   = mysql_get_client_info();               // client library version
                $database['dbHOSTDEFCHSET'] = mysql_client_encoding( $dBconn );      // this is the hosts default character-set
                $database['dbHOSTSTATS']    = explode("  ", mysql_stat( $dBconn ) ); // latest statistics


                // get the database grants/privilidges
                // added @RussW 5/05/2020
                $privResult = mysql_query( "SHOW GRANTS FOR CURRENT_USER" );

                while ( $row = @mysql_fetch_row( $privResult ) ) {
                    $database['dbPRIVS'] =  $row[0];
                }

                // find the database collation
                $coResult = mysql_query( "SHOW VARIABLES LIKE 'collation_database'" );

                while ( $row = mysql_fetch_row( $coResult ) ) {
                    $database['dbCOLLATION'] =  $row[1];
                }

                // find the database character-set
                $csResult = mysql_query( "SHOW VARIABLES LIKE 'character_set_database'" );

                while ( $row = mysql_fetch_array( $csResult ) ) {
                    $database['dbCHARSET'] =  $row[1];
                }

                // find all the dB tables and calculate the size
                mysql_select_db($instance['configDBNAME'], $dBconn);
                $tblResult = mysql_query("SHOW TABLE STATUS");

                $database['dbSIZE'] = 0;
                $rowCount = 0;

                while ( $row = mysql_fetch_array( $tblResult ) ) {
                    $rowCount++;

                    $tables[$row['Name']]['TABLE'] = $row['Name'];

                    // count tables with/without same prefix as in config
                    if(substr($row['Name'] , 0 , $dbPrefLen  ) === $instance['configDBPREF'] ) {
                        $confPrefTables = $confPrefTables + 1 ;

                    } else {
                        $notconfPrefTables = $notconfPrefTables + 1 ;
                    }

                    $table_size = ( $row[ 'Data_length' ] + $row[ 'Index_length' ] ) / 1024;
                    $tables[$row['Name']]['SIZE'] = sprintf( '%.2f', $table_size );
                    $database['dbSIZE'] += sprintf( '%.2f', $table_size );
                    $tables[$row['Name']]['SIZE'] = $tables[$row['Name']]['SIZE'] .' KiB';

                    if ( $showTables == '1' ) {
                        $tables[$row['Name']]['ENGINE']     = $row['Engine'];
                        $tables[$row['Name']]['VERSION']    = $row['Version'];
                        $tables[$row['Name']]['CREATED']    = $row['Create_time'];
                        $tables[$row['Name']]['UPDATED']    = $row['Update_time'];
                        $tables[$row['Name']]['CHECKED']    = $row['Check_time'];
                        $tables[$row['Name']]['COLLATION']  = $row['Collation'];
                        $tables[$row['Name']]['FRAGSIZE']   = sprintf( '%.2f', ( $row['Data_free'] /1024 ) ) .' KiB';
                        $tables[$row['Name']]['MAXGROW']    = sprintf( '%.1f', ( $row['Max_data_length'] /1073741824 ) ) .' GiB';
                        $tables[$row['Name']]['RECORDS']    = $row['Rows'];
                        $tables[$row['Name']]['AVGLEN']     = sprintf( '%.2f', ( $row['Avg_row_length'] /1024 ) ) .' KiB';

                    }
                }


                if ( $database['dbSIZE'] > '1024' ) {
                    $database['dbSIZE'] = sprintf('%.2f', ( $database['dbSIZE'] /1024 ) ) .' MiB';

                } else {
                    $database['dbSIZE'] = $database['dbSIZE'] .' KiB';
                }

                $database['dbTABLECOUNT'] = $rowCount;
                mysql_close( $dBconn );

            } else {
                $database['dbERROR'] = mysql_errno() .':'. mysql_error();
            } // end mysql if $dBconn is good

        } else {
            $database['dbHOSTSERV']     = _FPA_U; // SQL server version
            $database['dbHOSTINFO']     = _FPA_U; // connection type to dB
            $database['dbHOSTPROTO']    = _FPA_U; // server protocol type
            $database['dbHOSTCLIENT']   = _FPA_U; // client library version
            $database['dbHOSTDEFCHSET'] = _FPA_U; // this is the hosts default character-set
            $database['dbHOSTSTATS']    = _FPA_U; // latest statistics
            $database['dbCOLLATION']    = _FPA_U;
            $database['dbCHARSET']      = _FPA_U;
        }

    } elseif ( $instance['configDBTYPE'] == 'mysqli' AND $phpenv['phpSUPPORTSMYSQLI'] == _FPA_Y ) { // mysqli

        if (function_exists('mysqli_connect')) {
            $dBconn              = @new mysqli( $instance['configDBHOST'], $instance['configDBUSER'], $instance['configDBPASS'], $instance['configDBNAME'] );
            $database['dbERROR'] = mysqli_connect_errno( $dBconn ) .':'. mysqli_connect_error( $dBconn );
            $sql                 = "select name,type,enabled from ". $instance['configDBPREF']."extensions where type='plugin' or type='component' or type='module' or type='template' or type='library'";
            $result              = @$dBconn->query($sql);

            if ($result <> false) {

                if ($result->num_rows > 0) {
                    for ($exset = array ();
                    $row = $result->fetch_assoc();
                    $exset[] = $row);
                }

            }
            $sql = "select template, max(home) as home from ".$instance['configDBPREF']."template_styles group by template";
            $result = @$dBconn->query($sql);

            if ($result <> false) {

                if ($result->num_rows > 0) {
                    for ($tmpldef = array ();
                    $row = $result->fetch_assoc();
                    $tmpldef[] = $row);
                }

            }

            if ( $dBconn ) {
                $database['dbHOSTSERV']     = @mysqli_get_server_info( $dBconn );       // SQL server version
                $database['dbHOSTINFO']     = @mysqli_get_host_info( $dBconn );         // connection type to dB
                $database['dbHOSTPROTO']    = @mysqli_get_proto_info( $dBconn );        // server protocol type
                $database['dbHOSTCLIENT']   = @mysqli_get_client_info();                // client library version
                $database['dbHOSTDEFCHSET'] = @mysqli_character_set_name( $dBconn );       // this is the hosts default character-set
                $database['dbHOSTSTATS']    = explode("  ", @mysqli_stat( $dBconn ) );  // latest statistics

                // get the database grants/privilidges
                // added @RussW 5/05/2020
                $privResult = @$dBconn->query( "SHOW GRANTS FOR CURRENT_USER" );

                while ( $row = @mysqli_fetch_row( $privResult ) ) {
                    $database['dbPRIVS'] =  $row[0];
                }

                // find the database collation
                $coResult = @$dBconn->query( "SHOW VARIABLES LIKE 'collation_database'" );

                while ( $row = @mysqli_fetch_row( $coResult ) ) {
                    $database['dbCOLLATION'] =  $row[1];
                }

                // find the database character-set
                $csResult = @$dBconn->query( "SHOW VARIABLES LIKE 'character_set_database'" );

                while ( $row = @mysqli_fetch_array( $csResult ) ) {
                    $database['dbCHARSET']  =  $row[1];
                }

                // find all the dB tables and calculate the size
                $tblResult = @$dBconn->query( "SHOW TABLE STATUS" );

                $database['dbSIZE'] = 0;
                $rowCount           = 0;

                while ( $row = @mysqli_fetch_array( $tblResult ) ) {
                    $rowCount++;

                    $tables[$row['Name']]['TABLE']  = $row['Name'];

                    // count tables with/without same prefix as in config
                    if(substr($row['Name'] , 0 , $dbPrefLen  ) === $instance['configDBPREF'] ) {
                        $confPrefTables = $confPrefTables + 1 ;

                    } else {
                        $notconfPrefTables = $notconfPrefTables + 1 ;
                    }
                    $table_size = ($row[ 'Data_length' ] + $row[ 'Index_length' ]) / 1024;
                    $tables[$row['Name']]['SIZE'] = sprintf( '%.2f', $table_size );
                    $database['dbSIZE'] += sprintf( '%.2f', $table_size );
                    $tables[$row['Name']]['SIZE'] = $tables[$row['Name']]['SIZE'] .' KiB';


                    if ( $showTables == '1' ) {
                        $tables[$row['Name']]['ENGINE']     = $row['Engine'];
                        $tables[$row['Name']]['VERSION']    = $row['Version'];
                        $tables[$row['Name']]['CREATED']    = $row['Create_time'];
                        $tables[$row['Name']]['UPDATED']    = $row['Update_time'];
                        $tables[$row['Name']]['CHECKED']    = $row['Check_time'];
                        $tables[$row['Name']]['COLLATION']  = $row['Collation'];
                        $tables[$row['Name']]['FRAGSIZE']   = sprintf( '%.2f', ( $row['Data_free'] /1024 ) ) .' KiB';
                        $tables[$row['Name']]['MAXGROW']    = sprintf( '%.1f', ( $row['Max_data_length'] /1073741824 ) ) .' GiB';
                        $tables[$row['Name']]['RECORDS']    = $row['Rows'];
                        $tables[$row['Name']]['AVGLEN']     = sprintf( '%.2f', ( $row['Avg_row_length'] /1024 ) ) .' KiB';
                    }
                }


                if ( $database['dbSIZE'] > '1024' ) {
                    $database['dbSIZE']     = sprintf( '%.2f', ( $database['dbSIZE'] /1024 ) ) .' MiB';

                } else {
                    $database['dbSIZE']     = $database['dbSIZE'] .' KiB';
                }
                $database['dbTABLECOUNT']   = $rowCount;

            } else {
            // $database['dbERROR'] = mysqli_connect_errno( $dBconn ) .':'. mysqli_connect_error( $dBconn );
            } // end mysqli if $dBconn is good

        } else {
            $database['dbHOSTSERV']     = _FPA_U; // SQL server version
            $database['dbHOSTINFO']     = _FPA_U; // connection type to dB
            $database['dbHOSTPROTO']    = _FPA_U; // server protocol type
            $database['dbHOSTCLIENT']   = _FPA_U; // client library version
            $database['dbHOSTDEFCHSET'] = _FPA_U; // hosts default character-set
            $database['dbHOSTSTATS']    = _FPA_U; // latest statistics
            $database['dbCOLLATION']    = _FPA_U; // database collation
            $database['dbCHARSET']      = _FPA_U; // database character-set
            $database['dbERROR']        = _FPA_MYSQLI_CONN;
        } // end of dataBase connection routines


        } elseif ( $instance['configDBTYPE'] == 'pdomysql')  {

            try {
                $dBconn = new PDO("mysql:host=".$instance['configDBHOST'].";dbname=".$instance['configDBNAME'], $instance['configDBUSER'], $instance['configDBPASS']);

                // set the PDO error mode to exception
                $dBconn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            } catch(PDOException $e) {
                $dBconn = FALSE;
            }

            if ($dBconn) {
                $database['dbERROR'] = '0:';

                try {
                    $sql = $dBconn->prepare("select name,type,enabled from ". $instance['configDBPREF']."extensions where type='plugin' or type='component' or type='module' or type='template' or type='library'");
                    $sql->execute();
                    $exset = $sql->setFetchMode(PDO::FETCH_ASSOC);
                    $exset = $sql->fetchAll();

                    $sql = $dBconn->prepare("select template, max(home) as home from ".$instance['configDBPREF']."template_styles group by template");
                    $sql->execute();
                    $tmpldef = $sql->setFetchMode(PDO::FETCH_ASSOC);
                    $tmpldef = $sql->fetchAll();

                } catch(PDOException $e) {
                    //
                }

                if ( $dBconn ) {
                    $database['dbHOSTSERV']     = $dBconn->getAttribute(constant("PDO::ATTR_SERVER_VERSION" ));       // SQL server version
                    $database['dbHOSTINFO']     = $dBconn->getAttribute(constant("PDO::ATTR_CONNECTION_STATUS" ));         // connection type to dB
                    $database['dbHOSTCLIENT']   = $dBconn->getAttribute(constant("PDO::ATTR_CLIENT_VERSION" ));                // client library version
                    $database['dbHOSTDEFCHSET'] = $dBconn->query("SELECT CHARSET('')")->fetchColumn();      // this is the hosts default character-set
                    $database['dbHOSTSTATS']    = explode("  ", $dBconn->getAttribute(constant("PDO::ATTR_SERVER_INFO" )));  // latest statistics
                }

                // get the database grants/privilidges
                // added @RussW 5/05/2020
                $privResult = @$dBconn->query( "SHOW GRANTS FOR CURRENT_USER" );

                while ( $row = $privResult->fetch( PDO::FETCH_BOTH )) {
                    $database['dbPRIVS'] =  $row[0];
                }

                // find the database collation
                $coResult = $dBconn->query( "SHOW VARIABLES LIKE 'collation_database'" );

                while ( $row =  $coResult->fetch( PDO::FETCH_BOTH ))  {
                    $database['dbCOLLATION'] =  $row[1];
                }

                // find the database character-set
                $csResult = $dBconn->query( "SHOW VARIABLES LIKE 'character_set_database'" );

                while ( $row = $csResult->fetch( PDO::FETCH_BOTH )) {
                    $database['dbCHARSET']  =  $row[1];
                }

                // find all the dB tables and calculate the size
                $tblResult = $dBconn->query( "SHOW TABLE STATUS" );

                $database['dbSIZE'] = 0;
                $rowCount           = 0;

                while ( $row =  $tblResult->fetch( PDO::FETCH_BOTH )) {
                    $rowCount++;
                    $tables[$row['Name']]['TABLE']  = $row['Name'];

                    // count tables with/without same prefix as in config
                    if(substr($row['Name'] , 0 , $dbPrefLen  ) === $instance['configDBPREF'] ) {
                        $confPrefTables = $confPrefTables + 1 ;

                    } else {
                        $notconfPrefTables = $notconfPrefTables + 1 ;
                    }
                    $table_size = ($row[ 'Data_length' ] + $row[ 'Index_length' ]) / 1024;
                    $tables[$row['Name']]['SIZE'] = sprintf( '%.2f', $table_size );
                    $database['dbSIZE'] += sprintf( '%.2f', $table_size );
                    $tables[$row['Name']]['SIZE'] = $tables[$row['Name']]['SIZE'] .' KiB';


                    if ( $showTables == '1' ) {
                        $tables[$row['Name']]['ENGINE']     = $row['Engine'];
                        $tables[$row['Name']]['VERSION']    = $row['Version'];
                        $tables[$row['Name']]['CREATED']    = $row['Create_time'];
                        $tables[$row['Name']]['UPDATED']    = $row['Update_time'];
                        $tables[$row['Name']]['CHECKED']    = $row['Check_time'];
                        $tables[$row['Name']]['COLLATION']  = $row['Collation'];
                        $tables[$row['Name']]['FRAGSIZE']   = sprintf( '%.2f', ( $row['Data_free'] /1024 ) ) .' KiB';
                        $tables[$row['Name']]['MAXGROW']    = sprintf( '%.1f', ( $row['Max_data_length'] /1073741824 ) ) .' GiB';
                        $tables[$row['Name']]['RECORDS']    = $row['Rows'];
                        $tables[$row['Name']]['AVGLEN']     = sprintf( '%.2f', ( $row['Avg_row_length'] /1024 ) ) .' KiB';
                    }
                }

                if ( $database['dbSIZE'] > '1024' ) {
                    $database['dbSIZE']     = sprintf( '%.2f', ( $database['dbSIZE'] /1024 ) ) .' MiB';

                } else {
                    $database['dbSIZE']     = $database['dbSIZE'] .' KiB';
                }
                $database['dbTABLECOUNT']   = $rowCount;

            } else {
                $database['dbHOSTSERV']     = _FPA_U; // SQL server version
                $database['dbHOSTINFO']     = _FPA_U; // connection type to dB
                $database['dbHOSTPROTO']    = _FPA_U; // server protocol type
                $database['dbHOSTCLIENT']   = _FPA_U; // client library version
                $database['dbHOSTDEFCHSET'] = _FPA_U; // this is the hosts default character-set
                $database['dbHOSTSTATS']    = _FPA_U; // latest statistics
                $database['dbCOLLATION']    = _FPA_U;
                $database['dbCHARSET']      = _FPA_U;
                $database['dbERROR']        = _FPA_ECON;
            }

        } elseif ( $instance['configDBTYPE'] == 'postgresql')  {

            if (function_exists('pg_connect')) {
                $dBconn = @pg_connect("host=".$instance['configDBHOST']." dbname=".$instance['configDBNAME']." user=". $instance['configDBUSER']." password=". $instance['configDBPASS']);

                if ($dBconn) {
                    $database['dbERROR'] = '0:';
                    $postgresql = _FPA_Y;

                    $sql = @pg_query($dBconn, "select name,type,enabled from ". $instance['configDBPREF']."extensions where type='plugin' or type='component' or type='module' or type='template' or type='library'");
                    $exset = @pg_fetch_all($sql);

                    $sql = @pg_query($dBconn, "select template, max(home) as home from ".$instance['configDBPREF']."template_styles group by template");
                    $tmpldef = @pg_fetch_all($sql);

                    if ( $dBconn ) {
                        $database['dbHOSTSERV']     = pg_parameter_status($dBconn, "server_version");       // SQL server version
                        $database['dbHOSTINFO']     = _FPA_U;                                               // connection type to dB
                        $database['dbHOSTCLIENT']   = PGSQL_LIBPQ_VERSION_STR;                              // client library version
                        $database['dbHOSTDEFCHSET'] = pg_parameter_status($dBconn, "server_encoding");      // this is the hosts default character-set
                        $database['dbHOSTSTATS']    = _FPA_U;                                               // latest statistics
                        $database['dbCHARSET']      =  pg_parameter_status($dBconn, "client_encoding");
                        $sql = pg_fetch_array(pg_query($dBconn, "select encoding from pg_database"));
                        $res = $sql[0];
                        $val = pg_fetch_array(pg_query($dBconn, "select collname FROM pg_catalog.pg_collation where collencoding = ". $res));
                        $database['dbCOLLATION'] =  $val[0];
                    }
                    $tblResult = pg_query($dBconn," SELECT relname as name, pg_total_relation_size(relid) As size, pg_total_relation_size(relid) - pg_relation_size(relid) as externalsize FROM pg_catalog.pg_statio_user_tables WHERE relname LIKE '" . $instance['configDBPREF'] . "%' ORDER BY relname ASC");

                    // find all the dB tables
                    $database['dbSIZE'] = 0;
                    $rowCount           = 0;

                    while ( $row =  pg_fetch_array( $tblResult )) {
                        $rowCount++;
                        $tables[$row['name']]['TABLE']  = $row['name'];

                        // count tables with/without same prefix as in config
                        if(substr($row['name'] , 0 , $dbPrefLen  ) === $instance['configDBPREF'] ) {
                            $confPrefTables = $confPrefTables + 1 ;

                        } else {
                            $notconfPrefTables = $notconfPrefTables + 1 ;
                        }
                        $cr = pg_fetch_array(pg_query($dBconn," select count(*) from  " . $tables[$row['name']]['TABLE'] ."" )) ;
                        $table_size = ($row[ 'size' ] ) / 1024;
                        $tables[$row['name']]['SIZE'] = sprintf( '%.2f', $table_size );
                        $tables[$row['name']]['SIZE'] = $tables[$row['name']]['SIZE'] .' KiB';
                        $database['dbSIZE'] += sprintf( '%.2f', $table_size );

                        if ( $showTables == '1' ) {
                            $tables[$row['name']]['ENGINE']     = _FPA_U;
                            $tables[$row['name']]['VERSION']    = _FPA_U;
                            $tables[$row['name']]['CREATED']    = _FPA_U;
                            $tables[$row['name']]['UPDATED']    = _FPA_U;
                            $tables[$row['name']]['CHECKED']    = _FPA_U;
                            $tables[$row['name']]['COLLATION']  = $database['dbCHARSET'];
                            $tables[$row['name']]['FRAGSIZE']   = _FPA_U;
                            $tables[$row['name']]['MAXGROW']    = _FPA_U;
                            $tables[$row['name']]['RECORDS']    = $cr['count'];
                            $tables[$row['name']]['AVGLEN']     = _FPA_U;
                        }
                    }

                    if ( $database['dbSIZE'] > '1024' ) {
                        $database['dbSIZE']     = sprintf( '%.2f', ( $database['dbSIZE'] /1024 ) ) .' MiB';

                    } else {
                        $database['dbSIZE']     = $database['dbSIZE'] .' KiB';
                    }
                    $database['dbTABLECOUNT']   = $rowCount;

                } else {
                    $database['dbHOSTSERV']     = _FPA_U; // SQL server version
                    $database['dbHOSTINFO']     = _FPA_U; // connection type to dB
                    $database['dbHOSTPROTO']    = _FPA_U; // server protocol type
                    $database['dbHOSTCLIENT']   = _FPA_U; // client library version
                    $database['dbHOSTDEFCHSET'] = _FPA_U; // this is the hosts default character-set
                    $database['dbHOSTSTATS']    = _FPA_U; // latest statistics
                    $database['dbCOLLATION']    = _FPA_U;
                    $database['dbCHARSET']      = _FPA_U;
                    $database['dbERROR']        = _FPA_ECON;
                }

            } else {
                $database['dbHOSTSERV']     = _FPA_U; // SQL server version
                $database['dbHOSTINFO']     = _FPA_U; // connection type to dB
                $database['dbHOSTPROTO']    = _FPA_U; // server protocol type
                $database['dbHOSTCLIENT']   = _FPA_U; // client library version
                $database['dbHOSTDEFCHSET'] = _FPA_U; // this is the hosts default character-set
                $database['dbHOSTSTATS']    = _FPA_U; // latest statistics
                $database['dbCOLLATION']    = _FPA_U;
                $database['dbCHARSET']      = _FPA_U;
                $database['dbERROR']        = _FPA_DI_PHP_FU;
            }

        } elseif ( $instance['configDBTYPE'] == 'pgsql')  {

            try {
                $dBconn = new PDO("pgsql:host=".$instance['configDBHOST'].";dbname=".$instance['configDBNAME'], $instance['configDBUSER'], $instance['configDBPASS']);

                // set the PDO error mode to exception
                $dBconn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch(PDOException $e) {
                $dBconn = FALSE;
            }

            if ($dBconn) {
                $database['dbERROR'] = '0:';
                $postgresql = _FPA_Y;

                try {
                    $sql = $dBconn->prepare("select name,type,enabled from ". $instance['configDBPREF']."extensions where type='plugin' or type='component' or type='module' or type='template' or type='library'");
                    $sql->execute();
                    $exset = $sql->setFetchMode(PDO::FETCH_ASSOC);
                    $exset = $sql->fetchAll();

                    $sql = $dBconn->prepare("select template, max(home) as home from ".$instance['configDBPREF']."template_styles group by template");
                    $sql->execute();
                    $tmpldef = $sql->setFetchMode(PDO::FETCH_ASSOC);
                    $tmpldef = $sql->fetchAll();
                } catch(PDOException $e) {
                    //
                }

                if ( $dBconn ) {
                    $database['dbHOSTSERV']     = $dBconn->getAttribute(constant("PDO::ATTR_SERVER_VERSION" ));       // SQL server version
                    $database['dbHOSTINFO']     = $dBconn->getAttribute(constant("PDO::ATTR_CONNECTION_STATUS" ));         // connection type to dB
                    $database['dbHOSTCLIENT']   = $dBconn->getAttribute(constant("PDO::ATTR_CLIENT_VERSION" ));                // client library version
                    $database['dbHOSTSTATS']    = _FPA_U;
                }

                // find the database collation
                $coResult = $dBconn->query( "SELECT * FROM information_schema.character_sets");

                while ( $row =  $coResult->fetch( PDO::FETCH_BOTH ))  {
                    $database['dbCOLLATION'] =  $row['character_set_name'];
                    $database['dbCHARSET']  =  $row['character_set_name'];
                    $database['dbHOSTDEFCHSET'] =  $row['character_set_name'];
                }

                // find all the dB tables and calculate the size
                $tblResult = $dBconn->query( " SELECT relname as name, pg_total_relation_size(relid) As size, pg_total_relation_size(relid) - pg_relation_size(relid) as externalsize FROM pg_catalog.pg_statio_user_tables WHERE relname LIKE '". $instance['configDBPREF'] . "%' ORDER BY relname ASC");

                $database['dbSIZE'] = 0;
                $rowCount           = 0;

                while ( $row =  $tblResult->fetch( PDO::FETCH_BOTH )) {
                    $rowCount++;
                    $tables[$row['name']]['TABLE']  = $row['name'];

                    // count tables with/without same prefix as in config
                    if(substr($row['name'] , 0 , $dbPrefLen  ) === $instance['configDBPREF'] ) {
                        $confPrefTables = $confPrefTables + 1 ;
                    } else {
                        $notconfPrefTables = $notconfPrefTables + 1 ;
                    }

                    $crsql                        = $dBconn->query( " select count(*) from  " . $tables[$row['name']]['TABLE'] ."" );
                    $cr                           = $crsql->fetch( PDO::FETCH_BOTH );
                    $table_size                   = ($row[ 'size' ] ) / 1024;
                    $tables[$row['name']]['SIZE'] = sprintf( '%.2f', $table_size );
                    $tables[$row['name']]['SIZE'] = $tables[$row['name']]['SIZE'] .' KiB';
                    $database['dbSIZE'] += sprintf( '%.2f', $table_size );

                    if ( $showTables == '1' ) {
                        $tables[$row['name']]['ENGINE']     = _FPA_U;
                        $tables[$row['name']]['VERSION']    = _FPA_U;
                        $tables[$row['name']]['CREATED']    = _FPA_U;
                        $tables[$row['name']]['UPDATED']    = _FPA_U;
                        $tables[$row['name']]['CHECKED']    = _FPA_U;
                        $tables[$row['name']]['COLLATION']  = $database['dbCOLLATION'];
                        $tables[$row['name']]['FRAGSIZE']   = _FPA_U;
                        $tables[$row['name']]['MAXGROW']    = _FPA_U;
                        $tables[$row['name']]['RECORDS']    = $cr['count'];
                        $tables[$row['name']]['AVGLEN']     = _FPA_U;
                    }
                }

                if ( $database['dbSIZE'] > '1024' ) {
                    $database['dbSIZE']     = sprintf( '%.2f', ( $database['dbSIZE'] /1024 ) ) .' MiB';

                } else {
                    $database['dbSIZE']     = $database['dbSIZE'] .' KiB';
                }
                $database['dbTABLECOUNT']   = $rowCount;

            } else {
                $database['dbHOSTSERV']     = _FPA_U; // SQL server version
                $database['dbHOSTINFO']     = _FPA_U; // connection type to dB
                $database['dbHOSTPROTO']    = _FPA_U; // server protocol type
                $database['dbHOSTCLIENT']   = _FPA_U; // client library version
                $database['dbHOSTDEFCHSET'] = _FPA_U; // this is the hosts default character-set
                $database['dbHOSTSTATS']    = _FPA_U; // latest statistics
                $database['dbCOLLATION']    = _FPA_U;
                $database['dbCHARSET']      = _FPA_U;
                $database['dbERROR']        = _FPA_ECON;
            }


        } elseif ( $instance['configDBTYPE'] == 'sqlsrv')  {
            $database['dbHOSTSERV']     = _FPA_U; // SQL server version
            $database['dbHOSTINFO']     = _FPA_U; // connection type to dB
            $database['dbHOSTPROTO']    = _FPA_U; // server protocol type
            $database['dbHOSTCLIENT']   = _FPA_U; // client library version
            $database['dbHOSTDEFCHSET'] = _FPA_U; // this is the hosts default character-set
            $database['dbHOSTSTATS']    = _FPA_U; // latest statistics
            $database['dbCOLLATION']    = _FPA_U;
            $database['dbCHARSET']      = _FPA_U;
        } else {
            $database['dbHOSTSERV']     = _FPA_U; // SQL server version
            $database['dbHOSTINFO']     = _FPA_U; // connection type to dB
            $database['dbHOSTPROTO']    = _FPA_U; // server protocol type
            $database['dbHOSTCLIENT']   = _FPA_U; // client library version
            $database['dbHOSTDEFCHSET'] = _FPA_U; // this is the hosts default character-set
            $database['dbHOSTSTATS']    = _FPA_U; // latest statistics
            $database['dbCOLLATION']    = _FPA_U;
            $database['dbCHARSET']      = _FPA_U;
        }

        if ( isset( $dBconn ) AND $database['dbERROR'] == '0:' ) {
            $database['dbERROR'] = _FPA_N;

        } elseif ( $database['dbLOCAL'] == _FPA_N AND substr($database['dbERROR'], 0, 4) == '2005' ) { // 2005 = can't access host
            // if this is a remote host, it might be firewalled or disabled from external or non-internal network access
            $database['dbERROR']    = $database['dbERROR'] .' ( '. _FPA_DBCONNNOTE .' )';
        }


    } else { // if no configuration or if configured but dBase credentials aren't valid
        $database['dbDOCHECKS']     = _FPA_N;
        $database['dbLOCAL']        = _FPA_U;
    }

    if (!@$dBconn AND @$instance['configDBCREDOK'] == _FPA_PMISS ) {
        $instance['configDBCREDOK'] = _FPA_N;
        $database['dbDOCHECKS']     = _FPA_N;
    }



    /**
     * FIND AND ESTABLISH INSTALLED EXTENSIONS
     *
     * this function recurively looks for installed Components, Modules, Plugins and Templates
     * it only reads the .xml file to determine installation status and info, some extensions
     * do not have an associated .xml file and wont be displayed (normally core extensions)
     *
     * modified version of the function for the recirsive folder permisisons previously
     */
    if ( $instance['instanceFOUND'] == _FPA_Y ) { // fix for IIS *shrug*

        // this is a little funky and passes the extension array name bt variable reference
        // (&$arrname refers to each seperate array, which is called at the end) this was
        // depreciated at 5.3 and I couldn't find an alternative, so the fix to a PHP Warning
        // is to simply re-assign the $arrname back to itself inside the function, so it is
        // no-longer a reference
        function getDetails( $path, &$arrname, $loc, $level = 0 ) {
            global $component, $module, $plugin, $template, $library;

            // fix for PHP5.3 pass-variable-by-reference depreciation
            $arrname = $arrname;
            // Directories & files to ignore when listing output.
            $ignore = array( '.', '..', 'index.htm', 'index.html', '.DS_Store', 'none.xml', 'metadata.xml', 'default.xml', 'form.xml', 'contact.xml', 'edit.xml', 'blog.xml' );

            // open the directory to the handle $dh
            $dh = @opendir( $path );

            // loop through the directory
            while ( false !== ( $file = @readdir( $dh ) ) ) {

                // check that this file is not to be ignored
                if( !in_array( $file, $ignore ) ) {

                    // its a directory, so we need to keep reading down...
                    if( is_dir( "$path/$file" ) ) {

                        getDetails( "$path/$file", $arrname, $loc, ( $level +1 ) );
                        // Re-call this same function but on a new directory.
                        // this is what makes function recursive.

                    } else {

                        if ( $path == 'components' ) {
                            $cDir = substr( strrchr( $path .'/'. $file, '/' ), 1 );

                        } else {
                            $cDir = $path .'/'. $file;
                        }

                        if ( preg_match( "/\.xml/i", $file ) ) { // if filename matches .xml in the name

                            $content = file_get_contents( $cDir );

                            if ( preg_match( '#<(extension|install|mosinstall)#', $content, $isValidFile ) ) {
                                // $arrname[$loc][$cDir] = '';

                                $arrname[$loc][$cDir]['author']         = '-';
                                $arrname[$loc][$cDir]['authorUrl']      = '-';
                                $arrname[$loc][$cDir]['version']        = '-';
                                $arrname[$loc][$cDir]['creationDate']   = '-';
                                $arrname[$loc][$cDir]['type']           = '-';


                                if ( preg_match( '#<name>(.*)</name>#', $content, $name ) ) {
                                    $arrname[$loc][$cDir]['name']   = strip_tags( substr( $name[1], 0, 35 ) );

                                } else {
                                    $arrname[$loc][$cDir]['name']   = _FPA_U .' ('. $cDir . ') ';
                                }


                                if ( preg_match( '#<author>(.*)</author>#', $content, $author ) ) {
                                    $arrname[$loc][$cDir]['author'] = strip_tags( substr( $author[1], 0, 25 ) );

                                    if ( $author[1] == 'Joomla! Project'
                                    OR strtolower( $name[1] ) == 'joomla admin'
                                    OR strtolower( $name[1] ) == 'rhuk_milkyway'
                                    OR strtolower( $name[1] ) == 'ja_purity'
                                    OR strtolower( $name[1] ) == 'khepri'
                                    OR strtolower( $name[1] ) == 'bluestork'
                                    OR strtolower( $name[1] ) == 'atomic'
                                    OR strtolower( $name[1] ) == 'hathor'
                                    OR strtolower( $name[1] ) == 'protostar'
                                    OR strtolower( $name[1] ) == 'isis'
                                    OR strtolower( $name[1] ) == 'beez5'
                                    OR strtolower( $name[1] ) == 'beez_20'
                                    OR strtolower( $name[1] ) == 'cassiopeia'
                                    OR strtolower( $name[1] ) == 'atum'
                                    OR strtolower( substr( $name[1], 0, 4 ) ) == 'beez' ) {
                                        $arrname[$loc][$cDir]['type'] = _FPA_JCORE;

                                    } else {
                                        $arrname[$loc][$cDir]['type'] = _FPA_3PD;
                                    }

                                } else {
                                    $arrname[$loc][$cDir]['author']     = '-';
                                    $arrname[$loc][$cDir]['type']       = '-';
                                }

                                if ( preg_match( '#<version>(.*)</version>#', $content, $version ) ) {
                                    $arrname[$loc][$cDir]['version'] = substr( $version[1], 0, 13 );

                                } else {
                                    $arrname[$loc][$path .'/'. $file]['version'] = '-';
                                }

                                if ( preg_match( '#<creationDate>(.*)</creationDate>#', $content, $creationDate ) ) {
                                    $arrname[$loc][$cDir]['creationDate'] = $creationDate[1];

                                } else {
                                    $arrname[$loc][$cDir]['creationDate'] = '-';
                                }

                                if ( preg_match( '#<authorUrl>(.*)</authorUrl>#', $content, $authorUrl ) ) {
                                    $arrname[$loc][$cDir]['authorUrl'] = str_replace( array( 'http://', 'https://' ), '', $authorUrl[1] );

                                } else {
                                    $arrname[$loc][$cDir]['authorUrl'] = '-';
                                }

                            } //isValidFile

                        }

                    }
                }

            } // while

            @closedir( $dh );
        }


        // use the same function (above) to search for each extension type and load the results into it's associated array
        @getDetails( 'components', $component, 'SITE' );
        @getDetails( 'administrator/components', $component, 'ADMIN' );

        @getDetails( 'modules', $module, 'SITE' );
        @getDetails( 'administrator/modules', $module, 'ADMIN' );

        // cater for Joomla! 1.0 differences
        if ( @$instance['cmsRELEASE'] == '1.0' ) {
            @getDetails( 'mambots', $plugin, 'SITE' );
        } else {
            @getDetails( 'plugins', $plugin, 'SITE' );
        }

        @getDetails( 'templates', $template, 'SITE' );
        @getDetails( 'administrator/templates', $template, 'ADMIN' );
        @getDetails( 'libraries', $library, 'SITE' );

    } // end if instanceFOUND



    /**
     * LiveCheck - FPA
     * comment out _LIVE_CHECK_FPA in settings to disable
     *
     * checks this FPA version against the latest release on Github using cURL
     * - don't run if cURL disabled or not available
     * - don't run if doIT = 1
     * added - @RussW 28/05/2020
     * updated CURLOPT_SSL_VERIFYPEER added @RussW 3/06/2020
     *
     */
    if ( defined( '_LIVE_CHECK_FPA' ) AND $canDOLIVE == '1') {

        function doFPALIVE() {

            $gitcURL     = 'https://api.github.com/repos/ForumPostAssistant/FPA/releases/latest';  // fpa github json latest release URL
            $ch          = curl_init( $gitcURL );  // init cURL
            $gitcURLOPT  = array ( CURLOPT_USERAGENT => $_SERVER['HTTP_USER_AGENT'],
                                   CURLOPT_TIMEOUT => 5,
                                   CURLOPT_CONNECTTIMEOUT => 5,
                                   CURLOPT_RETURNTRANSFER => true,
                                   CURLOPT_SSL_VERIFYPEER => false,
                                   CURLOPT_HTTPHEADER => array('Content-type: application/json'),
                                  );
            curl_setopt_array( $ch, $gitcURLOPT );

            $gitcURLJSON  = curl_exec($ch); // get json result string

            if ($gitcURLJSON ===  FALSE) {
                $fpaVersionCheck = '';

            } else {
                $gitcURLARRAY   = json_decode($gitcURLJSON);  // decode json in to an array
                $thisFPAVER     = substr(_RES_VERSION, 0, 8);


                if (substr($gitcURLARRAY->tag_name, 0, 1) == 'v') {
                    $latestFPAVER   = ltrim($gitcURLARRAY->tag_name, 'v');  // trim the "v" (version) from the latest release tag

                } else {
                    $latestFPAVER   = $gitcURLARRAY->tag_name;
                }

                if (version_compare($thisFPAVER, $latestFPAVER) < 0) {
                    $fpaVersionCheckStatus   = 'warning';
                    $fpaVersionCheckIcon     = 'exclamation';
                    $fpaVersionCheckMessage  = _VER_CHECK_ATOLD.' ('. $thisFPAVER.')';
                    $fpaVersionCheckDownload = $gitcURLARRAY->html_url;

                } elseif (version_compare($thisFPAVER, $latestFPAVER) > 0) {
                    $fpaVersionCheckStatus   = 'info';
                    $fpaVersionCheckIcon     = 'question';
                    $fpaVersionCheckMessage  = _VER_CHECK_ATDEV.' ('. $thisFPAVER.')';
                    $fpaVersionCheckDownload = '';

                } else {
                    $fpaVersionCheckStatus   = 'success';
                    $fpaVersionCheckIcon     = 'check';
                    $fpaVersionCheckMessage  = _VER_CHECK_ATCUR.' ('. $thisFPAVER.')';
                    $fpaVersionCheckDownload = '';
                }

            }

            echo '<div class="w-100 p-2 bg-white small border border-'. $fpaVersionCheckStatus .' text-'. $fpaVersionCheckStatus .'">';
            echo '<i class="fas fa-'. $fpaVersionCheckIcon .'-circle fa-fw"></i>&nbsp;';
            echo 'FPA '.@$fpaVersionCheckMessage;

            if ( !empty($fpaVersionCheckDownload) ) {
                echo '<a class="mt-1 py-1 badge badge-'. $fpaVersionCheckStatus .' d-block w-75 mx-auto" href="'. $fpaVersionCheckDownload .'" rel="noreferrer noopener" target="_blank">Download Latest FPA (v'.$latestFPAVER.')</a>';
            }
            echo '</div>';

        } // function

    } // end FPA LiveCheck

    /**
     * LiveCheck - Joomla!
     * comment out _LIVE_CHECK_JOOMLA in settings to disable
     *
     * checks found instance version against the latest release on update.joomla.org using cURL
     * - don't run if cURL disabled or not available
     * - don't run if simpleXML or XML not available
     * - don't run if Joomla! instance not found
     * added - @RussW 28/05/2020
     *
     */
    if ( defined( '_LIVE_CHECK_JOOMLA') AND $canDOLIVE == '1' AND $instance['instanceFOUND'] == _FPA_Y ) {

        if ( extension_loaded('simplexml') AND ini_get( 'allow_url_fopen' ) == '1' ) {

            function doJOOMLALIVE($thisJVER) {

                $jupdateURL  = 'https://update.joomla.org/core/list.xml';
                $jupdateXML  = simpleXML_load_file( $jupdateURL, 'SimpleXMLElement', LIBXML_NOCDATA );

                if ($jupdateXML ===  FALSE) {
                    $joomlaVersionCheck = '';

                } else {
                    $latestJATTR  = $jupdateXML->extension[count($jupdateXML->extension) -1];
                    $latestJVER   = $latestJATTR->attributes()->version->__toString();
                    //$thisJVER     = '3.9.18';

                    if (version_compare($thisJVER, $latestJVER) < 0) {
                        $joomlaVersionCheckStatus   = 'warning';
                        $joomlaVersionCheckIcon     = 'exclamation';
                        $joomlaVersionCheckMessage  = _VER_CHECK_ATOLD.' ('. $thisJVER.')';
                        $joomlaVersionCheckDownload = 'https://downloads.joomla.org/';

                    } elseif (version_compare($thisJVER, $latestJVER) > 0) {
                        $joomlaVersionCheckStatus   = 'info';
                        $joomlaVersionCheckIcon     = 'question';
                        $joomlaVersionCheckMessage  = _VER_CHECK_ATDEV.' ('. $thisJVER.')';
                        $joomlaVersionCheckDownload = '';

                    } else {
                        $joomlaVersionCheckStatus   = 'success';
                        $joomlaVersionCheckIcon     = 'check';
                        $joomlaVersionCheckMessage  = _VER_CHECK_ATCUR.' ('. $thisJVER.')';
                        $joomlaVersionCheckDownload = '';
                    }

                    echo '<div class="w-100 p-2 bg-white small border border-'. $joomlaVersionCheckStatus .' text-'. $joomlaVersionCheckStatus .'">';
                    echo '<i class="fas fa-'. $joomlaVersionCheckIcon .'-circle fa-fw"></i>&nbsp;';
                    echo 'Joomla! '.$joomlaVersionCheckMessage;

                    if ( !empty($joomlaVersionCheckDownload) ) {
                        echo '<a class="mt-1 py-1 badge badge-'. $joomlaVersionCheckStatus .' d-block w-75 mx-auto d-print-none" data-html2canvas-ignore="true" href="'. $joomlaVersionCheckDownload .'" rel="noreferrer noopener" target="_blank">Download Latest Joomla! (v'.$latestJVER.')</a>';
                    }
                    echo '</div>';

                }

            } // function

        } // if simpleXML

    } // end Joomla! LiveCheck

    /**
     * LiveCheck - VEL
     * comment out _LIVE_CHECK_VEL in settings to disable
     *
     * checks if instance found and if extensions (versions) are found on  vel.joomla.org using cURL
     * - don't run if cURL disabled or not available
     * - don't run if simpleXML or XML not available
     * - don't run if Joomla! instance not found
     * - don't run if $doIT = 1 (running FPA)
     *
     * should always be below audit/test routines as it will disable the following options
     * - disable $showElevated, $showTables, $showCoreEx
     * added - @RussW 29/05/2020
     *
     */
    if ( defined( '_LIVE_CHECK_VEL') AND $canDOLIVE == '1' AND $instance['instanceFOUND'] == _FPA_Y AND @$_POST['doVEL'] == 1 ) {

        // disable FPA options to reduce run-time, clutter and load
        $showElevated  = 0;
        $showTables    = 0;
        $showCoreEx    = 0;

        echo 'DID VEL';

    } // end VEL LiveCheck



    function recursive_array_search($needle,$haystack) {
        foreach ($haystack as $key=>$value) {
            $current_key=$key;

            if($needle===$value OR (is_array($value) && recursive_array_search($needle,$value) !== false)) {
                return $current_key;
            }

        }
        return false;
    }

?>
<!doctype html>
<html lang="en-gb" dir="ltr" vocab="http://schema.org/">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="robots" content="noindex, nofollow, noodp, nocache, noarchive" />

		<title><?php echo _RES .' : v'. _RES_VERSION .' - '. _RES_LANG; ?></title>

		<link rel="shortcut icon" href="./templates/protostar/favicon.ico" />

        <?php if (@$_POST['doPDF'] == '1' OR @$_POST['doVEL'] == '1') { ?>
            <!--load pace progress bar if this take a while to run-->
            <script src="https://cdnjs.cloudflare.com/ajax/libs/pace/1.0.2/pace.min.js" integrity="sha256-EPrkNjGEmCWyazb3A/Epj+W7Qm2pB9vnfXw+X6LImPM=" crossorigin="anonymous"></script>
            <?php if ( @$_POST['darkmode'] == 1 OR $_SESSION['darkmode'] == 1 ) { ?>
                <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/pace/1.0.2/themes/orange/pace-theme-flash.min.css" integrity="sha256-RGBBrgymw4elQrpU8GjEkOCxf5vE5ZvpAGnhNpDONPk=" crossorigin="anonymous" />
            <?php } else { ?>
                <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/pace/1.0.2/themes/blue/pace-theme-flash.min.css" integrity="sha256-t/Bn1Mo8tYq5d8SoQoJF07C5qOrQ5B0iNPQiCmstoCo=" crossorigin="anonymous" />
            <?php } ?>
        <?php } // load pace for selected actions ?>

        <!-- bootswatch yeti theme - bootstrap core css -->
        <?php if ( @$_POST['darkmode'] == 1 OR $_SESSION['darkmode'] == 1 ) { ?>
           <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootswatch/4.5.0/cyborg/bootstrap.min.css" integrity="sha256-04BHXjNfsJ2qy+AStQeom2QIJYU8+6AMCfcO60W0qc8=" crossorigin="anonymous" />
        <?php } else { ?>
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootswatch/4.5.0/yeti/bootstrap.min.css" integrity="sha256-99KgWr1SjvkqT7dcWV+Cj9yfsKF2j4wrVRgHJYAiEtU=" crossorigin="anonymous" />
        <?php } // darkmode ?>

        <!-- fontawesome icon css -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" integrity="sha256-h20CPZ0QyXlBuAw7A+KluUYx/3pK+c7lYEpqLTlxjYQ=" crossorigin="anonymous" />

        <!-- custom BS4 styling @RussW 23/05/2020 -->
        <style>
            html { position: relative; min-height: 100%; }
            body { font-size: 0.98rem; color: #868ba1 !important; line-height: 1.3 !important; margin-top: 68px; scroll-behavior: smooth; }
            .small { letter-spacing: -0.25px; line-height: 1.1; font-size: 0.9rem; }
            .xsmall { letter-spacing: -0.25px; line-height: 1.1; font-size: 0.7rem; }
            small { letter-spacing: -0.25px; line-height: 1.2 !important; }
            .protected { background: #f0f0f5; color: #b80000; text-transform: uppercase; padding: 0 5px; border-left: 1px solid #b80000; border-right: 1px solid #b80000; font-size: 10px; line-height: 1.1; display: inline-block; }
            p, .btn { font-weight: 400 !important; }
            /* add dark blue to match other FPA pages */
            .bg-fpa-dark { background-color: #224872 !important; }
            .border-fpa-dark { border-color: #224872 !important; }
            .text-fpa-dark { color: #224872; }
            .pdf-break-before { page-break-before : always; }
            .pdf-break-after { page-break-after : always; }
            .pace .pace-progress { height: 8px !important; }

        <?php if ( @$darkmode != 1 ) { ?>
            /* override default BS Yeti theme to match other FPA pages */
            h1 { color: #000; font-weight: 400; }
            h1.h2, h2, h3, h4, h5, h6 { color: #343a40; font-weight: 400; }
            .bg-info, .badge-info, .btn-info { background-color: #17a2b8 !important; }
            .border-info, .btn-info { border-color: #17a2b8 !important; }
            .btn-info:hover { color: #fff !important;background-color: #138496 !important;border-color: #117a8b !important; }
            .btn-outline-info {color: #17a2b8 !important;border-color: #17a2b8 !important; }
            .btn-outline-info:hover { color: #fff !important;background-color: #17a2b8 !important;border-color: #17a2b8 !important; }
            .text-info { color: #17a2b8 !important; }
            .alert-info {color: #0c5460 !important;background-color: #d1ecf1 !important;border-color: #bee5eb !important; }
            .bg-light { background-color: rgba(0,0,0,0.03) !important; }

        <?php } else { // is darkmode ?>
            body, #confidenceHelp td, .form-control { color: #b0b0b0 !important; }
            h1, .h1 { font-size: 2.34375rem; font-weight: 400; }
            h2, .h2 { font-size: 1.875rem; font-weight: 400; }
            h1.h2, h2, h3, h4, h5, h6 { font-weight: 400; }
            .border { border-color: #97999c !important; }
            .text-muted { color: #888 !important; }
            .btn { padding: 0.375rem 0.5rem; }
            .btn, .btn-sm, .btn-lg, .card, .badge { border-radius: 0px !important; }
            .form-control, .form-control-sm { border-radius: 0px; }
            #confidenceHelp td { font-size: 0.85rem; }
            .bg-fpa-dark { background-color: #282828 !important; }
            .bg-white { background-color: #424242 !important; }
        <?php } // end style mode ?>

            /* increase default container widths to better suit dashboard type page */
            @media (min-width: 576px) { .container { max-width: 540px; } }
            @media (min-width: 768px) { .container { max-width: 720px; } }
            @media (min-width: 992px) { .container { max-width: 960px; } }
            @media (min-width: 1200px) { .container { max-width: 1160px; } }
            @media (min-width: 1440px) { .container { max-width: 1240px; } }
            @media print {
                .pdf-break-before { page-break-before : auto; }
                .pdf-break-after { page-break-after : auto; }
                .print-break-before { page-break-before : always; }
                .print-break-after { page-break-after : always; }
                .card-header, table th { color: #000 !important; }
                footer { border-top: 1px solid #000; }
            }
        </style>

        <script>
            /**
             * toggle show/hide FPA options panel/form
             * is overriden when doIT = 1 to hide panel/form and only show post output
             * @RussW 23/05/2020
             *
             */
            function toggleFPA(showHideDiv, switchTextDiv) {
                var ele = document.getElementById(showHideDiv);
                var text = document.getElementById(switchTextDiv);
                if ( ele.style.display == 'block' ) {
                    ele.style.display = 'none';
                    text.innerHTML    = '<i class="fas fa-chevron-circle-right"></i> Open the FPA Options';
                } else {
                    ele.style.display = 'block';
                    text.innerHTML    = '<i class="fas fa-chevron-circle-down"></i> Close the FPA Options';
                }
            }
        </script>

    </head>
    <body data-spy="scroll" data-target=".navbar" data-offset="68" id="fpa-body">

        <header>

            <!--assistive tech/screenreader accesskey polite notice-->
            <span class="sr-only d-print-none" data-html2canvas-ignore="true" role="alert" aria-live="polite" aria-atomic="false">
                The following keyboard access keys are enabled, <em>d</em> to delete FPA, <em>g</em> to generate post content,  <em>o</em> to to access the FPA options, <em>n</em> to run in night mode, <em>l</em> to run in light mode, <em>v</em> to run a vulnerable extensions check and <em>f</em> to re-run the default FPA report.
            </span>

            <?php
                // adjust navbar classes depending on nightmode
                if (@$darkmode == '1') {
                    $navbarClass = 'navbar-dark bg-fpa-dark';
                    $navbarBrandClass = 'white';
                } else {
                    $navbarClass = 'navbar-light bg-white';
                    $navbarBrandClass = 'primary';
                }
            ?>
            <nav class="navbar navbar-expand-lg <?php echo $navbarClass; ?> fixed-top shadow d-print-none" data-html2canvas-ignore="true">

                <a class="navbar-brand mr-0 mr-md-2 text-<?php echo $navbarBrandClass; ?> py-2 lead font-weight-bolder" href="<?php echo _FPA_SELF; ?>" aria-label="<?php echo _RES; ?>">
                    <span class="d-inline-block d-sm-none" aria-hidden="true">FPA</span>
                    <span class="d-none d-sm-inline-block"><?php echo _RES; ?></span>
                    <span class="ml-1 small text-muted"><?php echo 'v'. _RES_VERSION .' '. _RES_CODENAME; ?></span>
                </a><!--/.navbar-brand-->

                <ul class="navbar-nav flex-row ml-md-auto">

                    <!--dropdown anchors-->
                    <li class="nav-item dropdown py-2 d-none d-md-inline-block">
                        <a class="nav-link 1dropdown-toggle px-2 mr-1" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" aria-label="Report navigation">
                            <i class="fas fa-ellipsis-v fa-fw lead"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right shadow" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item py-1" href="#fpa-dashboard">Dashboard</a>
                            <?php if ( @$_POST['doIT'] == '1' ) { ?>
                                <a class="dropdown-item py-1" href="#postDetails">Post Content</a>
                            <?php } ?>
                            <a class="dropdown-item py-1" href="#instance-discovery">Discovery</a>
                            <?php if ( $showTables == '1' ) { ?>
                                <a class="dropdown-item py-1" href="#database-tables">Database</a>
                            <?php } ?>
                                <a class="dropdown-item py-1" href="#folder-checks">Permissions</a>
                            <?php if ( $showComponents == '1' OR $showModules == '1' OR $showLibraries == '1' OR $showPlugins == '1' ) { ?>
                                <a class="dropdown-item py-1" href="#extensions">Extensions</a>
                            <?php } ?>
                            <a class="dropdown-item py-1" href="#templates">Templates</a>
                            <div class="dropdown-divider mb-0"></div>

                            <form class="m-0 ml-auto p-0 1bg-danger small 1text-white" method="post" name="dropdownDELForm" id="dropdownDELForm">
                                <input type="hidden" name="act" value="delete" />
                                <button class="btn btn-danger text-white text-left btn-sm mr-1 w-100" type="submit" aria-label="Delete FPA now">
                                    <i class="fas fa-trash-alt fa-fw text-white lead"></i> Delete FPA Now
                                </button>
                            </form>
                        </div>
                    </li>

                    <!--privacy-->
                    <?php
                        if ($showProtected == 0) {
                            $privONACTIVE   = '';
                            $privONCHECKED  = '';
                            $privONBTN      = 'secondary';
                            $privOFFACTIVE  = 'active';
                            $privOFFCHECKED = 'checked';
                            $privOFFBTN     = 'info';
                        } else {
                            $privONACTIVE   = 'active';
                            $privONCHECKED  = 'checked';
                            $privONBTN      = 'info';
                            $privOFFACTIVE  = '';
                            $privOFFCHECKED = '';
                            $privOFFBTN      = 'secondary';
                        }
                    ?>
                    <li class="nav-item py-2 d-none d-lg-inline-block" data-container="body" data-toggle="popover" data-trigger="hover" data-placement="bottom" data-fallbackPlacement="flip" data-title="Enable Privacy" data-content="Protect certain sensitive information from public view.">
                        <form class="m-0 ml-auto p-0" method="post" name="navVELForm" id="navPROTECTForm">
                            <div class="xsmall text-center text-primary">Privacy</div>
                            <div class="btn-group btn-group-toggle mr-2" data-toggle="buttons">
                                <label class="btn btn-<?php echo $privONBTN; ?> btn-sm xsmall <?php echo $privONACTIVE; ?>">
                                    <input type="radio" name="showProtected" value="1" onclick="document.getElementById('navPROTECTForm').submit()" id="showProtectedON" <?php echo $privONCHECKED; ?>> ON
                                </label>
                                <label class="btn btn-<?php echo $privOFFBTN; ?> btn-sm xsmall <?php echo $privOFFACTIVE; ?>">
                                    <input type="radio" name="showProtected" value="0" onclick="document.getElementById('navPROTECTForm').submit()" id="showProtectedOFF" <?php echo $privOFFCHECKED; ?> > OFF
                                </label>
                            </div>
                        </form>
                    </li>

                    <!--standard FPA report (resets options)-->
                    <li class="nav-item py-2" data-container="body" data-toggle="popover" data-trigger="hover" data-placement="bottom" data-fallbackPlacement="flip" data-title="FPA Basic Discovery Report" data-content="Run the basic (on-screen) FPA Discovery report (accesskey = [control] alt + f)">
                        <a class="btn btn-outline-primary mr-1" href="<?php echo _FPA_SELF; ?>" role="button" accesskey="f" aria-label="Run the basic FPA Discovery report">
                            <i class="fas fa-chalkboard fa-fw lead"></i>
                        </a>
                    </li>

                    <!--run a VEL report-->
                    <?php if ( defined( '_LIVE_CHECK_VEL') AND $canDOLIVE == '1' AND $instance['instanceFOUND'] == _FPA_Y ) { ?>
                        <li class="nav-item py-2 d-none d-md-inline-block" data-container="body" data-toggle="popover" data-trigger="hover" data-placement="bottom" data-fallbackPlacement="flip" data-title="Vulnerable Extension List" data-content="Run a vulnerable extension check (accesskey = [control] alt + v)">
                            <form class="m-0 ml-auto p-0" method="post" name="navVELForm" id="navVELForm">
                                <input type="hidden" name="doVEL" value="1" />
                                <button class="btn btn-outline-warning mr-1" type="submit" accesskey="v" aria-label="Run a Vulnerable Extension Check">
                                    <i class="fas fa-biohazard fa-fw lead"></i>
                                </button>
                            </form>
                        </li>
                    <?php } // doVEL ?>

                    <!--print to PDF-->
                    <li class="nav-item py-2 d-none d-md-inline-block" data-container="body" data-toggle="popover" data-trigger="hover" data-placement="bottom" data-fallbackPlacement="flip" data-title="Print FPA Report to PDF" data-content="Print to PDF the current FPA snapshot and discovery report.">
                        <form class="m-0 ml-auto p-0" method="post" name="navPDFForm" id="navPDFForm">
                            <input type="hidden" name="doPDF" value="1" />
                            <button class="btn btn-outline-info mr-1" type="submit" accesskey="p" aria-label="Produce a PDF document of the FPA Report">
                                <i class="fas fa-file-pdf fa-fw lead"></i>
                            </button>
                        </form>
                    </li>

                    <!--download latest FPA-->
                    <li class="nav-item py-2 d-none d-md-inline-block" data-container="body" data-toggle="popover" data-trigger="hover" data-placement="bottom" data-fallbackPlacement="flip" data-title="Download FPA" data-content="<?php echo _RES_FPALATEST2; ?>">
                        <a class="btn btn-outline-info mr-1" href="<?php echo _RES_FPALINK2; ?>" rel="noreferrer noopener" target="_blank" role="button" aria-label="<?php echo _RES_FPALATEST2; ?>">
                            <i class="fas fa-cloud-download-alt fa-fw lead"></i>
                        </a>
                    </li>

                    <!-- Guided FPA Tour
                    <li class="nav-item py-2 d-none d-md-inline-block" data-container="body" data-toggle="popover" data-trigger="hover" data-placement="bottom" data-fallbackPlacement="flip" data-title="FPA Guided Tour" data-content="View the FPA guided tour and learn how to reead and use the FPA">
                        <a class="btn btn-outline-primary mr-1" href="#" role="button" aria-label="View the FPA guided tour">
                            <i class="fas fa-shoe-prints lead"></i>
                        </a>
                    </li>
                    -->

                    <!--darkmode-->
                    <?php if ( @$darkmode == '0' ) { ?>
                        <li class="nav-item py-2" data-container="body" data-toggle="popover" data-trigger="hover" data-placement="bottom" data-fallbackPlacement="flip" data-title="Switch To Night Mode" data-content="View FPA in Night Mode (accesskey = [control] alt + n)">
                            <form class="m-0 ml-auto p-0" method="post" name="navDARKForm" id="navDARKForm">
                                <input type="hidden" name="darkmode" value="1" />
                                <button class="btn btn-outline-dark mr-1" type="submit" accesskey="n" aria-label="Night Mode">
                                    <i class="fas fa-moon fa-fw lead"></i>
                                </button>
                            </form>
                        </li>
                    <?php } else { ?>
                        <li class="nav-item py-2" data-container="body" data-toggle="popover" data-trigger="hover" data-placement="bottom" data-fallbackPlacement="flip" data-title="Switch To Light Mode" data-content="View FPA in Light Mode (accesskey = [control] alt + l)">
                            <form class="m-0 ml-auto p-0" method="post" name="navDARKForm" id="navDARKForm">
                                <input type="hidden" name="darkmode" value="0" />
                                <button class="btn btn-outline-dark mr-1" type="submit" accesskey="l" aria-label="Light Mode">
                                    <i class="fas fa-sun fa-fw lead"></i>
                                </button>
                            </form>
                        </li>
                    <?php } // darkmode ?>

                    <!--got to docs-->
                    <li class="nav-item py-2" data-container="body" data-toggle="popover" data-trigger="hover" data-placement="bottom" data-fallbackPlacement="flip" data-title="FPA Documentation" data-content="Visit the FPA documentation site on Github">
                        <a class="1nav-link btn btn-outline-info mr-1" href="https://forumpostassistant.github.io/docs/" rel="noreferrer noopener" target="_blank" role="button" aria-label="Visit the FPA documentation site on Github">
                            <i class="fas fa-book-reader lead"></i>
                        </a>
                    </li>

                    <!--SPARE
                    <li class="nav-item py-2 border-right d-none d-md-inline-block mr-2" data-container="body" data-toggle="popover" data-trigger="hover" data-placement="bottom" data-fallbackPlacement="flip" data-content="Print the current FPA audit report">
                        <a class="btn btn-info lead mr-2" href="#" role="button" aria-label="Print the current FPA audit report">
                            <i class="fas fa-print lead"></i>
                        </a>
                    </li>
                    -->

                    <!--delete FPA-->
                    <li class="nav-item py-2" data-container="body" data-toggle="popover" data-trigger="hover" data-placement="bottom" data-fallbackPlacement="flip" data-title="FPA Security Notice" data-content="Delete the FPA script now (accesskey = [control] alt + d)">
                        <form class="m-0 ml-auto p-0" method="post" name="navDELForm" id="navDELForm">
                            <input type="hidden" name="act" value="delete" />
                            <button class="btn btn-outline-danger mr-1" type="submit" accesskey="d" aria-label="Delete FPA now">
                                <i class="fas fa-trash-alt fa-fw lead"></i>
                            </button>
                        </form>
                    </li>

                </ul><!--/.navbar-nav-->

            </nav>

            <?php
            /**
             * print only header
             *
             * added @RussW 31/05/2020
             *
             */
            ?>
            <div class="container d-none d-print-block border-bottom border-dark" id="printHeader">
                <div>
                    <h2 class="h1 font-weight-lighter mb-1">
                        <span class="xsmall text-right float-right"><?php echo date('jS F Y'); ?><br /><?php echo date('g:i a'); ?><br /><?php echo date('e'); ?></span>
                            <?php
                                if ( !empty($config->sitename) ) {
                                    echo $config->sitename;
                                }
                            ?>
                    </h2>
                    <h3 class="h4"><?php echo $_SERVER['HTTP_HOST']; ?></h3>
                </div>
            </div>

        </header>



        <?php
        /**
         * SEEING A WHITE SCREEN WHILST RUNNING FPA? OR SOMEONE HELPING YOU SENT YOU HERE?
         * uncomment _FPA_DIAG or _FPA_DIAG in Default Settings to enable and re-run FPA
         *
         * display_errors, enables php errors to be displayed on the screen
         * error_reporting, sets the level of errors to report, "-1" is all errors
         * log_errors, enables errors to be logged to a file, fpa_error.log in the "/" folder
         *
         * moved inside body to avoid page layout errors - @RussW 27/05/2020
         *
         */
        if ( defined( '_FPA_DEV' ) OR defined( '_FPA_DIAG' ) OR @$_SERVER['HTTPS'] != 'on' ) {
        ?>
            <div class="alert alert-warning text-white text-center p-0 m-0 d-print-none" data-html2canvas-ignore="true">

                <?php
                    // display developer-mode notice
                    if ( defined( '_FPA_DEV' ) ) {
                        ini_set( 'display_errors', 'Off' ); // default-display

                        echo '<h4 class="text-white m-1 p-0 text-capitalize">'. _FPA_DEVENA .'</h4>';

                    } // end developer-mode display

                    // display diagnostic-mode notice
                    if ( defined( '_FPA_DIAG' ) ) {
                        ini_set( 'display_errors', 1 );

                        ini_set ( 'error_reporting', '-1' );
                        ini_set( 'error_log', $fpa['diagLOG'] );

                        echo '<h4 class="text-white m-1 p-0 text-capitalize">'. _FPA_DIAENA .'</h4>';
                        echo '<p class="text-dark">'. _FPA_DIADSC .' '. $fpa['diagLOG'] .'</p>';

                            if ( file_exists( $fpa['diagLOG'] ) ) {

                                $fpa['fpaLASTERR'] = @array_pop( file( $fpa['diagLOG'] ) );
                                echo '<p class="border border-white p-2 mt-2 w-75 mx-auto"><strong>Last Known Error</strong><br />'. $fpa['fpaLASTERR'] .'</p>';

                            } else {
                                echo '<p class="border border-white p-2 mt-2 w-75 mx-auto"><strong>Last Known Error</strong><br />' ._FPA_NER .'</p>';
                            }

                    } // end diagnostic-mode display

                    if ( @$_SERVER['HTTPS'] != 'on' ) {
                        echo '<p class="pt-1 mb-1 w-75 mx-auto"><i class="fas fa-unlock-alt fa-fw"></i> SSL may not be available for this site, it is recommended that SSL is used on all sites where possible.</p>';
                    }
                ?>

            </div><!--/.alert DEV/DIAG-->

        <?php
            } else { // end developer- or diag -mode display
                ini_set( 'display_errors', 0 ); // default-display
            }
        ?>



        <main class="main">

            <!--START POST FORM-->
            <form method="post" name="postDetails" id="postDetails">


                <?php
                /**
                 * fpa snapshot section
                 *
                 * basic joomla and environment checks and display
                 *
                 */
                ?>
                <section class="bg-light pt-2" id="fpa-dashboard">
                    <div class="container pt-4 pb-3">

                        <h1 class="font-weight-light border-bottom"><i class="fas fa-dice-d6 fa-sm text-muted"></i> <?php echo _FPA_SNAP_TITLE; ?></h1>
                        <p class="text-dark mb-lg-5"><?php echo _FPA_DASHBOARD_CONFIDENCE_NOTE; ?></p>

                        <div class="row">
                            <div class="col-md-8 col-lg-8">

                                <?php
                                /**
                                 * fpa snapshot section
                                 * basic joomla and environment checks and display
                                 *
                                 * SUPPORT SECTIONS
                                 * added a 2.5 section - @PhilD 4-20-12
                                 * added a 3.1, 3.2 section - @PhilD 01-01-14
                                 *
                                 * Note:
                                 * With the release of Joomla! 3.2, the CMS introduced a new feature called, Strong Passwords.
                                 * The intent was to enhance the encryption of password hashing and storage through the use of BCrypt,
                                 * thus increasing the security of Joomla! 3.2 user accounts. Bcrypt was not available in the early releases
                                 * of php 5.3, and with the first releases, a bug in the algorithm surfaced. This prompted a change in the
                                 * later php versions to fix it. The Joomla 3 series required a minimum php version of 5.3+ which unfortunately
                                 * includes php versions without BCrypt and the buggy first release of BCrypt. The Strong Passwords feature
                                 * has built in compatibility to determine if BCrypt was available based on a php version check of the Joomla
                                 * installation's server. The version check is used to determine exactly what the Strong Passwords feature
                                 * would enable, BCrypt or the next best available password hashing encryption available. Unfortunately,
                                 * this can lead to access issues under certain circumstances.
                                 * To reflect this issue with Joomla 3.2.0 and earlier versions of php 5.3, the FPA checks to see if the
                                 * Joomla! version is 3.2.0 and then checks the php version on the server. If the version php version is less
                                 * than 5.3.7 then the FPA will report that php does not support Joomla!
                                 *
                                 * PHP version of 5.3.1+ is supported by Joomla 3.2.1 due to the fix put in place in Joomla 3.2.1
                                 *
                                 * MySQL:
                                 * On Medialayer at least, mysql 5.0.87-community will work with current versions of Joomla and has inno db enabled
                                 *
                                 */

                                /**
                                 * MariaDB check. Get the Database type and look for MariaDB. All current versions of MariaDB should be current
                                 * with Joomla. The issue with using version numbers is mysql also uses numbers, so this check differentiates
                                 * between mysql and MariaDB. If there is a better idea given the current FPA code feel free to submit it.
                                 * @PhilD 03-17-17
                                 *
                                 */
                                $input_line = @$database['dbHOSTSERV'];
                                preg_match("/\b(\w*mariadb\w*)\b/i", $input_line, $output_array);

                                if  (@$instance['cmsRELEASE'] >= '4.0') {
                                    $fpa['supportENV']['minPHP']        = '7.2.5';
                                    $fpa['supportENV']['minSQL']        = '5.6.0';
                                    $fpa['supportENV']['maxPHP']        = '8.0.0';
                                    $fpa['supportENV']['maxSQL']        = '9.0.0';
                                    $fpa['supportENV']['badPHP'][0]     = '5.3.0';
                                    $fpa['supportENV']['badPHP'][1]     = '5.3.1';
                                    $fpa['supportENV']['badPHP'][2]     = '5.3.2';
                                    $fpa['supportENV']['badPHP'][3]     = '5.3.3';
                                    $fpa['supportENV']['badPHP'][4]     = '5.3.4';
                                    $fpa['supportENV']['badPHP'][5]     = '5.3.5';
                                    $fpa['supportENV']['badPHP'][6]     = '5.3.6';
                                    $fpa['supportENV']['badZND'][0]     = _FPA_NA;

                                } elseif  (@$instance['cmsRELEASE'] == '3.10') {
                                    $fpa['supportENV']['minPHP']        = '5.3.10';
                                    $fpa['supportENV']['minSQL']        = '5.1.0';
                                    $fpa['supportENV']['maxPHP']        = '8.0.0';
                                    $fpa['supportENV']['maxSQL']        = '9.0.0';
                                    $fpa['supportENV']['badPHP'][0]     = '5.3.0';
                                    $fpa['supportENV']['badPHP'][1]     = '5.3.1';
                                    $fpa['supportENV']['badPHP'][2]     = '5.3.2';
                                    $fpa['supportENV']['badPHP'][3]     = '5.3.3';
                                    $fpa['supportENV']['badPHP'][4]     = '5.3.4';
                                    $fpa['supportENV']['badPHP'][5]     = '5.3.5';
                                    $fpa['supportENV']['badPHP'][6]     = '5.3.6';
                                    $fpa['supportENV']['badZND'][0]     = _FPA_NA;

                                } elseif  (@$instance['cmsRELEASE'] == '3.9') {
                                    $fpa['supportENV']['minPHP']        = '5.3.10';
                                    $fpa['supportENV']['minSQL']        = '5.1.0';
                                    $fpa['supportENV']['maxPHP']        = '7.5.0';
                                    $fpa['supportENV']['maxSQL']        = '8.5.0';
                                    $fpa['supportENV']['badPHP'][0]     = '5.3.0';
                                    $fpa['supportENV']['badPHP'][1]     = '5.3.1';
                                    $fpa['supportENV']['badPHP'][2]     = '5.3.2';
                                    $fpa['supportENV']['badPHP'][3]     = '5.3.3';
                                    $fpa['supportENV']['badPHP'][4]     = '5.3.4';
                                    $fpa['supportENV']['badPHP'][5]     = '5.3.5';
                                    $fpa['supportENV']['badPHP'][6]     = '5.3.6';
                                    $fpa['supportENV']['badZND'][0]     = _FPA_NA;

                                } elseif  (@$instance['cmsRELEASE'] > '3.7' AND @$instance['cmsDEVLEVEL'] > '2') {
                                    $fpa['supportENV']['minPHP']        = '5.3.10';
                                    $fpa['supportENV']['minSQL']        = '5.1.0';
                                    $fpa['supportENV']['maxPHP']        = '7.5.0';
                                    $fpa['supportENV']['maxSQL']        = '5.8.0';
                                    $fpa['supportENV']['badPHP'][0]     = '5.3.0';
                                    $fpa['supportENV']['badPHP'][1]     = '5.3.1';
                                    $fpa['supportENV']['badPHP'][2]     = '5.3.2';
                                    $fpa['supportENV']['badPHP'][3]     = '5.3.3';
                                    $fpa['supportENV']['badPHP'][4]     = '5.3.4';
                                    $fpa['supportENV']['badPHP'][5]     = '5.3.5';
                                    $fpa['supportENV']['badPHP'][6]     = '5.3.6';
                                    $fpa['supportENV']['badZND'][0]     = _FPA_NA;

                                } elseif ( @$instance['cmsRELEASE'] >= '3.5') {
                                    $fpa['supportENV']['minPHP']        = '5.3.10';
                                    $fpa['supportENV']['minSQL']        = '5.1.0';
                                    $fpa['supportENV']['maxPHP']        = '7.1.99';
                                    $fpa['supportENV']['maxSQL']        = '5.8.0';
                                    $fpa['supportENV']['badPHP'][0]     = '5.3.0';
                                    $fpa['supportENV']['badPHP'][1]     = '5.3.1';
                                    $fpa['supportENV']['badPHP'][2]     = '5.3.2';
                                    $fpa['supportENV']['badPHP'][3]     = '5.3.3';
                                    $fpa['supportENV']['badPHP'][4]     = '5.3.4';
                                    $fpa['supportENV']['badPHP'][5]     = '5.3.5';
                                    $fpa['supportENV']['badPHP'][6]     = '5.3.6';
                                    $fpa['supportENV']['badZND'][0]     = _FPA_NA;

                                } elseif ( @$instance['cmsRELEASE']  == '3.3' OR @$instance['cmsRELEASE']  == '3.4')  {
                                    $fpa['supportENV']['minPHP']        = '5.3.10';
                                    $fpa['supportENV']['minSQL']        = '5.1.0';
                                    $fpa['supportENV']['maxPHP']        = '6.0.0';
                                    $fpa['supportENV']['maxSQL']        = '5.8.0';
                                    $fpa['supportENV']['badPHP'][0]     = '5.3.0';
                                    $fpa['supportENV']['badPHP'][1]     = '5.3.1';
                                    $fpa['supportENV']['badPHP'][2]     = '5.3.2';
                                    $fpa['supportENV']['badPHP'][3]     = '5.3.3';
                                    $fpa['supportENV']['badPHP'][4]     = '5.3.4';
                                    $fpa['supportENV']['badPHP'][5]     = '5.3.5';
                                    $fpa['supportENV']['badPHP'][6]     = '5.3.6';
                                    $fpa['supportENV']['badZND'][0]     = _FPA_NA;

                                } elseif ( @$instance['cmsRELEASE'] == '3.2' AND @$instance['cmsDEVLEVEL'] >= 1) {
                                    $fpa['supportENV']['minPHP']        = '5.3.1';
                                    $fpa['supportENV']['minSQL']        = '5.1.0';
                                    $fpa['supportENV']['maxPHP']        = '6.0.0';  // latest release?
                                    $fpa['supportENV']['maxSQL']        = '5.8.0';  // latest release?
                                    $fpa['supportENV']['badPHP'][0]     = '5.3.0';
                                    $fpa['supportENV']['badPHP'][1]     = '5.3.1';
                                    $fpa['supportENV']['badPHP'][2]     = '5.3.2';
                                    $fpa['supportENV']['badPHP'][3]     = '5.3.3';
                                    $fpa['supportENV']['badPHP'][4]     = '5.3.4';
                                    $fpa['supportENV']['badPHP'][5]     = '5.3.5';
                                    $fpa['supportENV']['badPHP'][6]     = '5.3.6';
                                    $fpa['supportENV']['badZND'][0]     = _FPA_NA;
                                } elseif ( @$instance['cmsRELEASE'] == '3.2' AND @$instance['cmsDEVLEVEL'] == 0) {
                                    $fpa['supportENV']['minPHP']        = '5.3.7';
                                    $fpa['supportENV']['minSQL']        = '5.1.0';
                                    $fpa['supportENV']['maxPHP']        = '6.0.0';  // latest release?
                                    $fpa['supportENV']['maxSQL']        = '5.8.0';  // latest release?
                                    $fpa['supportENV']['badPHP'][0]     = '5.3.0';
                                    $fpa['supportENV']['badPHP'][1]     = '5.3.1';
                                    $fpa['supportENV']['badPHP'][2]     = '5.3.2';
                                    $fpa['supportENV']['badPHP'][3]     = '5.3.3';
                                    $fpa['supportENV']['badPHP'][4]     = '5.3.4';
                                    $fpa['supportENV']['badPHP'][5]     = '5.3.5';
                                    $fpa['supportENV']['badPHP'][6]     = '5.3.6';
                                    $fpa['supportENV']['badZND'][0]     = _FPA_NA;
                                } elseif ( @$instance['cmsRELEASE'] == '3.1' ) {
                                    $fpa['supportENV']['minPHP']        = '5.3.1';
                                    $fpa['supportENV']['minSQL']        = '5.1.0';
                                    $fpa['supportENV']['maxPHP']        = '6.0.0';  // latest release?
                                    $fpa['supportENV']['maxSQL']        = '5.8.0';  // latest release?
                                    $fpa['supportENV']['badPHP'][0]     = '5.3.0';
                                    $fpa['supportENV']['badPHP'][1]     = '5.3.1';
                                    $fpa['supportENV']['badPHP'][2]     = '5.3.2';
                                    $fpa['supportENV']['badPHP'][3]     = '5.3.3';
                                    $fpa['supportENV']['badPHP'][4]     = '5.3.4';
                                    $fpa['supportENV']['badPHP'][5]     = '5.3.5';
                                    $fpa['supportENV']['badPHP'][6]     = '5.3.6';
                                    $fpa['supportENV']['badZND'][0]     = _FPA_NA;
                                } elseif ( @$instance['cmsRELEASE'] == '3.0' ) {
                                    $fpa['supportENV']['minPHP']        = '5.3.1';
                                    $fpa['supportENV']['minSQL']        = '5.1.0';
                                    $fpa['supportENV']['maxPHP']        = '6.0.0';  // latest release?
                                    $fpa['supportENV']['maxSQL']        = '5.8.0';  // latest release?
                                    $fpa['supportENV']['badPHP'][0]     = '5.3.0';
                                    $fpa['supportENV']['badPHP'][1]     = '5.3.1';
                                    $fpa['supportENV']['badPHP'][2]     = '5.3.2';
                                    $fpa['supportENV']['badPHP'][3]     = '5.3.3';
                                    $fpa['supportENV']['badPHP'][4]     = '5.3.4';
                                    $fpa['supportENV']['badPHP'][5]     = '5.3.5';
                                    $fpa['supportENV']['badPHP'][6]     = '5.3.6';
                                    $fpa['supportENV']['badZND'][0]     = _FPA_NA;
                                } elseif ( @$instance['cmsRELEASE'] == '2.5' ) {
                                    $fpa['supportENV']['minPHP']        = '5.2.4';
                                    $fpa['supportENV']['minSQL']        = '5.0.4';
                                    $fpa['supportENV']['maxPHP']        = '6.0.0';  // latest release?
                                    $fpa['supportENV']['maxSQL']        = '5.8.0';  // latest release?
                                    $fpa['supportENV']['badPHP'][0]     = _FPA_NA;
                                    $fpa['supportENV']['badZND'][0]     = _FPA_NA;

                                } elseif ( @$instance['cmsRELEASE'] == '1.7' ) {
                                    $fpa['supportENV']['minPHP']        = '5.2.4';
                                    $fpa['supportENV']['minSQL']        = '5.0.4';
                                    $fpa['supportENV']['maxPHP']        = '6.0.0';  // latest release?
                                    $fpa['supportENV']['maxSQL']        = '5.8.0';  // latest release?
                                    $fpa['supportENV']['badPHP'][0]     = _FPA_NA;
                                    $fpa['supportENV']['badZND'][0]     = _FPA_NA;

                                } elseif ( @$instance['cmsRELEASE'] == '1.6' ) {
                                    $fpa['supportENV']['minPHP']        = '5.2.4';
                                    $fpa['supportENV']['minSQL']        = '5.0.4';
                                    $fpa['supportENV']['maxPHP']        = '6.0.0';  // latest release?
                                    $fpa['supportENV']['maxSQL']        = '5.8.0';  // latest release?
                                    $fpa['supportENV']['badPHP'][0]     = _FPA_NA;
                                    $fpa['supportENV']['badZND'][0]     = _FPA_NA;

                                } elseif ( @$instance['cmsRELEASE'] == '1.5' ) {

                                    if ( @$instance['cmsDEVLEVEL'] <= '14' ) {
                                        $fpa['supportENV']['minPHP']        = '4.3.10';
                                        $fpa['supportENV']['minSQL']        = '3.23.0';
                                        $fpa['supportENV']['maxPHP']        = '5.2.17';
                                        $fpa['supportENV']['maxSQL']        = '5.5.0';  // limited by ENGINE TYPE changes in 5.5 and install sql syntax

                                    } else {
                                        $fpa['supportENV']['minPHP']        = '4.3.10';
                                        $fpa['supportENV']['minSQL']        = '3.23.0';
                                        $fpa['supportENV']['maxPHP']        = '5.3.6';
                                        $fpa['supportENV']['maxSQL']        = '5.5.0';  // limited by ENGINE TYPE changes in 5.5 and install sql syntax

                                    }

                                    $fpa['supportENV']['badPHP'][0]     = '4.3.9';
                                    $fpa['supportENV']['badPHP'][1]     = '4.4.2';
                                    $fpa['supportENV']['badPHP'][2]     = '5.0.4';
                                    $fpa['supportENV']['badZND'][0]     = '2.5.10';

                                } elseif ( @$instance['cmsRELEASE'] == '1.0' ) {
                                    $fpa['supportENV']['minPHP']        = '3.0.1';
                                    $fpa['supportENV']['minSQL']        = '3.0.0';
                                    $fpa['supportENV']['maxPHP']        = '5.2.17';  // changed max supported php from 4.4.9 to 5.2.17 - 03/12/17 - PD
                                    $fpa['supportENV']['maxSQL']        = '5.0.91';  // limited by ENGINE TYPE changes in 5.0 and install sql syntax
                                    $fpa['supportENV']['badPHP'][0]     = _FPA_NA;
                                    $fpa['supportENV']['badZND'][0]     = _FPA_NA;

                                } else {
                                    $fpa['supportENV']['minPHP']        = _FPA_NA;
                                    $fpa['supportENV']['minSQL']        = _FPA_NA;
                                    $fpa['supportENV']['maxPHP']        = _FPA_NA;
                                    $fpa['supportENV']['maxSQL']        = _FPA_NA;
                                    $fpa['supportENV']['badPHP'][0]     = _FPA_NA;
                                    $fpa['supportENV']['badZND'][0]     = _FPA_NA;
                                }
                                ?>

                                <div class="row">

                                    <div class="col-sm-6 col-lg-3 text-center mb-3">

                                        <small class="d-block text-truncate"><?php echo _FPA_SUPPHP .' J! '. @$instance['cmsRELEASE'] .'.' . @$instance['cmsDEVLEVEL']; ?></small>
                                        <div class="border bg-white p-2 py-lg-3">

                                            <?php // minimum and maximum PHP support requirements met?
                                                if ( $fpa['supportENV']['minPHP'] == _FPA_NA ) {
                                                    echo '<span class="text-warning">'. _FPA_U .'</span>';
                                                    $snapshot['phpSUP4J'] = _FPA_U;

                                                } elseif ( ( version_compare( PHP_VERSION, $fpa['supportENV']['minPHP'], '>=' ) ) AND ( version_compare( PHP_VERSION, $fpa['supportENV']['maxPHP'], '<=' ) ) ) {
                                                    echo '<span class="text-success">'. _FPA_Y .'</span>';
                                                    $snapshot['phpSUP4J'] = _FPA_Y;

                                                } elseif ( ( version_compare( PHP_VERSION, $fpa['supportENV']['minPHP'], '<' ) ) OR ( version_compare( PHP_VERSION, $fpa['supportENV']['maxPHP'], '>' ) ) ) {
                                                    echo '<span class="text-danger">'. _FPA_N .'</span>';
                                                    $snapshot['phpSUP4J'] = _FPA_N;

                                                } else {
                                                    echo '<span class="text-warning">'. _FPA_U .'</span>';
                                                    $snapshot['phpSUP4J'] = _FPA_U;
                                                }
                                            ?>

                                        </div>

                                    </div>
                                    <div class="col-sm-6 col-lg-3 text-center mb-3">

                                        <small class="d-block text-truncate">PHP API</small>
                                        <div class="border bg-white p-2 py-lg-3">

                                            <?php // PHP API
                                                if ( @$phpenv['phpAPI'] ) {

                                                    if ( @$phpenv['phpAPI'] == 'apache2handler' ) {
                                                        echo '<span class="text-warning">'. @$phpenv['phpAPI'] .'</span>';

                                                    } else {
                                                        echo '<span class="text-success">'. @$phpenv['phpAPI'] .'</span>';
                                                    }

                                                } else {
                                                    echo '<span class="text-warning">'. _FPA_U .'</span>';
                                                }
                                            ?>

                                        </div>

                                    </div>
                                    <div class="col-sm-6 col-lg-3 text-center mb-3">

                                        <small class="d-block text-truncate"><?php echo _FPA_SUPPHP; ?> MySQL</small>
                                        <div class="border bg-white p-2 py-lg-3">

                                            <?php // MySQL supported by PHP?
                                                if ( array_key_exists( 'mysql', $phpextensions ) ) {
                                                    echo '<span class="text-success">'. _FPA_Y .'</span>';
                                                    $snapshot['phpSUP4MYSQL'] = _FPA_Y;

                                                } else {
                                                    echo '<span class="">'. _FPA_N .'</span>';
                                                    $snapshot['phpSUP4MYSQL'] = _FPA_N;
                                                }
                                            ?>

                                        </div>

                                    </div>
                                    <div class="col-sm-6 col-lg-3 text-center mb-3">

                                        <small class="d-block text-truncate"><?php echo _FPA_SUPPHP; ?> MySQLi</small>
                                        <div class="border bg-white p-2 py-lg-3">

                                            <?php // MySQLi supported by PHP?
                                                if ( array_key_exists( 'mysqli', $phpextensions ) ) {
                                                    echo '<span class="text-success">'. _FPA_Y .'</span>';
                                                    $snapshot['phpSUP4MYSQL-i'] = _FPA_Y;

                                                } else {
                                                    echo '<span class="text-warning">'. _FPA_N .'</span>';
                                                    $snapshot['phpSUP4MYSQL-i'] = _FPA_N;
                                                }
                                            ?>

                                        </div>

                                    </div>
                                    <div class="col-sm-6 col-lg-3 text-center mb-3">

                                        <small class="d-block text-truncate"><?php echo _FPA_SUPSQL .' J! '. @$instance['cmsRELEASE'] .'.' . @$instance['cmsDEVLEVEL']; ?></small>
                                        <div class="border bg-white p-2 py-lg-3">

                                            <?php // minimum and maximum MySQL support requirements met?
                                                if ( $fpa['supportENV']['minSQL'] == _FPA_NA OR @$database['dbERROR'] != _FPA_N ) {
                                                    echo '<span class="text-warning">'. _FPA_U .'</span>';
                                                    $snapshot['sqlSUP4J'] = _FPA_U;

                                                } elseif ( ( version_compare( @$database['dbHOSTSERV'], $fpa['supportENV']['minSQL'], '>=' ) ) AND ( version_compare( @$database['dbHOSTSERV'], $fpa['supportENV']['maxSQL'], '<=' ) ) ) {

                                                    // WARNING, will run, but ONLY after modifying install SQL to remove ENGINE TYPE statements (removed in MySQL 5.5)
                                                    if ( ( $instance['cmsRELEASE'] == '1.5' ) AND ( @$database['dbHOSTSERV'] > '5.1.43' ) ) {
                                                        echo '<span class="text-warning">'. _FPA_M .' (<a href="http://forum.joomla.org/viewtopic.php?p=2297327" target="_new">'. _FPA_SPNOTE .'</a>)</span>';
                                                        $snapshot['sqlSUP4J'] = _FPA_M;

                                                    } else {
                                                        echo '<span class="text-success">'. _FPA_Y .'</span>';
                                                        $snapshot['sqlSUP4J'] = _FPA_Y;
                                                    }

                                                } elseif ( ( version_compare( @$database['dbHOSTSERV'], $fpa['supportENV']['minSQL'], '<' ) ) OR ( version_compare( @$database['dbHOSTSERV'], $fpa['supportENV']['maxSQL'], '>' ) ) ) {

                                                    // WARNING, will run, but ONLY after modifying install SQL to remove ENGINE TYPE statements (removed in MySQL 5.5)
                                                    if ( ( $instance['cmsRELEASE'] == '1.5' ) AND ( @$database['dbHOSTSERV'] > '5.1.43' ) ) {
                                                        echo '<span class="text-warning">'. _FPA_M .' (<a href="http://forum.joomla.org/viewtopic.php?p=2297327" target="_new">'. _FPA_SPNOTE .'</a>)</span>';
                                                        $snapshot['sqlSUP4J'] = _FPA_M;

                                                    }
                                                    //Added this elseif to give the ok for postgreSQL
                                                    elseif ($instance['configDBTYPE'] == 'postgresql' AND $database['dbHOSTSERV'] >= 8.3 ) {
                                                        echo '<span class="text-success">'. _FPA_Y .'</span>';
                                                        $snapshot['sqlSUP4J'] = _FPA_Y;
                                                    }
                                                    //Added this elseif to give the ok for PDO postgreSQL
                                                    elseif ($instance['configDBTYPE'] == 'pgsql' AND $database['dbHOSTSERV'] >= 8.3 ) {
                                                        echo '<span class="text-success">'. _FPA_Y .'</span>';
                                                        $snapshot['sqlSUP4J'] = _FPA_Y;
                                                    }
                                                    //Added this elseif to give the ok for MariaDB -- PhilD 03-17-17
                                                    elseif (strtoupper(@$output_array[0]) == "MARIADB") {
                                                        echo '<span class="text-success">'. _FPA_MDB .'</span>';
                                                        $snapshot['sqlSUP4J'] = _FPA_Y;
                                                    }
                                                    else {
                                                        echo '<span class="text-danger">'. _FPA_N .'</span>';
                                                        $snapshot['sqlSUP4J'] = _FPA_N;
                                                    }

                                                } else {
                                                    echo '<span class="text-warning">'. _FPA_U .'</span>';
                                                    $snapshot['sqlSUP4J'] = _FPA_U;
                                                }
                                            ?>

                                        </div>

                                    </div>
                                    <div class="col-sm-6 col-lg-3 text-center mb-3">

                                        <small class="d-block text-truncate"><?php echo _FPA_SUPSQL; ?> MySQLi</small>
                                        <div class="border bg-white p-2 py-lg-3">

                                            <?php // MySQLi supported by MySQL?
                                                if ( !@$database['dbHOSTSERV'] OR @$database['dbERROR'] != _FPA_N ) {
                                                    echo '<span class="text-warning">'. _FPA_U .'</span>';
                                                    $snapshot['sqlSUP4SQL-i'] = _FPA_U;

                                                } elseif ( version_compare( @$database['dbHOSTSERV'], '5.0.7', '>=' ) ) {
                                                    echo '<span class="text-success">'. _FPA_Y .'</span>';

                                                } else {
                                                    echo '<span class="text-danger">'. _FPA_N .'</span>';
                                                    $snapshot['sqlSUP4SQL-i'] = _FPA_N;
                                                }
                                            ?>

                                        </div>

                                    </div>
                                    <div class="col-sm-6 col-lg-3 text-center mb-3">

                                        <small class="d-block text-truncate">Database Connection Type</small>
                                        <div class="border bg-white p-2 py-lg-3">

                                            <?php // J! connection to MySQL
                                                if ( @$instance['configDBTYPE'] ) {

                                                    if ( ( @$snapshot['sqlSUP4SQL-i'] == _FPA_N OR @$snapshot['sqlSUP4SQL-i'] == _FPA_U ) AND @$instance['configDBTYPE'] == 'mysqli') {
                                                        echo '<span class="text-danger">'. @$instance['configDBTYPE'] .'</span>';

                                                    } else {
                                                        echo '<span class="text-success">'. @$instance['configDBTYPE'] .'</span>';
                                                    }

                                                } else {
                                                    echo '<span class="text-warning">'. _FPA_U .'</span>';
                                                }
                                            ?>

                                        </div>

                                    </div>
                                    <div class="col-sm-6 col-lg-3 text-center mb-3">

                                        <small class="d-block text-truncate">Database <?php echo _FPA_DEF .' '. _FPA_TCOL; ?></small>
                                        <div class="border bg-white p-2 py-lg-3">

                                            <?php // MySQL default collation
                                                if ( @$database['dbHOSTDEFCHSET'] ) {
                                                    echo '<span class="text-success">'. @$database['dbHOSTDEFCHSET'] .'</span>';

                                                } else {
                                                    echo '<span class="text-warning">'. _FPA_U .'</span>';
                                                }
                                            ?>

                                        </div>

                                    </div>
                                    <div class="col-sm-6 col-lg-3 text-center mb-3">

                                        <small class="d-block text-truncate">PHP <?php echo _FPA_VER; ?></small>
                                        <div class="border bg-white p-2 py-lg-3">

                                            <?php // Unsupported PHP version
                                                if ( version_compare( PHP_VERSION, '5', '<' ) ) {
                                                    echo '<span class="text-danger">'. PHP_VERSION .'</span>';

                                                } else {
                                                    echo '<span class="text-success">'. PHP_VERSION .'</span>';
                                                }
                                            ?>

                                        </div>

                                    </div>
                                    <div class="col-sm-6 col-lg-3 text-center mb-3">

                                        <small class="d-block text-truncate"><?php echo _FPA_BADPHP; ?></small>
                                        <div class="border bg-white p-2 py-lg-3">

                                            <?php // known buggy php releases (mainly for installation on 1.5)
                                                foreach ( $fpa['supportENV']['badPHP'] as $badKey => $badValue ) {
                                                    if ( version_compare( PHP_VERSION, $badValue, '==' ) ) {
                                                        $badANS = _FPA_Y;
                                                        continue;
                                                    }

                                                }

                                                if ( @$badANS == _FPA_Y ) {
                                                    $badClass = 'text-danger';
                                                    $snapshot['buggyPHP'] = _FPA_N;

                                                } else {
                                                    $badANS = _FPA_N;
                                                    $badClass = 'success';
                                                    $snapshot['buggyPHP'] = _FPA_N;
                                                }
                                            ?>

                                            <span class="text-<?php echo $badClass; ?>"><?php echo $badANS; ?></span>
                                        </div>

                                    </div>
                                    <div class="col-sm-6 col-lg-3 text-center mb-3">

                                        <small class="d-block text-truncate">Database <?php echo _FPA_VER; ?></small>
                                        <div class="border bg-white p-2 py-lg-3">
                                            <span class="">
                                                <?php // MySQL Version
                                                    if ( @$database['dbHOSTSERV'] ) {
                                                        echo @$database['dbHOSTSERV'];
                                                    } else {
                                                        echo _FPA_U;
                                                    }
                                                ?>
                                            </span>
                                        </div>

                                    </div>
                                    <div class="col-sm-6 col-lg-3 text-center mb-3">

                                        <small class="d-block text-truncate"><?php echo _FPA_BADZND; ?></small>
                                        <div class="border bg-white p-2 py-lg-3">

                                            <?php // known buggy zend releases (mainly for installation on 1.5)
                                                $badValue   = ''; // reset variables to fix zend check bug
                                                $badANS     = '';
                                                foreach ( $fpa['supportENV']['badZND'] as $badKey => $badValue ) {

                                                    if ( version_compare( $phpextensions['Zend Engine'], $badValue, '==' ) ) {
                                                        $badANS = _FPA_Y;
                                                        continue;
                                                    }

                                                }

                                                if ( @$badANS == _FPA_Y ) {
                                                    $badClass = 'danger';
                                                    $snapshot['buggyZEND'] = _FPA_Y;

                                                } else {
                                                    $badANS = _FPA_N;
                                                    $badClass = 'success';
                                                    $snapshot['buggyZEND'] = _FPA_N;
                                                }
                                            ?>

                                            <span class="text-<?php echo $badClass; ?>"><?php echo $badANS; ?></span>
                                        </div>

                                    </div>

                                </div><!-- /.row-->
                                <?php showDev( $snapshot ); ?>


                                <?php
                                /**
                                 * if enabled, display live update information
                                 * added @RussW 28/05/2020
                                 *
                                 */
                                ?>
                                <?php if ( (defined( '_LIVE_CHECK_FPA' ) OR defined( '_LIVE_CHECK_JOOMLA' )) AND $canDOLIVE == '1' ) { ?>

                                    <?php
                                        if ( defined( '_LIVE_CHECK_FPA' ) AND (defined( '_LIVE_CHECK_JOOMLA' ) AND $instance['instanceFOUND'] == _FPA_Y)) {
                                            $rowCol = '2';
                                        } else {
                                            $rowCol = '1';
                                        }
                                    ?>

                                    <div class="row row-cols-1 row-cols-lg-<?php echo $rowCol; ?>">

                                        <?php if ( defined( '_LIVE_CHECK_FPA' ) ) { ?>
                                            <div class="col text-center mb-2 d-flex align-self-stretch d-print-none" data-html2canvas-ignore="true">

                                                <?php doFPALIVE(); ?>

                                            </div>
                                        <?php } // end FPA ?>

                                        <?php if ( defined( '_LIVE_CHECK_JOOMLA' ) AND $instance['instanceFOUND'] == _FPA_Y AND extension_loaded('simplexml') ) { ?>
                                            <div class="col text-center mb-2 d-flex align-self-stretch">

                                                <?php
                                                    $thisJVER = @$instance['cmsRELEASE'] .'.' . @$instance['cmsDEVLEVEL'];
                                                    doJOOMLALIVE($thisJVER);
                                                ?>

                                            </div>
                                        <?php } // end Joomla! ?>

                                    </div><!--/.row-->

                                <?php } // end FPA & Joomla! LiveChecks ?>

                                <?php
                                    if ( $fpaEXPIRENOTICE ) {  // modified date expiration notice
                                        echo '<div class="border my-1 py-1 text-center bg-white w-100">'. $fpaEXPIRENOTICE .'</div>';
                                    }
                                ?>

                            </div><!--/.col-->
                            <div class="col-md-4 col-lg-4">
                                <?php
                                /**
                                 * confidence rating based on basic environment tests
                                 *
                                 * a quick and dirty visual feedback method to display a score/rating in the confidence that
                                 * Joomla! will run/work based on some basic initial test results
                                 * @RussW added 23/05/2020
                                 *
                                 */

                                /**
                                 * confidenceScore
                                 * scale :
                                 * 0  = danger/no/unknown/unsupported/bad
                                 * 1  = warning/ok/old(minor)/maybe
                                 * 2  = success/yes/latest/good
                                 *
                                 */
                                (float)$confidenceScore = 0;
                                $confidenceResult = array();
                                $confidenceHelp   = array();

                                    // check php handler & phpsuexec
                                    if (substr($phpenv['phpAPI'], 0, 3) == 'cgi' OR $phpenv['phpAPI'] != 'apache2handler') {
                                        $confidenceResult['PHP API'] = 2;

                                    } elseif ($phpenv['phpAPI'] == 'apache2handler') {
                                        $confidenceResult['PHP API'] = 1;

                                        if ($phpenv['phpPHPSUEXEC'] == _FPA_Y) {
                                            $confidenceResult['phpPHPSUEXEC'] = 2;

                                        } elseif ($phpenv['phpPHPSUEXEC'] == _FPA_N) {
                                            $confidenceResult['PHPsuExec available'] = 1;

                                        } else {
                                            $confidenceResult['PHPsuExec available'] = 0;
                                        }

                                    } else {
                                        $confidenceResult['PHP API'] = 0;
                                    }

                                    // check apache suexec
                                    if ($phpenv['phpAPACHESUEXEC'] == _FPA_Y) {
                                        $confidenceResult['Apache suExec available'] = 2;

                                    } elseif (substr($phpenv['phpAPI'], 0, 4) == 'lite') {
                                        $confidenceResult['Server suExec available'] = 1;

                                    } else {
                                        $confidenceResult['Server suExec available'] = 0;
                                    }

                                    // check for UTF8 support
                                    if (array_key_exists( 'mbstring', $phpextensions )) {
                                        $confidenceResult['PHP mbstring available'] = 2;
                                    } else {
                                        $confidenceResult['PHP mbstring available'] = 1;
                                    }

                                    // check for compression extensions
                                    if (array_key_exists( 'zip', $phpextensions ) OR array_key_exists( 'zlib', $phpextensions ) OR array_key_exists( 'bz2', $phpextensions )) {
                                        $confidenceResult['PHP zip, zlib or bz2 available'] = 2;
                                    } else {
                                        $confidenceResult['PHP zip, zlib or bz2 available'] = 1;
                                    }

                                    // check for encryption extensions
                                    if (array_key_exists( 'mcrypt', $phpextensions ) OR array_key_exists( 'sodium', $phpextensions )) {
                                        $confidenceResult['PHP mcrypt or sodium available'] = 2;
                                    } else {
                                        $confidenceResult['PHP mcrypt or sodium available'] = 1;
                                    }

                                    // check for cURL extensions
                                    if (array_key_exists( 'curl', $phpextensions ) OR array_key_exists( 'sodium', $phpextensions )) {
                                        $confidenceResult['PHP cURL available'] = 2;
                                    } else {
                                        $confidenceResult['PHP cURL available'] = 1;
                                    }

                                    // check for XML extensions
                                    if (array_key_exists( 'xml', $phpextensions ) OR array_key_exists( 'libxml', $phpextensions )) {
                                        $confidenceResult['PHP xml or libxml available'] = 2;
                                    } else {
                                        $confidenceResult['PHP xml or libxml available'] = 1;
                                    }

                                    // check for database support
                                    if ($snapshot['phpSUP4MYSQL'] == _FPA_Y OR $snapshot['phpSUP4MYSQL-i'] == _FPA_Y) {
                                        $confidenceResult[_FPA_SUPPHP .' MySQL or MySQLi'] = 2;

                                    } else {
                                        $confidenceResult[_FPA_SUPPHP .' MySQL or MySQLi'] = 0;
                                    }

                                    // check for bad php versions
                                    if ($snapshot['buggyPHP'] == _FPA_N) {
                                        $confidenceResult[_FPA_BADPHP] = 2;

                                    } else {
                                        $confidenceResult[_FPA_BADPHP] = 0;
                                    }

                                    // check bad zend versions
                                    if ($snapshot['buggyZEND'] == _FPA_N) {
                                        $confidenceResult[_FPA_BADZND] = 2;

                                    } else {
                                        $confidenceResult[_FPA_BADZND] = 0;
                                    }

                                    // check if php sessionpath writable
                                    if ($phpenv['phpSESSIONPATHWRITABLE'] == _FPA_Y) {
                                        $confidenceResult['PHP Session Path '. _FPA_WRITABLE] = 2;

                                    } else {
                                        $confidenceResult['PHP Session Path '. _FPA_WRITABLE] = 0;
                                    }

                                    // check if system tmp is writable
                                    if ($system['sysTMPDIRWRITABLE'] == _FPA_Y) {
                                        $confidenceResult[_FPA_SERV .' Tmp '. _FPA_WRITABLE] = 2;

                                    } else {
                                        $confidenceResult[_FPA_SERV .' Tmp '. _FPA_WRITABLE] = 0;
                                    }


                                    // only test these items if instance is found (installed or not)
                                    if ($instance['instanceFOUND'] == _FPA_Y) {

                                        // does php support J! version
                                        if ($snapshot['phpSUP4J'] == _FPA_Y) {
                                            $confidenceResult[_FPA_SUPPHP .' J! '. @$instance['cmsRELEASE'] .'.' . @$instance['cmsDEVLEVEL'] .' <small>(PHP '. PHP_VERSION .')</small>'] = 2;

                                        } elseif ($snapshot['phpSUP4J'] == _FPA_M) {
                                                $confidenceResult[_FPA_SUPPHP .' J! '. @$instance['cmsRELEASE'] .'.' . @$instance['cmsDEVLEVEL'] .' <small>(PHP '. PHP_VERSION .')</small>'] = 1;

                                        } else {
                                            $confidenceResult[_FPA_SUPPHP .' J! '. @$instance['cmsRELEASE'] .'.' . @$instance['cmsDEVLEVEL'] .' <small>(PHP v'. PHP_VERSION .')</small>'] = 0;
                                        }

                                        // does db support J! version
                                        if ($snapshot['sqlSUP4J'] == _FPA_Y) {
                                            $confidenceResult[_FPA_SUPSQL .' J! '. @$instance['cmsRELEASE'] .'.' . @$instance['cmsDEVLEVEL']] = 2;

                                        } elseif ($snapshot['sqlSUP4J'] == _FPA_M) {
                                            $confidenceResult[_FPA_SUPSQL .' J! '. @$instance['cmsRELEASE'] .'.' . @$instance['cmsDEVLEVEL']] = 1;

                                        } else {
                                            $confidenceResult[_FPA_SUPSQL .' J! '. @$instance['cmsRELEASE'] .'.' . @$instance['cmsDEVLEVEL']] = 0;
                                        }

                                    } // end instandFOUND checks


                                    // nothing to change here if adding new confidence results (auto counts & calculates)
                                    $countConfidence = count($confidenceResult)*2;
                                    $confidenceScore = (array_sum($confidenceResult) / $countConfidence)*100;


                                    /**
                                     * showstoppers & belt 'n' braces
                                     *
                                     * if guaranteed to break Joomla!, definately unsupported, any of the following criteria
                                     * are met or if score result is not numeric or a positive number between 0-100, force
                                     * $confidenceScore to 0(zero)/F
                                     *
                                     */

                                    // unsupported minimum PHP version
                                    if (version_compare( PHP_VERSION, '5', '<' ))  {
                                        $confidenceScore = 0;
                                    }

                                    // mysql or php does not support installed Joomla! version
                                    if ($instance['instanceFOUND'] == _FPA_Y AND ($snapshot['phpSUP4J'] == _FPA_NO OR $snapshot['sqlSUP4J'] == _FPA_NO)) {
                                        $confidenceScore = 0;
                                    }

                                    // bad score result
                                    if (!is_numeric($confidenceScore) OR $confidenceScore < 0) {
                                        $confidenceScore = 0;
                                    }

                                    /**
                                     * set the $confidenceHelp icon colour
                                     *
                                     * we limit the colours use for the help icon and don't use the $confidenceScore colour scheme
                                     * so that it is more generic and will change the icon only within larger score variations.
                                     *
                                     * the colour changes are purely a visual method of informing the user that some audit tests
                                     * do not equal 2 (top score) and may need review (via the help icon button/panel)
                                     *
                                     * 0 - 25.000 (F rated) = danger
                                     * 25.001 - 99.999 (E, D, C, B & A rated) = warning
                                     * 100 (A+ rated) = info (default)
                                     *
                                     */
                                    if ($confidenceScore == 100) {
                                        $helpIconColor = 'info';

                                    } elseif ($confidenceScore == 0 OR $confidenceScore <= 25) {
                                        $helpIconColor = 'danger';

                                    } elseif ($confidenceScore > 40 OR $confidenceScore < 100) {
                                        $helpIconColor = 'warning';

                                    } else {
                                        $helpIconColor = 'info';
                                    }

                                    /**
                                     * generate a formated audit results table
                                     * displayed in the confidenceResult Help collapsable
                                     *
                                     * @param array $confidenceResult
                                     * @return $confidenceHelp
                                     */
                                    function confidenceShowHelp(array $confidenceResult) {

                                        echo '<table class="table table-striped table-bordered table-sm">';
                                        foreach ($confidenceResult as $confidenceHelpDesc => $confidenceHelpScore) {
                                            if ($confidenceHelpScore == 2) {
                                                $helpIcon  = 'check-circle';
                                                $helpColor = 'success';
                                            } elseif ($confidenceHelpScore == 1) {
                                                $helpIcon  = 'info-circle';
                                                $helpColor = 'info';
                                            } elseif ($confidenceHelpScore == 0) {
                                                $helpIcon  = 'times-circle';
                                                $helpColor = 'danger';
                                            } else {
                                                $helpIcon  = 'question-circle';
                                                $helpColor = 'light';
                                            }
                                            echo '<tr><td class="col-8">'. $confidenceHelpDesc .'</td><td class="col-4"><i class="fas fa-'. $helpIcon .' text-'. $helpColor .'"></i></td></tr>';
                                        }
                                        echo '</table>';

                                        return $confidenceResult;
                                    }
                                ?>
                                <div class="mx-lg-3">
                                    <div class="bg-white shadow text-center">
                                        <div class="m-2 float-right" data-toggle="popover" data-trigger="hover" data-placement="top" data-fallbackPlacement="flip" data-title="Confidence Audit Help" data-content="Click the icon to review the basic audit tests and results that determine this rating">
                                            <i class="fas fa-question-circle fa-lg text-<?php echo $helpIconColor; ?>" data-toggle="collapse" data-target="#confidenceHelp" aria-expanded="false" aria-controls="confidenceHelp" role="button" aria-label="View confidence results"></i>
                                        </div>
                                        <h2 class="h4 text-dark text-center border-bottom p-2"><?php echo _FPA_DASHBOARD_CONFIDENCE_TITLE; ?></h2>

                                        <div class="collapse text-left p-2" id="confidenceHelp">
                                            <h3 class="h6 text-center pb-2 m-0">Basic Audit Results</h3>
                                            <?php $confidenceHelp = confidenceShowHelp($confidenceResult); ?>
                                        </div>

                                        <?php
                                            /**
                                             * generate confidence rating
                                             * based on $confidenceScore
                                             * A - F & messaging
                                             *
                                             */
                                            if ($confidenceScore > 100 OR $confidenceScore < 0) {
                                                $confidenceRating = '<i class="fas fa-question-circle text-light"></i>';
                                                $confidenceColor  = 'muted';
                                                $confidenceMessage = _FPA_U;

                                            } elseif ($confidenceScore >= 0 AND $confidenceScore <= 25) {
                                                $confidenceRating  = 'F';
                                                $confidenceColor   = 'danger';
                                                $confidenceMessage = _FPA_CNF_F;

                                            } elseif ($confidenceScore <= 40) {
                                                $confidenceRating  = 'E';
                                                $confidenceColor   = 'warning';
                                                $confidenceMessage = _FPA_CNF_E;

                                            } elseif ($confidenceScore <= 60) {
                                                $confidenceRating  = 'D';
                                                $confidenceColor   = 'warning';
                                                $confidenceMessage = _FPA_CNF_D;

                                            } elseif ($confidenceScore <= 75) {
                                                $confidenceRating  = 'C';
                                                $confidenceColor   = 'info';
                                                $confidenceMessage = _FPA_CNF_C;

                                            } elseif ($confidenceScore <= 90) {
                                                $confidenceRating  = 'B';
                                                $confidenceColor   = 'primary';
                                                $confidenceMessage = _FPA_CNF_B;

                                            } elseif ($confidenceScore < 100) {
                                                $confidenceRating  = 'A';
                                                $confidenceColor   = 'success';
                                                $confidenceMessage = _FPA_CNF_A;

                                            } elseif ($confidenceScore == 100) {
                                                $confidenceRating  = 'A+';
                                                $confidenceColor   = 'success';
                                                $confidenceMessage = _FPA_CNF_A;

                                            } else { // catch-all
                                                $confidenceRating  = '<i class="fas fa-question-circle text-light"></i>';
                                                $confidenceColor   = 'muted';
                                                $confidenceMessage = _FPA_U;
                                            }
                                        ?>
                                        <h2 class="text-center display-2 text-<?php echo $confidenceColor; ?> mb-0"><strong><?php echo $confidenceRating; ?></strong></h2>
                                        <span class="badge badge-pill badge-light text-dark <?php echo $confidenceColor; ?> mx-auto position-relative" style="top:-15px;"><?php echo number_format($confidenceScore, 1); ?>%</span>
                                        <?php if ($confidenceMessage) { ?>
                                            <p class="xsmall text-center border-top bg-white text-<?php echo $confidenceColor; ?> p-2 mb-2"><?php echo $confidenceMessage; ?></p>
                                        <?php } ?>
                                    </div>
                                    <?php showDev( $confidenceResult ); ?>

                                    <!--generate basic post-->
                                    <input type="hidden" name="doIT" value="1" />
                                    <input type="submit" class="btn btn-success btn-block shadow-sm my-2 d-print-none" data-html2canvas-ignore="true" name="submit" value="<?php echo _FPA_CLICK; ?>" accesskey="g" />

                                    <!-- access the FPA optionPanels -->
                                    <a class="d-block btn btn-outline-primary mb-1 d-print-none" data-html2canvas-ignore="true" role="button" href="javascript:toggleFPA('fpaOptions','fpaButton');" id="fpaButton" accesskey="o"><i class="fas fa-chevron-circle-right"></i> Open the FPA Options</a>

                                </div>

                            </div><!--/.col-->
                        </div><!--/.row-->

                    </div><!--/.container-->
                </section>



                <?php
                /**
                 * fpa settings & post output section
                 *
                 */
                ?>
                <section class="border-top d-print-none" data-html2canvas-ignore="true" id="post-form">

                    <div class="container mb-2">

                        <div id="fpaOptions" style="display: none;">
                            <div class="row mt-5">
                                <div class="col-lg-6 mb-4 d-flex">

                                    <div class="card border align-items-stretch text-dark w-100 optionPanel">
                                        <div class="card-body">
                                            <h2 class="h5 text-info"><i class="fas fa-question-circle"></i> <?php echo _FPA_INSTRUCTIONS;  ?></h2>
                                            <?php
                                                echo '<ol>';
                                                echo '<li class="text-muted py-1">'. _FPA_INS_1 .'</li>';
                                                echo '<li class="text-muted py-1">'. _FPA_INS_2 .'</li>';
                                                echo '<li class="text-muted py-1">'. _FPA_INS_3 .'</li>';
                                                echo '<li class="text-muted py-1">'. _FPA_INS_4 .'</li>';
                                                echo '<li class="py-1">'. _FPA_INS_5 .'</li>';
                                                echo '<li class="py-1">'. _FPA_INS_6 .'</li>';
                                                echo '</ol>';
                                            ?>
                                        </div>
                                    </div><!--/.card-->

                                </div>
                                <div class="col-lg-6 mb-4 d-flex">

                                    <div class="card border align-items-stretch text-muted w-100 optionPanel">
                                        <div class="card-body">
                                            <h3 class="h5 text-muted mb-0"><i class="fas fa-info-circle"></i> Optional Information</h3>
                                            <span class="xsmall"><?php  echo _FPA_POST_NOTE; ?></span>

                                            <div class="form-group row mt-3">
                                                <label for="probDSC" class="col-md-4 col-form-label small"><?php echo _FPA_PROB_DSC; ?>:</label>
                                                <div class="col-md-8">
                                                    <input class="form-control form-control-sm bg-light" type="text" name="probDSC" id="probDSC" />
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label for="probMSG1" class="col-md-4 col-form-label small"><?php echo _FPA_PROB_MSG; ?>:</label>
                                                <div class="col-md-8">
                                                    <input class="form-control form-control-sm bg-light" type="text" name="probMSG1" id="probMSG1" />
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <?php if ( isset($phpenv['phpLASTERR']) ) { ?>
                                                    <label for="probMSG2" class="col-md-4 col-form-label small text-warning"><?php echo _FPA_LAST .' '. _FPA_ER; ?>:</label>
                                                    <div class="col-md-8">
                                                        <input class="form-control form-control-sm bg-light text-warning" type="text" name="probMSG2" id="probMSG2" value="<?php echo $phpenv['phpLASTERR']; ?>" aria-describedby="lastErrorHelp" />
                                                        <small id="lastErrorHelp" class="form-text text-muted text-right xsmall">auto-completed from your php error log</small>
                                                    </div>
                                                <?php } else { ?>
                                                    <label for="probMSG2" class="col-md-4 col-form-label small"><?php echo _FPA_PROB_MSG; ?>:</label>
                                                    <div class="col-md-8">
                                                        <input class="form-control form-control-sm bg-light" type="text" name="probMSG2" id="probMSG2" />
                                                    </div>
                                                <?php } ?>
                                            </div>

                                            <div class="form-group row">
                                                <label for="probACT" class="col-md-4 col-form-label small"><?php echo _FPA_PROB_ACT; ?>:</label>
                                                <div class="col-md-8">
                                                    <textarea class="form-control form-control-sm bg-light" name="probACT" id="probACT" rows="2"></textarea>
                                                </div>
                                            </div>

                                        </div>
                                    </div><!--/.card-->

                                </div>
                                <div class="col-lg-6 mb-4 d-flex">

                                    <div class="card border align-items-stretch w-100 optionPanel">
                                        <div class="card-body">
                                            <h2 class="h5 text-primary"><i class="fas fa-running"></i> Run-Time Options</h2>

                                            <div class="row">
                                                <div class="col-sm-7 text-dark mb-3">

                                                <?php
                                                    if ( @$_POST['showElevated'] == 0 AND  @$_POST['doIT'] == 1  ) {
                                                        $selectshowElevated = '';
                                                    } else {
                                                        $selectshowElevated = 'CHECKED'; // changed to checked - Phil - 4-20-12
                                                    }

                                                    if ( @$_POST['showTables'] == 0 AND  @$_POST['doIT'] == 1  ) {
                                                        $selectshowTables = '';
                                                    } else {
                                                        $selectshowTables = 'CHECKED';
                                                    }

                                                    if ( @$_POST['showComponents'] == 0 AND  @$_POST['doIT'] == 1  ) {
                                                        $selectshowComponents = '';
                                                    } else {
                                                        $selectshowComponents = 'CHECKED'; // changed to checked - Phil - 4-20-12
                                                    }

                                                    if ( @$_POST['showModules'] == 0 AND  @$_POST['doIT'] == 1  ) {
                                                        $selectshowModules = '';
                                                    } else {
                                                        $selectshowModules = 'CHECKED'; // changed to checked - Phil - 4-20-12
                                                    }

                                                    if ( @$_POST['showLibraries'] == 0 AND  @$_POST['doIT'] == 1  ) {
                                                        $selectshowLibraries = '';
                                                    } else {
                                                        $selectshowLibraries = 'CHECKED';
                                                    }

                                                    if ( @$_POST['showPlugins'] == 0 AND  @$_POST['doIT'] == 1  ) {
                                                        $selectshowPlugins = '';
                                                    } else {
                                                        $selectshowPlugins = 'CHECKED'; // changed to checked - Phil - 4-20-12
                                                    }
                                                    if ( @$_POST['showCoreEx'] == 0 AND  @$_POST['doIT'] == 1 ) {
                                                        $selectshowCoreEx = '';
                                                    } else {
                                                        $selectshowCoreEx = 'CHECKED';
                                                    }
                                                    if ( $instance['instanceFOUND'] != _FPA_Y ) {
                                                        $dis = 'DISABLED';

                                                    } else {
                                                        $dis = '';
                                                    }
                                                    ?>

                                                    <h3 class="h6 text-muted mb-0"><?php echo _FPA_OPT .' '. $dis; ?>:</h3>

                                                    <div class="form-check">
                                                        <input <?php echo $dis; ?> class="form-check-input" type="checkbox" name="showElevated" id="showElevatedCheck" value="1" <?php echo $selectshowElevated; ?> />
                                                        <label class="form-check-label mt-1" for="showElevatedCheck"><?php echo _FPA_SHOWELV; ?></label>
                                                    </div>

                                                    <div class="form-check">
                                                        <input <?php echo $dis; ?> class="form-check-input" type="checkbox" name="showTables" id="showTablesCheck" value="1" <?php echo $selectshowTables; ?> />
                                                        <label class="form-check-label mt-1" for="showTablesCheck"><?php echo _FPA_SHOWDBT; ?></label>
                                                    </div>

                                                    <div class="form-check">
                                                        <input <?php echo $dis; ?> class="form-check-input" type="checkbox" name="showComponents" id="showComponentsCheck" value="1" <?php echo $selectshowComponents; ?> />
                                                        <label class="form-check-label mt-1" for="showComponentsCheck"><?php echo _FPA_SHOWCOM; ?></label>
                                                    </div>

                                                    <div class="form-check">
                                                        <input <?php echo $dis; ?> class="form-check-input" type="checkbox" name="showModules" id="showModulesCheck" value="1" <?php echo $selectshowModules; ?> />
                                                        <label class="form-check-label mt-1" for="showModulesCheck"><?php echo _FPA_SHOWMOD; ?></label>
                                                    </div>

                                                    <div class="form-check">
                                                        <input <?php echo $dis; ?> class="form-check-input" type="checkbox" name="showLibraries" id="showLibrariesCheck" value="1" <?php echo $selectshowLibraries; ?> />
                                                        <label class="form-check-label mt-1" for="showLibrariesCheck"><?php echo _FPA_SHOWLIB; ?></label>
                                                    </div>

                                                    <div class="form-check">
                                                        <input <?php echo $dis; ?> class="form-check-input" type="checkbox" name="showPlugins" id="showPluginsCheck" value="1" <?php echo $selectshowPlugins; ?> />
                                                        <label class="form-check-label mt-1" for="showPluginsCheck"><?php echo _FPA_SHOWPLG; ?></label>
                                                    </div>

                                                    <div class="form-check">
                                                        <input <?php echo $dis; ?> class="form-check-input" type="checkbox" name="showCoreEx" id="showCoreExCheck" value="1" <?php echo $selectshowCoreEx; ?> />
                                                        <label class="form-check-label mt-1" for="showCoreExCheck"><?php echo _FPA_SHOWCEX; ?></label>
                                                    </div>

                                                </div>
                                                <div class="col-sm-5 text-dark mb-3">

                                                <?php
//                                                    if ( $showProtected == 2 OR @$_POST['showProtected'] == 2 ) {
                                                    if ( $showProtected == 1 OR @$_POST['showProtected'] == 1 ) {
                                                        $selectshowProtected_1 = '';
                                                        $selectshowProtected_2 = 'CHECKED';

//                                                    } elseif ( $showProtected == 1 OR @$_POST['showProtected'] == 1 ) {
//                                                        $selectshowProtected_1 = 'CHECKED';
//                                                        $selectshowProtected_2 = '';

//                                                    } elseif ( $showProtected == 2 ) {
//                                                        $selectshowProtected_1 = '';
//                                                        $selectshowProtected_2 = 'CHECKED';

                                                    } else {
                                                        $selectshowProtected_1 = 'CHECKED';
                                                        $selectshowProtected_2 = '';
//                                                        $selectshowProtected_1 = '';
//                                                        $selectshowProtected_2 = 'CHECKED';
                                                    }
                                                ?>

                                                    <h3 class="h6 text-muted mb-0">Information Privacy :</h3>

                                                    <fieldset>
                                                        <div class="form-check mb-1">
                                                            <input class="form-check-input" type="radio" name="showProtected" id="showProtected1" value="1" <?php echo $selectshowProtected_1; ?> aria-describedby="privacyNoHelp" />
                                                            <label class="form-check-label mt-1" for="showProtected1"><?php echo _FPA_PRIVNON .'<small class="text-success">('. _FPA_DEF .')</small>'; ?></label>
                                                            <small id="privacyNoHelp" class="form-text text-muted"><?php echo _FPA_PRIVNONNOTE; ?></small>
                                                        </div>

                                                        <div class="form-check">
                                                            <input class="form-check-input" type="radio" name="showProtected" id="showProtected2" value="2" <?php echo $selectshowProtected_2; ?> aria-describedby="privacyPartialHelp" />
                                                            <label class="form-check-label mt-1" for="showProtected2"><?php echo _FPA_PRIVPAR .' <!--<small class="text-success">('. _FPA_DEF .')</small>-->'; ?></label>
                                                            <small id="privacyPartialHelp" class="form-text text-muted"><?php echo _FPA_PRIVPARNOTE; ?></small>
                                                        </div>
                                                    </fieldset>

                                                </div>
                                            </div><!--/.row-->

                                        </div>
                                    </div><!--/.card-->

                                </div>
                                <div class="col-lg-6 mb-4 d-flex">

                                    <div class="card border shadow align-items-stretch w-100 optionPanel">
                                        <div class="card-header text-uppercase text-center small">
                                            <?php echo _FPA_INS_5; ?>
                                        </div>
                                        <div class="card-body">

                                            <!-- Generate the diagnostic post output -->
                                            <div class="py-3">
                                                <input type="hidden" name="doIT" value="1" />

                                                <input type="submit" class="btn btn-success btn-lg btn-block w-75 mx-auto shadow-sm" name="submit" value="<?php echo _FPA_CLICK; ?>" accesskey="g" />

                                                <input type="reset" class="btn btn-light btn-sm btn-block w-25 mx-auto" name="reset" value="reset" />
                                            </div>


                                            <?php
                                                if ( @$_POST['increasePOPS'] ) {
                                                    $selectPOPS = 'CHECKED';
                                                } else {
                                                    $selectPOPS = '';
                                                }
                                            ?>
                                            <!-- // !TODO make this more robust across multiple server configs -->
                                            <div class="form-check pt-3">
                                                <input class="form-check-input" type="checkbox" name="increasePOPS" id="showIncreasePOPSCheck" value="1" <?php echo $selectPOPS; ?> aria-describedby="popsHelp" />
                                                <label class="form-check-label mt-1" for="showIncreasePOPSCheck">PHP &quot;<span class="text-warning"><?php echo _FPA_OUTMEM; ?></span>&quot; <?php echo _FPA_OR; ?> &quot;<span class="text-warning"><?php echo _FPA_OUTTIM; ?></span>&quot; <?php echo _FPA_ERRS; ?>?</label>
                                                <small id="popsHelp" class="form-text text-muted xsmall"><?php echo _FPA_INCPOPS; ?></small>
                                            </div>

                                        </div>
                                    </div><!--/.card-->

                                </div>
                            </div><!--/.row-->
                        </div><!--/fpaOptions-->


                        <?php if ( @$_POST['doIT'] == '1' ) { ?>
                            <!-- post instructions and output -->
                            <div class="row mt-5">
                                <div class="col-lg-6 mb-4 d-flex">

                                    <div class="border border-info text-dark bg-white p-3 align-items-stretch w-100">
                                        <h2 class="h5 text-info"><i class="fas fa-question-circle"></i> <?php echo _FPA_INSTRUCTIONS;  ?></h2>
                                        <?php echo _FPA_INS_7; ?>
                                    </div>

                                </div><!--/.col-->
                                <div class="col-lg-6 mb-4 d-flex">

                                    <div class="border border-dark bg-white shadow p-3 align-items-stretch w-100">
                                        <h5 class="text-center text-uppercase"><?php echo _FPA_POSTD; ?></h5>
                                        <div id="postCharCount"></div>

                                            <?php
                                            /** LOAD UP THE SELECTED CONFIGURATION AND DIAGNOSTIC INFORMATION FOR THE POST
                                             * this section loads up a text-box with BBCode for the forum, it will quote each section
                                             * to make viewing easier and once used to the format, hopefully making it simpler to
                                             * pinpoint related information quickly
                                             *
                                             * the user then copies and pastes this outputin to forum post
                                             *
                                             * many "if/then/else" statements have been placed in single lines for ease of management,
                                             * this looks ugly and goes against coding practices but *shrug*, it's messy otherwise
                                             *
                                             * NOTE IF MODIFYING: carriage returns and line breaks MUST be double-quoted, not single-
                                             * quote, hence some of the weird quoting and formating
                                             */
                                            ?>

                                            <?php
                                            /**
                                             * BBCode for the Joomla! Forum
                                             */

                                            echo '<textarea class="1protected xsmall text-dark w-100 border bg-light p-1" type="text" rows="10" name="postOUTPUT" id="postOUTPUT">';
                                            echo '[quote="'. _RES .' (v'. _RES_VERSION .') : '. @date( 'j-M-Y' ) .'"]';

                                            if ( $_POST['probDSC'] ) { echo '[quote="'. _FPA_PROB_DSC .' :: "][size=85]'. $_POST['probDSC'] .' [/size][/quote]'; }

                                            if ( $_POST['probMSG1'] ) { echo '[quote="'. _FPA_PROB_MSG .' :: "][size=85]'. $_POST['probMSG1'] .'[/size][/quote]'; }

                                            if ( $phpenv['phpLASTERR'] AND $_POST['probMSG2'] ) { echo '[quote="'. _FPA_LAST .' PHP '. _FPA_ER .' :: "][size=85][color=#800000]'. $_POST['probMSG2'] .'[/color][/size][/quote]';
                                            } elseif ( !@$phpenv['phpLASTERROR'] AND $_POST['probMSG2'] ) { echo '[quote="'. _FPA_PROB_MSG .' :: "][size=85]'. $_POST['probMSG2'] .'[/size][/quote]'; }

                                            if ( $_POST['probACT'] ) { echo '[quote="'. _FPA_PROB_ACT .' "][size=85]'. $_POST['probACT'] .'[/size][/quote]'; }

                                            // do the basic information
                                            echo '[quote="'. _FPA_BASIC .' '. _FPA_ENVIRO .' ::"][size=85]';

                                            // Joomla! cms details
                                            echo '[b]'. _FPA_APP .' '. _FPA_INSTANCE.' :: [/b]';
                                            if ( $instance['instanceFOUND'] == _FPA_Y ) { echo '[color=Blue]'. $instance['cmsPRODUCT'] .' [b]'. $instance['cmsRELEASE'] .'.'. $instance['cmsDEVLEVEL'] .'[/b]-'. $instance['cmsDEVSTATUS'] .' ('. $instance['cmsCODENAME'] .') '. $instance['cmsRELDATE'] .'[/color]';
                                            } else { echo '[color=orange]'. _FPA_NF .'[/color]'; }

                                            // Multiple version file warning
                                            if ($vFileSum > 1) {
                                            echo "\r\n";
                                            echo '[color=Red][b]' . _FPA_MVFW . '[/b][/color]'; }

                                            // Joomla! platform details
                                            if ( @$instance['platformPRODUCT'] ) {
                                            echo "\r\n";
                                            echo '[b]'. _FPA_APP .' '. _FPA_PLATFORM .' :: [/b] [color=Blue]'. @$instance['platformPRODUCT'] .' [b]'. @$instance['platformRELEASE'] .'.'. @$instance['platformDEVLEVEL'] .'[/b]-'. @$instance['platformDEVSTATUS'] .' ('. @$instance['platformCODENAME'] .') '. @$instance['platformRELDATE'] .'[/color]'; }

                                            echo "\r\n";

                                            echo '[b]'. _FPA_APP .' '. _FPA_YC .' :: [/b]';

                                            if ( $instance['instanceCONFIGURED'] == _FPA_Y ) {
                                                echo '[color=Green]'. _FPA_Y .'[/color] | ';

                                                if ( $instance['configWRITABLE'] == _FPA_Y ) { echo '[color=Green]'. _FPA_WRITABLE .'[/color] ('; } else { echo _FPA_RO .' ('; }

                                                if ( substr( $instance['configMODE'],1 ,1 ) == '7' OR substr( $instance['configMODE'],2 ,1 ) >= '5' OR substr( $instance['configMODE'],3 ,1 ) >= '5' ) { echo '[color=Red]'; } else { echo '[color=Green]'; }
                                                echo $instance['configMODE'] .'[/color]) | ';

                                                if ( @$instance['definesEXIST'] == _FPA_Y ) {
                                                echo   _FPA_DEFI . ' ' . _FPA_E . ' | ';

                                                    if ( @$instance['equalPATH'] == _FPA_N ) {
                                                        echo '[color=Red]'. _FPA_DEFIPA .'[/color]  | ';
                                                    }
                                                }

                                                echo "\r\n";

                                                echo '[b]'. _FPA_CFG .' '. _FPA_OPTS .' :: Offline:[/b] '. $instance['configOFFLINE'] .' | [b]SEF:[/b] '. $instance['configSEF'] .' | [b]SEF Suffix:[/b] '. $instance['configSEFSUFFIX'] .' | [b]SEF ReWrite:[/b] '. $instance['configSEFRWRITE'] .' | ';
                                                echo '[b].htaccess/web.config:[/b] ';

                                                if ( ($instance['configSITEHTWC'] == _FPA_N AND $instance['configSEFRWRITE'] == '1') OR ($instance['configSITEHTWC'] == _FPA_N AND $instance['configSEFRWRITE'] == 'true' )) { echo '[color=orange]'. $instance['configSITEHTWC'] .' (ReWrite Enabled but no .htaccess?)[/color] | ';
                                                } elseif ( $instance['configSITEHTWC'] == _FPA_Y ) { echo '[color=Green]'. $instance['configSITEHTWC'] .'[/color] | ';
                                                } elseif ( $instance['configSITEHTWC'] == _FPA_N ) { echo '[color=orange]'. $instance['configSITEHTWC'] .'[/color] | '; }

                                                echo '[b]GZip:[/b] '. $instance['configGZIP'] .' | [b]Cache:[/b] '. $instance['configCACHING'] .' | [b]CacheTime:[/b] '. $instance['configCACHETIME'] .' | [b]CacheHandler:[/b] '. $instance['configCACHEHANDLER'] .' | [b]CachePlatformPrefix:[/b] '. $instance['configCACHEPLFPFX'] .' | [b]FTP Layer:[/b] '. $instance['configFTP'] .' | [b]Proxy:[/b] '. $instance['configPROXY'] .' | [b]LiveSite:[/b] '. $instance['configLIVESITE'] .' | [b]Session lifetime:[/b] '. $instance['configLIFETIME'] .' | [b]Session handler:[/b] '. $instance['configSESSHAND'] .' | [b]Shared sessions:[/b] '. $instance['configSHASESS'] .' | [b]SSL:[/b] '. $instance['configSSL'] .' | [b]Error Reporting:[/b] '. $instance['configERRORREP'] .' | [b]Site Debug:[/b] '. $instance['configSITEDEBUG'] .' | ';

                                                if ( version_compare( $instance['cmsRELEASE'], '1.5', '>=' ) ) {
                                                    echo '[b]Language Debug:[/b] '. $instance['configLANGDEBUG'] .' | ';
                                                    echo '[b]Default Access:[/b] '. $instance['configACCESS'] .' | [b]Unicode Slugs:[/b] '. $instance['configUNICODE'] .' | [b]dbConnection Type:[/b] '. $instance['configDBTYPE'] .' | ';
                                                }

                                                echo '[b]' . _FPA_SUPPHP .' J! '. @$instance['cmsRELEASE'] .'.' . @$instance['cmsDEVLEVEL'] . ': [/b]' ;

                                                if ( $snapshot['phpSUP4J'] == _FPA_Y ) { echo '[color=Green]'; } else { echo '[color=Red]'; }
                                                echo $snapshot['phpSUP4J'] .'[/color] | ';

                                                echo '[b]' . _FPA_SUPSQL .' J! '. @$instance['cmsRELEASE'] .'.' . @$instance['cmsDEVLEVEL'] . ': [/b]' ;

                                                if ( $snapshot['sqlSUP4J'] == _FPA_Y ) { echo '[color=Green]'; } else { echo '[color=Red]'; }
                                                echo $snapshot['sqlSUP4J'] .'[/color] | ';

                                                echo '[b]'. _FPA_DB .' '. _FPA_CREDPRES .':[/b] ';

                                                if ( $instance['configDBCREDOK'] == _FPA_Y ) { echo '[color=Green]'; } else { echo '[color=Red]'; }
                                                echo $instance['configDBCREDOK'] .'[/color] | ';

                                            } else {

                                                if ( @$instance['definesEXIST'] == _FPA_Y ) {
                                                    echo '[color=orange]'. _FPA_NF .' (' . _FPA_DEFI . ' ' . _FPA_E . ')[/color]';
                                                    if ( @$instance['equalPATH'] == _FPA_N ) {
                                                        echo '[color=Red]'. _FPA_DEFIPA .'[/color] ';
                                                    }
                                                } else {
                                                    echo '[color=orange]'. _FPA_NF .'[/color]';
                                                }

                                            }
                                            echo "\r\n\r\n";

                                            echo '[b]'. _FPA_HOST .' '. _FPA_CFG .' :: OS:[/b] '. $system['sysPLATOS'] .' |  [b]OS '._FPA_VER.':[/b] '. $system['sysPLATREL'] .' | [b]'. _FPA_TEC .':[/b] '. $system['sysPLATTECH'] .' | [b]'. _FPA_WSVR .':[/b] '. $system['sysSERVSIG'] .' | [b]Encoding:[/b] '. $system['sysENCODING'] .' |  [b]'. _FPA_SYS .' TMP '. _FPA_WRITABLE .':[/b] ';
                                            if ( $system['sysTMPDIRWRITABLE'] == _FPA_Y ) { echo '[color=Green]'; } else { echo '[color=Red]'; }
                                            echo $system['sysTMPDIRWRITABLE'] .'[/color] | ';

                                            if ( function_exists( 'disk_free_space' ) ) {
                                                $free_space = sprintf( '%.2f', disk_free_space( './' ) /1073741824 );
                                                $system['sysFREESPACE'] = $free_space .' GiB';
                                                echo '[b]  ' . _FPA_FDSKSP . ' :[/b] ' . $system['sysFREESPACE'] . ' |';
                                            } else {
                                                echo '[b]  ' . _FPA_FDSKSP . ' :[/b] ' . _FPA_U . ' |';
                                            }

                                            echo "\r\n\r\n";

                                            echo '[b]PHP '. _FPA_CFG .' :: '. _FPA_VER .':[/b] ';
                                            if ( version_compare( $phpenv['phpVERSION'], '5.0.0', '<' ) ) { echo '[color=Red]'. $phpenv['phpVERSION'] .'[/color] | '; } else { echo '[b]'. $phpenv['phpVERSION'] .'[/b] | '; }

                                            echo '[b]PHP API:[/b] ';
                                            if ( $phpenv['phpAPI'] == 'apache2handler' ) { echo '[color=orange]'. $phpenv['phpAPI'] .'[/color] | '; } else { echo '[b]'. $phpenv['phpAPI'] .'[/b] | '; }

                                            echo '[b]Session Path '. _FPA_WRITABLE .':[/b] ';
                                            if ( $phpenv['phpSESSIONPATHWRITABLE'] == _FPA_Y ) { echo '[color=Green]'. $phpenv['phpSESSIONPATHWRITABLE'] .'[/color] | '; } elseif ( $phpenv['phpSESSIONPATHWRITABLE'] == _FPA_N ) { echo '[color=Red]'. $phpenv['phpSESSIONPATHWRITABLE'] .'[/color] | '; } else { echo '[color=orange]'. $phpenv['phpSESSIONPATHWRITABLE'] .'[/color] | '; }

                                            echo '[b]Display Errors:[/b] '. $phpenv['phpERRORDISPLAY'] .' | [b]Error Reporting:[/b] '. $phpenv['phpERRORREPORT'] .' | [b]Log Errors To:[/b] '. $phpenv['phpERRLOGFILE'] .' | [b]Last Known Error:[/b] '. @$phpenv['phpLASTERRDATE'] .' | [b]Register Globals:[/b] '. $phpenv['phpREGGLOBAL'] .' | [b]Magic Quotes:[/b] '. $phpenv['phpMAGICQUOTES'] .' | [b]Safe Mode:[/b] '. $phpenv['phpSAFEMODE'] .' | [b]Allow url fopen:[/b] '. $phpenv['phpURLFOPEN'] .' | [b]Open Base:[/b] '. $phpenv['phpOPENBASE'] .' | [b]Uploads:[/b] '. $phpenv['phpUPLOADS'] .' | [b]Max. Upload Size:[/b] '. $phpenv['phpMAXUPSIZE'] .' | [b]Max. POST Size:[/b] '. $phpenv['phpMAXPOSTSIZE'] .' | [b]Max. Input Time:[/b] '. $phpenv['phpMAXINPUTTIME'] .' | [b]Max. Execution Time:[/b] '. $phpenv['phpMAXEXECTIME'] .' | [b]Memory Limit:[/b] '. $phpenv['phpMEMLIMIT'];

                                            echo "\r\n\r\n";

                                            echo '[b]Database '. _FPA_CFG .' :: [/b] ';
                                            if ( @$instance['configDBTYPE'] == 'sqlsrv' ) { echo '[color=brown][b]' . _FPA_MSSQL_SUPP . '[/b][/color]  '; }

                                            if ( $database['dbDOCHECKS'] == _FPA_N AND @$instance['configDBTYPE'] != 'sqlsrv') {
                                                echo '[color=orange]'. _FPA_DB .' '. _FPA_DBCREDINC .'[/color] '. _FPA_NODISPLAY;

                                                echo "\r\n";

                                                if ( @$instance['configDBCREDOK'] != _FPA_Y AND $instance['instanceFOUND'] == _FPA_Y ) {
                                                    echo '[color=Red][b]'. _FPA_MISSINGCRED .': [/b][/color] ';
                                                    if ( @$instance['configDBTYPE'] == '' ) { echo '[color=orange][b]Connection Type[/b] missing[/color] | '; }
                                                    if ( @$instance['configDBNAME'] == '' ) { echo '[color=orange][b]Database Name[/b] missing[/color] |'; }
                                                    if ( @$instance['configDBHOST'] == '' ) { echo '[color=orange][b]MySQL Host[/b] missing[/color] | '; }
                                                    if ( @$instance['configDBPREF'] == '' ) { echo '[color=orange][b]Table Prefix[/b] missing[/color] | '; }
                                                    if ( @$instance['configDBUSER'] == '' ) { echo '[color=orange][b]Database Username[/b] missing[/color] | '; }
                                                    if ( @$instance['configDBPASS'] == '' ) { echo '[color=orange][b]Database Password[/b] missing[/color] |'; }
                                                }


                                            } elseif ( @$database['dbERROR'] != _FPA_N AND @$instance['configDBTYPE'] != 'sqlsrv') {
                                                echo '[color=Red][b]'. _FPA_ECON .':[/b] ';
                                                echo  @$database['dbERROR'] .'[/color]' ;
                                            } elseif (@$instance['configDBTYPE'] != 'sqlsrv') {
                                                echo '[b]'. _FPA_VER .':[/b] [b]'. $database['dbHOSTSERV'] .'[/b] (Client:'. $database['dbHOSTCLIENT'] .') | ';
                                                echo '[b]'. _FPA_DB .' '. _FPA_TSIZ .':[/b] '. $database['dbSIZE'] .' | [b]'. _FPA_CONF_PREF_TABLE . ':&nbsp[/b] '. $confPrefTables . ' | [b]'. _FPA_OTHER_TABLE . ':&nbsp[/b] '. $notconfPrefTables ;
                                            }

                                            echo '[/size][/quote]';

                                            // do detailed information
                                            echo '[quote="'. _FPA_DETAILED .' '. _FPA_ENVIRO .' ::"][size=85]';

                                            echo '[b]'. _FPA_PHPEXT_TITLE .' :: [/b]';

                                            foreach ( $phpextensions as $key => $show ) {

                                                if ( $show != $phpextensions['ARRNAME'] ) {
                                                    // find the requirements and mark them as present or missing
                                                    if ( $key == 'libxml' OR $key == 'xml' OR $key == 'zip' OR $key == 'openssl' OR $key == 'zlib' OR $key == 'curl' OR $key == 'iconv' OR $key == 'mbstring' OR $key == 'mysql' OR $key == 'mysqli' OR $key == 'pdo_mysql' OR $key == 'mcrypt' OR $key == 'suhosin' OR $key == 'cgi' OR $key == 'cgi-fcgi' ) {
                                                        echo '[color=Green][b]'. $key .'[/b][/color] ('. $show .') | ';
                                                    } elseif ( $key == 'apache2handler' ) {
                                                        echo '[color=orange]'. $key .'[/color] ('. $show .') | ';
                                                    } else {
                                                        echo $key .' ('. $show .') | ';
                                                    }

                                                } // endif !arrname

                                                if ( !in_array( $key, $phpreq ) ) {
                                                    unset ( $phpreq[$key] );
                                                }

                                            }

                                            if ( version_compare( $instance['cmsRELEASE'], '3.8', '>=') OR version_compare( $phpenv['phpVERSION'], '7.2.0', '>=' ))   {
                                                unset($phpreq['mcrypt']);
                                            }

                                            if (version_compare( $phpenv['phpVERSION'], '7.0.0', '>=' ))   {
                                                unset($phpreq['mysql']);
                                            }

                                            echo "\r\n";
                                            echo '[b]'. _FPA_POTME .' :: [/b]';
                                            foreach ( $phpreq as $missingkey => $missing ) {
                                                echo '[color=orange]'. $missingkey .'[/color] | ';
                                            }

                                            // disabled PHP functions
                                            if ( $phpenv['phpDISABLED'] ) {
                                                echo "\r\n";
                                                echo '[b]'. _FPA_DI_PHP_FU .' :: [/b]';
                                                $disabledfunctions = explode(",",$phpenv['phpDISABLED']);
                                                $arrlength = count($disabledfunctions);
                                                for ($x = 0; $x < $arrlength; $x++) {
                                                    echo  $disabledfunctions[$x] .' | ';
                                                }
                                            }

                                            echo "\r\n\r\n";
                                            echo '[b]Switch User '. _FPA_ENVIRO .'[/b] [i](Experimental)[/i][b] :: PHP CGI:[/b] '. $phpenv['phpCGI'] .' | [b]Server SU:[/b] '. $phpenv['phpAPACHESUEXEC'] .' |  [b]PHP SU:[/b] '. $phpenv['phpPHPSUEXEC'] .' |   [b]Custom SU (LiteSpeed/Cloud/Grid):[/b] '. $phpenv['phpCUSTOMSU'];
                                            echo "\r\n";
                                            echo '[b]'. _FPA_POTOI .':[/b] ';
                                            if ( $phpenv['phpOWNERPROB'] == _FPA_Y ) { echo '[color=Red]'; } elseif ( $phpenv['phpOWNERPROB'] == _FPA_N ) { echo '[color=Green]'; } else { echo '[color=orange]'; }
                                            echo $phpenv['phpOWNERPROB'] .'[/color] ';

                                            // IF APACHE with PHP in Module mode
                                            if ( $phpenv['phpAPI'] == 'apache2handler' ) {
                                                echo "\r\n\r\n";

                                                echo '[b]'. _FPA_APAMOD_TITLE .' :: [/b]';

                                                foreach ( $apachemodules as $key => $show ) {

                                                    if ( $show != $apachemodules['ARRNAME'] ) {

                                                        // find the requirements and mark them as present or missing
                                                        if ( $show == 'mod_rewrite' OR $show == 'mod_cgi' OR $show == 'mod_cgid' OR $show == 'mod_expires' OR $show == 'mod_deflate' OR $show == 'mod_auth'  ) {
                                                            echo '[color=Green][b]'. $show .'[/b][/color] | ';
                                                        } elseif ( $show == 'mod_php4' ) {
                                                            echo '[color=Red]'. $show .'[/color] | ';
                                                        } else {
                                                            echo $show .' | ';
                                                        }

                                                    } // endif !arrname

                                                    if ( !in_array( $show, $apachereq ) ) {
                                                        unset ( $apachereq['ARRNAME'] );
                                                        unset ( $apachereq[$show] );
                                                    }

                                                }

                                                echo "\r\n";
                                                echo '[b]'. _FPA_POTMM .' :: [/b]';
                                                foreach ( $apachereq as $missingkey => $missing ) {
                                                    echo '[color=orange]'. $missingkey .'[/color] | ';
                                                }

                                                echo "\r\n";

                                            } // end if Apache and PHP module

                                            echo '[/size][/quote]';


                                            if ( $instance['instanceFOUND'] == _FPA_Y ) {
                                                echo '[quote="Folder Permissions ::"][size=85]';

                                                echo '[b]'. _FPA_COREDIR_TITLE .' :: [/b]';

                                                    foreach ( $folders as $i => $show ) {

                                                        if ( $show != $folders['ARRNAME'] ) {

                                                            if ( $_POST['showProtected'] == '3' ) {
                                                                echo '[color=orange]--'. _FPA_HIDDEN .'--[/color] (';
                                                            } else {
                                                                echo $show .' (';
                                                            }

                                                            if ( substr( $modecheck[$show]['mode'],1 ,1 ) == '7' OR substr( $modecheck[$show]['mode'],2 ,1 ) == '7' ) {
                                                                echo '[color=Red]'. $modecheck[$show]['mode'] .'[/color]) | ';
                                                            } else {
                                                                echo $modecheck[$show]['mode'] .') | ';
                                                            }

                                                        }

                                                    }


                                                    if ( @$_POST['showElevated'] == '1' ) {
                                                        echo "\r\n\r\n";

                                                        $limitCount = '0';
                                                        echo '[b]'. _FPA_ELEVPERM_TITLE .'[/b] [i]('. _FPA_FIRST .' 10)[/i][b] :: [/b]';

                                                            foreach ( $elevated as $key => $show ) {

                                                                if ( $limitCount >= '11' ) {
                                                                    unset ( $key );
                                                                } else {

                                                                    if ( $show != $elevated['ARRNAME'] ) {

                                                                        if ( $_POST['showProtected'] == '3' ) {
                                                                            echo '[color=orange]--'. _FPA_HIDDEN .'--[/color] (';
                                                                        } else {

                                                                            if ( $key == 'None' ) {
                                                                                echo '[color=Green][b]'. $key .'[/b][/color] ';
                                                                            } else {
                                                                                echo $key .'/ (';
                                                                            }

                                                                        }

                                                                        if ( $key != 'None' ) {

                                                                            if ( substr( $show['mode'],1 ,1 ) == '7' OR substr( $show['mode'],2 ,1 ) == '7' ) {
                                                                                echo '[color=Red]'. $show['mode'] .'[/color]) | ';
                                                                            } else {
                                                                                echo $show['mode'] .') | ';
                                                                            }

                                                                        }

                                                                    }

                                                                }

                                                                $limitCount ++;
                                                            }

                                                    }

                                                    echo '[/size][/quote]';

                                            } // end if InstanceFOUND



                                            // do the Database Statistics and Table information
                                            if ( $database['dbDOCHECKS'] == _FPA_Y AND @$database['dbERROR'] == _FPA_N AND @$_POST['showTables'] == '1' AND $database['dbHOSTINFO'] <> _FPA_U AND $instance['configDBTYPE'] <> 'postgresql' AND $instance['configDBTYPE'] <> 'pgsql' ) {
                                                echo '[quote="Database Information ::"][size=85]';
                                                echo '[b]'. _FPA_DB .' '. _FPA_STATS .' :: [/b]';
                                                foreach ( $database['dbHOSTSTATS'] as $show ) {
                                                    $dbPieces = explode(": ", $show );
                                                    echo '[b]'. $dbPieces[0] .':[/b] '. $dbPieces[1] .' | ';
                                                }
                                                echo '[/size][/quote]';
                                            }


                                            // do the Extensions information
                                            if ( $instance['instanceFOUND'] == _FPA_Y AND ( @$_POST['showComponents'] == '1' OR @$_POST['showModules'] == '1' OR @$_POST['showPlugins'] == '1' ) ) {
                                                echo '[quote="Extensions Discovered ::"][size=85]';

                                                if ( $_POST['showProtected'] == '3' ) {
                                                    echo '[color=orange][b]Strict[/b] Information Privacy was selected.[/color] Nothing to display.';
                                                    echo '[/size][/quote]';
                                                } else {

                                                    if ( @$_POST['showComponents'] == '1' ) {
                                                        echo '[b]'. _FPA_EXTCOM_TITLE .' :: '. _FPA_SITE .' :: [/b]';
                                                        if ( $showCoreEx == 1) {
                                                            echo "\r\n";
                                                            echo '[b] ' . _FPA_JCORE . ' :: [/b][color=Blue]';
                                                            if ( isset ($component['SITE'])) {
                                                                foreach ( $component['SITE'] as $key => $show ) {
                                                                    if (isset($exset[0]['name'])) {
                                                                        $extarrkey = recursive_array_search($show['name'], $exset);
                                                                            if ($extarrkey  !== False) {
                                                                                $extenabled = $exset[$extarrkey]['enabled'];
                                                                            } else { $extenabled = '?' ;}
                                                                    } else { $extenabled = '?' ;}
                                                                        if ($extenabled <> 0 AND $extenabled <> 1 ){
                                                                            $extenabled = '?';
                                                                        }
                                                                        if ( $show['type'] == _FPA_JCORE) {
                                                                            echo  $show['name'] .' ('. $show['version'] .')  '.$extenabled.' | ';
                                                                        }
                                                                }
                                                            }
                                                            echo '[/color]';
                                                        }
                                                        echo "\r\n";
                                                        echo '[b]' .  _FPA_3PD . ':: [/b][color=Brown]';
                                                        if ( isset ($component['SITE'])) {
                                                            foreach ( $component['SITE'] as $key => $show ) {
                                                                if (isset($exset[0]['name'])) {
                                                                    $extarrkey = recursive_array_search($show['name'], $exset);
                                                                        if ($extarrkey  !== False) {
                                                                            $extenabled = $exset[$extarrkey]['enabled'];
                                                                        } else { $extenabled = '?'; }
                                                                } else { $extenabled = '?'; }
                                                                if ($extenabled <> 0 AND $extenabled <> 1 ) {
                                                                    $extenabled = '?';
                                                                }
                                                                if ( $show['type'] == _FPA_3PD){
                                                                    echo  $show['name'] .' ('. $show['version'] .')  '.$extenabled.' | ';
                                                                }
                                                            }
                                                        }
                                                        echo '[/color]';
                                                        echo "\r\n\r\n";

                                                        echo '[b]'. _FPA_EXTCOM_TITLE .' :: '. _FPA_ADMIN .' :: [/b]';
                                                        if ( $showCoreEx == 1) {
                                                            echo "\r\n";
                                                            echo '[b] ' . _FPA_JCORE . ' :: [/b][color=Blue]';
                                                            if ( isset ($component['ADMIN'])) {
                                                                foreach ( $component['ADMIN'] as $key => $show ) {
                                                                    if (isset($exset[0]['name'])) {
                                                                        $extarrkey = recursive_array_search($show['name'], $exset);
                                                                        if ($extarrkey  !== False) {
                                                                            $extenabled = $exset[$extarrkey]['enabled'];
                                                                        } else { $extenabled = '?' ;}
                                                                    } else { $extenabled = '?' ;}
                                                                    if ($extenabled <> 0 AND $extenabled <> 1 ) {
                                                                        $extenabled = '?';
                                                                    }
                                                                    if ( $show['type'] == _FPA_JCORE) {
                                                                        echo  $show['name'] .' ('. $show['version'] .')  '.$extenabled.' | ';
                                                                    }
                                                                }
                                                            }
                                                            echo '[/color]';
                                                        }
                                                        echo "\r\n";
                                                        echo '[b]' .  _FPA_3PD . ':: [/b][color=Brown]';
                                                        if ( isset ($component['ADMIN'])) {
                                                            foreach ( $component['ADMIN'] as $key => $show ) {
                                                                if (isset($exset[0]['name'])) {
                                                                    $extarrkey = recursive_array_search($show['name'], $exset);
                                                                    if ($extarrkey  !== False) {
                                                                        $extenabled = $exset[$extarrkey]['enabled'];
                                                                    } else { $extenabled = '?'; }
                                                                } else { $extenabled = '?'; }
                                                                if ($extenabled <> 0 AND $extenabled <> 1 ) {
                                                                    $extenabled = '?';
                                                                }
                                                                if ( $show['type'] == _FPA_3PD) {
                                                                    echo  $show['name'] .' ('. $show['version'] .')  '.$extenabled.' | ';
                                                                }
                                                            }
                                                        }
                                                        echo '[/color]';
                                                    }
                                                    echo "\r\n\r\n";

                                                    if ( @$_POST['showModules'] == '1' ) {
                                                        echo '[b]'. _FPA_EXTMOD_TITLE .' :: '. _FPA_SITE .' :: [/b]';
                                                        if ( $showCoreEx == 1) {
                                                            echo "\r\n";
                                                            echo '[b] ' . _FPA_JCORE . ' :: [/b][color=Blue]';
                                                            if ( isset ($module['SITE'])) {
                                                                foreach ( $module['SITE'] as $key => $show ) {
                                                                    if (isset($exset[0]['name'])) {
                                                                        $extarrkey = recursive_array_search($show['name'], $exset);
                                                                        if ($extarrkey  !== False) {
                                                                            $extenabled = $exset[$extarrkey]['enabled'];
                                                                        } else { $extenabled = '?'; }
                                                                    } else { $extenabled = '?'; }
                                                                        if ($extenabled <> 0 AND $extenabled <> 1 ) {
                                                                            $extenabled = '?';
                                                                        }
                                                                        if ( $show['type'] == _FPA_JCORE) {
                                                                            echo  $show['name'] .' ('. $show['version'] .')  '.$extenabled.' | ';
                                                                        }
                                                                }
                                                            }
                                                            echo '[/color]';
                                                        }
                                                        echo "\r\n";
                                                        echo '[b]' .  _FPA_3PD . ':: [/b][color=Brown]';
                                                        if ( isset ($module['SITE'])) {
                                                            foreach ( $module['SITE'] as $key => $show ) {
                                                                if (isset($exset[0]['name'])) {
                                                                    $extarrkey = recursive_array_search($show['name'], $exset);
                                                                    if ($extarrkey  !== False) {
                                                                        $extenabled = $exset[$extarrkey]['enabled'];
                                                                    } else { $extenabled = '?'; }
                                                                } else { $extenabled = '?'; }
                                                                if ($extenabled <> 0 AND $extenabled <> 1 ) {
                                                                    $extenabled = '?';
                                                                }
                                                                if ( $show['type'] == _FPA_3PD) {
                                                                    echo  $show['name'] .' ('. $show['version'] .')  '.$extenabled.' | ';
                                                                }
                                                            }
                                                        }
                                                        echo '[/color]';
                                                        echo "\r\n\r\n";

                                                        echo '[b]'. _FPA_EXTMOD_TITLE .' :: '. _FPA_ADMIN .' :: [/b]';
                                                        if ( $showCoreEx == 1) {
                                                            echo "\r\n";
                                                            echo '[b] ' . _FPA_JCORE . ' :: [/b][color=Blue]';
                                                            if ( isset ($module['ADMIN'])) {
                                                                foreach ( $module['ADMIN'] as $key => $show ) {
                                                                    if (isset($exset[0]['name'])) {
                                                                        $extarrkey = recursive_array_search($show['name'], $exset);
                                                                        if ($extarrkey  !== False) {
                                                                            $extenabled = $exset[$extarrkey]['enabled'];
                                                                        } else { $extenabled = '?'; }
                                                                    } else { $extenabled = '?'; }
                                                                    if ($extenabled <> 0 AND $extenabled <> 1 ){
                                                                        $extenabled = '?';
                                                                    }
                                                                    if ( $show['type'] == _FPA_JCORE) {
                                                                        echo  $show['name'] .' ('. $show['version'] .')  '.$extenabled.' | ';
                                                                    }
                                                                }
                                                            }
                                                            echo '[/color]';
                                                        }
                                                        echo "\r\n";
                                                        echo '[b]' .  _FPA_3PD . ':: [/b][color=Brown]';
                                                        if ( isset ($module['ADMIN'])) {
                                                            foreach ( $module['ADMIN'] as $key => $show ) {
                                                                if (isset($exset[0]['name'])) {
                                                                    $extarrkey = recursive_array_search($show['name'], $exset);
                                                                    if ($extarrkey  !== False) {
                                                                        $extenabled = $exset[$extarrkey]['enabled'];
                                                                    } else { $extenabled = '?' ;}
                                                                } else { $extenabled = '?' ;}
                                                                if ($extenabled <> 0 AND $extenabled <> 1 ) {
                                                                    $extenabled = '?';
                                                                }
                                                                if ( $show['type'] == _FPA_3PD) {
                                                                    echo  $show['name'] .' ('. $show['version'] .')  '.$extenabled.' | ';
                                                                }
                                                            }
                                                        }
                                                        echo '[/color]';
                                                    }
                                                    echo "\r\n\r\n";


                                                    if ( @$_POST['showLibraries'] == '1' ) {
                                                        echo '[b]'. _FPA_EXTLIB_TITLE .' :: [/b]';
                                                        if ( @$_POST[showCoreEx] == '1') {
                                                            echo "\r\n";
                                                            echo '[b] ' . _FPA_JCORE . ' :: [/b][color=Blue]';
                                                            if ( isset ($library['SITE'])) {
                                                                foreach ( $library['SITE'] as $key => $show ) {
                                                                    if (isset($exset[0]['name'])) {
                                                                        $extarrkey = recursive_array_search($show['name'], $exset);
                                                                        if ($extarrkey  !== False) {
                                                                            $extenabled = $exset[$extarrkey]['enabled'];
                                                                        } else { $extenabled = '?'; }
                                                                    } else { $extenabled = '?'; }
                                                                    if ($extenabled <> 0 AND $extenabled <> 1 ) {
                                                                        $extenabled = '?';
                                                                    }
                                                                    if ( $show['type'] == _FPA_JCORE) {
                                                                        echo  $show['name'] .' ('. $show['version'] .')  '.$extenabled.' | ';
                                                                    }
                                                                }
                                                            }
                                                            echo '[/color]';
                                                        }
                                                        echo "\r\n";
                                                        echo '[b]' .  _FPA_3PD . ':: [/b][color=Brown]';
                                                        if ( isset ($library['SITE'])) {
                                                            foreach ( $library['SITE'] as $key => $show ) {
                                                                if (isset($exset[0]['name'])) {
                                                                    $extarrkey = recursive_array_search($show['name'], $exset);
                                                                    if ($extarrkey  !== False) {
                                                                        $extenabled = $exset[$extarrkey]['enabled'];
                                                                    } else { $extenabled = '?'; }
                                                                } else { $extenabled = '?'; }
                                                                if ($extenabled <> 0 AND $extenabled <> 1 ) {
                                                                    $extenabled = '?';
                                                                }
                                                                if ( $show['type'] == _FPA_3PD) {
                                                                    echo  $show['name'] .' ('. $show['version'] .')  '.$extenabled.' | ';
                                                                }
                                                            }
                                                        }
                                                        echo '[/color]';
                                                    }
                                                    echo "\r\n\r\n";

                                                    if ( @$_POST['showPlugins'] == '1' ) {
                                                        echo '[b]'. _FPA_EXTPLG_TITLE .' :: [/b]';
                                                        if ( $showCoreEx == 1) {
                                                            echo "\r\n";
                                                            echo '[b] ' . _FPA_JCORE . ' :: [/b][color=Blue]';
                                                            if ( isset ($plugin['SITE'])) {
                                                                foreach ( $plugin['SITE'] as $key => $show ) {
                                                                    if (isset($exset[0]['name'])) {
                                                                        $extarrkey = recursive_array_search($show['name'], $exset);
                                                                        if ($extarrkey  !== False) {
                                                                            $extenabled = $exset[$extarrkey]['enabled'];
                                                                        } else { $extenabled = '?'; }
                                                                    } else { $extenabled = '?'; }
                                                                    if ($extenabled <> 0 AND $extenabled <> 1 ){
                                                                        $extenabled = '?';
                                                                    }
                                                                    if ( $show['type'] == _FPA_JCORE) {
                                                                        echo  $show['name'] .' ('. $show['version'] .')  '.$extenabled.' | ';
                                                                    }
                                                                }
                                                            }
                                                            echo '[/color]';
                                                        }
                                                        echo "\r\n";
                                                        echo '[b]' .  _FPA_3PD . ':: [/b][color=Brown]';
                                                        if ( isset ($plugin['SITE'])) {
                                                            foreach ( $plugin['SITE'] as $key => $show ) {
                                                                if (isset($exset[0]['name'])) {
                                                                    $extarrkey = recursive_array_search($show['name'], $exset);
                                                                    if ($extarrkey  !== False) {
                                                                        $extenabled = $exset[$extarrkey]['enabled'];
                                                                    } else { $extenabled = '?'; }
                                                                } else { $extenabled = '?'; }
                                                                if ($extenabled <> 0 AND $extenabled <> 1 ) {
                                                                    $extenabled = '?';
                                                                }
                                                                if ( $show['type'] == _FPA_3PD) {
                                                                    echo  $show['name'] .' ('. $show['version'] .')  '.$extenabled.' | ';
                                                                }
                                                            }
                                                        }
                                                        echo '[/color]';
                                                    } // end if showComponents, Modules, Plugins, if cmsFOUND
                                                    echo '[/size][/quote]';
                                                } // end showProtected != strict


                                                // do the template information
                                                if ( $instance['instanceFOUND'] == _FPA_Y ) {
                                                    echo '[quote="'. _FPA_TMPL_TITLE .' Discovered ::"][size=85]';

                                                    if ( $_POST['showProtected'] == '3' ) {
                                                        echo '[color=orange][b]'. _FPA_STRICT .'[/b] '. _FPA_INFOPRI .'[/color] '. _FPA_NODISPLAY;
                                                        echo '[/size][/quote]';
                                                    } else {

                                                        echo '[b]'. _FPA_TMPL_TITLE .' :: '. _FPA_SITE .' :: [/b]';
                                                        if ( isset ($template['SITE'])) {
                                                            foreach ( $template['SITE'] as $key => $show ) {
                                                                if (substr($instance['cmsRELEASE'],0,1) <> 1 AND @$database['dbHOSTINFO'] <> _FPA_U OR $postgresql = _FPA_Y) {
                                                                    if (isset($exset[0]['name'])) {
                                                                        $extarrkey = recursive_array_search($show['name'], $exset);
                                                                            if ($extarrkey  !== False) {
                                                                                $extenabled = $exset[$extarrkey]['enabled'];
                                                                            } else { $extenabled = '?'; }
                                                                        } else { $extenabled = '?'; }
                                                                        if ($extenabled <> 0 AND $extenabled <> 1 ){
                                                                            $extenabled = '?';
                                                                        }
                                                                        if (isset($tmpldef[0]['template'])) {
                                                                            $extarrkey = recursive_array_search($show['name'], $tmpldef);
                                                                            if ($extarrkey  !== False) {
                                                                                $deftempl = $tmpldef[$extarrkey]['home'];
                                                                            } else { $deftempl = ''; }
                                                                        } else { $deftempl = ''; }
                                                                        if ($deftempl == 1 ) {
                                                                            $bldop = '[b][u]';
                                                                            $bldcl = '[/u][/b]';
                                                                        } else {
                                                                            $bldop = '';
                                                                            $bldcl = '';
                                                                        }
                                                                    } else {
                                                                        $bldop = '';
                                                                        $bldcl = '';
                                                                        $extenabled = '';
                                                                    }
                                                                    if ( $show['type'] == _FPA_3PD OR $showCoreEx == 1) {
                                                                        if ( $show['type'] == _FPA_3PD) {
                                                                            echo '[color=Brown]'. $bldop . $show['name'] .' ('. $show['version'] .')' . $bldcl . '[/color]  '.$extenabled.' | ';
                                                                        } else {
                                                                            echo '[color=Blue]'. $bldop . $show['name'] .' ('. $show['version'] .')' . $bldcl . '[/color]  '.$extenabled.' | ';
                                                                        }
                                                                    }
                                                            }
                                                        }
                                                        echo "\r\n";

                                                        echo '[b]'. _FPA_TMPL_TITLE .' :: '. _FPA_ADMIN .' :: [/b]';
                                                        if ( isset ($template['ADMIN'])) {
                                                            foreach ( $template['ADMIN'] as $key => $show ) {
                                                                if (substr($instance['cmsRELEASE'],0,1) <> 1 AND @$database['dbHOSTINFO'] <> _FPA_U OR $postgresql = _FPA_Y ) {
                                                                    if (isset($exset[0]['name'])) {
                                                                        $extarrkey = recursive_array_search($show['name'], $exset);
                                                                        if ($extarrkey  !== False) {
                                                                            $extenabled = $exset[$extarrkey]['enabled'];
                                                                        } else { $extenabled = '?'; }
                                                                    } else { $extenabled = '?'; }
                                                                        if ($extenabled <> 0 AND $extenabled <> 1 ) {
                                                                            $extenabled = '?';
                                                                        }
                                                                        if (isset($tmpldef[0]['template'])) {
                                                                            $extarrkey = recursive_array_search($show['name'], $tmpldef);
                                                                                if ($extarrkey  !== False) {
                                                                                    $deftempl = $tmpldef[$extarrkey]['home'];
                                                                                } else { $deftempl = ''; }
                                                                        } else { $deftempl = ''; }
                                                                            if ($deftempl == 1 ) {
                                                                                $bldop = '[b][u]';
                                                                                $bldcl = '[/u][/b]';
                                                                            } else {
                                                                                $bldop = '';
                                                                                $bldcl = '';
                                                                            }
                                                                } else {
                                                                    $bldop = '';
                                                                    $bldcl = '';
                                                                    $extenabled = '';
                                                                }
                                                                if ( $show['type'] == _FPA_3PD OR $showCoreEx == 1) {
                                                                    if ( $show['type'] == _FPA_3PD) {
                                                                        echo '[color=Brown]'. $bldop . $show['name'] .' ('. $show['version'] .')' . $bldcl . '[/color]  '.$extenabled.' | ';
                                                                    } else {
                                                                        echo '[color=Blue]'. $bldop . $show['name'] .' ('. $show['version'] .')' . $bldcl . '[/color]  '.$extenabled.' | ';
                                                                    }
                                                                }
                                                            }
                                                        }

                                                    }
                                                    echo '[/size][/quote]';
                                                }
                                            } // end if InstanceFOUND
                                            echo '[/quote]';
                                            echo '</textarea>';
                                        ?>

                                        <button class="btn btn-warning btn-lg btn-block" onclick="return false;" id="copyPOST"><i class="fas fa-copy"></i> Copy Post Content To Clipboard</button>

                                    </div><!--/.card-->

                                </div><!--/.col-->
                            </div><!--/.row-->
                        <?php } // end post doIT ?>

                    </div><!--/.container-->

                </section><!--/post form-->

            </form><!--END POST FORM-->


            <?php
            /**
             * fpa instance discovery information section
             *
             * dont show if doVEL = 1
             * added @RussW 29/05/2020
             *
             */
            ?>
            <?php if ( @$_POST['doVEL'] != 1 ) { ?>

                <section class="py-3 pdf-break-before" id="instance-discovery">
                    <div class="container mt-5">

                        <h2 class="h1 font-weight-light border-bottom mb-4"><i class="fas fa-chalkboard fa-sm text-muted"></i> <?php echo _FPA_DISCOVERY_REPORT; ?></h2>

                        <div class="row row-cols-1 row-cols-lg-2 print-break-after application-discovery">
                            <div class="col mb-4 d-flex align-self-stretch">

                                <div class="card border shadow w-100">
                                    <div class="card-header bg-info text-white">
                                        <?php echo $instance['ARRNAME']; ?> :: Discovery
                                    </div>
                                    <div class="card-body">

                                        <div class="row row-cols-2 row-cols-md-4">

                                            <div class="col text-center my-2 d-flex align-self-stretch">

                                                <div class="bg-white small w-100 border">
                                                    <div class="d-block xsmall bg-light text-uppercase text-dark py-1 mb-1">CMS <?php echo _FPA_F; ?></div>

                                                    <?php if ( $instance['instanceFOUND'] == _FPA_Y AND $instance['platformVFILE'] != _FPA_N) { ?>

                                                        <div class="xsmall mb-1"><?php echo @$instance['cmsPRODUCT']; ?></div>
                                                        <div class="font-weight-bolder mb-1"><?php echo @$instance['cmsRELEASE'] .'.'. @$instance['cmsDEVLEVEL']; ?></div>

                                                        <?php
                                                            if ( strtolower( @$instance['cmsDEVSTATUS'] ) == 'stable' ) {
                                                                $statusClass = 'success';

                                                            } elseif ( strtolower( substr( @$instance['cmsDEVSTATUS'],0, 4 ) ) == 'alph' OR strtolower( substr( @$instance['cmsDEVSTATUS'],0, 4 ) ) == 'beta' ) {
                                                                $statusClass = 'danger';

                                                            } elseif ( strtolower( substr( @$instance['cmsDEVSTATUS'],0, 2 ) ) == 'rc' ) {
                                                                $statusClass = 'warning';

                                                            } else {
                                                                $statusClass = 'warning';
                                                            }
                                                        ?>
                                                        <div class="badge badge-<?php echo $statusClass; ?> text-uppercase w-100"><?php echo @$instance['cmsDEVSTATUS']; ?></div>

                                                        <?php
                                                            // warning if more than one instance of version.php found
                                                            if ($vFileSum > 1) {
                                                                echo '<div class="bg-danger text-white xsmall py-1">' . _FPA_MVFWF . '</div>';
                                                            }
                                                        ?>

                                                    <?php } else { ?>
                                                        <div class="border border-warning text-warning small mx-auto w-75"><?php echo @$instance['instanceFOUND']; ?></div>
                                                    <?php } // instanceFOUND ?>

                                                </div>

                                            </div><!--/.col-->
                                            <div class="col text-center my-2 d-flex align-self-stretch">

                                            <div class="bg-white small w-100 border">
                                                    <div class="d-block xsmall bg-light text-uppercase text-dark py-1 mb-1"><?php echo _FPA_PLATFORM; ?></div>

                                                    <?php if ( $instance['instanceFOUND'] == _FPA_Y ) { ?>

                                                        <div class="xsmall mb-1"><?php echo @$instance['platformPRODUCT']; ?></div>
                                                        <div class="font-weight-bolder mb-1"><?php echo @$instance['platformRELEASE'] .'.'. @$instance['platformDEVLEVEL']; ?></div>

                                                        <?php
                                                            if ( strtolower( @$instance['platformDEVSTATUS'] ) == 'stable' ) {
                                                                $statusClass = 'success';

                                                            } elseif ( strtolower( substr( @$instance['platformDEVSTATUS'],0, 4 ) ) == 'alph' OR strtolower( substr( @$instance['cmsDEVSTATUS'],0, 4 ) ) == 'beta' ) {
                                                                $statusClass = 'danger';

                                                            } elseif ( strtolower( substr( @$instance['platformDEVSTATUS'],0, 2 ) ) == 'rc' ) {
                                                                $statusClass = 'warning';

                                                            } else {
                                                                $statusClass = 'warning';
                                                            }
                                                        ?>
                                                        <div class="badge badge-<?php echo $statusClass; ?> text-uppercase w-100"><?php echo @$instance['platformDEVSTATUS']; ?></div>

                                                        <?php
                                                            // warning if more than one instance of version.php found
                                                            if ($vFileSum > 1) {
                                                                echo '<div class="bg-danger text-white xsmall py-1">' . _FPA_MVFWF . '</div>';
                                                            }
                                                        ?>

                                                    <?php } else { ?>
                                                        <div class="border border-warning text-warning small mx-auto w-75"><?php echo @$instance['instanceFOUND']; ?></div>
                                                    <?php } // instanceFOUND ?>

                                                </div>

                                            </div><!--/.col-->
                                            <div class="col text-center my-2 d-flex align-self-stretch">

                                                <div class="bg-white small w-100 border">
                                                    <div class="d-block xsmall bg-light text-uppercase text-dark py-1 mb-1"><?php echo _FPA_CF .' '. _FPA_E; ?></div>

                                                        <?php
                                                            if ( $instance['instanceCONFIGURED'] == _FPA_Y ) {
                                                                $statusClass = 'success';

                                                            } else {
                                                                $statusClass = 'warning';
                                                            }
                                                        ?>
                                                        <div class="border border-<?php echo $statusClass; ?> text-<?php echo $statusClass; ?> small mx-auto w-75 mb-1"><?php echo @$instance['instanceCONFIGURED']; ?></div>
                                                </div>

                                            </div><!--/.col-->
                                            <div class="col text-center my-2 d-flex align-self-stretch">

                                                <div class="bg-white small w-100 border">
                                                    <div class="d-block xsmall bg-light text-uppercase text-dark py-1 mb-1"><?php echo _FPA_CF .' '. _FPA_VER; ?></div>

                                                        <?php
                                                            if ( @$instance['instanceCFGVERMATCH'] == _FPA_Y ) {
                                                                echo '<div class="font-weight-bolder mb-1">'. $instance['configVALIDFOR'] .'</div>';
                                                                echo '<div class="border border-success text-success xsmall mx-auto w-75 mb-1">'. _FPA_YMATCH .' CMS</div>';

                                                            } elseif ( @$instance['instanceCFGVERMATCH'] == _FPA_N ) {
                                                                echo '<div class="font-weight-bolder mb-1">'. $instance['configVALIDFOR'] .'</div>';
                                                                echo '<div class="border border-success text-success xsmall mx-auto w-75">'. _FPA_NMATCH .' CMS</div>';

                                                            } elseif ( @$instance['configVALIDFOR'] == _FPA_U ) {
                                                                echo '<div class="border border-warning text-warning small mx-auto w-75">'. $instance['configVALIDFOR'] .'</div>';
                                                            }
                                                        ?>

                                                </div>

                                            </div><!--/.col-->

                                            <?php if ( $instance['instanceCONFIGURED'] != _FPA_N AND $instance['instanceFOUND'] != _FPA_N ) { ?>

                                                <div class="col text-center my-2 d-flex align-self-stretch">

                                                    <div class="bg-white small w-100 border">
                                                        <div class="d-block xsmall bg-light text-uppercase text-dark py-1 mb-1"><?php echo _FPA_CF .' '. _FPA_VALID; ?></div>

                                                            <?php
                                                                if ( @$instance['configSANE'] == _FPA_Y AND @$instance['configSIZEVALID'] != _FPA_N ) {
                                                                    $saneClass = 'success';
                                                                    $configVALID = _FPA_Y;

                                                                } elseif ( @$instance['configVALIDFOR'] == _FPA_U ) {
                                                                    $saneClass = 'warning';
                                                                    $configVALID = _FPA_N;
                                                                }
                                                            ?>
                                                            <div class="border border-<?php echo $saneClass; ?> text-<?php echo $saneClass; ?> small mx-auto w-75 mb-1"><?php echo $configVALID; ?></div>

                                                    </div>

                                                </div><!--/.col-->
                                                <div class="col text-center my-2 d-flex align-self-stretch">

                                                    <div class="bg-white small w-100 border">
                                                        <div class="d-block xsmall bg-light text-uppercase text-dark py-1 mb-1"><?php echo _FPA_CF .' '. _FPA_MODE; ?></div>

                                                            <?php
                                                                // looking for --7 or -7- or -77 (default folder permissions are usually 755)
                                                                if ( substr( $instance['configMODE'],0 ,1 ) == '7' OR substr( $instance['configMODE'],1 ,1 ) == '7' OR substr( $instance['configMODE'],2 ,1 ) == '7' ) {
                                                                    $modeClass = 'border border-danger text-danger';

                                                                } elseif ( substr( $instance['configMODE'],1 ,1 ) >= '5' OR substr( $instance['configMODE'],2 ,1 ) >= '5' ) {
                                                                    $modeClass = 'border border-warning text-warning';

                                                                } elseif ( $instance['configMODE'] == _FPA_N ) {
                                                                    $modeClass = 'border border-warning text-warning';

                                                                } else {
                                                                    $modeClass = 'font-weight-bolder';
                                                                }

                                                            ?>
                                                            <div class="<?php echo $modeClass; ?> small mx-auto w-75 mb-1"><?php echo $instance['configMODE']; ?></div>

                                                            <?php
                                                                // is the file writable?
                                                                if ( ( $instance['configWRITABLE'] == _FPA_Y ) AND ( substr( $instance['configMODE'],0 ,1 ) == '7' OR substr( $instance['configMODE'],1 ,1 ) == '7' OR substr( $instance['configMODE'],2 ,1 ) == '7' ) ) {
                                                                    $writeClass = 'border border-danger text-danger';
                                                                    $canWrite = 'Writable';

                                                                } elseif ( ( $instance['configWRITABLE'] == _FPA_Y ) AND ( substr( $instance['configMODE'],0 ,1 ) <= '6' ) ) {
                                                                    $writeClass = 'border border-success text-success';
                                                                    $canWrite = _FPA_WRITABLE;

                                                                } elseif ( ( $instance['configWRITABLE'] != _FPA_Y ) ) {
                                                                    $writeClass = 'border border-warning text-warning';
                                                                    $canWrite = _FPA_RO;

                                                                }
                                                            ?>
                                                            <div class="<?php echo $writeClass; ?> xsmall mx-auto w-75 mb-1"><?php echo $canWrite; ?></div>

                                                    </div>

                                                </div><!--/.col-->
                                                <div class="col text-center my-2 d-flex align-self-stretch">

                                                    <div class="bg-white small w-100 border">
                                                        <div class="d-block xsmall bg-light text-uppercase text-dark py-1 mb-1"><?php echo _FPA_CF .' '. _FPA_OWNER; ?></div>

                                                        <?php
                                                            if ( $showProtected == 0 ) {
                                                                echo $instance['configOWNER']['name'];

                                                            } else {
                                                                echo '<span class="protected">'. _FPA_HIDDEN .'</span>';
                                                            }
                                                        ?>

                                                    </div>

                                                </div><!--/.col-->
                                                <div class="col text-center my-2 d-flex align-self-stretch">

                                                    <div class="bg-white small w-100 border">
                                                        <div class="d-block xsmall bg-light text-uppercase text-dark py-1 mb-1"><?php echo _FPA_CF .' '. _FPA_GROUP; ?></div>

                                                        <?php
                                                            if ( $showProtected == 0 ) {
                                                                echo $instance['configGROUP']['name'];

                                                            } else {
                                                                echo '<span class="protected">'. _FPA_HIDDEN .'</span>';
                                                            }
                                                        ?>

                                                    </div>

                                                </div><!--/.col-->

                                            <?php } else { ?>

                                                <div class="col-12 col-md-12 text-center my-2">
                                                    <p class="border border-warning text-warning p-2 mb-0 xsmall">
                                                        <?php
                                                            if ( $instance['instanceFOUND'] != _FPA_Y ) {
                                                                echo _FPA_INSTANCE .' '. _FPA_NF .', '. _FPA_NO .' '. $instance['ARRNAME'].' '. _FPA_TESTP .'<br />';
                                                            }

                                                            if ( $instance['instanceCONFIGURED'] == _FPA_Y ) {
                                                                echo _FPA_BUT .' '. _FPA_CFG .' '. _FPA_F;
                                                            }
                                                        ?>
                                                    </p>
                                                </div><!--/.col-12-->

                                            <?php } // instance found & configured ?>

                                        </div><!--./row-->

                                    </div>
                                </div><!--/.card (discovery)-->

                            </div><!--/.col-->
                            <div class="col mb-4 d-flex align-self-stretch">

                                <div class="card border shadow w-100">
                                    <div class="card-header bg-info text-white">
                                        <?php echo $instance['ARRNAME']; ?> :: Configuration
                                    </div>
                                    <div class="card-body">

                                        <div class="row row-cols-2 row-cols-md-4">

                                            <?php if ( $instance['instanceCONFIGURED'] == _FPA_Y AND $instance['configVALIDFOR'] != _FPA_U ) { ?>

                                                <div class="col text-center my-2 d-flex align-self-stretch">

                                                    <div class="bg-white small w-100 border">
                                                        <div class="d-block xsmall bg-light text-uppercase text-dark py-1 mb-1">Offline?</div>
                                                        <?php
                                                            if ( $instance['configOFFLINE'] == 'false' ) {
                                                                $offlineStatus = _FPA_N;
                                                                $offlineClass  = 'border border-info text-info';

                                                            } elseif ( $instance['configOFFLINE'] == 'true' ) {
                                                                    $offlineStatus = _FPA_Y;
                                                                    $offlineClass  = 'border border-warning text-warning';
                                                            } else {
                                                                $offlineStatus = _FPA_U;
                                                                $offlineClass  = 'border border-danger text-danger';
                                                            }
                                                        ?>
                                                        <div class="<?php echo $offlineClass; ?> mx-auto w-75 mb-1"><?php echo $offlineStatus; ?></div>
                                                    </div>

                                                </div><!--/.col-->
                                                <div class="col text-center my-2 d-flex align-self-stretch">

                                                    <div class="bg-white small w-100 border">
                                                        <div class="d-block xsmall bg-light text-uppercase text-dark py-1 mb-1">SEF URL's</div>
                                                        <?php
                                                            if ( $instance['configSEF'] == 'true' ) {
                                                                $sefClass  = 'info';

                                                            } else {
                                                                $sefClass  = 'warning';
                                                            }
                                                        ?>
                                                        <div class="xsmall w-100 mb-1 text-left px-1 mb-1 ">
                                                            <?php echo _FPA_EN; ?>: <span class="text-<?php echo $sefClass; ?> text-capitalize float-right"><?php echo $instance['configSEF']; ?></span>
                                                        </div>

                                                        <div class="xsmall w-100 mb-1 border-top text-left px-1 mb-1 ">
                                                            Suffix: <span class="float-right text-capitalize"><?php echo $instance['configSEFSUFFIX']; ?></span>
                                                        </div>

                                                        <?php
                                                            if ( ($instance['configSEFRWRITE'] == '1' OR $instance['configSEFRWRITE'] == 'true' ) AND $instance['configSITEHTWC'] != _FPA_Y ) {
                                                                $rewriteTitleClass = 'danger';
                                                                $rewriteClass      = 'danger';

                                                                if ($system['sysSHORTWEB'] != 'MIC') {
                                                                    $htwcMissing = '.htaccess missing';
                                                                } else {
                                                                    $htwcMissing = 'web.config missing';
                                                                }

                                                            } else {
                                                                $rewriteTitleClass = 'default';
                                                                $rewriteClass      = 'info';
                                                                $htwcMissing       = '';
                                                            }
                                                        ?>
                                                        <div class="xsmall w-100 mb-1 border-top text-left px-1 mb-1 text-<?php echo $rewriteTitleClass; ?>">
                                                            Rewrite: <span class="text-<?php echo $rewriteClass; ?> text-capitalize float-right"><?php echo $instance['configSEFRWRITE']; ?></span>
                                                            <?php
                                                                if ( !empty($htwcMissing) ) {
                                                                    echo '<span class="xsmall text-'.$rewriteClass.' float-right">'. $htwcMissing .'</span>';
                                                                }
                                                            ?>
                                                        </div>

                                                    </div>

                                                </div><!--/.col-->
                                                <div class="col text-center my-2 d-flex align-self-stretch">

                                                    <div class="bg-white small w-100 border">
                                                        <div class="d-block xsmall bg-light text-uppercase text-dark py-1 mb-1">Compression</div>
                                                        <?php
                                                            if ( $instance['configGZIP'] == 'true' ) {
                                                                $gzipClass  = 'info';

                                                            } else {
                                                                $gzipClass  = 'default';
                                                            }
                                                        ?>
                                                        <div class="xsmall w-100 mb-1 text-left px-1 mb-1 ">
                                                            GZip: <span class="text-<?php echo $gzipClass; ?> text-capitalize float-right"><?php echo $instance['configGZIP']; ?></span>
                                                        </div>

                                                        <?php
                                                            if ( $instance['configCACHING'] == 'true' ) {
                                                                $cacheClass  = 'info';

                                                            } else {
                                                                $cacheClass  = 'default';
                                                            }
                                                        ?>
                                                        <div class="xsmall w-100 mb-1 border-top text-left px-1 mb-1 ">
                                                            Cache: <span class="text-<?php echo $cacheClass; ?> text-capitalize float-right"><?php echo $instance['configCACHING']; ?></span>
                                                        </div>

                                                    </div>

                                                </div><!--/.col-->
                                                <div class="col text-center my-2 d-flex align-self-stretch">

                                                    <div class="bg-white small w-100 border">
                                                        <div class="d-block xsmall bg-light text-uppercase text-dark py-1 mb-1">Debugging</div>

                                                        <?php
                                                            if ( $instance['configERRORREP'] == 'none' ) {
                                                                $debugClass  = 'info';

                                                            } else {
                                                                $debugClass  = 'warning';
                                                            }
                                                        ?>
                                                        <div class="xsmall w-100 mb-1 text-left px-1 mb-1">
                                                            Error Rep: <span class="text-<?php echo $debugClass; ?> float-right text-capitalize"><?php echo substr($instance['configERRORREP'], 0, 5); ?></span>
                                                        </div>

                                                        <?php
                                                            if ( $instance['configSITEDEBUG'] == 'true' ) {
                                                                $debugClass  = 'warning';

                                                            } else {
                                                                $debugClass  = 'info';
                                                            }
                                                        ?>
                                                        <div class="xsmall w-100 mb-1 border-top text-left px-1 mb-1">
                                                            Site Debug: <span class="text-<?php echo $debugClass; ?> text-capitalize float-right"><?php echo $instance['configSITEDEBUG']; ?></span>
                                                        </div>

                                                        <?php
                                                            if ( $instance['configLANGDEBUG'] == 'true' ) {
                                                                $debugClass  = 'warning';

                                                            } else {
                                                                $debugClass  = 'info';
                                                            }
                                                        ?>
                                                        <div class="xsmall w-100 mb-1 border-top text-left px-1 mb-1">
                                                            Lang Debug: <span class="text-<?php echo $debugClass; ?> text-capitalize float-right"><?php echo $instance['configLANGDEBUG']; ?></span>
                                                        </div>

                                                    </div>

                                                </div><!--/.col-->
                                                <div class="col text-center my-2 d-flex align-self-stretch">

                                                <div class="bg-white small w-100 border">
                                                        <div class="d-block xsmall bg-light text-uppercase text-dark py-1 mb-1"><?php echo _FPA_DB; ?></div>

                                                        <div class="xsmall w-100 mb-1 text-left px-1 mb-1">
                                                            Type: <span class=" float-right text-capitalize"><?php echo substr(@$instance['configDBTYPE'], 0, 8); ?></span>
                                                        </div>

                                                        <div class="xsmall w-100 mb-1 border-top text-left px-1 mb-1">
                                                            Version: <span class=" float-right text-capitalize"><?php echo substr(@$database['dbHOSTSERV'], 0, 5); ?></span>
                                                        </div>

                                                        <div class="xsmall w-100 mb-1 border-top text-left px-1 mb-1">
                                                            CharSet: <span class=" float-right"><?php echo substr(@$database['dbCHARSET'], 0, 6); ?></span>
                                                        </div>

                                                    </div>

                                                </div><!--/.col-->
                                                <div class="col text-center my-2 d-flex align-self-stretch">

                                                    <div class="bg-white small w-100 border">
                                                        <div class="d-block xsmall bg-light text-uppercase text-dark py-1 mb-1">DB <?php echo _FPA_CRED; ?></div>
                                                        <?php
                                                            if ( $instance['configDBCREDOK'] == _FPA_Y ) {
                                                                $credStatus = _FPA_YACOMP;
                                                                $credClass  = 'border border-success text-success';

                                                            } else {
                                                                $credStatus = _FPA_NACOMP;
                                                                $credClass  = 'border border-warning text-warning';
                                                            }
                                                        ?>
                                                        <div class="<?php echo $credClass; ?> mx-auto w-75 mb-1 xsmall"><?php echo $credStatus; ?></div>
                                                    </div>

                                                </div><!--/.col-->
                                                <div class="col text-center my-2 d-flex align-self-stretch">

                                                    <div class="bg-white small w-100 border">
                                                        <div class="d-block xsmall bg-light text-uppercase text-dark py-1 mb-1"><?php echo _FPA_SEC; ?></div>

                                                        <?php
                                                            if ( $instance['configSSL'] == '1' ) {
                                                                $sslClass  = 'info';

                                                            } else {
                                                                $sslClass  = 'warning';
                                                            }
                                                        ?>
                                                        <div class="xsmall w-100 mb-1 text-left px-1 mb-1">
                                                            SSL: <span class="text-<?php echo $sslClass; ?> float-right text-capitalize"><?php echo @$instance['configSSL']; ?></span>
                                                        </div>

                                                        <?php
                                                            if ( $instance['configACCESS'] == '1' ) {
                                                                $accessClass   = 'info';
                                                                $accessStatus  = 'Public';

                                                            } elseif ( $instance['configACCESS'] == '2' ) {
                                                                $accessClass   = 'info';
                                                                $accessStatus  = 'Registered';

                                                            } elseif ( $instance['configACCESS'] == '2' ) {
                                                                $accessClass   = 'info';
                                                                $accessStatus  = 'Special';

                                                            } else {
                                                                $accessClass  = 'warning';
                                                                $accessStatus  = _FPA_U;
                                                            }
                                                        ?>
                                                        <div class="xsmall border-top w-100 mb-1 text-left px-1 mb-1">
                                                            Access: <span class="text-<?php echo $accessClass; ?> float-right text-capitalize"><?php echo $accessStatus; ?></span>
                                                        </div>

                                                    </div>

                                                </div><!--/.col-->
                                                <div class="col text-center my-2 d-flex align-self-stretch">

                                                    <div class="bg-white small w-100 border">
                                                        <div class="d-block xsmall bg-light text-uppercase text-dark py-1 mb-1"><?php echo _FPA_FEAT; ?></div>

                                                        <?php
                                                            if ( $instance['configFTP'] == '1' ) {
                                                                $ftpClass  = 'warning';

                                                            } else {
                                                                $ftpClass  = 'info';
                                                            }
                                                        ?>
                                                        <div class="xsmall w-100 mb-1 text-left px-1 mb-1">
                                                            FTP: <span class="text-<?php echo $ftpClass; ?> float-right text-capitalize"><?php echo @$instance['configFTP']; ?></span>
                                                        </div>

                                                        <div class="xsmall border-top w-100 mb-1 text-left px-1 mb-1">
                                                            Unicode Slug: <span class="float-right text-capitalize"><?php echo $instance['configUNICODE']; ?></span>
                                                        </div>

                                                    </div>

                                                </div><!--/.col-->

                                            <?php } else { ?>

                                                <div class="col-12 col-md-12 text-center my-2">
                                                    <p class="border border-warning text-warning p-2 mb-0 xsmall">
                                                        <?php echo _FPA_CFG .' '. _FPA_NF .' '. _FPA_OR .' '. _FPA_NVALID .', '. _FPA_NO .' '. $instance['ARRNAME'].' '. _FPA_TESTP .'<br />';?>
                                                    </p>
                                                </div><!--/.col-12-->

                                            <?php } // instance found & configured ?>

                                        </div><!--./row-->

                                    </div>
                                </div><!--/.card (configuration)-->

                            </div><!--/.col-->
                        </div><!--./row application-discovery-->
                        <?php showDev( $instance ); ?>

                        <div class="row row-cols-1 row-cols-lg-2 print-break-after hosting-discovery">
                            <div class="col mb-4 d-flex align-self-stretch">

                                <div class="card border shadow w-100">
                                    <div class="card-header bg-info text-white"><?php echo $phpenv['ARRNAME'] .' :: '. _FPA_DISC; ?></div>
                                    <div class="card-body">

                                        <table class="table table-striped table-bordered table-sm">
                                            <tbody>
                                                <tr class="flex-fill">
                                                    <td class="text-capitalize w-50">PHP <?php echo _FPA_VER; ?></td>
                                                    <td>
                                                        <?php echo $phpenv['phpVERSION']; ?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="text-capitalize">PHP API</td>
                                                    <td>
                                                        <?php
                                                            if ( $phpenv['phpAPI'] == 'apache2handler' ) {
                                                                $status = 'warning';

                                                            } else {
                                                                $status = 'success';

                                                            }
                                                            echo '<span class="text-'. $status.'">'. $phpenv['phpAPI'] .'</span>';
                                                        ?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="text-capitalize">Display Errors</td>
                                                    <td>
                                                        <?php echo $phpenv['phpERRORDISPLAY']; ?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="text-capitalize">Error Report Level</td>
                                                    <td>
                                                        <?php echo $phpenv['phpERRORREPORT']; ?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="text-capitalize">MySQL <?php echo _FPA_SUP; ?></td>
                                                    <td>
                                                        <?php echo $phpenv['phpSUPPORTSMYSQL']; ?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="text-capitalize">MySQLi <?php echo _FPA_SUP; ?></td>
                                                    <td>
                                                        <?php echo $phpenv['phpSUPPORTSMYSQLI']; ?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="text-capitalize">Magic Quotes</td>
                                                    <td>
                                                        <?php echo $phpenv['phpMAGICQUOTES'] ? 'true' : 'false'; ?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="text-capitalize">Safe Mode</td>
                                                    <td>
                                                        <?php echo $phpenv['phpSAFEMODE'] ? 'true' : 'false'; ?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="text-capitalize">Memory Limit</td>
                                                    <td>
                                                        <?php
                                                            echo $phpenv['phpMEMLIMIT'];
                                                            if ( @$_POST['increasePOPS'] == 1 ) { // the user set the increasePOPS setting for memory or time out errors
                                                                echo '&nbsp;<i class="text-warning">('. _FPA_UINC .' '. $fpa['ORIGphpMEMLIMIT'] .')</i>';
                                                            }
                                                        ?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="text-capitalize">PHP Uploads Enabled</td>
                                                    <td>
                                                        <?php echo $phpenv['phpUPLOADS']; ?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="text-capitalize">Max. Upload Size</td>
                                                    <td>
                                                        <?php echo $phpenv['phpMAXUPSIZE']; ?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="text-capitalize">Max. Post Size</td>
                                                    <td>
                                                        <?php echo $phpenv['phpMAXPOSTSIZE']; ?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="text-capitalize">Max. Input Time</td>
                                                    <td>
                                                        <?php echo $phpenv['phpMAXINPUTTIME']; ?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="text-capitalize">Max. Execution Time</td>
                                                    <td>
                                                        <?php
                                                            echo $phpenv['phpMAXEXECTIME'];
                                                            if ( @$_POST['increasePOPS'] == 1 ) { // the user set the increasePOPS setting for memory or time out errors
                                                                echo '&nbsp;<i class="text-warning">('. _FPA_UINC .' '. $fpa['ORIGphpMAXEXECTIME'] .')</i>';
                                                            }
                                                        ?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="text-capitalize">Register Globals</td>
                                                    <td>
                                                        <?php echo $phpenv['phpREGGLOBAL'] ? 'true' : 'false'; ?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="text-capitalize">Allow URL fopen</td>
                                                    <td>
                                                        <?php echo $phpenv['phpURLFOPEN']; ?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="text-capitalize">Open Base Path</td>
                                                    <td>
                                                        <?php echo $phpenv['phpOPENBASE']; ?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="text-capitalize">Disabled Functions</td>
                                                    <td class="xsmall">
                                                        <?php echo str_replace (',', ', ', $phpenv['phpDISABLED']); ?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="text-capitalize">Session Path</td>
                                                    <td class="xsmall">
                                                        <?php
                                                            if ( $showProtected == 0 ) {
                                                                echo $phpenv['phpSESSIONPATH'] .'<br />';
                                                            } else {
                                                                echo '<span class="protected">'. _FPA_HIDDEN .'</span><br />';
                                                            }

                                                            if ( $phpenv['phpSESSIONPATHWRITABLE'] == _FPA_Y ) {
                                                                $wColor = 'success';

                                                            } elseif ( $phpenv['phpSESSIONPATHWRITABLE'] == _FPA_N ) {
                                                                $wColor = 'danger';

                                                            } else {
                                                                $phpenv['phpSESSIONPATHWRITABLE'] = _FPA_U;
                                                            }
                                                            echo _FPA_WRITABLE.': <span class="text-'. $wColor .'">'. $phpenv['phpSESSIONPATHWRITABLE'] .'</span>';
                                                        ?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="text-capitalize">System php.ini</td>
                                                    <td class="xsmall">
                                                        <?php
                                                            echo $phpenv['phpINIFILE'] .'<br />';
                                                            echo 'Multiple ini files:&nbsp;';
                                                            echo $phpenv['phpINIOTHER'] ? 'true' : 'false';
                                                        ?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="2">
                                                        Last Known PHP Error<br />
                                                        <?php
                                                            if ( $phpenv['phpLASTERR'] ) {
                                                                echo '<span class="text-danger xsmall">'. $phpenv['phpLASTERR'] .'</span>';

                                                            } else {
                                                                echo '<span class="text-success">None</span>';
                                                            }
                                                        ?>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>

                                    <?php showDev( $phpenv ); ?>
                                    </div>
                                </div><!--/.card (php)-->

                            </div><!--/.col-->
                            <div class="col mb-4 d-flex align-self-stretch">

                                <div class="card border shadow w-100">
                                    <div class="card-header bg-info text-white"><?php echo $system['ARRNAME'] .' :: '. _FPA_DISC; ?></div>
                                    <div class="card-body">

                                        <table class="table table-striped table-bordered table-sm mb-5">
                                            <tbody>
                                                <tr class="flex-fill">
                                                    <td class="text-capitalize w-50"><?php echo _FPA_PLATFORM; ?></td>
                                                    <td>
                                                        <?php echo  $system['sysPLATOS']; ?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="text-capitalize">Kernel <?php echo _FPA_VER; ?></td>
                                                    <td>
                                                        <?php echo  $system['sysPLATREL']; ?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="text-capitalize"><?php echo _FPA_TEC; ?></td>
                                                    <td>
                                                        <?php echo  $system['sysPLATTECH']; ?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="text-capitalize"><?php echo _FPA_HNAME; ?></td>
                                                    <td>
                                                        <?php
                                                            if ( $showProtected == 0 ) {
                                                                echo $system['sysPLATNAME'];

                                                            } else {
                                                                echo '<span class="protected">'. _FPA_HIDDEN .'</span>';
                                                            }
                                                        ?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="text-capitalize">Total Disk Space</td>
                                                    <td>
                                                        <?php
                                                            if (function_exists('disk_total_space')) {
                                                                $total_space = sprintf('%.2f', disk_total_space('./') / 1073741824);
                                                                echo $total_space . ' GiB';

                                                            } else {
                                                                echo _FPA_U;
                                                            }
                                                        ?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="text-capitalize">Free Disk Space</td>
                                                    <td>
                                                        <?php
                                                            if (function_exists('disk_free_space')) {
                                                                $free_space = sprintf('%.2f', disk_free_space('./') / 1073741824);
                                                                if (function_exists('disk_total_space')) {
                                                                    $percent_free = $free_space ? round($free_space / $total_space, 2) * 100 : 0;

                                                                    if ($percent_free <= '5') {
                                                                        $status = 'text-warning';
                                                                    } else {
                                                                        $status = '';
                                                                    }

                                                                    echo $free_space .' GiB (<span class="'. $status .' xsmall">'. $percent_free .'%</span>)';
                                                                    $system['sysFREESPACE'] = $free_space . ' GiB';

                                                                } else {
                                                                    echo $free_space . ' GiB';
                                                                }

                                                            } else {
                                                                echo _FPA_U;
                                                            }
                                                        ?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="text-capitalize"><?php echo _FPA_SERV; ?> Name</td>
                                                    <td>
                                                        <?php
                                                            if ( $showProtected == 0 ) {
                                                                echo $system['sysSERVNAME'];

                                                            } else {
                                                                echo '<span class="protected">'. _FPA_HIDDEN .'</span>';
                                                            }
                                                        ?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="text-capitalize"><?php echo _FPA_SERV; ?> IP Address</td>
                                                    <td>
                                                        <?php
                                                            if ( $showProtected == 0 ) {
                                                                echo $system['sysSERVIP'];

                                                            } else {
                                                                echo '<span class="protected">'. _FPA_HIDDEN .'</span>&nbsp;';
                                                            }
                                                        ?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="text-capitalize"><?php echo _FPA_SERV; ?> Signature</td>
                                                    <td>
                                                        <?php echo $system['sysSERVSIG']; ?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="text-capitalize"><?php echo _FPA_SERV; ?> Encoding</td>
                                                    <td>
                                                        <?php echo str_replace(',', ', ', $system['sysENCODING']); ?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="text-capitalize">Executing <?php echo _FPA_USR; ?></td>
                                                    <td>
                                                        <?php echo $system['sysEXECUSER']; ?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="text-capitalize"><?php echo _FPA_SERV .' '. _FPA_USR; ?></td>
                                                    <td>
                                                        <?php echo $system['sysWEBOWNER']; ?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="text-capitalize"><?php echo _FPA_SERV .' '.  _FPA_DROOT; ?></td>
                                                    <td>
                                                        <?php
                                                            if ( $showProtected == 0 ) {
                                                                echo '<span class="xsmall">'. $system['sysDOCROOT'] .'</span>';

                                                            } else {
                                                                echo '<span class="protected">'. _FPA_HIDDEN .'</span>';
                                                            }
                                                        ?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="text-capitalize"><?php echo _FPA_SERV; ?> /Tmp Directory</td>
                                                    <td class="xsmall">
                                                        <?php
                                                            if ( $showProtected == 0 ) {
                                                                echo $system['sysSYSTMPDIR'] .'<br />';

                                                            } else {
                                                                echo '<span class="protected">'. _FPA_HIDDEN .'</span><br />';
                                                            }

                                                            if ( $system['sysTMPDIRWRITABLE'] == _FPA_Y ) {
                                                                $wColor = 'success';

                                                            } elseif ( $system['sysTMPDIRWRITABLE'] == _FPA_N ) {
                                                                $wColor = 'danger';

                                                            } else {
                                                                $system['sysTMPDIRWRITABLE'] = _FPA_U;
                                                            }
                                                            echo _FPA_WRITABLE.': <span class="text-'. $wColor .'">'. $system['sysTMPDIRWRITABLE'] .'</span>';
                                                        ?>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>

                                        <?php
                                        /**
                                         * permisison & ownership checks
                                         *
                                         * very basic checks for PHP API and process/executing user & current user
                                         * designed to replace the old 'funky' and generally inaccurate suExec routines
                                         *
                                         * if not 'cgi' then is very likely to have issues unless there is a custom cloud
                                         * solution in place
                                         *
                                         * however, if not cgi but the current & process user match, it's likely to be a
                                         * custom/cloud solution and might be ok
                                         *
                                         * if is 'cgi' then the process and current should match with no issues. however,
                                         * some cloud solutions 'fuzz' this method and users don't always have to match
                                         * @RussW added 24/05/2020
                                         *
                                         */
                                        ?>
                                        <table class="table table-striped table-bordered">
                                            <thead>
                                                <tr>
                                                    <td colspan="3" class="bg-info text-white">Switch  <?php echo  _FPA_USR .' '.  _FPA_CFG; ?></td>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td class="text-center">Server suExec</td>
                                                    <td class="text-center">PHP suExec</td>
                                                    <td class="text-center">Ownership</td>
                                                </tr>
                                                <tr>
                                                    <td class="text-center lead">
                                                        <?php
                                                            if ($phpenv['phpAPACHESUEXEC'] == _FPA_Y OR substr($phpenv['phpAPI'], 0, 4) == 'lite') {
                                                                $sColor = 'success';
                                                                $phpenv['phpAPACHESUEXEC'] = _FPA_Y;

                                                            } elseif ($phpenv['phpAPACHESUEXEC'] == _FPA_N) {
                                                                $sColor = 'warning';

                                                            } else {
                                                                $phpenv['phpAPACHESUEXEC'] = _FPA_U;
                                                                $sColor = '';
                                                            }
                                                            echo '<span class="badge badge-pill badge-'. $sColor .'">'. $phpenv['phpAPACHESUEXEC'] .'</span>';
                                                        ?>
                                                    </td>
                                                    <td class="text-center lead">
                                                        <?php
                                                            if ($phpenv['phpPHPSUEXEC'] == _FPA_Y) {
                                                                $sColor = 'success';

                                                            } elseif ($phpenv['phpPHPSUEXEC'] == _FPA_N) {
                                                                $sColor = 'warning';

                                                            } else {
                                                                $phpenv['phpPHPSUEXEC'] = _FPA_U;
                                                                $sColor = '';
                                                            }
                                                            echo '<span class="badge badge-pill badge-'. $sColor .'">'. $phpenv['phpPHPSUEXEC'] .'</span>';
                                                        ?>
                                                    </td>
                                                    <td class="text-center xsmall">
                                                        <span class="text-muted">Current User:</span> <?php echo  $system['sysCURRUSER']; ?><br />
                                                        <span class="text-muted">Process User:</span> <?php echo  $system['sysEXECUSER']; ?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="3">
                                                        <?php
                                                        /* OLD SUEXEC ROUTINE @RussW
                                                            if ($phpenv['phpAPACHESUEXEC'] != _FPA_Y AND $phpenv['phpPHPSUEXEC'] != _FPA_Y) {
                                                                    // not handlers installed
                                                                    $suColor = 'danger';
                                                                    $suStatus = _FPA_Y;
                                                                    $suMSG    = 'No user process permission or ownership management utilites available. Without a custom management utility you will have problems with file permissions and ownership';

                                                            } elseif (stristr($phpenv['phpAPI'], 'cgi') === FALSE) { // NOT cgi

                                                                if (($system['sysCURRUSER'] == $system['sysEXECUSER'])) {
                                                                    // not cgi but has Apache suExec and the users match
                                                                    $suColor = 'warning';
                                                                    $suStatus = _FPA_M;
                                                                    $suMSG    = 'Depending on any custom effective perrmissions, extension & template installations and file & image uploads might work.';

                                                                } elseif ($phpenv['phpAPACHESUEXEC'] == _FPA_Y AND ($system['sysCURRUSER'] != $system['sysEXECUSER'])) {
                                                                    $suColor = 'warning';
                                                                    $suStatus = _FPA_Y;
                                                                    $suMSG    = 'Extension & template installations and file & image uploads are very unlikely to work.';

                                                                } else {
                                                                    $suColor  = 'warning';
                                                                    $suStatus = _FPA_U;
                                                                    $suMSG    = 'Unable to determine effective perrmissions or ownership information.';
                                                                }

                                                            } else { // is php cgi

                                                                if ($system['sysCURRUSER'] == $system['sysEXECUSER']) {
                                                                    // is cgi and users match
                                                                    $suColor  = 'success';
                                                                    $suStatus = _FPA_N;
                                                                    $suMSG    = 'Extension & template installations and file & image uploads should not have any problems.';

                                                                } elseif ($system['sysCURRUSER'] != $system['sysEXECUSER']) {
                                                                        // is cgi and users dont match (weird)
                                                                        $suColor  = 'warning';
                                                                        $suStatus = _FPA_M;
                                                                        $suMSG    = 'Extension & template installations and file & image uploads might have some problems.';

                                                                } else {
                                                                    $suColor  = 'dark';
                                                                    $suStatus = _FPA_U;
                                                                    $suMSG    = 'Unable to determine effective perrmissions or ownership information.';
                                                                }
                                                            }
                                                        */


                                                            /**
                                                             * Simplified "effective" rights testing
                                                             * this routine is designed to try and determine if the user is, or will have, problems
                                                             * installing extensions or uploading files due to ownershop/permission configuration
                                                             * - only runs if an instance is found
                                                             *
                                                             * test a directory and the fpa script itself for "writable" status
                                                             * - if BOTH the test items are user writable then ownership obviously isn't a problem - display NO
                                                             * - if ONLY ONE test item is writable then we have non-standard permissions : display MAYBE
                                                             * - else if above criteria is not met (ie: both items are NOT writable) : display YES
                                                             *
                                                             * then check both items for elevated permissions, which may indicate a need raise modeset to achieve access
                                                             * assumed modeset defaults - Directory: 755, File: 644
                                                             * - raise a warning message elevated permisions are found
                                                             *
                                                             * NOTE: this test routine is now independant of the suExec (Switch User) status
                                                             * - this means the suExec (& user) status is purely informational now
                                                             * - this caters for litespeed using setUID and custom/Cloud solutions
                                                             * - this is a more robust method than using the presence of suExec, using the users own
                                                             *   "effective" rights to test for ownership or permission issues
                                                             *
                                                             * added @RussW 04/05/2020
                                                             *
                                                             */
                                                            if ( $instance['instanceFOUND'] == _FPA_Y ) {

                                                                $dirTOTest   = 'components';
                                                                $dirEPCheck  = substr( sprintf('%o', fileperms( $dirTOTest ) ),-3, 3 );
                                                                $fileEPCheck = substr( sprintf('%o', fileperms( basename($_SERVER['PHP_SELF']) ) ),-3, 3 );

                                                                if ( is_writeable(basename($_SERVER['PHP_SELF'])) AND is_writeable('components') ) {
                                                                    $suColor     = 'success';
                                                                    $suStatus    = _FPA_N;
                                                                    $suMSG       = 'Extension & template installations, file & image uploads should not have any problems.';
                                                                    $elevatedMSG = '';

                                                                } elseif ( !is_writeable(basename($_SERVER['PHP_SELF'])) XOR !is_writeable('components') ) {
                                                                    $suColor     = 'info';
                                                                    $suStatus    = _FPA_M;
                                                                    $suMSG       = 'Extension & template installations, file & image uploads might have some problems.';
                                                                    $elevatedMSG = 'Permissions are non-standard and may cause issues.';

                                                                } else {
                                                                    $suColor     = 'warning';
                                                                    $suStatus    = _FPA_Y;
                                                                    $suMSG       = 'Extension & template installations, file & image uploads are likely to have problems.';
                                                                    $elevatedMSG = '';
                                                                }

                                                                // display a warnng message if any "actual" permissions are elevated,
                                                                // this may indicate a need to raise modeset to make user writable
                                                                if ( ( substr($dirEPCheck,1 ,1) > '5' OR substr($dirEPCheck,2 ,1) > '5' ) OR ( substr($fileEPCheck,0 ,1) > '6' OR substr($fileEPCheck,1 ,1) > '4' OR substr($fileEPCheck,2 ,1) > '4' ) ) {
                                                                    $elevatedMSG = 'Permissions may have been elevated to overcome access problems.';
                                                                    if ( $isWINLOCAL == '1' ) {
                                                                        $elevatedMSG = $elevatedMSG.' '._FPA_WIN_LOCALHOST;
                                                                    }
                                                                }

                                                            } else {
                                                                $suColor     = 'info';
                                                                $suStatus    = _FPA_U;
                                                                $suMSG       = 'No Joomla! instance found to test';
                                                                $elevatedMSG = '';
                                                            } // instanceFOUND, effective rights test
                                                        ?>

                                                        <?php echo _FPA_PERMOWN; ?> Problems&nbsp;:&nbsp;<span class="badge badge-<?php echo $suColor; ?>"><?php echo $suStatus; ?></span>&nbsp;<span class="badge badge-light"><?php echo $phpenv['phpAPI']; ?></span>
                                                        <p class="my-1"><?php echo $suMSG; ?> <span class="text-warning"><?php echo $elevatedMSG; ?></span></p>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>

                                    <?php showDev( $system ); ?>
                                    </div>
                                </div><!--/.card (system)-->

                            </div><!--/.col-->
                        </div><!--./row hosting-discovery-->

                        <div class="row row-cols-12 print-break-after php-extensions">
                            <div class="col mb-4 d-flex align-self-stretch">

                                <div class="card border shadow w-100">
                                    <div class="card-header bg-info text-white"><?php echo $phpextensions['ARRNAME'] .' :: '. _FPA_DISC; ?></div>
                                    <div class="card-body">

                                        <div class="row row-cols-2 row-cols-xs-3 row-cols-sm-4 row-cols-lg-6">

                                            <?php
                                                foreach ( $phpextensions as $key => $show ) {
                                                    if ( $show != $phpextensions['ARRNAME'] ) {

                                                        if ( $key == 'exif' ) {
                                                            $pieces = explode( " $", $show );
                                                            $show = $pieces[0];
                                                        }

                                                        // find and highlight the requirements and mark them as present or missing
                                                        if ( $key == 'libxml' OR $key == 'xml' OR $key == 'zip' OR $key == 'openssl' OR $key == 'zlib' OR $key == 'curl' OR $key == 'iconv' OR $key == 'mbstring' OR $key == 'mysql' OR $key == 'mysqli' OR $key == 'pdo_mysql' OR $key == 'mcrypt' OR $key == 'sodium' OR $key == 'suhosin' OR $key == 'cgi' OR $key == 'cgi-fcgi' ) {
                                                            $status = 'dark';
                                                            $border = 'dark';
                                                            $weight = 'bolder';

                                                        } elseif ( $key == 'apache2handler') {
                                                            $status = 'warning';
                                                            $border = 'warning';
                                                            $weight = 'bold';

                                                        } else {
                                                            $status = 'dark';
                                                            $border = 'default';
                                                            $weight = 'normal';
                                                        }

                                                        if (empty($show)) {
                                                            $show = '-';
                                                        }

                                                        echo '<div class="col d-flex align-self-stretch">';
                                                        echo '<div class="bg-light border border-'.$border.' text-center small mb-2 w-100">';
                                                        echo '<div class="text-'.$status.' font-weight-'.$weight.' px-1 py-2">'. $key .'</div>';
                                                        echo '<div class="bg-white text-truncate px-1 py-2">'.$show.'</div>';
                                                        echo '</div>';
                                                        echo '</div>';

                                                    } // dont show if ARRNAME

                                                        // look for recommended extensions that aren't installed
                                                        if ( !in_array( $key, $phpreq ) ) {
                                                            unset ( $phpreq[$key] );
                                                        }

                                                } //foreach $phpextensions
                                            ?>
                                        </div><!--row-->

                                        <?php
                                            if ( version_compare( $instance['cmsRELEASE'], '3.8', '>=') OR version_compare( $phpenv['phpVERSION'], '7.2.0', '>=' ))   {
                                                unset($phpreq['mcrypt']);
                                            }

                                            if (version_compare( $phpenv['phpVERSION'], '7.0.0', '>=' ))   {
                                                unset($phpreq['mysql']);
                                            }

                                            if ( $phpreq ) {
                                                echo '<h6 class="mt-3">'. _FPA_POTME .':</h6>';
                                                echo '<div class="row row-cols-2 row-cols-xs-3 row-cols-sm-4 row-cols-lg-6">';

                                                foreach ( $phpreq as $missingkey => $missing ) {
                                                    echo '<div class="col">';
                                                    echo '<div class="border border-warning text-warning text-center xsmall p-2 mb-2">'. $missingkey .'</div>';
                                                    echo '</div>';
                                                }

                                                echo '</div>';
                                            }
                                        ?>

                                    <?php showDev( $phpextensions ); ?>
                                    <?php showDev( $phpreq ); ?>
                                    </div>
                                </div><!--/.card (php extensions)-->

                            </div><!--/.col-->
                        </div><!--row (php extensions)-->

                        <?php if ( $phpenv['phpAPI'] == 'apache2handler' ) { ?>

                            <div class="row row-cols-12 print-break-after apache-modules">
                                <div class="col mb-4 d-flex align-self-stretch">

                                    <div class="card border shadow w-100">
                                        <div class="card-header bg-info text-white"><?php echo $apachemodules['ARRNAME'] .' :: '. _FPA_DISC; ?></div>
                                        <div class="card-body">

                                            <div class="row row-cols-2 row-cols-xs-3 row-cols-sm-4 row-cols-lg-6">

                                                <?php
                                                    foreach ( $apachemodules as $key => $show ) {

                                                        if ( $show != $apachemodules['ARRNAME'] ) {

                                                            // find and highlight the requirements and mark them as present or missing
                                                            if ( $show == 'mod_rewrite' OR $show == 'mod_cgi' OR $show == 'mod_cgid' OR $show == 'mod_expires' OR $show == 'mod_deflate' OR $show == 'mod_auth'  ) {
                                                                $status = 'success';
                                                                $border = 'success';
                                                                $weight = 'bolder';

                                                            } elseif ( $show == 'mod_php4' OR $show == 'mod_php5' ) {
                                                                $status = 'warning';
                                                                $border = 'warning';
                                                                $weight = 'bold';

                                                            } else {
                                                                $status = 'dark';
                                                                $border = 'default';
                                                                $weight = 'normal';
                                                            }
                                                            echo '<div class="col d-flex align-self-stretch">';
                                                            echo '<div class="bg-light border border-'.$border.' text-center small mb-2 w-100">';
                                                            echo '<div class="text-'.$status.' font-weight-'.$weight.' px-1 py-2">'. $show .'</div>';
                                                            echo '</div>';
                                                            echo '</div>';

                                                        } // dont show if ARRNAME

                                                            // look for recommended modules that aren't installed
                                                            if ( !in_array( $show, $apachereq ) ) {
                                                                unset ( $apachereq['ARRNAME'] );
                                                                unset ( $apachereq[$show] );
                                                            }

                                                    } //foreach $apachemodules
                                                ?>
                                            </div><!--row-->

                                            <?php
                                                if ( $apachereq ) {
                                                    echo '<h6 class="mt-3">'. _FPA_POTMM .':</h6>';
                                                    echo '<div class="row row-cols-2 row-cols-xs-3 row-cols-sm-4 row-cols-lg-6">';

                                                    foreach ( $apachereq as $missingkey => $missing ) {
                                                        echo '<div class="col">';
                                                        echo '<div class="border border-warning text-warning text-center xsmall p-2 mb-2">'. $missingkey .'</div>';
                                                        echo '</div>';
                                                    }

                                                    echo '</div>';
                                                }

                                                unset ( $key, $show );
                                            ?>

                                        <?php showDev( $apachemodules ); ?>
                                        <?php $apachereq['ARRNAME'] = 'Potential Missing Apache Modules'; ?>
                                        <?php showDev( $apachereq ); ?>
                                        </div>
                                    </div><!--/.card (apache modules)-->

                                </div><!--/.col-->
                            </div><!--row (apache modules)-->

                        <?php } // end apache-modules ?>

                        <div class="row row-cols-1 row-cols-lg-2 database-discovery">
                            <div class="col mb-4 d-flex align-self-stretch">

                                <div class="card border shadow w-100">
                                    <div class="card-header bg-info text-white"><?php echo $database['ARRNAME'] .' :: '. _FPA_DISC; ?></div>
                                    <div class="card-body">

                                        <table class="table table-striped table-bordered table-sm">
                                            <tbody>
                                                <tr class="flex-fill">
                                                    <td class="text-capitalize w-50"><?php echo @$instance['configDBTYPE'] .' '. _FPA_VER; ?></td>
                                                    <td>
                                                        <?php
                                                            if ( @$database['dbHOSTSERV'] ) {
                                                                echo  _FPA_SERV .': '. $database['dbHOSTSERV'];

                                                            } else {
                                                                echo _FPA_SERV .': <span class="text-warning">'. _FPA_U .'</span>';
                                                            }

                                                            if ( @$database['dbHOSTCLIENT'] ) {
                                                                echo '<br />'. _FPA_CLNT .': '. substr ($database['dbHOSTCLIENT'], 0, 30) .'...';

                                                            } else {
                                                                echo '<br />'. _FPA_CLNT .': <span class="text-warning">'. _FPA_U .'</span>';
                                                            }
                                                        ?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="text-capitalize"><?php echo @$instance['configDBTYPE'] .' '. _FPA_HNAME; ?></td>
                                                    <td>
                                                        <?php
                                                            if ( $showProtected == 0 ) {

                                                                if ( $instance['configDBHOST'] ) {
                                                                    echo $instance['configDBHOST'];

                                                                } else {
                                                                    echo '<span class="text-danger">'. _FPA_NC .'</span>';
                                                                }

                                                            } else {
                                                                echo '<span class="protected">'. _FPA_HIDDEN .'</span>';
                                                            }
                                                        ?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="text-capitalize"><?php echo  _FPA_CONT; ?></td>
                                                    <td>
                                                        <?php
                                                            if ( $database['dbLOCAL'] == _FPA_Y ) {
                                                                echo '('. _FPA_LOCAL .') '. @$database['dbHOSTINFO'];

                                                            } elseif ( $database['dbLOCAL'] == _FPA_N AND @$database['dbHOSTINFO'] ) {

                                                                if ( $showProtected == 0 ) {
                                                                    echo '('. _FPA_REMOTE .') '. $database['dbHOSTINFO'];

                                                                } else {
                                                                    echo '<span class="protected">'. _FPA_HIDDEN .'</span>';
                                                                }

                                                            } elseif ( $database['dbLOCAL'] == _FPA_N AND !@$database['dbHOSTINFO'] ) {
                                                                echo '('. _FPA_REMOTE .') <span class="text-warning"> '. _FPA_U .'</span>';

                                                            } else {
                                                                echo '<span class="text-warning">'. _FPA_U .'</span>';
                                                            }
                                                        ?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="text-capitalize">PHP <?php echo _FPA_SUP; ?></td>
                                                    <td>
                                                        <?php
                                                            if ( @$instance['configDBTYPE'] == 'mysqli' AND $phpenv['phpSUPPORTSMYSQLI'] == _FPA_N ) {
                                                                echo '<span class="text-danger">'. $instance['configDBTYPE'] .' '. _FPA_IS .' '. _FPA_NSUP .' '. _FPA_BY .' PHP '. $phpenv['phpVERSION'] .'</span>';

                                                            } elseif (  @$instance['configDBTYPE'] == 'mysql' AND $phpenv['phpSUPPORTSMYSQL'] == _FPA_N ) {
                                                                echo '<span class="text-danger">'. $instance['configDBTYPE'] .' '. _FPA_IS .' '. _FPA_NSUP .' '. _FPA_BY .' PHP '. $phpenv['phpVERSION'] .'</span>';

                                                            } elseif ( ( @$instance['configDBTYPE'] == 'mysqli' AND $phpenv['phpSUPPORTSMYSQLI'] == _FPA_Y ) OR ( @$instance['configDBTYPE'] == 'mysql' AND $phpenv['phpSUPPORTSMYSQL'] == _FPA_Y ) OR @$instance['configDBTYPE'] == 'pdomysql' OR @$instance['configDBTYPE'] == 'postgresql'OR @$instance['configDBTYPE'] == 'pgsql') {
                                                                echo '<span class="text-success">'. $instance['configDBTYPE'] .' '. _FPA_IS .' '. _FPA_YSUP .' '. _FPA_BY .' PHP '. $phpenv['phpVERSION'] .'</span>';

                                                            } else {
                                                                echo '<span class="text-warning">PHP '. $phpenv['phpVERSION'] .' '. _FPA_SUP .' '. _FPA_IS .' '. _FPA_U .'</span>';
                                                            }
                                                        ?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="text-capitalize"><?php echo  _FPA_CON .' '. _FPA_TO .' '. @$instance['configDBTYPE']; ?></td>
                                                    <td>
                                                        <?php
                                                            if ( $database['dbDOCHECKS'] == _FPA_N ) {
                                                                echo '<span class="text-warning">'. _FPA_NOA .', '. _FPA_NC .'</span>';

                                                            } elseif ( @$database['dbERROR'] == _FPA_N ) {
                                                                echo '<span class="text-success">'. _FPA_Y .', '. _FPA_YCON .'</span>';

                                                            } elseif ( @$database['dbERROR'] != _FPA_N ) {
                                                                echo '<span class="text-danger">'. _FPA_N .', '. _FPA_ER .'</span>';
                                                            }
                                                        ?>
                                                    </td>
                                                </tr>

                                                <?php if ( @$database['dbERROR'] AND @$database['dbERROR'] != _FPA_N ) { ?>
                                                    <tr>
                                                        <td class="text-capitalize text-danger"><?php echo _FPA_ECON; ?></td>
                                                        <td>
                                                            <?php
                                                                echo '<span class="text-danger">'. $database['dbERROR'] .'</span>';
                                                            ?>
                                                        </td>
                                                    </tr>
                                                <?php } // dbERROR ?>

                                                <tr>
                                                    <td class="text-capitalize"><?php echo @$instance['configDBTYPE'] .' '. _FPA_CHARS; ?></td>
                                                    <td>
                                                        <?php
                                                            if ( @$database['dbCHARSET'] ) {
                                                                echo $database['dbCHARSET'];

                                                            } else {
                                                                echo '<span class="text-warning">'. _FPA_U .'</span>';
                                                            }
                                                        ?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="text-capitalize"><?php echo _FPA_DEF .' '. _FPA_CHARS; ?></td>
                                                    <td>
                                                        <?php
                                                            if ( @$database['dbHOSTDEFCHSET'] ) {
                                                                echo $database['dbHOSTDEFCHSET'];

                                                            } else {
                                                                echo '<span class="text-warning">'. _FPA_U .'</span>';
                                                            }
                                                        ?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="text-capitalize"><?php echo _FPA_DB .' '. _FPA_TCOL; ?></td>
                                                    <td>
                                                        <?php
                                                            if ( @$database['dbCOLLATION'] ) {
                                                                echo $database['dbCOLLATION'];

                                                            } elseif ( @$database['dbERROR'] != _FPA_N ) {
                                                                echo '<span class="text-warning">'. _FPA_U .'</span>';

                                                            } else {
                                                                echo '<span class="text-warning">'. _FPA_NC .'</span>';
                                                            }
                                                        ?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="text-capitalize"><?php echo _FPA_DB .' '. _FPA_TSIZ; ?></td>
                                                    <td>
                                                        <?php
                                                            if ( @$database['dbSIZE'] ) {
                                                                echo $database['dbSIZE'];

                                                            } else {
                                                                echo '<span class="text-warning">'. _FPA_U .'</span>';
                                                            }
                                                        ?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="2">User Privileges&nbsp;
                                                        <?php
                                                            if ( @$database['dbPRIVS'] ) {
                                                                if (stristr($database['dbPRIVS'], 'GRANT ALL')) {
                                                                    echo '<span class="badge badge-success xsmall text-lowercase mb-1 mr-1">'. substr($database['dbPRIVS'], 0, 9) .'</span>';

                                                                } else {
                                                                    $privPieces = explode(',', $database['dbPRIVS']);

                                                                    $i = 0;
                                                                    while ($i < count($privPieces)) {
                                                                        if ( stristr($privPieces[$i], 'TRIGGER') ) {
                                                                            echo '<span class="badge badge-info xsmall text-lowercase mb-1 mr-1">'. substr($privPieces[$i], 0, 8) .'</span>';

                                                                        }elseif ( stristr($privPieces[$i], 'GRANT PROXY ON') ) {
                                                                                echo '<span class="badge badge-info xsmall text-lowercase mb-1 mr-1">'. substr($privPieces[$i], 0, 11) .'</span>';

                                                                        } else {
                                                                            echo '<span class="badge badge-info xsmall text-lowercase mb-1 mr-1">'. $privPieces[$i] .'</span>';
                                                                        }
                                                                        $i++;
                                                                    }
                                                                }
                                                            } else {
                                                                echo '<span class="text-info">'. _FPA_U .'</span>';
                                                            }
                                                        ?>
                                                    </td>
                                                </tr>

                                                <?php if ( @$instance['configDBCREDOK'] != _FPA_Y AND $instance['instanceFOUND'] == _FPA_Y ) { ?>
                                                    <tr>
                                                        <td class="text-capitalize text-warning"><?php echo _FPA_MISSINGCRED; ?></td>
                                                        <td class="xsmall">
                                                            <?php
                                                                if ( @$instance['configDBTYPE'] == '' ) {
                                                                    echo _FPA_CONT .': <span class="text-warning">'. _FPA_NF .'</span><br />';
                                                                }
                                                                if ( @$instance['configDBHOST'] == '' ) {
                                                                    echo _FPA_DB.' '. _FPA_HNAME .': <span class="text-warning">'. _FPA_NF .'</span><br />';
                                                                }
                                                                if ( @$instance['configDBNAME'] == '' ) {
                                                                    echo _FPA_DB .' Name: <span class="text-warning">'. _FPA_NF .'</span><br />';
                                                                }
                                                                if ( @$instance['configDBPREF'] == '' ) {
                                                                    echo _FPA_TBL .' Prefix: <span class="text-warning">'. _FPA_NF .'</span><br />';
                                                                }
                                                                if ( @$instance['configDBUSER'] == '' ) {
                                                                    echo _FPA_DB .' '. _FPA_USER .': <span class="text-warning">'. _FPA_NF .'</span><br />';
                                                                }
                                                                if ( @$instance['configDBPASS'] == '' ) {
                                                                    echo _FPA_DB .' '. _FPA_PASS .': <span class="text-warning">'. _FPA_NF .'</span><br />';
                                                                }
                                                            ?>
                                                        </td>
                                                    </tr>
                                                <?php } // credentialsMissing ?>
                                            </tbody>
                                        </table>

                                    </div>
                                </div><!--/.card (discovery)-->

                            </div><!--/.col-->
                            <div class="col mb-4 d-flex align-self-stretch">

                                <div class="card border shadow w-100">
                                    <div class="card-header bg-info text-white"><?php echo $database['ARRNAME'] .' :: '. _FPA_PERF; ?></div>
                                    <div class="card-body">

                                        <table class="table table-striped table-bordered table-sm">
                                            <tbody>
                                                <?php if ( $database['dbDOCHECKS'] == _FPA_Y AND @$database['dbERROR'] == _FPA_N AND $instance['configDBTYPE'] <> 'postgresql' AND $instance['configDBTYPE'] <> 'pgsql' AND $instance['instanceFOUND'] == _FPA_Y) { ?>

                                                    <?php $pieces = explode( ':', $database['dbHOSTSTATS'][0] ); ?>
                                                    <tr class="flex-fill">
                                                        <td class="text-capitalize w-50"><?php echo $pieces[0]; ?></td>
                                                        <td>
                                                            <?php
                                                                /**
                                                                 * convert uptime from seconds to days, hours, minutes
                                                                 *
                                                                 * @param $seconds
                                                                 * @return $days $hours $minutes
                                                                 */
                                                                function uptimeToWords($seconds) {
                                                                    $days = intval(intval($seconds) / (3600*24));
                                                                    $hours = (intval($seconds) / 3600) % 24;
                                                                    $minutes = (intval($seconds) / 60) % 60;

                                                                    $days = $days ? $days . 'd ' : '';
                                                                    $hours = $hours ? $hours . 'h ' : '';
                                                                    $minutes = $minutes ? $minutes . 'm ' : '';

                                                                    return $days .' '. $hours .' '. $minutes;
                                                                }
                                                                echo uptimeToWords($pieces[1]);
                                                            ?>
                                                        </td>
                                                    </tr>

                                                    <?php $pieces = explode( ':', $database['dbHOSTSTATS'][1] ); ?>
                                                    <tr>
                                                        <td class="text-capitalize"><?php echo $pieces[0]; ?></td>
                                                        <td>
                                                            <?php echo $pieces[1]; ?>
                                                        </td>
                                                    </tr>

                                                    <?php $pieces = explode( ':', $database['dbHOSTSTATS'][2] ); ?>
                                                    <tr>
                                                        <td class="text-capitalize"><?php echo $pieces[0]; ?></td>
                                                        <td>
                                                            <?php echo $pieces[1]; ?>
                                                        </td>
                                                    </tr>

                                                    <?php $pieces = explode( ':', $database['dbHOSTSTATS'][3] ); ?>
                                                    <tr>
                                                        <td class="text-capitalize"><?php echo $pieces[0]; ?></td>
                                                        <td>
                                                            <?php echo $pieces[1]; ?>
                                                        </td>
                                                    </tr>

                                                    <?php $pieces = explode( ':', $database['dbHOSTSTATS'][4] ); ?>
                                                    <tr>
                                                        <td class="text-capitalize"><?php echo $pieces[0]; ?></td>
                                                        <td>
                                                            <?php echo $pieces[1]; ?>
                                                        </td>
                                                    </tr>

                                                    <?php $pieces = explode( ':', $database['dbHOSTSTATS'][5] ); ?>
                                                    <tr>
                                                        <td class="text-capitalize"><?php echo $pieces[0]; ?></td>
                                                        <td>
                                                            <?php echo $pieces[1]; ?>
                                                        </td>
                                                    </tr>

                                                    <?php $pieces = explode( ':', $database['dbHOSTSTATS'][6] ); ?>
                                                    <tr>
                                                        <td class="text-capitalize"><?php echo $pieces[0]; ?></td>
                                                        <td>
                                                            <?php echo $pieces[1]; ?>
                                                        </td>
                                                    </tr>

                                                    <?php $pieces = explode( ':', $database['dbHOSTSTATS'][7] ); ?>
                                                    <tr>
                                                        <td class="text-capitalize"><?php echo $pieces[0]; ?></td>
                                                        <td>
                                                            <?php echo $pieces[1]; ?>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="text-capitalize">No. Tables</td>
                                                        <td>
                                                            <?php
                                                                if ( $database['dbTABLECOUNT'] ) {
                                                                    echo $database['dbTABLECOUNT'] .' tables';

                                                                } else {
                                                                    echo '<span class="text-warning">'. _FPA_U .'</span>';
                                                                }
                                                            ?>
                                                        </td>
                                                    </tr>

                                                <?php } else { ?>

                                                    <tr>
                                                        <td class="text-center">
                                                            <?php
                                                                if (@$instance['configDBTYPE'] == 'postgresql' or @$instance['configDBTYPE'] == 'pgsql'){
                                                                    echo _FPA_NIMPLY . ' ' . _FPA_PGSQL;

                                                                } elseif ( @$instance['configDBTYPE'] == 'sqlsrv' ) {
                                                                    echo '<span class="text-warning">'.  _FPA_MSSQL_SUPP .'</span>';

                                                                } else {
                                                                    echo '<span class="text-warning">'. _FPA_NCON .'<br />'. _FPA_NO .' '. $database['ARRNAME'] .' '. _FPA_PERF .' '. _FPA_TESTP .'</span>';
                                                                }
                                                            ?>
                                                        </td>
                                                    </tr>

                                                <?php } ?>
                                            </tbody>
                                        </table>

                                    </div>
                                </div><!--/.card (performance)-->

                            </div><!--/.col-->
                        </div><!--./row (database-discovery)-->

                    <?php showDev( $database ); ?>
                    </div><!--/.container-->
                </section><!--#instance-discovery-->

            <?php } // dont show if doVEL = 1 ?>



            <?php
            /**
             * instance database table list (optional)
             *
             */
            ?>
            <?php if ( $showTables == '1' ) { ?>

                <section class="py-3 break-before pdf-break-before" id="database-tables">
                    <div class="container mt-5">

                        <h2 class="border-bottom mb-4"><?php echo _FPA_DB .' '. _FPA_DBTBL_TITLE; ?></h2>

                        <div class="d-md-none d-lg-none d-xl-none small text-center bg-warning text-white p-2 mb-2">Best viewed in landscape or larger viewports</div>

                        <div class="table-responsive-md">

                            <table class="table table-striped table-bordered table-sm">
                                <thead>
                                    <tr class="bg-info text-white xsmall">
                                        <th class="py-2"><?php echo _FPA_TNAM; ?></th>
                                        <th class="py-2 text-center"><?php echo _FPA_TSIZ; ?></th>
                                        <th class="py-2 text-center"><?php echo _FPA_TREC; ?></th>
                                        <th class="py-2 text-center d-none d-lg-table-cell"><?php echo _FPA_TAVL; ?></th>
                                        <th class="py-2 text-center d-none d-lg-table-cell"><?php echo _FPA_TFRA; ?></th>
                                        <th class="py-2 text-center"><?php echo _FPA_TENG; ?></th>
                                        <th class="py-2 text-center"><?php echo _FPA_TCOL; ?></th>
                                        <th class="py-2 text-center d-none d-md-table-cell"><?php echo _FPA_TCRE; ?></th>
                                        <th class="py-2 text-center d-none d-lg-table-cell"><?php echo _FPA_TUPD; ?></th>
                                        <th class="py-2 text-center d-none d-lg-table-cell"><?php echo _FPA_TCKD; ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php
                                    if ( $instance['instanceFOUND'] == _FPA_Y AND @$database['dbERROR'] == _FPA_N ) {

                                        // initialise some variables for table footer statistics
                                        $dbTotalTABL =  count($tables);
                                        $dbTotalSIZE = 0;
                                        $dbTotalRCDS = 0;
                                        $dbTotalFRAG = 0;

                                        foreach ( $tables as $i => $show ) {

                                            if ( $show != $tables['ARRNAME'] ) {

                                                if ( (float)str_ireplace(' KiB', '', $show['FRAGSIZE'] > 0 )) {
                                                    $fragClass = 'text-info';
                                                } else {
                                                    $fragClass = 'text-dark';
                                                }

                                                echo '<tr>';

                                                if ( $showProtected == 0 ) {
                                                    echo '<td class="xsmall">'. $show['TABLE'] .'</td>';
                                                } else {
                                                    echo '<td class="xsmall"><span class="protected">'. _FPA_HIDDEN .'</span></td>';
                                                }

                                                echo '<td class="xsmall text-center">'. $show['SIZE'] .'</td>';
                                                echo '<td class="xsmall text-center">'. $show['RECORDS'] .'</td>';
                                                echo '<td class="xsmall text-center d-none d-lg-table-cell">'. $show['AVGLEN'] .'</td>';
                                                echo '<td class="xsmall text-center d-none d-lg-table-cell '.$fragClass.'">'. $show['FRAGSIZE'] .'</td>';
                                                echo '<td class="xsmall text-center">'. $show['ENGINE'] .'</td>';
                                                echo '<td class="xsmall text-center">'. $show['COLLATION'] .'</td>';

                                                $pieces = explode( " ", $show['CREATED'] );
                                                echo '<td class="xsmall text-center d-none d-md-table-cell">'. $pieces['0'] .'</td>';

                                                $pieces = explode( " ", $show['UPDATED'] );
                                                echo '<td class="xsmall text-center d-none d-lg-table-cell">'. $pieces['0'] .'</td>';

                                                $pieces = explode( " ", $show['CHECKED'] );
                                                echo '<td class="xsmall text-center d-none d-lg-table-cell">'. $pieces['0'] .'</td>';

                                                // calculate some statistics for the table footer as we iterate the database array
                                                $dbTotalSIZE = $dbTotalSIZE + str_ireplace(' KiB', '', $show['SIZE']);
                                                $dbTotalRCDS = $dbTotalRCDS + $show['RECORDS'];

                                                // only calculate if configDBTYPE not postgres
                                                if ( @$instance['configDBTYPE'] != 'postgresql' AND @$instance['configDBTYPE'] != 'pgsql' ) {
                                                    $dbTotalFRAG = $dbTotalFRAG + str_ireplace(' KiB', '', $show['FRAGSIZE']);
                                                    $dbFragPERC  = number_format(($dbTotalFRAG / $dbTotalSIZE) * 100);
                                                }

                                                echo '</tr>';

                                            } // endif , dont show array name

                                        } // end foreach
                                        ?>

                                </tbody>

                                        <?php
                                        // calculated database statistics
                                        echo '<tfoot>';
                                        echo '<tr class="bg-info text-white xsmall">';
                                        echo '<th class="py-2">'. _FPA_TNAM .'</th>';
                                        echo '<th class="py-2 text-center">'. _FPA_TSIZ .'</th>';
                                        echo '<th class="py-2 text-center">'. _FPA_TREC .'</th>';
                                        echo '<th class="py-2 text-center d-none d-lg-table-cell">'. _FPA_TAVL .'</th>';
                                        echo '<th class="py-2 text-center d-none d-lg-table-cell">'. _FPA_TFRA .'</th>';
                                        echo '<th class="py-2 text-center">'. _FPA_TENG .'</th>';
                                        echo '<th class="py-2 text-center">'. _FPA_TCOL .'</th>';
                                        echo '<th class="py-2 text-center d-none d-md-table-cell">'. _FPA_TCRE .'</th>';
                                        echo '<th class="py-2 text-center d-none d-lg-table-cell">'. _FPA_TUPD .'</th>';
                                        echo '<th class="py-2 text-center d-none d-lg-table-cell">'. _FPA_TCKD .'</th>';
                                        echo '</tr>';
                                        echo '<tr class="text-info">';
                                        echo '<td>'. ($dbTotalTABL -1) .' Tables</td>'; // -1 to not count the array name
                                        echo '<td class="text-center">'. sprintf( '%.2f', ( $dbTotalSIZE /1024 ) ) .' MiB</td>';
                                        echo '<td class="text-center">'. $dbTotalRCDS .'</td>';
                                        echo '<td class="d-none d-lg-table-cell"></td>';

                                        // only show if configDBTYPE not postgres
                                        if ( @$instance['configDBTYPE'] != 'postgresql' AND @$instance['configDBTYPE'] != 'pgsql' ) {
					    echo '<td class="text-center d-none d-lg-table-cell">'. sprintf( '%.2f', ( $dbTotalFRAG /1024 ) ) .' MiB<br />'.$dbFragPERC.'%</td>';
                                        } else {
                                            echo '<td></td>';
                                        }

                                        echo '<td></td>';
                                        echo '<td></td>';
                                        echo '<td class="d-none d-md-table-cell"></td>';
                                        echo '<td class="d-none d-lg-table-cell"></td>';
                                        echo '<td class="d-none d-lg-table-cell"></td>';
                                        echo '</tr>';
                                        echo '</tfoot>';

                                    } else { // an instance wasn't found in the initial checks, so no tables to check
                                        echo '<tr class="table-warning text-center p-3">';
                                        echo '<td class="lead" colspan="10">'. _FPA_NCON .', '. _FPA_NO .' '. $tables['ARRNAME'] .' '. _FPA_TESTP .'</td>';
                                        echo '</tr>';
                                    }

                                ?>
                            </table>

                        </div><!--/.table-responsive-->

                        <?php showDev( $tables ); ?>
                    </div><!--/.container-->
                </section>

            <?php } // end showTables?>



            <?php
            /**
             * instance known directory & elevated permisisons list (optional)
             *
             * dont show if doVEL = 1
             * added @RussW 29/05/2020
             *
             */
            ?>
            <?php if ( @$_POST['doVEL'] != 1 ) { ?>

                <section class="py-3 break-before pdf-break-before" id="folder-checks">

                    <div class="container mt-5">

                        <h2 class="border-bottom mb-4"><?php echo $folders['ARRNAME'] .' '. $modecheck['ARRNAME']; ?></h2>

                        <div class="d-md-none d-lg-none d-xl-none small text-center bg-warning text-white p-2 mb-2">Best viewed in landscape or larger viewports</div>

                        <div class="table-responsive-md">

                            <table class="table table-striped table-bordered table-sm">
                                <thead>
                                    <tr class="bg-info text-white xsmall">
                                        <th class="py-2"><?php echo _FPA_FOLDER; ?></th>
                                        <th class="py-2 text-center"><?php echo _FPA_MODE; ?></th>
                                        <th class="py-2 text-center"><?php echo _FPA_WRITABLE; ?></th>
                                        <th class="py-2 text-center d-none d-md-table-cell"><?php echo _FPA_OWNER; ?></th>
                                        <th class="py-2 text-center d-none d-lg-table-cell"><?php echo _FPA_GROUP; ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php
                                    if ( $instance['instanceFOUND'] == _FPA_Y ) {

                                        foreach ( $folders as $i => $show ) {

                                            if ( $show != 'Core Folders' ) {

                                                echo '<tr>';

                                                /**
                                                 * modeset checks
                                                 *
                                                 * looking for --7 or -7- or -77 (default folder permissions are usually 755)
                                                 *
                                                 */
                                                if ( substr( $modecheck[$show]['mode'],1 ,1 ) == '7' OR substr( $modecheck[$show]['mode'],2 ,1 ) == '7' ) {
                                                    $modeClass  = 'white bg-danger';
                                                    $alertClass = 'danger';
                                                    $userClass  = 'default';
                                                    $groupClass = 'default';

                                                } elseif ( $modecheck[$show]['mode'] == '755' ) {
                                                    $modeClass  = 'success';
                                                    $alertClass = 'success';
                                                    $userClass  = 'default';
                                                    $groupClass = 'default';

                                                } else if ( substr( $modecheck[$show]['mode'],0 ,1 ) <= '5' AND $modecheck[$show]['mode'] != '---' ) {
                                                    $modeClass  = 'white bg-warning ';
                                                    $alertClass = 'warning';
                                                    $userClass  = 'default';
                                                    $groupClass = 'default';

                                                } else if ( $modecheck[$show]['group']['name'] == _FPA_N ) {
                                                    $modeClass  = 'white bg-warning';
                                                    $alertClass = 'warning';
                                                    $userClass  = 'warning';
                                                    $groupClass = 'warning';

                                                } else {
                                                    $modeClass  = 'default';
                                                    $alertClass = 'default';
                                                    $userClass  = 'default';
                                                    $groupClass = 'default';
                                                }

                                                /**
                                                 * effective writeable permissions
                                                 *
                                                 * is the folder writable by the executing user
                                                 *
                                                 */
                                                if ( ( $modecheck[$show]['writable'] != _FPA_Y ) ) {
                                                    $writeClass = 'warning';

                                                } elseif ( ( $modecheck[$show]['writable'] == _FPA_Y ) AND ( substr( $modecheck[$show]['mode'],0 ,1 ) == '7' ) ) {
                                                    $writeClass = 'success';

                                                } elseif ( $modecheck[$show]['writable'] == _FPA_N ) {
                                                    $writeClass = 'danger';

                                                } else {
                                                    $writeClass = 'muted';
                                                }

                                                /**
                                                 * users effective rights on folder
                                                 *
                                                 * does the folder exist? if so,
                                                 * does the folder actual owner equal the effective (executing) owner? if not,
                                                 * does the folder actual user group equal the effective (executing) user group?
                                                 */
                                                // is the 'executing' owner the same as the folder owner? and is the users groupID the same as the folders groupID?
                                                if ( ( $modecheck[$show]['owner']['name'] != $system['sysEXECUSER'] ) AND ( $modecheck[$show]['group']['name'] != _FPA_DNE ) ) {
                                                    $userClass  = 'warning';
                                                    $groupClass = 'default';

                                                } elseif ( isset( $modecheck[$show]['group']['gid'] ) AND isset( $modecheck[$show]['owner']['gid'] ) ) {

                                                    if ( $modecheck[$show]['group']['gid'] != $modecheck[$show]['owner']['gid'] ) {
                                                        $userClass  = 'default';
                                                        $groupClass = 'warning';
                                                    }

                                                } elseif ( $modecheck[$show]['group']['name'] == _FPA_DNE ) {
                                                    $modeClass  = 'warning';
                                                    $alertClass = 'warning';
                                                    $writeClass = 'warning';
                                                    $userClass  = 'warning';
                                                    $groupClass = 'warning';
                                                }

                                                echo '<td class="text-'.$alertClass.'">';
                                                echo $show;
                                                    if ($modecheck[$show]['mode'] == '---') {
                                                        echo ' <span class="xsmall">('. _FPA_DNE .')</span>';
                                                    }
                                                echo '</td>';
                                                echo '<td class="text-'.$modeClass.' text-center">'. $modecheck[$show]['mode'] .'</td>';
                                                echo '<td class="text-'.$writeClass.' text-center">';
                                                    // change writable status to visual icon cues instead of text
                                                    if ($modecheck[$show]['writable'] == _FPA_Y) {
                                                        echo '<i class="fas fa-check-circle fa-lg"></i>';

                                                    } elseif ($modecheck[$show]['writable'] == _FPA_N) {
                                                        echo '<i class="fas fa-times-circle fa-lg"></i>';

                                                    } elseif ($modecheck[$show]['writable'] == '-') {
                                                        echo '<i class="fas fa-minus-circle fa-lg text-muted"></i>';

                                                    } else {
                                                        echo $modecheck[$show]['writable'];
                                                    }
                                                echo '</td>';
                                                echo '<td class="'.$userClass.' xsmall text-center d-none d-md-table-cell">'. $modecheck[$show]['owner']['name'] .'</td>';
                                                echo '<td class="'.$groupClass.' xsmall text-center d-none d-lg-table-cell">';
                                                    if ($modecheck[$show]['group']['name'] == _FPA_DNE) {
                                                        echo '-';

                                                    } else {
                                                        echo $modecheck[$show]['group']['name'];
                                                    }

                                                echo '</td>';

                                                echo '</tr>';

                                            } // endif , dont show array name

                                        } // end foreach

                                    } else { // an instance wasn't found in the initial checks, so no folders to check
                                        echo '<tr class="table-warning text-center p-3">';
                                        echo '<td class="lead" colspan="5">'. _FPA_INSTANCE .' '. _FPA_NF .', '. _FPA_N .' '. $modecheck['ARRNAME'] .' '. _FPA_TESTP .'</td>';
                                        echo '</tr>';
                                    }

                                ?>
                                </tbody>
                            </table>

                        </div><!--/.table-responsive permissions-->

                        <?php if ( $isWINLOCAL == '1' ) { echo _FPA_WIN_LOCALHOST; } // win localhost notice ?>

                        <?php showDev( $folders ); ?>
                        <?php showDev( $modecheck ); ?>
                        <?php unset ( $key, $show ); ?>
                    </div><!--/.container-->


                    <?php if ( $showElevated == '1' ) { ?>

                        <div class="container mt-5">

                            <h2 class="border-bottom mb-4"><?php echo $elevated['ARRNAME'] .' <span class="small text-muted">('. _FPA_FIRST .' 10)</span>'; ?></h2>

                            <div class="table-responsive-md">

                                <table class="table table-striped table-bordered table-sm">
                                    <thead>
                                        <tr class="bg-info text-white xsmall">
                                            <th class="py-2"><?php echo _FPA_FOLDER; ?></th>
                                            <th class="py-2 text-center"><?php echo _FPA_MODE; ?></th>
                                            <th class="py-2 text-center d-none d-lg-table-cell"><?php echo _FPA_WRITABLE; ?></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                        if ( $instance['instanceFOUND'] == _FPA_Y ) {

                                            foreach ( $elevated as $key => $show ) {


                                                if ( $show != $elevated['ARRNAME'] ) {

                                                    echo '<tr>';

                                                    /**
                                                     * modeset checks
                                                     *
                                                     * looking for --7 or -7- or -77 (default folder permissions are usually 755)
                                                     *
                                                     */
                                                    if ( substr( $show['mode'],1 ,1 ) == '7' OR substr( $show['mode'],2 ,1 ) == '7' ) {
                                                        $modeClass  = 'white bg-danger';
                                                        $alertClass = 'danger';

                                                    } else {
                                                        $modeClass  = 'default';
                                                        $alertClass = 'default';
                                                    }

                                                    /**
                                                     * effective writeable permissions
                                                     *
                                                     * is the folder writable by the executing user
                                                     *
                                                     */
                                                    if ( ( $show['writable'] == _FPA_Y ) ) {
                                                        $writeClass = 'danger';

                                                    } else {
                                                        $writeClass = 'warning';
                                                    }

                                                    echo '<td class="text-'.$alertClass.'">'. $key .'/</td>';

                                                    echo '<td class="text-'.$modeClass.' text-center">'. $show['mode'] .'</td>';

                                                    echo '<td class="text-'.$writeClass.' text-center d-none d-lg-table-cell">';

                                                        if ( substr( $show['mode'],1 ,1 ) == '7' ) {
                                                            $gIcon  = 'check';
                                                            $gColor = 'danger';
                                                        } else {
                                                            $gIcon  = 'minus';
                                                            $gColor = 'muted';
                                                        }
                                                        if ( substr( $show['mode'],2 ,1 ) == '7' ) {
                                                            $wIcon  = 'check';
                                                            $wColor = 'danger';
                                                        } else {
                                                            $wIcon  = 'minus';
                                                            $wColor = 'muted';
                                                        }

                                                        echo '<table class="table table-borderless table-sm m-0"><tbody><tr class=" bg-transparent">';
                                                        echo '<td class="p-0 xsmall bg-transparent">Group Writable<br /><i class="fas fa-'.$gIcon.'-circle text-'.$gColor.' fa-lg pt-1"></i></td>';
                                                        echo '<td class="p-0 xsmall bg-transparent">World Writable<br /><i class="fas fa-'.$wIcon.'-circle text-'.$wColor.' fa-lg pt-1"></i></td>';
                                                        echo '</tr></tbody></table>';

                                                    echo '</td>';

                                                    echo '</tr>';

                                                } // endif , dont show array name

                                            } // end foreach

                                        } else { // an instance wasn't found in the initial checks, so no elevated permissions to check
                                            echo '<tr class="table-warning text-center p-3">';
                                            echo '<td class="lead" colspan="3">'. _FPA_INSTANCE .' '. _FPA_NF .', '. _FPA_NO .' '. $elevated['ARRNAME'] .' '. _FPA_TESTP .' '. _FPA_TESTP .'</td>';
                                            echo '</tr>';
                                        }

                                    ?>
                                    </tbody>
                                </table>

                            </div><!--/.table-responsive elevated-->

                            <?php showDev( $elevated ); ?>
                            <?php unset ( $key, $show ); ?>
                        </div><!--/.container-->

                    <?php } // end elevated ?>

                </section><!--/#folder-checks-->

            <?php } // dont show if doVEL = 1 } ?>



            <?php
            /**
             * instance installed components (optional)
             *
             */
            ?>
            <div class="break-before pdf-break-before" id="extensions">

                <?php if ( $showComponents == '1' ) { ?>

                    <section class="py-3" id="components">

                        <div class="container mt-5 site-components">

                            <form class="m-0 ml-auto p-0" method="post" name="comVELForm" id="comVELForm">
                                <h2 class="border-bottom mb-4">
                                    <?php echo $component['ARRNAME'] .' :: '. _FPA_SITE; ?>
                                    <?php if ( defined( '_LIVE_CHECK_VEL') AND $canDOLIVE == '1' AND $instance['instanceFOUND'] == _FPA_Y ) { ?>
                                        <input type="hidden" name="doVEL" value="1" />
                                        <button class="btn btn-warning xsmall float-right d-none d-md-inline-block d-print-none" data-html2canvas-ignore="true" type="submit" accesskey="v" aria-label="Run a Vulnerable Extension Check">
                                            <i class="fas fa-biohazard fa-sm fa-fw lead"></i> Check VEL
                                        </button>
                                    <?php } // doVEL ?>
                                </h2>
                            </form>

                            <div class="d-md-none d-lg-none d-xl-none small text-center bg-warning text-white p-2 mb-2">Best viewed in landscape or larger viewports</div>

                            <div class="table-responsive-md">

                                <table class="table table-striped table-bordered table-sm">
                                    <thead>
                                        <tr class="bg-info text-white xsmall">
                                            <th class="py-2"><?php echo _FPA_TNAM; ?></th>
                                            <th class="py-2 text-center"><?php echo _FPA_VER; ?></th>
                                            <th class="py-2 text-center d-none d-lg-table-cell"><?php echo _FPA_CRE; ?></th>
                                            <th class="py-2 text-center d-none d-lg-table-cell"><?php echo _FPA_AUTH; ?></th>
                                            <th class="py-2 text-center d-none d-lg-table-cell"><?php echo _FPA_ADDR; ?></th>
                                            <th class="py-2 text-center"><?php echo _FPA_TYPE; ?></th>
                                            <th class="py-2 text-center"><?php echo _FPA_EN; ?></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if ( $instance['instanceFOUND'] == _FPA_Y ) { ?>

                                            <?php if ( isset ( $component['SITE'])) { ?>
                                                <?php foreach ( $component['SITE'] as $key => $show ) { ?>

                                                    <tr>

                                                        <?php
                                                            if (isset($exset[0]['name'])) {
                                                                $extarrkey = recursive_array_search($show['name'], $exset);

                                                                if ($extarrkey  !== False) {
                                                                    $extenabled = $exset[$extarrkey]['enabled'];

                                                                } else {
                                                                    $extenabled = '?' ;
                                                                }

                                                            } else {
                                                                $extenabled = '?' ;
                                                            }

                                                            if ($extenabled <> 0 AND $extenabled <> 1 ){
                                                                $extenabled = '?';
                                                            }

                                                            if ( $show['type'] == _FPA_3PD) {
                                                                $typeColor = 'info';
                                                            } else {
                                                                $typeColor = 'dark';
                                                            }

                                                            if ($extenabled != 1) {
                                                                $typeColor = 'muted';
                                                            }
                                                        ?>

                                                        <td class="text-<?php echo $typeColor; ?>"><?php echo $show['name']; ?></td>

                                                        <td class="text-<?php echo $typeColor; ?> text-center"><?php echo $show['version']; ?></td>

                                                        <td class="text-<?php echo $typeColor; ?> d-none d-lg-table-cell"><?php echo $show['creationDate']; ?></td>

                                                        <td class="text-<?php echo $typeColor; ?> text-center d-none d-lg-table-cell"><?php echo $show['author']; ?></td>

                                                        <td class="text-<?php echo $typeColor; ?> text-center d-none d-lg-table-cell"><?php echo $show['authorUrl']; ?></td>

                                                        <td class="text-<?php echo $typeColor; ?> text-center"><?php echo $show['type']; ?></td>

                                                        <td class="text-center">
                                                            <?php
                                                                if ($extenabled == 1) {
                                                                    $statusIcon  = 'check';
                                                                    $statusColor = 'success';
                                                                } elseif ($extenabled == '?') {
                                                                    $statusIcon  = 'question';
                                                                    $statusColor = 'warning';
                                                                } else {
                                                                    $statusIcon  = 'minus';
                                                                    $statusColor = 'muted';
                                                                }
                                                            ?>
                                                            <i class="fas fa-<?php echo $statusIcon; ?>-circle text-<?php echo $statusColor; ?>"></i>
                                                        </td>

                                                    </tr>

                                                <?php } // foreach ?>
                                            <?php } // isset ?>

                                        <?php } else { ?>
                                            <tr class="table-warning text-center p-3">
                                                <td colspan="7" class="lead"><?php echo _FPA_INSTANCE .' '. _FPA_NF .', '. _FPA_NO .' '. $component['ARRNAME'] .' '. _FPA_TESTP; ?></td>
                                            </tr>
                                        <?php } // instanceFOUND ?>
                                    </tbody>
                                </table>

                            </div><!--/.table-responsive-->

                        </div><!--/.container(site-components)-->


                        <div class="container mt-5 admin-components">

                            <h2 class="border-bottom mb-4"><?php echo $component['ARRNAME'] .' :: '. _FPA_ADMIN; ?></h2>

                            <div class="d-md-none d-lg-none d-xl-none small text-center bg-warning text-white p-2 mb-2">Best viewed in landscape or larger viewports</div>

                            <div class="table-responsive-md">

                                <table class="table table-striped table-bordered table-sm">
                                    <thead>
                                        <tr class="bg-info text-white xsmall">
                                            <th class="py-2"><?php echo _FPA_TNAM; ?></th>
                                            <th class="py-2 text-center"><?php echo _FPA_VER; ?></th>
                                            <th class="py-2 text-center d-none d-lg-table-cell"><?php echo _FPA_CRE; ?></th>
                                            <th class="py-2 text-center d-none d-lg-table-cell"><?php echo _FPA_AUTH; ?></th>
                                            <th class="py-2 text-center d-none d-lg-table-cell"><?php echo _FPA_ADDR; ?></th>
                                            <th class="py-2 text-center"><?php echo _FPA_TYPE; ?></th>
                                            <th class="py-2 text-center"><?php echo _FPA_EN; ?></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if ( $instance['instanceFOUND'] == _FPA_Y ) { ?>

                                            <?php if ( isset ( $component['ADMIN'])) { ?>
                                                <?php foreach ( $component['ADMIN'] as $key => $show ) { ?>

                                                    <tr>

                                                        <?php
                                                            if (isset($exset[0]['name'])) {
                                                                $extarrkey = recursive_array_search($show['name'], $exset);

                                                                if ($extarrkey  !== False) {
                                                                    $extenabled = $exset[$extarrkey]['enabled'];

                                                                } else {
                                                                    $extenabled = '?' ;
                                                                }

                                                            } else {
                                                                $extenabled = '?' ;
                                                            }

                                                            if ($extenabled <> 0 AND $extenabled <> 1 ){
                                                                $extenabled = '?';
                                                            }

                                                            if ( $show['type'] == _FPA_3PD) {
                                                                $typeColor = 'info';
                                                            } else {
                                                                $typeColor = 'dark';
                                                            }

                                                            if ($extenabled != 1) {
                                                                $typeColor = 'muted';
                                                            }
                                                        ?>

                                                        <td class="text-<?php echo $typeColor; ?>"><?php echo $show['name']; ?></td>

                                                        <td class="text-<?php echo $typeColor; ?> text-center"><?php echo $show['version']; ?></td>

                                                        <td class="text-<?php echo $typeColor; ?> d-none d-lg-table-cell"><?php echo $show['creationDate']; ?></td>

                                                        <td class="text-<?php echo $typeColor; ?> text-center d-none d-lg-table-cell"><?php echo $show['author']; ?></td>

                                                        <td class="text-<?php echo $typeColor; ?> text-center d-none d-lg-table-cell"><?php echo $show['authorUrl']; ?></td>

                                                        <td class="text-<?php echo $typeColor; ?> text-center"><?php echo $show['type']; ?></td>

                                                        <td class="text-center">
                                                            <?php
                                                                if ($extenabled == 1) {
                                                                    $statusIcon  = 'check';
                                                                    $statusColor = 'success';
                                                                } elseif ($extenabled == '?') {
                                                                    $statusIcon  = 'question';
                                                                    $statusColor = 'warning';
                                                                } else {
                                                                    $statusIcon  = 'minus';
                                                                    $statusColor = 'muted';
                                                                }
                                                            ?>
                                                            <i class="fas fa-<?php echo $statusIcon; ?>-circle text-<?php echo $statusColor; ?>"></i>
                                                        </td>

                                                    </tr>

                                                <?php } // foreach ?>
                                            <?php } // isset ?>

                                        <?php } else { ?>
                                            <tr class="table-warning text-center p-3">
                                                <td colspan="7" class="lead"><?php echo _FPA_INSTANCE .' '. _FPA_NF .', '. _FPA_NO .' '. $component['ARRNAME'] .' '. _FPA_TESTP; ?></td>
                                            </tr>
                                        <?php } // instanceFOUND ?>
                                    </tbody>
                                </table>

                            </div><!--/.table-responsive-->

                            <?php showDev( $component ); ?>
                            <?php unset ( $key, $show ); ?>
                        </div><!--/.container(admin-components)-->

                    </section><!--/#components-->

                <?php } // ShowComponents ?>


                <?php if ( $showModules == '1' ) { ?>

                    <section class="py-3 break-before" id="modules">

                        <div class="container mt-5 site-modules">

                            <form class="m-0 ml-auto p-0" method="post" name="modVELForm" id="modVELForm">
                                <h2 class="border-bottom mb-4">
                                    <?php echo $module['ARRNAME'] .' :: '. _FPA_SITE; ?>
                                    <?php if ( defined( '_LIVE_CHECK_VEL') AND $canDOLIVE == '1' AND $instance['instanceFOUND'] == _FPA_Y ) { ?>
                                        <input type="hidden" name="doVEL" value="1" />
                                        <button class="btn btn-warning xsmall float-right d-none d-md-inline-block d-print-none" data-html2canvas-ignore="true" type="submit" accesskey="v" aria-label="Run a Vulnerable Extension Check">
                                            <i class="fas fa-biohazard fa-sm fa-fw lead"></i> Check VEL
                                        </button>
                                    <?php } // doVEL ?>
                                </h2>
                            </form>

                            <div class="d-md-none d-lg-none d-xl-none small text-center bg-warning text-white p-2 mb-2">Best viewed in landscape or larger viewports</div>

                            <div class="table-responsive-md">

                                <table class="table table-striped table-bordered table-sm">
                                    <thead>
                                        <tr class="bg-info text-white xsmall">
                                            <th class="py-2"><?php echo _FPA_TNAM; ?></th>
                                            <th class="py-2 text-center"><?php echo _FPA_VER; ?></th>
                                            <th class="py-2 text-center d-none d-lg-table-cell"><?php echo _FPA_CRE; ?></th>
                                            <th class="py-2 text-center d-none d-lg-table-cell"><?php echo _FPA_AUTH; ?></th>
                                            <th class="py-2 text-center d-none d-lg-table-cell"><?php echo _FPA_ADDR; ?></th>
                                            <th class="py-2 text-center"><?php echo _FPA_TYPE; ?></th>
                                            <th class="py-2 text-center"><?php echo _FPA_EN; ?></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if ( $instance['instanceFOUND'] == _FPA_Y ) { ?>

                                            <?php if ( isset ( $module['SITE'])) { ?>
                                                <?php foreach ( $module['SITE'] as $key => $show ) { ?>

                                                    <tr>

                                                        <?php
                                                            if (isset($exset[0]['name'])) {
                                                                $extarrkey = recursive_array_search($show['name'], $exset);

                                                                if ($extarrkey  !== False) {
                                                                    $extenabled = $exset[$extarrkey]['enabled'];

                                                                } else {
                                                                    $extenabled = '?' ;
                                                                }

                                                            } else {
                                                                $extenabled = '?' ;
                                                            }

                                                            if ($extenabled <> 0 AND $extenabled <> 1 ){
                                                                $extenabled = '?';
                                                            }

                                                            if ( $show['type'] == _FPA_3PD) {
                                                                $typeColor = 'info';
                                                            } else {
                                                                $typeColor = 'dark';
                                                            }

                                                            if ($extenabled != 1) {
                                                                $typeColor = 'muted';
                                                            }
                                                        ?>

                                                        <td class="text-<?php echo $typeColor; ?>"><?php echo $show['name']; ?></td>

                                                        <td class="text-<?php echo $typeColor; ?> text-center"><?php echo $show['version']; ?></td>

                                                        <td class="text-<?php echo $typeColor; ?> d-none d-lg-table-cell"><?php echo $show['creationDate']; ?></td>

                                                        <td class="text-<?php echo $typeColor; ?> text-center d-none d-lg-table-cell"><?php echo $show['author']; ?></td>

                                                        <td class="text-<?php echo $typeColor; ?> text-center d-none d-lg-table-cell"><?php echo $show['authorUrl']; ?></td>

                                                        <td class="text-<?php echo $typeColor; ?> text-center"><?php echo $show['type']; ?></td>

                                                        <td class="text-center">
                                                            <?php
                                                                if ($extenabled == 1) {
                                                                    $statusIcon  = 'check';
                                                                    $statusColor = 'success';
                                                                } elseif ($extenabled == '?') {
                                                                    $statusIcon  = 'question';
                                                                    $statusColor = 'warning';
                                                                } else {
                                                                    $statusIcon  = 'minus';
                                                                    $statusColor = 'muted';
                                                                }
                                                            ?>
                                                            <i class="fas fa-<?php echo $statusIcon; ?>-circle text-<?php echo $statusColor; ?>"></i>
                                                        </td>

                                                    </tr>

                                                <?php } // foreach ?>
                                            <?php } // isset ?>

                                        <?php } else { ?>
                                            <tr class="table-warning text-center p-3">
                                                <td colspan="7" class="lead"><?php echo _FPA_INSTANCE .' '. _FPA_NF .', '. _FPA_NO .' '. $module['ARRNAME'] .' '. _FPA_TESTP; ?></td>
                                            </tr>
                                        <?php } // instanceFOUND ?>
                                    </tbody>
                                </table>

                            </div><!--/.table-responsive-->

                        </div><!--/.container(site-modules)-->


                        <div class="container mt-5 admin-modules">

                            <h2 class="border-bottom mb-4"><?php echo $module['ARRNAME'] .' :: '. _FPA_ADMIN; ?></h2>

                            <div class="d-md-none d-lg-none d-xl-none small text-center bg-warning text-white p-2 mb-2">Best viewed in landscape or larger viewports</div>

                            <div class="table-responsive-md">

                                <table class="table table-striped table-bordered table-sm">
                                    <thead>
                                        <tr class="bg-info text-white xsmall">
                                            <th class="py-2"><?php echo _FPA_TNAM; ?></th>
                                            <th class="py-2 text-center"><?php echo _FPA_VER; ?></th>
                                            <th class="py-2 text-center d-none d-lg-table-cell"><?php echo _FPA_CRE; ?></th>
                                            <th class="py-2 text-center d-none d-lg-table-cell"><?php echo _FPA_AUTH; ?></th>
                                            <th class="py-2 text-center d-none d-lg-table-cell"><?php echo _FPA_ADDR; ?></th>
                                            <th class="py-2 text-center"><?php echo _FPA_TYPE; ?></th>
                                            <th class="py-2 text-center"><?php echo _FPA_EN; ?></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if ( $instance['instanceFOUND'] == _FPA_Y ) { ?>

                                            <?php if ( isset ( $module['ADMIN'])) { ?>
                                                <?php foreach ( $module['ADMIN'] as $key => $show ) { ?>

                                                    <tr>

                                                        <?php
                                                            if (isset($exset[0]['name'])) {
                                                                $extarrkey = recursive_array_search($show['name'], $exset);

                                                                if ($extarrkey  !== False) {
                                                                    $extenabled = $exset[$extarrkey]['enabled'];

                                                                } else {
                                                                    $extenabled = '?' ;
                                                                }

                                                            } else {
                                                                $extenabled = '?' ;
                                                            }

                                                            if ($extenabled <> 0 AND $extenabled <> 1 ){
                                                                $extenabled = '?';
                                                            }

                                                            if ( $show['type'] == _FPA_3PD) {
                                                                $typeColor = 'info';
                                                            } else {
                                                                $typeColor = 'dark';
                                                            }

                                                            if ($extenabled != 1) {
                                                                $typeColor = 'muted';
                                                            }
                                                        ?>

                                                        <td class="text-<?php echo $typeColor; ?>"><?php echo $show['name']; ?></td>

                                                        <td class="text-<?php echo $typeColor; ?> text-center"><?php echo $show['version']; ?></td>

                                                        <td class="text-<?php echo $typeColor; ?> d-none d-lg-table-cell"><?php echo $show['creationDate']; ?></td>

                                                        <td class="text-<?php echo $typeColor; ?> text-center d-none d-lg-table-cell"><?php echo $show['author']; ?></td>

                                                        <td class="text-<?php echo $typeColor; ?> text-center d-none d-lg-table-cell"><?php echo $show['authorUrl']; ?></td>

                                                        <td class="text-<?php echo $typeColor; ?> text-center"><?php echo $show['type']; ?></td>

                                                        <td class="text-center">
                                                            <?php
                                                                if ($extenabled == 1) {
                                                                    $statusIcon  = 'check';
                                                                    $statusColor = 'success';
                                                                } elseif ($extenabled == '?') {
                                                                    $statusIcon  = 'question';
                                                                    $statusColor = 'warning';
                                                                } else {
                                                                    $statusIcon  = 'minus';
                                                                    $statusColor = 'muted';
                                                                }
                                                            ?>
                                                            <i class="fas fa-<?php echo $statusIcon; ?>-circle text-<?php echo $statusColor; ?>"></i>
                                                        </td>

                                                    </tr>

                                                <?php } // foreach ?>
                                            <?php } // isset ?>

                                        <?php } else { ?>
                                            <tr class="table-warning text-center p-3">
                                                <td colspan="7" class="lead"><?php echo _FPA_INSTANCE .' '. _FPA_NF .', '. _FPA_NO .' '. $module['ARRNAME'] .' '. _FPA_TESTP; ?></td>
                                            </tr>
                                        <?php } // instanceFOUND ?>
                                    </tbody>
                                </table>

                            </div><!--/.table-responsive-->

                            <?php showDev( $module ); ?>
                            <?php unset ( $key, $show ); ?>
                        </div><!--/.container(admin-modules)-->

                    </section><!--/#modules-->

                <?php } // ShowModules ?>


                <?php if ( $showLibraries == '1' ) { ?>

                    <section class="py-3 break-before" id="library">

                        <div class="container mt-5 libraries">

                            <form class="m-0 ml-auto p-0" method="post" name="libVELForm" id="libVELForm">
                                <h2 class="border-bottom mb-4">
                                    <?php echo $library['ARRNAME'] .' :: '; ?>
                                    <?php if ( defined( '_LIVE_CHECK_VEL') AND $canDOLIVE == '1' AND $instance['instanceFOUND'] == _FPA_Y ) { ?>
                                        <input type="hidden" name="doVEL" value="1" />
                                        <button class="btn btn-warning xsmall float-right d-none d-md-inline-block d-print-none" data-html2canvas-ignore="true" type="submit" accesskey="v" aria-label="Run a Vulnerable Extension Check">
                                            <i class="fas fa-biohazard fa-sm fa-fw lead"></i> Check VEL
                                        </button>
                                    <?php } // doVEL ?>
                                </h2>
                            </form>

                            <div class="d-md-none d-lg-none d-xl-none small text-center bg-warning text-white p-2 mb-2">Best viewed in landscape or larger viewports</div>

                            <div class="table-responsive-md">

                                <table class="table table-striped table-bordered table-sm">
                                    <thead>
                                        <tr class="bg-info text-white xsmall">
                                            <th class="py-2"><?php echo _FPA_TNAM; ?></th>
                                            <th class="py-2 text-center"><?php echo _FPA_VER; ?></th>
                                            <th class="py-2 text-center d-none d-lg-table-cell"><?php echo _FPA_CRE; ?></th>
                                            <th class="py-2 text-center d-none d-lg-table-cell"><?php echo _FPA_AUTH; ?></th>
                                            <th class="py-2 text-center d-none d-lg-table-cell"><?php echo _FPA_ADDR; ?></th>
                                            <th class="py-2 text-center"><?php echo _FPA_TYPE; ?></th>
                                            <th class="py-2 text-center"><?php echo _FPA_EN; ?></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if ( $instance['instanceFOUND'] == _FPA_Y ) { ?>

                                            <?php if ( isset ( $library['SITE'])) { ?>
                                                <?php foreach ( $library['SITE'] as $key => $show ) { ?>

                                                    <tr>

                                                        <?php
                                                            if (isset($exset[0]['name'])) {
                                                                $extarrkey = recursive_array_search($show['name'], $exset);

                                                                if ($extarrkey  !== False) {
                                                                    $extenabled = $exset[$extarrkey]['enabled'];

                                                                } else {
                                                                    $extenabled = '?' ;
                                                                }

                                                            } else {
                                                                $extenabled = '?' ;
                                                            }

                                                            if ($extenabled <> 0 AND $extenabled <> 1 ){
                                                                $extenabled = '?';
                                                            }

                                                            if ( $show['type'] == _FPA_3PD) {
                                                                $typeColor = 'info';
                                                            } else {
                                                                $typeColor = 'dark';
                                                            }

                                                            if ($extenabled != 1) {
                                                                $typeColor = 'muted';
                                                            }
                                                        ?>

                                                        <td class="text-<?php echo $typeColor; ?>"><?php echo $show['name']; ?></td>

                                                        <td class="text-<?php echo $typeColor; ?> text-center"><?php echo $show['version']; ?></td>

                                                        <td class="text-<?php echo $typeColor; ?> d-none d-lg-table-cell"><?php echo $show['creationDate']; ?></td>

                                                        <td class="text-<?php echo $typeColor; ?> text-center d-none d-lg-table-cell"><?php echo $show['author']; ?></td>

                                                        <td class="text-<?php echo $typeColor; ?> text-center d-none d-lg-table-cell"><?php echo $show['authorUrl']; ?></td>

                                                        <td class="text-<?php echo $typeColor; ?> text-center"><?php echo $show['type']; ?></td>

                                                        <td class="text-center">
                                                            <?php
                                                                if ($extenabled == 1) {
                                                                    $statusIcon  = 'check';
                                                                    $statusColor = 'success';
                                                                } elseif ($extenabled == '?') {
                                                                    $statusIcon  = 'question';
                                                                    $statusColor = 'warning';
                                                                } else {
                                                                    $statusIcon  = 'minus';
                                                                    $statusColor = 'muted';
                                                                }
                                                            ?>
                                                            <i class="fas fa-<?php echo $statusIcon; ?>-circle text-<?php echo $statusColor; ?>"></i>
                                                        </td>

                                                    </tr>

                                                <?php } // foreach ?>
                                            <?php } // isset ?>

                                        <?php } else { ?>
                                            <tr class="table-warning text-center p-3">
                                                <td colspan="7" class="lead"><?php echo _FPA_INSTANCE .' '. _FPA_NF .', '. _FPA_NO .' '. $library['ARRNAME'] .' '. _FPA_TESTP; ?></td>
                                            </tr>
                                        <?php } // instanceFOUND ?>
                                    </tbody>
                                </table>

                            </div><!--/.table-responsive-->

                            <?php showDev( $library ); ?>
                            <?php unset ( $key, $show ); ?>
                        </div><!--/.container(libraries)-->

                    </section><!--/#library-->

                <?php } // ShowLibraries ?>


                <?php if ( $showPlugins == '1' ) { ?>

                    <section class="py-3" id="plugins">

                        <div class="container mt-5 plugins">

                            <form class="m-0 ml-auto p-0" method="post" name="plgVELForm" id="plgVELForm">
                                <h2 class="border-bottom mb-4">
                                    <?php echo $plugin['ARRNAME'] .' :: '; ?>
                                    <?php if ( defined( '_LIVE_CHECK_VEL') AND $canDOLIVE == '1' AND $instance['instanceFOUND'] == _FPA_Y ) { ?>
                                        <input type="hidden" name="doVEL" value="1" />
                                        <button class="btn btn-warning xsmall float-right d-none d-md-inline-block d-print-none" data-html2canvas-ignore="true" type="submit" accesskey="v" aria-label="Run a Vulnerable Extension Check">
                                            <i class="fas fa-biohazard fa-sm fa-fw lead"></i> Check VEL
                                        </button>
                                    <?php } // doVEL ?>
                                </h2>
                            </form>

                            <div class="d-md-none d-lg-none d-xl-none small text-center bg-warning text-white p-2 mb-2">Best viewed in landscape or larger viewports</div>

                            <div class="table-responsive-md">

                                <table class="table table-striped table-bordered table-sm">
                                    <thead>
                                        <tr class="bg-info text-white xsmall">
                                            <th class="py-2"><?php echo _FPA_TNAM; ?></th>
                                            <th class="py-2 text-center"><?php echo _FPA_VER; ?></th>
                                            <th class="py-2 text-center d-none d-lg-table-cell"><?php echo _FPA_CRE; ?></th>
                                            <th class="py-2 text-center d-none d-lg-table-cell"><?php echo _FPA_AUTH; ?></th>
                                            <th class="py-2 text-center d-none d-lg-table-cell"><?php echo _FPA_ADDR; ?></th>
                                            <th class="py-2 text-center"><?php echo _FPA_TYPE; ?></th>
                                            <th class="py-2 text-center"><?php echo _FPA_EN; ?></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if ( $instance['instanceFOUND'] == _FPA_Y ) { ?>

                                            <?php if ( isset ( $plugin['SITE'])) { ?>
                                                <?php foreach ( $plugin['SITE'] as $key => $show ) { ?>

                                                    <tr>

                                                        <?php
                                                            if (isset($exset[0]['name'])) {
                                                                $extarrkey = recursive_array_search($show['name'], $exset);

                                                                if ($extarrkey  !== False) {
                                                                    $extenabled = $exset[$extarrkey]['enabled'];

                                                                } else {
                                                                    $extenabled = '?' ;
                                                                }

                                                            } else {
                                                                $extenabled = '?' ;
                                                            }

                                                            if ($extenabled <> 0 AND $extenabled <> 1 ){
                                                                $extenabled = '?';
                                                            }

                                                            if ( $show['type'] == _FPA_3PD) {
                                                                $typeColor = 'info';
                                                            } else {
                                                                $typeColor = 'dark';
                                                            }

                                                            if ($extenabled != 1) {
                                                                $typeColor = 'muted';
                                                            }
                                                        ?>

                                                        <td class="text-<?php echo $typeColor; ?>"><?php echo $show['name']; ?></td>

                                                        <td class="text-<?php echo $typeColor; ?> text-center"><?php echo $show['version']; ?></td>

                                                        <td class="text-<?php echo $typeColor; ?> d-none d-lg-table-cell"><?php echo $show['creationDate']; ?></td>

                                                        <td class="text-<?php echo $typeColor; ?> text-center d-none d-lg-table-cell"><?php echo $show['author']; ?></td>

                                                        <td class="text-<?php echo $typeColor; ?> text-center d-none d-lg-table-cell"><?php echo $show['authorUrl']; ?></td>

                                                        <td class="text-<?php echo $typeColor; ?> text-center"><?php echo $show['type']; ?></td>

                                                        <td class="text-center">
                                                            <?php
                                                                if ($extenabled == 1) {
                                                                    $statusIcon  = 'check';
                                                                    $statusColor = 'success';
                                                                } elseif ($extenabled == '?') {
                                                                    $statusIcon  = 'question';
                                                                    $statusColor = 'warning';
                                                                } else {
                                                                    $statusIcon  = 'minus';
                                                                    $statusColor = 'muted';
                                                                }
                                                            ?>
                                                            <i class="fas fa-<?php echo $statusIcon; ?>-circle text-<?php echo $statusColor; ?>"></i>
                                                        </td>

                                                    </tr>

                                                <?php } // foreach ?>
                                            <?php } // isset ?>

                                        <?php } else { ?>
                                            <tr class="table-warning text-center p-3">
                                                <td colspan="7" class="lead"><?php echo _FPA_INSTANCE .' '. _FPA_NF .', '. _FPA_NO .' '. $plugin['ARRNAME'] .' '. _FPA_TESTP; ?></td>
                                            </tr>
                                        <?php } // instanceFOUND ?>
                                    </tbody>
                                </table>

                            </div><!--/.table-responsive-->

                            <?php showDev( $library ); ?>
                            <?php unset ( $key, $show ); ?>
                        </div><!--/.container(plugins)-->

                    </section><!--/#plugins-->

                <?php } // ShowPlugins ?>

            </div><!--#extensions-->



            <?php
            /**
             * instance installed templates
             *
             */
            ?>
            <section class="py-3" id="templates">

                <div class="container mt-5 site-templates">

                    <form class="m-0 ml-auto p-0" method="post" name="tplVELForm" id="tplVELForm">
                        <h2 class="border-bottom mb-4">
                            <?php echo $template['ARRNAME'] .' :: '. _FPA_SITE; ?>
                            <?php if ( defined( '_LIVE_CHECK_VEL') AND $canDOLIVE == '1' AND $instance['instanceFOUND'] == _FPA_Y ) { ?>
                                <input type="hidden" name="doVEL" value="1" />
                                <button class="btn btn-warning xsmall float-right d-none d-md-inline-block d-print-none" data-html2canvas-ignore="true" type="submit" accesskey="v" aria-label="Run a Vulnerable Extension Check">
                                    <i class="fas fa-biohazard fa-sm fa-fw lead"></i> Check VEL
                                </button>
                            <?php } // doVEL ?>
                        </h2>
                    </form>

                    <div class="d-md-none d-lg-none d-xl-none small text-center bg-warning text-white p-2 mb-2">Best viewed in landscape or larger viewports</div>

                    <div class="table-responsive-md">

                        <table class="table table-striped table-bordered table-sm">
                            <thead>
                                <tr class="bg-info text-white xsmall">
                                    <th class="py-2"><?php echo _FPA_TNAM; ?></th>
                                    <th class="py-2 text-center"><?php echo _FPA_VER; ?></th>
                                    <th class="py-2 text-center d-none d-lg-table-cell"><?php echo _FPA_CRE; ?></th>
                                    <th class="py-2 text-center d-none d-lg-table-cell"><?php echo _FPA_AUTH; ?></th>
                                    <th class="py-2 text-center d-none d-lg-table-cell"><?php echo _FPA_ADDR; ?></th>
                                    <th class="py-2 text-center"><?php echo _FPA_TYPE; ?></th>
                                    <th class="py-2 text-center"><?php echo _FPA_EN; ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if ( $instance['instanceFOUND'] == _FPA_Y ) { ?>

                                    <?php if ( isset ( $template['SITE'])) { ?>
                                        <?php foreach ( $template['SITE'] as $key => $show ) { ?>

                                            <tr>

                                                <?php
                                                    if (isset($exset[0]['name'])) {
                                                        $extarrkey = recursive_array_search($show['name'], $exset);

                                                        if ($extarrkey  !== False) {
                                                            $extenabled = $exset[$extarrkey]['enabled'];

                                                        } else {
                                                            $extenabled = '?' ;
                                                        }

                                                    } else {
                                                        $extenabled = '?' ;
                                                    }

                                                    if ($extenabled <> 0 AND $extenabled <> 1 ){
                                                        $extenabled = '?';
                                                    }

                                                    // test for whether this is the default template
                                                    if (isset($tmpldef[0]['template'])) {
                                                        $extarrkey = recursive_array_search($show['name'], $tmpldef);

                                                        if ($extarrkey  !== False) {
                                                            $deftempl = $tmpldef[$extarrkey]['home'];

                                                        } else {
                                                            $deftempl = '';
                                                        }

                                                    } else {
                                                        $deftempl = '';
                                                    }

                                                    if ($deftempl == 1 ) {
                                                        $isDEFTPL = 'bolder';
                                                        $isDEFTPLMSG = '<sup><i class="fas fa-check fa-fw text-success" data-toggle="tooltip" data-placement="top" title="Default Template"></i></sup>';

                                                    } else {
                                                        $isDEFTPL = 'normal';
                                                        $isDEFTPLMSG = '';
                                                    }


                                                    if ( $show['type'] == _FPA_3PD) {
                                                        $typeColor = 'info';
                                                    } else {
                                                        $typeColor = 'dark';
                                                    }

                                                    if ($extenabled != 1) {
                                                        $typeColor = 'muted';
                                                    }

                                                ?>

                                                <td class="text-<?php echo $typeColor; ?>">
                                                    <span class="font-weight-<?php echo $isDEFTPL; ?>"><?php echo $show['name']; ?></span>
                                                    <?php echo @$isDEFTPLMSG; ?>
                                                </td>

                                                <td class="text-<?php echo $typeColor; ?> text-center"><?php echo $show['version']; ?></td>

                                                <td class="text-<?php echo $typeColor; ?> d-none d-lg-table-cell"><?php echo $show['creationDate']; ?></td>

                                                <td class="text-<?php echo $typeColor; ?> text-center d-none d-lg-table-cell"><?php echo $show['author']; ?></td>

                                                <td class="text-<?php echo $typeColor; ?> text-center d-none d-lg-table-cell"><?php echo $show['authorUrl']; ?></td>

                                                <td class="text-<?php echo $typeColor; ?> text-center"><?php echo $show['type']; ?></td>

                                                <td class="text-center">
                                                    <?php
                                                        if ($extenabled == 1) {
                                                            $statusIcon  = 'check';
                                                            $statusColor = 'success';
                                                        } elseif ($extenabled == '?') {
                                                            $statusIcon  = 'question';
                                                            $statusColor = 'warning';
                                                        } else {
                                                            $statusIcon  = 'minus';
                                                            $statusColor = 'muted';
                                                        }
                                                    ?>
                                                    <i class="fas fa-<?php echo $statusIcon; ?>-circle text-<?php echo $statusColor; ?>"></i>
                                                </td>

                                            </tr>

                                        <?php } // foreach ?>
                                    <?php } // isset ?>


                                <?php } else { ?>
                                    <tr class="table-warning text-center p-3">
                                        <td colspan="7" class="lead"><?php echo _FPA_INSTANCE .' '. _FPA_NF .', '. _FPA_NO .' '. $module['ARRNAME'] .' '. _FPA_TESTP; ?></td>
                                    </tr>
                                <?php } // instanceFOUND ?>
                            </tbody>
                        </table>

                    </div><!--/.table-responsive-->

                </div><!--/.container(site-tempates)-->


                <div class="container mt-5 admin-templates">

                    <h2 class="border-bottom mb-4"><?php echo $template['ARRNAME'] .' :: '. _FPA_ADMIN; ?></h2>

                    <div class="d-md-none d-lg-none d-xl-none small text-center bg-warning text-white p-2 mb-2">Best viewed in landscape or larger viewports</div>

                    <div class="table-responsive-md">

                        <table class="table table-striped table-bordered table-sm">
                            <thead>
                                <tr class="bg-info text-white xsmall">
                                    <th class="py-2"><?php echo _FPA_TNAM; ?></th>
                                    <th class="py-2 text-center"><?php echo _FPA_VER; ?></th>
                                    <th class="py-2 text-center d-none d-lg-table-cell"><?php echo _FPA_CRE; ?></th>
                                    <th class="py-2 text-center d-none d-lg-table-cell"><?php echo _FPA_AUTH; ?></th>
                                    <th class="py-2 text-center d-none d-lg-table-cell"><?php echo _FPA_ADDR; ?></th>
                                    <th class="py-2 text-center"><?php echo _FPA_TYPE; ?></th>
                                    <th class="py-2 text-center"><?php echo _FPA_EN; ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if ( $instance['instanceFOUND'] == _FPA_Y ) { ?>

                                    <?php if ( isset ( $template['ADMIN'])) { ?>
                                        <?php foreach ( $template['ADMIN'] as $key => $show ) { ?>

                                            <tr>

                                                <?php
                                                    if (isset($exset[0]['name'])) {
                                                        $extarrkey = recursive_array_search($show['name'], $exset);

                                                        if ($extarrkey  !== False) {
                                                            $extenabled = $exset[$extarrkey]['enabled'];

                                                        } else {
                                                            $extenabled = '?' ;
                                                        }

                                                    } else {
                                                        $extenabled = '?' ;
                                                    }

                                                    if ($extenabled <> 0 AND $extenabled <> 1 ){
                                                        $extenabled = '?';
                                                    }

                                                    // test for whether this is the default template
                                                    if (isset($tmpldef[0]['template'])) {
                                                        $extarrkey = recursive_array_search($show['name'], $tmpldef);

                                                        if ($extarrkey  !== False) {
                                                            $deftempl = $tmpldef[$extarrkey]['home'];

                                                        } else {
                                                            $deftempl = '';
                                                        }

                                                    } else {
                                                        $deftempl = '';
                                                    }

                                                    if ($deftempl == 1 ) {
                                                        $isDEFTPL = 'bolder';
                                                        $isDEFTPLMSG = '<sup><i class="fas fa-check fa-fw text-success" data-toggle="tooltip" data-placement="top" title="Default Template"></i></sup>';

                                                    } else {
                                                        $isDEFTPL = 'normal';
                                                        $isDEFTPLMSG = '';
                                                    }

                                                    if ( $show['type'] == _FPA_3PD) {
                                                        $typeColor = 'info';
                                                    } else {
                                                        $typeColor = 'dark';
                                                    }

                                                    if ($extenabled != 1) {
                                                        $typeColor = 'muted';
                                                    }
                                                ?>

                                                <td class="text-<?php echo $typeColor; ?>">
                                                    <span class="font-weight-<?php echo $isDEFTPL; ?>"><?php echo $show['name']; ?></span>
                                                    <?php echo $isDEFTPLMSG; ?>
                                                </td>

                                                <td class="text-<?php echo $typeColor; ?> text-center"><?php echo $show['version']; ?></td>

                                                <td class="text-<?php echo $typeColor; ?> d-none d-lg-table-cell"><?php echo $show['creationDate']; ?></td>

                                                <td class="text-<?php echo $typeColor; ?> text-center d-none d-lg-table-cell"><?php echo $show['author']; ?></td>

                                                <td class="text-<?php echo $typeColor; ?> text-center d-none d-lg-table-cell"><?php echo $show['authorUrl']; ?></td>

                                                <td class="text-<?php echo $typeColor; ?> text-center"><?php echo $show['type']; ?></td>

                                                <td class="text-center">
                                                    <?php
                                                        if ($extenabled == 1) {
                                                            $statusIcon  = 'check';
                                                            $statusColor = 'success';
                                                        } elseif ($extenabled == '?') {
                                                            $statusIcon  = 'question';
                                                            $statusColor = 'warning';
                                                        } else {
                                                            $statusIcon  = 'minus';
                                                            $statusColor = 'muted';
                                                        }
                                                    ?>
                                                    <i class="fas fa-<?php echo $statusIcon; ?>-circle text-<?php echo $statusColor; ?>"></i>
                                                </td>

                                            </tr>

                                        <?php } // foreach ?>
                                    <?php } // isset ?>

                                <?php } else { ?>
                                    <tr class="table-warning text-center p-3">
                                        <td colspan="7" class="lead"><?php echo _FPA_INSTANCE .' '. _FPA_NF .', '. _FPA_NO .' '. $template['ARRNAME'] .' '. _FPA_TESTP; ?></td>
                                    </tr>
                                <?php } // instanceFOUND ?>
                            </tbody>
                        </table>

                    </div><!--/.table-responsive-->

                    <?php showDev( $template ); ?>
                    <?php unset ( $key, $show ); ?>
                </div><!--/.container(admin-templates)-->

            </section><!--/#templates-->

        </main>



        <footer class="mt-5" id="fpa-footer">
            <div class="container text-center p-3 xsmall">
            <p class="mb-2 d-print-none" data-html2canvas-ignore="true">
                    <?php echo _LICENSE_FOOTER .' '. _LICENSE_LINK; ?>
                </p>
                <p class="mb-1">
                    <?php echo _FPA_JDISCLAIMER; ?>
                </p>
            </div>
            <div class="container-fluid bg-fpa-dark text-white py-2">
                <p class="p-0 m-0 xsmall text-center">
                    FPA <?php echo _RES_VERSION .' '. _RES_CODENAME .' '. _RES_COPYRIGHT_STMT; ?><br />
                    <small class="text-center">
                        <?php echo '[ Release : '. _RES_RELEASE .' ] [ Language : '. _RES_LANG .' ] [ Updated : '. _RES_LAST_UPDATED .' ]'; ?>
                    </small>
                </p>
            </div>
        </footer>



        <?php
        /**
         * security notification
         *
         * dismissable toast/alert to replace the space-hog on page message
         * 5s display if doIT = 1, else 10s display
         * @RussW 21/05/2020
         *
         */
        ?>
        <script>
            var doIT = '<?php echo @$_POST['doIT']; ?>';
            if ( doIT == '1' ) {
                var timeleft  = 5;
            } else {
                var timeleft  = 19;
            }
            var noticeTimer = setInterval(function() {
                if (timeleft <= 0) {
                    clearInterval(noticeTimer);
                    document.getElementById("countdown").innerHTML = "0s";
                } else {
                    document.getElementById("countdown").innerHTML = timeleft + "s";
                }
                timeleft -= 1;
            }, 1000);
        </script>

        <div role="alert" aria-live="assertive" aria-atomic="true" class="toast position-fixed shadow d-print-none" data-html2canvas-ignore="true" style="top: 60px; right: 20px; z-index: 9999; width: 90%; max-width: 390px;" data-delay="<?php if (@$_POST['doIT'] == '1') { echo 6000; } else { echo 20000; } ?>" data-animation="false" id="securityToast">
            <div class="toast-header bg-danger text-white">
                <i class="fas fa-exclamation-circle fa-lg mr-2"></i>
                <span class="mr-auto">Security Notification</span>
                <span class="text-white" id="countdown"></span>
                <button type="button" class="ml-2 mb-1 text-white close" data-dismiss="toast" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="toast-body text-dark text-left">
                <?php echo _FPA_DELNOTE_LN2; ?>
                <?php echo _FPA_DELNOTE_LN3; ?>
            </div>
        </div>


        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.slim.min.js" integrity="sha256-pasqAKBDmFT4eHoN2ndd6lN370kFiGUFyTiUHWhU7k8=" crossorigin="anonymous"></script>
        <!--<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>-->
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>

        <?php if (@$_POST['doPDF'] == '1') { ?>
            <?php
            /**
             * load the export to PDF libaries and options
             *
             * added @RussW 03/06/2020
             * html2pdf bundle
             * - includes html2canvas
             * - includes jsPDF
             * also loads the pace progress bar in the head when invoked as the generation can take a little
             * time and end-users could get confused  or lost whilst the PDF is being generated
             *
             * exports to "landscape by default, as there is way too much information to show in portrait
             *
             */
            ?>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.2/html2pdf.bundle.min.js" integrity="sha256-1UYP03Qm8NpJtVQjd6OTwT9DjfgsYrNa8w1szRxBeqQ=" crossOrigin="anonymous"></script>
            <script>

                var filename = '<?php echo $_SERVER['SERVER_NAME'].'-'; ?>';
                var element = document.getElementById('fpa-body');
                var opt = {
                    margin:       10,
                    pagebreak: { mode: 'css', after: '.pdf-break-after', before: '.pdf-break-before' },
                    enableLinks: false,
                    filename:     filename+Date.now()+'.pdf',
                    image:        { type: 'jpeg', quality: 0.95 },
                    html2canvas:  { scale: 2 },
                    jsPDF:        { unit: 'mm', format: 'a4', orientation: 'l', compress: 'true', userUnit: 'px' }
                };

                // promise-based execution
                html2pdf().set(opt).from(element).save();

            </script>
        <?php } // doPDF = 1 ?>

        <script>

            /**
             * activate BS popovers, tooltips (on hover) and toasts
             * requires : jQuery & popper
             * @RussW 23/05/2020
             *
             */
            $(function () {
                $('[data-toggle="popover"]').popover();
                $('[data-toggle="tooltip"]').tooltip();
                $('.toast').toast('show');

                var offset = 64;
                $('.dropdown-menu a.dropdown-item').click(function(event) {
                    event.preventDefault();
                    $($(this).attr('href'))[0].scrollIntoView();
                    scrollBy(0, -offset);
                });
            });


            /**
             * post output functions
             * 1. hide the FPA options panel/form
             * 2. count post output characters, if over 20k post a message to split forum posts
             * 3. add an event listener to copy post output to clipboard when button clicked
             *
             * only executes child functions if doIT = 1
             * @RussW 23/05/2020
             *
             */
            function doPostActions() {
                var doIT = '<?php echo @$_POST['doIT']; ?>';

                if ( doIT == '1' ) {

                    // hide the options panel/form and change button text (overrides toggleFPA)
                    var eleOptions  = document.getElementById('fpaOptions');
                    var textButton  = document.getElementById('fpaButton');
                    eleOptions.style.display = 'none';
                    textButton.innerHTML     = '<i class="fas fa-chevron-circle-right"></i> Open the FPA Options';


                    // count and display post characters
                    var maxCharCount = '19850';
                    var eleCount     = document.getElementById('postOUTPUT');
                    var countMessage = '<?php echo _FPA_INS_8; ?>';
                    if ( eleCount.value.length > maxCharCount ) {
                        document.getElementById('postCharCount').innerHTML = '<div class="alert alert-warning text-white 1bg-white small my-1 p-3"><i class="fas fa-exclamation-triangle fa-2x d-block mb-2 text-center"></i>' + countMessage + '</div><div class="text-right mb-2"><span class="xsmall text-muted">Post Length:</span> <span class="badge badge-pill badge-warning">' + document.getElementById('postOUTPUT').value.length + '</span></div>';
                    } else {
                        document.getElementById('postCharCount').innerHTML = '<div class="text-right mb-2"><span class="xsmall text-muted">Post Length:</span> <span class="badge badge-pill badge-light">' + document.getElementById('postOUTPUT').value.length + '</span></div>';
                    }


                    // copy post output to clipboard
                    function copyPost() {
                        var copyText = document.querySelector('#postOUTPUT');
                        copyText.select();
                        copyText.setSelectionRange(0, 99999); /*for mobile devices*/
                        document.execCommand('copy');
                    }
                    document.querySelector('#copyPOST').addEventListener('click', copyPost);

                } // doIT = 1
            }
            doPostActions();

        </script>

    </body>
</html>
