<?php
/**
 * @package Forum Post Assistant / Bug Report Assistant
 * @version 1.2.0
 * @release playGround
 * @date 24/06/2011
 * @author RussW
 * @author Nikolai Plath (elkuku)
 */

error_reporting(-1);//-- Do you dare ? =;)

$sfBuilderDefinedLanguages = array('en-GB' => 'English', 'be-BY' => 'Belarusian', 'de-DE' => 'Deutsch', 'es-ES' => 'Español', 'fi-FI' => 'Suomi', 'hu-HU' => 'Hungarian', 'id-ID' => 'Indonesian', 'it-IT' => 'Italiano', 'pl-PL' => 'Polish', 'pt-BR' => 'Portuguese');//AutoFilled

$lang =(isset($_REQUEST['lang'])) ? $_REQUEST['lang'] : 'en-GB';

//-- "Load" the language
try
{
    qLanguage::loadLanguage($lang);
}
catch(Exception $e)
{
    //-- We shurely would die without a language, so..
    die($e->getMessage());
}//try

/** SET THE FPA DEFAULTS *****************************************************************/
define ( '_FPA_BRA', TRUE );      // bug-report-mode, else it's the standard Forum Post Assistant
// define ( '_FPA_DEV', TRUE );      // developer-mode, displays raw array data
// define ( '_FPA_DIAG', TRUE );     // diagnostic-mode, turns on PHP logging errors, display errors and logs error to a file.

/** SET THE JOOMLA! PARENT FLAG AND CONSTANTS ********************************************/
define ( '_VALID_MOS', 1 );         // for J!1.0
define ( '_JEXEC', 1 );             // for J!1.5, J!1.6, J!1.7



// Define some basic assistant information
if ( defined ( '_FPA_BRA' ) ) {
    define ( '_RES', 'Bug Report Assistant' );
} else {
    define ( '_RES', 'Forum Post Assistant' );
}

define ( '_RES_VERSION', '1.2.0' );
define ( '_RES_RELEASE', 'Beta' );         // can be Alpha, Beta, RC, Final
define ( '_RES_BRANCH', 'playGround' );    // can be playGround (Alpha/Beta only), currentDevelopment (RC only), masterPublic (Final only)
// define ( '_RES_LANG', 'en-GB' );               // Country/Language Code
define ( '_FPA_VER', 'Version' );

// !TODO update this once the REPO is re-organised
define ( '_RES_FPALINK', 'https://github.com/ForumPostAssistant/FPA/archives/' ); // where to get the latest 'Final Releases'
define ( '_RES_FPALATEST', 'Get the latest release of the ' );

/** DEFINE LANGUAGE STRINGS **************************************************************/
// define ( '_PHP_DISERR', 'Display PHP Errors Enabled' );
// define ( '_PHP_ERRREP', 'PHP Error Reporting Enabled' );
// define ( '_PHP_LOGERR', 'PHP Errors Being Logged To File' );

// section titles & developer-mode array names
// define ( '_FPA_SNAP_TITLE', 'Environment Support Snapshot' );
// define ( '_FPA_INST_TITLE', 'Application Instance' );
// define ( '_FPA_SYS_TITLE', 'System Environment' );
// define ( '_FPA_PHP_TITLE', 'PHP Environment' );
// define ( '_FPA_PHPEXT_TITLE', 'PHP Extensions' );
// define ( '_FPA_PHPREQ_TITLE', 'PHP Requirements' );
// define ( '_FPA_APAMOD_TITLE', 'Apache Modules' );
// define ( '_FPA_APAREQ_TITLE', 'Apache Requirements' );
// define ( '_FPA_DB_TITLE', 'Database Instance' );
// define ( '_FPA_DBTBL_TITLE', 'Table Structure' );
// define ( '_FPA_PERMCHK_TITLE', 'Permissions Checks' );
// define ( '_FPA_COREDIR_TITLE', 'Core Folders' );
// define ( '_FPA_ELEVPERM_TITLE', 'Elevated Permissions' );
// define ( '_FPA_EXTCOM_TITLE', 'Components' );
// define ( '_FPA_EXTMOD_TITLE', 'Modules' );
// define ( '_FPA_EXTPLG_TITLE', 'Plugins' );
// define ( '_FPA_TMPL_TITLE', 'Templates' );

// snapshot definitions
// v1.2.0
// define ( '_FPA_SUPPHP', 'PHP Supports');
// define ( '_FPA_SUPSQL', 'MySQL Supports');
// define ( '_FPA_BADPHP', 'Known Buggy PHP');
// define ( '_FPA_BADZND', 'Known Buggy Zend');
// slow screen message
// v1.2.0
// define ( '_FPA_SLOWGENPOST', 'Generating Post Output...' );
// define ( '_FPA_SLOWRUNTEST', 'Hang on in there while we run some tests...' );

// dev/diag-mode content
// v1.2.0
// define ( '_FPA_DEVMI', 'developer-mode-information' );
// define ( '_FPA_ELAPSE', 'elapse-runtime' );
// define ( '_FPA_DEVENA', 'DEVELOPER MODE is enabled' );
// define ( '_FPA_DEVDSC', 'This means that a variety of additional information will be displayed on-screen to assist with troubleshooting this script.' );
// define ( '_FPA_DIAENA', 'DIGNOSTIC MODE is enabled' );
// define ( '_FPA_DIADSC', 'This means that all php and script errors will be displayed on-screen and logged out to a file named' );
// define ( '_FPA_DIAERR', 'Last DIGNOSTIC MODE Error' );
// define ( '_FPA_SPNOTE', 'Special Note' );
// user post form content
// v1.2.0
// define ( '_FPA_INSTRUCTIONS', 'Instructions' );
// define ( '_FPA_INS_1', 'Enter your problem description <i>(optional)</i>' );
// define ( '_FPA_INS_2', 'Enter any error messages you see <i>(optional)</i>' );
// define ( '_FPA_INS_3', 'Enter any actions taken to resolve the issue <i>(optional)</i>' );
// define ( '_FPA_INS_4', 'Select detail level options of output <i>(optional)</i>' );
// define ( '_FPA_INS_5', 'Click the <span class="normal-note">Generate</span> post button to build the post content' );
// define ( '_FPA_INS_6', 'Copy the contents of the <span class="ok-hilite">&nbsp;Post Detail&nbsp;</span> box and paste it into a post' );
// define ( '_FPA_POST_NOTE', 'Leave ALL fields blank/empty to simply post diagnostic information.' );
// define ( '_FPA_PROB_DSC', 'Problem Description' );
// define ( '_FPA_PROB_MSG', 'Log/Error Message' );
// define ( '_FPA_PROB_ACT', 'Actions Taken To Resolve' );
// define ( '_FPA_PROB_CRE', 'Actions To ReCreate Issue' );
// define ( '_FPA_OPT', 'Optional Settings' );
// define ( '_FPA_SHOWELV', 'Show elevated folder permissions' );
// define ( '_FPA_SHOWDBT', 'Show database table statistics' );
// define ( '_FPA_SHOWCOM', 'Show Components' );
// define ( '_FPA_SHOWMOD', 'Show Modules' );
// define ( '_FPA_SHOWPLG', 'Show Plugins' );
// define ( '_FPA_INFOPRI', 'Information Privacy' );
// define ( '_FPA_PRIVNON', 'None' );
// define ( '_FPA_PRIVNONNOTE', 'No elements are masked' );
// define ( '_FPA_PRIVPAR', 'Partial' );
// define ( '_FPA_PRIVPARNOTE', 'Some elements are masked' );
// define ( '_FPA_PRIVSTR', 'Strict' );
// define ( '_FPA_PRIVSTRNOTE', 'All indentifiable elements are masked' );
// define ( '_FPA_CLICK', 'Click Here To Generate Post' );
// define ( '_FPA_OUTMEM', 'Out of Memory');
// define ( '_FPA_OUTTIM', 'Execution Time-Outs' );
// define ( '_FPA_INCPOPS', 'Temporarily increase PHP Memory and Execution Time' );
// define ( '_FPA_POSTD', 'Post Detail' );


/** common screen and post output strings ************************************************/
// v1.2.0
// define ( '_FPA_APP', 'Joomla!' );
// define ( '_FPA_INSTANCE', 'Instance' );
// define ( '_FPA_PLATFORM', 'Platform' );
// define ( '_FPA_DB', 'Database');
// define ( '_FPA_SYS', 'System' );
// define ( '_FPA_SERV', 'Server' );
// define ( '_FPA_CLNT', 'Client' );
// define ( '_FPA_HNAME', 'Hostname' );
// define ( '_FPA_DISC', 'Discovery' );
// define ( '_FPA_LEGEND', 'Legends and Settings' );
// define ( '_FPA_GOOD', 'OK/GOOD' );
// define ( '_FPA_WARNINGS', 'WARNINGS' );
// define ( '_FPA_ALERTS', 'ALERTS' );
// define ( '_FPA_SITE', 'SITE' );
// define ( '_FPA_ADMIN', 'ADMIN' );

### This should go => trash =;)
// define ( '_FPA_BY', 'by' );
// define ( '_FPA_OR', 'or' );
// define ( '_FPA_OF', 'of' );
// define ( '_FPA_TO', 'to' );
// define ( '_FPA_FOR', 'for' );
// define ( '_FPA_IS', 'is' );
// define ( '_FPA_AT', 'at' );
// define ( '_FPA_IN', 'in' );
// define ( '_FPA_BUT', 'but' );
### trash until here =;)


define ( '_FPA_NONE', 'None' );//@todo: constant ?
define ( '_FPA_M', 'Maybe' );//@todo: constant ?
define ( '_FPA_U', 'Unknown' );//@todo: constant ?
define ( '_FPA_3PD', '3rd Party' );//@todo: constant ?
define ( '_FPA_DNE', 'Does Not Exist' );//@todo: constant ?
define ( '_FPA_NA', 'N/A' );//@todo: constant ?

// define ( '_FPA_LAST', 'Last' );
// define ( '_FPA_DEF', 'default' );
// define ( '_FPA_Y', 'Yes' );
// define ( '_FPA_N', 'No' );
// define ( '_FPA_FIRST', 'First' );
// define ( '_FPA_K', 'Known' );
// define ( '_FPA_E', 'Exists' );
// define ( '_FPA_JCORE', 'Core' );
// define ( '_FPA_TESTP', 'tests performed' );


// define ( '_FPA_F', 'Found' );
// define ( '_FPA_NF', 'Not Found' );
// define ( '_FPA_OPTS', 'Options' );
// define ( '_FPA_CF', 'Config' );
// define ( '_FPA_CFG', 'Configuration' );
// define ( '_FPA_YC', 'Configured' );
// define ( '_FPA_NC', 'Not Configured' );
// define ( '_FPA_ECON', 'Connection Error' );
// define ( '_FPA_CON', 'Connect' );
// define ( '_FPA_YCON', 'Connected' );
// define ( '_FPA_CONT', 'Connection Type' );
// define ( '_FPA_NCON', 'Not Connected' );
// define ( '_FPA_SUP', 'support' );
// define ( '_FPA_YSUP', 'supported' );
// define ( '_FPA_DROOT', 'Doc Root' );
// define ( '_FPA_NSUP', 'not supported' );
// define ( '_FPA_NOA', 'Not Attempted' );
// define ( '_FPA_NER', 'No Errors Reported' );
// define ( '_FPA_ER', 'Error(s) Reported' );
// define ( '_FPA_ERR', 'error' );
// define ( '_FPA_ERRS', 'errors' );
// define ( '_FPA_YMATCH', 'matches' );
// define ( '_FPA_NMATCH', 'mis-match' );
// define ( '_FPA_NACOMP', 'appear complete' );
// define ( '_FPA_YACOMP', 'appear in-complete' );
// define ( '_FPA_SEC', 'Security' );
// define ( '_FPA_FEAT', 'Features' );
// define ( '_FPA_PERF', 'Performance' );


// define ( '_FPA_CRED', 'Credentials' );
// define ( '_FPA_CREDPRES', 'Credentials Present' );
// define ( '_FPA_HOST', 'Host' );
// define ( '_FPA_TEC', 'Technology' );
// define ( '_FPA_WSVR', 'Web Server' );
// define ( '_FPA_HIDDEN', 'protected' );
// define ( '_FPA_PASS', 'Password' );
// define ( '_FPA_USER', 'Username' );
// define ( '_FPA_USR', 'User' );
// define ( '_FPA_TNAM', 'Name' );
// define ( '_FPA_TSIZ', 'Size' );
// define ( '_FPA_TENG', 'Engine' );
// define ( '_FPA_TCRE', 'Created' );
// define ( '_FPA_TUPD', 'Updated' );
// define ( '_FPA_TCKD', 'Checked' );
// define ( '_FPA_TCOL', 'Collation' );
// define ( '_FPA_CHARS', 'Character Set' );
// define ( '_FPA_TFRA', 'Fragment Size' );
// define ( '_FPA_AUTH', 'Author' );
// define ( '_FPA_ADDR', 'Address' );
// define ( '_FPA_STATUS', 'Status' );
// define ( '_FPA_TREC', 'Rcds' );  // Number of table records
// define ( '_FPA_TAVL', 'Avg. Length' );
// define ( '_FPA_MODE', 'Mode' );
// define ( '_FPA_WRITABLE', 'Writable' );
// define ( '_FPA_RO', 'Read-Only' );
// define ( '_FPA_FOLDER', 'Folder' );
// define ( '_FPA_FILE', 'File' );
// define ( '_FPA_OWNER', 'Owner' );
// define ( '_FPA_GROUP', 'Group' );
// define ( '_FPA_LOCAL', 'Local' );
// define ( '_FPA_REMOTE', 'Remote' );
// define ( '_FPA_SECONDS', 'seconds' );
// define ( '_FPA_TBL', 'Table' );
// define ( '_FPA_STAT', 'Statistics' );
// define ( '_FPA_BASIC', 'Basic' );
// define ( '_FPA_DETAILED', 'Detailed' );
// define ( '_FPA_ENVIRO', 'Environment' );
// define ( '_FPA_VALID', 'Valid' );
// define ( '_FPA_NVALID', 'Not Valid' );
// define ( '_FPA_EN', 'Enabled' );
// define ( '_FPA_DI', 'Disabled' );
// define ( '_FPA_NO', 'No' );

// define ( '_FPA_POTOI', 'Potential Ownership Issues' );
// define ( '_FPA_POTME', 'Potential Missing Extensions' );
// define ( '_FPA_POTMM', 'Potential Missing Modules' );
// define ( '_FPA_DBCONNNOTE', 'may not be an error, check with host for remote access requirements.' );
// define ( '_FPA_DBCREDINC', 'Database credentials incomplete or not available');
// define ( '_FPA_MISSINGCRED', 'Missing credentials detected' );
// define ( '_FPA_NODISPLAY', 'Nothing to display.' );
// define ( '_FPA_EMPTY', 'could be empty' );
// define ( '_FPA_UINC', 'increased by user, was' );
// define ( '_PHP_VERLOW', 'PHP version too low' );
// define ( '_FPA_SHOW', 'Show' );
// define ( '_FPA_HIDE', 'Hide' );
/** END LANGUAGE STRINGS *****************************************************************/


echo '<?xml version="1.0" encoding="UTF-8"?>';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN"
    "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"
	xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
	xsi:schemaLocation="http://www.w3.org/MarkUp/SCHEMA/xhtml11.xsd"
	xml:lang="<?php echo qLanguage::getLangTag(); ?>">

<head>

<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />

<title><?php echo _RES .' : v'. _RES_VERSION .' ('. _RES_RELEASE .')';?></title>

<!-- @TODO different icons ? -->
<!-- @TODO NOW - the icon does not exist in J! >= 1.6 !! -->
<link rel="shortcut icon" href="./templates/rhuk_milkyway/favicon.ico" />

<style type="text/css" media="screen">
@CHARSET "UTF-8";
/**
 * TEST CSS file
 */
html,body,div,p,span {
	font-size: 10px;
	font-family: tahoma, arial;
	color: #404040;
}

.dev-mode-information {
	margin: 0 auto;
	margin-top: 10px;
	margin-bottom: 10px;
	padding: 5px;
	width: 750px;
	background-color: #CAFFD8;
	border: 1px solid #4D8000;
	/** CSS3 **/
	box-shadow: 3px 3px 3px #C0C0C0;
	-moz-box-shadow: 3px 3px 3px #C0C0C0;
	-webkit-box-shadow: 3px 3px 3px #C0C0C0;
	border-radius: 5px;
	-moz-border-radius: 5px;
	-webkit-border-radius: 5px;
}

.dev-mode-title {
	color: #4D8000;
	font-weight: bold;
	/** CSS3 **/
	text-shadow: 1px 1px 1px #FFF;
}

.snapshot-information {
	margin: 0 auto;
	margin-top: 10px;
	margin-bottom: 10px;
	padding: 5px;
	width: 740px;
	background-color: #F3EFE0;
	border: 1px solid #999966;
	/** CSS3 **/
	box-shadow: 3px 3px 3px #C0C0C0;
	-moz-box-shadow: 3px 3px 3px #C0C0C0;
	-webkit-box-shadow: 3px 3px 3px #C0C0C0;
	border-radius: 5px;
	-moz-border-radius: 5px;
	-webkit-border-radius: 5px;
}

.header-information {
	margin: 0px auto;
	margin-top: 10px;
	margin-bottom: 10px;
	padding: 5px;
	width: 740px;
	background-color: #E0FFFF;
	border: 1px solid #42AEC2;
	/** CSS3 **/
	box-shadow: 3px 3px 3px #C0C0C0;
	-moz-box-shadow: 3px 3px 3px #C0C0C0;
	-webkit-box-shadow: 3px 3px 3px #C0C0C0;
	border-radius: 5px;
	-moz-border-radius: 5px;
	-webkit-border-radius: 5px;
}

.header-title {
	color: #404040;
	text-align: center;
	font-size: 14px;
	font-weight: bold;
	padding: 1px;
	text-transform: uppercase;
	margin-left: 1px;
	margin-right: 1px;
	margin-top: 2px;
	margin-bottom: 2px;
	/** CSS3 **/
	text-shadow: 1px 1px 1px #FFF;
}

.header-column-title {
	color: #404040;
	font-weight: normal;
	padding: 1px;
	/** CSS3 **/
	text-shadow: 1px 1px 1px #FFF;
}

.section-information {
	margin: 0px auto;
	margin-top: 10px;
	margin-bottom: 10px;
	padding: 5px;
	width: 740px;
	background-color: #E0FFFF;
	border: 1px solid #42AEC2;
	min-height: 188px;
	/** CSS3 **/
	box-shadow: 3px 3px 3px #C0C0C0;
	-moz-box-shadow: 3px 3px 3px #C0C0C0;
	-webkit-box-shadow: 3px 3px 3px #C0C0C0;
	border-radius: 5px;
	-moz-border-radius: 5px;
	-webkit-border-radius: 5px;
}

.half-section-container {
	margin: 0px auto;
	padding: 5px;
	width: 750px;
}

.half-section-information-left {
	float: left;
	min-height: 188px;
	margin-top: 10px;
	margin-bottom: 10px;
	padding: 5px;
	width: 355px;
	background-color: #E0FFFF;
	border: 1px solid #42AEC2;
	/** CSS3 **/
	box-shadow: 3px 3px 3px #C0C0C0;
	-moz-box-shadow: 3px 3px 3px #C0C0C0;
	-webkit-box-shadow: 3px 3px 3px #C0C0C0;
	border-radius: 5px;
	-moz-border-radius: 5px;
	-webkit-border-radius: 5px;
}

.half-section-information-right {
	float: right;
	min-height: 188px;
	margin-top: 10px;
	margin-bottom: 10px;
	padding: 5px;
	width: 355px;
	background-color: #E0FFFF;
	border: 1px solid #42AEC2;
	/** CSS3 **/
	box-shadow: 3px 3px 3px #C0C0C0;
	-moz-box-shadow: 3px 3px 3px #C0C0C0;
	-webkit-box-shadow: 3px 3px 3px #C0C0C0;
	border-radius: 5px;
	-moz-border-radius: 5px;
	-webkit-border-radius: 5px;
}

.section-title {
	color: #404040;
	font-size: 12px;
	font-weight: bold;
	padding: 1px;
	text-transform: uppercase;
	margin-left: 1px;
	margin-right: 1px;
	margin-top: 2px;
	margin-bottom: 2px;
	/** CSS3 **/
	text-shadow: 1px 1px 1px #F5F5F5;
}

.mini-content-container {
	font-size: 9px !important;
	float: left;
	width: 83px;
	height: 75px;
	margin: 2px;
}

.mini-content-title {
	font-size: 8px;
	font-weight: bold;
	text-align: center;
	margin: 0px auto;
	margin-bottom: 4px !important;
	border-bottom: 1px solid #C0C0C0;
	text-transform: uppercase;
	/** CSS3 **/
	text-shadow: 1px 1px 1px #FFF;
}

.mini-content-box {
	font-size: 10px !important;
	text-align: center;
	margin: 0px auto;
	padding: 4px;
	border: 1px solid #42AEC2;
	height: 45px;
	background-color: #FFFFFF;
	/** CSS3 **/
	border-radius: 5px;
	-moz-border-radius: 5px;
	-webkit-border-radius: 5px;
}

.mini-content-box-small {
	font-size: 9px !important;
	text-align: center;
	margin: 0px auto;
	padding-left: 2px;
	text-align: left;
}

.column-title-container {
	background-color: #42AEC2;
	/** CSS3 **/
	border-top-left-radius: 5px;
	-moz-border-radius-topleft: 5px;
	-webkit-border-top-left: 5px;
	border-top-right-radius: 5px;
	-moz-border-radius-topright: 5px;
	-webkit-border-top-right: 5px;
}

.column-title {
	color: #E0FFFF;
	font-weight: bold;
	padding: 1px;
	text-transform: uppercase;
	margin-left: 1px;
	margin-right: 1px;
	margin-top: 2px;
	margin-bottom: 2px;
	/** CSS3 **/
	text-shadow: 1px 1px 1px #808080;
}

.row-content-container {
	border-bottom: 1px dotted #C0C0C0;
	width: 99%;
	margin: 0px auto;
	clear: both;
}

.nothing-to-display {
	text-align: center;
	font-size: 11px;
}

.column-content {
	margin-left: 1px;
	margin-right: 1px;
}

.normal {
	color: #404040;
}

.normal-note {
	color: #4D8000;
	background-color: #FFF;
	padding: 2px;
	margin-left: 5px;
	margin-right: 5px;
	font-weight: normal;
	border: 1px solid #4D8000;
	/** CSS3 **/
	box-shadow: 2px 2px 2px #C0C0C0;
	-moz-box-shadow: 2px 2px 2px #C0C0C0;
	-webkit-box-shadow: 2px 2px 2px #C0C0C0;
	border-radius: 3px;
	-moz-border-radius: 3px;
	-webkit-border-radius: 3px;
	text-shadow: 1px 1px 1px #F5F5F5;
}

.ok {
	color: #008000;
}

.ok-hilite {
	background-color: #CAFFD8;
	color: #008000;
	border: 1px solid #4D8000;
	/** CSS3 **/
	border-radius: 5px;
	-moz-border-radius: 5px;
	-webkit-border-radius: 5px;
}

.warn {
	background-color: #FFE4B5;
	color: #800000;
	border: 1px solid #FFA500;
	/** CSS3 **/
	border-radius: 5px;
	-moz-border-radius: 5px;
	-webkit-border-radius: 5px;
}

.warn-text {
	color: #FFA500;
}

.alert {
	background-color: #FFFF00;
	color: #800000;
	border: 1px solid #800000;
	/** CSS3 **/
	border-radius: %px;
	-moz-border-radius: 5px;
	-webkit-border-radius: 5px;
}

.alert-text {
	color: #800000;
}

.protected {
	color: #f60;
	background-color: #FFFFCC;
	line-height: 9px;
	font-size: 9px;
	font-weight: normal;
	text-transform: none;
}

fieldset.langSelect {
	padding: 0;
}

fieldset.langSelect ul {
	margin: 0;
}

fieldset.langSelect li {
	display: inline;
	padding-right: 0.5em;
}

fieldset.langSelect a {
	font-size: 12px;
	text-decoration: none;
	color: #000;
}

fieldset.langSelect a.active {
	background-color: #ffc;
}
</style>

<script type="text/javascript">
<!--
/**
 * TEST Javascript file
 */

/**
 * Submit the ''admin form''
 */
function submitform(pressbutton) {
	frm = document.getElementById('adminForm');

	if (pressbutton) {
		frm.task.value = pressbutton;
	}

	if (typeof frm.onsubmit == "function") {
		frm.onsubmit();
	}

	frm.submit();
}

/**
 * Show/Hide Post Form.
 * 
 * @param showHideDiv
 * @param switchTextDiv
 * @returns
 */
function toggle2(showHideDiv, switchTextDiv) {
	var ele = document.getElementById(showHideDiv);
	var text = document.getElementById(switchTextDiv);

	if (ele.style.display == "block") {
		ele.style.display = "none";
		text.innerHTML = '<span style="font-size:12px;color:#4D8000;"><span style="font-size:18px;color:#008000;">&Theta;</span> Show the <strong><?php echo _RES; ?></strong></span>';
	} else {
		ele.style.display = "block";
		text.innerHTML = '<span style="font-size:12px;color:#800000;"><span style="font-size:20px;color:#800000;">&otimes;</span> Hide the <strong><?php echo _RES; ?></strong></span>';
	}
}

 -->
</script>

</head>

<body onload="document.getElementById('slowScreenSplash').style.display = 'none';">

<div class="outer">

	<form method="post" id="adminForm" action="<?php echo $_SERVER['PHP_SELF']; ?>">

<?php


##########################################################################################
//@TODO refactorMe =;)
##########################################################################################


/** DISPLAY A "PROCESSING" MESSAGE, if the the routines take too long ********************/
// !TODO slowScreenSplash seems to be a little flaky
echo '<div id="slowScreenSplash" style="padding:20px;border: 2px solid #4D8000;background-color:#FFFAF0;border-radius: 10px;-moz-border-radius: 10px;-webkit-border-radius: 10px;margin: 0 auto; margin-top:50px;margin-bottom:20px;width:700px;position:relative;z-index:9999;top:10%; text-align: center">';
echo '<h1>'. _RES .'</h1>';

if ( @$_POST['doIT'] == 1 ) {
    echo '<h3 style="color:#4D8000;">'. qText('Generating Post Output...') .'</h3>';
} else {
    echo '<h3 style="color:#4D8000;">'. qText('Hang on in there while we run some tests...') .'</h3>';
}

echo '<br />v'. _RES_VERSION .'-'. _RES_RELEASE . ' (' . _RES_BRANCH . ')';
echo '</div>';

// setup the default runtime parameters and collect the POST data changes, if any

// default (limited privacy masking)
$showProtected  =( @$_POST['showProtected'] ) ? $_POST['showProtected'] : 2;
$showElevated   =( @$_POST['showElevated'] == 1 ) ? 1 : 0;
$showTables     =( @$_POST['showTables'] == 1 ) ? 1 : 0;
$showComponents =( @$_POST['showComponents'] == 1 ) ? 1 : 0;
$showModules    =( @$_POST['showModules'] == 1 ) ? 1 : 0;
$showPlugins    =( @$_POST['showPlugins'] == 1 ) ? 1 : 0;

// setup the Post type (Forum=BBCode, GitHUB=markdown or JoomlaCode=plain-text)
// later on, we also remove 'Elevated Permissions' & 'dB Stats' from GitHUb & JoomlaCode outputs based on these settings
if ( @$_POST['postFormat'] == 1 AND defined( '_FPA_BRA' ) ) {
    $postFormat  = 1;  // JoomlaCode
} elseif ( @$_POST['postFormat'] == 2 AND defined( '_FPA_BRA' ) ) {
    $postFormat  = 2;  // GitHUB
} elseif ( @$_POST['postFormat'] == 3 ) {
    $postFormat  = 3;   // Forum
} elseif ( defined( '_FPA_BRA' ) ) {
    $postFormat  = 2;  // GitHUB (default if BRA defined)
} else {
    $postFormat  = 3;   // Forum (default if BRA not defined)
}

// actually start the timer-pop
mt_start();

// build the initial arrays used throughout fpa/bra

if ( defined ( '_FPA_BRA' ) ) {
    $fpa['diagLOG']         = 'bra-Diag.log';
} else {
    $fpa['diagLOG']         = 'fpa-Diag.log';
}

$system = discoverSystem();

$instance = discoverInstance($system);

$phpenv = discoverPhpEnv($instance, $system);

$fpa['ARRNAME']             = _RES;

$phpenv['ARRNAME']          = qText('PHP Environment');
$snapshot['ARRNAME']        = qText('Environment Support Snapshot');
$instance['ARRNAME']        = qText('Application Instance');
$system['ARRNAME']          = qText('System Environment');
$phpextensions['ARRNAME']   = qText('PHP Extensions');
$phpreq['ARRNAME']          = qText('PHP Requirements');
$elevated['ARRNAME']        = qText('Elevated Permissions');
$component['ARRNAME']       = qText('Components');
$module['ARRNAME']          = qText('Modules');
$plugin['ARRNAME']          = qText('Plugins');
$template['ARRNAME']        = qText('Templates');
$apachemodules['ARRNAME']   = qText('Apache Modules');
$apachereq['ARRNAME']       = qText('Apache Requirements');
$database['ARRNAME']        = qText('Database Instance');
$tables['ARRNAME']          = qText('Table Structure');
$modecheck['ARRNAME']       = qText('Permissions Checks');
$folders['ARRNAME']         = qText('Core Folders');

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
$phpreq['mcrypt']           = '';
$phpreq['suhosin']          = '';
//    $phpreq['test']             = '';

$apachereq['mod_rewrite']   = '';
$apachereq['mod_expires']   = '';
$apachereq['mod_deflate']   = '';
$apachereq['mod_security']  = '';
$apachereq['mod_evasive']   = '';
$apachereq['mod_dosevasive'] = '';
$apachereq['mod_ssl']       = '';
$apachereq['mod_qos']       = '';
$apachereq[' mod_userdir']  = '';
//    $apachereq['test']          = '';

// folders to be tested for permissions
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
//    $folders[]                  = 'test/';

/** DETERMINE SOME SETTINGS BEFORE FPA MIGHT PLAY WITH THEM ******************************/
$fpa['ORIGphpMEMLIMIT']     = ini_get( 'memory_limit' );
$fpa['ORIGphpMAXEXECTIME']  = ini_get( 'max_execution_time' );

// if the user see's Out Of Memory or Execution Timer pops, double the current memory_limit and max_execution_time
// !FIXME doubling limits, seems a bit flaky on very secure hosts
if ( @$_POST['increasePOPS'] == 1 ) {
    ini_set ( 'memory_limit', $fpa['ORIGphpMEMLIMIT']*2 );
    ini_set ( 'max_execution_time', $fpa['ORIGphpMAXEXECTIME']*2 );
}

/** SEEING A WHITE SCREEN WHILST RUNNING FPA? OR SOMEONE HELPING YOU SENT YOU HERE? *******
 ** uncomment _FPA_DIAG above and re-run FPA
 **
 ** display_errors, enables php errors to be displayed on the screen
 ** error_reporting, sets the level of errors to report, "-1" is all errors
 ** log_errors, enables errors to be logged to a file, fpa_error.log in the "/" folder
 *****************************************************************************************/

if ( defined( '_FPA_DEV' ) OR defined( '_FPA_DIAG' ) ) {
    // these can only have inline styling because it is outputed before the html styling
    echo '<div style="text-align:center; margin:0px auto; margin-bottom: 5px; width:750px;">';

    if ( defined( '_FPA_DEV' ) AND defined( '_FPA_DIAG' ) ) {
        $divwidth = '350px';
    } else {
        $divwidth = '740px';
    }

    // display developer-mode notice
    if ( defined( '_FPA_DEV' ) ) {
//             ini_set( 'display_errors', 'Off' ); // default-display ----- WTF - whatadev... :(

        echo '<div style="text-shadow: 1px 1px 1px #FFF;float:right; text-align:center; width:'. $divwidth .'; background-color:#CAFFD8; border:1px solid #4D8000; color:#404040; font-size:10px; font-family:arial; padding:5px;-moz-box-shadow: 3px 3px 3px #C0C0c0;-webkit-box-shadow: 3px 3px 3px #C0C0c0;box-shadow: 3px 3px 3px #C0C0c0;border-radius:5px;-moz-border-radius:5px;-webkit-border-radius:5px;">';
        echo '<strong style="color:#4D8000;">'. qText('DEVELOPER MODE is enabled') .'</strong><br />';
        echo qText('This means that a variety of additional information will be displayed on-screen to assist with troubleshooting this script.');
        echo '</div>';
    } // end developer-mode display

    // display diagnostic-mode notice
    if ( defined( '_FPA_DIAG' ) ) {
        ini_set( 'display_errors', 1 );

        ini_set ( 'error_reporting', '-1' );
        ini_set( 'error_log', $fpa['diagLOG'] );

        echo '<div style="text-shadow: 1px 1px 1px #FFF;float:left; text-align:center; width:'. $divwidth .'; background-color:#CAFFD8; border:1px solid #4D8000; color:#404040; font-size:10px; font-family:arial; padding:5px;-moz-box-shadow: 3px 3px 3px #C0C0c0;-webkit-box-shadow: 3px 3px 3px #C0C0c0;box-shadow: 3px 3px 3px #C0C0c0;border-radius:5px;-moz-border-radius:5px;-webkit-border-radius:5px;">';
        echo '<strong style="color:#4D8000;">'. qText('DIGNOSTIC MODE is enabled') .'</strong><br />';
        echo sprintf(qText('This means that all php and script errors will be displayed on-screen and logged out to a file named %s.'), $fpa['diagLOG']);
        echo '</div>';

        echo '<div style="clear:both;" /></div>';

        if ( file_exists( $fpa['diagLOG'] ) ) {
            echo '<div style="margin-top:10px;text-align:left;text-shadow: 1px 1px 1px #FFF; width:740px; background-color:#FFFFCC; border:1px solid #800000; color:#404040; font-size:10px; font-family:arial; padding:5px;-moz-box-shadow: 3px 3px 3px #C0C0c0;-webkit-box-shadow: 3px 3px 3px #C0C0c0;box-shadow: 3px 3px 3px #C0C0c0;border-radius:5px;-moz-border-radius:5px;-webkit-border-radius:5px;">';
            echo '<strong style="color:#800000;">DIAGNOSTIC MODE ERROR</strong> in '. $fpa['diagLOG'] .'<br />';

            $fpa['fpaLASTERR'] = @array_pop( file( $fpa['diagLOG'] ) );
            echo $fpa['fpaLASTERR'];
            echo '</div>';

        } else {
            echo '<div style="margin-top:10px;text-align:left;text-shadow: 1px 1px 1px #FFF; width:740px; background-color:#FFFFCC; border:1px solid #800000; color:#404040; font-size:10px; font-family:arial; padding:5px;-moz-box-shadow: 3px 3px 3px #C0C0c0;-webkit-box-shadow: 3px 3px 3px #C0C0c0;box-shadow: 3px 3px 3px #C0C0c0;border-radius:5px;-moz-border-radius:5px;-webkit-border-radius:5px;">';
            echo '<strong style="color:#800000;">'. sprintf(qText('Last DIGNOSTIC MODE Error in %s'), $fpa['diagLOG']) .'</strong> ' . '<br />';
            echo qText('No Errors Reported');
            echo '</div>';
        }

    } // end diagnostic-mode display

    echo '<br style="clear:both;" />';
    echo '</div>';

} else { // end developer- or diag -mode display
//         ini_set( 'display_errors', 0 ); // default-display
}

/******************************************************************************************************************/
/** This is a test variable to check that diagnostic mode works, uncomment to cause an Undefined Variable notice **/
/** this will display an error if Developer-mode/diagnostic-mode are enabled, otherwise you shouldn't see errors **/

// echo $ExpectedDiagDevModeErrorVariable;

/******************************************************************************************************************/

// TESTING ONLY HUUUUUUGE DB  ( 2.1 GiB)
//$instance['configDBNAME'] = 'njs_bandsite';

// get all the Apache loaded extensions and versions
foreach ( get_loaded_extensions() as $i => $ext ) {
    $phpextensions[$ext]    = phpversion($ext);
}

$phpextensions['Zend Engine'] = zend_version();


/** DETERMINE APACHE ENVIRONMENT & SETTINGS ***********************************************
 ** here we try to determine the php enviroment and configuration
 ** to try and avoid "white-screens" fpa tries to check for function availability before
 ** using any function, but this does mean it has grown in size quite a bit and unfortunately
 ** gets a little messy in places.
 *****************************************************************************************/
/** general apache loaded modules? *******************************************************/
if ( function_exists( 'apache_get_version' ) ) {  // for Apache module interface

    foreach ( apache_get_modules() as $i => $modules ) {
       $apachemodules[$i] = ( $modules );  // show the version of loaded extensions
    }

    // include the Apache version
    $apachemodules[] = apache_get_version();

} else {  // for Apache cgi interface

    // !TESTME Does this work in cgi or cgi-fcgi
    print_r( get_extension_funcs( "cgi-fcgi" ) );
}
// !TODO see if there are IIS specific functions/modules


/** COMPLETE MODE (PERMISSIONS) CHECKS ON KNOWN FOLDERS ***********************************
 ** test the mode and writability of known folders from the $folders array
 ** to try and avoid "white-screens" fpa tries to check for function availability before
 ** using any function, but this does mean it has grown in size quite a bit and unfortunately
 ** gets a little messy in places.
 *****************************************************************************************/
/** build the mode-set details for each folder *******************************************/
if ( $instance['instanceFOUND'] == qText('Yes') ) {

    foreach ( $folders as $i => $show ) {

        if ( $show != $folders['ARRNAME'] ) { // ignore the ARRNAME

            if ( file_exists( $show ) ) {
                $modecheck[$show]['mode'] = substr( sprintf('%o', fileperms( $show ) ),-3, 3 );

                if ( is_writable( $show ) ) {
                    $modecheck[$show]['writable'] = qText('Yes');

                } else {
                    $modecheck[$show]['writable'] = qText('No');
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

    // !FIXME need to fix warning in array_filter ( '@' work-around )
    // new filtered list of folders to check permissions on, based on the installed release
    @array_filter( $folders, filter_folders( $folders, $instance ) );

}

unset ( $key, $show );


/** getDirectory FUNCTION TO RECURSIVELY READ THROUGH LOOKING FOR PERMISSIONS ************
 ** this is used to read the directory structure and return a list of folders with 'elevated'
 ** mode-sets ( -7- or --7 ) ignoring the first position as defaults folders are normally 755.
 ** $dirCount is applied when the folder list is excessive to reduce unnecessary processing
 ** on really sites with 00's or 000's of badly configured folder modes. Limited to displaying
 ** the first 10 only.
 *****************************************************************************************/
if ( $showElevated == '1' ) {

    $dirCount = 0;

        if ( $dirCount == '0' ) {
            $elevated['None'] = _FPA_NONE;
            $elevated['None']['mode'] = '-';
            $elevated['None']['writable'] = '-';
        }

    // now call the function to read from the selected folder ( '.' current location of FPA script )
    getDirectory( '.' );
    ksort( $elevated );

} // end showElevated

/** DETERMINE THE MYSQL VERSION AND IF WE CAN CONNECT *************************************
 ** here we try and find out more about MySQL and if we have an installed instance, see if
 ** talk to it and access the database.
 *****************************************************************************************/
if ( $instance['instanceCONFIGURED'] == qText('Yes')
// AND $instance['configDBCREDOK'] == qText('Yes') // disabled to allow empty password
)
{
    $database['dbDOCHECKS'] = qText('Yes');

    // look to see if we are using a remote or local MySQL server
    if ( $instance['configDBHOST'] == 'localhost' OR $instance['configDBHOST'] == '127.0.0.1' ) {
        $database['dbLOCAL'] = qText('Yes');

    } else {
        $database['dbLOCAL'] = qText('No');
    }

    // !TODO DB PING
    /**
        // See if the PHP Functions are available to test for connectivity
        if ( @$opSystem != 'WIN') {

          if ( function_exists('exec') ) {
            $hostPing = 1;
            exec("ping -c 2 ". $cfgARRAY['dbhost'][1] ." 2>&1", $output, $retval);
          } else if ( function_exists('passthru') ) {
            $hostPing = 1;
            passthru("ping -c 2 ". $cfgARRAY['dbhost'][1] ." >/dev/null 2>$0", $retval);
          } else if ( function_exists('system') ) {
            $hostPing = 1;
            system("ping -c 2 ". $cfgARRAY['dbhost'][1] ." >/dev/null 2>$0", $retval);
          } else {
            $hostPing = 0;
            echo '<br /><span class="isOk">ping not attempted, PHP restriciton</span>';
          }

        } else { // Windows Machines IIS Users, by default have no access to the shell, so the above errors
          @$hostPing = 0;
          echo '<br /><span class="isOk">ping not attempted, host restriciton</span>';
        }

        if ( @$hostPing != 0 ) {

          if ( @$retval != 0 ) {
            echo '<br />- '. PINGHOST .' <span class="isNo">'. FAIL .'</span>';
          } else {
            echo '<br />- '. PINGHOST .' <span class="isYes">'. SUCCESS.'</span>';
          }

        }
    **/
    // try and establish if we can talk to the dBase server with a ping, then try and connect and ping with mysql_ping

    // try and connect to the database server and table-space, using the database_host variable in the configuration.php
    // for J!1.0, it's not in the config, so we have assumed mysql, as mysqli wasn't available during it's support life-time
    if ( $instance['configDBTYPE'] == 'mysql' ) {

        $dBconn = @mysql_connect( $instance['configDBHOST'], $instance['configDBUSER'], $instance['configDBPASS'] );
        $database['dbERROR'] = mysql_errno() .':'. mysql_error();

        if ( $dBconn ) {
            mysql_select_db( $instance['configDBNAME'], $dBconn );
            $database['dbERROR'] = mysql_errno() .':'. mysql_error();

            // if we can connect, try and collect some details
            $database['dbHOSTSERV']     = mysql_get_server_info( $dBconn );      // SQL server version
            $database['dbHOSTINFO']     = mysql_get_host_info( $dBconn );        // connection type to dB
            $database['dbHOSTPROTO']    = mysql_get_proto_info( $dBconn );       // server protocol type
            $database['dbHOSTCLIENT']   = mysql_get_client_info();               // client library version
            $database['dbHOSTDEFCHSET'] = mysql_client_encoding( $dBconn );      // this is the hosts default character-set
            $database['dbHOSTSTATS']    = explode("  ", mysql_stat( $dBconn ) ); // latest statistics

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


    } elseif ( $instance['configDBTYPE'] == 'mysqli' AND $phpenv['phpSUPPORTSMYSQLI'] == qText('Yes') ) { // mysqli
        $dBconn = @new mysqli( $instance['configDBHOST'], $instance['configDBUSER'], $instance['configDBPASS'], $instance['configDBNAME'] );
        $database['dbERROR'] = mysqli_connect_errno( $dBconn ) .':'. mysqli_connect_error( $dBconn );

        if ( $dBconn ) {
            $database['dbHOSTSERV']     = @mysqli_get_server_info( $dBconn );       // SQL server version
            $database['dbHOSTINFO']     = @mysqli_get_host_info( $dBconn );         // connection type to dB
            $database['dbHOSTPROTO']    = @mysqli_get_proto_info( $dBconn );        // server protocol type
            $database['dbHOSTCLIENT']   = @mysqli_get_client_info();                // client library version
            $database['dbHOSTDEFCHSET'] = @mysqli_client_encoding( $dBconn );       // this is the hosts default character-set
            $database['dbHOSTSTATS']    = explode("  ", @mysqli_stat( $dBconn ) );  // latest statistics

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
            $tblResult = @$dBconn->query( 'SHOW TABLE STATUS' );

                $database['dbSIZE'] = 0;
                $rowCount           = 0;

                while ( $row = @mysqli_fetch_array( $tblResult ) ) {
                    $rowCount++;

                    $tables[$row['Name']]['TABLE']  = $row['Name'];

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
            $database['dbHOSTDEFCHSET'] = _FPA_U; // this is the hosts default character-set
            $database['dbHOSTSTATS']    = _FPA_U; // latest statistics
            $database['dbCOLLATION']    =  _FPA_U;
            $database['dbCHARSET']      =  _FPA_U;
    } // end of dataBase connection routines



    if ( isset( $dBconn ) AND $database['dbERROR'] == '0:' ) {
        $database['dbERROR'] = qText('No');

    } elseif ( $database['dbLOCAL'] == qText('No') AND substr($database['dbERROR'], 0, 4) == '2005' ) { // 2005 = can't access host
        // if this is a remote host, it might be firewalled or disabled from external or non-internal network access
        $database['dbERROR']    = $database['dbERROR'] .' ( '. qText('May not be an error, check with host for remote access requirements.') .' )';
    }

// if no configuration or if configured but dBase credentials aren't valid
} else {
    $database['dbDOCHECKS']     = qText('No');
    $database['dbLOCAL']        = _FPA_U;
}
?>



<?php
/** DETERMINE THE MYSQL VERSION AND IF WE CAN CONNECT *************************************
 ** here we try and find out more about MySQL and if we have an installed instance, see if
 ** talk to it and access the database.
 *****************************************************************************************/
/** FIND AND ESTABLISH INSTALLED EXTENSIONS ***********************************************
 ** this function recurively looks for installed Components, Modules, Plugins and Templates
 ** it only reads the .xml file to determine installation status and info, some extensions
 ** do not have an associated .xml file and wont be displayed (normally core extensions)
 **
 ** modified version of the function for the recirsive folder permisisons previously
 *****************************************************************************************/
if ( $instance['instanceFOUND'] == qText('Yes') ) { // fix for IIS *shrug*



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


} // end if instanceFOUND
?>










<?php
/** display the fpa heading ***************************************************************/
echo '<div class="snapshot-information">';
echo '<div class="header-title" style="">'. _RES .'</div>';

/*
 * Language switcher
 */
?>
<fieldset class="langSelect"><legend><?php echo qText('Language'); ?></legend>
<ul>
<?php

foreach($sfBuilderDefinedLanguages as $defLang => $name)
{
    $active =($defLang == $lang) ? 'active' : ''; ?>
    <li>
        <a class="<?php echo $active; ?>" title="<?php echo $name; ?>" href="#" onclick="var frm=document.getElementById('adminForm'); frm.lang.value='<?php echo $defLang; ?>'; frm.submit();"><?php echo $defLang; ?></a>
    </li>
    <!--
	<input type="radio" name="langx" id="lng_<?php echo $defLang; ?>"
	onclick="submitform();" <?php echo $checked; ?>
	value="<?php echo $defLang; ?>" />
	<label for="lng_<?php echo $defLang; ?>">
		<?php echo $name; ?>
	</label><br />
     -->
<?php
}//foreach
?>
</ul>
<input type="hidden" name="lang" value="<?php echo $lang; ?>"/>
</fieldset>
<?php


echo '<div class="header-column-title" style="text-align:center;">'. _FPA_VER .': v'. _RES_VERSION .'-'. _RES_RELEASE .' ('. _RES_BRANCH .')</div>';

echo '<br />';

/** ENVIRONMENT SUPPORT NOTICE (snapshot) **************************************************
 ** this section displays a message explaining if the system, mysql and php environment
 ** can support the discovered version of Joomla!
 **
 ** REQUIREMENTS: (as far as I know!)
 **          ____________________________________________
 **          | J1.7/6 | J!1.5.0-14 | J1.5.0-23 |  J!1.0  |
 ** ------------------------------------------------------
 ** MIN PHP  | 5.2.4  |   4.3.10   |  4.3.10   |  3.0.1  |
 ** MAX PHP  | -----  |   5.2.17   |  5.3.6    |  4.4.9  | // 5.0.0 was first release to include MySQLi support
 ** ------------------------------------------------------
 ** MIN MYSQL| 5.0.4  |   3.23.0   |  3.23.0   |  3.0.0  |
 ** MAX MYSQL| -----  |   5.1.43   |  5.1.43   |  5.0.91 | // only limited to 4.1.29 & 5.1 because install sql still has ENGINE TYPE statements (removed in MySQL 5.5)
 ** ------------------------------------------------------
 ** BAD PHP  | -----  |   4.39, 4.4.2, 5.0.5   |  -----  |
 ** BAD SQL  | -----  |        >5.0.0          |  -----  |
 ** BAD ZEND | -----  |         2.5.10         |  -----  |
 *****************************************************************************************/
$fpa['supportENV'] = '';

echo '<div>';
echo '<div style="width:85%;margin:0 auto;margin-top:10px;">';

/** SUPPORT SECTIONS *************************************************************/
if ( @$instance['cmsRELEASE'] == '1.7' ) {
    $fpa['supportENV']['minPHP']        = '5.2.4';
    $fpa['supportENV']['minSQL']        = '5.0.4';
    $fpa['supportENV']['maxPHP']        = '6.0.0';  // latest release?
    $fpa['supportENV']['maxSQL']        = '5.5.0';  // latest release?
    $fpa['supportENV']['badPHP'][0]     = _FPA_NA;
    $fpa['supportENV']['badZND'][0]     = _FPA_NA;

} elseif ( @$instance['cmsRELEASE'] == '1.6' ) {
    $fpa['supportENV']['minPHP']        = '5.2.4';
    $fpa['supportENV']['minSQL']        = '5.0.4';
    $fpa['supportENV']['maxPHP']        = '6.0.0';  // latest release?
    $fpa['supportENV']['maxSQL']        = '5.5.0';  // latest release?
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
    $fpa['supportENV']['maxPHP']        = '4.4.9';
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



// minimum and maximum PHP support requirements met?
echo '<div style="font-weight:bold;font-size:9px;text-transform:uppercase;width:24%;float:left;text-align:center;">'. sprintf(qText('PHP Supports %s'), ' J!'. @$instance['cmsRELEASE']) .'<br />';

    if ( $fpa['supportENV']['minPHP'] == _FPA_NA ) {
        echo '<div class="normal-note"><span class="warn-text">'. qText('Unknown') .'</span></div>';
        $snapshot['phpSUP4J'] = _FPA_U;

    } elseif ( ( version_compare( PHP_VERSION, $fpa['supportENV']['minPHP'], '>=' ) ) AND ( version_compare( PHP_VERSION, $fpa['supportENV']['maxPHP'], '<=' ) ) ) {
        echo '<div class="normal-note"><span class="ok">'. qText('Yes') .'</span></div>';
        $snapshot['phpSUP4J'] = qText('Yes');

    } elseif ( ( version_compare( PHP_VERSION, $fpa['supportENV']['minPHP'], '<' ) ) OR ( version_compare( PHP_VERSION, $fpa['supportENV']['maxPHP'], '>' ) ) ) {
        echo '<div class="normal-note"><span class="alert-text">'. qText('No') .'</span></div>';
        $snapshot['phpSUP4J'] = qText('No');

    } else {
        echo '<div class="normal-note"><span class="warn-text">'. qText('Unknown') .'</span></div>';
        $snapshot['phpSUP4J'] = _FPA_U;
    }

echo '</div>';


// PHP API
echo '<div style="font-weight:bold;font-size:9px;text-transform:uppercase;width:24%;float:left;text-align:center;">PHP API<br />';

    if ( $phpenv['phpAPI'] ) {

        if ( $phpenv['phpAPI'] == 'apache2handler' ) {
            echo '<div class="normal-note"><span class="warn-text">'. $phpenv['phpAPI'] .'</span></div>';

        } else {
            echo '<div class="normal-note"><span class="ok">'. $phpenv['phpAPI'] .'</span></div>';
        }

    } else {
        echo '<div class="normal-note"><span class="warn-text">'. qText('Unknown') .'</span></div>';
    }

echo '</div>';


// MySQL supported by PHP?
echo '<div style="font-weight:bold;font-size:9px;text-transform:uppercase;width:24%;float:left;text-align:center;">'. sprintf(qText('PHP Supports %s'), 'MySQL').'<br />';

    if ( array_key_exists( 'mysql', $phpextensions ) ) {
        echo '<div class="normal-note"><span class="ok">'. qText('Yes') .'</span></div>';
        $snapshot['phpSUP4MYSQL'] = qText('Yes');

    } else {
        echo '<div class="normal-note"><span class="alert-text">'. qText('No') .'</span></div>';
        $snapshot['phpSUP4MYSQL'] = qText('No');
    }

echo '</div>';

// MySQLi supported by PHP?
echo '<div style="font-weight:bold;font-size:9px;text-transform:uppercase;width:24%;float:left;text-align:center;">'. sprintf(qText('PHP Supports %s'), 'MySQLi').'<br />';

    if ( array_key_exists( 'mysqli', $phpextensions ) ) {
        echo '<div class="normal-note"><span class="ok">'. qText('Yes') .'</span></div>';
        $snapshot['phpSUP4MYSQL-i'] = qText('Yes');

    } else {
        echo '<div class="normal-note"><span class="warn-text">'. qText('No') .'</span></div>';
        $snapshot['phpSUP4MYSQL-i'] = qText('No');
    }

echo '</div>';

echo '<div style="clear:both;"></div><br />';

// minimum and maximum MySQL support requirements met?
echo '<div style="font-weight:bold;font-size:9px;text-transform:uppercase;width:24%;float:left;text-align:center;">'. sprintf(qText('MySQL Supports %s'), 'J!'. @$instance['cmsRELEASE']) .'<br />';

    if ( $fpa['supportENV']['minSQL'] == _FPA_NA OR @$database['dbERROR'] != qText('No') ) {
        echo '<div class="normal-note"><span class="warn-text">'. qText('Unknown') .'</span></div>';
        $snapshot['sqlSUP4J'] = _FPA_U;

    } elseif ( ( version_compare( @$database['dbHOSTSERV'], $fpa['supportENV']['minSQL'], '>=' ) ) AND ( version_compare( @$database['dbHOSTSERV'], $fpa['supportENV']['maxSQL'], '<=' ) ) ) {

        // WARNING, will run, but ONLY after modifying install SQL to remove ENGINE TYPE statements (removed in MySQL 5.5)
        if ( ( $instance['cmsRELEASE'] == '1.5' ) AND ( @$database['dbHOSTSERV'] > '5.1.43' ) ) {
            echo '<div class="normal-note"><span class="warn-text">'. qText('Maybe') .' (<a href="http://forum.joomla.org/viewtopic.php?p=2297327" target="_new">'. qText('Special Note') .'</a>)</span></div>';
            $snapshot['sqlSUP4J'] = _FPA_M;

        } else {
            echo '<div class="normal-note"><span class="ok">'. qText('Yes') .'</span></div>';
            $snapshot['sqlSUP4J'] = qText('Yes');
        }

    } elseif ( ( version_compare( @$database['dbHOSTSERV'], $fpa['supportENV']['minSQL'], '<' ) ) OR ( version_compare( @$database['dbHOSTSERV'], $fpa['supportENV']['maxSQL'], '>' ) ) ) {

        // WARNING, will run, but ONLY after modifying install SQL to remove ENGINE TYPE statements (removed in MySQL 5.5)
        if ( ( $instance['cmsRELEASE'] == '1.5' ) AND ( @$database['dbHOSTSERV'] > '5.1.43' ) ) {
            echo '<div class="normal-note"><span class="warn-text">'. qText('Maybe') .' (<a href="http://forum.joomla.org/viewtopic.php?p=2297327" target="_new">'. qText('Special Note') .'</a>)</span></div>';
            $snapshot['sqlSUP4J'] = _FPA_M;

        } else {
            echo '<div class="normal-note"><span class="alert-text">'. qText('No') .'</span></div>';
            $snapshot['sqlSUP4J'] = qText('No');
        }

    } else {
        echo '<div class="normal-note"><span class="warn-text">'. qText('Unknown') .'</span></div>';
        $snapshot['sqlSUP4J'] = _FPA_U;
    }

echo '</div>';


// MySQLi supported by MySQL?
echo '<div style="font-weight:bold;font-size:9px;text-transform:uppercase;width:24%;float:left;text-align:center;">'. sprintf(qText('MySQL Supports %s'), 'MySQLi').'<br />';

    if ( !@$database['dbHOSTSERV'] OR @$database['dbERROR'] != qText('No') ) {
        echo '<div class="normal-note"><span class="warn-text">'. qText('Unknown') .'</span></div>';
        $snapshot['sqlSUP4SQL-i'] = _FPA_U;

    } elseif ( version_compare( @$database['dbHOSTSERV'], '5.0.7', '>=' ) ) {
        echo '<div class="normal-note"><span class="ok">'. qText('Yes') .'</span></div>';

    } else {
        echo '<div class="normal-note"><span class="warn-text">'. qText('No') .'</span></div>';
        $snapshot['sqlSUP4SQL-i'] = qText('No');
    }

echo '</div>';


// J! connection to MySQL
echo '<div style="font-weight:bold;font-size:9px;text-transform:uppercase;width:24%;float:left;text-align:center;">MySQL Connection Type<br />';

    if ( $instance['configDBTYPE'] ) {

        if ( ( @$snapshot['sqlSUP4SQL-i'] == qText('No')
        OR @$snapshot['sqlSUP4SQL-i'] == _FPA_U )
        AND $instance['configDBTYPE'] == 'mysqli') {
            echo '<div class="normal-note"><span class="alert-text">'. $instance['configDBTYPE'] .'</span></div>';

        } else {
            echo '<div class="normal-note"><span class="ok">'. $instance['configDBTYPE'] .'</span></div>';
        }

    } else {
        echo '<div class="normal-note"><span class="warn-text">'. qText('Unknown') .'</span></div>';
    }

echo '</div>';


// MySQL default collation
echo '<div style="font-weight:bold;font-size:9px;text-transform:uppercase;width:24%;float:left;text-align:center;">' . qText('MySQL default collation') .'<br />';

    if ( @$database['dbHOSTDEFCHSET'] ) {
        echo '<div class="normal-note"><span class="ok">'. @$database['dbHOSTDEFCHSET'] .'</span></div>';

    } else {
        echo '<div class="normal-note"><span class="warn-text">'. qText('Unknown') .'</span></div>';
    }

echo '</div>';

echo '<br style="clear:both;" /><br />';

// Unsupported PHP version
echo '<div style="font-weight:bold;font-size:9px;text-transform:uppercase;width:24%;float:left;text-align:center;">'. sprintf(qText('%s version'), 'PHP') .'<br />';

    if ( version_compare( PHP_VERSION, '5', '<' ) ) {
        echo '<div class="normal-note"><span class="alert-text">'. PHP_VERSION .'</span></div>';

    } else {
        echo '<div class="normal-note"><span class="ok">'. PHP_VERSION .'</span></div>';
    }

echo '</div>';


// known buggy php releases (mainly for installation on 1.5)
echo '<div style="font-weight:bold;font-size:9px;text-transform:uppercase;width:24%;float:left;text-align:center;">'. qText('Known Buggy PHP') .'<br />';

    foreach ( $fpa['supportENV']['badPHP'] as $badKey => $badValue ) {
        if ( version_compare( PHP_VERSION, $badValue, '==' ) ) {
            $badANS = qText('Yes');
            continue;
        }

    }

    if ( @$badANS == qText('Yes') ) {
        $badClass = 'alert-text';
        $snapshot['buggyPHP'] = qText('No');

    } else {
        $badANS = qText('No');
        $badClass = 'ok';
        $snapshot['buggyPHP'] = qText('No');
    }

echo '<div class="normal-note"><span class="'. $badClass .'">'. $badANS .'</span></div>';

echo '</div>';


// MySQL Version
echo '<div style="font-weight:bold;font-size:9px;text-transform:uppercase;width:24%;float:left;text-align:center;">'. sprintf(qText('%s version'), 'MySQL') .'<br />';
echo '<div class="normal-note">';
    if ( @$database['dbHOSTSERV'] ) {
        echo @$database['dbHOSTSERV'];
    } else {
        echo qText('Unknown');
    }
echo '</div>';
echo '</div>';


// known buggy zend releases (mainly for installation on 1.5)
echo '<div style="font-weight:bold;font-size:9px;text-transform:uppercase;width:24%;float:left;text-align:center;">'. qText('Known Buggy Zend') .'<br />';

    foreach ( $fpa['supportENV']['badZND'] as $badKey => $badValue ) {

        if ( version_compare( $phpextensions['Zend Engine'], $badValue, '==' ) ) {
            $badANS = qText('Yes');
            continue;
        }

    }

    if ( @$badANS == qText('Yes') ) {
        $badClass = 'alert-text';
        $snapshot['buggyZEND'] = qText('Yes');

    } else {
        $badANS = qText('No');
        $badClass = 'ok';
        $snapshot['buggyZEND'] = qText('No');
    }

echo '<div class="normal-note"><span class="'. $badClass .'">'. $badANS .'</span></div>';

echo '</div>';


echo '</div>';
echo '<div style="clear:both;"><br /></div>';

echo '</div>';



//TEST
echo '<div style="text-align:center;"><a style="color:#4D8000!important;" href="'. _RES_FPALINK .'">'. _RES_FPALATEST .' '. _RES .'</a></div>';
echo '<div style="clear:both;"></div>';
echo '</div>';

showDev ( $snapshot );
?>






<!-- POST FORM -->
<div style="margin: 0px auto;text-align:left;text-shadow: 1px 1px 1px #FFF; width:740px; background-color:#FFF;border:1px solid #999966; color:#4D8000; font-size:10px; font-family:arial; padding:5px;-moz-box-shadow: 3px 3px 3px #C0C0C0;-webkit-box-shadow: 3px 3px 3px #C0C0C0;box-shadow: 3px 3px 3px #C0C0C0;border-radius:5px;-moz-border-radius:5px;-webkit-border-radius:5px;">
    <div id="headerDiv" class="">

        <?php
            // someone clicked the "Generate Post" button, so we want to keep the form open once the page refreshes
            if ( @$_POST['doIT'] == 1 ) {
                $displayMode = 'block';

            } else {
                $displayMode = 'none';
            }
        ?>

        <div id="titleText"><a id="myHeader" style="line-height:22px;text-decoration:none;color:#4D8000;" href="javascript:toggle2('myContent','myHeader');" ><span style="font-size:12px;color:#4D8000;"><span style="font-size:18px;color:#008000;">&Theta;</span> Show the <strong><?php echo _RES; ?></strong></span></a></div>

    </div>
    <div style="clear:both;"></div>
    <div id="contentDiv" style="">

        <div id="myContent" style="display: <?php echo $displayMode; ?>;">

            <div class="half-section-container" style="width:730px;">

                <div class="half-section-information-left" style="width:340px;padding-top:10px;padding-bottom:10px;border-color:#CCC;box-shadow: inset 3px 3px 3px #C0C0C0;-webkit-box-shadow: inset 3px 3px 3px #C0C0C0;background-color:transparent!important;">

                    <div class="normal-note" style="min-height:135px;">
                        <strong><?php echo qText('Instructions');  ?></strong>

                        <?php
                            echo '<ol style="margin-left:-15px;">';
                            echo '<li><span class="normal">'. qText('Enter your problem description <i>(optional)</i>') .'</span></li>';
                            echo '<li><span class="normal">'. qText('Enter any error messages you see <i>(optional)</i>') .'</span></li>';
                            echo '<li><span class="normal">'. qText('Enter any actions taken to resolve the issue <i>(optional)</i>') .'</span></li>';
                            echo '<li><span class="normal">'. qText('Select detail level options of output <i>(optional)</i>') .'</span><br /></li>';
                            echo '<li><span class="normal">'. sprintf(qText('Click the %s post button to build the post content'), '<span class="normal-note">'.qText('Generate').'</span>') .'</span><br /></li>';
                            echo '<li><span class="normal">'. sprintf(qText('Copy the contents of the %s box and paste it into a post'), '<span class="ok-hilite">&nbsp;'.qText('Post Detail').'&nbsp;</span>') .'</span></li>';
                            echo '</ol>';
                        ?>
                    </div>

                    <br />

                    <div class="normal-note" style="min-height:145px;padding-left:10px;">
                        <strong><?php echo qText('Optional Information'); ?></strong>
                        <br /><br />

                                <div style="text-align:right;padding:2px;">
                                    <div class="normal" style="text-align:left;width:120px;float:left;">
                                        <?php echo qText('Problem Description'); ?>:
                                    </div> <input class="normal-note" style="background-color: #FFFFCC;width:175px;font-size:9px;" type="text" name="probDSC" />
                                </div>
                                <div style="text-align:right;padding:2px;">
                                    <div class="normal" style="text-align:left;width:120px;float:left;">
                                        <?php echo qText('Log/Error Message'); ?>:
                                    </div> <input class="normal-note" style="background-color: #FFFFCC;width:175px;font-size:9px;" type="text" name="probMSG1" />
                                </div>

                                <?php
                                    if ( $phpenv['phpLASTERR'] ) {
                                        echo '<div style="text-align:right;padding:2px;"><div class="warn-text" style="text-align:left;width:120px;float:left;">'. qText('Last error') .':</div> <input class="normal-note" style="color: #800000;background-color: #FFFFCC;width:175px;font-size:9px;" type="text" value="'. $phpenv['phpLASTERR'] .'" name="probMSG2" /><br /><span class="normal" style="font-size:8px;">auto-completed from your php error log&nbsp;&nbsp;</span></div>';
                                    } else {
                                        echo '<div style="text-align:right;padding:2px;"><div class="normal" style="text-align:left;width:120px;float:left;">'
                                        . qText('Log/Error Message')
                                        . ':</div> <input class="normal-note" style="background-color: #FFFFCC;width:175px;font-size:9px;" type="text" name="probMSG2" /></div>';
                                    }
                                ?>

                                <div style="text-align:right;padding:2px;">
                                    <div class="normal" style="text-align:left;width:120px;float:left;">
                                    <?php if ( @$_POST['postFormat'] == '1' OR @$_POST['postFormat'] == '2' ) {
                                        echo qText('Actions To ReCreate Issue');
                                    } else {
                                        echo qText('Actions Taken To Resolve');
                                    } ?>:</div>
                                    <textarea class="normal-note" style="background-color: #FFFFCC;width:175px;font-size:9px;" name="probACT" cols="80" rows="5"></textarea>
                                </div>

                                <?php echo qText('Leave ALL fields blank/empty to simply post diagnostic information.'); ?>

                        </div>

                    </div>


                    <div class="half-section-information-right" style="width:340px;padding-top:10px;padding-bottom:10px;border-color:#CCC;box-shadow: inset 3px 3px 3px #C0C0C0;-webkit-box-shadow: inset 3px 3px 3px #C0C0C0;background-color:transparent!important;">

                        <div class="normal-note" style="min-height:135px;">
                        <!-- intended Post location -->
                        <?php

                        $selectColor_1 = '808080';
                        $selectColor_2 = '808080';
                        $selectColor_3 = '808080';

                        $selectpostFormat_1 = '';
                        $selectpostFormat_2 = '';
                        $selectpostFormat_3 = '';

                        if ( $postFormat == '1' AND defined( '_FPA_BRA' ) ) {  // JoomlaCode
                                $selectpostFormat_1 = 'checked="checked"';
                                $selectColor_1 = '4D8000';

                        } elseif ( $postFormat == '2' AND defined( '_FPA_BRA' ) ) {  // GitHUB
                                $selectpostFormat_2 = 'checked="checked"';
                                $selectColor_2 = '4D8000';

                        } elseif ( $postFormat == '3' AND !defined( '_FPA_BRA' ) ) {  // Forum
                                $selectpostFormat_3 = 'checked="checked"';
                                $selectColor_3 = '4D8000';

                        } else {
                                $selectpostFormat_3 = 'checked="checked"';
                                $selectColor_3 = '4D8000';
                        }
                        ?>

                        <div style="color:#4D8000;">
                        <span style="color:#4D8000;font-weight:bold;padding-right:20px;"><strong>Run-Time Options</strong></span>
                            <input style="font-size:9px;" type="radio" name="postFormat" value="3" <?php echo $selectpostFormat_3; ?> /><span style="color:#<?php echo $selectColor_3; ?>;padding-right:15px;">Forum</span>
                                <?php
                                    if ( defined( '_FPA_BRA' ) ) {
                                        echo '<input style="font-size:9px;" type="radio" name="postFormat" value="2" '. $selectpostFormat_2 .' /><span style="color:#'. $selectColor_2 .';padding-right:15px;">GitHUB</span>';
                                        echo '<input style="font-size:9px;" type="radio" name="postFormat" value="1" '. $selectpostFormat_1 .' /><span style="color:#'. $selectColor_1 .';padding-right:15px;">JoomlaCode</span>';
                                    }
                                ?>
                        </div>
                        <br />

                            <div style="float:left; width:170px;">

                                <?php
                                $selectshowElevated =( @$_POST['showElevated'] ) ? 'checked="checked"' : '';
                                $selectshowTables =( @$_POST['showTables'] ) ? 'checked="checked"' : '';
                                $selectshowComponents =( @$_POST['showComponents'] ) ? 'checked="checked"' : '';
                                $selectshowModules =( @$_POST['showModules'] ) ? 'checked="checked"' : '';
                                $selectshowPlugins =( @$_POST['showPlugins'] ) ? 'checked="checked"' : '';
                                $dis =( $instance['instanceFOUND'] != qText('Yes') ) ? 'disabled="disabled"' : '';
                                ?>

                                <strong>
                                    <?php echo qText('Optional Settings'); ?>
                                    <?php echo ($dis) ? ' ('.qText('Disabled').')' : ''; ?>
                                </strong>
                                <br />

                                <?php  // don't show these options if posting to JC or GitHUB
                                    if ( @$_POST['postFormat'] == '3' OR @$postFormat == '3' ) {
                                        echo '<input '. $dis .' style="font-size:9px;" type="checkbox" name="showElevated" value="1" '. $selectshowElevated .' /><span class="normal">'. qText('Show elevated folder permissions') .'</span><br />';
                                        echo '<input '. $dis .' style="font-size:9px;" type="checkbox" name="showTables" value="1" '. $selectshowTables .' /><span class="normal">'. qText('Show database table statistics') .'</span><br />';
                                    }
                                ?>

                                <input <?php echo $dis; ?> style="font-size:9px;" type="checkbox" name="showComponents" value="1" <?php echo $selectshowComponents ?> /><span class="normal"><?php echo qText('Show Components'); ?></span><br />
                                <input <?php echo $dis; ?> style="font-size:9px;" type="checkbox" name="showModules" value="1" <?php echo $selectshowModules ?> /><span class="normal"><?php echo qText('Show Modules'); ?></span><br />
                                <input <?php echo $dis; ?> style="font-size:9px;" type="checkbox" name="showPlugins" value="1" <?php echo $selectshowPlugins ?> /><span class="normal"><?php echo qText('Show Plugins'); ?></span><br />
                            </div>

                            <div style="float:right; width:150px;">
                            <?php
                            $selectshowProtected_1 = '';
                            $selectshowProtected_2 = '';
                            $selectshowProtected_3 = '';

                            if ( $showProtected >= 3 OR  @$_POST['showProtected'] >= 3 ) {
                                    $selectshowProtected_3 = 'checked="checked"';
                            } elseif ( $showProtected == 2 OR @$_POST['showProtected'] == 2 ) {
                                    $selectshowProtected_2 = 'checked="checked"';
                            } elseif ( $showProtected == 1 OR @$_POST['showProtected'] == 1 ) {
                                    $selectshowProtected_1 = 'checked="checked"';
                            } elseif ( $showProtected == 2 ) {
                                    $selectshowProtected_2 = 'checked="checked"';
                            } else {
                                    $selectshowProtected_2 = 'checked="checked"';
                            }

                            $selectPOPS =( @$_POST['increasePOPS'] ) ? 'checked="checked"' : '';
                            ?>

                                <strong><?php echo qText('Information Privacy'); ?></strong><br />
                                <input style="font-size:9px;" type="radio" name="showProtected" value="1" <?php echo $selectshowProtected_1; ?> />
                                <span class="ok"><?php echo qText('None'); ?></span><br />
                                <span style="line-height:8px;padding:0px;margin:0px;margin-left:15px;font-size:8px;"><?php echo qText('No elements are masked'); ?></span><br />
                                <input style="font-size:9px;" type="radio" name="showProtected" value="2" <?php echo $selectshowProtected_2; ?> />
                                <span class="warn-text"><?php echo qText('Partial') .' ('. qText('Default') .')'; ?></span><br />
                                <span style="line-height:8px;padding:0px;margin:0px;margin-left:15px;font-size:8px;"><?php echo qText('Some elements are masked'); ?></span><br />
                                <input style="font-size:9px;" type="radio" name="showProtected" value="3" <?php echo $selectshowProtected_3; ?> />
                                <span class="alert-text"><?php echo qText('Strict'); ?></span><br />
                                <span style="line-height:8px;padding:0px;margin:0px;margin-left:15px;font-size:8px;"><?php echo qText('All indentifiable elements are masked'); ?></span>
                            </div>

                            <div style="clear:both;"></div>
                        </div>

                        <br />

                        <div class="normal-note" style="min-height:145px;">
                        <div style="clear:both;"><br /></div>

                            <!-- Generate the diagnostic post output -->
                            <div style = "margin: 0px auto; width:90%;text-align:center;margin-top:10px;">
                                <input type="hidden" name="doIT" value="1" />

                                <input type="submit" class="ok-hilite"
                                style="box-shadow: 2px 2px 2px #C0C0C0;-moz-box-shadow: 2px 2px 2px #C0C0C0;-webkit-box-shadow: 2px 2px 2px #C0C0C0;text-transform:uppercase;cursor:pointer;cursor:hand;"
                                value="<?php echo qText('Click Here To Generate Post'); ?>" />

                                <div class="normal" style="text-shadow:none!important;margin-left:10px;float:left;width:95%;text-align:left;">
                                    <br />
                                    <span class="ok"><?php echo sprintf(qText('Click the %s post button to build the post content'), '<span class="normal-note">'.qText('Generate').'</span>'); ?></span>
                                </div>

                                <input type="reset" class="warn" style="font-size:8px;cursor:pointer;cursor:hand;" name="reset" value="reset" />

                            <div style="clear:both;"><br /></div>
                            </div>

                            <div style="clear:both;"></div>

                            <!-- // !TODO make this more robust across multiple server configs -->
                            <div class="normal" style="margin-left:15px;border-top:1px dotted #CCC;margin-top:30px;margin-right:15px;">
                                <input style="font-size:9px;" type="checkbox" name="increasePOPS" value="1" <?php echo $selectPOPS; ?> />
                                <?php echo sprintf(qText('PHP %1s or %2s errors ?'), '<span class="warn-text">"Out of Memory"</span>', '<span class="warn-text">"Execution Time-Out"</span>'); ?>
                                <br />
                                <span style="margin-left:15px;font-size:8px;"><?php echo qText('Temporarily increase PHP Memory and Execution Time'); ?></span>
                            </div>

                        </div>

                    </div>

                </div>

        <div style="clear:both;"></div>

<?php
if ( @$_POST['doIT'] == '1' ) {

    echo '<div class="normal-note" style="width:725px;text-align:center;margin: 0px auto;padding:2px;padding-top:5px;">';

    echo '<span class="ok" style="text-transform:uppercase;">'. _RES .' '. qText('Post Detail') .'</span><br />';


    /** LOAD UP THE SELECTED CONFIGURATION AND DIAGNOSTIC INFORMATION FOR THE POST ************
     ** this section loads up a text-box with BBCode for the forum, it will quote each section
     ** to make viewing easier and once used to the format, hopefully making it simpler to
     ** pinpoint related information quickly
     **
     ** the user then copies and pastes this output into forum post
     **
     ** many "if/then/else" statements have been placed in single lines for ease of management,
     ** this looks ugly and goes against coding practices but *shrug*, it's messy otherwise
     **
     ** NOTE IF MODIFYING: carriage returns and line breaks MUST be double-quoted, not single-
     ** quote, hence some of the weird quoting and formating
     *****************************************************************************************/
    echo '<textarea class="protected" style="width:700px;height:35px;font-size:9px;margin-top:5px;" type="text" rows="10" cols="100" name="postOUTPUT" id="postOUTPUT">';

    /** FORMAT THE OUT PUT FOR EACH POST OPTION (Forum, GitHUB, JoomlaCode) *******************
     ** BBCode for the Joomla! Forum
     ** GitHUB Markdown for GitHUB
     ** Plain Text for JoomlaCode
     *****************************************************************************************/
    // post the problem description, if any
    if ( defined( '_FPA_BRA' ) AND $_POST['postFormat'] == '1' ) { // JoomlaCode
/*
 * Joomlacode format
*/

if ( $_POST['probDSC'] ) {
    echo qText('Problem Description') .' ::  ';
    echo "\n";
    echo $_POST['probDSC'];
}

// post the problem message(1), if any
if ( $_POST['probMSG1'] ) {
    echo "\n\n";
    echo qText('Log/Error Message') .' ::  ';
    echo "\n";
    echo $_POST['probMSG1'];
}

if ( !@$_POST['probMSG1'] AND $_POST['probMSG2'] ) {
    echo "\n\n";
    echo qText('Log/Error Message') .' ::  ';
    echo "\n";
}

// post the problem message(2), if any (Remeber, this can be auto-generated from the PHP Error Log File)
if ( @$_POST['probMSG2'] ) {
    echo "\n";
    echo $_POST['probMSG2'];
}

// post the problem actions/re-creation details, if any
if ( @$_POST['probACT'] ) {
    echo "\n\n";
    echo qText('Actions To ReCreate Issue') .' ::  ';
    echo "\n";
    echo $_POST['probACT'];
    echo "\n\n";
}


echo "\n";
echo qText('Basic Environment') .' ::  ';
echo "\n";
echo qText('Joomla instance') .' ::  ';

if ( $instance['instanceFOUND'] == qText('Yes') ) {
    echo $instance['cmsPRODUCT'] .' '. $instance['cmsRELEASE'] .'.'. $instance['cmsDEVLEVEL']
    .'-'. $instance['cmsDEVSTATUS'] .' ('. $instance['cmsCODENAME'] .') '. $instance['cmsRELDATE'];
} else {
    echo qText('Not Found');
}

if ( @$instance['platformPRODUCT'] ) {
    echo "\n";
    echo qText('Platform instance') .' ::  ';
    echo $instance['platformPRODUCT'] .' '. $instance['platformRELEASE'] .'.'. $instance['platformDEVLEVEL']
    .'-'. $instance['platformDEVSTATUS'] .' ('. $instance['platformCODENAME'] .') '. $instance['platformRELDATE'];
}

echo "\n";

if ( $instance['instanceCONFIGURED'] == qText('Yes') ) {
    echo "\n";
    echo qText('Instance configured') .' ::  ';
    echo $instance['instanceCONFIGURED'] .' | ';

    if ( $instance['configWRITABLE'] == qText('Yes') ) {
        echo qText('Writable');
    } else {
        echo qText('Read-Only');
    }
    echo ' (' . $instance['configMODE'] .') | ';
    echo qText('Owner') .': '. $instance['configOWNER']['name']
    .' (uid: '. $instance['configOWNER']['uid'] .'/gid: '. $instance['configOWNER']['gid'] .')'
    .' | '. qText('Group') .': '. $instance['configGROUP']['name'] .' (gid: '. $instance['configGROUP']['gid'] .')'
    .' | **Valid For:** '. $instance['configVALIDFOR'];

    echo "\n";
    echo qText('Configuration options') .' ::  ';

    echo 'Offline: '. $instance['configOFFLINE']
    .' | SEF: '. $instance['configSEF']
    .' | SEF Suffix: '. $instance['configSEFSUFFIX']
    .' | SEF ReWrite: '. $instance['configSEFRWRITE']
    .' | GZip: '. $instance['configGZIP']
    .' | Cache: '. $instance['configCACHING']
    .' | FTP Layer: '. $instance['configFTP']
    .' | SSL: '. $instance['configSSL']
    .' | Error Reporting: '. $instance['configERRORREP']
    .' | Site Debug: '. $instance['configSITEDEBUG']
    .' | Language Debug: '. $instance['configLANGDEBUG']
    .' | Default Access: '. $instance['configACCESS']
    .' | Unicode Slugs: '. $instance['configUNICODE']
    .' | ';

    if ( $instance['configSITEHTWC'] == qText('Yes') ) {
        echo '.htaccess/web.config: '. $instance['configSITEHTWC'];
    }


    echo "\n";

    echo qText('Database Credentials Present') .':  '. $instance['configDBCREDOK'];
    echo "\n";
    if ( @$_POST['showComponents'] != '1' AND @$_POST['showModules'] != '1' AND @$_POST['showPlugins'] != '1' ) {
        echo "\n\n";
    }


    // IF Components Selected
    if ( @$_POST['showComponents'] == '1' ) {
        echo "\n";
        echo $component['ARRNAME'] .'  :: '. qText('SITE') .' ::  ';

        foreach ( $component['SITE'] as $key => $show ) {

            if ( $show != @$component['ARRNAME'] ) {
                echo $show['name'] .' ('. $show['version'] .') | ';
            } // endif !arrname

        }


        echo '  :: '. qText('ADMIN') .' ::  ';

        foreach ( $component['ADMIN'] as $key => $show ) {

            if ( $show != @$component['ARRNAME'] ) {
                echo $show['name'] .' ('. $show['version'] .') | ';
            } // endif !arrname

        }
        echo "\n";
    } // end components

    // IF Modules Selected
    if ( @$_POST['showModules'] == '1' ) {
        echo "\n";
        echo $module['ARRNAME'] .'  :: '. qText('SITE') .' ::  ';

        foreach ( $module['SITE'] as $key => $show ) {

            if ( $show != @$module['ARRNAME'] ) {
                echo $show['name'] .' ('. $show['version'] .') | ';
            } // endif !arrname

        }

        echo '  :: '. qText('ADMIN') .' ::  ';

        foreach ( $module['ADMIN'] as $key => $show ) {

            if ( $show != @$module['ARRNAME'] ) {
                echo $show['name'] .' ('. $show['version'] .') | ';
            } // endif !arrname

        }
        echo "\n";
    } // end modules

    // IF Plugins Selected
    if ( @$_POST['showPlugins'] == '1' ) {
        echo "\n";
        echo $plugin['ARRNAME'] .'  :: '. qText('SITE') .' ::  ';

        foreach ( $plugin['SITE'] as $key => $show ) {

            if ( $show != @$plugin['ARRNAME'] ) {
                echo $show['name'] .' ('. $show['version'] .') | ';
            } // endif !arrname

        }
    } // end plugins


    if ( @$_POST['showComponents'] == '1' OR @$_POST['showModules'] == '1' OR @$_POST['showPlugins'] == '1' ) {
        echo "\n\n";
    }


    echo "\n";
    echo qText('Host configuration') .' ::  OS: '. $system['sysPLATOS']
    .' | '. qText('OS version') .': '. $system['sysPLATREL']
    .' | '. sprintf(qText('Technology: %s'), $system['sysPLATTECH'])
    .' | '. sprintf(qText('Web Server: %s'), $system['sysSERVSIG'])
    .' | '. sprintf(qText('Encoding: %s'), $system['sysENCODING'])
    .' | '. qText('Document Root') .': '. $system['sysDOCROOT']
    .' | '. sprintf(qText('System TMP writable: %s'), $system['sysTMPDIRWRITABLE']);
    echo "\n";

    echo "\n";
    echo qText('MySQL configuration') .' ::  ';
    if ( $database['dbDOCHECKS'] == qText('No') ) {
        echo '**'. qText('Database credentials incomplete or not available') .'** '. qText('Nothing to display.');
    }

    if ( @$instance['configDBCREDOK'] != qText('Yes') AND $instance['instanceFOUND'] == qText('Yes') ) {
        echo "\n";
        echo qText('Missing credentials detected') .':  ';

        if ( $instance['configDBTYPE'] == '' ) {
            echo ' * Connection Type missing * ';
        }
        if ( $instance['configDBHOST'] == '' ) {
            echo ' * MySQL Host missing * ';
        }
        if ( @$instance['configDBPREF'] == '' ) {
            echo ' * Table Prefix missing * ';
        }
        if ( @$instance['configDBUSER'] == '' ) {
            echo ' * Database Username missing * ';
        }
        if ( @$instance['configDBPASS'] == '' ) {
            echo ' * Database Password missing * ';
        }
    }

    if ( @$database['dbERROR'] != qText('No') ) {
        echo "\n";
        echo '**'. qText('Connection Error') .':** '. @$database['dbERROR'];
    } else {
        echo qText('Version') .': '. $database['dbHOSTSERV'] .' (Client:'. $database['dbHOSTCLIENT'] .')'
        . ' | '. qText('Collation') .': '. $database['dbCOLLATION'] .' ('. qText('Character Set') .': '. $database['dbCHARSET'] .')'
        . ' | '. qText('Database size') .': '. $database['dbSIZE']
        . ' | # ' . qText('Table') .' : '. $database['dbTABLECOUNT'];
    }

    echo "\n";

    echo "\n";
    echo qText('PHP configuration') .' ::  '. qText('Version') .': '. $phpenv['phpVERSION']
    .' | PHP API: '. $phpenv['phpAPI']
    .' | Session Path '. qText('Writeable') .': '. $phpenv['phpSESSIONPATHWRITABLE']
    .' | Display Errors: '. $phpenv['phpERRORDISPLAY']
    .' | Error Reporting: '. $phpenv['phpERRORREPORT']
    .' | Log Errors To: '. $phpenv['phpERRLOGFILE']
    .' | '. sprintf(qText('Last known errors: %s'), $phpenv['phpLASTERRDATE'])
    .' | Register Globals: '. $phpenv['phpREGGLOBAL']
    .' | Magic Quotes: '. $phpenv['phpMAGICQUOTES']
    .' | Safe Mode: '. $phpenv['phpSAFEMODE']
    .' | Open Base: '. $phpenv['phpOPENBASE']
    .' | Uploads: '. $phpenv['phpUPLOADS']
    .' | Max. Upload Size: '. $phpenv['phpMAXUPSIZE']
    .' | Max. POST Size: '. $phpenv['phpMAXPOSTSIZE']
    .' | Max. Input Time: '. $phpenv['phpMAXINPUTTIME']
    .' | Max. Execution Time: '. $phpenv['phpMAXEXECTIME']
    .' | Memory Limit: '. $phpenv['phpMEMLIMIT'];

    // PHP modules
    echo "\n";
    echo 'PHP Modules ::  ';

    $requirements = array('libxml', 'xml', 'zip', 'openssl', 'zlib', 'curl', 'iconv'
    , 'mbstring', 'mysql', 'mysqli', 'mcrypt', 'suhosin', 'cgi', 'cgi-fcgi'
    );

    foreach ( $phpextensions as $key => $show ) {
        if ( $show != $phpextensions['ARRNAME'] ) {
            // find the requirements and mark them as present or missing
            if(in_array($key, $requirements)) {
                echo '*'. $key .' ('. $show .') | ';
            } elseif ( $key == 'apache2handler' ) {
                echo '*'. $key .'* ('. $show .') | ';
            } else {
                echo $key .' ('. $show .') | ';
            }
        } // endif !arrname

    }
    echo "\n";


    // IF APACHE with PHP in Module mode
    if ( $phpenv['phpAPI'] == 'apache2handler' ) {
        echo "\n";
        echo 'Apache Modules ::  ';

        foreach ( $apachemodules as $key => $show ) {

            if ( $show != $apachemodules['ARRNAME'] ) {
                // find the requirements and mark them as present or missing
                if ( $show == 'mod_rewrite' OR $show == 'mod_cgi' OR $show == 'mod_cgid' OR $show == 'mod_expires' OR $show == 'mod_deflate' OR $show == 'mod_auth'  ) {
                    echo '*'. $show .' | ';
                } elseif ( $show == 'mod_php4' ) {
                    echo '*'. $show .'* | ';
                } else {
                    echo $show .' | ';
                }

            } // endif !arrname

        }
        echo "\n";
    }


} else {
    echo "\n";
    echo qText('Instance configured') .' ::  ';
    echo $instance['instanceCONFIGURED'];
}


// show a BRA version footer
echo "\n";
echo "\n";
echo _RES .' (v'. _RES_VERSION .') : '. @date( 'jS F Y' );
if ( $_POST['probDSC'] ) {
    echo '####  '. qText('Problem Description') .' ::  ';
    echo "\n";
    echo "\n";
    echo '> <sub>'. $_POST['probDSC'] .'</sub>';
    echo "\n";
    echo "\n";
}

if ( $_POST['probMSG1'] ) {
    echo "\n";
    echo '#### '. qText('Log/Error Message') .' ::&nbsp;&nbsp;';
    echo "\n";
    echo "\n";
    echo '> <sub>'. $_POST['probMSG1'] .'</sub>';
    echo "\n";
}

if ( !@$_POST['probMSG1'] AND $_POST['probMSG2'] ) {
    echo "\n";
    echo '#### '. qText('Log/Error Message') .' ::&nbsp;&nbsp;';
    echo "\n";
    echo "\n";
}

if ( @$_POST['probMSG2'] ) {
    echo '> <sub>'. $_POST['probMSG2'] .'</sub>';
    echo "\n";
    echo "\n";
}

if ( @$_POST['probACT'] ) {
    echo "\n";
    echo '#### '. qText('Actions To ReCreate Issue') .' ::  ';
    echo "\n";
    echo '> <sub>'. $_POST['probACT'] .'</sub>';
    echo "\n";
    echo "\n";
}


echo "\n";
echo '#### '. qText('Basic Environment') .' ::  ';
echo "\n";
echo '> <sub>**'. qText('Joomla! instance') .' ::** ';

if ( $instance['instanceFOUND'] == qText('Yes') ) {
    echo $instance['cmsPRODUCT'] .' **'. $instance['cmsRELEASE'] .'.'. $instance['cmsDEVLEVEL']
    .'-'. $instance['cmsDEVSTATUS'] .'** ('. $instance['cmsCODENAME'] .') '. $instance['cmsRELDATE'] .'</sub>';
} else {
    echo qText('Not Found') .'</sub>';
}

if ( @$instance['platformPRODUCT'] ) {
    echo "\n";
    echo '> <sub>**'. qText('Platform instance') .' ::** ';
    echo $instance['platformPRODUCT'] .' **'. $instance['platformRELEASE'] .'.'. $instance['platformDEVLEVEL']
    .'-'. $instance['platformDEVSTATUS'] .'** ('. $instance['platformCODENAME'] .') '. $instance['platformRELDATE'] .'</sub>';
}

echo "\n";

if ( $instance['instanceCONFIGURED'] == qText('Yes') ) {
    echo "\n";
    echo '> <sub>**'. qText('Instance configuration') .' ::** ';
    echo '**'. $instance['instanceCONFIGURED'] .'** | ';

    if ( $instance['configWRITABLE'] == qText('Yes') ) {
        echo qText('Writable');
    } else {
        echo qText('Read-Only');
    }

    echo ' (' . $instance['configMODE'] .') | ';
    echo '**'. qText('Owner') .':** '. $instance['configOWNER']['name']
    .' (uid: '. $instance['configOWNER']['uid'] .'/gid: '. $instance['configOWNER']['gid'] .')'
    .' | **'. qText('Group') .':** '. $instance['configGROUP']['name'] .' (gid: '. $instance['configGROUP']['gid'] .')'
    .' | **Valid For:** '. $instance['configVALIDFOR'] .'</sub>';

    echo "\n";
    echo '> <sub>**'. qText('Configuration options') .' ::** ';
    echo '**Offline:** '. $instance['configOFFLINE']
    .' | **SEF:** '. $instance['configSEF']
    .' | **SEF Suffix:** '. $instance['configSEFSUFFIX']
    .' | **SEF ReWrite:** '. $instance['configSEFRWRITE']
    .' | **GZip:** '. $instance['configGZIP']
    .' | **Cache:** '. $instance['configCACHING']
    .' | **FTP Layer:** '. $instance['configFTP']
    .' | **SSL:** '. $instance['configSSL']
    .' | **Error Reporting:** '. $instance['configERRORREP']
    .' | **Site Debug:** '. $instance['configSITEDEBUG']
    .' | **Language Debug:** '. $instance['configLANGDEBUG']
    .' | **Default Access:** '. $instance['configACCESS']
    .' | **Unicode Slugs:** '. $instance['configUNICODE']
    .' | ';
    if ( $instance['configSITEHTWC'] == qText('Yes') ) {
        echo '**.htaccess/web.config:** '. $instance['configSITEHTWC'];
    }
    echo '</sub>';

    echo "\n";

    echo '> <sub>**'. qText('Database Credentials Present') .':** ';
    echo $instance['configDBCREDOK'] .'</sub>';
    echo "\n";
    if ( @$_POST['showComponents'] != '1' AND @$_POST['showModules'] != '1' AND @$_POST['showPlugins'] != '1' ) {
        echo '***';
    }


    // IF Components Selected
    if ( @$_POST['showComponents'] == '1' ) {
        echo "\n";
        echo '> <sub>**'. $component['ARRNAME'] .' ::** **'. qText('SITE') .' ::** ';

        foreach ( $component['SITE'] as $key => $show ) {

            if ( $show != @$component['ARRNAME'] ) {
                echo $show['name'] .' ('. $show['version'] .') | ';
            } // endif !arrname

        }


        echo ' **:: '. qText('ADMIN') .' ::** ';

        foreach ( $component['ADMIN'] as $key => $show ) {

            if ( $show != @$component['ARRNAME'] ) {
                echo $show['name'] .' ('. $show['version'] .') | ';
            } // endif !arrname

        }
        echo '</sub>';
        echo "\n";
    } // end components

    // IF Modules Selected
    if ( @$_POST['showModules'] == '1' ) {
        echo "\n";
        echo '> <sub>**'. $module['ARRNAME'] .' ::** **'. qText('SITE') .' ::** ';

        foreach ( $module['SITE'] as $key => $show ) {

            if ( $show != @$module['ARRNAME'] ) {
                echo $show['name'] .' ('. $show['version'] .') | ';
            } // endif !arrname

        }

        echo ' **:: '. qText('ADMIN') .' ::** ';

        foreach ( $module['ADMIN'] as $key => $show ) {

            if ( $show != @$module['ARRNAME'] ) {
                echo $show['name'] .' ('. $show['version'] .') | ';
            } // endif !arrname

        }
        echo '</sub>';
        echo "\n";
    } // end modules

    // IF Plugins Selected
    if ( @$_POST['showPlugins'] == '1' ) {
        echo "\n";
        echo '> <sub>**'. $plugin['ARRNAME'] .' ::** **'. qText('SITE') .' ::** ';

        foreach ( $plugin['SITE'] as $key => $show ) {

            if ( $show != @$plugin['ARRNAME'] ) {
                echo $show['name'] .' ('. $show['version'] .') | ';
            } // endif !arrname

        }
        echo '</sub>';
    } // end plugins


    if ( @$_POST['showComponents'] == '1' OR @$_POST['showModules'] == '1' OR @$_POST['showPlugins'] == '1' ) {
        echo "\n";
        echo '***';
    }


    echo "\n";
    echo '> <sub>**'. qText('Host configuration') .' ::** **OS:** '. $system['sysPLATOS']
    .' | **'. qText('OS version') .':** '. $system['sysPLATREL']
    .' | **'. qText('Technology') .':** '. $system['sysPLATTECH']
    .' | **'. qText('Web Server') .':** '. $system['sysSERVSIG']
    . ' | ' . sprintf(qText('**%1s**: %2s'), qText('Encoding'), $system['sysENCODING'])
    //                                 .' | **Encoding:** '. $system['sysENCODING']
    .' | **'. qText('Document Root') .':** '. $system['sysDOCROOT']
    //                                 .' | **'. _FPA_SYS .' TMP '. qText('Writable') .':** '. $system['sysTMPDIRWRITABLE'];
    . ' | ' . sprintf(qText('**%1s**: %2s'), qText('System TMP writable'), $system['sysTMPDIRWRITABLE']);
    echo "\n";
    echo '***';

    echo "\n";
    echo '> <sub>**'. qText('MySQL configuration') .' ::** ';
    if ( $database['dbDOCHECKS'] == qText('No') ) {
        echo '**'. qText('Database credentials incomplete or not available') .'** '. qText('Nothing to display.') .'</sub>';
    }

    if ( @$instance['configDBCREDOK'] != qText('Yes')
    AND $instance['instanceFOUND'] == qText('Yes') ) {
        echo "\n";
        echo '> <sub>**'. qText('Missing credentials detected') .':** ';

        if ( $instance['configDBTYPE'] == '' ) {
            echo '**Connection Type** missing | ';
        }
        if ( $instance['configDBHOST'] == '' ) {
            echo '**MySQL Host** missing | ';
        }
        if ( @$instance['configDBPREF'] == '' ) {
            echo '**Table Prefix** missing | ';
        }
        if ( @$instance['configDBUSER'] == '' ) {
            echo '**Database Username** missing | ';
        }
        if ( @$instance['configDBPASS'] == '' ) {
            echo '**Database Password** missing';
        }
        echo '</sub>';
    }

    if ( @$database['dbERROR'] != qText('No') ) {
        echo "\n";
        echo '> **'. qText('Connection Error') .':** '. @$database['dbERROR'] .'</sub>';
    } else {
        echo '**'. qText('Version') .':** '. $database['dbHOSTSERV']
        .' (Client:'. $database['dbHOSTCLIENT'] .')'
        . ' | **' . qText('Collation') .':** '. $database['dbCOLLATION']
        . ' (**' . qText('Character Set') .':** '. $database['dbCHARSET'] .')'
        . ' | **' .  qText('Database size') .':** '. $database['dbSIZE']
        . ' | **# ' . qText('Table') . ':** '. $database['dbTABLECOUNT'] .'</sub>';
    }

    echo "\n";
    echo '***';

    echo "\n";
    echo '> <sub>**'. qText('PHP configuration') .' ::** **'. qText('Version') .':** '. $phpenv['phpVERSION']
    .' | **PHP API:** '. $phpenv['phpAPI']
    .' | **Session Path '. qText('Writable') .':** '. $phpenv['phpSESSIONPATHWRITABLE']
    .' | **Display Errors:** '. $phpenv['phpERRORDISPLAY']
    .' | **Error Reporting:** '. $phpenv['phpERRORREPORT']
    .' | **Log Errors To:** '. $phpenv['phpERRLOGFILE']
    .' | **'. qText('Last known errors') .':** '. $phpenv['phpLASTERRDATE']
    .' | **Register Globals:** '. $phpenv['phpREGGLOBAL']
    .' | **Magic Quotes:** '. $phpenv['phpMAGICQUOTES']
    .' | **Safe Mode:** '. $phpenv['phpSAFEMODE']
    .' | **Open Base:** '. $phpenv['phpOPENBASE']
    .' | **Uploads:** '. $phpenv['phpUPLOADS']
    .' | **Max. Upload Size:** '. $phpenv['phpMAXUPSIZE']
    .' | **Max. POST Size:** '. $phpenv['phpMAXPOSTSIZE']
    .' | **Max. Input Time:** '. $phpenv['phpMAXINPUTTIME']
    .' | **Max. Execution Time:** '. $phpenv['phpMAXEXECTIME']
    .' | **Memory Limit:** '. $phpenv['phpMEMLIMIT'] .'</sub>';

    // PHP modules
    echo "\n";
    echo '> <sub>**PHP Modules ::** ';

    $requirements = array('libxml', 'xml', 'zip', 'openssl', 'zlib', 'curl', 'iconv'
    , 'mbstring', 'mysql', 'mysqli', 'mcrypt', 'suhosin', 'cgi', 'cgi-fcgi'
    );

    foreach ( $phpextensions as $key => $show ) {

        if ( $show != $phpextensions['ARRNAME'] ) {
            if(in_array($key, $requirements)) {
                // find the requirements and mark them as present or missing
                echo '**'. $key .'** ('. $show .') | ';
            } elseif ( $key == 'apache2handler' ) {
                echo '***'. $key .'*** ('. $show .') | ';
            } else {
                echo $key .' ('. $show .') | ';
            }
        } // endif !arrname

    }
    echo '</sub>';
    echo "\n";
    echo '***';

    // IF APACHE with PHP in Module mode
    if ( $phpenv['phpAPI'] == 'apache2handler' ) {
        echo "\n";
        echo '> <sub>**Apache Modules ::** ';

        foreach ( $apachemodules as $key => $show ) {

            if ( $show != $apachemodules['ARRNAME'] ) {
                // find the requirements and mark them as present or missing
                if ( $show == 'mod_rewrite' OR $show == 'mod_cgi' OR $show == 'mod_cgid' OR $show == 'mod_expires' OR $show == 'mod_deflate' OR $show == 'mod_auth'  ) {
                    echo '**'. $show .'** | ';
                } elseif ( $show == 'mod_php4' ) {
                    echo '***'. $show .'*** | ';
                } else {
                    echo $show .' | ';
                }

            } // endif !arrname

        }
        echo '</sub>';
        echo "\n";
        echo '***';
    }


} else {
    echo "\n";
    echo '> <sub>**'. qText('Instance configuration') .' ::** ';
    echo $instance['instanceCONFIGURED'] .'</sub>';
}


// show a BRA version footer
echo "\n";
echo "\n";
echo '#####  '. _RES .' (v'. _RES_VERSION .') : '. @date( 'jS F Y' );

                } elseif ( defined( '_FPA_BRA' ) AND $_POST['postFormat'] == '2' ) { // GitHUB
/*
 * GitHub format
*/
if ( $_POST['probDSC'] ) {
    echo '####  '. qText('Problem Description') .' ::  ';
    echo "\n";
    echo "\n";
    echo '> <sub>'. $_POST['probDSC'] .'</sub>';
    echo "\n";
    echo "\n";
}

if ( $_POST['probMSG1'] ) {
    echo "\n";
    echo '#### '. qText('Log/Error Message') .' ::&nbsp;&nbsp;';
    echo "\n";
    echo "\n";
    echo '> <sub>'. $_POST['probMSG1'] .'</sub>';
    echo "\n";
}

if ( !@$_POST['probMSG1'] AND $_POST['probMSG2'] ) {
    echo "\n";
    echo '#### '. qText('Log/Error Message') .' ::&nbsp;&nbsp;';
    echo "\n";
    echo "\n";
}

if ( @$_POST['probMSG2'] ) {
    echo '> <sub>'. $_POST['probMSG2'] .'</sub>';
    echo "\n";
    echo "\n";
}

if ( @$_POST['probACT'] ) {
    echo "\n";
    echo '#### '. qText('Actions To ReCreate Issue') .' ::  ';
    echo "\n";
    echo '> <sub>'. $_POST['probACT'] .'</sub>';
    echo "\n";
    echo "\n";
}


echo "\n";
echo '#### '. qText('Basic Environment') .' ::  ';
echo "\n";
echo '> <sub>**'. qText('Joomla! instance') .' ::** ';

if ( $instance['instanceFOUND'] == qText('Yes') ) {
    echo $instance['cmsPRODUCT'] .' **'. $instance['cmsRELEASE'] .'.'. $instance['cmsDEVLEVEL']
    .'-'. $instance['cmsDEVSTATUS'] .'** ('. $instance['cmsCODENAME'] .') '. $instance['cmsRELDATE'] .'</sub>';
} else {
    echo qText('Not Found') .'</sub>';
}

if ( @$instance['platformPRODUCT'] ) {
    echo "\n";
    echo '> <sub>**'. qText('Platform instance') .' ::** ';
    echo $instance['platformPRODUCT'] .' **'. $instance['platformRELEASE'] .'.'. $instance['platformDEVLEVEL']
    .'-'. $instance['platformDEVSTATUS'] .'** ('. $instance['platformCODENAME'] .') '. $instance['platformRELDATE'] .'</sub>';
}

echo "\n";

if ( $instance['instanceCONFIGURED'] == qText('Yes') ) {
    echo "\n";
    echo '> <sub>**'. qText('Instance configuration') . ' ::** ';
    echo '**'. $instance['instanceCONFIGURED'] .'** | ';

    if ( $instance['configWRITABLE'] == qText('Yes') ) {
        echo qText('Writable');
    } else {
        echo qText('Read-Only');
    }

    echo ' (' . $instance['configMODE'] .') | ';
    echo '**'. qText('Owner') .':** '. $instance['configOWNER']['name']
    .' (uid: '. $instance['configOWNER']['uid'] .'/gid: '. $instance['configOWNER']['gid'] .')'
    .' | **'. qText('Group') .':** '. $instance['configGROUP']['name'] .' (gid: '. $instance['configGROUP']['gid'] .')'
    .' | **Valid For:** '. $instance['configVALIDFOR'] .'</sub>';

    echo "\n";
    echo '> <sub>**'. qText('Configuration options') .' ::** ';
    echo '**Offline:** '. $instance['configOFFLINE']
    .' | **SEF:** '. $instance['configSEF']
    .' | **SEF Suffix:** '. $instance['configSEFSUFFIX']
    .' | **SEF ReWrite:** '. $instance['configSEFRWRITE']
    .' | **GZip:** '. $instance['configGZIP']
    .' | **Cache:** '. $instance['configCACHING']
    .' | **FTP Layer:** '. $instance['configFTP']
    .' | **SSL:** '. $instance['configSSL']
    .' | **Error Reporting:** '. $instance['configERRORREP']
    .' | **Site Debug:** '. $instance['configSITEDEBUG']
    .' | **Language Debug:** '. $instance['configLANGDEBUG']
    .' | **Default Access:** '. $instance['configACCESS']
    .' | **Unicode Slugs:** '. $instance['configUNICODE']
    .' | ';
    if ( $instance['configSITEHTWC'] == qText('Yes') ) {
        echo '**.htaccess/web.config:** '. $instance['configSITEHTWC'];
    }
    echo '</sub>';

    echo "\n";

    echo '> <sub>**'. qText('Database Credentials Present') .':** ';
    echo $instance['configDBCREDOK'] .'</sub>';
    echo "\n";
    if ( @$_POST['showComponents'] != '1' AND @$_POST['showModules'] != '1' AND @$_POST['showPlugins'] != '1' ) {
        echo '***';
    }


    // IF Components Selected
    if ( @$_POST['showComponents'] == '1' ) {
        echo "\n";
        echo '> <sub>**'. $component['ARRNAME'] .' ::** **'. qText('SITE') .' ::** ';

        foreach ( $component['SITE'] as $key => $show ) {

            if ( $show != @$component['ARRNAME'] ) {
                echo $show['name'] .' ('. $show['version'] .') | ';
            } // endif !arrname

        }


        echo ' **:: '. qText('ADMIN') .' ::** ';

        foreach ( $component['ADMIN'] as $key => $show ) {

            if ( $show != @$component['ARRNAME'] ) {
                echo $show['name'] .' ('. $show['version'] .') | ';
            } // endif !arrname

        }
        echo '</sub>';
        echo "\n";
    } // end components

    // IF Modules Selected
    if ( @$_POST['showModules'] == '1' ) {
        echo "\n";
        echo '> <sub>**'. $module['ARRNAME'] .' ::** **'. qText('SITE') .' ::** ';

        foreach ( $module['SITE'] as $key => $show ) {

            if ( $show != @$module['ARRNAME'] ) {
                echo $show['name'] .' ('. $show['version'] .') | ';
            } // endif !arrname

        }

        echo ' **:: '. qText('ADMIN') .' ::** ';

        foreach ( $module['ADMIN'] as $key => $show ) {

            if ( $show != @$module['ARRNAME'] ) {
                echo $show['name'] .' ('. $show['version'] .') | ';
            } // endif !arrname

        }
        echo '</sub>';
        echo "\n";
    } // end modules

    // IF Plugins Selected
    if ( @$_POST['showPlugins'] == '1' ) {
        echo "\n";
        echo '> <sub>**'. $plugin['ARRNAME'] .' ::** **'. qText('SITE') .' ::** ';

        foreach ( $plugin['SITE'] as $key => $show ) {

            if ( $show != @$plugin['ARRNAME'] ) {
                echo $show['name'] .' ('. $show['version'] .') | ';
            } // endif !arrname

        }
        echo '</sub>';
    } // end plugins


    if ( @$_POST['showComponents'] == '1' OR @$_POST['showModules'] == '1' OR @$_POST['showPlugins'] == '1' ) {
        echo "\n";
        echo '***';
    }


    echo "\n";
    echo '> <sub>**'. qText('Host configuration') .' ::** **OS:** '. $system['sysPLATOS']
    .' | **'. qText('OS Version') .':** '. $system['sysPLATREL']
    .' | **'. qText('Technology') .':** '. $system['sysPLATTECH']
    .' | **'. qText('Web Server') .':** '. $system['sysSERVSIG']
    . ' | ' . sprintf(qText('**%1s**: %2s'), qText('Encoding'), $system['sysENCODING'])
    .' | **'. qText('Document Root') .':** '. $system['sysDOCROOT']
    . ' | ' . sprintf(qText('**%1s**: %2s'), qText('System TMP writable'), $system['sysTMPDIRWRITABLE']);
    echo "\n";
    echo '***';

    echo "\n";
    echo '> <sub>**'. qText('MySQL configuration') .' ::** ';
    if ( $database['dbDOCHECKS'] == qText('No') ) {
        echo '**'. qText('Database credentials incomplete or not available') .'** '. qText('Nothing to display.') .'</sub>';
    }

    if ( @$instance['configDBCREDOK'] != qText('Yes')
    AND $instance['instanceFOUND'] == qText('Yes') ) {
        echo "\n";
        echo '> <sub>**'. qText('Missing credentials detected') .':** ';

        if ( $instance['configDBTYPE'] == '' ) {
            echo '**Connection Type** missing | ';
        }
        if ( $instance['configDBHOST'] == '' ) {
            echo '**MySQL Host** missing | ';
        }
        if ( @$instance['configDBPREF'] == '' ) {
            echo '**Table Prefix** missing | ';
        }
        if ( @$instance['configDBUSER'] == '' ) {
            echo '**Database Username** missing | ';
        }
        if ( @$instance['configDBPASS'] == '' ) {
            echo '**Database Password** missing';
        }
        echo '</sub>';
    }

    if ( @$database['dbERROR'] != qText('No') ) {
        echo "\n";
        echo '> **'. qText('Connection Error') .':** '. @$database['dbERROR'] .'</sub>';
    } else {
        echo '**'. qText('Version') .':** '. $database['dbHOSTSERV']
        .' (Client:'. $database['dbHOSTCLIENT'] .')'
        . ' | **' . qText('Collation') .':** '. $database['dbCOLLATION']
        . ' (**' . qText('Character Set') .':** '. $database['dbCHARSET'] .')'
        . ' | **' .  qText('Database size') .':** '. $database['dbSIZE']
        . ' | **# ' . qText('Table') . ':** '. $database['dbTABLECOUNT'] .'</sub>';
    }

    echo "\n";
    echo '***';

    echo "\n";
    echo '> <sub>**'. qText('PHP configuration') .' ::** **'. qText('Version') .':** '. $phpenv['phpVERSION']
    .' | **PHP API:** '. $phpenv['phpAPI']
    .' | **Session Path '. qText('Writable') .':** '. $phpenv['phpSESSIONPATHWRITABLE']
    .' | **Display Errors:** '. $phpenv['phpERRORDISPLAY']
    .' | **Error Reporting:** '. $phpenv['phpERRORREPORT']
    .' | **Log Errors To:** '. $phpenv['phpERRLOGFILE']
    .' | **'. qText('Last known errors') .':** '. $phpenv['phpLASTERRDATE']
    .' | **Register Globals:** '. $phpenv['phpREGGLOBAL']
    .' | **Magic Quotes:** '. $phpenv['phpMAGICQUOTES']
    .' | **Safe Mode:** '. $phpenv['phpSAFEMODE']
    .' | **Open Base:** '. $phpenv['phpOPENBASE']
    .' | **Uploads:** '. $phpenv['phpUPLOADS']
    .' | **Max. Upload Size:** '. $phpenv['phpMAXUPSIZE']
    .' | **Max. POST Size:** '. $phpenv['phpMAXPOSTSIZE']
    .' | **Max. Input Time:** '. $phpenv['phpMAXINPUTTIME']
    .' | **Max. Execution Time:** '. $phpenv['phpMAXEXECTIME']
    .' | **Memory Limit:** '. $phpenv['phpMEMLIMIT'] .'</sub>';

    // PHP modules
    echo "\n";
    echo '> <sub>**PHP Modules ::** ';

    $requirements = array('libxml', 'xml', 'zip', 'openssl', 'zlib', 'curl', 'iconv'
    , 'mbstring', 'mysql', 'mysqli', 'mcrypt', 'suhosin', 'cgi', 'cgi-fcgi'
    );

    foreach ( $phpextensions as $key => $show ) {

        if ( $show != $phpextensions['ARRNAME'] ) {
            if(in_array($key, $requirements)) {
                // find the requirements and mark them as present or missing
                echo '**'. $key .'** ('. $show .') | ';
            } elseif ( $key == 'apache2handler' ) {
                echo '***'. $key .'*** ('. $show .') | ';
            } else {
                echo $key .' ('. $show .') | ';
            }
        } // endif !arrname

    }
    echo '</sub>';
    echo "\n";
    echo '***';

    // IF APACHE with PHP in Module mode
    if ( $phpenv['phpAPI'] == 'apache2handler' ) {
        echo "\n";
        echo '> <sub>**Apache Modules ::** ';

        foreach ( $apachemodules as $key => $show ) {

            if ( $show != $apachemodules['ARRNAME'] ) {
                // find the requirements and mark them as present or missing
                if ( $show == 'mod_rewrite' OR $show == 'mod_cgi' OR $show == 'mod_cgid' OR $show == 'mod_expires' OR $show == 'mod_deflate' OR $show == 'mod_auth'  ) {
                    echo '**'. $show .'** | ';
                } elseif ( $show == 'mod_php4' ) {
                    echo '***'. $show .'*** | ';
                } else {
                    echo $show .' | ';
                }

            } // endif !arrname

        }
        echo '</sub>';
        echo "\n";
        echo '***';
    }

} else {
    echo "\n";
    echo '> <sub>**'. qText('Instance configuration') .' ::** ';
    echo $instance['instanceCONFIGURED'] .'</sub>';
}

// show a BRA version footer
echo "\n";
echo "\n";
echo '#####  '. _RES .' (v'. _RES_VERSION .') : '. @date( 'jS F Y' );

                } elseif ( $_POST['postFormat'] == '3' ) { // Forum
/*
 * Forum format
*/
if ( $_POST['probDSC'] ) {
    echo '[quote="'. qText('Problem Description') .' :: '. _RES .' (v'. _RES_VERSION .') : '. @date( 'jS F Y' ) .'"][size=85]'. $_POST['probDSC'] .' [/size][/quote]';
}

if ( $_POST['probMSG1'] ) {
    echo '[quote="'. qText('Log/Error Message') .' :: '. _RES .' (v'. _RES_VERSION .') : '. @date( 'jS F Y' ) .'"][size=85]'. $_POST['probMSG1'] .'[/size][/quote]';
}

if ( $phpenv['phpLASTERR'] AND $_POST['probMSG2'] ) {
    echo '[quote="'. qText('Last PHP error') .' :: '. _RES .' (v'. _RES_VERSION .') : '. @date( 'jS F Y' ) .'"][size=85][color=#800000]'. $_POST['probMSG2'] .'[/color][/size][/quote]';
} elseif ( ! $phpenv['phpLASTERROR'] AND $_POST['probMSG2'] ) {
    echo '[quote="'. qText('Log/Error Message') .' :: '. _RES .' (v'. _RES_VERSION .') : '. @date( 'jS F Y' ) .'"][size=85]'. $_POST['probMSG2'] .'[/size][/quote]';
}

if ( $_POST['probACT'] ) {
    echo '[quote="'. sprintf(qText('Actions Taken To Resolve by %s'), _RES .' (v'. _RES_VERSION .') '. @date( 'jS F Y' )) .'"][size=85]'. $_POST['probACT'] .'[/size][/quote]';
}

echo '[quote="'. _RES .' (v'. _RES_VERSION .') : '. @date( 'jS F Y' ) .'"]';

// do the basic information
echo '[quote="'. qText('Basic Environment') .' ::"][size=85]';

// Joomla! cms details
echo '[color=#000000][b]'. qText('Joomla! instance') . ' :: [/b][/color]';

if ( $instance['instanceFOUND'] == qText('Yes') ) {
    echo '[color=#0000F0]'. $instance['cmsPRODUCT'] .' [b]'. $instance['cmsRELEASE'] .'.'. $instance['cmsDEVLEVEL'] .'[/b]-'
    . $instance['cmsDEVSTATUS'] .' ('. $instance['cmsCODENAME'] .') '. $instance['cmsRELDATE'] .'[/color]';
} else { echo '[color=orange]'. qText('Not Found') .'[/color]';
}

// Joomla! platform details
if ( @$instance['platformPRODUCT'] ) {
    echo "\r\n";
    echo '[color=#000000][b]'. qText('Joomla! platform') .' :: [/b][/color]'
    .' [color=#0000F0]'. @$instance['platformPRODUCT'] .' [b]'. @$instance['platformRELEASE'] .'.'. @$instance['platformDEVLEVEL'] .'[/b]'
    .'-'. @$instance['platformDEVSTATUS'] .' ('. @$instance['platformCODENAME'] .') '. @$instance['platformRELDATE'] .'[/color]';
}

echo "\r\n";

echo '[color=#000000][b]'. qText('Joomla! configured') .' :: [/b][/color]';

if ( $instance['instanceCONFIGURED'] == qText('Yes') ) {
    echo '[color=#008000]'. qText('Yes') .'[/color] | ';

    if ( $instance['configWRITABLE'] == qText('Yes') ) {
        echo '[color=#008000]'. qText('Writable') .'[/color] (';
    } else {
        echo qText('Read-Only');
    }

    echo ' (';

    if ( substr( $instance['configMODE'],1 ,1 ) == '7' OR substr( $instance['configMODE'],2 ,1 ) >= '5' OR substr( $instance['configMODE'],3 ,1 ) >= '5' ) {
        echo '[color=#800000]';
    } else {
        echo '[color=#008000]';
    }
    echo $instance['configMODE'] .'[/color]) | ';
    echo '[b]'. qText('Owner') .':[/b] '. $instance['configOWNER']['name']
    . ' (uid: '. $instance['configOWNER']['uid'] .'/gid: '. $instance['configOWNER']['gid'] .')'
    . ' | [b]'. qText('Group') .':[/b] '. $instance['configGROUP']['name'] .' (gid: '. $instance['configGROUP']['gid'] .')'
    . ' | [b]Valid For:[/b] '. $instance['configVALIDFOR'];

    echo "\r\n";

    echo '[color=#000000][b]'. qText('Configuration options') .' :: [/b][/color] [b]Offline:[/b] '. $instance['configOFFLINE']
    . ' | [b]SEF:[/b] '. $instance['configSEF']
    . ' | [b]SEF Suffix:[/b] '. $instance['configSEFSUFFIX']
    . ' | [b]SEF ReWrite:[/b] '. $instance['configSEFRWRITE']
    . ' | ';
    echo '[b].htaccess/web.config:[/b] ';

    if ( $instance['configSITEHTWC'] == qText('No') AND $instance['configSEFRWRITE'] == '1' ) {
        echo '[color=orange]'. $instance['configSITEHTWC'] .' (ReWrite Enabled but no .htaccess?)[/color] | ';
    } elseif ( $instance['configSITEHTWC'] == qText('Yes') ) {
        echo '[color=#008000]'. $instance['configSITEHTWC'] .'[/color] | ';
    } elseif ( $instance['configSITEHTWC'] == qText('No') ) {
        echo '[color=orange]'. $instance['configSITEHTWC'] .'[/color] | ';
    }

    echo '[b]GZip:[/b] '. $instance['configGZIP']
    .' | [b]Cache:[/b] '. $instance['configCACHING']
    .' | [b]FTP Layer:[/b] '. $instance['configFTP']
    .' | [b]SSL:[/b] '. $instance['configSSL']
    .' | [b]Error Reporting:[/b] '. $instance['configERRORREP']
    .' | [b]Site Debug:[/b] '. $instance['configSITEDEBUG'] .' | ';

    if ( version_compare( $instance['cmsRELEASE'], '1.5', '>=' ) ) {
        echo '[b]Language Debug:[/b] '. $instance['configLANGDEBUG']
        .' | ';
    }

    if ( version_compare( $instance['cmsRELEASE'], '1.6', '>=' ) ) {
        echo '[b]Default Access:[/b] '. $instance['configACCESS']
        .' | [b]Unicode Slugs:[/b] '. $instance['configUNICODE']
        .' | ';
    }

    echo '[b]'. qText('Database Credentials Present') .':[/b] ';
    if ( $instance['configDBCREDOK'] == qText('Yes') ) {
        echo '[color=#008000]';
    } else {
        echo '[color=#800000]';
    }

    echo $instance['configDBCREDOK'] .'[/color]';

} else {
    echo '[color=orange]'. qText('Not Found') .'[/color]';
}

echo "\r\n\r\n";

$s = '';
$s .=(qText('Yes') == $system['sysTMPDIRWRITABLE'])
? '[color=#008000]'
: '[color=#800000]';
$s .= $system['sysTMPDIRWRITABLE'] .'[/color]';

echo '[color=#000000][b]'. qText('Host configuration') .' :: [/b][/color] [b]OS:[/b] '. $system['sysPLATOS']
. ' |  [b]'.qText('OS version').':[/b] '. $system['sysPLATREL']
. ' | [b]'. qText('Technology') .':[/b] '. $system['sysPLATTECH']
. ' | [b]'. qText('Web Server') .':[/b] '. $system['sysSERVSIG']
. ' | [b]'. qText('Encoding') . ':[/b] '. $system['sysENCODING']
. ' | [b]'. qText('Document Root') .':[/b] '. $system['sysDOCROOT']
. ' | ' . sprintf(qText('[b]%1s[/b]: %2s'), qText('System TMP writable'), $s);

echo "\r\n\r\n";

echo '[color=#000000][b]'. qText('PHP configuration') .' :: [/b][/color] [b]'. qText('Version') .':[/b] ';

if ( version_compare( $phpenv['phpVERSION'], '5.0.0', '<' ) ) {
    echo '[color=#800000]'. $phpenv['phpVERSION'] .'[/color] | ';
} else {
    echo '[b]'. $phpenv['phpVERSION'] .'[/b] | ';
}

echo '[b]PHP API:[/b] ';
if ( $phpenv['phpAPI'] == 'apache2handler' ) {
    echo '[color=orange]'. $phpenv['phpAPI'] .'[/color] | ';
} else {
    echo '[b]'. $phpenv['phpAPI'] .'[/b] | ';
}

echo '[b]Session Path '. qText('Writable') .':[/b] ';
if ( $phpenv['phpSESSIONPATHWRITABLE'] == qText('Yes') ) {
    echo '[color=#008000]'. $phpenv['phpSESSIONPATHWRITABLE'] .'[/color] | ';
} elseif ( $phpenv['phpSESSIONPATHWRITABLE'] == qText('No') ) {
    echo '[color=#800000]'. $phpenv['phpSESSIONPATHWRITABLE'] .'[/color] | ';
} else {
    echo '[color=orange]'. $phpenv['phpSESSIONPATHWRITABLE'] .'[/color] | ';
}

echo '[b]Display Errors:[/b] '. $phpenv['phpERRORDISPLAY']
.' | [b]Error Reporting:[/b] '. $phpenv['phpERRORREPORT']
.' | [b]Log Errors To:[/b] '. $phpenv['phpERRLOGFILE']
.' | [b]' . qText('Last known errors') . ':[/b] '. $phpenv['phpLASTERRDATE']
.' | [b]Register Globals:[/b] '. $phpenv['phpREGGLOBAL']
.' | [b]Magic Quotes:[/b] '. $phpenv['phpMAGICQUOTES']
.' | [b]Safe Mode:[/b] '. $phpenv['phpSAFEMODE']
.' | [b]Open Base:[/b] '. $phpenv['phpOPENBASE']
.' | [b]Uploads:[/b] '. $phpenv['phpUPLOADS']
.' | [b]Max. Upload Size:[/b] '. $phpenv['phpMAXUPSIZE']
.' | [b]Max. POST Size:[/b] '. $phpenv['phpMAXPOSTSIZE']
.' | [b]Max. Input Time:[/b] '. $phpenv['phpMAXINPUTTIME']
.' | [b]Max. Execution Time:[/b] '. $phpenv['phpMAXEXECTIME']
.' | [b]Memory Limit:[/b] '. $phpenv['phpMEMLIMIT'];

echo "\r\n\r\n";

echo '[color=#000000][b]'. qText('MySQL configuration') .' :: [/b][/color] ';
if ( $database['dbDOCHECKS'] == qText('No') ) {
    echo '[color=orange]'. qText('Database credentials incomplete or not available') .'[/color] '. qText('Nothing to display.');
    echo "\r\n";

    if ( @$instance['configDBCREDOK'] != qText('Yes') AND $instance['instanceFOUND'] == qText('Yes') ) {
        echo '[color=#800000][b]'. qText('Missing credentials detected') .': [/b][/color] ';

        if ( $instance['configDBTYPE'] == '' ) {
            echo '[color=orange][b]Connection Type[/b] missing[/color] | ';
        }
        if ( $instance['configDBHOST'] == '' ) {
            echo '[color=orange][b]MySQL Host[/b] missing[/color] | ';
        }
        if ( @$instance['configDBPREF'] == '' ) {
            echo '[color=orange][b]Table Prefix[/b] missing[/color] | ';
        }
        if ( @$instance['configDBUSER'] == '' ) {
            echo '[color=orange][b]Database Username[/b] missing[/color] | ';
        }
        if ( @$instance['configDBPASS'] == '' ) {
            echo '[color=orange][b]Database Password[/b] missing[/color] |';
        }

    }


} elseif ( @$database['dbERROR'] != qText('No') ) {
    echo '[b]'. qText('Connection Error') .':[/b] ';

    if ( $_POST['showProtected'] == '3' ) {
        echo '[color=orange][b]'. qText(Strict) .'[/b] '. qText('Information Privacy') .'[/color] - [color=#800000]'. qText('Error(s) reported') . '[/color].';
    } else {
        echo '[color=#800000]'. @$database['dbERROR'] .'[/color] : [color=orange]'. qText('Database credentials present in configuration ? ...') . '[/color]';
    }

} else {
    echo '[b]'. qText('Version') .':[/b] [b]'. $database['dbHOSTSERV'] .'[/b] (Client:'. $database['dbHOSTCLIENT'] .') | ';

    if ( $_POST['showProtected'] >= '1' ) {
        echo '[b]'. qText('Host') .':[/b]  [color=orange]--'. qText('Protected') .'--[/color] ([color=orange]--'. qText('Protected') .'--[/color]) | ';
    } else {
        echo '[b]'. qText('Host') .':[/b] '. $instance['configDBHOST'] .' ('. $database['dbHOSTINFO'] .') | ';
    }

    echo '[b]'. qText('Collation') .':[/b] '. $database['dbCOLLATION']
    . ' ([b]'. qText('Character Set') .':[/b] '. $database['dbCHARSET'] .')'
    . ' | [b]'. qText('Database size') .':[/b] '. $database['dbSIZE']
    . ' | [b]#'. qText('Table') .':[/b] '. $database['dbTABLECOUNT'];
}

echo '[/size][/quote]';

// do detailed information

echo '[quote="'. qText('Detailed Environment') .' ::"][size=85]';

echo '[color=#000000][b]'. qText('PHP Extensions') .' :: [/b][/color]';

$requirements = array('libxml', 'xml', 'zip', 'openssl', 'zlib', 'curl', 'iconv', 'mbstring'
, 'mysql', 'mysqli', 'mcrypt', 'suhosin', 'cgi', 'cgi-fcgi');

foreach ( $phpextensions as $key => $show ) {

    if ( $show != $phpextensions['ARRNAME'] ) {

        // find the requirements and mark them as present or missing
        if(in_array($key, $requirements)) {
            echo '[color=#008000][b]'. $key .'[/b][/color] ('. $show .') | ';
        } elseif ( $key == 'apache2handler' ) {
            echo '[color=orange]'. $key .'[/color] ('. $show .') | ';
        } else {
            echo $key .' ('. $show .') | ';
        }

    }

    if ( !in_array( $key, $phpreq ) ) {
        unset ( $phpreq[$key] );
    }

}

echo "\r\n";
echo '[color=#000000][b]'. qText('Potential Missing Extensions') .' :: [/b][/color]';
foreach ( $phpreq as $missingkey => $missing ) {
    echo '[color=orange]'. $missingkey .'[/color] | ';
}

echo "\r\n\r\n";
echo '[color=#000000][b]' . qText('Switch User Environment') .'[/b] [i]('.qText('Experimental').'[/i][b] :: [/b][/color]'
.' [b]PHP CGI:[/b] '. $phpenv['phpCGI']
.' | [b]Server SU:[/b] '. $phpenv['phpAPACHESUEXEC']
.' |  [b]PHP SU:[/b] '. $phpenv['phpPHPSUEXEC']
.' |   [b]Custom SU (Cloud/Grid):[/b] ' . $phpenv['phpCUSTOMSU'];

echo "\r\n";
echo '[b]'. qText('Potential Ownership Issues') .':[/b] ';

if ( $phpenv['phpOWNERPROB'] == qText('Yes') ) {
    echo '[color=#800000]';
} elseif ( $phpenv['phpOWNERPROB'] == qText('No') ) {
    echo '[color=#008000]';
} else {
    echo '[color=orange]';
}
echo $phpenv['phpOWNERPROB'] .'[/color] ';

// IF APACHE with PHP in Module mode
if ( $phpenv['phpAPI'] == 'apache2handler' ) {
    echo "\r\n\r\n";

    echo '[color=#000000][b]'. qText('Apache Modules') .' :: [/b][/color]';

    foreach ( $apachemodules as $key => $show ) {

        if ( $show != $apachemodules['ARRNAME'] ) {

            // find the requirements and mark them as present or missing
            if ( $show == 'mod_rewrite' OR $show == 'mod_cgi' OR $show == 'mod_cgid' OR $show == 'mod_expires' OR $show == 'mod_deflate' OR $show == 'mod_auth'  ) {
                echo '[color=#008000][b]'. $show .'[/b][/color] | ';
            } elseif ( $show == 'mod_php4' ) {
                echo '[color=#800000]'. $show .'[/color] | ';
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
    echo '[color=#000000][b]'. qText('Potential Missing Modules') .' :: [/b][/color]';
    foreach ( $apachereq as $missingkey => $missing ) {
        echo '[color=orange]'. $missingkey .'[/color] | ';
    }

    echo "\r\n";

} // end if Apache and PHP module



echo '[/size][/quote]';



if ( $instance['instanceFOUND'] == qText('Yes') ) {
    echo '[quote="Folder Permissions ::"][size=85]';

    echo '[color=#000000][b]'. qText('Core Folders') .' :: [/b][/color]';

    foreach ( $folders as $i => $show ) {

        if ( $show != $folders['ARRNAME'] ) {

            if ( $_POST['showProtected'] == '3' ) {
                echo '[color=orange]--'. qText('Protected') .'--[/color] (';
            } else {
                echo $show .' (';
            }

            if ( substr( $modecheck[$show]['mode'],1 ,1 ) == '7'
            OR substr( $modecheck[$show]['mode'],2 ,1 ) == '7' ) {
                echo '[color=#800000]'. $modecheck[$show]['mode'] .'[/color]) | ';
            } else {
                echo $modecheck[$show]['mode'] .') | ';
            }

        }

    }


    if ( @$_POST['showElevated'] == '1' ) {
        echo "\r\n\r\n";

        $limitCount = '0';
        echo '[color=#000000][b]'. qText('Elevated Permissions') .'[/b] [i]('. sprintf(qText('First %d'), 10) .')[/i][b] :: [/b] [/color]';

        foreach ( $elevated as $key => $show ) {

            if ( $limitCount >= '11' ) {
                unset ( $key );
            } else {

                if ( $show != $elevated['ARRNAME'] ) {

                    if ( $_POST['showProtected'] == '3' ) {
                        echo '[color=orange]--'. qText('Protected') .'--[/color] (';
                    } else {

                        if ( $key == 'None' ) {
                            echo '[color=#008000][b]'. $key .'[/b][/color] ';
                        } else {
                            echo $key .'/ (';

                        }

                    }

                    if ( $key != 'None' ) {

                        if ( substr( $show['mode'],1 ,1 ) == '7' OR substr( $show['mode'],2 ,1 ) == '7' ) {
                            echo '[color=#800000]'. $show['mode'] .'[/color]) | ';
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
if ( $database['dbDOCHECKS'] == qText('Yes') AND @$database['dbERROR'] == qText('No') AND @$_POST['showTables'] == '1' ) {
    echo '[quote="Database Information ::"][size=85]';

    echo '[color=#000000][b]'. qText('Database Statistics') .' :: [/b][/color]';

    foreach ( $database['dbHOSTSTATS'] as $show ) {
        $dbPieces = explode(": ", $show );
        echo '[b]'. $dbPieces[0] .':[/b] '. $dbPieces[1] .' | ';

    }

    /** REMOVED FROM POST OUTPUT ***************************************************
     ** TABLE STATISTICS removed from post output to reduce the post content,
     ** it occassionally pops the forum post character limits
     *******************************************************************************
     echo "\r\n\r\n";

     echo '[color=#000000][b]Table Statistics :: [/b][/color]';
     echo "\r\n";

     foreach ( $tables as $i => $show ) {

     if ( $show != $tables['ARRNAME'] ) {

     if ( $showProtected == '3' ) {
     echo '[color=orange]--'. qText('Protected') .'--[/color] ';
     echo "\r\n";

     } else {
     echo '[color=#000080]'. $show['TABLE'] .'[/color] ';
     echo "\r\n";
     }

     echo '[b]Size:[/b] '. $show['SIZE'] .' | [b]Records:[/b] '. $show['RECORDS'] .' | [b]Avg. Length:[/b] '. $show['AVGLEN'] .' | [b]Fragment Size[/b] (Overhead)[b]:[/b] '. $show['FRAGSIZE'] .' | [b]Engine:[/b] '. $show['ENGINE'] .' | [b]Collation:[/b] '. $show['COLLATION'];
     echo "\r\n";
     }

     }
     ***************************************************************************/

    echo '[/size][/quote]';

} elseif ( ( $database['dbDOCHECKS'] != qText('Yes') OR $database['dbERROR'] != qText('No') ) AND $_POST['showTables'] == '1' ) {

    // only show the tables if we can connect to the database
    //                                if ( $database['dbERROR'] == qText('No') ) {

    //                                }

}




// do the Extensions information
if ( $instance['instanceFOUND'] == qText('Yes') AND ( @$_POST['showComponents'] == '1' OR @$_POST['showModules'] == '1' OR @$_POST['showPlugins'] == '1' ) ) {
    echo '[quote="Extensions Discovered ::"][size=85]';

    if ( $_POST['showProtected'] == '3' ) {
        echo '[color=orange][b]Strict[/b] Information Privacy was selected.[/color] Nothing to display.';
        echo '[/size][/quote]';
    } else {


        if ( @$_POST['showComponents'] == '1' ) {
            echo '[color=#000000][b]'. qText('Components') .' :: '. qText('SITE') .' :: [/b][/color]';

            foreach ( $component['SITE'] as $key => $show ) {
                echo $show['name'] .' ('. $show['version'] .') | ';
            }

            echo "\r\n";

            echo '[color=#000000][b]'. qText('Components') .' :: '. qText('ADMIN') .' :: [/b][/color]';

            foreach ( $component['ADMIN'] as $key => $show ) {
                echo $show['name'] .' ('. $show['version'] .') | ';
            }

            echo "\r\n\r\n";
        }


        if ( @$_POST['showModules'] == '1' ) {
            echo '[color=#000000][b]'. qText('Modules') .' :: '. qText('SITE') .' :: [/b][/color]';

            foreach ( $module['SITE'] as $key => $show ) {
                echo $show['name'] .' ('. $show['version'] .') | ';
            }

            echo "\r\n";

            echo '[color=#000000][b]'. qText('Modules') .' :: '. qText('ADMIN') .' :: [/b][/color]';

            foreach ( $module['ADMIN'] as $key => $show ) {
                echo $show['name'] .' ('. $show['version'] .') | ';
            }

            echo "\r\n\r\n";
        }


        if ( @$_POST['showPlugins'] == '1' ) {
            echo '[color=#000000][b]'. qText('Plugins') .' :: '. qText('SITE') .' :: [/b][/color]';

            foreach ( $plugin['SITE'] as $key => $show ) {
                echo $show['name'] .' ('. $show['version'] .') | ';
            }

        }

        echo '[/size][/quote]';

    } // end if showComponents, Modules, Plugins, if cmsFOUND

} // end showProtected != strict


// do the template information
if ( $instance['instanceFOUND'] == qText('Yes') ) {
    echo '[quote="'. qText('Templates') .' Discovered ::"][size=85]';

    if ( $_POST['showProtected'] == '3' ) {
        echo '[color=orange][b]'. qText('Strict') .'[/b] '. qText('Information Privacy') .'[/color] '
        . qText('Nothing to display.');
        echo '[/size][/quote]';
    } else {

        echo '[color=#000000][b]'. qText('Templates') .' :: '. qText('SITE') .' :: [/b][/color]';

        foreach ( $template['SITE'] as $key => $show ) {
            echo $show['name'] .' ('. $show['version'] .') | ';
        }

        echo "\r\n";

        echo '[color=#000000][b]'. qText('Templates') .' :: '. qText('ADMIN') .' :: [/b][/color]';

        foreach ( $template['ADMIN'] as $key => $show ) {
            echo $show['name'] .' ('. $show['version'] .') | ';
        }

        echo '[/size][/quote]';

    } // end if InstanceFOUND

} // end showProtected != strict

/**
 echo '[quote="'. _RES .'"][size=85]';
 if ( $_POST['probDSC'] ) { echo '[b][u][color=black]Problem Description:[/color][/u][/b] &nbsp;'. $_POST['probDSC']; echo "\n\n"; }
 if ( $_POST['probMSG1'] ) { echo '[b][u][color=black]Error Message:[/color][/u][/b] &nbsp;'. $_POST['probMSG1']; echo "\n"; }
 if ( $_POST['probMSG2'] ) { echo '[b][u][color=black]Last Known PHP Error:[/color][/u][/b] &nbsp;'. $_POST['probMSG2']; echo "\n"; }
 if ( $_POST['probACT'] ) { echo "\n"; echo '[b][u][color=black]Actions Taken:[/color][/u][/b] &nbsp;'. $_POST['probACT']; }
 echo '[/size][/quote]';
 **/

echo '[/quote]';
    } // end forum post

    echo '</textarea>';

    echo '<div style="clear:both;"><br /></div>';
    echo '<span class="ok">'. sprintf(qText('Copy the contents of the %s box and paste it into a post'), '<span class="ok-hilite">&nbsp;'.qText('Post Detail').'&nbsp;</span>') .'</span>';
    echo '<div style="clear:both;"><br /></div>';
    echo '</div>';
}
?>

            </div>

        <div style="clear:both;"><br /></div>

        </div>
    </div>
<!-- POST FORM -->





<?php
    // build a full-width div to hold two 'half-width' section, side-by-side
    echo '<div class="half-section-container" style="z-index:1;">'; // start half-section container

        /** display the instance information *************************************************/
        echo '<div class="half-section-information-left">'; // start left content block

        echo '<div class="section-title" style="text-align:center;">' . sprintf(qText('%s discovery'), $instance['ARRNAME']) . '</div>';
        echo '<div class="" style="width:99%;margin: 0px auto;clear:both;margin-bottom:10px;">';
        // this is the column heading area, if any


        /** mini-content, shown in all cases *************************************************/
        echo '<div class="mini-content-container">';
        echo '<div class="mini-content-box">';
        echo '<div class="mini-content-title">'. qText('CMS found') .'</div>';

            if ( $instance['instanceFOUND'] == qText('Yes') ) {
                echo @$instance['cmsPRODUCT'] .'<br />';
                echo '<strong>'. @$instance['cmsRELEASE'] .'.'. @$instance['cmsDEVLEVEL'] .'</strong><br />';

                if ( strtolower( @$instance['cmsDEVSTATUS'] ) == 'stable' ) {
                    $statusClass = 'ok-hilite';
                } elseif ( strtolower( substr( @$instance['cmsDEVSTATUS'],0, 4 ) ) == 'alph' OR strtolower( substr( @$instance['cmsDEVSTATUS'],0, 4 ) ) == 'beta' ) {
                    $statusClass = 'alert';
                } elseif ( strtolower( substr( @$instance['cmsDEVSTATUS'],0, 2 ) ) == 'rc' ) {
                    $statusClass = 'warn';
                } else {
                    $statusClass = 'warn';
                }

                echo '<div class="'. $statusClass .'" style="margin: 0px auto;margin-top:1px;">'. @$instance['cmsDEVSTATUS'] .'</div>';
                //echo $instance['cmsCODENAME'];

            } else {
                echo '<div class="warn" style="margin: 0px auto;">'. @$instance['instanceFOUND'] .'</div>';
            }

        echo '</div>';
        echo '</div>';




        // caters for the platform separation
        echo '<div class="mini-content-container">';
        echo '<div class="mini-content-box">';
        echo '<div class="mini-content-title">'. qText('Platform') .'</div>';

        if ( $instance['platformVFILE'] != qText('No') ) {
            echo $instance['platformPRODUCT'] .'<br />';
            echo '<strong>'. $instance['platformRELEASE'] .'.'. @$instance['platformDEVLEVEL'] .'</strong><br />';


                if ( strtolower( $instance['platformDEVSTATUS'] ) == 'stable' ) {
                    $statusClass = 'ok-hilite';

                } elseif ( strtolower( substr( $instance['platformDEVSTATUS'],0, 4 ) ) == 'alph' OR strtolower( substr( $instance['platformDEVSTATUS'],0, 4 ) ) == 'beta' ) {
                    $statusClass = 'alert';

                } elseif ( strtolower( substr( $instance['platformDEVSTATUS'],0, 2 ) ) == 'rc' ) {
                    $statusClass = 'warn';

                }

                echo '<div class="'. $statusClass .'" style="margin: 0px auto;">'. $instance['platformDEVSTATUS'] .'</div>';

        } elseif ( $instance['platformVFILE'] == qText('No') AND $instance['cmsVFILE'] == qText('No')) {
            echo '<div class="warn" style="margin: 0px auto;">'. qText('No') .'</div>';

        } else {
            echo qText('N/A');
        }

        echo '</div>';
        echo '</div>';


        echo '<div class="mini-content-container">';
        echo '<div class="mini-content-box">';
        echo '<div class="mini-content-title">' . qText('Config exists') . '</div>';

            if ( $instance['instanceCONFIGURED'] == qText('No') ) {
                $configuredClass = 'warn';

            } else {
                $configuredClass = 'ok';

            }

        echo '<div class="'. $configuredClass .'" style="margin: 0px auto;">'. $instance['instanceCONFIGURED'] .'</div>';
        echo '</div>';
        echo '</div>';


        echo '<div class="mini-content-container">';
        echo '<div class="mini-content-box">';
        echo '<div class="mini-content-title">'. qText('Config version') .'</div>';

            if ( @$instance['instanceCFGVERMATCH'] == qText('Yes') ) {
                echo $instance['configVALIDFOR'];
                echo '<div class="ok" style="width:99%;margin: 0px auto;">'. qText('Matches CMS') .'</div>';

            } elseif ( @$instance['instanceCFGVERMATCH'] == qText('No') ) {
                echo $instance['configVALIDFOR'];
                echo '<div class="warn" style="width:99%;margin: 0px auto;">'. qText('CMS mis-match') .'</div>';

            } elseif ( @$instance['configVALIDFOR'] == _FPA_U ) {
                echo '<div class="warn" style="width:99%;margin: 0px auto;">'. $instance['configVALIDFOR'] .'</div>';

            }

        echo '</div>';
        echo '</div>';


        /** mini-content, only shown if instance found and configured ************************/
        if ( $instance['instanceCONFIGURED'] != qText('No') AND $instance['instanceFOUND'] != qText('No') ) {

            // force new line of mini-content-boxes
            echo '<div style="clear:both;"></div>';

            echo '<div class="mini-content-container">';
            echo '<div class="mini-content-box">';
            echo '<div class="mini-content-title">'. qText('Config valid') .'</div>';

                if ( @$instance['configSANE'] == qText('Yes') AND @$instance['configSIZEVALID'] != qText('No') ) {
                    $saneClass = 'ok';
                    $configVALID = qText('Yes');

                } else {
                    $saneClass = 'warn';
                    $configVALID = qText('No');

                }

            echo '<div class="'. $saneClass .'" style="width:50px;margin: 0px auto;">'. $configVALID .'</div>';
            echo '</div>';
            echo '</div>';


            echo '<div class="mini-content-container">';
            echo '<div class="mini-content-box">';
            echo '<div class="mini-content-title">'. qText('Config mode') .'</div>';

                // looking for --7 or -7- or -77 (default folder permissions are usually 755)
                if ( substr( $instance['configMODE'],0 ,1 ) == '7' OR substr( $instance['configMODE'],1 ,1 ) == '7' OR substr( $instance['configMODE'],2 ,1 ) == '7' ) {
                    $modeClass = 'alert';

                } elseif ( $instance['configMODE'] <= '644' ) {
                    $modeClass = 'ok';

                } elseif ( substr( $instance['configMODE'],1 ,1 ) >= '5' OR substr( $instance['configMODE'],2 ,1 ) >= '5' ) {
                    $modeClass = 'warn';

                } elseif ( $instance['configMODE'] == qText('No') ) {
                    $modeClass = 'warn-text';

                } else {
                    $modeClass = 'normal';

                }

            echo '<div class="'. $modeClass .'" style="width:50px;margin: 0px auto;">'. $instance['configMODE'] .'</div>';

                // is the file writable?
                if ( ( $instance['configWRITABLE'] == qText('Yes') ) AND ( substr( $instance['configMODE'],0 ,1 ) == '7' OR substr( $instance['configMODE'],1 ,1 ) == '7' OR substr( $instance['configMODE'],2 ,1 ) == '7' ) ) {
                    $writeClass = 'alert';
                    $canWrite = 'Writable';

                } elseif ( ( $instance['configWRITABLE'] == qText('Yes') ) AND ( substr( $instance['configMODE'],0 ,1 ) <= '6' ) ) {
                    $writeClass = 'ok';
                    $canWrite = qText('Writable');

                } elseif ( ( $instance['configWRITABLE'] != qText('Yes') ) ) {
                    $writeClass = 'warn';
                    $canWrite = qText('Read-Only');

                }

            echo '<div class="'. $writeClass .'" style="width:50px;margin: 0px auto;margin-top:1px;">'. $canWrite .'</div>';
            echo '</div>';
            echo '</div>';


            echo '<div class="mini-content-container">';
            echo '<div class="mini-content-box">';
            echo '<div class="mini-content-title">'. qText('Config Owner') .'</div>';

                if ( $showProtected <= 2 ) {
                    echo $instance['configOWNER']['name'];

                } else {
                    echo '<span class="protected">[&nbsp;--&nbsp;'. qText('Protected') .'&nbsp;--&nbsp;]</span>&nbsp;';

                }

            echo '</div>';
            echo '</div>';

            echo '<div class="mini-content-container">';
            echo '<div class="mini-content-box">';
            echo '<div class="mini-content-title">'. qText('Config Group') .'</div>';

                if ( $showProtected <= 2 ) {
                    echo $instance['configGROUP']['name'];

                } else {
                    echo '<span class="protected">[&nbsp;--&nbsp;'. qText('Protected') .'&nbsp;--&nbsp;]</span>&nbsp;';

                }

            echo '</div>';
            echo '</div>';

        } // end if no instance or configuration found dont display

        echo '</div>';



        // only do mode/permissions checks if an instance was found in the intial checks
        if ( $instance['instanceFOUND'] != qText('Yes') ) {
            // this is the content area
            echo '<div class="row-content-container nothing-to-display" style="">';
            echo '<div class="warn" style=" margin-top:10px;margin-bottom:10px;">';
            echo qText('Instance Not Found') .', '. sprintf(qText('No %s tests performed'), $instance['ARRNAME']);

                if ( $instance['instanceCONFIGURED'] == qText('Yes') ) {
                    echo '<br />'. qText('But configuration found');

                }

            echo '</div>';
            echo '</div>';

        }

        echo '</div>';
        // end content left block



        /** display the system information *************************************************/
        echo '<div class="half-section-information-right">'; // start right content block

        echo '<div class="section-title" style="text-align:center;">'. sprintf(qText('%s :: Configuration'), $instance['ARRNAME']) .'</div>';
        echo '<div class="" style="width:99%;margin: 0px auto;clear:both;margin-bottom:10px;">';

            // only do mode/permissions checks if an instance was found in the intial checks
            if ( $instance['instanceCONFIGURED'] == qText('Yes') AND $instance['configVALIDFOR'] != _FPA_U ) {

                echo '<div class="mini-content-container">';
                echo '<div class="mini-content-box">';
                echo '<div class="mini-content-title">Offline</div>';
                echo $instance['configOFFLINE'];
                echo '</div>';
                echo '</div>';


                echo '<div class="mini-content-container">';
                echo '<div class="mini-content-box">';
                echo '<div class="mini-content-title" style="margin-bottom:0px!important;">SEF URL\'s</div>';
                echo '<div class="mini-content-box-small">';
                echo '<div style="font-size:9px;width:99%;border-bottom: 1px dotted #c0c0c0;">'. qText('Enabled') .':<div style="float:right;font-size:9px;">'. $instance['configSEF'] .'</div></div>';
                echo '<div style="font-size:9px;width:99%;border-bottom: 1px dotted #c0c0c0;">Suffix:<div style="float:right;font-size:9px;">'. $instance['configSEFSUFFIX'] .'</div></div>';

                    if ( $system['sysSHORTWEB'] != 'MIC' AND $instance['configSEFRWRITE'] == '1' AND $instance['configSITEHTWC'] != qText('Yes') ) {
                        $sefColor = 'ff0000';

                    } else {
                        $sefColor = '404040';

                    }

                echo '<div style="font-size:9px;width:99%;border-bottom: 1px dotted #c0c0c0;color:#'. $sefColor .';">ReWrite:<div style="float:right;color:#'. $sefColor .';font-size:9px;">'. $instance['configSEFRWRITE'] .'</div></div>';
                echo '</div>';
                echo '</div>';
                echo '</div>';


                echo '<div class="mini-content-container">';
                echo '<div class="mini-content-box">';
                echo '<div class="mini-content-title" style="margin-bottom:0px!important;">Compression</div>';
                echo '<div class="mini-content-box-small">';
                echo '<div style="font-size:9px;width:99%;border-bottom: 1px dotted #c0c0c0;">GZip:<div style="float:right;font-size:9px;">'. $instance['configGZIP'] .'</div></div>';
                echo '<div style="font-size:9px;width:99%;border-bottom: 1px dotted #c0c0c0;">Cache:<div style="float:right;font-size:9px;">'. $instance['configCACHING'] .'</div></div>';
                echo '</div>';
                echo '</div>';
                echo '</div>';


                echo '<div class="mini-content-container">';
                echo '<div class="mini-content-box">';
                echo '<div class="mini-content-title" style="margin-bottom:0px!important;">Debugging</div>';
                echo '<div class="mini-content-box-small">';
                echo '<div style="font-size:9px;width:99%;border-bottom: 1px dotted #c0c0c0;">Error Rep:<div style="float:right;font-size:9px;">'. $instance['configERRORREP'] .'</div></div>';
                echo '<div style="font-size:9px;width:99%;border-bottom: 1px dotted #c0c0c0;">Site Debug:<div style="float:right;font-size:9px;">'. $instance['configSITEDEBUG'] .'</div></div>';
                echo '<div style="font-size:9px;width:99%;border-bottom: 1px dotted #c0c0c0;">Lang Debug:<div style="float:right;font-size:9px;">'. $instance['configLANGDEBUG'] .'</div></div>';
                echo '</div>';
                echo '</div>';
                echo '</div>';


                echo '<div class="mini-content-container">';
                echo '<div class="mini-content-box">';
                echo '<div class="mini-content-title" style="margin-bottom:0px!important;">'. qText('Database') .'</div>';
                echo '<div class="mini-content-box-small">';
                echo '<div style="font-size:9px;width:99%;border-bottom: 1px dotted #c0c0c0;">Type:<div style="float:right;font-size:9px;">'. $instance['configDBTYPE'] .'</div></div>';
                echo '<div style="font-size:9px;width:99%;border-bottom: 1px dotted #c0c0c0;">'. qText('Version') .':<div style="float:right;font-size:9px;">'. @$database['dbHOSTSERV'] .'</div></div>';
                echo '<div style="font-size:9px;width:99%;border-bottom: 1px dotted #c0c0c0;">CharSet:<div style="float:right;font-size:9px;">'. @$database['dbCHARSET'] .'</div></div>';
                echo '</div>';
                echo '</div>';
                echo '</div>';


                echo '<div class="mini-content-container">';
                echo '<div class="mini-content-box">';
                echo '<div class="mini-content-title">'. qText('Database credentials') .'</div>';

                    if ( $instance['configDBCREDOK'] == qText('Yes') ) {
                        echo '<div class="ok" style="width:99%;margin: 0px auto;font-size:9px;">'. qText('Appear in-complete') .'</div>';
                    } else {
                        echo '<div class="warn" style="width:99%;margin: 0px auto;font-size:9px;">'. qText('Appear complete') .'</div>';
                    }

                echo '</div>';
                echo '</div>';


                echo '<div class="mini-content-container">';
                echo '<div class="mini-content-box">';
                echo '<div class="mini-content-title" style="margin-bottom:0px!important;">'. qText('Security') .'</div>';
                echo '<div class="mini-content-box-small">';
                echo '<div style="font-size:9px;width:99%;border-bottom: 1px dotted #c0c0c0;">SSL:<div style="float:right;font-size:9px;">'. $instance['configSSL'] .'</div></div>';
                echo '<div style="font-size:9px;width:99%;border-bottom: 1px dotted #c0c0c0;">Def\' Access:<div style="float:right;font-size:9px;">'. $instance['configACCESS'] .'</div></div>';
                echo '</div>';
                echo '</div>';
                echo '</div>';


                echo '<div class="mini-content-container">';
                echo '<div class="mini-content-box">';
                echo '<div class="mini-content-title" style="margin-bottom:0px!important;">'. qText('Features') .'</div>';
                echo '<div class="mini-content-box-small">';
                echo '<div style="font-size:9px;width:99%;border-bottom: 1px dotted #c0c0c0;">FTP:<div style="float:right;font-size:9px;">'. $instance['configFTP'] .'</div></div>';
                echo '<div style="font-size:9px;width:99%;border-bottom: 1px dotted #c0c0c0;">Unicode Slug:<div style="float:right;font-size:9px;">'. $instance['configUNICODE'] .'</div></div>';
                echo '</div>';
                echo '</div>';
                echo '</div>';


            } else { // an instance wasn't found in the initial checks, so no folders to check


                echo '<div class="mini-content-container">';
                echo '<div class="mini-content-box">';
                echo '<div class="mini-content-title">'. qText('Config version') .'</div>';
                echo '<div class="warn" style="width:50px;margin: 0px auto;">'. qText('Unknown') .'</div>';
                echo '</div>';
                echo '</div>';


                echo '<div class="mini-content-container">';
                echo '<div class="mini-content-box">';
                echo '<div class="mini-content-title">'. qText('Config valid') .'</div>';

                    if ( @$instance['configSIZEVALID'] == qText('No') ) {
                        echo '<div class="warn" style="width:99%;margin: 0px auto;">'. qText('Could be empty') .'</div>';
                    }

                echo '</div>';
                echo '</div>';


                echo '<div class="row-content-container nothing-to-display" style="">';
                echo '<div class="warn" style=" margin-top:10px;margin-bottom:10px;">';
                echo qText('Configuration not found or invalid')
                . '<br /> '. sprintf(qText('No %s tests performed'), $instance['ARRNAME']);
                echo '</div>';
                echo '</div>';
            }

        echo '</div>';
        echo '</div>';
        // end content right block

    echo '</div>'; // end half-section container
    showDev( $instance );
?>



<?php
    // build a full-width div to hold two 'half-width' section, side-by-side
    echo '<div class="half-section-container" style="">'; // start half-section container

        /** display the instance information *************************************************/
        echo '<div class="half-section-information-left">'; // start left content block

        echo '<div class="section-title" style="text-align:center;">'. sprintf(qText('%s discovery'), $database['ARRNAME']) .'</div>';
        echo '<div class="" style="width:99%;margin: 0px auto;clear:both;margin-bottom:10px;">';

        echo '<div class="mini-content-box-small" style="">';
        echo '<div style="line-height:10px;font-size:8px;color:#404040;text-shadow: #fff 1px 1px 1px; width:99%;border-bottom:1px solid #ccebeb;font-weight:bold;padding:1px;padding-right:0px;padding-bottom:3px;text-transform:uppercase;">'
        . sprintf(qText('%s version'), $instance['configDBTYPE'])
        .':<div style="line-height:11px;text-transform:none!important;float:right;font-size:9px;font-weight:normal;width:60%;background-color:#fff;text-align:right;padding:1px;padding-top:0px;border-top-right-radius: 5px;-moz-border-top-right-radius: 5px;-webkit-border-top-right-radius: 5px;  border-top-left-radius: 5px;-moz-border-top-left-radius: 5px;-webkit-border-top-left-radius: 5px;border-right: 1px solid #42AEC2;border-left: 1px solid #42AEC2;border-top: 1px solid #42AEC2;1px solid #ccebeb;">';

            if ( @$database['dbHOSTSERV'] ) {
                echo '<span class="normal">'. qText('Server') .': '. $database['dbHOSTSERV'] .'&nbsp;</span>';

            } else {
                echo '<span class="normal">'. qText('Server') .':</span> <span class="warn-text">'. qText('Unknown') .'&nbsp;</span>';
            }

            if ( @$database['dbHOSTCLIENT'] ) {
                echo '<span class="normal">&nbsp;&nbsp;'. qText('Client') .': '. $database['dbHOSTCLIENT'] .'&nbsp;</span>';

            } else {
                echo '<span class="normal">&nbsp;&nbsp;'. qText('Client') .':</span> <span class="warn-text">'. qText('Unknown') .'&nbsp;</span>';
            }

        echo '</div></div>';
        echo '</div>';


        echo '<div class="mini-content-box-small" style="">';
        echo '<div style="line-height:10px;font-size:8px;color:#404040;text-shadow: #fff 1px 1px 1px;width:99%;border-bottom:1px solid #ccebeb;font-weight:bold;padding:1px;padding-top:0px;padding-right:0px;padding-bottom:2px;text-transform:uppercase;">'
        . $instance['configDBTYPE'] .' '. qText('Hostname')
        .':<div style="line-height:11px;text-transform:none!important;float:right;font-size:9px;font-weight:normal;width:60%;background-color:#fff;text-align:right;padding:1px;padding-top:0px;border-right: 1px solid #42AEC2;border-left: 1px solid #42AEC2;1px solid #ccebeb;">';

            if ( $showProtected == 1 ) {

                if ( $instance['configDBHOST'] ) {
                    echo '<div class="normal">&nbsp;'. $instance['configDBHOST'] .'&nbsp;</div>';

                } else {
                    echo '<span class="alert-text">&nbsp;'. qText('Not Configured') .'&nbsp;</span>';
                }

            } else {
                echo '<span class="protected">[&nbsp;--&nbsp;'. qText('Protected') .'&nbsp;--&nbsp;]</span>&nbsp;';
            }

        echo '</div></div>';
        echo '</div>';


        echo '<div class="mini-content-box-small" style="">';
        echo '<div style="line-height:10px;font-size:8px;color:#404040;text-shadow: #fff 1px 1px 1px;width:99%;border-bottom:1px solid #ccebeb;font-weight:bold;padding:1px;padding-top:0px;padding-right:0px;padding-bottom:2px;text-transform:uppercase;">'
        . qText('Connection Type')
        .':<div style="line-height:11px;text-transform:none!important;float:right;font-size:9px;font-weight:normal;width:60%;background-color:#fff;text-align:right;padding:1px;padding-top:0px;border-right: 1px solid #42AEC2;border-left: 1px solid #42AEC2;1px solid #ccebeb;">';

        echo '<span class="normal">';

            if ( $database['dbLOCAL'] == qText('Yes') ) {
                echo '('. qText('Local') .') '. $database['dbHOSTINFO'] .'&nbsp';

            } elseif ( $database['dbLOCAL'] == qText('No') AND @$database['dbHOSTINFO'] ) {

                if ( $showProtected <= 2 ) {
                    echo '('. qText('Remote') .') '. $database['dbHOSTINFO'] .'&nbsp';

                } else {
                    echo '<span class="protected">[&nbsp;--&nbsp;'. qText('Protected') .'&nbsp;--&nbsp;]</span>&nbsp;';
                }

            } elseif ( $database['dbLOCAL'] == qText('No') AND !@$database['dbHOSTINFO'] ) {
                echo '('. qText('Remote') .') <span class="warn-text"> '. qText('Unknown') .'</span>&nbsp';

            } else {
                echo '<span class="warn-text">'. qText('Unknown') .'</span>';
            }

            echo '</span>';

        echo '</div></div>';
        echo '</div>';


        echo '<div class="mini-content-box-small" style="">';
        echo '<div style="line-height:10px;font-size:8px;color:#404040;text-shadow: #fff 1px 1px 1px;width:99%;border-bottom:1px solid #ccebeb;font-weight:bold;padding:1px;padding-top:0px;padding-right:0px;padding-bottom:2px;text-transform:uppercase;">'
        .sprintf(qText('%s support'), 'PHP')
        .':<div style="line-height:11px;text-transform:none!important;float:right;font-size:9px;font-weight:normal;width:60%;background-color:#fff;text-align:right;padding:1px;padding-top:0px;border-right: 1px solid #42AEC2;border-left: 1px solid #42AEC2;1px solid #ccebeb;">';

            if ( $instance['configDBTYPE'] == 'mysqli' AND $phpenv['phpSUPPORTSMYSQLI'] == qText('No') ) {
                echo '<span class="alert-text">'. sprintf(qText('%s is not supported by PHP %s'), $instance['configDBTYPE'], $phpenv['phpVERSION']) .'&nbsp;</span>';

            } elseif ( ( $instance['configDBTYPE'] == 'mysqli' AND $phpenv['phpSUPPORTSMYSQLI'] == qText('Yes') ) OR @$instance['configDBTYPE'] == 'mysql' ) {
                echo '<span class="ok">'. sprintf(qText('%s is supported by PHP %s'), $instance['configDBTYPE'], $phpenv['phpVERSION']) .'&nbsp;</span>';

            } else {
                echo '<span class="warn-text">'.sprintf(qText('PHP %s support is unknown'), $phpenv['phpVERSION']) .'&nbsp;</span>';
            }

        echo '</div></div>';
        echo '</div>';


        echo '<div class="mini-content-box-small" style="">';
        echo '<div style="line-height:10px;font-size:8px;color:#404040;text-shadow: #fff 1px 1px 1px;width:99%;border-bottom:1px solid #ccebeb;font-weight:bold;padding:1px;padding-top:0px;padding-right:0px;padding-bottom:2px;text-transform:uppercase;">'
        . sprintf(qText('Connect to %s'), $instance['configDBTYPE'])
        .':<div style="line-height:11px;text-transform:none!important;float:right;font-size:9px;font-weight:normal;width:60%;background-color:#fff;text-align:right;padding:1px;padding-top:0px;border-right: 1px solid #42AEC2;border-left: 1px solid #42AEC2;1px solid #ccebeb;">';

            if ( $database['dbDOCHECKS'] == qText('No') ) {
                echo '<span class="warn-text">&nbsp;'. qText('Not Attempted') .', '. qText('Not Configured') .'&nbsp;</span>';

            } elseif ( @$database['dbERROR'] == qText('No') ) {
                echo '<span class="ok">&nbsp;'. qText('Yes') .', '. qText('Connected') .'&nbsp;</span>';

            } elseif ( @$database['dbERROR'] != qText('No') ) {
                echo '<span class="alert-text">&nbsp;'. qText('Error(s) reported') .'&nbsp;</span>';
            }

        echo '</div></div>';
        echo '</div>';



            if ( @$database['dbERROR'] AND @$database['dbERROR'] != qText('No') ) {

                echo '<div class="mini-content-box-small" style="">';
                echo '<div class="alert-text" style="line-height:10px;text-shadow: #fff 1px 1px 1px;border-bottom: 1px solid #ccebeb;font-size:8px;width:99%;font-weight:bold;padding:1px;padding-top:0px;padding-right:0px;padding-bottom:2px;text-transform:uppercase;">'
                . qText('Connection Error')
                .':<div style="line-height:11px;text-transform:none!important;float:right;font-size:9px;font-weight:normal;width:60%;background-color:#fff;text-align:right;padding:1px;padding-top:0px;border-right: 1px solid #42AEC2;border-left: 1px solid #42AEC2;border-bottom: 1px solid #ccebeb;">';

                echo '<div class="alert" style="margin:5px;font-weight:normal;font-size:9px;padding:2px;">'. $database['dbERROR'] .'</div>';

                echo '</div></div>';
                echo '</div>';
                echo '<br style="clear:both;" />';
            }


        echo '<div class="mini-content-box-small" style="">';
        echo '<div style="line-height:10px;font-size:8px;color:#404040;text-shadow: #fff 1px 1px 1px;width:99%;border-bottom: 1px solid #ccebeb;font-weight:bold;padding:1px;padding-top:0px;padding-right:0px;padding-bottom:2px;text-transform:uppercase;">'
        . $instance['configDBTYPE'] .' '. qText('Character Set')
        .':<div style="line-height:11px;text-transform:none!important;float:right;font-size:9px;font-weight:normal;width:60%;background-color:#fff;text-align:right;padding:1px;padding-top:0px;border-right: 1px solid #42AEC2;border-left: 1px solid #42AEC2;border-bottom: 1px solid #ccebeb;">';

            if ( @$database['dbCHARSET'] ) {
                echo '<span class="normal">&nbsp;'. $database['dbCHARSET'] .'&nbsp;</span>';

            } else {
                echo '<span class="warn-text">&nbsp;'. qText('Unknown') .'&nbsp;</span>';
            }

        echo '</div></div>';
        echo '</div>';


        echo '<div class="mini-content-box-small" style="">';
        echo '<div style="line-height:10px;font-size:8px;color:#404040;text-shadow: #fff 1px 1px 1px;width:99%;border-bottom: 1px solid #ccebeb;font-weight:bold;padding:1px;padding-top:0px;padding-right:0px;padding-bottom:2px;text-transform:uppercase;">'
        . qText('Default Character Set')
        . ':<div style="line-height:11px;text-transform:none!important;float:right;font-size:9px;font-weight:normal;width:60%;background-color:#fff;text-align:right;padding:1px;padding-top:0px;border-right: 1px solid #42AEC2;border-left: 1px solid #42AEC2;border-bottom: 1px solid #ccebeb;">';

            if ( @$database['dbHOSTDEFCHSET'] ) {
                echo '<span class="normal">&nbsp;'. $database['dbHOSTDEFCHSET'] .'&nbsp;</span>';

            } else {
                echo '<span class="warn-text">&nbsp;'. qText('Unknown') .'&nbsp;</span>';
            }

        echo '</div></div>';
        echo '</div>';


        echo '<div class="mini-content-box-small" style="">';
        echo '<div style="line-height:10px;font-size:8px;color:#404040;text-shadow: #fff 1px 1px 1px;width:99%;border-bottom: 1px solid #ccebeb;font-weight:bold;padding:1px;padding-top:0px;padding-right:0px;padding-bottom:2px;text-transform:uppercase;">'
        . qText('Database collation')
        .':<div style="line-height:11px;text-transform:none!important;float:right;font-size:9px;font-weight:normal;width:60%;background-color:#fff;text-align:right;padding:1px;padding-top:0px;border-right: 1px solid #42AEC2;border-left: 1px solid #42AEC2;border-bottom: 1px solid #ccebeb;">';

            if ( @$database['dbCOLLATION'] ) {
                echo '<div class="normal">&nbsp;'. $database['dbCOLLATION'] .'&nbsp;</div>';

            } elseif ( @$database['dbERROR'] != qText('No') ) {
                echo '<span class="warn-text">&nbsp;'. qText('Unknown') .'&nbsp;</span>';

            } else {
                echo '<span class="warn-text">&nbsp;'. qText('Not Configured') .'&nbsp;</span>';
            }

        echo '</div></div>';
        echo '</div>';


        echo '<div class="mini-content-box-small" style="">';
        echo '<div style="line-height:10px;font-size:8px;color:#404040;text-shadow: #fff 1px 1px 1px;width:99%;font-weight:bold;padding:1px;padding-right:0px;padding-top:0px;padding-bottom:3px;text-transform:uppercase;">'
        . qText('Database size')
        .':<div style="line-height:9px;text-transform:none!important;float:right;font-size:11px;font-weight:normal;width:60%;background-color:#fff;text-align:right;padding:1px;padding-top:0px;border-bottom-right-radius: 5px;-moz-border-bottom-right-radius: 5px;-webkit-border-bottom-right-radius: 5px;  border-bottom-left-radius: 5px;-moz-border-bottom-left-radius: 5px;-webkit-border-bottom-left-radius: 5px;border-right: 1px solid #42AEC2;border-left: 1px solid #42AEC2;border-bottom: 1px solid #42AEC2;">';

            if ( @$database['dbSIZE'] ) {
                echo '<span class="normal">&nbsp;'. $database['dbSIZE'] .'&nbsp;</span>';

            } else {
                echo '<span class="warn-text">&nbsp;'. qText('Unknown') .'&nbsp;</span>';
            }

        echo '</div></div>';


        if ( @$instance['configDBCREDOK'] != qText('Yes') AND $instance['instanceFOUND'] == qText('Yes') ) {
        echo '<br /><br />';
        echo '<div class="mini-content-box-small" style="">';
        echo '<div style="line-height:10px;font-size:8px;color:#404040;text-shadow: #fff 1px 1px 1px;width:99%;border-bottom: 1px solid #ccebeb;font-weight:bold;padding:1px;padding-top:0px;padding-right:0px;padding-bottom:2px;text-transform:uppercase;">';

        echo '<span class="alert-text" style="font-size:8px;">' . qText('Missing credentials detected') .':</span> ';

            if ( $instance['configDBTYPE'] == '' ) { echo '<span class="warn-text" style="font-size:9px;font-weight:normal;text-transform:none;">&nbsp;'. sprintf(qText('%s not found'), '<b>' . qText('Connection Type') .'</b>') .'</span>'; }
            if ( $instance['configDBHOST'] == '' ) { echo '<span class="warn-text" style="font-size:9px;font-weight:normal;text-transform:none;">&nbsp;'. sprintf(qText('%s not found'), '<b>' . qText('MySQL Hostname') .'</b>') . '</span>'; }
            if ( @$instance['configDBPREF'] == '' ) { echo '<span class="warn-text" style="font-size:9px;font-weight:normal;text-transform:none;">&nbsp;'. sprintf(qText('%s not found'), '<b>' . qText('Table Prefix') .'</b>') . '</span>'; }
            if ( @$instance['configDBUSER'] == '' ) { echo '<span class="warn-text" style="font-size:9px;font-weight:normal;text-transform:none;">&nbsp;'. sprintf(qText('%s not found'), '<b>' . qText('Database user') .'</b>') . '</span>'; }

            //-- @todo: allow empty db password ?
            if ( @$instance['configDBPASS'] == '' ) { echo '<span class="warn-text" style="font-size:9px;font-weight:normal;text-transform:none;">&nbsp;'. sprintf(qText('%s not found'), '<b>' . qText('Database password') .'</b>') . '</span>'; }

            echo '</div></div>';
        }


        echo '</div>';
        echo '</div></div>';
        // end content left block


        /** display the system information *************************************************/
        echo '<div class="half-section-information-right">'; // start right content block

        echo '<div class="section-title" style="text-align:center;">'. $database['ARRNAME'] .' :: '. qText('Performance') .'</div>';
        echo '<div class="" style="width:99%;margin: 0px auto;clear:both;margin-bottom:10px;">';

            // only do mode/permissions checks if an instance was found in the intial checks
            if ( $database['dbDOCHECKS'] == qText('Yes') AND @$database['dbERROR'] == qText('No') ) {

                $pieces = explode(": ", $database['dbHOSTSTATS'][0] );

                echo '<div class="mini-content-box-small" style="">';
                echo '<div style="line-height:10px;font-size:8px;color:#404040;text-shadow: #fff 1px 1px 1px; width:99%;border-bottom:1px solid #ccebeb;font-weight:bold;padding:1px;padding-right:0px;padding-bottom:3px;text-transform:uppercase;">'. $pieces[0] .':<div style="line-height:11px;text-transform:none!important;float:right;font-size:9px;font-weight:normal;width:60%;background-color:#fff;text-align:right;padding:1px;padding-top:0px;border-top-right-radius: 5px;-moz-border-top-right-radius: 5px;-webkit-border-top-right-radius: 5px;  border-top-left-radius: 5px;-moz-border-top-left-radius: 5px;-webkit-border-top-left-radius: 5px;border-right: 1px solid #42AEC2;border-left: 1px solid #42AEC2;border-top: 1px solid #42AEC2;1px solid #ccebeb;">';
                echo '<span class="normal">'. $pieces[1] .' seconds&nbsp;</span>';
                echo '</div></div>';
                echo '</div>';


                $pieces = explode(": ", $database['dbHOSTSTATS'][1] );
                echo '<div class="mini-content-box-small" style="">';
                echo '<div style="line-height:10px;font-size:8px;color:#404040;text-shadow: #fff 1px 1px 1px;width:99%;border-bottom:1px solid #ccebeb;font-weight:bold;padding:1px;padding-top:0px;padding-right:0px;padding-bottom:2px;text-transform:uppercase;">'. $pieces[0] .':<div style="line-height:11px;text-transform:none!important;float:right;font-size:9px;font-weight:normal;width:60%;background-color:#fff;text-align:right;padding:1px;padding-top:0px;border-right: 1px solid #42AEC2;border-left: 1px solid #42AEC2;1px solid #ccebeb;">';
                echo '<span class="normal">'. $pieces[1] .'&nbsp;</span>';
                echo '</div></div>';
                echo '</div>';


                $pieces = explode(": ", $database['dbHOSTSTATS'][2] );
                echo '<div class="mini-content-box-small" style="">';
                echo '<div style="line-height:10px;font-size:8px;color:#404040;text-shadow: #fff 1px 1px 1px;width:99%;border-bottom:1px solid #ccebeb;font-weight:bold;padding:1px;padding-top:0px;padding-right:0px;padding-bottom:2px;text-transform:uppercase;">'. $pieces[0] .':<div style="line-height:11px;text-transform:none!important;float:right;font-size:9px;font-weight:normal;width:60%;background-color:#fff;text-align:right;padding:1px;padding-top:0px;border-right: 1px solid #42AEC2;border-left: 1px solid #42AEC2;1px solid #ccebeb;">';
                echo '<span class="normal">'. $pieces[1] .'&nbsp;</span>';
                echo '</div></div>';
                echo '</div>';


                $pieces = explode(": ", $database['dbHOSTSTATS'][3] );
                echo '<div class="mini-content-box-small" style="">';
                echo '<div style="line-height:10px;font-size:8px;color:#404040;text-shadow: #fff 1px 1px 1px;width:99%;border-bottom:1px solid #ccebeb;font-weight:bold;padding:1px;padding-top:0px;padding-right:0px;padding-bottom:2px;text-transform:uppercase;">'. $pieces[0] .':<div style="line-height:11px;text-transform:none!important;float:right;font-size:9px;font-weight:normal;width:60%;background-color:#fff;text-align:right;padding:1px;padding-top:0px;border-right: 1px solid #42AEC2;border-left: 1px solid #42AEC2;1px solid #ccebeb;">';
                echo '<span class="normal">'. $pieces[1] .'&nbsp;</span>';
                echo '</div></div>';
                echo '</div>';


                $pieces = explode(": ", $database['dbHOSTSTATS'][4] );
                echo '<div class="mini-content-box-small" style="">';
                echo '<div style="line-height:10px;font-size:8px;color:#404040;text-shadow: #fff 1px 1px 1px;width:99%;border-bottom:1px solid #ccebeb;font-weight:bold;padding:1px;padding-top:0px;padding-right:0px;padding-bottom:2px;text-transform:uppercase;">'. $pieces[0] .':<div style="line-height:11px;text-transform:none!important;float:right;font-size:9px;font-weight:normal;width:60%;background-color:#fff;text-align:right;padding:1px;padding-top:0px;border-right: 1px solid #42AEC2;border-left: 1px solid #42AEC2;1px solid #ccebeb;">';
                echo '<span class="normal">'. $pieces[1] .'&nbsp;</span>';
                echo '</div></div>';
                echo '</div>';


                $pieces = explode(": ", $database['dbHOSTSTATS'][5] );
                echo '<div class="mini-content-box-small" style="">';
                echo '<div style="line-height:10px;font-size:8px;color:#404040;text-shadow: #fff 1px 1px 1px;width:99%;border-bottom:1px solid #ccebeb;font-weight:bold;padding:1px;padding-top:0px;padding-right:0px;padding-bottom:2px;text-transform:uppercase;">'. $pieces[0] .':<div style="line-height:11px;text-transform:none!important;float:right;font-size:9px;font-weight:normal;width:60%;background-color:#fff;text-align:right;padding:1px;padding-top:0px;border-right: 1px solid #42AEC2;border-left: 1px solid #42AEC2;1px solid #ccebeb;">';
                echo '<span class="normal">'. $pieces[1] .'&nbsp;</span>';
                echo '</div></div>';
                echo '</div>';


                $pieces = explode(": ", $database['dbHOSTSTATS'][6] );
                echo '<div class="mini-content-box-small" style="">';
                echo '<div style="line-height:10px;font-size:8px;color:#404040;text-shadow: #fff 1px 1px 1px;width:99%;border-bottom:1px solid #ccebeb;font-weight:bold;padding:1px;padding-top:0px;padding-right:0px;padding-bottom:2px;text-transform:uppercase;">'. $pieces[0] .':<div style="line-height:11px;text-transform:none!important;float:right;font-size:9px;font-weight:normal;width:60%;background-color:#fff;text-align:right;padding:1px;padding-top:0px;border-right: 1px solid #42AEC2;border-left: 1px solid #42AEC2;1px solid #ccebeb;">';
                echo '<span class="normal">'. $pieces[1] .'&nbsp;</span>';
                echo '</div></div>';
                echo '</div>';


                $pieces = explode(": ", $database['dbHOSTSTATS'][7] );
                echo '<div class="mini-content-box-small" style="">';
                echo '<div style="line-height:10px;font-size:8px;color:#404040;text-shadow: #fff 1px 1px 1px;width:99%;border-bottom:1px solid #ccebeb;font-weight:bold;padding:1px;padding-top:0px;padding-right:0px;padding-bottom:2px;text-transform:uppercase;">'. $pieces[0] .':<div style="line-height:11px;text-transform:none!important;float:right;font-size:9px;font-weight:normal;width:60%;background-color:#fff;text-align:right;padding:1px;padding-top:0px;border-right: 1px solid #42AEC2;border-left: 1px solid #42AEC2;1px solid #ccebeb;">';
                echo '<span class="normal">'. $pieces[1] .'&nbsp;</span>';
                echo '</div></div>';
                echo '</div>';



                echo '<div class="mini-content-box-small" style="">';
                echo '<div style="line-height:10px;font-size:8px;color:#404040;text-shadow: #fff 1px 1px 1px;width:99%;font-weight:bold;padding:1px;padding-right:0px;padding-top:0px;padding-bottom:3px;text-transform:uppercase;">'
                .'# '. qText('Table')
                .':<div style="line-height:9px;text-transform:none!important;float:right;font-size:11px;font-weight:normal;width:60%;background-color:#fff;text-align:right;padding:1px;padding-top:0px;border-bottom-right-radius: 5px;-moz-border-bottom-right-radius: 5px;-webkit-border-bottom-right-radius: 5px;  border-bottom-left-radius: 5px;-moz-border-bottom-left-radius: 5px;-webkit-border-bottom-left-radius: 5px;border-right: 1px solid #42AEC2;border-left: 1px solid #42AEC2;border-bottom: 1px solid #42AEC2;">';

                    if ( $database['dbTABLECOUNT'] ) {
                        echo '<span class="normal">&nbsp;'. $database['dbTABLECOUNT'] .' tables&nbsp;</span>';

                    } else {
                        echo '<span class="warn-text">&nbsp;'. qText('Unknown') .'&nbsp;</span>';
                    }

                echo '</div></div>';
                echo '</div>';


            } else { // an instance wasn't found in the initial checks, so no folders to check

                echo '<div class="row-content-container nothing-to-display" style="">';
                echo '<div class="warn" style=" margin-top:10px;margin-bottom:10px;">'. qText('Not Connected')
                .'<br />'. sprintf(qText('No %s performance tests performed'), $database['ARRNAME']) .'</div>';
                echo '</div>';
            }


        echo '</div>';
        echo '</div>';
        // end content right block

    echo '<div style="clear:both;"></div>';

    showDev( $database );

    echo '</div>'; // end half-section container
    echo '<div style="clear:both;"></div>';
?>



<?php
    if ( $showTables == '1' ) {

        /** display the table statistics and details for the selected database *******************/
        echo '<div class="section-information">';
        echo '<div class="section-title" style="text-align:center;">'. $tables['ARRNAME'] .'</div>';

        echo '<div class="column-title-container" style="width:99%;margin: 0px auto;clear:both;display:block;">';

        echo '<div class="column-title" style="width:20%;float:left;text-align:center;">'. qText('Name') .'</div>';
        echo '<div class="column-title" style="width:7%;float:left;left;text-align:center;">'. qText('Size') .'</div>';
        echo '<div class="column-title" style="width:6%;float:left;text-align:center;">'. qText('Table records') .'</div>';
        echo '<div class="column-title" style="width:8%;float:left;text-align:center;">'. qText('Avg. Length') .'</div>';
        echo '<div class="column-title" style="width:10%;float:left;text-align:center;">'. qText('Fragment Size') .'</div>';
        echo '<div class="column-title" style="width:6%;float:left;text-align:center;">'. qText('Engine') .'</div>';
        echo '<div class="column-title" style="width:10%;float:left;text-align:center;">'. qText('Collation') .'</div>';
        echo '<div class="column-title" style="width:9%;float:left;text-align:center;">'. qText('Created') .'</div>';
        echo '<div class="column-title" style="width:9%;float:left;text-align:center;">'. qText('Updated') .'</div>';
        echo '<div class="column-title" style="width:9%;float:left;text-align:center;">'. qText('Checked') .'</div>';
        echo '<div style="clear:both;"></div>';
        echo '</div>';

            if ( $instance['instanceFOUND'] == qText('Yes') AND @$database['dbERROR'] == qText('No') ) {

                foreach ( $tables as $i => $show ) {

                    if ( $show != $tables['ARRNAME'] ) {
                        // produce the output
                        echo '<div style="font-size:9px;border-bottom:1px dotted #C0C0C0;width:99%;margin: 0px auto;padding-top:1px;padding-bottom:1px;clear:both;">';

                            if ( $showProtected <= 2 ) {
                                echo '<div style="font-size:9px;text-align:left;float:left;width:20%;">&nbsp;'. $show['TABLE'] .'</div>';

                            } else {

                                echo '<div style="font-size:9px;text-align:left;float:left;width:20%;">&nbsp;<span class="protected">[&nbsp;--&nbsp;'. qText('Protected') .'&nbsp;--&nbsp;]</span></div>';

                            }

                        echo '<div style="font-size:9px;text-align:center;float:left;width:8%;">'. $show['SIZE'] .'</div>';
                        echo '<div style="font-size:9px;text-align:center;float:left;width:7%;">'. $show['RECORDS'] .'</div>';
                        echo '<div style="font-size:9px;text-align:center;float:left;width:8%;">'. $show['AVGLEN'] .'</div>';
                        echo '<div style="font-size:9px;text-align:center;float:left;width:10%;">'. $show['FRAGSIZE'] .'</div>';
                        echo '<div style="font-size:9px;text-align:center;float:left;width:7%;">'. $show['ENGINE'] .'</div>';


                        if ( $show['COLLATION'] != $database['dbCOLLATION'] ) {
                            echo '<div style="font-size:9px;text-align:center;float:left;width:12%;"><span class="warn-text" style="font-size:9px;">*</span>'. $show['COLLATION'] .'</div>';

                        } else {
                            echo '<div style="font-size:9px;text-align:center;float:left;width:12%;">'. $show['COLLATION'] .'</div>';

                        }

                        $pieces = explode( " ", $show['CREATED'] );
                        echo '<div style="font-size:9px;text-align:center;float:left;width:9%;">'. $pieces['0'] .'</div>';

                        $pieces = explode( " ", $show['UPDATED'] );
                        echo '<div style="font-size:9px;text-align:center;float:left;width:9%;">'. $pieces['0'] .'</div>';

                        $pieces = explode( " ", $show['CHECKED'] );
                        echo '<div style="font-size:9px;text-align:center;float:left;width:9%;">'. $pieces['0'] .'</div>';

                        echo '<br /></div>';

                    } // endif , dont show array name

                } // end foreach


            } else { // an instance wasn't found in the initial checks, so no tables to check
                echo '<div style="text-align:center;border-bottom:1px dotted #C0C0C0;width:99%;margin: 0px auto;padding-top:1px;padding-bottom:1px;clear:both;font-size: 11px;">';
                echo '<div class="warn" style=" margin-top:10px;margin-bottom:10px;">'. qText('Not Connected') .', '. sprintf(qText('No %s tests performed'), $tables['ARRNAME']) .'</div>';
                echo '</div>';
            }


        echo '</div>'; // end container
        showDev( $tables );
        unset ( $key, $show );

    } // end showTables
?>



<?php
    // build a full-width div to hold two 'half-width' section, side-by-side
    echo '<div class="half-section-container" style="">'; // start half-section container

        /** display the instance information *************************************************/
        echo '<div class="half-section-information-left">'; // start left content block

        echo '<div class="section-title" style="text-align:center;">'. sprintf(qText('%s discovery'), $phpenv['ARRNAME']) .'</div>';
        echo '<div class="" style="width:99%;margin: 0px auto;clear:both;margin-bottom:10px;">';

        echo '<div class="mini-content-box-small" style="">';
        echo '<div style="line-height:10px;font-size:8px;color:#404040;text-shadow: #fff 1px 1px 1px; width:99%;border-bottom:1px solid #ccebeb;font-weight:bold;padding:1px;padding-right:0px;padding-bottom:3px;text-transform:uppercase;">'
        .sprintf(qText('%s version'), 'PHP')
        .':<div style="line-height:11px;text-transform:none!important;float:right;font-size:9px;font-weight:normal;width:60%;background-color:#fff;text-align:right;padding:1px;padding-top:0px;border-top-right-radius: 5px;-moz-border-top-right-radius: 5px;-webkit-border-top-right-radius: 5px;  border-top-left-radius: 5px;-moz-border-top-left-radius: 5px;-webkit-border-top-left-radius: 5px;border-right: 1px solid #42AEC2;border-left: 1px solid #42AEC2;border-top: 1px solid #42AEC2;1px solid #ccebeb;">';
        echo '<span class="normal">'. $phpenv['phpVERSION'] .'&nbsp;</span>';
        echo '</div></div>';
        echo '</div>';


        echo '<div class="mini-content-box-small" style="">';
        echo '<div style="line-height:10px;font-size:8px;color:#404040;text-shadow: #fff 1px 1px 1px;width:99%;border-bottom:1px solid #ccebeb;font-weight:bold;padding:1px;padding-top:0px;padding-right:0px;padding-bottom:2px;text-transform:uppercase;">PHP API:<div style="line-height:11px;text-transform:none!important;float:right;font-size:9px;font-weight:normal;width:60%;background-color:#fff;text-align:right;padding:1px;padding-top:0px;border-right: 1px solid #42AEC2;border-left: 1px solid #42AEC2;1px solid #ccebeb;">';

            if ( $phpenv['phpAPI'] == 'apache2handler' ) {
                $status = 'warn-text';

            } else {
                $status = 'ok';

            }

        echo '<span class="'. $status.'">'. $phpenv['phpAPI'] .'&nbsp;</span>';
        echo '</div></div>';
        echo '</div>';


        echo '<div class="mini-content-box-small" style="">';
        echo '<div style="line-height:10px;font-size:8px;color:#404040;text-shadow: #fff 1px 1px 1px;width:99%;border-bottom:1px solid #ccebeb;font-weight:bold;padding:1px;padding-top:0px;padding-right:0px;padding-bottom:2px;text-transform:uppercase;">Display Errors:<div style="line-height:11px;text-transform:none!important;float:right;font-size:9px;font-weight:normal;width:60%;background-color:#fff;text-align:right;padding:1px;padding-top:0px;border-right: 1px solid #42AEC2;border-left: 1px solid #42AEC2;1px solid #ccebeb;">';
        echo '<span class="normal">'. $phpenv['phpERRORDISPLAY'] .'&nbsp;</span>';
        echo '</div></div>';
        echo '</div>';


        echo '<div class="mini-content-box-small" style="">';
        echo '<div style="line-height:10px;font-size:8px;color:#404040;text-shadow: #fff 1px 1px 1px;width:99%;border-bottom:1px solid #ccebeb;font-weight:bold;padding:1px;padding-top:0px;padding-right:0px;padding-bottom:2px;text-transform:uppercase;">Error Report Level:<div style="line-height:11px;text-transform:none!important;float:right;font-size:9px;font-weight:normal;width:60%;background-color:#fff;text-align:right;padding:1px;padding-top:0px;border-right: 1px solid #42AEC2;border-left: 1px solid #42AEC2;1px solid #ccebeb;">';
        echo '<span class="normal">'. $phpenv['phpERRORREPORT'] .'&nbsp;</span>';
        echo '</div></div>';
        echo '</div>';


        echo '<div class="mini-content-box-small" style="">';
        echo '<div style="line-height:10px;font-size:8px;color:#404040;text-shadow: #fff 1px 1px 1px;width:99%;border-bottom:1px solid #ccebeb;font-weight:bold;padding:1px;padding-top:0px;padding-right:0px;padding-bottom:2px;text-transform:uppercase;">'
        . sprintf(qText('%s support'), 'MySQLi') .':<div style="line-height:11px;text-transform:none!important;float:right;font-size:9px;font-weight:normal;width:60%;background-color:#fff;text-align:right;padding:1px;padding-top:0px;border-right: 1px solid #42AEC2;border-left: 1px solid #42AEC2;1px solid #ccebeb;">';
        echo '<span class="normal">'. $phpenv['phpSUPPORTSMYSQLI'] .'&nbsp;</span>';
        echo '</div></div>';
        echo '</div>';


        echo '<div class="mini-content-box-small" style="">';
        echo '<div style="line-height:10px;font-size:8px;color:#404040;text-shadow: #fff 1px 1px 1px;width:99%;border-bottom:1px solid #ccebeb;font-weight:bold;padding:1px;padding-top:0px;padding-right:0px;padding-bottom:2px;text-transform:uppercase;">Magic Quotes:<div style="line-height:11px;text-transform:none!important;float:right;font-size:9px;font-weight:normal;width:60%;background-color:#fff;text-align:right;padding:1px;padding-top:0px;border-right: 1px solid #42AEC2;border-left: 1px solid #42AEC2;1px solid #ccebeb;">';
        echo '<span class="normal">'. $phpenv['phpMAGICQUOTES'] .'&nbsp;</span>';
        echo '</div></div>';
        echo '</div>';


        echo '<div class="mini-content-box-small" style="">';
        echo '<div style="line-height:10px;font-size:8px;color:#404040;text-shadow: #fff 1px 1px 1px;width:99%;border-bottom:1px solid #ccebeb;font-weight:bold;padding:1px;padding-top:0px;padding-right:0px;padding-bottom:2px;text-transform:uppercase;">Safe Mode:<div style="line-height:11px;text-transform:none!important;float:right;font-size:9px;font-weight:normal;width:60%;background-color:#fff;text-align:right;padding:1px;padding-top:0px;border-right: 1px solid #42AEC2;border-left: 1px solid #42AEC2;1px solid #ccebeb;">';
        echo '<span class="normal">'. $phpenv['phpSAFEMODE'] .'&nbsp;</span>';
        echo '</div></div>';
        echo '</div>';


        echo '<div class="mini-content-box-small" style="">';
        echo '<div style="line-height:10px;font-size:8px;color:#404040;text-shadow: #fff 1px 1px 1px;width:99%;border-bottom:1px solid #ccebeb;font-weight:bold;padding:1px;padding-top:0px;padding-right:0px;padding-bottom:2px;text-transform:uppercase;">Memory Limit:<div style="line-height:11px;text-transform:none!important;float:right;font-size:9px;font-weight:normal;width:60%;background-color:#fff;text-align:right;padding:1px;padding-top:0px;border-right: 1px solid #42AEC2;border-left: 1px solid #42AEC2;1px solid #ccebeb;">';
        echo '<span class="normal">';

            if ( @$_POST['increasePOPS'] == 1 ) { // the user set the increasePOPS setting for memory or time out errors
                echo '<i class="warn-text">('. sprintf(qText('increased by user, was %s'), $fpa['ORIGphpMEMLIMIT']) .')</i>&nbsp;';

            }

        echo $phpenv['phpMEMLIMIT'] .'&nbsp;</span>';
        echo '</div></div>';
        echo '</div>';


        echo '<div class="mini-content-box-small" style="">';
        echo '<div style="line-height:10px;font-size:8px;color:#404040;text-shadow: #fff 1px 1px 1px;width:99%;border-bottom:1px solid #ccebeb;font-weight:bold;padding:1px;padding-top:0px;padding-right:0px;padding-bottom:2px;text-transform:uppercase;">'
        .qText('Uploads enabled :')
        .'<div style="line-height:11px;text-transform:none!important;float:right;font-size:9px;font-weight:normal;width:60%;background-color:#fff;text-align:right;padding:1px;padding-top:0px;border-right: 1px solid #42AEC2;border-left: 1px solid #42AEC2;1px solid #ccebeb;">';
        echo '<span class="normal">'. $phpenv['phpUPLOADS'] .'&nbsp;</span>';
        echo '</div></div>';
        echo '</div>';


        echo '<div class="mini-content-box-small" style="">';
        echo '<div style="line-height:10px;font-size:8px;color:#404040;text-shadow: #fff 1px 1px 1px;width:99%;border-bottom:1px solid #ccebeb;font-weight:bold;padding:1px;padding-top:0px;padding-right:0px;padding-bottom:2px;text-transform:uppercase;">Max. Upload Size:<div style="line-height:11px;text-transform:none!important;float:right;font-size:9px;font-weight:normal;width:60%;background-color:#fff;text-align:right;padding:1px;padding-top:0px;border-right: 1px solid #42AEC2;border-left: 1px solid #42AEC2;1px solid #ccebeb;">';
        echo '<span class="normal">'. $phpenv['phpMAXUPSIZE'] .'&nbsp;</span>';
        echo '</div></div>';
        echo '</div>';


        echo '<div class="mini-content-box-small" style="">';
        echo '<div style="line-height:10px;font-size:8px;color:#404040;text-shadow: #fff 1px 1px 1px;width:99%;border-bottom:1px solid #ccebeb;font-weight:bold;padding:1px;padding-top:0px;padding-right:0px;padding-bottom:2px;text-transform:uppercase;">Max. Post Size:<div style="line-height:11px;text-transform:none!important;float:right;font-size:9px;font-weight:normal;width:60%;background-color:#fff;text-align:right;padding:1px;padding-top:0px;border-right: 1px solid #42AEC2;border-left: 1px solid #42AEC2;1px solid #ccebeb;">';
        echo '<span class="normal">'. $phpenv['phpMAXPOSTSIZE'] .'&nbsp;</span>';
        echo '</div></div>';
        echo '</div>';


        echo '<div class="mini-content-box-small" style="">';
        echo '<div style="line-height:10px;font-size:8px;color:#404040;text-shadow: #fff 1px 1px 1px;width:99%;border-bottom:1px solid #ccebeb;font-weight:bold;padding:1px;padding-top:0px;padding-right:0px;padding-bottom:2px;text-transform:uppercase;">Max. Input Time:<div style="line-height:11px;text-transform:none!important;float:right;font-size:9px;font-weight:normal;width:60%;background-color:#fff;text-align:right;padding:1px;padding-top:0px;border-right: 1px solid #42AEC2;border-left: 1px solid #42AEC2;1px solid #ccebeb;">';
        echo '<span class="normal">'. $phpenv['phpMAXINPUTTIME'] .' seconds&nbsp;</span>';
        echo '</div></div>';
        echo '</div>';


        echo '<div class="mini-content-box-small" style="">';
        echo '<div style="line-height:10px;font-size:8px;color:#404040;text-shadow: #fff 1px 1px 1px;width:99%;border-bottom:1px solid #ccebeb;font-weight:bold;padding:1px;padding-top:0px;padding-right:0px;padding-bottom:2px;text-transform:uppercase;">Max. Execution Time:<div style="line-height:11px;text-transform:none!important;float:right;font-size:9px;font-weight:normal;width:60%;background-color:#fff;text-align:right;padding:1px;padding-top:0px;border-right: 1px solid #42AEC2;border-left: 1px solid #42AEC2;1px solid #ccebeb;">';
        echo '<span class="normal">';

            if ( @$_POST['increasePOPS'] == 1 ) { // the user set the increasePOPS setting for memory or time out errors
                echo '<i class="warn-text">('. sprintf(qText('increased by user, was %s'), $fpa['ORIGphpMAXEXECTIME']) .')</i>&nbsp;';

            }

        echo $phpenv['phpMAXEXECTIME'] .' seconds&nbsp;</span>';
        echo '</div></div>';
        echo '</div>';


        echo '<div class="mini-content-box-small" style="">';
        echo '<div style="line-height:10px;font-size:8px;color:#404040;text-shadow: #fff 1px 1px 1px;width:99%;font-weight:bold;padding:1px;padding-right:0px;padding-top:0px;padding-bottom:3px;text-transform:uppercase;">Register Globals:<div style="line-height:9px;text-transform:none!important;float:right;font-size:11px;font-weight:normal;width:60%;background-color:#fff;text-align:right;padding:1px;padding-top:0px;border-bottom-right-radius: 5px;-moz-border-bottom-right-radius: 5px;-webkit-border-bottom-right-radius: 5px;  border-bottom-left-radius: 5px;-moz-border-bottom-left-radius: 5px;-webkit-border-bottom-left-radius: 5px;border-right: 1px solid #42AEC2;border-left: 1px solid #42AEC2;border-bottom: 1px solid #42AEC2;">';
        echo '<span class="normal">'. $phpenv['phpREGGLOBAL'] .'&nbsp;</span>';
        echo '</div></div>';
        echo '</div>';

        echo "<br />";

        echo '<div class="mini-content-box-small" style="">';
        echo '<div style="line-height:10px;font-size:8px;color:#404040;text-shadow: #fff 1px 1px 1px;width:99%;border-bottom: 1px solid #ccebeb;font-weight:bold;padding:1px;padding-top:0px;padding-right:0px;padding-bottom:2px;text-transform:uppercase;">Open Base Path:<div style="float:right;">';
        echo '<span class="normal" style="font-size:9px;font-weight:normal;text-transform:none;">'. $phpenv['phpOPENBASE'] .'&nbsp;</span>';
        echo '</div></div>';
        echo '</div>';


        echo '<div class="mini-content-box-small" style="">';
        echo '<div style="line-height:10px;font-size:8px;color:#404040;text-shadow: #fff 1px 1px 1px;width:99%;border-bottom: 1px solid #ccebeb;font-weight:bold;padding:1px;padding-top:0px;padding-right:0px;padding-bottom:2px;text-transform:uppercase;">Session Path:<div style="float:right;">';
        echo '<span class="normal" style="font-size:9px;font-weight:normal;text-transform:none;">'. $phpenv['phpSESSIONPATH'] .'&nbsp;</span>';
        echo '</div></div>';
        echo '</div>';


        echo '<div class="mini-content-box-small" style="">';
        echo '<div style="line-height:10px;font-size:8px;color:#404040;text-shadow: #fff 1px 1px 1px;width:99%;border-bottom: 1px solid #ccebeb;font-weight:bold;padding:1px;padding-top:0px;padding-right:0px;padding-bottom:2px;text-transform:uppercase;">'
        .'Session Path '. qText('Writable') .':<div style="float:right;">';

            if ( $phpenv['phpSESSIONPATHWRITABLE'] == qText('Yes') ) {
                echo '<span class="ok" style="font-size:9px;font-weight:normal;text-transform:none;">'. $phpenv['phpSESSIONPATHWRITABLE'] .'&nbsp;</span>';

            } elseif ( $phpenv['phpSESSIONPATHWRITABLE'] == qText('No') ) {
                echo '<span class="alert-text" style="font-size:9px;font-weight:normal;text-transform:none;">'. $phpenv['phpSESSIONPATHWRITABLE'] .'&nbsp;</span>';

            } else {
                echo '<span class="warn-text" style="font-size:9px;font-weight:normal;text-transform:none;">'. qText('Unknown') .'&nbsp;</span>';

            }

        echo '</div></div>';
        echo '</div>';


        echo '<div class="mini-content-box-small" style="">';
        echo '<div style="line-height:10px;font-size:8px;color:#404040;text-shadow: #fff 1px 1px 1px;width:99%;border-bottom: 1px solid #ccebeb;font-weight:bold;padding:1px;padding-top:0px;padding-right:0px;padding-bottom:2px;text-transform:uppercase;">INI File Path:<div style="float:right;">';
        echo '<span class="normal" style="font-size:9px;font-weight:normal;text-transform:none;">'. $phpenv['phpINIFILE'] .'&nbsp;</span>';
        echo '</div></div>';
        echo '</div>';

        echo '<div class="mini-content-box-small" style="">';
        echo '<div style="line-height:10px;font-size:8px;color:#404040;text-shadow: #fff 1px 1px 1px;width:99%;border-bottom: 1px solid #ccebeb;font-weight:bold;padding:1px;padding-top:0px;padding-right:0px;padding-bottom:2px;text-transform:uppercase;">'
        .qText('Last known PHP error')
        .':<div style="float:right;">';

            if ( $phpenv['phpLASTERR'] ) {
                echo '<div class="alert" style="margin:5px;font-weight:normal;font-size:9px;padding:2px;text-transform:none;word-wrap: break-word;width:325px;">'. $phpenv['phpLASTERR'] .'</div>';

            } else {
                echo '<span class="ok" style="margin:5px;text-transform:none;font-weight:normal;font-size:9px;padding:2px;">None</span>';
            }

        echo '</div></div>';
        echo '</div>';

        echo '</div></div>';



        /** display the instance information *************************************************/
        echo '<div class="half-section-information-right">'; // start left content block

        echo '<div class="section-title" style="text-align:center;">'. sprintf(qText('%s discovery'), $system['ARRNAME']) .'</div>';
        echo '<div class="" style="width:99%;margin: 0px auto;clear:both;margin-bottom:10px;">';

        echo '<div class="mini-content-box-small" style="">';
        echo '<div style="line-height:10px;font-size:8px;color:#404040;text-shadow: #fff 1px 1px 1px; width:99%;border-bottom:1px solid #ccebeb;font-weight:bold;padding:1px;padding-right:0px;padding-bottom:3px;text-transform:uppercase;">'
        . qText('Platform')
        .':<div style="line-height:11px;text-transform:none!important;float:right;font-size:9px;font-weight:normal;width:60%;background-color:#fff;text-align:right;padding:1px;padding-top:0px;border-top-right-radius: 5px;-moz-border-top-right-radius: 5px;-webkit-border-top-right-radius: 5px;  border-top-left-radius: 5px;-moz-border-top-left-radius: 5px;-webkit-border-top-left-radius: 5px;border-right: 1px solid #42AEC2;border-left: 1px solid #42AEC2;border-top: 1px solid #42AEC2;1px solid #ccebeb;">';
        echo '<span class="normal">'. $system['sysPLATOS'] .'&nbsp;</span>';
        echo '</div></div>';
        echo '</div>';


        echo '<div class="mini-content-box-small" style="">';
        echo '<div style="line-height:10px;font-size:8px;color:#404040;text-shadow: #fff 1px 1px 1px;width:99%;border-bottom:1px solid #ccebeb;font-weight:bold;padding:1px;padding-top:0px;padding-right:0px;padding-bottom:2px;text-transform:uppercase;">'
        . sprintf(qText('%s version'), 'Kernel')
        .':<div style="line-height:11px;text-transform:none!important;float:right;font-size:9px;font-weight:normal;width:60%;background-color:#fff;text-align:right;padding:1px;padding-top:0px;border-right: 1px solid #42AEC2;border-left: 1px solid #42AEC2;1px solid #ccebeb;">';
        echo '<span class="normal">'. $system['sysPLATREL'] .'&nbsp;</span>';
        echo '</div></div>';
        echo '</div>';


        echo '<div class="mini-content-box-small" style="">';
        echo '<div style="line-height:10px;font-size:8px;color:#404040;text-shadow: #fff 1px 1px 1px;width:99%;border-bottom:1px solid #ccebeb;font-weight:bold;padding:1px;padding-top:0px;padding-right:0px;padding-bottom:2px;text-transform:uppercase;">'
        . qText('Technology')
        .':<div style="line-height:11px;text-transform:none!important;float:right;font-size:9px;font-weight:normal;width:60%;background-color:#fff;text-align:right;padding:1px;padding-top:0px;border-right: 1px solid #42AEC2;border-left: 1px solid #42AEC2;1px solid #ccebeb;">';
        echo '<span class="normal">'. $system['sysPLATTECH'] .'&nbsp;</span>';
        echo '</div></div>';
        echo '</div>';


        echo '<div class="mini-content-box-small" style="">';
        echo '<div style="line-height:10px;font-size:8px;color:#404040;text-shadow: #fff 1px 1px 1px;width:99%;border-bottom:1px solid #ccebeb;font-weight:bold;padding:1px;padding-top:0px;padding-right:0px;padding-bottom:2px;text-transform:uppercase;">'
        . qText('Hostname')
        .':<div style="line-height:11px;text-transform:none!important;float:right;font-size:9px;font-weight:normal;width:60%;background-color:#fff;text-align:right;padding:1px;padding-top:0px;border-right: 1px solid #42AEC2;border-left: 1px solid #42AEC2;1px solid #ccebeb;">';

            if ( $showProtected == 1 ) {
                echo '<span class="normal">'. $system['sysPLATNAME'] .'&nbsp;</span>';

            } else {
                echo '<span class="protected">[&nbsp;--&nbsp;'. qText('Protected') .'&nbsp;--&nbsp;]</span>&nbsp;';

            }

        echo '</div></div>';
        echo '</div>';


        echo '<div class="mini-content-box-small" style="">';
        echo '<div style="line-height:10px;font-size:8px;color:#404040;text-shadow: #fff 1px 1px 1px;width:99%;border-bottom: 1px solid #ccebeb;font-weight:bold;padding:1px;padding-top:0px;padding-right:0px;padding-bottom:2px;text-transform:uppercase;">Total Disk Space:<div style="line-height:11px;text-transform:none!important;float:right;font-size:9px;font-weight:normal;width:60%;background-color:#fff;text-align:right;padding:1px;padding-top:0px;border-right: 1px solid #42AEC2;border-left: 1px solid #42AEC2;border-bottom: 1px solid #ccebeb;">';
            if ( function_exists( 'disk_free_space' ) ) {
                $total_space = sprintf( '%.2f', disk_total_space( './' ) /1073741824 );
                echo '<span class="normal">'. $total_space .' GiB&nbsp;</span>';

            } else {
                echo '<span class="normal">'. qText('Unknown') .'&nbsp;</span>';

            }

        echo '</div></div>';
        echo '</div>';


        echo '<div class="mini-content-box-small" style="">';
        echo '<div style="line-height:10px;font-size:8px;color:#404040;text-shadow: #fff 1px 1px 1px;width:99%;border-bottom: 1px solid #ccebeb;font-weight:bold;padding:1px;padding-top:0px;padding-right:0px;padding-bottom:2px;text-transform:uppercase;">Free Disk Space:<div style="line-height:11px;text-transform:none!important;float:right;font-size:9px;font-weight:normal;width:60%;background-color:#fff;text-align:right;padding:1px;padding-top:0px;border-right: 1px solid #42AEC2;border-left: 1px solid #42AEC2;border-bottom: 1px solid #ccebeb;">';
            if ( function_exists( 'disk_free_space' ) ) {

                $free_space = sprintf( '%.2f', disk_free_space( './' ) /1073741824 );
                $percent_free = $free_space ? round($free_space / $total_space, 2) * 100 : 0;

                if ( $percent_free <= '5' ) {
                    $status = 'warn';

                } else {
                    $status = 'normal';

                }

                echo '<span class="normal">(<span class="'. $status .'">'. $percent_free.'%</span>)  '. $free_space .' GiB&nbsp;</span>';
                $system['sysFREESPACE'] = $free_space .' GiB';
            } else {
                echo '<span class="normal">'. qText('Unknown') .'&nbsp;</span>';

            }

        echo '</div></div>';
        echo '</div>';


        echo '<div class="mini-content-box-small" style="">';
        echo '<div style="line-height:10px;font-size:8px;color:#404040;text-shadow: #fff 1px 1px 1px;width:99%;border-bottom:1px solid #ccebeb;font-weight:bold;padding:1px;padding-top:0px;padding-right:0px;padding-bottom:2px;text-transform:uppercase;">'
        . sprintf(qText('Server %s:'), '')
        .':<div style="line-height:11px;text-transform:none!important;float:right;font-size:9px;font-weight:normal;width:60%;background-color:#fff;text-align:right;padding:1px;padding-top:0px;border-right: 1px solid #42AEC2;border-left: 1px solid #42AEC2;1px solid #ccebeb;">';

            if ( $showProtected == 1 ) {
                echo '<span class="normal">'. $system['sysSERVNAME'] .'&nbsp;</span>';

            } else {
                echo '<span class="protected">[&nbsp;--&nbsp;'. qText('Protected') .'&nbsp;--&nbsp;]</span>&nbsp;';

            }

        echo '</div></div>';
        echo '</div>';


        echo '<div class="mini-content-box-small" style="">';
        echo '<div style="line-height:10px;font-size:8px;color:#404040;text-shadow: #fff 1px 1px 1px;width:99%;border-bottom:1px solid #ccebeb;font-weight:bold;padding:1px;padding-top:0px;padding-right:0px;padding-bottom:2px;text-transform:uppercase;">'
        . sprintf(qText('Server %s:'), 'IP')
        .'<div style="line-height:11px;text-transform:none!important;float:right;font-size:9px;font-weight:normal;width:60%;background-color:#fff;text-align:right;padding:1px;padding-top:0px;border-right: 1px solid #42AEC2;border-left: 1px solid #42AEC2;1px solid #ccebeb;">';

            if ( $showProtected == 1 ) {
                echo '<span class="normal">'. $system['sysSERVIP'] .'&nbsp;</span>';

            } else {
                echo '<span class="protected">[&nbsp;--&nbsp;'. qText('Protected') .'&nbsp;--&nbsp;]</span>&nbsp;';

            }

        echo '</div></div>';
        echo '</div>';


        echo '<div class="mini-content-box-small" style="">';
        echo '<div style="line-height:10px;font-size:8px;color:#404040;text-shadow: #fff 1px 1px 1px;width:99%;border-bottom:1px solid #ccebeb;font-weight:bold;padding:1px;padding-top:0px;padding-right:0px;padding-bottom:2px;text-transform:uppercase;">'
        . sprintf(qText('Server %s:'), qText('Signature'))
        .'<div style="line-height:11px;text-transform:none!important;float:right;font-size:9px;font-weight:normal;width:60%;background-color:#fff;text-align:right;padding:1px;padding-top:0px;border-right: 1px solid #42AEC2;border-left: 1px solid #42AEC2;1px solid #ccebeb;">';
        echo '<span class="normal">'. $system['sysSERVSIG'] .'&nbsp;</span>';
        echo '</div></div>';
        echo '</div>';


        echo '<div class="mini-content-box-small" style="">';
        echo '<div style="line-height:10px;font-size:8px;color:#404040;text-shadow: #fff 1px 1px 1px;width:99%;border-bottom:1px solid #ccebeb;font-weight:bold;padding:1px;padding-top:0px;padding-right:0px;padding-bottom:2px;text-transform:uppercase;">'
        . sprintf(qText('Server %s:'), qText('Encoding'))
        .'<div style="line-height:11px;text-transform:none!important;float:right;font-size:9px;font-weight:normal;width:60%;background-color:#fff;text-align:right;padding:1px;padding-top:0px;border-right: 1px solid #42AEC2;border-left: 1px solid #42AEC2;1px solid #ccebeb;">';
        echo '<span class="normal">'. $system['sysENCODING'] .'&nbsp;</span>';
        echo '</div></div>';
        echo '</div>';


        echo '<div class="mini-content-box-small" style="">';
        echo '<div style="line-height:10px;font-size:8px;color:#404040;text-shadow: #fff 1px 1px 1px;width:99%;border-bottom: 1px solid #ccebeb;font-weight:bold;padding:1px;padding-top:0px;padding-right:0px;padding-bottom:2px;text-transform:uppercase;">Executing '
        . qText('User')
        .':<div style="line-height:11px;text-transform:none!important;float:right;font-size:9px;font-weight:normal;width:60%;background-color:#fff;text-align:right;padding:1px;padding-top:0px;border-right: 1px solid #42AEC2;border-left: 1px solid #42AEC2;border-bottom: 1px solid #ccebeb;">';
        echo '<span class="normal">'. $system['sysEXECUSER'] .'&nbsp;</span>';
        echo '</div></div>';
        echo '</div>';


        echo '<div class="mini-content-box-small" style="">';
        echo '<div style="line-height:10px;font-size:8px;color:#404040;text-shadow: #fff 1px 1px 1px;width:99%;font-weight:bold;padding:1px;padding-right:0px;padding-top:0px;padding-bottom:3px;text-transform:uppercase;">'
        . sprintf(qText('Server %s:'), qText('User'))
        .'<div style="line-height:9px;text-transform:none!important;float:right;font-size:11px;font-weight:normal;width:60%;background-color:#fff;text-align:right;padding:1px;padding-top:0px;border-bottom-right-radius: 5px;-moz-border-bottom-right-radius: 5px;-webkit-border-bottom-right-radius: 5px;  border-bottom-left-radius: 5px;-moz-border-bottom-left-radius: 5px;-webkit-border-bottom-left-radius: 5px;border-right: 1px solid #42AEC2;border-left: 1px solid #42AEC2;border-bottom: 1px solid #42AEC2;">';
        echo '<span class="normal">'. $system['sysWEBOWNER'] .'&nbsp;</span>';
        echo '</div></div>';
        echo '</div>';

        echo "<br />";

        echo '<div class="mini-content-box-small" style="">';
        echo '<div style="line-height:10px;font-size:8px;color:#404040;text-shadow: #fff 1px 1px 1px;width:99%;border-bottom: 1px solid #ccebeb;font-weight:bold;padding:1px;padding-top:0px;padding-right:0px;padding-bottom:2px;text-transform:uppercase;">'
        . qText('Document Root')
        .':<div style="float:right;">';


            if ( $showProtected <= 2 ) {
                echo '<span class="normal" style="font-size:9px;font-weight:normal;text-transform:none;">'. $system['sysDOCROOT'] .'&nbsp;</span>';

            } else {
                echo '<span class="protected">[&nbsp;--&nbsp;'. qText('Protected') .'&nbsp;--&nbsp;]</span>&nbsp;';

            }

        echo '</div></div>';
        echo '</div>';


        echo '<div class="mini-content-box-small" style="">';
        echo '<div style="line-height:10px;font-size:8px;color:#404040;text-shadow: #fff 1px 1px 1px;width:99%;border-bottom: 1px solid #ccebeb;font-weight:bold;padding:1px;padding-top:0px;padding-right:0px;padding-bottom:2px;text-transform:uppercase;">'
        . sprintf(qText('Server %s:'), qText('Temp'))
        .'<div style="float:right;">';

            if ( $showProtected <= 2 ) {
                echo '<span class="normal" style="font-size:9px;font-weight:normal;text-transform:none;">'. $system['sysSYSTMPDIR'] .'&nbsp;</span>';

            } else {
                echo '<span class="protected">[&nbsp;--&nbsp;'. qText('Protected') .'&nbsp;--&nbsp;]</span>&nbsp;';

            }

        echo '</div></div>';
        echo '</div>';

        if ( $system['sysTMPDIRWRITABLE'] == qText('Yes') ) {
            $s = '<span class="ok" style="font-size:9px;font-weight:normal;text-transform:none;">'. $system['sysTMPDIRWRITABLE'] .'&nbsp;</span>';

        } elseif ( $system['sysTMPDIRWRITABLE'] == qText('No') ) {
            $s = '<span class="alert-text" style="font-size:9px;font-weight:normal;text-transform:none;">'. $system['sysTMPDIRWRITABLE'] .'&nbsp;</span>';

        } else {
            $s = '<span class="warn-text" style="font-size:9px;font-weight:normal;text-transform:none;">'. qText('Unknown') .'&nbsp;</span>';
        }

        echo '<div class="mini-content-box-small">';
        echo '<div style="line-height:10px;font-size:8px;color:#404040;text-shadow: #fff 1px 1px 1px;width:99%;border-bottom: 1px solid #ccebeb;font-weight:bold;padding:1px;padding-top:0px;padding-right:0px;padding-bottom:2px;text-transform:uppercase;">';
        echo sprintf(qText('Server temp writable: %s'), '<div style="float:right;">'.$s.'</div>');


        echo '</div>';
        echo '</div>';


        echo '<div class="mini-content-box-small" style="">';
        echo '<div style="line-height:10px;font-size:8px;color:#404040;text-shadow: #fff 1px 1px 1px;width:99%;border-bottom: 1px solid #ccebeb;font-weight:bold;padding:1px;padding-top:0px;padding-right:0px;padding-bottom:2px;text-transform:uppercase;">'
        .qText('Switch user configuration')
        .':<div style="float:right;">';
        echo '<div style="clear:both;"></div>';
        echo '<div style="background-color: #fff;border:1px solid #42aec2;border-radius:3px;-moz-border-radius:3px;-webkit-border-radius:3px;text-align:center;margin:2px;width:78px;padding:1px;float:left;font-size:8px;font-weight:normal;">suExec<br /><b>'. $phpenv['phpAPACHESUEXEC'] .'</b></div>';
        echo '<div style="background-color: #fff;border:1px solid #42aec2;border-radius:3px;-moz-border-radius:3px;-webkit-border-radius:3px;text-align:center;margin:2px;width:78px;padding:1px;float:left;font-size:8px;font-weight:normal;">PHP suExec<br /><b>'. $phpenv['phpPHPSUEXEC'] .'</b></div>';
        echo '<div style="background-color: #fff;border:1px solid #42aec2;border-radius:3px;-moz-border-radius:3px;-webkit-border-radius:3px;text-align:center;margin:2px;width:78px;padding:1px;float:left;font-size:8px;font-weight:normal;">Custom su<br /><b>'. $phpenv['phpCUSTOMSU'] .'</b></div>';
        echo '<div style="background-color: #fff;border:1px solid #42aec2;border-radius:3px;-moz-border-radius:3px;-webkit-border-radius:3px;text-align:center;margin:2px;width:78px;padding:1px;float:left;font-size:8px;font-weight:normal;">Ownership Probs<br /><b>';

            if ( $phpenv['phpOWNERPROB'] == qText('No') ) {
                $status = 'ok';

            } elseif ( $phpenv['phpOWNERPROB'] == _FPA_M ) {
                $status = 'warn-text';

            } elseif ( $phpenv['phpOWNERPROB'] == qText('Yes') ) {
                $status = 'alert-text';

            } else {
                $status = 'warn-text';

            }

        echo '<span class="'. $status .'" style="font-size:8px;">'. $phpenv['phpOWNERPROB'] .'</span>';
        echo '</b></div>';
        echo '</div></div>';
        echo '</div>';


        echo '<br style="clear:both;" />';
        echo '</div></div>';


        echo '<br style="clear:both;" />';
        echo '</div>';


    showDev( $phpenv );
    showDev( $system );
?>



<?php
        echo '<div class="section-information">'; // start right content block

        echo '<div class="section-title" style="text-align:center;">' . sprintf(qText('%s discovery'), $phpextensions['ARRNAME']) .'</div>';
        echo '<div class="" style="width:99%;margin: 0px auto;clear:both;margin-bottom:10px;">';

            foreach ( $phpextensions as $key => $show ) {

                if ( $show != $phpextensions['ARRNAME'] ) {

                    if ( $key == 'exif' ) {
                        $pieces = explode( " $", $show );
                        $show = $pieces[0];

                    }


                    // find the requirements and mark them as present or missing
                    if ( $key == 'libxml' OR $key == 'xml' OR $key == 'zip' OR $key == 'openssl' OR $key == 'zlib' OR $key == 'curl' OR $key == 'iconv' OR $key == 'mbstring' OR $key == 'mysql' OR $key == 'mysqli' OR $key == 'mcrypt' OR $key == 'suhosin' OR $key == 'cgi' OR $key == 'cgi-fcgi' ) {
                        $status = 'ok';
                        $border = '4D8000';
                        $background = 'CAFFD8';
                        $weight = 'normal';
                    } elseif ( $key == 'apache2handler' ) {
                        $status = 'warn-text';
                        $border = 'FFA500';
                        $background = 'FFE4B5';
                        $weight = 'bold';
                    } else {
                        $status = 'normal';
                        $border = '42AEC2';
                        $background = 'FFF';
                        $weight = 'normal';
                    }


                    echo '<div style="background-color: #'. $background .';border:1px solid #'. $border .';border-radius:3px;-moz-border-radius:3px;-webkit-border-radius:3px;text-align:center;margin:2px;padding:1px;min-height:20px;width:82px;float:left;font-size:8px;">'
                    .'<span class="'. $status .'" style="font-size:8px;font-weight:'. $weight .';text-shadow:1px 1px 1px #fff;">'. $key .'</span><br />'. $show .'</div>';

                } // endif !arrname


                // look for recommended extensions that aren't installed
                if ( !in_array( $key, $phpreq ) ) {
                    unset ( $phpreq[$key] );
                }

            } // end foreach


            if ( $phpreq ) {
                echo '<br style="clear:both;" /><br />';
                echo '<div class="mini-content-box-small">';
                echo '<div class="warn-text" style="line-height:10px;font-size:9px;text-shadow: #fff 1px 1px 1px;width:99%;border-bottom: 1px solid #ccebeb;font-weight:bold;padding:1px;padding-top:0px;padding-right:0px;padding-bottom:2px;text-transform:uppercase;">'
                . qText('Potential Missing Extensions')
                .':<br /><div style="float:left;text-transform:none;">';

                echo '<br style="clear:both;" />';

                $status = 'warn-text';
                $border = 'FFA500';
                $background = 'FFF';
                $weight = 'bold';


                foreach ( $phpreq as $missingkey => $missing ) {
                    echo '<div style="background-color: #'. $background .';border:1px solid #'. $border .';border-radius:3px;-moz-border-radius:3px;-webkit-border-radius:3px;text-align:center;margin:2px;padding:1px;min-height:10px;width:82px;float:left;font-size:8px;">'
                    .'<span class="'. $status .'" style="font-size:8px;font-weight:'. $weight .';text-shadow:1px 1px 1px #fff;">'. $missingkey .'</span></div>';

                }

                echo '</div></div>';
                echo '</div>';

            }

        echo '<br style="clear:both;" />';
        echo '</div></div>';

    showDev( $phpextensions );
    $phpreq['ARRNAME'] = 'Potential Missing PHP Extensions';

    showDev( $phpreq );
    unset ( $key, $show );
?>



<?php
        if ( $phpenv['phpAPI'] == 'apache2handler' ) {

            /** display the instance information *************************************************/
            echo '<div class="section-information">'; // start right content block
            echo '<div class="section-title" style="text-align:center;">'. $apachemodules['ARRNAME'] .' :: Discovery</div>';
            echo '<div class="" style="width:99%;margin: 0px auto;clear:both;margin-bottom:10px;">';

                foreach ( $apachemodules as $key => $show ) {

                    if ( $show != $apachemodules['ARRNAME'] ) {

                        // find the requirements and mark them as present or missing
                        if ( $show == 'mod_rewrite' OR $show == 'mod_cgi' OR $show == 'mod_cgid' OR $show == 'mod_expires' OR $show == 'mod_deflate' OR $show == 'mod_auth'  ) {
                            $status = 'ok';
                            $border = '4D8000';
                            $background = 'CAFFD8';
                            $weight = 'normal';

                        } elseif ( $show == 'mod_php4' ) {
                            $status = 'warn-text';
                            $border = 'FFA500';
                            $background = 'FFE4B5';
                            $weight = 'bold';

                        } else {
                            $status = 'normal';
                            $border = '42AEC2';
                            $background = 'FFF';
                            $weight = 'normal';

                        }


                        echo '<div class="'. $status .'" style="background-color: #'. $background .';border:1px solid #'. $border .';font-weight: '. $weight .';border-radius:3px;-moz-border-radius:3px;-webkit-border-radius:3px;text-align:center;margin:2px;width:82px;padding:1px;float:left;font-size:8px;">'. $show .'</div>';


                    } // endif !arrname


                    // look for recommended extensions that aren't installed
                    if ( !in_array( $show, $apachereq ) ) {
                        unset ( $apachereq['ARRNAME'] );
                        unset ( $apachereq[$show] );

                    }

                } // end foreach



                if ( $apachereq ) {
                    echo '<br style="clear:both;" /><br />';
                    echo '<div class="mini-content-box-small" style="">';
                    echo '<div class="warn-text" style="line-height:10px;font-size:9px;text-shadow: #fff 1px 1px 1px;width:99%;border-bottom: 1px solid #ccebeb;font-weight:bold;padding:1px;padding-top:0px;padding-right:0px;padding-bottom:2px;text-transform:uppercase;">'
                    . qText('Potential Missing Modules') .':<br />'
                    .'<div style="float:left;text-transform:none;">';

                    echo '<br style="clear:both;" />';

                    $status = 'warn-text';
                    $border = 'FFA500';
                    $background = 'FFF';
                    $weight = 'bold';

                    foreach ( $apachereq as $missingkey => $missing ) {
                        echo '<div style="background-color: #'. $background .';border:1px solid #'. $border .';border-radius:3px;-moz-border-radius:3px;-webkit-border-radius:3px;text-align:center;margin:2px;padding:1px;min-height:10px;width:82px;float:left;font-size:8px;">'
                        .'<span class="'. $status .'" style="font-size:8px;font-weight:'. $weight .';text-shadow:1px 1px 1px #fff;">'. $missingkey .'</span></div>';

                    }

                    echo '</div></div>';
                    echo '</div>';

                }

        echo '<br style="clear:both;" />';
        echo '</div></div>';

        showDev( $apachemodules );
        $apachereq['ARRNAME'] = 'Potential Missing Apache Modules';

        showDev( $apachereq );
        unset ( $key, $show );

        }
?>



<?php
    /** display the mode-set details for each core folder ********************************/
    echo '<div class="section-information">';
    echo '<div class="section-title" style="text-align:center;">'. $folders['ARRNAME'] .' '. $modecheck['ARRNAME'] .'</div>';

    echo '<div class="column-title-container" style="width:99%;margin: 0px auto;clear:both;display:block;">';
    // this is the column heading area, if any

    echo '<div class="column-title" style="width:7%;float:left;text-align:center;">'. qText('Mode') .'</div>';
    echo '<div class="column-title" style="width:8%;float:left;left;text-align:center;">'. qText('Writable') .'</div>';
    echo '<div class="column-title" style="width:58%;float:left;">'. qText('Folder') .'</div>';
    echo '<div class="column-title" style="width:12%;float:right;text-align:center;">'. qText('Group') .'</div>';
    echo '<div class="column-title" style="width:12%;float:right;text-align:center;">'. qText('Owner') .'</div>';
    echo '<div style="clear:both;"></div>';
    echo '</div>';

    // only do mode/permissions checks if an instance was found in the intial checks
    if ( $instance['instanceFOUND'] == qText('Yes') ) {
    // this is the content area

        foreach ( $folders as $i => $show ) {

            if ( $show != 'Core Folders' ) {

                // looking for --7 or -7- or -77 (default folder permissions are usually 755)
                if ( substr( $modecheck[$show]['mode'],1 ,1 ) == '7' OR substr( $modecheck[$show]['mode'],2 ,1 ) == '7' ) {
                    $modeClass = 'alert';
                    $alertClass = 'alert-text';
                    $userClass = 'normal';
                    $groupClass = 'normal';
                } elseif ( $modecheck[$show]['mode'] == '755' ) {
                    $modeClass = 'ok';
                    $alertClass = 'normal';
                    $userClass = 'normal';
                    $groupClass = 'normal';
                } else if ( substr( $modecheck[$show]['mode'],0 ,1 ) <= '5' AND $modecheck[$show]['mode'] != '---' ) {
                    $modeClass = 'warn';
                    $alertClass = 'warn-text';
                    $userClass = 'normal';
                    $groupClass = 'normal';
                } else if ( $modecheck[$show]['group']['name'] == qText('No') ) {
                    $modeClass = 'warn-text';
                    $alertClass = 'warn-text';
                    $userClass = 'warn-text';
                    $groupClass = 'warn-text';
                } else {
                    $modeClass = 'normal';
                    $alertClass = 'normal';
                    $userClass = 'normal';
                    $groupClass = 'normal';
                }

                // is the folder writable?
                if ( ( $modecheck[$show]['writable'] != qText('Yes') ) ) {
                    $writeClass = 'warn-text';
                } elseif ( ( $modecheck[$show]['writable'] == qText('Yes') ) AND ( substr( $modecheck[$show]['mode'],0 ,1 ) == '7' ) ) {
                    $writeClass = 'normal';
                } elseif ( $modecheck[$show]['writable'] == qText('No') ) {
                    $writeClass = 'ok';
                }

                // is the 'executing' owner the same as the folder owner? and is the users groupID the same as the folders groupID?
                if ( ( $modecheck[$show]['owner']['name'] != $system['sysEXECUSER'] ) AND ( $modecheck[$show]['group']['name'] != _FPA_DNE ) ) {
                    $userClass = 'warn-text';
                    $groupClass = 'normal';
                } elseif ( isset( $modecheck[$show]['group']['gid'] ) AND isset( $modecheck[$show]['owner']['gid'] ) ) {

                    if ( $modecheck[$show]['group']['gid'] != $modecheck[$show]['owner']['gid'] ) {
                        $userClass = 'normal';
                        $groupClass = 'warn-text';
                    }

                } elseif ( $modecheck[$show]['group']['name'] == _FPA_DNE ) {
                    $modeClass = 'warn-text';
                    $alertClass = 'warn-text';
                    $writeClass = 'warn-text';
                    $userClass = 'warn-text';
                    $groupClass = 'warn-text';
                }

                // produce the output
                echo '<div style="border-bottom:1px dotted #C0C0C0;width:99%;margin: 0px auto;padding-top:1px;padding-bottom:1px;clear:both;">';

                echo '<div class="column-content '. $modeClass .'" style="float:left;width:7%;text-align:center;">';
                echo $modecheck[$show]['mode'];  // display the mode
                echo '</div>';

                echo '<div class="column-content '. $writeClass .'" style="width:8%;float:left;text-align:center;">';
                echo $modecheck[$show]['writable'];  // display if writable
                echo '</div>';

                echo '<div class="column-content '. $alertClass .'" style="width:58%;float:left;padding-left:5px;">';

                    if ( $showProtected <= 2 ) {
                        echo $show;  // display the folder name
                    } else {
                        echo '<span class="protected">[&nbsp;--&nbsp;'. qText('Protected') .'&nbsp;--&nbsp;]</span>';
                    }

                echo '</div>';

                echo '<div class="column-content '. $groupClass .'" style="float:right;width:12%;text-align:center;">';
                echo $modecheck[$show]['group']['name'];  // display the group
                echo '</div>';

                echo '<div class="column-content '. $userClass .'"" style="float:right;width:12%;text-align:center;">';
                echo $modecheck[$show]['owner']['name'];  // display the owner
                echo '</div>';

                echo '<div style="clear:both;"></div>';
                echo '</div>';
            }
        }

    } else { // an instance wasn't found in the initial checks, so no folders to check
        echo '<div style="text-align:center;border-bottom:1px dotted #C0C0C0;width:99%;margin: 0px auto;padding-top:1px;padding-bottom:1px;clear:both;font-size: 11px;">';
        echo '<div class="warn" style=" margin-top:10px;margin-bottom:10px;">'. qText('Instance Not Found') .', '. sprintf(qText('No %s tests performed'), $modecheck['ARRNAME']) .'</div>';
        echo '</div>';
    }

    echo '</div>';
    echo '<div style="clear:both;"></div>';

    // !TODO fix missing heading properly rather than this messy work-around
    $folders['ARRNAME'] = 'Core Folders';
    showDev( $folders );
    showDev( $modecheck );
    unset ( $key, $show );
?>


<?php
    /** display the folders with elevated permissions ************************************/
    if ( $showElevated == '1' ) {

        echo '<div class="section-information">';
        echo '<div class="section-title" style="text-align:center;">'. $elevated['ARRNAME'] .' ('. sprintf(qText('First %d'), 10) .')</div>';

        echo '<div class="column-title-container" style="width:99%;margin: 0px auto;clear:both;display:block;">';

        echo '<div class="column-title" style="width:7%;float:left;text-align:center;">'. qText('Mode') .'</div>';
        echo '<div class="column-title" style="width:8%;float:left;left;text-align:center;">'. qText('Writable') .'</div>';
        echo '<div class="column-title" style="width:58%;float:left;">'. qText('Folder') .'</div>';
        echo '<div style="clear:both;"></div>';
        echo '</div>';


        // only do mode/permissions checks if an instance was found in the intial checks
        if ( $instance['instanceFOUND'] == qText('Yes') ) {

            foreach ( $elevated as $key => $show ) {

                if ( $show != $elevated['ARRNAME'] ) {

                    // looking for --7 or -7- or -77 (default folder permissions are usually 755)
                    if ( substr( $show['mode'],1 ,1 ) == '7' OR substr( $show['mode'],2 ,1 ) == '7' ) {
                        $modeClass = 'alert';
                        $alertClass = 'alert-text';
                    } else {
                        $modeClass = 'normal';
                        $alertClass = 'normal';
                    }

                    // is the folder writable?
                    if ( ( $show['writable'] == qText('Yes') ) ) {
                        $writeClass = 'alert-text';
                    } else {
                        $writeClass = 'warn-text';
                    }

                    // hilite the "cancelled processing" message, after 25 elevated folders (limited to save resources on a really bad site
//                    if ( substr( $key, 0, 4 ) == '*PRO' ) {
//                        $alertClass = 'alert';
//                    }

                    echo '<div style="border-bottom:1px dotted #C0C0C0;width:99%;margin: 0px auto;padding-top:1px;padding-bottom:1px;clear:both;">';

                    echo '<div class="column-content '. $modeClass .'" style="float:left;width:7%;text-align:center;">';
                    echo $show['mode'];  // display the mode
                    echo '</div>';

                    echo '<div class="column-content '. $writeClass .'" style="width:8%;float:left;text-align:center;">';
                    echo $show['writable'];  // display if writable
                    echo '</div>';

                    echo '<div class="column-content '. $alertClass .'" style="width:58%;float:left;padding-left:5px;">';

                        if ( $showProtected <= 2 ) {

                            if ( $key == 'None' ) {
                                echo '<span style="color:#008000"><b>'. $key .'</b></span>';
                            } else {
                                echo $key .'/ (';
                            }

//                        }
//                            echo $key;  // display the folder name

                        } else {
                            echo '<span class="protected">[&nbsp;--&nbsp;'. qText('Protected') .'&nbsp;--&nbsp;]</span>';
                        }

                    echo '</div>';

                    echo '<div style="clear:both;"></div>';
                    echo '</div>';

                } // endif ARRNAME

            } // end for each


        } else { // an instance wasn't found in the initial checks, so no folders to check
            echo '<div style="text-align:center;border-bottom:1px dotted #C0C0C0;width:99%;margin: 0px auto;padding-top:1px;padding-bottom:1px;clear:both;font-size: 11px;">';
            echo '<div class="warn" style=" margin-top:10px;margin-bottom:10px;">'. qText('Instance Not Found') .', '. sprintf(qText('No %s tests performed'), $elevated['ARRNAME']) .'</div>';
            echo '</div>';
        }

        echo '</div>';
        echo '<div style="clear:both;"></div>';

        showDev( $elevated );
        unset ( $key, $show );
    } // endif showElevated
?>














<?php
    if ( $showComponents == '1' ) {

        echo '<div class="section-information">';

        echo '<div class="section-title" style="text-align:center;">'. $component['ARRNAME'] .' :: '. qText('SITE') .'</div>';

        echo '<div class="column-title-container" style="width:99%;margin: 0px auto;clear:both;display:block;">';
        echo '<div class="column-title" style="width:20%;float:left;text-align:left;">'. qText('Name') .'</div>';
        echo '<div class="column-title" style="width:14%;float:left;text-align:center;">'. qText('Version') .'</div>';
        echo '<div class="column-title" style="width:14%;float:left;">'. qText('Created') .'</div>';
        echo '<div class="column-title" style="width:14%;float:left;">'. qText('Author') .'</div>';
        echo '<div class="column-title" style="width:19%;float:left;">'. qText('Address') .'</div>';
        echo '<div class="column-title" style="width:10%;float:right;text-align:center;">'. qText('Status') .'</div>';
        echo '<div style="clear:both;"></div>';
        echo '</div>';


        echo '<div class="" style="width:99%;margin: 0px auto;clear:both;margin-bottom:10px;">';


        echo '<div class="mini-content-box-small" style="">';
        if ( $instance['instanceFOUND'] == qText('Yes') ) { // an instance wasn't found in the initial checks, so no folders to check

            foreach ( $component['SITE'] as $key => $show ) {

                if ( $show['type'] != '3rd Party' ) {
                    $typeColor = '404040';
                } else {
                    $typeColor = '000080';
                }

                echo '<div style="line-height:10px;font-size:8px;color:#404040;text-shadow: #fff 1px 1px 1px;border-bottom:1px solid #ccebeb;padding:1px;padding-right:0px;padding-bottom:3px;">';

                if ( $showProtected <= 2 ) {
                    echo '<div style="float:left;width:20%;color:#'. $typeColor .';">'. $show['name'] .'</div>'
                    .'<div style="float:left;width:15%;text-align:center;color:#'. $typeColor .';">'. $show['version'] .'</div>'
                    .'<div style="float:left;width:15%;color:#'. $typeColor .';">'. $show['creationDate'] .'</div>'
                    .'<div style="float:left;width:15%;color:#'. $typeColor .';">'. $show['author'] .'</div>'
                    .'<div style="float:left;width:20%;color:#'. $typeColor .';">'. $show['authorUrl'] .'</div>'
                    .'<div style="float:right;width:10%;color:#'. $typeColor .';text-align:center;">'. $show['type'] .'</div><br />';
                } else {
                    echo '<div style="float:left;width:20%;color:#'. $typeColor .';">'
                    .'<span class="protected">[&nbsp;--&nbsp;'. qText('Protected') .'&nbsp;--&nbsp;]</span>'
                    .'</div>'
                    .'<div style="float:left;width:15%;text-align:center;color:#'. $typeColor .';">'. $show['version'] .'</div>'
                    .'<div style="float:left;width:15%;color:#'. $typeColor .';">'. $show['creationDate'] .'</div>'
                    .'<div style="float:left;width:15%;color:#'. $typeColor .';">'. $show['author'] .'</div>'
                    .'<div style="float:left;width:20%;color:#'. $typeColor .';">'. $show['authorUrl'] .'</div>'
                    .'<div style="float:right;width:10%;color:#'. $typeColor .';text-align:center;">'. $show['type'] .'</div><br />';
                }

                echo '</div>';
            }

        } else {
            echo '<div style="text-align:center;border-bottom:1px dotted #C0C0C0;width:99%;margin: 0px auto;padding-top:1px;padding-bottom:1px;clear:both;font-size: 11px;">';
            echo '<div class="warn" style=" margin-top:10px;margin-bottom:10px;">'. qText('Instance Not Found') .', '. sprintf(qText('No %s tests performed'), $component['ARRNAME']) .'</div>';
            echo '</div>';
        }

        echo '</div></div>';




        echo '<br style="clear:both;" />';
        echo '<div class="section-title" style="text-align:center;">'. $component['ARRNAME'] .' :: '. qText('ADMIN') .'</div>';

        echo '<div class="column-title-container" style="width:99%;margin: 0px auto;clear:both;display:block;">';
        echo '<div class="column-title" style="width:20%;float:left;text-align:left;">'. qText('Name') .'</div>';
        echo '<div class="column-title" style="width:14%;float:left;text-align:center;">'. qText('Version') .'</div>';
        echo '<div class="column-title" style="width:14%;float:left;">'. qText('Credentials') .'</div>';
        echo '<div class="column-title" style="width:14%;float:left;">'. qText('Author') .'</div>';
        echo '<div class="column-title" style="width:19%;float:left;">'. qText('Address') .'</div>';
        echo '<div class="column-title" style="width:10%;float:right;text-align:center;">'. qText('Status') .'</div>';
        echo '<div style="clear:both;"></div>';
        echo '</div>';

        echo '<div class="" style="width:99%;margin: 0px auto;clear:both;margin-bottom:10px;">';
        if ( $instance['instanceFOUND'] == qText('Yes') ) { // an instance wasn't found in the initial checks, so no folders to check

            foreach ( $component['ADMIN'] as $key => $show ) {

                if ( $show['type'] != _FPA_3PD ) {
                    $typeColor = '404040';
                } else {
                    $typeColor = '000080';
                }

                echo '<div style="line-height:10px;font-size:8px;color:#404040;text-shadow: #fff 1px 1px 1px;border-bottom:1px solid #ccebeb;padding:1px;padding-right:0px;padding-bottom:3px;">';

                if ( $showProtected <= 2 ) {
                    echo '<div style="float:left;width:20%;color:#'. $typeColor .';">'. $show['name'] .'</div>'
                    .'<div style="float:left;width:15%;text-align:center;color:#'. $typeColor .';">'. $show['version'] .'</div>'
                    .'<div style="float:left;width:15%;color:#'. $typeColor .';">'. $show['creationDate'] .'</div>'
                    .'<div style="float:left;width:15%;color:#'. $typeColor .';">'. $show['author'] .'</div>'
                    .'<div style="float:left;width:20%;color:#'. $typeColor .';">'. $show['authorUrl'] .'</div>'
                    .'<div style="float:right;width:10%;color:#'. $typeColor .';text-align:center;">'. $show['type'] .'</div><br />';
                } else {
                    echo '<div style="float:left;width:20%;color:#'. $typeColor .';">'
                    .'<span class="protected">[&nbsp;--&nbsp;'. qText('Protected') .'&nbsp;--&nbsp;]</span>'
                    .'</div>'
                    .'<div style="float:left;width:15%;text-align:center;color:#'. $typeColor .';">'. $show['version'] .'</div>'
                    .'<div style="float:left;width:15%;color:#'. $typeColor .';">'. $show['creationDate'] .'</div>'
                    .'<div style="float:left;width:15%;color:#'. $typeColor .';">'. $show['author'] .'</div>'
                    .'<div style="float:left;width:20%;color:#'. $typeColor .';">'. $show['authorUrl'] .'</div>'
                    .'<div style="float:right;width:10%;color:#'. $typeColor .';text-align:center;">'. $show['type'] .'</div><br />';
                }

                echo '</div>';
            }


        } else {
//        if ( $instance['instanceFOUND'] == qText('No') ) { // an instance wasn't found in the initial checks, so no folders to check
            echo '<div style="text-align:center;border-bottom:1px dotted #C0C0C0;width:99%;margin: 0px auto;padding-top:1px;padding-bottom:1px;clear:both;font-size: 11px;">';
            echo '<div class="warn" style=" margin-top:10px;margin-bottom:10px;">'. qText('Instance Not Found') .', '. sprintf(qText('No %s tests performed'), $component['ARRNAME']) .'</div>';
            echo '</div>';
        }


        echo '</div></div>';



        echo '<br style="clear:both;" />';
        echo '</div></div>';
        // end content left block


    echo '<div style="clear:both;"></div>';

    showDev( $component );
    unset ( $key, $show );
    echo '</div>'; // end half-section container

    echo '<div style="clear:both;"></div>';

    } // end showComponents
?>










<?php
    if ( $showModules == '1' ) {

        echo '<div class="section-information">';

        echo '<div class="section-title" style="text-align:center;">'. $module['ARRNAME'] .' :: '. qText('SITE') .'</div>';

        echo '<div class="column-title-container" style="width:99%;margin: 0px auto;clear:both;display:block;">';
        echo '<div class="column-title" style="width:20%;float:left;text-align:left;">'. qText('Name') .'</div>';
        echo '<div class="column-title" style="width:14%;float:left;text-align:center;">'. qText('Version') .'</div>';
        echo '<div class="column-title" style="width:14%;float:left;">'. qText('Credentials') .'</div>';
        echo '<div class="column-title" style="width:14%;float:left;">'. qText('Author') .'</div>';
        echo '<div class="column-title" style="width:19%;float:left;">'. qText('Address') .'</div>';
        echo '<div class="column-title" style="width:10%;float:right;text-align:center;">'. qText('Status') .'</div>';
        echo '<div style="clear:both;"></div>';
        echo '</div>';


        echo '<div class="" style="width:99%;margin: 0px auto;clear:both;margin-bottom:10px;">';


        echo '<div class="mini-content-box-small" style="">';
        if ( $instance['instanceFOUND'] == qText('Yes') ) { // an instance wasn't found in the initial checks, so no folders to check

            foreach ( $module['SITE'] as $key => $show ) {

                if ( $show['type'] != _FPA_3PD ) {
                    $typeColor = '404040';
                } else {
                    $typeColor = '000080';
                }

                echo '<div style="line-height:10px;font-size:8px;color:#404040;text-shadow: #fff 1px 1px 1px;border-bottom:1px solid #ccebeb;padding:1px;padding-right:0px;padding-bottom:3px;">';

                if ( $showProtected <= 2 ) {
                    echo '<div style="float:left;width:20%;color:#'. $typeColor .';">'. $show['name'] .'</div>'
                    .'<div style="float:left;width:15%;text-align:center;color:#'. $typeColor .';">'. $show['version'] .'</div>'
                    .'<div style="float:left;width:15%;color:#'. $typeColor .';">'. $show['creationDate'] .'</div>'
                    .'<div style="float:left;width:15%;color:#'. $typeColor .';">'. $show['author'] .'</div>'
                    .'<div style="float:left;width:20%;color:#'. $typeColor .';">'. $show['authorUrl'] .'</div>'
                    .'<div style="float:right;width:10%;color:#'. $typeColor .';text-align:center;">'. $show['type'] .'</div><br />';
                } else {
                    echo '<div style="float:left;width:20%;color:#'. $typeColor .';">'
                    .'<span class="protected">[&nbsp;--&nbsp;'. qText('Protected') .'&nbsp;--&nbsp;]</span>'
                    .'</div>'
                    .'<div style="float:left;width:15%;text-align:center;color:#'. $typeColor .';">'. $show['version'] .'</div>'
                    .'<div style="float:left;width:15%;color:#'. $typeColor .';">'. $show['creationDate'] .'</div>'
                    .'<div style="float:left;width:15%;color:#'. $typeColor .';">'. $show['author'] .'</div>'
                    .'<div style="float:left;width:20%;color:#'. $typeColor .';">'. $show['authorUrl'] .'</div>'
                    .'<div style="float:right;width:10%;color:#'. $typeColor .';text-align:center;">'. $show['type'] .'</div><br />';
                }

                echo '</div>';
            }

        } else {
            echo '<div style="text-align:center;border-bottom:1px dotted #C0C0C0;width:99%;margin: 0px auto;padding-top:1px;padding-bottom:1px;clear:both;font-size: 11px;">';
            echo '<div class="warn" style=" margin-top:10px;margin-bottom:10px;">'. qText('Instance Not Found') .', '. sprintf(qText('No %s tests performed'), $module['ARRNAME']) .'</div>';
            echo '</div>';
        }

        echo '</div></div>';




        echo '<div style="clear:both;"></div>';
        echo '<div class="section-title" style="text-align:center;">'. $module['ARRNAME'] .' :: '. qText('ADMIN') .'</div>';

        echo '<div class="column-title-container" style="width:99%;margin: 0px auto;clear:both;display:block;">';
        echo '<div class="column-title" style="width:20%;float:left;text-align:left;">'. qText('Name') .'</div>';
        echo '<div class="column-title" style="width:14%;float:left;text-align:center;">'. qText('Version') .'</div>';
        echo '<div class="column-title" style="width:14%;float:left;">'. qText('Credentials') .'</div>';
        echo '<div class="column-title" style="width:14%;float:left;">'. qText('Author') .'</div>';
        echo '<div class="column-title" style="width:19%;float:left;">'. qText('Address') .'</div>';
        echo '<div class="column-title" style="width:10%;float:right;text-align:center;">'. qText('Status') .'</div>';
        echo '<div style="clear:both;"></div>';
        echo '</div>';

        echo '<div class="" style="width:99%;margin: 0px auto;clear:both;margin-bottom:10px;">';
        if ( $instance['instanceFOUND'] == qText('Yes') ) { // an instance wasn't found in the initial checks, so no folders to check

            foreach ( $module['ADMIN'] as $key => $show ) {

                if ( $show['type'] != _FPA_3PD ) {
                    $typeColor = '404040';
                } else {
                    $typeColor = '000080';
                }

                echo '<div style="line-height:10px;font-size:8px;color:#404040;text-shadow: #fff 1px 1px 1px;border-bottom:1px solid #ccebeb;padding:1px;padding-right:0px;padding-bottom:3px;">';

                if ( $showProtected <= 2 ) {
                    echo '<div style="float:left;width:20%;color:#'. $typeColor .';">'. $show['name'] .'</div>'
                    .'<div style="float:left;width:15%;text-align:center;color:#'. $typeColor .';">'. $show['version'] .'</div>'
                    .'<div style="float:left;width:15%;color:#'. $typeColor .';">'. $show['creationDate'] .'</div>'
                    .'<div style="float:left;width:15%;color:#'. $typeColor .';">'. $show['author'] .'</div>'
                    .'<div style="float:left;width:20%;color:#'. $typeColor .';">'. $show['authorUrl'] .'</div>'
                    .'<div style="float:right;width:10%;color:#'. $typeColor .';text-align:center;">'. $show['type'] .'</div><br />';
                } else {
                    echo '<div style="float:left;width:20%;color:#'. $typeColor .';">'
                    .'<span class="protected">[&nbsp;--&nbsp;'. qText('Protected') .'&nbsp;--&nbsp;]</span>'
                    .'</div>'
                    .'<div style="float:left;width:15%;text-align:center;color:#'. $typeColor .';">'. $show['version'] .'</div>'
                    .'<div style="float:left;width:15%;color:#'. $typeColor .';">'. $show['creationDate'] .'</div>'
                    .'<div style="float:left;width:15%;color:#'. $typeColor .';">'. $show['author'] .'</div>'
                    .'<div style="float:left;width:20%;color:#'. $typeColor .';">'. $show['authorUrl'] .'</div>'
                    .'<div style="float:right;width:10%;color:#'. $typeColor .';text-align:center;">'. $show['type'] .'</div><br />';
                }

                echo '</div>';
            }

        } else {
            echo '<div style="text-align:center;border-bottom:1px dotted #C0C0C0;width:99%;margin: 0px auto;padding-top:1px;padding-bottom:1px;clear:both;font-size: 11px;">';
            echo '<div class="warn" style=" margin-top:10px;margin-bottom:10px;">'. qText('Instance Not Found') .', '. sprintf(qText('No %s tests performed'), $module['ARRNAME']) .'</div>';
            echo '</div>';
        }

        echo '</div></div>';



        echo '<br style="clear:both;" />';
        echo '</div></div>';
        // end content left block


    echo '<div style="clear:both;"></div>';

    showDev( $module );
    unset ( $key, $show );
    echo '</div>'; // end half-section container

    echo '<div style="clear:both;"></div>';

    } // end showModules
?>










<?php
    if ( $showPlugins == '1' ) {

        echo '<div class="section-information">';

        echo '<div class="section-title" style="text-align:center;">'. $plugin['ARRNAME'] .' :: '. qText('SITE') .'</div>';

        echo '<div class="column-title-container" style="width:99%;margin: 0px auto;clear:both;display:block;">';
        echo '<div class="column-title" style="width:20%;float:left;text-align:left;">'. qText('Name') .'</div>';
        echo '<div class="column-title" style="width:14%;float:left;text-align:center;">'. qText('Version') .'</div>';
        echo '<div class="column-title" style="width:14%;float:left;">'. qText('Credentials') .'</div>';
        echo '<div class="column-title" style="width:14%;float:left;">'. qText('Author') .'</div>';
        echo '<div class="column-title" style="width:19%;float:left;">'. qText('Address') .'</div>';
        echo '<div class="column-title" style="width:10%;float:right;text-align:center;">'. qText('Status') .'</div>';
        echo '<div style="clear:both;"></div>';
        echo '</div>';


        echo '<div class="" style="width:99%;margin: 0px auto;clear:both;margin-bottom:10px;">';



        echo '<div class="mini-content-box-small" style="">';
        if ( $instance['instanceFOUND'] == qText('Yes') ) { // an instance wasn't found in the initial checks, so no folders to check

            foreach ( $plugin['SITE'] as $key => $show ) {

                if ( $show['type'] != _FPA_3PD ) {
                    $typeColor = '404040';
                } else {
                    $typeColor = '000080';
                }

                echo '<div style="line-height:10px;font-size:8px;color:#404040;text-shadow: #fff 1px 1px 1px;border-bottom:1px solid #ccebeb;padding:1px;padding-right:0px;padding-bottom:3px;">';

                if ( $showProtected <= 2 ) {
                    echo '<div style="float:left;width:20%;color:#'. $typeColor .';">'. $show['name'] .'</div>'
                    .'<div style="float:left;width:15%;text-align:center;color:#'. $typeColor .';">'. $show['version'] .'</div>'
                    .'<div style="float:left;width:15%;color:#'. $typeColor .';">'. $show['creationDate'] .'</div>'
                    .'<div style="float:left;width:15%;color:#'. $typeColor .';">'. $show['author'] .'</div>'
                    .'<div style="float:left;width:20%;color:#'. $typeColor .';">'. $show['authorUrl'] .'</div>'
                    .'<div style="float:right;width:10%;color:#'. $typeColor .';text-align:center;">'. $show['type'] .'</div><br />';
                } else {
                    echo '<div style="float:left;width:20%;color:#'. $typeColor .';">'
                    .'<span class="protected">[&nbsp;--&nbsp;'. qText('Protected') .'&nbsp;--&nbsp;]</span>'
                    .'</div>'
                    .'<div style="float:left;width:15%;text-align:center;color:#'. $typeColor .';">'. $show['version'] .'</div>'
                    .'<div style="float:left;width:15%;color:#'. $typeColor .';">'. $show['creationDate'] .'</div>'
                    .'<div style="float:left;width:15%;color:#'. $typeColor .';">'. $show['author'] .'</div>'
                    .'<div style="float:left;width:20%;color:#'. $typeColor .';">'. $show['authorUrl'] .'</div>'
                    .'<div style="float:right;width:10%;color:#'. $typeColor .';text-align:center;">'. $show['type'] .'</div><br />';
                }

                echo '</div>';
            }

        } else {
            echo '<div style="text-align:center;border-bottom:1px dotted #C0C0C0;width:99%;margin: 0px auto;padding-top:1px;padding-bottom:1px;clear:both;font-size: 11px;">';
            echo '<div class="warn" style=" margin-top:10px;margin-bottom:10px;">'. qText('Instance Not Found') .', '. sprintf(qText('No %s tests performed'), $plugin['ARRNAME']) .'</div>';
            echo '</div>';
        }

        echo '</div></div>';


        echo '<br style="clear:both;" />';
        echo '</div></div>';
        // end content left block


    echo '<div style="clear:both;"></div>';

    showDev( $plugin );
    unset ( $key, $show );
    echo '</div>'; // end half-section container

    echo '<div style="clear:both;"></div>';

    } // end showPlugins










    echo '<div class="section-information">';

    echo '<div class="section-title" style="text-align:center;">'. $template['ARRNAME'] .' :: '. qText('SITE') .'</div>';

    echo '<div class="column-title-container" style="width:99%;margin: 0px auto;clear:both;display:block;">';
    echo '<div class="column-title" style="width:20%;float:left;text-align:left;">'. qText('Name') .'</div>';
    echo '<div class="column-title" style="width:14%;float:left;text-align:center;">'. qText('Version') .'</div>';
    echo '<div class="column-title" style="width:14%;float:left;">'. qText('Credentials') .'</div>';
    echo '<div class="column-title" style="width:14%;float:left;">'. qText('Author') .'</div>';
    echo '<div class="column-title" style="width:19%;float:left;">'. qText('Address') .'</div>';
    echo '<div class="column-title" style="width:10%;float:right;text-align:center;">'. qText('Status') .'</div>';
    echo '<div style="clear:both;"></div>';
    echo '</div>';


    echo '<div class="" style="width:99%;margin: 0px auto;clear:both;margin-bottom:10px;">';


    echo '<div class="mini-content-box-small" style="">';
    if ( $instance['instanceFOUND'] == qText('Yes') ) { // an instance wasn't found in the initial checks, so no folders to check

        foreach ( $template['SITE'] as $key => $show ) {

            if ( $show['type'] != _FPA_3PD ) {
                $typeColor = '404040';
            } else {
                $typeColor = '000080';
            }

            echo '<div style="line-height:10px;font-size:8px;color:#404040;text-shadow: #fff 1px 1px 1px;border-bottom:1px solid #ccebeb;padding:1px;padding-right:0px;padding-bottom:3px;">';

            if ( $showProtected <= 2 ) {
                echo '<div style="float:left;width:20%;color:#'. $typeColor .';">'. $show['name'] .'</div>'
                .'<div style="float:left;width:15%;text-align:center;color:#'. $typeColor .';">'. $show['version'] .'</div>'
                .'<div style="float:left;width:15%;color:#'. $typeColor .';">'. $show['creationDate'] .'</div>'
                .'<div style="float:left;width:15%;color:#'. $typeColor .';">'. $show['author'] .'</div>'
                .'<div style="float:left;width:20%;color:#'. $typeColor .';">'. $show['authorUrl'] .'</div>'
                .'<div style="float:right;width:10%;color:#'. $typeColor .';text-align:center;">'. $show['type'] .'</div><br />';
            } else {
                echo '<div style="float:left;width:20%;color:#'. $typeColor .';">'
                .'<span class="protected">[&nbsp;--&nbsp;'. qText('Protected') .'&nbsp;--&nbsp;]</span>'
                .'</div>'
                .'<div style="float:left;width:15%;text-align:center;color:#'. $typeColor .';">'. $show['version'] .'</div>'
                .'<div style="float:left;width:15%;color:#'. $typeColor .';">'. $show['creationDate'] .'</div>'
                .'<div style="float:left;width:15%;color:#'. $typeColor .';">'. $show['author'] .'</div>'
                .'<div style="float:left;width:20%;color:#'. $typeColor .';">'. $show['authorUrl'] .'</div>'
                .'<div style="float:right;width:10%;color:#'. $typeColor .';text-align:center;">'. $show['type'] .'</div><br />';
            }

            echo '</div>';
        }

    } else {
        echo '<div style="text-align:center;border-bottom:1px dotted #C0C0C0;width:99%;margin: 0px auto;padding-top:1px;padding-bottom:1px;clear:both;font-size: 11px;">';
        echo '<div class="warn" style=" margin-top:10px;margin-bottom:10px;">'. qText('Instance Not Found') .', '. sprintf(qText('No %s tests performed'), $template['ARRNAME']) .'</div>';
        echo '</div>';
    }

    echo '</div></div>';




    echo '<div style="clear:both;"></div>';
    echo '<div class="section-title" style="text-align:center;">'. $template['ARRNAME'] .' :: '. qText('ADMIN') .'</div>';

    echo '<div class="column-title-container" style="width:99%;margin: 0px auto;clear:both;display:block;">';
    echo '<div class="column-title" style="width:20%;float:left;text-align:left;">'. qText('Name') .'</div>';
    echo '<div class="column-title" style="width:14%;float:left;text-align:center;">'. qText('Version') .'</div>';
    echo '<div class="column-title" style="width:14%;float:left;">'. qText('Credentials') .'</div>';
    echo '<div class="column-title" style="width:14%;float:left;">'. qText('Author') .'</div>';
    echo '<div class="column-title" style="width:19%;float:left;">'. qText('Address') .'</div>';
    echo '<div class="column-title" style="width:10%;float:right;text-align:center;">'. qText('Status') .'</div>';
    echo '<div style="clear:both;"></div>';
    echo '</div>';

    echo '<div class="" style="width:99%;margin: 0px auto;clear:both;margin-bottom:10px;">';

    if ( $instance['instanceFOUND'] == qText('Yes') ) { // an instance wasn't found in the initial checks, so no folders to check

        foreach ( @$template['ADMIN'] as $key => $show ) {

            if ( $show['type'] != _FPA_3PD ) {
                $typeColor = '404040';
            } else {
                $typeColor = '000080';
            }

            echo '<div style="line-height:10px;font-size:8px;color:#404040;text-shadow: #fff 1px 1px 1px;border-bottom:1px solid #ccebeb;padding:1px;padding-right:0px;padding-bottom:3px;">';

            if ( $showProtected <= 2 ) {
                echo '<div style="float:left;width:20%;color:#'. $typeColor .';">'. $show['name'] .'</div>'
                .'<div style="float:left;width:15%;text-align:center;color:#'. $typeColor .';">'. $show['version'] .'</div>'
                .'<div style="float:left;width:15%;color:#'. $typeColor .';">'. $show['creationDate'] .'</div>'
                .'<div style="float:left;width:15%;color:#'. $typeColor .';">'. $show['author'] .'</div>'
                .'<div style="float:left;width:20%;color:#'. $typeColor .';">'. $show['authorUrl'] .'</div>'
                .'<div style="float:right;width:10%;color:#'. $typeColor .';text-align:center;">'. $show['type'] .'</div><br />';
            } else {
                echo '<div style="float:left;width:20%;color:#'. $typeColor .';">'
                .'<span class="protected">[&nbsp;--&nbsp;'. qText('Protected') .'&nbsp;--&nbsp;]</span>'
                .'</div>'
                .'<div style="float:left;width:15%;text-align:center;color:#'. $typeColor .';">'. $show['version'] .'</div>'
                .'<div style="float:left;width:15%;color:#'. $typeColor .';">'. $show['creationDate'] .'</div>'
                .'<div style="float:left;width:15%;color:#'. $typeColor .';">'. $show['author'] .'</div>'
                .'<div style="float:left;width:20%;color:#'. $typeColor .';">'. $show['authorUrl'] .'</div>'
                .'<div style="float:right;width:10%;color:#'. $typeColor .';text-align:center;">'. $show['type'] .'</div><br />';
            }

            echo '</div>';
        }

    } else {
        echo '<div style="text-align:center;border-bottom:1px dotted #C0C0C0;width:99%;margin: 0px auto;padding-top:1px;padding-bottom:1px;clear:both;font-size: 11px;">';
        echo '<div class="warn" style=" margin-top:10px;margin-bottom:10px;">'. qText('Instance Not Found') .', '. sprintf(qText('No %s tests performed'), $template['ARRNAME']) .'</div>';
        echo '</div>';
    }

    echo '</div>';

    echo '<div style="clear:both;"></div>';
    // end content left block

    echo '<div style="clear:both;"></div>';

    showDev( $template );

    unset ( $key, $show );

    echo '</div>'; // end half-section container

    echo '<div style="clear:both;"></div>';

showDev( $fpa );

/**@@FPA_DEVINFO@@**/

/*
 * pieces/legend.php
 */
echo '<div class="snapshot-information" style="text-align:center;color:#4D8000!important;padding-top:10px;">';
echo '<span class="header-title">'. qText('Legends and Settings') .'</span>';
echo '<div style="width:85%;margin:0 auto;margin-top:10px;">';

// LEGENDS
echo '<div class="half-section-container" style="clear:both;width:100%;">';
echo '<div class="ok-hilite" style="text-align:center;width:21%;float:left;margin-left:10px;margin-right:10px;">'. qText('OK/GOOD') .'</div>';
echo '<div class="warn" style="text-align:center;width:21%;float:left;margin-left:10px;margin-right:10px;">'. qText('WARNINGS') .'</div>';
echo '<div class="alert" style="text-align:center;width:21%;float:left;margin-left:10px;margin-right:10px;">'. qText('ALERTS') .'</div>';
echo '<div class="protected" style="text-align:center;width:21%;float:left;margin-left:10px;margin-right:10px;">[&nbsp;--&nbsp;'. qText('Protected') .'&nbsp;--&nbsp;]</div>';
echo '</div>';
echo '<div style="clear:both;"><br /></div>';


// SELECTIONS
echo '<div style="font-weight:bold;width:25%;float:left;text-align:center;">Developer-Mode<br />';
if ( defined ( '_FPA_DEV' ) ) {
    echo '<div class="normal-note">'. qText('Enabled') .'</div>';
} else {
    echo '<div class="normal-note">'. qText('Disabled') .' (<i style="color:#808080;">'. qText('Default') .'</i> )</div>';
}
echo '</div>';

echo '<div style="font-weight:bold;width:25%;float:left;text-align:center;">'. qText('Information Privacy') .'<br />';
if ( $showProtected == 1 ) {
    echo '<div class="normal-note"><span class="ok">'. qText('None') .'</span></div>';
} elseif ( $showProtected == 2 ) {
    echo '<div class="normal-note"><span class="warn-text">'. qText('Partial') .'</span> (<i style="color:#808080;">'. qText('Default') .'</i> )</div>';
} elseif ( $showProtected >= 3 ) {
    echo '<div class="normal-note"><span class="alert-text">'. qText('Strict') .'</span></div>';
}
echo '</div>';

echo '<div style="font-weight:bold;width:25%;float:left;text-align:center;">'. qText('Elevated Permissions') .'<br />';
if ( $showElevated == 1 ) {
    echo '<div class="normal-note">'. qText('Show') .'</div>';
} else {
    echo '<div class="normal-note">'. qText('Hide') .' (<i style="color:#808080;">'. qText('Default') .'</i> )</div>';
}
echo '</div>';

echo '<div style="font-weight:bold;width:25%;float:left;text-align:center;">'. qText('Table Structure') .'<br />';
if ( $showTables == '1' ) {
    echo '<div class="normal-note">'. qText('Show') .'</div>';
} else {
    echo '<div class="normal-note">'. qText('Hide') .' (<i style="color:#808080;">'. qText('Default') .'</i> )</div>';
}
echo '</div>';

echo '<div style="clear:both;"></div>';

echo '<div style="font-weight:bold;width:25%;float:left;text-align:center;">Diagnostic-Mode<br />';
if ( defined ( '_FPA_DIAG' ) ) {
    echo '<div class="normal-note">'. qText('Enabled') .'</div>';
} else {
    echo '<div class="normal-note">'. qText('Disabled') .' (<i style="color:#808080;">'. qText('Default') .'</i> )</div>';
}
echo '</div>';

echo '<div style="font-weight:bold;width:25%;float:left;text-align:center;">'. qText('Components') .'<br />';
if ( $showComponents == '1' ) {
    echo '<div class="normal-note">'. qText('Show') .'</div>';
} else {
    echo '<div class="normal-note">'. qText('Hide') .' (<i style="color:#808080;">'. qText('Default') .'</i> )</div>';
}
echo '</div>';

echo '<div style="font-weight:bold;width:25%;float:left;text-align:center;">'. qText('Modules') .'<br />';
if ( $showModules == '1' ) {
    echo '<div class="normal-note">'. qText('Show') .'</div>';
} else {
    echo '<div class="normal-note">'. qText('Hide') .' (<i style="color:#808080;">'. qText('Default') .'</i> )</div>';
}
echo '</div>';

echo '<div style="font-weight:bold;width:25%;float:left;text-align:center;">'. qText('Plugins') .'<br />';
if ( $showPlugins == '1' ) {
    echo '<div class="normal-note">'. qText('Show') .'</div>';
} else {
    echo '<div class="normal-note">'. qText('Hide') .' (<i style="color:#808080;">'. qText('Default') .'</i> )</div>';
}
echo '</div>';

echo '</div>';
echo '<div style="clear:both;"><br /></div>';

echo '<div style="text-align:center!important;">';
echo '<a style="color:#4D8000!important;" href="'. _RES_FPALINK .'">'. _RES_FPALATEST .' '. _RES .'</a>';
echo '</div>';
echo '</div>';

?>

</form>

</div><!-- outer -->

</body>

</html>

<?php
function discoverInstance($system)
{
    $instance = array();

    $instance['configDBTYPE'] = '';
    $instance['configDBHOST'] = '';

    /** DETERMINE INSTANCE STATUS & VERSIONING ************************************************
     ** here we check for known files to determine if an instance even exists, then we look for
     ** the version and configuration files. some differ between between versions, so we have a
     ** bit of jiggling to do.
     ** to try and avoid "white-screens" fpa no-longer "includes" these files, but merely tries
     ** to open and read them, although this is slower, it improves the reliability of fpa.
     *****************************************************************************************/

    /** is an instance present? **************************************************************/
    // this is a two-fold sanity check, we look two pairs of known folders, only one pair need exist
    // this caters for the potential of missing folders, but is not exhaustive or too time consuming
    if ( ( file_exists( 'components/' ) AND file_exists( 'modules/' ) )
    OR ( file_exists( 'administrator/components/' ) AND file_exists( 'administrator/modules/' ) ) ) {
        $instance['instanceFOUND'] = qText('Yes');
    } else {
        $instance['instanceFOUND'] = qText('No');
    }



    /** what version is the instance? ********************************************************/
    // J1.0 includes/version.php & mambots folder
    if ( file_exists( 'includes/version.php' ) AND file_exists( 'mambots/' ) ) {
        $instance['cmsVFILE'] = 'includes/version.php';

        // J1.5 libraries/joomla/version.php & xmlrpc folder
    } elseif ( file_exists( 'libraries/joomla/version.php' ) AND file_exists( 'xmlrpc/' ) ) {
        $instance['cmsVFILE'] = 'libraries/joomla/version.php';

        // J1.5 & Nooku Server libraries/joomla/version.php & koowa folder
    } elseif ( file_exists( 'libraries/joomla/version.php' ) AND file_exists( 'libraries/koowa/koowa.php' ) ) {
        $instance['cmsVFILE'] = 'libraries/joomla/version.php';

        // J1.6 libraries/joomla/version.php & joomla.xml files
    } elseif ( file_exists( 'libraries/joomla/version.php' ) AND file_exists( 'joomla.xml' ) ) {
        $instance['cmsVFILE'] = 'libraries/joomla/version.php';

        // J1.7 includes/version.php & libraries/joomla/platform.php files
    } elseif ( file_exists( 'includes/version.php' ) AND file_exists( 'libraries/platform.php' ) ) {
        $instance['cmsVFILE'] = 'includes/version.php';

        // fpa could find the required files to determine version(s)
    } else {
        $instance['cmsVFILE'] = qText('No');

    }



    /** what version is the framework? (J!1.7 & above) ***************************************/
    // J1.7 libraries/joomla/platform.php
    if ( file_exists( 'libraries/platform.php' ) ) {
        $instance['platformVFILE'] = 'libraries/platform.php';

        // J1.5 Nooku Server libraries/koowa/koowa.php
    } elseif ( file_exists( 'libraries/koowa/koowa.php' ) ) {
        $instance['platformVFILE'] = 'libraries/koowa/koowa.php';

    } else {
        $instance['platformVFILE'] = qText('No');
    }



    // read the cms version file into $cmsVContent (all versions)
    if ( $instance['cmsVFILE'] != qText('No') ) {
        $cmsVContent = file_get_contents( $instance['cmsVFILE'] );

        // find the basic cms information
        preg_match ( '#\$PRODUCT.*=\s[\'|\"](.*)[\'|\"];#', $cmsVContent, $cmsPRODUCT );
        preg_match ( '#\$RELEASE.*=\s[\'|\"](.*)[\'|\"];#', $cmsVContent, $cmsRELEASE );
        preg_match ( '#\$(DEV_LEVEL.*|MAINTENANCE.*)=\s[\'|\"](.*)[\'|\"];#', $cmsVContent, $cmsDEVLEVEL );
        preg_match ( '#\$(DEV_STATUS.*|STATUS.*)=\s[\'|\"](.*)[\'|\"];#', $cmsVContent, $cmsDEVSTATUS );
        preg_match ( '#\$(CODENAME.*|CODE_NAME.*)=\s[\'|\"](.*)[\'|\"];#', $cmsVContent, $cmsCODENAME );
        preg_match ( '#\$(RELDATE.*|RELEASE_DATE.*)=\s[\'|\"](.*)[\'|\"];#', $cmsVContent, $cmsRELDATE );

        $instance['cmsPRODUCT'] = $cmsPRODUCT[1];
        $instance['cmsRELEASE'] = $cmsRELEASE[1];
        $instance['cmsDEVLEVEL'] = $cmsDEVLEVEL[2];
        $instance['cmsDEVSTATUS'] = $cmsDEVSTATUS[2];
        $instance['cmsCODENAME'] = $cmsCODENAME[2];
        $instance['cmsRELDATE'] = $cmsRELDATE[2];
    }



    // read the platform version file into $platformVContent (J!1.7 & above only)
    if ( $instance['platformVFILE'] != qText('No') ) {
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
            preg_match ( '#PRODUCT.*=\s[\'|\"](.*)[\'|\"];#', $platformVContent, $platformPRODUCT );
            preg_match ( '#RELEASE.*=\s[\'|\"](.*)[\'|\"];#', $platformVContent, $platformRELEASE );
            preg_match ( '#MAINTENANCE.*=\s[\'|\"](.*)[\'|\"];#', $platformVContent, $platformDEVLEVEL );
            preg_match ( '#STATUS.*=\s[\'|\"](.*)[\'|\"];#', $platformVContent, $platformDEVSTATUS );
            preg_match ( '#CODE_NAME.*=\s[\'|\"](.*)[\'|\"];#', $platformVContent, $platformCODENAME );
            preg_match ( '#RELEASE_DATE.*=\s[\'|\"](.*)[\'|\"];#', $platformVContent, $platformRELDATE );

            $instance['platformPRODUCT'] = $platformPRODUCT[1];
            $instance['platformRELEASE'] = $platformRELEASE[1];
            $instance['platformDEVLEVEL'] = $platformDEVLEVEL[1];
            $instance['platformDEVSTATUS'] = $platformDEVSTATUS[1];
            $instance['platformCODENAME'] = $platformCODENAME[1];
            $instance['platformRELDATE'] = $platformRELDATE[1];
        }
    }



    /** is Joomla! installed/configured? *****************************************************/
    // determine exactly where the REAL configuration file is, it might not be the one in the "/" folder
    if ( @$instance['cmsRELEASE'] == '1.0' ) {

        // !TODO add finding configuration outside of "/"
        if ( file_exists( 'configuration.php' ) ) {
            //          $configContent = file_get_contents( 'configuration.php' );

            //              if ( preg_match( '#require.*[\"|\'](.*)[\"|\']#', $configContent ) ) {
            //                  preg_match ( '#require.*[\"|\'](.*)[\"|\']#', $configContent, $findConfig );

            //                  $instance['configPATH'] =  dirname( __FILE__ ) . $findConfig[1];
            //              } else {
            //                  $instance['configPATH'] =  dirname( __FILE__ ) .'/'. $findConfig[1];
            //              }

            //                  $instance['configMOVED'] = qText('Yes');
            //              } else {
            //                  $instance['configMOVED'] = qText('No');
            $instance['configPATH'] = 'configuration.php';
            //              }

        }

    } elseif ( @$instance['cmsRELEASE'] == '1.5' ) {
        $instance['configPATH'] = 'configuration.php';

    } elseif ( @$instance['cmsRELEASE'] >= '1.6' ) {

        // look for a 'defines' override file in the "/" folder.
        if ( file_exists( 'defines.php' ) ) {
            $instance['configPATH'] = 'configuration.php';

        } elseif ( file_exists( 'includes/defines.php' ) ) {
            $instance['configPATH'] = 'configuration.php';

        } else {
            $instance['configDEFINE'] = qText('Not Found');
            $instance['configPATH'] = 'configuration.php';
        }

    } else {
        $instance['configPATH'] = 'configuration.php';
        $instance['configMOVED'] = qText('No');
    }


    // find the configuration file (all versions)
    if ( file_exists( $instance['configPATH'] ) ) {
        $instance['instanceCONFIGURED'] = qText('Yes');

        // determine it's ownership and mode
        if ( is_writable( $instance['configPATH'] ) ) {
            $instance['configWRITABLE']	= qText('Yes');

        } else {
            $instance['configWRITABLE']	= qText('No');

        }


        $instance['configMODE'] = substr( sprintf('%o', fileperms( $instance['configPATH'] ) ),-3, 3 );


        if ( function_exists( 'posix_getpwuid' ) AND $system['sysSHORTOS'] != 'WIN' ) {
            // gets the UiD and converts to 'name' on non Windows systems
            $instance['configOWNER'] = posix_getpwuid( fileowner( $instance['configPATH'] ) );
            $instance['configGROUP'] = posix_getgrgid( filegroup( $instance['configPATH'] ) );

        } else { // only get the UiD for Windows, not 'name'
            $instance['configOWNER']['name'] = fileowner( $instance['configPATH'] );
            $instance['configGROUP']['name'] = filegroup( $instance['configPATH'] );
        }


        /** if present, is the configuration file valid? *****************************************/
        $cmsCContent = file_get_contents( $instance['configPATH'] );

        if ( preg_match ( '#(\$mosConfig_)#', $cmsCContent ) ) {
            $instance['configVALIDFOR'] = '1.0';

        } elseif ( preg_match ( '#(var)#', $cmsCContent ) ) {
            $instance['configVALIDFOR'] = '1.5';

        } elseif ( preg_match ( '#(public)#', $cmsCContent ) AND $instance['platformVFILE'] == qText('No') ) {
            $instance['configVALIDFOR'] = '1.6';

        } elseif ( preg_match ( '#(public)#', $cmsCContent ) AND $instance['platformVFILE'] != qText('No') ) {
            $instance['configVALIDFOR'] = '1.7 and above';

        } else {
            $instance['configVALIDFOR'] = _FPA_U;
        }

        // fpa found a configuration.php but couldn't determine the version, is it valid?
        if ( $instance['configVALIDFOR'] == _FPA_U ) {

            if ( filesize( 'configuration.php' ) < 512 ) {
                $instance['configSIZEVALID'] = qText('No');
            }
        }


        // check if the configuration.php version matches the discovered version
        if ( $instance['configVALIDFOR'] != _FPA_U AND $instance['cmsVFILE'] != qText('No') ) {

            if ( version_compare( $instance['cmsRELEASE'], substr( $instance['configVALIDFOR'],0,3 ), '==' ) ) {
                $instance['instanceCFGVERMATCH'] = qText('Yes');

            } else {
                $instance['instanceCFGVERMATCH'] = qText('No');
            }


            // set defaults for the configuration's validity and a sanity score of zero
            $instance['configSANE'] = qText('No');
            $instance['configSANITYSCORE'] = 0;


            // !TODO add white-space etc checks
            // do some configuration.php sanity/validity checks
            if ( filesize( 'configuration.php' ) > 512 ) {
                $instance['cfgSANITY']['configSIZEVALID'] = qText('Yes');
            }

            // !TODO FINISH  white-space etc checks
            $instance['cfgSANITY']['configNOTDIST'] = qText('Yes');   // is not the distribution example
            $instance['cfgSANITY']['configNOWSPACE'] = qText('Yes');  // no white-space
            $instance['cfgSANITY']['configOPTAG'] = qText('Yes');     // has php open tag
            $instance['cfgSANITY']['configCLTAG'] = qText('Yes');     // has php close tag
            $instance['cfgSANITY']['configJCONFIG'] = qText('Yes');   // has php close tag

            // run through the sanity checks, if sane ( =Yes ) increment the score by 1 (should total 6)
            foreach ( $instance['cfgSANITY'] as $i => $sanityCHECK ) {

                if ( $instance['cfgSANITY'][$i] == qText('Yes') ) {
                    $instance['configSANITYSCORE'] = $instance['configSANITYSCORE'] +1;
                }
            }

            // if the configuration file is sane, set it as valid
            if ( $instance['configSANITYSCORE'] == '6' ) {
                $instance['configSANE'] = qText('Yes');   // configuration appears valid?
            }

        } else {
            $instance['instanceCFGVERMATCH'] = _FPA_U;
        }

        // common configuration variables for J!1.5 and above only
        if ( $instance['configVALIDFOR'] != _FPA_U ) {

            // common configuration variable across all versions
            preg_match ( '#\$(mosConfig_offline.*|offline.*)=\s[\'|\"](.*)[\'|\"];#', $cmsCContent, $configOFFLINE );
            preg_match ( '#\$(mosConfig_sef.*|sef.*)=\s[\'|\"](.*)[\'|\"];#', $cmsCContent, $configSEF );
            preg_match ( '#\$(mosConfig_gzip.*|gzip.*)=\s[\'|\"](.*)[\'|\"];#', $cmsCContent, $configGZIP );
            preg_match ( '#\$(mosConfig_caching.*|caching.*)=\s[\'|\"](.*)[\'|\"];#', $cmsCContent, $configCACHING );
            preg_match ( '#\$(mosConfig_error_reporting.*|error_reporting.*)=\s[\'|\"](.*)[\'|\"];#', $cmsCContent, $configERRORREP );
            preg_match ( '#\$(mosConfig_debug.*|debug.*)=\s[\'|\"](.*)[\'|\"];#', $cmsCContent, $configSITEDEBUG );
            preg_match ( '#dbtype.*=\s[\'|\"](.*)[\'|\"];#', $cmsCContent, $configDBTYPE );

            // J!1.0 assumed 'mysql' with no variable, so we'll just add it
            if (!array_key_exists('1', $configDBTYPE)) {
                $configDBTYPE[1] = 'mysql';
            }

            preg_match ( '#\$(mosConfig_host.*|host.*)=\s[\'|\"](.*)[\'|\"];#', $cmsCContent, $configDBHOST );
            preg_match ( '#\$(mosConfig_db.*|db\s.*)=\s[\'|\"](.*)[\'|\"];#', $cmsCContent, $configDBNAME );
            preg_match ( '#\$(mosConfig_dbprefix.*|dbprefix.*)=\s[\'|\"](.*)[\'|\"];#', $cmsCContent, $configDBPREF );
            preg_match ( '#\$(mosConfig_user.*|user.*)=\s[\'|\"](.*)[\'|\"];#', $cmsCContent, $configDBUSER );
            preg_match ( '#\$(mosConfig_password.*|password.*)=\s[\'|\"](.*)[\'|\"];#', $cmsCContent, $configDBPASS );

            $instance['configOFFLINE'] = $configOFFLINE[2];
            $instance['configSEF'] = $configSEF[2];
            $instance['configGZIP'] = $configGZIP[2];
            $instance['configCACHING'] = $configCACHING[2];
            $instance['configERRORREP'] = $configERRORREP[2];
            $instance['configSITEDEBUG'] = $configSITEDEBUG[2];
            $instance['configDBTYPE'] = $configDBTYPE[1];
            $instance['configDBHOST'] = $configDBHOST[2];
            $instance['configDBNAME'] = $configDBNAME[2];
            $instance['configDBPREF'] = $configDBPREF[2];
            $instance['configDBUSER'] = $configDBUSER[2];
            $instance['configDBPASS'] = $configDBPASS[2];

            // force all the configuration settings that are either depreciated or unused by the lowest support release (ie: J!1.0)
            $instance['configLANGDEBUG'] = _FPA_NA;
            $instance['configSEFSUFFIX'] = _FPA_NA;
            $instance['configSEFRWRITE'] = _FPA_NA;
            $instance['configFTP'] = _FPA_NA;
            $instance['configSSL'] = _FPA_NA;
            $instance['configACCESS'] = _FPA_NA;
            $instance['configUNICODE'] = _FPA_NA;
            // these forced settings will be over-written later by the variable supported release
        }

        // common configuration variables for J!1.5 and above only
        if ( $instance['configVALIDFOR'] != '1.0' AND $instance['configVALIDFOR'] != _FPA_U ) {

            preg_match ( '#sef_rewrite.*=\s[\'|\"](.*)[\'|\"];#', $cmsCContent, $configSEFREWRITE );
            preg_match ( '#sef_suffix.*=\s[\'|\"](.*)[\'|\"];#', $cmsCContent, $configSEFSUFFIX );
            preg_match ( '#debug_lang.*=\s[\'|\"](.*)[\'|\"];#', $cmsCContent, $configLANGDEBUG );
            preg_match ( '#ftp_enable.*=\s[\'|\"](.*)[\'|\"];#', $cmsCContent, $configFTP );
            preg_match ( '#force_ssl.*=\s[\'|\"](.*)[\'|\"];#', $cmsCContent, $configSSL );

            $instance['configSEFRWRITE'] = $configSEFREWRITE[1];
            $instance['configSEFSUFFIX'] = $configSEFSUFFIX[1];
            $instance['configLANGDEBUG'] = $configLANGDEBUG[1];
            $instance['configFTP'] = $configFTP[1];

            if ( $configSSL ) {
                // 1.7 hack, 1.7.0 seems not to have this option
                $instance['configSSL'] = $configSSL[1];

            } else {
                $instance['configSSL'] = _FPA_NA;
            }
        }

        // common configuration variables for J!1.6 and above only
        if ( $instance['configVALIDFOR'] != '1.0'
        AND $instance['configVALIDFOR'] != '1.5'
        AND $instance['configVALIDFOR'] != _FPA_U ) {

            preg_match ( '#access.*=\s[\'|\"](.*)[\'|\"];#', $cmsCContent, $configACCESS );
            preg_match ( '#unicodeslugs.*=\s[\'|\"](.*)[\'|\"];#', $cmsCContent, $configUNICODE );

            $instance['configACCESS'] = $configACCESS[1];
            $instance['configUNICODE'] = $configUNICODE[1];
        }

        // check if all the DB credentials are complete
        if ( $instance['configDBTYPE']
        AND $instance['configDBHOST']
        AND $instance['configDBNAME']
        AND $instance['configDBPREF']
        AND $instance['configDBUSER']
        AND $instance['configDBPASS'] ) {
            $instance['configDBCREDOK'] = qText('Yes');

        } else {
            $instance['configDBCREDOK'] = qText('No');
        }



        // looking for htaccess (Apache and some others) or web.config (IIS)
        if ( $system['sysSHORTWEB'] != 'MIC' ) {

            // htaccess files
            if ( file_exists( '.htaccess' ) ) {
                $instance['configSITEHTWC'] = qText('Yes');

            } else {
                $instance['configSITEHTWC'] = qText('No');
            }

            if ( file_exists( 'administrator/.htaccess' ) ) {
                $instance['configADMINHTWC'] = qText('Yes');

            } else {
                $instance['configADMINHTWC'] = qText('No');

            }

        } else {

            // web.config file
            if ( file_exists( 'web.config' ) ) {
                $instance['configSITEHTWC'] = qText('Yes');
                $instance['configADMINHTWC'] = _FPA_NA;

            } else {
                $instance['configSITEHTWC'] = qText('No');
                $instance['configADMINHTWC'] = _FPA_NA;
            }
        }
    } else { // no configuration.php found
        $instance['instanceCONFIGURED'] = qText('No');
        $instance['configVALIDFOR'] = _FPA_U;
    }

    return $instance;

}

/**
 * Discover the PHP environment
 */
function discoverPhpEnv($instance, $system)
{
    $phpenv = array();

    $phpenv['phpVERSION'] = phpversion();

    $phpenv['phpLASTERR']       = '';
    $phpenv['phpLASTERRDATE']   = '';
    $phpenv['phpERRORDISPLAY']  = ini_get( 'display_errors' );
    $phpenv['phpERRORREPORT']   = ini_get( 'error_reporting' );
    $phpenv['phpERRLOGFILE']    = ini_get( 'error_log' );

    /** DETERMINE PHP ENVIRONMENT & SETTINGS ***********************************************
     ** here we try to determine the php enviroment and configuration
     ** to try and avoid "white-screens" fpa tries to check for function availability before
     ** using any function, but this does mean it has grown in size quite a bit and unfortunately
     ** gets a little messy in places.
     *****************************************************************************************/

    /** general php related settings? *****************************************************/
    if ( version_compare( PHP_VERSION, '5.0', '>=' ) ) {
        $phpenv['phpSUPPORTSMYSQLI'] = qText('Yes');

    } elseif ( version_compare( PHP_VERSION, '4.4.9', '<=' ) ) {
        $phpenv['phpSUPPORTSMYSQLI'] = qText('No');

    } else {
        $phpenv['phpSUPPORTSMYSQLI'] = _FPA_U;
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
    // if open_basedir is in effect, don't bother doing session_save.path test, will error if path not in open_basedir
    if ( isset( $phpenv['phpOPENBASE'] ) ) {

        // is the session_save.path writable to this user?
        if ( is_writable( session_save_path() ) ) {
            $phpenv['phpSESSIONPATHWRITABLE'] = qText('Yes');

        } else {
            $phpenv['phpSESSIONPATHWRITABLE'] = qText('No');
        }

    } else {
        $phpenv['phpSESSIONPATHWRITABLE'] = _FPA_U;
    }

    // input and upload related settings
    $phpenv['phpUPLOADS']           = ini_get( 'file_uploads' );
    $phpenv['phpMAXUPSIZE']         = ini_get( 'upload_max_filesize' );
    $phpenv['phpMAXPOSTSIZE']       = ini_get( 'post_max_size' );
    $phpenv['phpMAXINPUTTIME']      = ini_get( 'max_input_time' );
    $phpenv['phpMAXEXECTIME']       = ini_get( 'max_execution_time' );
    $phpenv['phpMEMLIMIT']          = ini_get( 'memory_limit' );
    $phpenv['phpDISABLED']          = ini_get( 'disable_functions' );  // !TODO add this ti the display somewhere

    /** API and ownership related settings ***************************************************/
    $phpenv['phpAPI']               = php_sapi_name();

    // looking for php to be installed as a CGI or CGI/Fast
    if (substr($phpenv['phpAPI'], 0, 3) == 'cgi') {
        $phpenv['phpCGI'] = qText('Yes');

        // looking for the Apache "suExec" utility
        if ( ( $system['sysCURRUSER'] === $system['sysWEBOWNER'] ) AND ( substr($phpenv['phpAPI'], 0, 3) == 'cgi' ) ) {
            $phpenv['phpAPACHESUEXEC'] = qText('Yes');
            $phpenv['phpOWNERPROB'] = qText('No');

        } else {
            $phpenv['phpAPACHESUEXEC'] = qText('No');
            $phpenv['phpOWNERPROB'] = _FPA_M;
        }

        // looking for the "phpsuExec" utility
        if ( ( $system['sysCURRUSER'] === $system['sysEXECUSER'] ) AND ( substr($phpenv['phpAPI'], 0, 3) == 'cgi' ) ) {
            $phpenv['phpPHPSUEXEC'] = qText('Yes');
            $phpenv['phpOWNERPROB'] = qText('No');

        } else {
            $phpenv['phpPHPSUEXEC'] = qText('No');
            $phpenv['phpOWNERPROB'] = _FPA_M;
        }

    } else {
        $phpenv['phpCGI'] = qText('No');
        $phpenv['phpAPACHESUEXEC'] = qText('No');
        $phpenv['phpPHPSUEXEC'] = qText('No');
        $phpenv['phpOWNERPROB'] = _FPA_M;
    }

    /** WARNING WILL ROBINSON! ****************************************************************
     ** THIS IS A TEST FEATURE AND AS SUCH NOT GUARANTEED TO BE 100% ACCURATE
     ** try and cater for custom "su" environments, like cluster, grid and cloud computing.
     ** this would include weird ownership combinations that allow group access to non-owner files
     ** (like GoDaddy and a couple of grid and cloud providers I know of)
     *****************************************************************************************/
    if ( ( $instance['instanceCONFIGURED'] == qText('Yes') )
    AND ( $system['sysCURRUSER'] != $instance['configOWNER']['name'] )
    AND ( $instance['configWRITABLE'] == qText('Yes') )
    AND ( ( substr( $instance['configMODE'],0 ,1 ) < '6' )
    OR ( substr( $instance['configMODE'],1 ,1 ) < '6' )
    OR ( substr( $instance['configMODE'],2 ,1 ) <= '6' ) ) ) {
        $phpenv['phpCUSTOMSU'] = _FPA_M;
        $phpenv['phpOWNERPROB'] = qText('No');

    } else {
        $phpenv['phpCUSTOMSU'] = qText('No');
        $phpenv['phpOWNERPROB'] = _FPA_M;
    }
    /*****************************************************************************************/
    /** THIS IS A TEST FEATURE AND AS SUCH NOT GUARANTEED TO BE 100% ACCURATE ****************/
    /*****************************************************************************************/

    /** DETERMINE IF THERE IS A KNOWN ERROR ALREADY *******************************************
     ** here we try and determine if there is an existing php error log file, if there is we
     ** then look to see how old it is, if it's less than one day old, lets see if what the last
     ** error this and try and auto-enter that as the problem description
     *****************************************************************************************/

    /** is there an existing php error-log file? *********************************************/
    if ( file_exists( $phpenv['phpERRLOGFILE'] ) ) {
        // when was the file last modified?
        $phpenv['phpLASTERRDATE'] = date ("dS F Y H:i:s.", filemtime( $phpenv['phpERRLOGFILE'] ));

        // determine the number of seconds for one day
        $age = 1 * 60*60*24;
        // get the modified time in seconds
        $file_time = filemtime( $phpenv['phpERRLOGFILE'] );
        // get the current time in seconds
        $now_time = time();

        // if the file was modified less than one day ago, grab the last error entry
        if ( $file_time - $now_time < $age ) {
            // !FIXME memory allocation error on large php_error file
            $lines = file( $phpenv['phpERRLOGFILE'] );
            $phpenv['phpLASTERR'] = array_pop( $lines );
        }
    }

    return $phpenv;
}


/** DETERMINE SYSTEM ENVIRONMENT & SETTINGS ***********************************************
 ** here we try to determine the hosting enviroment and configuration
 ** to try and avoid "white-screens" fpa tries to check for function availability before
 ** using any function, but this does mean it has grown in size quite a bit and unfortunately
 ** gets a little messy in places.
 *****************************************************************************************/
function discoverSystem()
{
    $system = array();

    // WIN, DAR, LIN, SOL
    $system['sysSHORTOS'] = strtoupper( substr( PHP_OS, 0, 3 ) );

    // APA = Apache, MIC = MS IIS, LIT = LiteSpeed etc
    $system['sysSHORTWEB'] = strtoupper( substr( $_SERVER['SERVER_SOFTWARE'], 0, 3 ) );

    /** what server and os is the host? ******************************************************/

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

        // Windows work-around for not using EXEC User (this limits the cpability of discovering SU Environments though)
        $system['sysEXECUSER'] = $system['sysCURRUSER'];
    }


    // looking for the Apache "suExec" Utility
    if ( function_exists( 'exec' ) AND $system['sysSHORTOS'] != 'WIN' ) {
        // find the owner of the current process running this script
        $system['sysWEBOWNER'] = exec("whoami");

    } elseif ( function_exists( 'passthru' ) AND $system['sysSHORTOS'] != 'WIN' ) {
        $system['sysWEBOWNER'] = passthru("whoami");

    } else {
        // We'll have to give up if we can't 'exec' or 'passthru' something.
        // This occurs with Windows and some more secure environments
        $system['sysWEBOWNER'] = _FPA_NA;
    }

    // find the system temp directory
    if ( version_compare( PHP_VERSION, '5.2.1', '>=' ) ) {
        $system['sysSYSTMPDIR'] = sys_get_temp_dir();

        // is the system /tmp writable to this user?
        if ( is_writable( sys_get_temp_dir() ) ) {
            $system['sysTMPDIRWRITABLE'] = qText('Yes');

        } else {
            $system['sysTMPDIRWRITABLE'] = qText('No');
        }

    } else {
        $system['sysSYSTMPDIR'] = _FPA_U;
        $system['sysTMPDIRWRITABLE'] = _FPA_U;
    }

    return $system;
}

function convert($size) {
    $unit=array('b','kb','mb','gb','tb','pb');
    return @round($size/pow(1024,($i=floor(log($size,1024)))),2).' '.$unit[$i];
}

// !CLEANME this needs to be done a little smarter
// here we take the folders array and unset folders that aren't relevant to a specific release
function filter_folders( $folders, $instance ) {
    GLOBAL $folders;

    if ( $instance['cmsRELEASE'] != '1.0' ) {
        // ignore the folders for J!1.0
        unset ( $folders[4] );

    } elseif ( $instance['cmsRELEASE'] == '1.0' ) {
        // ignore folders for J1.5 and above
        unset ( $folders[3] );
        unset ( $folders[8] );
        unset ( $folders[9] );
        unset ( $folders[12] );
    }


    if ( $instance['platformPRODUCT'] != 'Nooku' ) {
        // ignore the Nooku sites folder if not Nooku
        unset ( $folders[14] );
    }

}

// this is a little funky and passes the extension array name bt variable reference
// (&$arrname refers to each seperate array, which is called at the end) this was
// depreciated at 5.3 and I couldn't find an alternative, so the fix to a PHP Warning
// is to simply re-assign the $arrname back to itself inside the function, so it is
//no-longer a reference
function getDetails( $path, &$arrname, $loc, $level = 0 ) {
    global $component, $module, $plugin, $template;

    // fix for PHP5.3 pass-variable-by-reference depreciation
    $arrname = $arrname;
    // Directories & files to ignore when listing output.
    $ignore = array( '.', '..', 'index.htm', 'index.html', '.DS_Store', 'none.xml', 'metadata.xml', 'default.xml', 'form.xml', 'contact.xml', 'edit.xml', 'blog.xml' );

    // open the directory to the handle $dh
    $dh = @opendir( $path );

    // loop through the directory
    while( false !== ( $file = @readdir( $dh ) ) ) {

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

                if ( preg_match( "/\.xml/i", $file ) ) {
                    // if filename matches .xml in the name

                    $content = file_get_contents( $cDir );

                    if ( preg_match( '#<(extension|install|mosinstall)#', $content, $isValidFile ) ) {
                        $arrname[$loc][$cDir] = '';

                        $arrname[$loc][$cDir]['author']         = '-';
                        $arrname[$loc][$cDir]['authorUrl']      = '-';
                        $arrname[$loc][$cDir]['version']        = '-';
                        $arrname[$loc][$cDir]['creationDate']   = '-';
                        $arrname[$loc][$cDir]['type']           = '-';


                        if ( preg_match( '#<name>(.*)</name>#', $content, $name ) ) {
                            $arrname[$loc][$cDir]['name']   = strip_tags( substr( $name[1], 0, 30 ) );

                        } else {
                            $arrname[$loc][$cDir]['name']   = _FPA_U;
                        }


                        if ( preg_match( '#<author>(.*)</author>#', $content, $author ) ) {
                            $arrname[$loc][$cDir]['author'] = strip_tags( substr( $author[1], 0, 19 ) );

                            if ( $author[1] == 'Joomla! Project' OR strtolower( $name[1] ) == 'joomla admin' OR strtolower( $name[1] ) == 'rhuk_milkyway' OR strtolower( $name[1] ) == 'ja_purity' OR strtolower( $name[1] ) == 'khepri' OR strtolower( $name[1] ) == 'bluestork' OR strtolower( $name[1] ) == 'atomic' OR strtolower( $name[1] ) == 'hathor' OR strtolower( substr( $name[1], 0, 4 ) ) == 'beez' ) {
                                $arrname[$loc][$cDir]['type'] = qText('Core');

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
    }
    @closedir( $dh );
}

function getDirectory( $path = '.', $level = 0 ) {
    GLOBAL $elevated, $dirCount;

    // directories to ignore when listing output. Many hosts
    $ignore = array( '.', '..' );

    // open the directory to the handle $dh
    $dh = @opendir( $path );

    // loop through the directory
    while ( false !== ( $file = readdir( $dh ) ) ) {

        // check that this file is not to be ignored
        if ( !in_array( $file, $ignore ) ) {

            if ( $dirCount < '10' ) {
                // 10 or more folder will cancel the processing

                // its a directory, so we need to keep reading down...
                if ( is_dir( "$path/$file" ) ) {

                    $dirName = $path .'/'. $file;
                    $dirMode = substr( sprintf( '%o', fileperms( $dirName ) ),-3, 3 );

                    // looking for --7 or -7- or -77 (default folder permissions are usually 755)
                    if ( substr( $dirMode,1 ,1 ) == '7' OR substr( $dirMode,2 ,1 ) == '7' ) {
                        $elevated[''. str_replace( './','', $dirName ) .'']['mode'] = $dirMode;

                        if ( is_writable( $dirName ) ) {
                            $elevated[''. str_replace( './','', $dirName ) .'']['writable'] = qText('Yes');

                        } else {  // custom ownership or setUiD/GiD in-effect
                            $elevated[''. str_replace( './','', $dirName ) .'']['writable'] = qText('No');
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

// build the developer-mode function to display the raw arrays
function showDev( &$section ) {

    if ( ! defined( '_FPA_DEV' ) ) {
        return;
    }

    // this can only have inline styling because it is outputed before the html styling
    echo '<div style="width:750px;margin: 0px auto;margin-bottom:10px;font-family:arial;font-size:10px;color:#808080;">';
    echo '<div style="text-shadow: 1px 1px 1px #F5F5F5;font-weight:bold;color:#4D8000;text-transform:uppercase;padding-bottom:2px;">';
    echo '<span style="color: #808080;font-weight:normal;text-transform:lowercase;">['. qText('developer-mode-information') .']</span><br />';
    echo $section['ARRNAME'] .' Array :';
    echo '</div>';

    echo '<div style="-moz-box-shadow: inset -3px -3px 3px #CAE897;-webkit-box-shadow: inset -3px -3px 3px #CAE897;box-shadow: inset -3px -3px 3px #CAE897;padding:5px;background-color:#E2F4C4; border:1px solid #4D8000;border-radius:5px;-moz-border-radius:5px;-webkit-border-radius:5px;">';
    print_r ( $section );
    echo '<p><em>'. sprintf(qText('Elapsed-runtime: %s seconds'), '<strong>' . mt_end() . '</strong>') .'</em></p>';
    echo '</div>';

    echo '</div>';
} // end developer-mode function


/* @version SVN $Id: language.php 567 2011-10-30 17:52:44Z elkuku $ */

/**
 * Small multilanguage function.
 *
 * @param string $original Text to translate.
 * @param if additional paramaters are supplied, the function behaves like sprintf.
 *
 * @return string Translated text or original if not found
 */
function qText($original)
{
    $translated = qLanguage::translate($original);

    if(func_num_args() > 1)
    {
        //-- Treat it as sprintf
        $args = func_get_args();

        $args[0] = $translated;

        return call_user_func_array('sprintf', $args);
    }

    return $translated;
}//function

/**
 * Language handling class.
 */
abstract class qLanguage
{
    protected static $lang = '';

    protected static $strings = array();

    protected static $untranslateds = array();

    public static function loadLanguage($lang)
    {
        //-- Get the 'raw' language file
        self::parseStrings(getPredefinedLanguageStrings($lang));

        self::$lang = $lang;
    }//function

    public static function translate($string)
    {
        //short: return (isset(self::$strings[$string]) ? self::$strings[$string] : $translated;

        if(isset(self::$strings[$string]))
        {
            //-- Translation found
            $translated = self::$strings[$string];
        }
        else//
        {
            //-- No translation found
            $translated = $string;

            //-- Record untranslated string
            self::$untranslateds[] = $string;
        }

        return $translated;
    }//function

    public static function getUntranslateds()
    {
        return self::$untranslateds;
    }//function

    public static function getLangTag()
    {
        return self::$lang;
    }//function

    protected static function parseStrings($strings)
    {
        foreach($strings as $line)
        {
            $line = trim($line);

            //-- Blank
            if( ! $line)
            continue;

            $pos = strpos($line, '=');

            //-- Other invalid ?
            if( ! $pos)
            continue;

            $key = trim(substr($line, 0, $pos));
            $value = trim(substr($line, $pos + 1));

            self::$strings[$key] = $value;
        }//foreach
    }//function
}//class

/**
 * Get the contents of a language file.
 *
 * Strings will be auto filled by a build script.
 *
 * @param string $lang The language to load - e.g. de-DE
 *
 * @return array
 * @throws Exception
 */
function getPredefinedLanguageStrings($lang)
{
    if( ! $lang || 'en-GB' == $lang) return array();

    //-- AutoFilled
    $sfBuilderStrings = array('be-BY' => 'Generating Post Output... = Стварэнне рэзультата паведамлення...
Hang on in there while we run some tests... = Пачакайте калі ласка, пакуль мы выконваем некалькі тэстаў ...
PHP Environment = Асяроддзе PHP
Environment Support Snapshot = Здымак асяроддзя
Application Instance = Адзінка прылажэння
System Environment = Сістэмнае асяродзе
PHP Extensions = Пашырэння PHP
PHP Requirements = Патрабаванні PHP
Components = Кампаненты
Modules = Модулі
Plugins = Плагіны
Templates = Шаблоны
Apache Modules = Модулі Apache
Apache Requirements = Патрабаванні Apache
Table Structure = Структура табліц
Core Folders = Асноўныя папкі
DEVELOPER MODE is enabled = Рэжым распрацоўніка уключаны
DIGNOSTIC MODE is enabled = Рэжым дыягностыкі уключаны
Last DIGNOSTIC MODE Error in %s = Рэжым дыягностыкі: апошняя памылка ў %s.
No Errors Reported = Няма паведамленняў пра памылкі
Yes = Так
No = Не
May not be an error, check with host for remote access requirements. = вашага хоста.
Post Detail = Падрабязнасці паведамлення
', 'de-DE' => 'Generating Post Output... = Generiere die Post Ausgabe...
Hang on in there while we run some tests... = Etwas Geduld während wir einige Tests durchführen...
PHP Extensions = PHP Erweiterungen
Yes = Ja
No = Nein
Unknown = Unbekannt
Enter your problem description <i>(optional)</i> = Geben Sie eine Problembeschreibung ein <i>(optional)</i>
Disabled = Deaktiviert
Default = Standard
%s discovery = Analyse von %s
Protected = Geschützt
Enabled = Aktiviert
Not Configured = Nicht Konfiguriert
Connected = Verbunden
Not Connected = Nicht verbunden
Uploads enabled : = Uploads aktiviert: 
Elapsed-runtime: %s seconds = Benötigte Ausführungaszeit: %s Sekunden
Not Found = Nicht gefunden
Legends and Settings = Legende und Einstellungen
Language = Sprache
', 'es-ES' => 'Generating Post Output... = Generando el mensaje...
Hang on in there while we run some tests... = Un momento, estamos realizando algunas pruebas...
Yes = Si
No = No
Disabled = Desactivado
Default = Estandard
Enabled = Activado
Not Configured = No configurado
Connected = Connectado
Not Connected = No connectado
Uploads enabled : = Subidas activadas :
Elapsed-runtime: %s seconds = Tiempo estiomado: %s segundos
Not Found = No encontrado
Legends and Settings = Leyenda y Ajustes
Language = Idioma
', 'fi-FI' => 'Generating Post Output... = Luodaan raporttikoodia...
Hang on in there while we run some tests... = Odota hetki, suoritamme kokeita...
PHP Environment = PHP-ympäristö
Environment Support Snapshot = Ympäristön tuen pikasilmäys
Application Instance = Sovellusinstanssi
System Environment = Järjestelmäympäristö
PHP Extensions = PHP laajennukset
PHP Requirements = PHP vaatimukset
Elevated Permissions = Korotetut oikeudet
Components = Komponentit
Modules = Moduulit
Plugins = Liitännäiset
Templates = Sivupohjat
Apache Modules = Apache moduulit
Apache Requirements = Apache vaatimukset
Database Instance = Tietokantainstanssi
Table Structure = Taulujen rakenne
Permissions Checks = Oikeuksien tarkastus
Core Folders = Ydinhakemistot
DEVELOPER MODE is enabled = KEHITYSTILA on päällä
DIGNOSTIC MODE is enabled = DIAGNOSTINEN TILA on päällä
Last DIGNOSTIC MODE Error in %s = Viimeisin DIAGNOSTISEN TILAN virhe lokissa %s
No Errors Reported = Ei raportoituja virheitä
Yes = Kyllä
No = Ei
May not be an error, check with host for remote access requirements. = Ei välttämättä ole virhe, tarkasta palveluntarjoajalta etäyhteysvaatimukset.
PHP Supports %s = PHP tukee %s
Unknown = Tuntematon
MySQL Supports %s = MySQL tukee %s
Maybe = Ehkä
Special Note = Erityishuomautus
MySQL default collation = MySQL oletusaakkostus
%s version = %s versio
Known Buggy PHP = Tunnetusti virheellinen PHP
Known Buggy Zend = Tunnetusti virheellinen Zend
Instructions = Ohjeet
Enter your problem description <i>(optional)</i> = Kirjoita kuvaus ongelmastasi <i>(valinnainen)</i>
Enter any error messages you see <i>(optional)</i> = Kopioi tai kirjoita tähän virheilmoitus/-kset <i>(valinnainen)</i>
Enter any actions taken to resolve the issue <i>(optional)</i> = Miten olen yrittänyt ratkaista ongelmaa? <i>(valinnainen)</i>
Select detail level options of output <i>(optional)</i> = Valitse tuotettavan raportin yksityskohtien taso <i>(valinnainen)</i>
Click the %s post button to build the post content = Paina %s -nappia luodaksesi foorumille liitettävän koodin
Generate = Luo raportti
Copy the contents of the %s box and paste it into a post = Kopioi %s ruudun sisältö kokonaisuudessaan ja liitä se foorumiviestiisi
Post Detail = Raporttikoodi
Optional Information = Lisätietoja
Problem Description = Ongelman kuvaus
Log/Error Message = Loki/virheilmoitus
Last error = Viimeisin virhe
Actions To ReCreate Issue = Toimet ongelman toisintamiseksi
Actions Taken To Resolve = Ongelman korjaamiseksi tehdyt toimet
Leave ALL fields blank/empty to simply post diagnostic information. = Voit jättää kaikki kentät tyhjiksi kerätäksesi vain diagnostiset tiedot.
Optional Settings = Valinnaiset asetukset
Disabled = Poissa käytöstä
Show elevated folder permissions = Näytä korotetut kansioiden oikeudet
Show database table statistics = Näytä tietokantataulujen tilastot
Show Components = Listaa komponentit
Show Modules = Listaa modullit
Show Plugins = Listaa liitännäiset
Information Privacy = Tietosuoja
None = Ei mitään
No elements are masked = Mitään ei peitetä
Partial = Osittainen
Default = Oletus
Some elements are masked = Jotkin tiedot peitetään
Strict = Tiukka
All indentifiable elements are masked = Kaikki tunnistettavat tiedot peitetään
Click Here To Generate Post = Luo raportti
PHP %1s or %2s errors ? = PHP %1s tai %2s virheet?
Temporarily increase PHP Memory and Execution Time = Lisää väliaikaisesti PHP muistia ja suoritusaikaa
%s discovery = %s selvitys
CMS found = CMS löytyi
Platform = Alusta
Config exists = Asetukset olemassa
Config version = Asetusten versio
Matches CMS = Täsmää CMS:n
CMS mis-match = CMS ristiriita
Config valid = Asetukset kelvot
Config mode = Asetusmoodi
Writable = Kirjoitettava
Read-Only = Vain luku
Config Owner = Asetusten omistaja
Protected = Suojattu
Config Group = Asetusten ryhmä
Instance Not Found = Instanssia ei löytynyt
No %s tests performed = %s testejä ei suoritettu
But configuration found = Mutta asetukset löytyivät
%s :: Configuration = %s :: asetukset
Enabled = Käytössä
Database = Tietokanta
Version = Versio
Database credentials = Tietokannan tunnukset
Appear in-complete = Näyttäisi puutteelliselta
Appear complete = Näyttäisi täydelliseltä
Security = Turvallisuus
Features = Ominaisuudet
Could be empty = Saattaa olla tyhjä
Configuration not found or invalid = Asetukset hukassa tai kelvottomat
Server = Palvelin
Client = Asiakas
Hostname = Isäntänimi
Not Configured = Ei asetettu
Connection Type = Yhteystyyppi
Local = Paikallinen
Remote = Etä
%s support = %s tuki
%s is not supported by PHP %s = %s ei ole PHP %s tukema
%s is supported by PHP %s = %s on PHP %s tukema
PHP %s support is unknown = PHP %s tuki tuntematon
Connect to %s = Yhdistä %s
Not Attempted = Ei yritetty
Connected = Yhdistetty
Error(s) reported = Virhe(itä) raportoitiin
Connection Error = Yhteysvirhe
Character Set = Merkistö
Default Character Set = Oletusmerkistö
Database collation = Tietokannan aakkostus
Database size = Tietokannan koko
Missing credentials detected = Puuttuva valtuutus havaittiin
%s not found = %s ei löytynyt
MySQL Hostname = MySQL isäntänimi
Table Prefix = Taulun etuliite
Database user = Tietokannan käyttäjätunnus
Database password = Tietokannan salasana
Performance = Suorituskyky
Table = Taulu
Not Connected = Ei yhdistetty
No %s performance tests performed = %s suorituskykytestejä ei suoritettu
Name = Nimi
Size = Koko
Table records = Taulussa tietueita
Avg. Length = Keskipituus
Fragment Size = Osan koko
Engine = Moottori
Collation = Aakkostus
Created = Luotu
Updated = Päivitetty
Checked = Tarkastettu
increased by user, was %s = käyttäjän korottama, oli %s
Uploads enabled : = Lataukset sallittu:
Last known PHP error = Viimeisin havaittu PHP virhe
Technology = Arkkitehtuuri
Server %s: = Palvelin %s:
Signature = Allekirjoitus
Encoding = Koodaus
User = Käyttäjä
Document Root = Document Root
Temp = Temp
Server temp writable: %s = Järjestelmän temp kirjoitettavissa: %s
Switch user configuration = Vaihda käyttäjäasetukset
Potential Missing Extensions = Mahdollisesti puuttuvat laajennukset
Potential Missing Modules = Mahdollisesti puuttuvat moduulit
Mode = Moodi
Folder = Hakemisto
Group = Ryhmä
Owner = Omistaja
First %d = Ensimmäinen %d
SITE = SIVUSTO
Author = Tekijä
Address = Osoite
Status = Tila
ADMIN = YLLÄPITÄJÄ
Credentials = Valtuutus
Core = Ydin
developer-mode-information = kehittäjätilan-tiedot
Elapsed-runtime: %s seconds = Kulunut suoritusaika: %s sekuntia
Not Found = Ei löydy
Legends and Settings = Selitteet ja asetukset
OK/GOOD = OK/KELPO
WARNINGS = VAROITUKSET
ALERTS = HÄLYTYKSET
Show = Näytä
Hide = Piilota
Basic Environment = Perusympäristö
Joomla instance = Joomla-instanssi
Platform instance = Alustainstanssi
Instance configured = Instanssi määritetty
Configuration options = Asetusvalinnat
Database Credentials Present = Tietokannan tunnukset olemassa
Host configuration = Isäntäasetukset
OS version = Käyttöjärjestelmäversio
Technology: %s = Arkkitehtuuri: %s
Web Server: %s = Web-palvelin: %s
Encoding: %s = Koodaus: %s
System TMP writable: %s = Järjestelmän TMP kirjoitettavissa: %s
MySQL configuration = MySQL asetukset
Database credentials incomplete or not available = Tietokannan tunnukset puutteelliset tai puuttuvat
Nothing to display. = Ei näytettävää
PHP configuration = PHP asetukset
Last known errors: %s = Viimeisimmät havaitut virheet: %s
Joomla! instance = Joomla!-instanssi
Instance configuration = Instanssin asetukset
Web Server = Web-palvelin
**%1s**: %2s = **%1s**: %2s
System TMP writable = Järjestelmän TMP kirjoitettavissa
Last known errors = Viimeisimmät havaitut virheet
OS Version = Käyttöjärjestelmäversio
Last PHP error = Viimeisin PHP virhe
Actions Taken To Resolve by %s = Ongelman ratkaisemiseksi %s tekemät toimenpiteet 
Joomla! platform = Joomla! alusta
Joomla! configured = Joomla! määritetty
[b]%1s[/b]: %2s = [b]%1s[/b]: %2s
Database credentials present in configuration ? ... = Tietokannan tunnukset asetuksissa? ...
Host = Isäntä
Detailed Environment = Ympäristön tiedot
Switch User Environment = Vaihda käyttäjäympäristö
Experimental = Kokeellinen
Potential Ownership Issues = Mahdollisia omistajuusongelmia
Database Statistics = Tietokantatilastot
Language = Kieli
', 'hu-HU' => 'PHP Environment = PHP környezet
System Environment = Rendszerkörnyezet
PHP Extensions = PHP kiterjesztések
PHP Requirements = PHP követelmények
Components = Komponensek
Modules = Bővítmények
Plugins = Beépülők
Templates = Sablonok
Apache Modules = Apache bővítmények
Apache Requirements = Apache követelmények
Database Instance = Adatbázis példány
Table Structure = Tábla struktúra
Permissions Checks = Jogosultság ellenőrzés
DEVELOPER MODE is enabled = FEJLESZTŐ MÓD engedélyezve
Yes = Igen
No = Nem
PHP Supports %s = PHP támogatások %s
Unknown = Ismeretlen
MySQL Supports %s = MySQL támogatások %s
Maybe = Talán
%s version = %s verzió
Instructions = Utasítások
Problem Description = Probléma leírása
Last error = Utolsó hiba
Disabled = Letiltva
None = Nincs
Partial = Részleges
Default = Alapértelmezett
Strict = Szigorú
Platform = Platform
Writable = Írható
Read-Only = Csak olvasható
Enabled = Engedélyezve
Database = Adatbázis
Version = Verzió
Security = Biztonság
Features = Jellemzők
Server = Szerver
Client = Kliens
Hostname = Hosztnév
Local = Helyi
Remote = Távoli
%s support = %s támogatás
Database size = Adatbázis méret
Created = Létrehozta
Updated = Frissítve
Checked = Ellenőrizve
Last known PHP error = Utolsó ismert PHP hiba
Technology = Technológia
Server %s: = Szerver %s:
Signature = Aláírás
Encoding = Kódolás
User = Felhasználó
Temp = Temp
Mode = Mód
Folder = Könyvtár
Group = Csoport
Owner = Tulajdonos
SITE = WEBHELY
Author = Szerző
Address = Cím
Status = Állapot
ADMIN = ADMINISZTRÁTOR
Not Found = Nem található
Legends and Settings = Történet és beállítások
OK/GOOD = OKÉ/JÓ
WARNINGS = FIGYELMEZTETÉSEK
ALERTS = RIASZTÁSOK
Show = Megjelenít
Hide = Elrejt
OS version = Operációs rendszer verzió
', 'id-ID' => 'Generating Post Output... = Menghasilkan Keluaran Posting...
Hang on in there while we run some tests... = Tunggu disana sementara kami menjalankan beberapa test...
PHP Environment = Linkungan PHP
Environment Support Snapshot = Potret Pendukung Lingkungan
Application Instance = Instansi Aplikasi
System Environment = Lingkungan System
PHP Extensions = Ekstensi PHP
PHP Requirements = Persyaratan PHP
Elevated Permissions = Tingkatan Perizinan
Components = Komponen
Modules = Modul
Plugins = Pengaya
Templates = Template
Apache Modules = Modul Apache
Apache Requirements = Persyaratan Apache
Database Instance = Instansi Database
Table Structure = Struktur Table
Permissions Checks = Pemeriksaan Hak Akses
Core Folders = Folder Inti
DEVELOPER MODE is enabled = DEVELOPER MODE diaktifkan
DIGNOSTIC MODE is enabled = DIGNOSTIC MODE diaktifkan
Last DIGNOSTIC MODE Error in %s = DIGNOSTIC MODE Kesalahan berakhir dalam %s
No Errors Reported = Dilaporkan Tidak Ada Kesalahan
Yes = Ya
No = Tidak
May not be an error, check with host for remote access requirements. = Mungkin bukan kesalahan, periksa host pada persyaratan akses remote.
PHP Supports %s = PHP Mendukung %s
Unknown = Tidak diketahui
MySQL Supports %s = MySQL Mendukung %s
Maybe = Mungkin
Special Note = Catatan Khusus
MySQL default collation = MySQL kolasi standar
%s version = %s versi
Known Buggy PHP = PHP Buggy Yang Diketahui
Known Buggy Zend = Zend Buggy Yang Diketahui
Instructions = Instruksi
Enter your problem description <i>(optional)</i> = Masukkan deskripsi masalah anda <i>(opsional)</i>
Enter any error messages you see <i>(optional)</i> = Masukkan pesan kesalahan apapun yang anda lihat <i>(opsional)</i>
Enter any actions taken to resolve the issue <i>(optional)</i> = tersebut <i>(opsional)</i>
Select detail level options of output <i>(optional)</i> = Pilih rincian opsi tingkat keluaran <i>(opsional)</i>
Click the %s post button to build the post content = Klik pada %s tombol pos untuk membuat konten pos
Generate = Menghasilkan
Copy the contents of the %s box and paste it into a post = Salin konten boks %s dan tempelkan pada pos
Post Detail = Rincian Pos
Optional Information = Informasi Opsional
Problem Description = Deskripsi Masalah
Log/Error Message = Pesan Log/Kesalahan
Last error = Kesalahan terakhir
Actions To ReCreate Issue = Aksi untuk ReCreate Masalah
Actions Taken To Resolve = Aksi Yang Diambil Untuk Menyelesaikan
Leave ALL fields blank/empty to simply post diagnostic information. = Biarkan ALL/SEMUA bidang isian kosong untuk pos analisa informasi sederhana.
Optional Settings = Pengaturan Opsional
Disabled = Nonaktif
Show elevated folder permissions = Tampilkan tingkatan hak akses folder
Show database table statistics = Tampilkan statistik tabel database
Show Components = Tampilkan Komponen
Show Modules = Tampilkan Modul
Show Plugins = Tampilkan Pengaya
Information Privacy = Informasi Pribadi
None = Tanpa
No elements are masked = Tidak ada elemen yang disamarkan
Partial = Terpisah
Default = Standar
Some elements are masked = Beberapa elemen disamarkan
Strict = Teliti
All indentifiable elements are masked = Semua element yang teridentifikasi disamarkan
Click Here To Generate Post = Klik Disini Untuk Menghasilkan Pos
PHP %1s or %2s errors ? = Kesalahan PHP %1s atau %2s ?
Temporarily increase PHP Memory and Execution Time = Untuk sementara menaikkan Memori PHP dan Waktu Eksekusi
%s discovery = %s dideteksi
CMS found = CMS ditemukan
Platform = Platform
Config exists = Ada configurasi
Config version = Versi konfigurasi
Matches CMS = CMS Sesuai
CMS mis-match = CMS tak sesuai
Config valid = Konfigurasi berlaku
Config mode = Mode konfigurasi
Writable = Dapat ditulis
Read-Only = Hanya-Baca
Config Owner = Pemilik Konfigurasi
Protected = Dilindungi
Config Group = Grup Konfigurasi
Instance Not Found = Instansi Tidak Ditemukan
No %s tests performed = Tidak ada %s yang dikerjakan
But configuration found = Tapi konfigurasi ditemukan
%s :: Configuration = %s :: Konfigurasi
Enabled = Aktif
Database = Database
Version = Versi
Database credentials = Mandat database
Appear in-complete = Muncul tidak lengkap
Appear complete = Muncul lengkap
Security = Keamanan
Features = Fitur
Could be empty = Mungkin kosong
Configuration not found or invalid = Konfigurasi tidak ditemukan atau tidak berlaku
Server = Server
Client = Klien
Hostname = Nama host
Not Configured = Tak dikonfigurasi
Connection Type = Tipe Koneksi
Local = Lokal
Remote = Remote
%s support = %s mendukung
%s is not supported by PHP %s = %s tidak didukung oleh PHP %s
%s is supported by PHP %s = %s didukung oleh PHP %s
PHP %s support is unknown = PHP %s dukungan tidak diketahui
Connect to %s = Menyambung ke %s
Not Attempted = Tidak Dicoba
Connected = Tersambung
Error(s) reported = Ditemukan kesalahan
Connection Error = Kesalahan Koneksi
Character Set = Set Karakter
Default Character Set = Karakter Set Standar
Database collation = Kolasi database
Database size = Ukuran database
Missing credentials detected = Terdeteksi hilangnya mandat
%s not found = %s tidak ditemukan
MySQL Hostname = Nama Host MySQL
Table Prefix = Awalan Tabel
Database user = Pengguna database
Database password = Password database
Performance = Performa
Table = Tabel
Not Connected = Tak tersambung
No %s performance tests performed = Tidak ada %s tes performa yang dilakukan
Name = Nama
Size = Ukuran
Table records = Rekam tabel
Avg. Length = Avg. Panjang
Fragment Size = Ukuran Penggalan
Engine = Mesin
Collation = Kolasi
Created = Dibuat
Updated = Pembaharuan
Checked = Diperiksa
increased by user, was %s = dinaikkan oleh pengguna, yaitu %s
Uploads enabled : = Upload diaktifkan :
Last known PHP error = Kesalahan PHP terakhir yang diketahui
Technology = Teknologi
Server %s: = Server %s:
Signature = Tanda-tangan
Encoding = Penyandian
User = Pengguna
Document Root = Root Dokumen
Temp = Temp
Server temp writable: %s = Temp server bisa ditulis: %s
Switch user configuration = Ganti konfigurasi pengguna
Potential Missing Extensions = Berpotensi Ekstensi Hilang
Potential Missing Modules = Berpotensi Modul Hilang
Mode = Mode
Folder = Folder
Group = Grup
Owner = Pemilik
First %d = Pertama %d
SITE = SITE/SITUS
Author = Penulis
Address = Alamat
Status = Status
ADMIN = ADMIN
Credentials = Mandat
Core = Inti
developer-mode-information = informasi-mode-developer
Elapsed-runtime: %s seconds = Waktu dilalui: %s detik
Not Found = Tidak Ditemukan
Legends and Settings = Legenda dan Pengaturan
OK/GOOD = OK/BAIK
WARNINGS = PERINGATAN
ALERTS = TANDA
Show = Tampil
Hide = Sembunyi
Basic Environment = Lingkungan Dasar
Joomla instance = Instansi Joomla
Platform instance = Instansi Platform
Instance configured = Instansi dikonfigurasi
Configuration options = Opsi konfigurasi
Database Credentials Present = Kredensial Database Yang Ada
Host configuration = Konfigurasi host
OS version = Versi OS
Technology: %s = Teknologi: %s
Web Server: %s = Server Web: %s
Encoding: %s = Penyandian: %s
System TMP writable: %s = Sistem TMP bisa ditulis: %s
MySQL configuration = Konfigurasi MySQL
Database credentials incomplete or not available = Kredensial database tidak lengkap atau tidak tersedia
Nothing to display. = Tidak ada yang bisa ditampilkan.
PHP configuration = Konfigurasi PHP
Last known errors: %s = Kesalahan terakhir yang diketahui: %s
Joomla! instance = Instansi Joomla!
Instance configuration = Instansi konfigurasi
Web Server = Server Web
**%1s**: %2s = **%1s**: %2s
System TMP writable = Sistem TMP Bisa Ditulis
Last known errors = Kesalahan terakhir yang diketahui
OS Version = Versi OS
Last PHP error = Kesalahan PHP terakhir
Actions Taken To Resolve by %s = Aksi Yang Diambil Untuk Menyelsaikan oleh %s
Joomla! platform = Joomla! platform
Joomla! configured = Joomla! dikonfigurasi
[b]%1s[/b]: %2s = [b]%1s[/b]: %2s
Database credentials present in configuration ? ... = Kredensial database yang ada dalam konfigurasi? ...
Host = Host
Detailed Environment = Rincian Lingkungan
Switch User Environment = Ganti Lingkungan Pengguna
Experimental = Eksperimental
Potential Ownership Issues = Berpotensi Masalah Pada Kepemilikan
Database Statistics = Statistik Database
Language = Bahasa
', 'it-IT' => 'Generating Post Output... = Generazione output del post in corso...
Hang on in there while we run some tests... = Attendi mentre eseguiamo alcuni test ...
PHP Environment = Ambiente PHP
Environment Support Snapshot = Snapshot ambiente supporto
Application Instance = Istanza applicazione
System Environment = Ambiente di Sistema
PHP Extensions = Estensioni PHP
PHP Requirements = Requisiti PHP
Elevated Permissions = Permessi elevati
Components = Componenti
Modules = Moduli
Plugins = Plugins
Templates = Templates
Apache Modules = Moduli di Apache
Apache Requirements = Requisiti Apache
Database Instance = Istanza Database
Table Structure = Struttura tabelle
Permissions Checks = Controllo dei permessi
Core Folders = Cartelle Core
DEVELOPER MODE is enabled = Il DEVELOPER MODE è abilitato
DIGNOSTIC MODE is enabled = La MODALITÀ DIAGNOSTICA è attiva
Last DIGNOSTIC MODE Error in %s = Ultimo errore MODALITÀ DIAGNOSTICA in %s
No Errors Reported = Nessun errore riportato
Yes = Sì
No = No
May not be an error, check with host for remote access requirements. = accesso remoto.
PHP Supports %s = PHP supporta %s
Unknown = Sconosciuto
MySQL Supports %s = MySQL Supporta %s
Maybe = Potrebbe
Special Note = Nota speciale
MySQL default collation = MySQL collation predefinita
%s version = %s versione
Known Buggy PHP = PHP con problemi noti
Known Buggy Zend = Zend con problemi noti
Instructions = Istruzioni
Enter your problem description <i>(optional)</i> = Inserisci la descrizione del tuo problema <i>(opzionale)</i>
Enter any error messages you see <i>(optional)</i> = Inserisci i messaggi di errore visualizzati <i>(opzionale)</i>
Enter any actions taken to resolve the issue <i>(optional)</i> = Scrivi le azioni intraprese per risolvere il problema <i>(opzionale)</i>
Select detail level options of output <i>(optional)</i> = Seleziona le opzioni del livello di dettaglio dell\'output <i>(opzionale)</i>
Click the %s post button to build the post content = Fai click sul pulsante %s del post per creare il contenuto del post
Generate = Genera
Copy the contents of the %s box and paste it into a post = Copia il contenuto del box %s e incollalo in un post
Post Detail = Dettagli post
Optional Information = Informazioni opzionali
Problem Description = Descrizione problema
Log/Error Message = Messaggi Log/Errore
Last error = Ultimo errore
Actions To ReCreate Issue = Azioni per ricreare il problema
Actions Taken To Resolve = Azioni intraprese per la risoluzione
Leave ALL fields blank/empty to simply post diagnostic information. = diagnostiche.
Optional Settings = Impostazioni Opzionali
Disabled = Disabilitato
Show elevated folder permissions = Mostra permessi elevati cartelle
Show database table statistics = Mostra statistiche tabella database
Show Components = Mostra Componenti
Show Modules = Mostra Moduli
Show Plugins = Mostra Plugins
Information Privacy = Privacy informazioni
None = No
No elements are masked = Nessun elemento nascosto
Partial = Parziale
Default = Predefinito
Some elements are masked = Alcuni elementi sono nascosti
Strict = Strict
All indentifiable elements are masked = Tutti gli elementi identificabili sono nascosti
Click Here To Generate Post = Clicca qui per generare il post
PHP %1s or %2s errors ? = Errori PHP %1s o %2s ?
Temporarily increase PHP Memory and Execution Time = Aumenta temporaneamente la memoria PHP ed il tempo di esecuzione
%s discovery = %s scoperto
CMS found = CMS trovato
Platform = Piattaforma
Config exists = Config. esistente
Config version = Versione Config.
Matches CMS = CMS corrispondente
CMS mis-match = CMS non corrispondente
Config valid = Config. valida
Config mode = Modalità Config.
Writable = Scrivibile
Read-Only = Sola lettura
Config Owner = Proprietario Config.
Protected = Protetto
Config Group = Gruppo Config.
Instance Not Found = Istanza non trovata
No %s tests performed = Nessun %s test eseguito
But configuration found = Ma la configurazione è stata trovata
%s :: Configuration = %s :: Configurazione
Enabled = Abilitato
Database = Database
Version = Versione
Database credentials = Credenziali Database
Appear in-complete = Sembra incompleta
Appear complete = Sembra completa
Security = Sicurezza
Features = Caratteristiche
Could be empty = Può essere vuoto
Configuration not found or invalid = Configurazione non trovata o non valida
Server = Server
Client = Client
Hostname = Nome host
Not Configured = Non configurato
Connection Type = Tipo di connessione
Local = Locale
Remote = Remota
%s support = supporto %s
%s is not supported by PHP %s = %s non è supportato da PHP %s
%s is supported by PHP %s = %s è supportato da PHP %s
PHP %s support is unknown = Il supporto di PHP %s è sconosciuto
Connect to %s = Connetti a %s
Not Attempted = Nessun tentativo
Connected = Connesso
Error(s) reported = Errore(i) riportato(i)
Connection Error = Errore di connessione
Character Set = Set di caratteri
Default Character Set = Set di caratteri predefinito
Database collation = Collation Database
Database size = Dimensione Database
Missing credentials detected = Rilevata mancanza di credenziali
%s not found = %s non trovato
MySQL Hostname = Nome host MySQL
Table Prefix = Prefisso Tabelle
Database user = Utente Database
Database password = Password Database
Performance = Performance
Table = Tabella
Not Connected = Non connesso
No %s performance tests performed = Nessun %s test di performance eseguito
Name = Nome
Size = Dimensione
Table records = Records Tabella
Avg. Length = Lunghezza media
Fragment Size = Dimensione frammento
Engine = Motore
Collation = Collation
Created = Creato
Updated = Aggiornato
Checked = Controllato
increased by user, was %s = aumentato dall\'utente, era %s
Uploads enabled : = Uploads abilitati :
Last known PHP error = Ultimo errore PHP conosciuto
Technology = Tecnologia
Server %s: = Server %s:
Signature = Firma
Encoding = Codifica
User = Utente
Document Root = Root documento
Temp = Temp
Server temp writable: %s = Temp del server scrivibile: %s
Switch user configuration = Cambia configurazione utente
Potential Missing Extensions = Potenziali estensioni mancanti
Potential Missing Modules = Potenziali moduli mancanti
Mode = Modalità
Folder = Cartella
Group = Grupp
Owner = Proprietario
First %d = Primo %d
SITE = SITO
Author = Autore
Address = Indirizzo
Status = Stato
ADMIN = ADMIN
Credentials = Credenzial
Core = Core
developer-mode-information = informazioni-developer-mode
Elapsed-runtime: %s seconds = Tempo di esecuzione trascorso: %s secondi
Not Found = Non trovato
Legends and Settings = Leggende e impostazioni
OK/GOOD = OK/BUONO
WARNINGS = AVVERTENZE
ALERTS = AVVISI
Show = Mostra
Hide = Nascondi
Basic Environment = Ambiente base
Joomla instance = Istanza Joomla
Platform instance = Istanza Platform
Instance configured = Istanza configurata
Configuration options = Opzioni di configurazione
Database Credentials Present = Credenziali Database presenti
Host configuration = Configurazione Host
OS version = Versione OS
Technology: %s = Tecnologia: %s
Web Server: %s = Web Server: %s
Encoding: %s = Codifica: %s
System TMP writable: %s = TMP di sistema scrivibile: %s
MySQL configuration = Configurazione MySQL
Database credentials incomplete or not available = Credenziali database non complete o non disponibili
Nothing to display. = Nulla da visualizzare.
PHP configuration = Configurazione PHP
Last known errors: %s = Ultimi errori noti: %s
Joomla! instance = Istanza Joomla!
Instance configuration = Configurazione istanza
Web Server = Web Server
**%1s**: %2s = **%1s**: %2s
System TMP writable = TMP di sistema scrivibile
Last known errors = Ultimi errori noti
OS Version = Versione OS
Last PHP error = Ultimo errore PHP
Actions Taken To Resolve by %s = Azioni per risolvere intraprese da %s
Joomla! platform = Joomla! platform
Joomla! configured = Joomla! configurato
[b]%1s[/b]: %2s = [b]%1s[/b]: %2s
Database credentials present in configuration ? ... = Le credenziali del Database sono presenti nella Configurazione ? ...
Host = Host
Detailed Environment = Ambiente dettagliato
Switch User Environment = Cambia Ambiente Utente
Experimental = Sperimentale
Potential Ownership Issues = Possibili problemi di permessi/owning
Database Statistics = Statistiche Database
Language = Lingua
', 'pl-PL' => 'Hang on in there while we run some tests... = Zostań tutaj przez chwile, a my uruchomimy kilka testów ...
PHP Environment = Środowisko PHP
Application Instance = Instancja aplikacji
System Environment = Środowisko systemu
PHP Extensions = Rozszerzenia PHP
PHP Requirements = Wymagania PHP
Components = Komponenty
Modules = Moduły
Plugins = Wtyczki
Templates = Szablony
Apache Modules = Moduły Apache
Apache Requirements = Wymagania Apache
Database Instance = Instancja bazy danych
Table Structure = Struktura tabeli
Permissions Checks = Sprawdzenie uprawnień
Core Folders = Foldery rdzenia
DEVELOPER MODE is enabled = TRYB PROGRAMISTY jest włączony
DIGNOSTIC MODE is enabled = TRYB DIAGNOSTYCZNY jest włączony
No Errors Reported = Brak zgłoszonych błędów
Yes = Tak
No = Nie
PHP Supports %s = Obsluga PHP  %s
Unknown = Nieznany
MySQL Supports %s = Obsługa MySQL %s
Maybe = Może
Special Note = Uwaga specjalna
MySQL default collation = Domyślne sortowanie MySQL
%s version = %s wersja
Instructions = Instrukcje
Enter your problem description <i>(optional)</i> = Opisz swój problem <i>(opcjonalnie)</i>
Enter any error messages you see <i>(optional)</i> = Wpisz komunikaty o błędu który widzisz <i>(opcjonalnie)</i>
Enter any actions taken to resolve the issue <i>(optional)</i> = Opisz akcje, która rozwiązała problem <i>(opcjonalnie)</i>
Select detail level options of output <i>(optional)</i> = Wybierz opcje poziom szczegółowości wyjścia <i>(opcja)</i>
Generate = Generowanie
Post Detail = Szczegóły postu
Optional Information = Informacje opcjonalne
Problem Description = Opis problemu
Log/Error Message = Komunikat błędu
Last error = Ostatni błąd
Actions To ReCreate Issue = Jak uzyskać bląd ponownie
Actions Taken To Resolve = Działania podjęte w celu rozwiązania
Optional Settings = Ustawienia opcjonalne
Disabled = Wyłączone
Show elevated folder permissions = Pokaż podwyższone uprawnienia folderu
Show database table statistics = Pokaż statystyki tabeli bazy danych
Show Components = Pokaż komponenty
Show Modules = Pokaż moduły
Show Plugins = Pokaż wtyczki
None = Żaden
No elements are masked = Brak elementów maskowanych
Partial = Częściowo
Default = Domyślnie
Some elements are masked = Niektóre elementy są maskowane
Strict = Ścisły
Click Here To Generate Post = Kliknij tutaj aby wtgenerować wiadomość
Temporarily increase PHP Memory and Execution Time = Tymczasowe zwiększanie pamięci dla PHP i czasu wykonywania
Platform = Platforma
Config exists = Konfig istnieje
Writable = Zapisywalny
Read-Only = Tylko do odczytu
Protected = Chroniony
No %s tests performed = Brak %s przeprowadzonych testów
Enabled = Włączone
Database = Baza danych
Version = Wersja
Security = Bezpieczeństwo
Features = Funkcje
Could be empty = Może być puste
Configuration not found or invalid = Konfiguracja nie znaleziona lub nieprawidlowa
Server = Serwer
Client = Klient
Hostname = Nazwa hosta
Not Configured = Nie skonfigurowano
Connection Type = Typ połączenia
Local = Lokalny
Remote = Zdalny
%s support = %s wsparcie
%s is not supported by PHP %s = %s nie jest obsługiwany przez PHP %s
%s is supported by PHP %s = %s jest wspierane przez PHP %s
Connect to %s = Połącz z %s
Connected = Połączony
Error(s) reported = bląd/błędy zgłoszone
Connection Error = Błąd połączenia
Character Set = Zestaw znaków
Default Character Set = Domyślny zestaw znaków
Database collation = Sortowanie bazy danych
Database size = Rozmiar bazy danych
%s not found = %s nie znaleziono
MySQL Hostname = MySQL Nazwa hosta
Table Prefix = Prefiks tabeli
Database user = Użytkownik bazy danych
Database password = Hasło bazy danych
Performance = Wydajność
Table = Tabela
Not Connected = Nie podłączony
No %s performance tests performed = Brak %s przeprowadzonych badań wydajności
Name = Nazwa
Size = Rozmiar
Table records = Rekordy tabeli
Avg. Length = Śr. Długość
Engine = Silnik
Collation = Porównanie
Created = Stworzony
Updated = Aktualizowany
Checked = Sprawdzony
Uploads enabled : = Wgrywanie włączone :
Last known PHP error = Ostatni znany błąd PHP
Technology = Technologia
Signature = Podpis
Encoding = Kodowanie
User = Użytkownik
Mode = Tryb
Folder = Folder
Group = Grupa
Owner = Właściciel
Author = Autor
Address = Adres
Status = Status
ADMIN = ADMIN
Core = Rdzeń
Not Found = Nie znaleziono
Show = Pokaż
Hide = Ukryj
MySQL configuration = konfiguracja MySQL
Nothing to display. = Nic do wyświetlenia.
PHP configuration = Konfiguracja PHP
OS Version = Wersja systemu operacyjnego
Last PHP error = Ostatni błąd PHP
', 'pt-BR' => 'Generating Post Output... = Gerando Conteúdo para Mensagem ...
Hang on in there while we run some tests... = Aguardee, enquanto nós executamos alguns testes ...
PHP Environment = Ambiente PHP
Environment Support Snapshot = Imagem do Suporte do Ambiente
Application Instance = Instância da Aplicação
System Environment = Ambiente do Sistema
PHP Extensions = Extensões PHP
PHP Requirements = Requisitos PHP
Elevated Permissions = Permissões Elevadas
Components = Componentes
Modules = Módulos
Plugins = Plugins
Templates = Templates
Apache Modules = Módulos do Apache
Apache Requirements = Requisitos Apache
Database Instance = Instância do Banco de Dados
Table Structure = Estrutura da Tabela
Permissions Checks = Verificação das Permissões
Core Folders = Diretórios do Core
DEVELOPER MODE is enabled = MODO DESENVOLVEDOR esta habilitado
DIGNOSTIC MODE is enabled = MODO DIAGNÓSTICO está habilitado
Last DIGNOSTIC MODE Error in %s = Último erro no MODO DIGNÓSTICO em %s
No Errors Reported = Sem erros Relatados
Yes = Sim
No = Não
May not be an error, check with host for remote access requirements. = remoto.
PHP Supports %s = Suporte PHP %s
Unknown = Desconhecido
MySQL Supports %s = Suporte MySQL %s
Maybe = Talvez
Special Note = Nota Especial
');//AutoFilled

    if( ! array_key_exists($lang, $sfBuilderStrings))
    throw new Exception('Language not found'.$lang);//-- Do not translate

    return explode("\n", $sfBuilderStrings[$lang]);
}//function

