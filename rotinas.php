<?php
require_once 'services/manager_session.php';
require_once 'services/tipoUsuario.php';
session_start();
ManagerSession::validaAcesso(5);

$rotinas_1 = listarRotinas();
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
               
               <div class="card">
                        <div class="card-header">
                            <h2>Permissões</h2>
                        </div>
                        <div class="card-body card-padding">
                            <div class="row">
                                
                            <?php
                            if($rotinas_1 != "nenhum"){
                                foreach ($rotinas_1 as $rotina){
                            ?>
                                
                                <div class="col-sm-12">
                                    <div class="fg-line form-group">
                                        <blockquote class="m-b-25">                          
                                        <p class="lead"><?php echo $rotina->nome ?></p>
                                        
                                        <?php
                                        if($rotina->subRotinas != "nenhum"){
                                            foreach ($rotina->subRotinas as $subRotinas){
                                        ?>
                                            <a class="list-group-item media" href="subRotinaDetail?i=<?php echo $subRotinas->id ?>">
                                                <div class="pull-left">
                                                    <img class="lgi-img" src="img/icons/rotina.png" alt="">
                                                </div>
                                                <div class="media-body">
                                                    <div class="lgi-heading"><?php echo $subRotinas->nome ?></div>
                                                    <small class="lgi-text"><?php echo $subRotinas->path ?></small>
                                                </div>
                                            </a>                                            
                                         
                                        <?php
                                            }
                                        }else{
                                            echo "nenhuma subrotina";
                                        }
                                        ?>
                                      </blockquote>  
                                    </div>
                                </div>
                                
                                <hr>
                                
                            <?php
                                }
                            }else{
                                echo "nenhuma rotina";
                            }
                            ?>
                                
                            </div>
                        </div>
                    </div>               
                    <div class="card-body">
                        <a href="#subrotina" data-toggle="modal" style="float: right" class="btn bgm-black btn-icon-text"><i class="zmdi zmdi-plus"></i> Nova Subrotina</a>
                    </div>
               
            </div>              
        </section>
        
        <div class="modal fade" id="subrotina" role="dialog" aria-hidden="true" >
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">NOVA SUBROTINA</h4>
                    </div>

                    <form class="formularioSub" action="services/rotina.php" method="POST">
                        <input type="hidden" name="function" value="novaSubRotina"/> 
                        <div class="card">
                            <div class="card-body card-padding">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="fg-line form-group">
                                            <input type="text" class="form-control input-sm" name="nome" placeholder="Nome" required="">                                                       
                                        </div>
                                    </div>
                                    
                                    <div class="col-sm-6">
                                        <div class="fg-line form-group">
                                            <input type="text" class="form-control input-sm" name="icon" placeholder="Icone">                                                       
                                        </div>
                                    </div> 
                                    
                                    <div class="col-sm-12">
                                        <div class="fg-line form-group">
                                            <input type="text" class="form-control input-sm" name="path" placeholder="Path">                                                       
                                        </div>
                                    </div>                                     
                                    
                                <div class="col-sm-6">  
                                    <div class="fg-line form-group">
                                        <label>Rotina</label><br>
                                        <select class="chosen" placeholder="Selecione a rotina" name="id_rotina">
                                            
                                                <option disabled="" selected="" value="">SELECIONE</option>
                                                <?php
                                                if($rotinas_1 != "nenhum"){
                                                foreach ($rotinas_1 as $rotina1) {
                                                    ?>
                                                    <option value="<?php echo $rotina1->id ?>"><?php echo $rotina1->nome ?></option>
                                                    <?php
                                                }
                                                }else{
                                                    echo 'nenhuma rotina';
                                                }
                                                ?>
                                            </optgroup>

                                        </select>
                                    </div>
                                </div>
                                    
                                <div class="col-sm-6">  
                                    <div class="fg-line form-group">
                                        <label>Disponível no Menu</label><br>
                                        <select class="chosen" placeholder="Selecione a rotina" name="menu">
                                            <option disabled="" selected="" value="">SELECIONE</option>
                                            <option value="s">SIM</option>
                                            <option value="n">Não</option>
                                            </optgroup>

                                        </select>
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
            $('.formularioSub').ajaxForm({
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
        });       
    </script>      

</body>
</html>
