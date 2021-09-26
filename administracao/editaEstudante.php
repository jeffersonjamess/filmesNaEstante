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
	<script type="text/javascript">
		function validaCampos(){
			if (document.fmStudents.txtNome.value == "") {
				alert("Por favor, preencha um nome!");
				document.fmStudents.txtNome.focus();
				return false;
			}
			if (document.fmStudents.txtEmail.value == "") {
				alert("Por favor, preencha um e-mail!");
				document.fmStudents.txtEmail.focus();
				return false;
			}
			if (document.fmStudents.selCurso.value == 0) {
				alert("Por favor, escolha um curso!");
				document.fmStudents.selCurso.focus();
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
			<h1 class="text-center">Estudantes</h1><br>
			<div class="row">
				<div class="col-md-3 col-sm-3">
					<?php include_once "menuAdm.html" ?>
				</div>
				<div class="col-md-9 col-sm-9">

					<?php
						if (isset($_GET['excluiEstudante'])) {
							$curso = new Students();
							$id = $_GET['excluiEstudante'];

							$deletarEstudante = $curso->excluirEstudante($id);
						}elseif(isset($_GET['editaEstudante'])) {

							$estudante = new Students();
							$id = $_GET['editaEstudante'];
							$_SESSION['editaEstudante'] = $id;

							$exibe = json_decode($estudante->getEstudante($id));
							foreach ($exibe as $saida) {
								$nomeEstudante = $saida->name;
								$email = $saida->email;
								$telefone = $saida->phone;
								$cursoEstudante = $saida->course;
								$ativo = $saida->status;
						}
					?>

						<div class="tab-pane fade show active" id="tabFormulario" role="tabpanel" aria-labelledby="linkFormulario">
							<br>
							<h3>Editar cadastro de Estudante:</h3>
							<form name="fmStudents" method="get" action="editaEstudante.php" onsubmit="return validaCampos()">
								<label>Nome:</label><br>
								<input type="text" name="txtNome" class="form-control" maxlength="100" value="<?php echo $nomeEstudante; ?>">

								<br>
								<label>E-mail:</label>
								<input type="email" name="txtEmail" placeholder="Digite um e-mail" maxlength="80" class="form-control" aria-describedby="emailHelp" value="<?php echo $email; ?>" />

								<br>
								<label>Telefone:</label>
								<input type="text" name="txtTelefone" id="telefone" placeholder="Digite um número de telefone" maxlength="15" class="form-control" value="<?php echo $telefone; ?>" />

								<br>
								<label>Ativo ou Inativo?</label>
								<select name="selAtivo" class="form-control">
									<option value="A" <?php if($ativo == "A"){ echo "selected"; } ?> >Ativo</option>
									<option value="I" <?php if($ativo == "I"){ echo "selected"; } ?> >Inativo</option>
								</select>


								<br>
								<label>Curso:</label>
								<select name="selCurso" class="form-control">
									<option value="0">Selecione um curso</option>
									<?php
										$curso = new Courses();
										$todosCursos;
										$todosCursos = json_decode($curso->listarCursos());
										foreach ($todosCursos as $saida) {
											$idCourse = $saida->id;
											$nomeCurso = $saida->nameCourse;
									?>
										<option value="<?php echo $idCourse; ?>" <?php if($idCourse == $cursoEstudante){ echo "selected"; } ?> >
											<?php echo $nomeCurso; ?></option>
									<?php
										}
									?>
								</select>
								<br><br>

								<button type="submit" name="btnSubmitEditaEstudante" class="btn btn-success w-100">Salvar Alterações</button>
							</form>
							<br>

						</div>
						<br>
						<?php
						}elseif(isset($_GET['btnSubmitEditaEstudante'])){
							$estudante = new Students();
							$id = $_SESSION['editaEstudante'];
							unset($_SESSION['editaEstudante']);

							$nomeEstudante = $_GET['txtNome'];
							$email = $_GET['txtEmail'];
							$telefone = $_GET['txtTelefone'];
							$status = $_GET['selAtivo'];
							$atualizadoEm = date_format(new DateTime('America/Sao_Paulo'), "Y-m-d H:i:s");
							$cursoEstudante = $_GET['selCurso'];

							$dados = [
								"id" => $id,
								"name" => $nomeEstudante,
								"email" => $email,
								"phone" => $telefone,
								"status" => $status,
								"updated_at" => $atualizadoEm,
								"course" => $cursoEstudante
							];
							$dados = json_encode($dados);

							$editaEstudante = $estudante->editarEstudante($dados);
						}else{ ?>
							<div class="alert alert-success" role="alert">
								<h3>Nenhum aluno encontrado!</h3>
								<br>
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