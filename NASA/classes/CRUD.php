<?php

	require_once 'DB.php';
	
	header('Content-Type: text/html; charset=utf-8');
	
	class Crud extends DB {

		protected $tabelaUsuario = 'users';
		protected $tabelaPosts  = 'posts';
		protected $tabelaComents  = 'comentarios';
		protected $tabelaReact   = 'reacoes';
		protected $tabelaLocal   = 'localizacoes';
		protected $tabelaResp   = 'respostas';

		//abstract public function insert();
		//abstract public function update($id);

		public function find($id){
			$sql  = "SELECT * FROM $this->tabelaUsuario WHERE id = :id";
			$stmt = DB::prepare($sql);
			$stmt->bindParam(':id', $id, PDO::PARAM_INT);
			$stmt->execute();
			return $stmt->fetch();
		}
	
		public function findAll(){
			$sql  = "SELECT * FROM $this->tabelaUsuario ";
			$stmt = DB::prepare($sql);
			$stmt->execute();
			return $stmt->fetchAll();
		}
		
		public function resgatarIdLike($idUsuario,$idFabula){
			
			$sql  = "SELECT idLike FROM $this->tabelaLikes WHERE idUsuario = :idUsuario AND idFabula = :idFabula";
			$stmt = DB::prepare($sql);
			$stmt->bindParam(':idUsuario', $idUsuario);
			$stmt->bindParam(':idFabula', $idFabula);
			$stmt->execute();
			return $stmt->fetchAll();
		}
		
		public function resgatarRateCrescente($idFabula){
				
			$sql  = "SELECT idLike FROM $this->tabelaLikes WHERE idUsuario = :idUsuario AND idFabula = :idFabula";
			$stmt = DB::prepare($sql);
			$stmt->bindParam(':idUsuario', $idUsuario);
			$stmt->bindParam(':idFabula', $idFabula);
			$stmt->execute();
			return $stmt->fetchAll();
			
		}
		
		public function pegaQtdLikes($idFabula){
			
			$sql  = "SELECT * FROM $this->tabelaLikes WHERE idFabula = :idFabula AND rate = 1";
			$stmt = DB::prepare($sql);
			$stmt->bindParam(':idFabula', $idFabula);
			$stmt->execute();
			return $stmt->fetchAll();
			
		}
		
		public function pegaQtdDislikes($idFabula){
			
			$sql  = "SELECT * FROM $this->tabelaLikes WHERE idFabula = :idFabula AND rate = 2";
			$stmt = DB::prepare($sql);
			$stmt->bindParam(':idFabula', $idFabula);
			$stmt->execute();
			return $stmt->fetchAll();
				
		}
		
		public function atualizarQtdLikes($idFabula,$qtdLikes){
		
			$sql  = "UPDATE $this->tabelaFabula SET qtdLike = $qtdLikes WHERE idFabula = :idFabula";
			$stmt = DB::prepare($sql);
			$stmt->bindParam(':idFabula', $idFabula);
			return $stmt->execute();
		
		}
		
		public function atualizarQtdDislikes($idFabula,$qtdDislikes){
			
			$sql  = "UPDATE $this->tabelaFabula SET qtdDislike = $qtdDislikes WHERE idFabula = :idFabula";
			$stmt = DB::prepare($sql);
			$stmt->bindParam(':idFabula', $idFabula);
			return $stmt->execute();
		
		}
		
		public function atualizaRanking($idFabula,$ranking){

			$sql  = "UPDATE $this->tabelaFabula SET ranking = $ranking WHERE idFabula = :idFabula";
			$stmt = DB::prepare($sql);
			$stmt->bindParam(':idFabula', $idFabula);
			return $stmt->execute();
			
		}
		
		public function inserirRate	($idUsuario,$idFabula,$rate){
		
			$sql  = "INSERT INTO $this->tabelaLikes (idUsuario, idFabula, rate) VALUES (:idUsuario, :idFabula, :rate)";
			$stmt = DB::prepare($sql);
			$stmt->bindParam(':idUsuario', $idUsuario);
			$stmt->bindParam(':idFabula', $idFabula);
			$stmt->bindParam(':rate', $rate);
			return $stmt->execute();
		
		}
		
		public function atualizarRate($idUsuario,$idFabula,$rate){
			
				$sql  = "UPDATE $this->tabelaLikes SET rate = :rate WHERE idUsuario = :idUsuario AND idFabula = :idFabula";
				$stmt = DB::prepare($sql);
				$stmt->bindParam(':idUsuario', $idUsuario);
				$stmt->bindParam(':idFabula', $idFabula);
				$stmt->bindParam(':rate', $rate);
				return $stmt->execute();
		}
		
		/*public function selecionarLikes($idUsuario,$idFabula,$rate){
			
			$sql  = "SELECT likes FROM $this->tabelaFabula WHERE idFabula = :idFabula";
			$stmt = DB::prepare($sql);
			$stmt->bindParam(':idFabula', $idFabula);
			$stmt->execute();
			return $stmt->fetchAll();

		}*/
		
		public function selecionarRate($idUsuario,$idFabula,$rate){
		
			$sql  = "SELECT * FROM $this->tabelaLikes WHERE idUsuario = :idUsuario AND idFabula = :idFabula AND rate = :rate";
			$stmt = DB::prepare($sql);
			$stmt->bindParam(':idUsuario', $idUsuario);
			$stmt->bindParam(':idFabula', $idFabula);
			$stmt->bindParam(':rate', $rate);
			$stmt->execute();
			return $stmt->fetchAll();
		
		}
		
		public function delete($id){
			$sql  = "DELETE FROM $this->tabelaUsuario WHERE id = :id";
			$stmt = DB::prepare($sql);
			$stmt->bindParam(':id', $id, PDO::PARAM_INT);
			return $stmt->execute(); 
		}
		
		public function deletarLike($idFabula){
			
			$sql  = "SELECT * FROM $this->tabelaLikes WHERE idFabula = :idFabula";
			$stmt = DB::prepare($sql);
			$stmt->bindValue(':idFabula', $idFabula);
			$stmt->execute();
			
			$qtdRegistros = $stmt->rowCount();
			
			if ($qtdRegistros > 0){
			
				$resultado = $stmt->fetchAll(PDO::FETCH_ASSOC);
				
				$i = 0;
				
				// Excluindo os registros com IDs iguais 
				while($qtdRegistros > 0){
				
					$sql  = "DELETE FROM $this->tabelaLikes WHERE idLike = :idLike";
					$stmt = DB::prepare($sql);
					$stmt->bindValue(':idLike', $resultado[$i]['idLike']);
					$stmt->execute();
					
					--$qtdRegistros;
					$i++;
				
				}
				
				return true;
			
			}else{
				
				return false;
				
			}

		}
		
		public function deletarFabula($idFabula){
			$sql  = "DELETE FROM $this->tabelaFabula WHERE idFabula = :idFabula";
			$stmt = DB::prepare($sql);
			$stmt->bindValue(':idFabula', $idFabula);
			return $stmt->execute();
		}
		
		public function select($email,$senha){

			// Montando a consulta
			$sql  = "SELECT * FROM $this->tabelaUsuario WHERE email=? AND senha=?";

			// Preparando statement
			$stmt = DB::prepare($sql);
			$stmt->bindparam(1, $email, PDO::PARAM_STR);
			$stmt->bindparam(2, $senha, PDO::PARAM_STR);

			// Executando statement
			$stmt->execute();

			// Obter linha consultada
			$obj = $stmt->fetchObject();
			return $obj;
		}

		public function testar(){
		
			// Montando a consulta
			$sql  = "SELECT * FROM $this->tabelaUsuario WHERE email=? AND senha=?";
		
			// Preparando statement
			$stmt = DB::prepare($sql);
			$stmt->bindparam(1, $email, PDO::PARAM_STR);
			$stmt->bindparam(2, $senha, PDO::PARAM_STR);
		
			// Executando statement
			$stmt->execute();
		
			// Obter linha consultada
			$obj = $stmt->fetchObject();
			return $obj;
		}
		
		
		public function selectEditar($idUsuario){
			
			$sql  = "SELECT * FROM $this->tabelaUsuario WHERE idUsuario = :idUsuario";
			$stmt = DB::prepare($sql);
			$stmt->bindParam(':idUsuario', $idUsuario, PDO::PARAM_INT);
			$stmt->execute();
			return $stmt->fetch();
			
		}

		public function resgatarTudo($email){
			
			$sql  = "SELECT idUsuario, nome, email, celular, status, foto FROM $this->tabelaUsuario";
			$stmt = DB::prepare($sql);
			$stmt->execute();
			return $stmt->fetchAll();

		}
		
		public function resgatarNomeR($email){
				
			$sql  = "SELECT nome FROM $this->tabelaUsuario WHERE email= :email";
			$stmt = DB::prepare($sql);
			$stmt->bindParam(':email', $email);
			$stmt->execute();
			return $stmt->fetchAll();
		
		}
		
		public function resgatarTudoUsuario($idUsuario){
				
			$sql  = "SELECT * FROM $this->tabelaUsuario WHERE idUsuario = :idUsuario";
			$stmt = DB::prepare($sql);
			$stmt->bindParam(':idUsuario', $idUsuario);
			$stmt->execute();
			return $stmt->fetchAll();
		
		}
		
		public function resgatarIdUsuario($idFabula){

			$sql  = "SELECT * FROM $this->tabelaFabula WHERE idFabula = :idFabula";
			$stmt = DB::prepare($sql);
			$stmt->bindParam(':idFabula', $idFabula, PDO::PARAM_INT);
			$stmt->execute();
			return $stmt->fetchAll(); 

		}
		
		public function resgatarNomeUsuario($idUsuario){
				
			$sql  = "SELECT nome FROM $this->tabelaUsuario WHERE idUsuario = :idUsuario";
			$stmt = DB::prepare($sql);
			$stmt->bindParam(':idUsuario', $idUsuario, PDO::PARAM_INT);
			$stmt->execute();
			return $stmt->fetchAll();
		
		}
		
		public function verificarEmail($email){
				
			$sql  = "SELECT * FROM $this->tabelaUsuario WHERE email = :email";
			$stmt = DB::prepare($sql);
			$stmt->bindParam(':email', $email);
			$stmt->execute();
			return $stmt->fetch();
				
		}
		
		public function verificarLogin($email,$senha){
			
			$sql  = "SELECT * FROM $this->tabelaUsuario WHERE email = :email AND senha = :senha";
			
			$stmt = DB::prepare($sql);
			$stmt->bindParam(':email', $email);
			$stmt->bindParam(':senha', $senha);
			return $stmt->execute();
			
			//return $stmt->fetch();
			
		}
		
		public function resgatarDadosUsuario($email){
		
			$sql  = "SELECT * FROM $this->tabelaUsuario WHERE email = :email";
			$stmt = DB::prepare($sql);
			$stmt->bindParam(':email', $email);
			$stmt->execute();
			return $stmt->fetch();
			
		}
		
		public function resgatarID($email){
				
			$sql  = "SELECT * FROM $this->tabelaUsuario WHERE email = :email";
			$stmt = DB::prepare($sql);
			$stmt->bindParam(':email', $email, PDO::PARAM_INT);
			$stmt->execute();
			return $stmt->fetchAll();
		
		}
		
		public function alterarSenha($idUsuario,$novaSenha){
		
			$sql  = "UPDATE $this->tabelaUsuario SET senha = :novaSenha WHERE idUsuario = :idUsuario";
			$stmt = DB::prepare($sql);
			$stmt->bindParam(':idUsuario', $idUsuario);
			$stmt->bindParam(':novaSenha', $novaSenha);
			return $stmt->execute();
		
		}
		
		public function redefinirSenhaUsuario($idUsuario,$novaSenha){
			
			$sql  = "UPDATE $this->tabelaUsuario SET senha = :novaSenha WHERE idUsuario = :idUsuario";
			$stmt = DB::prepare($sql);
			$stmt->bindParam(':idUsuario', $idUsuario);
			$stmt->bindParam(':novaSenha', $novaSenha);
			return $stmt->execute();
			
		}
		
		public function resgatarFabulas($idUsuario){
			
			$sql = "SELECT * FROM $this->tabelaFabula WHERE idUsuario = :idUsuario";
			$stmt = DB::prepare($sql);
			$stmt->bindParam(':idUsuario', $idUsuario, PDO::PARAM_INT);
			$stmt->execute();
			return $stmt->fetchAll();
		
		}
		
		public function resgatarFabulaEspecifica($idFabula){
				
			$sql = "SELECT nomeFabula FROM $this->tabelaFabula WHERE idFabula = :idFabula";
			$stmt = DB::prepare($sql);
			$stmt->bindParam(':idFabula', $idFabula, PDO::PARAM_INT);
			return $stmt->execute();
		}
		
		public function resgatarFE($idFabula){
		
			$sql = "SELECT * FROM $this->tabelaFabula WHERE idFabula = :idFabula";
			$stmt = DB::prepare($sql);
			$stmt->bindParam(':idFabula', $idFabula, PDO::PARAM_INT);
			$stmt->execute();
			return $stmt->fetchAll();
		
		}
		
		public function resgatarTodasFabulas(){
				
			$sql = "SELECT * FROM $this->tabelaFabula";
			$stmt = DB::prepare($sql);
			$stmt->execute();
			return $stmt->fetchAll();
		
		}
		
		public function resgatarTodasFabulasRanking(){
		
			$sql = "SELECT * FROM $this->tabelaFabula ORDER BY ranking DESC";
			$stmt = DB::prepare($sql);
			$stmt->execute();
			return $stmt->fetchAll();
		
		}

		/*public function resgatarParte($email,$termo){
			
			$sql  = "SELECT id, nome, email, celular, status, foto FROM $this->table WHERE email LIKE :email";
			$stmt = DB::prepare($sql);
			$stmt->bindValue(':email', $termo.'%');
			$stmt->execute();
			return $stmt->fetchAll(PDO::FETCH_OBJ);

		}*/
		
		public function resgatarParteMF($termo){
				
			$sql  = "SELECT * FROM $this->tabelaFabula WHERE nomeFabula LIKE :nomeFabula";
			$stmt = DB::prepare($sql);
			$stmt->bindValue(':nomeFabula', '%'.$termo.'%');
			$stmt->execute();
			return $stmt->fetchAll();
			
		}
		
		public function resgatarParteMF2016($idUsuario,$termo){
		
			$sql  = "SELECT * FROM $this->tabelaFabula WHERE idUsuario = :idUsuario AND nomeFabula LIKE :nomeFabula";
			$stmt = DB::prepare($sql);
			$stmt->bindParam(':idUsuario', $idUsuario);
			$stmt->bindValue(':nomeFabula', '%'.$termo.'%');
			$stmt->execute();
			return $stmt->fetchAll();
		
		}
		
		public function resgatarParteFR($termo){
		
			$sql  = "SELECT * FROM $this->tabelaFabula WHERE nomeFabula LIKE :nomeFabula";
			$stmt = DB::prepare($sql);
			$stmt->bindValue(':nomeFabula', '%'.$termo.'%');
			$stmt->execute();
			return $stmt->fetchAll();
		
		}
		
		public function resgatarParteMF2017($idUsuario,$termo){
		
			$sql  = "SELECT * FROM $this->tabelaFabula WHERE idUsuario = :idUsuario AND nomeFabula LIKE :nomeFabula";
			$stmt = DB::prepare($sql);
			$stmt->bindParam(':idUsuario', $idUsuario);
			$stmt->bindValue(':nomeFabula', '%'.$termo.'%');
			$stmt->execute();
			return $stmt->fetchAll();
		
		}
		
		public function resgatarParteMF2($idUsuario,$termo){
		
			$sql  = "SELECT * FROM $this->tabelaFabula WHERE idUsuario = :idUsuario AND nomeFabula LIKE :nomeFabula";
			$stmt = DB::prepare($sql);
			$stmt->bindParam(':idUsuario', $idUsuario);
			$stmt->bindValue(':nomeFabula', '%'.$termo.'%');
			$stmt->execute();
			return $stmt->fetchAll();
				
		}

		public function insert($email,$senha,$status,$foto){

			$sql  = "INSERT INTO $this->tabelaUsuario (email, senha, status, foto) VALUES (:email, :senha, :status, :foto)";
			$stmt = DB::prepare($sql);
			$stmt->bindParam(':email', $email);
			$stmt->bindParam(':senha', $senha);
			$stmt->bindParam(':status', $status);
			$stmt->bindParam(':foto',  $foto);
			return $stmt->execute(); 

		}
		
		public function insertFabula($idUsuario,$nomeFabula,$textoFabula,$moralFabula){
		
			$sql  = "INSERT INTO $this->tabelaFabula (nomeFabula, textoFabula, moralFabula, idUsuario) VALUES (:nomeFabula, :textoFabula, :moralFabula, :idUsuario)";
			$stmt = DB::prepare($sql);
			$stmt->bindParam(':nomeFabula', $nomeFabula);
			$stmt->bindParam(':textoFabula', $textoFabula);
			$stmt->bindParam(':moralFabula', $moralFabula);
			$stmt->bindParam(':idUsuario', $idUsuario);
			return $stmt->execute();
		
		}
		
		public function atualizaStatus($idUsuario){
		
			$sql  = "UPDATE $this->tabelaUsuario SET status = 1 WHERE idUsuario = :idUsuario";
			$stmt = DB::prepare($sql);
			$stmt->bindParam(':idUsuario', $idUsuario);
			return $stmt->execute();
			
		}
		
		public function atualizaFabula($idFabula,$nomeFabula,$textoFabula,$moralFabula){
		
			$sql  = "UPDATE $this->tabelaFabula SET nomeFabula = :nomeFabula, textoFabula = :textoFabula, moralFabula = :moralFabula WHERE idFabula = :idFabula";
			$stmt = DB::prepare($sql);
			$stmt->bindParam(':idFabula', $idFabula);
			$stmt->bindParam(':nomeFabula', $nomeFabula);
			$stmt->bindParam(':textoFabula', $textoFabula);
			$stmt->bindParam(':moralFabula', $moralFabula);
			return $stmt->execute();
		
		}
		
		public function update($id){

			$sql  = "UPDATE $this->tabelaUsuario SET email = :email, senha = :senha WHERE id = :id";
			$stmt = DB::prepare($sql);
			$stmt->bindParam(':email', $this->email);
			$stmt->bindParam(':senha', $this->senha);
			$stmt->bindParam(':id', $id);
			return $stmt->execute();

		}

		public function updatePerfil($idUsuario,$nome,$email,$sexo,$data_nascimento,$escolaridade,$escola,$tipo_escola,$celular,$foto){

			$sql  = "UPDATE $this->tabelaUsuario SET nome=:nome, email=:email, sexo=:sexo, data_nascimento=:data_nascimento, escolaridade=:escolaridade, escola=:escola, tipo_escola=:tipo_escola, celular=:celular, foto=:foto WHERE idUsuario=:idUsuario";

			$stmt = DB::prepare($sql);
			
			$stmt->bindValue(':nome', $nome);
			$stmt->bindValue(':email', $email);

			return $stmt->execute(); 

		}

		public function deletarID($id) {

			$sql  = "DELETE FROM $this->tabelaUsuario WHERE id = :id";
			$stmt = DB::prepare($sql);
			$stmt->bindValue(':id', $id);
			//$stmt->bindParam(':id', $id, PDO::PARAM_INT);
			return $stmt->execute();

		}

	}

?>