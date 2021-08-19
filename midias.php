<?php
require_once 'services/manager_session.php';
require_once 'services/midia.php';
session_start();
ManagerSession::validaAcesso(9);

$midias = listarMidias();

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
    <link href="vendors/bower_components/chosen/chosen.css" rel="stylesheet">
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
                            <h2>MÍDIAS</h2>
                            
                        <div style="margin-top: 25px" style="float: right; width: 20%">
                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="fg-line form-group">
                                        <label>Ambiente</label><br>
                                        <select class="chosen" name="tipo" id="tipo" onchange="buscaInst()">
                                            <option disabled="" selected="">SELECIONE</option>
                                            <option value="4">INTERNAS</option>
                                            <option value="2">EXTERNAS</option>
                                            <option value="3">DIGITAIS & ELETRÔNICAS</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>                            
                        </div>
                        <div class="card-body card-padding">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div id="resultados" class="list-group">
                                    
                                    <?php
                                        if($midias != "nenhum"){
                                            foreach ($midias as $midia){
                                    ?>
                                    
                                    <a class="list-group-item media" href="midiaDetail?i=<?php echo $midia->id ?>">
                                        <div class="pull-left">
                                            <img class="lgi-img" src="img/icons/midia.png" alt="">
                                        </div>
                                        <div class="media-body">
                                            <div class="lgi-heading"><?php echo $midia->nome ?></div>
                                            <small class="lgi-text"><?php echo $midia->nome_tipomidia ?></small> 
                                        </div>
                                    </a>
                                    
                                    <?php
                                            }
                                        }else{
                                            echo "Nenhuma mídia";
                                        }
                                    ?>
                                </div>
                                </div>
                            </div>
                        </div>
                    </div>
                        <div class="preloader loadingCliente" style="display: none; float: left; padding-top: 5px">
                            <svg class="pl-circular" viewBox="25 25 50 50">
                            <circle class="plc-path" cx="50" cy="50" r="20"/>
                            </svg>
                        </div>                    
                    <div class="card-body">
                        <a href="midiaNova" style="float: right" class="btn bgm-black btn-icon-text"><i class="zmdi zmdi-plus"></i> Nova</a>
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
    <script src="vendors/bower_components/chosen/chosen.jquery.js"></script>

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
        
        function buscaInst(){
                $.ajax({
                    url: "services/midia.php",
                    type: 'POST',
                    data: {function: 'buscaMidiaPorTipo', id_tipomidia: $("#tipo").val()},
                    success: function (data) {
                        $("#resultados").html(data);
                    }
                });            
        }        
    </script>      

</body>
</html>
