<?php

	require_once 'CRUD.php';

	class Usuarios extends Crud {

		private $nome;
		private $email;
		private $senha;
		private $cpf;
		private $data_nascimento;
		private $celular;
		private $status;

		private $foto='padrao.jpg'; 

		public function setNome($nome){
			$this->nome = $nome;
		}

		public function getNome(){
			return $this->nome;
		}

		public function setEmail($email){
			$this->email = $email;
		}

		public function getEmail(){
			return $this->email;
		}

		public function setSenha($senha){
			$this->senha = $senha;
		}

		public function getSenha(){
			return $this->senha;
		}

		public function setCpf($cpf){
			$this->cpf = $cpf;
		}

		public function getCpf(){
			return $this->cpf;
		}

		public function setDataNascimento($data_nascimento){
			$this->data_nascimento = $data_nascimento;
		}

		public function getDataNascimento(){
			return $this->data_nascimento;
		}

		public function setCelular($celular){
			$this->celular = $celular;
		}

		public function getCelular(){
			return $this->celular;
		}

		public function setStatus($status){
			$this->status = $status;
		}

		public function getStatus(){
			return $this->status;
		}

	}

?>