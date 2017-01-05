<?php

/** 
* Main class for mAPI
* @author thiodor@gmail.com
*/

include realpath(dirname(__FILE__)) . '/mDB.class.php';
include realpath(dirname(__FILE__)) . '/mPagination.class.php';

class mAPI {
  public $db;
  public $dbh;
  public $pagination;
  private $paths = array();

  function __construct($options) {

    $this->db = new Database($options);
    $this->dbh=$this->db->getDb();
    $this->pagination = new Pagination();
  }

  public function request() {
    $uri = $_SERVER['REQUEST_URI'];
    $method = $_SERVER['REQUEST_METHOD'];
   
    $paths = explode('/', $this->paths($uri));
    array_shift($paths); // Hack; get rid of initials empty string
    
    $this->paths = $paths;
    array_shift( $this->paths );
		
    $resource = array_shift($paths);

    //We only accept call under /api endpoint
		if ($resource == 'api') {
      $this->handle_name($method, $this->paths);
		} else {
			// We only handle resources under 'api'
			header('HTTP/1.1 404 Not Found');
		}

  }

  private function handle_name($method, $name) {
    switch ($method) {
      case 'GET':
       
      break;

      case 'POST':

      break;
    }    
  }

  private function paths($url) {
		$uri = parse_url($url);
		return $uri['path'];
	}
  
}

$options = array(
      'database' => '',
      'username' => '',
      'password' => ''
      );

$myApi = new mAPI($options);
