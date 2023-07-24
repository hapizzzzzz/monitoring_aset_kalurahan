<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Inventaris</title>
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
    <center><h3 class="judul">Tambah Inventaris</h3></center>
</div>

<div class="container" style="width:40%; margin-top: 2%; margin-bottom: 3%;">
	<form method="POST" action="detail/proses_detail/proses_inventaris.php">
      	<div class="modal-body">
		  	<!-- <input type="hidden" name="dpdkode_pengadaan" value="<?php //$kode_pengadaan ?>"> -->
			<input type="hidden" id="in_kode_jenis" name="in_kode_jenis">
			<input type="hidden" id="jumlah_inventaris" name="jumlah_inventaris">
			<input type="hidden" id="satuan_inventaris" name="satuan_inventaris">
			<div class="mb-3">
    			<label class="form-label"><b>Pilih Barang</b></label>
				<select class="ch" name="pilihan_pengadaan" id="pilihan_pengadaan" onchange="detail()">
					<option value="">- Pilih Barang -</option>
					<?php
						$pilih_pengadaan = $con->query("SELECT detail_perencanaan.aset_perencanaan, detail_pengadaan.kode_detail_pengadaan FROM detail_perencanaan JOIN detail_pengadaan ON detail_perencanaan.kode_detail_perencanaan = detail_pengadaan.kode_detail_perencanaan WHERE detail_pengadaan.kode_detail_pengadaan NOT IN (SELECT inventaris.kode_detail_pengadaan FROM inventaris)");
						while($pilihan_pengadaan=$pilih_pengadaan->fetch_assoc()){
					?>
					<option value="<?= $pilihan_pengadaan['kode_detail_pengadaan']?>"><?=  $pilihan_pengadaan['kode_detail_pengadaan']." - ".$pilihan_pengadaan['aset_perencanaan'] ?></option>
					<?php }	?>
					<?php
						$pilih_pengadaan_tp = $con->query("SELECT detail_pengadaan_tp.kode_detail_pengadaan_tp, detail_pengadaan_tp.nama_barang_tp FROM detail_pengadaan_tp WHERE detail_pengadaan_tp.kode_detail_pengadaan_tp NOT IN (SELECT inventaris.kode_detail_pengadaan FROM inventaris)");
						while($pilihan_pengadaan_tp=$pilih_pengadaan_tp->fetch_assoc()){
					?>
					<option value="<?= $pilihan_pengadaan_tp['kode_detail_pengadaan_tp']?>"><?=  $pilihan_pengadaan_tp['kode_detail_pengadaan_tp']." - ".$pilihan_pengadaan_tp['nama_barang_tp'] ?></option>
					<?php }	?>
				</select>
  			</div>
			<div class="mb-3">
				<label class="form-label"><b class="bold">Identitas</b></label>
				<textarea class="form-control" name="identitas_inventaris" rows="4" cols="50" style="resize: none;" required></textarea>
  			</div>
			<div class="mb-3">
				<label class="form-label"><b class="bold">Keterangan</b></label>
				<textarea class="form-control" id="keterangan_inventaris" name="keterangan_inventaris" rows="4" cols="50" style="resize: none;"></textarea>
  			</div>
		</div>
      	<div>
		  	<button type="submit" class="btn btn-primary" name="bSimpan">Simpan</button>            
      	</div>
	</form>
</div>

<div class="container" style="width:35%; margin-top: 2%; margin-left:2%; margin-bottom:2%; position:absolute">
      	<div class="modal-body">
		  	<div class="mb-3">
    			<label class="form-label"><b class="bold">Jenis Barang</b></label>
    			<input type="text" class="form-control" name="in_jenis_barang" id="in_jenis_barang" style="background: #efefef; pointer-events: none;">
  			</div>
			<div class="mb-3">
    			<label class="form-label"><b class="bold">Nama Barang</b></label>
    			<input type="text" class="form-control" name="in_nama" id="in_nama" style="background: #efefef; pointer-events: none;">
  			</div>
			<div class="mb-3">
    			<label class="form-label"><b class="bold">Jumlah</b></label>
    			<input type="number" class="form-control" name="in_jumlah" id="in_jumlah" style="background: #efefef; pointer-events: none;">
  			</div>
			<div class="mb-3">
    			<label class="form-label"><b class="bold">Lokasi</b></label>
    			<input type="text" class="form-control" name="in_lokasi" id="in_lokasi" style="background: #efefef; pointer-events: none;">
  			</div>
			<div class="mb-3">
				<label class="form-label"><b class="bold">Keterangan</b></label>
				<textarea class="form-control" id="in_keterangan" name="in_keterangan" rows="4" cols="50" style="background: #efefef; pointer-events: none;">
					
				</textarea>
    			<!-- <input type="text" class="form-control" name="dpdketerangan" id="dpdketerangan" style="background: #efefef; pointer-events: none;"> -->
  			</div>
		</div>
</div>

</body>

<script>

	function detail(){
		// alert("ok");
		var kode = $("#pilihan_pengadaan").val();

		if(kode.length == "") {
			$('#in_kode_jenis').val("");
			$('#in_jenis_barang').val("");
			$('#in_nama').val("");
			$('#in_jumlah').val("");
			$('#in_lokasi').val("");
			$('#in_keterangan').val("");
			$('#jumlah_inventaris').val("0");
			$('#satuan_inventaris').val("");
			$('#keterangan_inventaris').val("");
		} else {
		$.ajax({
			url :"detail/data_pengadaan_inventaris.php",
			method :"POST",
			data : {'kode':kode},
			dataType : "json",
			success:function(data){

				if(data.kode_detail_pengadaan_tp){

					$('#in_kode_jenis').val(data.kode_jenis);
					$('#in_jenis_barang').val(data.nama_kelompok);
					$('#in_nama').val(data.nama_barang_tp);
					$('#in_jumlah').val(data.volume_tp);
					$('#in_lokasi').val(data.lokasi_tp);
					$('#in_keterangan').val(data.keterangan_tp);
					$('#jumlah_inventaris').val(data.volume_tp);
					$('#satuan_inventaris').val(data.satuan_tp);
					$('#keterangan_inventaris').val(data.keterangan_tp);

				}
				
				if(data.kode_detail_pengadaan){

					$('#in_kode_jenis').val(data.kode_jenis);
					$('#in_jenis_barang').val(data.nama_kelompok);
					$('#in_nama').val(data.aset_perencanaan);
					$('#in_jumlah').val(data.perkiraan_volume);
					$('#in_lokasi').val(data.rencana_lokasi);
					$('#in_keterangan').val(data.keterangan);
					$('#jumlah_inventaris').val(data.perkiraan_volume);
					$('#satuan_inventaris').val(data.rencana_satuan_volume);
					$('#keterangan_inventaris').val(data.keterangan);
					
				}

			}
		})
	}
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