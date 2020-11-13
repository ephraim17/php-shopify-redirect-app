<?php

// Set variables for our request
$shop = $_GET['shop'];
$api_key = getenv('SHOPIFY_API_KEY');
$scopes = "read_customers,write_customers,read_orders,write_products,read_themes,write_themes,write_script_tags";
$redirect_uri = "https://auto-redirector-pro.herokuapp.com/generate_token.php";

// Build install/approval URL to redirect to
$install_url = "https://" . $shop . "/admin/oauth/authorize?client_id=" . $api_key . "&scope=" . $scopes . "&redirect_uri=" . urlencode($redirect_uri);

// Redirect
header("Location: " . $install_url);
die();
