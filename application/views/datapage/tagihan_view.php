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
										<th>Supplier / PT</th>
										<th>Jumlah Tagihan</th>
										<th>Total Nominal</th>
										<th>Total Pembayaran</th>
										<th>Status</th>
										<th class="datatable-nosort">Action</th>
									</tr>
								</thead>
								<tbody>
                                    <?php
                                    if($tgh->num_rows() > 0){
                                        $no=1;
                                        foreach($tgh->result() as $val){
                                        //$id_tagihan = sha1($val->id_tagihan);
                                        $nm=$val->nama_supplier;
                                        $jumlah_tagihan = $this->data_model->get_byid('tagihan',['nama_supplier'=>$nm])->num_rows();
                                        $nominal = $this->db->query("SELECT SUM(nominal_tagihan) AS jml FROM tagihan WHERE nama_supplier='$nm'")->row("jml");
                                        $nominal_bayar = $this->db->query("SELECT SUM(nominal_bayar) AS jml FROM tagihan_bayar WHERE nm='$nm'")->row("jml");
                                        $nama_encrypt = $this->data_model->safe_base64_encode($nm);
                                    ?>
                                    <tr>
                                        <td><?=$no;?></td>
                                        <td><?=strtoupper($val->nama_supplier);?></td>
                                        <td><?=$jumlah_tagihan;?></td>
                                        <td>Rp. <?=number_format($nominal,0,',','.');?></td>
                                        <td>Rp. <?=number_format($nominal_bayar,0,',','.');?></td>
                                        <td>
                                            <?php if($nominal == $nominal_bayar){ ?>
                                                <span class="badge badge-success">Lunas</span>
                                            <?php } else { if($nominal > $nominal_bayar){
                                                echo '<span class="badge badge-danger">Belum Lunas</span>';
                                            } else { ?>
                                                <span class="badge badge-warning">Lebih Bayar</span>  
                                            <?php } } ?>
                                        </td>
                                        <td>
                                            <div class="dropdown">
                                                <a class="btn btn-link font-24 p-0 line-height-1 no-arrow dropdown-toggle" href="#" role="button" data-toggle="dropdown">
                                                    <i class="dw dw-more"></i>
                                                </a>
                                                <div class="dropdown-menu dropdown-menu-right dropdown-menu-icon-list">
                                                    <a class="dropdown-item" href="<?=base_url('tagihan/id/'.$nama_encrypt);?>">Detail</a>
                                                    
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