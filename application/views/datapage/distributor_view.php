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
								<a class="btn btn-success" href="javascript:void(0);" onclick="changeadd()" role="button" data-toggle="modal" data-target="#modals">
										+ Tambah Distributor
								</a>
                                <a class="btn btn-warning" href="javascript:void(0);" data-toggle="modal" data-target="#mod">
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
										<th>Nama Distributor</th>
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
                                        $_ttl_nota=0;
                                        $_ttl_htg=0;
                                        $_ttl_byr=0;
                                        $_ttl_sisa=0;
                                        foreach($dist->result() as $val){
                                        $id = $val->id_dis;
                                        $shaid = sha1($id);
                                        $nmdis = $val->nama_distributor;
                                        $nota1  = $this->db->query("SELECT COUNT(id_outstok) AS jml FROM stok_produk_keluar WHERE nama_tujuan = '$nmdis' AND tujuan='Agen' AND status_lunas = 'Belum Lunas'")->row("jml");
                                        $nota2  = $this->db->query("SELECT SUM(nilai_tagihan) AS total FROM stok_produk_keluar WHERE nama_tujuan = '$nmdis' AND tujuan='Agen'")->row("total");
                                        $bayarr  = $this->db->query("SELECT SUM(nominal_bayar) AS total FROM hutang_agen_bayar WHERE nama_agen = '$nmdis' ")->row("total");
                                        $sisa_hutang = $nota2 - $bayarr;
                                        $_ttl_nota += $nota1;
                                        $_ttl_htg += $nota2;
                                        $_ttl_byr += $bayarr;
                                        $_ttl_sisa += $sisa_hutang;
                                    ?>
                                    <tr>
                                        <td><?=$no;?></td>
                                        <td><?=$nmdis;?></td>
                                        <td><?=$nota1<1 ? '-':'<font style="color:red;">'.$nota1.'</font>';?></td>
                                        <td><?=$nota2<1 ? '-':'Rp. '.number_format($nota2,0,',','.');?></td>
                                        <td><?=$bayarr<1 ? '-':'Rp. '.number_format($bayarr,0,',','.');?></td>
                                        <td><?=$sisa_hutang<1 ? '<label class="badge badge-success" style="margin:0;">Lunas</label>':'Rp. '.number_format($sisa_hutang,0,',','.');?></td>
                                        
                                        <td>
                                            <div class="dropdown">
                                                <a class="btn btn-link font-24 p-0 line-height-1 no-arrow dropdown-toggle" href="#" role="button" data-toggle="dropdown">
                                                            <i class="dw dw-more"></i>
                                                </a>
                                                <div class="dropdown-menu dropdown-menu-right dropdown-menu-icon-list">
                                                    <a class="dropdown-item" href="<?=base_url('hutang-agen/'.$shaid.'');?>"><i class="dw dw-search"></i> View</a>
                                                    <a class="dropdown-item" href="javascript:void(0);" onclick="bayarAgen('<?=$val->nama_distributor;?>','<?=$shaid;?>')" data-toggle="modal" data-target="#modals2">
                                                        <i class="dw dw-add"></i> Input Pembayaran
                                                    </a>
                                                    <a class="dropdown-item" href="javascript:void(0);" onclick="edit('<?=$id;?>','<?=$val->nama_distributor;?>','<?=$val->notelp;?>','<?=$val->alamat;?>')" data-toggle="modal" data-target="#modals">
                                                        <i class="dw dw-edit"></i> Edit Agen
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
                                        echo "<tr>";
                                        echo "<td colspan='2'><strong>Total</strong></td>";
                                        echo "<td><strong>".$_ttl_nota."</strong></td>";
                                        echo "<td><strong>Rp. ".number_format($_ttl_htg,0,',','.')."</strong></td>";
                                        echo "<td><strong>Rp. ".number_format($_ttl_byr,0,',','.')."</strong></td>";
                                        echo "<td><strong>Rp. ".number_format($_ttl_sisa,0,',','.')."</strong></td>";
                                        echo "<td></td>";
                                        echo "</tr>";
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
                                <div class="modal fade" id="modals2" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
									<div class="modal-dialog modal-dialog-centered">
										<div class="modal-content">
											<div class="modal-header">
												<h4 class="modal-title" id="myLargeModalLabel">
													Pembayaran Agen
												</h4>
												<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
													×
												</button>
											</div>
                                            <?php echo form_open_multipart('save-agen-bayar'); ?>
                                            <input type="hidden" name="idReseller" value="0" id="idReseller">
											<div class="modal-body" id="modalBodyid">
                                                <label for="nmReseller">Nama Agem</label>
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
                                                <small>Masukan bukti / foto pembayaran. Ekstensi: JPG, PNG</small>
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
    function bayarAgen(nama,id){
        document.getElementById('idReseller').value = ''+id;
        document.getElementById('nmReseller').value = ''+nama;
    }
</script>