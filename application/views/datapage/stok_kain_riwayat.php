<div class="main-container">
			<div class="pd-ltr-20 xs-pd-20-10">
				<div class="min-height-200px">
					<div class="page-header">
						<div class="row" style="display:flex;justify-content:space-between;">
							<div class="col-md-6 col-sm-12">
								<div class="title">
									<h4>Management Data Stok Kain</h4>
								</div>
								<nav aria-label="breadcrumb" role="navigation">
									<ol class="breadcrumb">
										<li class="breadcrumb-item">
											<a href="<?=base_url('beranda');?>">Home</a>
										</li>
                                        <li class="breadcrumb-item">
											<a href="<?=base_url('data-kain');?>">Data</a>
										</li>
                                        <li class="breadcrumb-item">
											<a href="javascript:;">Riwayat</a>
										</li>
										<li class="breadcrumb-item active" aria-current="page">
                                            <?=$input;?>
										</li>
									</ol>
								</nav>
							</div>
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
                    if($input=="Kain Masuk"){ ?>
					<!-- Simple Datatable start -->
					<div class="card-box mb-30">
						<div class="pd-20 table-responsive">
                            <table class="data-table table stripe hover nowrap">
								<thead>
									<tr>
                                        <th>No</th>
										<th>Surat Jalan</th>
										<th>Tanggal</th>
										<th>Jenis Kain</th>
										<th>Total Panjang</th>
										<th>Satuan</th>
										<th>Jumlah Roll</th>
										<th>Supplier</th>
										<th class="datatable-nosort">Action</th>
									</tr>
								</thead>
								<tbody>
                                    <?php
                                    if($record->num_rows() > 0){
                                        $no=1;
                                        foreach($record->result() as $row):
                                        $id = $row->id_kain;
                                        $codeinput = $row->codeinput;
                                        $tanggal_masuk = $row->tgl_masuk;
                                        $orderTgl = date('Y-m-d', strtotime($tanggal_masuk));
                                        $date = new DateTime($tanggal_masuk);
                                        $formatted_date = $date->format('d M Y');
                                        $dt = $this->data_model->get_byid('data_kain', ['id_kain'=>$id])->row_array();
                                        $nama_kain = $dt['nama_kain'];
                                        $satuan = $dt['satuan'];
                                        if (floor($row->total_panjang) != $row->total_panjang) {
                                            $frt = number_format($row->total_panjang, 2, ',', '.');
                                        } else {
                                            $frt = number_format($row->total_panjang, 0, ',', '.');
                                        }
                                    ?>
                                    <tr>
                                        <td><?=$no++;?></td>
                                        <td><?=$row->surat_jalan;?></td>
                                        <td data-order="<?=$orderTgl;?>"><?=$formatted_date;?></td>
                                        <td><?=$nama_kain;?></td>
                                        <td><?=$frt;?></td>
                                        <td><?=$satuan;?></td>
                                        <td><?=$row->jumlah_roll;?></td>
                                        <td><?=$row->supplier;?></td>
                                        <td>
                                            <div class="dropdown">
                                                <a class="btn btn-link font-24 p-0 line-height-1 no-arrow dropdown-toggle" href="#" role="button" data-toggle="dropdown">
                                                    <i class="dw dw-more"></i>
                                                </a>
                                                <div class="dropdown-menu dropdown-menu-right dropdown-menu-icon-list">
                                                    <?php if($this->uri->segment(2) == "masuk") { ?>
                                                    <a class="dropdown-item" href="<?=base_url('data-kain/id/'.$codeinput);?>"><i class="bi bi-list-check"></i> Detail Penerimaan</a>
                                                    <?php } ?>
                                                    <a class="dropdown-item" href="javascript:void(0);" onclick="showData('in','<?=$codeinput;?>')" data-toggle="modal" data-target="#view-bigmodals"><i class="dw dw-eye"></i> View</a>
                                                    <a class="dropdown-item" href="javascript:void(0);" onclick="cahnge('<?=$codeinput;?>','<?=$nama_kain;?>','<?=$formatted_date;?>')" data-toggle="modal" data-target="#Medium-modal"><i class="bi bi-trash" style="color:red;"></i> Hapus</a>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                            <?php
                                        endforeach;
                                    } else {
                                        echo "<tr><td colspan='9'>Tidak ada data kain masuk</td></tr>";
                                    }
                                    ?>
									
								</tbody>
							</table>
						</div>
					</div>
                    <!-- tampilan jika pengiriman keluar -->
                    <?php } else { ?>
                        <div class="card-box mb-30">
						<div class="pd-20 table-responsive">
                            <table class="data-table table stripe hover nowrap">
								<thead>
									<tr>
                                        <th>No</th>
										<th>Produsen</th>
										<th>Tanggal</th>
										<th>Jenis Kain</th>
										<th>Total Panjang</th>
										<th>Roll</th>
										<th class="datatable-nosort">Action</th>
									</tr>
								</thead>
								<tbody>
                                    <?php
                                    if($record->num_rows() > 0){
                                        $no=1;
                                        foreach($record->result() as $row):
                                        $id = $row->id_kain;
                                        $id_produsen = $row->id_produsen;
                                        $dt2 = $this->data_model->get_byid('data_produsen', ['id_produsen'=>$id_produsen])->row_array();
                                        $codeinput = $row->codeinput;
                                        $tanggal_masuk = $row->tgl_kirim;
                                        $date = new DateTime($tanggal_masuk);
                                        $formatted_date = $date->format('d M Y');
                                        $dt = $this->data_model->get_byid('data_kain', ['id_kain'=>$id])->row_array();
                                        $nama_kain = $dt['nama_kain'];
                                        $satuan = $dt['satuan'];
                                        $nama_produsen = $dt2['nama_produsen'];
                                        $total_panjang = number_format($row->total_panjang,0, '', '.');
                                    ?>
                                    <tr>
                                        <td><?=$no++;?></td>
                                        <td><?=$nama_produsen;?></td>
                                        <td><?=$formatted_date;?></td>
                                        <td><?=$nama_kain;?></td>
                                        <td><?=$row->panjang_kirim.' '.$satuan;?></td>
                                        <td><?=$row->jumlah_roll;?></td>
                                        <td>
                                            <div class="dropdown">
                                                <a class="btn btn-link font-24 p-0 line-height-1 no-arrow dropdown-toggle" href="#" role="button" data-toggle="dropdown">
                                                    <i class="dw dw-more"></i>
                                                </a>
                                                <div class="dropdown-menu dropdown-menu-right dropdown-menu-icon-list">
                                                    <a class="dropdown-item" href="<?=base_url('data-kain/kirim/id/'.$codeinput);?>"><i class="dw dw-eye"></i> View</a>
                                                    
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                            <?php
                                        endforeach;
                                    } else {
                                        echo "<tr><td colspan='9'>Tidak ada data kain masuk</td></tr>";
                                    }
                                    ?>
									
								</tbody>
							</table>
						</div>
					</div>
                    <?php } ?>
					<!-- Simple Datatable End -->
                                <div class="modal fade" id="Medium-modal" tabindex="-1" role="dialog"  aria-labelledby="myLargeModalLabel" aria-hidden="true">
									<div class="modal-dialog modal-dialog-centered">
										<div class="modal-content">
											<div class="modal-header">
												<h4 class="modal-title" id="myLargeModalLabel">
													Hapus Data ?
												</h4>
												<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
											</div>
                                            <form action="<?=base_url('proses-hapuskain-in'); ?>" method="post">
                                            <input type="hidden" value="0" id="id_kaintoDel" name="idkain">
											<div class="modal-body" id="modalBodyid23">
											</div>
											<div class="modal-footer">
												<button type="button" class="btn btn-secondary" data-dismiss="modal">
													Batal
												</button>
												<button type="submit" class="btn btn-danger">
													Lanjutkan Hapus
												</button>
											</div>
                                            </form>
										</div>
									</div>
								</div>
                                <div class="modal fade bs-example-modal-lg" id="view-bigmodals" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
									<div class="modal-dialog modal-lg modal-dialog-centered">
										<div class="modal-content">
											<div class="modal-header">
												<h4 class="modal-title" id="myLargeModalLabel23">
													Large modal
												</h4>
												<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
													×
												</button>
											</div>
											<div class="modal-body" id="mdbody2245"></div>
											<!-- <div class="modal-footer">
												<button type="button" class="btn btn-secondary" data-dismiss="modal">
													Close
												</button>
												<button type="button" class="btn btn-primary">
													Save changes
												</button>
											</div> -->
										</div>
									</div>
								</div>
                </div>
				
			</div>
		</div>
<script>
    function cahnge(id,namaKain,tgl){
        document.getElementById("id_kaintoDel").value = ''+id;
        document.getElementById("modalBodyid23").innerHTML = '<p>Proses ini akan menghapus riwayat masuk kain serta tagihan pembelian kain <strong>'+namaKain+'</strong> tanggal <strong>'+tgl+'</strong>.<br>&nbsp;<br>Proses ini juga akan mengurangi stok kain <strong>'+namaKain+'</strong> di gudang  ?</p>';
    }
</script>