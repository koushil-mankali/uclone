<?php
if(!isset($_SERVER['HTTP_REFERER'])){
    // redirect them to your desired location
    header('location:./');
    exit;
}
require_once("database/dbconn.php");
$db = new Database();

$data = stripslashes(file_get_contents("php://input"));
$mydata = json_decode(utf8_decode($data), true);
$search = $mydata['search'];

if(!empty($search)){
    if($db->select('courses','crs_nm,crs_token',null,"crs_nm COLLATE UTF8_GENERAL_CI LIKE '%$search%'",null,['0'=>5])){
        $em = $db->getResult();
        $cnt = count($em) > 0 ? count($em) : false;
        if($cnt){
            echo json_encode($em);
        }
    }
}

?>
