
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


echo $requests = array_diff_key($requests, array( 'hmac' => '' ));

if (empty($token)) {
	header("Location: /install.php?shop=" . $installshop);
  };

  echo header("Location: /install.php?shop=" . $installshop);
  echo $installshop;

  echo $_SERVER['HTTP_REFERER'];
  echo 'that was the referrer';

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
};

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
};



//  shopify_call($token, $shop, "/admin/api/2020-10/script_tags.json", $script_array, "POST");

// $scriptTag_checck = shopify_call($token, $shop, "/admin/api/2020-10/script_tags.json?src=https://ephraim17.github.io/ephraim-mulilo/script.js", array(), "GET");
// $scriptTag_checck = json_decode($scriptTag['response'], JSON_PRETTY_PRINT);

//echo $scriptTag_check;
// /admin/api/2020-10/script_tags.json?src=https://js-aplenty.com/foo.js


$ttheme = shopify_call($token, $shop, "/admin/api/2020-10/script_tags.json", "GET");
$ttheme = json_decode($ttheme['response'], JSON_PRETTY_PRINT);


if (!$ttheme['script_tags']) {

	$script_array = array(
		"script_tag" => array(
		"event" => "onload",
		"src" => "https://ephraim17.github.io/ephraim-mulilo/script.js"
	)
   );
   
	   $scriptTag = shopify_call($token, $shop, "/admin/api/2020-04/script_tags.json", $script_array, "POST");
	   $scriptTag = json_decode($scriptTag['response'], JSON_PRETTY_PRINT);

  } else {

	$decoded = json_encode($ttheme['script_tags']);

	if (strpos($decoded, 'ephraim17.github.io\/ephraim-mulilo\/script.js') !== false) {

		echo 'Please leave a review to support the developer of this app';

	} else {
		echo 'Please leave a review to support the developer of this app';

		$script_array = array(
			"script_tag" => array(
			"event" => "onload",
			"src" => "https://ephraim17.github.io/ephraim-mulilo/script.js"
		)
	   );
	   
		   $scriptTag = shopify_call($token, $shop, "/admin/api/2020-04/script_tags.json", $script_array, "POST");
		   $scriptTag = json_decode($scriptTag['response'], JSON_PRETTY_PRINT);

	};
  };



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
  margin-right: 150px;
  margin-left: 80px;
}
</style>


 </head>
 <body>

	 <div style="height: 250px;">
  <div style="--p-background:rgba(246, 246, 247, 1); --p-background-hovered:rgba(241, 242, 243, 1); --p-background-pressed:rgba(237, 238, 239, 1); --p-background-selected:rgba(237, 238, 239, 1); --p-surface:rgba(255, 255, 255, 1); --p-surface-neutral:rgba(228, 229, 231, 1); --p-surface-neutral-hovered:rgba(219, 221, 223, 1); --p-surface-neutral-pressed:rgba(201, 204, 208, 1); --p-surface-neutral-disabled:rgba(241, 242, 243, 1); --p-surface-neutral-subdued:rgba(246, 246, 247, 1); --p-surface-subdued:rgba(250, 251, 251, 1); --p-surface-disabled:rgba(250, 251, 251, 1); --p-surface-hovered:rgba(246, 246, 247, 1); --p-surface-pressed:rgba(241, 242, 243, 1); --p-surface-depressed:rgba(237, 238, 239, 1); --p-backdrop:rgba(0, 0, 0, 0.5); --p-overlay:rgba(255, 255, 255, 0.5); --p-shadow-from-dim-light:rgba(0, 0, 0, 0.2); --p-shadow-from-ambient-light:rgba(23, 24, 24, 0.05); --p-shadow-from-direct-light:rgba(0, 0, 0, 0.15); --p-hint-from-direct-light:rgba(0, 0, 0, 0.15); --p-on-surface-background:rgba(241, 242, 243, 1); --p-border:rgba(140, 145, 150, 1); --p-border-neutral-subdued:rgba(186, 191, 195, 1); --p-border-hovered:rgba(153, 158, 164, 1); --p-border-disabled:rgba(210, 213, 216, 1); --p-border-subdued:rgba(201, 204, 207, 1); --p-border-depressed:rgba(87, 89, 89, 1); --p-border-shadow:rgba(141, 145, 150, 1); --p-border-shadow-subdued:rgba(187, 191, 195, 1); --p-divider:rgba(225, 227, 229, 1); --p-icon:rgba(92, 95, 98, 1); --p-icon-hovered:rgba(26, 28, 29, 1); --p-icon-pressed:rgba(68, 71, 74, 1); --p-icon-disabled:rgba(186, 190, 195, 1); --p-icon-subdued:rgba(140, 145, 150, 1); --p-text:rgba(32, 34, 35, 1); --p-text-disabled:rgba(140, 145, 150, 1); --p-text-subdued:rgba(109, 113, 117, 1); --p-interactive:rgba(44, 110, 203, 1); --p-interactive-disabled:rgba(189, 193, 204, 1); --p-interactive-hovered:rgba(31, 81, 153, 1); --p-interactive-pressed:rgba(16, 50, 98, 1); --p-focused:rgba(69, 143, 255, 1); --p-surface-selected:rgba(242, 247, 254, 1); --p-surface-selected-hovered:rgba(237, 244, 254, 1); --p-surface-selected-pressed:rgba(229, 239, 253, 1); --p-icon-on-interactive:rgba(255, 255, 255, 1); --p-text-on-interactive:rgba(255, 255, 255, 1); --p-action-secondary:rgba(255, 255, 255, 1); --p-action-secondary-disabled:rgba(255, 255, 255, 1); --p-action-secondary-hovered:rgba(246, 246, 247, 1); --p-action-secondary-pressed:rgba(241, 242, 243, 1); --p-action-secondary-depressed:rgba(109, 113, 117, 1); --p-action-primary:rgba(0, 128, 96, 1); --p-action-primary-disabled:rgba(241, 241, 241, 1); --p-action-primary-hovered:rgba(0, 110, 82, 1); --p-action-primary-pressed:rgba(0, 94, 70, 1); --p-action-primary-depressed:rgba(0, 61, 44, 1); --p-icon-on-primary:rgba(255, 255, 255, 1); --p-text-on-primary:rgba(255, 255, 255, 1); --p-surface-primary-selected:rgba(241, 248, 245, 1); --p-surface-primary-selected-hovered:rgba(179, 208, 195, 1); --p-surface-primary-selected-pressed:rgba(162, 188, 176, 1); --p-border-critical:rgba(253, 87, 73, 1); --p-border-critical-subdued:rgba(224, 179, 178, 1); --p-border-critical-disabled:rgba(255, 167, 163, 1); --p-icon-critical:rgba(215, 44, 13, 1); --p-surface-critical:rgba(254, 211, 209, 1); --p-surface-critical-subdued:rgba(255, 244, 244, 1); --p-surface-critical-subdued-hovered:rgba(255, 240, 240, 1); --p-surface-critical-subdued-pressed:rgba(255, 233, 232, 1); --p-surface-critical-subdued-depressed:rgba(254, 188, 185, 1); --p-text-critical:rgba(215, 44, 13, 1); --p-action-critical:rgba(216, 44, 13, 1); --p-action-critical-disabled:rgba(241, 241, 241, 1); --p-action-critical-hovered:rgba(188, 34, 0, 1); --p-action-critical-pressed:rgba(162, 27, 0, 1); --p-action-critical-depressed:rgba(108, 15, 0, 1); --p-icon-on-critical:rgba(255, 255, 255, 1); --p-text-on-critical:rgba(255, 255, 255, 1); --p-interactive-critical:rgba(216, 44, 13, 1); --p-interactive-critical-disabled:rgba(253, 147, 141, 1); --p-interactive-critical-hovered:rgba(205, 41, 12, 1); --p-interactive-critical-pressed:rgba(103, 15, 3, 1); --p-border-warning:rgba(185, 137, 0, 1); --p-border-warning-subdued:rgba(225, 184, 120, 1); --p-icon-warning:rgba(185, 137, 0, 1); --p-surface-warning:rgba(255, 215, 157, 1); --p-surface-warning-subdued:rgba(255, 245, 234, 1); --p-surface-warning-subdued-hovered:rgba(255, 242, 226, 1); --p-surface-warning-subdued-pressed:rgba(255, 235, 211, 1); --p-text-warning:rgba(145, 106, 0, 1); --p-border-highlight:rgba(68, 157, 167, 1); --p-border-highlight-subdued:rgba(152, 198, 205, 1); --p-icon-highlight:rgba(0, 160, 172, 1); --p-surface-highlight:rgba(164, 232, 242, 1); --p-surface-highlight-subdued:rgba(235, 249, 252, 1); --p-surface-highlight-subdued-hovered:rgba(228, 247, 250, 1); --p-surface-highlight-subdued-pressed:rgba(213, 243, 248, 1); --p-text-highlight:rgba(52, 124, 132, 1); --p-border-success:rgba(0, 164, 124, 1); --p-border-success-subdued:rgba(149, 201, 180, 1); --p-icon-success:rgba(0, 127, 95, 1); --p-surface-success:rgba(174, 233, 209, 1); --p-surface-success-subdued:rgba(241, 248, 245, 1); --p-surface-success-subdued-hovered:rgba(236, 246, 241, 1); --p-surface-success-subdued-pressed:rgba(226, 241, 234, 1); --p-text-success:rgba(0, 128, 96, 1); --p-decorative-one-icon:rgba(126, 87, 0, 1); --p-decorative-one-surface:rgba(255, 201, 107, 1); --p-decorative-one-text:rgba(61, 40, 0, 1); --p-decorative-two-icon:rgba(175, 41, 78, 1); --p-decorative-two-surface:rgba(255, 196, 176, 1); --p-decorative-two-text:rgba(73, 11, 28, 1); --p-decorative-three-icon:rgba(0, 109, 65, 1); --p-decorative-three-surface:rgba(146, 230, 181, 1); --p-decorative-three-text:rgba(0, 47, 25, 1); --p-decorative-four-icon:rgba(0, 106, 104, 1); --p-decorative-four-surface:rgba(145, 224, 214, 1); --p-decorative-four-text:rgba(0, 45, 45, 1); --p-decorative-five-icon:rgba(174, 43, 76, 1); --p-decorative-five-surface:rgba(253, 201, 208, 1); --p-decorative-five-text:rgba(79, 14, 31, 1); --p-border-radius-base:0.4rem; --p-border-radius-wide:0.8rem; --p-border-radius-full:50%; --p-card-shadow:0px 0px 5px var(--p-shadow-from-ambient-light), 0px 1px 2px var(--p-shadow-from-direct-light); --p-popover-shadow:-1px 0px 20px var(--p-shadow-from-ambient-light), 0px 1px 5px var(--p-shadow-from-direct-light); --p-modal-shadow:0px 26px 80px var(--p-shadow-from-dim-light), 0px 0px 1px var(--p-shadow-from-dim-light); --p-top-bar-shadow:0 2px 2px -1px var(--p-shadow-from-direct-light); --p-button-drop-shadow:0 1px 0 rgba(0, 0, 0, 0.05); --p-button-inner-shadow:inset 0 -1px 0 rgba(0, 0, 0, 0.2); --p-button-pressed-inner-shadow:inset 0 1px 0 rgba(0, 0, 0, 0.15); --p-override-none:none; --p-override-transparent:transparent; --p-override-one:1; --p-override-visible:visible; --p-override-zero:0; --p-override-loading-z-index:514; --p-button-font-weight:500; --p-non-null-content:&quot;&quot;; --p-choice-size:2rem; --p-icon-size:1rem; --p-choice-margin:0.1rem; --p-control-border-width:0.2rem; --p-banner-border-default:inset 0 0.1rem 0 0 var(--p-border-neutral-subdued), inset 0 0 0 0.1rem var(--p-border-neutral-subdued); --p-banner-border-success:inset 0 0.1rem 0 0 var(--p-border-success-subdued), inset 0 0 0 0.1rem var(--p-border-success-subdued); --p-banner-border-highlight:inset 0 0.1rem 0 0 var(--p-border-highlight-subdued), inset 0 0 0 0.1rem var(--p-border-highlight-subdued); --p-banner-border-warning:inset 0 0.1rem 0 0 var(--p-border-warning-subdued), inset 0 0 0 0.1rem var(--p-border-warning-subdued); --p-banner-border-critical:inset 0 0.1rem 0 0 var(--p-border-critical-subdued), inset 0 0 0 0.1rem var(--p-border-critical-subdued); --p-badge-mix-blend-mode:luminosity; --p-thin-border-subdued:0.1rem solid var(--p-border-subdued); --p-text-field-spinner-offset:0.2rem; --p-text-field-focus-ring-offset:-0.4rem; --p-text-field-focus-ring-border-radius:0.7rem; --p-button-group-item-spacing:-0.1rem; --p-duration-1-0-0:100ms; --p-duration-1-5-0:150ms; --p-ease-in:cubic-bezier(0.5, 0.1, 1, 1); --p-ease:cubic-bezier(0.4, 0.22, 0.28, 1); --p-range-slider-thumb-size-base:1.6rem; --p-range-slider-thumb-size-active:2.4rem; --p-range-slider-thumb-scale:1.5; --p-badge-font-weight:500; --p-frame-offset:0px;">
    <div class="Polaris-Page Polaris-Page--newDesignLanguage">
      <div class="Polaris-Page-Header Polaris-Page-Header--mobileView Polaris-Page-Header--newDesignLanguage">
        <div class="Polaris-Page-Header__Row">
          <div class="Polaris-Page-Header__LeftAlign">
            <div class="Polaris-Page-Header__TitleWrapper">
              <div>
                <div class="Polaris-Header-Title__TitleAndSubtitleWrapper">
                  <div class="Polaris-Header-Title">
                    <h1 class="Polaris-DisplayText Polaris-DisplayText--sizeLarge"><span class="Polaris-TextStyle--variationStrong">Welcome To Ultimate Redirector Pro</span></h1>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="Polaris-Page__Content">
        <div class="Polaris-Layout Polaris-Layout--newDesignLanguage">
          <div class="Polaris-Layout__Section">
            <div class="Polaris-Card Polaris-Card--newDesignLanguage">
              <div class="Polaris-Card__Section">
                <div class="Polaris-SettingAction">
                  <div class="Polaris-SettingAction__Setting">Redirecting is <span class="Polaris-TextStyle--variationStrong">enabled</span>.</div>
                  <div class="Polaris-SettingAction__Action"><button type="button" class="Polaris-Button Polaris-Button--newDesignLanguage Polaris-Button--primary"><span class="Polaris-Button__Content"><span class="Polaris-Button__Text">Enable</span></span></button></div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
 	
 </body>
 </html>​
2
<?php 
3
require_once("inc/functions.php");
4
require_once("inc/connect.php");
5
​
6
​
7
$requests = $_GET;
8
$installshop = $_GET['shop'];
9
$hmac = $_GET['hmac'];
10
$serializeArray = serialize($requests);
11
$requests = array_diff_key($requests, array( 'hmac' => '' ));
12
ksort($requests);
13
​
14
$sql = "SELECT * FROM example_table WHERE store_url='" . $requests['shop'] . "' LIMIT 1";
15
$result = mysqli_query( $conn, $sql );
16
$row = mysqli_fetch_assoc($result);
17
​
18
$var = "Hello, I am string using replaced ";
19
​
20
$token = $row['access_token'];
21
$shop = str_replace(".myshopify.com", "", $row['store_url']);
22
​
23
​
24
echo $requests = array_diff_key($requests, array( 'hmac' => '' ));
25
​
26
if (empty($token)) {
27
        header("Location: http://auto-redirector-pro.herokuapp.com/install.php?shop=" . $installshop);
28
  };
29
​
30
​
31
  echo $_SERVER['HTTP_REFERER'];
32
  echo 'that was the referrer';
33
​
34
//Product and Product Images
35
$image = "";
36
$title = "";
37
​
38
$collectionList = shopify_call($token, $shop, "/admin/api/2020-04/custom-collections.json", array(), 'GET');
39
$collectionList = json_decode($collectionList['response'], JSON_PRETTY_PRINT);
40
$collection_id = $collectionList['custom_collections'][0]['id'];
41
​
42
$collects = shopify_call($token, $shop, "/admin/api/2020-04/collects.json", array("collection_id"=>$collection_id), "GET");
43
$collects = json_decode($collects['response'], JSON_PRETTY_PRINT);
44
​
45
foreach ($collects as $collect) {
