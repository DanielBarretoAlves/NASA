<?php
	function __autoload($class_name){
		require_once 'classes/' . $class_name . '.php';
	}
?>

<!DOCTYPE html>
<html lang="pt-BR">
	
	<head>
		<title>Portal das F@abula</title>
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta name="keywords" content="Church Sign In Form,Login Forms,Sign up Forms,Registration Forms,News latter Forms,Elements"./>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		
		<link rel='stylesheet' type='text/css' href="css/estiloLogin.css" />
		<link rel="stylesheet" type='text/css' href="css/estiloPrincipal.css">
		
		<link rel="stylesheet" href="css/estiloRS.css">
		
		<script type="text/javascript" src="js/funcoeslike.js"></script>
		<script type="text/javascript" src="js/jquery-2.2.3.min.js"></script>
		
		<!--webfonts-->
		<link href='http://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,400,300,600,700,800' rel='stylesheet' type='text/css'>
		<!--//webfonts-->
		
	</head>
	
	<body>
		<h1></h1>
		
			<div class="app-cross">
				
				<div class="cross">
					<img src="img/login/cross.png" class="img-responsive" alt="" />
				</div>
				
				<h2>REDEFINA SUA SENHA</h2>
				
				<form action="" method="post">
					<input type="password" onkeyup="verificarSenha()" placeholder="Digite a senha" id="senha1" name="senha1" autocomplete="off" required />
					<input type="password" onkeyup="verificarSenha()" placeholder="Repita a senha" id="senha2" name="senha2" autocomplete="off" required />
					
					<br/>
					
					<img id="olho" src="img/olho.png" />
					
					<div id="resultado"></div>
					
					<div class="submit"><input type="submit" value="REDEFINIR" name="btnSubmit" id="submit" disabled="disabled" /></div>
					
					<div class="clear"></div>
					
				</form>
				<br/>
				<div id="div1"></div>
				
			</div>
			
		<!--start-copyright-->
	   		<div class="copy-right">
					<p>Copyright &copy; 2016  Todos direitos reservados </p>
			</div>
		<!--//end-copyright-->
		
		<script type="text/javascript">

			var senha1 = $('#senha1');
			var senha2 = $('#senha2');

			var olho   = $("#olho");

			olho.mousedown(function() {
				senha1.attr("type", "text");
				senha2.attr("type", "text");
			});

			olho.mouseup(function() {
				senha1.attr("type", "password");
				senha2.attr("type", "password");
			});

			olho.mouseover(function() {
				senha1.attr("type", "password");
				senha2.attr("type", "password");
			});
			
			// para evitar o problema de arrastar a imagem e a senha continuar exposta, citada pelo nosso amigo nos comentários
			olho.mouseout(function() { 
				senha1.attr("type", "password");
				senha2.attr("type", "password");
			});
				
		</script>
		
	</body>

</html>

<?php
	
	require_once 'classes/CRUD.php';

	if (isset($_POST['btnSubmit'])) {
		if (isset($_GET['conta'])){
			if(isset($_POST['senha2'])){
				
				$crud = new Crud();
				
				$emailUsuario = base64_decode($_GET['conta']);
				$novaSenha    = $_POST['senha2'];
				
				// Recuperando (se houver) registro que contenha o e-mail que foi passado como parÃ¢metro
				$resultadoIdUsuario = $crud->resgatarID($emailUsuario);
				
				if (count($resultadoIdUsuario) > 0){
					
					$idUsuario = $resultadoIdUsuario->idUsuario;
					
					$resultado = $crud->redefinirSenhaUsuario($idUsuario,$novaSenha);
				
					if ($resultado){

?>

						<script type="text/javascript">
							alert("Senha alterada com sucesso.");
							document.location.href= "index.php";
						</script>

<?php

					}else{

?>

						<script type="text/javascript">
							alert("Erro ao alterar Senha.");
						</script>

<?php

					}
				
				}else{
				
?>
					<script type="text/javascript">
						alert("Estão faltando dados.");
					</script>
	
<?php 

				}		
			}
		}
	}

?>