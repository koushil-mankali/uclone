<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if(!(isset($_SESSION['isLogin']) && isset($_SESSION['uemail']))){
    header('location:../login');
}

$page = "close_acc";

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
                <div class="cls_acc_bdy">
                    <div>Once you delete you'r account you can't restore it back, If you want to continue click on the agree checkbox and you will be able to delete you'r account.</div>
                    <br />
                    <br />
                    <form action="close_acc_r" method="POST" name="" id="" class="">
                        <label for="">Agree To Delete Account:</label>
                        <input type="checkbox" name="agree" id="agree">
                        <br />
                        <br />
                        <input type="submit" value="Delete Account" id="delete" class="stu_acc_set_sbtn" name="delete">
                    </form>
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