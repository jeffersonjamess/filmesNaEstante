<!DOCTYPE html>
<html>
<?php
if (!isset($_SESSION)) {
	session_start();
}
	if ($_SESSION["acesso"]==true) {
?>
<head>
	<?php
		include "header.html";
		include "../complementos/conexao.php";
		include "../complementos/funcoes.php";
		include "../Model/Courses.php";
		include "../Model/Students.php";
	?>
	<title>Cadastro de Cursos</title>
</head>
<body class="administracao">

	<!-- MENU SUPERIOR --------------------->

	<?php include_once "menuSuperior.html";	?>

	<!-- FIM DO MENU SUPERIOR --------------------->


	<!-- PRINCIPAL --------------------->
		
		<main class="container">
			<h1 class="text-center">Cursos</h1><br>
			<div class="row">
				<div class="col-md-3 col-sm-3">
					<?php include_once "menuAdm.html" ?>
				</div>
				<div class="col-md-9 col-sm-9">
					
					<?php
						/* VERIFICA SE FOI ENVIADO UM CURSO PARA CADASTRADO, */
						/* CASO NÃO TENHA SIDO, IRÁ MOSTRAR O FORMULÁRIO PARA CADASTRO */
						if (isset($_GET["exibeCurso"])) {

							$curso = new Courses();
							$id = $_GET["exibeCurso"];

							$exibe = json_decode($curso->getCurso($id));
							foreach ($exibe as $saida) {
								$nomeCurso = $saida->nameCourse;
								$descricao = $saida->description;
								$status = $saida->status;
								$dataInicio = date_create($saida->dateStart);
								$dataFim = date_create($saida->dateFinish);
								$criadoEm = date_create($saida->created_at);
								$atualizadoEm = date_create($saida->updated_at);
							}
							if ($status == "A") {
								$status = "ATIVO";
							}else{ $status = "INATIVO"; }


							?>
							
							<ul class="nav nav-tabs" role="tablist">
								<li class="nav-item" role="presentation">
									<!-- ABA PARA CADASTRO DE NOVO CURSO -->
									<a href="#tabFormulario" class="nav-link active" id="linkFormulario" data-toggle="tab" role="tab" aria-controls="tabFormulario"><h3>Cadastro</h3></a>
								</li>
								<li class="nav-item" role="presentation">
									<!-- ABA PARA EXIBIÇÃO DOS CURSOS JÁ CADASTRADOS -->
									<a href="#tabExibicao" class="nav-link" id="linkExibicao" data-toggle="tab" role="tab" aria-controls="tabExibicao"><h3>Alunos desse curso</h3></a>
								</li>
							</ul>

							<div class="tab-content" id="meusConteudos">
								<div class="tab-pane fade show active" id="tabFormulario" role="tabpanel" aria-labelledby="linkFormulario">
									<h1 class="text-center"><?php echo $nomeCurso; ?></h1>
									<br>
									<h4>Descrição do curso:</h4>
									<p><?php echo $descricao; ?></p>
									<h4>Atualmente o curso está <strong><?php echo $status; ?></strong></h4>
									<h4>Início do curso: <strong><?php echo date_format($dataInicio, "d/m/Y"); ?></strong></h4>
									<h4>Término do curso: <strong><?php echo date_format($dataFim, "d/m/Y"); ?></strong></h4>

									<h4>O Cadastro do curso foi realizado em: <strong><?php echo date_format($criadoEm, "d/m/Y H:i:s") ?></strong></h4>
									<h4>Foi Atualizado pela última vez em: <strong><?php echo date_format($criadoEm, "d/m/Y H:i:s") ?></strong></h4>

									<br><br>
									<a href="editaCurso.php?editaCurso=<?php echo $id; ?>" class="btn btn-primary btn-lg btn-block">Editar</a>
									<a href="editaCurso.php?excluirCurso=<?php echo $id; ?>" class="btn btn-danger btn-lg btn-block" onclick="return confirm('Tem certeza que deseja excluir este curso?')">Excluir</a>

									<br>
								</div>

								<!-- ABA PARA EXIBIÇÃO DOS ALUNOS CADASTRADOS NESSE CURSO -->
								<div class="tab-pane fade" id="tabExibicao" role="tabpanel" aria-labelledby="linkExibicao">
									<br>
									<div class="row">
									<?php
									$estudantes = new Students();
									$curso = $_GET['exibeCurso'];

									$estudantesCurso = json_decode($estudantes->listarEstudantesNoCurso($curso));
									foreach ($estudantesCurso as $saida) {
										$id = $saida->id;
										$nomeEstudante = $saida->name;
									?>
									<div class="col-md-6 itensCadastrados text-center">
										<h4><?php echo $nomeEstudante; ?></h4>
										<div class="btn-group btn-group-lg" role="group" arial-label="Basic sample">
											<a href="exibeEstudante.php?exibeEstudante=<?php echo $id; ?>" class="btn btn-success">Ver</a>
											<a href="editaEstudante.php?editaEstudante=<?php echo $id; ?>" class="btn btn-primary">Editar</a>
											<a href="editaEstudante.php?excluiEstudante=<?php echo $id; ?>" class="btn btn-danger" onclick="return confirm('Tem certeza que deseja excluir este(a) estudante?')">Excluir</a>
										</div>
									</div>
									<?php
									}
									?>
									</div>
								</div>
							</div>
							
							<?php
						}else{
							?>
							<div class="alert alert-warning" role="alert">
								<h3>Ops!</h3>
								<h4>Curso não encontrado.</h4>
								<br><br>
								<a href='cursos.php' class="alert-link" target='_self'>Voltar</a>
							</div>
							<?php
						}
					?>
				</div>
			</div>
		</main>
	<!-- FIM DO PRINCIPAL --------------------->
</body>
<?php
	}else{ ?>
		<meta http-equiv="refresh" content=0;url="login.php">
	<?php
	}
?>
</html>