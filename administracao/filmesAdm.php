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
	<title>Cadastro de Filmes - Administração</title>
	
</head>
<body class="administracao">

	<!-- MENU SUPERIOR --------------------->

	<?php include_once "menuSuperior.html";	?>

	<!-- FIM DO MENU SUPERIOR --------------------->


	<!-- PRINCIPAL --------------------->
		
		<main class="container">
			<h1 class="text-center">FILMES - Administração</h1><br>
			<div class="row">
				<div class="col-md-3 col-sm-2">
					<?php include_once "menuAdm.html" ?>
				</div>
				<div class="col-md-8 col-sm-8">
					
				</div>
			</div>



			
			
		</main>
	<!-- FIM DO PRINCIPAL --------------------->

	<?php if(isset($con)){ mysqli_close($con); } ?>
</body>
<?php
	}else{ ?>
		<meta http-equiv="refresh" content=0;url="administracao/login.php">
	<?php
	}
?>
</html>