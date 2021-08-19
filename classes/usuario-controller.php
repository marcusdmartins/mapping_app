<?php

require_once 'conexao.php';
require_once 'usuario-class.php';

class Usuario_controller{
    
 public static $instance;
  
    public static function getInstance() {
        if (!isset(self::$instance))
            self::$instance = new Message_controller();

        return self::$instance;
    }
    
    public static function buscaPorId($id_usuario){
        
        $busca = Conexao::getInstance()->prepare("SELECT * FROM usuario WHERE id_usuario = '$id_usuario'");
        $busca->execute();
        $linhas = $busca->rowCount();
        
        if($linhas > 0){
            $dados = $busca->fetch(PDO::FETCH_OBJ);
            return $dados;
        }else{
            return "nenhum";
        }
    }
}