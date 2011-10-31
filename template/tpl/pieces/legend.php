<?php
/*
 * pieces/legend.php
 */
echo '<div class="snapshot-information" style="text-align:center;color:#4D8000!important;padding-top:10px;">';
echo '<span class="header-title">'. qText('Legends and Settings') .'</span>';
echo '<div style="width:85%;margin:0 auto;margin-top:10px;">';
// LEGENDS
echo '<div class="half-section-container" style="clear:both;width:100%;">';
echo '<div class="ok-hilite" style="text-align:center;width:21%;float:left;margin-left:10px;margin-right:10px;">'. _FPA_GOOD .'</div>';
echo '<div class="warn" style="text-align:center;width:21%;float:left;margin-left:10px;margin-right:10px;">'. _FPA_WARNINGS .'</div>';
echo '<div class="alert" style="text-align:center;width:21%;float:left;margin-left:10px;margin-right:10px;">'. _FPA_ALERTS .'</div>';
echo '<div class="protected" style="text-align:center;width:21%;float:left;margin-left:10px;margin-right:10px;">[&nbsp;--&nbsp;'. _FPA_HIDDEN .'&nbsp;--&nbsp;]</div>';
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

echo '<div style="font-weight:bold;width:25%;float:left;text-align:center;">'. _FPA_INFOPRI .'<br />';
if ( $showProtected == 1 ) {
    echo '<div class="normal-note"><span class="ok">'. _FPA_PRIVNON .'</span></div>';
} elseif ( $showProtected == 2 ) {
    echo '<div class="normal-note"><span class="warn-text">'. _FPA_PRIVPAR .'</span> (<i style="color:#808080;">'. qText('Default') .'</i> )</div>';
} elseif ( $showProtected >= 3 ) {
    echo '<div class="normal-note"><span class="alert-text">'. _FPA_PRIVSTR .'</span></div>';
}
echo '</div>';

echo '<div style="font-weight:bold;width:25%;float:left;text-align:center;">'. _FPA_ELEVPERM_TITLE .'<br />';
if ( $showElevated == 1 ) {
    echo '<div class="normal-note">'. _FPA_SHOW .'</div>';
} else {
    echo '<div class="normal-note">'. _FPA_HIDE .' (<i style="color:#808080;">'. qText('Default') .'</i> )</div>';
}
echo '</div>';

echo '<div style="font-weight:bold;width:25%;float:left;text-align:center;">'. _FPA_DBTBL_TITLE .'<br />';
if ( $showTables == '1' ) {
    echo '<div class="normal-note">'. _FPA_SHOW .'</div>';
} else {
    echo '<div class="normal-note">'. _FPA_HIDE .' (<i style="color:#808080;">'. qText('Default') .'</i> )</div>';
}
echo '</div>';

echo '<br style="clear:both;" />';

echo '<div style="font-weight:bold;width:25%;float:left;text-align:center;">Diagnostic-Mode<br />';
if ( defined ( '_FPA_DIAG' ) ) {
    echo '<div class="normal-note">'. qText('Enabled') .'</div>';
} else {
    echo '<div class="normal-note">'. qText('Disabled') .' (<i style="color:#808080;">'. qText('Default') .'</i> )</div>';
}
echo '</div>';

echo '<div style="font-weight:bold;width:25%;float:left;text-align:center;">'. _FPA_EXTCOM_TITLE .'<br />';
if ( $showComponents == '1' ) {
    echo '<div class="normal-note">'. _FPA_SHOW .'</div>';
} else {
    echo '<div class="normal-note">'. _FPA_HIDE .' (<i style="color:#808080;">'. qText('Default') .'</i> )</div>';
}
echo '</div>';

echo '<div style="font-weight:bold;width:25%;float:left;text-align:center;">'. _FPA_EXTMOD_TITLE .'<br />';
if ( $showModules == '1' ) {
    echo '<div class="normal-note">'. _FPA_SHOW .'</div>';
} else {
    echo '<div class="normal-note">'. _FPA_HIDE .' (<i style="color:#808080;">'. qText('Default') .'</i> )</div>';
}
echo '</div>';

echo '<div style="font-weight:bold;width:25%;float:left;text-align:center;">'. _FPA_EXTPLG_TITLE .'<br />';
if ( $showPlugins == '1' ) {
    echo '<div class="normal-note">'. _FPA_SHOW .'</div>';
} else {
    echo '<div class="normal-note">'. _FPA_HIDE .' (<i style="color:#808080;">'. qText('Default') .'</i> )</div>';
}
echo '</div>';

echo '</div>';
echo '<div style="clear:both;"><br /></div>';

echo '<div style="text-align:center!important;"><a style="color:#4D8000!important;" href="'. _RES_FPALINK .''. _RES_LANG .'" target="_github">'. _RES_FPALATEST .' '. _RES .'</a></div>';
echo '</div>';
