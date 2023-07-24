<?php
include('../../koneksi.php');


if(isset($_POST['bSimpan'])){

$nomor_perdes = $_POST['nomor_perdes'];
$tahun_perdes = $_POST['tahun_perdes'];
$nama_partner = $_POST['nama_partner'];
$tanggal_perdes = $_POST['tanggal_perdes'];
$bentuk_pemanfaatan = $_POST['bentuk_pemanfaatan'];
$nomor_surat_perjanjian = $_POST['no_surat_perjanjian'];
$awal_periode = $_POST['awal_periode_pemanfaatan'];
$akhir_periode = $_POST['akhir_periode_pemanfaatan'];
// $surat_perjanjian = $_POST['file'];

$nama_surat_perjanjian = $_FILES['file']['name'];
$lokasi_surat_perjanjian = $_FILES['file']['tmp_name'];

$format_file = substr($nama_surat_perjanjian, -4);

// echo $nama_surat_perjanjian;

if ($format_file != ".pdf"){
    echo "<script>
            alert('Format File Harus PDF !');
            document.location='../../menu.php?page=pemanfaatan';
        </script>";
} else {

    $cek_pemanfaatan = $con->query("SELECT COUNT(kode_pemanfaatan) AS jumkp FROM pemanfaatan");
    $data_pemanfaatan = mysqli_fetch_assoc($cek_pemanfaatan);
    if($data_pemanfaatan['jumkp'] < 1){

        $kode_pemanfaatan = "PN00000001";

        $namabaru_surat_perjanjian = "Surat perjanjian_".$kode_pemanfaatan.".pdf";

        move_uploaded_file($lokasi_surat_perjanjian, "../../file_pemanfaatan/".$namabaru_surat_perjanjian);

        $simpan = $con->query("INSERT INTO pemanfaatan (
                                kode_pemanfaatan,
                                nomor_perdes,
                                nama_partner,
                                tahun_perdes,
                                tanggal_perdes,
                                bentuk_pemanfaatan,
                                no_surat_perjanjian,
                                awal_jangka_waktu,
                                akhir_jangka_waktu,
                                file_pemanfaatan) VALUES (
                                    '$kode_pemanfaatan',
                                    '$nomor_perdes',
                                    '$nama_partner',
                                    '$tahun_perdes',
                                    '$tanggal_perdes',
                                    '$bentuk_pemanfaatan',
                                    '$nomor_surat_perjanjian',
                                    '$awal_periode',
                                    '$akhir_periode',
                                    '$namabaru_surat_perjanjian')");

        if($simpan){
            echo "<script>
                    document.location='../../menu.php?page=pemanfaatan';
                </script>";
        } else {
            echo "<script>
                    alert('Gagal Menambahkan Data !');
                    document.location='../../menu.php?page=pemanfaatan';
                </script>";
        }


    } else {

        $daftar_kode = array();

        $cek_urutan_kode = $con->query("SELECT SUBSTR(kode_pemanfaatan, 3) AS strkp FROM pemanfaatan");
        while($urutan_kode = mysqli_fetch_assoc($cek_urutan_kode)){
            $daftar_kode[] = $urutan_kode['strkp'];
        }

        $int_daftar_kode = array_map('intval', $daftar_kode);

        // var_dump($daftar_kode);

        $urutan_terakhir = max($int_daftar_kode);

        // echo $urutan_terakhir;
        
        $urutan_baru = $urutan_terakhir + 1;

        $kode_urutan_baru = sprintf('%08d', $urutan_baru);

        $kode_pemanfaatan_baru = "PN".$kode_urutan_baru;

        // echo $kode_pemanfaatan_baru;

        $namabaru_surat_perjanjian = "Surat perjanjian_".$kode_pemanfaatan_baru.".pdf";

        move_uploaded_file($lokasi_surat_perjanjian, "../../file_pemanfaatan/".$namabaru_surat_perjanjian);

        $simpan = $con->query("INSERT INTO pemanfaatan (
            kode_pemanfaatan,
            nomor_perdes,
            nama_partner,
            tahun_perdes,
            tanggal_perdes,
            bentuk_pemanfaatan,
            no_surat_perjanjian,
            awal_jangka_waktu,
            akhir_jangka_waktu,
            file_pemanfaatan) VALUES (
                '$kode_pemanfaatan_baru',
                '$nomor_perdes',
                '$nama_partner',
                '$tahun_perdes',
                '$tanggal_perdes',
                '$bentuk_pemanfaatan',
                '$nomor_surat_perjanjian',
                '$awal_periode',
                '$akhir_periode',
                '$namabaru_surat_perjanjian')");

        if($simpan){
            echo "<script>
                document.location='../../menu.php?page=pemanfaatan';
            </script>";
        } else {
            echo "<script>
                alert('Gagal Menambahkan Data !');
                document.location='../../menu.php?page=pemanfaatan';
            </script>";
        }

    }

  }

}

if(isset($_POST['bHapus'])){

    $kode_pemanfaatan = $_POST['kode_pemanfaatan'];

    $nama_file = $con->query("SELECT file_pemanfaatan FROM pemanfaatan WHERE kode_pemanfaatan = '$kode_pemanfaatan'");

    $data_nama_file = mysqli_fetch_assoc($nama_file);

    $hapus_nama_file = $data_nama_file['file_pemanfaatan'];

    $lokasi_file = '../../file_pemanfaatan/'.$hapus_nama_file;

    $status=unlink($lokasi_file);    

    if($status){

        $hapus = $con->query("DELETE FROM pemanfaatan WHERE kode_pemanfaatan = '$kode_pemanfaatan'");

        echo "<script>
                document.location='../../menu.php?page=pemanfaatan';
            </script>";
    } else {
        echo "<script>
                alert('Gagal Menghapus Data !');
                document.location='../../menu.php?page=pemanfaatan';
            </script>";
    }
} 

?>