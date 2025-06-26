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
							if($kain['satuan'] == "Yard"){
								$nilai_yard = $drow['total_panjang'];
								$nilai_meter = $drow['total_panjang'] * 0.9144;
							} else {
								$nilai_meter = $drow['total_panjang'];
								$nilai_yard = $drow['total_panjang'] / 0.9144;
							}
							if (floor($nilai_yard) != $nilai_yard) {
								$formatted_yard = number_format($nilai_yard, 2, ',', '.');
							} else {
								$formatted_yard = number_format($nilai_yard, 0, ',', '.');
							}
							if (floor($nilai_meter) != $nilai_meter) {
								$formatted_meter = number_format($nilai_meter, 2, ',', '.');
							} else {
								$formatted_meter = number_format($nilai_meter, 0, ',', '.');
							}
							$rcord = $this->data_model->get_record('stok_kain')->num_rows();
							$codeinput = $drow['codeinput'];
							$cek_record = $this->data_model->get_byid('stok_kain_masuk_history', ['codeinput'=>$codeinput])->num_rows();
							
                        ?>
                    
					<!-- Simple Datatable start -->
					<div class="card-box mb-30">
						<div class="pd-20" style="background-color:#ccc;border-radius:10px 10px 0 0;">
							Detail Pembelian <strong><?=$kain['nama_kain'];?></strong><br>
						</div>
						<div class="pd-20">
							<div class="sow">
								<span style="width:200px;">Nomor Surat Jalan</span>
								<span>:</span>
								<strong><?=$drow['surat_jalan'];?></strong>
							</div>
							<div class="sow">
								<span style="width:200px;">Tanggal Pembelian</span>
								<span>:</span>
								<strong><?=$tanggal_format;?></strong>
							</div>
							<div class="sow">
								<span style="width:200px;">Jumlah Pembelian</span>
								<span>:</span>
								<strong><?=$drow['jumlah_roll'];?> Roll</strong> 
							</div>
							<input type="hidden" id="asliPanjang" value="<?=$total_panjang_asli;?>">
							<input type="hidden" id="asliRoll" value="<?=$drow['jumlah_roll'];?>">
							<div class="sow">
								<span style="width:200px;">Total Panjang</span>
								<span>:</span>
								<span>
								<strong><?=$formatted_yard;?></strong> Yard / <strong><?=$formatted_meter;?></strong> Meter</span>
							</div>
							<div class="sow">
								<span style="width:200px;">Harga Per <?=$kain['satuan'];?></span>
								<span>:</span>
								<strong>Rp. <?=number_format($harga_satuan, 0, ',', '.'); ?></strong>
							</div>
							<div class="sow">
								<span style="width:200px;">Total Harga Beli</span>
								<span>:</span>
								<strong>Rp. <?=number_format($drow['harga_beli'], 0, ',', '.'); ?></strong>
							</div>
							<div class="sow">
								<span style="width:200px;">Supplier</span>
								<span>:</span>
								<strong><?=$drow['supplier']; ?></strong>
							</div>
							<div class="sow">
								<span style="width:200px;">Keterangan</span>
								<span>:</span>
								<strong><?=$drow['ket']; ?></strong>
							</div>
							<div class="sow">
								<span style="width:200px;">Diinput Oleh</span>
								<span>:</span>
								<strong><?=$drow['yg_input']; ?></strong>
							</div>
							<p>&nbsp;</p>
							Masukan data detail penerimaan kain 
							<form action="<?=base_url('save-kain-per-item');?>" method="post">
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
									<th></th>
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
									<td>
										<a href="javascript:void(0)" onclick="del('Data Kain','<?=$val->idstokkain;?>','<?=$val->nama_kain;?>')" style="color:red;"><i class="icon-copy bi bi-trash"></i></a>
									</td>
								</tr>
								<?php $no++;
									}
								}
								$number_row = $cek_record + 1;
								?>
								<tr>
									<td><?=$number_row;?></td>
									<td>
										<?php if($rcord==0){ ?>
											<input type="text" name="codekain" id="codekain" placeholder="Masukan Kode Kain" class="form-control" style="width:200px;" required>
										<?php } else {?>
										<div class="form-label" style="width:200px;">
											<div class="autoComplete_wrapper" style="width:100%;">
												<input id="autoComplete" style="width:100%;" type="search" dir="ltr" spellcheck=false autocorrect="off" autocomplete="off" name="codekain" autocapitalize="off" required>
											</div>
										</div>
										<?php } ?>
									</td>
									<td>
										<input type="text" name="namakain" style="min-width:170px;" id="namakain" placeholder="Masukan Nama Kain" class="form-control">
									</td>
									<td>
										<input type="text" name="totalpanjang" id="totalpanjang" placeholder="Satuan : <?=$kain['satuan'];?>" class="form-control" style="width:150px;">
									</td>
									<td colspan="2">
										<input type="text" name="jmlroll" id="jmlroll" placeholder="Jumlah Roll" class="form-control" style="width:150px;">
									</td>
								</tr>
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
									<th></th>
								</tr>
								<tr>
									<td colspan="6">
										<button type="submit" class="btn btn-primary">Simpan</button>
									</td>
								</tr>
							</table>
							</div>
							</form>
							<hr>
							<div style="width:100%;display:flex;justify-content:flex-end;">
							<?php
							if( $drow['gambar_foto'] == "null" ){
								?>
								<button type="button" class="btn btn-dark" data-toggle="modal" data-target="#modals23">Upload Surat Jalan</button>
								<?php
							} else {
								?>
								<button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#modals25">Lihat Surat Jalan</button>&nbsp;
								<button type="button" class="btn btn-dark" data-toggle="modal" data-target="#modals23">Upload Bukti Lainya</button>
								<?php
							}
							?>
							&nbsp;<a href="<?=base_url('data-kain/update/'.$codeinput);?>">
							<button type="button" class="btn btn-warning">Update Data</button></a>
							</div>
						</div>
					</div>
					<!-- Simple Datatable End -->
                    			<div class="modal fade" id="modals23" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
									<div class="modal-dialog modal-dialog-centered">
										<div class="modal-content">
											<div class="modal-header">
												<h4 class="modal-title" id="myLargeModalLabel">
													Upload Foto / Surat Jalan
												</h4>
												<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
													×
												</button>
											</div>
                                            <?php echo form_open_multipart('save-foto-sj'); ?>
											<input type="hidden" name="codeinput" id="codeinput23" value="<?=$codeinput;?>">
											<div class="modal-body" id="modalBodyid45">
												<p>Anda dapat mengunggah foto bukti penerimaan atau foto surat jalan penerimaan kain.</p>
                                                <label for="upload">Upload</label>
                                                <input type="file" id="upload" name="upload" class="form-control" onchange="validateFile('image')" required>
												<div style="width:100%;" id="previewContainer"></div>
                                            </div>
											<div class="modal-footer">
												<button type="button" class="btn btn-default" data-dismiss="modal">
													Close
												</button>
                                                <button type="submit" class="btn btn-primary" id="simpandataflow">
													Upload
												</button>
											</div>
											<?php echo form_close(); ?>
										</div>
									</div>
								</div>

								<div class="modal fade bs-example-modal-lg" id="modals25" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
									<div class="modal-dialog modal-lg modal-dialog-centered">
										<div class="modal-content">
											<div class="modal-header">
												<h4 class="modal-title" id="myLargeModalLabel">
													FOTO / SURAT JALAN
												</h4>
												<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
													×
												</button>
											</div>
											<div class="modal-body">
												<?php 
												$allfoto = $this->data_model->get_byid('data_kain_masuk_sj', ['codeinput'=>$codeinput]);
												if($drow['gambar_foto'] != "null") { ?>
												<div class="sowimage">
													<img src="<?=base_url('uploads/');?><?=$drow['gambar_foto']; ?>" alt="<?=$drow['surat_jalan']; ?>">
													<?php if($allfoto->num_rows() == 0){ ?>
													<span onclick="del('Foto Surat Jalan', '<?=$drow['gambar_foto']; ?>', 'Surat Jalan')">Hapus Gambar Ini</span> 
													<?php } ?>
												</div>
												<?php 
												
												foreach($allfoto->result() as $lp){
													?>
													<div class="sowimage">
														<img src="<?=base_url('uploads/');?><?=$lp->gambar_foto; ?>" alt="<?=$drow['surat_jalan']; ?>">
														<span onclick="del('Foto Surat Jalan', '<?=$lp->gambar_foto; ?>', 'Surat Jalan')">Hapus Gambar Ini</span>
													</div>
													<?php
												}
												} else { echo "Tidak ada gambar / foto surat jalan"; }?>
											</div>
											
										</div>
									</div>
								</div>
                </div>
				
			</div>
		</div>
        <script>
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
			function validateFile(tipe) {
				var fileInput = document.getElementById('upload');
				var filePath = fileInput.value;
				var maxFileSize = 5 * 1024 * 1024;
				if(tipe=='image'){
					var allowedExtensions = /(\.png|\.jpg|\.jpeg)$/i;
					var txtx = 'Hanya file dengan format PNG dan JPG.';
				} else {
					var allowedExtensions = /(\.png|\.jpg|\.jpeg|\.doc|\.docx|\.xls|\.xlsx|\.pdf)$/i;
					var txtx = 'Hanya file dengan format PNG, JPG, DOC, XLSX, atau PDF yang diperbolehkan.';
				}

				if (!allowedExtensions.exec(filePath)) {
					Swal.fire({
						icon: 'error',
						title: 'Format File Tidak Sesuai!',
						text: ''+txtx+'',
					});
					// Hapus nilai input file
					fileInput.value = '';
					return false;
				}
				if (fileInput.files[0].size > maxFileSize) {
					Swal.fire({
						icon: 'error',
						title: 'Ukuran File Terlalu Besar!',
						text: 'File tidak boleh lebih dari 2MB.',
					});
					// Hapus nilai input file
					fileInput.value = '';
					return false;
				}
				
			}
        </script>