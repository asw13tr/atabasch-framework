<?php

namespace Atabasch\Core;
use \Atabasch\Core\HttpStatusCode;
use Atabasch\Core\TemplateHelpers;

class Response{
    private static string $pathViews = __DIR__.'/../Views';

    private static string $urlPattern = '@^https?:\/\/|^ftp:\/\/|^www\.|\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}@imu';


    protected static function getSelf(){
        return new self();
    }


    /**
     * Status Codeları
     *
     * @return \Atabasch\Core\HttpStatusCode
     */
    public static function httpStatusCode(): \Atabasch\Core\HttpStatusCode{
        return new HttpStatusCode();
    }

    /**
     * Statuscode değil yada al
     *
     * @param $code
     * @return Response
     */
    public static function statusCode($code=null): Response|int{
        if(!$code){
            return http_response_code();
        }else{
            http_response_code($code);
        }
        return self::getSelf();
    }

    /**
     * Views dizininden php dosyaları çalıştırır.
     *
     * @param string|null $viewFileName views dizini içinde var olan bir php dosya adı.
     * @param array $datas çalıştırılan view dosyası içinde kullanılacak değişkenler dizisi.
     * @param int $statusCode
     * @return Response
     */
    public static function initTwig(string $viewFileName=null){
        $loader     = new \Twig\Loader\FilesystemLoader(self::$pathViews);
        $twig       = new \Twig\Environment($loader);

        self::setTwigFunctions($twig);

        $filename   = basename($viewFileName, '.html').'.html';
        return (object) [
           'template'   => $twig->load($filename),
           'filename'   => $filename
        ] ;
    }
    public static function setTwigFunctions($twig){
        $twig->addFunction(new \Twig\TwigFunction('url', function(string $more=null) {
            return Url::get($more);
        }));
    }
    public static function view(string $viewFileName=null, array $datas=[], int $statusCode=200): Response{
        $twig = self::initTwig($viewFileName);

        self::statusCode($statusCode);
        if(!file_exists(self::getFilePath($twig->filename))){
            echo "Not found: ".self::getFilePath($twig->filename);
        }else{
            $datas = array_merge([], $datas);
            echo $twig->template->render($datas);
        }
        return self::getSelf();
    }

    /**
     * View dosyası php uzantısı düzenleme
     *
     * @param string $fileName
     * @return string
     */
    private static function getFilePath(string $fileName=''): string{
        return trim(self::$pathViews, '/').'/'.$fileName;
    }

    /**
     * Datas değişkenini ekrana json formatında basar.
     *
     * @param array $datas
     * @return Response
     */
    public static function json(array $datas=[]): Response{
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($datas);
        return self::getSelf();
    }

    /**
     * Bir dosya indirme sayfası oluşturur.
     *
     * @param string $fileUrl
     * @param string|null $fileName
     * @return $this
     */
    public static function download(string $fileUrl, string $fileName=null): Response{
        $fileName = $fileName ?? basename($fileUrl);
        header('Content-Type: application/octet-stream');
        header("Content-Transfer-Encoding: Binary");
        header("Content-disposition: attachment; filename=\"" .$fileName. "\"");
        readfile($fileUrl);
        return self::getSelf();
    }

    public static function redirect(string $urlOrPath='', int $time=0, int $responseCode=0): Response{
        $redirectUrl = $urlOrPath;
        if(!preg_match(self::$urlPattern, $urlOrPath)){
            $redirectUrl = Url::get($urlOrPath);
        }

        if($time<1){
            header('Location:'.$redirectUrl, true, $responseCode);
        }else{
            header("Refresh:{$time}; url={$redirectUrl}", true, $responseCode);
        }
        return self::getSelf();
    }


}