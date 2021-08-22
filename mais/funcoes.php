<?php


//FUNÇÃO PARA SUBIR IMAGENS
function enviaImagem($imagem, $caminho, $imagemTemp){
	$extensao = pathinfo($imagem, PATHINFO_EXTENSION);
	$extensao = strtolower($extensao);

	if(strstr('.jpg;.jpeg;.png', $extensao)){
		$imagem = $caminho.mt_rand().".".$extensao;
		// teste1232132.jpg
		$diretorio = "../imagens/".$caminho."/";
		// ../imagens/teste/
		move_uploaded_file($imagemTemp, $diretorio.$imagem);
	}else{ ?>
		<div class="alert alert-danger" role="alert">
			Você poderá enviar apenas imagens do tipo *.jpeg, *.jpg e *.png!
		</div><br><br>
	<?php
	}
	return $imagem;
}


//FUNÇÃO PARA EXECUTAR AS QUERYs E RETORNAR AS MENSAGENS DE SAÍDA
function executaQuery($sql, $paginaDeRetorno){
	include "conexao.php";
	if ($res = mysqli_query($con, $sql)) {
		$reg=mysqli_fetch_assoc($res);
		$saida = $reg['saida'];
		$rotulo = $reg['saida_rotulo'];
		switch ($rotulo) {
			case "Tudo certo!":
				$alert = 'alert-success';
				break;
			case "OPS!":
				$alert = 'alert-warning';
				break;
			case "ERRO!":
				$alert = 'alert-danger';
				break;
		}
		?>
		<div class="alert <?php echo $alert; ?>" role="alert">
			<h3><?php echo $rotulo; ?></h3>
			<?php echo $saida; ?>
			<br><br>
			<a href="<?php echo $paginaDeRetorno; ?>" class="alert-link" target='_self'>Voltar</a>
		</div>
		<?php
	}else{
		echo "Erro ao executar a query.";
	}
	if(isset($con)){ mysqli_close($con); }
}


//FUNÇÃO PARA EXLCUIR TODAS AS IMAGENS DE UM ATOR/DIRETOR/FILME/BANNER
function excluiImagens($codigo, $alvo){
	include "conexao.php";

	//$imagens = array();
	$linhas = 0;
	$where = $alvo."_codigo";

	//SELECT * FROM imagens WHERE atores_codigo = 3
	$sql = "SELECT * FROM imagens WHERE ".$where." = $codigo";
	if ($res = mysqli_query($con,$sql)) {
		$linhas = mysqli_affected_rows($con);
		if ($linhas > 0) {
			while ($reg = mysqli_fetch_assoc($res)) {
				
				$delete = unlink("../imagens/".$alvo."/".$reg["caminho"]);
				if (!$delete) {
					?>
					<div class="alert danger" role="alert">
						<h3>Erro!</h3>
						<p>Algo deu errado ao excluir a imagem: <?php $reg["caminho"]; ?></p>
						<br>
					</div>
					<?php
				}
			}
		}
	}else{ ?>

		<div class="alert danger" role="alert">
			<h3>Erro!</h3>
			<p>Algo deu errado executar a query!</p>
			<br>
		</div>
		<?php
	}
	if(isset($con)){ mysqli_close($con); }
}
?>