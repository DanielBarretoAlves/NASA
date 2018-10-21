<?php require_once "header.php"; ?>

<?php
					
	//coletando dados da $_SESSION
	if(IsSet($_SESSION['id_usuario']))
		$idUsuario = $_SESSION['id_usuario'];
		
?>

		<div id="banner">
			<div class="container">
				<div class="app-cross">
				
					<form action="" method="post">
						<input type="password" onkeyup="verificarSenha()" placeholder="Nova senha" id="senha1" name="senha1" autocomplete="off" required />
						<input type="password" onkeyup="verificarSenha()" placeholder="Repita a nova senha" id="senha2" name="senha2" autocomplete="off" required />
						
						<br/>
						
						<img id="olho" src="img/olho.png" />
						
						<div id="resultado"></div>
						
						<div class="submit"><input type="submit" value="TROCAR SENHA" name="btnSubmit" id="submit" disabled="disabled" /></div>
						
						<div class="clear"></div>
						
					</form>
					<br/>
					<div id="div1"></div>
					
				</div>
			</div>
		</div>
		
<?php require_once "footer.php"; ?>

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
			
			// para evitar o problema de arrastar a imagem e a senha continuar exposta, citada pelo nosso amigo nos coment�rios
			olho.mouseout(function() { 
				senha1.attr("type", "password");
				senha2.attr("type", "password");
			});
				
		</script>
	
<?php require_once "footerjs.php"; ?>

<?php
	
	require_once 'classes/CRUD.php';

	if (isset($_POST['btnSubmit'])){
		
		if(isset($_POST['senha2'])){
			
			$crud = new Crud();
				
			$novaSenha = $_POST['senha2'];
			
			// Alterando a senha no banco de dados
			$resultadoIdUsuario = $crud->alterarSenha($idUsuario,$novaSenha);
				
			if ($resultadoIdUsuario){
				
				// Importa as classes phpmailer e smtp
				require("phpmailer/class.phpmailer.php");
				require("phpmailer/class.smtp.php");
					
				// faz uma inst�ncia da classe PHPMailer
				$phpmail = new PHPMailer();
				
				// Setando a linguagem
				$phpmail->setLanguage('pt','phpmailer/language/');
				
				$host                = 'smtp.gmail.com';
				$username            = 'portaldasfabulas@gmail.com';
				$password            = 'f@bulando';
				$port                = 587;
				$secure              = 'tls';
				
				$from                = $username;            // Remetente
				$fromname            = 'Portal das f@bulas'; // Nome do remetente
				
				// Define que � uma conex�o SMTP
				$phpmail->isSMTP();
				
				// enables SMTP debug information (for testing)
				// 1 = errors and messages
				// 2 = messages only
				$phpmail->SMTPDebug = 0;
				
				// Define o endere�o do servidor de envio
				$phpmail->Host       = $host;
					
				// Utilizar autentica��o SMTP
				$phpmail->SMTPAuth   = true;
					
				// Email ou usu�rio para autentica��o
				$phpmail->Username   = $username;
					
				// Senha do usu�rio
				$phpmail->Password   = $password;
					
				//Porta da conex�o
				$phpmail->Port       = $port;
				
				// Protocolo da conex�o
				$phpmail->SMTPSecure = $secure;
					
				// Preenchimento do campo FROM do e-mail
				$phpmail->From       = $from;
				$phpmail->FromName   = $fromname;
				
				// Nome do destinat�rio
				$nomeDestinatario = "Prezadx";
				
				// Pegando o email do destinatário
				$dadosDoUsuario = $usuario->selectEditar($idUsuario);
				$emailDestinatario = $dadosDoUsuario->email;
				
				// Configura os destinat�rios - Endere�os que devem receber a mensagem
				$phpmail->addAddress($emailDestinatario,$nomeDestinatario);
					
				// Configura a mensagem
				$phpmail->isHTML(true);
					
				// Charset da mensagem (opcional)
				$phpmail->CharSet    = 'UTF-8';
					
				// Tamanhdo do texto por linha
				$phpmail->WordWrap   = 70;
				
				$mensagem = "====================================== <br/><br/>
							 Sua senha foi alterada recentemente.   <br/><br/>
		 					 ====================================== <br/><br/>
					 		-> Portal das F@bulas <-";
					
				$phpmail->Subject = utf8_decode('Senha alterada');
				$phpmail->Body    = utf8_decode($mensagem);
				
				// Mesma mensagem sem tag HTML
				$phpmail->AltBody = 'Ative sua conta';
				
				//
				$phpmail->MsgHTML($mensagem);
				
				// Envia o e-mail
				$email_enviado    = $phpmail->Send();
				
				if ($email_enviado){
				
?>

					<script type="text/javascript">
						alert("Senha alterada com sucesso.");
						document.location.href= "principal.php";
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

?>