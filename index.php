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

$var = "Hello, I am string using replaced ";

$token = $row['access_token'];
$shop = str_replace(".myshopify.com", "", $row['store_url']);

if (empty($token)) {
	header("Location: install.php?shop=" . $requests['shop']);

  };

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



//  shopify_call($token, $shop, "/admin/api/2020-10/script_tags.json", $script_array, "POST");
$scriptTag_check = shopify_call($token, $shop, "/admin/api/2020-04/script_tags.json", "GET");
$scriptTag_check = json_decode($scriptTag_check['response'], JSON_PRETTY_PRINT);

echo $scriptTag_check['response'];

// if ($scriptTag_check['src'] === 'eph') {

// }




/*
if $scriptTag contains ephraim mulilo script tag, dont run
*/



 ?>
<!DOCTYPE html>
 <html>
 <head>
 	<title>Redirect To Checkout</title>
	 <link
  rel="stylesheet"
  href="https://unpkg.com/@shopify/polaris@5.0.0/dist/styles.css"
/>


 </head>
 <body>

<script>
$(document).read(function(){
    $("#click-button").click(function(){
        $.ajax({
        url: "script.php",
        method:"POST",
        data:"token=buttonclick",
        success: function(result){
            if(result != "fail"){
                //Perform actions with the results...
            }
        }});
    });
});
</script>

 <div class="center">
 <h1>Now redirecting customers.</h1><div style="--top-bar-background:#00848e; --top-bar-background-lighter:#1d9ba4; --top-bar-color:#f9fafb; --p-frame-offset:0px;"><span class="Polaris-Spinner Polaris-Spinner--colorTeal Polaris-Spinner--sizeLarge">
</div>

	<p>If this application worked for you, then please leave a review so it can help others as well. If you are having problems then please contact us via the chat bot and we will help you out!</p>	 <script src="//code.tidio.co/emvrdv8i57vs6jajetqwiei3azx8t5wf.js" async></script>
	<div style="--top-bar-background:#00848e; --top-bar-background-lighter:#1d9ba4; --top-bar-color:#f9fafb; --p-frame-offset:0px;"><button type="button" class="Polaris-Button Polaris-Button--primary"><span class="Polaris-Button__Content"><span class="Polaris-Button__Text">Start Redirecting</span></span></button></div>
	<a href="upgrade.php?<?php echo $_SERVER['QUERY_STRING']; ?>" target="_blank">Upgrade</a>
 	
 </body>
 </html>
