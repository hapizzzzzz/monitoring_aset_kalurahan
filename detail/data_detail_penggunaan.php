<?php
  include('../koneksi.php');
 
  $kode = $_POST['kode'];

  $query = mysqli_query($con, "SELECT * FROM inventaris JOIN kuota_aset ON inventaris.kode_inventaris = kuota_aset.kode_inventaris WHERE inventaris.kode_inventaris = '$kode'");
  $data = mysqli_fetch_array($query);
  echo json_encode($data);

?>