<?php
use PHPMailer\PHPMailer\PHPMailer;
session_start();
require_once('../database/dbconn.php');

$db = new Database();
try{
    if(isset($_POST['esubmit'])){
        if(($_POST['lemail'] == "")){
            $err="Please Enter You'r Email Id!";
        }else{
            if(isset($_GET['user']) &&  $_GET['user'] == "instructor"){ 
                $uemail =htmlentities($_POST['lemail']);
                $db->select("instructor_data","iemail",null,"iemail ='$uemail'",null,null);
                $em = $db->getResult();
                $cc = count($em);
                $token = bin2hex(random_bytes(4));

                if($cc > 0){
                    if($d=$db->insert('password_reset',['email'=>$uemail,'code'=>$token])){

                        
                        $subject = "Password Reset";
                        $message = "Here is You'r 4 Digit Code $token ";
                       
                        require_once "../smtp/PHPMailer.php";
                        require_once "../smtp/SMTP.php";
                        require_once "../smtp/Exception.php";

                        $mail = new PHPMailer();

                        //smtp settings
                        $mail->isSMTP();
                        $mail->Host = "smtp.gmail.com";
                        $mail->SMTPAuth = true;
                        $mail->Username = "koushil.webdeveloper@gmail.com";
                        $mail->Password = 'Hu$h0dROd9n=!e=as3?v';
                        $mail->Port = 465;
                        $mail->SMTPSecure = "ssl";

                        //email settings
                        $mail->isHTML(true);
                        $mail->setFrom('uclone@admin.com','Uclone');
                        $mail->addAddress($uemail);
                        $mail->Subject = ("uclone@admin.com ($subject)");
                        $mail->Body = $message;

                        if($mail->send()){
                            $msg="Password reset link has been mailed to you'r account.";
                            $_SESSION['iemail'] = $uemail;
                            echo "<script>setTimeout(()=>{ location.href='sec_code'; },2000);</script>";
                        }
                        else
                        {
                            $err="Something went wrong please try again!";
                        }
                    }
                }else{
                    $err="Email Id Doesn't Exists!";
                }
            }else{
                $uemail =htmlentities($_POST['lemail']);
                $db->select("user_data","uemail",null,"uemail ='$uemail'",null,null);
                $em = $db->getResult();
                $cc = count($em);
                $token = bin2hex(random_bytes(4));

                if($cc > 0){
                    if($d=$db->insert('password_reset',['email'=>$uemail,'code'=>$token])){
                        
                        $subject = "Password Reset";
                        $message = "Here is You'r 4 Digit Code $token ";

                        require_once "../smtp/PHPMailer.php";
                        require_once "../smtp/SMTP.php";
                        require_once "../smtp/Exception.php";

                        $mail = new PHPMailer();

                        //smtp settings
                        $mail->isSMTP();
                        $mail->Host = "smtp.gmail.com";
                        $mail->SMTPAuth = true;
                        $mail->Username = "koushil.webdeveloper@gmail.com";
                        $mail->Password = 'Hu$h0dROd9n=!e=as3?v';
                        $mail->Port = 465;
                        $mail->SMTPSecure = "ssl";

                        //email settings
                        $mail->isHTML(true);
                        $mail->setFrom('uclone@admin.com','Uclone');
                        $mail->addAddress($uemail);
                        $mail->Subject = ("uclone@admin.com ($subject)");
                        $mail->Body = $message;

                        if($mail->send()){
                            $msg="Password reset link has been mailed to you'r account.";
                            $_SESSION['uemail'] = $uemail;
                            echo "<script>setTimeout(()=>{ location.href='sec_code'; },2000);</script>";
                        }
                        else
                        {
                            $err="Something went wrong please try again!";
                        }
                    }
                }else{
                    $err="Email Id Doesn't Exists!";
                }
            }
        }
    }
}catch(Exception $e){
    $err = "Something went wrong please try again!!!!";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
    <link rel="stylesheet" href="../css/all.css">
    <link rel="stylesheet" href="../css/forgotPassword.css">
</head>
<body>
    
    <div class="email_verify">

        <div class="reset_modal">
            <div class="reset_ttl">Reset Password</div>
            <form action="" method="POST"  id="email_f">
                <div class="lgemail">
                    <label for="lemail" class="login_lbl">Email</label>
                    <span class="int_lemail"><i class="fas fa-envelope"></i></span>
                    <input type="email" name="lemail" id="lemail" class="lg_inpt" >
                </div>

                <div class='lg_btn'>
                    <input type="submit" name="esubmit" value="Submit" id="esubmit" class="fsubmit">
                </div>
            </form>
            
            <div class="lg_sg">Don't have an account? <a href="<?php if($_GET['user'] == "student"){ echo "../signup";}else if($_GET['user'] == "instructor"){echo "../instructor/signup";}else {echo "../signup";} ?>">Sign up</a></div>
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
