<?php

$host = "eu-cdbr-west-03.cleardb.net";
$username = getenv('DB_Username');
$password = getenv('DB_Password');
$dbname = "heroku_c9f515d96d37b64";

$conn = mysqli_connect( $host, $username, $password, $dbname );

if ( !$conn ) {

    die( "Connect was not successful: " . mysqli_connect_error() );
}
