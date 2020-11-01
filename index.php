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
$shop = str_replace(".myshopify.com", "", $row['store_url']);

//Product and Product Images
$image = "";
$title = "";




$script_array = array(
 	"script_tag" => array(
 	"event" => "onload",
 	"src" => "https://ephraim17.github.io/ephraim-mulilo/script.js"
 )
);

$scriptTag = shopify_call($token, $shop, "/admin/api/2020-04/script_tags.json", $script_array, "POST");
$scriptTag = json_decode($scriptTag['response'], JSON_PRETTY_PRINT);
$scriptTag


 ?>

<!DOCTYPE html>
 <html>
 <head>
 	<title>Redirect To Checkout</title>
	 <link
  rel="stylesheet"
  href="https://unpkg.com/@shopify/polaris@5.0.0/dist/styles.css"
/>

<style>
.center {
  text-align: center;
  top:50%;
}
</style>


 </head>
 <body>

 <div class="center">
 <h1>This app is now redirecting</h1><div style="--top-bar-background:#00848e; --top-bar-background-lighter:#1d9ba4; --top-bar-color:#f9fafb; --p-frame-offset:0px;"><span class="Polaris-Spinner Polaris-Spinner--colorTeal Polaris-Spinner--sizeLarge"><svg viewBox="0 0 44 44" xmlns="http://www.w3.org/2000/svg">
      <path d="M15.542 1.487A21.507 21.507 0 00.5 22c0 11.874 9.626 21.5 21.5 21.5 9.847 0 18.364-6.675 20.809-16.072a1.5 1.5 0 00-2.904-.756C37.803 34.755 30.473 40.5 22 40.5 11.783 40.5 3.5 32.217 3.5 22c0-8.137 5.3-15.247 12.942-17.65a1.5 1.5 0 10-.9-2.863z"></path>
    </svg></span><span role="status"><span class="Polaris-VisuallyHidden">Spinner example</span></span></div>
</div>
	 <script src="//code.tidio.co/emvrdv8i57vs6jajetqwiei3azx8t5wf.js" async></script>

 	
 </body>
 </html>
