<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Digital Signature</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.10.0/dist/sweetalert2.min.css" integrity="sha256-ZCK10swXv9CN059AmZf9UzWpJS34XvilDMJ79K+WOgc=" crossorigin="anonymous">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <style>
        #signature-pad {
            border: 1px solid #ccc;
            width: 100%;
            height: 450px;
            touch-action: none; /* Prevent scrolling on touch devices */
        }
    </style>
</head>
<body>
<?php
$tipe = $this->uri->segment(2);
$id = $this->uri->segment(4);
if($tipe == "pkwt"){
    $cek = $this->data_model->get_byid('pkwt', ['sha1(idpkwt)'=>$id]);
} else {
    $cek = $this->data_model->get_byid('pkwtp', ['sha1(id_spkwtp)'=>$id]);
}
if($cek->num_rows() == 1){
    if($tipe == "pkwt"){
        $idsending = $cek->row('idpkwt');
    } else {
        $idsending = $cek->row('id_spkwtp');
    }
$nosurat = $cek->row('nosurat');
$nrp = $cek->row('nrp');
$kar = $this->data_model->get_byid('data_karyawan', ['nrp'=>$nrp])->row('nama');
?>
<div class="container mt-5">
    <h2>Digital Signature</h2>
    <small>No Surat : <strong><?=$nosurat;?></strong>, Atas Nama : <strong><?=$kar;?></strong></small>
    <div class="row">
        <div class="col-md-12">
            <canvas id="signature-pad"></canvas>
        </div>
    </div>
    <div class="row mt-3">
        <div class="col-md-12">
            <button id="clear" class="btn btn-danger">Clear</button>
            <button id="save" class="btn btn-success">Save</button>
        </div>
    </div>
</div>
<?php } else { ?>
<div class="container mt-5">
    <h2>Error Token For Signature</h2>
    
    <div class="row">
        <div class="col-md-12">
            <canvas id="signature-pad"></canvas>
        </div>
    </div>
    <div class="row mt-3">
        <div class="col-md-12">
            <button id="backid" class="btn btn-primary">Back</button>
        </div>
    </div>
</div>
<?php } ?>
<script src="https://cdn.jsdelivr.net/npm/signature_pad@4.0.0/dist/signature_pad.umd.min.js"></script><script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.10.0/dist/sweetalert2.all.min.js" integrity="sha256-IW9RTty6djbi3+dyypxajC14pE6ZrP53DLfY9w40Xn4=" crossorigin="anonymous"></script>
    
<script>
    var canvas = document.getElementById('signature-pad');
    var signaturePad = new SignaturePad(canvas);

    // Adjust canvas size
    function resizeCanvas() {
        var ratio = Math.max(window.devicePixelRatio || 1, 1);
        canvas.width = canvas.offsetWidth * ratio;
        canvas.height = canvas.offsetHeight * ratio;
        canvas.getContext("2d").scale(ratio, ratio);
        signaturePad.clear(); // otherwise isEmpty() might return incorrect value
    }

    window.addEventListener('resize', resizeCanvas);
    resizeCanvas();
    
    document.addEventListener('keydown', function(event) {
        if (event.keyCode === 27) {
            signaturePad.clear();
        }
    });

    document.getElementById('clear').addEventListener('click', function () {
        signaturePad.clear();
    });

    document.getElementById('save').addEventListener('click', function () {
        if (signaturePad.isEmpty()) {
            Swal.fire('Anda belum melakukan tanda tangan');
        } else {
            var dataUrl = signaturePad.toDataURL('image/png');
            var xhr = new XMLHttpRequest();
           
            var saveUrl = '<?php echo site_url('signature/save'); ?>';
            console.log('Save URL:', saveUrl);  // Tambahkan log ini
            xhr.open('POST', saveUrl, true);

            xhr.setRequestHeader('Content-Type', 'application/json');
            xhr.onreadystatechange = function () {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    Swal.fire('Berhasil menyimpan', '', 'success').then((result) => {
                        window.location.href = '<?php echo site_url("data-".$tipe.""); ?>';
                    });
                } else {
                    Swal.fire('Oops!', 'Terjadi kesalahan', 'error');
                }
            };
            var payload = JSON.stringify({
                id: '<?php echo $id; ?>',
                tipe: '<?php echo $tipe; ?>',
                kar: '<?php echo $kar; ?>',
                image: dataUrl
            });
            xhr.send(payload);
        }
    });
</script>
</body>
</html>
