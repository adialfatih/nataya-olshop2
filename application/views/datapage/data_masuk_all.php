<div class="main-container">
			<div class="pd-ltr-20 xs-pd-20-10">
				<div class="min-height-200px">
					<div class="page-header">
						<div class="row" style="display:flex;justify-content:space-between;">
							<div class="col-md-6 col-sm-12">
								<div class="title">
									<h4>Data Pemasukan Stok Gudang</h4>
								</div>
								<nav aria-label="breadcrumb" role="navigation">
									<ol class="breadcrumb">
										<li class="breadcrumb-item">
											<a href="<?=base_url('beranda');?>">Home</a>
										</li>
                                        <li class="breadcrumb-item">
											<a href="#">Stok</a>
										</li>
                                        <li class="breadcrumb-item">
											<a href="javascript:;">Masuk</a>
										</li>
										<li class="breadcrumb-item active" aria-current="page">
                                            Semua Data
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
                        ?>
					<!-- Simple Datatable start -->
					<div class="card-box mb-30">
						<div style="width:100%;display:flex;align-items:center;padding:20px;gap:10px;background:#dedede;border-radius:10px 10px 0 0;">
                            <div style="display:flex;flex-direction:column;">
								<span>Cari Berdasarkan Pengirim : </span>
								<div class="form-label" style="width:300px;">
									<!-- <div class="autoComplete_wrapper" style="width:300px;">
										<input id="autoComplete" onchange="lookData()" style="width:300px;" type="search" dir="ltr" spellcheck=false autocorrect="off" autocomplete="off" name="kodeproduk" autocapitalize="off" required>
									</div> -->
									<select name="produsen" id="autoComplete" class="form-control" style="width:300px;" onchange="lookData()">
									<option value="null">Pilih Produsen</option>
									<?php
									foreach($produsen->result() as $p){
										echo "<option value='".$p->nama_produsen."'>".$p->nama_produsen."</option>";
									}
									?>
									</select>
								</div>
							</div>
							<div style="display:flex;flex-direction:column;">
								<span>Tampilkan Tanggal : </span>
								<div class="form-label" style="width:300px;">
									<input class="form-control"id="thisTegel" type="date" onchange="lookData()">
								</div>
							</div>
                        </div>
						<div class="pd-20 table-responsive">
							<p id="paragraphShow">Menampilkan data masuk tanggal <?=date('d M Y', strtotime(date('Y-m-d')));?></p>
                            <table class="data-table table stripe hover nowrap" id="table1">
								<thead>
									<tr>
                                        <th>NO</th>
                                        <th>SJ</th>
										<th>PENGIRIM</th>
										<th>TANGGAL DITERIMA</th>
										<th>JUMLAH DITERIMA</th>
										<th>TOTAL HARGA</th>
										<th>DITERIMA OLEH</th>
                                        <th>#</th>
									</tr>
								</thead>
								<tbody id="tableBody">
                                    <tr>
										<td colspan="7">Loading data....</td>
									</tr>
								</tbody>
							</table>
						</div>
					</div>
                    <!-- tampilan jika pengiriman keluar -->
                    
					<!-- Simple Datatable End -->
                                
                </div>
				
			</div>
		</div>