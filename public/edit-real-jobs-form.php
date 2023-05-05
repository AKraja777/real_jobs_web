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
    $company_name = $db->escapeString($_POST['company_name']);
    $title = $db->escapeString($_POST['title']);
    $description = $db->escapeString($_POST['description']);
    $income = $db->escapeString($_POST['income']);
    $error = array();
    
    if (!empty($_FILES['image']['name'])) {
    
        $upload_dir = "../upload/image/";
        $file_name = time() . "_" . basename($_FILES['image']['name']);
        $target_file = $upload_dir . $file_name;
    
        if (move_uploaded_file($_FILES['image']['tmp_name'], $target_file)) {
    
            $sql_query = "UPDATE real_jobs SET title='$title', image='$file_name', company_name='$company_name', description='$description', income='$income' WHERE id = $ID";
            $db->sql($sql_query);
            $update_result = $db->getResult();
    
            if (!empty($update_result)) {
                $update_result = 0;
            } else {
                $update_result = 1;
            }
    
            if ($update_result == 1) {
                $error['update_real-jobs'] = "<section class='content-header'><span class='label label-success'>real job updated successfully</span></section>";
            } else {
                $error['update_real-jobs'] = "<span class='label label-danger'>Failed to update fake job</span>";
            }
        } else {
            $error['upload'] = "<span class='label label-danger'>Failed to upload image</span>";
        }
    } else {
        $sql_query = "UPDATE real_jobs SET title='$title', company_name='$company_name', description='$description', income='$income' WHERE id = $ID";
        $db->sql($sql_query);
        $update_result = $db->getResult();
    
        if (!empty($update_result)) {
            $update_result = 0;
        } else {
            $update_result = 1;
        }
    
        if ($update_result == 1) {
            $error['update_real-jobs'] = "<section class='content-header'><span class='label label-success'>real job updated successfully</span></section>";
        } else {
            $error['update_real-jobs'] = "<span class='label label-danger'>Failed to update fake job</span>";
        }
    }
}    

// create array variable to store previous data
$data = array();

$sql_query = "SELECT * FROM real_jobs WHERE id =" . $ID;
$db->sql($sql_query);
$res = $db->getResult();

if (isset($_POST['btnCancel'])) { ?>
    <script>
        window.location.href = "real-jobs.php";
    </script>
<?php } ?>
<section class="content-header">
    <h1>
        Edit Jobs<small><a href='real-jobs.php'><i class='fa fa-angle-double-left'></i>&nbsp;&nbsp;&nbsp;Back to jobs</a></small></h1>
    <small><?php echo isset($error['update_real-jobs']) ? $error['update_real-jobs'] : ''; ?></small>
    <ol class="breadcrumb">
        <li><a href="home.php"><i class="fa fa-home"></i> Home</a></li>
    </ol>
</section>
<section class="content">
    <!-- Main row -->

    <div class="row">
        <div class="col-md-10">

            <!-- general form elements -->
            <div class="box box-primary">
                <div class="box-header with-border">

                </div>
                <!-- /.box-header -->
                <!-- form start -->
                <form name="edit_real-jobs_form" method="post" enctype="multipart/form-data">
                    <div class="box-body">
                        <div class="row">
                            <div class="form-group">
                                <div class="col-md-6">
                                    <label for="exampleInputEmail1">Comapny Name</label><i class="text-danger asterik">*</i>
                                    <input type="text" class="form-control" name="company_name" value="<?php echo $res[0]['company_name']; ?>">
                                </div>
                                <div class="col-md-6">
                                    <label for="exampleInputEmail1">title</label><i class="text-danger asterik">*</i>
                                    <input type="text" class="form-control" name="title" value="<?php echo $res[0]['title']; ?>">
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="form-group">
                                <div class="col-md-6">
                                    <label for="exampleInputEmail1">Description</label><i class="text-danger asterik">*</i>
                                    <input type="text" class="form-control" name="description" value="<?php echo $res[0]['description']; ?>">
                                </div>
                                <div class="col-md-6">
                                    <label for="exampleInputEmail1">Income</label><i class="text-danger asterik">*</i>
                                    <input type="number" class="form-control" name="income" value="<?php echo $res[0]['income']; ?>">
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="form-group col-md-4">
                                  <div class="form-group">
                                <label for="">Image</label>
                               <input type="file" class="form-control" name="image" required>
                                   <?php
                                if (!empty($res[0]['image'])) {
                                  $image_url = DOMAIN_URL . 'upload/image/' . $res[0]['image'];
                                  echo '<p class="help-block"><img src="' . $image_url . '" style="max-width:100%" /></p>';
                                    }
                                      ?>
                            </div>
                       </div>
          <!-- /.box-body -->
               
                    </div>
                    <div class="box-footer">
                        <button type="submit" class="btn btn-primary" name="btnEdit">Update</button>
                    </div>
                    </div>
                </form>
            </div><!-- /.box -->
        </div>
    </div>
</section>

<div class="separator"> </div>
<?php $db->disconnect(); ?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.17.0/jquery.validate.min.js"></script>

<script>
    var changeCheckbox = document.querySelector('#status_button');
    var init = new Switchery(changeCheckbox);
    changeCheckbox.onchange = function() {
        if ($(this).is(':checked')) {
            $('#status').val(1);
        } else {
            $('#status').val(0);
        }
    };
</script>
