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
						<!-- <li>
							<a href="" class="dropdown-toggle no-arrow ">
								<span class="micon bi bi-arrow-down-up"></span
								><span class="mtext">Cash Flow</span>
							</a>
						</li> -->
						
						<li class="dropdown">
							<a href="javascript:;" class="dropdown-toggle <?=$url=='data-kain'?'active':'';?>">
								<span class="micon dw dw-sheet"></span
								><span class="mtext">Kain</span>
							</a>
							<ul class="submenu">
								<li><a href="<?=base_url('data-kain');?>" class="<?=$url=='data-kain' && $url2=='' ? 'active':'';?>">Data Kain</a></li>
								<li><a href="<?=base_url('data-kain/masuk');?>" class="<?=$url=='data-kain' && $url2=='masuk' ? 'active':'';?>">Kain Masuk</a></li>
								<li><a href="<?=base_url('data-kain/pengiriman');?>" class="<?=$url=='data-kain' && $url2=='pengiriman' ? 'active':'';?>">Kain Keluar</a></li>
							</ul>
						</li>
						
						<li class="dropdown">
							<a href="javascript:;" class="dropdown-toggle">
								<span class="micon ti-dropbox"></span
								><span class="mtext">Data Stok</span>
							</a>
							<ul class="submenu">
								<li><a href="<?=base_url('data-stok/toko');?>" class="<?=$url=='data-stok' && $url2=='toko' ?'active':'';?>">Stok TOKO</a></li>
								<li><a href="<?=base_url('data-stok/gudang');?>" class="<?=$url=='data-stok' && $url2=='gudang' ?'active':'';?>">Stok GUDANG</a></li>
								<li><a href="<?=base_url('data-stok/masuk');?>" class="<?=$url=='data-stok' && $url2=='masuk' ?'active':'';?>">Stok Masuk</a></li>
								<li><a href="<?=base_url('data-stok/keluar');?>" class="<?=$url=='data-stok' && $url2=='keluar' ?'active':'';?>">Stok Keluar</a></li>
								<li><a href="<?=base_url('data-stok/mutasi');?>" <?=$url=='mutasi' ?'class="active"':'';?><?=$url=='data-stok' && $url2=='mutasi' ?'class="active"':'';?>>Mutasi Stok</a></li>
							</ul>
						</li>
						<li class="dropdown">
							<a href="javascript:;" class="dropdown-toggle <?=$url=='cash-flow'?'active':'';?>">
								<span class="micon bi bi-arrow-down-up"></span
								><span class="mtext">Cash Flow</span>
							</a>
							<ul class="submenu">
								<li><a href="<?=base_url('cash-flow');?>" class="<?=$url=='cash-flow'?'active':'';?>">Keuangan</a></li>
								<li><a href="<?=base_url('tagihan');?>" class="<?=$url=='tagihan' ? 'active':'';?>">Tagihan</a></li>
								<li><a href="<?=base_url('piutang');?>" class="<?=$url=='piutang' ? 'active':'';?>">Piutang</a></li>
							</ul>
						</li>
						<!-- <li>
							<a href="<=base_url('data-kain');?>" class="dropdown-toggle no-arrow <=$url=='data-kain'?'active':'';?>">
								<span class="micon dw dw-sheet"></span
								><span class="mtext">Data Kain</span>
							</a>
						</li> -->
						<li class="dropdown">
							<a href="javascript:;" class="dropdown-toggle <?=$url=='product'?'active':'';?>">
								<span class="micon dw dw-tag"></span
								><span class="mtext">Produk</span>
							</a>
							<ul class="submenu">
								<li><a href="<?=base_url('product/data-stok');?>" class="<?=$url2=='data-stok'?'active':'';?>">Stok Produk</a></li>
								<li><a href="<?=base_url('produk/data-stok-in');?>" class="<?=$url2=='data-stok-in'?'active':'';?>">Stok Masuk</a></li>
								<li><a href="<?=base_url('produk/data-stok-out');?>" class="<?=$url2=='data-stok-out'?'active':'';?>">Stok Keluar</a></li>
								<li><a href="<?=base_url('product');?>" class="<?=$url2=='' && $url=='product' ?'active':'';?>">Data Produk</a></li>
							</ul>
						</li>
						
						<li>
							<a href="<?=base_url('produksi');?>" class="dropdown-toggle no-arrow <?=$url=='produksi'?'active':'';?>">
								<span class="micon bi bi-building"></span
								><span class="mtext">Produksi</span>
							</a>
						</li>
						<li>
							<a href="<?=base_url('distributor');?>" class="dropdown-toggle no-arrow <?=$url=='distributor'?'active':'';?>">
								<span class="micon bi bi-diagram-3"></span
								><span class="mtext">Distributor</span>
							</a>
						</li>
						<li>
							<a href="<?=base_url('reseller');?>" class="dropdown-toggle no-arrow <?=$url=='reseller'?'active':'';?>">
								<span class="micon bi bi-person-check-fill"></span
								><span class="mtext">Reseller</span>
							</a>
						</li>
						<!-- <li>
							<a href="<=base_url('bot');?>" class="dropdown-toggle no-arrow <=$url=='bot'?'active':'';?>">
								<span class="micon ion-social-whatsapp-outline"></span
								><span class="mtext">BOT WhatsApp</span>
							</a>
							
						</li> -->
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