<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Detail Pengadaan</title>
	<script src="https://code.jquery.com/jquery-3.7.0.min.js" integrity="sha256-2Pmvv0kuTBOenSvLm6bvfBSSHrUJ+3A7x6P5Ebd07/g=" crossorigin="anonymous"></script>
</head>
<body>
	
<div class="lingkaran">
    <center><h3 class="judul">Tambah Detail Pengadaan</h3></center>
</div>
<div class="container">

<?php

	$kode_pengadaan = $_GET['kode_pengadaan'];
	$pengadaan = $con->query("SELECT*FROM pengadaan JOIN perencanaan ON pengadaan.kode_perencanaan = perencanaan.kode_perencanaan WHERE kode_pengadaan = '$kode_pengadaan'");
	$data_pengadaan = $pengadaan->fetch_array();

?>

	<table class="table">
        <tr>
			<td><h4 class="rincian">Kode Pengadaan : <?php echo $kode_pengadaan?></h4></td>
		</tr>
		<tr>
			<td><h4 class="rincian">No RPJM : <?php echo $data_pengadaan['no_rpjm']?></h4></td>
		</tr>
        <tr>
            <td><h4 class="rincian">No RKP : <?php echo $data_pengadaan['no_rkp']?></h4></td>
		</tr>
        <tr>
            <td><h4 class="rincian">Periode RPJM : <?php echo $data_pengadaan['periode_rpjm']?></h4></td>
        </tr>
        <tr>
			<td><h4 class="rincian">Tahun RKP  : <?php echo $data_pengadaan['tahun_rkp']?></h4></td>
		</tr>
	</table>

</div>

<div class="container" style="width:40%; margin-top: 0%; margin-bottom: 12%;">
	<form method="POST" action="detail/proses_detail/proses_detail_pengadaan.php">
      	<div class="modal-body">
		  	<input type="hidden" name="dpdkode_pengadaan" value="<?=$kode_pengadaan?>">
			<div class="mb-3">
    			<label class="form-label"><b class="bold">Kode Barang</b></label>
    			<select class="form-select" id="dpdkode_barang" name="dpdkode_barang" onchange="detail()" placeholder="Pilih Kode Barang">
					<option value="">- Pilih Barang -</option>
					<?php
						$ambil = $con->query("SELECT detail_perencanaan.kode_detail_perencanaan, detail_perencanaan.jenis_kegiatan_rencana, detail_perencanaan.aset_perencanaan FROM detail_perencanaan WHERE detail_perencanaan.kode_perencanaan = '$data_pengadaan[kode_perencanaan]' AND detail_perencanaan.kode_detail_perencanaan NOT IN (SELECT detail_pengadaan.kode_detail_perencanaan FROM detail_pengadaan)");
						while($datadetail=$ambil->fetch_assoc()){
					?>
					<option value="<?= $datadetail['kode_detail_perencanaan']?>"><?=  $datadetail['kode_detail_perencanaan']." - ".$datadetail['jenis_kegiatan_rencana']." - ".$datadetail['aset_perencanaan'] ?></option>
					<?php }	?>
				</select>
  			</div>
			<div class="mb-3">
    			<label class="form-label"><b class="bold">APBDesa</b></label>
    			<input type="number" class="form-control" value="0" name="dpdapbdesa" required>
  			</div>
			<div class="mb-3">
    			<label class="form-label"><b class="bold">Perolehan Lain Yg Sah</b></label>
    			<input type="number" class="form-control" value="0" name="dpdperolehanlain" required>
  			</div>
			<div class="mb-3">
    			<label class="form-label"><b class="bold">Aset Kekayaan Asli Desa</b></label>
    			<input type="number" class="form-control" value="0" name="dpdkekayaandesa" required>
  			</div>
			<div class="mb-3">
    			<label class="form-label"><b class="bold">Tanggal Perolehan<b></label>
    			<input type="date" class="form-control" name="dpdtgl_perolehan" required>
  			</div>
			<div class="mb-3">
    			<label class="form-label"><b class="bold">Penanggung Jawab</b></label>
    			<select class="form-select" id="dpdpengurus" name="dpdpengurus">
					<option value="">- Pilih Pengurus -</option>
					<?php
						$pilih_pengurus = $con->query("SELECT pengurus.nomor_pengurus, pengurus.nama_pengurus FROM pengurus");
						while($pilihan=$pilih_pengurus->fetch_assoc()){
					?>
					<option value="<?= $pilihan['nomor_pengurus']?>"><?=  $pilihan['nomor_pengurus']." - ".$pilihan['nama_pengurus']?></option>
					<?php }	?>
				</select>
  			</div>
		</div>
      	<div>
		  	<button type="submit" class="btn btn-primary" name="bSimpan">Simpan</button>            
      	</div>
	</form>
</div>

<div class="container" style="width:35%; margin-top: 0%; margin-left:2%; margin-bottom:2%; position:absolute">
      	<div class="modal-body">
			<div class="mb-3">
    			<label class="form-label"><b class="bold">Jenis Kegiatan</b></label>
    			<input type="text" class="form-control" name="dpdjeniskegiatan" id="dpdjeniskegiatan" style="background: #efefef; pointer-events: none;">
  			</div>
			<div class="mb-3">
    			<label class="form-label"><b class="bold">Bidang</b></label>
    			<input type="text" class="form-control" name="dpdbidang" id="dpdbidang" style="background: #efefef; pointer-events: none;">
  			</div>
			<div class="mb-3">
    			<label class="form-label"><b class="bold">Nama Barang</b></label>
    			<input type="text" class="form-control" name="dpdnama" id="dpdnama" style="background: #efefef; pointer-events: none;">
  			</div>
			<div class="mb-3">
    			<label class="form-label"><b class="bold">Jumlah</b></label>
    			<input type="number" class="form-control" name="dpdjumlah" id="dpdjumlah" style="background: #efefef; pointer-events: none;">
  			</div>
			<div class="mb-3">
    			<label class="form-label"><b class="bold">Lokasi</b></label>
    			<input type="text" class="form-control" name="dpdlokasi" id="dpdlokasi" style="background: #efefef; pointer-events: none;">
  			</div>
			<div class="mb-3">
				<label class="form-label"><b class="bold">Keterangan</b></label>
				<textarea class="form-control" id="dpdketerangan" name="dpdketerangan" rows="4" cols="50" style="background: #efefef; pointer-events: none;">
					
				</textarea>
    			<!-- <input type="text" class="form-control" name="dpdketerangan" id="dpdketerangan" style="background: #efefef; pointer-events: none;"> -->
  			</div>
			<div class="mb-3">
    			<label class="form-label"><b class="bold">Perkiraan Biaya</b></label>
    			<input type="number" class="form-control" name="dprbiaya" id="dprbiaya" style="background: #efefef; pointer-events: none;">
  			</div>
		</div>
</div>

</body>

<script>

	function detail(){
		// alert("ok");
		var kode = $("#dpdkode_barang").val();

		if(kode.length == "") {
			$('#dpdjeniskegiatan').val("");
			$('#dpdbidang').val("");
			$('#dpdnama').val("");
			$('#dpdjumlah').val("");
			$('#dpdlokasi').val("");
			$('#dpdketerangan').val("");
			$('#dprbiaya').val("");
		} else {
		$.ajax({
			url :"detail/data_detail_pengadaan.php",
			method :"POST",
			data : {'kode':kode},
			dataType : "json",
			success:function(data){
				$('#dpdjeniskegiatan').val(data.jenis_kegiatan_rencana);
				$('#dpdbidang').val(data.bidang_perencanaan);
				$('#dpdnama').val(data.aset_perencanaan);
				$('#dpdjumlah').val(data.perkiraan_volume);
				$('#dpdlokasi').val(data.rencana_lokasi);
				$('#dpdketerangan').val(data.keterangan);
				$('#dprbiaya').val(data.perkiraan_biaya);
			}
		})
	}
	}

</script>

</html>