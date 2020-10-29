<?php

$host = "eu-cdbr-west-03.cleardb.net";
$username = "bfdbe3822d6e93";
$password = "fa50e3e6";
$dbname = "heroku_c9f515d96d37b64";

$conn = mysqli_connect( $host, $username, $password, $dbname );

if ( !$conn ) {

    die( "Connect was not successful: " . mysqli_connect_error() );
}