<div class="main-container">
			<div class="pd-ltr-20 xs-pd-20-10">
				<div class="min-height-200px">
					<div class="page-header">
						<div class="row">
							<div class="col-md-6 col-sm-12">
								<div class="title">
									<h4>Data Tukar Libur Karyawan</h4>
								</div>
								<nav aria-label="breadcrumb" role="navigation">
									<ol class="breadcrumb">
										<li class="breadcrumb-item">
											<a href="<?=base_url('beranda');?>">Home</a>
										</li>
                                        <li class="breadcrumb-item">
											<a href="#">Users</a>
										</li>
                                        <li class="breadcrumb-item">
											<a href="#">Data</a>
										</li>
										<li class="breadcrumb-item active" aria-current="page">
											Tukar Libur
										</li>
									</ol>
								</nav>
							</div>
							<div class="col-md-6 col-sm-12 text-right">
								<div class="dropdown">
									<a class="btn btn-primary" href="<?=base_url('users/tukar-libur/add');?>" role="button">
										+ Buat Baru
									</a>
								</div>
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
						<div class="pd-20"></div>
						<div class="pb-20">
							<table class="data-table table stripe hover nowrap">
								<thead>
									<tr>
										<th class="table-plus datatable-nosort">No</th>
										<th>NRP</th>
										<th>Nama Karyawan</th>
										<th>Jabatan</th>
										<th>Hari Libur</th>
										<th>Tukar Ke</th>
										<th>Alasan</th>
										<th>Diinput oleh</th>
										<th class="datatable-nosort">Action</th>
									</tr>
								</thead>
								<tbody>
                                    <?php
                                    if($dtrow->num_rows() >0){
                                        $no=1;
                                        foreach($dtrow->result() as $val):
										$id = $val->id_dtl;
                                        $nrp = $val->nrp;
                                        $row = $this->db->query("SELECT nrp,nama,jabatan FROM data_karyawan WHERE nrp='$nrp'")->row_array();
										$nama = $row['nama'];
                                        $hl_asli = $val->hari_libur_asli;
										$x_asli = explode('-', $val->tgl_libur_asli);
										$tgl_asli = $x_asli[2].' '.$bln[$x_asli[1]].' '.$x_asli[0];
										$_libur_asli = $hl_asli.", ".$tgl_asli;

										$hl_tukar = $val->hari_libur;
										$x_tukar = explode('-', $val->tgl_libur);
										$tgl_tukar = $x_tukar[2].' '.$bln[$x_tukar[1]].' '.$x_tukar[0];
										$_libur_tukar = $hl_tukar.", ".$tgl_tukar;
										$acc = $val->acc_hrd;
                                    ?>
                                    <tr>
                                        <td><?=$no;?></td>
                                        <td><?=$nrp;?></td>
                                        <td><?=$nama;?></td>
                                        <td><?=$row['jabatan'];?></td>
                                        <td><?=$_libur_asli;?></td>
                                        <td><?=$_libur_tukar;?></td>
										<td><?=$val->alasan;?></td>
										<td><?=$val->yg_input;?></td>
										<td>
											<?php if($this->session->userdata('nama') == $val->yg_input OR $this->session->userdata('nama')=='Users'){ ?>
											<div class="dropdown">
                                                <a class="btn btn-link font-24 p-0 line-height-1 no-arrow dropdown-toggle" href="#" role="button" data-toggle="dropdown">
                                                            <i class="dw dw-more"></i>
                                                </a>
                                                <div class="dropdown-menu dropdown-menu-right dropdown-menu-icon-list">
                                                    <a class="dropdown-item" href="javascript:void(0);" onclick="deletethis('<?=$id;?>')">
                                                        <i class="bi bi-trash3" style="color:red;"></i> Delete
                                                    </a>
                                                </div>
                                            </div>
											<?php } else { ?>
												<div class="dropdown">
                                                <a class="btn btn-link font-24 p-0 line-height-1 no-arrow dropdown-toggle" href="#" role="button" data-toggle="dropdown">
                                                            <i class="dw dw-more"></i>
                                                </a>
                                                <div class="dropdown-menu dropdown-menu-right dropdown-menu-icon-list">
                                                    <a class="dropdown-item" href="javascript:void(0);" onclick="blockuser()">
                                                        <i class="bi bi-trash3" style="color:red;"></i> Delete
                                                    </a>
                                                </div>
                                            </div>
											<?php } ?>
										</td>
                                    </tr>
                                    <?php $no++; endforeach;
                                    } else {
                                        echo "<tr><td style='color:red;' colspan='8'>Belum ada data tukar libur.</td></tr>";
                                    }
                                    ?>
								</tbody>
							</table>
						</div>
					</div>
					<!-- Simple Datatable End -->
								
                </div>
				
			</div>
		</div>
        