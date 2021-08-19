<?php
require_once 'services/manager_session.php';
require_once 'services/tipomidia.php';
session_start();
ManagerSession::validaAcesso(15);

$tipomidias = listarTipoMidias();

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

        <section id="content" style="margin-top: -15px">
           <div class="container">
                <div class="card">
                    <div class="card-header">
                        <h2>Qual o tipo de mídia da publicidade?</h2>
                    </div>
                    <div class="card-body card-padding">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="list-group">

                                    <a class="list-group-item media" href="publicidadeNova">
                                        <div class="pull-left">
                                            <img class="lgi-img" src="img/icons/local.png" alt="">
                                        </div>
                                        <div class="media-body">
                                            <div class="lgi-heading">Interna</div>
                                            <small class="lgi-text" style="font-style: italic">Midias em ambientes internos do Hospital</small> 
                                        </div>
                                    </a>

                                    <a class="list-group-item media" href="publicidadeDigitalNova">
                                        <div class="pull-left">
                                            <img class="lgi-img" src="img/icons/digital.png" alt="">
                                        </div>
                                        <div class="media-body">
                                            <div class="lgi-heading">Digital/ Eletrônica</div>
                                            <small class="lgi-text" style="font-style: italic">Midias em ambientes digitais: Site, Radio, Tv, Redes Sociais, etc.</small> 
                                        </div>
                                    </a>

                                    <a class="list-group-item media" href="publicidadeExternaNova">
                                        <div class="pull-left">
                                            <img class="lgi-img" src="img/icons/externa.png" alt="">
                                        </div>
                                        <div class="media-body">
                                            <div class="lgi-heading">Externa</div>
                                            <small class="lgi-text" style="font-style: italic">Midias em ambientes externos: Outdoors, Placas, etc.</small> 
                                        </div>
                                    </a>                                    

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
        $(function(){
            $('.formularioNivel').ajaxForm({
                beforeSend: function () {
                    $('.loadingCliente').css({display: "block"});
                },
                success: function () {
                    $('.loadingCliente').css({display: "none"});
                },
                complete: function(result){
                    if(result.responseText === "success"){
                        swal({
                            title: "Salvo com sucesso",
                            text: "Registro inserido com sucesso",
                            type: "success"
                        });   
                    }else{
                        swal({
                            title: "Falha ao inserir",
                            text: "Falha ao inserir registro",
                            type: "error"
                        });                        
                    }
 
                }
            });
        });
    </script>      

</body>
</html>
