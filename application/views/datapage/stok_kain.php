<div class="main-container">
			<div class="pd-ltr-20 xs-pd-20-10">
				<div class="min-height-200px">
					<div class="page-header">
						<div class="row" style="display:flex;justify-content:space-between;">
							<div class="col-md-6 col-sm-12">
								<div class="title">
									<h4>Management Data Stok Kain</h4>
								</div>
								<nav aria-label="breadcrumb" role="navigation">
									<ol class="breadcrumb">
										<li class="breadcrumb-item">
											<a href="<?=base_url('beranda');?>">Home</a>
										</li>
                                        <li class="breadcrumb-item">
											<a href="#">Data</a>
										</li>
										<li class="breadcrumb-item active" aria-current="page">
                                            Stok Kain
										</li>
									</ol>
								</nav>
							</div>
                            <div style="display:flex;align-items:center;gap:10px;margin-right:15px;">
                                    <a class="btn btn-outline-primary" href="javscript:void(0);" role="button" data-toggle="modal" data-target="#modals23">
                                        <i class="icon-copy bi bi-box-arrow-in-down-left"></i>&nbsp; Kain Masuk
                                    </a>
                                    <a class="btn btn-danger" href="javscript:void(0);" data-toggle="modal" data-target="#modalKirim">
                                        <i class="icon-copy bi bi-box-arrow-up-right"></i>&nbsp; Kirim Kain
                                    </a>
                                    <a class="btn btn-secondary" href="javscript:void(0);" data-toggle="modal" data-target="#modals25">
                                        <i class="icon-copy bi bi-tags"></i>
                                    </a>
                            </div>
						</div>
					</div>
                     
                        <?php
							if (!empty($this->session->flashdata('update'))) {
                                echo "<div class='alert alert-warning ' role='alert'>
                                        ".$this->session->flashdata('update').
                                        "</div>";
                            }
                            if (!empty($this->session->flashdata('gagal'))) {
                                echo "<div class='alert alert-danger ' role='alert'>
                                        ".$this->session->flashdata('gagal').
                                        "</div>";
                            }
                            if (!empty($this->session->flashdata('sukses'))) {
                                echo "<div class='alert alert-success ' role='alert'>
                                        ".$this->session->flashdata('sukses').
                                        "</div>";
                            }
                            //echo $sess_akses;
                        ?>
                    
					<!-- Simple Datatable start -->
					<div class="card-box mb-30">
						<div class="pd-20 table-responsive">
							<table class="table table-bordered stripe hover nowrap">
								<thead>
									<tr>
										<th class="table-plus datatable-nosort">No</th>
										<th>Jenis Kain</th>
										<th>Total Panjang</th>
										<th>Jumlah Roll</th>
										<th class="datatable-nosort">Action</th>
									</tr>
								</thead>
								<tbody id="viewStokKain">
                                    <tr>
                                        <td colspan="5">
                                            <div style="width:100%;display:flex;justify-content:center;align-items:center"></div>
                                        </td>
                                    </tr>
                                </tbody>
							</table>
						</div>
					</div>
					<!-- Simple Datatable End -->
                    <div class="modal fade bs-example-modal-lg" id="modals23" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
									<div class="modal-dialog modal-lg modal-dialog-centered">
										<div class="modal-content">
											<div class="modal-header">
												<h4 class="modal-title" id="myLargeModalLabel">
                                                <i class="icon-copy bi bi-box-arrow-in-down-left"></i>&nbsp;INPUT KAIN MASUK
												</h4>
												<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
													×
												</button>
											</div>
                                            <?php echo form_open_multipart('save-stok-kain'); 
                                            $tgl_now = date('Y-m-d');
                                            ?>
											<div class="modal-body">
                                                <div class="form-group row">
                                                    <label class="col-sm-12 col-md-2 col-form-label">No Surat Jalan</label>
                                                    <div class="col-sm-12 col-md-10">
                                                        <input type="text" class="form-control" style="max-width:100%;width:350px;" name="nosj" id="nosj" placeholder="Masukan nomor surat jalan / referensi" required>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label class="col-sm-12 col-md-2 col-form-label">Tanggal Masuk</label>
                                                    <div class="col-sm-12 col-md-10">
                                                        <input type="date" class="form-control" style="width:250px;" name="tglmasuk" id="tglmasuk" value="<?=$tgl_now;?>" required>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label class="col-sm-12 col-md-2 col-form-label">Nama Kain</label>
                                                    <div class="col-sm-12 col-md-10">
                                                        <select name="namakain" id="namakain" style="max-width:100%;width:350px;" class="form-control" onchange="ambilsatua2n(this.value)" required>
                                                            <option value="">--Pilih Kain--</option>
                                                            <?php foreach($produk->result() as $p){
                                                                ?><option value="<?=$p->id_kain;?>"><?=$p->nama_kain;?></option><?php
                                                            }?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label class="col-sm-12 col-md-2 col-form-label" for="jumlah" id="idjumlahText">Jumlah Masuk</label>
                                                    <div class="col-sm-12 col-md-10" style="display:flex;align-items:center;gap:15px;">
                                                        <input class="form-control" style="width:350px;" name="jumlah" id="jumlah" type="text" placeholder="Masukan Jumlah Stok Masuk" oninput="formatAngka(this)" onchange="hitungHarga()" disabled required />
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label class="col-sm-12 col-md-2 col-form-label" for="roll">Jumlah Roll</label>
                                                    <div class="col-sm-12 col-md-10">
                                                        <input class="form-control" style="width:250px;" name="roll" oninput="formatAngka(this)" id="roll" type="text" placeholder="Masukan Jumlah Roll" disabled required />
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label class="col-sm-12 col-md-2 col-form-label" for="dari">Dikirim dari</label>
                                                    <div class="col-sm-12 col-md-10" style="display:flex;align-items:center;gap:15px;">
                                                        <input class="form-control" name="dari" id="dari" list="dari-list" type="text" placeholder="Masukan Asal Barang / Pengirim / Supplier" disabled required />
                                                    </div>
                                                </div>
                                                <datalist id="dari-list">
                                                    <?php $datasd = $this->db->query("SELECT DISTINCT supplier FROM data_kain_masuk ORDER BY supplier ASC");
                                                    foreach($datasd->result() as $sd){
                                                        ?><option value="<?=$sd->supplier;?>"><?php
                                                    }
                                                    ?>
                                                </datalist>
                                                <div class="form-group row">
                                                    <label class="col-sm-12 col-md-2 col-form-label" for="hargabeli">Harga Beli</label>
                                                    <div class="col-sm-12 col-md-10" >
                                                        <input class="form-control" style="min-width:100%;max-width:350px;" name="hargabeli" id="hargabeli" type="text" oninput="formatAngka(this)" placeholder="Masukan Harga Pembelian Total" onchange="hitungHarga()" disabled required />
                                                        <small id="showSaldoID" style="color:red;"></small>
                                                    </div>
                                                </div>
                                                <input type="hidden" id="saldoSekarang" value="<?=$saldo;?>">
                                                <div class="form-group row">
                                                    <label class="col-sm-12 col-md-2 col-form-label" for="hargakain" id="hargaKainid">Harga Kain</label>
                                                    <div class="col-sm-12 col-md-10" style="display:flex;align-items:center;gap:15px;">
                                                        <input class="form-control" style="width:350px;" name="hargakain" id="hargakain" type="text" placeholder="Harga Kain Persatuan" readonly required />
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label class="col-sm-12 col-md-2 col-form-label" for="upload">Gambar</label>
                                                    <div class="col-sm-12 col-md-10">
                                                        <input class="form-control" name="upload" id="upload" type="file" onchange="validateFile('image')" />
                                                        <small>Masukan bukti foto surat jalan. Ekstensi: JPG, PNG</small>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label class="col-sm-12 col-md-2 col-form-label" for="ketproduk">Keterangan</label>
                                                    <div class="col-sm-12 col-md-10">
                                                        <textarea name="ket" style="height:100px;" id="ketproduk" class="form-control" placeholder="Masukan Keterangan  (opsional)"></textarea>
                                                    </div>
                                                </div>
                                                
											</div>
											<div class="modal-footer">
                                                <!-- <a href="<=base_url('data-kain/masuk');?>">
												<button type="button" class="btn btn-secondary">
													Riwayat Kain Masuk
												</button></a> -->
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">
													Close
												</button>
												<button type="submit" class="btn btn-primary">
													Save changes
												</button>
											</div>
                                            <?php echo form_close(); ?>
										</div>
									</div>
								</div>
                                <!-- Simple Datatable End -->
                                <div class="modal fade bs-example-modal-lg" id="modals25" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
									<div class="modal-dialog modal-lg modal-dialog-centered">
										<div class="modal-content">
											<div class="modal-header">
												<h4 class="modal-title" id="myLargeModalLabel">
													DATA KAIN
												</h4>
												<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
													×
												</button>
											</div>
                                            <form action="<?=base_url('input-kain'); ?>" method="post">
											<div class="modal-body">
                                                <table class="table table-bordered stripe hover">
                                                    <thead>
                                                        <tr>
                                                            <th>NO</th>
                                                            <th>NAMA KAIN</th>
                                                            <th>SATUAN</th>
                                                            <th></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php $no=1; foreach($produk->result() as $g){?>
                                                        <tr>
                                                            <td><?= $no++; ?></td>
                                                            <td><?= $g->nama_kain; ?></td>
                                                            <td><?= $g->satuan; ?></td>
                                                            <td><a href="javascript:void(0)" onclick="del('Kain','<?= $g->id_kain; ?>','<?= $g->nama_kain; ?>')"><i class="icon-copy bi bi-trash3" style="color:red;"></i></td>
                                                        </tr>
                                                        <?php } ?>
                                                        <tr>
                                                            <td></td>
                                                            <td><input type="text" id="input_kain" class="form-control" placeholder="Masukan Nama Kain" name="namakain" required></td>
                                                            <td>
                                                                <select id="input_satuan2" name="satuan" class="form-control" required>
                                                                    <option value="">Pilih Satuan</option>
                                                                    <option value="Yard">Yard</option>
                                                                    <option value="Meter">Meter</option>
                                                                </select>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
											</div>
											<div class="modal-footer">
												<button type="button" class="btn btn-secondary" data-dismiss="modal">
													Close
												</button>
												<button type="submit" class="btn btn-primary">
													Save changes
												</button>
											</div>
                                            </form>
										</div>
									</div>
								</div>
                                <!-- Simple Datatable End -->
                                <div class="modal fade bs-example-modal-lg" id="modals-datakain" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
									<div class="modal-dialog modal-lg modal-dialog-centered">
										<div class="modal-content">
											<div class="modal-header">
												<h4 class="modal-title" id="myLargeModalLabel">
													STOK KAIN
												</h4>
												<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
													×
												</button>
											</div>
											<div class="modal-body" id="bodyModalKain"></div>
										</div>
									</div>
								</div>
                                <!-- Simple Datatable End -->
                                <div class="modal fade bs-example-modal-lg" id="modalKirim" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
									<div class="modal-dialog modal-lg modal-dialog-centered">
										<div class="modal-content">
											<div class="modal-header">
												<h4 class="modal-title" id="myLargeModalLabel">
                                                <i class="icon-copy bi bi-box-arrow-up-right" style="color:red;"></i>&nbsp;&nbsp; KIRIM KAIN / BARANG
												</h4>
												<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
											</div>
                                            <?php echo form_open_multipart('save-kirim-kain'); ?>
											<div class="modal-body" id="bodyModalKain23">
                                                <div class="form-group row">
                                                    <label class="col-sm-12 col-md-2 col-form-label">Tanggal</label>
                                                    <div class="col-sm-12 col-md-10">
                                                        <input type="date" class="form-control" style="width:250px;" name="tglkirim" id="tglkirim" value="<?=$tgl_now;?>" required>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label class="col-sm-12 col-md-2 col-form-label">Kirim Ke</label>
                                                    <div class="col-sm-12 col-md-10">
                                                        <select name="produsen" id="produsen" style="width: 100%; max-width: 350px;" class="form-control" required>
                                                            <option value="">--Pilih Produksi / Konveksi--</option>
                                                            <?php 
                                                            $produsen = $this->db->query("SELECT id_produsen,nama_produsen FROM data_produsen");
                                                            foreach($produsen->result() as $te){
                                                                ?><option value="<?=$te->id_produsen;?>"><?=$te->nama_produsen;?></option><?php
                                                            }?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label class="col-sm-12 col-md-2 col-form-label">Jenis Kain</label>
                                                    <div class="col-sm-12 col-md-10">
                                                        <select name="namakain" id="namakain" style="width: 100%; max-width: 350px;" class="form-control" required>
                                                            <option value="">--Pilih Kain--</option>
                                                            <?php foreach($produk->result() as $ty){
                                                                ?><option value="<?=$ty->id_kain;?>"><?=$ty->nama_kain;?></option><?php
                                                            }?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label class="col-sm-12 col-md-2 col-form-label" for="nilai2">Harga Barang</label>
                                                    <div class="col-sm-12 col-md-10">
                                                        <input class="form-control" style="width: 100%; max-width: 350px;" name="nilai" oninput="formatAngka(this)" id="nilai2" type="text" placeholder="Masukan Nilai yang harus dibayarkan" required />
                                                        <div style="width:100%;background-color:#f8f9fa;padding:10px;font-size:12px;">
                                                            Total harga ini adalah nilai yang harus di bayarkan produksi/konveksi kepada anda.<br><strong>Note : </strong>Setelah proses simpan anda akan di arahkan ke halaman detail pengiriman barang. Anda dapat mengubahnya sesuai kebutuhan.
                                                        </div>
                                                    </div>
                                                </div>
                                                <hr>
                                                
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
												<button type="submit" class="btn btn-success">
													Submit
												</button>
											</div>
                                            <?php echo form_close(); ?>
										</div>
									</div>
								</div>
                </div>
				
			</div>
		</div>
        <script>
            function cekdata(){
                var panjangAsli = document.getElementById('stokPanjang').value.replace(/\D/g, '');
                var stokRoll = document.getElementById('stokRoll').value.replace(/\D/g, '');
                var stokNilai = document.getElementById('stokNilai').value.replace(/\D/g, '');
                var roll = document.getElementById('roll2').value.replace(/\D/g, '');
                var jumlah = document.getElementById('jumlah2').value.replace(/\D/g, '');
                if(parseFloat(jumlah) <= parseFloat(panjangAsli)){
                    document.getElementById('notice1').innerHTML = '';
                } else {
                    document.getElementById('notice1').innerHTML = 'Jumlah Stok Adalah :'+panjangAsli;
                }
                if(parseFloat(roll) <= parseFloat(stokRoll)){
                    document.getElementById('notice2').innerHTML = '';
                } else {
                    document.getElementById('notice2').innerHTML = 'Jumlah Roll Adalah :'+stokRoll;
                }
                if(parseFloat(jumlah) > 0 && parseFloat(stokNilai) > 0 ){
                    var totalNilai = parseFloat(jumlah) * parseFloat(stokNilai);
                    var formattedTotalNilai = Math.floor(totalNilai).toLocaleString('id-ID');
                    document.getElementById('nilai2').value = ''+formattedTotalNilai;
                }
            }
            function hitungHarga(){
                var hargabeli = document.getElementById('hargabeli').value.replace(/\D/g, '');
                var jumlah = document.getElementById('jumlah').value.replace(/\D/g, '');
                var saldoNow = document.getElementById('saldoSekarang').value;
                //alert('hargabeli '+hargabeli+' jumlah '+jumlah);
                var hargapermeter = hargabeli/jumlah;
                var formattedHargaPerMeter = Math.floor(hargapermeter).toLocaleString('id-ID');
                document.getElementById('hargakain').value = ''+formattedHargaPerMeter;
                if(parseInt(hargabeli) > 0){
                    var saldoAkhir = saldoNow - hargabeli;
                    var formattedSaldoAkhir = Math.floor(saldoAkhir).toLocaleString('id-ID');
                    if(parseInt(saldoNow) > parseInt(hargabeli)){
                        document.getElementById('showSaldoID').innerHTML = '';
                    } else {
                        document.getElementById('showSaldoID').innerHTML = 'Saldo Tidak Cukup. Jika anda melanjutkan maka saldo anda akan menjadi '+formattedSaldoAkhir+'';
                    }
                }
                
            }
            document.getElementById('tambahProduk').addEventListener('click', function() {
                // Mendapatkan tabel
                var table = document.getElementById('productTable');
                
                // Membuat elemen baris baru
                var row = table.insertRow(table.rows.length - 1);
                
                // Membuat sel baru di dalam baris
                var cell1 = row.insertCell(0);
                var cell2 = row.insertCell(1);
                var cell3 = row.insertCell(2);
                var cell4 = row.insertCell(3);
                
                // Menambahkan elemen ke dalam setiap sel
                cell1.innerHTML = `<select name="produks[]" class="form-control" required>
                                    <option value="">--Produk--</option>
                                    <?php 
                                    $dtp = $this->db->query("SELECT codeunik,nama_produk FROM data_produk ORDER BY nama_produk ASC");
                                    foreach($dtp->result() as $se){
                                        ?><option value="<?=$se->codeunik;?>"><?=$se->nama_produk;?></option><?php
                                    }?>
                                </select>`;
                
                cell2.innerHTML = `<select name="size[]" class="form-control" required>
                                    <option value="">--Ukuran--</option>
                                    <option value="Allsize">Allsize</option>
                                    <option value="S">S</option>
                                    <option value="M">M</option>
                                    <option value="L">L</option>
                                    <option value="XL">XL</option>
                                    <option value="XXL">XXL</option>
                                </select>`;
                
                cell3.innerHTML = '<input type="text" name="warna[]" class="form-control">';
                cell4.innerHTML = '<input type="text" name="jml[]" class="form-control">';
            });
            function isMobileDevice() {
                return /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent);
            }

            // Fungsi untuk mengubah behavior input file
            function setupFileInput() {
                var fileInput = document.getElementById('upload');

                if (isMobileDevice()) {
                    // Jika perangkat mobile, tambahkan atribut capture untuk membuka kamera
                    fileInput.setAttribute('capture', 'camera');
                } else {
                    // Jika perangkat desktop, hapus atribut capture jika ada
                    fileInput.removeAttribute('capture');
                }
            }

            // Panggil fungsi saat halaman dimuat
            window.onload = setupFileInput;
        </script>