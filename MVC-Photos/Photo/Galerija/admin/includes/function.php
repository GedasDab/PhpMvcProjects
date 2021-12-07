<?php
    /*
    //It can be written.
    // Scaning aplication and looking for underclare, works like constructor
    function __autoload($class){
        $class = strtolower($class);
        //Needs a path.
        $the_path = "includes/{$class}.php";
        //When there is a mistake, the file name comes here and print in class, than
        // there is a full path, that means this path finds the file and makes no error.
        if(file_exists($the_path)){
            // Makes sure it calls one, if not, big error.
            require_once($the_path);
        }else{
            die("The file name {$class}.php was not found...");
        }
    }
    */

    //Does the same thing, but does more, more function
    // Its safety, if we forget to include the file.
    function classAutoLoader($class){
        $class = strtolower($class);
        //Needs a path.
        $the_path = "includes/{$class}.php";
        if(is_file($the_path) && !class_exists($class)){
            include $the_path;
        }else{
            die("This file name {$class}.php was not found");
        }
    }
    spl_autoload_register('classAutoLoader');

    function redirect($location){
        
        header("Location: {$location}");
        
    }

?>
