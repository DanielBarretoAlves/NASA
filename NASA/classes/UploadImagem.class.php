<?php

	class UploadImagem{
		
		// Definida no arquivo index.php, ser� a largura m�xima da nossa imagem
		private $width;
		
		// Definida no arquivo index.php, ser� a altura m�xima da nossa imagem
		private $height;
		
		//$extensoes_aceitas = array('bmp' ,'png', 'svg', 'jpeg', 'jpg');
		protected $tipos = array("jpeg", "jpg", "svg", "png", "gif");
		
		public function setarValoresWH($largura,$altura){
			
			$this->width  = $largura;
			$this->height = $altura;
			
		}
		
		// Nossos tipos de imagem dispon�veis para este exemplo
		// Fun��o que ir� redimensionar nossa imagem
		protected function redimensionar($caminho, $nomearquivo){
			// Determina as novas dimens�es
			$width = $this->width;
			$height = $this->height;
			
			// Pegamos a largura e altura originais, al�m do tipo de imagem
			list($width_orig, $height_orig, $tipo, $atributo) = getimagesize($caminho.$nomearquivo);
			
			// Se largura � maior que altura, dividimos a largura determinada pela original e multiplicamos a altura pelo resultado, para manter a propor��o da imagem
			if($width_orig > $height_orig){
				$height2 = ($width/$width_orig)*$height_orig;
				
				// Se altura � maior que largura, dividimos a altura determinada pela original e multiplicamos a largura pelo resultado, para manter a propor��o da imagem
			}elseif($width_orig < $height_orig){
			
				$width = ($height/$height_orig)*$width_orig;
			
			} // -> fim if
			
			// Criando a imagem com o novo tamanho
			$novaimagem = imagecreatetruecolor($width, $height);  
																		
			switch($tipo){

				// Se o tipo da imagem for gif
				case 1:
					// Obt�m a imagem gif original
					$origem = imagecreatefromgif($caminho.$nomearquivo);
					
					// Copia a imagem original para a imagem com novo tamanho
					imagecopyresampled($novaimagem, $origem, 0, 0, 0, 0, $width, $height, $width_orig, $height_orig);
					
					// Envia a nova imagem gif para o lugar da antiga
					imagegif($novaimagem, $caminho.$nomearquivo);
					break;
					
				// Se o tipo da imagem for jpg
				case 2:
					
					// Obt�m a imagem jpg original
					$origem = imagecreatefromjpeg($caminho.$nomearquivo);
					
					// Copia a imagem original para a imagem com novo tamanho
					imagecopyresampled($novaimagem, $origem, 0, 0, 0, 0, $width, $height, $width_orig, $height_orig);
					
					// Envia a nova imagem jpg para o lugar da antiga
					imagejpeg($novaimagem, $caminho.$nomearquivo);
					break;
				
				// Se o tipo da imagem for png
				case 3:
					
					// Obt�m a imagem png original
					$origem = imagecreatefrompng($caminho.$nomearquivo);
					
					// Copia a imagem original para a imagem com novo tamanho
					imagecopyresampled($novaimagem, $origem, 0, 0, 0, 0, $width, $height, $width_orig, $height_orig);
					
					// Envia a nova imagem png para o lugar da antiga
					imagepng($novaimagem, $caminho.$nomearquivo);
					break;
			} // -> fim switch
			
			// Destr�i a imagem nova criada e j� salva no lugar da original
			imagedestroy($novaimagem);
			
			// Destr�i a c�pia de nossa imagem original
			imagedestroy($origem);
		} // -> fim function redimensionar()
			
		protected function tirarAcento($texto){
			
			// array com letras acentuadas
			$com_acento = array('�','�','�','�','�','�','�','�','�','�','�','�','�','�','�','�','�','�','�','�','�','�','�','�','�','�','�','�','�','�','�','�','�','�','�','�','�','�','�','�','�','�','�','�','�','�','O','�','�','�','�',);
			
			// array com letras correspondentes ao array anterior, por�m sem acento
			$sem_acento = array('a','a','a','a','a','a','c','e','e','e','e','i','i','i','i','n','o','o','o','o','o','u','u','u','y','A','A','A','A','A','A','C','E','E','E','E','I','I','I','I','N','O','O','O','O','O','0','U','U','U','Y',);
			
			// procuramos no nosso texto qualquer caractere do primeiro array e substitu�mos pelo seu correspondente presente no 2� array
			$final = str_replace($com_acento, $sem_acento, $texto);
			
			// array com pontua��o e acentos
			$com_pontuacao = array('�','`','�','^','~',' ','-');
			
			// array com substitutos para o array anterior
			$sem_pontuacao = array('','','','','','_','_');
			
			// procuramos no nosso texto qualquer caractere do primeiro array e substitu�mos pelo seu correspondente presente no 2� array
			$final = str_replace($com_pontuacao, $sem_pontuacao, $final);
			
			// retornamos a vari�vel com nosso texto sem pontua��es, acentos e letras acentuadas
			return $final;
		
		} // -> fim function tirarAcento()
		
		// Fun��o que ir� fazer o upload da imagem
		public function salvar($caminho, $file){
			
			// Retiramos acentos, espa�os e h�fens do nome da imagem
			$file['name'] = $this->tirarAcento(($file['name']));
			
			// Atribu�mos caminho e nome da imagem a uma vari�vel apenas
			$uploadfile = $caminho.$file['name'];
			
			// Guardamos na vari�vel tipo o formato do arquivo enviado
			$tipo = strtolower(end(explode('/', $file['type'])));
			
			// Verifica se a imagem enviada � do tipo jpeg, png ou gif
			if (array_search($tipo, $this->tipos) === false) {
				$mensagem = "<font color='#F00'>Envie apenas imagens no formato jpeg, png ou gif!</font>";
				return $mensagem;
			}
			
			// Se a imagem tempor�ria n�o for movida para onde a vari�vel com caminho e nome indica, exibiremos uma mensagem de erro
			else if (!move_uploaded_file($file['tmp_name'], $uploadfile)){
				
				switch($file['error']){
					case 1:
						$mensagem = "<font color='#F00'>O tamanho do arquivo � maior que o tamanho permitido.</font>";
						break;
					
					case 2:
						$mensagem = "<font color='#F00'>O tamanho do arquivo � maior que o tamanho permitido.</font>";
						break;
					
					case 3:
						$mensagem = "<font color='#F00'>O upload do arquivo foi feito parcialmente.</font>";
					
					case 4:
						$mensagem = "<font color='#F00'>N�o foi feito o upload de arquivo.</font>";
						break;
				} // -> fim switch
				
				// Se a imagem tempor�ria for movida
			} /* -> fim if */
			else{
				
				// Pegamos sua largura e altura originais
				list($width_orig, $height_orig) = getimagesize($uploadfile);
				
				//Comparamos sua largura e altura originais com as desejadas
				if($width_orig > $this->width || $height_orig > $this->height){
					
					// Chamamos a fun��o que redimensiona a imagem
					$this->redimensionar($caminho, $file['name']);
				} // -> fim if
				
				// Exibiremos uma mensagem de sucesso
				$mensagem = "<a href='".$uploadfile."'><font color='#070'>Upload realizado com sucesso!</font><a>";
			
			} // -> fim else
			
			// Retornamos a mensagem com o erro ou sucesso
			return $mensagem;
						
		} // -> fim function salvar()
			
	} // -> fim classe 
	
?>