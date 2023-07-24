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
    <center><h3 class="judul">Detail Perolehan</h3></center>
</div>
<div class="container">
	
	<?php

	$kode_pengadaantp = $_GET['kode_pengadaan_tp'];
	$pengadaantp = $con->query("SELECT*FROM pengadaan_tp WHERE kode_pengadaan_tp = '$kode_pengadaantp'");
	$data_pengadaantp = $pengadaantp->fetch_array();

	$sub_total = $con->query("SELECT SUM(nominal_perolehan_lain + nominal_kekayaan_desa) AS total_nominal FROM detail_pengadaan_tp where kode_pengadaan_tp = '$kode_pengadaantp'");
	$sub_total_tp = $sub_total->fetch_array();

	?>

	<table class="table">
		<tr>
			<td><h4 class="rincian">Kode Perolehan : <?php echo $kode_pengadaantp?></h4></td>
		</tr>
        <tr>
            <td><h4 class="rincian">Asal Usul Barang : <?php echo $data_pengadaantp['sumber_perolehan_tp']?></h4></td>
		</tr>
		<tr>
            <td><h4 class="rincian">Tahun : <?php echo $data_pengadaantp['tahun_pengadaan_tp']?></h4></td>
		</tr>
        <tr>
            <td><h4 class="rincian">Total Nominal : <?php echo "Rp ".$sub_total_tp['total_nominal']?></h4></td>
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
			<th><center>Perolehan Lain Yg Sah</center></th>
			<th><center>Kekayaan Asli Desa</center></th>
			<th><center>Tanggal Perolehan</center></th>
			<th style="width: 20%"></th>
		</tr>
	</thead>
	<tbody>
		<?php $nomor=1;?>
		<?php $ambil=$con->query("SELECT * FROM detail_pengadaan_tp WHERE kode_pengadaan_tp = '$kode_pengadaantp'"); ?>
		<?php while($pecah=$ambil->fetch_assoc()){?>
		<tr>
			<td><center><?php echo $nomor++;?></center></td>
			<td><center><?php echo $pecah['kode_detail_pengadaan_tp']?></center></td>
			<td><center><?php echo $pecah['nama_barang_tp']?></center></td>
			<td><center><?php echo $pecah['volume_tp']." ".$pecah['satuan_tp']?></center></td>
			<td><center><?php echo $pecah['nominal_perolehan_lain']?></center></td>
			<td><center><?php echo $pecah['nominal_kekayaan_desa']?></center></td>
			<td><center><?php echo date('d/m/Y', strtotime($pecah['tanggal_perolehan_tp']))?></center></td>
			<td><center>
				<!-- <a href="detail/proses_detail/proses_detail_dpr.php?hapus_barang_dpr=<?php //echo $pecah['kode_detail_perencanaan'];?>&action=hapus_data_dpr&kode_perencanaan=<?php //echo $kode_perencanaan?>" class= "btn btn-danger">Hapus</a> -->
				
				<!-- Button trigger modal hapus barang -->
				<button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#modalHapus<?=$nomor?>" data-toggle="tooltip" data-placement="top" title="Hapus">
					<i class="bi bi-trash"></i>
				</button>
				<!-- Button trigger modal edit barang -->
				<button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#modalEdit<?=$nomor?>" data-toggle="tooltip" data-placement="top" title="Edit">
					<i class="bi bi-pencil"></i>
				</button>
				<!-- Button trigger modal rincian barang -->
				<button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modalrincian<?=$nomor?>" data-toggle="tooltip" data-placement="top" title="Rincian">
					<i class="bi bi-card-list"></i>
				</button>
				
				<!-- <a href="menu.php?page=ubah_detail_rencana&kode_detail_perencanaan=<?php // echo $pecah['kode_detail_perencanaan'];?>" class= "btn btn-warning">Ubah</a> -->
			</td></center>
		</tr>

<!-- Data Jenis Barang -->

<?php

	$kode_jenis = $pecah['kode_jenis'];

	$jenis = $con->query("SELECT * FROM jenis_barang WHERE kode_jenis = '$kode_jenis'");
	$data_jenis = $jenis->fetch_assoc();
?>

<!-- Data Jenis Barang -->
		
<!-- Awal Modal Edit Barang-->
<div class="modal fade modal-lg" id="modalEdit<?=$nomor?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="staticBackdropLabel">Edit Perolehan</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
	  <form method="POST" action="detail/proses_detail/proses_detail_pengadaan_tp.php">
      <div class="modal-body">
	  		<input type="hidden" name="ekode_detail_pengadaan_tp" value="<?=$pecah['kode_detail_pengadaan_tp']?>">
	  		<input type="hidden" name="ekode_pengadaan_tp" value="<?=$kode_pengadaantp?>">
			<div class="mb-3">
    			<label class="form-label"><b>Nama Barang</b></label>
    			<input type="text" class="form-control" name="enama_barang_tp" value="<?=$pecah['nama_barang_tp']?>">
  			</div>
			<div class="mb-3">
				<label class="form-label"><b>Jenis Barang</b></label>
    			<select class="ch" name="ejenis_barang_tp">
					<option value="<?= $data_jenis['kode_jenis']?>"><?= $data_jenis['kode_jenis']." - ".$data_jenis['nama_kelompok']?></option>
					<?php
						$jenis_barang = $con->query("SELECT * FROM jenis_barang WHERE NOT kode_jenis='$kode_jenis'");
						while($data_jbarang=$jenis_barang->fetch_assoc()){
					?>
					<option value="<?= $data_jbarang['kode_jenis']?>"><?= $data_jbarang['kode_jenis']." - ".$data_jbarang['nama_kelompok']?></option>
					<?php } ?>
				</select>
  			</div>
			<div class="mb-3">
    			<label class="form-label"><b>Perolehan Lain Yg Sah (Rp)</b></label>
    			<input type="number" class="form-control" min="0" max="99999999999" name="enominal_perolehan_lain_tp" value="<?= $pecah['nominal_perolehan_lain']?>" required>
  			</div>
			<div class="mb-3">
    			<label class="form-label"><b>Kekayaan Asli Desa (Rp)</b></label>
    			<input type="number" class="form-control" min="0" max="99999999999" name="enominal_kekayaan_desa_tp" value="<?= $pecah['nominal_kekayaan_desa']?>" required>
  			</div>
			<div class="mb-3">
    			<label class="form-label"><b>Volume</b></label>
    			<input type="text" class="form-control" name="evolume_tp" value="<?= $pecah['volume_tp']?>" style="background: #efefef; pointer-events: none;" required>
  			</div>
			<div class="mb-3">
    			<label class="form-label"><b>Satuan</b></label>
    			<input type="text" class="form-control" name="esatuan_tp" value="<?= $pecah['satuan_tp']?>" style="background: #efefef; pointer-events: none;" required>
  			</div>
			<div class="mb-3">
    			<label class="form-label"><b>Tanggal Perolehan</b></label>
    			<input type="date" class="form-control" name="etanggal_tp" value="<?= $pecah['tanggal_perolehan_tp']?>" required>
  			</div>
			<div class="mb-3">
    			<label class="form-label"><b>Lokasi</b></label>
    			<input type="text" class="form-control" name="elokasi_tp" value="<?= $pecah['lokasi_tp']?>" required>
  			</div>
			<div class="mb-3">
				<label class="form-label"><b class="bold">Keterangan</b></label>
				<textarea class="form-control" name="eketerangan_tp" rows="4" cols="50" style="resize: none;" required><?= $pecah['keterangan_tp']?></textarea>
  			</div>
  			<div class="mb-3">
    			<label class="form-label"><b>Penanggung Jawab</b></label>
    			<select class="form-select" name="epenanggung_jawab_tp">
					<option value="<?=$pecah['nomor_pengurus_tp']?>"><?=$pecah['nomor_pengurus_tp']." - ".$pecah['nama_pengurus_tp']?></option>
					<?php
						$pilih_pengurus = $con->query("SELECT pengurus.nomor_pengurus, pengurus.nama_pengurus FROM pengurus WHERE NOT nomor_pengurus='$pecah[nomor_pengurus_tp]'");
						while($pilihan=$pilih_pengurus->fetch_assoc()){
					?>
					<option value="<?= $pilihan['nomor_pengurus']?>"><?=  $pilihan['nomor_pengurus']." - ".$pilihan['nama_pengurus']?></option>
					<?php }	?>
				</select>
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
<!--  Akhir Modal Edit Barang-->

<!-- Awal Modal Hapus Barang-->
<div class="modal fade" id="modalHapus<?=$nomor?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel">Konfirmasi !</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
	  <form method="POST" action="detail/proses_detail/proses_detail_pengadaan_tp.php">
	  <input type="hidden" name="kode_pengadaan_tp" value="<?=$pecah['kode_pengadaan_tp']?>">
      <input type="hidden" name="kode_detail_pengadaan_tp" value="<?=$pecah['kode_detail_pengadaan_tp']?>">
	  <div class="modal-body">
			
			<h5 class="text-center">Data ini akan dihapus ?<br>
				<span class="text-danger"><?= $pecah['kode_detail_pengadaan_tp']?> - <?=$pecah['nama_barang_tp']?></span>
			</h5>

      </div>
      <div class="modal-footer">
		<button type="submit" class="btn btn-primary" name="bHapus">Yakin</button>
        <button type="button" class="btn btn-warning" data-bs-dismiss="modal">Batal</button>
      </div>
	</form>
    </div>
  </div>
</div>
<!--  Akhir Modal Hapus Barang-->

<!-- Awal Modal Rincian Barang-->
<div class="modal fade" id="modalrincian<?=$nomor?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" class="text-danger" id="staticBackdropLabel">Detail Perolehan</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
	  <div class="modal-body">
			<h6><b>Nama Barang : </b></h6>
			<h5 class="ddpd"><?=$pecah['nama_barang_tp']?></h5>
			<hr>
			<h6><b>Perolehan Lain Yg Sah : </b></h6>
			<h5 class="ddpd"><?=$pecah['nominal_perolehan_lain']?></h5>
			<hr>
			<h6><b>Kekayaan Asli Desa : </b></h6>
			<h5 class="ddpd"><?=$pecah['nominal_kekayaan_desa']?></h5>
			<hr>
			<h6><b>Jumlah : </b></h6>
			<h5 class="ddpd"><?= $pecah['volume_tp']." ".$pecah['satuan_tp']?></h5>
			<hr>
			<h6><b>Jenis : </b></h6>
			<h5 class="ddpd"><?=$pecah['kode_jenis']." - ".$data_jenis['nama_kelompok']?></h5>
			<hr>
			<h6><b>Tanggal Perolehan : </b></h6>
			<h5 class="ddpd"><?=date('d/m/Y', strtotime($pecah['tanggal_perolehan_tp']))?></h5>
			<hr>
			<h6><b>Lokasi : </b></h6>
			<h5 class="ddpd"><?=$pecah['lokasi_tp']?></h5>
			<hr>
			<h6><b>Keterangan : </b></h6>
			<h5 class="ddpd"><?=$pecah['keterangan_tp']?></h5>
			<hr>
			<h6><b>Penanggung Jawab : </b></h6>
			<h5 class="ddpd">Nomor : <?=$pecah['nomor_pengurus_tp']?></h5>
			<h5 class="ddpd">Nama : <?=$pecah['nama_pengurus_tp']?></h5>
			<h5 class="ddpd">No Telp : <?=$pecah['no_hp_pengurus_tp']?></h5>
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
	</tbody>
</table>

<!-- Awal Modal Tambah Barang-->
<div class="modal fade modal-lg" id="modalTambah" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="staticBackdropLabel">Tambah Barang</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
	  <form method="POST" action="detail/proses_detail/proses_detail_pengadaan_tp.php">
      <div class="modal-body">
	  		<input type="hidden" name="kode_pengadaan_tp" value="<?=$kode_pengadaantp?>">
  			<div class="mb-3">
    			<label class="form-label"><b>Nama Barang</b></label>
    			<input type="text" class="form-control" name="nama_barang_tp" required>
  			</div>
			<div class="mb-3">
				<label class="form-label"><b>Jenis Barang</b></label>
    			<select class="ch" name="jenis_barang_tp">
					<?php
						$jenis_b = $con->query("SELECT * FROM jenis_barang");
						while($data_jb=$jenis_b->fetch_assoc()){
					?>
					<option value="<?= $data_jb['kode_jenis']?>"><?= $data_jb['kode_jenis']." - ".$data_jb['nama_kelompok']?></option>
					<?php } ?>
				</select>
  			</div>
			<div class="mb-3">
    			<label class="form-label"><b>Volume</b></label>
    			<input type="number" min="0" max="2147483647" class="form-control" name="volume_tp" required>
  			</div>
			<div class="mb-3">
    			<label class="form-label"><b>Satuan</b></label>
    			<input type="text" class="form-control" name="satuan_tp" required>
  			</div>
            <div class="mb-3">
    			<label class="form-label"><b>Tanggal Perolehan</b></label>
    			<input type="date" class="form-control" name="tanggal_tp" required>
  			</div>
			<div class="mb-3">
    			<label class="form-label"><b>Perolehan Lain Yg Sah (Rp)</b></label>
    			<input type="number" min="0" max="99999999999" class="form-control" value="0" name="nominal_perolehan_lain" required>
  			</div>
			<div class="mb-3">
    			<label class="form-label"><b>Kekayaan Asli Desa (Rp)</b></label>
    			<input type="number" min="0" max="99999999999" class="form-control" value="0" name="nominal_kekayaan_desa" required>
  			</div>
			<div class="mb-3">
    			<label class="form-label"><b>Lokasi</b></label>
    			<input type="text" class="form-control" name="lokasi_tp" required>
  			</div>
			<div class="mb-3">
				<label class="form-label"><b class="bold">Keterangan</b></label>
				<textarea class="form-control" name="keterangan_tp" rows="4" cols="50" style="resize: none;" required></textarea>
  			</div>
            <div class="mb-3">
    			<label class="form-label"><b>Penanggung Jawab</b></label>
    			<select class="form-select" name="pengurus_tp">
					<?php
						$pilih_pengurus = $con->query("SELECT pengurus.nomor_pengurus, pengurus.nama_pengurus FROM pengurus");
						while($pilihan=$pilih_pengurus->fetch_assoc()){
					?>
					<option value="<?= $pilihan['nomor_pengurus']?>"><?=  $pilihan['nomor_pengurus']." - ".$pilihan['nama_pengurus']?></option>
					<?php }	?>
				</select>
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
<!--  Akhir Modal Tambah Barang-->

</div>

<script>
      $(document).ready(function () {
        $(".ch").chosen({
          width: "100%",
          no_results_text: "Oops, nothing found!",
          allow_single_deselect: true,
        });
      });
</script>