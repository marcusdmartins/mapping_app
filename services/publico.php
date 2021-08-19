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
        $url = "publico/novo";
        
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
        $url = "publico/remover";
        
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
        $url = "publico/atualizar";
        
        $retorno = Api::requisicao($url, $campos);
        $ret = json_decode($retorno);
        
        if($ret->message == 'success'){
            echo "success";
        }else{
            echo $ret->message;
        }
        
    }
    
    if($_POST['function'] == 'publicoPorCampanhaInst'){
        
        $campos = array("id_pessoa" => Api::getIdPessoa(), "token" => Api::getToken(), "token_aplicacao" => Api::getTokenAplicacao(),
                        "id_campanha" => $_POST['id_campanha']);
        $url = "publico/publicoPorCampanha";
        
        $retorno = Api::requisicao($url, $campos);
        $dados = json_decode($retorno);
        
        if(!isset($dados->codigo)){
            foreach ($dados as $dado){
                echo'<div class="chip animated fadeIn">'.$dado->nome_publico.'</div>';
            }
        }else{
            echo "Nenhum";
        }
    }
    
    if($_POST['function'] == 'graficoImpactoCampanha'){
        $id_campanha = $_POST['id_campanha'];
        $publicos = listarPublicos();
        
        if(!isset($publicos->codigo)){
            foreach ($publicos as $publico5){
                $media = mediaImpactoCampanha($id_campanha, $publico5->id);
                if(empty($media)){
                    $percent = 0;
                }else{
                    $percent = $media->media;
                }
            echo'<div class="list-group-item animated fadeIn">
                    <div class="lgi-heading m-b-5">'.$publico5->nome.'</div>

                    <div class="progress">
                        <div class="progress-bar" role="progressbar" aria-valuenow="'.$percent.'"
                             aria-valuemin="0" aria-valuemax="100" style="width: '.$percent.'%">
                        </div>
                    </div>
                </div>';
        }
        }else{
            echo "Nenhum publico";
        }
    }    
}

function listarPublicos(){
    $url = "publico/listarTudo";
    $campos = Array("id_pessoa" => Api::getIdPessoa(), "token" => Api::getToken(), "token_aplicacao" => Api::getTokenAplicacao());
    $retorno = Api::requisicao($url, $campos);
    $dados = json_decode($retorno);
    
    if(!isset($dados->codigo)){
        return $dados;
    }else{
        return "nenhum";
    }
}

function listarPublico($id){
    $url = "publico/listar";
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

function mediaImpactoCampanha($id_campanha, $id_publico){
    $url = "publico/mediaCampanhaPublico";
    $campos = array("id_pessoa" => Api::getIdPessoa(), "token" => Api::getToken(), "token_aplicacao" => Api::getTokenAplicacao(), 
                    "id_campanha" => $id_campanha, "id_publico" => $id_publico);
    $retorno = Api::requisicao($url, $campos);
    $dados = json_decode($retorno);
    
    if(!isset($dados->codigo)){
        return $dados;
    }else{
        return "nenhum";
    }
}