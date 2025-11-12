<?php
	if($_COOKIE['loginAprovado'.$cookie] != ""){

		if($controleUsuario == "tem usuario"){
			
			$area = "depoimentos";
			include('f/conf/validaAcesso.php');
			if($validaAcesso == "ok"){

				$sqlNomeDepoimento = "SELECT * FROM depoimentos WHERE codDepoimento = '".$url[6]."'";
				$resultNomeDepoimento = $conn->query($sqlNomeDepoimento);
				$dadosNomeDepoimento = $resultNomeDepoimento->fetch_assoc();
?>	
				<div id="localizacao-topo">
					<div id="conteudo-localizacao-topo">
						<p class="nome-lista">Cadastros</p>
						<p class="flexa"></p>
						<p class="nome-lista">Depoimentos</p>
						<p class="flexa"></p>
						<p class="nome-lista">Imagens</p>
						<p class="flexa"></p>
						<p class="nome-lista"><?php echo $dadosNomeDepoimento['nomeDepoimento'] ;?></p>
						<br class="clear" />
					</div>
					<table class="tabela-interno" >
<?php
				if($dadosNomeDepoimento['statusDepoimento'] == "T"){
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
							<td class="botoes-interno"><a href='<?php echo $configUrl; ?>cadastros/depoimentos/ativacao/<?php echo $dadosNomeDepoimento['codDepoimento'] ?>/' title='Deseja <?php echo $statusPergunta ?> o depoimento <?php echo $dadosNomeDepoimento['nomeDepoimento'] ?>?' ><img src="<?php echo $configUrl; ?>f/i/default/corpo-default/<?php echo $status ?>-branco.gif" alt="icone"></a></td>
							<td class="botoes-interno"><a href='<?php echo $configUrl; ?>cadastros/depoimentos/alterar/<?php echo $dadosNomeDepoimento['codDepoimento'] ?>/' title='Deseja alterar o depoimento <?php echo $dadosNomeDepoimento['nomeDepoimento'] ?>?' ><img src="<?php echo $configUrl;?>f/i/default/corpo-default/icones-alterar-branco.gif" alt="icone" /></a></td>
							<td class="botoes-interno"><a href='javascript: confirmaExclusao(<?php echo $dadosNomeDepoimento['codDepoimento'] ?>, "<?php echo htmlspecialchars($dadosNomeDepoimento['nomeDepoimento']) ?>");' title='Deseja excluir o depoimento <?php echo $dadosNomeDepoimento['nomeDepoimento'] ?>?' ><img src='<?php echo $configUrl; ?>f/i/default/corpo-default/excluir-branco.gif' alt="icone"></a></td>
						</tr>
						<script>
							function confirmaExclusao(cod, nome){
								if(confirm("Deseja excluir o depoimento "+nome+"?")){
									window.location='<?php echo $configUrlGer; ?>cadastros/depoimentos/excluir/'+cod+'/';
								}
							}
						 </script>
					</table>	
					<div class="botao-consultar"><a title="Consultar Depoimentos" href="<?php echo $configUrl;?>cadastros/depoimentos/"><div class="esquerda-consultar"></div><div class="conteudo-consultar">Consultar</div><div class="direita-consultar"></div></a></div>					
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
								$sqlConsultaDelete = "SELECT * FROM depoimentosImagens WHERE codDepoimentoImagem = ".$_POST[$contadorDel];
								$resultConsultaDelete = $conn->query($sqlConsultaDelete);
								$dadosConsultaDelete = $resultConsultaDelete->fetch_assoc();
								
								$sqlDelete = "DELETE FROM depoimentosImagens WHERE codDepoimentoImagem = ".$_POST[$contadorDel];
								$resultDelete = $conn->query($sqlDelete);
								if(file_exists("f/depoimentos/".$dadosConsultaDelete['codDepoimento']."-".$dadosConsultaDelete['codDepoimentoImagem']."-O.".$dadosConsultaDelete['extDepoimentoImagem'])){
									unlink("f/depoimentos/".$dadosConsultaDelete['codDepoimento']."-".$dadosConsultaDelete['codDepoimentoImagem']."-O.".$dadosConsultaDelete['extDepoimentoImagem']);
									unlink("f/depoimentos/".$dadosConsultaDelete['codDepoimento']."-".$dadosConsultaDelete['codDepoimentoImagem']."-W.webp");
								}
							
								if($resultDelete == 1){
									$noErros = "ok";
								}
							}
						}
					}
					
					if($exclusao == ""){
						
						$pastaDestino = "f/depoimentos/";
											
						$file = $_FILES['imagem'];
						$ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
							
						if(in_array($ext, ['jpg', 'jpeg', 'png', 'gif'])){	
							
							$file_name = uniqid() . '.' . $ext;							
															
							$sqlDepoimento = "SELECT * FROM depoimentos WHERE codDepoimento = ".$url[6]." ORDER BY codDepoimento DESC LIMIT 0,1";
							$resultDepoimento = $conn->query($sqlDepoimento);
							$dadosDepoimento = $resultDepoimento->fetch_assoc();
															
							$sql =  "INSERT INTO depoimentosImagens VALUES(0, ".$url[6].", '', '".$ext."')";
							$result = $conn->query($sql);
													
							if($result == 1){

								function saveWebPImage($original_image, $new_image_path, $quality = 100) {
									if (imagewebp($original_image, $new_image_path, $quality)) {
										return true;
									} else {
										return false;
									}
								}
																
								$sqlNome = "SELECT * FROM depoimentosImagens ORDER BY codDepoimentoImagem DESC";
								$resultNome = $conn->query($sqlNome);
								$dadosNome = $resultNome->fetch_assoc();
								
								$codDepoimentoImagem = $dadosNome['codDepoimentoImagem'];
								$codDepoimento = $dadosNome['codDepoimento'];
								$nomeDepoimentoImagem = $dadosNome['nomeDepoimentoImagem'];
								
								move_uploaded_file($file['tmp_name'], $pastaDestino.$codDepoimento."-".$codDepoimentoImagem."-O.".$ext);
								
								chmod ($pastaDestino.$codDepoimento."-".$codDepoimentoImagem."-O.".$ext, 0755);
																
								$imagemWebP = $pastaDestino.$codDepoimento."-".$codDepoimentoImagem."-W.webp";

								switch ($ext) {
									case 'jpg':
									case 'jpeg':
									$original_image = imagecreatefromjpeg($pastaDestino.$codDepoimento."-".$codDepoimentoImagem."-O.".$ext);
									break;
									case 'png':
									$original_image = imagecreatefrompng($pastaDestino.$codDepoimento."-".$codDepoimentoImagem."-O.".$ext);
									break;
									case 'gif':
									$original_image = imagecreatefromgif($pastaDestino.$codDepoimento."-".$codDepoimentoImagem."-O.".$ext);
									break;
								}

								saveWebPImage($original_image, $imagemWebP, 95);

								imagedestroy($original_image);

								chmod ($pastaDestino.$codDepoimento."-".$codDepoimentoImagem."-W.webp", 0755);								
														
								$erroData = "<p class='erro'>Imagem cadastrada com sucesso!</p>";														
						
							}else{
								$erroData = "<p class='erro'>Problemas ao cadastrar imagem!</p>";
							}
									
						}else{
							$erroData = "<p class='erro'>Extenção não permitida ou imagem não selecionada!</p>";
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

						<form action="<?php echo $configUrlGer; ?>cadastros/depoimentos/imagens/<?php echo $url[6];?>/" enctype="multipart/form-data" method="post">
							<p class="aviso" style="color:#718B8F; margin-bottom:20px; font-size:15px;"><label style="color:#FF0000;">Observação:</label>As extensões permitidas estão listadas abaixo;<br/>Tamanho recomendado está listado abaixo;<br/>Para cadastrar imagens, clique em escolher arquivo e selecione uma ou mais imagens e clique em salvar;<br/>As imagens são salvas automaticamente;<br/>Para excluir as imagens, selecione a imagem e clique no botão excluir;</p>
							
							<p class="bloco-campo"><label class="label" style="font-size:15px; line-height:20px; font-weight:normal;"><strong>Extensão:</strong> png, jpg ou jpeg<br/><strong>Tamanho:</strong> 500px x 500px</labeL>
							<input class="campo" type="file" name="imagem" style="width:400px; margin-top:10px;" value="" /></p>
							
							<p class="bloco-campo"><div class="botao-expansivel"><p class="esquerda-botao"></p><input class="botao" type="submit" name="cadastrar" title="Salvar" value="Salvar" /><p class="direita-botao"></p></div></p>						
							<br class="clear"/>
							<br/>
							<br/>
							<div class="lista-imagens">
<?php
				$sqlRegistro = "SELECT * FROM depoimentosImagens WHERE codDepoimento = ".$url[6]."";
				$resultRegistro = $conn->query($sqlRegistro);
				$dadosRegistro = $resultRegistro->fetch_assoc();
				$registros = mysqli_num_rows($resultRegistro);
				
				  
				$pagina = $url[7];
				if($pagina == 1 || $pagina == "" ){
					$sqlConsulta = "SELECT * FROM depoimentosImagens WHERE codDepoimento = ".$url[6]." ORDER BY codDepoimentoImagem ASC LIMIT 0, 14";
					$somaLimite = "14";
					$pgInicio = "0";		
				}else{
					$somaLimite = $pagina * 14;
					$pgInicio = $somaLimite - 14;
					$sqlConsulta = "SELECT * FROM depoimentosImagens WHERE codDepoimento = ".$url[6]." ORDER BY codDepoimentoImagem ASC LIMIT ".$pgInicio.", 14";
				}

				$cont = 0;

				$resultConsulta = $conn->query($sqlConsulta);
				while($dadosImagem = $resultConsulta->fetch_assoc()){
					$mostrando = $mostrando + 1;		
?>       
								<div class="imagem" style="width:300px; height:200px; margin-right:30px;">
									<p style="width:300px; height:142px; display:table-cell; vertical-align:middle;"><img src="<?php echo $configUrl."f/depoimentos/".$dadosImagem['codDepoimento'].'-'.$dadosImagem['codDepoimentoImagem'].'-W.webp';?>" alt="Imagem Depoimento" width="300"/><br/></p>
									<label><input type="checkbox" name="excluir<?php echo $cont; ?>" value="<?php echo $dadosImagem['codDepoimentoImagem']; ?>" /> Excluir</label>
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
				$area = "cadastros/depoimentos/imagens/".$url[6];
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
