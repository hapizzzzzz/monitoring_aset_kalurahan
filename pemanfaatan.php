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
    <center><h3 class="judul">Daftar Pemanfaatan</h3></center>
</div>
<div class="container">
    <!-- Button trigger modal edit pemanfaatan -->
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalTambah" style="margin-bottom: 3%; font-size: 15px; border-radius: 10px; width: 15%">
		<i class="bi bi-plus-circle"></i>Tambah Data
    </button>
	<!-- Button trigger riwayat pemanfaatan -->
	<a href="menu.php?page=riwayat_pemanfaatan" class="btn btn-success" style="margin-bottom: 3%; font-size: 15px; border-radius: 10px; width: 15%"><i class="bi bi-card-list"></i>Riwayat</a>
    <!-- Button trigger modal cetak Pemanfaatan -->
	<button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modalCetak" style="margin-bottom: 3%; font-size: 15px; border-radius: 10px; width: 15%">
		<i class="bi bi-printer"></i>Cetak
	</button>
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
			<th><center>Tahun</center></th>
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
			<td><center><?php echo $pecah['tahun_pemanfaatan']?></center></td>
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
			<!-- <div class="mb-3">
    			<label class="form-label"><b>Tahun Pemanfaatan</b></label>
				<input type="text" class="form-control" name="etahun_pemanfaatan" value="<?php// $pecah['tahun_pemanfaatan']?>" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" maxlength="4" required>
			</div> -->
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
			<div class="mb-3">
				<label class="form-label"><b>Tahun Pemanfaatan</b></label>
				<input type="text" class="form-control" name="tahun_pemanfaatan" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" maxlength="4" required>
			</div>
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

<!-- Awal Modal Cetak Pemanfaatan-->
<div class="modal fade" id="modalCetak" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" class="text-danger" id="staticBackdropLabel">Pilih Tahun Pemanfaatan</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
	  <form method="POST" action="../aset/cetak/cetak_pemanfaatan.php?" target="_blank">
    	<div class="modal-body">
  			<div class="mb-3">
    	  		<select class="ch" name="pilihan_tahun_pemanfaaatan">
					<?php
						$pilih_tahun = $con->query("SELECT DISTINCT tahun_pemanfaatan FROM pemanfaatan");
						while($pilihan_tahun=$pilih_tahun->fetch_assoc()){
					?>
					<option value="<?= $pilihan_tahun['tahun_pemanfaatan']?>"><?= $pilihan_tahun['tahun_pemanfaatan']?></option>
					<?php } ?>
				</select>
  			</div>
       	</div>
       	<div class="modal-footer">
	 		<button type="submit" class="btn btn-success" name="bSimpan">Cetak</button>
        	<button type="button" class="btn btn-warning" data-bs-dismiss="modal">Batal</button>
       	</div>
      </form>
    </div>
  </div>
</div>
<!--  Akhir Modal Cetak Pemanfaatan-->

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