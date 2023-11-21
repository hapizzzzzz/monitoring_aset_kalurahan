<?php
  include('../koneksi.php');
 
  $id = $_POST['kode'];

  $cari_kode_dp = $con->query("SELECT kode_detail_pengadaan FROM inventaris WHERE kode_inventaris = '$id'");
  $pilih_kode_dp = mysqli_fetch_assoc($cari_kode_dp);

  $kode_dp = $pilih_kode_dp['kode_detail_pengadaan'];

  $cek_pengadaan = $con->query("SELECT COUNT(kode_detail_pengadaan) AS cek_pengadaan FROM detail_pengadaan WHERE kode_detail_pengadaan = '$kode_dp'");
  $cek_pd = mysqli_fetch_assoc($cek_pengadaan);
  
  if ($cek_pd['cek_pengadaan'] < 1){
    $query = mysqli_query($con, "SELECT * FROM detail_pengadaan_tp JOIN jenis_barang ON detail_pengadaan_tp.kode_jenis = jenis_barang.kode_jenis JOIN pengadaan_tp ON pengadaan_tp.kode_pengadaan_tp = detail_pengadaan_tp.kode_pengadaan_tp WHERE kode_detail_pengadaan_tp = '$kode_dp'");
    $data = mysqli_fetch_array($query);
    echo json_encode($data);
    // echo "detail_pengadaan_tp";

   } else {
    $query = mysqli_query($con, "SELECT * FROM detail_pengadaan JOIN detail_perencanaan ON detail_pengadaan.kode_detail_perencanaan = detail_perencanaan.kode_detail_perencanaan JOIN jenis_barang ON detail_perencanaan.kode_jenis = jenis_barang.kode_jenis JOIN perencanaan ON detail_perencanaan.kode_perencanaan = perencanaan.kode_perencanaan WHERE detail_pengadaan.kode_detail_pengadaan = '$kode_dp'");
    $data = mysqli_fetch_array($query);
    echo json_encode($data);
    // echo "detail_pengadaan";
  }

    // $query = mysqli_query($con, "SELECT * FROM detail_pengadaan JOIN detail_perencanaan ON detail_pengadaan.kode_detail_perencanaan = detail_perencanaan.kode_detail_perencanaan JOIN jenis_barang ON detail_perencanaan.kode_jenis = jenis_barang.kode_jenis JOIN perencanaan ON detail_perencanaan.kode_perencanaan = perencanaan.kode_perencanaan WHERE detail_pengadaan.kode_detail_pengadaan = '$kode_dp'");
    // $data = mysqli_fetch_array($query);
    // echo json_encode($data);

?>