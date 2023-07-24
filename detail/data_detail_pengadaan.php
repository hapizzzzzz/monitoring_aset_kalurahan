<?php
  include('../koneksi.php');
 
  $id = $_POST['kode'];

  $query = mysqli_query($con, "SELECT * FROM detail_perencanaan WHERE kode_detail_perencanaan = '$id'");
  $data = mysqli_fetch_array($query);
  echo json_encode($data);
?>