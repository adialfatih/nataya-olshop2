<div class="main-container">
			<div class="pd-ltr-20 xs-pd-20-10">
				<div class="min-height-200px">
					<div class="page-header">
						<div class="row">
							<div class="col-md-6 col-sm-12">
								<div class="title">
									<h4>Data Cuti Karyawan users</h4>
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
											<a href="#">Cuti</a>
										</li>
										<li class="breadcrumb-item active" aria-current="page">
											Karyawan 
										</li>
									</ol>
								</nav>
							</div>
							<div class="col-md-6 col-sm-12 text-right">
								<div class="dropdown">
									<a class="btn btn-primary" href="<?=base_url('input-data-cuti');?>" role="button">
										+ Tambah Data
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
                        ?>
                    
					<!-- Simple Datatable start -->
					<div class="card-box mb-30">
						<div class="pd-20">
						</div>
						<div class="pb-20">
							<table class="data-table table stripe hover nowrap">
								<thead>
									<tr>
										<th class="table-plus datatable-nosort">No</th>
										<th>Nama Karyawan</th>
										<!-- <th>Departement </th> -->
										<th>Divisi</th>
										<th>Jabatan</th>
										<th>Tanggal Cuti</th>
										<th>Lama Cuti</th>
										<th>Diinput Oleh</th>
										<th class="datatable-nosort">Action</th>
									</tr>
								</thead>
								<tbody>
                                    <?php
                                    $ar = ['01'=>'Jan', '02'=>'Feb', '03'=>'Mar', '04'=>'Apr', '05'=>'May', '06'=>'Jun', '07'=>'Jul', '08'=>'Ags', '09'=>'Sep', '10'=>'Okt', '11'=>'Nov', '12'=>'Des'];
                                    if($qry->num_rows() > 0){
                                        foreach($qry->result() as $row => $value){
                                        $nrp = $value->nrp;
                                        $rz = $this->db->query("SELECT nrp,nama,departement,divisi,jabatan FROM data_karyawan WHERE nrp='$nrp' ")->row_array();
                                        $nama = strtolower($rz['nama']);
                                        $departement = strtolower($rz['departement']);
                                        $divisi = strtolower($rz['divisi']);
                                        $jabatan = strtolower($rz['jabatan']);
                                        $x = explode('-', $value->tanggal_cuti);
                                        $xx = $x[2].' '.$ar[$x[1]].' '.$x[0];
                                        $kiy = $value->kode_input;
                                        $oleh = $value->oleh;
                                    ?>
                                    <tr>
                                        <td><?=$row+1;?></td>
                                        <td><?=ucwords($nama);?></td>
                                        <!-- <td><=ucwords($departement);?></td> -->
                                        <td><?=ucwords($divisi);?></td>
                                        <td><?=ucwords($jabatan);?></td>
                                        <td><?=$xx;?></td>
                                        <td><?=$value->lama_cuti;?> Hari</td>
                                        <td><?=$oleh;?></td>
                                        <td>
                                            <div class="dropdown">
                                                        <a class="btn btn-link font-24 p-0 line-height-1 no-arrow dropdown-toggle" href="#" role="button" data-toggle="dropdown">
                                                            <i class="dw dw-more"></i>
                                                        </a>
                                                        <div class="dropdown-menu dropdown-menu-right dropdown-menu-icon-list">
                                                            <a class="dropdown-item" href="javascript:void(0);" onclick="viewCut('<?=$kiy;?>')" data-toggle="modal" data-target="#Medium-modal">
                                                                <i class="dw dw-eye"></i> View
                                                            </a>
                                                            <?php
                                                            $akses = $this->session->userdata('akses');
                                                            if($akses == "user"){
                                                                if($sess_nama == $oleh){
                                                                    ?>
                                                                    <a class="dropdown-item" href="javascript:void(0);" onclick="delCut('<?=ucwords($nama);?>','<?=$kiy;?>')">
                                                                        <i class="dw dw-delete-3"></i> Delete 
                                                                    </a>
                                                                    <?php
                                                                } else {
                                                                    ?>
                                                                    <a class="dropdown-item" href="javascript:void(0);" onclick="noakses()">
                                                                        <i class="dw dw-delete-3"></i> Delete 
                                                                    </a>
                                                                    <?php
                                                                }
                                                            } else {
                                                            ?>
                                                            <a class="dropdown-item" href="javascript:void(0);" onclick="delCut('<?=ucwords($nama);?>','<?=$kiy;?>')">
                                                                <i class="dw dw-delete-3"></i> Delete 
                                                            </a>
                                                            <?php } ?>
                                                        </div>
                                                    </div>  
                                        </td>
                                    </tr>
                                    <?php
                                        } //end foreach
                                    } else {
                                        echo "<tr><td colspan='8'>Tidak ada data</td></tr>";
                                    }
                                    ?>
								</tbody>
							</table>
						</div>
					</div>
					<!-- Simple Datatable End -->
								<div class="modal fade" id="Medium-modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
									<div class="modal-dialog modal-dialog-centered">
										<div class="modal-content">
											<div class="modal-header">
												<h4 class="modal-title" id="myLargeModalLabel">
													Data Cuti
												</h4>
												<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
													×
												</button>
											</div>
											<div class="modal-body" id="modalBodyid"></div>
											<div class="modal-footer">
												<button type="button" class="btn btn-secondary" data-dismiss="modal">
													Close
												</button>
											</div>
										</div>
									</div>
								</div>
                </div>
				
			</div>
		</div>
        <input type="hidden" id="tgl_masuk">
        <input type="hidden" id="tahunids">
        <input type="hidden" id="bulanids">