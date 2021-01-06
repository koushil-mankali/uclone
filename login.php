<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
require_once('database/dbconn.php');

if(isset($_SESSION['isLogin'])){
    header('location:student');
}else{
    $db = new Database();
    try{
        if(isset($_POST['login'])){
            if(($_POST['lemail'] == "") || ($_POST['lpass'] == "")){
                $err="Please Fill All the Fields";
            }else{
                $uemail =htmlentities($_POST['lemail']);
                $db->select('user_data','upassword,r_token',null,'uemail="'. $uemail .'"');
                $em=$db->getResult();
                $cnt = count($em);
                if($cnt > 0){
                    $upass=$em[0]['upassword'];
                    $re_token=$em[0]['r_token'];
                }
                if(isset($_COOKIE['mail']) && isset($_COOKIE['pass'])){
                    if(password_verify($_COOKIE['pass'],$re_token)){
                        $_SESSION['isLogin']="true";
                        $_SESSION['uemail']=$uemail;
                        $r_token=random_bytes(16);
                        $r_token_h=password_hash($r_token,PASSWORD_BCRYPT);
                        $db->update('user_data',"r_token='$r_token_h'","uemail='$uemail'");
                        setcookie('mail',$uemail,time()+(7*24*60*60));
                        setcookie('pass',$r_token,time()+(7*24*60*60));
                        header('location:student');
                    }else{
                        if(isset($_COOKIE['mail'])){
                            setcookie('mail',"",time()-10);
                        }
                        if(isset($_COOKIE['pass'])){
                            setcookie('pass',"",time()-10);
                        }
                        $err = "Wrong Credentials";
                    }
                }
                if(password_verify($_POST['lpass'],isset($upass) ? $upass : "")){
                    $_SESSION['isLogin']="true";
                    $_SESSION['uemail']=$uemail;
                    if(!empty($_POST['checkbox'])){
                        $r_token=random_bytes(16);
                        $r_token_h=password_hash($r_token,PASSWORD_BCRYPT);
                        $db->update('user_data',"r_token='$r_token_h'","uemail='$uemail'");
                        setcookie('mail',$uemail,time()+(7*24*60*60));
                        setcookie('pass',$r_token,time()+(7*24*60*60));
                    }else{
                        if(isset($_COOKIE['mail'])){
                            setcookie('mail',"",time()-10);
                        }
                        if(isset($_COOKIE['pass'])){
                            setcookie('pass',"",time()-10);
                        }
                    }
                    if(isset($_GET['crs_id'])){
                        $crs_token = $_GET['crs_id'];
                        echo "<script>window.location.href='checkout?crs_id=$crs_token'</script>";
                    }elseif(isset($_GET['cart'])){
                        $crs_token = $_GET['cart'];
                        echo "<script>window.location.href='course?crs_id=$crs_token'</script>";
                    }else{
                        header('location:student');
                    }
                }else{
                    $err="Wrong Credentials!";
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
    <title>Signup | Uclone </title>
    <link rel="stylesheet" href="css/all.css">
    <link rel="stylesheet" href="css/custom.css">
</head>
<body>

    <div class="backdrop_login" id="backdrop_login">
        <div class="login_modal">
            <div class="login_ttl">Login</div>
            <form action="" method="POST">
                <div class="lgemail">
                    <label for="lemail" class="login_lbl">Email</label>
                    <span class="sg_email"><i class="fas fa-envelope"></i></span>
                    <input type="email" name="lemail" id="lemail" class="lg_inpt" value="<?php if(isset($_COOKIE['mail'])){ echo $_COOKIE['mail']; }?>">
                </div>
                <div class="lgpassowrd">
                    <label for="lpass" class="login_lbl">Password</label>
                    <span class="sg_pass"><i class="fas fa-lock"></i></span>
                    <input type="password" name="lpass" id="lpass" class="lg_inpt" value="<?php if(isset($_COOKIE['pass'])){ echo $_COOKIE['pass']; }?>">
                </div>
                <div class="sreme">
                    <input type="checkbox" id="srem" name="checkbox" <?php if(isset($_COOKIE['mail'])){ ?> checked <?php }?> >
                    <label for="srem" >Remember Me</label>
                </div>

                <?php if(isset($err)){ ?>
                <div class="err">
                    <span><?php echo $err; ?></span>
                </div>
                <?php } ?>
           
                <div class='lg_btn'>
                    <input type="submit" value="Login" id="llogin" name="login">
                    <a href="/uclone" class="cancel_btn" id="cancel_btnlg">Cancel</a>
                </div>
            </form>
            <div class="lg_fr">or <a href="forgot_password/?user=student">Forgot Password</a></div>
            <div class="lg_sg">Don't have an account? <a id="slogin_a" href="signup" class="a_btns">Sign up</a></div>
        </div>
    </div>

    <script src="javascript/all.js"></script>
    <script src="javascript/frontend.js"></script>
</body>
</html>