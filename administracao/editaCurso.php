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
						if (isset($_GET['excluirCurso'])) {
							$curso = new Courses();
							$id = $_GET['excluirCurso'];

							$deletarCurso = $curso->excluirCurso($id);
						}elseif (isset($_GET['editaCurso'])) {
							
							$id = $_GET['editaCurso'];
							$_SESSION['editaCurso']=$id;

							$curso = new Courses();
							$cursoParaEditar = json_decode($curso->getCurso($id));

							foreach ($cursoParaEditar as $saida) {
								$nomeCurso = $saida->nameCourse;
								$inicioCurso = substr($saida->dateStart, 0,10);
								$fimCurso = substr($saida->dateFinish, 0,10);
								$ativo = $saida->status;
								$descricao = $saida->description;
							}
							?>

							<br>
							<h3>Editar cadastro do curso: <u><?php echo $nomeCurso; ?></u></h3>
							<form name="fmCursos" method="get" action="editaCurso.php" onsubmit="return validaCampos()">
								<label>Nome:</label><br>
								<input type="text" name="txtNome" class="form-control" maxlength="100" value="<?php echo $nomeCurso; ?>">
								
								<div class="row">
									<div class="col-md-6">
										<br>
										<label for="festa">Data de início do curso:</label><br>
		    							<input type="date" name="dtInicioCurso" class="form-control" min="2022-02-01" max="2025-10-01" value="<?php echo $inicioCurso; ?>">
	    							</div>

	    							<div class="col-md-6">
										<br>
										<label for="festa">Data de encerramento do curso:</label><br>
		    							<input type="date" name="dtFimCurso" class="form-control" min="2022-02-02" max="2026-02-01" value="<?php echo $fimCurso; ?>">
	    							</div>

								</div>
								<br>
								<label>Descrição do curso:</label><br>
								<textarea name="txtDescricao" maxlength="2000" placeholder="Pequena descrição do curso..." class="form-control"><?php echo $descricao; ?></textarea>

								<br>
								<label>Ativo ou Inativo?</label><br>
								<select name="selAtivo" class="form-control">
									<option value="A" <?php if($ativo == "A"){ echo "selected"; } ?> >Ativo</option>
									<option value="I" <?php if($ativo == "I"){ echo "selected"; } ?> >Inativo</option>
								</select>
								
								<br>
								<button type="submit" name="btnSubmitEditaCurso" class="btn btn-success w-100">Editar Curso</button>
								<br><br>
							</form>

							<?php
						}elseif (isset($_GET['btnSubmitEditaCurso'])) {
							$curso = new Courses();
							$id = $_SESSION['editaCurso'];
							unset($_SESSION['editaCurso']);
							
							$nome = $_GET["txtNome"];
							$descricao = $_GET["txtDescricao"];
							$inicioCurso = date_create($_GET["dtInicioCurso"]);
							$fimCurso = date_create($_GET["dtFimCurso"]);
							$status = $_GET["selAtivo"];
							
							$inicioCurso = date_format($inicioCurso, "Y-m-d H:i:s");
							$fimCurso = date_format($fimCurso, "Y-m-d H:i:s"); 
							$updated_at = date_format(new DateTime('America/Sao_Paulo'), "Y-m-d H:i:s");

							$dados = [
								"id" => $id,
								"nameCourse" => $nome,
								"description" => $descricao,
								"dateStart" => $inicioCurso,
								"dateFinish" => $fimCurso,
								"status" => $status,
								"updated_at" => $updated_at
							];
							$dados = json_encode($dados);

							$editaCurso = $curso->editarCurso($dados);
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
		<meta http-equiv="refresh" content=0;url="login.php">
	<?php
	}
?>
</html>