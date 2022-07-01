<?php

namespace Atabasch\Controllers\Admin;

use Atabasch\System\Controller;

class Users extends Controller{


    public function list(){
        echo "Burası ADMIN içindeki Users Controllerının LIST methdu";
    }


    public function edit($username, $id){
        echo "Burası Admin içindeki User Controllerinin Edit methodu. USERNAME: $username ve ID: $id";
    }

}