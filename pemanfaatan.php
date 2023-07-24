<div class="lingkaran">
    <center><h3 class="judul">Daftar Pemanfaatan</h3></center>
</div>
<div class="container">
	<!-- <a href="menu.php?page=tambah_inventaris" class="btn btn-primary" style="margin-bottom: 3%; font-size: 15px; border-radius: 10px; width: 15%"><i class="bi bi-plus-circle"></i>Tambah Data</a> -->
    <!-- Button trigger modal edit pemanfaatan -->
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalTambah" style="margin-bottom: 3%; font-size: 15px; border-radius: 10px; width: 15%">
		<i class="bi bi-plus-circle"></i>Tambah Data
    </button>
    <a href="../aset/cetak/cetak_invetaris.php" target="_blank" class="btn btn-success" style="margin-bottom: 3%; font-size: 15px; border-radius: 10px; width: 15%" value="val"><i class="bi bi-printer"></i>Cetak</a>
    <table class="table table-sm" cellspacing="0" width="100%" id="table" style="margin-top: 20px;">
	<thead>
		<tr>
			<th><center>No.</center></th>
			<th><center>Kode</center></th>
			<th><center>Nama Partner</center></th>
			<th><center>No Telp</center></th>
			<th><center>No Perdes</center></th>
			<th><center>Tahun Perdes</center></th>
            <th><center>Tanggal Terbit Perdes</center></th>
			<th style="width: 15%"></th>
		</tr>
	</thead>
	<tbody>
        <?php include ('koneksi.php');?>
		<?php $nomor=1;?>

		<?php $ambil=$con->query("SELECT*FROM pemanfaatan");?>
		<?php while($pecah=$ambil->fetch_assoc()){?>
		<tr>
			<td><center><?php echo $nomor++;?></center></td>
			<td><center><?php echo $pecah['kode_pemanfaatan']?></center></td>
			<td><center><?php echo $pecah['nama_partner']?></center></td>
			<td><center><?php echo $pecah['no_telp']?></center></td>
			<td><center><?php echo $pecah['no_perdes']?></center></td>
            <td><center><?php echo $pecah['tahun_perdes']?></center></td>
			<td><center><?php echo date('d/m/Y', strtotime($pecah['tanggal_terbit_perdes']))?></center></td>
			<td><center>
				<!-- Button trigger modal edit pemanfaatan -->
				<button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#modalEdit<?=$nomor?>" data-toggle="tooltip" data-placement="top" title="Edit">
					<i class="bi bi-pencil"></i>
				</button>
				<!-- Button trigger modal hapus pemanfaatan -->
				<button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#modalHapus<?=$nomor?>" data-toggle="tooltip" data-placement="top" title="Hapus">
					<i class="bi bi-trash"></i>
				</button>
				<!-- Button trigger modal detail pemanfaatan -->
				<a href="menu.php?page=detail_pemanfaatan&kode_pemanfaatan=<?php echo $pecah['kode_pemanfaatan'];?>" class= "btn btn-success" data-toggle="tooltip" data-placement="top" title="Detail"><i class="bi bi-card-list"></i></a>
			</td></center>
		</tr>

<!-- Awal Modal Edit Pemanfaatan-->
<div class="modal fade modal-lg" id="modalEdit<?=$nomor?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="staticBackdropLabel">Edit Pemanfatan</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
	  <form method="POST" action="transaksi/proses_transaksi/proses_pemanfaatan.php">
      <div class="modal-body">
			<input type="hidden" name="ein_kode" value="<?=$pecah['kode_pemanfaatan']?>">
			<div class="mb-3">
    			<label class="form-label"><b>No Perdes</b></label>
    			<input type="text" class="form-control" name="eno_perdes" value="<?=$pecah['no_perdes']?>" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" maxlength="5" required>
  			</div>
			<div class="mb-3">
    			<label class="form-label"><b>Tahun Perdes</b></label>
				<input type="text" class="form-control" name="etahun_perdes" value="<?=$pecah['tahun_perdes']?>" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" maxlength="4" required>
			</div>
            <div class="mb-3">
				<label class="form-label"><b class="bold">Tanggal Perdes</b></label>
                <input type="date" class="form-control" name="etgl_perdes" value="<?=$pecah['tanggal_terbit_perdes']?>" required>
            </div>
      	</div>
		<div class="modal-body">
			<input type="hidden" name="ein_kode" value="<?=$pecah['kode_pemanfaatan']?>">
			<div class="mb-3">
    			<label class="form-label"><b>Nama Partner</b></label>
    			<input type="text" class="form-control" name="enama_partner" value="<?=$pecah['nama_partner']?>" required>
  			</div>
			<div class="mb-3">
    			<label class="form-label"><b>Nomor Telpon</b></label>
				<input type="text" class="form-control" name="enotelp_partner" value="<?=$pecah['no_telp']?>" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" maxlength="13" required>
			</div>
            <div class="mb-3">
				<label class="form-label"><b class="bold">Email</b></label>
                <input type="text" class="form-control" name="eemail_partner" value="<?=$pecah['email']?>" required>
            </div>
			<div class="mb-3">
				<label class="form-label"><b class="bold">Alamat</b></label>
				<textarea class="form-control" name="ealamat_partner" rows="4" cols="50" style="resize: none;" required><?= $pecah['alamat']?></textarea>
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
<!--  Akhir Modal Edit Pemanfaatan-->

<!-- Awal Modal Hapus Pemanfaatan-->
<div class="modal fade" id="modalHapus<?=$nomor?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  				<div class="modal-dialog">
    				<div class="modal-content">
      					<div class="modal-header">
        					<h5 class="modal-title" id="staticBackdropLabel">Konfirmasi !</h5>
        					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      					</div>
	  					<form method="POST" action="transaksi/proses_transaksi/proses_pemanfaatan.php">
      						<input type="hidden" name="kode_pemanfaatan" value="<?=$pecah['kode_pemanfaatan']?>">
	  						<div class="modal-body">

							  <h6 class="text-danger">*Semua data lain yang memiliki kaitan dengan dengan data ini akan dihapus !</h6><br>
			
								<h5 class="text-center">Data ini akan dihapus ?<br>
									<span class="text-danger"><?= $pecah['kode_pemanfaatan']." - ".$pecah['nama_partner']." - ".$pecah['tahun_perdes']?></span>
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
<!--  Akhir Modal Hapus Pemanfaatan-->

<?php }?>

	</tbody>
</table>

<!-- Awal Modal Tambah Pemanfaatan-->
<div class="modal fade modal-lg" id="modalTambah" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="staticBackdropLabel">Tambah Pemanfatan</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
	  <form method="POST" action="transaksi/proses_transaksi/proses_pemanfaatan.php" enctype="multipart/form-data">
      <div class="modal-body">
	  	<div class="mb-3">
            <label class="form-label"><b>No Perdes</b></label>
            <input type="text" class="form-control" name="no_perdes" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" maxlength="5" required>
        </div>
		<table style="width: 100%">
			<tr>
				<td style="width: 50%">
				<div class="mb-3">
					<label class="form-label"><b>Tahun Perdes</b></label>
					<input type="text" class="form-control" name="tahun_perdes" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" maxlength="4" required>
				</div>
				</td>
				<td>
				<div class="mb-3">
					<label class="form-label"><b>Tanggal Terbit Perdes</b></label>
					<input type="date" class="form-control" name="tgl_terbit_perdes" required>
				</div>
				</td>
			</tr>
		</table>
		</div>
		<div class="modal-body">
		<div class="mb-3">
            <label class="form-label"><b>Nama Partner/Peminjam/Penyewa</b></label>
            <input type="text" class="form-control" name="nama_partner" required>
        </div>
		<table style="width:100%">
			<tr>
				<td>
				<div class="mb-3">
					<label class="form-label"><b>No Telepon</b></label>
					<input type="text" class="form-control" name="notelp_partner" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" maxlength="13" required>
				</div>
				</td>
				<td>
				<div class="mb-3">
					<label class="form-label"><b>Email</b></label>
					<input type="text" class="form-control" name="email_partner" required>
				</div>
				</td>
			</tr>
		</table>
        <div class="mb-3">
            <label class="form-label"><b>Alamat</b></label>
            <textarea class="form-control" name="alamat_partner" rows="4" cols="50" style="resize: none;" required></textarea>
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
<!--  Akhir Modal Tambah Pemanfaatan-->

</div>