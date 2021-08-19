<?php
require_once 'services/manager_session.php';
require_once 'services/campanha.php';
require_once 'services/midia.php';
require_once 'services/publico.php';
require_once 'services/tipomidia.php';
require_once 'services/grupo.php';
require_once 'services/subgrupo.php';
require_once 'services/local.php';
require_once 'services/publicidade.php';
require_once 'services/funcoes.php';
session_start();
ManagerSession::validaAcesso(15);

$campanhas = listarCampanhas();
$tipomidias = listarTipoMidias();
$grupos = listarGrupos();
$locais = listarLocais();

if(!empty($_GET)){
    $dados = listarPublicidade($_GET['i']);
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
                    <input type="hidden" name="function" value="edit"/>
                    <input type="hidden" name="ambiente" value="e"/>
                    <input type="hidden" name="pessoa_log" value="<?php echo $_SESSION['UsuarioID']?>"/>
                    <input type="hidden" name="id" value="<?php echo $dados->id ?>"/>
                    <div class="card">
                        <div class="card-header">
                            <h2>Informações da Publicidade</h2>
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
                                                <option <?php if($dados->id_campanha == $campanha->id){?> selected="" <?php }?> 
                                                    value="<?php echo $campanha->id ?>"><?php echo $campanha->nome ?></option>
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
                                        if($tipomidias != "nenhum"){
                                            foreach ($tipomidias as $tipomidia){
                                                $midias = listarMidiaPorTipo($tipomidia->id);
                                        ?>
                                        
                                            <optgroup label="<?php echo $tipomidia->nome ?>">
                                                <?php
                                                    if($midias != "nenhum"){
                                                        foreach ($midias as $midia){
                                                ?>
                                                    <option <?php if($dados->id_midia == $midia->id){?> selected="" <?php }?> 
                                                        value="<?php echo $midia->id ?>"><?php echo $midia->nome ?></option>
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
                                        <select class="chosen" name="status">
                                                <option disabled="" selected="" value="">SELECIONE</option>
                                                <option <?php if($dados->status == 'i'){?> selected="" <?php }?> 
                                                    value="i">Inativa</option>
                                                <option <?php if($dados->status == 'a'){?> selected="" <?php }?> 
                                                    value="a">Ativa</option>
                                        </select>
                                    </div>
                                </div>
                                
                                <div class="col-sm-12">
                                    <div class="fg-line form-group">
                                        <label>Descrição</label>
                                        <input type="text" class="form-control input-sm" value="<?php echo $dados->descricao ?>" id="descricao" name="descricao">
                                    </div>
                                </div>                                

                                <div style="display: none" class="col-sm-12">
                                    <div class="fg-line form-group">
                                        <label>Local</label><br>
                                        <select class="chosen" name="id_local" id="local" onchange="atualizarCombos()">
                                            
                                                <option disabled="" selected="" value="">SELECIONE</option>
                                                <?php
                                                if($locais != "nenhum"){
                                                foreach ($locais as $local) {
                                                    ?>
                                                    <option <?php if($dados->id_local == $local->id){?> selected="" <?php }?>
                                                        value="<?php echo $local->id ?>"><?php echo "$local->nome - $local->nome_subgrupo - $local->nome_grupo" ?></option>
                                                    <?php
                                                }
                                                }else{
                                                    echo 'nenhum local';
                                                }
                                                ?>
                                        </select>
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
                                
                                <div class="col-sm-6">
                                    <!--CICLOS-->
                                    <label>Ciclos desta publicidade</label><br>
                                    <?php
                                    
                                    if($dados->ciclo != "nenhum"){
                                        foreach ($dados->ciclo as $ciclo){
                                    ?>
                                    
                                    <div class="card-padding animated fadeIn" style="padding-bottom: 20px">
                                        
                                        <a id="" class="list-group-item media grupoList" href="#modalCiclo<?php echo $ciclo->id?>" data-toggle="modal">
                                            <div class="media-body">
                                                <div class="lgi-heading"><strong>Inicio: </strong> <?php echo formata_padrao_data($ciclo->ciclo_inicio)?></div>
                                                <div class="lgi-heading"><strong>Termino: </strong> <?php echo formata_padrao_data($ciclo->ciclo_fim)?></div>
                                                <div style="margin-top: -30px" class="lgi-heading pull-right"><strong>Status: </strong> <?php echo getStatusCiclo($ciclo->ciclo_status)?></div>
                                            </div>
                                        </a>  
                                    </div>

                                   <?php
                                        }
                                    }
                                    else{
                                        echo "<p>Nenhum Ciclo</p>";
                                    }
                                   ?>
                                    
                                   <a href="#novoCiclo" data-toggle="modal" class="pull-right">Novo Ciclo</a>
                                    
                                </div>  
                                
                            </div>
                            
                            <div class="row" style="margin-top: 10px">
                                <div class="col-sm-12">
                                    <div class="fg-line form-group">
                                        <label>Encontre o local no Mapa</label><br>
                                        <div id="mapa" style="height: 500px; width: 100%"></div>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="fg-line form-group">
                                        <label>Latitude</label><br>
                                        <input type="text" value="<?php echo $dados->latitude ?>" class="form-control input-sm" id="lat" name="latitude" required="">
                                    </div>
                                </div>
                                
                                <div class="col-sm-3">
                                    <div class="fg-line form-group">
                                        <label>Longitude</label><br>
                                        <input type="text" value="<?php echo $dados->longitude ?>" class="form-control input-sm" id="lng" name="longitude" required="">
                                    </div>
                                </div>                                
                            </div>                            
                        </div>
                    </div>
                    
                    <div class="card-body">
                        <a href="javascript:window.history.go(-1)" style="float: left" class="btn bgm-gray btn-icon-text"><i class="zmdi zmdi-arrow-back"></i> Voltar</a>
                        <button type="submit" style="float: right; margin: 2px" class="btn bgm-black btn-icon-text"><i class="zmdi zmdi-plus"></i> Salvar</button>
                        <a onclick="excl_publicidade(<?php echo $dados->id ?>)" style="float: right; margin: 2px" class="btn bgm-red btn-icon-text"><i class="zmdi zmdi-delete"></i> Excluir</a>
                    
                    <!-- SPINEER DE LOADING -->    
                    <div class="preloader loadingCliente" style="display: none">
                        <svg class="pl-circular" viewBox="25 25 50 50">
                        <circle class="plc-path" cx="50" cy="50" r="20"/>
                        </svg>
                    </div> 
                    </div>

                </form>
               
               
                <!-- MODAL DE NOVOS CICLOS -->
               
                <div class="modal fade" id="novoCiclo" role="dialog" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title">NOVO CICLO</h4>
                            </div>

                            <form class="formularioCiclo" action="services/publicidade.php" method="POST">
                                <input type="hidden" name="function" value="novoCiclo"/>
                                <input type="hidden" name="id_publicidade" value="<?php echo $dados->id ?>"/>
                                <div class="card">
                                    <div class="card-body card-padding">
                                    <div class="row">
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

                                        <div class="col-sm-6">
                                            <div class="fg-line form-group">
                                                <label>Custo (R$)</label>
                                                <input type="text" class="form-control input-sm custo" id="custo" name="custo" required="">
                                            </div>
                                        </div>                                                

                                        <div class="col-sm-12">
                                            <div class="preloader loadingEdit" style="display: none; float: left; padding-top: 5px">
                                                <svg class="pl-circular" viewBox="25 25 50 50">
                                                <circle class="plc-path" cx="50" cy="50" r="20"/>
                                                </svg>
                                            </div>    
                                        </div>
                                        <div class="col-sm-12">
                                            <div class="modal-footer">
                                                <button type="submit" class="btn btn-link">Salvar</button>
                                                <button type="button" class="btn btn-link" data-dismiss="modal">Cancelar</button>
                                            </div>                                    
                                        </div>
                                    </div>

                                    </div>
                                </div>
                            </form> 
                        </div>
                    </div>
                </div>               
               
                <!-- MODAIS CICLO -->
                
                <?php
                if($dados->ciclo != "nenhum"){
                    foreach ($dados->ciclo as $ciclo2){
                ?>
               
                    <div class="modal fade" id="modalCiclo<?php echo $ciclo2->id ?>" role="dialog" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title">EDITAR CICLO</h4>
                                </div>

                                <form class="formularioCiclo" action="services/publicidade.php" method="POST">
                                    <input type="hidden" name="function" value="editCiclo"/> 
                                    <input type="hidden" name="id" value="<?php echo $ciclo2->id ?>"/>
                                    <div class="card">
                                        <div class="card-body card-padding">
                                        <div class="row">
                                            <div class="col-sm-3">
                                                <div class="fg-line form-group">
                                                    <label>Início do Ciclo</label>
                                                    <input type="text" value="<?php echo formata_padrao_data($ciclo2->ciclo_inicio)?>" class="form-control input-sm datas" data-toggle="datepicker" id="inicio" name="inicio" required="">
                                                </div>
                                            </div>

                                            <div class="col-sm-3">
                                                <div class="fg-line form-group">
                                                    <label>Término do Ciclo</label>
                                                    <input type="text" value="<?php echo formata_padrao_data($ciclo2->ciclo_fim)?>" class="form-control input-sm datas" data-toggle="datepicker" id="fim" name="fim" required="">
                                                </div>
                                            </div>

                                            <div class="col-sm-6">
                                                <div class="fg-line form-group">
                                                    <label>Custo individual (R$)</label>
                                                    <input type="text" value="<?php echo moeda($ciclo2->ciclo_custo)?>" class="form-control input-sm custo" id="custo" name="custo" required="">
                                                </div>
                                            </div>                                                

                                            <div class="col-sm-12">
                                                <div class="preloader loadingEdit" style="display: none; float: left; padding-top: 5px">
                                                    <svg class="pl-circular" viewBox="25 25 50 50">
                                                    <circle class="plc-path" cx="50" cy="50" r="20"/>
                                                    </svg>
                                                </div>    
                                            </div>
                                            <div class="col-sm-12">
                                                <div class="modal-footer">
                                                    <button type="submit" class="btn btn-link">Salvar</button>
                                                    <button type="button" class="btn btn-link" data-dismiss="modal">Cancelar</button>
                                                    <button type="button" style="color: #c12e2a" class="btn btn-link" onclick="excl_ciclo(<?php echo $ciclo2->id ?>)">Excluir</button>
                                                </div>                                    
                                            </div>
                                        </div>

                                        </div>
                                    </div>
                                </form> 
                            </div>
                        </div>
                    </div>               
               <?php
                    }
                }
                ?>

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
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDQfsOR1rKIXnNbydRdYqr1p9xvdNjmYvs"></script>
    
    <script>
        $(function(){
            
            window.onload = function(){
                preencheImpactos();
                buscaPublicosCampanha();
            }            
            
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
                            title: "Atualizado com sucesso",
                            text: "Registro atualizado com sucesso",
                            type: "success",
                            confirmButtonText: "Ok"
                        }).then(function(){
//                            location.reload();
                        });   
                    }else{
                        swal({
                            title: "Falha ao atualizar",
                            
                            type: "error"
                        });                        
                    }
                }
            });
            
            $('.formularioCiclo').ajaxForm({
                beforeSend: function () {
                    $('.loadingCliente').css({display: "block"});
                },
                success: function () {
                    $('.loadingCliente').css({display: "none"});
                },
                complete: function(result){
                    location.reload();
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
        
        function preencheImpactos(){
            $.ajax({
               url: "services/local.php",
               type: 'POST',
               data:{function: 'impactoPorLocalInst', id_local: $("#local").val()},
               success:function(data){
                   $("#impactos").html(data);
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
        
        function excl_ciclo(id){   
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
                excl_action(id);
            });
        };
        
        function excl_action(id){
            $.ajax({
                    type: "POST",
                    data: {i:id, function:'remover_ciclo'},
                    url: "services/publicidade.php",
                    dataType: "html",
                    success: function(data){
                        swal({
                            title: "Removido com sucesso",
                            text: "",
                            type: "success",
                            confirmButtonText: "Ok"
                        }).then(function () {
                            location.reload();
                        });                         
                        
                        
                    }                    
                });
        }
        
        function excl_publicidade(id){   
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
                excl_publicidade_action(id);
            });
        };
        
        function excl_publicidade_action(id){
            $.ajax({
                    type: "POST",
                    data: {i:id, function:'remover'},
                    url: "services/publicidade.php",
                    dataType: "html",
                    success: function(data){
                        swal({
                            title: "Removido com sucesso",
                            text: "",
                            type: "success",
                            confirmButtonText: "Ok"
                        }).then(function () {
                            location.href='publicidadesCampanha';
                        });                         
                        
                        
                    }                    
                });
        }        
        
        $('.custo').mask('#.##0,00', {reverse: true});
        
    </script>
    
    
<script>
    var latitude = <?php echo $dados->latitude ?>;
    var longitude = <?php echo $dados->longitude ?>;
    function markerIncial(){
        createMarker(latitude, longitude);
    }    
    
    var map;
    var marker;

    function initialize() {
       var mapOptions = {
          center: new google.maps.LatLng(latitude, longitude),
          zoom: 14,
          mapTypeId: 'roadmap'
       };

       map = new google.maps.Map(document.getElementById('mapa'), mapOptions);

       google.maps.event.addListener(map, "click", function(event) {

          var lat = event.latLng.lat().toFixed(6);
          var lng = event.latLng.lng().toFixed(6);

          createMarker(lat, lng);
          getCoords(lat, lng);

       });

       markerIncial();
    }
    google.maps.event.addDomListener(window, 'load', initialize);

    function createMarker(lat, lng) {

       if (marker) {
          marker.setMap(null);
          marker = "";
       }

       marker = new google.maps.Marker({
          position: new google.maps.LatLng(lat, lng),
          draggable: true,
          map: map
       });

       google.maps.event.addListener(marker, 'dragend', function() {

          marker.position = marker.getPosition();

          var lat = marker.position.lat().toFixed(6);
          var lng = marker.position.lng().toFixed(6);

          getCoords(lat, lng);

       });
    }

    function getCoords(lat, lng) {

       var coords_lat = document.getElementById('lat');
       coords_lat.value = lat;
       var coords_lng = document.getElementById('lng');
       coords_lng.value = lng;
    }    
    
</script>    

</body>
</html>
