<?php
include('../../koneksi.php');


if(isset($_POST['bSimpan'])){

    $no_perdes = $_POST['no_perdes'];
    $tahun_perdes = $_POST['tahun_perdes'];
    $tanggal_terbit_perdes = $_POST['tgl_terbit_perdes'];

    $nama_partner = $_POST['nama_partner'];
    $notelp_partner = $_POST['notelp_partner'];
    $email_partner = $_POST['email_partner'];
    $alamat_partner = $_POST['alamat_partner'];

    $cek_pemanfaatan = $con->query("SELECT COUNT(kode_pemanfaatan) AS jmlkpn FROM pemanfaatan");
    $data_pemanfaatan = mysqli_fetch_assoc($cek_pemanfaatan);

    if($data_pemanfaatan['jmlkpn'] < 1){
        $kode_pemanfaatan = "PN00000001";
        
        $simpan = $con->query("INSERT INTO pemanfaatan (
            kode_pemanfaatan,
            no_perdes,
            tahun_perdes,
            tanggal_terbit_perdes,
            nama_partner,
            no_telp,
            email,
            alamat) VALUES (
                '$kode_pemanfaatan',
                '$no_perdes',
                '$tahun_perdes',
                '$tanggal_terbit_perdes',
                '$nama_partner',
                '$notelp_partner',
                '$email_partner',
                '$alamat_partner')");

    if($simpan){

        echo "<script>
                document.location='../../menu.php?page=pemanfaatan';
            </script>";
    } else {
        echo "<script>
                alert('Gagal Menyimpan Data !');
                document.location='../../menu.php?page=pemanfaatan';
            </script>";
    }

    } else {

        $urutan_kode_pemanfaatan = array();

        $cek_kode_pemanfaatan = $con->query("SELECT SUBSTR(kode_pemanfaatan, 3) AS kpn FROM pemanfaatan");
        while($data_kode_pemanfaatan = mysqli_fetch_assoc($cek_kode_pemanfaatan)){
            $urutan_kode_pemanfaatan[] = $data_kode_pemanfaatan['kpn'];
        }

        $int_urutan_kode_pemanfaatan = array_map('intval', $urutan_kode_pemanfaatan);

        $urutan_baru = max($int_urutan_kode_pemanfaatan) + 1;

        $kode_urutan = sprintf('%08d', $urutan_baru);

        $kode_pemanfaatan_baru = "PN".$kode_urutan;

        $simpan = $con->query("INSERT INTO pemanfaatan (
            kode_pemanfaatan,
            no_perdes,
            tahun_perdes,
            tanggal_terbit_perdes,
            nama_partner,
            no_telp,
            email,
            alamat) VALUES (
            '$kode_pemanfaatan_baru',
            '$no_perdes',
            '$tahun_perdes',
            '$tanggal_terbit_perdes',
            '$nama_partner',
            '$notelp_partner',
            '$email_partner',
            '$alamat_partner')");

        if($simpan){

            echo "<script>
                    document.location='../../menu.php?page=pemanfaatan';
                </script>";
        } else {

            echo "<script>
                    alert('Gagal Simpan Data !');
                    document.location='../../menu.php?page=pemanfaatan';
                </script>";
        }

    }

}

if(isset($_POST['bHapus'])){

    $kode_pemanfaatan = $_POST['kode_pemanfaatan'];
    $hapus = $con->query("DELETE FROM pemanfaatan WHERE kode_pemanfaatan = '$kode_pemanfaatan'");

    if($hapus){

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

if(isset($_POST['bUbah'])){

    $eno_perdes = $_POST['eno_perdes'];
    $etahun_perdes = $_POST['etahun_perdes'];
    $etgl_perdes = $_POST['etgl_perdes'];

    $kode_pemanfaatan = $_POST['ein_kode'];
    $enama_partner = $_POST['enama_partner'];
    $enotelp_partner = $_POST['enotelp_partner'];
    $eemail_partner = $_POST['eemail_partner'];
    $ealamat_partner = $_POST['ealamat_partner'];

    $ubah = $con->query("UPDATE pemanfaatan SET
            no_perdes = '$eno_perdes',
            tahun_perdes = '$etahun_perdes',
            tanggal_terbit_perdes = '$etgl_perdes',
            nama_partner = '$enama_partner',
            no_telp = '$enotelp_partner',
            email = '$eemail_partner',
            alamat = '$ealamat_partner' WHERE kode_pemanfaatan = '$kode_pemanfaatan'");

    if($ubah){
        echo "<script>
                document.location='../../menu.php?page=pemanfaatan';
            </script>";
    } else {
        echo "<script>
                alert('Gagal Ubah Data !');
                document.location='../../menu.php?page=pemanfaatan';
            </script>";
    }
} 


?>