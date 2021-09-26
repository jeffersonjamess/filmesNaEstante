<?php
// CONEXÃO COM O BANCO DE DADOS
abstract class Conexao{
	protected function conectarBD(){
		try{
			return $con = new PDO("mysql:host=localhost;dbname=ra201366435","root","");
		}catch(PDOException $e){
			return $e->getMessage();
		}
	}
}
?>