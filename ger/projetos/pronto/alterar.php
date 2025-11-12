<?php
	if($_COOKIE['loginAprovado'.$cookie] != ""){

		if($controleUsuario == "tem usuario"){
			
			$area = "projetos";
			include('f/conf/validaAcesso.php');
			if($validaAcesso == "ok"){

				$sqlNomeProjeto = "SELECT * FROM projetos WHERE codProjeto = '".$url[6]."' LIMIT 0,1";
				$resultNomeProjeto = $conn->query($sqlNomeProjeto);
				$dadosNomeProjeto = $resultNomeProjeto->fetch_assoc();
?>
				<div id="localizacao-topo">
					<div id="conteudo-localizacao-topo">
						<p class="nome-lista">Projeto(s)</p>
						<p class="flexa"></p>
						<p class="nome-lista">Pronto</p>
						<p class="flexa"></p>
						<p class="nome-lista">Alterar</p>
						<p class="flexa"></p>
						<p class="nome-lista"><?php echo $dadosNomeProjeto['nomeProjeto'] ;?></p>
						<br class="clear" />
					</div>
					<table class="tabela-interno" >
<?php	
				if($dadosNomeProjeto['statusProjeto'] == "T"){
					$statusProjeto = "status-ativo";
					$statusIcone = "ativado";
					$statusPergunta = "desativar";
				}else{
					$statusProjeto = "status-desativado";
					$statusIcone = "desativado";
					$statusPergunta = "ativar";
				}	

				if($_COOKIE['codAprovado'.$cookie] == $dadosNomeProjeto['codUsuario'] || $filtraUsuario == ""){
?>	
						<tr class="tr-interno">
							<td class="botoes-interno"><a href='<?php echo $configUrl; ?>projetos/pronto/ativacao/<?php echo $dadosNomeProjeto['codProjeto'] ?>/' title='Deseja <?php echo $statusPergunta ?> o imóvel <?php echo $dadosNomeProjeto['nomeProjeto'];?> ?' ><img src="<?php echo $configUrl; ?>f/i/default/corpo-default/<?php echo $statusProjeto ?>-branco.gif" alt="icone" /></a></td>
							<td class="botoes-interno"><a href='javascript: confirmaExclusao(<?php echo $dadosNomeProjeto['codProjeto'] ?>, "<?php echo htmlspecialchars($dadosNomeProjeto['nomeProjeto']) ?>");' title='Deseja excluir o imóvel <?php echo $dadosNomeProjeto['nomeProjeto'] ?>?' ><img src='<?php echo $configUrl; ?>f/i/default/corpo-default/excluir-branco.gif' alt="icone"></a></td>
						</tr>
<?php
				}
?>
							<script>
								function confirmaExclusao(cod, nome){
									if(confirm("Deseja excluir o imóvel "+nome+"?")){
										window.location='<?php echo $configUrlGer; ?>projetos/pronto/excluir/'+cod+'/';
									}
								}
							</script>
					</table>	
					<div class="botao-consultar"><a title="Consultar Projeto(s)" href="<?php echo $configUrl;?>projetos/pronto/"><div class="esquerda-consultar"></div><div class="conteudo-consultar">Consultar</div><div class="direita-consultar"></div></a></div>					
				</div>
				
				<div id="dados-conteudo">
					<div id="cadastrar">
						
<?php
				if($_POST['nome'] != ""){
							
					include ('f/conf/criaUrl.php');
					$urlProjeto = criaUrl($_POST['nome']);																						

					$sqlCodigo = "SELECT codigoProjeto FROM projetos WHERE codigoProjeto = '".$_POST['codigo']."' and codProjeto != ".$url[6]." LIMIT 0,1";
					$resultCodigo = $conn->query($sqlCodigo);
					$dadosCodigo = $resultCodigo->fetch_assoc();
					
					if($dadosCodigo['codigoProjeto'] == ""){
					
						$preco = $_POST['preco'];
						$preco = str_replace(".", "", $preco);
						$preco = str_replace(",", ".", $preco);

						$parcela = $_POST['precoParcelado'];
						$parcela = str_replace(".", "", $parcela);
						$parcela = str_replace(",", ".", $parcela);

						$vParcela = $_POST['vParcela'];
						$vParcela = str_replace(".", "", $vParcela);
						$vParcela = str_replace(",", ".", $vParcela);

						$descricao = str_replace("../../../../", $configUrlGer, $_POST['descricao']);
						$descricaoGrande = str_replace("../../../../", $configUrlGer, $_POST['descricaoGrande']);

						if($parcela == ""){
							$parcela = "";
						}else{
							$parcela = $parcela;
						}	
						
						if($vParcelado == ""){
							$vParcelado = "0.00";
						}else{
							$vParcelado = $vParcelado;
						}
						
						if($entrada == ""){
							$entrada = "0.00";
						}else{
							$entrada = $entrada;
						}							
					
						if($preco == ""){
							$preco = "0.00";
						}else{
							$preco = $preco;
						}	
											
						if($_POST['quartos'] == ""){
							$quartos = 0;
						}else{
							$quartos = $_POST['quartos'];
						}	
											
						if($_POST['suite'] == ""){
							$suite = 0;
						}else{
							$suite = $_POST['suite'];
						}	
											
						if($_POST['banheiros'] == ""){
							$banheiros = 0;
						}else{
							$banheiros = $_POST['banheiros'];
						}	
											
						if($_POST['garagem'] == ""){
							$garagem = 0;
						}else{
							$garagem = $_POST['garagem'];
						}	
											
						if($_POST['metragem'] == ""){
							$metragem = 0;
						}else{
							$metragem = $_POST['metragem'];
						}	
											
						if($_POST['metragemC'] == ""){
							$metragemC = 0;
						}else{
							$metragemC = $_POST['metragemC'];
						}	
											
						if($_POST['fundos'] == ""){
							$fundos = 0;
						}else{
							$fundos = $_POST['fundos'];
						}						

						if($_POST['dMar'] == ""){
							$dMar = 0;
						}else{
							$dMar = $_POST['dMar'];
						}				
						
						$sql = "UPDATE projetos SET codigoProjeto = '".$_POST['codigo']."', nomeProjeto = '".$_POST['nome']."', precoProjeto = '".$preco."', numeroParcelaProjeto = '".$_POST['numeroParcelas']."', numeroParcelaSProjeto = '".$_POST['numeroParcelasS']."', valorProjeto = '" .$_POST['tipoValor']. "', codCidade = '".$_POST['cidades']."', codBairro = '".$_POST['bairro']."', enderecoProjeto = '".$_POST['endereco']."', quadraProjeto = '".$_POST['quadra']."', loteProjeto = '".$_POST['lote']."', matriculaProjeto = '".$_POST['matricula']."', dMarProjeto = '".$_POST['dMar']."',  quartosProjeto = '".$quartos."', banheirosProjeto = '".$banheiros."', suiteProjeto = '".$suite."', garagemProjeto = '".$garagem."', metragemProjeto = '".$metragem."', metragemCProjeto = '".$metragemC."', fundosProjeto = '".$fundos."',  siglaMetragem = '".$_POST['siglaMetragem']."',  frenteProjeto = '".$_POST['frente']."', posicaoProjeto = '".$_POST['posicao']."', codTipoProjeto = '".$_POST['tipo']."', videoProjeto = '".str_replace("'", "&#39;", $_POST['video'])."', mapaProjeto = '".str_replace("'", "&#39;", $_POST['mapa'])."', descricaoProjeto = '".str_replace("'", "&#39;", $descricao)."',descricaoGrandeProjeto = '".str_replace("'", "&#39;", $descricaoGrande)."', urlProjeto = '".$urlProjeto."' WHERE codProjeto = '".$url[6]."'";
						$result = $conn->query($sql);		
						if($result == 1){
							$_SESSION['nome'] = $_POST['nome'];
							$_SESSION['alteracaos'] = "ok";

							$sqlUltimoProjeto = "SELECT * FROM projetos WHERE codProjeto = '$url[6]'";
							$resultUltimoProjeto = $conn->query($sqlUltimoProjeto);
							$dadosUltimoProjeto = $resultUltimoProjeto->fetch_assoc();

							if($result == 1){
								if(isset($_POST["complemento"])) {
									$sql =  "DELETE FROM projetosComplementos WHERE codProjeto = ".$url[6];
									$result = $conn->query($sql);

									$optionArray = $_POST["complemento"];
									for($i = 0; $i < count($optionArray); $i++){
										$sqlInsereProjetosComplementares = "INSERT INTO projetosComplementos VALUES(0, ".$url[6].", ".$optionArray[$i].")";
										$resultInsereProjetosComplementares = $conn->query($sqlInsereProjetosComplementares);
									}
								}

								$sql =  "DELETE FROM projetoOpcoesFichas WHERE codProjeto = ".$url[6];
								$result = $conn->query($sql);
								for($i = 1; $i <= $_POST['nCampos']; $i++){
									$sqlInsere = "INSERT INTO projetoOpcoesFichas VALUES(0, ".$dadosUltimoProjeto['codProjeto'].", '".$_POST['cod'.$i]."', '".$_POST['opcao'.$i]."')";
									$resultInsere = $conn->query($sqlInsere);
								}
							}


							echo "<meta HTTP-EQUIV='Refresh' CONTENT='0;URL=".$configUrlGer."projetos/pronto/'>";
						}else{
							$erroData = "<p class='erro'>Problemas ao alterar imóvel!</p>";
						}
					}else{
						$erroData = "<p class='erro'>Código ja utilizado em outro imóvel!</p>";
					}	
				}else{
					$sql = "SELECT * FROM projetos WHERE codProjeto = ".$url[6];
					$result = $conn->query($sql);
					$dadosProjeto = $result->fetch_assoc();
					
					$_SESSION['codigo'] = $dadosProjeto['codigoProjeto'];
					$_SESSION['nome'] = $dadosProjeto['nomeProjeto'];
					$_SESSION['cidades'] = $dadosProjeto['codCidade'];
					$_SESSION['bairro'] = $dadosProjeto['codBairro'];
					$_SESSION['quadra'] = $dadosProjeto['quadraProjeto'];
					$_SESSION['endereco'] = $dadosProjeto['enderecoProjeto'];
					$_SESSION['lote'] = $dadosProjeto['loteProjeto'];
					$_SESSION['matricula'] = $dadosProjeto['matriculaProjeto'];
					$_SESSION['quartos'] = $dadosProjeto['quartosProjeto'];
					$_SESSION['suite'] = $dadosProjeto['suiteProjeto'];
					$_SESSION['banheiros'] = $dadosProjeto['banheirosProjeto'];
					$_SESSION['garagem'] = $dadosProjeto['garagemProjeto'];
					$_SESSION['metragem'] = $dadosProjeto['metragemProjeto'];
					$_SESSION['metragemC'] = $dadosProjeto['metragemCProjeto'];
					$_SESSION['fundos'] = $dadosProjeto['fundosProjeto'];
					$_SESSION['frente'] = $dadosProjeto['frenteProjeto'];
					$_SESSION['posicao'] = $dadosProjeto['posicaoProjeto'];
					$_SESSION['tipo'] = $dadosProjeto['codTipoProjeto'];
					$_SESSION['video'] = $dadosProjeto['videoProjeto'];
					$_SESSION['mapa'] = $dadosProjeto['mapaProjeto'];
					$_SESSION['descricao'] = $dadosProjeto['descricaoProjeto'];
					$_SESSION['descricaoGrande'] = $dadosProjeto['descricaoGrandeProjeto'];
					$_SESSION['preco'] = $dadosProjeto['precoProjeto'];
					$_SESSION['entrada'] = $dadosProjeto['entrada'];
					$_SESSION['parcelas'] =  $dadosProjeto['nParcelaProjeto'];
					$_SESSION['vParcela'] =  $dadosProjeto['valorParcelaProjeto'];
					$_SESSION['dMar'] =  $dadosProjeto['dMarProjeto'];
					$_SESSION['entrada'] =  $dadosProjeto['entradaProjeto'];
					$_SESSION['tipoValor'] = $dadosProjeto['valorProjeto'];
					$_SESSION['siglaMetragem'] = $dadosProjeto['siglaMetragem'];
					$_SESSION['numeroParcelas'] = $dadosProjeto['numeroParcelaProjeto'];
					$_SESSION['numeroParcelasS'] = $dadosProjeto['numeroParcelaSProjeto'];
					$_SESSION['precoParcelado'] = $dadosProjeto['precoParcelaProjeto'];
					$_SESSION['tipoParcela'] = $dadosProjeto['tipoParcelaProjeto'];

					$i = 0;
					$sqlProjetoOpcoes = "SELECT * FROM projetoOpcoesFichas WHERE codProjeto = ".$url[6];
					$resultProjetoOpcoes = $conn->query($sqlProjetoOpcoes);
					while($dadosProjetoOpcoes = $resultProjetoOpcoes->fetch_assoc()){
						$i ++;
							$_SESSION['opcao'.$i] = $dadosProjetoOpcoes['dadoProjetoOpcao'];

					}
					
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

				if($_COOKIE['codAprovado'.$cookie] == $dadosProjeto['codUsuario'] || $filtraUsuario == ""){
?>				
					<div class="botao-editar"><a title="Editar" href="javascript:habilitaCampo();"><div class="esquerda-editar"></div><div class="conteudo-editar">Editar</div><div class="direita-editar"></div></a></div>					
<?php
				}
?>					
					<p class="obrigatorio">Campos obrigatórios *</p>
					<br/>
					<p style="color:#718B8F; font-weight:bold;">* Campos nesta cor aparecerão no site</p>
					<p style="color:#718B8F;">* Campos nesta cor não aparecerão no site</p>
					<br/>
					<script>
						function habilitaCampo(){
							document.getElementById("codigo").disabled = false;
							document.getElementById("nome").disabled = false;
							document.getElementById("preco").disabled = false;
							document.getElementById("quartos").disabled = false;
							document.getElementById("banheiros").disabled = false;
							document.getElementById("suite").disabled = false;
							document.getElementById("garagem").disabled = false;
							document.getElementById("metragem").disabled = false;
							document.getElementById("metragemC").disabled = false;
							document.getElementById("fundos").disabled = false;
							document.getElementById("frente").disabled = false;
							document.getElementById("tipo").disabled = false;
							document.getElementById("alterar").disabled = false;
							document.getElementById("numeroParcelas").disabled = false;
							document.getElementById("numeroParcelasS").disabled = false;
						}
					</script>
		
					<script>
						function moeda(z){  
							v = z.value;
							v=v.replace(/\D/g,"")  
							v=v.replace(/[0-9]{12}/,"inválido")   
							v=v.replace(/(\d{1})(\d{8})$/,"$1.$2")  
							v=v.replace(/(\d{1})(\d{5})$/,"$1.$2")  
							v=v.replace(/(\d{1})(\d{1,2})$/,"$1,$2")	
							z.value = v;
						}
					</script>
						<form id="formulario" name="formProjeto" action="<?php echo $configUrlGer; ?>projetos/pronto/alterar/<?php echo $url[6] ;?>/" method="post">						
							<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
							<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.4/css/select2.min.css" rel="stylesheet" />
							<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.4/js/select2.min.js"></script>	
							<p class="bloco-campo-float"><label>Tipo "Projeto Pronto": <span class="obrigatorio"> * </span></label>
								<select class="campo" id="tipo" name="tipo" style="width:250px; height:32px;" required <?php echo $erroAtiva == "ok" ? "" : "disabled='disabled'";?> onChange="exibeCamposTipo(this.value);">
									<option value="">Selecione</option>
<?php
				$sqlTipoProjeto = "SELECT * FROM tipoProjeto WHERE statusTipoProjeto = 'T' ORDER BY nomeTipoProjeto ASC";
				$resultTipoProjeto = $conn->query($sqlTipoProjeto);
				while($dadosTipoProjeto = $resultTipoProjeto->fetch_assoc()){
?>
									<option value="<?php echo $dadosTipoProjeto['codTipoProjeto'] ;?>" <?php echo $_SESSION['tipo'] == $dadosTipoProjeto['codTipoProjeto'] ? '/SELECTED/' : '';?>><?php echo $dadosTipoProjeto['nomeTipoProjeto'] ;?></option>
<?php
				}
?>					
								</select>
								<br class="clear"/>
							</p>

							<p class="bloco-campo-float"><label>Código: <span class="obrigatorio"> * </span></label>
							<input class="campo" type="text" id="codigo" name="codigo" style="width:80px;" <?php echo $erroAtiva == "ok" ? "" : "disabled='disabled'";?> required value="<?php echo $_SESSION['codigo']; ?>" onKeyDown="Mascara(this,Integer);" onKeyPress="Mascara(this,Integer);" onKeyUp="Mascara(this,Integer);"/></p>
					
							<p class="bloco-campo-float">
								<label>Preço: <span class="obrigatorio"> </span></label>
								<input class="campo" type="text" id="preco" name="preco" style="width:150px;" onKeyUp="moeda(this);" <?php echo $erroAtiva == "ok" ? "" : "disabled='disabled'";?> value="<?php echo number_format($_SESSION['preco'], 2, ",", "."); ?>" />
							</p>
							<p class="bloco-campo-float">
								<label>N° max de parcelas: <span class="obrigatorio"> * </span></label>
								<input class="campo" type="text" id="numeroParcelas" name="numeroParcelas"  <?php echo $erroAtiva == "ok" ? "" : "disabled='disabled'";?>  required style="width:207px;" value="<?php echo $_SESSION['numeroParcelas']; ?>" />
							</p>
					
							<p class="bloco-campo-float">
								<label>N° Parcelas s/ juros: <span class="obrigatorio"> * </span></label>
								<input class="campo" type="text" id="numeroParcelasS" name="numeroParcelasS"  <?php echo $erroAtiva == "ok" ? "" : "disabled='disabled'";?>  required style="width:207px;" value="<?php echo $_SESSION['numeroParcelasS']; ?>" />
							</p>

							<br class="clear"/>

							<p class="bloco-campo-float"><label>Nome do Projeto Pronto: <span class="obrigatorio"> * </span></label>
							<input class="campo" type="text" id="nome" name="nome"  <?php echo $erroAtiva == "ok" ? "" : "disabled='disabled'";?>  style="width:980px;" required value="<?php echo $_SESSION['nome']; ?>" /></p>

							<br class="clear"/>				

							<p class="bloco-campo-float coloca retira 6" ><label>Quartos: <span class="obrigatorio"> </span></label>
							<input class="campo" type="number" id="quartos" <?php echo $erroAtiva == "ok" ? "" : "disabled='disabled'";?> name="quartos" style="width:98px;" value="<?php echo $_SESSION['quartos']; ?>" /></p>

							<p class="bloco-campo-float coloca retira 6" ><label>Suítes: <span class="obrigatorio"> </span></label>
							<input class="campo" type="number" id="suite" <?php echo $erroAtiva == "ok" ? "" : "disabled='disabled'";?> name="suite" style="width:98px;" value="<?php echo $_SESSION['suite']; ?>" /></p>

							<p class="bloco-campo-float coloca retira 6" ><label>Banheiros: <span class="obrigatorio"> </span></label>
							<input class="campo" type="number" id="banheiros" <?php echo $erroAtiva == "ok" ? "" : "disabled='disabled'";?> name="banheiros" style="width:98px;" value="<?php echo $_SESSION['banheiros']; ?>" /></p>

							<p class="bloco-campo-float coloca retira 6" ><label>Garagem: <span class="obrigatorio"> </span></label>
							<input class="campo" type="number" id="garagem" <?php echo $erroAtiva == "ok" ? "" : "disabled='disabled'";?> name="garagem" style="width:98px;" value="<?php echo $_SESSION['garagem']; ?>" /></p>

							<p class="bloco-campo-float coloca retira 6" ><label>Área Construída: <span class="obrigatorio"> </span></label>
							<input class="campo" type="text" id="metragemC" <?php echo $erroAtiva == "ok" ? "" : "disabled='disabled'";?> name="metragemC" style="width:98px;" value="<?php echo $_SESSION['metragemC']; ?>" /></p>
							
							<p class="bloco-campo-float coloca retira 5" ><label>Frente: <span class="obrigatorio"> </span></label>
							<input class="campo" type="text" id="frente" <?php echo $erroAtiva == "ok" ? "" : "disabled='disabled'";?> name="frente" style="width:98px;" value="<?php echo $_SESSION['frente']; ?>" onKeyup="calculaArea();" /></p>
							
							<p class="bloco-campo-float coloca retira 5" ><label>Fundos: <span class="obrigatorio"> </span></label>
							<input class="campo" type="text" id="fundos" <?php echo $erroAtiva == "ok" ? "" : "disabled='disabled'";?> name="fundos" style="width:98px;" value="<?php echo $_SESSION['fundos']; ?>"  onKeyup="calculaArea();"/></p>

							<p class="bloco-campo-float coloca retira 5" ><label>Área Terreno: <span class="obrigatorio"> </span></label>
							<input class="campo" type="text" id="metragem" <?php echo $erroAtiva == "ok" ? "" : "disabled='disabled'";?> name="metragem" style="width:98px;" value="<?php echo $_SESSION['metragem']; ?>" /></p>

							<br class="clear"/>	

							<script type="text/javascript">
								function calculaArea(){
									var frente = document.getElementById("frente").value;
									var fundos = document.getElementById("fundos").value;
									frente = frente.replace(",", ".");
									fundos = fundos.replace(",", ".");
									
									if(frente != "" && fundos != ""){
										calcula = frente * fundos;
										document.getElementById("metragem").value=calcula;
									}
								}
							</script>	
							
							<div id="bloco">
				
<?php 			
								$i = 0;
								$contador = 0;
								$sqlFichas = "SELECT * FROM fichas WHERE statusFicha = 'T' ORDER BY nomeFicha ASC";	
								$resultFichas = $conn->query($sqlFichas);
								while($dadosFichas = $resultFichas->fetch_assoc()){
				
									$contador ++;
									if($contador == 4){
										$contador = 0;
										$margin = "margin-right:0px;";
									}else{
										$margin = "";
									}
				
?>
												<fieldset style="<?php echo $margin; ?>"> 
													<legend><?php echo  $dadosFichas['nomeFicha']; ?></legend>
														<div id="bloco-opcoes">
<?php 
								$sqlProjetosFichas = "SELECT * FROM projetosFichas WHERE codFicha = ".$dadosFichas['codFicha']."";
								$resultProjetosFichas = $conn->query($sqlProjetosFichas);
								while($dadosProjetosFichas = $resultProjetosFichas->fetch_assoc()){
									$sqlOpcoesFichas = "SELECT * FROM opcoesFichas WHERE codOpcaoFicha = ".$dadosProjetosFichas['codOpcaoFicha']." ORDER BY codOpcaoFicha ASC";
									$resultOpcoesFichas = $conn->query($sqlOpcoesFichas);
									$dadosOpcoesFichas = $resultOpcoesFichas->fetch_assoc();
									$i++;
				
?>	
													<p class="bloco-campo-float coloca retira 6" style="margin-right: 0px; margin-bottom: 5px; margin-top: 5px; width: 100%;"><label style="margin-bottom: 4px;"><?php echo $dadosOpcoesFichas['nomeOpcaoFicha']; ?>: <span class="obrigatorio"> </span></label>
													<input class="campo" type="text" id="opcao<?php echo $i; ?>" name="opcao<?php echo $i; ?>" style="width:98px;" value="<?php echo  $_SESSION['opcao'.$i]; ?>" /></p>
													<input  type="hidden" name="cod<?php echo $i; ?>" value="<?php echo $dadosOpcoesFichas['codOpcaoFicha']; ?>"/></p>
													
<?php 			
								}
								

?>
														</div>
													</fieldset>
<?php 
				
								}
								
?>								
								<input type="hidden" value="<?php echo $i;?>" name="nCampos"/> 
								
							</div>

							<style>
								#bloco { width: 995px;display: flex;flex-wrap: wrap; text-align: center; justify-content: center; gap: 10px; margin-bottom: 20px;}
								#bloco fieldset {width: 231px;margin-right: 10px; border: 1px solid #93C6C6; border-radius: 5px; font-size: 14px; background-color: white; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); }
								#bloco fieldset legend { display: block; font-weight: bold; font-size: 16px; color: #718B8F;}
								#bloco fieldset #bloco-opcoes {display: flex; flex-wrap: wrap; justify-content: center;}
							</style>
							
							<p class="bloco-campo"><label>Projetos Complementares: <span class="obrigatorio"> </span></label>
								<select class="select2 form-control campo" id="idSelect2" name="complemento[]" multiple="" style="width:995px; display: none;">
									<optgroup label="Selecione as atuacao">
<?php
								// Seleciona todos os projetos complementares ativos
								$sqlProjetosComplementares = "SELECT * FROM projetosComplementares WHERE statusProjetoComplementar = 'T' ORDER BY nomeProjetoComplementar ASC, codProjetoComplementar ASC";
								$resultProjetosComplementares = $conn->query($sqlProjetosComplementares);

								// Busca os projetos complementares já vinculados ao projeto atual na tabela de conexão
								$projetosSelecionados = array();
								$sqlSelecionados = "SELECT codProjetoComplementar FROM projetosComplementos WHERE codProjeto = " . intval($url[6]);
								$resultSelecionados = $conn->query($sqlSelecionados);
								while($rowSelecionado = $resultSelecionados->fetch_assoc()) {
									$projetosSelecionados[] = $rowSelecionado['codProjetoComplementar'];
								}

								while($dadosProjetosComplementares = $resultProjetosComplementares->fetch_assoc()){
									$selected = in_array($dadosProjetosComplementares['codProjetoComplementar'], $projetosSelecionados) ? 'selected' : '';
?>
										<option value="<?php echo $dadosProjetosComplementares['codProjetoComplementar']; ?>" <?php echo $selected; ?>>
											<?php echo $dadosProjetosComplementares['nomeProjetoComplementar']; ?> - R$ <?php echo number_format($dadosProjetosComplementares['precoProjetoComplementar'], 2, ",", "."); ?>
										</option>
<?php
								}
?>
									</optgroup>
								</select>
							</p>
						
							<br class="clear"/>	

							<p class="bloco-campo" style="width:997px;"><label>Descrição Topo:<span class="obrigatorio"> </span></label>
							<textarea class="campo textarea" id="descricao" name="descricao" type="text" style="width:855px; height:200px;" ><?php echo $_SESSION['descricao']; ?></textarea></p>

							<p class="bloco-campo" style="width:997px;"><label>Descrição Grande:<span class="obrigatorio"> </span></label>
							<textarea class="campo textarea" id="descricaoGrande" name="descricaoGrande" type="text" style="width:855px; height:200px;" ><?php echo $_SESSION['descricaoGrande']; ?></textarea></p>
							
							<br class="clear"/>

							<div class="botao-expansivel"><p class="esquerda-botao"></p><input id="alterar" <?php echo $erroAtiva == "ok" ? "" : "disabled='disabled'";?> class="botao" type="submit" name="alterar" title="Alterar" value="Alterar"/><p class="direita-botao"></p></div>						
							<br class="clear"/>
						</form>
					</div>					
				</div>
				<script>
					var $rf = jQuery.noConflict();
					$rf(".select2").select2();				
				</script>				
<?php
				if($_SESSION['erro'] == "ok"){ 
					$_SESSION['codigo'] = "";
					$_SESSION['nome'] = "";
					$_SESSION['preco'] = "";
					$_SESSION['precoC'] = "";
					$_SESSION['cidades'] = "";
					$_SESSION['bairro'] = "";
					$_SESSION['endereco'] = "";
					$_SESSION['lote'] = "";
					$_SESSION['quadra'] = "";
					$_SESSION['matricula'] = "";
					$_SESSION['metragem'] = "";
					$_SESSION['tipo'] = "";
					$_SESSION['tipoc'] = "";
					$_SESSION['video'] = "";
					$_SESSION['mapa'] = "";
					$_SESSION['descricao'] = "";
					$_SESSION['siglaMetragem'] = "";
					for($i = 1; $i<= $_POST['nCampos']; $i++){
						$_SESSION['opacao'.$i] = "";
					}
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
