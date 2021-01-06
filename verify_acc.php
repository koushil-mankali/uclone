<?php
if(!isset($_GET['token'])){
    // redirect them to your desired location
    header('location:err404.php');
    exit;
}
require_once("database/dbconn.php");
$db = new Database();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify Account | MK ELearn</title>
    <link rel="stylesheet" href="css/all.css">
    <link rel="stylesheet" href="css/custom.css">
    <link rel="stylesheet" href="css/verifyAcc.css">
</head>
<body>
    <!-- Header Section Start -->
    <?php include_once('inc/header.php') ?>
    <!-- Header Section End -->
   <div class="bdy">
        <?php
            $token = isset($_GET['token']) ? $_GET['token'] : false;
            $type = isset($_GET['type']) ? $_GET['type'] : false;
            $cmn_msg = "<div class='dv1'>
                            <div class='div12'>Account Already Verified!</div>
                            <div class='div13'>Go To <a href='./'>HomePage</a></div>
                        </div>";
            if($token){
                if($db->select('user_verify','uname,uemail,upassword,status',null,"token = '$token'")){
                    $em = $db->getResult();
                    $uname = $em[0]['uname'];
                    $uemail = $em[0]['uemail'];
                    $upassword = $em[0]['upassword'];
                    $status = $em[0]['status'];
                    if($status == 0){
                        if($type){
                            if($type == 'user'){
                                if($db->update('user_verify','status=1',"token = '$token'")){
                                    if($db->insert('user_data',['uname'=>$uname,'uemail'=>$uemail,'upassword'=>$upassword,])){
                                        echo "<div class='dv1'>
                                                    <div class='div12'>Account Verified Successfully!</div>
                                                </div>";
                                        echo "<script>
                                                    setTimeout(()=>{
                                                        window.location.href='student/';
                                                    },2000);
                                                </script>";
                                    }
                                }
                            }else if($type == 'instructor'){
                                if($db->update('user_verify','status=1',"token = '$token'")){
                                    if($db->insert('instructor_data',['iname'=>$uname,'iemail'=>$uemail,'ipass'=>$upassword,])){
                                        echo "<div class='dv1'>
                                                    <div class='div12'>Account Verified Successfully!</div>
                                                </div>";
                                        echo "<script>
                                                    setTimeout(()=>{
                                                        window.location.href='instructor/login';
                                                    },2000);
                                                </script>";
                                    }
                                }
                            }else{
                                echo $cmn_msg;
                            }
                        }else{
                            echo $cmn_msg;
                        }
                    }else if($status == 1){
                        echo $cmn_msg;
                    }else{
                        echo $cmn_msg;
                    }
                }else{
                    echo $cmn_msg;
                }
            }else{
                echo $cmn_msg;
            }
        ?>
   </div>
   <!-- Footer Section Start -->
   <?php include_once('inc/footer.php') ?>
    <!-- Footer Section End -->
</body>
</html>