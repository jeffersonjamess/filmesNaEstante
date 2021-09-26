<?php
require_once('../complementos/conexao.php');
class Courses extends Conexao{
	protected $con;
	private $id, $nameCourse, $description, $dateStart, $dateFinish, $status, $created_at, $updated_at;

	public function __construct(){
		$this->con = $this->conectarBD();
	}
	
	
 	public function setDados($dados){
		$objCadastro = json_decode($dados);

		$this->id = $objCadastro->id;
		$this->nameCourse = $objCadastro->nameCourse;
		$this->description = $objCadastro->description;
		$this->dateStart = $objCadastro->dateStart;
		$this->dateFinish = $objCadastro->dateFinish;
		$this->status = $objCadastro->status;
		$this->updated_at = $objCadastro->updated_at;
		if (isset($objCadastro->created_at)) {
			$this->created_at = $objCadastro->created_at;
		}
	}

	public function cadastrarCurso($dados){
		$this->setDados($dados);

		$sql = "INSERT INTO courses (id, nameCourse, description, dateStart, dateFinish, status, created_at, updated_at) VALUES (:ID, :NAMECOURSE, :DESCRIPTION, :DATESTART, :DATEFINISH, :STATUS, :CREATED_AT, :UPDATED_AT)";
		$stmt = $this->con->prepare($sql);

		$res = $stmt->execute(
			array(
				"ID"=>$this->id,
				"NAMECOURSE"=>$this->nameCourse,
				"DESCRIPTION"=>$this->description,
				"DATESTART"=>$this->dateStart,
				"DATEFINISH"=>$this->dateFinish,
				"STATUS"=>$this->status,
				"CREATED_AT"=>$this->created_at,
				"UPDATED_AT"=>$this->updated_at
			)
		);
		$contagem = $stmt->rowCount();
		if ($contagem > 0) {
			?>
			<div class="alert alert-success" role="alert">
				<h3>Tudo Certo!</h3>
				<h4>Curso cadastrado com sucesso!</h4>
				<br><br>
				<a href='cursos.php' class="alert-link" target='_self'>Voltar</a>
			</div>
			<?php
		}else{
			?>
			<div class="alert alert-danger" role="alert">
				<h3>ERRO!</h3>
				<h4>Algo deu erro ao cadastrar o curso!</h4>
				<br><br>
				<a href='cursos.php' class="alert-link" target='_self'>Voltar</a>
			</div>
			<?php
		}
	}

	/* FUNÇÃO PARA EXIBIÇÃO DE TODOS OS CURSOS CADASTRADOS */
	public function listarCursos(){
		$sql = "SELECT * FROM courses ORDER BY id";

		$stmt = $this->con->prepare($sql);
		$stmt->execute();

		$res = $stmt->fetchAll(PDO::FETCH_ASSOC);
		$contagem = $stmt->rowCount();
		if ($contagem == 0) {
			/* SE NÃO HOUVER NENHUM CURSO CADASTRADO, SERÁ MOSTRADA A MENSAGEM ABAIXO */
			?>
			<div class="alert alert-success" role="alert">
				<h3>Não há nenhum curso cadastro.</h3>
				<br>
				<a href='cursos.php' class="alert-link" target='_self'>Voltar</a>
			</div>
			<?php
		}
		return json_encode($res);
	}

	/* FUNÇÃO PARA EXCLUIR UM CURSO */
	public function excluirCurso($id){
		$this->id = $id;

		/* PRIMEIRO VERIFICA SE NÃO TEM NENHUM ESTUDANTE VINCULADO AO CURSO */
		$sql = "SELECT * FROM students WHERE course = :ID";

		$stmt = $this->con->prepare($sql);
		$stmt->execute(
			array(
				"ID"=>$this->id
			)
		);

		$contagem = $stmt->rowCount();
		if ($contagem > 0) {
			/* SE HOUVER ESTUDANTES CADASTRADOS NO CURSO, NÃO SERÁ POSSÍVEL EXCLUIR */
			?>
			<div class="alert alert-warning" role="alert">
				<h3>Ops!</h3>
				<h4>Existem estudantes matriculados nesse curso. Remova os estudantes primeiro</h4>
				<br><br>
				<a href='cursos.php' class="alert-link" target='_self'>Voltar</a>
			</div>
			<?php
		}else{
			
			$sql = "DELETE FROM courses WHERE id = :ID";

			$stmt = $this->con->prepare($sql);

			$res = $stmt->execute(
				array(
					"ID"=>$this->id
				)
			);

			$contagem = $stmt->rowCount();
			if ($contagem > 0) {
				?>
				<div class="alert alert-success" role="alert">
					<h3>Tudo Certo!</h3>
					<h4>Curso EXCLUÍDO com sucesso!</h4>
					<br><br>
					<a href='cursos.php' class="alert-link" target='_self'>Voltar</a>
				</div>
				<?php
			}else{
				?>
				<div class="alert alert-danger" role="alert">
					<h3>ERRO!</h3>
					<h4>Algo deu erro ao EXCLUIR o curso!</h4>
					<br><br>
					<a href='cursos.php' class="alert-link" target='_self'>Voltar</a>
				</div>
				<?php
			}

		}
	}

	/* FUNÇÃO PARA TRAZER INFORMAÇÕES REFERENTES A UM CURSO */
	public function getCurso($id){
		$this->id = $id;
		$sql = "SELECT * FROM courses WHERE id = :ID";

		$stmt = $this->con->prepare($sql);
		$stmt->execute(
			array(
				"ID"=>$this->id
			)
		);
		$res = $stmt->fetchAll(PDO::FETCH_ASSOC);
		$contagem = $stmt->rowCount();
		return json_encode($res);
	}

	/* FUNÇÃO PARA EDITAR INFORMAÇÕES DE UM CURSO */
	public function editarCurso($dados){
		$this->setDados($dados);

		$sql = "UPDATE courses SET nameCourse = :NAMECOURSE, description = :DESCRIPTION, dateStart = :DATESTART, dateFinish = :DATEFINISH, status = :STATUS, UPDATED_AT = :UPDATED_AT WHERE id = :ID";
		$stmt = $this->con->prepare($sql);

		$res = $stmt->execute(
			array(
				"ID"=>$this->id,
				"NAMECOURSE"=>$this->nameCourse,
				"DESCRIPTION"=>$this->description,
				"DATESTART"=>$this->dateStart,
				"DATEFINISH"=>$this->dateFinish,
				"STATUS"=>$this->status,
				"UPDATED_AT"=>$this->updated_at
			)
		);
		$contagem = $stmt->rowCount();
		if ($contagem > 0) {
			?>
			<div class="alert alert-success" role="alert">
				<h3>Tudo Certo!</h3>
				<h4>Curso ALTERADO com sucesso!</h4>
				<br><br>
				<a href='cursos.php' class="alert-link" target='_self'>Voltar</a>
			</div>
			<?php
		}else{
			?>
			<div class="alert alert-danger" role="alert">
				<h3>ERRO!</h3>
				<h4>Algo deu erro ao EDITAR o curso!</h4>
				<br><br>
				<a href='cursos.php' class="alert-link" target='_self'>Voltar</a>
			</div>
			<?php
		}
	}

	/* FUNÇÃO PARA TRAZER O ÚLTIMO ID CADASTRADO NA TABELA COURSES */
	/* É USADA NA HORA DE CADASTRAR UM NOVO CURSO */
	public function getID(){
		$sql = "SELECT MAX(id) as id FROM courses";

		$stmt = $this->con->prepare($sql);
		$stmt->execute();

		$res = $stmt->fetchAll(PDO::FETCH_ASSOC);
		return json_encode($res);
	}

}

?>
