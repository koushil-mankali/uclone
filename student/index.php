<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if(!(isset($_SESSION['isLogin']) && isset($_SESSION['uemail']))){
    header('location:../login');
}
require_once("../database/dbconn.php");

$page = "student";

$usemail = $_SESSION['uemail'];

$db = new Database();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Panel</title>
    <link rel="stylesheet" href="../css/all.css">
    <link rel="stylesheet" href="../css/studentPanel.css">
</head>
<body>


    <!-- Header Section Start -->
    <?php include_once('../inc/sheader.php') ?>
    <!-- Header Section End -->

    <div class="stu_ban1">
        <img src="" alt="" class="stu_ban1_img">
    </div>

    <div class="section1">
        <p class="sec1_title">My Courses</p>

        <div class="my_courses">

            <?php
            if($db->select('course_order',"course_order.crs_token,courses.crs_nm,courses.crs_img,instructor_data.iname","courses ON course_order.crs_token = courses.crs_token INNER JOIN instructor_data ON course_order.crs_creator = instructor_data.iemail","course_order.stu_email = '$usemail'")){
                $em = $db->getResult();
                $cnt = count($em) == 0 ? $er = "" : count($em);
            }else{
                $err = "Unable to Fetch Data";
            }
            $i=0;  while($i<$cnt){
                $crs_img = isset($em[$i]['crs_img']) ? $em[$i]['crs_img'] :  $err = "Error Fetching Data";;
                $crs_nm = isset($em[$i]['crs_nm']) ? $em[$i]['crs_nm'] :  $err = "Error Fetching Data";
                $iname = isset($em[$i]['iname']) ? $em[$i]['iname'] :  $err = "Error Fetching Data";
                $crs_token = isset($em[$i]['crs_token']) ? $em[$i]['crs_token'] :  $err = "Error Fetching Data";
                echo 
                "<div class='my_course' onclick='location.href=\"course_page?crs_code=$crs_token\"'>
                    <div class='sec_img'>
                        <img src='../images/courses/$crs_img' alt='course image' class='sec_crs_img'>
                    </div>
                    <div class='sec_bdy'>
                        <p class='sec_crs_title'>$crs_nm</p>
                        <p class='sec_crs_author'>$iname</p>
                    </div>
                </div>";
                $i++;
                }
            ?>
        </div>
        
    </div>
    
    <?php include_once("../inc/sfooter.php") ?>
    <script src="../javascript/jquery.js"></script>
    <script src="../javascript/all.js"></script>
    <script src="../javascript/studentPanel.js"></script>
</body>
</html>