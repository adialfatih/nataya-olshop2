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
								<h4 class="text-blue h4">Surat Perintah Lembur</h4>
								<p class="mb-30">Buat SPL dihalaman ini kemudian tambahkan beberapa karyawan.</p>
							</div>
							
						</div>
                        <?php
                        $uri = $this->uri->segment(4);
                        $acakKode = $this->data_model->acakKode(15);
                        $cekuri = $this->data_model->get_byid('data_lembur',['urlcode'=>$uri]);
                        if($cekuri->num_rows() == 1){
                            $links = "true";
                        } else {
                            $links = "false";
                        }
                        ?>
						<form action="#" method="post" enctype="multipart/form-data">
                            <div class="form-group row">
								<label class="col-sm-12 col-md-2 col-form-label" for="dep">Departement</label>
								<div class="col-sm-12 col-md-10" style="display:flex;align-items:center;">
                                    <?php if($links == "true"){ ?>
                                        <input type="text" id="dep" name="dep" class="form-control" value="<?=$cekuri->row("dep");?>" style="width:300px;" readonly>
                                    <?php } else { ?>
									<select name="dep" id="dep" class="form-control" style="width:300px;">
                                        <option value="">Pilih Departement</option>
                                        <?php
                                            $dtdep = $this->data_model->showDepartement();
                                            foreach ($dtdep->result() as $key => $value) {
                                                echo '<option value="'.$value->departement.'">'.$value->departement.'</option>';
                                            }
                                        ?>
                                    </select>
                                    <?php } ?>
								</div>
							</div>
                            <div class="form-group row">
								<label class="col-sm-12 col-md-2 col-form-label" for="pengganti">Tanggal Lembur</label>
								<div class="col-sm-12 col-md-10" style="display:flex;align-items:center;">
                                    <?php if($links == "true"){ 
                                    $hari_lembur = $cekuri->row("hari_lembur");
                                    $_x = explode('-', $cekuri->row("tgl_lembur"));
                                    $_print = $_x[2].' '.$this->data_model->printBln($_x[1]).' '.$_x[0];
                                    $_x2 = $hari_lembur.", ".$_print;
                                    ?>
                                        <input type="text" id="tgllembur" name="tgllembur" class="form-control" value="<?=$_x2;?>" style="width:300px;" readonly>
                                    <?php } else { ?>
									<input type="date" name="tgllembur" id="tgllembur" class="form-control" style="width:300px;" required>
                                    <?php } ?>
								</div>
							</div>
                            
                            <div class="form-group row">
								<label class="col-sm-12 col-md-2 col-form-label" for="alasan">Uraian Tugas</label>
								<div class="col-sm-12 col-md-10" style="display:flex;align-items:center;">
                                    <?php if($links == "true"){ ?>
                                        <textarea name="tugas" id="tugas" class="form-control" style="width:400px;height:80px;" placeholder="Masukan Uraian Tugas Lembur Untuk Karyawan" readonly><?=$cekuri->row("uraian_tugas");?></textarea>
                                    <?php } else { ?>
									<textarea name="tugas" id="tugas" class="form-control" style="width:400px;height:80px;" placeholder="Masukan Uraian Tugas Lembur Untuk Karyawan" required></textarea>
                                    <?php } ?>
								</div>
							</div>
                            <div class="form-group row">
								<label class="col-sm-12 col-md-2 col-form-label" for="isti">Waktu Istirahat</label>
								<div class="col-sm-12 col-md-10" style="display:flex;align-items:center;">
                                <?php if($links=="true"){ ?>
                                <input type="text" id="jamisti" value="<?=$cekuri->row("istirahat_lembur");?> Menit" class="form-control" style="width:300px;" readonly>
                                <?php 
                                } else { ?>
                                <div class="btn-group btn-group-toggle" data-toggle="buttons">
									<label class="btn btn-outline-success active">
										<input type="radio" name="options" value="60" id="option1" />
										1 JAM
									</label>
									<label class="btn btn-outline-success">
										<input type="radio" name="options" value="30" id="option2" />
										30 MENIT
									</label>
									<label class="btn btn-outline-success">
										<input type="radio" name="options" value="0" id="option3" checked />
										TANPA ISTIRAHAT
									</label>
								</div>
                                <?php } ?>
                                </div>
                            </div>
                            <?php if($links=="true"){ ?>
                            <div class="form-group row">
								<label class="col-sm-12 col-md-2 col-form-label" for="inputyg">Di input Oleh</label>
								<div class="col-sm-12 col-md-10" style="display:flex;align-items:center;">
                                <input type="text" id="inputyg" value="<?=$cekuri->row("yg_input");?>" class="form-control" style="width:300px;" readonly>
                                </div>
                            </div>
                            <?php } ?>
                            <div class="form-group row" style="padding:10px;">
                                <div class="custom-control custom-checkbox mb-5">
                                <?php if($links == "true"){ ?>
                                    <input type="checkbox" class="custom-control-input" id="cek" name="cek" value="oke" <?=$cekuri->row("hari_kerja")=='n' ? 'checked' : '';?> disabled />
									<label class="custom-control-label" for="cek">Centang jika lembur pada <strong>hari libur</strong></label>
                                <?php } else { ?>
									<input type="checkbox" class="custom-control-input" id="cek" name="cek" value="oke" />
									<label class="custom-control-label" for="cek">Centang jika lembur pada <strong>hari libur</strong></label>
                                <?php } ?>
								</div>
							</div>
                            
                            <input type="hidden" name="urlcode" id="urlcode" value="<?=$links=='true' ? $uri:$acakKode ;?>">
                            <?php if($links != "true"){ ?>
                            <div class="form-group row" style="padding:20px;">
                                <button type="button" class="btn btn-primary" id="submitbutton2">
                                    <i class="icon-copy bi bi-save-fill"></i>
									&nbsp;Simpan
								</button>
                                <input type="hidden" id="autoComplete">
							</div>
                            <?php } else { ?>
                            <div id="tesjson" class="table-responsive">
                                <table class="table table-striped table-bordered">
                                    <thead>
                                        <tr>
                                            <th rowspan="2" style="text-align:center;vertical-align:middle;">No</th>
                                            <th rowspan="2" style="text-align:center;vertical-align:middle;">Nama Karyawan</th>
                                            <th rowspan="2" style="text-align:center;vertical-align:middle;">Jabatan</th>
                                            <th colspan="2" style="text-align:center;">Jam Lembur</th>
                                            <th rowspan="2" style="text-align:center;vertical-align:middle;">Lama Lembur</th>
                                            <th rowspan="2" style="text-align:center;vertical-align:middle;">Verif</th>
                                            <?php if(strtolower($sess_nama) == $yg_inputs OR $sess_nama=="Users"){ ?>
                                            <th rowspan="2" style="text-align:center;vertical-align:middle;">Hapus</th><?php } ?>
                                            <?php if($akses == "'ADM'"){ echo '<th rowspan="2" style="text-align:center;vertical-align:middle;">Action</th>'; }?>
                                        </tr>
                                        <tr>
                                            <th  style="text-align:center;">Jam Mulai</th>
                                            <th  style="text-align:center;">Berakhir</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                            $_qr = $this->db->query("SELECT * FROM data_lembur_kar WHERE id_data_lembur='$uri'");
                                            if($_qr->num_rows() > 0){ 
                                        $no=1;
                                        foreach($_qr->result() as $val):
                                            $__acc = $val->acc_hrd;
                                            $__idkar = $val->id_data_lembur_kar;
                                            $__jam_awal = $val->dari_jam;
                                            $__jam_akhir = $val->sampai_jam;
                                            
                                        ?>
                                        <tr>
                                            <td style="text-align:center;"><?=$no;?></td>
                                            <td>
                                                <?=ucwords($val->nama);?>
                                            </td>
                                            <td><?=ucwords($val->jabatan);?></td>
                                            <td style="text-align:center;"><?=$val->dari_jam;?></td>
                                            <td style="text-align:center;"><?=$val->sampai_jam;?></td>
                                            <td style="text-align:center;"><?=$val->total_jam;?></td>
                                            <?php
                                            if($akses == "'ADM'"){ ?>
                                            <td style="text-align:center;">
                                                <?php if($__acc == "no"){ echo '<span class="badge badge-warning">Pending Verification</span>'; }?>
                                                <?php if($__acc == "acc"){ echo '<span class="badge badge-success">Acc</span>'; }?>
                                                <?php if($__acc == "dis"){ echo '<span class="badge badge-danger">Reject</span>'; }?>
                                            </td>
                                            <td>
                                                <div class="dropdown">
                                                    <a class="btn btn-link font-24 p-0 line-height-1 no-arrow dropdown-toggle" href="#" role="button" data-toggle="dropdown">
                                                                <i class="dw dw-more"></i>
                                                    </a>
                                                    <div class="dropdown-menu dropdown-menu-right dropdown-menu-icon-list">
                                                        <!-- <a class="dropdown-item" href="javascript:void(0);" onclick="accthis('<?=$__idkar;?>','<?=ucwords($val->nama);?>','y')">
                                                            <i class="bi bi-check2-circle" style="color:green;"></i> Acc
                                                        </a>
                                                        <a class="dropdown-item" href="javascript:void(0);" onclick="accthis('<?=$__idkar;?>','<?=ucwords($val->nama);?>','n')">
                                                            <i class="bi bi-x-circle" style="color:red;"></i> Tolak
                                                        </a> -->
                                                        <a class="dropdown-item" href="javascript:void(0);" onclick="accthis('<?=$__idkar;?>','<?=ucwords($val->nama);?>','hpsthis')">
                                                            <i class="bi bi-x" style="color:red;"></i> Hapus
                                                        </a>
                                                    </div>
                                                </div>
                                            </td>
                                            <?php
                                            } else {
                                            ?>
                                            <td style="text-align:center;">
                                                <?php if($__acc == "no"){ echo '<span class="badge badge-warning">Pending Verification</span>'; }?>
                                                <?php if($__acc == "acc"){ echo '<span class="badge badge-success">Acc</span>'; }?>
                                                <?php if($__acc == "dis"){ echo '<span class="badge badge-danger">Reject</span>'; }?>
                                            </td>
                                            <?php } 
                                            if(strtolower($sess_nama) == $yg_inputs OR $sess_nama=="Users"){ ?>
                                            <td style="text-align:center;"><a style="color:red;" onclick="hapusLmeburKar('<?=$__idkar;?>','<?=ucwords($val->nama);?>')" href="javascript:void(0);">Hapus</a></td> <?php } ?>
                                        </tr>
                                        <?php $no++; endforeach;
                                            } else {
                                                if($akses == "'ADM'"){
                                                    echo "<tr><td colspan='8'>Tidak ada data</td></tr>";
                                                } else {
                                                    echo "<tr><td colspan='8'>Tidak ada data</td></tr>";
                                                }
                                            }
                                            if(strtolower($sess_nama) == $yg_inputs OR $sess_nama=="Users"){
                                        ?>
                                        <tr>
                                            <td colspan="<?=$akses == "'ADM'" ? '9':'8';?>">
                                                <button type="button" class="btn btn-primary" id="addbutton2" data-toggle="modal"
                                                data-target="#bd-example-modal-lg">
                                                    + Tambahkan Karyawan
                                                </button>
                                            </td>
                                        </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                                <?php if($akses == "'ADM'"){ ?>
                                                <button type="button" class="btn btn-success" onclick="accsemua('<?=$uri;?>')">
                                                    Acc Semua
                                                </button>
                                                <button type="button" class="btn btn-danger" onclick="rejectsemua('<?=$uri;?>')">
                                                    Tolak Semua
                                                </button>
                                                &nbsp;&nbsp;
                                                <button type="button" class="btn btn-danger" onclick="hapusspl('<?=$uri;?>')">
                                                    Hapus SPL
                                                </button>
                                <?php } ?>
                            </div>
                            <?php } ?>
                        </form>
					</div>
					<!-- Simple Datatable End -->
                    <?php if($links == "true"){ ?>
                                <div class="modal fade bs-example-modal-lg" id="bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
									<div class="modal-dialog modal-lg modal-dialog-centered">
										<div class="modal-content">
											<div class="modal-header">
												<h4 class="modal-title" id="myLargeModalLabel">
													Tambah Karyawan
												</h4>
												<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
											</div>
                                            <form action="<?=base_url('userproses/inputlembur2'); ?>" method="post">
											<div class="modal-body">
                                                <div class="form-group row">
                                                    <label class="col-sm-12 col-md-2 col-form-label">Karyawan</label>
                                                    <div class="col-sm-12 col-md-10">
                                                        <div class="autoComplete_wrapper">
                                                            <input id="autoComplete" type="search" dir="ltr" spellcheck=false autocorrect="off" autocomplete="off" name="nrp" autocapitalize="off" required>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label class="col-sm-12 col-md-2 col-form-label">Jam Awal Lembur</label>
                                                    <div class="col-sm-12 col-md-10">
                                                        <input type="text" id="awal" name="awal" class="form-control" style="width:300px;" value="13:00">
                                                        <span id="timeFeedback" class="valid">Valid time format</span>
                                                    </div>
                                                    
                                                </div>
                                                <div class="form-group row">
                                                    <label class="col-sm-12 col-md-2 col-form-label">Jam Selesai Lembur</label>
                                                    <div class="col-sm-12 col-md-10">
                                                        <input type="text" id="akhir" name="akhir" class="form-control" style="width:300px;" value="14:00">
                                                        <span id="timeFeedback2" class="valid">Valid time format</span>
                                                    </div>
                                                    
                                                    <input type="hidden" name="kode" value="<?=$uri;?>">
                                                </div>
											</div>
                                            <input type="hidden" value="<?=$cekuri->row("istirahat_lembur");?>" name="jamisti">
											<div class="modal-footer">
												<button type="button" class="btn btn-secondary" data-dismiss="modal">
													Close
												</button>
												<button type="submit" class="btn btn-primary">
													Save changes
												</button>
											</div>
                                            </form>
										</div>
									</div>
                                </div>
                    <?php } ?>
                </div>
				<input type="hidden" id="submitbutton2">
			</div>
		</div>
        <script>
            function validateTimeInput(time) {
                const timeFormat = /^([01]\d|2[0-3]):([0-5]\d)$/;
                return timeFormat.test(time);
            }
            const timeInput = document.getElementById('awal');
            const timeFeedback = document.getElementById('timeFeedback');

            // Menambahkan event listener untuk 'input'
            timeInput.addEventListener('input', function() {
                const timeValue = timeInput.value;

                if (validateTimeInput(timeValue)) {
                    timeFeedback.textContent = "Valid time format.";
                    timeFeedback.classList.add('valid');
                    timeFeedback.classList.remove('invalid');
                } else {
                    timeFeedback.textContent = "Invalid time format.";
                    timeFeedback.classList.remove('valid');
                    timeFeedback.classList.add('invalid');
                }
            });
            const timeInput2 = document.getElementById('akhir');
            const timeFeedback2 = document.getElementById('timeFeedback2');

            // Menambahkan event listener untuk 'input'
            timeInput2.addEventListener('input', function() {
                const timeValue = timeInput2.value;

                if (validateTimeInput(timeValue)) {
                    timeFeedback2.textContent = "Valid time format.";
                    timeFeedback2.classList.add('valid');
                    timeFeedback2.classList.remove('invalid');
                } else {
                    timeFeedback2.textContent = "Invalid time format.";
                    timeFeedback2.classList.remove('valid');
                    timeFeedback2.classList.add('invalid');
                }
            });
        </script>