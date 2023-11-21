<?php

include('../../koneksi.php');

if(isset($_POST['bSimpan'])){

?>

<?php

    $no_berita_acara = $_POST['no_berita_acara'];
    $tahun_berita_acara = $_POST['tahun_berita_acara'];
    $tanggal_berita_acara = $_POST['tanggal_berita_acara'];
    $nomor_keputusan = $_POST['nomor_keputusan'];
    $tahun_keputusan = $_POST['tahun_keputusan'];

    $nama_file_penghapusan = $_FILES['file']['name'];
    $lokasi_file_penghapusan = $_FILES['file']['tmp_name'];

    $nba = sprintf('%02d', $no_berita_acara);
    $nk = sprintf('%02d', $nomor_keputusan);
    
    $result=$con->query("SELECT COUNT(kode_penghapusan) AS jmlkode FROM penghapusan WHERE no_berita_acara = '$nba' AND tahun_berita_acara = '$tahun_berita_acara' AND tanggal_berita_acara = '$tanggal_berita_acara'");
    $data=mysqli_fetch_assoc($result);

    $format_file = substr($nama_file_penghapusan, -4);

    if (($format_file == ".pdf") || ($format_file == ".PDF")){

        if($data['jmlkode'] < 1){

            $date   = new DateTime($tanggal_berita_acara);
            $t_b_a = $date->format('d-m-y');
            $tba    = explode('-', $t_b_a);
            $tbax = implode("", $tba);

            $kodeps = "PS".$nba.$tbax;

            $namabaru_file_penghapusan = "SPS_".$kodeps.".pdf";

            $simpan = $con->query("INSERT INTO penghapusan (
                kode_penghapusan,
                no_berita_acara,
                tahun_berita_acara,
                tanggal_berita_acara,
                nomor_keputusan,
                tahun_keputusan,
                file_penghapusan) VALUES (
                    '$kodeps',
                    '$nba',
                    '$tahun_berita_acara',
                    '$tanggal_berita_acara',
                    '$nk',
                    '$tahun_keputusan',
                    '$namabaru_file_penghapusan')");
                    
                echo "<script>document.location='../../menu.php?page=penghapusan';</script>";

                if (!$simpan) {
                    echo "<script>
                                alert('Terjadi Kesalahan Dalam Menyimpan Data !');
                                document.location='../../menu.php?page=penghapusan';
                            </script>";
                } else {
                    move_uploaded_file($lokasi_file_penghapusan, "../../file_penghapusan/".$namabaru_file_penghapusan);
                }

            } else {
                echo "<script>
                        alert('Penghapusan dengan nomor berita acara $no_berita_acara, tanggal $tanggal_berita_acara, dan tahun $tahun_berita_acara telah ada');
                        document.location='../../menu.php?page=penghapusan';
                      </script>";
            }
    } else {
        echo "<script>
                alert('Format file harus .pdf !');
                document.location='../../menu.php?page=penghapusan';
            </script>";
    } 
}

if(isset($_POST['bHapus'])){

    function hapus_penghapusan(){

        include('../../koneksi.php');

        $hapus = $con->query("DELETE FROM penghapusan WHERE kode_penghapusan = '$_POST[kode_penghapusan]'");

        if($hapus){
            echo "<script>
                    document.location='../../menu.php?page=penghapusan';
                </script>";
        } else {
            echo "<script>
                    alert('Gagal Hapus Data');
                    document.location='../../menu.php?page=penghapusan';
                </script>";
        }
    }

    $nama_file = $_POST['hfile'];

    $lokasi_file = '../../file_penghapusan/'.$nama_file;
    $status=unlink($lokasi_file);

    if($status){

        hapus_penghapusan();
        
    } else {
        // echo "<script>
        //     alert('Gagal Hapus File Penghapusan');
        //     document.location='../../menu.php?page=penghapusan';
        // </script>";
    }

    // $cek_file_pemanfaatan = $con->query("SELECT COUNT(detail_pemanfaatan.file_pemanfaatan) AS jumlah_file FROM perencanaan JOIN detail_perencanaan ON perencanaan.kode_perencanaan = detail_perencanaan.kode_perencanaan
    //                                      JOIN detail_pengadaan ON detail_pengadaan.kode_detail_perencanaan = detail_perencanaan.kode_detail_perencanaan
    //                                      JOIN inventaris ON detail_pengadaan.kode_detail_pengadaan = inventaris.kode_detail_pengadaan JOIN detail_pemanfaatan ON detail_pemanfaatan.kode_inventaris = inventaris.kode_inventaris
    //                                      WHERE perencanaan.kode_perencanaan = '$_POST[pkode]'");
    
    // $jumlah_file = mysqli_fetch_assoc($cek_file_pemanfaatan);

    // if($jumlah_file['jumlah_file'] < 1){
    //     hapus_perencanaan();
    // } else {
        
    //     $file_pemanfaatan = $con->query("SELECT detail_pemanfaatan.file_pemanfaatan FROM perencanaan JOIN detail_perencanaan ON perencanaan.kode_perencanaan = detail_perencanaan.kode_perencanaan
    //                                      JOIN detail_pengadaan ON detail_pengadaan.kode_detail_perencanaan = detail_perencanaan.kode_detail_perencanaan
    //                                      JOIN inventaris ON detail_pengadaan.kode_detail_pengadaan = inventaris.kode_detail_pengadaan JOIN detail_pemanfaatan ON detail_pemanfaatan.kode_inventaris = inventaris.kode_inventaris
    //                                      WHERE perencanaan.kode_perencanaan = '$_POST[pkode]'");

    //     while ($surat_perjanjian = mysqli_fetch_assoc($file_pemanfaatan)){
            
    //         $lokasi_file = '../../file_pemanfaatan/'.$surat_perjanjian['file_pemanfaatan'];
    //         $status=unlink($lokasi_file);

    //     }

    //     if($status){
    //         hapus_perencanaan();
    //     } else {
    //         echo "<script>
    //                 alert('Gagal Hapus Data Perencanaan');
    //                 document.location='../../menu.php?page=perencanaan';
    //             </script>";
    //     }
    // }
} 


if(isset($_POST['bUbah'])){

    $kode_penghapusan = $_POST['kode_penghapusan'];

    function ubah_penghapusan(){

        $kode_penghapusan = $_POST['kode_penghapusan'];

        include('../../koneksi.php');

        $no_keputusan = $_POST['no_keputusan'];
        $tahun_keputusan = $_POST['tahun_keputusan'];

        $ubah = $con->query("UPDATE penghapusan SET
        nomor_keputusan = '$no_keputusan',
        tahun_keputusan = '$tahun_keputusan'
        WHERE kode_penghapusan = '$kode_penghapusan'");

        if($ubah){
            echo "<script>
                        document.location='../../menu.php?page=penghapusan';
                </script>";
        } else {
            echo "<script>
                        alert('Gagal Ubah Data');
                        document.location='../../menu.php?page=penghapusan';
                </script>";
        }
    }

    $enama_file_penghapusan = $_FILES['e_file']['name'];
    $elokasi_file_penghapusan = $_FILES['e_file']['tmp_name'];

    $file_penghapusan = $_POST['file_penghapusan'];

    if ($enama_file_penghapusan == "") {

        ubah_penghapusan();

    } else {

        $format_file = substr($enama_file_penghapusan, -4);

        if (($format_file == ".pdf") || ($format_file == ".PDF")){
            $lokasi_file = '../../file_penghapusan/'.$file_penghapusan;
            $status=unlink($lokasi_file);

            if($status){

                ubah_penghapusan();

                $cari_file_penghapusan = $con->query("SELECT file_penghapusan FROM penghapusan WHERE kode_penghapusan = '$kode_penghapusan'");
                $nama_file_penghapusan = mysqli_fetch_assoc($cari_file_penghapusan);

                $ubah_nama_file = $nama_file_penghapusan['file_penghapusan'];

                move_uploaded_file($elokasi_file_penghapusan, "../../file_penghapusan/".$ubah_nama_file);
            }

        } else {
            echo "<script>
                    alert('Format file harus .pdf !');
                    document.location='../../menu.php?page=penghapusan';
                </script>";
        } 

    }

}

?>