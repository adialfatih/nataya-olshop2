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
            height: 100vh;
            padding: 20px;
            position: relative;
        }
        .container {
            width: 100%;
            max-width: 500px;
            background: white;
            padding: 10px;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }
        .table-container {
            max-height: 400px;
            overflow: auto;
            border: 1px solid #ddd;
            scrollbar-width: thin;
            scrollbar-color: #ccc transparent;
            white-space: nowrap;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            min-width: 600px;
        }
        th, td {
            padding: 8px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th {
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
    </style>
</head>
<body>
    <?php
    $uri = $this->uri->segment(4);
    $id_res = intval($uri) - 98761;
    $cek_res = $this->data_model->get_byid('data_reseller', ['id_res'=>$id_res]);
    if($cek_res->num_rows() == 1){
    $nama_res = $cek_res->row('nama_reseller');
    ?>
    <div class="loading-overlay" id="loading"><div class="loader"></div></div>
    <div class="container" style="display: none;" id="content">
        <h2 style="text-align: center; margin-bottom: 10px;">Data Tagihan</h2>
        <strong>Nama Reseller : <?=$nama_res;?></strong>
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>No SJ</th>
                        <th>Tanggal SJ</th>
                        <th>Nilai Tagihan</th>
                        <th>Jumlah Bayar</th>
                        <th>Sisa Tagihan</th>
                        <th>Status</th>
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
        echo "Anda tidak diperbolehkan mengakses halaman ini..!!";
    }?>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script>
        const data = [
            { noSJ: '001', tanggal: '2025-02-01', nilai: 500000, bayar: 500000, sisa: 0, status: 'Lunas' },
            { noSJ: '002', tanggal: '2025-02-02', nilai: 750000, bayar: 400000, sisa: 350000, status: 'Belum Lunas' },
            { noSJ: '003', tanggal: '2025-02-03', nilai: 600000, bayar: 600000, sisa: 0, status: 'Lunas' }
        ];
        function loadData() {
            fetch('<?=base_url('reseller2/loadData/'.$id_res);?>')
                .then(response => response.json())
                .then(data => {
                    const tableBody = document.getElementById("data-body");
                    tableBody.innerHTML = '';
                    data.forEach(item => {
                        let row = `<tr>
                            <td>${item.no}</td>
                            <td>${item.no_sj}</td>
                            <td>${item.tgl}</td>
                            <td>Rp ${item.nilai_tagihan}</td>
                            <td>Rp ${item.jml_bayar}</td>
                            <td>Rp ${item.jml_sisa}</td>
                            <td><span class="badge ${item.lunas === 'Lunas' ? 'badge-lunas' : 'badge-belum'}">${item.lunas}</span></td>
                        </tr>`;
                        tableBody.innerHTML += row;
                    });
                    document.getElementById("loading").style.display = "none";
                    document.getElementById("content").style.display = "block";
                })
                .catch(error => console.error('Error:', error));
        }
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
    </script>
</body>
</html>
