<div class="main-container">
			<div class="pd-ltr-20 xs-pd-20-10">
				<div class="min-height-200px">
					
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
                        ?>
                    
					<!-- Simple Datatable start -->
					<div class="pd-20 card-box mb-30">
                        <div class="clearfix">
							<div class="pull-left">
								<h4 class="text-blue h4">Ganti Libur Mingguan Karyawan</h4>
								<p class="mb-30">PT. Rindang Jati Spinning</p>
							</div>
							
						</div>
                        						
						<form action="<?=base_url('userproses/gantilibur');?>" method="post" enctype="multipart/form-data">
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
                            <div class="form-group row">
								<label class="col-sm-12 col-md-2 col-form-label" for="nrp_id"></label>
								<div class="col-sm-12 col-md-10">
                                    <small id="nrpnotis"></small>
								</div>
							</div>
                            <div class="form-group row">
								<label class="col-sm-12 col-md-2 col-form-label" for="hari_libur">Hari Libur</label>
								<div class="col-sm-12 col-md-10" style="display:flex;align-items:center;">
									<input type="text" name="hari_libur" id="hari_libur" class="form-control" style="width:300px;" placeholder="Pilih karyawan" readonly>
								</div>
							</div>
                            <div class="form-group row">
								<label class="col-sm-12 col-md-2 col-form-label" for="pengganti">Ganti Ke</label>
								<div class="col-sm-12 col-md-10" style="display:flex;align-items:center;">
									<select name="pengganti" id="pengganti" class="form-control" style="width:300px;" required>
                                        <option value="">Pilih Hari</option>
                                        <option value="SENIN">Senin</option>
                                        <option value="SELASA">Selasa</option>
                                        <option value="RABU">Rabu</option>
                                        <option value="KAMIS">Kamis</option>
                                        <option value="JUMAT">Jumat</option>
                                        <option value="SABTU">Sabtu</option>
                                        <option value="MINGGU">Minggu</option>
                                        
                                    </select>
								</div>
							</div>
                            
                            <div class="form-group row" style="padding:10px;">
                                <div class="custom-control custom-checkbox mb-5">
									<input type="checkbox" class="custom-control-input" id="customCheck1" name="cek" value="oke" />
									<label class="custom-control-label" for="customCheck1">Tetap dihalaman ini setelah menyimpan</label>
								</div>
							</div>
                            <div class="form-group row" style="padding:20px;">
                                <button type="submit" class="btn btn-primary">
                                    <i class="icon-copy bi bi-save-fill"></i>
									&nbsp;Simpan
								</button>
							</div>
                            <div id="tesjson">

                            </div>
                        </form>
					</div>
					<!-- Simple Datatable End -->
								
                </div>
				
			</div>
		</div>
        