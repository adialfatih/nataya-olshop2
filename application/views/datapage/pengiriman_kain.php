<div class="main-container">
			<div class="pd-ltr-20 xs-pd-20-10">
				<div class="min-height-200px">
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
                            $id_produsen = $dts['id_produsen'];
                            $codeinput = $dts['codeinput'];
                            $id_kain = $dts['id_kain'];
                            $harga_bayar = $dts['harga_bayar'];
                            $yg_input = $dts['yg_input'];
                            $prod = $this->data_model->get_byid('data_produsen', ['id_produsen'=>$id_produsen])->row_array();
                            $notelp = $prod['notelp'];
                            $formatted = "+62 " . substr($notelp, 0, 4) . "-" . substr($notelp, 4, 4) . "-" . substr($notelp, 8);
                            $kain = $this->data_model->get_byid('data_kain', ['id_kain'=>$id_kain])->row_array();
                        ?>
                    
					<!-- Simple Datatable start -->
					<div class="card-box mb-30">
						<div class="pd-20" style="background-color:#ccc;border-radius:10px 10px 0 0;font-weight:bold;">
							Detail Pengiriman Barang
						</div>
                        <div class="pd-20">
                            <div class="sow">
								<span style="width:200px;">Nomor Surat Jalan</span>
								<span>:</span>
								<strong><?=$dts['nosj'];?></strong>
							</div>
                            <div class="sow">
								<span style="width:200px;">Jenis Kain</span>
								<span>:</span>
								<strong><?=$kain['nama_kain'];?></strong>
							</div>
                            <div class="sow">
								<span style="width:200px;">Kirim Ke</span>
								<span>:</span>
								<strong><?=$prod['nama_produsen'];?></strong>
							</div>
                            <div class="sow">
								<span style="width:200px;">No Telp</span>
								<span>:</span>
								<strong><?=$formatted;?></strong>
							</div>
                            <div class="sow">
								<span style="width:200px;">Alamat</span>
								<span>:</span>
								<strong><?=$prod['alamat'];?></strong>
							</div>
                            <div class="sow">
								<span style="width:200px;">Jumlah Bayar</span>
								<span>:</span>
                                <strong>Rp. <?=number_format($harga_bayar,0, '', '.'); ?></strong>
							</div>
                            <div class="sow">
								<span style="width:200px;">Diinput Oleh</span>
								<span>:</span>
								<strong><?=$yg_input; ?></strong>
							</div>
                            <div style="width:100%;display:flex;align-items:center;justify-content:flex-end;margin-top:15px;gap:10px;">
                                <button class="btn btn-warning" data-toggle="modal" data-target="#modals454">Edit Data</button>
                                <button class="btn btn-secondary"><i class="icon-copy bi bi-printer-fill"></i> Cetak</button>
                                <?php
                                $cek_utang = $this->data_model->get_byid('hutang_produsen',['id_produsen'=>$id_produsen,'code_kiriman'=>$codeinput])->num_rows();
                                if($cek_utang == 0){ ?>
                                    <button class="btn btn-info" data-toggle="modal" data-target="#modals7687">Simpan Piutang</button>
                                <?php } else { ?>
                                    <button class="btn btn-info">Piutang</button>
                                <?php }  ?>
                                <button class="btn btn-danger" onclick="hapusKiriman('<?=$codeinput;?>')">Hapus Kiriman</button>
                            </div>
                            <div class="table-responsive" style="margin-top:15px;">
                                <table class="table table-bordered">
                                    <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Kode Kain</th>
                                        <th>Kain</th>
                                        <th>Panjang</th>
                                        <th>Jumlah Roll</th>
                                        <th>Total Panjang</th>
                                        <th>Harga</th>
                                        <th>#</th>
                                    </tr></thead>
                                    <tbody id="trBody"></tbody>
                                </table>
                            </div>
                            <hr>
							
							<form action="<?=base_url();?>prosesajax/sendDataKain" method="post">
                            <input type="hidden" name="codeinput" id="codeinputID" value="<?=$dts['codeinput'];?>">
                            <div class="table-responsive">
							<table class="table table-bordered">
                                <tr>
                                    <th colspan="6" style="background:#242322;color:#fff;">Kiriman Kain<br><small>Masukan data kain yang di kirim</small></th>
                                </tr>
								<tr>
									<th>#</th>
									<th>Kode Kain</th>
									<th>Nama Kain</th>
									<th>Panjang Kain</th>
									<th>Jumlah Roll</th>
									<th></th>
								</tr>
                                <tr>
									<td>#</td>
									<td>
										<div class="form-label" style="width:200px;">
											<div class="autoComplete_wrapper" style="width:100%;">
												<input id="autoComplete" style="width:100%;" type="search" dir="ltr" spellcheck=false autocorrect="off" autocomplete="off" name="codekain" autocapitalize="off" required>
											</div>
										</div>
									</td>
									<td>
										<input type="text" name="namakain" style="min-width:170px;" id="namakain" placeholder="Masukan Nama Kain" class="form-control" readonly>
									</td>
									<td>
										<input type="text" name="totalpanjang" id="totalpanjang" placeholder="Satuan : <?=$kain['satuan'];?>" class="form-control" style="width:150px;" readonly>
									</td>
									<td colspan="2">
										<input type="text" name="jmlroll_stok" id="jmlroll" onkeyup="testes()" placeholder="Jumlah Roll" class="form-control" style="width:150px;" required>
										<input type="hidden" name="jmlroll_kirim" id="jmlroll2">
									</td>
								</tr>
                                <tr>
                                    <td colspan="5">
                                        <button type="button" id="submitBtn" class="btn btn-primary">Simpan</button>
                                    </td>
                                </tr>
                            </table>
                            </form>
                            <div class="table-responsive" style="margin-top:15px;">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th colspan="3" style="background:#242322;color:#fff;">Extras<br><small>Tambahkan barang lainya yang di kirim.</small></th>
                                        </tr>
                                        <tr>
                                            <th>Nama Barang</th>
                                            <th>Jumlah</th>
                                            <th>#</th>
                                        </tr>
                                    </thead>
                                    <tbody id="idbody23"></tbody>
                                    <tfooter>
                                        <tr>
                                            <td><input type="text" class="form-control" style="min-width:170px;" placeholder="Masukan nama barang" id="nmBarangEx"></td>
                                            <td><input type="text" class="form-control" style="min-width:170px;" placeholder="Masukan jumlah barang" id="jmlBarangEx"></td>
                                            <td>
                                                <button type="button" class="btn btn-primary" onclick="tambahkanExtras()">Tambahkan</button>
                                            </td>
                                        </tr>
                                    </tfooter>
                                </table>
                            </div>
                            <div class="table-responsive" style="margin-top:15px;">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th colspan="7" style="background:#242322;color:#fff;">Catatan untuk <?=$prod['nama_produsen'];?><br><small>Tambahkan catatan kebutuhan produk anda.</small></th>
                                        </tr>
                                        <tr>
                                            <th>Nama Produk</th>
                                            <th>Warna / Model</th>
                                            <th>Ukuran</th>
                                            <th>Jumlah Permintaan</th>
                                            <th>Terpenuhi</th>
                                            <th>NB</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody id="idbody78"></tbody>
                                    <tfooter>
                                        <tr>
                                            <td>
                                                <select name="tw2" id="tw2" class="form-control" style="min-width:170px;">
                                                    <option value="">Pilih Produk</option>
                                                    <?php
                                                    $pd = $this->db->query("SELECT id_produk,nama_produk FROM data_produk")->result();
                                                    foreach($pd as $vl){
                                                        echo "<option value='".$vl->id_produk."'>".$vl->nama_produk."</option>";
                                                    }
                                                    ?>
                                                </select>
                                            </td>
                                            <td><input type="text" class="form-control" style="min-width:170px;" placeholder="Masukan warna/model" id="tw3"></td>
                                            <td><input type="text" class="form-control" style="min-width:170px;" placeholder="Contoh: XL atau X,XL,XXL" id="tw4"></td>
                                            <td colspan="2"><input type="text" class="form-control" style="min-width:170px;" placeholder="Contoh: 100 atau 100,50,100" id="tw5"></td>
                                            
                                            <td></td>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <td colspan="7">
                                                <button type="button" class="btn btn-primary" onclick="tambahkanNotes()">Tambahkan Catatan</button>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="7">
                                                Anda bisa menambahkan multiple ukuran dan jumlah data menggunakan koma (,) tanpa spasi.<br>
                                                Contoh :<br>
                                                Cinos Panjang - Merah - <strong>L,XL,XXL</strong> - 100,50,120
                                            </td>
                                        </tr>
                                    </tfooter>
                                </table>
                            </div>
						</div>
					</div>
					<!-- Simple Datatable End -->
                                <div class="modal fade bs-example-modal-lg" id="modals454" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
									<div class="modal-dialog modal-lg modal-dialog-centered">
										<div class="modal-content">
											<div class="modal-header">
												<h4 class="modal-title" id="myLargeModalLabel">
                                                    EDIT DATA
												</h4>
												<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
													×
												</button>
											</div>
											<div class="modal-body">
                                            <form action="<?=base_url('proses/updatepengiriman');?>" method="post">
                                                <div class="form-group row">
                                                    <label class="col-sm-12 col-md-2 col-form-label">Surat Jalan</label>
                                                    <div class="col-sm-12 col-md-10">
                                                        <input class="form-control" type="text" name="newsj" value="<?=$dts['nosj'];?>" />
                                                        <input type="hidden" name="oldsj" value="<?=$dts['nosj'];?>" />
                                                        <input type="hidden" name="codeinput" value="<?=$dts['codeinput'];?>" />
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label class="col-sm-12 col-md-2 col-form-label">Jumlah Bayar</label>
                                                    <div class="col-sm-12 col-md-10">
                                                        <input class="form-control" type="text" oninput="formatRibuan(this)" name="newjmlbayar" value="<?=number_format($harga_bayar,0, '', '.'); ?>" />
                                                        <input type="hidden" name="oldjmlbayar" value="<?=number_format($harga_bayar,0, '', '.'); ?>" />
                                                    </div>
                                                </div>
                                            
											</div>
                                            <div class="modal-footer">
                                                <button type="submit" class="btn btn-primary">Simpan</button>
                                            </div>
                                            </form>
										</div>
									</div>
								</div>
                                <div class="modal fade bs-example-modal-lg" id="modals7687" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
									<div class="modal-dialog modal-lg modal-dialog-centered">
										<div class="modal-content">
											<div class="modal-header">
												<h4 class="modal-title" id="myLargeModalLabel">
                                                    BUAT TAGIHAN PIUTANG
												</h4>
												<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
													×
												</button>
											</div>
                                            <form action="<?=base_url('proses/addPiutang');?>" method="post">
											<div class="modal-body">
                                                <p><strong>Note :</strong>&nbsp;Pastikan data kain, ekstra dan catatan telah selesai anda buat sebelum anda membuat tagihan piutang untuk pengiriman kain tersebut. Tagihan piutang akan di tambahkan ke :</p>
                                                <table class="table">
                                                    <tr>
                                                        <td>Konveksi / Produsen</td>
                                                        <th><?=$prod['nama_produsen'];?></th>
                                                    </tr>
                                                    <tr>
                                                        <td>Nominal Utang</td>
                                                        <th>Rp. <?=number_format($harga_bayar,0, '', '.'); ?></th>
                                                    </tr>
                                                    <tr>
                                                        <td>Nomor Surat Jalan</td>
                                                        <th><?=$dts['nosj'];?></th>
                                                    </tr>
                                                </table>
											</div>
                                            <div class="modal-footer">
                                                <input name="codekiriman" type="hidden" value="<?=$codeinput;?>">
                                                <button type="submit" class="btn btn-primary">Simpan Piutang</button>
                                            </div>
                                            </form>
										</div>
									</div>
								</div>
                                <div class="modal fade bs-example-modal-lg" id="modalsnotesBN" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
									<div class="modal-dialog modal-lg modal-dialog-centered">
										<div class="modal-content">
											<div class="modal-header">
												<h4 class="modal-title" id="myLargeModalLabel">
                                                    NOTES
												</h4>
												<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
													×
												</button>
											</div>
                                            <form action="<?=base_url('proses/addnotes2');?>" method="post">
											<div class="modal-body">
                                                <textarea name="notes" id="notes" class="form-control" style="width:100%;height:150px;" placeholder="Masukan keterangan atau catatan penting lainnya."></textarea>
											</div>
                                            <div class="modal-footer">
                                                <input name="idnts" id="idnts" type="hidden" value="0">
                                                <button type="submit" class="btn btn-primary">Simpan NB</button>
                                            </div>
                                            </form>
										</div>
									</div>
								</div>
                                <div class="modal fade" id="Medium-modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
									<div class="modal-dialog modal-dialog-centered">
										<div class="modal-content">
											<div class="modal-header">
												<h4 class="modal-title" id="myLargeModalLabel">
													Masukan nilai terpenuhi
												</h4>
												<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
													×
												</button>
											</div>
                                            <form action="<?=base_url('proses/addnotes3');?>" method="post">
                                            <input name="idnts" id="idnts2" type="hidden" value="0">
											<div class="modal-body">
												<input type="number" class="form-control" name="terpenuhi" id="terpenuhi" placeholder="Masukan nilai terpenuhi">
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
                </div>
				
			</div>
		</div>
        <script>
        const totalPanjangInput = document.getElementById('total_panjang');
        const hargaBeliInput = document.getElementById('harga_beli');
        const hargaSatuanInput = document.getElementById('harga_satuan');

        function formatNumber(num) {
            return num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
        }

        function unformatNumber(num) {
            return parseFloat(num.replace(/\./g, '') || 0);
        }

        function calculateHargaSatuan() {
            const totalPanjang = unformatNumber(totalPanjangInput.value);
            const hargaBeli = unformatNumber(hargaBeliInput.value);
            if (totalPanjang > 0) {
                hargaSatuanInput.value = formatNumber(Math.round(hargaBeli / totalPanjang));
            }
        }

        function calculateHargaBeli() {
            const totalPanjang = unformatNumber(totalPanjangInput.value);
            const hargaSatuan = unformatNumber(hargaSatuanInput.value);
            hargaBeliInput.value = formatNumber(Math.round(hargaSatuan * totalPanjang));
        }

        function addInputEventListeners(input, callback) {
            input.addEventListener('input', function () {
                const cursorPosition = input.selectionStart;
                const rawValue = input.value.replace(/\D/g, ''); // Remove non-numeric characters
                input.value = formatNumber(rawValue); // Format with thousand separator
                input.setSelectionRange(cursorPosition, cursorPosition); // Restore cursor position
                callback();
            });
        }

        addInputEventListeners(totalPanjangInput, calculateHargaSatuan);
        addInputEventListeners(hargaBeliInput, calculateHargaSatuan);
        addInputEventListeners(hargaSatuanInput, calculateHargaBeli);
        document.getElementById('jmlroll').addEventListener('input', function () {
            // const jmlroll = parseInt(document.getElementById('jmlroll').value, 10);
            // const jmlroll2 = parseInt(document.getElementById('jmlroll2').value, 10);
            
            // // Cek jika jmlroll kurang dari 1 atau lebih besar dari jmlroll2
            // if (jmlroll < 1 || jmlroll > jmlroll2) {
            //     document.getElementById('jmlroll').classList.add('invlid');
            // } else {
            //     document.getElementById('jmlroll').classList.remove('invlid');
            // }
            console.log('tes');
        });
        function testes(){
            //console.log('tes');
            const submitBtn = document.getElementById('submitBtn');
            const jmlroll = parseInt(document.getElementById('jmlroll').value, 10);
            const jmlroll2 = parseInt(document.getElementById('jmlroll2').value, 10);
            if(jmlroll==""){
                submitBtn.disabled = true;
            } else {
            if (jmlroll < 1 || jmlroll > jmlroll2) {
                //document.getElementById('jmlroll').classList.add('invlid');
                submitBtn.disabled = true;
            } else {
                //document.getElementById('jmlroll').classList.remove('invlid');
                submitBtn.disabled = false;
            } }
        }
        function formatRibuan(input) {
            // Hapus karakter selain angka
            let angka = input.value.replace(/[^0-9]/g, '');

            // Tambahkan titik setiap 3 digit
            input.value = angka.replace(/\B(?=(\d{3})+(?!\d))/g, '.');
        }

        // Ambil elemen input
        const inputElement = document.getElementById('newjmlbayar');

        // Tambahkan event listener untuk "input"
        inputElement.addEventListener('input', function () {
            formatRibuan(this);
        });
        function note2s(id,val){
            document.getElementById('idnts2').value = ''+id;
            document.getElementById('terpenuhi').value = ''+val;
        }
    </script>