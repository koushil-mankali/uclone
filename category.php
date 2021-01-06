<?php
require_once("database/dbconn.php");
$db = new Database();

if(isset($_GET['cat_nm'])){
    $search = $_GET['cat_nm'];
    if($db->select('courses','courses.crs_nm,courses.crs_tag_ln,courses.crs_dur,courses.crs_price,courses.crs_org_prc,courses.crs_img,i.iname',"instructor_data as i ON courses.crs_creator = i.iemail","courses.crs_cat='$search'")){
        $em = $db->getResult();
        $cnt = count($em) > 0 ? count($em) : false;
    }
}else{
    if(!isset($_SERVER['HTTP_REFERER'])){
        // redirect them to your desired location
        header('location:./');
        exit;
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

    <!-- Section 1 Start  -->
    <div class="cat_sec1">
        <p class="cat_sec1_ttl" ><span><?php echo $search; ?></span> Courses</p>
        <p class="cat_sec_ttl">Courses to get you started</p>
    </div>
    <!-- Section 1 End -->


    <!-- Section 2 Start -->

    <div class=" cat_sec2">

        <div class="sec_courses">

        <?php 
        
        if($db->select('courses','courses.crs_nm,courses.crs_price,courses.crs_img,courses.crs_token,i.iname',"instructor_data as i ON courses.crs_creator = i.iemail","courses.crs_cat='$search'",null,['0'=>4])){
            $emone = $db->getResult();
            $cntone = count($emone) > 0 ? count($emone) : false;
            $i = 0;
            while($i < $cntone){
                $cname = $emone[$i]['crs_nm'];
                $cprice = $emone[$i]['crs_price'];
                $cimg = $emone[$i]['crs_img'];
                $ctoken = $emone[$i]['crs_token'];
                $ciname = $emone[$i]['iname'];
                $db->select('review','AVG(ratings) as avg',null,"crs_token='$ctoken'");
                $rt1 = $db->getResult();
                $rt1_cnt = count($rt1);
                if($rt1_cnt > 0){
                    $rating =  $rt1['0']['avg'];
                    $rat_round = substr(number_format($rating, 2, '.', ''), 0, -1);
                }
                echo "<div class='sec_course' onclick='location.href=\"course?crs_id=$ctoken\"'>
                            <div class='sec_img'>
                                <img src='images/courses/$cimg' alt='course image' class='sec_crs_img'>
                            </div>
                            <div class='sec_bdy'>
                                <p class='sec_crs_title'>$cname</p>
                                <p class='sec_crs_author'>$ciname</p>
                                <p class='sec_crs_ratings'>$rat_round "; $j = 0; do{ echo "<span class='fas fa-star' style='color:#fd4; stroke:#444; stroke-width:20px;'></span>"; $j++;}while(($j < round($rat_round))); echo "</p>
                                <p class='sec_crs_price'>₹ $cprice <small>RS/-</small></p>
                            </div>
                        </div>";
                $i++;
            }
        }
        
        ?>

            

        </div>

    </div>

    <!-- Section 2 End -->


    <!-- Section 3 Start -->

    <div class="section4">
        <div class="sec4_1">
            <i class="fa fa-play-circle fa_icon"></i>
            <div class="sec4_p">
                <p class="sec4_p1">Find video courses on almost any topic</p>
                <p class="sec4_p2">Learn any topic anywhere you want</p>
            </div>
        </div>
        <div class="sec4_1">
            <i class="fas fa-clock fa_icon"></i>
            <div class="sec4_p" >
                <p class="sec4_p1">Learn Any Where Any Time</p>
                <p class="sec4_p2">Enjoy lifetime access to courses and learn any time</p>
            </div>
        </div>
        <div class="sec4_1">
            <i class="fas fa-chalkboard-teacher fa_icon"></i>
            <div class="sec4_p" >
                <p class="sec4_p1">Learn from industry experts</p>
                <p class="sec4_p2">Select from top instructors around the world</p>
            </div>
        </div>
    </div>


    <!-- Section 3 End -->


    <!-- Section 4 Start -->

    <div class="slideshow-container">
    <p class="cat_sec_ttl">Featured courses</p>
        <?php 
            if($db->select('courses','courses.crs_nm,crs_tag_ln,courses.crs_price,courses.crs_img,courses.crs_token,courses.lst_upt,i.iname',"instructor_data as i ON courses.crs_creator = i.iemail","courses.crs_cat='$search'",null,['0'=>4])){
                $emone = $db->getResult();
                $cntone = count($emone) > 0 ? count($emone) : false;
                $i = 0;
                while($i < $cntone){
                    $cname = $emone[$i]['crs_nm'];
                    $ctag = $emone[$i]['crs_tag_ln'];
                    $cprice = $emone[$i]['crs_price'];
                    $cimg = $emone[$i]['crs_img'];
                    $ctoken = $emone[$i]['crs_token'];
                    $lstupt = $emone[$i]['lst_upt'];
                    $ciname = $emone[$i]['iname'];
                    $db->select('review','AVG(ratings) as avg',null,"crs_token='$ctoken'");
                    $rt1 = $db->getResult();
                    $rt1_cnt = count($rt1);
                    if($rt1_cnt > 0){
                        $rating =  $rt1['0']['avg'];
                        $rat_round = substr(number_format($rating, 2, '.', ''), 0, -1);
                    }
                    echo ' 
                    <div class="mySlides fade" onclick="location.href=\'course?crs_id='.$ctoken.'\'">
                        <div class="cat_sec4_div1">
                            <div class="cat_sec4_img">
                                <img src="images/courses/'.$cimg.'" alt="cat_feature">
                            </div>
                            <div class="cat_sec4_bdy">
                                <p class="cat_sec4_bdy_ttl same">'. $cname .'</p>
                                <p class="cat_sec4_bdy_tag same">'.$ctag.'</p>
                                <p class="cat_sec4_bdy_auth same">'.$ciname.'</p>
                                <p class="cat_sec4_bdy_det same"><span class="cat_sec4_upd">Updated <b>'.$lstupt.'</b></span></p>
                                <p class="cat_sec4_bdy_rat same"><span class="cat_sec4_ratings">'?><?php echo $rat_round ; $j = 0; do{ echo " <span class='fas fa-star' style='color:#fd4; stroke:#444; stroke-width:20px;'></span>"; $j++;}while(($j < round($rat_round)));  echo'</span>&nbsp;&nbsp;<span class="crs_bst_seller">Best Seller</span></p>
                                <p class="cat_sec4_bdy_price">₹'.$cprice.'</p>
                            </div>
                        </div>
                    </div>';
                    
                    $i++;


                }
            }
            ?>
            <a class="prev" onclick="plusSlides(-1)">&#10094;</a>
            <a class="next" onclick="plusSlides(1)">&#10095;</a>

    </div>

    <!-- Section 4 End -->


  



    <!-- Section 7 Start -->

    <div class="cat_sec7">
        <p class="cat_sec_ttl">All Development courses</p>
        <div class="cat_sec7_desc"><i class="fas fa-exclamation-circle"></i> Not sure? All courses have a 30-day money-back guarantee</div>
        <div class="cat_sec7_opt">
            <div class="cat_sec7_filter" id="cat_sec7_filter"><i class="fas fa-filter"></i> Filter</div>
            <ul class="cat_sec7_pop">
                <li>Most Popular <i class="fas fa-angle-down mst_pop"></i></li>
                <ul class="cat_sec7_ul">
                    <li class="cat_sec7_li">Most Popular</li>
                    <li class="cat_sec7_li">Highest Rated</li>
                    <li class="cat_sec7_li">Newest</li>
                </ul>
            </ul>
            <div class="cat_sec7_res_cnt"><span><?php echo isset($cnt) ? $cnt : 0; ?></span> Results</div>
        </div>
        <div class="cat_sec7_bdy">
            <div class="cat_sec7_sidebar" id="cat_sec7_sidebar">
                <div class="cdet">
                    <details class="ccdet">
                    <summary class="csum">Language</summary>
                        <form action="" method="POST">
                            <ul class="cul">
                            <?php
                                    
                                if($db->select('courses','DISTINCT crs_lng',null,"crs_cat = '$search'")){
                                    $res3 = $db->getResult();
                                    $res3_cnt = count($res3);
                                    $k=0;
                                    while($k < $res3_cnt){
                                        $crs_lng = $res3[$k]['crs_lng'];
                                        echo "<li class='cli'><input type='checkbox' name='' id='clii' class='clii'> <label for='clii' class='clilb'>$crs_lng</label></li>";
                                        $k++;
                                    }
                                }

                            ?>
                
                            </ul>
                        </form>
                    </deatils>
                </div>
            </div>
            <div class="cat_sec7_res_bdy" id="cat_sec7_res_bdy">
                <?php
                  
                    function display_content($st,$ed){
                        $start = $st;
                        $end = $ed;
                        global $db,$search;
                        if($db->select('courses','courses.crs_nm,courses.crs_tag_ln,courses.crs_dur,courses.crs_price,courses.crs_org_prc,courses.crs_img,courses.crs_token,i.iname',"instructor_data as i ON courses.crs_creator = i.iemail","courses.crs_cat = '$search'",null,[$start=>$end])){
                            $em = $db->getResult();
                            $cnt = count($em) > 0 ? count($em) : false;
                            if($cnt){
                                $i = 0;
                                while($i < $cnt){
                                    $crs_nm = isset($em[$i]['crs_nm']) ? $em[$i]['crs_nm'] : "No Data";
                                    $crs_tag_ln = isset($em[$i]['crs_tag_ln']) ? $em[$i]['crs_tag_ln'] : "No Data";
                                    $crs_dur = isset($em[$i]['crs_dur']) ? $em[$i]['crs_dur'] : "No Data";
                                    $crs_price = isset($em[$i]['crs_price']) ? $em[$i]['crs_price'] : "No Data";
                                    $crs_org_prc = isset($em[$i]['crs_org_prc']) ? $em[$i]['crs_org_prc'] : "No Data";
                                    $crs_img = isset($em[$i]['crs_img']) ? $em[$i]['crs_img'] : "No Data";
                                    $crs_token = isset($em[$i]['crs_token']) ? $em[$i]['crs_token'] : "No Data";
                                    $iname = isset($em[$i]['iname']) ? $em[$i]['iname'] : "No Data";
        
                                    $db->select('lectures','COUNT(lct_nm) as lct',null,"crs_token = '$crs_token'");
                                    $lct_cnt = $db->getResult();
                                    $lct_num = $lct_cnt['0']['lct'];
        
                                    echo "
                                    <div class='cat_sec7_res' onclick='location.href=\"course?crs_id=$crs_token\"'>
                                        <div class='cat_sec7_img'>
                                            <img src='images/courses/$crs_img' alt='course'>
                                        </div>
                                        <div class='cat_sec7_crs_det'>
                                            <div class='cat_sec7_crs_ttl'>$crs_nm</div>
                                            <div class='cat_sec7_crs_tag'>$crs_tag_ln</div>
                                            <div class='cat_sec7_crs_aut'>$iname</div>
                                            <div class='cat_sec7_crs_rat'>Ratings</div>
                                            <div class='cat_sec7_crs_data'><span>$crs_dur duration</span><span>$lct_num lectures</span></div>
                                            <div class='cat-sec7_crs_price'>
                                                <span class='cat_sec7_crs_pr'>₹ $crs_price</span>
                                                <span class='cat_sec7_crs_st_pr'>₹ $crs_org_prc</span>
                                            </div>
                                        </div>
                                    </div>";
                                    $i++;
                                }
                            }else{
                                $err = "No Data";
                            }
                        }
                    }
                    
                    require_once("pagination.php");
                    
                
                ?>

            </div>
        </div>
    </div>        


    <!-- Section 7 End -->


    <!-- Section 8 Start -->
    <?php
        pagination();
    ?>
    <!-- Section 8 End -->


    <!-- Footer Section Start -->
    <?php include_once('inc/footer.php') ?>
    <!-- Footer Section End -->
    <script src="javascript/jquery.js"></script>
    <script src="javascript/all.js"></script>
    <script src="javascript/frontend.js"></script>
</body>
</html>