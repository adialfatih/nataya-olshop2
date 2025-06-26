<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
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
            <h1>Login Users</h1>
            <form action="<?=base_url('users-process');?>" method="post" id="idfrm"> 
                <div class="input-box">
                    <label for="username">Username</label>
                    <input type="text" name="username" id="username" autocomplete="off" required>
                    <ion-icon name="person-circle-outline"></ion-icon>
                </div>
                <div class="input-box">
                    <label for="password">Password</label>
                    <input type="password" name="password" id="password" autocomplete="off" required>
                    <ion-icon name="key-outline"></ion-icon>
                </div>
                <div style="width:100%;margin-top:10px;color:red;font-size:12px;text-align:left;">
                    <?php
                    if (!empty($this->session->flashdata('announce'))) {
                        echo $this->session->flashdata('announce');
                    }?>
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
</body>
</html>