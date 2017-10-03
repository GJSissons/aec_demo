				  
                        $(document).ready(						
                            function(){
                                function setLitleResponseFieldsCard(response) {
                                    document.getElementById('response$code').value = response.response;
                                    document.getElementById('response$message').value = response.message;
                                    document.getElementById('response$responseTime').value = response.responseTime;
                                    document.getElementById('response$reportGroup').value = response.reportGroup;
                                    document.getElementById('response$merchantTxnId').value = response.id;
                                    document.getElementById('response$orderId').value = response.orderId;
                                    document.getElementById('response$type').value = response.type;
									document.getElementById('response$firstSix').value = response.firstSix;
									document.getElementById('response$lastFour').value = response.lastFour;
									document.getElementById('response$vantivTxnId').value = response.vantivTxnId;
                                }
                                
                                function submitAfterLitleCard (response) {
                                    setLitleResponseFieldsCard(response);
									$('#amex-button').hide();
									$('#card-submit').hide();
									$('#authorize-card').show();
                                    /* For this demonstration don't call submit because we are invoking it manually for clarity
                                    document.forms['fCheckout'].submit();
                                    */
                                }
                            
                                function onErrorAfterLitleCard (response) {
                                    setLitleResponseFieldsCard(response);
									
									if(response.response == '871') {
										alert("Invalid card number. Check and retry. (Not Mod10)");
									}
									else if(response.response == '872') {
										alert("Invalid card number. Check and retry. (Too short)");
									}
									else if(response.response == '873') {
										alert("Invalid card number. Check and retry. (Too long)");
									}
									else if(response.response == '874') {
										alert("Invalid card number. Check and retry. (Not a number)");
									}
									else if(response.response == '875') {
										alert("We are experiencing technical difficulties. Please try again later or call 555-555-1212");
									}
									else if(response.response == '876') {
										alert("Invalid card number. Check and retry. (Failure from Server)");
									}
									else if(response.response == '881') {
										alert("Invalid card validation code. Check and retry. (Not a number)");
									}
									else if(response.response == '882') {
										alert("Invalid card validation code. Check and retry. (Too short)");
									}
									else if(response.response == '883') {
										alert("Invalid card validation code. Check and retry. (Too long)");
									}
									else if(response.response == '889') {
										alert("We are experiencing technical difficulties. Please try again later or call 555-555-1212");
									}
									
                                    return false;
                                }
                                
                                
								var elapsedTime;
								
								
                                function onTimeoutAfterLitleCard() {
                                    //alert('Timed out');
                                    elapsedTime = new Date().getTime() - elapsedTime;
                                    document.getElementById('timeoutMessage').value = 'Timed out after ' + elapsedTime + 'ms';
                                }
                                
                                var formFields = {
                                    "accountNum"   :document.getElementById('cardNumber'), 
                                    "cvv2" :document.getElementById('cardCVC'),
                                    "expDate" :document.getElementById('expDate'),
                                    "paypageRegistrationId":document.getElementById('paypageRegistrationId'),
                                    "bin"  :document.getElementById('bin') 
                                };
								
								show_eprotect_classic_fields();

                                $("#card-submit").click(
                                    function(){
                                        // clear test fields
										
										console.log("in card-submit handler");
										
										if (document.getElementById("request$paypageId").value == "") {
												alert("Card number, Expiry and CVV required for card authorization");
												return false;
										}
										
                                        setLitleResponseFieldsCard({"response":"", "message":""});
                                        document.getElementById('timeoutMessage').value="";
                                        
                                        elapsedTime=new Date().getTime();
                                        
										console.log("populating LitleRequestCard");
										
                                        var litleRequestCard = {
                                            "paypageId" : document.getElementById("request$paypageId").value,
                                            "reportGroup" : document.getElementById("request$reportGroup").value,
                                            "orderId" : document.getElementById("request$orderId").value,
                                            "id" : document.getElementById("request$merchantTxnId").value,
                                            "url" : 'https://request-prelive.np-securepaypage-litle.com'
                                        };
                        
										console.log(litleRequestCard);
										console.log("Form Fields");
										console.log(formFields);
										
                                        var timeout = document.getElementById("request$timeout").value;
										console.log("Exposing hidden fields");
										$('#hidden_fields').show();
                                        new LitlePayPage().sendToLitle(litleRequestCard, formFields, submitAfterLitleCard, onErrorAfterLitleCard, onTimeoutAfterLitleCard, timeout);
										
                                        return false;
                                        
                                    }
                                );
                            }
                        );
						
						function show_eprotect_classic_fields() {
							console.log('In show_eprotect_classic_fields');
							$('#requestpagepageId_wrapper').show();
							$('#requestmerchantTxnId_wrapper').show();
							$('#requestorderId_wrapper').show();
							$('#requestreportGroup_wrapper').show();
							$('#requesttimeout_wrapper').show();
							$('#responsecode_wrapper').show();
							$('#responseresponseTime_wrapper').show();
							$('#responsemessage_wrapper').show();
							$('#responselitleTxnId').show();
							$('#responseorderId_wrapper').show();
							$('#responsereportGroup_wrapper').show();
							$('#responsetype_wrapper').show();
							$('#responsefirstSix_wrapper').show();
							$('#responselastFour_wrapper').show();
							$('#timeoutMessage_wrapper').show();
							$('#responsemerchantTxnId_wrapper').show();
							$('#paypageRegistrationId_wrapper').show();
							$('#bin_wrapper').show();
							
							$('#encryptedData_wrapper').hide();
							$('#sharedKey_wrapper').hide();
	
						}
						
						
