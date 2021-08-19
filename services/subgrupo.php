<?php
require_once 'api.php';
require_once 'manager_session.php';

//POSTS

if (!empty($_POST)) {
    //INSERIR
    @session_start();
    if ($_POST['function'] == 'novo') {
        
        $campos = array("id_pessoa" => Api::getIdPessoa(), "token" => Api::getToken(), "token_aplicacao" => Api::getTokenAplicacao(),
                        "nome" => $_POST['nome'], "id_grupo" => $_POST['id_grupo']);
        $url = "subgrupo/novo";
        
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
        $url = "subgrupo/remover";
        
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
                        "id" => $_POST['id'], "nome" => $_POST['nome'], "id_grupo" => $_POST['id_grupo']);
        $url = "subgrupo/atualizar";
        
        $retorno = Api::requisicao($url, $campos);
        $ret = json_decode($retorno);
        
        if($ret->message == 'success'){
            echo "success";
        }else{
            echo $ret->message;
        }
        
    }   
    
    if($_POST['function'] == 'subgrupoPorGrupo'){
        $campos = array("id_pessoa" => Api::getIdPessoa(), "token" => Api::getToken(), "token_aplicacao" => Api::getTokenAplicacao(),
                        "id_grupo" => $_POST['id_grupo']);
        $url = "subgrupo/subgrupoPorGrupo";
        
        $retorno = Api::requisicao($url, $campos);
        $dados = json_decode($retorno);
        
        if(!isset($dados->codigo)){
            foreach ($dados as $dado){
            echo'
                <a class="list-group-item media" href="subgrupoDetail?i='.$dado->id.'">
                    <div class="pull-left">
                        <img class="lgi-img" src="img/icons/subgrupo.png" alt="">
                    </div>
                <div class="media-body">
                    <div class="lgi-heading">'.$dado->nome.'</div>
                        <small class="lgi-text">'.$dado->nome_grupo.'</small>
                            
                    </div>
                </a>';
        }
        }else{
            echo "Nenhum subgrupo";
        }
    }   
    
    if($_POST['function'] == 'subgrupoPorGrupoCombo'){
        $campos = array("id_pessoa" => Api::getIdPessoa(), "token" => Api::getToken(), "token_aplicacao" => Api::getTokenAplicacao(),
                        "id_grupo" => $_POST['id_grupo']);
        $url = "subgrupo/subgrupoPorGrupo";
        
        $retorno = Api::requisicao($url, $campos);
        $dados = json_decode($retorno);
        
        if(!isset($dados->codigo)){
            foreach ($dados as $dado){
                echo'<option style = "padding: 16px" value="'.$dado->id.'">'.$dado->nome.'</option>';
        }
        }else{
            echo "Nenhum subgrupo";
        }
    }

    if($_POST['function'] == 'subgrupoPorGrupoList'){
        $campos = array("id_pessoa" => Api::getIdPessoa(), "token" => Api::getToken(), "token_aplicacao" => Api::getTokenAplicacao(),
                        "id_grupo" => $_POST['id_grupo']);
        $url = "subgrupo/subgrupoPorGrupo";
        
        $retorno = Api::requisicao($url, $campos);
        $dados = json_decode($retorno);
        
        if(!isset($dados->codigo)){
            foreach ($dados as $dado){
                
                $qtd = buscaQtdPublicidadePorSubgrupo($dado->id);
                
                if($qtd->qtd > 0){
                    $display = 'block';
                }else{
                    $display = 'none';
                } 
                
            echo'
                <div class="card-padding animated fadeIn" style="padding-bottom: 20px">
                    <a id="subgrupo'.$dado->id.'" class="list-group-item media subgrupoList" href="#" onclick="buscaLocais('.$dado->id.')">
                        <div class="media-body">
                            <div class="lgi-heading">'.$dado->nome.'
                                <div class="chip" style="margin-top: 1px; float: right; color: #FFF; display: '.$display.'">
                                    '.$qtd->qtd.'
                                </div>                                
                            </div>
                        </div>

                    </a>  
                </div>';
        }
        }else{
            echo '<p class="animated fadeIn">Nenhum subgrupo</p>';
        }
    }    
}

function listarSubgrupos(){
    $url = "subgrupo/listarTudo";
    $campos = Array("id_pessoa" => Api::getIdPessoa(), "token" => Api::getToken(), "token_aplicacao" => Api::getTokenAplicacao());
    $retorno = Api::requisicao($url, $campos);
    $dados = json_decode($retorno);
    
    if(!isset($dados->codigo)){
        return $dados;
    }else{
        return "nenhum";
    }
}

function listarSubgrupo($id){
    $url = "subgrupo/listar";
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

function buscaQtdPublicidadePorSubgrupo($id){
    $url = "publicidade/buscaQtdPublicidadePorSubgrupo";
    $campos = array("id_pessoa" => Api::getIdPessoa(), "token" => Api::getToken(), "token_aplicacao" => Api::getTokenAplicacao(), 
                    "id_subgrupo" => $id);
    $retorno = Api::requisicao($url, $campos);
    $dados = json_decode($retorno);
    
    if(!isset($dados->codigo)){
        return $dados;
    }else{
        return "nenhum";
    }
}