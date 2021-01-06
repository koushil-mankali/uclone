<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
require_once('../database/dbconn.php');

if((isset($_SESSION['isLogin']) && isset($_SESSION['iemail']))){
    header('location:index');
}else{
    $db = new Database();
    try{
        if(isset($_POST['login'])){
            if(($_POST['lemail'] == "") || ($_POST['lpass'] == "")){
                $err="Please Fill All the Fields";
            }else{
                $uemail =htmlentities($_POST['lemail']);
                $db->select('instructor_data','ipass,r_token',null,'iemail="'. $uemail .'"');
                if($em=$db->getResult()){
                    $upass=$em[0]['ipass'];
                    $re_token=$em[0]['r_token'];
                    if(isset($_COOKIE['imail']) && isset($_COOKIE['ipass'])){
                        if(password_verify($_COOKIE['ipass'],$re_token)){
                            $_SESSION['isLogin']="true";
                            $_SESSION['iemail']=$uemail;
                            $r_token=random_bytes(16);
                            $r_token_h=password_hash($r_token,PASSWORD_BCRYPT);
                            $db->update('instructor_data',"r_token='$r_token_h'","iemail='$uemail'");
                            setcookie('imail',$uemail,time()+(7*24*60*60));
                            setcookie('ipass',$r_token,time()+(7*24*60*60));
                            header('location:index');
                        }else{
                            if(isset($_COOKIE['imail'])){
                                setcookie('imail',"",time()-10);
                            }
                            if(isset($_COOKIE['ipass'])){
                                setcookie('ipass',"",time()-10);
                            }
                            $err = "Wrong Credentials";
                        }
                    }
                    if(password_verify($_POST['lpass'],$upass)){
                        $_SESSION['isLogin']="true";
                        $_SESSION['iemail']=$uemail;
                        if(!empty($_POST['checkbox'])){
                            $r_token=random_bytes(16);
                            $r_token_h=password_hash($r_token,PASSWORD_BCRYPT);
                            $db->update('instructor_data',"r_token='$r_token_h'","iemail='$uemail'");
                            setcookie('imail',$uemail,time()+(7*24*60*60));
                            setcookie('ipass',$r_token,time()+(7*24*60*60));
                        }else{
                            if(isset($_COOKIE['imail'])){
                                setcookie('imail',"",time()-10);
                            }
                            if(isset($_COOKIE['ipass'])){
                                setcookie('ipass',"",time()-10);
                            }
                        }
                        header('location:index');
                    }else{
                        $err="Wrong Credentials!";
                    }
                }else{
                    $err = "Wrong Credentials!";
                }
            }
        }
    }catch(Exception $e){
        $err = "Something went wrong please try again!";
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Instructor Login | MK ELearning</title>
    <link rel="stylesheet" href="../css/all.css">
    <link rel="stylesheet" href="../css/instructorPanel.css">
</head>
<body>
    <div class="instructor_login">
        <div class="login_modal" id="login_modal">
            <div class="login_ttl">Login</div>
            <form action="" method="POST">
                <div class="lgemail">
                    <label for="lemail" class="login_lbl">Email</label>
                    <span class="int_lemail"><i class="fas fa-envelope"></i></span>
                    <input type="email" name="lemail" id="lemail" class="lg_inpt" value="<?php if(isset($_COOKIE['imail'])){ echo $_COOKIE['imail']; }?>">
                </div>
                <div class="lgpassowrd">
                    <label for="lpass" class="login_lbl">Password</label>
                    <span class="int_lpass"><i class="fas fa-lock"></i></span>
                    <input type="password" name="lpass" id="lpass" class="lg_inpt" value="<?php if(isset($_COOKIE['ipass'])){ echo $_COOKIE['ipass']; }?>">
                </div>
                <div class="sreme">
                    <input type="checkbox" name="checkbox" id="srem" <?php if(isset($_COOKIE['imail'])){ ?> checked <?php }?>>
                    <label for="srem" >Remember Me</label>
                </div>
                <div class='lg_btn'>
                    <input type="submit" name="login" value="Login" id="llogin">
                    <a href="/uclone" class="cancel_btn" id="cancel_btnlg">Cancel</a>
                </div>
            </form>
            <?php if(isset($err)){ ?>
            <div class="err">
                <span><?php echo $err; ?></span>
            </div>
            <?php } ?>
            <div class="lg_fr">or <a href="../forgot_password?user=instructor">Forgot Password</a></div>
            <div class="lg_sg">Don't have an account? <a href="signup" id="signup">Sign up</a></div>
        </div>
    </div>

    <script src="../javascript/jquery.js"></script>
    <script src="../javascript/all.js"></script>
    <script src="../javascript/instructorPanel.js"></script>
</body>
</html>