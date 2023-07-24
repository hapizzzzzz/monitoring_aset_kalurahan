<?php

include('../../koneksi.php');

if(isset($_POST['bSimpan'])){

?>

<?php

    $norpjm = $_POST['prno_rpjm'];
    $norkp = $_POST['prno_rkp'];
    $tglrpjm = $_POST['prtgl_rpjm'];
    $tglrkp = $_POST['prtgl_rkp'];
    $periodeawal = $_POST['prperiode_rpjmawal'];
    $periodeakhir = $_POST['prperiode_rpjmakhir'];
    $thnrkp = $_POST['prthn_rkp'];
    
    // $zeroawal = sprintf("%02d", $norpjm);
    // $zeroakhir = sprintf("%02d", $norkp);

    $digit_awalrpjm = substr($periodeawal,-2);
    $digit_akhirrpjm = substr($periodeakhir,-2);
    
    $kode = $digit_awalrpjm.$digit_akhirrpjm.$thnrkp;
    $perioderpjm = $periodeawal." S.d ".$periodeakhir;
    
    $result=$con->query("SELECT COUNT(kode_perencanaan) AS jmlkode FROM perencanaan WHERE tahun_rkp = '$thnrkp'");
    $data=mysqli_fetch_assoc($result);


if($data['jmlkode'] < 1){

    $kodepd = "PD".$kode;

    $simpan = $con->query("INSERT INTO perencanaan (
        kode_perencanaan,
        no_rpjm,
        tanggal_rpjm,
        no_rkp,
        tanggal_rkp,
        periode_rpjm,
        tahun_rkp) VALUES (
            '$kode',
            '$norpjm',
            '$tglrpjm',
            '$norkp',
            '$tglrkp',
            '$perioderpjm',
            '$thnrkp')");

    $simpanpd = $con->query("INSERT INTO pengadaan (
        kode_pengadaan,
        kode_perencanaan) VALUES (
            '$kodepd',
            '$kode')");
            
        echo "<script>document.location='../../menu.php?page=perencanaan';</script>";


    } else {
        echo "<script>
                alert('Perencanaan untuk tahun RKP $thnrkp telah ada');
                document.location='../../menu.php?page=perencanaan';
              </script>";
    }
}

if(isset($_POST['bHapus'])){
    // $hapusdpd = $con->query("DELETE FROM detail_pengadaan WHERE kode_pengadaan = ANY(
    //     SELECT kode_pengadaan FROM pengadaan
    //     WHERE kode_perencanaan='$_POST[pkode]')");
    // $hapuspd = $con->query("DELETE FROM pengadaan WHERE kode_perencanaan = '$_POST[pkode]'");
    // $hapus_detail = $con->query("DELETE FROM detail_perencanaan WHERE kode_perencanaan = '$_POST[pkode]'");
    // if($hapus_detail){
    $hapus = $con->query("DELETE FROM perencanaan WHERE kode_perencanaan = '$_POST[pkode]'");

    if($hapus){
        echo "<script>
                  document.location='../../menu.php?page=perencanaan';
               </script>";
    } else {
          echo "<script>
                  alert('Gagal Hapus Data');
                  document.location='../../menu.php?page=perencanaan';
                </script>";
    }
} 
// }

if(isset($_POST['bUbah'])){
    // $periode_rpjm = $_POST['pawalrpjm']." S.d ".$_POST['pakhirrpjm'];
    $ubah = $con->query("UPDATE perencanaan SET
        no_rpjm = '$_POST[pnorpjm]',
        tanggal_rpjm = '$_POST[ptglrpjm]',
        no_rkp = '$_POST[pnorkp]',
        tanggal_rkp = '$_POST[ptglrkp]'
    WHERE kode_perencanaan = '$_POST[pkode]'");

    if($ubah){
        echo "<script>
                    document.location='../../menu.php?page=perencanaan';
              </script>";
    } else {
        echo "<script>
                    alert('Gagal Ubah Data');
                    document.location='../../menu.php?page=perencanaan';
              </script>";
    }
}

?>