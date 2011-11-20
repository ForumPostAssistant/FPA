#!/usr/bin/php
<?php
/**
 * @package    SingleFileBuilder
 * @subpackage Stand alone - Builder
 * @author     Nikolai Plath (elkuku) {@link http://www.nik-it.de NiK-IT.de}
 * @author     Created on 10-Sep-2010
 */

error_reporting(-1);

define('DS', DIRECTORY_SEPARATOR);
define('NL', "\n");

require_once 'functions.php';

$silent = false;

if('cli' == php_sapi_name())
{
    if(isset($argv))
    {
        if(isset($argv[1])
        && '-s' == $argv[1])
        $silent = true;
    }

    define('BR', "\n");
}
else
{
    define('BR', '<br />');
}

define('SFB_SILENT', $silent);

try
{
    out('SingleFileBuilder');
    out('=================');

    $config = simplexml_load_file('config.xml');

    if( ! $config)
    throw new Exception('Invalid config.xml');

    include 'languagebuilder.php';

    $ls = array();

    $templateContents = file_get_contents('template/template.php');

    //-- Replace replacements
    foreach ($config->replacements->file as $file)
    {
        out('Processing file '.$file.'...', false);

        $contents = file_get_contents('template/tpl/'.$file);

        if(0 === strpos($contents, '<?php'))
        $contents = substr($contents, 6);

        if($contents)
        $templateContents = str_replace('/**@@'.$file->attributes()->tag.'@@**/', $contents, $templateContents);

        out('OK');
    }//foreach

    //-- Process language
    if(isset($config->languages->language))
    {
        $ls = array("en-GB' => 'English");

        foreach($config->languages->language as $language)
        {
            $tag = (string)$language->attributes()->tag;

            if('en-GB' == $tag)
            continue;

            $ls[] = $tag."' => '".$language;
        }//foreach

        $definedLanguages = "'".implode("', '", $ls)."'";

//         $languageClass = file_get_contents('template/language.php');

//         if(0 === strpos($languageClass, '<?php'))
//         $languageClass = substr($languageClass, 6);


        $templateContents = str_replace('$sfBuilderDefinedLanguages = array('
        , '$sfBuilderDefinedLanguages = array('.$definedLanguages, $templateContents);
        $langBuilder = new EVILangChecker(array(), $config);

        $languageStrings = array();

        foreach($config->languages->language as $language)
        {
            $tag = (string)$language->attributes()->tag;

            out('Processing language '.$tag.'...', false);

            $fileInfo = $langBuilder->parseFile($tag);

            $s = '\''.$tag.'\' => \'';

            foreach ($fileInfo->strings as $key => $info)
            {
                $s .= $key.' = '.str_replace("'", "\'", $info->string).NL;
            }//foreach

            $s .= "'";

            $languageStrings[] = $s;

            out('OK ('.count($fileInfo->strings).' strings)');
        }//foreach

        $languageStrings = implode(', ', $languageStrings);

        $templateContents = str_replace('$sfBuilderStrings = array('
        , '$sfBuilderStrings = array('.$languageStrings, $templateContents);
    }

//     //-- Add the language class to the end of the file
//     if(isset($languageClass))
//     $templateContents .= NL.$languageClass;

    //-- Save the result
    $fileName = 'build/'.$config->resultfile;

    out('Saving to '.$fileName);

    file_put_contents($fileName, $templateContents);

    out();
    out('Finished =;)');

    exit(0);
}
catch (Exception $e)
{
    out($e->getMessage());

    exit(1);
}//try
