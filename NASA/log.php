<?php
	function __autoload($class_name){
		require_once 'classes/' . $class_name . '.php';
	}
?>
<!DOCTYPE html>

<html>
<head>
<title>reveles</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="main.css">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script src="https://www.w3schools.com/lib/w3.js"></script>
<link href="https://fonts.googleapis.com/css?family=Abril+Fatface|Comfortaa:300,400,700|Srisakdi:400,700" rel="stylesheet">
<script type="text/javascript" src="js/funcoeslike.js"></script>
<script type="text/javascript" src="js/jquery-2.2.3.min.js"></script>

</head>
<body>

<div class="navbar">
  <a href="ct.html" class="singUP">Create</a>
</div>

<div class="main">
	<div id="leftBox" class="leftBox">
		<h1>Reveles</h1>
		 <img class="nature" src="01.jpg" width="100%" height="60%;">
		 <img class="nature" src="02.jpg" width="100%" height="60%;">
		 <img class="nature" src="03.jpg" width="100%" height="60%;">
		 <img class="nature" src="04.jpg" width="100%" height="60%;">
		 <img class="nature" src="05.jpg" width="100%" height="60%;">
		 <img class="nature" src="06.jpg" width="100%" height="60%;">
		 <img class="nature" src="07.jpg" width="100%" height="60%;">
		 <img class="nature" src="09.jpg" width="100%" height="60%;">
		 <img class="nature" src="10.jpg" width="100%" height="60%;">
		 <p>Our dream is to show you the world that we live</p>
		 <script>
w3.slideshow(".nature", 2000);
</script>
	</div>
	<div id="rightBox" class="rightBox">
		<h1>Welcome Back!</h1>
		<form action="" method="post">
		<label for="lname">Email: </label>
		<input type="email" id="emailL" class="emailL" name="emailL" placeholder="Your Email.."></br>
		<label for="1password">Password: </label>
		<input type="password" id="senhaL" class="senhaL" name="senhaL" placeholder="Your password..">
		<input type="submit" value="Confirm" class="entrar" id="entrar" name="entrar"><div id="div1"></div>
		</form>
		
	</div>
  
  
</div>
<?php
			
			if(isset($_POST["entrar"])){
			
				$email = $_POST["emailL"];
				$senha = $_POST["senhaL"];
				
				
				
				if ($email != '' && $senha != ''){
					
					$crud = new Crud();
					
					
					$consulta = $crud->verificarLogin($email,$senha);
					
						
				if($consulta){
				
						/*
						echo("<script>alert('teste');</script>");
						//print("teste");
						
						// Recuperando os dados do usuario se existir
						$dadosDoUsuario = $crud->resgatarDadosUsuario($email);
						
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
						
						header("Location:feed.php");
					
		
						/*<!--<script type="text/javascript">
							$("#div1").html("<div style='color: blue;'>Aguarde... </div><meta http-equiv=refresh content=0;URL=feed.php>");
						</script>-->*/

	
		
					}else{
						
					
		?>
						<script type="text/javascript">
							$("#div1").html("<div style='color: red;'>Combinacao errada!</div>");
						</script>
		
		<?php 
		
					}
				
				}else{
		
		?>
				
					<script type="text/javascript">
						$("#div1").html("<div style='color: yellow;'>Esqueceu de nada não?</div><meta http-equiv=refresh content=1;URL=index.php>");
					</script>
						
		<?php
		
				}
			}
			
		?>
</body>
</html>
