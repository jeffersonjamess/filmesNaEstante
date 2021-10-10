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
		include_once "../complementos/conexao.php";
		include_once "../complementos/funcoes.php";
		include "../Model/Courses.php";
		include "../Model/Students.php";

	?>
	<title>Cadastro de Estudantes</title>
</head>
<body class="administracao">

	<!-- MENU SUPERIOR --------------------->

	<?php include_once "menuSuperior.html";	?>

	<!-- FIM DO MENU SUPERIOR --------------------->


	<!-- PRINCIPAL --------------------->
		
		<main class="container">
			<h1 class="text-center">Estudantes</h1><br>
			<div class="row">
				<div class="col-md-3 col-sm-3">
					<?php include_once "menuAdm.html" ?>
				</div>
				<div class="col-md-9 col-sm-9">

					<?php
						if (isset($_GET["exibeEstudante"])) {

							$estudante = new Students();
							$id = $_GET["exibeEstudante"];

							$exibe = json_decode($estudante->getEstudante($id));
							
							foreach ($exibe as $saida) {
								$nomeEstudante = $saida->name;
								$email = $saida->email;
								$telefone = $saida->phone;
								$cursoEstudante = $saida->course;
								$status = $saida->status;
								$criadoEm = date_create($saida->created_at);
								$atualizadoEm = date_create($saida->updated_at);
							}
							if ($status == "A") {
								$status = "ATIVO";
							}else{ $status = "INATIVO"; }

							$curso = new Courses();
							$temp = json_decode($curso->getCurso($cursoEstudante));
							foreach ($temp as $saida) {
								$nomeCurso = $saida->nameCourse;
							}
						?>

						<h1 class="text-center">Cadastro do(a) estudante: <?php echo $nomeEstudante; ?></h1>
						<br>
						<h4>E-mail: <strong><?php echo $email; ?></strong></h4>
						<h4>Telefone: <strong><?php echo $telefone; ?></strong></h4>
						<h4>Atualmente o cadastro de <?php echo $nomeEstudante; ?> está <strong><?php echo $status; ?></strong></h4>
						<h4><?php echo $nomeEstudante; ?> está matriculado(a) no curso: <a href="exibeCurso.php?exibeCurso=<?php echo $cursoEstudante; ?>"><strong><?php echo $nomeCurso ?></strong></a></h4>

						<h4>O cadastro do(a) estudante foi realizado em: <strong><?php echo date_format($criadoEm, "d/m/Y H:i:s") ?></strong></h4>
						<h4>Foi atualizado pela última vez em: <strong><?php echo date_format($atualizadoEm, "d/m/Y H:i:s") ?></strong></h4>

						<br>
						<a href="editaEstudante.php?editaEstudante=<?php echo $id; ?>" class="btn btn-primary btn-lg btn-block">Editar</a>
						<a href="editaEstudante.php?excluiEstudante=<?php echo $id; ?>" class="btn btn-danger btn-lg btn-block" onclick="return confirm('Tem certeza que deseja excluir este(a) estudante?')">Excluir</a>
						<br>
						<br>
						<?php
						}else{
							?>
							<div class="alert alert-warning" role="alert">
								<h3>Ops!</h3>
								<h4>Aluno não encontrado.</h4>
								<br><br>
								<a href='estudantes.php' class="alert-link" target='_self'>Voltar</a>
							</div>
							<?php
							}
						?>
				</div>
			</div>
		</main>
	<script type="text/javascript" src="../js/mascara.js"></script>
	<?php include_once "rodape.html"; ?>
</body>
<?php
	}else{ ?>
		<meta http-equiv="refresh" content=0;url="../index.php">
	<?php
	}
?>
</html>