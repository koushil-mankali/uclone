<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if(!isset($_SESSION['isLogin'])){
    header('location:login');
}
header("Pragma: no-cache");
header("Cache-Control: no-cache");
header("Expires: 0");

$usemail = isset($_SESSION['uemail']) ? $_SESSION['uemail'] : "";

$_SESSION['uemail'] = $usemail;

require_once("database/dbconn.php");
$db = new Database();

if($db->select('cart','cart_crs_token',null,"uemail = '$usemail'")){
    $em = $db->getResult();
    $crs_token = isset($em[0]['cart_crs_token']) ? $em[0]['cart_crs_token'] : null;
    $cnt = count($em) > 0 ? count($em) : false;
    if($db->select('cart','c.crs_price,c.crs_org_prc',"courses as c ON cart.cart_crs_token = c.crs_token","uemail='$usemail'")){
        $pc = $db->getResult();
        $cnt_p = count($pc);
        $j=0;
        $total = 0;
        $total_org = 0;
        while($j<$cnt_p){
            $total += $pc[$j]['crs_price'];
            $total_org += $pc[$j]['crs_org_prc'];
            $j++;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="GENERATOR" content="Evrsoft First Page">
    <title>Checkout</title>
    <link rel="stylesheet" href="css/all.css">
    <link rel="stylesheet" href="css/payments.css">
    <link rel="stylesheet" href="css/custom.css">
</head>
<body>
    <!-- Header Section Start -->
    <?php include_once('inc/header.php') ?>
    <!-- Header Section End -->
        <?php
            if($cnt == 0){
                echo
                "<div class='no_cart'>
                <i class='nct_i fas fa-shopping-cart'></i>
                <div class='nc_t'>Your cart is empty. Keep shopping to find a course!</div>
                <div class='nc_btn' onclick=\"location.href='./'\">Keep Shopping</div>
                </div>";
            }else {
        ?>

            <div class="check_out2">
            <!-- <div class="login_ttl">Check Out</div> -->
                <div class="ct_p1">
                    <div class="ct_p1_t"><?php if(isset($cnt)){echo $cnt;}else{ echo 0;}?> Course in Cart</div>
                    <?php
                        if($db->select('cart','cart_crs_token',null,"uemail = '$usemail'")){
                            $em2 = $db->getResult();
                            $cnt2 = count($em2);
                            $i = 0;
                            while($i < $cnt2){
                                $crs_token2 = $em2[$i]['cart_crs_token'];
                                $db->select('courses','crs_nm,crs_price,crs_org_prc,crs_img',null,"crs_token='$crs_token2'");
                                $res = $db->getResult();
                                $crs_count = count($res);
                                $crs_nme = $res[0]['crs_nm'];
                                $crs_prcl = $res[0]['crs_price'];
                                $crs_org_prcl = $res[0]['crs_org_prc'];
                                $crs_img = $res[0]['crs_img'];
                                echo
                                "<div class='ctt1'>
                                    <div class='ct1'>
                                        <img src='images/courses/$crs_img' alt='' class='ct1img'>
                                    </div>
                                    <div class='ct2'>$crs_nme</div>
                                    <div id='ct3' class='ct3' crs='$crs_token2'>Remove</div>
                                    <div class='ct4'>
                                        <div class='ct4_1'>₹$crs_prcl</div>
                                        <div class='ct4_2'>₹$crs_org_prcl</div>
                                    </div>
                                </div>";
                                $i++;
                            }
                        }
                    ?>
                </div>
                <div class="ct_p2">
                    <div class="ct_p1_t">Total:</div>
                    <?php 
                    if(isset($_POST['apply'])){
                        $cpn = isset($_POST['coupon']) ? $_POST['coupon'] : null;
                        $cpp=htmlentities(strtoupper($cpn));
                        if($db->select('coupons','coupon,off,exp_date',null,"coupon = '$cpp'")){
                            $c_p = $db->getResult();
                            $cnt_p = count($c_p);
                            if($cnt_p == 1){
                                if(isset($c_p)){
                                    $off = $c_p[0]['off'];
                                    $exp_date = $c_p[0]['exp_date'];
                                }
                            }else{
                                $err = "Invalid Coupon Code";
                            }
                        }else{
                            $err = "Invalid Coupon Code";
                        }
                    }
                    if(isset($off) && isset($exp_date)){
                        global $cpp;
                        global $exp_date;
                        $date =date("Y-m-d"); 
                        $dt1 = new DateTime($date);
                        $dt2 = new DateTime($exp_date);
                        $dt_df = date_diff($dt1,$dt2); 
                        $diff = $dt_df->format("%R%a");
                        if($diff > 0){ 
                            if(isset($total)){ 
                                global $off;
                                $calc = $off / 100;
                                $discount = $calc * $total;
                                $total_disc =$total - $discount;

                                if(isset($total_org)){
                                    $prct = round($total_disc / ($total_org / 100),2);
                                    $prct = 100 - $prct . "%"; 
                                }
                            } 
                        } 
                    }
                    if(isset($total_org)){
                        $prct2 = round($total / ($total_org / 100),2);
                        $prct2 = 100 - $prct2 . "%"; 
                    }
                    ?>
                    <div class="prc">₹<?php if(isset($total_disc)){global $total_disc;  echo $total_disc;}else{ if(isset($total)){ echo $total;}} ?></div>
                    
                    <div><span class="org_prc">₹<?php if(isset($total_org)){ echo $total_org;} ?></span>&nbsp;&nbsp;<span class="prc_off"><?php if(isset($prct)){ echo $prct; }else{ if(isset($prct2))echo $prct2;} ?> Off</span></div>
                    <form action="" method="POST" class="cpn_f">
                        <input type="text" name="coupon" id="coupon" class="coupon" placeholder="Enter Coupon">
                        <input type="submit" class="apply_btn" id="apply_btn" name="apply" value="Apply">
                    </form>
                    <?php
                    
                    if(isset($cpp)){
                        global $cpp;
                        global $exp_date;
                        $date =date("Y-m-d"); 
                        $dt1 = new DateTime($date);
                        $dt2 = new DateTime($exp_date);
                        $dt_df = date_diff($dt1,$dt2); 
                        $diff = $dt_df->format("%R%a");
                        if($diff > 0){
                             ?> <div class='cpn_appld'><span class='cpn_cl' id='clear'>X</span>&nbsp;&nbsp;<span class='cpn'><?php echo $cpp; ?><span class='cpn_t'> is applied</span></span></div> <?php
                        }else{
                            $err2 = "Coupon Expired";
                        }
                        if(isset($err)){
                            echo "<div class='err2'>
                                <span>$err</span>
                            </div>";
                        }else if(isset($err2)){
                            echo "<div class='err2'>
                            <span>$err2</span>
                            </div>";
                        }
                    }
                    ?>
                    <form action="./payments/pay@paytm/pgRedirect" method="POST">
                    
                        <input type="hidden" readonly id="txn_amount" name="TXN_AMOUNT" class="lg_inpt" value="<?php if(isset($total_disc)){global $total_disc;  echo $total_disc;}else{ if(isset($total)){ echo $total;} } ?>">
                        <input type="hidden" readonly id="CUST_ID" maxlength="12" size="12" name="CUST_ID" autocomplete="off" class="lg_inpt" value="<?php if(isset($usemail)){ echo $usemail;} ?>">
                        <input type="hidden" readonly id="ORDER_ID" maxlength="20" size="20" name="ORDER_ID" autocomplete="off" class="lg_inpt" value="<?php echo  "ORDS" . rand(10000,99999999)?>">
                        <input type="hidden" id="CHANNEL_ID" name="CHANNEL_ID" autocomplete="off" value="WEB">
                        <input type="hidden" id="INDUSTRY_TYPE_ID" name="INDUSTRY_TYPE_ID" autocomplete="off" value="Retail">
                    
                        <div>
                            <input type="submit" value="Checkout" class="checkout" id="checkout" name="checkout">
                        </div>
                        
                    <?php $_SESSION['CART'] = true; ?>
                    </form>
                </div>
            </div>         

        <?php } ?>       

    <!-- Footer Section Start -->
    <?php include_once('inc/footer.php') ?>
    <!-- Footer Section End -->
    <script src="javascript/jquery.js"></script>
    <script src="javascript/all.js"></script>
    <script src="javascript/frontend.js"></script>
    <script>
        document.getElementById('ct3').addEventListener('click',()=>{
        var val = document.getElementById('ct3').getAttribute('crs');
        var xhr =new XMLHttpRequest();
        xhr.open('POST','cart_delete',true);
        xhr.onload = ()=>{
        
        };
        const mydata = {token : val};
        const data = JSON.stringify(mydata);
        xhr.send(data);
        location.reload();
        });

        document.getElementById('clear').addEventListener('click',()=>{
            location.href="./cart";
        });
    </script>
</body>
</html>
