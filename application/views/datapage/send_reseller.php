<div class="main-container">
			<div class="pd-ltr-20 xs-pd-20-10">
				<div class="min-height-200px">
					<div class="page-header">
						<div class="row" style="display:flex;justify-content:space-between;">
							<div class="col-md-6 col-sm-12">
								<div class="title">
									<h4>Kirim Produk ke Reseller</h4>
								</div>
								<nav aria-label="breadcrumb" role="navigation">
									<ol class="breadcrumb">
										<li class="breadcrumb-item">
											<a href="<?=base_url('beranda');?>">Home</a>
										</li>
                                        <li class="breadcrumb-item">
											<a href="#">Kirim</a>
										</li>
                                        <?php if($send_code1 == "null"){ ?>
                                        <li class="breadcrumb-item">
											<a href="javascript:;">Stok</a>
										</li>
										<li class="breadcrumb-item active" aria-current="page">
                                            Reseller
										</li>
                                        <?php } else { ?>
                                        <li class="breadcrumb-item">
											<a href="javascript:;">Reseller</a>
										</li>
										<li class="breadcrumb-item active" aria-current="page">
                                            <?=$send_code1->row("nama_tujuan");?>
										</li>
                                        <?php } ?>
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
                            if($send_code1 == "null"){
                            $sendcode = $this->data_model->kodeBayar(10);
                            } else {
                            $sendcode = $send_code1->row("send_code");
                            }
                        ?>
					<!-- Simple Datatable start -->
					<div class="card-box mb-30 pd-20">
                        <div class="form-group row">
                            <label class="col-sm-12 col-md-2 col-form-label">Nama Reseller</label>
                            <div class="col-sm-12 col-md-10">
                                <?php if($send_code1 == "null"){ ?>
                                <select class="custom-select col-sm-4" id="idReseller">
                                    <option value="">Pilih Reseller...</option>
                                    <?php foreach($reseller->result() as $r){ ?>
                                    <option value="<?=$r->id_res;?>"><?=$r->nama_reseller;?></option>
                                    <?php } ?>
                                </select>
                                <?php } else { ?>
                                <input type="text" id="idReseller" class="form-control col-sm-4" value="<?=$send_code1->row("nama_tujuan");?>" readonly>
                                <?php } ?>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-12 col-md-2 col-form-label">Tanggal Kirim</label>
                            <div class="col-sm-12 col-md-4">
                                <?php if($send_code1 == "null"){ ?>
                                <input class="form-control date-picker" id="tglKirim" placeholder="Pilih Tanggal" type="text">
                                <?php } else { ?>
                                <input class="form-control date-picker" id="tglKirim" value="<?=date("d F Y", strtotime($send_code1->row("tgl_out")));?>" placeholder="Pilih Tanggal" type="text">
                                
                                <?php } ?>
                            </div>
                        </div>
                        <input type="hidden" value="<?=$sendcode;?>" id="sendCode" name="sendcode" required>
                        <input type="hidden" value="Reseller" id="tujuanKirim" name="tujuankirim" required>
                        <div class="form-group row">
                            <label class="col-sm-12 col-md-2 col-form-label">Status Pembayaran</label>
                            <div class="col-sm-12 col-md-6">
                                <select class="custom-select col-sm-4" id="statusBayar">
                                    <option value="">Pilih</option>
                                    <?php if($send_code1 == "null"){ ?>
                                        <option value="Lunas">Lunas</option>
                                        <option value="Belum Lunas">Belum Dibayar</option>
                                    <?php } else { ?>
                                        <option value="Lunas" <?=$send_code1->row('status_lunas') == "Lunas" ? "selected" : "";?>>Lunas</option>
                                        <option value="Belum Lunas" <?=$send_code1->row('status_lunas') == "Belum Lunas" ? "selected" : "";?>>Belum Dibayar</option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-12 col-md-2 col-form-label">Jumlah Pembayaran</label>
                            <div class="col-sm-12 col-md-4">
                                <?php if($send_code1 == "null"){ ?>
                                <input type="text" id="angkaBayar" value="0" oninput="formatAngka(this)" class="form-control" placeholder="Masukan Jumlah Pembayaran" readonly>
                                <?php } else { ?>
                                <input type="text" id="angkaBayar" value="<?=number_format($send_code1->row('nilai_tagihan'),0,".",".");?>" oninput="formatAngka(this)" class="form-control" placeholder="Masukan Jumlah Pembayaran" readonly>
                                <?php } ?>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-12 col-md-2 col-form-label">Keterangan</label>
                            <div class="col-sm-6 col-md-6">
                                <?php if($send_code1 == "null"){ ?>
                                <textarea class="form-control" id="kete" style="height:100px;" placeholder="Masukan Keterangan"></textarea>
                                <?php } else { ?>
                                <textarea class="form-control" id="kete" style="height:100px;" placeholder="Masukan Keterangan"><?=$send_code1->row('ket');?></textarea>
                                <?php } ?>
                            </div>
                        </div>
                        <?php if($send_code1 == "null"){ ?>
                        <button type="submit" class="btn btn-primary" id="simpanReseller">Simpan</button>
                        <button type="submit" class="btn btn-success" id="addProdukReseller" style="display:none;" data-toggle="modal" data-target="#modals454">+ Tambah Produk</button>
                        <button type="submit" class="btn btn-secondary" id="addProdukResellerDis">+ Tambah Produk</button>
                        <?php } else { ?>
                            <button type="submit" class="btn btn-warning" id="updateReseller">Update Data</button>
                            <button type="submit" class="btn btn-success" id="addProdukReseller" data-toggle="modal" data-target="#modals454">+ Tambah Produk</button>
                            <button type="submit" class="btn btn-danger" onclick="hapusData('<?=$send_code1->row('send_code');?>')">Hapus Data</button>
                        <?php } ?>
                        <div class="table-responsive" id="loadTampilkanTable"></div>
					</div>
                    <!-- tampilan jika pengiriman keluar -->
                                <div class="modal fade bs-example-modal" id="modals454" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
									<div class="modal-dialog modal-dialog-centered">
										<div class="modal-content">
											<div class="modal-header">
												<h4 class="modal-title" id="myLargeModalLabel">
                                                    Masukan Produk Yang Di Kirim
												</h4>
												<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
													×
												</button>
											</div>
											<div class="modal-body" id="imgshid">
                                                <div style="width:100%;display:flex;flex-direction:column;">
                                                    <label class="form-label">Kode Produk</label>
                                                    <div class="form-label">
                                                        <div class="autoComplete_wrapper">
                                                            <input id="autoComplete" type="search" dir="ltr" spellcheck=false autocorrect="off" autocomplete="off" name="codeproduk" autocapitalize="off" required>
                                                        </div>
                                                    </div>
                                                    <small id="produkmotif"></small>
                                                </div> 
                                                <div style="width:100%;display:flex;flex-direction:column;margin-top:20px;">
                                                    <select name="ukuran" id="ukuran" class="form-control" onchange="cariKodeUkuran()">
                                                        <option value="">Ukuran Tersedia</option>
                                                    </select>
                                                    <small id="jumlahkirimspan"></small>
                                                </div> 
                                                <div style="width:100%;display:flex;flex-direction:column;margin-top:20px;">
                                                    <label class="form-label">Jumlah Kirim</label>
                                                    <input type="text" oninput="formatAngka(this)" placeholder="Masukan jumlah yang di kirim" name="jumlah" id="jumlahkirim" class="form-control">
                                                </div> 
											</div>
											<div class="modal-footer">
                                                <button type="button" class="btn btn-success" id="tambahKanProduk">Tambahkan</button>
                                            </div>
                                        </div>
									</div>
								</div>  
					<!-- Simple Datatable End -->
                                
                </div>
				
			</div>
		</div>