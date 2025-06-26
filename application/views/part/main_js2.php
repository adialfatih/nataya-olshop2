<script src="<?=base_url('assets/');?>vendors/scripts/core.js"></script>
		<script src="<?=base_url('assets/');?>vendors/scripts/script.min.js"></script>
		<script src="<?=base_url('assets/');?>vendors/scripts/process.js"></script>
		<script src="<?=base_url('assets/');?>vendors/scripts/layout-settings.js"></script>
		<!-- Slick Slider js -->
		<script src="<?=base_url('assets/');?>src/plugins/slick/slick.min.js"></script>
		<!-- bootstrap-touchspin js -->
		<script src="<?=base_url('assets/');?>src/plugins/bootstrap-touchspin/jquery.bootstrap-touchspin.js"></script>
		<?php  if(!empty($autocomplet)) { ?>
		<script src="<?=base_url('assets2/');?>autoComplete.min.js"></script>
		<?php } ?>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.10.0/dist/sweetalert2.all.min.js" integrity="sha256-IW9RTty6djbi3+dyypxajC14pE6ZrP53DLfY9w40Xn4=" crossorigin="anonymous"></script>
		<script>
			<?php if($autocomplet=="stokgudang"){ 
			$stok = $this->db->query("SELECT nama_produk FROM data_produk");
			$ar = array();
			foreach($stok->result() as $st){
				$ds = '"'.$st->nama_produk.'"';
				$ar[] = $ds;
			}
			$stok_im = implode(",",$ar);
			?>
			const autoCompleteJS = new autoComplete({
                placeHolder: "Ketik Nama Produk...",
                data: { src: [<?=$stok_im;?>], cache: true, },
                resultItem: { highlight: true },
                events: {
                    input: {
                        selection: (event) => {
                            const selection = event.detail.selection.value;
                            autoCompleteJS.input.value = selection;
							var thisId = document.getElementById('thisID').value;
							var thisTipeStok = document.getElementById('thisTipeStok').value;
							loadstok(thisId,thisTipeStok,'null',selection);
							$('#kategori90').val('');
                        }
                    }
                }
            });
			<?php } ?>
			$('#autoComplete').on('change', function() {
				var vs = $('#autoComplete').val();
				if(vs == ""){
					var thisId = document.getElementById('thisID').value;
					var thisTipeStok = document.getElementById('thisTipeStok').value;
					loadstok(thisId,thisTipeStok,'null','null');
					$('#kategori90').val('');
				}
			});
			<?php if($autocomplet=="stokprodukmasuk"){ 
			$stok = $this->db->query("SELECT DISTINCT kode_bar1  FROM data_produk_detil");
			$ar = array();
			foreach($stok->result() as $st){
				$ds = '"'.$st->kode_bar1.'"';
				$ar[] = $ds;
			}
			$stok_im = implode(",",$ar);
			?>
			const autoCompleteJS = new autoComplete({
                placeHolder: "Ketik kode...",
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
							$.ajax({
								url:"<?=base_url();?>prosesajax/cekkodedetil",
								type: "POST",
								data: {"selection" : selection},
									cache: false,
									success: function(dataResult){
										var dataResult = JSON.parse(dataResult);
										const selectElement = document.getElementById("namaproduk");
										if(dataResult.statusCode == 200){
											Swal.fire('Success', 'Kode Ditemukan', 'success');
											selectElement.value = ''+dataResult.id_produk;
											document.getElementById("modelproduk").value = ''+dataResult.warna;
											document.getElementById("ukuranproduk").value = ''+dataResult.ukuran;
										} else {
											Swal.fire('Error', dataResult.psn, 'error');
											selectElement.value = "";
											document.getElementById("modelproduk").value = '';
											document.getElementById("ukuranproduk").value = '';
										}
									},
									error: function(jqXHR, textStatus, errorThrown) {
										console.error("Gagal terkoneksi ke URL. Status:", textStatus, "Error:", errorThrown);
										Swal.fire('Error', 'Tidak dapat terhubung ke URL', 'error');
									}
							});
                        }
                    }
                }
            });
			
			function cekModel(){
				var autoComplete = document.getElementById('autoComplete').value;
				var nama = document.getElementById('namaproduk').value;
				var model = document.getElementById('modelproduk').value;
				if(nama!="" && model!=""){
					$.ajax({
						url:"<?=base_url();?>prosesajax/cekmodel",
						type: "POST",
						data: {"model" : model, "nama" : nama, "autoComplete" : autoComplete},
							cache: false,
							success: function(dataResult){
								var dataResult = JSON.parse(dataResult);
								if(dataResult.statusCode == 200){
									if(dataResult.nb == "true"){
										$('#noticest').html('');
									} else {
										$('#noticest').html('Produk ini sudah terdaftar dengan kode '+dataResult.kode);
									}
								} else {
									$('#noticest').html('');
								}
							}
					});
				} else {
					$('#noticest').html('');
				}
				
			}
			function deleteThis(cd){
				Swal.fire({
				title: "Are you sure?",
				text: "You won't be able to revert this!",
				icon: "warning",
				showCancelButton: true,
				confirmButtonColor: "#3085d6",
				cancelButtonColor: "#d33",
				confirmButtonText: "Yes, delete it!"
				}).then((result) => {
				if (result.isConfirmed) {
					$.ajax({
						url:"<?=base_url();?>prosesajax/delstokin",
						type: "POST",
						data: {"cd" : cd},
						cache: false,
						success: function(dataResult){
							var dataResult = JSON.parse(dataResult);
							if(dataResult.statusCode == 200){
								Swal.fire('Success', dataResult.psn, 'success');
							} else {
								Swal.fire('Error', dataResult.psn, 'error');
							}
						}
					});
				}
				});
			}
			function tambahkanNotes(){
				var codeinput = document.getElementById('codeinput').value;
				var kode = document.getElementById('autoComplete').value;
				var nmproduk = document.getElementById('namaproduk').value;
				var model = document.getElementById('modelproduk').value;
				var ukr = document.getElementById('ukuranproduk').value;
				var jumlah = document.getElementById('jumlahproduk').value;
				var hpp = document.getElementById('hpp').value;
				var hargajual = document.getElementById('hargajual').value;
				if(kode!="" && model!="" && ukr!="" && jumlah!="" && nmproduk!="" && hpp!="" && hargajual!=""){
					$.ajax({
						url:"<?=base_url();?>prosesajax/sendnotes2",
						type: "POST",
						data: {"kode":kode,"nmproduk":nmproduk,"model":model,"ukr":ukr,"jumlah":jumlah,"codeinput":codeinput,"hpp":hpp,"hargajual":hargajual},
						cache: false,
						success: function(dataResult){
							var dataResult = JSON.parse(dataResult);
							if(dataResult.statusCode == 200){
								loadDAta1(codeinput);
								document.getElementById('autoComplete').value = '';
								document.getElementById('namaproduk').value = '';
								document.getElementById('modelproduk').value = '';
								document.getElementById('ukuranproduk').value = '';
								document.getElementById('jumlahproduk').value = '';
								Swal.fire({
									title: "Berhasil!",
									text: "Menyimpan data Stok Masuk",
									icon: "success"
								});
							} else {
								Swal.fire({
									title: "Gagal!",
									text: ""+dataResult.psn+"",
									icon: "error"
								});
							}
						}
					});
				} else {
					Swal.fire({ title: "Info!", text: "Anda harus mengisi semua data", icon: "warning" });
				}
			}
			function loadDAta1(id){
				$.ajax({
					url:"<?=base_url();?>prosesajax/showTable2",
					type: "POST",
					data: {"id" : id},
					cache: false,
					success: function(dataResult){
						$('#tbodyID').html(dataResult);
					}
				});
			}
			var cd = document.getElementById('codeinput2').value;
			loadDAta1(cd);
			function hapusIn(id,codeinput){
				$.ajax({
					url:"<?=base_url();?>prosesajax/hapusTablke",
					type: "POST",
					data: {"id" : id, "codeinput" : codeinput},
					cache: false,
					success: function(dataResult){
						var dataResult = JSON.parse(dataResult);
						if(dataResult.statusCode == 200){
							loadDAta1(dataResult.psn);
						}
					}
				});
			}
			<?php } ?>
			jQuery(document).ready(function () {
				jQuery(".product-slider").slick({
					slidesToShow: 1,
					slidesToScroll: 1,
					arrows: true,
					infinite: true,
					speed: 1000,
					fade: true,
					asNavFor: ".product-slider-nav",
				});
				jQuery(".product-slider-nav").slick({
					slidesToShow: 3,
					slidesToScroll: 1,
					asNavFor: ".product-slider",
					dots: false,
					infinite: true,
					arrows: false,
					speed: 1000,
					centerMode: true,
					focusOnSelect: true,
				});
				$("input[name='demo3_22']").TouchSpin({
					initval: 1,
				});
			});
            function validateAndPreviewImage() {
                const input = document.getElementById('upload');
                const imgPreview = document.getElementById('imgForUpload');
                const file = input.files[0]; // Mendapatkan file yang diunggah

                // Cek apakah ada file yang diunggah
                if (!file) {
                    Swal.fire('Tidak ada file yang dipilih.');
                    return;
                }

                // Validasi ekstensi file
                const allowedExtensions = ['image/jpeg', 'image/png']; // Ekstensi yang diizinkan
                if (!allowedExtensions.includes(file.type)) {
                    Swal.fire('Ekstensi file harus JPG atau PNG.');
                    input.value = ''; // Kosongkan input file
                    imgPreview.src = '<?=base_url("assets/");?>no_image.svg'; // Kembalikan gambar default
                    return;
                }

                // Validasi ukuran file (maksimal 2MB)
                if (file.size > 5 * 1024 * 1024) { // 2MB = 2 * 1024 * 1024 bytes
                    Swal.fire('Ukuran file maksimal adalah 2MB.');
                    input.value = ''; // Kosongkan input file
                    imgPreview.src = '<?=base_url("assets/");?>no_image.svg'; // Kembalikan gambar default
                    return;
                }

                // Jika file valid, tampilkan pratinjau gambar
                const reader = new FileReader();
                reader.onload = function(e) {
                    imgPreview.src = e.target.result; // Menampilkan gambar pratinjau
                }
                reader.readAsDataURL(file); // Membaca file sebagai Data URL
            }
			function ambilsatuan(id){
				$.ajax({
					url:"prosesajax/ambilsatuan",
					type: "POST",
					data: {"id" : id},
					cache: false,
					success: function(dataResult){
						var dataResult = JSON.parse(dataResult);
						if(dataResult.statusCode == 200){
							$('#satuanID').html(''+dataResult.satuan);
							$('#input_satuan').val(''+dataResult.satuan);
							$('#hargabeli').val(''+dataResult.harga_beli);
							$('#hargajual').val(''+dataResult.harga_jual);
						} else {
							$('#satuanID').html('');
							$('#input_satuan').val('');
							$('#hargabeli').val('');
							$('#hargajual').val('');
						}
						
					}
				});
			}
			function formatAngka(input) {
				let value = input.value.replace(/\D/g, '');
				value = value.replace(/\B(?=(\d{3})+(?!\d))/g, '.');
				input.value = value;
			}
			<?php if($showStok=="true"){ ?>
			//var tipeShowStok = "<?=$showStokTipe;?>";
			function loadstok(id,tipe,kat,nm){
				console.log('nm : '+nm);
				document.getElementById('thisID').value = ''+id;
				$('#viewStok').html('<tr><td colspan="6"><div style="width:100%;display:flex;justify-content:center;align-items:center"><div class="loader"></div></div></td></tr>');
				console.log('id : '+id);
				$.ajax({
					url:"<?=base_url();?>prosesajax/datadis",
					type: "POST",
					data: {"id" : id, "tipeShowStok" : tipe},
					cache: false,
					success: function(dataResult){
						$('#idStokView').html(dataResult);
					}
				});
				$.ajax({
					url:"<?=base_url();?>prosesajax/tampilkanstok",
					type: "POST",
					data: {"id" : id, "tipeShowStok" : tipe, "kat" : kat, "nm" : nm},
					cache: false,
					success: function(dataResult){
						setTimeout(() => {
							$('#viewStok').html(dataResult);
						}, 900);
					}
				});
				
			}
			var thisId = document.getElementById('thisID').value;
			var thisTipeStok = document.getElementById('thisTipeStok').value;
			loadstok(thisId,thisTipeStok,'null','null');
			function changeSelectKategori(value){
				var thisId = document.getElementById('thisID').value;
				var thisTipeStok = document.getElementById('thisTipeStok').value;
				loadstok(thisId,thisTipeStok,value,'null');
			}
			<?php } ?>
			function ceksj(val){
				$.ajax({
					url:"prosesajax/ceksjbrgmask",
					type: "POST",
					data: {"val" : val},
					cache: false,
					success: function(dataResult){
						var dataResult = JSON.parse(dataResult);
						if(dataResult.statusCode == 200){
							if(dataResult.nb=="true"){
								$('#notice2').html('');
							} else {
								$('#notice2').html('Surat Jalan Sudah Pernah Digunakan.');
							}
						}
					}
				});
			}
			$(document).ready(function () {
				$('#upload_file').on('change', function () {
					const file = this.files[0]; // Ambil file yang dipilih
					if (file) {
						const fileName = file.name; // Nama file
						const fileExtension = fileName.split('.').pop().toLowerCase(); // Ekstensi file

						// Daftar ekstensi file yang diperbolehkan
						const allowedExtensions = ['xls', 'xlsx'];

						// Validasi ekstensi file
						if (!allowedExtensions.includes(fileExtension)) {
							// Reset nilai input file
							$(this).val('');

							// Tampilkan pesan error menggunakan SweetAlert2
							Swal.fire({
								icon: 'error',
								title: 'Invalid File',
								text: 'Please upload a valid Excel file (.xls, .xlsx).',
								confirmButtonColor: '#d33'
							});
						}
					}
				});
				// Data untuk autocomplete
				
			});
			function changeKode23(kodebar1){
				$.ajax({
					url:"<?=base_url();?>proses2/cekHarga",
					type: "POST",
					data: {"id" : kodebar1},
					cache: false,
					success: function(dataResult){
						var dataResult = JSON.parse(dataResult);
						if(dataResult.statusCode == 200){
							
								$('#kode_bar123').val(''+kodebar1);
								$('#harga_produksi23').val(''+dataResult.harga_produk);
								$('#harga_jual23').val(''+dataResult.harga_jual);
							} else {
								Swal.fire('Error.. (291)');
							}
						
					}
				});
			}
			function cariModel(kode){
				$.ajax({
					url:"<?=base_url();?>proses2/cekModel",
					type: "POST",
					data: {"kode" : kode},
					cache: false,
					success: function(dataResult){
						var dataResult = JSON.parse(dataResult);
						if(dataResult.statusCode == 200){
							$('#modelwarna233').attr('readonly', 'readonly');
							$('#modelwarna233').val(''+dataResult.warna);
						} else {
							$('#modelwarna233').removeAttr('readonly');
							$('#modelwarna233').val('Kode Tidak ditemukan Anda perlu menambahkan model produk');
						}
					}
				});
			}
			$('#kode_bar456').on('input', function() {
                $(this).val($(this).val().toUpperCase());
            });
			function hapusProduk(nm,id){
				Swal.fire({
				title: "Hapus Produk ?",
				text: "Anda akan menghapus produk "+nm+"",
				icon: "warning",
				showCancelButton: true,
				confirmButtonColor: "#3085d6",
				cancelButtonColor: "#d33",
				confirmButtonText: "Ya, Hapus"
				}).then((result) => {
				if (result.isConfirmed) {
					$.ajax({
						url:"<?=base_url();?>prosesajax2/hapusProdukini",
						type: "POST",
						data: {"id" : id},
						cache: false,
						success: function(dataResult){
							var dataResult = JSON.parse(dataResult);
							if(dataResult.statusCode == 200){
								Swal.fire('Success', dataResult.psn, 'success').then((result) => {
									$('#trid'+id).hide(500);
								});
							} else {
								Swal.fire('Error', dataResult.psn, 'error');
							}
						}
					});
				}
				});
			}
			function hapusModel(nm,kodebar,warna){
				Swal.fire({
				title: "Hapus Produk "+nm+" Warna "+warna+"",
				text: "PRINGATAN.!! INI JUGA AKAN MENGHAPUS SEMUA STOK MODEL TERSEBUT",
				icon: "warning",
				showCancelButton: true,
				confirmButtonColor: "#3085d6",
				cancelButtonColor: "#d33",
				confirmButtonText: "Ya, Hapus"
				}).then((result) => {
				if (result.isConfirmed) {
					$.ajax({
						url:"<?=base_url();?>prosesajax2/hapusModelini",
						type: "POST",
						data: {"kodebar" : kodebar},
						cache: false,
						success: function(dataResult){
							var dataResult = JSON.parse(dataResult);
							if(dataResult.statusCode == 200){
								Swal.fire('Success', dataResult.psn, 'success').then((result) => {
									location.reload();
								});
							} else {
								Swal.fire('Error', dataResult.psn, 'error');
							}
						}
					});
				}
				});
			}
		</script>
		<!-- Google Tag Manager (noscript) -->
		<noscript ><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-NXZMQSS" height="0" width="0" style="display: none; visibility: hidden" ></iframe></noscript>
		<!-- End Google Tag Manager (noscript) -->
	</body>
</html>


