<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
require_once("../database/dbconn.php");

$page = "students";

$usemail = $_SESSION['iemail'];

$db = new Database();

if($db->select('course_order','u.uname,c.crs_nm','user_data as u ON course_order.stu_email = u.uemail INNER JOIN courses as c ON course_order.crs_token = c.crs_token',"course_order.crs_creator = '$usemail'")){
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
    <title>Students Record</title>
    <link rel="stylesheet" href="css/all.css">
    <link rel="stylesheet" href="../css/instructorPanel.css">
</head>
<body>
    <?php include_once('../inc/instHeader.php') ?>

    <div class="inst_ss">  
        <?php include_once('sidebar.php') ?>

        <div class="dash">

        <div class="student_details">
            <div class="stu_d_h">Student Details</div>
            <table class="stu_d_tb" id="stu_d_tb">
                <tr class="stu_d_th">
                    <th>ID</th>
                    <th>Name</th>
                    <th>Courses Enrolled</th>
                </tr>
                <?php $i=0;  while($i<$cnt){
                echo "<tr class='stu_d_td'>";
                    $uname = isset($em[$i]['uname']) ? $em[$i]['uname'] :  $err = "Error Fetching Data";;
                    $crs_nm = isset($em[$i]['crs_nm']) ? $em[$i]['crs_nm'] :  $err = "Error Fetching Data";
                    echo"<td>$cnt</td>
                    <td>$uname</td>
                    <td>$crs_nm</td>
                    </tr>";
                    $i++;
                 } ?>
            </table>
        </div>


        </div>

    </div>

    <script src="../javascript/jquery.js"></script>
    <script src="../javascript/all.js"></script>
    <script src="../javascript/instructorPanel.js"></script>
</body>
</html>