<script type="text/javascript">
		function checkChannel() {
				var ischeck = ValidateInputsTENOR();
				if ( ischeck ) {
						return true;
				}
				else {
						alert("Please choose Credit Card option to use!");
						return false;
				}
		}

		function clearPROMOID(tenor) {
				document.formDokuOrder.PROMOID.value = '';
				document.formDokuOrder.INSTALLMENT_ACQUIRER.value = '';		
				document.formDokuOrder.PAYMENTCHANNEL.value = '';		
				document.formDokuOrder.action = '{$URL}';
		}

		function clearPROMOIDKLIKPAYBCA(tenor) {
				document.formDokuOrder.PROMOID.value = '';
				document.formDokuOrder.INSTALLMENT_ACQUIRER.value = '';		
				document.formDokuOrder.action = 'modules/dokuonecheckout/BCAKLIKPAY.php';
				document.formDokuOrder.CUSTOMERID.value = '{$URL}MIP';
				document.formDokuOrder.PAYMENTCHANNEL.value = '18';		
		}

		function functionKLIKPAYBCA() {
				$.post( "/modules/dokuonecheckout/BCAKLIKPAY.php", { TRANSIDMERCHANT: "{$TRANSIDMERCHANT}", AMOUNT: "{$AMOUNT}" } );
				document.getElementById("formDokuOrder").submit();
		}


		function clearPROMOIDToken(tenor) {
				document.formDokuOrder.PROMOID.value = '';
				document.formDokuOrder.PAYMENTCHANNEL.value = '16';		
				document.formDokuOrder.INSTALLMENT_ACQUIRER.value = '';		
				document.formDokuOrder.PAYMENTCHANNEL.value = '';	
				document.formDokuOrder.action = '{$URL}';
	
		}

	    function setInstallmentOffus(tenor) {
			document.formDokuOrder.PROMOID.value = tenor;
			document.formDokuOrder.INSTALLMENT_ACQUIRER.value = '{$ACQUIRERCODE}';
			document.formDokuOrder.PAYMENTCHANNEL.value = '';	
			document.formDokuOrder.action = '{$URL}';	
		}

		
		function setBNIPROMOID(tenor) {
				switch (tenor) {
						case '03':
								document.formDokuOrder.PROMOID.value = '{$BNI_INSTALLMENT_PLAN}';
								document.formDokuOrder.INSTALLMENT_ACQUIRER.value = '100';
								document.formDokuOrder.PAYMENTCHANNEL.value = '';	
								document.formDokuOrder.action = '{$URL}';	
						break;
						case '06':
								document.formDokuOrder.PROMOID.value = '{$BNI_INSTALLMENT_PLAN}';
								document.formDokuOrder.INSTALLMENT_ACQUIRER.value = '100';
								document.formDokuOrder.PAYMENTCHANNEL.value = '';	
								document.formDokuOrder.action = '{$URL}';	
						break;
						case '09':
								document.formDokuOrder.PROMOID.value = '{$BNI_INSTALLMENT_PLAN}';
								document.formDokuOrder.PAYMENTCHANNEL.value = '';		
								document.formDokuOrder.INSTALLMENT_ACQUIRER.value = '100';
								document.formDokuOrder.action = '{$URL}';
						break;
						case '12':
								document.formDokuOrder.PROMOID.value = '{$BNI_INSTALLMENT_PLAN}';
								document.formDokuOrder.PAYMENTCHANNEL.value = '';		
								document.formDokuOrder.INSTALLMENT_ACQUIRER.value = '100';
								document.formDokuOrder.action = '{$URL}';
						break;
				} 				
		}

		function setMandiriPROMOID(tenor) {
				switch (tenor) {
						case '03':
								document.formDokuOrder.PROMOID.value = '003';
								document.formDokuOrder.INSTALLMENT_ACQUIRER.value = '300';
								document.formDokuOrder.PAYMENTCHANNEL.value = '';	
								document.formDokuOrder.action = '{$URL}';	
							break;
						case '06':
								document.formDokuOrder.PROMOID.value = '006';
								document.formDokuOrder.INSTALLMENT_ACQUIRER.value = '300';
								document.formDokuOrder.PAYMENTCHANNEL.value = '';	
								document.formDokuOrder.action = '{$URL}';	
							break;
						case '09':
								document.formDokuOrder.PROMOID.value = '009';
								document.formDokuOrder.INSTALLMENT_ACQUIRER.value = '300';
								document.formDokuOrder.PAYMENTCHANNEL.value = '';
								document.formDokuOrder.action = '{$URL}';		
							break;
						case '12':
								document.formDokuOrder.PROMOID.value = '012';
								document.formDokuOrder.INSTALLMENT_ACQUIRER.value = '300';
								document.formDokuOrder.PAYMENTCHANNEL.value = '';	
								document.formDokuOrder.action = '{$URL}';	
							break;
				} 				
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
		
		<h2 style="font-size: 18px;">
		Choose Credit Card Option
		</h2>
		
		<li style="list-style-type: none;">
		{if $USE_TOKENIZATION eq 1}
		<ul><input type="radio" name="TENOR" value="" onclick="clearPROMOIDToken()"> Regular Credit Card Tokenization</ul>
		{else}
		<ul><input type="radio" name="TENOR" value="" onclick="clearPROMOID()"> Regular Credit Card {$USE_TOKENIZATION}</ul>
		{/if}
		{if $BNI_INSTALLMENT eq 1}
				{$BNI_INSTALLMENT_DISPLAY}						
		{/if}

		{if $MANDIRI_INSTALLMENT eq 1}
				{$MANDIRI_INSTALLMENT_DISPLAY}
		{/if}		
		
		{if $USE_INSTALLMENT_OFFUS eq 1}
				{$INSTALLMENT_OFFUS_DISPLAY}
		{/if}		
		{if $USE_KLIKPAYBCA eq 1}
		<ul><input type="radio" name="TENOR" value="" onclick="clearPROMOIDKLIKPAYBCA()"> BCA KlikPay</ul>
		{/if}


		
		</li>
		
		<input type="hidden" name="PROMOID" value="">
		<input type="hidden" name="INSTALLMENT_ACQUIRER" value="">
    	<input type="submit" class="doku_payment_module_submit" value="PROCESS PAYMENT" onclick="return checkChannel()">
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
    	<input type=hidden name="PAYMENTCHANNEL"   value="{$PAYMENTCHANNEL}">																
    	<input type=hidden name="NAME"             value="{$NAME}">
		<input type=hidden name="EMAIL"            value="{$EMAIL}">		
    	<input type=hidden name="HOMEPHONE"        value="{$HOMEPHONE}">
    	{if $USE_TOKENIZATION eq 1}
    	<input type=hidden name="CUSTOMERID"    value="{$EMAIL}">
    	{/if}
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
				

</form>
</div>