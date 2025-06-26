<div class="main-container">
			<div class="pd-ltr-20 xs-pd-20-10">
				<div class="min-height-200px">
					<div class="page-header">
						<div class="row" style="display:flex;justify-content:space-between;">
							<div class="col-md-6 col-sm-12">
								<div class="title">
									<h4>Mutasi Stok</h4>
								</div>
								<nav aria-label="breadcrumb" role="navigation">
									<ol class="breadcrumb">
										<li class="breadcrumb-item">
											<a href="<?=base_url('beranda');?>">Home</a>
										</li>
                                        <li class="breadcrumb-item">
											<a href="#">Data Stok</a>
										</li>
										<li class="breadcrumb-item active" aria-current="page">
                                            Mutasi
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
                            $uris = $this->uri->segment(2);
                            $uriw = $this->uri->segment(3);
                            if($uris == "toko" && $uriw=="gudang"){
                                $jenis = "<font style='color:red;font-weight:bold'>Kirim Ke</font>";
                                $jenis2 = "Kirim";
                            } else {
                                $jenis = "<font style='color:green;font-weight:bold'>Terima Dari</font>";
                                $jenis2 = "Terima";
                            }
                        ?>
					<!-- Simple Datatable start -->
					<div class="card-box pd-20">
                        <input type="hidden" id="codeProses" value="<?=$codeProses;?>">
						<div class="form-group row">
                            <label class="col-sm-12 col-md-2 col-form-label"><?=$jenis;?> Gudang</label>
                            <div class="col-sm-12 col-md-10">
                                <?php if($jenis2 == "Kirim") { ?>
                                <input type="hidden" id="asalKirim" value="toko">
                                <input name="prosesid" id="prosesid" class="form-control" style="max-width:350px;" value="Toko -> Gudang" disabled />
                                <?php } else { ?>
                                <input type="hidden" id="asalKirim" value="gudang">
                                <input name="prosesid" id="prosesid" class="form-control" style="max-width:350px;" value="Gudang -> Toko" disabled />
                                <?php } ?>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-12 col-md-2 col-form-label">Tanggal <?=$jenis2;?></label>
                            <div class="col-sm-12 col-md-10">
                                <?php if($dataProses == "null"){?>
                                <input type="date" name="tgl" id="tglid" class="form-control" style="max-width:350px;" />
                                <?php } else { ?>
                                <input type="date" name="tgl" id="tglid" value="<?=$dataProses['tgl_mutasi'];?>" class="form-control" style="max-width:350px;" />
                                <?php } ?>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-12 col-md-2 col-form-label">Catatan</label>
                            <div class="col-sm-12 col-md-10">
                                <?php if($dataProses == "null"){?>
                                <textarea name="catatan" id="catatanid" class="form-control" style="height:80px; max-width:450px;" placeholder="Masukan Catatan / Keterangan"></textarea>
                                <?php } else { ?>
                                <textarea name="catatan" id="catatanid" class="form-control" style="height:80px; max-width:450px;" placeholder="Masukan Catatan / Keterangan"><?=$dataProses['ket'];?></textarea>
                                <?php } ?>
                                
                            </div>
                        </div>
                        <span>Data produk yang di <?=strtolower($jenis2);?> :</span>
                        <div class="table-responsive" style="margin-top:10px;">
                            <small id="loadingTables"></small>
                            <table class="table table-bordered table-hover table-full-width">
                                <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>Produk</th>
                                        <th>Model</th>
                                        <th>Ukuran</th>
                                        <th>Jumlah</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody id="bodyTables">
                                    <tr>
                                        <td colspan="5">Masukan produk yang di <?=strtolower($jenis2);?></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-12 col-md-2 col-form-label">Nama Produk</label>
                            <div class="col-sm-12 col-md-10">
                                <div class="form-label" style="200px;">
                                    <div class="autoComplete_wrapper" style="width:100%;">
                                        <input id="autoComplete" type="search" dir="ltr" spellcheck=false autocorrect="off" autocomplete="off" name="codekain" autocapitalize="off" required>
                                        <small id="load1"></small>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-12 col-md-2 col-form-label">Model</label>
                            <div class="col-sm-12 col-md-10">
                                <select name="model" class="form-control" style="max-width:350px;" id="model" disabled>
                                    <option value="">Silahkan pilih produk</option>
                                </select>
                                <small id="load2" style="color:red;"></small>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-12 col-md-2 col-form-label">Ukuran</label>
                            <div class="col-sm-12 col-md-10">
                                <select name="ukr" class="form-control" style="max-width:350px;" id="ukr" disabled>
                                    <option value="">Silahkan pilih model</option>
                                </select>
                                <small id="load3"></small>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-12 col-md-2 col-form-label">Jumlah <?=$jenis2;?></label>
                            <div class="col-sm-12 col-md-10">
                                <input type="text" name="jumlah" id="jumlah" class="form-control" style="max-width:350px;" placeholder="Masukan jumlah" oninput="formatAngka(this)" disabled>
                            </div>
                        </div>
                        <button type="button" class="btn btn-primary" id="idSimpanAdd">Simpan dan Tambah</button>
					</div>
                    <!-- tampilan jika pengiriman keluar -->
                    
					<!-- Simple Datatable End -->
                                
                </div>
				
			</div>
		</div>