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
           
    $payment_status = $db->escapeString(($_POST['payment_status']));
    $error = array();



$sql_query = "UPDATE payments SET payment_status='$payment_status' WHERE id =  $ID";
$db->sql($sql_query);
$update_result = $db->getResult();
        
        if (!empty($update_result)) {
            $update_result = 0;
        } else {
            $update_result = 1;
        }

        // check update result
        if ($update_result == 1) {
            $error['update_payments'] = "<section class='content-header'><span class='label label-success'>payments updated Successfully</span></section>";
        } else {
            $error['update_payments'] = "<span class='label label-danger'>Failed update</span>";
        }
    }



// create array variable to store previous data
$data = array();

$sql_query = "SELECT * FROM payments ";
$db->sql($sql_query);
$res = $db->getResult();
if (isset($_POST['btnCancel'])) { ?>
    <script>
        window.location.href = "payments.php";
    </script>
<?php } ?>
<section class="content-header">
    <h1>
        Edit payments Details<small><a href='payments.php'><i class='fa fa-angle-double-left'></i>&nbsp;&nbsp;&nbsp;Back to payments</a></small></h1>
    <small><?php echo isset($error['update_payments']) ? $error['update_payments'] : ''; ?></small>
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
                <form id="edit_payments_form" method="post" enctype="multipart/form-data">
                    <div class="box-body">
                     <div class="row">
                     <div class="form-group col-md-4">
                                  <div class="form-group">
                                <label for="">Image</label>
                                   <?php
                                if (!empty($res[0]['image'])) {
                                  $image_url = DOMAIN_URL . 'upload/image/' . $res[0]['image'];
                                  echo '<p class="help-block"><img src="' . $image_url . '" style="max-width:100%" /></p>';
                                    }
                                      ?>
                            </div>
                                </div>
                            <div class="form-group">
                                <div class="col-md-4">
                                    <label class="control-label">Payment Status</label> <i class="text-danger asterik">*</i><br>
                                    <div id="status" class="btn-group">
                                        <label class="btn btn-warning" data-toggle-class="btn-default" data-toggle-passive-class="btn-default">
                                            <input type="radio" name="payment_status" value="0" <?= ($res[0]['payment_status'] == 0) ? 'checked' : ''; ?>>Pending
                                        </label>
                                        <label class="btn btn-success" data-toggle-class="btn-primary" data-toggle-passive-class="btn-default">
                                            <input type="radio" name="payment_status" value="1" <?= ($res[0]['payment_status'] == 1) ? 'checked' : ''; ?>> Success
                                        </label>
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
