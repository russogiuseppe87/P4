<?php

namespace Blog\Model\User; 

class User{

	private $_id;
	private $_username;
	private $_pass;
	private $_email;
	private $_creation_date_fr;

	public function __construct(array $donnees){

	    $this->hydrate($donnees);
	}

	private function hydrate(array $donnees){
	
		foreach ($donnees as $key => $value){
	      	$method = 'set'.ucfirst($key);

	      	if(method_exists($this, $method)){
	      		$this->$method($value);
	      	}
	    }
	}


	public function id(){
		return $this->_id;
	}
	public function username(){
		return $this->_username;
	}
	public function pass(){
		return $this->_pass;
	}
	public function email(){
		return $this->_email;
	}
	public function creation_date_fr(){
		return $this->_creation_date_fr;
	}


	public function setId($id){
		// On convertit l'argument en nombre entier.
		$id = (int) $id;
		// On vérifie ensuite si ce nombre est bien strictement positif.
		if ($id > 0){
			$this->_id = $id;
		}
	}
	public function setUsername($username){
		// On vérifie qu'il s'agit bien d'une chaîne de caractères.
		if (is_string($username)){
	      	$this->_username = $username;
	    }
	}
	public function setPass($pass){
		if (is_string($pass)){
	      	$this->_pass = $pass;
	    }
	}
	public function setEmail($email){
		if (is_string($email)){
	      	$this->_email = $email;
	    }
	}
	public function setCreation_date_fr($creation_date_fr){
		$this->_creation_date_fr = $creation_date_fr;
	}

}