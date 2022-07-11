<?php

namespace Atabasch\Core;

class Request{

    /**
     * http yada https değeri döndürür.
     *
     * @return mixed
     */
    public static function scheme(): string{
        return $_SERVER['REQUEST_SCHEME'];
    }

    /**
     * Servisin çalıştığı port numarasını döndürür.
     *
     * @return mixed
     */
    public static function port(): string{
        return $_SERVER['SERVER_PORT'];
    }

    /**
     * Host adresini döndürür.
     *
     * @return string
     */
    public static function host(): string{
        return $_SERVER['HTTP_HOST'];
    }
    public static function domain(): string{ return static::host(); }

    /**
     * @return string
     */
    public static function hostWithScheme(): string{
        return $_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['HTTP_HOST'];
    }

    /**
     * Çalışan sayfanın QueryString içermeyen tam adresini döndürür.
     *
     * @return string
     */
    public static function url(): string{
        return $_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['HTTP_HOST'].explode('?', $_SERVER["REQUEST_URI"])[0];
    }

    /**
     * Çalışan sayfanın tam url adresini döndürür.
     *
     * @return string
     */
    public static function fullUrl(): string{
        return $_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['HTTP_HOST'].$_SERVER["REQUEST_URI"];
    }

    /**
     * Host adresi ve QueryString çıkarılmış url;
     *
     * @return string
     */
    public static function path(): string{
        $appUrl = self::scheme().'://'.(Config::get('app.url', null) ?? static::host());
        return rtrim(str_replace($appUrl, '', static::url()), '/');
    }

    /**
     * İstek yapılan sayfanın queryString değerini verir.
     *
     * @return mixed
     */
    public static function queryString(): string{
        return $_SERVER["QUERY_STRING"];
    }

    /**
     * QueryString eklenmil path bilgisi
     *
     * @return string
     */
    public static function pathWithQueryString(): string{
        return static::path() . (!static::queryString()? '': '?'.static::queryString());
    }

    /**
     * Request Method'u verir.
     *
     * @return string
     */
    public static function method(): string{
        return $_SERVER["REQUEST_METHOD"];
    }

    /**
     * Parametre oalrak gönderilen method isminin o an ki sayfanın methodu ile aynı olup olmadığını sorgular.
     *
     * @param string|array $method
     * @return bool
     */
    public static function isMethod($method='get'): bool{
        $methods = is_array($method)? $method : explode(',', $method);
        $methods = array_map(function($methodName){
            return strtoupper(trim($methodName));
        }, $methods);
        return in_array(static::method(), $methods);
    }

    /**
     * Path sorgulama
     *
     * @param string $path
     * @return string
     */
    public static function is(string $path): string{
        $path   = trim( trim( strtolower($path), '/') );
        $cPath  = trim( trim( strtolower(static::path()), '/') );
        return $path===$cPath;
    }

    /**
     * Client IP adresini verir.
     *
     * @return mixed
     */
    public static function ip(){
        if(isset($_SERVER["HTTP_CF_CONNECTING_IP"])){
            $_SERVER['REMOTE_ADDR'] = $_SERVER["HTTP_CF_CONNECTING_IP"];
            $_SERVER['HTTP_CLIENT_IP'] = $_SERVER["HTTP_CF_CONNECTING_IP"];
        }
        $client  = @$_SERVER['HTTP_CLIENT_IP'];
        $forward = @$_SERVER['HTTP_X_FORWARDED_FOR'];
        $remote  = $_SERVER['REMOTE_ADDR'];

        if(filter_var($client, FILTER_VALIDATE_IP)){
            $ip = $client;
        }elseif(filter_var($forward, FILTER_VALIDATE_IP)){
            $ip = $forward;
        }else{
            $ip = $remote;
        }
        return $ip;
    }


    public static function input(){
        return new Input();
    }


    public static function route(){

    }







}