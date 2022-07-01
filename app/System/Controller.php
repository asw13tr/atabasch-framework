<?php

namespace Atabasch\System;

class Controller{

    public function route(){
        return new Route();
    }

    public function request(){
        return new Request();
    }

    public function response(){
        return new Response();
    }

    public function input(){
        return new Input();
    }


}