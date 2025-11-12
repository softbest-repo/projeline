<?php
	session_start();

	include('../f/conf/config.php');
	include('../f/conf/functions.php');
	require '../vendor/autoload.php';

	$token = $_POST['token'];
	$action = $_POST['action'];

	// $url = 'https://www.google.com/recaptcha/api/siteverify';
	// $data = array('secret' => $chaveSecreta,'response' => $token);

	// // call curl to POST request
	// $ch = curl_init();
	// curl_setopt($ch, CURLOPT_URL, $url);
	// curl_setopt($ch, CURLOPT_POST, true);
	// curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
	// curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	// $response = curl_exec($ch);
	// curl_close($ch);
	// $arrResponse = json_decode($response, true);

	// // verify the response
	// if ($arrResponse["success"] == true && $arrResponse["score"] >= 0.5) {
	
		if (isset($_POST['recuperar'])) { 
			$sqlEsqueci = "SELECT codCliente, nomeCliente, sobrenomeCliente, senhaCliente, emailCliente, statusCliente FROM clientes WHERE emailCliente = '" . $_POST['email'] . "' LIMIT 0,1";
			$resultEsqueci = $conn->query($sqlEsqueci);
			$dadosEsqueci = $resultEsqueci->fetch_assoc();
			

			if ($dadosEsqueci['codCliente'] != "") {
				$sqlEsqueci = "SELECT codCliente, nomeCliente, sobrenomeCliente, senhaCliente, emailCliente, statusCliente FROM cliente WHERE emailCliente = '" . $_POST['email'] . "' LIMIT 0,1";
				if ($dadosEsqueci['statusCliente'] == 'T') {

					$assunto = "Cadastro de Conta";

					$nomeCliente = $dadosEsqueci['nomeCliente'];
					$sobrenomeCliente = $dadosEsqueci['sobrenomeCliente'];
					$emailCliente = $dadosEsqueci['emailCliente'];
					$senhaCliente = $dadosEsqueci['senhaCliente'];

					$sqlEmail = "SELECT * FROM emails WHERE statusEmail = 'T' LIMIT 0,1";
					$resultEmail = $conn->query($sqlEmail);
					$dadosEmail = $resultEmail->fetch_assoc();

					$nomeRemetente = $nomeEmpresa;
					$assunto = "Esqueci minha senha";
					$emailRemetente = $dadosEmail['enderecoEmail'];
					$senhaRemetente = $dadosEmail['senhaEmail'];
					$nomeDestino = $_POST['nomeCompleto'];
					$emailDestino = $_POST['email'];

					$mailer = new PHPMailer\PHPMailer\PHPMailer();
					$mailer->IsSMTP();
					$mailer->SMTPDebug = 0;
					$mailer->Port = 587;
					$mailer->Host = $hostEmail;
					$mailer->SMTPAuth = true;
					$mailer->Username = $emailRemetente;
					$mailer->Password = $senhaRemetente;
					//~ $mailer->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
					$mailer->IsHTML(true);
					$mailer->CharSet = 'utf-8';

					$nome = $_POST['nome'];
					$sobrenome = $_POST['sobrenome'];
					$emailC = $_POST['email'];
					$celular = $_POST['celular'];
					$descricao = $_POST['descricao'];
					$cidade = $_POST['cidade'];

					$nomeRemetente = $nomeEmpresaMenor;
					$nomeDestino = $nomeEmpresaMenor;
					$emailDestino = $email;

					include ('corpo-email-esqueci.php');

					$mailer->setFrom($emailRemetente, $nomeRemetente);
					$mailer->AddAddress($emailDestino, $nomeDestino);
					$mailer->Subject = $assunto;
					$mailer->Body = $conteudoEmailEmpresa;
					$mailer->Send();
					$mailer->ClearAllRecipients();
					$mailer->ClearAttachments();

					if ($emailC != "") {
						$nomeRemetente = $nomeEmpresaMenor;
						$nomeDestino = $nomeEmpresaMenor;
						$emailDestino = $emailC;

						include ('corpo-email-esqueci.php');

						$mailer->setFrom($emailRemetente, $nomeRemetente);
						$mailer->AddAddress($emailDestino, $nomeDestino);
						$mailer->Subject = $assunto;
						$mailer->Body = $conteudoEmailCliente;
						$mailer->Send();
						$mailer->ClearAllRecipients();
						$mailer->ClearAttachments();
					}

					$sql = "INSERT INTO contatos VALUES(0, 0, 0, '" . $assunto . "', '" . date("Y-m-d") . "', '" . $_POST['nome'] . "', '" . $_POST['email'] . "', '" . $_POST['cidade'] . "', '" . $_POST['estado'] . "', '" . $_POST['celular'] . "', '" . $_POST['descricao'] . "', 'T')";
					$result = $conn->query($sql);

					$_SESSION['email'] = "";
					$_SESSION['msg-recuperacao'] = "<p style=' width: 100%; text-align: center;color: red; font-weight: bold; margin-bottom: 0px;  left: 50%; transform: translateX(-50%); font-size:12px; position: absolute; bottom: 45px;'>Sua senha foi recuperada com sucesso e enviada ao seu e-mail!</p>";
					echo "<meta HTTP-EQUIV='Refresh' CONTENT='0;URL=" . $configUrl . "minha-conta/login/'>";
					exit();
				} else {
					$_SESSION['email'] = $_POST['email'];
					$_SESSION['msg-recuperacao'] = "<p style='color: red;font-weight: bold; margin-bottom: 0px; left: 50%; transform: translateX(-50%);font-size: 13px; position: absolute; top: 85px; width: 100%; text-align: center;'>Sua conta foi desativada, para mais informações entre em contato!</p>";
					echo "<meta HTTP-EQUIV='Refresh' CONTENT='0;URL=" . $configUrl . "minha-conta/esqueci-minha-senha/'>";
					exit();
				}
			} else {
				$_SESSION['email'] = $_POST['email'];
				$_SESSION['msg-recuperacao'] = "<p  style='color: red;font-weight: bold; margin-bottom: 0px; left: 50%; transform: translateX(-50%);font-size: 13px; position: absolute; top: 85px; width: 100%; text-align: center;'>Seu e-mail não consta em nossos registros!</p>";
				echo "<meta HTTP-EQUIV='Refresh' CONTENT='0;URL=" . $configUrl . "minha-conta/esqueci-minha-senha/'>";
				exit();
			}
		}
	// } else {
	// $_SESSION['msg-recuperacao'] = "<p style='color: red;font-weight: bold; margin-bottom: 0px; left: 50%; transform: translateX(-50%);font-size: 13px; position: absolute; top: 85px; width: 100%; text-align: center;' >Problemas ao verificar Captcha, atualize a página e tente novamente!</p>";
	// }
?>
