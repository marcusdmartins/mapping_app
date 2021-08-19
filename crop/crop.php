<?php
  @session_start();
  require('canvas.php');
  require_once '../classes/pessoa-controller.php';
  $pessoa_controller = new Pessoa_controller();
  

  $x = $_POST['dataX'];
  $y = $_POST['dataY'];
  $w = $_POST['dataW'];
  $h = $_POST['dataH'];
  
  $nome_imagem = $_POST['nome_imagem'];

  
  $img = new canvas();

  $img->carrega('../'.$nome_imagem)->posicaoCrop($x, $y, $w, $h)->redimensiona($w, $h, 'crop')->grava('../'.$nome_imagem);
  
            
  $retorno_funcao = $pessoa_controller->alteraFoto($_SESSION['UsuarioID'], $nome_imagem);
  
  if ($retorno_funcao == 'success') {
                $_SESSION['message'] = 3;
                echo"<script>location.href = '../perfil.php';</script>";
            } else {

                $_SESSION['message'] = 4;
                echo"<script>location.href = '../perfil.php';</script>";
            }


echo $nome_imagem;
  exit;
