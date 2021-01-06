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

$page = "close_acc";

$usemail = $_SESSION['uemail'];

$db = new Database();

if(isset($_POST['delete'])){
    $db->select('user_data','u_pic',null,"uemail='$usemail'");
    $em=$db->getResult();
    $pic=$em[0]['u_pic'];
    $dest_nm = "../images/students/";
    $unset_img = $dest_nm.$pic;
    unlink($unset_img);
    if($db->delete('user_data',"uemail = '$usemail'")){
        $db->delete('user_verify',"uemail = '$usemail'");
        $scr_msg = "It's Unbearable to see you leaving us, we hope you will come back soon...";
        echo "<script> setTimeout(()=>{
            window.location.href='../';
        },3000);</script>";
        session_unset();
        session_destroy();
    }else{
        $err = "Unable to Delete Account try Again!";
        echo "<script> setTimeout(()=>{
            window.location.href='close_acc';
        },3000);</script>";
    }
}else{
    header('location:../err404');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Closing Account</title>
    <link rel="stylesheet" href="../css/all.css">
    <link rel="stylesheet" href="../css/close_acc.css">
</head>
<body>
    <div class="cls_bck">
        <div class="msg_box">
            <?php if(isset($scr_msg)){ ?>
            <div>
                <span class="mssg"><?php echo $scr_msg; ?></span>
            </div>
            <?php } ?>
            <?php if(isset($err)){ ?>
            <div >
                <span class="mssg"><?php echo $err; ?></span>
            </div>
            <?php } ?>
        </div>
    </div>
    <script src="../javascript/jquery.js"></script>
    <script src="../javascript/all.js"></script>
    <script src="../javascript/studentPanel.js"></script>
</body>
</html>