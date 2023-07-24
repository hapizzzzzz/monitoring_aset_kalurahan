<?php

include('../../koneksi.php');

if(isset($_POST['bSimpan'])){
    
    $kode_pemanfaatan = $_POST['kode_pemanfaatan'];
    $pilihan_aset = $_POST['pilihan_aset'];
    $jumlah_pn = $_POST['jumlah_pn'];
    $bentuk_pemanfaatan = $_POST['bentuk_pemanfaatan'];
    $no_surat_perjanjian = $_POST['no_surat_perjanjian'];
    $biaya_kontribusi = $_POST['biaya'];
    $keterangan = $_POST['keterangan_pn'];
    $awal_periode_pemanfaatan = $_POST['awal_periode_pemanfaatan'];
    $akhir_periode_pemanfaatan = $_POST['akhir_periode_pemanfaatan'];

    $cek_kuota=$con->query("SELECT jumlah_kuota FROM kuota_aset WHERE kode_inventaris = '$pilihan_aset'");
    $jml_kuota = mysqli_fetch_assoc($cek_kuota);

    $nama_surat_perjanjian = $_FILES['file']['name'];
    $lokasi_surat_perjanjian = $_FILES['file']['tmp_name'];

    $format_file = substr($nama_surat_perjanjian, -4);

    if (($format_file == ".pdf") || ($format_file == ".PDF")){

        if ($jml_kuota['jumlah_kuota'] < $jumlah_pn) {
            echo "<script>
                        alert('Jumlah kuota aset yang tersisa lebih sedikit dari inputan jumlah pemanfaatan !');
                        document.location='../../menu.php?page=detail_pemanfaatan&kode_pemanfaatan=$kode_pemanfaatan';
                    </script>";
        } else {
    
            $cek_kode_pemanfaatan = $con->query("SELECT COUNT(kode_detail_pemanfaatan) AS jumkdp FROM detail_pemanfaatan");
            $jumkdp = mysqli_fetch_assoc($cek_kode_pemanfaatan);
            
            if($jumkdp['jumkdp'] < 1){
                $kode_detail_pemanfaatan = "DPN0000001";

                $namabaru_surat_perjanjian = "Surat perjanjian_".$kode_detail_pemanfaatan.".pdf";
        
                $simpan = $con->query("INSERT INTO detail_pemanfaatan (
                    kode_detail_pemanfaatan,
                    kode_pemanfaatan,
                    kode_inventaris,
                    jumlah_aset_p,
                    bentuk_pemanfaatan,
                    no_surat_perjanjian,
                    file_pemanfaatan,
                    biaya_kontribusi,
                    keterangan_pemanfaatan,
                    awal_pemanfaatan,
                    akhir_pemanfaatan,
                    status_pemanfaatan) VALUES (
                        '$kode_detail_pemanfaatan',
                        '$kode_pemanfaatan',
                        '$pilihan_aset',
                        '$jumlah_pn',
                        '$bentuk_pemanfaatan',
                        '$no_surat_perjanjian',
                        '$namabaru_surat_perjanjian',
                        '$biaya_kontribusi',
                        '$keterangan',
                        '$awal_periode_pemanfaatan',
                        '$akhir_periode_pemanfaatan',
                        'Berlangsung')");
                
                if (!$simpan) {
                    echo "<script>
                                alert('Jumlah kuota aset yang tersisa lebih sedikit dari inputan jumlah pemanfaatan !');
                                document.location='../../menu.php?page=detail_pemanfaatan&kode_pemanfaatan=$kode_pemanfaatan';
                            </script>";
                } else {
                    move_uploaded_file($lokasi_surat_perjanjian, "../../file_pemanfaatan/".$namabaru_surat_perjanjian);

                    $kuota_aset = $con->query("SELECT jumlah_kuota FROM kuota_aset WHERE kode_inventaris = '$pilihan_aset'");
                    $sisa_kuota = mysqli_fetch_assoc($kuota_aset);

                    $kuota_baru = $sisa_kuota['jumlah_kuota'] - $jumlah_pn;

                    $ubah_kuota = $con->query("UPDATE kuota_aset SET jumlah_kuota = '$kuota_baru' WHERE kode_inventaris = '$pilihan_aset'");

                    if(!$ubah_kuota){
                        echo "<script>
                                alert('Terjadi kesalahan dalam merubah kuota aset !');
                                document.location='../../menu.php?page=detail_pemanfaatan&kode_pemanfaatan=$kode_pemanfaatan';
                            </script>";
                    } else {
                        echo "<script>document.location='../../menu.php?page=detail_pemanfaatan&kode_pemanfaatan=$kode_pemanfaatan';</script>";
                    }
                }
                
            } else {

                $kode_dpn = array();

                $cek_kode_ada = $con->query("SELECT SUBSTR(kode_detail_pemanfaatan, 4) AS kode_detail_pemanfaatan FROM detail_pemanfaatan WHERE kode_pemanfaatan = '$kode_pemanfaatan'");
                
                while($data_kode_ada = mysqli_fetch_assoc($cek_kode_ada)){
                    $kode_dpn[] = $data_kode_ada['kode_detail_pemanfaatan'];
                }

                $int_kode_dpn = array_map('intval', $kode_dpn);

                $kode_terakhir_dpn = max($int_kode_dpn);

                $urutan_baru = $kode_terakhir_dpn + 1;

                $data_urutan_baru = sprintf('%07d', $urutan_baru);

                $kode_dpn_baru = "DPN".$data_urutan_baru;

                $namabaru_surat_perjanjian = "Surat perjanjian_".$kode_dpn_baru.".pdf";
        
                $simpan = $con->query("INSERT INTO detail_pemanfaatan (
                    kode_detail_pemanfaatan,
                    kode_pemanfaatan,
                    kode_inventaris,
                    jumlah_aset_p,
                    bentuk_pemanfaatan,
                    no_surat_perjanjian,
                    file_pemanfaatan,
                    biaya_kontribusi,
                    keterangan_pemanfaatan,
                    awal_pemanfaatan,
                    akhir_pemanfaatan,
                    status_pemanfaatan) VALUES (
                        '$kode_dpn_baru',
                        '$kode_pemanfaatan',
                        '$pilihan_aset',
                        '$jumlah_pn',
                        '$bentuk_pemanfaatan',
                        '$no_surat_perjanjian',
                        '$namabaru_surat_perjanjian',
                        '$biaya_kontribusi',
                        '$keterangan',
                        '$awal_periode_pemanfaatan',
                        '$akhir_periode_pemanfaatan',
                        'Berlangsung')");
                
                if (!$simpan) {
                    echo "<script>
                                alert('Jumlah kuota aset yang tersisa lebih sedikit dari inputan jumlah pemanfaatan !');
                                document.location='../../menu.php?page=detail_pemanfaatan&kode_pemanfaatan=$kode_pemanfaatan';
                            </script>";
                } else {
                    move_uploaded_file($lokasi_surat_perjanjian, "../../file_pemanfaatan/".$namabaru_surat_perjanjian);
                    
                    $kuota_aset = $con->query("SELECT jumlah_kuota FROM kuota_aset WHERE kode_inventaris = '$pilihan_aset'");
                    $sisa_kuota = mysqli_fetch_assoc($kuota_aset);

                    $kuota_baru = $sisa_kuota['jumlah_kuota'] - $jumlah_pn;

                    $ubah_kuota = $con->query("UPDATE kuota_aset SET jumlah_kuota = '$kuota_baru' WHERE kode_inventaris = '$pilihan_aset'");

                    if(!$ubah_kuota){
                        echo "<script>
                                alert('Terjadi kesalahan dalam merubah kuota aset !');
                                document.location='../../menu.php?page=detail_pemanfaatan&kode_pemanfaatan=$kode_pemanfaatan';
                            </script>";
                    } else {
                        echo "<script>document.location='../../menu.php?page=detail_pemanfaatan&kode_pemanfaatan=$kode_pemanfaatan';</script>";
                    }
                }
            }
    
        }

    } else {
        echo "<script>
                alert('Format file harus .pdf !');
                document.location='../../menu.php?page=detail_pemanfaatan&kode_pemanfaatan=$kode_pemanfaatan';
            </script>";
    }   
}


if(isset($_POST['bHapus'])){

    $kode_pemanfaatan = $_POST['kode_pemanfaatan'];
    $kode_detail_pemanfaatan = $_POST['kode_dpn'];
    $kode_inventaris = $_POST['kode_in_dpn'];
    $jumlah_aset_pemanfaatan = $_POST['jumlah_dpn'];
    $nama_file = $_POST['hapus_file'];

    $cek_kuota = $con->query("SELECT jumlah_kuota FROM kuota_aset WHERE kode_inventaris = '$kode_inventaris'");
    $sisa_kuota = mysqli_fetch_assoc($cek_kuota);

    $kuota_pulih = $sisa_kuota['jumlah_kuota'] + $jumlah_aset_pemanfaatan;

    $pulihkan_kuota = $con->query("UPDATE kuota_aset SET jumlah_kuota = '$kuota_pulih' WHERE kode_inventaris = '$kode_inventaris'");

    $lokasi_file = '../../file_pemanfaatan/'.$nama_file;

    $status=unlink($lokasi_file);

    if($status){

        $hapus = $con->query("DELETE FROM detail_pemanfaatan WHERE kode_detail_pemanfaatan = '$kode_detail_pemanfaatan'");

        if(!$hapus){
            echo "<script>
                    alert('Terjadi kesalahan dalam menghapus detail pemanfaatan !');
                    document.location='../../menu.php?page=detail_pemanfaatan&kode_pemanfaatan=$kode_pemanfaatan';
                </script>";
        } else {
            echo "<script>
                    document.location='../../menu.php?page=detail_pemanfaatan&kode_pemanfaatan=$kode_pemanfaatan';
                </script>";
        }

    } else {
        echo "<script>
                alert('Terjadi kesalahan dalam menghapus detail pemanfaatan !');
                document.location='../../menu.php?page=detail_pemanfaatan&kode_pemanfaatan=$kode_pemanfaatan';
            </script>";
    }

}


if(isset($_POST['bHapusTP'])){

    $kode_pemanfaatan = $_POST['kode_pemanfaatan'];
    $kode_detail_pemanfaatan = $_POST['kode_dpntp'];
    $kode_inventaris = $_POST['kode_in_dpntp'];
    $jumlah_aset_pemanfaatan = $_POST['jumlah_dpntp'];
    $nama_file = $_POST['hapus_filetp'];

    $cek_kuota = $con->query("SELECT jumlah_kuota FROM kuota_aset WHERE kode_inventaris = '$kode_inventaris'");
    $sisa_kuota = mysqli_fetch_assoc($cek_kuota);

    $kuota_pulih = $sisa_kuota['jumlah_kuota'] + $jumlah_aset_pemanfaatan;

    $pulihkan_kuota = $con->query("UPDATE kuota_aset SET jumlah_kuota = '$kuota_pulih' WHERE kode_inventaris = '$kode_inventaris'");

    $lokasi_file = '../../file_pemanfaatan/'.$nama_file;

    $status=unlink($lokasi_file);

    if($status){

        $hapus = $con->query("DELETE FROM detail_pemanfaatan WHERE kode_detail_pemanfaatan = '$kode_detail_pemanfaatan'");

        if(!$hapus){
            echo "<script>
                    alert('Terjadi kesalahan dalam menghapus detail pemanfaatan !');
                    document.location='../../menu.php?page=detail_pemanfaatan&kode_pemanfaatan=$kode_pemanfaatan';
                </script>";
        } else {
            echo "<script>
                    document.location='../../menu.php?page=detail_pemanfaatan&kode_pemanfaatan=$kode_pemanfaatan';
                </script>";
        }

    } else {
        echo "<script>
                alert('Terjadi kesalahan dalam menghapus detail pemanfaatan !');
                document.location='../../menu.php?page=detail_pemanfaatan&kode_pemanfaatan=$kode_pemanfaatan';
            </script>";
    }

}

?>