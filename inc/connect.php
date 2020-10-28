<?php

$host = "mysql://bfdbe3822d6e93:fa50e3e6@eu-cdbr-west-03.cleardb.net/heroku_c9f515d96d37b64?reconnect=true";
$username = "bfdbe3822d6e93";
$password = "fa50e3e6";
$dbname = "bfdbe3822d6e93";

$conn = mysqli_connect( $host, $username, $password, $dbname );

if ( !$conn ) {

    die( "Connect was not successful: " . mysqli_connect_error() );
}
