<div class="main-container">
			<div class="pd-ltr-20 xs-pd-20-10">
				<div class="min-height-200px">
					<div class="page-header">
						<div class="row">
							<div class="col-md-6 col-sm-12">
								<div class="title">
									<h4>Menampilkan Data Reseller</h4>
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
                                            Reseller
										</li>
									</ol>
								</nav>
							</div>
                            <?php if($sess_akses=="Super"){?>
							<div class="col-md-6 col-sm-12 text-right">
								<a class="btn btn-success" href="javascript:void(0);" onclick="changeadd()" role="button" data-toggle="modal" data-target="#modals">
										+ Tambah Reseller
								</a>
                                <a class="btn btn-warning" href="javascript:void(0);" data-toggle="modal" data-target="#modals2311">
										Rekap Setoran
								</a>
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
										<th>Nama Reseller</th>
										<th>Nota Belum Dibayar</th>
										<th>Total Hutang</th>
										<th>Pembayaran</th>
										<th>Sisa Hutang</th>
										<th class="datatable-nosort">Action</th>
									</tr>
								</thead>
								<tbody>
                                    <?php
                                    if($dist->num_rows() > 0){
                                        $no=1;
                                        foreach($dist->result() as $val){
                                        $id = $val->id_res;
                                        $id2 = intval($id) + 98761;
                                        $id3 = sha1($id);
                                        $teksToCopy = "".base_url()."reseller/data/tagihan/".$id3."";
                                        $nm = $val->nama_reseller;
                                        $cn = $this->db->query("SELECT COUNT(id_outstok) AS jml FROM stok_produk_keluar WHERE nama_tujuan='$nm' AND tujuan='Reseller' AND status_lunas='Belum Lunas'")->row("jml");

                                        $jml = $this->db->query("SELECT SUM(nilai_tagihan) AS jml FROM stok_produk_keluar WHERE nama_tujuan='$nm' AND tujuan='Reseller'")->row("jml");


                                        //$jml = $this->db->query("SELECT SUM(nominal_hutang) AS jml FROM hutang_reseller WHERE id_res='$id'")->row("jml");

                                        $jmlbyr = $this->db->query("SELECT SUM(nominal) AS jml FROM hutang_reseller_bayar WHERE id_res='$id'")->row("jml");
                                        $sisa = intval($jml) - intval($jmlbyr);
                                    ?>
                                    <tr>
                                        <td><?=$no;?></td>
                                        <td><?=$nm;?></td>
                                        <td>
                                            <?php
                                            if($cn==0){ echo "Tidak Ada"; } else {
 ?>
                                            <a href="reseller/tagihan/nota/<?=$id2;?>" style="text-decoration:none;color:red;"><?=$cn;?></a>
 <?php
                                            }
                                            ?>
                                        </td>
                                        <td>Rp.<?=number_format($jml,0,",",".");?></td>
                                        <td>Rp.<?=number_format($jmlbyr,0,",",".");?></td>
                                        <td>
                                            <?php if($sisa==0){
                                                echo "<span class='badge badge-success'>Lunas</span>";
                                            } else {
                                                echo "<font style='color:red';>Rp.".number_format($sisa,0,",",".")."</font>";
                                            }
                                            ?>
                                        </td>
                                        <td>
                                            <div class="dropdown">
                                                <a class="btn btn-link font-24 p-0 line-height-1 no-arrow dropdown-toggle" href="#" role="button" data-toggle="dropdown">
                                                    <i class="dw dw-more"></i>
                                                </a>
                                                <div class="dropdown-menu dropdown-menu-right dropdown-menu-icon-list">
                                                    <a class="dropdown-item" href="javascript:void(0);" onclick="upBayar('<?=$id;?>','<?=$val->nama_reseller;?>', '<?=$cn;?>')">
                                                        <i class="bi bi-currency-exchange"></i> Input Pembayaran
                                                    </a>
                                                    <a class="dropdown-item" href="javascript:void(0);" onclick="viewBayar('<?=$id;?>','<?=$val->nama_reseller;?>')" data-toggle="modal" data-target="#modals4">
                                                        <i class="bi bi-currency-dollar"></i> Riwayat Pembayaran
                                                    </a>
                                                    <a class="dropdown-item" href="javascript:void(0);" onclick="edit('<?=$id;?>','<?=$val->nama_reseller;?>','<?=$val->notelp;?>','<?=$val->alamat;?>')" data-toggle="modal" data-target="#modals">
                                                        <i class="dw dw-edit"></i> Edit Data
                                                    </a>
                                                    <a class="dropdown-item" href="javascript:void(0);" onclick="copythis('<?=$teksToCopy;?>')">
                                                        <i class="bi bi-share"></i> Copy Link
                                                    </a>
                                                    <a class="dropdown-item" href="javascript:void(0);" onclick="del('Reseller','<?=$id;?>','<?=$val->nama_reseller;?>')">
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
                                        echo "<tr><td colspan='5'>Anda belum memiliki reseller</td></tr>";
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
													Tambah Reseller
												</h4>
												<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
													×
												</button>
											</div>
                                            <form action="<?=base_url('save-reseller');?>" method="post">
                                            <input type="hidden" name="idtipe" value="0" id="idtipe">
											<div class="modal-body" id="modalBodyid">
                                                <label for="namadistributor">Nama Reseller</label>
                                                <input type="text" id="namadistributor" name="namadistributor" class="form-control" placeholder="Masukan Nama Reseller" required>
                                                <label for="nowa">No Telepon / WA</label>
                                                <input type="number" id="nowa" name="nowa" class="form-control" placeholder="Masukan Nomor Telephon tanpa 0/62" required>
                                                <label for="almt">Alamat Reseller</label>
                                                <textarea name="almt" class="form-control" placeholder="Masukan Alamat Reseller" id="almt"></textarea>
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
                                <div class="modal fade" id="modals2" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
									<div class="modal-dialog modal-dialog-centered">
										<div class="modal-content">
											<div class="modal-header">
												<h4 class="modal-title" id="myLargeModalLabel">
													Pembayaran Reseller
												</h4>
												<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
													×
												</button>
											</div>
                                            <?php echo form_open_multipart('save-reseller-bayar'); ?>
                                            <input type="hidden" name="idReseller" value="0" id="idReseller">
											<div class="modal-body" id="modalBodyid">
                                                <label for="nmReseller">Nama Reseller</label>
                                                <input type="text" id="nmReseller" name="nmReseller" class="form-control" readonly>
                                                <!-- <label for="sjBayar" style="margin-top:10px;">Pembayaran Surat Jalan</label>
                                                <select name="sjBayar" class="form-control" id="sjBayar" onchange="cekbyrnominal(this.value)" required>
                                                    <option value="">Pilih Surat Jalan Pembayaran</option>
                                                </select> -->
                                                <label for="tglBayar" style="margin-top:10px;">Tanggal Pembayaran</label>
                                                <input type="date" id="tglBayar" name="tglBayar" class="form-control" value="<?=date('Y-m-d');?>" required>
                                                <label for="jmlBayar" style="margin-top:10px;">Jumlah Pembayaran</label>
                                                <input type="text" id="jmlBayar" oninput="formatAngka(this)" name="jmlBayar" class="form-control" placeholder="Masukan Nomor Nominal" required>
                                                <label for="jnsBayar" style="margin-top:10px;">Jenis Pembayaran</label>
                                                <select name="jnsBayar" class="form-control" id="jnsBayar">
                                                    <option value="">Pilih Jenis Pembayaran</option>
                                                    <option value="Tunai">Tunai</option>
                                                    <option value="Transfer">Transfer</option>
                                                    <option value="Virtual Account">Virtual Account</option>
                                                </select>
                                                <label for="upload" style="margin-top:10px;">Upload Bukti Pembayaran</label>
                                                <input class="form-control" name="upload" id="upload" type="file" onchange="validateFile('image')" />
                                                <small>Masukan bukti foto surat jalan. Ekstensi: JPG, PNG</small>
                                            </div>
											<div class="modal-footer">
												<button type="button" class="btn btn-default" data-dismiss="modal">
													Close
												</button>
                                                <button type="submit" class="btn btn-primary">
													Simpan Data
												</button>
											</div>
                                            <?php echo form_close(); ?>
										</div>
									</div>
								</div>
                                <div class="modal fade" id="modals4" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
									<div class="modal-dialog modal-lg modal-dialog-centered">
										<div class="modal-content">
											<div class="modal-header">
												<h4 class="modal-title" id="myLargeModalLabel21455">
													Riwayat Pembayaran Reseller
												</h4>
												<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
													×
												</button>
											</div>
											<div class="modal-body" id="modalBodyid2345">
                                                <div style="width:100%;display:flex;align-items:center;justify-content:center;"><div class="loader"></div></div>
                                            </div>
											<div class="modal-footer">
												<button type="button" class="btn btn-default" data-dismiss="modal">
													Close
												</button>
                                                
											</div>
										</div>
									</div>
								</div>
                                <!-- tampilan jika pengiriman keluar -->
                                <div class="modal fade" id="modals2311" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
									<div class="modal-dialog modal-dialog-centered">
										<div class="modal-content">
											<div class="modal-header">
												<h4 class="modal-title" id="myLargeModalLabel2311">
													Rekap Setoran Reseller
												</h4>
												<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
													×
												</button>
											</div>
                                            <?php echo form_open_multipart('rekap/setoran/reseller'); ?>
											<div class="modal-body" id="modalBodyid2311">
                                                <label for="kode_bar456">Tanggal</label>
                                                <input class="form-control" name="dates" id="kode_bar456" type="text" placeholder="Masukan tanggal rekap..." />
												
                                                <label for="ukuran244" style="margin-top:5px;">Nama</label>
                                                <input class="form-control" name="nama" id="ukuran244" type="text" placeholder="Masukan nama (opsional)" />
                                                
                                            </div>
											<div class="modal-footer">
												<button type="button" class="btn btn-default" data-dismiss="modal">
													Close
												</button>
                                                <button type="submit" class="btn btn-primary" id="tombolSubmit">
                                                    <i class="icon-copy bi bi-search"></i>&nbsp; Submit
												</button>
                                                <span class="loader" id="thisLoader" style="display:none;"></span>
											</div>
                                            <?php echo form_close(); ?>
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
        document.getElementById('namadistributor').value = '';
        document.getElementById('idtipe').value = '';
        document.getElementById('nowa').value = '';
        document.getElementById('almt').value = '';
        document.getElementById('namadistributor').value = ''+nm;
        document.getElementById('idtipe').value = ''+id;
        document.getElementById('nowa').value = ''+no;
        document.getElementById('almt').value = ''+al;
        console.log(id+'-'+nm+'-'+no+'-'+al);
    }
    
</script>