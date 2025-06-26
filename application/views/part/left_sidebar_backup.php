<?php 
$url = $this->uri->segment(1); $url2 = $this->uri->segment(2);
?>
<div class="left-side-bar">
			<div class="brand-logo">
				<a href="#">
					<img src="<?=base_url('assets/');?>2.png" alt="" class="dark-logo" />
					<img
						src="<?=base_url('assets/');?>1.png"
						alt=""
						class="light-logo"
					/>
				</a>
				<div class="close-sidebar" data-toggle="left-sidebar-close">
					<i class="ion-close-round"></i>
				</div>
			</div>
			<div class="menu-block customscroll">
				<div class="sidebar-menu">
					<ul id="accordion-menu">
						<li class="dropdown">
							<a href="<?=base_url('beranda');?>" class="dropdown-toggle no-arrow <?=$url==''?'active':'';?><?=$url=='beranda'?'active':'';?>">
								<span class="micon bi bi-house"></span
								><span class="mtext">Home</span>
							</a>
						</li>
						<li class="dropdown">
							<a href="javascript:void(0);" class="dropdown-toggle <?=$url=='data' && $url2!='libur-nasional' ?'active':'';?>">
								<span class="micon bi bi-people"></span
								><span class="mtext">Data Karyawan</span>
							</a>
							<ul class="submenu">
								<li><a href="<?=base_url('data/karyawan');?>" <?=$url2=='karyawan'?'class="active"':'';?>>Aktif</a></li>
								<li><a href="<?=base_url('data/resign');?>" <?=$url2=='resign'?'class="active"':'';?>>Resign</a></li>
								<li><a href="<?=base_url('data/mutasi');?>" <?=$url2=='mutasi'?'class="active"':'';?>>Mutasi/Promosi</a></li>
								<li><a href="<?=base_url('data/libur');?>" <?=$url2=='libur'?'class="active"':'';?>>Libur Karyawan</a></li>
								<li><a href="<?=base_url('data/tukar-libur');?>" <?=$url2=='tukar-libur'?'class="active"':'';?>>Tukar Libur</a></li>
							</ul>
						</li>
						<li class="dropdown">
							<a href="javascript:void(0);" class="dropdown-toggle <?=$url=='absensi'?'active':'';?>">
								<span class="micon bi bi-journal-check"></span
								><span class="mtext">Data Absensi</span>
							</a>
							<ul class="submenu">
								<li><a href="<?=base_url('absensi');?>" <?=$url=='absensi' && $url2==''?'class="active"':'';?>>Absensi</a></li>
								<li><a href="<?=base_url('absensi/lembur');?>" <?=$url2=='lembur'?'class="active"':'';?>>Lembur</a></li>
								<li><a href="<?=base_url('absensi/security');?>" <?=$url2=='security'?'class="active"':'';?>>Security</a></li>
								<li><a href="<?=base_url('absensi/istirahat');?>" <?=$url2=='istirahat'?'class="active"':'';?>>Istirahat</a></li>
								<li><a href="<?=base_url('absensi/terlambat');?>" <?=$url2=='terlambat'?'class="active"':'';?>>Data Terlambat</a></li>
								<li><a href="<?=base_url('absensi/rekap');?>" <?=$url2=='rekap'?'class="active"':'';?><?=$url2=='detail'?'class="active"':'';?>>Rekap Absen</a></li>
							</ul>
						</li>
						<li>
							<a href="<?=base_url('cuti-karyawan');?>" class="dropdown-toggle no-arrow <?=$url=='cuti-karyawan' ?'active':'';?><?=$url=='buat-data-cuti' ?'active':'';?>">
								<span class="micon bi bi-calendar2-week"></span
								><span class="mtext">Cuti Karyawan</span>
							</a>
						</li>
						<li>
							<a href="<?=base_url('data/libur-nasional');?>" class="dropdown-toggle no-arrow <?=$url=='data' && $url2=='libur-nasional'?'active':'';?>">
								<span class="micon bi bi-calendar-day"></span
								><span class="mtext">Libur Nasional</span>
							</a>
						</li>
						<li>
							<a href="<?=base_url('data-pkwt');?>" class="dropdown-toggle no-arrow <?=$url=='data-pkwt'?'active':'';?><?=$url=='buat-pkwt-baru'?'active':'';?>">
								<span class="micon bi bi-file-text"></span
								><span class="mtext">PKWT</span>
							</a>
						</li>
						<li>
							<a href="<?=base_url('data-pkwtp');?>" class="dropdown-toggle no-arrow <?=$url=='data-pkwtp'?'active':'';?><?=$url=='buat-pkwtp-baru'?'active':'';?>">
								<span class="micon bi bi-file-x"></span
								><span class="mtext">SPKWTP</span>
							</a>
						</li>
						<li class="dropdown">
							<a href="javascript:void(0);" class="dropdown-toggle <?=$url=='data-mesin'?'active':'';?><?=$url=='manage-data'?'active':'';?><?=$url=='data-finger'?'active':'';?>">
								<span class="micon bi bi-fingerprint"></span
								><span class="mtext">Finger Print</span>
							</a>
							<ul class="submenu">
								<li><a href="<?=base_url('data-finger');?>" <?=$url=='data-finger'?'class="active"':'';?>>Rekam Jari</a></li>
								<li><a href="<?=base_url('manage-data');?>" <?=$url=='manage-data'?'class="active"':'';?>>Kelola Data</a></li>
								<li><a href="<?=base_url('data-mesin');?>" <?=$url=='data-mesin'?'class="active"':'';?>>Data Mesin</a></li>
							</ul>
						</li>
						<li>
							<a href="<?=base_url('akses-users');?>" class="dropdown-toggle no-arrow <?=$url=='akses-users'?'active':'';?>">
								<span class="micon fa fa-user-circle"></span
								><span class="mtext">User Akses</span>
							</a>
						</li>
                        <li>
							<a href="<?=base_url('login');?>" class="dropdown-toggle no-arrow">
								<span class="micon dw dw-logout1"></span
								><span class="mtext">Logout</span>
							</a>
						</li>
					</ul>
				</div>
			</div>
		</div>
		<div class="mobile-menu-overlay"></div>