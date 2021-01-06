<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
require_once("database/dbconn.php");

$page = "course";

$db = new Database();

if(isset($_GET['crs_id'])){

    $crs_token = htmlentities($_GET['crs_id']);

    $db->select('courses','crs_creator,crs_nm,crs_tag_ln,crs_lng,crs_cc,stu_lrn,crs_req,crs_desc,crs_dur,crs_art,crs_res,crs_price,crs_org_prc,crs_img,lst_upt',null,"crs_token='$crs_token'");

    $res = $db->getResult();
    $crs_count = count($res);
    if($crs_count > 0){
        $crs_creator = $res[0]['crs_creator'];
        $crs_nme = $res[0]['crs_nm'];
        $crs_tagl = $res[0]['crs_tag_ln'];
        $crs_lngl = $res[0]['crs_lng'];
        $crs_ccl = $res[0]['crs_cc'];
        $crs_wull = $res[0]['stu_lrn']; 
        $crs_reql = $res[0]['crs_req'];
        $crs_descl = $res[0]['crs_desc'];
        $crs_durl = $res[0]['crs_dur'];
        $crs_artl = $res[0]['crs_art'];
        $crs_dnrl = $res[0]['crs_res'];
        $crs_prcl = $res[0]['crs_price'];
        $crs_org_prcl = $res[0]['crs_org_prc'];
        $crs_img = $res[0]['crs_img'];
        $lst_upt = $res[0]['lst_upt'];
    }

    if(isset($crs_creator)){
        if($db->select('instructor_data','iname,idesc,ipic',null,"iemail='$crs_creator'")){
            $res1 = $db->getResult();
            $iname = $res1[0]['iname'];
            $idesc = $res1[0]['idesc'];
            $ipic = $res1[0]['ipic'];
        }else{
            $err = "Error Fecthing Data!";
        }
    }else{
        $err = "Error Fecthing Data!";
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title></title>
    <link rel="stylesheet" href="css/all.css">
    <link rel="stylesheet" href="css/custom.css">
</head>
<body id="crs_bdy">
    <!-- Header Section Start -->
    <?php include_once('inc/header.php') ?>
    <!-- Header Section End -->

    <!-- Sidebar Start  -->
    <div class="crs_sidebar">
       <div class="crs_video_bar">
        <?php if(isset($_GET["crs_id"])){ 
            $crs_tokenn = $_GET["crs_id"];
            if($db->select('lectures',"DISTINCT (lct_vid)",null,"crs_token ='$crs_tokenn'")){
                $em1 = $db->getResult();
                $cnt1 = count($em1);
                if($cnt1 != 0){ $vid = $em1['0']['lct_vid']; }
        ?>
        <video src="videos/<?php echo $vid; } } ?>" class="crs_sbr_video" width="100%"; height="100%";>

        </video>           
       </div>
       <div class="crs_sbr_body">
       <?php
        if(isset($crs_org_prcl)){
            $prct2 = round($crs_prcl / ($crs_org_prcl / 100),2);
            $prct2 = 100 - $prct2 . "%"; 
        }
       ?>
            <span class="crs_sbr_price crs_mr"><span class="crs_prce"> <b>₹</b> <?php if(isset($crs_prcl)){ echo $crs_prcl; } ?></span> &nbsp;<span class="crs_discount">₹<?php if(isset($crs_org_prcl)){ echo $crs_org_prcl; } ?></span> &nbsp;<span class="crs_off"><?php if(isset($prct2)){ echo $prct2;} ?> off</span></span>
            <span class="crs_sbr_tme_lft crs_mr"> <i class="fas fa-clock"></i> 5 days left at this price!</span>
            <form action="" method="POST">
                <input type='submit' value='Add to cart' name="add_to_cart" class='crs_sbr_btn add_btn crs_mr' id='add_to_cart' >
            </form>
            <?php
                if(isset($_SESSION['uemail'])){
                    $uemail = $_SESSION['uemail'];
                    if(isset($crs_token) && isset($uemail)){
                        if($db->select('user_courses',"courses_en",null,"courses_en ='$crs_token' AND ucmail = '$uemail'")){
                            $emm = $db->getResult();
                            $cntt = count($emm);
                            if($cntt == 0){
                                if($db->select('cart',"cart_crs_token",null,"cart_crs_token ='$crs_token' AND uemail = '$uemail'")){
                                    $em = $db->getResult();
                                    $cnt = count($em);
                                    if($cnt == 0){
                                 
                                    }else{
                                        ?>
                                        <script>
                                            var add = document.getElementById('add_to_cart'); 
                                            var att = document.createAttribute('disabled');  
                                            att.value='disabled';
                                            var att2 = document.createAttribute('style');  
                                            att2.value='rgb(236, 82, 82,0.2)';
                                            add.setAttributeNode(att);
                                            add.setAttributeNode(att2);
                                        </script>
                                        <?php
                                    }
                                }
                            }else{
                                ?>
                                <script>
                                    var add = document.getElementById('add_to_cart'); 
                                    var att = document.createAttribute('disabled');  
                                    att.value='disabled';
                                    var att2 = document.createAttribute('style');  
                                    att2.value='background-color:rgb(236, 82, 82,0.2);';
                                    add.setAttributeNode(att);
                                    add.setAttributeNode(att2);
                                </script><?php
                            }
                        }
                    }
                }
            ?>
           
            <?php
            if(isset($_POST['add_to_cart'])){
                if(!(isset($_SESSION['isLogin']) && isset($_SESSION['uemail']))){
                    echo "<script>location.href='login?cart=$crs_token'</script>";
                }else{
                    $uemail = $_SESSION['uemail'];
                    if($db->select('cart',"cart_crs_token",null,"cart_crs_token ='$crs_token' AND uemail = '$uemail'")){
                        $em = $db->getResult();
                        $cnt = count($em);
                        if($cnt == 0){
                            if($db->insert('cart',['cart_crs_token'=>$crs_token,'uemail'=>$uemail,'crs_creator'=>$crs_creator])){
                            ?>
                            <script>
                                var add = document.getElementById('add_to_cart'); 
                                var att = document.createAttribute('disabled');  
                                att.value='disabled';
                                var att2 = document.createAttribute('style');  
                                att2.value='rgb(236, 82, 82,0.2)';
                                add.setAttributeNode(att);
                                add.setAttributeNode(att2);
                                location.reload();
                            </script>
                            <?php
                            }
                        }else{
                            ?>
                            <script>
                                var add = document.getElementById('add_to_cart'); 
                                var att = document.createAttribute('disabled');  
                                att.value='disabled';
                                var att2 = document.createAttribute('style');  
                                att2.value='background-color:rgb(236, 82, 82,0.2);';
                                add.setAttributeNode(att);
                                add.setAttributeNode(att2);
                                <?php $_SESSION['btn'] = "style='background-color:rgb(236, 82, 82,0.2);'" ?>
                            </script><?php
                        }
                    }else{
                        $err = "Error";
                    }
                }
            }
            ?>
           <?php
             if(isset($crs_token) && isset($uemail)){
                if($db->select('user_courses',"courses_en",null,"courses_en ='$crs_token' AND ucmail = '$uemail'")){
                    $emm = $db->getResult();
                    $cntt = count($emm);
                    if($cntt == 0){

                    }else{ ?>
                        <script>
                                var buy_nw = document.getElementById('buy_nw'); 
                                var att = document.createAttribute('disabled');  
                                att.value='disabled';
                                var att2 = document.createAttribute('style');  
                                att2.value='rgb(236, 82, 82,0.2)';
                                buy_nw.setAttributeNode(att);
                                buy_nw.setAttributeNode(att2);
                        </script>
                <?php }
                }
            }
           ?>
            <a href="./checkout?crs_id=<?php if(isset($crs_token)){ echo $crs_token; } ?>" class="crs_sbr_btn buy_btn crs_mr" id="buy_nw">Buy Now</a>
            <span class="crs_sbr_mny crs_mr">30-Day Money-Back Guarantee</span>
            <div class="crs_sbr_div crs_mr">
                <span class="crs_sbr_ttl crs_mr">This course includes:</span>
                <span class="crs_sbr_1 crs_mr"><i class="fas fa-file-video"></i>&nbsp; <span><?php if(isset($crs_durl)){ echo $crs_durl; } ?></span> hours on-demand video</span>
                <span class="crs_sbr_2 crs_mr"><i class="fas fa-file-pdf"></i>&nbsp; <span><?php if(isset($crs_artl)){ echo $crs_artl; } ?></span> articles</span>
                <span class="crs_sbr_3 crs_mr"><i class="fas fa-download"></i>&nbsp; <span><?php if(isset($crs_dnrl)){ echo $crs_dnrl; } ?></span> downloadable resources</span>
                <span class="crs_sbr_4 crs_mr"><i class="fas fa-infinity"></i>&nbsp; Full lifetime access</span>
                <span class="crs_sbr_5 crs_mr"><i class="fas fa-mobile"></i>&nbsp; Access on mobile and TV</span>
                <span class="crs_sbr_6 crs_mr"><i class="fas fa-certificate"></i>&nbsp; Certificate of completion</span>
            </div>
       </div>
       <hr class="hr">
       <div class="crs_sbr_end">
            <span class="crs_sbr_end_title crs_mr">Training 5 or more people?</span>
            <span class="crs_sbr_end_sub crs_mr">Get your team access to 4,000+ top Udemy courses anytime, anywhere.</span>
            <a href="signup" class="crs_sbr_btn buy_btn crs_mr">Try MKLearn Bussiness</a>
       </div>
    </div>
    <!-- Sidebar End  -->


    <!-- Section 1 Start  -->
    <?php
        $db->select('course_order','COUNT(crs_ord_id)',null,"crs_token = '$crs_token'");
        $emmc = $db->getResult();
        $cntc = count($emmc);
    ?>

    <div class="c_top_header">
        <div class="c_top_sec1">
            <span class="crs_title crs_cmm"><?php if(isset($crs_nme)){ echo $crs_nme; } ?></span>
            <span class="crs_tag crs_cmm"><?php if(isset($crs_tagl)){ echo $crs_tagl; } ?></span>
            <?php 
                    $db->select('review','AVG(ratings) as avg',null,"crs_token='$crs_token'");
                    $rt1 = $db->getResult();
                    $rt1_cnt = count($rt1);
                    if($rt1_cnt > 0){
                        $rating =  $rt1['0']['avg'];
                        $rat_round = substr(number_format($rating, 2, '.', ''), 0, -1);
                    }
                ?>
            <span class="crs_line1 crs_cmm"><span class="bst_seller">Best Seller</span> <span class="sec_crs_ratings"><?php echo $rat_round; ?> (Ratings)</span> <span class="auth_students"><?php if(!empty($cntc)){ echo $cntc . " " . "students";} ?></span></span>
            <span class="author crs_cmm">Created By <a href="#"><?php if(isset($iname)){ echo $iname; } ?></a></span>
            <span class="crs_line2 crs_cmm"><span class="last_updated"><i class="fas fa-exclamation-circle"></i><?php if(isset($lst_upt)){ echo $lst_upt; } ?></span>   <span class="crs_lang"><i class="fas fa-globe"></i> <?php if(isset($crs_lngl)){ echo $crs_lngl; } ?></span>    <span class="crs_cc"><i class="fas fa-closed-captioning"></i> CC</span></span>
            <span class="crs_btns crs_cmm">
                <span class="crs_top_btn">Wishlist &nbsp;<i class="fas fa-heart"></i></span>
                <input type="text" value="" id="cshare" class="hide">
                <span class="crs_top_btn" id="share_btn">Share &nbsp;<i class="fas fa-share"></i></span>
                <span class="crs_top_btn">Gift this Course</span>
            </span>
        </div>
    </div>
    <!-- Section 1 End  -->


    <!-- Section 2 Start  -->

    <div class="crs_sec2">
        <ul class="crs_sec2_ul">
            <p class="crs_Sec2_ttl">What you'll learn</p>
            <?php if(isset($crs_wull)){ 
                $mark=explode('.', $crs_wull);
                foreach($mark as $out) {
                    echo "<li class='crs_sec2_listy'>&nbsp; &nbsp;$out</li>";
                }
            } ?> 
        </ul>
    </div>

     <!-- Section 2 End  -->


    <!-- Section 3 Start  -->

    <div class="crs_sec3">
        <ul>
            <p class="crs_sec3_ttl">Requirements</p>
            <?php if(isset($crs_reql)){ 
                $mark=explode('.', $crs_reql);
                foreach($mark as $out) {
                    echo "<li class='crs_sec3_listy'>$out</li>";
                }
            } ?>
        </ul>
        <div>
            <p class="crs_sec3_ttl">Description</p>
            <p><?php if(isset($crs_descl)){ echo $crs_descl; } ?></p>
        </div>
        
    </div>

    <!-- Section 3 End  -->


    <!-- Section 4 Start  -->

    <!-- <div class="crs_sec4 crs_cmm_sec">
        <p class="crs_Sec4_ttl">Featured review</p>
        <div class="crs_sec4_ul">
            <div class="crs_sec4_ul2">
                <div class="crs_sec4_img_div">
                <img src="images/profile.jpg" alt="" class="crs_sec4_img">
                </div>
                <div class="crs_sec4_det">
                    <p>Name</p>
                    <p>Courses</p>
                    <p>Reviews</p>
                </div>
            </div>
            <div><span>Ratings</span> <span>Time Ago</span></div>
            <div class="crs_sec4_des">Lorem ipsum dolor sit amet consectetur adipisicing elit. Dolorum, corrupti. Nam iure consequuntur consectetur ipsum minus, quas explicabo veritatis recusandae cupiditate amet, voluptatem eaque, nisi laboriosam facilis ut! Neque labore alias ex corrupti iusto repellendus exercitationem sequi adipisci eveniet suscipit incidunt quam, modi explicabo eum dignissimos quas.</div>
            <div class="crs_sec4_des2">Was this review helpful?</div>
        </div>
        <div class="crs_sec4_end"> <span><i class="far fa-thumbs-up fa-2x"></i> <i class="far fa-thumbs-down fa-2x"></i></span>  &nbsp; &nbsp;<a href="#" class="crs_sec4_report">Report</a></div>
    </div> -->

     <!-- Section 4 End  -->


    <!-- Section 5 Start  -->

    <div class="crs_sec5 crs_cmm_sec">
        <p class="crs_ec5_p1">Students also bought</p> 
        <div class="crs_sec5_cor">
            <div class="crs_sec5_cor_img">
                <img src="images/courses/sample.png" alt="">
            </div>
            <div class="crs_sec5_div1">
                <p class="crs_sec5_ttl">Title of Course</p>
                <div class="crs_sec5_idiv2">
                    <span class="crs_line1 crs_cmm"> <span class="crs_bst_seller">Best Seller</span> <span class="crs_hours">Hours</span> <span class="crs_updated">Updated</span></span>
                </div>
            </div>
            <div class="crs_sec5_div2">
                <p>Ratings&nbsp; <i class="fas fa-star crs_sec7_icons"></i></p>
            </div>
            <div class="crs_sec5_div3">
                <p>Students&nbsp;<i class="fas fa-user-friends"></i></p>
            </div>
            <div class="crs_sec5_div4">
                <p class="crs_sec5_4p1">Price</p>
                <p class="crs_sec5_4p2">price</p>
            </div>
            <div class="crs_sec5_div5">
                <i class="fab fa-gratipay fa-2x"></i>
            </div>
        </div> 
        
        
        <div class="crs_sec5_cor">
            <div class="crs_sec5_cor_img">
                <img src="images/courses/sample.png" alt="">
            </div>
            <div class="crs_sec5_div1">
                <p class="crs_sec5_ttl">Title of Course</p>
                <div class="crs_sec5_idiv2">
                    <span class="crs_line1 crs_cmm"> <span class="crs_bst_seller">Best Seller</span> <span class="crs_hours">Hours</span> <span class="crs_updated">Updated</span></span>
                </div>
            </div>
            <div class="crs_sec5_div2">
                <p>Ratings&nbsp; <i class="fas fa-star crs_sec7_icons"></i></p>
            </div>
            <div class="crs_sec5_div3">
                <p>Students&nbsp;<i class="fas fa-user-friends"></i></p>
            </div>
            <div class="crs_sec5_div4">
                <p class="crs_sec5_4p1">Price</p>
                <p class="crs_sec5_4p2">price</p>
            </div>
            <div class="crs_sec5_div5">
                <i class="fab fa-gratipay fa-2x"></i>
            </div>
        </div>  
        
        
        <div class="crs_sec5_cor">
            <div class="crs_sec5_cor_img">
                <img src="images/courses/sample.png" alt="">
            </div>
            <div class="crs_sec5_div1">
                <p class="crs_sec5_ttl">Title of Course</p>
                <div class="crs_sec5_idiv2">
                    <span class="crs_line1 crs_cmm"> <span class="crs_bst_seller">Best Seller</span> <span class="crs_hours">Hours</span> <span class="crs_updated">Updated</span></span>
                </div>
            </div>
            <div class="crs_sec5_div2">
                <p>Ratings&nbsp; <i class="fas fa-star crs_sec7_icons"></i></p>
            </div>
            <div class="crs_sec5_div3">
                <p>Students&nbsp;<i class="fas fa-user-friends"></i></p>
            </div>
            <div class="crs_sec5_div4">
                <p class="crs_sec5_4p1">Price</p>
                <p class="crs_sec5_4p2">price</p>
            </div>
            <div class="crs_sec5_div5">
                <i class="fab fa-gratipay fa-2x"></i>
            </div>
        </div>     

        <div class="crs_sec5_cor">
            <div class="crs_sec5_cor_img">
                <img src="images/courses/sample.png" alt="">
            </div>
            <div class="crs_sec5_div1">
                <p class="crs_sec5_ttl">Title of Course</p>
                <div class="crs_sec5_idiv2">
                    <span class="crs_line1 crs_cmm"> <span class="crs_bst_seller">Best Seller</span> <span class="crs_hours">Hours</span> <span class="crs_updated">Updated</span></span>
                </div>
            </div>
            <div class="crs_sec5_div2">
                <p>Ratings&nbsp; <i class="fas fa-star crs_sec7_icons"></i></p>
            </div>
            <div class="crs_sec5_div3">
                <p>Students&nbsp;<i class="fas fa-user-friends"></i></p>
            </div>
            <div class="crs_sec5_div4">
                <p class="crs_sec5_4p1">Price</p>
                <p class="crs_sec5_4p2">price</p>
            </div>
            <div class="crs_sec5_div5">
                <i class="fab fa-gratipay fa-2x"></i>
            </div>
        </div>  
        
        <button class="shmore" id="crs_recent">Show More</button>
    </div>

     <!-- Section 5 End  -->


     <!-- Section 6 Start  -->

     <div class="crs_sec6 crs_cmm_sec">
        <p class="crs_sec6_ttl">Course content</p>
        <?php
            $db->select('lectures','COUNT(DISTINCT sec_nm) as sec_nm,COUNT( lct_nm ) as lct_nm,SEC_TO_TIME(SUM(TIME_TO_SEC(`lct_dur`))) as time',null,"crs_token = '$crs_token'");
            $resc = $db->getResult();
            $cnttc = count($resc);
            if($cnttc != 0){
                $secs = $resc['0']['sec_nm'];
                $lects = $resc['0']['lct_nm'];
                $times = $resc['0']['time'];
                echo "<div class='crs_sec6_det'><span>$secs Sections • </span><span>$lects Lectures • </span><span> $times total length</span></div>";
            }
        ?>
        <div class="crs_sec6_cnt">

        <?php 
            $db->select('lectures','DISTINCT(sec_nm) as name',null,"crs_token='$crs_token'");
            $emmt = $db->getResult();
            $cnttt = count($emmt);
            $i=0;
            while($i<$cnttt){
                $sec_name = $emmt[$i]['name'];    
                $db->select('lectures','SEC_TO_TIME(SUM(TIME_TO_SEC(`lct_dur`))) as time2',null,"crs_token='$crs_token' AND sec_nm = '$sec_name'");
                $sec_tm = $db->getResult();
                $sec_time = $sec_tm['0']['time2'];
            ?>
                <details class="crs_sec6_details" <?php if($i==0){ echo "open";} ?>>
                    <summary class="crs_sec6_summary">
                        <span class="crs_sec6_sum1">
                            <span class='crs_sec6_sum_name'><?php echo $sec_name; ?></span><span class='crs_sec6_sum_dur'><?php echo $sec_time; ?></span>
                        </span>
                    </summary>
                    <ul>
                    <?php $db->select('lectures','lct_nm,lct_dur',null,"crs_token='$crs_token' AND sec_nm = '$sec_name'");
                        $ltt = $db->getResult();
                        $cont = count($ltt);
                        if($cont != 0){
                            $j=0;
                            while($j<$cont){
                                $llct_nm = $ltt[$j]['lct_nm'];
                                $llct_dr = $ltt[$j]['lct_dur'];
                                $num = $j + 1;
                                echo "<li><span class='crs_sec6_liname'>$num. $llct_nm</span><span class='crs_sec6_litime'>$llct_dr</span></li>";
                                $j++;
                            }
                        }
                    ?>
                    </ul>
                </details>
        <?php
                $i++;
            }
        ?>
        
        </div>
     </div>
     <!-- Section 6 End  -->

    <!-- Section 7 Start  -->
    <?php
        $db->select('course_order','COUNT(crs_ord_id)',null,"crs_creator = '$crs_creator'");
        $emmc = $db->getResult();
        $cntc = count($emmc);
    ?>

    <div class="crs_sec7 crs_cmm_sec">
        <p class="crs_Sec7_ttl">Instructor</p>
        <p class="crs_Sec7_ins"><?php if(isset($iname)){ echo $iname; } ?></p>
        <p class="crs_Sec7_ins_det">Instructor Details</p>
        <div class="crs_sec7_ul">
            <div class="crs_sec7_ul2">
                <div class="crs_sec7_img_div">
                <img src="images/instructors/<?php if(isset($ipic)){ echo $ipic; } ?>" alt="" class="crs_sec7_img">
                </div>
                <div class="crs_sec7_det">
                    <?php
                        $db->select('review','COUNT(id) as reviews',null,"creator_email='$crs_creator'");
                        $rev=$db->getResult();
                        if(count($rev) > 0){
                            $rev_cnt = $rev['0']['reviews'];
                            echo "<p><i class='fas fa-medal crs_sec7_icons'></i>&nbsp; &nbsp;$rev_cnt Reviews</p>";
                        }else{
                            echo "<p><i class='fas fa-medal crs_sec7_icons'></i>&nbsp; &nbsp;0</p>";
                        }
                    ?>
                    <p><i class="fas fa-user-friends crs_sec7_icons"></i>&nbsp;&nbsp;<?php echo $cntc;?> Students</p>
                    <p><i class="fas fa-play-circle crs_sec7_icons"></i>&nbsp; &nbsp;<?php if(isset($crs_count)){ echo $crs_count; } ?></p>
                </div>
            </div>
            <div class="crs_sec7_des"><?php if(isset($idesc)){ echo $idesc; } ?></div>
        </div>
    </div>

     <!-- Section 7 End  -->



     <!-- Section 8 Start  -->
        <div class="crs_sec8 crs_cmm_sec">
            <p class="crs_sec8_p1">Student feedback</p>
            <div class="crs_sec8_div">
                <div class="crs_sec8_div1">
                    <p class='crs_sec8_div1_p1'><?php echo $rat_round; ?></p>
                    <p class="crs_sec8_div1_p2">stars</p>
                    <p class="crs_sec8_div1_p3">Course Rating</p>
                </div>
                <?php 
                    $db->selectg('review','ratings,COUNT(*) as avg2',null,"crs_token='$crs_token'","ratings",null);
                    $rt2 = $db->getResult();
                    $rt2_cnt = count($rt2);
                    if($rt2_cnt > 0){
                        $j=0;
                        $avgg = array();
                        while($j < $rt2_cnt){
                            array_push($avgg,$rt2[$j]['avg2']);
                            $j++;
                        }
                    }
                ?>
                <?php 
                    $db->select('review','COUNT(ratings) as avg3',null,"crs_token='$crs_token'");
                    $rt3 = $db->getResult();
                    $rt3_cnt = count($rt3);
                    if($rt3_cnt > 0){
                        $avgg_cnt = $rt3['0']['avg3'];
                    }
                ?>
                <div class="crs_sec8_div2">
                    <progress value="<?php if(isset($avgg['4'])){ echo $avgg['4']; }else{ echo '0'; } ?>" max="<?php if(isset($avgg_cnt)){ echo $avgg_cnt; }else{ echo '5'; } ?>"></progress>
                    <progress value="<?php if(isset($avgg['3'])){ echo $avgg['3']; }else{ echo '0'; } ?>" max="<?php if(isset($avgg_cnt)){ echo $avgg_cnt; }else{ echo '5'; } ?>"></progress>
                    <progress value="<?php if(isset($avgg['2'])){ echo $avgg['2']; }else{ echo '0'; } ?>" max="<?php if(isset($avgg_cnt)){ echo $avgg_cnt; }else{ echo '5'; } ?>"></progress>
                    <progress value="<?php if(isset($avgg['1'])){ echo $avgg['1']; }else{ echo '0'; } ?>" max="<?php if(isset($avgg_cnt)){ echo $avgg_cnt; }else{ echo '5'; } ?>"></progress>
                    <progress value="<?php if(isset($avgg['0'])){ echo $avgg['0']; }else{ echo '0'; } ?>" max="<?php if(isset($avgg_cnt)){ echo $avgg_cnt; }else{ echo '5'; } ?>"></progress>
                </div>
                <div class="crs_sec8_div3">
                    <p>5 &nbsp;<?php $c = 0; while($c < 5){ echo "<span class='fas fa-star' style='color:#fd4; stroke:#444; stroke-width:20px;'></span>"; $c++;}?></p>
                    <p>4 &nbsp;<?php $c = 0; while($c < 4){ echo "<span class='fas fa-star' style='color:#fd4; stroke:#444; stroke-width:20px;'></span>"; $c++;}?></p>
                    <p>3 &nbsp;<?php $c = 0; while($c < 3){ echo "<span class='fas fa-star' style='color:#fd4; stroke:#444; stroke-width:20px;'></span>"; $c++;}?></p>
                    <p>2 &nbsp;<?php $c = 0; while($c < 2){ echo "<span class='fas fa-star' style='color:#fd4; stroke:#444; stroke-width:20px;'></span>"; $c++;}?></p>
                    <p>1 &nbsp;<?php $c = 0; while($c < 1){ echo "<span class='fas fa-star' style='color:#fd4; stroke:#444; stroke-width:20px;'></span>"; $c++;}?></p>
                </div>
            </div>
        </div>
     <!-- Section 8 End  -->

     <?php
        if(isset($_POST['r_submit'])){
            if(isset($_SESSION['isLogin']) && $_SESSION['isLogin']){
                $uemail = $_SESSION['uemail'];
                $db->select('user_data','uname',null,"uemail = '$uemail'");
                $unamea = $db->getResult();
                if(count($unamea) != 0){
                    $name = $unamea['0']['uname'];
                    if(isset($_POST['star']) && isset($_POST['ucomment'])){
                        $star = $_POST['star'];
                        $cmmt = $_POST['ucomment'];
                        $db->insert('review',['name'=>$name,'ratings'=>$star,'comment'=>$cmmt,'stu_email'=>$uemail,'crs_token'=>$crs_token,'creator_email'=>$crs_creator]);
                    }else{
                        echo "<script>location.href='index.php'</script>";
                    }
                }else{
                    echo "<script>location.href='login.php'</script>";
                }
            }else{
                echo "<script>location.href='login.php'</script>";
            }    
        }
     ?>

     <!-- Section 9 Start  -->
     <p class="crs_cmmt_sec">Comment Section</p>
     <div class="crs_sec9 crs_cmm_sec">
            <form action="" id="comment_sec" class="comment_sec" method="POSt">
                <div class="rating-h">Rating</div>
                <div class="stars">
                    <input class="star star-5" id="star-5" type="radio" name="star" value="5" />
                    <label class="star star-5" for="star-5"></label>
                    <input class="star star-4" id="star-4" type="radio" name="star" value="4" />
                    <label class="star star-4" for="star-4"></label>
                    <input class="star star-3" id="star-3" type="radio" name="star" value="3" />
                    <label class="star star-3" for="star-3"></label>
                    <input class="star star-2" id="star-2" type="radio" name="star" value="2" />
                    <label class="star star-2" for="star-2"></label>
                    <input class="star star-1" id="star-1" type="radio" name="star" value="1" />
                    <label class="star star-1" for="star-1"></label>
                </div>

                <div class="comment_div">
                    <label for="ucomment" class="rating-h">Comment</label>
                    <textarea name="ucomment" id="ucomment" cols="30" rows="10"></textarea>
                </div>
                <input class="submit_btn_sec9" type="submit" value="Comment" name="r_submit">
            </form>
        </div>
     <!-- Section 9 End  -->


     <!-- Section 10 Start  -->
     <?php 
      $db->select('review','id',null,"crs_token='$crs_token'");
      $cmt1 = $db->getResult();
      $cmt1_cnt = count($cmt1);
      if($cmt1_cnt == 0){
      }else{
     ?>
     <div class="crs_review_sec crs_cmm_sec">
        <p class="crs_review_p1">Reviews</p>
            <div class="crs_reviews">

            <?php 
            
                $db->select('review','name,ratings,time,comment',null,"crs_token='$crs_token'");
                $cmt = $db->getResult();
                $cmt_cnt = count($cmt);

                if($cmt_cnt != 0){
                    $k = 0;
                    while($k < $cmt_cnt){
                        $cmt_name = $cmt[$k]['name'];
                        $cmt_ratings = $cmt[$k]['ratings'];
                        $cmt_time = $cmt[$k]['time'];
                        $cmt_comment = $cmt[$k]['comment'];
            ?>
            <div class="crs_review">
                <div class="crs_review_img">
                    <img src="images/reviews/review1.jpg" alt="review">
                </div>
                <div class="crs_review_cmmt">
                    <p class="crs_review_name"><?php echo $cmt_name; ?></p>
                    <span class="crs_review_rt"><span class="crs_review_rat"><?php $i=0; while($i < $cmt_ratings){ echo "<span class='fas fa-star' style='color:#fd4; stroke:#444; stroke-width:20px;'></span> "; $i++; } ?> <span class="crs_review_ratings"><?php echo $cmt_time; ?></span></span></span>
                    <span class="crs_review_msg"><?php echo $cmt_comment; ?></span>
                </div>
            </div>
            <?php
                        $k++;
                    }
                }

            ?>
                
<!-- 
                <div class="crs_review">
                    <div class="crs_review_img">
                        <img src="images/reviews/review1.jpg" alt="review">
                    </div>
                    <div class="crs_review_cmmt">
                        <p class="crs_review_name">Name</p>
                        <span class="crs_review_rt"><span class="crs_review_rat">Ratings <span class="crs_review_ratings">Time</span></span></span>
                        <span class="crs_review_msg">Lorem ipsum dolor, sit amet consectetur adipisicing elit. Aspernatur dolor magni natus eos aliquam, esse magnam a at temporibus pariatur dolorum tempore praesentium eius ratione vel quas commodi consequatur corrupti. Labore optio ut eaque dolores, vero placeat explicabo, eum nam eveniet nulla dolorum animi rerum facere deleniti culpa ipsum necessitatibus?</span>
                    </div>
                </div> -->

            </div>
            <button class="shmore" id="crs_review_shmr">Show More</button>
     </div>
     <?php } ?>
     <!-- Section 10 End  -->

    <!-- Footer Section Start -->
    <?php include_once('inc/footer.php') ?>
    <!-- Footer Section End -->
    <script src="javascript/jquery.js"></script>
    <script src="javascript/all.js"></script>
    <script src="javascript/frontend.js"></script>
</body>
</html>