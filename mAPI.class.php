<?php

/** 
* Main class for mAPI
* @author thiodor@gmail.com
*/

include realpath(dirname(__FILE__)) . '/mDB.class.php';

class mAPI {
  public $db;
  public $dbh;

  function __construct($options) {

    $this->db = new Database($options);
    $this->dbh=$this->db->getDb();
    
  }
  
 
}