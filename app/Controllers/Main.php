<?php

namespace Atabasch\Controllers;
use Atabasch\System\Controller;

class Main extends Controller{


    public function index(){
        echo "Main Controller içindeki <strong>index</strong> methodu";
        echo "<pre>";


    }


    public function show(){
        echo "Main Controller içindeki <strong>show</strong> methodu";
    }

    public function edit(int $id=null){
        echo "Main Controller içindeki <strong>edit</strong> methodu Parametre: <strong>$id</strong>";
    }

    public function delete(){
        echo "Main Controller içindeki <strong>delete</strong> methodu";
    }


}