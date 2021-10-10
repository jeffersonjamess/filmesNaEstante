<?php
	include_once "../complementos/conexao.php";

	if (!isset($_SESSION)) {
		session_start();
	}

	unset($_SESSION['acesso']);
	unset($_SESSION['editaEstudante']);
	unset($_SESSION['editaCurso']);
	session_destroy();	
?>
<html>
	<br><br>
	<center><h2>Fazedo Logoff!</h2></center>
	<meta http-equiv="refresh" content=2;url="../index.php">
</html>