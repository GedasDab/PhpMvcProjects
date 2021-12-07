<?php include("includes/init.php"); ?>
<?php if(!$session->is_signed_in()) {redirect("login.php");} ?>
<!-- Navigation -->
<?php

//If no photo, redirect
if(empty($_GET['id'])){
    redirect("photos.php");
}

$photo = Photo::find_by_id($_GET['id']);

//We find photo, we delete
if($photo){
    $session->message("The photo {$photo->filename} has been deleted");
    $photo->delete_photo();
    redirect("photos.php");
}else{
    redirect("photos.php");
}


?>