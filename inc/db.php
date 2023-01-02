<?php
$con = mysqli_connect("localhost","root","rootroot","flag");
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
// Check connection
if (mysqli_connect_errno())
  {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
  }
  $db = new PDO( 'mysql:host=localhost;dbname=flag;charset=utf8', 'root', 'rootroot');
  $db->exec('SET NAMES utf8');
  $db->exec('SET CHARACTER SET utf8');
