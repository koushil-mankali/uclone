<?php
if(!isset($_SERVER['HTTP_REFERER'])){
    // redirect them to your desired location
    header('location:err404.php');
    exit;
}

require_once("database/dbconn.php");
$db = new Database();

$mydata = file_get_contents("php://input");
$data = json_decode($mydata,true);
$token=$data['token'];


if($db->delete('cart',"cart_crs_token='$token'")){

}else{
    echo "Something Goes Wrong Please Try Again!";
}

?>