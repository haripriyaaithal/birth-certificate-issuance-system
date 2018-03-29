<?php

$connection = new mysqli("localhost", "root","","bcis");

// Check database connection
if($connection->connect_error) {
  die("Database connection failed -> ".$connection->connect_error);
}

