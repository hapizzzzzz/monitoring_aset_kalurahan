<?php

include('koneksi.php');

$kode = $con->query("SELECT SUBSTR(kode_inventaris, 8, 5) AS kode_in FROM inventaris WHERE SUBSTR(kode_inventaris, 1, 7) = '3050201'");

$array_kode = array();

while($in_kode = mysqli_fetch_assoc($kode)){
    $array_kode[] = $in_kode['kode_in'];
}

// var_dump($array_kode); 

$int_kodeIDs = array_map('intval', $array_kode);

$kode_akhir = max($int_kodeIDs);

echo $kode_akhir."<br>";

$kode_baru = $kode_akhir + 1;

// echo $kode_baru;

$kode_urutan_baru = sprintf('%05d', $kode_baru);

$kode_bar_in = '3050105'.$kode_urutan_baru;

echo $kode_bar_in."<br>";

$kalimat = "Bangun Serah Guna Atau Bangun Guna Serah";

echo strlen($kalimat);

// var_dump($int_kodeIDs);







?>