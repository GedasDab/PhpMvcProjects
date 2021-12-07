<?php
// DS-DIRECTORY_SEPARATOR its like \
// Makes and shows (echo INCLUDES_PATH;) directory of file.
defined('DS') ? null : define('DS', DIRECTORY_SEPARATOR);
define('SITE_ROOT','C:'.DS.'xampp'.DS.'htdocs'.DS.'Galerija');
defined('INCLUDES_PATH') ? null : define('INCLUDES_PATH', SITE_ROOT.DS.'admin'.DS.'includes');

//defined('IMAGES_PATH') ? null : define('IMAGES_PATH', SITE_ROOT.DS.'admin'.DS.'images');

//All works at the same time.
//Requires to work, more secure
require_once("function.php");
require_once("new_config.php");
require_once("database.php");
require_once("db_object.php");
require_once("user.php");
require_once("session.php");
require_once("photo.php");
require_once("comment.php");
require_once("paginate.php");
?>