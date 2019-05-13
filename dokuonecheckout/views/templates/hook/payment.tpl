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

<script type="text/javascript">
function RedirectToDOKU() {
	if (!document.formDokuOrder.PAYMENTCHANNEL.value) {
				var ischeck = ValidateInputs();
				if ( ischeck ) {
						$.post( "/modules/dokuonecheckout/validate.php", { TRANSIDMERCHANT: "{$TRANSIDMERCHANT}", AMOUNT: "{$AMOUNT}" } );
						return true;
				}
				else {
						alert("Please choose Payment Channel to use!");
						return false;
				}
		} else {
				$.post( "/modules/dokuonecheckout/validate.php", { TRANSIDMERCHANT: "{$TRANSIDMERCHANT}", AMOUNT: "{$AMOUNT}" } );
						return true;
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
			document.formDokuOrder.PAYMENTCHANNEL.value = "";
			document.formDokuOrder.MALLID.value = "{$MALLID}";
			document.formDokuOrder.CHAINMERCHANT.value = "{$CHAINMERCHANT}";
			document.formDokuOrder.WORDS.value = "{$WORDS}";
			document.formDokuOrder.action = "{$URL}";
			document.formDokuOrder.CUSTOMERID.value = "{$EMAIL}";			
		}

		function channel16() {
			document.formDokuOrder.PAYMENTCHANNEL.value = "16";
			document.formDokuOrder.MALLID.value = "{$MALLID}";
			document.formDokuOrder.CHAINMERCHANT.value = "{$CHAINMERCHANT}";
			document.formDokuOrder.WORDS.value = "{$WORDS}";
			document.formDokuOrder.action = "{$URL}";
			document.formDokuOrder.CUSTOMERID.value = "{$EMAIL}";

		}

		function channel37() {
			document.formDokuOrder.PAYMENTCHANNEL.value = "37";
			document.formDokuOrder.MALLID.value = "{$MALL_ID_KREDIVO}";
			document.formDokuOrder.CHAINMERCHANT.value = "{$CHAIN_ID_KREDIVO}";
			document.formDokuOrder.WORDS.value = "{$WORDS_KREDIVO}";
			document.formDokuOrder.action = "{$URL}";

		}

		function channel38() {
			document.formDokuOrder.PAYMENTCHANNEL.value = "38";
			document.formDokuOrder.MALLID.value = "{$MALL_ID_BNIVA}";
			document.formDokuOrder.CHAINMERCHANT.value = "{$CHAIN_ID_BNIVA}";
			document.formDokuOrder.WORDS.value = "{$WORDS_BNIVA}";
			document.formDokuOrder.action = "modules/dokuonecheckout/merchanthostedva.php";
			document.formDokuOrder.CUSTOMERID.value = '{$URL_MERCHANTHOSTED}';
		}

		function channel22() {
			document.formDokuOrder.PAYMENTCHANNEL.value = "22";
			document.formDokuOrder.MALLID.value = "{$MALL_ID_SINARMASVA}";
			document.formDokuOrder.CHAINMERCHANT.value = "{$CHAIN_ID_SINARMASVA}";
			document.formDokuOrder.WORDS.value = "{$WORDS_SINARMASVA}";
			document.formDokuOrder.action = "modules/dokuonecheckout/merchanthostedva.php";
			document.formDokuOrder.CUSTOMERID.value = '{$URL_MERCHANTHOSTED}';
		}

		function channel18() {
			document.formDokuOrder.PAYMENTCHANNEL.value = "18";
			document.formDokuOrder.MALLID.value = "{$MALL_ID_KLIKPAYBCA}";
			document.formDokuOrder.CHAINMERCHANT.value = "{$CHAIN_ID_KLIKPAYBCA}";
			document.formDokuOrder.action = 'modules/dokuonecheckout/BCAKLIKPAY.php';
			document.formDokuOrder.CUSTOMERID.value = '{$URL}MIP';
			document.formDokuOrder.WORDS.value = "{$WORDS_KLIKPAYBCA}";

		}

		function channel45() {
			document.formDokuOrder.PAYMENTCHANNEL.value = "45";
			document.formDokuOrder.MALLID.value = "{$MALLID}";
			document.formDokuOrder.CHAINMERCHANT.value = "{$CHAINMERCHANT}";
			document.formDokuOrder.WORDS.value = "{$WORDS}";
			document.formDokuOrder.action = "{$URL}";
			document.formDokuOrder.CUSTOMERID.value = "{$EMAIL}";
		}


</script>

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
				<ul><input type="radio" name="PAYMENTCHANNEL" value="" onclick="return channel()"> With DOKU</ul>

		{if $USE_TOKENIZATION eq 1}
				<ul><input type="radio" name="PAYMENTCHANNEL" value="16" onclick="return channel16()"> Credit Card Tokenization</ul>
		{/if}

		{if $CHANNEL_KREDIVO eq 1}
				<ul><input type="radio" name="PAYMENTCHANNEL" value="37" onclick="return channel37()" > Kredivo</ul>
		{/if}							

		{if $USE_KLIKPAYBCA eq 1}
				<ul><input type="radio" name="PAYMENTCHANNEL" value="18" onclick="return channel18()"> BCA Klikpay</ul>
		{/if}	

		{if $USE_BNIVA eq 1}
				<ul><input type="radio" name="PAYMENTCHANNEL" value="38" onclick="return channel38()"> BNIVA</ul>
		{/if}	

		{if $USE_SINARMASVA eq 1}
				<ul><input type="radio" name="PAYMENTCHANNEL" value="22" onclick="return channel22()"> SINARMASVA</ul>
		{/if}	

    	{if $CHANNEL_BNIYAP eq 1}
    	    <ul><input type="radio" name="PAYMENTCHANNEL" value="45" onclick="return channel45()"> BNI YAP!</ul>
    	{/if}						

		<input type="submit" class="doku_payment_module_submit" value="PROCESS PAYMENT" onclick="return RedirectToDOKU();">

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
		<input type=hidden name="CUSTOMERID"            value="{$EMAIL}">		
    <input type=hidden name="HOMEPHONE"        value="{$HOMEPHONE}">
    <input type=hidden name="MOBILEPHONE"      value="{$MOBILEPHONE}"> 
    <input type=hidden name="BASKET"           value="{$BASKET}">				
    <input type=hidden name="ADDRESS"          value="{$ADDRESS}"> 
	  <input type=hidden name="CITY"             value="{$CITY}"> 
	  <input type=hidden name="CITY"             value="{$CITY}"> 
    <input type=hidden name="STATE"            value="{$STATE}"> 
    <input type=hidden name="ZIPCODE"          value="{$ZIPCODE}"> 
		<input type=hidden name="SHIPPING_COUNTRY" value="{$SHIPPING_COUNTRY}"> 
		<input type=hidden name="SHIPPING_ADDRESS" value="{$SHIPPING_ADDRESS}"> 
    <input type=hidden name="SHIPPING_CITY"    value="{$SHIPPING_CITY}"> 
    <input type=hidden name="SHIPPING_ZIPCODE" value="{$SHIPPING_ZIPCODE}"> 				
				
</form>
</div>
