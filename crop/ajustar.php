<?php
@session_start();
require_once '../classes/login.php';

$src_foto = getFotoPerfilTemp($_SESSION['UsuarioID']);
?>


<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta content="IE=edge" http-equiv="X-UA-Compatible">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Ajustar imagem</title>
        <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
        <link href="css/cropper.min.css" rel="stylesheet">
        <link href="css/main.css" rel="stylesheet">

        <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
        <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
          <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
    </head>
    <body>
        <!-- header -->
        <header class="navbar navbar-static-top docs-navbar-top" id="top">

        </header>

        <div class="container docs-overview">

            <div class="row">
                <div class="col-md-9">

                    <div class="img-container"><img src="../<?php echo $src_foto ?>"></div>

                </div>
                <div class="col-md-3">

                    <div class="docs-data">
                        <form action="crop.php" method="POST">
                            <div class="input-group">
                                <input class="form-control" name="nome_imagem" type="hidden" value="<?php echo $src_foto ?>">
                            </div>
                            <input class="form-control" name="dataX" id="dataX" type="hidden" placeholder="x">

                            <input class="form-control" name="dataY" id="dataY" type="hidden" placeholder="y">

                            <input class="form-control" name="dataW" id="dataWidth" type="hidden" placeholder="width">

                            <input class="form-control" name="dataH" id="dataHeight" type="hidden" placeholder="height">

                            <input type="submit" value="Ok"/>
                        </form>
                    </div>
                </div>
            </div>

            <script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
            <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
            <script src="https://cdn.rawgit.com/google/code-prettify/master/loader/run_prettify.js"></script>

            <script src="js/cropper.min.js"></script>
            <script src="js/main.js"></script>
    </body>
</html>
