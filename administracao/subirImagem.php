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
	<title>Subir Imagem - Filmes na Estante</title>
	<?php
	//FUNÇÃO PARA SUBIR IMAGENS
	function enviaImagem($imagem, $caminho, $imagemTemp){
		$extensao = pathinfo($imagem, PATHINFO_EXTENSION);
		$extensao = strtolower($extensao);

		if(strstr('.jpg;.jpeg;.png', $extensao)){
			$imagem = $caminho.mt_rand().".".$extensao;
			// teste1232132.jpg
			$diretorio = "../imagens/".$caminho."/";
			// ../imagens/teste/
			move_uploaded_file($imagemTemp, $diretorio.$imagem);
		}else{ ?>
			<div class="alert alert-danger" role="alert">
				Você poderá enviar apenas imagens do tipo *.jpeg, *.jpg e *.png!
			</div><br><br>
		<?php
		}
		return $imagem;
	}
	?>
</head>
<body class="administracao">

	<!-- MENU SUPERIOR --------------------->

	<?php include_once "menuSuperior.html";	?>

	<!-- FIM DO MENU SUPERIOR --------------------->


	<!-- PRINCIPAL --------------------->
		
		<main class="container">
			<h1 class="text-center">DIRETORES(AS) - Administração</h1><br>
			<div class="row">
				<div class="col-md-3 col-sm-3">
					<?php include_once "menuAdm.html" ?>
				</div>
				<div class="col-md-9 col-sm-9">
					<?php
						if (isset($_POST['btnSubmitImagem'])) {
							$nomeImagem = $_FILES['fileImagem']['name'];

							if($nomeImagem != "" && isset($_FILES['fileImagem']['name']) ){
								$nomeImagem = enviaImagem($_FILES['fileImagem']['name'], "teste", $_FILES['fileImagem']['tmp_name'] );
							}else{
								$nomeImagem = "";
							} ?>
								<h3 class="text-center">Tudo certo!</h3><br>
								<h3 class="text-center">Imagem Cadastrada com sucesso.</h4><br><br>
								<a href="subirImagem.php">Voltar</a>
							<?php
						}else{
					?>
					
					<form name="fmImagem" method="post" action="subirImagem.php" enctype="multipart/form-data">
						<label>Insira a Imagem:</label><br>
						<input type="file" name="fileImagem" class="btn btn-success w-100" accept="image/png, image/jpeg"><br><br>
						<button type="submit" class="btn btn-primary form-control" name="btnSubmitImagem">Cadastrar Imagem</button>
					</form>
					<?php
					}
					?>
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