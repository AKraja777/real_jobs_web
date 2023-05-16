
<?php
include_once('includes/functions.php');
$function = new functions;
include_once('includes/custom-functions.php');
$fn = new custom_functions;
?>
<?php

if (isset($_GET['id'])) {
    $ID = $db->escapeString($_GET['id']);
} else {
    // $ID = "";
    return false;
    exit(0);
}
if (isset($_POST['btnEdit'])) {
    $title = $db->escapeString($_POST['title']);
    $error = array();
    
   
    if (!empty($_FILES['image']['name'])) {
    
        $upload_dir = "upload/image/";
        $file_name = time() . "_" . basename($_FILES['image']['name']);
        $target_file = $upload_dir . $file_name;
    
        if (move_uploaded_file($_FILES['image']['tmp_name'], $target_file)) {

            $sql_query = "UPDATE fake_jobs SET title='$title', image='$file_name' WHERE id = $ID";
            $db->sql($sql_query);
            $update_result = $db->getResult();
            
            if (!empty($update_result)) {
                $update_result = 0;
            } else {
                $update_result = 1;
            }

            
            if ($update_result == 1) {
                $error['update_fake-jobs'] = "<section class='content-header'><span class='label label-success'>fake jobs updated Successfully</span></section>";
            } else {
                $error['update_fake-jobs'] = "<span class='label label-danger'>Failed update</span>";
            }
        } else {
            
            $error['upload'] = "<span class='label label-danger'>Failed to upload image</span>";
        }
    } else {
      
        $sql_query = "UPDATE fake_jobs SET title='$title' WHERE id = $ID";
        $db->sql($sql_query);
        $update_result = $db->getResult();
        
        if (!empty($update_result)) {
            $update_result = 0;
        } else {
            $update_result = 1;
        }

        // check update result
        if ($update_result == 1) {
            $error['update_fake-jobs'] = "<section class='content-header'><span class='label label-success'>fake jobs updated Successfully</span></section>";
        } else {
            $error['update_fake-jobs'] = "<span class='label label-danger'>Failed update</span>";
        }
    }
}


// create array variable to store previous data
$data = array();

$sql_query = "SELECT * FROM fake_jobs WHERE id =" . $ID;
$db->sql($sql_query);
$res = $db->getResult();

if (isset($_POST['btnCancel'])) { ?>
    <script>
        window.location.href = "fake-jobs.php";
    </script>
<?php } ?>
<section class="content-header">
    <h1>
        Edit Jobs<small><a href='fake-jobs.php'><i class='fa fa-angle-double-left'></i>&nbsp;&nbsp;&nbsp;Back to jobs</a></small></h1>
    <small><?php echo isset($error['update_fake-jobs']) ? $error['update_fake-jobs'] : ''; ?></small>
    <ol class="breadcrumb">
        <li><a href="home.php"><i class="fa fa-home"></i> Home</a></li>
    </ol>
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
                <form name="edit_fake-jobs_form" method="post" enctype="multipart/form-data">
                    <div class="box-body">
                    <div class="row">
                            <div class="form-group">
                                <div class='col-md-6'>
                                <label for="exampleInputEmail1">Title</label><i class="text-danger asterik">*</i>
                                    <input type="text" class="form-control" name="title" value="<?php echo $res[0]['title']; ?>">
                                </div>
                                <div class="form-group col-md-4">
                                  <div class="form-group">
                                <label for="">Image</label>
                               <input type="file" class="form-control" accept="image/png, image/jpeg"  name="image">
                                   <?php
                                if (!empty($res[0]['image'])) {
                                  $image_url = DOMAIN_URL . 'upload/image/' . $res[0]['image'];
                                  echo '<p class="help-block"><img src="' . $image_url . '" style="max-width:100%" /></p>';
                                    }
                                      ?>
                            </div>
                       
                       </div>
                     </div>
                       </div>

                            
                        </div>
                    </div>
                  
                    <!-- /.box-body -->

                    <div class="box-footer">
                        <button type="submit" class="btn btn-primary" name="btnEdit">Update</button>

                    </div>

                </form>

            </div><!-- /.box -->
        </div>
    </div>
</section>