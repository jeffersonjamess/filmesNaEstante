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
	<title>Home</title>
	<script type="text/javascript">
		function validaCampos(){
			if (document.fmCategorias.txtCategoria.value == "") {
				alert("Por favor, preencha o nome da categoria.");
				document.fmCategorias.txtCategoria.focus();
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
			<h1 class="text-center">CATEGORIAS - Administração</h1><br>
			<div class="row">
				<div class="col-md-3 col-sm-3">
					<?php include_once "menuAdm.html" ?>
				</div>
				<div class="col-md-9 col-sm-9">
					<?php
						if(isset($_GET['excluirCategoria'])){
							$codigoCategoria = $_GET['excluirCategoria'];
							$sql = "CALL sp_deleta_categoria('$codigoCategoria', @saida, @rotulo);";
							executaQuery($sql, "categoriasAdm.php");
							
						}else if (isset($_GET['editaCategoria'])) {
							$_SESSION['codigoCategoria'] = $_GET['editaCategoria'];
							$nomeCategoria = $_GET['nomeCategoria'];
							?>
								<h2 class="text-center">Alteração de categoria</h2>
								<form name="fmCategorias" method="get" action="editaCategoriaAdm.php" onsubmit="return validaCampos()">
									<label>Nome da categoria:</label><br>
									<input type="text" name="txtCategoria" value="<?php echo $nomeCategoria; ?>" class="form-control" maxlength="50"><br>
									<button type="submit" class="btn btn-primary w-100" name="btnSubmitCategoria">Alterar Categoria</button>
								</form>
								<br>
							<?php
						}else if(isset($_GET['btnSubmitCategoria'])){
							$nomeCategoria = $_GET['txtCategoria'];
							$codigoCategoria = $_SESSION['codigoCategoria'];
							unset($_SESSION['codigoCategoria']);
							$sql = "CALL sp_edita_categoria($codigoCategoria,'$nomeCategoria',@saida, @rotulo);";
							executaQuery($sql,"categoriasAdm.php");
							
						}else{

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