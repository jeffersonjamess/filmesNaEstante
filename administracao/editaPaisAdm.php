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
	<title>Administração</title>
	<script type="text/javascript">
		function validaCampos(){
			if (document.fmPaises.txtPais.value == "") {
				alert("Por favor, preencha o nome do País.");
				document.fmPaises.txtPais.focus();
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
			<h1 class="text-center">PAÍSES - Administração</h1><br>
			<div class="row">
				<div class="col-md-3 col-sm-3">
					<?php include_once "menuAdm.html" ?>
				</div>
				<div class="col-md-9 col-sm-9">
					<?php
						if(isset($_GET['excluirPais'])){
							$codigoPais = $_GET['excluirPais'];
							$sql = "CALL sp_deleta_pais('$codigoPais', @saida, @rotulo);";
							executaQuery($sql,"paisesAdm.php");
							
						}else if (isset($_GET['editaPais'])) {
							$_SESSION['codigoPais'] = $_GET['editaPais'];
							$nomePais = $_GET['nomePais'];
							?>
								<h2 class="text-center">Alteração de país</h2>
								<form name="fmPaises" method="get" action="editaPaisAdm.php" onsubmit="return validaCampos()">
									<label>Nome do País:</label><br>
									<input type="text" name="txtPais" value="<?php echo $nomePais; ?>" class="form-control" maxlength="50"><br>
									<button type="submit" class="btn btn-primary w-100" name="btnSubmitPais">Alterar País</button>
								</form>
								<br>
							<?php
						}else if(isset($_GET['btnSubmitPais'])){
							$nomePais = $_GET['txtPais'];
							$codigoPais = $_SESSION['codigoPais'];
							unset($_SESSION['codigoPais']);
							$sql = "CALL sp_edita_pais($codigoPais,'$nomePais',@saida, @rotulo);";
							executaQuery($sql, "paisesAdm.php");
							
						}
					?>
				</div>
			</div>

			
		</main>
	<!-- FIM DO PRINCIPAL --------------------->
	<!-- FECHANDO CONEXÃO COM O BANCO DE DADOS --------------------->
	<?php if(isset($con)){ mysqli_close($con); } ?>
</body>
<?php
	}else{ ?>
		<meta http-equiv="refresh" content=0;url="login.php">
	<?php
	}
?>
</html>