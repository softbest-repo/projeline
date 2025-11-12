<?php
	ini_set('display_errors', '0');
	error_reporting(E_ALL | E_STRICT);

	include('../../f/conf/config.php');
	include('../../f/conf/functions.php');
	include('../../f/conf/validaAcesso.php');

	$busca = $_GET['busca'];
			
	$busca = str_replace("-", " ", $busca);
	$busca = str_replace("-", " ", $busca);
	$busca = str_replace("-", " ", $busca);
	$busca = str_replace("-", " ", $busca);
	$busca = str_replace("-", " ", $busca);
	$busca = str_replace("-", " ", $busca);
	$busca = str_replace("-", " ", $busca);
	$busca = str_replace("-", " ", $busca);
	$busca = str_replace("-", " ", $busca);


	$busca = str_replace("'", "&#39;", $busca);	
	$pedacos = explode(" ", $busca);	
	$numero = count($pedacos);
	
	$order = explode(" ", $busca);
?>
							<table class="tabela-menus" >
								<tr class="titulo-tabela" border="none">
									<th class="canto-esq">Nº Pedido</th>
									<th>Cliente</th>
									<th>Celular</th>
									<th>Status</th>
									<th>Total</th>
									<th>Data e Hora</th>
									<th>Detalhes</th>
									<th class="canto-dir">Excluir</th>
								</tr>						
<?php
	if($numero >= 1){
		$sqlVendas = "SELECT * FROM vendas V inner join clientes C on V.CodCliente = C.codCliente WHERE V.codVenda != '' and (V.codVenda LIKE '%".$order[0]."%') or (C.nomeCliente LIKE '%".$order[0]."%' and C.nomeCliente LIKE '%".$order[1]."%' and C.nomeCliente LIKE '%".$order[2]."%' and C.nomeCliente LIKE '%".$order[3]."%' and C.nomeCliente LIKE '%".$order[4]."%') or (C.sobrenomeCliente LIKE '%".$order[0]."%' and C.sobrenomeCliente LIKE '%".$order[1]."%' and C.sobrenomeCliente LIKE '%".$order[2]."%' and C.sobrenomeCliente LIKE '%".$order[3]."%' and C.sobrenomeCliente LIKE '%".$order[4]."%') ORDER BY locate('".$order[0]."',C.nomeCliente), locate('".$order[1]."',C.nomeCliente), locate('".$order[2]."',C.nomeCliente), locate('".$order[3]."',C.nomeCliente), locate('".$order[4]."',C.nomeCliente), V.statusVenda ASC, V.dataVenda DESC, V.codVenda DESC LIMIT 0,30";		
	}
	
	if($busca == ""){
		$sqlVendas = "SELECT * FROM vendas V inner join clientes C on V.codCliente = C.codCliente WHERE V.codVenda != '' ORDER BY statusVenda ASC, V.dataVenda DESC, V.codVenda DESC";
	}
	$resultVendas = $conn->query($sqlVendas);
	while($dadosVendas = $resultVendas->fetch_assoc()){
	
		$dataVenda = explode(" ", $dadosVendas['dataVenda']);
										
		$celularWhats = str_replace("(", "", $dadosVendas['celularCliente']); 
		$celularWhats = str_replace(")", "", $celularWhats); 
		$celularWhats = str_replace(" ", "", $celularWhats); 
		$celularWhats = str_replace("-", "", $celularWhats); 

		if($dadosVendas['statusVenda'] == "NOT_MADE"){
			$status = "Pagamento não Realizado";
			$backgroundColor = "#ff0000";
			$color = "#FFF";
		}else
		if($dadosVendas['statusVenda'] == "CANCELLED"){
			$status = "Pagamento Cancelado";
			$backgroundColor = "#bf0000";
			$color = "#FFF";
		}else
		if($dadosVendas['statusVenda'] == "DECLINED"){
			$status = "Pagamento Negado";
			$backgroundColor = "#ff4d4d";
			$color = "#FFF";
		}else
		if($dadosVendas['statusVenda'] == "REFUNDED"){
			$status = "Pagamento Devolvido";
			$backgroundColor = "#ff8080";
			$color = "#FFF";
		}else						
		if($dadosVendas['statusVenda'] == "CHARGEDBACK"){
			$status = "Pagamento Estornado";
			$backgroundColor = "#ffb3b3";
			$color = "#333";						
		}else						
		if($dadosVendas['statusVenda'] == "WAITING"){
			$status = "Aguardando Pagamento";					
			$backgroundColor = "#fbaa14";
			$color = "#333";					
		}else
		if($dadosVendas['statusVenda'] == "IN_ANALYSIS"){
			$status = "Em Análise";					
			$backgroundColor = "#ffc966";
			$color = "#333";					
		}else
		if($dadosVendas['statusVenda'] == "AUTHORIZED"){
			$status = "Pagamento Autorizado";
			$backgroundColor = "#c7e4f6";
			$color = "#333";																
		}else
		if($dadosVendas['statusVenda'] == "PAID"){
			$status = "Pagamento Aprovado";
			$backgroundColor = "#99d6ff";
			$color = "#333";																
		}								
?>
								<tr class="tr">
									<td class="dez" style="text-align:center;"><a href='<?php echo $configUrlGer; ?>atendimento/vendas/detalhes/<?php echo $dadosVendas['codVenda'] ?>/' title='Veja os detalhes da venda do cliente <?php echo $dadosVendas['nomeCompleto'] ?>'><?php echo $dadosVendas['codVenda'];?></a></td>
									<td class="trinta"><a href='<?php echo $configUrlGer; ?>atendimento/vendas/detalhes/<?php echo $dadosVendas['codVenda'] ?>/' title='Veja os detalhes da venda do cliente <?php echo $dadosVendas['nomeCliente'] ?>'><?php echo $dadosVendas['nomeCliente'];?> <?php echo $dadosVendas['sobrenomeCliente'];?></a></td>
									<td class="vinte" style="text-align:center;"><a target="_blank" href='https://api.whatsapp.com/send?1=pt_BR&amp;phone=55<?php echo $celularWhats;?>' title='Clique para iniciar uma conversa no WhatsApp'><?php echo $dadosVendas['celularCliente'];?></a></td>
									<td class="dez" style="text-align:center;"><a href='<?php echo $configUrlGer; ?>atendimento/vendas/detalhes/<?php echo $dadosVendas['codVenda'] ?>/' title='Veja os detalhes da venda do cliente <?php echo $dadosVendas['nomeCompleto'] ?>'>R$ <?php echo number_format($dadosVendas['valorVenda'], 2, ",", ".");?></a></td>
									<td class="vinte" style="text-align:center;">
										<select class="campo" name="categoria" style="width:200px; color:<?php echo $color;?>; background:<?php echo $backgroundColor;?>;" onChange="alteraStatus(this.value, '<?php echo $dadosVendas['codVenda'];?>');">
											<option value="NOT_MADE" <?php echo $vendas['statusVenda'] == "NOT_MADE" ? "/SELECTED/" : "";?>>Pagamento não Efetuado</option>	
											<option value="CANCELLED" <?php echo $dadosVendas['statusVenda'] == "CANCELLED" ? "/SELECTED/" : "";?>>Pagamento Cancelado</option>
											<option value="DECLINED" <?php echo $dadosVendas['statusVenda'] == "DECLINED" ? "/SELECTED/" : "";?>>Pagamento Recusado</option>
											<option value="REFUNDED" <?php echo $dadosVendas['statusVenda'] == "REFUNDED" ? "/SELECTED/" : "";?>>Pagamento Estornado</option>
											<option value="CHARGEDBACK" <?php echo $dadosVendas['statusVenda'] == "CHARGEDBACK" ? "/SELECTED/" : "";?>>Pagamento Devolvido</option>
											<option value="WAITING" <?php echo $dadosVendas['statusVenda'] == "WAITING" ? "/SELECTED/" : "";?>>Aguardando Pagamento</option>
											<option value="IN_ANALYSIS" <?php echo $dadosVendas['statusVenda'] == "IN_ANALYSIS" ? "/SELECTED/" : "";?>>Em Análise</option>
											<option value="AUTHORIZED" <?php echo $dadosVendas['statusVenda'] == "AUTHORIZED" ? "/SELECTED/" : "";?>>Pagamento Autorizado</option>
											<option value="PAID" <?php echo $dadosVendas['statusVenda'] == "PAID" ? "/SELECTED/" : "";?>>Pagamento Aprovado</option>
										</select>
									</td> 									
									<td class="vinte" style="text-align:center;"><a style="text-align:center; display:block;" href='<?php echo $configUrlGer; ?>atendimento/vendas/detalhes/<?php echo $dadosVendas['codVenda'] ?>/' title='Veja os detalhes da venda do cliente <?php echo $dadosVendas['nomeCompleto'] ?>'><?php echo data($dataVenda[0]);?><br/><?php echo $dataVenda[1];?></a></td>
									<td class="botoes"><a href="<?php echo $configUrlGer; ?>atendimento/vendas/detalhes/<?php echo $dadosVendas['codVenda'] ?>/" title='Veja os detalhes da venda do cliente <?php echo $dadosVendas['nomeCliente'] ?>?' ><img style="padding-top:10px;" src='<?php echo $configUrl; ?>f/i/detalhes.svg' width="45" alt="icone"></a></td>
									<td class="botoes"><a href='javascript: confirmaExclusao(<?php echo $dadosVendas['codVenda'] ?>, "<?php echo htmlspecialchars($dadosVendas['nomeCompleto']) ?>");' title='Deseja excluir a venda do cliente <?php echo $dadosVendas['nomeCompleto'] ?>?' ><img src='<?php echo $configUrl; ?>f/i/default/corpo-default/excluir.gif' alt="icone"></a></td>
								</tr>
<?php						
	}
?>
							</table>	
							<script>
								
								function confirmaExclusao(cod, nome){

									if(confirm("Deseja excluir a venda do cliente "+nome+" ?")){
										window.location='<?php echo $configUrlGer; ?>atendimento/vendas/excluir/'+cod+'/';
									}
								}
								
								function alteraStatus(cod, id){
									document.getElementById("alteraStatus").value=cod;
									document.getElementById("idStatus").value=id;
									document.getElementById("formStatus").submit();
								}  

								$bgds = jQuery.noConflict();
								$bgds('form').bind("keypress", function(e) {
								  if (e.keyCode == 13){               
									e.preventDefault();
									return false;
								  }
								});	
												
							</script>
							<form id="formStatus" action="<?php echo $configUrlGer;?>atendimento/vendas/" method="post">
								<input type="hidden" value="" name="alteraStatus" id="alteraStatus"/>
								<input type="hidden" value="" name="idStatus" id="idStatus"/>
							</form>	
