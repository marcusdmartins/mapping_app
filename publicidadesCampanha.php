<?php
require_once 'services/manager_session.php';
require_once 'services/grupo.php';
require_once 'services/publicidade.php';
require_once 'services/campanha.php';
require_once 'services/midia.php';
require_once 'services/tipomidia.php';
require_once 'services/local.php';
session_start();
ManagerSession::validaAcesso(6);
$grupos = listarGrupos();
$campanhas = listarCampanhas();
$tipomidias = listarTipoMidias();
$locais = listarLocais();
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
    
    <style>
        .chip {
          display: inline-block;
          padding: 0 10px;
          height: 25px;
          font-size: 11px;
          line-height: 25px;
          border-radius: 15px;
          background-color: #CF4429;
          margin: 5px;
          margin-top: -25px
        }        
    </style>    

</head>
<body>
    <?php include("topo.php") ?>

    <section id="main">
        <?php include ("menu.php") ?>
        <section id="content">
            <div class="container">
                <form class="formulario" action="services/publicidade.php" method="POST">
                    <input type="hidden" name="function" value="novo"/>
                    <input type="hidden" name="ambiente" value="i"/>
                    <input type="hidden" name="pessoa_log" value="<?php echo $_SESSION['UsuarioID']?>"/>
                    <div class="card">
                        <div class="card-header">
                            <h2>Publicidades por campanha</h2>
                        </div>
                        <div class="card-body card-padding">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="fg-line form-group">
                                        <label>Campanha</label><br>
                                        <select class="chosen" id="campanha" name="campanha" onchange="filtroPublicidades()">
                                                <option disabled="" selected="" value="">SELECIONE</option>
                                                <?php
                                                if($campanhas != "nenhum"){
                                                    foreach ($campanhas as $campanha){
                                                ?>
                                                    <option value="<?php echo $campanha->id ?>"><?php echo $campanha->nome ?></option>
                                                <?php
                                                    }
                                                }
                                                ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-sm-3">
                                    <label>Mídia</label><br>
                                    <select class="chosen" id="midia" onchange="filtroPublicidades()">
                                        <option selected="" value="TODAS">Todas</option>
                                        <?php
                                        if($tipomidias != "nenhum"){
                                            foreach ($tipomidias as $tipomidia){
                                                $midias = listarMidiaPorTipo($tipomidia->id);
                                        ?>
                                        
                                            <optgroup label="<?php echo $tipomidia->nome ?>">
                                                <?php
                                                    if($midias != "nenhum"){
                                                        foreach ($midias as $midia){
                                                ?>
                                                    <option value="<?php echo $midia->id ?>"><?php echo $midia->nome ?></option>
                                                <?php
                                                        }
                                                    }
                                                ?>
                                            </optgroup>
                                        
                                        <?php
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>                               
                                
                                <div class="col-sm-3">  
                                    <div class="fg-line form-group">
                                        <label>Status</label><br>
                                        <select class="chosen" id="status" onchange="filtroPublicidades()">
                                                <option selected="" value="TODOS">Todos</option>
                                                <option value="i">Inativa</option>
                                                <option value="a">Ativa</option>
                                        </select>
                                    </div>
                                </div>

                                </div>
                                
                                <div class="row" style="margin-top: 60px">
                                
                                <div class="col-sm-12">
                                    <div class="fg-line form-group" id="publicidades"></div>
                                </div>
                                
                            </div>
                        </div>
                    </div>

                    
                    <div class="card-body">
                        <a href="javascript:history.back()" style="float: left" class="btn bgm-gray btn-icon-text"><i class="zmdi zmdi-arrow-back"></i> Voltar</a>
                    
                    <!-- SPINEER DE LOADING-->    
                    <div class="preloader loadingCliente" style="display: none">
                        <svg class="pl-circular" viewBox="25 25 50 50">
                        <circle class="plc-path" cx="50" cy="50" r="20"/>
                        </svg>
                    </div> 
                    </div>

                </form>                
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
        
        function filtroPublicidades(){
            
            $.ajax({
               url: "services/publicidade.php",
               type: 'POST',
               data:{function: 'publicidadeFiltroList', campanha: $("#campanha").val(), 
                        midia: $("#midia").val(), status: $("#status").val()},
               success:function(data){
                   $("#publicidades").html(data);
               }
            }); 
         
        }         
        
    </script>      

</body>
</html>
