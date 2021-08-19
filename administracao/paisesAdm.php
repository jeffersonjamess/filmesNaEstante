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
			<h1 class="text-center">Países - Administração</h1><br>
			<div class="row">
				<div class="col-md-3 col-sm-3">
					<?php include_once "menuAdm.html" ?>
				</div>
				<div class="col-md-9 col-sm-9">
					<?php
						if(isset($_GET['btnSubmitPais'])){
							$nomePais = $_GET['txtPais'];
							$link = $nomePais;
							$sql = "CALL sp_cadastra_pais('$nomePais','$link',@saida, @rotulo);";
							executaQuery($sql, "paisesAdm.php");
							
						}else{


					?>

					<h2 class="text-center">Cadastro de Países</h2>
					<form name="fmPaises" method="get" action="PaisesAdm.php" onsubmit="return validaCampos()">
						<label>Nome do País:</label><br>
						<input type="text" name="txtPais" class="form-control" maxlength="50"><br>
						<button type="submit" class="btn btn-primary w-100" name="btnSubmitPais">Cadastrar</button>
					</form>
					<br>
					<hr/>
					<h2 class="text-center">Países cadastrados:</h2>
						<div class="row">
						<?php
							$sql = 'SELECT * FROM vw_retorna_pais';
							if ($res=mysqli_query($con, $sql)) {
								$nomePais = array();
								$linkPais = array();
								$codigoPais = array();
								$i = 0;
								while ($reg=mysqli_fetch_assoc($res)) {
									$nomePais[$i] = $reg['nome_pais'];
									$linkPais[$i] = $reg['link_pais'];
									$codigoPais[$i] = $reg['codigo_pais'];
									?>
									
										<div class="col-md-3 itensCadastrados text-center">
											<h4><?php echo $nomePais[$i]; ?></h4>
											<div class="btn-group btn-group-sm" role="group" arial-label="Basic sample">
												<a href="editaPaisAdm.php?editaPais=<?php echo $codigoPais[$i]; ?>&nomePais=<?php echo $nomePais[$i]; ?>" class="btn btn-primary">Editar</a>
												<a href="editaPaisAdm.php?excluirPais=<?php echo $codigoPais[$i]; ?>" class="btn btn-secondary" onclick="return confirm('Tem certeza que deseja excluir esta Pais?')">Excluir</a>
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