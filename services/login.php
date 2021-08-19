<?php

require_once 'api.php';
require_once 'manager_session.php';


if (!empty($_POST)) {

    if ($_POST['function'] == 'getSession') {

        echo "$_SESSION[UsuarioID], $_SESSION[UsuarioNome], $_SESSION[UsuarioNivel]";
    }

    if ($_POST['function'] == 'valida') {
        
        $usuario = array("email" => $_POST['email'], "senha" => $_POST['senha'], "token_aplicacao" => Api::getTokenAplicacao());
        $url = "acesso/logar";
        $retorno = Api::requisicao($url, $usuario);
        $ret = json_decode($retorno);
        
        if($ret->login == 'true'){
            ManagerSession::setSession($ret);
            echo $ret->login;
        }else{
            echo $ret->login;
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
    
}