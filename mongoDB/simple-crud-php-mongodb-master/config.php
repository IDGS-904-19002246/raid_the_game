<?php
/**
 * Connection to MongoDB
 * 
 * $connection = new MongoClient(); // connects to localhost:27017
 * 
 * For remote host connection
 * 
 * $connection = new MongoClient( "mongodb://example.com" ); // connect to a remote host (default port: 27017)
 * $connection = new MongoClient( "mongodb://example.com:65432" ); // connect to a remote host at a given port
 * 
 * Connection using database username and password
 * 
 * $connectionUrl = sprintf('mongodb://%s:%d/%s', $host, $port, $database);
 * $connection = new Mongo($connectionUrl, array('username' => $username, 'password' => $password));
 */ 

//  composer require mongodb/mongodb
// $client = new MongoDB\Client('mongodb://mongodb-deployment:27017');
// $connection = new MongoClient();
// new MongoClient("mongodb://mydbservername:27017", array("username" => "joe", "password" => "test"));



require '../../vendor/autoload.php'; // include Composer's autoloader

use MongoDB\Client;

$client = new Client("mongodb://localhost:27017");
$db = $client->DB_mydb;



/**
 * Select database named "test"
 */ 

 
// $db = $connection->test;
?>
