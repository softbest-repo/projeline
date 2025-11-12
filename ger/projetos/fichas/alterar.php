<?php
	if($_COOKIE['loginAprovado'.$cookie] != ""){

		if($controleUsuario == "tem usuario"){
			
			$area = "fichas";
			include('f/conf/validaAcesso.php');
			if($validaAcesso == "ok"){

				$sqlNomePagamento = "SELECT codFicha, nomeFicha, statusFicha FROM fichas WHERE codFicha = '".$url[6]."' LIMIT 0,1";
				$resultNomePagamento = $conn->query($sqlNomePagamento);
				$dadosNomePagamento = $resultNomePagamento->fetch_assoc();
?>
				<div id="localizacao-topo">
					<div id="conteudo-localizacao-topo">
						<p class="nome-lista">Projeto(s)</p>
						<p class="flexa"></p>
						<p class="nome-lista">Ficha Técnica</p>
						<p class="flexa"></p>
						<p class="nome-lista">Alterar</p>
						<p class="flexa"></p>
						<p class="nome-lista"><?php echo $dadosNomePagamento['nomeFicha'] ;?></p>
						<br class="clear" />
					</div>
					<table class="tabela-interno" >
<?php
				if($dadosNomePagamento['statusFicha'] == "T"){
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
							<td class="botoes-interno"><a href='<?php echo $configUrl; ?>projetos/fichas/ativacao/<?php echo $dadosNomePagamento['codFicha'] ?>/' title='Deseja <?php echo $statusPergunta ?> o tamanho <?php echo $dadosNomePagamento['nomeFicha'] ?>?' ><img src="<?php echo $configUrl; ?>f/i/default/corpo-default/<?php echo $status ?>-branco.gif" alt="icone"></a></td>
							<td class="botoes-interno"><a href='javascript: confirmaExclusao(<?php echo $dadosNomePagamento['codFicha'] ?>, "<?php echo htmlspecialchars($dadosNomePagamento['nomeFicha']) ?>");' title='Deseja excluir o tamanho <?php echo $dadosNomePagamento['nomeFicha'] ?>?' ><img src='<?php echo $configUrl; ?>f/i/default/corpo-default/excluir-branco.gif' alt="icone"></a></td>
						</tr>
						<script>
							function confirmaExclusao(cod, nome){

								if(confirm("Deseja excluir o tamanho "+nome+"?")){
									window.location='<?php echo $configUrlGer; ?>projetos/fichas/excluir/'+cod+'/';
								}
							}
						</script>
					</table>	
					<div class="botao-consultar"><a title="Consultar Fichas" href="<?php echo $configUrl;?>projetos/fichas/"><div class="esquerda-consultar"></div><div class="conteudo-consultar">Consultar</div><div class="direita-consultar"></div></a></div>					
				</div>
				<div id="dados-conteudo">
					<div id="cadastrar">
<?php
				if(isset($_POST['alterar'])){

					include ('f/conf/criaUrl.php');
					$urlFicha = criaUrl($_POST['nome']);
																	
					$sql = "UPDATE fichas SET nomeFicha = '".preparaNome($_POST['nome'])."', urlFicha = '".$urlFicha."' WHERE codFicha = '".$url[6]."'";
					$result = $conn->query($sql);
					
					if($result == 1){

						$sqlDeleta = "DELETE FROM projetosFichas WHERE codFicha = ".$url[6]."";
						$resultDeleta = $conn->query($sqlDeleta);
						
						for($i=1; $i<=$_POST['total-opcoesFichas']; $i++){
							if($_POST['opcoesFichas'.$i] != ""){
								
								$sqlInsere = "INSERT INTO projetosFichas VALUES(0, ".$url[6].", ".$_POST['opcoesFichas'.$i].")";
								$resultInsere = $conn->query($sqlInsere);
								
							}
						}
					}	
					
					if($result == 1){
						$_SESSION['nome'] = $_POST['nome'];
						$_SESSION['alteracao'] = "ok";
						echo "<meta HTTP-EQUIV='Refresh' CONTENT='0;URL=".$configUrlGer."projetos/fichas/'>";
					}else{
						$erroData = "<p class='erro'>Problemas ao alterar Ficha!</p>";
					}
				}else{
					$sql = "SELECT * FROM fichas WHERE codFicha = ".$url[6];
					$result = $conn->query($sql);
					$dadosFicha = $result->fetch_assoc();
					$_SESSION['nome'] = $dadosFicha['nomeFicha'];
					$_SESSION[''] = $dadosFicha['nomeFicha'];

				}

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
				$sqlProjetoTamanhoT = "SELECT codProjetoFicha FROM projetosFichas WHERE codFicha = ".$url[6];
				$resultProjetoTamanhoT = $conn->query($sqlProjetoTamanhoT);
				$total = $resultProjetoTamanhoT->num_rows;
				
				

?>				


					
						<div class="botao-editar"><a title="Editar" href="javascript:habilitaCampo();"><div class="esquerda-editar"></div><div class="conteudo-editar">Editar</div><div class="direita-editar"></div></a></div>					
						<p class="obrigatorio">Campos obrigatórios *</p> 
						<br/>
						<script>
							function habilitaCampo(){
								document.getElementById("nome").disabled = false;
<?php 
	if($total >= 1){
						
		$cont = 0;
			
		$sqlProjetoOpcaoFicha = "SELECT * FROM projetosFichas WHERE codFicha = ".$url[6]." ORDER BY codProjetoFicha ASC";
		$resultProjetoOpcaoFicha = $conn->query($sqlProjetoOpcaoFicha);
		while($dadosProjetoOpcaoFicha = $resultProjetoOpcaoFicha->fetch_assoc()){						

		$cont++;
?>
								document.getElementById("opcoesFichas<?php echo $cont;?>").disabled = false;
<?php
	}
	}else{
?>
								document.getElementById("opcoesFichas1").disabled = false;
<?php
	}
?>
								document.getElementById("alterar").disabled = false;
								

							}
						</script>  
						<form action="<?php echo $configUrlGer; ?>projetos/fichas/alterar/<?php echo $url[6] ;?>/" method="post">
							<p class="bloco-campo"><label>Nome: <span class="obrigatorio"> * </span></label>
							<input id="nome" <?php echo $erroAtiva == "ok" ? "" : "disabled='disabled'";?> required class="campo" type="text" name="nome" style="width:300px;" value="<?php echo $_SESSION['nome']; ?>" /></p>




							<div id="bloco-opcoesFichas" style="margin-top:10px; margin-bottom:20px;">
								<script type="text/javascript">
									function novaOpcaoFicha(){
										var pegaTotalOpcaoFicha = document.getElementById("total-opcoesFichas").value;
										var somaPegaTotalOpcaoFicha = parseInt(pegaTotalOpcaoFicha) + 1;
										
										var novadiv = document.createElement('div');
										novadiv.setAttribute('id', "bloco-opcoesFichas"+somaPegaTotalOpcaoFicha);							
										document.getElementById("bloco-novo").appendChild(novadiv);	
										
<?php 
										$sqlOpcaoFicha = "SELECT nomeOpcaoFicha, codOpcaoFicha FROM opcoesFichas WHERE statusOpcaoFicha = 'T' ORDER BY nomeOpcaoFicha ASC";
										$resultOpcaoFicha = $conn->query($sqlOpcaoFicha);
?>
																
										document.getElementById("bloco-opcoesFichas"+somaPegaTotalOpcaoFicha).innerHTML += "<p class='bloco-campo'><label>OpcaoFicha:</label><select class='campo' name='opcoesFichas"+somaPegaTotalOpcaoFicha+"' style='width:320px;'><option value=''>Selecione</option><?php while($dadosOpcaoFicha = $resultOpcaoFicha->fetch_assoc()){?><option value='<?php echo $dadosOpcaoFicha['codOpcaoFicha'];?>'><?php echo $dadosOpcaoFicha['nomeOpcaoFicha'];?></option><?php } ?></select></p>";
										document.getElementById("total-opcoesFichas").value=somaPegaTotalOpcaoFicha;						
									}
								</script>
							
								<div id="bloco-novo">
<?php				 
				if($total >= 1){ 
					
					$cont = 0;
					
					$sqlProjetoOpcaoFicha = "SELECT * FROM projetosFichas WHERE codFicha = ".$url[6]." ORDER BY codOpcaoFicha ASC";
					$resultProjetoOpcaoFicha = $conn->query($sqlProjetoOpcaoFicha);
					while($dadosProjetoOpcaoFicha = $resultProjetoOpcaoFicha->fetch_assoc()){	
						
						
						$cont++;				
?>
									<div id="bloco-opcoesFichas<?php echo $cont;?>">	
										<p class="bloco-campo"><label>OpcaoFicha:<span class="obrigatorio"> * </span></label>
											<select class="campo" name="opcoesFichas<?php echo $cont;?>" id="opcoesFichas<?php echo $cont;?>" <?php echo $erroAtiva == "ok" ? "" : "disabled='disabled'";?> style="width:320px;">
												<option value="">Selecione</option>
<?php
						$sqlOpcaoFicha = "SELECT nomeOpcaoFicha, codOpcaoFicha FROM opcoesFichas WHERE statusOpcaoFicha = 'T' ORDER BY nomeOpcaoFicha ASC";
						$resultOpcaoFicha = $conn->query($sqlOpcaoFicha);
						while($dadosOpcaoFicha = $resultOpcaoFicha->fetch_assoc()){
?>					
												<option value="<?php echo $dadosOpcaoFicha['codOpcaoFicha'];?>" <?php echo $dadosProjetoOpcaoFicha['codOpcaoFicha'] == $dadosOpcaoFicha['codOpcaoFicha'] ? "/SELECTED/" : "";?>><?php echo $dadosOpcaoFicha['nomeOpcaoFicha'];?></option>
<?php
						}
?>
											</select>
										</p>
									</div>	
<?php
					}
				}else{
?>
									<div id="bloco-opcoesFichas1">	
										<p class="bloco-campo"><label>OpcaoFicha:<span class="obrigatorio"> * </span></label>
											<select class="campo" name="opcoesFichas1" id="opcoesFichas1" required <?php echo $erroAtiva == "ok" ? "" : "disabled='disabled'";?> style="width:320px;">
												<option value="">Selecione</option>
<?php
					$sqlOpcaoFicha = "SELECT nomeOpcaoFicha, codOpcaoFicha FROM opcoesFichas WHERE statusOpcaoFicha = 'T' ORDER BY nomeOpcaoFicha ASC";
					$resultOpcaoFicha = $conn->query($sqlOpcaoFicha);
					while($dadosOpcaoFicha = $resultOpcaoFicha->fetch_assoc()){
?>					
												<option value="<?php echo $dadosOpcaoFicha['codOpcaoFicha'];?>" <?php echo $_SESSION['opcoesFichas1'] == $dadosOpcaoFicha['codOpcaoFicha'] ? "/SELECTED/" : "";?>><?php echo $dadosOpcaoFicha['nomeOpcaoFicha'];?></option>
<?php
					}
?>
											</select>
										</p>
									</div>	
<?php
				}
?>
								</div>
								
								<div class="botao-consultar" onClick="novaOpcaoFicha();" style="margin-left:340px; margin-top:-48px; width: 34px; margin-bottom:0px; position:absolute;"><div class="esquerda-consultar"></div><div class="conteudo-consultar">+</div><div class="direita-consultar"></div></div>					
<?php
				if($total >= 1){
?>								
								<input type="hidden" value="<?php echo $total;?>" name="total-opcoesFichas" id="total-opcoesFichas"/>									
<?php
				}else{			
?>
								<input type="hidden" value="1" name="total-opcoesFichas" id="total-opcoesFichas"/>									
<?php
				}
?>
							</div>




							<p class="bloco-campo"><div class="botao-expansivel"><p class="esquerda-botao"></p><input class="botao" id="alterar" <?php echo $erroAtiva == "ok" ? "" : "disabled='disabled'";?> type="submit" name="alterar" title="Alterar" value="Alterar" /><p class="direita-botao"></p></div></p>						
							<br class="clear"/>
						</form>
					</div>
				</div>
<?php
				if($_SESSION['erro'] == "ok"){
					$_SESSION['nome'] = "";
				}

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
