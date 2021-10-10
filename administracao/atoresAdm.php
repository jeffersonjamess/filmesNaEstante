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
						if (isset($_POST['btnSubmitAtores'])) {
							
							$nomeImagem1 = $_FILES['fileImagemAtor1']['name'];
							$nomeImagem2 = $_FILES['fileImagemAtor2']['name'];
							$nomeImagem3 = $_FILES['fileImagemAtor3']['name'];

							if ($nomeImagem1 <> "" && isset($_FILES['fileImagemAtor1']['name'])) {
								$nomeImagem1 = enviaImagem($_FILES['fileImagemAtor1']['name'], "atores", $_FILES['fileImagemAtor1']['tmp_name']);
							}else{
								$nomeImagem1 = "";
							}

							if ($nomeImagem2 <> "" && isset($_FILES['fileImagemAtor2']['name'])) {
								$nomeImagem2 = enviaImagem($_FILES['fileImagemAtor2']['name'], "atores", $_FILES['fileImagemAtor2']['tmp_name']);
							}else{
								$nomeImagem2 = "";
							}

							if ($nomeImagem3 <> "" && isset($_FILES['fileImagemAtor3']['name'])) {
								$nomeImagem3 = enviaImagem($_FILES['fileImagemAtor3']['name'], "atores", $_FILES['fileImagemAtor3']['tmp_name']);
							}else{
								$nomeImagem3 = "";
							}

							$nome = $_POST['txtNome'];
							$pais = $_POST['selPais'];
							$bio = $_POST['txtBiografia'];

							$sql = "CALL sp_cadastra_atores('$nome','$pais','$bio','$nomeImagem1','$nomeImagem2','$nomeImagem3',@saida, @saida_rotulo)";

							executaQuery($sql, "atoresAdm.php");

						}else{
					?>

					<ul class="nav nav-tabs" role="tablist">
						<li class="nav-item" role="presentation">
							 <a href="#tabExibicao" class="nav-link active" id="linkExibicao" data-toggle="tab" role="tab" aria-controls="tabExibicao">Atores e Atrizes Cadastrados</a>
						</li>
						<li class="nav-item" role="presentation">
							 <a href="#tabFormulario" class="nav-link" id="linkFormulario" data-toggle="tab" role="tab" aria-controls="tabFormulario">Cadastro</a>
						</li>
						
					</ul>

					<div class="tab-content" id="meusConteudos">
						<div class="tab-pane fade show active" id="tabExibicao" role="tabpanel" aria-labelledby="linkExibicao">
							<br>
							<h3>Atores/Atrizes Cadastrados(as):</h3><br>
							<div class=row>
								<?php
									$sql = "SELECT * FROM vw_retorna_atores order by nome_ator";
									if ($res=mysqli_query($con,$sql)) {
										
										$nomeAtor = array();
										$codigoAtor = array();
										$imagemAtor = array();
										$i = 0;

										while($reg=mysqli_fetch_assoc($res)){
											$nomeAtor[$i] = $reg['nome_ator'];
											$codigoAtor[$i] = $reg['codigo_ator'];
											$imagemAtor[$i] = $reg['caminho_imagem'];

											if (!isset($imagemAtor[$i])) {
												$imagemAtor[$i] = "sem_imagem.jpg";
											}
											?>
											<div class="col-md-3 itensCadastrados text-center">
												<img src="../imagens/atores/<?php echo $imagemAtor[$i]; ?>" class="img-responsive img-thumbnail">
												<h4><?php echo $nomeAtor[$i]; ?></h4>
												<div class="btn-group btn-group-sm" role="group" arial-label="Basic sample">
													<a href="editaAtorAdm.php?editaAtor=<?php echo $codigoAtor[$i]; ?>" class="btn btn-primary">Editar</a>
													<a href="editaAtorAdm.php?excluirAtor=<?php echo $codigoAtor[$i]; ?>" class="btn btn-secondary" onclick="return confirm('Tem certeza que deseja excluir este(a) Ator/atriz?')">Excluir</a>
												</div>
											</div>

											<?php
											$i++;
										}
									}else{
										echo "Erro ao executar a query!";
									}
								?>
							</div>

						</div>

						<div class="tab-pane fade" id="tabFormulario" role="tabpanel" aria-labelledby="linkFormulario">
							<br>
							<h3>Cadastrar Novo(a) ator/atriz:</h3>
							<form name="fmAtores" method="post" action="atoresAdm.php" enctype="multipart/form-data" onsubmit="return validaCampos()">
								<label>Nome:</label><br>
								<input type="text" name="txtNome" class="form-control" maxlength="70">

								<br>
								<label>País:</label>
								<select name="selPais" class="form-control">
									<option value="0">- - - - - - - - - - -</option>
									<?php
										$sql = "SELECT * FROM vw_retorna_pais ORDER BY nome_pais";
										if($res = mysqli_query($con,$sql)){
											$nomePais = array();
											$codigoPais = array();
											$i = 0;
											while ($reg = mysqli_fetch_assoc($res)) {
												$nomePais[$i] = $reg['nome_pais'];
												$codigoPais[$i] = $reg['codigo_pais'];
												?>
												<option value="<?php echo $codigoPais[$i] ?>"><?php echo $nomePais[$i]; ?></option>
												<?php
												$i++;
											}
										}
									?>
								</select>
								
								<br>
								<label>Biografia do(a) Ator/Atriz:</label><br>
								<textarea name="txtBiografia" maxlength="2000" placeholder="Pequena história/descrição do ator/atriz..." class="form-control"></textarea>

								<br>
								<label>Fotos do(a) ator/atriz:</label><br>
								<input type="file" name="fileImagemAtor1" class="btn btn-success w-100" accept="image/png, imagem/jpeg"><br><br>
								<input type="file" name="fileImagemAtor2" class="btn btn-success w-100" accept="image/png, imagem/jpeg"><br><br>
								<input type="file" name="fileImagemAtor3" class="btn btn-success w-100" accept="image/png, imagem/jpeg"><br><br>

								<button type="submit" name="btnSubmitAtores" class="btn btn-primary w-100">Cadastrar</button>
								<br><br>
							</form>

						</div>
						
					</div>
					<br>
					<?php
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