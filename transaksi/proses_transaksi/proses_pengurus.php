<?php

include('../../koneksi.php');

if(isset($_POST['bSimpan'])){

    // $posisi_pengurus = $_POST['no_pengurus'];
    $nm_pengurus = $_POST['nm_pengurus'];
    $hp_pengurus = $_POST['hp_pengurus'];
    
    $ket_posisi = $_POST['ket_posisi'];

    $posisi_pengurus = strtoupper($ket_posisi);

    if ($posisi_pengurus=='') {
        echo "<script>
                alert('Data pengurus belum lengkap');
                document.location='../../menu.php?page=pengurus';
              </script>";
    } else {
    
    $result=$con->query("SELECT COUNT(nomor_pengurus) AS jmlno_pengurus FROM pengurus WHERE nama_pengurus='$nm_pengurus' AND posisi='$posisi_pengurus'");
    $data=mysqli_fetch_assoc($result);

    $resultkepaladesa=$con->query("SELECT COUNT(posisi) AS kepala_desa FROM pengurus WHERE posisi = 'KEPALA DESA'");
    $datakepaladesa=mysqli_fetch_assoc($resultkepaladesa);

    $resultsekretaris=$con->query("SELECT COUNT(posisi) AS sekretaris FROM pengurus WHERE posisi = 'SEKRETARIS'");
    $datasekretaris=mysqli_fetch_assoc($resultsekretaris);

    $resultpetugas=$con->query("SELECT COUNT(posisi) AS petugas FROM pengurus WHERE posisi = 'KAUR UMUM'");
    $datapetugas=mysqli_fetch_assoc($resultpetugas);

    if($data['jmlno_pengurus'] < 1){

    if ($posisi_pengurus == 'KEPALA DESA') {
        if ($datakepaladesa['kepala_desa'] < 1) {
            $simpan = $con->query("INSERT INTO pengurus (
                nomor_pengurus,
                nama_pengurus,
                no_hp,
                posisi) VALUES (
                    '01',
                    '$nm_pengurus',
                    '$hp_pengurus',
                    '$posisi_pengurus')");          
            echo "<script>document.location='../../menu.php?page=pengurus';</script>";
        } else {
            echo "<script>
                    alert('Data untuk Kepala Desa telah ada !');
                    document.location='../../menu.php?page=pengurus';
                  </script>";
        }
    }
    elseif ($posisi_pengurus == 'SEKRETARIS') {
        if ($datasekretaris['sekretaris'] < 1) {
            $simpan = $con->query("INSERT INTO pengurus (
                nomor_pengurus,
                nama_pengurus,
                no_hp,
                posisi) VALUES (
                    '02',
                    '$nm_pengurus',
                    '$hp_pengurus',
                    '$posisi_pengurus')");          
            echo "<script>document.location='../../menu.php?page=pengurus';</script>";
        } else {
            echo "<script>
                    alert('Data untuk Sekretaris telah ada !');
                    document.location='../../menu.php?page=pengurus';
                  </script>";
        }
        
    }
    elseif ($posisi_pengurus == 'KAUR UMUM') {
        if ($datapetugas['petugas'] < 1) {
            $simpan = $con->query("INSERT INTO pengurus (
                nomor_pengurus,
                nama_pengurus,
                no_hp,
                posisi) VALUES (
                    '03',
                    '$nm_pengurus',
                    '$hp_pengurus',
                    '$posisi_pengurus')");          
            echo "<script>document.location='../../menu.php?page=pengurus';</script>";
        } else {
            echo "<script>
                    alert('Data untuk Kaur Umum telah ada !');
                    document.location='../../menu.php?page=pengurus';
                  </script>";
        }
        
    } else {

    $cek_kd = $con->query("SELECT COUNT(nomor_pengurus) AS cek_kd FROM pengurus WHERE posisi = 'KEPALA DESA'");
    $data_kd = mysqli_fetch_assoc($cek_kd);
    if($data_kd['cek_kd'] < 1){
        echo "<script>
                alert('Data untuk Kepala Desa belum ada, harap input data kepala desa terlebih dahulu !');
                document.location='../../menu.php?page=pengurus';
              </script>";
    } else {
        $cek_sk = $con->query("SELECT COUNT(nomor_pengurus) AS cek_sk FROM pengurus WHERE posisi = 'SEKRETARIS'");
        $data_sk = mysqli_fetch_assoc($cek_sk);
        if($data_sk['cek_sk'] < 1){
        echo "<script>
                alert('Data untuk Sekretaris belum ada, harap input data sekretaris terlebih dahulu !');
                document.location='../../menu.php?page=pengurus';
              </script>";
        } else {
            $cek_ku = $con->query("SELECT COUNT(nomor_pengurus) AS cek_ku FROM pengurus WHERE posisi = 'KAUR UMUM'");
            $data_ku = mysqli_fetch_assoc($cek_ku);
            if($data_ku['cek_ku'] < 1){
                echo "<script>
                        alert('Data untuk Kaur Umum belum ada, harap input data Kaur Umum terlebih dahulu !');
                        document.location='../../menu.php?page=pengurus';
                    </script>";
            } else {

                $cek_no_pengurus = $con->query("SELECT nomor_pengurus FROM pengurus");

                $array_no_pengurus = array();

                while($data_no_pengurus = mysqli_fetch_assoc($cek_no_pengurus)){
                    $array_no_pengurus[] = $data_no_pengurus['nomor_pengurus'];
                }

                $int_no_pengurus = array_map('intval', $array_no_pengurus);

                $nomor_pengurus_akhir = max($int_no_pengurus);

                $nomor_pengurus_baru = $nomor_pengurus_akhir + 1;

                $nomor_pengurus_urutan_baru = sprintf('%02d', $nomor_pengurus_baru);

                $simpan = $con->query("INSERT INTO pengurus (
                    nomor_pengurus,
                    nama_pengurus,
                    no_hp,
                    posisi) VALUES (
                        '$nomor_pengurus_urutan_baru',
                        '$nm_pengurus',
                        '$hp_pengurus',
                        '$posisi_pengurus')");          

                if($simpan){
                    echo "<script>document.location='../../menu.php?page=pengurus';</script>";
                } else {
                    echo "<script>
                        alert('Gagal Input Data !');
                        document.location='../../menu.php?page=pengurus';
                    </script>";
                }

            }
          }        
        }


      }
    } else {
        echo "<script>
                alert('Pengurus dengan nama $nm_pengurus dan posisi $posisi_pengurus telah ada !');
                document.location='../../menu.php?page=pengurus';
              </script>";
    }
  }
}

if(isset($_POST['bHapus'])){
    
    $eno_pengurus = $_POST['hpengurus'];

    $hapus = $con->query("DELETE FROM pengurus WHERE nomor_pengurus = '$eno_pengurus'");

    if($hapus){
        echo "<script>
                  document.location='../../menu.php?page=pengurus';
               </script>";
    } else {
          echo "<script>
                  alert('Gagal Hapus Data');
                  document.location='../../menu.php?page=pengurus';
                </script>";
}}

if(isset($_POST['bUbah'])){

    $eno_pengurus = $_POST['eno_pengurus'];
    $enm_pengurus = $_POST['enama_pengurus'];
    $ehp_pengurus = $_POST['ehp_pengurus'];

    $ubah = $con->query("UPDATE pengurus SET
        nama_pengurus = '$enm_pengurus',
        no_hp = '$ehp_pengurus'
    WHERE nomor_pengurus = '$eno_pengurus'");

    if($ubah){
        echo "<script>
                    document.location='../../menu.php?page=pengurus';
              </script>";
    } else {
        echo "<script>
                    alert('Gagal Ubah Data');
                    document.location='../../menu.php?page=pengurus';
              </script>";
    }
  }

?>