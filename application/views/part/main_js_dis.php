<script src="<?=base_url('assets/');?>vendors/scripts/core.js"></script>
		<script src="<?=base_url('assets/');?>vendors/scripts/script.min.js"></script>
		<script src="<?=base_url('assets/');?>vendors/scripts/process.js"></script>
		<script src="<?=base_url('assets/');?>vendors/scripts/layout-settings.js"></script>
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
            function copythis(url) {
                navigator.clipboard.writeText(url)
                    .then(() => Swal.fire({title: "Good job!",text: "URL copied to clipboard",icon: "success"}))
                    .catch(err => Swal.fire({title: "Sorry",text: "URL could not be copied",icon: "error"}));
            }
		</script>
		<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-NXZMQSS" height="0" width="0" style="display: none; visibility: hidden"></iframe></noscript>
	</body>
</html>