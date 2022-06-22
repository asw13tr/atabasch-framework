<?php
class Session{


  public function set($key, $val=null){
    $_SESSION[$key] = $val;
  } // set



  // values require a array
  public function setMany($values){
    if(is_array($values)){
      foreach($values as $key => $val){
        $_SESSION[$key] = $val;
      }
    }
  } // setMany



  public function has($key){
    return isset($_SESSION[$key]);
  } // has



  public function get($key, $default="", $reqType=false){
    $result = $default;
    if(isset($_SESSION[$key])){
      $obj = $_SESSION[$key];

      switch (strtolower($reqType)) {
        case 'array':
            $result = is_array($obj)? $obj : $default; break;
        case 'integer':
            $result = is_integer($obj)? $obj : $default; break;
        case 'bool':
            $result = is_bool($obj)? $obj : $default; break;
        case 'object':
            $result = is_object($obj)? $obj : $default; break;
        default:
            $result = $obj;
        }

    }
    return $result;
  } // get



  public function delete($key){
    unset($_SESSION[$key]);
  } // delete



  public function destroy(){
    $_SESSION = null;
    session_destroy();
  } // destroy





}

?>
