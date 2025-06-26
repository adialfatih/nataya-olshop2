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
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.10.0/dist/sweetalert2.all.min.js" integrity="sha256-IW9RTty6djbi3+dyypxajC14pE6ZrP53DLfY9w40Xn4=" crossorigin="anonymous"></script>
		<script>
			
			<?php if($showTable=="produkKeluar"){ ?>
			function loadDataTable(tgl,tipe,nama){
				$('#tableBody').html('Loading data...');
				$.ajax({
					url:"<?=base_url('showtable/showprodukKeluar');?>",
					type: "POST",
					data: {"tgl":tgl,"tipe":tipe,"nama":nama},
					cache: false,
					success: function(dataResult){
						if ($.fn.DataTable.isDataTable('#table1')) {
							$('#table1').DataTable().destroy();
						}
						$('#tableBody').html(dataResult);
						$('#table1').DataTable();
					}
				});
				$.ajax({
					url:"<?=base_url('showtable/showprodukKeluar2');?>",
					type: "POST",
					data: {"tgl":tgl,"tipe":tipe,"nama":nama},
					cache: false,
					success: function(dataResult){
						$('#paragraphShow').html(dataResult);
					}
				});
			}
			loadDataTable('null','null','null');
			function lookData(){
				var tipe = document.getElementById('kategori90').value;
				var nama = document.getElementById('autoComplete').value;
				var tgl = document.getElementById('thisTegel').value;
				loadDataTable(tgl,tipe,nama);
			}
			<?php } if($showTable=="produkMasuk"){?>
			function loadDataTable(nama,tgl){
				$('#tableBody').html('Loading data...');
				$.ajax({
					url:"<?=base_url('showtable/showprodukmasuk');?>",
					type: "POST",
					data: {"nama":nama,"tgl":tgl},
					cache: false,
					success: function(dataResult){
						if ($.fn.DataTable.isDataTable('#table1')) {
							$('#table1').DataTable().destroy();
						}
						$('#tableBody').html(dataResult);
						$('#table1').DataTable();
					}
				});
				$.ajax({
					url:"<?=base_url('showtable/showprodukmasuk2');?>",
					type: "POST",
					data: {"nama":nama,"tgl":tgl},
					cache: false,
					success: function(dataResult){
						$('#paragraphShow').html(dataResult);
					}
				});
			}
			loadDataTable('null','null');
			function lookData(){
				var nama = document.getElementById('autoComplete').value;
				var tgl = document.getElementById('thisTegel').value;
				loadDataTable(nama,tgl);
			}
			<?php } ?>

			
			const autoCompleteJS = new autoComplete({
                placeHolder: "Ketikan Nama ",
                data: {
                    src: ["tes","tes2"],
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