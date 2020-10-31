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

echo $var;
echo $row['access_token'];
echo $row['store_url'];
echo str_replace(".myshopify.com", "", $row['store_url']);

$recurring_array = array(
	'recurring_application_charge' => array(
		'name' => 'Example Plan',
		'test' => true,  //remove this line before sending to app store
		'price' => 4.99,
		'return_url' => "https://" . $row['store_url'] . "/admin/apps/php-my-app/?" . $_SERVER['QUERY_STRING']
	)
);



$recurring_charge = shopify_call($token, $shop, "/admin/api/2020-10/recurring_application_charges.json", $recurring_array, 'POST');
$recurring_charge = json_decode($charge['response'], JSON_PRETTY_PRINT);

echo '<script>top.window.location - "'. $recurring_charge['recurring_application_charge']['confirmation_url'].'"</script>';
die;
// if( isset($_GET['charge_id']) && $_GET['charge_id'] != '' ) {
// 	$charge_id = $_GET['charge_id'];

// 	$array = array(
// 		'recurring_application_charge' => array(
// 			"id" => $charge_id,
// 		    "name" => "Example Plan",
// 		    "api_client_id" => rand(1000000, 9999999),
// 		    "price" => "1.00",
// 		    "status" => "accepted",
// 		    "return_url" => "https://weeklyhow.myshopfy.com/admin/apps/exampleapp-14",
// 		    "billing_on" => null,
// 		    "test" => true,
// 		    "activated_on" => null,
// 		    "trial_ends_on" => null,
// 		    "cancelled_on" => null,
// 		    "trial_days" => 0,
// 		    "decorated_return_url" => "https://weeklyhow.myshopfy.com/admin/apps/exampleapp-14/?charge_id=" . $charge_id
// 		)
// 	);

// 	$activate = shopify_call($token, $shop, "/admin/api/2019-10/recurring_application_charges/".$charge_id."/activate.json", $array, 'POST');
// 	$activate = json_decode($activate['response'], JSON_PRETTY_PRINT);

// 	print_r($activate);
	
// }

//Idea Index check if charge id exists. Index is just a redirecting page.




 ?>

 <!DOCTYPE html>
 <html>
 <head>
 	<title>Replaced Shopify Example App</title>
 </head>
 <body>
 	<h1>Shopify Example App</h1>
 	<img src="<?php echo $image; ?>" style="width:250px;">
 	<p><?php echo $title; ?></p>
 </body>
 </html>
