<div class="main-container">
			<div class="pd-ltr-20 xs-pd-20-10">
				<div class="min-height-200px">
					<div class="page-header">
						<div class="row">
							<div class="col-md-6 col-sm-12">
								<div class="title">
									<h4>Menampilkan Nota Reseller</h4>
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
											<a href="#">Nota</a>
										</li>
										<li class="breadcrumb-item active" aria-current="page">
                                            <?=$dtres['nama_reseller'];?>
										</li>
									</ol>
								</nav>
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
                            //echo $sess_akses;
                        ?>
                    
					<!-- Simple Datatable start -->
					<div class="card-box mb-30">
						<div class="pd-20 table-responsive">
                            <h3 id="tesOiut">Outstanding : </h3>
                            <hr>
							<table class="table table-bordered stripe hover nowrap">
								<thead>
									<tr>
										<th class="table-plus datatable-nosort">No</th>
										<th>Nama Reseller</th>
										<th>SJ</th>
										<th>Tanggal</th>
										<th>Jumlah Tagihan</th>
										<th>Pembayaran</th>
										<th>Sisa Hutang</th>
										<th class="datatable-nosort">Status</th>
									</tr>
								</thead>
								<tbody>
<?php
    $res = $dtres['nama_reseller'];
    $nilai_bayar = floatval($nilai_bayar);
    $sisa_bayar = floatval($nilai_bayar);
    $outstanding = 0;
    $ary = $this->db->query("SELECT * FROM stok_produk_keluar WHERE nama_tujuan='$res' AND tujuan='Reseller' ORDER BY tgl_out");
    if($ary->num_rows() > 0){
        $no=1;
        foreach($ary->result() as $val){
            $id_outstok = $val->id_outstok;
            $tgl = date('d M Y', strtotime($val->tgl_out));
            $nilai_tagihan = floatval($val->nilai_tagihan);
            if($sisa_bayar > 0){
                if($sisa_bayar >= $nilai_tagihan){
                    $this->data_model->updatedata('id_outstok',$id_outstok,'stok_produk_keluar',['status_lunas'=>'Lunas']);
                    $_jmlBayar = number_format($nilai_tagihan,0,",",".");
                    $_jmlSisa = 0;
                    $outstanding = $outstanding + $_jmlSisa;
                    $_lunas = "<span class='badge badge-success'>Lunas</span>";
                    $sisa_bayar = $sisa_bayar - $nilai_tagihan;
                } else {
                    $this->data_model->updatedata('id_outstok',$id_outstok,'stok_produk_keluar',['status_lunas'=>'Belum Lunas']);
                    $_jmlBayar = number_format($sisa_bayar,0,",",".");
                    $_jmlSisa2 = $nilai_tagihan - $sisa_bayar;
                    $outstanding = $outstanding + $_jmlSisa2;
                    $_jmlSisa = number_format($_jmlSisa2,0,",",".");
                    $_lunas = "<span class='badge badge-danger'>Belum Lunas</span>";
                    $sisa_bayar = 0;
                }
            } else {
                $_jmlBayar = 0;
                $_jmlSisa2 = $nilai_tagihan - $_jmlBayar;
                $outstanding = $outstanding + $_jmlSisa2;
                $_jmlSisa = number_format($_jmlSisa2,0,",",".");
                $_lunas = "<span class='badge badge-danger'>Belum Lunas</span>";
            }
            echo "<tr>";
            echo "<td>".$no++."</td>";
            echo "<td>".$val->nama_tujuan."</td>";
            echo "<td>".$val->no_sj."</td>";
            echo "<td>".$tgl."</td>";
            echo "<td>Rp. ".number_format($val->nilai_tagihan,0,",",".")."</td>";
            echo "<td>Rp. ".$_jmlBayar."</td>";
            echo "<td>Rp. ".$_jmlSisa."</td>";
            echo "<td>".$_lunas."</td>";
           
            echo "</tr>";
        }
        ?>
        <script>
            document.getElementById('tesOiut').innerHTML = 'Outstanding : Rp.<?php echo number_format($outstanding,0,",","."); ?>';
        </script>
        <?php
    } else {
        echo "<tr><td colspan='7'>Anda belum memiliki nota</td></td></tr>";
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