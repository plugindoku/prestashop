<?php

require_once(dirname(__FILE__).'/../../config/config.inc.php');
require_once(dirname(__FILE__).'/../../init.php');
require_once(dirname(__FILE__).'/dokuonecheckout.php');

$dokuonecheckout = new DOKUOnecheckout();
					 
$trx = array();														

$trx['amount']           = $_POST['AMOUNT'];
$trx['transidmerchant']  = $_POST['TRANSIDMERCHANT']; 
$trx['process_datetime'] = date("Y-m-d H:i:s");
$trx['process_type']     = 'PAYMENT REQUEST';
$trx['ip_address']       = $dokuonecheckout->getipaddress();
$trx['message']          = "Payment Request to DOKU";

$config = $dokuonecheckout->getServerConfig();
$order_state = $config['DOKU_AWAITING_PAYMENT'];

//$dokuonecheckout->validateOrder($trx['transidmerchant'], $order_state, $trx['amount'], $dokuonecheckout->displayName, $trx['transidmerchant']);							 

# Insert to table onecheckout
$dokuonecheckout->add_dokuonecheckout($trx);								

?>