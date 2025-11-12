<?php 
	include ('../../f/conf/config.php');

	$codProjetoImagem = $_POST['codProjetoImagem'];
	$ordenacaoProjetoImagem = $_POST['ordenacaoProjetoImagem'];

	$update = "UPDATE projetosImagens SET ordenacaoProjetoImagem = '".$ordenacaoProjetoImagem."' WHERE codProjetoImagem = ".$codProjetoImagem."";
	$result = $conn->query($update);
?>
