<?php
include ('../../koneksi.php');

if(isset($_POST['bSimpan'])){

    $kode_penghapusan = $_POST['kode_penghapusan'];
    $kode_inventaris = $_POST['kode_inventaris'];
    $jumlah_hapus_aset = $_POST['jumlah_hapus_aset'];

    $cek_kuota = $con->query("SELECT jumlah_kuota FROM kuota_aset WHERE kode_inventaris = '$kode_inventaris'");
    $cek_sisa_kuota = mysqli_fetch_assoc($cek_kuota);

    if($cek_sisa_kuota['jumlah_kuota'] < $jumlah_hapus_aset){

        echo "<script>
                    alert('Jumlah aset yang akan dihapus melebihi sisa kuota aset ! Pastikan aset yang ingin dihapus tidak sedang digunakan atau dimanfaatkan !');
                    document.location='../../menu.php?page=detail_penghapusan&kode_penghapusan=$kode_penghapusan';
                </script>";
    
    } else {

        global $sisa_kuota_aset;

        $sisa_kuota_aset = $cek_sisa_kuota['jumlah_kuota'] - $jumlah_hapus_aset;

        function ubah_jumlah_inventaris(){

            $jumlah_hapus_aset = $_POST['jumlah_hapus_aset'];

            include("../../koneksi.php");

            $kode_inventaris = $_POST['kode_inventaris'];

            $cek_jumlah = $con->query("SELECT jumlah FROM inventaris WHERE kode_inventaris = '$kode_inventaris'");
            $cek_jumlah_aset = mysqli_fetch_assoc($cek_jumlah);

            $sisa_jumlah_aset = $cek_jumlah_aset['jumlah'] - $jumlah_hapus_aset;

            $ubah_jumlah_aset = $con->query("UPDATE inventaris SET jumlah = '$sisa_jumlah_aset' WHERE kode_inventaris = '$kode_inventaris'");

        }

        function ubah_jumlah(){

            $kode_inventaris = $_POST['kode_inventaris'];
            $jumlah_hapus_aset = $_POST['jumlah_hapus_aset'];

            include("../../koneksi.php");

            global $sisa_kuota_aset;

            if ($sisa_kuota_aset > 0){

                $ubah_kuota_aset = $con->query("UPDATE kuota_aset SET jumlah_kuota = '$sisa_kuota_aset' WHERE kode_inventaris = '$kode_inventaris'");

                if (!$ubah_kuota_aset){

                    echo "<script>
                            alert('Terdapat Kesalahan Sistem');
                            document.location='../../menu.php?page=detail_penghapusan&kode_penghapusan=$kode_penghapusan';
                        </script>";

                } else {

                    ubah_jumlah_inventaris();

                }
            
            } else {

                $cek_aset_penggunaan = $con->query("SELECT SUM(jumlah_pg) AS jumlah_barang FROM detail_penggunaan WHERE kode_inventaris = '$kode_inventaris'");
                $jumlah_aset_penggunaan = mysqli_fetch_assoc($cek_aset_penggunaan);

                $cek_aset_pemanfaatan = $con->query("SELECT SUM(jumlah_aset_p) AS jumlah_barang FROM detail_pemanfaatan WHERE kode_inventaris = '$kode_inventaris'");
                $jumlah_aset_pemanfaatan = mysqli_fetch_assoc($cek_aset_pemanfaatan);

                $jumlah_aset_terpakai = $jumlah_aset_penggunaan['jumlah_barang'] + $jumlah_aset_pemanfaatan['jumlah_barang'];

                if($jumlah_aset_terpakai > 0){

                    $ubah_kuota_aset_trp = $con->query("UPDATE kuota_aset SET jumlah_kuota = 0 WHERE kode_inventaris = '$kode_inventaris'");

                    if (!$ubah_kuota_aset_trp){

                        echo "<script>
                                alert('Terdapat Kesalahan Sistem');
                                document.location='../../menu.php?page=detail_penghapusan&kode_penghapusan=$kode_penghapusan';
                            </script>";

                    } else {

                        ubah_jumlah_inventaris();

                    }

                } else {

                    $hapus_kuota = $con->query("DELETE FROM kuota_aset WHERE kode_inventaris = '$kode_inventaris'");

                    if (!$hapus_kuota){

                        echo "<script>
                                alert('Terdapat Kesalahan Sistem');
                                document.location='../../menu.php?page=detail_penghapusan&kode_penghapusan=$kode_penghapusan';
                            </script>";

                    } else {
                        $hapus_aset = $con->query("DELETE FROM inventaris WHERE kode_inventaris = '$kode_inventaris'");
                    }

                }
            
            }
            
        }


        function simpan_data_penghapusan(String $kdp, String $nb, String $sb, String $tp, String $jb){

            include("../../koneksi.php");

            $apbdesa = $_POST['dpsapbdesa'];
            $perolehan_lain = $_POST['dpsperolehanlain'];
            $kekayaan_asli_desa = $_POST['dpskekayaandesa'];

            $kode_penghapusan = $_POST['kode_penghapusan'];
            $kode_inventaris = $_POST['kode_inventaris'];
            $jumlah_hapus_aset = $_POST['jumlah_hapus_aset'];
            $penyebab_penghapusan = $_POST['penyebab_penghapusan'];
            $keterangan_tindakan = $_POST['keterangan_tindakan'];
            $tanggal_penghapusan = $_POST['tanggal_penghapusan'];
            $penanggung_jawab = $_POST['penanggung_jawab'];

            $cari_data_inventaris = $con->query("SELECT * FROM inventaris WHERE kode_inventaris = '$kode_inventaris'");
            $data_inventaris = mysqli_fetch_assoc($cari_data_inventaris);

            $identitas_barang = $data_inventaris['identitas_barang'];

            $simpan_data = $con->query("INSERT INTO detail_penghapusan (
                kode_detail_penghapusan,
                kode_penghapusan,
                kode_inventaris,
                tahun_perolehan,
                jenis_barang,
                nama_barang,
                jumlah_penghapusan,
                satuan_barang,
                apbdesa,
                perolehan_lain,
                kekayaan_asli_desa,
                identitas_barang,
                penyebab_penghapusan,
                tindakan_penghapusan,
                nama_penanggung_jawab,
                tanggal_penghapusan) VALUES (
                    '$kdp',
                    '$kode_penghapusan',
                    '$kode_inventaris',
                    '$tp',
                    '$jb',
                    '$nb',
                    '$jumlah_hapus_aset',
                    '$sb',
                    '$apbdesa',
                    '$perolehan_lain',
                    '$kekayaan_asli_desa',
                    '$identitas_barang',
                    '$penyebab_penghapusan',
                    '$keterangan_tindakan',
                    '$penanggung_jawab',
                    '$tanggal_penghapusan')");
        
            if (!$simpan_data) {
                
                echo "<script>
                        alert('Maaf Terjadi Masalah, Data tidak dapat disimpan');
                    </script>";

                echo "<script>document.location='../../menu.php?page=detail_penghapusan&kode_penghapusan=$kode_penghapusan';</script>";
            
            } else {

                ubah_jumlah();
                echo "<script>document.location='../../menu.php?page=detail_penghapusan&kode_penghapusan=$kode_penghapusan';</script>";

            }

        }



        $cek_detail_penghapusan = $con->query("SELECT COUNT(kode_detail_penghapusan) AS jmldps FROM detail_penghapusan WHERE kode_penghapusan = '$kode_penghapusan'");
        $data_detail_penghapusan = mysqli_fetch_assoc($cek_detail_penghapusan);

        $dpsb = substr($kode_penghapusan, 2);

        if($data_detail_penghapusan['jmldps'] < 1){
            
            $kode_detail_penghapusan = "DS".$dpsb."001";

            $cari_nama_aset_pr = $con->query("SELECT*FROM inventaris JOIN detail_pengadaan ON detail_pengadaan.kode_detail_pengadaan = inventaris.kode_detail_pengadaan JOIN detail_perencanaan ON detail_perencanaan.kode_detail_perencanaan = detail_pengadaan.kode_detail_perencanaan JOIN jenis_barang ON detail_perencanaan.kode_jenis = jenis_barang.kode_jenis JOIN perencanaan ON detail_perencanaan.kode_perencanaan = perencanaan.kode_perencanaan WHERE inventaris.kode_inventaris = '$kode_inventaris'");
            $nama_aset_pr = mysqli_fetch_assoc($cari_nama_aset_pr);

            $cari_nama_aset_tp = $con->query("SELECT*FROM inventaris JOIN detail_pengadaan_tp ON detail_pengadaan_tp.kode_detail_pengadaan_tp = inventaris.kode_detail_pengadaan JOIN jenis_barang ON detail_pengadaan_tp.kode_jenis = jenis_barang.kode_jenis JOIN pengadaan_tp ON detail_pengadaan_tp.kode_pengadaan_tp = pengadaan_tp.kode_pengadaan_tp WHERE inventaris.kode_inventaris = '$kode_inventaris'");
            $nama_aset_tp = mysqli_fetch_assoc($cari_nama_aset_tp);

            if(empty($nama_aset_pr['aset_perencanaan'])){

                simpan_data_penghapusan($kode_detail_penghapusan, $nama_aset_tp['nama_barang_tp'], $nama_aset_tp['satuan_tp'], $nama_aset_tp['tahun_pengadaan_tp'], $nama_aset_tp['nama_kelompok']);

            } else {

                simpan_data_penghapusan($kode_detail_penghapusan, $nama_aset_pr['aset_perencanaan'], $nama_aset_pr['rencana_satuan_volume'],$nama_aset_pr['tahun_rkp'], $nama_aset_pr['nama_kelompok']);
            }


        } else {

            $kode_dps = array();

            $cek_kode_dps = $con->query("SELECT SUBSTR(kode_detail_penghapusan, 11) AS kode_detail_penghapusan FROM detail_penghapusan WHERE kode_penghapusan = '$kode_penghapusan'");
                
            while($data_kode_dps = mysqli_fetch_assoc($cek_kode_dps)){
                $kode_dps[] = $data_kode_dps['kode_detail_penghapusan'];
            }

            $int_kode_dps = array_map('intval', $kode_dps);

            $kode_terakhir_dps = max($int_kode_dps);

            $urutan_baru = $kode_terakhir_dps + 1;

            $data_urutan_baru = sprintf('%03d', $urutan_baru);

            $kode_detail_penghapusan_baru = "DS".$dpsb.$data_urutan_baru;

            $cari_nama_aset_pr = $con->query("SELECT*FROM inventaris JOIN detail_pengadaan ON detail_pengadaan.kode_detail_pengadaan = inventaris.kode_detail_pengadaan JOIN detail_perencanaan ON detail_perencanaan.kode_detail_perencanaan = detail_pengadaan.kode_detail_perencanaan JOIN jenis_barang ON detail_perencanaan.kode_jenis = jenis_barang.kode_jenis JOIN perencanaan ON detail_perencanaan.kode_perencanaan = perencanaan.kode_perencanaan WHERE inventaris.kode_inventaris = '$kode_inventaris'");
            $nama_aset_pr = mysqli_fetch_assoc($cari_nama_aset_pr);

            $cari_nama_aset_tp = $con->query("SELECT*FROM inventaris JOIN detail_pengadaan_tp ON detail_pengadaan_tp.kode_detail_pengadaan_tp = inventaris.kode_detail_pengadaan JOIN jenis_barang ON detail_pengadaan_tp.kode_jenis = jenis_barang.kode_jenis JOIN pengadaan_tp ON detail_pengadaan_tp.kode_pengadaan_tp = pengadaan_tp.kode_pengadaan_tp WHERE inventaris.kode_inventaris = '$kode_inventaris'");
            $nama_aset_tp = mysqli_fetch_assoc($cari_nama_aset_tp);

            if(empty($nama_aset_pr['aset_perencanaan'])){

                simpan_data_penghapusan($kode_detail_penghapusan_baru, $nama_aset_tp['nama_barang_tp'], $nama_aset_tp['satuan_tp'], $nama_aset_tp['tahun_pengadaan_tp'], $nama_aset_tp['nama_kelompok']);

            } else {

                simpan_data_penghapusan($kode_detail_penghapusan_baru, $nama_aset_pr['aset_perencanaan'], $nama_aset_pr['rencana_satuan_volume'],$nama_aset_pr['tahun_rkp'], $nama_aset_pr['nama_kelompok']);
            }
        }
    }
}

if(isset($_POST['bUbah'])){

    $e_kode_penghapusan = $_POST['kode_penghapusan'];
    $e_detail_penghapusan = $_POST['e_kode_detail_penghapusan'];
    $e_penyebab_penghapusan = $_POST['e_penyebab_penghapusan'];
    $e_tindakan_penghapusan = $_POST['e_tindakan_penghapusan'];
    $e_penanggung_jawab = $_POST['e_penanggung_jawab'];
    $e_tanggal_penghapusan = $_POST['e_tanggal_penghapusan'];

    $e_apbdesa = $_POST['e_apbdesa'];
    $e_perolehan_lain = $_POST['e_perolehan_lain'];
    $e_kekayaan_asli_desa = $_POST['e_kekayaan_asli_desa'];

    $update_detail_penghapusan = $con->query("UPDATE detail_penghapusan SET
        apbdesa = '$e_apbdesa',
        perolehan_lain = '$e_perolehan_lain',
        kekayaan_asli_desa = '$e_kekayaan_asli_desa',
        penyebab_penghapusan = '$e_penyebab_penghapusan',
        tindakan_penghapusan = '$e_tindakan_penghapusan',
        nama_penanggung_jawab = '$e_penanggung_jawab',
        tanggal_penghapusan = '$e_tanggal_penghapusan'
    WHERE kode_detail_penghapusan='$e_detail_penghapusan'");

    if (!$update_detail_penghapusan) {
                    
        echo "<script>
                alert('Maaf Terjadi Masalah, Data tidak dapat disimpan');         
            </script>";

        echo "<script>document.location='../../menu.php?page=detail_penghapusan&kode_penghapusan=$e_kode_penghapusan';</script>";

    } else {

        echo "<script>document.location='../../menu.php?page=detail_penghapusan&kode_penghapusan=$e_kode_penghapusan';</script>";

    }
}

if(isset($_POST['bHapus'])){

    $h_kode_penghapusan = $_POST['h_kode_penghapusan'];
    $h_kode_detail_penghapusan = $_POST['h_kode_detail_penghapusan'];

    $hapus_detail_penghapusan = $con->query("DELETE FROM detail_penghapusan WHERE kode_detail_penghapusan = '$h_kode_detail_penghapusan'");

    if (!$hapus_detail_penghapusan) {
                    
        echo "<script>
                alert('Maaf Terjadi Masalah, Data tidak dapat disimpan');         
            </script>";

        echo "<script>document.location='../../menu.php?page=detail_penghapusan&kode_penghapusan=$h_kode_penghapusan';</script>";

    } else {

        echo "<script>document.location='../../menu.php?page=detail_penghapusan&kode_penghapusan=$h_kode_penghapusan';</script>";

    }
}
    
?>