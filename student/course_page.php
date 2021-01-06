<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if(!(isset($_SESSION['isLogin']) && isset($_SESSION['uemail']))){
    header('location:../login');
}
require_once("../database/dbconn.php");

$page = "course_page";

$usemail = $_SESSION['uemail'];
$crs_token = isset($_GET['crs_code']) ? $_GET['crs_code'] : header('location:index');

$db = new Database();

if($db->select('courses','crs_nm,crs_img',null,"crs_token = '$crs_token'")){
    $emm = $db->getResult();
    $cntt = count($emm);
    if($cntt >0){
        $crs_nm = isset($emm[0]['crs_nm']) ? $emm[0]['crs_nm'] :  $err = "Error Fetching Data";
        $crs_img = isset($emm[0]['crs_img']) ? $emm[0]['crs_img'] :  $err = "Error Fetching Data";
    }else{
        $err = "Error Fetching Data";
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $crs_nm; ?></title>
    <link rel="stylesheet" href="../css/all.css">
    <link rel="stylesheet" href="../css/studentPanel.css">
</head>
<body>
    <?php include_once("../inc/sheader.php") ?>
    
    <div class="stu_crs_pg">
        <div class="crs_vid">
            <?php
             if($db->select('lectures','DISTINCT (sec_nm)',null,"crs_token = '$crs_token'")){
                $em_sec = $db->getResult();
                $cnt_sec = count($em_sec) == 0 ? "No Lectures Avaliable" : count($em_sec);
                $fst_sec = isset($em_sec[0]['sec_nm']) ? $em_sec[0]['sec_nm'] :  "No Lectures Avaliable";
            }
            
            if($db->select('lectures','lct_vid',null,"crs_token = '$crs_token' AND sec_nm ='$fst_sec'")){
                $em = $db->getResult();
                $fst_vid = isset($em[0]['lct_vid']) ? $em[0]['lct_vid'] :  "No Lectures Avaliable";
            }
            $vid = isset($_GET['lct']) ? $_GET['lct'] : $fst_vid; ?>
            <video poster="../images/courses/<?php echo $crs_img; ?>" src="../videos/<?php echo $vid; ?>" controls class="crs_vid_ply">
            </video>
            <details class="vid_res">
                <summary class="vid_res_sum">Resources</summary>
                <p>downloadable resources...</p>
            </details>
        </div>
        <div class="crs_lst">
            <div class="crs_lst_ttl">Course Content</div>

            <div class="crs_lst_cnt">
            <!-- vd_plg -->
            <?php

            $i=0;
            while($i<$cnt_sec){
                $sec_nm = isset($em_sec[$i]['sec_nm']) ? $em_sec[$i]['sec_nm'] :  $err = "Error Fetching Data main";
                echo "<details class='crs_ply_det'>
                <summary class='crs_ply_sum'>$sec_nm</summary>";
                if($db->select('lectures','lct_nm,lct_vid',null,"crs_token = '$crs_token' AND sec_nm ='$sec_nm'")){
                    $em = $db->getResult();
                    $cnt = count($em) == 0 ? $err = "" : count($em);
                    $j=0;
                    while($j<$cnt){
                        $lct_nm = isset($em[$j]['lct_nm']) ? $em[$j]['lct_nm'] :  $err = "Error Fetching Data 1";
                        $lct_vid = isset($em[$j]['lct_vid']) ? $em[$j]['lct_vid'] :  $err = "Error Fetching Data 2";
                        $fst_vid = isset($em[0]['lct_vid']) ? $em[0]['lct_vid'] :  $err = "Error Fetching Data 3";
                    echo "<ul>
                            <a class='crs_ply_li_a' href='course_page?crs_code=$crs_token&lct=$lct_vid'><li class='crs_ply_li '><i class='fas fa-play'></i>&nbsp;&nbsp;$lct_nm</li></a>
                        </ul>";
                    $j++;
                    }
                }
                echo"</details>";
                $i++;
            }

            
            ?>

            </div>
            
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
    </div>


<br><br>
    <?php include_once("../inc/sfooter.php") ?>
    <script src="../javascript/jquery.js"></script>
    <script src="../javascript/all.js"></script>
    <script src="../javascript/studentPanel.js"></script>
</body>
</html>