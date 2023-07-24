<?php
	include_once('../koneksi.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Penggunaan Aset</title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
	<style>
		table {page-break-inside: avoid;}
		thead {display: table-row-group;}
		tr{page-break-inside: avoid;}
		h3{font-size: 110%};
		h4{font-size: 2cm};
	</style>
</head>
<body>

<?php

	// $tahun_tp = $_POST['pilihan_tahun_tp'];
	// $pengadaan_tp = $con->query("SELECT * FROM pengadaan_tp JOIN detail_pengadaan_tp ON pengadaan_tp.kode_pengadaan_tp = detail_pengadaan_tp.kode_pengadaan_tp WHERE pengadaan_tp.tahun_pengadaan_tp = '$tahun_tp'");
	// $data_pengadaan_tp = $pengadaan_tp->fetch_array();

	// $total_nominal = $con->query("SELECT SUM(nominal_perolehan_lain + nominal_kekayaan_desa) AS total_nominal FROM pengadaan_tp JOIN detail_pengadaan_tp ON pengadaan_tp.kode_pengadaan_tp = detail_pengadaan_tp.kode_pengadaan_tp WHERE pengadaan_tp.tahun_pengadaan_tp = '$tahun_tp'");
	// $total_nominal_tp = $total_nominal->fetch_array();

    // =====================================================

?>
	<div>
        <center><h3 style="margin-top: 3%;">DAFTAR PENGGUNAAN</h3></center>
		<center><h3>PEMERINTAH DESA SENDANGTIRTO-KEC.BERBAH-SLEMAN-DI YOGYAKARTA</h3></center>
		<center><h3 style="margin-bottom: 10%;">TAHUN <?= date('Y'); ?></h3></center>
	</div>

    <?php

	$xcoba = array();
	$xdcoba = array();

	$pcoba = $con->query("SELECT * FROM penggunaan JOIN detail_penggunaan ON penggunaan.kode_penggunaan = detail_penggunaan.kode_penggunaan");
	
	while($dcoba = $pcoba->fetch_assoc()){
		$xcoba[] = $dcoba['lokasi'];
	}

	$xdcoba = array_values(array_unique($xcoba));
	$jmlxd = count($xdcoba);
	// var_dump($xdcoba);

    ?>



    <?php

	for ($i=0; $i<$jmlxd; $i++) { 

        // $subnominal = $con->query("SELECT SUM(nominal_perolehan_lain + nominal_kekayaan_desa) AS jumlah_sub_nominal FROM pengadaan_tp JOIN detail_pengadaan_tp ON pengadaan_tp.kode_pengadaan_tp = detail_pengadaan_tp.kode_pengadaan_tp WHERE pengadaan_tp.tahun_pengadaan_tp = '$tahun_tp' AND pengadaan_tp.sumber_perolehan_tp = '$xdcoba[$i]'");
        // $subnominalx = $subnominal->fetch_array();

		$lokasi_penggunaan = $con->query("SELECT*FROM penggunaan JOIN detail_penggunaan ON penggunaan.kode_penggunaan = detail_penggunaan.kode_penggunaan WHERE penggunaan.lokasi = '$xdcoba[$i]'");
		$lokasix = $lokasi_penggunaan->fetch_array();
	
    ?>

<table class="table table-bordered" cellspacing="0" width="100%">
<div style="page-break-inside: avoid;">

    <thead>
        <tr>
            <th colspan="8">Lokasi : <?php echo $lokasix['lokasi'] ?></th>
        </tr>
		<tr>
			<th><center>No.</center></th>
			<th><center>Pengguna</center></th>
			<th><center>Nama Aset</center></th>
			<th><center>Jumlah</center></th>
			<th><center>Identitas</center></th>
			<th><center>Keterangan</center></th>
		</tr>
	</thead>
	<tbody>
		<?php $nomor=1;?>

        <?php $ambil=$con->query("SELECT*FROM penggunaan JOIN detail_penggunaan ON penggunaan.kode_penggunaan = detail_penggunaan.kode_penggunaan JOIN inventaris ON inventaris.kode_inventaris = detail_penggunaan.kode_inventaris JOIN detail_pengadaan ON inventaris.kode_detail_pengadaan = detail_pengadaan.kode_detail_pengadaan JOIN detail_perencanaan ON detail_pengadaan.kode_detail_perencanaan = detail_perencanaan.kode_detail_perencanaan WHERE penggunaan.lokasi = '$lokasix[lokasi]'"); ?>
		<?php while($pecah=$ambil->fetch_assoc()){?>
		<tr>
			<td><center><?php echo $nomor;?></center></td>
			<td><center><?php echo $pecah['pengguna']?></center></td>
			<td><center><?php echo $pecah['aset_perencanaan']?></center></td>
			<td><center><?php echo $pecah['jumlah_pg']." ".$pecah['satuan']?></center></td>
			<td><center><?php echo $pecah['identitas_barang']?></center></td>
			<td><center><?php echo $pecah['keterangan_penggunaan']?></center></td>
		</tr>
		<?php $nomor++;?>
		<?php }?>

		<?php $ambil_tp=$con->query("SELECT*FROM penggunaan JOIN detail_penggunaan ON penggunaan.kode_penggunaan = detail_penggunaan.kode_penggunaan JOIN inventaris ON inventaris.kode_inventaris = detail_penggunaan.kode_inventaris JOIN detail_pengadaan_tp ON inventaris.kode_detail_pengadaan = detail_pengadaan_tp.kode_detail_pengadaan_tp WHERE penggunaan.lokasi = '$lokasix[lokasi]'"); ?>
		<?php while($pecah_tp=$ambil_tp->fetch_assoc()){?>
		<tr>
			<td><center><?php echo $nomor;?></center></td>
			<td><center><?php echo $pecah_tp['pengguna']?></center></td>
			<td><center><?php echo $pecah_tp['nama_barang_tp']?></center></td>
			<td><center><?php echo $pecah_tp['jumlah_pg']." ".$pecah_tp['satuan']?></center></td>
			<td><center><?php echo $pecah_tp['identitas_barang']?></center></td>
			<td><center><?php echo $pecah_tp['keterangan_penggunaan']?></center></td>
		</tr>
		<?php $nomor++;?>
		<?php }?>
        <!-- <tr>
            <td colspan="8"><b>Sub Total : Rp <?php //echo $subnominalx['jumlah_sub_nominal'] ?> ,-</b></td>
        </tr> -->
	</tbody>
</div>
	<?php } 
	// =====================================================
	?>

    </table>

	<!-- <table class="table table-bordered" cellspacing="0" width="100%">
		<td><h3><b>Total Nominal  : Rp <?php //echo $total_nominal_tp['total_nominal']?> ,-</b></h3></td>
	</table> -->
	<script>
		window.print();
	</script>

</body>
</html>
