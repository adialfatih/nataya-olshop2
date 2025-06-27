<script src="<?=base_url('assets/');?>vendors/scripts/core.js"></script>
<script src="<?=base_url('assets/');?>vendors/scripts/script.min.js"></script>
<script src="<?=base_url('assets/');?>vendors/scripts/process.js"></script>
<script src="<?=base_url('assets/');?>vendors/scripts/layout-settings.js"></script>
<script src="<?=base_url('assets/');?>src/plugins/datatables/js/jquery.dataTables.min.js"></script>
<script src="<?=base_url('assets/');?>src/plugins/datatables/js/dataTables.bootstrap4.min.js"></script>
<script src="<?=base_url('assets/');?>src/plugins/datatables/js/dataTables.responsive.min.js"></script>
<script src="<?=base_url('assets/');?>src/plugins/datatables/js/responsive.bootstrap4.min.js"></script>
<script src="<?=base_url('assets2/');?>autoComplete.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.10.0/dist/sweetalert2.all.min.js" integrity="sha256-IW9RTty6djbi3+dyypxajC14pE6ZrP53DLfY9w40Xn4=" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/autonumeric@4.6.0"></script>
		<script>
			<?php
			$stok = $this->db->query("SELECT nama_produk FROM data_produk ORDER BY nama_produk ASC");
			$ar = array();
			foreach($stok->result() as $st){
				$ds = '"'.$st->nama_produk.'"';
				$ar[] = $ds;
			}
			$stok_im = implode(",",$ar);
			?>
				const autoCompleteJS = new autoComplete({
                placeHolder: "Ketik Nama Produk",
                data: { src: [<?=$stok_im;?>], cache: true, },
                resultItem: { highlight: true  },
                events: {
                    input: {
                        selection: (event) => {
                            const selection = event.detail.selection.value;
                            autoCompleteJS.input.value = selection;
                            $('#modelSelect').html('<option value="">Loading...</option>');
                            $.ajax({
								url:"<?=base_url();?>newtable/showmodel",
								type: "POST",
								data: {"id" : selection},
									cache: false,
									success: function(dataResult){
                                        //console.log(dataResult);
										let options = '';
                                        options += `<option value="all">Semua</option>`;
                                        let data = JSON.parse(dataResult);
                                        data.forEach(item => {
                                            options += `<option value="${item.kode_bar}">${item.warna_model}</option>`;
                                        });
                                        $('#modelSelect').html(options);
									}
							});
                        }
                    }
                }
            });
			
			
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
            function loadTableHarga(){
                var produk = $('#autoComplete').val();
                var model = $('#modelSelect').val();
                console.log(model);
                console.log(produk);
                $('#tableHargaBody').html('<tr><td colspan="6"><div style="width:100%;display:flex;justify-content:center;align-items:center"><div class="loader"></div></div></td></tr>');
                $.ajax({
					url:"<?=base_url();?>newtable/tampilkanproduk",
					type: "POST",
					data: {"produk" : produk, "model" : model},
					cache: false,
					success: function(dataResult){
                        setTimeout(() => {
                            $('#tableHargaBody').html(dataResult);
                        }, 200);
					}
				});
            }
            $(document).on('click', '.harga-produk, .harga-jual', function() {
                const id = $(this).data('id');
                const tipe = $(this).data('tipe'); // 'produk' atau 'jual'
                const hargaAwal = $(this).data('harga');

                Swal.fire({
                    title: 'Update Harga',
                    html: '<input id="hargaInput" class="swal2-input" placeholder="Harga">',
                    showCancelButton: true,
                    confirmButtonText: 'Update',
                    didOpen: () => {
                        const input = document.getElementById('hargaInput');
                        input.value = hargaAwal;

                        // Terapkan AutoNumeric
                        new AutoNumeric(input, {
                            digitGroupSeparator: '.',
                            decimalCharacter: ',',
                            decimalPlaces: 0,
                            unformatOnSubmit: true
                        });
                    },
                    preConfirm: () => {
                        const rawValue = AutoNumeric.getNumber('#hargaInput');
                        if (!rawValue || isNaN(rawValue)) {
                            Swal.showValidationMessage('Masukkan harga yang valid');
                            return false;
                        }
                        return rawValue;
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        const hargaBaru = result.value;
                        // Kirim AJAX update ke server
                        $.post("<?= base_url('newtable/update_harga') ?>", {
                            id: id,
                            tipe: tipe,
                            harga: hargaBaru
                        }, function(res) {
                            Swal.fire('Berhasil!', 'Harga berhasil diperbarui.', 'success')
                                .then(() => {
                                    loadTableHarga();
                                });
                        });
                    }
                });
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