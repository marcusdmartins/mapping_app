<?php
require_once 'services/manager_session.php';
require_once 'services/grupo.php';
require_once 'services/publicidade.php';
require_once 'services/campanha.php';
require_once 'services/midia.php';
require_once 'services/publico.php';
session_start();
ManagerSession::validaAcesso(1);
$grupos = listarGrupos();

$proximas_campanhas = buscaProximasCampanhas();
$campanhas_andamento = buscaCampanhasEmAndamento();

$midias_digitais = listarMidiaPorTipo(3);
$midias_externas = buscaPublicidadesPorAmbiente("e");

$campanhas = listarCampanhas();

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
                    <div class="block-header">
                        <h2>VISÃO GERAL</h2>
                    </div>

                    <div class="card">
                    <div class="card-body">
                        <ul class="tab-nav tn-justified tn-icon" role="tablist">
                            <li role="presentation" class="active">
                                <a class="col-sx-4" href="#tab-1" aria-controls="tab-1" role="tab"
                                   data-toggle="tab"> 
                                    <i style="margin: 10px; top: 10px" class="zmdi zmdi-home icon-tab"> </i> Mídias Internas
                                </a>
                            </li>
                            <li role="presentation">
                                <a class="col-xs-4" href="#tab-2" aria-controls="tab-2" role="tab"
                                   data-toggle="tab">
                                    <i style="margin: 10px; top: 10px" class="zmdi zmdi-globe-alt icon-tab"></i> Mídias Digitais & Eletrônicas
                                </a>
                            </li>
                            <li role="presentation">
                                <a class="col-xs-4" href="#tab-3" aria-controls="tab-3" role="tab"
                                   data-toggle="tab">
                                    <i style="margin: 10px; top: 10px" class="zmdi zmdi-pin icon-tab"></i> Mídias Externas
                                </a>
                            </li>
                        </ul>

                        <div class="tab-content p-20">
                            <div role="tabpanel" class="tab-pane animated fadeIn in active" id="tab-1" style="background-color: #f0f0f0; padding: 15px">
                            <div class="container">
                                <div class="row">
                                    <div class="card col-sm-2" style="margin: 0px">
                                        <div class="card-header">
                                            GRUPO
                                        </div>
                                        <?php
                                            foreach ($grupos as $grupo){
                                                $qtd = buscaQtdPublicidadePorGrupo($grupo->id);
                                        ?>
                                            <div class="card-padding animated fadeIn" style="padding-bottom: 20px">
                                                <a id="grupo<?php echo $grupo->id ?>" class="list-group-item media grupoList" href="#" onclick="buscaSubgrupos(<?php echo $grupo->id ?>)">
                                                    <div class="media-body">
                                                        <div class="lgi-heading"><?php echo $grupo->nome ?>
                                                            <?php
                                                                if($qtd->qtd > 0){
                                                            ?>
                                                            <div class="chip" style="margin-top: 1px; float: right; color: #FFF">
                                                                <?php echo $qtd->qtd ?>
                                                            </div>
                                                            <?php
                                                                }
                                                            ?>                                                        
                                                        </div>
                                                    </div>
                                                </a>  
                                            </div>
                                        <?php
                                            }
                                        ?>
                                    </div>

                                    <div class="card col-sm-2" style="margin: 0px">
                                        <div class="card-header">
                                            SUBGRUPO
                                        </div>
                                        <div id="content-subgrupo">

                                        </div>
                                    </div>

                                    <div class="card col-sm-2" style="margin: 0px">
                                        <div class="card-header">
                                            LOCAL
                                        </div>
                                        <div id="content-local">

                                        </div>                        
                                    </div>  

                                    <div class="card col-sm-6" style="margin: 0px">
                                        <div class="card-header">
                                            PUBLICIDADE
                                        </div>
                                        <div id="content-publicidade">

                                        </div>                         
                                    </div>                     
                                </div>
                            </div>
                            </div>

                            <div role="tabpanel" class="tab-pane animated fadeIn" id="tab-2" style="background-color: #f0f0f0; padding: 15px">
                                <div class="container">
                                    <div class="row">
                                        <?php
                                            foreach ($midias_digitais as $midia_dig){
                                        ?>
                                        
                                        <div class="card col-sm-12" style="margin: 10px">
                                            <div class="card-header">
                                                <?php echo $midia_dig->nome ?>
                                            </div>
                                            <div id="content-publicidade">
                                                
                                                <?php
                                                    $pubs_digitais = buscaPublicidadesPorMidia($midia_dig->id);
                                                    if($pubs_digitais != "nenhum"){
                                                    foreach ($pubs_digitais as $pub_digital){
                                                        $inicio = formata_padrao_data($pub_digital->ciclo->ciclo_inicio);
                                                        $fim = formata_padrao_data($pub_digital->ciclo->ciclo_fim);
                                                ?>
                                                
                                                <div class="card-padding animated fadeIn" style="padding-bottom: 20px">
                                                    <a id="" class="list-group-item media localList" href="publicidadeDetail?i=<?php echo $pub_digital->id ?>">
                                                        <div class="pull-right">
                                                            <img style="width: 80px" src="../../mapping/<?php echo $pub_digital->layout_campanha ?>" alt="">
                                                        </div>                        
                                                        <div class="media-body">
                                                            <div class="lgi-heading"><?php echo $pub_digital->descricao; ?></div>
                                                            <small><strong>Ciclo: </strong><?php echo $inicio ." à ". $fim ?></small><br>
                                                        </div>
                                                    </a>  
                                                </div>
                                                <?php
                                                    }
                                                }
                                                ?>
                                            </div>                         
                                        </div>
                                        <?php
                                            }
                                        ?>
                                    </div>
                                </div>
                            </div>

                            <div role="tabpanel" class="tab-pane animated fadeIn" id="tab-3">
                                <div id="mapa" style="height: 500px; width: 100%"></div>
                            </div>
                        </div>
                    </div>
                    </div>

                    <div class="row">
                        <div class="col-md-8">
                            <div class="row">
                                <div class="col-md-12 col-sm-12">
                                    <div class="card">
                                        <div class="card-header">
                                            <h2>Média de Públicos impactados por Campanha<small>Selecione a campanha:</small></h2>
                                            <select onchange="graficoImpactoMedio()" placeholder="Nenhuma Campanha" id="campanhaMedia" class="chosen">
                                                <?php
                                                    foreach ($campanhas as $campanha3){
                                                ?>
                                                <option value="<?php echo $campanha3->id ?>"><?php echo $campanha3->nome ?></option>
                                                <?php
                                                    }
                                                ?>
                                            </select>
                                        </div>

                                        <div class="card-body">
                                            <div class="list-group" id="graficoImpacto">
                                                
                                            </div>
                                            <a class="view-more" href="publicos">Ver públicos</a>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="col-md-12 col-sm-12">
                                    <div class="card">
                                        <div class="card-header">
                                            <h2>Custo de Publicidades por Campanha<small>Selecione a campanha:</small></h2>
                                            <select onchange="custoPorCampanha()" id="campanhaCusto" class="chosen">
                                                <?php
                                                    foreach ($campanhas as $campanha3){
                                                ?>
                                                <option value="<?php echo $campanha3->id ?>"><?php echo $campanha3->nome ?></option>
                                                <?php
                                                    }
                                                ?>
                                            </select>
                                        </div>

                                        <div class="card-body card-padding">
                                            <h2 class="animated fadeIn" id="displayCusto"></h2>
                                        </div>
                                    </div>
                                </div>                                
                                
                            </div>
                        </div>

                        <div class="col-md-4 col-sm-6">
                                <div class="card">
                                    <div class="card-header">
                                        <h2>Campanhas em andamento<small></small></h2>
                                    </div>
                                    <div class="card-body" style="padding: 30px; margin-top: -25px">
                                        <div class="fg-line form-group">
                                        <?php
                                        if($campanhas_andamento != "nenhum"){
                                            foreach ($campanhas_andamento as $campanha_2){
                                        ?>
                                            <div class="card-padding animated fadeIn">
                                                <a class="list-group-item media localList" href="campanhaDetail?i=<?php echo $campanha_2->id ?>">
                                                    <div class="pull-right">
                                                        <img style="width: 80px" src="../../mapping/<?php echo $campanha_2->layout ?>" alt="">
                                                    </div>                        
                                                    <div class="media-body">
                                                        <div class="lgi-heading"><?php echo $campanha_2->nome?></div>
                                                        <!--<small><strong>Ciclo: </strong>'.$inicio.' à '.$fim.'</small><br>-->
                                                    </div>
                                                </a>  
                                            </div>
                                        <?php
                                            }
                                        }else{
                                            echo "<p style='margin:15px'>Nenhuma campanha em andamento</p>";
                                        }
                                        ?>
                                        </div>  
                                    </div>
                                    <a class="view-more" href="campanhas">Ver campanhas</a>
                                </div>                            
                            <div class="card">
                                <div class="card-header">
                                    <h2>Próximas campanhas <small></small></h2>
                                </div>
                                <div class="card-body">
                                    <div class="list-group">
                                        
                                    <?php
                                    if($proximas_campanhas != "nenhum"){
                                        foreach ($proximas_campanhas as $campanha1){
                                            $mes = formata_data_mes_abre($campanha1->inicio);
                                            $dia = date('d', strtotime($campanha1->inicio));                                            
                                    ?>
                                        <a href="campanhaDetail?i=<?php echo $campanha1->id ?>">
                                            <div class="list-group-item media">
                                                <div class="pull-left">
                                                    <div class="event-date bgm-green" style="padding: 15px">
                                                        <span class="ed-day"><?php echo $dia ?></span>
                                                        <span class="ed-month-time"><?php echo $mes ?></span>
                                                    </div>
                                                </div>
                                                <div class="media-body">
                                                    <div class="lgi-heading"><?php echo $campanha1->nome ?></div>
                                                    <small class="lgi-text"><?php echo $campanha1->descricao ?></small>
                                                </div>
                                            </div>
                                        </a>
                                    <?php
                                        }
                                        }else{
                                            echo "<p style='margin:25px'>Nenhuma campanha</p>";
                                        }                                        
                                    ?>
                                        <a class="view-more" href="campanhas">Ver campanhas</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
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
    <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDQfsOR1rKIXnNbydRdYqr1p9xvdNjmYvs&callback=initMap"></script>

    <!-- Placeholder for IE9 -->
    <!--[if IE 9 ]>
        <script src="vendors/bower_components/jquery-placeholder/jquery.placeholder.min.js"></script>
    <![endif]-->

    <script src="js/app.min.js"></script>
    <script src="js/jquery.form.js"></script>
    <script src="js/afterglow.min.js"></script>
    <script>
        
        $(document).ready(function(){
           graficoImpactoMedio(); 
           custoPorCampanha();
        });
        
        function graficoImpactoMedio(){
            $.ajax({
               url: "services/publico.php",
               type: 'POST',
               data:{function: 'graficoImpactoCampanha', id_campanha: $("#campanhaMedia").val()},
               success:function(data){
                   $("#graficoImpacto").html(data);
               }
            });
        }
        
        function custoPorCampanha(){
            $.ajax({
               url: "services/campanha.php",
               type: 'POST',
               data:{function: 'custoCampanha', id_campanha: $("#campanhaCusto").val()},
               success:function(data){
                   $("#displayCusto").html(data);
               }
            });
        }        
        
        function alternaJanela(id){
            var janelas = document.getElementsByClassName("janelas");
            var janela = document.getElementById(id);

            var i;
            for (i = 0; i < janelas.length; i++) {
              janelas[i].style.display = "none";
            } 

            janela.style.display="block";
        } 

        function buscaSubgrupos(id_grupo){
            var itens = document.getElementsByClassName("grupoList");
            var i;
            for (i = 0; i < itens.length; i++) {
              itens[i].style.background = "#fff";
            }             
            var item = document.getElementById('grupo'+id_grupo);
            item.style.background = "#85E4F9";
            $("#content-publicidade").html("");
            $("#content-local").html("");
            $.ajax({
               url: "services/subgrupo.php",
               type: 'POST',
               data:{function: 'subgrupoPorGrupoList', id_grupo: id_grupo},
               success:function(data){
                   $("#content-subgrupo").html(data);
               }
            });
        } 

        function buscaLocais(id_subgrupo){
            var subgrupo_itens = document.getElementsByClassName("subgrupoList");
            var i;
            for (i = 0; i < subgrupo_itens.length; i++) {
              subgrupo_itens[i].style.background = "#fff";
            }             
            var subgrupo_item = document.getElementById('subgrupo'+id_subgrupo);
            subgrupo_item.style.background = "#85E4F9";    
            $("#content-publicidade").html("");
            $.ajax({
               url: "services/local.php",
               type: 'POST',
               data:{function: 'localPorSubgrupoList', id_subgrupo: id_subgrupo},
               success:function(data){
                   $("#content-local").html(data);
               }
            });
        }

        function buscaPublicidades(id_local){

            var local_itens = document.getElementsByClassName("localList");
            var i;
            for (i = 0; i < local_itens.length; i++) {
              local_itens[i].style.background = "#fff";
            }             
            var local_item = document.getElementById('local'+id_local);
            local_item.style.background = "#85E4F9";   

            $.ajax({
               url: "services/publicidade.php",
               type: 'POST',
               data:{function: 'publicidadePorLocalList', id_local: id_local},
               success:function(data){
                   $("#content-publicidade").html(data);
               }
            });            

        }         
    </script>
    
    <script>

      function initMap() {
        var hsd = {lat: -2.522966, lng: -44.245136};
        var map = new google.maps.Map(document.getElementById('mapa'), {
          zoom: 12,
          center: hsd
        });
        
        <?php
            foreach ($midias_externas as $me){
                $inicio = formata_padrao_data($me->ciclo->ciclo_inicio);
                $fim = formata_padrao_data($me->ciclo->ciclo_fim);
        ?>
        
        var contentString<?php echo $me->id ?> = 
            '<a style="color:#000" href="publicidadeExternaDetail?i=<?php echo $me->id?>">'+
            '<div id="">'+
            '<div id="siteNotice">'+
            '<img style="width:100%" src="../../mapping_api/<?php echo $me->layout_campanha ?>" />'+
            '</div>'+
            '<h4 id="firstHeading" class="firstHeading"><?php echo $me->nome_campanha ?></h4>'+
            '<div id="bodyContent">'+
            '<p style="margin:0px"><b>Descrição: </b><?php echo $me->descricao ?></p>' +
            '<p style="margin:0px"><b>Midia: </b><?php echo $me->nome_midia ?></p>' +
            '<p style="margin:0px"><b>Ciclo: </b><?php echo $inicio .' à '. $fim ?></p>' +
            '</div>'+
            '</div></a>';
        var infowindow<?php echo $me->id ?> = new google.maps.InfoWindow({
          content: contentString<?php echo $me->id ?>,
          maxWidth: 400
        });
        
        var position1<?php echo $me->id ?> = {lat: <?php echo $me->latitude ?>, lng: <?php echo $me->longitude ?>};
        var marker1<?php echo $me->id ?> = new google.maps.Marker({
          position: position1<?php echo $me->id ?>,
          map: map,
          title: '<?php echo $me->descricao ?>'
        }); 
        
        marker1<?php echo $me->id ?>.addListener('click', function() {
          infowindow<?php echo $me->id ?>.open(map, marker1<?php echo $me->id ?>);
        });
        
        <?php
            }
        ?>
        
      }
      
    </script>

    

</body>
</html>
