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
                                        <form action="<?=base_url('update-product');?>" method="post">
                                        <input type="hidden" id="codeunik" value="<?=$produk['codeunik'];?>" name="codeunik">
										<span>Nama Produk</span>
                                        <input type="text" name="namaproduk" class="form-control" value="<?=$produk['nama_produk'];?>" style="margin-bottom:20px;">
										<span >Keterangan Produk</span>
                                        <textarea name="ket" class="form-control" id="ket" style="margin-bottom:20px;"><?=$produk['keterangan_produk'];?></textarea>
                                        <div style="display:flex;align-items:center;">
                                            <span style="width:100px;">Kategori  </span>
                                            <select name="kat" id="kat" class="form-control" style="width:150px;">
                                                <option value="0">--Pilih Kategori--</option>
                                                <?php foreach($kat->result() as $k){?>
                                                <option value="<?=$k->id_kat;?>" <?php if($k->id_kat == $produk['id_kat']){echo "selected";} ?>><?=$k->kategori;?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                        <div style="display:flex;align-items:center;margin-top:10px;">
                                            <span style="width:100px;">Satuan  </span>
                                            <select name="satuan" id="satuan" class="form-control" style="width:250px;" required>
                                                <option value="">--Pilih Satuan Barang--</option>
                                                <option value="Pcs" <?php if("Pcs" == $produk['satuan']){echo "selected";} ?>>Pcs</option>
                                                <option value="Bale" <?php if("Bale" == $produk['satuan']){echo "selected";} ?>>Bale</option>
                                                <option value="Kg" <?php if("Kg" == $produk['satuan']){echo "selected";} ?>>Kg</option>
                                                <option value="Meter" <?php if("Meter" == $produk['satuan']){echo "selected";} ?>>Meter</option>
                                                <option value="Yard" <?php if("Yard" == $produk['satuan']){echo "selected";} ?>>Yard</option>
                                                <option value="Palet" <?php if("Palet" == $produk['satuan']){echo "selected";} ?>>Palet</option>
                                                <option value="Unit" <?php if("Unit" == $produk['satuan']){echo "selected";} ?>>Unit</option>
                                                <option value="Karton" <?php if("Karton" == $produk['satuan']){echo "selected";} ?>>Karton</option>
                                            </select>
                                        </div>
                                        

										<div class="row" style="margin-top:30px;">
											<div class="col-md-6 col-6">
												&nbsp;
											</div>
											<div class="col-md-6 col-6">
												<button type="submit" class="btn btn-outline-primary btn-block"><i class="fa fa-save"></i>&nbsp; Simpan Data</button>
											</div>
										</div>
                                        </form>
									</div>
								</div>
							</div>
						</div>
                    </div>
					<!-- Simple Datatable End -->
								
                </div>
				
			</div>
		</div>