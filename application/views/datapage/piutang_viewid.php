<div class="main-container">
			<div class="pd-ltr-20 xs-pd-20-10">
				<div class="min-height-200px">
					<div class="page-header">
						<div class="row" style="display:flex;justify-content:space-between;">
							<div class="col-md-6 col-sm-12">
								<div class="title">
									<h4>Data Piutang <?=$prod['nama_produsen'];?></h4>
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
											<a href="javascript:;">Cash Flow</a>
										</li>
                                        <li class="breadcrumb-item">
											<a href="javascript:;">Piutang</a>
										</li>
										<li class="breadcrumb-item active" aria-current="page">
                                            <?=$prod['nama_produsen'];?>
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
                        ?>
					<!-- Simple Datatable start -->
					<div class="card-box mb-30">
						<div class="pd-20 table-responsive">
                            <table class="data-table table stripe hover nowrap">
								<thead>
									<tr>
                                        <th>No</th>
										<th>Surat Jalan</th>
										<th>Jenis Barang</th>
										<th>Nominal Piutang</th>
										<th>Nominal Pembayaran</th>
										<th>Status</th>
										<th></th>
									</tr>
								</thead>
								<tbody>
                                    <?php
                                    $id = $prod['id_produsen'];
                                    $cek = $this->data_model->get_byid('hutang_produsen',['id_produsen'=>$id]);
                                    if($cek->num_rows()>0){
                                        $no=1;
                                        foreach($cek->result() as $val){
                                            $code = $val->code_kiriman;
                                            $kode_htgp = $val->kode_htgp;
											$thisbayar = $this->db->query("SELECT SUM(nominal_bayar) AS jml FROM hutang_produsen_bayar WHERE kode_htgp='$kode_htgp'")->row("jml");
                                            $dt = $this->data_model->get_byid('data_kain_keluar',['codeinput'=>$code])->row_array();
                                            $nama_kain = $this->data_model->get_byid('data_kain',['id_kain'=>$dt['id_kain']])->row("nama_kain");
											if($thisbayar>=$val->jumlah_hutang){
												$st = "Lunas";
											} else {
												$st = "Belum Lunas";
											}
                                            echo "<tr>";
                                            echo "<td>".$no++."</td>";
											?>
											<td>
												<a href="<?=base_url('data-kain/kirim/id/'.$code);?>" target="_blank" style="color:blue;"><?=$dt['nosj'];?></a>
											</td>
											<?php
                                            echo "<td>".$nama_kain."</td>";
                                            echo "<td>Rp. ".number_format($val->jumlah_hutang,0,',','.')."</td>";
                                            echo "<td>Rp. ".number_format($thisbayar,0,',','.')."</td>";
											if($st=="Lunas"){
												echo "<td><span class='badge badge-success'>Lunas</span></td>";
											} else {
												echo "<td><span class='badge badge-danger'>Belum Lunas</span></td>";
											}
											?>
											<td>
												<div class="dropdown">
													<a class="btn btn-link font-24 p-0 line-height-1 no-arrow dropdown-toggle" href="#" role="button" data-toggle="dropdown">
														<i class="dw dw-more"></i>
													</a>
													<div class="dropdown-menu dropdown-menu-right dropdown-menu-icon-list">
														<a class="dropdown-item" href="javascript:;" onclick="kodeHutang('<?=$kode_htgp;?>')" data-toggle="modal" data-target="#modals23"><i class="bi bi-currency-exchange"></i> Input Pembayaran</a>
														<a class="dropdown-item" href="javascript:;" onclick="kodeHutangView('<?=$kode_htgp;?>')" data-toggle="modal" data-target="#modals2398"><i class="dw dw-edit2"></i> Edit</a>
														<a class="dropdown-item" href="javascript:;" onclick="del('Tagihan Piutang','<?=$code;?>','Piutang')"><i class="dw dw-delete-3"></i> Delete</a>
													</div>
												</div>
											</td>
											<?php
                                            echo "</tr>";
                                        }
                                    }
                                    ?>
								</tbody>
							</table>
						</div>
					</div>
                    <!-- tampilan jika pengiriman keluar -->
                    <div class="modal fade bs-example-modal-lg" id="modals23" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
									<div class="modal-dialog modal-lg modal-dialog-centered">
										<div class="modal-content">
											<div class="modal-header">
												<h4 class="modal-title" id="myLargeModalLabel">
                                                    INPUT PEMBAYARAN
												</h4>
												<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
													×
												</button>
											</div>
                                            <?php echo form_open_multipart('save-pembayaran-hutang'); 
                                            $tgl_now = date('Y-m-d');
                                            ?>
                                            <input type="hidden" value="0" name="idhutang" id="idhutang">
                                            <input type="hidden" value="<?=$this->uri->segment(3);?>" name="idid">
											<div class="modal-body">
                                                <div class="form-group row">
                                                    <label class="col-sm-12 col-md-2 col-form-label">Metode Pembayaran</label>
                                                    <div class="col-sm-12 col-md-10">
                                                        <select name="metode" id="metode" class="form-control" style="width:350px;" required>
															<option value="">-- Pilih Metode Pembayaran --</option>
															<option value="Bayar">Bayar Langsung</option>
															<option value="Exchange">Bayar Dari Hasil Produk / Exchange</option>
														</select>
                                                    </div>
                                                </div>
												<div class="form-group row">
                                                    <label class="col-sm-12 col-md-2 col-form-label">Tanggal Pembayaran</label>
                                                    <div class="col-sm-12 col-md-10">
                                                        <input type="date" class="form-control" style="width:250px;" name="tglmasuk" id="tglmasuk" value="<?=$tgl_now;?>" max="<?=$tgl_now;?>" required>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label class="col-sm-12 col-md-2 col-form-label">Nominal Pembayaran</label>
                                                    <div class="col-sm-12 col-md-10">
                                                        <input type="text" class="form-control" oninput="formatAngka(this)" style="width:350px;" name="nominal" id="nominal" placeholder="Masukan Nominal Pembayaran" min="0" required>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label class="col-sm-12 col-md-2 col-form-label">Proses Pembayaran</label>
                                                    <div class="col-sm-12 col-md-10">
                                                        <input type="text" class="form-control" name="prosesbayar" id="prosesbayar" placeholder="Ex: Tunai, Transfer BCA, Virtual Account" min="0" required>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label class="col-sm-12 col-md-2 col-form-label" for="upload">Bukti Bayar</label>
                                                    <div class="col-sm-12 col-md-10">
                                                        <input class="form-control" name="upload" id="upload" type="file" onchange="validateFile('image')" />
                                                        <small>Upload bukti bayar. Ekstensi: JPG, PNG</small>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label class="col-sm-12 col-md-2 col-form-label" for="ketproduk">Keterangan</label>
                                                    <div class="col-sm-12 col-md-10">
                                                        <textarea name="ket" style="height:100px;" id="ketproduk" class="form-control" placeholder="Masukan Keterangan  (opsional)"></textarea>
                                                    </div>
                                                </div>
                                                <div class="form-group row" style="margin-top:-15px;">
                                                    <label class="col-sm-12 col-md-2 col-form-label" for="ketproduk232">&nbsp;</label>
                                                    <div class="col-sm-12 col-md-10">
                                                        <small>Jika metode pembayaran adalah exchange, Silahkan masukan keterangan disertai surat jalan penerimaan barang/stok.</small>
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
								<div class="modal fade bs-example-modal-lg" id="modals2398" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
									<div class="modal-dialog modal-lg modal-dialog-centered">
										<div class="modal-content">
											<div class="modal-header">
												<h4 class="modal-title" id="myLargeModalLabel">
                                                    DATA PEMBAYARAN
												</h4>
												<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
													×
												</button>
											</div>
											<div class="modal-body" id="modalBodyID">
                                                
											</div>
										</div>
									</div>
								</div>
					<!-- Simple Datatable End -->
                                
                </div>
				
			</div>
		</div>
		<script>
			function kodeHutang(id){
				document.getElementById('idhutang').value = ''+id;
			}
		</script>