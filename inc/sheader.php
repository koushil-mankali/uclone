<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
require_once("../database/dbconn.php");

$usemail = $_SESSION['uemail'];
$db = new Database();

$db->select('user_data','u_pic',null,"uemail='$usemail'");
$em=$db->getResult();
$pic=$em[0]['u_pic'];

?>
<header>
    <div class="stu_header">
        <a href="../" class="web_ttl">MK ELearning</a>
        <ul class="myacc">
            <li><img src="../images/students/<?php echo $pic; ?>" alt="" class="u_profile"></li>
            <ul class="myacc_dropdown">
                <li class="dropdown_li"><a href="./">My Account</a></li>
                <li class="dropdown_li"><a href="payment_history">Payments</a></li>
                <li class="dropdown_li"><a href="settings">Settings</a></li>
                <li class="dropdown_li"><a href="close_acc">Close Account</a></li>
                <li class="dropdown_li"><a href="logout">Logout</a></li>
            </ul>
        </ul>    
    </div>
</header>