<?php
session_start();

// set time for session timeout
$currentTime = time() + 25200;
$expired = 3600;

// if session not set go to login page
if (!isset($_SESSION['username'])) {
    header("location:index.php");
}

// if current time is more than session timeout back to login page
if ($currentTime > $_SESSION['timeout']) {
    session_destroy();
    header("location:index.php");
}

// destroy previous session timeout and create new one
unset($_SESSION['timeout']);
$_SESSION['timeout'] = $currentTime + $expired;

header('Access-Control-Allow-Origin: *');
header("Content-Type: application/json");
header("Expires: 0");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");


include_once('../includes/custom-functions.php');
$fn = new custom_functions;
include_once('../includes/crud.php');
include_once('../includes/variables.php');
include_once('../includes/functions.php');
$fnc = new functions;
$db = new Database();
$db->connect();
$currentdate = date('Y-m-d');
if (isset($config['system_timezone']) && isset($config['system_timezone_gmt'])) {
    date_default_timezone_set($config['system_timezone']);
    $db->sql("SET `time_zone` = '" . $config['system_timezone_gmt'] . "'");
} else {
    date_default_timezone_set('Asia/Kolkata');
    $db->sql("SET `time_zone` = '+05:30'");
}
if (isset($_GET['table']) && $_GET['table'] == 'users') {
    $offset = 0;
    $limit = 10;
    $where = '';
    $sort = 'id';
    $order = 'DESC';

    if (isset($_GET['offset']))
        $offset = $db->escapeString($fn->xss_clean($_GET['offset']));
    if (isset($_GET['limit']))
        $limit = $db->escapeString($fn->xss_clean($_GET['limit']));

    if (isset($_GET['sort']))
        $sort = $db->escapeString($fn->xss_clean($_GET['sort']));
    if (isset($_GET['order']))
        $order = $db->escapeString($fn->xss_clean($_GET['order']));

        if (isset($_GET['search']) && !empty($_GET['search'])) {
            $search = $db->escapeString($fn->xss_clean($_GET['search']));
            $where = "WHERE u.name LIKE '%" . $search . "%' OR u.mobile LIKE '%" . $search . "%' OR u.email LIKE '%" . $search . "%' OR u.password LIKE '%" . $search . "%' OR u.skills LIKE '%" . $search . "%' OR u.place LIKE '%" . $search . "%'";
        } 
        
        
        $sql = "SELECT COUNT(`id`) as total FROM `users` u " . $where;
        $db->sql($sql);
        $res = $db->getResult();
        foreach ($res as $row) {
            $total = $row['total'];
        }
        
        $sql = "SELECT * FROM users u " . $where . " ORDER BY " . $sort . " " . $order . " LIMIT " . $offset . "," . $limit;
        $db->sql($sql);
        $res = $db->getResult();
        $bulkData = array();

        $bulkData['total'] = $total;
        $rows = array();
        $tempRow = array();
        foreach ($res as $row) {
        $operate = '<a href="edit-user.php?id=' . $row['id'] . '" class="text text-primary"><i class="fa fa-edit"></i>Edit</a>';
        $operate .= ' <a class="text text-danger" href="delete-user.php?id=' . $row['id'] . '"><i class="fa fa-trash"></i>Delete</a>';
        $tempRow['id'] = $row['id'];
        $tempRow['name'] = $row['name'];
        $tempRow['mobile'] = $row['mobile'];
        $tempRow['password'] = $row['password'];
        $tempRow['email'] = $row['email'];
        $tempRow['place'] = $row['place'];
        $tempRow['skills'] = $row['skills'];
        $tempRow['working_experience'] = $row['working_experience'];
        if($row['status']==0)
        $tempRow['status'] ="<label class='label label-default'>Deactive</label>";
    elseif($row['status']==1)
        $tempRow['status']="<label class='label label-success'>Active</label>";        
    else
        $tempRow['status']="<label class='label label-danger'>Blocked</label>";
    if($row['chat']==1)
        $tempRow['chat'] ="<p class='text text-success'>Enabled</p>";
    else
        $tempRow['chat']="<p class='text text-danger'>Disabled</p>";

        
        $tempRow['operate'] = $operate;

        $rows[] = $tempRow;
    }
    $bulkData['rows'] = $rows;
    print_r(json_encode($bulkData));
}



if (isset($_GET['table']) && $_GET['table'] == 'real_jobs') {
    $offset = 0;
    $limit = 10;
    $where = '';
    $sort = 'id';
    $order = 'DESC';

    if (isset($_GET['offset']))
        $offset = $db->escapeString($fn->xss_clean($_GET['offset']));
    if (isset($_GET['limit']))
        $limit = $db->escapeString($fn->xss_clean($_GET['limit']));

    if (isset($_GET['sort']))
        $sort = $db->escapeString($fn->xss_clean($_GET['sort']));
    if (isset($_GET['order']))
        $order = $db->escapeString($fn->xss_clean($_GET['order']));

        if (isset($_GET['search']) && !empty($_GET['search'])) {
            $search = $db->escapeString($fn->xss_clean($_GET['search']));
            $where = "WHERE u.company_name LIKE '%" . $search . "%' OR u.title LIKE '%" . $search . "%'";
        } 
        
        
        $sql = "SELECT COUNT(`id`) as total FROM `real_jobs` r " . $where;
        $db->sql($sql);
        $res = $db->getResult();
        foreach ($res as $row) {
            $total = $row['total'];
        }
        
        $sql = "SELECT * FROM real_jobs r " . $where . " ORDER BY " . $sort . " " . $order . " LIMIT " . $offset . "," . $limit;
        $db->sql($sql);
        $res = $db->getResult();
        $bulkData = array();

        $bulkData['total'] = $total;
        $rows = array();
        $tempRow = array();
        foreach ($res as $row) {
            $target_path = 'upload/image/';
        $operate = '<a href="edit-real-jobs.php?id=' . $row['id'] . '" class="text text-primary"><i class="fa fa-edit"></i>Edit</a>';
        $operate .= ' <a class="text text-danger" href="delete-real-jobs.php?id=' . $row['id'] . '"><i class="fa fa-trash"></i>Delete</a>';
        $tempRow['id'] = $row['id'];
        $tempRow['company_name'] = $row['company_name'];
        $tempRow['title'] = $row['title'];
        $tempRow['description'] = $row['description'];
        $tempRow['income'] = $row['income'];
        $tempRow['image'] = "<a href='" . $row['image'] . "' target='_blank'><img src='" . $target_path .$row['image'] . "' height='50' /></a>";
        $tempRow['operate'] = $operate;

        $rows[] = $tempRow;
    }
    $bulkData['rows'] = $rows;
    print_r(json_encode($bulkData));
}

if (isset($_GET['table']) && $_GET['table'] == 'fake_jobs') {
    $offset = 0;
    $limit = 10;
    $where = '';
    $sort = 'id';
    $order = 'DESC';

    if (isset($_GET['offset']))
        $offset = $db->escapeString($fn->xss_clean($_GET['offset']));
    if (isset($_GET['limit']))
        $limit = $db->escapeString($fn->xss_clean($_GET['limit']));

    if (isset($_GET['sort']))
        $sort = $db->escapeString($fn->xss_clean($_GET['sort']));
    if (isset($_GET['order']))
        $order = $db->escapeString($fn->xss_clean($_GET['order']));

        if (isset($_GET['search']) && !empty($_GET['search'])) {
            $search = $db->escapeString($fn->xss_clean($_GET['search']));
            $where = "WHERE f.title LIKE '%" . $search . "%'";
        } 
        
        
        $sql = "SELECT COUNT(`id`) as total FROM `fake_jobs` f " . $where;
        $db->sql($sql);
        $res = $db->getResult();
        foreach ($res as $row) {
            $total = $row['total'];
        }
        
        $sql = "SELECT * FROM fake_jobs f " . $where . " ORDER BY " . $sort . " " . $order . " LIMIT " . $offset . "," . $limit;
        $db->sql($sql);
        $res = $db->getResult();
        $bulkData = array();

        $bulkData['total'] = $total;
        $rows = array();
        $tempRow = array();
        foreach ($res as $row) {
            $target_path = 'upload/image/';
            $operate = '<a href="edit-fake-jobs.php?id=' . $row['id'] . '" class="text text-primary"><i class="fa fa-edit"></i>Edit</a>';
            $operate .= ' <a class="text text-danger" href="delete-fake-jobs.php?id=' . $row['id'] . '"><i class="fa fa-trash"></i>Delete</a>';
            $tempRow['id'] = $row['id'];
            $tempRow['title'] = $row['title'];
            $tempRow['image'] = "<a href='" . $target_path.$row['image'] . "' target='_blank'><img src='" .$target_path. $row['image'] . "' height='100' /></a>";
            $tempRow['operate'] = $operate;
        
            $rows[] = $tempRow;
        }
        
        $bulkData['rows'] = $rows;
        print_r(json_encode($bulkData));
    }        
    if (isset($_GET['table']) && $_GET['table'] == 'check_fake_jobs') {
        $offset = 0;
        $limit = 10;
        $where = '';
        $sort = 'id';
        $order = 'DESC';
    
        if (isset($_GET['offset']))
            $offset = $db->escapeString($fn->xss_clean($_GET['offset']));
        if (isset($_GET['limit']))
            $limit = $db->escapeString($fn->xss_clean($_GET['limit']));
    
        if (isset($_GET['sort']))
            $sort = $db->escapeString($fn->xss_clean($_GET['sort']));
        if (isset($_GET['order']))
            $order = $db->escapeString($fn->xss_clean($_GET['order']));
    
            if (isset($_GET['search']) && !empty($_GET['search'])) {
                $search = $db->escapeString($fn->xss_clean($_GET['search']));
                $where = "WHERE f.title LIKE '%" . $search . "%'";
            } 
            
            
            $sql = "SELECT COUNT(`id`) as total FROM `check_fake_jobs` c " . $where;
            $db->sql($sql);
            $res = $db->getResult();
            foreach ($res as $row) {
                $total = $row['total'];
            }
            
            $sql = "SELECT * FROM check_fake_jobs c " . $where . " ORDER BY " . $sort . " " . $order . " LIMIT " . $offset . "," . $limit;
            $db->sql($sql);
            $res = $db->getResult();
            $bulkData = array();
    
            $bulkData['total'] = $total;
            $rows = array();
            $tempRow = array();
            foreach ($res as $row) {
                $operate = '<a href="edit-check-fake-jobs.php?id=' . $row['id'] . '" class="text text-primary"><i class="fa fa-edit"></i>Edit</a>';
                $operate .= ' <a class="text text-danger" href="delete-fake-jobs.php?id=' . $row['id'] . '"><i class="fa fa-trash"></i>Delete</a>';
                $tempRow['id'] = $row['id'];
                $tempRow['title'] = $row['title'];
                $tempRow['description'] = $row['description'];
                $tempRow['screenshot'] = "<a href='" . $row['screenshot'] . "' target='_blank'><img src='" . $row['screenshot'] . "' height='50' /></a>";
                if($row['status']==0){
                    $tempRow['status']="<p class='text text-primary'>Pending</p>";        
                }
                elseif($row['status']==1){
                    $tempRow['status']="<p class='text text-success'>Fake</p>";        
                }
                else{
                    $tempRow['status']="<p class='text text-danger'>Real</p>";        
                }
                $tempRow['operate'] = $operate;
            
                $rows[] = $tempRow;
            }
            
            $bulkData['rows'] = $rows;
            print_r(json_encode($bulkData));
        }        

        if (isset($_GET['table']) && $_GET['table'] == 'payments') {
            $offset = 0;
            $limit = 10;
            $where = '';
            $sort = 'id';
            $order = 'DESC';
            // if ((isset($_GET['user_id']) && $_GET['user_id'] != '')) {
            //     $user_id = $db->escapeString($fn->xss_clean($_GET['user_id']));
            //     $where .= "AND r.user_id = '$user_id'";
            // }
              
            if (isset($_GET['offset']))
                $offset = $db->escapeString($fn->xss_clean($_GET['offset']));
            if (isset($_GET['limit']))
                $limit = $db->escapeString($fn->xss_clean($_GET['limit']));
        
            if (isset($_GET['sort']))
                $sort = $db->escapeString($fn->xss_clean($_GET['sort']));
            if (isset($_GET['order']))
                $order = $db->escapeString($fn->xss_clean($_GET['order']));
             
                if (isset($_GET['search']) && !empty($_GET['search'])) {
                    $search = $db->escapeString($fn->xss_clean($_GET['search']));
                    $where = "WHERE u.name LIKE '%" . $search . "%' OR u.mobile LIKE '%" . $search . "%' OR u.email LIKE '%" . $search . "%' OR u.password LIKE '%" . $search . "%' OR u.skills LIKE '%" . $search . "%' OR u.place LIKE '%" . $search . "%'";
                } 
            if (isset($_GET['sort'])) {
                $sort = $db->escapeString($_GET['sort']);
            }
            if (isset($_GET['order'])) {
                $order = $db->escapeString($_GET['order']);
            }
          
            $join = "LEFT JOIN `users` u ON l.user_id = u.id WHERE l.id IS NOT NULL " . $where;

            $sql = "SELECT COUNT(l.id) AS total FROM `payments` l " . $join;
            $db->sql($sql);
            $res = $db->getResult();
            foreach ($res as $row)
                $total = $row['total'];
           
             $sql = "SELECT l.id AS id,l.*,u.name,u.mobile,l.payment_status AS status ,l.image AS image FROM `payments` l " . $join . " ORDER BY $sort $order LIMIT $offset, $limit";
             $db->sql($sql);
             $res = $db->getResult();


            $bulkData = array();
            $bulkData['total'] = $total;
            $rows = array();
            $tempRow = array();
            foreach ($res as $row) {
        
                $operate = '<a href="edit-payments.php?id=' . $row['id'] . '" class="text text-primary"><i class="fa fa-edit"></i>Edit</a>';
                $operate .= ' <a class="text text-danger" href="delete-payments.php?id=' . $row['id'] . '"><i class="fa fa-trash"></i>Delete</a>';
                $tempRow['id'] = $row['id'];
                $tempRow['name'] = $row['name'];
                $tempRow['mobile'] = $row['mobile'];
                $tempRow['image'] = "<a href='" . $row['image'] . "' target='_blank'><img src='" . $row['image'] . "' height='50' /></a>";
                if($row['payment_status']==1)
        $tempRow['payment_status'] ="<p class='text text-success'>Success</p>";
    else
        $tempRow['payment_status']="<p class='text text-danger'>Pending</p>";

        
                $tempRow['operate'] = $operate;
                $rows[] = $tempRow;
            }
            $bulkData['rows'] = $rows;
            print_r(json_encode($bulkData));
        }