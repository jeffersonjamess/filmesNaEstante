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
						if(isset($_GET['btnSubmitCategoria'])){
							$nomeCategoria = $_GET['txtCategoria'];
							$link = $nomeCategoria;
							$sql = "CALL sp_cadastra_categoria('$nomeCategoria','$link',@saida, @rotulo);";
							
							executaQuery($sql, "categoriasAdm.php");
						}else{


					?>

					<h2 class="text-center">Cadastro de categorias</h2>
					<form name="fmCategorias" method="get" action="categoriasAdm.php" onsubmit="return validaCampos()">
						<label>Nome da categoria:</label><br>
						<input type="text" name="txtCategoria" class="form-control" maxlength="50"><br>
						<button type="submit" class="btn btn-primary w-100" name="btnSubmitCategoria">Cadastrar</button>
					</form>
					<br>
					<hr/>
					<h2 class="text-center">Categorias cadastradas:</h2>
						<div class="row">
						<?php
							$sql = 'SELECT * FROM vw_retorna_categorias';
							if ($res=mysqli_query($con, $sql)) {
								$nomeCategoria = array();
								$codigoCategoria = array();
								$i = 0;
								while ($reg=mysqli_fetch_assoc($res)) {
									$nomeCategoria[$i] = $reg['Nome_Categoria'];
									$codigoCategoria[$i] = $reg['Codigo_Categoria'];
									?>
									
										<div class="col-md-3 itensCadastrados text-center">
											<h4><?php echo $nomeCategoria[$i]; ?></h4>
											<div class="btn-group btn-group-sm" role="group" arial-label="Basic sample">
												<a href="editaCategoriaAdm.php?editaCategoria=<?php echo $codigoCategoria[$i]; ?>&nomeCategoria=<?php echo $nomeCategoria[$i]; ?>" class="btn btn-primary">Editar</a>
												<a href="editaCategoriaAdm.php?excluirCategoria=<?php echo $codigoCategoria[$i]; ?>" class="btn btn-secondary" onclick="return confirm('Tem certeza que deseja excluir esta categoria?')">Excluir</a>
											</div>
										</div>
									
									<?php
									$i++;
								}
							}

						?>
							</div>

					<?php

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