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