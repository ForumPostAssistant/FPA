<?php
function out($string = '', $return = true)
{
    if(SFB_SILENT)
    return;

    echo $string;

    echo ($return) ? BR : '';
}//function
