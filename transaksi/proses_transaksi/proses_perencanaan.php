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

    function hapus_perencanaan(){

        include('../../koneksi.php');

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

    $cek_file_pemanfaatan = $con->query("SELECT COUNT(detail_pemanfaatan.file_pemanfaatan) AS jumlah_file FROM perencanaan JOIN detail_perencanaan ON perencanaan.kode_perencanaan = detail_perencanaan.kode_perencanaan
                                         JOIN detail_pengadaan ON detail_pengadaan.kode_detail_perencanaan = detail_perencanaan.kode_detail_perencanaan
                                         JOIN inventaris ON detail_pengadaan.kode_detail_pengadaan = inventaris.kode_detail_pengadaan JOIN detail_pemanfaatan ON detail_pemanfaatan.kode_inventaris = inventaris.kode_inventaris
                                         WHERE perencanaan.kode_perencanaan = '$_POST[pkode]'");
    
    $jumlah_file = mysqli_fetch_assoc($cek_file_pemanfaatan);

    if($jumlah_file['jumlah_file'] < 1){
        hapus_perencanaan();
    } else {
        
        $file_pemanfaatan = $con->query("SELECT detail_pemanfaatan.file_pemanfaatan FROM perencanaan JOIN detail_perencanaan ON perencanaan.kode_perencanaan = detail_perencanaan.kode_perencanaan
                                         JOIN detail_pengadaan ON detail_pengadaan.kode_detail_perencanaan = detail_perencanaan.kode_detail_perencanaan
                                         JOIN inventaris ON detail_pengadaan.kode_detail_pengadaan = inventaris.kode_detail_pengadaan JOIN detail_pemanfaatan ON detail_pemanfaatan.kode_inventaris = inventaris.kode_inventaris
                                         WHERE perencanaan.kode_perencanaan = '$_POST[pkode]'");

        while ($surat_perjanjian = mysqli_fetch_assoc($file_pemanfaatan)){
            
            $lokasi_file = '../../file_pemanfaatan/'.$surat_perjanjian['file_pemanfaatan'];
            $status=unlink($lokasi_file);

        }

        if($status){
            hapus_perencanaan();
        } else {
            echo "<script>
                    alert('Gagal Hapus Data Perencanaan');
                    document.location='../../menu.php?page=perencanaan';
                </script>";
        }
    }
} 


if(isset($_POST['bUbah'])){

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