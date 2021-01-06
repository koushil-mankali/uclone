<?php 
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if(!(isset($_SESSION['isLogin']) && isset($_SESSION['iemail']))){
    header('location:login');
}
require_once("../database/dbconn.php");

$page = "courses";

$usemail = $_SESSION['iemail'];

$db = new Database();

$db->select('courses','crs_nm,crs_img,crs_token',null,"crs_creator='$usemail'");
  


$em=$db->getResult();
$crs_cnt = count($em);
if($crs_cnt == 0){
    $no_data = "No Data";
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crouses</title>
    <link rel="stylesheet" href="css/all.css">
    <link rel="stylesheet" href="../css/instructorPanel.css">
</head>
<body>
    <?php include_once('../inc/instHeader.php') ?>

    <div class="inst_ss">  
        <?php include_once('sidebar.php') ?>

        <div class="dash">

            <div class="crs_h">Courses</div>
           
                <?php  $i=0; while($i< $crs_cnt){ ?>
                <div class="course_sec">
                    <img src="../images/courses/<?php if(isset($em[$i]['crs_img'])){echo $em[$i]['crs_img'];}?>" class="crs_img">
                    <div class="crs_name"><?php if(isset($em[$i]['crs_nm'])){echo $em[$i]['crs_nm'];}?></div>
                    <a href="add_lectures?crs_id=<?php if(isset($em[$i]['crs_token'])){echo $em[$i]['crs_token'];}?>" class="crs_add_lectures">Add/Edit Lectures</a>
                    <a href="create_courses?crs_id=<?php if(isset($em[$i]['crs_token'])){echo $em[$i]['crs_token'];}?>" class="crs_edit">Edit Course</a>
                    <a href="delete_courses?crs_id=<?php if(isset($em[$i]['crs_token'])){echo $em[$i]['crs_token'];}?>" class="crs_delete">Delete Course</a>
                </div>
                <?php $i++; }  if(isset($no_data)){echo "<span class='nodata'>$no_data</span>";}?>
            </div>

        </div>

    </div>

    <script src="../javascript/jquery.js"></script>
    <script src="../javascript/all.js"></script>
    <script src="../javascript/instructorPanel.js"></script>
</body>
</html>
