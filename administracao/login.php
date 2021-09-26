<!DOCTYPE html>
<html>
<?php
	if (!isset($_SESSION)) {
		session_start();
	}
	if (isset($_SESSION['acesso'])) {
		?>
		<center><h2>A Sessão já está aberta</h2>
			<br>
			<h3>Você será redirecionado.</h3>
		</center>
		<meta http-equiv="refresh" content=2;url="estudantes.php">
		<?php
	}else{
?>
<head>
	<?php
		include_once "header.html";
		include_once "../complementos/conexao.php";
	?>


	<title>Mapa - Back End II</title>
	<script type="text/javascript">
		function validaCampos(){
			if (document.fmLogin.txtLogin.value == "") {
				alert("Por favor, preencha um Login!");
				document.fmLogin.txtLogin.focus();
				return false;
			}
			if (document.fmLogin.txtSenha.value == "") {
				alert("Por favor, preencha a sua senha!");
				document.fmLogin.txtSenha.focus();
				return false;
			}
		}
	</script>
</head>
<body class="administracao">

	<!-- PRINCIPAL --------------------->
		
		<main class="container">
			<h1 class="text-center">Administração</h1><br>
			<div class="row">
				<div class="col-md-7 col-sm-7">
					<img src="../imagens/login.jpg" class="img-login rounded mx-auto d-block" alt="Imagens ilustrativa para login" style="max-width: 400px">
				</div>
				<div class="col-md-5 col-sm-5">
					<?php
						define("USER", "201366435");
						define("PASS", "jefferson");

						if (isset($_POST['btnSubmitLogin'])) {
							$usuario = $_POST['txtLogin'];
							$senha = $_POST['txtSenha'];

							if ($usuario == USER && $senha == PASS) {
								$_SESSION['acesso']=true;
							?>
								<div class="alert alert-success" role="alert">
									<h2 class="text-center">Login efetuado com sucesso!</h2>
									<br>
								</div>
								<meta http-equiv="refresh" content=2;url="estudantes.php">
							<?php
							}else{ ?>
								<div class="alert alert-danger" role="alert">
									<h2 class="text-center">Usuário ou senha inválido!</h2>
									<br><br>
									<a href='login.php' class="alert-link" target='_self'>Voltar</a>
								</div>
							<?php
							}
						}else{
					?>
					<form name="fmLogin" method="post" action="login.php" onsubmit="return validaCampos();">
						<h2 class="text-center">Insira o seu Login e Senha:</h2><br>
						<input type="text" name="txtLogin" placeholder="insira o seu login aqui" class="form-control text-center"><br><br>
						<input type="password" name="txtSenha" placeholder="insira a sua senha aqui" class="form-control text-center"><br><br>
						<button type="submit" name="btnSubmitLogin" class="btn btn-primary w-100">Entrar</button>
					</form>
					<?php
						}
					?>
				</div>
			</div>
			
		</main>
	<!-- FIM DO PRINCIPAL --------------------->

</body>
<?php
	}
?>
</html>