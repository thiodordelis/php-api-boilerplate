<?php 

/**
* DB class
* @author thiodor@gmail.com
*/

class Database
{
  protected $options;
  public $db;

  public function __construct($options = null, $initialize = true) {
    $this->options = array();

    $this->options = $options;
    if ($initialize) {
      $this->initialize();
    }
  }

  public function __destruct() {
    //$this->db->close();
  }

  /* 
  * Initialize DB connection 
  **/
  protected function initialize() {
    try {
      $this->db = new PDO("mysql:host=localhost;dbname=".$this->options['database'].";charset=utf8", $this->options['username'], $this->options['password']);
		  $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		  $this->db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
		  $this->db->setAttribute(PDO::ATTR_EMULATE_PREPARES, true);
		  $this->db->setAttribute(PDO::MYSQL_ATTR_USE_BUFFERED_QUERY,true);
    } catch(PDOException $e) {
      throw new Exception("Error Processing Request ".$e, 1);           
    }
  }

  public function getDb() {
    if ($this->db instanceof PDO) {
      return $this->db;
    }
  }

  /* 
  * @desc query the DB  
  * @param string $table
  * @param string $sql - User defined query. If contains parameters, user $parameters
  * @param array $parameters - Parameters to use in the sql query, like :id or :user
  * @return array with rows
  **/
  public function query(string $table="",string $sql="",array $parameters):array {
    $sql = (empty($sql)?"SELECT * FROM ".$table : $sql);
    $query = $this->db->prepare($sql);
    $query->execute( $parameters );
    $result = $query->fetchAll(\PDO::FETCH_OBJ);
    return $result;
  }

}

?>