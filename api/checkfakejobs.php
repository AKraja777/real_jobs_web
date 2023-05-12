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
include_once('../includes/custom-functions.php');
include_once('../includes/functions.php');
$fn = new custom_functions;

if (empty($_POST['title'])) {
    $response['success'] = false;
    $response['message'] = "Please enter a title";
    print_r(json_encode($response));
    return false;
}
if (empty($_POST['description'])) {
    $response['success'] = false;
    $response['message'] = "Please enter a description";
    print_r(json_encode($response));
    return false;
}

if (!isset($_FILES['screenshot']) || empty($_FILES['screenshot']['name'])) {
    $response['success'] = false;
    $response['message'] = "Please upload an screenshot";
    print_r(json_encode($response));
    return false;
}
if (empty($_POST['user_id'])) {
    $response['success'] = false;
    $response['message'] = "Please enter a user id";
    print_r(json_encode($response));
    return false;
}

$title = $db->escapeString($_POST['title']);
$description = $db->escapeString($_POST['description']);
$user_id = $db->escapeString($_POST['user_id']);
if (isset($_FILES['screenshot']) && !empty($_FILES['screenshot']) && $_FILES['screenshot']['error'] == 0 && $_FILES['screenshot']['size'] > 0) {
    if (!is_dir('../upload/screenshot/')) {
        mkdir('../upload/screenshot/', 0777, true);
    }
    $screenshot = $db->escapeString($fn->xss_clean($_FILES['screenshot']['name']));
    $extension = pathinfo($_FILES["screenshot"]["name"], PATHINFO_EXTENSION);
    $result = $fn->validate_image($_FILES["screenshot"]);
    if (!$result) {
        $response["success"] = false;
        $response["message"] = "Image type must be jpg, jpeg, gif, or png!";
        print_r(json_encode($response));
        return false;
    }
    $screenshot_name = microtime(true) . '.' . strtolower($extension);
    $full_path = '../upload/image/' . $screenshot_name;
    $upload_image2 = 'upload/image/' . $screenshot_name;
    if (!move_uploaded_file($_FILES["screenshot"]["tmp_name"], $full_path)) {
        $response["success"] = false;
        $response["message"] = "Invalid directory to upload image!";
        print_r(json_encode($response));
        return false;
    }
}

$sql = "INSERT INTO check_fake_jobs (user_id,title,description,screenshot) VALUES ($user_id,'$title''$title','$description', '$upload_image2')";
$db->sql($sql);
$sql = "SELECT * FROM check_fake_jobs ";
$db->sql($sql);
$res = $db->getResult();
$response['success'] = true;
$response['message'] = "Jobs added Successfully";
$response['data'] = $res;
print_r(json_encode($response));

?>
