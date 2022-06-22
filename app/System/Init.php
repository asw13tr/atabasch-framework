<?php

namespace Atabasch\System;

class Init{


    public function run(){
        $this->loadConfigs();
    }



    private function loadConfigs(){
        $pathFolder = realpath(__DIR__.'/../Configs');
        $files = array_diff( scandir($pathFolder), ['.', '..'] );

        $configs = [];
        foreach($files as $file){
            $key = substr($file, 0, -4);
            $configs[$key] = include( $pathFolder.'/'.$file);
        }

        $GLOBALS['_CONFIG'] = (object) $configs;
    }

}