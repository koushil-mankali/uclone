<?php
use PHPMailer\PHPMailer\PHPMailer;
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
require_once('database/dbconn.php');

if(isset($_SESSION['isLogin'])){
    header('location:student');
}else{
    try{
        if(isset($_POST['signup'])){
            if(($_POST['suser'] == "") || ($_POST['semail'] == "") || ($_POST['spass'] == "")){
                $err="Please Fill All the Fields";
            }else{
                $suser = htmlentities($_POST['suser']);
                $semail = htmlentities($_POST['semail']);
                $spass = password_hash(htmlentities($_POST['spass']),PASSWORD_BCRYPT);
                $token = bin2hex(random_bytes(10));

                $db = new Database();

                $db->select('user_data','uemail',null,'uemail="'.$semail.'"',null,null);
            
                $er=$db->getResult();
                $cc=count($er);
                if($cc > 0){
                    $err = "Email Already Exists";
                }else{

                    if($db->insert('user_verify',['uname'=>$suser,'uemail'=>$semail,'upassword'=>$spass,'token'=>$token,'status'=>'0'])){

                        $subject = "Account Verification";
                        $message = "To Activate You'r Uclone Account <a href='http://localhost/uclone/verify_acc?token=$token&type=user'>Click Here </a>";
                   
                        require_once "smtp/PHPMailer.php";
                        require_once "smtp/SMTP.php";
                        require_once "smtp/Exception.php";

                        $mail = new PHPMailer();

                        //smtp settings
                        $mail->isSMTP();
                        $mail->Host = "smtp.gmail.com";
                        $mail->SMTPAuth = true;
                        $mail->Username = "";   //Place you'r mail id here
                        $mail->Password = '';  //Place you'r mail password here
                        $mail->Port = 465;
                        $mail->SMTPSecure = "ssl";

                        //email settings
                        $mail->isHTML(true);
                        $mail->setFrom('uclone@admin.com','Uclone');
                        $mail->addAddress($semail);
                        $mail->Subject = ("uclone@admin.com ($subject)");
                        $mail->Body = $message;

                        if($mail->send()){
                            $msg="Account activation link has been mailed please verify to activate you'r account.";
                        }
                        else
                        {
                            $err="Something went wrong please try again!";
                        }
                    }
                }
            }
        }

    } catch(Exception $e){
        $err = "Something went wrong please try again!";
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Signup | Uclone </title>
    <link rel="stylesheet" href="css/all.css">
    <link rel="stylesheet" href="css/custom.css">
</head>
<body class="backdrop_signups">

    <div class="backdrop_signup" id="backdrop_signup">
        <div class="signup_modal">
            <div class="signup_ttl">Sign Up</div>
                <form action="" method="POST">
                <div class="sfullnme">
                    <label for="suser" class="signup_lbl">Username</label>
                    <span class="sg_user"><i class="fas fa-user"></i></span>
                    <input type="text" name="suser" id="suser" class="sg_inpt" >
                </div>
                <div class="sgemail">
                    <label for="semail" class="signup_lbl">Email</label>
                    <span class="sg_email"><i class="fas fa-envelope"></i></span>
                    <input type="email" name="semail" id="semail" class="sg_inpt" >
                </div>
                <div class="sgpassowrd">
                    <label for="spass" class="signup_lbl">Password</label>
                    <span class="sg_pass"><i class="fas fa-lock"></i></span>
                    <input type="password" name="spass" id="spass" class="sg_inpt">
                </div>
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
                <div class='sg_btn'>
                    <input type="submit" name="signup" value="Sign Up" id="slogin">
                    <a href="/uclone" class="cancel_btn" id="cancel_btnsg">Cancel</a>
                </div>
            </form>
            <div class="sg_sg">Already have an account? <a href="login" id="llogin_a" class="a_btns">Log In</a></div>
        </div>
    </div>

    <script src="javascript/all.js"></script>
    <script type="text/javascript" src="javascript/frontend.js"></script>
</body>
</html>