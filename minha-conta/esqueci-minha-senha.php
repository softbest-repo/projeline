<?php 
	session_start();
?>
	<div id="conteudo-interno">
		<div id="conteudo-esqueci-minha-senha" style="position:relative;">
			<p class="botao-topo"><a href="<?php echo $configUrl;?>minha-conta/"> Voltar</a></p>
			<div id="bloco-titulo">
				<p class="titulo">ESQUECI MINHA SENHA</p>
			</div>
			<p class="botao-topo" style="position:absolute; top: 50px; right:0;"><a href="<?php echo $configUrl;?>minha-conta/login/"> Voltar</a></p>
			<div id="alinha"  style=" width: 50%; position: relative; z-index: 20; height:338px; background-color: #b5b5b52b; padding: 25px  0px; border-radius: 15px; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);">
				<form style="position: relative;" name="esqueci" action="<?php echo $configUrl;?>minha-conta/sendEmail-recuperacao.php" method="post" onSubmit="return confereErro(this);">
					<div class="imagem">
						<img src="<?php echo  $configUrl.'f/i/quebrado/rb_3864.png'; ?>" alt="img">
					</div>
					<div id="form" style="position: relative;"> 
						<p class="descricao"> Digite seu e-mail para lembrar sua senha. </p>

<?php if(isset($_SESSION['msg-recuperacao'])){ echo $_SESSION['msg-recuperacao']; } ?>

						<p class="campo-padrao"><label class="label">E-mail:<span class="obrigatorio">*</span></label><br/>
						<input class="input" type="email" required value="<?php echo $_SESSION['email'];?>" name="email" /></p>						
						<p class="campo-enviar">
							<input class="botao" type="submit" value="Recuperar minha Senha" name="recuperar" />
						</p>
					</div>
				</form>
			</div>
		</div>
	</div>
<?php 
	 $_SESSION['msg-recuperacao'] = "";
?>	
