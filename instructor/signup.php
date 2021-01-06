<?php
use PHPMailer\PHPMailer\PHPMailer;
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
require_once('../database/dbconn.php');

if(isset($_SESSION['isLogin'])){
    header('location:index');
}else{
    try{
        if(isset($_POST['signup'])){
            if(($_POST['sgname'] == "") || ($_POST['sgemail'] == "") || ($_POST['sgpass'] == "")){
                $err="Please Fill All the Fields";
            }else{
                $suser = htmlentities($_POST['sgname']);
                $semail = htmlentities($_POST['sgemail']);
                $spass = password_hash(htmlentities($_POST['sgpass']),PASSWORD_BCRYPT);
                $token = bin2hex(random_bytes(10));

                $db = new Database();

                $db->select('instructor_data','iemail',null,'iemail="'.$semail.'"',null,null);
            
                $er=$db->getResult();
                $cc=count($er);
                if($cc > 0){
                    $err = "Email Already Exists";
                }else{

                    if($db->insert('user_verify',['uname'=>$suser,'uemail'=>$semail,'upassword'=>$spass,'token'=>$token,'status'=>'0'])){

                        $subject = "Account Verification";
                        $message = "To Activate You'r Uclone Account <a href='http://localhost/uclone/verify_acc?token=$token&type=instructor'>Click Here </a>";
              
                        require_once "../smtp/PHPMailer.php";
                        require_once "../smtp/SMTP.php";
                        require_once "../smtp/Exception.php";

                        $mail = new PHPMailer();

                        //smtp settings
                        $mail->isSMTP();
                        $mail->Host = "smtp.gmail.com";
                        $mail->SMTPAuth = true;
                        $mail->Username = ""; //Place you'r mail id here
                        $mail->Password = ''; //Place you'r mail password here
                        $mail->Port = 465;
                        $mail->SMTPSecure = "ssl";

                        //email settings
                        $mail->isHTML(true);
                        $mail->setFrom($semail,'Uclone');
                        $mail->addAddress($semail);
                        $mail->Subject = ("$semail ($subject)");
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
    <title>Instructor Signup | MK ELearning</title>
    <link rel="stylesheet" href="../css/all.css">
    <link rel="stylesheet" href="../css/instructorPanel.css">
</head>
<body>
    <div class="instructor_login">
        <div class="signup_modal" id="signup_modal">
            <div class="signup_ttl">Sign Up</div>
            <form action="" method="POST">
                <div class="sgemail">
                    <label for="sgname" class="signup_lbl">Name</label>
                    <span class="int_sgemail"><i class="fas fa-user"></i></span>
                    <input type="text" name="sgname" id="sgname" class="sg_inpt" >
                </div>
                <div class="sgemail">
                    <label for="sgemail" class="signup_lbl">Email</label>
                    <span class="int_sgemail"><i class="fas fa-envelope"></i></span>
                    <input type="email" name="sgemail" id="sgemail" class="sg_inpt" >
                </div>
                <div class="sgpassowrd">
                    <label for="sgpass" class="signup_lbl">Password</label>
                    <span class="int_sgpass"><i class="fas fa-lock"></i></span>
                    <input type="password" name="sgpass" id="sgpass" class="sg_inpt">
                </div>
                <div class='sg_btn'>
                    <input type="submit" name="signup" value="Signup" id="lsignup">
                    <a href="/uclone" class="cancel_btn" id="cancel_btnlg">Cancel</a>
                </div>
            </form>
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
            <div class="sg_fr">or <a href="../forgot_password?user=instructor">Forgot Password</a></div>
            <div class="sg_sg">Already have an account? <a href="login" id="login">Login</a></div>
        </div>
    </div>

    <script src="../javascript/jquery.js"></script>
    <script src="../javascript/all.js"></script>
    <script src="../javascript/instructorPanel.js"></script>
</body>
</html>