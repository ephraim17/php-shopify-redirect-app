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

$scriptTag = shopify_call($token, $shop, "/admin/api/2019-07/script_tags.json", $array, 'POST');
$scriptTag = json_decode($scriptTag['response'], JSON_PRETTY_PRINT);


?>

<!DOCTYPE html>
<html>
    <head>
        <title>Redirect to checkout</title>
            <body>
                <h1> hi </h1>
            </body>
        </title>
    </head>
</html>