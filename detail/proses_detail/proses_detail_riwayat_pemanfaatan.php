<?php

include('../../koneksi.php');

if(isset($_POST['bHapus'])){

    $kode_riwayat_pemanfaatan = $_POST['kode_riwayat_pemanfaatan'];
    $file_riwayat = $_POST['file_riwayat'];

    $lokasi_file = '../../riwayat_pemanfaatan/'.$file_riwayat;

    $status=unlink($lokasi_file);

    if($status){

        $hapus = $con->query("DELETE FROM transaksi_pemanfaatan_selesai WHERE kode_riwayat_pemanfaatan = '$kode_riwayat_pemanfaatan'");

        if($hapus){

            echo "<script>
                    document.location='../../menu.php?page=riwayat_pemanfaatan';
                </script>";

        } else {

            echo "<script>
                    alert('Terjadi kesalahan dalam menghapus riwayat pemanfaatan !');
                    document.location='../../menu.php?page=riwayat_pemanfaatan';
                </script>";
        }

    } else {
        echo "<script>
                alert('Terjadi kesalahan dalam menghapus riwayat pemanfaatan !');
                document.location='../../menu.php?page=riwayat_pemanfaatan';
            </script>";
    }

}

?>