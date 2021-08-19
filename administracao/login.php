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
			<h4>Você será redirecionado para página de Administração.</h4>
		</center>
		<meta http-equiv="refresh" content=2;url="../adm.php">
		<?php
	}else{
?>
<head>
	<?php
		include_once "header.html";
		include_once "../mais/conexao.php";
	?>

	<title>Cadatro de Usuários - Filmes na Estante</title>
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

	<!-- MENU SUPERIOR --------------------->

	<?php include_once "menuSuperior.html";	?>

	<!-- FIM DO MENU SUPERIOR --------------------->


	<!-- PRINCIPAL --------------------->
		
		<main class="container">
			<h1 class="text-center">USUÁRIOS - Administração</h1><br>
			<div class="row">
				<div class="col-md-7 col-sm-7">
					<img src="../imagens/login.jpg" class="w-100" alt="Imagens ilustrativa para login">
				</div>
				<div class="col-md-5 col-sm-5">
					<?php
						if (isset($_POST['btnSubmitLogin'])) {
							$usuario = $_POST['txtLogin'];
							$senha = $_POST['txtSenha'];
							$sql = "SELECT login, senha FROM usuarios WHERE login = '$usuario' AND senha = '$senha'";
							if ($res=mysqli_query($con,$sql)) {
								$linhas = mysqli_affected_rows($con);
								if ($linhas > 0) {
									$_SESSION['acesso']=true;
									?>
									<div class="alert alert-success" role="alert">
										<h2 class="text-center">Login efetuado com sucesso!</h2>
										<br>
									</div>
									<meta http-equiv="refresh" content=2;url="../adm.php">
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
								echo "<h3>Erro ao executar a Query!</h3>";
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
		<!--- ENCERRANDO A CONEXÃO COM O BANCO DE DADOS --->
		<?php if (isset($con)) { mysqli_close($con); }  ?>
	<!-- FIM DO PRINCIPAL --------------------->

</body>
<?php
	}
?>
</html>