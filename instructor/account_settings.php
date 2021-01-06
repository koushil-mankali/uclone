<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if(!(isset($_SESSION['isLogin']) && isset($_SESSION['iemail']))){
    header('location:login');
}
require_once("../database/dbconn.php");

$page = "account_settings";

$usemail = $_SESSION['iemail'];

$db = new Database();

$db->select('instructor_data','iname,iemail,ipass,idesc,ipic',null,"iemail='$usemail'");
$em=$db->getResult();
$name=$em[0]['iname'];
$email=$em[0]['iemail'];
$password=$em[0]['ipass'];
$desc=$em[0]['idesc'];
$pic=$em[0]['ipic'];

if(isset($_POST['update'])){
    $uname = $_POST['int_user_name'] != "" ? $_POST['int_user_name'] : $name;
    $uemail = $_POST['int_email'] != "" ? $_POST['int_email'] : $email;
    $upassword = $_POST['int_pass'] != "" ? password_hash($_POST['int_pass'],PASSWORD_BCRYPT) : "";
    $idesc = $_POST['int_desc'] != "" ? $_POST['int_desc'] : $desc;
    if(empty($_FILES["int_pr_pc"]["name"])){
        $upic = "";
    }else{
        $upic = "true"; 
    }

    if(($upassword == "") && ($upic == "")){
        if($db->update('instructor_data',"iname='$uname',iemail='$uemail',idesc=\"$idesc\"","iemail='$email'")){
            $msg="Data Updated Succesfully";
            $_SESSION['iemail'] = $uemail;
            $name = $uname;
            $email = $uemail;
            $desc = $idesc;
        }else{
            $err = "Unable to Update Data!";
        }
    }elseif(($upassword != "") && ($upic == "")){
        if($db->update('instructor_data',"iname='$uname',iemail='$uemail',ipass='$upassword',idesc=\"$idesc\"","iemail='$email'")){
            $msg="Data Updated Succesfully";
            $_SESSION['iemail'] = $uemail;
            $name = $uname;
            $email = $uemail;
            $desc = $idesc;
        }else{
            $err = "Unable to Update Data!";
        }
    }elseif(($upassword != "") && ($upic != "")){
        $tmp_nm = $_FILES["int_pr_pc"]["tmp_name"];
        $dest_nm = "../images/instructors/";
        $file_nm = $_FILES['int_pr_pc']['name'];
        $file_type=$_FILES['int_pr_pc']['type'];
        $file_sz=$_FILES['int_pr_pc']['size'];
        $file_exp = explode('.',$file_nm);
        $file_ext=strtolower(end($file_exp));
        
        $extensions= array("jpeg","jpg","png");
        
        if(in_array($file_ext,$extensions)=== false){
            $err="extension not allowed, please choose a JPEG or PNG file.";
        }
        if($file_sz > 2097152){
            $err='File size must be excately 2 MB';
        }

        $img_nm = uniqid().$file_nm;
        $img_dest=$dest_nm.$img_nm;
        
        if(empty($err)==true){
            if(move_uploaded_file($tmp_nm,$img_dest)){
                // if($pic != ""){
                //     $unset_img = $dest_nm.$pic;
                //     unlink($unset_img);
                // }
                if($db->update('instructor_data',"iname='$uname',iemail='$uemail',ipass='$upassword',idesc=\"$idesc\",ipic='$img_nm'","iemail='$email'")){
                    $msg="Data Updated Succesfully";
                    $_SESSION['iemail'] = $uemail;
                    $name = $uname;
                    $email = $uemail;
                    $desc = $idesc;
                }else{
                    $err = "Unable to Update Data!";
                }
            }else{
                $err = "Unable to Update Data!";
            }
         }else{
            $err = "Error While Updating Please Try Again!";
         }
        
    }elseif(($upassword == "") && ($upic != "")){
        $tmp_nm = $_FILES["int_pr_pc"]["tmp_name"];
        $dest_nm = "../images/instructors/";
        $file_nm = $_FILES['int_pr_pc']['name'];
        $file_type=$_FILES['int_pr_pc']['type'];
        $file_sz=$_FILES['int_pr_pc']['size'];
        $file_exp = explode('.',$file_nm);
        $file_ext=strtolower(end($file_exp));
        
        
        $extensions= array("jpeg","jpg","png");
        
        if(in_array($file_ext,$extensions)=== false){
            $err="extension not allowed, please choose a JPEG or PNG file 2.";
        }
        if($file_sz > 2097152){
            $err='File size must be excately 2 MB';
        }
        $img_nm = uniqid().$file_nm;
        $img_dest=$dest_nm.$img_nm;
        
        if(empty($errors)==true){
            if(move_uploaded_file($tmp_nm,$img_dest)){
                if($pic != ""){
                    $unset_img = $dest_nm.$pic;
                    unlink($unset_img);
                }
                if($db->update('instructor_data',"iname='$uname',iemail='$uemail',idesc=\"$idesc\",ipic='$img_nm'","iemail='$email'")){
                    $msg="Data Updated Succesfully";
                    $_SESSION['iemail'] = $uemail;
                    $name = $uname;
                    $email = $uemail;
                    $desc = $idesc;
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
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account Settings</title>
    <link rel="stylesheet" href="css/all.css">
    <link rel="stylesheet" href="../css/instructorPanel.css">
</head>
<body>
    <?php include_once('../inc/instHeader.php') ?>

    <div class="inst_ss">  
        <?php include_once('sidebar.php') ?>

        <div class="dash">
            <div class="int_acc_set">
                <div class="int_acc_set_ttl">Profile Settings</div>
                <div class="int_acc_set_bdy">
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
                    <form action="" method="POST" name="" id="" class="" enctype="multipart/form-data">
                        <div class="int_acc_f">
                            <label for="int_user_name" class="l_user_name l_int_f">User Name:</label>
                            <input type="text" name="int_user_name" id="int_user_name" class="int_user_name int_f_inp" value="<?php if(isset($name)){echo $name;} ?>">
                        </div>
                        <div class="int_acc_f">
                            <label for="int_email" class="l_email l_int_f">Email:</label>
                            <input type="email" name="int_email" id="int_email" class="int_email int_f_inp" value="<?php if(isset($email)){echo $email;} ?>">
                        </div>
                        <div class="int_acc_f">
                            <label for="int_pass" class="l_pass l_int_f">Password:</label>
                            <input type="password" name="int_pass" id="int_pass" class="int_pass int_f_inp">
                        </div>
                        <div class="int_acc_f">
                            <label for="int_desc" class="l_desc l_int_f">Description:</label>
                            <textarea name="int_desc" id="int_desc" class="int_desc int_f_inp"><?php if(isset($desc)){echo $desc;} ?></textarea>
                        </div>
                        <div class="int_acc_f">
                            <label for="int_pr_pc" class="l_pr_pc l_int_f">Profile Photo:</label>
                            <input type="file" name="int_pr_pc" id="int_pr_pc" class="int_pr_pc int_f_inp">
                        </div>
                        <input type="submit" value="Update" name="update" class="int_acc_set_sbtn">
                    </form>
                    <br />
                    
                </div>
            </div>
        </div>

    </div>

    <script src="../javascript/jquery.js"></script>
    <script src="../javascript/all.js"></script>
    <script src="../javascript/instructorPanel.js"></script>
</body>
</html>
