<?php

use \Blog\Model;
use \Blog\Model\User\UserManager;
use \Blog\Model\Comment\CommentManager;
use \Blog\Model\User\User;
use \Exception;


    /* PAGE */ 


function createUserForm($postTitles){
	require('view/frontend/createUserFormView.php');
}

function connectUserForm($connectionParameters, $postTitles){
	require('view/frontend/connectUserFormView.php');
}

function readUser($connectionParameters, $postTitles){
}


    /* ACTION */ 


function createUser($username, $pass, $email){
	// Hachage du mot de passe
	$pass_hache = password_hash($pass, PASSWORD_DEFAULT);

	$userManager = new UserManager();

    $user = new User([
      'username' => $username,
      'pass' => $pass_hache,
      'email' => $email
    ]);

    $affectedLines = $userManager->create($user);

    if ($affectedLines === false) {
        throw new \Exception('Impossible d\'enregistrer l\'utilisateur');
    }
    else {
        header('Location: index.php?page=readPostsList');
    }
}

function connectUser($username, $pass, $rememberMe = false){ 

	$userManager = new UserManager();
	// On vérifie qu'il s'agit bien d'une chaîne de caractères
	if (is_string($username)){
		$resultat = $userManager->get($username);
	}

	if (!$resultat){
	     throw new \Exception('Mauvais identifiant ou mot de passe'); 
	} else {

		$user = new User($resultat);
		// Comparaison du pass envoyé via le formulaire avec la base
		$isPasswordCorrect = password_verify($pass, $user->pass());

	    if ($isPasswordCorrect) {
	    	if ($rememberMe === 'on'){
	        	setcookie('pass_hache', $user->pass(), time() + 365*24*3600, null, null, false, true);
		        setcookie('username', $username, time() + 365*24*3600, null, null, false, true);

		        // Suppression des variables de session et de la session 
				$_SESSION = array();
				session_destroy();
			} else {
				$_SESSION['pass_hache'] = $user->pass();
	        	$_SESSION['username'] = $username;

	        	// Suppression des cookies de connexion automatique
				setcookie('pass_hache', '');
				setcookie('username', '');
			}
	    }
	    else {
	        throw new Exception('Mauvais identifiant ou mot de passe'); 
	    }
	}
	header('Location: index.php?page=readPostsList');
}

function disconnectUser($connectionParameters){

	if (isset($connectionParameters['validCookies'])){
		// Ignore les identifiants de cookies pendant la session
		$_SESSION['ignoreCookies'] = true;

	} else {
		// Suppression des variables de session et de la session
		$_SESSION = array();
		session_destroy();
	}
	header('Location:index.php');
}

function verifyConnectionId($pass_hache, $username){

	$userManager = new UserManager();
	// Vérification de l'information envoyée
	if (is_string($username)){
		$resultat = $userManager->get($username);
	} else {
		return false; // Invalid connection id 
	}
	// Vérification de la présence de l'username envoyé dans la base
	if (!$resultat){
	    return false; // Invalid connection id  
	} else {
		$user = new User($resultat);
		$isPasswordCorrect = $pass_hache === $user->pass();
	}
	// Comparaison du pass envoyé avec celui de la base
	if ($isPasswordCorrect){
		return true; //connection enabled
	} else {
		return false; // Invalid connection id 
	}
}

function updateUser(){
}

function removeUser(){
}