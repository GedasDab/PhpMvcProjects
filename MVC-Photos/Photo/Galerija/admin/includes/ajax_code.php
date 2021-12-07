<?php require("init.php");

    $user = new User();

    //Show photo or even we can call it change photo
    if(isset($_POST['image_name'])) {
        $user->ajax_save_user_image($_POST['image_name'], $_POST['user_id']);
    }

    //Show info.
    if(isset($_POST['photo_id'])) {
        Photo::display_sidebar_data($_POST['photo_id']);
    }

?>