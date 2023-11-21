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

	$tahun_pemanfaatan = $_POST['pilihan_tahun_pemanfaaatan'];
	// $pemanfaatan = $con->query("SELECT * FROM pemanfaatan JOIN detail_pemanfaatan ON pemanfaatan.kode_pemanfaatan = detail_pemanfaatan.kode_pemanfaatan WHERE pemanfaatan.tahun_pemanfaatan = '$tahun_pemanfaatan'");
	// $data_pemanfaatan = $pemanfaatan->fetch_array();

	// $total_nominal = $con->query("SELECT SUM(nominal_perolehan_lain + nominal_kekayaan_desa) AS total_nominal FROM pengadaan_tp JOIN detail_pengadaan_tp ON pengadaan_tp.kode_pengadaan_tp = detail_pengadaan_tp.kode_pengadaan_tp WHERE pengadaan_tp.tahun_pengadaan_tp = '$tahun_tp'");
	// $total_nominal_tp = $total_nominal->fetch_array();

    // =====================================================

?>
	<div>
        <center><h3 style="margin-top: 3%;">DAFTAR PEMANFAATAN ASET DESA</h3></center>
		<center><h3>PEMERINTAH DESA SENDANGTIRTO-KEC.BERBAH-SLEMAN-DI YOGYAKARTA</h3></center>
		<center><h3 style="margin-bottom: 10%;">TAHUN <?php echo $tahun_pemanfaatan ?></h3></center>
	</div>

    <?php

	// $xcoba = array();
	// $xdcoba = array();

	// $pcoba = $con->query("SELECT * FROM pemanfaatan WHERE tahun_pemanfaatan = '$tahun_pemanfaatan'");
	// while($dcoba = $pcoba->fetch_assoc()){
	// 	$xcoba[] = $dcoba['nama_partner'];
	// }

	// $xdcoba = array_values(array_unique($xcoba));
	// $jmlxd = count($xdcoba);
	// var_dump($xdcoba);

    ?>



    <?php

	// for ($i=0; $i<$jmlxd; $i++) { 

        // $subnominal = $con->query("SELECT SUM(nominal_perolehan_lain + nominal_kekayaan_desa) AS jumlah_sub_nominal FROM pengadaan_tp JOIN detail_pengadaan_tp ON pengadaan_tp.kode_pengadaan_tp = detail_pengadaan_tp.kode_pengadaan_tp WHERE pengadaan_tp.tahun_pengadaan_tp = '$tahun_tp' AND pengadaan_tp.sumber_perolehan_tp = '$xdcoba[$i]'");
        // $subnominalx = $subnominal->fetch_array();

		// $subpemanfaatan = $con->query("SELECT*FROM pemanfaatan WHERE tahun_pemanfaatan = '$tahun_pemanfaatan' AND nama_partner = '$xdcoba[$i]'");
		// $subpemanfaatanx = $subpemanfaatan->fetch_array();
	
    ?>

<!-- <table class="table table-bordered" cellspacing="0" width="100%">
	<tr>
        <th colspan="8">Kode Pemanfaatan : <?php //echo $subpemanfaatanx['kode_pemanfaatan'] ?></th>
		<th colspan="8">Nama Partner : <?php //echo $subpemanfaatanx['nama_partner'] ?></th>
	</tr>
	<tr>
		<th colspan="8">Tahun Perdes : <?php //echo $subpemanfaatanx['tahun_perdes'] ?></th>
		<th colspan="8">No Telp : <?php //echo $subpemanfaatanx['no_telp'] ?></th>
	</tr>
	<tr>
		<th colspan="8">Tanggal Perdes : <?php //echo $subpemanfaatanx['tanggal_terbit_perdes'] ?></th>
		<th colspan="8">Email : <?php //echo $subpemanfaatanx['email'] ?></th>
    </tr>
	<tr>
		<th colspan="8">No Perdes : <?php //echo $subpemanfaatanx['no_perdes'] ?></th>
		<th colspan="8">Alamat : <?php //echo $subpemanfaatanx['alamat'] ?></th>
    </tr>
</table> -->
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

        <?php //$kode_pemanfaatan = $subpemanfaatanx['kode_pemanfaatan']?>
        
        <!-- Menampilkan data detail ( dari perencanaan ) -->
        <?php $ambil=$con->query("SELECT*FROM detail_pemanfaatan JOIN pemanfaatan ON detail_pemanfaatan.kode_pemanfaatan = pemanfaatan.kode_pemanfaatan JOIN inventaris ON detail_pemanfaatan.kode_inventaris = inventaris.kode_inventaris JOIN detail_pengadaan ON inventaris.kode_detail_pengadaan = detail_pengadaan.kode_detail_pengadaan JOIN detail_perencanaan ON detail_perencanaan.kode_detail_perencanaan = detail_pengadaan.kode_detail_perencanaan JOIN jenis_barang ON detail_perencanaan.kode_jenis = jenis_barang.kode_jenis
			WHERE pemanfaatan.tahun_pemanfaatan = '$tahun_pemanfaatan'"); ?>
		<?php while($pecah=$ambil->fetch_assoc()){?>
		<tr>
			<td><center><?php echo $nomor++;?></center></td>
			<td><center><?php echo $pecah['nama_kelompok']?></center></td>
			<td><center><?php echo $pecah['kode_inventaris']." - ".$pecah['aset_perencanaan']?></center></td>
			<td><center><?php echo $pecah['no_perdes']?></center></td>
			<td><center><?php echo date('d/m/Y', strtotime($pecah['tanggal_terbit_perdes']))?></center></td>
			<td><center><?php echo $pecah['no_surat_perjanjian']?></center></td>
			<td><center><?php echo $pecah['jumlah_aset_p']?></center></td>
			<td><center><?php echo $pecah['biaya_kontribusi']?></center></td>
			<td><center><?php echo $pecah['bentuk_pemanfaatan']?></center></td>
		</tr>
		<?php }?>

		<!-- Menampilkan data detail ( dari partner ( tanpa perencanaan ) ) -->
        <?php $ambiltp=$con->query("SELECT*FROM detail_pemanfaatan JOIN pemanfaatan ON detail_pemanfaatan.kode_pemanfaatan = pemanfaatan.kode_pemanfaatan JOIN inventaris ON detail_pemanfaatan.kode_inventaris = inventaris.kode_inventaris JOIN detail_pengadaan_tp ON inventaris.kode_detail_pengadaan = detail_pengadaan_tp.kode_detail_pengadaan_tp JOIN jenis_barang ON detail_pengadaan_tp.kode_jenis = jenis_barang.kode_jenis
			WHERE pemanfaatan.tahun_pemanfaatan = '$tahun_pemanfaatan'"); ?>
		<?php while($pecahtp=$ambiltp->fetch_assoc()){?>
		<tr>
		<td><center><?php echo $nomor++;?></center></td>
			<td><center><?php echo $pecahtp['nama_kelompok']?></center></td>
			<td><center><?php echo $pecahtp['kode_inventaris']." - ".$pecahtp['nama_barang_tp']?></center></td>
			<td><center><?php echo $pecahtp['no_perdes']?></center></td>
			<td><center><?php echo date('d/m/Y', strtotime($pecahtp['tanggal_terbit_perdes']))?></center></td>
			<td><center><?php echo $pecahtp['no_surat_perjanjian']?></center></td>
			<td><center><?php echo $pecahtp['jumlah_aset_p']?></center></td>
			<td><center><?php echo $pecahtp['biaya_kontribusi']?></center></td>
			<td><center><?php echo $pecahtp['bentuk_pemanfaatan']?></center></td>
		</tr>
		<?php }?>

	</tbody>
</div>

	<?php
		$jumlah_biaya_pemanfaatan = $con->query("SELECT SUM(biaya_kontribusi) AS total_biaya FROM detail_pemanfaatan JOIN pemanfaatan ON detail_pemanfaatan.kode_pemanfaatan = pemanfaatan.kode_pemanfaatan WHERE tahun_pemanfaatan = $tahun_pemanfaatan");
		$total_biaya = mysqli_fetch_assoc($jumlah_biaya_pemanfaatan);
	?>

	<tr>
		<td align="right" colspan="5"><h3><b>Jumlah Total</b></h3></td>
		<td align="right" colspan="3"><h3><b><?= $total_biaya['total_biaya']?></b></h3></td>
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
