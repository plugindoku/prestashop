<!-- NOT USE ANYMORE, MOVE TO payment.tpl -->

<!--

{capture name=path}{l s='Shipping' mod='dokuonecheckout'}{/capture}
{include file="$tpl_dir./breadcrumb.tpl"}


<h2>{l s='Order summary' mod='dokuonecheckout'}</h2>

{assign var='current_step' value='payment'}

{if isset($nbProducts) && $nbProducts <= 0}
    <p class="warning">{l s='Your shopping cart is empty.'}</p>
{else}

<h3>{l s='Order Details' mod='dokuonecheckout'}</h3>

<form name="formDokuOrder" id="formDokuOrder" action="{$URL}" method="post">
    <table border="0">
        <tr>
            <td>{l s='You have chosen to pay via DOKU Payment Gateway.' mod='dokuonecheckout'}
                {l s=' Here is a short summary of your order:' mod='dokuonecheckout'}
                <br/><br/>
            </td>
        </tr>
        <tr>
            <td>{l s='The total amount of your order is : ' mod='dokuonecheckout'} <b>Rp {$AMOUNT}</b></td>
        </tr>
        <tr>
            <td>
                <br/><br/>
                {l s='You will be redirected to DOKU to complete your payment.' mod='checkout'}
                <br /><br />
                <b>{l s='Please confirm your order by clicking \'Submit Order\'' mod='checkout'}.</b>
            </td>
        </tr>
    </table>

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
    <input type=hidden name="MOBILEPHONE"      value="{$MOBILEPHONE}"> 
    <input type=hidden name="BASKET"           value="{$BASKET}">				
    <input type=hidden name="ADDRESS"          value="{$ADDRESS}"> 
	  <input type=hidden name="CITY"             value="{$CITY}"> 
    <input type=hidden name="STATE"            value="{$STATE}"> 
    <input type=hidden name="ZIPCODE"          value="{$ZIPCODE}"> 				

    <p class="cart_navigation">
        <a href="{$base_dir_ssl}order.php?step=3" class="button_large">{l s='Other Payment Methods' mod='dokuonecheckout'}</a>
        <input type="submit" name="DokuSubmit" value="{l s='Submit Order' mod='dokuonecheckout'}" class="exclusive_large" />
    </p>
</form>

<script type="text/javascript">
		document.getElementById("formDokuOrder").submit();
</script>

{/if}

-->