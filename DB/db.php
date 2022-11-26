<?php 
$dbhost = 'localhost:3307';
$dbuser = 'root';
$dbpass = '';
$dbname = 'website';
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
$conn = mysqli_connect($dbhost,$dbuser,$dbpass,$dbname);
mysqli_set_charset($conn , "utf8");
if(!$conn) {
    die("<br><p style='color:red;font-size:35px;' >Database not connected !</p>");
}
?>