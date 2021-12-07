<?php

//Methods that we going to use over and over.
class Db_object{

    public $errors = array();
    public $upload_errors_array = array(
        UPLOAD_ERR_OK           => "There is no error",
        UPLOAD_ERR_INI_SIZE		=> "The uploaded file exceeds the upload_max_filesize directive in php.ini",
        UPLOAD_ERR_FORM_SIZE    => "The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form",
        UPLOAD_ERR_PARTIAL      => "The uploaded file was only partially uploaded.",
        UPLOAD_ERR_NO_FILE      => "No file was uploaded.",               
        UPLOAD_ERR_NO_TMP_DIR   => "Missing a temporary folder.",
        UPLOAD_ERR_CANT_WRITE   => "Failed to write file to disk.",
        UPLOAD_ERR_EXTENSION    => "A PHP extension stopped the file upload."					
    ); // array end

   
    //Find all info at the same time
    public static function find_all(){
        // When we call static ( cant use static because other class )
        return static::find_by_query("SELECT * FROM " . static::$db_table . " ");
    }
    
    //Find by id
    //Calls the method find_this_query, sends him the sql code.
    public static function find_by_id($id){
        global $database;
        $the_result_array = static::find_by_query("SELECT * FROM " . static::$db_table . " WHERE id = $id LIMIT 1");
        
        // If it is not empty, than do the first array_shift, if it is empty than do
        // the second
        return !empty($the_result_array) ? array_shift($the_result_array) : false;
        /*        
        if(!empty($the_result_array)){
            //Grabs first item
            $first_item = array_shift($the_result_array);
            return $first_item;
        }else{
            return false;
        }
        */        
           
    }
    
    //Takes the information and sends to instantation, then return who called the method.
    //Goes to the database, finds it and than sends to instantation...
    public static function find_by_query($sql){
        global $database;
        
        $result_set = $database->query($sql);
        //Set array
        $the_object_array = array();
        //Takes every row-key
        while($row = mysqli_fetch_array($result_set)){
            $the_object_array[] = static::instantation($row);
        }
        return $the_object_array;
    }
    
    
    //Makes with names.
    public static function instantation($the_record){
        //No he going to instantation the other class User, not Db_object class
        //Takes a class that's calling this method
        $calling_class = get_called_class();
        //We set the class to a object
        $the_object = new $calling_class;
        
            //We can use like this.
            //$the_object->id = $found_user['id'];
            //$the_object->username = $found_user['username'];
            //$the_object->password = $found_user['password'];
            //$the_object->first_name = $found_user['first_name'];
            //$the_object->last_name = $found_user['last_name'];
            //return $the_object;
        
        foreach($the_record as $property => $value){
            if($the_object->has_the_attribute($property)){
                $the_object->$property = $value;
            }
        }
        return $the_object;
    }
    
    //We don't need to use out side the class.
	private function has_the_attribute($the_attribute) {

		// $object_properties = get_object_vars($this);
        // return array_key_exists($the_attribute, $object_properties);
        
        // property_exists — Checks if the object or class has a property 
		return property_exists($this, $the_attribute);
	}
    
    //Saves the properties DB, that we mentioned at the start
    public function properties(){
        //return get_object_vars($this);
        
        $properties = array();
        
        foreach(static::$db_table_fields as $db_field){
            
            //property_exists — Checks if the object or class has a property
            //$this -> object that calls with data
            //$db_field -> from class that is calling elements
            if(property_exists($this, $db_field)){
                $properties[$db_field] = $this->$db_field;
            }
            //var_dump($this->$db_field);exit;
        }
        //Return array with values and keys
        return $properties;
    }// End properties 
    
    //
    protected function clean_properties(){
        global $database;
        
        $clean_properties = array();
        // Looping through it, taking the key and value

        // Takes keys and elements.
        foreach($this->properties() as $key => $value){
            //We make it to let as use like SQL
            $clean_properties[$key] = $database->escape_string($value);
        }
        return $clean_properties;
    } // End clean_properties
        
    
    //Saves the info, when its created(When we have the id).
    //For example we update info. 
    public function save(){
        return isset($this->id) ? $this->update() : $this->create();
    }
    
    //Create method
    public function create(){
        global $database;
        
        $properties = $this->clean_properties();
        
        //We sql .= means that we combine.
        // implode - seperating each vaue in comma and than we use arra_key to take keys
        // keys are - username, password, first_name, last_name 
        $sql = "INSERT INTO " . static::$db_table . "(". implode(",", array_keys($properties)) .")";
        // We use this to take each value (1)
        $sql .= "VALUES ('". implode("','", array_values($properties)) ."')";
        
        /*
        // (2) Also we can do like this.
        $sql .= $database -> escape_string($this -> username)   . "', '";
        $sql .= $database -> escape_string($this -> password)   . "', '";
        $sql .= $database -> escape_string($this -> first_name) . "', '";
        $sql .= $database -> escape_string($this -> last_name)  . "')";
        */
        
        //send to database query method
        if($database->query($sql)){
            // Pull out and assigned
            $this -> id = $database -> the_insert_id();
            return true;
        }else{
            return false;
        }
    } //End create method
    
    //Updates the info.
    public function update(){
        global $database;
          
        /*
        //Variantas kaip galima rasyti
        $sql = "UPDATE " . self::$db_table . " SET ";
        $sql .= "username= '"   . $database->escape_string($this->username)     . "',";
        $sql .= "password= '"   . $database->escape_string($this->password)     . "',";
        $sql .= "first_name= '" . $database->escape_string($this->first_name)   . "',";
        $sql .= "last_name= '"  . $database->escape_string($this->last_name)    . "' ";
        $sql .= " WHERE id= "    . $database->escape_string($this->id);
        */
        
        //Call the method.
        $properties = $this -> clean_properties();
        //Make array
        $properties_pairs = array();
        
        //We can write like this.
        foreach($properties as $key => $value){
            $properties_pairs[] = "{$key}= '{$value}' ";
        }
        
        //Updates info.
        $sql = "UPDATE " . static::$db_table . " SET ";
        $sql .= implode(", ", $properties_pairs);
        $sql .= " WHERE id= "    . $database->escape_string($this->id);
        
        $database->query($sql);
        
        //Its like if, looks for and prints true or false.
        return (mysqli_affected_rows($database->connection) == 1) ? true : false;
        
    }//End update method
    
    //Delete the info
    public function delete(){
        global $database;
        
        $sql  = "DELETE FROM " . static::$db_table ." ";
        $sql .= " WHERE id=" . $database->escape_string($this->id);
        $sql .= " LIMIT 1";
        
        $database->query($sql);
        
        //Its like if, looks for and prints true or false.
        return (mysqli_affected_rows($database->connection) == 1) ? true : false;
        
    }//End Delete the info
    
    // Count photo or other thing.
    public static function count_all() {
        global $database;

        $sql = "SELECT COUNT(*) FROM " . static::$db_table;
        $result_set = $database->query($sql);
        $row = mysqli_fetch_array($result_set);

        return array_shift($row);
    }
    
}//Db_object end.
?>