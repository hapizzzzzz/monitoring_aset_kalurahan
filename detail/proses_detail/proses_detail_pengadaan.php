<?php

include('../../koneksi.php');

if(isset($_POST['bSimpan'])){

$kode_pengadaan = $_POST['dpdkode_pengadaan'];
$kode_detail_perencanaan = $_POST['dpdkode_barang'];
$apbdesa = $_POST['dpdapbdesa'];
$perolehan_lain = $_POST['dpdperolehanlain'];
$kekayaan_desa = $_POST['dpdkekayaandesa'];
$tanggal_perolehan = $_POST['dpdtgl_perolehan'];
$penanggung_jawab = $_POST['dpdpengurus'];

$pengurus = $con->query("SELECT * FROM pengurus WHERE nomor_pengurus = $penanggung_jawab");
$data_pengurus = $pengurus->fetch_array();

$kode_detail_pengadaan = substr($kode_detail_perencanaan,2);
$kode_dp = "PDB".$kode_detail_pengadaan;

$no_pengurus = $data_pengurus['nomor_pengurus'];
$nama_pegurus = $data_pengurus['nama_pengurus'];
$hp_pengurus = $data_pengurus['no_hp'];

if ($kode_pengadaan=="" || $kode_detail_perencanaan=="" || $apbdesa=="" || $perolehan_lain=="" || $kekayaan_desa=="" ||
$tanggal_perolehan=="" || $penanggung_jawab==""){
    echo "<script>
          alert('Data Belum  Lengkap, Harap Cek Kembali. Pastikan Semua Kolom Telah Terisi !');
          document.location='../../menu.php?page=tambah_detail_pengadaan&kode_pengadaan=$kode_pengadaan';
          </script>";
}else{

    $result=$con->query("SELECT COUNT(kode_detail_perencanaan) AS jmkode_dp FROM detail_pengadaan WHERE kode_detail_perencanaan = '$kode_detail_perencanaan'");
    $datakpr=mysqli_fetch_assoc($result);

    $nama_barang=$con->query("SELECT aset_perencanaan FROM detail_perencanaan WHERE kode_detail_perencanaan = '$kode_detail_perencanaan'");
    $anbarang=$nama_barang->fetch_array();

    $jumlah_dan_keterangan=$con->query("SELECT perkiraan_volume, rencana_satuan_volume, keterangan FROM detail_perencanaan WHERE kode_detail_perencanaan = '$kode_detail_perencanaan'");
    $jum_ket=$jumlah_dan_keterangan->fetch_array();

    $jumlah_barang_invetaris = $jum_ket['perkiraan_volume'];
    $satuan_barang_inventaris = $jum_ket['rencana_satuan_volume'];
    $keterangan_barang_inventaris = $jum_ket['keterangan'];
    $kode_inventaris = "INV".$kode_detail_pengadaan;

    if($datakpr['jmkode_dp'] >= 1){

    echo "<script>
            alert('Data $kode_detail_perencanaan - $anbarang telah diadakan !');
            document.location='../../menu.php?page=detail_pengadaan&kode_pengadaan=$kode_pengadaan';
        </script>";
    
    } else {

    $simpan = $con->query("INSERT INTO detail_pengadaan (
        kode_pengadaan,
        kode_detail_perencanaan,
        kode_detail_pengadaan,
        apbdesa,
        perolehan_lain,
        kekayaan_asli_desa,
        tgl_perolehan,
        nomor_pengurus,
        nama_pengurus,
        no_hp_pengurus) VALUES (
            '$kode_pengadaan',
            '$kode_detail_perencanaan',
            '$kode_dp',
            '$apbdesa',
            '$perolehan_lain',
            '$kekayaan_desa',
            '$tanggal_perolehan',
            '$no_pengurus',
            '$nama_pegurus',
            '$hp_pengurus')");

    if ($simpan) {

    echo "<script>document.location='../../menu.php?page=detail_pengadaan&kode_pengadaan=$kode_pengadaan';</script>";
    }

    if (!$simpan) {
        echo "<script>
                    alert('Maaf Terjadi Masalah, Data tidak dapat disimpan');
                    document.location='../../menu.php?page=tambah_detail_pengadaan&kode_pengadaan=$kode_pengadaan';
              </script>";
    }
}
}
}

if(isset($_POST['bHapus'])){

    function hapus_detail_pengadaan(){

        include('../../koneksi.php');

        $hkode_detail_pengadaan = $_POST['dpdkode_detail_pengadaan'];
        $kode_pengadaan = $_POST['dpdkode_pengadaan'];
    
        $hapus_inventaris = $con->query("DELETE FROM inventaris WHERE kode_detail_pengadaan = '$hkode_detail_pengadaan'");
        $hapus = $con->query("DELETE FROM detail_pengadaan WHERE kode_detail_pengadaan = '$hkode_detail_pengadaan'");  
    
        echo "<script>
                document.location='../../menu.php?page=detail_pengadaan&kode_pengadaan=$kode_pengadaan';
              </script>";
        
        if (!$hapus){
              echo "<script>
                      alert('Gagal Hapus Data');
                      document.location='../../menu.php?page=detail_pengadaan&kode_pengadaan=$kode_pengadaan';
                    </script>";
        }

    }

    $cek_file_pemanfaatan=$con->query("SELECT COUNT(detail_pemanfaatan.file_pemanfaatan) AS jumlah_file FROM detail_pengadaan JOIN inventaris ON detail_pengadaan.kode_detail_pengadaan = inventaris.kode_detail_pengadaan
                                        JOIN detail_pemanfaatan ON inventaris.kode_inventaris = detail_pemanfaatan.kode_inventaris
                                        WHERE detail_pengadaan.kode_detail_pengadaan = '$_POST[dpdkode_detail_pengadaan]'");

    $jumlah_file_pemanfaatan = mysqli_fetch_assoc($cek_file_pemanfaatan);

    if ($jumlah_file_pemanfaatan['jumlah_file'] < 1){

        hapus_detail_pengadaan();

    } else {

        $kode_pengadaan = $_POST['dpdkode_pengadaan'];

        $file_pemanfaatan=$con->query("SELECT detail_pemanfaatan.file_pemanfaatan AS jumlah_file FROM detail_pengadaan JOIN inventaris ON detail_pengadaan.kode_detail_pengadaan = inventaris.kode_detail_pengadaan
                                        JOIN detail_pemanfaatan ON inventaris.kode_inventaris = detail_pemanfaatan.kode_inventaris
                                        WHERE detail_pengadaan.kode_detail_pengadaan = '$_POST[dpdkode_detail_pengadaan]'");

        while($surat_perjanjian=mysqli_fetch_assoc($file_pemanfaatan)){

            $lokasi_file = '../../file_pemanfaatan/'.$surat_perjanjian['jumlah_file'];
            $status=unlink($lokasi_file);

        }

        if ($status) {
            
            hapus_detail_pengadaan();

        } else {
            echo "<script>
                      alert('Gagal Hapus Data Detail Pengadaan');
                      document.location='../../menu.php?page=detail_pengadaan&kode_pengadaan=$kode_pengadaan';
                    </script>";        
        }
    }
}


if(isset($_POST['bUbah'])){

    $kode_p = $_POST['dpdkode_pengadaan'];
    $kode_dp = $_POST['dpdkode_detail_pengadaan'];
    $eapbdesa = $_POST['edpdAPBDesa'];
    $eperolehanlain = $_POST['edpdperolehanlain'];
    $ekekayaandesa = $_POST['edpdkekayaandesa'];
    $epengurus = $_POST['edpdpengurus'];
    $etgl = $_POST['edpdtgl'];

    $pengurus = $con->query("SELECT * FROM pengurus WHERE nomor_pengurus = '$epengurus'");
    $data_pengurus = $pengurus->fetch_array();

    $no_pengurus = $data_pengurus['nomor_pengurus'];
    $nama_pengurus = $data_pengurus['nama_pengurus'];
    $hp_pengurus = $data_pengurus['no_hp'];

    $ubah = $con->query("UPDATE detail_pengadaan SET
        apbdesa = '$eapbdesa',
        perolehan_lain = '$eperolehanlain',
        kekayaan_asli_desa = '$ekekayaandesa',
        tgl_perolehan = '$etgl',
        nomor_pengurus = '$no_pengurus',
        nama_pengurus = '$nama_pengurus',
        no_hp_pengurus = '$hp_pengurus'
    WHERE kode_detail_pengadaan = '$kode_dp'");

    if($ubah){
        echo "<script>
                    document.location='../../menu.php?page=detail_pengadaan&kode_pengadaan=$kode_p';
              </script>";
    } else {
        echo "<script>
                    alert('Gagal Ubah Data');
                    document.location='../../menu.php?page=detail_pengadaan&kode_pengadaan=$kode_p';
              </script>";
    }
}

?>