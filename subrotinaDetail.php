<?php
require_once 'services/manager_session.php';
require_once 'services/rotina.php';
require_once 'services/tipoUsuario.php';
require_once 'services/funcoes.php';

session_start();
ManagerSession::validaAcesso(5);

if(!empty($_GET)){
    $dados = listarSubrotina($_GET['i']);
    $rotina_sub = listarRotina($dados->rotina_id);
    
    if($dados->menu == "s"){
        $opc_menu = "Sim";
    }else if($dados->menu == "n"){
        $opc_menu = "Não";
    }
    
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
                            <h2>Subrotina</h2>
                        </div>
                        <div class="card-body card-padding">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="fg-line form-group">
                                        <label>Nome</label>
                                        <p><?php echo $dados->nome ?></p>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="fg-line form-group">
                                        <label>Rotina</label>
                                        <p><?php echo $rotina_sub->nome ?></p>
                                    </div>
                                </div> 
                                <div class="col-sm-6">  
                                    <div class="fg-line form-group">
                                        <label>Path</label><br>
                                        <p><?php echo $dados->path ?></p>
                                    </div>
                                </div>
                                
                                <div class="col-sm-6">  
                                    <div class="fg-line form-group">
                                        <label>Menu</label><br>
                                        <p><?php echo $opc_menu ?></p>
                                    </div>
                                </div>

                                <div class="col-sm-6">  
                                    <div class="fg-line form-group">
                                        <label>Icone</label><br>
                                        <p><?php echo $dados->icon ?></p>
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
                        <a href="rotinas" style="float: left" class="btn bgm-gray btn-icon-text"><i class="zmdi zmdi-arrow-back"></i> Voltar</a>
                        <a style="float: right; margin: 5px" class="btn bgm-red btn-icon-text delete" id="delete"><i class="zmdi zmdi-delete"></i> Excluir</a>
                        <a data-toggle="modal" href="#edit" style="float: right; margin: 5px" class="btn bgm-black btn-icon-text"><i class="zmdi zmdi-edit"></i> Editar</a>
                    </div>
            </div>              
        </section>
        
        <div class="modal fade" id="edit" role="dialog" aria-hidden="true" >
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">EDITAR DADOS</h4>
                    </div>

                    <form class="formularioEdit" action="services/rotina.php" method="POST">
                        <input type="hidden" name="function" value="editSubRotina"/> 
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
                                            <label>Rotina</label><br>
                                            <select class="chosen" placeholder="Selecione a rotina" name="id_rotina">

                                                    <?php
                                                    $rotinas_2 = listarRotinas();
                                                    if($rotinas_2 != "nenhum"){
                                                    foreach ($rotinas_2 as $rotina1) {
                                                        ?>
                                                        <option <?php if($rotina1->id == $dados->rotina_id){?> selected="" <?php }?> 
                                                            value="<?php echo $rotina1->id ?>"><?php echo $rotina1->nome ?></option>
                                                        <?php
                                                    }
                                                    }else{
                                                        echo 'nenhuma rotina';
                                                    }
                                                    ?>
                                            </select>
                                        </div>
                                    </div>                                    

                                    <div class="col-sm-6">  
                                        <div class="fg-line form-group">
                                            <label>Menu</label><br>
                                            <select class="chosen" placeholder="Selecione o curso" name="menu">
                                                        <option <?php if($dados->menu == "s"){?> selected="" <?php }?> value="s">Sim</option>
                                                        <option <?php if($dados->menu == "n"){?> selected="" <?php }?> value="n">Não</option>
                                                </optgroup>

                                            </select>
                                        </div>
                                    </div>
                                    
                                    <div class="col-sm-6">
                                        <div class="fg-line form-group">
                                            <label>Path</label>
                                            <input type="text" value="<?php echo $dados->path ?>" class="form-control input-sm" name="path">
                                        </div>
                                    </div> 
                                    
                                    <div class="col-sm-6">
                                        <div class="fg-line form-group">
                                            <label>Icone</label>
                                            <input type="text" value="<?php echo $dados->icon ?>" class="form-control input-sm" name="icon">
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
                    data: {i:id, function:'removerSubRotina'},
                    url: "services/rotina.php",
                    dataType: "html",
                    success: function(data){
                        swal({
                            title: "Removido com sucesso",
                            text: "",
                            type: "success",
                            confirmButtonText: "Ok"
                        }).then(function () {
                            location.href='rotinas';
                        });                         
                        
                        
                    }                    
                });
        }
        
        $('#valor').mask('#.##0,00', {reverse: true});
        
    </script>      

</body>
</html>
