<?php
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
