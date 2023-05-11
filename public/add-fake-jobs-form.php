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
    }
           
       if (!empty($title)) {
        if ($_FILES['image']['error'] == 0 && $_FILES['image']['size'] > 0) {
            $target_path = 'upload/image/';

            $extension = pathinfo($_FILES["image"]["name"])['extension'];
            $result = $fn->validate_image($_FILES["image"]);
            if (!$result) {
                echo " <span class='label label-danger'>image type must jpg, jpeg, gif, or png!</span>";
                return false;
                exit();
            }
            $image = microtime(true) . '.' . strtolower($extension);
            $full_path = $target_path . "" . $image;
            if (!move_uploaded_file($_FILES["image"]["tmp_name"], $full_path)) {
                echo "<p class='alert alert-danger'>Invalid directory to load image!</p>";
                return false;
            }
        }
        
            $sql_query = "INSERT INTO fake_jobs (title,image) VALUES ('$title','$image')";
            $db->sql($sql_query);
            $result = $db->getResult();
            if (!empty($result)) {
                $result = 0;
            } else {
                $result = 1;
            }
            if ($result == 1) {
                echo "<div class='alert alert-success'> Jobs Added Successfully!</div>";
                
            } else {
                echo "<div class='alert alert-danger'> Failed!</div>";
            }
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
                                        <input type="file" class="form-control" accept="image/png, image/jpeg" name="image"  required>
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