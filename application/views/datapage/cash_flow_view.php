<div class="main-container">
			<div class="pd-ltr-20 xs-pd-20-10">
				<div class="min-height-200px">
					<div class="page-header">
						<div class="row">
							<div class="col-md-6 col-sm-12">
								<div class="title">
									<h4>Menampilkan Data Keuangan / Cash Flow</h4>
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
                                            Cash Flow
										</li>
									</ol>
								</nav>
							</div>
                            <?php if($cash->num_rows()==0){?>
							<div class="col-md-6 col-sm-12 text-right">
								<div class="dropdown">
									<a class="btn btn-secondary" href="javascript:void(0);" role="button" data-toggle="modal" data-target="#modals">
										Buat Saldo Awal
									</a>
								</div>
							</div>
                            <?php } else { ?>
                            <div class="col-md-6 col-sm-12 text-right">
								<div class="dropdown">
									<a class="btn btn-success" href="javascript:void(0);" role="button" data-toggle="modal" data-target="#modals23">
										Input Keuangan
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
					<div class="card-box mb-30 pd-20">
                        <?php if($cash->num_rows()==0){?>
						<p>Anda perlu membuat saldo awal.!!</p>
                        <?php } else { ?>
                        <div class="pd-20 table-responsive">
							<table class="table table-bordered stripe hover nowrap">
								<thead>
									<tr>
										<th class="table-plus datatable-nosort">No</th>
										<th>IN/OUT</th>
										<th>NOMINAL</th>
										<th>TANGGAL</th>
										<th>JAM</th>
										<th>KETERANGAN</th>
										<th class="datatable-nosort">Action</th>
									</tr>
								</thead>
								<tbody id="showData"></tbody>
							</table>
						</div> 
                        <?php } ?>
					</div>
					<!-- Simple Datatable End -->
								<div class="modal fade" id="modals" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
									<div class="modal-dialog modal-dialog-centered">
										<div class="modal-content">
											<div class="modal-header">
												<h4 class="modal-title" id="myLargeModalLabel">
													Input Saldo Awal
												</h4>
												<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
													×
												</button>
											</div>
                                            <form action="<?=base_url('save-saldoawal');?>" method="post">
                                            <input type="hidden" name="idtipe" value="0" id="idtipe">
											<div class="modal-body" id="modalBodyid">
                                                <label for="tgl">Set Tanggal</label>
                                                <input type="date" id="tgl" name="tgl" class="form-control" value="<?=date('Y-m-d');?>"  required>
                                                <label for="nilai">Nominal</label>
                                                <input type="text" id="nilai" name="nilai" oninput="formatRibuan(this)" class="form-control" placeholder="0" required>
                                                <label for="ket">Keterangan</label>
                                                <textarea name="ket" class="form-control" id="ket" readonly>SALDO AWAL</textarea>
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
								<div class="modal fade" id="modals23" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
									<div class="modal-dialog modal-dialog-centered">
										<div class="modal-content">
											<div class="modal-header">
												<h4 class="modal-title" id="myLargeModalLabel">
													CATATAN KEUANGAN
												</h4>
												<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
													×
												</button>
											</div>
                                            
											<div class="modal-body" id="modalBodyid45">
												<div class="pilihan2">
													<label class="pilihanin" id="in">DANA MASUK</label>
													<label class="pilihanout" id="out">DANA KELUAR</label>
													<input type="hidden" name="idtipe" value="" id="idtipe234">
												</div>
												
                                                <label for="tgl">Tanggal</label>
                                                <input type="date" id="tgl567" name="tgl" class="form-control" value="<?=date('Y-m-d');?>"  required>
                                                <label for="nilai">Nominal</label>
                                                <input type="text" id="nilai2356" name="nilai" oninput="formatRibuan(this)" class="form-control" placeholder="0" required>
												
                                                <label for="ket">Keterangan</label>
                                                <textarea name="ket" class="form-control" style="height:100px;" id="ket24558" placeholder="Masukan Keterangan"></textarea>
                                            </div>
											<div class="modal-footer">
												<button type="button" class="btn btn-default" data-dismiss="modal">
													Close
												</button>
                                                <button type="button" class="btn btn-primary" id="simpandataflow">
													Simpan Data
												</button>
											</div></form>
										</div>
									</div>
								</div>
                                
                </div>
				
			</div>
		</div>
        <script>
            function formatRibuan(input) {
                let value = input.value.replace(/[^0-9,]/g, '');
                const split = value.split(',');
                if (split.length > 2) {
                    value = split[0] + ',' + split.slice(1).join('');
                }
                const [integerPart, decimalPart] = value.split(',');
                value = integerPart.replace(/\B(?=(\d{3})+(?!\d))/g, ".") + (decimalPart ? ',' + decimalPart : '');
                input.value = value;
            }
			const labelIn = document.getElementById("in");
			const labelOut = document.getElementById("out");
			const inputTipe = document.getElementById("idtipe234");

			// Fungsi untuk menangani klik pada DANA MASUK
			labelIn.addEventListener("click", function() {
				labelIn.classList.add("active");
				labelOut.classList.remove("active");
				inputTipe.value = "in"; // Set idtipe menjadi "in"
			});

			// Fungsi untuk menangani klik pada DANA KELUAR
			labelOut.addEventListener("click", function() {
				labelOut.classList.add("active");
				labelIn.classList.remove("active");
				inputTipe.value = "out"; // Set idtipe menjadi "out"
			});
        </script>