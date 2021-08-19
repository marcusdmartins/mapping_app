<?php
require_once 'services/manager_session.php';
require_once 'services/campanha.php';
require_once 'services/midia.php';
require_once 'services/publico.php';
require_once 'services/tipomidia.php';
require_once 'services/grupo.php';
require_once 'services/subgrupo.php';
require_once 'services/local.php';
session_start();
ManagerSession::validaAcesso(15);

$campanhas = listarCampanhas();
$tipomidias = listarTipoMidias();
$midias = listarMidiaPorTipo(3);
$grupos = listarGrupos();
$locais = listarLocais();

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
    
    <style>
    .chip {
      display: inline-block;
      padding: 0 15px;
      height: 30px;
      font-size: 12px;
      line-height: 30px;
      border-radius: 15px;
      background-color: #f1f1f1;
      margin: 5px
    }        
    </style>

</head>
<body>
    <?php include("topo.php") ?>

    <section id="main">
        <?php include ("menu.php") ?>

        <section id="content" style="margin-top: -15px">
            <div class="container">
                <form class="formulario" action="services/publicidade.php" method="POST">
                    <input type="hidden" name="function" value="novo"/>
                    <input type="hidden" name="ambiente" value="d"/>
                    <input type="hidden" name="pessoa_log" value="<?php echo $_SESSION['UsuarioID']?>"/>
                    <input type="hidden" value="1" id="qtd" name="qtd" required="">
                    <div class="card">
                        <div class="card-header">
                            <h2>Nova Publicidade Digital/Eletrônica</h2>
                        </div>
                        <div class="card-body card-padding">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="fg-line form-group">
                                        <label>Campanha</label><br>
                                        <select class="chosen" id="id_campanha" name="id_campanha" onchange="preencheCiclo()">
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
                                    <select class="chosen" name="id_midia">
                                        <option disabled="" selected="">SELECIONE</option>
                                                <?php
                                                    if($midias != "nenhum"){
                                                        foreach ($midias as $midia){
                                                ?>
                                                    <option value="<?php echo $midia->id ?>"><?php echo $midia->nome ?></option>
                                                <?php
                                                        }
                                                    }
                                                ?>
                                    </select>
                                </div>                               
                                
                                <div class="col-sm-3">  
                                    <div class="fg-line form-group">
                                        <label>Status</label><br>
                                        <select class="chosen" name="status">
                                                <option disabled="" selected="" value="">SELECIONE</option>
                                                <option value="i">Inativa</option>
                                                <option value="a">Ativa</option>
                                        </select>
                                    </div>
                                </div>
                                
                                <div class="col-sm-12">
                                    <div class="fg-line form-group">
                                        <label>Descrição</label>
                                        <input type="text" class="form-control input-sm" id="descricao" name="descricao" required="">
                                    </div>
                                </div>                                

                                <div class="col-sm-6">
                                    <div class="fg-line form-group">
                                        <label>Custo individual (R$)</label>
                                        <input type="text" class="form-control input-sm" id="custo" name="custo" required="">
                                    </div>
                                </div>

                                <div class="col-sm-3">
                                    <div class="fg-line form-group">
                                        <label>Início do Ciclo</label>
                                        <input type="text" class="form-control input-sm datas" data-toggle="datepicker" id="inicio" name="inicio" required="">
                                    </div>
                                </div>

                                <div class="col-sm-3">
                                    <div class="fg-line form-group">
                                        <label>Término do Ciclo</label>
                                        <input type="text" class="form-control input-sm datas" data-toggle="datepicker" id="fim" name="fim" required="">
                                    </div>
                                </div>
                                
                            </div>
                                
                            <div class="row" style="margin-top: 60px">
                                
                                <div class="col-sm-6">
                                    <div class="fg-line form-group">
                                        <label>Públicos que devem ser impactados por esta campanha</label><br><br>
                                        <div id="publicosCampanha">
                                        </div>
                                    </div>
                                </div>  
                                
                            </div>
                        </div>
                    </div>
                    
                    <div class="card-body">
                        <a href="midiaSelect" style="float: left" class="btn bgm-gray btn-icon-text"><i class="zmdi zmdi-arrow-back"></i> Voltar</a>
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
    <script src="vendors/bower_components/jquery-mask-plugin/dist/jquery.mask.min.js"></script>

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
                            location.href='publicidadesCampanha';
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
        
        function atualizarCombos(){
            preencheImpactos();
        }
        
        
        function preencheCiclo(){
            buscaInicioCampanha();
            buscaFimCampanha();
            buscaPublicosCampanha();
        }
        
        function buscaInicioCampanha(){
            $.ajax({
               url: "services/campanha.php",
               type: 'POST',
               data:{function: 'buscaInicio', id: $("#id_campanha").val()},
               success:function(data){
                   $("#inicio").val(data);
               }
            });
        } 
        
        function buscaFimCampanha(){
            $.ajax({
               url: "services/campanha.php",
               type: 'POST',
               data:{function: 'buscaFim', id: $("#id_campanha").val()},
               success:function(data){
                   $("#fim").val(data);
               }
            });
        }  
        
        function buscaPublicosCampanha(){
            $.ajax({
               url: "services/publico.php",
               type: 'POST',
               data:{function: 'publicoPorCampanhaInst', id_campanha: $("#id_campanha").val()},
               success:function(data){
                   $("#publicosCampanha").html(data);
               }
            });
        }         
        
        $('#custo').mask('#.##0,00', {reverse: true});
        
    </script>      

</body>
</html>
