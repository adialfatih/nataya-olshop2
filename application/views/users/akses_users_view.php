<div class="main-container">
			<div class="pd-ltr-20 xs-pd-20-10">
				<div class="min-height-200px">
					<div class="page-header">
						<div class="row">
							<div class="col-md-6 col-sm-12">
								<div class="title">
									<h4>Data Akses Karyawan</h4>
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
											<a href="#">Akses</a>
										</li>
										<li class="breadcrumb-item active" aria-current="page">
											Users
										</li>
									</ol>
								</nav>
							</div>
                            <div class="col-md-6 col-sm-12 text-right">
								<div class="dropdown">
									<a class="btn btn-primary" href="javascript:void(0);" role="button" data-toggle="modal" data-target="#Medium-modal">
										+ Tambah Users
									</a>
								</div>
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
                    <!-- <div class="card-box mb-30" style="padding:20px;">
                        Lorem, ipsum dolor sit amet consectetur adipisicing elit. Labore optio dicta qui at assumenda nisi iste hic quas et, nihil vitae laudantium sint maiores omnis itaque aliquid similique maxime. Necessitatibus?
                    </div> -->
					<!-- Simple Datatable start -->
                     <?php
                     if($akses == "user"){ ?>
                    <div class="card-box mb-30">
                        <div class="pd-20" style="background:#ccc;font-size:12px;border-radius:10px 10px 0px 0px;">
                            Data karyawan yang memiliki akses ke aplikasi.
                        </div>
                        <div class="pd-20 table-responsive">
                            <h1>HALAMAN INI TIDAK BISA DI AKSES OLEH ANDA</h1>
						</div>
					</div>
<?php
                     } else {
                     ?>
					<div class="card-box mb-30">
                        <div class="pd-20" style="background:#ccc;font-size:12px;border-radius:10px 10px 0px 0px;">
                            Data karyawan yang memiliki akses ke aplikasi.
                        </div>
                        <div class="pd-20 table-responsive">
                            <table class="data-table table stripe hover nowrap">
                            <!-- <table class="table table-bordered table-hover table-striped"> -->
                                <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>Nama</th>
                                        <th>Username</th>
                                        <th>Password</th>
                                        <th>Akses</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $dts = $this->data_model->get_record('table_users');
                                    $no = 1;
                                    foreach ($dts->result() as $dt) {
                                        $iduser = $dt->idusers;
                                        if($dt->akses == "super"){} else {
                                    ?>
                                    <tr>
                                        <td><?=$no++?></td>
                                        <td><?=$dt->nama_users;?></td>
                                        <td><?=$dt->username;?></td>
                                        <td>******</td>
                                        <td><?=$dt->akses=="'ADM'" ? 'HRD' : $dt->akses;?></td>
                                        <td>
                                            <div class="dropdown">
                                                <a class="btn btn-link font-24 p-0 line-height-1 no-arrow dropdown-toggle" href="#" role="button" data-toggle="dropdown">
                                                    <i class="dw dw-more"></i>
                                                </a>
                                                <div class="dropdown-menu dropdown-menu-right dropdown-menu-icon-list">
                                                    <a class="dropdown-item" href="javascript:void(0);" onclick="ubahpassuser('<?=$iduser;?>','<?=$dt->nama_users;?>')">
                                                            <i class="bi bi-key"></i> Ubah Password
                                                    </a>
                                                    <a class="dropdown-item" href="javascript:void(0);" onclick="hapusUsers('<?=$iduser;?>','<?=$dt->nama_users;?>')">
                                                        <i class="dw dw-delete-3"></i> Delete User
                                                    </a>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <?php } } ?>
                                </tbody>
                            </table>
						</div>
					</div>
                    <?php } ?>
					<!-- Simple Datatable End -->
                                <div class="modal fade" id="Medium-modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
									<div class="modal-dialog modal-dialog-centered">
										<div class="modal-content">
											<div class="modal-header">
												<h4 class="modal-title" id="myLargeModalLabel">
													Tambah Users
												</h4>
												<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
													×
												</button>
											</div>
                                            <form action="<?=base_url('userproses/addnewuser');?>" method="post">
											<div class="modal-body">
                                                <div style="width:100%;display:flex;align-items:center;gap:10px;">
                                                    <span>Karyawan</span>
                                                    <div class="form-label">
                                                        <div class="autoComplete_wrapper">
                                                            <input id="autoComplete" type="search" dir="ltr" spellcheck=false autocorrect="off" autocomplete="off" name="nrp" autocapitalize="off" required>
                                                        </div>
                                                    </div>
                                                </div>
												<div style="width:100%;display:flex;align-items:center;gap:10px;margin-top:20px;">
                                                    <span style="width:120px;">Password</span>
                                                    <input type="text" name="password" class="form-control" placeholder="Masukan password" style="width:calc(100% - 120px); ">
                                                </div>
                                                <div style="width:100%;display:flex;align-items:center;gap:10px;margin-top:20px;">
                                                    <span style="width:120px;">Akses</span>
                                                    <input type="text" class="form-control" value="user" style="width:calc(100% - 120px); " readonly>
                                                </div>
											</div>
											<div class="modal-footer">
												<button type="button" class="btn btn-secondary" data-dismiss="modal">
													Close
												</button>
												<button type="submit" class="btn btn-primary">
													Save
												</button>
											</div>
                                            </form>
										</div>
									</div>
								</div>
                                
                </div>
				
			</div>
		</div>
        