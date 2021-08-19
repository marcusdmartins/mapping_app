<?php

require_once 'api.php';

class ManagerSession{

    public static function setSession($ret){

        session_start();
        $_SESSION['UsuarioID'] = $ret->id;
        $_SESSION['UsuarioNome'] = $ret->nome;
        $_SESSION['UsuarioTipo'] = $ret->tipoUsuario;
        $_SESSION['token'] = $ret->token;

//        setcookie('UsuarioID', $ret->id, (time() + (14 * 24 * 3600)));
//        setcookie('UsuarioNome', $ret->nome, (time() + (14 * 24 * 3600)));
//        setcookie('UsuarioTipo', $ret->tipoUsuario, (time() + (14 * 24 * 3600)));

        return "success";        
    }
    
    public static function setCookie(){
        setcookie("i", $_SESSION['UsuarioID'], (time() + (14 * 24 * 3600)), "/");
        return true;
    }    

    public static function excluiCookie(){
        
        unset($_COOKIE['UsuarioID']);
        setcookie('i', '', time() - 3600, '/');
        
        return true;
    }    
    
    public static function dois_acessos($nivel_1, $nivel_2) {

        if (isset($_COOKIE['i'])) {

            if (($_SESSION['UsuarioTipo'] != $nivel_1) && ($_SESSION['UsuarioTipo'] != $nivel_2)) {

                //session_destroy();
                echo"<script>location.href ='home';</script>";
            }
        } else {
            echo"<script>location.href ='index';</script>";
        }
    }
    
    public static function validaCookie(){
        if(isset($_COOKIE['i'])){
            if($_COOKIE['i'] != null){
                $url = "pessoa/listar";
                $campos = array("id" => $_COOKIE['i']);
                $retorno = Api::requisicao($url, $campos);
                $ret = json_decode($retorno);

                ManagerSession::setSession($ret);
            }
        }

        if(isset($_SESSION['UsuarioID'])){
            echo"<script>location.href ='home';</script>";
        }
    }
    
    public static function buscaItensMenu($tipoUsuario){
        $url = "acesso/listarPermissoes";
        $campos = Array("tipoUsuario" => $tipoUsuario);
        $retorno = Api::requisicao($url, $campos);
        $dados = json_decode($retorno);

        if(!isset($dados->codigo)){
            return $dados;
        }else{
            return "nenhum";
        }
    }

    public static function validaAcesso($subRotina){
        
            if(empty($_SESSION['UsuarioTipo'])){
                echo"<script>location.href ='classes/logout.php';</script>";
            }
            $tipoUsuario = $_SESSION['UsuarioTipo'];
            $url = "acesso/verificaPermissao";
            $campos = Array("tipoUsuario" => $tipoUsuario, "subRotina" => $subRotina);
            $retorno = Api::requisicao($url, $campos);
            $dados = json_decode($retorno);

            if($dados->message == "false"){
                 echo"<script>location.href ='classes/logout.php';</script>";
            }
                  
    }
    
    public static function validaPermissaoElemento($subRotina){
        $tipoUsuario = $_SESSION['UsuarioTipo'];
        $url = "acesso/verificaPermissao";
        $campos = Array("tipoUsuario" => $tipoUsuario, "subRotina" => $subRotina);
        $retorno = Api::requisicao($url, $campos);
        $dados = json_decode($retorno);

        return $dados->message;
        
    }     
    
    
}