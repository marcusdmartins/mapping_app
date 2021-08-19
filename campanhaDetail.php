<?php
require_once 'services/manager_session.php';
require_once 'services/campanha.php';
require_once 'services/publico.php';
require_once 'services/funcoes.php';

session_start();
ManagerSession::validaAcesso(10);

if(!empty($_GET)){
    $dados = listarCampanha($_GET['i']);
    
    if($dados == "nenhum"){
        echo "<script>location.href='home'</script>";
    }
    
    $publicos = listarPublicos();
    $publicosCampanha = buscaPublicosPorCampanha($dados->id);
    
    $status = getStatusCiclo($dados->status);
    
    
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
    <link href="css/datepicker.css" rel="stylesheet">    
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
                            <h2>Campanha</h2>
                        </div>
                        <div class="card-body card-padding">
                            <div class="row">
                            <div class="col-sm-4">
                                <img style="width: 100%" src="../../mapping_api/<?php echo $dados->layout ?>"/>
                                <a style="margin-top: 25px" data-toggle="modal" href="#modalLayout" class="">Alterar layout</a>
                            </div>
                            
                            <div class="col-sm-8">
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="fg-line form-group">
                                                <label>Nome</label>
                                                <p><?php echo $dados->nome ?></p>
                                            </div>
                                        </div>

                                        <div class="col-sm-3">
                                            <div class="fg-line form-group">
                                                <label>Início</label>
                                                <p><?php echo formata_padrao_data($dados->inicio) ?></p>
                                            </div>
                                        </div>
                                        <div class="col-sm-3">
                                            <div class="fg-line form-group">
                                                <label>Termino</label>
                                                <p><?php echo formata_padrao_data($dados->fim) ?></p>
                                            </div>
                                        </div>   

                                        <div class="col-sm-6">
                                            <div class="fg-line form-group">
                                                <label>Descrição</label>
                                                <p><?php echo $dados->descricao ?></p>
                                            </div>
                                        </div>  
                                        <div class="col-sm-6">
                                            <div class="fg-line form-group">
                                                <label>Ambiente</label>
                                                <p><?php echo getAmbientePublicidade($dados->ambiente) ?></p>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="fg-line form-group">
                                                <label>Status</label>
                                                <p><?php echo $status ?></p>
                                            </div>
                                        </div> 
                                        
                                        <div class="col-sm-12">
                                            <div class="fg-line form-group">
                                                <label>Públicos alvos</label>
                                                <select disabled="" class="chosen" multiple data-placeholder="Nenhum">

                                                    <?php
                                                        if($publicos != "nenhum"){
                                                            foreach ($publicos as $publico){
                                                            $valida = validaPublicoCampanha($publico->id, $dados->id);
                                                    ?>
                                                        <option <?php if($valida->message == "true"){?> selected="" <?php }?> value="<?php echo $publico->id ?>"><?php echo $publico->nome ?></option>
                                                    <?php
                                                        }
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>                                         
                                        
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
                        <a href="campanhas" style="float: left" class="btn bgm-gray btn-icon-text"><i class="zmdi zmdi-arrow-back"></i> Voltar</a>
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

                    <form class="formularioEdit" action="services/campanha.php" method="POST">
                        <input type="hidden" name="function" value="edit"/> 
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
                                    
                                <div class="col-sm-3">
                                    <div class="fg-line form-group">
                                        <label>Data de início</label>
                                        <input id="data" type="text" value="<?php echo formata_padrao_data($dados->inicio) ?>" class="form-control input-sm datas" data-toggle="datepicker" name="inicio" required="">
                                    </div>
                                </div>

                                <div class="col-sm-3">
                                    <div class="fg-line form-group">
                                        <label>Data de termino</label>
                                        <input id="data" type="text" value="<?php echo formata_padrao_data($dados->fim) ?>" class="form-control input-sm datas" data-toggle="datepicker" name="fim" required="">
                                    </div>
                                </div>
                                    
                                <div class="col-sm-12">
                                    <div class="fg-line form-group">
                                        <label>Ambiente</label>
                                        <select class="chosen" name="ambiente">
                                            <option <?php if ($dados->ambiente == "i"){ ?> selected="" <?php }?> value="i">Interna</option>
                                            <option <?php if ($dados->ambiente == "e"){ ?> selected="" <?php }?> value="e">Externa</option>
                                        </select>
                                    </div>
                                </div>                                    
                                    
                                <div class="col-sm-12">
                                    <label>Selecione os públicos alvos</label>
                                    <select class="chosen" required="" name="publicos[]" multiple data-placeholder="Selecionar...">
                                        
                                        <?php
                                            if($publicos != "nenhum"){
                                                foreach ($publicos as $publico){
                                                $valida = validaPublicoCampanha($publico->id, $dados->id);
                                        ?>
                                        
                                        <option <?php if($valida->message == "true"){?> selected="" <?php }?> value="<?php echo $publico->id ?>"><?php echo $publico->nome ?></option>
                                          
                                        <?php
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>                                    
                                    
                                    <div class="col-sm-12" style="margin-top: 20px">
                                    <div class="fg-line form-group">
                                        <label>Descricao</label>
                                        <textarea id="descricao" type="text" rows="4" class="form-control input-sm" name="descricao"><?php echo $dados->descricao ?></textarea>
                                    </div>
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
        
        <div class="modal fade" id="modalLayout" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">ALTERAR LAYOUT</h4>
                    </div>

                    <form class="formularioEditLayout" action="services/campanha.php" method="POST">
                        <input type="hidden" name="function" value="editLayout"/> 
                        <input type="hidden" name="id" value="<?php echo $dados->id ?>"/>
                        <div class="card">
                            <div class="card-body card-padding">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="fg-line form-group">
                                            <label>Layout</label>
                                            <input type="file" class="form-control input-sm" name="layout" required="">
                                        </div>
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
    <script src="vendors/sparklines/jquery.sparkline.min.js"></script>

    <!-- FLOT CHART JS -->
    <script src="vendors/bower_components/chosen/chosen.jquery.js"></script>
    <script src="vendors/bower_components/flot/jquery.flot.js"></script>
    <script src="vendors/bower_components/flot/jquery.flot.resize.js"></script>
    <script src="vendors/bower_components/flot.tooltip/js/jquery.flot.tooltip.min.js"></script>
    <script src="vendors/flot-orderbars/jquery.flot.orderBars.js"></script>
    <script src="vendors/flot-orderbars/jquery.flot.categories.js"></script>
    <script src="vendors/bower_components/jquery-mask-plugin/dist/jquery.mask.min.js"></script>
    <script src="js/datepicker.js"></script>
    <script src="js/datepicker.pt-BR.js"></script>
    <!-- Placeholder for IE9 -->
    <!--[if IE 9 ]>
        <script src="vendors/bower_components/jquery-placeholder/jquery.placeholder.min.js"></script>
    <![endif]-->

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
            
            $('.formularioEditLayout').ajaxForm({
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
                    url: "services/campanha.php",
                    dataType: "html",
                    success: function(data){
                        swal({
                            title: "Removido com sucesso",
                            text: "",
                            type: "success",
                            confirmButtonText: "Ok"
                        }).then(function () {
                            location.href='campanhas';
                        });                         
                        
                    }                    
                });
        }
        
        $('#valor').mask('#.##0,00', {reverse: true});
        
    </script>      

</body>
</html>
