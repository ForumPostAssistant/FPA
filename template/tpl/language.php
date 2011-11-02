<?php
/* @version SVN $Id: language.php 567 2011-10-30 17:52:44Z elkuku $ */

/**
 * Small multilanguage function.
 *
 * @param string $original Text to translate.
 * @param if additional paramaters are supplied, the function behaves like sprintf.
 *
 * @return string Translated text or original if not found
 */
function qText($original)
{
    $translated = qLanguage::translate($original);

    if(func_num_args() > 1)
    {
        //-- Treat it as sprintf
        $args = func_get_args();

        $args[0] = $translated;

        return call_user_func_array('sprintf', $args);
    }

    return $translated;
}//function

/**
 * Language handling class.
 */
abstract class qLanguage
{
    protected static $lang = '';

    protected static $strings = array();

    protected static $untranslateds = array();

    public static function loadLanguage($lang)
    {
        //-- Get the 'raw' language file
        self::parseStrings(getPredefinedLanguageStrings($lang));

        self::$lang = $lang;
    }//function

    public static function translate($string)
    {
        //short: return (isset(self::$strings[$string]) ? self::$strings[$string] : $translated;

        if(isset(self::$strings[$string]))
        {
            //-- Translation found
            $translated = self::$strings[$string];
        }
        else//
        {
            //-- No translation found
            $translated = $string;

            //-- Record untranslated string
            self::$untranslateds[] = $string;
        }

        return $translated;
    }//function

    public static function getUntranslateds()
    {
        return self::$untranslateds;
    }//function

    public static function getLangTag()
    {
        return self::$lang;
    }//function

    protected static function parseStrings($strings)
    {
        foreach($strings as $line)
        {
            $line = trim($line);

            //-- Blank
            if( ! $line)
            continue;

            $pos = strpos($line, '=');

            //-- Other invalid ?
            if( ! $pos)
            continue;

            $key = trim(substr($line, 0, $pos));
            $value = trim(substr($line, $pos + 1));

            self::$strings[$key] = $value;
        }//foreach
    }//function
}//class

/**
 * Get the contents of a language file.
 *
 * Strings will be auto filled by a build script.
 *
 * @param string $lang The language to load - e.g. de-DE
 *
 * @return array
 * @throws Exception
 */
function getPredefinedLanguageStrings($lang)
{
    if( ! $lang || 'en-GB' == $lang) return array();

    //-- AutoFilled
    $sfBuilderStrings = array();//AutoFilled

    if( ! array_key_exists($lang, $sfBuilderStrings))
    throw new Exception('Language not found'.$lang);//-- Do not translate

    return explode("\n", $sfBuilderStrings[$lang]);
}//function
