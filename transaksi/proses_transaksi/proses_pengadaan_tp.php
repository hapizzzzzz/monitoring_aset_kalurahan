<?php

include('../../koneksi.php');

if(isset($_POST['bSimpan'])){

?>

<?php

    $dptpnamasumber = $_POST['dptpnamasumber'];
    $dptptahun = $_POST['dptptahun'];
    
    $result=$con->query("SELECT COUNT(kode_pengadaan_tp) AS jmltpkode FROM pengadaan_tp");
    $data=mysqli_fetch_assoc($result);


if($data['jmltpkode'] < 1){

    $urutan = sprintf("%04s", 1);

    $kodepdtp = "PT".$dptptahun.$urutan;

    $simpan = $con->query("INSERT INTO pengadaan_tp (
        kode_pengadaan_tp,
        sumber_perolehan_tp,
        tahun_pengadaan_tp) VALUES (
            '$kodepdtp',
            '$dptpnamasumber',
            '$dptptahun')");
            
    echo "<script>document.location='../../menu.php?page=pengadaan_tp';</script>";

} else {
    $kode_ada=$con->query("SELECT COUNT(kode_pengadaan_tp) AS jmltpkodeada FROM pengadaan_tp WHERE sumber_perolehan_tp = '$dptpnamasumber' AND tahun_pengadaan_tp = '$dptptahun'");
    $data_ada=mysqli_fetch_assoc($kode_ada);

    if($data_ada['jmltpkodeada'] < 1){

    $kode_ada_tahun=$con->query("SELECT COUNT(kode_pengadaan_tp) AS kodeadatahun FROM pengadaan_tp WHERE tahun_pengadaan_tp = '$dptptahun'");
    $data_ada_tahun=mysqli_fetch_assoc($kode_ada_tahun);

    if($data_ada_tahun['kodeadatahun'] < 1){

        $urutan_tahun_baru = sprintf("%04s", 1);

        $kodepdtp_taru = "PT".$dptptahun.$urutan_tahun_baru;

        $tambah_taru = $con->query("INSERT INTO pengadaan_tp (
            kode_pengadaan_tp,
            sumber_perolehan_tp,
            tahun_pengadaan_tp) VALUES (
                '$kodepdtp_taru',
                '$dptpnamasumber',
                '$dptptahun')");
            
        echo "<script>document.location='../../menu.php?page=pengadaan_tp';</script>";
    
    } else {
        
        $jml_kode_ada=$con->query("SELECT kode_pengadaan_tp, SUBSTR(kode_pengadaan_tp,6) FROM pengadaan_tp WHERE tahun_pengadaan_tp='$dptptahun'");
        $kodey = array();
        
        while ($jmlkodex=mysqli_fetch_assoc($jml_kode_ada)) {
            $kodey[] = $jmlkodex['SUBSTR(kode_pengadaan_tp,6)'];
        }

        $kodeyintegerIDs = array_map('intval', $kodey);


        $kode_terakhir = max($kodeyintegerIDs);

        $kode_urutan = $kode_terakhir + 1;

        $kode_urutan_baru = sprintf('%04d', $kode_urutan);

        $kode_baru = "PT".$dptptahun.$kode_urutan_baru;

        
        $tambah_data = $con->query("INSERT INTO pengadaan_tp (
        kode_pengadaan_tp,
        sumber_perolehan_tp,
        tahun_pengadaan_tp) VALUES (
            '$kode_baru',
            '$dptpnamasumber',
            '$dptptahun')");

        echo "<script>document.location='../../menu.php?page=pengadaan_tp';</script>";

    }

    } else {
        echo "<script>
                  alert('Pengadaan dengan asal sumber $dptpnamasumber pada tahun $dptptahun telah ada');
                  document.location='../../menu.php?page=pengadaan_tp';
              </script>";
    }
 }
}

if(isset($_POST['bHapus'])){

    $hapus = $con->query("DELETE FROM pengadaan_tp WHERE kode_pengadaan_tp = '$_POST[tpkode]'");

    if($hapus){
        echo "<script>
                document.location='../../menu.php?page=pengadaan_tp';
               </script>";
    } else {
          echo "<script>
                  alert('Gagal Hapus Data');
                  document.location='../../menu.php?page=pengadaan_tp';
                </script>";
    }
} 
// }

if(isset($_POST['bUbah'])){

    $sumber_perolehan_tp = $_POST['edptpsumber'];
    $tahun_perolehan_tp = $_POST['etahuntp'];
    $kode_pengadaan_tp = $_POST['edptpkode'];

    $cek=$con->query("SELECT COUNT(kode_pengadaan_tp) AS cektp FROM pengadaan_tp WHERE sumber_perolehan_tp = '$sumber_perolehan_tp' AND tahun_pengadaan_tp = '$tahun_perolehan_tp'");
    $cek_datatp = mysqli_fetch_assoc($cek);

    if($cek_datatp['cektp'] < 1) {

    $ubah = $con->query("UPDATE pengadaan_tp SET
        sumber_perolehan_tp = '$sumber_perolehan_tp'
    WHERE kode_pengadaan_tp = '$kode_pengadaan_tp'");

    if($ubah){
        echo "<script>
                    document.location='../../menu.php?page=pengadaan_tp';
              </script>";
    } else {
        echo "<script>
                    alert('Gagal Ubah Data');
                    document.location='../../menu.php?page=pengadaan_tp';
              </script>";
        }
    } else {
        echo "<script>
                alert('Pengadaan dengan asal sumber $sumber_perolehan_tp pada tahun $tahun_perolehan_tp telah ada');
                document.location='../../menu.php?page=pengadaan_tp';
              </script>";
    }
}

?>