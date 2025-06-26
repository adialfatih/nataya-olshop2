<script src="<?=base_url('assets/');?>vendors/scripts/core.js"></script>
<script src="<?=base_url('assets/');?>vendors/scripts/script.min.js"></script>
<script src="<?=base_url('assets/');?>vendors/scripts/process.js"></script>
<script src="<?=base_url('assets/');?>vendors/scripts/layout-settings.js"></script>
<script src="<?=base_url('assets/');?>vendors/scripts/datatable-setting.js"></script>
		<?php  
			$ar = array();
            //$kode_bar = $data = $this->db->query("SELECT DISTINCT nama_tujuan FROM stok_produk_keluar WHERE tujuan='Customer' ORDER BY nama_tujuan ASC");
            $kode_bar = $this->db->query("SELECT DISTINCT kode_bar1 FROM data_produk_stok");
			foreach($kode_bar->result() as $kd){
				$ds = '"'.$kd->kode_bar1.'"';
				$ar[] = $ds;
			}
			$stok_im = implode(",",$ar);
		?>
		<script src="<?=base_url('assets2/');?>/autoComplete.min.js"></script>
			<script>
			const autoCompleteJS = new autoComplete({
                placeHolder: "Masukan Kode Barang",
                data: { src: [<?=$stok_im;?>], cache: true, },
                resultItem: { highlight: true },
                events: {
                    input: {
                        selection: (event) => {
                            const selection = event.detail.selection.value;
                            autoCompleteJS.input.value = selection;
							$('#notifStok').html('Loading...');
                            $.ajax({
                                url:"<?=base_url();?>proses2/cekjmlstok",
                                type: "POST", data: {"id" : selection},
                                cache: false,
                                success: function(dataResult){
                                    var data = JSON.parse(dataResult);
                                    if(data.statusCode==200){
                                        $('#notifStok').html(data.nm+' '+data.mdl+' Ukuran : '+data.ukr+'<br>Jumlah Stok : '+data.cek+' Pcs');
                                        $('#addProdukCustomer').prop('disabled', false);
                                    } else {
                                        $('#notifStok').html('<font style="color:red;">Stok tidak tersedia.</font>');
                                        $('#addProdukCustomer').prop('disabled', true);
                                    }
                                }
                            });
                        }
                    }
                }
            });
			</script>
		<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.10.0/dist/sweetalert2.all.min.js" integrity="sha256-IW9RTty6djbi3+dyypxajC14pE6ZrP53DLfY9w40Xn4=" crossorigin="anonymous"></script>
		<!-- Google Tag Manager (noscript) -->
		<script>
			
			function formatAngka(input) {
				let value = input.value.replace(/\D/g, '');
				value = value.replace(/\B(?=(\d{3})+(?!\d))/g, '.');
				input.value = value;
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
						data: {"sendcode" : sendcode, "kode_bar1" : kode_bar1, "cus":"yes"},
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
			$( "#autoComplete" ).on( "change", function() {
                var daata = $('#autoComplete').val();
                if(daata==""){
                    $('#notifStok').html('');
                    $('#addProdukCustomer').prop('disabled', true);
                } else {
                    $.ajax({
                        url:"<?=base_url();?>proses2/cekjmlstok",
                        type: "POST", data: {"id" : daata},
                        cache: false,
                        success: function(dataResult){
                            var data = JSON.parse(dataResult);
                            if(data.statusCode==200){
                                $('#notifStok').html(data.nm+' '+data.mdl+' Ukuran : '+data.ukr+'<br>Jumlah Stok : '+data.cek+' Pcs');
                                $('#addProdukCustomer').prop('disabled', false);
                            } else {
                                $('#notifStok').html('<font style="color:red;">Stok tidak tersedia.</font>');
                                $('#addProdukCustomer').prop('disabled', true);
                            }
                        }
                    });
                }
            });
            $( "#btnSimpan23" ).on( "click", function() {
                Swal.fire('Sukses', 'Berhasil Menyimpan', 'success').then(function(){
                    document.location.href = "<?=base_url('stok/kirim/customer');?>";
                });
            });
            $( "#kirimAgen" ).on( "click", function() {
                const idAgen = $('#idAgen').val();
				const tglKirim = $('#tglKirim').val();
				const sendCode = $('#sendCode').val();
				const tujuanKirim = $('#tujuanKirim').val();
				const statusBayar = $('#statusBayar').val();
				const angkaBayar = $('#angkaBayar').val();
				const kete = $('#kete').val();
				const cariProduk = $('#autoComplete').val();
				const jumlahProdukKirim = $('#jumlahProdukKirim').val();
                if(idAgen!="" && tglKirim!="" && sendCode!="" && cariProduk!="" && jumlahProdukKirim!=""){
                    $.ajax({
						url:"<?=base_url();?>proses2/sendtoagen",
						type: "POST",
						data: {"idAgen" : idAgen, "tglKirim" : tglKirim, "sendCode" : sendCode, "tujuanKirim" : tujuanKirim, "statusBayar" : statusBayar, "angkaBayar" : angkaBayar, "kete" : kete, "cariProduk" : cariProduk, "jumlahProdukKirim" : jumlahProdukKirim},
							cache: false,
							success: function(dataResult){
								var data = JSON.parse(dataResult);
								if(data.statusCode==200){
									Swal.fire('Berhasil Menyimpan', data.psn, 'success');
                                    $('#autoComplete').val('');
                                    $('#jumlahProdukKirim').val('');
                                    $('#notifStok').html('');
                                    loadTableKirim(sendCode);
								} else {
									Swal.fire('Gagal Menyimpan', data.psn, 'warning');
								}
							}
					});
                } else {
                    Swal.fire('Gagal Menyimpan', 'Anda harus mengisi semua form', 'warning');
                }
            });
			function addProdukToAgen2(){
				const namaAgen = $('#idAgen').val();
				const tglKirim = $('#tglKirim').val();
				const sendCode = $('#sendCode').val();
				const tujuanKirim = $('#tujuanKirim').val();
				const statusBayar = $('#statusBayar').val();
				const angkaBayar = $('#angkaBayar').val();
				const angkaBayar2 = angkaBayar.replace(/\D/g, '');
				const kete = $('#kete').val();
				const kodebarang = $('#autoComplete').val();
				const jumlahProdukKirim = $('#jumlahProdukKirim').val();
				const kirimProduk = jumlahProdukKirim.replace(/\D/g, '');
				if(namaAgen!="" && tglKirim!="" && sendCode!=""){
					
						$.ajax({
						url:"<?=base_url();?>proses2/sendtoagen2",
						type: "POST",
						data: {"namaAgen":namaAgen, "tglKirim":tglKirim, "sendCode":sendCode, "tujuanKirim":tujuanKirim, "statusBayar":statusBayar, "angkaBayar":angkaBayar2, "kete":kete, "kodebarang":kodebarang, "kirimProduk":kirimProduk},
						cache: false,
							success: function(dataResult){
								console.log(dataResult);
								var data = JSON.parse(dataResult);
								if(data.statusCode==200){
									Swal.fire('Berhasil Menyimpan', 'Berhasil menyimpan', 'success');
								} else {
									Swal.fire('Gagal Menyimpan', data.psn, 'warning');
								}
							}
						});
					
				} else {
					Swal.fire('Gagal Menyimpan', 'Anda harus mengisi semua form', 'warning');
				}
			}
			function addProdukToAgen(){
				const namaAgen = $('#idAgen').val();
				const tglKirim = $('#tglKirim').val();
				const sendCode = $('#sendCode').val();
				const tujuanKirim = $('#tujuanKirim').val();
				const statusBayar = $('#statusBayar').val();
				const angkaBayar = $('#angkaBayar').val();
				const angkaBayar2 = angkaBayar.replace(/\D/g, '');
				const kete = $('#kete').val();
				const kodebarang = $('#autoComplete').val();
				const jumlahProdukKirim = $('#jumlahProdukKirim').val();
				const kirimProduk = jumlahProdukKirim.replace(/\D/g, '');
				if(namaAgen!="" && tglKirim!="" && sendCode!="" && kodebarang!="" && kirimProduk!=""){
					if(parseInt(kirimProduk) > 0){
						$.ajax({
						url:"<?=base_url();?>proses2/sendtoagen",
						type: "POST",
						data: {"namaAgen":namaAgen, "tglKirim":tglKirim, "sendCode":sendCode, "tujuanKirim":tujuanKirim, "statusBayar":statusBayar, "angkaBayar":angkaBayar2, "kete":kete, "kodebarang":kodebarang, "kirimProduk":kirimProduk},
						cache: false,
							success: function(dataResult){
								console.log(dataResult);
								var data = JSON.parse(dataResult);
								if(data.statusCode==200){
									swal.fire('Berhasil Menyimpan', 'Berhasil menyimpan', 'success').then(function(){
										loadTableKirim(sendCode);
										$('#autoComplete').val('');
										$('#jumlahProdukKirim').val('');
									});
								} else {
									Swal.fire('Gagal Menyimpan', data.psn, 'warning');
								}
							}
						});
					} else {
						Swal.fire('Gagal Menyimpan', 'Jumlah Produk harus lebih dari 0', 'warning');
					}
				} else {
					Swal.fire('Gagal Menyimpan', 'Anda harus mengisi semua form', 'warning');
				}
				
			}
			$( "#addProdukCustomer" ).on( "click", function() {
				const namaCustomer = $('#namaCustomer').val();
				const tglKirim = $('#tglKirim').val();
				const sendCode = $('#sendCode').val();
				const tujuanKirim = $('#tujuanKirim').val();
				const statusBayar = $('#statusBayar').val();
				const angkaBayar = $('#angkaBayar').val();
				const kete = $('#kete').val();
				const cariProduk = $('#autoComplete').val();
				const jumlahProdukKirim = $('#jumlahProdukKirim').val();
				if(namaCustomer!="" && tglKirim!="" && sendCode!="" && cariProduk!="" && jumlahProdukKirim!=""){
					$.ajax({
						url:"<?=base_url();?>proses2/sendtocustomer",
						type: "POST",
						data: {"namaCustomer" : namaCustomer, "tglKirim" : tglKirim, "sendCode" : sendCode, "tujuanKirim" : tujuanKirim, "statusBayar" : statusBayar, "angkaBayar" : angkaBayar, "kete" : kete, "cariProduk" : cariProduk, "jumlahProdukKirim" : jumlahProdukKirim},
							cache: false,
							success: function(dataResult){
								var data = JSON.parse(dataResult);
								if(data.statusCode==200){
									Swal.fire('Berhasil Menyimpan', data.psn, 'success');
									$('#addProdukResellerDis').hide();
									$('#addProdukReseller').show();
                                    $('#autoComplete').val('');
                                    $('#jumlahProdukKirim').val('');
                                    $('#notifStok').html('');
                                    loadTableKirim(sendCode);
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
					data: {"id" : id, "tes":"oke"},
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