<?php
/**
 * @version $Id: builder.php 567 2011-10-30 17:52:44Z elkuku $
 * @package    SingleFileBuilder
 * @subpackage Stand alone - Builder
 * @author     Nikolai Plath (elkuku) {@link http://www.nik-it.de NiK-IT.de}
 * @author     Created on 10-Sep-2010
 */

error_reporting(-1);

define('DS', DIRECTORY_SEPARATOR);
define('NL', "\n");

if('cli' == php_sapi_name())
{
    define('BR', "\n");
}
else
{
    define('BR', '<br />');
}

try
{
    echo 'SingleFileBuilder'.BR;

    $options = parse_ini_file('builder.ini', true);

    if( ! $options)
    throw new Exception('Invalid builder.ini');

    include 'languagebuilder.php';

    $ls = array("en-GB' => 'English");

    foreach($options['languages'] as $lang => $name)
    {
        if($lang != 'en-GB')
        {
            $ls[] = $lang."' => '".$name;
        }
    }//foreach

    $definedLanguages = "'".implode("', '", $ls)."'";

    $languageClass = file_get_contents('template/language.php');

    if(0 === strpos($languageClass, '<?php'))
    $languageClass = substr($languageClass, 6);

    $templateContents = file_get_contents('template/template.php');

    $templateContents = str_replace('$sfBuilderDefinedLanguages = array('
    , '$sfBuilderDefinedLanguages = array('.$definedLanguages, $templateContents);

    foreach ($options['replacements'] as $replacement => $commandString)
    {
        $command = substr($commandString, 0, strpos($commandString, ':'));

        $cOptions = substr($commandString, strpos($commandString, ':') + 1);

        switch ($command)
        {
            case 'file' :
                $contents = file_get_contents('template/tpl/'.$cOptions);

                echo 'Processing file '.$cOptions.'...';

                if(0 === strpos($contents, '<?php'))
                $contents = substr($contents, 6);
                break;

            default:
                $contents = '';
            echo 'Processing '.$command.' - '.$cOptions.'...';
            break;
        }//switch

        if($contents)
        $templateContents = str_replace('/**@@'.$replacement.'@@**/', $contents, $templateContents);

        echo 'OK'.BR;
    }//foreach

    $templateContents .= NL.$languageClass;

    $langBuilder = new EVILangChecker(array(), $options);

    $languageStrings = array();

    foreach ($options['languages'] as $tag => $langName)
    {
        echo 'Processing language '.$tag.'...';

        $fileInfo = $langBuilder->parseFile($tag);

        $s = '\''.$tag.'\' => \'';

        foreach ($fileInfo->strings as $key => $info)
        {
            $s .= $key.' = '.$info->string.NL;
        }//foreach

        $s .= "'";

        $languageStrings[] = $s;

        echo 'OK ('.count($fileInfo->strings).' strings)'.BR;
    }//foreach

    $languageStrings = implode(', ', $languageStrings);

    $templateContents = str_replace('$sfBuilderStrings = array('
    , '$sfBuilderStrings = array('.$languageStrings, $templateContents);

    $fileName = 'build/'.$options['common']['result_file_name'];

    echo 'Saving to '.$fileName.BR;

    file_put_contents($fileName, $templateContents);

    echo 'Finished =;)'.BR;

    exit(0);
}
catch (Exception $e)
{
    echo $e->getMessage();

    exit(1);
}//try
