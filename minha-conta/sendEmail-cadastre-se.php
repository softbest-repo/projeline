<?php
	ob_start();
	session_start();
	
	include('../f/conf/config.php');
	include('../f/conf/functions.php');
	require '../vendor/autoload.php';

	$token = $_POST['token'];
	$action = $_POST['action'];
	
	$url = 'https://www.google.com/recaptcha/api/siteverify';
	$data = array( 'secret' => $chaveSecreta, 'response' => $token );
	  
	 $ch = curl_init();
	 curl_setopt($ch, CURLOPT_URL, $url);
	 curl_setopt($ch, CURLOPT_POST, true);
	 curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
	 curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	 $response = curl_exec($ch);
	 curl_close($ch);
	 $arrResponse = json_decode($response, true);
	  
	if($arrResponse["success"] == true && $arrResponse["score"] >= 0.5){

		$sqlCpf = "SELECT count(codCliente) registros FROM clientes WHERE cpfCliente = '".$_POST['cpf']."' LIMIT 0,1";
		$resultCpf = $conn->query($sqlCpf);
		$dadosCpf = $resultCpf->fetch_assoc();		
			
		if($dadosCpf['registros'] == 0){								

			$sqlEmail = "SELECT count(codCliente) registros FROM clientes WHERE emailCliente = '".$_POST['email']."' LIMIT 0,1";
			$resultEmail = $conn->query($sqlEmail);
			$dadosEmail = $resultEmail->fetch_assoc();		
				
			if($dadosEmail['registros'] == 0){								

				echo "<div id='bloco-loading'><p class='loading'></p><p class='text-loading'>Aguarde enquanto finalizamos o seu cadastro!</p></div>";
				echo "<style>
						#bloco-loading {display: flex;flex-direction: column;align-items: center;justify-content: center; padding-top: 100px;text-align: center;}
						.loading {margin-bottom: 10px;}.text-loading {font-size: 24px;color: #737272;font-weight: 700; font-family: 'Poppins';}
					</style>";

				$sqlInto = "INSERT INTO clientes VALUES(0, '".date('Y-m-d')."', '".str_replace("\"", "&quot;", str_replace("'", "&#39;", $_POST['nome']))."', '".str_replace("\"", "&quot;", str_replace("'", "&#39;", $_POST['sobrenome']))."', '".$_POST['cpf']."', '".$_POST['cidade']."', '".$_POST['estado']."', '".$_POST['celular']."', '".$_POST['celular2']."', '".$_POST['email']."', '".$_POST['senha']."', 'T')";
				$resultInto = $conn->query($sqlInto);
				
				if($resultInto == 1){
					
					$sqlCodCliete = "SELECT * FROM clientes WHERE nomeCliente = '".$_POST['nome']."' ORDER BY codCliente DESC LIMIT 0,1";
					$resultCodCliente = $conn->query($sqlCodCliete);
					$dadosCodCliente = $resultCodCliente->fetch_assoc();
									
					setcookie("codAprovado".$cookie, $dadosCodCliente['codCliente'], time() + 3600, "/");					

					$assunto = "Cadastro de Conta";

					$sqlEmail = "SELECT * FROM emails WHERE statusEmail = 'T' LIMIT 0,1";
					$resultEmail = $conn->query($sqlEmail);
					$dadosEmail = $resultEmail->fetch_assoc();

					$emailRemetente = $dadosEmail['enderecoEmail'];
					$senhaRemetente = $dadosEmail['senhaEmail'];

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
					$celular2 = $_POST['celular2'];
					$descricao = $_POST['descricao'];
					$cidade = $_POST['cidade'];
					

					$nomeRemetente = $nomeEmpresaMenor;
					$nomeDestino = $nomeEmpresaMenor;
					$emailDestino = $email;
										
					include ('corpo-email.php');

					$mailer->setFrom($emailRemetente, $nomeRemetente);
					$mailer->AddAddress($emailDestino, $nomeDestino);
					$mailer->Subject = $assunto;
					$mailer->Body = $conteudoEmailEmpresa;
					$mailer->Send();
					$mailer->ClearAllRecipients();
					$mailer->ClearAttachments();

					if($emailC != ""){
						
						$nomeRemetente = $nomeEmpresaMenor;
						$nomeDestino = $nomeEmpresaMenor;
						$emailDestino = $emailC;

						include ('corpo-email.php');

						$mailer->setFrom($emailRemetente, $nomeRemetente);
						$mailer->AddAddress($emailDestino, $nomeDestino);
						$mailer->Subject = $assunto;
						$mailer->Body = $conteudoEmailCliente;;
						$mailer->Send();
						$mailer->ClearAllRecipients();
						$mailer->ClearAttachments();
					
					}
					
					if($_SESSION['salvaLocal'] != ""){
						$linkLocal = $_SESSION['salvaLocal'];
						$_SESSION['salvaLocal'] = "";
						echo "<meta HTTP-EQUIV='Refresh' CONTENT='0;URL=".$configUrl.$linkLocal."'>";	
					}else{
						echo "<meta HTTP-EQUIV='Refresh' CONTENT='0;URL=".$configUrl."minha-conta/'>";
					}			

				}

				$_SESSION['nome'] = "";
				$_SESSION['sobrenome'] = "";
				$_SESSION['cpf'] = "";
				$_SESSION['email'] = "";
				$_SESSION['celular'] = "";
				$_SESSION['celular2'] = "";
				$_SESSION['cidade'] = "";
				$_SESSION['estado'] = "";
				$_SESSION['senha'] = "";
			
			}else{
				$_SESSION['msg-cadastro'] = "Email já cadastrado!";
				$_SESSION['msg-cadastro'] = '<p class="erro" style="color: red; font-weight: bold; margin-bottom: 0px;  left: 50%; transform: translateX(-50%); font-size:13px; position: absolute; top: 20px;">Email já cadastrado!</p>';
				echo "<meta HTTP-EQUIV='Refresh' CONTENT='0;URL=".$configUrl."minha-conta/cadastre-se/'>";
				exit();
			}
		}else{
			$_SESSION['msg-cadastro'] = "Cpf já cadastrado!";
			$_SESSION['msg-cadastro'] = '<p class="erro" style="color: red; font-weight: bold; margin-bottom: 0px;  left: 50%; transform: translateX(-50%); font-size:13px; position: absolute; top: 20px;">Email já cadastrado!</p>';
			echo "<meta HTTP-EQUIV='Refresh' CONTENT='0;URL=".$configUrl."minha-conta/cadastre-se/'>";
			exit();
		}

	}else{
	 	$_SESSION['erro'] = "<p class='erro'>Problemas ao verificar Captcha, atualize a página e tente novamente!</p>";
	}		
?>
