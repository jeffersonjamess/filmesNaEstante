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
						/* CRIAÇÃO DAS VARIÁVEIS DE SESSÃO: */ 
						$_SESSION['caminho_imagem'] = array();
						$_SESSION['codigo_imagem'] = array();

						if (isset($_GET['excluirAtor'])) {
							
							$codigoAtor = $_GET['excluirAtor'];
							//excluir as imagens do ator
							excluiImagens($codigoAtor, "atores");

							$sql = "CALL sp_deleta_atores($codigoAtor, @saida, @saida_rotulo)";
							executaQuery($sql, "atoresAdm.php");

						}elseif (isset($_GET['editaAtor'])){
							// Carregar informações do(a) Ator/Atriz

							$codigoAtor = $_GET['editaAtor'];
							$_SESSION['codigoAtor'] = $codigoAtor;
							$imagemAtor = array();
							$codigoImagem = array();
							$i = 0;
							$sql = "SELECT * FROM atores WHERE codigo = '$codigoAtor'";
							if ($res = mysqli_query($con, $sql)) {
								$reg=mysqli_fetch_assoc($res);
								$nomeAtor = $reg['nome'];
								$paisAtor = $reg['paises_codigo'];
								$bioAtor = $reg['biografia'];
							}else{
								echo "Erro ao executar a query.";
							}
							$sql = "SELECT * FROM imagens WHERE atores_codigo = '$codigoAtor'";
							$contador = 0;
							if ($res = mysqli_query($con, $sql)) {
								while ($reg=mysqli_fetch_assoc($res)) {
									$imagemAtor[$i] = $reg['caminho'];
									$codigoImagem[$i] = $reg['codigo'];
									$i++;
									$contador = $i;
								}
							}else{
								echo "Erro ao executar a query.";
							}


							for ($i=0; $i < $contador; $i++) { 
								if (isset($imagemAtor[$i])) {
									$_SESSION['caminho_imagem'][$i] = $imagemAtor[$i];
									$_SESSION['codigo_imagem'][$i] = $codigoImagem[$i];
									echo "armazenou na sessão do código imagem: ".$_SESSION['codigo_imagem'][$i]."<br>";
								}
							}
							?>
							


					<!-- EXIBIÇÃO DO FORMUMÁRIO -->
					<div class="tab-pane fade show active" id="tabFormulario" role="tabpanel" aria-labelledby="linkFormulario">
						<br>
						<h3>Editar cadastro de <?php echo $nomeAtor; ?></h3>
						<form name="fmAtores" method="post" action="editaAtorAdm.php" enctype="multipart/form-data" onsubmit="return validaCampos()">
							<label>Nome:</label><br>
							<input type="text" name="txtNome" class="form-control" maxlength="70" value="<?php echo $nomeAtor; ?>">

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
											<option value="<?php echo $codigoPais[$i] ?>" <?php 
											if ($codigoPais[$i] == $paisAtor) {
												?> selected <?php
											}
											?> ><?php echo $nomePais[$i]; ?></option>
											<?php
											$i++;
										}
									}
								?>
							</select>
							
							<br>
							<label>Biografia do(a) Ator/Atriz:</label><br>
							<textarea name="txtBiografia" maxlength="2000" placeholder="Pequena história/descrição do ator/atriz..." class="form-control"><?php echo $bioAtor; ?></textarea>

							<br>
							<div class="row text-center">
								<div class="col-md-3"><strong>Imagem do(a) ator/atriz</strong></div>
								<div class="col-md-6"><strong>Carregar nova imagem</strong></div>
								<div class="col-md-3"><strong>Excluir imagem?</strong></div>
								<?php
								$j = 0;
								for ($i=1; $i <= 3; $i++) { ?>
									<div class="col-md-3">
										<?php
										if (isset($imagemAtor[$j])) {
										?>
										
										<img src="../imagens/atores/<?php echo $imagemAtor[$j]; ?>" title="<?php echo $imagemAtor[$j]; ?>" style="max-width: 100px; padding: 5px;" > <?php
										}else{
											?> <img src="../imagens/sem_imagem.jpg" style="max-width: 100px; padding: 5px;"> <?php
										}
										?>
									</div>
									<div class="col-md-6"><input type="file" name="<?php echo "fileImagemAtor".$i; ?>" class="btn btn-success w-100" accept="image/png, imagem/jpeg"></div>
									<div class="col-md-3"><input type="checkbox" name="<?php echo "chExcluir".$i; ?>" class="form-control"></div>
									<br><br>
									<?php
									$j++;
								}
								?>

							</div>

							<button type="submit" name="btnSubmitEditaAtores" class="btn btn-primary w-100">Editar</button>
							<br><br>
						</form>
					</div>

					<?php
						}elseif (isset($_POST['btnSubmitEditaAtores'])) {
							$codigoAtor = $_SESSION['codigoAtor'];
							unset($_SESSION['codigoAtor']);

							$nomeImagem = array();
							$codigoImagem = array();
							$j = 0;
							for ($i=1; $i <= 3; $i++) { 
								$nomeImagem[$j] = $_FILES['fileImagemAtor'.$i]['name'];
								$codigoImagem[$j] = "";
								if ($nomeImagem[$j] <> "" && isset($_FILES['fileImagemAtor'.$i]['name'])) {
									$nomeImagem[$j] = enviaImagem($_FILES['fileImagemAtor'.$i]['name'], "atores", $_FILES['fileImagemAtor'.$i]['tmp_name']);
									echo "subiu a imagem. o nome dela é: ".$nomeImagem[$j]."<br>";
								}elseif (isset($_SESSION['caminho_imagem'][$j])) {
									$nomeImagem[$j] = $_SESSION['caminho_imagem'][$j];
									echo "agora o nome imagem está: ".$nomeImagem[$j]."<br>";
								}

								echo "teoricamente deveria estar com o código na sessão: ".$_SESSION['codigo_imagem'][$j]."<br>";

								if (isset($_SESSION['codigo_imagem'][$j])) {
									echo "entrou no if para ver se tem algo na sessão do código imagem<br>";
									$codigoImagem[$j] = $_SESSION['codigo_imagem'][$j];
								}

								/* essa verificação é para o caso do usuário substituir a imagem que já está salva */
								if (isset($_SESSION['caminho_imagem'][$j]) && isset($nomeImagem[$j]) ) {
									echo "entrou no if para substituir a imagem"."<br>";
									if ($nomeImagem[$j] <> $_SESSION['caminho_imagem'][$j]) {
										echo "entrou no segundo if para substituir a imagem"."<br>";
										/* excluiImagens($codigoImagem[$j],"atores"); */
										$delete = unlink("../imagens/atores/".$nomeImagem[$j]);
										if (!$delete) {
											?>
											<div class="alert danger" role="alert">
												<h3>Erro!</h3>
												<p>Algo deu errado ao excluir a imagem: <?php $nomeImagem[$j]; ?></p>
												<br>
											</div>
											<?php
										}
									}
								}else{
									echo "não entrou no if pra substituir a imagem.<br>";
								}


								/* essa verificação é para ver se o usuário marcou opção de excluir a imagem */
								if (isset($_POST['chExcluir'.$j])) {
									excluiImagens($codigoImagem[$j],"atores");
								}
								$j++;
							}

							
							if (isset($_SESSION['caminho_imagem']) || isset($_SESSION['codigo_imagem'])) {
								unset($_SESSION['caminho_imagem']);
								unset($_SESSION['codigo_imagem']);
								echo "fez o unset"."<br>";
							}

							$nome = $_POST['txtNome'];
							$pais = $_POST['selPais'];
							$bio = $_POST['txtBiografia'];

							$sql = "CALL sp_edita_ator('$codigoAtor','$nome','$pais','$bio','$nomeImagem[0]','$codigoImagem[0]','$nomeImagem[1]','$codigoImagem[1]','$nomeImagem[2]','$codigoImagem[2]',@saida, @saida_rotulo)";
							echo "<br>esse é o sql: ".$sql."<br>";
							executaQuery($sql, "atoresAdm.php");


						}else{
							?>
							<meta http-equiv="refresh" content=5;url="atoresAdm.php">
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