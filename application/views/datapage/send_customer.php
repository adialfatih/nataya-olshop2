<div class="main-container">
			<div class="pd-ltr-20 xs-pd-20-10">
				<div class="min-height-200px">
					<div class="page-header">
						<div class="row" style="display:flex;justify-content:space-between;">
							<div class="col-md-6 col-sm-12">
								<div class="title">
									<h4>Kirim Produk ke Customer</h4>
								</div>
								<nav aria-label="breadcrumb" role="navigation">
									<ol class="breadcrumb">
										<li class="breadcrumb-item">
											<a href="<?=base_url('beranda');?>">Home</a>
										</li>
                                        <li class="breadcrumb-item">
											<a href="#">Kirim</a>
										</li>
                                        <?php if($send_code1 == "null"){ ?>
                                        <li class="breadcrumb-item">
											<a href="javascript:;">Stok</a>
										</li>
										<li class="breadcrumb-item active" aria-current="page">
                                            Customer
										</li>
                                        <?php } else { ?>
                                        <li class="breadcrumb-item">
											<a href="javascript:;">Customer</a>
										</li>
										<li class="breadcrumb-item active" aria-current="page">
                                            <?=$send_code1['nama_tujuan'];?>
										</li>
                                        <?php } ?>
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
                            if($send_code1 == "null"){
                            $sendcode = $this->data_model->kodeBayar(10);
                            } else {
                            $sendcode = $send_code1['send_code'];
                            }
                        ?>
					<!-- Simple Datatable start -->
					<div class="card-box mb-30 pd-20">
                        <div class="form-group row">
                            <label class="col-sm-12 col-md-2 col-form-label">Nama Customer</label>
                            <div class="col-sm-12 col-md-10">
                                <?php if($send_code1 == "null"){ ?>
                                <input type="text" list="namacus" id="namaCustomer" class="form-control" placeholder="Masukan Nama Customer" style="max-width:350px;">
                                <datalist id="namacus">
                                        <?php $qr=$this->db->query("SELECT DISTINCT nama_tujuan FROM stok_produk_keluar WHERE tujuan='Customer' ORDER BY nama_tujuan ASC"); foreach($qr->result() as $row){ echo "<option value='".$row->nama_tujuan."'>"; } ?>
                                </datalist>
                                <?php } else { ?>
                                <input type="text" id="namaCustomer" class="form-control" value="<?=$send_code1['nama_tujuan'];?>" placeholder="Masukan Nama Customer" style="max-width:350px;">
                                <?php } ?>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-12 col-md-2 col-form-label">Tanggal Kirim</label>
                            <div class="col-sm-12 col-md-4">
                                <?php if($send_code1 == "null"){ ?>
                                <input class="form-control date-picker" id="tglKirim" placeholder="Pilih Tanggal" type="text">
                                <?php } else { ?>
                                <input class="form-control date-picker" id="tglKirim" value="<?=date("d F Y", strtotime($send_code1['tgl_out']));?>" placeholder="Pilih Tanggal" type="text">
                                <?php } ?>
                            </div>
                        </div>
                        <input type="hidden" value="<?=$sendcode;?>" id="sendCode" name="sendcode" required>
                        <input type="hidden" value="Customer" id="tujuanKirim" name="tujuankirim" required>
                        <div class="form-group row">
                            <label class="col-sm-12 col-md-2 col-form-label">Status Pembayaran</label>
                            <div class="col-sm-12 col-md-6">
                                <select class="custom-select col-sm-4" id="statusBayar">
                                    <option value="Lunas" selected>Lunas</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-12 col-md-2 col-form-label">Jumlah Pembayaran</label>
                            <div class="col-sm-12 col-md-4">
                                <?php if($send_code1 == "null"){ ?>
                                <input type="text" id="angkaBayar" value="0" oninput="formatAngka(this)" class="form-control" placeholder="Masukan Jumlah Pembayaran" readonly>
                                <?php } else { ?>
                                <input type="text" id="angkaBayar" value="<?=number_format($send_code1['nilai_tagihan'],0,".",".");?>" oninput="formatAngka(this)" class="form-control" placeholder="Masukan Jumlah Pembayaran" readonly>
                                <?php } ?>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-12 col-md-2 col-form-label">Keterangan</label>
                            <div class="col-sm-6 col-md-6">
                                <?php if($send_code1 == "null"){ ?>
                                <textarea class="form-control" id="kete" style="height:100px;" placeholder="Masukan Keterangan"></textarea>
                                <?php } else { ?>
                                <textarea class="form-control" id="kete" style="height:100px;" placeholder="Masukan Keterangan"><?=$send_code1['ket'];?></textarea>
                                <?php } ?>
                            </div>
                        </div>
                        <div id="oiwek"></div>
                        <div class="table-responsive" style="min-height:400px;">
                            <span>Data Pengiriman Produk : </span>
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Kode</th>
                                        <th>Produk</th>
                                        <th>Jumlah Kirim</th>
                                        <th>Total Harga</th>
                                        <th>Hapus</th>
                                    </tr>
                                </thead>
                                <tbody id="loadTampilkanTable"></tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="3">
                                            <div class="form-label" style="200px;">
                                                <div class="autoComplete_wrapper" style="width:100%;">
                                                    <input id="autoComplete" type="search" dir="ltr" spellcheck=false autocorrect="off" autocomplete="off" name="codekain" autocapitalize="off" required>
                                                </div>
                                            </div>
                                            <small id="notifStok"></small>
                                        </td>
                                        <td>
                                            <input type="text" id="jumlahProdukKirim" oninput="formatAngka(this)" class="form-control" placeholder="Masukan jumlah">
                                        </td>
                                        <td>0</td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td colspan="6">
                                            <button type="submit" class="btn btn-success" id="addProdukCustomer">+ Tambah Produk</button>
                                            <?php if($send_code1 == "null"){} else { ?>
                                            <button type="button" class="btn btn-primary" id="btnSimpan23">Simpan</button> <?php } ?>
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                        
					</div>
                    <!-- tampilan jika pengiriman keluar -->
                                
                </div>
				
			</div>
		</div>