<?php
require_once 'services/manager_session.php';
require_once 'services/grupo.php';
session_start();
ManagerSession::validaAcesso(6);

$grupos = listarGrupos();

?>
<!DOCTYPE html>
<!--[if IE 9 ]><html class="ie9"><![endif]-->
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>mapping</title>

    <link href="vendors/bower_components/fullcalendar/dist/fullcalendar.min.css" rel="stylesheet">
    <link href="vendors/bower_components/animate.css/animate.min.css" rel="stylesheet">
    <link href="vendors/bower_components/sweetalert2/dist/sweetalert2.min.css" rel="stylesheet">
    <link href="vendors/bower_components/material-design-iconic-font/dist/css/material-design-iconic-font.min.css" rel="stylesheet">
    <link href="vendors/bower_components/malihu-custom-scrollbar-plugin/jquery.mCustomScrollbar.min.css" rel="stylesheet">
    <link href="vendors/bower_components/mediaelement/build/mediaelementplayer.css" rel="stylesheet">
    <!-- CSS -->
    <link href="css/app_1.min.css" rel="stylesheet">
    <link href="css/app_2.min.css" rel="stylesheet">

</head>
<body>
    <?php include("topo.php") ?>

    <section id="main">
        <?php include ("menu.php") ?>

        <section id="content">
                <div class="container">
                    <div class="messages card">
                        <div class="m-sidebar">
                            <header>
                                <h2 class="hidden-xs">Buscar Publicidade</h2>

                            </header>

                            <div class="ms-search hidden-xs">
                                <div class="fg-line">
                                    <i class="zmdi zmdi-search"></i>

                                    <input type="text" class="form-control" placeholder="Search...">
                                </div>
                            </div>

                            <div class="list-group c-overflow">
                                <a class="list-group-item media" href="#" onclick="alternaJanela('janelaCiclano')">
                                    <div class="media-body">
                                        <div class="lgi-heading">Ciclano</div>
                                    </div>
                                </a>

                                <a class="list-group-item media" href="#" onclick="alternaJanela('janelaFulano')">
                                    <div class="media-body">
                                        <div class="lgi-heading">Fulano</div>
                                    </div>
                                </a>
                            </div>
                        </div>

                        <div class="m-body">
                            
                            <div class="janelas" id="janelaCiclano" style="display: block">
                                <header class="mb-header">
                                    <div class="mbh-user clearfix">
                                        <div class="p-t-5">Ciclano</div>
                                    </div>
                                </header>

                                <div class="mb-list">
                                    <div class="mbl-messages c-overflow">
                                        <div class="mblm-item mblm-item-left">
                                            <div>
                                                Eu sou o ciclano
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            
                            <div class="janelas" id="janelaFulano" style="display: none">
                                <header class="mb-header">
                                    <div class="mbh-user clearfix">
                                        <div class="p-t-5">Fulano</div>
                                    </div>
                                </header>

                                <div class="mb-list">
                                    <div class="mbl-messages c-overflow">
                                        <div class="mblm-item mblm-item-left">
                                            <div>
                                                Eu sou o fulano
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>                            
                            
                        </div>
                    </div>
                </div>
            </section>
    </section>

    <!-- Javascript Libraries -->
    <script src="vendors/bower_components/jquery/dist/jquery.min.js"></script>
    <script src="vendors/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="vendors/bower_components/Waves/dist/waves.min.js"></script>
    <script src="vendors/bower_components/sweetalert2/dist/sweetalert2.min.js"></script>
    <script src="vendors/bower_components/malihu-custom-scrollbar-plugin/jquery.mCustomScrollbar.concat.min.js"></script>
    <script src="vendors/bower_components/mediaelement/build/mediaelement-and-player.min.js"></script>
    <script src="vendors/bower_components/moment/min/moment.min.js"></script>
    <script src="vendors/bower_components/fullcalendar/dist/fullcalendar.min.js"></script>


    <script src="vendors/sparklines/jquery.sparkline.min.js"></script>

    <!-- FLOT CHART JS -->
    <script src="vendors/bower_components/flot/jquery.flot.js"></script>
    <script src="vendors/bower_components/flot/jquery.flot.resize.js"></script>
    <script src="vendors/bower_components/flot.tooltip/js/jquery.flot.tooltip.min.js"></script>
    <script src="vendors/flot-orderbars/jquery.flot.orderBars.js"></script>
    <script src="vendors/flot-orderbars/jquery.flot.categories.js"></script>

    <!-- Placeholder for IE9 -->
    <!--[if IE 9 ]>
        <script src="vendors/bower_components/jquery-placeholder/jquery.placeholder.min.js"></script>
    <![endif]-->

    <script src="js/app.min.js"></script>
    <script src="js/jquery.form.js"></script>
    <script src="js/afterglow.min.js"></script>
    
    <script>
        
        function alternaJanela(id){
            var janelas = document.getElementsByClassName("janelas");
            var janela = document.getElementById(id);
            
            var i;
            for (i = 0; i < janelas.length; i++) {
              janelas[i].style.display = "none";
            } 
            
            janela.style.display="block";
        }         
        
    </script>      

</body>
</html>
