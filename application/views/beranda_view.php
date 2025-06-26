<div class="main-container">
			<div class="pd-ltr-20">
				
				<div class="title pb-20">
					<h2 class="h3 mb-0">System Overview</h2>
				</div>

				<div class="row pb-10">
					<div class="col-xl-3 col-lg-3 col-md-6 mb-20">
						<div class="card-box height-100-p widget-style3">
							<a href="<?=base_url('cash-flow');?>">
							<div class="d-flex flex-wrap">
								<div class="widget-data">
									<div class="weight-700 font-24 text-dark"><?=number_format($saldo,0,',','.');?></div>
									<div class="font-14 text-secondary weight-500">
										Saldo
									</div>
								</div>
								<div class="widget-icon">
									<div class="icon" data-color="#00eccf">
										<i class="icon-copy bi bi-credit-card"></i>
									</div>
								</div>
							</div>
							</a>
						</div>
					</div>
					<div class="col-xl-3 col-lg-3 col-md-6 mb-20">
						<div class="card-box height-100-p widget-style3">
							<a href="<?=base_url('data/karyawan');?>">
							<div class="d-flex flex-wrap">
								<div class="widget-data">
									<div class="weight-700 font-24 text-dark">0</div>
									<div class="font-14 text-secondary weight-500">
										Karyawan Aktif
									</div>
								</div>
								<div class="widget-icon">
									<div class="icon" data-color="#ffffff">
										<span class="icon-copy bi bi-people"></span>
									</div>
								</div>
							</div>
							</a>
						</div>
					</div>
					<div class="col-xl-3 col-lg-3 col-md-6 mb-20">
						<div class="card-box height-100-p widget-style3">
							<a href="<?=base_url('data/resign');?>">
							<div class="d-flex flex-wrap">
								<div class="widget-data">
									<div class="weight-700 font-24 text-dark">0</div>
									<div class="font-14 text-secondary weight-500">
										Karyawan Resign
									</div>
								</div>
								<div class="widget-icon">
									<div class="icon" data-color="#ff5b5b">
										<span class="icon-copy bi bi-people"></span>
									</div>
								</div>
							</div>
							</a>
						</div>
					</div>
					<div class="col-xl-3 col-lg-3 col-md-6 mb-20">
						<div class="card-box height-100-p widget-style3">
							<div class="d-flex flex-wrap">
								<div class="widget-data">
									<div class="weight-700 font-24 text-dark">0</div>
									<div class="font-14 text-secondary weight-500">Notifikasi</div>
								</div>
								<div class="widget-icon">
									<div class="icon" data-color="#09cc06">
										<i class="icon-copy bi bi-app-indicator"></i>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				
				
				<div class="footer-wrap pd-20 mb-20 card-box">
					&copy; <?=$setup['tahun_pembuatan'];?> : <?=$setup['nama_client'];?>
				</div>
			</div>
		</div>