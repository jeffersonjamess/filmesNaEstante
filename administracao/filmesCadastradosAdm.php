<!DOCTYPE html>
<html>
<?php
if (!isset($_SESSION)) {
	session_start();
}
	if ($_SESSION['acesso']==true) {
?>
<head>
	<?php
		include_once "header.html";
		include_once "../mais/conexao.php";
	?>

	<title>Filmes Cadastrados - Filmes na Estante</title>
	
</head>
<body class="administracao">

	<!-- MENU SUPERIOR --------------------->

	<?php include_once "menuSuperior.html";	?>

	<!-- FIM DO MENU SUPERIOR --------------------->


	<!-- PRINCIPAL --------------------->
		
		<main class="container">
			<h1 class="text-center">FILMES CADASTRADOS - Administração</h1><br>
			<div class="row">
				<div class="col-md-3 col-sm-3">
					<?php include_once "menuAdm.html" ?>
				</div>
			</div>



			
			
		</main>
	<!-- FIM DO PRINCIPAL --------------------->

	<?php if(isset($con)){ mysqli_close($con); } ?>
</body>
<?php
	}else{ ?>
		<meta http-equiv="refresh" content=0;url="login.php">
	<?php
	}
?>
</html>