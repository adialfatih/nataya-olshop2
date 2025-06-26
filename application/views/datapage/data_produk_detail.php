<div class="main-container">
			<div class="pd-ltr-20 xs-pd-20-10">
				<div class="min-height-200px">
					<div class="page-header">
						<div class="row" style="display:flex;justify-content:space-between;">
							<div class="col-md-6 col-sm-12">
								<div class="title">
									<h4><?=$produk['nama_produk'];?></h4>
								</div>
								<nav aria-label="breadcrumb" role="navigation">
									<ol class="breadcrumb">
										<li class="breadcrumb-item">
											<a href="<?=base_url('beranda');?>">Home</a>
										</li>
                                        <li class="breadcrumb-item">
											<a href="javascript:void(0);">Data</a>
										</li>
										<li class="breadcrumb-item" aria-current="page">
                                            <a href="<?=base_url('product');?>">Produk</a>
										</li>
                                        <li class="breadcrumb-item active" id="idShowKategori" aria-current="page">
                                            <?=$produk['nama_produk'];?>
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
					<div class="product-wrap">
						<div class="product-detail-wrap mb-30">
							<div class="row">
								<div class="col-lg-6 col-md-12 col-sm-12">
                                    <?php if($img_produk->num_rows() > 0){ 
                                    ?>
									<div class="product-slider slider-arrow">
                                        <?php foreach($img_produk->result() as $img): ?>
										<div class="product-slide">
											<img src="<?=base_url('uploads/'.$img->url_gbr);?>" alt="" />
										</div>
                                        <?php endforeach; ?>
									</div>
									<div class="product-slider-nav">
                                        <?php foreach($img_produk->result() as $img2): ?>
                                        <div class="product-slide-nav">
											<img src="<?=base_url('uploads/'.$img2->url_gbr);?>" alt="" />
										</div>
                                        <?php endforeach; 
                                        $jml_gambar = $img_produk->num_rows();
                                        if($jml_gambar < 4){
                                            $sisa = 4 - $jml_gambar;
                                            for ($i=0; $i < $sisa ; $i++) { 
                                                ?><div class="product-slide-nav">
                                                    <img src="<?=base_url('assets/');?>no_image.svg" alt="" />
                                                </div><?php
                                            }
                                        }
                                        ?>
										
									</div>
                                    <?php } else { ?>
                                    <div class="product-slider slider-arrow">
										<div class="product-slide">
											<img src="<?=base_url('assets/');?>no_image.svg" alt="" />
										</div>
										<div class="product-slide">
											<img src="<?=base_url('assets/');?>no_image.svg" alt="" />
										</div>
										<div class="product-slide">
											<img src="<?=base_url('assets/');?>no_image.svg" alt="" />
										</div>
										<div class="product-slide">
											<img src="<?=base_url('assets/');?>no_image.svg" alt="" />
										</div>
									</div>
									<div class="product-slider-nav">
										<div class="product-slide-nav">
											<img src="<?=base_url('assets/');?>no_image.svg" alt="" />
										</div>
										<div class="product-slide-nav">
											<img src="<?=base_url('assets/');?>no_image.svg" alt="" />
										</div>
										<div class="product-slide-nav">
											<img src="<?=base_url('assets/');?>no_image.svg" alt="" />
										</div>
										<div class="product-slide-nav">
											<img src="<?=base_url('assets/');?>no_image.svg" alt="" />
										</div>
									</div>
                                    <?php } 
                                    $kat_produk = $this->data_model->get_byid('kategori_produk', ['id_kat'=>$produk['id_kat']])->row('kategori');
                                    ?>
								</div>
								<div class="col-lg-6 col-md-12 col-sm-12">
									<div class="product-detail-desc pd-20 card-box height-100-p">
										<div style="width:100%;display:flex;justify-content:space-between;margin-bottom:10px;">
											<h4><?=$produk['nama_produk'];?></h4>
											<button class="btn btn-primary" data-toggle="modal" data-target="#modals2311">+ Tambah Produk</button>
										</div>
										
										<p>Keterangan Produk : <?=$produk['keterangan_produk'];?></p>
										<?php
										$cd = $produk['id_produk'];
										$jumlah = $this->db->query("SELECT COUNT(id_bar) AS jml FROM data_produk_stok WHERE id_produk = '$cd'")->row('jml');
										
										if($this->uri->segment(3) == "id"){
											$loc = $this->uri->segment(4);
											$dt = $this->db->query("SELECT id_produk,kode_bar,warna_model FROM data_produk_detil WHERE id_produk = '$cd' GROUP BY warna_model ORDER BY CAST(REGEXP_SUBSTR(kode_bar, '[0-9]+') AS UNSIGNED)");
										} else {
											$dt = $this->db->query("SELECT id_produk,kode_bar,warna_model FROM data_produk_detil WHERE id_produk = '$cd'  GROUP BY warna_model ORDER BY CAST(REGEXP_SUBSTR(kode_bar, '[0-9]+') AS UNSIGNED)");
										}
										//echo $cd;
										?>
										<small>Kategori Produk : <strong><?=$kat_produk;?></strong></small><br>
										<small>Total Stok : <strong><?=$jumlah==''?'0':number_format($jumlah, 0, ',', '.');?></strong> <?=$produk['satuan'];?></small>
                                        <br>
                                        <br>
										<?php 
										if($dt->num_rows() > 0){
											$nmP = $produk['nama_produk'];
										?>
										<table class="table table-bordered" style="font-size:12px;">
                                            <tr>
                                                <th>KODE</th>
                                                <th>WARNA</th>
                                                <th>(UKURAN, JUMLAH) HARGA</th>
                                            </tr>
											<?php foreach($dt->result() as $det){
											echo "<tr id='kdbar".$det->id_bar."'>";
											echo "<td>".$det->kode_bar."</td>";
											?>
											<td>
												<span onclick="hapusModel('<?=$nmP;?>','<?=$det->kode_bar;?>','<?=$det->warna_model;?>')"><?=$det->warna_model;?></span>
											</td>
											<?php
											//echo "<td>".$det->warna_model."</td>";
											
											$_ukr = $this->db->query("SELECT kode_bar,ukuran FROM data_produk_detil WHERE kode_bar = '$det->kode_bar'")->result();
											$ar_ukur = array();
											foreach($_ukr as $ukr){
												//echo $ukr->ukuran.", ";
												$ar_ukur[] = $ukr->ukuran;
											}
											
											echo "<td>";
											for ($p=0; $p <count($ar_ukur) ; $p++) { 
												$kode_bar1 = $det->kode_bar."-".$ar_ukur[$p];
												$jumlah2 = $this->db->query("SELECT COUNT(id_bar) AS jml FROM data_produk_stok WHERE kode_bar1 = '$kode_bar1' ")->row('jml');
												$_hrg = $this->db->query("SELECT harga_produk,harga_jual FROM data_produk_stok WHERE kode_bar1 = '$kode_bar1' ORDER BY id_bar DESC LIMIT 1")->row('harga_jual');
												$_hrg1 = number_format($_hrg, 0, ',', '.');
												if($jumlah2 > 0){
												?>
												(<?=$ar_ukur[$p];?>, <?=$jumlah2;?> Pcs) <a style="color:blue;text-decoration:none;" href="javascript:;" data-toggle="modal" data-target="#modals23" onclick="changeKode23('<?=$kode_bar1?>')">Rp. <?=$_hrg1?></a><br>
												<?php }
												
											}
											echo "</td>";
											echo "</tr>";
											} ?>
                                        </table>
										<?php } ?>
										
                                        <br>
										<div class="row">
											<div class="col-md-6 col-6">
												<a href="javascript:void(0)" class="btn btn-primary btn-block" data-toggle="modal" data-target="#modals">
                                                    <i class="dw dw-image"></i>&nbsp; Add Image
                                                </a>
											</div>
											
											<div class="col-md-6 col-6">
												<a href="<?=base_url('product/update/'.$codereal);?>" class="btn btn-outline-primary btn-block"><i class="dw dw-edit"></i>&nbsp; Edit Data</a>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
                    </div>
					<!-- Simple Datatable End -->
								<div class="modal fade" id="modals" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
									<div class="modal-dialog modal-dialog-centered">
										<div class="modal-content">
											<div class="modal-header">
												<h4 class="modal-title" id="myLargeModalLabel">
													Tambah Gambar Produk
												</h4>
												<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
													×
												</button>
											</div>
                                            <?php echo form_open_multipart('add-image-to-produk'); ?>
                                            <input type="hidden" value="<?=$codereal;?>" name="codeunik" required>
											<div class="modal-body" id="modalBodyid">
                                                <label for="upload">Upload Gambar</label>
                                                <input class="form-control" name="upload" id="upload" type="file" onchange="validateAndPreviewImage()" />
                                                <small>Ekstensi : PNG, JPG. Maksimal ukuran 2 MB.</small>
                                                <br>
                                                <div style="width:100%;display:flex;align-items:center;justify-content:center;">
                                                <img id="imgForUpload" src="<?=base_url('assets/');?>no_image.svg" alt="Upload" style="width:50%;">
                                                </div>
                                            </div>
											<div class="modal-footer">
												<button type="button" class="btn btn-default" data-dismiss="modal">
													Close
												</button>
                                                <button type="submit" class="btn btn-primary">
													Simpan
												</button>
											</div>
                                            <?php echo form_close(); ?>
										</div>
									</div>
								</div>
                                <!-- modal large -->
                                <div class="modal fade" id="modals23" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
									<div class="modal-dialog modal-dialog-centered">
										<div class="modal-content">
											<div class="modal-header">
												<h4 class="modal-title" id="myLargeModalLabel23">
													Update Harga Produk
												</h4>
												<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
													×
												</button>
											</div>
                                            <?php echo form_open_multipart('proses2/updateharga'); ?>
                                            <input type="hidden" value="<?=$codereal;?>" name="codeunik" required>
											<div class="modal-body" id="modalBodyid23">
                                                <label for="kode_bar123">Kode Produk</label>
                                                <input class="form-control" name="kode_bar1" id="kode_bar123" type="text" value="Loading..." readonly />
                                                <br>
                                                <label for="harga_produksi23">Harga Produksi</label>
                                                <input class="form-control" name="harga_produksi" oninput="formatAngka(this)" id="harga_produksi23" type="text" value="Loading..." />
                                                <br>
                                                <label for="harga_jual23">Harga Jual</label>
                                                <input class="form-control" name="harga_jual" id="harga_jual23" oninput="formatAngka(this)" type="text" value="Loading..." />
												<input type="hidden" value="<?=$codereal;?>" name="codereal">
                                            </div>
											<div class="modal-footer">
												<button type="button" class="btn btn-default" data-dismiss="modal">
													Close
												</button>
                                                <button type="submit" class="btn btn-primary">
													Simpan
												</button>
											</div>
                                            <?php echo form_close(); ?>
										</div>
									</div>
								</div>
								<!-- modal large -->
                                <div class="modal fade" id="modals2311" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
									<div class="modal-dialog modal-dialog-centered">
										<div class="modal-content">
											<div class="modal-header">
												<h4 class="modal-title" id="myLargeModalLabel2311">
													Tambah Jumlah Produk
												</h4>
												<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
													×
												</button>
											</div>
                                            <?php echo form_open_multipart('proses2/tambahStok'); ?>
                                            <input type="hidden" value="<?=$codereal;?>" name="codeunik" required>
                                            <input type="hidden" value="<?=$id_produk;?>" name="id_produk" required>
											<div class="modal-body" id="modalBodyid2311">
                                                <label for="kode_bar456">Kode Produk</label>
                                                <input class="form-control" name="kode_bar" onkeyup="cariModel(this.value)" id="kode_bar456" type="text" placeholder="Masukan Kode Produk..." />
												<label for="modelwarna233" style="margin-top:5px;">Model / Warna</label>
                                                <input class="form-control" name="modelwarna" id="modelwarna233" type="text" placeholder="Masukan Model Warna" readonly />
                                                <label for="ukuran244" style="margin-top:5px;">Ukuran</label>
                                                <input class="form-control" name="ukuran" id="ukuran244" type="text" placeholder="Masukan ukuran" />
                                                <label for="jml23" style="margin-top:5px;">Jumlah Produk</label>
                                                <input class="form-control" name="jumlah" id="jml23" oninput="formatAngka(this)" type="text" placeholder="Masukan jumlah penambahan..." />
												<small>Anda bisa mengubah harga setelah anda simpan..!!</small>
                                            </div>
											<div class="modal-footer">
												<button type="button" class="btn btn-default" data-dismiss="modal">
													Close
												</button>
                                                <button type="submit" class="btn btn-primary">
													Simpan
												</button>
											</div>
                                            <?php echo form_close(); ?>
										</div>
									</div>
								</div>
                </div>
				
			</div>
		</div>