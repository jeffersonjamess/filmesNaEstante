<?php
// CONEXÃO COM O BANCO DE DADOS FILMES NA ESTANTE
$host = "localhost";
$user = "root";
$pass = "";
$base = "dbfilmes";

// FAZENDO A CONEXÃO COM O BANCO DE DADOS
$con = mysqli_connect($host, $user, $pass);
$banco = mysqli_select_db($con, $base);

// MENSAGEM DE FALHA DE CONEXÃO
if(mysqli_connect_errno()){
	die("Falha de conexão com o banco de dados: ".
		mysqli_connect_error() . " ( " . mysqli_connect_errno() . " )"
	);
}

// CONFIGURAÇÃO DE CARACTERES
mysqli_query($con, "SET NAMES 'uft8'");
mysqli_query($con, "SET character_set_connection=uft8");
mysqli_query($con, "SET character_set_client=uft8");
mysqli_query($con, "SET character_set_result=uft8");
?>