<div class="main-container">
			<div class="pd-ltr-20 xs-pd-20-10">
				<div class="min-height-200px">
					<div class="page-header">
						<div class="row" style="display:flex;justify-content:space-between;">
							<div class="col-md-6 col-sm-12">
								<div class="title">
									<h4>Data Mutasi Stok Produk</h4>
								</div>
								<nav aria-label="breadcrumb" role="navigation">
									<ol class="breadcrumb">
										<li class="breadcrumb-item">
											<a href="<?=base_url('beranda');?>">Home</a>
										</li>
                                        <li class="breadcrumb-item">
											<a href="#">Stok</a>
										</li>
										<li class="breadcrumb-item active" aria-current="page">
                                            Mutasi
										</li>
									</ol>
								</nav>
							</div>
                            <!-- <div style="display:flex;align-items:center;gap:10px;margin-right:15px;">
                                 <a class="btn btn-success" href="javscript:void(0);" data-toggle="modal" data-target="#modals2311">
                                    <i class="icon-copy bi bi-search"></i>&nbsp; Rekap Data
                                </a>
                            </div> -->
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
                            <table class="data-table table stripe hover nowrap" id="table1">
								<thead>
									<tr>
                                        <th>No.</th>
										<th>TANGGAL</th>
										<th>JENIS MUTASI</th>
										<th>JUMLAH KIRIM</th>
										<th>KETERANGAN</th>
                                        <th>#</th>
									</tr>
								</thead>
								<tbody id="tableBody">
                                    <tr><td colspan="6">Loading data....</td></tr>
								</tbody>
							</table>
						</div>
					</div>
                    <!-- tampilan jika pengiriman keluar -->
                                <div class="modal fade" id="modals2311as" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
									<div class="modal-dialog modal-lg modal-dialog-centered">
										<div class="modal-content">
											<div class="modal-header">
												<h4 class="modal-title" id="myLael2311">
													Lihat Rekap Data
												</h4>
												<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
													×
												</button>
											</div>
											<div class="modal-body" id="modl11">
                                                Lorem ipsum dolor sit amet consectetur adipisicing elit. Ipsa odit ipsum odio, numquam non voluptatum sunt beatae necessitatibus sint minus porro ullam, iste fugit? Aliquid deleniti iure facere blanditiis consequuntur?
                                            </div>
											
										</div>
									</div>
								</div>
					<!-- Simple Datatable End -->
                                
                </div>
				
			</div>
		</div>