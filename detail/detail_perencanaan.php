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
    <center><h3 class="judul">Detail Perencanaan</h3></center>
</div>
<div class="container">
	
	<?php

	$kode_perencanaan = $_GET['kode_perencanaan'];
	$perencanaan = $con->query("SELECT*FROM perencanaan where kode_perencanaan = '$kode_perencanaan'");
	$data_perencanaan = $perencanaan->fetch_array();

	$sub_total = $con->query("SELECT SUM(perkiraan_biaya) AS total_perkiraan_b FROM detail_perencanaan where kode_perencanaan = '$kode_perencanaan'");
	$sub_total_p = $sub_total->fetch_array();

	?>

	<table class="table">
		<tr>
			<td><h4 class="rincian">No RPJM : <?php echo $data_perencanaan['no_rpjm']?></h4></td>
			<td><h4 class="rincian">Taggal RPJM  : <?php echo date('d/m/Y', strtotime($data_perencanaan['tanggal_rpjm']))?></h4></td>
		</tr>
		<tr>
			<td><h4 class="rincian">No RKP : <?php echo $data_perencanaan['no_rkp']?></h4></td>
			<td><h4 class="rincian">Tanggal RKP  : <?php echo date('d/m/Y', strtotime($data_perencanaan['tanggal_rkp']))?></h4></td>
		</tr>
		<tr>
			<td><h4 class="rincian">Periode RPJM : <?php echo $data_perencanaan['periode_rpjm']?></h4></td>
			<td><h4 class="rincian">Tahun RKP  : <?php echo $data_perencanaan['tahun_rkp']?></h4></td>
		</tr>
		<tr>
			<td><h4 class="rincian">Total Perkiraan Biaya  : Rp <?php echo $sub_total_p['total_perkiraan_b']?></h4></td>
		</tr>
	</table>

	<!-- Button trigger modal tambah barang -->
	<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalTambah" style="margin-bottom: 3%; font-size: 15px; border-radius: 10px; width: 15%">
		<i class="bi bi-plus-circle"></i>Tambah Data
	</button>

	<a href="../aset/cetak/cetak_detail_perencanaan.php?kode_perencanaan=<?php echo $kode_perencanaan ?>" target="_blank" class="btn btn-success" style="margin-bottom: 3%; font-size: 15px; border-radius: 10px; width: 15%" value="val"><i class="bi bi-printer"></i>Cetak</a>
    <table class="table table-sm" cellspacing="0" width="100%" id="table" style="margin-top: 20px;">
	<thead>
		<tr>
			<th><center>No.</center></th>
			<th><center>Kode</center></th>
			<th><center>Nama Barang</center></th>
			<th><center>Jenis Kegiatan</center></th>
			<th><center>Jumlah</center></th>
			<th><center>Bidang</center></th>
			<th></th>
		</tr>
	</thead>
	<tbody>
		<?php $nomor=1;?>
		<?php $ambil=$con->query("SELECT*FROM detail_perencanaan JOIN jenis_barang ON detail_perencanaan.kode_jenis = jenis_barang.kode_jenis where detail_perencanaan.kode_perencanaan = '$kode_perencanaan'"); ?>
		<?php while($pecah=$ambil->fetch_assoc()){?>
		<tr>
			<td><center><?php echo $nomor++;?></center></td>
			<td><center><?php echo $pecah['kode_detail_perencanaan']?></center></td>
			<td><center><?php echo $pecah['aset_perencanaan']?></center></td>
			<td><center><?php echo $pecah['jenis_kegiatan_rencana']?></center></td>
			<td><center><?php echo $pecah['perkiraan_volume']." ".$pecah['rencana_satuan_volume']?></center></td>
			<td><center><?php echo $pecah['bidang_perencanaan']?></center></td>
			<td><center>
				<!-- <a href="detail/proses_detail/proses_detail_dpr.php?hapus_barang_dpr=<?php //echo $pecah['kode_detail_perencanaan'];?>&action=hapus_data_dpr&kode_perencanaan=<?php //echo $kode_perencanaan?>" class= "btn btn-danger">Hapus</a> -->
				
				<!-- Button trigger modal hapus barang -->
				<button type="button" class="btn btn-danger" data-bs-toggle="modal" data-toggle="tooltip" data-placement="top" title="Hapus" data-bs-target="#modalHapus<?=$nomor?>">
					<i class="bi bi-trash"></i>
				</button>
				<!-- Button trigger modal edit barang -->
				<button type="button" class="btn btn-warning" data-bs-toggle="modal" data-toggle="tooltip" data-placement="top" title="Edit" data-bs-target="#modalEdit<?=$nomor?>">
					<i class="bi bi-pencil"></i>
				</button>
				<button type="button" class="btn btn-success" data-bs-toggle="modal" data-toggle="tooltip" data-placement="top" title="Rincian" data-bs-target="#modalrincian<?=$nomor?>">
					<i class="bi bi-card-list"></i>
				</button>
				
				<!-- <a href="menu.php?page=ubah_detail_rencana&kode_detail_perencanaan=<?php // echo $pecah['kode_detail_perencanaan'];?>" class= "btn btn-warning">Ubah</a> -->
			</td></center>
		</tr>
		
<!-- Awal Modal Edit Barang-->
<div class="modal fade modal-lg" id="modalEdit<?=$nomor?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="staticBackdropLabel">Edit Barang</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
	  <form method="POST" action="detail/proses_detail/proses_detail_dpr.php?kode_perencanaan=<?php echo $kode_perencanaan ?>">
      <div class="modal-body">
			<div class="mb-3">
    			<label class="form-label"><b>Kode</b></label>
    			<input type="text" class="form-control" name="dpkode" value="<?=$pecah['kode_detail_perencanaan']?>" style="background: #efefef; pointer-events: none;">
  			</div>
  			<div class="mb-3">
    			<label class="form-label"><b>Nama Barang</b></label>
    			<input type="text" class="form-control" name="dpnamabarang" value="<?=$pecah['aset_perencanaan']?>" required>
  			</div>
			<div class="mb-3">
    			<label class="form-label"><b>Jenis Kegiatan</b></label>
    			<input type="text" class="form-control" name="dpjeniskegiatan" value="<?= $pecah['jenis_kegiatan_rencana']?>" required>
  			</div>
			<div class="mb-3">
    			<label class="form-label"><b>Jenis Barang</b></label>
				<select class="ch" name="dpjenisbarang">
					<option value="<?=$pecah['kode_jenis']?>"><?=$pecah['kode_jenis']." - ".$pecah['nama_kelompok']?></option>
					<?php
						$pilih_jenis = $con->query("SELECT * FROM jenis_barang WHERE NOT kode_jenis='$pecah[kode_jenis]'");
						while($pilihan_jenis=$pilih_jenis->fetch_assoc()){
					?>
					<option value="<?= $pilihan_jenis['kode_jenis']?>"><?=  $pilihan_jenis['kode_jenis']." - ".$pilihan_jenis['nama_kelompok']?></option>
					<?php }	?>
				</select>
  			</div>
			<div class="mb-3">
    			<label class="form-label"><b>Lokasi</b></label>
    			<input type="text" class="form-control" name="dplokasi" value="<?= $pecah['rencana_lokasi']?>" required>
  			</div>
			<div class="mb-3">
    			<label class="form-label"><b>Volume</b></label>
    			<input type="text" class="form-control" name="dpvolume" min="0"  value="<?= $pecah['perkiraan_volume']?>" style="background: #efefef; pointer-events: none;" required>
  			</div>
			<div class="mb-3">
    			<label class="form-label"><b>Satuan</b></label>
    			<input type="text" class="form-control" name="dpsatuan" value ="<?= $pecah['rencana_satuan_volume']?>" style="background: #efefef; pointer-events: none;" required>
  			</div>
			<div class="mb-3">
    			<label class="form-label"><b>Sumber Biaya</b></label>
				<select class="form-select" name="dpsumberbiaya">
					<option value="<?=$pecah['rencana_sumber_biaya']?>"><?=$pecah['rencana_sumber_biaya']?></option>
					<option value="Pendapatan Asli Desa">Pendapatan Asli Desa</option>
					<option value="Dana Desa">Dana Desa</option>
					<option value="Hasil Pajak & Retribusi Daerah Kabupaten / Kota">Hasil Pajak & Retribusi Daerah Kabupaten / Kota</option>
					<option value="Alokasi Dana Desa">Alokasi Dana Desa</option>
					<option value="Bantuan Keuangan Provinsi">Bantuan Keuangan Provinsi</option>
					<option value="Bantuan Keuangan Kabupaten / Kota">Bantuan Keuangan Kabupaten / Kota</option>
					<option value="Pendapatan Lain lain">Pendapatan Lain lain</option>
				</select>
  			</div>
			<div class="mb-3">
    			<label class="form-label"><b>Perkiraan Biaya (Rp)</b></label>
    			<input type="number" min="0" max="99999999999" class="form-control" name="dpperkiraanbiaya" value="<?= $pecah['perkiraan_biaya']?>" required>
  			</div>
			<div class="mb-3">
				<label class="form-label"><b class="bold">Keterangan</b></label>
				<textarea class="form-control" name="dpketerangan" rows="4" cols="50" style="resize: none;" required><?= $pecah['keterangan']?></textarea>
    			<!-- <input type="text" class="form-control" name="dpdketerangan" id="dpdketerangan" style="background: #efefef; pointer-events: none;"> -->
  			</div>
  			<div class="mb-3">
    			<label class="form-label"><b>Bidang</b></label>
    			<select class="form-select" name="dpbidang">
					<option value="<?=$pecah['bidang_perencanaan']?>"><?=$pecah['bidang_perencanaan']?></option>
					<option value="Penyelenggaraan pemerintahan desa">Penyelenggaraan pemerintahan desa</option>
					<option value="Pelaksanaan pembangunan desa">Pelaksanaan pembangunan desa</option>
					<option value="Pembinaan kemasyarakatan">Pembinaan kemasyarakatan</option>
					<option value="Pemberdayaan masyarakat">Pemberdayaan masyarakat</option>
					<option value="Tidak terduga">Tidak terduga</option>
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
	  <form method="POST" action="detail/proses_detail/proses_detail_dpr.php?kode_perencanaan=<?php echo $kode_perencanaan ?>">
      <input type="hidden" name="dpkode" value="<?=$pecah['kode_detail_perencanaan']?>">
	  <div class="modal-body">

	  		<h6 class="text-danger">*Semua data lain yang memiliki kaitan dengan dengan data ini akan dihapus !</h6><br>
			
			<h5 class="text-center">Data ini akan dihapus ?<br>
				<span class="text-danger"><?= $pecah['kode_detail_perencanaan']?> - <?=$pecah['aset_perencanaan']?></span>
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
        <h5 class="modal-title" class="text-danger" id="staticBackdropLabel">Detail Barang</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
	  <div class="modal-body">
	  		<h6><b>Kode - Nama Barang: </b></h6>
			<h5 class="ddpd"><?=$pecah['kode_detail_perencanaan']." - ".$pecah['aset_perencanaan']?></h5>
			<hr>
			<h6><b>Jenis Kegiatan : </b></h6>
			<h5 class="ddpd"><?=$pecah['jenis_kegiatan_rencana']?></h5>
			<hr>
			<h6><b>Jenis Barang : </b></h6>
			<h5 class="ddpd"><?=$pecah['kode_jenis']." - ".$pecah['nama_kelompok']?></h5>
			<hr>
			<h6><b>Bidang : </b></h6>
			<h5 class="ddpd"><?=$pecah['bidang_perencanaan']?></h5>
			<hr>
			<h6><b>Lokasi : </b></h6>
			<h5 class="ddpd"><?=$pecah['rencana_lokasi']?></h5>
			<hr>
			<h6><b>Jumlah : </b></h6>
			<h5 class="ddpd"><?= $pecah['perkiraan_volume']." ".$pecah['rencana_satuan_volume']?></h5>
			<hr>
			<h6><b>Sumber Biaya : </b></h6>
			<h5 class="ddpd"><?=$pecah['rencana_sumber_biaya']?></h5>
			<hr>
			<h6><b>Perkiraan Biaya : </b></h6>
			<h5 class="ddpd"><?= "Rp ".$pecah['perkiraan_biaya']." ,-"?></h5>
			<hr>
			<h6><b>Keterangan : </b></h6>
			<h5 class="ddpd"><?=$pecah['keterangan']?></h5>
			<hr>
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
	  <form method="POST" action="detail/proses_detail/proses_detail_dpr.php">
      <div class="modal-body">
	  		<input type="hidden" name="dpkode_perencanaan" value="<?=$kode_perencanaan?>">
  			<div class="mb-3">
    			<label class="form-label"><b>Nama Barang</b></label>
    			<input type="text" class="form-control" name="dpnamabarang" required>
  			</div>
			<div class="mb-3">
    			<label class="form-label"><b>Jenis Kegiatan</b></label>
    			<input type="text" class="form-control" name="dpjeniskegiatan" required>
  			</div>
			<div class="mb-3">
				<label class="form-label"><b>Jenis Barang</b></label>
    			<select class="ch" name="dpjenisbarang">
					<?php
						$jenis_b = $con->query("SELECT * FROM jenis_barang");
						while($data_jb=$jenis_b->fetch_assoc()){
					?>
					<option value="<?= $data_jb['kode_jenis']?>"><?= $data_jb['kode_jenis']." - ".$data_jb['nama_kelompok']?></option>
					<?php } ?>
				</select>
  			</div>
			<div class="mb-3">
    			<label class="form-label"><b>Lokasi</b></label>
    			<input type="text" class="form-control" name="dplokasi" required>
  			</div>
			<div class="mb-3">
    			<label class="form-label"><b>Volume</b></label>
    			<input type="number" min="0" max="2147483647" class="form-control" name="dpvolume" required>
  			</div>
			<div class="mb-3">
    			<label class="form-label"><b>Satuan</b></label>
    			<input type="text" class="form-control" name="dpsatuan" required>
  			</div>
			<div class="mb-3">
    			<label class="form-label"><b>Sumber Biaya</b></label>
				<select class="form-select" name="dpsumberbiaya">
					<option value="Pendapatan Asli Desa">Pendapatan Asli Desa</option>
					<option value="Dana Desa">Dana Desa</option>
					<option value="Hasil Pajak & Retribusi Daerah Kabupaten / Kota">Hasil Pajak & Retribusi Daerah Kabupaten / Kota</option>
					<option value="Alokasi Dana Desa">Alokasi Dana Desa</option>
					<option value="Bantuan Keuangan Provinsi">Bantuan Keuangan Provinsi</option>
					<option value="Bantuan Keuangan Kabupaten / Kota">Bantuan Keuangan Kabupaten / Kota</option>
					<option value="Pendapatan Lain lain">Pendapatan Lain lain</option>
				</select>
  			</div>
			<div class="mb-3">
    			<label class="form-label"><b>Perkiraan Biaya (Rp)</b></label>
    			<input type="number" min="0" max="99999999999" class="form-control" name="dpperkiraanbiaya" required>
  			</div>
			<div class="mb-3">
				<label class="form-label"><b class="bold">Keterangan</b></label>
				<textarea class="form-control" name="dpketerangan" rows="4" cols="50" style="resize: none;" required></textarea>
  			</div>
  			<div class="mb-3">
    			<label class="form-label"><b>Bidang</b></label>
    			<select class="form-select" name="dpbidang">
					<option value="Penyelenggaraan pemerintahan desa">Penyelenggaraan pemerintahan desa</option>
					<option value="Pelaksanaan pembangunan desa">Pelaksanaan pembangunan desa</option>
					<option value="Pembinaan kemasyarakatan">Pembinaan kemasyarakatan</option>
					<option value="Pemberdayaan masyarakat">Pemberdayaan masyarakat</option>
					<option value="Tidak terduga">Tidak terduga</option>
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