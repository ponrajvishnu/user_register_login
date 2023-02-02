<?php

function db_connect(){
  //Global db settings

  $dbhost = 'localhost';
  $dbuser = 'root';
  $dbpass = 'root';
  $db     = 'project';

  $con = mysqli_connect($dbhost, $dbuser, $dbpass);
  if (!$con){
          die('Could not connect: ' . mysqli_error($con));
  }

  mysqli_select_db($con, $db);

  return $con;
}

?>