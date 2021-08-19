<?php

class Login{

public $id;
public $email;
public $senha;
public $nivel;

//getters e setters

	function setEmail($email){
		
		$this->email = $email;
		
	}
	function getEmail(){
		
		return $this->email;
		
	}
	
	function setSenha($senha){
		
		$this->senha = $senha;
		
	}
	
	function getSenha(){
		
		return $this->senha;
		
	}
	

}