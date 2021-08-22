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
		include_once "../mais/funcoes.php";
	?>
	<title>Cadastro de Atores - Administração Filmes na Estante</title>
	<script type="text/javascript">
		function validaCampos(){
			if (document.fmAtores.txtNome.value == "") {
				alert("Por favor, preencha um nome!");
				document.fmAtores.txtNome.focus();
				return false;
			}
			if (document.fmAtores.txtBiografia.value == "") {
				alert("Por favor, preencha uma Biografia!");
				document.fmAtores.txtBiografia.focus();
				return false;
			}
			if (document.fmAtores.selPais.value == 0) {
				alert("Por favor, escolha um país!");
				document.fmAtores.selPais.focus();
				return false;
			}
		}
	</script>
</head>
<body class="administracao">

	<!-- MENU SUPERIOR --------------------->

	<?php include_once "menuSuperior.html";	?>

	<!-- FIM DO MENU SUPERIOR --------------------->


	<!-- PRINCIPAL --------------------->
		
		<main class="container">
			<h1 class="text-center">ATORES/ATRIZES - Administração</h1><br>
			<div class="row">
				<div class="col-md-3 col-sm-3">
					<?php include_once "menuAdm.html" ?>
				</div>
				<div class="col-md-9 col-sm-9">

					<?php
						if (isset($_GET['excluirAtor'])) {
							
							$codigoAtor = $_GET['excluirAtor'];
							//excluir as imagens do ator
							excluiImagens($codigoAtor, "atores");

							$sql = "CALL sp_deleta_atores($codigoAtor, @saida, @saida_rotulo)";
							executaQuery($sql, "atoresAdm.php");

						}else{

						}

					?>

				</div>
			</div>
		</main>
	<!-- FIM DO PRINCIPAL --------------------->

	<?php  if(isset($con)){ mysqli_close($con); } 	?>
</body>
<?php
	}else{ ?>
		<meta http-equiv="refresh" content=0;url="login.php">
	<?php
	}
?>
</html>