<?php
if(!isset($_SERVER['HTTP_REFERER'])){
    // redirect them to your desired location
    header('location:../err404.php');
    exit;
}
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if(!(isset($_SESSION['isLogin']) && isset($_SESSION['uemail']))){
    header('location:../login');
}
require_once("../database/dbconn.php");

$usemail = $_SESSION['uemail'];

$db = new Database();

$db->select('user_data','uname,u_pic',null,"uemail='$usemail'");
$em=$db->getResult();
$name=$em[0]['uname'];
$pic=$em[0]['u_pic'];

?>
<div class="stu_acc_set_l">
    <div class="stu_acc_pro">
        <div class="stu_acc_img_div"><img src="../images/students/<?php echo $pic ?>" alt="profile photo" class="stu_acc_img"></div>
        <div class="stu_acc_nm"><?php if(isset($name)){ echo $name;}else {echo "MK Learning";} ?></div>
    </div>
    <ul class="stu_set_ul">
        <a class="stu_set_a <?php if(isset($page) && $page == "settings"){ echo "stu_set_a_act";} ?>" href="settings"><li>Settings</li></a>
        <a class="stu_set_a <?php if(isset($page) && $page == "payment_history"){ echo "stu_set_a_act";} ?>" href="payment_history"><li>Payments</li></a>
        <a class="stu_set_a <?php if(isset($page) && $page == "close_acc"){ echo "stu_set_a_act";} ?>" href="close_acc"><li>Close Account</li></a>
    </ul>
</div>