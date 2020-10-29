<?php

// Set variables for our request
$shop = $_GET['shop'];
$api_key = "70bdfe1c895cdcbf82f069556f38baa0";
$scopes = "read_customers,write_customers,read_orders,write_products,read_themes,write_themes,write_script_tags";
$redirect_uri = "https://php-shopify-app.herokuapp.com/generate_token.php";

// Build install/approval URL to redirect to
$install_url = "https://" . $shop . ".myshopify.com/admin/oauth/authorize?client_id=" . $api_key . "&scope=" . $scopes . "&redirect_uri=" . urlencode($redirect_uri);

// Redirect
header("Location: " . $install_url);
die();