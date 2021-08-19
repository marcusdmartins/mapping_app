<?php
require_once 'api.php';
require_once 'manager_session.php';
require_once 'publico.php';

//POSTS
if (!empty($_POST)) {
    //INSERIR
    @session_start();
    if ($_POST['function'] == 'novoLocal') {
        
        $publicos = listarPublicos();
        $impacto = Array();
        foreach ($publicos as $publico){
            $dados = array("publico" => $publico->id, "impacto" => $_POST['impacto'.$publico->id]);
            array_push($impacto, $dados);
        }
        
        $campos = array("id_pessoa" => Api::getIdPessoa(), "token" => Api::getToken(), "token_aplicacao" => Api::getTokenAplicacao(),
                        "nome" => $_POST['nome'], "id_subgrupo" => $_POST['id_subgrupo'], "impacto" => $impacto);
        $url = "local/novo";
        
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
        $url = "local/remover";
        
        $retorno = Api::requisicao($url, $campos);
        $ret = json_decode($retorno);
        
        if($ret->message == 'success'){
            echo "success";
        }else{
            echo $ret->message;
        }
    } 
    
    //ATUALIZAR
    if($_POST['function'] == 'editLocal'){
        
        $publicos = listarPublicos();
        $impacto = Array();
        foreach ($publicos as $publico){
            $dados = array("publico" => $publico->id, "impacto" => $_POST['impacto'.$publico->id]);
            array_push($impacto, $dados);
        }        
        
        $campos = array("id_pessoa" => Api::getIdPessoa(), "token" => Api::getToken(), "token_aplicacao" => Api::getTokenAplicacao(),
                        "id" => $_POST['id'], "nome" => $_POST['nome'], "id_subgrupo" => $_POST['id_subgrupo'], "impacto" => $impacto);
        $url = "local/atualizar";
        
        $retorno = Api::requisicao($url, $campos);
        $ret = json_decode($retorno);
        
        if($ret->message == 'success'){
            echo "success";
        }else{
            echo $ret->message;
        }
        
    }   
    
    if($_POST['function'] == 'localPorSubgrupo'){
        $campos = array("id_pessoa" => Api::getIdPessoa(), "token" => Api::getToken(), "token_aplicacao" => Api::getTokenAplicacao(),
                        "id_subgrupo" => $_POST['id_subgrupo']);
        $url = "local/localPorSubgrupo";
        
        $retorno = Api::requisicao($url, $campos);
        $dados = json_decode($retorno);
        
        if(!isset($dados->codigo)){
            foreach ($dados as $dado){
            echo'
                <a class="list-group-item media" href="localDetail?i='.$dado->id.'">
                    <div class="pull-left">
                        <img class="lgi-img" src="img/icons/local.png" alt="">
                    </div>
                <div class="media-body">
                    <div class="lgi-heading">'.$dado->nome.'</div>
                        <small class="lgi-text">'.$dado->nome_subgrupo.'</small>
                            
                    </div>
                </a>            
            ';
        }
        }else{
            echo "Nenhum local";
        }
    }
    
    if($_POST['function'] == 'localPorSubgrupoCombo'){
        $campos = array("id_pessoa" => Api::getIdPessoa(), "token" => Api::getToken(), "token_aplicacao" => Api::getTokenAplicacao(),
                        "id_subgrupo" => $_POST['id_subgrupo']);
        $url = "local/localPorSubgrupo";
        
        $retorno = Api::requisicao($url, $campos);
        $dados = json_decode($retorno);
        
        if(!isset($dados->codigo)){
            foreach ($dados as $dado){
                echo'<option style = "padding: 16px" value="'.$dado->id.'">'.$dado->nome.'</option>';
        }
        }else{
            echo "Nenhum local";
        }
    }
    
    if($_POST['function'] == 'localPorSubgrupoList'){
        $campos = array("id_pessoa" => Api::getIdPessoa(), "token" => Api::getToken(), "token_aplicacao" => Api::getTokenAplicacao(),
                        "id_subgrupo" => $_POST['id_subgrupo']);
        $url = "local/localPorSubgrupo";
        
        $retorno = Api::requisicao($url, $campos);
        $dados = json_decode($retorno);
        
        if(!isset($dados->codigo)){
            foreach ($dados as $dado){
                
                $qtd = buscaQtdPublicidadePorLocal($dado->id);
                
                if($qtd->qtd > 0){
                    $display = 'block';
                }else{
                    $display = 'none';
                }                 
                
                echo'
                <div class="card-padding animated fadeIn" style="padding-bottom: 20px">
                    <a id="local'.$dado->id.'" class="list-group-item media localList" href="#" onclick="buscaPublicidades('.$dado->id.')">

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
            echo '<p class="animated fadeIn">Nenhum local</p>';
        }
    }

    if($_POST['function'] == 'impactoPorLocalInst'){
        
        $campos = array("id_pessoa" => Api::getIdPessoa(), "token" => Api::getToken(), "token_aplicacao" => Api::getTokenAplicacao(),
                        "id_local" => $_POST['id_local']);
        $url = "local/impactosPorLocal";
        
        $retorno = Api::requisicao($url, $campos);
        $dados = json_decode($retorno);
        
        if(!isset($dados->codigo)){
            foreach ($dados as $dado){
                echo'
                    <label>'.$dado->nome_publico.'</label><br><br>
                    <div class="progress animated fadeIn">
                        <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="'.$dado->impacto.'" aria-valuemin="0"
                             aria-valuemax="100" style="width: '.$dado->impacto.'%;">
                        </div>
                    </div><hr>';
            }
        }else{
            echo "Nenhum";
        }
    }    
}

function listarLocais(){
    $url = "local/listarTudo";
    $campos = Array("id_pessoa" => Api::getIdPessoa(), "token" => Api::getToken(), "token_aplicacao" => Api::getTokenAplicacao());
    $retorno = Api::requisicao($url, $campos);
    $dados = json_decode($retorno);
    
    if(!isset($dados->codigo)){
        return $dados;
    }else{
        return "nenhum";
    }
}

function listarLocal($id){
    $url = "local/listar";
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

function impactoPorPublicoLocal($id_publico, $id_local){
    $url = "local/impactoPorPublicoLocal";
    $campos = Array("id_pessoa" => Api::getIdPessoa(), "token" => Api::getToken(), "token_aplicacao" => Api::getTokenAplicacao(),
                    "id_local" => $id_local, "id_publico" => $id_publico);
    $retorno = Api::requisicao($url, $campos);
    $dados = json_decode($retorno);
    
    if(!isset($dados->codigo)){
        return $dados;
    }else{
        return "nenhum";
    }
}

function buscaQtdPublicidadePorLocal($id){
    $url = "publicidade/buscaQtdPublicidadePorLocal";
    $campos = array("id_pessoa" => Api::getIdPessoa(), "token" => Api::getToken(), "token_aplicacao" => Api::getTokenAplicacao(), 
                    "id_local" => $id);
    $retorno = Api::requisicao($url, $campos);
    $dados = json_decode($retorno);
    
    if(!isset($dados->codigo)){
        return $dados;
    }else{
        return "nenhum";
    }
}