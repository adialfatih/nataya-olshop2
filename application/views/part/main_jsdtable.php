<script src="<?=base_url('assets/');?>vendors/scripts/core.js"></script>
		<script src="<?=base_url('assets/');?>vendors/scripts/script.min.js"></script>
		<script src="<?=base_url('assets/');?>vendors/scripts/process.js"></script>
		<script src="<?=base_url('assets/');?>vendors/scripts/layout-settings.js"></script>
		<script src="<?=base_url('assets/');?>src/plugins/datatables/js/jquery.dataTables.min.js"></script>
		<script src="<?=base_url('assets/');?>src/plugins/datatables/js/dataTables.bootstrap4.min.js"></script>
		<script src="<?=base_url('assets/');?>src/plugins/datatables/js/dataTables.responsive.min.js"></script>
		<script src="<?=base_url('assets/');?>src/plugins/datatables/js/responsive.bootstrap4.min.js"></script>
		<!-- buttons for Export datatable -->
		<script src="<?=base_url('assets/');?>src/plugins/datatables/js/dataTables.buttons.min.js"></script>
		<script src="<?=base_url('assets/');?>src/plugins/datatables/js/buttons.bootstrap4.min.js"></script>
		<script src="<?=base_url('assets/');?>src/plugins/datatables/js/buttons.print.min.js"></script>
		<script src="<?=base_url('assets/');?>src/plugins/datatables/js/buttons.html5.min.js"></script>
		<script src="<?=base_url('assets/');?>src/plugins/datatables/js/buttons.flash.min.js"></script>
		<script src="<?=base_url('assets/');?>src/plugins/datatables/js/pdfmake.min.js"></script>
		<script src="<?=base_url('assets/');?>src/plugins/datatables/js/vfs_fonts.js"></script>
		<!-- Datatable Setting js -->
		<script src="<?=base_url('assets/');?>vendors/scripts/datatable-setting.js"></script>
		<?php if($daterange == "one"){ ?>
			<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
			<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
			<script>$('input[name="dates"]').daterangepicker();</script>
		<?php } ?>
		<?php  if(!empty($autocomplet)) { 
			$ar = array();
			foreach($kode_bar->result() as $kd){
				$ds = '"'.$kd->kode_bar.'"';
				$ar[] = $ds;
			}
			$stok_im = implode(",",$ar);
			
		?>
		<script src="<?=base_url('assets2/');?>/autoComplete.min.js"></script>
			<script>
			const autoCompleteJS = new autoComplete({
                placeHolder: "Ketik kode",
                data: {
                    src: [<?=$stok_im;?>],
                    cache: true,
                },
                resultItem: {
                    highlight: true
                },
                events: {
                    input: {
                        selection: (event) => {
                            const selection = event.detail.selection.value;
                            autoCompleteJS.input.value = selection;
							//console.log('tes'+selection);
							$('#ukuran').empty();
							$('#ukuran').append('<option value="">Loading...</option>');
							$('produkmotif').html('Loading...');
                            $.ajax({
								url:"<?=base_url();?>proses2/cekkodeProduk",
								type: "POST",
								data: {"id" : selection},
									cache: false,
									success: function(dataResult){
										var dataResult = JSON.parse(dataResult);
										if(dataResult.statusCode == 200){
											console.log(''+dataResult.ukr);
											$('#ukuran').empty();
											$('#ukuran').append('<option value="">Ukuran Tersedia</option>');
											dataResult.ukr.forEach(function(item) {
												$('#ukuran').append('<option value="' + item + '">' + item + '</option>');
											});
											$('#produkmotif').html('Nama Produk :<strong>'+dataResult.produk+'</strong> Motif : <strong>'+dataResult.model+'</strong>');
										} else {
											$('#produkmotif').html('<font style="color:red;">'+dataResult.psn+'</font>');
										}
									}
							});
                        }
                    }
                }
            });
			</script>
		<?php } ?>
		<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.10.0/dist/sweetalert2.all.min.js" integrity="sha256-IW9RTty6djbi3+dyypxajC14pE6ZrP53DLfY9w40Xn4=" crossorigin="anonymous"></script>
		
		<script>
			function cariKodeUkuran(){
				const kodebar = document.getElementById('autoComplete').value;
				const ukuran = document.getElementById('ukuran').value;
				var kodebar1 = kodebar+"-"+ukuran;
				console.log(kodebar1);
				$('#jumlahkirimspan').html('Loading...');
				$.ajax({
					url:"<?=base_url();?>proses2/carijumlahstok",
					type: "POST",
					data: {"id" : kodebar1},
					cache: false,
					success: function(dataResult){
						var dataResult = JSON.parse(dataResult);
						if(dataResult.statusCode == 200){
							$('#jumlahkirimspan').html('Stok Tersedia : <strong>'+dataResult.jumlah+'</strong>');
							console.log(kodebar1);
						}
						
					}
				});
			}
			function showData(type,code){
				$('#mdbody2245').html('<div style="width:100%;height:100px;display:flex;justify-content:center;align-items:center;"><div class="loader"></div></div>');
				if(type == 'in'){
					$('#myLargeModalLabel23').html('Riwayat Kain Masuk');
					$.ajax({
						url:"<?=base_url();?>prosesajax/viewKainMasuk",
						type: "POST",
						data: {"id" : code},
							cache: false,
							success: function(dataResult){
								setTimeout(() => {
									$('#mdbody2245').html(dataResult);
								}, 1000);
							}
					});
				} else {
					$('#myLargeModalLabel23').html('Riwayat Pengiriman Kain');
					$.ajax({
						url:"<?=base_url();?>prosesajax/viewKainKeluar",
						type: "POST",
						data: {"id" : code},
							cache: false,
							success: function(dataResult){
								setTimeout(() => {
									$('#mdbody2245').html(dataResult);
								}, 1000);
							}
					});
				}
			}
			function del(tipe, id, ops){
				Swal.fire({
				title: "Hapus "+ops+"?",
				text: "Anda akan menghapus data "+tipe+"",
				icon: "warning",
				showCancelButton: true,
				confirmButtonColor: "#3085d6",
				cancelButtonColor: "#d33",
				confirmButtonText: "Yes, delete it!"
				}).then((result) => {
				if (result.isConfirmed) {
					$.ajax({
						url:"<?=base_url();?>prosesajax/deletes",
						type: "POST",
						data: {"id" : id, "tipe" : tipe},
							cache: false,
							success: function(dataResult){
								Swal.fire({
								title: "Deleted!",
								text: "Berhasil menghapus data "+tipe+"",
								icon: "success"
								}).then(function(){
									location.reload();
								});
							}
					});
				}
				});
			}
			function formatAngka(input) {
				let value = input.value.replace(/\D/g, '');
				value = value.replace(/\B(?=(\d{3})+(?!\d))/g, '.');
				input.value = value;
			}
			function kodeHutangView(id){
				$('#modalBodyID').html('<div style="width:100%;height:100px;display:flex;justify-content:center;align-items:center;"><div class="loader"></div></div>');
				$.ajax({
					url:"<?=base_url();?>prosesajax/showPembayaranPiutang",
					type: "POST",
					data: {"id" : id},
					cache: false,
					success: function(dataResult){
						setTimeout(() => {
							$('#modalBodyID').html(dataResult);
						}, 1200);
					}
				});
			}
			function delPembayaranPiutang(id){
				Swal.fire({
				title: "Hapus Pembayaran ?",
				text: "Anda akan menghapus data pembayaran piutang.",
				icon: "warning",
				showCancelButton: true,
				confirmButtonColor: "#3085d6",
				cancelButtonColor: "#d33",
				confirmButtonText: "Yes, delete it!"
				}).then((result) => {
				if (result.isConfirmed) {
					$.ajax({
						url:"<?=base_url();?>prosesajax/delPembayaranPiutang",
						type: "POST",
						data: {"id" : id},
							cache: false,
							success: function(dataResult){
								Swal.fire({
								title: "Deleted!",
								text: "Berhasil menghapus pembayaran",
								icon: "success"
								}).then(function(){
									location.reload();
								});
							}
					});
				}
				});
			}
			function hapust(kode_bar1,sendcode){
				Swal.fire({
				title: "Anda yakin ?",
				text: "Hapus kode "+kode_bar1+"",
				icon: "warning",
				showCancelButton: true,
				confirmButtonColor: "#3085d6",
				cancelButtonColor: "#d33",
				confirmButtonText: "Yes, delete it!"
				}).then((result) => {
				if (result.isConfirmed) {
					$.ajax({
						url:"<?=base_url();?>proses2/delproduksend",
						type: "POST",
						data: {"sendcode" : sendcode, "kode_bar1" : kode_bar1},
							cache: false,
							success: function(dataResult){
								Swal.fire({
								title: "Deleted!",
								text: "Berhasil menghapus produk",
								icon: "success"
								}).then(function(){
									//$('#s'+kode_bar1+''+sendcode+'').hide();
									loadTableKirim(sendcode);
								});
							}
					});
				}
				});
			}
			$( "#updateReseller" ).on( "click", function() {
				updateReseller();
			});
			function updateReseller(){
				const namaReseller = $('#idReseller').val();
				const tglKirim = $('#tglKirim').val();
				const sendCode = $('#sendCode').val();
				const tujuanKirim = $('#tujuanKirim').val();
				const statusBayar = $('#statusBayar').val();
				const angkaBayar = $('#angkaBayar').val();
				const kete = $('#kete').val();
				if(namaReseller!="" && tglKirim!="" && sendCode!="" && tujuanKirim!="" && statusBayar!="" && angkaBayar!=""){
					$.ajax({
						url:"<?=base_url();?>proses2/sendtoresellerupdate",
						type: "POST",
						data: {"namaReseller" : namaReseller, "tglKirim" : tglKirim, "sendCode" : sendCode, "tujuanKirim" : tujuanKirim, "statusBayar" : statusBayar, "angkaBayar" : angkaBayar, "kete" : kete},
							cache: false,
							success: function(dataResult){
								var data = JSON.parse(dataResult);
								if(data.statusCode==200){
									Swal.fire('Berhasil Menyimpan', data.psn, 'success');
									$('#addProdukResellerDis').hide();
									$('#addProdukReseller').show();
								} else {
									Swal.fire('Gagal Menyimpan', data.psn, 'warning');
								}
							}
					});
				}
			}
			function simpanPenjualanReseller(){
				const namaReseller = $('#idReseller').val();
				const tglKirim = $('#tglKirim').val();
				const sendCode = $('#sendCode').val();
				const tujuanKirim = $('#tujuanKirim').val();
				const statusBayar = $('#statusBayar').val();
				const angkaBayar = $('#angkaBayar').val();
				const kete = $('#kete').val();
				//console.log('namaReseller', namaReseller, 'tglKirim', tglKirim, 'sendCode', sendCode, 'tujuanKirim', tujuanKirim, 'statusBayar', statusBayar, 'angkaBayar', angkaBayar);
				if(namaReseller!="" && tglKirim!="" && sendCode!="" && tujuanKirim!="" && statusBayar!="" && angkaBayar!=""){
					$.ajax({
						url:"<?=base_url();?>proses2/sendtoreseller",
						type: "POST",
						data: {"namaReseller" : namaReseller, "tglKirim" : tglKirim, "sendCode" : sendCode, "tujuanKirim" : tujuanKirim, "statusBayar" : statusBayar, "angkaBayar" : angkaBayar, "kete" : kete},
							cache: false,
							success: function(dataResult){
								var data = JSON.parse(dataResult);
								if(data.statusCode==200){
									Swal.fire('Berhasil Menyimpan', data.psn, 'success');
									$('#addProdukResellerDis').hide();
									$('#addProdukReseller').show();
								} else {
									Swal.fire('Gagal Menyimpan', data.psn, 'warning');
								}
							}
					});
				} else {
					Swal.fire('Gagal Menyimpan', 'Anda harus mengisi semua form', 'warning');
				}
			}
			$( "#simpanReseller" ).on( "click", function() {
				simpanPenjualanReseller();
			} );
			$( "#addProdukResellerDis" ).on( "click", function() {
				Swal.fire('Info', 'Anda belum menyimpan', 'info');
			} );
			$( "#tambahKanProduk" ).on( "click", function() {
				const kodebar = $('#autoComplete').val();
				const ukuran = $('#ukuran').val();
				const jumlahkirim = $('#jumlahkirim').val();
				const sendCode = $('#sendCode').val();
				console.log(''+sendCode);
				if(kodebar!="" && ukuran!="" && jumlahkirim!=""){
					$.ajax({
						url:"<?=base_url();?>proses2/tambahkanproduk",
						type: "POST",
						data: {"kodebar" : kodebar, "ukuran" : ukuran, "jumlahkirim" : jumlahkirim, "sendCode" : sendCode},
							cache: false,
							success: function(dataResult){
								var data = JSON.parse(dataResult);
								if(data.statusCode==200){
									Swal.fire('Berhasil Menyimpan', data.psn, 'success');
									$('#addProdukResellerDis').hide();
									$('#addProdukReseller').show();
									loadTableKirim(sendCode);
									//updateReseller();
								} else {
									Swal.fire('Gagal Menyimpan', data.psn, 'warning');
								}
							}
					});
				} else {
					Swal.fire('Gagal Menyimpan', 'Anda harus mengisi semua form', 'warning');
				}
			} );
			function loadTableKirim(id){
				$.ajax({
					url:"<?=base_url();?>proses2/loadtablekirim",
					type: "POST",
					data: {"id" : id},
					cache: false,
					success: function(dataResult){
						$('#loadTampilkanTable').html(dataResult);
					}
				});
				$.ajax({
					url:"<?=base_url();?>proses2/loadtablekirim2",
					type: "POST",
					data: {"id" : id},
					cache: false,
					success: function(dataResult){
						var data = JSON.parse(dataResult);
						if(data.statusCode==200){
							console.log(''+data.psn);
							$('#angkaBayar').val(data.psn);
						}
					}
				});
			}
			const sendCode = $('#sendCode').val();
			loadTableKirim(sendCode);
			// $( "#addProdukReseller" ).on( "click", function() {
			// 	const sendCode = $('#sendCode').val();
			// } );
			function hapusData(id){
				$.ajax({
					url:"<?=base_url();?>proses2/hapusKirimanRes",
					type: "POST",
					data: {"id" : id},
					cache: false,
					success: function(dataResult){
						var data = JSON.parse(dataResult);
						if(data.statusCode==200){
							Swal.fire('Berhasil Menghapus', ''+data.psn+'', 'success').then(function(){
								location.href = "<?=base_url('data-stok/keluar');?>";
							});
						} else {
							Swal.fire('Gagal Menghapus', ''+data.psn+'', 'error');
						}
					}
				});
			}
			$( "#tombolSubmit" ).on( "click", function() {
				$('#tombolSubmit').hide();
				$('#thisLoader').show();
			} );
			<?php if($showTable=="produkMasuk"){?>
			function loadDataTable(){
				$('#tableBody').html('Loading data...');
				$.ajax({
					url:"<?=base_url('showtable/showprodukmasuk');?>",
					type: "POST",
					data: {},
					cache: false,
					success: function(dataResult){
						if ($.fn.DataTable.isDataTable('#table1')) {
							$('#table1').DataTable().destroy();
						}
						$('#tableBody').html(dataResult);
						$('#table1').DataTable();
					}
				});
			}
			loadDataTable();
			<?php }
			if($showTable=="produkMutasi"){?>
			function loadDataTable(){
				$('#tableBody').html('Loading data...');
				$.ajax({
					url:"<?=base_url('showtable/showprodukMutasi');?>",
					type: "POST",
					data: {},
					cache: false,
					success: function(dataResult){
						if ($.fn.DataTable.isDataTable('#table1')) {
							$('#table1').DataTable().destroy();
						}
						$('#tableBody').html(dataResult);
						$('#table1').DataTable();
					}
				});
			}
			loadDataTable();
			function showDetail(cd,tipe){
				$('#modals2311as').modal('show');
				if(tipe == "KirimGudang"){
					$('#myLael2311').html('<i style="color:red;" class="icon-copy bi bi-arrow-right-circle-fill"></i> &nbsp;Kirim Gudang');
				} else {
					$('#myLael2311').html('<i style="color:green;" class="icon-copy bi bi-arrow-left-circle-fill"></i> &nbsp;Terima Dari Gudang');
				}
				$('#modl11').html('<div style="width:100%;display:flex;justify-content:center;"><div class="loader"></div></div>');
				$.ajax({
					url:"<?=base_url('mutasi/loadBarangMutasi2');?>",
					type: "POST",
					data: {"codeProses":cd},
					cache: false,
					success: function(dataResult){
						setTimeout(() => {
							$('#modl11').html(dataResult);
						}, 500);
						
					}
				});
			}
			<?php } ?>
		</script>
		<noscript
			><iframe
				src="https://www.googletagmanager.com/ns.html?id=GTM-NXZMQSS"
				height="0"
				width="0"
				style="display: none; visibility: hidden"
			></iframe
		></noscript>
		<!-- End Google Tag Manager (noscript) -->
	</body>
</html>