<script src="<?=base_url('assets/');?>vendors/scripts/core.js"></script>
		<script src="<?=base_url('assets/');?>vendors/scripts/script.min.js"></script>
		<script src="<?=base_url('assets/');?>vendors/scripts/process.js"></script>
		<script src="<?=base_url('assets/');?>vendors/scripts/layout-settings.js"></script>
		<script src="<?=base_url('assets/');?>src/plugins/datatables/js/jquery.dataTables.min.js"></script>
		<script src="<?=base_url('assets/');?>src/plugins/datatables/js/dataTables.bootstrap4.min.js"></script>
		<script src="<?=base_url('assets/');?>src/plugins/datatables/js/dataTables.responsive.min.js"></script>
		<script src="<?=base_url('assets/');?>src/plugins/datatables/js/responsive.bootstrap4.min.js"></script>
		<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
		<script src="<?=base_url('assets2/');?>autoComplete.min.js"></script>
		<?php if($daterange == "one"){ ?>
			<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
			<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
			<script>$('input[name="dates"]').daterangepicker();</script>
		<?php } ?>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.10.0/dist/sweetalert2.all.min.js" integrity="sha256-IW9RTty6djbi3+dyypxajC14pE6ZrP53DLfY9w40Xn4=" crossorigin="anonymous"></script>
		<script>
			<?php if($autocomplet=="stok"){ 
			$stok = $this->db->query("SELECT nama_produk FROM data_produk ORDER BY nama_produk ASC");
			$ar = array();
			foreach($stok->result() as $st){
				$ds = '"'.$st->nama_produk.'"';
				$ar[] = $ds;
			}
			$stok_im = implode(",",$ar);
			?>
				const autoCompleteJS = new autoComplete({
                placeHolder: "Ketik dan Pilih Produk",
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
                            
                        }
                    }
                }
            });
			<?php } if($autocomplet=="addkain"){ 
			$stok = $this->db->query("SELECT DISTINCT kode_kain FROM stok_kain WHERE id_kain='$drow2' ORDER BY kode_kain ASC");
			$ar = array();
			foreach($stok->result() as $st){
				$ds = '"'.$st->kode_kain.'"';
				$ar[] = $ds;
			}
			$stok_im = implode(",",$ar);
			?>
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
                            $.ajax({
								url:"<?=base_url();?>prosesajax/shodnamakain",
								type: "POST",
								data: {"id" : selection},
									cache: false,
									success: function(dataResult){
										$('#namakain').val(''+dataResult);
									}
							});
                        }
                    }
                }
            });
			<?php } if($autocomplet=="sendkain"){ 
			$stok = $this->db->query("SELECT DISTINCT kode_kain,total_panjang  FROM stok_kain WHERE id_kain='$drow2' ORDER BY kode_kain ASC");
			$ar = array();
			foreach($stok->result() as $st){
				$ds = '"'.$st->kode_kain.','.$st->total_panjang.'"';
				$ar[] = $ds;
			}
			$stok_im = implode(",",$ar);
			?>
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
                            $.ajax({
								url:"<?=base_url();?>prosesajax/shodnamakain2",
								type: "POST",
								data: {"id" : selection},
									cache: false,
									success: function(dataResult){
										var dataResult = JSON.parse(dataResult);
										if(dataResult.statusCode == 200){
											$('#namakain').val(''+dataResult.nama);
											$('#jmlroll').val(''+dataResult.jumlah_kain);
											$('#jmlroll2').val(''+dataResult.jumlah_kain);
											$('#totalpanjang').val(''+dataResult.ukuran+' '+dataResult.satuan);
										} else {
											$('#namakain').val('');
											$('#jmlroll').val('');
											$('#jmlroll2').val('');
											$('#totalpanjang').val('');
										}
									}
							});
                        }
                    }
                }
            });
			var cd = document.getElementById('codeinputID').value;
			function loadSendKain(id){
				$.ajax({
					url:"<?=base_url();?>prosesajax/showSendKainData",
					type: "POST",
					data: {"id" : id},
					cache: false,
					success: function(dataResult){
						$('#trBody').html(dataResult);
					}
				});
			}
			loadSendKain(cd);
			function loadSendKain2(id){
				$.ajax({
					url:"<?=base_url();?>prosesajax/showSendKainData2",
					type: "POST",
					data: {"id" : id},
					cache: false,
					success: function(dataResult){
						$('#idbody23').html(dataResult);
					}
				});
			}
			loadSendKain2(cd);
			function tambahkanExtras(){
				var id = document.getElementById('codeinputID').value;
				var extr = document.getElementById('nmBarangEx').value;
				var pcs = document.getElementById('jmlBarangEx').value;
				if(extr!="" && pcs!=""){
				$.ajax({
					url:"<?=base_url();?>prosesajax/showSendKainData3",
					type: "POST",
					data: {"id" : id, "extr":extr, "pcs":pcs},
					cache: false,
					success: function(dataResult){
						loadSendKain2(id);
						document.getElementById('nmBarangEx').value = '';
						document.getElementById('jmlBarangEx').value = '';
					}
				});
				} else {
					Swal.fire({ title: "Info!", text: "Anda harus mengisi nama barang dan jumlah", icon: "warning" });
				}
			}
			function hapusKiriman(id){
				Swal.fire({
				title: "Hapus Kiriman?",
				text: "Anda akan menghapus Kiriman ini?",
				icon: "warning",
				showCancelButton: true,
				confirmButtonColor: "#3085d6",
				cancelButtonColor: "#d33",
				confirmButtonText: "Hapus"
				}).then((result) => {
				if (result.isConfirmed) {
					$.ajax({
						url:"<?=base_url();?>prosesajax/hapusKiriman",
						type: "POST",
						data: {"id" : id},
							cache: false,
							success: function(dataResult){
								var dataResult = JSON.parse(dataResult);
								if(dataResult.statusCode == 200){
									Swal.fire({
										title: "Berhasil!",
										text: "Data berhasil dihapus",
										icon: "success"
									}).then((result) => {
										location.href = "<?=base_url('data-kain/pengiriman');?>";
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
				}
				});
			}
			function tambahkanNotes(){
				var id = document.getElementById('codeinputID').value;
				var idproduk = document.getElementById('tw2').value;
				var model = document.getElementById('tw3').value;
				var ukr = document.getElementById('tw4').value;
				var jumlah = document.getElementById('tw5').value;
				var databenar = "1";
				if(idproduk!="" && model!="" && ukr!="" && jumlah!=""){
					var ukuranArray = ukr.split(',');
					var jumlahArray = jumlah.split(',');
					if (ukuranArray.length !== jumlahArray.length) {
						Swal.fire({ title: "Info!", text: "Jumlah ukuran dan jumlah harus sama!", icon: "warning" });
						var databenar = "0";
						return false;
					}
					// Ensure every jumlah is a number
					for (var i = 0; i < jumlahArray.length; i++) {
						if (isNaN(jumlahArray[i]) || jumlahArray[i].trim() === '') {
							Swal.fire({ title: "Info!", text: "Setiap jumlah harus berupa angka valid!", icon: "warning" });
							var databenar = "0";
							return false;
						}
					}

					$.ajax({
						url:"<?=base_url();?>prosesajax/sendnotes",
						type: "POST",
						data: {"id":id,"databenar" : databenar, "idproduk" : idproduk, "model" : model, "ukr" : ukr, "jumlah" : jumlah},
						cache: false,
						success: function(dataResult){
							var dataResult = JSON.parse(dataResult);
							if(dataResult.statusCode == 200){
								loadbodyNotes(id);
								document.getElementById('tw2').value = '';
								document.getElementById('tw3').value = '';
								document.getElementById('tw4').value = '';
								document.getElementById('tw5').value = '';
							} else {
								Swal.fire({
									title: "Gagal!",
									text: ""+dataResult.psn+"",
									icon: "error"
								});
							}
						}
					});
					//alert('Validasi berhasil!');
					return true;
				} else {
					Swal.fire({ title: "Info!", text: "Anda harus mengisi semua data", icon: "warning" });
				}
			}
			function loadbodyNotes(id){
				$.ajax({
					url:"<?=base_url();?>prosesajax/showNotes",
					type: "POST",
					data: {"id" : id},
					cache: false,
					success: function(dataResult){
						$('#idbody78').html(dataResult);
					}
				});
			}
			function notes(id){
				$.ajax({
					url:"<?=base_url();?>prosesajax/cariNotes",
					type: "POST",
					data: {"id" : id},
					cache: false,
					success: function(dataResult){
						var dataResult = JSON.parse(dataResult);
						if(dataResult.statusCode == 200){
							if(dataResult.nb == "null"){
								$('#notes').html('');
								$('#idnts').val(''+id);
							} else {
								$('#notes').html(''+dataResult.nb+'');
								$('#idnts').val(''+id);
							}
							
						}
					}
				});
			}
			loadbodyNotes(cd);
			function delnotes(id){
				$.ajax({
					url:"<?=base_url();?>prosesajax/delNotes",
					type: "POST",
					data: {"id" : id},
					cache: false,
					success: function(dataResult){
						loadbodyNotes(cd);
					}
				});
			}
			<?php } ?>
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
			function showKategori(id,kat){
				document.getElementById('bodyTable').innerHTML = '<tr><td colspan="6"><div style="width:100%;display:flex;justify-content:center;align-items:center;"><div class="loader"></div></div></td></tr><tr><td colspan="6" style="text-align:center;color:#737373;">Memuat kategori '+kat+'....</td></tr>';
				$.ajax({
						url:"<?=base_url();?>prosesajax/showKategori",
						type: "POST",
						data: {"id" : id, "kat" : kat},
							cache: false,
							success: function(dataResult){
								setTimeout(() => {
									document.getElementById('bodyTable').innerHTML = dataResult;
									document.getElementById('idShowKategori').innerHTML = ''+kat;
								}, 1200);
							}
				});
			}
			function ambilsatua2n(val){
				//Swal.fire('tes'+val);
				$.ajax({
						url:"<?=base_url();?>prosesajax/ambilkain",
						type: "POST",
						data: {"id" : val},
							cache: false,
							success: function(dataResult){
								var dataResult = JSON.parse(dataResult);
								if(dataResult.statusCode == 200){
									$('#idjumlahText').html('Jumlah '+dataResult.satuan);
									$('#hargaKainid').html('Harga /'+dataResult.satuan);
									document.getElementById('jumlah').disabled = false;
									document.getElementById('roll').disabled = false;
									document.getElementById('dari').disabled = false;
									document.getElementById('hargabeli').disabled = false;
								} else {
									$('#idjumlahText').html('Jumlah');
									$('#hargaKainid').html('Harga Kain');
									document.getElementById('jumlah').disabled = true;
									document.getElementById('jumlah').value = '';
									document.getElementById('roll').disabled = true;
									document.getElementById('roll').value = '';
									document.getElementById('dari').disabled = true;
									document.getElementById('hargabeli').disabled = true;
									document.getElementById('dari').value = '';
									document.getElementById('hargabeli').value = '';
									document.getElementById('hargakain').value = '';
									
									
								}
							}
				});
			}
			function formatAngka(input) {
				let value = input.value.replace(/\D/g, '');
				value = value.replace(/\B(?=(\d{3})+(?!\d))/g, '.');
				input.value = value;
			}
			function showKategoriRightClick(event, id, kategori, desk) {
				event.preventDefault(); // Mencegah menu klik kanan browser tampil
				//Swal.fire("Klik Kanan:", id, kategori);
				// Set posisi menu konteks pada kursor
				const contextMenu = document.getElementById('contextMenu');
				contextMenu.style.top = `${event.pageY}px`;
				contextMenu.style.left = `${event.pageX}px`;
				contextMenu.style.display = 'block';

				// Tetapkan aksi 'Edit' dan 'Hapus' dengan data kategori yang benar
				contextMenu.querySelector('.dropdown-item:nth-child(1)').setAttribute('onclick', `editKategori('${id}', '${kategori}', '${desk}')`);
				contextMenu.querySelector('.dropdown-item:nth-child(2)').setAttribute('onclick', `hapusKategori('${id}', '${kategori}')`);
			}
			document.addEventListener('click', function(event) {
				const contextMenu = document.getElementById('contextMenu');
				if (contextMenu.style.display === 'block' && !contextMenu.contains(event.target)) {
					contextMenu.style.display = 'none';
				}
			});
			function editKategori(id, kategori, desk) {
				const contextMenu = document.getElementById('contextMenu');
				contextMenu.style.display = 'none';
				document.getElementById('kat').value = ''+kategori;
				if(desk=="null"){
					document.getElementById('keterangan').value = '';
				} else {
					document.getElementById('keterangan').value = ''+desk;
				}
				
				document.getElementById('idtipe').value = ''+id;
				$('#modals').modal('show');
			}
			function clearModals(){
				document.getElementById('kat').value = '';
				document.getElementById('keterangan').value = '';
				document.getElementById('idtipe').value = '0';
			}
			function hapusKategori(id, kategori) {
				const contextMenu = document.getElementById('contextMenu');
				contextMenu.style.display = 'none';
				del('Kategori', id, kategori);
			}
			function validateFile(tipe) {
				var fileInput = document.getElementById('upload');
				var filePath = fileInput.value;
				var maxFileSize = 5 * 1024 * 1024;
				if(tipe=='image'){
					var allowedExtensions = /(\.png|\.jpg|\.jpeg)$/i;
					var txtx = 'Hanya file dengan format PNG dan JPG.';
				} else {
					var allowedExtensions = /(\.png|\.jpg|\.jpeg|\.doc|\.docx|\.xls|\.xlsx|\.pdf)$/i;
					var txtx = 'Hanya file dengan format PNG, JPG, DOC, XLSX, atau PDF yang diperbolehkan.';
				}

				if (!allowedExtensions.exec(filePath)) {
					Swal.fire({
						icon: 'error',
						title: 'Format File Tidak Sesuai!',
						text: ''+txtx+'',
					});
					// Hapus nilai input file
					fileInput.value = '';
					return false;
				}
				if (fileInput.files[0].size > maxFileSize) {
					Swal.fire({
						icon: 'error',
						title: 'Ukuran File Terlalu Besar!',
						text: 'File tidak boleh lebih dari 2MB.',
					});
					// Hapus nilai input file
					fileInput.value = '';
					return false;
				}
			}
			function notif(ic,txt){
				Swal.fire({
					icon: ''+ic+'',
					title: ''+ic+'!',
					text: ''+txt+'',
				});
			}
            function peringatan(txt) {
                Toastify({
                    text: ""+txt+"",
                    duration: 4000,
                    close:true,
                    gravity:"bottom",
                    position: "right",
                    backgroundColor: "#cc214e",
                }).showToast();
            }
            function suksestoast(txt){
                Toastify({
                    text: ""+txt+"",
                    duration: 3000,
                    close:true,
                    gravity:"bottom",
                    position: "right",
                    backgroundColor: "#4fbe87",
                }).showToast();
            }
			document.addEventListener('keydown', function(event) {
				// Cek jika tombol yang ditekan adalah 'Escape' (keyCode 27)
				if (event.key === 'Escape' || event.keyCode === 27) {
					// Mengarahkan user ke halaman sebelumnya
					history.back();
				}
			});
			<?php if($showStok=="kain"){ ?>
			function loadKain(){
				document.getElementById('viewStokKain').innerHTML = '<tr><td colspan="5"><div style="width:100%;display:flex;justify-content:center;align-items:center;"><div class="loader"></div></div></td></tr>';
				$.ajax({
						url:"<?=BASE_URL();?>prosesajax/showDataKain",
						type: "POST",
						data: {"id" : "all"},
							cache: false,
							success: function(dataResult){
								setTimeout(() => {
									document.getElementById('viewStokKain').innerHTML = dataResult;
								}, 1000);
							}
				});
			}
			loadKain();
			function openViewKain(id){
				$('#bodyModalKain').html('<div style="width:100%;display:flex;justify-content:center;align-items:center;"><div class="loader"></div></div>');
				$.ajax({
						url:"prosesajax/showDataKainid",
						type: "POST",
						data: {"id" : id},
							cache: false,
							success: function(dataResult){
								setTimeout(() => {
									$('#bodyModalKain').html(dataResult);
								}, 1000);
							}
				});
			}
			function ambiljeniskain(id){
				$.ajax({
						url:"prosesajax/ambilStokKain",
						type: "POST",
						data: {"id" : id},
							cache: false,
							success: function(dataResult){
								var dataResult = JSON.parse(dataResult);
								if(dataResult.statusCode == 200){
									$('#jumlah2').val(''+dataResult.panjang);
									$('#roll2').val(''+dataResult.roll);
									$('#stokPanjang').val(''+dataResult.panjang);
									$('#stokRoll').val(''+dataResult.roll);
									$('#stokNilai').val(''+dataResult.nilai);
								} else {
									$('#jumlah2').val('0');
									$('#roll2').val('0');
									$('#stokPanjang').val('0');
									$('#stokRoll').val('0');
									$('#stokNilai').val('0');
								}
							}
				});
			}
			<?php } ?>
			$("#submitBtn").click(function() {
				var codeinput = $('#codeinputID').val();
				var codekain = $('#autoComplete').val();
				var jmlroll_stok = $('#jmlroll2').val();
				var jmlroll_kirim = $('#jmlroll').val();
				var namakain = $('#namakain').val();
				var pjgPerRoll = $('#totalpanjang').val();
				if(codeinput!="" && codekain!="" && jmlroll_stok!="" && jmlroll_kirim!=""){
					if(parseInt(jmlroll_kirim) <= parseInt(jmlroll_stok)){
					$.ajax({
						url:"<?=base_url();?>prosesajax/sendDataKain",
						type: "POST",
						data: {"codeinput" : codeinput, "codekain" : codekain, "jmlroll_stok" : jmlroll_stok, "jmlroll_kirim" : jmlroll_kirim, "namakain" : namakain, "pjgPerRoll" : pjgPerRoll},
							cache: false,
							success: function(dataResult){
								var dataResult = JSON.parse(dataResult);
								if(dataResult.statusCode == 200){
									$('#autoComplete').val('');
									$('#namakain').val('');
									$('#totalpanjang').val('');
									$('#jmlroll').val('');
									$('#jmlroll2').val('');
									Swal.fire({
										icon: 'success',
										title: 'Berhasil Menyimpan',
										text: ''+dataResult.psn+'',
									}).then((result) => {
										loadSendKain(codeinput);
									});
								} else {
									Swal.fire({
										icon: 'error',
										title: 'Gagal Menyimpan',
										text: ''+dataResult.psn+'',
									});
								}
							}
					});
					} else {
						Swal.fire({
							icon: 'error',
							title: 'Jumlah Roll Tidak Sesuai!',
							text: 'Pastikan jumlah roll kirim tidak lebih besar dari jumlah stok',
						});
					}
				} else {
					Swal.fire({
						icon: 'error',
						title: 'Data Tidak Lengkap!',
						text: 'Pastikan semua data sudah terisi!',
					});
				}
			});
			function viewBayar(id,name){
				$('#modalBodyid2345').html('<div style="width:100%;display:flex;justify-content:center;align-items:center;"><div class="loader"></div></div>');
				$('#myLargeModalLabel21455').html('Riwayat Pembayaran <small>'+name+'</small>');
				$.ajax({
					url:"<?=base_url();?>proses2/lihatbayar",
					type: "POST",
					data: {"id" : id, "name" : name},
					cache: false,
					success: function(dataResult){
						setTimeout(() => {
							$('#modalBodyid2345').html(dataResult);
						}, 1200);
						
					}
				});
			}
			function upBayar(id,nm,cn){
				document.getElementById('nmReseller').value = ''+nm;
				document.getElementById('idReseller').value = ''+id;
				console.log(nm);
				if(cn>0){
					$('#modals2').modal('show');
					$.ajax({
						url:"<?=base_url();?>proses2/lihatbayarSJ",
						type: "POST",
						data: {"id" : id, "name" : nm},
						cache: false,
						success: function(dataResult){
							var dataResult = JSON.parse(dataResult);
							var selectElement = $("#sjBayar");
							selectElement.empty();
							selectElement.append($('<option>', { value: '',text: 'Pilih Surat Jalan'}));
							selectElement.append($('<option>', { value: 'all',text: 'Semua Surat Jalan'}));
							$.each(dataResult.sj, function(index, value) {
								selectElement.append($('<option>', {
									value: value,   
									text: value
								}));
							});
						}
					});
				} else {
					Swal.fire('Tidak ada nota yang belum dibayar!');
				}
				
			}
			function cekbyrnominal(id){
				$.ajax({
					url:"<?=base_url();?>proses2/lihatnominalsj",
					type: "POST",
					data: {"id" : id},
					cache: false,
					success: function(dataResult){
						$('#jmlBayar').val(''+dataResult+'');
					}
				});
			}
			function copythis(text) {
				const textArea = document.createElement('textarea');
				textArea.value = text;
				document.body.appendChild(textArea);
				textArea.select();
				textArea.setSelectionRange(0, 99999); 
				document.execCommand('copy');
				document.body.removeChild(textArea);
				Swal.fire('Berhasil','Link berhasil di copy ke clipboard.!','success');
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