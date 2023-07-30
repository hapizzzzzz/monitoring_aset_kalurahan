<?php

include('../../koneksi.php');

if(isset($_POST['bSimpan'])){

$kode_pengadaan_tp = $_POST['kode_pengadaan_tp'];
$nama_barang_tp = $_POST['nama_barang_tp'];
$jenis_barang_tp = $_POST['jenis_barang_tp'];
$volume_tp = $_POST['volume_tp'];
$satuan_tp = $_POST['satuan_tp'];
$tanggal_tp = $_POST['tanggal_tp'];
$nominal_perolehan_lain_tp = $_POST['nominal_perolehan_lain'];
$nominal_kekayaan_desa_tp = $_POST['nominal_kekayaan_desa'];
$lokasi_tp = $_POST['lokasi_tp'];
$keterangan_tp = $_POST['keterangan_tp'];
$pengurus_tp = $_POST['pengurus_tp'];

$cek_ada = $con->query("SELECT COUNT(kode_detail_pengadaan_tp) AS cek_ada FROM detail_pengadaan_tp WHERE kode_pengadaan_tp = '$kode_pengadaan_tp'");
$data_cek_ada = $cek_ada->fetch_array();

$kp_tp = substr($kode_pengadaan_tp, 4);

if ($data_cek_ada['cek_ada'] < 1){
    $kode_detail_pengadaan_tp = 'DT'.$kp_tp.'00001';

    $pj = $con->query("SELECT*FROM pengurus WHERE nomor_pengurus = '$pengurus_tp'");
    $data_pj = $pj->fetch_assoc();

    $nomor_pj = $data_pj['nomor_pengurus'];
    $nama_pj = $data_pj['nama_pengurus'];
    $nomor_hp_pj = $data_pj['no_hp'];

    $simpan = $con->query("INSERT INTO detail_pengadaan_tp (
        kode_detail_pengadaan_tp,
        kode_pengadaan_tp,
        nama_barang_tp,
        nominal_perolehan_lain,
        nominal_kekayaan_desa,
        kode_jenis,
        volume_tp,
        satuan_tp,
        tanggal_perolehan_tp,
        lokasi_tp,
        keterangan_tp,
        nomor_pengurus_tp,
        nama_pengurus_tp,
        no_hp_pengurus_tp) VALUES (
            '$kode_detail_pengadaan_tp',
            '$kode_pengadaan_tp',
            '$nama_barang_tp',
            '$nominal_perolehan_lain_tp',
            '$nominal_kekayaan_desa_tp',
            '$jenis_barang_tp',
            '$volume_tp',
            '$satuan_tp',
            '$tanggal_tp',
            '$lokasi_tp',
            '$keterangan_tp',
            '$nomor_pj',
            '$nama_pj',
            '$nomor_hp_pj')");

    echo "<script>
                document.location='../../menu.php?page=detail_pengadaantp&kode_pengadaan_tp=$kode_pengadaan_tp';
          </script>";
 } else {

    $data_kode = array();

    $ksebelumnya = $con->query("SELECT kode_detail_pengadaan_tp, SUBSTR(kode_detail_pengadaan_tp,9) AS ksebelumnya FROM detail_pengadaan_tp WHERE kode_pengadaan_tp = '$kode_pengadaan_tp'");
    while($dkode=mysqli_fetch_assoc($ksebelumnya)){
        $data_kode[] = $dkode['ksebelumnya'];
    }

    $kodeyintegerIDs = array_map('intval', $data_kode);

    $kode_terakhir = max($kodeyintegerIDs) + 1;

    $kode_urutan_baru = sprintf('%05d', $kode_terakhir);

    $kode_detail_pengadaan_tp = "DT".$kp_tp.$kode_urutan_baru;

    $pj = $con->query("SELECT*FROM pengurus WHERE nomor_pengurus = '$pengurus_tp'");
    $data_pj = $pj->fetch_assoc();

    $nomor_pj = $data_pj['nomor_pengurus'];
    $nama_pj = $data_pj['nama_pengurus'];
    $nomor_hp_pj = $data_pj['no_hp'];

    $simpan = $con->query("INSERT INTO detail_pengadaan_tp (
        kode_detail_pengadaan_tp,
        kode_pengadaan_tp,
        nama_barang_tp,
        nominal_perolehan_lain,
        nominal_kekayaan_desa,
        kode_jenis,
        volume_tp,
        satuan_tp,
        tanggal_perolehan_tp,
        lokasi_tp,
        keterangan_tp,
        nomor_pengurus_tp,
        nama_pengurus_tp,
        no_hp_pengurus_tp) VALUES (
            '$kode_detail_pengadaan_tp',
            '$kode_pengadaan_tp',
            '$nama_barang_tp',
            '$nominal_perolehan_lain_tp',
            '$nominal_kekayaan_desa_tp',
            '$jenis_barang_tp',
            '$volume_tp',
            '$satuan_tp',
            '$tanggal_tp',
            '$lokasi_tp',
            '$keterangan_tp',
            '$nomor_pj',
            '$nama_pj',
            '$nomor_hp_pj')");

        echo "<script>
                document.location='../../menu.php?page=detail_pengadaantp&kode_pengadaan_tp=$kode_pengadaan_tp';
            </script>";
 }
}

if(isset($_POST['bHapus'])){

    $kode_pengadaan_tp = $_POST['kode_pengadaan_tp'];
    $kode_detail_pengadaan_tp = $_POST['kode_detail_pengadaan_tp'];

    $hapus = $con->query("DELETE FROM detail_pengadaan_tp WHERE kode_detail_pengadaan_tp = '$kode_detail_pengadaan_tp'");  

    echo "<script>
            document.location='../../menu.php?page=detail_pengadaantp&kode_pengadaan_tp=$kode_pengadaan_tp';
          </script>";
    
    if (!$hapus){
          echo "<script>
                  alert('Gagal Hapus Data');
                  document.location='../../menu.php?page=detail_pengadaantp&kode_pengadaan_tp=$kode_pengadaan_tp';
                </script>";
    }
}


if(isset($_POST['bUbah'])){

    $ekode_pengadaan_tp = $_POST['ekode_pengadaan_tp'];
    $ekode_detail_pengadaan_tp = $_POST['ekode_detail_pengadaan_tp'];
    $enama_barang_tp = $_POST['enama_barang_tp'];
    $ejenis_barang_tp = $_POST['ejenis_barang_tp'];
    $enominal_perolehan_lain_tp = $_POST['enominal_perolehan_lain_tp'];
    $enominal_kekayaan_desa_tp = $_POST['enominal_kekayaan_desa_tp'];
    $evolume_tp = $_POST['evolume_tp'];
    $esatuan_tp = $_POST['esatuan_tp'];
    $etanggal_tp = $_POST['etanggal_tp'];
    $elokasi_tp= $_POST['elokasi_tp'];
    $eketerangan_tp= $_POST['eketerangan_tp'];
    $epenanggung_jawab_tp =$_POST['epenanggung_jawab_tp'];

    $pengurus = $con->query("SELECT * FROM pengurus WHERE nomor_pengurus = '$epenanggung_jawab_tp'");
    $data_pengurus = $pengurus->fetch_array();

    $no_pengurus = $data_pengurus['nomor_pengurus'];
    $nama_pengurus = $data_pengurus['nama_pengurus'];
    $hp_pengurus = $data_pengurus['no_hp'];

    $ubah = $con->query("UPDATE detail_pengadaan_tp SET
        nama_barang_tp = '$enama_barang_tp',
        kode_jenis = '$ejenis_barang_tp',
        volume_tp = '$evolume_tp',
        satuan_tp = '$esatuan_tp',
        nominal_perolehan_lain = '$enominal_perolehan_lain_tp',
        nominal_kekayaan_desa = '$enominal_kekayaan_desa_tp',
        tanggal_perolehan_tp = '$etanggal_tp',
        lokasi_tp = '$elokasi_tp',
        keterangan_tp = '$eketerangan_tp',
        nomor_pengurus_tp = '$no_pengurus',
        nama_pengurus_tp = '$nama_pengurus',
        no_hp_pengurus_tp = '$hp_pengurus'
    WHERE kode_detail_pengadaan_tp = '$ekode_detail_pengadaan_tp'");

    if($ubah){
        echo "<script>
                    document.location='../../menu.php?page=detail_pengadaantp&kode_pengadaan_tp=$ekode_pengadaan_tp';
              </script>";
    } else {
        echo "<script>
                    alert('Gagal Ubah Data');
                    document.location='../../menu.php?page=detail_pengadaantp&kode_pengadaan_tp=$ekode_pengadaan_tp';
              </script>";
    }
}

?>