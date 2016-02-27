<?php
  function connectToDB() {
    $con = new mysqli("localhost", "root", "", "GradStudents");
    if ($mysqli->connect_errno) {
      echo "Failed to connect to MySQL: " . $mysqli->connect_error;
    }

    return $con;
  }
?>
