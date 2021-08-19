<?php
require_once 'api.php';
require_once 'manager_session.php';
require_once 'funcoes.php';

//POSTS

if (!empty($_POST)) {
    //INSERIR
    @session_start();
    if ($_POST['function'] == 'novo') {
                
        if (!empty($_FILES['layout'])) {
            $arquivo = $_FILES['layout'];
            if ($_FILES['layout']['name'] != "" or $_FILES['layout']['name'] != null) {
                preg_match("/\.(pdf|PDF|png|gif|jpg|jpeg){1}$/i", $arquivo["name"], $ext);
                $nome_arquivo = md5(uniqid(time())) . "." . $ext[1];
                $caminho_imagem = $_SERVER['DOCUMENT_ROOT'] . "/mapping_api/arquivos/" . $nome_arquivo;
                $caminho_bd = "arquivos/" . $nome_arquivo;
                move_uploaded_file($arquivo["tmp_name"], $caminho_imagem);
                $layout = $caminho_bd;
            }else {
                $layout = null;    
            }
        } else {
            $layout = null;
        }         
        
        $inicio = formata_padrao_data_bd($_POST['inicio']);
        $fim = formata_padrao_data_bd($_POST['fim']);
        $status = consultaStatusData($inicio, $fim);        
        
        $campos = array("id_pessoa" => Api::getIdPessoa(), "token" => Api::getToken(), "token_aplicacao" => Api::getTokenAplicacao(),
                        "nome" => $_POST['nome'], "descricao" => $_POST['descricao'], "ambiente" => $_POST['ambiente'], "inicio" => $inicio, "fim" => $fim,
                        "status" => $status, "pessoa_log" => $_POST['pessoa_log'], "layout" => $layout, "publicos" => $_POST['publicos']);
        $url = "campanha/novo";
        
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
        $url = "campanha/remover";
        
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
        
        $inicio = formata_padrao_data_bd($_POST['inicio']);
        $fim = formata_padrao_data_bd($_POST['fim']);
        $status = consultaStatusData($inicio, $fim);         
        
        $campos = array("id_pessoa" => Api::getIdPessoa(), "token" => Api::getToken(), "token_aplicacao" => Api::getTokenAplicacao(),
                        "id" => $_POST['id'], "nome" => $_POST['nome'], "descricao" => $_POST['descricao'], "ambiente" => $_POST['ambiente'], "inicio" => $inicio, "fim" => $fim,
                        "status" => $status, "publicos" => $_POST['publicos']);
        $url = "campanha/atualizar";
        
        $retorno = Api::requisicao($url, $campos);
        $ret = json_decode($retorno);
        
        if($ret->message == 'success'){
            echo "success";
        }else{
            echo $ret->message;
        }
    }
    
    //ATUALIZAR LAYOUT
    if($_POST['function'] == 'editLayout'){
        
        $arquivo = $_FILES['layout'];
        if (isset($_FILES['layout'])) {

            if ($_FILES['layout']['name'] != "" or $_FILES['layout']['name'] != null) {
                preg_match("/\.(pdf|PDF|png|gif|jpg|jpeg){1}$/i", $arquivo["name"], $ext);
                $nome_arquivo = md5(uniqid(time())) . "." . $ext[1];
                $caminho_imagem = $_SERVER['DOCUMENT_ROOT'] . "/mapping_api/arquivos/" . $nome_arquivo;
                $caminho_bd = "arquivos/" . $nome_arquivo;
                move_uploaded_file($arquivo["tmp_name"], $caminho_imagem);
                $layout = $caminho_bd;
            }else {
                $layout = null;    
            }
        } else {
            $layout = null;
        }         
        
        $campos = array("id_pessoa" => Api::getIdPessoa(), "token" => Api::getToken(), "token_aplicacao" => Api::getTokenAplicacao(),
                        "id" => $_POST['id'], "layout" => $layout);
        $url = "campanha/updateLayout";
        
        $retorno = Api::requisicao($url, $campos);
        $ret = json_decode($retorno);
        
        if($ret->message == 'success'){
            echo "success";
        }else{
            echo $ret->message;
        }
    }   
    
    //BUSCA CAMPANHA INST
    if($_POST['function'] == 'buscaCampanhaInst'){
        $campos = array("id_pessoa" => Api::getIdPessoa(), "token" => Api::getToken(), "token_aplicacao" => Api::getTokenAplicacao(),
                        "busca" => $_POST['busca'], "ambiente" => $_POST['ambiente']);
        $url = "campanha/buscaCampanhaInst";
        
        $retorno = Api::requisicao($url, $campos);
        $dados = json_decode($retorno);
        
        if(!isset($dados->codigo)){
            foreach ($dados as $dado){
            echo'
                <a class="list-group-item media" href="campanhaDetail?i='.$dado->id.'">
                    <div class="pull-right">
                        <img style="width: 180px" src="../../mapping/'.$dado->layout.'" alt="">
                    </div>
                <div class="media-body">
                    <div class="lgi-heading"><h4>'.$dado->nome.'</h4></div>
                        <small class="lgi-text">'.$dado->descricao.'</small>
                            
                    </div>
                </a>';
        }
        }else{
            echo "Nenhuma campanha";
        }
    }
    
    if($_POST['function'] == 'custoCampanha'){
        $campos = array("id_pessoa" => Api::getIdPessoa(), "token" => Api::getToken(), "token_aplicacao" => Api::getTokenAplicacao(),
                        "id_campanha" => $_POST['id_campanha']);
        $url = "campanha/custoPorCampanha";
        
        $retorno = Api::requisicao($url, $campos);
        $dados = json_decode($retorno);
        
        if(!isset($dados->codigo)){
            echo "R$ ".moeda($dados->custo);
        
        }else{
            echo "Nenhum custo";
        }
    }    

    //BUSCA INICIO CICLO
    if($_POST['function'] == 'buscaInicio'){
        $campos = array("id_pessoa" => Api::getIdPessoa(), "token" => Api::getToken(), "token_aplicacao" => Api::getTokenAplicacao(),
                        "id" => $_POST['id']);
        $url = "campanha/listar";
        
        $retorno = Api::requisicao($url, $campos);
        $dados = json_decode($retorno);
        
        if(!isset($dados->codigo)){
            echo formata_padrao_data($dados->inicio);
        }else{
            echo "nenhum";
        }
    }
    
    //BUSCA FIM CICLO
    if($_POST['function'] == 'buscaFim'){
        $campos = array("id_pessoa" => Api::getIdPessoa(), "token" => Api::getToken(), "token_aplicacao" => Api::getTokenAplicacao(),
                        "id" => $_POST['id']);
        $url = "campanha/listar";
        
        $retorno = Api::requisicao($url, $campos);
        $dados = json_decode($retorno);
        
        if(!isset($dados->codigo)){
            echo formata_padrao_data($dados->fim);
        }else{
            echo "nenhum";
        }
    }     
    
}

function listarCampanhas(){
    $url = "campanha/listarTudo";
    $campos = Array("id_pessoa" => Api::getIdPessoa(), "token" => Api::getToken(), "token_aplicacao" => Api::getTokenAplicacao());
    $retorno = Api::requisicao($url, $campos);
    $dados = json_decode($retorno);
    
    if(!isset($dados->codigo)){
        return $dados;
    }else{
        return "nenhum";
    }
}

function listarCampanha($id){
    $url = "campanha/listar";
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

function validaPublicoCampanha($id_publico, $id_campanha){
    $url = "campanha/validarPublico";
    $campos = Array("id_pessoa" => Api::getIdPessoa(), "token" => Api::getToken(), "token_aplicacao" => Api::getTokenAplicacao(),
                    "id_publico" => $id_publico, "id_campanha" => $id_campanha);
    $retorno = Api::requisicao($url, $campos);
    $dados = json_decode($retorno);
    
    return $dados;

}

function buscaPublicosPorCampanha($id_campanha){
    $url = "campanha/buscaPublicosPorCampanha";
    $campos = array("id_pessoa" => Api::getIdPessoa(), "token" => Api::getToken(), "token_aplicacao" => Api::getTokenAplicacao(), 
                    "id_campanha" => $id_campanha);
    $retorno = Api::requisicao($url, $campos);
    $dados = json_decode($retorno);
    
    if(!isset($dados->codigo)){
        return $dados;
    }else{
        return "nenhum";
    }
}

function buscaProximasCampanhas(){
    $url = "campanha/buscaProximasCampanhas";
    $campos = array("id_pessoa" => Api::getIdPessoa(), "token" => Api::getToken(), "token_aplicacao" => Api::getTokenAplicacao());
    $retorno = Api::requisicao($url, $campos);
    $dados = json_decode($retorno);
    
    if(!isset($dados->codigo)){
        return $dados;
    }else{
        return "nenhum";
    }
}

function buscaCampanhasEmAndamento(){
    $url = "campanha/buscaCampanhasEmAndamento";
    $campos = array("id_pessoa" => Api::getIdPessoa(), "token" => Api::getToken(), "token_aplicacao" => Api::getTokenAplicacao());
    $retorno = Api::requisicao($url, $campos);
    $dados = json_decode($retorno);
    
    if(!isset($dados->codigo)){
        return $dados;
    }else{
        return "nenhum";
    }
}