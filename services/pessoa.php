<?php
require_once 'api.php';
require_once 'manager_session.php';
require_once 'funcoes.php';

//POSTS
if (!empty($_POST)) {
    //INSERIR
    @session_start();
    if ($_POST['function'] == 'nova') {
        
        $senha = "mappinghsd";
        $campos = array("id_pessoa" => Api::getIdPessoa(), "token" => Api::getToken(), "token_aplicacao" => Api::getTokenAplicacao(),
                        "nome" => $_POST['nome'],
                        "email" => $_POST['email'],
                        "senha" => $senha,
                        "tipoUsuario" => $_POST['tipoUsuario']);
        
        $url = "pessoa/nova";
        
        $retorno = Api::requisicao($url, $campos);
        $ret = json_decode($retorno);
        
        if($ret->message == 'success'){
            echo "success";
        }else{
            echo "error";
        }
        
    }
    
    //BLOQUEAR
    if($_POST['function'] == 'bloq'){
        $campos = array("id_pessoa" => Api::getIdPessoa(), "token" => Api::getToken(), "token_aplicacao" => Api::getTokenAplicacao(),
                        "id" => $_POST['i']);
        $url = "pessoa/bloquear";
        
        $retorno = Api::requisicao($url, $campos);
        $ret = json_decode($retorno);
        
        if($ret->message == 'success'){
            echo "success";
        }else{
            echo $ret->message;
        }
    }
    
    //DESBLOQUEAR
    if($_POST['function'] == 'desbloq'){
        $campos = array("id_pessoa" => Api::getIdPessoa(), "token" => Api::getToken(), "token_aplicacao" => Api::getTokenAplicacao(),
                        "id" => $_POST['i']);
        $url = "pessoa/desbloquear";
        
        $retorno = Api::requisicao($url, $campos);
        $ret = json_decode($retorno);
        
        if($ret->message == 'success'){
            echo "success";
        }else{
            echo $ret->message;
        }
    }
    
    //RESETAR
    if($_POST['function'] == 'reset'){
        $campos = array("id_pessoa" => Api::getIdPessoa(), "token" => Api::getToken(), "token_aplicacao" => Api::getTokenAplicacao(),
                        "id" => $_POST['i']);
        $url = "pessoa/resetar";
        
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
                        "id" => $_POST['id'],
                        "nome" => $_POST['nome'],
                        "email" => $_POST['email'],
                        "tipoUsuario" => $_POST['tipoUsuario']);
        
        $url = "pessoa/atualizar";
        
        $retorno = Api::requisicao($url, $campos);
        $ret = json_decode($retorno);
        
        if($ret->message == 'success'){
            echo "success";
        }else{
            echo $ret->message;
        }
    }
    
    //ATUALIZAR
    if($_POST['function'] == 'altera_senha'){
        
        if($_POST['senha_nova'] == $_POST['repeticao']){
        
        $campos = array("id_pessoa" => Api::getIdPessoa(), "token" => Api::getToken(), "token_aplicacao" => Api::getTokenAplicacao(),
                        "id" => $_POST['id'],
                        "senha_antiga" => $_POST['senha_antiga'],
                        "senha_nova" => $_POST['senha_nova']);
        
        $url = "pessoa/alteraSenha";
        
        $retorno = Api::requisicao($url, $campos);
        $ret = json_decode($retorno);
        
        if($ret->message == 'success'){
            echo "success";
        }else{
            echo $ret->message;
        }
        
        }else{
            echo "Confirmação da senha incorreta";
        }
    }    

    //BUSCA POR LOGIN
    if($_POST['function'] == 'buscaPorLogin'){
        $campos = array("login" => $_POST['login']);
        $url = "pessoa/buscaPorLogin";
        
        $retorno = Api::requisicao($url, $campos);
        $ret = json_decode($retorno);
        
        if($ret->message == 'disponivel'){
            echo "disponivel";
        }else{
            echo $ret->message;
        }
    }
    
    //BUSCA INSTANTANEA
    if($_POST['function'] == 'buscaInstPessoa'){
        $campos = array("busca" => $_POST['busca'], "tipoUsuario" => $_POST['tipoUsuario']);
        $url = "pessoa/buscaInstPessoa";
        
        $retorno = Api::requisicao($url, $campos);
        $dados = json_decode($retorno);
        
        if(!isset($dados->codigo)){
            
            if($_POST['tipoUsuario'] == '5'){
                $link_page = 'alunoDetail';
            }else if($_POST['tipoUsuario'] == '6'){
                $link_page = 'responsavelDetail';
            }else if($_POST['tipoUsuario'] == '4'){
                $link_page = 'professorDetail';
            }
            
            foreach ($dados as $dado){
            echo'
                <a class="list-group-item media" href="'.$link_page.'?i='.$dado->id.'">
                    <div class="pull-left">
                        <img class="lgi-img" src="fotos/avatar.png" alt="">
                    </div>
                <div class="media-body">
                    <div class="lgi-heading">'.$dado->nome.'</div>
                        <small><strong>CPF: </strong>'.$dado->cpf.'</small><br>
                        <small><strong>Email: </strong>'.$dado->email.'</small><br>
                        <small><strong>Login: </strong>'.$dado->login.'</small>
                    </div>
                </a>';
        }
        }else{
            echo "Nenhum";
        }
    }

    //BUSCA POR ID
    if($_POST['function'] == 'listarPessoa'){
        $campos = array("id" => $_POST['id']);
        $url = "pessoa/listar";
        
        $retorno = Api::requisicao($url, $campos);
        $ret = json_decode($retorno);
        
        if(!isset($ret->codigo)){
            echo $retorno;
        }else{
            echo "nenhum";
        }        
    }    
}

function listarPessoas(){
    $url = "pessoa/listarTudo";
    $campos = array("id_pessoa" => Api::getIdPessoa(), "token" => Api::getToken(), "token_aplicacao" => Api::getTokenAplicacao());
    $retorno = Api::requisicao($url, $campos);
    $dados = json_decode($retorno);
    
    if(!isset($dados->codigo)){
        return $dados;
    }else{
        return "nenhum";
    }
}

function listarPessoa($id){
    $url = "pessoa/listar";
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

function listarPessoasPorTipo($tipo){
    $url = "pessoa/listarPorTipo";
    $campos = Array("tipoUsuario" => $tipo);
    $retorno = Api::requisicao($url, $campos);
    $dados = json_decode($retorno);
    
    if(!isset($dados->codigo)){
        return $dados;
    }else{
        return "nenhum";
    }
}

function buscaPorResponsavel($id){
    $url = "pessoa/buscaPorResponsavel";
    $campos = Array("id_responsavel" => $id);
    $retorno = Api::requisicao($url, $campos);
    $dados = json_decode($retorno);
    
    if(!isset($dados->codigo)){
        return $dados;
    }else{
        return "nenhum";
    }
}