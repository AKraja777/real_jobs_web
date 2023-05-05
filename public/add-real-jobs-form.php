<?php
include_once('includes/functions.php');
$function = new functions;
include_once('includes/custom-functions.php');
$fn = new custom_functions;

?>
<?php
if (isset($_POST['btnAdd'])) {

        $company_name= $db->escapeString($_POST['company_name']);
        $title= $db->escapeString($_POST['title']);
        $description = $db->escapeString($_POST['description']);
        $income= $db->escapeString($_POST['income']);
        $error = array();

        
     
        if (empty($company_name)) {
            $error['company_name'] = " <span class='label label-danger'>Required!</span>";
        }
        if (empty($title)) {
            $error['title'] = " <span class='label label-danger'>Required!</span>";
        }
       
        if (empty($description)) {
            $error['description'] = " <span class='label label-danger'>Required!</span>";
        }
        if (empty($income)) {
            $error['income'] = " <span class='label label-danger'>Required!</span>";
        }
        if (empty($_FILES['image']['name'])) {
            $error['image'] = " <span class='label label-danger'>Required!</span>";
        }
       


        if ( !empty($company_name)  && !empty($title) && !empty($description) && !empty($income))
        {
            if (isset($_FILES['image']) && !empty($_FILES['image']) && $_FILES['image']['error'] == 0 && $_FILES['image']['size'] > 0) {
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
                        $sql_query = "INSERT INTO real_jobs (company_name,title,description,income,image)VALUES('$company_name','$title','$description','$income','$upload_image2')";
                        $db->sql($sql_query);
                        $result = $db->getResult();
                        if (!empty($result)) {
                            $result = 0;
                        } else {
                            $result = 1;
                        }
                        if ($result == 1) {
                            $sql = "SELECT id FROM real_jobs ORDER BY id DESC LIMIT 1";
                            $db->sql($sql);
                            $res = $db->getResult();
                            $real_jobs_id = $res[0]['id'];
                            if (is_array($_POST['job_details'])) {
                                for ($i = 0; $i < count($_POST['job_details']); $i++) {
                                    $job_details = $db->escapeString(($_POST['job_details'][$i]));
                                    $sql = "INSERT INTO real_jobs_variant (real_jobs_id,job_details) VALUES('$real_jobs_id','$job_details')";
                                    $db->sql($sql);
                                    $real_jobs_variant_result = $db->getResult();
                                }
                                if (!empty($real_jobs_variant_result)) {
                                    $real_jobs_variant_result = 0;
                                } else {
                                    $real_jobs_variant_result = 1;
                                }
                            }
                            $error['add_real_jobs'] = "<section class='content-header'>
                                                            <span class='label label-success'>real_jobs Added Successfully</span> </section>";
                        } else {
                            $error['add_real_jobs'] = " <span class='label label-danger'>Failed</span>";
                        }
                    }
                }
            }
        }
    }        
            
?>
<section class="content-header">
    <h1>Add New Jobs <small><a href='real-jobs.php'> <i class='fa fa-angle-double-left'></i>&nbsp;&nbsp;&nbsp;Back to Jobs</a></small></h1>

   
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
                <form name="add_real-jobs_form" method="post" enctype="multipart/form-data">
                    <div class="box-body">
                    <div class="row">
                            <div class="form-group">
                                <div class='col-md-6'>
                                <label for="exampleInputEmail1">Company Name</label><i class="text-danger asterik">*</i>
                                    <input type="text" class="form-control" name="company_name">
                                </div>
                                <div class='col-md-6'>
                                    <label for="exampleInputEmail1">Title</label> <i class="text-danger asterik">*</i>
                                    <input type="text" class="form-control" name="title" required>
                                </div>
                            </div>
                            
                        </div>
                        <br>
                        <div class="row">
                            <div class="form-group">
                                <div class='col-md-6'>
                                <label for="exampleInputEmail1">Description</label> <i class="text-danger asterik">*</i>
                                    <input type="text" class="form-control" name="description" required>
                                </div>
                                <div class="col-md-6">
                                <label for="exampleInputEmail1">Income</label> <i class="text-danger asterik">*</i>
                                    <input type="number" class="form-control" name="income" required>
                                </div>
                            </div>
                        </div>
                        <br>
                            <div id="packate_div">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group packate_div">
                                            <label for="exampleInputEmail1">job details</label> <i class="text-danger asterik">*</i>
                                            <textarea type="text" rows="2" class="form-control" name="job_details" required></textarea>
                                        </div>
                                    </div>
                                    <div class="col-md-1">
                                        <label>Tab</label>
                                        <a class="add_packate_variation" title="Add variation of real jobs" style="cursor: pointer;color:white;"><button class="btn btn-warning">Add More</button></a>
                                    </div>
                                    <div id="variations">
                                    </div>
                                </div>
                                <div class="form-group col-md-4">
                                    <div class="form-group">
                                        <label for="">Image</label>
                                        <input type="file" class="form-control" name="image"  required>
                                    </div>
                                </div>
                        </div>
                    </div>

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
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script>
    $(document).ready(function () {
        var max_fields = 8;
        var wrapper = $("#packate_div");
        var add_button = $(".add_packate_variation");

        var x = 1;
        $(add_button).click(function (e) {
            e.preventDefault();
            if (x < max_fields) {
                x++;
                $(wrapper).append('<div class="row"><div class="col-md-6"><div class="form-group"><label for="job_details">job_details</label>'+'<textarea type="text" row="2" class="form-control" name="job_details[]"></textarea></div></div>'+'<div class="col-md-1" style="display: grid;"><label>Tab</label><a class="remove" style="cursor:pointer;color:white;"><button class="btn btn-danger">Remove</button></a></div>'+'</div>');
            }
            else{
                alert('You Reached the limits')
            }
        });

        $(wrapper).on("click", ".remove", function (e) {
            e.preventDefault();
            $(this).closest('.row').remove();
            x--;
        })
    });
</script>

<!--code for page clear-->
<script>
    function refreshPage(){
    window.location.reload();
} 
</script>

<?php $db->disconnect(); ?>