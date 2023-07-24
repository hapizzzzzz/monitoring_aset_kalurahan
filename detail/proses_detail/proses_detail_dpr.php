<?php
include ('../../koneksi.php');

if(isset($_POST['bSimpan'])){

    $kodeadapr = array();
    $kpori = $_POST['dpkode_perencanaan'];
    $kodeperencanaan = $_POST['dpkode_perencanaan']."1";

    $kodeakhir = $con->query("SELECT SUBSTRING(kode_detail_perencanaan, 3) AS kodeadapr FROM detail_perencanaan WHERE kode_perencanaan = '$kpori'");
    while ($kodesudah=$kodeakhir->fetch_assoc()) {
        $kodeadapr[] = $kodesudah['kodeadapr']."<br>";
    }

    $IDskodeadapr = array_map('intval', $kodeadapr);

    // print_r($IDskodeadapr);

    if(empty($IDskodeadapr)){  
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
                'PR$kodeperencanaan',
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
    $kode_akhir_dpr = max($IDskodeadapr);
    $kode_baru_dpr = max($IDskodeadapr) + 1;
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
                'PR$kode_baru_dpr',
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