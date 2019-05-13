<script type="text/javascript">
		function checkChannel() {
				var ischeck = ValidateInputs();
				if ( ischeck ) {
						$.post( "/modules/dokuonecheckout/validate.php", { TRANSIDMERCHANT: "{$TRANSIDMERCHANT}", AMOUNT: "{$AMOUNT}" } );
						return true;
				}
				else {
						alert("Please choose Payment Channel to use!");
						return false;
				}
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
		function channel() {
			 if (document.formDokuOrder.PAYMENTCHANNEL.value == "37") {
			 	document.formDokuOrder.MALLID.value = "{$MALL_ID_KREDIVO}";
			 	document.formDokuOrder.CHAINMERCHANT.value = "{$CHAIN_ID_KREDIVO}";
			 	document.formDokuOrder.WORDS.value = "{$WORDS_KREDIVO}";
			 	document.formDokuOrder.action = "{$URL}";
			 }else {
			 	document.formDokuOrder.MALLID.value = "{$MALLID}";
			 	document.formDokuOrder.CHAINMERCHANT.value = "{$CHAINMERCHANT}";
			 	document.formDokuOrder.WORDS.value = "{$WORDS}";
			 	document.formDokuOrder.action = "{$URL}";
			 	document.formDokuOrder.CUSTOMERID.value = "{$EMAIL}";


			 }
			 }
		function channelBCA(){
				document.formDokuOrder.MALLID.value = "{$MALL_ID_KLIKPAYBCA}";
			 	document.formDokuOrder.CHAINMERCHANT.value = "{$CHAIN_ID_KLIKPAYBCA}";
			 	document.formDokuOrder.WORDS.value = "{$WORDS_KLIKPAYBCA}";
				document.formDokuOrder.action = 'modules/dokuonecheckout/BCAKLIKPAY.php';
				document.formDokuOrder.CUSTOMERID.value = '{$URL}MIP';
				document.formDokuOrder.PAYMENTCHANNEL.value = '18';	
			}
		function channelSINARMAS(){
				document.formDokuOrder.MALLID.value = "{$MALL_ID_SINARMASVA}";
			 	document.formDokuOrder.CHAINMERCHANT.value = "{$CHAIN_ID_SINARMASVA}";
			 	document.formDokuOrder.WORDS.value = "{$WORDS_SINARMASVA}";
				document.formDokuOrder.action = 'modules/dokuonecheckout/merchanthostedva.php';
				document.formDokuOrder.CUSTOMERID.value = '{$URL_MERCHANTHOSTED}';
				document.formDokuOrder.PAYMENTCHANNEL.value = '22';	
			}
		function channelBNI(){
				document.formDokuOrder.MALLID.value = "{$MALL_ID_BNIVA}";
			 	document.formDokuOrder.CHAINMERCHANT.value = "{$CHAIN_ID_BNIVA}";
			 	document.formDokuOrder.WORDS.value = "{$WORDS_BNIVA}";
				document.formDokuOrder.action = 'modules/dokuonecheckout/merchanthostedva.php';
				document.formDokuOrder.CUSTOMERID.value = '{$URL_MERCHANTHOSTED}';
				document.formDokuOrder.PAYMENTCHANNEL.value = '38';	
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

		{if $USE_TOKENIZATION eq 1}
				<ul><input type="radio" name="PAYMENTCHANNEL" value="16" onclick="return channel()"> Credit Card Tokenization</ul>
		{else if $CHANNEL_CC eq 1}
				<ul><input type="radio" name="PAYMENTCHANNEL" value="15" onclick="return channel()"> Credit Card</ul>
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
		
		<input type="submit" class="doku_payment_module_submit" value="PROCESS PAYMENT" onclick="return checkChannel();">
		
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
    	<input type=hidden name="CUSTOMERID" 	   value="{$EMAIL}"> 
		<input type=hidden name="SHIPPING_ADDRESS" value="{$SHIPPING_ADDRESS}"> 
    	<input type=hidden name="SHIPPING_CITY"    value="{$SHIPPING_CITY}"> 
    	<input type=hidden name="SHIPPING_ZIPCODE" value="{$SHIPPING_ZIPCODE}"> 				

</form>
</div>