<?php

function getAuth($fields) {
    $xml = '<?xml version="1.0"?>
      <litleOnlineRequest version="9.9" xmlns="http://www.litle.com/schema" merchantId="'.$fields['ecomm$MerchantId'].'">
        <authentication>
            <user>'.$fields['ecomm$User'].'</user>
            <password>'.$fields['ecomm$Pass'].'</password>
        </authentication>
        <authorization id="'.$fields['response$merchantTxnId'].'" reportGroup="'.$fields['response$reportGroup'].'" customerId="'.$fields['customerId'].'">
            <orderId>'.$fields['response$orderId'].'</orderId>
            <amount>'.number_format($fields['amount']*100,0,'.','').'</amount>
            <orderSource>ecommerce</orderSource>
            <billToAddress>
                <name>'.$fields['name'].'</name>
                <addressLine1>'.$fields['customer$Address'].'</addressLine1>
                <city>'.$fields['customer$City'].'</city>
                <state>'.$fields['customer$State'].'</state>
                <zip>'.$fields['customer$Zip'].'</zip>
                <country>'.$fields['customer$Country'].'</country>
                <email>'.$fields['customer$Email'].'</email>
                <phone>'.$fields['customer$Phone'].'</phone>
            </billToAddress>
            <paypage>
                <paypageRegistrationId>'.$fields['paypageRegistrationId'].'</paypageRegistrationId>
            </paypage>
        </authorization>
      </litleOnlineRequest>';
      
      return($xml);
}



function CallAPI($method, $url, $data = false, $platform = "litle")
{
    $curl = curl_init();

    switch ($method)
    {
        case "POST":
            curl_setopt($curl, CURLOPT_POST, 1);

            if ($data)
                curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
            break;
        case "PUT":
            curl_setopt($curl, CURLOPT_PUT, 1);
            break;
        default:
            if ($data)
                $url = sprintf("%s?%s", $url, http_build_query($data));
    }

    // Optional Authentication:
    //curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
    //curl_setopt($curl, CURLOPT_USERPWD, $_POST['username'].':'.$_POST['password']);

    if ($platform == "litle")      curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type:text/xml; charset=utf-8'));
	if ($platform == "mercurypay") curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type:text/xml; charset=utf-8','SOAPAction: "http://www.mercurypay.com/CreditTransaction"'));
	curl_setopt($curl, CURLOPT_VERBOSE, true);
	curl_setopt($curl, CURLOPT_STDERR, fopen('php://stderr', 'w'));	
	if ($platform == "litle")      curl_setopt($curl, CURLOPT_HTTPHEADER, array('Expect:'));
		
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
	
	curl_setopt($curl, CURLINFO_HEADER_OUT, true);

    $result = curl_exec($curl);

    
	// Uncomment the lines below to debug the structure of the CURL request to see headers
	//echo '<pre>';
	//$information = curl_getinfo($curl);
	//print_r($information);
	//echo '</pre>';
	
	curl_close($curl);

    return $result;
}




?>