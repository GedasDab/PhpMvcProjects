<?php include("includes/header.php"); ?>
<?php if(!$session->is_signed_in()) {redirect("login.php");} ?>

<?php

$message = "";
    if(isset($_FILES['file'])){
        //cheking the button
        //echo "<h1>Hello</h1>";
        
        $photo = new Photo();
        //take from HTML and saves it.
        $photo->title = $_POST['title'];
        $photo->user_id = $_SESSION['user_id'];

        $photo->set_file($_FILES['file']);
        
        if($photo->save()){
            $message = "Photo uploaded Successfully";
        }else{
            //Display error
            $message = join ("<br>", $photo->errors);
        }
    }

?>

<!-- Navigation -->
<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
    <!-- Brand and toggle get grouped for better mobile display -->

    <?php include("../admin/includes/top_nav.php"); ?>

    <!-- Sidebar Menu Items - These collapse to the responsive navigation menu on small screens -->

    <?php include("../admin/includes/side_nav.php"); ?>

    <!-- /.navbar-collapse -->
</nav>



<div id="page-wrapper">


    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">
                    Upload
                    <small>Subheading</small>
                </h1>

                <div class="col-md-6">
                    <?php echo $message; ?>
                    <form action="upload.php" method="post" enctype="multipart/form-data">

                        <div class="form-group">

                            <input type="text" name="title" class="form-control">

                        </div>

                        <div class="form-group">

                            <input type="file" name="file">

                        </div>

                        <input type="submit" name="submit">

                    </form>
                </div>
            </div>
        </div>
        <!-- /.row -->

        <div class="row">
            <div class="col-lg-12">
                <form action="upload.php" class="dropzone"></form>
            </div>
        </div>

    </div>
    <!-- /.container-fluid -->
</div>
<!-- /#page-wrapper -->

<?php include("includes/footer.php"); ?>