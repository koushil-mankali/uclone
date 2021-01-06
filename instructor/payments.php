<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
require_once("../database/dbconn.php");

$page = "payments";

$usemail = $_SESSION['iemail'];

$db = new Database();

if(isset($_POST['ord_id'])){
    $ord_id =$_POST['ord_id'];
    // $sql = "select * from course_order where or_id='$ord_id'";
    if($db->select('course_order','course_order.or_id,course_order.txn_amt,course_order.txn_dt,course_order.or_msg,course_order.stu_email,u.uname,c.crs_nm','user_data as u ON course_order.stu_email = u.uemail INNER JOIN courses as c ON course_order.crs_token = c.crs_token',"course_order.or_id ='$ord_id' AND course_order.crs_creator = '$usemail'")){
        $em = $db->getResult();
        $or_id = isset($em[0]['or_id']) ? $em[0]['or_id'] :  $err = "Error Fetching Data";;
        $txn_amt = isset($em[0]['txn_amt']) ? $em[0]['txn_amt'] :  $err = "Error Fetching Data";;
        $txn_dt = isset($em[0]['txn_dt']) ? $em[0]['txn_dt'] :  $err = "Error Fetching Data";;
        $or_msg = isset($em[0]['or_msg']) ? $em[0]['or_msg'] :  $err = "Error Fetching Data";;
        $stu_email = isset($em[0]['stu_email']) ? $em[0]['stu_email'] :  $err = "Error Fetching Data";;
        $uname = isset($em[0]['uname']) ? $em[0]['uname'] :  $err = "Error Fetching Data";;
        $crs_nm = isset($em[0]['crs_nm']) ? $em[0]['crs_nm'] :  $err = "Error Fetching Data";;
    }else{
        $err = "Error Fetching Data";
    }
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

            <div class="pay_det_box">
                <form action="" id="pay_fm" method="POST" class="pay_fm" >
                    <div class="pay_det_sch">
                        <span ><i id="pay_ic" class="fas fa-file-invoice"></i></span>
                        <input type="text" name="ord_id" id="pay_id_inp" class="pay_id_inp">
                    </div>
                    <!-- <input type="submit" name="signup" value="" id=""> -->
                </form>
                <?php if(isset($err)){ ?>
                <div class="err">
                    <span><?php echo $err; ?></span>
                </div>
                <?php } ?>
            </div>
        
            <div class="dash_sec2">

                <div class="student_details2" id="student_details2">
                    <div class="stu_d_h">Payment Details</div>
                    <table class="stu_d_tb" id="stu_d_tb">
                        <tr class="stu_d_th2">
                            <th>Order ID</th>
                            <th class="stu_d_tdd2"><?php if(isset($ord_id)){ echo $ord_id;} ?></th>
                        </tr>
                        <tr class="stu_d_td">
                            <td>Name</td>
                            <td><?php if(isset($uname)){ echo $uname;} ?></td>
                        </tr>
                        <tr class="stu_d_td">
                            <td>Email</td>
                            <td><?php if(isset($stu_email)){ echo $stu_email;} ?></td>
                        </tr>
                        <tr class="stu_d_td">
                            <td>Course</td>
                            <td><?php if(isset($crs_nm)){ echo $crs_nm;} ?></td>
                        </tr>
                        <tr class="stu_d_td">
                            <td>Amount</td>
                            <td><?php if(isset($txn_amt)){ echo $txn_amt;} ?></td>
                        </tr>
                        <tr class="stu_d_td">
                            <td>Transaction Status</td>
                            <td><?php if(isset($or_msg)){ echo $or_msg;} ?></td>
                        </tr>
                        <tr class="stu_d_td">
                            <td>Date</td>
                            <td><?php if(isset($txn_dt)){ echo $txn_dt;} ?></td>
                        </tr>
                    </table>
                    <button class="print_btn" onclick="window.print()">Print</button>
                </div>            
            </div>

        </div>
    </div>

    <script src="../javascript/jquery.js"></script>
    <script src="../javascript/all.js"></script>
    <script src="../javascript/instructorPanel.js"></script>
</body>
</html>