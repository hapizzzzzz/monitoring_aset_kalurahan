<?php
  include('../koneksi.php');
 
  $kode = $_POST['kode'];

  $cek_pengadaan = $con->query("SELECT COUNT(kode_detail_pengadaan) AS cek_pengadaan FROM detail_pengadaan WHERE kode_detail_pengadaan = '$kode'");
  $cek_pd = mysqli_fetch_assoc($cek_pengadaan);
  if ($cek_pd['cek_pengadaan'] < 1){
    $query = mysqli_query($con, "SELECT * FROM detail_pengadaan_tp JOIN jenis_barang ON detail_pengadaan_tp.kode_jenis = jenis_barang.kode_jenis WHERE kode_detail_pengadaan_tp = '$kode'");
    $data = mysqli_fetch_array($query);
    echo json_encode($data);
    // echo "detail_pengadaan_tp";

   } else {
    $query = mysqli_query($con, "SELECT * FROM detail_pengadaan JOIN detail_perencanaan ON detail_pengadaan.kode_detail_perencanaan = detail_perencanaan.kode_detail_perencanaan JOIN jenis_barang ON detail_perencanaan.kode_jenis = jenis_barang.kode_jenis WHERE detail_pengadaan.kode_detail_pengadaan = '$kode'");
    $data = mysqli_fetch_array($query);
    echo json_encode($data);
    // echo "detail_pengadaan";
  }
?>