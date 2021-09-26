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
						/* VERIFICA SE FOI ENVIADO UM ESTUDANTE PARA CADASTRADO, */
						/* CASO NÃO TENHA SIDO, IRÁ MOSTRAR O FORMULÁRIO PARA CADASTRO */
						if (isset($_POST['btnSubmitEstudante'])) {

							$estudante = new Students();


							/* PEQUENA FUNÇÃO PARA GERA UM ID */
							$idTemp = json_decode($estudante->getID());
							foreach ($idTemp as $saida) {
								$id = $saida->id;
							}
							if (is_null($id)) {
								$id = 1;
							}else{
								$id++;
							}

							$nome = $_POST['txtNome'];
							$email = $_POST['txtEmail'];
							$telefone = $_POST['txtTelefone'];
							$cursoEscolhido = $_POST['selCurso'];
							$ativo = $_POST['selAtivo'];

							$senha = "123"; /* SENHA PADRÃO PARA NOVOS ESTUDANTES */
							$senha = md5($senha); /* CODIFICANDO A SENHA PADRÃO */

							$created_at = date_format(new DateTime('America/Sao_Paulo'), 'Y-m-d H:i:s');
							$updated_at = date_format(new DateTime('America/Sao_Paulo'), 'Y-m-d H:i:s');
							
							$dados = [
								"id" => $id,
								"name" => $nome,
								"email" => $email,
								"password" => $senha,
								"phone" => $telefone,
								"status" => $ativo,
								"created_at" => $created_at,
								"updated_at" => $updated_at,
								"course" => $cursoEscolhido
							];

							$dados = json_encode($dados);

							$cadastraAluno = $estudante->cadastrarAluno($dados);
						}else{
					?>

					<ul class="nav nav-tabs" role="tablist">
						<li class="nav-item" role="presentation">
							<!-- ABA DE EXIBIÇÃO ESTUDANTES CADASTRADOS -->
							<a href="#tabExibicao" class="nav-link active" id="linkExibicao" data-toggle="tab" role="tab" aria-controls="tabExibicao"><h3>Estudantes Cadastrados</h3></a>
						</li>
						<li class="nav-item" role="presentation">
							<!-- ABA PARA CADASTRO DE NOVO ESTUDANTE -->
							<a href="#tabFormulario" class="nav-link" id="linkFormulario" data-toggle="tab" role="tab" aria-controls="tabFormulario"><h3>Cadastrar</h3></a>
						</li>
					</ul>

					<div class="tab-content" id="meusConteudos">

						<!-- ABA DE EXIBIÇÃO DOS ESTUDANTES CADASTRADOS -->
						<div class="tab-pane fade show active" id="tabExibicao" role="tabpanel" aria-labelledby="linkExibicao">
							<br>
							<div class=row>
								<?php
									/* EXIBINDO CURSOS CADASTRADOS */
									$estudante = new Students();

									$todosEstudantes = json_decode($estudante->listarEstudantes());
									foreach ($todosEstudantes as $saida) {
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


						<!-- ABA DE EXIBIÇÃO DO FORMULÁRIO PARA CADASTRO DE NOVO ESTUDANTE -->
						<div class="tab-pane fade" id="tabFormulario" role="tabpanel" aria-labelledby="linkFormulario">
							<br>
							<h3>Cadastrar Novo Estudante:</h3>
							<form name="fmStudents" method="post" action="estudantes.php" onsubmit="return validaCampos()">
								<label>Nome:</label><br>
								<input type="text" name="txtNome" class="form-control" maxlength="100">

								<br>
								<label>E-mail:</label>
								<input type="email" name="txtEmail" placeholder="Digite um e-mail" maxlength="80" class="form-control" aria-describedby="emailHelp"/>

								<br>
								<label>Telefone:</label>
								<input type="text" name="txtTelefone" id="telefone" placeholder="Digite um número de telefone" maxlength="15" class="form-control" />

								<br>
								<label>Ativo ou Inativo?</label>
								<select name="selAtivo" class="form-control">
									<option value="A">Ativo</option>
									<option value="I">Inativo</option>									
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
											$id = $saida->id;
											$nomeCurso = $saida->nameCourse;
									?>
										<option value="<?php echo $id; ?>"><?php echo $nomeCurso; ?></option>
									<?php
										}
									?>
								</select>
								<br><br>

								<button type="submit" name="btnSubmitEstudante" class="btn btn-primary w-100">Cadastrar</button>
							</form>
							<br>

						</div>

					</div>
					<br>
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