<?php
	if($_COOKIE['loginAprovado'.$cookie] != ""){

		if($controleUsuario == "tem usuario"){
			
			$area = "projetosPersonalizados";
			include('f/conf/validaAcesso.php');
			if($validaAcesso == "ok"){

				$sqlNomeProjetoPersonalizado = "SELECT * FROM projetosPersonalizados WHERE codProjetoPersonalizado = '".$url[6]."'";
				$resultNomeProjetoPersonalizado = $conn->query($sqlNomeProjetoPersonalizado);
				$dadosNomeProjetoPersonalizado = $resultNomeProjetoPersonalizado->fetch_assoc();
?>	
				<div id="localizacao-topo">
					<div id="conteudo-localizacao-topo">
						<p class="nome-lista">Projetos</p>
						<p class="flexa"></p>
						<p class="nome-lista">Projetos Personalizados</p>
						<p class="flexa"></p>
						<p class="nome-lista">Imagens</p>
						<p class="flexa"></p>
						<p class="nome-lista"><?php echo $dadosNomeProjetoPersonalizado['nomeProjetoPersonalizado'] ;?></p>
						<br class="clear" />
					</div>
					<table class="tabela-interno" >
<?php
				if($dadosNomeProjetoPersonalizado['statusProjetoPersonalizado'] == "T"){
					$status = "status-ativo";
					$statusIcone = "ativado";
					$statusPergunta = "desativar";
				}else{
					$status = "status-desativado";
					$statusIcone = "desativado";
					$statusPergunta = "ativar";
				}		
?>	
						<tr class="tr-interno">
							<td class="botoes-interno"><a href='<?php echo $configUrl; ?>projetos/projetosPersonalizados/ativacao/<?php echo $dadosNomeProjetoPersonalizado['codProjetoPersonalizado'] ?>/' title='Deseja <?php echo $statusPergunta ?> o Projeto <?php echo $dadosNomeProjetoPersonalizado['nomeProjetoPersonalizado'] ?>?' ><img src="<?php echo $configUrl; ?>f/i/default/corpo-default/<?php echo $status ?>-branco.gif" alt="icone"></a></td>
							<td class="botoes-interno"><a href='<?php echo $configUrl; ?>projetos/projetosPersonalizados/alterar/<?php echo $dadosNomeProjetoPersonalizado['codProjetoPersonalizado'] ?>/' title='Deseja alterar o Projeto <?php echo $dadosNomeProjetoPersonalizado['nomeProjetoPersonalizado'] ?>?' ><img src="<?php echo $configUrl;?>f/i/default/corpo-default/icones-alterar-branco.gif" alt="icone" /></a></td>
							<td class="botoes-interno"><a href='javascript: confirmaExclusao(<?php echo $dadosNomeProjetoPersonalizado['codProjetoPersonalizado'] ?>, "<?php echo htmlspecialchars($dadosNomeProjetoPersonalizado['nomeProjetoPersonalizado']) ?>");' title='Deseja excluir o Projeto <?php echo $dadosNomeProjetoPersonalizado['nomeProjetoPersonalizado'] ?>?' ><img src='<?php echo $configUrl; ?>f/i/default/corpo-default/excluir-branco.gif' alt="icone"></a></td>
						</tr>
						<script>
							function confirmaExclusao(cod, nome){
								if(confirm("Deseja excluir a Projeto "+nome+"?")){
									window.location='<?php echo $configUrlGer; ?>projetos/projetosPersonalizados/excluir/'+cod+'/';
								}
							}
						 </script>
					</table>	
					<div class="botao-consultar"><a title="Consultar Projeto Personalizado" href="<?php echo $configUrl;?>projetos/projetosPersonalizados/"><div class="esquerda-consultar"></div><div class="conteudo-consultar">Consultar</div><div class="direita-consultar"></div></a></div>					
				</div>
				<div id="dados-conteudo">
					<div id="cadastrar">

<?php	
				if(isset($_POST['cadastrar'])){
					
					$exclusao = "";
					
					if($_POST['cont'] >  0){
												
						for($i=0; $i<=$_POST['cont']; $i++){
							$contadorDel = "excluir".$i;
							if(isset($_POST[$contadorDel])){
								$exclusao = "ok";
								$sqlConsultaDelete = "SELECT * FROM projetosPersonalizadosImagens WHERE codProjetoPersonalizadoImagem = ".$_POST[$contadorDel];
								$resultConsultaDelete = $conn->query($sqlConsultaDelete);
								$dadosConsultaDelete = $resultConsultaDelete->fetch_assoc();
								
								$sqlDelete = "DELETE FROM projetosPersonalizadosImagens WHERE codProjetoPersonalizadoImagem = ".$_POST[$contadorDel];
								$resultDelete = $conn->query($sqlDelete);
								if(file_exists("f/projetosPersonalizados/".$dadosConsultaDelete['codProjetoPersonalizado']."-".$dadosConsultaDelete['codProjetoPersonalizadoImagem']."-O.".$dadosConsultaDelete['extProjetoPersonalizadoImagem'])){
									unlink("f/projetosPersonalizados/".$dadosConsultaDelete['codProjetoPersonalizado']."-".$dadosConsultaDelete['codProjetoPersonalizadoImagem']."-O.".$dadosConsultaDelete['extProjetoPersonalizadoImagem']);
								}
							
								if($resultDelete == 1){
									$noErros = "ok";
								}
							}
						}
					}
					
					if($exclusao == ""){
						
						$pastaDestino = "f/projetosPersonalizados/";
											
						$file = $_FILES['imagem'];
						$ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
							
						if(in_array($ext, ['jpg', 'jpeg', 'png', 'svg'])){	
							
							$file_name = uniqid() . '.' . $ext;							
															
							$sqlProjetoPersonalizado = "SELECT * FROM projetosPersonalizados WHERE codProjetoPersonalizado = ".$url[6]." ORDER BY codProjetoPersonalizado DESC LIMIT 0,1";
							$resultProjetoPersonalizado = $conn->query($sqlProjetoPersonalizado);
							$dadosProjetoPersonalizado = $resultProjetoPersonalizado->fetch_assoc();
															
							$sql =  "INSERT INTO projetosPersonalizadosImagens VALUES(0, ".$url[6].", '', '".$ext."')";
							$result = $conn->query($sql);
													
							if($result == 1){
								
								$sqlNome = "SELECT * FROM projetosPersonalizadosImagens ORDER BY codProjetoPersonalizadoImagem DESC";
								$resultNome = $conn->query($sqlNome);
								$dadosNome = $resultNome->fetch_assoc();
								
								$codProjetoPersonalizadoImagem = $dadosNome['codProjetoPersonalizadoImagem'];
								$codProjetoPersonalizado = $dadosNome['codProjetoPersonalizado'];
								$nomeProjetoPersonalizadoImagem = $dadosNome['nomeProjetoPersonalizadoImagem'];
								
								move_uploaded_file($file['tmp_name'], $pastaDestino.$codProjetoPersonalizado."-".$codProjetoPersonalizadoImagem."-O.".$ext);
								
								chmod ($pastaDestino.$codProjetoPersonalizado."-".$codProjetoPersonalizadoImagem."-O.".$ext, 0755);
																
								$erroData = "<p class='erro'>Imagem cadastrado com sucesso!</p>";														
						
							}else{
								$erroData = "<p class='erro'>Problemas ao cadastrar imagem!</p>";
							}
									
						}else{
							$erroData = "<p class='erro'>Extenção não permitida ou imagem não selecionado!</p>";
						}				
					}else{
						$erroData = "<p class='erro'>Imagem excluída com sucesso!</p>";
					}				
				}
?>
<?php	
				if($erroData != "" || $erro == "sim" || $erro == "ok"){
?>

						<div class="area-erro">
<?php
					echo $erroData;
					if($erro == "sim" || $erro == "ok"){
						include('f/conf/mostraErro.php');
					}
?>
						</div>
<?php
				}
?>				

						<form action="<?php echo $configUrlGer; ?>projetos/projetosPersonalizados/imagens/<?php echo $url[6];?>/" enctype="multipart/form-data" method="post">
							<p class="aviso" style="color:#718B8F; margin-bottom:20px; font-size:15px;"><label style="color:#FF0000;">Observação:</label>As extensões permitidas estão listadas abaixo;<br/>Tamanho recomendado está listado abaixo;<br/>Para cadastrar imagens, clique em escolher arquivo e clique em salvar;<br/>A imagem será salva automaticamente;<br/>Para excluir as imagens, selecione a imagem e clique no botão Salvar;</p>
							
							<p class="bloco-campo"><label class="label" style="font-size:15px; line-height:20px; font-weight:normal;"><strong>Extensão:</strong> png, jpg, jpeg ou svg</labeL>
							<input class="campo" type="file" name="imagem" style="width:390px; margin-top:10px;" value="" /></p>
							
							<p class="bloco-campo"><div class="botao-expansivel"><p class="esquerda-botao"></p><input class="botao" type="submit" name="cadastrar" title="Salvar" value="Salvar" /><p class="direita-botao"></p></div></p>						
							<br class="clear"/>
							<br/>
							<br/>
							<div class="lista-imagens">
<?php
				$sqlRegistro = "SELECT * FROM projetosPersonalizadosImagens WHERE codProjetoPersonalizado = ".$url[6]."";
				$resultRegistro = $conn->query($sqlRegistro);
				$dadosRegistro = $resultRegistro->fetch_assoc();
				$registros = mysqli_num_rows($resultRegistro);
				
				  
				$pagina = $url[7];
				if($pagina == 1 || $pagina == "" ){
					$sqlConsulta = "SELECT * FROM projetosPersonalizadosImagens WHERE codProjetoPersonalizado = ".$url[6]." ORDER BY codProjetoPersonalizadoImagem ASC LIMIT 0, 14";
					$somaLimite = "14";
					$pgInicio = "0";		
				}else{
					$somaLimite = $pagina * 14;
					$pgInicio = $somaLimite - 14;
					$sqlConsulta = "SELECT * FROM projetosPersonalizadosImagens WHERE codProjetoPersonalizado = ".$url[6]." ORDER BY codProjetoPersonalizadoImagem ASC LIMIT ".$pgInicio.", 14";
				}

				$cont = 0;

				$resultConsulta = $conn->query($sqlConsulta);
				while($dadosImagem = $resultConsulta->fetch_assoc()){
					$mostrando = $mostrando + 1;		
?>       
								<div class="imagem" style="width:200px; height:200px; margin-right:30px;">
									<p style="width:200px; height:142px; display:table-cell; vertical-align:middle;"><img src="<?php echo $configUrl."f/projetosPersonalizados/".$dadosImagem['codProjetoPersonalizado'].'-'.$dadosImagem['codProjetoPersonalizadoImagem'].'-O.'.$dadosImagem['extProjetoPersonalizadoImagem'];?>" width="100" alt="Imagem ProjetoPersonalizado"/><br/></p>
									<label><input type="checkbox" name="excluir<?php echo $cont; ?>" value="<?php echo $dadosImagem['codProjetoPersonalizadoImagem']; ?>" /> Excluir</label>
								</div>			
<?php
					$cont = $cont + 1;
				}
?>
								<input type="hidden" name="cont" value="<?php echo $cont; ?>" />
							</div>
						</form>
					</div>
					<br class="clear" />
					<br/>
 <?php
				if($erro == "ok"){
					$_SESSION['erroDados'] = ""; 
					
					
				}
				$regPorPag = 14;
				$area = "projetos/projetosPersonalizados/imagens/".$url[6];
				include('f/conf/paginacao-imagens.php');
?>
				</div>
<?php
			}else{
?>	
				<div id="filtro">
					<div id="erro-permicao">	
<?php
				echo "<p><strong>Você não tem permissão para acessar essa área!</strong></p>";
				echo "<p>Para mais informações entre em contato com o administrador!</p>";
?>	
					</div>
				</div>
<?php
			}

		}else{
			echo "<meta HTTP-EQUIV='Refresh' CONTENT='0;URL=".$configUrl."controle-acesso.php'>";
		}

	}else{
		echo "<meta HTTP-EQUIV='Refresh' CONTENT='0;URL=".$configUrl."login.php'>";
	}
?>
