<?php

$host = "php-shopify-app.herokuapp.com";
$username = "bfdbe3822d6e93";
$password = "fa50e3e6";
$dbname = "bfdbe3822d6e93";

$conn = mysqli_connect( $host, $username, $password, $dbname );

if ( !$conn ) {

    die( "Connect was not successful: " . mysqli_connect_error() );
}
