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
    <center><h3 class="judul">Daftar Penghapusan</h3></center>
</div>
<div class="container">
    <!-- Button trigger modal tambah Penghapusan -->
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalTambah" style="margin-bottom: 3%; font-size: 15px; border-radius: 10px; width: 15%">
		<i class="bi bi-plus-circle"></i>Tambah Data
    </button>
	<!-- Button trigger modal cetak Penghapusan -->
	<button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modalCetak" style="margin-bottom: 3%; font-size: 15px; border-radius: 10px; width: 15%">
		<i class="bi bi-printer"></i>Cetak
	</button>
    <table class="table table-sm" cellspacing="0" width="100%" id="table" style="margin-top: 20px;">
	<thead>
		<tr>
			<th><center>No.</center></th>
			<th><center>Kode</center></th>
			<th><center>No B.A</center></th>
			<th><center>Tahun B.A</center></th>
			<th><center>Tanggal B.A</center></th>
			<th><center>Nomor Keputusan</center></th>
            <th><center>Tahun Keputusan</center></th>
			<th><center>File Penghapusan</center></th>
			<th style="width: 15%"></th>
		</tr>
	</thead>
	<tbody>
        <?php include ('koneksi.php');?>
		<?php $nomor=1;?>

		<?php $ambil=$con->query("SELECT*FROM penghapusan");?>
		<?php while($pecah=$ambil->fetch_assoc()){?>
		<tr>
			<td><center><?php echo $nomor++;?></center></td>
			<td><center><?php echo $pecah['kode_penghapusan']?></center></td>
			<td><center><?php echo $pecah['no_berita_acara']?></center></td>
			<td><center><?php echo $pecah['tahun_berita_acara']?></center></td>
			<td><center><?php echo date('d/m/Y', strtotime($pecah['tanggal_berita_acara']))?></center></td>
            <td><center><?php echo $pecah['nomor_keputusan']?></center></td>
			<td><center><?php echo $pecah['tahun_keputusan']?></center></td>
			<td><center><a href='file_penghapusan/<?=$pecah['file_penghapusan']?>' download><?= $pecah['file_penghapusan']?></a></center></td>
			<td><center>
				<!-- Button trigger modal edit penghapusan -->
				<button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#modalEdit<?=$nomor?>" data-toggle="tooltip" data-placement="top" title="Edit">
					<i class="bi bi-pencil"></i>
				</button>
				<!-- Button trigger modal hapus penghapusan -->
				<button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#modalHapus<?=$nomor?>" data-toggle="tooltip" data-placement="top" title="Hapus">
					<i class="bi bi-trash"></i>
				</button>
				<!-- Button trigger modal detail penghapusan -->
				<a href="menu.php?page=detail_penghapusan&kode_penghapusan=<?php echo $pecah['kode_penghapusan'];?>" class= "btn btn-success" data-toggle="tooltip" data-placement="top" title="Detail"><i class="bi bi-card-list"></i></a>
			</td></center>
		</tr>

<!-- Awal Modal Edit Penghapusan-->
<div class="modal fade modal-lg" id="modalEdit<?=$nomor?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="staticBackdropLabel">Edit Penghapusan</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
	  <form method="POST" action="transaksi/proses_transaksi/proses_penghapusan.php" enctype="multipart/form-data">
      <div class="modal-body">
			<input type="hidden" name="kode_penghapusan" value="<?=$pecah['kode_penghapusan']?>">
			<input type="hidden" name="file_penghapusan" value="<?=$pecah['file_penghapusan']?>">
      	</div>
		<div class="modal-body">
			<div class="mb-3">
    			<label class="form-label"><b>No Keputusan</b></label>
    			<input type="text" class="form-control" name="no_keputusan" value="<?=$pecah['nomor_keputusan']?>" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" maxlength="2" required>
  			</div>
			<div class="mb-3">
    			<label class="form-label"><b>Tahun Keputusan</b></label>
				<input type="text" class="form-control" name="tahun_keputusan" value="<?=$pecah['tahun_keputusan']?>" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" maxlength="4" required>
			</div>
            <div class="mb-3">
				<label class="form-label"><b class="bold">File Penghapusan (.pdf)</b></label>
				<input type="file" class="form-control" name="e_file">
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
<!--  Akhir Modal Edit Penghapusan-->

<!-- Awal Modal Hapus Penghapusan-->
<div class="modal fade" id="modalHapus<?=$nomor?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  				<div class="modal-dialog">
    				<div class="modal-content">
      					<div class="modal-header">
        					<h5 class="modal-title" id="staticBackdropLabel">Konfirmasi !</h5>
        					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      					</div>
	  					<form method="POST" action="transaksi/proses_transaksi/proses_penghapusan.php">
      						<input type="hidden" name="kode_penghapusan" value="<?=$pecah['kode_penghapusan']?>">
                            <input type="hidden" name="hfile" value="<?=$pecah['file_penghapusan']?>">
                            <div class="modal-body">
                                <div class="text-danger"><h5 class="text-center">Data ini akan dihapus ?</h5></div>
                                <hr>

                                <h6><b>Kode : </b></h6>
                                <h5 class="ddpd"><?=$pecah['kode_penghapusan']?></h5>
                                <hr>
                                <h6><b>No Berita Acara : </b></h6>
                                <h5 class="ddpd"><?=$pecah['no_berita_acara']?></h5>
                                <hr>
                                <h6><b>Tanggal Berita Acara : </b></h6>
                                <h5 class="ddpd"><?=date('d/m/Y', strtotime($pecah['tanggal_berita_acara']))?></h5>
                                <hr>
                                <h6><b>Tahun Berita Acara : </b></h6>
                                <h5 class="ddpd"><?=$pecah['tahun_berita_acara']?></h5>
                            </div>
      						<div class="modal-footer">
								<button type="submit" class="btn btn-primary" name="bHapus">Yakin</button>
        						<button type="button" class="btn btn-warning" data-bs-dismiss="modal">Batal</button>
      						</div>
						</form>
    				</div>
  				</div>
			</div>
<!--  Akhir Modal Hapus Penghapusan-->

<?php }?>

	</tbody>
</table>

<!-- Awal Modal Tambah Penghapusan-->
<div class="modal fade modal-lg" id="modalTambah" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="staticBackdropLabel">Tambah Penghapusan</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
	  <form method="POST" action="transaksi/proses_transaksi/proses_penghapusan.php" enctype="multipart/form-data">
      	<div class="modal-body">
			<div class="mb-3">
				<label class="form-label"><b>No Berita Acara</b></label>
				<input type="text" class="form-control" name="no_berita_acara" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" maxlength="2" required>
			</div>
			<table style="width: 100%">
				<tr>
					<td style="width: 50%">
						<div class="mb-3">
							<label class="form-label"><b>Tahun Berita Acara</b></label>
							<input type="text" class="form-control" name="tahun_berita_acara" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" maxlength="4" required>
						</div>
					</td>
					<td>
						<div class="mb-3">
							<label class="form-label"><b>Tanggal Berita Acara</b></label>
							<input type="date" class="form-control" name="tanggal_berita_acara" required>
						</div>
					</td>
				</tr>
			</table>
            <table style="width: 100%">
				<tr>
					<td style="width: 50%">
						<div class="mb-3">
							<label class="form-label"><b>Nomor Keputusan</b></label>
							<input type="text" class="form-control" name="nomor_keputusan" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" maxlength="2" required>
						</div>
					</td>
					<td>
						<div class="mb-3">
							<label class="form-label"><b>Tahun Keputusan</b></label>
							<input type="text" class="form-control" name="tahun_keputusan" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" maxlength="4" required>
						</div>
					</td>
				</tr>
			</table>
			<div class="mb-3">
                <label class="form-label"><b class="bold">File Penghapusan (.pdf)</b></label>
				<input type="file" class="form-control" name="file" required>
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
<!--  Akhir Modal Tambah Penghapusan-->

<!-- Awal Modal Cetak Penghapusan-->
<div class="modal fade" id="modalCetak" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" class="text-danger" id="staticBackdropLabel">Pilih Tahun Penghapusan</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
	  <form method="POST" action="../aset/cetak/cetak_penghapusan.php?" target="_blank">
    	<div class="modal-body">
  			<div class="mb-3">
    	  		<select class="ch" name="pilihan_tahun_berita_acara">
					<?php
						$pilih_tahun = $con->query("SELECT DISTINCT tahun_berita_acara FROM penghapusan");
						while($pilihan_tahun=$pilih_tahun->fetch_assoc()){
					?>
					<option value="<?= $pilihan_tahun['tahun_berita_acara']?>"><?= $pilihan_tahun['tahun_berita_acara']?></option>
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
<!--  Akhir Modal Cetak Penghapusan-->

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