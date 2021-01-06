<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if(!(isset($_SESSION['isLogin']) && isset($_SESSION['uemail']))){
    header('location:../login');
}
require_once("../database/dbconn.php");

$page = "payment_history";

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

    <div class="stu_acc_set">
        <?php include_once('left_sidebar.php')?>
        <div class="stu_acc_set_r">
            <div class="stu_acc_set_ttl">Profile Settings</div>
            <div class="stu_acc_set_bdy">
            <?php if(isset($msg)){ ?>
            <div class="msg">
                <span><?php echo $msg; ?></span>
            </div>
            <?php } ?>
            <?php if(isset($err)){ ?>
            <div class="err">
                <span><?php echo $err; ?></span>
            </div>
            <?php } ?>
                <div class="student_details">
                    <div class="stu_d_h">Payments History</div>
                    <table class="stu_d_tb" id="stu_d_tb">
                        <tr class="stu_d_th">
                            <th>Order ID</th>
                            <th>Course Enrolled</th>
                            <th>Amount</th>
                            <th>Transaction Date</th>
                            <th>Status</th>
                        </tr>
                        <?php
                        if($db->select('course_order','course_order.or_id,course_order.txn_amt,course_order.txn_dt,course_order.or_msg,c.crs_nm','courses as c ON course_order.crs_token = c.crs_token',"course_order.stu_email = '$usemail'","course_order.txn_dt DESC",['0'=>30])){
                            $em = $db->getResult();
                            $cnt = count($em) == 0 ? $er = "" : count($em);
                        }else{
                            $err = "Error Fetching Data";
                        }
                        $i=0;  while($i<$cnt){
                        $or_id = isset($em[$i]['or_id']) ? $em[$i]['or_id'] :  $err = "Error Fetching Data";
                        $txn_amt = isset($em[$i]['txn_amt']) ? $em[$i]['txn_amt'] :  $err = "Error Fetching Data";;
                        $txn_dt = isset($em[$i]['txn_dt']) ? $em[$i]['txn_dt'] :  $err = "Error Fetching Data";
                        $or_msg = isset($em[$i]['or_msg']) ? $em[$i]['or_msg'] :  $err = "Error Fetching Data";
                        $crs_nm = isset($em[$i]['crs_nm']) ? $em[$i]['crs_nm'] :  $err = "Error Fetching Data";
                        echo "<tr class='stu_d_td'>";
                        echo   "<td>$or_id</td>
                                <td>$crs_nm</td>
                                <td>$txn_amt</td>
                                <td>$txn_dt</td>
                                <td>$or_msg</td>
                                </tr> ";
                                $i++;
                        }?>
                    </table>
                </div>
            </div>
        </div>
    </div>

<?php include_once("../inc/sfooter.php") ?>
    <script src="../javascript/jquery.js"></script>
    <script src="../javascript/all.js"></script>
    <script src="../javascript/studentPanel.js"></script>
</body>
</html>