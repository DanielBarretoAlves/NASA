<?php
	
	require_once 'classes/CRUD.php';
	
	$crud = new Crud();
	
	// Resgatando o array de resultado de f�bulas
	$resultadoFabulas = $crud->resgatarTodasFabulas();

	foreach ($resultadoFabulas as $dadosFabulas){
			
		$qtdLikes    = count($crud->pegaQtdLikes($dadosFabulas->idFabula));
		$qtdDislikes = count($crud->pegaQtdDislikes($dadosFabulas->idFabula));
		$ranking     = $qtdLikes - $qtdDislikes;
		
		$crud->atualizarQtdLikes($dadosFabulas->idFabula,$qtdLikes);
		$crud->atualizarQtdDislikes($dadosFabulas->idFabula,$qtdDislikes);
		$crud->atualizaRanking($dadosFabulas->idFabula,$ranking);
		
	}
	
	// inicia o manipulador de sess�o
	session_start();
	
	unset ($_SESSION['id_usuario']);
	
	$_SESSION = array();
	
	// recupera o nome do identificador de sess�o
	$cookie_name = session_name();
	
	// elimina todas as informa��es relacionadas � sess�o atual
	session_destroy();
	
	// encerra o manipulador de sess�o
	session_write_close();
	
	// limpa o cookie identificador de sess�o
	setcookie(session_name(),'',time()-300);
	
	header("Location: index.php");
	
?>