<?php
require_once 'services/manager_session.php';
require_once 'services/grupo.php';
session_start();
ManagerSession::validaAcesso(7);

$grupos = listarGrupos();

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

</head>
<body>
    <?php include("topo.php") ?>

    <section id="main">
        <?php include ("menu.php") ?>

        <section id="content" style="margin-top: -15px">
           <div class="container">
               <form class="formulario" action="services/subgrupo.php" method="POST">
                    <input type="hidden" name="function" value="novo"/>
                    <div class="card">
                        <div class="card-header">
                            <h2>Novo Subgrupo</h2>
                        </div>
                        <div class="card-body card-padding">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="fg-line form-group">
                                        <label>Subgrupo</label><br>
                                        <input type="text" class="form-control input-sm" name="nome" placeholder="Nome" required="">
                                    </div>
                                </div>
                                
                                <div class="col-sm-6">  
                                    <div class="fg-line form-group">
                                        <label>Grupo</label><br>
                                        <select class="chosen" placeholder="Selecione o grupo" name="id_grupo">
                                            
                                                <option disabled="" selected="" value="">SELECIONE</option>
                                                <?php
                                                if($grupos != "nenhum"){
                                                foreach ($grupos as $grupo) {
                                                    ?>
                                                    <option value="<?php echo $grupo->id ?>"><?php echo $grupo->nome ?></option>
                                                    <?php
                                                }
                                                }else{
                                                    echo 'nenhum grupo';
                                                }
                                                ?>
                                            </optgroup>

                                        </select>
                                    </div>
                                </div>                                
                            </div>
                        </div>
                    </div>
                   
                    <div class="card-body">
                        <a href="subgrupos" style="float: left" class="btn bgm-gray btn-icon-text"><i class="zmdi zmdi-arrow-back"></i> Voltar</a>
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
                            location.href='subgrupos';
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
