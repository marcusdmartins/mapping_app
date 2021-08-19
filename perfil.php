<?php
require_once 'services/manager_session.php';
require_once 'services/pessoa.php';
require_once 'services/tipoUsuario.php';
require_once 'services/funcoes.php';

session_start();
ManagerSession::validaAcesso(6);

    $dados = listarPessoa($_SESSION['UsuarioID']);
    
    if($dados == "nenhum"){
        echo "<script>location.href='home'</script>";
    }


$tiposUsuario = listarTiposUsuario();

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
                            <h2>Meu Perfil</h2>
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
                                        <label>Email</label>
                                        <p><?php echo $dados->email ?></p>
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="fg-line form-group">
                                        <label>Tipo de usuário</label>
                                        <p><?php echo $dados->tipo_usuario_nome ?></p>
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
                        <a href="javascript:history.back()" style="float: left" class="btn bgm-gray btn-icon-text"><i class="zmdi zmdi-arrow-back"></i> Voltar</a>
                        <a data-toggle="modal" href="#edit" style="float: right; margin: 5px" class="btn bgm-black btn-icon-text"><i class="zmdi zmdi-edit"></i> Editar</a>
                        <a data-toggle="modal" href="#alteraSenha" style="float: right; margin: 5px" class="btn bgm-black btn-icon-text"><i class="zmdi zmdi-dialpad"></i> Alterar senha</a>
                    </div>
            </div>              
        </section>
        
        <div class="modal fade" id="edit" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">EDITAR DADOS</h4>
                    </div>

                    <form class="formularioEdit" action="services/pessoa.php" method="POST">
                        <input type="hidden" name="function" value="edit"/> 
                        <input type="hidden" name="id" value="<?php echo $dados->id ?>"/>
                        <input type="hidden" name="tipoUsuario" value="<?php echo $dados->tipo_usuario ?>"/>
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
                                            <label>Email</label>
                                            <input type="text" value="<?php echo $dados->email ?>" class="form-control input-sm" name="email" required="">
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
        
        <!-- Modal Default -->
        <div class="modal fade" id="alteraSenha" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">ALTERAR SENHA</h4>
                    </div>

                        <form class="formSenha" action="services/pessoa.php" method="POST">
                            <input type="hidden" value="altera_senha" name="function" />
                            <input name="id" type="hidden" value="<?php echo $_SESSION['UsuarioID']; ?>">
                            <div class="card">
                                <div class="card-body card-padding">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="form-group fg-line">
                                                <input type="password" name="senha_antiga" class="form-control input-sm" id="exampleInputEmail1"
                                                       placeholder="Senha atual">
                                            </div>
                                        </div>
                                        <div class="col-sm-12">
                                            <div class="form-group fg-line">
                                                <input type="password" name="senha_nova" class="form-control input-sm" id="exampleInputPassword1"
                                                       placeholder="Nova senha">
                                            </div>
                                        </div>  
                                        <div class="col-sm-12">
                                            <div class="form-group fg-line">
                                                <input type="password" name="repeticao" class="form-control input-sm" id="exampleInputPassword1"
                                                       placeholder="Confirme a nova senha">
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
            
            $('.formSenha').ajaxForm({
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
                            text: result.responseText,
                            type: "error"
                        });                        
                    }

                }
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
        });
        
        $('.bloq').click(function () {    
            swal({
                title: "Tem certeza?",
                text: "O usuário será bloqueado!",
                type: "warning",
                showCancelButton: true,
                cancelButtonText: "Cancelar",
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Sim, bloquear!",
                closeOnConfirm: false
            }).then(function () {
                bloq(<?php echo $dados->id ?>);
            });
        });
        
        function bloq(id){
            $.ajax({
                    type: "POST",
                    data: {i:id, function:'bloq'},
                    url: "services/pessoa.php",
                    dataType: "html",
                    success: function(data){
                        swal({
                            title: "Bloqueado com sucesso",
                            text: "",
                            type: "success",
                            confirmButtonText: "Ok"
                        }).then(function () {
                            location.reload();
                        });                         
                    }                    
                });
        }
        
        $('.desbloq').click(function () {    
            swal({
                title: "Tem certeza?",
                text: "O usuário será desbloqueado!",
                type: "warning",
                showCancelButton: true,
                cancelButtonText: "Cancelar",
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Sim, desbloquear!",
                closeOnConfirm: false
            }).then(function () {
                desbloq(<?php echo $dados->id ?>);
            });
        });
        
        function desbloq(id){
            $.ajax({
                    type: "POST",
                    data: {i:id, function:'desbloq'},
                    url: "services/pessoa.php",
                    dataType: "html",
                    success: function(data){
                        swal({
                            title: "Desbloqueado com sucesso",
                            text: "",
                            type: "success",
                            confirmButtonText: "Ok"
                        }).then(function () {
                            location.reload();
                        });                         
                    }                    
                });
        }
        
        $('.reset').click(function () {    
            swal({
                title: "Tem certeza?",
                text: "A senha deste usuário será resetada!",
                type: "warning",
                showCancelButton: true,
                cancelButtonText: "Cancelar",
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Sim, resetar!",
                closeOnConfirm: false
            }).then(function () {
                reset(<?php echo $dados->id ?>);
            });
        });
        
        function reset(id){
            $.ajax({
                    type: "POST",
                    data: {i:id, function:'reset'},
                    url: "services/pessoa.php",
                    dataType: "html",
                    success: function(data){
                        swal({
                            title: "Senha resetada com sucesso",
                            text: "",
                            type: "success",
                            confirmButtonText: "Ok"
                        }).then(function () {
                            location.reload();
                        });                         
                    }                    
                });
        }        
        
        $('#valor').mask('#.##0,00', {reverse: true});
        
    </script>      

</body>
</html>
