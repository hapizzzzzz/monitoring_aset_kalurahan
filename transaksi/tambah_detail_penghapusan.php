<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Detail Penghapusan</title>
	<script src="https://code.jquery.com/jquery-3.7.0.min.js" integrity="sha256-2Pmvv0kuTBOenSvLm6bvfBSSHrUJ+3A7x6P5Ebd07/g=" crossorigin="anonymous"></script>
    <script
        src="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.8.7/chosen.jquery.js"
        integrity="sha512-eSeh0V+8U3qoxFnK3KgBsM69hrMOGMBy3CNxq/T4BArsSQJfKVsKb5joMqIPrNMjRQSTl4xG8oJRpgU2o9I7HQ=="
        crossorigin="anonymous"
        referrerpolicy="no-referrer"
    ></script>
    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.8.7/chosen.css"
        integrity="sha512-0nkKORjFgcyxv3HbE4rzFUlENUMNqic/EzDIeYCgsKa/nwqr2B91Vu/tNAu4Q0cBuG4Xe/D1f/freEci/7GDRA=="
        crossorigin="anonymous"
        referrerpolicy="no-referrer"
    />
</head>
<body>
	
<div class="lingkaran">
    <center><h3 class="judul">Tambah Detail Penghapusan</h3></center>
</div>
<div class="container">

<?php

	$kode_penghapusan = $_GET['kode_penghapusan'];
	$penghapusan = $con->query("SELECT*FROM penghapusan WHERE kode_penghapusan = '$kode_penghapusan'");
	$data_penghapusan = $penghapusan->fetch_array();

	?>

	<table class="table" style="width:80%">
		<tr>
			<td><h4 class="rincian">Nomor Berita Acara : <?php echo $data_penghapusan['no_berita_acara']?></h4></td>
			<td><h4 class="rincian">Tahun Berita Acara : <?php echo $data_penghapusan['tahun_berita_acara']?></h4></td>
		</tr>
    <tr>
      <td><h4 class="rincian">Tanggal Berita Acara : <?php echo date('d/m/Y', strtotime($data_penghapusan['tanggal_berita_acara']))?></h4></td>
			<td><h4 class="rincian">Nomor Keputusan : <?php echo $data_penghapusan['nomor_keputusan']?></h4></td>
		</tr>
		<tr>
			<td><h4 class="rincian">Tahun Keputusan : <?php echo $data_penghapusan['tahun_keputusan']?></h4></td>
			<td><h4 class="rincian">File Penghapusan : <a href='file_penghapusan/<?=$data_penghapusan['file_penghapusan']?>' download><?= $data_penghapusan['file_penghapusan']?></a></h4></td>
		</tr>
	</table>

</div>

<div class="container" style="width:40%; margin-top: 0%; margin-bottom: 12%;">
	<form method="POST" action="detail/proses_detail/proses_detail_penghapusan.php">
      	<div class="modal-body">
		  	<input type="hidden" name="kode_penghapusan" value="<?=$kode_penghapusan?>">
			<div class="mb-3">
    			<label class="form-label"><b class="bold">Kode Inventaris</b></label>
    			<select class="ch" name="kode_inventaris" id="kode_inventaris" onchange="handleChange()">
					<option value="">- Pilih Aset -</option>
					<?php
						$pilih_inventaris_tp = $con->query("SELECT * FROM inventaris JOIN detail_pengadaan_tp ON inventaris.kode_detail_pengadaan = detail_pengadaan_tp.kode_detail_pengadaan_tp JOIN kuota_aset ON kuota_aset.kode_inventaris = inventaris.kode_inventaris WHERE kuota_aset.jumlah_kuota > 0");
						while($pilihan_inventaris_tp=$pilih_inventaris_tp->fetch_assoc()){
					?>
					<option value="<?= $pilihan_inventaris_tp['kode_inventaris']?>"><?=  $pilihan_inventaris_tp['kode_inventaris']." - ".$pilihan_inventaris_tp['nama_barang_tp']?></option>
					<?php }	?>
					<?php
						$pilih_inventaris = $con->query("SELECT * FROM inventaris JOIN detail_pengadaan ON inventaris.kode_detail_pengadaan = detail_pengadaan.kode_detail_pengadaan JOIN detail_perencanaan ON detail_pengadaan.kode_detail_perencanaan = detail_perencanaan.kode_detail_perencanaan JOIN kuota_aset ON kuota_aset.kode_inventaris = inventaris.kode_inventaris WHERE kuota_aset.jumlah_kuota > 0");
						while($pilihan_inventaris=$pilih_inventaris->fetch_assoc()){
					?>
					<option value="<?= $pilihan_inventaris['kode_inventaris']?>"><?=  $pilihan_inventaris['kode_inventaris']." - ".$pilihan_inventaris['aset_perencanaan']?></option>
					<?php }	?>
				</select>
  			</div>
			<div class="mb-3">
    			<label class="form-label"><b class="bold">Jumlah Penghapusan</b></label>
    			<input type="number" class="form-control" name="jumlah_hapus_aset" required>
  			</div>
			<div class="mb-3">
    			<label class="form-label"><b class="bold">APBDesa</b></label>
    			<input type="number" class="form-control" value="0" name="dpsapbdesa" required>
  			</div>
			<div class="mb-3">
    			<label class="form-label"><b class="bold">Perolehan Lain Yg Sah</b></label>
    			<input type="number" class="form-control" value="0" name="dpsperolehanlain" required>
  			</div>
			<div class="mb-3">
    			<label class="form-label"><b class="bold">Aset Kekayaan Asli Desa</b></label>
    			<input type="number" class="form-control" value="0" name="dpskekayaandesa" required>
  			</div>
			<div class="mb-3">
    			<label class="form-label"><b class="bold">Keterangan / Penyebab</b></label>
    			<textarea class="form-control" id="penyebab_penghapusan" name="penyebab_penghapusan" rows="4" cols="50" style="resize: none;" required></textarea>
  			</div>
			<div class="mb-3">
                <label class="form-label"><b class="bold">Tindakan</b></label>
    		    <textarea class="form-control" id="keterangan_tindakan" name="keterangan_tindakan" rows="4" cols="50" style="resize: none;" required></textarea>
  			</div>
			<div class="mb-3">
    			<label class="form-label"><b class="bold">Tanggal Penghapusan<b></label>
    			<input type="date" class="form-control" name="tanggal_penghapusan" required>
  			</div>
			<div class="mb-3">
    			<label class="form-label"><b class="bold">Penanggung Jawab</b></label>
    			<select class="form-select" id="penanggung_jawab" name="penanggung_jawab">
					<option value="">- Pilih Pengurus -</option>
					<?php
						$pilih_pengurus = $con->query("SELECT pengurus.nomor_pengurus, pengurus.nama_pengurus FROM pengurus");
						while($pilihan=$pilih_pengurus->fetch_assoc()){
					?>
					<option value="<?= $pilihan['nama_pengurus']?>"><?=  $pilihan['nomor_pengurus']." - ".$pilihan['nama_pengurus']?></option>
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
    			<label class="form-label"><b class="bold">Kode Detail Pengadaan</b></label>
    			<input type="text" class="form-control" name="kdp" id="kdp" style="background: #efefef; pointer-events: none;">
  			</div>
		  	<div class="mb-3">
    			<label class="form-label"><b class="bold">Tahun Pembelian / Perolehan</b></label>
    			<input type="text" class="form-control" name="tahun_pp" id="tahun_pp" style="background: #efefef; pointer-events: none;">
  			</div>
            <div class="mb-3">
    			<label class="form-label"><b class="bold">Jenis Barang</b></label>
    			<input type="text" class="form-control" name="jenis_barang" id="jenis_barang" style="background: #efefef; pointer-events: none;">
  			</div>
			<div class="mb-3">
    			<label class="form-label"><b class="bold">APBDesa (Rp)</b></label>
    			<input type="number" class="form-control" name="apbdesa" id="apbdesa" style="background: #efefef; pointer-events: none;">
  			</div>
			<div class="mb-3">
    			<label class="form-label"><b class="bold">Perolehan Lain Yg Sah (Rp)</b></label>
    			<input type="number" class="form-control" name="perolehan_lain" id="perolehan_lain" style="background: #efefef; pointer-events: none;">
  			</div>
			<div class="mb-3">
    			<label class="form-label"><b class="bold">Kekayaan Asli Desa (Rp)</b></label>
    			<input type="number" class="form-control" name="kekayaan_asli_desa" id="kekayaan_asli_desa" style="background: #efefef; pointer-events: none;">
  			</div>

		  	<div class="mb-3">
    			<label class="form-label"><b class="bold">Jumlah Pengadaan / Perolehan</b></label>
    			<input type="text" class="form-control" name="jumlah_pp" id="jumlah_pp" style="background: #efefef; pointer-events: none;">
  			</div>
			<div class="mb-3">
    			<label class="form-label"><b class="bold">Jumlah Aset</b></label>
    			<input type="text" class="form-control" name="jumlah_aset" id="jumlah_aset" style="background: #efefef; pointer-events: none;">
  			</div>
            <div class="mb-3">
    			<label class="form-label"><b class="bold">Kuota Aset</b></label>
    			<input type="text" class="form-control" name="kuota_aset" id="kuota_aset" style="background: #efefef; pointer-events: none;">
  			</div>
			<div class="mb-3">
				<label class="form-label"><b class="bold">Identitas</b></label>
				<textarea class="form-control" id="identitas_aset" name="identitas_aset" rows="4" cols="50" style="background: #efefef; pointer-events: none;">
					
				</textarea>
  			</div>
            <div class="mb-3">
				<label class="form-label"><b class="bold">Keterangan</b></label>
				<textarea class="form-control" id="keterangan_aset" name="keterangan_aset" rows="4" cols="50" style="background: #efefef; pointer-events: none;">
					
				</textarea>
  			</div>
		</div>
</div>

</body>

<script>

	function detail_dp(){
		// alert("ok");
		var kode = $("#kode_inventaris").val();

		if(kode.length == "") {
			$('#kdp').val("");
			$('#tahun_pp').val("");
			$('#jenis_barang').val("");
			$('#apbdesa').val("");
			$('#perolehan_lain').val("");
			$('#kekayaan_asli_desa').val("");
			$('#jumlah_pp').val("");
		} else {
		$.ajax({
			url :"detail/data_detail_penghapusan_dp.php",
			method :"POST",
			data : {'kode':kode},
			dataType : "json",
			success:function(data){

				// $('#tahun_pp').val(data.tahun_rkp);

				if(data.kode_detail_pengadaan_tp){

					$('#kdp').val(data.kode_detail_pengadaan_tp);
					$('#tahun_pp').val(data.tahun_pengadaan_tp);
					$('#jenis_barang').val(data.nama_kelompok);
					$('#apbdesa').val(0);
					$('#perolehan_lain').val(data.nominal_perolehan_lain);
					$('#kekayaan_asli_desa').val(data.nominal_kekayaan_desa);
					$('#jumlah_pp').val(data.volume_tp);

				}
				
				if(data.kode_detail_pengadaan){

					$('#kdp').val(data.kode_detail_pengadaan);
					$('#tahun_pp').val(data.tahun_rkp);
					$('#jenis_barang').val(data.nama_kelompok);
					$('#apbdesa').val(data.apbdesa);
					$('#perolehan_lain').val(data.perolehan_lain);
					$('#kekayaan_asli_desa').val(data.kekayaan_asli_desa);
					$('#jumlah_pp').val(data.perkiraan_volume);
					
				}

			}
		})
	}
	}

	function detail(){
		// alert("ok");
		var kode = $("#kode_inventaris").val();

		if(kode.length == "") {
			$('#jumlah_aset').val("");
			$('#kuota_aset').val("");
			$('#satuan_aset').val("");
			$('#identitas_aset').val("");
			$('#keterangan_aset').val("");
		} else {
		$.ajax({
			url :"detail/data_detail_penghapusan.php",
			method :"POST",
			data : {'kode':kode},
			dataType : "json",
			success:function(data){
				$('#jumlah_aset').val(data.jumlah+" "+data.satuan);
				$('#kuota_aset').val(data.jumlah_kuota+" "+data.satuan);
				$('#satuan_aset').val(data.satuan);
				$('#identitas_aset').val(data.identitas_barang);
				$('#keterangan_aset').val(data.keterangan_aset);
			}
		})
	}
	}

	function handleChange(){ 
		detail();
		detail_dp();
	}

</script>
<script>
      $(document).ready(function () {
        $(".ch").chosen({
          width: "100%",
          no_results_text: "Oops, nothing found!",
          allow_single_deselect: true,
        });
      });
</script>

</html>