<?php
	include_once('../koneksi.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Riwayat Pemanfaatan Aset Kalurahan Sendangtirto</title>
	<link rel="stylesheet" href="../style.css">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
	<style>
		/* table {page-break-inside: avoid;} */
		thead {display: table-row-group;}
		tr{page-break-inside: avoid;}
		h3{font-size: 110%};
		h4{font-size: 2cm};
	</style>
</head>
<body>

<?php

	$tahun_riwayat_pemanfaatan = $_POST['pilihan_tahun_riwayat_pemanfaaatan'];

    // =====================================================

?>
	<div>
        <center><h3 style="margin-top: 3%;">RIWAYAT PEMANFAATAN ASET DESA</h3></center>
		<center><h3>PEMERINTAH DESA SENDANGTIRTO-KEC.BERBAH-SLEMAN-DI YOGYAKARTA</h3></center>
		<center><h3 style="margin-bottom: 10%;">TAHUN <?php echo $tahun_riwayat_pemanfaatan ?></h3></center>
	</div>

<table class="table table-bordered" cellspacing="0" width="100%">
<div style="page-break-inside: avoid;">
    <thead>
		<tr>
			<th style="width:5%; vertical-align: middle;" rowspan="2"><center>No.</center></th>
			<th style="vertical-align: middle;" rowspan="2"><center>Jenis Barang<center></th>
			<th style="vertical-align: middle;" rowspan="2"><center>Aset</center></th>
			<th style="vertical-align: middle;" colspan="2"><center>Peraturan Desa</center></th>
            <th style="vertical-align: middle;" rowspan="2"><center>No Surat Perjanjian</center></th>
            <th style="vertical-align: middle;" rowspan="2"><center>Jumlah</center></th>
			<th style="vertical-align: middle;" rowspan="2"><center>Biaya</center></th>
			<th style="vertical-align: middle;" rowspan="2"><center>Bentuk Pemanfaatan</center></th>
		</tr>
		<tr>
			<th style="vertical-align: middle;" rowspan="2"><center>No Perdes</center></th>
			<th style="vertical-align: middle;" rowspan="2"><center>Tanggal</center></th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td></td>
			<td><center>1</center></td>
			<td><center>2</center></td>
			<td><center>3</center></td>
			<td><center>4</center></td>
			<td><center>5</center></td>
			<td><center>6</center></td>
			<td><center>7</center></td>
			<td><center>8</center></td>
		</tr>
		<?php $nomor=1;?>
        
        <!-- Menampilkan riwayat pemanfaatan -->
        <?php $ambil=$con->query("SELECT*FROM transaksi_pemanfaatan_selesai WHERE tahun_pemanfaatan = '$tahun_riwayat_pemanfaatan'"); ?>
		<?php while($pecah=$ambil->fetch_assoc()){?>
		<tr>
			<td><center><?php echo $nomor++;?></center></td>
			<td><center><?php echo $pecah['jenis_barang']?></center></td>
			<td><center><?php echo $pecah['kode_inventaris']." - ".$pecah['nama_aset']?></center></td>
			<td><center><?php echo $pecah['no_perdes']?></center></td>
			<td><center><?php echo date('d/m/Y', strtotime($pecah['tanggal_perdes']))?></center></td>
			<td><center><?php echo $pecah['no_surat_perjanjian']?></center></td>
			<td><center><?php echo $pecah['jumlah_p']?></center></td>
			<td><center><?php echo $pecah['biaya_kontribusi']?></center></td>
			<td><center><?php echo $pecah['bentuk_pemanfaatan']?></center></td>
		</tr>
		<?php }?>

	</tbody>
</div>
	
	<?php
		$jumlah_biaya_riwayat_pemanfaatan = $con->query("SELECT SUM(biaya_kontribusi) AS total_biaya FROM transaksi_pemanfaatan_selesai WHERE tahun_pemanfaatan = '$tahun_riwayat_pemanfaatan'");
		$total_biaya_riwayat = mysqli_fetch_assoc($jumlah_biaya_riwayat_pemanfaatan);
	?>

	<tr>
		<td align="right" colspan="5"><h3><b>Jumlah Total</b></h3></td>
		<td align="right" colspan="3"><h3><b><?= $total_biaya_riwayat['total_biaya']?></b></h3></td>
		<td></td>
	</tr>

</table>

<?php
$cek_kepala_desa = $con->query("SELECT nama_pengurus FROM pengurus WHERE nomor_pengurus = '01'");
$data_kepala_desa = mysqli_fetch_assoc($cek_kepala_desa);
?>

<?php
$cek_sekretaris = $con->query("SELECT nama_pengurus FROM pengurus WHERE nomor_pengurus = '02'");
$data_sekretaris = mysqli_fetch_assoc($cek_sekretaris);
?>

<?php
$cek_kaur = $con->query("SELECT nama_pengurus FROM pengurus WHERE nomor_pengurus = '03'");
$data_kaur = mysqli_fetch_assoc($cek_kaur);
?>

<div class="container" style="width: 30%; margin-left: 0%">
	<table style="width: 100%">
		<tr>
			<td><center><h7>MENGETAHUI : </h7></center></td>
		</tr>
		<tr>
			<td><center><h7>KEPALA DESA</h7></center></td>
		</tr>
		<tr>
			<td><center><h7>Pemegang Kekuasaan Pengelolaan Aset Desa</h7></center></td>
		</tr>
	</table>

	<br>
	<br>
	<br>
	<br>
	<?php 

	if(!$data_kepala_desa){ ?>
		<h7><center><?= "Data Kepala Desa belum ada !"?></center></h7>
	<?php } else { ?>
		<h7><center><?= $data_kepala_desa['nama_pengurus']?></center></h7>
	<?php } ?>

</div>

<div class="container" style="width: 30%; position: relative; float: right; margin-left: 0%">
	<table style="width: 100%">
		<tr>
			<td><center><h7>Desa SENDANGTIRTO, Tanggal.........................</h7></center></td>
		</tr>
		<tr>
			<td><center><h7>KEPALA URUSAN TATA USAHA UMUM</h7></center></td>
		</tr>
		<tr>
			<td><center><h7>Petugas/Pengurus Barang Milik Desa</h7></center></td>
		</tr>
	</table>

	<br>
	<br>
	<br>
	<br>
	<?php 

	if(!$data_kaur){ ?>
		<h7><center><?= "Data KAUR Umum belum ada !"?></center></h7>
	<?php } else { ?>
		<h7><center><?= $data_kaur['nama_pengurus']?></center></h7>
	<?php } ?>

</div>

<div class="container" style="width: 30%; position: relative; float: right; margin-left: 0%">
	<table style="width: 100%">
		<tr>
			<td><center><h7>DIVERIVIKASI OLEH :</h7></center></td>
		</tr>
		<tr>
			<td><center><h7>SEKRETARIS DESA</h7></center></td>
		</tr>
		<tr>
			<td><center><h7>Selaku Pembantu Pengelola Aset Desa</h7></center></td>
		</tr>
	</table>

	<br>
	<br>
	<br>
	<br>
	<?php 

	if(!$data_sekretaris){ ?>
		<h7><center><?= "Data Sekretaris belum ada !"?></center></h7>
	<?php } else { ?>
		<h7><center><?= $data_sekretaris['nama_pengurus']?></center></h7>
	<?php } ?>

</div>

	<script>
		window.print();
	</script>

</body>
</html>
