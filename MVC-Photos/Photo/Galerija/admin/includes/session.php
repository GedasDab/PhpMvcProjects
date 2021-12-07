<?php
//Everyone to check the user is on ir not, check everything. 
class Session {
    // In method to check
    private $signed_in = false;
    //Be going to use somewhere more
    public $user_id;
    //Message
    public $message;
    // count visitors
    public $count;
    
    //Calling automaticly
    function __construct(){
        session_start();
        $this->visitor_count();
        $this->check_the_login();
        $this->check_message();
    }



    public function visitor_count(){
        if(isset($_SESSION['count'])){
            return $this->count = $_SESSION['count']++;
        }else{
            return $_SESSION['count'] = 1;
        }
    }
    
    //Gather function, get a private value
    //Check is the user online or not.
    //return true or false, depending on the situation
    public function is_signed_in(){
        //Public method we can use everywhere
        //If we get false, that means not signed
        return $this->signed_in;
    }
    
    public function login($user){
        if($user){
            //We asigning user_id at the same time and Session
            $this->user_id = $_SESSION['user_id'] = $user->id;
            $this->signed_in = true;
        }
    }
    
    //Log out
    public function logout(){
        unset($_SESSION['user_id']);
        unset($this->user_id);
        $this->signed_in = false;
    }
    
    //The section is set
    private function check_the_login(){
        //If the issetion is equil user_id
        if(isset($_SESSION['user_id'])){
            //We apply
            $this->user_id = $_SESSION['user_id'];
            $this->signed_in = true;
        }else{
            unset($this->user_id);
            $this->signed_in = false;
        }
    }
    
    // Messages
    public function message($msg="") {
        //Check is empty or not
		if(!empty($msg)) {
			$_SESSION['message'] = $msg;
		} else {
			return $this->message;
		}

    }
    
    //Cheking message.
    private function check_message(){

	 	if(isset($_SESSION['message'])) {
	 	    $this->message = $_SESSION['message'];
	 	    unset($_SESSION['message']);
	 	} else {
	 		$this->message = "";
	 	}
	}
    
}
//To use this word.
$session = new Session();
$message = $session->message();

?>