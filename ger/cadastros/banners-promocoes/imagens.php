<?php
	if($_COOKIE['loginAprovado'.$cookie] != ""){

		if($controleUsuario == "tem usuario"){
			
			$area = "banners-promocoes";
			include('f/conf/validaAcesso.php');
			if($validaAcesso == "ok"){

				$sqlNomeBannerPromocao = "SELECT * FROM bannersPromocoes WHERE codBannerPromocao = '".$url[6]."'";
				$resultNomeBannerPromocao = $conn->query($sqlNomeBannerPromocao);
				$dadosNomeBannerPromocao = $resultNomeBannerPromocao->fetch_assoc();
?>	
				<div id="localizacao-topo">
					<div id="conteudo-localizacao-topo">
						<p class="nome-lista">Cadastros</p>
						<p class="flexa"></p>
						<p class="nome-lista">Banner Promocao Capa</p>
						<p class="flexa"></p>
						<p class="nome-lista">Imagens</p>
						<p class="flexa"></p>
						<p class="nome-lista"><?php echo $dadosNomeBannerPromocao['nomeBannerPromocao'] ;?></p>
						<br class="clear" />
					</div>
					<table class="tabela-interno" >
<?php
				if($dadosNomeBannerPromocao['statusBannerPromocao'] == "T"){
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
							<td class="botoes-interno"><a href='<?php echo $configUrl; ?>cadastros/banners-promocoes/ativacao/<?php echo $dadosNomeBannerPromocao['codBannerPromocao'] ?>/' title='Deseja <?php echo $statusPergunta ?> o banner capa <?php echo $dadosNomeBannerPromocao['nomeBannerPromocao'] ?>?' ><img src="<?php echo $configUrl; ?>f/i/default/corpo-default/<?php echo $status ?>-branco.gif" alt="icone"></a></td>
							<td class="botoes-interno"><a href='<?php echo $configUrl; ?>cadastros/banners-promocoes/alterar/<?php echo $dadosNomeBannerPromocao['codBannerPromocao'] ?>/' title='Deseja alterar o banner capa <?php echo $dadosNomeBannerPromocao['nomeBannerPromocao'] ?>?' ><img src="<?php echo $configUrl;?>f/i/default/corpo-default/icones-alterar-branco.gif" alt="icone" /></a></td>
							<td class="botoes-interno"><a href='javascript: confirmaExclusao(<?php echo $dadosNomeBannerPromocao['codBannerPromocao'] ?>, "<?php echo htmlspecialchars($dadosNomeBannerPromocao['nomeBannerPromocao']) ?>");' title='Deseja excluir o banner capa <?php echo $dadosNomeBannerPromocao['nomeBannerPromocao'] ?>?' ><img src='<?php echo $configUrl; ?>f/i/default/corpo-default/excluir-branco.gif' alt="icone"></a></td>
						</tr>
						<script>
							function confirmaExclusao(cod, nome){
								if(confirm("Deseja excluir o banner capa "+nome+"?")){
									window.location='<?php echo $configUrlGer; ?>cadastros/banners-promocoes/excluir/'+cod+'/';
								}
							}
						 </script>
					</table>	
					<div class="botao-consultar"><a title="Consultar BannerPromocaos Capa" href="<?php echo $configUrl;?>cadastros/banners-promocoes/"><div class="esquerda-consultar"></div><div class="conteudo-consultar">Consultar</div><div class="direita-consultar"></div></a></div>					
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
								$sqlConsultaDelete = "SELECT * FROM bannersPromocoesImagens WHERE codBannerPromocaoImagem = ".$_POST[$contadorDel];
								$resultConsultaDelete = $conn->query($sqlConsultaDelete);
								$dadosConsultaDelete = $resultConsultaDelete->fetch_assoc();
								
								$sqlDelete = "DELETE FROM bannersPromocoesImagens WHERE codBannerPromocaoImagem = ".$_POST[$contadorDel];
								$resultDelete = $conn->query($sqlDelete);
								if(file_exists("f/banners-promocoes/".$dadosConsultaDelete['codBannerPromocao']."-".$dadosConsultaDelete['codBannerPromocaoImagem']."-O.".$dadosConsultaDelete['extBannerPromocaoImagem'])){
									unlink("f/banners-promocoes/".$dadosConsultaDelete['codBannerPromocao']."-".$dadosConsultaDelete['codBannerPromocaoImagem']."-O.".$dadosConsultaDelete['extBannerPromocaoImagem']);
									unlink("f/banners-promocoes/".$dadosConsultaDelete['codBannerPromocao']."-".$dadosConsultaDelete['codBannerPromocaoImagem']."-W.webp");
									unlink("f/banners-promocoes/".$dadosConsultaDelete['codBannerPromocao']."-".$dadosConsultaDelete['codBannerPromocaoImagem']."-G.webp");
									unlink("f/banners-promocoes/".$dadosConsultaDelete['codBannerPromocao']."-".$dadosConsultaDelete['codBannerPromocaoImagem']."-M.webp");
									unlink("f/banners-promocoes/".$dadosConsultaDelete['codBannerPromocao']."-".$dadosConsultaDelete['codBannerPromocaoImagem']."-P.webp");
								}
							
								if($resultDelete == 1){
									$noErros = "ok";
								}
							}
						}
					}
					
					if($exclusao == ""){					

						function saveWebPImage($original_image, $new_image_path, $quality = 100) {
							if (imagewebp($original_image, $new_image_path, $quality)) {
								return true;
							} else {
								return false;
							}
						}

						function resizeImage($original_image, $width, $height, $destination_path, $quality = 90) {
							$resized_image = imagecreatetruecolor($width, $height);
							imagecopyresampled($resized_image, $original_image, 0, 0, 0, 0, $width, $height, imagesx($original_image), imagesy($original_image));
							saveWebPImage($resized_image, $destination_path, $quality);
							imagedestroy($resized_image);
						}

						$pastaDestino = "f/banners-promocoes/";

						$file = $_FILES['imagem'];
						$ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));

						if (in_array($ext, ['jpg', 'jpeg', 'png', 'gif'])) {	
							
							$file_name = uniqid() . '.' . $ext;							
							
							$sqlBannerPromocao = "SELECT * FROM bannersPromocoes WHERE codBannerPromocao = ".$url[6]." ORDER BY codBannerPromocao DESC LIMIT 0,1";
							$resultBannerPromocao = $conn->query($sqlBannerPromocao);
							$dadosBannerPromocao = $resultBannerPromocao->fetch_assoc();
							
							$sql =  "INSERT INTO bannersPromocoesImagens VALUES(0, ".$url[6].", '', '".$ext."')";
							$result = $conn->query($sql);
							
							if ($result == 1) {
								
								$sqlNome = "SELECT * FROM bannersPromocoesImagens ORDER BY codBannerPromocaoImagem DESC";
								$resultNome = $conn->query($sqlNome);
								$dadosNome = $resultNome->fetch_assoc();
								
								$codBannerPromocaoImagem = $dadosNome['codBannerPromocaoImagem'];
								$codBannerPromocao = $dadosNome['codBannerPromocao'];
								$nomeBannerPromocaoImagem = $dadosNome['nomeBannerPromocaoImagem'];
								
								move_uploaded_file($file['tmp_name'], $pastaDestino.$codBannerPromocao."-".$codBannerPromocaoImagem."-O.".$ext);
								
								chmod($pastaDestino.$codBannerPromocao."-".$codBannerPromocaoImagem."-O.".$ext, 0755);

								$imagemWebP = $pastaDestino.$codBannerPromocao."-".$codBannerPromocaoImagem."-W.webp";
								
								switch ($ext) {
									case 'jpg':
									case 'jpeg':
										$original_image = imagecreatefromjpeg($pastaDestino.$codBannerPromocao."-".$codBannerPromocaoImagem."-O.".$ext);
										break;
									case 'png':
										$original_image = imagecreatefrompng($pastaDestino.$codBannerPromocao."-".$codBannerPromocaoImagem."-O.".$ext);
										break;
									case 'gif':
										$original_image = imagecreatefromgif($pastaDestino.$codBannerPromocao."-".$codBannerPromocaoImagem."-O.".$ext);
										break;
								}

								$original_width = imagesx($original_image);
								$original_height = imagesy($original_image);

								if ($original_width >= 1920 && $original_height >= 1080) {
									resizeImage($original_image, 1920, 1080, $pastaDestino.$codBannerPromocao."-".$codBannerPromocaoImagem."-G.webp");
								}
								if ($original_width >= 1080 && $original_height >= 1080) {
									resizeImage($original_image, 1080, 1080, $pastaDestino.$codBannerPromocao."-".$codBannerPromocaoImagem."-M.webp");
								}
								if ($original_width >= 640 && $original_height >= 360) {
									resizeImage($original_image, 640, 360, $pastaDestino.$codBannerPromocao."-".$codBannerPromocaoImagem."-P.webp");
								}

								saveWebPImage($original_image, $imagemWebP, 95);
								imagedestroy($original_image);

								chmod($pastaDestino.$codBannerPromocao."-".$codBannerPromocaoImagem."-W.webp", 0755);								
								
								$erroData = "<p class='erro'>Imagem cadastrada com sucesso!</p>";
							
							} else {
								$erroData = "<p class='erro'>Problemas ao cadastrar imagem!</p>";
							}
								
						} else {
							$erroData = "<p class='erro'>Extensão não permitida ou imagem não selecionada!</p>";
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

						<form action="<?php echo $configUrlGer; ?>cadastros/banners-promocoes/imagens/<?php echo $url[6];?>/" enctype="multipart/form-data" method="post">
							<p class="aviso" style="color:#718B8F; margin-bottom:20px; font-size:15px;"><label style="color:#FF0000;">Observação:</label>As extensões permitidas estão listadas abaixo;<br/>Tamanho recomendado está listado abaixo;<br/>Para cadastrar imagens, clique em escolher arquivo e selecione uma ou mais imagens e clique em salvar;<br/>As imagens são salvas automaticamente;<br/>Para excluir as imagens, selecione a imagem e clique no botão excluir;</p>

							<p class="aviso" style="color:#718B8F; margin-bottom:20px; font-size:15px;"><label style="color:#FF0000;">Importante:</label>A primeira imagem cadastrada será mostrada na Versão Desktop e a segunda será mostrada na versão Mobile.</p>
							
							<p class="bloco-campo"><label class="label" style="font-size:15px; line-height:20px; font-weight:normal;"><strong>Extensão:</strong> png,jpg ou jpeg<br/><strong>Tamanho Desktop:</strong> 2560 x 1440 | <strong>Tamanho Mobile:</strong> 1080 x 1080</labeL>
							<input class="campo" type="file" name="imagem" style="width:390px; margin-top:10px;" value="" /></p>
							
							<p class="bloco-campo"><div class="botao-expansivel"><p class="esquerda-botao"></p><input class="botao" type="submit" name="cadastrar" title="Salvar" value="Salvar" /><p class="direita-botao"></p></div></p>						
							<br class="clear"/>
							<br/>
							<br/>
							<div class="lista-imagens">
<?php
				$sqlRegistro = "SELECT * FROM bannersPromocoesImagens WHERE codBannerPromocao = ".$url[6]."";
				$resultRegistro = $conn->query($sqlRegistro);
				$dadosRegistro = $resultRegistro->fetch_assoc();
				$registros = mysqli_num_rows($resultRegistro);
				
				  
				$pagina = $url[7];
				if($pagina == 1 || $pagina == "" ){
					$sqlConsulta = "SELECT * FROM bannersPromocoesImagens WHERE codBannerPromocao = ".$url[6]." ORDER BY codBannerPromocaoImagem ASC LIMIT 0, 14";
					$somaLimite = "14";
					$pgInicio = "0";		
				}else{
					$somaLimite = $pagina * 14;
					$pgInicio = $somaLimite - 14;
					$sqlConsulta = "SELECT * FROM bannersPromocoesImagens WHERE codBannerPromocao = ".$url[6]." ORDER BY codBannerPromocaoImagem ASC LIMIT ".$pgInicio.", 14";
				}

				$cont = 0;

				$resultConsulta = $conn->query($sqlConsulta);
				while($dadosImagem = $resultConsulta->fetch_assoc()){
					$mostrando = $mostrando + 1;		
?>       
								<div class="imagem" style="width:300px; height:200px; margin-right:30px;">
									<p style="width:300px; height:150px; display:table-cell; vertical-align:middle;"><img src="<?php echo $configUrl."f/banners-promocoes/".$dadosImagem['codBannerPromocao'].'-'.$dadosImagem['codBannerPromocaoImagem'].'-W.webp';?>" alt="Imagem BannerPromocao" style="max-width:300px; max-height:150px;"/><br/></p>
									<label><input type="checkbox" name="excluir<?php echo $cont; ?>" value="<?php echo $dadosImagem['codBannerPromocaoImagem']; ?>" /> Excluir</label>
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
				$area = "cadastros/banners-promocoes/imagens/".$url[6];
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
