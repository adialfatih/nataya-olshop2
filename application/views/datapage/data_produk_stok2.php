<div class="main-container">
			<div class="pd-ltr-20 xs-pd-20-10">
				<div class="min-height-200px">
					<div class="page-header">
						<div class="row" style="display:flex;justify-content:space-between;">
							<div class="col-md-6 col-sm-12">
								<div class="title">
									<h4>Menampilkan Data Stok Produk</h4>
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
                                            Stok Produk
										</li>
                                        <li class="breadcrumb-item" id="idShowKategori" aria-current="page">
                                            <?=ucwords($nama_kat);?>
										</li>
									</ol>
								</nav>
							</div>
                            <div style="display:flex;align-items:center;gap:10px;margin-right:15px;">
                                <?php if($kat->num_rows() > 0){?>
                                <div class="dropdown">
                                    <a class="btn btn-primary dropdown-toggle" href="javascript:void(0);" role="button" data-toggle="dropdown">
                                        Kategori Produk
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        <?php 
                                        foreach($kat->result() as $g){
                                            $_idkat = $g->id_kat;
                                            ?><a class="dropdown-item" style="color:#0957d6;" href="<?=base_url('product/data-stok/'.$_idkat);?>"><?=$g->kategori;?></a><?php
                                        }
                                        ?>
                                    </div>
                                </div>
                                <?php } ?>
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
                            //echo $sess_akses;
                        ?>
                    
					<!-- Simple Datatable start -->
					<div class="card-box mb-30">
                        <?php
                        $im=array();
                        foreach($produk->result() as $dd){
                            //echo $dd->id_produk.",";
                            $im[]=$dd->id_produk;
                        }
                        $imp = implode(",", $im);
                        //echo $imp;
                        ?>
						<div class="pd-20 table-responsive">
                            <table class="data-table table stripe hover nowrap">
								<thead>
									<tr>
										<th class="table-plus datatable-nosort">No</th>
										<th>Kode Produk</th>
										<th>Nama Produk</th>
										<th>Model / Warna</th>
										<th>Ukuran</th>
										<th>Jumlah</th>
									</tr>
								</thead>
								<tbody id="bodyTable2">
                                    <?php
                                    $dbs = $this->db->query("SELECT * FROM data_produk_detil WHERE id_produk IN ($imp) ORDER BY nama_produk ASC");
                                    $no=1;
                                    foreach($dbs->result() as $val){
                                    $id = $val->id_produkdetil;
                                    $nm = $val->nama_produk;
                                    $mdl = $val->warna_model;
                                    $kode = $val->kode_bar1;
                                    $jml_stok = $this->db->query("SELECT kode_bar1 FROM data_produk_stok WHERE kode_bar1 = '$kode'")->num_rows();
                                    echo "<tr>";
                                    echo "<td>".$no++."</td>";
                                    if($val->kode_bar1==""){
                                        echo "<td>";
                                        ?><a href="javascript:;" onclick="changeKode('<?=$id;?>','<?=$nm;?>','<?=$mdl;?>','<?=$kode;?>')" style="color:red;" data-toggle="modal" data-target="#modals">NULL</a><?php
                                        echo "</td>";
                                    } else {
                                        echo "<td>";
                                        ?><a href="javascript:;" onclick="changeKode('<?=$id;?>','<?=$nm;?>','<?=$mdl;?>','<?=$kode;?>')" style="color:#000;" data-toggle="modal" data-target="#modals"><?=$val->kode_bar1?></a><?php
                                        echo "</td>";
                                    }
                                    echo "<td>".$nm."</td>";
                                    echo "<td>".$mdl."</td>";
                                    echo "<td>".$val->ukuran."</td>";
                                    echo "<td>".number_format($jml_stok, 0, ",", ".")."</td>";
                                    echo "</tr>";
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
													UBAH KODE
												</h4>
												<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
													×
												</button>
											</div>
                                            <form action="<?=base_url('update-kode');?>" method="post">
                                            <input type="hidden" name="idtipe" value="0" id="idtipe">
											<div class="modal-body" id="modalBodyid">
                                                <label for="produkmodel">PRODUK MODEL</label>
                                                <input type="text" id="produkmodel" name="produkmodel" class="form-control" required>
                                                <label for="nilai">Kode</label>
                                                <input type="text" id="nilai" name="nilai" class="form-control" placeholder="Masukan Kode Barang" required>
                                                <input type="hidden" id="id_produkdetil" name="idid" value="0">
                                            </div>
											<div class="modal-footer">
												<button type="button" class="btn btn-default" data-dismiss="modal">
													Close
												</button>
                                                <button type="submit" class="btn btn-primary">
													Update Kode
												</button>
											</div>
                                            </form>
										</div>
									</div>
								</div>
                </div>
				
			</div>
		</div>
<script>
    function changeKode(id,nm,mdl,kode){
        document.getElementById('produkmodel').value = ''+nm+' - '+mdl;
        document.getElementById('nilai').value = ''+kode;
        document.getElementById('id_produkdetil').value = ''+id;
    }
</script>