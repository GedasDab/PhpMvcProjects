<?php

class User extends Db_object{
    //We use one word, that works with all methods, if we change something, we need to 
    //change here, thats our table name.
    //clean_properties and proterties , they actually looping through this.
    protected static $db_table = "users";
    protected static $db_table_fields = array('username','password','first_name','last_name', 'user_image');
    public $id;
    public $username;
    public $password;
    public $first_name;
    public $last_name;
    public $user_image;
    // We save the first files name
    public $upload_directory = "images";



    public function set_file($file) { 

        if(empty($file) || !$file || !is_array($file)) {
            // Save the error.
            $this->errors[] = "There was no file uploaded here";
            return false;
        }elseif($file['error'] !=0) {
            // Save the error if we have.
            $this->errors[] = $this->upload_errors_array[$file['error']];
            return false;
        } else {
            // Save the information of the file.
            $this->user_image =  basename($file['name']);
            $this->tmp_path = $file['tmp_name'];
            $this->type     = $file['type'];
            $this->size     = $file['size'];
        }
    }

    //Example how to put photo.
    public $image_placeholder = "http://placehold.it/400x400&text=image";

    public function image_path_and_placeholder(){
        // If statement. After $this we don't need $ word 
        return empty($this->user_image) ? $this->image_placeholder : $this->upload_directory .DS. $this->user_image;
    }
    
    //Find user
	public static function verify_user($username, $password) {
		global $database;

        //Creates SQL that we can use it.
		$username = $database->escape_string($username);
		$password = $database->escape_string($password);

		$sql = "SELECT * FROM  " . self::$db_table . " WHERE ";
		$sql .= "username = '{$username}' ";
		$sql .= "AND password = '{$password}' ";
		$sql .= "LIMIT 1";

		$the_result_array = self::find_by_query($sql);
        //If not empty we do array shift if not, return false.
		return !empty($the_result_array) ? array_shift($the_result_array) : false;
    }
         

    public function upload_photo() 
    {       
        //if empty we are good, if not empty, we will get error
        if(!empty($this->errors)) {
            return false;
        }
        //Is file name empty ir path we check
        if(empty($this->user_image) || empty($this->tmp_path)){
            $this->errors[] = "the file was not available";
            return false;
        }

        // Site_Root our all path, DS its \ , file admin \ images our file \ file name
        $target_path = SITE_ROOT . DS . 'admin' . DS . $this->upload_directory . DS . $this->user_image;
        
        //Check the file, path
        if(file_exists($target_path)) {
            $this->errors[] = "The file {$this->user_image} already exists";
            return false;
        }
        
        //Move the file.
        if(move_uploaded_file($this->tmp_path, $target_path)) {
            //Check the file.
                unset($this->tmp_path);
                return true;
        //check was the file created
        } else {
            $this->errors[] = "the file directory probably does not have permission";
            return false;
        }
            
    }// end save function

    public function ajax_save_user_image($user_image, $user_id) {

		global $database;
        // Delete gaps.
		$user_image = $database->escape_string($user_image);
		$user_id = $database->escape_string($user_id);
        //Set data.
		$this->user_image = $user_image;
		$this->id         = $user_id;

		$sql  = "UPDATE " . self::$db_table . " SET user_image = '{$this->user_image}' ";
		$sql .= " WHERE id = {$this->id} ";
		$update_image = $database->query($sql);

		echo $this->image_path_and_placeholder();
    }

    public function delete_photo(){
        // Delete photo. If does it.
        if($this->delete()){
            // Delete the file.
            $target_path = SITE_ROOT.DS. 'admin' . DS . $this->upload_directory . DS . $this->user_image;

            return  unlink($target_path) ? true : false;
        }else{

            return false;

        }
    }

    public function photos(){
        return Photo::find_by_query("SELECT * FROM photos WHERE `user_id`=".$this->id);
    }
    
} //End class User


?>