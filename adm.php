<!DOCTYPE html>
<html>
<?php
	if (!isset($_SESSION)) {
		session_start();
	}
	if ($_SESSION['acesso'] == true) {
?>
<head>
	<?php
		include_once "header.html";
	?>

	<title>Home</title>
	
</head>
<body class="administracao">

	<!-- MENU SUPERIOR --------------------->

	<?php include_once "menuSuperior.html";	?>

	<!-- FIM DO MENU SUPERIOR --------------------->


	<!-- PRINCIPAL --------------------->
		
		<main class="container">
			<h1 class="text-center">Administração</h1><br>
			<div class="row text-center">

				<div class="col-md-3 col-sm-4 col-6 opcoes">
					<a href="administracao/filmesAdm.php">
						<i class="fas fa-film"></i>
						<p>Cadastrar Novo Filme</p>
					</a>
				</div>

				<div class="col-md-3 col-sm-4 col-6 opcoes">
					<a href="administracao/filmesCadastradosAdm.php">
						<i class="fas fa-file-video"></i>
						<p>Filmes Cadastrados</p>
					</a>
				</div>

				<div class="col-md-3 col-sm-4 col-6 opcoes">
					<a href="administracao/diretoresAdm.php">
						<i class="fas fa-bullhorn"></i>
						<p>Diretores</p>
					</a>
				</div>

				<div class="col-md-3 col-sm-4 col-6 opcoes">
					<a href="administracao/atoresAdm.php">
						<i class="fas fa-theater-masks"></i>
						<p>Atores</p>
					</a>
				</div>

				<div class="col-md-3 col-sm-4 col-6 opcoes">
					<a href="administracao/categoriasAdm.php">
						<i class="fas fa-stream"></i>
						<p>Categorias</p>
					</a>
				</div>

				<div class="col-md-3 col-sm-4 col-6 opcoes">
					<a href="administracao/bannerAdm.php">
						<i class="fab fa-microsoft"></i>
						<p>Banner Principal</p>
					</a>
				</div>

				<div class="col-md-3 col-sm-4 col-6 opcoes">
					<a href="administracao/paisesAdm.php">
						<i class="far fa-flag"></i>
						<p>Países</p>
					</a>
				</div>

				<div class="col-md-3 col-sm-4 col-6 opcoes">
					<a href="administracao/usuariosAdm.php">
						<i class="fas fa-users"></i>
						<p>Usuários</p>
					</a>
				</div>

				<div class="col-md-3 col-sm-4 col-6 opcoes">
					<a href="administracao/minhaConta.php">
						<i class="fas fa-user-cog"></i>
						<p>Minha Conta</p>
					</a>
				</div>

				<div class="col-md-3 col-sm-4 col-6 opcoes">
					<a href="administracao/logoff.php" class="stretched-link">
						<i class="fas fa-sign-out-alt"></i>
						<p>Sair</p>
					</a>
				</div>				


			</div>



			
			
		</main>
	<!-- FIM DO PRINCIPAL --------------------->
</body>
<?php
	}else{
		?>
		<meta http-equiv="refresh" content=0;url="administracao/login.php">
		<?php
	}
?>
</html>