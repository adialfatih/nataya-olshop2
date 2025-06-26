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
                            //echo $sess_akses;
							$kode = $this->uri->segment(3);
							$drow_jumlah = $this->data_model->get_byid('data_kain_masuk', ['codeinput'=>$kode])->num_rows();
							if($drow_jumlah == 0){ redirect(base_url('data-kain')); }
							$drow = $this->data_model->get_byid('data_kain_masuk', ['codeinput'=>$kode])->row_array();
							$kain = $this->data_model->get_byid('data_kain',['id_kain'=>$drow['id_kain']])->row_array();
							$tanggal_format = date("d M Y", strtotime($drow['tgl_masuk']));
							$total_panjang_asli = $drow['total_panjang'];
							$harga_satuan  = $drow['harga_permeter'];
							// if($kain['satuan'] == "Yard"){
							// 	$nilai_yard = $drow['total_panjang'];
							// 	$nilai_meter = $drow['total_panjang'] * 0.9144;
							// } else {
							// 	$nilai_meter = $drow['total_panjang'];
							// 	$nilai_yard = $drow['total_panjang'] / 0.9144;
							// }
							if (floor($total_panjang_asli) != $total_panjang_asli) {
								$total_panjang_asli2 = number_format($total_panjang_asli, 2, ',', '.');
							} else {
								$total_panjang_asli2 = number_format($total_panjang_asli, 0, ',', '.');
							}
							if (floor($harga_satuan) != $harga_satuan) {
								$harga_satuan2 = number_format($harga_satuan, 2, ',', '.');
							} else {
								$harga_satuan2 = number_format($harga_satuan, 0, ',', '.');
							}
							$rcord = $this->data_model->get_record('stok_kain')->num_rows();
							$codeinput = $drow['codeinput'];
							$cek_record = $this->data_model->get_byid('stok_kain_masuk_history', ['codeinput'=>$codeinput])->num_rows();
							
                        ?>
                    <form action="<?=base_url('save-update-kain');?>" method="post">
					<!-- Simple Datatable start -->
					<div class="card-box mb-30">
						<div class="pd-20">
							Update Data Pembelian <strong><?=$kain['nama_kain'];?></strong><br>
							<br>
							<div class="sow">
								<span style="width:200px;">Nomor Surat Jalan</span>
								<span>:</span>
                                <input type="text" name="surat_jalan" id="surat_jalan" value="<?=$drow['surat_jalan'];?>" class="form-control" style="max-width:250px;">
							</div>
							<div class="sow" style="margin-top:10px;">
								<span style="width:200px;">Tanggal Pembelian</span>
								<span>:</span>
                                <input type="date" name="tgl" id="tgl" value="<?=$drow['tgl_masuk'];?>" class="form-control" style="max-width:250px;">
							</div>
							<div class="sow" style="margin-top:10px;">
								<span style="width:200px;">Jumlah Roll</span>
								<span>:</span>
                                <input type="text" name="roll" id="roll" value="<?=$drow['jumlah_roll'];?>" class="form-control" style="max-width:250px;">
							</div>
							<input type="hidden" id="asliPanjang" value="<?=$total_panjang_asli;?>">
							<input type="hidden" id="asliRoll" value="<?=$drow['jumlah_roll'];?>">
							<input type="hidden" name="codeinputupdate" id="codeinput23" value="<?=$drow['codeinput'];?>">
							<div class="sow" style="margin-top:10px;">
								<span style="width:200px;">Total <?=$kain['satuan'];?></span>
								<span>:</span>
                                <input type="text" name="total_panjang" id="total_panjang" value="<?=$total_panjang_asli2;?>" class="form-control" style="max-width:250px;">
							</div>
                            <div class="sow" style="margin-top:10px;">
								<span style="width:200px;">Total Harga Beli</span>
								<span>:</span>
                                <input type="text" name="harga_beli" id="harga_beli" value="<?=number_format($drow['harga_beli'], 0, ',', '.'); ?>" class="form-control" style="max-width:250px;">
								
							</div>
							<div class="sow" style="margin-top:10px;">
								<span style="width:200px;">Harga Per <?=$kain['satuan'];?></span>
								<span>:</span>
                                <input type="text" name="harga_satuanup" id="harga_satuan" value="<?=$harga_satuan2;?>" class="form-control" style="max-width:250px;">
								
							</div>
							
							<div class="sow" style="margin-top:10px;">
								<span style="width:200px;">Supplier</span>
								<span>:</span>
                                <input type="text" name="supplier" id="supplier" value="<?=$drow['supplier']; ?>" class="form-control" style="max-width:350px;">
							</div>
							<div class="sow" style="margin-top:10px;">
								<span style="width:200px;">Keterangan</span>
								<span>:</span>
                                <textarea name="ket" id="ket" class="form-control" style="max-width:350px;height:60px"><?=$drow['ket']; ?></textarea>
							</div>
							<div class="sow" style="margin-top:10px;">
								<span style="width:200px;">Diinput Oleh</span>
								<span>:</span>
								<strong><?=$drow['yg_input']; ?></strong>
							</div>
                            <p>&nbsp;</p>
                            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
							<p>&nbsp;</p>
							Masukan data detail penerimaan kain 
							
							<input type="hidden" name="codeinput" id="codeinput" value="<?=$codeinput;?>">
							<input type="hidden" name="ididkain" id="ididkain" value="<?=$drow['id_kain'];?>">
							<input type="hidden" name="harga_satuan" id="harga_satuan" value="<?=$harga_satuan;?>">
							<div class="table-responsive">
							<table class="table">
								<tr>
									<th>#</th>
									<th>Kode Kain</th>
									<th>Nama Kain</th>
									<th>Panjang Kain</th>
									<th>Jumlah Roll</th>
								</tr>
								<?php
								if($cek_record > 0){
									$dt_pembelian = $this->data_model->get_byid('stok_kain_masuk_history', ['codeinput'=>$codeinput])->result();
									$no=1;
									$_roll=0; $_pjg=0;
									foreach($dt_pembelian as $val){
									if (floor($val->total_panjang) != $val->total_panjang) {
										$pjg = number_format($val->total_panjang, 2, ',', '.');
									} else {
										$pjg = number_format($val->total_panjang, 0, ',', '.');
									}
									$all_pjg = $val->total_panjang * $val->jumlah_roll;
									$_pjg+=$all_pjg;
									$_roll+=$val->jumlah_roll;
								?>
								<tr>
									<td><?=$no;?></td>
									<td><?=$val->kode_kain;?></td>
									<td><?=$val->nama_kain;?></td>
									<td><?=$pjg;?></td>
									<td><?=number_format($val->jumlah_roll, 0, ',', '.');?></td>
									
								</tr>
								<?php $no++;
									}
								}
								$number_row = $cek_record + 1;
								?>
								
								<tr>
									<th colspan="3">TOTAL</th>
									<th>
										<?php
										if (floor($_pjg) != $_pjg) {
											echo number_format($_pjg, 2, ',', '.');
										} else {
											echo number_format($_pjg, 0, ',', '.');
										} 
										echo " ".$kain['satuan'];
										?>
									</th>
									<th><?=number_format($_roll, 0, ',', '.');?></th>
								</tr>
								
							</table>
							</div>
							
							
						</div>
					</div>
                    </form>
					<!-- Simple Datatable End -->
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

    </script>