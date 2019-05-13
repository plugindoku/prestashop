<?php
require_once(dirname(__FILE__).'/../../config/config.inc.php');
require_once(dirname(__FILE__).'/../../init.php');
require_once(dirname(__FILE__).'/dokuonecheckout.php');

//echo 'test';

if (!$_POST){
	header('Location: javascript:history.go(-1)');
	die;
}
$URL = $_POST['CUSTOMERID'];
$PAYMENTCHANNEL=$_POST['PAYMENTCHANNEL'];
if ($PAYMENTCHANNEL=='22'){
	$bank='SINARMAS';
} else {
	$bank ='BNI';
}
$WORDS=$_POST['WORDS'];
$AMOUNT=$_POST['AMOUNT'];
$TRANSIDMERCHANT=$_POST['TRANSIDMERCHANT'];
$SESSIONID=$_POST['SESSIONID'];


$data= array('req_address'=>$_POST['ADDRESS'],
		'req_amount'=>$_POST['AMOUNT'],
		'req_basket'=>$_POST['BASKET'],
		'req_chain_merchant'=>$_POST['CHAINMERCHANT'],
		'req_email'=>$_POST['EMAIL'],
		'req_expiry_time'=>'12466',
		'req_mall_id'=>$_POST['MALLID'],
		'req_mobile_phone'=>$_POST['MOBILEPHONE'],
		'req_name'=>$_POST['ADDRESS'],
		'req_purchase_amount'=>$_POST['AMOUNT'],
		'req_request_date_time'=>$_POST['REQUESTDATETIME'],
		'req_session_id'=>$_POST['SESSIONID'],
		'req_trans_id_merchant'=>$_POST['TRANSIDMERCHANT'],
		'req_words'=>$_POST['WORDS'],
		'req_currency'=>$_POST['CURRENCY'],
		'req_purchase_currency'=>$_POST['PURCHASECURRENCY']
	);

$POSTVARIABLES = $pariabel;


define('POSTURL' , $URL);
define('POSTVARS', $POSTVARIABLES);


  $ch = curl_init(POSTURL);
  curl_setopt($ch, CURLOPT_POST, 1);
  curl_setopt($ch, CURLOPT_POSTFIELDS, 'data='. json_encode($data));
  curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
  curl_setopt($ch, CURLOPT_HEADER, 0);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
  curl_setopt($ch, CURLOPT_TIMEOUT, 18);
  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
  $GETDATARESULT = curl_exec($ch);
  curl_close($ch);

  $GETDATARESULT = json_decode($GETDATARESULT);
if($GETDATARESULT->res_response_code == '0000'){
//    echo 'GENERATE SUCCESS -- ';
	$configarray = parse_ini_file("config_bni_sinarmas_va.ini");
	$bank=$configarray[$bank];
	$paymentcode_ = $GETDATARESULT->res_pay_code;
	$PAYMENTCODE = $bank.$paymentcode_;
	$STATUSCODE = $GETDATARESULT->res_payment_code;
	$myservername = _PS_BASE_URL_.__PS_BASE_URI__;

?>

<!doctype html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>DOKU Payment Page - Redirect</title>
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-status-bar-style" content="black">
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>  
<script type="text/javascript" src="https://pay.doku.com/merchant_data/ocov2/js/doku.analytics.js"></script>
 
<link rel="stylesheet" type="text/css" href="https://pay.doku.com/merchant_data/ocov2/css/default.min.css"/>
<link rel="stylesheet" type="text/css" href="https://pay.doku.com/merchant_data/ocov2/css/style.min.css"/>

</head>

<body class="tempdefault tempcolor tempone" onload="document.formRedirect.submit()">

	<section class="default-width">
		
		<div class="head padd-default">
			<div class="left-head fleft">
			</div>
			
			<div class="clear"></div>
		</div>
		
		<br />
		
		<div class="">
		    
		<div class="loading">
			<div class="spinner">
				<div class="double-bounce1"></div>
				<div class="double-bounce2"></div>
			</div>
			<div class="color-one">
				Please wait.<br />
				Your request is being processed...<br />
				<br />
				<span id="TEXT-CONTINUE">Click button below if the page is not change</span>
			</div>
		</div>
		    
		<form action="<?php echo $myservername;?>index.php?fc=module&module=dokuonecheckout&controller=request&task=redirect" method="POST" id="formRedirect" name="formRedirect">
			<input type="hidden" name="WORDS" value="<?php echo $WORDS;?>">
			<input type="hidden" name="AMOUNT" value="<?php echo $AMOUNT;?>">
			<input type="hidden" name="TRANSIDMERCHANT" value="<?php echo $TRANSIDMERCHANT;?>">
			<input type="hidden" name="STATUSCODE" value="<?php echo $STATUSCODE;?>">
			<input type="hidden" name="PAYMENTCODE" value="<?php echo $PAYMENTCODE;?>">
			<input type="hidden" name="PAYMENTCHANNEL" value="<?php echo $PAYMENTCHANNEL;?>">
			<input type="hidden" name="SESSIONID" value="<?php echo $SESSIONID;?>">

		</form>				
				
		</div>
		
	</section>
	
	<div class="footer">
		<div id="copyright" class="">Copyright DOKU 2018</div>
	</div>
    
</body>
</html>

<?php
}else{
echo $GETDATARESULT;
}
?>

