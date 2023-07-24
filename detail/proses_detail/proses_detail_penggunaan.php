<?php
include ('../../koneksi.php');

if(isset($_POST['bSimpan'])){

    $pilihan_aset = $_POST['pilihan_aset'];
    $jumlah_pg = $_POST['jumlah_pg'];
    $identitas_pg = $_POST['identitas_pg'];
    $keterangan_pg = $_POST['keterangan_pg'];
    $kode_penggunaan = $_POST['tkode_penggunaan'];

    $cek_kuota= $con->query("SELECT jumlah_kuota FROM kuota_aset WHERE kode_inventaris = '$pilihan_aset'");
    $sisa_kuota = mysqli_fetch_assoc($cek_kuota);
    
    if($jumlah_pg > $sisa_kuota['jumlah_kuota']){
        echo "<script>
                alert('Jumlah yang ingin digunakan melebihi sisa kuota');
                document.location='../../menu.php?page=detail_penggunaan&kode_penggunaan=$kode_penggunaan';
              </script>";
    } else {
        $cek_u_dpg = $con->query("SELECT COUNT(kode_detail_penggunaan) AS jumdpg FROM detail_penggunaan");
        $u_dpg_akhir = mysqli_fetch_assoc($cek_u_dpg);

        if($u_dpg_akhir['jumdpg'] < 1){

            $kode_dpg = "DPG0000001";

            $simpan_penggunaan = $con->query("INSERT INTO detail_penggunaan (
                kode_penggunaan,
                kode_detail_penggunaan,
                kode_inventaris,
                jumlah_pg,
                keterangan_penggunaan
                    ) VALUES (
                    '$kode_penggunaan',
                    '$kode_dpg',
                    '$pilihan_aset',
                    '$jumlah_pg',
                    '$keterangan_pg')");

            $kuota_aset = array();
            
            $cek_sisa_kuota = $con->query("SELECT jumlah_kuota FROM kuota_aset WHERE kode_inventaris = '$pilihan_aset'");
            while($sisa_kuota = $cek_sisa_kuota->fetch_assoc()){
                $kuota_aset[] = $sisa_kuota['jumlah_kuota'];
            }

            $sisa_kuota_aset = max($kuota_aset);

            $kuota_baru = $sisa_kuota_aset - $jumlah_pg;

            $update_kuota = $con->query("UPDATE kuota_aset SET jumlah_kuota = '$kuota_baru' WHERE kode_inventaris='$pilihan_aset'");

            if($update_kuota){
                echo "<script>
                        document.location='../../menu.php?page=detail_penggunaan&kode_penggunaan=$kode_penggunaan';
                      </script>";
            } else {
                echo "<script>
                        alert('Gagal Simpan Data');
                        document.location='../../menu.php?page=detail_penggunaan&kode_penggunaan=$kode_penggunaan';
                      </script>";
            }

        } else {

            $data_kode_dpg = array();

            $cek_detail_pg = $con->query("SELECT SUBSTR(kode_detail_penggunaan,4,7) AS kdpg FROM detail_penggunaan");
            while($data_detail_pg=$cek_detail_pg->fetch_assoc()){
                $data_kode_dpg[] = $data_detail_pg['kdpg'];
            }

            $int_dpgIDs = array_map('intval', $data_kode_dpg);

            $kdpg_akhir = max($int_dpgIDs);

            $kdpg_baru = $kdpg_akhir + 1;

            $kdpg_urutan_baru = sprintf('%07d', $kdpg_baru);

            $kode_dpg = "DPG".$kdpg_urutan_baru;

            $simpan_penggunaan = $con->query("INSERT INTO detail_penggunaan (
                kode_penggunaan,
                kode_detail_penggunaan,
                kode_inventaris,
                jumlah_pg,
                keterangan_penggunaan
                    ) VALUES (
                    '$kode_penggunaan',
                    '$kode_dpg',
                    '$pilihan_aset',
                    '$jumlah_pg',
                    '$keterangan_pg')");

            $kuota_aset = array();
            
            $cek_sisa_kuota = $con->query("SELECT jumlah_kuota FROM kuota_aset WHERE kode_inventaris = '$pilihan_aset'");
            while($sisa_kuota = $cek_sisa_kuota->fetch_assoc()){
                $kuota_aset[] = $sisa_kuota['jumlah_kuota'];
            }

            $sisa_kuota_aset = max($kuota_aset);

            $kuota_baru = $sisa_kuota_aset - $jumlah_pg;

            $update_kuota = $con->query("UPDATE kuota_aset SET jumlah_kuota = '$kuota_baru' WHERE kode_inventaris='$pilihan_aset'");

            if($update_kuota){
                echo "<script>
                        document.location='../../menu.php?page=detail_penggunaan&kode_penggunaan=$kode_penggunaan';
                      </script>";
            } else {
                echo "<script>
                        alert('Gagal Simpan Data');
                        document.location='../../menu.php?page=detail_penggunaan&kode_penggunaan=$kode_penggunaan';
                      </script>";
            }

        }
    }
    
}

if(isset($_POST['bHapusTP'])){
    
    $kode_penggunaan = $_POST['kode_penggunaan'];
    $jumlah_pg = $_POST['jumlah_pg'];
    $kode_detail_penggunaan = $_POST['kode_detail_penggunaan'];
    $kode_inventaris = $_POST['kode_in_pg'];

    $hapus = $con->query("DELETE FROM detail_penggunaan WHERE kode_detail_penggunaan = '$kode_detail_penggunaan'");
    
    $cek_kuota = $con->query("SELECT jumlah_kuota FROM kuota_aset WHERE kode_inventaris = '$kode_inventaris'");
    
    $sisa_kuota = array();

    while($cek_sisa=$cek_kuota->fetch_assoc()){
        $sisa_kuota[] = $cek_sisa['jumlah_kuota'];
    }

    $sisa_kuota_aset = max($sisa_kuota);

    $pulih_kuota = $sisa_kuota_aset + $jumlah_pg;

    $pulihkan_kuota = $con->query("UPDATE kuota_aset SET jumlah_kuota = '$pulih_kuota' WHERE kode_inventaris = '$kode_inventaris'");

    if($pulihkan_kuota){
        echo "<script>
                document.location='../../menu.php?page=detail_penggunaan&kode_penggunaan=$kode_penggunaan';
              </script>";
    } else {
        echo "<script>
                alert('Gagal Hapus Data');
                document.location='../../menu.php?page=detail_penggunaan&kode_penggunaan=$kode_penggunaan';
              </script>";
    }
}

if(isset($_POST['bHapus'])){
    
    $kode_penggunaan = $_POST['kode_penggunaan'];
    $jumlah_pg = $_POST['jumlah_pg'];
    $kode_detail_penggunaan = $_POST['kode_detail_penggunaan'];
    $kode_inventaris = $_POST['kode_in_pg'];

    $hapus = $con->query("DELETE FROM detail_penggunaan WHERE kode_detail_penggunaan = '$kode_detail_penggunaan'");
    
    $cek_kuota = $con->query("SELECT jumlah_kuota FROM kuota_aset WHERE kode_inventaris = '$kode_inventaris'");
    
    $sisa_kuota = array();

    while($cek_sisa=$cek_kuota->fetch_assoc()){
        $sisa_kuota[] = $cek_sisa['jumlah_kuota'];
    }

    $sisa_kuota_aset = max($sisa_kuota);

    $pulih_kuota = $sisa_kuota_aset + $jumlah_pg;

    $pulihkan_kuota = $con->query("UPDATE kuota_aset SET jumlah_kuota = '$pulih_kuota' WHERE kode_inventaris = '$kode_inventaris'");

    if($pulihkan_kuota){
        echo "<script>
                document.location='../../menu.php?page=detail_penggunaan&kode_penggunaan=$kode_penggunaan';
              </script>";
    } else {
        echo "<script>
                alert('Gagal Hapus Data');
                document.location='../../menu.php?page=detail_penggunaan&kode_penggunaan=$kode_penggunaan';
              </script>";
    }
}

if(isset($_POST['bUbahTP'])){
    
    $kode_penggunaan = $_POST['kode_penggunaan'];
    $kode_detail_penggunaan = $_POST['epg_kode_dpgtp'];
    $keterangan_epgtp = $_POST['epg_keterangan_tp'];

    $ubah_epgtp = $con->query("UPDATE detail_penggunaan SET keterangan_penggunaan = '$keterangan_epgtp' WHERE kode_detail_penggunaan = '$kode_detail_penggunaan'");

    if($ubah_epgtp){
        echo "<script>
                document.location='../../menu.php?page=detail_penggunaan&kode_penggunaan=$kode_penggunaan';
              </script>";
    } else {
        echo "<script>
                alert('Gagal Hapus Data');
                document.location='../../menu.php?page=detail_penggunaan&kode_penggunaan=$kode_penggunaan';
              </script>";
    }
}

if(isset($_POST['bUbah'])){
    
    $kode_penggunaan = $_POST['kode_penggunaan'];
    $kode_detail_penggunaan = $_POST['epg_kode_dpg'];
    $keterangan_epg = $_POST['epg_keterangan'];

    $ubah_epg = $con->query("UPDATE detail_penggunaan SET keterangan_penggunaan = '$keterangan_epg' WHERE kode_detail_penggunaan = '$kode_detail_penggunaan'");

    if($ubah_epg){
        echo "<script>
                document.location='../../menu.php?page=detail_penggunaan&kode_penggunaan=$kode_penggunaan';
              </script>";
    } else {
        echo "<script>
                alert('Gagal Hapus Data');
                document.location='../../menu.php?page=detail_penggunaan&kode_penggunaan=$kode_penggunaan';
              </script>";
    }
}
    
?>