<?php
require_once 'services/manager_session.php';
require_once 'services/campanha.php';
require_once 'services/publico.php';
session_start();
ManagerSession::validaAcesso(11);

$publicos = listarPublicos();

?>
<!DOCTYPE html>
<!--[if IE 9 ]><html class="ie9"><![endif]-->
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>mapping</title>

    <!-- Vendor CSS -->

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
    <link href="css/datepicker.css" rel="stylesheet">    
</head>
<body>
    <?php include("topo.php") ?>

    <section id="main">
        <?php include ("menu.php") ?>

        <section id="content" style="margin-top: -15px">
           <div class="container">
               <form class="formulario" action="services/campanha.php" method="POST">
                    <input type="hidden" name="function" value="novo"/>
                    <input type="hidden" name="pessoa_log" value="<?php echo $_SESSION['UsuarioID']?>"/>
                    <div class="card">
                        <div class="card-header">
                            <h2>Nova Campanha</h2>
                        </div>
                        <div class="card-body card-padding">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="fg-line form-group">
                                        <label>Nome</label><br>
                                        <input type="text" class="form-control input-sm" name="nome" required="">
                                    </div>
                                </div>
                                
                                <div class="col-sm-2">
                                    <div class="fg-line form-group">
                                        <label>Data de início</label>
                                        <input id="data" type="text" class="form-control input-sm datas" data-toggle="datepicker" name="inicio" required="">
                                    </div>
                                </div>

                                <div class="col-sm-2">
                                    <div class="fg-line form-group">
                                        <label>Data de termino</label>
                                        <input id="data" type="text" class="form-control input-sm datas" data-toggle="datepicker" name="fim" required="">
                                    </div>
                                </div>   
                                
                                <div class="col-sm-2">
                                    <div class="fg-line form-group">
                                        <label>Ambiente</label>
                                        <select class="chosen" name="ambiente">
                                            <option value="i">Interna</option>
                                            <option value="e">Externa</option>
                                        </select>
                                    </div>
                                </div>                                

                                <div class="col-sm-12">
                                    <div class="fg-line form-group">
                                        <label>Descricao</label>
                                        <textarea id="descricao" type="text" rows="4" class="form-control input-sm" name="descricao"></textarea>
                                    </div>
                                </div>
                                
                                <div class="col-sm-12">
                                    <label>Selecione os públicos alvos</label>
                                    <select class="chosen" name="publicos[]" multiple data-placeholder="Selecionar...">
                                        
                                        <?php
                                            if($publicos != "nenhum"){
                                                foreach ($publicos as $publico){
                                        ?>
                                        
                                        <option value="<?php echo $publico->id ?>"><?php echo $publico->nome ?></option>
                                          
                                        <?php
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>                               
                                
                                <div class="col-sm-12" style="margin-top: 20px">
                                    <div class="fg-line form-group">
                                        <label>Layout</label>
                                        <input id="titulo" type="file" class="form-control input-sm" name="layout" required="">
                                    </div>
                                </div>                                
                                
                            </div>
                        </div>
                    </div>
                   
                    <div class="card-body">
                        <a href="campanhas" style="float: left" class="btn bgm-gray btn-icon-text"><i class="zmdi zmdi-arrow-back"></i> Voltar</a>
                        <button type="submit" style="float: right" class="btn bgm-black btn-icon-text"><i class="zmdi zmdi-plus"></i> Salvar</button>
                    
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

    <script src="vendors/sparklines/jquery.sparkline.min.js"></script>
    <script src="vendors/bower_components/chosen/chosen.jquery.js"></script>
    
    <script src="js/datepicker.js"></script>
    <script src="js/datepicker.pt-BR.js"></script>       
    
    <!-- FLOT CHART JS -->
    <script src="vendors/bower_components/flot/jquery.flot.js"></script>
    <script src="vendors/bower_components/flot/jquery.flot.resize.js"></script>
    <script src="vendors/bower_components/flot.tooltip/js/jquery.flot.tooltip.min.js"></script>
    <script src="vendors/flot-orderbars/jquery.flot.orderBars.js"></script>
    <script src="vendors/flot-orderbars/jquery.flot.categories.js"></script>

    <script src="js/app.min.js"></script>
    <script src="js/jquery.form.js"></script>
    <script src="js/afterglow.min.js"></script>
    
    <script>
        $(function(){
            $('.datas').datepicker({
              autoHide: true,
              zIndex: 2048,
              language: 'pt-BR'
            });
            
            $('.formulario').ajaxForm({
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
                        }).then(function () {
                            location.href='campanhas';
                        });   
                    }else{
                        swal({
                            title: "Falha ao inserir",
                            text: result.responseText,
                            type: "error"
                        });                        
                    }
                }
            });
        });
    </script>      

</body>
</html>
