<div class="main-container">
			<div class="pd-ltr-20 xs-pd-20-10">
				<div class="min-height-200px">
					<div class="page-header">
						<div class="row" style="display:flex;justify-content:space-between;">
							<div class="col-md-6 col-sm-12">
								<div class="title">
									<h4>Data Pengeluaran Stok Gudang</h4>
								</div>
								<nav aria-label="breadcrumb" role="navigation">
									<ol class="breadcrumb">
										<li class="breadcrumb-item">
											<a href="<?=base_url('beranda');?>">Home</a>
										</li>
                                        <li class="breadcrumb-item">
											<a href="#">Stok</a>
										</li>
                                        <li class="breadcrumb-item">
											<a href="javascript:;">Keluar</a>
										</li>
										<li class="breadcrumb-item active" aria-current="page">
                                            Semua Data
										</li>
									</ol>
								</nav>
							</div>
                            <div style="display:flex;align-items:center;gap:10px;margin-right:15px;">
                                 <a class="btn btn-success" href="javscript:void(0);" data-toggle="modal" data-target="#modals2311">
                                    <i class="icon-copy bi bi-search"></i>&nbsp; Rekap Data
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
                        ?>
					<!-- Simple Datatable start -->
					<div class="card-box mb-30">
						<div style="width:100%;display:flex;align-items:center;padding:20px;gap:10px;background:#dedede;border-radius:10px 10px 0 0;">
							<div style="display:flex;flex-direction:column;">
								<span>Tampilkan Tujuan : </span>
                            	<select name="kategori" onchange="lookData()" id="kategori90" class="form-control" style="width:200px;" onchange="changeSelectKategori(this.value)">
                                <option value="null" >--Pilih Tujuan--</option>
                                    <option value="Agen">Agen</option>
                                    <option value="Reseller">Reseller</option>
                                    <option value="Customer">Customer</option>
                                </select>
							</div>
                            <div style="display:flex;flex-direction:column;">
								<span>Cari Nama : </span>
								<div class="form-label" style="width:300px;">
									<div class="autoComplete_wrapper" style="width:300px;">
										<input id="autoComplete" onchange="lookData()" style="width:300px;" type="search" dir="ltr" spellcheck=false autocorrect="off" autocomplete="off" name="kodeproduk" autocapitalize="off" required>
									</div>
								</div>
							</div>
							<div style="display:flex;flex-direction:column;">
								<span>Atau tampilkan tanggal : </span>
								<div class="form-label" style="width:300px;">
									<input class="form-control"id="thisTegel" type="date" onchange="lookData()">
								</div>
							</div>
                        </div>
						<div class="pd-20 table-responsive">
							<p id="paragraphShow">Menampilkan data keluar tanggal <?=date('d M Y', strtotime(date('Y-m-d')));?></p>
                            <table class="data-table table stripe hover nowrap" id="table1">
								<thead>
									<tr>
                                        <th>SJ</th>
										<th>TUJUAN</th>
										<th>NAMA PENERIMA</th>
										<th>TANGGAL KIRIM</th>
										<th>JUMLAH KIRIM</th>
										<th>TOTAL HARGA</th>
										<th>Lunas</th>
										<th></th>
                                        <th>#</th>
									</tr>
								</thead>
								<tbody id="tableBody">
                                    <tr><td colspan="9">Loading data....</td></tr>
								</tbody>
							</table>
						</div>
					</div>
                    <!-- tampilan jika pengiriman keluar -->
                                <div class="modal fade" id="modals2311" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
									<div class="modal-dialog modal-dialog-centered">
										<div class="modal-content">
											<div class="modal-header">
												<h4 class="modal-title" id="myLargeModalLabel2311">
													Lihat Rekap Data
												</h4>
												<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
													×
												</button>
											</div>
                                            <?php echo form_open_multipart('data-stok/keluar/rekap'); ?>
											<div class="modal-body" id="modalBodyid2311">
                                                <label for="kode_bar456">Tanggal</label>
                                                <input class="form-control" name="dates" id="kode_bar456" type="text" placeholder="Masukan tanggal rekap..." />
												<label for="modelwarna233" style="margin-top:5px;">Penjualan</label>
                                                <select name="tipejual" id="tipejual" class="form-control">
                                                    <option value="all">--Semua Penjualan--</option>
                                                    <option value="Customer">Customer</option>
                                                    <option value="Reseller">Reseller</option>
                                                    <option value="Agen">Agen</option>
                                                </select>
                                                <label for="ukuran244" style="margin-top:5px;">Nama</label>
                                                <input class="form-control" name="nama" id="ukuran244" type="text" placeholder="Masukan nama (opsional)" />
                                            </div>
											<div class="modal-footer">
												<button type="button" class="btn btn-default" data-dismiss="modal">
													Close
												</button>
                                                <button type="submit" class="btn btn-primary" id="tombolSubmit">
                                                    <i class="icon-copy bi bi-search"></i>&nbsp; Submit
												</button>
                                                <span class="loader" id="thisLoader" style="display:none;"></span>
											</div>
                                            <?php echo form_close(); ?>
										</div>
									</div>
								</div>
					<!-- Simple Datatable End -->
                                
                </div>
				
			</div>
		</div>