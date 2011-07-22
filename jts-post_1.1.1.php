<?php
/**
 **  @package Joomla! Tools Suite - Forum Post Generation Utility
 **  @author RussW
 **  @copyright RussW, All rights reserved. 2010
 **/


	 /****************************************************************************** 
	  ** IF YOU ARE SEEING A WHITE SCREEN WHNE RUNNING JTS-post OR IF YOU WERE SENT
    ** HERE BY THE JTS-WSD TOOL COMMENT OUT THE FOLLOWING LINE BY PLACING TWO 
    ** forward slashes in front of it, like this;
	  ******************************************************************************/
//	   error_reporting( E_ALL ); 
//		error_reporting( E_NOTICE );
			
	/** SET THE PARENT FILE FLAG **/
		define( '_VALID_MOS', 1 );
		define( '_JEXEC', 1 );
		define( 'JPATH_BASE', dirname(__FILE__ ) );

	/** MESSAGE/LANGUAGE SECTION (FOR TRANSALTION) **/
	// Basic Setup
		define( '_JTSP_TITLE', 'JTS-post : Joomla! Forum Post Assistant' );
		define( '_JTSP_VERSION', '1.1.1' );
		define( '_JTSP_RELEASE', 'Final' );
		define( '_JTSP_JTS', 'Joomla! Tools Suite' );
	// User Instructions, Notes and Data Entry
		define( '_INSTRUCTIONS', 'Instructions' );
		define( '_INS_1', 'Complete your problem description <i>(optional)</i>' );
		define( '_INS_2', 'Add <i>single line</i> error message of log entry <i>(optional)</i>' );
		define( '_INS_3', 'Explain what actions have already been taken to resolve this issue <i>(optional)</i>' );
		define( '_INS_4', 'Select additional level(s) of detail to generate in post.' );
		define( '_INS_5', 'Click "<em>Generate Forum Post</em>" button.' );

		define( '_POST_NOTE', 'Leave ALL fields blank/empty to simply post diagnostic information.' );
		define( '_PROB_DESC', 'Problem Description' );
		define( '_LOG_MSG', 'Log/Error Message' );
		define( '_ACTION', 'Actions Taken To Resolve' );
	// Basic Profile and Options Setup
		define( '_PROFILE_RUN_OPTIONS', 'Run Time Options' );
		define( '_PROFILE_EXTENDED_TITLE', 'Extended Diagnostic Post' );
		define( '_PROFILE_EXTENDED_INFO', 'Includes additional, more detailed information in output' );
		define( '_PROFILE_EXTENDED_SECURE', 'Include Potentially Sensative Information?' );
		define( '_PROFILE_EXTENDED_SECURE_INFO', 'Includes Hostname, Domainname, IP Address entries from output' );
		define( '_PROFILE_EXTENDED_CHOICE', 'Generate An' );
		define( '_PROFILE_INCLUDE_COMPONENT_CHOICE', 'Include Component Audit' );
		define( '_PROFILE_INCLUDE_COMPONENT_INFO', 'Includes a component revision audit (on screen only)' );
		define( '_PROFILE_INCLUDE_MODULE_CHOICE', 'Include Module Audit' );
		define( '_PROFILE_INCLUDE_MODULE_INFO', 'Includes a module revision audit (on screen only)' );
		define( '_PROFILE_INCLUDE_PLUGIN_CHOICE', 'Include Plugin Audit' );
		define( '_PROFILE_INCLUDE_PLUGIN_INFO', 'Includes a plugin revision audit (on screen only)' );
		define( '_PROFILE_RUN_MSG', 'Click the "Generate Forum Post" button to generate a pre-prepared forum configuration post, then copy the provided output and paste it in to a post at <a href="http://forum.joomla.org/" target="JForums">http://forum.joomla.org/</a>' );
		define( '_PROFILE_RUN', 'Generate Forum Post' );
		define( '_PROFILE_RESET', 'Reset' );

		define( '_PROFILE_EXECERROR', 'Seeing PHP "Out of Memory" or "Execution Time" Errors?' );
		define( '_PROFILE_EXECERROR_INFO', 'Temporarily increase PHP Memory and Execution Time.' );

	// Discovery Labels
		define( '_ENV_DISCOVERY', 'Environment Discovery' );
		define( '_JOOMLA', 'Joomla!' );
		define( '_HOST', 'Host' );
		define( '_WEB', 'Web' );
		define( '_PHP', 'PHP' );
		define( '_MYSQL', 'MySQL' );
		define( '_ENVIRONMENT', 'Environment' );

		define( '_CFG_FILE', 'configuration.php' );
		define( '_ARCHITECTURE', 'Architecture' );
		define( '_PLATFORM', 'Platform' );
		define( '_VERSION', 'Version' );
		define( '_WRITABLE', 'Writable' );
		define( '_NOT_WRITABLE', 'Not Writable' );
		define( '_MODE', 'Mode' );
		define( '_RG_EMULATION', 'RG_EMULATION' );
		define( '_ENABLED', 'Enabled' );
		define( '_DISABLED', 'Disabled' );
		define( '_NA', 'N/A' );
		define( '_SERVER', 'Server' );
		define( '_SUPPORT', 'Support' );
		define( '_REQ', 'Requirements' );
		define( '_NO', 'No' );
		define( '_YES', 'Yes' );
		define( '_SECONDS', 'seconds' );
		define( '_INFO', 'Info' );
		define( '_WO_REWRITE', 'without ReWrite' );
		define( '_W_REWRITE', 'with ReWrite' );
		define( '_NOT_IMPLEMENTED', 'Not Implemented' );
		define( '_IMPLEMENTED', 'Implemented' );
		define( '_CURRENT_PATH', 'Current Path' );
		define( '_DOC_ROOT', 'Document Root' );
		define( '_ACCOUNT', 'Acc.' );
		define( '_USER', 'User' );
		define( '_ACC_MATCH', 'User and Web Server accounts are the same. (PHP/suExec probably installed)' );
		define( '_ACC_MATCH_NO', 'User and Web Server accounts are not the same. (PHP/suExec probably not installed)' );
		define( '_FUNCTIONS', 'Functions' );
		define( '_CLIENT', 'Client' );
		define( '_CHARSET', 'Character Set' );

	define( '_DIAG_INFO', 'Diagnostic Information' );
	define( '_EXT_INFO', 'Extended Information' );
	define( '_COMPONENT', 'a component of' );

	define( '_BAD_VERSION', 'The Joomla! version was not recognised, or we were unable to find the appropriate "version" file.' );
	define( '_NOT_INSTALLED', 'A Joomla! instance was not detected, either Joomla! is not installed or we were unable to find/read a "configuration.php" file.' );


	/** BEGIN BASIC DISCOVERY ROUTINES **/
		
		/** J! version discovery **/
		// INITIAL CHECKS AND SETUP
		// Find the Joomla! configuration file(s)
			if (file_exists( './configuration.php' )) {

			// Is J! installed yet?
			if(defined( '_VALID_MOS' )) {
 	  		@require_once("./configuration.php");
				} else {
   				@include_once("./configuration.php");
					} 

					if(defined( '_JEXEC' )) {
 	  				@require_once("./configuration.php");
						} else {
   						@include_once("./configuration.php");
							} 

		// If we find a configuration.php, Joomla! should be considered to be installed.
		$installedJ		=	"1";

			} else if (!file_exists( './configuration.php' )) {
				// or are doing Pre-Installation checks?
				$installedJ		=	"0";
				}

	/** BEGIN JOOMLA VERSION CHECKING **/
	// Check for J! v1.0 version file
		if (file_exists( './includes/version.php' )) {
			@require_once( './includes/version.php' );

				// Build a MySQL connection
        $link = @mysql_connect('localhost', $mosConfig_user, $mosConfig_password);
					$sqlErr = mysql_errno();

					// If MySQL fails, try MySQLi
					if ((!$link) && (function_exists( 'mysqli_connect' ))) {
						$link = @mysqli_connect('localhost', $mosConfig_user, $mosConfig_password);
							$sqlErr = mysqli_connect_errno();
							}
/******************************************************************************
** IF YOU ARE SEEING A WHITE SCREEN WHNE RUNNING JTS-post OR IF YOU WERE SENT
** HERE BY THE JTS-WSD TOOL COMMENT OUT THE FOLLOWING LINE BY PLACING TWO
** forward slashes in front of it, like this;
** J1.0.x check fails with white screen and class erro - cm210711
******************************************************************************/

		// Discovery - It's Joomla! 1.0
		$isJVER         = "10";

			$_VERSION 		= new joomlaVersion();
			$version 		= $_VERSION->PRODUCT .' '. $_VERSION->RELEASE .'.'. $_VERSION->DEV_LEVEL .' '. $_VERSION->DEV_STATUS.' [ '.$_VERSION->CODENAME .' ] '. $_VERSION->RELDATE .' '. $_VERSION->RELTIME .' '. $_VERSION->RELTZ;


		// Check for J! v1.5 or v1.6 version file
		} else if (file_exists( './libraries/joomla/version.php' )) {  
				@require_once( './libraries/joomla/version.php' );


//			define('JPATH_BASE', dirname(__FILE__) );
			if (!defined ('JPATH_BASE') ) {
				define('JPATH_BASE', dirname(__FILE__) );
			}
			define( 'DS', DIRECTORY_SEPARATOR );

			require_once ( JPATH_BASE .DS.'includes'.DS.'defines.php' );
			require_once ( JPATH_BASE .DS.'includes'.DS.'framework.php' );

			// Not sure this is required, MySQL "get" commands work fine for me, but not for some without it....
			$mainframe =& JFactory::getApplication('site');


			$_VERSION 		= new JVersion();
			$version 		= $_VERSION->PRODUCT .' '. $_VERSION->RELEASE .'.'. $_VERSION->DEV_LEVEL .' '. $_VERSION->DEV_STATUS.' [ '.$_VERSION->CODENAME .' ] '. $_VERSION->RELDATE .' '. $_VERSION->RELTIME .' '. $_VERSION->RELTZ;



			// Discovery - It's Joomla! 1.5		
			if ($_VERSION->RELEASE == 1.5) { $isJVER = "15"; }

				// Discovery - It's Joomla! 1.6		
				if ($_VERSION->RELEASE == 1.6) { $isJVER =  "16"; }



			$_JCONFIG		= new JConfig();
			@$jts_legacy - @$_JCONFIG->legacy;
			$jts_ftp		= $_JCONFIG->ftp_enable;
			$jts_sef		= $_JCONFIG->sef;
			$jts_sef_rewrite= $_JCONFIG->sef_rewrite;


			// Otherwise, assume J! is not installed and the user is doing Pre-Installation check, or a bad/incomplete FTP upload has occured
			} else if ((@$isJVER != "10") || (@$isJVER != "15") || (@$isJVER != "16")) {

				// Set isJVER to Pre-Install (PI) to force Pre-Install Check otpions only
				$isJVER			= "unknownVer";

				}

			/** SETUP Common Output responses **/


				if (is_writable('./configuration.php')) { 
					$cfgWrite = "[color=red]". _WRITABLE ."[/color]"; $cfgPerm = substr(sprintf('%o', @fileperms('./configuration.php')),-3, 3); 
					} else { 
						$cfgWrite = "". _NOT_WRITABLE .""; 
						$cfgPerm = substr(sprintf('%o', @fileperms('./configuration.php')),-3, 3);
						}



				if ( ($isJVER == "15") || ($isJVER == "16") ) {

					if ($jts_sef == "0") { 
						$sefstate = "". _DISABLED.""; 
						} else { 
							$sefstate = "". _ENABLED."";
							}
					
					if ($jts_sef_rewrite == "0") { 
						$rewritestate = " (". _WO_REWRITE .") "; 
						} else { 
							$rewritestate = " (". _W_REWRITE .") "; 
							}
					
				} else {

					if ( (@$mosConfig_sef == "0") || (@$mosConfig_sef == "") ) { 
						$sefstate = "". _DISABLED .""; $rewritestate = ''; 
						} else { 
							$sefstate = "". _ENABLED .""; $rewritestate = ''; 
							}
				
				}


		if ($isJVER == "15") { 

				if (@$jts_legacy == "1") { 
					$legacymode = "". _ENABLED .""; 
					} else { 
						$legacymode = "". _DISABLED .""; 
						}


				if ($jts_ftp == "1") { 
					$ftpLayer = "". _ENABLED .""; 
					} else { 
						$ftpLayer = "". _DISABLED .""; 
						}

		} else {
			$legacymode = "". _NA ."";
			$ftpLayer = "". _NA ."";
			}




				// Using .htaccess?
				if (!file_exists('.htaccess')) { 
					$htaccess = "". _NOT_IMPLEMENTED .""; 
					} else { 
						$htaccess = "". _IMPLEMENTED .""; 
						}		


				// Looking for some form of "SwitchUser" Utility
				if (function_exists( 'exec' )) {
        			$ApacheAcc = exec("whoami");
					} else if (function_exists( 'passthru' )) {         				 		
						$ApacheAcc = passthru("whoami");
						}

				$UserAcc = get_current_user ();

				if ($UserAcc == $ApacheAcc) { 
					$accountMatch = "". _ACC_MATCH .""; 
					} else { 
						$accountMatch = "". _ACC_MATCH_NO .""; 
						}


				// Looking for MySQL Client version
				if (@function_exists('mysql_client_encoding')) { 
					$charset = mysql_client_encoding();
					}


		// If Audits time-out or run out of memory, try increasing them.
		if ( @$_POST['executionError'] == "1" ) {
			$prevExecTime = ini_get('max_execution_time');
			$execTimeMSG = " now, but user had to increase from ". $prevExecTime ."";

			$prevExecMem = ini_get('memory_limit');
			$execMemMSG = " now, but user had to increase from ". $prevExecMem ."";

			ini_set('max_execution_time','240');
			ini_set("memory_limit","96M");
		}
//echo $prevExecTime ." | ". $prevExecMem;

	// END JTS CONFIGURATION AND SETUP


	/** BEGIN BASIC PAGE **/
		echo "<?xml version=\"1.0\" encoding=\"iso-8859-1\"?".">";
?>


	<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
	<html xmlns="http://www.w3.org/1999/xhtml">
	<head>


	<!--// BEGIN STYLING //-->
		<style type="text/css">
		body, div, input, p, span 	{ font-size:11px; color: #404040;font-family:tahoma, arial, verdana; }
		td													{ padding-left: 10px; font-family:tahoma, arial, verdana; }
		.jts-heading								{ font-size: 20px; line-height:22px;font-weight:bold; font-variant: small-caps;}
		.lowRiskOption 							{ color: #404040; }
		.highRiskOption 						{ color: #800000; }
		.headings										{ color: #212121; font-size: 11px; font-weight:bold;}
		.tdHeadings									{ color:#212121;padding-left:6px;font-weight:bold;border: 1px solid #29447B; background-color: #5094A0; }
		.tdSHeadings								{ color:#212121;padding-left:6px;font-weight:bold;border: 1px solid #5094A0; background-color: transparent; }
		.problemNotes 							{ color: #404040; font-size: 9px; font-weight:bold; }
	 	.problemInput								{ border: 1px solid #FF9900; background-color: #FFF0D8; }
		.profileNotes 							{ color: #808080; font-size: 9px; }
		.tColumn-l									{ background-color:#F5F5F5;width:auto;text-align:left;padding-left:25px;border:1px solid #C0C0C0;float:left;width:43%;margin-left:10px; }
		.bColumn-l									{ width:auto;text-align:left;padding-left:15px;float:left;width:45%; }
		.tColumn-r									{ background-color:#F5F5F5;width:auto;text-align:left;padding-left:25px;border:1px solid #C0C0C0;float:right;width:43%;margin-right:10px; }
		.bColumn-r									{ width:auto;text-align:left;padding-right:20px;float:right;width:45% }

		</style>
	

		<title><?php echo _JTSP_TITLE ." : v". _JTSP_VERSION ." (". _JTSP_RELEASE .")"; ?></title>

		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />

		<?php
		/** BASIC PAGE SETUP **/
		// Cute'sie, icon stuff, if available
		if ( $isJVER == "10" ) {
			echo '<link rel="shortcut icon" href="./images/favicon.ico" />';

				} else {
				echo '<link rel="shortcut icon" href="./templates/rhuk_milkyway/favicon.ico" />';
					
					}
		?>


		<script type="text/javascript"> 
		// Auto-Select all the output on Focus in the output textarea
			function select_all() {
				var text_val=eval("document.JTSpost.profileOutput");
					text_val.focus();
					text_val.select();
			}
		
		</script>





	</head>

		<body>

	<?php
		// J! Version has been recognised
		if ( ( @$isJVER != "unknownVer" ) && ( @$installedJ != "0" ) ) { 		
		?>


		<!--// Open Main Container //-->
		<div class="main-container" style="width:775px;margin:0px auto;">		


		<!--// Application Title //-->
		<div class="tdHeadings jts-heading" style="width:100%;text-align:center;">

			<?php echo _JTSP_TITLE ." <span style='font-size: 9pt;font-weight:normal;'>: v"._JTSP_VERSION ." (". _JTSP_RELEASE .")</span>" ?>			

		</div>


	<br style="clear:both;" />

		<!--// Instructions, tell 'em how to use it... //-->
		<div class="tColumn-l" style="">
			
					<p class="headings"><?php echo _INSTRUCTIONS; ?></p>

						<span class="lowRiskOption" style="">
							<b>1.</b> <?php echo _INS_1; ?><br />
							<b>2.</b> <?php echo _INS_2; ?><br />
							<b>3.</b> <?php echo _INS_3; ?><br />
							<b>4.</b> <?php echo _INS_4; ?><br />
							<b>5.</b> <?php echo _INS_5; ?><br /> 
						</span>

					<br />
		</div>


		<!--// Ask what Actions and Choices They Want //-->
		<div class="tColumn-r" style="">

			<p class="headings"><?PHP echo _PROFILE_RUN_OPTIONS; ?></p>

				<form method="post" name="JTSpost">


					<!--// Do An EXTENDED Profile //-->
					<?php if ( @$_POST['doEXTPROFILE'] == 1 ) { $_EXTENDED_PROFILE_CHECKED = "checked"; }?>
					<input type="checkbox" name="doEXTPROFILE" value="1" <?php echo @$_EXTENDED_PROFILE_CHECKED; ?> >
						<span class="lowRiskOption"><?php echo _PROFILE_EXTENDED_CHOICE .' '. _PROFILE_EXTENDED_TITLE; ?>?</span>
							<br />
								<span class="profileNotes" style="padding-left:5px;"><?php echo _PROFILE_EXTENDED_INFO; ?></span>
				
					<br />
				
						<!--// Include a INSECURE Information //-->
						<?php if ( @$_POST['doEXTPROFILESECURE'] == 1 ) { $_EXTENDED_PROFILESECURE_CHECKED = "checked"; }?>
						<input style="margin-left:25px;" type="checkbox" name="doEXTPROFILESECURE" value="1" <?php echo @$_EXTENDED_PROFILESECURE_CHECKED; ?> > 
							<span class="highRiskOption"><?php echo _PROFILE_EXTENDED_SECURE; ?></span>
								<br />
									<span class="profileNotes" style="padding-left:25px;"><?php echo _PROFILE_EXTENDED_SECURE_INFO; ?></span>

						<br /><br />

							<!--// Include a COMPONENTS Audit //-->
							<?php if ( @$_POST['doCOMPONENTS'] == 1 ) { $_COMPONENTS_CHECKED = "checked"; }?>
							<input type="checkbox" name="doCOMPONENTS" value="1" <?php echo @$_COMPONENTS_CHECKED; ?> > 
								<span class="lowRiskOption"><?php echo _PROFILE_INCLUDE_COMPONENT_CHOICE; ?>?</span>
									<br />
										<span class="profileNotes" style="padding-left:5px;"><?php echo _PROFILE_INCLUDE_COMPONENT_INFO; ?></span>
				
							<br />

								<!--// Include a Modules Audit //-->
								<?php if ( @$_POST['doMODULES'] == 1 ) { $_MODULES_CHECKED = "checked"; }?>
								<input type="checkbox" name="doMODULES" value="1" <?php echo @$_MODULES_CHECKED; ?> >
									<span class="lowRiskOption"><?php echo _PROFILE_INCLUDE_MODULE_CHOICE ?>?</span>
										<br />
											<span class="profileNotes" style="padding-left:5px;"><?php echo _PROFILE_INCLUDE_MODULE_INFO; ?></span>
				
								<br />

									<!--// Include a PLUGINS Audit //-->
									<?php if ( @$_POST['doPLUGINS'] == 1 ) { $_PLUGINS_CHECKED = "checked"; }?>
									<input type="checkbox" name="doPLUGINS" value="1" <?php echo @$_PLUGINS_CHECKED; ?> >
										<span class="lowRiskOption"><?php echo _PROFILE_INCLUDE_PLUGIN_CHOICE ?>?</span>
											<br />
												<span class="profileNotes" style="padding-left:5px;"><?php echo _PROFILE_INCLUDE_PLUGIN_INFO; ?></span>
				
			<p>

				<br />

					<!--// Press this to Generate the diagnostic output //-->					
					<input type="hidden" name="doGENERATE" value="1">
					
					<input type="submit" style="border:1px solid #246024;background-color:#9DFF00;cursor:pointer;cursor:hand;" name="submit" value=" - <?php echo _PROFILE_RUN; ?> - ">
					
					<input type="reset" style="border:1px solid #FF9900;cursor:pointer;cursor:hand;" name="reset" value=" - <?php echo _PROFILE_RESET; ?> - ">
							
				</p>

			<!--// Remind 'em how to do things //-->
			<p class="lowRiskOption"><?php echo _PROFILE_RUN_MSG; ?></p>

			<!--// If Audits Timeout or Run out of Memory try increasing them //-->
			<?php if ( @$_POST['executionError'] == 1 ) { $_EXECERROR_CHECKED = "checked"; }?>
			<input type="checkbox" name="executionError" value="1" <?php echo @$_EXECERROR_CHECKED; ?> >
				<span class="lowRiskOption"><?php echo _PROFILE_EXECERROR ?>?</span>
					<br />
						<span class="profileNotes" style="padding-left:5px;"><?php echo _PROFILE_EXECERROR_INFO; ?></span>

		</div>

	<p style="clear:left;" />&nbsp;</p>
		<!--// Problem Description Column //-->
		<div class="tColumn-l" style="">
<!--//		<div class="tColumn-l" style="border:none; background-color:transparent;"> //-->

			<p>

				<!--// Give 'em the option to enter a problem description //-->
				<span class="problemNotes"><?php echo _PROB_DESC; ?>:</span>
					<br />
						<input class="problemNotes problemInput" type="text" name="probDesc" size="50">

				<br />
					
					<!--// Give 'em the option to enter an error/log message //-->
					<span class="problemNotes"><?php echo _LOG_MSG;?> (1):</span>
						<br />
							<input class="problemNotes problemInput" type="text" name="logOne" size="50">

					<br />

						<!--// Give 'em the option to enter an additional error/log message //-->
						<span class="problemNotes"><?php echo _LOG_MSG;?> (2):</span>
							<br />
								<input class="problemNotes problemInput" type="text" name="logTwo" size="50">

						<br />

							<!--// Give 'em the option to enter what they have tried already //-->
							<span class="problemNotes"><?php echo _ACTION;?>:</span>
								<br />
									<textarea class="problemNotes problemInput" name="actionsTaken" rows="3" cols="50"></textarea>
			
			</p>
			
										
					<span class="profileNotes"><?php echo _POST_NOTE; ?></span><br />
			

		</div>


		<!--// Show the required profile output //-->
		<div style="clear:both;width:100%;text-align:center;" style="">

			<?php if(@$_POST['doGENERATE'] == '1') { // ONLY show if "Generate Post" Selected ?>
				<br />


				<textarea name="profileOutput" id="profileOutput" style="background-color: #DEF5C8;border: 1px solid #808080;font-size:10px;" cols="110" rows="6" onClick="select_all();">[size=90]<?php if ($_POST['probDesc'] !='') { echo "[quote=\"JTS-post ". _PROB_DESC ."\"]". $_POST['probDesc'] ."[/quote]"; } if ($_POST['logOne'] !='') { echo "[quote=\"JTS-post ". _LOG_MSG ."\"]". $_POST['logOne'] ."[/quote]"; } if ($_POST['logTwo'] !='') { echo "[quote=\"JTS-post ". _LOG_MSG ."\"]". $_POST['logTwo'] ."[/quote]"; } if ($_POST['actionsTaken'] !='') { echo "[quote=\"JTS-post ". _ACTION ."\"]";  echo $_POST['actionsTaken'] .'[/quote]'; } echo "\n"; ?>[/size][quote="JTS-post <?php echo _DIAG_INFO; ?>"][size=85]<?php echo "[b]". _JOOMLA ." ". _VERSION .":[/b] [color=blue]". $version ."[/color]\n"; echo "[b]". _CFG_FILE .":[/b] ". $cfgWrite ." (". _MODE .": ". $cfgPerm ." ) | "; if ($isJVER == "10") { echo "[b]". _RG_EMULATION .":[/b] ". $rgEmulation ."\n"; } echo "[b]". _ARCHITECTURE ."/". _PLATFORM .": [/b]". @php_uname(s) ." ". @php_uname(r) ." ( ". @php_uname(m) .") | "; echo "[b]". _WEB ." ". _SERVER .":[/b] ". $_SERVER['SERVER_SOFTWARE']; ?> <?php if ( $_POST['doEXTPROFILESECURE'] == 1 ) { echo "( ". $_SERVER['HTTP_HOST'] ." )"; } echo " | "; echo "[b]". _PHP ." ". _VERSION .":[/b] ". phpversion() ."\n"; echo "[b]". _PHP ." ". _REQ .":[/b] register_globals: "; if (ini_get('register_globals')) { echo "[color=red]". _ENABLED ."[/color] | "; } else { echo _DISABLED ." | "; } echo "magic_quotes_gpc: "; if (!ini_get('magic_quotes_gpc')) { echo "[color=red]". _DISABLED ."[/color] | "; } else { echo _ENABLED ." | "; } echo "safe_mode: "; if (ini_get('safe_mode')) { echo "[color=red]". _ENABLED ."[/color] | "; } else { echo _DISABLED ." | "; } echo _MYSQL ." ". _SUPPORT .": "; echo extension_loaded('mysql')?''. _YES .' | ':'[color=red]'. _NO .'[/color] | '; echo "XML ". _SUPPORT .": "; echo extension_loaded('xml')?''._YES .' | ':'[color=red]'. _NO .'[/color] | '; echo "zlib ". _SUPPORT .": "; echo extension_loaded('zlib')?''. _YES .'':'[color=red]'. _NO .'[/color]'; echo "\nmbstring ". _SUPPORT ." (1.5 or above): "; echo extension_loaded('mbstring')?''. _YES .' | ':'[color=red]'. _NO .'[/color] | '; echo "iconv ". _SUPPORT ." (1.5 or above): "; echo function_exists('iconv')?''. _YES .' | ':'[color=red]'. _NO .'[/color] | '; if (!is_writable(ini_get('session.save_path'))) { echo "save.session_path: [color=red]". _NOT_WRITABLE ."[/color] | "; } else { echo "save.session_path: ". _WRITABLE ." | "; }?> <?php if ($_POST['executionError'] =="1") { echo "Max. Execution Time: ".ini_get('max_execution_time')." "._SECONDS." (". $execTimeMSG ." ) | "; } else { echo "Max.Execution Time: ". ini_get('max_execution_time');?><?php echo " ". _SECONDS ." | "; } echo "File Uploads:  "; if (ini_get('file_uploads') == "1") { echo _ENABLED ."\n"; } else { echo _DISABLED ."\n"; } echo "[b]". _MYSQL ." ". _VERSION .":[/b] "; echo @mysql_get_server_info(); echo " ( ". @mysql_get_host_info() ." )"; ?>[/size][/quote]
<?php if ( $_POST['doEXTPROFILE'] == '1' ) { echo "[quote=\"JTS-post ". _EXT_INFO ."\"][size=85]"; echo "[b]SEF: [/b]". $sefstate ."". $rewritestate ." | "; echo "[b]Legacy Mode:[/b] ". $legacymode ." | "; echo "[b]FTP Layer:[/b] ". $ftpLayer ." | "; echo "[b]htaccess:[/b] ". $htaccess ."\n"; echo "[b]PHP/suExec: [/b]". $accountMatch ."\n"; echo "[b]". _PHP ." ". _ENVIRONMENT .": [/b] API: ". php_sapi_name() ." | "; echo "". _MYSQL ."i: "; echo extension_loaded('mysqli')?''. _YES .' | ':''. _NO .' | '; ?><?php if ($_POST['executionError'] =="1") { echo "Max. Memory: ". ini_get('memory_limit') ." ("; echo $execMemMSG ." ) | "; } else { echo "Max. Memory: ". ini_get('memory_limit') ." | "; }?><?php echo "Max. Upload Size: ". ini_get('upload_max_filesize') ." | "; echo "Max. Post Size: ". ini_get('post_max_size') ." | "; echo "Max. Input Time: ". ini_get('max_input_time') ." | "; echo "Zend ". _VERSION .": ". zend_version() ."\n"; echo _DISABLED ." ". _FUNCTIONS .": ". ini_get('disable_functions') ."\n"; echo "[b]". _MYSQL ." ". _CLIENT .": [/b]". @mysql_get_client_info() ." ( ". $charset ." )[/size][/quote]"; }  ?>
				</textarea>



			<?php } // END show only if "Generate Post" selected ?>

<!--//				</form>  //-->

			</div>


		<div style="clear:both;width:100%;text-align:center;" style="">&nbsp;</div>

			<div class="bColumn-l" style="">
			

	<table border="0" cellpadding="0" cellspacing="2" align="center" width="100%">

		<tr>
			<td class='tdHeadings' colspan="2"><?php echo _JOOMLA ." ". _ENV_DISCOVERY; ?></td>
		</tr>

		<tr><td class="spacer" colspan="3"></td></tr>

		<tr>
			<td width="35%" valign="middle"><strong><?php echo _JOOMLA ." ". _VERSION; ?></strong></td>
			<td width="65%" valign="middle"><strong><?php echo $version; ?></strong></td>
		</tr>

		<tr>
			<td valign="middle"><strong><?php echo _CFG_FILE; ?></strong></td>
			<td valign="middle">
			<?php
				if (is_writable('./configuration.php')) { 
					echo "<font color='red'>". _WRITABLE ."</font>"; $cfgWrite = "[color=red]". _WRITABLE ."[/color]"; $cfgPerm = substr(sprintf('%o', @fileperms('./configuration.php')),-3, 3); 
					} else { 
						echo "". _NOT_WRITABLE .""; $cfgWrite = "". _NOT_WRITABLE .""; 
//						$cfgPerm = substr(sprintf('%o', @fileperms('./configuration.php')),-3, 3);
						}

				echo " ( ". _MODE .": ". substr(sprintf('%o', @fileperms('./configuration.php')),-3, 3) ." ) ";
			?>
			</td>
		</tr>


		<?php if ($isJVER == "10") { ?>

		<tr>
			<td valign="middle"><strong><?php echo _RG_EMULATION; ?></strong></td>
			<td valign="middle">
			<?php
				if ( RG_EMULATION == "1" ) { 
					echo "<font color='red'>". _ENABLED ."</font>"; $rgEmulation = "[color=red]". _ENABLED ."[/color]"; 
					} else { 
						echo "". _DISABLED .""; $rgEmulation = "". _DISABLED .""; 
						}		
			?>
			</td>
		</tr>

		<?php } else { ?> 

		<tr>
			<td valign="middle"><strong><?php echo _RG_EMULATION; ?></strong></td>
			<td valign="middle">N/A <?php $rgEmulation = "". _NA .""; ?></td>
		</tr>		

		<?php } ?>


		<tr><td class="spacer" colspan="3"></td></tr>

		<tr>
			<td class='tdSHeadings' colspan="2"><?php echo _HOST ." ". _ENV_DISCOVERY; ?></td>
		</tr>

		<tr><td class="spacer" colspan="3"></td></tr>

		<tr>
			<td valign="middle"><strong><?php echo _ARCHITECTURE; ?></strong></td>
			<td valign="middle"><?php echo @php_uname(m) ." ( ". (substr(PHP_OS, 0, 10)) ." )"; ?></td>
		</tr>

		<tr>
			<td valign="top"><strong><?php echo _PLATFORM; ?></strong></td>
			<td valign="top"><?php echo @php_uname(s); ?> <?php echo @php_uname(r); ?><br /> <?php echo @php_uname(v); ?></td>
		</tr>

		<tr><td class="spacer" colspan="3"></td></tr>

		<tr>
			<td class='tdSHeadings' colspan="2"><?php echo _WEB ." ". _ENV_DISCOVERY; ?></td>
		</tr>

		<tr><td class="spacer" colspan="3"></td></tr>

        <tr>
			<td><b><?php echo _WEB ." ". _SERVER ." ". _VERSION; ?></b></td>
			<td><?php echo $_SERVER['SERVER_SOFTWARE']; ?></td>
		</tr>
        
        <tr>
			<td><?php echo _WEB ." ". _HOST; ?></td>
			<td><?php echo $_SERVER['HTTP_HOST']; ?></td>
		</tr>

		<tr><td class="spacer" colspan="3"></td></tr>
		
		<tr>
			<td class='tdSHeadings' colspan="2"><?php echo _PHP ." ". _ENV_DISCOVERY; ?></td>
		</tr>
		
		<tr><td class="spacer" colspan="3"></td></tr>
        
        <tr>
			<td><b><?php echo _PHP ." ". _VERSION; ?></b></td>
			<td><?php echo phpversion(); ?></td>
		</tr>
        
        <tr>
			<td>register_globals</td>
			<td>
			<?php 
				if (ini_get('register_globals')) { 
					echo "<font color='red'>". _ENABLED ."</font>"; 
					} else { 
						echo "". _DISABLED .""; 
						} 
			?>
			</td>
		</tr>

        <tr>
			<td>magic_quotes_gpc</td>
			<td>
			<?php 
				if (!ini_get('magic_quotes_gpc')) { 
					echo "<font color='red'>". _DISABLED ."</font>"; 
					} else { 
					echo "". _ENABLED .""; 
						} 
			?>
			</td>
		</tr>
						
        <tr>
			<td>safe_mode</td>
			<td>
			<?php 
				if (ini_get('safe_mode')) { 
					echo "<font color='red'>". _ENABLED ."</font>"; 
					} else { 
						echo "". _DISABLED .""; 
						} 
			?>
			</td>
		</tr>

		<tr>
			<td><?php echo _MYSQL; ?></td>
			<td>
				<?php echo extension_loaded('mysql')?''. _YES.'':'<span style="color: red;">'. _NO .'</font>'; ?>
			</td>
		</tr>

        <tr>
			<td>xml</td>
			<td>
				<?php echo extension_loaded('xml')?''. _YES .'':'<span style="color: red;">'. _NO .'</font>'; ?></td>
		</tr>

        <tr>
			<td>zlib</td>
			<td>
				<?php echo extension_loaded('zlib')?''. _YES .'':'<span style="color: red;">'. _NO .'</font>'; ?>
			</td>
		</tr>
	
		<tr>
			<td>mbstring</td>
			<td>
				<?php echo extension_loaded('mbstring')?''. _YES .'':'<span style="color: red;">'. _NO .'</font>'; ?>
			</td>
		</tr>

		<tr>
			<td>iconv</td>
			<td>
				<?php echo function_exists('iconv')?''. _YES .'':'<span style="color: red;">'. _NO .'</font>'; ?>
			</td>
		</tr>

        <tr>
			<td valign="top">save.session_path</td>
			<td>
			<?php 
				echo ini_get('session.save_path') ."<br />";
					if (!is_writable(ini_get('session.save_path'))) { 
						echo "<font color='red'>". _NOT_WRITABLE ."</font>"; 
						} else { 
							echo "". _WRITABLE .""; 
							} 
			?>
			</td>
		</tr>

        <tr>
			<td>Max. Execution Time</td>
			<td>
			
			<?php echo ini_get('max_execution_time'); ?> <?php echo _SECONDS; ?>
			<?php if (@$_POST['executionError'] == "1") { echo "<span class='profileNotes'>". $execTimeMSG ."</span>"; } ?>
			</td>
		</tr>

        <tr>
			<td>File Upload</td>
			<td>
			<?php if (ini_get('file_uploads') == "1") { 
				echo "Enabled"; 
				} else { 
					echo "Disabled"; 
					} 
			?>
			</td>
		</tr>

		<tr><td class="spacer" colspan="3"></td></tr>
		
		<tr>
			<td class='tdSHeadings' colspan="2"><?php echo _MYSQL ." ". _ENV_DISCOVERY; ?></td>
		</tr>

		<tr><td class="spacer" colspan="3"></td></tr>
        
        <tr>
			<td><b><?php echo _MYSQL ." ". _SERVER ." ". _VERSION; ?></b></td>
			<td><?php echo @mysql_get_server_info(); ?></td>
		</tr>

		<tr>
			<td><?php echo _HOST ." ". _INFO; ?></td>
			<td><?php echo @mysql_get_host_info(); ?></td>
		</tr>
		</table>
		<!--// END BASIC DISCOVERY //-->
			
			
			</div>

			<div class="bColumn-r" style="">
			

	<table border="0" cellpadding="0" cellspacing="2" align="center" width="100%">

		<tr>
			<td class='tdHeadings' style="" colspan="2"><strong><?php echo _JOOMLA ." ". _ENV_DISCOVERY; ?></strong></td>
		</tr>

		<tr><td class="spacer" colspan="3"></td></tr>

		<tr>
			<td width="35%" valign="middle"><strong>SEF</strong></td>
			<td width="65%" valign="middle">
			<?php
				if ($isJVER == "15") {
					if ($jts_sef == "0") { 
						echo "". _DISABLED.""; $sefstate = "". _DISABLED.""; 
						} else { 
							echo "". _ENABLED."";  $sefstate = "". _ENABLED."";
							}
					
					if ($jts_sef_rewrite == "0") { 
						echo " (". _WO_REWRITE .")"; $rewritestate = " (". _WO_REWRITE .") "; 
						} else { 
							echo " (". _W_REWRITE .")"; $rewritestate = " (". _W_REWRITE .") "; 
							}
					
				} else {

					if (@$mosConfig_sef == "0") { 
						echo "". _DISABLED .""; $sefstate = "". _DISABLED .""; $rewritestate = ''; 
						} else { 
							echo "". _ENABLED .""; $sefstate = "". _ENABLED .""; $rewritestate = ''; 
							}
				
				}
			?>			
			</td>
		</tr>


		<?php if (($isJVER == "15") || ($isJVER == "16")) { ?>

		<tr>
			<td valign="middle"><strong>Legacy Mode</strong></td>
			<td valign="middle">
			<?php
				if (@$jts_legacy == "1") { 
					echo "". _ENABLED .""; $legacymode = "". _ENABLED .""; 
					} else { 
						echo "". _DISABLED .""; $legacymode = "". _DISABLED .""; 
						}
			?>
			</td>
		</tr>

		<tr>
			<td valign="middle"><strong>FTP Layer</strong></td>
			<td valign="middle">
			<?php
				if ($jts_ftp == "1") { 
					echo "". _ENABLED .""; $ftpLayer = "". _ENABLED .""; 
					} else { 
						echo "". _DISABLED .""; $ftpLayer = "". _DISABLED .""; 
						}
			?>
			</td>
		</tr>

		<?php } else { ?>

		<tr>
			<td valign="middle"><strong>Legacy Mode</strong></td>
			<td valign="middle">
			<?php echo _NA; $legacymode = "". _NA .""; ?>
			</td>
		</tr>

		<tr>
			<td valign="middle"><strong>FTP Layer</strong></td>
			<td valign="middle">
			<?php echo _NA; $ftpLayer = "". _NA .""; ?>
			</td>
		</tr>

		<?php } ?>

		<tr>
			<td valign="middle"><strong>htaccess</strong></td>
			<td valign="middle">
			<?php
				if (!file_exists('.htaccess')) { 
					echo "". _NOT_IMPLEMENTED .""; $htaccess = "". _NOT_IMPLEMENTED .""; 
					} else { 
						echo "". _IMPLEMENTED .""; $htaccess = "". _IMPLEMENTED .""; 
						}		
			?>			
			</td>
		</tr>

		<tr>
			<td class='tdSHeadings' colspan="2"><?php echo _WEB ." ". _ENV_DISCOVERY; ?></td>
		</tr>

		<tr><td class="spacer" colspan="3"></td></tr>

		<tr>
			<td><?php echo _CURRENT_PATH; ?></td>
			<td><?php echo getcwd (); ?></td>
		</tr>

        <tr>
			<td><?php echo _DOC_ROOT; ?></td>
			<td><?php echo $_SERVER['DOCUMENT_ROOT']; ?></td>
		</tr>

        <tr>
			<td valign="top"><?php echo _SERVER ." ". _ACCOUNT; ?><br /><?php echo _USER ." ". _ACCOUNT; ?></td>
			<td>
			<?php
/*
				if (function_exists( 'exec' )) {
        			$ApacheAcc = exec("whoami");
					} else if (function_exists( 'passthru' )) {         				 		
						$ApacheAcc = passthru("whoami");
						}

				$UserAcc = get_current_user ();
*/							
				echo $ApacheAcc ."<br />". $UserAcc;
/*				
				if ($UserAcc == $ApacheAcc) { 
					$accountMatch = "". _ACC_MATCH .""; 
					} else { 
						$accountMatch = "". _ACC_MATCH_NO .""; 
						}
*/
					echo "<br /><span class='profileNotes'>". $accountMatch ."</span>";
			?>							
			</td>
		</tr>

		<tr><td class="spacer" colspan="3"></td></tr>
		
		<tr>
			<td class='tdSHeadings' colspan="2"><?php echo _PHP ." ". _ENV_DISCOVERY; ?></td>
		</tr>

		<tr>
			<td><?php echo _PHP; ?> API</td>
			<td><?php echo php_sapi_name(); ?></td>
		</tr>

        <tr>
			<td>MySQLi</td>
			<td><?php echo extension_loaded('mysqli')?''. _YES .'':'<span style="color: red;">'. _NO .'</font>'; ?></td>
		</tr>

		<tr>
			<td>Max. Memory Limit</td>
			<td>
			<?php echo ini_get('memory_limit'); ?>
						<?php if (@$_POST['executionError'] == "1") { echo "<span class='profileNotes'>". $execMemMSG ."</span>"; } ?>
			</td>
		</tr>

		<tr>
			<td>Max. Upload File Size</td>
			<td><?php echo ini_get('upload_max_filesize'); ?></td>
		</tr>

        <tr>
			<td>Max. Post Size</td>
			<td><?php echo ini_get('post_max_size'); ?></td>
		</tr>

        <tr>
			<td>Max. Input Time</td>
			<td><?php echo ini_get('max_input_time'); _SECONDS; ?></td>
		</tr>

        <tr>
			<td>Zend <?php echo _VERSION; ?></td>
			<td><?php echo zend_version(); ?></td>
		</tr>

        <tr>
			<td><?php echo _DISABLED ." ". _FUNCTIONS; ?></td>
			<td>
			<?php
            	if (ini_get('disable_functions')) { 
            		echo (ini_get('disable_functions')); 
            		} else if (!ini_get('disable_functions')) { 
            			echo "<i>". _NO ." ". _DISABLED ." ". _FUNCTIONS ."</i>"; 
            			}
			?>
			</td>
		</tr>
		
		<tr><td class="spacer" colspan="3"></td></tr>
		
		<tr>
			<td class='tdSHeadings' colspan="2"><?php echo _MYSQL ." ". _ENV_DISCOVERY; ?></td>
		</tr>
		
		<tr><td class="spacer" colspan="3"></td></tr>
        
        <tr>
			<td><?php echo _CLIENT ." ". _VERSION; ?></td>
			<td><?php echo @mysql_get_client_info(); ?></td>
		</tr>

        <tr>
			<td><?php echo _CHARSET; ?></td>
			<td>
			<?php
					echo $charset;
			?>
			</td>
		</tr>
		</table>		

			
			
			</div>


		<div style="clear:both;width:100%;text-align:center;" style=""><br />&nbsp;<br /></div>
</form>


			<?php if (@$_POST['doCOMPONENTS'] == "1" ) { ?>

			<div class="tColumn-l" style="width:99%;">


<br />
<div align="center">

<?php

//define the path as relative
$dir = "administrator/components/";

//using the opendir function
$dir_handle = @opendir($dir);// or die("Unable to open $dir");


  echo "<table border=\"0\" cellspacing=\"3\" cellpadding=\"0\" width=\"90%\" align='center'>";
  echo "<tr><th class=\"tdHeadings\" colspan=\"5\">Administrator Components</th></tr>";
  echo "<tr><td class=\"tdSHeadings\"> &nbsp;<b>Component Name</b></td>";
  echo "<td class=\"tdSHeadings\"> &nbsp;<b>Version</b></td>";
  echo "<td class=\"tdSHeadings\"> &nbsp;<b>Author</b></td>";
  echo "<td class=\"tdSHeadings\"> &nbsp;<b>Author Site<b/></td>";
  echo "<td class=\"tdSHeadings\"> &nbsp;<b>Type<b/></td></tr>";
  echo "<tr><td colspan=\"5\" style=\"height: 10px;\"></td></tr>";


while ($file = readdir($dir_handle)) {

  if($file!="." && $file!=".." && $file!="index.html") {
    $newDir = $dir.''.$file;
    $dir1 = opendir($newDir);

     while ($f = readdir($dir1)) {

      //if (eregi("\.xml",$f)){ #if filename matches .xml in the name
			if (preg_match("/\.xml/i",$f)){ #if filename matches .xml in the name

        $content = file_get_contents($newDir.'/'.$f);

        if (preg_match('#install(.*)#', $content, $isInstallFile)) {

      echo "<tr><td class=\"vflist\" width=\"25%\" style=\"border-left: 1px solid #C0C0C0; border-top: 1px solid #C0C0C0; border-bottom: 1px solid #C0C0C0;\">&nbsp;";
        if (preg_match('#<name>(.*)</name>#', $content, $name)) {

          if (preg_match('#<author>(.*)</author>#', $content, $author)) {

            if ($author[1] == "Joomla! Project") {
              echo "<font color=\"green\">". $name[1] ."</font>";
            } else {
              echo "<font color=\"blue\">". $name[1] ."</font>";
            }

          }
        }
      echo "</td>";

      echo "<td class=\"vflist\" width=\"12%\" style=\"color: navy; border-top: 1px solid #C0C0C0; border-bottom: 1px solid #C0C0C0;\">&nbsp;v";
        if (preg_match('#<version>(.*)</version>#', $content, $version)) {
		  echo $version[1];
		}
	  echo "</td>";

      echo "<td class=\"vflist\" width=\"26%\" style=\"border-left: 1px solid #C0C0C0; border-top: 1px solid #C0C0C0; border-bottom: 1px solid #C0C0C0;\">&nbsp;";
        if (preg_match('#<author>(.*)</author>#', $content, $author)) {
          echo $author[1];
        }
      echo "</td>";
	  
      echo "<td class=\"vflist\" width=\"27%\" style=\" border-top: 1px solid #C0C0C0; border-bottom: 1px solid #C0C0C0;\">&nbsp;";
        if (preg_match('#<authorUrl>(.*)</authorUrl>#', $content, $authorUrl)) {
//          echo "<a href=\"http://". $authorUrl[1] ."\" target=\"_new\">". $authorUrl[1] ."</a>";
			str_replace(array('http://','https://'), '', $authorUrl[1]);

			$aURL = str_replace(array('http://','https://'), '', $authorUrl[1]);
			
          echo "<a href=\"http://". $aURL ."\" target=\"_new\">". $aURL ."</a>";

        }
      echo "</td>";

      echo "<td class=\"vflist\" width=\"10%\" style=\"border-top: 1px solid #C0C0C0; border-right: 1px solid #C0C0C0; border-bottom: 1px solid #C0C0C0;\">&nbsp;";
      if (preg_match('#<author>(.*)</author>#', $content, $author)) {

        if ($author[1] == "Joomla! Project") {
          echo "<font color=\"green\">Core</font>";
        } else {
          echo "<font color=\"blue\">3rd Party</font>";
        }
      }
    echo "</td></tr>";

    echo "<tr><td colspan=\"5\" class=\"ext_desc\" style=\"background-color: #F1F1F1; border-bottom: 1px solid #C0C0C0; border-right: 1px solid #C0C0C0; border-left: 1px solid #C0C0C0;\">&nbsp;";
      if (preg_match('#<description>(.*)</description>#', $content, $description)) {
		echo strip_tags(substr($description[1], 0, 200));
		echo "...";
      }
    echo "</td></tr>";
    echo "<tr><td colspan=\"5\" style=\"height: 10px;\">&nbsp;</td></tr>";

      }
    }
  }
}
}
  echo "</table>";
  echo "<div class=\"profileNotes\">Done Processing Administrator Components</div>";
  //closing the directory
  closedir($dir_handle);
?>

  <br /><br />


<?php

//define the path as relative
$dir = "components/";

//using the opendir function
$dir_handle = @opendir($dir); // or die("Unable to open $dir");

  echo "<table border=\"0\" cellspacing=\"3\" cellpadding=\"0\" width=\"90%\" align='center'>";
  echo "<tr><th class=\"tdHeadings\" colspan=\"5\">Site Components</th></tr>";
  echo "<tr><td class=\"tdSHeadings\"> &nbsp;<b>Component Name</b></td>";
  echo "<td class=\"tdSHeadings\"> &nbsp;<b>Version</b></td>";
  echo "<td class=\"tdSHeadings\"> &nbsp;<b>Author</b></td>";
  echo "<td class=\"tdSHeadings\"> &nbsp;<b>Author Site<b/></td>";
  echo "<td class=\"tdSHeadings\"> &nbsp;<b>Type<b/></td></tr>";
  echo "<tr><td colspan=\"5\" style=\"height: 10px;\"></td></tr>";


while ($file = readdir($dir_handle)) {

  if($file!="." && $file!=".." && $file!="index.html") {
    $newDir = $dir.''.$file;
    $dir1 = opendir($newDir);

     while ($f = readdir($dir1)) {

//      if (eregi("\.xml",$f)){ #if filename matches .xml in the name
			if (preg_match("/\.xml/i",$f)){ #if filename matches .xml in the name

        $content = file_get_contents($newDir.'/'.$f);

        if (preg_match('#install(.*)#', $content, $isInstallFile)) {

      echo "<tr><td class=\"vflist\" width=\"25%\" style=\"border-left: 1px solid #C0C0C0; border-top: 1px solid #C0C0C0; border-bottom: 1px solid #C0C0C0;\">&nbsp;";
        if (preg_match('#<name>(.*)</name>#', $content, $name)) {

          if (preg_match('#<author>(.*)</author>#', $content, $author)) {

            if ($author[1] == "Joomla! Project") {
              echo "<font color=\"green\">". $name[1] ."</font>";
            } else {
              echo "<font color=\"blue\">". $name[1] ."</font>";
            }

          }
        }
      echo "</td>";

      echo "<td class=\"vflist\" width=\"12%\" style=\"color: navy; border-top: 1px solid #C0C0C0; border-bottom: 1px solid #C0C0C0;\">&nbsp;v";
        if (preg_match('#<version>(.*)</version>#', $content, $version)) {
		  echo $version[1];
		}
	  echo "</td>";

      echo "<td class=\"vflist\" width=\"26%\" style=\"border-left: 1px solid #C0C0C0; border-top: 1px solid #C0C0C0; border-bottom: 1px solid #C0C0C0;\">&nbsp;";
        if (preg_match('#<author>(.*)</author>#', $content, $author)) {
          echo $author[1];
        }
      echo "</td>";
	  
      echo "<td class=\"vflist\" width=\"27%\" style=\" border-top: 1px solid #C0C0C0; border-bottom: 1px solid #C0C0C0;\">&nbsp;";
        if (preg_match('#<authorUrl>(.*)</authorUrl>#', $content, $authorUrl)) {
//          echo "<a href=\"http://". $authorUrl[1] ."\" target=\"_new\">". $authorUrl[1] ."</a>";
			str_replace(array('http://','https://'), '', $authorUrl[1]);

			$aURL = str_replace(array('http://','https://'), '', $authorUrl[1]);
			
          echo "<a href=\"http://". $aURL ."\" target=\"_new\">". $aURL ."</a>";
        }
      echo "</td>";

      echo "<td class=\"vflist\" width=\"10%\" style=\"border-top: 1px solid #C0C0C0; border-right: 1px solid #C0C0C0; border-bottom: 1px solid #C0C0C0;\">&nbsp;";
      if (preg_match('#<author>(.*)</author>#', $content, $author)) {

        if ($author[1] == "Joomla! Project") {
          echo "<font color=\"green\">Core</font>";
        } else {
          echo "<font color=\"blue\">3rd Party</font>";
        }
      }
    echo "</td></tr>";

    echo "<tr><td colspan=\"5\" class=\"ext_desc\" style=\"background-color: #F1F1F1; border-bottom: 1px solid #C0C0C0; border-right: 1px solid #C0C0C0; border-left: 1px solid #C0C0C0;\">&nbsp;";
      if (preg_match('#<description>(.*)</description>#', $content, $description)) {
		echo strip_tags(substr($description[1], 0, 200));
		echo "...";
      }
    echo "</td></tr>";
    echo "<tr><td colspan=\"5\" style=\"height: 10px;\">&nbsp;</td></tr>";

      }
    }
  }
}
}
  echo "</table>";
  echo "<div class=\"profileNotes\">Done Processing Site Components</div>";
  //closing the directory
  closedir($dir_handle);
?>  
</div>
<br /><br />


				
			</div>

		<?php } ?>



		<?php if (@$_POST['doMODULES'] == "1" ) { ?>			

		<div style="clear:both;width:100%;text-align:center;" style="">&nbsp;</div>

			<div class="tColumn-l" style="width:99%;">
<br />
<div align="center">


<?php
//$isJVER = "15";
//echo $isJVER;
if (($isJVER == "15") || ($isJVER == "16")) {


//define the path as relative
$dir = "administrator/modules/";

	//using the opendir function
	$dir_handle = @opendir($dir); // or die("Unable to open $dir");


  echo "<table border=\"0\" cellspacing=\"3\" cellpadding=\"0\" width=\"90%\" align='center'>";
  echo "<tr><th class=\"tdHeadings\" colspan=\"5\">Administrator Modules</th></tr>";
  echo "<tr><td class=\"tdSHeadings\"> &nbsp;<b>Module Name</b></td>";
  echo "<td class=\"tdSHeadings\"> &nbsp;<b>Version</b></td>";
  echo "<td class=\"tdSHeadings\"> &nbsp;<b>Author</b></td>";
  echo "<td class=\"tdSHeadings\"> &nbsp;<b>Author Site<b/></td>";
  echo "<td class=\"tdSHeadings\"> &nbsp;<b>Type<b/></td></tr>";
  echo "<tr><td colspan=\"5\" style=\"height: 10px;\"></td></tr>";

	while ($file = readdir($dir_handle)) {

  if($file!="." && $file!=".." && $file!="index.html") {

    $newDir = $dir.''.$file;
    $dir1 = opendir($newDir);

     while ($f = readdir($dir1)) {


//      if (eregi("\.xml",$f)){ #if filename matches .xml in the name
			if (preg_match("/\.xml/i",$f)){ #if filename matches .xml in the name

        $content = file_get_contents($newDir.'/'.$f);

        if (preg_match('#install(.*)#', $content, $isInstallFile)) {

      echo "<tr><td class=\"vflist\" width=\"25%\" style=\"border-left: 1px solid #C0C0C0; border-top: 1px solid #C0C0C0; border-bottom: 1px solid #C0C0C0;\">&nbsp;";
        if (preg_match('#<name>(.*)</name>#', $content, $name)) {

          if (preg_match('#<author>(.*)</author>#', $content, $author)) {

            if ($author[1] == "Joomla! Project") {
              echo "<font color=\"green\">". $name[1] ."</font>";
            } else {
              echo "<font color=\"blue\">". $name[1] ."</font>";
            }

          }
        }
      echo "</td>";

      echo "<td class=\"vflist\" width=\"12%\" style=\"color: navy; border-top: 1px solid #C0C0C0; border-bottom: 1px solid #C0C0C0;\">&nbsp;v";
        if (preg_match('#<version>(.*)</version>#', $content, $version)) {
		  echo $version[1];
		}
	  echo "</td>";

      echo "<td class=\"vflist\" width=\"26%\" style=\"border-left: 1px solid #C0C0C0; border-top: 1px solid #C0C0C0; border-bottom: 1px solid #C0C0C0;\">&nbsp;";
        if (preg_match('#<author>(.*)</author>#', $content, $author)) {
          echo $author[1];
        }
      echo "</td>";
	  
      echo "<td class=\"vflist\" width=\"27%\" style=\" border-top: 1px solid #C0C0C0; border-bottom: 1px solid #C0C0C0;\">&nbsp;";
        if (preg_match('#<authorUrl>(.*)</authorUrl>#', $content, $authorUrl)) {
//          echo "<a href=\"http://". $authorUrl[1] ."\" target=\"_new\">". $authorUrl[1] ."</a>";
			str_replace(array('http://','https://'), '', $authorUrl[1]);

			$aURL = str_replace(array('http://','https://'), '', $authorUrl[1]);
			
          echo "<a href=\"http://". $aURL ."\" target=\"_new\">". $aURL ."</a>";
        }
      echo "</td>";

      echo "<td class=\"vflist\" width=\"10%\" style=\"border-top: 1px solid #C0C0C0; border-right: 1px solid #C0C0C0; border-bottom: 1px solid #C0C0C0;\">&nbsp;";
      if (preg_match('#<author>(.*)</author>#', $content, $author)) {

        if ($author[1] == "Joomla! Project") {
          echo "<font color=\"green\">Core</font>";
        } else {
          echo "<font color=\"blue\">3rd Party</font>";
        }
      }
    echo "</td></tr>";

    echo "<tr><td colspan=\"5\" class=\"ext_desc\" style=\"background-color: #F1F1F1; border-bottom: 1px solid #C0C0C0; border-right: 1px solid #C0C0C0; border-left: 1px solid #C0C0C0;\">&nbsp;";
      if (preg_match('#<description>(.*)</description>#', $content, $description)) {
//        echo $description[1];
		echo strip_tags(substr($description[1], 0, 200));
		echo "...";
      }
    echo "</td></tr>";
    echo "<tr><td colspan=\"5\" style=\"height: 10px;\">&nbsp;</td></tr>";

      }
    }
  }
}

	}

  echo "</table>";
  echo "<div class=\"profileNotes\">Done Processing Administrator Modules</div>";
  //closing the directory

  closedir($dir_handle);

?>

  <br /><br />


<?php

//define the path as relative
$dir = "modules/";

	//using the opendir function
	$dir_handle = @opendir($dir); // or die("Unable to open $dir");

  echo "<table border=\"0\" cellspacing=\"3\" cellpadding=\"0\" width=\"90%\" align='center'>";
  echo "<tr><th class=\"tdHeadings\" colspan=\"5\">Site Modules</th></tr>";
  echo "<tr><td class=\"tdSHeadings\"> &nbsp;<b>Modules Name</b></td>";
  echo "<td class=\"tdSHeadings\"> &nbsp;<b>Version</b></td>";
  echo "<td class=\"tdSHeadings\"> &nbsp;<b>Author</b></td>";
  echo "<td class=\"tdSHeadings\"> &nbsp;<b>Author Site<b/></td>";
  echo "<td class=\"tdSHeadings\"> &nbsp;<b>Type<b/></td></tr>";
  echo "<tr><td colspan=\"5\" style=\"height: 10px;\"></td></tr>";

	while ($file = readdir($dir_handle)) {


  if($file!="." && $file!=".." && $file!="index.html") {
    $newDir = $dir.''.$file;
    $dir1 = opendir($newDir);

     while ($f = readdir($dir1)) {

//      if (eregi("\.xml",$f)){ #if filename matches .xml in the name
			if (preg_match("/\.xml/i",$f)){ #if filename matches .xml in the name

        $content = file_get_contents($newDir.'/'.$f);

        if (preg_match('#install(.*)#', $content, $isInstallFile)) {

      echo "<tr><td class=\"vflist\" width=\"25%\" style=\"border-left: 1px solid #C0C0C0; border-top: 1px solid #C0C0C0; border-bottom: 1px solid #C0C0C0;\">&nbsp;";
        if (preg_match('#<name>(.*)</name>#', $content, $name)) {

          if (preg_match('#<author>(.*)</author>#', $content, $author)) {

            if ($author[1] == "Joomla! Project") {
              echo "<font color=\"green\">". $name[1] ."</font>";
            } else {
              echo "<font color=\"blue\">". $name[1] ."</font>";
            }

          }
        }
      echo "</td>";

      echo "<td class=\"vflist\" width=\"12%\" style=\"color: navy; border-top: 1px solid #C0C0C0; border-bottom: 1px solid #C0C0C0;\">&nbsp;v";
        if (preg_match('#<version>(.*)</version>#', $content, $version)) {
		  echo $version[1];
		}
	  echo "</td>";

      echo "<td class=\"vflist\" width=\"26%\" style=\"border-left: 1px solid #C0C0C0; border-top: 1px solid #C0C0C0; border-bottom: 1px solid #C0C0C0;\">&nbsp;";
        if (preg_match('#<author>(.*)</author>#', $content, $author)) {
          echo $author[1];
        }
      echo "</td>";
	  
      echo "<td class=\"vflist\" width=\"27%\" style=\" border-top: 1px solid #C0C0C0; border-bottom: 1px solid #C0C0C0;\">&nbsp;";
        if (preg_match('#<authorUrl>(.*)</authorUrl>#', $content, $authorUrl)) {
//          echo "<a href=\"http://". $authorUrl[1] ."\" target=\"_new\">". $authorUrl[1] ."</a>";
			str_replace(array('http://','https://'), '', $authorUrl[1]);

			$aURL = str_replace(array('http://','https://'), '', $authorUrl[1]);
			
          echo "<a href=\"http://". $aURL ."\" target=\"_new\">". $aURL ."</a>";
        }
      echo "</td>";

      echo "<td class=\"vflist\" width=\"10%\" style=\"border-top: 1px solid #C0C0C0; border-right: 1px solid #C0C0C0; border-bottom: 1px solid #C0C0C0;\">&nbsp;";
      if (preg_match('#<author>(.*)</author>#', $content, $author)) {

        if ($author[1] == "Joomla! Project") {
          echo "<font color=\"green\">Core</font>";
        } else {
          echo "<font color=\"blue\">3rd Party</font>";
        }
      }
    echo "</td></tr>";

    echo "<tr><td colspan=\"5\" class=\"ext_desc\" style=\"background-color: #F1F1F1; border-bottom: 1px solid #C0C0C0; border-right: 1px solid #C0C0C0; border-left: 1px solid #C0C0C0;\">&nbsp;";
      if (preg_match('#<description>(.*)</description>#', $content, $description)) {
//        echo $description[1];
		echo strip_tags(substr($description[1], 0, 200));
      }
    echo "</td></tr>";
    echo "<tr><td colspan=\"5\" style=\"height: 10px;\">&nbsp;</td></tr>";

      }
    }
  }
}

	}

  echo "</table>";
  echo "<div class=\"profileNotes\">Done Processing Site Modules</div>";

  //closing the directory
  closedir($dir_handle);

?>  

<?php
} else { // Do isV10
?>



<?php
//define the path as relative
$dir = "administrator/modules/";

	//using the opendir function
///	$dir_handle = @opendir($dir) or die("Unable to open $dir");


  echo "<table border=\"0\" cellspacing=\"3\" cellpadding=\"0\" width=\"90%\" align='center'>";
  echo "<tr><th class=\"tdHeadings\" colspan=\"5\">Administrator Modules</th></tr>";
  echo "<tr><td class=\"tdSHeadings\"> &nbsp;<b>Module Name</b></td>";
  echo "<td class=\"tdSHeadings\"> &nbsp;<b>Version</b></td>";
  echo "<td class=\"tdSHeadings\"> &nbsp;<b>Author</b></td>";
  echo "<td class=\"tdSHeadings\"> &nbsp;<b>Author Site<b/></td>";
  echo "<td class=\"tdSHeadings\"> &nbsp;<b>Type<b/></td></tr>";
  echo "<tr><td colspan=\"5\" style=\"height: 10px;\"></td></tr>";

///	while ($file = readdir($dir_handle)) {

  if($file!="." && $file!=".." && $file!="index.html") {

    $newDir = $dir.''.$file;
    $dir1 = opendir($newDir);

     while ($f = readdir($dir1)) {


//      if (eregi("\.xml",$f)){ #if filename matches .xml in the name
			if (preg_match("/\.xml/i",$f)){ #if filename matches .xml in the name

        $content = file_get_contents($newDir.'/'.$f);

        if (preg_match('#install(.*)#', $content, $isInstallFile)) {

      echo "<tr><td class=\"vflist\" width=\"25%\" style=\"border-left: 1px solid #C0C0C0; border-top: 1px solid #C0C0C0; border-bottom: 1px solid #C0C0C0;\">&nbsp;";
        if (preg_match('#<name>(.*)</name>#', $content, $name)) {

          if (preg_match('#<author>(.*)</author>#', $content, $author)) {

            if ($author[1] == "Joomla! Project") {
              echo "<font color=\"green\">". $name[1] ."</font>";
            } else {
              echo "<font color=\"blue\">". $name[1] ."</font>";
            }

          }
        }
      echo "</td>";

      echo "<td class=\"vflist\" width=\"12%\" style=\"color: navy; border-top: 1px solid #C0C0C0; border-bottom: 1px solid #C0C0C0;\">&nbsp;v";
        if (preg_match('#<version>(.*)</version>#', $content, $version)) {
		  echo $version[1];
		}
	  echo "</td>";

      echo "<td class=\"vflist\" width=\"26%\" style=\"border-left: 1px solid #C0C0C0; border-top: 1px solid #C0C0C0; border-bottom: 1px solid #C0C0C0;\">&nbsp;";
        if (preg_match('#<author>(.*)</author>#', $content, $author)) {
          echo $author[1];
        }
      echo "</td>";
	  
      echo "<td class=\"vflist\" width=\"27%\" style=\" border-top: 1px solid #C0C0C0; border-bottom: 1px solid #C0C0C0;\">&nbsp;";
        if (preg_match('#<authorUrl>(.*)</authorUrl>#', $content, $authorUrl)) {

//          echo "<a href=\"http://". $authorUrl[1] ."\" target=\"_new\">". $authorUrl[1] ."</a>";
			str_replace(array('http://','https://'), '', $authorUrl[1]);

			$aURL = str_replace(array('http://','https://'), '', $authorUrl[1]);
			
          echo "<a href=\"http://". $aURL ."\" target=\"_new\">". $aURL ."</a>";

        }
      echo "</td>";

      echo "<td class=\"vflist\" width=\"10%\" style=\"border-top: 1px solid #C0C0C0; border-right: 1px solid #C0C0C0; border-bottom: 1px solid #C0C0C0;\">&nbsp;";
      if (preg_match('#<author>(.*)</author>#', $content, $author)) {

        if ($author[1] == "Joomla! Project") {
          echo "<font color=\"green\">Core</font>";
        } else {
          echo "<font color=\"blue\">3rd Party</font>";
        }
      }
    echo "</td></tr>";

    echo "<tr><td colspan=\"5\" class=\"ext_desc\" style=\"background-color: #F1F1F1; border-bottom: 1px solid #C0C0C0; border-right: 1px solid #C0C0C0; border-left: 1px solid #C0C0C0;\">&nbsp;";
      if (preg_match('#<description>(.*)</description>#', $content, $description)) {
//        echo $description[1];
		echo strip_tags(substr($description[1], 0, 200));
		echo "...";
      }
    echo "</td></tr>";
    echo "<tr><td colspan=\"5\" style=\"height: 10px;\">&nbsp;</td></tr>";

      }
    }
  }
}

///	}

  echo "</table>";
  echo "<div class=\"profileNotes\">Done Processing Administrator Modules</div>";
  //closing the directory
///  closedir($dir_handle);

?>

  <br /><br />


<?php

//define the path as relative
$dir = "modules/";

	//using the opendir function
///	$dir_handle = @opendir($dir) or die("Unable to open $dir");

  echo "<table border=\"0\" cellspacing=\"3\" cellpadding=\"0\" width=\"90%\" align='center'>";
  echo "<tr><th class=\"tdHeadings\" colspan=\"5\">Site Modules</th></tr>";
  echo "<tr><td class=\"tdSHeadings\"> &nbsp;<b>Modules Name</b></td>";
  echo "<td class=\"tdSHeadings\"> &nbsp;<b>Version</b></td>";
  echo "<td class=\"tdSHeadings\"> &nbsp;<b>Author</b></td>";
  echo "<td class=\"tdSHeadings\"> &nbsp;<b>Author Site<b/></td>";
  echo "<td class=\"tdSHeadings\"> &nbsp;<b>Type<b/></td></tr>";
  echo "<tr><td colspan=\"5\" style=\"height: 10px;\"></td></tr>";

///	while ($file = readdir($dir_handle)) {


  if($file!="." && $file!=".." && $file!="index.html") {
    $newDir = $dir.''.$file;
    $dir1 = opendir($newDir);

     while ($f = readdir($dir1)) {

//      if (eregi("\.xml",$f)){ #if filename matches .xml in the name
			if (preg_match("/\.xml/i",$f)){ #if filename matches .xml in the name

        $content = file_get_contents($newDir.'/'.$f);

        if (preg_match('#install(.*)#', $content, $isInstallFile)) {

      echo "<tr><td class=\"vflist\" width=\"25%\" style=\"border-left: 1px solid #C0C0C0; border-top: 1px solid #C0C0C0; border-bottom: 1px solid #C0C0C0;\">&nbsp;";
        if (preg_match('#<name>(.*)</name>#', $content, $name)) {

          if (preg_match('#<author>(.*)</author>#', $content, $author)) {

            if ($author[1] == "Joomla! Project") {
              echo "<font color=\"green\">". $name[1] ."</font>";
            } else {
              echo "<font color=\"blue\">". $name[1] ."</font>";
            }

          }
        }
      echo "</td>";

      echo "<td class=\"vflist\" width=\"12%\" style=\"color: navy; border-top: 1px solid #C0C0C0; border-bottom: 1px solid #C0C0C0;\">&nbsp;v";
        if (preg_match('#<version>(.*)</version>#', $content, $version)) {
		  echo $version[1];
		}
	  echo "</td>";

      echo "<td class=\"vflist\" width=\"26%\" style=\"border-left: 1px solid #C0C0C0; border-top: 1px solid #C0C0C0; border-bottom: 1px solid #C0C0C0;\">&nbsp;";
        if (preg_match('#<author>(.*)</author>#', $content, $author)) {
          echo $author[1];
        }
      echo "</td>";
	  
      echo "<td class=\"vflist\" width=\"27%\" style=\" border-top: 1px solid #C0C0C0; border-bottom: 1px solid #C0C0C0;\">&nbsp;";
        if (preg_match('#<authorUrl>(.*)</authorUrl>#', $content, $authorUrl)) {
//          echo "<a href=\"http://". $authorUrl[1] ."\" target=\"_new\">". $authorUrl[1] ."</a>";
			str_replace(array('http://','https://'), '', $authorUrl[1]);

			$aURL = str_replace(array('http://','https://'), '', $authorUrl[1]);
			
          echo "<a href=\"http://". $aURL ."\" target=\"_new\">". $aURL ."</a>";
        }
      echo "</td>";

      echo "<td class=\"vflist\" width=\"10%\" style=\"border-top: 1px solid #C0C0C0; border-right: 1px solid #C0C0C0; border-bottom: 1px solid #C0C0C0;\">&nbsp;";
      if (preg_match('#<author>(.*)</author>#', $content, $author)) {

        if ($author[1] == "Joomla! Project") {
          echo "<font color=\"green\">Core</font>";
        } else {
          echo "<font color=\"blue\">3rd Party</font>";
        }
      }
    echo "</td></tr>";

    echo "<tr><td colspan=\"5\" class=\"ext_desc\" style=\"background-color: #F1F1F1; border-bottom: 1px solid #C0C0C0; border-right: 1px solid #C0C0C0; border-left: 1px solid #C0C0C0;\">&nbsp;";
      if (preg_match('#<description>(.*)</description>#', $content, $description)) {
//        echo $description[1];
		echo strip_tags(substr($description[1], 0, 200));
      }
    echo "</td></tr>";
    echo "<tr><td colspan=\"5\" style=\"height: 10px;\">&nbsp;</td></tr>";

      }
    }
  }
}

///	}

  echo "</table>";
  echo "<div class=\"profileNotes\">Done Processing Site Modules</div>";

  //closing the directory
///  closedir($dir_handle);


 } // end isV10
?>  


</div>
<br /><br />

			</div>

			<?php } ?>




				<?php if (@$_POST['doPLUGINS'] == "1" ) { ?>
		<div style="clear:both;width:100%;text-align:center;" style="">&nbsp;</div>
			<div class="tColumn-l" style="width:99%;">

<br />
<div align="center">
<?php

if ($isJVER == "10") {
//define the path as relative
$dir = "mambots/";

//using the opendir function
$dir_handle = @opendir($dir);// or die("Unable to open $dir");


  echo "<table border=\"0\" cellspacing=\"3\" cellpadding=\"0\" width=\"90%\" align='center'>";
  echo "<tr><th class=\"tdHeadings\" colspan=\"5\">Site Mambots</th></tr>";
  echo "<tr><td class=\"tdSHeadings\"> &nbsp;<b>Mambot Name</b></td>";
  echo "<td class=\"tdSHeadings\"> &nbsp;<b>Version</b></td>";
  echo "<td class=\"tdSHeadings\"> &nbsp;<b>Author</b></td>";
  echo "<td class=\"tdSHeadings\"> &nbsp;<b>Author Site<b/></td>";
  echo "<td class=\"tdSHeadings\"> &nbsp;<b>Type<b/></td></tr>";
  echo "<tr><td colspan=\"5\" style=\"height: 10px;\"></td></tr>";


while ($file = readdir($dir_handle)) {

  if($file!="." && $file!=".." && $file!="index.html") {
    $newDir = $dir.''.$file;
    $dir1 = opendir($newDir);

     while ($f = readdir($dir1)) {

//      if (eregi("\.xml",$f)){ #if filename matches .xml in the name
			if (preg_match("/\.xml/i",$f)){ #if filename matches .xml in the name

        $content = file_get_contents($newDir.'/'.$f);

        if (preg_match('#install(.*)#', $content, $isInstallFile)) {

      echo "<tr><td class=\"vflist\" width=\"25%\" style=\"border-left: 1px solid #C0C0C0; border-top: 1px solid #C0C0C0; border-bottom: 1px solid #C0C0C0;\">&nbsp;";
        if (preg_match('#<name>(.*)</name>#', $content, $name)) {

          if (preg_match('#<author>(.*)</author>#', $content, $author)) {

            if ($author[1] == "Joomla! Project") {
              echo "<font color=\"green\">". $name[1] ."</font>";
            } else {
              echo "<font color=\"blue\">". $name[1] ."</font>";
            }

          }
        }
      echo "</td>";

      echo "<td class=\"vflist\" width=\"12%\" style=\"color: navy; border-top: 1px solid #C0C0C0; border-bottom: 1px solid #C0C0C0;\">&nbsp;v";
        if (preg_match('#<version>(.*)</version>#', $content, $version)) {
		  echo $version[1];
		}
	  echo "</td>";

      echo "<td class=\"vflist\" width=\"26%\" style=\"border-left: 1px solid #C0C0C0; border-top: 1px solid #C0C0C0; border-bottom: 1px solid #C0C0C0;\">&nbsp;";
        if (preg_match('#<author>(.*)</author>#', $content, $author)) {
          echo $author[1];
        }
      echo "</td>";
	  
      echo "<td class=\"vflist\" width=\"27%\" style=\" border-top: 1px solid #C0C0C0; border-bottom: 1px solid #C0C0C0;\">&nbsp;";
        if (preg_match('#<authorUrl>(.*)</authorUrl>#', $content, $authorUrl)) {
//          echo "<a href=\"http://". $authorUrl[1] ."\" target=\"_new\">". $authorUrl[1] ."</a>";
			str_replace(array('http://','https://'), '', $authorUrl[1]);

			$aURL = str_replace(array('http://','https://'), '', $authorUrl[1]);
			
          echo "<a href=\"http://". $aURL ."\" target=\"_new\">". $aURL ."</a>";
        }
      echo "</td>";

      echo "<td class=\"vflist\" width=\"10%\" style=\"border-top: 1px solid #C0C0C0; border-right: 1px solid #C0C0C0; border-bottom: 1px solid #C0C0C0;\">&nbsp;";
      if (preg_match('#<author>(.*)</author>#', $content, $author)) {

        if ($author[1] == "Joomla! Project") {
          echo "<font color=\"green\">Core</font>";
        } else {
          echo "<font color=\"blue\">3rd Party</font>";
        }
      }
    echo "</td></tr>";

    echo "<tr><td colspan=\"5\" class=\"ext_desc\" style=\"background-color: #F1F1F1; border-bottom: 1px solid #C0C0C0; border-right: 1px solid #C0C0C0; border-left: 1px solid #C0C0C0;\">&nbsp;";
      if (preg_match('#<description>(.*)</description>#', $content, $description)) {
		echo strip_tags(substr($description[1], 0, 200));
		echo "...";
      }
    echo "</td></tr>";
    echo "<tr><td colspan=\"5\" style=\"height: 10px;\">&nbsp;</td></tr>";

      }
    }
  }
}
}
  echo "</table>";
  echo "<div class=\"profileNotes\">Done Processing Site Mambots</div>";
  //closing the directory
  closedir($dir_handle);
?>


<?php } else { ?>

<?php

//define the path as relative
$dir = "plugins/";

	//using the opendir function
	$dir_handle = @opendir($dir); // or die("Unable to open $dir");

  echo "<table border=\"0\" cellspacing=\"3\" cellpadding=\"0\" width=\"90%\" align='center'>";
  echo "<tr><th class=\"tdHeadings\" colspan=\"5\">Site Plugins</th></tr>";
  echo "<tr><td class=\"tdSHeadings\"> &nbsp;<b>Plugin Name</b></td>";
  echo "<td class=\"tdSHeadings\"> &nbsp;<b>Version</b></td>";
  echo "<td class=\"tdSHeadings\"> &nbsp;<b>Author</b></td>";
  echo "<td class=\"tdSHeadings\"> &nbsp;<b>Author Site<b/></td>";
  echo "<td class=\"tdSHeadings\"> &nbsp;<b>Type<b/></td></tr>";
  echo "<tr><td colspan=\"5\" style=\"height: 10px;\"></td></tr>";

	while ($file = readdir($dir_handle)) {


  if($file!="." && $file!=".." && $file!="index.html") {
    $newDir = $dir.''.$file;
    $dir1 = opendir($newDir);

     while ($f = readdir($dir1)) {

//      if (eregi("\.xml",$f)){ #if filename matches .xml in the name
			if (preg_match("/\.xml/i",$f)){ #if filename matches .xml in the name

        $content = file_get_contents($newDir.'/'.$f);

        if (preg_match('#install(.*)#', $content, $isInstallFile)) {

      echo "<tr><td class=\"vflist\" width=\"25%\" style=\"border-left: 1px solid #C0C0C0; border-top: 1px solid #C0C0C0; border-bottom: 1px solid #C0C0C0;\">&nbsp;";
        if (preg_match('#<name>(.*)</name>#', $content, $name)) {

          if (preg_match('#<author>(.*)</author>#', $content, $author)) {

            if ($author[1] == "Joomla! Project") {
              echo "<font color=\"green\">". $name[1] ."</font>";
            } else {
              echo "<font color=\"blue\">". $name[1] ."</font>";
            }

          }
        }
      echo "</td>";

      echo "<td class=\"vflist\" width=\"12%\" style=\"color: navy; border-top: 1px solid #C0C0C0; border-bottom: 1px solid #C0C0C0;\">&nbsp;v";
        if (preg_match('#<version>(.*)</version>#', $content, $version)) {
		  echo $version[1];
		}
	  echo "</td>";

      echo "<td class=\"vflist\" width=\"26%\" style=\"border-left: 1px solid #C0C0C0; border-top: 1px solid #C0C0C0; border-bottom: 1px solid #C0C0C0;\">&nbsp;";
        if (preg_match('#<author>(.*)</author>#', $content, $author)) {
          echo $author[1];
        }
      echo "</td>";
	  
      echo "<td class=\"vflist\" width=\"27%\" style=\" border-top: 1px solid #C0C0C0; border-bottom: 1px solid #C0C0C0;\">&nbsp;";
        if (preg_match('#<authorUrl>(.*)</authorUrl>#', $content, $authorUrl)) {
			
//          echo "<a href=\"http://". $authorUrl[1] ."\" target=\"_new\">". $authorUrl[1] ."</a>";
			str_replace(array('http://','https://'), '', $authorUrl[1]);

			$aURL = str_replace(array('http://','https://'), '', $authorUrl[1]);
			
          echo "<a href=\"http://". $aURL ."\" target=\"_new\">". $aURL ."</a>";			

        }
      echo "</td>";

      echo "<td class=\"vflist\" width=\"10%\" style=\"border-top: 1px solid #C0C0C0; border-right: 1px solid #C0C0C0; border-bottom: 1px solid #C0C0C0;\">&nbsp;";
      if (preg_match('#<author>(.*)</author>#', $content, $author)) {

        if ($author[1] == "Joomla! Project") {
          echo "<font color=\"green\">Core</font>";
        } else {
          echo "<font color=\"blue\">3rd Party</font>";
        }
      }
    echo "</td></tr>";

    echo "<tr><td colspan=\"5\" class=\"ext_desc\" style=\"background-color: #F1F1F1; border-bottom: 1px solid #C0C0C0; border-right: 1px solid #C0C0C0; border-left: 1px solid #C0C0C0;\">&nbsp;";
      if (preg_match('#<description>(.*)</description>#', $content, $description)) {
//        echo $description[1];
		echo strip_tags(substr($description[1], 0, 200));
      }
    echo "</td></tr>";
    echo "<tr><td colspan=\"5\" style=\"height: 10px;\">&nbsp;</td></tr>";

      }
    }
  }
}

	}

  echo "</table>";
  echo "<div class=\"profileNotes\">Done Processing Site Plugins</div>";

  //closing the directory
  closedir($dir_handle);

?>  




<?php } // end 15 ?>
</div>
<br /><br />


			</div>
			
			<div class="" style="">&nbsp;</div>
			
			<?php } ?>
			
		<div style="clear:both;width:100%;text-align:center;" style="">&nbsp;</div>

		</div>
		<!--// Close Main Container //-->


	<?php
	// J! Version was not recognised
		} else  if ( $isJVER == "unknownVer" ) {
		
			echo "<div style='background-color: yellow; text-align: center;'>". _BAD_VERSION ."</div>";
	
			} else if ( $installedJ == "0" ) {
			
				echo "<div style='background-color: yellow; text-align: center;'>". _NOT_INSTALLED ."</div>";
				
				}
	?>
		</body
	
	</html>