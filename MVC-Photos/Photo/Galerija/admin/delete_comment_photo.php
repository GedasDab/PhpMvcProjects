<?php include("includes/init.php"); ?>
<?php if(!$session->is_signed_in()) {redirect("login.php");} ?>
<!-- Navigation -->
<?php

//If no photo, redirect
if(empty($_GET['id'])){
    redirect("comments.php");
}

$comment = Comment::find_by_id($_GET['id']);

//We find photo, we delete
if($comment){
    $session->message("The comment that was writen by {$comment->author} has been deleted");
    $comment->delete();
    redirect("comment_photo.php?id={$comment->photo_id}");
}else{
    redirect("comments_photo.php?id={$comment->photo_id}");
}


?>