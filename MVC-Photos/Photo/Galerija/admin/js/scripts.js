$(document).ready(function(){
var user_href;
var user_href_splitted;
var user_id;
var image_src;
var image_href_splitted;
var image_name;
var photo_id;
    // We make button false disable
    $(".modal_thumbnails").click(function(){
        /* prop takes attribute */
        $("#set_user_image").prop('disabled', false);
        user_href = $("#user-id").prop('href');
        user_href_splitted = user_href.split("=");
        user_id = user_href_splitted[user_href_splitted.length -1];

        image_src = $(this).prop("src");
        image_href_splitted = image_src.split("/");
        image_name = image_href_splitted[image_href_splitted.length -1];

        // Sitas yra photo_library_model data=echo id ten spausdinama
        // Tai mes pasiimame ta atributa
        photo_id = $(this).attr("data");

        $.ajax({
            url: "includes/ajax_code.php",
            data:{photo_id:photo_id},
            type: "POST",
            success:function(data) {
                if(!data.error) {
                    $("#modal_sidebar").html(data);	
                }
            }
        });

        //alert(image_name);
    });

    $("#set_user_image").click(function(){
        $.ajax({
            url: "includes/ajax_code.php",
            data:{
                image_name: image_name,
                user_id: user_id
            },
            type: "POST",
            success: function(data){
                if(!data.error) {
                    
                    $(".user_image_box a img").prop('src', data);

                    // Reload page
                    // location.reload(true);
                }
            }
        });
    });

    /* When we press in edit_php "Save" box , it toggle.  */
    $(".info-box-header").click(function(){

        // Save ,the small box opens fast
        $(".inside").slideToggle("fast");

        // When we press, then the arrow goes down.
        $("#toggle").toggleClass("glyphicon-menu-down glyphicon , glyphicon-menu-up glyphicon ");
    
    });

    /* When we try to delete photos.php a photo it shows alert */
    $(".delete_link").click(function(){

        return confirm("Are you sure you want to delete this item");
        
    });

});



tinymce.init({ selector: 'textarea' });
