<?php
namespace Atabasch\System;

/*
 * _CONFIG adındaki GLOBAL objeden değer almaya yarar.
 *
 * */

class Config{

    private $configs = null;

    function __construct(){
        $this->configs = $GLOBALS['_CONFIG'];
    }


    /* ------------------------------------------------------------------------------
     * This method get all config items
     * ------------------------------------------------------------------------------
     * $Config->all();
     *
     *
     * */
    public function all(){
        return $this->configs;
    }



    /* ------------------------------------------------------------------------------
     * Config dosyalarındaki değerleri getirir.
     * ------------------------------------------------------------------------------
     * $Config->get('key.key2.key...')
     * $Config->get('key-key2-key3')
     *
     * */
    public function get($configKeys = 'app'){
        $strKeys = str_replace(['.', ',', '->', '-', '=>', '>', '@', '#'], '.', $configKeys);
        $parts = explode('.',  $strKeys);
        $result = $this->configs;
        foreach($parts as $part){
            $result = $result->$part;
        }
        return $result;
    }



}