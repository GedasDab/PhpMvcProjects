<?php
//Padarome ,kad butu open_db_connection leista prieiga.
require_once("new_config.php");
class Database{
    
  public $connection;
  public $db; 
    
    //Automatiskai atodaro
    function __construct(){
        $this->db = $this->open_db_connection();
    }
    
    public function open_db_connection(){
        //Pasitikriname ar veikia.
            //Galiam naudoti ir toki
            //$this -> connection = new mysqli(DB_HOST,DB_USER,DB_PASS,DB_NAME);
        //Bet sitas naujesnis, naujesne versija PHP veikia sitas.
        $this -> connection = new mysqli(DB_HOST,DB_USER,DB_PASS,DB_NAME);
        
        if($this->connection->connect_error) {
            die("Database connection failed" . $this->connection->connect_error);
        }

        return $this->connection;
    }
    
    public function query($sql){
        $result = $this->db->query($sql);
        $this->confirm_query($result);
        return $result;
    }
    
    private function confirm_query($result){
        //Patikrinimas
        if(!$result){
            die("Query failed" . $this->db->error);
        }   
    }
    
    //This function is used to create a legal 
    //SQL string that you can use in an SQL statement
    public function escape_string($string){
        $escaped_string = $this->db->real_escape_string($string);
        return $escaped_string;
    }
    
    public function the_insert_id(){
        return mysqli_insert_id($this->db);
    }
    
    //public function the_insert_id(){
        //return $this->connection->insert_id;
    //}
    
}

//Tokiu butu iskvieciami metodai.
$database = new Database();
//$database->open_db_connection();
?>
