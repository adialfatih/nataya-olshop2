<div class="main-container">
			<div class="pd-ltr-20 xs-pd-20-10">
				<div class="min-height-200px">
					<div class="page-header">
						<div class="row" style="display:flex;justify-content:space-between;">
							<div class="col-md-6 col-sm-12">
								<div class="title">
									<h4>Data Produk Masuk</h4>
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
											<a href="javascript:;">Produk</a>
										</li>
										<li class="breadcrumb-item active" aria-current="page">
                                            Masuk
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
										<th>Tanggal Masuk</th>
										<th>No SJ</th>
										<th>Produsen / Konveksi</th>
										<th>Jumlah Produk</th>
										<th>Nominal</th>
										<th>Diinput Oleh</th>
									</tr>
								</thead>
								<tbody>
                                    <?php
                                    $no=1;
                                    if($indata->num_rows() > 0){
                                        foreach($indata->result() as $val){
                                            $formattedDate = date('d M Y', strtotime($val->tgl_masuk));
                                            $cd = $val->codeinput;
                                            $prod = $this->data_model->get_byid('data_produsen',['id_produsen'=>$val->id_produsen])->row("nama_produsen");
                                            $jml = $this->db->query("SELECT SUM(jumlah) AS jml FROM data_produk_stok_masuk_notes WHERE codeinput='$cd'")->row('jml');
                                            $nilai = number_format($val->total_nilai_barang,0,',','.');
                                            echo "<tr>";
                                            echo "<td>{$no}</td>";
                                            echo "<td>{$formattedDate}</td>";
                                            echo "<td>";
                                            ?><a href="<?=base_url('data-stok/masuk/'.$cd);?>" style="color:blue;"><?=$val->suratjalan;?></a><?php
                                            echo "</td>";
                                            echo "<td>{$prod}</td>";
                                            echo "<td>{$jml} Pcs</td>";
                                            echo "<td>Rp. {$nilai}</td>";
                                            echo "<td>{$val->yg_input}</td>";
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