<?php
	include_once('../koneksi.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Perencanaan Aset Kalurahan Sendangtirto</title>
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

	$kode_perencanaan = $_GET['kode_perencanaan'];
	$perencanaan = $con->query("SELECT*FROM perencanaan where kode_perencanaan = '$kode_perencanaan'");
	$data_perencanaan = $perencanaan->fetch_array();

	$sub_total = $con->query("SELECT SUM(perkiraan_biaya) AS total_perkiraan_b FROM detail_perencanaan where kode_perencanaan = '$kode_perencanaan'");
	$sub_total_p = $sub_total->fetch_array();

    // =====================================================

?>
	<div>
        <center><h3 style="margin-top: 3%;">DAFTAR PERANCANAAN ASET DESA</h3></center>
		<center><h3>PEMERINTAH DESA SENDANGTIRTO-KEC.BERBAH-SLEMAN-DI YOGYAKARTA</h3></center>
		<center><h3 style="margin-bottom: 10%;">TAHUN <?php echo $data_perencanaan['tahun_rkp'] ?></h3></center>
	</div>
<div>

    <table style="width: 100%">
		<tr>
			<td><h3>No RPJM : <?php echo $data_perencanaan['no_rpjm']?></h3></td>
			<td><h3>Taggal RPJM  : <?php echo date('d/m/Y', strtotime($data_perencanaan['tanggal_rpjm']))?></h3></td>
			<td><h3>Periode RPJM : <?php echo $data_perencanaan['periode_rpjm']?></h3></td>
		</tr>
		<tr>
			<td><h3>No RKP : <?php echo $data_perencanaan['no_rkp']?></h4></td>
			<td><h3>Tanggal RKP  : <?php echo date('d/m/Y', strtotime($data_perencanaan['tanggal_rkp']))?></h3></td>
			<td><h3>Tahun RKP  : <?php echo $data_perencanaan['tahun_rkp']?></h3></td>
		</tr>
		<tr>
			<td><h3><b>Kode Lokasi Desa : 34.04.08.2001</b></h3></td>
		</tr>
	</table>

    <?php

	$xcoba = array();
	$xdcoba = array();

	$pcoba = $con->query("SELECT * FROM detail_perencanaan WHERE kode_perencanaan = '$kode_perencanaan'");
	while($dcoba = $pcoba->fetch_assoc()){
		$xcoba[] = $dcoba['bidang_perencanaan'];
	}

	$xdcoba = array_values(array_unique($xcoba));
	$jmlxd = count($xdcoba);
	// var_dump($xdcoba);

    ?>

    <?php

	for ($i=0; $i<$jmlxd; $i++) { 

        $subbidang = $con->query("SELECT SUM(perkiraan_biaya) AS subbidang FROM detail_perencanaan where kode_perencanaan = '$kode_perencanaan' AND bidang_perencanaan = '$xdcoba[$i]'");
        $subbidangx = $subbidang->fetch_array();

		$bidangc = $con->query("SELECT*FROM detail_perencanaan where kode_perencanaan = '$kode_perencanaan' AND bidang_perencanaan = '$xdcoba[$i]'");
		$bidangx = $bidangc->fetch_array();
	
    ?>
	<table class="table table-bordered" cellspacing="0" width="100%">
	<div style="page-break-inside: avoid;">
    <thead>
        <tr>
            <th colspan="8">Bidang : <?php echo $bidangx['bidang_perencanaan'] ?></th>
        </tr>
		<tr>
			<th style="width:5%"><center>No.</center></th>
			<th><center>Kode</center></th>
			<th><center>Nama Barang</center></th>
			<th><center>Jenis Kegiatan</center></th>
			<th><center>Lokasi</center></th>
			<th><center>Perkiraan Volume</center></th>
			<th><center>Sumber Biaya</center></th>
			<th><center>Perkiraan Biaya (Rp)</center></th>
		</tr>
	</thead>
	<tbody>
		<?php $nomor=1;?>
		<?php $ambil=$con->query("SELECT*FROM detail_perencanaan where kode_perencanaan = '$kode_perencanaan' and bidang_perencanaan = '$xdcoba[$i]'"); ?>
		<?php while($pecah=$ambil->fetch_assoc()){?>
		<tr>
			<td><center><?php echo $nomor;?></center></td>
			<td><center><?php echo $pecah['kode_detail_perencanaan']?></center></td>
			<td><center><?php echo $pecah['aset_perencanaan']?></center></td>
			<td><center><?php echo $pecah['jenis_kegiatan_rencana']?></center></td>
			<td><center><?php echo $pecah['rencana_lokasi']?></center></td>
			<td><center><?php echo $pecah['perkiraan_volume']." ".$pecah['rencana_satuan_volume']?></center></td>
			<td><center><?php echo $pecah['rencana_sumber_biaya']?></center></td>
			<td><center><?php echo $pecah['perkiraan_biaya']?></center></td>
		</tr>
		<?php $nomor++;?>
		<?php }?>
        <tr>
            <td colspan="8"><b>Sub Total Perkiraan Biaya : Rp <?php echo $subbidangx['subbidang'] ?> ,-</b></td>
        </tr>
	</tbody>
	</div>
	<?php } 
	// =====================================================
	?>
    
    </table>

	<table class="table table-bordered" cellspacing="0" width="100%">
		<td><h3><b>Total Perkiraan Biaya  : Rp <?php echo $sub_total_p['total_perkiraan_b']?> ,-</b></h3></td>
	</table>

	<script>
		window.print();
	</script>
</body>
</html>
