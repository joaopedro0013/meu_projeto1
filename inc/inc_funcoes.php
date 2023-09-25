<?php

function abreConexao($configuracoes = array()){

	$connection	=	mysqli_connect(
									$configuracoes['db_host'],
									$configuracoes['db_user_name'],
									$configuracoes['db_password'],
									$configuracoes['db_name']
								);
	
	mysqli_query($connection, "SET NAMES 'utf8'");
	mysqli_query($connection, 'SET character_set_connection=utf8');
	mysqli_query($connection, 'SET character_set_client=utf8');
	mysqli_query($connection, 'SET character_set_results=utf8');

	return $connection;
}


function fechaConexao(){
	@mysql_close();
}

function trataPost(){
	
	$post = null;
	
	if($_POST){
		foreach($_POST as $field => $value){
			$post[$field] = htmlspecialchars(strip_tags(trim($value),'<>'),ENT_QUOTES,'ISO-8859-1');
		}
	}
	
	return $post;
	
}

function abreSessaoUsuario($rowUsuario = array()){
	@session_start();
	$_SESSION = $rowUsuario;
}

function validaSessao($configuracoes){
	@session_start();
	if(!$_SESSION['login']){
		header("Location: login.php");
		exit();
	}
}

?>