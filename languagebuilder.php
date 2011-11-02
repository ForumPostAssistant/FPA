#!/usr/bin/php
<?php
/**
 * @package    EasyVerifyInstall
 * @subpackage Language checker
 * @author     Nikolai Plath (elkuku) {@link http://www.nik-it.de NiK-IT.de}
 * @author     Created on 06-Jan-2009
 * @license    GNU/GPL
 */

error_reporting(-1);

require_once 'functions.php';

$direct = false;

$silent = false;

if(isset($argv)
&& strstr($argv[0], basename(__FILE__)))
{
    $direct = true;

    if(isset($argv[1]) && '-s' == $argv[1])
    $silent = true;
}

defined('SFB_SILENT') || define('SFB_SILENT', $silent);

if($direct
|| $_SERVER['DOCUMENT_ROOT'].$_SERVER['SCRIPT_NAME'] == __FILE__)//direct call
{
    defined('DS') || define('DS', DIRECTORY_SEPARATOR);
    defined('NL') || define('NL', "\n");

    if('cli' == php_sapi_name())
    {
        defined('BR') || define('BR', "\n");
    }
    else
    {
        defined('BR') || define('BR', '<br />');
    }

    try
    {
        out('sfLanguageBuilder');
        out('=================');

        $config = simplexml_load_file('config.xml');

        if( ! $config)
        throw new Exception('Invalid config.xml');

        out('Looking for PHP files to check... ', false);

        $fileList = array('template.php');

        foreach ($config->replacements->file as $file)
        {
            if('php' != substr($file, strripos($file, '.') + 1))
            continue;

            $fileList[] = 'tpl/'.$file;
        }

        out('found '.count($fileList));

        $checker = new eviLangChecker($fileList, $config);

        out('Creating the template... ', false);

        $checker->createTemplate();

        out('OK');

        out('Creating / updating language files:');

        $checker->createUpdateAll();

        out();
        out('Finished =;)');
    }
    catch(Exception $e)
    {
        echo nl2br($e);
    }//try
}

/**
 * EVI Language checker.
 */
class EVILangChecker
{
    /*
     * Public vars
    */
    public $pattern = "/qText\(\s*\'(.*)\'|qText\(\s*\'(.*)\'\s*\)/iU";

    /*
     * Private vars
    */
    private $languages = array();

    private $base = '';

    private $strings = array();

    private $fileName = '';

    private $fileList = array();

    public function __construct($fileList = array(), $config = null)
    {
        $this->fileList = (array) $fileList;

        if(isset($config->languages->language))
        {
            foreach($config->languages->language as $language)
            {
                $this->languages[(string)$language->attributes()->tag] = (string)$language;
            }//foreach
        }

        $this->base = dirname(__FILE__);
    }//function

    public function createTemplate()
    {
        $template = $this->checkFiles();

        if( ! is_dir($this->base.'/g11n'))
        mkdir($this->base.'/g11n');

        $this->writeFile($this->base.'/g11n/template.pot', $template);
    }//function

    public function createUpdateAll()
    {
        foreach(array_keys($this->languages) as $tag)
        {
            $contents = implode("\n", $this->checkLanguage($tag));

            $this->writeFile($this->base.'/g11n/'.$tag.'.po', $contents);
        }//foreach
    }//function

    /**
     * Check source files for translatable strings.
     *
     * @return string
     */
    public function checkFiles()
    {
        foreach ($this->fileList as $path)
        {
            $fullPath = $this->base.'/template/'.$path;
            if( ! file_exists($this->base.'/'.$this->fileName))
            {
                echo 'File not found: '.$fullPath;
                continue;
            }

            $lines = file($fullPath);

            $founds = array();

            foreach($lines as $lineNum => $line)
            {
                preg_match_all($this->pattern, $line, $matches, PREG_SET_ORDER);

                if( ! $matches)
                continue;

                foreach($matches as $match)
                {
                    $s = $match[1];

                    if( ! isset($this->strings[$s]))
                    {
                        $this->strings[$s] = array();
                    }

                    $this->strings[$s][] = $path.':'.($lineNum + 1);
                }//foreach
            }//foreach
        }//foreach

        $options = array();
        $options['timeOffset'] = $this->getTimeOffset();

        $result = array();
        $result[] = $this->getHead($options);

        foreach($this->strings as $string => $entries)
        {
            foreach($entries as $found)
            {
                $result[] = '#: '.$found;
            }//foreach

            $result[] = 'msgid "'.$string.'"';
            $result[] = 'msgstr ""';
            $result[] = '';
        }//foreach

        return implode("\n", $result);
    }//function

    /**
     * Create or update a language file.
     *
     * @param string $lang
     * @throws Exception
     */
    public function checkLanguage($lang)
    {
        if( ! array_key_exists($lang, $this->languages))
        throw new Exception('Invalid language');

        if( ! $this->strings)
        $this->check();

        try
        {
            $translations = $this->parseFile($lang);
        }
        catch (Exception $e)
        {
            //-- New file
            $options = array();
            $options['timeOffset'] = $this->getTimeOffset();

            $translations = new stdClass;
            $translations->head = $this->getHead($options);
            $translations->strings = array();
        }//try

        out('Processing '.$lang.'... ', false);

        $result = array();

        $result[] = $translations->head;

        foreach($this->strings as $string => $entries)
        {
            foreach($entries as $found)
            {
                $result[] = '#: '.$found;
            }//foreach

            $result[] = 'msgid "'.$string.'"';

            $result[] =(array_key_exists($string, $translations->strings))
            ? 'msgstr "'.$translations->strings[$string]->string.'"'
            : 'msgstr ""';

            $result[] = '';
        }//foreach

        out('OK');

        return $result;
    }//function

    /**
     * Get a po file header.
     *
     * @param array $options
     */
    private function getHead($options)
    {
        return "
# SOME DESCRIPTIVE TITLE.
# Copyright (C) YEAR Free Software Foundation, Inc.
# FIRST AUTHOR <EMAIL@ADDRESS>, YEAR.
#
#, fuzzy
msgid \"\"
msgstr \"\"
\"Project-Id-Version: PACKAGE VERSION\\n\"
\"Report-Msgid-Bugs-To: wp-polyglots@lists.automattic.com\\n\"
\"POT-Creation-Date: ".date('Y-m-d H:i ').$options['timeOffset']."00\\n\"
\"PO-Revision-Date: 2010-MO-DA HO:MI+ZONE\\n\"
\"Last-Translator: FULL NAME <EMAIL@ADDRESS>\\n\"
\"Language-Team: LANGUAGE <LL@li.org>\\n\"
\"Content-Type: text/plain; charset=CHARSET\\n\"
\"Content-Transfer-Encoding: 8bit\\n\"
\"X-Generator: JALHOO\\n\"
\"MIME-Version: 1.0\\n\"
\"Plural-Forms: nplurals=INTEGER; plural=EXPRESSION;\\n\"
";
    }//function

    private function getTimeOffset()
    {
        $dateTimeZone = new DateTimeZone(date_default_timezone_get());
        $dateTime = new DateTime('now', $dateTimeZone);

        return $dateTimeZone->getOffset($dateTime) / 3600;
    }//function

    private function writeFile($path, $contents)
    {
        $pointer = fopen ($path, 'w');

        if( ! $pointer)
        throw new Exception('Can not open file at: '.$path);

        fwrite($pointer, $contents);

        fclose ($pointer);
    }//function

    /**
     * Parse a po style language file.
     *
     * @param string $fileName Absolute path to the language file.
     *
     * @return g11nFileInfo
     */
    public function parseFile($lang)
    {
        $ext =('template' == $lang) ? 'pot' : 'po';
        $fileName = $this->base.'/g11n/'.DS.$lang.'.'.$ext;

        if( ! file_exists($fileName))
        throw new Exception('language file not found');

        $fileInfo = new stdClass;//g11nFileInfo;

        $fileInfo->fileName = $fileName;
        $fileInfo->strings = array();

        if( ! file_exists($fileName))
        {
            return $fileInfo;//@todo throw exception
        }

        $lines = file($fileName);

        if( ! $lines)
        {
            return $fileInfo;//@todo throw exception
        }

        //-- Just in case add two empty lines to the end - bad parser ?..
        $lines[] = '';
        $lines[] = '';

        $msgid = '';
        $msgstr = '';
        $msg_plural = '';
        $msg_plurals = array();

        $head = '';

        $info = '';

        $state = -1;

        $stringsPlural = array();

        foreach($lines as $line)
        {
            $line = trim($line);

            if(0 === strpos($line, '#~'))
            continue;

            $match = array();

            switch($state)
            {
                case - 1 : //Start parsing
                    if( ! $line)
                    {
                        //-- First empty line stops header
                        $state = 0;
                    }
                    else
                    {
                        $head .= $line."\n";
                    }
                    break;
                case 0 : //waiting for msgid
                    if(preg_match('/^msgid "(.*)"$/', $line, $match))
                    {
                        $msgid = stripcslashes($match[1]);
                        $state = 1;
                    }
                    else
                    {
                        $info .= $line."\n";
                    }
                    break;
                case 1 : //reading msgid, waiting for msgstr
                    if(preg_match('/^msgstr "(.*)"$/', $line, $match))
                    {
                        $msgstr = stripcslashes($match[1]);
                        $state = 2;
                    }
                    else if(preg_match('/^msgid_plural "(.*)"$/', $line, $match))
                    {
                        $msg_plural = stripcslashes($match[1]);
                        $state = 1;
                    }
                    else if(preg_match('/^msgstr\[(\d+)\] "(.*)"$/', $line, $match))
                    {
                        $msg_plurals[stripcslashes($match[1])] = stripcslashes($match[2]);
                        $state = 1;
                    }
                    else if(preg_match('/^"(.*)"$/', $line, $match))
                    {
                        $msgid = stripcslashes($match[1]);
                    }
                    break;
                case 2 : //reading msgstr, waiting for blank
                    if(preg_match('/^"(.*)"$/', $line, $match))
                    {
                        $msgstr = stripcslashes($match[1]);
                    }
                    else if(empty($line))
                    {
                        if($msgstr)
                        {
                            //we have a complete entry
                            $e = new stdClass;
                            $e->info = $info;
                            $e->string = $msgstr;
                            $fileInfo->strings[$msgid] = $e;
                        }

                        $state = 0;
                        $info = '';
                    }
                    break;
            }//switch

            //comment or blank line?
            if(empty($line)
            || preg_match('/^#/', $line))
            {
                if($msg_plural)
                {
                    if($msg_plurals[0])
                    {
                        $t = new stdClass();
                        $t->plural = $msg_plural;
                        $t->forms = $msg_plurals;
                        $t->info = $info;
                        $fileInfo->stringsPlural[$msgid] = $t;
                    }

                    $msg_plural = '';
                    $msg_plurals = array();
                    $state = 0;
                }
            }
        }//foreach

        $fileInfo->head = $head;

        return $fileInfo;
    }//function
}//class
