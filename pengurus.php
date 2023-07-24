<div class="lingkaran">
    <center><h3 class="judul">Daftar Anggota</h3></center>
</div>
<div class="container">

	<!-- Button trigger modal tambah pengurus -->
	<button onclick="kosong()" type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalTambah" style="margin-bottom: 3%; font-size: 15px; border-radius: 10px; width: 15%">
		<i class="bi bi-plus-circle"></i>Tambah Data
	</button>

    <table class="table table-sm" cellspacing="0" width="100%" id="table" style="margin-top: 20px;">
	<thead>
		<tr>
			<th><center>No.</center></th>
			<th><center>Nomor Pengurus</center></th>
			<th><center>Nama Pengurus</center></th>
			<th><center>Nomor Telp</center></th>
			<th><center>Posisi</center></th>
			<th></th>
		</tr>
	</thead>
	<tbody>
        <?php include ('koneksi.php');?>
		<?php $nomor=1;?>
		<?php $ambil=$con->query("SELECT*FROM pengurus"); ?>
		<?php while($pecah=$ambil->fetch_assoc()){?>
		<tr>
			<td><center><?php echo $nomor++;?></center></td>
			<td><center><?php echo $pecah['nomor_pengurus']?></center></td>
			<td><center><?php echo $pecah['nama_pengurus']?></center></td>
			<td><center><?php echo $pecah['no_hp']?></center></td>
			<td><center><?php echo $pecah['posisi']?></center></td>
			<td><center>
				<!-- Button trigger modal hapus pengurus -->
				<button type="button" class="btn btn-danger" data-bs-toggle="modal" data-toggle="tooltip" data-placement="top" title="Hapus" data-bs-target="#modalHapus<?=$nomor?>">
					<i class="bi bi-trash"></i>
				</button>
				<!-- Button trigger modal edit pengurus -->
				<button type="button" class="btn btn-warning" data-bs-toggle="modal" data-toggle="tooltip" data-placement="top" title="Edit" data-bs-target="#modalEdit<?=$nomor?>">
					<i class="bi bi-pencil"></i>
				</button>
			</td></center>
		</tr>

		<!-- Awal Modal Hapus pengurus-->
			<div class="modal fade" id="modalHapus<?=$nomor?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  				<div class="modal-dialog">
    				<div class="modal-content">
      					<div class="modal-header">
        					<h5 class="modal-title" id="staticBackdropLabel">Konfirmasi !</h5>
        					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      					</div>
	  					<form method="POST" action="transaksi/proses_transaksi/proses_pengurus.php">
      						<input type="hidden" name="hpengurus" value="<?=$pecah['nomor_pengurus']?>">
	  						<div class="modal-body">
			
								<h5 class="text-center">Data ini akan dihapus ?<br>
									<span class="text-danger"><?= $pecah['nama_pengurus']?></span>
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
		<!--  Akhir Modal Hapus Pengurus-->

		<!-- Awal Modal Edit Pengurus-->
		<div class="modal fade modal-lg" id="modalEdit<?=$nomor?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  			<div class="modal-dialog">
    			<div class="modal-content">
      				<div class="modal-header">
        				<h1 class="modal-title fs-5" id="staticBackdropLabel">Edit Data</h1>
        				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      				</div>
	  				<form method="POST" action="transaksi/proses_transaksi/proses_pengurus.php">
      					<div class="modal-body">
                            <input type="hidden" name="eno_pengurus" value="<?=$pecah['nomor_pengurus']?>">
							<div class="mb-3">
    							<label class="form-label"><b>Nama Pengurus</b></label>
    							<input type="text" class="form-control" name="enama_pengurus" value="<?=$pecah['nama_pengurus']?>" required>
  							</div>
  							<div class="mb-3">
    							<label class="form-label"><b>Nomor Telp</b></label>
    							<input type="text" class="form-control" name="ehp_pengurus" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" maxlength="13" value="<?=$pecah['no_hp']?>" required>
  							</div>
      						<div class="modal-footer">
		  						<button type="submit" class="btn btn-primary" name="bUbah">Ubah</button>
        						<button type="button" class="btn btn-warning" data-bs-dismiss="modal">Batal</button>
      						</div>
						</div>
					</form>
    			</div>
  			</div>
		</div>
		<!--  Akhir Modal Edit Pengurus-->

		<?php }?>
	</tbody>
</table>

<!-- Awal Modal Tambah Pengurus-->
<div class="modal fade modal-lg" id="modalTambah" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="staticBackdropLabel">Tambah Data</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
	  <form method="POST" action="transaksi/proses_transaksi/proses_pengurus.php">
      <div class="modal-body">
  			<div class="mb-3">
    			<label class="form-label"><b>Posisi Pengurus</b></label>
    			<!-- <input type="text" class="form-control" name="no_pengurus" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" maxlength="2" required> -->
				<table style="width:100%">
					<tr>
						<td>
						<select class="form-select" id="posisi_pengurus" style="width:100%" onchange="detail()">
							<option value="">- Pilih Posisi -</option>
							<option value="Kepala Desa">01 - Kepala Desa</option>
							<option value="Sekretaris">02 - Sekretaris</option>
							<option value="Kaur Umum">03 - Kaur Umum</option>
							<option value="Lainnya">04 - Lainnya</option>
						</select>
						</td>
						<td>
							<input type="text" class="form-control" id="keterangan_posisi" name="ket_posisi" required>
						</td>
					</tr>
				</table>
  			</div>
			<div class="mb-3">
    			<label class="form-label"><b>Nama Pengurus</b></label>
    			<input type="text" class="form-control" name="nm_pengurus" required>
  			</div>
			<div class="mb-3">
    			<label class="form-label"><b>Nomor Telp</b></label>
    			<input type="text" class="form-control" name="hp_pengurus" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" maxlength="13" required>
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
<!--  Akhir Modal Tambah Pengurus-->

</div>

<script>
	function detail(){
		// alert("ok");
		var kode = $("#posisi_pengurus").val();

		if(kode == "") {
			$('#keterangan_posisi').val("");
			document.getElementById("keterangan_posisi").readOnly = true;
		}
		else if(kode == "Kepala Desa") {
			$('#keterangan_posisi').val("Kepala Desa");
			document.getElementById("keterangan_posisi").readOnly = true;
		}
		else if(kode == "Sekretaris") {
			$('#keterangan_posisi').val("Sekretaris");
			document.getElementById("keterangan_posisi").readOnly = true;
		}
		else if(kode == "Kaur Umum") {
			$('#keterangan_posisi').val("Kaur Umum");
			document.getElementById("keterangan_posisi").readOnly = true;
		} else {
			$('#keterangan_posisi').val("");
			document.getElementById("keterangan_posisi").readOnly = false;
		}
	}

	function kosong(){
		document.getElementById("keterangan_posisi").readOnly = true;
	}

</script>