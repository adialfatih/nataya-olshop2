<div class="main-container">
			<div class="pd-ltr-20 xs-pd-20-10">
				<div class="min-height-200px">
					<div class="page-header">
						<div class="row">
							<div class="col-md-6 col-sm-12">
								<div class="title">
									<h4>Menampilkan Data Akses User</h4>
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
                                            Akses User 
										</li>
									</ol>
								</nav>
							</div>
                            <?php if($sess_akses=="Super"){?>
							<div class="col-md-6 col-sm-12 text-right">
								<div class="dropdown">
									<a class="btn btn-success" href="javascript:void(0);" onclick="changeadd()" role="button" data-toggle="modal" data-target="#modals">
										+ Tambah User
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
										<th>Nama User</th>
										<th>Username</th>
										<th>Password</th>
										<th>Hak Akses</th>
										<th class="datatable-nosort">Action</th>
									</tr>
								</thead>
								<tbody>
                                    <?php $no=1; foreach($users->result() as $val){ 
                                    $_nama = ucwords($val->nama_admin);
                                    $_user = $val->username;
                                    $_pass = $val->password;
                                    $_akses = $val->akses;
                                    $_id = $val->idadm;
                                    ?>
                                    <tr>
                                        <td><?=$no;?></td>
                                        <td><?=$_nama;?></td>
                                        <td><?=$_user;?></td>
                                        <td>*********</td>
                                        <td>
                                            <?php
                                            if($_akses == "Super"){ echo "<span class='badge badge-danger'>Super Admin</span>"; }
                                            if($_akses == "Admin"){ echo "<span class='badge badge-success'>Admin</span>"; }
                                            if($_akses == "User"){ echo "<span class='badge badge-warning'>Users</span>"; }
                                            ?>
                                        </td>
                                        <td>
                                            <?php if($sess_akses=="Super"){?>
                                            <div class="dropdown">
                                                <a class="btn btn-link font-24 p-0 line-height-1 no-arrow dropdown-toggle" href="#" role="button" data-toggle="dropdown">
                                                            <i class="dw dw-more"></i>
                                                </a>
                                                <div class="dropdown-menu dropdown-menu-right dropdown-menu-icon-list">
                                                    <a class="dropdown-item" href="javascript:void(0);" onclick="edit('<?=$_id;?>', '<?=$_nama;?>','<?=$_user;?>','<?=$_pass;?>','<?=$_akses;?>')" data-toggle="modal" data-target="#modals">
                                                        <i class="dw dw-edit"></i> Edit
                                                    </a>
                                                    <a class="dropdown-item" href="javascript:void(0);" onclick="del('User', '<?=$val->username;?>','<?=$val->nama_admin;?>')">
                                                        <i class="dw dw-trash"></i> Delete
                                                    </a>
                                                </div>
                                            </div>
                                            <?php } else { 
                                            if($_user == $sess_username){
                                            ?><div class="dropdown">
                                                <a class="btn btn-link font-24 p-0 line-height-1 no-arrow dropdown-toggle" href="#" role="button" data-toggle="dropdown">
                                                            <i class="dw dw-more"></i>
                                                </a>
                                                <div class="dropdown-menu dropdown-menu-right dropdown-menu-icon-list">
                                                    <a class="dropdown-item" href="javascript:void(0);" onclick="edit('<?=$_id;?>', '<?=$_nama;?>','<?=$_user;?>','<?=$_pass;?>','<?=$_akses;?>')" data-toggle="modal" data-target="#modals">
                                                        <i class="dw dw-edit"></i> Edit
                                                    </a>
                                                </div>
                                            </div>
                                            <?php
                                            } } ?>
                                        </td>
                                    </tr>
                                    <?php $no++; } ?>
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
													Tambah Akses
												</h4>
												<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
													×
												</button>
											</div>
                                            <form action="<?=base_url('save-user');?>" method="post">
                                            <input type="hidden" name="idtipe" value="0" id="idtipe">
											<div class="modal-body" id="modalBodyid">
                                                <label for="namauser">Nama User</label>
                                                <input type="text" id="namauser" name="nama" class="form-control" placeholder="Masukan Nama User" required>
                                                <label for="username">Username Login</label>
                                                <input type="text" id="username" name="username" class="form-control" placeholder="Masukan Username Login" required>
                                                <label for="pass">Password Login</label>
                                                <input type="text" id="pass" name="pass" class="form-control" placeholder="Masukan Password Login" required>
                                                <label for="akses">Hak Akses User</label>
                                                <select name="akses" id="akses" class="form-control" required>
                                                    <option value="">Pilih Hak Akses</option>
                                                    <option value="Super">Super Admin</option>
                                                    <option value="Admin">Admin</option>
                                                    <option value="User">User</option>
                                                </select>
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
        document.getElementById('idtipe').value = '0';
        document.getElementById('namauser').value = '';
        document.getElementById('username').value = '';
        document.getElementById('pass').value = '';
        document.getElementById('akses').value = '';
    }
    function edit(id,nm,usn,pass,akses){
        document.getElementById('idtipe').value = ''+id;
        document.getElementById('namauser').value = ''+nm;
        document.getElementById('username').value = ''+usn;
        document.getElementById('pass').value = ''+pass;
        document.getElementById('akses').value = ''+akses;

    }
</script>