<?php
/**
* @version $Id: index.php 5571 2006-10-26 05:20:13Z Saka $
* @package Joomla
* @copyright Copyright (C) 2005 Open Source Matters. All rights reserved.
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
* Joomla! is free software. This version may have been modified pursuant
* to the GNU General Public License, and as distributed it includes or
* is derivative of works licensed under the GNU General Public License or
* other free or open source software licenses.
* See COPYRIGHT.php for copyright notices and details.
*/

/*******************************************************************************
* Version 0.4
* Modified 25th January 2007 by RussW (Joomla! Q&T WorkGroup) of JustJoomla
* to incorporate an Pre-Installation check for new users and a crude
* Joomla! Health and Security Audit environment for those all ready having
* installed Joomla!
* Design, layout and large portions of the code copyright Open Source Matters
* HISA (Health, Installation and Security Audit) is based on the Joomla!
* 1.0.12 Web-Installer (index.php)
* My code additions are the crude bits, I am not a PHP Developer by trade, but
* I hope someone finds it useful.
*******************************************************************************/


/*******************************************************************************
* Basic Run-Time Instructions
* HISA has been designed to be a Self-Contained Utility, no external resources are
* required.
*
* Simply drop this file in to the Top-Level directory of your Joomla!
* installation or in the directory that you are planning on installing Joomla!
* into and call it from a Web Browser.
* If you have not yet installed Joomla! or even copied the Joomla! distribution
* files to the directory you wish to install in to yet, HISA can still provide
* you with a basic overview of your environment and a view of whether your host
* will support Joomla! installation.
*
* Heaps of Error messages, Informational messages and Advisory messages have
* been included covering a large proportion of regularly seen Operational,
* Installation and Security issues, however we cannot capture all eventualities.
*******************************************************************************/

error_reporting( E_ALL & ~E_NOTICE);

// Set flag that this is a parent file
define( '_VALID_MOS', 1 );


view();

/*
 * Added 1.0.11
 */
function view() {

	$sp 		      = ini_get( 'session.save_path' );
	define ( 'noGlobal', 0);

		if (file_exists( 'configuration.php' )) {
			include( 'configuration.php' );
		} else {
			$noConfig = "1";
		}

	if (file_exists( 'globals.php' )) {
	require( 'globals.php' );
	} else {
	$noGlobal         = "1";
	}

	// Checking for J1 v1.0
	if (file_exists( 'includes/version.php' )) {
		require_once( 'includes/version.php' );
		$isV1         = "1";


	$_VERSION 		  = new joomlaVersion();
	$versioninfo 	  = $_VERSION->RELEASE .'.'. $_VERSION->DEV_LEVEL .' '. $_VERSION->DEV_STATUS;
	$version 		  = $_VERSION->PRODUCT .' '. $_VERSION->RELEASE .'.'. $_VERSION->DEV_LEVEL .' '. $_VERSION->DEV_STATUS.' [ '.$_VERSION->CODENAME .' ] '. $_VERSION->RELDATE .' '. $_VERSION->RELTIME .' '. $_VERSION->RELTZ;

	$thisVersion      = $_VERSION->RELEASE .'.'. $_VERSION->DEV_LEVEL;
	$thisDevLevel     = $_VERSION->DEV_LEVEL;

	} else { // If J! v1.0 not installed (installation check maybe) or user is running v1.5
		$notV1        = "<h1>Joomla! v1.1 Pre-Installation Assessment</h1><div style='text-align: left;' class='installCheckMsg'>It appears that you do not have Joomla! v1.0 installed or that we could not find your configuration file, so we will assume that this is a Pre-Installation Assessment.<br>";
		$notV1       .= "</div>";

		$notV1Post    = "<div style='text-align: left;' class='installCheckMsg'>This Script is only designed to Assess or Pre-Check Joomla! v1.0 installations, if you have Joomla! v1.5 installed we will not detect the instance. ";
		$notV1Post   .= "You may download your own copy of Joomla! from the <a href='http://forge.joomla.org/sf/frs/do/viewSummary/projects.joomla/frs' target='_new'>Joomla! Forge</a></div>";
	}

	// Current Release Information
	$currentPHP       = '5.2.3';
	$isWin            = (substr(PHP_OS, 0, 3) == 'WIN');
	$currentRelease   = '1.0';
	$currentDevLevel  = '13';
	$currentVersion   = $currentRelease.'.'.$currentDevLevel;


    /* Messages Section **************************************************/
    $uptoDate         = "Your Joomla! instance is up to date";
    $outofDate        = "Your Joomla! instance is not at the latest release.";
    $considerUpgrade  = "You should consider upgrading to ". $currentVersion ." as soon as is feasible.";
    $belowEleven      = "You are running a version of Joomla! below 1.0.11. There are serious security implications you should consider.";
    $notStable        = "You are running a <b>".$_VERSION->DEV_STATUS."</b> release version of Joomla!.";
    $stableUpgrade    = "You should consider upgrading to a <b>Stable</b> version of ". $currentVersion ." as soon as is feasible.";
	$phpDownlevel     = "Your version of PHP is not at the latest release of ". $currentPHP ."";
	$phpBelowFive     = "Your version of PHP below V5, you may wish to consider moving to a higher revision for enhanced security measures.";
	$jNotInstalled    = "It looks as if Joomla! is not installed yet as we didn't find a Joomla! configuration file.";
	$noDbDetails      = "We believe Joomla! is installed but couldn't find a Joomla! configuration file, so we were unable to determine your MySQL details.";
    $noConfigFile     = "Check your Joomla! directory for a mispelt or missing configuration.php, if you have not yet run the installer, please run the Web-Installer to generate a valid configuration file.";
	$sSessionNotSet   = "Your PHP save_session.path variable appears not to be set by your host. You will most likely have Administrator login problems unless this is resolved.";
	$sSessionPErr     = "Either your PHP save_session.path has not been set up correctly or your host has safe_mode configured. You will need to contact your host regarding resolving this issue.";
	$sSessionNoWrite  = "Your PHP save_session.path is not writable to you. You will most likely have Administrator login problems unless this is resolved.";
	$sSessionWErr     = "Either your PHP save_session.path directory does not have the correct write or execute permissions for you or your host has safe_mode configured. You will need to contact your host regarding resolving this issue.";
	$phpBelowMin      = "Your version of php (". phpversion() .") is below the minimum (4.1.0) supported by Joomla!.";
	$phpBelowMinErr   = "You will need to consider upgrading your servers PHP to a supported version (above 4.1.0)";
	$phpExtMissing    = "Your PHP instance does not have one or more required Extensions compiled or configured.";
	$phpExtMissingErr = "You will need to contact your host requesting the missing Extension to be compiled in to PHP.";
	$configWrite      = "Your configuration.php is world writable. For security you should consider demoting the permissions on this file. World writable may expose your site to potential unwanted access or exploits.";
	$configWriteErr   = "Safer permissions might be 644. This action does mean that you will no longer be able to use Joomla! to modify the configuration online.";
	$configNotWrite   = "Your configuration.php is not writable. For security this is good, however, you will no longer be able to use Joomla! to modify the configuration online.";
	$foundMySQL       = "PHP is compiled with MySQL support and should be available for use by Joomla!</div>";
	$regGlobalsOn	  = "The PHP setting register_globals is enabled, this setting may allow your site to be compromised if your directory permissions are elevated (0777)";
	$regGlobalsOnErr  = "Request that your host disable register_globals for security reasons and demote your directory permissions to the default (0755). Refer to the Joomla! <a href=http://forum.joomla.org target=_new>Security Forums</a> for further information.";


	echo "<?xml version=\"1.0\" encoding=\"iso-8859-1\"?".">";
	?>
	<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
	<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
	<title>Joomla! HISA - (Health, Installation and Security Audit)</title>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
	<link rel="shortcut icon" href="../images/favicon.ico" />

	<style>

	body {
		margin: 0px;
		padding: 0px;
		color : #333;
		background-color : #FFF;
		font-size : 11px;
		font-family : Arial, Helvetica, sans-serif;
	}

	#wrapper {
	        border: 0px;
	        margin: 0px;
	        margin-left: auto;
	        margin-right: auto;
	        padding: 0px;
	}

	#header {
	        background-color: #000;
	        background-position: right top;
	        border-bottom: 4px solid #C64934;
	}

	#joomla {
	        position: relative;
	        width: 100%;
	        background-position: bottom right;
	        margin: 0px;
	        padding: 0px;
	}

	#stepbar {
		background-color: #F1F1F1;
		width: 170px !important;
		width: 170px;
		font-size: 11px;
		float: left;
		text-align: left;
	}

	#step {
		font-size: 25px;
		font-weight: bold;
		text-align: center;
		color: #666666;
		padding: 10px 10px 10px 10px;
		white-space: nowrap;
		position: relative;
		float: center;
	}

	.step-on {
		color: #fff;
		background: #c64934;
		font-weight: bold;
		font-size: 12px;
		padding: 5px;
		border: 1px solid #cccccc;
		margin-bottom: 2px;
	}

	.step-off {
	  font-size: 12px;
		color: #999999;
		font-weight: bold;
		padding: 5px;
		border: 1px solid #cccccc;
		margin-bottom: 2px;
	}

	#right {
	  float: right;
	  width: 555px !important;
	  width: 545px;
	  border-left: 1px solid #cccccc;
	  padding-left: 10px;
	}

	#right-block {
	  float: right;
	  width: 725px !important;
	  width: 714px;
	  padding-left: 10px;
	}

	#break {
		height: 20px;
	}

	.licensetext {
	  text-align: left;
	}

	.license {
	  padding: 0px;
	  width: 530px;
	  height: 300px;
	}

	.license-form {
	  float: left;
	}

	.install {
		margin-left: auto;
		margin-right: auto;
		margin-top: 3em;
		margin-bottom: 3em;
		padding: 10px;
		border: 1px solid #cccccc;
		width: 750px;
		background: #F1F1F1;
	}

	.install h1 {
		font-size: 15px;
		font-weight: bold;
	 	color: #c64934;
		padding: 10px 10px 4px 0px;
	 	text-align: left;
		border-bottom: 1px solid #c64934;
		margin-bottom: 10px;
	}

	.install-form {
	  position: relative;
		text-align: left;
		float: right;
		width: 74%;
	}

	.install-text {
	  position: relative;
		text-align: left;
		width: 25%;
		float: left;
	}

	.form-block {
		border: 1px solid #cccccc;
		background: #E9ECEF;
		padding-top: 5px;
		padding-left: 5px;
		padding-bottom: 5px;
		padding-right: 5px;
	}

	.left {
	  position: relative;
		text-align: left;
		float: left;
		width: 50%;
	}

	.right {
	  position: relative;
		text-align: left;
		float: right;
		width: 50%;
	}

	.far-right {
	  position: relative;
		text-align: right;
		float: right;
	}

	.far-left {
	  position: relative;
		text-align: left;
		float: left;
	}

	.clr {
	    clear:both;
	    }

	.ctr {
		text-align: center;
	}

	.button {
		border : solid 1px #cccccc;
		background: #E9ECEF;
		color : #666666;
		font-weight : bold;
		font-size : 11px;
		padding: 4px;
	}

	table.content {
		width: 95%;
	}

	table.content td {
		color : #333333;
		font-size: 11px;
		width: 50%;
	}

	table.content2 {
		width: 90%;
	}

	table.content2 td {
		color : #333333;
		font-size: 11px;
	}

	.toggle {
		font-weight: bold;
	}


	/*  old stuff */


	a {
		color: #C64934;
		text-decoration: underline;
	}
	a:hover {
		color : #30569D;
		text-decoration : underline;
	}
	a:active {
		color : #FF9900;
		text-decoration : underline;
	}

	.inputbox {

		color: blue;
		font-family: Arial, Helvetica, sans-serif;
		z-index: -3;
		font-size: 11px;
	}

	.small {
		color : #333;
		font-size : 10px;
	}

	.error {
		color : #cc0000;
		font-size : 12px;
		font-weight : bold;
		padding-top: 10px;
		padding-bottom: 10px;
	}


	select.options, input.options {
		font-size: 8pt;
		border: 1px solid #999;
	}

	form {
		margin: 0px 0px 0px 0px;
	}


	.dottedline {
		border-bottom: 1px solid #333;
	}

	.installheader {
		color : #FFF;
		font-size : 24px;
	}

	textarea {
		color : #0000dd;
		font-family : Arial;
		font-size : 11px;
		border: 1px;
	}

    P.pageBreak {
		page-break-before: always;
	}

	.bad-message {
		border: 1px solid #cc0000;
		background: #ffffcc;
		font-size: 11px;
	    text-align: left;
	    vertical-align: top;
		min-height: 25px;
		padding-bottom: 5px;
		padding-left: 25px;
		color: red;
		font-weight: normal;
		background-image: url(includes/js/ThemeOffice/warning.png);
		background-position: 4px 4px;
		background-repeat: no-repeat;
	}

	.warn-message {
		border: 1px solid #666666;
		background: #ffffe0;
		font-size: 11px;
	    text-align: left;
	    vertical-align: top;
		min-height: 25px;
		padding-bottom: 5px;
		padding-left: 25px;
		font-weight: normal;
		background-image: url(includes/js/ThemeOffice/tooltip.png);
		background-position: 4px 4px;
		background-repeat: no-repeat;
	}

	.good-message {
		border: 1px solid #666666;
		background: #ffffff;
		font-size: 11px;
	    text-align: left;
	    vertical-align: middle;
		height: 25px;
		min-height: 25px;
		padding-bottom: 5px;
		padding-top: 5px;
		padding-left: 25px;
		font-weight: normal;
		background-image: url(includes/js/ThemeOffice/checkin.png);
		background-position: 4px 4px;
		background-repeat: no-repeat;
	}

	.advisor {
		border: 1px solid #666666;
		background: #ffffff;
		font-size: 11px;
	    text-align: left;
	    vertical-align: top;
		min-height: 25px;
		padding-bottom: 5px;
		padding-left: 25px;
		font-weight: normal;
		background-image: url(includes/js/ThemeOffice/language.png);
		background-position: 4px 4px;
		background-repeat: no-repeat;
	}

	.item {
		vertical-align: top;
	}

/* Installation Success Scale */
		table  { font-family: helvetica; }
		.main  {  }
		.side  { font-size: 8px; width: 35px; }
		.scale { font-size: 8px; border-right: 1px solid #e1e1e1; width: 20px; }
		.rate  { font-size: 11px; text-align:center; font-weight: bold; color: #404040; background-color: transparent;}
		.title { font-size: 12px; text-align:center; font-weight: bold; color: #404040; padding: 5px; }
		.scaleMsg { font-size: 10px; text-align:left; font-weight: normal; color: #808080; padding: 5px; }
		.installCheckMsg { font-size: 12px; text-align:left; font-weight: normal; color: #808080; padding: 5px; }
	</style>

	<script type="text/javascript">
		function disp_alert() { alert("Security Advise:" + '\n\n' + "Due to the highly sensitive nature of the information displayed in this report," + '\n' + "it is advisable to remove the Joomla! HISA script from the server immediately after use.") }
	</script>


	</head>
	<body onLoad="disp_alert()">

<div id="wrapper">
	<div id="header">
		<div id="joomla" style="padding-left: 25px; padding-top: 10px; height: 50px; font-size: 25px; font-weight: bold; color: #666666;">Joomla! Health, Installation and Security Audit</div>
	</div>
<!--//	<div class="error" style="padding: 2px; height: 15px; font-size: 11px; font-weight: normal; background-color: yellow; text-align: center;">Due to the highly sensative nature of the information displayed, the Joomla! HISA script should be removed from the server immediately after use.</div> //-->
</div>

<div id="ctr" align="center">
	<div class="install">
		<div id="stepbar">
			<div class="step-on">
				Host Environment
			</div>
			<div class="step-on">
				PHP Environment
			</div>
			<div class="step-on">
				MySQL Environment
			</div>
			<div class="step-on">
				Web-Server Environment
			</div>
			<div class="step-on">
				Joomla! Environment
			</div>
			<div class="step-on">
				Installation Check
			</div>
			<br>
			<b>Report Date:</b><br>
			<?php echo date('l dS \of F Y'); ?>
		</div>


		<div id="right">
	  		<div id="step">
	  			Joomla!<br>Health, Installation and Security Audit
	  		</div>

				<h1 style="text-align: center; border-bottom: 0px; color=#666666;">
					<?php
						if ($isV1 == "1") {
							echo $version;
					?>
					<br><br>
					<div class="form-block">
					<table class="content" border="0" width="95%" cellspadding="2" cellspacing="3" align="center">
					<tr>
					  <?php
					    if ($thisVersion == $currentVersion) {
						  echo "<td colspan='2' class='good-message'>". $uptoDate ."</td>";
						  } else {
						    echo "<td width='50%' class='bad-message'>". $outofDate ."</td>";
							echo "<td width='50%' class='advisor'>". $considerUpgrade ."</td>";

						  if ($thisDevLevel <= 10) { echo "<tr><td width='50%' class='bad-message'>". $belowEleven ."</td><td width='50%' class='advisor'>". $considerUpgrade ."</td></tr>"; }
						}

						  if ($_VERSION->DEV_STATUS != "Stable") {
						    echo "<tr><td width='50%' class='warn-message'>". $notStable ."</td><td width='50%' class='advisor'>". $stableUpgrade ."</td>";
						  }
					  ?>
					</tr>
					</table>

					</div>
					<?php
}
//						} else {
//							echo $notV1; ?>


					<br>
  			<div class="clr"></div>
  			<h1>Installation Assessment:</h1>
					<div class="form-block">

<table border="0" cellspacing="0" cellpadding="0" width="70%" align="center">
	<tr>
		<td align="center" valign="top">

			<table border="0" cellspacing="2" cellpadding="0" width="100%" height="100%" align="center">
<?php
	$colorOnNone   = "#b22222";
	$colorOnLow    = "#990099";
	$colorOnMed    = "#0033ff";
	$colorOnGood   = "#33ffff";
	$colorOnHigh   = "#66cc00";
	$colorOff      = "#ffffff";

	$tally = 13;

	$total = 0;


	if (is_writable( $sp )) { ($total++); } else { $installNote .= "<b>save_session.path</b> is not writable. You may observe Administrator login issues.<br>"; }
	if (ini_get('display_errors')) { ($total++); }
	if (!ini_get('register_globals')) { ($total++); } else { ($total--); $installNote .= "<b><font color=#C64934>register_globals</b> is enabled, the security of your web site could be compromised. Refer to the Joomla!</font> <a href=http://forum.joomla.org target=_new>Security Forum</a>.<br>";}
	if (!ini_get('safe_mode')) { ($total++); } else { $installNote .= "<b>safe_mode</b> is enabled, your installation may be troublesome. Refer to the Joomla! <a href=http://forum.joomla.org target=_new>Installation Forum</a>.<br>"; }

	if (ini_get('file_uploads')) { ($total++); } else { $installNote .= "<b>file_uploads</b> is disabled, you will not be able to upload any files or install Extensions.<br>"; }
	if (ini_get('magic_quotes_gpc')) { ($total++); } else { $installNote .= "<b>magic_quotes</b> is disabled, this is not essential for Joomla! to function but aids in securing your web site to some degree. Your installation can continue with this setting.<br>"; }
	if (!ini_get('magic_quotes_runtime')) { ($total++); }
	if (!ini_get('output_buffering')) { ($total++); }
	if (!ini_get('session_autostart')) { ($total++); } else { $installNote .= "<b>session_autostart</b> is enabled, you may observe eratic login behaviour.<br>"; }

// ShowStoppers - Sets Installation Assessment to 0%, not possible.
	if (extension_loaded('zlib')) { ($total++); } else { ($total = 0); $installNote .= "You do not have the <b>zlib library</b> loaded in PHP.<br>"; }
	if (extension_loaded('xml')) { ($total++); } else { ($total = 0); $installNote .= "You do not have the <b>xml library loaded</b> in PHP.<br>"; }
    if (function_exists( 'mysql_connect' )) { ($total++); } else { ($total = 0); $installNote .= "PHP does not have <b>MySQL support</b>.<br>"; }
	if (phpversion() > '4.1') { ($total++); } else { ($total = 0); $installNote .= "Your <b>PHP version</b> is not supported by Joomla!<br>"; }

	echo "<tr><td class='title' colspan='15'>Installation Assessment</td></tr>";
	echo "<tr>";

	if ($total === 0) {
			echo "<td bgcolor='#ffffff' class='scale' style='border-left: 2px solid ".$colorOnNone.";'>&nbsp;</td>";

		for ($n=0; $n<($total-1); $n++) {
//		for ($n=0; $n<13; $n++) {
			echo "<td class='scale' bgcolor='#ffffff'>&nbsp;</td>";
		}

	} else {

		for ($i=0; $i<$total; $i++) {

			if ($i < 3) {
				echo "<td class='scale' bgcolor='". $colorOnNone ."'>&nbsp;</td>";
				} elseif ($i < 6) {
					echo "<td class='scale' bgcolor='". $colorOnLow ."'>&nbsp;</td>";
					} elseif ($i < 9) {
						echo "<td class='scale' bgcolor='". $colorOnMed ."'>&nbsp;</td>";
						} elseif ($i <= 11) {
							echo "<td class='scale' bgcolor='". $colorOnGood ."'>&nbsp;</td>";
							} elseif ($i <= $total) {
								echo "<td class='scale' bgcolor='". $colorOnHigh ."'>&nbsp;</td>";
			}

		}


		for ($i=$total; $i<$tally; $i++) {
			echo "<td class='scale' bgcolor='". $colorOff ."'> &nbsp;</td>";
		}


	}
echo "</tr>";

	$scaleSuccess = number_format(($total/$tally)*100,0);
	echo "<tr><td colspan='15' class='rate' bgcolor='". $colorOff ."'>". $scaleSuccess ."%</td></tr>";

	if ($scaleSuccess <= 20) { $installMsg .= "It will not be possible to install or run Joomla! at this time."; }
			elseif ($scaleSuccess <= 30) { $installMsg = "Joomla! is very unlikely to install or run under this configuration."; }
				elseif ($scaleSuccess <= 40) { $installMsg = "Joomla! may install/run, however it is very unlikley to be functional."; }
					elseif ($scaleSuccess <= 50) { $installMsg = "Joomla! may install or run, however functionailty will be severly hampered."; }
						elseif ($scaleSuccess <= 60) { $installMsg = "Joomla! should probably install or run, but with reduced functionality."; }
							elseif ($scaleSuccess <= 70) { $installMsg = "Joomla! should install or run, but the majority of features will not not function correctly."; }
								elseif ($scaleSuccess <= 80) { $installMsg = "Joomla! should install or run, but some features will not function correctly."; }
									elseif ($scaleSuccess <= 90) { $installMsg = "Joomla! should install or run, but you might have difficulty making use of some features."; }
										elseif ($scaleSuccess <= 95) { $installMsg = "Joomla! should install or run, but you may observe a few minor difficulties with some features."; }
											elseif ($scaleSuccess > 95) { $installMsg = "Joomla! should install or run, with no immediate issues. Enjoy your Joomla! Experience."; }

	echo "<tr><td colspan='15' class='advisor' style='color: #404040;'>". $installMsg ."</td></tr>";
	if ($total != $tally) {
		echo "<tr><td colspan='15' class='warn-message'><b>Advisories:</b><br>".$installNote."</td></tr>";
	}
?>

		</table>

	</td>
	</tr>
</table>
</div>
<?php
							echo $notV1Post;
//						}  // end NotV1
					?>
				</h1>
  			<div class="clr"></div>
  			<h1>Host Environment:</h1>
	  		<div class="install-text">
  				<p>This is an overview of your host servers' environment.</p>
  			</div>
			<div class="install-form">
  				<div class="form-block">

						<table class="content" border="0">
                        <tr>
						    <td class="item" width="35%"><b>Hostname</b></td>
							<td class="item" width="65%"><?php echo @php_uname(n); ?></td>
						</tr>
                        <tr>
						    <td class="item">&nbsp; - Host IP Address</td>
							<td class="item"><?php echo @gethostbyname(trim(`hostname`)); ?></td>
						</tr>
                        <tr>
						    <td class="item">&nbsp; - Platform</td>
							<td class="item"><?php echo @php_uname(s); ?> <?php echo @php_uname(r); ?> <?php echo @php_uname(v); ?></td>
						</tr>
                        <tr>
						    <td class="item">&nbsp; - Architcture</td>
							<td class="item"><?php echo @php_uname(m); ?></td>
						</tr>
                        <tr>
						    <td class="item">&nbsp; - Username</td>
							<td class="item"><?php echo get_current_user (); ?></td>
						</tr>
                        <tr>
						    <td class="item">&nbsp; - Current Path</td>
							<td class="item"><?php echo getcwd (); ?></td>
						</tr>
                        </table>
  				</div>
			</div>
		</div>
		<div class="clr"></div>
	</div>







	<div id="ctr" align="center">
		<div class="install">
		<div id="stepbar">
			<p>
			<?php
		  		echo "<table border='0' width='96%' cellspadding='2' cellspacing='3' align='center'><tr><td width='50%' class='advisor'>The Web-Servers virtual Site IP Address ( ". $_SERVER['SERVER_ADDR'] ." ) will be your Web Site IP Address</td></tr></table>";
		  		echo "<table border='0' width='96%' cellspadding='2' cellspacing='3' align='center'><tr><td width='50%' class='advisor'>The Document Root is most likely going to be the base of your Joomla! absolute_path variable, with any sub-directory appended to it that you have installed Joomla! into.</td></tr></table>";
			?>
			</p>
		</div>
			<div id="right">


  			<div class="clr"></div>
  			<h1>Web-Server Environment:</h1>
	  		<div class="install-text">
  				<p>This is an oveview of the hosts Web Serving environment and configuration.</p>
  			</div>
			<div class="install-form">
  				<div class="form-block">
						<table class="content" border="0">
                        <tr>
						    <td class="item" width="35%"><b>Server Version</b></td>
							<td class="item" width="65%"><?php echo $_SERVER['SERVER_SOFTWARE']; ?></td>
						</tr>
                        <tr>
						    <td class="item">&nbsp; - Host</td>
							<td class="item"><?php echo $_SERVER['HTTP_HOST']; ?></td>
						</tr>
                        <tr>
						    <td class="item">&nbsp; - Document Root</td>
							<td class="item"><?php echo $_SERVER['DOCUMENT_ROOT']; ?></td>
						</tr>
                        <tr>
						    <td class="item">&nbsp; - Site IP Address</td>
							<td class="item"><?php echo $_SERVER['SERVER_ADDR']; ?></td>
						</tr>
                        <tr>
						    <td class="item">&nbsp; - Server Port</td>
							<td class="item"><?php echo $_SERVER['SERVER_PORT']; ?></td>
						</tr>
                        <tr>
						    <td class="item">&nbsp; - Server Admin</td>
							<td class="item"><?php echo $_SERVER['SERVER_ADMIN']; ?></td>
						</tr>
                        <tr>
						    <td class="item">&nbsp; - Server Signature</td>
							<td class="item"><?php echo $_SERVER['SERVER_SIGNATURE']; ?></td>
						</tr>
                        <tr>
						    <td class="item">&nbsp; - Server Protocol</td>
							<td class="item"><?php echo $_SERVER['SERVER_PROTOCOL']; ?></td>
						</tr>
                        <tr>
						    <td class="item">&nbsp; - Gateway Interface</td>
							<td class="item"><?php echo $_SERVER['GATEWAY_INTERFACE']; ?></td>
						</tr>
                        </table>

  				</div>
			</div>

		</div>
		<div class="clr"></div>
	</div>




	<p class="pageBreak"></p>





<div id="ctr" align="center">
	<div class="install">

		<div id="stepbar">
			<p>
			<?php
				if (version_compare(phpversion(), $currentPHP, "<")) {
			  		echo "<table border='0' width='96%' cellspadding='2' cellspacing='3' align='center'><tr><td width='50%' class='warn-message'>". $phpDownlevel ."</td></tr></table>"; }
				if (version_compare(phpversion(), 5.0, "<")) {
			  		echo "<table border='0' width='96%' cellspadding='2' cellspacing='3' align='center'><tr><td width='50%' class='advisor'>". $phpBelowFive ."</td></tr></table>"; }
			?>
			</p>
		</div>


		<div id="right">
  			<div class="clr"></div>
  			<h1>PHP Environment:</h1>
	  		<div class="install-text">
  				<p>This is an oveview of the hosts PHP environment and configuration.</p>
  			</div>
			<div class="install-form">
  				<div class="form-block">
						<table class="content" border="0">
                        <tr>
						    <td class="item" width="35%"><b>PHP Version</b></td>
							<td class="item" width="65%"><?php echo phpversion(); ?></td>
						</tr>
                        <tr>
						    <td class="item">&nbsp; - Include Files</td>
							<td class="item"><?php echo ini_get('include_path'); ?></td>
						</tr>
                        <tr>
						    <td class="item">&nbsp; - PHP API</td>
							<td class="item"><?php echo php_sapi_name(); ?></td>
						</tr>
                        <tr>
						    <td class="item">&nbsp; - Zend Version</td>
							<td class="item"><?php echo zend_version(); ?>
							</td>
						</tr>
                        </table>
  				</div>
			</div>

		</div>
		<div class="clr"></div>
	</div>


	<?php
	if ($isV1 == "1") { // Only display the rest of the pages if Joomla! v1.0 installed.
	?>


	<div id="ctr" align="center">
		<div class="install">
		<div id="stepbar">
			<p>
			<?php
				if ((($noConfig == "1") && ($noGlobal == "1")) || ($isV1 != "1")) {
			  		echo "<table border='0' width='96%' cellspadding='2' cellspacing='3' align='center'><tr><td width='50%' class='warn-message'>". $jNotInstalled ."</td></tr></table>"; }
				if (($noConfig == "1") && ($noGlobal != "1") && ($isV1 == "1")) {
			  		echo "<table border='0' width='96%' cellspadding='2' cellspacing='3' align='center'><tr><td width='50%' class='bad-message'>". $noDbDetails ."</td></tr><tr><td width='50%' class='advisor'>". $noConfigFile ."</td></tr></table>"; }
				if ((function_exists( 'mysql_connect' )) AND ($noConfig == "1")) {
			  		echo "<table border='0' width='96%' cellspadding='2' cellspacing='3' align='center'><tr><td width='50%' class='good-message'>". $foundMySQL ."</td></tr><tr><td width='50%' class='advisor'>". $noConfigFile ."</td></tr></table>"; }
			?>
			</p>
		</div>
			<div id="right">


  			<div class="clr"></div>
  			<h1>MySQL Environment:</h1>
	  		<div class="install-text">
  				<p>This is an oveview of the hosts MySQL Database environment and configuration.</p>
  			</div>
			<div class="install-form">
  				<div class="form-block">




			<?php
	        $link = @mysql_connect('localhost', $mosConfig_user, $mosConfig_password);
			$sqlErr = mysql_errno();

			if ((!$link) && (function_exists( 'mysqli_connect' ))) {

				$link = @mysqli_connect('localhost', $mosConfig_user, $mosConfig_password);
				$sqlErr = mysqli_connect_errno();
			}

//				echo $sqlErr;
				if (($sqlErr == "2013") || ($sqlErr == "2003") || ($sqlErr == "10061")) {
					echo "MySQL appears to be unavailable, this needs to be resolved before we can continue.";
				}

				if (($sqlErr == "1045") || ($sqlErr == "1130")) {
					echo "MySQL appears to be available, but we received an Access Denied response.";
				}
				?>
						<table class="content" border="0">
                        <tr>
						    <td class="item" width="35%"><b>MySQL Server Version</b></td>
							<td class="item" width="65%"><?php echo @mysql_get_server_info(); ?></td>
						</tr>
                        <tr>
						    <td class="item">&nbsp; - Client Version</td>
							<td class="item"><?php echo @mysql_get_client_info(); ?></td>
						</tr>
                        <tr>
						    <td class="item">&nbsp; - Host Info</td>
							<td class="item"><?php echo @mysql_get_host_info(); ?></td>
						</tr>
                        <tr>
						    <td class="item">&nbsp; - Protocol Version</td>
							<td class="item"><?php echo @mysql_get_proto_info(); ?></td>
						</tr>
                        </table>

						<?php
							if ((function_exists( 'mysql_connect' )) AND ($noConfig == "1")) {
								echo "<p class=warn-message>MySQL support appears to be available, but we could not find your Joomla! configuration file to acquire credentials.</p>";
							}
						?>
  				</div>
			</div>

		</div>
		<div class="clr"></div>
	</div>









	<div id="ctr" align="center">
		<div class="install">
		<div id="stepbar">
			<p>
			<?php
				if ($mosConfig_offline == "1") {
		  			echo "<table border='0' width='96%' cellspadding='2' cellspacing='3' align='center'><tr><td width='50%' class='advisor'>Your site is currently configured as <b>Offline</b>. This maybe modified in the configuration.php</td></tr></table>";
				}
		  		echo "<table border='0' width='96%' cellspadding='2' cellspacing='3' align='center'><tr><td width='50%' class='advisor'>The Live site is the Internet Address of your Joomla! installation.</td></tr></table>";
		  		echo "<table border='0' width='96%' cellspadding='2' cellspacing='3' align='center'><tr><td width='50%' class='advisor'>The Absolute Path is where yuo shuold find your Joomla! installation.</td></tr></table>";
			?>
			</p>
		</div>
			<div id="right">


  			<div class="clr"></div>
  			<h1>Joomla! Environment:</h1>
	  		<div class="install-text">
  				<p>This is an oveview of your Joomla! Installation and configuration.</p>
  			</div>
			<div class="install-form">
  				<div class="form-block">
						<table class="content" border="0">
                        <tr>
						    <td class="item" width="35%"><b>Site Name</b></td>
							<td class="item" width="65%"><?php echo $mosConfig_sitename; ?></td>
						</tr>
                        <tr>
						    <td class="item" width="35%">&nbsp; - Site Offline</td>
							<td class="item" width="65%">
							<?php
							if ($mosConfig_offline == "1") {
							  echo "Site is <font color='red'>Offline</font>";
							  } else { echo "Site is <font color='green'>Online</font>"; }
							?>
							</td>
						</tr>
                        <tr>
						    <td class="item" width="35%">&nbsp; - Version</td>
							<td class="item" width="65%"><?php echo $version; ?></td>
						</tr>
                        <tr>
						    <td class="item">&nbsp; - Live Site</td>
							<td class="item"><?php echo $mosConfig_live_site; ?></td>
						</tr>
                        <tr>
						    <td class="item">&nbsp; - Absolute Path</td>
							<td class="item"><?php echo $mosConfig_absolute_path ?></td>
						</tr>
                        <tr>
						    <td class="item">&nbsp; - Cache Settings</td>
							<td class="item">
							<?php
							if ($mosConfig_caching == "1") {
							  echo "Enabled";
							  echo "<br>".$mosConfig_cachepath;
							  } else { echo "Disabled"; }
							?>
							</td>
						</tr>
                        <tr>
						    <td class="item">&nbsp; - Using SEF</td>
							<td class="item">
							<?php
							if ($mosConfig_sef == "1") {
							  echo "Enabled";
							  } else { echo "Disabled"; }
							?>
							</td>
                        </table>

  				</div>
			</div>

		</div>
		<div class="clr"></div>
	</div>


<?php } // end isV1 only ?>


	<p class="pageBreak"></p>





	<div id="ctr" align="center">
		<div class="install">

			<div id="stepbar">
			<?php

				if (version_compare(phpversion(), 4.1, "<")) {
			  		echo "<table border='0' width='96%' cellspadding='2' cellspacing='3' align='center'><tr><td width='50%' class='bad-message'>". $phpBelowMin ."</td></tr><tr><td width='50%' class='advisor'>". $phpBelowMinErr ."</td></tr></table>"; }

				if ( (!extension_loaded('zlib')) || (!extension_loaded('xml')) || (!extension_loaded('mysql')) ) {
				echo "<table border='0' width='96%' cellspadding='2' cellspacing='3' align='center'><tr><td width='50%' class='bad-message'>". $phpExtMissing ."</td></tr><tr><td width='50%' class='advisor'>". $phpExtMissingErr ."</td></tr></table>"; }

				if (!$sp) {
			  		echo "<table border='0' width='96%' cellspadding='2' cellspacing='3' align='center'><tr><td width='50%' class='bad-message'>". $sSessionNotSet ."</td></tr><tr><td width='50%' class='advisor'>". $sSessionPErr ."</td></tr></table>"; }

				if (!is_writable( $sp )) {
					echo "<table border='0' width='96%' cellspadding='2' cellspacing='3' align='center'><tr><td width='50%' class='bad-message'>". $sSessionNoWrite ."</td></tr><tr><td width='50%' class='advisor'>". $sSessionWErr ."</td></tr></table>"; }

				if ($noConfig == "1"){
					echo "<table border='0' width='96%' cellspadding='2' cellspacing='3' align='center'><tr><td width='50%' class='bad-message'>". $jNotInstalled ."</td></tr><tr><td width='50%' class='advisor'>". $noConfigFile ."</td></tr></table>"; }

			if (@file_exists( 'configuration.php' )) {
				if (!is_writable( 'configuration.php' )) {
					echo "<table border='0' width='96%' cellspadding='2' cellspacing='3' align='center'><tr><td class='advisor'>". $configNotWrite ."</td></tr></table>"; }
				if (is_writable( 'configuration.php' )) {
					echo "<table border='0' width='96%' cellspadding='2' cellspacing='3' align='center'><tr><td width='50%' class='bad-message'>". $configWrite ."</td></tr><tr><td width='50%' class='advisor'>". $configWriteErr ."</td></tr></table>"; }
			}

			?>
			</div>

			<div id="right">
				<div class="clr"></div>
				<h1>
					Required Settings Check:
				</h1>

				<div class="install-text">
					<p>
						If any of these items are highlighted in red then please take actions to correct them.
					</p>
					<p>
						Failure to do so could lead to your Joomla! installation not functioning correctly.
					</p>
					<div class="ctr"></div>
				</div>

				<div class="install-form">
					<div class="form-block">
						<table class="content">
						<tr>
							<td class="item">
								PHP version >= 4.1.0
							</td>
							<td align="left">
								<?php echo phpversion() < '4.1' ? '<b><font color="red">No</font></b>' : '<b><font color="green">Yes</font></b>';?>
							</td>
						</tr>
						<tr>
							<td>
								&nbsp; - zlib compression support
							</td>
							<td align="left">
								<?php echo extension_loaded('zlib') ? '<b><font color="green">Available</font></b>' : '<b><font color="red">Unavailable</font></b>';?>
							</td>
						</tr>
						<tr>
							<td>
								&nbsp; - XML support
							</td>
							<td align="left">
								<?php echo extension_loaded('xml') ? '<b><font color="green">Available</font></b>' : '<b><font color="red">Unavailable</font></b>';?>
							</td>
						</tr>
						<tr>
							<td>
								&nbsp; - MySQL support
							</td>
							<td align="left">
								<?php echo function_exists( 'mysql_connect' ) ? '<b><font color="green">Available</font></b>' : '<b><font color="red">Unavailable</font></b>';?>
							</td>
						</tr>
						<tr>
							<td valign="top" class="item">
								configuration.php
							</td>
							<td align="left">
								<?php
								if (@file_exists('configuration.php') &&  @is_writable( 'configuration.php' )){
									echo '<b><font color="green">Writeable</font></b>';
								} else if (is_writable( '..' )) {
									echo '<b><font color="red">Writeable</font></b>';
								} else {
									echo '<b><font color="green">Unwriteable</font></b>';
								}
								?>
							</td>
						</tr>
						<tr>
							<td class="item">
								Session save path
							</td>
							<td align="left" valign="top">
								<?php echo is_writable( $sp ) ? '<b><font color="green">Writeable</font></b>' : '<b><font color="red">Unwriteable</font></b>';?>
							</td>
						</tr>
						<tr>
							<td class="item" colspan="2">
								<b>(</b> <?php echo $sp ? $sp : 'Not set'; ?> <b>)</b>
							</td>
						</tr>
						</table>
					</div>
				</div>
				<div class="clr"></div>

				<?php
				$wrongSettingsTexts = array();

				if ( ini_get('magic_quotes_gpc') != '1' ) {
					$wrongSettingsTexts[] = 'PHP magic_quotes_gpc setting is `OFF` instead of `ON`';
				}
				if ( ini_get('register_globals') == '1' ) {
					$wrongSettingsTexts[] = 'PHP register_globals setting is `ON` instead of `OFF`';
				}

				if ($noGlobal != "1") {
					if ( RG_EMULATION != 0 ) {
						$wrongSettingsTexts[] = 'Joomla! RG_EMULATION setting is `ON` instead of `OFF` in file globals.php(Pre-1.0.13) / configuration.php(Post-1.0.13) <br /><span style="font-weight: normal; font-style: italic; color: #666;">`ON` by default for compatibility reasons</span>';
					}
				}


				if ( count($wrongSettingsTexts) ) {
					?>
					<h1>
						Security Check:
					</h1>

					<div class="install-text">
						<p>
							Following PHP Server Settings are not optimal for site <strong>Security or Integrity</strong> and it is recommended to change them:
						</p>
						<p>
							Please check <a href="http://forum.joomla.org/index.php/topic,81058.0.html" target="_blank">the Official Joomla! Server Security post</a> for more information.
						</p>
						<div class="ctr"></div>
					</div>

					<div class="install-form">
						<div class="form-block" style=" border: 1px solid #cc0000; background: #ffffcc;">
							<table class="content">
							<tr>
								<td class="item">
									<ul style="margin: 0px; padding: 0px; padding-left: 5px; text-align: left; padding-bottom: 0px; list-style: none;">
										<?php
										foreach ($wrongSettingsTexts as $txt) {
											?>
											<li style="min-height: 25px; padding-bottom: 5px; padding-left: 25px; color: red; font-weight: bold; background-image: url(../includes/js/ThemeOffice/warning.png); background-repeat: no-repeat; background-position: 0px 2px;" >
												<?php
												echo $txt;
												?>
											</li>
											<?php
										}
										?>
									</ul>
								</td>
							</tr>
							</table>
						</div>
					</div>
					<div class="clr"></div>
					<?php
				}
				?>

				<h1>
					Recommended Settings Check:
				</h1>

				<div class="install-text">
					<p>
						These settings are recommended for PHP in order to ensure full
						compatibility with Joomla!.
					</p>
					<p>
						However, Joomla! will still operate if your settings do not quite match the recommended
					</p>
					<div class="ctr"></div>
				</div>

				<div class="install-form">
					<div class="form-block">

						<table class="content">
						<tr>
							<td class="toggle" width="500px">
								Directive
							</td>
							<td class="toggle">
								Recommended
							</td>
							<td class="toggle">
								Actual
							</td>
						</tr>
						<?php
						$php_recommended_settings = array(array ('Safe Mode','safe_mode','OFF'),
							array ('Display Errors','display_errors','ON'),
							array ('File Uploads','file_uploads','ON'),
							array ('Magic Quotes GPC','magic_quotes_gpc','ON'),
							array ('Magic Quotes Runtime','magic_quotes_runtime','OFF'),
							array ('Register Globals','register_globals','OFF'),
							array ('Output Buffering','output_buffering','OFF'),
							array ('Session auto start','session.auto_start','OFF'),
						);

						foreach ($php_recommended_settings as $phprec) {
							?>
							<tr>
								<td class="item">
									<?php echo $phprec[0]; ?>:
								</td>
								<td class="toggle">
									<?php echo $phprec[2]; ?>:
								</td>
								<td>
									<b>
										<?php
										if ( get_php_setting($phprec[1]) == $phprec[2] ) {
											?>
											<font color="green">
											<?php
										} else {
											?>
											<font color="red">
											<?php
										}
										echo get_php_setting($phprec[1]);
										?>
										</font>
									</b>
								<td>
							</tr>
							<?php
						}
						?>
						<tr>
							<td class="item">
								Register Globals Emulation:
							</td>
							<td class="toggle">
								OFF:
							</td>
							<td>
								<?php
								if ($noGlobal != "1") {
								if ( RG_EMULATION ) {
									?>
									<font color="red"><b>
									<?php
								} else {
									?>
									<font color="green"><b>
									<?php
								}
									echo ((RG_EMULATION) ? 'ON' : 'OFF');
								} else { echo "<b>N/A</b>"; }
								?>
								</b>
								</font>
							<td>
						</tr>
						<?php if ($noGlobal == "1") { ?>
							<tr><td colspan="3" class="advisor"><i>Register Globals Emulation is a Joomla! function and can only be tested with Joomla! installed.</i></td></tr>
						<?php } ?>
						</table>
  				</div>
			</div>

		</div>
		<div class="clr"></div>
	</div>






<?php	if ($isV1 == "1") { // Only display the rest of the pages if Joomla! v1.0 installed. ?>

	<div id="ctr" align="center">
		<div class="install">

			<div id="stepbar">
			<br>
			<table border="0" align="center" width="90%">
			<tr>
				<td colspan="2" style="font-size: 9px; vertical-align: top;"><b>Mode Security:</b></td>
			</tr>
			<tr>
				<td width="20%" style="color: red; font-size: 9px; vertical-align: top;">RED</td>
				<td width="80%" style="font-size: 9px; vertical-align: top;">The Directory is World Writable, this might expose your site to unwanted access or exploits</td>
			</tr>
			<tr>
				<td width="20%" style="color: blue; font-size: 9px; vertical-align: top;">BLUE</td>
				<td width="80%" style="font-size: 9px;" vertical-align: top;>No &quot;Execute&quot; or &quot;Read&quot; bit set, file execution may be problematic in this directory</td>
			</tr>
			<tr>
				<td width="20%" style="color: green; font-size: 9px; vertical-align: top;">GREEN</td>
				<td width="80%" style="font-size: 9px; vertical-align: top;">These permissions are reasonably sane, but may still require review. Default Unix directory Mode is normally: 0755</td>
			</tr>
			<tr>
				<td colspan="2" style="font-size: 8px; vertical-align: top;">
				<br /><b>References:</b><br />
					<a href="http://forum.joomla.org/index.php/topic,102558.0.html" target="_new">Joomla! Security FAQ Table of Contents</a><br />
					<a href="http://forum.joomla.org/index.php/topic,81058.0.html" target=_new">Joomla! Administrators Security Checklist</a><br />
					<a href="http://forum.joomla.org/index.php/topic,121470.0.html" target="_new">FAQ: Joomla! Permissions Overview</a>
				</td>
			</tr>
			</table>

			<?php
			if (ini_get('register_globals')) {
				echo "<table border='0' width='96%' cellspadding='2' cellspacing='3' align='center'><tr><td width='50%' class='bad-message'>". $regGlobalsOn ."</td></tr><tr><td width='50%' class='advisor'>". $regGlobalsOnErr ."</td></tr></table>"; }
			?>

			</div>

			<div id="right">
				<div class="clr"></div>

				<h1>
					Directory and File Permissions Check:
				</h1>

				<div class="install-text">
					<p>
						In order for Joomla! to function correctly it needs to be able to access or write to certain files or directories.
					</p>
					<p>
						If you see "Unwriteable" you need to change the permissions on the file or directory to allow Joomla! to write to it.
					</p>
					<div class="clr">&nbsp;&nbsp;</div>
					<div class="ctr"></div>
				</div>

				<div class="install-form">
					<div class="form-block">
						<table class="content" cellspacing="0">
						<tr>
							<td class="toggle">Directory</td>
							<td class="toggle" align="right">Web-Server&nbsp;&nbsp;</td>
							<td class="toggle" align="center">Mode</td>
						</tr>


						<?php
						writableCell( 'administrator/backups' );
						writableCell( 'administrator/components' );
						writableCell( 'administrator/modules' );
						writableCell( 'administrator/templates' );
						writableCell( 'cache' );
						writableCell( 'components' );
						writableCell( 'images' );
						writableCell( 'images/banners' );
						writableCell( 'images/stories' );
						writableCell( 'language' );
						writableCell( 'mambots' );
						writableCell( 'mambots/content' );
						writableCell( 'mambots/editors' );
						writableCell( 'mambots/editors-xtd' );
						writableCell( 'mambots/search' );
						writableCell( 'mambots/system' );
						writableCell( 'media' );
						writableCell( 'modules' );
						writableCell( 'templates' );
						?>
						</table>
					</div>
					<div class="clr"></div>
				</div>

				<div class="clr"></div>
			</div>
			<div class="clr"></div>
		</div>
	<div class="error" style="width: 755px; padding: 2px; height: 15px; font-size: 11px; font-weight: normal; background-color: yellow; text-align: center;">Due to the highly sensitive nature of the information displayed, the Joomla! HISA script should be removed from the server immediately after use.</div>
	</div>

<div class="clr"></div>
	<?php } // Close the Joomla! v1.0 display check ?>
<div class="ctr">
	<a href="http://www.joomla.org" target="_blank">Joomla!</a> is Free Software released under the GNU/GPL License.
</div>

	</body>
	</html>
	<?php
}

function get_php_setting($val) {
	$r =  (ini_get($val) == '1' ? 1 : 0);
	return $r ? 'ON' : 'OFF';
}

function writableCell( $folder, $relative=0, $text='' ) {
	$writeable 		= '<b><font color="green">Writeable</font></b>&nbsp;&nbsp;';
	$unwriteable 	= '<b><font color="red">Unwriteable</font></b>&nbsp;&nbsp;';

	echo '<tr>';
	echo '<td class="item">' . $folder . '/</td>';
	echo '<td align="right" style="border-right: 1px solid #c0c0c0;">';
	if ( $relative ) {
		echo is_writable( "../$folder" ) 	? $writeable : $unwriteable;
	} else {
		echo is_writable( "$folder" ) 		? $writeable : $unwriteable;
	}
	echo '</td>';
	echo '<td class="item" align="center">';
		if (substr(sprintf('%o', fileperms($folder)), -1) == '7')
			{ echo "<font color='red'>"; }
	 		elseif (substr(sprintf('%o', fileperms($folder)), -1) <= '4')
				{ echo "<font color='blue'>"; }
				else { echo "<font color='green'>"; }

			if ( $relative ) {
		 		echo "". substr(sprintf('%o', fileperms("../".$folder)), -4) ."";
			} else {
				echo "". substr(sprintf('%o', fileperms($folder)), -4) ."";
			}
		echo '</font>';
		echo '</td>';

	echo '</tr>';
}
?>
