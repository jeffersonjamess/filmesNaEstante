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
	<script type="text/javascript">
		function validaCampos(){
			if (document.fmCursos.txtNome.value == "") {
				alert("Por favor, preencha um nome!");
				document.fmCursos.txtNome.focus();
				return false;
			}
			if (document.fmCursos.txtDescricao.value == "") {
				alert("Por favor, preencha uma descrição!");
				document.fmCursos.txtDescricao.focus();
				return false;
			}
			if (document.fmCursos.dtInicioCurso.value > document.fmCursos.dtFimCurso.value) {
				alert("A data de Início não pode ser posterior ao fim do curso!");
				document.fmCursos.dtInicioCurso.focus();
				return false;
			}
			if (document.fmCursos.dtInicioCurso.value == "") {
				alert("Por favor, selecione uma data para o ínicio do curso.");
				document.fmCursos.dtInicioCurso.focus();
				return false;
			}

			if (document.fmCursos.dtFimCurso.value == "") {
				alert("Por favor, selecione uma data para o fim do curso.");
				document.fmCursos.dtFimCurso.focus();
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
			<h1 class="text-center">Cursos</h1><br>
			<div class="row">
				<div class="col-md-3 col-sm-3">
					<?php include_once "menuAdm.html" ?>
				</div>
				<div class="col-md-9 col-sm-9">

					<?php
						/* VERIFICA SE FOI ENVIADO UM CURSO PARA CADASTRADO, */
						/* CASO NÃO TENHA SIDO, IRÁ MOSTRAR O FORMULÁRIO PARA CADASTRO */
						if (isset($_GET["btnSubmitCursos"])) {

							$curso = new Courses();
							/* PEQUENA FUNÇÃO PARA GERA UM ID */
							$idTemp = json_decode($curso->getID());
							foreach ($idTemp as $saida) {
								$id = $saida->id;
							}
							if (is_null($id)) {
								$id = 1;
							}else{
								$id++;
							}
							

							$nome = $_GET["txtNome"];
							$descricao = $_GET["txtDescricao"];
							$inicioCurso = date_create($_GET["dtInicioCurso"]);
							$fimCurso = date_create($_GET["dtFimCurso"]);
							$status = $_GET["selAtivo"];
							
							$inicioCurso = date_format($inicioCurso, "Y-m-d H:i:s");
							$fimCurso = date_format($fimCurso, "Y-m-d H:i:s"); 
							$created_at = date_format(new DateTime(), "Y-m-d H:i:s");
							$updated_at = date_format(new DateTime(), "Y-m-d H:i:s");

							$dados = [
								"id" => $id,
								"nameCourse" => $nome,
								"description" => $descricao,
								"dateStart" => $inicioCurso,
								"dateFinish" => $fimCurso,
								"status" => $status,
								"created_at" => $created_at,
								"updated_at" => $updated_at
							];
							$dados = json_encode($dados);

							$cadastraCurso = $curso->cadastrarCurso($dados);
							
							?>
							<?php
						}else{
					?>


					<ul class="nav nav-tabs" role="tablist">
						<li class="nav-item" role="presentation">
							<!-- ABA PARA CADASTRO DE NOVO CURSO -->
							<a href="#tabFormulario" class="nav-link active" id="linkFormulario" data-toggle="tab" role="tab" aria-controls="tabFormulario"><h3>Cadastro</h3></a>
						</li>
						<li class="nav-item" role="presentation">
							<!-- ABA PARA EXIBIÇÃO DOS CURSOS JÁ CADASTRADOS -->
							<a href="#tabExibicao" class="nav-link" id="linkExibicao" data-toggle="tab" role="tab" aria-controls="tabExibicao"><h3>Cursos Cadastrados</h3></a>
						</li>
					</ul>

					<!-- ABA PARA CADASTRO DE NOVO CURSO -->
					<div class="tab-content" id="meusConteudos">
						<div class="tab-pane fade show active" id="tabFormulario" role="tabpanel" aria-labelledby="linkFormulario">
							<br>
							<h3>Cadastrar Novo Curso:</h3>
							<form name="fmCursos" method="get" action="cursos.php" onsubmit="return validaCampos()">
								<label>Nome:</label><br>
								<input type="text" name="txtNome" class="form-control" maxlength="70">
								
								<div class="row">
									<div class="col-md-6">
										<br>
										<label for="festa">Data de início do curso:</label><br>
		    							<input type="date" name="dtInicioCurso" class="form-control" min="2022-02-01" max="2025-10-01">
	    							</div>

	    							<div class="col-md-6">
										<br>
										<label for="festa">Data de encerramento do curso:</label><br>
		    							<input type="date" name="dtFimCurso" class="form-control" min="2022-02-02" max="2026-02-01">
	    							</div>

								</div>
								<br>
								<label>Descrição do curso:</label><br>
								<textarea name="txtDescricao" maxlength="2000" placeholder="Pequena descrição do curso..." class="form-control"></textarea>

								<br>
								<label>Ativo ou Inativo?</label><br>
								<select name="selAtivo" class="form-control">
									<option value="I">Inativo</option>
									<option value="A">Ativo</option>
								</select>
								
								<br>

								<button type="submit" name="btnSubmitCursos" class="btn btn-primary w-100">Cadastrar</button>
								<br><br>
							</form>

						</div>

						<!-- ABA PARA EXIBIÇÃO DOS CURSOS JÁ CADASTRADOS -->
						<div class="tab-pane fade" id="tabExibicao" role="tabpanel" aria-labelledby="linkExibicao">
							<br>
							<h3>Cursos Cadastrados:</h3><br>
							<div class=row>
								<?php
									/* EXIBINDO CURSOS CADASTRADOS */
									$curso = new Courses();

									$todosCursos = json_decode($curso->listarCursos());
									foreach ($todosCursos as $saida) {
										$id = $saida->id;
										$nomeCurso = $saida->nameCourse;
									?>
									<div class="col-md-6 itensCadastrados text-center">
										<h4><?php echo $nomeCurso; ?></h4>
										<div class="btn-group btn-group-lg" role="group" arial-label="Basic sample">
											<a href="exibeCurso.php?exibeCurso=<?php echo $id; ?>" class="btn btn-success">Ver</a>
											<a href="editaCurso.php?editaCurso=<?php echo $id; ?>" class="btn btn-primary">Editar</a>
											<a href="editaCurso.php?excluirCurso=<?php echo $id; ?>" class="btn btn-danger" onclick="return confirm('Tem certeza que deseja excluir este curso?')">Excluir</a>
										</div>
									</div>
									<?php
									}

									?>
							</div>

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
</body>
<?php
	}else{ ?>
		<meta http-equiv="refresh" content=0;url="login.php">
	<?php
	}
?>
</html>