<?php
require_once("inc/functions.php");
require_once("inc/connect.php");

$requests = $_GET;
$installshop = $_GET['shop'];
$hmac = $_GET['hmac'];
$serializeArray = serialize($requests);
$requests = array_diff_key($requests, array( 'hmac' => '' ));
ksort($requests);

$sql = "SELECT * FROM example_table WHERE store_url='" . $requests['shop'] . "' LIMIT 1";
$result = mysqli_query( $conn, $sql );
$row = mysqli_fetch_assoc($result);

$var = "Hello, I am string using replaced ";

$token = $row['access_token'];
$shop = str_replace(".myshopify.com", "", $row['store_url']);


$installshop = $_GET['shop'];

if ($token) {
	header('Location: https://'.$installshop.'/admin/apps/php-my-app');
  };


// Set variables for our request
$shop = $_GET['shop'];
$api_key = getenv('SHOPIFY_API_KEY');
$scopes = "read_customers,read_orders,read_themes,write_themes,read_script_tags,write_script_tags";
$redirect_uri = "https://auto-redirector-pro.herokuapp.com/generate_token.php";

// Build install/approval URL to redirect to
$install_url = "https://" . $shop . "/admin/oauth/authorize?client_id=" . $api_key . "&scope=" . $scopes . "&redirect_uri=" . urlencode($redirect_uri);

// Redirect

header("Location: " . $install_url);
die();
