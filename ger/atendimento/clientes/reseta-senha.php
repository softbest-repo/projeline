<?php
	ini_set('display_errors', '0');
	error_reporting(E_ALL | E_STRICT);

	include('../../f/conf/config.php');
	include('../../f/conf/conexao.php');

	$codCliente = $_POST['codCliente'];

	$sqlUpdate = "UPDATE clientes SET senha = '123456' WHERE codCliente = '".$codCliente."'";
	$resultUpdate = $conn->query($sqlUpdate);
	
	require_once('class.phpmailer.php');

	$mailer = new PHPMailer();
	$mailer->IsSMTP();
	$mailer->SMTPDebug = 1;
	$mailer->Port = 587;			 
	$mailer->Host = $hostEmail;

	$sqlCliente = "SELECT * FROM clientes WHERE codCliente = ".$codCliente." LIMIT 0,1";
	$resultCliente = $conn->query($sqlCliente);
	$dadosCliente = $resultCliente->fetch_assoc();

	$nomeCliente = $dadosCliente['nomeCompleto'];
	$emailCliente = $dadosCliente['email'];
	$telefoneCliente = $dadosCliente['fone1'];

	$sqlEmail = "SELECT * FROM emails WHERE statusEmail = 'T' LIMIT 0,1";
	$resultEmail = $conn->query($sqlEmail);
	$dadosEmail = $resultEmail->fetch_assoc();
	
	$nomeRemetente = $nomeEmpresaMenor;
	$assunto = "Sua senha foi resetada";
	$emailRemetente = $dadosEmail['enderecoEmail'];
	$senhaRemetente = $dadosEmail['senhaEmail'];
	$nomeDestino = $nomeCliente;
	$emailDestino = $emailCliente;
	$senha = $dadosCliente['senha'];

	include ('corpo-email-senha.php');

	$mailer->SMTPAuth = true; //Define se haverá ou não autenticação no SMTP
	$mailer->Username = $emailRemetente; //Informe o e-mai o completo
	$mailer->Password = $senhaRemetente; //Senha da caixa postal
	$mailer->FromName = $nomeRemetente; //Nome que será exibido para o destinatário
	$mailer->From = $emailRemetente; //Obrigatório ser a mesma caixa postal indicada em "username"
	$mailer->AddAddress($emailDestino); //Destinatários
	$mailer->Subject = $assunto;
	$mailer->IsHTML(true);
	$mailer->CharSet = 'utf-8';
	$mailer->Body = $conteudoEmailCliente;
	$mailer->Send();
	$mailer->ClearAllRecipients();
	$mailer->ClearAttachments();	
?>
