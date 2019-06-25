<?
class Application {
  public function __construct(){
    $this->_set_reporting();
    $this->_unregister_globals();
	}

  private function _set_reporting(){
    error_reporting(E_ALL);
    if(DEBUG){
      ini_set('display_errors', 1);
    } else {
      ini_set('display_errors', 0);
      ini_set('log_errors', 1);
    }
  }

  private function _unregister_globals(){
    
  }
}
