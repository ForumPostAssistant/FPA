<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en-gb" lang="en-gb" >


<?php


/**
 **  @package Forum Post Assistant / Bug Report Assistant
 **  @version 1.4.7 litoralis 
 **  @last updated 09/01/2019
 **  @release Beta
 **  @date 24/06/2011
 **  @author RussW
 **  @author PhilD
 **  
 ** Remember to revision and last updated date below on about line 36
 **/

/**
 * for edit changelog see https://github.com/ForumPostAssistant/FPA/pulls?q=is%3Apr+is%3Aclosed
 */
 

    /** SET THE FPA DEFAULTS *****************************************************************/
    # define ( '_FPA_DEV', TRUE );      // developer-mode, displays raw array data
    # define ( '_FPA_DIAG', TRUE );     // diagnostic-mode, turns on PHP logging errors, display errors and logs error to a file.

	/** SET THE JOOMLA! PARENT FLAG AND CONSTANTS ********************************************/
	define ( '_VALID_MOS', 1 );         // for J!1.0
	define ( '_JEXEC', 1 );             // for J!1.5, J!1.6, J!1.7, J!2.5, J!3.0


	// Define some basic assistant information

	define ( '_RES', 'Forum Post Assistant' );
	define ( '_RES_VERSION', '1.4.7 (litoralis)' );
	define ( '_last_updated', '12-Dec-2018' );
	define ( '_COPYRIGHT_STMT', ' Copyright &copy 2011-'. @date("Y").  ' Russell Winter, Phil DeGruy, Bernard Toplak, Claire Mandville, Sveinung Larsen. <br>' );
	define ( '_LICENSE_LINK', '<a href="http://www.gnu.org/licenses/" target="_blank">http://www.gnu.org/licenses/</a>' ); // link to GPL license
	define ( '_LICENSE_FOOTER', ' The FPA comes with ABSOLUTELY NO WARRANTY. <br> This is free software,
	and covered under the GNU GPLv3 or later license. You are welcome to redistribute it under certain conditions.
	For details read the LICENSE.txt file included in the download package with this script.
	A copy of the license may also be obtained at ' );
	define ( '_RES_RELEASE', '' );         // can be Alpha, Beta, RC, Final
	define ( '_RES_BRANCH', 'Branch en-GB' );    // can be playGround (Alpha/Beta only), currentDevelopment (RC only), masterPublic (Final only)
	define ( '_RES_LANG', '&nbsp Language en-GB' );               // Country/Language Code
	define ( '_RES_FPALINK', 'https://github.com/ForumPostAssistant/FPA/tarball/en-GB/' ); // where to get the latest 'Final Releases'
	define ( '_RES_FPALATEST', 'Get the latest tar.gz release of the ' );
	define ( '_RES_FPALINK2', 'https://github.com/ForumPostAssistant/FPA/zipball/en-GB/' ); // where to get the latest 'Final Releases'
	define ( '_RES_FPALATEST2', 'Get the latest zip release of the ' );

	/** DEFINE LANGUAGE STRINGS **************************************************************/
	define ( '_PHP_DISERR', 'Display PHP Errors Enabled' );
	define ( '_PHP_ERRREP', 'PHP Error Reporting Enabled' );
	define ( '_PHP_LOGERR', 'PHP Errors Being Logged To File' );
	// section titles & developer-mode array names
	define ( '_FPA_SNAP_TITLE', 'Environment Support Snapshot' );
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
	define ( '_FPA_SLOWGENPOST', 'Generating Post Output...' );
	define ( '_FPA_SLOWRUNTEST', 'Hang on while we run some tests...' );
	// remove script notice content - Phil 4-17-12
	define ( '_FPA_DELNOTE_LN1', '<h3><p /><font color="Red" size="2">** SECURITY NOTICE **</font color></size></h3><p /><font size="1">Due to the highly sensitive nature of the information displayed by the FPA script,<p /> it should be removed from the server immediately after use.</font>' );
	define ( '_FPA_DELNOTE_LN2', '<p /><font size="1">  If the script is left on the site, it can be used to gather enough information to hack your site.</font>' );
	define ( '_FPA_DELNOTE_LN3', '<p /><font color="Red" size="3" ;">After use, <a href="fpa-en.php?act=delete">Click Here</a>  to delete this script.</font>' );
	// dev/diag-mode content
	define ( '_FPA_DEVMI', 'developer-mode-information' );
	define ( '_FPA_ELAPSE', 'elapse-runtime' );
	define ( '_FPA_DEVENA', 'DEVELOPER MODE is enabled' );
	define ( '_FPA_DEVDSC', 'This means that a variety of additional information will be displayed on-screen to assist with troubleshooting this script.' );
	define ( '_FPA_DIAENA', 'DIGNOSTIC MODE is enabled' );
	define ( '_FPA_DIADSC', 'This means that all php and script errors will be displayed on-screen and logged out to a file named' );
	define ( '_FPA_DIAERR', 'Last DIGNOSTIC MODE Error' );
	define ( '_FPA_SPNOTE', 'Special Note' );
	// user post form content
	define ( '_FPA_INSTRUCTIONS', 'Instructions' );
	define ( '_FPA_INS_1', 'Enter your problem description <i>(optional)</i>' );
	define ( '_FPA_INS_2', 'Enter any error messages you see <i>(optional)</i>' );
	define ( '_FPA_INS_3', 'Enter any actions taken to resolve the issue <i>(optional)</i>' );
	define ( '_FPA_INS_4', 'Select detail level options of output <i>(optional)</i>' );
	define ( '_FPA_INS_5', 'Click the <span class="normal-note">Click Here To Generate Post</span> button to build the post content' );
	define ( '_FPA_INS_6', 'Copy the contents of the <span class="ok-hilite">&nbsp;Post Detail&nbsp;</span> box and paste it into a post following the instructions below the generated text box' );
	define ( '_FPA_INS_7', ' <div align="center"><font size="2">To copy the contents of the Post Detail box:
            </font></div>
            <p align="left" />
            <div align="left"><font size="2">1.) Place the cursor in the above box of generated text.</font></div>
            <p align="left" />
            <div align="left"><font size="2">2.) Use CTRL-a to select all the text within the box.</font></div>
            <p align="left" />
            <div align="left"><font size="2">3.) Use CTRL-c to copy the generated text to the browser clipboard.</font></div>
            <p align="left" />
            <div align="left"><font size="2">4.) Use CTRL-v to paste the copied text into your forum posting at the desired spot.</font></div> 
            <p align="left" />
            <div align="left"><font size="2">5.) Disable smilies to prevent charcters being converted by the forums software.</font></div> 
            <hr>
            <div align="left"><font size="2">If your site has many extensions installed, the forum post output could excede the posting limit. </font></div>
            <div align="left"><font size="2">If this happens, use more than one post, and utilize the optional settings to divide the output.  </font></div>
            <div align="left"><font size="2">Try generating first without plugins, and next with plugins but without components and modules.   </font></div>
            <p align="left" />
            <div align="left"><font size="2">Maximum number of characters pr. post are 20.000    <button type="button" onclick="CountCharacters()">Count Characters</button></div>
            <div align="center"><font size="3"> <output id ="chcount"></output></div>');
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
	define ( '_FPA_POSTD', 'Post Detail' );

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
	define ( '_FPA_SITE', 'SITE' );
	define ( '_FPA_ADMIN', 'ADMIN' );
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
	/** END LANGUAGE STRINGS *****************************************************************/

// ** delete script when done - Phil 8-07-12
// attempts to delete file from site. If it fails then message to manually delete the file is presented.
// fixed undefined index when server uses E_STRICT - Phil 9-20-12
 if (isset($_GET['act']) && $_GET['act']  == 'delete') {
		$host  = $_SERVER['HTTP_HOST'];
		$uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
		$extra = ''; // add index (or other) page if desired

	// try to set script to 777 to make sure we have permission to delete
		chmod("fpa-en.php", 0777);  // octal; correct value of mode
	// Delete the file.
		unlink('fpa-en.php');

	// Message and link to home page of site.
		echo '<div id="slowScreenSplash" style="padding:20px;border: 2px solid #4D8000;background-color:#FFFAF0;border-radius: 10px;-moz-border-radius: 10px;-webkit-border-radius: 10px;margin: 0 auto; margin-top:50px;margin-bottom:20px;width:700px;position:relative;z-index:9999;top:10%;" align="center">';
		$page= ("http://$host$uri/");
		$filename = 'fpa-en.php';
// Something went wrong and the script was not deleted so it must be removed manually so we tell the user to do so - Phil 8-07-12
	if (file_exists($filename)) {
		chmod("fpa-en.php", 0644);  // octal; correct value of mode
		echo "<p><font color='Red' size='4'>Oops!</size></font color>";
		echo "<p><font color='Red' size='3'>Something went wrong with the delete process and the file </font color><font color='#000000'size='3'>$filename</font color></size><font color='Red'> still exists. </font color></p>";
		echo "<p><font color='Red' size='3'>For site security, please remove the file </font color><font color='#000000'size='3'>$filename</font color></size><font color='Red'> manually using your ftp program.</font color></p>";

	} else {
		echo "<p><font color='#000000' size='3'>Thank You for using the FPA. </font color></p>";
	}
		echo "<a href='$page'>Go to your Home Page.</a>";

		exit;
	}
// end delete script

	/** DISPLAY A "PROCESSING" MESSAGE, if the the routines take too long ********************/
	// !TODO slowScreenSplash seems to be a little flaky
	// this is the top pink box
	echo '<div id="slowScreenSplash" style="padding:20px;border: 2px solid #4D8000;background-color:#FFFAF0;border-radius: 10px;-moz-border-radius: 10px;-webkit-border-radius: 10px;margin: 0 auto; margin-top:50px;margin-bottom:20px;width:810px;position:relative;z-index:9999;top:10%;" align="center">';
	echo '<h1>'. _RES .'</h1>';
	echo  _RES_VERSION .'-'. _RES_RELEASE .' ('. _RES_BRANCH . _RES_LANG.')';
	echo '<p>FPA last updated on: '. _last_updated . '</p>' ;

	if ( @$_POST['doIT'] == 1 ) {
		echo '<h3 style="color:#4D8000;">'. _FPA_SLOWGENPOST .'</h3>';
	} else {
		echo '<h3 style="color:#4D8000;">'. _FPA_SLOWRUNTEST .'</h3>';

	}


	echo _FPA_DELNOTE_LN1;
	echo _FPA_DELNOTE_LN2;
	echo _FPA_DELNOTE_LN3;
	echo '</div>';


	// setup the default runtime parameters and collect the POST data changes, if any
	if ( @$_POST['showProtected'] ) {
		$showProtected  = @$_POST['showProtected'];

	} else {
		$showProtected = 2; // default (limited privacy masking)

	}

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
	$apachereq[' mod_userdir']  = '';
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
?>



<?php
	// build the developer-mode function to display the raw arrays
	function showDev( &$section ) {

		// this can only have inline styling because it is outputed before the html styling
		if ( defined( '_FPA_DEV' ) ) {
			echo '<div style="width:750px;margin: 0px auto;margin-bottom:10px;font-family:arial;font-size:10px;color:#808080;">';
			echo '<div style="text-shadow: 1px 1px 1px #F5F5F5;font-weight:bold;color:#4D8000;text-transform:uppercase;padding-bottom:2px;">';
			echo '<span style="color: #808080;font-weight:normal;text-transform:lowercase;">['. _FPA_DEVMI .']</span><br />';
			echo $section['ARRNAME'] .' Array :';
			echo '</div>';

			echo '<div style="-moz-box-shadow: inset -3px -3px 3px #CAE897;-webkit-box-shadow: inset -3px -3px 3px #CAE897;box-shadow: inset -3px -3px 3px #CAE897;padding:5px;background-color:#E2F4C4; border:1px solid #4D8000;border-radius:5px;-moz-border-radius:5px;-webkit-border-radius:5px;">';
				print_r ( $section );
			echo '<p><em>'. _FPA_ELAPSE .': <strong>'. mt_end() .'</strong> '. _FPA_SECONDS .'</em></p>';
			echo '</div>';

			echo '</div>';
		} // end if _FPA_DEV defined
	} // end developer-mode function
?>



<?php
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



	/** DETERMINE IF THERE IS A KNOWN ERROR ALREADY *******************************************
	** here we try and determine if there is an existing php error log file, if there is we
	** then look to see how old it is, if it's less than one day old, lets see if what the last
	** error this and try and auto-enter that as the problem description
	*****************************************************************************************/

	/** is there an existing php error-log file? *********************************************/
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

			/** if the file was modified less than one day ago, grab the last error entry
			** Changed this section to get rid of the "Strict Standards: Only variables should be passed by reference"
			** error  Phil - 9-20-12 */
		if ( $now_time - $file_time < $age ) {
			/*  !FIXME memory allocation error on large php_error file - RussW
			** replaced these two lines with code below - Phil 09-23-12
			**  $lines = file( $phpenv['phpERRLOGFILE'] );
			**  $phpenv['phpLASTERR'] = array_pop( $lines );

	*********************************************
		** Begin the fix for the memory allocation error on large php_error file
		** Solution is to read the file line by line; not reading the whole file in memory.
		** I just open a kind of a pointer to it, then seek it char by char.
		** This is a more efficient way to work with large files.   - Phil 09-23-12  */
	$line = '';

	$f = fopen(($phpenv['phpERRLOGFILE']), 'r');
	$cursor = -1;

	fseek($f, $cursor, SEEK_END);
	$char = fgetc($f);

	/**
	* Trim trailing newline chars of the file
	*/
	while ($char === "\n" || $char === "\r") {
		fseek($f, $cursor--, SEEK_END);
		$char = fgetc($f);
		}

	/**
	* Read until the start of file or first newline char
	*/
	while ($char !== false && $char !== "\n" && $char !== "\r") {
	/**
	* Prepend the new char
	*/
		$line = $char . $line;
		fseek($f, $cursor--, SEEK_END);
		$char = fgetc($f);
		}

	// echo $line;
	$phpenv['phpLASTERR'] = $line;

		}
			}
	// ************** End Fix for memory allocation error when reading php_error file
?>

<?php
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
			ini_set( 'display_errors', 'Off' ); // default-display

			echo '<div style="text-shadow: 1px 1px 1px #FFF;float:right; text-align:center; width:'. $divwidth .'; background-color:#CAFFD8; border:1px solid #4D8000; color:#404040; font-size:10px; font-family:arial; padding:5px;-moz-box-shadow: 3px 3px 3px #C0C0c0;-webkit-box-shadow: 3px 3px 3px #C0C0c0;box-shadow: 3px 3px 3px #C0C0c0;border-radius:5px;-moz-border-radius:5px;-webkit-border-radius:5px;">';
			echo '<strong style="color:#4D8000;">'. _FPA_DEVENA .'</strong><br />';
			echo _FPA_DEVDSC;
			echo '</div>';
		} // end developer-mode display

		// display diagnostic-mode notice
		if ( defined( '_FPA_DIAG' ) ) {
			ini_set( 'display_errors', 1 );

			ini_set ( 'error_reporting', '-1' );
			ini_set( 'error_log', $fpa['diagLOG'] );

			echo '<div style="text-shadow: 1px 1px 1px #FFF;float:left; text-align:center; width:'. $divwidth .'; background-color:#CAFFD8; border:1px solid #4D8000; color:#404040; font-size:10px; font-family:arial; padding:5px;-moz-box-shadow: 3px 3px 3px #C0C0c0;-webkit-box-shadow: 3px 3px 3px #C0C0c0;box-shadow: 3px 3px 3px #C0C0c0;border-radius:5px;-moz-border-radius:5px;-webkit-border-radius:5px;">';
			echo '<strong style="color:#4D8000;">'. _FPA_DIAENA .'</strong><br />';
			echo _FPA_DIADSC .' '. $fpa['diagLOG'] .'.';
			echo '</div>';


				if ( file_exists( $fpa['diagLOG'] ) ) {
					echo '<br style="clear:both;" /><div style="margin-top:10px;text-align:left;text-shadow: 1px 1px 1px #FFF; width:740px; background-color:#FFFFCC; border:1px solid #800000; color:#404040; font-size:10px; font-family:arial; padding:5px;-moz-box-shadow: 3px 3px 3px #C0C0c0;-webkit-box-shadow: 3px 3px 3px #C0C0c0;box-shadow: 3px 3px 3px #C0C0c0;border-radius:5px;-moz-border-radius:5px;-webkit-border-radius:5px;">';
					echo '<strong style="color:#800000;">DIAGNOSTIC MODE ERROR</strong> in '. $fpa['diagLOG'] .'<br />';

					$fpa['fpaLASTERR'] = @array_pop( file( $fpa['diagLOG'] ) );
					echo $fpa['fpaLASTERR'];
					echo '</div>';

				} else {
					echo '<br style="clear:both;" /><div style="margin-top:10px;text-align:left;text-shadow: 1px 1px 1px #FFF; width:740px; background-color:#FFFFCC; border:1px solid #800000; color:#404040; font-size:10px; font-family:arial; padding:5px;-moz-box-shadow: 3px 3px 3px #C0C0c0;-webkit-box-shadow: 3px 3px 3px #C0C0c0;box-shadow: 3px 3px 3px #C0C0c0;border-radius:5px;-moz-border-radius:5px;-webkit-border-radius:5px;">';
					echo '<strong style="color:#800000;">'. _FPA_DIAERR .'</strong> '. _FPA_IN .' '. $fpa['diagLOG'] .'<br />';
					echo _FPA_NER;
					echo '</div>';
				}

		} // end diagnostic-mode display

		echo '<br style="clear:both;" />';
		echo '</div>';


	} else { // end developer- or diag -mode display
		ini_set( 'display_errors', 0 ); // default-display

	}


?>



<?php
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
	if ( ( file_exists( 'components/' ) AND file_exists( 'modules/' ) ) OR ( file_exists( 'administrator/components/' ) AND file_exists( 'administrator/modules/' ) ) ) {
		$instance['instanceFOUND'] = _FPA_Y;
	} else {
		$instance['instanceFOUND'] = _FPA_N;
	}



	/** what version is the instance? ********************************************************/
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

	/** Detect multiple instances of version file ***************************************/
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

	/** what version is the framework? (J!1.7 & above) ***************************************/
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

	/** is Joomla! installed/configured? *****************************************************/
	// determine exactly where the REAL configuration file is, it might not be the one in the "/" folder
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


	/** if present, is the configuration file valid? *****************************************/
		/** added code to fix the config version mis-match on 2.5 versions of Joomla - 4-8-12 - Phil *****/
		/** reworked code block to better determine version in 1.7 - 3.0+ versions of Joomla - 8-06-12 - Phil *****/
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
				$instance['cfgSANITY']['configNOTDIST'] = _FPA_Y;   // is not the distribution example
				$instance['cfgSANITY']['configNOWSPACE'] = _FPA_Y;  // no white-space
				$instance['cfgSANITY']['configOPTAG'] = _FPA_Y;     // has php open tag
				$instance['cfgSANITY']['configCLTAG'] = _FPA_Y;     // has php close tag
				$instance['cfgSANITY']['configJCONFIG'] = _FPA_Y;   // has php close tag

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


			// include configuration.php
			if ( $instance['configVALIDFOR'] != _FPA_U ) 
            {
    			ini_set( 'display_errors', 1 );
                $includeconfig = require_once($instance['configPATH']);
                $config = new JConfig();
                if ( defined( '_FPA_DIAG' ) ) {
                    ini_set( 'display_errors', 1 );
                    }
                    else
                    {
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
?>

<?php
	/** DETERMINE SYSTEM ENVIRONMENT & SETTINGS ***********************************************
	** here we try to determine the hosting enviroment and configuration
	** to try and avoid "white-screens" fpa tries to check for function availability before
	** using any function, but this does mean it has grown in size quite a bit and unfortunately
	** gets a little messy in places.
	*****************************************************************************************/

	/** what server and os is the host? ******************************************************/
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
?>



<?php
	/** DETERMINE PHP ENVIRONMENT & SETTINGS ***********************************************
	** here we try to determine the php enviroment and configuration
	** to try and avoid "white-screens" fpa tries to check for function availability before
	** using any function, but this does mean it has grown in size quite a bit and unfortunately
	** gets a little messy in places.
	*****************************************************************************************/

	/** general php related settings? *****************************************************/
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

	/** API and ownership related settings ***************************************************/
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



		/** WARNING WILL ROBINSON! ****************************************************************
		** THIS IS A TEST FEATURE AND AS SUCH NOT GUARANTEED TO BE 100% ACCURATE
		** try and cater for custom "su" environments, like cluster, grid and cloud computing.
		** this would include weird ownership combinations that allow group access to non-owner files
		** (like GoDaddy and a couple of grid and cloud providers I know of)
		*****************************************************************************************
		** took out this part: AND ( $instance['configWRITABLE'] == _FPA_Y )  as Joomla sets config file
		** to 444 so is read only permissions. Also changed this section:
		** ( $system['sysCURRUSER'] != $instance['configOWNER']['name'] from != to ==
		** If config owner is same as current user then we are probably using a custom "su" enviroment
		** such as LiteSpeed uses - 4-8-12 - Phil **/

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

?>




<?php
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
		/**
		* BERNARD: commented out
		* @todo: find out if this is even used on the webpage
		*/
		#print_r( get_extension_funcs( "cgi-fcgi" ) );
	}
	// !TODO see if there are IIS specific functions/modules
?>



<?php
	/** COMPLETE MODE (PERMISSIONS) CHECKS ON KNOWN FOLDERS ***********************************
	** test the mode and writability of known folders from the $folders array
	** to try and avoid "white-screens" fpa tries to check for function availability before
	** using any function, but this does mean it has grown in size quite a bit and unfortunately
	** gets a little messy in places.
	*****************************************************************************************/
	/** build the mode-set details for each folder *******************************************/
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
?>



<?php
	/** getDirectory FUNCTION TO RECURSIVELY READ THROUGH LOOKING FOR PERMISSIONS ************
	** this is used to read the directory structure and return a list of folders with 'elevated'
	** mode-sets ( -7- or --7 ) ignoring the first position as defaults folders are normally 755.
	** $dirCount is applied when the folder list is excessive to reduce unnecessary processing
	** on really sites with 00's or 000's of badly configured folder modes. Limited to displaying
	** the first 10 only.
	*****************************************************************************************/
	if ( $showElevated == '1' ) {

		$dirCount = 0;

		function getDirectory( $path = '.', $level = 0 ) {
			global $elevated, $dirCount;

			// directories to ignore when listing output. Many hosts
			$ignore = array( '.', '..' );

			// open the directory to the handle $dh
			if ( !$dh = @opendir( $path ) )
			{ # Bernard: if a folder is NOT readable, without this check we get endless loop
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
		/** Fixed Warning: Illegal string offset 'mode' on line 1476
		** Warning: Illegal string offset 'writable' on line 1477 - Phil 09-20-12*/
			if (isset( $dirCount) == '0' ) {
				$elevated['None'] = _FPA_NONE;
				$elevated['None']['mode'] = '-';
				$elevated['None']['writable'] = '-';
			}

		// now call the function to read from the selected folder ( '.' current location of FPA script )
		getDirectory( '.' );
		ksort( $elevated );

	} // end showElevated
?>



<?php
	/** DETERMINE THE MYSQL VERSION AND IF WE CAN CONNECT *************************************
	** here we try and find out more about MySQL and if we have an installed instance, see if
	** talk to it and access the database.
	*****************************************************************************************/
	$postgresql = _FPA_N;
	if ( $instance['instanceCONFIGURED'] == _FPA_Y AND ($instance['configDBCREDOK'] == _FPA_Y OR $instance['configDBCREDOK'] == _FPA_PMISS)) {
		$database['dbDOCHECKS'] = _FPA_Y;


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
			if (function_exists('mysql_connect')) {
			$dBconn = @mysql_connect( $instance['configDBHOST'], $instance['configDBUSER'], $instance['configDBPASS'] );
			$database['dbERROR'] = mysql_errno() .':'. mysql_error();

    @mysql_select_db( $instance['configDBNAME'], $dBconn );
    $sql = "select name,type,enabled from ".$instance['configDBPREF']."extensions where type='plugin' or type='component' or type='module' or type='template' or type='library'";
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
			$dBconn = @new mysqli( $instance['configDBHOST'], $instance['configDBUSER'], $instance['configDBPASS'], $instance['configDBNAME'] );
			$database['dbERROR'] = mysqli_connect_errno( $dBconn ) .':'. mysqli_connect_error( $dBconn );
			$sql = "select name,type,enabled from ". $instance['configDBPREF']."extensions where type='plugin' or type='component' or type='module' or type='template' or type='library'";
			$result = @$dBconn->query($sql);
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
		} // end of dataBase connection routines


		} elseif ( $instance['configDBTYPE'] == 'pdomysql')  {                                                                            
		  try {
		  $dBconn = new PDO("mysql:host=".$instance['configDBHOST'].";dbname=".$instance['configDBNAME'], $instance['configDBUSER'], $instance['configDBPASS']);

		  // set the PDO error mode to exception
		  $dBconn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		  }
		  catch(PDOException $e)
		  {
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
		  }
		  catch(PDOException $e)
		  {
		  }

			if ( $dBconn ) {
				$database['dbHOSTSERV']     = $dBconn->getAttribute(constant("PDO::ATTR_SERVER_VERSION" ));       // SQL server version
				$database['dbHOSTINFO']     = $dBconn->getAttribute(constant("PDO::ATTR_CONNECTION_STATUS" ));         // connection type to dB
				$database['dbHOSTCLIENT']   = $dBconn->getAttribute(constant("PDO::ATTR_CLIENT_VERSION" ));                // client library version
				$database['dbHOSTDEFCHSET'] = $dBconn->query("SELECT CHARSET('')")->fetchColumn();      // this is the hosts default character-set
				$database['dbHOSTSTATS']    = explode("  ", $dBconn->getAttribute(constant("PDO::ATTR_SERVER_INFO" )));  // latest statistics 
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
		  }
		  catch(PDOException $e)
		  {
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
		  }
		  catch(PDOException $e)
		  {
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
                        $crsql = $dBconn->query( " select count(*) from  " . $tables[$row['name']]['TABLE'] ."" );
						$cr = $crsql->fetch( PDO::FETCH_BOTH );
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

	// if no configuration or if configured but dBase credentials aren't valid
	} else {
		$database['dbDOCHECKS']     = _FPA_N;
		$database['dbLOCAL']        = _FPA_U;
	}
    if (!@$dBconn AND @$instance['configDBCREDOK'] == _FPA_PMISS ) {
		$instance['configDBCREDOK'] = _FPA_N;
		$database['dbDOCHECKS']     = _FPA_N;
	}

?>



<?php
	/** FIND AND ESTABLISH INSTALLED EXTENSIONS ***********************************************
	** this function recurively looks for installed Components, Modules, Plugins and Templates
	** it only reads the .xml file to determine installation status and info, some extensions
	** do not have an associated .xml file and wont be displayed (normally core extensions)
	**
	** modified version of the function for the recirsive folder permisisons previously
	*****************************************************************************************/
	if ( $instance['instanceFOUND'] == _FPA_Y ) { // fix for IIS *shrug*

		// this is a little funky and passes the extension array name bt variable reference
		// (&$arrname refers to each seperate array, which is called at the end) this was
		// depreciated at 5.3 and I couldn't find an alternative, so the fix to a PHP Warning
		// is to simply re-assign the $arrname back to itself inside the function, so it is
		//no-longer a reference
		function getDetails( $path, &$arrname, $loc, $level = 0 ) {
			global $component, $module, $plugin, $template, $library;

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
		}
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
?>

<?php
function recursive_array_search($needle,$haystack) {
    foreach($haystack as $key=>$value) {
        $current_key=$key;
        if($needle===$value OR (is_array($value) && recursive_array_search($needle,$value) !== false)) {
            return $current_key;
        }
    }
    return false;
}
?>







		<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

                <!-- NOTE (@RussW): attempt to reduce the chance of indexing, archiving or caching through robots meta, if left on server -->
                <meta name="robots" content="noindex, nofollow, noodp, nocache, noarchive" />			
			
		<title><?php echo _RES .' : v'. _RES_VERSION .' ('. _RES_RELEASE .' / '. _RES_LANG .')';
		echo '<p>FPA last updated on: '. _last_updated . '</p>' ;
		?></title>
		<?php //!TODO different icons ?>
		<link rel="shortcut icon" href="./templates/protostar/favicon.ico" />

		<style type="text/css" media="screen">
			html, body, div, p, span {
				font-size: 10px;
				font-family: tahoma, arial;
				color: #404040;
			}

			.dev-mode-information {
				margin: 0 auto;
				margin-top:10px;
				margin-bottom:10px;
				padding: 5px;
				width:830px;
				background-color:#CAFFD8;
				border:1px solid #4D8000;
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
				margin-top:10px;
				margin-bottom:10px;
				padding: 5px;
				width:840px;
				background-color:#F3EFE0;
				border:1px solid #999966;
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
				margin-top:10px;
				margin-bottom:10px;
				padding: 5px;
				width:840px;
				background-color:#E0FFFF;
				border:1px solid #42AEC2;
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
				text-align:center;
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
				margin-top:10px;
				margin-bottom:10px;
				padding: 5px;
				width:830px;
				background-color:#E0FFFF;
				border:1px solid #42AEC2;
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
				width:840px;
			}

			.half-section-information-left {
				float:left;
				min-height: 188px;
				margin-top:10px;
				margin-bottom:10px;
				padding: 5px;
				width:48%;
				background-color:#E0FFFF;
				border:1px solid #42AEC2;
				/** CSS3 **/
				box-shadow: 3px 3px 3px #C0C0C0;
				-moz-box-shadow: 3px 3px 3px #C0C0C0;
				-webkit-box-shadow: 3px 3px 3px #C0C0C0;
				border-radius: 5px;
				-moz-border-radius: 5px;
				-webkit-border-radius: 5px;
			}

			.half-section-information-right {
				float:right;
				min-height: 188px;
				margin-top:10px;
				margin-bottom:10px;
				padding: 5px;
				width:48%;
				background-color:#E0FFFF;
				border:1px solid #42AEC2;
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
				float:left;
				width: 23.7%;
				height: 50%;
				margin: 2px;
			}

			.mini-content-title {
				font-size: 8px;
				font-weight: bold;
				text-align:center;
				margin: 0px auto;
				margin-bottom: 4px !important;
				border-bottom: 1px solid #C0C0C0;
				text-transform: uppercase;
				/** CSS3 **/
				text-shadow: 1px 1px 1px #FFF;
			}

			.mini-content-box {
				font-size: 10px !important;
				text-align:center;
				margin: 0px auto;
				padding: 4px;
				border: 1px solid #42AEC2;
				height: 70px;
				background-color: #FFFFFF;
				/** CSS3 **/
				border-radius: 5px;
				-moz-border-radius: 5px;
				-webkit-border-radius: 5px;
			}

			.mini-content-box-small {
				font-size: 9px !important;
				text-align:center;
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
				clear:both;
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
				color:#4D8000;
				background-color: #FFF;
				padding:2px;
				margin-left: 5px;
				margin-right: 5px;
				font-weight:normal;
				border:1px solid #4D8000;
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
				border-radius: 5px;
				-moz-border-radius: 5px;
				-webkit-border-radius: 5px;
			}

			.alert-text {
				color: #800000;
			}

			.protected {
				color: #f60;
				background-color: #FFFFCC;
				line-height:9px;
				font-size:9px;
				font-weight:normal;
				text-transform:none;
			}
		</style>


		<!-- Show/Hide Post Form -->
		<script type="text/javascript">
		function toggle2(showHideDiv, switchTextDiv) {
			var ele = document.getElementById(showHideDiv);
			var text = document.getElementById(switchTextDiv);

			if ( ele.style.display == "block" ) {
				ele.style.display = "none";
				text.innerHTML = "<span style=\"font-size:12px;color:#4D8000;\"><span style=\"font-size:18px;color:#008000;\">&Theta;</span> Show the <strong><?php echo _RES; ?></strong></span>";
			} else {
				ele.style.display = "block";
				text.innerHTML = "<span style=\"font-size:12px;color:#800000;\"><span style=\"font-size:20px;color:#800000;\">&otimes;</span> Hide the <strong><?php echo _RES; ?></strong></span>";
			}
		}
		</script>

		<script>
			document.all["slowScreenSplash"].style.display = "none";
		</script>

    <!-- Count characters in post output -->
    <script>
    function CountCharacters() {
      var x = document.getElementById("postOUTPUT").value; 
      var sln = x.length + 140; 
      document.getElementById("chcount").innerHTML = sln; 
    }
    </script>

		</head>
<body>

<?php
	/** display the fpa heading ***************************************************************/
	echo '<div class="snapshot-information">';
	echo '<div class="header-title" style="">'. _RES .'</div>';
	echo '<div class="header-column-title" style="text-align:center;">'. _FPA_VER .': v'. _RES_VERSION .'-'. _RES_RELEASE .' ('. _RES_BRANCH .'&nbsp -'. _RES_LANG .')</div>';
	echo '<div class="header-column-title" style="text-align:center;"> FPA last updated on: '. _last_updated . '</p>' ;
	echo '<br />';

	/** ENVIRONMENT SUPPORT NOTICE (snapshot) **************************************************
	** this section displays a message explaining if the system, mysql and php environment
	** can support the discovered version of Joomla!
	**
	** REQUIREMENTS: (as far as I know!)
	**          ______________________________________________________
	**          | J3.0   | J1.7/6 | J!1.5.0-14 | J1.5.0-23 |  J!1.0  |
	** ------------------------------------------------------
	** MIN PHP  | 5.3.1  | 5.2.4  |   4.3.10   |  4.3.10   |  3.0.1  |
	** MAX PHP  | -----  | -----  |   5.2.17   |  5.3.6    |  4.4.9  | // 5.0.0 was first release to include MySQLi support
	** ------------------------------------------------------
	** MIN MYSQL | 5.1.6 | 5.0.4  |   3.23.0   |  3.23.0   |  3.0.0  |
	** MAX MYSQL | ----- | -----  |   5.1.43   |  5.1.43   |  5.0.91 | // only limited to 4.1.29 & 5.1 because install sql still has ENGINE TYPE statements (removed in MySQL 5.5)
	** ------------------------------------------------------
	** BAD PHP  | -----  | -----  |   4.39, 4.4.2, 5.0.5   |  -----  |
	** BAD SQL  | -----  | -----  |        >5.0.0          |  -----  |
	** BAD ZEND | -----  | -----  |         2.5.10         |  -----  |
	*****************************************************************************************/

	echo '<div>';
	echo '<div style="width:85%;margin:0 auto;margin-top:10px;">';

	/** SUPPORT SECTIONS *************************************************************/
	/** added a 2.5 section - Phil 4-20-12 *******/
	/** added a 3.1, 3.2 section - Phil 01-01-14
		Note:
		With the release of Joomla! 3.2, the CMS introduced a new feature called, Strong Passwords.
		The intent was to enhance the encryption of password hashing and storage through the use of BCrypt,
		thus increasing the security of Joomla! 3.2 user accounts. Bcrypt was not available in the early releases
		of php 5.3, and with the first releases, a bug in the algorithm surfaced. This prompted a change in the
		later php versions to fix it. The Joomla 3 series required a minimum php version of 5.3+ which unfortunately
		includes php versions without BCrypt and the buggy first release of BCrypt. The Strong Passwords feature
		has built in compatibility to determine if BCrypt was available based on a php version check of the Joomla
		installation's server. The version check is used to determine exactly what the Strong Passwords feature
		would enable, BCrypt or the next best available password hashing encryption available. Unfortunately,
		this can lead to access issues under certain circumstances.
		To reflect this issue with Joomla 3.2.0 and earlier versions of php 5.3, the FPA checks to see if
		the Joomla! version is 3.2.0 and then checks the php version on the server. If the version php version
		is less than 5.3.7 then the FPA will report that php does not support Joomla!
		PHP version of 5.3.1+ is supported by Joomla 3.2.1 due to the fix put in place in Joomla 3.2.1
		Mysql:
		On Medialayer at least, mysql 5.0.87-community will work with current versions of Joomla and has inno db enabled
		*******/
		
		/** MariaDB check. Get the Database type and look for MariaDB. All current versions of MariaDB 
			should be current with Joomla. The issue with using version numbers is mysql also uses numbers, 
			so this check differentiates between mysql and MariaDB. If there is a better idea given the 
			current FPA code feel free to submit it.  -- PhilD 03-17-17
		****/
		$input_line = @$database['dbHOSTSERV'];
		preg_match("/\b(\w*mariadb\w*)\b/i", $input_line, $output_array);
	
		
	if  (@$instance['cmsRELEASE'] >= '4.0') {
		$fpa['supportENV']['minPHP']        = '7.0.0';
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

	} elseif  (@$instance['cmsRELEASE'] == '3.10') {
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

	} elseif  (@$instance['cmsRELEASE'] > '3.7' and @$instance['cmsDEVLEVEL'] > '2') {
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

	} elseif ( @$instance['cmsRELEASE']  == '3.3' or @$instance['cmsRELEASE']  == '3.4')  {
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

	} elseif ( @$instance['cmsRELEASE'] == '3.2' and @$instance['cmsDEVLEVEL'] >= 1) {
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
	} elseif ( @$instance['cmsRELEASE'] == '3.2' and @$instance['cmsDEVLEVEL'] == 0) {
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
	//	$fpa['supportENV']['maxPHP']        = '4.4.9';
		$fpa['supportENV']['maxPHP']        = '5.2.17';   // changed max supported php from 4.4.9 to 5.2.17 - 03/12/17 - PD
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
	echo '<div style="font-weight:bold;font-size:9px;text-transform:uppercase;width:24%;float:left;text-align:center;">'. _FPA_SUPPHP .' J! '. @$instance['cmsRELEASE'] .'.' . @$instance['cmsDEVLEVEL'] .'<br />';

		if ( $fpa['supportENV']['minPHP'] == _FPA_NA ) {
			echo '<div class="normal-note"><span class="warn-text">'. _FPA_U .'</span></div>';
			$snapshot['phpSUP4J'] = _FPA_U;

		} elseif ( ( version_compare( PHP_VERSION, $fpa['supportENV']['minPHP'], '>=' ) ) AND ( version_compare( PHP_VERSION, $fpa['supportENV']['maxPHP'], '<=' ) ) ) {
			echo '<div class="normal-note"><span class="ok">'. _FPA_Y .'</span></div>';
			$snapshot['phpSUP4J'] = _FPA_Y;

		} elseif ( ( version_compare( PHP_VERSION, $fpa['supportENV']['minPHP'], '<' ) ) OR ( version_compare( PHP_VERSION, $fpa['supportENV']['maxPHP'], '>' ) ) ) {
			echo '<div class="normal-note"><span class="alert-text">'. _FPA_N .'</span></div>';
			$snapshot['phpSUP4J'] = _FPA_N;

		} else {
			echo '<div class="normal-note"><span class="warn-text">'. _FPA_U .'</span></div>';
			$snapshot['phpSUP4J'] = _FPA_U;
		}

	echo '</div>';


	// PHP API
	echo '<div style="font-weight:bold;font-size:9px;text-transform:uppercase;width:24%;float:left;text-align:center;">PHP API<br />';

		if ( @$phpenv['phpAPI'] ) {

			if ( @$phpenv['phpAPI'] == 'apache2handler' ) {
				echo '<div class="normal-note"><span class="warn-text">'. @$phpenv['phpAPI'] .'</span></div>';

			} else {
				echo '<div class="normal-note"><span class="ok">'. @$phpenv['phpAPI'] .'</span></div>';
			}

		} else {
			echo '<div class="normal-note"><span class="warn-text">'. _FPA_U .'</span></div>';
		}

	echo '</div>';


	// MySQL supported by PHP?
	echo '<div style="font-weight:bold;font-size:9px;text-transform:uppercase;width:24%;float:left;text-align:center;">'. _FPA_SUPPHP .' MySQL<br />';

		if ( array_key_exists( 'mysql', $phpextensions ) ) {
			echo '<div class="normal-note"><span class="ok">'. _FPA_Y .'</span></div>';
			$snapshot['phpSUP4MYSQL'] = _FPA_Y;

		} else {
			echo '<div class="normal-note"><span class="alert-text">'. _FPA_N .'</span></div>';
			$snapshot['phpSUP4MYSQL'] = _FPA_N;
		}

	echo '</div>';


	// MySQLi supported by PHP?
	echo '<div style="font-weight:bold;font-size:9px;text-transform:uppercase;width:24%;float:left;text-align:center;">'. _FPA_SUPPHP .' MySQLi<br />';

		if ( array_key_exists( 'mysqli', $phpextensions ) ) {
			echo '<div class="normal-note"><span class="ok">'. _FPA_Y .'</span></div>';
			$snapshot['phpSUP4MYSQL-i'] = _FPA_Y;

		} else {
			echo '<div class="normal-note"><span class="warn-text">'. _FPA_N .'</span></div>';
			$snapshot['phpSUP4MYSQL-i'] = _FPA_N;
		}

	echo '</div>';

	echo '<br style="clear:both;" /><br />';

	// minimum and maximum MySQL support requirements met?
	echo '<div style="font-weight:bold;font-size:9px;text-transform:uppercase;width:24%;float:left;text-align:center;">'. _FPA_SUPSQL .' J! '. @$instance['cmsRELEASE'] .'.' . @$instance['cmsDEVLEVEL'] .'<br />';

		if ( $fpa['supportENV']['minSQL'] == _FPA_NA OR @$database['dbERROR'] != _FPA_N ) {
			echo '<div class="normal-note"><span class="warn-text">'. _FPA_U .'</span></div>';
			$snapshot['sqlSUP4J'] = _FPA_U;

		} elseif ( ( version_compare( @$database['dbHOSTSERV'], $fpa['supportENV']['minSQL'], '>=' ) ) AND ( version_compare( @$database['dbHOSTSERV'], $fpa['supportENV']['maxSQL'], '<=' ) ) ) {

			// WARNING, will run, but ONLY after modifying install SQL to remove ENGINE TYPE statements (removed in MySQL 5.5)
			if ( ( $instance['cmsRELEASE'] == '1.5' ) AND ( @$database['dbHOSTSERV'] > '5.1.43' ) ) {
				echo '<div class="normal-note"><span class="warn-text">'. _FPA_M .' (<a href="http://forum.joomla.org/viewtopic.php?p=2297327" target="_new">'. _FPA_SPNOTE .'</a>)</span></div>';
				$snapshot['sqlSUP4J'] = _FPA_M;

			} else {
				echo '<div class="normal-note"><span class="ok">'. _FPA_Y .'</span></div>';
				$snapshot['sqlSUP4J'] = _FPA_Y;
			}

		} elseif ( ( version_compare( @$database['dbHOSTSERV'], $fpa['supportENV']['minSQL'], '<' ) ) OR ( version_compare( @$database['dbHOSTSERV'], $fpa['supportENV']['maxSQL'], '>' ) ) ) {

			// WARNING, will run, but ONLY after modifying install SQL to remove ENGINE TYPE statements (removed in MySQL 5.5)
			if ( ( $instance['cmsRELEASE'] == '1.5' ) AND ( @$database['dbHOSTSERV'] > '5.1.43' ) ) {
				echo '<div class="normal-note"><span class="warn-text">'. _FPA_M .' (<a href="http://forum.joomla.org/viewtopic.php?p=2297327" target="_new">'. _FPA_SPNOTE .'</a>)</span></div>';
				$snapshot['sqlSUP4J'] = _FPA_M;

			} 
			//Added this elseif to give the ok for postgreSQL
			elseif ($instance['configDBTYPE'] == 'postgresql' AND $database['dbHOSTSERV'] >= 8.3 ) {
				echo '<div class="normal-note"><span class="ok">'. _FPA_Y .'</span></div>';
				$snapshot['sqlSUP4J'] = _FPA_Y;
			}

			//Added this elseif to give the ok for PDO postgreSQL
			elseif ($instance['configDBTYPE'] == 'pgsql' AND $database['dbHOSTSERV'] >= 8.3 ) {
				echo '<div class="normal-note"><span class="ok">'. _FPA_Y .'</span></div>';
				$snapshot['sqlSUP4J'] = _FPA_Y;
			}
                         
			//Added this elseif to give the ok for MariaDB -- PhilD 03-17-17
			elseif (@$output_array[0] == "MariaDB") {
				echo '<div class="normal-note"><span class="ok">'. _FPA_MDB .'</span></div>';
				$snapshot['sqlSUP4J'] = _FPA_Y;
			}
			else {
				echo '<div class="normal-note"><span class="alert-text">'. _FPA_N .'</span></div>';
				$snapshot['sqlSUP4J'] = _FPA_N;
			}

		} else {
			echo '<div class="normal-note"><span class="warn-text">'. _FPA_U .'</span></div>';
			$snapshot['sqlSUP4J'] = _FPA_U;
		}

	echo '</div>';


	// MySQLi supported by MySQL?
	echo '<div style="font-weight:bold;font-size:9px;text-transform:uppercase;width:24%;float:left;text-align:center;">'. _FPA_SUPSQL .' MySQLi<br />';

		if ( !@$database['dbHOSTSERV'] OR @$database['dbERROR'] != _FPA_N ) {
			echo '<div class="normal-note"><span class="warn-text">'. _FPA_U .'</span></div>';
			$snapshot['sqlSUP4SQL-i'] = _FPA_U;

		} elseif ( version_compare( @$database['dbHOSTSERV'], '5.0.7', '>=' ) ) {
			echo '<div class="normal-note"><span class="ok">'. _FPA_Y .'</span></div>';

		} else {
			echo '<div class="normal-note"><span class="warn-text">'. _FPA_N .'</span></div>';
			$snapshot['sqlSUP4SQL-i'] = _FPA_N;
		}

	echo '</div>';


	// J! connection to MySQL
	echo '<div style="font-weight:bold;font-size:9px;text-transform:uppercase;width:24%;float:left;text-align:center;">Database Connection Type<br />';

		if ( @$instance['configDBTYPE'] ) {

			if ( ( @$snapshot['sqlSUP4SQL-i'] == _FPA_N OR @$snapshot['sqlSUP4SQL-i'] == _FPA_U ) AND @$instance['configDBTYPE'] == 'mysqli') {
				echo '<div class="normal-note"><span class="alert-text">'. @$instance['configDBTYPE'] .'</span></div>';

			} else {
				echo '<div class="normal-note"><span class="ok">'. @$instance['configDBTYPE'] .'</span></div>';
			}

		} else {
			echo '<div class="normal-note"><span class="warn-text">'. _FPA_U .'</span></div>';
		}

	echo '</div>';


	// MySQL default collation
	echo '<div style="font-weight:bold;font-size:9px;text-transform:uppercase;width:24%;float:left;text-align:center;">Database '. _FPA_DEF .' '. _FPA_TCOL .'<br />';

		if ( @$database['dbHOSTDEFCHSET'] ) {
			echo '<div class="normal-note"><span class="ok">'. @$database['dbHOSTDEFCHSET'] .'</span></div>';

		} else {
			echo '<div class="normal-note"><span class="warn-text">'. _FPA_U .'</span></div>';
		}

	echo '</div>';

	echo '<br style="clear:both;" /><br />';

	// Unsupported PHP version
	echo '<div style="font-weight:bold;font-size:9px;text-transform:uppercase;width:24%;float:left;text-align:center;">PHP '. _FPA_VER .'<br />';

		if ( version_compare( PHP_VERSION, '5', '<' ) ) {
			echo '<div class="normal-note"><span class="alert-text">'. PHP_VERSION .'</span></div>';

		} else {
			echo '<div class="normal-note"><span class="ok">'. PHP_VERSION .'</span></div>';
		}

	echo '</div>';


	// known buggy php releases (mainly for installation on 1.5)
	echo '<div style="font-weight:bold;font-size:9px;text-transform:uppercase;width:24%;float:left;text-align:center;">'. _FPA_BADPHP .'<br />';

		foreach ( $fpa['supportENV']['badPHP'] as $badKey => $badValue ) {
			if ( version_compare( PHP_VERSION, $badValue, '==' ) ) {
				$badANS = _FPA_Y;
				continue;
			}

		}

		if ( @$badANS == _FPA_Y ) {
			$badClass = 'alert-text';
			$snapshot['buggyPHP'] = _FPA_N;

		} else {
			$badANS = _FPA_N;
			$badClass = 'ok';
			$snapshot['buggyPHP'] = _FPA_N;
		}

	echo '<div class="normal-note"><span class="'. $badClass .'">'. $badANS .'</span></div>';

	echo '</div>';


	// MySQL Version
	echo '<div style="font-weight:bold;font-size:9px;text-transform:uppercase;width:24%;float:left;text-align:center;">Database '. _FPA_VER .'<br />';
	echo '<div class="normal-note">';
		if ( @$database['dbHOSTSERV'] ) {
			echo @$database['dbHOSTSERV'];
		} else {
			echo _FPA_U;
		}
	echo '</div>';
	echo '</div>';


	// known buggy zend releases (mainly for installation on 1.5)
	echo '<div style="font-weight:bold;font-size:9px;text-transform:uppercase;width:24%;float:left;text-align:center;">'. _FPA_BADZND .'<br />';
// reset variables to fix zend check bug
	$badValue = "";
	$badANS = "";
		foreach ( $fpa['supportENV']['badZND'] as $badKey => $badValue ) {

			if ( version_compare( $phpextensions['Zend Engine'], $badValue, '==' ) ) {
				$badANS = _FPA_Y;
				continue;
			}

		}

		if ( @$badANS == _FPA_Y ) {
			$badClass = 'alert-text';
			$snapshot['buggyZEND'] = _FPA_Y;

		} else {
			$badANS = _FPA_N;
			$badClass = 'ok';
			$snapshot['buggyZEND'] = _FPA_N;
		}

	echo '<div class="normal-note"><span class="'. $badClass .'">'. $badANS .'</span></div>';

	echo '</div>';


	echo '</div>';
	echo '<div style="clear:both;"><br /></div>';

	echo '</div>';



	//links for download that are found in the grey FPA box area.
	echo '<div style="text-align:center;"><a style="color:#4D8000!important;" href="'. _RES_FPALINK .''. _RES_LANG .'" target="_github">'. _RES_FPALATEST .' '. _RES .'</a></div>';
	echo '<div style="clear:both;"></div>';
	echo "<p></p>";
	echo '<div style="text-align:center!important;"><a style="color:#4D8000!important;" href="'. _RES_FPALINK2 .''. _RES_LANG .'" target="_github">'. _RES_FPALATEST2 .' '. _RES .'</a><p></div>';
	echo _FPA_DELNOTE_LN1;
	echo _FPA_DELNOTE_LN2;
	echo _FPA_DELNOTE_LN3;
	echo '</div>';
	showDev ( $snapshot );
	?>






	<!-- POST FORM -->
	<div style="margin: 0px auto;text-align:left;text-shadow: 1px 1px 1px #FFF; width:820px; background-color:#FFF;border:1px solid #999966; color:#4D8000; font-size:10px; font-family:arial; padding:5px;-moz-box-shadow: 3px 3px 3px #C0C0C0;-webkit-box-shadow: 3px 3px 3px #C0C0C0;box-shadow: 3px 3px 3px #C0C0C0;border-radius:5px;-moz-border-radius:5px;-webkit-border-radius:5px;">
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
						<strong><?php echo _FPA_INSTRUCTIONS;  ?></strong>

						<?php
							echo '<ol style="margin-left:-15px;">';
							echo '<li><span class="normal">'. _FPA_INS_1 .'</span></li>';
							echo '<li><span class="normal">'. _FPA_INS_2 .'</span></li>';
							echo '<li><span class="normal">'. _FPA_INS_3 .'</span></li>';
							echo '<li><span class="normal">'. _FPA_INS_4 .'</span></li><br />';
							echo '<li><span class="normal">'. _FPA_INS_5 .'</span></li><br />';
							echo '<li><span class="normal">'. _FPA_INS_6 .'</span></li>';
							echo '</ol>';
						?>
						</div>

					<br />

						<div class="normal-note" style="min-height:145px;padding-left:10px;">
						<strong>Optional Information</strong><br /><br />

							<form method="post" name="postDetails" id="postDetails">

								<div style="text-align:right;padding:2px;"><div class="normal" style="text-align:left;width:120px;float:left;"><?php echo _FPA_PROB_DSC; ?>:</div> <input class="normal-note" style="background-color: #FFFFCC;width:175px;font-size:9px;" type="text" name="probDSC" /></div>
								<div style="text-align:right;padding:2px;"><div class="normal" style="text-align:left;width:120px;float:left;"><?php echo _FPA_PROB_MSG; ?>:</div> <input class="normal-note" style="background-color: #FFFFCC;width:175px;font-size:9px;" type="text" name="probMSG1" /></div>

								<?php
									if ( isset($phpenv['phpLASTERR']) ) {
										echo '<div style="text-align:right;padding:2px;"><div class="warn-text" style="text-align:left;width:120px;float:left;">'. _FPA_LAST .' '. _FPA_ER .':</div> <input class="normal-note" style="color: #800000;background-color: #FFFFCC;width:175px;font-size:9px;" type="text" value="'. $phpenv['phpLASTERR'] .'" name="probMSG2" /><br /><span class="normal" style="font-size:8px;">auto-completed from your php error log&nbsp;&nbsp;</span></div>';
									} else {
										echo '<div style="text-align:right;padding:2px;"><div class="normal" style="text-align:left;width:120px;float:left;">'. _FPA_PROB_MSG .':</div> <input class="normal-note" style="background-color: #FFFFCC;width:175px;font-size:9px;" type="text" name="probMSG2" /></div>';
									}
								?>

								<div style="text-align:right;padding:2px;"><div class="normal" style="text-align:left;width:120px;float:left;"><?php  echo _FPA_PROB_ACT;  ?>:</div> <textarea class="normal-note" style="background-color: #FFFFCC;width:175px;font-size:9px;" type="text" name="probACT"></textarea></div>

								<?php  echo _FPA_POST_NOTE; ?>

						</div>

					</div>


					<div class="half-section-information-right" style="width:340px;padding-top:10px;padding-bottom:10px;border-color:#CCC;box-shadow: inset 3px 3px 3px #C0C0C0;-webkit-box-shadow: inset 3px 3px 3px #C0C0C0;background-color:transparent!important;">

						<div class="normal-note" style="min-height:135px;">
						<!-- intended Post location -->

						<div style="color:#4D8000;">
						<span style="color:#4D8000;font-weight:bold;padding-right:20px;"><strong>Run-Time Options</strong></span>
						</div>
						<br />



							<div style="float:left; width:170px;">

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

								<strong><?php echo _FPA_OPT .' '. $dis; ?>:</strong><br />				
								<input <?php echo $dis; ?> style="font-size:9px;" type="checkbox" name="showElevated" value="1" <?php echo $selectshowElevated ?> /><span class="normal"><?php echo _FPA_SHOWELV; ?></span><br />
								<input <?php echo $dis; ?> style="font-size:9px;" type="checkbox" name="showTables" value="1" <?php echo $selectshowTables ?> /><span class="normal"><?php echo _FPA_SHOWDBT; ?></span><br />
								<input <?php echo $dis; ?> style="font-size:9px;" type="checkbox" name="showComponents" value="1" <?php echo $selectshowComponents ?> /><span class="normal"><?php echo _FPA_SHOWCOM; ?></span><br />
								<input <?php echo $dis; ?> style="font-size:9px;" type="checkbox" name="showModules" value="1" <?php echo $selectshowModules ?> /><span class="normal"><?php echo _FPA_SHOWMOD; ?></span><br />
								<input <?php echo $dis; ?> style="font-size:9px;" type="checkbox" name="showLibraries" value="1" <?php echo $selectshowLibraries ?> /><span class="normal"><?php echo _FPA_SHOWLIB; ?></span><br />			
            					<input <?php echo $dis; ?> style="font-size:9px;" type="checkbox" name="showPlugins" value="1" <?php echo $selectshowPlugins ?> /><span class="normal"><?php echo _FPA_SHOWPLG; ?></span><br />
								<input <?php echo $dis; ?> style="font-size:9px;" type="checkbox" name="showCoreEx" value="1" <?php echo $selectshowCoreEx ?> /><span class="normal"><?php echo _FPA_SHOWCEX; ?></span><br />
							</div>

							<div style="float:right; width:150px;">
							<?php
								if ( $showProtected == 2 OR @$_POST['showProtected'] == 2 ) {
									$selectshowProtected_1 = '';
									$selectshowProtected_2 = 'CHECKED';
								} elseif ( $showProtected == 1 OR @$_POST['showProtected'] == 1 ) {
									$selectshowProtected_1 = 'CHECKED';
									$selectshowProtected_2 = '';
								} elseif ( $showProtected == 2 ) {
									$selectshowProtected_1 = '';
									$selectshowProtected_2 = 'CHECKED';
								} else {
									$selectshowProtected_1 = '';
									$selectshowProtected_2 = 'CHECKED';
								}
							?>

								<strong>Information Privacy :</strong><br />
								<input style="font-size:9px;" type="radio" name="showProtected" value="1" <?php echo $selectshowProtected_1; ?> /><span class="alert-text"><?php echo _FPA_PRIVNON; ?></span><br /><span style="line-height:8px;padding:0px;margin:0px;margin-left:15px;font-size:8px;"><?php echo _FPA_PRIVNONNOTE; ?></span><br />
								<input style="font-size:9px;" type="radio" name="showProtected" value="2" <?php echo $selectshowProtected_2; ?> /><span class="ok"><?php echo _FPA_PRIVPAR .' ('. _FPA_DEF .')'; ?></span><br /><span style="line-height:8px;padding:0px;margin:0px;margin-left:15px;font-size:8px;"><?php echo _FPA_PRIVPARNOTE; ?></span><br />
							</div>

						<div style="clear:both;"></div>
						</div>

					<br />

						<div class="normal-note" style="min-height:145px;">
						<div style="clear:both;"><br /></div>

							<!-- Generate the diagnostic post output -->
							<div style = "margin: 0px auto; width:90%;text-align:center;margin-top:10px;">
								<input type="hidden" name="doIT" value="1" />

								<input type="submit" class="ok-hilite" style="box-shadow: 2px 2px 2px #C0C0C0;-moz-box-shadow: 2px 2px 2px #C0C0C0;-webkit-box-shadow: 2px 2px 2px #C0C0C0;text-transform:uppercase;cursor:pointer;cursor:hand;" name="submit" value="<?php echo _FPA_CLICK; ?>" />

									<div class="normal" style="text-shadow:none!important;margin-left:10px;float:left;width:95%;text-align:left;">
										<br />
										<span class="ok"><?php echo _FPA_INS_5; ?></span>
									</div>


								<input type="reset" class="warn" style="font-size:8px;cursor:pointer;cursor:hand;" name="reset" value="reset" />


							<div style="clear:both;"><br /></div>
							</div>



							<div style="clear:both;"></div>
							<?php
								if ( @$_POST['increasePOPS'] ) {
									$selectPOPS = 'CHECKED';
								} else {
									$selectPOPS = '';
								}
							?>
							<!-- // !TODO make this more robust across multiple server configs -->
							<div class="normal" style="margin-left:15px;border-top:1px dotted #CCC;margin-top:30px;margin-right:15px;">
								<input style="font-size:9px;" type="checkbox" name="increasePOPS" value="1" <?php echo $selectPOPS; ?> />PHP &quot;<span class="warn-text"><?php echo _FPA_OUTMEM; ?></span>&quot; <?php echo _FPA_OR; ?> &quot;<span class="warn-text"><?php echo _FPA_OUTTIM; ?></span>&quot; <?php echo _FPA_ERRS; ?>?<br />
								<span style="margin-left:15px;font-size:8px;"><?php echo _FPA_INCPOPS; ?></span>
							</div>

						</div>

					</div>

				</div>

		<div style="clear:both;"></div>

		<?php
			if ( @$_POST['doIT'] == '1' ) {

				echo '<div class="normal-note" style="width:725px;text-align:center;margin: 0px auto;padding:2px;padding-top:5px;">';

				echo '<span class="ok" style="text-transform:uppercase;">'. _RES .' '. _FPA_POSTD .'</span><br />';


				/** LOAD UP THE SELECTED CONFIGURATION AND DIAGNOSTIC INFORMATION FOR THE POST ************
				** this section loads up a text-box with BBCode for the forum, it will quote each section
				** to make viewing easier and once used to the format, hopefully making it simpler to
				** pinpoint related information quickly
				**
				** the user then copies and pastes this outputin to forum post
				**
				** many "if/then/else" statements have been placed in single lines for ease of management,
				** this looks ugly and goes against coding practices but *shrug*, it's messy otherwise
				**
				** NOTE IF MODIFYING: carriage returns and line breaks MUST be double-quoted, not single-
				** quote, hence some of the weird quoting and formating
				*****************************************************************************************/
				echo '<textarea class="protected" style="width:700px;height:400px;font-size:9px;margin-top:5px;" type="text" rows="20" cols="100" name="postOUTPUT" id="postOUTPUT">';


				/** BBCode for the Joomla! Forum
				*****************************************************************************************/
					echo '[quote="'. _RES .' (v'. _RES_VERSION .') : '. @date( 'jS F Y' ) .'"]';

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
					echo '[color=Red][b]' . _FPA_MVFW . '[/b][/color]';}

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

            if ( $_POST['showProtected'] == '1' ) {
  						echo '[b]'. _FPA_OWNER .':[/b] '. $instance['configOWNER']['name'] .' (uid: '. isset($instance['configOWNER']['uid']) .'/gid: '. isset($instance['configOWNER']['gid']) .') | [b]'. _FPA_GROUP .':[/b] '. $instance['configGROUP']['name'] .' (gid: '. isset($instance['configGROUP']['gid']) .') | [b]Valid For:[/b] '. $instance['configVALIDFOR'];
              } else {
  						echo '[b]'. _FPA_OWNER .':[/b]  [color=orange]--'. _FPA_HIDDEN .'--[/color] . (uid: '. isset($instance['configOWNER']['uid']) .'/gid: '. isset($instance['configOWNER']['gid']) .') | [b]'. _FPA_GROUP .':[/b]  [color=orange]--'. _FPA_HIDDEN .'--[/color]  (gid: '. isset($instance['configGROUP']['gid']) .') | [b]Valid For:[/b] '. $instance['configVALIDFOR'];
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

					if ( $showProtected <> 1 ) {
					echo '[b]'. _FPA_HOST .' '. _FPA_CFG .' :: OS:[/b] '. $system['sysPLATOS'] .' |  [b]OS '._FPA_VER.':[/b] '. $system['sysPLATREL'] .' | [b]'. _FPA_TEC .':[/b] '. $system['sysPLATTECH'] .' | [b]'. _FPA_WSVR .':[/b] '. $system['sysSERVSIG'] .' | [b]Encoding:[/b] '. $system['sysENCODING'] .' | [b]'. _FPA_DROOT .':[/b] '. '[color=orange]--'. _FPA_HIDDEN .'--[/color]' .' | [b]'. _FPA_SYS .' TMP '. _FPA_WRITABLE .':[/b] ';
						if ( $system['sysTMPDIRWRITABLE'] == _FPA_Y ) { echo '[color=Green]'; } else { echo '[color=Red]'; }
						echo $system['sysTMPDIRWRITABLE'] .'[/color] | ';
					}else{
					echo '[b]'. _FPA_HOST .' '. _FPA_CFG .' :: OS:[/b] '. $system['sysPLATOS'] .' |  [b]OS '._FPA_VER.':[/b] '. $system['sysPLATREL'] .' | [b]'. _FPA_TEC .':[/b] '. $system['sysPLATTECH'] .' | [b]'. _FPA_WSVR .':[/b] '. $system['sysSERVSIG'] .' | [b]Encoding:[/b] '. $system['sysENCODING'] .' | [b]'. _FPA_DROOT .':[/b] '. $system['sysDOCROOT'] .' | [b]'. _FPA_SYS .' TMP '. _FPA_WRITABLE .':[/b] ';
						if ( $system['sysTMPDIRWRITABLE'] == _FPA_Y ) { echo '[color=Green]'; } else { echo '[color=Red]'; }
						echo $system['sysTMPDIRWRITABLE'] .'[/color] | ';
					}

					if ( function_exists( 'disk_free_space' ) )
						{
						$free_space = sprintf( '%.2f', disk_free_space( './' ) /1073741824 );
						$system['sysFREESPACE'] = $free_space .' GiB';
						  echo '[b]  ' . _FPA_FDSKSP . ' :[/b] ' . $system['sysFREESPACE'] . ' |';
						}
						else
						{
						  echo '[b]  ' . _FPA_FDSKSP . ' :[/b] ' . _FPA_U . ' |';
						}
                        
					echo "\r\n\r\n";

					echo '[b]PHP '. _FPA_CFG .' :: '. _FPA_VER .':[/b] ';
						if ( version_compare( $phpenv['phpVERSION'], '5.0.0', '<' ) ) { echo '[color=Red]'. $phpenv['phpVERSION'] .'[/color] | '; } else { echo '[b]'. $phpenv['phpVERSION'] .'[/b] | '; }

					echo '[b]PHP API:[/b] ';
						if ( $phpenv['phpAPI'] == 'apache2handler' ) { echo '[color=orange]'. $phpenv['phpAPI'] .'[/color] | '; } else { echo '[b]'. $phpenv['phpAPI'] .'[/b] | '; }

					echo '[b]Session Path '. _FPA_WRITABLE .':[/b] ';
						if ( $phpenv['phpSESSIONPATHWRITABLE'] == _FPA_Y ) { echo '[color=Green]'. $phpenv['phpSESSIONPATHWRITABLE'] .'[/color] | '; } elseif ( $phpenv['phpSESSIONPATHWRITABLE'] == _FPA_N ) { echo '[color=Red]'. $phpenv['phpSESSIONPATHWRITABLE'] .'[/color] | '; } else { echo '[color=orange]'. $phpenv['phpSESSIONPATHWRITABLE'] .'[/color] | '; }

					echo '[b]Display Errors:[/b] '. $phpenv['phpERRORDISPLAY'] .' | [b]Error Reporting:[/b] '. $phpenv['phpERRORREPORT'] .' | [b]Log Errors To:[/b] '. $phpenv['phpERRLOGFILE'] .' | [b]Last Known Error:[/b] '. @$phpenv['phpLASTERRDATE'] .' | [b]Register Globals:[/b] '. $phpenv['phpREGGLOBAL'] .' | [b]Magic Quotes:[/b] '. $phpenv['phpMAGICQUOTES'] .' | [b]Safe Mode:[/b] '. $phpenv['phpSAFEMODE'] .' | [b]Open Base:[/b] '. $phpenv['phpOPENBASE'] .' | [b]Uploads:[/b] '. $phpenv['phpUPLOADS'] .' | [b]Max. Upload Size:[/b] '. $phpenv['phpMAXUPSIZE'] .' | [b]Max. POST Size:[/b] '. $phpenv['phpMAXPOSTSIZE'] .' | [b]Max. Input Time:[/b] '. $phpenv['phpMAXINPUTTIME'] .' | [b]Max. Execution Time:[/b] '. $phpenv['phpMAXEXECTIME'] .' | [b]Memory Limit:[/b] '. $phpenv['phpMEMLIMIT'];

					echo "\r\n\r\n";

					echo '[b]Database '. _FPA_CFG .' :: [/b] ';
					if ( $database['dbDOCHECKS'] == _FPA_N ) {
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


					} elseif ( @$database['dbERROR'] != _FPA_N ) { echo '[b]'. _FPA_ECON .':[/b] ';

							if ( $_POST['showProtected'] == '3' ) {
								echo '[color=orange][b]'. _FPA_PRIVSTR .'[/b] '. _FPA_INFOPRI .'[/color], '. _FPA_BUT .' [color=Red]'. _FPA_ER .'[/color].';
							} else {
								echo '[color=Red]'. @$database['dbERROR'] .'[/color] : [color=orange]'. _FPA_DB .' '. _FPA_CREDPRES .'? '. _FPA_IN .' '. _FPA_CFG .'...[/color]';
							}

					} else {
						echo '[b]'. _FPA_VER .':[/b] [b]'. $database['dbHOSTSERV'] .'[/b] (Client:'. $database['dbHOSTCLIENT'] .') | ';

							if ( $_POST['showProtected'] > '1' ) { echo '[b]'. _FPA_HOST .':[/b]  [color=orange]--'. _FPA_HIDDEN .'--[/color] ([color=orange]--'. _FPA_HIDDEN .'--[/color]) | ';
							} else { echo '[b]'. _FPA_HOST .':[/b] '. $instance['configDBHOST'] .' ('. $database['dbHOSTINFO'] .') | '; }
							echo '[b]'. _FPA_DEF .' '. _FPA_TCOL .':[/b] '. $database['dbCOLLATION'] .' ([b]'. _FPA_DEF .' '. _FPA_CHARS .':[/b] '. $database['dbCHARSET'] .') | [b]'. _FPA_DB .' '. _FPA_TSIZ .':[/b] '. $database['dbSIZE'] .' | [b]#'. _FPA_OF .'&nbsp'. _FPA_TABLE .':&nbsp[/b] '. $database['dbTABLECOUNT'];
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
 				for($x = 0; $x < $arrlength; $x++) {
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
										if ( $show['type'] == _FPA_JCORE)
										{                      
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
										} else { $extenabled = '?' ;}
										} else { $extenabled = '?' ;}
										if ($extenabled <> 0 AND $extenabled <> 1 ){
										$extenabled = '?';
										}
										if ( $show['type'] == _FPA_3PD)
										{                      
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
										if ($extenabled <> 0 AND $extenabled <> 1 ){
										$extenabled = '?';
										}
										if ( $show['type'] == _FPA_JCORE)
										{                      
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
										} else { $extenabled = '?' ;}
										} else { $extenabled = '?' ;}
										if ($extenabled <> 0 AND $extenabled <> 1 ){
										$extenabled = '?';
										}
										if ( $show['type'] == _FPA_3PD)
										{                      
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
										} else { $extenabled = '?' ;}
										} else { $extenabled = '?' ;}
										if ($extenabled <> 0 AND $extenabled <> 1 ){
										$extenabled = '?';
										}
										if ( $show['type'] == _FPA_JCORE)
										{                      
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
										} else { $extenabled = '?' ;}
										} else { $extenabled = '?' ;}
										if ($extenabled <> 0 AND $extenabled <> 1 ){
										$extenabled = '?';
										}
										if ( $show['type'] == _FPA_3PD)
										{                      
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
										} else { $extenabled = '?' ;}
										} else { $extenabled = '?' ;}
										if ($extenabled <> 0 AND $extenabled <> 1 ){
										$extenabled = '?';
										}
										if ( $show['type'] == _FPA_JCORE)
										{                      
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
										if ($extenabled <> 0 AND $extenabled <> 1 ){
										$extenabled = '?';
										}
										if ( $show['type'] == _FPA_3PD)
										{                      
										echo  $show['name'] .' ('. $show['version'] .')  '.$extenabled.' | ';
										}
									}
								}
                                echo '[/color]';
			  			}
								echo "\r\n\r\n";                              


							if ( @$_POST['showLibraries'] == '1' ) {
								echo '[b]'. _FPA_EXTLIB_TITLE .' :: '. _FPA_SITE .' :: [/b]';
							if ( @$_POST[showCoreEx] == '1') {
								echo "\r\n";
								echo '[b] ' . _FPA_JCORE . ' :: [/b][color=Blue]';
                                if ( isset ($library['SITE'])) {
									foreach ( $library['SITE'] as $key => $show ) {
										if (isset($exset[0]['name'])) { 
										$extarrkey = recursive_array_search($show['name'], $exset);
                                        if ($extarrkey  !== False) {
										$extenabled = $exset[$extarrkey]['enabled'];
										} else { $extenabled = '?' ;}
										} else { $extenabled = '?' ;}
										if ($extenabled <> 0 AND $extenabled <> 1 ){
										$extenabled = '?';
										}
										if ( $show['type'] == _FPA_JCORE)
										{                      
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
										} else { $extenabled = '?' ;}
										} else { $extenabled = '?' ;}
										if ($extenabled <> 0 AND $extenabled <> 1 ){
										$extenabled = '?';
										}
										if ( $show['type'] == _FPA_3PD)
										{                      
										echo  $show['name'] .' ('. $show['version'] .')  '.$extenabled.' | ';
										}
									}
								}
                                    echo '[/color]';
			  			    }
								echo "\r\n\r\n";

							if ( @$_POST['showPlugins'] == '1' ) {
								echo '[b]'. _FPA_EXTPLG_TITLE .' :: '. _FPA_SITE .' :: [/b]';
							if ( $showCoreEx == 1) {
								echo "\r\n";
								echo '[b] ' . _FPA_JCORE . ' :: [/b][color=Blue]';
                                if ( isset ($plugin['SITE'])) {
									foreach ( $plugin['SITE'] as $key => $show ) {
										if (isset($exset[0]['name'])) { 
										$extarrkey = recursive_array_search($show['name'], $exset);
                                        if ($extarrkey  !== False) {
										$extenabled = $exset[$extarrkey]['enabled'];
										} else { $extenabled = '?' ;}
										} else { $extenabled = '?' ;}
										if ($extenabled <> 0 AND $extenabled <> 1 ){
										$extenabled = '?';
										}
										if ( $show['type'] == _FPA_JCORE)
										{                      
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
										} else { $extenabled = '?' ;}
										} else { $extenabled = '?' ;}
										if ($extenabled <> 0 AND $extenabled <> 1 ){
										$extenabled = '?';
										}
										if ( $show['type'] == _FPA_3PD)
										{                      
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
										  } else { $extenabled = '?' ;}
										  } else { $extenabled = '?' ;}
										if ($extenabled <> 0 AND $extenabled <> 1 ){
										  $extenabled = '?';
										}
										if (isset($tmpldef[0]['template'])) { 
										$extarrkey = recursive_array_search($show['name'], $tmpldef);
                                        if ($extarrkey  !== False) {
										$deftempl = $tmpldef[$extarrkey]['home'];    
                                        } else { $deftempl = '' ;}
										} else { $deftempl = '' ;}
										if ($deftempl == 1 ){                    
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
										if ( $show['type'] == _FPA_3PD OR $showCoreEx == 1)
										{                      
										if ( $show['type'] == _FPA_3PD)
										{                     
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
										  } else { $extenabled = '?' ;}
										  } else { $extenabled = '?' ;}
										if ($extenabled <> 0 AND $extenabled <> 1 ){
										  $extenabled = '?';
										}
										if (isset($tmpldef[0]['template'])) { 
										$extarrkey = recursive_array_search($show['name'], $tmpldef);
                                        if ($extarrkey  !== False) {
										$deftempl = $tmpldef[$extarrkey]['home'];    
                                        } else { $deftempl = '' ;}
										} else { $deftempl = '' ;}
										if ($deftempl == 1 ){                    
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
										if ( $show['type'] == _FPA_3PD OR $showCoreEx == 1)
										{                      
										if ( $show['type'] == _FPA_3PD)
										{                     
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
						} // end showProtected != strict


				echo '</textarea>';
				echo '<div style="clear:both;"><br /></div>';
				echo '<span class="ok">'. _FPA_INS_7 .'</span>';
				echo '<div style="clear:both;"><br /></div>';
				echo '</div>';

		?>

						</form>

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

		echo '<div class="section-title" style="text-align:center;">'. $instance['ARRNAME'] .' :: Discovery</div>';
		echo '<div class="" style="width:99%;margin: 0px auto;clear:both;margin-bottom:10px;">';
		// this is the column heading area, if any


		/** mini-content, shown in all cases *************************************************/
		echo '<div class="mini-content-container">';
		echo '<div class="mini-content-box">';
		echo '<div class="mini-content-title">CMS '. _FPA_F .'</div>';

                # die(var_dump($instance));
			if ( $instance['instanceFOUND'] == _FPA_Y ) {
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

			} else {
				echo '<div class="warn" style="margin: 0px auto;">'. @$instance['instanceFOUND'] .'</div>';
			}

		// Warning if more than one instance of version.php found
			if ($vFileSum > 1) { 
				echo "\r\n";          
				echo '<font color="Red">' . _FPA_MVFWF . '</font>';
			}
		echo '</div>';
		echo '</div>';




		// caters for the platform separation
		echo '<div class="mini-content-container">';
		echo '<div class="mini-content-box">';
		echo '<div class="mini-content-title">'. _FPA_PLATFORM .'</div>';

		if ( $instance['platformVFILE'] != _FPA_N ) {
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

		} elseif ( $instance['platformVFILE'] == _FPA_N AND $instance['cmsVFILE'] == _FPA_N) {
			echo '<div class="warn" style="margin: 0px auto;">'. _FPA_N .'</div>';

		} else {
			echo _FPA_NA;
		}

		echo '</div>';
		echo '</div>';


		echo '<div class="mini-content-container">';
		echo '<div class="mini-content-box">';
		echo '<div class="mini-content-title">'. _FPA_CF .' '. _FPA_E .'</div>';

			if ( $instance['instanceCONFIGURED'] == _FPA_N ) {
				$configuredClass = 'warn';

			} else {
				$configuredClass = 'ok';

			}

		echo '<div class="'. $configuredClass .'" style="margin: 0px auto;">'. $instance['instanceCONFIGURED'] .'</div>';
		echo '</div>';
		echo '</div>';


		echo '<div class="mini-content-container">';
		echo '<div class="mini-content-box">';
		echo '<div class="mini-content-title">'. _FPA_CF .' '. _FPA_VER .'</div>';

			if ( @$instance['instanceCFGVERMATCH'] == _FPA_Y ) {
				echo $instance['configVALIDFOR'];
				echo '<div class="ok" style="width:99%;margin: 0px auto;">'. _FPA_YMATCH .' CMS</div>';

			} elseif ( @$instance['instanceCFGVERMATCH'] == _FPA_N ) {
				echo $instance['configVALIDFOR'];
				echo '<div class="warn" style="width:99%;margin: 0px auto;">CMS '. _FPA_NMATCH .'</div>';

			} elseif ( @$instance['configVALIDFOR'] == _FPA_U ) {
				echo '<div class="warn" style="width:99%;margin: 0px auto;">'. $instance['configVALIDFOR'] .'</div>';

			}

		echo '</div>';
		echo '</div>';


		/** mini-content, only shown if instance found and configured ************************/
		if ( $instance['instanceCONFIGURED'] != _FPA_N AND $instance['instanceFOUND'] != _FPA_N ) {

			// force new line of mini-content-boxes
			echo '<div style="clear:both;"></div>';

			echo '<div class="mini-content-container">';
			echo '<div class="mini-content-box">';
			echo '<div class="mini-content-title">'. _FPA_CF .' '. _FPA_VALID .'</div>';

				if ( @$instance['configSANE'] == _FPA_Y AND @$instance['configSIZEVALID'] != _FPA_N ) {
					$saneClass = 'ok';
					$configVALID = _FPA_Y;

				} else {
					$saneClass = 'warn';
					$configVALID = _FPA_N;

				}

			echo '<div class="'. $saneClass .'" style="width:50px;margin: 0px auto;">'. $configVALID .'</div>';
			echo '</div>';
			echo '</div>';


			echo '<div class="mini-content-container">';
			echo '<div class="mini-content-box">';
			echo '<div class="mini-content-title">'. _FPA_CF .' '. _FPA_MODE .'</div>';

				// looking for --7 or -7- or -77 (default folder permissions are usually 755)
				if ( substr( $instance['configMODE'],0 ,1 ) == '7' OR substr( $instance['configMODE'],1 ,1 ) == '7' OR substr( $instance['configMODE'],2 ,1 ) == '7' ) {
					$modeClass = 'alert';

				} elseif ( $instance['configMODE'] <= '644' ) {
					$modeClass = 'ok';

				} elseif ( substr( $instance['configMODE'],1 ,1 ) >= '5' OR substr( $instance['configMODE'],2 ,1 ) >= '5' ) {
					$modeClass = 'warn';

				} elseif ( $instance['configMODE'] == _FPA_N ) {
					$modeClass = 'warn-text';

				} else {
					$modeClass = 'normal';

				}

			echo '<div class="'. $modeClass .'" style="width:50px;margin: 0px auto;">'. $instance['configMODE'] .'</div>';

				// is the file writable?
				if ( ( $instance['configWRITABLE'] == _FPA_Y ) AND ( substr( $instance['configMODE'],0 ,1 ) == '7' OR substr( $instance['configMODE'],1 ,1 ) == '7' OR substr( $instance['configMODE'],2 ,1 ) == '7' ) ) {
					$writeClass = 'alert';
					$canWrite = 'Writable';

				} elseif ( ( $instance['configWRITABLE'] == _FPA_Y ) AND ( substr( $instance['configMODE'],0 ,1 ) <= '6' ) ) {
					$writeClass = 'ok';
					$canWrite = _FPA_WRITABLE;

				} elseif ( ( $instance['configWRITABLE'] != _FPA_Y ) ) {
					$writeClass = 'warn';
					$canWrite = _FPA_RO;

				}

			echo '<div class="'. $writeClass .'" style="width:50px;margin: 0px auto;margin-top:1px;">'. $canWrite .'</div>';
			echo '</div>';
			echo '</div>';


			echo '<div class="mini-content-container">';
			echo '<div class="mini-content-box">';
			echo '<div class="mini-content-title">'. _FPA_CF .' '. _FPA_OWNER .'</div>';

				if ( $showProtected <= 2 ) {
					echo $instance['configOWNER']['name'];

				} else {
					echo '<span class="protected">[&nbsp;--&nbsp;'. _FPA_HIDDEN .'&nbsp;--&nbsp;]</span>&nbsp;';

				}

			echo '</div>';
			echo '</div>';


			echo '<div class="mini-content-container">';
			echo '<div class="mini-content-box">';
			echo '<div class="mini-content-title">'. _FPA_CF .' '. _FPA_GROUP .'</div>';

				if ( $showProtected <= 2 ) {
					echo $instance['configGROUP']['name'];

				} else {
					echo '<span class="protected">[&nbsp;--&nbsp;'. _FPA_HIDDEN .'&nbsp;--&nbsp;]</span>&nbsp;';

				}

			echo '</div>';
			echo '</div>';

		} // end if no instance or configuration found dont display

		echo '</div>';



		// only do mode/permissions checks if an instance was found in the intial checks
		if ( $instance['instanceFOUND'] != _FPA_Y ) {
			// this is the content area
			echo '<div class="row-content-container nothing-to-display" style="">';
			echo '<div class="warn" style=" margin-top:10px;margin-bottom:10px;">';
			echo _FPA_INSTANCE .' '. _FPA_NF .', '. _FPA_NO .' '. $instance['ARRNAME'].' '. _FPA_TESTP;

				if ( $instance['instanceCONFIGURED'] == _FPA_Y ) {
					echo '<br />'. _FPA_BUT .' '. _FPA_CFG .' '. _FPA_F;

				}

			echo '</div>';
			echo '</div>';

		}

		echo '</div>';
		// end content left block



		/** display the system information *************************************************/
		echo '<div class="half-section-information-right">'; // start right content block

		echo '<div class="section-title" style="text-align:center;">'. $instance['ARRNAME'] .' :: '. _FPA_CFG .'</div>';
		echo '<div class="" style="width:99%;margin: 0px auto;clear:both;margin-bottom:10px;">';

			// only do mode/permissions checks if an instance was found in the intial checks
			if ( $instance['instanceCONFIGURED'] == _FPA_Y AND $instance['configVALIDFOR'] != _FPA_U ) {

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
				echo '<div style="font-size:9px;width:99%;border-bottom: 1px dotted #c0c0c0;">'. _FPA_EN .':<div style="float:right;font-size:9px;">'. $instance['configSEF'] .'</div></div>';
				echo '<div style="font-size:9px;width:99%;border-bottom: 1px dotted #c0c0c0;">Suffix:<div style="float:right;font-size:9px;">'. $instance['configSEFSUFFIX'] .'</div></div>';

					if ( $system['sysSHORTWEB'] != 'MIC' AND ($instance['configSEFRWRITE'] == '1' OR $instance['configSEFRWRITE'] == 'true' ) AND $instance['configSITEHTWC'] != _FPA_Y ) {
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
				echo '<div style="font-size:9px;width:99%;border-bottom: 1px dotted #c0c0c0;">ErrorRep:<div style="float:right;font-size:9px;">'. $instance['configERRORREP'] .'</div></div>';
				echo '<div style="float:right;font-size:9px;width:99%;border-bottom: 1px dotted #c0c0c0;">Site Debug:<div style="float:right;font-size:9px;">'. $instance['configSITEDEBUG'] .'</div></div>';
				echo '<div style="float:right;font-size:9px;width:99%;border-bottom: 1px dotted #c0c0c0;">Lang Debug:<div style="float:right;font-size:9px;">'. $instance['configLANGDEBUG'] .'</div></div>';
				echo '</div>';
				echo '</div>';
				echo '</div>';


				echo '<div class="mini-content-container">';
				echo '<div class="mini-content-box">';
				echo '<div class="mini-content-title" style="margin-bottom:0px!important;">'. _FPA_DB .'</div>';
				echo '<div class="mini-content-box-small">';
				echo '<div style="font-size:9px;width:99%;border-bottom: 1px dotted #c0c0c0;">Type:<div style="float:right;font-size:9px;">'. $instance['configDBTYPE'] .'</div></div>';
				echo '<div style="font-size:9px;width:99%;border-bottom: 1px dotted #c0c0c0;">'. _FPA_VER .':<div style="float:right;font-size:9px;">'. @$database['dbHOSTSERV'] .'</div></div>';
				echo '<div style="font-size:9px;width:99%;border-bottom: 1px dotted #c0c0c0;">CharSet:<div style="float:right;font-size:9px;">'. @$database['dbCHARSET'] .'</div></div>';
				echo '</div>';
				echo '</div>';
				echo '</div>';


				echo '<div class="mini-content-container">';
				echo '<div class="mini-content-box">';
				echo '<div class="mini-content-title">'. _FPA_DB .' '. _FPA_CRED .'</div>';

					if ( $instance['configDBCREDOK'] == _FPA_Y ) {
						echo '<div class="ok" style="width:99%;margin: 0px auto;font-size:9px;">'. _FPA_YACOMP .'</div>';
					} else {
						echo '<div class="warn" style="width:99%;margin: 0px auto;font-size:9px;">'. _FPA_NACOMP .'</div>';
					}

				echo '</div>';
				echo '</div>';


				echo '<div class="mini-content-container">';
				echo '<div class="mini-content-box">';
				echo '<div class="mini-content-title" style="margin-bottom:0px!important;">'. _FPA_SEC .'</div>';
				echo '<div class="mini-content-box-small">';
				echo '<div style="font-size:9px;width:99%;border-bottom: 1px dotted #c0c0c0;">SSL:<div style="float:right;font-size:9px;">'. $instance['configSSL'] .'</div></div>';
				echo '<div style="font-size:9px;width:99%;border-bottom: 1px dotted #c0c0c0;">Def\' Access:<div style="float:right;font-size:9px;">'. $instance['configACCESS'] .'</div></div>';
				echo '</div>';
				echo '</div>';
				echo '</div>';


				echo '<div class="mini-content-container">';
				echo '<div class="mini-content-box">';
				echo '<div class="mini-content-title" style="margin-bottom:0px!important;">'. _FPA_FEAT .'</div>';
				echo '<div class="mini-content-box-small">';
				echo '<div style="font-size:9px;width:99%;border-bottom: 1px dotted #c0c0c0;">FTP:<div style="float:right;font-size:9px;">'. $instance['configFTP'] .'</div></div>';
				echo '<div style="font-size:9px;width:99%;border-bottom: 1px dotted #c0c0c0;">Unicode Slug:<div style="float:right;font-size:9px;">'. $instance['configUNICODE'] .'</div></div>';
				echo '</div>';
				echo '</div>';
				echo '</div>';


			} else { // an instance wasn't found in the initial checks, so no folders to check


				echo '<div class="mini-content-container">';
				echo '<div class="mini-content-box">';
				echo '<div class="mini-content-title">'. _FPA_CF .' '. _FPA_VER .'</div>';
				echo '<div class="warn" style="width:50px;margin: 0px auto;">'. _FPA_U .'</div>';
				echo '</div>';
				echo '</div>';


				echo '<div class="mini-content-container">';
				echo '<div class="mini-content-box">';
				echo '<div class="mini-content-title">'. _FPA_CF .' '. _FPA_VALID .'</div>';

					if ( @$instance['configSIZEVALID'] == _FPA_N ) {
						echo '<div class="warn" style="width:99%;margin: 0px auto;">'. _FPA_EMPTY .'</div>';
					}

				echo '</div>';
				echo '</div>';


				echo '<div class="row-content-container nothing-to-display" style="">';
				echo '<div class="warn" style=" margin-top:10px;margin-bottom:10px;">';
				echo _FPA_CFG .' '. _FPA_NF .' '. _FPA_OR .' '. _FPA_NVALID .'<br /> '. _FPA_NO .' '. $instance['ARRNAME'] .' '. _FPA_TESTP;
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

		echo '<div class="section-title" style="text-align:center;">'. $database['ARRNAME'] .' :: '. _FPA_DISC .'</div>';
		echo '<div class="" style="width:99%;margin: 0px auto;clear:both;margin-bottom:10px;">';

		echo '<div class="mini-content-box-small" style="">';
		echo '<div style="line-height:10px;float:left;font-size:8px;color:#404040;text-shadow: #fff 1px 1px 1px; width:99%;border-bottom:1px solid #ccebeb;font-weight:bold;padding:1px;padding-right:0px;padding-bottom:0px;text-transform:uppercase;">'. @$instance['configDBTYPE'] .' '. _FPA_VER .':<div style="line-height:11px;text-transform:none!important;float:right;font-size:9px;font-weight:normal;width:60%;background-color:#fff;text-align:right;padding:1px;padding-top:0px;border-top-right-radius: 5px;-moz-border-top-right-radius: 5px;-webkit-border-top-right-radius: 5px;  border-top-left-radius: 5px;-moz-border-top-left-radius: 5px;-webkit-border-top-left-radius: 5px;border-right: 1px solid #42AEC2;border-left: 1px solid #42AEC2;border-top: 1px solid #42AEC2;1px solid #ccebeb;">';

			if ( @$database['dbHOSTSERV'] ) {
				echo '<span class="normal">'. _FPA_SERV .': '. $database['dbHOSTSERV'] .'&nbsp;</span>';

			} else {
				echo '<span class="normal">'. _FPA_SERV .':</span> <span class="warn-text">'. _FPA_U .'&nbsp;</span>';
			}

			if ( @$database['dbHOSTCLIENT'] ) {
				echo '<span class="normal">&nbsp;&nbsp;'. _FPA_CLNT .': '. $database['dbHOSTCLIENT'] .'&nbsp;</span>';

			} else {
				echo '<span class="normal">&nbsp;&nbsp;'. _FPA_CLNT .':</span> <span class="warn-text">'. _FPA_U .'&nbsp;</span>';
			}

		echo '</div></div>';
		echo '</div>';


		echo '<div class="mini-content-box-small" style="">';
		echo '<div style="line-height:10px;float:left;font-size:8px;color:#404040;text-shadow: #fff 1px 1px 1px;width:99%;border-bottom:1px solid #ccebeb;font-weight:bold;padding:1px;padding-top:0px;padding-right:0px;padding-bottom:0px;text-transform:uppercase;">'. @$instance['configDBTYPE'] .' '. _FPA_HNAME .':<div style="line-height:11px;text-transform:none!important;float:right;font-size:9px;font-weight:normal;width:60%;background-color:#fff;text-align:right;padding:1px;padding-top:0px;border-right: 1px solid #42AEC2;border-left: 1px solid #42AEC2;1px solid #ccebeb;">';

			if ( $showProtected == 1 ) {

				if ( $instance['configDBHOST'] ) {
					echo '<div class="normal">&nbsp;'. $instance['configDBHOST'] .'&nbsp;</div>';

				} else {
					echo '<span class="alert-text">&nbsp;'. _FPA_NC .'&nbsp;</span>';
				}

			} else {
				echo '<span class="protected">[&nbsp;--&nbsp;'. _FPA_HIDDEN .'&nbsp;--&nbsp;]</span>&nbsp;';
			}

		echo '</div></div>';
		echo '</div>';


		echo '<div class="mini-content-box-small" style="">';
		echo '<div style="line-height:10px;float:left;font-size:8px;color:#404040;text-shadow: #fff 1px 1px 1px;width:99%;border-bottom:1px solid #ccebeb;font-weight:bold;padding:1px;padding-top:0px;padding-right:0px;padding-bottom:0px;text-transform:uppercase;">'. _FPA_CONT .':<div style="line-height:11px;text-transform:none!important;float:right;font-size:9px;font-weight:normal;width:60%;background-color:#fff;text-align:right;padding:1px;padding-top:0px;border-right: 1px solid #42AEC2;border-left: 1px solid #42AEC2;1px solid #ccebeb;">';

		echo '<span class="normal">';

			if ( $database['dbLOCAL'] == _FPA_Y ) {
				echo '('. _FPA_LOCAL .') '. @$database['dbHOSTINFO'] .'&nbsp';

			} elseif ( $database['dbLOCAL'] == _FPA_N AND @$database['dbHOSTINFO'] ) {

				if ( $showProtected <= 2 ) {
					echo '('. _FPA_REMOTE .') '. $database['dbHOSTINFO'] .'&nbsp';

				} else {
					echo '<span class="protected">[&nbsp;--&nbsp;'. _FPA_HIDDEN .'&nbsp;--&nbsp;]</span>&nbsp;';
				}

			} elseif ( $database['dbLOCAL'] == _FPA_N AND !@$database['dbHOSTINFO'] ) {
				echo '('. _FPA_REMOTE .') <span class="warn-text"> '. _FPA_U .'</span>&nbsp';

			} else {
				echo '<span class="warn-text">'. _FPA_U .'</span>';
			}

			echo '</span>';

		echo '</div></div>';
		echo '</div>';


		echo '<div class="mini-content-box-small" style="">';
		echo '<div style="line-height:10px;float:left;font-size:8px;color:#404040;text-shadow: #fff 1px 1px 1px;width:99%;border-bottom:1px solid #ccebeb;font-weight:bold;padding:1px;padding-top:0px;padding-right:0px;padding-bottom:0px;text-transform:uppercase;">PHP '. _FPA_SUP .':<div style="line-height:11px;text-transform:none!important;float:right;font-size:9px;font-weight:normal;width:60%;background-color:#fff;text-align:right;padding:1px;padding-top:0px;border-right: 1px solid #42AEC2;border-left: 1px solid #42AEC2;1px solid #ccebeb;">';

			if ( @$instance['configDBTYPE'] == 'mysqli' AND $phpenv['phpSUPPORTSMYSQLI'] == _FPA_N ) {
				echo '<span class="alert-text">'. $instance['configDBTYPE'] .' '. _FPA_IS .' '. _FPA_NSUP .' '. _FPA_BY .' PHP '. $phpenv['phpVERSION'] .'&nbsp;</span>';

			} elseif (  @$instance['configDBTYPE'] == 'mysql' AND $phpenv['phpSUPPORTSMYSQL'] == _FPA_N ) {
 				echo '<span class="alert-text">'. $instance['configDBTYPE'] .' '. _FPA_IS .' '. _FPA_NSUP .' '. _FPA_BY .' PHP '. $phpenv['phpVERSION'] .'&nbsp;</span>';

			} elseif ( ( @$instance['configDBTYPE'] == 'mysqli' AND $phpenv['phpSUPPORTSMYSQLI'] == _FPA_Y ) OR ( @$instance['configDBTYPE'] == 'mysql' AND $phpenv['phpSUPPORTSMYSQL'] == _FPA_Y ) OR @$instance['configDBTYPE'] == 'pdomysql' OR @$instance['configDBTYPE'] == 'postgresql'OR @$instance['configDBTYPE'] == 'pgsql') {
				echo '<span class="ok">'. $instance['configDBTYPE'] .' '. _FPA_IS .' '. _FPA_YSUP .' '. _FPA_BY .' PHP '. $phpenv['phpVERSION'] .'&nbsp;</span>';

			} else {
				echo '<span class="warn-text">PHP '. $phpenv['phpVERSION'] .' '. _FPA_SUP .' '. _FPA_IS .' '. _FPA_U .'&nbsp;</span>';
			}

		echo '</div></div>';
		echo '</div>';


		echo '<div class="mini-content-box-small" style="">';
		echo '<div style="line-height:10px;float:left;font-size:8px;color:#404040;text-shadow: #fff 1px 1px 1px;width:99%;border-bottom:1px solid #ccebeb;font-weight:bold;padding:1px;padding-top:0px;padding-right:0px;padding-bottom:0px;text-transform:uppercase;">'. _FPA_CON .' '. _FPA_TO .' '. @$instance['configDBTYPE'] .':<div style="line-height:11px;text-transform:none!important;float:right;font-size:9px;font-weight:normal;width:60%;background-color:#fff;text-align:right;padding:1px;padding-top:0px;border-right: 1px solid #42AEC2;border-left: 1px solid #42AEC2;1px solid #ccebeb;">';

			if ( $database['dbDOCHECKS'] == _FPA_N ) {
				echo '<span class="warn-text">&nbsp;'. _FPA_NOA .', '. _FPA_NC .'&nbsp;</span>';

			} elseif ( @$database['dbERROR'] == _FPA_N ) {
				echo '<span class="ok">&nbsp;'. _FPA_Y .', '. _FPA_YCON .'&nbsp;</span>';

			} elseif ( @$database['dbERROR'] != _FPA_N ) {
				echo '<span class="alert-text">&nbsp;'. _FPA_N .', '. _FPA_ER .'&nbsp;</span>';
			}

		echo '</div></div>';
		echo '</div>';



			if ( @$database['dbERROR'] AND @$database['dbERROR'] != _FPA_N ) {

				echo '<div class="mini-content-box-small" style="">';
				echo '<div class="alert-text" style="line-height:10px;float:left;text-shadow: #fff 1px 1px 1px;border-bottom: 1px solid #ccebeb;font-size:8px;width:99%;font-weight:bold;padding:1px;padding-top:0px;padding-right:0px;padding-bottom:0px;text-transform:uppercase;">'. _FPA_ECON .':<div style="line-height:11px;text-transform:none!important;float:right;font-size:9px;font-weight:normal;width:60%;background-color:#fff;text-align:right;padding:1px;padding-top:0px;border-right: 1px solid #42AEC2;border-left: 1px solid #42AEC2;border-bottom: 1px solid #ccebeb;">';

				echo '<div class="alert" style="margin:5px;font-weight:normal;font-size:9px;padding:2px;">'. $database['dbERROR'] .'</div>';

				echo '</div></div>';
				echo '</div>';
				echo '<br style="clear:both;" />';
			}


		echo '<div class="mini-content-box-small" style="">';
		echo '<div style="line-height:10px;float:left;font-size:8px;color:#404040;text-shadow: #fff 1px 1px 1px;width:99%;border-bottom: 1px solid #ccebeb;font-weight:bold;padding:1px;padding-top:0px;padding-right:0px;padding-bottom:0px;text-transform:uppercase;">'. @$instance['configDBTYPE'] .' '. _FPA_CHARS .':<div style="line-height:11px;text-transform:none!important;float:right;font-size:9px;font-weight:normal;width:60%;background-color:#fff;text-align:right;padding:1px;padding-top:0px;border-right: 1px solid #42AEC2;border-left: 1px solid #42AEC2;border-bottom: 1px solid #ccebeb;">';

			if ( @$database['dbCHARSET'] ) {
				echo '<span class="normal">&nbsp;'. $database['dbCHARSET'] .'&nbsp;</span>';

			} else {
				echo '<span class="warn-text">&nbsp;'. _FPA_U .'&nbsp;</span>';
			}

		echo '</div></div>';
		echo '</div>';


		echo '<div class="mini-content-box-small" style="">';
		echo '<div style="line-height:10px;float:left;font-size:8px;color:#404040;text-shadow: #fff 1px 1px 1px;width:99%;border-bottom: 1px solid #ccebeb;font-weight:bold;padding:1px;padding-top:0px;padding-right:0px;padding-bottom:0px;text-transform:uppercase;">'. _FPA_DEF .' '. _FPA_CHARS .':<div style="line-height:11px;text-transform:none!important;float:right;font-size:9px;font-weight:normal;width:60%;background-color:#fff;text-align:right;padding:1px;padding-top:0px;border-right: 1px solid #42AEC2;border-left: 1px solid #42AEC2;border-bottom: 1px solid #ccebeb;">';

			if ( @$database['dbHOSTDEFCHSET'] ) {
				echo '<span class="normal">&nbsp;'. $database['dbHOSTDEFCHSET'] .'&nbsp;</span>';

			} else {
				echo '<span class="warn-text">&nbsp;'. _FPA_U .'&nbsp;</span>';
			}

		echo '</div></div>';
		echo '</div>';


		echo '<div class="mini-content-box-small" style="">';
		echo '<div style="line-height:10px;float:left;font-size:8px;color:#404040;text-shadow: #fff 1px 1px 1px;width:99%;border-bottom: 1px solid #ccebeb;font-weight:bold;padding:1px;padding-top:0px;padding-right:0px;padding-bottom:0px;text-transform:uppercase;">'. _FPA_DB .' '. _FPA_TCOL .':<div style="line-height:11px;text-transform:none!important;float:right;font-size:9px;font-weight:normal;width:60%;background-color:#fff;text-align:right;padding:1px;padding-top:0px;border-right: 1px solid #42AEC2;border-left: 1px solid #42AEC2;border-bottom: 1px solid #ccebeb;">';

			if ( @$database['dbCOLLATION'] ) {
				echo '<div class="normal">&nbsp;'. $database['dbCOLLATION'] .'&nbsp;</div>';

			} elseif ( @$database['dbERROR'] != _FPA_N ) {
				echo '<span class="warn-text">&nbsp;'. _FPA_U .'&nbsp;</span>';

			} else {
				echo '<span class="warn-text">&nbsp;'. _FPA_NC .'&nbsp;</span>';
			}

		echo '</div></div>';
		echo '</div>';


		echo '<div class="mini-content-box-small" style="">';
		echo '<div style="line-height:10px;float:left;font-size:8px;color:#404040;text-shadow: #fff 1px 1px 1px;width:99%;font-weight:bold;padding:1px;padding-right:0px;padding-top:0px;padding-bottom:0px;text-transform:uppercase;">'. _FPA_DB .' '. _FPA_TSIZ .':<div style="line-height:9px;text-transform:none!important;float:right;font-size:11px;font-weight:normal;width:60%;background-color:#fff;text-align:right;padding:1px;padding-top:0px;border-bottom-right-radius: 5px;-moz-border-bottom-right-radius: 5px;-webkit-border-bottom-right-radius: 5px;  border-bottom-left-radius: 5px;-moz-border-bottom-left-radius: 5px;-webkit-border-bottom-left-radius: 5px;border-right: 1px solid #42AEC2;border-left: 1px solid #42AEC2;border-bottom: 1px solid #42AEC2;">';

			if ( @$database['dbSIZE'] ) {
				echo '<span class="normal">&nbsp;'. $database['dbSIZE'] .'&nbsp;</span>';

			} else {
				echo '<span class="warn-text">&nbsp;'. _FPA_U .'&nbsp;</span>';
			}

		echo '</div></div>';


		if ( @$instance['configDBCREDOK'] != _FPA_Y AND $instance['instanceFOUND'] == _FPA_Y ) {
		echo '<br /><br />';
		echo '<div class="mini-content-box-small" style="">';
		echo '<div style="line-height:10px;font-size:8px;color:#404040;text-shadow: #fff 1px 1px 1px;width:99%;border-bottom: 1px solid #ccebeb;font-weight:bold;padding:1px;padding-top:0px;padding-right:0px;padding-bottom:2px;text-transform:uppercase;"><span class="alert-text" style="font-size:8px;">'. _FPA_MISSINGCRED .':</span> ';

			if ( @$instance['configDBTYPE'] == '' ) { echo '<span class="warn-text" style="font-size:9px;font-weight:normal;text-transform:none;">&nbsp;<b>'. _FPA_CONT .'</b> '. _FPA_NF .'</span>'; }
			if ( @$instance['configDBHOST'] == '' ) { echo '<span class="warn-text" style="font-size:9px;font-weight:normal;text-transform:none;">&nbsp;MySQL <b>'. _FPA_HNAME .'</b> '. _FPA_NF .'</span>'; }
			if ( @$instance['configDBNAME'] == '' ) { echo '<span class="warn-text" style="font-size:9px;font-weight:normal;text-transform:none;">&nbsp;'. _FPA_DB .' <b>'. _FPA_TNAM .'</b> '. _FPA_NF .'</span>'; }
			if ( @$instance['configDBPREF'] == '' ) { echo '<span class="warn-text" style="font-size:9px;font-weight:normal;text-transform:none;">&nbsp;<b>'. _FPA_TBL .' Prefix</b> '. _FPA_NF .'</span>'; }
			if ( @$instance['configDBUSER'] == '' ) { echo '<span class="warn-text" style="font-size:9px;font-weight:normal;text-transform:none;">&nbsp;'. _FPA_DB .' <b>'. _FPA_USER .'</b> '. _FPA_NF .'</span>'; }
			if ( @$instance['configDBPASS'] == '' ) { echo '<span class="warn-text" style="font-size:9px;font-weight:normal;text-transform:none;">&nbsp;'. _FPA_DB .' <b>'. _FPA_PASS .'</b> '. _FPA_NF .'</span>'; }

			echo '</div></div>';
		}


		echo '</div>';
		echo '</div></div>';
		// end content left block


		/** display the system information *************************************************/
		echo '<div class="half-section-information-right">'; // start right content block

		echo '<div class="section-title" style="text-align:center;">'. $database['ARRNAME'] .' :: '. _FPA_PERF .'</div>';
		echo '<div class="" style="width:99%;margin: 0px auto;clear:both;margin-bottom:10px;">';

			// only do mode/permissions checks if an instance was found in the intial checks
			if ( $database['dbDOCHECKS'] == _FPA_Y AND @$database['dbERROR'] == _FPA_N AND $instance['configDBTYPE'] <> 'postgresql' AND $instance['configDBTYPE'] <> 'pgsql' ) {

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
				echo '<div style="line-height:10px;font-size:8px;color:#404040;text-shadow: #fff 1px 1px 1px;width:99%;font-weight:bold;padding:1px;padding-right:0px;padding-top:0px;padding-bottom:3px;text-transform:uppercase;"># '. _FPA_OF .' '. _FPA_TBL .':<div style="line-height:9px;text-transform:none!important;float:right;font-size:11px;font-weight:normal;width:60%;background-color:#fff;text-align:right;padding:1px;padding-top:0px;border-bottom-right-radius: 5px;-moz-border-bottom-right-radius: 5px;-webkit-border-bottom-right-radius: 5px;  border-bottom-left-radius: 5px;-moz-border-bottom-left-radius: 5px;-webkit-border-bottom-left-radius: 5px;border-right: 1px solid #42AEC2;border-left: 1px solid #42AEC2;border-bottom: 1px solid #42AEC2;">';

					if ( $database['dbTABLECOUNT'] ) {
						echo '<span class="normal">&nbsp;'. $database['dbTABLECOUNT'] .' tables&nbsp;</span>';

					} else {
						echo '<span class="warn-text">&nbsp;'. _FPA_U .'&nbsp;</span>';
					}

				echo '</div></div>';
				echo '</div>';


			} else { // an instance wasn't found in the initial checks
				echo '<div class="row-content-container nothing-to-display" style="">';
				if ($instance['configDBTYPE'] == 'postgresql' or $instance['configDBTYPE'] == 'pgsql'){
				    echo '<div class="normal" style=" margin-top:10px;margin-bottom:10px;">'. _FPA_NIMPLY . ' ' . _FPA_PGSQL . '<br /></div>';
				    echo '</div>';
				} else {
				echo '<div class="warn" style=" margin-top:10px;margin-bottom:10px;">'. _FPA_NCON .'<br />'. _FPA_NO .' '. $database['ARRNAME'] .' '. _FPA_PERF .' '. _FPA_TESTP .'</div>';
				echo '</div>';
			}
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

		echo '<div class="column-title" style="width:20%;float:left;text-align:center;">'. _FPA_TNAM .'</div>';
		echo '<div class="column-title" style="width:7%;float:left;left;text-align:center;">'. _FPA_TSIZ .'</div>';
		echo '<div class="column-title" style="width:6%;float:left;text-align:center;">'. _FPA_TREC .'</div>';
		echo '<div class="column-title" style="width:8%;float:left;text-align:center;">'. _FPA_TAVL .'</div>';
		echo '<div class="column-title" style="width:10%;float:left;text-align:center;">'. _FPA_TFRA .'</div>';
		echo '<div class="column-title" style="width:6%;float:left;text-align:center;">'. _FPA_TENG .'</div>';
		echo '<div class="column-title" style="width:10%;float:left;text-align:center;">'. _FPA_TCOL .'</div>';
		echo '<div class="column-title" style="width:9%;float:left;text-align:center;">'. _FPA_TCRE .'</div>';
		echo '<div class="column-title" style="width:9%;float:left;text-align:center;">'. _FPA_TUPD .'</div>';
		echo '<div class="column-title" style="width:9%;float:left;text-align:center;">'. _FPA_TCKD .'</div>';
		echo '<div style="clear:both;"></div>';
		echo '</div>';

			if ( $instance['instanceFOUND'] == _FPA_Y AND @$database['dbERROR'] == _FPA_N ) {

				foreach ( $tables as $i => $show ) {

					if ( $show != $tables['ARRNAME'] ) {
						// produce the output
						echo '<div style="font-size:9px;border-bottom:1px dotted #C0C0C0;width:99%;margin: 0px auto;padding-top:1px;padding-bottom:1px;clear:both;">';

							if ( $showProtected <= 2 ) {
								echo '<div style="font-size:9px;text-align:left;float:left;width:20%;">&nbsp;'. $show['TABLE'] .'</div>';

							} else {

								echo '<div style="font-size:9px;text-align:left;float:left;width:20%;">&nbsp;<span class="protected">[&nbsp;--&nbsp;'. _FPA_HIDDEN .'&nbsp;--&nbsp;]</span></div>';

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
				echo '<div class="warn" style=" margin-top:10px;margin-bottom:10px;">'. _FPA_NCON .', '. _FPA_NO .' '. $tables['ARRNAME'] .' '. _FPA_TESTP .'</div>';
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

		echo '<div class="section-title" style="text-align:center;">'. $phpenv['ARRNAME'] .' :: '. _FPA_DISC .'</div>';
		echo '<div class="" style="width:99%;margin: 0px auto;clear:both;margin-bottom:10px;">';

		echo '<div class="mini-content-box-small" style="">';
		echo '<div style="line-height:10px;font-size:8px;color:#404040;text-shadow: #fff 1px 1px 1px; width:99%;border-bottom:1px solid #ccebeb;font-weight:bold;padding:1px;padding-right:0px;padding-bottom:3px;text-transform:uppercase;">PHP '. _FPA_VER .':<div style="line-height:11px;text-transform:none!important;float:right;font-size:9px;font-weight:normal;width:60%;background-color:#fff;text-align:right;padding:1px;padding-top:0px;border-top-right-radius: 5px;-moz-border-top-right-radius: 5px;-webkit-border-top-right-radius: 5px;  border-top-left-radius: 5px;-moz-border-top-left-radius: 5px;-webkit-border-top-left-radius: 5px;border-right: 1px solid #42AEC2;border-left: 1px solid #42AEC2;border-top: 1px solid #42AEC2;1px solid #ccebeb;">';
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
		echo '<div style="line-height:10px;font-size:8px;color:#404040;text-shadow: #fff 1px 1px 1px;width:99%;border-bottom:1px solid #ccebeb;font-weight:bold;padding:1px;padding-top:0px;padding-right:0px;padding-bottom:2px;text-transform:uppercase;">MySQLi '. _FPA_SUP .':<div style="line-height:11px;text-transform:none!important;float:right;font-size:9px;font-weight:normal;width:60%;background-color:#fff;text-align:right;padding:1px;padding-top:0px;border-right: 1px solid #42AEC2;border-left: 1px solid #42AEC2;1px solid #ccebeb;">';
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
				echo '<i class="warn-text">('. _FPA_UINC .' '. $fpa['ORIGphpMEMLIMIT'] .')</i>&nbsp;';

			}

		echo $phpenv['phpMEMLIMIT'] .'&nbsp;</span>';
		echo '</div></div>';
		echo '</div>';


		echo '<div class="mini-content-box-small" style="">';
		echo '<div style="line-height:10px;font-size:8px;color:#404040;text-shadow: #fff 1px 1px 1px;width:99%;border-bottom:1px solid #ccebeb;font-weight:bold;padding:1px;padding-top:0px;padding-right:0px;padding-bottom:2px;text-transform:uppercase;">Uploads '. _FPA_EN .':<div style="line-height:11px;text-transform:none!important;float:right;font-size:9px;font-weight:normal;width:60%;background-color:#fff;text-align:right;padding:1px;padding-top:0px;border-right: 1px solid #42AEC2;border-left: 1px solid #42AEC2;1px solid #ccebeb;">';
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
				echo '<i class="warn-text">('. _FPA_UINC .' '. $fpa['ORIGphpMAXEXECTIME'] .')</i>&nbsp;';

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
		echo '<div style="line-height:10px;font-size:8px;color:#404040;text-shadow: #fff 1px 1px 1px;width:99%;border-bottom: 1px solid #ccebeb;font-weight:bold;padding:1px;padding-top:0px;padding-right:0px;padding-bottom:2px;text-transform:uppercase;">Session Path '. _FPA_WRITABLE .':<div style="float:right;">';

			if ( $phpenv['phpSESSIONPATHWRITABLE'] == _FPA_Y ) {
				echo '<span class="ok" style="font-size:9px;font-weight:normal;text-transform:none;">'. $phpenv['phpSESSIONPATHWRITABLE'] .'&nbsp;</span>';

			} elseif ( $phpenv['phpSESSIONPATHWRITABLE'] == _FPA_N ) {
				echo '<span class="alert-text" style="font-size:9px;font-weight:normal;text-transform:none;">'. $phpenv['phpSESSIONPATHWRITABLE'] .'&nbsp;</span>';

			} else {
				echo '<span class="warn-text" style="font-size:9px;font-weight:normal;text-transform:none;">'. _FPA_U .'&nbsp;</span>';

			}

		echo '</div></div>';
		echo '</div>';


		echo '<div class="mini-content-box-small" style="">';
		echo '<div style="line-height:10px;font-size:8px;color:#404040;text-shadow: #fff 1px 1px 1px;width:99%;border-bottom: 1px solid #ccebeb;font-weight:bold;padding:1px;padding-top:0px;padding-right:0px;padding-bottom:2px;text-transform:uppercase;">INI File Path:<div style="float:right;">';
		echo '<span class="normal" style="font-size:9px;font-weight:normal;text-transform:none;">'. $phpenv['phpINIFILE'] .'&nbsp;</span>';
		echo '</div></div>';
		echo '</div>';

		echo '<div class="mini-content-box-small" style="">';
		echo '<div style="line-height:10px;font-size:8px;color:#404040;text-shadow: #fff 1px 1px 1px;width:99%;border-bottom: 1px solid #ccebeb;font-weight:bold;padding:1px;padding-top:0px;padding-right:0px;padding-bottom:2px;text-transform:uppercase;">'. _FPA_LAST .' '. _FPA_K .' PHP  '. _FPA_ERR .':<div style="float:right;">';

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

		echo '<div class="section-title" style="text-align:center;">'. $system['ARRNAME'] .' :: '. _FPA_DISC .'</div>';
		echo '<div class="" style="width:99%;margin: 0px auto;clear:both;margin-bottom:10px;">';

		echo '<div class="mini-content-box-small" style="">';
		echo '<div style="line-height:10px;font-size:8px;color:#404040;text-shadow: #fff 1px 1px 1px; width:99%;border-bottom:1px solid #ccebeb;font-weight:bold;padding:1px;padding-right:0px;padding-bottom:3px;text-transform:uppercase;">'. _FPA_PLATFORM .':<div style="line-height:11px;text-transform:none!important;float:right;font-size:9px;font-weight:normal;width:60%;background-color:#fff;text-align:right;padding:1px;padding-top:0px;border-top-right-radius: 5px;-moz-border-top-right-radius: 5px;-webkit-border-top-right-radius: 5px;  border-top-left-radius: 5px;-moz-border-top-left-radius: 5px;-webkit-border-top-left-radius: 5px;border-right: 1px solid #42AEC2;border-left: 1px solid #42AEC2;border-top: 1px solid #42AEC2;1px solid #ccebeb;">';
		echo '<span class="normal">'. $system['sysPLATOS'] .'&nbsp;</span>';
		echo '</div></div>';
		echo '</div>';


		echo '<div class="mini-content-box-small" style="">';
		echo '<div style="line-height:10px;font-size:8px;color:#404040;text-shadow: #fff 1px 1px 1px;width:99%;border-bottom:1px solid #ccebeb;font-weight:bold;padding:1px;padding-top:0px;padding-right:0px;padding-bottom:2px;text-transform:uppercase;">Kernel '. _FPA_VER .':<div style="line-height:11px;text-transform:none!important;float:right;font-size:9px;font-weight:normal;width:60%;background-color:#fff;text-align:right;padding:1px;padding-top:0px;border-right: 1px solid #42AEC2;border-left: 1px solid #42AEC2;1px solid #ccebeb;">';
		echo '<span class="normal">'. $system['sysPLATREL'] .'&nbsp;</span>';
		echo '</div></div>';
		echo '</div>';


		echo '<div class="mini-content-box-small" style="">';
		echo '<div style="line-height:10px;font-size:8px;color:#404040;text-shadow: #fff 1px 1px 1px;width:99%;border-bottom:1px solid #ccebeb;font-weight:bold;padding:1px;padding-top:0px;padding-right:0px;padding-bottom:2px;text-transform:uppercase;">'. _FPA_TEC .':<div style="line-height:11px;text-transform:none!important;float:right;font-size:9px;font-weight:normal;width:60%;background-color:#fff;text-align:right;padding:1px;padding-top:0px;border-right: 1px solid #42AEC2;border-left: 1px solid #42AEC2;1px solid #ccebeb;">';
		echo '<span class="normal">'. $system['sysPLATTECH'] .'&nbsp;</span>';
		echo '</div></div>';
		echo '</div>';


		echo '<div class="mini-content-box-small" style="">';
		echo '<div style="line-height:10px;font-size:8px;color:#404040;text-shadow: #fff 1px 1px 1px;width:99%;border-bottom:1px solid #ccebeb;font-weight:bold;padding:1px;padding-top:0px;padding-right:0px;padding-bottom:2px;text-transform:uppercase;">'. _FPA_HNAME .':<div style="line-height:11px;text-transform:none!important;float:right;font-size:9px;font-weight:normal;width:60%;background-color:#fff;text-align:right;padding:1px;padding-top:0px;border-right: 1px solid #42AEC2;border-left: 1px solid #42AEC2;1px solid #ccebeb;">';

			if ( $showProtected == 1 ) {
				echo '<span class="normal">'. $system['sysPLATNAME'] .'&nbsp;</span>';

			} else {
				echo '<span class="protected">[&nbsp;--&nbsp;'. _FPA_HIDDEN .'&nbsp;--&nbsp;]</span>&nbsp;';

			}

		echo '</div></div>';
		echo '</div>';


		echo '<div class="mini-content-box-small" style="">';
		echo '<div style="line-height:10px;font-size:8px;color:#404040;text-shadow: #fff 1px 1px 1px;width:99%;border-bottom: 1px solid #ccebeb;font-weight:bold;padding:1px;padding-top:0px;padding-right:0px;padding-bottom:2px;text-transform:uppercase;">Total Disk Space:<div style="line-height:11px;text-transform:none!important;float:right;font-size:9px;font-weight:normal;width:60%;background-color:#fff;text-align:right;padding:1px;padding-top:0px;border-right: 1px solid #42AEC2;border-left: 1px solid #42AEC2;border-bottom: 1px solid #ccebeb;">';
        if (function_exists('disk_total_space'))
        {
        	$total_space = sprintf('%.2f', disk_total_space('./') / 1073741824);
        	echo '<span class="normal">' . $total_space . ' GiB&nbsp;</span>';
        }
        else
        {
        	echo '<span class="normal">' . _FPA_U . '&nbsp;</span>';
        }

		echo '</div></div>';
		echo '</div>';


		echo '<div class="mini-content-box-small" style="">';
		echo '<div style="line-height:10px;font-size:8px;color:#404040;text-shadow: #fff 1px 1px 1px;width:99%;border-bottom: 1px solid #ccebeb;font-weight:bold;padding:1px;padding-top:0px;padding-right:0px;padding-bottom:2px;text-transform:uppercase;">Free Disk Space:<div style="line-height:11px;text-transform:none!important;float:right;font-size:9px;font-weight:normal;width:60%;background-color:#fff;text-align:right;padding:1px;padding-top:0px;border-right: 1px solid #42AEC2;border-left: 1px solid #42AEC2;border-bottom: 1px solid #ccebeb;">';
        if (function_exists('disk_free_space'))
        {	
        	$free_space = sprintf('%.2f', disk_free_space('./') / 1073741824);
        	if (function_exists('disk_total_space'))
        	{
            	$percent_free = $free_space ? round($free_space / $total_space, 2) * 100 : 0;	
            	if ($percent_free <= '5')
            	{
            		$status = 'warn';
            	}
            	else
            	{
            		$status = 'normal';
            	}	
            	echo '<span class="normal">(<span class="' . $status . '">' . $percent_free . '%</span>)  ' . $free_space . ' GiB&nbsp;</span>';
            	$system['sysFREESPACE'] = $free_space . ' GiB';
            }
            else
            {
                echo '<span class="normal"> ' . $free_space . ' GiB&nbsp;</span>';
            }
        }
        else
        {
        	echo '<span class="normal">' . _FPA_U . '&nbsp;</span>';
        }

		echo '</div></div>';
		echo '</div>';


		echo '<div class="mini-content-box-small" style="">';
		echo '<div style="line-height:10px;font-size:8px;color:#404040;text-shadow: #fff 1px 1px 1px;width:99%;border-bottom:1px solid #ccebeb;font-weight:bold;padding:1px;padding-top:0px;padding-right:0px;padding-bottom:2px;text-transform:uppercase;">'. _FPA_SERV .':<div style="line-height:11px;text-transform:none!important;float:right;font-size:9px;font-weight:normal;width:60%;background-color:#fff;text-align:right;padding:1px;padding-top:0px;border-right: 1px solid #42AEC2;border-left: 1px solid #42AEC2;1px solid #ccebeb;">';

			if ( $showProtected == 1 ) {
				echo '<span class="normal">'. $system['sysSERVNAME'] .'&nbsp;</span>';

			} else {
				echo '<span class="protected">[&nbsp;--&nbsp;'. _FPA_HIDDEN .'&nbsp;--&nbsp;]</span>&nbsp;';

			}

		echo '</div></div>';
		echo '</div>';


		echo '<div class="mini-content-box-small" style="">';
		echo '<div style="line-height:10px;font-size:8px;color:#404040;text-shadow: #fff 1px 1px 1px;width:99%;border-bottom:1px solid #ccebeb;font-weight:bold;padding:1px;padding-top:0px;padding-right:0px;padding-bottom:2px;text-transform:uppercase;">'. _FPA_SERV .' IP:<div style="line-height:11px;text-transform:none!important;float:right;font-size:9px;font-weight:normal;width:60%;background-color:#fff;text-align:right;padding:1px;padding-top:0px;border-right: 1px solid #42AEC2;border-left: 1px solid #42AEC2;1px solid #ccebeb;">';

			if ( $showProtected == 1 ) {
				echo '<span class="normal">'. $system['sysSERVIP'] .'&nbsp;</span>';

			} else {
				echo '<span class="protected">[&nbsp;--&nbsp;'. _FPA_HIDDEN .'&nbsp;--&nbsp;]</span>&nbsp;';

			}

		echo '</div></div>';
		echo '</div>';


		echo '<div class="mini-content-box-small" style="">';
		echo '<div style="line-height:10px;font-size:8px;color:#404040;text-shadow: #fff 1px 1px 1px;width:99%;border-bottom:1px solid #ccebeb;font-weight:bold;padding:1px;padding-top:0px;padding-right:0px;padding-bottom:2px;text-transform:uppercase;">'. _FPA_SERV .' Signature:<div style="line-height:11px;text-transform:none!important;float:right;font-size:9px;font-weight:normal;width:60%;background-color:#fff;text-align:right;padding:1px;padding-top:0px;border-right: 1px solid #42AEC2;border-left: 1px solid #42AEC2;1px solid #ccebeb;">';
		echo '<span class="normal">'. $system['sysSERVSIG'] .'&nbsp;</span>';
		echo '</div></div>';
		echo '</div>';


		echo '<div class="mini-content-box-small" style="">';
		echo '<div style="line-height:10px;font-size:8px;color:#404040;text-shadow: #fff 1px 1px 1px;width:99%;border-bottom:1px solid #ccebeb;font-weight:bold;padding:1px;padding-top:0px;padding-right:0px;padding-bottom:2px;text-transform:uppercase;">'. _FPA_SERV .' Encoding:<div style="line-height:11px;text-transform:none!important;float:right;font-size:9px;font-weight:normal;width:60%;background-color:#fff;text-align:right;padding:1px;padding-top:0px;border-right: 1px solid #42AEC2;border-left: 1px solid #42AEC2;1px solid #ccebeb;">';
		echo '<span class="normal">'. $system['sysENCODING'] .'&nbsp;</span>';
		echo '</div></div>';
		echo '</div>';


		echo '<div class="mini-content-box-small" style="">';
		echo '<div style="line-height:10px;font-size:8px;color:#404040;text-shadow: #fff 1px 1px 1px;width:99%;border-bottom: 1px solid #ccebeb;font-weight:bold;padding:1px;padding-top:0px;padding-right:0px;padding-bottom:2px;text-transform:uppercase;">Executing '. _FPA_USR .':<div style="line-height:11px;text-transform:none!important;float:right;font-size:9px;font-weight:normal;width:60%;background-color:#fff;text-align:right;padding:1px;padding-top:0px;border-right: 1px solid #42AEC2;border-left: 1px solid #42AEC2;border-bottom: 1px solid #ccebeb;">';
		echo '<span class="normal">'. $system['sysEXECUSER'] .'&nbsp;</span>';
		echo '</div></div>';
		echo '</div>';


		echo '<div class="mini-content-box-small" style="">';
		echo '<div style="line-height:10px;font-size:8px;color:#404040;text-shadow: #fff 1px 1px 1px;width:99%;font-weight:bold;padding:1px;padding-right:0px;padding-top:0px;padding-bottom:3px;text-transform:uppercase;">'. _FPA_SERV .' '. _FPA_USR .':<div style="line-height:9px;text-transform:none!important;float:right;font-size:11px;font-weight:normal;width:60%;background-color:#fff;text-align:right;padding:1px;padding-top:0px;border-bottom-right-radius: 5px;-moz-border-bottom-right-radius: 5px;-webkit-border-bottom-right-radius: 5px;  border-bottom-left-radius: 5px;-moz-border-bottom-left-radius: 5px;-webkit-border-bottom-left-radius: 5px;border-right: 1px solid #42AEC2;border-left: 1px solid #42AEC2;border-bottom: 1px solid #42AEC2;">';
		echo '<span class="normal">'. $system['sysWEBOWNER'] .'&nbsp;</span>';
		echo '</div></div>';
		echo '</div>';

		echo "<br />";

		echo '<div class="mini-content-box-small" style="">';
		echo '<div style="line-height:10px;font-size:8px;color:#404040;text-shadow: #fff 1px 1px 1px;width:99%;border-bottom: 1px solid #ccebeb;font-weight:bold;padding:1px;padding-top:0px;padding-right:0px;padding-bottom:2px;text-transform:uppercase;">'. _FPA_DROOT .':<div style="float:right;">';


			if ( $showProtected <= 2 ) {
				echo '<span class="normal" style="font-size:9px;font-weight:normal;text-transform:none;">'. $system['sysDOCROOT'] .'&nbsp;</span>';

			} else {
				echo '<span class="protected">[&nbsp;--&nbsp;'. _FPA_HIDDEN .'&nbsp;--&nbsp;]</span>&nbsp;';

			}

		echo '</div></div>';
		echo '</div>';


		echo '<div class="mini-content-box-small" style="">';
		echo '<div style="line-height:10px;font-size:8px;color:#404040;text-shadow: #fff 1px 1px 1px;width:99%;border-bottom: 1px solid #ccebeb;font-weight:bold;padding:1px;padding-top:0px;padding-right:0px;padding-bottom:2px;text-transform:uppercase;">'. _FPA_SERV .' Temp:<div style="float:right;">';

			if ( $showProtected <= 2 ) {
				echo '<span class="normal" style="font-size:9px;font-weight:normal;text-transform:none;">'. $system['sysSYSTMPDIR'] .'&nbsp;</span>';

			} else {
				echo '<span class="protected">[&nbsp;--&nbsp;'. _FPA_HIDDEN .'&nbsp;--&nbsp;]</span>&nbsp;';

			}

		echo '</div></div>';
		echo '</div>';


		echo '<div class="mini-content-box-small" style="">';
		echo '<div style="line-height:10px;font-size:8px;color:#404040;text-shadow: #fff 1px 1px 1px;width:99%;border-bottom: 1px solid #ccebeb;font-weight:bold;padding:1px;padding-top:0px;padding-right:0px;padding-bottom:2px;text-transform:uppercase;">'. _FPA_SERV .' Temp '. _FPA_WRITABLE .':<div style="float:right;">';

			if ( $system['sysTMPDIRWRITABLE'] == _FPA_Y ) {
				echo '<span class="ok" style="font-size:9px;font-weight:normal;text-transform:none;">'. $system['sysTMPDIRWRITABLE'] .'&nbsp;</span>';

			} elseif ( $system['sysTMPDIRWRITABLE'] == _FPA_N ) {
				echo '<span class="alert-text" style="font-size:9px;font-weight:normal;text-transform:none;">'. $system['sysTMPDIRWRITABLE'] .'&nbsp;</span>';

			} else {
				echo '<span class="warn-text" style="font-size:9px;font-weight:normal;text-transform:none;">'. _FPA_U .'&nbsp;</span>';
			}

		echo '</div></div>';
		echo '</div>';


		//echo '<br style="clear:both;" />';
		echo '<div class="mini-content-box-small" style="">';
		echo '<div style="line-height:10px;font-size:8px;color:#404040;text-shadow: #fff 1px 1px 1px;width:99%;border-bottom: 1px solid #ccebeb;font-weight:bold;padding:1px;padding-top:0px;padding-right:0px;padding-bottom:2px;text-transform:uppercase;">Switch '. _FPA_USR .' '. _FPA_CFG ;
		echo '<br style="clear:both;" />';
		echo '<div style="background-color: #fff;border:1px solid #42aec2;border-radius:3px;-moz-border-radius:3px;-webkit-border-radius:3px;text-align:center;margin:2px;width:22%;padding:1px;float:left;font-size:8px;font-weight:normal;">suExec<br /><b>'. $phpenv['phpAPACHESUEXEC'] .'</b></div>';
		echo '<div style="background-color: #fff;border:1px solid #42aec2;border-radius:3px;-moz-border-radius:3px;-webkit-border-radius:3px;text-align:center;margin:2px;width:22%;padding:1px;float:left;font-size:8px;font-weight:normal;">PHP suExec<br /><b>'. $phpenv['phpPHPSUEXEC'] .'</b></div>';
		echo '<div style="background-color: #fff;border:1px solid #42aec2;border-radius:3px;-moz-border-radius:3px;-webkit-border-radius:3px;text-align:center;margin:2px;width:22%;padding:1px;float:left;font-size:8px;font-weight:normal;">Custom su<br /><b>'. $phpenv['phpCUSTOMSU'] .'</b></div>';
		echo '<div style="background-color: #fff;border:1px solid #42aec2;border-radius:3px;-moz-border-radius:3px;-webkit-border-radius:3px;text-align:center;margin:2px;width:22%;padding:1px;float:left;font-size:8px;font-weight:normal;">Ownership Probs<br /><b>';

			if ( $phpenv['phpOWNERPROB'] == _FPA_N ) {
				$status = 'ok';

			} elseif ( $phpenv['phpOWNERPROB'] == _FPA_M ) {
				$status = 'warn-text';

			} elseif ( $phpenv['phpOWNERPROB'] == _FPA_Y ) {
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

		echo '<div class="section-title" style="text-align:center;">'. $phpextensions['ARRNAME'] .' :: '. _FPA_DISC .'</div>';
		echo '<div class="" style="width:99%;margin: 0px auto;clear:both;margin-bottom:10px;">';

			foreach ( $phpextensions as $key => $show ) {

				if ( $show != $phpextensions['ARRNAME'] ) {

					if ( $key == 'exif' ) {
						$pieces = explode( " $", $show );
						$show = $pieces[0];

					}


					// find the requirements and mark them as present or missing
					if ( $key == 'libxml' OR $key == 'xml' OR $key == 'zip' OR $key == 'openssl' OR $key == 'zlib' OR $key == 'curl' OR $key == 'iconv' OR $key == 'mbstring' OR $key == 'mysql' OR $key == 'mysqli' OR $key == 'pdo_mysql' OR $key == 'mcrypt' OR $key == 'suhosin' OR $key == 'cgi' OR $key == 'cgi-fcgi' ) {
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


					echo '<div style="background-color: #'. $background .';border:1px solid #'. $border .';border-radius:3px;-moz-border-radius:3px;-webkit-border-radius:3px;text-align:center;margin:2px;padding:1px;min-height:25px;min-width:82px;float:left;font-size:8px;"><span class="'. $status .'" style="font-size:8px;font-weight:'. $weight .';text-shadow:1px 1px 1px #fff;">'. $key .'</span><br />'. $show .'</div>';

				} // endif !arrname


				// look for recommended extensions that aren't installed
				if ( !in_array( $key, $phpreq ) ) {
					unset ( $phpreq[$key] );
				}

			} // end foreach

			if ( version_compare( $instance['cmsRELEASE'], '3.8', '>=') OR version_compare( $phpenv['phpVERSION'], '7.2.0', '>=' ))   {
			 unset($phpreq['mcrypt']);   
			}

			if (version_compare( $phpenv['phpVERSION'], '7.0.0', '>=' ))   {
			 unset($phpreq['mysql']);   
			}

			if ( $phpreq ) {
				echo '<br style="clear:both;" /><br />';
				echo '<div class="mini-content-box-small" style="">';
				echo '<div class="warn-text" style="line-height:10px;font-size:9px;text-shadow: #fff 1px 1px 1px;width:99%;border-bottom: 1px solid #ccebeb;font-weight:bold;padding:1px;padding-top:0px;padding-right:0px;padding-bottom:2px;text-transform:uppercase;">'. _FPA_POTME .':<br /><div style="float:left;text-transform:none;">';

				echo '<br style="clear:both;" />';

				$status = 'warn-text';
				$border = 'FFA500';
				$background = 'FFF';
				$weight = 'bold';


				foreach ( $phpreq as $missingkey => $missing ) {
					echo '<div style="background-color: #'. $background .';border:1px solid #'. $border .';border-radius:3px;-moz-border-radius:3px;-webkit-border-radius:3px;text-align:center;margin:2px;padding:1px;min-height:10px;width:82px;float:left;font-size:8px;"><span class="'. $status .'" style="font-size:8px;font-weight:'. $weight .';text-shadow:1px 1px 1px #fff;">'. $missingkey .'</span></div>';

				}

				echo '</div></div>';
				echo '</div>';

			}

			// disabled PHP functions
			if ( $phpenv['phpDISABLED'] ) {
				echo '<br style="clear:both;" /><br />';
				echo '<div class="mini-content-box-small" style="">';
				echo '<div class="normal" style="line-height:10px;font-size:9px;text-shadow: #fff 1px 1px 1px;width:99%;border-bottom: 1px solid #ccebeb;font-weight:bold;padding:1px;padding-top:0px;padding-right:0px;padding-bottom:2px;text-transform:uppercase;">'. _FPA_DI_PHP_FU .':<br /><div style="float:left;text-transform:none;">';
				echo '<br style="clear:both;" />';
				$status = 'normal';
				$border = '42AEC2';
				$background = 'FFF';
				$weight = 'normal';
                $disabledfunctions = explode(",",$phpenv['phpDISABLED']);
                $arrlength = count($disabledfunctions);
				for($x = 0; $x < $arrlength; $x++) {
					echo '<div style="background-color: #'. $background .';border:1px solid #'. $border .';border-radius:3px;-moz-border-radius:3px;-webkit-border-radius:3px;text-align:center;margin:2px;padding:1px;min-height:10px;width:82px;float:left;font-size:8px;"><span class="'. $status .'" style="font-size:8px;font-weight:'. $weight .';text-shadow:1px 1px 1px #fff;">'. $disabledfunctions[$x] .'</span></div>';
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
					echo '<div class="warn-text" style="line-height:10px;font-size:9px;text-shadow: #fff 1px 1px 1px;width:99%;border-bottom: 1px solid #ccebeb;font-weight:bold;padding:1px;padding-top:0px;padding-right:0px;padding-bottom:2px;text-transform:uppercase;">'. _FPA_POTMM .':<br /><div style="float:left;text-transform:none;">';

					echo '<br style="clear:both;" />';

					$status = 'warn-text';
					$border = 'FFA500';
					$background = 'FFF';
					$weight = 'bold';

					foreach ( $apachereq as $missingkey => $missing ) {
						echo '<div style="background-color: #'. $background .';border:1px solid #'. $border .';border-radius:3px;-moz-border-radius:3px;-webkit-border-radius:3px;text-align:center;margin:2px;padding:1px;min-height:10px;width:82px;float:left;font-size:8px;"><span class="'. $status .'" style="font-size:8px;font-weight:'. $weight .';text-shadow:1px 1px 1px #fff;">'. $missingkey .'</span></div>';

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

	echo '<div class="column-title" style="width:7%;float:left;text-align:center;">'. _FPA_MODE .'</div>';
	echo '<div class="column-title" style="width:8%;float:left;left;text-align:center;">'. _FPA_WRITABLE .'</div>';
	echo '<div class="column-title" style="width:58%;float:left;">'. _FPA_FOLDER .'</div>';
	echo '<div class="column-title" style="width:12%;float:right;text-align:center;">'. _FPA_GROUP .'</div>';
	echo '<div class="column-title" style="width:12%;float:right;text-align:center;">'. _FPA_OWNER .'</div>';
	echo '<div style="clear:both;"></div>';
	echo '</div>';

	// only do mode/permissions checks if an instance was found in the intial checks
	if ( $instance['instanceFOUND'] == _FPA_Y ) {
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
				} else if ( $modecheck[$show]['group']['name'] == _FPA_N ) {
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
				if ( ( $modecheck[$show]['writable'] != _FPA_Y ) ) {
					$writeClass = 'warn-text';
				} elseif ( ( $modecheck[$show]['writable'] == _FPA_Y ) AND ( substr( $modecheck[$show]['mode'],0 ,1 ) == '7' ) ) {
					$writeClass = 'normal';
				} elseif ( $modecheck[$show]['writable'] == _FPA_N ) {
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
						echo '<span class="protected">[&nbsp;--&nbsp;'. _FPA_HIDDEN .'&nbsp;--&nbsp;]</span>';
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
		echo '<div class="warn" style=" margin-top:10px;margin-bottom:10px;">'. _FPA_INSTANCE .' '. _FPA_NF .', '. _FPA_N .' '. $modecheck['ARRNAME'] .' '. _FPA_TESTP .'</div>';
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
		echo '<div class="section-title" style="text-align:center;">'. $elevated['ARRNAME'] .' ('. _FPA_FIRST .' 10)</div>';

		echo '<div class="column-title-container" style="width:99%;margin: 0px auto;clear:both;display:block;">';

		echo '<div class="column-title" style="width:7%;float:left;text-align:center;">'. _FPA_MODE .'</div>';
		echo '<div class="column-title" style="width:8%;float:left;left;text-align:center;">'. _FPA_WRITABLE .'</div>';
		echo '<div class="column-title" style="width:58%;float:left;">'. _FPA_FOLDER .'</div>';
		echo '<div style="clear:both;"></div>';
		echo '</div>';


		// only do mode/permissions checks if an instance was found in the intial checks
		if ( $instance['instanceFOUND'] == _FPA_Y ) {

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
					if ( ( $show['writable'] == _FPA_Y ) ) {
						$writeClass = 'alert-text';
					} else {
						$writeClass = 'warn-text';
					}


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

						} else {
							echo '<span class="protected">[&nbsp;--&nbsp;'. _FPA_HIDDEN .'&nbsp;--&nbsp;]</span>';
						}

					echo '</div>';
					echo '<div style="clear:both;"></div>';
					echo '</div>';

				} // endif ARRNAME

			} // end for each


		} else { // an instance wasn't found in the initial checks, so no folders to check
			echo '<div style="text-align:center;border-bottom:1px dotted #C0C0C0;width:99%;margin: 0px auto;padding-top:1px;padding-bottom:1px;clear:both;font-size: 11px;">';
			echo '<div class="warn" style=" margin-top:10px;margin-bottom:10px;">'. _FPA_INSTANCE .' '. _FPA_NF .', '. _FPA_NO .' '. $elevated['ARRNAME'] .' '. _FPA_TESTP .'</div>';
			echo '</div>';
		}

		echo '</div>';
		echo '<div style="clear:both;"></div>';

		showDev( $elevated );
		unset ( $key, $show );
	} // endif showElevated
?>




<?php
	// Components
	if ( $showComponents == '1' ) {

		echo '<div class="section-information">';

		echo '<div class="section-title" style="text-align:center;">'. $component['ARRNAME'] .' :: '. _FPA_SITE .'</div>';

		echo '<div class="column-title-container" style="width:99%;margin: 0px auto;clear:both;display:block;">';
		echo '<div class="column-title" style="width:22%;float:left;text-align:left;">'. _FPA_TNAM .'</div>';
		echo '<div class="column-title" style="width:10%;float:left;text-align:center;">'. _FPA_VER .'</div>';
		echo '<div class="column-title" style="width:10%;float:left;text-align:center;">'. _FPA_CRE .'</div>';
		echo '<div class="column-title" style="width:18%;float:left;text-align:center;">'. _FPA_AUTH .'</div>';
		echo '<div class="column-title" style="width:18%;float:left;text-align:center;">'. _FPA_ADDR .'</div>';
		echo '<div class="column-title" style="width:5%;float:left;text-align:center;">'. _FPA_EN .'</div>';
		echo '<div class="column-title" style="width:10%;float:right;text-align:center;">'. _FPA_TYPE .'</div>';
		echo '<div style="clear:both;"></div>';
		echo '</div>';


		echo '<div class="" style="width:99%;margin: 0px auto;clear:both;margin-bottom:10px;">';


		echo '<div class="mini-content-box-small" style="">';
		if ( $instance['instanceFOUND'] == _FPA_N ) { // an instance wasn't found in the initial checks, so no folders to check
			echo '<div style="text-align:center;border-bottom:1px dotted #C0C0C0;width:99%;margin: 0px auto;padding-top:1px;padding-bottom:1px;clear:both;font-size: 11px;">';
			echo '<div class="warn" style=" margin-top:10px;margin-bottom:10px;">'. _FPA_INSTANCE .' '. _FPA_NF .', '. _FPA_NO .' '. $component['ARRNAME'] .' '. _FPA_TESTP .'</div>';
			echo '</div>';
		} else
		// Site components 
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
				if ( $show['type'] == _FPA_3PD OR $showCoreEx == 1 AND $showProtected <= 2) {
					$typeColor = '404040';
					echo '<div><div style="float:left;width:22%;color:#'. $typeColor .';">'. $show['name'] .'</div><div style="float:left;width:10%;text-align:center;color:#'. $typeColor .';">'. $show['version'] .'</div><div style="float:left;width:12%;text-align:center;color:#'. $typeColor .';">'. $show['creationDate'] .'</div><div style="float:left;width:18%;text-align:center;color:#'. $typeColor .';">'. $show['author'] .'</div><div style="float:left;width:18%;text-align:center;color:#'. $typeColor .';">'. $show['authorUrl'] .'</div><div style="float:left;width:5%;text-align:center;color:#'. $typeColor .';">'. $extenabled .'</div><div style="float:right;width:10%;color:#'. $typeColor .';text-align:center;">'. $show['type'] .'</div><br style="clear:both" /></div>';

				} elseif ( $showProtected > 2 ) {
					$typeColor = '000080';
					echo '<div><div style="float:left;width:20%;color:#'. $typeColor .';"><span class="protected">[&nbsp;--&nbsp;'. _FPA_HIDDEN .'&nbsp;--&nbsp;]</span></div><div style="float:left;width:15%;text-align:center;color:#'. $typeColor .';">'. $show['version'] .'</div><div style="float:left;width:15%;color:#'. $typeColor .';">'. $show['creationDate'] .'</div><div style="float:left;width:18%;color:#'. $typeColor .';">'. $show['author'] .'</div><div style="float:left;width:20%;color:#'. $typeColor .';">'. $show['authorUrl'] .'</div><div style="float:right;width:10%;color:#'. $typeColor .';text-align:center;">'. $show['type'] .'</div><br style="clear:both" /></div>';
				}
 		}       


		echo '</div></div>';




		echo '<br style="clear:both;" />';
		echo '<div class="section-title" style="text-align:center;">'. $component['ARRNAME'] .' :: '. _FPA_ADMIN .'</div>';

		echo '<div class="column-title-container" style="width:99%;margin: 0px auto;clear:both;display:block;">';
		echo '<div class="column-title" style="width:22%;float:left;text-align:left;">'. _FPA_TNAM .'</div>';
		echo '<div class="column-title" style="width:10%;float:left;text-align:center;">'. _FPA_VER .'</div>';
		echo '<div class="column-title" style="width:10%;float:left;text-align:center;">'. _FPA_CRE .'</div>';
		echo '<div class="column-title" style="width:18%;float:left;text-align:center;">'. _FPA_AUTH .'</div>';
		echo '<div class="column-title" style="width:18%;float:left;text-align:center;">'. _FPA_ADDR .'</div>';
		echo '<div class="column-title" style="width:5%;float:left;text-align:center;">'. _FPA_EN .'</div>';
		echo '<div class="column-title" style="width:10%;float:right;text-align:center;">'. _FPA_TYPE .'</div>';
		echo '<div style="clear:both;"></div>';
		echo '</div>';

		echo '<div class="" style="width:99%;margin: 0px auto;clear:both;margin-bottom:10px;">';
	if ( $instance['instanceFOUND'] == _FPA_N ) { // an instance wasn't found in the initial checks, so no folders to check
			echo '<div style="text-align:center;border-bottom:1px dotted #C0C0C0;width:99%;margin: 0px auto;padding-top:1px;padding-bottom:1px;clear:both;font-size: 11px;">';
			echo '<div class="warn" style=" margin-top:10px;margin-bottom:10px;">'. _FPA_INSTANCE .' '. _FPA_NF .', '. _FPA_NO .' '. $component['ARRNAME'] .' '. _FPA_TESTP .'</div>';
			echo '</div>';
		} else
		// Admin components
			foreach ( $component['ADMIN'] as $key => $show ) {
				if (isset($exset[0]['name'])) { 
					$extarrkey = recursive_array_search($show['name'], $exset);
                    if ($extarrkey  !== False) {
					$extenabled = $exset[$extarrkey]['enabled'];
				} else { $extenabled = '?' ;}
				} else { $extenabled = '?' ;}
				if ($extenabled <> 0 AND $extenabled <> 1 ){
					$extenabled = '?';
				}
				if ( $show['type'] == _FPA_3PD OR $showCoreEx == 1 AND $showProtected <= 2) {
					$typeColor = '404040';
					echo '<div><div style="float:left;width:22%;color:#'. $typeColor .';">'. $show['name'] .'</div><div style="float:left;width:10%;text-align:center;color:#'. $typeColor .';">'. $show['version'] .'</div><div style="float:left;width:12%;text-align:center;color:#'. $typeColor .';">'. $show['creationDate'] .'</div><div style="float:left;width:18%;text-align:center;color:#'. $typeColor .';">'. $show['author'] .'</div><div style="float:left;width:18%;text-align:center;color:#'. $typeColor .';">'. $show['authorUrl'] .'</div><div style="float:left;width:5%;text-align:center;color:#'. $typeColor .';">'. $extenabled .'</div><div style="float:right;width:10%;color:#'. $typeColor .';text-align:center;">'. $show['type'] .'</div><br style="clear:both" /></div>';

				} elseif ( $showProtected > 2 ) {
					$typeColor = '000080';
					echo '<div><div style="float:left;width:20%;color:#'. $typeColor .';"><span class="protected">[&nbsp;--&nbsp;'. _FPA_HIDDEN .'&nbsp;--&nbsp;]</span></div><div style="float:left;width:15%;text-align:center;color:#'. $typeColor .';">'. $show['version'] .'</div><div style="float:left;width:15%;color:#'. $typeColor .';">'. $show['creationDate'] .'</div><div style="float:left;width:18%;color:#'. $typeColor .';">'. $show['author'] .'</div><div style="float:left;width:20%;color:#'. $typeColor .';">'. $show['authorUrl'] .'</div><div style="float:right;width:10%;color:#'. $typeColor .';text-align:center;">'. $show['type'] .'</div><br style="clear:both" /></div>';

				}
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
	//Modules
	if ( $showModules == '1' ) {

		echo '<div class="section-information">';

		echo '<div class="section-title" style="text-align:center;">'. $module['ARRNAME'] .' :: '. _FPA_SITE .'</div>';

		echo '<div class="column-title-container" style="width:99%;margin: 0px auto;clear:both;display:block;">';
		echo '<div class="column-title" style="width:22%;float:left;text-align:left;">'. _FPA_TNAM .'</div>';
		echo '<div class="column-title" style="width:10%;float:left;text-align:center;">'. _FPA_VER .'</div>';
		echo '<div class="column-title" style="width:10%;float:left;text-align:center;">'. _FPA_CRE .'</div>';
		echo '<div class="column-title" style="width:18%;float:left;text-align:center;">'. _FPA_AUTH .'</div>';
		echo '<div class="column-title" style="width:18%;float:left;text-align:center;">'. _FPA_ADDR .'</div>';
		echo '<div class="column-title" style="width:5%;float:left;text-align:center;">'. _FPA_EN .'</div>';
		echo '<div class="column-title" style="width:10%;float:right;text-align:center;">'. _FPA_TYPE .'</div>';
		echo '<div style="clear:both;"></div>';
		echo '</div>';


		echo '<div class="" style="width:99%;margin: 0px auto;clear:both;margin-bottom:10px;">';


		echo '<div class="mini-content-box-small" style="">';
		if ( $instance['instanceFOUND'] == _FPA_N ) { // an instance wasn't found in the initial checks, so no folders to check
			echo '<div style="text-align:center;border-bottom:1px dotted #C0C0C0;width:99%;margin: 0px auto;padding-top:1px;padding-bottom:1px;clear:both;font-size: 11px;">';
			echo '<div class="warn" style=" margin-top:10px;margin-bottom:10px;">'. _FPA_INSTANCE .' '. _FPA_NF .', '. _FPA_NO .' '. $component['ARRNAME'] .' '. _FPA_TESTP .'</div>';
			echo '</div>';
		} else
		// Site modules 
			foreach ( $module['SITE'] as $key => $show ) {
				if (isset($exset[0]['name'])) { 
					$extarrkey = recursive_array_search($show['name'], $exset);
                    if ($extarrkey  !== False) {
					$extenabled = $exset[$extarrkey]['enabled'];
				} else { $extenabled = '?' ;}
				} else { $extenabled = '?' ;}
				if ($extenabled <> 0 AND $extenabled <> 1 ){
					$extenabled = '?';
				}
				if ( $show['type'] == _FPA_3PD OR $showCoreEx == 1 AND $showProtected <= 2) {
					$typeColor = '404040';
					echo '<div><div style="float:left;width:22%;color:#'. $typeColor .';">'. $show['name'] .'</div><div style="float:left;width:10%;text-align:center;color:#'. $typeColor .';">'. $show['version'] .'</div><div style="float:left;width:12%;text-align:center;color:#'. $typeColor .';">'. $show['creationDate'] .'</div><div style="float:left;width:18%;text-align:center;color:#'. $typeColor .';">'. $show['author'] .'</div><div style="float:left;width:18%;text-align:center;color:#'. $typeColor .';">'. $show['authorUrl'] .'</div><div style="float:left;width:5%;text-align:center;color:#'. $typeColor .';">'. $extenabled .'</div><div style="float:right;width:10%;color:#'. $typeColor .';text-align:center;">'. $show['type'] .'</div><br style="clear:both" /></div>';

				} elseif ( $showProtected > 2 ) {
					$typeColor = '000080';
					echo '<div><div style="float:left;width:20%;color:#'. $typeColor .';"><span class="protected">[&nbsp;--&nbsp;'. _FPA_HIDDEN .'&nbsp;--&nbsp;]</span></div><div style="float:left;width:15%;text-align:center;color:#'. $typeColor .';">'. $show['version'] .'</div><div style="float:left;width:15%;color:#'. $typeColor .';">'. $show['creationDate'] .'</div><div style="float:left;width:18%;color:#'. $typeColor .';">'. $show['author'] .'</div><div style="float:left;width:20%;color:#'. $typeColor .';">'. $show['authorUrl'] .'</div><div style="float:right;width:10%;color:#'. $typeColor .';text-align:center;">'. $show['type'] .'</div><br style="clear:both" /></div>';

				}
			}


		echo '</div></div>';




		echo '<br style="clear:both;" />';
		echo '<div class="section-title" style="text-align:center;">'. $module['ARRNAME'] .' :: '. _FPA_ADMIN .'</div>';

		echo '<div class="column-title-container" style="width:99%;margin: 0px auto;clear:both;display:block;">';
		echo '<div class="column-title" style="width:22%;float:left;text-align:left;">'. _FPA_TNAM .'</div>';
		echo '<div class="column-title" style="width:10%;float:left;text-align:center;">'. _FPA_VER .'</div>';
		echo '<div class="column-title" style="width:10%;float:left;text-align:center;">'. _FPA_CRE .'</div>';
		echo '<div class="column-title" style="width:18%;float:left;text-align:center;">'. _FPA_AUTH .'</div>';
		echo '<div class="column-title" style="width:18%;float:left;text-align:center;">'. _FPA_ADDR .'</div>';
		echo '<div class="column-title" style="width:5%;float:left;text-align:center;">'. _FPA_EN .'</div>';
		echo '<div class="column-title" style="width:10%;float:right;text-align:center;">'. _FPA_TYPE .'</div>';
		echo '<div style="clear:both;"></div>';
		echo '</div>';

		echo '<div class="" style="width:99%;margin: 0px auto;clear:both;margin-bottom:10px;">';
		if ( $instance['instanceFOUND'] == _FPA_N ) { // an instance wasn't found in the initial checks, so no folders to check
			echo '<div style="text-align:center;border-bottom:1px dotted #C0C0C0;width:99%;margin: 0px auto;padding-top:1px;padding-bottom:1px;clear:both;font-size: 11px;">';
			echo '<div class="warn" style=" margin-top:10px;margin-bottom:10px;">'. _FPA_INSTANCE .' '. _FPA_NF .', '. _FPA_NO .' '. $component['ARRNAME'] .' '. _FPA_TESTP .'</div>';
			echo '</div>';
		} else
		// Admin modules 
			foreach ( $module['ADMIN'] as $key => $show ) {
				if (isset($exset[0]['name'])) { 
					$extarrkey = recursive_array_search($show['name'], $exset);
                    if ($extarrkey  !== False) {
					$extenabled = $exset[$extarrkey]['enabled'];
				} else { $extenabled = '?' ;}
				} else { $extenabled = '?' ;}
				if ($extenabled <> 0 AND $extenabled <> 1 ){
					$extenabled = '?';
				}
				if ( $show['type'] == _FPA_3PD OR $showCoreEx == 1 AND $showProtected <= 2) {
					$typeColor = '404040';
					echo '<div><div style="float:left;width:22%;color:#'. $typeColor .';">'. $show['name'] .'</div><div style="float:left;width:10%;text-align:center;color:#'. $typeColor .';">'. $show['version'] .'</div><div style="float:left;width:12%;text-align:center;color:#'. $typeColor .';">'. $show['creationDate'] .'</div><div style="float:left;width:18%;text-align:center;color:#'. $typeColor .';">'. $show['author'] .'</div><div style="float:left;width:18%;text-align:center;color:#'. $typeColor .';">'. $show['authorUrl'] .'</div><div style="float:left;width:5%;text-align:center;color:#'. $typeColor .';">'. $extenabled .'</div><div style="float:right;width:10%;color:#'. $typeColor .';text-align:center;">'. $show['type'] .'</div><br style="clear:both" /></div>';

				} elseif ( $showProtected > 2 ) {
					$typeColor = '000080';
					echo '<div><div style="float:left;width:20%;color:#'. $typeColor .';"><span class="protected">[&nbsp;--&nbsp;'. _FPA_HIDDEN .'&nbsp;--&nbsp;]</span></div><div style="float:left;width:15%;text-align:center;color:#'. $typeColor .';">'. $show['version'] .'</div><div style="float:left;width:15%;color:#'. $typeColor .';">'. $show['creationDate'] .'</div><div style="float:left;width:18%;color:#'. $typeColor .';">'. $show['author'] .'</div><div style="float:left;width:20%;color:#'. $typeColor .';">'. $show['authorUrl'] .'</div><div style="float:right;width:10%;color:#'. $typeColor .';text-align:center;">'. $show['type'] .'</div><br style="clear:both" /></div>';

				}
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
	//Libraries
	if ( $showLibraries == '1' ) {

		echo '<div class="section-information">';

		echo '<div class="section-title" style="text-align:center;">'. $library['ARRNAME'] .' :: '. _FPA_SITE .'</div>';

		echo '<div class="column-title-container" style="width:99%;margin: 0px auto;clear:both;display:block;">';
		echo '<div class="column-title" style="width:22%;float:left;text-align:left;">'. _FPA_TNAM .'</div>';
		echo '<div class="column-title" style="width:10%;float:left;text-align:center;">'. _FPA_VER .'</div>';
		echo '<div class="column-title" style="width:10%;float:left;text-align:center;">'. _FPA_CRE .'</div>';
		echo '<div class="column-title" style="width:18%;float:left;text-align:center;">'. _FPA_AUTH .'</div>';
		echo '<div class="column-title" style="width:18%;float:left;text-align:center;">'. _FPA_ADDR .'</div>';
		echo '<div class="column-title" style="width:5%;float:left;text-align:center;">'. _FPA_EN .'</div>';
		echo '<div class="column-title" style="width:10%;float:right;text-align:center;">'. _FPA_TYPE .'</div>';
		echo '<div style="clear:both;"></div>';
		echo '</div>';


		echo '<div class="" style="width:99%;margin: 0px auto;clear:both;margin-bottom:10px;">';


		echo '<div class="mini-content-box-small" style="">';
		if ( $instance['instanceFOUND'] == _FPA_N ) { // an instance wasn't found in the initial checks, so no folders to check
			echo '<div style="text-align:center;border-bottom:1px dotted #C0C0C0;width:99%;margin: 0px auto;padding-top:1px;padding-bottom:1px;clear:both;font-size: 11px;">';
			echo '<div class="warn" style=" margin-top:10px;margin-bottom:10px;">'. _FPA_INSTANCE .' '. _FPA_NF .', '. _FPA_NO .' '. $component['ARRNAME'] .' '. _FPA_TESTP .'</div>';
			echo '</div>';
		} else
		// Site libraries 
			foreach ( $library['SITE'] as $key => $show ) {
				if (isset($exset[0]['name'])) { 
					$extarrkey = recursive_array_search($show['name'], $exset);
                    if ($extarrkey  !== False) {
					$extenabled = $exset[$extarrkey]['enabled'];
				} else { $extenabled = '?' ;}
				} else { $extenabled = '?' ;}
				if ($extenabled <> 0 AND $extenabled <> 1 ){
					$extenabled = '?';
				}
				if ( $show['type'] == _FPA_3PD OR $showCoreEx == 1 AND $showProtected <= 2) {
					$typeColor = '404040';
					echo '<div><div style="float:left;width:22%;color:#'. $typeColor .';">'. $show['name'] .'</div><div style="float:left;width:10%;text-align:center;color:#'. $typeColor .';">'. $show['version'] .'</div><div style="float:left;width:12%;text-align:center;color:#'. $typeColor .';">'. $show['creationDate'] .'</div><div style="float:left;width:18%;text-align:center;color:#'. $typeColor .';">'. $show['author'] .'</div><div style="float:left;width:18%;text-align:center;color:#'. $typeColor .';">'. $show['authorUrl'] .'</div><div style="float:left;width:5%;text-align:center;color:#'. $typeColor .';">'. $extenabled .'</div><div style="float:right;width:10%;color:#'. $typeColor .';text-align:center;">'. $show['type'] .'</div><br style="clear:both" /></div>';

				} elseif ( $showProtected > 2 ) {
					$typeColor = '000080';
					echo '<div><div style="float:left;width:20%;color:#'. $typeColor .';"><span class="protected">[&nbsp;--&nbsp;'. _FPA_HIDDEN .'&nbsp;--&nbsp;]</span></div><div style="float:left;width:15%;text-align:center;color:#'. $typeColor .';">'. $show['version'] .'</div><div style="float:left;width:15%;color:#'. $typeColor .';">'. $show['creationDate'] .'</div><div style="float:left;width:18%;color:#'. $typeColor .';">'. $show['author'] .'</div><div style="float:left;width:20%;color:#'. $typeColor .';">'. $show['authorUrl'] .'</div><div style="float:right;width:10%;color:#'. $typeColor .';text-align:center;">'. $show['type'] .'</div><br style="clear:both" /></div>';

				}
			}


		echo '</div></div>';


		echo '<br style="clear:both;" />';
		echo '</div></div>';
		// end content left block


	echo '<div style="clear:both;"></div>';

	showDev( $library );
	unset ( $key, $show );
	echo '</div>'; // end half-section container

	echo '<div style="clear:both;"></div>';

	} // end showLibraries
?>



<?php
	//Plugins
	if ( $showPlugins == '1' ) {

		echo '<div class="section-information">';

		echo '<div class="section-title" style="text-align:center;">'. $plugin['ARRNAME'] .' :: '. _FPA_SITE .'</div>';

		echo '<div class="column-title-container" style="width:99%;margin: 0px auto;clear:both;display:block;">';
		echo '<div class="column-title" style="width:22%;float:left;text-align:left;">'. _FPA_TNAM .'</div>';
		echo '<div class="column-title" style="width:10%;float:left;text-align:center;">'. _FPA_VER .'</div>';
		echo '<div class="column-title" style="width:10%;float:left;text-align:center;">'. _FPA_CRE .'</div>';
		echo '<div class="column-title" style="width:18%;float:left;text-align:center;">'. _FPA_AUTH .'</div>';
		echo '<div class="column-title" style="width:18%;float:left;text-align:center;">'. _FPA_ADDR .'</div>';
		echo '<div class="column-title" style="width:5%;float:left;text-align:center;">'. _FPA_EN .'</div>';
		echo '<div class="column-title" style="width:10%;float:right;text-align:center;">'. _FPA_TYPE .'</div>';
		echo '<div style="clear:both;"></div>';
		echo '</div>';


		echo '<div class="" style="width:99%;margin: 0px auto;clear:both;margin-bottom:10px;">';



		echo '<div class="mini-content-box-small" style="">';
		if ( $instance['instanceFOUND'] == _FPA_N ) { // an instance wasn't found in the initial checks, so no folders to check
			echo '<div style="text-align:center;border-bottom:1px dotted #C0C0C0;width:99%;margin: 0px auto;padding-top:1px;padding-bottom:1px;clear:both;font-size: 11px;">';
			echo '<div class="warn" style=" margin-top:10px;margin-bottom:10px;">'. _FPA_INSTANCE .' '. _FPA_NF .', '. _FPA_NO .' '. $component['ARRNAME'] .' '. _FPA_TESTP .'</div>';
			echo '</div>';
		} else
		// Site Plugins 
			foreach ( $plugin['SITE'] as $key => $show ) {
				if (isset($exset[0]['name'])) { 
					$extarrkey = recursive_array_search($show['name'], $exset);
                    if ($extarrkey  !== False) {
					$extenabled = $exset[$extarrkey]['enabled'];
				} else { $extenabled = '?' ;}
				} else { $extenabled = '?' ;}
				if ($extenabled <> 0 AND $extenabled <> 1 ){
					$extenabled = '?';
				}
				if ( $show['type'] == _FPA_3PD OR $showCoreEx == 1 AND $showProtected <= 2) {
					$typeColor = '404040';
					echo '<div><div style="float:left;width:22%;color:#'. $typeColor .';">'. $show['name'] .'</div><div style="float:left;width:10%;text-align:center;color:#'. $typeColor .';">'. $show['version'] .'</div><div style="float:left;width:12%;text-align:center;color:#'. $typeColor .';">'. $show['creationDate'] .'</div><div style="float:left;width:18%;text-align:center;color:#'. $typeColor .';">'. $show['author'] .'</div><div style="float:left;width:18%;text-align:center;color:#'. $typeColor .';">'. $show['authorUrl'] .'</div><div style="float:left;width:5%;text-align:center;color:#'. $typeColor .';">'. $extenabled .'</div><div style="float:right;width:10%;color:#'. $typeColor .';text-align:center;">'. $show['type'] .'</div><br style="clear:both" /></div>';

				} elseif ( $showProtected > 2 ) {
					$typeColor = '000080';
					echo '<div><div style="float:left;width:20%;color:#'. $typeColor .';"><span class="protected">[&nbsp;--&nbsp;'. _FPA_HIDDEN .'&nbsp;--&nbsp;]</span></div><div style="float:left;width:15%;text-align:center;color:#'. $typeColor .';">'. $show['version'] .'</div><div style="float:left;width:15%;color:#'. $typeColor .';">'. $show['creationDate'] .'</div><div style="float:left;width:18%;color:#'. $typeColor .';">'. $show['author'] .'</div><div style="float:left;width:20%;color:#'. $typeColor .';">'. $show['authorUrl'] .'</div><div style="float:right;width:10%;color:#'. $typeColor .';text-align:center;">'. $show['type'] .'</div><br style="clear:both" /></div>';

				}
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
?>




<?php
		// Templates
		echo '<div class="section-information">';

		echo '<div class="section-title" style="text-align:center;">'. $template['ARRNAME'] .' :: '. _FPA_SITE .'</div>';

		echo '<div class="column-title-container" style="width:99%;margin: 0px auto;clear:both;display:block;">';
		echo '<div class="column-title" style="width:22%;float:left;text-align:left;">'. _FPA_TNAM .'</div>';
		echo '<div class="column-title" style="width:10%;float:left;text-align:center;">'. _FPA_VER .'</div>';
		echo '<div class="column-title" style="width:10%;float:left;text-align:center;">'. _FPA_CRE .'</div>';
		echo '<div class="column-title" style="width:18%;float:left;text-align:center;">'. _FPA_AUTH .'</div>';
		echo '<div class="column-title" style="width:18%;float:left;text-align:center;">'. _FPA_ADDR .'</div>';
		echo '<div class="column-title" style="width:5%;float:left;text-align:center;">'. _FPA_EN .'</div>';
		echo '<div class="column-title" style="width:10%;float:right;text-align:center;">'. _FPA_TYPE .'</div>';
		echo '<div style="clear:both;"></div>';
		echo '</div>';


		echo '<div class="" style="width:99%;margin: 0px auto;clear:both;margin-bottom:10px;">';


		echo '<div class="mini-content-box-small" style="">';
		if ( $instance['instanceFOUND'] == _FPA_N ) { // an instance wasn't found in the initial checks, so no folders to check
			echo '<div style="text-align:center;border-bottom:1px dotted #C0C0C0;width:99%;margin: 0px auto;padding-top:1px;padding-bottom:1px;clear:both;font-size: 11px;">';
			echo '<div class="warn" style=" margin-top:10px;margin-bottom:10px;">'. _FPA_INSTANCE .' '. _FPA_NF .', '. _FPA_NO .' '. $component['ARRNAME'] .' '. _FPA_TESTP .'</div>';
			echo '</div>';
		} else
		// Site templates 
			foreach ( $template['SITE'] as $key => $show ) {
				if (isset($exset[0]['name'])) { 
					$extarrkey = recursive_array_search($show['name'], $exset);
                    if ($extarrkey  !== False) {
					$extenabled = $exset[$extarrkey]['enabled'];
				} else { $extenabled = '?' ;}
				} else { $extenabled = '?' ;}
				if ($extenabled <> 0 AND $extenabled <> 1 ){
					$extenabled = '?';
				}
				if ( $show['type'] == _FPA_3PD OR $showCoreEx == 1 AND $showProtected <= 2) {
					$typeColor = '404040';
					echo '<div><div style="float:left;width:22%;color:#'. $typeColor .';">'. $show['name'] .'</div><div style="float:left;width:10%;text-align:center;color:#'. $typeColor .';">'. $show['version'] .'</div><div style="float:left;width:12%;text-align:center;color:#'. $typeColor .';">'. $show['creationDate'] .'</div><div style="float:left;width:18%;text-align:center;color:#'. $typeColor .';">'. $show['author'] .'</div><div style="float:left;width:18%;text-align:center;color:#'. $typeColor .';">'. $show['authorUrl'] .'</div><div style="float:left;width:5%;text-align:center;color:#'. $typeColor .';">'. $extenabled .'</div><div style="float:right;width:10%;color:#'. $typeColor .';text-align:center;">'. $show['type'] .'</div><br style="clear:both" /></div>';

				} elseif ( $showProtected > 2 ) {
					$typeColor = '000080';
					echo '<div><div style="float:left;width:20%;color:#'. $typeColor .';"><span class="protected">[&nbsp;--&nbsp;'. _FPA_HIDDEN .'&nbsp;--&nbsp;]</span></div><div style="float:left;width:15%;text-align:center;color:#'. $typeColor .';">'. $show['version'] .'</div><div style="float:left;width:15%;color:#'. $typeColor .';">'. $show['creationDate'] .'</div><div style="float:left;width:18%;color:#'. $typeColor .';">'. $show['author'] .'</div><div style="float:left;width:20%;color:#'. $typeColor .';">'. $show['authorUrl'] .'</div><div style="float:right;width:10%;color:#'. $typeColor .';text-align:center;">'. $show['type'] .'</div><br style="clear:both" /></div>';

				}
			}

		echo '</div></div>';




		echo '<br style="clear:both;" />';
		echo '<div class="section-title" style="text-align:center;">'. $template['ARRNAME'] .' :: '. _FPA_ADMIN .'</div>';

		echo '<div class="column-title-container" style="width:99%;margin: 0px auto;clear:both;display:block;">';
		echo '<div class="column-title" style="width:22%;float:left;text-align:left;">'. _FPA_TNAM .'</div>';
		echo '<div class="column-title" style="width:10%;float:left;text-align:center;">'. _FPA_VER .'</div>';
		echo '<div class="column-title" style="width:10%;float:left;text-align:center;">'. _FPA_CRE .'</div>';
		echo '<div class="column-title" style="width:18%;float:left;text-align:center;">'. _FPA_AUTH .'</div>';
		echo '<div class="column-title" style="width:18%;float:left;text-align:center;">'. _FPA_ADDR .'</div>';
		echo '<div class="column-title" style="width:5%;float:left;text-align:center;">'. _FPA_EN .'</div>';
		echo '<div class="column-title" style="width:10%;float:right;text-align:center;">'. _FPA_TYPE .'</div>';
		echo '<div style="clear:both;"></div>';
		echo '</div>';

		echo '<div class="" style="width:99%;margin: 0px auto;clear:both;margin-bottom:10px;">';
		if ( $instance['instanceFOUND'] == _FPA_N ) { // an instance wasn't found in the initial checks, so no folders to check
			echo '<div style="text-align:center;border-bottom:1px dotted #C0C0C0;width:99%;margin: 0px auto;padding-top:1px;padding-bottom:1px;clear:both;font-size: 11px;">';
			echo '<div class="warn" style=" margin-top:10px;margin-bottom:10px;">'. _FPA_INSTANCE .' '. _FPA_NF .', '. _FPA_NO .' '. $component['ARRNAME'] .' '. _FPA_TESTP .'</div>';
			echo '</div>';
		} else
		// Admin templates 
			foreach ( $template['ADMIN'] as $key => $show ) {
				if (isset($exset[0]['name'])) { 
					$extarrkey = recursive_array_search($show['name'], $exset);
                    if ($extarrkey  !== False) {
					$extenabled = $exset[$extarrkey]['enabled'];
				} else { $extenabled = '?' ;}
				} else { $extenabled = '?' ;}
				if ($extenabled <> 0 AND $extenabled <> 1 ){
					$extenabled = '?';
				}
				if ( $show['type'] == _FPA_3PD OR $showCoreEx == 1 AND $showProtected <= 2) {
					$typeColor = '404040';
					echo '<div><div style="float:left;width:22%;color:#'. $typeColor .';">'. $show['name'] .'</div><div style="float:left;width:10%;text-align:center;color:#'. $typeColor .';">'. $show['version'] .'</div><div style="float:left;width:12%;text-align:center;color:#'. $typeColor .';">'. $show['creationDate'] .'</div><div style="float:left;width:18%;text-align:center;color:#'. $typeColor .';">'. $show['author'] .'</div><div style="float:left;width:18%;text-align:center;color:#'. $typeColor .';">'. $show['authorUrl'] .'</div><div style="float:left;width:5%;text-align:center;color:#'. $typeColor .';">'. $extenabled .'</div><div style="float:right;width:10%;color:#'. $typeColor .';text-align:center;">'. $show['type'] .'</div><br style="clear:both" /></div>';

				} elseif ( $showProtected > 2 ) {
					$typeColor = '000080';
					echo '<div><div style="float:left;width:20%;color:#'. $typeColor .';"><span class="protected">[&nbsp;--&nbsp;'. _FPA_HIDDEN .'&nbsp;--&nbsp;]</span></div><div style="float:left;width:15%;text-align:center;color:#'. $typeColor .';">'. $show['version'] .'</div><div style="float:left;width:15%;color:#'. $typeColor .';">'. $show['creationDate'] .'</div><div style="float:left;width:18%;color:#'. $typeColor .';">'. $show['author'] .'</div><div style="float:left;width:20%;color:#'. $typeColor .';">'. $show['authorUrl'] .'</div><div style="float:right;width:10%;color:#'. $typeColor .';text-align:center;">'. $show['type'] .'</div><br style="clear:both" /></div>';
				}
			}

		echo '</div></div>';
		echo '<br style="clear:both;" />';
		echo '</div></div>';
		// end content left block


	echo '<div style="clear:both;"></div>';

	showDev( $template );
	unset ( $key, $show );
	echo '</div>'; // end half-section container

	echo '<div style="clear:both;"></div>';
	// end show templates
?>


<?php
	showDev( $fpa );

	if ( defined( '_FPA_DEV' ) ) {

		echo '<div class="dev-mode-information">';
		echo '<span class="dev-mode-title">'. _RES .' Memory Statistics : </span> (requires PHP4.3.2 & PHP5.2.0)<br />';
		echo '<div style="margin-left: 10px;">';

			function convert($size) {
				$unit=array('b','kb','mb','gb','tb','pb');
				return @round($size/pow(1024,($i=floor(log($size,1024)))),2).' '.$unit[$i];
			}

				if( function_exists('memory_get_usage') ) {
					echo 'Currently Allocated Memory: '. convert( memory_get_usage() ) .'<br />'; // currently allocated memory
				} else {
					echo _PHP_VERLOW .', memory_get_usage '. _FPA_DNE .'<br />';
				}


				if( function_exists('memory_get_peak_usage') ) {
					echo 'Total Peak Memory: '. convert( memory_get_peak_usage(true) ); // total peak memory usage
				} else {
					echo _PHP_VERLOW .', memory_get_peak_usage '. _FPA_DNE .'<br />';
				}

		echo '<p style="font-weight:bold;"><em>total runtime : '. mt_end() .' '. _FPA_SECONDS .'</em></p>';
		echo '</div>';
		echo '</div>';
	}







		echo '<div class="snapshot-information" style="text-align:center;color:#4D8000!important;padding-top:10px;">';
		echo '<span class="header-title">'. _FPA_LEGEND .'</span>';
		echo '<div style="width:85%;margin:0 auto;margin-top:10px;">';
		// LEGENDS
		echo '<div class="half-section-container" style="clear:both;width:100%;">';
		echo '<div class="ok-hilite" style="text-align:center;width:21%;float:left;margin-left:10px;margin-right:10px;">'. _FPA_GOOD .'</div>';
		echo '<div class="warn" style="text-align:center;width:21%;float:left;margin-left:10px;margin-right:10px;">'. _FPA_WARNINGS .'</div>';
		echo '<div class="alert" style="text-align:center;width:21%;float:left;margin-left:10px;margin-right:10px;">'. _FPA_ALERTS .'</div>';
		echo '<div class="protected" style="text-align:center;width:21%;float:left;margin-left:10px;margin-right:10px;">[&nbsp;--&nbsp;'. _FPA_HIDDEN .'&nbsp;--&nbsp;]</div>';
		echo '</div>';
		echo '<div style="clear:both;"><br /></div>';


		// SELECTIONS
		echo '<div style="font-weight:bold;width:25%;float:left;text-align:center;">Developer-Mode<br />';
			if ( defined ( '_FPA_DEV' ) ) {
				echo '<div class="normal-note">'. _FPA_EN .'</div>';
			} else {
				echo '<div class="normal-note">'. _FPA_DI .' (<i style="color:#808080;">'. _FPA_DEF .'</i> )</div>';
			}
		echo '</div>';

		echo '<div style="font-weight:bold;width:25%;float:left;text-align:center;">'. _FPA_INFOPRI .'<br />';
			if ( $showProtected == 1 ) {
				echo '<div class="normal-note"><span class="ok">'. _FPA_PRIVNON .'</span></div>';
			} elseif ( $showProtected == 2 ) {
				echo '<div class="normal-note"><span class="warn-text">'. _FPA_PRIVPAR .'</span> (<i style="color:#808080;">'. _FPA_DEF .'</i> )</div>';
			} elseif ( $showProtected >= 3 ) {
				echo '<div class="normal-note"><span class="alert-text">'. _FPA_PRIVSTR .'</span></div>';
			}
		echo '</div>';

		echo '<div style="font-weight:bold;width:25%;float:left;text-align:center;">'. _FPA_ELEVPERM_TITLE .'<br />';
			if ( $showElevated == 1 ) {
				echo '<div class="normal-note">'. _FPA_SHOW .'</div>';
			} else {
				echo '<div class="normal-note">'. _FPA_HIDE .' (<i style="color:#808080;">'. _FPA_DEF .'</i> )</div>';
			}
		echo '</div>';

		echo '<div style="font-weight:bold;width:25%;float:left;text-align:center;">'. _FPA_DBTBL_TITLE .'<br />';
			if ( $showTables == '1' ) {
				echo '<div class="normal-note">'. _FPA_SHOW .'</div>';
			} else {
				echo '<div class="normal-note">'. _FPA_HIDE .' (<i style="color:#808080;">'. _FPA_DEF .'</i> )</div>';
			}
		echo '</div>';

		echo '<br style="clear:both;" />';

		echo '<div style="font-weight:bold;width:25%;float:left;text-align:center;">Diagnostic-Mode<br />';
			if ( defined ( '_FPA_DIAG' ) ) {
				echo '<div class="normal-note">'. _FPA_EN .'</div>';
			} else {
				echo '<div class="normal-note">'. _FPA_DI .' (<i style="color:#808080;">'. _FPA_DEF .'</i> )</div>';
			}
		echo '</div>';

		echo '<div style="font-weight:bold;width:25%;float:left;text-align:center;">'. _FPA_EXTCOM_TITLE .'<br />';
			if ( $showComponents == '1' ) {
				echo '<div class="normal-note">'. _FPA_SHOW .'</div>';
			} else {
				echo '<div class="normal-note">'. _FPA_HIDE .' (<i style="color:#808080;">'. _FPA_DEF .'</i> )</div>';
			}
		echo '</div>';

		echo '<div style="font-weight:bold;width:25%;float:left;text-align:center;">'. _FPA_EXTMOD_TITLE .'<br />';
			if ( $showModules == '1' ) {
				echo '<div class="normal-note">'. _FPA_SHOW .'</div>';
			} else {
				echo '<div class="normal-note">'. _FPA_HIDE .' (<i style="color:#808080;">'. _FPA_DEF .'</i> )</div>';
			}
		echo '</div>';

		echo '<div style="font-weight:bold;width:25%;float:left;text-align:center;">'. _FPA_EXTPLG_TITLE .'<br />';
			if ( $showPlugins == '1' ) {
				echo '<div class="normal-note">'. _FPA_SHOW .'</div>';
			} else {
				echo '<div class="normal-note">'. _FPA_HIDE .' (<i style="color:#808080;">'. _FPA_DEF .'</i> )</div>';
			}
		echo '</div>';

		echo '</div>';
		echo '<div style="clear:both;"><br /></div>';

		echo '<div style="text-align:center!important;"><a style="color:#4D8000!important;" href="'. _RES_FPALINK .''. _RES_LANG .'" target="_github">'. _RES_FPALATEST .' '. _RES .'</a></div>';
		echo "<p></p>";
		echo '<div style="text-align:center!important;"><a style="color:#4D8000!important;" href="'. _RES_FPALINK2 .''. _RES_LANG .'" target="_github">'. _RES_FPALATEST2 .' '. _RES .'</a></div>';
		echo "<br></br><p>FPA " . _RES_VERSION . " " . _COPYRIGHT_STMT . " "  . _LICENSE_FOOTER . " "  . _LICENSE_LINK . "</p>";
		echo '</div>';

?>


</body>
</html>
