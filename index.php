<!DOCTYPE html>

<?php
/* Global variables */

//$paypageId = "a2y4o6m8k0";
$paypageId = "pGdxWrykrdvNkBK3";
$merchantTxnId = "12345";
$orderId = "cust_order";
$reportGroup = "67890";
$timeout = "5000";
$customerId = "6548346";
$amount="14.99";

/* eComm endpoint parameters */

$ecommUser = "u82918854344049902";
$ecommPass = "QVtHWtb6UGk5XCz";
$ecommMerchantId = "1268016";
$endpoint = "https://transact-prelive.litle.com/vap/communicator/online";

/* Default customer address info (unless retrieved from AMEX wallet) to demonstrate AVS verification */

$customerName = "Fred Flinstone";
$customerAddress = "123 Main street";
$customerCity = "Cincinatti";
$customerState = "Ohio";
$customerZip = "12345";
$customerCountry = "US";
$customerEmail = "fred.flinstone@gmail.com";
$customerPhone = "555 555-1212";

/* AMEX Express Checkout specific parameters */

/*
$AECsharedSecret = "77a0a1f3a2ca4e119168cf68eb5b2008";
*/

$AECsharedSecret = "ace15dec32234dcc87862bd4dc6916b9";


?>
<html>
<head>
  <meta charset="UTF-8">
  <title>AMEX Express Checkout Demo</title>
  
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/meyer-reset/2.0/reset.min.css">
 

  <link rel='stylesheet prefetch' href='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css'>
  <link rel='stylesheet prefetch' href='https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css'>
 
  <link rel="stylesheet" href="https://e42fb64d.servage-customer.net/vantiv/aec_demo/css/style.css">  
  
  <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>
  
  <!-- This is the eProtect endpoint required for the AMEX Express Checkout integration -->
  <script type="text/javascript" src="https://request.eprotect.vantivprelive.com/eProtect/eProtect-api3.js"></script>
  
  <!-- This is the eProtect endpoint required for the classic eProtect integration -->
  <script type="text/javascript" src="https://request-prelive.np-securepaypage-litle.com/LitlePayPage/litle-api2.js"></script>

  <script>
	function fillFields() {
		$('#cardNumber').val("378310203312332");
		$('#cardCVC').val("111");
		$('#cardExpiry').val("0117");
	}
	
	function clearFields() {
		$('#cardNumber').val("");
		$('#cardCVC').val("");
		$('#cardExpiry').val("");
	}
	
  </script>

  <!-- The code for the eProtect classic use case is included JavaScript file below -->
  <script type="text/javascript" src="./js/classic.js"></script>
  
  <!-- The AMEX Express Checkout code is in the included JavaScript file below -->
  <script type="text/javascript" src="./js/aec.js"></script>

</head>

<body>
 
 <h2>AMEX Express Checkout Demo</h2>
 
  <div class="actionlinks">
	<span onclick="fillFields();">Fill Form</span> |
	<span onclick="clearFields();">Clear Form</span> |
	<span id="showfields" onclick="$('#hidden_fields').show(); show_eprotect_classic_fields(); $('#hidefields').show(); $('#showfields').hide();">Show Hidden Fields  |  </span>
	<span id="hidefields" style="display:none;" onclick="$('#hidden_fields').hide(); $('#hidefields').hide(); $('#showfields').show();">Hide Hidden Fields  |  </span>
	<span id="showhelp"  onclick="$('#help_area').show(); $('#hidehelp').show(); $('#showhelp').hide();">Show Help</span>
	<span id="hidehelp" onclick="$('#help_area').hide(); $('#hidehelp').hide(); $('#showhelp').show();" style="display:none;">Hide Help</span>
  </div>

  <div id="help_area">
  <p>Enter a test credit card to simulate processing against Vantiv's eCommerce platform or make a payment using a test card stored in the AMEX Express Checkout wallet.</p>
  <p>This demo operates against the AMEX Express Checkout QA environment and the Vantiv eCommerce pre-live environment and illustrates how eProtect can be used to facilitate both traditional card payments and wallet transactions. Please do not use real card numbers.</p>
 
  <p><u>For traditional card payments</u></p>
  <ul>
  <li>Click the Fill Form button or manually enter a suitable test card</li>
  <li>Click Submit to perform a traditional eProtect transaction. The hidden fields will be so you can expect values returned by the eProtect service</li>
  <li>Click Authorize Card Transaction to POST payment details to the web server and monitor to Vantiv eCommerce Authorization transaction</li>
  </ul>
  <p><u>For AMEX Express Checkout wallet payments</u></p>
  <ul>
  <li>Ignore the Payment Details section and click the AMEX Express Checkout button</li>
  <li>When presented with the AEC wallet login screen use the following test credentials: aectest3 / aectest</li>
  <li>Select a card in the wallet and proceed and use it to make the payment</li>
  <li>Hidden fields retrieved from AMEX will be exposed via the website (normally a consumer would not see these fields)</li>
  <li>Scroll down to the bottom of the screen and Authorize a payment to pass the information the Vantiv's front end</li>
  <li>The following screen will show the resulting interaction with Vantiv's eCommerce environment</li>
  
  </ul>  
  </div>
  

  <div class="container">
  
  <div class="row">
	<!-- You can make it whatever width you want. I'm making it full width
	on <= small devices and 4/12 page width on >= medium devices -->
  <div class="col-xs-12 col-md-4">

   <!-- CREDIT CARD FORM STARTS HERE -->
  <div class="panel panel-default credit-card-box">
	<div class="panel-heading display-table" >
		<div class="row display-tr" >
			<h3 class="panel-title display-td" >Payment Details</h3>
			<div class="display-td" >                            
				<img class="img-responsive pull-right" src="./images/accepted_c22e0.png">
			</div>
		</div>                    
	</div>

	<div class="panel-body">
		<form role="form" id="payment-form" action="authorize.php" method="POST">
		
		<div id="card-details">
		
		<div class="row">
			<div class="col-xs-12">
				<div class="form-group">
					<label for="couponCode">CARDHOLDER NAME</label>
					<input type="text" class="form-control" name="name" id="name" value="<?php echo $customerName;?>" />
				</div>
			</div>                        
		</div>

		<div class="row">
			<div class="col-xs-12">
				<div class="form-group">
					<label for="cardNumber">CARD NUMBER</label>
					<div class="input-group">
						<input type="tel" class="form-control" name="cardNumber" id="cardNumber" placeholder="Valid Card Number" autocomplete="cc-number"   />
						<span class="input-group-addon"><i class="fa fa-credit-card"></i></span>
					</div>
				</div>                            
			</div>
		</div>

		<div class="row">
			<div class="col-xs-7 col-md-7">
				<div class="form-group">
					<label for="cardExpiry">
					<span class="hidden-xs">EXPIRATION</span><span class="visible-xs-inline">EXP</span> DATE</label>
					<input type="tel" class="form-control" name="cardExpiry" id="cardExpiry" placeholder="MMYY" autocomplete="cc-exp"  />
				</div>
			</div>
			<div class="col-xs-5 col-md-5 pull-right">
				<div class="form-group">
					<label for="cardCVC">CV CODE</label>
					<input type="tel" class="form-control" name="cardCVC" id="cardCVC" placeholder="CVC/CVV/CID" autocomplete="cc-csc"  />
				</div>
			</div>
		</div>

		<div class="row">
			<div class="col-xs-12">
				<!-- <button class="btn btn-success btn-lg btn-block" type="submit" id="card-submit">Submit</button> -->
				<button class="btn btn-success btn-lg btn-block" type="button" id="card-submit">Submit</button>
			</div>
		</div>
		
		</div> <!-- card-details div -->

		<div class="row" style="display:none;">
			<div class="col-xs-12">
				<p class="payment-errors"></p>
			</div>
		</div>
		
		<div id="hidden_fields" style="display:none; margin-top:20px;">
		
			<div id="explain_hidden_fields">
			<p>The fields below are normally hidden from view but are exposed here to illustrate how the integration works. Traditional eProtect integrations populate hidden fields that are subsequently posted to the merchant server. For consistency we use the same approach here with AMEX Express Checkout, although when a user pays with the AEC wallet, a different set of parameters are passed to the server.</p>
			</div>
			<!-- request$pagepageId -->
			<div class="row" id="requestpagepageId_wrapper">
				<div class="col-xs-12">
					<div class="form-group">
						<label for="request$paypageId">paypageId</label>
						<div>
							<input type="text" class="form-control hidden_field" name="request$paypageId" id="request$paypageId" value="<?php echo $paypageId;?>"  />
						</div>
					</div>                            
				</div>
			</div>

			<!-- request$merchantTxnId -->
			<div class="row" id="requestmerchantTxnId_wrapper">
				<div class="col-xs-12">
					<div class="form-group">
						<label for="request$merchantTxnId">merchantTxnId</label>
						<div>
							<input type="text" class="form-control hidden_field" name="request$merchantTxnId" id="request$merchantTxnId" value="<?php echo $merchantTxnId;?>"  />
						</div>
					</div>                            
				</div>
			</div>

			<!-- request$orderId -->
			<div class="row" id="requestorderId_wrapper">
				<div class="col-xs-12">
					<div class="form-group">
						<label for="request$orderId">orderId</label>
						<div>
							<input type="text" class="form-control hidden_field" name="request$orderId" id="request$orderId" value="<?php echo $orderId;?>"  />
						</div>
					</div>                            
				</div>
			</div>
			
			<!-- request$reportGroup -->
			<div class="row" id="requestreportGroup_wrapper">
				<div class="col-xs-12">
					<div class="form-group">
						<label for="request$reportGroup">reportGroup</label>
						<div>
							<input type="text" class="form-control hidden_field" name="request$reportGroup" id="request$reportGroup" value="<?php echo $reportGroup;?>"  />
						</div>
					</div>                            
				</div>
			</div>

			<!-- request$timeout -->
			<div class="row" id="requesttimeout_wrapper">
				<div class="col-xs-12">
					<div class="form-group">
						<label for="request$timeout">timeout</label>
						<div>
							<input type="text" class="form-control hidden_field" name="request$timeout" id="request$timeout" value="<?php echo $timeout?>"  />
						</div>
					</div>                            
				</div>
			</div>

			<!-- response$code -->
			<div class="row" id="responsecode_wrapper">
				<div class="col-xs-12">
					<div class="form-group">
						<label for="response$code">Code</label>
						<div>
							<input type="text" class="form-control hidden_field" name="response$code" id="response$code"  />
						</div>
					</div>                            
				</div>
			</div>

			<!-- response$responseTime -->
			<div class="row" id="responseresponseTime_wrapper">
				<div class="col-xs-12">
					<div class="form-group">
						<label for="response$responseTime">responseTime</label>
						<div>
							<input type="text" class="form-control hidden_field" name="response$responseTime" id="response$responseTime"  />
						</div>
					</div>                            
				</div>
			</div>
			
			<!-- response$message -->
			<div class="row" id="responsemessage_wrapper">
				<div class="col-xs-12">
					<div class="form-group">
						<label for="response$message">message</label>
						<div>
							<input type="text" class="form-control hidden_field" name="response$message" id="response$message"  />
						</div>
					</div>                            
				</div>
			</div>

			<!-- response$vantivTxnId -->
			<div class="row" id="responsevantivTxnId_wrapper">
				<div class="col-xs-12">
					<div class="form-group">
						<label for="response$vantivTxnId">VantivTxnId</label>
						<div>
							<input type="text" class="form-control hidden_field" name="response$vantivTxnId" id="response$vantivTxnId"  />
						</div>
					</div>                            
				</div>
			</div>

			<!-- response$merchantTxnId -->
			<div class="row" id="responsemerchantTxnId_wrapper">
				<div class="col-xs-12">
					<div class="form-group">
						<label for="response$merchantTxnId">merchantTxnId</label>
						<div>
							<input type="text" class="form-control hidden_field" name="response$merchantTxnId" id="response$merchantTxnId"  />
						</div>
					</div>                            
				</div>
			</div>
			
			<!-- response$orderId -->
			<div class="row" id="responseorderId_wrapper">
				<div class="col-xs-12">
					<div class="form-group">
						<label for="response$orderId">orderId</label>
						<div>
							<input type="text" class="form-control hidden_field" name="response$orderId" id="response$orderId"  />
						</div>
					</div>                            
				</div>
			</div>

			
			<!-- response$reportGroup -->
			<div class="row" id="responsereportGroup_wrapper">
				<div class="col-xs-12">
					<div class="form-group">
						<label for="response$reportGroup">reportGroup</label>
						<div>
							<input type="text" class="form-control hidden_field" name="response$reportGroup" id="response$reportGroup"  />
						</div>
					</div>                            
				</div>
			</div>

			<!-- response$type -->
			<div class="row" id="responsetype_wrapper">
				<div class="col-xs-12">
					<div class="form-group">
						<label for="response$type">type</label>
						<div>
							<input type="text" class="form-control hidden_field" name="response$type" id="response$type"  />
						</div>
					</div>                            
				</div>
			</div>

			<!-- response$firstSix -->
			<div class="row" id="responsefirstSix_wrapper">
				<div class="col-xs-12">
					<div class="form-group">
						<label for="response$firstSix">firstSix</label>
						<div>
							<input type="text" class="form-control hidden_field" name="response$firstSix" id="response$firstSix"  />
						</div>
					</div>                            
				</div>
			</div>
			
			<!-- response$lastFour -->
			<div class="row" id="responselastFour_wrapper">
				<div class="col-xs-12">
					<div class="form-group">
						<label for="response$lastFour">lastFour</label>
						<div>
							<input type="text" class="form-control hidden_field" name="response$lastFour" id="response$lastFour"  />
						</div>
					</div>                            
				</div>
			</div>

			<!-- timeoutMessage -->
			<div class="row" id="timeoutMessage_wrapper">
				<div class="col-xs-12">
					<div class="form-group">
						<label for="timeoutMessage">timeoutMessage</label>
						<div>
							<input type="text" class="form-control hidden_field" name="timeoutMessage" id="timeoutMessage"  />
						</div>
					</div>                            
				</div>
			</div>

			<!-- paypageRegistrationId -->
			<div class="row" id="paypageRegistrationId_wrapper">
				<div class="col-xs-12">
					<div class="form-group">
						<label for="paypageRegistrationId">paypageRegistrationId (LVT)</label>
						<div>
							<input type="text" class="form-control hidden_field" name="paypageRegistrationId" id="paypageRegistrationId"  />
						</div>
					</div>                            
				</div>
			</div>

			<!-- AEC encryptedData -->
			<div class="row" id="encryptedData_wrapper">
				<div class="col-xs-12">
					<div class="form-group">
						<label for="encryptedData">AEC encryptedData</label>
						<div>
							<input type="text" class="form-control hidden_field" name="encryptedData" id="encryptedData"  />
						</div>
					</div>                            
				</div>
			</div>

			<!-- AEC sharedKey -->
			<div class="row" id="sharedKey_wrapper">
				<div class="col-xs-12">
					<div class="form-group">
						<label for="sharedKey">AEC sharedKey</label>
						<div>
							<input type="text" class="form-control hidden_field" name="sharedKey" id="sharedKey" value="<?php echo $AECsharedSecret;?>"  />
						</div>
					</div>                            
				</div>
			</div>

			
			<!-- BIN -->
			<div class="row" id="bin_wrapper">
				<div class="col-xs-12">
					<div class="form-group">
						<label for="bin">Bank Identification Number (BIN)</label>
						<div>
							<input type="text" class="form-control hidden_field" name="bin" id="bin"  />
						</div>
					</div>                            
				</div>
			</div>
			
			
			
			<div id="authorize-wallet" class="row">
				<div class="col-xs-12">
					<button class="btn btn-success btn-lg btn-block" id="authorize-wallet-button" type="submit">Authorize Wallet Transaction</button>
				</div>
			</div>

			<div id="authorize-card" class="row">
				<div class="col-xs-12">
					<button class="btn btn-success btn-lg btn-block" id="authorize-card-button" type="submit">Authorize Card Transaction</button>
				</div>
			</div>

			
			<!-- These are additional hidden fields ...
				 In a real application these data items would be obtained from elsewhere in the application or extracted
				 from the encrypted data in the response from the wallet -->
				 
			<input type="hidden" name="ecomm$User" id="ecomm$User" value="<?php echo $ecommUser; ?>">
			<input type="hidden" name="ecomm$Pass" id="ecomm$Pass" value="<?php echo $ecommPass; ?>">
			<input type="hidden" name="ecomm$MerchantId" id="ecomm$MerchantId" value="<?php echo $ecommMerchantId; ?>">
			<input type="hidden" name="customer$Address" id="customer$Address" value="<?php echo $customerAddress; ?>">
			<input type="hidden" name="customer$City" id="customer$City" value="<?php echo $customerCity; ?>">
			<input type="hidden" name="customer$Zip" id="customer$Zip" value="<?php echo $customerZip; ?>">
			<input type="hidden" name="customer$State" id="customer$State" value="<?php echo $customerState; ?>">
			<input type="hidden" name="customer$Country" id="customer$Country" value="<?php echo $customerCountry; ?>">
			<input type="hidden" name="customer$Email" id="customer$Email" value="<?php echo $customerEmail; ?>">
			<input type="hidden" name="customer$Phone" id="customer$Phone" value="<?php echo $customerPhone; ?>">
			<input type="hidden" name="customerId" id="customerId" value="<?php echo $customerId; ?>">
			<input type="hidden" name="amount" id="amount" value="<?php echo $amount; ?>">
			<input type="hidden" name="endpoint" id="endpoint" value="<?php echo $endpoint; ?>">
					
		</div> <!-- hidden_fields -->

		<!-- AMEX EXPRESS CHECKOUT PORTION STARTS HERE -->
		<div style="width:100%;">
			<div id="amex-button" style="margin-top:25px;">
				<center>
				<p><b>OR</b></p>
				<div id="amex-express-checkout"></div>
				</center>
			</div>
		</div>

			
		</form>
	</div> <!-- panel body -->
</div> <!-- credit card box -->           

<!-- CREDIT CARD FORM ENDS HERE -->



</div>            

</div>
</div>

	
<script type="text/javascript"
src="https://icm.aexp-static.com/Internet/IMDC/AmexExpressCheckout/js/2.0/AEC.js">
</script>
	
</body>

<!--
<script src='http://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.13.1/jquery.validate.min.js'></script>
<script src='http://cdnjs.cloudflare.com/ajax/libs/jquery.payment/1.2.3/jquery.payment.min.js'></script>
-->

</html>
