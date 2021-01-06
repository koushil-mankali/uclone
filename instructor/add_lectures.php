<?php 
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if(!(isset($_SESSION['isLogin']) && isset($_SESSION['iemail']))){
    header('location:login');
}
require_once("../database/dbconn.php");

$page = "add_lectures";

$usemail = $_SESSION['iemail'];

$db = new Database();

if(isset($_POST['add'])){
    if(($_POST['inst_crs_sec_nm'] == "") || ($_POST['inst_crs_let_nm'] == "") || ($_POST['inst_crs_let_tm'] == "") || empty($_FILES['inst_crs_vd']['name'])){
        $err = "Please Fill All The Fields";
    }else{
        $sec_nm = $_POST['inst_crs_sec_nm'];
        $let_nm = $_POST['inst_crs_let_nm'];
        $let_dur = $_POST['inst_crs_let_tm'];
        $crs_token = isset($_GET['crs_id']) ? $_GET['crs_id'] : "";

        $tmp_nm = $_FILES["inst_crs_vd"]["tmp_name"];
        $dest_nm = "../videos/";
        $file_nm = $_FILES['inst_crs_vd']['name'];
        $file_type=$_FILES['inst_crs_vd']['type'];
        $file_sz=$_FILES['inst_crs_vd']['size'];
        $file_exp = explode('.',$file_nm);
        $file_ext=strtolower(end($file_exp));
        
        $extensions= array("mp4","mp3","wmv","flv","avi","mov","m4a","m4v");
        
        if(in_array($file_ext,$extensions) === false){
            $err="extension not allowed, please choose a mp4 or mp3 etc... file types.";
        }
        if($file_sz > 101097152){
            $err='File size must be less than 100 MB';
        }

        $vd_nm = uniqid().$file_nm;
        $vd_dest=$dest_nm.$vd_nm;

        if(empty($err)==true && $let_dur != ""){
            if(move_uploaded_file($tmp_nm,$vd_dest)){
                if($db->insert('lectures',['crs_token'=>$crs_token,'sec_nm'=>$sec_nm,'lct_nm'=>$let_nm,'lct_dur'=>$let_dur,'lct_vid'=>$vd_nm])){
                    $msg="Lecture Added Succesfully";
                    $db->select('lectures','SEC_TO_TIME(SUM(TIME_TO_SEC(`lct_dur`))) as time',null,"crs_token = '$crs_token'");
                    $resc = $db->getResult();
                    $cnttc = count($resc);
                    if($cnttc != 0){
                        $times = $resc['0']['time'];
                        $db->update('courses',"crs_dur='$times'","crs_token='$crs_token'");
                    }
                }else{
                    $err = "Unable to Add Lecture!";
                }
            }else{
                $err = "Unable to Add Lecture!";
            }
        }else{
            if(isset($err)){ echo $err; }else{ echo "Error While Adding Lecture Please Try Again!"; }
        }
        
    }
}

$crs_token = isset($_GET['crs_id']) ? $_GET['crs_id'] : "";
if($db->select('lectures','DISTINCT sec_nm',null,"crs_token='$crs_token'")){
    $em = $db->getResult();
    $cnt=count($em);
}

if(isset($_POST['get_details'])){
    $sec_name = $_POST['inst_crs_sec_nm'];
    if($db->select('lectures','id,sec_nm,lct_nm,lct_dur',null,"sec_nm='$sec_name' AND crs_token = '$crs_token'")){
        $emm = $db->getResult();
        $cntt=count($emm);
    }else{
        $err = "Error in Fetchig Data";
    }
}

if(isset($_POST['delete'])){
    $del_id = isset($_POST['del_id']) ? $_POST['del_id'] : "";
    if($db->select('lectures','lct_vid',null,"id='$del_id'")){
        $lct_vid_nm = $db->getResult();
        $vid_nm = "../videos/".$lct_vid_nm[0]['lct_vid'];
        if(unlink($vid_nm)){
            if($db->delete('lectures',"id='$del_id'")){
                $msg = "Lecture Deleted Successfully";
                $db->select('lectures','SEC_TO_TIME(SUM(TIME_TO_SEC(`lct_dur`))) as time',null,"crs_token = '$crs_token'");
                $resc = $db->getResult();
                $cnttc = count($resc);
                if($cnttc != 0){
                    $times = $resc['0']['time'];
                    $db->update('courses',"crs_dur='$times'","crs_token='$crs_token'");
                }
            }else{
                $err = "Error Deleting Data";
            }
        }
    }else{
        $err = "Error in Deleting Data";
    }
}

if(isset($_POST['update'])){
    if(($_POST['inst_crs_let_nm'] == "") || ($_POST['inst_crs_let_tm'] == "")){
        $err = "Please Fill All The Fields";
    }else{
        $lct_nm = $_POST['inst_crs_let_nm'];
        $let_dur = $_POST['inst_crs_let_tm'];
        $crs_token = isset($_GET['crs_id']) ? $_GET['crs_id'] : "";
        $sec_nm = $_POST['sec_name'];
        $id = $_POST['id_val'];

        if($db->update('lectures',"lct_nm='$lct_nm',lct_dur='$let_dur'","crs_token='$crs_token' AND sec_nm='$sec_nm' AND id='$id'")){
            $msg="Updated Succesfully";
            $db->select('lectures','SEC_TO_TIME(SUM(TIME_TO_SEC(`lct_dur`))) as time',null,"crs_token = '$crs_token'");
            $resc = $db->getResult();
            $cnttc = count($resc);
            if($cnttc != 0){
                $times = $resc['0']['time'];
                $db->update('courses',"crs_dur='$times'","crs_token='$crs_token'");
            }
        }else{
            $err = "Unable to Update!";
        }   
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crouses</title>
    <link rel="stylesheet" href="css/all.css">
    <link rel="stylesheet" href="../css/instructorPanel.css">
</head>
<body>
    <?php include_once('../inc/instHeader.php') ?>

    <div class="inst_ss">  
        <?php include_once('sidebar.php') ?>
        <div class="dash">
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
            <!-- Section 1 Start  -->

            <div class="inst_crs_sec1">
                <div class="inst_crs_sec1_ttl">Add Lecture Details</div>
                <div class="inst_crs_sec1_bdy">
                    <form action="" method="POST" enctype="multipart/form-data">
                        <div class="inst_crs_det">
                            <input type="hidden" name="add_lct_hid_id">
                            <div class="inst_details_Sec">
                                <label for="inst_crs_sec_nm" class="inst_crs_det_lbl">Section Name</label>
                                <input type="text" class="inst_crs_inpt_det" name="inst_crs_sec_nm" id="inst_crs_sec_nm" list="sec_nms" autocomplete="off">
                                <datalist id="sec_nms">
                                
                                    <?php
                                        if($cnt > 0){
                                            $i=0;
                                            while($i<$cnt){
                                                echo "<option value='".$em[$i]['sec_nm']."'>".$em[$i]['sec_nm']."</option>";
                                                $i++;
                                            }
                                        }else{
                                            $err = "No Data Avalible";
                                        }
                                        
                                    ?>
                                    
                                </datalist>
                            </div>
                            
                            <div class="inst_details_Sec">
                                <label for="inst_crs_let_nm" class="inst_crs_det_lbl">Lecture Name</label>
                                <input type="text" class="inst_crs_inpt_det" name="inst_crs_let_nm" id="inst_crs_let_nm">
                            </div>

                            <div class="inst_details_Sec">
                                <label for="inst_crs_let_nm" class="inst_crs_det_lbl">Lecture Duation <small>Follow the order 00:00:00</small></label>
                                <input type="text" class="inst_crs_inpt_det" name="inst_crs_let_tm" id="inst_crs_let_tm">
                            </div>
                        </div>
                        
                        <div class="inst_crs_det">
                            <div class="inst_selection">
                                <label for="inst_crs_vd" class="inst_crs_det_lbl">Video File</label>
                                <input type="file" class="inst_crs_file" name="inst_crs_vd" id="inst_crs_video_file" multiple>
                            </div>
                        </div>
                        <input type="submit" name="add" value="Add" class="add_lect">
                    </form>
                </div>
                <br />
                <br />
                <br />
                </div>

                <div class="dash_sec2" style="padding-bottom:50px;">
                <div class="inst_crs_sec1">
                <div class="inst_crs_sec1_ttl">Update Lecture Details</div>
                <div class="inst_crs_sec1_bdy">
                    <form action="" method="POST" enctype="multipart/form-data">
                        <div class="inst_crs_det2">     
                            <div class="inst_details_Sec">
                                <label for="inst_crs_sec_nm" class="inst_crs_det_lbl">Section Name</label>
                                <select  class="inst_crs_inpt_det w-100" name="inst_crs_sec_nm" id="inst_crs_sec_nm">
                                    <option value="">Select</option>
                                    <?php
                                        if($cnt > 0){
                                            $i=0;
                                            while($i<$cnt){
                                                echo "<option value='".$em[$i]['sec_nm']."'>".$em[$i]['sec_nm']."</option>";
                                                $i++;
                                            }
                                        }else{
                                            $err = "No Data Avalible";
                                        }
                                        
                                    ?>
                                    
                                </select>
                            </div>
                        </div>
                        <input type="submit" name="get_details" value="Get Data" class="add_lect">
                        <br />
                        <br />
                    </form>
                    <form action="" method="POST" enctype="multipart/form-data">
                        <div class="inst_crs_det2">                        
                            <div class="int_crs_det3">
                                <?php
                                    if(isset($cntt)){
                                        if($cntt > 0){
                                            $i=0;
                                            while($i<$cntt){
                                              
                                                echo 
                                        
                                                "<div class='inst_details_Sec'>
                                                <form method='POST' action='' class='uform'>
                                                <label for='inst_crs_let_nm' class='inst_crs_det_lbl2'>Lecture Name</label>
                                                <input type='text' class='inst_crs_inpt_det' name='inst_crs_let_nm' id='inst_crs_let_nm' value='". $emm[$i]['lct_nm'] ."'>
                                                <label for='inst_crs_let_nm' class='inst_crs_det_lbl2'> Duation</label>
                                                <input type='text' class='inst_crs_inpt_det' name='inst_crs_let_tm' id='inst_crs_let_tm' value='". $emm[$i]['lct_dur'] ."'>
                                                <input type='hidden' name='sec_name' value='".$emm[$i]['sec_nm']."'>
                                                <input type='hidden' name='id_val' value='".$emm[$i]['id']."'>
                                                <input type='submit' name='update' value='Update' class='update_lect'>
                                                <form method='POST' action='' class='dform'>
                                                <input type='hidden' name='del_id' value='".$emm[$i]['id']."'>
                                                <input type='submit' name='delete' value='Delete' class='delete_lect'>
                                                </form>
                                                </form>
                                                </div>  ";
                                                $i++;
                                            }
                                        }else{
                                            $err = "No Data Avalible";
                                        }
                                    }
                                    
                                ?>
                            </div>
                        </div>
                    </form>
                </div>
                </div>
            </div>

            <!-- Section 1 End  -->

        </div>

    </div>

    <script src="../javascript/jquery.js"></script>
    <script src="../javascript/all.js"></script>
    <script src="../javascript/instructorPanel.js"></script>
</body>
</html>
