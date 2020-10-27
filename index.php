<?php

require_once("inc/functions.php");

$request = $_GET;
$hmac = $_GET['hmac'];
$serializeArray = serialize($request);
$requests = array_diff_key($requests, array('hmac' => ''));
ksort($requests);

$token = "";
$shop = "redirect-to-checkout.myshopify.com";

$collectionList = shopify_call($token, $shop, "/admin/api/2020-10/custome_collection.json", array(), 'GET');
$collectionList = json_decode($collectionList['response'], JSON_PRETTY_PRINT);
