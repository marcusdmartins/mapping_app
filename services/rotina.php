<?php
require_once 'api.php';
require_once 'manager_session.php';

//POSTS

if (!empty($_POST)) {
    //INSERIR
    @session_start();
    if ($_POST['function'] == 'novaSubRotina') {
        $campos = array("id_pessoa" => Api::getIdPessoa(), "token" => Api::getToken(), "token_aplicacao" => Api::getTokenAplicacao(),
                        "nome" => $_POST['nome'],
                        "path" => $_POST['path'],
                        "icon" => $_POST['icon'],
                        "menu" => $_POST['menu'],
                        "id_rotina" => $_POST['id_rotina']);
        
        $url = "subRotina/nova";
        
        $retorno = Api::requisicao($url, $campos);
        $ret = json_decode($retorno);
        
        if($ret->message == 'success'){
            echo "success";
        }else{
            echo $ret->message;
        }
    }
    //EXCLUIR
    if($_POST['function'] == 'removerSubRotina'){
        $campos = array("id_pessoa" => Api::getIdPessoa(), "token" => Api::getToken(), "token_aplicacao" => Api::getTokenAplicacao(),
                        "id" => $_POST['i']);
        $url = "subrotina/remover";
        
        $retorno = Api::requisicao($url, $campos);
        $ret = json_decode($retorno);
        
        if($ret->message == 'success'){
            echo "success";
        }else{
            echo $ret->message;
        }
        
    } 
    
    //ATUALIZAR
    if($_POST['function'] == 'editSubRotina'){
        $campos = array("id_pessoa" => Api::getIdPessoa(), "token" => Api::getToken(), "token_aplicacao" => Api::getTokenAplicacao(),
                        "id" => $_POST['id'],
                        "nome" => $_POST['nome'],
                        "path" => $_POST['path'],
                        "icon" => $_POST['icon'],
                        "menu" => $_POST['menu'],
                        "id_rotina" => $_POST['id_rotina']);
        $url = "subrotina/atualizar";
        
        $retorno = Api::requisicao($url, $campos);
        $ret = json_decode($retorno);
        
        if($ret->message == 'success'){
            echo "success";
        }else{
            echo $ret->message;
        }
        
    }     
}

function listarNiveis(){
    @session_start();
    $url = "subrotina/listarTudo";
    $campos = Array("id_pessoa" => Api::getIdPessoa(), "token" => Api::getToken(), "token_aplicacao" => Api::getTokenAplicacao());
    $retorno = Api::requisicao($url, $campos);
    $dados = json_decode($retorno);
    
    if(!isset($dados->codigo)){
        return $dados;
    }else{
        return "nenhum";
    }
}

function listarRotina($id_rotina){
    @session_start();
    $url = "rotina/listar";
    $campos = array("id_pessoa" => Api::getIdPessoa(), "token" => Api::getToken(), "token_aplicacao" => Api::getTokenAplicacao(),
                    "id" => $id_rotina);
    $retorno = Api::requisicao($url, $campos);
    $dados = json_decode($retorno);
    
    if(!isset($dados->codigo)){
        return $dados;
    }else{
        return "nenhum";
    }
}

function listarSubrotina($id_subrotina){
    @session_start();
    $url = "subrotina/listar";
    $campos = array("id_pessoa" => Api::getIdPessoa(), "token" => Api::getToken(), "token_aplicacao" => Api::getTokenAplicacao(),
                    "id" => $id_subrotina);
    $retorno = Api::requisicao($url, $campos);
    $dados = json_decode($retorno);
    
    if(!isset($dados->codigo)){
        return $dados;
    }else{
        return "nenhum";
    }
}