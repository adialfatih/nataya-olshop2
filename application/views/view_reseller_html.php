<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Tagihan</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }
        body {
            background-color: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 10px;
            position: relative;
        }
        .container {
            width: 100%;
            max-width: 500px;
            background: white;
            padding: 10px;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            overflow: auto;
        }
        .table-container {
            min-height: 400px;
            overflow: auto;
            border: 1px solid #ddd;
            scrollbar-width: thin;
            scrollbar-color: #ccc transparent;
            white-space: nowrap;
        }
        table.table {
            width: 100%;
            border-collapse: collapse;
            min-width: 600px;
        }
        table.table th, td {
            padding: 8px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        table.table th {
            background: #007BFF;
            color: white;
            position: sticky;
            top: 0;
            z-index: 1;
        }
        .badge {
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: bold;
            display: inline-block;
        }
        .badge-lunas {
            background-color: #28a745;
            color: white;
        }
        .badge-belum {
            background-color: #dc3545;
            color: white;
        }
        .loading-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(255, 255, 255, 0.8);
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: 20px;
            font-weight: bold;
            color: #007BFF;
        }
/* HTML: <div class="loader"></div> */
.loader {
  width: 50px;
  aspect-ratio: 1;
  border-radius: 50%;
  border: 8px solid #0000;
  border-right-color: #ffa50097;
  position: relative;
  animation: l24 1s infinite linear;
}
.loader:before,
.loader:after {
  content: "";
  position: absolute;
  inset: -8px;
  border-radius: 50%;
  border: inherit;
  animation: inherit;
  animation-duration: 2s;
}
.loader:after {
  animation-duration: 4s;
}
@keyframes l24 {
  100% {transform: rotate(1turn)}
}
/* Style for the modal background */
.modal {
    display: none; /* Hidden by default */
    position: fixed; /* Stay in place */
    left: 0;
    top: 0;
    width: 100%; /* Full width */
    height: 100%; /* Full height */
    overflow: auto; /* Enable scroll if needed */
    background-color: rgba(0, 0, 0, 0.5); /* Black w/ opacity */
    z-index: 1; /* Sit on top */
    animation: fadeIn 0.3s ease-in-out;
    padding:10px;
}

/* Modal Content */
.modal-content {
    background-color: #fefefe;
    margin: 15% auto; /* 15% from the top and centered */
    padding: 20px 10px;
    border: 1px solid #888;
    border-radius: 10px;
    width: 100%;
    animation: slideIn 0.3s ease-in-out;
    display: flex;
    flex-direction: column;
    align-items: center;
}

/* The Close Button */
.close {
    color: #aaa;
    float: right;
    font-size: 28px;
    font-weight: bold;
}

.close:hover,
.close:focus {
    color: black;
    text-decoration: none;
    cursor: pointer;
}

/* Keyframes for fadeIn animation */
@keyframes fadeIn {
    from {
        opacity: 0;
    }
    to {
        opacity: 1;
    }
}

/* Keyframes for slideIn animation */
@keyframes slideIn {
    from {
        transform: translateY(-50px);
        opacity: 0;
    }
    to {
        transform: translateY(0);
        opacity: 1;
    }
}
    </style>
</head>
<body>
    <?php
    $uri = $this->uri->segment(4);
    $id_res = intval($uri) - 98761;
    $cek_res = $this->data_model->get_byid('data_reseller', ['sha1(id_res)'=>$uri]);
    if($cek_res->num_rows() == 1){
    $nama_res = $cek_res->row('nama_reseller');
    $id_res2 = $cek_res->row('id_res');
    $ary = $this->db->query("SELECT SUM(nilai_tagihan) AS jml FROM stok_produk_keluar WHERE nama_tujuan='$nama_res' AND tujuan='Reseller'")->row("jml");
    $nilai_bayar = $this->db->query("SELECT SUM(nominal) AS jml FROM hutang_reseller_bayar WHERE id_res='$id_res2'")->row("jml");
    $outstanding = floatval($ary) - floatval($nilai_bayar);
    $outstanding = number_format($outstanding,0,",",".");
    ?>
    <div class="loading-overlay" id="loading"><div class="loader"></div></div>
    <div class="container" style="display: none;" id="content">
        <h2 style="text-align: center; margin-bottom: 10px;">Data Tagihan</h2>
        Nama Reseller : <strong><?=$nama_res;?></strong><br>
        Outstanding : <strong>Rp. <?=$outstanding;?></strong><hr><br>
        <div class="table-container">
            <table class="table">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>No SJ</th>
                        <th>Tanggal SJ</th>
                        <th>Nilai Tagihan</th>
                        <th>Jumlah Bayar</th>
                        <th>Sisa Tagihan</th>
                        <th>Status</th>
                        <th>#</th>
                    </tr>
                </thead>
                <tbody id="data-body">
                    <!-- Data akan diisi dengan JavaScript -->
                </tbody>
            </table>
        </div>
    </div>
    <?php
    } else {
        ?>
        <div style="width:100%;display:flex;align-items:center;justify-content:center;flex-direction:column;height:100vh;gap:20px;">
            <img src="<?=base_url('assets/tes.gif');?>" alt="Access Denied">
            <span>Anda tidak diperbolehkan mengakses halaman ini..!!</span>
        </div>
        <?php
       
    }?>

    <!-- The Modal -->
    <div id="myModal" class="modal">
      <!-- Modal content -->
      <div class="modal-content" id="modalIsi">
          <div class="loader"></div>
          Please Wait...
      </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script>
        function loadData() {
            fetch('<?=base_url('reseller2/loadData/'.$uri);?>')
                .then(response => response.json())
                .then(data => {
                    const tableBody = document.getElementById("data-body");
                    tableBody.innerHTML = '';
                    console.table(data);
                    data.forEach(item => {
                        let row = `<tr>
                            <td>${item.no}</td>
                            <td><a style="color:red;text-decoration:none;" onclick="openModal('${item.no_sj}')">${item.no_sj}</a></td>
                            <td>${item.tgl}</td>
                            <td>Rp ${item.nilai_tagihan}</td>
                            <td>Rp ${item.jml_bayar}</td>
                            <td>Rp ${item.jml_sisa}</td>
                            <td><span class="badge ${item.lunas === 'Lunas' ? 'badge-lunas' : 'badge-belum'}">${item.lunas}</span></td>
                            <td><span style='padding:5px 10px;font-size:10px;background-color:#f57520;color:white;border-radius:3px;' onclick="openModalHide('${item.no_sj}','<?=$uri;?>')">Hide</span></td>
                        </tr>`;
                        tableBody.innerHTML += row;
                    });
                    document.getElementById("loading").style.display = "none";
                    document.getElementById("content").style.display = "block";
                    console.log('sampai this');
                })
                .catch(error => console.error('Error:', error));
        }
        //loadData();
        // function loadData() {
        //     const tableBody = document.getElementById("data-body");
        //     data.forEach(item => {
        //         let row = `<tr>
        //             <td>${item.noSJ}</td>
        //             <td>${item.tanggal}</td>
        //             <td>Rp ${item.nilai.toLocaleString()}</td>
        //             <td>Rp ${item.bayar.toLocaleString()}</td>
        //             <td>Rp ${item.sisa.toLocaleString()}</td>
        //             <td><span class="badge ${item.status === 'Lunas' ? 'badge-lunas' : 'badge-belum'}">${item.status}</span></td>
        //         </tr>`;
        //         tableBody.innerHTML += row;
        //     });
        // }

        document.addEventListener("DOMContentLoaded", () => {
            setTimeout(() => {
                document.getElementById("loading").style.display = "none";
                document.getElementById("content").style.display = "block";
                loadData();
            }, 1500);
        });
        function openModal(id) { 
            $('#modalIsi').html('<div class="loader"></div><br>Please Wait...');
            modal.style.display = "block"; 
            $.ajax({
				url:"<?=base_url();?>reseller2/showAllSJ",
				type: "POST",
				data: {"id" : id},
				cache: false,
				success: function(dataResult){
                    setTimeout(() => {
                        $('#modalIsi').html(dataResult);
                    }, 1200);
				}
			});
           
        }
        //function openModalHide(sj,id)
        var modal = document.getElementById("myModal");
        function closeModal() { modal.style.display = "none"; }
        



        // When the user clicks anywhere outside of the modal, close it
        window.onclick = function(event) {
            if (event.target == modal) {
                modal.style.display = "none";
            }
        }
    </script>
</body>
</html>
