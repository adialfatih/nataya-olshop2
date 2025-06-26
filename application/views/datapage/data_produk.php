<div class="main-container">
			<div class="pd-ltr-20 xs-pd-20-10">
				<div class="min-height-200px">
					<div class="page-header">
						<div class="row" style="display:flex;justify-content:space-between;">
							<div class="col-md-6 col-sm-12">
								<div class="title">
									<h4>Menampilkan Data Produk</h4>
								</div>
								<nav aria-label="breadcrumb" role="navigation">
									<ol class="breadcrumb">
										<li class="breadcrumb-item">
											<a href="<?=base_url('beranda');?>">Home</a>
										</li>
                                        <li class="breadcrumb-item">
											<a href="#">Data</a>
										</li>
										<li class="breadcrumb-item active" aria-current="page">
                                            Produk
										</li>
                                        <li class="breadcrumb-item" id="idShowKategori" aria-current="page">
                                            Semua Produk
										</li>
									</ol>
								</nav>
							</div>
                            <div style="display:flex;align-items:center;gap:10px;margin-right:15px;">
                                <?php if($kat->num_rows() > 0){?>
                                <a class="btn btn-outline-primary" href="javscript:void(0);" role="button" data-toggle="modal" data-target="#modals23">
                                    + Produk
                                </a>
                                <div class="dropdown">
                                    <a class="btn btn-primary dropdown-toggle" href="javascript:void(0);" role="button" data-toggle="dropdown">
                                        Kategori Produk
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        <?php foreach($kat->result() as $g){
                                            $_idkat = $g->id_kat;
                                            ?><a class="dropdown-item" style="color:#0957d6;" href="javascirpt:void(0);" onclick="showKategori('<?=$_idkat;?>','<?=$g->kategori;?>')" oncontextmenu="showKategoriRightClick(event, '<?=$_idkat;?>','<?=$g->kategori;?>', '<?=$g->keterangan;?>'); return false;"><?=$g->kategori;?></a><?php
                                        }
                                        ?>
                                        <a class="dropdown-item" href="javascirpt:void(0);" onclick="showKategori('all','Semua Produk')">Tampilkan Semua</a>
                                        <a class="dropdown-item" href="javscript:void(0);" onclick="clearModals()" role="button" data-toggle="modal" data-target="#modals">Buat Kategori Baru</a>
                                    </div>
                                </div>
                                <?php } else { ?>
                                    <a class="btn btn-outline-primary" href="javscript:void(0);" onclick="notif('warning','Anda belum memiliki kategori produk.')" role="button">
                                        + Produk
                                    </a>
                                    <a class="btn btn-primary" href="javscript:void(0);" onclick="clearModals()" role="button" data-toggle="modal" data-target="#modals">
                                        Buat Kategori
                                    </a>
                                <?php } ?>
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
							<table class="table table-bordered stripe hover nowrap">
								<thead>
									<tr>
										<th class="table-plus datatable-nosort">No</th>
										<th>Gambar</th>
										<th>Kategori</th>
										<th>Nama Produk</th>
										<th>Keterangan</th>
										<th class="datatable-nosort">Action</th>
									</tr>
								</thead>
								<tbody id="bodyTable">
                                    <?php
                                    if($produk->num_rows() > 0){
                                        $no=1;
                                        foreach($produk->result() as $val){
                                        $idkat = $val->id_kat;
                                        $katnama = $this->data_model->get_byid('kategori_produk', ['id_kat'=>$idkat])->row('kategori');
                                        $codeunik = $val->codeunik;
                                        $cek_gambar = $this->data_model->get_byid('gambar_produk', ['codeunik'=>$codeunik])->num_rows();
                                        if($cek_gambar==0){
                                            $url_gbr = base_url('assets/img-placeholder.svg');
                                            $alt_gbr = 'Image Placeholder';
                                        } else {
                                            $gbr = $this->db->query("SELECT * FROM gambar_produk WHERE codeunik='$codeunik' LIMIT 1")->row("url_gbr");
                                            $url_gbr = base_url('uploads/'.$gbr);
                                            $alt_gbr = $val->nama_produk;
                                        }
                                    ?>
                                    <tr>
                                        <td><?=$no;?></td>
                                        <td>
                                            <img src="<?=$url_gbr;?>" alt="<?=$alt_gbr;?>" style="width:100px;height:100px;">
                                        </td>
                                        <td><?=$katnama;?></td>
                                        <td><?=$val->nama_produk;?></td>
                                        <td style="max-width: 300px;word-wrap: break-word;">
                                            <?php
                                            $keterangan_produk = $val->keterangan_produk;
                                            $kata_array = explode(' ', $keterangan_produk); // Memecah teks menjadi array kata-kata
                                            $kata_terbatas = array_slice($kata_array, 0, 20); // Mengambil 20 kata pertama
                                            $teks_terbatas = implode(' ', $kata_terbatas); 
                                            echo $teks_terbatas.'...';
                                            ?>
                                        </td>
                                        <td>
                                            <div class="dropdown">
                                                <a class="btn btn-link font-24 p-0 line-height-1 no-arrow dropdown-toggle" href="#" role="button" data-toggle="dropdown">
                                                            <i class="dw dw-more"></i>
                                                </a>
                                                <div class="dropdown-menu dropdown-menu-right dropdown-menu-icon-list">
                                                    <a class="dropdown-item" href="<?=base_url('product/'.$codeunik);?>">
                                                        <i class="dw dw-eye"></i> View
                                                    </a>
                                                    <a class="dropdown-item" href="javascript:void(0);" onclick="del('Produk','<?=$codeunik;?>','<?=$val->nama_produk;?>')">
                                                        <i class="dw dw-trash" style="color:#c90e0e;"></i> Delete
                                                    </a>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <?php
                                            $no++;
                                        }
                                    } else {
                                        echo "<tr><td colspan='6'>Anda belum memiliki sebuah produk</td></tr>";
                                    }
                                    ?>
                                </tbody>
							</table>
						</div>
					</div>
					<!-- Simple Datatable End -->
								<div class="modal fade" id="modals" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
									<div class="modal-dialog modal-dialog-centered">
										<div class="modal-content">
											<div class="modal-header">
												<h4 class="modal-title" id="myLargeModalLabel">
													Tambah Kategori Produk
												</h4>
												<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
													×
												</button>
											</div>
                                            <form action="<?=base_url('save-kategori');?>" method="post">
                                            <input type="hidden" name="idtipe" value="0" id="idtipe">
											<div class="modal-body" id="modalBodyid">
                                                <label for="kat">Nama Kategori</label>
                                                <input type="text" id="kat" name="kat" class="form-control" placeholder="Masukan Nama Kategori" required>
                                                <label for="keterangan">Keterangan <small>(opsional)</small></label>
                                                <textarea type="text" id="keterangan" name="ket" class="form-control" placeholder="Masukan Keterangan"></textarea>
                                                
                                            </div>
											<div class="modal-footer">
												<button type="button" class="btn btn-default" data-dismiss="modal">
													Close
												</button>
                                                <button type="submit" class="btn btn-primary">
													Simpan Kategori
												</button>
											</div>
                                            </form>
										</div>
									</div>
								</div>
                                <!-- modal large -->
                                <div class="modal fade bs-example-modal-lg" id="modals23" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
									<div class="modal-dialog modal-lg modal-dialog-centered">
										<div class="modal-content">
											<div class="modal-header">
												<h4 class="modal-title" id="myLargeModalLabel">
													Tambah Produk Baru
												</h4>
												<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
													×
												</button>
											</div>
                                            <?php echo form_open_multipart('save-produk'); ?>
                                            <input type="hidden" name="codeunik" id="codeunik" value="<?=$codeuniq;?>" required>
											<div class="modal-body">
                                                <div class="form-group row">
                                                    <label class="col-sm-12 col-md-2 col-form-label" for="katproduk">Kategori</label>
                                                    <div class="col-sm-12 col-md-10">
                                                        <select name="katproduk" id="katproduk" class="form-control" style="width:250px;" required>
                                                            <option value="">--Pilih Kategori Produk--</option>
                                                            <?php foreach($kat->result() as $g){?>
                                                            <option value="<?=$g->id_kat;?>"><?=$g->kategori;?></option>
                                                            <?php } ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label class="col-sm-12 col-md-2 col-form-label" for="namaproduk">Nama Produk</label>
                                                    <div class="col-sm-12 col-md-10">
                                                        <input class="form-control" name="namaproduk" id="namaproduk" type="text" placeholder="Masukan Nama Produk" required />
                                                    </div>
                                                </div>
                                                
                                                
                                                <div class="form-group row">
                                                    <label class="col-sm-12 col-md-2 col-form-label" for="upload">Gambar</label>
                                                    <div class="col-sm-12 col-md-10">
                                                        <input class="form-control" name="upload" id="upload" type="file" onchange="validateFile('image')" />
                                                        <small>Ekstensi : PNG, JPG. Maksimal ukuran 2 MB.</small>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label class="col-sm-12 col-md-2 col-form-label" for="satuan">Satuan</label>
                                                    <div class="col-sm-12 col-md-10">
                                                        <select name="satuan" id="satuan" class="form-control" style="width:250px;" required>
                                                            <option value="">--Pilih Satuan Barang--</option>
                                                            <option value="Pcs">Pcs</option>
                                                            <option value="Bale">Bale</option>
                                                            <option value="Kg">Kg</option>
                                                            <option value="Meter">Meter</option>
                                                            <option value="Yard">Yard</option>
                                                            <option value="Palet">Palet</option>
                                                            <option value="Unit">Unit</option>
                                                            <option value="Karton">Karton</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label class="col-sm-12 col-md-2 col-form-label" for="ketproduk">Keterangan</label>
                                                    <div class="col-sm-12 col-md-10">
                                                        <textarea name="ketproduk" id="ketproduk" class="form-control" placeholder="Masukan Keterangan Produk / Barang (opsional)"></textarea>
                                                    </div>
                                                </div>
											</div>
											<div class="modal-footer">
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
                                <div id="contextMenu" style="display: none; position: absolute; background-color: white; border: 1px solid #ddd; box-shadow: 0px 8px 16px rgba(0,0,0,0.2); z-index: 1000;">
                                    <a href="javascript:void(0);" onclick="editKategori()" class="dropdown-item">Edit</a>
                                    <a href="javascript:void(0);" onclick="hapusKategori()" class="dropdown-item">Hapus</a>
                                </div>
                </div>
				
			</div>
		</div>