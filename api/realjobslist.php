<?php
header('Access-Control-Allow-Origin: *');
header("Content-Type: application/json");
header("Expires: 0");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
date_default_timezone_set('Asia/Kolkata');

include_once('../includes/crud.php');
$db = new Database();
$db->connect();


$sql = "SELECT * FROM `real_jobs`";
$db->sql($sql);
$res = $db->getResult();
$num = $db->numRows($res);
if($num>=1){
        $rows = array();
        $temp = array();
        foreach ($res as $row) {
            $id = $row['id'];
            $temp['id'] = $row['id'];
            $temp['company_name'] = $row['company_name'];
            $temp['title'] = $row['title'];
            $temp['description'] = $row['description'];
            $temp['income'] = $row['income'];
 
            $sql = "SELECT * FROM `real_jobs_variant` WHERE real_jobs_id = '$id'";
            $db->sql($sql);
            $res = $db->getResult();
            $temp['real_jobs_variant'] = $res;
            $rows[] = $temp;
        }
        $response['success'] = true;
        $response['message'] = "Real Jobs Listed Successfully";
        $response['data'] = $rows;
        print_r(json_encode($response));
}
else{
    $response['success'] = false;
    $response['message'] = "Data Not Found";
    print_r(json_encode($response));
}


?>