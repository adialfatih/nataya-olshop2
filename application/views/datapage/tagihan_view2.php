<div class="main-container">
			<div class="pd-ltr-20 xs-pd-20-10">
				<div class="min-height-200px">
					<div class="page-header">
						<div class="row" style="display:flex;justify-content:space-between;">
							<div class="col-md-6 col-sm-12">
								<div class="title">
									<h4>Management Data Tagihan Pembayaran</h4>
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
											<a href="javascript:;">Cash Flow</a>
										</li>
										<li class="breadcrumb-item active" aria-current="page">
                                            Tagihan
										</li>
									</ol>
								</nav>
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
						<div class="pd-20 table-responsive">
                            <table class="data-table table stripe hover nowrap">
								<thead>
									<tr>
                                        <th>No</th>
                                        <th>Tanggal</th>
										<th>Jenis Tagihan</th>
										<th>Supplier / PT</th>
										<th>Nominal</th>
										<th>Status</th>
										<th class="datatable-nosort">Action</th>
									</tr>
								</thead>
								<tbody>
                                    <?php
                                    if($tgh->num_rows() > 0){
                                        $no=1;
                                        foreach($tgh->result() as $val){
                                        $id_tagihan = sha1($val->id_tagihan);
                                            ?>
                                    <tr>
                                        <td><?=$no;?></td>
                                        <td><?=date('d M Y', strtotime($val->tgl_awal_tagihan));?></td>
                                        <td><?=$val->jenis_tagihan;?></td>
                                        <td><?=strtoupper($val->nama_supplier);?></td>
                                        <td>Rp. <?=number_format($val->nominal_tagihan,0,',','.');?></td>
                                        <td>
                                            <?php
                                            if($val->status == 'Belum Lunas'){?>
                                                <span class="badge badge-danger">Belum Lunas</span>
                                            <?php }
                                            elseif($val->status == 'Lunas'){?>
                                                <span class="badge badge-success">Lunas</span>    
                                            <?php }
                                            ?>
                                        </td>
                                        <td>
                                            <div class="dropdown">
                                                <a class="btn btn-link font-24 p-0 line-height-1 no-arrow dropdown-toggle" href="#" role="button" data-toggle="dropdown">
                                                    <i class="dw dw-more"></i>
                                                </a>
                                                <div class="dropdown-menu dropdown-menu-right dropdown-menu-icon-list">
                                                    <a class="dropdown-item" href="<?=base_url('tagihan/id/'.$id_tagihan);?>">Detail</a>
                                                    
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                            <?php
                                            $no++;
                                        }
                                    }
                                    ?>
								</tbody>
							</table>
						</div>
					</div>
                    <!-- tampilan jika pengiriman keluar -->
                    
					<!-- Simple Datatable End -->
                                
                </div>
				
			</div>
		</div>