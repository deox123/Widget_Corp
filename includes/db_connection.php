<?php
  // 1. Create a database connection
  define("DB_SERVER", "localhost");
  define("DB_USER", "nikola");
  define("DB_PASS", "sifra");
  define("DB_NAME", "widget_corp");
  $connection = mysqli_connect(DB_SERVER, DB_USER, DB_PASS,DB_NAME);
  // Test if connection occured
  if(mysqli_connect_errno()) {
    die("Datebase connection failed: " .
          mysqli_connect_error() .
          " (" . mysqli_connect_errno() . ")"
    );
  }
?>
