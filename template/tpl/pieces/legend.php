<?php
/*
 * pieces/legend.php
 */
echo '<div class="snapshot-information" style="text-align:center;color:#4D8000!important;padding-top:10px;">';
echo '<span class="header-title">'. qText('Legends and Settings') .'</span>';
echo '<div style="width:85%;margin:0 auto;margin-top:10px;">';

// LEGENDS
echo '<div class="half-section-container" style="clear:both;width:100%;">';
echo '<div class="ok-hilite" style="text-align:center;width:21%;float:left;margin-left:10px;margin-right:10px;">'. qText('OK/GOOD') .'</div>';
echo '<div class="warn" style="text-align:center;width:21%;float:left;margin-left:10px;margin-right:10px;">'. qText('WARNINGS') .'</div>';
echo '<div class="alert" style="text-align:center;width:21%;float:left;margin-left:10px;margin-right:10px;">'. qText('ALERTS') .'</div>';
echo '<div class="protected" style="text-align:center;width:21%;float:left;margin-left:10px;margin-right:10px;">[&nbsp;--&nbsp;'. qText('Protected') .'&nbsp;--&nbsp;]</div>';
echo '</div>';
echo '<div style="clear:both;"><br /></div>';


// SELECTIONS
echo '<div style="font-weight:bold;width:25%;float:left;text-align:center;">Developer-Mode<br />';
if ( defined ( '_FPA_DEV' ) ) {
    echo '<div class="normal-note">'. qText('Enabled') .'</div>';
} else {
    echo '<div class="normal-note">'. qText('Disabled') .' (<i style="color:#808080;">'. qText('Default') .'</i> )</div>';
}
echo '</div>';

echo '<div style="font-weight:bold;width:25%;float:left;text-align:center;">'. qText('Information Privacy') .'<br />';
if ( $showProtected == 1 ) {
    echo '<div class="normal-note"><span class="ok">'. qText('None') .'</span></div>';
} elseif ( $showProtected == 2 ) {
    echo '<div class="normal-note"><span class="warn-text">'. qText('Partial') .'</span> (<i style="color:#808080;">'. qText('Default') .'</i> )</div>';
} elseif ( $showProtected >= 3 ) {
    echo '<div class="normal-note"><span class="alert-text">'. qText('Strict') .'</span></div>';
}
echo '</div>';

echo '<div style="font-weight:bold;width:25%;float:left;text-align:center;">'. qText('Elevated Permissions') .'<br />';
if ( $showElevated == 1 ) {
    echo '<div class="normal-note">'. qText('Show') .'</div>';
} else {
    echo '<div class="normal-note">'. qText('Hide') .' (<i style="color:#808080;">'. qText('Default') .'</i> )</div>';
}
echo '</div>';

echo '<div style="font-weight:bold;width:25%;float:left;text-align:center;">'. qText('Table Structure') .'<br />';
if ( $showTables == '1' ) {
    echo '<div class="normal-note">'. qText('Show') .'</div>';
} else {
    echo '<div class="normal-note">'. qText('Hide') .' (<i style="color:#808080;">'. qText('Default') .'</i> )</div>';
}
echo '</div>';

echo '<div style="clear:both;"></div>';

echo '<div style="font-weight:bold;width:25%;float:left;text-align:center;">Diagnostic-Mode<br />';
if ( defined ( '_FPA_DIAG' ) ) {
    echo '<div class="normal-note">'. qText('Enabled') .'</div>';
} else {
    echo '<div class="normal-note">'. qText('Disabled') .' (<i style="color:#808080;">'. qText('Default') .'</i> )</div>';
}
echo '</div>';

echo '<div style="font-weight:bold;width:25%;float:left;text-align:center;">'. qText('Components') .'<br />';
if ( $showComponents == '1' ) {
    echo '<div class="normal-note">'. qText('Show') .'</div>';
} else {
    echo '<div class="normal-note">'. qText('Hide') .' (<i style="color:#808080;">'. qText('Default') .'</i> )</div>';
}
echo '</div>';

echo '<div style="font-weight:bold;width:25%;float:left;text-align:center;">'. qText('Modules') .'<br />';
if ( $showModules == '1' ) {
    echo '<div class="normal-note">'. qText('Show') .'</div>';
} else {
    echo '<div class="normal-note">'. qText('Hide') .' (<i style="color:#808080;">'. qText('Default') .'</i> )</div>';
}
echo '</div>';

echo '<div style="font-weight:bold;width:25%;float:left;text-align:center;">'. qText('Plugins') .'<br />';
if ( $showPlugins == '1' ) {
    echo '<div class="normal-note">'. qText('Show') .'</div>';
} else {
    echo '<div class="normal-note">'. qText('Hide') .' (<i style="color:#808080;">'. qText('Default') .'</i> )</div>';
}
echo '</div>';

echo '</div>';
echo '<div style="clear:both;"><br /></div>';

echo '<div style="text-align:center!important;">';
echo '<a style="color:#4D8000!important;" href="'. _RES_FPALINK .'">'. _RES_FPALATEST .' '. _RES .'</a>';
echo '</div>';
echo '</div>';
