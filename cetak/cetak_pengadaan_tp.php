<?php
	include_once('../koneksi.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Perolehan Aset Kalurahan Sendangtirto</title>
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

	$tahun_tp = $_POST['pilihan_tahun_tp'];
	$pengadaan_tp = $con->query("SELECT * FROM pengadaan_tp JOIN detail_pengadaan_tp ON pengadaan_tp.kode_pengadaan_tp = detail_pengadaan_tp.kode_pengadaan_tp WHERE pengadaan_tp.tahun_pengadaan_tp = '$tahun_tp'");
	$data_pengadaan_tp = $pengadaan_tp->fetch_array();

	$total_nominal = $con->query("SELECT SUM(nominal_perolehan_lain + nominal_kekayaan_desa) AS total_nominal FROM pengadaan_tp JOIN detail_pengadaan_tp ON pengadaan_tp.kode_pengadaan_tp = detail_pengadaan_tp.kode_pengadaan_tp WHERE pengadaan_tp.tahun_pengadaan_tp = '$tahun_tp'");
	$total_nominal_tp = $total_nominal->fetch_array();

    // =====================================================

?>
	<div>
        <center><h3 style="margin-top: 3%;">DAFTAR PEROLEHAN ASET DESA</h3></center>
		<center><h3>PEMERINTAH DESA SENDANGTIRTO-KEC.BERBAH-SLEMAN-DI YOGYAKARTA</h3></center>
		<center><h3 style="margin-bottom: 10%;">TAHUN <?php echo $tahun_tp ?></h3></center>
	</div>

    <?php

	$xcoba = array();
	$xdcoba = array();

	$pcoba = $con->query("SELECT * FROM pengadaan_tp WHERE tahun_pengadaan_tp = '$tahun_tp'");
	while($dcoba = $pcoba->fetch_assoc()){
		$xcoba[] = $dcoba['sumber_perolehan_tp'];
	}

	$xdcoba = array_values(array_unique($xcoba));
	$jmlxd = count($xdcoba);
	// var_dump($xdcoba);

    ?>



    <?php

	for ($i=0; $i<$jmlxd; $i++) { 

        $subnominal = $con->query("SELECT SUM(nominal_perolehan_lain + nominal_kekayaan_desa) AS jumlah_sub_nominal FROM pengadaan_tp JOIN detail_pengadaan_tp ON pengadaan_tp.kode_pengadaan_tp = detail_pengadaan_tp.kode_pengadaan_tp WHERE pengadaan_tp.tahun_pengadaan_tp = '$tahun_tp' AND pengadaan_tp.sumber_perolehan_tp = '$xdcoba[$i]'");
        $subnominalx = $subnominal->fetch_array();

		$subperolehan = $con->query("SELECT*FROM pengadaan_tp WHERE tahun_pengadaan_tp = '$tahun_tp' AND sumber_perolehan_tp = '$xdcoba[$i]'");
		$subperolehanx = $subperolehan->fetch_array();
	
    ?>

<table class="table table-bordered" cellspacing="0" width="100%">
<div style="page-break-inside: avoid;">

    <thead>
        <tr>
            <th colspan="8">Sumber Perolehan : <?php echo $subperolehanx['sumber_perolehan_tp'] ?></th>
        </tr>
		<tr>
			<th><center>No.</center></th>
			<th><center>Kode</center></th>
			<th><center>Nama Barang</center></th>
			<th><center>Jumlah</center></th>
			<th><center>Perolehan Lain Yg Sah (Rp)</center></th>
			<th><center>Kekayaan Asli Desa (Rp)</center></th>
		</tr>
	</thead>
	<tbody>
		<?php $nomor=1;?>

        <!-- Mencari kode pengadaan tp -->
        <?php $sumber_perolehan_tp = $subperolehanx['sumber_perolehan_tp']?>
        <?php $kode_tp = $con->query("SELECT kode_pengadaan_tp FROM pengadaan_tp WHERE sumber_perolehan_tp = '$sumber_perolehan_tp' AND tahun_pengadaan_tp = '$tahun_tp'");?>
        <?php $data_kode_tp = $kode_tp->fetch_assoc()?>
        <?php $kode_pengadaan_tp = $data_kode_tp['kode_pengadaan_tp']?>
        
        <!-- Menampilkan data detail -->
        <?php $ambil=$con->query("SELECT*FROM detail_pengadaan_tp WHERE kode_pengadaan_tp = '$kode_pengadaan_tp'"); ?>
		<?php while($pecah=$ambil->fetch_assoc()){?>
		<tr>
			<td><center><?php echo $nomor;?></center></td>
			<td><center><?php echo $pecah['kode_jenis']?></center></td>
			<td><center><?php echo $pecah['nama_barang_tp']?></center></td>
			<td><center><?php echo $pecah['volume_tp']." ".$pecah['satuan_tp']?></center></td>
			<td><center><?php echo $pecah['nominal_perolehan_lain']?></center></td>
			<td><center><?php echo $pecah['nominal_kekayaan_desa']?></center></td>
		</tr>
		<?php $nomor++;?>
		<?php }?>
        <tr>
            <td colspan="8"><b>Sub Total : Rp <?php echo $subnominalx['jumlah_sub_nominal'] ?> ,-</b></td>
        </tr>
	</tbody>
</div>
	<?php } 
	// =====================================================
	?>

    </table>

	<table class="table table-bordered" cellspacing="0" width="100%">
		<td><h3><b>Total Nominal  : Rp <?php echo $total_nominal_tp['total_nominal']?> ,-</b></h3></td>
	</table>
	<script>
		window.print();
	</script>

</body>
</html>
