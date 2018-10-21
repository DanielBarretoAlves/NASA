function olhoMagico(){
	
	var senha = $('#senhaL');
	var olho= $("#olho");

	olho.mousedown(function() {
	  senha.attr("type", "text");
	});

	olho.mouseup(function() {
	  senha.attr("type", "password");
	});
	
	// para evitar o problema de arrastar a imagem e a senha continuar exposta, 
	//citada pelo nosso amigo nos comentários
	$( "#olho" ).mouseout(function() { 
	  $("#senhaL").attr("type", "password");
	});
	
}

function salvarAutomatico(id,nomeFabulajs,textoFabulajs,moralFabulajs,acaojs){
	
	if (id != '' && nomeFabulajs != '' && textoFabulajs != '' && moralFabulajs != ''){
		
		if (acaojs == 'c'){
			
			$.ajax({
				type:"POST",
				url:"cadastrarfabula.php",
				data:'acao=cadFabula&idUsuario='+id+'&nomeFabula='+nomeFabulajs+'&textoFabula='+textoFabulajs+'&moralFabula='+moralFabulajs,
				success: function(result){                 // O retorno é um json
					$("#div2").html("<div class='alert alert-success' role='alert'>Fabula cadastrada!</div>" +
							        "<meta http-equiv=refresh content=2;URL=minhasfabulas.php>");
				},
				error: function (result) {
					$("#div2").html("<div class='alert alert-danger' role='alert'>Erro ao gravar a fabula.</div>" +
							        "<meta http-equiv=refresh content=2;URL=minhasfabulas.php>");
				}
			});
		
		}else{
			if (acaojs == 'v'){
				
				$.ajax({
					type:"POST",
					url:"visualizarfabula.php",
					data:'acao=visFabula&idFabula='+id+'&nomeFabula='+nomeFabulajs+'&textoFabula='+textoFabulajs+'&moralFabula='+moralFabulajs,
					success: function(result){                 // O retorno é um json
						$("#div2").html("<div class='alert alert-success' role='alert'>Fabula alterada!</div>" +
								        "<meta http-equiv=refresh content=2;URL=minhasfabulas.php>");
					},
					error: function (result) {
						$("#div2").html("<div class='alert alert-danger' role='alert'>Erro ao alterar a fabula.</div>" +
								        "<meta http-equiv=refresh content=2;URL=minhasfabulas.php>");
					}
				});
			}
		}
	}else{
		$("#div2").html("<div class='alert alert-danger' role='alert'>.: Preencha todos os campos :. <br/> Por último, após preencher o campo 'Moral da Fábula', <br/> pressione a tecla TAB </div>" +
        "<meta http-equiv=refresh content=1;URL=minhasfabulas.php");
	}
	
}

function verificarSenha(){

	var senha1 = document.getElementById("senha1").value;
	var senha2 = document.getElementById("senha2").value;
	
	if(senha1 == senha2 && senha1.length > 5 && senha1.length < 12 && senha2.length > 5 && senha1.length < 12){
		document.getElementById("resultado").innerHTML = "&raquo; As senhas são iguais.";
		document.getElementById("resultado").style.color = "#008B45";
		$("#submit").attr("disabled", false);
	}else{
		document.getElementById("resultado").innerHTML = "As senhas não correspondem e devem ter entre 8 e 12 caracteres.";
		document.getElementById("resultado").style.color = "#FF6347";
		$("#submit").attr("disabled", true);
	}
	
}

function validarEmail(emailUsuariojs){
	
	var filter = /^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/i;
	
	if(!filter.test(emailUsuariojs))
		return false;
	else
		return true;
	
}

function recuperarSenha(emailUsuariojs){
	
	if (emailUsuariojs != 'E-mail'){
		
		if (validarEmail(emailUsuariojs)){
			
			$.ajax({
				type:"POST",
				url:"recuperarSenha.php",
				data:'emailDestinatario='+emailUsuariojs,
				success: function(result){                 // O retorno é um json
					$("#div1").html("<div style='color: yellow;'>Verifique sua caixa de entrada ...</div><meta http-equiv=refresh content=2;URL=index.php>");
				},
				error: function (result) {
					$("#div1").html("<div style='color: red;'>Erro ao enviar e-mail ...</div><meta http-equiv=refresh content=2;URL=index.php>");
				}
			});
		
		}else{
			
			$("#div1").html("<div style='color: green;'>Digite um e-mail válido ...</div><meta http-equiv=refresh content=2;URL=index.php>");
			
		}
		
	}else{

		$("#div1").html("<div style='color: red;'>Esqueceu de nada não?</div><meta http-equiv=refresh content=2;URL=index.php>");
	
	}

}

function like(idUsuariojs,idFabulajs){
	
	$('.fd'+idFabulajs).removeClass('dislike-h');
	$('.fl'+idFabulajs).addClass('like-h');
	
	$.ajax({
		type:"POST",
		url:"ajax.php",
		data:'acao=like&idUsuario='+idUsuariojs+'&idFabula='+idFabulajs,
		success: function(){}
	});

}

function dislike(idUsuariojs,idFabulajs){		
		
	$('.fl'+idFabulajs).removeClass('like-h');
	$('.fd'+idFabulajs).addClass('dislike-h');
	
	$.ajax({
		type:"POST",
		url:"ajax.php",
		data:'acao=dislike&idUsuario='+idUsuariojs+'&idFabula='+idFabulajs,
		success: function(){}
	});
	
}

/* Função para exibir um alert confirmando a exclusão do registro*/
function confirmaExclusao(id){
	
	retorno = confirm("Deseja excluir essa fábula?")

	if (retorno){

	    //Cria um formulário
	    var formulario = document.createElement("form");
	    formulario.action = "minhasfabulas.php";
	    formulario.method = "post";

		// Cria os inputs e adiciona ao formulário
	    var inputAcao = document.createElement("input");
	    inputAcao.type = "hidden";
	    inputAcao.value = "excluir";
	    inputAcao.name = "acao";
	    formulario.appendChild(inputAcao); 

	    var inputId = document.createElement("input");
	    inputId.type = "hidden";
	    inputId.value = id;
	    inputId.name = "id";
	    formulario.appendChild(inputId);

	    //Adiciona o formulário ao corpo do documento
	    document.body.appendChild(formulario);

	    //Envia o formulário
	    formulario.submit();
	}
}

/* Função para exibir um alert confirmando a exclusão do registro*/
function cancelar(){
	window.location="principal.php";
}
