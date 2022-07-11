<?php

namespace Atabasch\Controllers\Admin;

use Atabasch\Core\Controller;
use Atabasch\Core\Request;
use Atabasch\Core\Response;

class Users extends Controller{


    public function list(){
        return Response::view('user', ['title' => 'Kullanıcı Sayfası'])->statusCode(301);

    }


    public function edit($username, $id){
        echo "Burası Admin içindeki User Controllerinin Edit methodu. USERNAME: $username ve ID: $id";
    }

}