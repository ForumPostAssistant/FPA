<?php
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
