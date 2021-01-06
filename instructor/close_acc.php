<?php 
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if(!(isset($_SESSION['isLogin']) && isset($_SESSION['iemail']))){
    header('location:login');
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Close Acc</title>
    <link rel="stylesheet" href="css/all.css">
    <link rel="stylesheet" href="../css/instructorPanel.css">
</head>
<body>
    <?php include_once('../inc/instHeader.php') ?>

    <div class="inst_ss">  
        <?php include_once('sidebar.php') ?>


        <div class="dash">
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


</div>


<script src="../javascript/jquery.js"></script>
<script src="../javascript/all.js"></script>
<script src="../javascript/instructorPanel.js"></script>
</body>
</html>
