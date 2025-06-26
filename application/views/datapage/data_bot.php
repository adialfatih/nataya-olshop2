<div class="main-container">
			<div class="pd-ltr-20 xs-pd-20-10">
				<div class="min-height-200px">
					<div class="page-header">
						<div class="row">
							<div class="col-md-6 col-sm-12">
								<div class="title">
									<h4>Pengaturan BOT WhatsApp</h4>
								</div>
								<nav aria-label="breadcrumb" role="navigation">
									<ol class="breadcrumb">
										<li class="breadcrumb-item">
											<a href="<?=base_url('beranda');?>">Home</a>
										</li>
                                        <li class="breadcrumb-item">
											<a href="#">Settings</a>
										</li>
										<li class="breadcrumb-item active" aria-current="page">
                                            BOT WhatsApp
										</li>
									</ol>
								</nav>
							</div>
                            <?php if($sess_akses=="Super"){?>
							<div class="col-md-6 col-sm-12 text-right">
								<div class="dropdown">
									<a class="btn btn-success" href="javascript:void(0);" role="button" data-toggle="modal" data-target="#bd-example-modal-lg">
										+ Auto Reply
									</a>
								</div>
							</div>
                            <?php } ?>
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
										<th>Pesan User</th>
										<th>Auto Reply</th>
										<th>Tipe</th>
										<th>File</th>
										<th class="datatable-nosort">Action</th>
									</tr>
								</thead>
								<tbody>
                                    <?php
                                    if($bot->num_rows() > 0){
                                        $no=1;
                                        foreach($bot->result() as $val):
                                    ?>
                                    <tr>
                                        <td><?=$no++;?></td>
                                        <td><?=$val->pesan;?></td>
                                        <td><?=$val->jawaban;?></td>
                                        <td><?=ucwords($val->tipe_reply);?></td>
                                        <td><?=$val->url_file;?></td>
                                        <td>
                                            <div class="dropdown">
                                                <a class="btn btn-link font-24 p-0 line-height-1 no-arrow dropdown-toggle" href="#" role="button" data-toggle="dropdown">
                                                            <i class="dw dw-more"></i>
                                                </a>
                                                <div class="dropdown-menu dropdown-menu-right dropdown-menu-icon-list">
                                                    <a class="dropdown-item" href="javascript:void(0);" onclick="del('Pesan Auto Reply','<?=$val->idbot;?>','Pesan')">
                                                        <i class="dw dw-trash"></i> Delete
                                                    </a>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <?php
                                        endforeach;
                                    } else {
                                        echo "<tr><td colspan='6'>Anda belum membuat auto reply</td></tr>";
                                    }
                                    
                                    ?>
                                </tbody>
							</table>
						</div>
					</div>
					<!-- Simple Datatable End -->
					            <div class="modal fade bs-example-modal-lg" id="bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
									<div class="modal-dialog modal-lg modal-dialog-centered">
										<div class="modal-content">
											<div class="modal-header">
												<h4 class="modal-title" id="myLargeModalLabel">
													Buat Auto Reply
												</h4>
												<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
													×
												</button>
											</div>
                                            <?php echo form_open_multipart('save-bot'); ?>
											<div class="modal-body">
                                                <div class="form-group row">
                                                    <label class="col-sm-12 col-md-2 col-form-label" for="pesanuser">Pesan User</label>
                                                    <div class="col-sm-12 col-md-10">
                                                        <input class="form-control" name="pesanuser" id="pesanuser" type="text" placeholder="Masukan pesan dari user" required />
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label class="col-sm-12 col-md-2 col-form-label" for="idreplay">Balasan</label>
                                                    <div class="col-sm-12 col-md-10">
                                                        <textarea class="form-control" name="idreplay" id="idreplay" type="text" placeholder="Masukan jawaban yang anda inginkan"></textarea>
                                                        <small>Gunakan <font style="color:red;">\n</font> untuk ENTER</small>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label class="col-sm-12 col-md-2 col-form-label" for="tipebalasan">Tipe Balasan</label>
                                                    <div class="col-sm-12 col-md-10">
                                                        <select name="tipebalasan" id="tipebalasan" class="form-control" style="width:250px;">
                                                            <option value="teks">Text</option>
                                                            <option value="image">Pesan Gambar</option>
                                                            <option value="file">Kirim File</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label class="col-sm-12 col-md-2 col-form-label" for="upload">Upload</label>
                                                    <div class="col-sm-12 col-md-10">
                                                        <input class="form-control" name="upload" id="upload" type="file" onchange="validateFile('file')" />
                                                        <small>Hanya boleh : PNG, JPG, Doc, Xlxs, Pdf</small>
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
                                
                </div>
				
			</div>
		</div>