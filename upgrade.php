<?php
require_once("inc/functions.php");
require_once("inc/connect.php");

$requests = $_GET;
$hmac = $_GET['hmac'];
$serializeArray = serialize($requests);
$requests = array_diff_key($requests, array( 'hmac' => '' ));
ksort($requests);

$sql = "SELECT * FROM example_table WHERE store_url='" . $requests['shop'] . "' LIMIT 1";
$result = mysqli_query( $conn, $sql );
$row = mysqli_fetch_assoc($result);

$token = $row['access_token'];
$shop = $row['store_url'];


$array = array(
	'recurring_application_charge' => array(
		'name' => 'Redirect To Checkout',
		'test' => true,  //remove this line before sending to app store
		'price' => 4.99,
		'return_url' => "https://" . $shop . '/admin/apps/php-my-app/?' . $_SERVER['QUERY_STRING']
	)
);

$charge = shopify_call($token, $shop, "/admin/api/2020-10/recurring_application_charges.json", $array, 'POST');
$charge = json_decode($charge['response'], JSON_PRETTY_PRINT);

header('Location: ' . $charge['recurring_application_charge']['confirmation_url'] );
exit();

?>