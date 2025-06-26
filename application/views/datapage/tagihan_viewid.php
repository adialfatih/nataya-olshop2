<div class="main-container">
			<div class="pd-ltr-20 xs-pd-20-10">
				<div class="min-height-200px">
					<div class="page-header">
						<div class="row" style="display:flex;justify-content:space-between;">
							<div class="col-md-6 col-sm-12">
								<div class="title">
									<h4>Tagihan Pembayaran</h4>
								</div>
								<nav aria-label="breadcrumb" role="navigation">
									<ol class="breadcrumb no-print">
										<li class="breadcrumb-item">
											<a href="<?=base_url('beranda');?>">Home</a>
										</li>
                                        <li class="breadcrumb-item">
											<a href="#">Data</a>
										</li>
                                        <li class="breadcrumb-item">
											<a href="#">Tagihan</a>
										</li>
										<li class="breadcrumb-item active" aria-current="page">
                                            <?=strtoupper($nmnm);?>
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
                            $kode = $tgh->row('codeinput');
                            $id_tagihan2 = $tgh->row('id_tagihan');
                            $jns = $tgh->row("jenis_tagihan"); //jenis_tagihan
                            $pemb = $this->data_model->get_byid('tagihan_bayar', ['codeinput'=>$kode]);
                            if($pemb->num_rows() > 0){
                                $total_bayar = $this->db->query("SELECT SUM(nominal_bayar) AS jml FROM tagihan_bayar WHERE codeinput='$kode'")->row("jml");
                            } else {
                                $total_bayar = 0;
                            }
                            $status_pembayaran = "";

                        ?>
					<!-- Simple Datatable start -->
					<div class="card-box mb-30">
                        
						<div class="pd-20 table-responsive">
                            <strong>DATA TAGIHAN : </strong>
                            <hr>
                            <table class="data-table table stripe hover nowrap">
								<thead>
									<tr>
                                        <th>Tanggal</th>
										<th>Jenis Tagihan</th>
										<th>Supplier / PT</th>
										<th>Nominal Tagihan</th>
										<th>Total Pembayaran</th>
										<th>Status</th>
									</tr>
								</thead>
								<tbody>
                                    <?php
                                    if($tgh->num_rows() > 0){
                                        $no=1;
                                        foreach($tgh->result() as $val){
                                        $id_tagihan = sha1($val->id_tagihan);
                                        $id_tagihan2 = $val->id_tagihan;
                                        $total_bayar = $this->db->query("SELECT SUM(nominal) AS jml FROM tagihan_bayar2 WHERE id_tagihan='$id_tagihan2'")->row("jml");
                                            ?>
                                    <tr>
                                        <td><?=date('d M Y', strtotime($val->tgl_awal_tagihan));?></td>
                                        <td><?=$val->jenis_tagihan;?></td>
                                        <td><?=strtoupper($val->nama_supplier);?></td>
                                        <td>Rp. <?=number_format($val->nominal_tagihan,0,',','.');?></td>
                                        <td>Rp. <?=number_format($total_bayar,0,',','.');?></td>
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
                                    </tr>
                                            <?php
                                            $status_pembayaran = $val->status;
                                            $no++;
                                        }
                                    }
                                    ?>
								</tbody>
							</table>
                            <hr>
                            <?php $pemb = $this->data_model->get_byid('tagihan_bayar', ['nm'=>$nmnm]); 
                            if($status_pembayaran=="Belum Lunas"){
                            ?>
                            <div style="width:100%;display:flex;justify-content:flex-end;">
                                <button type="button" class="btn btn-success" data-toggle="modal" data-target="#modals23">Input Pembayaran</button>
                            </div>
                            <?php } ?>
						</div>
					</div>
                    <?php if($pemb->num_rows() > 0){ ?>
                    <div class="card-box mb-30">
						<div class="pd-20 table-responsive">
                        <strong>Riwayat Pembayaran : </strong>
                        <hr>
                            <table class="data-table table stripe hover nowrap">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Tanggal Bayar</th>
                                        <th>Nominal Bayar</th>
                                        <th>Proses Pembayaran</th>
                                        <th>Keterangan</th>
                                        <th>Diinput Oleh</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $nno=1; foreach($pemb->result() as $val): ?>
                                    <tr>
                                        <td><?=$nno++;?></td>
                                        <td><?=date('d M Y', strtotime($val->tgl_bayar));?></td>
                                        <td>
                                            Rp. <?=number_format($val->nominal_bayar,0,',','.');?>
                                        </td>
                                        <td><?=$val->proses_pembayaran;?></td>
                                        <td><?=$val->ket;?></td>
                                        <td><?=$val->yg_input;?></td>
                                        <td>
                                            <div class="dropdown">
                                                <a class="btn btn-link font-24 p-0 line-height-1 no-arrow dropdown-toggle" href="#" role="button" data-toggle="dropdown">
                                                    <i class="dw dw-more"></i>
                                                </a>
                                                <div class="dropdown-menu dropdown-menu-right dropdown-menu-icon-list">
                                                    <a class="dropdown-item" href="javascript:void(0);" onclick="del('Pembayaran Tagihan', '<?=$val->codebayar;?>','Riwayat Pembayaran')"> <i class="dw dw-trash"></i> Hapus</a>
                                                    <?php if($val->bukti_bayar!="null"){ ?>
                                                    <a class="dropdown-item" href="javascript:void(0);" onclick="showImage('<?=$val->bukti_bayar;?>')" data-toggle="modal" data-target="#modals454"> <i class="dw dw-view"></i> Lihat Bukti Bayar</a>
                                                    <?php } ?>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <?php endforeach; 
                                    $totalBayar = number_format($ttlbyr,0,',','.');
                                    ?>
                                </tbody>
                            </table>
                            
                        </div>
					</div>
                    <?php } ?>
					<!-- Simple Datatable End -->
                                <div class="modal fade bs-example-modal-lg" id="modals23" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
									<div class="modal-dialog modal-lg modal-dialog-centered">
										<div class="modal-content">
											<div class="modal-header">
												<h4 class="modal-title" id="myLargeModalLabel">
                                                    INPUT PEMBAYARAN
												</h4>
												<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
													×
												</button>
											</div>
                                            <?php echo form_open_multipart('save-pembayaran-tagihan'); 
                                            $tgl_now = date('Y-m-d');
                                            ?>
                                            <input type="hidden" value="<?=$nmnm;?>" name="nama_sup">
                                            <input type="hidden" value="<?=$this->uri->segment(3);?>" name="kodesha">
											<div class="modal-body">
                                                <div class="form-group row">
                                                    <label class="col-sm-12 col-md-2 col-form-label">Tanggal Pembayaran</label>
                                                    <div class="col-sm-12 col-md-10">
                                                        <input type="date" class="form-control" style="width:250px;" name="tglmasuk" id="tglmasuk" value="<?=$tgl_now;?>" max="<?=$tgl_now;?>" required>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label class="col-sm-12 col-md-2 col-form-label">Nominal Pembayaran</label>
                                                    <div class="col-sm-12 col-md-10">
                                                        <input type="text" class="form-control" oninput="formatAngka(this)" style="width:350px;" name="nominal" id="nominal" placeholder="Masukan Nominal Pembayaran" min="0" required>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label class="col-sm-12 col-md-2 col-form-label">Proses Pembayaran</label>
                                                    <div class="col-sm-12 col-md-10">
                                                        <input type="text" class="form-control" name="prosesbayar" id="prosesbayar" placeholder="Ex: Tunai, Transfer BCA, Virtual Account" min="0" required>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label class="col-sm-12 col-md-2 col-form-label" for="upload">Bukti Bayar</label>
                                                    <div class="col-sm-12 col-md-10">
                                                        <input class="form-control" name="upload" id="upload" type="file" onchange="validateFile('image')" />
                                                        <small>Upload bukti bayar. Ekstensi: JPG, PNG</small>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label class="col-sm-12 col-md-2 col-form-label" for="ketproduk">Keterangan</label>
                                                    <div class="col-sm-12 col-md-10">
                                                        <textarea name="ket" style="height:100px;" id="ketproduk" class="form-control" placeholder="Masukan Keterangan  (opsional)"></textarea>
                                                    </div>
                                                </div>
                                                
											</div>
											<div class="modal-footer">
                                                <!-- <a href="<=base_url('data-kain/masuk');?>">
												<button type="button" class="btn btn-secondary">
													Riwayat Kain Masuk
												</button></a> -->
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">
													Close
												</button>
												<button type="submit" class="btn btn-primary">
													Save changes
												</button>
											</div>
                                            <?php echo form_close(); ?>
										</div>
									</div>
								</div>
                                <div class="modal fade bs-example-modal-lg" id="modals454" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
									<div class="modal-dialog modal-lg modal-dialog-centered">
										<div class="modal-content">
											<div class="modal-header">
												<h4 class="modal-title" id="myLargeModalLabel">
                                                    BUKTI PEMBAYARAN
												</h4>
												<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
													×
												</button>
											</div>
											<div class="modal-body" id="imgshid">
                                                tes
											</div>
											
										</div>
									</div>
								</div>
                </div>
				
			</div>
		</div>
        <script>
            function showImage(img){
                var url = "<?=base_url();?>";
                document.getElementById('imgshid').innerHTML = '<img src="'+url+'uploads/'+img+'" alt="Image" style="max-width: 100%; height: auto;">';
            }
            function isMobileDevice() {
                return /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent);
            }

            // Fungsi untuk mengubah behavior input file
            function setupFileInput() {
                var fileInput = document.getElementById('upload');

                if (isMobileDevice()) {
                    // Jika perangkat mobile, tambahkan atribut capture untuk membuka kamera
                    fileInput.setAttribute('capture', 'camera');
                } else {
                    // Jika perangkat desktop, hapus atribut capture jika ada
                    fileInput.removeAttribute('capture');
                }
            }

            // Panggil fungsi saat halaman dimuat
            window.onload = setupFileInput;
        </script>