<?php
require_once 'api.php';
require_once 'manager_session.php';

//POSTS

if (!empty($_POST)) {
    //INSERIR
    @session_start();
    if ($_POST['function'] == 'novo') {
        
        $campos = array("id_pessoa" => Api::getIdPessoa(), "token" => Api::getToken(), "token_aplicacao" => Api::getTokenAplicacao(),
                        "nome" => $_POST['nome']);
        $url = "tipoUsuario/novo";
        
        $retorno = Api::requisicao($url, $campos);
        $ret = json_decode($retorno);
        
        if($ret->message == 'success'){
            echo "success";
        }else{
            echo $ret->message;
        }
    }
    //EXCLUIR
    if($_POST['function'] == 'remover'){
        $campos = array("id_pessoa" => Api::getIdPessoa(), "token" => Api::getToken(), "token_aplicacao" => Api::getTokenAplicacao(),
                        "id" => $_POST['i']);
        $url = "tipoUsuario/remover";
        
        $retorno = Api::requisicao($url, $campos);
        $ret = json_decode($retorno);
        
        if($ret->message == 'success'){
            echo "success";
        }else{
            echo $ret->message;
        }
        
    } 
    
    //ATUALIZAR
    if($_POST['function'] == 'edit'){
        $campos = array("id_pessoa" => Api::getIdPessoa(), "token" => Api::getToken(), "token_aplicacao" => Api::getTokenAplicacao(),
                        "id" => $_POST['id'], "nome" => $_POST['nome']);
        $url = "tipoUsuario/atualizar";
        
        $retorno = Api::requisicao($url, $campos);
        $ret = json_decode($retorno);
        
        if($ret->message == 'success'){
            echo "success";
        }else{
            echo $ret->message;
        }
        
    }  
    
    //UPDATE PERMISSAO
    if($_POST['function'] == 'updatePermissao'){
        $campos = array("tipoUsuario" => $_POST['tipoUsuario'], "rotina" => $_POST['rotina'], "subRotina" => $_POST['subRotina']);
        $url = "acesso/updatePermissao";
        
        $retorno = Api::requisicao($url, $campos);
        $ret = json_decode($retorno);
        
        if($ret->message == 'success'){
            echo "success";
        }else{
            echo $ret->message;
        }
        
    }      
}

function listarTiposUsuario(){
    $url = "tipoUsuario/listarTudo";
    $campos = Array("id_pessoa" => Api::getIdPessoa(), "token" => Api::getToken(), "token_aplicacao" => Api::getTokenAplicacao());
    $retorno = Api::requisicao($url, $campos);
    $dados = json_decode($retorno);
    
    if(!isset($dados->codigo)){
        return $dados;
    }else{
        return "nenhum";
    }
}

function listarTipoUsuario($id){
    $url = "tipoUsuario/listar";
    $campos = array("id_pessoa" => Api::getIdPessoa(), "token" => Api::getToken(), "token_aplicacao" => Api::getTokenAplicacao(), 
                    "id" => $id);
    $retorno = Api::requisicao($url, $campos);
    $dados = json_decode($retorno);
    
    if(!isset($dados->codigo)){
        return $dados;
    }else{
        return "nenhum";
    }
}

function listarRotinas(){
    $url = "acesso/listarRotinas";
    $campos = array();
    $retorno = Api::requisicao($url, $campos);
    $dados = json_decode($retorno);
    
    if(!isset($dados->codigo)){
        return $dados;
    }else{
        return "nenhum";
    }
}

function verificaPermissao($tipoUsuario, $subRotina){
    $url = "acesso/verificaPermissao";
    $campos = array("tipoUsuario" => $tipoUsuario, "subRotina" => $subRotina);
    $retorno = Api::requisicao($url, $campos);
    $dados = json_decode($retorno);
    
    return $dados->message;
}