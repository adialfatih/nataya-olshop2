<div class="main-container">
			<div class="pd-ltr-20 xs-pd-20-10">
				<div class="min-height-200px">
					<div class="page-header">
						<div class="row" style="display:flex;justify-content:space-between;">
							<div class="col-md-6 col-sm-12">
								<div class="title">
									<h4 id="headingTitle">Management Data Stok <?=$showStokTipe;?></h4>
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
                                            Stok
										</li>
									</ol>
								</nav>
							</div>
                            <?php if($showStokTipe=="Toko"){?>
                            <div style="display:flex;align-items:center;gap:10px;margin-right:15px;">
                                    <a class="btn btn-outline-primary" href="javscript:void(0);"role="button" data-toggle="modal" data-target="#modals23">
                                        <i class="icon-copy bi bi-box-arrow-in-down-left"></i>&nbsp; Stok Masuk
                                    </a>
                                    <div class="dropdown">
                                        <a class="btn btn-danger dropdown-toggle" href="javascript:void(0);" role="button" data-toggle="dropdown">
                                            Stok Keluar
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-right">
                                            <a class="dropdown-item" style="color:#000;" href="<?=base_url('stok/kirim/customer');?>">Kirim Customer</a>
                                            <a class="dropdown-item" style="color:#000;" href="<?=base_url('stok/kirim/reseller');?>">Kirim Reseller</a>
                                            <a class="dropdown-item" style="color:#000;" href="<?=base_url('stok/kirim/agen');?>">Kirim Distributor/Agen</a>
                                        </div>
                                    </div>
                                    <a class="btn btn-success" href="javscript:void(0);" data-toggle="modal" data-target="#modals454">
                                        <i class="icon-copy bi bi-file-earmark-excel-fill"></i>&nbsp; Import Data Excel
                                    </a>
                            </div>
                            <?php } else { ?>
                            <div style="display:flex;align-items:center;gap:10px;margin-right:15px;">
                                    
                                    <div class="dropdown">
                                        <a class="btn btn-danger dropdown-toggle" href="javascript:void(0);" role="button" data-toggle="dropdown">
                                            Mutasi Stok
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-right">
                                            <a class="dropdown-item" style="color:#000;" href="<?=base_url('mutasi/toko/gudang');?>">Toko -> Gudang</a>
                                            <a class="dropdown-item" style="color:#000;" href="<?=base_url('mutasi/gudang/toko');?>">Gudang -> Toko</a>
                                        </div>
                                    </div>
                                    
                            </div>
                            <?php } ?>
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
                            //echo $sess_akses;
                        ?>
                    <input type="hidden" id="thisID" value="0">
                    <input type="hidden" id="thisTipeStok" value="<?=$showStokTipe;?>">
					<!-- Simple Datatable start -->
					<div class="card-box mb-30">
                        <div class="pd-20" style="width:100%;display:flex;justify-content:space-between;background:#ccc;color:#000;border-radius:10px 10px 0 0;">
                            <strong id="idStokView">STOK GUDANG (Loading...)</strong>
                            <?php
                            if($showStokTipe=="Gudang"){
                            $dis = $this->db->query("SELECT id_dis,nama_distributor FROM data_distributor ORDER BY nama_distributor ASC");
                            if($dis->num_rows() > 0){
                            ?>
                            <div class="form-group mb-md-0">
								<select class="form-control form-control-sm selectpicker" onchange="loadstok(this.value,'null','null','null')">
									<option value="0">--Stok di Agen--</option>
									<?php
                                    foreach ($dis->result() as $value) {
                                        if($value->id_dis == 11 || $value->id_dis == 9){} else {
                                            echo '<option value="'.$value->id_dis.'">'.$value->nama_distributor.'</option>';
                                        }
                                    }
                                    ?>
								</select>
							</div>
                            <?php } } ?>
                        </div>
                        <div style="width:100%;display:flex;align-items:center;padding:20px 20px 0 20px;gap:10px;">
                            <span>Tampilkan Kategori : </span>
                            <select name="kategori" id="kategori90" class="form-control" style="width:200px;" onchange="changeSelectKategori(this.value)">
                                <option value="null">--Pilih Kategori--</option>
                                <?php $kat1 = $this->db->query("SELECT id_kat,kategori FROM kategori_produk ORDER BY kategori ASC");
                                foreach($kat1->result() as $k){?>
                                <option value="<?=$k->id_kat;?>"><?=$k->kategori;?></option>
                                <?php } ?>
                            </select>
                            <span>Cari Produk : </span>
                            <div class="form-label" style="width:300px;">
								<div class="autoComplete_wrapper" style="width:100%;">
									<input id="autoComplete" style="width:100%;" type="search" dir="ltr" spellcheck=false autocorrect="off" autocomplete="off" name="kodeproduk" autocapitalize="off" required>
								</div>
							</div>
                        </div>
						<div class="pd-20 table-responsive">
							<table class="table table-bordered stripe hover nowrap">
								<thead>
									<tr>
										<th class="table-plus datatable-nosort">No</th>
										<th>Gambar Produk</th>
										<th>Nama Produk</th>
										<th>Ukuran Tersedia</th>
										<th>Jumlah Stok</th>
										<th class="datatable-nosort">Action</th>
									</tr>
								</thead>
								<tbody id="viewStok">
                                    <tr>
                                        <td colspan="6">
                                            <div style="width:100%;display:flex;justify-content:center;align-items:center"><div class="loader"></div></div>
                                        </td>
                                    </tr>
                                </tbody>
							</table>
						</div>
					</div>
					<!-- Simple Datatable End -->
                    <div class="modal fade bs-example-modal-lg" id="modals23" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
									<div class="modal-dialog modal-lg modal-dialog-centered">
										<div class="modal-content">
											<div class="modal-header">
												<h4 class="modal-title" id="myLargeModalLabel">
													Data Stok Masuk
												</h4>
												<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
													×
												</button>
											</div>
                                            <?php echo form_open_multipart('save-stokin-produk'); 
                                            $tgl_now = date('Y-m-d');
                                            ?>
											<div class="modal-body">
                                                <div class="form-group row">
                                                    <label class="col-sm-12 col-md-2 col-form-label">No Surat Jalan</label>
                                                    <div class="col-sm-12 col-md-10">
                                                        <input type="text" class="form-control" style="width:350px;" name="sj" id="sj" oninput="ceksj(this.value)" placeholder="Masukan No Surat Jalan" required>
                                                        <small style="color:red;" id="notice2"></small>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label class="col-sm-12 col-md-2 col-form-label">Tanggal Masuk</label>
                                                    <div class="col-sm-12 col-md-10">
                                                        <input type="date" class="form-control" style="width:250px;" name="tglmasuk" id="tglmasuk" value="<?=$tgl_now;?>" max="<?=$tgl_now;?>" required>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label class="col-sm-12 col-md-2 col-form-label">Diterima Di</label>
                                                    <div class="col-sm-12 col-md-10">
                                                        <select name="diterimadi" id="diterimadi" style="width:350px;" class="form-control" required>
                                                            <option value="Toko">Toko</option>
                                                            <option value="Gudang">Gudang</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label class="col-sm-12 col-md-2 col-form-label">Produsen / Konveksi</label>
                                                    <div class="col-sm-12 col-md-10">
                                                        <select name="idprodusen" id="idprodusen" style="width:350px;" class="form-control" required>
                                                            <option value="">--Pilih Produsen/Konveksi--</option>
                                                            <?php foreach($produsen->result() as $p){
                                                                ?><option value="<?=$p->id_produsen;?>"><?=$p->nama_produsen;?></option><?php
                                                            }?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label class="col-sm-12 col-md-2 col-form-label">Total Harga</label>
                                                    <div class="col-sm-12 col-md-10">
                                                        <input type="text" class="form-control" style="width:350px;" oninput="formatAngka(this)" name="totalharga" id="totalharga" placeholder="Masukan harga total produk" required>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label class="col-sm-12 col-md-2 col-form-label">&nbsp;</label>
                                                    <div class="col-sm-12 col-md-10">
                                                        <input type="checkbox" value="yes" name="tagihan" id="tagihan">
                                                        <label for="tagihan">Masukan ke data tagihan saya.</label>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label class="col-sm-12 col-md-2 col-form-label" for="upload">Gambar</label>
                                                    <div class="col-sm-12 col-md-10">
                                                        <input class="form-control" name="upload" id="upload" type="file" onchange="validateAndPreviewImage()" />
                                                        <small>Masukan bukti foto surat jalan. Ekstensi: JPG, PNG</small>
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
                                <div class="modal fade bs-example-modal" id="modals454" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
									<div class="modal-dialog modal-dialog-centered">
										<div class="modal-content">
                                        <?php echo form_open_multipart('import/importexcel',array('name' => 'spreadsheet')); ?>
											<div class="modal-header">
												<h4 class="modal-title" id="myLargeModalLabel">
                                                    Upload Stok From Excel
												</h4>
												<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
													×
												</button>
											</div>
											<div class="modal-body" id="imgshid">
                                                <div style="width:100%;display:flex;flex-direction:column;gap:20px;">
                                                    <label class="form-label">Upload Excel</label>
                                                    <input class="form-control" placeholder="Upload List" type="file" name="upload_file" id="upload_file" required>
                                                </div> 
											</div>
											<div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">
                                                    Close
                                                </button>
                                                <button type="submit" class="btn btn-success">Import Data</button>
                                            </div>
                                        <?php echo form_close();?>
										</div>
                                        
									</div>
								</div>
                </div>
				
			</div>
		</div>
<script>
function cekinput(){
    const jumlahInput = document.getElementById('jumlah').value;
    const ukuranInput = document.getElementById('ukuran').value;
    const notis1 = document.getElementById('idnotice');
    const notis2 = document.getElementById('idnotice2');

            // Mengubah input menjadi array
            const jumlahArray = jumlahInput.split(',').map(Number);
            const ukuranArray = ukuranInput.split(',');

            // Memeriksa kesesuaian jumlah
            if (jumlahArray.length !== ukuranArray.length) {
                //alert('Jumlah dan ukuran harus memiliki jumlah yang sama!');
                notis1.innerHTML = 'Jumlah dan ukuran harus memiliki jumlah yang sama!';
                notis2.innerHTML = '';
                return;
            }

            // Memeriksa input yang valid
            for (let i = 0; i < jumlahArray.length; i++) {
                if (jumlahArray[i] <= 0 || isNaN(jumlahArray[i])) {
                    //alert(`Jumlah tidak valid pada data ke-${i + 1}`);
                    notis1.innerHTML = `Jumlah tidak valid pada data ke-${i + 1}`;
                    notis2.innerHTML = '';
                    return;
                }
                if (ukuranArray[i].trim() === '') {
                    //alert(`Ukuran tidak boleh kosong pada data ke-${i + 1}`);
                    notis1.innerHTML = `Ukuran tidak boleh kosong pada data ke-${i + 1}`;
                    notis2.innerHTML = '';
                    return;
                }
            }

            notis1.innerHTML = '';
            notis2.innerHTML = 'Jumlah dan Ukuran Sudah Valid';
}
</script>