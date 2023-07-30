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
    <center><h3 class="judul">Detail Pemanfaatan</h3></center>
</div>
<div class="container">
	
	<?php

	$kode_pemanfaatan = $_GET['kode_pemanfaatan'];
	$pemanfaatan = $con->query("SELECT*FROM pemanfaatan WHERE kode_pemanfaatan = '$kode_pemanfaatan'");
	$data_pemanfaatan = $pemanfaatan->fetch_array();

	?>

	<table class="table" style="width:80%">
		<tr>
			<td><h4 class="rincian">Nama : <?php echo $data_pemanfaatan['nama_partner']?></h4></td>
			<td><h4 class="rincian">No Perdes : <?php echo $data_pemanfaatan['no_perdes']?></h4></td>
		</tr>
        <tr>
            <td><h4 class="rincian">No Telp : <?php echo $data_pemanfaatan['no_telp']?></h4></td>
			<td><h4 class="rincian">Tahun Perdes : <?php echo $data_pemanfaatan['tahun_perdes']?></h4></td>
		</tr>
		<tr>
			<td><h4 class="rincian">Email : <?php echo $data_pemanfaatan['email']?></h4></td>
			<td><h4 class="rincian">Tanggal Terbit Perdes : <?php echo date('d/m/Y', strtotime($data_pemanfaatan['tanggal_terbit_perdes']))?></h4></td>
		</tr>
        <tr>
			<td><h4 class="rincian" rowspan="2">Alamat : <?php echo $data_pemanfaatan['alamat']?></h4></td>
		</tr>
	</table>

	<!-- Button trigger modal tambah detail pemanfaatan -->
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
			<th><center>Bentuk Pemanfaatan</center></th>
			<th><center>Jangka Waktu</center></th>
			<th style="width: 20%"></th>
		</tr>
	</thead>
	<tbody>

		<?php $nomor=1;?>
		<?php $ambil=$con->query("SELECT * FROM detail_pemanfaatan JOIN inventaris ON detail_pemanfaatan.kode_inventaris = inventaris.kode_inventaris JOIN detail_pengadaan ON detail_pengadaan.kode_detail_pengadaan = inventaris.kode_detail_pengadaan JOIN detail_perencanaan ON detail_pengadaan.kode_detail_perencanaan = detail_perencanaan.kode_detail_perencanaan WHERE detail_pemanfaatan.kode_pemanfaatan = '$kode_pemanfaatan'"); ?>
		<?php while($pecah=$ambil->fetch_assoc()){?>
		<tr>
			<td><center><?php echo $nomor++;?></center></td>
			<td><center><?php echo $pecah['kode_detail_pemanfaatan']?></center></td>
			<td><center><?php echo $pecah['aset_perencanaan']?></center></td>
			<td><center><?php echo $pecah['jumlah_aset_p'] ." ".$pecah['satuan']?></center></td>
			<td><center><?php echo $pecah['bentuk_pemanfaatan']?></center></td>
			<td><center><?php echo date('d/m/Y', strtotime($pecah['awal_pemanfaatan']))." Sd ".date('d/m/Y', strtotime($pecah['akhir_pemanfaatan']))?></center></td>
			<td><center>
				
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
				<!-- Button trigger modal status -->
				<button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modalStatus<?=$nomor?>" data-toggle="tooltip" data-placement="top" title="Transaksi Selesai">
					<i class="bi bi-check-circle"></i>
				</button>
				
			</td></center>
		</tr>

		<!-- Awal Modal Hapus Detail Pemanfaatan-->
		<div class="modal fade" id="modalHapus<?=$nomor?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  				<div class="modal-dialog">
    				<div class="modal-content">
      					<div class="modal-header">
        					<h5 class="modal-title" id="staticBackdropLabel">Konfirmasi !</h5>
        					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      					</div>
	  					<form method="POST" action="detail/proses_detail/proses_detail_pemanfaatan.php">
						  	<input type="hidden" name="kode_pemanfaatan" value="<?=$kode_pemanfaatan?>">
						  	<input type="hidden" name="kode_dpn" value="<?=$pecah['kode_detail_pemanfaatan']?>">
							<input type="hidden" name="kode_in_dpn" value="<?=$pecah['kode_inventaris']?>">
							<input type="hidden" name="jumlah_dpn" value="<?=$pecah['jumlah_aset_p']?>">
							<input type="hidden" name="hapus_file" value="<?=$pecah['file_pemanfaatan']?>">
	  						<div class="modal-body">
			
								<h5 class="text-center">Data ini akan dihapus ?<br>
									<span class="text-danger"><?= $pecah['kode_detail_pemanfaatan']." - ".$pecah['aset_perencanaan']." ( ".$pecah['jumlah_aset_p']." ".$pecah['satuan']." ) "." - ".$pecah['bentuk_pemanfaatan']?></span>
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
		<!--  Akhir Modal Hapus Detail Pemanfaatan-->

		<!-- Awal Modal Edit Detail Pemanfaatan-->
		<div class="modal fade modal-lg" id="modalEdit<?=$nomor?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
			<div class="modal-header">
				<h1 class="modal-title fs-5" id="staticBackdropLabel">Edit Pemanfaatan</h1>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<form method="POST" action="detail/proses_detail/proses_detail_pemanfaatan.php" enctype="multipart/form-data">
			<div class="modal-body">
				<div class="mb-3">
					<input type="hidden" name="kode_pemanfaatan" value="<?=$kode_pemanfaatan?>">
					<input type="hidden" name="e_kode_detail_pemanfaatan" value="<?=$pecah['kode_detail_pemanfaatan']?>">
					<label class="form-label"><b>Nama Barang</b></label>
					<input type="text" class="form-control" name="dpnamabarang" value="<?=$pecah['aset_perencanaan']." - ".$pecah['jumlah_aset_p']?>" style="background: #efefef; pointer-events: none;">
				</div>
				<div class="mb-3">
					<label class="form-label"><b>Bentuk Pemanfaatan</b></label>
					<select class="form-select" name="e_bentuk_pemanfaatan" style="width:100%">
						<option value="<?= $pecah['bentuk_pemanfaatan']?>"><?= $pecah['bentuk_pemanfaatan']?></option>
						<option value="Sewa">Sewa</option>
						<option value="Pinjam pakai">Pinjam Pakai</option>
						<option value="Kerja sama">Kerja Sama</option>
						<option value="Bangun serah guna / Bangun guna serah">Bangun Serah Guna / Bangun Guna Serah</option>
					</select>
				</div>
				<div class="mb-3">
					<label class="form-label"><b>No Surat Perjanjian</b></label>
					<input type="text" class="form-control" name="e_no_surat_perjanjian" value ="<?= $pecah['no_surat_perjanjian']?>" required>
				</div>
				<div class="mb-3">
					<label class="form-label"><b class="bold">File Pemanfaatan (.pdf)</b></label>
					<input type="file" class="form-control" name="e_file">
				</div>
				<div class="mb-3">
					<label class="form-label"><b>Biaya Kontribusi (Rp)</b></label>
					<input type="number" min="0" max="99999999999" class="form-control" name="e_biaya_kontribusi" value="<?= $pecah['biaya_kontribusi']?>" required>
				</div>
				<div class="mb-3">
					<label class="form-label"><b class="bold">Keterangan</b></label>
					<textarea class="form-control" name="e_keterangan" rows="4" cols="50" style="resize: none;" required><?= $pecah['keterangan_pemanfaatan']?></textarea>
				</div>
				<div class="mb-3">
					<label class="form-label"><b>Awal Jangka Waktu</b></label>
					<input type="date" class="form-control" name="e_awal_periode_pemanfaatan" value="<?= $pecah['awal_pemanfaatan']?>" required>
				</div>
				<div class="mb-3">
					<label class="form-label"><b>Akhir Jangka Waktu</b></label>
					<input type="date" class="form-control" name="e_akhir_periode_pemanfaatan" value="<?= $pecah['akhir_pemanfaatan']?>" required>
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
		<!--  Akhir Modal Edit Detail Pemanfaatan-->

		<!-- Awal Modal Rincian Pemanfaatan-->
		<div class="modal fade" id="modalrincian<?=$nomor?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" class="text-danger" id="staticBackdropLabel">Detail Pemanfaatan</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
				<h6><b>Kode Pengadaan / Perolehan : </b></h6>
				<h5 class="ddpd"><?=$pecah['kode_detail_pengadaan']?></h5>
				<hr>
				<h6><b>Kode Inventaris : </b></h6>
				<h5 class="ddpd"><?=$pecah['kode_inventaris']?></h5>
				<hr>
				<h6><b>Nama Aset : </b></h6>
				<h5 class="ddpd"><?=$pecah['aset_perencanaan']?></h5>
				<hr>
				<h6><b>Jumlah : </b></h6>
				<h5 class="ddpd"><?=$pecah['jumlah_aset_p']?></h5>
				<hr>
				<h6><b>Bentuk Pemanfaatan : </b></h6>
				<h5 class="ddpd"><?=$pecah['bentuk_pemanfaatan']?></h5>
				<hr>
				<h6><b>Biaya Kontribusi : </b></h6>
				<h5 class="ddpd"><?=$pecah['biaya_kontribusi'];?></h5>
				<hr>
				<h6><b>Jangka Waktu : </b></h6>
				<h5 class="ddpd"><?=date('d/m/Y', strtotime($pecah['awal_pemanfaatan']))." Sd ".date('d/m/Y', strtotime($pecah['akhir_pemanfaatan']))?></h5>
				<hr>
				<h6><b>Keterangan : </b></h6>
				<h5 class="ddpd"><?=$pecah['keterangan_pemanfaatan']?></h5>
				<hr>
				<h6><b>No Surat Perjanjian : </b></h6>
				<h5 class="ddpd"><?=$pecah['no_surat_perjanjian']?></h5>
				<hr>
				<h6><b>File Surat Perjanjian : </b></h6>
				<a href='file_pemanfaatan/<?=$pecah['file_pemanfaatan']?>' download><?= $pecah['file_pemanfaatan']?></a>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-success" data-bs-dismiss="modal">OK</button>
			</div>
			</form>
			</div>
		</div>
		</div>
		<!--  Akhir Modal Rincian Pemanfaatan-->

		<?php }?>

		<?php $ambil_tp=$con->query("SELECT * FROM detail_pemanfaatan JOIN inventaris ON detail_pemanfaatan.kode_inventaris = inventaris.kode_inventaris JOIN detail_pengadaan_tp ON detail_pengadaan_tp.kode_detail_pengadaan_tp = inventaris.kode_detail_pengadaan WHERE detail_pemanfaatan.kode_pemanfaatan = '$kode_pemanfaatan'"); ?>
		<?php while($pecah_tp=$ambil_tp->fetch_assoc()){?>
		<tr>
			<td><center><?php echo $nomor++;?></center></td>
			<td><center><?php echo $pecah_tp['kode_detail_pemanfaatan']?></center></td>
			<td><center><?php echo $pecah_tp['nama_barang_tp']?></center></td>
			<td><center><?php echo $pecah_tp['jumlah_aset_p'] ." ".$pecah_tp['satuan']?></center></td>
			<td><center><?php echo $pecah_tp['bentuk_pemanfaatan']?></center></td>
			<td><center><?php echo date('d/m/Y', strtotime($pecah_tp['awal_pemanfaatan']))." Sd ".date('d/m/Y', strtotime($pecah_tp['akhir_pemanfaatan']))?></center></td>
			<td><center>
				
				<!-- Button trigger modal hapus barang -->
				<button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#modalHapusTP<?=$nomor?>" data-toggle="tooltip" data-placement="top" title="Hapus">
					<i class="bi bi-trash"></i>
				</button>
				<!-- Button trigger modal edit barang -->
				<button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#modalEditTP<?=$nomor?>" data-toggle="tooltip" data-placement="top" title="Edit">
					<i class="bi bi-pencil"></i>
				</button>
				<!-- Button trigger modal rincian barang -->
				<button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modalrincianTP<?=$nomor?>" data-toggle="tooltip" data-placement="top" title="Rincian">
					<i class="bi bi-card-list"></i>
				</button>
				<!-- Button trigger modal status -->
				<button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modalStatus<?=$nomor?>" data-toggle="tooltip" data-placement="top" title="Transaksi Selesai">
					<i class="bi bi-check-circle"></i>
				</button>
				
				
			</td></center>
		</tr>

		<!-- Awal Modal Hapus Detail Pemanfaatan TP-->
		<div class="modal fade" id="modalHapusTP<?=$nomor?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  				<div class="modal-dialog">
    				<div class="modal-content">
      					<div class="modal-header">
        					<h5 class="modal-title" id="staticBackdropLabel">Konfirmasi !</h5>
        					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      					</div>
	  					<form method="POST" action="detail/proses_detail/proses_detail_pemanfaatan.php">

						  	<input type="hidden" name="kode_pemanfaatan" value="<?=$kode_pemanfaatan?>">
							<input type="hidden" name="kode_dpntp" value="<?=$pecah_tp['kode_detail_pemanfaatan']?>">
						  	<input type="hidden" name="kode_in_dpntp" value="<?=$pecah_tp['kode_inventaris']?>">
							<input type="hidden" name="jumlah_dpntp" value="<?=$pecah_tp['jumlah_aset_p']?>">
							<input type="hidden" name="hapus_filetp" value="<?=$pecah_tp['file_pemanfaatan']?>">
	  						<div class="modal-body">
			
								<h5 class="text-center">Data ini akan dihapus ?<br>
									<span class="text-danger"><?= $pecah_tp['kode_detail_pemanfaatan']." - ".$pecah_tp['nama_barang_tp']." ( ".$pecah_tp['jumlah_aset_p']." ".$pecah_tp['satuan']." ) "." - ".$pecah_tp['bentuk_pemanfaatan']?></span>
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
		<!--  Akhir Modal Hapus Detail Pemanfaatan TP-->

		<!-- Awal Modal Edit Detail Pemanfaatan TP-->
		<div class="modal fade modal-lg" id="modalEditTP<?=$nomor?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
			<div class="modal-header">
				<h1 class="modal-title fs-5" id="staticBackdropLabel">Edit Pemanfaatan</h1>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<form method="POST" action="detail/proses_detail/proses_detail_pemanfaatan.php" enctype="multipart/form-data">
			<div class="modal-body">
				<div class="mb-3">
					<input type="hidden" name="kode_pemanfaatan" value="<?=$kode_pemanfaatan?>">
					<input type="hidden" name="e_kode_detail_pemanfaatan_tp" value="<?=$pecah_tp['kode_detail_pemanfaatan']?>">
					<label class="form-label"><b>Nama Barang</b></label>
					<input type="text" class="form-control" value="<?=$pecah_tp['nama_barang_tp']." - ".$pecah_tp['jumlah_aset_p']?>" style="background: #efefef; pointer-events: none;">
				</div>
				<div class="mb-3">
					<label class="form-label"><b>Bentuk Pemanfaatan</b></label>
					<select class="form-select" name="e_bentuk_pemanfaatan_tp" style="width:100%">
						<option value="<?= $pecah_tp['bentuk_pemanfaatan']?>"><?= $pecah_tp['bentuk_pemanfaatan']?></option>
						<option value="Sewa">Sewa</option>
						<option value="Pinjam pakai">Pinjam Pakai</option>
						<option value="Kerja sama">Kerja Sama</option>
						<option value="Bangun serah guna / Bangun guna serah">Bangun Serah Guna / Bangun Guna Serah</option>
					</select>
				</div>
				<div class="mb-3">
					<label class="form-label"><b>No Surat Perjanjian</b></label>
					<input type="text" class="form-control" name="e_no_surat_perjanjian_tp" value ="<?= $pecah_tp['no_surat_perjanjian']?>" required>
				</div>
				<div class="mb-3">
					<label class="form-label"><b class="bold">File Pemanfaatan (.pdf)</b></label>
					<input type="file" class="form-control" name="e_file_tp">
				</div>
				<div class="mb-3">
					<label class="form-label"><b>Biaya Kontribusi (Rp)</b></label>
					<input type="number" min="0" max="99999999999" class="form-control" name="e_biaya_kontribusi_tp" value="<?= $pecah_tp['biaya_kontribusi']?>" required>
				</div>
				<div class="mb-3">
					<label class="form-label"><b class="bold">Keterangan</b></label>
					<textarea class="form-control" name="e_keterangan_tp" rows="4" cols="50" style="resize: none;" required><?= $pecah_tp['keterangan_pemanfaatan']?></textarea>
				</div>
				<div class="mb-3">
					<label class="form-label"><b>Awal Jangka Waktu</b></label>
					<input type="date" class="form-control" name="e_awal_periode_pemanfaatan_tp" value="<?= $pecah_tp['awal_pemanfaatan']?>" required>
				</div>
				<div class="mb-3">
					<label class="form-label"><b>Akhir Jangka Waktu</b></label>
					<input type="date" class="form-control" name="e_akhir_periode_pemanfaatan_tp" value="<?= $pecah_tp['akhir_pemanfaatan']?>" required>
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
		<!--  Akhir Modal Edit Detail Pemanfaatan TP-->

		<!-- Awal Modal Rincian Detail Pemanfaatan TP-->
		<div class="modal fade" id="modalrincianTP<?=$nomor?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" class="text-danger" id="staticBackdropLabel">Rincian Pemanfaatan</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
					<h6><b>Kode Pengadaan / Perolehan : </b></h6>
					<h5 class="ddpd"><?=$pecah_tp['kode_detail_pengadaan']?></h5>
					<hr>
					<h6><b>Kode Inventaris : </b></h6>
					<h5 class="ddpd"><?=$pecah_tp['kode_inventaris']?></h5>
					<hr>
					<h6><b>Nama Aset : </b></h6>
					<h5 class="ddpd"><?=$pecah_tp['nama_barang_tp']?></h5>
					<hr>
					<h6><b>Jumlah : </b></h6>
					<h5 class="ddpd"><?=$pecah_tp['jumlah_aset_p']?></h5>
					<hr>
					<h6><b>Bentuk Pemanfaatan : </b></h6>
					<h5 class="ddpd"><?=$pecah_tp['bentuk_pemanfaatan']?></h5>
					<hr>
					<h6><b>Biaya Kontribusi : </b></h6>
					<h5 class="ddpd"><?=$pecah_tp['biaya_kontribusi'];?></h5>
					<hr>
					<h6><b>Jangka Waktu : </b></h6>
					<h5 class="ddpd"><?=date('d/m/Y', strtotime($pecah_tp['awal_pemanfaatan']))." Sd ".date('d/m/Y', strtotime($pecah_tp['akhir_pemanfaatan']))?></h5>
					<hr>
					<h6><b>Keterangan : </b></h6>
					<h5 class="ddpd"><?=$pecah_tp['keterangan_pemanfaatan']?></h5>
					<hr>
					<h6><b>No Surat Perjanjian : </b></h6>
					<h5 class="ddpd"><?=$pecah_tp['no_surat_perjanjian']?></h5>
					<hr>
					<h6><b>File Surat Perjanjian : </b></h6>
					<a href='file_pemanfaatan/<?=$pecah_tp['file_pemanfaatan']?>' download><?= $pecah_tp['file_pemanfaatan']?></a>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-success" data-bs-dismiss="modal">OK</button>
			</div>
			</form>
			</div>
		</div>
		</div>
		<!--  Akhir Modal Rincian Detail Pemanfaatan TP-->
		
		<?php }?>

	</tbody>
	</table>

	<!-- Awal Modal Tambah detail pemanfaatan-->
	<div class="modal fade modal-lg" id="modalTambah" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
		<div class="modal-header">
			<h1 class="modal-title fs-5" id="staticBackdropLabel">Tambah Pemanfaatan</h1>
			<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
		</div>
		<form method="POST" action="detail/proses_detail/proses_detail_pemanfaatan.php" enctype="multipart/form-data">
		<div class="modal-body">
				<div class="mb-3">
					<input type="hidden" name="kode_pemanfaatan" value="<?=$kode_pemanfaatan?>">
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
					<label class="form-label"><b>Jumlah</b></label>
					<table style="width:100%">
						<tr>
							<td><input type="number" min="0" max="2147483647" class="form-control" name="jumlah_pn" id="jumlah_pn" style="width: 100%;" required><td>
							<td><input type="text" class="form-control" id="satuan_pn" style="width: 100%; background: #efefef; pointer-events: none;" required><td>
						</tr>
					</table>
				</div>
				<div class="mb-3">
					<tr>
						<td style="width: 50%">
							<label class="form-label"><b>Bentuk Pemanfaatan</b></label>
							<select class="form-select" name="bentuk_pemanfaatan" style="width:100%">
								<option value="Sewa">Sewa</option>
								<option value="Pinjam pakai">Pinjam Pakai</option>
								<option value="Kerja sama">Kerja Sama</option>
								<option value="Bangun serah guna / Bangun guna serah">Bangun Serah Guna / Bangun Guna Serah</option>
							</select>
						</td>
					</tr>
				</div>
				<div class="mb-3">
					<label class="form-label"><b>No Surat Perjanjian</b></label>
					<input type="text" class="form-control" name="no_surat_perjanjian" id="no_surat_perjanjian" style="width: 100%;" maxlength="50" required><td>
				</div>
				<div class="mb-3">
					<label class="form-label"><b class="bold">File Pemanfaatan (.pdf)</b></label>
					<input type="file" class="form-control" name="file" required>
				</div>
				<div class="mb-3">
					<label class="form-label"><b class="bold">Biaya Kontribusi (Rp)</b></label>
					<input type="number" min="0" class="form-control" name="biaya" id="biaya" style="width: 100%;" required>
				</div>
				<div class="mb-3">
					<label class="form-label"><b class="bold">Keterangan</b></label>
					<textarea class="form-control" name="keterangan_pn" id="keterangan_pn" rows="4" cols="50" style="resize: none;" required></textarea>
  				</div>
				<div class="mb-3">
					<table style="width: 100%">
						<tr>
							<td>
								<label class="form-label"><b>Awal Jangka Waktu</b></label>
								<input type="date" class="form-control" name="awal_periode_pemanfaatan" required>
							</td>
							<td>
								<label class="form-label"><b>Akhir Jangka Waktu</b></label>
								<input type="date" class="form-control" name="akhir_periode_pemanfaatan" required>
							</td>
						</tr>
					</table>
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
			$('#jumlah_pn').val("");
			$('#satuan_pn').val("");
		} else {
		$.ajax({
			url :"detail/data_detail_pemanfaatan.php",
			method :"POST",
			data : {'kode':kode},
			dataType : "json",
			success:function(data){

				if(data){
					$('#jumlah_pn').val(data.jumlah_kuota);
					$('#satuan_pn').val(data.satuan);
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