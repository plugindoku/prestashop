<?php

require_once(dirname(__FILE__).'/../../config/config.inc.php');
require_once(dirname(__FILE__).'/../../init.php');
require_once(dirname(__FILE__).'/dokuonecheckout.php');

$dokuonecheckout = new DOKUOnecheckout();

$task = $_GET['task'];
								
switch ($task)
{
	 case "identify":
			
	 $config = $dokuonecheckout->getServerConfig();
	 $use_identify = $config['USE_IDENTIFY'];
					 
	 if ( intval($use_identify) == 1 )
	 {						
			 if ( empty($_POST) )
			 {
					 echo "Stop : Access Not Valid";
					 die;
			 }
											
			 if (substr($dokuonecheckout->getipaddress(),0,strlen($dokuonecheckout->ip_range)) !== $dokuonecheckout->ip_range)
			 {
					 echo "Stop : IP Not Allowed : ".$dokuonecheckout->getipaddress();
			 }
			 else
			 {	    
					 $trx = array();														

					 $trx['amount']           = $_POST['AMOUNT'];
					 $trx['transidmerchant']  = $_POST['TRANSIDMERCHANT']; 
				   $trx['payment_code']      = $_POST['PAYMENTCODE'];
					 $trx['payment_channel']  = $_POST['PAYMENTCHANNEL'];
					 $trx['session_id']       = $_POST['SESSIONID'];
					 $trx['process_datetime'] = date("Y-m-d H:i:s");
					 $trx['process_type']     = 'IDENTIFY';
					 $trx['ip_address']       = $dokuonecheckout->getipaddress();
					 $trx['message']          = "Identify process message come from DOKU";
					 
					 $order_state = $config['DOKU_AWAITING_PAYMENT'];
					 $dokuonecheckout->validateOrder($trx['transidmerchant'], $order_state, $trx['amount'], $dokuonecheckout->displayName, $trx['transidmerchant']);

					 if ( in_array($trx['payment_channel'], $dokuonecheckout->va_channel) )
					 {
							 switch ( $trx['payment_channel'] )
							 {
									case "05":
										 $va_channel = "Permata Virtual Account";
									break;
							 
									case "14":
									case "35";
										 $va_channel = "ALFA Group Virtual Account";
									break;
							 
									case "29":
										 $va_channel = "BCA Virtual Account";
									break;

									case "31":
										 $va_channel = "Indomaret Virtual Account";
									break;

									case "41":
										 $va_channel = "Mandiri Virtual Account";
									break;
							 
									default:
										 $va_channel = "Virtual Account";
									break;							 
							 }
						
							 $email_data = array( '{va_channel}' => $va_channel,
																	  '{amount}' => $trx['amount'],
																	  '{payment_code}' => $trx['paymentcode']
																  );
						
							 $order_id = $dokuonecheckout->get_order_id($trx['transidmerchant']);
							 $status_no = $config['DOKU_PAYMENT_STATUS_PENDING_EMAIL'];
							 $dokuonecheckout->set_order_status($order_id, $status_no, $email_data);
					 }	else
					    {
					        $order_id = $dokuonecheckout->get_order_id($trx['transidmerchant']);
							 $status_no = $config['DOKU_PAYMENT_STATUS_PENDING'];
							 $dokuonecheckout->set_order_status($order_id, $status_no);
					    }				 
					 
					 # Insert transaction identify to table onecheckout
					 $dokuonecheckout->add_dokuonecheckout($trx);			
					 echo "Continue";
			 }
	 }
	 else
	 {
					 echo "Stop : Access Not Valid";
					 die;			
	 }
	 
	 break;

	 case "notify":
			
	 if ( empty($_POST) )
	 {
			echo "Stop : Access Not Valid";
			die;
	 }
										
	 if (substr($dokuonecheckout->getipaddress(),0,strlen($dokuonecheckout->ip_range)) !== $dokuonecheckout->ip_range)
	 {
			 echo "Stop : IP Not Allowed : ".$dokuonecheckout->getipaddress();
	 }
	 else
	 {
			 $trx = array();
			 
			 $trx['words']                     = $_POST['WORDS'];
			 $trx['transidmerchant']           = $_POST['TRANSIDMERCHANT'];
			 $trx['result_msg']                = $_POST['RESULTMSG'];            
			 $trx['verify_status']             = $_POST['VERIFYSTATUS'];        
			 
			 $config = $dokuonecheckout->getServerConfig();
			 
			 $order_id = $dokuonecheckout->get_order_id($trx['transidmerchant']);
						if (!$order_id){
			 			
			 			$order_state = $config['DOKU_AWAITING_PAYMENT'];
			 			$trx['amount']                = $_POST['AMOUNT'];
						$dokuonecheckout->validateOrder($trx['transidmerchant'], $order_state, $trx['amount'], $dokuonecheckout->displayName, $trx['transidmerchant']);
						$order_id = $dokuonecheckout->get_order_id($trx['transidmerchant']);
			 			}
			 $order = new Order($order_id);
			 $trx_amount = number_format($order->getOrdersTotalPaid(), 2, '.', '');

			 $words_components = trim($trx_amount).
													 trim($config['MALL_ID']).
													 trim($config['SHARED_KEY']).
													 trim($trx['transidmerchant']).
													 trim($trx['result_msg']).
													 trim($trx['verify_status']);
			 			 
			 $words = sha1($words_components);
			 
			 if ( $trx['words']==$words )
			 {
				   $trx['raw_post_data']         = file_get_contents("php://input");				 
					 $trx['ip_address']            = $dokuonecheckout->getipaddress();
					 $trx['amount']                = $_POST['AMOUNT'];
					 $trx['response_code']         = $_POST['RESPONSECODE'];
					 $trx['approval_code']         = $_POST['APPROVALCODE'];
					 $trx['payment_channel']       = $_POST['PAYMENTCHANNEL'];
					 $trx['payment_code']          = $_POST['PAYMENTCODE'];
					 $trx['session_id']            = $_POST['SESSIONID'];
					 $trx['bank_issuer']           = $_POST['BANK'];
					 $trx['creditcard']            = $_POST['MCN'];                   
					 $trx['doku_payment_datetime'] = $_POST['PAYMENTDATETIME'];
					 $trx['process_datetime']      = date("Y-m-d H:i:s");
					 $trx['verify_id']             = $_POST['VERIFYID'];
					 $trx['verify_score']          = (int) $_POST['VERIFYSCORE'];
					 $trx['notify_type']           = $_POST['STATUSTYPE'];
					 $trx['raw_post_data']				= http_build_query($_POST,'','&');

					 switch ( $trx['notify_type'] )
					 {
							 case "P":
							 $trx['process_type'] = 'NOTIFY';
							 break;
					 
							 case "V":
							 $trx['process_type'] = 'REVERSAL';
							 break;
					 }
					 
					 $result = $dokuonecheckout->checkTrx($trx);

					 if ( $result < 1 )
					 {
							 echo "Stop : Transaction Not Found";
							 die;            
					 }
					 else
					 {							 
							 $use_edu  = $config['USE_EDU'];
							 $order_id = $dokuonecheckout->get_order_id($trx['transidmerchant']);
							 
							 switch (TRUE)
							 {
									 case ( $trx['result_msg']=="SUCCESS" && $trx['notify_type']=="P" && intval($use_edu) == 1 && in_array($trx['payment_channel'], $dokuonecheckout->edu_channel) ):
									 $trx['message'] = "Notify process message come from DOKU. Success but using EDU : pending";
									 $status         = "on-hold";
									 $status_no      = $config['DOKU_WAIT_FOR_VERIFICATION'];
									 break;
									 
									 case ( $trx['result_msg']=="SUCCESS" && $trx['notify_type']=="P" ):
									 $trx['message'] = "Notify process message come from DOKU. Success : completed";
									 $status         = "completed";
									 $status_no      = 2;
									 $dokuonecheckout->emptybag();
									 break;
									 
									 case ( $trx['result_msg']=="FAILED" && $trx['notify_type']=="P" ):
									 $trx['message'] = "Notify process message come from DOKU. Transaction failed : canceled";
									 $status         = "failed";
									 $status_no      = $config['DOKU_PAYMENT_FAILED'];
									 break;
									 
									 case ( $trx['notify_type']=="V" ):
									 $trx['message'] = "Notify process message come from DOKU. Void by EDU : canceled";
									 $status         = "failed";
									 $status_no      = $config['DOKU_PAYMENT_FAILED'];
									 break; 
									 
									 default:
									 $trx['message'] = "Notify process message come from DOKU, use default rule : canceled";
									 $status         = "failed";
									 $status_no      = $config['DOKU_PAYMENT_FAILED'];
									 break;
							 }
	 
							 $dokuonecheckout->set_order_status($order_id, $status_no);
	 
							 # Insert transaction notify to table onecheckout
							 $dokuonecheckout->add_dokuonecheckout($trx);
							 
							 echo "Continue";
					 }
			 }
			 else
			 {
					 echo "Stop : Request Not Valid";
					 
					 $trx['message']       = "WORDS not match";
					 $trx['raw_post_data'] = "WORDS component: ".$words_components;
					 
					 $dokuonecheckout->add_dokuonecheckout($trx);
					 die;
			 }
	 }
	 
	 break;

	 case "review":
			
	 if ( empty($_POST) )
	 {
			echo "Stop : Access Not Valid";
			die;
	 }
										
	 if (substr($dokuonecheckout->getipaddress(),0,strlen($dokuonecheckout->ip_range)) !== $dokuonecheckout->ip_range)
	 {
			 echo "Stop : IP Not Allowed : ".$dokuonecheckout->getipaddress();
	 }
	 else
	 {
			 $config = $dokuonecheckout->getServerConfig();
			 
			 $use_edu = $config['USE_EDU'];
			 if ( empty($use_edu) )
			 {
					 echo "Stop : Access Not Authenticate";
					 die;
			 }								
			 
			 $trx = array();
			 
			 $trx['words']                     = $_POST['WORDS'];
			 $trx['transidmerchant']           = $_POST['TRANSIDMERCHANT'];
			 $trx['result_msg']                = $_POST['RESULTMSG'];            
			 $trx['verify_status']             = $_POST['VERIFYSTATUS'];        																
			 
			 $order_id = $dokuonecheckout->get_order_id($trx['transidmerchant']);
			 $order = new Order($order_id);
			 $trx_amount = number_format($order->getOrdersTotalPaid(), 2, '.', '');

			 $words_components = trim($trx_amount).
													 trim($config['MALL_ID']).
													 trim($config['SHARED_KEY']).
													 trim($trx['transidmerchant']).
													 trim($trx['result_msg']).
													 trim($trx['verify_status']);
			 
			 $words = sha1($words_components);
			 
			 if ( $trx['words']==$words )
			 {            
					 $trx['ip_address']            = $dokuonecheckout->getipaddress();
					 $trx['response_code']         = $_POST['RESPONSECODE'];
					 $trx['approval_code']         = $_POST['APPROVALCODE'];
					 $trx['payment_channel']       = $_POST['PAYMENTCHANNEL'];
					 $trx['payment_code']          = $_POST['PAYMENTCODE'];
					 $trx['session_id']            = $_POST['SESSIONID'];
					 $trx['bank_issuer']           = $_POST['BANK'];
					 $trx['creditcard']            = $_POST['MCN'];                   
					 $trx['doku_payment_datetime'] = $_POST['PAYMENTDATETIME'];
					 $trx['process_datetime']      = date("Y-m-d H:i:s");
					 $trx['verify_id']             = $_POST['VERIFYID'];
					 $trx['verify_score']          = (int) $_POST['VERIFYSCORE'];
					 $trx['notify_type']           = $_POST['STATUSTYPE'];
					 $trx['process_type'] 					= 'REVIEW';
					 
					 $result = $dokuonecheckout->checkTrx($trx);

					 if ( $result < 1 )
					 {
							 echo "Stop : Transaction Not Found";
							 die;            
					 }
					 else
					 {
							 $order_id = $dokuonecheckout->get_order_id($trx['transidmerchant']);
							 
							 switch (TRUE)
							 {
									 case ( $trx['verify_status']=="APPROVE" ):
									 $trx['message'] = "EDU Review process message come from DOKU. DOKU Payment and Verification Success : ".$trx['verify_status'];  
									 $status         = "completed";
									 $status_no      = 2;
									 $dokuonecheckout->emptybag();
									 break;

									 case ( $trx['verify_status']=="REJECT" || $trx['verify_status']=="HIGHRISK" || $trx['verify_status']=="NA" ):
									 $trx['message'] = "EDU Review process message come from DOKU. DOKU Verification result is bad : ".$trx['verify_status'];  
									 $status         = "failed";
									 $status_no      = $config['DOKU_PAYMENT_FAILED'];
									 break;

									 default:
									 $trx['message'] = "EDU Review process message come from DOKU. DOKU Verification result is unrecognized : ". $trx['verify_status'];  
									 $status         = "failed";
									 $status_no      = $config['DOKU_PAYMENT_FAILED'];
									 break;														
							 }
	 
							 $dokuonecheckout->set_order_status($order_id, $status_no);                                      
							 
							 # Insert transaction notify to table onecheckout
							 $dokuonecheckout->add_dokuonecheckout($trx);
							 
							 echo "Continue";
					 }
			 }
			 else
			 {
					 echo "Stop : Request Not Valid";
					 
					 $trx['message']       = "WORDS not match";
					 $trx['raw_post_data'] = "WORDS component: ".$words_components;
					 
					 $dokuonecheckout->add_dokuonecheckout($trx);					 
					 die;
			 }
	 }
			 
	 break;	 
	 
	 default:
	 echo "Stop : Access Not Valid";
	 die;			
	 break;
}        

?>