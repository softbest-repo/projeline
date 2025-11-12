<?php
	if($_COOKIE['loginAprovado'.$cookie] != ""){

		if($controleUsuario == "tem usuario"){
			
			$area = "projetos";
			include('f/conf/validaAcesso.php');
			if($validaAcesso == "ok"){

				if($_SESSION['cadastro'] == "ok"){
					$erroConteudo = "<p class='erro'>Imóvel <strong>".$_SESSION['nome']."</strong> cadastrado com sucesso!</p>";
					$_SESSION['cadastro'] = "";
					$_SESSION['nome'] = "";
				}else	
				if($_SESSION['alteracaos'] == "ok"){
					$erroConteudo = "<p class='erro'>Imóvel <strong>".$_SESSION['nome']."</strong> alterado com sucesso!</p>";
					$_SESSION['alteracaos'] = "";
					$_SESSION['nome'] = "";
				}else	
				if($_SESSION['ativacaos'] == "ok"){
					$erroConteudo = "<p class='erro'>Imóvel <strong>".$_SESSION['nome']."</strong> ".$_SESSION['acao']." com sucesso!</p>";
					$_SESSION['ativacaos'] = "";
					$_SESSION['nome'] = "";
				}else
				if($_SESSION['destaque'] == "ok"){
					$erroConteudo = "<p class='erro'>Imóvel <strong>".$_SESSION['nome']."</strong> ".$_SESSION['acao']."!</p>";
					$_SESSION['destaque'] = "";
					$_SESSION['nome'] = "";
				}else
				if($_SESSION['exclusaos'] == "ok"){
					$erroConteudo = "<p class='erro'>Imóvel <strong>".$_SESSION['nome']."</strong> excluído com sucesso!</p>";
					$_SESSION['exclusaos'] = "";
					$_SESSION['nome'] = "";
				}
				
				if(isset($_POST['tipoFiltro'])){
					if($_POST['tipoFiltro'] != ""){
						$_SESSION['tipoFiltro'] = $_POST['tipoFiltro'];
					}else{
						$_SESSION['tipoFiltro'] = "";
					}
				}
				
				if($_SESSION['tipoFiltro'] != ""){
					$filtraTipo = " and codTipoProjeto = '".$_SESSION['tipoFiltro']."'";
				}	
																																								
?>
				<div id="filtro">
					<div id="localizacao-filtro">
						<p class="nome-lista">Projeto(s)</p>
						<p class="flexa"></p>
						<p class="nome-lista">Pronto</p>
						<br class="clear" />
					</div>
					<div class="demoTarget">
						<div id="formulario-filtro">
							<script type="text/javascript">
								function alteraFiltro(){
									document.getElementById("alteraFiltro").submit();
								}
							</script>
							<form id="alteraFiltro" action="<?php echo $configUrl;?>projetos/pronto/" method="post" >
								<p class="nome-clientes-filtro" style="width:300px;"><label class="label">Filtrar Código ou Nome:</label>
								<input type="text" style="width:275px;" name="projetos" onKeyUp="buscaAvancada();" id="busca" autocomplete="off" value="<?php echo $_SESSION['nome-projetos-filtro'];?>" /></p>
								<input style="display:none;" type="text" size="16" name="teste" value="" />

								<p class="bloco-campo-float" style="margin-right:0px;"><label>Filtrar Tipo de projeto pronto: <span class="obrigatorio"> </span></label>
									<select class="campo" id="tipoFiltro" name="tipoFiltro" style="width:226px; padding:5.5px;" onChange="alteraFiltro();">
										<option value="">Todos</option>
<?php
				$sqlTipoProjeto = "SELECT * FROM tipoProjeto WHERE statusTipoProjeto = 'T' ORDER BY nomeTipoProjeto ASC";
				$resultTipoProjeto = $conn->query($sqlTipoProjeto);
				while($dadosTipoProjeto = $resultTipoProjeto->fetch_assoc()){
?>
										<option value="<?php echo $dadosTipoProjeto['codTipoProjeto'] ;?>" <?php echo $_SESSION['tipoFiltro'] == $dadosTipoProjeto['codTipoProjeto'] ? '/SELECTED/' : '';?>><?php echo $dadosTipoProjeto['nomeTipoProjeto'] ;?></option>
<?php
				}
?>					
									</select>
									<br class="clear"/>
								</p>

								
								<div class="botao-novo" style="margin-top:17px; margin-left:0px;"><a title="Novo imóvel" onClick="abreCadastrar();"><div class="esquerda-novo"></div><div class="conteudo-novo" id="conteudo-novo-cliente">Novo "Prejeto Pronto"</div><div class="direita-novo"></div></a></div>
								<div class="botao-novo" style="display:none; margin-left:0px; margin-top:16px;" id="botaoFechar"><a title="Fechar" onClick="abreCadastrar();"><div class="esquerda-novo"></div><div class="conteudo-novo" id="conteudo-novo-cliente">X</div><div class="direita-novo"></div></a></div>
								<br class="clear" />
							</form>						
						</div>
					</div>
					<script>
						function abreCadastrar(){
							var $rf = jQuery.noConflict();
							if(document.getElementById("cadastrar").style.display=="none"){
								document.getElementById("botaoFechar").style.display="block";
								$rf("#cadastrar").slideDown(250);
							}else{
								document.getElementById("botaoFechar").style.display="none";
								$rf("#cadastrar").slideUp(250);
							}
						}
					</script>				
					<div id="cadastrar" style="display:none; margin-left:30px; margin-top:30px; margin-bottom:30px;">		
						<div class="botao-novo" style="margin-left:0px; margin-top:-20px; margin-bottom:20px;"><a href="<?php echo $configUrlGer;?>projetos/tipoProjeto/1/"><div class="esquerda-novo"></div><div class="conteudo-novo">Cadastrar novo tipo projeto</div><div class="direita-novo"></div></a></div>
						<br class="clear"/>
<?php
				if($_POST['nome'] != ""){
							
					include ('f/conf/criaUrl.php');
					$urlProjeto = criaUrl($_POST['nome']);					
						
					$descricao = str_replace("../../", $configUrlGer, $_POST['descricao']);
					$descricaoGrande = str_replace("../../", $configUrlGer, $_POST['descricaoGrande']);
					
					$preco = $_POST['preco'];
					$preco = str_replace(".", "", $preco);
					$preco = str_replace(",", ".", $preco);

					$precoParcelado = $_POST['precoParcelado'];
					$precoParcelado = str_replace(".", "", $precoParcelado);
					$precoParcelado = str_replace(",", ".", $precoParcelado);

					if($vParcela == ""){
						$vParcela = "0.00";
					}else{
						$vParcela = $vParcela;
					}	
					
					if($entrada == ""){
						$aVientradasta = "0.00";
					}else{
						$entrada = $entrada;
					}	

					if($preco == ""){
						$preco = "0.00";
					}else{
						$preco = $preco;
					}

					if($precoParcelado == ""){
						$precoParcelado = "0.00";
					}else{
						$precoParcelado = $precoParcelado;
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
														
					$sql = "INSERT INTO projetos VALUES(0, '".$_POST['codigo']."', '".$_POST['nome']."', '".$preco."', '".$_POST['numeroParcelas']."', '".$_POST['numeroParcelasS']."', '".$precoParcelado."',  'F',  '".$_POST['cidades']."', '".$_POST['bairro']."', '".$entrada."', '".$_POST['parcelas']."', '".$vParcela."', '".$_POST['tipoValor']."' ,'".$_POST['endereco']."', '".$_POST['quadra']."', '".$_POST['lote']."', '".$_POST['matricula']."', '".$dMar."',  '".$quartos."', '".$banheiros."', '".$suite."', '".$garagem."', '".$metragem."', '".$metragemC."', '".$fundos."', '".$_POST['siglaMetragem']."',  '".$_POST['frente']."',  '".$_POST['posicao']."', '".$_POST['tipo']."', 'V', '".str_replace("'", "&#39;", $_POST['video'])."', '".str_replace("'", "&#39;", $_POST['mapa'])."', '".str_replace("'", "&#39;", $descricao)."','".str_replace("'", "&#39;", $descricaoGrande)."', 'F', 'T', '".$urlProjeto."')";
					$result = $conn->query($sql);

					$sqlUltimoProjeto = "SELECT * FROM projetos ORDER BY codProjeto DESC LIMIT 1";
					$resultUltimoProjeto = $conn->query($sqlUltimoProjeto);
					$dadosUltimoProjeto = $resultUltimoProjeto->fetch_assoc();
					
					$teste = 0;
					if($result == 1){
						if(isset($_POST["complemento"])) {
							$optionArray = $_POST["complemento"];
							for($i = 0; $i < count($optionArray); $i++){
								$sqlInsereProjetosComplementares = "INSERT INTO projetosComplementos VALUES(0, ".$dadosUltimoProjeto['codProjeto'].", ".$optionArray[$i].")";
								$resultInsereProjetosComplementares = $conn->query($sqlInsereProjetosComplementares);
							}
						}
						
						$sqlOpcoesFichas = "SELECT * FROM projetosFichas ORDER BY codOpcaoFicha ASC";
						$resultOpcoesFichas = $conn->query($sqlOpcoesFichas);
						while($dadosOpcoesFichas = $resultOpcoesFichas->fetch_assoc()){
							$i++;
							$sqlInsere = "INSERT INTO projetoOpcoesFichas VALUES(0, ".$dadosUltimoProjeto['codProjeto'].", ".$dadosOpcoesFichas['codOpcaoFicha'].", '".$_POST['opcao'.$i]."')";
							$resultInsere = $conn->query($sqlInsere);
						}
						
						echo "<meta HTTP-EQUIV='Refresh' CONTENT='0;URL=".$configUrlGer."projetos/pronto/imagens/".$dadosUltimoProjeto['codProjeto']."/'>";
					}else{
						$erroData = "<p class='erro'>Problemas ao cadastrar Projeto!</p>";
					}
					
		
				}else{
					$_SESSION['proprietarios'] = "";
					$_SESSION['codigo'] = "";
					$_SESSION['nome'] = "";
					$_SESSION['preco'] = "";
					$_SESSION['cidades'] = "";
					$_SESSION['bairros'] = "";
					$_SESSION['endereco'] = "";
					$_SESSION['quadra'] = "";
					$_SESSION['lote'] = "";
					$_SESSION['matricula'] = "";
					$_SESSION['quartos'] = "";
					$_SESSION['banheiros'] = "";
					$_SESSION['suite'] = "";
					$_SESSION['garagem'] = "";
					$_SESSION['metragem'] = "";
					$_SESSION['metragemC'] = "";
					$_SESSION['fundos'] = "";
					$_SESSION['largura'] = "";
					$_SESSION['frente'] = "";
					$_SESSION['posicao'] = "";
					$_SESSION['tipo'] = "";
					$_SESSION['video'] = "";
					$_SESSION['mapa'] = "";
					$_SESSION['descricao'] = "";
					$_SESSION['descricaoGrande'] = "";
					$_SESSION['entrada'] = "";
					$_SESSION['parcelas'] = "";
					$_SESSION['vParcela'] = "";
					$_SESSION['dMar'] = "";
					$_SESSION['numeroParcelas'] = "";
					$_SESSION['numeroParcelasS'] = "";
					$_SESSION['precoParcelado'] = "";

						
					function somarComZerosAEsquerda(string $numero1, string $numero2): string{
						$numero1Int = (int)$numero1;
						$numero2Int = (int)$numero2;

						$soma = $numero1Int + $numero2Int;
						$somaFormatada = sprintf('%04d', $soma);

						return $somaFormatada;
					}	
										
					$sqlCodigo = "SELECT * FROM projetos WHERE statusProjeto = 'T' ORDER BY codigoProjeto DESC LIMIT 0,1";
					$resultCodigo = $conn->query($sqlCodigo);
					$dadosCodigo = $resultCodigo->fetch_assoc();
					
					if($dadosCodigo['codProjeto'] != ""){
						
						$montaCodigo = somarComZerosAEsquerda($dadosCodigo['codigoProjeto'], 0001);						
						
					}else{
						
						$montaCodigo = "0001";														
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
?>								
						<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
						<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.4/css/select2.min.css" rel="stylesheet" />
						<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.4/js/select2.min.js"></script>
						<p class="obrigatorio">Campos obrigatórios *</p>
						<br/>
						<p style="color:#718B8F; font-weight:bold;">* Campos neste formato aparecerão no site</p>
						<p style="color:#718B8F;">* Campos neste formato não aparecerão no site</p>
						<br/>
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
						<form id="formulario" name="formProjeto" action="<?php echo $configUrlGer; ?>projetos/pronto/" method="post">
							<input type="hidden" id="tipoEnvio" name="tipoEnvio" value="" />

							<p class="bloco-campo-float"><label>Tipo "Projeto Pronto": <span class="obrigatorio"> * </span></label>
								<select class="campo" id="tipo" name="tipo" style="width:250px; height:32px;" required onChange="exibeCamposTipo(this.value);">
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
							<input class="campo" type="text" id="codigo" name="codigo" style="width:80px;" required value="<?php echo $montaCodigo;?>" onKeyDown="Mascara(this,Integer);" onKeyPress="Mascara(this,Integer);" onKeyUp="Mascara(this,Integer);"/></p>
					
							<p class="bloco-campo-float">
								<label>Preço: <span class="obrigatorio"> </span></label>
								<input class="campo" type="text" id="preco" name="preco" style="width:150px;" onKeyUp="moeda(this);" value="<?php echo $_SESSION['preco']; ?>" />
							</p>

							<p class="bloco-campo-float">
								<label>Nº max de parcelas: <span class="obrigatorio"> * </span></label>
								<input class="campo" type="text" id="numeroParcelas" name="numeroParcelas" required style="width:207px;" value="<?php echo $_SESSION['numeroParcelas']; ?>" />
							</p>

							<p class="bloco-campo-float">
								<label>Nº parcelas s/ juros: <span class="obrigatorio"> * </span></label>
								<input class="campo" type="text" id="numeroParcelasS" name="numeroParcelasS" required style="width:207px;" value="<?php echo $_SESSION['numeroParcelasS']; ?>" />
							</p>

							<br class="clear"/>

							<p class="bloco-campo-float"><label>Nome do Projeto Pronto: <span class="obrigatorio"> * </span></label>
							<input class="campo" type="text" id="nome" name="nome" style="width:980px;" required value="<?php echo $_SESSION['nome']; ?>" /></p>

							<br class="clear"/>

							<p class="bloco-campo-float coloca retira 6 "><label>Quartos: <span class="obrigatorio"> </span></label>
							<input class="campo" type="number" id="quartos" name="quartos" style="width:98px;" value="<?php echo $_SESSION['quartos']; ?>" /></p>

							<p class="bloco-campo-float coloca retira 6"><label>Suítes: <span class="obrigatorio"> </span></label>
							<input class="campo" type="number" id="suite" name="suite" style="width:98px;" value="<?php echo $_SESSION['suite']; ?>" /></p>

							<p class="bloco-campo-float coloca retira 6"><label>Banheiros: <span class="obrigatorio"> </span></label>
							<input class="campo" type="number" id="banheiros" name="banheiros" style="width:98px;" value="<?php echo $_SESSION['banheiros']; ?>" /></p>

							<p class="bloco-campo-float coloca retira 6"><label>Garagem: <span class="obrigatorio"> </span></label>
							<input class="campo" type="number" id="garagem" name="garagem" style="width:98px;" value="<?php echo $_SESSION['garagem']; ?>" /></p>
							
							<p class="bloco-campo-float coloca retira 6"><label>Área Construída: <span class="obrigatorio"> </span></label>
							<input class="campo" type="text" id="metragemC" name="metragemC" style="width:113px;" value="<?php echo $_SESSION['metragemC']; ?>" /></p>

							<p class="bloco-campo-float coloca retira 5 6"><label>Frente: <span class="obrigatorio"> </span></label>
							<input class="campo" type="text" id="frente" name="frente" style="width:98px;" value="<?php echo $_SESSION['frente']; ?>" onKeyup="calculaArea();" /></p>
							
							<p class="bloco-campo-float coloca retira 5"><label>Fundos: <span class="obrigatorio"> </span></label>
							<input class="campo" type="text" id="fundos" name="fundos" style="width:98px;" value="<?php echo $_SESSION['fundos']; ?>" onKeyup="calculaArea();" /></p>

							<p class="bloco-campo-float coloca retira 5"><label>Área Terreno: <span class="obrigatorio"> </span></label>
							<input class="campo" type="text" id="metragem" name="metragem" style="width:98px;" value="<?php echo $_SESSION['metragem']; ?>" /></p>

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

							<br class="clear"/>
							
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
									<input class="campo" type="text" id="opcao<?php echo $i; ?>" name="opcao<?php echo $i; ?>" style="width:98px;" value="" /></p>
									
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

							<p class="bloco-campo"><label>Projetos Complementares: <span class="obrigatorio"> </span></label>
								<select class="select2 form-control campo" id="idSelect2" name="complemento[]" multiple="" style="width:995px; display: none;">
									<optgroup label="Selecione as atuacao">
<?php
	$sqlProjetosComplementares = "SELECT * FROM projetosComplementares WHERE statusProjetoComplementar = 'T' ORDER BY nomeProjetoComplementar ASC, codProjetoComplementar ASC";
	$resultProjetosComplementares = $conn->query($sqlProjetosComplementares);
	while($dadosProjetosComplementares = $resultProjetosComplementares->fetch_assoc()){
?>
										<option value="<?php echo $dadosProjetosComplementares['codProjetoComplementar']; ?>" <?php echo (isset($_SESSION['projetosComplementares']) && $_SESSION['projetosComplementares'] == $dadosProjetosComplementares['codProjetoComplementar']) ? 'selected' : ''; ?>><?php echo $dadosProjetosComplementares['nomeProjetoComplementar']; ?> - R$ <?php echo number_format($dadosProjetosComplementares['precoProjetoComplementar'], 2, ",", "."); ?></option>
<?php
	}
?>	
									</optgroup>
								</select>
							</p>

							<style>
								#bloco { width: 995px;display: flex;flex-wrap: wrap; text-align: center; justify-content: center; gap: 10px; margin-bottom: 20px;}
								#bloco fieldset {width: 231px;margin-right: 10px; border: 1px solid #93C6C6; border-radius: 5px; font-size: 14px; background-color: white; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); }
								#bloco fieldset legend { display: block; font-weight: bold; font-size: 16px; color: #718B8F;}
								#bloco fieldset #bloco-opcoes {display: flex; flex-wrap: wrap; justify-content: center;}
							</style>
			
							<p class="bloco-campo" style="width:995px;"><label>Descrição Topo:<span class="obrigatorio"> </span></label>
							<textarea class="campo textarea" id="descricao" name="descricao" type="text"><?php echo $_SESSION['descricao']; ?></textarea></p>

							<p class="bloco-campo" style="width:995px;"><label>Descrição Grande:<span class="obrigatorio"> </span></label>
							<textarea class="campo textarea" id="descricaoGrande" name="descricaoGrande" type="text"><?php echo $_SESSION['descricaoGrande']; ?></textarea></p>
							


							<p class="bloco-campo"><div class="botao-expansivel"><p class="esquerda-botao"></p><input class="botao" type="submit" name="cadastrar" title="Salvar Imóvel" value="Salvar" /><p class="direita-botao"></p></div></p>						
							<br class="clear"/>
						</form>
					</div>
				</div>
				<script>
					var $rf = jQuery.noConflict();
					$rf(".select2").select2();				
				</script>					
				<div id="dados-conteudo">
					<div id="consultas">
					
					
<?php	
				if($erroConteudo != ""){
?>
						<div class="area-erro">
<?php
					echo $erroConteudo;	
?>
						</div>
						
<?php
				}
?>
						<script type="text/javascript">
							function buscaAvancada(){
								var $AGD = jQuery.noConflict();
								var busca = $AGD("#busca").val();
								busca = busca.replace(" ", "-");
								busca = busca.replace(" ", "-");
								busca = busca.replace(" ", "-");
								busca = busca.replace(" ", "-");
								busca = busca.replace(" ", "-");
								busca = busca.replace(" ", "-");
								busca = busca.replace(" ", "-");
								busca = busca.replace(" ", "-");
								$AGD("#busca-carregada").load("<?php echo $configUrl;?>projetos/pronto/busca-projeto.php?busca="+busca);
								if(busca == ""){
									document.getElementById("paginacao").style.display="block";
								}else{
									document.getElementById("paginacao").style.display="none";
								}
							}	
						</script>
						<div id="busca-carregada">
<?php
				$sqlConta = "SELECT nomeProjeto FROM projetos WHERE codProjeto !=''".$filtraCidade.$filtraBairro.$filtraTipo.$filtraQuadra.$filtraLote."";
				$resultConta = $conn->query($sqlConta);
				$dadosConta = $resultConta->fetch_assoc();
				$registros = mysqli_num_rows($resultConta);

				
				
				if($dadosConta['nomeProjeto'] != ""){
?>
							<table class="tabela-menus" >
								<tr class="titulo-tabela" border="none">
									<th class="canto-esq">Código</th>
									<th>Título do Anúncio</th>
									<th>Tipo Projeto Pronto</th>
									<th>Preço</th>
									<th>Destaques</th>
									<th>Status</th>
									<th>Imagens</th>
									<th>Plantas</th>
									<th>Anexos</th>
									<th>Alterar</th>
									<th class="canto-dir">Excluir</th>
								</tr>	
<?php

					if($url[5] == 1 || $url[5] == ""){ 
						$pagina = 1;
						$sqlProjeto = "SELECT * FROM projetos WHERE codProjeto !=''".$filtraCidade.$filtraBairro.$filtraTipo.$filtraQuadra.$filtraLote." ORDER BY statusProjeto ASC, destaqueProjeto ASC, codProjeto DESC LIMIT 0,30";
					}else{
						$pagina = $url[5];
						$paginaFinal = $pagina * 30;
						$paginaInicial = $paginaFinal - 30;
						$sqlProjeto = "SELECT * FROM projetos WHERE codProjeto !=''".$filtraCidade.$filtraBairro.$filtraTipo.$filtraQuadra.$filtraLote." ORDER BY statusProjeto ASC, destaqueProjeto ASC, codProjeto DESC LIMIT ".$paginaInicial.",30";
					}		
		
					$resultProjeto = $conn->query($sqlProjeto);
					while($dadosProjeto = $resultProjeto->fetch_assoc()){
						$mostrando = $mostrando + 1;
								
						if($dadosProjeto['statusProjeto'] == "T"){
							$status = "status-ativo";
							$statusIcone = "ativado";
							$statusPergunta = "desativar";
						}else{
							$status = "status-desativado";
							$statusIcone = "desativado";
							$statusPergunta = "ativar";
						}					
						
						if($dadosProjeto['destaqueProjeto'] == "T"){
							$destaque = "destaque-ativado";
							$destaqueIcone = "ativado";
							$destaquePergunta = "retirar o imóvel ";
						}else{
							$destaque = "destaque-desativado";
							$destaqueIcone = "desativado";
							$destaquePergunta = "colocar o ";
						}	
														
						$sqlTipo = "SELECT * FROM tipoProjeto WHERE statusTipoProjeto = 'T' and codTipoProjeto = ".$dadosProjeto['codTipoProjeto']." ORDER BY codTipoProjeto DESC LIMIT 0,1";
						$resultTipo = $conn->query($sqlTipo);
						$dadosTipo = $resultTipo->fetch_assoc();

						$sqlImagem = "SELECT * FROM projetosImagens WHERE codProjeto = ".$dadosProjeto['codProjeto']." ORDER BY ordenacaoProjetoImagem ASC LIMIT 0,1";
						$resultImagem = $conn->query($sqlImagem);
						$dadosImagem = $resultImagem->fetch_assoc();			
						
						$sqlImagemP = "SELECT * FROM plantasImagens WHERE codProjeto = ".$dadosProjeto['codProjeto']." ORDER BY ordenacaoPlantaImagem ASC LIMIT 0,1";
						$resultImagemP = $conn->query($sqlImagemP);
						$dadosImagemP = $resultImagemP->fetch_assoc();

?>
								<tr class="tr">
									<td class="dez" style="width:8%; text-align:center;"><a style="padding:0px;" href='<?php echo $configUrlGer; ?>projetos/pronto/alterar/<?php echo $dadosProjeto['codProjeto'] ?>/' title='Veja os detalhes do imóvel <?php echo $dadosProjeto['nomeProjeto'] ?>'><?php echo $dadosProjeto['codigoProjeto'];?></a></td>
									<td class="vinte" style="text-align:left;"><a style="padding:0px;" href='<?php echo $configUrlGer; ?>projetos/pronto/alterar/<?php echo $dadosProjeto['codProjeto'] ?>/' title='Veja os detalhes do imóvel <?php echo $dadosProjeto['nomeProjeto'] ?>'><?php echo $dadosProjeto['nomeProjeto'];?></a></td>
									<td class="doze" style="text-align:center;"><a style="padding:0px;" href='<?php echo $configUrlGer; ?>projetos/pronto/alterar/<?php echo $dadosProjeto['codProjeto'] ?>/' title='Veja os detalhes do imóvel <?php echo $dadosProjeto['nomeProjeto'] ?>'><?php echo $dadosTipo['nomeTipoProjeto'];?></a></td>
									<td class="vinte" style="text-align:center;"><a style="padding:0px;" href='<?php echo $configUrlGer; ?>projetos/pronto/alterar/<?php echo $dadosProjeto['codProjeto'] ?>/' title='Veja os detalhes do imóvel <?php echo $dadosProjeto['nomeProjeto'] ?>'>R$ <?php echo number_format($dadosProjeto['precoProjeto'], 2, ",", ".");?></a></td>
									<td class="botoes" style="width:5%;"><a style="padding:0px;" href='<?php echo $configUrl; ?>projetos/pronto/destaque/<?php echo $dadosProjeto['codProjeto'] ?>/' title='Deseja <?php echo $destaquePergunta ?> <?php echo $dadosProjeto['nomeProjeto'] ?> do site ?' ><img src="<?php echo $configUrl; ?>f/i/<?php echo $destaque ?>.png" alt="icone"></a></td>
									<td class="botoes" style="width:5%;"><a style="padding:0px;" href='<?php echo $configUrl; ?>projetos/pronto/ativacao/<?php echo $dadosProjeto['codProjeto'] ?>/' title='Deseja <?php echo $statusPergunta ?> o imóvel <?php echo $dadosProjeto['nomeProjeto'] ?>?' ><img src="<?php echo $configUrl; ?>f/i/default/corpo-default/<?php echo $status ?>.gif" alt="icone"></a></td>
									<td class="botoes" style="width:5%;"><a style="padding:0px;" href='<?php echo $configUrl; ?>projetos/pronto/imagens/<?php echo $dadosProjeto['codProjeto'] ?>/' title='Deseja gerenciar imagens do imóvel <?php echo $dadosProjeto['nomeProjeto'] ?>?' ><img style="<?php echo $dadosImagem['codProjetoImagem'] == "" ? 'display:none;' : 'padding-top:5px;';?>" src="<?php echo $configUrlGer.'f/projetos/'.$dadosImagem['codProjeto'].'-'.$dadosImagem['codProjetoImagem'].'-W.webp';?>" height="50"/><img style="<?php echo $dadosImagem['codProjetoImagem'] != "" ? 'display:none;' : '';?>" src="<?php echo $configUrl; ?>f/i/default/corpo-default/gerenciar-imagens.gif" alt="icone"></a></td>
									<td class="botoes" style="width:5%;"><a style="padding:0px;" href='<?php echo $configUrl; ?>projetos/pronto/plantaImagens/<?php echo $dadosProjeto['codProjeto'] ?>/' title='Deseja gerenciar imagens do imóvel <?php echo $dadosProjeto['nomeProjeto'] ?>?' ><img style="<?php echo $dadosImagemP['codPlantaImagem'] == "" ? 'display:none;' : 'padding-top:5px;';?>" src="<?php echo $configUrlGer.'f/plantas/'.$dadosImagemP['codProjeto'].'-'.$dadosImagemP['codPlantaImagem'].'-O.'.$dadosImagemP['extPlantaImagem'];?>" height="50"/><img style="<?php echo $dadosImagemP['codPlantaImagem'] != "" ? 'display:none;' : '';?>" src="<?php echo $configUrl; ?>f/i/default/corpo-default/gerenciar-imagens.gif" alt="icone"></a></td>
									<td class="botoes"><a href='<?php echo $configUrl; ?>projetos/pronto/anexos/<?php echo $dadosProjeto['codProjeto'] ?>/' title='Deseja cadastrar anexos para o imóvel <?php echo $dadosProjeto['nomeProjeto'] ?>?' ><img src="<?php echo $configUrl;?>f/i/geren-documentos.png" alt="icone"/></a></td>
									<td class="botoes" style="width:5%;"><a style="padding:0px;" href='<?php echo $configUrl; ?>projetos/pronto/alterar/<?php echo $dadosProjeto['codProjeto'] ?>/' title='Deseja alterar o imóvel <?php echo $dadosProjeto['nomeProjeto'] ?>?' ><img src="<?php echo $configUrl;?>f/i/default/corpo-default/icones-alterar.gif" alt="icone" /></a></td>
									<td class="botoes" style="width:5%;"><a style="padding:0px;" href='javascript: confirmaExclusao(<?php echo $dadosProjeto['codProjeto'] ?>, "<?php echo htmlspecialchars($dadosProjeto['nomeProjeto']) ?>");' title='Deseja excluir o imóvel <?php echo $dadosProjeto['nomeProjeto'] ?>?' ><img src='<?php echo $configUrl; ?>f/i/default/corpo-default/excluir.gif' alt="icone"></a></td>
								</tr>
<?php			
					}	
?>
								<script type="text/javascript">
									function confirmaExclusao(cod, nome){
										if(confirm("Deseja excluir o imóvel "+nome+"?")){
											window.location='<?php echo $configUrlGer; ?>projetos/pronto/excluir/'+cod+'/';
										}
									}
								</script> 
							</table>
<?php
				}
?>
						</div>		
<?php			
			$regPorPagina = 30;
			$area = "projetos/pronto";
			include ('f/conf/paginacao.php');		
?>							
					</div>
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
