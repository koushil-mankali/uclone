<?php
require_once("database/dbconn.php");
$db = new Database();

if(isset($_GET['search'])){
    $search = $_GET['search'];
    if($db->select('courses','courses.crs_nm,courses.crs_tag_ln,courses.crs_dur,courses.crs_price,courses.crs_org_prc,courses.crs_img,i.iname',"instructor_data as i ON courses.crs_creator = i.iemail","courses.crs_nm COLLATE UTF8_GENERAL_CI LIKE '%$search%'",null,['0'=>20])){
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

    
    <!-- Section 7 Start -->

    <div class="cat_sec7">
        <br />
        <br />
        <p class="cat_sec_ttl"><?php echo "$cnt results for \"$search\"";?></p>
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
                    <summary class="csum">Category</summary>
                        <form action="" method="POST">
                            <ul class="cul">
                                <?php
                                    
                                    if($db->select('category','cat_name')){
                                        $res1 = $db->getResult();
                                        $res1_cnt = count($res1);
                                        $j = 0;
                                        while($j < $res1_cnt){
                                            $cat_nm = $res1[$j]['cat_name'];
                                            if($db->select('courses','crs_cat',null,"crs_nm COLLATE UTF8_GENERAL_CI LIKE '%$search%' AND crs_cat = '$cat_nm'")){
                                                $res2 = $db->getResult();
                                                $res2_cnt = count($res2);
                                                echo "<li class='cli'><input type='checkbox' name='' id='clii' class='clii'> <label for='clii' class='clilb'>$cat_nm &nbsp; ($res2_cnt)</label></li>";
                                            }
                                            $j++;
                                        }
                                    }

                                ?>
                            </ul>
                        </form>
                    </deatils>
                </div>
                <div class="cdet">
                    <details class="ccdet">
                    <summary class="csum">Language</summary>
                        <form action="" method="POST">
                            <ul class="cul">
                            <?php
                                    
                                if($db->select('courses','DISTINCT crs_lng',null,"crs_nm COLLATE UTF8_GENERAL_CI LIKE '%$search%'")){
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
                
                if($db->select('courses','courses.crs_nm,courses.crs_tag_ln,courses.crs_dur,courses.crs_price,courses.crs_org_prc,courses.crs_img,i.iname,courses.crs_token',"instructor_data as i ON courses.crs_creator = i.iemail","courses.crs_nm COLLATE UTF8_GENERAL_CI LIKE '%$search%'",null,['0'=>20])){
                    $em = $db->getResult();
                    $cnt = count($em) > 0 ? count($em) : false;
                    // echo $cnt;
                    // print_r($cnt);
                    // die();
                    if($cnt){
                        $i = 0;
                        while($i < $cnt){
                            $crs_nm = isset($em[$i]['crs_nm']) ? $em[$i]['crs_nm'] : "No Data";
                            $crs_tag_ln = isset($em[$i]['crs_tag_ln']) ? $em[$i]['crs_tag_ln'] : "No Data";
                            $crs_dur = isset($em[$i]['crs_dur']) ? $em[$i]['crs_dur'] : "No Data";
                            $crs_price = isset($em[$i]['crs_price']) ? $em[$i]['crs_price'] : "No Data";
                            $crs_org_prc = isset($em[$i]['crs_org_prc']) ? $em[$i]['crs_org_prc'] : "No Data";
                            $crs_img = isset($em[$i]['crs_img']) ? $em[$i]['crs_img'] : "No Data";
                            $iname = isset($em[$i]['iname']) ? $em[$i]['iname'] : "No Data";
                            $crs_token = isset($em[$i]['crs_token']) ? $em[$i]['crs_token'] : "No Data";
                            if($db->select('lectures','COUNT(id) as id',null,"crs_token = '$crs_token'")){
                                $resd = $db->getResult();
                                if($resd[0]['id'] > 0){
                                    $lct = $resd[0]['id'];
                                }else{
                                    $lct = "No Data";
                                }
                            }else{
                                $lct = "No Data";
                            }
                            $db->select('review','AVG(ratings) as avg',null,"crs_token='$crs_token'");
                            $rt1 = $db->getResult();
                            $rt1_cnt = count($rt1);
                            if($rt1_cnt > 0){
                                $rating =  $rt1['0']['avg'];
                                $rat_round = substr(number_format($rating, 2, '.', ''), 0, -1);
                            }
                            echo "
                            <div class='cat_sec7_res' onclick='location.href=\"course?crs_id=$crs_token\"'>
                                <div class='cat_sec7_img'>
                                    <img src='images/courses/$crs_img' alt='course'>
                                </div>
                                <div class='cat_sec7_crs_det'>
                                    <div class='cat_sec7_crs_ttl'>$crs_nm</div>
                                    <div class='cat_sec7_crs_tag'>$crs_tag_ln</div>
                                    <div class='cat_sec7_crs_aut'>$iname</div>
                                    <div class='cat_sec7_crs_rat'>$rat_round "; $j = 0; do{ echo "<span class='fas fa-star' style='color:#fd4; stroke:#444; stroke-width:20px;'></span>"; $j++;}while(($j < round($rat_round))); echo "</div>
                                    <div class='cat_sec7_crs_data'><span>$crs_dur</span><span>$lct</span></div>
                                    <div class='cat-sec7_crs_price'>
                                        <span class='cat_sec7_crs_pr'>$crs_price</span>
                                        <span class='cat_sec7_crs_st_pr'>$crs_org_prc</span>
                                    </div>
                                </div>
                            </div>";
                            $i++;
                        }  
                    }else{
                        $err = "No Data";
                    }
                }
                
                
                ?>

            </div>
        </div>
    </div>        


    <!-- Section 7 End -->


    <!-- Section 8 Start -->







    <!-- Footer Section Start -->
    <?php include_once('inc/footer.php') ?>
    <!-- Footer Section End -->
    <script src="javascript/jquery.js"></script>
    <script src="javascript/all.js"></script>
    <script src="javascript/frontend.js"></script>
</body>
</html>