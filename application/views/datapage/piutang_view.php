<div class="main-container">
			<div class="pd-ltr-20 xs-pd-20-10">
				<div class="min-height-200px">
					<div class="page-header">
						<div class="row" style="display:flex;justify-content:space-between;">
							<div class="col-md-6 col-sm-12">
								<div class="title">
									<h4>Data Piutang Konveksi/Produsen</h4>
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
                                            Piutang
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
										<th>Konveksi/Produsen</th>
										<th>Alamat</th>
										<th>Nominal Piutang</th>
										<th>Nominal Pembayaran</th>
										<th>Status</th>
                                        <th></th>
									</tr>
								</thead>
								<tbody>
                                    <?php
                                    $produsen = $this->data_model->get_record('data_produsen');
                                    $no=1;
                                    foreach($produsen->result() as $val){
                                        $id = $val->id_produsen;
                                        $id2 = sha1($id);
                                        $cek = $this->data_model->get_byid('hutang_produsen',['id_produsen'=>$id]);
                                        if($cek->num_rows()>0){
                                            $total_hutang = $this->db->query("SELECT SUM(jumlah_hutang) AS jml FROM hutang_produsen WHERE id_produsen='$id'")->row("jml");
                                            $allhutang = "Rp.".number_format($total_hutang,0,',','.');
                                            $total_bayar = 0;
                                            echo "<tr>";
                                            echo "<td>".$no."</td>";
                                            echo "<td>".$val->nama_produsen."</td>";
                                            echo "<td>".$val->alamat."</td>";
                                            echo "<td>".$allhutang."</td>";
                                            echo "<td>".$total_bayar."</td>";
                                            if($total_bayar == $total_hutang){
                                                ?><td>
                                                    <a href="<?=base_url('piutang/id/'.$id2.'');?>" ><label class='badge badge-success' style="cursor:pointer;">Lunas</label></a>
                                                </td><?php
                                            } else {
                                                ?><td>
                                                    <a href="<?=base_url('piutang/id/'.$id2.'');?>"><label class='badge badge-danger' style="cursor:pointer;">Belum Lunas</label></a>
                                                </td><?php
                                            }
                                            ?>
                                            <td>
                                                <div class="dropdown">
													<a class="btn btn-link font-24 p-0 line-height-1 no-arrow dropdown-toggle" href="#" role="button" data-toggle="dropdown">
														<i class="dw dw-more"></i>
													</a>
													<div class="dropdown-menu dropdown-menu-right dropdown-menu-icon-list">
														<a class="dropdown-item" href="<?=base_url('piutang/id/'.$id2.'');?>""><i class="dw dw-edit2"></i> Lihat Piutang</a>
														
													</div>
												</div>
                                            </td>
                                            <?php
                                            echo "</tr>";
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