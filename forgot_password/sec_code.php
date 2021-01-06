<?php
session_start();
require_once('../database/dbconn.php');

if(!(isset($_SESSION['uemail']) || isset($_SESSION['iemail']))){
    header('location:index');
}else{
    $db = new Database();
    try{
        if(isset($_POST['vsubmit'])){
            if(($_POST['vcode'] == "")){
                $err="Please Enter 4 Digit Code!";
            }else{
                $uemail = isset($_SESSION['uemail']) ? $_SESSION['uemail'] : $_SESSION['iemail'] ;
                $code =htmlentities($_POST['vcode']);
                $db->select("password_reset","code",null,"email ='$uemail'",null,null);
                $em = $db->getResult();
                if($em[0]['code'] == $code){
                        header('location:new_password');
                }else{
                    $err="Wrong Code!";
                }
            }
        }
    }catch(Exception $e){
        $err = "Something went wrong please try again!!!!";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Enter Code</title>
    <link rel="stylesheet" href="../css/all.css">
    <link rel="stylesheet" href="../css/forgotPassword.css">
</head>
<body>
    
    <div class="email_verify">

        <div class="reset_modal">
            <form action="" method="POST" id="code_f">
                <div class="em_succ">Enter 4 Digit Code Mailed To You</div>
                <div class="ent_cd">
                    <span class="l_entcd">Enter Code: </span>
                    <input type="text" name="vcode" id="vcode" class="vcode" maxlength="8">
                </div>
                <div class='lg_btn'>
                    <input type="submit" name="vsubmit" value="Submit" id="vsubmit" class="fsubmit">
                </div>
            </form>
            <div class="lg_sg">Don't have an account? <a href="signup">Sign up</a></div>
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