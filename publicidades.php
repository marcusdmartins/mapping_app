<?php
require_once 'services/manager_session.php';
require_once 'services/grupo.php';
require_once 'services/publicidade.php';
session_start();
ManagerSession::validaAcesso(6);
$grupos = listarGrupos();
?>
<!DOCTYPE html>
<!--[if IE 9 ]><html class="ie9"><![endif]-->
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>mapping</title>

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
                                    <div class="lgi-heading"><?php echo $grupo->nome ?></div>
                                </div>
                                <?php
                                    if($qtd->qtd > 0){
                                ?>
                                <div class="chip" style="float: right; color: #FFF">
                                    <?php echo $qtd->qtd ?>
                                </div>
                                <?php
                                    }
                                ?>
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

    <!-- Placeholder for IE9 -->
    <!--[if IE 9 ]>
        <script src="vendors/bower_components/jquery-placeholder/jquery.placeholder.min.js"></script>
    <![endif]-->

    <script src="js/app.min.js"></script>
    <script src="js/jquery.form.js"></script>
    <script src="js/afterglow.min.js"></script>
    
    <script>
        
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

</body>
</html>
