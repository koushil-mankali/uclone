<?php
session_start();
require_once("../../database/dbconn.php");
$db = new Database();

header("Pragma: no-cache");
header("Cache-Control: no-cache");
header("Expires: 0");

// following files need to be included
require_once("./lib/config_paytm.php");
require_once("./lib/encdec_paytm.php");

$paytmChecksum = "";
$paramList = array();
$isValidChecksum = "FALSE";

$paramList = $_POST;

$paytmChecksum = isset($_POST["CHECKSUMHASH"]) ? $_POST["CHECKSUMHASH"] : ""; //Sent by Paytm pg



//Verify all parameters received from Paytm pg to your application. Like MID received from paytm pg is same as your application�s MID, TXN_AMOUNT and ORDER_ID are same as what was sent by you to Paytm PG for initiating transaction etc.
$isValidChecksum = verifychecksum_e($paramList, PAYTM_MERCHANT_KEY, $paytmChecksum); //will return TRUE or FALSE string.


if($isValidChecksum == "TRUE") {

	if ($_POST["STATUS"] == "TXN_SUCCESS") {
		echo "<b>Transaction status is success</b>" . "<br/>";
		if(isset($_POST['ORDERID']) && isset($_POST['STATUS'])){
			$or_id = $_POST['ORDERID'];
			$txn_id = $_POST['TXNID'];
			$txn_amt = $_POST['TXNAMOUNT'];
			$py_md = $_POST['PAYMENTMODE'];
			$txn_dt = $_POST['TXNDATE'];
			$or_st = $_POST['STATUS'];
			$or_msg = $_POST['RESPMSG'];
			$or_gtw = $_POST['GATEWAYNAME'];
			$or_btxn = $_POST['BANKTXNID'];
			$or_bnm = $_POST['BANKNAME'];
			$stu_email = $_SESSION['uemail'];
			$crs_token = isset($_SESSION['CRS_TOKEN']) ? $_SESSION['CRS_TOKEN'] : "";
			$crs_creator = isset($_SESSION['CRS_CREATOR']) ? $_SESSION['CRS_CREATOR'] : "";
			

			if(isset($_SESSION['CART']) && $_SESSION['CART'] == true){
				if($db->select('cart','cart_crs_token,crs_creator',null,"uemail='$stu_email'")){
					$res = $db->getResult();
					$cnt = count($res);
					$i=0;
					while($i<$cnt){
						$crs_token2 = $res[$i]['cart_crs_token'];
						$crs_creator2 = $res[$i]['crs_creator'];
						
						if($db->insert('course_order',['or_id'=>$or_id,'txn_id'=>$txn_id,'txn_amt'=>$txn_amt,'py_md'=>$py_md,'txn_dt'=>$txn_dt,'or_st'=>$or_st,'or_msg'=>$or_msg,'or_gtw'=>$or_gtw,'or_btxn'=>$or_btxn,'or_bnm'=>$or_bnm,'stu_email'=>$stu_email,'crs_token'=>$crs_token2,'crs_creator'=>$crs_creator2])){
							$db->delete('cart',"cart_crs_token='$crs_token2'");
							$db->insert('user_courses',['ucmail'=>$stu_email,'courses_en'=>$crs_token2,'payment_id'=>$or_id]);
							echo "Redirecting to My Profile";
							echo "<script> setTimeout(()=>{
								window.location.href='../../student/';
							},1000);</script>";
						}
						$i++;
					}
				}
			}else{
				if($db->insert('course_order',['or_id'=>$or_id,'txn_id'=>$txn_id,'txn_amt'=>$txn_amt,'py_md'=>$py_md,'txn_dt'=>$txn_dt,'or_st'=>$or_st,'or_msg'=>$or_msg,'or_gtw'=>$or_gtw,'or_btxn'=>$or_btxn,'or_bnm'=>$or_bnm,'stu_email'=>$stu_email,'crs_token'=>$crs_token,'crs_creator'=>$crs_creator])){
					$db->insert('user_courses',['ucmail'=>$stu_email,'courses_en'=>$crs_token,'payment_id'=>$or_id]);
					echo "Redirecting to My Profile";
					echo "<script> setTimeout(()=>{
						window.location.href='../../student/';
					},1000);</script>";
				}
			}
		}
	}
	else {
		echo "<b>Transaction status is failure</b>" . "<br/>";
	}

}
else {
	echo "<b>Checksum mismatched.</b>";
	//Process transaction as suspicious.
}

?>