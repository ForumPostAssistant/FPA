<?php
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