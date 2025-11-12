<?php
	session_start();
	if($_COOKIE['codAprovado'.$cookie] == ""){
		if(!empty($_POST['email'])) {
			$sqlCliente = "SELECT * FROM clientes WHERE emailCliente = '".$_POST['email']."' AND senhaCliente = '".$_POST['senha']."'";
			$resultCliente = $conn->query($sqlCliente);
			$dadosCliente = $resultCliente->fetch_assoc();

			if($dadosCliente) {
				setcookie("clienteAprovado".$cookie, $dadosCliente['compraCliente'], time() + 3600, "/");
				setcookie("loginAprovado".$cookie, $dadosCliente['sobrenomeCliente'], time() + 3600, "/");
				setcookie("codAprovado".$cookie, $dadosCliente['codCliente'], time() + 3600, "/");
?>
				<div id="conteudo-interno" style="display: flex; justify-content: center; align-items: center; height: 615px;">
					<img src="<?php echo $configUrl.'f/i/quebrado/loading.svg'; ?>" width="100px" alt="">
				</div>
<?php
				if($_SESSION['salvaLocal'] != ""){
					$linkLocal = $_SESSION['salvaLocal'];
					$_SESSION['salvaLocal'] = "";
					echo "<meta HTTP-EQUIV='Refresh' CONTENT='0;URL=".$configUrl.$linkLocal."'>";
				}else{
					echo "<meta HTTP-EQUIV='Refresh' CONTENT='0;URL=".$configUrl."minha-conta/'>";
				}
			} else {
				$_SESSION['msg-login'] = '<p class="erro" style="color: red; font-weight: bold; margin-bottom: 0px;  left: 50%; transform: translateX(-50%); font-size:12px; position: absolute; bottom: 45px;">E-mail ou senha incorretos!</p>';
			}
		}
?>

		<div id="conteudo-interno">
			<div id="bloco-titulo">
				<p class="titulo">LOGIN</p>
			</div>
			<div id="repete-login">
				<div class="imagem">
					<img src="<?php echo $configUrl.'f/i/quebrado/4370811.jpg'; ?>" alt="img">
				</div>
				<div class="formulario">
					<p>Acesse Sua Conta</p>
					
					<form style="position: relative;" action="<?php echo $configUrl;?>minha-conta/login/" method="post">
						<label for="email">Seu Email</label>
						<div id="flex">
							<input type="email" id="email" name="email" required placeholder=" ex: Deivid@email.com" value="<?php echo $_SESSION['email'];?>">
						</div>
						
						<label for="senha">Sua Senha</label>
						<div id="flex">
							<input style="margin-bottom: 30px;" type="password" id="senha" name="senha" required placeholder="*******" value="<?php echo $_SESSION['senha'];?>">
						</div>
						<?php if(isset($_SESSION['msg-login'])){ echo $_SESSION['msg-login']; } ?>
						<?php if(isset($_SESSION['msg-recuperacao'])){ echo $_SESSION['msg-recuperacao']; } ?>
						<button type="submit">Login</button>
					</form>
					<div class="links">
						<a href="<?php echo $configUrl.'minha-conta/esqueci-minha-senha/' ?>">Esqueci minha senha</a> / <a href="<?php echo $configUrl.'minha-conta/cadastre-se/';?>">Cadastre-se</a>
					</div>
				</div>
			</div>
		</div>
		
<?php
		$_SESSION['msg-login'] = "";
		$_SESSION['msg-recuperacao'] = "";
	} else {
		echo "<meta HTTP-EQUIV='Refresh' CONTENT='0;URL=".$configUrl."minha-conta/'>";			
	}
?>
