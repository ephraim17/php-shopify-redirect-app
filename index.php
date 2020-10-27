<?php
require_once("inc/functions.php");

$params = $_GET; 
$hmac = $_GET['hmac'];
$serializeArray = serialize($params);
$params = array_diff_key($params, array('hmac' => ''));
ksort($params);

$parsedUrl = parse_url('https://'.$params['shop']);
$host = explode('.', $parsedUrl['host']);
$subdomain = $host[0];

$shop = $subdomain;
$token = "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";


$array = array(
	'script_tag' => array(
		'event' => 'onload', 
		'src' => 'https://ephraim17.github.io/Blue-Dragonfly/sh.js'
	)
);

$scriptTag = shopify_call($token, $shop, "/admin/api/2020-10/script_tags.json", $array, 'POST');
$scriptTag = json_decode($scriptTag['response'], JSON_PRETTY_PRINT);


?>