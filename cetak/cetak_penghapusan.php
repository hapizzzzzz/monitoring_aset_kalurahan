<?php
	include_once('../koneksi.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Pemanfaatan Aset Kalurahan Sendangtirto</title>
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

	$tahun_berita_acara = $_POST['pilihan_tahun_berita_acara'];

?>
	<div>
        <center><h3 style="margin-top: 3%;">DAFTAR PENGHAPUSAN ASET DESA</h3></center>
		<center><h3>PEMERINTAH DESA SENDANGTIRTO-KEC.BERBAH-SLEMAN-DI YOGYAKARTA</h3></center>
		<center><h3 style="margin-bottom: 10%;">TAHUN <?php echo $tahun_berita_acara ?></h3></center>
	</div>

<table class="table table-bordered" cellspacing="0" width="100%">
<div style="page-break-inside: avoid;">
    <thead>
		<tr>
			<th style="width:5%; vertical-align: middle;" rowspan="2"><center>No.</center></th>
			<th style="vertical-align: middle;" rowspan="2"><center>Jenis Barang<center></th>
			<th style="vertical-align: middle;" rowspan="2"><center>Nama Barang<center></th>
			<th style="vertical-align: middle;" rowspan="2"><center>Jumlah</center></th>
			<th style="vertical-align: middle;" colspan="3"><center>Asal Usul Barang</center></th>
            <th style="vertical-align: middle;" rowspan="2"><center>Tahun Pengadaan / Perolehan</center></th>
            <th style="vertical-align: middle;" rowspan="2"><center>No BA</center></th>
			<th style="vertical-align: middle;" rowspan="2"><center>Tahun BA</center></th>
			<th style="vertical-align: middle;" rowspan="2"><center>Keterangan Penyebab</center></th>
		</tr>
		<tr>
			<th style="vertical-align: middle;" rowspan="2"><center>Kekayaan Asli Desa</center></th>
			<th style="vertical-align: middle;" rowspan="2"><center>APBDesa</center></th>
			<th style="vertical-align: middle;" rowspan="2"><center>Perolehan Lain Yg Sah</center></th>
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
			<td><center>9</center></td>
			<td><center>10</center></td>
		</tr>
		<?php $nomor=1;?>

        <?php $ambil=$con->query("SELECT*FROM detail_penghapusan JOIN penghapusan ON detail_penghapusan.kode_penghapusan = penghapusan.kode_penghapusan WHERE penghapusan.tahun_berita_acara = '$tahun_berita_acara'"); ?>
		<?php while($pecah=$ambil->fetch_assoc()){?>
		<tr>
			<td><center><?php echo $nomor++;?></center></td>
			<td><center><?php echo $pecah['jenis_barang']?></center></td>
			<td><center><?php echo $pecah['nama_barang']?></center></td>
			<td><center><?php echo $pecah['jumlah_penghapusan']." ".$pecah['satuan_barang']?></center></td>
			<td align="right"><?php echo $pecah['kekayaan_asli_desa']?></td>
			<td align="right"><?php echo $pecah['apbdesa']?></td>
			<td align="right"><?php echo $pecah['perolehan_lain']?></td>
			<td><center><?php echo $pecah['tahun_perolehan']?></center></td>
			<td><center><?php echo $pecah['no_berita_acara']?></center></td>
			<td><center><?php echo $pecah['tahun_berita_acara']?></center></td>
			<td><center><?php echo $pecah['penyebab_penghapusan']?></center></td>
		</tr>
		<?php }?>

	</tbody>
</div>

	<?php
		$jumlah_nominal_kekayaan_asli_desa = $con->query("SELECT SUM(kekayaan_asli_desa) AS kekayaan_asli_desa FROM detail_penghapusan JOIN penghapusan ON detail_penghapusan.kode_penghapusan = penghapusan.kode_penghapusan WHERE tahun_berita_acara = $tahun_berita_acara");
		$total_nominal_kekayaan_asli_desa = mysqli_fetch_assoc($jumlah_nominal_kekayaan_asli_desa);

		$jumlah_nominal_apbdesa = $con->query("SELECT SUM(apbdesa) AS apbdesa FROM detail_penghapusan JOIN penghapusan ON detail_penghapusan.kode_penghapusan = penghapusan.kode_penghapusan WHERE tahun_berita_acara = $tahun_berita_acara");
		$total_nominal_apbdesa = mysqli_fetch_assoc($jumlah_nominal_apbdesa);

		$jumlah_nominal_perolehan_lain = $con->query("SELECT SUM(perolehan_lain) AS perolehan_lain FROM detail_penghapusan JOIN penghapusan ON detail_penghapusan.kode_penghapusan = penghapusan.kode_penghapusan WHERE tahun_berita_acara = $tahun_berita_acara");
		$total_nominal_perolehan_lain = mysqli_fetch_assoc($jumlah_nominal_perolehan_lain);

		$total_keseluruhan_nominal = $total_nominal_kekayaan_asli_desa['kekayaan_asli_desa'] + $total_nominal_apbdesa['apbdesa'] + $total_nominal_perolehan_lain['perolehan_lain'];
	?>

	<tr>
		<td align="right" colspan="4"><h3><b>Jumlah Total</b></h3></td>
		<td align="right" colspan="1"><h3><b><?= $total_nominal_kekayaan_asli_desa['kekayaan_asli_desa']?></b></h3></td>
		<td align="right" colspan="1"><h3><b><?= $total_nominal_apbdesa['apbdesa']?></b></h3></td>
		<td align="right" colspan="1"><h3><b><?= $total_nominal_perolehan_lain['perolehan_lain']?></b></h3></td>
		<td colspan="4"></td>
	</tr>

	<tr>
		<td align="right" colspan="4"><h3><b>Total Keseluruhan</b></h3></td>
		<td align="right" colspan="3"><h3><b><?= $total_keseluruhan_nominal?></b></h3></td>
		<td colspan="4"></td>
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
