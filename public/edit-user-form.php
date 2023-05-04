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

            $name = $db->escapeString(($_POST['name']));
            $mobile = $db->escapeString(($_POST['mobile']));
            $email = $db->escapeString(($_POST['email']));
            $password = $db->escapeString(($_POST['password']));
            $place = $db->escapeString(($_POST['place']));
            $skills = $db->escapeString(($_POST['skills']));
            $working_experience = $db->escapeString(($_POST['working_experience']));
            $status = $db->escapeString(($_POST['status']));
            $error = array();

     if (!empty($name) && !empty($mobile) && !empty($email)&& !empty($password)&& !empty($skills)&& !empty($place)&& !empty($working_experience)&& !empty($status)) 
		{

        $sql_query = "UPDATE users SET name='$name', mobile='$mobile',email='$email',status='$status',password='$password',place='$place',skills='$skills',working_experience='$working_experience' WHERE id =  $ID";
        $db->sql($sql_query);
        $update_result = $db->getResult();
        if (!empty($update_result)) {
            $update_result = 0;
        } else {
            $update_result = 1;
        }

        // check update result
        if ($update_result == 1) {
            $error['update_users'] = " <section class='content-header'><span class='label label-success'>users updated Successfully</span></section>";
        } else {
            $error['update_users'] = " <span class='label label-danger'>Failed update</span>";
        }
    }
}


// create array variable to store previous data
$data = array();

$sql_query = "SELECT * FROM users WHERE id =" . $ID;
$db->sql($sql_query);
$res = $db->getResult();

if (isset($_POST['btnCancel'])) { ?>
    <script>
        window.location.href = "users.php";
    </script>
<?php } ?>
<section class="content-header">
    <h1>
        Edit users<small><a href='users.php'><i class='fa fa-angle-double-left'></i>&nbsp;&nbsp;&nbsp;Back to users</a></small></h1>
    <small><?php echo isset($error['update_users']) ? $error['update_users'] : ''; ?></small>
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
                <form name="edit_users_form" method="post" enctype="multipart/form-data">
                    <div class="box-body">
                    <div class="row">
                            <div class="form-group">
                                <div class='col-md-6'>
                                    <label for="exampleInputEmail1">Name</label> <i class="text-danger asterik">*</i>
                                    <input type="text" class="form-control" name="name" value="<?php echo $res[0]['name']; ?>">
                                </div>

                            </div>
                            
                        </div>
                        <br>
                        <div class="row">
                            <div class="form-group">
                                <div class="col-md-6">
                                    <label for="exampleInputEmail1">Mobile Number</label><i class="text-danger asterik">*</i>
                                    <input type="mobile" class="form-control" name="mobile" value="<?php echo $res[0]['mobile']; ?>">
                                </div>
                                <div class="col-md-6">
                                    <label for="exampleInputEmail1">Email</label><i class="text-danger asterik">*</i>
                                    <input type="text" class="form-control" name="email" value="<?php echo $res[0]['email']; ?>">
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="form-group">
                                <div class="col-md-6">
                                    <label for="exampleInputEmail1">Password</label><i class="text-danger asterik">*</i>
                                    <input type="password" class="form-control" name="password" value="<?php echo $res[0]['password']; ?>">
                                </div>
                                <div class="col-md-6">
                                    <label for="exampleInputEmail1">Place</label><i class="text-danger asterik">*</i>
                                    <input type="text" class="form-control" name="place" value="<?php echo $res[0]['place']; ?>">
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="form-group">
                                <div class="col-md-6">
                                    <label for="exampleInputEmail1">Skills</label><i class="text-danger asterik">*</i>
                                    <input type="text" class="form-control" name="skills" value="<?php echo $res[0]['skills']; ?>">
                                </div>
                                <div class="col-md-6">
                                    <label for="exampleInputEmail1">Working Experience</label><i class="text-danger asterik">*</i>
                                    <input type="working_experience" class="form-control" name="working_experience" value="<?php echo $res[0]['working_experience']; ?>">
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="row">
    <div class="col-md-3">
        <div class="form-group">
            <label for="">status</label><br>
            <input type="checkbox" id="status_button" class="js-switch" <?= isset($res[0]['status']) && $res[0]['status'] == 1 ? 'checked' : '' ?>>
            <input type="hidden" id="status" name="status" value="<?= isset($res[0]['status']) && $res[0]['status'] == 1 ? 1 : 0 ?>">
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
