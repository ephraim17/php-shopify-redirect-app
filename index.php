<?php

require_once("inc/functions.php");

$request = $_GET;
$hmac = $_GET['hmac'];
$serializeArray = serialize($request);
$requests = array_diff_key($requests, array('hmac' => ''));
ksort($requests);

$parsedUrl = parse_url('https://'.$params['shop']);
$host = explode('.', $parsedUrl['host']);
$subdomain = $host[0];

$shop = $subdomain;
$token = "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";
//$shop = "redirect-to-checkout.myshopify.com";

$array = array(
	'script_tag' => array(
		'event' => 'onload', 
		'src' => 'https://ephraim17.github.io/Blue-Dragonfly/script.js'
	)
);

$scriptTag = shopify_call($token, "https://daywalkers-app-test-store.myshopify.com/", "/admin/api/2020-10/script_tags.json", $array, 'POST');
$scriptTag = json_decode($scriptTag['response'], JSON_PRETTY_PRINT);


?>

<!DOCTYPE html>
<html>
    <head>
        <title>Redirect to checkout</title>
            <body>
                <h1> hi waddup my dawg</h1>
            </body>
        </title>
    </head>
</html>
