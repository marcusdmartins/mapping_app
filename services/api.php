<?php
class Api{

    public static function requisicao($url, $campos){
        
        //$uri_on = "../../mapping/".$url;
        $uri_off = "localhost/mapping_api/".$url;
        
        $mediaType = "application/json";
        // formato da requisição
        $charSet = "UTF-8";
        $headers = array();
        $headers[] = "Accept: " . $mediaType;
        $headers[] = "Accept-Charset: " . $charSet;
        $headers[] = "Accept-Encoding: " . $mediaType;
        $headers[] = "Content-Type: " . $mediaType . ";charset=" . $charSet;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $uri_off);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($campos));
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $result = curl_exec($ch);
        
        return $result;

    }
    
    public static function getIdPessoa(){
        if(!empty($_SESSION['UsuarioID'])){
            $id_pessoa = $_SESSION['UsuarioID'];            
        }else{
            $id_pessoa = null;             
        }        
        return $id_pessoa;
    }    
    
    public static function getToken(){
        if(!empty($_SESSION['token'])){
            $token = $_SESSION['token'];
        }else{
            $token = null;
        }
        return $token;
    }
    
    public static function getTokenAplicacao(){
        $token_aplicacao = "asbdhjoasdu";
        return $token_aplicacao;        
    }    
}