<div class="main-container">
			<div class="pd-ltr-20 xs-pd-20-10">
				<div class="min-height-200px">
					<div class="page-header">
						<div class="row">
							<div class="col-md-6 col-sm-12">
								<div class="title">
									<h4>Input Data Cuti Karyawan</h4>
								</div>
								<nav aria-label="breadcrumb" role="navigation">
									<ol class="breadcrumb">
										<li class="breadcrumb-item">
											<a href="<?=base_url('beranda');?>">Home</a>
										</li>
                                        <li class="breadcrumb-item">
											<a href="#">Tambah</a>
										</li>
                                        <li class="breadcrumb-item">
											<a href="#">Data</a>
										</li>
										<li class="breadcrumb-item active" aria-current="page">
											Cuti Karyawan
										</li>
									</ol>
								</nav>
							</div>
							
						</div>
					</div>
                    
					<!-- Simple Datatable start -->
					<div class="pd-20 card-box mb-30">
						<div class="clearfix">
							<div class="pull-left">
								<h4 class="text-blue h4">FORMULIR CUTI KARYAWAN</h4>
								<p class="mb-30">PT. Rindang Jati</p>
							</div>
							
						</div>
                        <?php
                            if (!empty($this->session->flashdata('gagal'))) {
                                echo "<div class='alert alert-danger' role='alert'>
                                        ".$this->session->flashdata('gagal').
                                        "</div>";
                            }
							if (!empty($this->session->flashdata('sukses'))) {
                                echo "<div class='alert alert-success' role='alert'>
                                        ".$this->session->flashdata('sukses').
                                        "</div>";
                            }
							$tahun = date('Y');
							
                        ?>
						
						<form action="#" method="post" enctype="multipart/form-data">
							<div class="form-group row">
								<label class="col-sm-12 col-md-2 col-form-label" for="nosurat">TANGGAL SURAT</label>
								<div class="col-sm-12 col-md-10">
									<input class="form-control" id="tgl_surat" type="date" style="width:300px;" name="tgl_surat" value="<?=date('Y-m-d');?>" required />
								</div>
							</div>
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
                            <div class="form-group row" style="margin-top:-20px;">
								<label class="col-sm-12 col-md-2 col-form-label" for="nrp_id"></label>
								<div class="col-sm-12 col-md-10">
                                    <small id="nrpnotis">
                                        
                                    </small>
								</div>
							</div>
							<input type="hidden" id="customCheck1">
							<input type="hidden" id="customCheck2">
							<input type="hidden" id="shiftvalue">
                            <div class="form-group row">
								<label class="col-sm-12 col-md-2 col-form-label" for="jnscuti">JENIS CUTI</label>
								<div class="col-sm-12 col-md-10" style="display:flex;align-items:center;">
									<select name="jnscuti" id="jnscuti" class="form-control" style="width:350px;">
										<option value="">-- Pilih Jenis Cuti--</option>
										<option value="Cuti Tahunan">Cuti Tahunan</option>
										<option value="Cuti Sakit">Cuti Sakit</option>
										<option value="Cuti Besar">Cuti Besar</option>
										<option value="Cuti Khusus Alasan Penting">Cuti Khusus Alasan Penting</option>
										<option value="Cuti Melahirkan">Cuti Melahirkan</option>
										<option value="Cuti Diluar Tanggungan Perusahaan">Cuti Diluar Tanggungan Perusahaan</option>
									</select>
								</div>
							</div>
                            <div class="form-group row">
								<label class="col-sm-12 col-md-2 col-form-label" for="tgl_cuti">TANGGAL CUTI</label>
								<div class="col-sm-12 col-md-10" style="display:flex;align-items:center;">
									<input type="date" name="tgl_cuti" id="tgl_cuti" class="form-control" style="width:250px;" required>
								</div>
							</div>
                            <div class="form-group row">
								<label class="col-sm-12 col-md-2 col-form-label" for="masacuti">MASA CUTI</label>
								<div class="col-sm-12 col-md-10" style="display:flex;align-items:center;">
									<input type="number" name="masacuti" id="masacuti" class="form-control" style="width:100px;" value="0" min="0" max="2" required>&nbsp; Hari
								</div>
							</div>
                            <input type="hidden" id="tmt2" value="0" name="tmt2">
                            <div class="form-group row">
								<label class="col-sm-12 col-md-2 col-form-label" for="alasan">ALASAN CUTI</label>
								<div class="col-sm-12 col-md-10" style="display:flex;align-items:center;">
									<textarea name="alasan" id="alasan" class="form-control" style="width:400px;height:100px;" placeholder="Masukan alasan cuti"></textarea>
								</div>
							</div>
                            <!-- <hr>
                            <span style="font-weight:bold;">Data Diri Karyawan</span>
                            <hr> -->
                            <input type="hidden" id="tipeLoginUser" value="users">
							<div class="form-group row" style="padding-left:20px;margin-top:30px;">
								<button class="btn btn-primary" type="button" id="simpanCuti">Simpan Data Cuti</button>
							</div>
                            <div style="width:100%;padding:10px;background:#f5f5f5;" id="prosesData">
                                
                            </div>
                        </form>
                    </div>
					<!-- Simple Datatable End -->
                </div>
				<input type="hidden" id="tgl_masuk">
				<input type="hidden" id="tahunids">
				<input type="hidden" id="bulanids">
			</div>
		</div>
        