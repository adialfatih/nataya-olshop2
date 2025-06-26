<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="manifest" href="manifest.json">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="application-name" content="Nataya Data">
    <meta name="apple-mobile-web-app-title" content="Nataya Data">
    <meta name="theme-color" content="#246cd1">
    <meta name="msapplication-navbutton-color" content="#246cd1">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta name="msapplication-starturl" content="/">
    <link rel="apple-touch-icon" sizes="180x180" href="https://nataya.damayraya.com/logo/logo.png"/>
		<link rel="icon" type="image/png" sizes="32x32" href="https://nataya.damayraya.com/logo/logo.png"/>
		<link rel="icon" type="image/png" sizes="16x16" href="https://nataya.damayraya.com/logo/logo.png"/>

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Aplikasi</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto&family=Roboto+Slab:wght@100..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?=base_url('assets/newtipe/');?>style.css">
    <link rel="stylesheet" href="<?=base_url('assets/newtipe/');?>responsive.css">
</head>
<body>
    <div class="container">
        <div class="login-box">
            <h1>Login Aplikasi</h1>
            <form action="<?=base_url('login-action');?>" method="post" id="idfrm"> 
                <div class="input-box">
                    <label for="username">Username</label>
                    <input type="text" name="username" id="username" autocomplete="off" required>
                    <ion-icon name="person-circle-outline" style="color:#1151bf;"></ion-icon>
                </div>
                <div class="input-box">
                    <label for="password">Password</label>
                    <input type="password" name="password" id="password" autocomplete="off" required>
                    <ion-icon name="key-outline" style="color:#f5a031;"></ion-icon>
                </div>
                <div style="margin-top: 10px;font-size:13px;color:#2c2d2e;">
                    <?php
                    $setup = $this->db->query("SELECT * FROM table_settings WHERE id_setup='1'")->row_array();
                    ?>
                    <small>&copy; <?=$setup['tahun_pembuatan'];?> : <?=$setup['nama_client'];?></small>
                </div>
                <div class="btn-box">
                   <button type="submit"><ion-icon name="lock-open"></ion-icon>Login</button>
                </div>
                <!-- <ion-icon name="heart"></ion-icon> -->
            </form>
        </div>
    </div>


    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    <script>
if ('serviceWorker' in navigator) {
                navigator.serviceWorker.register("serviceworker.js");
            }
    </script>
</body>
</html>