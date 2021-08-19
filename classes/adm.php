<?php

require_once 'adm-controller.php';

@session_start();

if(!empty($_GET['f'])){
    
    if($_GET['f'] == 'excl'){
        
        $id_adm = $_GET['i'];
        
        $adm_controller = new Adm_controller();
        
        $retorno_funcao = $adm_controller->excluiAdm($id_adm);
        
        if($retorno_funcao == 'success'){
            
            $_SESSION['message'] = 18;
            echo"<script>location.href = '../adms.php';</script>";             
            
        }else{
            
            $_SESSION['message'] = 19;
            echo"<script>location.href = '../adms.php';</script>"; 
            
        }
        
    }
    
}

if(!empty($_POST['function'])){
    
    if($_POST['function'] == 'nova_adm'){
        
        $adm_controller = new Adm_controller();
        $adm = new Adm();
        
        $adm->nome_adm = $_POST['nome_adm'];

        $retorno_funcao = $adm_controller->novaAdm($adm);
        
        if($retorno_funcao == 'success'){
            
            $_SESSION['message'] = 3;
            echo"<script>location.href = '../admsView.php';</script>";             
            
        }else{
            
            $_SESSION['message'] = 4;
            echo"<script>location.href = '../admsView.php';</script>";               
            
        }
        
    }    
    
    if($_POST['function'] == 'auto_cadastro_adm'){
        
        $adm_controller = new Adm_controller();
        $adm = new Adm();
        
        $adm->nome_adm = $_POST['nome_adm'];
        $id_pessoa = $_POST['id_pessoa'];
        $id_cond = $_POST['id_cond'];

        $retorno_funcao = $adm_controller->novaAdmFirst($adm, $id_cond, $id_pessoa);
        
        if($retorno_funcao == 'success'){
            
            echo"<script>location.href = 'login.php?i=$id_pessoa&f=valida';</script>";         
            
        }else{
            
            $_SESSION['message'] = 4;
            echo"<script>location.href = '../novaAdmFirst.php';</script>";               
            
        }
        
    }
    
    if($_POST['function'] == 'edit_adm'){
        
        $adm_controller = new Adm_controller();
        $adm = new Adm();
        
        $adm->id_adm = $_POST['id_adm'];
        $adm->nome_adm = $_POST['nome_adm'];

        $retorno_funcao = $adm_controller->editAdm($adm);
        
        if($retorno_funcao == 'success'){
            
            $_SESSION['message'] = 3;
            echo"<script>location.href = '../admDetail.php?i=$adm->id_adm';</script>";             
            
        }else{
            
            $_SESSION['message'] = 4;
            echo"<script>location.href = '../admDetail.php?i=$adm->id_adm';</script>";               
            
        }
        
    }
    
}

function buscaAdmPorId($id_adm){
    
    $adm_controller = new Adm_controller();
    
    $dado = $adm_controller->buscaAdmPorId($id_adm);
    
    return $dado;
    
}

function buscaAdmPorUsuario($id_user){
    
    $adm_controller = new Adm_controller();
    
    $dados = $adm_controller->buscaAdmPorUsuario($id_user);
    
    return $dados;
    
}

function buscaTodasAdm(){
    
    $adm_controller = new Adm_controller();
    
    $dados = $adm_controller->buscaTodasAdm();
    
    return $dados;
    
}
