<!DOCTYPE html>
<html lang="pt-BR">
	
	<head>
		<title>Portal das F@bula</title>
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta name="keywords" content="Church Sign In Form,Login Forms,Sign up Forms,Registration Forms,News latter Forms,Elements"./>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		
		<script type="text/javascript" src="js/jquery-2.2.3.min.js"></script>
	</head>
	<body>	
		<div id="div3"></div>
	</body>
</html>

<?php
	
	require_once 'classes/CRUD.php';

	$idUsuario = $_GET['id'];
	
	if (isset($idUsuario)){
		
		$crud = new Crud();
		
		$resultado = $crud->atualizaStatus($idUsuario);
		
		if($resultado){
			
?>
					
			<script type="text/javascript">
				$("#div3").html("<div style='color: blue; text-align: center'>Conta ativada com sucesso!!!<br/>Aguarde, você será redirecionado ...</div><meta http-equiv=refresh content=4;URL=index.php>");
			</script>
									
<?php
			
		}else{
			
?>
					
			<script type="text/javascript">
				$("#div3").html("<div style='color: red; text-align: center'>Erro ao ativar sua conta!</div><meta http-equiv=refresh content=4;URL=index.php>");
			</script>
									
<?php

		}
		
	}

?>