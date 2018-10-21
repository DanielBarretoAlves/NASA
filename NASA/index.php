<?php
	function __autoload($class_name){
		require_once 'classes/' . $class_name . '.php';
	}
?>

<!DOCTYPE html>
<html lang="pt-BR">
	
	<head>
		<title>Portal das F@bulas</title>
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta name="keywords" content="Church Sign In Form,Login Forms,Sign up Forms,Registration Forms,News latter Forms,Elements"./>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		
		<link rel='stylesheet' type='text/css' href="css/estiloLogin.css" />
		<link rel="stylesheet" type='text/css' href="css/estiloPrincipal.css">
		
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
				
				<h2>LOGIN</h2>
				
				<form action="" method="post">
					<input type="email" id="emailL" name="emailL" placeholder="Digite seu e-mail"   onfocus="this.value = '';" class="text" required />
					<input type="password" id="senhaL" name="senhaL" placeholder="Digite sua senha" onfocus="this.value = '';" required />
					
					<br/>
					
					<img id="olho" src="img/olho.png" />
					
					<div class="submit"><input type="submit" value="ENTRAR" name="entrar" /></div>
					
					<div id="div1"></div>
					
					<div class="clear"></div>
					<h3><a href="javascript:void(0);" id="botaoE" onclick="enviarEmail();">Esqueceu a senha ?</a></h3>
				</form>
				<br/>
				
				
				<div class="buttons">
					<a href="#" class="hvr-shutter-in-verticalfacebook">Entrar com Facebook</a>
					<!-- <br/><br/>
					<a href="#" class="hvr-shutter-in-verticaltwitter">Entrar com Twitter</a> -->
				</div>
				<h4>Novo aqui ? <a href="cadastrarusuario.php"> Cadastre-se</a></h4>
				
			</div>
			
		<!--start-copyright-->
	   		<div class="copy-right">
					<p>Copyright &copy; 2016  Todos direitos reservados </p>
			</div>
		<!--//end-copyright-->
		
		
		<?php
			
			if(isset($_POST["entrar"])){
			
				$email = $_POST["emailL"];
				$senha = $_POST["senhaL"];
				
				if ($email != '' && $senha != ''){
				
					$crud = new Crud();
					
					$consulta = $crud->verificarLogin($email,$senha);
					
					if($consulta){
						
						print("teste");
						
						// Recuperando os dados do usuario se existir
						/*$dadosDoUsuario = $crud->resgatarDadosUsuario($email);
						
						$idUsuario      = $dadosDoUsuario->idUsuario;
						$nomeUsuario    = explode(' ', $dadosDoUsuario->nome);
							
						//Inicianco a sess�o para acessar o vetor $_SESSION[]
						session_start();
						
						// Criando as sess�es
						$_SESSION['id_usuario'] = $idUsuario;
						
						if ($nomeUsuario[0] == '')
							$_SESSION['n_usuario']  = 'USUARIO';
						else
							$_SESSION['n_usuario']  = $nomeUsuario[0];*/
					
		?>
						<!--<script type="text/javascript">
							$("#div1").html("<div style='color: blue;'>Aguarde ...</div><meta http-equiv=refresh content=2;URL=principal.php>");
						</script>-->

		<?php 
		
					}else{
					
		?>
						<script type="text/javascript">
							$("#div1").html("<div style='color: red;'>Combinacao errada!<br/> Ou e-mail n�o foi ativado!</div><meta http-equiv=refresh content=1;URL=index.php>");
						</script>
		
		<?php 
		
					}
				
				}else{
		
		?>
				
					<script type="text/javascript">
						$("#div1").html("<div style='color: yellow;'>Esqueceu de nada n�o?</div><meta http-equiv=refresh content=1;URL=index.php>");
					</script>
						
		<?php
		
				}
			}
			
		?>
		
		<script type="text/javascript">
			
			$('#botaoE').click(function(){
				email = $('#emailL').val();
				recuperarSenha(email);
			});
		</script>
		
		<script type="text/javascript">

			var senha = $('#senhaL');
			var olho  = $("#olho");

			olho.mousedown(function() {
				senha.attr("type", "text");
			});

			olho.mouseup(function() {
				senha.attr("type", "password");
			});

			olho.mouseover(function() {
				senha.attr("type", "password");
			});
			
			// para evitar o problema de arrastar a imagem e a senha continuar exposta, citada pelo nosso amigo nos coment�rios
			olho.mouseout(function() { 
				senha.attr("type", "password");
			});
				
		</script>
		
	</body>

</html>