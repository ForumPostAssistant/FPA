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

$sfBuilderDefinedLanguages = array();//AutoFilled

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

/**@@FPA_DEFINES@@**/

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
/**@@FPA_CSS@@**/
</style>

<script type="text/javascript">
<!--
/**@@FPA_JAVASCRIPT@@**/
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

/**@@LANGUAGE_SWITCHER@@**/

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
/**@@FPA_FORMAT_JOOMLACODE@@**/
                } elseif ( defined( '_FPA_BRA' ) AND $_POST['postFormat'] == '2' ) { // GitHUB
/**@@FPA_FORMAT_GITHUB@@**/
                } elseif ( $_POST['postFormat'] == '3' ) { // Forum
/**@@FPA_FORMAT_FORUM@@**/
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

/**@@FPA_LEGEND@@**/
?>

</form>

</div><!-- outer -->

</body>

</html>

<?php
/**@@FPA_DISCOVER_INSTANCE@@**/

/**@@FPA_DISCOVER_PHP@@**/

/**@@FPA_DISCOVER_SYSTEM@@**/

/**@@FPA_FUNCTIONS@@**/

/**@@LANGUAGE_CLASS@@**/
