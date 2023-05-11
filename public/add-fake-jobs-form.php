<?php
include_once('includes/functions.php');
$function = new functions;
include_once('includes/custom-functions.php');
$fn = new custom_functions;



?>
<?php
if (isset($_POST['btnAdd'])) {
        $title = $db->escapeString(($_POST['title']));
        $error = array();
       
        
        if (empty($title)) {
            $error['title'] = " <span class='label label-danger'>Required!</span>";
        }
        if (empty($_FILES['image']['name'])) {
            $error['image'] = " <span class='label label-danger'>Required!</span>";
        }
    }
           
       if (!empty($title)) 
        {

       if (isset($_FILES['image']) && !empty($_FILES['image']) && $_FILES['image']['error'] == 0 && $_FILES['image']['size'] > 0 && isset($_POST['title']) && !empty($_POST['title'])) {
           if (!is_dir('../upload/image/')) {
               mkdir('../upload/image/', 0777, true);
           }
           $image = $db->escapeString($fn->xss_clean($_FILES['image']['name']));
           $extension = pathinfo($_FILES["image"]["name"], PATHINFO_EXTENSION);
           $result = $fn->validate_image($_FILES["image"]);
           if (!$result) {
               $error['image'] = " <span class='label label-danger'>Image type must be jpg, jpeg, gif, or png!</span>";
           } else {
               $image_name = microtime(true) . '.' . strtolower($extension);
               $full_path = '../upload/image/' . $image_name;
               $upload_image2 = 'upload/image/' . $image_name;
               if (!move_uploaded_file($_FILES["image"]["tmp_name"], $full_path)) {
                   $error['image'] = " <span class='label label-danger'>Invalid directory to upload image!</span>";
               } else {
                   $title = $db->escapeString($_POST['title']);
                   $sql_query = "INSERT INTO fake_jobs (title,image) VALUES ('$title','$upload_image2')";
                   $db->sql($sql_query);
                   $result = $db->getResult();
                   if (!empty($result)) {
                       $result = 0;
                   } else {
                       $result = 1;
                   }
               }
           }
       }
    }
       if ($result == 0) {
           $error['add_fake_jobs'] = "<section class='content-header'>
                                   <span class='label label-success'>Fake jobs added successfully</span>
                                 </section>";
       } else {
           $error['add_fake_jobs'] = " <span class='label label-danger'>Failed</span>";
       }
      ?> 

<section class="content-header">
    <h1>Add New Jobs <small><a href='fake-jobs.php'> <i class='fa fa-angle-double-left'></i>&nbsp;&nbsp;&nbsp;Back to Jobs</a></small></h1>

   
    <ol class="breadcrumb">
        <li><a href="home.php"><i class="fa fa-home"></i> Home</a></li>
    </ol>
    <hr />
</section>
<section class="content">
    <div class="row">
        <div class="col-md-10">
           
            <!-- general form elements -->
            <div class="box box-primary">
                <div class="box-header with-border">

                </div>
                <!-- /.box-header -->
                <!-- form start -->
                <form name="add_fake-jobs_form" method="post" enctype="multipart/form-data">
                    <div class="box-body">
                    <div class="row">
                            <div class="form-group">
                                <div class='col-md-6'>
                                <label for="exampleInputEmail1">Title</label><i class="text-danger asterik">*</i>
                                    <input type="text" class="form-control" name="title">
                                </div>
                                <div class="form-group col-md-4">
                                    <div class="form-group">
                                        <label for="">Image</label>
                                        <input type="file" class="form-control" name="image"  required>
                                    </div>
                                </div>
                            </div>
                            
                        </div>
                    </div>
                  
                    <!-- /.box-body -->

                    <div class="box-footer">
                        <button type="submit" class="btn btn-primary" name="btnAdd">Submit</button>
                        <input type="reset" onClick="refreshPage()" class="btn-warning btn" value="Clear" />
                    </div>

                </form>

            </div><!-- /.box -->
        </div>
    </div>
</section>
           
         

<div class="separator"> </div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.17.0/jquery.validate.min.js"></script>
<script>
    $('#add_leave_form').validate({

        ignore: [],
        debug: false,
        rules: {
        reason: "required",
            date: "required",
        }
    });
    $('#btnClear').on('click', function() {
        for (instance in CKEDITOR.instances) {
            CKEDITOR.instances[instance].setData('');
        }
    });
</script>
<script>
    $(document).ready(function () {
        $('#user_id').select2({
        width: 'element',
        placeholder: 'Type in name to search',

    });
    });

    if ( window.history.replaceState ) {
  window.history.replaceState( null, null, window.location.href );
}

</script>

<!--code for page clear-->
<script>
    function refreshPage(){
    window.location.reload();
} 
</script>

<?php $db->disconnect(); ?>