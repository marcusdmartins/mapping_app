<?php

require_once 'login-controller.php';
require_once 'login-class.php';
require_once 'class.phpmailer.php';
require_once 'class.smtp.php';

@session_start();

$login = new Login_controller();

if (!empty($_POST)) {

    if ($_POST['function'] == 'getSession') {

        echo "$_SESSION[UsuarioID], $_SESSION[UsuarioNome], $_SESSION[UsuarioNivel]";
    }

    if ($_POST['function'] == 'valida') {

        $usuario = new Login();

        $usuario->setEmail($_POST['email']);
        $usuario->setSenha($_POST['senha']);

        $retorno_funcao = $login->valida($usuario);
         $login->setCookie();

        if ($retorno_funcao == 'success') {

            echo"<script>location.href = '../home';</script>";
        }else{
            $_SESSION['message'] = 1;
            $login->excluiCookie();
            echo"<script>location.href = '../index';</script>";
        }
    }

    if ($_POST['function'] == 'consulta_sessao') {

        @session_start();
        if (!empty($_SESSION)) {
            echo 'true';
        } else {
            echo 'false';
        }
    }

    if ($_POST['function'] == 'altera_senha') {

        $login_controller = new Login_controller();

        $retorno_funcao = $login_controller->alteraSenha($_POST['senha_atual'], $_POST['nova_senha'], $_POST['confirma_senha']);

        $_SESSION['message'] = $retorno_funcao;
        echo"<script>window.history.go(-1);</script>";
    }
}

if (!empty($_GET['f'])) {

    if ($_GET['f'] == "valida") {

        $usuario = new Login();
        $pessoa_controller = new Pessoa_controller();

        $id_user = $_GET['i'];
        $user = $pessoa_controller->buscaPorId($id_user);

        $usuario->setEmail($user->email);
        $usuario->setSenha($user->senha);

        $retorno_funcao = $login->valida($usuario);
       

        if ($retorno_funcao == 'success') {
             echo"<script>location.href = '../home.php';</script>";
        } else{
            $_SESSION['message'] = 1;
            $login->excluiCookie();
            echo"<script>location.href = '../index';</script>";
        }
    }
}

function um_acesso($nivel) {

    if (isset($_COOKIE['i'])) {

        if ($_SESSION['UsuarioNivel'] != $nivel) {
            //session_destroy();
            echo"<script>location.href ='../home';</script>";
        }
    } else {
        echo"<script>location.href ='../index';</script>";
    }
}

function dois_acessos($nivel_1, $nivel_2) {

    if (isset($_COOKIE['i'])) {

        if (($_SESSION['UsuarioNivel'] != $nivel_1) && ($_SESSION['UsuarioNivel'] != $nivel_2)) {

            //session_destroy();
            echo"<script>location.href ='home';</script>";
        }
    } else {
        echo"<script>location.href ='index';</script>";
    }
}

function buscaTipoUsuario($id) {

    $login_controller = new Login_controller();

    $tipo = $login_controller->buscaTipoUsuario($id);

    return $tipo;
}