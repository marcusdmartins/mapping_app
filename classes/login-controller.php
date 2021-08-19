<?php

require_once 'conexao.php';
require_once 'login-class.php';
require_once 'usuario-controller.php';

class Login_controller {

    public static $instance;

    public static function getInstance() {
        if (!isset(self::$instance))
            self::$instance = new Login_controller();

        return self::$instance;
    }

    function valida($login) {

        $valida = Conexao::getInstance()->prepare("SELECT * FROM usuario WHERE email = '$login->email'"
                . "AND senha = '$login->senha'; ");
        $valida->execute();

        $dados_usuario = $valida->fetch(PDO::FETCH_OBJ);
        $linhas = $valida->rowCount();

        if ($linhas > 0) {
      
            @session_start();
            $_SESSION['UsuarioID'] = $dados_usuario->id_usuario;
            $_SESSION['UsuarioNome'] = $dados_usuario->nome;
            $_SESSION['UsuarioNivel'] = $dados_usuario->id_tipo_usuario;

            setcookie('UsuarioID', $dados_usuario->id_usuario, (time() + (14 * 24 * 3600)));
            setcookie('UsuarioNome', $dados_usuario->nome, (time() + (14 * 24 * 3600)));
            setcookie('UsuarioNivel', $dados_usuario->id_tipo_usuario, (time() + (14 * 24 * 3600)));

            return "success";
        
        } else {

            return "error";
        }
    }

    public static function buscaTipoUsuario($id) {

        $busca = Conexao::getInstance()->prepare("SELECT * FROM tipo_usuario WHERE id_tipo_usuario = '$id'");
        $busca->execute();

        $dados = $busca->fetch(PDO::FETCH_OBJ);

        return $dados->descricao;
    }

    public static function alteraSenha($senha_atual, $nova_senha, $confirma_senha) {

        $pessoa_controller = new Pessoa_controller();

        $dados_pessoa = $pessoa_controller->buscaPorId($_SESSION['UsuarioID']);

        if ($nova_senha != $confirma_senha) {

            return 10;
        } else if ($dados_pessoa->senha != $senha_atual) {

            return 11;
        } else {

            $altera_senha = Conexao::getInstance()->prepare("UPDATE usuario SET senha = '$nova_senha' WHERE id_usuario = '$_SESSION[UsuarioID]'");
            $altera_senha->execute();

            $linhas = $altera_senha->rowCount();

            if ($linhas > 0) {

                return 12;
            } else {

                return 4;
            }
        }
    }
    
    public static function setSession(){
        
        $usuario_controller = new Usuario_controller();
        $dados_pessoa = $usuario_controller->buscaPorId($_COOKIE['i']);
        
        //@sesion_start();
        $_SESSION['UsuarioID'] = $dados_pessoa->id_usuario;
        $_SESSION['UsuarioNome'] = $dados_pessoa->nome;
        $_SESSION['UsuarioNivel'] = $dados_pessoa->id_tipo_usuario;
        
        return true;
        
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
   
    

}
