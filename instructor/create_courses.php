<?php 
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if(!(isset($_SESSION['isLogin']) && isset($_SESSION['iemail']))){
    header('location:login');
}
require_once("../database/dbconn.php");

$page = "create_courses";

$usemail = $_SESSION['iemail'];

$db = new Database();

if(isset($_POST['submit'])){
    if(($_POST['inst_crs_name'] == "") || ($_POST['inst_crs_tag'] == "") || ($_POST['inst_crs_lang'] == "") || ($_POST['inst_crs_wul'] == "") || ($_POST['inst_crs_req'] == "") || ($_POST['inst_crs_desc'] == "") || ($_POST['inst_crs_cat'] == "") || ($_POST['inst_crs_art'] == "") || ($_POST['inst_crs_dnr'] == "")|| ($_POST['inst_crs_prc'] == "") || ($_POST['inst_crs_org_prc'] == "") || ($_FILES['crs_img']['name'] == "")){
        $err = "Please Fill All The Fields!";
    }else{
        $crs_name = htmlentities($_POST['inst_crs_name']);
        $crs_tag = htmlentities($_POST['inst_crs_tag']);
        $crs_lng = htmlentities($_POST['inst_crs_lang']);
        // $crs_cc = htmlentities($_FILES['inst_crs_cc']['name']);
        $crs_wul = htmlentities($_POST['inst_crs_wul']);
        $crs_req = htmlentities($_POST['inst_crs_req']);
        $crs_desc = htmlentities($_POST['inst_crs_desc']);
        $crs_cat = htmlentities($_POST['inst_crs_cat']);
        $crs_art = htmlentities($_POST['inst_crs_art']);
        $crs_dnr = htmlentities($_POST['inst_crs_dnr']);
        $crs_prc = htmlentities($_POST['inst_crs_prc']);
        $crs_org_prc = htmlentities($_POST['inst_crs_org_prc']);
        $crs_token = bin2hex(random_bytes(5));
        $crs_creator = $_SESSION['iemail'];

        $tmp_nm = $_FILES["crs_img"]["tmp_name"];
        $dest_nm = "../images/courses/";
        $file_nm = $_FILES['crs_img']['name'];
        $file_type=$_FILES['crs_img']['type'];
        $file_sz=$_FILES['crs_img']['size'];
        $file_exp = explode('.',$file_nm);
        $file_ext=strtolower(end($file_exp));
        
        $extensions= array("jpeg","jpg","png","gif");
        
        if(in_array($file_ext,$extensions)=== false){
            $err="extension not allowed, please choose a JPEG or PNG file.";
        }
        if($file_sz > 2097152){
            $err='File size must be excately 2 MB';
        }

        $img_nm = uniqid().$file_nm;
        $img_dest=$dest_nm.$img_nm;



        if(!empty($_FILES["inst_crs_cc"]["tmp_name"])){
            $tmpcc_nm = $_FILES["inst_crs_cc"]["tmp_name"];
            $destcc_nm = "../subtitles/";
            $filecc_nm = $_FILES['inst_crs_cc']['name'];
            $filecc_sz=$_FILES['inst_crs_cc']['size'];
            

            if($file_sz > 2097152){
                $err='File size must be excately 2 MB';
            }

            $cc_nm = uniqid().$filecc_nm;
            $cc_dest=$destcc_nm.$cc_nm;

            if(empty($err)==true){
                if(move_uploaded_file($tmp_nm,$img_dest) && move_uploaded_file($tmpcc_nm,$cc_dest)){
                    if($db->insert('courses',['crs_creator'=>$crs_creator,'crs_nm'=>$crs_name,'crs_tag_ln'=>$crs_tag,'crs_lng'=>$crs_lng,'crs_cc'=>$cc_nm,'stu_lrn'=>$crs_wul,'crs_req'=>$crs_req,'crs_desc'=>$crs_desc,'crs_art'=>$crs_art,'crs_res'=>$crs_dnr,'crs_price'=>$crs_prc,'crs_org_prc'=>$crs_org_prc,'crs_img'=>$img_nm,'crs_token'=>$crs_token,'crs_cat'=>$crs_cat])){
                        $msg="Course Created";
                    }else{
                        $err = "Unable to Create Course!";
                    }
                }else{
                    $err = "Unable to Create Course!";
                }
            }else{
                $err = $err;
             }
        }else{
            if(empty($err)==true){
                if(move_uploaded_file($tmp_nm,$img_dest)){
                    if($db->insert('courses',['crs_creator'=>$crs_creator,'crs_nm'=>$crs_name,'crs_tag_ln'=>$crs_tag,'crs_lng'=>$crs_lng,'stu_lrn'=>$crs_wul,'crs_req'=>$crs_req,'crs_desc'=>$crs_desc,'crs_art'=>$crs_art,'crs_res'=>$crs_dnr,'crs_price'=>$crs_prc,'crs_org_prc'=>$crs_org_prc,'crs_img'=>$img_nm,'crs_token'=>$crs_token,'crs_cat'=>$crs_cat])){
                        $msg="Course Created";
                    }else{
                        $err = "Unable to Create Course!";
                    }
                }else{
                    $err = "Unable to Create Course!";
                }
            }else{
                $err = $err;
             }
        }      
    }
}

if(isset($_GET['crs_id'])){

    $crs_token = htmlentities($_GET['crs_id']);

    $db->select('courses','crs_nm,crs_tag_ln,crs_lng,crs_cc,stu_lrn,crs_req,crs_desc,crs_art,crs_res,crs_price,crs_org_prc,crs_img,crs_cat',null,"crs_token='$crs_token'");

    $res = $db->getResult();
    $cnt_res = count($res);

    if($cnt_res > 0){
        $crs_nme = $res[0]['crs_nm'];
        $crs_tagl = $res[0]['crs_tag_ln'];
        $crs_lngl = $res[0]['crs_lng'];
        $crs_ccl = $res[0]['crs_cc'];
        $crs_wull = $res[0]['stu_lrn']; 
        $crs_reql = $res[0]['crs_req'];
        $crs_descl = $res[0]['crs_desc'];
        $crs_artl = $res[0]['crs_art'];
        $crs_dnrl = $res[0]['crs_res'];
        $crs_prcl = $res[0]['crs_price'];
        $crs_org_prcl = $res[0]['crs_org_prc'];
        $crs_cat = $res[0]['crs_cat'];
        $crs_img = $res[0]['crs_img'];
    } 

    if(isset($_POST['update'])){
        if(($_POST['inst_crs_name'] == "") || ($_POST['inst_crs_tag'] == "") || ($_POST['inst_crs_lang'] == "") || ($_POST['inst_crs_wul'] == "") || ($_POST['inst_crs_req'] == "") || ($_POST['inst_crs_desc'] == "")|| ($_POST['inst_crs_art'] == "") || ($_POST['inst_crs_dnr'] == "")|| ($_POST['inst_crs_prc'] == "") || ($_POST['inst_crs_org_prc'] == "")|| ($_POST['inst_crs_cat'] == "")){
            $err = "Please Fill All The Fields!";
        }else{
            $crs_name = htmlentities($_POST['inst_crs_name']);
            $crs_tag = htmlentities($_POST['inst_crs_tag']);
            $crs_lng = htmlentities($_POST['inst_crs_lang']);
            $crs_wul = htmlentities($_POST['inst_crs_wul']);
            $crs_req = htmlentities($_POST['inst_crs_req']);
            $crs_desc = htmlentities($_POST['inst_crs_desc']);
            $crs_art = htmlentities($_POST['inst_crs_art']);
            $crs_dnr = htmlentities($_POST['inst_crs_dnr']);
            $crs_prc = htmlentities($_POST['inst_crs_prc']);
            $crs_org_prc = htmlentities($_POST['inst_crs_org_prc']);
            $crs_cat = htmlentities($_POST['inst_crs_cat']);

            if(($_FILES['crs_img']['name'] == "") && ($_FILES['inst_crs_cc']['name'] == "")){
                if($db->update('courses',"crs_nm='$crs_name',crs_tag_ln='$crs_tag',crs_lng='$crs_lng',stu_lrn='$crs_wul',crs_req='$crs_req',crs_desc='$crs_desc',crs_art='$crs_art',crs_res='$crs_dnr',crs_price='$crs_prc',crs_org_prc='$crs_org_prc',crs_cat='$crs_cat'","crs_token='$crs_token'")){
                    $msg = "Succesfully Updated Data";
                }else{
                    $err = "Error Updating Data";
                }
            }elseif(($_FILES['crs_img']['name'] == "")){
                $tmpcc_nm = $_FILES["inst_crs_cc"]["tmp_name"];
                $destcc_nm = "../subtitles/";
                $filecc_nm = $_FILES['inst_crs_cc']['name'];
                $filecc_sz=$_FILES['inst_crs_cc']['size'];

                if($file_sz > 2097152){
                    $err='File size must be excately 2 MB';
                }

                $cc_nm = uniqid().$filecc_nm;
                $cc_dest=$destcc_nm.$cc_nm;

                if(move_uploaded_file($tmpcc_nm,$cc_dest)){
                    $unlink = $destcc_nm.$crs_ccl;
                    try{
                        unlink($unlink);
                    }catch(Exception $e){
                        $err = "Unable to process action!";
                    }
                    if($db->update('courses',"crs_nm='$crs_name',crs_tag_ln='$crs_tag',crs_lng='$crs_lng',crs_cc='$cc_nm',stu_lrn='$crs_wul',crs_req='$crs_req',crs_desc='$crs_desc',crs_art='$crs_art',crs_res='$crs_dnr',crs_price='$crs_prc',crs_org_prc='$crs_org_prc',crs_cat='$crs_cat'","crs_token='$crs_token'")){
                    $msg = "Succesfully Updated Data";
                    }
                    else{
                        $err = "Error Updating Data";
                    }
                }
                else{
                    $err = "Error Uploading Image!";
                }

            }elseif(($_FILES['inst_crs_cc']['name'] == "")){
                
                $tmp_nm = $_FILES["crs_img"]["tmp_name"];
                $dest_nm = "../images/courses/";
                $file_nm = $_FILES['crs_img']['name'];
                $file_type=$_FILES['crs_img']['type'];
                $file_sz=$_FILES['crs_img']['size'];
                $file_exp = explode('.',$file_nm);
                $file_ext=strtolower(end($file_exp));
                
                $extensions= array("jpeg","jpg","png","gif");
                
                if(in_array($file_ext,$extensions)=== false){
                    $err="extension not allowed, please choose a JPEG or PNG file.";
                }
                if($file_sz > 2097152){
                    $err='File size must be excately 2 MB';
                }

                $img_nm = uniqid().$file_nm;
                $img_dest=$dest_nm.$img_nm;

                if(move_uploaded_file($tmp_nm,$img_dest)){
                    $unlink = $dest_nm.$crs_img;
                    try{
                        unlink($unlink);
                    }catch(Exception $e){
                        $err = "Unable to process action!";
                    }
                    if($db->update('courses',"crs_nm='$crs_name',crs_tag_ln='$crs_tag',crs_lng='$crs_lng',stu_lrn='$crs_wul',crs_req='$crs_req',crs_desc='$crs_desc',crs_art='$crs_art',crs_res='$crs_dnr',crs_price='$crs_prc',crs_org_prc='$crs_org_prc',crs_img='$img_nm',crs_cat='$crs_cat'","crs_token='$crs_token'")){
                        $msg = "Succesfully Updated Data";
                    }else{
                        $err = "Error Updating Data";
                    }
                }else{
                    $err = "Error Updating Image";
                }
            }else{
                $err = "Error Updating Data!";
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
    <title>Create Course</title>
    <link rel="stylesheet" href="css/all.css">
    <link rel="stylesheet" href="../css/instructorPanel.css">
</head>
<body>
    <?php include_once('../inc/instHeader.php') ?>

    <div class="inst_ss">  
        <?php include_once('sidebar.php') ?>

        <div class="dash">

            <!-- Section 1 Start  -->

            <div class="inst_crs_sec1">
                <div class="inst_crs_sec1_ttl">Course Details</div>
                <div class="inst_crs_sec1_bdy">
                    <form action="" method="POST" enctype="multipart/form-data">

                        <!-- Course Banner Section Start  -->

                        <div class="inst_crs">
                            <label for="inst_crs_name" class="inst_crs_det_lbl">Course Name</label>
                            <input class="inst_crs_inpt" type="text" name="inst_crs_name" id="inst_crs_name" value="<?php if(isset($crs_nme)){ echo $crs_nme; } ?>">
                        </div>
                        <div class="inst_crs">
                            <label for="inst_crs_tag"  class="inst_crs_det_lbl">Course Tag Line</label>
                            <input type="text" class="inst_crs_inpt" name="inst_crs_tag" id="inst_crs_tag" value="<?php if(isset($crs_tagl)){ echo $crs_tagl;} ?>">
                        </div>
                        <div class="inst_crs_det">
                           <div class="inst_selection">
                                <label for="inst_crs_lang" class="inst_crs_det_lbl">Language</label>
                                <select class="inst_crs_lang" name="inst_crs_lang">
                                    <!-- <option value=""><input type="text" class="inst_crs_inpt" name="inst_crs_lang" id="inst_crs_lang"></option> -->
                                    <option <?php if(isset($crs_lngl) && $crs_lngl == "english"){ echo "selected";} ?> value="english">English</option>
                                    <option <?php if(isset($crs_lngl) && $crs_lngl == "telugu"){ echo "selected";} ?> value="telugu">Telugu</option>
                                    <option <?php if(isset($crs_lngl) && $crs_lngl == "hindi"){ echo "selected";} ?> value="hindi">Hindi</option>
                                    <option <?php if(isset($crs_lngl) && $crs_lngl == "tamil"){ echo "selected";} ?> value="tamil">Tamil</option>
                                    <option <?php if(isset($crs_lngl) && $crs_lngl == "malyalam"){ echo "selected";} ?> value="malyalam">Malyalam</option>
                                    <option <?php if(isset($crs_lngl) && $crs_lngl == "french"){ echo "selected";} ?> value="french">French</option>
                                    <option <?php if(isset($crs_lngl) && $crs_lngl == "russian"){ echo "selected";} ?> value="russian">Russian</option>
                                    <option <?php if(isset($crs_lngl) && $crs_lngl == "chinese"){ echo "selected";} ?> value="chinese">Chinese</option>
                                    <option <?php if(isset($crs_lngl) && $crs_lngl == "urudu"){ echo "selected";} ?> value="urudu">Urudu</option>
                                </select>
                           </div>
                            
                            <div class="inst_selection">
                                <label for="inst_crs_cc" class="inst_crs_det_lbl">CC</label>
                                <input type="file" class="inst_crs_file" name="inst_crs_cc" id="inst_crs_cc" multiple>
                            </div>
                        </div>

                        <!-- Course Banner Section End  -->

                        <!-- Course Desc Section Start  -->

                        <div class="inst_crs">
                            <label for="inst_crs_wul" class="inst_crs_det_lbl">What Student Can learn  <small>Seperate the statements by using "."(Full Stop)</small></label>
                            <textarea class="inst_crs_inpt" name="inst_crs_wul" id="inst_crs_wul">
<?php if(isset($crs_wull)){ echo $crs_wull;}else{ ?>

<?php } ?>
                            </textarea>
                        </div>
                        <br>
                        <div class="inst_crs">
                            <label for="inst_crs_req" class="inst_crs_det_lbl">Requirements <small>Seperate the statements by using "."(Full Stop)</small></label>
                            <textarea class="inst_crs_inpt" name="inst_crs_req" id="inst_crs_req">
<?php if(isset($crs_reql)){ echo $crs_reql;}else{ ?>

<?php } ?>
                            </textarea>
                        </div>
                        <br>
                        <div class="inst_crs">
                            <label for="inst_crs_desc" class="inst_crs_det_lbl">Description</label>
                            <textarea class="inst_crs_inpt" name="inst_crs_desc" id="inst_crs_desc"><?php if(isset($crs_descl)){ echo $crs_descl;} ?></textarea>
                        </div>

                        <!-- Course Desc Section End  -->

                        <!-- Course Details Section Start  -->

                        <div class="inst_crs_det">
                            <div class="inst_details_Sec">
                                <label for="inst_crs_cat" class="inst_crs_det_lbl">Category</label>
                                <!-- <input type="text" class="inst_crs_inpt_det" value="<?php if(isset($crs_durl)){ echo $crs_durl;} ?>"> -->
                                <select class="inst_crs_inpt_det" name="inst_crs_cat" id="inst_crs_len" >
                                    <option>Select</option>
                                    <?php 
                                        $db->select('category','*');
                                        $resu = $db->getResult(); 
                                        $res_cnt = count($resu);
                                        if($res_cnt > 0){
                                            $i=0;
                                            while($i < $res_cnt){ ?>
                                                <option <?php if(isset($crs_cat)){ if($crs_cat == $resu[$i]['cat_name']){ echo 'selected';} } ?> value=  "<?php echo $resu[$i]['cat_name'] ?>" ><?php  echo $resu[$i]['cat_name']; ?></option>
                                            <?php  $i++;
                                            }
                                        }
                                    ?>
                                </select>
                            </div>

                            <div class="inst_details_Sec">
                                <label for="inst_crs_art" class="inst_crs_det_lbl">Articles Provided</label>
                                <input type="text" class="inst_crs_inpt_det" name="inst_crs_art" id="inst_crs_art" value="<?php if(isset($crs_artl)){ echo $crs_artl;} ?>">
                            </div>

                            <div class="inst_details_Sec">
                                <label for="inst_crs_dnr" class="inst_crs_det_lbl">Downloadable Resourses</label>
                                <input type="text" class="inst_crs_inpt_det" name="inst_crs_dnr" id="inst_crs_dnr0" value="<?php if(isset($crs_dnrl)){ echo $crs_dnrl;} ?>">
                            </div>
                        </div>
                        <div class="inst_crs_det">
                            <div class="inst_details_Sec">
                                <label for="inst_crs_prc" class="inst_crs_det_lbl">Price</label>
                                <input type="text" class="inst_crs_inpt" name="inst_crs_prc" id="inst_crs_prc" value="<?php if(isset($crs_prcl)){ echo $crs_prcl;} ?>">
                            </div>
                            <div class="inst_details_Sec">
                                <label for="inst_crs_org_prc" class="inst_crs_det_lbl">Original Price</label>
                                <input type="text" class="inst_crs_inpt" name="inst_crs_org_prc" id="inst_crs_org_prc" value="<?php if(isset($crs_org_prcl)){ echo $crs_org_prcl;} ?>">
                            </div>
                        </div>

                        <!-- Course Details Section End  -->

                        <!-- Course Image Section End  -->
                        <div class="inst_crs_det">
                            <div class="inst_details_Sec">
                                <label for="inst_crs_art" class="inst_crs_det_lbl">Course Image</label>
                                <input type="file" name="crs_img" id="crs_img">
                            </div>
                        </div>
                        <!-- Course Image Section End  -->
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
                        <!-- Course Buttons Section Start  -->

                        <div class="inst_crs_btn">
                            <button type="rest" class="inst_crs_rst_btn inst_crs_btns" id="inst_crs_rst_btn">Reset</button>
                            <?php if(isset($_GET['crs_id'])){ ?>
                                <input type="submit" value="Update" name="update" class="inst_crs_crt_btn inst_crs_btns" id="inst_crs_crt_btn">
                            <?php }else{ ?>
                            <input type="submit" value="Create" name="submit" class="inst_crs_crt_btn inst_crs_btns" id="inst_crs_crt_btn">
                            <?php } ?>
                        </div>
                        <!-- Course Buttons Section End  -->
                    </form>
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