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

    $dkpn = substr($kode_pemanfaatan, 2, 6);

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
    
            $cek_kode_pemanfaatan = $con->query("SELECT COUNT(kode_detail_pemanfaatan) AS jumkdp FROM detail_pemanfaatan WHERE kode_pemanfaatan = '$kode_pemanfaatan'");
            $jumkdp = mysqli_fetch_assoc($cek_kode_pemanfaatan);
            
            if($jumkdp['jumkdp'] < 1){
                $kode_detail_pemanfaatan = "DN".$dkpn."0001";

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
                    akhir_pemanfaatan) VALUES (
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
                        '$akhir_periode_pemanfaatan')");
                
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

                $cek_kode_ada = $con->query("SELECT SUBSTR(kode_detail_pemanfaatan, 9) AS kode_detail_pemanfaatan FROM detail_pemanfaatan WHERE kode_pemanfaatan = '$kode_pemanfaatan'");
                
                while($data_kode_ada = mysqli_fetch_assoc($cek_kode_ada)){
                    $kode_dpn[] = $data_kode_ada['kode_detail_pemanfaatan'];
                }

                $int_kode_dpn = array_map('intval', $kode_dpn);

                $kode_terakhir_dpn = max($int_kode_dpn);

                $urutan_baru = $kode_terakhir_dpn + 1;

                $data_urutan_baru = sprintf('%04d', $urutan_baru);

                // echo $dkpn."<br>";

                // echo $kode_terakhir_dpn;

                $kode_dpn_baru = "DN".$dkpn.$data_urutan_baru;

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
                    akhir_pemanfaatan) VALUES (
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
                        '$akhir_periode_pemanfaatan')");
                
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

if (isset($_POST['bUbah'])) {

    $enama_surat_perjanjian = $_FILES['e_file']['name'];
    $elokasi_surat_perjanjian = $_FILES['e_file']['tmp_name'];

    if ($enama_surat_perjanjian == "") {
     
        $kode_pemanfaatan = $_POST['kode_pemanfaatan'];
        $kode_detail_pemanfaatan = $_POST['e_kode_detail_pemanfaatan'];
        $bentuk_pemanfaatan = $_POST['e_bentuk_pemanfaatan'];
        $no_surat_perjanjian = $_POST['e_no_surat_perjanjian'];
        $biaya_kontribusi = $_POST['e_biaya_kontribusi'];
        $keterangan = $_POST['e_keterangan'];
        $awal_periode_pemanfaatan = $_POST['e_awal_periode_pemanfaatan'];
        $akhir_periode_pemanfaatan = $_POST['e_akhir_periode_pemanfaatan'];

        $ubah_dp = $con->query("UPDATE detail_pemanfaatan SET
            bentuk_pemanfaatan = '$bentuk_pemanfaatan',
            no_surat_perjanjian = '$no_surat_perjanjian',
            biaya_kontribusi = '$biaya_kontribusi',
            keterangan_pemanfaatan = '$keterangan',
            awal_pemanfaatan = '$awal_periode_pemanfaatan',
            akhir_pemanfaatan = '$akhir_periode_pemanfaatan'
            WHERE kode_detail_pemanfaatan = '$kode_detail_pemanfaatan'");

        if ($ubah_dp) {
            echo "<script>
                    document.location='../../menu.php?page=detail_pemanfaatan&kode_pemanfaatan=$kode_pemanfaatan';
                </script>";
        } else {
            echo "<script>
                    alert('Terjadi gangguan dalam mengedit detail pemanfaatan !');
                    document.location='../../menu.php?page=detail_pemanfaatan&kode_pemanfaatan=$kode_pemanfaatan';
                </script>";
        }

    } else {

        $kode_pemanfaatan = $_POST['kode_pemanfaatan'];
        $kode_detail_pemanfaatan = $_POST['e_kode_detail_pemanfaatan'];
        $bentuk_pemanfaatan = $_POST['e_bentuk_pemanfaatan'];
        $no_surat_perjanjian = $_POST['e_no_surat_perjanjian'];
        $biaya_kontribusi = $_POST['e_biaya_kontribusi'];
        $keterangan = $_POST['e_keterangan'];
        $awal_periode_pemanfaatan = $_POST['e_awal_periode_pemanfaatan'];
        $akhir_periode_pemanfaatan = $_POST['e_akhir_periode_pemanfaatan'];

        $file_sp = $con->query("SELECT file_pemanfaatan FROM detail_pemanfaatan WHERE kode_detail_pemanfaatan = '$kode_detail_pemanfaatan'");
        $data_file_sp = mysqli_fetch_assoc($file_sp);
        $hdata_file_sp = $data_file_sp['file_pemanfaatan'];

        $lokasi_file = '../../file_pemanfaatan/'.$hdata_file_sp;
        $status=unlink($lokasi_file);

        if($status){

            $namabaru_surat_perjanjian = "Surat perjanjian_".$kode_detail_pemanfaatan.".pdf";

            move_uploaded_file($elokasi_surat_perjanjian, "../../file_pemanfaatan/".$namabaru_surat_perjanjian);

            $ubah_dp = $con->query("UPDATE detail_pemanfaatan SET
            bentuk_pemanfaatan = '$bentuk_pemanfaatan',
            no_surat_perjanjian = '$no_surat_perjanjian',
            biaya_kontribusi = '$biaya_kontribusi',
            keterangan_pemanfaatan = '$keterangan',
            awal_pemanfaatan = '$awal_periode_pemanfaatan',
            akhir_pemanfaatan = '$akhir_periode_pemanfaatan'
            WHERE kode_detail_pemanfaatan = '$kode_detail_pemanfaatan'");

            if ($ubah_dp) {
                echo "<script>
                        document.location='../../menu.php?page=detail_pemanfaatan&kode_pemanfaatan=$kode_pemanfaatan';
                    </script>";
            } else {
                echo "<script>
                        alert('Terjadi gangguan dalam mengedit detail pemanfaatan !');
                        document.location='../../menu.php?page=detail_pemanfaatan&kode_pemanfaatan=$kode_pemanfaatan';
                    </script>";
            }

        }

    }

}


if (isset($_POST['bUbahTP'])) {

    $enama_surat_perjanjian = $_FILES['e_file_tp']['name'];
    $elokasi_surat_perjanjian = $_FILES['e_file_tp']['tmp_name'];

    if ($enama_surat_perjanjian == "") {
     
        $kode_pemanfaatan = $_POST['kode_pemanfaatan'];
        $kode_detail_pemanfaatan = $_POST['e_kode_detail_pemanfaatan_tp'];
        $bentuk_pemanfaatan = $_POST['e_bentuk_pemanfaatan_tp'];
        $no_surat_perjanjian = $_POST['e_no_surat_perjanjian_tp'];
        $biaya_kontribusi = $_POST['e_biaya_kontribusi_tp'];
        $keterangan = $_POST['e_keterangan_tp'];
        $awal_periode_pemanfaatan = $_POST['e_awal_periode_pemanfaatan_tp'];
        $akhir_periode_pemanfaatan = $_POST['e_akhir_periode_pemanfaatan_tp'];

        $ubah_dp = $con->query("UPDATE detail_pemanfaatan SET
            bentuk_pemanfaatan = '$bentuk_pemanfaatan',
            no_surat_perjanjian = '$no_surat_perjanjian',
            biaya_kontribusi = '$biaya_kontribusi',
            keterangan_pemanfaatan = '$keterangan',
            awal_pemanfaatan = '$awal_periode_pemanfaatan',
            akhir_pemanfaatan = '$akhir_periode_pemanfaatan'
            WHERE kode_detail_pemanfaatan = '$kode_detail_pemanfaatan'");

        if ($ubah_dp) {
            echo "<script>
                    document.location='../../menu.php?page=detail_pemanfaatan&kode_pemanfaatan=$kode_pemanfaatan';
                </script>";
        } else {
            echo "<script>
                    alert('Terjadi gangguan dalam mengedit detail pemanfaatan !');
                    document.location='../../menu.php?page=detail_pemanfaatan&kode_pemanfaatan=$kode_pemanfaatan';
                </script>";
        }

    } else {

        $kode_pemanfaatan = $_POST['kode_pemanfaatan'];
        $kode_detail_pemanfaatan = $_POST['e_kode_detail_pemanfaatan_tp'];
        $bentuk_pemanfaatan = $_POST['e_bentuk_pemanfaatan_tp'];
        $no_surat_perjanjian = $_POST['e_no_surat_perjanjian_tp'];
        $biaya_kontribusi = $_POST['e_biaya_kontribusi_tp'];
        $keterangan = $_POST['e_keterangan_tp'];
        $awal_periode_pemanfaatan = $_POST['e_awal_periode_pemanfaatan_tp'];
        $akhir_periode_pemanfaatan = $_POST['e_akhir_periode_pemanfaatan_tp'];

        $file_sp = $con->query("SELECT file_pemanfaatan FROM detail_pemanfaatan WHERE kode_detail_pemanfaatan = '$kode_detail_pemanfaatan'");
        $data_file_sp = mysqli_fetch_assoc($file_sp);
        $hdata_file_sp = $data_file_sp['file_pemanfaatan'];

        $lokasi_file = '../../file_pemanfaatan/'.$hdata_file_sp;
        $status=unlink($lokasi_file);

        if($status){

            $namabaru_surat_perjanjian = "Surat perjanjian_".$kode_detail_pemanfaatan.".pdf";

            move_uploaded_file($elokasi_surat_perjanjian, "../../file_pemanfaatan/".$namabaru_surat_perjanjian);

            $ubah_dp = $con->query("UPDATE detail_pemanfaatan SET
            bentuk_pemanfaatan = '$bentuk_pemanfaatan',
            no_surat_perjanjian = '$no_surat_perjanjian',
            biaya_kontribusi = '$biaya_kontribusi',
            keterangan_pemanfaatan = '$keterangan',
            awal_pemanfaatan = '$awal_periode_pemanfaatan',
            akhir_pemanfaatan = '$akhir_periode_pemanfaatan'
            WHERE kode_detail_pemanfaatan = '$kode_detail_pemanfaatan'");

            if ($ubah_dp) {
                echo "<script>
                        document.location='../../menu.php?page=detail_pemanfaatan&kode_pemanfaatan=$kode_pemanfaatan';
                    </script>";
            } else {
                echo "<script>
                        alert('Terjadi gangguan dalam mengedit detail pemanfaatan !');
                        document.location='../../menu.php?page=detail_pemanfaatan&kode_pemanfaatan=$kode_pemanfaatan';
                    </script>";
            }

        }

    }

}

if (isset($_POST['bStatus'])) {

    function insert_status_pemanfaatan($kr, $urutan_file){

        include('../../koneksi.php');

        $kode_pemanfaatan = $_POST['kode_pemanfaatan'];
        $kode_detail_pemanfaatan = $_POST['kode_dpn'];

        $cek_data_pemanfaatan = $con->query("SELECT * FROM pemanfaatan JOIN detail_pemanfaatan ON pemanfaatan.kode_pemanfaatan = detail_pemanfaatan.kode_pemanfaatan WHERE detail_pemanfaatan.kode_detail_pemanfaatan = '$kode_detail_pemanfaatan'");
        $data_pemanfaatan = mysqli_fetch_assoc($cek_data_pemanfaatan);

        $nama_partner = $data_pemanfaatan['nama_partner'];
        $no_hp = $data_pemanfaatan['no_telp'];
        $email_partner = $data_pemanfaatan['email'];
        $alamat = $data_pemanfaatan['alamat'];
        $no_perdes = $data_pemanfaatan['no_perdes'];
        $tahun_perdes = $data_pemanfaatan['tahun_perdes'];
        $tanggal_perdes = $data_pemanfaatan['tanggal_terbit_perdes'];
        $tahun_pemanfaatan = $data_pemanfaatan['tahun_pemanfaatan'];
    
        $kode_inventaris = $_POST['kode_inv'];
        $nama_aset = $_POST['nama_aset'];
        $jumlah_p = $_POST['jumlah_dpn'];
        $bentuk_pemanfaatan = $_POST['bentuk_pemanfaatan'];
        $biaya_kontribusi = $_POST['biaya_kontribusi'];
        $awal_pemanfaaatan = $_POST['awal_pemanfaatan'];
        $akhir_pemanfaatan = $_POST['akhir_pemanfaatan'];
        $keterangan = $_POST['keterangan'];
        $no_surat_perjanjian = $_POST['no_surat_perjanjian'];
        $satuan = $_POST['satuan_dpn'];
        $file_pemanfaatan = $_POST['nama_file'];

        $kode_jenis = $_POST['kode_jns'];
        $pilihan_jenis_barang = $con->query("SELECT nama_kelompok FROM jenis_barang WHERE kode_jenis = '$kode_jenis'");
        $pilih_jenis_barang = mysqli_fetch_assoc($pilihan_jenis_barang);

        $jenis_barang = $pilih_jenis_barang['nama_kelompok'];

        $file_riwayat = "Surat Perjanjian_R".$tahun_perdes.$urutan_file.".pdf";

            $tambah_riwayat = $con->query("INSERT INTO transaksi_pemanfaatan_selesai (
                kode_riwayat_pemanfaatan,
                nama_partner,
                no_hp,
                email_partner,
                alamat,
                no_perdes,
                tahun_perdes,
                tanggal_perdes,
                tahun_pemanfaatan,
                jenis_barang,
                kode_inventaris,
                nama_aset,
                jumlah_p,
                satuan_p,
                bentuk_pemanfaatan,
                biaya_kontribusi,
                awal_pemanfaatan,
                akhir_pemanfaatan,
                keterangan,
                no_surat_perjanjian,
                file_pemanfaatan) VALUES (
                    '$kr',
                    '$nama_partner',
                    '$no_hp',
                    '$email_partner',
                    '$alamat',
                    '$no_perdes',
                    '$tahun_perdes',
                    '$tanggal_perdes',
                    '$tahun_pemanfaatan',
                    '$jenis_barang',
                    '$kode_inventaris',
                    '$nama_aset',
                    '$jumlah_p',
                    '$satuan',
                    '$bentuk_pemanfaatan',
                    '$biaya_kontribusi',
                    '$awal_pemanfaaatan',
                    '$akhir_pemanfaatan',
                    '$keterangan',
                    '$no_surat_perjanjian',
                    '$file_riwayat'
                )");


            $cek_kuota = $con->query("SELECT jumlah_kuota FROM kuota_aset WHERE kode_inventaris = '$_POST[kode_inv]'");
            $data_kuota = mysqli_fetch_assoc($cek_kuota);

            $kuota_kembali = $data_kuota['jumlah_kuota'] + $jumlah_p;

            $pulihkan_kuota = $con->query("UPDATE kuota_aset SET jumlah_kuota = '$kuota_kembali' WHERE kode_inventaris = '$_POST[kode_inv]'");

            if($pulihkan_kuota){

                $hapus_detail_pemanfaatan = $con->query("DELETE FROM detail_pemanfaatan WHERE kode_detail_pemanfaatan = '$kode_detail_pemanfaatan'");

            }

            echo "<script>
                    document.location='../../menu.php?page=detail_pemanfaatan&kode_pemanfaatan=$kode_pemanfaatan';
                </script>";

    }

    $kode_detail_pemanfaatan = $_POST['kode_dpn'];

    $cek_data_pemanfaatan = $con->query("SELECT * FROM pemanfaatan JOIN detail_pemanfaatan ON pemanfaatan.kode_pemanfaatan = detail_pemanfaatan.kode_pemanfaatan WHERE detail_pemanfaatan.kode_detail_pemanfaatan = '$kode_detail_pemanfaatan'");
    $data_pemanfaatan = mysqli_fetch_assoc($cek_data_pemanfaatan);

    $tahun_perdes = $data_pemanfaatan['tahun_perdes'];

    $cek_riwayat = $con->query("SELECT COUNT(kode_riwayat_pemanfaatan) AS jumlah_riwayat FROM transaksi_pemanfaatan_selesai WHERE tahun_perdes = '$tahun_perdes'");
    $jumlah_riwayat = mysqli_fetch_assoc($cek_riwayat);

    function pindah_file($tahun_perdes, $file_pemanfaatan, $urutan_file){

        $file_riwayat = "Surat Perjanjian_R".$tahun_perdes.$urutan_file;
        $lokasi_file_pemanfaatan = '../../file_pemanfaatan/'.$file_pemanfaatan;
        $lokasi_file_riwayat = '../../riwayat_pemanfaatan/'.$file_riwayat.".pdf";
        $pemanfaatan_to_riwayat = rename($lokasi_file_pemanfaatan,$lokasi_file_riwayat);   

    }
    
    if($jumlah_riwayat['jumlah_riwayat'] < 1){

        $tahun_perdes = $data_pemanfaatan['tahun_perdes'];
        $kode_riwayat_pemanfaatan = "R".$tahun_perdes."00000001";
        
        pindah_file($tahun_perdes, $_POST['nama_file'], "00000001");

        insert_status_pemanfaatan($kode_riwayat_pemanfaatan, "00000001");

    } else {

        $kode_riwayat = [];

        $tahun_perdes = $data_pemanfaatan['tahun_perdes'];
        
        $data_riwayat = $con->query("SELECT SUBSTR(kode_riwayat_pemanfaatan,6) AS kode_riwayat_pemanfaatan FROM transaksi_pemanfaatan_selesai WHERE tahun_perdes = '$tahun_perdes'");

        while($data_kode_riwayat = mysqli_fetch_assoc($data_riwayat)){
            $kode_riwayat[] = $data_kode_riwayat['kode_riwayat_pemanfaatan'];
        }

        $int_data_riwayat = array_map('intval',$kode_riwayat);

        $urutan_baru = max($int_data_riwayat) + 1;

        $urutan_kode_baru = sprintf('%08d', $urutan_baru);        

        $kode_riwayat_pemanfaatan = "R".$tahun_perdes.$urutan_kode_baru;

        pindah_file($tahun_perdes, $_POST['nama_file'], $urutan_kode_baru);
        
        insert_status_pemanfaatan($kode_riwayat_pemanfaatan, $urutan_kode_baru);

    }
}



?>