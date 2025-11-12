<?php
	if($_COOKIE['loginAprovado'.$cookie] != ""){

		if($controleUsuario == "tem usuario"){
			
			$area = "comparativos";
			include('f/conf/validaAcesso.php');
			if($validaAcesso == "ok"){
				
				$sqlNomePagamento = "SELECT codComparativo, nomeComparativo, statusComparativo FROM comparativos WHERE codComparativo = '".$url[6]."' LIMIT 0,1";
				$resultNomePagamento = $conn->query($sqlNomePagamento);
				$dadosNomePagamento = $resultNomePagamento->fetch_assoc();
				
?>
				<div id="localizacao-topo">
					<div id="conteudo-localizacao-topo">
						<p class="nome-lista">Cadastros</p>
						<p class="flexa"></p>
						<p class="nome-lista">Comparativo</p>
						<p class="flexa"></p>
						<p class="nome-lista">Alterar</p>
						<p class="flexa"></p>
						<p class="nome-lista"><?php echo $dadosNomePagamento['nomeComparativo'] ;?></p>
						<br class="clear" />
					</div>
					<table class="tabela-interno" >
<?php 
				if($dadosNomePagamento['statusComparativo'] == "T"){
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
							<td class="botoes-interno"><a href='<?php echo $configUrl; ?>cadastros/comparativos/ativacao/<?php echo $dadosNomePagamento['codComparativo'] ?>/' title='Deseja <?php echo $statusPergunta ?> o integrante da comparativos <?php echo $dadosNomePagamento['nomeComparativo'] ?>?' ><img src="<?php echo $configUrl; ?>f/i/default/corpo-default/<?php echo $status ?>-branco.gif" alt="icone"></a></td>
							<td class="botoes-interno"><a href='javascript: confirmaExclusao(<?php echo $dadosNomePagamento['codComparativo'] ?>, "<?php echo htmlspecialchars($dadosNomePagamento['nomeComparativo']) ?>");' title='Deseja excluir o integrante da comparativos <?php echo $dadosNomePagamento['nomeComparativo'] ?>?' ><img src='<?php echo $configUrl; ?>f/i/default/corpo-default/excluir-branco.gif' alt="icone"></a></td>
						</tr>
						<script>
							function confirmaExclusao(cod, nome){

								if(confirm("Deseja excluir o integrante da comparativos "+nome+"?")){
									window.location='<?php echo $configUrlGer; ?>cadastros/comparativos/excluir/'+cod+'/';
								}
							}
						</script>
					</table>	
					<div class="botao-consultar"><a title="Consultar Comparativo" href="<?php echo $configUrl;?>cadastros/comparativos/"><div class="esquerda-consultar"></div><div class="conteudo-consultar">Consultar</div><div class="direita-consultar"></div></a></div>					
				</div>
				<div id="dados-conteudo">
					<div id="cadastrar">
						<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
						<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.4/css/select2.min.css" rel="stylesheet" />
						<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.4/js/select2.min.js"></script>						
<?php 
				if(isset($_POST['alterar'])){

					include ('f/conf/criaUrl.php');
					$urlComparativo = criaUrl($_POST['nome']);

					$descricao = str_replace("../../../../", $configUrlGer, $_POST['descricao']);
					$descricao = str_replace("../../../../", $configUrlGer, $descricao);
					$descricao = str_replace("../../../../", $configUrlGer, $descricao);
					$descricao = str_replace("../../../../", $configUrlGer, $descricao);
					$descricao = str_replace("../../../../", $configUrlGer, $descricao);
					$descricao = str_replace("../../../../", $configUrlGer, $descricao);
					$descricao = str_replace("../../../../", $configUrlGer, $descricao);
					$descricao = str_replace("../../../../", $configUrlGer, $descricao);
					$descricao = str_replace("../../../../", $configUrlGer, $descricao);
					$descricao = str_replace("../../../../", $configUrlGer, $descricao);
					$descricao = str_replace("../../../../", $configUrlGer, $descricao);
					$descricao = str_replace("../../../../", $configUrlGer, $descricao);
					$descricao = str_replace("../../../../", $configUrlGer, $descricao);
					$descricao = str_replace("../../../../", $configUrlGer, $descricao);
					$descricao = str_replace("../../../../", $configUrlGer, $descricao);
					$descricao = str_replace("../../../../", $configUrlGer, $descricao);
					$descricao = str_replace("../../../../", $configUrlGer, $descricao);
					$descricao = str_replace("../../../../", $configUrlGer, $descricao);
					$descricao = str_replace("../../../../", $configUrlGer, $descricao);
					$descricao = str_replace("../../../../", $configUrlGer, $descricao);
											
					$sql = "UPDATE comparativos SET nomeComparativo = '".preparaNome($_POST['nome'])."', prazoComparativo = '".preparaNome($_POST['prazo'])."', cifraoComparativo = ".$_POST['cifra'].",  descricaoComparativo = '".str_replace("'", "&#39;", $descricao)."', urlComparativo = '".$urlComparativo."' WHERE codComparativo = '".$url[6]."'";
					$result = $conn->query($sql); 

					if($result == 1){
						$_SESSION['nome'] = $_POST['nome'];
						$_SESSION['alteracaos'] = "ok";

						$sqlCaracteristicaComparativo = "SELECT * FROM caracteristicasComparativos WHERE codComparativo = ".$url[6]."";
						$resultCaracteristicaComparativo = $conn->query($sqlCaracteristicaComparativo);
						$dadosCaracteristicaComparativo = $resultCaracteristicaComparativo->fetch_assoc();
						
						 $sqlCaracteristica = "SELECT *  FROM caracteristicasComparativos ORDER BY codCaracteristica ASC";
						$resultCaracteristica = $conn->query($sqlCaracteristica);
						while($dadosCaracteristicaLimpa = $resultCaracteristica->fetch_assoc()){

							$_SESSION['caracteristica'.$url[6].$dadosCaracteristicaLimpa['codCaracteristica']] = "";
						}



						for($i=1; $i<=$_POST['quantas']; $i++){
							if($i == 1){
								$sqlDelete = "DELETE FROM caracteristicasComparativos WHERE codComparativo = ".$url[6]."";
								$resultDelete = $conn->query($sqlDelete);
							}
							if($_POST['caracteristica'.$i] != ""){
								if (isset($_POST['destaqueCaracteristica'.$i])) {
									  $capa  = 'T';
							   } else {
									  $capa  = 'F';
							   }
								$sqlInsere = "INSERT INTO caracteristicasComparativos VALUES(0, ".$_POST['caracteristica'.$i].",'".$capa."',".$url[6].")";
								$resultInsere = $conn->query($sqlInsere);
							}
						}

						echo "<meta HTTP-EQUIV='Refresh' CONTENT='0;URL=".$configUrlGer."cadastros/comparativos/'>";
					}else{
						$erroData = "<p class='erro'>Problemas ao alterar integrante da comparativos!</p>";
					}

				}else{ 
					$sql = "SELECT * FROM comparativos WHERE codComparativo = ".$url[6];
					$result = $conn->query($sql);
					$dadosComparativo = $result->fetch_assoc();
					$_SESSION['nome'] = $dadosComparativo['nomeComparativo'];
					$_SESSION['prazo'] = $dadosComparativo['prazoComparativo'];
					$_SESSION['descricao'] = $dadosComparativo['descricaoComparativo'];
					$_SESSION['status'] = $dadosComparativo['statusComparativo'];
					$_SESSION['cifra'] = $dadosComparativo['cifraoComparativo'];
					
					$sqlCaracteristica = "SELECT *  FROM caracteristicas ORDER BY codCaracteristica ASC";
					$resultCaracteristica = $conn->query($sqlCaracteristica);
					while($dadosCaracteristicaLimpa = $resultCaracteristica->fetch_assoc()){
						$_SESSION['caracteristica'.$url[6].$dadosCaracteristicaLimpa['codCaracteristica']] = "";
						
						
					}
						
				 	$sqlCaracteristica = "SELECT *  FROM caracteristicasComparativos WHERE codComparativo = ".$dadosComparativo['codComparativo']." ORDER BY codCaracteristica ASC";
					$resultCaracteristica = $conn->query($sqlCaracteristica);
					while($dadosCaracteristica = $resultCaracteristica->fetch_assoc()){	
					 	$_SESSION['caracteristica'.$url[6].$dadosCaracteristica['codCaracteristica']] = "OK";
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
					
						<div class="botao-editar"><a title="Editar" href="javascript:habilitaCampo();"><div class="esquerda-editar"></div><div class="conteudo-editar">Editar</div><div class="direita-editar"></div></a></div>					
						<p class="obrigatorio">Campos obrigatórios *</p>
						<br/>
						<script>
							function habilitaCampo(){
								document.getElementById("nome").disabled = false;
								document.getElementById("prazo").disabled = false;
								document.getElementById("cifra").disabled = false;
								document.getElementById("alterar").disabled = false;
<?php
				$cont = 0;
				
				$sqlCaracteristica = "SELECT * FROM caracteristicas WHERE statusCaracteristica = 'T' ORDER BY codOrdenacaoCaracteristica ASC";
				$resultCaracteristica = $conn->query($sqlCaracteristica);
				while($dadosCaracteristica = $resultCaracteristica->fetch_assoc()){
					$cont++;
?>
							document.getElementById("caracteristica<?php echo $cont;?>").disabled = false;
<?php
				}
?>
								

							}
						</script> 
						<form action="<?php echo $configUrlGer; ?>cadastros/comparativos/alterar/<?php echo $url[6] ;?>/" method="post">

							<p class="bloco-campo-float"><label>Nome: <span class="obrigatorio"> * </span></label>
							<input id="nome" <?php echo $erroAtiva == "ok" ? "" : "disabled='disabled'";?> required class="campo" type="text" name="nome" style="width:500px;" value="<?php echo $_SESSION['nome']; ?>" /></p>

							<p class="bloco-campo-float"><label>Prazo: <span class="obrigatorio"> * </span> <span class="em" style="font-weight:normal;"> Ex: 7 dias </span></label>
							<input class="campo" type="text" id="prazo" name="prazo" <?php echo $erroAtiva == "ok" ? "" : "disabled='disabled'";?> style="width:131px;" 
							 value="<?php echo $_SESSION['prazo']; ?>" /></p>

							 <p class="bloco-campo-float"><label> Cifra(s): <span class="obrigatorio"> * <span class="em" style="font-weight:normal;"> Max 5 </span> </label>
							<input class="campo" type="number" name="cifra"  <?php echo $erroAtiva == "ok" ? "" : "disabled='disabled'";?> style="width:131px;" value="<?php echo $_SESSION['cifra']; ?>" min="0" max="5" id="cifra" />
							
						
							<div class="bloco-campo" style="margin-bottom:25px; width: 833px;"><label>Características:<span class="obrigatorio"> </span></label>
							<label  style="font-size: 12px; margin-bottom:10px;">*Máximo duas características na capa por imóvel.*</label>
								<div style="display: flex; display: flex; width: 833px; flex-wrap: wrap;">
<?php
				$cont = 0;
				$contTodas = 0;
				
				$sqlCaracteristica = "SELECT * FROM caracteristicas WHERE statusCaracteristica = 'T' ORDER BY codOrdenacaoCaracteristica ASC";
				$resultCaracteristica = $conn->query($sqlCaracteristica);
				while($dadosCaracteristica = $resultCaracteristica->fetch_assoc()){

					$sqlCaracteristicaComparativo = "SELECT * FROM caracteristicasComparativos WHERE codCaracteristica = '".$dadosCaracteristica['codCaracteristica']."'";
					$resultCaracteristicaComparativo = $conn->query($sqlCaracteristicaComparativo);
					$dadosCaracteristicaComparativo = $resultCaracteristicaComparativo->fetch_assoc();
					
					$cont++;
					$contTodas++;
?>				
										<label style="font-weight:normal; height:20px; cursor:pointer; font-size:14px; margin-top:5px; margin-right: 5px; margin-left: 5px;"><input type="checkbox" style="cursor:pointer;" <?php echo $erroAtiva == "ok" ? "" : "disabled='disabled'";?> value="<?php echo $dadosCaracteristica['codCaracteristica'];?>" <?php echo $_SESSION['caracteristica'.$url[6].$dadosCaracteristica['codCaracteristica']] == 'OK' ? 'checked' : '';?> id="caracteristica<?php echo $contTodas;?>" name="caracteristica<?php echo $contTodas;?>"/> <?php echo $dadosCaracteristica['nomeCaracteristica'];?></label>
										
<?php
					if($cont == 5){
						$cont = 0;
?>
									<br class="clear"/>
<?php
					}

				}
				
?>
									<input type="hidden" value="<?php echo $contTodas;?>" name="quantas"/>
									<br class="clear"/>
								</div>
							</div>


							<p class="bloco-campo" style="width:830px;"><label>Descrição:<span class="obrigatorio"> </span></label>
							<textarea class="campo textarea" id="descricao" name="descricao" type="text" style="width:400px; height:200px;" ><?php echo $_SESSION['descricao']; ?></textarea></p>

							<p class="bloco-campo"><div class="botao-expansivel"><p class="esquerda-botao"></p><input class="botao" id="alterar" <?php echo $erroAtiva == "ok" ? "" : "disabled='disabled'";?> type="submit" name="alterar" title="Alterar" value="Alterar" /><p class="direita-botao"></p></div></p>						
							<br class="clear"/>
						</form>
					</div>
					<script>
						const cifra = document.getElementById('cifra');
						
						cifra.addEventListener('input', function() {
							if (parseInt(cifra.value) > 5) {
								cifra.value = 0;
							}
						});
					</script>
				</div>
				<script>
					var $rf = jQuery.noConflict();
					$rf(".select2").select2();				
				</script>				
<?php
				if($_SESSION['erro'] == "ok"){
					$_SESSION['nome'] = "";
					$_SESSION['celular'] = "";
					$_SESSION['descricao'] = "";
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
