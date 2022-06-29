<?php

namespace Atabasch\System;

class Application{

    /**
     * Yapıcı fonksiyon
     */
    public function __construct(){
        $this->init();
    }

    /**
     * Uygulama için gerekli kurulum işlemlerinin sırayla çalıştırılacağı method.
     *
     * @return void
     */
    private function init(): void{
        $this->loadConfigs();
    }

    /**
     * Uygulamayı çalıştıracak olan method
     *
     * @return void
     */
    public function run(): void{
        $this->getRoutes();
    }

    /**
     * app\Configs klasöri içindeki dosyaları çağırıp _CONFIG adındaki global değişkeni oluşturan method
     *
     * @return void
     */
    private function loadConfigs(): void{
        $pathFolder = realpath(__DIR__.'/../Configs');
        $files = array_diff( scandir($pathFolder), ['.', '..'] );

        $configs = [];
        foreach($files as $file){
            $key = substr($file, 0, -4);
            $configs[$key] = include( $pathFolder.'/'.$file);
        }

        $GLOBALS['_CONFIG'] = (object) $configs;
    }

    /**
     * Yönlendiricileri getiren fonksiyon
     *
     * @return void
     */
    private function getRoutes(): void{
        require(__DIR__.'/../routes.php');
    }




}