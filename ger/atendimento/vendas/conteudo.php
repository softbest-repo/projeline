<?php
	if($_COOKIE['loginAprovado'.$cookie] != ""){

		if($controleUsuario == "tem usuario"){
			
			$area = "vendas";
			include('f/conf/validaAcesso.php');
			if($validaAcesso == "ok"){		

				if($_POST['alteraStatus'] != ""){

					$query = "SELECT * FROM vendas WHERE codVenda = '".$_POST['idStatus']."'";
					$result = $conn->query($query);
					$vendas = $result->fetch_assoc();
										
					$sqlUpdate = "UPDATE vendas SET statusVenda = '".$_POST['alteraStatus']."' WHERE codVenda = '".$_POST['idStatus']."'";
					$resultUpdate = $conn->query($sqlUpdate);
				
					$_SESSION['statusTransacao'] = "ok";				
				}
				

				if($_SESSION['statusTransacao'] == "ok"){
					$erroConteudo = "<p class='erro'>Status da venda alterado com sucesso!</p>";
					$_SESSION['statusTransacao'] = "";
					$_SESSION['nome'] = "";
				}else
				if($_SESSION['excluir'] == "ok"){
					$erroConteudo = "<p class='erro'>Venda <strong>".$_SESSION['nome']."</strong> excluído com sucesso!</p>";
					$_SESSION['excluir'] = "";
					$_SESSION['nome'] = "";
				}

				if(isset($_POST['status-filtro'])){
					if($_POST['status-filtro'] != ""){
						$_SESSION['status-filtro'] = $_POST['status-filtro'];
					}else{
						$_SESSION['status-filtro'] = "";
					}
				}
				
				if($_SESSION['status-filtro'] != ""){
					$filtraStatus = " and V.statusVenda = '".$_SESSION['status-filtro']."'";
				}
?>

				<div id="filtro">							
					<div id="localizacao-filtro">
						<p class="nome-lista">Atendimento</p>
						<p class="flexa"></p>
						<p class="nome-lista">Vendas</p>	
						<br class="clear"/>
					</div>
					<div class="demoTarget">
						<script type="text/javascript">
							function alteraStatus(status){
								document.getElementById("filtroStatus").submit();
							}
						</script>
						<div id="formulario-filtro">
							<form id="filtroStatus" action="<?php echo $configUrl;?>atendimento/vendas/" method="post">

								<script type="text/javascript">
									function executaForm(status){
										document.getElementById("filtroStatus").submit();
									}
								</script>
						
								<p class="nome-clientes-filtro" style="width:290px;"><label class="label">Filtre por Nº do Pedido ou Cliente:</label>
								<input type="text" style="width:270px;" name="vendas" onKeyUp="buscaAvancada();" id="busca" autocomplete="off" value="<?php echo $_SESSION['nome-vendas-filtro'];?>" /></p>
								<input style="display:none;" type="text" size="16" name="teste" value="" />									

								<p class="bloco-campo-float"><label>Status Pedido:<span class="obrigatorio"> </span></label>
									<select id="status-filtro" class="campo" name="status-filtro" style="width:200px; padding:7px;" onChange="executaForm();">
										<option value="">Todos</option>
										<option value="NOT_MADE" <?php echo $_SESSION['status-filtro'] == "NOT_MADE" ? "/SELECTED/" : "";?>>Pagamento não Efetuado</option>	
										<option value="CANCELLED" <?php echo $_SESSION['status-filtro'] == "CANCELLED" ? "/SELECTED/" : "";?>>Pagamento Cancelado</option>
										<option value="DECLINED" <?php echo $_SESSION['status-filtro'] == "DECLINED" ? "/SELECTED/" : "";?>>Pagamento Recusado</option>
										<option value="REFUNDED" <?php echo $_SESSION['status-filtro'] == "REFUNDED" ? "/SELECTED/" : "";?>>Pagamento Estornado</option>
										<option value="CHARGEDBACK" <?php echo $_SESSION['status-filtro'] == "CHARGEDBACK" ? "/SELECTED/" : "";?>>Pagamento Devolvido</option>
										<option value="WAITING" <?php echo $_SESSION['status-filtro'] == "WAITING" ? "/SELECTED/" : "";?>>Aguardando Pagamento</option>
										<option value="IN_ANALYSIS" <?php echo $_SESSION['status-filtro'] == "IN_ANALYSIS" ? "/SELECTED/" : "";?>>Em Análise</option>
										<option value="AUTHORIZED" <?php echo $_SESSION['status-filtro'] == "AUTHORIZED" ? "/SELECTED/" : "";?>>Pagamento Autorizado</option>
										<option value="PAID" <?php echo $_SESSION['status-filtro'] == "PAID" ? "/SELECTED/" : "";?>>Pagamento Aprovado</option>
									</select>
								</p>

								<br class="clear" />
							</form>
						</div>
					</div>
				</div>
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
								$AGD("#busca-carregada").load("<?php echo $configUrl;?>atendimento/vendas/busca-vendas.php?busca="+busca);
								if(busca == ""){
									document.getElementById("paginacao").style.display="block";
								}else{
									document.getElementById("paginacao").style.display="none";
								}
							}	
						</script>
						<div id="busca-carregada">
<?php
				$sqlConta = "SELECT count(V.codVenda) registros, V.codVenda FROM vendas V inner join clientes C on V.codCliente = C.codCliente WHERE V.codVenda != ''".$filtraStatus."";
				$resultConta = $conn->query($sqlConta);
				$dadosConta = $resultConta->fetch_assoc();
				$registros = $dadosConta['registros'];
				
				if($dadosConta['codVenda'] != ""){
?>
							<table class="tabela-menus" >
								<tr class="titulo-tabela" border="none">
									<th class="canto-esq">Nº Pedido</th>
									<th>Cliente</th>
									<th>Celular</th>
									<th>Total</th>
									<th>Status</th>
									<th>Data e Hora</th>
									<th>Detalhes</th>
									<th class="canto-dir">Excluir</th>
								</tr>					
<?php
				}
				
				if($url[5] == 1 || $url[5] == ""){
					$pagina = 1;
					$sqlVendas = "SELECT * FROM vendas V inner join clientes C on V.codCliente = C.codCliente WHERE V.codVenda != ''".$filtraStatus." ORDER BY statusVenda ASC, V.dataVenda DESC, V.codVenda DESC LIMIT 0,30";
				}else{
					$pagina = $url[5];
					$paginaFinal = $pagina * 30;
					$paginaInicial = $paginaFinal - 30;
					$sqlVendas = "SELECT * FROM vendas V inner join clientes C on V.codCliente = C.codCliente WHERE V.codVenda != ''".$filtraStatus." ORDER BY statusVenda ASC, V.dataVenda DESC, V.codVenda DESC LIMIT ".$paginaInicial.",30";				
				}		

				$resultVendas = $conn->query($sqlVendas);
				while($dadosVendas = $resultVendas->fetch_assoc()){
					$mostrando++;				
					
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
									  if (e.keyCode == 13) {               
										e.preventDefault();
										return false;
									  }
									});					
								</script>

								<form id="formStatus" action="<?php echo $configUrlGer;?>atendimento/vendas/" method="post">
									<input type="hidden" value="" name="alteraStatus" id="alteraStatus"/>
									<input type="hidden" value="" name="idStatus" id="idStatus"/>
								</form>
							</table>							
						</div>
<?php
					$regPorPagina = 30;
					$area = "atendimento/vendas";
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
				echo "<p><strong>Vocês não tem permissão para acessar essa área!</strong></p>";
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
