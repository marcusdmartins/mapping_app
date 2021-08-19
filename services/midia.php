<?php
require_once 'api.php';
require_once 'manager_session.php';

//POSTS

if (!empty($_POST)) {
    //INSERIR
    @session_start();
    if ($_POST['function'] == 'novo') {
        
        $campos = array("id_pessoa" => Api::getIdPessoa(), "token" => Api::getToken(), "token_aplicacao" => Api::getTokenAplicacao(),
                        "nome" => $_POST['nome'], "icon" => null, "id_tipomidia" => $_POST['id_tipomidia']);
        $url = "midia/novo";
        
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
        $url = "midia/remover";
        
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
                        "id" => $_POST['id'], "nome" => $_POST['nome'], "icon" => null, "id_tipomidia" => $_POST['id_tipomidia']);
        $url = "midia/atualizar";
        
        $retorno = Api::requisicao($url, $campos);
        $ret = json_decode($retorno);
        
        if($ret->message == 'success'){
            echo "success";
        }else{
            echo $ret->message;
        }
        
    }
    
    //BUSCA POR TIPO
    if($_POST['function'] == 'buscaMidiaPorTipo'){
        $campos = array("id_pessoa" => Api::getIdPessoa(), "token" => Api::getToken(), "token_aplicacao" => Api::getTokenAplicacao(),
                        "id_tipomidia" => $_POST['id_tipomidia']);
        $url = "midia/buscaMidiaPorTipo";
        
        $retorno = Api::requisicao($url, $campos);
        $dados = json_decode($retorno);        
        
        if(!isset($dados->codigo)){
            foreach ($dados as $dado){
            echo'
                <a class="list-group-item media" href="midiaDetail?i='.$dado->id.'">
                    <div class="pull-left">
                        <img class="lgi-img" src="img/icons/midia.png" alt="">
                    </div>
                    <div class="media-body">
                        <div class="lgi-heading">'.$dado->nome.'</div>
                        <small class="lgi-text">'.$dado->nome_tipomidia.'</small> 
                    </div>
                </a>';
        }
        }else{
            echo "Nenhuma mídia";
        }
    }     
}

function listarMidias(){
    $url = "midia/listarTudo";
    $campos = Array("id_pessoa" => Api::getIdPessoa(), "token" => Api::getToken(), "token_aplicacao" => Api::getTokenAplicacao());
    $retorno = Api::requisicao($url, $campos);
    $dados = json_decode($retorno);
    
    if(!isset($dados->codigo)){
        return $dados;
    }else{
        return "nenhum";
    }
}

function listarMidia($id){
    $url = "midia/listar";
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

function listarMidiaPorTipo($id_tipomidia){
    $url = "midia/buscaMidiaPorTipo";
    $campos = Array("id_pessoa" => Api::getIdPessoa(), "token" => Api::getToken(), "token_aplicacao" => Api::getTokenAplicacao(),
                    "id_tipomidia" => $id_tipomidia);
    $retorno = Api::requisicao($url, $campos);
    $dados = json_decode($retorno);
    
    if(!isset($dados->codigo)){
        return $dados;
    }else{
        return "nenhum";
    }
}