<?php


require(dirname(__FILE__).'/includes/helper_funcs.php');

/*
ini_set('display_errors', 'On');
require __DIR__ . '/vendor/autoload.php';
use Jose\Factory\JWKFactory;
use Jose\Loader;
*/


?>




<!--
// We create our key object (JWK) using a public RSA key stored in a file 
function decrypt_payload($encrypted_payload,$shared_secret_key)
{
   $shared_secret_key = base64_encode($shared_secret_key);    $keys = JWKFactory::createFromValues([
      'kty' => 'oct',
      'k' => $shared_secret_key
   ]);
   $loader = new Loader();
   // The payload is decrypted using our key.
$jwt = $loader->loadAndDecryptUsingKey(
         $encrypted_payload, // The input to load and decrypt
         $keys, // The symmetric or private key
         ['A256KW'], // A list of allowed key encryption algorithms
         ['A256CBC-HS512'],
         $recipient_index);

   $decrypted_payload = json_encode($jwt->getPayload(),JSON_UNESCAPED_SLASHES);
   return $decrypted_payload;
}

-->

<html>



<head>
  <meta charset="UTF-8">
  <title>Vantiv Visa Checkout Demo</title>
  
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/meyer-reset/2.0/reset.min.css">
 
  <link rel='stylesheet prefetch' href='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css'>
  <link rel='stylesheet prefetch' href='https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css'>
 
  <link rel="stylesheet" href="https://e42fb64d.servage-customer.net/vantiv/aec_demo/css/style.css">  
  
  <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>


 </head>
 
 <body>
 
 <?php
 
 echo "<h2>Variables POSTed to web server</h2>";
 
 $variables_posted = print_r($_POST, true);
 
 echo '<textarea rows="20" style="width:100%;">';
 echo $variables_posted;
 echo '</textarea>';
 
 $xml = getAuth($_POST);
 
 
 
 echo "<h2>Authorization Request constructed on Web Server</h2>";
 
 echo '<textarea rows="20" style="width:100%;">';
 echo $xml;
 echo '</textarea>';
 
 
 $auth_result = CallAPI("POST", $_POST['endpoint'], $xml);
 $result_xml = simplexml_load_string($auth_result);

 
 echo "<h2>Response from Vantiv eCommerce endpoint</h2>";
 
 echo '<textarea rows="20" style="width:100%;">';
 echo $auth_result;
 //echo $result_xml;
 echo "</textarea>";
 
 ?>
 
 <a href="index.php">Perform another transaction</a>
 </body>
 
 </html>