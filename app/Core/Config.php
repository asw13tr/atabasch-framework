<?php
namespace Atabasch\Core;

/*
 * _CONFIG adındaki GLOBAL objeden değer almaya yarar.
 *
 * */

class Config{

    private static $configs = [];

    public static function init(){
        self::$configs = $GLOBALS['_CONFIG'];
    }


    /* ------------------------------------------------------------------------------
     * This method get all config items
     * ------------------------------------------------------------------------------
     * $Config->all();
     *
     *
     * */
    public static function all(){
        return self::$configs;
    }


    /* ------------------------------------------------------------------------------
     * Config dosyalarındaki değerleri getirir.
     * ------------------------------------------------------------------------------
     * $Config->get('key.key2.key...')
     * $Config->get('key-key2-key3')
     *
     * */
    public static function get($configKeys = 'app', $default=null){
        $strKeys = str_replace(['.', ',', '->', '-', '=>', '>', '@', '#'], '.', $configKeys);
        $parts = explode('.',  $strKeys);
        $result = self::$configs;
        foreach($parts as $part){
            $result = $result->$part ?? $default;
        }
        return $result;
    }



}