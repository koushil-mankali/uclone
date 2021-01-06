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

$db->select('courses','id',null,"crs_creator='$usemail'");
$em=$db->getResult();
$crs_count = count($em);

$db->select('course_order','DISTINCT stu_email',null,"crs_creator='$usemail'");
$st=$db->getResult();
$stu_count = count($st);

$db->select('course_order','crs_token',null,"crs_creator='$usemail'");
$crs_sld=$db->getResult();
$crs_sld_cnt = count($crs_sld);

if($db->select('course_order','course_order.crs_ord_id,course_order.or_id,u.uname,c.crs_nm','user_data as u ON course_order.stu_email = u.uemail INNER JOIN courses as c ON course_order.crs_token = c.crs_token',"course_order.crs_creator = '$usemail'","course_order.crs_ord_id DESC",['0'=>10])){
    $em = $db->getResult();
    $cnt = count($em) == 0 ? $er = "" : count($em);
}else{
    $err = "Error Fetching Data";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="css/all.css">
    <link rel="stylesheet" href="../css/instructorPanel.css">
</head>
<body>
    <?php include_once('../inc/instHeader.php') ?>

    <div class="inst_ss">  
        <?php include_once('sidebar.php') ?>


        <div class="dash">

            <!-- Section 1 Start  -->

            <div class="dash_sec1">
                <div class="dash_sec1_box">
                    <div class="dash_sec1_box_ttl tx-ct"><i class="fas fa-video"></i>&nbsp; Courses</div>
                    <div class="dash_sec1_box_bdy tx-ct"><div class="dash_sec1_no"><?php if(isset($crs_count)){ echo $crs_count;}else{ echo "No Data";} ?></div></div>
                    <a href="courses" class="dash_sec1_box_vw tx-ct">View</a>
                </div>

                <div class="dash_sec1_box">
                    <div class="dash_sec1_box_ttl tx-ct"><i class="fas fa-users"></i>&nbsp; Students</div>
                    <div class="dash_sec1_box_bdy tx-ct"><div class="dash_sec1_no"><?php if(isset($stu_count)){ echo $stu_count;}else{ echo "No Data";} ?></div></div>
                    <a href="students" class="dash_sec1_box_vw tx-ct">View</a>
                </div>

                <div class="dash_sec1_box">
                    <div class="dash_sec1_box_ttl tx-ct">Courses Sold</div>
                    <div class="dash_sec1_box_bdy tx-ct"><div class="dash_sec1_no"><?php if(isset($crs_sld_cnt)){ echo $crs_sld_cnt;}else{ echo "No Data";} ?></div></div>
                    <a href="payments" class="dash_sec1_box_vw tx-ct">View</a>
                </div>
            </div>

            <!-- Section 1 End -->  


            <!-- Section 2 Start -->
            <div class="dash_sec2">
                <div class="student_details">
                    <div class="stu_d_h">New Enrollments</div>
                    <table class="stu_d_tb" id="stu_d_tb">
                        <tr class="stu_d_th">
                            <th>Name</th>
                            <th>Course Enrolled</th>
                            <th>Payment Id</th>
                        </tr>
                        <?php $i=0;  while($i<$cnt){
                        $or_id = isset($em[$i]['or_id']) ? $em[$i]['or_id'] :  $err = "Error Fetching Data";
                        $uname = isset($em[$i]['uname']) ? $em[$i]['uname'] :  $err = "Error Fetching Data";;
                        $crs_nm = isset($em[$i]['crs_nm']) ? $em[$i]['crs_nm'] :  $err = "Error Fetching Data";
                        echo "<tr class='stu_d_td'>";
                        echo   "<td>$uname</td>
                                <td>$crs_nm</td>
                                <td>$or_id</td>
                                </tr> ";
                                $i++;
                        }?>
                    </table>
                </div>
            </div>
            <!-- Section 2 End -->

        </div>


    </div>
    <script src="../javascript/jquery.js"></script>
    <script src="../javascript/all.js"></script>
    <script src="../javascript/instructorPanel.js"></script>
</body>
</html>