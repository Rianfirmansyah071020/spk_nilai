<?php
session_start();
error_reporting(0);

?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Login</title>
    <link href="../../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="../../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css">
    <link href="../../css/ruang-admin.min.css" rel="stylesheet">

</head>

<body style="background-image: url(../../assets_home/img/bac.jpg); background-size:cover;">
    <!-- Login Content -->
    <div class="container-login">
        <div class="row justify-content-end">
            <div class="col-xl-4 col-lg-12 col-md-9">
                <div class="my-5">
                    <div class="card-body p-0">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="login-form">
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-4">Masukan Username Disini</h1>
                                        <?php
                                            require "../controller/controller.php";

                                            if(isset($_POST['lupa'])) {

                                                if(lupa_password($_POST) === true) { ?>
                                        <script>
                                        document.location.href = "index.php";
                                        alert("Username dan password anda sudah dikirim ke email");
                                        </script>
                                        <?php     }
                                            }
                                        ?>
                                    </div>
                                    <form class="user" action="" method="post">
                                        <div class="form-group">
                                            <input type="text" class="form-control" name="username"
                                                id="exampleInputusername" aria-describedby="username"
                                                placeholder="username:xxx" required>
                                        </div>
                                        <div class="form-group mt-4">
                                            <button type="submit" name="lupa"
                                                class="btn btn-primary w-100">Kirim</button>
                                        </div>
                                        <div class="form-group mt-4">
                                            <a href="../../index.php" class="btn btn-warning">kembali</a>
                                        </div>
                                    </form>
                                    <hr>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    <!-- Login Content -->
    <script src="../../vendor/jquery/jquery.min.js"></script>
    <script src="../../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../../vendor/jquery-easing/jquery.easing.min.js"></script>
    <script src="../../js/ruang-admin.min.js"></script>
</body>

</html>