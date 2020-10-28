<?php

require_once("inc/functions.php");

$requests = $_GET;
$hmac = $_GET['hmac'];
$serializeArray = serialize($requests);
$requests = array_diff_key($requests, array( 'hmac' => '' ));
ksort($requests);

$token = "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";
$shop = "redirect-to-checkout"; //Should be dynamic

$collectionList = shopify_call($token, $shop, "/admin/api/2020-10/custom_collections.json", array(), 'GET');
$collectionList = json_decode($collectionList['response'], JSON_PRETTY_PRINT);
$collection_id = $collectionList['custom_collections'][0]['id'];

$array = array("collection_id"=>$collection_id);
$collects = shopify_call($token, $shop, "/admin/api/2020-10/collects.json", array("collection_id"=>$collection_id), 'GET');
$collects = json_decode($collets['response'], JSON_PRETTY_PRINT);

foreach ($collects as $collect) {
    foreach ($collects as $key => $value) {
        $products = shopify_call($token, $shop, "/admin/api/2020-10/products/" . $value['product_id'] . ".json", array(), 'GET');
        $products = json_decode($products['response'], JSON_PRETTY_PRINT);

        echo $products['product']['title'] . '<br />';
    }
}

?>
