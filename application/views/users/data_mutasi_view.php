<div class="main-container">
			<div class="pd-ltr-20 xs-pd-20-10">
				<div class="min-height-200px">
					<div class="page-header">
						<div class="row">
							<div class="col-md-6 col-sm-12">
								<div class="title">
									<h4>Data Mutasi Karyawan</h4>
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
											<a href="#">Mutasi</a>
										</li>
										<li class="breadcrumb-item active" aria-current="page">
											Karyawan
										</li>
									</ol>
								</nav>
							</div>
							<div class="col-md-6 col-sm-12 text-right">
								<div class="dropdown">
									<a class="btn btn-primary" href="<?=base_url('users/mutasi-karyawan/add');?>" role="button">
										Mutasi Baru
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
						<div class="pd-20">&nbsp;</div>
						<div class="table-responsive">
							<table class="data-table table stripe hover nowrap">
								<thead>
									<tr>
										<th style='text-align:center;'>No</th>
										<th>Hari, Tanggal</th>
										<th>Karyawan</th>
										<th>Divisi Sebelum</th>
										<!-- <th>Jabatan Sebelum</th> -->
										<th>Divisi Sesudah</th>
										<!-- <th>Jabatang Sesudah</th> -->
                                        <th>Dimutasi Oleh</th>
										<th>Action</th>
									</tr>
								</thead>
								<tbody>
                                    <?php
									$akses = $this->session->userdata('akses');
									$id = $this->session->userdata('username');
									if($akses =="user"){
										$dtrow = $this->db->query("SELECT * FROM data_mutasi WHERE yg_input='$id'");
									} else {
										$dtrow = $this->data_model->sort_record('tanggal_perubahan','data_mutasi');
									}
                                    
                                    if($dtrow->num_rows() > 0){
                                        
                                        $no = 1;
                                        foreach($dtrow->result() as $val){
                                        $idmut = $val->id_mutasi;
                                        $tgl = $val->tanggal_perubahan;
                                        $timestamp = strtotime($tgl);
                                        $day_name = date('l', $timestamp);
                                        $day_name_indonesia = ["Sunday" => "Minggu", "Monday" => "Senin", "Tuesday" => "Selasa", "Wednesday" => "Rabu", "Thursday" => "Kamis", "Friday" => "Jumat", "Saturday" => "Sabtu"];
                                        $nama_hari = $day_name_indonesia[$day_name];
                                        $x = explode('-', $tgl);
                                        $tgl = $x[2].' '.$bln[$x[1]].' '.$x[0];
                                        $nrp = $val->nrp;
                                        $nrp2 = $val->yg_input;
                                        $nama = $this->data_model->get_byid('data_karyawan', ['nrp'=>$nrp])->row('nama');
										$cekyg_input = $this->db->query("SELECT nrp,nama FROM data_karyawan WHERE nrp='$nrp2'");
										if($cekyg_input->num_rows() == 1){
											$yginput2 = strtolower($cekyg_input->row("nama")); ;
											$yginput = ucwords($yginput2);
										} else {
											$yginput = ucwords($val->yg_input);
										}
                                    ?>
                                    <tr>
                                        <td style='text-align:center;'><?=$no++?></td>
                                        <td><?=$nama_hari.', '.$tgl;?></td>
                                        <td><?=$nama;?></td>
                                        <td><?=$val->div_sebelum;?></td>
                                        <td><?=$val->div_sesudah;?></td>
                                        <td><?=$yginput;?></td>
                                        <td>
										
                                            <div class="dropdown">
												<a class="btn btn-link font-24 p-0 line-height-1 no-arrow dropdown-toggle"
													href="#"
													role="button"
													data-toggle="dropdown"
												>
													<i class="dw dw-more"></i>
												</a>
												<div class="dropdown-menu dropdown-menu-right dropdown-menu-icon-list">
													<?php if($this->session->userdata('username') == $nrp2 OR $this->session->userdata('akses')=='super'){ ?>
													<a class="dropdown-item" href="javascript:void(0);" onclick="muts('<?=$idmut;?>','<?=$nama;?>')" data-toggle="modal"
                                                    data-target="#Medium-modal"><i class="bi bi-arrow-counterclockwise"></i> Batalkan</a>
													<?php } else { ?>
													<a class="dropdown-item" href="javascript:void(0);" onclick="blockuser()"><i class="bi bi-arrow-counterclockwise"></i> Batalkan</a>
													<?php } ?>
												</div>
											</div>
										
                                        </td>
                                    </tr>
                                        <?php
                                        }
                                    } else {
                                        echo "<tr><td colspan='7'>Tidak ada data mutasi</td></tr>";
                                    }
                                    ?>
								</tbody>
							</table>
						</div>
					</div>
					<!-- Simple Datatable End -->
					<!-- Popup -->
                    <div
									class="modal fade"
									id="Medium-modal"
									tabindex="-1"
									role="dialog"
									aria-labelledby="myLargeModalLabel"
									aria-hidden="true"
								>
									<div class="modal-dialog modal-dialog-centered">
										<div class="modal-content">
											<div class="modal-header">
												<h4 class="modal-title" id="myLargeModalLabel">
													Hapus Mutasi
												</h4>
												<button
													type="button"
													class="close"
													data-dismiss="modal"
													aria-hidden="true"
												>
													×
												</button>
											</div>
                                            <form action="<?=base_url('userproses/reversemutasi');?>" method="post">
											<div class="modal-body">
                                                <div style="display:flex;flex-direction:column;">
                                                    <span>Nama Karyawan</span>
                                                    <input type="text" name="nmkarid" class="form-control" id="nmkarid" readonly>
                                                    <input type="hidden" id="idmutasi" name="idmutasi" value="0">
                                                </div>
                                                <br>
												<p>
													Proses ini akan menghapus data mutasi karyawan dan mengembalikan karyawan ke divisi sebelumnya.
												</p>
											</div>
											<div class="modal-footer">
												<button
													type="button"
													class="btn btn-secondary"
													data-dismiss="modal"
												>
													Close
												</button>
												<button type="submit" class="btn btn-primary">
													Save changes
												</button>
											</div>
                                            </form>
										</div>
									</div>
								</div>		
                </div>
				
			</div>
		</div>
        