<?php
include_once('includes/functions.php');
$function = new functions;
include_once('includes/custom-functions.php');
$fn = new custom_functions;



?>
<?php
if (isset($_POST['btnAdd'])) {

        $name = $db->escapeString(($_POST['name']));
        $mobile = $db->escapeString(($_POST['mobile']));
        $email = $db->escapeString(($_POST['email']));
        $password = $db->escapeString(($_POST['password']));
        $place = $db->escapeString(($_POST['place']));
        $skills = $db->escapeString(($_POST['skills']));
        $working_experience = $db->escapeString(($_POST['working_experience']));

       
        $error = array();
       
        if (empty($name)) {
            $error['name'] = " <span class='label label-danger'>Required!</span>";
        }
        if (empty($mobile)) {
            $error['mobile'] = " <span class='label label-danger'>Required!</span>";
        }
        if (empty($email)) {
            $error['email'] = " <span class='label label-danger'>Required!</span>";
        }
        
        if (empty($password)) {
            $error['password'] = " <span class='label label-danger'>Required!</span>";
        }
        
        if (empty($place)) {
            $error['[place]'] = " <span class='label label-danger'>Required!</span>";
        }
        
        if (empty($skills)) {
            $error['skills'] = " <span class='label label-danger'>Required!</span>";
        }
        
        if (empty($working_experience)) {
            $error['working_experience'] = " <span class='label label-danger'>Required!</span>";
        }
        
           
       if (!empty($name) && !empty($mobile)&& !empty($email)&& !empty($password)&& !empty($place)&& !empty($skills) && !empty($working_experience)) 
       {
        $sql_query = "SELECT * FROM users WHERE mobile = '$mobile'";
        $db->sql($sql_query);
        $res = $db->getResult();
        $num = $db->numRows($res);
        if ($num >= 1) {
            $error['add_users'] = " <span class='label label-danger'>users Already Added</span>";
            
        }else{
            $sql_query = "INSERT INTO users (name,mobile,email,password,place,skills,working_experience)VALUES('$name','$mobile','$email','$password','$place','$skills','$working_experience')";
            $db->sql($sql_query);
            $result = $db->getResult();
        }
            if (!empty($result)) {
                $result = 0;
            } else {
                $result = 1;
            }
        if ($result == 0) {
            $error['add_users'] = "<section class='content-header'>
                                      <span class='label label-success'>users Added Successfully</span> </section>";
        } else {
            $error['add_users'] = " <span class='label label-danger'>Failed</span>";
        }
    }
}
?>
<section class="content-header">
    <h1>Add New users <small><a href='users.php'> <i class='fa fa-angle-double-left'></i>&nbsp;&nbsp;&nbsp;Back to users</a></small></h1>

   
    <ol class="breadcrumb">
        <li><a href="home.php"><i class="fa fa-home"></i> Home</a></li>
    </ol>
    <hr />
</section>
<section class="content">
    <div class="row">
        <div class="col-md-10">
           
            <!-- general form elements -->
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
                                    <input type="text" class="form-control" name="name">
                                </div>

                            </div>
                            
                        </div>
                        <br>
                        <div class="row">
                            <div class="form-group">
                                <div class="col-md-6">
                                    <label for="exampleInputEmail1">Mobile Number</label><i class="text-danger asterik">*</i>
                                    <input type="mobile" class="form-control" name="mobile">
                                </div>
                                <div class="col-md-6">
                                    <label for="exampleInputEmail1">Email</label><i class="text-danger asterik">*</i>
                                    <input type="text" class="form-control" name="email">
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="form-group">
                                <div class="col-md-6">
                                    <label for="exampleInputEmail1">Password</label><i class="text-danger asterik">*</i>
                                    <input type="password" class="form-control" name="password">
                                </div>
                                <div class="col-md-6">
                                    <label for="exampleInputEmail1">Place</label><i class="text-danger asterik">*</i>
                                    <input type="text" class="form-control" name="place">
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="form-group">
                                <div class="col-md-6">
                                    <label for="exampleInputEmail1">Skills</label><i class="text-danger asterik">*</i>
                                    <input type="text" class="form-control" name="skills">
                                </div>
                                <div class="col-md-6">
                                    <label for="exampleInputEmail1">Working Experience</label><i class="text-danger asterik">*</i>
                                    <input type="working_experience" class="form-control" name="working_experience">
                                </div>
                            </div>
                        </div>
          <!-- /.box-body -->

                 <div class="box-footer">
                        <button type="submit" class="btn btn-primary" name="btnAdd">Add</button>
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