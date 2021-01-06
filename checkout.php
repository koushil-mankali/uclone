<?php
if(!isset($_SERVER['HTTP_REFERER'])){
    // redirect them to your desired location
    header('location:err404.php');
    exit;
}
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
session_regenerate_id (true);
if(!isset($_SESSION['isLogin'])){
    header('location:./');
}else{
    header("Pragma: no-cache");
    header("Cache-Control: no-cache");
    header("Expires: 0");

    $usemail = $_SESSION['uemail'];

    require_once("database/dbconn.php");
    $db = new Database();
    if(isset($_GET['crs_id'])){

        $crs_token = htmlentities($_GET['crs_id']);
    
        $db->select('courses','crs_creator,crs_nm,crs_tag_ln,crs_lng,crs_cc,stu_lrn,crs_req,crs_desc,crs_dur,crs_art,crs_res,crs_price,crs_org_prc,crs_img,lst_upt',null,"crs_token='$crs_token'");
    
        $res = $db->getResult();
        $crs_count = count($res);
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
    }else{
        header('location:./');
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
    
        <div class="check_out">
        <div class="login_modal">
            <div class="login_ttl">Check Out</div>
            <form action="./payments/pay@paytm/pgRedirect" method="POST">
                <div class="lgemail">
                    <label for="ORDER_ID" class="login_lbl">Order Id</label>
                    <span class="sg_email"><i class="fas fa-envelope fa-2x"></i></span>
                    <input type="text" readonly id="ORDER_ID" maxlength="20" size="20" name="ORDER_ID" autocomplete="off" class="lg_inpt" value="<?php echo  "ORDS" . rand(10000,99999999)?>">
                </div>
                <div class="lgemail">
                    <label for="CUST_ID" class="login_lbl">Email</label>
                    <span class="sg_email"><i class="fas fa-envelope fa-2x"></i></span>
                    <input type="email" readonly id="CUST_ID" maxlength="12" size="12" name="CUST_ID" autocomplete="off" class="lg_inpt" value="<?php if(isset($usemail)){ echo $usemail;} ?>">
                </div>
                <div class="lgpassowrd">
                    <label for="txn_amount" class="login_lbl">Amount</label>
                    <span class="sg_pass"><i class="fas fa-lock fa-2x"></i></span>
                    <input type="text" readonly id="txn_amount" name="TXN_AMOUNT" class="lg_inpt" value="<?php if(isset($crs_prcl)){ echo $crs_prcl;} ?>">
                </div>
                <input type="hidden" id="CHANNEL_ID" name="CHANNEL_ID" autocomplete="off" value="WEB">
                <input type="hidden" id="INDUSTRY_TYPE_ID" name="INDUSTRY_TYPE_ID" autocomplete="off" value="Retail">
            
                <?php if(isset($err)){ ?>
                <div class="err">
                    <span><?php echo $err; ?></span>
                </div>
                <?php } ?>
               <?php
               ?>
               <?php               
                $_SESSION['CRS_TOKEN'] = $crs_token;
                $_SESSION['CRS_CREATOR'] = $crs_creator;
               ?>
                <div class='lg_btn'>
                    <input type="submit" value="Checkout" id="llogin" name="login">
                    <a href="course?crs_id=<?php if(isset($crs_token)){ echo $crs_token;} ?>" class="cancel_btn" id="cancel_btnlg">Cancel</a>
                </div>
            </form>
        </div>
    </div>

    <!-- Footer Section Start -->
    <?php include_once('inc/footer.php') ?>
    <!-- Footer Section End -->
    <script src="javascript/jquery.js"></script>
    <script src="javascript/all.js"></script>
    <script src="javascript/frontend.js"></script>
</body>
</html>
