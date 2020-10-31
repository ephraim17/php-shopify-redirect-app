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

$token1 = $row['access_token'];
$shop1 = $row['store_url'];

$var = "Hello, I am string using replaced ";

$token = $row['access_token'];
$shop = str_replace(".myshopify.com", "", $row['store_url']);

// echo $var;
// echo $row['access_token'];
// echo $row['store_url'];
// echo str_replace(".myshopify.com", "", $row['store_url']);


// $recurring_array = array(
// 	'recurring_application_charge' => array(
// 		'name' => 'Example Plan',
// 		'test' => true,  //remove this line before sending to app store
// 		'price' => 4.99,
// 		'return_url' => "https://" . $row['store_url'] . "/admin/apps/php-my-app/?" . $_SERVER['QUERY_STRING']
// 	)
// );



// $charge = shopify_call($token, $shop, "/admin/api/2020-10/recurring_application_charges.json", $recurring_array, 'POST');
// $charge = json_decode($charge['response'], JSON_PRETTY_PRINT);


// header('Location: ' . $charge['recurring_application_charge']['confirmation_url'] );
// exit();

//Product and Product Images
$image = "";
$title = "";

$collectionList = shopify_call($token, $shop, "/admin/api/2020-04/custom-collections.json", array(), 'GET');
$collectionList = json_decode($collectionList['response'], JSON_PRETTY_PRINT);
$collection_id = $collectionList['custom_collections'][0]['id'];

$collects = shopify_call($token, $shop, "/admin/api/2020-04/collects.json", array("collection_id"=>$collection_id), "GET");
$collects = json_decode($collects['response'], JSON_PRETTY_PRINT);

foreach ($collects as $collect) {
	foreach($collect as $key => $value) {
		$products = shopify_call($token, $shop, "/admin/api/2020-04/products/" . $value['product_id'] . ".json", array(), "GET");
		$products = json_decode($products['response'], JSON_PRETTY_PRINT);

		$images = shopify_call($token, $shop, "/admin/api/2020-04/products/" . $value['product_id'] . "/images.json", array(), "GET");
		$images = json_decode($images['response'], JSON_PRETTY_PRINT);


		 $image = $images['images'][0]['src'];
         $title = $products['product']['title'];

	}
}

// Based on 4th video
$theme = shopify_call($token, $shop, "/admin/api/2020-04/themes.json", array(), "GET");
$theme = json_decode($theme['response'], JSON_PRETTY_PRINT);

//echo print_r($theme);

foreach ($theme as $curr_theme) {
	foreach($curr_theme as $key => $value) {
		if($value['role'] === 'main') {

			//echo "Theme ID: " . $value['id'] . "<br/>";
			//echo "Theme Name: " . $value['name'] . "<br/>";

			/*$array = array(
   				"asset" => array(
 					"key" => "templates/index.liquid",
 					"value" => "<script>document.querySelector('.h1').innerText = 'SHOPIFY 10';</script>"
   				)
			);*/

			$assets = shopify_call($token, $shop, "/admin/api/2020-04/themes/" . $value['id'] . "/assets.json", $array, "PUT");
		    $assets = json_decode($assets['response'], JSON_PRETTY_PRINT);

		}
	}
}



$script_array = array(
 	"script_tag" => array(
 	"event" => "onload",
 	"src" => "https://ephraim17.github.io/Blue-Dragonfly/script.js"
 )
);

$scriptTag = shopify_call($token, $shop, "/admin/api/2020-04/script_tags.json", $script_array, "POST");
$scriptTag = json_decode($scriptTag['response'], JSON_PRETTY_PRINT);



 ?>

 
 <!DOCTYPE html>
 <html>
 <head>
 	<title>Replaced Shopify Example App</title>
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
 <h1>Now redirecting</h1><div style="--top-bar-background:#00848e; --top-bar-background-lighter:#1d9ba4; --top-bar-color:#f9fafb; --p-frame-offset:0px;"><span class="Polaris-Spinner Polaris-Spinner--colorTeal Polaris-Spinner--sizeLarge"><svg viewBox="0 0 44 44" xmlns="http://www.w3.org/2000/svg">
      <path d="M15.542 1.487A21.507 21.507 0 00.5 22c0 11.874 9.626 21.5 21.5 21.5 9.847 0 18.364-6.675 20.809-16.072a1.5 1.5 0 00-2.904-.756C37.803 34.755 30.473 40.5 22 40.5 11.783 40.5 3.5 32.217 3.5 22c0-8.137 5.3-15.247 12.942-17.65a1.5 1.5 0 10-.9-2.863z"></path>
    </svg></span><span role="status"><span class="Polaris-VisuallyHidden">Spinner example</span></span></div>
</div>

 	
 </body>
 </html>
