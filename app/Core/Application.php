<?php

namespace Atabasch\Core;

class Application{


    /**
     * Uygulama için gerekli kurulum işlemlerinin sırayla çalıştırılacağı method.
     *
     * @return void
     */
    public static function init(): void{
        static::loadConfigs();

        // Posttan gelen verileri input sınıfı içerisinde al.
        Input::init();
    }

    /**
     * Uygulamayı çalıştıracak olan method
     *
     * @return void
     */
    public static function run(): void{
        self::init();

        static::getRoutes();
    }

    /**
     * app\Configs klasöri içindeki dosyaları çağırıp _CONFIG adındaki global değişkeni oluşturan method
     *
     * @return void
     */
    private static function loadConfigs(): void{
        $pathFolder = realpath(__DIR__.'/../Configs');
        $files = array_diff( scandir($pathFolder), ['.', '..'] );

        $configs = [];
        foreach($files as $file){
            $key = substr($file, 0, -4);
            $configs[$key] = include( $pathFolder.'/'.$file);
        }

        $GLOBALS['_CONFIG'] = (object) $configs;
        Config::init();
    }

    /**
     * Yönlendiricileri getiren fonksiyon
     *
     * @return void
     */
    private static function getRoutes(): void{
        require(__DIR__ . '/../Routes/web.php');
    }




}