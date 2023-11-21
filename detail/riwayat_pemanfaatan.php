<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Pemanfaatan</title>
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
    <script>
        $(document).ready(function () {
            $(".ch").chosen({
            width: "100%",
            no_results_text: "Oops, nothing found!",
            allow_single_deselect: true,
            });
        });
    </script>
</head>
<body>
    <div class="lingkaran">
        <center><h3 class="judul">Riwayat Pemanfaatan</h3></center>
    </div>

    <div class="container">
        <!-- Button trigger modal cetak riwayat pemanfaatan -->
        <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modalCetak" style="margin-bottom: 3%; font-size: 15px; border-radius: 10px; width: 15%">
            <i class="bi bi-printer"></i>Cetak
        </button>
        <table class="table table-sm" cellspacing="0" width="100%" id="table" style="margin-top: 20px;">
        <thead>
            <tr>
                <th><center>No.</center></th>
                <th><center>Kode</center></th>
                <th><center>Nama Partner</center></th>
                <th><center>Nama Aset</center></th>
                <th><center>Jumlah</center></th>
                <th><center>Bentuk Pemanfaatan</center></th>
                <th><center>Jangka Waktu</center></th>
                <th><center>Tahun Pemanfaatan</center></th>
                <th style="width: 10%"></th>
            </tr>
        </thead>
        <tbody>

            <?php $nomor=1;?>
            <?php $ambil=$con->query("SELECT * FROM transaksi_pemanfaatan_selesai"); ?>
            <?php while($pecah=$ambil->fetch_assoc()){?>
            <tr>
                <td><center><?php echo $nomor++;?></center></td>
                <td><center><?php echo $pecah['kode_riwayat_pemanfaatan']?></center></td>
                <td><center><?php echo $pecah['nama_partner']?></center></td>
                <td><center><?php echo $pecah['nama_aset']?></center></td>
                <td><center><?php echo $pecah['jumlah_p'] ." ".$pecah['satuan_p']?></center></td>
                <td><center><?php echo $pecah['bentuk_pemanfaatan']?></center></td>
                <td><center><?php echo date('d/m/Y', strtotime($pecah['awal_pemanfaatan']))." Sd ".date('d/m/Y', strtotime($pecah['akhir_pemanfaatan']))?></center></td>
                <td><center><?php echo $pecah['tahun_pemanfaatan']?></center></td>
                <td><center>
                    
                    <!-- Button trigger modal hapus barang -->
                    <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#modalHapus<?=$nomor?>" data-toggle="tooltip" data-placement="top" title="Hapus">
                        <i class="bi bi-trash"></i>
                    </button>
                    <!-- Button trigger modal rincian barang -->
                    <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modalrincian<?=$nomor?>" data-toggle="tooltip" data-placement="top" title="Rincian">
                        <i class="bi bi-card-list"></i>
                    </button>
                    
                </td></center>
            </tr>

            <!-- Awal Modal Cetak Riwayat Pemanfaatan-->
            <div class="modal fade" id="modalCetak" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" class="text-danger" id="staticBackdropLabel">Pilih Tahun Riwayat Pemanfaatan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="POST" action="../aset/cetak/cetak_riwayat_pemanfaatan.php?" target="_blank">
                    <div class="modal-body">
                        <div class="mb-3">
                            <select class="ch" name="pilihan_tahun_riwayat_pemanfaaatan">
                                <?php
                                    $pilih_tahun = $con->query("SELECT DISTINCT tahun_pemanfaatan FROM transaksi_pemanfaatan_selesai");
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
            <!--  Akhir Modal Cetak Riwayat Pemanfaatan-->

            <!-- Awal Modal Hapus Detail Pemanfaatan-->
            <div class="modal fade" id="modalHapus<?=$nomor?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="staticBackdropLabel">Konfirmasi !</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <form method="POST" action="detail/proses_detail/proses_detail_riwayat_pemanfaatan.php">
                                <input type="hidden" name="kode_riwayat_pemanfaatan" value="<?=$pecah['kode_riwayat_pemanfaatan']?>">
                                <input type="hidden" name="file_riwayat" value="<?=$pecah['file_pemanfaatan']?>">
                                <div class="modal-body">
                
                                    <div class="text-danger"><h5 class="text-center">Hapus Riwayat Pemanfaatan ?</h5></div>
                                    <hr>
                                    <h6><b>Nama Partner : </b></h6>
                                    <h5 class="ddpd"><?=$pecah['nama_partner']?></h5>
                                    <hr>
                                    <h6><b>Nama Aset : </b></h6>
                                    <h5 class="ddpd"><?=$pecah['nama_aset']." ( ".$pecah['jumlah_p']." ".$pecah['satuan_p']." ) "?></h5>
                                    <hr>
                                    <h6><b>Bentuk Pemanfaatan : </b></h6>
                                    <h5 class="ddpd"><?=$pecah['bentuk_pemanfaatan']?></h5>
                                    <hr>
                                    <h6><b>Jangka Waktu : </b></h6>
                                    <h5 class="ddpd"><?=date('d/m/Y', strtotime($pecah['awal_pemanfaatan']))." Sampai dengan ".date('d/m/Y', strtotime($pecah['akhir_pemanfaatan']))?></h5>
                                    <hr>
                                    <h6><b>Tahun Pemanfaatan : </b></h6>
                                    <h5 class="ddpd"><?=$pecah['tahun_pemanfaatan']?></h5>
                                    <hr>
                                    <h6><b>Keterangan : </b></h6>
                                    <h5 class="ddpd"><?=$pecah['keterangan']?></h5>

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
            
            <!-- Awal Modal Rincian Pemanfaatan-->
            <div class="modal fade" id="modalrincian<?=$nomor?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" class="text-danger" id="staticBackdropLabel">Detail Riwayat Pemanfaatan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <h6><b>Kode : </b></h6>
                    <h5 class="ddpd"><?=$pecah['kode_riwayat_pemanfaatan']?></h5>
                    <hr>
                    <h6><b>Nama Partner : </b></h6>
                    <h5 class="ddpd"><?=$pecah['nama_partner']?></h5>
                    <hr>
                    <h6><b>No Hp : </b></h6>
                    <h5 class="ddpd"><?=$pecah['no_hp']?></h5>
                    <hr>
                    <h6><b>Email : </b></h6>
                    <h5 class="ddpd"><?=$pecah['email_partner']?></h5>
                    <hr>
                    <h6><b>Alamat : </b></h6>
                    <h5 class="ddpd"><?=$pecah['alamat']?></h5>
                    <hr>
                    <h6><b>Nomor Perdes : </b></h6>
                    <h5 class="ddpd"><?=$pecah['no_perdes'];?></h5>
                    <hr>
                    <h6><b>Tahun Perdes : </b></h6>
                    <h5 class="ddpd"><?=$pecah['tahun_perdes'];?></h5>
                    <hr>
                    <h6><b>Tanggal Perdes : </b></h6>
                    <h5 class="ddpd"><?=$pecah['tanggal_perdes'];?></h5>
                    <hr>
                    <h6><b>Tahun Pemanfaatan : </b></h6>
                    <h5 class="ddpd"><?=$pecah['tahun_pemanfaatan'];?></h5>
                    <hr>
                    <h6><b>Nama Aset : </b></h6>
                    <h5 class="ddpd"><?=$pecah['nama_aset'];?></h5>
                    <hr>
                    <h6><b>Jumlah : </b></h6>
                    <h5 class="ddpd"><?=$pecah['jumlah_p']." ".$pecah['satuan_p'];?></h5>
                    <hr>
                    <h6><b>Bentuk Pemanfaatan : </b></h6>
                    <h5 class="ddpd"><?=$pecah['bentuk_pemanfaatan'];?></h5>
                    <hr>
                    <h6><b>Biaya Kontribusi : </b></h6>
                    <h5 class="ddpd"><?=$pecah['biaya_kontribusi'];?></h5>
                    <hr>
                    <h6><b>Jangka Waktu : </b></h6>
                    <h5 class="ddpd"><?=date('d/m/Y', strtotime($pecah['awal_pemanfaatan']))." Sd ".date('d/m/Y', strtotime($pecah['akhir_pemanfaatan']))?></h5>
                    <hr>
                    <h6><b>Keterangan : </b></h6>
                    <h5 class="ddpd"><?=$pecah['keterangan']?></h5>
                    <hr>
                    <h6><b>No Surat Perjanjian : </b></h6>
                    <h5 class="ddpd"><?=$pecah['no_surat_perjanjian']?></h5>
                    <hr>
                    <h6><b>File Surat Perjanjian : </b></h6>
                    <a href='riwayat_pemanfaatan/<?=$pecah['file_pemanfaatan']?>' download><?= $pecah['file_pemanfaatan']?></a>
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
    <div>
</body>
</html>