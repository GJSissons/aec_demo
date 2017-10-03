/* The AMEX client_id in aec_init below is configured for use with Vantiv.
   It will return additional fields obtained when AMEX vaults card credentials
   using Vantiv's eProtect service.
   For traditional non eProtect integrations, developers can experiement with
   the standard shared credential for the AMEX QA environment which which return
   an encrypyed payload only.
   
   cc8eb057-7f93-41a5-8f4e-9fb51d835b78
   
*/


var aec_init=
{
"client_id": "e4e6beb7-71b1-4ae6-90d7-8e3ca12e8f3d",
"request_id": "7f6d0887-8346-4c7e-87d1-6f99dcbe490b",
"theme ": "desktop",
"button_color": "dark",
"action": "checkout",
"locale": "en_US",
"country": "US",
"callback": "aec_callback_handler",
"env": "qa",
"dialog_type": "modal",
"button_type": "standard",
"disable_btn": "false" ,
"merchant_reserved_data":
{
"id":"1234",
"orderId":"abc1234",
"reportGroup":"Acme Co."
}
}



function aec_callback_handler(response)
{
	console.log("in aec_callback_handler");
	console.log(response);
   //place response.enc_data in hidden field so it can be passed to server
	document.getElementById('encryptedData').value = response.enc_data;
	document.getElementById('response$lastFour').value    = response.fpan_last_four;
	document.getElementById('paypageRegistrationId').value = response.merchant_reserved_data.paypageRegistrationId;
	document.getElementById('response$orderId').value = response.merchant_reserved_data.orderId;
	document.getElementById('response$reportGroup').value = response.merchant_reserved_data.reportGroup;
	document.getElementById('response$merchantTxnId').value = response.merchant_reserved_data.id;
	document.getElementById('cardNumber').value = '**********'+response.fpan_last_four;;
	
	
	$('#authorize-wallet').show();
	$('#card-submit').hide();
	$('#hidden_fields').show();
	$('#amex-button').hide();
	show_aec_wallet_fields();
}


function show_aec_wallet_fields() {
	console.log('In show_aec_wallet_fields');
							$('#requestpagepageId_wrapper').show();
							$('#requestmerchantTxnId_wrapper').show();
							$('#requestorderId_wrapper').show();
							$('#requestreportGroup_wrapper').show();							
							$('#responseorderId_wrapper').show();
							$('#responsereportGroup_wrapper').show();						
							$('#responselastFour_wrapper').show();
							$('#responsemerchantTxnId_wrapper').show();
							$('#paypageRegistrationId_wrapper').show();
							$('#encryptedData_wrapper').show();
							$('#sharedKey_wrapper').show();
			
							$('#requesttimeout_wrapper').hide();
							$('#responsecode_wrapper').hide();
							$('#responseresponseTime_wrapper').hide();
							$('#responsemessage_wrapper').hide();
							$('#responsetype_wrapper').hide();
							$('#responsefirstSix_wrapper').hide();
							$('#timeoutMessage_wrapper').hide();
							$('#bin_wrapper').hide();
							$('#responsevantivTxnId').hide();

}



/*

function aec_callback_handler(response)
{
	console.log("in aec_callback_handler");
	console.log(response);
   //place response data in hidden fields so it can be passed to server
	document.getElementById('encryptedData').value   = response.enc_data;
	document.getElementById('fpanLastFour').value    = response.fpan_last_four;
	document.getElementById('fpanExpiryYear').value  = response.fpan_expiry.year;
	document.getElementById('fpanExpiryMonth').value = response.fpan_expiry.month;
	document.getElementById('id').value              = response.merchant_reserved_data.id;
	document.getElementById('orderId').value         = response.merchant_reserved_data.orderId;
	document.getElementById('reportGroup').value     = response.merchant_reserved_data.reportGroup;
	document.getElementById('paypageRegistrationId').value = response.merchant_reserved_data.paypageRegistrationId;
	//Depending on your implementation, submit the form containing the hidden fields to the merchant server
	
}

*/

