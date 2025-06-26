<script src="<?=base_url('assets/');?>vendors/scripts/core.js"></script>
		<script src="<?=base_url('assets/');?>vendors/scripts/script.min.js"></script>
		<script src="<?=base_url('assets/');?>vendors/scripts/process.js"></script>
		<script src="<?=base_url('assets/');?>vendors/scripts/layout-settings.js"></script>
		<!-- switchery js -->
		<script src="<?=base_url('assets/');?>src/plugins/switchery/switchery.min.js"></script>
		<!-- bootstrap-tagsinput js -->
		<script src="<?=base_url('assets/');?>src/plugins/bootstrap-tagsinput/bootstrap-tagsinput.js"></script>
		<!-- bootstrap-touchspin js -->
		<script src="<?=base_url('assets/');?>src/plugins/bootstrap-touchspin/jquery.bootstrap-touchspin.js"></script>
		<script src="<?=base_url('assets/');?>vendors/scripts/advanced-components.js"></script>
		<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.10.0/dist/sweetalert2.all.min.js" integrity="sha256-IW9RTty6djbi3+dyypxajC14pE6ZrP53DLfY9w40Xn4=" crossorigin="anonymous"></script>
		<script>
			$(document).ready(function() {
			let offset = 0;
			const limit = 100;
			let loading = false;
			var baseurl = "<?=base_url();?>";
			function loadData() {
				if (loading) return;
					loading = true;
					$.ajax({
						url: '<?=base_url('prosesajax/loadcash');?>',
						type: 'GET',
						data: { offset: offset, limit: limit },
						dataType: 'json',
						success: function(response) {
							let rows = '';
							$.each(response.data, function(index, item) {
								if(item.ket == 'SALDO AWAL'){
									rows += `<tr>
									<td>${offset + index + 1}</td>
									<td><span class="badge badge-success"> <i class="icon-copy bi bi-arrow-down-short"></i> Masuk </span></td>
									<td>Rp. ${item.jumlah}</td>
									<td>${item.tgl}</td>
									<td>${item.waktu}</td>
									<td>${item.ket}</td>
									<td></td>
								</tr>`;
								} else {
								if(item.alur == "in"){
								rows += `<tr>
									<td>${offset + index + 1}</td>
									<td><span class="badge badge-success"> <i class="icon-copy bi bi-arrow-down-short"></i> Masuk </span></td>
									<td>Rp. ${item.jumlah}</td>
									<td>${item.tgl}</td>
									<td>${item.waktu}</td>
									<td>${item.ket}</td>
									<td>
										<div class="dropdown">
                                            <a class="btn btn-link font-24 p-0 line-height-1 no-arrow dropdown-toggle" href="#" role="button" data-toggle="dropdown">
                                                <i class="dw dw-more"></i>
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-right dropdown-menu-icon-list">
                                            	<a class="dropdown-item" href="${baseurl}redirecting/${item.codeinput}/${item.ket}" target="_blank">
                                                        <i class="dw dw-view"></i> View
                                                </a>
                                                <a class="dropdown-item" href="javascript:void(0);" onclick="deletesaldo('${item.codeinput}','${item.ket}')">
                                                        <i class="dw dw-trash" style="color:#c90e0e;"></i> Delete
                                                </a>
                                            </div>
                                        </div>
                                    </td>
								</tr>`;
								} else {
									rows += `<tr>
									<td>${offset + index + 1}</td>
									<td><span class="badge badge-danger"> <i class="icon-copy bi bi-arrow-up-short"></i> Keluar </span></td>
									<td>Rp. ${item.jumlah}</td>
									<td>${item.tgl}</td>
									<td>${item.waktu}</td>
									<td>${item.ket}</td>
									<td>
										<div class="dropdown">
                                            <a class="btn btn-link font-24 p-0 line-height-1 no-arrow dropdown-toggle" href="#" role="button" data-toggle="dropdown">
                                                <i class="dw dw-more"></i>
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-right dropdown-menu-icon-list">
                                            	<a class="dropdown-item" href="${baseurl}redirecting/${item.codeinput}/${item.ket}" target="_blank">
                                                        <i class="dw dw-view"></i> View
                                                </a>
                                                <a class="dropdown-item" href="javascript:void(0);" onclick="deletesaldo('${item.codeinput}','${item.ket}')">
                                                        <i class="dw dw-trash" style="color:#c90e0e;"></i> Delete
                                                </a>
                                            </div>
                                        </div>
                                    </td>
								</tr>`;
								}
								}
							});
							
							$('#showData').append(rows);
							offset += limit;
							loading = false;
						},
						error: function() {
							loading = false;
						}
					});
			}
			loadData();
			$(window).scroll(function() {
				if ($(window).scrollTop() + $(window).height() >= $(document).height()) {
					loadData(); // Muat lebih banyak data
				}
			});
		});
		function deletesaldo(id,tipe){
			Swal.fire({
				title: "Hapus Data",
				text: "Apakah Anda yakin ingin menghapus data ini?",
				icon: "warning",
				showCancelButton: true,
				confirmButtonColor: "#3085d6",
				cancelButtonColor: "#d33",
				confirmButtonText: "Ya, Hapus"
			}).then((result) => {
				if (result.isConfirmed) {
					$.ajax({
						url:"prosesajax/deletesaldo",	
						type: "POST",
						data: {"id" : id, "tipe" : tipe},
						cache: false,
						success: function(dataResult){
							Swal.fire({
								title: "Berhasil",
								text: "Berhasil menghapus data",
								icon: "success"
							}).then(function(){
								location.reload();
							})
						}
			})}})
		}
			const simpandataflow = document.getElementById("simpandataflow");

			// Fungsi untuk menangani klik pada DANA MASUK
			simpandataflow.addEventListener("click", function() {
				var tipe = document.getElementById("idtipe234").value;
				var tgl = document.getElementById("tgl567").value;
				var nominal = document.getElementById("nilai2356").value;
				var ket = document.getElementById("ket24558").value;
				if(tipe!="" && tgl!="" && nominal!="" && ket!=""){
					$('#modalBodyid45').html('<div style="width:100%;height:100px;display:flex;justify-content:center;align-items:center;"><div class="loader"></div></div>');
					$.ajax({
						url:"prosesajax/inputflowcash",
						type: "POST",
						data: {"tipe" : tipe, "tgl" : tgl, "nominal" : nominal, "ket" : ket},
						cache: false,
						success: function(dataResult){
							setTimeout(() => {
								Swal.fire({
									title: "Berhasil",
									text: "Data berhasil disimpan",
									icon: "success"
								}).then(function(){
									location.reload();
								})
							}, 1000);
						}
					});
				} else {
					Swal.fire('Peringatan...!!!','Anda harus mengisi semua data dengan benar!!', 'error');
				}
			});
			
		</script>
		<!-- Google Tag Manager (noscript) -->
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
