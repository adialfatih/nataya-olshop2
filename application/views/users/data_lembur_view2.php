<div class="main-container">
			<div class="pd-ltr-20 xs-pd-20-10">
				<div class="min-height-200px">
					<div class="page-header">
						<div class="row">
							<div class="col-md-6 col-sm-12">
								<div class="title">
									<h4>Data Lembur Karyawan</h4>
								</div>
								<nav aria-label="breadcrumb" role="navigation">
									<ol class="breadcrumb">
										<li class="breadcrumb-item">
											<a href="<?=base_url('beranda');?>">Home</a>
										</li>
                                        <li class="breadcrumb-item">
											<a href="#">Users</a>
										</li>
                                        <li class="breadcrumb-item">
											<a href="#">Data</a>
										</li>
										<li class="breadcrumb-item active" aria-current="page">
											Lembur
										</li>
									</ol>
								</nav>
							</div>
							<div class="col-md-6 col-sm-12 text-right">
								<div class="dropdown">
									<a class="btn btn-primary" href="<?=base_url('users/data-lembur/add');?>" role="button">
										+ Buat SPL
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
						<div class="pd-20">
							<!-- <h4 class="text-blue h4">Tabel Data Karyawan</h4>
							<p class="mb-0">
                                You can see all data of karyawan
								<a
									class="text-primary"
									href="https://datatables.net/"
									target="_blank"
									>Click Here</a
								>
							</p> -->
                            &nbsp;
						</div>
						<div class="pb-20 table-responsive">
							<table class="data-table table stripe hover nowrap">
								<thead>
									<tr>
										<th style='text-align:center;'>No</th>
										<th>Hari, Tanggal</th>
										<th>Departement</th>
										<th>Hari Kerja</th>
										<th>Karyawan</th>
										<th>Verif HRD</th>
										<?php echo "<th class='datatable-nosort'>Action</th>";?>
									</tr>
								</thead>
								<tbody>
									<?php
										$_qr = $this->db->query("SELECT * FROM data_lembur ORDER BY id_data_lembur DESC");
										if($_qr->num_rows() > 0){
											$no=1;
											foreach($_qr->result() as $val){
												$x = explode('-', $val->tgl_lembur);
												$_print = $x[2].' '.$bln[$x[1]].' '.$x[0];
												$_dep = strtolower($val->dep);
												$_id = $val->urlcode;
												$_lbr = $val->hari_lembur.", ".$_print;
												$_acc = $val->acc_hrd;
                                                $hari_kerja = $val->hari_kerja;
												echo "<tr>";
												echo "<td style='text-align:center;'>$no</td>";
												echo "<td style='text-align:left;'>".$_lbr."</td>";
												echo "<td style='text-align:left;'>".ucfirst($_dep)."</td>";
												echo "<td style='text-align:left;'>";
                                                if($hari_kerja == "y"){
                                                    echo "<span class='badge badge-success'>Ya</span'>";
                                                } else {
                                                    echo "<span class='badge badge-danger'>Tidak</span>";
                                                }
												
												echo "</td>";

												$jml_kar = $this->db->query("SELECT * FROM data_lembur_kar WHERE id_data_lembur='$_id'");
												if($jml_kar->num_rows() > 0){
													$ar_kar = array();
													foreach($jml_kar->result() as $kry):
														$ar_kar[] = ucwords($kry->nama);
													endforeach;
													if(count($ar_kar) > 2){
														$first_names = array_slice($ar_kar, 0, 2); // Ambil 3 nama pertama
														$remaining_count = count($ar_kar) - 2; // Hitung sisa nama
														$tes = implode(", ", $first_names) . " dan " . $remaining_count . " lainnya";
													} else {
														$tes = implode(", ", $ar_kar);
													}
													//$tes = implode(', ', $ar_kar);
													echo "<td style='text-align:left;'>$tes</td>";
												} else {
												echo "<td style='text-align:left;color:red;'>Tidak Ada Karyawan</td>";
												}

												echo "<td style='text-align:left;'>";
                                                ?><a href="<?=base_url('users/data-lembur/add/'.$_id);?>"><?php
												if($_acc == "no"){
													echo "<span class='badge badge-warning'>Pending Verification</span>";
												} elseif($_acc == "acc"){
													echo "<span class='badge badge-success'>Acc</span>";
												} else {
													echo "<span class='badge badge-danger'>Reject</span>";
												}
												echo "</a></td>";
												
												?>
												<td>
													<div class="dropdown">
                                                        <a class="btn btn-link font-24 p-0 line-height-1 no-arrow dropdown-toggle" href="#" role="button" data-toggle="dropdown">
                                                            <i class="dw dw-more"></i>
                                                        </a>
                                                        <div class="dropdown-menu dropdown-menu-right dropdown-menu-icon-list">
                                                            <a class="dropdown-item" href="<?=base_url('users/data-lembur/add/'.$_id);?>">
                                                                <i class="dw dw-eye"></i> View
                                                            </a>
                                                            <a class="dropdown-item" href="javascript:void(0);" onclick="lbrs('<?=$_id;?>','<?=$_dep;?>','<?=$_lbr;?>')" data-toggle="modal" data-target="#Medium-modal">
                                                                <i class="dw dw-delete-3"></i> Delete
                                                            </a>
                                                        </div>
                                                    </div>
												</td>
												<?php
												
												echo "</tr>";
												$no++;
											}
										} else {
											echo "<tr><td colspan='6'>Tidak ada data lembur</td></tr>";
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
													Hapus Lembur
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
                                            <form action="<?=base_url('userproses/deletelembur');?>" method="post">
											<div class="modal-body">
                                                <div style="display:flex;flex-direction:column;">
                                                    <span>Lembur</span>
                                                    <input type="text" name="harilmebur" class="form-control" id="harilmebur" readonly>
                                                    <input type="hidden" id="idlembur" name="idlembur" value="0">
                                                </div>
												<div style="display:flex;flex-direction:column;">
                                                    <span>Departement</span>
                                                    <input type="text" name="depids" class="form-control" id="depids" readonly>
                                                </div>
                                                <br>
												<p>
													Anda akan menghapus Surat Perintah Lembur. Klik Hapus untuk melanjutkan!!
												</p>
											</div>
											<div class="modal-footer">
												<button
													type="button"
													class="btn btn-secondary"
													data-dismiss="modal"
												>
													Batal
												</button>
												<button type="submit" class="btn btn-danger">
													Hapus
												</button>
											</div>
                                            </form>
										</div>
									</div>
								</div>	
                </div>
				
			</div>
		</div>
        