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

<div class="lingkaran">
    <center><h3 class="judul">Detail Penggunaan</h3></center>
</div>
<div class="container">
	
	<?php

	$kode_penggunaan = $_GET['kode_penggunaan'];
	$penggunaan = $con->query("SELECT*FROM penggunaan WHERE kode_penggunaan = '$kode_penggunaan'");
	$data_penggunaan = $penggunaan->fetch_assoc();

	?>

	<table class="table">
		<tr>
			<td><h4 class="rincian">Kode Penggunaan : <?php echo $kode_penggunaan?></h4></td>
		</tr>
        <tr>
            <td><h4 class="rincian">Nama Pengguna : <?php echo $data_penggunaan['pengguna']?></h4></td>
		</tr>
		<tr>
            <td><h4 class="rincian">Lokasi : <?php echo $data_penggunaan['lokasi']?></h4></td>
		</tr>
	</table>

	<!-- Button trigger modal tambah barang -->
	<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalTambah" style="margin-bottom: 3%; font-size: 15px; border-radius: 10px; width: 15%">
		<i class="bi bi-plus-circle"></i>Tambah Data
	</button>

    <table class="table table-sm" cellspacing="0" width="100%" id="table" style="margin-top: 20px;">
	<thead>
		<tr>
			<th><center>No.</center></th>
			<th><center>Kode</center></th>
			<th><center>Nama Barang</center></th>
			<th><center>Jumlah</center></th>
			<th><center>Identitas Barang</center></th>
			<th><center>Keterangan</center></th>
			<th style="width: 20%"></th>
		</tr>
	</thead>
	<tbody>
		<?php $nomor=1;?>
		<?php $ambil_tp=$con->query("SELECT * FROM detail_penggunaan JOIN inventaris ON detail_penggunaan.kode_inventaris = inventaris.kode_inventaris JOIN detail_pengadaan_tp ON detail_pengadaan_tp.kode_detail_pengadaan_tp = inventaris.kode_detail_pengadaan WHERE detail_penggunaan.kode_penggunaan = '$kode_penggunaan'"); ?>
		<?php while($pecah_tp=$ambil_tp->fetch_assoc()){?>
		<tr>
			<td><center><?php echo $nomor++;?></center></td>
			<td><center><?php echo $pecah_tp['kode_detail_penggunaan']?></center></td>
			<td><center><?php echo $pecah_tp['nama_barang_tp']?></center></td>
			<td><center><?php echo $pecah_tp['jumlah_pg'] ." ".$pecah_tp['satuan']?></center></td>
			<td><center><?php echo $pecah_tp['identitas_barang']?></center></td>
			<td><center><?php echo $pecah_tp['keterangan_penggunaan']?></center></td>
			<td><center>
				
				<!-- Button trigger modal hapus Penggunaan -->
				<button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#modalHapusTP<?=$nomor?>" data-toggle="tooltip" data-placement="top" title="Hapus">
					<i class="bi bi-trash"></i>
				</button>
				<!-- Button trigger modal edit Penggunaan -->
				<button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#modalEditTP<?=$nomor?>" data-toggle="tooltip" data-placement="top" title="Edit">
					<i class="bi bi-pencil"></i>
				</button>
				<!-- Button trigger modal rincian Penggunaan -->
				<button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modalrincian<?=$nomor?>" data-toggle="tooltip" data-placement="top" title="Rincian">
					<i class="bi bi-card-list"></i>
				</button>
				
			</td></center>
		</tr>

		<!-- Awal Modal Hapus PenggunaanTP-->
		<div class="modal fade" id="modalHapusTP<?=$nomor?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  				<div class="modal-dialog">
    				<div class="modal-content">
      					<div class="modal-header">
        					<h5 class="modal-title" id="staticBackdropLabel">Konfirmasi !</h5>
        					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      					</div>
	  					<form method="POST" action="detail/proses_detail/proses_detail_penggunaan.php">
      						<input type="hidden" name="kode_detail_penggunaan" value="<?=$pecah_tp['kode_detail_penggunaan']?>">
							<input type="hidden" name="jumlah_pg" value="<?=$pecah_tp['jumlah_pg']?>">
							<input type="hidden" name="kode_in_pg" value="<?=$pecah_tp['kode_inventaris']?>">
							<input type="hidden" name="kode_penggunaan" value="<?=$kode_penggunaan?>">
	  						<div class="modal-body">
			
								<h5 class="text-center">Data ini akan dihapus ?<br>
									<span class="text-danger"><?= $pecah_tp['kode_detail_penggunaan']." - ".$pecah_tp['nama_barang_tp']." ( ".$pecah_tp['jumlah_pg']." ".$pecah_tp['satuan']." ) "?></span>
								</h5>

      						</div>
      						<div class="modal-footer">
								<button type="submit" class="btn btn-primary" name="bHapusTP">Yakin</button>
        						<button type="button" class="btn btn-warning" data-bs-dismiss="modal">Batal</button>
      						</div>
						</form>
    				</div>
  				</div>
			</div>
		<!--  Akhir Modal Hapus PenggunaanTP-->

		<!-- Awal Modal Edit PenggunaanTP-->
		<div class="modal fade modal-lg" id="modalEditTP<?=$nomor?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
			<div class="modal-header">
				<h1 class="modal-title fs-5" id="staticBackdropLabel">Edit Penggunaan</h1>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<form method="POST" action="detail/proses_detail/proses_detail_penggunaan.php">
			<div class="modal-body">
			<input type="hidden" name="epg_kode_dpgtp" value="<?=$pecah_tp['kode_detail_penggunaan']?>">
			<input type="hidden" name="kode_penggunaan" value="<?=$kode_penggunaan?>">
					<div class="mb-3">
						<label class="form-label"><b>Kode</b></label>
						<input type="text" class="form-control" value="<?=$pecah_tp['nama_barang_tp']." - ".$pecah_tp['jumlah_pg']." ".$pecah_tp['satuan']?>" style="background: #efefef; pointer-events: none;">
					</div>
					<div class="mb-3">
						<label class="form-label"><b>Identitas</b></label>
						<textarea class="form-control" rows="4" cols="50" style="resize: none; background: #efefef; pointer-events: none;" required><?= $pecah_tp['identitas_barang']?></textarea>
					</div>
					<div class="mb-3">
						<label class="form-label"><b class="bold">Keterangan</b></label>
						<textarea class="form-control" name="epg_keterangan_tp" rows="4" cols="50" style="resize: none;" required><?= $pecah_tp['keterangan_penggunaan']?></textarea>
					</div>
				</div>
				<div class="modal-footer">
					<button type="submit" class="btn btn-primary" name="bUbahTP">Ubah</button>
					<button type="button" class="btn btn-warning" data-bs-dismiss="modal">Batal</button>
				</div>
			</form>
			</div>
		</div>
		</div>
		<!--  Akhir Modal Edit PenggunaanTP-->

		<!-- Awal Modal Rincian Barang-->
		<div class="modal fade" id="modalrincian<?=$nomor?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" class="text-danger" id="staticBackdropLabel">Detail Penggunaan</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
				<h6><b>Kode Pengadaan / Perolehan : </b></h6>
				<h5 class="ddpd"><?=$pecah_tp['kode_detail_pengadaan']?></h5>
				<hr>
				<h6><b>Kode Inventaris : </b></h6>
				<h5 class="ddpd"><?=$pecah_tp['kode_inventaris']?></h5>
				<hr>
				<h6><b>Nama Barang : </b></h6>
				<h5 class="ddpd"><?=$pecah_tp['nama_barang_tp']?></h5>
				<hr>
				<h6><b>Jumlah : </b></h6>
				<h5 class="ddpd"><?= $pecah_tp['jumlah_pg']." ".$pecah_tp['satuan']?></h5>
				<hr>
				<h6><b>Identitas : </b></h6>
				<h5 class="ddpd"><?=$pecah_tp['identitas_barang']?></h5>
				<hr>
				<h6><b>Keterangan : </b></h6>
				<h5 class="ddpd"><?=$pecah_tp['keterangan_penggunaan']?></h5>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-success" data-bs-dismiss="modal">OK</button>
			</div>
			</form>
			</div>
		</div>
		</div>
		<!--  Akhir Modal Rincian Barang-->
		
		<?php }?>

		
		<?php $ambil=$con->query("SELECT * FROM detail_penggunaan JOIN inventaris ON detail_penggunaan.kode_inventaris = inventaris.kode_inventaris JOIN detail_pengadaan ON detail_pengadaan.kode_detail_pengadaan = inventaris.kode_detail_pengadaan JOIN detail_perencanaan ON detail_pengadaan.kode_detail_perencanaan = detail_perencanaan.kode_detail_perencanaan WHERE detail_penggunaan.kode_penggunaan = '$kode_penggunaan'"); ?>
		<?php while($pecah=$ambil->fetch_assoc()){?>
		<tr>
			<td><center><?php echo $nomor++;?></center></td>
			<td><center><?php echo $pecah['kode_detail_penggunaan']?></center></td>
			<td><center><?php echo $pecah['aset_perencanaan']?></center></td>
			<td><center><?php echo $pecah['jumlah_pg'] ." ".$pecah['satuan']?></center></td>
			<td><center><?php echo $pecah['identitas_barang']?></center></td>
			<td><center><?php echo $pecah['keterangan_penggunaan']?></center></td>
			<td><center>
				
				<!-- Button trigger modal hapus Penggunaan -->
				<button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#modalHapus<?=$nomor?>" data-toggle="tooltip" data-placement="top" title="Hapus">
					<i class="bi bi-trash"></i>
				</button>
				<!-- Button trigger modal edit Penggunaan -->
				<button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#modalEdit<?=$nomor?>" data-toggle="tooltip" data-placement="top" title="Edit">
					<i class="bi bi-pencil"></i>
				</button>
				<!-- Button trigger modal rincian Penggunaan -->
				<button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modalrincian<?=$nomor?>" data-toggle="tooltip" data-placement="top" title="Rincian">
					<i class="bi bi-card-list"></i>
				</button>
				
			</td></center>
		</tr>

		<!-- Awal Modal Hapus Penggunaan-->
		<div class="modal fade" id="modalHapus<?=$nomor?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  				<div class="modal-dialog">
    				<div class="modal-content">
      					<div class="modal-header">
        					<h5 class="modal-title" id="staticBackdropLabel">Konfirmasi !</h5>
        					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      					</div>
	  					<form method="POST" action="detail/proses_detail/proses_detail_penggunaan.php">
      						<input type="hidden" name="kode_detail_penggunaan" value="<?=$pecah['kode_detail_penggunaan']?>">
							<input type="hidden" name="jumlah_pg" value="<?=$pecah['jumlah_pg']?>">
							<input type="hidden" name="kode_in_pg" value="<?=$pecah['kode_inventaris']?>">
							<input type="hidden" name="kode_penggunaan" value="<?=$kode_penggunaan?>">
	  						<div class="modal-body">
			
								<h5 class="text-center">Data ini akan dihapus ?<br>
									<span class="text-danger"><?= $pecah['kode_detail_penggunaan']." - ".$pecah['aset_perencanaan']." ( ".$pecah['jumlah_pg']." ".$pecah['satuan']." ) "?></span>
								</h5>

      						</div>
      						<div class="modal-footer">
								<button type="submit" class="btn btn-primary" name="bHapusTP">Yakin</button>
        						<button type="button" class="btn btn-warning" data-bs-dismiss="modal">Batal</button>
      						</div>
						</form>
    				</div>
  				</div>
			</div>
		<!--  Akhir Modal Hapus Penggunaan-->

		<!-- Awal Modal Edit Penggunaan-->
		<div class="modal fade modal-lg" id="modalEdit<?=$nomor?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
			<div class="modal-header">
				<h1 class="modal-title fs-5" id="staticBackdropLabel">Edit Penggunaan</h1>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<form method="POST" action="detail/proses_detail/proses_detail_penggunaan.php">
			<div class="modal-body">
			<input type="hidden" name="epg_kode_dpg" value="<?=$pecah['kode_detail_penggunaan']?>">
			<input type="hidden" name="kode_penggunaan" value="<?=$kode_penggunaan?>">
					<div class="mb-3">
						<label class="form-label"><b>Penggunaan</b></label>
						<input type="text" class="form-control" value="<?=$pecah['aset_perencanaan']." - ".$pecah['jumlah_pg']." ".$pecah['satuan']?>" style="background: #efefef; pointer-events: none;">
					</div>
					<div class="mb-3">
						<label class="form-label"><b>Identitas</b></label>
						<textarea class="form-control" rows="4" cols="50" style="resize: none; background: #efefef; pointer-events: none;" required><?= $pecah['identitas_barang']?></textarea>
					</div>
					<div class="mb-3">
						<label class="form-label"><b class="bold">Keterangan</b></label>
						<textarea class="form-control" name="epg_keterangan" rows="4" cols="50" style="resize: none;" required><?= $pecah['keterangan_penggunaan']?></textarea>
					</div>
				</div>
				<div class="modal-footer">
					<button type="submit" class="btn btn-primary" name="bUbah">Ubah</button>
					<button type="button" class="btn btn-warning" data-bs-dismiss="modal">Batal</button>
				</div>
			</form>
			</div>
		</div>
		</div>
		<!--  Akhir Modal Edit Penggunaan-->


		<!-- Awal Modal Rincian Penggunaan-->
		<div class="modal fade" id="modalrincian<?=$nomor?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" class="text-danger" id="staticBackdropLabel">Detail Penggunaan</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
				<h6><b>Kode Pengadaan / Perolehan : </b></h6>
				<h5 class="ddpd"><?=$pecah['kode_detail_pengadaan']?></h5>
				<hr>
				<h6><b>Kode Inventaris : </b></h6>
				<h5 class="ddpd"><?=$pecah['kode_inventaris']?></h5>
				<hr>
				<h6><b>Nama Barang : </b></h6>
				<h5 class="ddpd"><?=$pecah['aset_perencanaan']?></h5>
				<hr>
				<h6><b>Jumlah : </b></h6>
				<h5 class="ddpd"><?= $pecah['jumlah_pg']." ".$pecah['satuan']?></h5>
				<hr>
				<h6><b>Identitas : </b></h6>
				<h5 class="ddpd"><?=$pecah['identitas_barang']?></h5>
				<hr>
				<h6><b>Keterangan : </b></h6>
				<h5 class="ddpd"><?=$pecah['keterangan_penggunaan']?></h5>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-success" data-bs-dismiss="modal">OK</button>
			</div>
			</form>
			</div>
		</div>
		</div>
		<!--  Akhir Modal Rincian Penggunaan-->

		<?php }?>
	</tbody>
</table>

<!-- Awal Modal Tambah Penggunaan-->
<div class="modal fade modal-lg" id="modalTambah" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="staticBackdropLabel">Tambah Pengggunaan</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
	  <form method="POST" action="detail/proses_detail/proses_detail_penggunaan.php">
      <div class="modal-body">
			<div class="mb-3">
			    <input type="hidden" name="tkode_penggunaan" value="<?=$kode_penggunaan?>">
    			<label class="form-label"><b>Pilih Aset</b></label>
				<select class="ch" name="pilihan_aset" id="pilihan_aset" onchange="detail()">
					<option value="">- Pilih Barang -</option>
					<?php
						$pilih_penggunaan_tp = $con->query("SELECT * FROM inventaris JOIN detail_pengadaan_tp ON inventaris.kode_detail_pengadaan = detail_pengadaan_tp.kode_detail_pengadaan_tp JOIN kuota_aset ON kuota_aset.kode_inventaris = inventaris.kode_inventaris WHERE kuota_aset.jumlah_kuota > 0");
						while($pilihan_penggunaan_tp=$pilih_penggunaan_tp->fetch_assoc()){
					?>
					<option value="<?= $pilihan_penggunaan_tp['kode_inventaris']?>"><?=  $pilihan_penggunaan_tp['kode_inventaris']." - ".$pilihan_penggunaan_tp['nama_barang_tp']." ( ".$pilihan_penggunaan_tp['jumlah_kuota']." ) "?></option>
					<?php }	?>
                    <?php
						$pilih_penggunaan = $con->query("SELECT * FROM inventaris JOIN detail_pengadaan ON inventaris.kode_detail_pengadaan = detail_pengadaan.kode_detail_pengadaan JOIN detail_perencanaan ON detail_pengadaan.kode_detail_perencanaan = detail_perencanaan.kode_detail_perencanaan JOIN kuota_aset ON kuota_aset.kode_inventaris = inventaris.kode_inventaris WHERE kuota_aset.jumlah_kuota > 0");
						while($pilihan_penggunaan=$pilih_penggunaan->fetch_assoc()){
					?>
					<option value="<?= $pilihan_penggunaan['kode_inventaris']?>"><?=  $pilihan_penggunaan['kode_inventaris']." - ".$pilihan_penggunaan['aset_perencanaan']." ( ".$pilihan_penggunaan['jumlah_kuota']." ) "?></option>
					<?php }	?>
				</select>
  			</div>
			<div class="mb-3">
    			<label class="form-label"><b>Jumlah </b></label>
				<table style="width:100%">
					<tr>
    					<td><input type="number" min="0" max="2147483647" class="form-control" name="jumlah_pg" id="jumlah_pg" style="width: 100%;" required><td>
						<td><input type="text" class="form-control" id="satuan_pg" style="width: 100%; background: #efefef; pointer-events: none;" required><td>
					</tr>
				</table>
			</div>
            <div class="mb-3">
				<label class="form-label"><b class="bold">Identitas</b></label>
				<textarea style="background: #efefef; pointer-events: none;" class="form-control" name="identitas_pg" id="identitas_pg" rows="4" cols="50" style="resize: none;" required></textarea>
  			</div>
            <div class="mb-3">
				<label class="form-label"><b class="bold">Keterangan</b></label>
				<textarea class="form-control" name="keterangan_pg" id="keterangan_pg" rows="4" cols="50" style="resize: none;" required></textarea>
  			</div>
      	</div>
      	<div class="modal-footer">
		  	<button type="submit" class="btn btn-primary" name="bSimpan">Simpan</button>
        	<button type="button" class="btn btn-warning" data-bs-dismiss="modal">Batal</button>
      	</div>
	</form>
    </div>
  </div>
</div>
<!--  Akhir Modal Tambah Penggunaan-->

</div>

<script>
	function detail(){
		// alert("ok");
		var kode = $("#pilihan_aset").val();

		if(kode.length == "") {
			$('#identitas_pg').val("");
			$('#keterangan_pg').val("");
			$('#jumlah_pg').val("");
			$('#satuan_pg').val("");
		} else {
		$.ajax({
			url :"detail/data_detail_penggunaan.php",
			method :"POST",
			data : {'kode':kode},
			dataType : "json",
			success:function(data){

				if(data){
					$('#identitas_pg').val(data.identitas_barang);
					$('#keterangan_pg').val(data.keterangan_aset);
					$('#jumlah_pg').val(data.jumlah_kuota);
					$('#satuan_pg').val(data.satuan);
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
