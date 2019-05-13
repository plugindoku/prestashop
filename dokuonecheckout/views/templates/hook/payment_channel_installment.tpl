<script type="text/javascript">
//		function checkChannel() {
//				var ischeck = ValidateInputs();
//				if ( ischeck ) {
//						var ischeckTENOR = ValidateInputsTENOR();
//						if ( ischeckTENOR ) {
//								return true;
//						}
//						else {
//								alert("Please choose Credit Card option to use!");
//								return false;								
//						}
//				}
//				else {
//						alert("Please choose Payment Channel to use!");
//						return false;
//				}
//		}

		function clearPROMOID(tenor) {
				document.formDokuOrder.PROMOID.value = '';
				document.formDokuOrder.INSTALLMENT_ACQUIRER.value = '';		
		}		
		
		function setInstallmentOffus03(tenor) {
			document.formDokuOrder.PROMOID.value = tenor;
			document.formDokuOrder.INSTALLMENT_ACQUIRER.value = '{$ACQUIRERCODE}';
			document.formDokuOrder.TENOR.value = '03';
			document.formDokuOrder.PAYMENTTYPE.value = 'OFFUSINSTALLMENT';
		}

		function setInstallmentOffus06(tenor) {
			document.formDokuOrder.PROMOID.value = tenor;
			document.formDokuOrder.INSTALLMENT_ACQUIRER.value = '{$ACQUIRERCODE}';
			document.formDokuOrder.TENOR.value = '06';
			document.formDokuOrder.PAYMENTTYPE.value = 'OFFUSINSTALLMENT';
		}

		function setInstallmentOffus09(tenor) {
			document.formDokuOrder.PROMOID.value = tenor;
			document.formDokuOrder.INSTALLMENT_ACQUIRER.value = '{$ACQUIRERCODE}';
			document.formDokuOrder.TENOR.value = '09';
			document.formDokuOrder.PAYMENTTYPE.value = 'OFFUSINSTALLMENT';
		}

		function setInstallmentOffus12(tenor) {
			document.formDokuOrder.PROMOID.value = tenor;
			document.formDokuOrder.INSTALLMENT_ACQUIRER.value = '{$ACQUIRERCODE}';
			document.formDokuOrder.TENOR.value = '12';
			document.formDokuOrder.PAYMENTTYPE.value = 'OFFUSINSTALLMENT';
		}

		function setBNIPROMOID(tenor) {
				switch (tenor) {
						case '03':
								document.formDokuOrder.PROMOID.value = '{$BNI_INSTALLMENT_PLAN}';
								document.formDokuOrder.INSTALLMENT_ACQUIRER.value = '100';
								document.formDokuOrder.TENOR.value = '03';
								document.formDokuOrder.PAYMENTTYPE.value = '';
						break;
						case '06':
								document.formDokuOrder.PROMOID.value = '{$BNI_INSTALLMENT_PLAN}';
								document.formDokuOrder.INSTALLMENT_ACQUIRER.value = '100';
								document.formDokuOrder.TENOR.value = '06';
								document.formDokuOrder.PAYMENTTYPE.value = '';
						break;
						case '09':
								document.formDokuOrder.PROMOID.value = '{$BNI_INSTALLMENT_PLAN}';
								document.formDokuOrder.INSTALLMENT_ACQUIRER.value = '100';
								document.formDokuOrder.TENOR.value = '09';
								document.formDokuOrder.PAYMENTTYPE.value = '';
						break;
						case '12':
								document.formDokuOrder.PROMOID.value = '{$BNI_INSTALLMENT_PLAN}';
								document.formDokuOrder.INSTALLMENT_ACQUIRER.value = '100';
								document.formDokuOrder.TENOR.value = '12';
								document.formDokuOrder.PAYMENTTYPE.value = '';
						break;
				} 				
		}

		function setMandiriPROMOID(tenor) {
				switch (tenor) {
						case '03':
								document.formDokuOrder.PROMOID.value = '003';
								document.formDokuOrder.INSTALLMENT_ACQUIRER.value = '300';
								document.formDokuOrder.TENOR.value = '03';
								document.formDokuOrder.PAYMENTTYPE.value = '';
						break;
						case '06':
								document.formDokuOrder.PROMOID.value = '006';
								document.formDokuOrder.INSTALLMENT_ACQUIRER.value = '300';
								document.formDokuOrder.TENOR.value = '06';
								document.formDokuOrder.PAYMENTTYPE.value = '';
						break;
						case '09':
								document.formDokuOrder.PROMOID.value = '009';
								document.formDokuOrder.INSTALLMENT_ACQUIRER.value = '300';
								document.formDokuOrder.TENOR.value = '09';
								document.formDokuOrder.PAYMENTTYPE.value = '';
						break;
						case '12':
								document.formDokuOrder.PROMOID.value = '012';
								document.formDokuOrder.INSTALLMENT_ACQUIRER.value = '300';
								document.formDokuOrder.TENOR.value = '12';
								document.formDokuOrder.PAYMENTTYPE.value = '';
						break;
				} 				
		}

				function channelKREDIVO() {
				document.formDokuOrder.MALLID.value = "{$MALL_ID_KREDIVO}";
			 	document.formDokuOrder.CHAINMERCHANT.value = "{$CHAIN_ID_KREDIVO}";
			 	document.formDokuOrder.WORDS.value = "{$WORDS_KREDIVO}";
			 	document.formDokuOrder.action = "{$URL}";
								document.formDokuOrder.PROMOID.value = '';
								document.formDokuOrder.INSTALLMENT_ACQUIRER.value = '';
								document.formDokuOrder.TENOR.value = '';
								document.formDokuOrder.PAYMENTTYPE.value = '';
			 }

			 function channel(){
			 	document.formDokuOrder.MALLID.value = "{$MALLID}";
			 	document.formDokuOrder.CHAINMERCHANT.value = "{$CHAINMERCHANT}";
			 	document.formDokuOrder.WORDS.value = "{$WORDS}";
			 	document.formDokuOrder.action = "{$URL}";
			 	document.formDokuOrder.CUSTOMERID.value = "{$EMAIL}";
								document.formDokuOrder.PROMOID.value = '';
								document.formDokuOrder.INSTALLMENT_ACQUIRER.value = '';
								document.formDokuOrder.TENOR.value = '';
								document.formDokuOrder.PAYMENTTYPE.value = '';
			
			 }

		function channelBCA(){
				document.formDokuOrder.MALLID.value = "{$MALL_ID_KLIKPAYBCA}";
			 	document.formDokuOrder.CHAINMERCHANT.value = "{$CHAIN_ID_KLIKPAYBCA}";
			 	document.formDokuOrder.WORDS.value = "{$WORDS_KLIKPAYBCA}";
				document.formDokuOrder.action = 'modules/dokuonecheckout/BCAKLIKPAY.php';
				document.formDokuOrder.CUSTOMERID.value = '{$URL}MIP';
				document.formDokuOrder.PAYMENTCHANNEL.value = '18';	
								document.formDokuOrder.PROMOID.value = '';
								document.formDokuOrder.INSTALLMENT_ACQUIRER.value = '';
								document.formDokuOrder.TENOR.value = '';
								document.formDokuOrder.PAYMENTTYPE.value = '';
			}
		function channelSINARMAS(){
				document.formDokuOrder.MALLID.value = "{$MALL_ID_SINARMASVA}";
			 	document.formDokuOrder.CHAINMERCHANT.value = "{$CHAIN_ID_SINARMASVA}";
			 	document.formDokuOrder.WORDS.value = "{$WORDS_SINARMASVA}";
				document.formDokuOrder.action = 'modules/dokuonecheckout/merchanthostedva.php';
				document.formDokuOrder.CUSTOMERID.value = '{$URL_MERCHANTHOSTED}';
				document.formDokuOrder.PAYMENTCHANNEL.value = '22';	
								document.formDokuOrder.PROMOID.value = '';
								document.formDokuOrder.INSTALLMENT_ACQUIRER.value = '';
								document.formDokuOrder.TENOR.value = '';
								document.formDokuOrder.PAYMENTTYPE.value = '';
			}
		function channelBNI(){
				document.formDokuOrder.MALLID.value = "{$MALL_ID_BNIVA}";
			 	document.formDokuOrder.CHAINMERCHANT.value = "{$CHAIN_ID_BNIVA}";
			 	document.formDokuOrder.WORDS.value = "{$WORDS_BNIVA}";
				document.formDokuOrder.action = 'modules/dokuonecheckout/merchanthostedva.php';
				document.formDokuOrder.CUSTOMERID.value = '{$URL_MERCHANTHOSTED}';
				document.formDokuOrder.PAYMENTCHANNEL.value = '38';	
								document.formDokuOrder.PROMOID.value = '';
								document.formDokuOrder.INSTALLMENT_ACQUIRER.value = '';
								document.formDokuOrder.TENOR.value = '';
								document.formDokuOrder.PAYMENTTYPE.value = '';
			}

		
		function ValidateInputs() {
				len = document.formDokuOrder.PAYMENTCHANNEL.length

				var x = false;
				for (i = 0; i <len; i++) {
						if (document.formDokuOrder.PAYMENTCHANNEL[i].checked) {
								var x = true;
						}
				}
				return x;
		}		
		
		function ValidateInputsTENOR() {
				len = document.formDokuOrder.TENOR.length

				var x = false;
				for (i = 0; i <len; i++) {
						if (document.formDokuOrder.TENOR[i].checked) {
								var x = true;
						}
				}
				return x;
		}				
</script>

<style>
.doku_payment_module {
    display: block;
		background-color: #FBFBFB;
    border: 1px solid #D6D4D4;
    border-radius: 4px;
    line-height: 23px;
    color: #333;
    padding: 0px 0px 20px 20px;
		margin-bottom: 10px;		
}

.doku_payment_module td {
		line-height: 15px;
}

.doku_payment_module_submit {
    border-radius: 10px;
    color: white;
    background-color: #c6122f;
}
</style>

<div class="doku_payment_module">
<form name="formDokuOrder" id="formDokuOrder" action="{$URL}" method="post">

		<table cellpadding="0" cellspacing="0" border="0" width="400">
				<tr>
						<td rowspan="2"><img src="{$this_path}logo.png" alt="{l s='Pay via DOKU' mod='dokuonecheckout'}"/></td>
						<td><b style="font-size: 20px;">{$payment_name}</b></td>
				</tr>
				<tr>
						<td>{$payment_description}</td>
				</tr>
		</table>
		
		<li style="list-style-type: none;">
								
		{if $BNI_INSTALLMENT eq 1}
			{$BNI_INSTALLMENT_DISPLAY}						
		{/if}
												
		{if $MANDIRI_INSTALLMENT eq 1}
			{$MANDIRI_INSTALLMENT_DISPLAY}
		{/if}
		
		{if $USE_INSTALLMENT_OFFUS eq 1}
			{$INSTALLMENT_OFFUS_DISPLAY}
		{/if}		
		
		{if $CHANNEL_CC eq 1}
		<ul>
					{if $USE_TOKENIZATION eq 1}
						<input type="radio" name="PAYMENTCHANNEL" value="16" onclick="return channel()"> Credit Card
						{else}
						<input type="radio" name="PAYMENTCHANNEL" value="15" onclick="return channel()"> Regular Credit Card
						{/if}
		</ul>
		{/if}
		
		{if $CHANNEL_DOKUWALLET eq 1}
				<ul><input type="radio" name="PAYMENTCHANNEL" value="04" onclick="return channel()"> Dokuwallet</ul>
		{/if}
		
		{if $CHANNEL_CLICKPAY eq 1}
				<ul><input type="radio" name="PAYMENTCHANNEL" value="02" onclick="return channel()"> Mandiri Clickpay</ul>
		{/if}	
		
		{if $CHANNEL_BRI eq 1}
				<ul><input type="radio" name="PAYMENTCHANNEL" value="06" onclick="return channel()"> ePay BRI</ul>
		{/if}			
		
		{if $CHANNEL_KLIKBCA eq 1}
				<ul><input type="radio" name="PAYMENTCHANNEL" value="03" onclick="return channel()"> Klik BCA</ul>
		{/if}					
		
		{if $CHANNEL_ATM eq 1}
				<ul><input type="radio" name="PAYMENTCHANNEL" value="36" onclick="return channel()"> ATM Transfer Permata VA</ul>
		{/if}
		
		{if $CHANNEL_ATM_MANDIRI eq 1}
				<ul><input type="radio" name="PAYMENTCHANNEL" value="41" onclick="return channel()"> ATM Transfer Mandiri VA</ul>
		{/if}
		
		{if $CHANNEL_ATM_BCA eq 1}
				<ul><input type="radio" name="PAYMENTCHANNEL" value="29" onclick="return channel()"> ATM Transfer BCA VA</ul>
		{/if}							

		{if $CHANNEL_STORE eq 1}
				<ul><input type="radio" name="PAYMENTCHANNEL" value="35" onclick="return channel()"> Convenience Store ALFA Group</ul>
		{/if}

		{if $CHANNEL_KREDIVO eq 1}
				<ul><input type="radio" name="PAYMENTCHANNEL" value="37" onclick="return channel()" > Kredivo</ul>
		{/if}							

		{if $CHANNEL_INDOMARET eq 1}
				<ul><input type="radio" name="PAYMENTCHANNEL" value="31" onclick="return channel()"> Convenience Store Indomaret</ul>
		{/if}							

		{if $USE_KLIKPAYBCA eq 1}
				<ul><input type="radio" name="PAYMENTCHANNEL" value="18" onclick="return channelBCA()"> BCA Klikpay</ul>
		{/if}	

		{if $CHANNEL_BRIVA eq 1}
    	    <ul><input type="radio" name="PAYMENTCHANNEL" value="34" onclick="return channel()"> ATM Transfer BRI VA</ul>
    	{/if}
	
    	{if $CHANNEL_CIMBVA eq 1}
    	    <ul><input type="radio" name="PAYMENTCHANNEL" value="32" onclick="return channel()"> ATM Transfer CIMB VA</ul>
    	{/if}
	
    	{if $CHANNEL_DANAMONVA eq 1}
    	    <ul><input type="radio" name="PAYMENTCHANNEL" value="33" onclick="return channel()"> ATM Transfer DANAMON VA</ul>
    	{/if}
	
    	{if $CHANNEL_QNBVA eq 1}
    	    <ul><input type="radio" name="PAYMENTCHANNEL" value="42" onclick="return channel()"> ATM Transfer QNB VA</ul>
    	{/if}
	
    	{if $CHANNEL_BTNVA eq 1}
    	    <ul><input type="radio" name="PAYMENTCHANNEL" value="43" onclick="return channel()"> ATM Transfer BTN VA</ul>
    	{/if}
	
    	{if $CHANNEL_MAYBANKVA eq 1}
    	    <ul><input type="radio" name="PAYMENTCHANNEL" value="44" onclick="return channel()"> ATM Transfer MAYBANK VA</ul>
    	{/if}
	
    	{if $CHANNEL_BNIVA eq 1}
    	    <ul><input type="radio" name="PAYMENTCHANNEL" value="38" onclick="return channelBNI()"> ATM Transfer BNI VA</ul>
    	{/if}
	
    	{if $CHANNEL_SINARMASVA eq 1}
    	    <ul><input type="radio" name="PAYMENTCHANNEL" value="22" onclick="return channelSINARMAS()"> ATM Transfer SINARMAS VA</ul>
    	{/if}
	
    	{if $CHANNEL_MUAMALATIB eq 1}
    	    <ul><input type="radio" name="PAYMENTCHANNEL" value="25" onclick="return channel()"> MUAMALAT IB</ul>
    	{/if}
	
    	{if $CHANNEL_DANAMONIB eq 1}
    	    <ul><input type="radio" name="PAYMENTCHANNEL" value="26" onclick="return channel()"> DANAMON IB</ul>
    	{/if}
	
    	{if $CHANNEL_PERMATANET eq 1}
    	    <ul><input type="radio" name="PAYMENTCHANNEL" value="28" onclick="return channel()"> PERMATANET IB</ul>
    	{/if}
	
    	{if $CHANNEL_CIMBCLICKS eq 1}
    	    <ul><input type="radio" name="PAYMENTCHANNEL" value="19" onclick="return channel()"> CIMB CLICKS</ul>
    	{/if}
	
    	{if $CHANNEL_BNIYAP eq 1}
    	    <ul><input type="radio" name="PAYMENTCHANNEL" value="45" onclick="return channel()"> BNI YAP!</ul>
    	{/if}
    			</li>
					
		<input type="hidden" name="CUSTOMERID" value="{$EMAIL}">		
		<input type="hidden" name="PAYMENTTYPE" value="">			
		<input type="hidden" name="PROMOID" value="">
		<input type="hidden" name="INSTALLMENT_ACQUIRER" value="">		
		<input type="hidden" name="TENOR" value="">		
	    <input type=hidden name="MALLID"           value="{$MALLID}">
		<input type=hidden name="CHAINMERCHANT"    value="{$CHAINMERCHANT}">
    	<input type=hidden name="TRANSIDMERCHANT"  value="{$TRANSIDMERCHANT}">
    	<input type=hidden name="AMOUNT"           value="{$AMOUNT}">
		<input type=hidden name="PURCHASEAMOUNT"   value="{$PURCHASEAMOUNT}">
	    <input type=hidden name="WORDS"            value="{$WORDS}">
    	<input type=hidden name="REQUESTDATETIME"  value="{$REQUESTDATETIME}">
    	<input type=hidden name="CURRENCY"         value="{$CURRENCY}">
	    <input type=hidden name="PURCHASECURRENCY" value="{$PURCHASECURRENCY}">				
    	<input type=hidden name="SESSIONID"        value="{$SESSIONID}">
    	<input type=hidden name="NAME"             value="{$NAME}">
		<input type=hidden name="EMAIL"            value="{$EMAIL}">		
	    <input type=hidden name="HOMEPHONE"        value="{$HOMEPHONE}">
    	<input type=hidden name="MOBILEPHONE"      value="{$MOBILEPHONE}"> 
    	<input type=hidden name="BASKET"           value="{$BASKET}">				
    	<input type=hidden name="ADDRESS"          value="{$ADDRESS}"> 
	  	<input type=hidden name="CITY"             value="{$CITY}"> 
    	<input type=hidden name="STATE"            value="{$STATE}"> 
    	<input type=hidden name="ZIPCODE"          value="{$ZIPCODE}"> 
	    <input type=hidden name="SHIPPING_COUNTRY" value="{$SHIPPING_COUNTRY}"> 
		<input type=hidden name="SHIPPING_ADDRESS" value="{$SHIPPING_ADDRESS}"> 
    	<input type=hidden name="SHIPPING_CITY"    value="{$SHIPPING_CITY}"> 
    	<input type=hidden name="SHIPPING_ZIPCODE" value="{$SHIPPING_ZIPCODE}"> 				
		<input type="submit" class="doku_payment_module_submit" value="PROCESS PAYMENT" onclick="return checkChannel();">
		
</form>
</div>