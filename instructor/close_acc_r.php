<?php
if(!isset($_SERVER['HTTP_REFERER'])){
    // redirect them to your desired location
    header('location:../err404.php');
    exit;
}
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if(!(isset($_SESSION['isLogin']) && isset($_SESSION['iemail']))){
    header('location:login');
}

require_once("../database/dbconn.php");

$page = "close_acc_r";

$usemail = $_SESSION['iemail'];

$db = new Database();

if(isset($_POST['delete'])){
    $db->select('instructor_data','ipic',null,"iemail='$usemail'");
    $em=$db->getResult();
    $cont = count($em);
    if($cont > 0){
        $pic=$em[0]['ipic'];
        $dest_nm = "../images/instructors/";
        $unset_img = $dest_nm.$pic;
        unlink($unset_img);
        if($db->delete('instructor_data',"iemail = '$usemail'")){
            $db->delete('user_verify',"uemail = '$usemail'");
            $db->select('courses','crs_img,crs_token',null,"crs_creator='$usemail'");
            $em=$db->getResult();
            $cnt = count($em);
            $i=0;
            while($i<$cnt){
                $pic=$em[$i]['crs_img'];
                $dest_nm = "../images/courses/";
                $unset_img = $dest_nm.$pic;
                if($pic != ""){
                    unlink($unset_img);
                }
                $token=$em[$i]['crs_token'];
                $db->select('lectures','lct_vid',null,"crs_token='$token'");
                $em2=$db->getResult();
                $cnt2 = count($em2);
                $j=0;
                while($j<$cnt2){
                    $vid=$em2[$j]['lct_vid'];
                    $dest_nm2 = "../videos/";
                    $unset_vid = $dest_nm2.$vid;
                    if($vid != ""){
                        unlink($unset_vid);
                    }
                    $j++;
                }
                $tkn = $em[$i]['crs_token'];
                $db->delete('lectures',"crs_token = '$tkn'");
                $i++;
            }
            $db->delete('courses',"crs_creator = '$usemail'");
            $scr_msg = "It's Unbearable to see you leaving us, we hope you will come back soon...";
            echo "<script> setTimeout(()=>{
                window.location.href='../';
            },3000);</script>";
            session_unset();
            session_destroy();
        }
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