<?php
session_start();
require_once('../database/dbconn.php');

if(!(isset($_SESSION['uemail']) || isset($_SESSION['iemail']))){
    header('location:index');
}else{
    $db = new Database();
    try{
        if(isset($_POST['nsubmit'])){
            if(($_POST['lpass'] == "")){
                $err="Please Enter a New Password!";
            }else{
                if(isset($_SESSION['iemail'])){
                    $uemail=$_SESSION['iemail'];
                    $pass =password_hash(htmlentities($_POST['lpass']),PASSWORD_BCRYPT);
                    if($db->update('instructor_data',"ipass='$pass'","iemail='$uemail'")){
                        $db->update('user_verify',"upassword='$pass'","uemail='$uemail'");
                        $msg="Success Fully Updated Password";
                    }else{
                        $err="Unable To Update Password Please Try Again!";
                    }
                }else{
                    $uemail=$_SESSION['uemail'];
                    $pass =password_hash(htmlentities($_POST['lpass']),PASSWORD_BCRYPT);
                    if($db->update('user_data',"upassword='$pass'","uemail='$uemail'")){
                        $db->update('user_verify',"upassword='$pass'","uemail='$uemail'");
                        $msg="Success Fully Updated Password";
                    }else{
                        $err="Unable To Update Password Please Try Again!";
                    }
                }
            }
        }
    }catch(Exception $e){
        $err = "Something went wrong please try again!!!!" . $e;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Password</title>
    <link rel="stylesheet" href="../css/all.css">
    <link rel="stylesheet" href="../css/forgotPassword.css">
</head>
<body>
    
    <div class="email_verify">
        <div class="reset_modal">
            <form action="" method="POST" id="new_f">
                <div class="lgpassowrd">
                    <label for="lpass" class="login_lbl">New Password</label>
                    <span class="int_lpass"><i class="fas fa-lock"></i></span>
                    <input type="password" name="lpass" id="lpass" class="lg_inpt">
                </div>
                <div class='lg_btn'>
                    <input type="submit" name="nsubmit" value="Update" id="esubmit" class="fsubmit">
                </div>
            </form>
            <?php if(isset($msg)){ ?>
            <div class="msg">
                <span><?php echo $msg; ?></span>
                <div class='lg_btn'>
                <a href='../instructor/login' id='esubmit' class='fsubmit'>
                </div>
            </div>
            <?php } ?>
            <?php if(isset($err)){ ?>
            <div class="err">
                <span><?php echo $err; ?></span>
            </div>
            <?php } ?>
        </div>
    </div>

    <script src="../javascript/jquery.js"></script>
    <script src="../javascript/all.js"></script>
    <script src="../javascript/resetPassword.js"></script>
</body>
</html>