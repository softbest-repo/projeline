<?php
	if($_COOKIE['loginAprovado'.$cookie] != ""){

		if($controleUsuario == "tem usuario"){
			
			$area = "vendas";
			include('f/conf/validaAcesso.php');
			if($validaAcesso == "ok"){	

				$query = "SELECT * FROM vendas WHERE codVenda = '".$url[6]."'";
				$result = $conn->query($query);
				$vendas = $result->fetch_assoc();

				$sqlCliente = "SELECT * FROM clientes WHERE codCliente = ".$vendas['codCliente'];
				$resultCliente = $conn->query($sqlCliente);
				$dadosCliente = $resultCliente->fetch_assoc();
					
				$dataVenda = explode(" ", $vendas['dataVenda']);				
?>
				<div id="localizacao-topo">
					<div id="conteudo-localizacao-topo">
						<p class="nome-lista">Atendimento</p>
						<p class="flexa"></p>
						<p class="nome-lista">Vendas</p>
						<p class="flexa"></p>
						<p class="nome-lista">Detalhes</p>
						<p class="flexa"></p>
						<p class="nome-lista"><?php echo $dadosCliente['nomeCliente'] ;?> <?php echo $dadosCliente['sobrenomeCliente'] ;?></p>
						<br class="clear" />
					</div>
					<div class="botao-consultar" style="float:left;"><a title="Consultar Vendas" href="<?php echo $configUrl;?>atendimento/vendas/"><div class="esquerda-consultar"></div><div class="conteudo-consultar">Consultar</div><div class="direita-consultar"></div></a></div>					
					<br class="clear" />
				</div>
				<div id="dados-conteudo">
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

				$dataVenda = explode(" ", $vendas['dataVenda']);				
?>
					<div id="cadastrar" style="width:1024px;">
<?php				
				if($vendas['statusVenda'] == "NOT_MADE"){
					$status = "Pagamento não Efetuado";
					$backgroundColor = "#ff0000";
					$color = "#FFF";
				}else
				if($vendas['statusVenda'] == "CANCELLED"){
					$status = "Pagamento Cancelado";
					$backgroundColor = "#bf0000";
					$color = "#FFF";
				}else
				if($vendas['statusVenda'] == "DECLINED"){
					$status = "Pagamento Negado";
					$backgroundColor = "#ff4d4d";
					$color = "#FFF";
				}else
				if($vendas['statusVenda'] == "REFUNDED"){
					$status = "Pagamento Devolvido";
					$backgroundColor = "#ff8080";
					$color = "#FFF";
				}else						
				if($vendas['statusVenda'] == "CHARGEDBACK"){
					$status = "Pagamento Estornado";
					$backgroundColor = "#ffb3b3";
					$color = "#333";						
				}else						
				if($vendas['statusVenda'] == "WAITING"){
					$status = "Aguardando Pagamento";					
					$backgroundColor = "#fbaa14";
					$color = "#333";					
				}else
				if($vendas['statusVenda'] == "IN_ANALYSIS"){
					$status = "Em Análise";					
					$backgroundColor = "#ffc966";
					$color = "#333";					
				}else
				if($vendas['statusVenda'] == "AUTHORIZED"){
					$status = "Pagamento Autorizado";
					$backgroundColor = "#c7e4f6";
					$color = "#333";																
				}else
				if($vendas['statusVenda'] == "PAID"){
					$status = "Pagamento Aprovado";
					$backgroundColor = "#99d6ff";
					$color = "#333";																
				}	
?>
						<div class="rastreamento" style="display:table; margin-bottom:20px;">
							<form id="statusChange" action="<?php echo $configUrlGer;?>atendimento/vendas/detalhes/<?php echo $url[6];?>/" method="post">
								<p><label style="color:#000; display:contents;">Status do Pedido</label>
									<select class="campo" name="alteraStatus" disabled="disabled" style="width:250px; color:<?php echo $color;?>; background:<?php echo $backgroundColor;?>;" onChange="alteraStatus2();">
										<option value="NOT_MADE" <?php echo $vendas['statusVenda'] == "NOT_MADE" ? "/SELECTED/" : "";?>>Pagamento não Efetuado</option>
										<option value="CANCELLED" <?php echo $vendas['statusVenda'] == "CANCELLED" ? "/SELECTED/" : "";?>>Pagamento Cancelado</option>
										<option value="DECLINED" <?php echo $vendas['statusVenda'] == "DECLINED" ? "/SELECTED/" : "";?>>Pagamento Recusado</option>
										<option value="REFUNDED" <?php echo $vendas['statusVenda'] == "REFUNDED" ? "/SELECTED/" : "";?>>Pagamento Estornado</option>
										<option value="CHARGEDBACK" <?php echo $vendas['statusVenda'] == "CHARGEDBACK" ? "/SELECTED/" : "";?>>Pagamento Devolvido</option>
										<option value="WAITING" <?php echo $vendas['statusVenda'] == "WAITING" ? "/SELECTED/" : "";?>>Aguardando Pagamento</option>
										<option value="IN_ANALYSIS" <?php echo $vendas['statusVenda'] == "IN_ANALYSIS" ? "/SELECTED/" : "";?>>Em Análise</option>
										<option value="AUTHORIZED" <?php echo $vendas['statusVenda'] == "AUTHORIZED" ? "/SELECTED/" : "";?>>Pagamento Autorizado</option>
										<option value="PAID" <?php echo $vendas['statusVenda'] == "PAID" ? "/SELECTED/" : "";?>>Pagamento Aprovado</option>
									</select>
								</p>
							</form>
							<script type="text/javascript">
								function alteraStatus2(){
									document.getElementById("statusChange").submit();
								}
							</script>
						</div>						
<?php		
			   $estados = array(
					'ACRE' => 'AC',
					'ALAGOAS' => 'AL',
					'AMAPÁ' => 'AP',
					'AMAZONAS' => 'AM',
					'BAHIA' => 'BA',
					'CEARÁ' => 'CE',
					'DISTRITO FEDERAL' => 'DF',
					'ESPÍRITO SANTO' => 'ES',
					'GOIÁS' => 'GO',
					'MARANHÃO' => 'MA',
					'MATO GROSSO' => 'MT',
					'MATO GROSSO DO SUL' => 'MS',
					'MINAS GERAIS' => 'MG',
					'PARÁ' => 'PA',
					'PARAÍBA' => 'PB',
					'PARANÁ' => 'PR',
					'PERNAMBUCO' => 'PE',
					'PIAUÍ' => 'PI',
					'RIO DE JANEIRO' => 'RJ',
					'RIO GRANDE DO NORTE' => 'RN',
					'RIO GRANDE DO SUL' => 'RS',
					'RONDÔNIA' => 'RO',
					'RORAIMA' => 'RR',
					'SANTA CATARINA' => 'SC',
					'SÃO PAULO' => 'SP',
					'SERGIPE' => 'SE',
					'TOCANTINS' => 'TO'
				);							

				$celularWhats = str_replace("(", "", $dadosCliente['fone1']); 
				$celularWhats = str_replace(")", "", $celularWhats); 
				$celularWhats = str_replace(" ", "", $celularWhats); 
				$celularWhats = str_replace("-", "", $celularWhats); 

				if(strlen($dadosCliente['nomeCompleto']) >= 48 && strlen($dadosCliente['nomeCompleto']) <= 53){
					$fontCliente = "10px";
					$nomeCliente = $dadosCliente['nomeCompleto'];
				}else
				if(strlen($dadosCliente['nomeCompleto']) >= 54){
					$fontCliente = "10px";
					$nomeCliente = mb_strimwidth(strip_tags($dadosCliente['nomeCompleto']), 0, 53, "...");
				}else{
					$fontCliente = "11px;";
					$nomeCliente = $dadosCliente['nomeCompleto'];
				}		
				
				if($vendas['statusVenda'] == "PAID"){
					$sqlVendasInfo = "SELECT * FROM vendasInfo WHERE codVenda = '".$vendas['codVenda']."' and statusVendaInfo = '".$vendas['statusVenda']."'";
					$resultVendasInfo = $conn->query($sqlVendasInfo);
					$dadosVendaInfo = $resultVendasInfo->fetch_assoc();
					
					$jsonVendaInfo = json_decode($dadosVendaInfo['jsonVendaInfo'], true);
					$tipoPagamento = $jsonVendaInfo['charges'][0]['payment_method']['type'];
				}else{
					$tipoPagamento = "--";
				}
?>										
						<div id="exibe-faturamento">
							<table style="width:100%; border-collapse:collapse;">
								<tr border="none">
									<th rowspan="2" style="width:5%; color:#000; padding:5px; border:1px solid #000; font-size:12px; font-weight:bold; text-align:right; background-color:#d9d9d9;">Nº: </th>
									<th rowspan="2" style="width:8%; color:#000; padding:5px; border:1px solid #000; font-size:18px; font-weight:700; text-align:left;"><?php echo $vendas['codVenda'];?></th>
									<th rowspan="2" style="width:8%; color:#000; padding:5px; border:1px solid #000; font-size:12px; font-weight:bold; text-align:right; background-color:#d9d9d9;">DATA: </th>
									<th rowspan="2" style="width:15%; color:#000; padding:5px; border:1px solid #000; font-size:18px; font-weight:700; text-align:left;"><?php echo data($dataVenda[0]);?></th>
								</tr>	
								<tr border="none">
									<th style="width:10%; color:#000; padding:3px; border:1px solid #000; font-size:12px; font-weight:bold; text-align:right; background-color:#d9d9d9;">PGT: </th>
									<th colspan="3" style="width:10%; color:#000; padding:3px; border:1px solid #000; font-size:12px; font-weight:500; text-align:left;dadosCliente"><?php echo $tipoPagamento == 'CREDIT_CARD' ? 'Cartão de Crédito' : $tipoPagamento;?></th>
								</tr>	
							</table>
							<table style="width:100%; margin-top:10px; border-collapse:collapse;">
								<tr border="none">
									<th style="width:5%; color:#000; padding:5px; border:1px solid #000; font-size:12px; font-weight:bold; text-align:right; background-color:#d9d9d9;">CLIENTE: </th>
									<th style="width:40%; color:#000; padding:5px; border:1px solid #000; font-size:12px; font-weight:500; text-align:left;dadosCliente"><?php echo $dadosCliente['nomeCliente'];?> <?php echo $dadosCliente['sobrenomeCliente'];?></th>
									<th style="width:6%; color:#000; padding:5px; border:1px solid #000; font-size:12px; font-weight:bold; text-align:right; background-color:#d9d9d9;">CPF:</th>
									<th colspan="3" style="width:20%; color:#000; padding:5px; border:1px solid #000; font-size:12px; font-weight:500; text-align:left;dadosCliente"><?php echo $dadosCliente['cpfCliente'];?></th>
								</tr>	
								<tr border="none">
									<th style="width:5%; color:#000; padding:5px; border:1px solid #000; font-size:12px; font-weight:bold; text-align:right; background-color:#d9d9d9;">E-MAIL: </th>
									<th style="width:40%; color:#000; padding:5px; border:1px solid #000; font-size:12px; font-weight:500; text-align:left;dadosCliente"><?php echo $dadosCliente['emailCliente'];?></th>
									<th style="width:6%; color:#000; padding:5px; border:1px solid #000; font-size:12px; font-weight:bold; text-align:right; background-color:#d9d9d9;">Celular 1: </th>
									<th style="width:15%; color:#000; padding:5px; border:1px solid #000; font-size:12px; font-weight:500; text-align:left;dadosCliente"><a style="color:#000; font-size:12px; font-weight:500;" target="_blank" href='https://api.whatsapp.com/send?1=pt_BR&amp;phone=55<?php echo $celularWhats;?>' title='Clique para iniciar uma conversa no WhatsApp'><?php echo $dadosCliente['celularCliente'];?></a></th>
									<th style="width:6%; color:#000; padding:5px; border:1px solid #000; font-size:12px; font-weight:bold; text-align:right; background-color:#d9d9d9;">Celular 2: </th>
									<th style="width:15%; color:#000; padding:5px; border:1px solid #000; font-size:12px; font-weight:500; text-align:left;dadosCliente"><?php echo $dadosCliente['celular2Cliente'];?></th>
								</tr>	
							</table>	
							<table style="width:100%; margin-top:10px; border-collapse:collapse;">	
								<tr border="none">
									<th style="width:5%; color:#000; padding:5px; border:1px solid #000; font-size:12px; font-weight:bold; text-align:right; background-color:#d9d9d9;">CIDADE: </th>
									<th style="width:25%; color:#000; padding:5px; border:1px solid #000; font-size:12px; font-weight:500; text-align:left;dadosCliente border-top:none;"><?php echo $dadosCliente['cidadeCliente'];?></th>
									<th style="width:5%; color:#000; padding:5px; border:1px solid #000; font-size:12px; font-weight:bold; text-align:right; background-color:#d9d9d9;">UF: </th>
									<th style="width:10%; color:#000; padding:5px; border:1px solid #000; font-size:12px; font-weight:500; text-align:left;dadosCliente border-top:none;"><?php echo $dadosCliente['estadoCliente'];?></th>
								</tr>		
							</table>																																							
							<table style="width:100%; margin-top:10px; border-collapse:collapse;">
								<tr border="none" style="">
									<th style="color:#000; padding:3px; border:1px solid #000; font-size:14px;">QTD</th>
									<th style="color:#000; padding:3px; border:1px solid #000; font-size:14px;">PROJETO</th>
									<th class="retirar" style="color:#000; padding:3px; border:1px solid #000; font-size:14px;">VALOR</th>
								</tr>						
<?php         
				$entra5 = "";
				
				$contTotal = 0;
				$contTudo = 0;
				$contFundo = 0;
				$totalDaVenda = 0;
				$totalQuantidade = 0;
				$totalItens = 0;
				
				$sqlItemTotal = "SELECT count(codVendaItem) total FROM vendasItens WHERE codVenda = '".$url[6]."'";
				$resultItemTotal = $conn->query($sqlItemTotal);
				$dadosItemTotal = $resultItemTotal->fetch_assoc();
				
				$sqlItem = "SELECT * FROM vendasItens WHERE codVenda = '".$url[6]."' ORDER BY codVendaItem ASC";
				$resultItem = $conn->query($sqlItem);
				while($dadosItem = $resultItem->fetch_assoc()){     
					
					$contTotal++;
					$contTudo++;
					$contFundo++;

					if($dadosItem['codProjeto'] != 0 && $dadosItem['codProjetoComplementar'] == 0){
					
						$sqlProjeto = "SELECT * FROM projetos WHERE codProjeto = ".$dadosItem['codProjeto']." LIMIT 0,1";
						$resultProjeto = $conn->query($sqlProjeto);
						$dadosProjeto = $resultProjeto->fetch_assoc();

						$sqlImagem = "SELECT * FROM projetosImagens WHERE codProjeto = ".$dadosProjeto['codProjeto']." ORDER BY ordenacaoProjetoImagem ASC, codProjetoImagem ASC LIMIT 0,1";
						$resultImagem = $conn->query($sqlImagem);
						$dadosImagem = $resultImagem->fetch_assoc();
				
						if($dadosImagem['codProjetoImagem'] != ""){
							$img = $configUrlGer.'f/projetos/'.$dadosImagem['codProjeto'].'-'.$dadosImagem['codProjetoImagem'].'-P.'.$dadosImagem['extProjetoImagem'];
							$imgG = $configUrlGer.'f/projetos/'.$dadosImagem['codProjeto'].'-'.$dadosImagem['codProjetoImagem'].'-G.'.$dadosImagem['extProjetoImagem'];
						}	
					}
					
					if($contFundo == 2){
						$contFundo = 0;
						$fundo = "background-color:#fff;";
					}else{
						$fundo = "background-color:#d9d9d9;";
					}						
?>
								<tr style="width:100%; height:73px; max-height:100px; overflow:hidden; <?php echo $fundo;?>">
									<td style="width:20%; text-align:center; color:#000; font-size:50px; font-weight:bold; border:1px solid #000;">1</td>
									<td style="width:60%; padding:4px 4px; vertical-align:initial; text-align:center; text-align:left; border:1px solid #000;">
										<div style="width:100%;">
											<p style="height:64px; overflow:hidden; display:table-cell; vertical-align:middle; padding-left:20px;"><span style="color:#000; display:block; font-size:14px; font-weight:bold; text-align:center;"><?php echo $dadosItem['nomeItemVenda'];?></span></p>
										</div>
									</td>
									<td style="width:20%; text-align:center; color:#000; font-weight:bold; border:1px solid #000; font-size:15px;">R$ <?php echo number_format($dadosItem['valorItemVenda'], 2, ",", "."); ?></td>
								</tr>
<?php
					$totalProjeto = $totalProjeto + $dadosItem['valorItemVenda'];
					$totalQuantidade = $totalQuantidade + 1;
				}
?>
							<table style="width:100%; margin-top:10px; border-collapse:collapse;">
								<tr border="none" style="background-color:#d9d9d9;">
									<th style="width:20%; color:#000; padding:3px; border:1px solid #000; font-size:15px;">QTD</th>
									<th style="width:60%; color:#000; padding:3px; border:1px solid #000; font-size:15px;">QTD ITENS</th>
									<th colspan="2" style="width:20%; color:#000; padding:3px; border:1px solid #000; font-size:15px;">VALOR TOTAL</th>
								</tr>	
								<tr border="none">
									<th style="width:20%; color:#000; padding:3px; border:1px solid #000; font-size:15px;"><?php echo $totalQuantidade;?></th>
									<th style="width:60%; color:#000; padding:3px; border:1px solid #000; font-size:15px;"><?php echo $totalQuantidade;?></th>
									<th style="width:20%; color:#000; padding:3px; border:1px solid #000; font-size:15px;">R$ <?php echo number_format($totalProjeto, 2, ",", ".");?></th>
								</tr>	
							</table>	
<?php								
				$vendaCompleta = $totalDaVenda + $vendas['ValorFrete'];   		
?>									
						</div> 										
						<div id="imprimir-faturamento" style="display:none;">
							<table style="width:100%; border-collapse:collapse;">
								<tr border="none">
									<th rowspan="2" style="width:5%; color:#000; padding:2px; border:1px solid #000; font-size:11px; font-weight:bold; text-align:right; background-color:#d9d9d9;">Nº: </th>
									<th rowspan="2" style="width:8%; color:#000; padding:2px; border:1px solid #000; font-size:16px; font-weight:700; text-align:left;"><?php echo $vendas['codVenda'];?></th>
									<th rowspan="2" style="width:8%; color:#000; padding:2px; border:1px solid #000; font-size:11px; font-weight:bold; text-align:right; background-color:#d9d9d9;">DATA: </th>
									<th rowspan="2" style="width:15%; color:#000; padding:2px; border:1px solid #000; font-size:16px; font-weight:700; text-align:left;"><?php echo data($dataVenda[0]);?></th>
									<th style="width:10%; color:#000; padding:2px; border:1px solid #000; font-size:11px; font-weight:bold; text-align:right; background-color:#d9d9d9;">PRAZO: </th>
									<th style="width:10%; color:#000; padding:2px; border:1px solid #000; font-size:11px; font-weight:500; text-align:left;"><?php echo $vendas['prazo'];?> DIAS</th>
									<th style="width:10%; color:#000; padding:2px; border:1px solid #000; font-size:11px; font-weight:bold; text-align:right; background-color:#d9d9d9;">TABELA: </th>
									<th style="width:10%; color:#000; padding:2px; border:1px solid #000; font-size:11px; font-weight:500; text-align:left;"><?php echo $tabela;?></th>
									<th rowspan="2" style="width:20%; color:#FFF; padding:2px; border:1px solid #000; font-size:13px; font-weight:700; text-align:center; background-color:#000;"><?php echo $dadosCliente['etiqueta'] == "C" ? 'COM ETIQUETA' : 'SEM ETIQUETA';?></th>
								</tr>	
								<tr border="none">
									<th style="width:10%; color:#000; padding:3px; border:1px solid #000; font-size:11px; font-weight:bold; text-align:right; background-color:#d9d9d9;">PGT: </th>
									<th colspan="3" style="width:10%; color:#000; padding:3px; border:1px solid #000; font-size:11px; font-weight:500; text-align:left;dadosCliente"><?php echo $vendas['condicoesVenda'];?>X NO <?php echo $vendas['formaVenda'];?></th>
								</tr>	
							</table>
						</div>	
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
