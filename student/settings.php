<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if(!(isset($_SESSION['isLogin']) && isset($_SESSION['uemail']))){
    header('location:../login');
}
require_once("../database/dbconn.php");

$page = "settings";

$usemail = $_SESSION['uemail'];

$db = new Database();

$db->select('user_data','uname,uemail,upassword,u_pic',null,"uemail='$usemail'");
$em=$db->getResult();
$name=$em[0]['uname'];
$email=$em[0]['uemail'];
$password=$em[0]['upassword'];
$pic=$em[0]['u_pic'];

if(isset($_POST['update'])){
    $uname = $_POST['stu_user_name'] != "" ? $_POST['stu_user_name'] : $name;
    $uemail = $_POST['stu_email'] != "" ? $_POST['stu_email'] : $email;
    $upassword = $_POST['stu_pass'] != "" ? password_hash($_POST['stu_pass'],PASSWORD_BCRYPT) : "";
    if(empty($_FILES["stu_pr_pc"]["name"])){
        $upic = "";
    }else{
        $upic = "true"; 
    }
    if(($upassword == "") && ($upic == "")){
        if($db->update('user_data',"uname='$uname',uemail='$uemail'","uemail='$email'")){
            $msg="Data Updated Succesfully";
            $_SESSION['uemail'] = $uemail;
            $name = $uname;
            $email = $uemail;
        }else{
            $err = "Unable to Update Data!";
        }
    }elseif(($upassword != "") && ($upic == "")){
        if($db->update('user_data',"uname='$uname',uemail='$uemail',upassword='$upassword'","uemail='$email'")){
            $msg="Data Updated Succesfully";
            $_SESSION['uemail'] = $uemail;
            $name = $uname;
            $email = $uemail;
        }else{
            $err = "Unable to Update Data!";
        }
    }elseif(($upassword != "") && ($upic != "")){
        $tmp_nm = $_FILES["stu_pr_pc"]["tmp_name"];
        $dest_nm = "../images/students/";
        $file_nm = $_FILES['stu_pr_pc']['name'];
        $file_type=$_FILES['stu_pr_pc']['type'];
        $file_sz=$_FILES['stu_pr_pc']['size'];
        $file_exp = explode('.',$file_nm);
        $file_ext=strtolower(end($file_exp));
        
        $extensions= array("jpeg","jpg","png");
        
        if(in_array($file_ext,$extensions)=== false){
            $err="extension not allowed, please choose a JPEG or PNG file.";
        }else{
            if($file_sz > 2097152){
                $err='File size must be excately 2 MB';
            }else{

                $img_nm = uniqid().$file_nm;
                $img_dest=$dest_nm.$img_nm;
                
                if(empty($errors)==true){
                    if(move_uploaded_file($tmp_nm,$img_dest)){
                        $unset_img = $dest_nm.$pic;
                        unlink($unset_img);
                        if($db->update('user_data',"uname='$uname',uemail='$uemail',upassword='$upassword',u_pic='$img_nm'","uemail='$email'")){
                            $msg="Data Updated Succesfully";
                            $_SESSION['uemail'] = $uemail;
                            $name = $uname;
                            $email = $uemail;
                        }else{
                            $err = "Unable to Update Data!";
                        }
                    }else{
                        $err = "Unable to Update Data!";
                    }
                }else{
                    $err = "Error While Updating Please Try Again!";
                }
            }
        }
        
    }elseif(($upassword == "") && ($upic != "")){
        $tmp_nm = $_FILES["stu_pr_pc"]["tmp_name"];
        $dest_nm = "../images/students/";
        $file_nm = $_FILES['stu_pr_pc']['name'];
        $file_type=$_FILES['stu_pr_pc']['type'];
        $file_sz=$_FILES['stu_pr_pc']['size'];
        $file_exp = explode('.',$file_nm);
        $file_ext=strtolower(end($file_exp));
        
        
        $extensions= array("jpeg","jpg","png","gif");
        
        if(in_array($file_ext,$extensions)=== false){
            $err="extension not allowed, please choose a JPEG or PNG file 2.";
        }else{
            if($file_sz > 2097152){
                $err='File size must be excately 2 MB';
            }else{
                $img_nm = uniqid().$file_nm;
                $img_dest=$dest_nm.$img_nm;
                
                if(empty($errors)==true){
                    if(move_uploaded_file($tmp_nm,$img_dest)){
                        if($pic != ""){
                            $unset_img = $dest_nm.$pic;
                            unlink($unset_img);
                        }
                        if($db->update('user_data',"uname='$uname',uemail='$uemail',u_pic='$img_nm'","uemail='$email'")){
                            $msg="Data Updated Succesfully";
                            $_SESSION['uemail'] = $uemail;
                            $name = $uname;
                            $email = $uemail;
                        }else{
                            $err = "Unable to Update Data!";
                        }
                    }else{
                        $err = "Unable to Update Data!";
                    }
                }else{
                    $err = "Error While Updating Please Try Again!";
                }
            }
        }
    }
}
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
                <form action="" method="POST" enctype="multipart/form-data">
                    <div class="stu_acc_f">
                        <label for="stu_user_name" class="l_user_name l_stu_f">User Name:</label>
                        <input type="text" name="stu_user_name" id="stu_user_name" class="stu_user_name stu_f_inp" value="<?php if(isset($name)){echo $name;} ?>" >
                    </div>
                    <div class="stu_acc_f">
                        <label for="stu_email" class="l_email l_stu_f">Email:</label>
                        <input type="email" name="stu_email" id="stu_email" class="stu_email stu_f_inp" value="<?php if(isset($email)){echo $email;} ?>">
                    </div>
                    <div class="stu_acc_f">
                        <label for="stu_pass" class="l_pass l_stu_f">Password:</label>
                        <input type="password" name="stu_pass" id="stu_pass" class="stu_pass stu_f_inp">
                    </div>
                    <div class="stu_acc_f">
                        <label for="stu_pr_pc" class="l_pr_pc l_stu_f">Profile Photo:</label>
                        <input type="file" name="stu_pr_pc" id="stu_pr_pc" class="stu_pr_pc stu_f_inp">
                    </div>
                    <input type="submit" name="update" value="Update" class="stu_acc_set_sbtn">
                </form>
                <br />
                <br />
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
            </div>
        </div>
    </div>

<?php include_once("../inc/sfooter.php") ?>
    <script src="../javascript/jquery.js"></script>
    <script src="../javascript/all.js"></script>
    <script src="../javascript/studentPanel.js"></script>
</body>
</html>

