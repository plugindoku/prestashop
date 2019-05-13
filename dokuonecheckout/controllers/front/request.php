<?php

class DOKUOnecheckoutRequestModuleFrontController extends ModuleFrontController
{
    public $ssl = true;

    public function initContent()
    {
        parent::initContent();

        $dokuonecheckout = new dokuonecheckout();        
        $task		         = $_GET['task'];

        switch ($task)
        {
            case "redirect":                
						if ( empty($_POST) )
						{
								echo "Stop : Access Not Valid";
								die;
						}
						
						$trx = array();
						
						$trx['words']                = $_POST['WORDS'];
						$trx['amount']               = $_POST['AMOUNT'];
						$trx['transidmerchant']      = $_POST['TRANSIDMERCHANT']; 
						$trx['status_code']          = $_POST['STATUSCODE'];
						
						if ( isset($_POST['PAYMENTCODE']) ) $trx['payment_code'] = $_POST['PAYMENTCODE'];
					
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
            
						$words = sha1($trx_amount.
											trim($config['SHARED_KEY']).
											trim($trx['transidmerchant']).
											trim($trx['status_code']));	

						if (!$_POST['status_code']){
							$words=$trx['words'];
						}

						if ( $trx['words']==$words )
						{
					
								$use_edu  = $config['USE_EDU'];
								
								$trx['payment_channel']  = $_POST['PAYMENTCHANNEL'];
								$trx['session_id']       = $_POST['SESSIONID'];
								$trx['ip_address']       = $dokuonecheckout->getipaddress();
								$trx['process_datetime'] = date("Y-m-d H:i:s");
								$trx['process_type']     = 'REDIRECT';

								$statuscode=$trx['status_code'];
								$statusnotify='SUCCESS';
								$resultcheck = $dokuonecheckout->checkTrx($trx, 'NOTIFY', $statusnotify);

								$BCA_status = $dokuonecheckout->get_bcaklikpay_status($trx['transidmerchant']);

								if ($BCA_status>0){
									$trx['status_code']='0000';
								}
								switch ($trx['status_code'])
								{
										case "0000":
										$result_msg = "SUCCESS";
										break;
										
										default:
										$result_msg = "FAILED";
										break;
								}								
								
								# Check if the transaction have notify message  
								$result = $dokuonecheckout->checkTrx($trx, 'NOTIFY', $result_msg);
								$checkredirect = $dokuonecheckout->checkTrx($trx, 'REDIRECT');

								# Check if transaction is VA Channel
								if ( in_array($trx['payment_channel'], $dokuonecheckout->va_channel) && $trx['status_code'] == "5511" )
								{
										# If the transaction have notify, check the status code to display the right template
										switch (TRUE)
										{
												case ( $result > 0 && $trx['status_code']=="0000" ):
												$trx['message'] = "Redirect process message come from DOKU. Transaction is Success";  
												$status         = "completed";				
												$return_message = "Your payment is success. We will process your order. Thank you for shopping with us.";
												$template       = 'success.tpl';												
												break;
												
												case ($resultcheck > 0 && $trx['status_code']=="5511");
												$trx['message'] = "Redirect process message come from DOKU. Transaction is Success";  
												$status         = "completed";				
												$return_message = "Your payment is success. We will process your order. Thank you for shopping with us.";
												$template       = 'success.tpl';												
												break;

												case ($checkredirect > 0 && $trx['status_code']=="5511");
												$trx['message'] = "Redirect process message come from DOKU. Transaction is pending for payment";  
												$status         = "pending";				
												$return_message = "Your payment is pending. Thank you for shopping with us.";
												$template       = 'pending_va.tpl';												
												break;
												
												default:
												$trx['message'] = "Redirect process come from DOKU. Transaction is pending for payment";  
												$status         = "pending";
												$status_no      = $config['DOKU_PAYMENT_STATUS_PENDING'];
												$template       = "pending_va.tpl";														
												break;
										}
										                    										
                    $dokuonecheckout->emptybag();
                    
                     switch( $trx['payment_channel'] )
                    {
						case "22":
                            $payment_channel = "ATM Transfer Sinarmas VA";
                        break;
						
						case "38":
                        case "40":
                            $payment_channel = "ATM Transfer BNI VA";
                        break;
						
						default:
								$payment_channel = "unknown channel";
						break;
                    }

                    $this->context->smarty->assign(array(
                                                         'payment_channel' => $payment_channel, # ATM Transfer / Alfa Payment
                                                         'payment_code'    => $trx['payment_code']
                                                         ));
                    $this->setTemplate($template);                    
								}
								# Check if transaction is Klik BCA Channel
								elseif ( in_array($trx['payment_channel'], $dokuonecheckout->klikbca_channel) && $trx['status_code'] <> "0000" )
								{
										# If the transaction have notify, check the status code to display the right template
										switch (TRUE)
										{
												case ( $result > 0 && $trx['status_code']=="0000" ):
												$trx['message'] = "Redirect process message come from DOKU. Transaction is Success";  
												$status         = "completed";				
												$return_message = "Your payment is success. We will process your order. Thank you for shopping with us.";
												$template       = 'success.tpl';												
												break;
										
												default:
												$trx['message'] = "Redirect process come from DOKU. Transaction is pending for payment";  
												$status         = "pending";
												$status_no      = $config['DOKU_PAYMENT_STATUS_PENDING'];
												$template       = "pending_klikbca.tpl";
												break;
										}
										                    										
                    $dokuonecheckout->emptybag();
										
                    $this->context->smarty->assign(array(
                                                         'payment_channel' => 'Klik BCA',
                                                         ));
                    $this->setTemplate($template);          										
								}
                else
                {										
                    
										if ( $result > 0) 
										{
												# If the transaction have notify, check the status code to display the right template
												switch (TRUE)
												{
														case ( $trx['status_code']=="0000" && intval($use_edu) == 1 && in_array($trx['payment_channel'], $dokuonecheckout->edu_channel) ):
														$trx['message'] = "Redirect process message come from DOKU. Notify is Success, wait for EDU Verification";  
														$status         = "on-hold";									
														$return_message = "Thank you for shopping with us. We will process your payment soon.";
														$template       = 'success_verification.tpl';
														$dokuonecheckout->emptybag();
														break;
												
														case ( $trx['status_code']=="0000" ):
														$trx['message'] = "Redirect process message come from DOKU. Transaction is Success";  
														$status         = "completed";				
														$return_message = "Your payment is success. We will process your order. Thank you for shopping with us.";
														$template       = 'success.tpl';
														$dokuonecheckout->emptybag();																
														break;
												
														default:
                            $trx['message'] = "Redirect process message come from DOKU. Transaction is Failed";  
                            $status         = "failed";				
                            $return_message = "Your payment is failed. Please check your payment detail or please try again later.";
                            $template       = 'failed.tpl';																
														break;
												}																						
												
										}
										else
										{
												# If the transaction doesn't have notify, use check status to DOKU  
												$check_result_msg = $dokuonecheckout->doku_check_status($trx);
												
												# Check if the transaction have check status result or not
												if ( empty( $check_result_msg ) )
												{
														# If the transaction doesn't have check status, show pending template for success result. Must check with DOKU.
														switch (TRUE)
														{
																case ( $trx['status_code']=="0000" ):
																$trx['message'] = "Redirect process with no notify message come from DOKU. There is no Check Status : pending";
																$status         = "pending";
																$return_message = "Thank you for shopping with us. We will process your payment soon.";
																$template       = 'pending.tpl';
																$dokuonecheckout->emptybag();
																break;
														
																default:
																$trx['message'] = "Redirect process with no notify message come from DOKU. There is no Check Status : failed"; 
																$status         = "failed";				
																$return_message = "Your payment is failed. Please check your payment detail or please try again later.";
																$template       = 'failed.tpl';
																break;														
														}
												}
												else
												{
														# If the transaction have check status, update the transaction status according to check status result.															
														switch (TRUE)
														{
																case ( $check_result_msg=="SUCCESS" && intval($use_edu) == 1 && in_array($trx['payment_channel'], $dokuonecheckout->edu_channel) ):
																$trx['message'] = "Redirect process with no notify message come from DOKU. Check Status result is Success but using EDU : pending";
																$status         = "on-hold";
																$status_no      = $config['DOKU_WAIT_FOR_VERIFICATION'];
																$template       = 'success_verification.tpl';
																break;
																
																case ( $check_result_msg=="SUCCESS" ):
																$trx['message'] = "Redirect process with no notify message come from DOKU. Check Status result is Success : completed";
																$status         = "completed";
																$status_no      = 2;
																$template       = 'success.tpl';
																$dokuonecheckout->emptybag();
																break;
																
																case ( $check_result_msg=="FAILED" ):
																$trx['message'] = "Redirect process with no notify message come from DOKU. Check Status result is Failed : canceled";
																$status         = "failed";
																$status_no      = $config['DOKU_PAYMENT_FAILED'];
																$template       = 'failed.tpl';
																break;
																																
																default:
																$trx['message'] = "Redirect process with no notify message come from DOKU. There is no Check Status result : pending. Check with DOKU.";
																$status         = "pending";
																$status_no      = $config['DOKU_AWAITING_PAYMENT'];
																$template       = 'pending.tpl';
																break;
														}														
												}
										}
                    
                    switch( $trx['payment_channel'] )
                    {
                        case "01":
						case "15":
                            $payment_channel = "Credit Card";
                        break;

                        case "02":
                            $payment_channel = "Mandiri Clickpay";
                        break;

                        case "03":
                            $payment_channel = "Klik BCA";
                        break;												
												
                        case "04":
                            $payment_channel = "Dokuwallet";
                        break;

                        case "05":
                        case "36":
                            $payment_channel = "ATM Transfer Permata VA";
                        break;

                        case "06":
                            $payment_channel = "ePay BRI";
                        break;

                        case "14":
						case "35":
                            $payment_channel = "DOKU Alfa";
                        break;

						case "22":
                            $payment_channel = "ATM Transfer Sinarmas VA";
                        break;
				
						case "25":
                            $payment_channel = "Internet Banking Muamalat";
                        break;
				
						case "26":
                            $payment_channel = "Internet Banking Danamon";
                        break;
						
						case "28":
                            $payment_channel = "Internet Banking Permata";
                        break;
				
                        case "29":
                            $payment_channel = "ATM Transfer BCA VA";
                        break;

                        case "31":
                            $payment_channel = "Doku Indomaret";
                        break;

                        case "32":
                            $payment_channel = "ATM Transfer CIMB VA";
                        break;
				
						case "33":
                            $payment_channel = "ATM Transfer Danamon VA";
                        break;
				
						case "34":
                            $payment_channel = "ATM Transfer BRI VA";
                        break;
						
						case "37":
                            $payment_channel = "Kredivo";
                        break;
						
						case "38":
                        case "40":
                            $payment_channel = "ATM Transfer BNI VA";
                        break;
						
						case "41":
                            $payment_channel = "ATM Transfer Mandiri VA";
                        break;
						
						case "42":
                            $payment_channel = "ATM Transfer QNB VA";
                        break;
						
						case "43":
                            $payment_channel = "ATM Transfer BTN VA";
                        break;
				
										
												default:
														$payment_channel = "unknown channel";
												break;
                    }
                    
                    $this->context->smarty->assign(array(
                                                        'payment_channel' => $payment_channel
                                                        ));
                    
                    $this->setTemplate($template);
								
                }								
								
								
								# Update order status
								if ( isset($status_no) ) $dokuonecheckout->set_order_status($order_id, $status_no);
								
								# Insert transaction redirect to table onecheckout
								$dokuonecheckout->add_dokuonecheckout($trx);                                
            }
						else
						{
								$dokuonecheckout->setTemplate('invalid.tpl');
						}						
            break;

            default:
                $dokuonecheckout->setTemplate('invalid.tpl');
            break;
        }
		}
}