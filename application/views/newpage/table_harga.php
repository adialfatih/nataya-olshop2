<div class="main-container">
			<div class="pd-ltr-20 xs-pd-20-10">
				<div class="min-height-200px">
					<div class="page-header">
						<div class="row">
							<div class="col-md-6 col-sm-12">
								<div class="title">
									<h4>Menampilkan Tabel Harga Produk</h4>
								</div>
								<nav aria-label="breadcrumb" role="navigation">
									<ol class="breadcrumb">
										<li class="breadcrumb-item">
											<a href="<?=base_url('beranda');?>">Home</a>
										</li>
                                        <li class="breadcrumb-item">
											<a href="#">Data</a>
										</li>
										<li class="breadcrumb-item active" aria-current="page">
                                            Tabel Harga
										</li>
									</ol>
								</nav>
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
						<div class="pd-20 table-responsive" style="min-height:400px;">
                            <div style="width:100%;display:flex;align-items:center;gap:10px;margin-bottom:30px;justify-content:flex-start;">
                                <span>Cari Produk</span>
                                <div class="autoComplete_wrapper">
                                    <input id="autoComplete" type="search" dir="ltr" spellcheck=false autocorrect="off" autocomplete="off" name="codekain" autocapitalize="off" onchange="loadTableHarga()">
                                </div>
                                <span>Model</span>
                                <select name="model" id="modelSelect" class="form-control" style="width:200px;" onchange="loadTableHarga()">
                                    <option value="">Pilih Produk</option>
                                </select>
                            </div>
                            
							<table class="table table-bordered stripe hover nowrap">
								<thead>
									<tr>
										<th class="table-plus datatable-nosort">No</th>
										<th>Nama Produk</th>
										<th>Model</th>
										<th>Ukuran</th>
										<th>Harga Pokok</th>
										<th>Harga Jual</th>
									</tr>
								</thead>
								<tbody id="tableHargaBody">
                                    <tr>
                                        <td colspan="6">
                                            Pilih produk untuk menampilkan harga
                                            <!-- <div style="width:100%;display:flex;justify-content:center;align-items:center"><div class="loader"></div></div> -->
                                        </td>
                                    </tr>
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
													Tambah Produsen
												</h4>
												<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
													×
												</button>
											</div>
                                            <form action="<?=base_url('save-produsen');?>" method="post">
                                            <input type="hidden" name="idtipe" value="0" id="idtipe">
											<div class="modal-body" id="modalBodyid">
                                                <label for="namadistributor">Nama Produsen</label>
                                                <input type="text" id="namadistributor" name="namadistributor" class="form-control" placeholder="Masukan Nama Produsen" required>
                                                <label for="nowa">No Telepon / WA</label>
                                                <input type="number" id="nowa" name="nowa" class="form-control" placeholder="Masukan Nomor Telephon tanpa 0/62" required>
                                                <label for="almt">Alamat Produsen</label>
                                                <textarea name="almt" class="form-control" placeholder="Masukan Alamat Produsen" id="almt"></textarea>
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
                                <div class="modal fade" id="modals2" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
									<div class="modal-dialog modal-dialog-centered">
										<div class="modal-content">
											<div class="modal-header">
												<h4 class="modal-title" id="myLargeModalLabel23">
													
												</h4>
												<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
													×
												</button>
											</div>
                                            <form action="<?=base_url('akses-produsen');?>" method="post">
                                            <input type="hidden" name="idtipe" value="0" id="idtipe2">
                                            <input type="hidden" name="idprodusen2" value="0" id="idprodusen2">
											<div class="modal-body" id="modalBodyid">
                                                <label for="namadistributor23">Nama Produsen</label>
                                                <input type="text" id="namadistributor23" name="namadistributor" class="form-control" placeholder="Masukan Nama Produsen" readonly>
                                                <label for="usernamelogin">Username Login</label>
                                                <input type="text" id="usernamelogin" name="usernames" class="form-control" placeholder="Masukan Username untuk login" required>
                                                <label for="pass">Password Login</label>
                                                <input type="text" id="pass" name="pass" class="form-control" placeholder="Masukan Password Login" required>
                                            </div>
											<div class="modal-footer">
												<button type="button" class="btn btn-default" data-dismiss="modal">
													Close
												</button>
                                                <button type="submit" class="btn btn-primary" id="idakses23">
													Buat Akses
												</button>
											</div>
                                            </form>
										</div>
									</div>
								</div>
                </div>
				
			</div>
		</div>