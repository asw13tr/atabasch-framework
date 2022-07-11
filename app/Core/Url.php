<?php

namespace Atabasch\Core;

use Atabasch\Core\Config;

/*
 * Framework url işlemlerinin yapıldığı sınıf
 * */

class Url{


    /**
     * App için url adresi oluşturur.
     *
     * @param string $more
     * @return string
     */
    public static function get(string $more = ''): string{
        return trim(self::root(), '/').'/'.trim($more, '/');
    }


    /**
     * Aktif sayfanın o anki tam url adresini verir.
     *
     * @return string
     */
    public static function current(): string{
        return $_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
    }


    /**
     * App url adresini verir.
     *
     * @return string
     */
    public static function root(): string{
        $url = Config::get('app.url', Request::hostWithScheme());
        if(!preg_match('/^https?:\/\//i', $url)){
            $url = (Config::get('app.ssl', false)? 'https://' : 'http://') . $url;
        }
        return $url;
    }
    public static function app(): string{
        return self::root();
    }


    /**
     * Aktif url'nin "App Url" adresinden sonraki kısmı verir.
     * Eğer $keepQuery parametresi true gönderilirse ?x=y şeklindeki queryString bölümünü'de verir.
     *
     * @param bool $keepQuery
     * @return string
     */
    public static function requestUri(bool $keepQuery=false): string{
        $result = str_replace(self::root(), '', self::current());
        return $keepQuery? $result : explode('?', $result)[0];
    }


    /**
     * ? işaretinden sonra girilen get formatındaki query string'i verir
     *
     * @return string
     */
    public static function queryString(): string{
        return  $_SERVER['QUERY_STRING'];
    }


    /**
     * Request uri parçalarını verir (queryString Hariç)
     *
     * @return array
     */
    public static function requestUriParts(): array{
        $clearRequestUri = trim(self::requestUri(), '/');
        return explode('/', $clearRequestUri);
    }





}