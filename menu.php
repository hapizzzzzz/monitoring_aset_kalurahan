<?php
include ('koneksi.php');
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous" /> -->
    <!-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha2/css/bootstrap.min.css" integrity="sha384-DhY6onE6f3zzKbjUPRc2hOzGAdEf4/Dz+WJwBvEYL/lkkIsI3ihufq9hk9K4lVoK" crossorigin="anonymous"/> -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css"/>


    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script type="text/javascript" language="javascript" src="http://cdn.datatables.net/1.10.4/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" language="javascript" src="http://cdn.datatables.net/plug-ins/1.13.2/integration/bootstrap/3/dataTables.bootstrap.js"></script>

    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <link href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css" rel="stylesheet" />

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>

    <link rel="stylesheet" href="style.css">
    <script type="text/javascript" charset="utf-8">
        $(document).ready(function() {
	    $('#table').DataTable();
        });
    </script>
    <script>
        $(function () {
            $('[data-toggle="tooltip"]').tooltip({
            trigger : 'hover'
            })  
        })
    </script>
    <title>ASET</title>
</head>
<body>
    <!-- <div class="header"><img src="gambar/logo.png" alt="logo" align="right" style="width:60px; margin:2px"></div> -->
    <div class="sidebar p-4 bg-primary">
        <H4 class="mb-5 text-white">Aset Kalurahan Sendangtirto</H4>
        <li onclick="location.href='menu.php?page=pengurus'">
            <a class="text-white" href="menu.php?page=pengurus"><i class="bi bi-person"></i>Pengurus</a>
        </li>
        <li onclick="location.href='menu.php?page=perencanaan'">
            <a class="text-white" href="menu.php?page=perencanaan"><i class="bi bi-clipboard"></i>Perencanaan</a>
        </li>
        <li onclick="subPengadaan()">
            <a class="text-white" href="#"><i class="bi bi-clipboard-plus"></i>Pengadaan</a>
        </li>
        <li id="sub_1" style="margin-left: 10%; font-size: 85%; display: none;" onclick="location.href='menu.php?page=pengadaan'">
            <a class="text-white" href="menu.php?page=pengadaan"><i class="bi bi-arrow-right-circle"></i>Berdasar Perencanaan</a>
        </li>
        <li id="sub_2" style="margin-left: 10%; font-size: 85%; display: none;" onclick="location.href='menu.php?page=pengadaan_tp'">
            <a class="text-white" href="menu.php?page=pengadaan_tp"><i class="bi bi-arrow-right-circle"></i>Tanpa Perencanaan</a>
        </li>
        <li onclick="location.href='menu.php?page=inventaris'">
            <a class="text-white" href="menu.php?page=inventaris"><i class="bi bi-box2"></i>Inventaris</a>
        </li>
        <li onclick="location.href='menu.php?page=penggunaan'">
            <a class="text-white" href="menu.php?page=penggunaan"><i class="bi bi-gear"></i>Penggunaan</a>
        </li>
        <li onclick="location.href='menu.php?page=pemanfaatan'">
            <a class="text-white" href="menu.php?page=pemanfaatan"><i class="bi bi-boxes"></i>Pemanfaatan</a>
        </li>
        <li onclick="location.href='menu.php?page=penghapusan'">
            <a class="text-white" href="menu.php?page=penghapusan"><i class="bi bi-eraser"></i>Penghapusan</a>
        </li>
    </div>

    <?php
    if (isset($_GET['page'])) {
        $page = $_GET['page'];
    
    switch ($page) {
        case 'perencanaan':
            include "perencanaan.php";
            break;
        case 'tambah_perencanaan':
            include "transaksi/tambah_perencanaan.php";
            break;
        case 'detail_perencanaan':
            include "detail/detail_perencanaan.php";
            break;
        case 'pengadaan':
            include "pengadaan.php";
            break;
        case 'pengadaan_tp':
            include "pengadaan_tp.php";
            break;
        case 'tambah_pengadaan':
            include "transaksi/tambah_pengadaan.php";
            break;
        case 'tambah_inventaris':
            include "transaksi/tambah_inventaris.php";
            break;
        case 'tambah_pengadaan_tp':
            include "transaksi/tambah_pengadaan_tp.php";
            break;
        case 'detail_pengadaan':
            include "detail/detail_pengadaan.php";
            break;
        case 'detail_pengadaantp':
            include "detail/detail_pengadaantp.php";
            break;
        case 'tambah_detail_pengadaan':
            include "detail/tambah_detail_pengadaan.php";
            break;
        case 'pengurus':
            include "pengurus.php";
            break;
        case 'inventaris':
            include "inventaris.php";
            break;
        case 'penggunaan':
            include "penggunaan.php";
            break;
        case 'detail_penggunaan':
            include "detail/detail_penggunaan.php";
            break;
        case 'pemanfaatan':
            include "pemanfaatan.php";
            break;
        case 'detail_pemanfaatan':
            include "detail/detail_pemanfaatan.php";
            break;
        case 'riwayat_pemanfaatan':
            include "detail/riwayat_pemanfaatan.php";
            break;
        case 'penghapusan':
            include "penghapusan.php";
            break;
        default:
            echo "<h1 style='margin-left:10cm'>Halaman tidak ditemukan</h1>";
            break;
    }
    }
    ?>
</body>

<script>
    
function subPengadaan() {
  var x = document.getElementById("sub_1");
  var y = document.getElementById("sub_2");
  if (x.style.display === "none" && y.style.display === "none") {
    x.style.display = "block";
    y.style.display = "block";
  } else {
    x.style.display = "none";
    y.style.display = "none";
  }
}
</script>

</html>