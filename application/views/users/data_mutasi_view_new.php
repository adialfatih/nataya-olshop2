<div class="main-container">
			<div class="pd-ltr-20 xs-pd-20-10">
				<div class="min-height-200px">
					<div class="page-header">
						<div class="row">
							<div class="col-md-6 col-sm-12">
								<div class="title">
									<h4>Tambah Data Mutasi Karyawan</h4>
								</div>
								<nav aria-label="breadcrumb" role="navigation">
									<ol class="breadcrumb">
										<li class="breadcrumb-item">
											<a href="<?=base_url('beranda');?>">Home</a>
										</li>
                                        <li class="breadcrumb-item">
											<a href="#">Mutasi</a>
										</li>
										<li class="breadcrumb-item active" aria-current="page">
											Baru
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
							$bln = array(
								'01' => 'Jan', '02' => 'Feb', '03' => 'Mar', '04' => 'Apr', '05' => 'Mei', '06' => 'Jun', '07' => 'Jul', '08' => 'Agu', '09' => 'Sep', '10' => 'Okt', '11' => 'Nov', '12' => 'Des',
							);
							//echo $akses;
                        ?>
                    
					<!-- Simple Datatable start -->
					<div class="card-box mb-30">
						<div class="pd-20">&nbsp;</div>
						<div class="pb-20">
                                            <form action="<?=base_url('proses/mutasikar');?>" method="post" style="padding:0 20px 0 20px;">
                                            <input type="hidden" id="tipeinput" name="tipeinput" value="0">
											
                                                <!-- <div style="width:100%;height:100px;display:flex;justify-content:center;align-items:center;"><div class="loader"></div></div>
                                                <div style="width:100%;display:flex;justify-content:center;align-items:center;">Please Wait...</div> -->
                                                <div class="form-group row">
                                                    <label class="col-sm-12 col-md-2 col-form-label">NRP / Nama Karyawan</label>
                                                    <div class="col-sm-12 col-md-10">
                                                        <div class="form-label">
                                                            <div class="autoComplete_wrapper">
                                                                <input id="autoComplete" type="search" dir="ltr" spellcheck=false autocorrect="off" autocomplete="off" name="nrp" autocapitalize="off" required>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group row" style="margin-top:-30px;font-size:14px;">
                                                    <label class="col-sm-12 col-md-2 col-form-label" for="nrp_id">&nbsp;</label>
                                                    <div class="col-sm-12 col-md-10" id="nrpnotis">
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label class="col-sm-12 col-md-2 col-form-label" for="dep_id">Departement</label>
                                                    <div class="col-sm-12 col-md-10">
                                                        <div class="form-label">
                                                            <select name="dep_id" id="dep_id" class="form-control" style="width:300px;" required>
                                                                <option value="">Pilih Departement</option>
                                                                <?php foreach($dep->result() as $val): ?>
                                                                    <option value="<?=$val->departement?>"><?=$val->departement?></option>
                                                                <?php endforeach; ?>
                                                            </select>
                                                        </div>
                                                            
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label class="col-sm-12 col-md-2 col-form-label" for="div_id">Divisi</label>
                                                    <div class="col-sm-12 col-md-10">
                                                        <div class="form-label">
                                                            <select name="div_id" id="div_id" class="custom-select2 form-control" required>
                                                                <option value="">Pilih Divisi</option>
                                                                <?php foreach($divisi->result() as $val): ?>
                                                                    <option value="<?=$val->divisi?>"><?=$val->divisi?></option>
                                                                <?php endforeach; ?>
                                                                <option value="Swiper Lusi">Swiper Lusi</option>
                                                            </select>
                                                        </div>
                                                            
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label class="col-sm-12 col-md-2 col-form-label" for="jab_id">Jabatan</label>
                                                    <div class="col-sm-12 col-md-10">
                                                        <div class="form-label">
                                                            <select name="jab_id" id="jab_id" class="custom-select2 form-control" style="max-width: 400px; height: 38px" required>
                                                                <option value="">Pilih Jabatan</option>
                                                                <?php foreach($jab->result() as $val): ?>
                                                                    <option value="<?=$val->jabatan?>"><?=$val->jabatan?></option>
                                                                <?php endforeach; ?>
                                                                <option value="Pemberes Lusi">Pemberes Lusi</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group row" id="submitbutton2">
                                                    <label class="col-sm-12 col-md-2 col-form-label" for="kjk">KJK</label>
                                                    <div class="col-sm-12 col-md-10">
                                                        <div class="form-label">
                                                            <select name="kjkname" id="kjk" class="form-control" required>
                                                                <option value="">Pilih </option>
                                                                <option value="yes">KJK </option>
                                                                <option value="null">NON KJK </option>
                                                            </select>
                                                        </div>
                                                            
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label class="col-sm-12 col-md-2 col-form-label" for="Shift">Shift</label>
                                                    <div class="col-sm-12 col-md-10">
                                                        <div class="form-label">
                                                            <select name="shiftname" id="Shift" class="form-control" required>
                                                                <option value="">Pilih </option>
                                                                <option value="Shift">Shift </option>
                                                                <option value="GS">DS </option>
                                                            </select>
                                                        </div>
                                                            
                                                    </div>
                                                </div>
                                                
                                                <div class="form-group row">
                                                    <label class="col-sm-12 col-md-2 col-form-label" for="tglmut">Tanggal Mutasi</label>
                                                    <div class="col-sm-12 col-md-10">
                                                        <div class="form-label">
                                                            <input type="date" min="2024-08-22" value="<?=date('Y-m-d');?>" name="tglmut" id="tglmut" class="form-control" style="width:300px;">
                                                        </div>
                                                            
                                                    </div>
                                                </div>
												<button type="button" onclick="history.back()" class="btn btn-secondary" data-dismiss="modal">
													Batal
												</button>
												<button type="submit" class="btn btn-success" style="color:#fff;">
													Simpan
												</button>
											
                                            </form>
						</div>
					</div>
					<!-- Simple Datatable End -->
					<!-- Popup -->		
                </div>
				
			</div>
		</div>
        