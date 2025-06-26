<div class="main-container">
			<div class="pd-ltr-20 xs-pd-20-10">
				<div class="min-height-200px">
					<div class="page-header">
						<div class="row" style="display:flex;justify-content:space-between;">
							<div class="col-md-6 col-sm-12">
								<div class="title">
									<h4>Rekap Setoran Reseller</h4>
								</div>
								<nav aria-label="breadcrumb" role="navigation">
									<ol class="breadcrumb">
										<li class="breadcrumb-item">
											<a href="<?=base_url('beranda');?>">Home</a>
										</li>
                                        <li class="breadcrumb-item">
											<a href="#">Laporan</a>
										</li>
                                        <li class="breadcrumb-item">
											<a href="javascript:;">Rekap</a>
										</li>
										<li class="breadcrumb-item active" aria-current="page">
                                            Setoran
										</li>
									</ol>
								</nav>
							</div>
                            <div style="display:flex;align-items:center;gap:10px;margin-right:15px;">
                                <a class="btn btn-warning" href="javascript:void(0);" data-toggle="modal" data-target="#modals2311">
										Rekap Setoran
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
                        <p style="padding:20px 20px 0 20px;"><?=$textRekap;?></p>
						<div class="pd-20 table-responsive">
                            <table class="data-table table stripe hover nowrap">
								<thead>
									<tr>
										<th class="table-plus datatable-nosort">No</th>
										<th>Nama Reseller</th>
										<th>Tanggal Bayar</th>
										<th>Nominal</th>
										<th>Keterangan</th>
										<th class="datatable-nosort">Action</th>
									</tr>
								</thead>
								<tbody>
                        <?php
                            $qry = $this->db->query($queryRekap);
                                if($qry->num_rows() > 0){
                                $no=1;
                                    $namaArray = array();
                                    foreach($qry->result() as $val){
                                    $idres=$val->id_res;
                                    $nmRes = $this->data_model->get_byid('data_reseller', ['id_res'=>$val->id_res])->row("nama_reseller");
                                    $nmRes = strtoupper($nmRes);
                                    if(in_array($idres, $namaArray)){} else { array_push($namaArray, $idres);}
                        ?>
                                    <tr>
										<td class="table-plus"><?=$no;?></td>
										<td><?=$nmRes;?></td>
										<td><?=date('d M Y', strtotime($val->tglbyr));?></td>
										<td><?=number_format($val->nominal,0,",",".");?></td>
										<td><?=$val->ketbyr;?></td>
										<td>
											<div class="dropdown">
												<a
													class="btn btn-link font-24 p-0 line-height-1 no-arrow dropdown-toggle"
													href="#"
													role="button"
													data-toggle="dropdown"
												>
													<i class="dw dw-more"></i>
												</a>
												<div
													class="dropdown-menu dropdown-menu-right dropdown-menu-icon-list"
												>
													<a class="dropdown-item" href="#"
														><i class="dw dw-eye"></i> View</a
													>
													<a class="dropdown-item" href="#"
														><i class="dw dw-edit2"></i> Edit</a
													>
													<a class="dropdown-item" href="#"
														><i class="dw dw-delete-3"></i> Delete</a
													>
												</div>
											</div>
										</td>
									</tr>
                                    <?php
                                        $no++;
                                    } //end foreach
                                } //end if
                            ?>
                                </tbody>
                            </table>
						</div>
					</div>
                    <div class="card-box mb-30">
                        <p style="padding:20px 20px 0 20px;font-weight:bold;">Rekapitulasi Data</p>
						<div class="pd-20 table-responsive">
                            <table class="table table-bordered stripe hover">
                                <thead>
                                    <tr>
                                        <th>NO</th>
                                        <th>NAMA RESELLER</th>
                                        <th>TOTAL SETORAN</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php
                                $nos=1;
                                $allTotal = 0;
                                foreach($namaArray as $reseller){
                                    $nmRes = $this->data_model->get_byid('data_reseller', ['id_res'=>$reseller])->row("nama_reseller");
                                    $nmRes = strtoupper($nmRes);
                                    $allNominal = $this->db->query("SELECT SUM(nominal) AS jml FROM hutang_reseller_bayar WHERE id_res='$reseller' AND tglbyr BETWEEN '$tgl1' AND '$tgl2'")->row("jml");
                                    $allTotal += $allNominal;
                                    echo "<tr>";
                                    echo "<td>".$nos."</td>";
                                    echo "<td>".$nmRes."</td>";
                                    echo "<td>".number_format($allNominal,0,",",".")."</td>";
                                    echo "</tr>";
                                    $nos++;
                                }
                                ?>
                                <tr>
                                    <th></th><th>TOTAL</th><th><?=number_format($allTotal,0,",",".");?></th>
                                </tr>
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
													Rekap Setoran Reseller
												</h4>
												<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
													×
												</button>
											</div>
                                            <?php echo form_open_multipart('rekap/setoran/reseller'); ?>
											<div class="modal-body" id="modalBodyid2311">
                                                <label for="kode_bar456">Tanggal</label>
                                                <input class="form-control" name="dates" id="kode_bar456" type="text" placeholder="Masukan tanggal rekap..." />
												
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
                </div>
				
			</div>
		</div>