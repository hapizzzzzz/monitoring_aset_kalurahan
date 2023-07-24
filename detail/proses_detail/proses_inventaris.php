<?php
include ('../../koneksi.php');

if(isset($_POST['bSimpan'])){

    $in_kode_jenis = $_POST['in_kode_jenis'];
    $kode_detail_pengadaan = $_POST['pilihan_pengadaan'];
    $identitas_barang = $_POST['identitas_inventaris'];
    $jumlah_barang = $_POST['jumlah_inventaris'];
    $satuan_aset = $_POST['satuan_inventaris'];
    $keterangan_aset = $_POST['keterangan_inventaris'];

    $cek_jenis = $con->query("SELECT COUNT(kode_inventaris) AS injml FROM inventaris WHERE SUBSTRING(kode_inventaris, 1, 7) = '$in_kode_jenis'");
    $cek_urutan_jenis = mysqli_fetch_assoc($cek_jenis);

    if($cek_urutan_jenis['injml'] < 1){
        $urutan_kode = sprintf('%05d', 1);
        $kode_inventaris = $in_kode_jenis.$urutan_kode;

        $simpan = $con->query("INSERT INTO inventaris (
            kode_inventaris,
            kode_detail_pengadaan,
            identitas_barang,
            jumlah,
            satuan,
            keterangan_aset) VALUES (
                '$kode_inventaris',
                '$kode_detail_pengadaan',
                '$identitas_barang',
                '$jumlah_barang',
                '$satuan_aset',
                '$keterangan_aset')");

        $cek_kuota = $con->query("SELECT COUNT(kode_kuota) AS jmlkuota FROM kuota_aset");
        $data_kuota = mysqli_fetch_assoc($cek_kuota);

        if($data_kuota['jmlkuota'] < 1){
            $simpan_kuota = $con->query("INSERT INTO kuota_aset (
                kode_kuota,
                kode_inventaris,
                jumlah_kuota) VALUES (
                    'KA0000000001',
                    '$kode_inventaris',
                    '$jumlah_barang')");
        } else {
            $urutan_kuota=array();

            $cek_urutan_kuota = $con->query("SELECT SUBSTRING(kode_kuota,3,10) FROM kuota_aset");
            while($urutan_data_kuota=$cek_urutan_kuota->fetch_assoc()){
                $urutan_kuota[] = $urutan_data_kuota['SUBSTRING(kode_kuota,3,10)'];
            }
    
            $IDskodekt = array_map('intval',$urutan_kuota);
    
            $kode_akhir_kuota = max($IDskodekt);
    
            $kode_urutan_kuota = $kode_akhir_kuota+1;
    
            $urutan_kuota_baru = sprintf('%010d', $kode_urutan_kuota);
    
            $kode_kuota_baru = "KA".$urutan_kuota_baru;
    
            $simpan_kuota = $con->query("INSERT INTO kuota_aset (
                kode_kuota,
                kode_inventaris,
                jumlah_kuota) VALUES (
                    '$kode_kuota_baru',
                    '$kode_inventaris',
                    '$jumlah_barang')");
    
        } 

    } else {

        $kumpulan_data = array();

        $cek_urutan_data = $con->query("SELECT SUBSTRING(kode_inventaris, 8, 5) FROM inventaris WHERE SUBSTRING(kode_inventaris, 1, 7) = '$in_kode_jenis'");
        while ($urutan_data=$cek_urutan_data->fetch_assoc()) {
            $kumpulan_data[] = $urutan_data['SUBSTRING(kode_inventaris, 8, 5)'];
        }

        $IDskodein = array_map('intval', $kumpulan_data);

        $kode_akhir_in = max($IDskodein);
        $kode_urutan_in = $kode_akhir_in + 1;

        $kode_urutan_baru = sprintf('%05d', $kode_urutan_in);

        $kode_baru_in = $in_kode_jenis.$kode_urutan_baru;

        $simpan = $con->query("INSERT INTO inventaris (
            kode_inventaris,
            kode_detail_pengadaan,
            identitas_barang,
            jumlah,
            satuan,
            keterangan_aset) VALUES (
                '$kode_baru_in',
                '$kode_detail_pengadaan',
                '$identitas_barang',
                '$jumlah_barang',
                '$satuan_aset',
                '$keterangan_aset')");

        $urutan_kuota=array();

        $cek_urutan_kuota = $con->query("SELECT SUBSTRING(kode_kuota,3,10) FROM kuota_aset");
        while($urutan_data_kuota=$cek_urutan_kuota->fetch_assoc()){
            $urutan_kuota[] = $urutan_data_kuota['SUBSTRING(kode_kuota,3,10)'];
        }

        $IDskodekt = array_map('intval',$urutan_kuota);

        $kode_akhir_kuota = max($IDskodekt);

        $kode_urutan_kuota = $kode_akhir_kuota+1;

        $urutan_kuota_baru = sprintf('%010d', $kode_urutan_kuota);

        $kode_kuota_baru = "KA".$urutan_kuota_baru;

        $simpan_kuota = $con->query("INSERT INTO kuota_aset (
            kode_kuota,
            kode_inventaris,
            jumlah_kuota) VALUES (
                '$kode_kuota_baru',
                '$kode_baru_in',
                '$jumlah_barang')");

    }
    
            if($simpan_kuota){
                echo "<script>
                        document.location='../../menu.php?page=inventaris';
                      </script>";
            } else {
                echo "<script>
                        alert('Gagal Simpan Data');
                        document.location='../../menu.php?page=inventaris;
                      </script>";
            }
}


if(isset($_POST['bUbah'])){

    $kode_inventaris = $_POST['ein_kode'];
    $identitas = $_POST['ein_identitas'];
    $keterangan =$_POST['ein_keterangan'];

    $ubah = $con->query("UPDATE inventaris SET
        identitas_barang = '$identitas',
        keterangan_aset = '$keterangan'
    WHERE kode_inventaris = '$kode_inventaris'");

    if($ubah){
        echo "<script>
                document.location='../../menu.php?page=inventaris';
              </script>";
    } else {
        echo "<script>
                alert('Gagal Ubah Data');
                document.location='../../menu.php?page=inventaris';
              </script>";
    }
}

if(isset($_POST['bUbahTP'])){

    $kode_inventaris = $_POST['ein_kode_tp'];
    $identitas = $_POST['ein_identitas_tp'];
    $keterangan =$_POST['ein_keterangan_tp'];

    $ubah = $con->query("UPDATE inventaris SET
        identitas_barang = '$identitas',
        keterangan_aset = '$keterangan'
    WHERE kode_inventaris = '$kode_inventaris'");

    if($ubah){
        echo "<script>
                document.location='../../menu.php?page=inventaris';
              </script>";
    } else {
        echo "<script>
                alert('Gagal Ubah Data');
                document.location='../../menu.php?page=inventaris';
              </script>";
    }
}


if(isset($_POST['bHapus'])){ 

    $hapus = $con->query("DELETE FROM inventaris WHERE kode_inventaris = '$_POST[kode_inventaris]'");
    if($hapus){
        echo "<script>
                    document.location='../../menu.php?page=inventaris';
              </script>";
    } else {
        echo "<script>
                alert('Gagal Hapus Data');
              </script>";
    }
}

if(isset($_POST['bHapusTP'])){ 

    $hapus = $con->query("DELETE FROM inventaris WHERE kode_inventaris = '$_POST[kode_inventaris_tp]'");
    if($hapus){
        echo "<script>
                    document.location='../../menu.php?page=inventaris';
              </script>";
    } else {
        echo "<script>
                alert('Gagal Hapus Data');
              </script>";
    }
}
    
?>