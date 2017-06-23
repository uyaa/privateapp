<?php

define('SHOPIFY_APP_SECRET', 'c7c669693ecabc5cc620bc62628e00a9cbe49c38e2e102d16918d5f7991a7206');

function verify_webhook($data, $hmac_header)
{
  $calculated_hmac = base64_encode(hash_hmac('sha256', $data, SHOPIFY_APP_SECRET, true));
  return ($hmac_header == $calculated_hmac);
}


$hmac_header = $_SERVER['HTTP_X_SHOPIFY_HMAC_SHA256'];
$data = file_get_contents('php://input');
$verified = verify_webhook($data, $hmac_header);
error_log('Webhook verified: '.var_export($verified, true)); //check error.log to see the result
error_log(var_export($data, true)); //check error.log to see the result

if($verified) {
	file_put_contents("latest_json.json", $data);
}

?>