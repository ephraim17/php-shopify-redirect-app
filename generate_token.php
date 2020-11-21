<?php

// Get our helper functions
require_once("inc/functions.php");
require_once("inc/connect.php");



// Set variables for our request
$api_key = getenv('SHOPIFY_API_KEY');
$shared_secret = getenv('SHOPIFY_SHARED_SECRET');
$params = $_GET; // Retrieve all request parameters
$hmac = $_GET['hmac']; // Retrieve HMAC request parameter

$shop_url = $params['shop'];

$params = array_diff_key($params, array('hmac' => '')); // Remove hmac from params
ksort($params); // Sort params lexographically

$computed_hmac = hash_hmac('sha256', http_build_query($params), $shared_secret);

// Use hmac data to check that the response is from Shopify or not
if (hash_equals($hmac, $computed_hmac)) {

	// Set variables for our request
	$query = array(
		"client_id" => $api_key, // Your API key
		"client_secret" => $shared_secret, // Your app credentials (secret key)
		"code" => $params['code'] // Grab the access key from the URL
	);

	// Generate access token URL
	$access_token_url = "https://" . $params['shop'] . "/admin/oauth/access_token";

	// Configure curl client and execute request
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_URL, $access_token_url);
	curl_setopt($ch, CURLOPT_POST, count($query));
	curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($query));
	$result = curl_exec($ch);
	curl_close($ch);

	// Store the access token
	$result = json_decode($result, true);
	$access_token = $result['access_token'];

	// Show the access token (don't do this in production!)
	//echo $access_token;

	$sql = "INSERT INTO example_table (store_url, access_token, install_date)
	VALUES ('".$params['shop']."', '".$access_token."', NOW())";

	if (mysqli_query($conn, $sql)) {
	
		header('Location: https://'.$params['shop'].'/admin/apps/php-my-app');
		die();
	
	} else {
	
		echo "Error inserting new record: " . mysqli_error($conn);
	
	}

} else {
	// Someone is trying to be shady!
	//Where the fuck did we come from?

	$_SESSION['page'] = $_SERVER['HTTP_REFERER'];
	echo $_SESSION['page'];
	echo 'hi';
	die('This request is NOT from Shopify!');
}
