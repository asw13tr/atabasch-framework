<?php

namespace Atabasch\Controllers;
use Atabasch\Core\Input;
use Atabasch\Core\Response;
use Atabasch\Core\Url;

class Main extends \Atabasch\Core\Controller{


    public function index(){
        $datas = [
            'users' => [
                ['id'=>1, 'name'=>'Furkan', 'job'=>'Programmer'],
                ['id'=>2, 'name'=>'Mehmet Akif', 'job'=>'Meuer'],
                ['id'=>3, 'name'=>'Ahmet', 'job'=>'Operator'],
                ['id'=>4, 'name'=>'Nurullah', 'job'=>'Programmer'],
                ['id'=>5, 'name'=>'Samet', 'job'=>'Teacher'],
            ]
        ];
        return Response::view('index', $datas);
    }


    public function about(){
        echo "Main Controller içindeki <strong>about</strong> methodu";
    }

    public function gallery($id){
        echo "Main Controller içindeki <strong>gallery</strong> methodu Parametre: $id";
    }

    public function contactPost(){
        echo "<pre>";
        print_r( Input::post('card,parent') );
    }

    public function contact(){

        Response::view('contact');
    }


}