<?php
include ('../../koneksi.php');

if(isset($_POST['bSimpan'])){

    $kodeadapr = array();
    $kpori = $_POST['dpkode_perencanaan'];
    $kodeperencanaan = $_POST['dpkode_perencanaan']."1";

    $kodeakhir = $con->query("SELECT SUBSTRING(kode_detail_perencanaan, 3, 4) AS kodeadapr FROM detail_perencanaan WHERE kode_perencanaan = '$kpori'");
    while ($kodesudah=$kodeakhir->fetch_assoc()) {
        $kodeadapr[] = $kodesudah['kodeadapr']."<br>";
    }

    $IDskodeadapr = array_map('intval', $kodeadapr);

    $tahun_rkp = $con->query("SELECT tahun_rkp FROM perencanaan WHERE kode_perencanaan = '$kpori'");
    $data_tahun_rkp = mysqli_fetch_assoc($tahun_rkp);
    $tahun_perencanaan = $data_tahun_rkp['tahun_rkp'];

    if(empty($IDskodeadapr)){

        $kode_detail_perencanaan = "PR".$tahun_perencanaan."000001";
        
        $simpan = $con->query("INSERT INTO detail_perencanaan (
            kode_detail_perencanaan,
            kode_perencanaan,
            aset_perencanaan,
            jenis_kegiatan_rencana,
            kode_jenis,
            rencana_lokasi,
            perkiraan_volume,
            rencana_satuan_volume,
            rencana_sumber_biaya,
            perkiraan_biaya,
            bidang_perencanaan,
            keterangan) VALUES (
                '$kode_detail_perencanaan',
                '$kpori',
                '$_POST[dpnamabarang]',
                '$_POST[dpjeniskegiatan]',
                '$_POST[dpjenisbarang]',
                '$_POST[dplokasi]',
                '$_POST[dpvolume]',
                '$_POST[dpsatuan]',
                '$_POST[dpsumberbiaya]',
                '$_POST[dpperkiraanbiaya]',
                '$_POST[dpbidang]',
                '$_POST[dpketerangan]')");
    } else {

    $cek_kode_detail_perancanaan = $con->query("SELECT SUBSTR(kode_detail_perencanaan, 7) AS kdp FROM detail_perencanaan WHERE kode_perencanaan = '$kpori'");
    
    $data_kdp = [];

    while($data_kode_detail_perencanaan = mysqli_fetch_assoc($cek_kode_detail_perancanaan)){
        $data_kdp[] = $data_kode_detail_perencanaan['kdp'];
    }

    $int_data_kdp = array_map('intval', $data_kdp);

    $urutan_terakhir = max($int_data_kdp);

    $urutan_baru = $urutan_terakhir + 1;

    $urutan_kode = sprintf('%06d', $urutan_baru);

    $kode_baru_dpr = "PR".$tahun_perencanaan.$urutan_kode;
    
    $simpan = $con->query("INSERT INTO detail_perencanaan (
            kode_detail_perencanaan,
            kode_perencanaan,
            aset_perencanaan,
            jenis_kegiatan_rencana,
            kode_jenis,
            rencana_lokasi,
            perkiraan_volume,
            rencana_satuan_volume,
            rencana_sumber_biaya,
            perkiraan_biaya,
            bidang_perencanaan,
            keterangan) VALUES (
                '$kode_baru_dpr',
                '$kpori',
                '$_POST[dpnamabarang]',
                '$_POST[dpjeniskegiatan]',
                '$_POST[dpjenisbarang]',
                '$_POST[dplokasi]',
                '$_POST[dpvolume]',
                '$_POST[dpsatuan]',
                '$_POST[dpsumberbiaya]',
                '$_POST[dpperkiraanbiaya]',
                '$_POST[dpbidang]',
                '$_POST[dpketerangan]')");
    }

if($simpan){
    echo "<script>
            document.location='../../menu.php?page=detail_perencanaan&kode_perencanaan=$kpori';
          </script>";
} else {
    echo "<script>
            alert('Gagal Simpan Data');
            document.location='../../menu.php?page=detail_perencanaan&kode_perencanaan='$kpori';
          </script>";
}
}


if(isset($_POST['bUbah'])){
    $ubah = $con->query("UPDATE detail_perencanaan SET
        aset_perencanaan = '$_POST[dpnamabarang]',
        jenis_kegiatan_rencana = '$_POST[dpjeniskegiatan]',
        kode_jenis = '$_POST[dpjenisbarang]',
        bidang_perencanaan = '$_POST[dpbidang]',
        rencana_lokasi = '$_POST[dplokasi]',
        perkiraan_volume = '$_POST[dpvolume]',
        rencana_satuan_volume = '$_POST[dpsatuan]',
        rencana_sumber_biaya = '$_POST[dpsumberbiaya]',
        perkiraan_biaya = '$_POST[dpperkiraanbiaya]',
        keterangan = '$_POST[dpketerangan]'
    WHERE kode_detail_perencanaan = '$_POST[dpkode]'");

    if($ubah){
        echo "<script>
                document.location='../../menu.php?page=detail_perencanaan&kode_perencanaan=$_GET[kode_perencanaan]';
              </script>";
    } else {
        echo "<script>
                alert('Gagal Ubah Data');
                document.location='../../menu.php?page=detail_perencanaan&kode_perencanaan=$_GET[kode_perencanaan]';
              </script>";
    }
}


if(isset($_POST['bHapus'])){ 

    $hdetail_pengadaan = $con->query("DELETE FROM detail_pengadaan WHERE kode_detail_perencanaan = '$_POST[dpkode]'");
    $hapus = $con->query("DELETE FROM detail_perencanaan WHERE kode_detail_perencanaan = '$_POST[dpkode]'");
    if($hapus){
        echo "<script>
                document.location='../../menu.php?page=detail_perencanaan&kode_perencanaan=$_GET[kode_perencanaan]';
              </script>";
    } else {
        echo "<script>
                alert('Gagal Hapus Data');
              </script>";
    }
}
    
?>