<?php
require_once 'services/manager_session.php';
require_once 'services/grupo.php';
require_once 'services/subgrupo.php';
require_once 'services/local.php';
require_once 'services/funcoes.php';
require_once 'services/publico.php';

session_start();
ManagerSession::validaAcesso(8);

if(!empty($_GET)){
    $dados = listarLocal($_GET['i']);
    $subgrupo = listarSubgrupo($dados->id_subgrupo);
    $grupo = listarGrupo($subgrupo->id_grupo);
    $grupos = listarGrupos();
    $subgrupos = listarSubgrupos();
    $publicos = listarPublicos();
    
    if($dados == "nenhum"){
        echo "<script>location.href='home'</script>";
    }
}else{
    echo "<script>location.href='home'</script>";
}

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
    <link href="vendors/bower_components/chosen/chosen.css" rel="stylesheet"> 
    <link href="vendors/bower_components/mediaelement/build/mediaelementplayer.css" rel="stylesheet">
    <link href="vendors/bower_components/nouislider/distribute/nouislider.min.css" rel="stylesheet">
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
                            <h2>Local</h2>
                        </div>
                        <div class="card-body card-padding">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="fg-line form-group">
                                        <label>Nome</label>
                                        <p><?php echo $dados->nome ?></p>
                                    </div>
                                </div>
                                
                                <div class="col-sm-3">
                                    <div class="fg-line form-group">
                                        <label>Subgrupo</label>
                                        <p><?php echo $dados->nome_subgrupo ?></p>
                                    </div>
                                </div>                                
                                
                                <div class="col-sm-3">
                                    <div class="fg-line form-group">
                                        <label>Grupo</label>
                                        <p><?php echo $grupo->nome ?></p>
                                    </div>
                                </div>

                                <div class="col-sm-6">  
                                    <label>Públicos impactados:</label><br><br>
                                    <?php
                                        foreach ($publicos as $publico){
                                            
                                        $impactoDados1 = impactoPorPublicoLocal($publico->id, $dados->id);
                                        if($impactoDados1 == "nenhum"){
                                            $impactoDisplay1 = 0;
                                        }else{
                                            $impactoDisplay1 = $impactoDados1->impacto;
                                        }                                            
                                    ?>
                                    
                                    <div class="fg-line form-group">
                                        <label><?php echo $publico->nome ?></label><br><br>
                                            
                                        <div class="progress">
                                            <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="<?php echo $impactoDisplay1 ?>" aria-valuemin="0"
                                                 aria-valuemax="100" style="width: <?php echo $impactoDisplay1 ?>%;">
                                            </div>
                                        </div>                                            
                                    </div>
                                    <hr>
                                                                        
                                    <?php
                                    }
                                    ?>
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
                        <a href="locais" style="float: left" class="btn bgm-gray btn-icon-text"><i class="zmdi zmdi-arrow-back"></i> Voltar</a>
                        <a style="float: right; margin: 5px" class="btn bgm-red btn-icon-text delete" id="delete"><i class="zmdi zmdi-delete"></i> Excluir</a>
                        <a data-toggle="modal" href="#edit" style="float: right; margin: 5px" class="btn bgm-black btn-icon-text"><i class="zmdi zmdi-edit"></i> Editar</a>
                    </div>
            </div>              
        </section>
        
        <div class="modal fade" id="edit" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">EDITAR DADOS</h4>
                    </div>

                    <form class="formularioEdit" action="services/local.php" method="POST">
                        <input type="hidden" name="function" value="editLocal"/> 
                        <input type="hidden" name="id" value="<?php echo $dados->id ?>"/>
                        <div class="card">
                            <div class="card-body card-padding">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="fg-line form-group">
                                            <label>Nome</label>
                                            <input type="text" value="<?php echo $dados->nome ?>" class="form-control input-sm" name="nome" required="">
                                        </div>
                                    </div>
                                    
                                    <div class="col-sm-6">  
                                        <div class="fg-line form-group">
                                            <label>Subgrupo</label><br>
                                            <select class="chosen" placeholder="Selecione o subgrupo" name="id_subgrupo">

                                                    <option disabled="" selected="" value="">SELECIONE</option>
                                                    <?php
                                                    if($subgrupos != "nenhum"){
                                                    foreach ($subgrupos as $subgrupo1) {
                                                        ?>
                                                    <option <?php if($dados->id_subgrupo == $subgrupo1->id){?> selected="" <?php } ?> 
                                                                value="<?php echo $subgrupo1->id ?>"><?php echo $subgrupo1->nome ." - ".$subgrupo1->nome_grupo ?></option>
                                                        <?php
                                                    }
                                                    }else{
                                                        echo 'nenhum subgrupo';
                                                    }
                                                    ?>
                                                </optgroup>

                                            </select>
                                        </div>
                                    </div>
                                    
                                    <div class="col-sm-12">  
                                        <label>Públicos impactados:</label><br><br>
                                        <?php
                                            foreach ($publicos as $publico2){

                                        ?>

                                        <div class="fg-line form-group">
                                            <label><?php echo $publico2->nome ?></label><br><br>
                                                <div id="<?php echo $publico2->id?>" class="input-slider m-b-25"></div>
                                                <input name="impacto<?php echo $publico2->id ?>" type="hidden" id="valor<?php echo $publico2->id?>" class="form-control input-sm"/>
                                        </div>
                                        <hr>

                                        <?php
                                        }
                                        ?>
                                    </div>                                    
                                    
                                    <div class="col-sm-6">
                                        <div class="preloader loadingEdit" style="display: none; float: left; padding-top: 5px">
                                            <svg class="pl-circular" viewBox="25 25 50 50">
                                            <circle class="plc-path" cx="50" cy="50" r="20"/>
                                            </svg>
                                        </div>    
                                    </div>

                                    <div class="modal-footer">
                                        <button type="submit" class="btn btn-link">Salvar</button>
                                        <button type="button" class="btn btn-link" data-dismiss="modal">Cancelar</button>
                                    </div>                                    

                                </div>

                            </div>
                        </div>
                    </form> 

                </div>
            </div>
        </div>         
        
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
    <script src="vendors/bower_components/nouislider/distribute/nouislider.min.js"></script>

    <script src="vendors/sparklines/jquery.sparkline.min.js"></script>

    <!-- FLOT CHART JS -->
    <script src="vendors/bower_components/flot/jquery.flot.js"></script>
    <script src="vendors/bower_components/flot/jquery.flot.resize.js"></script>
    <script src="vendors/bower_components/flot.tooltip/js/jquery.flot.tooltip.min.js"></script>
    <script src="vendors/flot-orderbars/jquery.flot.orderBars.js"></script>
    <script src="vendors/flot-orderbars/jquery.flot.categories.js"></script>
    <script src="vendors/bower_components/chosen/chosen.jquery.js"></script>
    <script src="vendors/bower_components/jquery-mask-plugin/dist/jquery.mask.min.js"></script>
    <!-- Placeholder for IE9 -->
    <!--[if IE 9 ]>
        <script src="vendors/bower_components/jquery-placeholder/jquery.placeholder.min.js"></script>
    <![endif]-->

    <script src="js/app.min.js"></script>
    <script src="js/jquery.form.js"></script>
    <script src="js/afterglow.min.js"></script>
    
    <script>
        $(function(){
            
            <?php
                foreach ($publicos as $publico1){
                $impactoDados = impactoPorPublicoLocal($publico1->id, $dados->id);
                if($impactoDados == "nenhum"){
                    $impactoDisplay = 0;
                }else{
                    $impactoDisplay = $impactoDados->impacto;
                }
            ?>
         
            var slider<?php echo $publico1->id?> = document.getElementById('<?php echo $publico1->id?>');
            noUiSlider.create(slider<?php echo $publico1->id ?>, {
                start: [<?php echo $impactoDisplay ?>],
                connect: "lower",
                range: {
                    'min': 0,
                    'max': 100
                }
            });

            var inputNumber<?php echo $publico1->id ?> = document.getElementById('valor<?php echo $publico1->id ?>');
            slider<?php echo $publico1->id ?>.noUiSlider.on('update', function (values, handle) {
                var value = values[handle];
                inputNumber<?php echo $publico1->id ?>.value = value;
            });  
            
            <?php
                }
            ?>            
            
            
            $('.formularioEdit').ajaxForm({
                beforeSend: function () {
                    $('.loadingEdit').css({display: "block"});
                },
                success: function () {
                    $('.loadingEdit').css({display: "none"});
                },
                complete: function(result){
                    if(result.responseText === "success"){
                        swal({
                            title: "Atualizado com sucesso",
                            text: "Registro atualizado com sucesso",
                            type: "success",
                            confirmButtonText: "Ok"
                        }).then(function(){
                            location.reload();
                        });   
                    }else{
                        swal({
                            title: "Falha ao atualizar",
                            
                            type: "error"
                        });                        
                    }
 
                }
            });
        });
        
        $('.delete').click(function () {    
            swal({
                title: "Tem certeza?",
                text: "O registro será excluído!",
                type: "warning",
                showCancelButton: true,
                cancelButtonText: "Cancelar",
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Sim, excluir!",
                closeOnConfirm: false
            }).then(function () {
                excl(<?php echo $dados->id ?>);
            });
        });
        
        function excl(id){
            $.ajax({
                    type: "POST",
                    data: {i:id, function:'remover'},
                    url: "services/local.php",
                    dataType: "html",
                    success: function(data){
                        swal({
                            title: "Removido com sucesso",
                            text: "",
                            type: "success",
                            confirmButtonText: "Ok"
                        }).then(function () {
                            location.href='locais';
                        });                         
                        
                        
                    }                    
                });
        }
        
        $('#valor').mask('#.##0,00', {reverse: true});
        
    </script>      

</body>
</html>
