<script src="<?=base_url('assets/');?>vendors/scripts/core.js"></script>
		<script src="<?=base_url('assets/');?>vendors/scripts/script.min.js"></script>
		<script src="<?=base_url('assets/');?>vendors/scripts/process.js"></script>
		<script src="<?=base_url('assets/');?>vendors/scripts/layout-settings.js"></script>
		
		<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.10.0/dist/sweetalert2.all.min.js" integrity="sha256-IW9RTty6djbi3+dyypxajC14pE6ZrP53DLfY9w40Xn4=" crossorigin="anonymous"></script>
		<?php  if(!empty($autocomplet) AND $autocomplet=="mutasi") { 
			$ar = array();
			foreach($produk->result() as $kd){
				$ds = '"'.$kd->nama_produk.'"';
				$ar[] = $ds;
			}
			$stok_im = implode(",",$ar);
			
		?>
		<script src="<?=base_url('assets2/');?>/autoComplete.min.js"></script>
		<script>
			const autoCompleteJS = new autoComplete({
                placeHolder: "Ketik nama produk",
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
							$('#model').empty();
							$('#model').append('<option value="">Loading...</option>');
							$('#ukr').empty();
							$('#ukr').attr('disabled', true);
							$('#ukr').append('<option value="">Silahkan pilih model</option>');
                            $.ajax({
								url:"<?=base_url();?>proses2/cekkodeProduk2",
								type: "POST",
								data: {"id" : selection},
									cache: false,
									success: function(dataResult){
										var dataResult = JSON.parse(dataResult);
										if(dataResult.statusCode == 200){
                                            $('#model').attr('disabled', false);
											$('#model').empty();
											$('#model').append('<option value="">Pilih Model Produk</option>');
                                            dataResult.model.forEach(item => {
                                                //console.log(item.kode_bar); // atau item.nama_produk dll.
                                                $('#model').append('<option value="' + item.kode_bar + '">' + item.warna_model + '</option>');
                                            });
											$('#load1').html('');
										} else {
											$('#load1').html('<font style="color:red;">'+dataResult.psn+'</font>');
										}
									}
							});
                        }
                    }
                }
            });
			$('#model').on('change', function() {
				var model = $('#model').val();
				$('#ukr').empty();
				$('#ukr').append('<option value="">Loading...</option>');
				$.ajax({
					url:"<?=base_url();?>proses2/cekmodel2",
					type: "POST",
					data: {"kodebar" : model},
						cache: false,
						success: function(dataResult){
							var dataResult = JSON.parse(dataResult);
							if(dataResult.statusCode == 200){
								$('#ukr').attr('disabled', false);
								$('#ukr').empty();
								$('#ukr').append('<option value="">Pilih Ukuran Produk</option>');
                                dataResult.model2.forEach(item => {
                                    //console.log(item.kode_bar1); // atau item.nama_produk dll.
                                    $('#ukr').append('<option value="' + item.kode_bar1 + '">' + item.ukuran + '</option>');
                                });
							} else {
								$('#load2').html(''+dataResult.psn);
							}
						}
				});
			});
			$('#ukr').on('change', function() {
				var model 	 = $('#model').val();
				var ukr 	 = $('#ukr').val();
				var nmProduk = $('#autoComplete').val();
				var asalKirim= $('#asalKirim').val();
				
				console.log('ini yg kirim '+ukr);
				if(model != "" && ukr != "" && nmProduk != "") {
					$.ajax({
						url:"<?=base_url();?>proses2/cekmodelAndStok",
						type: "POST",
						data: {"kodebar" : model, "ukr" : ukr, "nmProduk" : nmProduk,  "asalKirim" : asalKirim},
						cache: false,
						success: function(dataResult){
							var dataResult = JSON.parse(dataResult);
							if(dataResult.statusCode == 200){
								$('#load3').html(''+dataResult.psn);
								$('#jumlah').attr('disabled', false);
							} else {
								$('#load3').html('<font style="color:red;">'+dataResult.psn+'</font>');
							}
						}
					});
				} else {
					$('#jumlah').attr('disabled', true);
				}
			});
			$('#idSimpanAdd').on('click', function() {
				var codeProses 	= $('#codeProses').val();
				var tgl 	 	= $('#tglid').val();
				var ctt 	 	= $('#catatanid').val();
				if(ctt==""){ var ctt = "null"; }
				var asalKirim	= $('#asalKirim').val();

				var nmProduk 	= $('#autoComplete').val();
				var model 	 	= $('#model').val();
				var ukr 	 	= $('#ukr').val();
				var jumlah 		= $('#jumlah').val();
				console.log('ini hasil di kirim '+ukr);
				if(codeProses != "" && tgl != "" && asalKirim != "" && nmProduk != "" && model != "" && ukr != "" && jumlah != "") {
					Swal.showLoading();
					$.ajax({
						url:"<?=base_url();?>mutasi/simpanMutasi",
						type: "POST",
						data: {"codeProses" : codeProses, "tgl" : tgl, "ctt" : ctt,  "asalKirim" : asalKirim, "nmProduk" : nmProduk, "model" : model, "ukr" : ukr, "jumlah" : jumlah},
						cache: false,
						success: function(dataResult){
							console.log(dataResult);
							var dataResult = JSON.parse(dataResult);
							if(dataResult.statusCode == 200){
								Swal.fire({ icon: 'success', title: dataResult.psn2,
									text: dataResult.psn
								});
								loadBarangMutasi(codeProses);
							} else {
								Swal.fire({ icon: 'error', title: 'Gagal Menyimpan',
									text: dataResult.psn
								});
							}
						}
					});
				} else {
					Swal.fire({ icon: 'error', title: 'Oops...',
						text: 'Data belum lengkap'
					});
				}
			});
			function loadBarangMutasi(codeProses){
				if(codeProses == "null"){ codeProses = $('#codeProses').val(); }
				$('#loadingTables').html('<font style="color:red;">Sedang mengambil data...</font>');
				$.ajax({
					url:"<?=base_url();?>mutasi/loadBarangMutasi",
					type: "POST",
					data: {"codeProses" : codeProses},
					cache: false,
					success: function(dataResult){
						$('#bodyTables').html(dataResult);
						$('#loadingTables').html('');
					}
				});
			}
			loadBarangMutasi('<?=$codeProses;?>');
			function hapusBarangMutasi(id){
				Swal.fire({
				title: "Hapus Data ?",
				text: "Anda tidak bisa mengembalikan proses ini,",
				icon: "warning",
				showCancelButton: true,
				confirmButtonColor: "#3085d6",
				cancelButtonColor: "#d33",
				confirmButtonText: "Hapus"
				}).then((result) => {
				if (result.isConfirmed) {
					Swal.fire({ title: 'Proses Hapus...', allowOutsideClick: false,
						didOpen: () => { Swal.showLoading(); }
					});
					$.ajax({
						url:"<?=base_url();?>mutasi/kembalikanMutasi",
						type: "POST",
						data: {"id" : id},
						cache: false,
						success: function(dataResult){
							setTimeout(() => {
								Swal.close();
								Swal.fire({ icon: 'success', title: 'Berhasil!', text: 'Data telah disimpan.' });
								loadBarangMutasi('<?=$codeProses;?>');
							}, 800);
						}
					});
				}
				});
			}
		</script>
		<?php } ?>
		
		
		<script>
			function formatAngka(input) {
				let value = input.value.replace(/\D/g, '');
				value = value.replace(/\B(?=(\d{3})+(?!\d))/g, '.');
				input.value = value;
			}
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