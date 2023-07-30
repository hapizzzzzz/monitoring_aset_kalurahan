<?php

include('../../koneksi.php');

if(isset($_POST['bSimpan'])){

    $mixfont_lokasi = $_POST['lokasi_penggunaan'];
    $lokasi =  strtoupper($mixfont_lokasi);
    $pengguna = $_POST['pengguna'];
    
    $cek = $con->query("SELECT COUNT(kode_penggunaan) AS jumkode FROM penggunaan");
    $jum_kode = mysqli_fetch_assoc($cek);

    if($jum_kode['jumkode'] < 1){

        $kode_penggunaan_baru = "PG00001";

        $simpan = $con->query("INSERT INTO penggunaan (kode_penggunaan, pengguna, lokasi) VALUES ('$kode_penggunaan_baru','$pengguna','$lokasi')");

        if($simpan){
            echo "<script>
                        document.location='../../menu.php?page=penggunaan';
                  </script>";
        } else {
            echo "<script>
                        alert('Data penggunaan gagal ditambahkan !');
                        document.location='../../menu.php?page=penggunaan';
                  </script>";
        }

    } else {

        $cek_pengguna = $con->query("SELECT COUNT(kode_penggunaan) AS jumpenggunaan FROM penggunaan WHERE pengguna = '$pengguna' AND lokasi = '$lokasi'");
        $cek_penggunaan = mysqli_fetch_assoc($cek_pengguna);

            if($cek_penggunaan['jumpenggunaan'] < 1){

                $cek_kode = $con->query("SELECT SUBSTR(kode_penggunaan, 3, 5) AS dkpg FROM penggunaan");
                $kode_terakhir = array();

                while($cek_kode_akhir = $cek_kode->fetch_assoc()){
                    $kode_terakhir[] = $cek_kode_akhir['dkpg'];
                }

                $kode_pgIDs = array_map('intval', $kode_terakhir);

                $kode_urutan_terakhir = max($kode_pgIDs);

                $kode_urutan_baru = $kode_urutan_terakhir + 1;

                $kode_leading_baru = sprintf('%05d', $kode_urutan_baru);

                $kode_penggunaan_baru = "PG".$kode_leading_baru;

                $simpan = $con->query("INSERT INTO penggunaan (kode_penggunaan, pengguna, lokasi) VALUES ('$kode_penggunaan_baru','$pengguna','$lokasi')");

                if($simpan){
                    echo "<script>
                                document.location='../../menu.php?page=penggunaan';
                          </script>";
                } else {
                    echo "<script>
                                alert('Data penggunaan gagal ditambahkan !');
                                document.location='../../menu.php?page=penggunaan';
                          </script>";
                }                   

            } else {
                echo "<script>
                            alert('Penggunaan dengan nama pengguna $pengguna pada lokasi $lokasi telah ada !');
                            document.location='../../menu.php?page=penggunaan';
                      </script>";
            }

    }
}

if(isset($_POST['bUbah'])){
    

    $kode = $_POST['ekode_penggunaan'];
    $mixfont_lokasi = $_POST['elokasi_penggunaan'];
    $lokasi =  strtoupper($mixfont_lokasi);
    $pengguna = $_POST['epengguna'];

    $ubah = $con->query("UPDATE penggunaan SET lokasi='$lokasi', pengguna='$pengguna' WHERE kode_penggunaan = '$kode'");

    if($ubah){
        echo "<script>document.location='../../menu.php?page=penggunaan';</script>";
    } else {
        echo "<script>
                    alert('Data penggunaan gagal diubah !');
                    document.location='../../menu.php?page=penggunaan';
              </script>";
    }
}

if(isset($_POST['bHapus'])){
    

    $kode = $_POST['kode_penggunaan'];

    $cek_detail_penggunaan = $con->query("SELECT * FROM detail_penggunaan WHERE kode_penggunaan = '$kode'");
    while($data_detail_penggunaan=$cek_detail_penggunaan->fetch_assoc()){

        $jum_dpg = array();

        $cek_jumlah_dpg = $con->query("SELECT jumlah_kuota FROM kuota_aset WHERE kode_inventaris = '$data_detail_penggunaan[kode_inventaris]'");
        while($jumlah_dpg=$cek_jumlah_dpg->fetch_assoc()){
            $jum_dpg = $jumlah_dpg['jumlah_kuota'];
        }


        $kuota_inv = $jum_dpg + $data_detail_penggunaan['jumlah_pg'];;

        $pulih_pg = $con->query("UPDATE kuota_aset SET jumlah_kuota = '$kuota_inv' WHERE kode_inventaris = '$data_detail_penggunaan[kode_inventaris]'");

        if($pulih_pg){
            $hapus_detail_penggunaan = $con->query("DELETE FROM detail_penggunaan WHERE kode_detail_penggunaan ='$data_detail_penggunaan[kode_detail_penggunaan]'");
        }

    }

    $hapus = $con->query("DELETE FROM penggunaan WHERE kode_penggunaan = '$kode'");

    if($hapus){
        echo "<script>document.location='../../menu.php?page=penggunaan';</script>";
    } else {
        echo "<script>
                    alert('Data penggunaan gagal dihapus !');
                    document.location='../../menu.php?page=penggunaan';
              </script>";
    }
}

?>