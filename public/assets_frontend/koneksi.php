<?php
   $hostname  = "localhost";
   $username  = "root";
   $password  = "";
   $dbname  = "kpi";
   $db = mysql_connect($hostname, $username, $password) or die ('Koneksi Gagal! ');
   mysql_select_db($dbname);
?>