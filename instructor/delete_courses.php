<?php 
if(!isset($_SERVER['HTTP_REFERER'])){
    // redirect them to your desired location
    header('location:../err404.php');
    exit;
}
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if(!(isset($_SESSION['isLogin']) && isset($_SESSION['iemail']))){
    header('location:login');
}
require_once("../database/dbconn.php");

$page = "delete_courses";

$db = new Database();

if(isset($_GET['crs_id'])){

    $crs_token = htmlentities($_GET['crs_id']);

    if($db->select('lectures','id,lct_vid',null,"crs_token='$crs_token'")){
        $lct_vid_nm = $db->getResult();
        $del_cnt =  count($lct_vid_nm);
        $i = 0;
        while($i < $del_cnt){
            $vid_nm = "../videos/".$lct_vid_nm[$i]['lct_vid'];
            $id = $lct_vid_nm[$i]['id'];
            if(unlink($vid_nm)){
                if($db->delete('lectures',"id='$id'")){
                    $msg = "Lectures Deleted Successfully";
                    
                }else{
                    $err = "Error Deleting Data";
                }
            }
            $i++;
        }
        if($db->select('courses','crs_img',null,"crs_token='$crs_token'")){
            $crs_img = $db->getResult();
            $img_nm = "../images/courses/".$crs_img['0']['crs_img'];
            if(unlink($img_nm)){
                if($db->delete('courses',"crs_token='$crs_token'")){
                    $msg = "Course Deleted Successfully";
                }else{
                    $err = "Error Deleting Course";
                }
            }
        }else{
            $err = "Error in Deleting Course";
        }  
        echo "<script>location.href='courses'</script>";
    }else{
        $err = "Error in Deleting Data";
    }
}

?>