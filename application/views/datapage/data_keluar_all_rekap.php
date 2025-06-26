<div class="main-container">
			<div class="pd-ltr-20 xs-pd-20-10">
				<div class="min-height-200px">
					<div class="page-header">
						<div class="row" style="display:flex;justify-content:space-between;">
							<div class="col-md-6 col-sm-12">
								<div class="title">
									<h4>Data Pengeluaran Stok Gudang</h4>
								</div>
								<nav aria-label="breadcrumb" role="navigation">
									<ol class="breadcrumb">
										<li class="breadcrumb-item">
											<a href="<?=base_url('beranda');?>">Home</a>
										</li>
                                        <li class="breadcrumb-item">
											<a href="#">Stok</a>
										</li>
                                        <li class="breadcrumb-item">
											<a href="javascript:;">Keluar</a>
										</li>
										<li class="breadcrumb-item active" aria-current="page">
                                            Rekap
										</li>
									</ol>
								</nav>
							</div>
                            <div style="display:flex;align-items:center;gap:10px;margin-right:15px;">
                                 <a class="btn btn-success" href="javscript:void(0);" data-toggle="modal" data-target="#modals2311">
                                    <i class="icon-copy bi bi-search"></i>&nbsp; Rekap Data
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
                            $cek = $this->db->query($queryRekap);
							//echo $queryRekap;
                            $idProduk = array();
                            foreach($cek->result() as $val){
                                if(in_array($val->id_produk, $idProduk)){} else {
									$idProduk[] = $val->id_produk;
								}
                            }
							//echo $queryRekap;
                        ?>
					<!-- Simple Datatable start -->
					<div class="card-box mb-30">
                        <p style="padding:20px 20px 0 20px;"><?=$textRekap;?></p>
						<div class="pd-20 table-responsive">
                            <table class="table table-bordered stripe hover nowrap">
								<thead>
								<?php
								//if($rekapTipe == 1){
									echo "<tr>";
									echo "<th rowspan='2' style='text-align:center;'>Motif</th>";
									echo "<th rowspan='2' style='text-align:center;'>Warna</th>";
									echo "<th style='text-align:center;'>M</th>";
									echo "<th style='text-align:center;'>L</th>";
									echo "<th style='text-align:center;'>XL</th>";
									echo "<th style='text-align:center;'>XXL</th>";
									echo "<th style='text-align:center;'>XXXL</th>";
									echo "<th style='text-align:center;'>4XL</th>";
									echo "<th rowspan='2' style='text-align:center;'>Jumlah</th>";
									echo "<th rowspan='2' style='text-align:center;'>Jumlah Total</th>";
									echo "</tr>";
									echo "<tr>";
									echo "<th style='text-align:center;'>6</th>";
									echo "<th style='text-align:center;'>8</th>";
									echo "<th style='text-align:center;'>10</th>";
									echo "<th style='text-align:center;'>12</th>";
									echo "<th style='text-align:center;'>14</th>";
									echo "<th style='text-align:center;'>16</th>";
									echo "</tr>";
								// } else {
								// 	echo "<tr>";
								// 	echo "<td>Tanggal Keluar</td>";
								// 	echo "<td>Produk</td>";
								// 	echo "</tr>";
								// }
								?>
								</thead>
								<tbody>
                                <?php
                                    //if($rekapTipe == 1){
										//sort($idProduk);
										$_segalanyaTotal = 0;
										for ($i=0; $i <count($idProduk) ; $i++) {
										$id_produk = $idProduk[$i];
										$namaProduk = $this->db->query("SELECT nama_produk FROM data_produk WHERE id_produk='$id_produk'")->row("nama_produk");
										$qr1 = $queryRekap." AND id_produk='$id_produk'";
										//echo $qr1."<br>";
										$jmlTerjual = $this->db->query($qr1)->num_rows();
											$qr2 = $this->db->query($qr1." GROUP BY kode_bar1");
										//echo $qr1." GROUP BY kode_bar1<br>";
											$kode_bar1 = array();
											foreach($qr2->result() as $val){
												$xModel2 = explode('-', $val->kode_bar1);
												$xModel = $xModel2[0];
												if(in_array($xModel, $kode_bar1)){} else {
													$kode_bar1[] = $xModel;
												}
											}
											$rowspan = count($kode_bar1);
										//echo "<td>".number_format($jmlTerjual,0,",",".")."</td>";
										//echo "<td>";
											for ($a=0; $a <count($kode_bar1) ; $a++) { 
												$warna = $kode_bar1[$a];
												$model = $this->db->query("SELECT * FROM data_produk_detil WHERE kode_bar='$warna' LIMIT 1")->row_array();
												$modelwarna = $model['warna_model'];
												$ukuran = $model['ukuran'];
												$_kodebar = $model['kode_bar'];
												$qr3 = $qr1." AND kode_bar1 LIKE '".$warna."%'";
												//$qr4 = $qr1." AND kode_bar1 = '".$warna."'";
												$_sendJml = $this->db->query($qr3)->num_rows();
												$tampilanJumlahNyamping = 0;
												//echo $modelwarna." - ".$ukuran." : <strong>".$_sendJml."</strong> Pcs<br>";
												echo "<tr>";
												if($a==0){ echo "<td rowspan='$rowspan'>".$namaProduk."</td>"; }
												echo "<td>".$modelwarna."</td>";
												echo "<td>"; 
															$_kodebar1 = $_kodebar."-M";
															$_kodebar11 = $_kodebar."-6";
															$qr4 = $qr1." AND kode_bar1 = '$_kodebar1'";
															$qr41 = $qr1." AND kode_bar1 = '$_kodebar11'";
															//echo $qr4;
															$_sendJml2 = $this->db->query($qr4)->num_rows();
															$_sendJml21 = $this->db->query($qr41)->num_rows();
															$_alljmlUkr = intval($_sendJml2) + intval($_sendJml21);
															echo $_alljmlUkr;
															$tampilanJumlahNyamping += $_alljmlUkr;
												echo "</td>";

												echo "<td>"; 
															$_kodebar1 = $_kodebar."-L";
															$_kodebar11 = $_kodebar."-8";
															$qr4 = $qr1." AND kode_bar1 = '$_kodebar1'";
															$qr41 = $qr1." AND kode_bar1 = '$_kodebar11'";
															//echo $qr4;
															$_sendJml2 = $this->db->query($qr4)->num_rows();
															$_sendJml21 = $this->db->query($qr41)->num_rows();
															$_alljmlUkr = intval($_sendJml2) + intval($_sendJml21);
															echo $_alljmlUkr;
															$tampilanJumlahNyamping += $_alljmlUkr;
												echo "</td>";

												echo "<td>"; 
															$_kodebar1 = $_kodebar."-XL";
															$_kodebar11 = $_kodebar."-10";
															$qr4 = $qr1." AND kode_bar1 = '$_kodebar1'";
															$qr41 = $qr1." AND kode_bar1 = '$_kodebar11'";
															//echo $qr4;
															$_sendJml2 = $this->db->query($qr4)->num_rows();
															$_sendJml21 = $this->db->query($qr41)->num_rows();
															$_alljmlUkr = intval($_sendJml2) + intval($_sendJml21);
															echo $_alljmlUkr;
															$tampilanJumlahNyamping += $_alljmlUkr;
												echo "</td>";

												echo "<td>"; 
															$_kodebar1 = $_kodebar."-XXL";
															$_kodebar11 = $_kodebar."-12";
															$qr4 = $qr1." AND kode_bar1 = '$_kodebar1'";
															$qr41 = $qr1." AND kode_bar1 = '$_kodebar11'";
															//echo $qr4;
															$_sendJml2 = $this->db->query($qr4)->num_rows();
															$_sendJml21 = $this->db->query($qr41)->num_rows();
															$_alljmlUkr = intval($_sendJml2) + intval($_sendJml21);
															echo $_alljmlUkr;
															$tampilanJumlahNyamping += $_alljmlUkr;
												echo "</td>";

												echo "<td>"; 
															$_kodebar1 = $_kodebar."-XXXL";
															$_kodebar11 = $_kodebar."-14";
															$qr4 = $qr1." AND kode_bar1 = '$_kodebar1'";
															$qr41 = $qr1." AND kode_bar1 = '$_kodebar11'";
															//echo $qr4;
															$_sendJml2 = $this->db->query($qr4)->num_rows();
															$_sendJml21 = $this->db->query($qr41)->num_rows();
															$_alljmlUkr = intval($_sendJml2) + intval($_sendJml21);
															echo $_alljmlUkr;
															$tampilanJumlahNyamping += $_alljmlUkr;
												echo "</td>";
												echo "<td>"; 
															$_kodebar1 = $_kodebar."-4XL";
															$_kodebar11 = $_kodebar."-16";
															$qr4 = $qr1." AND kode_bar1 = '$_kodebar1'";
															$qr41 = $qr1." AND kode_bar1 = '$_kodebar11'";
															//echo $qr4;
															$_sendJml2 = $this->db->query($qr4)->num_rows();
															$_sendJml21 = $this->db->query($qr41)->num_rows();
															$_alljmlUkr = intval($_sendJml2) + intval($_sendJml21);
															echo $_alljmlUkr;
															$tampilanJumlahNyamping += $_alljmlUkr;
												echo "</td>";
												echo "<td>$tampilanJumlahNyamping</td>";
												if($a==0){ echo "<td rowspan='$rowspan' style='text-align:center;'>$jmlTerjual</td>"; }
												echo "</tr>";
											}
										//echo "</td>";
										$_segalanyaTotal+=$jmlTerjual;
										}
									// } else {
									// 	$startDate = new DateTime($tgl1);
									// 	$endDate = new DateTime($tgl2);
									// 	$endDate->modify('+1 day');
									// 	$interval = new DateInterval('P1D');
									// 	$dateRange = new DatePeriod($startDate, $interval, $endDate);
									// 	foreach ($dateRange as $date) {
									// 		$dateFormat = $date->format('Y-m-d');
									// 		$showTgl = date('d M Y', strtotime($dateFormat));
									// 		$qr1 = "SELECT * FROM v_pengeluaran WHERE tgl_out='$dateFormat'";
									// 		if($tipejual!="All"){ $qr1 .= " AND tujuan='$tipejual'"; }
									// 		if($nama!=""){ $qr1 .= " AND nama_tujuan ='$nama'"; }
									// 		$cek = $this->db->query($qr1);
									// 		$_idProduk = array();
									// 		foreach($cek->result() as $val){
									// 			if(in_array($val->id_produk, $_idProduk)){} else {
									// 				$_idProduk[] = $val->id_produk;
									// 			}
									// 		}
									// 		echo "<tr>";
									// 		echo "<td><font style='color:blue;font-weight:bold;'>".$showTgl."</font></td>";
									// 		echo "<td>";
									// 		echo "<table>";
									// 		foreach($_idProduk as $val){
									// 			$namaProduk = $this->db->query("SELECT id_produk,nama_produk FROM data_produk WHERE id_produk='$val'")->row("nama_produk");
									// 			$qr2 = $qr1." AND id_produk='$val'";
									// 			$qr2 = $this->db->query($qr2);
									// 			echo "<tr>";
									// 			echo "<td>".$namaProduk." (<strong style='color:red;'>".$qr2->num_rows()."</strong> Pcs)</td>";
									// 			$ukuranJual = array();
									// 			foreach($qr2->result() as $ukr){
									// 				if(in_array($ukr->kode_bar1, $ukuranJual)){} else {
									// 					$ukuranJual[] = $ukr->kode_bar1;
									// 				}
									// 			}
									// 			echo "<td>";
									// 			for ($a=0; $a <count($ukuranJual) ; $a++) { 
									// 				$xw = $ukuranJual[$a];
									// 				$nmModel = $this->db->query("SELECT * FROM `data_produk_detil` WHERE `kode_bar1` = '$xw'")->row("warna_model");
									// 				$jmlModel = $qr1." AND kode_bar1='$xw'";
									// 				$jmlModel = $this->db->query($jmlModel)->num_rows();
									// 				if($a!=0){ echo ", "; }
									// 				echo "".$nmModel." (<strong>".$jmlModel."</strong>)";
									// 			}
									// 			echo "</td>";
									// 			echo "</tr>";
									// 		}
									// 		echo "</table>";
									// 		echo "</td>";
									// 		echo "</tr>";
									// 	}
									// }
                                ?>
								</tbody>
								<tfoot>
									<tr>
										<th colspan="2">Total</th>
										<th></th>
										<th></th>
										<th></th>
										<th></th>
										<th></th>
										<th></th>
										<th></th>
										<th style='text-align:center;'><?=$_segalanyaTotal;?></th>
								</tfoot>
							</table>
						</div>
					</div>
                    <!-- tampilan jika pengiriman keluar -->
                                <div class="modal fade" id="modals2311" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
									<div class="modal-dialog modal-dialog-centered">
										<div class="modal-content">
											<div class="modal-header">
												<h4 class="modal-title" id="myLargeModalLabel2311">
													Lihat Rekap Data
												</h4>
												<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
													×
												</button>
											</div>
                                            <?php echo form_open_multipart('data-stok/keluar/rekap'); ?>
											<div class="modal-body" id="modalBodyid2311">
                                                <label for="kode_bar456">Tanggal</label>
                                                <input class="form-control" name="dates" id="kode_bar456" type="text" placeholder="Masukan tanggal rekap..." />
												<label for="modelwarna233" style="margin-top:5px;">Penjualan</label>
                                                <select name="tipejual" id="tipejual" class="form-control">
                                                    <option value="all">--Semua Penjualan--</option>
                                                    <option value="Customer">Customer</option>
                                                    <option value="Reseller">Reseller</option>
                                                    <option value="Agen">Agen</option>
                                                </select>
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
					<!-- Simple Datatable End -->
                                
                </div>
				
			</div>
		</div>