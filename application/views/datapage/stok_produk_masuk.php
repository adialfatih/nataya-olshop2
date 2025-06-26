<div class="main-container">
			<div class="pd-ltr-20 xs-pd-20-10">
				<div class="min-height-200px">
					<div class="page-header">
						<div class="row" style="display:flex;justify-content:space-between;">
							<div class="col-md-6 col-sm-12">
								<div class="title">
									<h4>Management Data Stok</h4>
								</div>
								<nav aria-label="breadcrumb" role="navigation">
									<ol class="breadcrumb">
										<li class="breadcrumb-item">
											<a href="<?=base_url('beranda');?>">Home</a>
										</li>
                                        <li class="breadcrumb-item">
											<a href="#">Data</a>
										</li>
                                        <li class="breadcrumb-item">
											<a href="#">Stok</a>
										</li>
										<li class="breadcrumb-item active" aria-current="page">
                                            Masuk
										</li>
									</ol>
								</nav>
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
                        <div class="pd-20" style="width:100%;display:flex;justify-content:space-between;background:#ccc;color:#000;border-radius:10px 10px 0 0;">
                            <strong id="idStokView">STOK MASUK</strong>
                            
                        </div>
						<div class="pd-20 table-responsive">
                            <input type="hidden" id="codeinput2" value="<?=$indata['codeinput'];?>">
                            <div class="sow">
								<span style="width:200px;">Nomor Surat Jalan</span>
								<span>:</span>
								<strong><?=$indata['suratjalan'];?></strong>
							</div>
                            <div class="sow">
								<span style="width:200px;">Kiriman Dari</span>
								<span>:</span>
								<strong><?=$produsen['nama_produsen'];?></strong>
							</div>
                            <div class="sow">
								<span style="width:200px;">Tanggal Masuk</span>
								<span>:</span>
								<strong><?=date("d M Y", strtotime($indata['tgl_masuk']));?></strong>
							</div>
                            <div class="sow">
								<span style="width:200px;">Lokasi</span>
								<span>:</span>
								<strong><?=$indata['lokasi'];?></strong>
							</div>
                            <div class="sow">
								<span style="width:200px;">Total Harga Barang</span>
								<span>:</span>
								<strong>Rp. <?=number_format($indata['total_nilai_barang'], 0, ',', '.');?></strong>
							</div>
                            <div class="sow" style="margin-top:10px;">
								<span style="width:200px;">Masuk Tagihan</span>
								<span>:</span>
                                <?php
                                if($indata['masuk_tagihan'] == "yes"){
                                    echo "<label class='badge badge-success'>Ya</label>";
                                } else {
                                    echo "<label class='badge badge-danger'>Tidak</label>";
                                }
                                ?>
							</div>
                            
                            <div style="width:100%;display:flex;justify-content:flex-end;">
                                <button class="btn btn-danger" onclick="deleteThis('<?=$indata['codeinput'];?>')">Hapus Data</button>
                            </div>
                            
                            <br>
                            <div class="sow">
								<span style="width:200px;">Detail Penerimaan Produk</span>
								<span>:</span>
							</div>
                            <div class="table-responsive">
                                <table class="table table-bordered table-hover">
                                    <thead>
                                        <tr class="bg-secondary text-white">
                                            <th scope="col">No</th>
                                            <th>KODE</th>
                                            <th>PRODUK</th>
                                            <th>MODEL</th>
                                            <th>UKURAN</th>
                                            <th>JUMLAH</th>
                                            <th>HPP</th>
                                            <th>TOTAL HPP</th>
                                            <th>HARGA JUAL</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody id="tbodyID">
                                    </tbody>
                                </table>
                            </div>
                            <br>
                            <br>
                            <hr>
                                        
                            
                            <div class="form-group row">
                                <label class="col-sm-12 col-md-2 col-form-label">Kode Produk</label>
                                <div class="col-sm-12 col-md-10">
                                    <div class="form-label" style="width:300px;">
										<div class="autoComplete_wrapper" style="width:100%;">
											<input id="autoComplete" style="width:100%;" type="search" dir="ltr" spellcheck=false autocorrect="off" autocomplete="off" name="kodeproduk" autocapitalize="off" required>
										</div>
									</div>
                                    <div style="display:flex;"><small><strong>Note</strong>: Aturan penulisan kode adalah KodeProduk-Ukuran. Ex: KODE-XL</small></div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-12 col-md-2 col-form-label">Nama Produk</label>
                                <div class="col-sm-12 col-md-10">
                                    <?php
                                    $p = $this->db->query("SELECT id_produk,nama_produk FROM data_produk ORDER BY nama_produk ASC")->result();
                                    ?>
                                    <select name="namaproduk" id="namaproduk" class="form-control" style="width:350px;" onchange="cekModel()">
                                        <option value="">-- Pilih Produk --</option>
                                        <?php foreach($p as $val){ ?>
                                        <option value="<?=$val->id_produk;?>"><?=$val->nama_produk;?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-12 col-md-2 col-form-label">Model Produk</label>
                                <div class="col-sm-12 col-md-10">
                                    <input type="text" class="form-control" style="width:350px;" onchange="cekModel()" name="modelproduk" id="modelproduk" placeholder="Masukan Model Produk" required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-12 col-md-2 col-form-label">Ukuran</label>
                                <div class="col-sm-12 col-md-10">
                                    <input type="text" class="form-control" style="width:350px;" name="ukuranproduk" id="ukuranproduk" placeholder="Masukan Ukuran Produk" required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-12 col-md-2 col-form-label">Jumlah</label>
                                <div class="col-sm-12 col-md-10">
                                    <input type="text" class="form-control" style="width:350px;" oninput="formatAngka(this)" name="jumlahproduk" id="jumlahproduk" placeholder="Masukan Jumlah Produk" required>
                                    <small style="color:red;" id="noticest"></small>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-12 col-md-2 col-form-label">Harga Produksi</label>
                                <div class="col-sm-12 col-md-10">
                                    <input type="text" class="form-control" style="width:350px;" oninput="formatAngka(this)" name="hpp" id="hpp" placeholder="Masukan Produksi" required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-12 col-md-2 col-form-label">Harga Jual Produk</label>
                                <div class="col-sm-12 col-md-10">
                                    <input type="text" class="form-control" style="width:350px;" oninput="formatAngka(this)" name="hargajual" id="hargajual" placeholder="Masukan Jual Produk" required>
                                </div>
                            </div>
                            <input type="hidden" id="codeinput" value="<?=$indata['codeinput'];?>">
                            <button type="button" class="btn btn-primary" onclick="tambahkanNotes()">Tambahkan Produk</button>
						</div>
					</div>
					<!-- Simple Datatable End -->
                    
                                
                </div>
				
			</div>
		</div>
<script>
function cekinput(){
    const jumlahInput = document.getElementById('jumlah').value;
    const ukuranInput = document.getElementById('ukuran').value;
    const notis1 = document.getElementById('idnotice');
    const notis2 = document.getElementById('idnotice2');

            // Mengubah input menjadi array
            const jumlahArray = jumlahInput.split(',').map(Number);
            const ukuranArray = ukuranInput.split(',');

            // Memeriksa kesesuaian jumlah
            if (jumlahArray.length !== ukuranArray.length) {
                //alert('Jumlah dan ukuran harus memiliki jumlah yang sama!');
                notis1.innerHTML = 'Jumlah dan ukuran harus memiliki jumlah yang sama!';
                notis2.innerHTML = '';
                return;
            }

            // Memeriksa input yang valid
            for (let i = 0; i < jumlahArray.length; i++) {
                if (jumlahArray[i] <= 0 || isNaN(jumlahArray[i])) {
                    //alert(`Jumlah tidak valid pada data ke-${i + 1}`);
                    notis1.innerHTML = `Jumlah tidak valid pada data ke-${i + 1}`;
                    notis2.innerHTML = '';
                    return;
                }
                if (ukuranArray[i].trim() === '') {
                    //alert(`Ukuran tidak boleh kosong pada data ke-${i + 1}`);
                    notis1.innerHTML = `Ukuran tidak boleh kosong pada data ke-${i + 1}`;
                    notis2.innerHTML = '';
                    return;
                }
            }

            notis1.innerHTML = '';
            notis2.innerHTML = 'Jumlah dan Ukuran Sudah Valid';
}
</script>