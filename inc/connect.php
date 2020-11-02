<?php

$host = getenv('DB_Host');
$username = getenv('DB_Username');
$password = getenv('DB_Password');
$dbname = getenv('DB_Name');

$conn = mysqli_connect( $host, $username, $password, $dbname );

if ( !$conn ) {

    die( "Connect was not successful: " . mysqli_connect_error() );
}
