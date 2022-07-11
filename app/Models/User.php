<?php

namespace Atabasch\Models;
use Atabasch\Core\Model;

class User extends Model {

    public $table = 'users';
    public $primaryKey = 'id';
    public $columns =  ['username', 'password', 'email'];
    public $createdColumn = "c_time";
    public $updatedColumn = "u_time";
    public $deletedColumn = "d_time";


    public function create(){
        $this->create($this);
    }



}