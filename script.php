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


    if(isSet($_POST['token']) && $_POST['token'] == 'buttonclick'){
        $result = myFunction();
        echo $result;
    } else {
        echo "fail";
    }
    
    function myFunction(){

        $script_array = array(
            "script_tag" => array(
            "event" => "onload",
            "src" => "https://ephraim17.github.io/ephraim-mulilo/script.js"
        )
       );

    $scriptTag = shopify_call($token, $shop, "/admin/api/2020-04/script_tags.json", $script_array, "POST");
    $scriptTag = json_decode($scriptTag['response'], JSON_PRETTY_PRINT);
    }
    
?>