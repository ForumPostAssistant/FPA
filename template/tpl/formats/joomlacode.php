<?php
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
