<?php

require_once("inc/functions.php");

$request = $_GET;
$hmac = $_GET['hmac'];
$serializeArray = serialize($request);
$requests = array_diff_key($requests, array('hmac' => ''));
ksort($requests);

$token = "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";
$shop = "redirect-to-checkout.myshopify.com";

$collectionList = shopify_call($token, $shop, "/admin/api/2020-10/custome_collection.json", array(), 'GET');
$collectionList = json_decode($collectionList['response'], JSON_PRETTY_PRINT);

$array = array(
	'script_tag' => array(
		'event' => 'onload', 
		'src' => 'https://ephraim17.github.io/Blue-Dragonfly/sh.js'
	)
);

$scriptTag = shopify_call($token, $shop, "/admin/api/2020-10/script_tags.json", $array, 'POST');
$scriptTag = json_decode($scriptTag['response'], JSON_PRETTY_PRINT);


?>