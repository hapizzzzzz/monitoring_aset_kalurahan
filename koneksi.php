<?php
$servername = "localhost";
$username ="root";
$password ="";
$database = "aset";

$con=mysqli_connect($servername,$username,$password,$database);

if (!$con) {
    echo "<h1>Sambungan Bermasalah</h1>";
}
?>