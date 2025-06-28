<div class="main-container">
			<div class="pd-ltr-20 xs-pd-20-10">
				<div class="min-height-200px">
					<div class="page-header">
						<div class="row">
							<div class="col-md-6 col-sm-12">
								<div class="title">
									<h4>Data Hutang Agen/Distributor</h4>
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
											<a href="#">Hutang</a>
										</li>
										<li class="breadcrumb-item active" aria-current="page">
                                            <?=$agen['nama_distributor'];?>
										</li>
									</ol>
								</nav>
							</div>
                            
							<div class="col-md-6 col-sm-12 text-right">
								<div class="dropdown">
									<a class="btn btn-success" href="javascript:void(0);" onclick="changeadd()">
										<i class="bi bi-share"></i>&nbsp; Share Url
									</a>
								</div>
							</div>
						</div>
					</div>
                     
                        <?php
							if (!empty($this->session->flashdata('update'))) {
                                echo '<div class="card-box mb-30" style="padding:20px;">';
                                echo "<div class='alert alert-warning ' role='alert'>
                                        ".$this->session->flashdata('update').
                                        "</div></div>";
                            }
                            if (!empty($this->session->flashdata('gagal'))) {
                                echo '<div class="card-box mb-30" style="padding:20px;">';
                                echo "<div class='alert alert-danger ' role='alert'>
                                        ".$this->session->flashdata('gagal').
                                        "</div></div>";
                            }
                            if (!empty($this->session->flashdata('sukses'))) {
                                echo '<div class="card-box mb-30" style="padding:20px;">';
                                echo "<div class='alert alert-success ' role='alert'>
                                        ".$this->session->flashdata('sukses').
                                        "</div></div>";
                            }
                            //echo $sess_akses;
                        ?>
                    
					<!-- Simple Datatable start -->
					<div class="card-box mb-30">
						<div class="pd-20 table-responsive">
							<table class="table table-bordered stripe hover nowrap">
								<thead>
									<tr>
										<th>No</th>
										<th>SJ</th>
										<th>Tanggal</th>
										<th>Tagihan</th>
										<th>Pembayaran</th>
										<th>Sisa Hutang</th>
									</tr>
								</thead>
								<tbody>
                                    
                                </tbody>
							</table>
						</div>
					</div>
					<!-- Simple Datatable End -->
								<div class="modal fade" id="modals" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
									<div class="modal-dialog modal-dialog-centered">
										<div class="modal-content">
											<div class="modal-header">
												<h4 class="modal-title" id="myLargeModalLabel">
													Tambah Distributor
												</h4>
												<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
													×
												</button>
											</div>
                                            <form action="<?=base_url('save-distributor');?>" method="post">
                                            <input type="hidden" name="idtipe" value="0" id="idtipe">
											<div class="modal-body" id="modalBodyid">
                                                <label for="namadistributor">Nama Distributor</label>
                                                <input type="text" id="namadistributor" name="namadistributor" class="form-control" placeholder="Masukan Nama Distributor" required>
                                                <label for="nowa">No Telepon / WA</label>
                                                <input type="number" id="nowa" name="nowa" class="form-control" placeholder="Masukan Nomor Telephon tanpa 0/62" required>
                                                <label for="almt">Alamat Distributor</label>
                                                <textarea name="almt" class="form-control" placeholder="Masukan Alamat Distributor" id="almt"></textarea>
                                            </div>
											<div class="modal-footer">
												<button type="button" class="btn btn-default" data-dismiss="modal">
													Close
												</button>
                                                <button type="submit" class="btn btn-primary">
													Simpan Data
												</button>
											</div>
                                            </form>
										</div>
									</div>
								</div>
                                
                </div>
				
			</div>
		</div>