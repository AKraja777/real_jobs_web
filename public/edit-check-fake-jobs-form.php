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
    $description = $db->escapeString($_POST['description']);
    $status = $db->escapeString($_POST['status']);
    $error = array();
    
   
    if (!empty($_FILES['screenshot']['name'])) {
        
        $upload_dir = "../upload/images/";
        $file_name = time() . "_" . basename($_FILES['screenshot']['name']);
        $target_file = $upload_dir . $file_name;

       
        if (move_uploaded_file($_FILES['images']['tmp_name'], $target_file)) {

            $sql_query = "UPDATE check_fake_jobs SET title='$title', screenshot='$file_name',description='$description',status='$status' WHERE id = $ID";
            $db->sql($sql_query);
            $update_result = $db->getResult();
            
            if (!empty($update_result)) {
                $update_result = 0;
            } else {
                $update_result = 1;
            }

            
            if ($update_result == 1) {
                $error['update_check-fake-jobs'] = "<section class='content-header'><span class='label label-success'>check fake jobs updated Successfully</span></section>";
            } else {
                $error['update_check-fake-jobs'] = "<span class='label label-danger'>Failed update</span>";
            }
        } else {
            
            $error['upload'] = "<span class='label label-danger'>Failed to upload image</span>";
        }
    } else {
      
        $sql_query = "UPDATE check_fake_jobs SET title='$title',description='$description',status='$status' WHERE id = $ID";
        $db->sql($sql_query);
        $update_result = $db->getResult();
        
        if (!empty($update_result)) {
            $update_result = 0;
        } else {
            $update_result = 1;
        }

        // check update result
        if ($update_result == 1) {
            $error['update_check-fake-jobs'] = "<section class='content-header'><span class='label label-success'>check fake jobs updated Successfully</span></section>";
        } else {
            $error['update_check-fake-jobs'] = "<span class='label label-danger'>Failed update</span>";
        }
    }
}


// create array variable to store previous data
$data = array();

$sql_query = "SELECT * FROM check_fake_jobs ";
$db->sql($sql_query);
$res = $db->getResult();
if (isset($_POST['btnCancel'])) { ?>
    <script>
        window.location.href = "check_fake_jobs.php";
    </script>
<?php } ?>
<section class="content-header">
    <h1>
        Edit Check Fake Jobs Details<small><a href='check-fake-jobs.php'><i class='fa fa-angle-double-left'></i>&nbsp;&nbsp;&nbsp;Back to check fake jobs</a></small></h1>
    <small><?php echo isset($error['update_fake_jobs']) ? $error['update_fake_jobs'] : ''; ?></small>
    <ol class="breadcrumb">
        <li><a href="home.php"><i class="fa fa-home"></i> Home</a></li>
    </ol>
</section>
<section class="content">
    <!-- Main row -->

    <div class="row">
        <div class="col-md-8">

            <!-- general form elements -->
            <div class="box box-primary">
                <div class="box-header with-border">
                </div>
                <form id="edit_check_fake_jobs_form" method="post" enctype="multipart/form-data">
                    <div class="box-body">
                        <div class="row">
                            <div class="form-group">
                                <div class="col-md-6">
                                    <label for="exampleInputEmail1">title</label> <i class="text-danger asterik">*</i>
                                    <input type="text" class="form-control" name="title" value="<?php echo $res[0]['title']; ?>">
                                </div>
                                <div class="col-md-6">
                                    <label for="exampleInputEmail1">description</label> <i class="text-danger asterik">*</i>
                                    <input type="text" class="form-control" name="description" value="<?php echo $res[0]['description']; ?>">
                                </div>
                            </div>
                        </div>
                        <br>
                                  <div class="form-group">
                                <label for="">screenshot</label>
                               <input type="file" class="form-control" name="screenshot" required>
                                   <?php
                                if (!empty($res[0]['screenshot'])) {
                                  $image_url = DOMAIN_URL . 'upload/screenshot/' . $res[0]['screenshot'];
                                  echo '<p class="help-block"><img src="' . $image_url . '" style="max-width:100%" /></p>';
                                    }
                                      ?>
                            </div>
                       </div>
                        <br>
                        <div class="row">
                            <div class="form-group">
                                <div class="col-md-8">
                                    <label class="control-label">Status</label> <i class="text-danger asterik">*</i><br>
                                    <div id="status" class="btn-group">
                                        <label class="btn btn-warning" data-toggle-class="btn-default" data-toggle-passive-class="btn-default">
                                            <input type="radio" name="status" value="0" <?= ($res[0]['status'] == 0) ? 'checked' : ''; ?>>Pending
                                        </label>
                                        <label class="btn btn-success" data-toggle-class="btn-primary" data-toggle-passive-class="btn-default">
                                            <input type="radio" name="status" value="1" <?= ($res[0]['status'] == 1) ? 'checked' : ''; ?>> Fake
                                        </label>
                                        <label class="btn btn-danger" data-toggle-class="btn-primary" data-toggle-passive-class="btn-default">
                                            <input type="radio" name="status" value="2" <?= ($res[0]['status'] == 2) ? 'checked' : ''; ?>> Real
                                        </label>
                                    </div>

                                </div>
                            </div>
                        </div>

                    </div><!-- /.box-body -->

                    <div class="box-footer">
                        <button type="submit" class="btn btn-primary" name="btnEdit">Update</button>

                    </div>
                </form>
            </div><!-- /.box -->
        </div>
    </div>
</section>

<div class="separator"> </div>
<?php $db->disconnect(); ?>
