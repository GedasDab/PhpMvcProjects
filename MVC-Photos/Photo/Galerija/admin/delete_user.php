<?php include("includes/init.php"); ?>
<?php if(!$session->is_signed_in()) {redirect("login.php");} ?>
<!-- Navigation -->
<?php

//If no user, redirect
if(empty($_GET['id'])){
    redirect("users.php");
}

// We use class User that extends Db_object.
$user = User::find_by_id($_GET['id']);

//We find user, we delete
if($user){
    $session->message("The user has been deleted");
    //$user->delete();
    $user->delete_photo();
    redirect("users.php");
}else{
    redirect("users.php");
}


?>