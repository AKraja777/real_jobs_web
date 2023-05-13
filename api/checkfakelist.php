<?php
header('Access-Control-Allow-Origin: *');
header("Content-Type: application/json");
header("Expires: 0");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

include_once('../includes/crud.php');

$db = new Database();
$db->connect();

if (empty($_POST['user_id'])) {
    $response['success'] = false;
    $response['message'] = "User ID is empty";
    print_r(json_encode($response));
    return false;
}

$user_id = $db->escapeString($_POST['user_id']);

$sql = "SELECT * FROM check_fake_jobs WHERE user_id = '$user_id'";
$db->sql($sql);
$res = $db->getResult();
$num = $db->numRows($res);

if ($num >= 1) {
    foreach($res as $row){

        $temp['id'] = $row['id'];
        $temp['title'] = $row['title'];
        $temp['description'] = $row['description'];
        $temp['screenshot'] = DOMAIN_URL . $row['screenshot'];
        $temp['status'] = $row['status'];
        $temp['user_id'] = $row['user_id'];
        $rows[] = $temp;

    }
    $response['success'] = true;
    $response['message'] = "fake jobs details Retieved Successfully";
    $response['data'] = $rows;
    print_r(json_encode($response));
}
else{
    
    $response['success'] = false;
    $response['message'] =" Not Found";
    print_r(json_encode($response));
}

?>
