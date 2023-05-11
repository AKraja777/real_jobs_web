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

if (empty($_POST['name'])) {
    $response['success'] = false;
    $response['message'] = "Name is Empty";
    print_r(json_encode($response));
    return false;
}
if (empty($_POST['email'])) {
    $response['success'] = false;
    $response['message'] = "Email Id is Empty";
    print_r(json_encode($response));
    return false;
}
if (empty($_POST['mobile'])) {
    $response['success'] = false;
    $response['message'] = "mobile is Empty";
    print_r(json_encode($response));
    return false;
}
if (empty($_POST['password'])) {
    $response['success'] = false;
    $response['message'] = "password is Empty";
    print_r(json_encode($response));
    return false;
}
if (empty($_POST['place'])) {
    $response['success'] = false;
    $response['message'] = "place is Empty";
    print_r(json_encode($response));
    return false;
}
if (empty($_POST['skills'])) {
    $response['success'] = false;
    $response['message'] = "skills is Empty";
    print_r(json_encode($response));
    return false;
}



$name = $db->escapeString($_POST['name']);
$email = $db->escapeString($_POST['email']);
$mobile = $db->escapeString($_POST['mobile']);
$password = $db->escapeString($_POST['password']);
$place = $db->escapeString($_POST['place']);
$skills = $db->escapeString($_POST['skills']);
$working_experience = $db->escapeString($_POST['working_experience']);
$sql = "SELECT * FROM users WHERE mobile = '$mobile' AND email='$email'";
$db->sql($sql);
$res = $db->getResult();
$num = $db->numRows($res);

if ($num >= 1) {
    $response['success'] = false;
    $response['message'] = "You are Already Registered";
    print_r(json_encode($response));
} else {
    $sql = "INSERT INTO users (`name`,`email`,`mobile`,`password`,`place`,`skills`,`working_experience`) VALUES ('$name','$email','$mobile','$password','$place','$skills','$working_experience')";
    $db->sql($sql);
    $sql = "SELECT * FROM users WHERE email = '$email'";
    $db->sql($sql);
    $res = $db->getResult();
    $response['success'] = true;
    $response['message'] = "users added successfully";
    $response['data'] = $res;
    print_r(json_encode($response));
}