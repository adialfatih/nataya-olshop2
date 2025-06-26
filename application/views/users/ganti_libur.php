<div class="main-container">
			<div class="pd-ltr-20 xs-pd-20-10">
				<div class="min-height-200px">
					<div class="page-header">
						<div class="row">
							<div class="col-md-6 col-sm-12">
								<div class="title">
									<h4>Ganti Libur Mingguan Karyawan</h4>
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
											<a href="#">Libur</a>
										</li>
										<li class="breadcrumb-item active" aria-current="page">
											Karyawan
										</li>
									</ol>
								</nav>
							</div>
							<div class="col-md-6 col-sm-12 text-right">
								<div class="dropdown">
									<a class="btn btn-primary" href="<?=base_url('users/ganti-libur/add');?>" role="button">
										Ganti Libur Karyawan
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
							$bln = array(
								'01' => 'Jan', '02' => 'Feb', '03' => 'Mar', '04' => 'Apr', '05' => 'Mei', '06' => 'Jun', '07' => 'Jul', '08' => 'Agu', '09' => 'Sep', '10' => 'Okt', '11' => 'Nov', '12' => 'Des',
							);
							//echo $akses;
                        ?>
                    
					<!-- Simple Datatable start -->
					<div class="card-box mb-30">
						<div class="pd-20"></div>
						<div class="pb-20">
							<table class="data-table table stripe hover nowrap">
								<thead>
									<tr>
										<th class="table-plus datatable-nosort">No</th>
										<th>NRP</th>
										<th>Nama Karyawan</th>
										<th>Jabatan</th>
										<th>Hari Libur Sebelum</th>
										<th>Hari Libur Sekarang</th>
										<th>Di input oleh</th>
										<th class="datatable-nosort">Action</th>
									</tr>
								</thead>
								<tbody>
                                    <?php
									$qrow = $this->db->query("SELECT * FROM data_libur_ganti ORDER BY id_dlg DESC");
									if($qrow->num_rows() > 0){
										$no = 1;
										foreach($qrow->result() as $row){
										$_id = $row->id_dlg;
										$nrp = $row->nrp;
										$kar = $this->db->query("SELECT nrp,nama,jabatan FROM data_karyawan WHERE nrp = '$nrp'")->row_array();
										$nama=$kar['nama'];
										$yg = $row->yg_ganti;
										$cek=$this->db->query("SELECT nrp,nama FROM data_karyawan WHERE nrp='$yg'");
										if($cek->num_rows() == 1){
											$namausers = strtolower($cek->row("nama"));
											$namausers = ucwords($namausers);
										} else {
											$namausers = $yg;
										}
										?>
									<tr>
										<td><?=$no++;?></td>
										<td><?=$nrp;?></td>
										<td><?=$nama;?></td>
										<td><?=$kar['jabatan'];?></td>
										<td><?=$row->hari_libur_sebelum;?></td>
										<td><?=$row->hari_libur_sekarang;?></td>
										<td><?=$namausers;?></td>
										<td>
											<?php if($this->session->userdata('username') == $yg OR $this->session->userdata('nama')=='Users'){ ?>
											<div class="dropdown">
                                                <a class="btn btn-link font-24 p-0 line-height-1 no-arrow dropdown-toggle" href="#" role="button" data-toggle="dropdown">
                                                            <i class="dw dw-more"></i>
                                                </a>
                                                <div class="dropdown-menu dropdown-menu-right dropdown-menu-icon-list">
                                                    <a class="dropdown-item" href="javascript:void(0);" onclick="deletegantilibur('<?=$_id;?>','<?=$nama;?>')">
                                                        <i class="bi bi-trash3" style="color:red;"></i> Batalkan
                                                    </a>
                                                </div>
                                            </div>
											<?php } else { ?>
												<div class="dropdown">
                                                <a class="btn btn-link font-24 p-0 line-height-1 no-arrow dropdown-toggle" href="#" role="button" data-toggle="dropdown">
                                                            <i class="dw dw-more"></i>
                                                </a>
                                                <div class="dropdown-menu dropdown-menu-right dropdown-menu-icon-list">
                                                    <a class="dropdown-item" href="javascript:void(0);" onclick="blockuser()">
                                                        <i class="bi bi-trash3" style="color:red;"></i> Batalkan
                                                    </a>
                                                </div>
                                            </div>
											<?php } ?>
										</td>
									</tr>
											<?php
										}
									}
									?>
								</tbody>
							</table>
						</div>
					</div>
					<!-- Simple Datatable End -->
								
                </div>
				
			</div>
		</div>
        