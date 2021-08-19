<?php
require_once 'api.php';
require_once 'manager_session.php';
require_once 'funcoes.php';

//POSTS

if (!empty($_POST)) {
    
    //INSERIR
    @session_start();
    if ($_POST['function'] == 'novo') {
        
        if($_POST['ambiente'] == "i"){
            $id_local = $_POST['id_local'];
            $longitude = null;
            $latitude = null;    
        }else if($_POST['ambiente'] == "e"){
            $longitude = $_POST['longitude'];
            $latitude = $_POST['latitude'];
            $id_local = 1;
        }else if($_POST['ambiente'] == "d"){
            $id_local = 1;
            $longitude = null;
            $latitude = null;             
        }
        
        $dataInicio = formata_padrao_data_bd($_POST['inicio']);
        $dataFim = formata_padrao_data_bd($_POST['fim']);
        $status_ciclo = consultaStatusData($dataInicio, $dataFim);
        
        $campos = array("id_pessoa" => Api::getIdPessoa(), "token" => Api::getToken(), "token_aplicacao" => Api::getTokenAplicacao(),
                        "descricao" => $_POST['descricao'],
                        "id_campanha" => $_POST['id_campanha'],
                        "id_midia" => $_POST['id_midia'], 
                        "ambiente" => $_POST['ambiente'], 
                        "id_local" => $id_local,
                        "latitude" => $latitude,
                        "longitude" => $longitude,
                        "status" => $_POST['status'],
                        "pessoa_log" => $_POST['pessoa_log'],
                        "custo" => moeda_to_float($_POST['custo']),
                        "status_ciclo" => $status_ciclo,
                        "inicio" => $dataInicio,
                        "fim" => $dataFim,
                        "qtd" => $_POST['qtd']);
        
        $url = "publicidade/novo";
        
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
        $url = "publicidade/remover";
        
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
        
        if($_POST['ambiente'] == "i"){
            $id_local = $_POST['id_local'];
            $longitude = null;
            $latitude = null;            
        }else if($_POST['ambiente'] == "e"){
            $longitude = $_POST['longitude'];
            $latitude = $_POST['latitude'];
            $id_local = 1;
        }else if($_POST['ambiente'] == "d"){
            $id_local = 1;
            $longitude = null;
            $latitude = null;            
        }        
        
        $campos = array("id_pessoa" => Api::getIdPessoa(), "token" => Api::getToken(), "token_aplicacao" => Api::getTokenAplicacao(),
                        "descricao" => $_POST['descricao'],
                        "id" => $_POST['id'],
                        "id_campanha" => $_POST['id_campanha'],
                        "id_midia" => $_POST['id_midia'], 
                        "id_local" => $id_local,
                        "latitude" => $latitude,
                        "longitude" => $longitude,
                        "status" => $_POST['status'],
                        "pessoa_log" => $_POST['pessoa_log']);
        $url = "publicidade/atualizar";
        
        $retorno = Api::requisicao($url, $campos);
        $ret = json_decode($retorno);
        
        if($ret->message == 'success'){
            echo "success";
        }else{
            echo $ret->message;
        }
        
    }
    
    //NOVO CICLO   
    if($_POST['function'] == 'novoCiclo'){
        
        $dataInicio = formata_padrao_data_bd($_POST['inicio']);
        $dataFim = formata_padrao_data_bd($_POST['fim']);
        $status_ciclo = consultaStatusData($dataInicio, $dataFim);
        
        $campos = array("id_pessoa" => Api::getIdPessoa(), "token" => Api::getToken(), "token_aplicacao" => Api::getTokenAplicacao(),
                        "id_publicidade" => $_POST['id_publicidade'],
                        "inicio" => $dataInicio,
                        "fim" => $dataFim,
                        "status" => $status_ciclo,
                        "custo" => moeda_to_float($_POST['custo']));
        $url = "ciclo/novo";
        
        $retorno = Api::requisicao($url, $campos);
        $ret = json_decode($retorno);
        
        if($ret->message == 'success'){
            echo "success";
        }else{
            echo $ret->message;
        }
        
    }    
    
    //ATUALIZAR CICLO   
    if($_POST['function'] == 'editCiclo'){
        
        $dataInicio = formata_padrao_data_bd($_POST['inicio']);
        $dataFim = formata_padrao_data_bd($_POST['fim']);
        $status_ciclo = consultaStatusData($dataInicio, $dataFim);
        
        $campos = array("id_pessoa" => Api::getIdPessoa(), "token" => Api::getToken(), "token_aplicacao" => Api::getTokenAplicacao(),
                        "id" => $_POST['id'],
                        "inicio" => $dataInicio,
                        "fim" => $dataFim,
                        "status" => $status_ciclo,
                        "custo" => moeda_to_float($_POST['custo']));
        $url = "ciclo/atualizar";
        
        $retorno = Api::requisicao($url, $campos);
        $ret = json_decode($retorno);
        
        if($ret->message == 'success'){
            echo "success";
        }else{
            echo $ret->message;
        }
        
    }

    //EXCLUIR CICLO
    if($_POST['function'] == 'remover_ciclo'){
        $campos = array("id_pessoa" => Api::getIdPessoa(), "token" => Api::getToken(), "token_aplicacao" => Api::getTokenAplicacao(),
                        "id" => $_POST['i']);
        $url = "ciclo/remover";
        
        $retorno = Api::requisicao($url, $campos);
        $ret = json_decode($retorno);
        
        if($ret->message == 'success'){
            echo "success";
        }else{
            echo $ret->message;
        }
    }    
    
    if($_POST['function'] == 'publicidadePorLocalList'){
        $campos = array("id_pessoa" => Api::getIdPessoa(), "token" => Api::getToken(), "token_aplicacao" => Api::getTokenAplicacao(),
                        "id_local" => $_POST['id_local']);
        $url = "publicidade/buscaPublicidadePorLocal";
        
        $retorno = Api::requisicao($url, $campos);
        $dados = json_decode($retorno);
        
        if(!isset($dados->codigo)){
            foreach ($dados as $dado){
                
                $inicio = formata_padrao_data($dado->ciclo->ciclo_inicio);
                $fim = formata_padrao_data($dado->ciclo->ciclo_fim);
                $status = getStatusCiclo($dado->ciclo->ciclo_status);

                echo'
                <div class="card-padding animated fadeIn" style="padding-bottom: 20px">
                    <a id="local'.$dado->id.'" class="list-group-item media localList" href="publicidadeDetail?i='.$dado->id.'">
                        <div class="pull-right">
                            <img style="width: 80px" src="../../mapping/'.$dado->layout_campanha.'" alt="">
                        </div>                        
                        <div class="media-body">
                            <div class="lgi-heading">'.$dado->nome_midia.'</div>
                            <small><strong>Ciclo: </strong>'.$inicio.' à '.$fim.'</small><br>
                            <small><strong>Status: </strong>'.$status.'</small>
                            
                        </div>
                    </a>  
                </div>';
        }
        }else{
            echo '<p class="animated fadeIn">Nenhuma publicidade</p>';
        }
    }

    if($_POST['function'] == 'publicidadeFiltroList'){
        $campos = array("id_pessoa" => Api::getIdPessoa(), "token" => Api::getToken(), "token_aplicacao" => Api::getTokenAplicacao(),
                        "campanha" => $_POST['campanha'], "midia" => $_POST['midia'], "status" => $_POST['status']);
        $url = "publicidade/filtroPublicidades";
        
        $retorno = Api::requisicao($url, $campos);
        $dados = json_decode($retorno);
        
        if(!isset($dados->codigo)){
            foreach ($dados as $dado){
                
                $inicio = formata_padrao_data($dado->ciclo->ciclo_inicio);
                $fim = formata_padrao_data($dado->ciclo->ciclo_fim);
                $status_pub = getStatusPublicidade($dado->status);
                $status = getStatusCiclo($dado->ciclo->ciclo_status);
                $local = $dado->nome_local." - ".$dado->nome_subgrupo." - ".$dado->nome_grupo;
                
                if($dado->ambiente == "e"){
                    $page = "publicidadeExternaDetail";
                }else{
                    $page = "publicidadeDetail";
                }

                echo'
                <div class="card-padding animated fadeIn" style="padding-bottom: 20px">
                    <a id="local'.$dado->id.'" class="list-group-item media localList" href="'.$page.'?i='.$dado->id.'">
                        <div class="pull-right">
                            <img style="width: 140px" src="../../mapping/'.$dado->layout_campanha.'" alt="">
                        </div>                        
                        <div class="media-body">
                            <div class="lgi-heading">'.$dado->nome_midia.'</div>
                            <small><strong>Descrição: </strong>'.$dado->descricao.'</small><br>
                            <small><strong>Local: </strong>'.$local.'</small><br>
                            <small><strong>Ciclo: </strong>'.$inicio.' à '.$fim.'</small><br>
                            <small><strong>Status Ciclo: </strong>'.$status.'</small><br>                                
                            <small><strong>Status Publicidade: </strong>'.$status_pub.'</small>
                        </div>
                    </a>  
                </div>';
        }
        }else{
            echo '<p class="animated fadeIn">Nenhuma publicidade</p>';
        }
    }    
}

function listarPublicidades(){
    $url = "publicidade/listarTudo";
    $campos = Array("id_pessoa" => Api::getIdPessoa(), "token" => Api::getToken(), "token_aplicacao" => Api::getTokenAplicacao());
    $retorno = Api::requisicao($url, $campos);
    $dados = json_decode($retorno);
    
    if(!isset($dados->codigo)){
        return $dados;
    }else{
        return "nenhum";
    }
}

function listarPublicidade($id){
    $url = "publicidade/listar";
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

function buscaQtdPublicidadePorGrupo($id){
    $url = "publicidade/buscaQtdPublicidadePorGrupo";
    $campos = array("id_pessoa" => Api::getIdPessoa(), "token" => Api::getToken(), "token_aplicacao" => Api::getTokenAplicacao(), 
                    "id_grupo" => $id);
    $retorno = Api::requisicao($url, $campos);
    $dados = json_decode($retorno);
    
    if(!isset($dados->codigo)){
        return $dados;
    }else{
        return "nenhum";
    }
}

function buscaPublicidadesPorMidia($id_midia){
    $url = "publicidade/buscaPublicidadesPorMidia";
    $campos = array("id_pessoa" => Api::getIdPessoa(), "token" => Api::getToken(), "token_aplicacao" => Api::getTokenAplicacao(), 
                    "id_midia" => $id_midia);
    $retorno = Api::requisicao($url, $campos);
    $dados = json_decode($retorno);
    
    if(!isset($dados->codigo)){
        return $dados;
    }else{
        return "nenhum";
    }
}

function buscaPublicidadesPorAmbiente($ambiente){
    $url = "publicidade/buscaPublicidadesPorAmbiente";
    $campos = array("id_pessoa" => Api::getIdPessoa(), "token" => Api::getToken(), "token_aplicacao" => Api::getTokenAplicacao(), 
                    "ambiente" => $ambiente);
    $retorno = Api::requisicao($url, $campos);
    $dados = json_decode($retorno);
    
    if(!isset($dados->codigo)){
        return $dados;
    }else{
        return "nenhum";
    }
}