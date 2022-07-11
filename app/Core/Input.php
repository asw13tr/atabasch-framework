<?php

namespace Atabasch\Core;

class Input{

    /**
     * Post'dan gelen verilerin atanacağı sınıf değişkeni
     *
     * @var array
     */
    private static $postDatas = [];

    /**
     * Yapıcı method post ile gelen verileri postDatas değişkenine atar.
     *
     */
    public static function init(){
       $datas = (count($_POST)>0)? json_encode($_POST) : file_get_contents("php://input");
        self::$postDatas = json_decode($datas, true);
    }

    /**
     * QueryString verilerini alır.
     *
     * @param $key
     * @param $default
     * @return string
     */
    public function get($key=null, $default=null): mixed{
        if(!$key){
            return $_GET;
        }else{
            return $_GET[$key] ?? $default;
        }
    }

    /**
     * Post'dan gelen değerleri alır.
     *
     * @param string|null $index
     * @param $default
     * @return false|mixed|string
     */
    public static function post(string $index=null, $default=null): mixed
    {
        if(!$index){
            return self::$postDatas;
        }elseif(preg_match('@->|\.|,@', $index)){
            return self::getPostDataFromArray(self::getIndexParts($index), $default);
        }else{
            return self::$postDatas[$index];
        }
    }

    /**
     * Posttan gelen verileri almak için key.key2.key3 mantığı ile girilen değerleri parçalayıp bir dizi yapar.
     *
     * @param string $key
     * @return array
     */
    private static function getIndexParts(string $key): array{
        $keys = preg_replace('/\s+/im', '', $key);
        $keys = str_replace(['->', '-', ','], '.', $keys);
        $keys = trim($keys, '.');
        return explode('.', $keys);
    }

    /**
     * Post verilerinin iç içe dizi mantığıyla alınmasını sağlar.
     *
     * @param string $indexes
     * @param $default
     * @return false|mixed|string
     */
    private static function getPostDataFromArray(array $indexes, $default): mixed{
        $result = self::$postDatas;
        foreach($indexes as $index){
            if(empty($result[$index])){
                $result = $default;
                break;
            }
            $result = $result[$index];
        }
        return $result;
    }

}