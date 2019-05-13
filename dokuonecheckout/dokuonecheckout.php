<?php

/*
    Plugin Name : Prestashop DOKU Onecheckout Payment Gateway
    Plugin URI  : http://www.doku.com
    Description : DOKU Onecheckout Payment Gateway for Prestashop 1.5, 1.6 dan 1.7
    Version     : 2.2.0
    Author      : DOKU
    Author URI  : http://www.doku.com
*/


if (!defined('_PS_VERSION_'))
    exit;

class DOKUOnecheckout extends PaymentModule
{
    private $_html = '';
    private $_postErrors = array();

    public $server_dest;
    public $mall_id_dev;
    public $shared_key_dev;
		public $chain_dev;
		public $mall_id_prod;
		public $shared_key_prod;
		public $chain_prod;
		public $use_edu;
		public $use_identify;		
		public $doku_name;
		public $doku_description;
		public $use_installment;				
		public $use_tokenization;				
		public $use_klikpaybca;				
		public $min_installment;						
		public $use_installment_offus;				
		public $min_installment_offus;						
		public $bni_installment;
		public $bni_installment_plan;
		public $bni_installment_tenor;
		public $mandiri_installment;
		public $mandiri_installment_plan;
		public $mandiri_installment_tenor;		
		public $channel_option;		
		public $channel_cc;
		public $channel_cc_tokenization;
		public $channel_dokuwallet;
		public $channel_clickpay;
		public $channel_klikbca;
		public $channel_bri;		
		public $channel_briva;    
    	public $channel_cimbva;    
    	public $channel_danamonva;    
    	public $channel_qnbva;    
    	public $channel_btnva;    
    	public $channel_maybankva;    
    	public $channel_bniva;    
    	public $channel_sinarmasva;    
    	public $channel_muamalatib;    
    	public $channel_danamonib;    
    	public $channel_permatanet;
    	public $channel_cimbclicks;    
    	public $channel_bniyap;    
		public $channel_atm;
		public $channel_atm_mandiri;
		public $channel_atm_bca;
		public $channel_store;		
		public $channel_indomaret;
		public $channel_kredivo;
		public $ip_range;
		public $va_channel;
		public $klikbca_channel;
		public $edu_channel;
		public $mall_id_kredivo;
		public $chain_id_kredivo;
		public $shared_key_kredivo;
        public $mall_id_bniva;
        public $chain_id_bniva;
        public $shared_key_bniva;
        public $mall_id_sinarmasva;
        public $chain_id_sinarmasva;
        public $shared_key_sinarmasva;
        public $mall_id_klikpaybca;
        public $chain_id_klikpaybca;
        public $shared_key_klikpaybca;

    public function __construct()
    {
        $this->name             = 'dokuonecheckout';
        $this->tab              = 'payments_gateways';
		$this->author           = 'Doku';
        $this->version          = '2.2.0';
		$this->need_instance 	= 0;
		$this->ps_versions_compliancy = array('min' => '1.6', 'max' => _PS_VERSION_);
		$this->bootstrap 		= true;
		parent::__construct();
        $this->displayName      = $this->l('DOKU Payment Gateway');
        $this->description      = $this->l('DOKU is Indonesia\'s largest and fastest growing provider of electronic payment. We provide electronic payment processing, online and in mobile applications. Enabling e-Commerce merchants of any size to accept a wide range of online payment options, from credit cards to emerging payment types.');
        $this->confirmUninstall = $this->l('Are you sure you want to uninstall?');

				$this->ip_range         = '103.10.129';
				$this->va_channel       = array("05","07","14","22","29","31","32","33","34","35","36","38","40","41","42","43","44");
				$this->klikbca_channel  = "03";
				$this->edu_channel		= array("01","15");			
				$this->kredivo_channel  = "37";			
				
        $config = Configuration::getMultiple(array('SERVER_DEST', 'MALL_ID_DEV', 'SHARED_KEY_DEV', 'CHAIN_DEV', 'MALL_ID_PROD', 'SHARED_KEY_PROD', 'CHAIN_PROD', 'USE_EDU', 'USE_IDENTIFY','MALL_ID_KREDIVO','CHAIN_ID_KREDIVO','SHARED_KEY_KREDIVO','MALL_ID_BNIVA','CHAIN_ID_BNIVA','SHARED_KEY_BNIVA','MALL_ID_KLIKPAYBCA','CHAIN_ID_KLIKPAYBCA','SHARED_KEY_KLIKPAYBCA','MALL_ID_SINARMASVA','CHAIN_ID_SINARMASVA','SHARED_KEY_SINARMASVA'));

        if (isset($config['SERVER_DEST']))
            $this->server_dest               = $config['SERVER_DEST'];
        if (isset($config['MALL_ID_DEV']))
            $this->mall_id_dev               = $config['MALL_ID_DEV'];
        if (isset($config['SHARED_KEY_DEV']))
            $this->shared_key_dev            = $config['SHARED_KEY_DEV'];
        if (isset($config['CHAIN_DEV']))
            $this->chain_dev                 = $config['CHAIN_DEV'];
        if (isset($config['MALL_ID_PROD']))
            $this->mall_id_prod              = $config['MALL_ID_PROD'];
        if (isset($config['MALL_ID_PROD']))
            $this->shared_key_prod           = $config['MALL_ID_PROD'];
        if (isset($config['CHAIN_PROD']))
            $this->chain_prod                = $config['CHAIN_PROD'];
        if (isset($config['USE_EDU']))
            $this->use_edu                   = $config['USE_EDU'];
        if (isset($config['USE_IDENTIFY']))
            $this->use_identify              = $config['USE_IDENTIFY'];
        if (isset($config['DOKU_NAME']))
            $this->doku_name                 = $config['DOKU_NAME'];
        if (isset($config['DOKU_DESCRIPTION']))
            $this->doku_description          = $config['DOKU_DESCRIPTION'];						
		if (isset($config['USE_INSTALLMENT']))
            $this->use_installment           = $config['USE_INSTALLMENT'];
		if (isset($config['USE_KLIKPAYBCA']))
            $this->use_klikpaybca           = $config['USE_KLIKPAYBCA'];
		if (isset($config['USE_TOKENIZATION']))
            $this->use_tokenization           = $config['USE_TOKENIZATION'];
        if (isset($config['MIN_INSTALLMENT']))
            $this->min_installment           = $config['MIN_INSTALLMENT'];
		if (isset($config['USE_INSTALLMENT_OFFUS']))
            $this->USE_INSTALLMENT_OFFUS     = $config['USE_INSTALLMENT_OFFUS'];
        if (isset($config['MIN_INSTALLMENT_OFFUS']))
            $this->min_installment_offus     = $config['MIN_INSTALLMENT_OFFUS'];
        if (isset($config['BNI_INSTALLMENT']))
            $this->bni_installment           = $config['BNI_INSTALLMENT'];
        if (isset($config['BNI_INSTALLMENT_PLAN']))
            $this->bni_installment_plan      = $config['BNI_INSTALLMENT_PLAN'];
        if (isset($config['BNI_INSTALLMENT_TENOR']))
            $this->bni_installment_tenor     = $config['BNI_INSTALLMENT_TENOR'];					
        if (isset($config['MANDIRI_INSTALLMENT']))
            $this->mandiri_installment       = $config['MANDIRI_INSTALLMENT'];
        if (isset($config['MANDIRI_INSTALLMENT_PLAN']))
            $this->mandiri_installment_pan   = $config['MANDIRI_INSTALLMENT_PLAN'];
        if (isset($config['MANDIRI_INSTALLMENT_TENOR']))
            $this->mandiri_installment_tenor = $config['MANDIRI_INSTALLMENT_TENOR'];					
        if (isset($config['CHANNEL_OPTION']))
            $this->channel_option            = $config['CHANNEL_OPTION'];
        if (isset($config['CHANNEL_CC']))
            $this->channel_cc                = $config['CHANNEL_CC'];
        if (isset($config['CHANNEL_CC_TOKENIZATION']))
            $this->channel_cc_tokenization                = $config['CHANNEL_CC_TOKENIZATION'];
        if (isset($config['CHANNEL_DOKUWALLET']))
            $this->channel_dokuwallet        = $config['CHANNEL_DOKUWALLET'];					
        if (isset($config['CHANNEL_CLICKPAY']))
            $this->channel_clickpay          = $config['CHANNEL_CLICKPAY'];					
        if (isset($config['CHANNEL_BRI']))
            $this->channel_bri               = $config['CHANNEL_BRI'];
        if (isset($config['CHANNEL_BRIVA']))
            $this->channel_briva               = $config['CHANNEL_BRIVA'];
        if (isset($config['CHANNEL_CIMBVA']))
            $this->channel_cimbva              = $config['CHANNEL_CIMBVA'];
        if (isset($config['CHANNEL_DANAMONVA']))
            $this->channel_danamonva           = $config['CHANNEL_DANAMONVA'];
        if (isset($config['CHANNEL_QNBVA']))
            $this->channel_qnbva               = $config['CHANNEL_QNBVA'];
        if (isset($config['CHANNEL_BTNVA']))
            $this->channel_btnva               = $config['CHANNEL_BTNVA'];
        if (isset($config['CHANNEL_MAYBANKVA']))
            $this->channel_maybankva           = $config['CHANNEL_MAYBANKVA'];
        if (isset($config['CHANNEL_BNIVA']))
            $this->channel_bniva               = $config['CHANNEL_BNIVA'];
        if (isset($config['CHANNEL_SINARMASVA']))
            $this->channel_sinarmasva          = $config['CHANNEL_SINARMASVA'];
        if (isset($config['CHANNEL_MUAMALATIB']))
            $this->channel_muamalatib          = $config['CHANNEL_MUAMALATIB'];
        if (isset($config['CHANNEL_DANAMONIB']))
            $this->channel_danamonib           = $config['CHANNEL_DANAMONIB'];
        if (isset($config['CHANNEL_PERMATANET']))
            $this->channel_permatanet          = $config['CHANNEL_PERMATANET'];
        if (isset($config['CHANNEL_CIMBCLICKS']))
            $this->channel_cimbclicks          = $config['CHANNEL_CIMBCLICKS'];
        if (isset($config['CHANNEL_BNIYAP']))
            $this->channel_bniyap              = $config['CHANNEL_BNIYAP'];
        if (isset($config['CHANNEL_KLIKBCA']))
            $this->channel_klikbca           = $config['CHANNEL_KLIKBCA'];						
        if (isset($config['CHANNEL_ATM']))
            $this->channel_atm               = $config['CHANNEL_ATM'];
        if (isset($config['CHANNEL_ATM_BCA']))
            $this->channel_atm_bca           = $config['CHANNEL_ATM_BCA'];											
        if (isset($config['CHANNEL_ATM_MANDIRI']))
            $this->channel_atm_mandiri       = $config['CHANNEL_ATM_MANDIRI'];											
        if (isset($config['CHANNEL_STORE']))
            $this->channel_store             = $config['CHANNEL_STORE'];					
        if (isset($config['CHANNEL_INDOMARET']))
            $this->channel_indomaret         = $config['CHANNEL_INDOMARET'];	
        if (isset($config['CHANNEL_KREDIVO']))
            $this->channel_kredivo           = $config['CHANNEL_KREDIVO'];
        if (isset($config['MALL_ID_KREDIVO']))
            $this->mall_id_kredivo           = $config['MALL_ID_KREDIVO'];
        if (isset($config['SHARED_KEY_KREDIVO']))
            $this->shared_key_kredivo        = $config['SHARED_KEY_KREDIVO'];
        if (isset($config['CHAIN_ID_KREDIVO']))
            $this->chain_id_kredivo          = $config['CHAIN_ID_KREDIVO'];
        if (isset($config['MALL_ID_BNIVA']))
            $this->mall_id_bniva           = $config['MALL_ID_BNIVA'];
        if (isset($config['SHARED_KEY_BNIVA']))
            $this->shared_key_bniva        = $config['SHARED_KEY_BNIVA'];
        if (isset($config['CHAIN_ID_BNIVA']))
            $this->chain_id_bniva          = $config['CHAIN_ID_BNIVA'];
        if (isset($config['MALL_ID_SINARMASVA']))
            $this->mall_id_sinarmasva           = $config['MALL_ID_SINARMASVA'];
        if (isset($config['SHARED_KEY_SINARMASVA']))
            $this->shared_key_sinarmasva        = $config['SHARED_KEY_SINARMASVA'];
        if (isset($config['CHAIN_ID_SINARMASVA']))
            $this->chain_id_sinarmasva          = $config['CHAIN_ID_SINARMASVA'];
        if (isset($config['MALL_ID_KLIKPAYBCA']))
            $this->mall_id_klikpaybca          = $config['MALL_ID_KLIKPAYBCA'];
        if (isset($config['SHARED_KEY_KLIKPAYBCA']))
            $this->shared_key_klikpaybca        = $config['SHARED_KEY_KLIKPAYBCA'];
        if (isset($config['CHAIN_ID_KLIKPAYBCA']))
            $this->chain_id_klikpaybca          = $config['CHAIN_ID_KLIKPAYBCA'];
				
					

        
				if ( isset($this->server_dest) )
				{
						if ( $this->server_dest == 0 )
						{
								if ( !isset($this->mall_id_dev) || !isset($this->shared_key_dev) || !isset($this->chain_dev) )
								$this->warning = $this->l('Mall ID, Shared Key and Chain must be configured in order to use this module correctly.');
						}
						else
						{
								if ( !isset($this->mall_id_prod) || !isset($this->shared_key_prod) || !isset($this->chain_prod) )
								$this->warning = $this->l('Mall ID, Shared Key and Chain must be configured in order to use this module correctly.');
						}
				}
				else
				{
						$this->warning = $this->l('Please set Server Destination in order to use this module correctly.');
				}
    }

    public function install()
    {
        parent::install();
        $this->createdokuonecheckoutTable();
        $this->registerHook('Payment');
        $this->registerHook('PaymentReturn');
		$this->registerHook('updateOrderStatus');
		$this->addDOKUOrderStatus();
		$this->copyEmailFiles();
		return true;
    }

    public function uninstall()
    {		if (
			!parent::uninstall()
		) {
			return false;
		} else {
		Configuration::deleteByName('SERVER_DEST');		
        Configuration::deleteByName('MALL_ID_DEV');
        Configuration::deleteByName('SHARED_KEY_DEV');
        Configuration::deleteByName('CHAIN_DEV');				
        Configuration::deleteByName('MALL_ID_PROD');
        Configuration::deleteByName('SHARED_KEY_PROD');
        Configuration::deleteByName('CHAIN_PROD');
        Configuration::deleteByName('USE_EDU');						
        Configuration::deleteByName('USE_IDENTIFY');										
		Configuration::deleteByName('DOKU_NAME');
		Configuration::deleteByName('DOKU_DESCRIPTION');														
        Configuration::deleteByName('USE_INSTALLMENT');														
        Configuration::deleteByName('USE_TOKENIZATION');														
        Configuration::deleteByName('USE_KLIKPAYBCA');														
        Configuration::deleteByName('MIN_INSTALLMENT');
        Configuration::deleteByName('USE_INSTALLMENT_OFFUS');														
        Configuration::deleteByName('MIN_INSTALLMENT_OFFUS');
        Configuration::deleteByName('BNI_INSTALLMENT');
        Configuration::deleteByName('BNI_INSTALLMENT_PLAN');
        Configuration::deleteByName('BNI_INSTALLMENT_TENOR');
        Configuration::deleteByName('MANDIRI_INSTALLMENT');
        Configuration::deleteByName('MANDIRI_INSTALLMENT_PLAN');
        Configuration::deleteByName('MANDIRI_INSTALLMENT_TENOR');				
        Configuration::deleteByName('CHANNEL_OPTION');
        Configuration::deleteByName('CHANNEL_CC');				
        Configuration::deleteByName('CHANNEL_CC_TOKENIZATION');				
        Configuration::deleteByName('CHANNEL_DOKUWALLET');				
        Configuration::deleteByName('CHANNEL_CLICKPAY');				
        Configuration::deleteByName('CHANNEL_BRI');
        Configuration::deleteByName('CHANNEL_BRIVA');
        Configuration::deleteByName('CHANNEL_CIMBVA');
        Configuration::deleteByName('CHANNEL_DANAMONVA');
        Configuration::deleteByName('CHANNEL_QNBVA');
        Configuration::deleteByName('CHANNEL_BTNVA');
        Configuration::deleteByName('CHANNEL_MAYBANKVA');
        Configuration::deleteByName('CHANNEL_BNIVA');
        Configuration::deleteByName('CHANNEL_SINARMASVA');
        Configuration::deleteByName('CHANNEL_MUAMALATIB');
        Configuration::deleteByName('CHANNEL_DANAMONIB');
        Configuration::deleteByName('CHANNEL_PERMATANET');
        Configuration::deleteByName('CHANNEL_CIMBCLICKS');
        Configuration::deleteByName('CHANNEL_BNIYAP');
   		Configuration::deleteByName('CHANNEL_KLIKBCA');
        Configuration::deleteByName('CHANNEL_ATM');
	    Configuration::deleteByName('CHANNEL_ATM_BCA');
	    Configuration::deleteByName('CHANNEL_ATM_MANDIRI');
        Configuration::deleteByName('CHANNEL_STORE');
        Configuration::deleteByName('CHANNEL_KREDIVO');
		Configuration::deleteByName('MALL_ID_KREDIVO');
        Configuration::deleteByName('SHARED_KEY_KREDIVO');
        Configuration::deleteByName('CHAIN_ID_KREDIVO');
        Configuration::deleteByName('MALL_ID_BNIVA');
        Configuration::deleteByName('SHARED_KEY_BNIVA');
        Configuration::deleteByName('CHAIN_ID_BNIVA');
        Configuration::deleteByName('MALL_ID_SINARMASVA');
        Configuration::deleteByName('SHARED_KEY_SINARMASVA');
        Configuration::deleteByName('CHAIN_ID_SINARMASVA');
        Configuration::deleteByName('MALL_ID_KLIKPAYBCA');
        Configuration::deleteByName('SHARED_KEY_KLIKPAYBCA');
        Configuration::deleteByName('CHAIN_ID_KLIKPAYBCA');
				
				/*				
				$this->deleteOrderState(Tools::safeOutput(Configuration::get('DOKU_AWAITING_PAYMENT')));
				$this->deleteOrderState(Tools::safeOutput(Configuration::get('DOKU_PAYMENT_STATUS_PENDING')));
				$this->deleteOrderState(Tools::safeOutput(Configuration::get('DOKU_PAYMENT_STATUS_PENDING_EMAIL')));
				$this->deleteOrderState(Tools::safeOutput(Configuration::get('DOKU_WAIT_FOR_VERIFICATION')));
				$this->deleteOrderState(Tools::safeOutput(Configuration::get('DOKU_PAYMENT_FAILED')));				

				unlink(dirname(__FILE__).'/../../img/os/'.(Tools::safeOutput(Configuration::get('DOKU_AWAITING_PAYMENT'))).'.gif');
				unlink(dirname(__FILE__).'/../../img/os/'.(Tools::safeOutput(Configuration::get('DOKU_PAYMENT_STATUS_PENDING'))).'.gif');
				unlink(dirname(__FILE__).'/../../img/os/'.(Tools::safeOutput(Configuration::get('DOKU_PAYMENT_STATUS_PENDING_EMAIL'))).'.gif');
				unlink(dirname(__FILE__).'/../../img/os/'.(Tools::safeOutput(Configuration::get('DOKU_WAIT_FOR_VERIFICATION'))).'.gif');
				unlink(dirname(__FILE__).'/../../img/os/'.(Tools::safeOutput(Configuration::get('DOKU_PAYMENT_FAILED'))).'.gif');
				
				Configuration::deleteByName('DOKU_AWAITING_PAYMENT');
				Configuration::deleteByName('DOKU_PAYMENT_STATUS_PENDING');
				Configuration::deleteByName('DOKU_PAYMENT_STATUS_PENDING_EMAIL');
				Configuration::deleteByName('DOKU_WAIT_FOR_VERIFICATION');
				Configuration::deleteByName('DOKU_PAYMENT_FAILED');
				*/
				
        parent::uninstall();
        Db::getInstance()->Execute("DROP TABLE `"._DB_PREFIX_."dokuonecheckout`");
        parent::uninstall();
        	return true;
		}
        
    }

    function createdokuonecheckoutTable()
    {
        $db = Db::getInstance();
        $query = "
				CREATE TABLE "._DB_PREFIX_."dokuonecheckout (
					trx_id int( 11 ) NOT NULL AUTO_INCREMENT,
					ip_address VARCHAR( 16 ) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
					process_type VARCHAR( 15 ) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
					process_datetime DATETIME NULL, 
					doku_payment_datetime DATETIME NULL,   
					transidmerchant VARCHAR(30) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
					amount DECIMAL( 20,2 ) NOT NULL DEFAULT '0',
					notify_type VARCHAR( 1 ) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
					response_code VARCHAR( 4 ) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
					status_code VARCHAR( 4 ) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
					result_msg VARCHAR( 20 ) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
					reversal INT( 1 ) COLLATE utf8_unicode_ci NOT NULL DEFAULT 0,
					approval_code CHAR( 20 ) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
					payment_channel VARCHAR( 2 ) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
					payment_code VARCHAR( 20 ) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
					bank_issuer VARCHAR( 100 ) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
					creditcard VARCHAR( 16 ) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
					words VARCHAR( 200 ) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',  
					session_id VARCHAR( 48 ) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
					verify_id VARCHAR( 30 ) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
					verify_score INT( 3 ) COLLATE utf8_unicode_ci NOT NULL DEFAULT 0,
					verify_status VARCHAR( 10 ) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
					check_status INT( 1 ) COLLATE utf8_unicode_ci NOT NULL DEFAULT 0,
					count_check_status INT( 1 ) COLLATE utf8_unicode_ci NOT NULL DEFAULT 0,
					raw_post_data TEXT COLLATE utf8_unicode_ci,  
					message TEXT COLLATE utf8_unicode_ci,  
					bcaklikpaycode TEXT COLLATE utf8_unicode_ci,  
					PRIMARY KEY (trx_id)
				) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1										
				";

        $db->Execute($query);
    }
                                
    private function _postValidation()
    {
        // configuration
        if (Tools::isSubmit('btnSubmit'))
        {
						if ( intval(Tools::getValue('server_dest')) == 0 )
						{
								if (!Tools::getValue('mall_id_dev'))
										$this->_postErrors[] = $this->l('Mall ID is required.');
								elseif (!Tools::getValue('shared_key_dev'))
										$this->_postErrors[] = $this->l('Sharedkey is required.');
								elseif (!Tools::getValue('chain_dev'))
										$this->_postErrors[] = $this->l('Chain is required.');
						}
						else
						{
								if (!Tools::getValue('mall_id_prod'))
										$this->_postErrors[] = $this->l('Mall ID is required.');
								elseif (!Tools::getValue('shared_key_prod'))
										$this->_postErrors[] = $this->l('Sharedkey is required.');
								elseif (!Tools::getValue('chain_prod'))
										$this->_postErrors[] = $this->l('Chain is required.');								
						}
						if ( intval(Tools::getValue('channel_option')) == 1 )
						{
						if ( intval(Tools::getValue('channel_kredivo')) == 1 )
						{
								if (!Tools::getValue('mall_id_kredivo'))
										$this->_postErrors[] = $this->l('Mall ID KREDIVO is required.');
								elseif (!Tools::getValue('shared_key_kredivo'))
										$this->_postErrors[] = $this->l('Sharedkey KREDIVO is required.');
								elseif (!Tools::getValue('chain_id_kredivo'))
										$this->_postErrors[] = $this->l('Chain KREDIVO is required.');
						}
                        if ( intval(Tools::getValue('channel_bniva')) == 1 )
                        {
                                if (!Tools::getValue('mall_id_bniva'))
                                        $this->_postErrors[] = $this->l('Mall ID BNIVA is required.');
                                elseif (!Tools::getValue('shared_key_bniva'))
                                        $this->_postErrors[] = $this->l('Sharedkey BNIVA is required.');
                                elseif (!Tools::getValue('chain_id_bniva'))
                                        $this->_postErrors[] = $this->l('Chain BNIVA is required.');
                        }
                        if ( intval(Tools::getValue('channel_sinarmasva')) == 1 )
                        {
                                if (!Tools::getValue('mall_id_sinarmasva'))
                                        $this->_postErrors[] = $this->l('Mall ID SINARMASVA is required.');
                                elseif (!Tools::getValue('shared_key_sinarmasva'))
                                        $this->_postErrors[] = $this->l('Sharedkey SINARMASVA is required.');
                                elseif (!Tools::getValue('chain_id_sinarmasva'))
                                        $this->_postErrors[] = $this->l('Chain SINARMASVA is required.');
                        }
                        if ( intval(Tools::getValue('channel_klikbca')) == 1 )
                        {
                                if (!Tools::getValue('mall_id_klikpaybca'))
                                        $this->_postErrors[] = $this->l('Mall ID KLIKPAYBCA is required.');
                                elseif (!Tools::getValue('shared_key_klikpaybca'))
                                        $this->_postErrors[] = $this->l('Sharedkey KLIKPAYBCA is required.');
                                elseif (!Tools::getValue('chain_id_klikpaybca'))
                                        $this->_postErrors[] = $this->l('Chain KLIKPAYBCA is required.');
                        }
						}
        }
    }

    private function _postProcess()
    {
        if (Tools::isSubmit('btnSubmit'))
        {
            Configuration::updateValue('SERVER_DEST',               trim(Tools::getValue('server_dest')));
            Configuration::updateValue('MALL_ID_DEV',               trim(Tools::getValue('mall_id_dev')));
            Configuration::updateValue('SHARED_KEY_DEV',            trim(Tools::getValue('shared_key_dev')));
			Configuration::updateValue('CHAIN_DEV',                 trim(Tools::getValue('chain_dev')));
            Configuration::updateValue('MALL_ID_PROD',              trim(Tools::getValue('mall_id_prod')));
            Configuration::updateValue('SHARED_KEY_PROD',           trim(Tools::getValue('shared_key_prod')));
			Configuration::updateValue('CHAIN_PROD',                trim(Tools::getValue('chain_prod')));						
			Configuration::updateValue('USE_EDU',                   trim(Tools::getValue('use_edu')));						
			Configuration::updateValue('USE_IDENTIFY',              trim(Tools::getValue('use_identify')));						
			Configuration::updateValue('DOKU_NAME',                 trim(Tools::getValue('doku_name')));
			Configuration::updateValue('DOKU_DESCRIPTION',          trim(Tools::getValue('doku_description')));						
			Configuration::updateValue('USE_INSTALLMENT',           trim(Tools::getValue('use_installment')));
			Configuration::updateValue('USE_KLIKPAYBCA',            trim(Tools::getValue('use_klikpaybca')));
			Configuration::updateValue('USE_TOKENIZATION',          trim(Tools::getValue('use_tokenization')));
			Configuration::updateValue('MIN_INSTALLMENT',           trim(Tools::getValue('min_installment')));
			Configuration::updateValue('USE_INSTALLMENT_OFFUS',     trim(Tools::getValue('use_installment_offus')));
			Configuration::updateValue('MIN_INSTALLMENT_OFFUS',     trim(Tools::getValue('min_installment_offus')));
			Configuration::updateValue('BNI_INSTALLMENT',           trim(Tools::getValue('bni_installment')));						
			Configuration::updateValue('BNI_INSTALLMENT_PLAN',      trim(Tools::getValue('bni_installment_plan')));						
			Configuration::updateValue('BNI_INSTALLMENT_TENOR',     trim(Tools::getValue('bni_installment_tenor')));						
			Configuration::updateValue('MANDIRI_INSTALLMENT',       trim(Tools::getValue('mandiri_installment')));						
			Configuration::updateValue('MANDIRI_INSTALLMENT_PLAN',  trim(Tools::getValue('mandiri_installment_plan')));						
			Configuration::updateValue('MANDIRI_INSTALLMENT_TENOR', trim(Tools::getValue('mandiri_installment_tenor')));
			Configuration::updateValue('CHANNEL_OPTION',            trim(Tools::getValue('channel_option')));
			Configuration::updateValue('CHANNEL_CC',                trim(Tools::getValue('channel_cc')));
			Configuration::updateValue('CHANNEL_CC_TOKENIZATION',   trim(Tools::getValue('channel_cc_tokenization')));
			Configuration::updateValue('CHANNEL_DOKUWALLET',        trim(Tools::getValue('channel_dokuwallet')));
			Configuration::updateValue('CHANNEL_CLICKPAY',          trim(Tools::getValue('channel_clickpay')));						
	      	Configuration::updateValue('CHANNEL_BRIVA',             trim(Tools::getValue('channel_briva')));
      		Configuration::updateValue('CHANNEL_CIMBVA',            trim(Tools::getValue('channel_cimbva')));
      		Configuration::updateValue('CHANNEL_DANAMONVA',         trim(Tools::getValue('channel_danamonva')));
      		Configuration::updateValue('CHANNEL_QNBVA',             trim(Tools::getValue('channel_qnbva')));
      		Configuration::updateValue('CHANNEL_BTNVA',             trim(Tools::getValue('channel_btnva')));
      		Configuration::updateValue('CHANNEL_MAYBANKVA',         trim(Tools::getValue('channel_maybankva')));
      		Configuration::updateValue('CHANNEL_BNIVA',             trim(Tools::getValue('channel_bniva')));
      		Configuration::updateValue('CHANNEL_SINARMASVA',        trim(Tools::getValue('channel_sinarmasva')));
      		Configuration::updateValue('CHANNEL_MUAMALATIB',        trim(Tools::getValue('channel_muamalatib')));
      		Configuration::updateValue('CHANNEL_DANAMONIB',         trim(Tools::getValue('channel_danamonib')));
      		Configuration::updateValue('CHANNEL_PERMATANET',        trim(Tools::getValue('channel_permatanet')));
      		Configuration::updateValue('CHANNEL_CIMBCLICKS',        trim(Tools::getValue('channel_cimbclicks')));
      		Configuration::updateValue('CHANNEL_BNIYAP',            trim(Tools::getValue('channel_bniyap')));
   			Configuration::updateValue('CHANNEL_BRI',               trim(Tools::getValue('channel_bri')));
			Configuration::updateValue('CHANNEL_KLIKBCA',           trim(Tools::getValue('channel_klikbca')));
			Configuration::updateValue('CHANNEL_ATM',               trim(Tools::getValue('channel_atm')));
			Configuration::updateValue('CHANNEL_ATM_BCA',           trim(Tools::getValue('channel_atm_bca')));						
			Configuration::updateValue('CHANNEL_ATM_MANDIRI',       trim(Tools::getValue('channel_atm_mandiri')));						
			Configuration::updateValue('CHANNEL_STORE',             trim(Tools::getValue('channel_store')));						
			Configuration::updateValue('CHANNEL_INDOMARET',         trim(Tools::getValue('channel_indomaret')));						
			Configuration::updateValue('CHANNEL_KREDIVO',           trim(Tools::getValue('channel_kredivo')));						
			Configuration::updateValue('MALL_ID_KREDIVO',           trim(Tools::getValue('mall_id_kredivo')));						
			Configuration::updateValue('SHARED_KEY_KREDIVO',        trim(Tools::getValue('shared_key_kredivo')));						
			Configuration::updateValue('CHAIN_ID_KREDIVO',          trim(Tools::getValue('chain_id_kredivo')));						
            Configuration::updateValue('MALL_ID_KLIKPAYBCA',        trim(Tools::getValue('mall_id_klikpaybca')));                      
            Configuration::updateValue('SHARED_KEY_KLIKPAYBCA',     trim(Tools::getValue('shared_key_klikpaybca')));                       
            Configuration::updateValue('CHAIN_ID_KLIKPAYBCA',       trim(Tools::getValue('chain_id_klikpaybca')));                     
            Configuration::updateValue('MALL_ID_BNIVA',             trim(Tools::getValue('mall_id_bniva')));                      
            Configuration::updateValue('SHARED_KEY_BNIVA',          trim(Tools::getValue('shared_key_bniva')));                       
            Configuration::updateValue('CHAIN_ID_BNIVA',            trim(Tools::getValue('chain_id_bniva')));                     
            Configuration::updateValue('MALL_ID_SINARMASVA',        trim(Tools::getValue('mall_id_sinarmasva')));                      
            Configuration::updateValue('SHARED_KEY_SINARMASVA',     trim(Tools::getValue('shared_key_sinarmasva')));                       
            Configuration::updateValue('CHAIN_ID_SINARMASVA',       trim(Tools::getValue('chain_id_sinarmasva')));                     
        }
        //$this->_html .= '<div class="conf confirm"> '.$this->l('Settings updated').'</div>';
        $this->_html .= '<div class="alert alert-success conf confirm"> '.$this->l('Settings updated').'</div>';
    }

    private function _displayForm()
    {				
				$myservername = _PS_BASE_URL_.__PS_BASE_URI__;
				
				$chain_dev        = "NA";
				$chain_dev_set    = Tools::safeOutput(Tools::getValue('CHAIN_DEV', Configuration::get('CHAIN_DEV')));				
				if ( empty($chain_dev_set) ) $chain_dev_set = $chain_dev;

				$chain_prod       = "NA";
				$chain_prod_set   = Tools::safeOutput(Tools::getValue('CHAIN_PROD', Configuration::get('CHAIN_PROD')));				
				if ( empty($chain_prod_set) ) $chain_prod_set = $chain_prod;
				
				$use_identify     = "checked=\"\"";
				$use_identify_set = Tools::safeOutput(Tools::getValue('USE_IDENTIFY', Configuration::get('USE_IDENTIFY')));
				if ( empty($use_identify_set) || intval($use_identify_set) == 0 ) $use_identify = "";
				
				$use_edu          = "checked=\"\"";
				$use_edu_set      = Tools::safeOutput(Tools::getValue('USE_EDU', Configuration::get('USE_EDU')));
				if ( empty($use_edu_set) || intval($use_edu_set) == 0 ) $use_edu = "";

				$name             = "DOKU Payment Gateway";
				$name_set         = Tools::safeOutput(Tools::getValue('DOKU_NAME', Configuration::get('DOKU_NAME')));
				if ( empty($name_set) ) $name_set = $name;

				$description      = "Click here to redirect you to DOKU secure payment gateway to process your payment";
				$description_set  = Tools::safeOutput(Tools::getValue('DOKU_DESCRIPTION', Configuration::get('DOKU_DESCRIPTION')));
				if ( empty($description_set) ) $description_set = $description;				
				
				$use_installment         = "checked=\"\"";
				$use_installment_set     = Tools::safeOutput(Tools::getValue('USE_INSTALLMENT', Configuration::get('USE_INSTALLMENT')));
				if ( empty($use_installment_set) || intval($use_installment_set) == 0 ) $use_installment = "";

				$use_klikpaybca         = "checked=\"\"";
				$use_klikpaybca_set     = Tools::safeOutput(Tools::getValue('USE_KLIKPAYBCA', Configuration::get('USE_KLIKPAYBCA')));
				if ( empty($use_klikpaybca_set) || intval($use_klikpaybca_set) == 0 ) $use_klikpaybca = "";

				$use_tokenization         = "checked=\"\"";
				$use_tokenization_set     = Tools::safeOutput(Tools::getValue('USE_TOKENIZATION', Configuration::get('USE_TOKENIZATION')));
				if ( empty($use_tokenization_set) || intval($use_tokenization_set) == 0 ) $use_tokenization = "";

				$use_installment_offus         = "checked=\"\"";
				$use_installment_offus_set     = Tools::safeOutput(Tools::getValue('USE_INSTALLMENT_OFFUS', Configuration::get('USE_INSTALLMENT_OFFUS')));
				if ( empty($use_installment_offus_set) || intval($use_installment_offus_set) == 0 ) $use_installment_offus = "";
				
				$min_installment         = "500000";
				$min_installment_set     = Tools::safeOutput(Tools::getValue('MIN_INSTALLMENT', Configuration::get('MIN_INSTALLMENT')));
				if ( empty($min_installment_set) || intval($min_installment_set) == 0 ) $min_installment_set = $min_installment;

				$min_installment_offus         = "500000";
				$min_installment_offus_set    = Tools::safeOutput(Tools::getValue('MIN_INSTALLMENT_OFFUS', Configuration::get('MIN_INSTALLMENT_OFFUS')));
				if ( empty($min_installment_offus_set) || intval($min_installment_offus_set) == 0 ) $min_installment_offus_set = $min_installment_offus;
								
				$bni_installment         = "checked=\"\"";
				$bni_installment_set     = Tools::safeOutput(Tools::getValue('BNI_INSTALLMENT', Configuration::get('BNI_INSTALLMENT')));
				if ( empty($bni_installment_set) || intval($bni_installment_set) == 0 ) $bni_installment = "";
				
				$mandiri_installment     = "checked=\"\"";
				$mandiri_installment_set = Tools::safeOutput(Tools::getValue('MANDIRI_INSTALLMENT', Configuration::get('MANDIRI_INSTALLMENT')));
				if ( empty($mandiri_installment_set) || intval($mandiri_installment_set) == 0 ) $mandiri_installment = "";				
								
				$channel_cc              = "checked=\"\"";
				$channel_cc_set          = Tools::safeOutput(Tools::getValue('CHANNEL_CC', Configuration::get('CHANNEL_CC')));
				if ( empty($channel_cc_set) || intval($channel_cc_set) == 0 ) $channel_cc = "";				

				$channel_briva           = "checked=\"\"";
        		$channel_briva_set       = Tools::safeOutput(Tools::getValue('CHANNEL_BRIVA', Configuration::get('CHANNEL_BRIVA')));
        		if ( empty($channel_briva_set) || intval($channel_briva_set) == 0 ) $channel_briva = "";
        		
        		$channel_cimbva          = "checked=\"\"";
        		$channel_cimbva_set      = Tools::safeOutput(Tools::getValue('CHANNEL_CIMBVA', Configuration::get('CHANNEL_CIMBVA')));
        		if ( empty($channel_cimbva_set) || intval($channel_cimbva_set) == 0 ) $channel_cimbva = "";
        		
        		$channel_danamonva       = "checked=\"\"";
        		$channel_danamonva_set   = Tools::safeOutput(Tools::getValue('CHANNEL_DANAMONVA', Configuration::get('CHANNEL_DANAMONVA')));
        		if ( empty($channel_danamonva_set) || intval($channel_danamonva_set) == 0 ) $channel_danamonva = "";
        		
        		$channel_qnbva           = "checked=\"\"";
        		$channel_qnbva_set       = Tools::safeOutput(Tools::getValue('CHANNEL_QNBVA', Configuration::get('CHANNEL_QNBVA')));
        		if ( empty($channel_qnbva_set) || intval($channel_qnbva_set) == 0 ) $channel_qnbva = "";
        		
        		$channel_btnva           = "checked=\"\"";
        		$channel_btnva_set       = Tools::safeOutput(Tools::getValue('CHANNEL_BTNVA', Configuration::get('CHANNEL_BTNVA')));
        		if ( empty($channel_btnva_set) || intval($channel_btnva_set) == 0 ) $channel_btnva = "";
        		
        		$channel_maybankva       = "checked=\"\"";
        		$channel_maybankva_set   = Tools::safeOutput(Tools::getValue('CHANNEL_MAYBANKVA', Configuration::get('CHANNEL_MAYBANKVA')));
        		if ( empty($channel_maybankva_set) || intval($channel_maybankva_set) == 0 ) $channel_maybankva = "";
        		
        		$channel_bniva           = "checked=\"\"";
        		$channel_bniva_set       = Tools::safeOutput(Tools::getValue('CHANNEL_BNIVA', Configuration::get('CHANNEL_BNIVA')));
        		if ( empty($channel_bniva_set) || intval($channel_bniva_set) == 0 ) $channel_bniva = "";
        		
        		$channel_sinarmasva      = "checked=\"\"";
        		$channel_sinarmasva_set  = Tools::safeOutput(Tools::getValue('CHANNEL_SINARMASVA', Configuration::get('CHANNEL_SINARMASVA')));
        		if ( empty($channel_sinarmasva_set) || intval($channel_sinarmasva_set) == 0 ) $channel_sinarmasva = "";
        		
        		$channel_muamalatib      = "checked=\"\"";
        		$channel_muamalatib_set  = Tools::safeOutput(Tools::getValue('CHANNEL_MUAMALATIB', Configuration::get('CHANNEL_MUAMALATIB')));
        		if ( empty($channel_muamalatib_set) || intval($channel_muamalatib_set) == 0 ) $channel_muamalatib = "";
        		
        		$channel_danamonib       = "checked=\"\"";
        		$channel_danamonib_set   = Tools::safeOutput(Tools::getValue('CHANNEL_DANAMONIB', Configuration::get('CHANNEL_DANAMONIB')));
        		if ( empty($channel_danamonib_set) || intval($channel_danamonib_set) == 0 ) $channel_danamonib = "";
        		
        		$channel_permatanet      = "checked=\"\"";
        		$channel_permatanet_set  = Tools::safeOutput(Tools::getValue('CHANNEL_PERMATANET', Configuration::get('CHANNEL_PERMATANET')));
        		if ( empty($channel_permatanet_set) || intval($channel_permatanet_set) == 0 ) $channel_permatanet = "";
        		
        		$channel_cimbclicks      = "checked=\"\"";
        		$channel_cimbclicks_set  = Tools::safeOutput(Tools::getValue('CHANNEL_CIMBCLICKS', Configuration::get('CHANNEL_CIMBCLICKS')));
        		if ( empty($channel_cimbclicks_set) || intval($channel_cimbclicks_set) == 0 ) $channel_cimbclicks = "";
        		
        		$channel_bniyap          = "checked=\"\"";
        		$channel_bniyap_set      = Tools::safeOutput(Tools::getValue('CHANNEL_BNIYAP', Configuration::get('CHANNEL_BNIYAP')));
        		if ( empty($channel_bniyap_set) || intval($channel_bniyap_set) == 0 ) $channel_bniyap = "";

				$channel_cc_tokenization = "checked=\"\"";
				$channel_cc_tokenization_set          = Tools::safeOutput(Tools::getValue('CHANNEL_CC_TOKENIZATION', Configuration::get('CHANNEL_CC_TOKENIZATION')));
				if ( empty($channel_cc_tokenization_set) || intval($channel_cc_tokenization_set) == 0 ) $channel_cc_tokenization = "";				

				$channel_dokuwallet      = "checked=\"\"";
				$channel_dokuwallet_set  = Tools::safeOutput(Tools::getValue('CHANNEL_DOKUWALLET', Configuration::get('CHANNEL_DOKUWALLET')));
				if ( empty($channel_dokuwallet_set) || intval($channel_dokuwallet_set) == 0 ) $channel_dokuwallet = "";				

				$channel_clickpay        = "checked=\"\"";
				$channel_clickpay_set    = Tools::safeOutput(Tools::getValue('CHANNEL_CLICKPAY', Configuration::get('CHANNEL_CLICKPAY')));
				if ( empty($channel_clickpay_set) || intval($channel_clickpay_set) == 0 ) $channel_clickpay = "";				

				$channel_bri             = "checked=\"\"";
				$channel_bri_set         = Tools::safeOutput(Tools::getValue('CHANNEL_BRI', Configuration::get('CHANNEL_BRI')));
				if ( empty($channel_bri_set) || intval($channel_bri_set) == 0 ) $channel_bri = "";
				
				$channel_klikbca         = "checked=\"\"";
				$channel_klikbca_set     = Tools::safeOutput(Tools::getValue('CHANNEL_KLIKBCA', Configuration::get('CHANNEL_KLIKBCA')));
				if ( empty($channel_klikbca_set) || intval($channel_klikbca_set) == 0 ) $channel_klikbca = "";				
				
				$channel_atm             = "checked=\"\"";
				$channel_atm_set         = Tools::safeOutput(Tools::getValue('CHANNEL_ATM', Configuration::get('CHANNEL_ATM')));
				if ( empty($channel_atm_set) || intval($channel_atm_set) == 0 ) $channel_atm = "";
				
				$channel_atm_bca         = "checked=\"\"";
				$channel_atm_bca_set     = Tools::safeOutput(Tools::getValue('CHANNEL_ATM_BCA', Configuration::get('CHANNEL_ATM_BCA')));
				if ( empty($channel_atm_bca_set) || intval($channel_atm_bca_set) == 0 ) $channel_atm_bca = "";								

				$channel_atm_mandiri         = "checked=\"\"";
				$channel_atm_mandiri_set     = Tools::safeOutput(Tools::getValue('CHANNEL_ATM_MANDIRI', Configuration::get('CHANNEL_ATM_MANDIRI')));
				if ( empty($channel_atm_mandiri_set) || intval($channel_atm_mandiri_set) == 0 ) $channel_atm_mandiri = "";								

				$channel_store             = "checked=\"\"";
				$channel_store_set         = Tools::safeOutput(Tools::getValue('CHANNEL_STORE', Configuration::get('CHANNEL_STORE')));
				if ( empty($channel_store_set) || intval($channel_store_set) == 0 ) $channel_store = "";

				$channel_indomaret         = "checked=\"\"";
				$channel_indomaret_set     = Tools::safeOutput(Tools::getValue('CHANNEL_INDOMARET', Configuration::get('CHANNEL_INDOMARET')));
				if ( empty($channel_indomaret_set) || intval($channel_indomaret_set) == 0 ) $channel_indomaret = "";
				
				$channel_kredivo           = "checked=\"\"";
				$channel_kredivo_set       = Tools::safeOutput(Tools::getValue('CHANNEL_KREDIVO', Configuration::get('CHANNEL_KREDIVO')));
				if ( empty($channel_kredivo_set) || intval($channel_kredivo_set) == 0 ) $channel_kredivo = "";

				$server_dest = Tools::safeOutput(Tools::getValue('SERVER_DEST', Configuration::get('SERVER_DEST')));
				
				if ( empty($server_dest) || intval($server_dest) == 0 )
				{
						$select_option = '<option value="0" selected>Development</option>
															<option value="1">Production</option>';
				}
				else
				{
						$select_option = '<option value="0">Development</option>
															<option value="1" selected>Production</option>';				
				}

				$channel_option = Tools::safeOutput(Tools::getValue('CHANNEL_OPTION', Configuration::get('CHANNEL_OPTION')));
				
				if ( empty($channel_option) || intval($channel_option) == 0 )
				{
						$select_channel_option = '<option value="0" selected>In DOKU</option>
															        <option value="1">In Store</option>';
				}
				else
				{
						$select_channel_option = '<option value="0">In DOKU</option>
															        <option value="1" selected>In Store</option>';				
				}				
								
        // form configuration
        $this->_html .=
        '<style>
						.dokupresta td {
								padding-top: 5px;
								padding-bottom: 5px;
								padding-right: 5px;
						}
				</style>
				
				<form name="dokuonecheckout_config" id="dokuonecheckout_config" action="'.Tools::htmlentitiesUTF8($_SERVER['REQUEST_URI']).'" onsubmit="return FormValidation()" method="post">
             <fieldset>
                <legend><img src="../img/admin/contact.gif" />'.$this->l('Configuration details').'</legend>
                <table border="0" width="1000" cellpadding="2" cellspacing="2" id="form" class="dokupresta">
										<tr>
												<td colspan="4"><h2>'.$this->l('DOKU Payment Gateway Module Configuration').'</h2></td>
										</tr>
										<tr><td colspan="4"><hr /></td></tr>
                    <tr>
                        <td width="200">'.$this->l('* Server Destination').'</td>
												<td width="5">:</td>
                        <td>
														<select name="server_dest">
														'.$select_option.'
														</select>                            
                        </td>
                        <td>* Choose Server Destination</td>
                    </tr>
                    <tr>
                        <td>'.$this->l('* Mall ID Development').'</td>
												<td>:</td>
                        <td>
                            <input type="text" name="mall_id_dev" value="'.Tools::safeOutput(Tools::getValue('MALL_ID_DEV', Configuration::get('MALL_ID_DEV'))).'" />
                        </td>
                        <td>* Input your Development Mall ID.</td>
                    </tr>										
                    <tr>
                        <td>'.$this->l('* Shared Key Development').'</td>
												<td>:</td>
                        <td>
                            <input type="text" name="shared_key_dev" value="'.Tools::safeOutput(Tools::getValue('SHARED_KEY_DEV', Configuration::get('SHARED_KEY_DEV'))).'" />
                        </td>
                        <td>* Input your Development Shared Key.</td>
                    </tr>
                    <tr>
                        <td>'.$this->l('* Chain Development').'</td>
												<td>:</td>
                        <td>
                            <input type="text" name="chain_dev" value="'.$chain_dev_set.'" />
                        </td>
                        <td>* Input your Development Chain.</td>
                    </tr>
                    <tr>
                        <td>'.$this->l('* Mall ID Production').'</td>
												<td>:</td>
                        <td>
                            <input type="text" name="mall_id_prod" value="'.Tools::safeOutput(Tools::getValue('MALL_ID_PROD', Configuration::get('MALL_ID_PROD'))).'" />
                        </td>
                        <td>* Input your Production Mall ID.</td>
                    </tr>										
                    <tr>
                        <td>'.$this->l('* Shared Key Production').'</td>
												<td>:</td>
                        <td>
                            <input type="text" name="shared_key_prod" value="'.Tools::safeOutput(Tools::getValue('SHARED_KEY_PROD', Configuration::get('SHARED_KEY_PROD'))).'" />
                        </td>
                        <td>* Input your Production Shared Key.</td>
                    </tr>
                    <tr>
                        <td>'.$this->l('* Chain Production').'</td>
												<td>:</td>
                        <td>
                            <input type="text" name="chain_prod" value="'.$chain_prod_set.'" />
                        </td>
                        <td>* Input your Production Chain.</td>
                    </tr>
                    <tr>
                        <td>'.$this->l('Use EDU').'</td>
												<td>:</td>
                        <td>
												    <input type="checkbox" name="use_edu" value="1" '.$use_edu.'>
                        </td>
                        <td>Are you using DOKU EDU Services? Unchecked if you unsure.</td>
                    </tr>
                    <tr>
                        <td>'.$this->l('Use Identify').'</td>
												<td>:</td>
                        <td>
                            <input type="checkbox" name="use_identify" value="1" '.$use_identify.'>
                        </td>
                        <td>Are you using Identify? Unchecked if you unsure.</td>
                    </tr>
                    <tr>
                        <td>'.$this->l('DOKU Payment Name').'</td>
												<td>:</td>
                        <td>
                            <input type="text" name="doku_name" size="40" value="'.$name_set.'" />
                        </td>
                        <td>* Payment name to be displayed when checkout.</td>
                    </tr>
                    <tr>
                        <td>'.$this->l('DOKU Description').'</td>
												<td>:</td>
                        <td>
                            <input type="text" name="doku_description" size="40" value="'.$description_set.'" />
                        </td>
                        <td>* Payment description to be displayed when checkout.</td>
                    </tr>										
										<tr><td colspan="4"><hr /></td></tr>
                    <tr>
                        <td>'.$this->l('Use Installment').'</td>
												<td>:</td>
                        <td>
                            <input type="checkbox" name="use_installment" value="1" '.$use_installment.'">
                            <input type="hidden" name="use_installment_offus" value="1" '.$use_installment_offus.'">

                        </td>
                        <td>Are you using Installment feature? Unchecked if you unsure.</td>
                    </tr>																			
                    <tr>
                        <td>'.$this->l('Minimal Installment Value').'</td>
												<td>:</td>
                        <td>
                            <input type="text" name="min_installment" size="10" value="'.$min_installment_set.'">
                        </td>
                        <td>If you are using Installment, what is minimal amount to use Installment?</td>
                    </tr>
										<tr>
												<td colspan="4">
												<table border="0" width="900" cellpadding="2" cellspacing="2" id="form" style="margin-top: 20px; margin-left: 20px;">
												<tr align="left">
														<td width="50">'.$this->l('BNI').'</td>
														<td width="5">:</td>
														<td width="50">
																<input type="checkbox" name="bni_installment" value="1" '.$bni_installment.'">
														</td>
														<td width="350">
																TENOR <input type="text" name="bni_installment_tenor" size="20" value="'.Tools::safeOutput(Tools::getValue('BNI_INSTALLMENT_TENOR', Configuration::get('BNI_INSTALLMENT_TENOR'))).'"> example : 03,06,09,12															
														</td>
														<td>
																PROMO ID <input type="text" name="bni_installment_plan" size="10" value="'.Tools::safeOutput(Tools::getValue('BNI_INSTALLMENT_PLAN', Configuration::get('BNI_INSTALLMENT_PLAN'))).'"> example : 001
														</td>
														<td></td>
												</tr>
												<tr align="left">
														<td>'.$this->l('Mandiri').'</td>
														<td>:</td>
														<td>
																<input type="checkbox" name="mandiri_installment" value="1" '.$mandiri_installment.'">
														</td>
														<td>
																TENOR <input type="text" name="mandiri_installment_tenor" size="20" value="'.Tools::safeOutput(Tools::getValue('MANDIRI_INSTALLMENT_TENOR', Configuration::get('MANDIRI_INSTALLMENT_TENOR'))).'"> example : 03,06,09,12
														</td>
														<td>
																<!--
																PROMO ID <input type="text" name="mandiri_installment_plan" size="10" value="'.Tools::safeOutput(Tools::getValue('MANDIRI_INSTALLMENT_PLAN', Configuration::get('MANDIRI_INSTALLMENT_PLAN'))).'"> example : 003,006
																-->																
														</td>
														<td></td>
												</tr>												
												</table>
												</td>
										</tr>
										<tr><td colspan="4"><hr /></td></tr>
					<tr>
                        <td>'.$this->l('Use Klikpay BCA').'</td>
												<td>:</td>
                        <td>
                            <input type="checkbox" name="use_klikpaybca" value="1" '.$use_klikpaybca.'">
                        </td>
                        <td>Are you using Klikpay BCA? Unchecked if you unsure.</td>
                    </tr>		
                    <tr><td colspan="4"><hr /></td></tr>																	
                    <tr>
                        <td>'.$this->l('Show Payment Channel Option').'</td>
												<td>:</td>
                        <td>
														<select name="channel_option" style="width: 150px;">
														'.$select_channel_option.'
														</select>                            
                        </td>
                        <td></td>
                    </tr>			
										<tr>
												<td colspan="4">
												<table border="0" width="700" cellpadding="2" cellspacing="2" id="form" style="margin-top: 20px; margin-left: 20px;">
												<tr align="left">
														<td colspan="3"><b>'.$this->l('If Select "In Store", choose Payment Channel to show').'</b></td>
												</tr>
												<tr align="left">
														<td width="200">'.$this->l('Credit Card').'</td>
														<td width="5">:</td>
														<td width="200">
																<input type="checkbox" name="channel_cc" value="1" '.$channel_cc.'">
														</td>
												</tr>										
												<tr align="left">
														<td width="50">'.$this->l('Dokuwallet').'</td>
														<td width="5">:</td>
														<td width="50">
																<input type="checkbox" name="channel_dokuwallet" value="1" '.$channel_dokuwallet.'">
														</td>
												</tr>																						
												<tr align="left">
														<td>'.$this->l('Mandiri Clickpay').'</td>
														<td>:</td>
														<td>
																<input type="checkbox" name="channel_clickpay" value="1" '.$channel_clickpay.'">
														</td>
												</tr>
												<tr align="left">
														<td>'.$this->l('ePay BRI').'</td>
														<td>:</td>
														<td>
																<input type="checkbox" name="channel_bri" value="1" '.$channel_bri.'">
														</td>
												</tr>											
												<tr align="left">
														<td>'.$this->l('ATM Transfer Permata VA').'</td>
														<td>:</td>
														<td>
																<input type="checkbox" name="channel_atm" value="1" '.$channel_atm.'">
														</td>
												</tr>
												<tr align="left">
														<td>'.$this->l('ATM Transfer BCA VA').'</td>
														<td>:</td>
														<td>
																<input type="checkbox" name="channel_atm_bca" value="1" '.$channel_atm_bca.'">
														</td>
												</tr>												
												<tr align="left">
														<td>'.$this->l('ATM Transfer MANDIRI VA').'</td>
														<td>:</td>
														<td>
																<input type="checkbox" name="channel_atm_mandiri" value="1" '.$channel_atm_mandiri.'">
														</td>
												</tr>												
												<tr align="left">
														<td>'.$this->l('Convenience Store ALFA Group').'</td>
														<td>:</td>
														<td>
																<input type="checkbox" name="channel_store" value="1" '.$channel_store.'">
														</td>
												</tr>
												<tr align="left">
														<td>'.$this->l('Convenience Store Indomaret').'</td>
														<td>:</td>
														<td>
																<input type="checkbox" name="channel_indomaret" value="1" '.$channel_indomaret.'">
														</td>
												</tr>
												    
												    <tr align="left">
                       								     <td width="50">'.$this->l('ATM Transfer BRI').'</td>
                       								     <td width="5">:</td>
                       								     <td width="50">
                       								         <input type="checkbox" name="channel_briva" value="1" '.$channel_briva.'">
                       								     </td>
                       								 </tr>                                           
								
                       								 <tr align="left">
                       								     <td width="50">'.$this->l('ATM Transfer CIMB NIAGA').'</td>
                       								     <td width="5">:</td>
                       								     <td width="50">
                       								         <input type="checkbox" name="channel_cimbva" value="1" '.$channel_cimbva.'">
                       								     </td>
                       								 </tr>                                           
								
                       								 <tr align="left">
                       								     <td width="50">'.$this->l('ATM Transfer Danamon').'</td>
                       								     <td width="5">:</td>
                       								     <td width="50">
                       								         <input type="checkbox" name="channel_danamonva" value="1" '.$channel_danamonva.'">
                       								     </td>
                       								 </tr>                                           
								
                       								 <tr align="left">
                       								     <td width="50">'.$this->l('ATM Transfer QNB').'</td>
                       								     <td width="5">:</td>
                       								     <td width="50">
                       								         <input type="checkbox" name="channel_qnbva" value="1" '.$channel_qnbva.'">
                       								     </td>
                       								 </tr>                                           
								
                       								 <tr align="left">
                       								     <td width="50">'.$this->l('ATM Transfer BTN').'</td>
                       								     <td width="5">:</td>
                       								     <td width="50">
                       								         <input type="checkbox" name="channel_btnva" value="1" '.$channel_btnva.'">
                       								     </td>
                       								 </tr>                                           
								
                       								 <tr align="left">
                       								     <td width="50">'.$this->l('ATM Transfer BNI').'</td>
                       								     <td width="5">:</td>
                       								     <td width="50">
                       								         <input type="checkbox" name="channel_bniva" value="1" '.$channel_bniva.'">
                       								     </td>
                       								 </tr>                                           
								
                       								 <tr align="left">
                       								     <td width="50">'.$this->l('ATM Transfer Maybank').'</td>
                       								     <td width="5">:</td>
                       								     <td width="50">
                       								         <input type="checkbox" name="channel_maybankva" value="1" '.$channel_maybankva.'">
                       								     </td>
                       								 </tr>                                           
								
                       								 <tr align="left">
                       								     <td width="50">'.$this->l('ATM Transfer Sinarmas').'</td>
                       								     <td width="5">:</td>
                       								     <td width="50">
                       								         <input type="checkbox" name="channel_sinarmasva" value="1" '.$channel_sinarmasva.'">
                       								     </td>
                       								 </tr>                                           
								
                       								 <tr align="left">
                       								     <td width="50">'.$this->l('Muamalat Internet Banking').'</td>
                       								     <td width="5">:</td>
                       								     <td width="50">
                       								         <input type="checkbox" name="channel_muamalatib" value="1" '.$channel_muamalatib.'">
                       								     </td>
                       								 </tr>                                           
								
                       								 <tr align="left">
                       								     <td width="50">'.$this->l('Permatanet Internet Banking').'</td>
                       								     <td width="5">:</td>
                       								     <td width="50">
                       								         <input type="checkbox" name="channel_permatanet" value="1" '.$channel_permatanet.'">
                       								     </td>
                       								 </tr>                                           
								
                       								 <tr align="left">
                       								     <td width="50">'.$this->l('Cimb Clicks').'</td>
                       								     <td width="5">:</td>
                       								     <td width="50">
                       								         <input type="checkbox" name="channel_cimbclicks" value="1" '.$channel_cimbclicks.'">
                       								     </td>
                       								 </tr>                                           
								
                       								 <tr align="left">
                       								     <td width="50">'.$this->l('Danamon Internet Banking').'</td>
                       								     <td width="5">:</td>
                       								     <td width="50">
                       								         <input type="checkbox" name="channel_danamonib" value="1" '.$channel_danamonib.'">
                       								     </td>
                       								 </tr>
								
                       								 <tr align="left">
                       								     <td width="50">'.$this->l('BNI YAP!').'</td>
                       								     <td width="5">:</td>
                       								     <td width="50">
                       								         <input type="checkbox" name="channel_bniyap" value="1" '.$channel_bniyap.'">
                       								     </td>
                       								 </tr>   
												<tr align="left">
														<td>'.$this->l('Kredivo').'</td>
														<td>:</td>
														<td>
																<input type="checkbox" name="channel_kredivo" value="1" '.$channel_kredivo.'">
														</td>
												</tr>
												                    <tr>
                        <td>'.$this->l('* Mall ID Kredivo').'</td>
												<td>:</td>
                        <td>
                            <input type="text" name="mall_id_kredivo" value="'.Tools::safeOutput(Tools::getValue('MALL_ID_KREDIVO', Configuration::get('MALL_ID_KREDIVO'))).'" />
                        </td>
                        <td>* Input your Kredivo Mall ID.</td>
                    </tr>										
                    <tr>
                        <td>'.$this->l('* Shared Key Kredivo').'</td>
												<td>:</td>
                        <td>
                            <input type="text" name="shared_key_kredivo" value="'.Tools::safeOutput(Tools::getValue('SHARED_KEY_KREDIVO', Configuration::get('SHARED_KEY_KREDIVO'))).'" />
                        </td>
                        <td>* Input your Kredivo Shared Key.</td>
                    </tr>
                    <tr>
                        <td>'.$this->l('* Chain Kredivo').'</td>
												<td>:</td>
                        <td>
                            <input type="text" name="chain_id_kredivo" value="'.Tools::safeOutput(Tools::getValue('CHAIN_ID_KREDIVO', Configuration::get('CHAIN_ID_KREDIVO'))).'" />
                        </td>
                        <td>* Input your Kredivo Chain.</td>
                    </tr>
                    <tr>
                        <td>'.$this->l('* Mall ID BNIVA').'</td>
                                                <td>:</td>
                        <td>
                            <input type="text" name="mall_id_bniva" value="'.Tools::safeOutput(Tools::getValue('MALL_ID_BNIVA', Configuration::get('MALL_ID_BNIVA'))).'" />
                        </td>
                        <td>* Input your BNIVA Mall ID.</td>
                    </tr>                                       
                    <tr>
                        <td>'.$this->l('* Shared Key BNIVA').'</td>
                                                <td>:</td>
                        <td>
                            <input type="text" name="shared_key_bniva" value="'.Tools::safeOutput(Tools::getValue('SHARED_KEY_BNIVA', Configuration::get('SHARED_KEY_BNIVA'))).'" />
                        </td>
                        <td>* Input your BNIVA Shared Key.</td>
                    </tr>
                    <tr>
                        <td>'.$this->l('* Chain BNIVA').'</td>
                                                <td>:</td>
                        <td>
                            <input type="text" name="chain_id_bniva" value="'.Tools::safeOutput(Tools::getValue('CHAIN_ID_BNIVA', Configuration::get('CHAIN_ID_BNIVA'))).'" />
                        </td>
                        <td>* Input your BNIVA Chain.</td>
                    </tr>
                    <tr>
                        <td>'.$this->l('* Mall ID SINARMASVA').'</td>
                                                <td>:</td>
                        <td>
                            <input type="text" name="mall_id_sinarmasva" value="'.Tools::safeOutput(Tools::getValue('MALL_ID_SINARMASVA', Configuration::get('MALL_ID_SINARMASVA'))).'" />
                        </td>
                        <td>* Input your SINARMASVA Mall ID.</td>
                    </tr>                                       
                    <tr>
                        <td>'.$this->l('* Shared Key SINARMASVA').'</td>
                                                <td>:</td>
                        <td>
                            <input type="text" name="shared_key_sinarmasva" value="'.Tools::safeOutput(Tools::getValue('SHARED_KEY_SINARMASVA', Configuration::get('SHARED_KEY_SINARMASVA'))).'" />
                        </td>
                        <td>* Input your SINARMASVA Shared Key.</td>
                    </tr>
                    <tr>
                        <td>'.$this->l('* Chain SINARMASVA').'</td>
                                                <td>:</td>
                        <td>
                            <input type="text" name="chain_id_sinarmasva" value="'.Tools::safeOutput(Tools::getValue('CHAIN_ID_SINARMASVA', Configuration::get('CHAIN_ID_SINARMASVA'))).'" />
                        </td>
                        <td>* Input your SINARMASVA Chain.</td>
                    </tr>
                    <tr>
                        <td>'.$this->l('* Mall ID KLIKPAYBCA').'</td>
                                                <td>:</td>
                        <td>
                            <input type="text" name="mall_id_klikpaybca" value="'.Tools::safeOutput(Tools::getValue('MALL_ID_KLIKPAYBCA', Configuration::get('MALL_ID_KLIKPAYBCA'))).'" />
                        </td>
                        <td>* Input your KLIKPAYBCA Mall ID.</td>
                    </tr>                                       
                    <tr>
                        <td>'.$this->l('* Shared Key KLIKPAYBCA').'</td>
                                                <td>:</td>
                        <td>
                            <input type="text" name="shared_key_klikpaybca" value="'.Tools::safeOutput(Tools::getValue('SHARED_KEY_KLIKPAYBCA', Configuration::get('SHARED_KEY_KLIKPAYBCA'))).'" />
                        </td>
                        <td>* Input your KLIKPAYBCA Shared Key.</td>
                    </tr>
                    <tr>
                        <td>'.$this->l('* Chain KLIKPAYBCA').'</td>
                                                <td>:</td>
                        <td>
                            <input type="text" name="chain_id_klikpaybca" value="'.Tools::safeOutput(Tools::getValue('CHAIN_ID_KLIKPAYBCA', Configuration::get('CHAIN_ID_KLIKPAYBCA'))).'" />
                        </td>
                        <td>* Input your KLIKPAYBCA Chain.</td>
                    </tr>

												</table>
												</td>												
										<tr><td colspan="4"><hr /></td></tr>
                    <tr>
												<td colspan="4"><input class="button" name="btnSubmit" value="'.$this->l('Update settings').'" type="submit" /></td>
										</tr>
                    <tr>
                        <td style="vertical-align: top;"></td>
                        <td colspan ="3" style="padding-bottom:15px;"></td>
                    </tr>
                    <tr>
                        <td><strong>'.$this->l('IDENTIFY URL').'</strong></td>
                        <td colspan ="3">'.$myservername.'modules/dokuonecheckout/request.php?task=identify</td>
                    </tr>
                    <tr>
                        <td><strong>'.$this->l('NOTIFY URL').'</strong></td>
                        <td colspan ="3">'.$myservername.'modules/dokuonecheckout/request.php?task=notify</td>
                    </tr>
                    <tr>
                        <td><strong>'.$this->l('REDIRECT URL').'</strong></td>
                        <td colspan ="3">'.$myservername.'index.php?fc=module&module=dokuonecheckout&controller=request&task=redirect</td>
                    </tr>
                    <tr>
                        <td><strong>'.$this->l('REVIEW URL').'</strong></td>
                        <td colspan ="3">'.$myservername.'modules/dokuonecheckout/request.php?task=review</td>
                    </tr>
                </table>
            </fieldset>
        </form>';
    }

    public function getContent()
    {
        $this->_html = '<h2>'.$this->displayName.'</h2>';

        if (Tools::isSubmit('btnSubmit'))
        {
            $this->_postValidation();
            if (!sizeof($this->_postErrors))
						{
                $this->_postProcess();
						}
            else
						{
                foreach ($this->_postErrors as $err)
								{
                    $this->_html .= '<div class="alert error">'. $err .'</div>';
								}
						}
        }
        else
				{
            $this->_html .= '<br />';
				}

        $this->_displayForm();

        return $this->_html;
    }

    public function execPayment($cart)
    {
        if (!$this->active)
            return;

        $basket='';
        global $cookie,$smarty;

        $dokuonecheckout = new dokuonecheckout();
        $cart            = new Cart(intval($cookie->id_cart));
        $address         = new Address(intval($cart->id_address_invoice));
        $country         = new Country(intval($address->id_country));
        $state           = NULL;
        if ($address->id_state)
            $state       = new State(intval($address->id_state));
        $customer        = new Customer(intval($cart->id_customer));
        $currency_order  = new Currency(intval($cart->id_currency));
        $products        = $cart->getProducts();        
        $summarydetail   = $cart->getSummaryDetails();
               
        $i = 0;
        $basket = '';
        
        foreach($products as $product)
        {
            $name_wt1  = preg_replace("/([^a-zA-Z0-9.\-=:&% ]+)/", " ", $product['name']);
            $name_wt = str_replace(',', '-', $name_wt1);
            $price_wt = number_format($product['price_wt'],2,'.','');
            $total_wt = number_format($product['total_wt'],2,'.','');

            $basket .= $name_wt . ',' ;
            $basket .= $price_wt . ',' ;
            $basket .= $product['cart_quantity'] . ',';
            $basket .= $total_wt .';' ;            
        }
		        
				# Discount
        if ( $summarydetail['total_discounts'] > 0)
				{ 
						$nDiskon =    number_format($summarydetail['total_discounts'],2,'.','');
						$nMinus  = -1 * $nDiskon ;
           
						$basket .= 'Total Discount ,';
            $basket .=  $nMinus . ',';
            $basket .=  '1,';
            $basket .=  $nMinus . ';';
        }
        
				# Shipping
				if ( $summarydetail['total_shipping'] > 0)
				{ 
						$basket .= 'Shipping Cost ,';
						$basket .=  number_format($summarydetail['total_shipping'],2,'.','') . ',';
						$basket .=  '1,';
						$basket .=  number_format($summarydetail['total_shipping'],2,'.','') . ';';
				}
		
				# REMARK TAX FROM BASKET, SEEM ALREADY INCLUDE ON PRODUCT PRICE	
				# Tax
				/*
				if ( $summarydetail['total_tax'] > 0)
				{ 
						$basket .= 'Total Tax ,';
						$basket .=  number_format($summarydetail['total_tax'],2,'.','') . ',';
						$basket .=  '1,';
						$basket .=  number_format($summarydetail['total_tax'],2,'.','') . ';';
				}
				*/

				# Gift Wrapping		
				if ( $summarydetail['total_wrapping'] > 0)
				{ 
						$basket .= 'Gift Wrapping ,';
						$basket .=  number_format($summarydetail['total_wrapping'],2,'.','') . ',';
						$basket .=  '1,';
						$basket .=  number_format($summarydetail['total_wrapping'],2,'.','') . ';';
				}

				# $basket = preg_replace("/([^a-zA-Z0-9.\-,=:;&% ]+)/", " ", $basket); // move to product process
				
        $total = number_format(floatval(number_format($cart->getOrderTotal(true, 3), 2, '.', '')),2,'.','');
				
				$this->total_amount = intval($total);
		
				# REMARK TAX FROM BASKET, SEEM ALREADY INCLUDE ON PRODUCT PRICE
				/*
				if ( $summarydetail['total_tax'] > 0)
				{ 
					$total = number_format($total + $summarydetail['total_tax'], 2, '.','');
				}
				*/								
				
        $order       = new Order($dokuonecheckout->currentOrder);
				$server_dest = Tools::safeOutput(Configuration::get('SERVER_DEST'));
				
				if ( empty($server_dest) || intval($server_dest) == 0 )
				{
						$MALL_ID     = Tools::safeOutput(Configuration::get('MALL_ID_DEV'));
						$SHARED_KEY  = Tools::safeOutput(Configuration::get('SHARED_KEY_DEV'));
						$CHAIN       = Tools::safeOutput(Configuration::get('CHAIN_DEV'));
						$URL				 = "https://staging.doku.com/Suite/Receive";
                        $URL_MERCHANTHOSTED = "https://staging.doku.com/api/payment/DoGeneratePaycodeVA";
				}
				else
				{
						$MALL_ID     = Tools::safeOutput(Configuration::get('MALL_ID_PROD'));
						$SHARED_KEY  = Tools::safeOutput(Configuration::get('SHARED_KEY_PROD'));
						$CHAIN       = Tools::safeOutput(Configuration::get('CHAIN_PROD'));
						$URL				 = "https://pay.doku.com/Suite/Receive";
                        $URL_MERCHANTHOSTED = "https://pay.doku.com/api/payment/DoGeneratePaycodeVA";
				}

				
				# Set Redirect Parameter
				$CURRENCY            = 360;
				$TRANSIDMERCHANT     = intval($cart->id);
				$NAME                = Tools::safeOutput($address->firstname . ' ' . $address->lastname);
				$EMAIL               = $customer->email;
				$ADDRESS             = Tools::safeOutput($address->address1 . ' ' . $address->address2);
				$CITY                = Tools::safeOutput($address->city);
				$ZIPCODE             = Tools::safeOutput($address->postcode);
				$STATE               = Tools::safeOutput($state->name);
				$MALL_ID_KREDIVO     = Tools::safeOutput(Configuration::get('MALL_ID_KREDIVO'));
				$SHARED_KEY_KREDIVO  = Tools::safeOutput(Configuration::get('SHARED_KEY_KREDIVO'));
				$CHAIN_ID_KREDIVO    = Tools::safeOutput(Configuration::get('CHAIN_ID_KREDIVO'));
                $MALL_ID_BNIVA       = Tools::safeOutput(Configuration::get('MALL_ID_BNIVA'));
                $SHARED_KEY_BNIVA    = Tools::safeOutput(Configuration::get('SHARED_KEY_BNIVA'));
                $CHAIN_ID_BNIVA      = Tools::safeOutput(Configuration::get('CHAIN_ID_BNIVA'));
                $MALL_ID_SINARMASVA  = Tools::safeOutput(Configuration::get('MALL_ID_SINARMASVA'));
                $SHARED_KEY_SINARMASVA  = Tools::safeOutput(Configuration::get('SHARED_KEY_SINARMASVA'));
                $CHAIN_ID_SINARMASVA    = Tools::safeOutput(Configuration::get('CHAIN_ID_SINARMASVA'));
                $MALL_ID_KLIKPAYBCA     = Tools::safeOutput(Configuration::get('MALL_ID_KLIKPAYBCA'));
                $SHARED_KEY_KLIKPAYBCA  = Tools::safeOutput(Configuration::get('SHARED_KEY_KLIKPAYBCA'));
                $CHAIN_ID_KLIKPAYBCA    = Tools::safeOutput(Configuration::get('CHAIN_ID_KLIKPAYBCA'));
				$REQUEST_DATETIME    = date("YmdHis");
				$IP_ADDRESS          = $this->getipaddress();
				$PROCESS_DATETIME    = date("Y-m-d H:i:s");
				$PROCESS_TYPE        = "REQUEST";
				$AMOUNT              = $total;
				$PHONE               = trim($address->phone_mobile);
				$PAYMENT_CHANNEL     = "";
				$SESSION_ID          = "";
				$WORDS               = sha1(trim($AMOUNT).
																		trim($MALL_ID).
																		trim($SHARED_KEY).
																		trim($TRANSIDMERCHANT));							
				$WORDS_MERCHANTHOSTED= sha1(trim($AMOUNT).
                                                                        trim($MALL_ID).
                                                                        trim($SHARED_KEY).
                                                                        trim($TRANSIDMERCHANT).
                                                                        trim($CURRENCY));                            
                $WORDS_KREDIVO       = sha1(trim($AMOUNT).
																		trim($MALL_ID_KREDIVO).
																		trim($SHARED_KEY_KREDIVO).
																		trim($TRANSIDMERCHANT));	
                $WORDS_BNIVA       = sha1(trim($AMOUNT).
                                                                        trim($MALL_ID_BNIVA).
                                                                        trim($SHARED_KEY_BNIVA).
                                                                        trim($TRANSIDMERCHANT).
                                                                        trim($CURRENCY));    
                $WORDS_SINARMASVA       = sha1(trim($AMOUNT).
                                                                        trim($MALL_ID_SINARMASVA).
                                                                        trim($SHARED_KEY_SINARMASVA).
                                                                        trim($TRANSIDMERCHANT).
                                                                        trim($CURRENCY));    
                $WORDS_KLIKPAYBCA       = sha1(trim($AMOUNT).
                                                                        trim($MALL_ID_KLIKPAYBCA).
                                                                        trim($SHARED_KEY_KLIKPAYBCA).
                                                                        trim($TRANSIDMERCHANT)); 

				$USE_KLIKPAYBCA      = Tools::safeOutput(Configuration::get('USE_KLIKPAYBCA'));
				$USE_TOKENIZATION    = Tools::safeOutput(Configuration::get('USE_TOKENIZATION'));
				$CHANNEL_KREDIVO     = Tools::safeOutput(Configuration::get('CHANNEL_KREDIVO'));
                $CHANNEL_BNIVA       = Tools::safeOutput(Configuration::get('CHANNEL_BNIVA'));
                $CHANNEL_SINARMASVA  = Tools::safeOutput(Configuration::get('CHANNEL_SINARMASVA'));
				$CHANNEL_BNIYAP      = Tools::safeOutput(Configuration::get('CHANNEL_BNIYAP'));
						
																		
				$SMARTY_ARRAY = 	array(
															'this_path'        		=> $this->_path,
															'this_path_ssl'    		=> Configuration::get('PS_FO_PROTOCOL').$_SERVER['HTTP_HOST'].__PS_BASE_URI__."modules/{$this->name}/",
															'payment_name'     		=> Configuration::get('DOKU_NAME'),
															'payment_description' 	=> Configuration::get('DOKU_DESCRIPTION'),
															'URL'			   		=> $URL,
															'MALLID'           		=> $MALL_ID,
															'CHAINMERCHANT'    		=> $CHAIN,
															'AMOUNT'           		=> $AMOUNT,
															'PURCHASEAMOUNT'   		=> $AMOUNT,
															'TRANSIDMERCHANT'  		=> $TRANSIDMERCHANT,
															'WORDS'            		=> $WORDS,
															'REQUESTDATETIME'  		=> $REQUEST_DATETIME,
															'CURRENCY'         		=> $CURRENCY,
															'PURCHASECURRENCY' 		=> $CURRENCY,
															'SESSIONID'        		=> $WORDS,
															'PAYMENTCHANNEL'   		=> $PAYMENT_CHANNEL,
															'NAME'             		=> $NAME,
															'EMAIL'            		=> $EMAIL,
															'HOMEPHONE'        		=> $PHONE,
															'MOBILEPHONE'      		=> $PHONE,
															'BASKET'           		=> $basket,
															'ADDRESS'          		=> $ADDRESS,
															'CITY'             		=> $CITY,
															'STATE'            		=> $STATE,
															'ZIPCODE'          		=> $ZIPCODE,
															'SHIPPING_ZIPCODE' 		=> $ZIPCODE,
															'SHIPPING_CITY'    		=> $CITY,
															'SHIPPING_ADDRESS' 		=> $ADDRESS,
															'SHIPPING_COUNTRY' 		=> 'ID',
															'MALL_ID_KREDIVO'  		=> $MALL_ID_KREDIVO,
															'CHAIN_ID_KREDIVO' 		=> $CHAIN_ID_KREDIVO,
															'WORDS_KREDIVO'    		=> $WORDS_KREDIVO,
                                                            'MALL_ID_BNIVA'         => $MALL_ID_BNIVA,
                                                            'CHAIN_ID_BNIVA'        => $CHAIN_ID_BNIVA,
                                                            'WORDS_BNIVA'           => $WORDS_BNIVA,
                                                            'MALL_ID_SINARMASVA'    => $MALL_ID_SINARMASVA,
                                                            'CHAIN_ID_SINARMASVA'   => $CHAIN_ID_SINARMASVA,
                                                            'WORDS_SINARMASVA'      => $WORDS_SINARMASVA,
                                                            'MALL_ID_KLIKPAYBCA'    => $MALL_ID_KLIKPAYBCA,
                                                            'CHAIN_ID_KLIKPAYBCA'   => $CHAIN_ID_KLIKPAYBCA,
                                                            'WORDS_KLIKPAYBCA'      => $WORDS_KLIKPAYBCA,
                                                            'WORDS_MERCHANTHOSTED'  => $WORDS_MERCHANTHOSTED,
															'USE_KLIKPAYBCA'		=> $USE_KLIKPAYBCA,
															'USE_TOKENIZATION'		=> $USE_TOKENIZATION,
															'CHANNEL_KREDIVO'       => $CHANNEL_KREDIVO,
                                                            'CHANNEL_BNIVA'         => $CHANNEL_BNIVA,
                                                            'CHANNEL_SINARMASVA'    => $CHANNEL_SINARMASVA,
             												'CHANNEL_BNIYAP'        => $CHANNEL_BNIYAP,
                                                            'URL_MERCHANTHOSTED'	=> $URL_MERCHANTHOSTED			



													);

				$USE_INSTALLMENT_OFFUS = Tools::safeOutput(Configuration::get('USE_INSTALLMENT_OFFUS'));
				if ( intval($USE_INSTALLMENT_OFFUS) > 0 )
				{
					$configarray = parse_ini_file("config_doku.ini");
					$bank=$configarray['bank'];
					$arr_bank = explode(",", $bank);


					foreach ($arr_bank as $bank) 
					{
					$bank_tenor = $configarray[$bank];
					$arr_tenor = explode (",",$bank_tenor);
					$bank_plan = $bank." PLAN";
					$bank_plan_id =$configarray[$bank_plan];
					$acq_code = $configarray['acquirercode'];
					foreach ($arr_tenor as $tenor)
					{
						switch ($tenor) 
						{
										case "03":
										$INSTALLMENT_OFFUS_DISPLAY .= "<ul><input type=\"radio\" name=\"PAYMENTCHANNEL\" value=\"15\" onclick=\"setInstallmentOffus03('$bank_plan_id')\"> ".$bank." Installment 3 Months</ul>\r\n";
										break;

										case "06":
										$INSTALLMENT_OFFUS_DISPLAY .= "<ul><input type=\"radio\" name=\"PAYMENTCHANNEL\" value=\"15\" onclick=\"setInstallmentOffus06('$bank_plan_id')\"> ".$bank." Installment 6 Months</ul>\r\n";
										break;

										case "09":
										$INSTALLMENT_OFFUS_DISPLAY .= "<ul><input type=\"radio\" name=\"PAYMENTCHANNEL\" value=\"15\" onclick=\"setInstallmentOffus09('$bank_plan_id')\"> ".$bank." Installment 9 Months</ul>\r\n";
										break;

										case "12":
										$INSTALLMENT_OFFUS_DISPLAY .= "<ul><input type=\"radio\" name=\"PAYMENTCHANNEL\" value=\"15\" onclick=\"setInstallmentOffus12('$bank_plan_id')\"> ".$bank." Installment 12 Months</ul>\r\n";
										break;					
						}
					}
				}

				}

				$USE_INSTALLMENT = Tools::safeOutput(Configuration::get('USE_INSTALLMENT'));
				if ( intval($USE_INSTALLMENT) > 0 )
				{		
						$USE_TOKENIZATION          = Tools::safeOutput(Configuration::get('USE_TOKENIZATION'));
						$MIN_INSTALLMENT           = Tools::safeOutput(Configuration::get('MIN_INSTALLMENT'));
						$BNI_INSTALLMENT           = Tools::safeOutput(Configuration::get('BNI_INSTALLMENT'));
						$BNI_INSTALLMENT_PLAN      = Tools::safeOutput(Configuration::get('BNI_INSTALLMENT_PLAN'));
						$MANDIRI_INSTALLMENT       = Tools::safeOutput(Configuration::get('MANDIRI_INSTALLMENT'));
						$MANDIRI_INSTALLMENT_TENOR = Tools::safeOutput(Configuration::get('MANDIRI_INSTALLMENT_TENOR'));
						
						$BNI_INSTALLMENT_TENOR   = Tools::safeOutput(Configuration::get('BNI_INSTALLMENT_TENOR'));
						$bni_tenor               = explode(",", $BNI_INSTALLMENT_TENOR);
						$BNI_INSTALLMENT_DISPLAY = "";

						foreach ( $bni_tenor as $tenor )
						{
								switch ( $tenor )
								{
										case "03":
										$BNI_INSTALLMENT_DISPLAY .= "<ul><input type=\"radio\" name=\"PAYMENTCHANNEL\" value=\"15\" onclick=\"setBNIPROMOID('$tenor')\"> BNI Installment 3 Months</ul>\r\n";
										break;

										case "06":
										$BNI_INSTALLMENT_DISPLAY .= "<ul><input type=\"radio\" name=\"PAYMENTCHANNEL\" value=\"15\" onclick=\"setBNIPROMOID('$tenor')\"> BNI Installment 6 Months</ul>\r\n";
										break;

										case "09":
										$BNI_INSTALLMENT_DISPLAY .= "<ul><input type=\"radio\" name=\"PAYMENTCHANNEL\" value=\"15\" onclick=\"setBNIPROMOID('$tenor')\"> BNI Installment 9 Months</ul>\r\n";
										break;

										case "12":
										$BNI_INSTALLMENT_DISPLAY .= "<ul><input type=\"radio\" name=\"PAYMENTCHANNEL\" value=\"15\" onclick=\"setBNIPROMOID('$tenor')\"> BNI Installment 12 Months</ul>\r\n";
										break;										
								}
						}

						$MANDIRI_INSTALLMENT_TENOR   = Tools::safeOutput(Configuration::get('MANDIRI_INSTALLMENT_TENOR'));
						$mandiri_tenor               = explode(",", $MANDIRI_INSTALLMENT_TENOR);
						$MANDIRI_INSTALLMENT_DISPLAY = "";
						foreach ( $mandiri_tenor as $tenor )
						{
								switch ( $tenor )
								{
										case "03":
										$MANDIRI_INSTALLMENT_DISPLAY .= "<ul><input type=\"radio\" name=\"PAYMENTCHANNEL\" value=\"15\" onclick=\"setMandiriPROMOID('$tenor')\"> Mandiri Installment 3 Months</ul>\r\n";
										break;

										case "06":
										$MANDIRI_INSTALLMENT_DISPLAY .= "<ul><input type=\"radio\" name=\"PAYMENTCHANNEL\" value=\"$15\" onclick=\"setMandiriPROMOID('$tenor')\"> Mandiri Installment 6 Months</ul>\r\n";
										break;

										case "09":
										$MANDIRI_INSTALLMENT_DISPLAY .= "<ul><input type=\"radio\" name=\"PAYMENTCHANNEL\" value=\"$15\" onclick=\"setMandiriPROMOID('$tenor')\"> Mandiri Installment 9 Months</ul>\r\n";
										break;

										case "12":
										$MANDIRI_INSTALLMENT_DISPLAY .= "<ul><input type=\"radio\" name=\"PAYMENTCHANNEL\" value=\"$15\" onclick=\"setMandiriPROMOID('$tenor')\"> Mandiri Installment 12 Months</ul>\r\n";
										break;										
								}
						}
						
						$ARRAY_INSTALLMENT = array (
								'USE_TOKENIZATION'	     		 => $USE_TOKENIZATION,
								'ACQUIRERCODE'		 	         => $acq_code,
								'USE_INSTALLMENT_OFFUS'		     => $USE_INSTALLMENT_OFFUS,
								'INSTALLMENT_OFFUS_DISPLAY'		 => $INSTALLMENT_OFFUS_DISPLAY,
								'MIN_INSTALLMENT'                => $MIN_INSTALLMENT,
								'BNI_INSTALLMENT'                => $BNI_INSTALLMENT,
								'BNI_INSTALLMENT_PLAN'           => $BNI_INSTALLMENT_PLAN,
								'BNI_INSTALLMENT_DISPLAY'        => $BNI_INSTALLMENT_DISPLAY,
								'MANDIRI_INSTALLMENT'            => $MANDIRI_INSTALLMENT,
								'MANDIRI_INSTALLMENT_DISPLAY'    => $MANDIRI_INSTALLMENT_DISPLAY
						);
						
						$SMARTY_ARRAY = array_merge( $SMARTY_ARRAY, $ARRAY_INSTALLMENT );
				}				

				$CHANNEL_OPTION = Tools::safeOutput(Configuration::get('CHANNEL_OPTION'));
				if ( intval($CHANNEL_OPTION) > 0 )
				{
						$CHANNEL_CC                = Tools::safeOutput(Configuration::get('CHANNEL_CC'));
						$CHANNEL_DOKUWALLET        = Tools::safeOutput(Configuration::get('CHANNEL_DOKUWALLET'));
						$CHANNEL_CLICKPAY          = Tools::safeOutput(Configuration::get('CHANNEL_CLICKPAY'));
						$CHANNEL_BRI               = Tools::safeOutput(Configuration::get('CHANNEL_BRI'));
						$CHANNEL_KLIKBCA           = Tools::safeOutput(Configuration::get('CHANNEL_KLIKBCA'));
						$CHANNEL_ATM               = Tools::safeOutput(Configuration::get('CHANNEL_ATM'));
						$CHANNEL_ATM_BCA           = Tools::safeOutput(Configuration::get('CHANNEL_ATM_BCA'));
						$CHANNEL_ATM_MANDIRI       = Tools::safeOutput(Configuration::get('CHANNEL_ATM_MANDIRI'));
						$CHANNEL_STORE             = Tools::safeOutput(Configuration::get('CHANNEL_STORE'));
						$CHANNEL_INDOMARET         = Tools::safeOutput(Configuration::get('CHANNEL_INDOMARET'));
						$CHANNEL_KREDIVO           = Tools::safeOutput(Configuration::get('CHANNEL_KREDIVO'));
           				$CHANNEL_BRIVA             = Tools::safeOutput(Configuration::get('CHANNEL_BRIVA'));
           				$CHANNEL_CIMBVA            = Tools::safeOutput(Configuration::get('CHANNEL_CIMBVA'));
           				$CHANNEL_DANAMONVA         = Tools::safeOutput(Configuration::get('CHANNEL_DANAMONVA'));
           				$CHANNEL_QNBVA             = Tools::safeOutput(Configuration::get('CHANNEL_QNBVA'));
           				$CHANNEL_BTNVA             = Tools::safeOutput(Configuration::get('CHANNEL_BTNVA'));
           				$CHANNEL_MAYBANKVA         = Tools::safeOutput(Configuration::get('CHANNEL_MAYBANKVA'));
           				$CHANNEL_BNIVA             = Tools::safeOutput(Configuration::get('CHANNEL_BNIVA'));
           				$CHANNEL_SINARMASVA        = Tools::safeOutput(Configuration::get('CHANNEL_SINARMASVA'));
           				$CHANNEL_MUAMALATIB        = Tools::safeOutput(Configuration::get('CHANNEL_MUAMALATIB'));
           				$CHANNEL_DANAMONIB         = Tools::safeOutput(Configuration::get('CHANNEL_DANAMONIB'));
           				$CHANNEL_PERMATANET        = Tools::safeOutput(Configuration::get('CHANNEL_PERMATANET'));
           				$CHANNEL_CIMBCLICKS        = Tools::safeOutput(Configuration::get('CHANNEL_CIMBCLICKS'));
           				$CHANNEL_BNIYAP            = Tools::safeOutput(Configuration::get('CHANNEL_BNIYAP'));	

						$ARRAY_CHANNEL = array (
								'CHANNEL_CC'                     => $CHANNEL_CC,
								'CHANNEL_DOKUWALLET'             => $CHANNEL_DOKUWALLET,
								'CHANNEL_CLICKPAY'               => $CHANNEL_CLICKPAY,
								'CHANNEL_BRI'                    => $CHANNEL_BRI,
								'CHANNEL_KLIKBCA'                => $CHANNEL_KLIKBCA,
								'CHANNEL_ATM'                    => $CHANNEL_ATM,
								'CHANNEL_ATM_BCA'                => $CHANNEL_ATM_BCA,
								'CHANNEL_ATM_MANDIRI'            => $CHANNEL_ATM_MANDIRI,
								'CHANNEL_STORE'                  => $CHANNEL_STORE,
								'CHANNEL_INDOMARET'              => $CHANNEL_INDOMARET,
             					'CHANNEL_BRIVA'                  => $CHANNEL_BRIVA,     
             					'CHANNEL_CIMBVA'                 => $CHANNEL_CIMBVA,
             					'CHANNEL_DANAMONVA'              => $CHANNEL_DANAMONVA,
             					'CHANNEL_QNBVA'                  => $CHANNEL_QNBVA,
             					'CHANNEL_BTNVA'                  => $CHANNEL_BTNVA,
             					'CHANNEL_MAYBANKVA'              => $CHANNEL_MAYBANKVA,
             					'CHANNEL_BNIVA'                  => $CHANNEL_BNIVA,
             					'CHANNEL_SINARMASVA'             => $CHANNEL_SINARMASVA,
             					'CHANNEL_MUAMALATIB'             => $CHANNEL_MUAMALATIB,
             					'CHANNEL_DANAMONIB'              => $CHANNEL_DANAMONIB,
             					'CHANNEL_PERMATANET'             => $CHANNEL_PERMATANET,
             					'CHANNEL_CIMBCLICKS'             => $CHANNEL_CIMBCLICKS,
								'CHANNEL_KREDIVO'                => $CHANNEL_KREDIVO,
             					'CHANNEL_BNIYAP'                 => $CHANNEL_BNIYAP								
						);						
						
						$SMARTY_ARRAY = array_merge( $SMARTY_ARRAY, $ARRAY_CHANNEL );
				}				
													
				$smarty->assign( $SMARTY_ARRAY );

				$trx['ip_address']          = $IP_ADDRESS;
				$trx['process_type']        = $PROCESS_TYPE;
				$trx['process_datetime']    = $PROCESS_DATETIME;
				$trx['transidmerchant']     = $TRANSIDMERCHANT;
				$trx['amount']              = $AMOUNT;
				$trx['session_id']          = $WORDS;
				$trx['words']               = $WORDS;
				$trx['message']             = "Transaction request start";
				$trx['raw_post_data']		= http_build_query($SMARTY_ARRAY,'','&');
							
				$this->add_dokuonecheckout($trx);
			
    }

    function hookPayment($params)
    {
        if (!$this->active)
            return;

				$cart = new Cart(intval($cookie->id_cart));
				
				$this->execPayment($cart);		
						
				$USE_INSTALLMENT = Tools::safeOutput(Configuration::get('USE_INSTALLMENT'));
				$MIN_INSTALLMENT = Tools::safeOutput(Configuration::get('MIN_INSTALLMENT'));
				$CHANNEL_OPTION  = Tools::safeOutput(Configuration::get('CHANNEL_OPTION'));
				$CHANNEL_CC      = Tools::safeOutput(Configuration::get('CHANNEL_CC'));
				$USE_TOKENIZATION      = Tools::safeOutput(Configuration::get('USE_TOKENIZATION'));
				$TOTAL_AMOUNT    = $this->total_amount;
				
				# channel 0 in DOKU, channel 1 in Store
				switch ( true )
				{
						case ( intval($CHANNEL_OPTION) == 0 && intval($USE_INSTALLMENT) == 1 && $TOTAL_AMOUNT > $MIN_INSTALLMENT ) :
						return $this->display(__FILE__, 'views/templates/hook/payment_channel_installment.tpl');
						break;

						case ( intval($CHANNEL_OPTION) == 1 && intval($USE_INSTALLMENT) == 1 && intval($CHANNEL_CC) == 1 && $TOTAL_AMOUNT > $MIN_INSTALLMENT ) :
						return $this->display(__FILE__, 'views/templates/hook/payment_channel_installment.tpl');
						break;						

						case ( intval($CHANNEL_OPTION) == 1 && intval($USE_INSTALLMENT) == 0 ) :
						return $this->display(__FILE__, 'views/templates/hook/payment_channel.tpl');
						break;												
						
						default:
						return $this->display(__FILE__, 'views/templates/hook/payment.tpl');
						break;
				}
    }
	
		function getServerConfig()
		{
				$server_dest = Tools::safeOutput(Configuration::get('SERVER_DEST'));
				
				if ( empty($server_dest) || intval($server_dest) == 0 )
				{
						$MALL_ID    = Tools::safeOutput(Configuration::get('MALL_ID_DEV'));
						$SHARED_KEY = Tools::safeOutput(Configuration::get('SHARED_KEY_DEV'));
						$CHAIN      = Tools::safeOutput(Configuration::get('CHAIN_DEV'));				
						$URL_CHECK  = "https://staging.doku.com/Suite/CheckStatus";						
				}
				else
				{
						$MALL_ID    = Tools::safeOutput(Configuration::get('MALL_ID_PROD'));
						$SHARED_KEY = Tools::safeOutput(Configuration::get('SHARED_KEY_PROD'));
						$CHAIN      = Tools::safeOutput(Configuration::get('CHAIN_PROD'));						
						$URL_CHECK  = "https://pay.doku.com/Suite/CheckStatus";						
				}
						
				$USE_EDU      = Tools::safeOutput(Configuration::get('USE_EDU'));
				$USE_IDENTIFY = Tools::safeOutput(Configuration::get('USE_IDENTIFY'));
				
				$DOKU_AWAITING_PAYMENT = Tools::safeOutput(Configuration::get('DOKU_AWAITING_PAYMENT'));
				$DOKU_PAYMENT_STATUS_PENDING = Tools::safeOutput(Configuration::get('DOKU_PAYMENT_STATUS_PENDING'));
				$DOKU_PAYMENT_STATUS_PENDING_EMAIL = Tools::safeOutput(Configuration::get('DOKU_PAYMENT_STATUS_PENDING_EMAIL'));
				$DOKU_WAIT_FOR_VERIFICATION = Tools::safeOutput(Configuration::get('DOKU_WAIT_FOR_VERIFICATION'));
				$DOKU_PAYMENT_FAILED = Tools::safeOutput(Configuration::get('DOKU_PAYMENT_FAILED'));								
						
				$config = array( "MALL_ID" => $MALL_ID, 
						         "SHARED_KEY" => $SHARED_KEY,
						         "CHAIN" => $CHAIN,
						         "USE_EDU" => $USE_EDU,
						         "USE_IDENTIFY" => $USE_IDENTIFY,
						         "URL_CHECK" => $URL_CHECK,
						         "DOKU_AWAITING_PAYMENT" => $DOKU_AWAITING_PAYMENT,
						         "DOKU_PAYMENT_STATUS_PENDING" => $DOKU_PAYMENT_STATUS_PENDING,
						         "DOKU_PAYMENT_STATUS_PENDING_EMAIL" => $DOKU_PAYMENT_STATUS_PENDING_EMAIL,
						         "DOKU_WAIT_FOR_VERIFICATION" => $DOKU_WAIT_FOR_VERIFICATION,
						         "DOKU_PAYMENT_FAILED" => $DOKU_PAYMENT_FAILED
						         );   
							
				return $config;
		}

		function addDOKUOrderStatus()
		{
				$stateConfig = array();
				try {
						$stateConfig['color'] = '#00ff00';
						$this->addOrderStatus(
								'DOKU_AWAITING_PAYMENT',
								'Awaiting DOKU Payment',
								$stateConfig,
								false,
								''
						);        
						$stateConfig['color'] = 'blue';
						$this->addOrderStatus(
								'DOKU_PAYMENT_STATUS_PENDING',
								'DOKU Payment Pending',
								$stateConfig,
								false,
								''
						);
						$stateConfig['color'] = '#00ffff';
						$this->addOrderStatus(
								'DOKU_PAYMENT_STATUS_PENDING_EMAIL',
								'DOKU Payment Pending Email',
								$stateConfig,
								true,
								'doku_payment_code'
						);						
						$stateConfig['color'] = 'blue';
						$this->addOrderStatus(
								'DOKU_WAIT_FOR_VERIFICATION',
								'Wait for DOKU Verification',
								$stateConfig,
								true,
								'doku_payment_verification'
						);
						$stateConfig['color'] = 'red';
						$this->addOrderStatus(
								'DOKU_PAYMENT_FAILED',
								'DOKU Payment Failed',
								$stateConfig,
								true,
								'doku_payment_failed'
						);
						return true;
				} catch (Exception $exception) {
						return false;
				}
		}
		
		function addOrderStatus($configKey, $statusName, $stateConfig, $send_email, $template)
		{
				if (!Configuration::get($configKey)) {
						$orderState = new OrderState();
						$orderState->name = array();
						$orderState->module_name = $this->name;
						$orderState->send_email = $send_email;
						$orderState->color = $stateConfig['color'];
						$orderState->hidden = false;
						$orderState->delivery = false;
						$orderState->logable = true;
						$orderState->invoice = false;
						$orderState->paid = false;

            foreach (Language::getLanguages() as $language) {
                $orderState->template[$language['id_lang']] = $template;
                $orderState->name[$language['id_lang']] = $statusName;
            }
						
						if ($orderState->add()) {
								$dokuIcon = dirname(__FILE__).'/logo.png';
								$newStateIcon = dirname(__FILE__).'/../../img/os/'.(int)$orderState->id.'.gif';
								copy($dokuIcon, $newStateIcon);
						}
		
						$order_state_id = (int)$orderState->id;
				}
				else
				{
						$order_state_id = Tools::safeOutput(Configuration::get($configKey));
				}
				
				Configuration::updateValue($configKey, $order_state_id);
		}		

		function copyEmailFiles()
		{
				$folderSource = dirname(__FILE__).'/mail';
				$folderDestination = _PS_ROOT_DIR_.'/mails/en';

				$files = glob($folderSource."/*.*");
				
				foreach($files as $file)
				{
						$file_to_go = str_replace($folderSource, $folderDestination, $file);
						copy($file, $file_to_go);
				}			
		}
		
		function deleteOrderState($id_order_state)
		{		
				$orderState = new OrderState($id_order_state);        
				$orderState->delete();		
		}
		
    function getipaddress()    
    {
        if (!empty($_SERVER['HTTP_CLIENT_IP']))
        {
            $ip=$_SERVER['HTTP_CLIENT_IP'];
        }
        elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))
        {
            $ip=$_SERVER['HTTP_X_FORWARDED_FOR'];
        }
        else
        {
            $ip=$_SERVER['REMOTE_ADDR'];
        }

        return $ip;
    }

		function checkTrx($trx, $process='REQUEST', $result_msg='')
		{
				$db = Db::getInstance();
				
				$db_prefix = _DB_PREFIX_;
				
				if ( $result_msg == "PENDING" ) return 0;
				
				$check_result_msg = "";
				if ( !empty($result_msg) )
				{
					$check_result_msg = " AND result_msg = '$result_msg'";
				}
							
				$db->Execute("SELECT * FROM ".$db_prefix."dokuonecheckout" .
										 " WHERE process_type = '$process'" .
										 $check_result_msg.
										 " AND transidmerchant = '" . $trx['transidmerchant'] . "'" .
										 " AND amount = '". $trx['amount'] . "'".
										 " AND session_id = '". $trx['session_id'] . "'" );        
					
				return $db->numRows();
		}		

    function add_dokuonecheckout($datainsert) 
    {
				$db = Db::getInstance();
				
				$db_prefix = _DB_PREFIX_;
				
        $SQL = "";
        
        foreach ( $datainsert as $field_name=>$field_data )
        {
            $SQL .= " $field_name = '$field_data',";
        }
        $SQL = substr( $SQL, 0, -1 );

        $db->Execute("INSERT INTO " . $db_prefix . "dokuonecheckout SET $SQL");
    }

		function getCheckStatusList($trx='')
		{
				$db = Db::getInstance();
				
				$db_prefix = _DB_PREFIX_;
			
				$query = "";
				if ( !empty($trx) )
				{
						$query  = " AND transidmerchant = '".$trx['transidmerchant']."'";
						$query .= " AND amount = '". $trx['amount'] . "'";
						$query .= " AND session_id = '". $trx['session_id'] . "'";
				}
				else
				{
						$query  = " AND check_status = 0";
				}
				
				$resultQuery = $db->executeS(	"SELECT * FROM ".$db_prefix."dokuonecheckout" .
																			" WHERE process_type = 'REQUEST'" .
																			$query.
																			" AND count_check_status < 3" .
																			" ORDER BY trx_id DESC LIMIT 1" );
				$result = $resultQuery[0];
				
				if ( empty($result) )
				{
						return 0;
				}
				else
				{
						return $result;
				}
		}			

		function updateCountCheckStatusTrx($trx)
		{
				$db = Db::getInstance();
				
				$db_prefix = _DB_PREFIX_;
				
				$db->Execute("UPDATE ".$db_prefix."dokuonecheckout" .
										 " SET count_check_status = count_check_status + 1,".
										 " check_status = 0".
										 " WHERE process_type = 'REQUEST'" .
										 " AND transidmerchant = '" . $trx['transidmerchant'] . "'" .
										 " AND amount = '". $trx['amount'] . "'".
										 " AND session_id = '". $trx['session_id'] . "'" );        
		}

		function bcaklikpaycode($trx)
		{
				$db = Db::getInstance();
				
				$db_prefix = _DB_PREFIX_;
				
				$db->Execute("UPDATE ".$db_prefix."dokuonecheckout" .
										 " SET bcaklikpaycode = '" . $trx['bcaklikpaycode'] . "'".
										 " WHERE transidmerchant = '" . $trx['transidmerchant'] . "'" .
										 " AND amount = '". $trx['amount'] . "'".
										 " AND session_id = '". $trx['session_id'] . "'" );        
		}			
		
		function doku_check_status($transaction)
		{
				$config = $this->getServerConfig();
				$result = $this->getCheckStatusList($transaction);
				
				if ( $result == 0 )
				{
						return "FAILED";
				}

				$trx     = $result;
				
				$words   = sha1( 	trim($config['MALL_ID']).
													trim($config['SHARED_KEY']).
													trim($trx['transidmerchant']) );
														
				$data = "MALLID=".$config['MALL_ID']."&CHAINMERCHANT=".$config['CHAIN']."&TRANSIDMERCHANT=".$trx['transidmerchant']."&SESSIONID=".$trx['session_id']."&PAYMENTCHANNEL=&WORDS=".$words;
				
				$ch = curl_init();
				curl_setopt($ch, CURLOPT_URL, $config['URL_CHECK']);
				curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 20); 
				curl_setopt($ch, CURLOPT_HEADER, false);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
				curl_setopt($ch, CURLOPT_POST, true);        
				curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
				$output = curl_exec($ch);
				$curl_errno = curl_errno($ch);
				$curl_error = curl_error($ch);
				curl_close($ch);        
				
				if ($curl_errno > 0)
				{
						#return "Stop : Connection Error";
				}             
				
				libxml_use_internal_errors(true);
				$xml = simplexml_load_string($output);
				
				if ( !$xml )
				{
						$this->updateCountCheckStatusTrx($transaction);
				}                
				else
				{
						$trx = array();
						$trx['ip_address']            = $this->getipaddress();
						$trx['process_type']          = "CHECKSTATUS";
						$trx['process_datetime']      = date("Y-m-d H:i:s");
						$trx['transidmerchant']       = (string) $xml->TRANSIDMERCHANT;
						$trx['amount']                = (string) $xml->AMOUNT;
						$trx['notify_type']           = (string) $xml->STATUSTYPE;
						$trx['response_code']         = (string) $xml->RESPONSECODE;
						$trx['result_msg']            = (string) $xml->RESULTMSG;
						$trx['approval_code']         = (string) $xml->APPROVALCODE;
						$trx['payment_channel']       = (string) $xml->PAYMENTCHANNEL;
						$trx['payment_code']          = (string) $xml->PAYMENTCODE;
						$trx['words']                 = (string) $xml->WORDS;
						$trx['session_id']            = (string) $xml->SESSIONID;
						$trx['bank_issuer']           = (string) $xml->BANK;
						$trx['creditcard']            = (string) $xml->MCN;
						$trx['verify_id']             = (string) $xml->VERIFYID;
						$trx['verify_score']          = (int) $xml->VERIFYSCORE;
						$trx['verify_status']         = (string) $xml->VERIFYSTATUS;            
						
						# Insert transaction check status to table onecheckout
						$this->add_dokuonecheckout($trx);
						
						return $xml->RESULTMSG;
				}		
		}		
		
		function emptybag()
		{	
				$products = $this->context->cart->getProducts();
				foreach ($products as $product) {
						$this->context->cart->deleteProduct($product["id_product"]);
				}
		}
	
    function get_order_id($cart_id) 
    {
				$db = Db::getInstance();
				
				$db_prefix = _DB_PREFIX_;				
				$SQL       = "SELECT id_order FROM " . $db_prefix . "orders WHERE id_cart = $cart_id";
				
				return $db->getValue($SQL);
		}

    function get_bcaklikpay_status($transactionid) 
    {
				$db = Db::getInstance();
				
				$db_prefix = _DB_PREFIX_;				
				$SQL       = "SELECT * FROM " . $db_prefix . "dokuonecheckout WHERE transidmerchant = $transactionid and response_code='0000'";
				
				return $db->getValue($SQL);
		}
	 
    function set_order_status($order_id, $state, $emaildata = array()) 
    {
				$objOrder = new Order($order_id);
				$history = new OrderHistory();
				$history->id_order = (int)$objOrder->id;
				$history->changeIdOrderState((int)$state, (int)($objOrder->id));
				$history->addWithemail(true, $emaildata);				
				$history->save();
    }	 
	 
}

?>