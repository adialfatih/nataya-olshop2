<div class="main-container">
			<div class="pd-ltr-20 xs-pd-20-10">
				<div class="min-height-200px">
					<div class="page-header">
						<div class="row">
							<div class="col-md-6 col-sm-12">
								<div class="title">
									<h4>Menampilkan Data Distributor</h4>
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
                                            Distributor
										</li>
									</ol>
								</nav>
							</div>
                            <?php if($sess_akses=="Super"){?>
							<div class="col-md-6 col-sm-12 text-right">
								<div class="dropdown">
									<a class="btn btn-success" href="javascript:void(0);" onclick="changeadd()" role="button" data-toggle="modal" data-target="#modals">
										+ Tambah Distributor
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
										<th>Nama Distributor</th>
										<th>No Telp/WhatsApp</th>
										<th>Alamat</th>
										<th class="datatable-nosort">Action</th>
									</tr>
								</thead>
								<tbody>
                                    <?php
                                    if($dist->num_rows() > 0){
                                        $no=1;
                                        foreach($dist->result() as $val){
                                        $id = $val->id_dis;
                                    ?>
                                    <tr>
                                        <td><?=$no;?></td>
                                        <td><?=$val->nama_distributor;?></td>
                                        <td>+62<?=$val->notelp;?></td>
                                        <td><?=$val->alamat;?></td>
                                        <td>
                                            <div class="dropdown">
                                                <a class="btn btn-link font-24 p-0 line-height-1 no-arrow dropdown-toggle" href="#" role="button" data-toggle="dropdown">
                                                            <i class="dw dw-more"></i>
                                                </a>
                                                <div class="dropdown-menu dropdown-menu-right dropdown-menu-icon-list">
                                                    <a class="dropdown-item" href="javascript:void(0);" onclick="edit('<?=$id;?>','<?=$val->nama_distributor;?>','<?=$val->notelp;?>','<?=$val->alamat;?>')" data-toggle="modal" data-target="#modals">
                                                        <i class="dw dw-edit"></i> Edit
                                                    </a>
                                                    <a class="dropdown-item" href="javascript:void(0);" onclick="del('Distributor','<?=$id;?>','<?=$val->nama_distributor;?>')">
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
                                        echo "<tr><td colspan='5'>Anda belum memiliki distributor</td></tr>";
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
													Tambah Distributor
												</h4>
												<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
													×
												</button>
											</div>
                                            <form action="<?=base_url('save-distributor');?>" method="post">
                                            <input type="hidden" name="idtipe" value="0" id="idtipe">
											<div class="modal-body" id="modalBodyid">
                                                <label for="namadistributor">Nama Distributor</label>
                                                <input type="text" id="namadistributor" name="namadistributor" class="form-control" placeholder="Masukan Nama Distributor" required>
                                                <label for="nowa">No Telepon / WA</label>
                                                <input type="number" id="nowa" name="nowa" class="form-control" placeholder="Masukan Nomor Telephon tanpa 0/62" required>
                                                <label for="almt">Alamat Distributor</label>
                                                <textarea name="almt" class="form-control" placeholder="Masukan Alamat Distributor" id="almt"></textarea>
                                            </div>
											<div class="modal-footer">
												<button type="button" class="btn btn-default" data-dismiss="modal">
													Close
												</button>
                                                <button type="submit" class="btn btn-primary">
													Simpan Data
												</button>
											</div>
                                            </form>
										</div>
									</div>
								</div>
                                
                </div>
				
			</div>
		</div>
<script>
    function changeadd(){
        document.getElementById('namadistributor').value = '';
        document.getElementById('idtipe').value = '0';
        document.getElementById('nowa').value = '';
        document.getElementById('almt').value = '';
    }
    function edit(id,nm,no,al){
        document.getElementById('namadistributor').value = ''+nm;
        document.getElementById('idtipe').value = ''+id;
        document.getElementById('nowa').value = ''+no;
        document.getElementById('almt').value = ''+al;
    }
</script>