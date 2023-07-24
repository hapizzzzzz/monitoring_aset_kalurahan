<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perencanaan</title>
	<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
</head>
<body>
    <div class="lingkaran">
        <center><h3 class="judul">Tambah Perencanaan</h3></center>
    </div>
    <div class="container">
    <form method="POST" action="transaksi/proses_transaksi/proses_perencanaan.php" onsubmit="return submitForm(this);">
      <div class="modal-body">
	  		<input type="hidden" name="bSimpan" value="simpan">
  			<div class="mb-3">
    			<label class="form-label"><b class="bold">No RPJM</b></label>
    			<input type="number" class="form-control" min="1" max="99" name="prno_rpjm" id="prno_rpjm" required>
  			</div>
			<div class="mb-3">
    			<label class="form-label"><b class="bold">Tanggal RPJM</b></label>
    			<input type="date" class="form-control" name="prtgl_rpjm" id="prtgl_rpjm" required>
  			</div>
			<div class="mb-3">
    			<label class="form-label"><b class="bold">No RKP</b></label>
    			<input type="number" class="form-control" min="1" max="99" name="prno_rkp" id="prno_rkp" required>
  			</div>
			<div class="mb-3">
    			<label class="form-label"><b class="bold">Tanggal RKP</b></label>
    			<input type="date" class="form-control" name="prtgl_rkp" id="prtgl_rkp" required>
  			</div>
			<div class="mb-3">
                <label class="form-label"><b class="bold">Periode Tahun RPJM</b></label>
                <table>
                    <tr>
                        <td style="width:50%"><input type="number" class="form-control" min="1111" max="9999" name="prperiode_rpjmawal" id="prperiode_rpjmawal" required></td>
                        <td><b class="bold"> S.d </b></td>
                        <td style="width:50%"><input type="number" class="form-control" min="1111" max="9999" name="prperiode_rpjmakhir" id="prperiode_rpjmakhir" required></td>
                    </tr>
                </table>
  			</div>
			<div class="mb-3">
    			<label class="form-label"><b class="bold">Tahun RKP</b></label>
    			<input type="number" min="1900" max="2099" class="form-control" name="prthn_rkp" id="prthn_rkp" required>
  			</div>
      	</div>
      	<div>
		  	<button type="submit" class="btn btn-primary">Simpan</button>
      	</div>
	</form>

	<script>
		function submitForm(form) {

			var norpjm = $("#prno_rpjm").val();
			var tglrpjm = $("#prtgl_rpjm").val();
			var norkp = $("#prno_rkp").val();
			var tglrkp = $("#prtgl_rkp").val();
			var rpjmawal = $("#prperiode_rpjmawal").val();
			var rpjmakhir = $("#prperiode_rpjmakhir").val();
			var thnrkp = $("#prthn_rkp").val();

			swal({
				title: "Apakah Anda Yakin Akan Menyimpan Data Ini?",
				text: "No RPJM : " + norpjm + " | Tgl RPJM : " + tglrpjm + " | No RKP : " + norkp + " | Tgl RKP : " + tglrkp + " | Awal RPJM : " + rpjmawal + " | Akhir RPJM : " + rpjmakhir + " | Thn RKP : " + thnrkp,
				icon: "warning",
				buttons: true,
				dangerMode: true,
			})
			.then((isOkay) => {
				if (isOkay){
					form.submit();
				}
			});
			return false;
		}
	</script>

    </div>
</body>
</html>