<?php
    require_once 'services/manager_session.php';
    ManagerSession::validaCookie();
?>
<!DOCTYPE html>
    <!--[if IE 9 ]><html class="ie9"><![endif]-->
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Login</title>

        <!-- Vendor CSS -->
        <link href="vendors/bower_components/animate.css/animate.min.css" rel="stylesheet">
        <link href="vendors/bower_components/material-design-iconic-font/dist/css/material-design-iconic-font.min.css" rel="stylesheet">
        <link href="vendors/bower_components/sweetalert2/dist/sweetalert2.min.css" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Montserrat:400,800" rel="stylesheet">

        <style>
                .titulo{
                    font-family: 'Montserrat', sans-serif;
                    font-size: 20px;
                    font-weight: 800;
                    font-style: italic;
                }

                .corpo{
                    font-family: 'Montserrat', sans-serif;
                    /*font-weight: 500;*/
                }

                body{
                  font-family: 'Montserrat', sans-serif !important;  
                }        
        </style>

        <!-- CSS -->
        <link href="css/app_1.min.css" rel="stylesheet">
        <link href="css/app_2.min.css" rel="stylesheet">
    </head>

    <body>
        <div class="login-content animated fadeIn" style="background-image: url(img/back.png); background-size: 100%; background-repeat: no-repeat">
            <!-- Login -->
            <div class="lc-block toggled" id="l-login">
                <img src="img/logo_mapping_white.png" style="width: 250px; margin-bottom: 20px">
                <form class="login" action="services/login.php" method="POST">
                    <input type="hidden" name="function" value="valida">
                    <div class="lcb-form" style="margin-left: -25px; margin-right: -20px" style="background-color: #CBA4FF">
                        <div class="input-group m-b-20">
                            <span class="input-group-addon"><i class="zmdi zmdi-account"></i></span>
                            <div class="fg-line">
                                <input type="text" name="email" class="form-control" placeholder="Email" required="">
                            </div>
                        </div>

                        <div class="input-group m-b-20">
                            <span class="input-group-addon"><i class="zmdi zmdi-lock"></i></span>
                            <div class="fg-line">
                                <input type="password" name="senha" class="form-control" placeholder="Senha" required="">
                            </div>
                        </div>

                        <button type="submit" href="" class="btn btn-login btn bgm-blue btn-float"><i class="zmdi zmdi-arrow-forward"></i></button>
                    </div>
                </form>
            <!--<div class="lcb-navigation">
                    <a href="" data-ma-action="login-switch" data-ma-block="#l-forget-password"><i>?</i> <span>Esqueceu a senha?</span></a>
                </div>-->
            </div>
            
            <!-- Recuperar Senha -->
            <div class="lc-block" id="l-forget-password">
                <form action="services/login.php" method="POST">
                <input type="hidden" name="function" value="recup_senha"/>
                <div class="lcb-form" style="margin-left: -25px; margin-right: -20px">
                    <p class="text-left">Digite seu email</p>
                    <div class="input-group m-b-20">
                        <span class="input-group-addon"><i class="zmdi zmdi-email"></i></span>
                        <div class="fg-line">
                            <input type="text" name="email" class="form-control" placeholder="Email" required="">
                        </div>
                    </div>
                    <button type="submit" class="btn btn-login btn-info btn-float"><i class="zmdi zmdi-check"></i></button>
                </div>
                </form>

                <div class="lcb-navigation">
                    <a href="" data-ma-action="login-switch" data-ma-block="#l-login"><i class="zmdi zmdi-long-arrow-left"></i> <span>Voltar</span></a>
                    
                </div>
            </div>
        </div>
        

        <!-- Javascript Libraries -->
        <script src="vendors/bower_components/jquery/dist/jquery.min.js"></script>
        <script src="vendors/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
        <script src="vendors/bower_components/sweetalert2/dist/sweetalert2.min.js"></script>

        <script src="vendors/bower_components/Waves/dist/waves.min.js"></script>

        <script src="js/app.min.js"></script>
        <script src="js/jquery.form.js"></script>       
        
        <script>
            $(function(){
                $('.login').ajaxForm({
                    beforeSend: function () {
                        //$('.loadingCliente').css({display: "block"});
                    },
                    success: function () {
                       // $('.loadingCliente').css({display: "none"});
                    },
                    complete: function(result){
                        if(result.responseText === "true"){
                            location.href="home";
                        }else if(result.responseText === "bloq"){
                            swal({
                                title: "Usuario bloqueado",
                                //text: result.responseText,
                                type: "warning"
                            });   
                        }else{
                            swal({
                                title: "Login inválido",
                                //text: result.responseText,
                                type: "warning"
                            });                            
                        }                   
                    }
                });
            });
        </script>
    </body>
</html>
