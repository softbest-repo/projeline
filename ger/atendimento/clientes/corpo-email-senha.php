<?php
//Corpo do Email do cliente
$conteudoEmailCliente = "<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Strict//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd'>
<html xmlns='http://www.w3.org/1999/xhtml' xml:lang='pt' lang='pt'>
	<head>
		<title>".$nomeEmpresaMenor."</title>
		<meta http-equiv='content-type' content='text/html;charset=utf-8' />
		<meta name='author' content='SoftBest'/>
		<meta name='description' content='' />
		<meta name='keywords' content='' />
	</head>
	<body>
		<div style='width:588px; min-height:500px; margin:0 auto; border:2px solid ".$cor1.";'>
			<div style='width:588px; height:120px; position:relative; border-bottom:15px solid ".$cor2."; overflow:hidden;'>
				<img src='".$configUrl."f/i/mail.png' alt='' />
			</div>
			<div style='width:588px;'>	
				<table>
					<tr>
						<td><h2 style='color:#171614; margin:0; padding-top:15px; padding-bottom:10px;'>".$assunto."</h2></td>
					</tr>
				</table>
				<table>
					<tr>
						<td style='color:#171614000'>Olá <strong>".$nomeCliente."</strong>!</td>
					</tr>
					<tr>
						<td style='color:#171614000'>Sua senha foi resetada com sucesso!</td>
					</tr>
				</table>
				<table>
					<tr>
						<td style='padding:0; margin:0;'><h4 style='padding-top:15px; padding-bottom:5px; text-decoration:underline; margin:0;'>Seus Dados</h4></td>
					</tr>
					<tr>
						<td colspan='2'><strong>Nome:</strong> ".$nomeCliente."</td>
					</tr>
					<tr>
						<td colspan='2'><strong>Telefone:</strong> ".$telefoneCliente."</td>
					</tr>
					<tr>
						<td colspan='2'><strong>E-mail:</strong> ".$emailCliente."</td>
					</tr>
					<tr>
						<td colspan='2'><strong>Nova Senha:</strong> ".$senha."</td>
					</tr>
				</table>
			</div>
			<div style='width:588px; border-top:15px solid ".$cor2."; border-bottom: 2px solid #FF0000; margin-top:50px; height:85px;'>					
				<table style='float:left; width:480px; margin-top:10px;'>
					<tr>
						<td style='font-size:14px; color:#171614000; padding-bottom:20px;'><strong>".$nomeEmpresaMenor."</strong></td>
					</tr>				
					<tr>
						<td><a style='color:#900;' href='".$dominio."' title='".$dominioSem."'<font color='#900'>".$dominioSem."</font></a></td>
					</tr>
				</table>
				<table style='float:left;'>
					<td>
						<p style='padding:0; margin:0;'><a href='http://www.softbest.com.br/' title='www.softbest.com.br' target='_blank'><img style='border:none;' src='".$configUrl."f/i/logo-mail.png' alt='Imagem Softbest' /></a></p>
					</td>
				</table>
				<br style='clear:both;'/>	
			</div>
			<p style='text-align:center; font-size:12px;'>Este é um e-mail automático. Favor não o responda.</p>	
		</div>
	</body>
</html>";
?>
