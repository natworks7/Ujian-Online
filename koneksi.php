<?php
$server="localhost";
$user = "root";
$password= "";
$database ="ujianonline";

$konek= mysqli_connect($server,$user,$password,$database);

if(!$konek){
echo "koneksi<p>";
print "gagal";
}

date_default_timezone_set("Asia/jakarta");
?>
