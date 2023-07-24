<?php
	include_once('../koneksi.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Pengadaan Aset Kalurahan Sendangtirto</title>
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

	$kode_pengadaan = $_GET['kode_pengadaan'];
	$pengadaan = $con->query("SELECT*FROM perencanaan JOIN pengadaan ON perencanaan.kode_perencanaan = pengadaan.kode_perencanaan where kode_pengadaan = '$kode_pengadaan'");
	$data_pengadaan = $pengadaan->fetch_array();

	$total_biaya = $con->query("SELECT SUM(apbdesa + perolehan_lain + kekayaan_asli_desa) AS total_biaya FROM detail_pengadaan where kode_pengadaan = '$kode_pengadaan'");
	$total_biayapd = $total_biaya->fetch_array();

    // =====================================================

?>
	<div>
        <center><h3 style="margin-top: 3%;">DAFTAR PENGADAAN ASET DESA</h3></center>
		<center><h3>PEMERINTAH DESA SENDANGTIRTO-KEC.BERBAH-SLEMAN-DI YOGYAKARTA</h3></center>
		<center><h3 style="margin-bottom: 10%;">TAHUN <?php echo $data_pengadaan['tahun_rkp'] ?></h3></center>
	</div>

    <table style="width: 100%">
		<tr>
			<td><h3>No RPJM : <?php echo $data_pengadaan['no_rpjm']?></h3></td>
			<td><h3>Periode RPJM : <?php echo $data_pengadaan['periode_rpjm']?></h4></td>
		</tr>
		<tr>
			<td><h3>No RKP : <?php echo $data_pengadaan['no_rkp']?></h4></td>
			<td><h3>Tanggal RKP  : <?php echo $data_pengadaan['tahun_rkp']?></h3></td>
		</tr>
		<tr>
			<td><h3><b>Kode Lokasi Desa : 34.04.08.2001</b></h3></td>
		</tr>
	</table>

    <?php

	$xcoba = array();
	$xdcoba = array();

	$pcoba = $con->query("SELECT * FROM detail_pengadaan JOIN detail_perencanaan ON detail_perencanaan.kode_detail_perencanaan = detail_pengadaan.kode_detail_perencanaan WHERE kode_pengadaan = '$kode_pengadaan'");
	while($dcoba = $pcoba->fetch_assoc()){
		$xcoba[] = $dcoba['bidang_perencanaan'];
	}

	$xdcoba = array_values(array_unique($xcoba));
	$jmlxd = count($xdcoba);
	// var_dump($xdcoba);

    ?>



    <?php

	for ($i=0; $i<$jmlxd; $i++) { 

        $subbidang = $con->query("SELECT SUM(apbdesa + perolehan_lain + kekayaan_asli_desa) AS subbidang FROM detail_perencanaan JOIN detail_pengadaan ON detail_perencanaan.kode_detail_perencanaan = detail_pengadaan.kode_detail_perencanaan where kode_pengadaan = '$kode_pengadaan' AND bidang_perencanaan = '$xdcoba[$i]'");
        $subbidangx = $subbidang->fetch_array();

		$bidangc = $con->query("SELECT*FROM detail_perencanaan JOIN detail_pengadaan ON detail_perencanaan.kode_detail_perencanaan = detail_pengadaan.kode_detail_perencanaan where detail_pengadaan.kode_pengadaan = '$kode_pengadaan' AND detail_perencanaan.bidang_perencanaan = '$xdcoba[$i]'");
		$bidangx = $bidangc->fetch_array();
	
    ?>

<table class="table table-bordered" cellspacing="0" width="100%">
<div style="page-break-inside: avoid;">

    <thead>
        <tr>
            <th colspan="8">Bidang : <?php echo $bidangx['bidang_perencanaan'] ?></th>
        </tr>
		<tr>
			<th style="width:5%; vertical-align: middle;" rowspan="2"><center>No.</center></th>
			<th style="vertical-align: middle;" rowspan="2"><center>Jenis Kegiatan<center></th>
			<th style="vertical-align: middle;" rowspan="2"><center>Kode</center></th>
			<th style="vertical-align: middle;" rowspan="2"><center>Nama Barang</center></th>
			<th style="vertical-align: middle;" rowspan="2"><center>Jumlah</center></th>
			<th style="vertical-align: middle;" colspan="3"><center>Asal Usul Barang</center></th>
		</tr>
		<tr>
			<th><center>APBDesa</center></th>
			<th><center>Perolehan Lain Yg Sah</center></th>
			<th><center>Aset/Kekayaan Asli Desa</center></th>
		</tr>
	</thead>
	<tbody>
		<?php $nomor=1;?>
		<?php $ambil=$con->query("SELECT*FROM detail_perencanaan JOIN detail_pengadaan ON detail_perencanaan.kode_detail_perencanaan = detail_pengadaan.kode_detail_perencanaan where detail_pengadaan.kode_pengadaan = '$kode_pengadaan' AND detail_perencanaan.bidang_perencanaan = '$xdcoba[$i]'"); ?>
		<?php while($pecah=$ambil->fetch_assoc()){?>
		<tr>
			<td><center><?php echo $nomor;?></center></td>
			<td><center><?php echo $pecah['jenis_kegiatan_rencana']?></center></td>
			<td><center><?php echo $pecah['kode_detail_pengadaan']?></center></td>
			<td><center><?php echo $pecah['aset_perencanaan']?></center></td>
			<td><center><?php echo $pecah['perkiraan_volume']." ".$pecah['rencana_satuan_volume']?></center></td>
			<td><center><?php echo $pecah['apbdesa']?></center></td>
			<td><center><?php echo $pecah['perolehan_lain']?></center></td>
			<td><center><?php echo $pecah['kekayaan_asli_desa']?></center></td>
		</tr>
		<?php $nomor++;?>
		<?php }?>
        <tr>
            <td colspan="8"><b>Sub Total : Rp <?php echo $subbidangx['subbidang'] ?> ,-</b></td>
        </tr>
	</tbody>
</div>
	<?php } 
	// =====================================================
	?>

    </table>

	<table class="table table-bordered" cellspacing="0" width="100%">
		<td><h3><b>Total Biaya  : Rp <?php echo $total_biayapd['total_biaya']?> ,-</b></h3></td>
	</table>
	<script>
		window.print();
	</script>

</body>
</html>
