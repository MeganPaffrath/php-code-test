<?php
  class Database {
    function openConnection() {
      $host = getenv("HOST");
      $username = getenv("USERNAME");
      $password = getenv("PASSWORD");

      $connection = mysqli_connect($host, $username, $password);
      if (!$connection) {
        die("Connection failure: " . mysqli_connect_error());
      } 
      echo "CONNECTED";
    }

    function getData() {

    }
  }
?>