<?php
require_once('../complementos/conexao.php');
class Students extends Conexao{
	protected $con;
	private $id, $name, $email, $password, $phone, $course, $status, $create_at, $updated_at;
	
	function __construct(){
		$this->con = $this->conectarBD();
	}

	public function setDados($dados){
		$objCadastro = json_decode($dados);

		$this->id = $objCadastro->id;
		$this->name = $objCadastro->name;
		$this->email = $objCadastro->email;
		$this->phone = $objCadastro->phone;
		$this->status = $objCadastro->status;
		$this->updated_at = $objCadastro->updated_at;
		$this->course = $objCadastro->course;
		if (isset($objCadastro->created_at)) {
			$this->created_at = $objCadastro->created_at;
		}
		if (isset($objCadastro->password)) {
			$this->password = $objCadastro->password;
		}
	}
	
	/* FUNÇÃO PARA CADASTRAR INFORMAÇÕES DE UM ESTUDANTE */
	public function cadastrarAluno($dados){
		$this->setDados($dados);

		$sql = "INSERT INTO students (id, name, email, password, phone, status, created_at, updated_at, course) VALUES (:ID, :NAME, :EMAIL, :PASSWORD, :PHONE, :STATUS, :CREATED_AT, :UPDATED_AT, :COURSE)";
		$stmt = $this->con->prepare($sql);

		$res = $stmt->execute(
			array(
				"ID"=>$this->id,
				"NAME"=>$this->name,
				"EMAIL"=>$this->email,
				"PASSWORD"=>$this->password,
				"PHONE"=>$this->phone,
				"STATUS"=>$this->status,
				"CREATED_AT"=>$this->created_at,
				"UPDATED_AT"=>$this->updated_at,
				"COURSE"=>$this->course
			)
		);
		$contagem = $stmt->rowCount();
		if ($contagem > 0) {
			?>
			<div class="alert alert-success" role="alert">
				<h3>Tudo Certo!</h3>
				<h4>Estudante cadastrado com sucesso!</h4>
				<br><br>
				<a href='estudantes.php' class="alert-link" target='_self'>Voltar</a>
			</div>
			<?php
		}else{
			?>
			<div class="alert alert-danger" role="alert">
				<h3>ERRO!</h3>
				<h4>Algo deu erro ao cadastrar o(a) estudante!</h4>
				<br><br>
				<a href='estudantes.php' class="alert-link" target='_self'>Voltar</a>
			</div>
			<?php
		}
	}

	/* FUNÇÃO PARA TRAZER TODOS ESTUDANTES CADASTRADOS */
	public function listarEstudantes(){
		$sql = "SELECT * FROM students ORDER BY name";

		$stmt = $this->con->prepare($sql);
		$stmt->execute();

		$res = $stmt->fetchAll(PDO::FETCH_ASSOC);
		$contagem = $stmt->rowCount();
		if ($contagem == 0) {
			?>
			<div class="alert alert-success" role="alert">
				<h3>Não há nenhum aluno cadastrado.</h3>
				<br>
				<a href='estudantes.php' class="alert-link" target='_self'>Voltar</a>
			</div>
			<?php
		}
		return json_encode($res);
		
	}

	/* FUNÇÃO PARA EXCLUIR O CADASTRO DE UM ESTUDANTE */
	public function excluirEstudante($id){
		$this->id = $id;
		$sql = "DELETE FROM students WHERE id = :ID";

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
				<h4>Estudante EXCLUÍDO com sucesso!</h4>
				<br><br>
				<a href='estudantes.php' class="alert-link" target='_self'>Voltar</a>
			</div>
			<?php
		}else{
			?>
			<div class="alert alert-danger" role="alert">
				<h3>ERRO!</h3>
				<h4>Algo deu erro ao EXCLUIR o(a) estudante!</h4>
				<br><br>
				<a href='estudantes.php' class="alert-link" target='_self'>Voltar</a>
			</div>
			<?php
		}
	}

	/* FUNÇÃO PARA RETORNAR INFORMAÇÕES DE UM ESTUDANTE */
	public function getEstudante($id){
		$this->id = $id;
		$sql = "SELECT * FROM students WHERE id = :ID";

		$stmt = $this->con->prepare($sql);
		$stmt->execute(
			array(
				"ID"=>$this->id
			)
		);
		$res = $stmt->fetchAll(PDO::FETCH_ASSOC);
		$contagem = $stmt->rowCount();
		if ($contagem == 0) { ?>
			<div class="alert alert-warning" role="alert">
				<h3>Estudante não encontrado!</h3>
				<br>
				<a href='estudantes.php' class="alert-link" target='_self'>Voltar</a>
			</div>
			<?php
		}elseif($contagem > 0) {
			return json_encode($res);
		}
	}

	/* FUNÇÃO PARA EDITAR INFORMAÇÕES DE UM ESTUDANTE */
	public function editarEstudante($dados){
		$this->setDados($dados);

		$sql = "UPDATE students SET name = :NAME, updated_at = :UPDATED_AT, email = :EMAIL, phone = :PHONE, status = :STATUS, course = :COURSE WHERE id = :ID";
		$stmt = $this->con->prepare($sql);

		$res = $stmt->execute(
			array(
				"ID"=>$this->id, 
				"NAME"=>$this->name,
				"EMAIL"=>$this->email,
				"PHONE"=>$this->phone,
				"STATUS"=>$this->status,
				"COURSE"=>$this->course,
				"UPDATED_AT"=>$this->updated_at
			)
		);

		$contagem = $stmt->rowCount();
		if ($contagem > 0) {
			?>
			<div class="alert alert-success" role="alert">
				<h3>Tudo Certo!</h3>
				<h4>Estudante EDITADO com sucesso!</h4>
				<br><br>
				<a href='estudantes.php' class="alert-link" target='_self'>Voltar</a>
			</div>
			<?php
		}else{
			?>
			<div class="alert alert-danger" role="alert">
				<h3>ERRO!</h3>
				<h4>Algo deu erro ao EDITAR o cadastro do Estudante!</h4>
				<br><br>
				<a href='estudantes.php' class="alert-link" target='_self'>Voltar</a>
			</div>
			<?php
		}
	}

	/* FUNÇÃO PARA TRAZER O ÚLTIMO ID CADASTRADO NA TABELA STUDENTS */
	/* É USADA NA HORA DE CADASTRAR UM NOVO ESTUDANTE */
	public function getID(){
		$sql = "SELECT MAX(id) as id FROM students";

		$stmt = $this->con->prepare($sql);
		$stmt->execute();

		$res = $stmt->fetchAll(PDO::FETCH_ASSOC);
		return json_encode($res);
	}

	public function listarEstudantesNoCurso($course){
		$this->course = $course;
		$sql = "SELECT * FROM students WHERE course = :COURSE";

		$stmt = $this->con->prepare($sql);
		$stmt->execute(
			array(
				"COURSE"=>$this->course
			)
		);
		$res = $stmt->fetchAll(PDO::FETCH_ASSOC);
		$contagem = $stmt->rowCount();
		if ($contagem == 0) {
			?>
			<div class="alert alert-success" role="alert">
				<h3>Não há nenhum aluno cadastrado nesse curso.</h3>
				<br>
				<a href='cursos.php' class="alert-link" target='_self'>Voltar</a>
			</div>
			<?php
		}
		return json_encode($res);
	}

}
?>