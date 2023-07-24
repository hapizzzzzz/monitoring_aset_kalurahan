<?php
	include_once('../koneksi.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Inventaris Aset Desa</title>
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

	<div>
        <center><h3 style="margin-top: 3%;">DAFTAR INVENTARIS ASET DESA</h3></center>
		<center><h3>PEMERINTAH DESA SENDANGTIRTO-KEC.BERBAH-SLEMAN-DI YOGYAKARTA</h3></center>
		<center><h3 style="margin-bottom: 10%;">TAHUN <?= date('Y');?></h3></center>
	</div>

    
<table class="table table-bordered" cellspacing="0" width="100%">
<div style="page-break-inside: avoid;">

    <thead>
		<tr>
			<th style="width:5%; vertical-align: middle;" rowspan="2"><center>No.</center></th>
			<th style="vertical-align: middle;" rowspan="2"><center>Jenis Barang<center></th>
			<th style="vertical-align: middle;" rowspan="2"><center>Kode</center></th>
			<th style="vertical-align: middle;" rowspan="2"><center>Identitas Barang</center></th>
			<th style="vertical-align: middle;" rowspan="2"><center>Jml Barang</center></th>
			<th style="vertical-align: middle;" colspan="3"><center>Asal Usul Barang</center></th>
            <th style="vertical-align: middle;" rowspan="2"><center>Tgl Perolehan/Pembelian</center></th>
            <th style="vertical-align: middle;" rowspan="2"><center>Keterangan</center></th>
		</tr>
		<tr>
			<th style="vertical-align: middle;" rowspan="2"><center>APBDesa</center></th>
			<th style="vertical-align: middle;" rowspan="2"><center>Perolehan Lain Yg Sah</center></th>
			<th style="vertical-align: middle;" rowspan="2"><center>Aset/Kekayaan Asli Desa</center></th>
		</tr>
	</thead>
	<tbody>
		<tr>
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
		<?php $ambil=$con->query("SELECT*FROM inventaris JOIN detail_pengadaan ON detail_pengadaan.kode_detail_pengadaan = inventaris.kode_detail_pengadaan JOIN detail_perencanaan ON detail_perencanaan.kode_detail_perencanaan = detail_pengadaan.kode_detail_perencanaan JOIN jenis_barang ON detail_perencanaan.kode_jenis = jenis_barang.kode_jenis"); ?>
	    <?php while($pecah=$ambil->fetch_assoc()){?>
        <?php $tgl_perolehan = $pecah['tgl_perolehan']?>
        <tr>
			<td><center><?php echo $nomor;?></center></td>
			<td><center><?php echo $pecah['nama_kelompok']?></center></td>
			<td><center><?php echo $pecah['kode_jenis']?></center></td>
			<td><center><?php echo $pecah['identitas_barang']?></center></td>
			<td><center><?php echo $pecah['jumlah']?></center></td>
			<td><center><?php echo $pecah['apbdesa']?></center></td>
			<td><center><?php echo $pecah['perolehan_lain']?></center></td>
			<td><center><?php echo $pecah['kekayaan_asli_desa']?></center></td>
            <td><center><?php echo date('d/m/Y', strtotime($tgl_perolehan))?></center></td>
            <td><center><?php echo $pecah['keterangan_aset']?></center></td>
		</tr>
		<?php $nomor++;?>
		<?php }?>

		<?php $ambil_tp=$con->query("SELECT*FROM inventaris JOIN detail_pengadaan_tp ON detail_pengadaan_tp.kode_detail_pengadaan_tp = inventaris.kode_detail_pengadaan JOIN jenis_barang ON detail_pengadaan_tp.kode_jenis = jenis_barang.kode_jenis");?>
	    <?php while($pecah_tp=$ambil_tp->fetch_assoc()){?>
        <?php $tgl_perolehan_tp = $pecah_tp['tanggal_perolehan_tp']?>
        <tr>
			<td><center><?php echo $nomor++;?></center></td>
			<td><center><?php echo $pecah_tp['nama_barang_tp']?></center></td>
			<td><center><?php echo $pecah_tp['kode_jenis']?></center></td>
			<td><center><?php echo $pecah_tp['identitas_barang']?></center></td>
			<td><center><?php echo $pecah_tp['jumlah']?></center></td>
			<td><center><?php echo "0"?></center></td>
			<td><center><?php echo $pecah_tp['nominal_perolehan_lain']?></center></td>
			<td><center><?php echo $pecah_tp['nominal_kekayaan_desa']?></center></td>
            <td><center><?php echo date('d/m/Y', strtotime($tgl_perolehan_tp))?></center></td>
            <td><center><?php echo $pecah_tp['keterangan_aset']?></center></td>
		</tr>
		<?php }?>
	</tbody>
</div>
<?php

//Sub APBDesa

$in_apbdesa = $con->query("SELECT SUM(apbdesa) AS in_apbdesa FROM inventaris JOIN detail_pengadaan ON detail_pengadaan.kode_detail_pengadaan = inventaris.kode_detail_pengadaan JOIN detail_perencanaan ON detail_perencanaan.kode_detail_perencanaan = detail_pengadaan.kode_detail_perencanaan");
$jum_in_apbdesa = mysqli_fetch_assoc($in_apbdesa);

//Sub Perolehan Lain Yg Sah

$in_perolehan_lain_pd = $con->query("SELECT SUM(perolehan_lain) AS in_perolehan_lain_pd FROM inventaris JOIN detail_pengadaan ON detail_pengadaan.kode_detail_pengadaan = inventaris.kode_detail_pengadaan JOIN detail_perencanaan ON detail_perencanaan.kode_detail_perencanaan = detail_pengadaan.kode_detail_perencanaan");
$jum_in_perolehan_lain_pd = mysqli_fetch_assoc($in_perolehan_lain_pd);

$in_perolehan_lain_tp = $con->query("SELECT SUM(nominal_perolehan_lain) AS in_perolehan_lain_tp FROM inventaris JOIN detail_pengadaan_tp ON detail_pengadaan_tp.kode_detail_pengadaan_tp = inventaris.kode_detail_pengadaan");
$jum_in_perolehan_lain_tp = mysqli_fetch_assoc($in_perolehan_lain_tp);

$jum_in_perolehan_lain_pd_tp = $jum_in_perolehan_lain_pd['in_perolehan_lain_pd'] + $jum_in_perolehan_lain_tp['in_perolehan_lain_tp'];

//Sub Kekayaan Asli Desa

$in_kekayaan_desa_pd = $con->query("SELECT SUM(kekayaan_asli_desa) AS in_kekayaan_desa_pd FROM inventaris JOIN detail_pengadaan ON detail_pengadaan.kode_detail_pengadaan = inventaris.kode_detail_pengadaan JOIN detail_perencanaan ON detail_perencanaan.kode_detail_perencanaan = detail_pengadaan.kode_detail_perencanaan");
$jum_in_kekayaan_desa_pd = mysqli_fetch_assoc($in_kekayaan_desa_pd);

$in_kekayaan_desa_tp = $con->query("SELECT SUM(nominal_kekayaan_desa) AS in_kekayaan_desa_tp FROM inventaris JOIN detail_pengadaan_tp ON detail_pengadaan_tp.kode_detail_pengadaan_tp = inventaris.kode_detail_pengadaan");
$jum_in_kekayaan_desa_tp = mysqli_fetch_assoc($in_kekayaan_desa_tp);

$jum_in_kekayaan_desa_pd_tp = $jum_in_kekayaan_desa_pd['in_kekayaan_desa_pd'] + $jum_in_kekayaan_desa_tp['in_kekayaan_desa_tp']; 

//Jumlah Total

$jumlah_total = $jum_in_apbdesa['in_apbdesa'] + $jum_in_perolehan_lain_pd_tp + $jum_in_kekayaan_desa_pd_tp;

?>
<tr>
	<td align="right" colspan="5"><h3><b>Sub Total</b></h3></td>
	<td align="right"><h3><b><?=$jum_in_apbdesa['in_apbdesa'];?></b></h3></td>
	<td align="right"><h3><b><?=$jum_in_perolehan_lain_pd_tp?></b></h3></td>
	<td align="right"><h3><b><?=$jum_in_kekayaan_desa_pd_tp?></b></h3></td>
</tr>
<tr>
	<td align="right" colspan="5"><h3><b>Jumlah Total</b></h3></td>
	<td align="right" colspan="3"><h3><b><?=$jumlah_total?></b></h3></td>
</tr>
</table>

<?php
$cek_sekretaris = $con->query("SELECT nama_pengurus FROM pengurus WHERE nomor_pengurus = '02'");
$data_sekretaris = mysqli_fetch_assoc($cek_sekretaris);
?>

<?php
$cek_kaur = $con->query("SELECT nama_pengurus FROM pengurus WHERE nomor_pengurus = '03'");
$data_kaur = mysqli_fetch_assoc($cek_kaur);
?>

<div class="container" style="width: 45%; margin-left: 0%">
<table style="width: 100%">
	<tr>
		<td><center><h7>MENGETAHUI : </h7></center></td>
	</tr>
	<tr>
		<td><center><h7>SEKRETARIS DESA</h7></center></td>
	</tr>
	<tr>
		<td><center><h7>Selaku Pembantu Pengelola Barang Milik Desa</h7></center></td>
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

<div class="container" style="width: 45%; position: relative; float: right; margin-left: 2%">
<table style="width: 100%">
	<tr>
		<td><center><h7>Desa SENDANGTIRTO, Tanggal.........................</h7></center></td>
	</tr>
	<tr>
		<td><center><h7>PETUGAS/PENGURUS</h7></center></td>
	</tr>
	<tr>
		<td><center><h7>BARANG MILIK DESA</h7></center></td>
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



	<script>
		window.print();
	</script>

</body>
</html>
