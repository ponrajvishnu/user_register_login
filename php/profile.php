<?php
require '../vendor/autoload.php';
include("db_connection.php");
$con = db_connect();

$id = $_GET['id'];  // Get Userid from url

$userQuery = "SELECT * FROM user_registration WHERE id = $id";
$result = mysqli_query($con,$userQuery);
$userData = mysqli_fetch_array($result);

$client = new MongoDB\Client;

$projectdb = $client->projectdb;

$collectionNames = [];
foreach($projectdb->listCollections() as $collection){
    $collectionNames[] = $collection->getName();
}

$exists = in_array('users', $collectionNames);

if($exists){
    $usercollection = $projectdb->users;
}else{
    $usercollection = $projectdb->createCollection('users');
}

if($usercollection){
    $email = $userData['email'];
    $users = $usercollection->findOne(['email' => $email]);
}

include('../profile.html');
?>