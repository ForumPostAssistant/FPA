<?php
/*
 * Dev info
 */
if ( defined( '_FPA_DEV' ) ) {

    echo '<div class="dev-mode-information">';
    echo '<span class="dev-mode-title">'. _RES .' Memory Statistics : </span> (requires PHP4.3.2 & PHP5.2.0)<br />';
    echo '<div style="margin-left: 10px;">';


    if( function_exists('memory_get_usage') ) {
        echo sprintf(qText('Currently Allocated Memory: %s'), convert( memory_get_usage() )) .'<br />'; // currently allocated memory
    } else {
        echo sprintf(qText('PHP version too low. The function %s does not exist'), 'memory_get_usage');
        echo '<br />';
    }


    if( function_exists('memory_get_peak_usage') ) {
        echo 'Total Peak Memory: '. convert( memory_get_peak_usage(true) ); // total peak memory usage
    } else {
        echo sprintf(qText('PHP version too low. The function %s does not exist'), 'memory_get_peak_usage');
        echo '<br />';
    }

    echo '<p style="font-weight:bold;"><em>'.sprintf(qText('Total runtime : %s seconds'), mt_end()) .'</em></p>';
    echo '</div>';
    echo '</div>';
}
