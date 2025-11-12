<?php
	ini_set('display_errors', '0');
	error_reporting(E_ALL | E_STRICT);

	include('../../f/conf/config.php');
	include('../../f/conf/conexao.php');
	include('../../f/conf/functions.php');
	include('../../f/conf/validaAcesso.php');

	$busca = $_GET['busca'];
	$cpfCpnj = $_GET['cpfCpnj'];
			
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
									<th class="canto-esq">Nome</th>
									<th>CPF</th>
									<th>Celular</th>
									<th>Cidade / Estado</th>
									<th>Cadastro</th>
									<th>Status</th>
									<th>Alterar</th>
									<th class="canto-dir">Excluir</th>
								</tr>					
<?php	
	if($cpfCpnj != ""){
		$sqlClientes = "SELECT * FROM clientes WHERE cpfCliente LIKE '%".$cpfCpnj."%' ORDER BY codCliente DESC LIMIT 0,30";
	}else
	if($numero >= 1){
		$sqlClientes = "SELECT * FROM clientes WHERE codCliente != '' and nomeCliente LIKE '%".$order[0]."%' and nomeCliente LIKE '%".$order[1]."%' and nomeCliente LIKE '%".$order[2]."%' and nomeCliente LIKE '%".$order[3]."%' and nomeCliente LIKE '%".$order[4]."%' ORDER BY locate('".$order[0]."',nomeCliente), locate('".$order[1]."',nomeCliente), locate('".$order[2]."',nomeCliente), locate('".$order[3]."',nomeCliente), locate('".$order[4]."',nomeCliente) LIMIT 0,30";		
	}
	
	if($busca == "" && $cpfCpnj == ""){
		$sqlClientes = "SELECT * FROM clientes WHERE codCliente != '' ORDER BY statusCliente ASC, dataCliente DESC, nomeCliente DESC";
	}
	$resultClientes = $conn->query($sqlClientes);
	while($dadosClientes = $resultClientes->fetch_assoc()){
					
		if($dadosClientes['statusCliente'] == "T"){
			$status = "status-ativo";
			$statusIcone = "ativado";
			$statusPergunta = "desativar";
		}else{
			$status = "status-desativado";
			$statusIcone = "desativado";
			$statusPergunta = "ativar";
		}		
			
		$aniversario = explode("-", $dadosClientes['nascimento']);
		$novaData = $aniversario[2]."/".$aniversario[1];

		$celularWhats = str_replace("(", "", $dadosClientes['fone1']); 
		$celularWhats = str_replace(")", "", $celularWhats); 
		$celularWhats = str_replace(" ", "", $celularWhats); 
		$celularWhats = str_replace("-", "", $celularWhats); 			
?>
								<tr class="tr">
									<td class="vinte"><img style="<?php echo $novaData == date('d/m') ? '' : 'display:none;';?> padding-right:10px; cursor:pointer;" title="Clique para ver o numero" src="<?php echo $configUrl;?>f/i/default/corpo-default/icon-bolo.png" alt="Aniversário" /><a href='<?php echo $configUrlGer; ?>atendimento/clientes/alterar/<?php echo $dadosClientes['codCliente'] ?>/' title='Veja os detalhes do cliente <?php echo $dadosClientes['nomeCliente'] ?>'><?php echo $dadosClientes['nomeCliente'];?> <?php echo $dadosClientes['sobrenomeCliente'];?></a></td>
									<td class="vinte" style="text-align:center;"><a style="padding:0px;" href='<?php echo $configUrlGer; ?>atendimento/clientes/alterar/<?php echo $dadosClientes['codCliente'] ?>/' title='Clique para iniciar uma conversa no WhatsApp'><?php echo $dadosClientes['cpfCliente'];?></a></td>
									<td class="vinte" style="text-align:center;"><a style="padding:0px;" target="_blank" href='https://api.whatsapp.com/send?1=pt_BR&amp;phone=55<?php echo $celularWhats;?>' title='Clique para iniciar uma conversa no WhatsApp'><?php echo $dadosClientes['celularCliente'];?></a></td>
									<td class="vinte" style="text-align:center;"><a style="padding:0px;" href='<?php echo $configUrlGer; ?>atendimento/clientes/alterar/<?php echo $dadosClientes['codCliente'] ?>/' title='Veja os detalhes do cliente <?php echo $dadosClientes['nomeCliente'] ?>'><?php echo $dadosClientes['cidadeCliente'];?> / <?php echo $dadosClientes['estadoCliente'];?></a></td>
									<td class="dez" style="text-align:center;"><a style="padding:0px;" href='<?php echo $configUrlGer; ?>atendimento/clientes/alterar/<?php echo $dadosClientes['codCliente'] ?>/' title='Veja os detalhes do cliente <?php echo $dadosClientes['nomeCliente'] ?>'><?php echo data($dadosClientes['dataCliente']);?></a></td>
									<td class="botoes"><a style="padding:0px;" href='<?php echo $configUrl; ?>atendimento/clientes/ativacao/<?php echo $dadosClientes['codCliente'] ?>/' title='Deseja <?php echo $statusPergunta ?> o cliente <?php echo $dadosClientes['nomeCliente'] ?>?' ><img src="<?php echo $configUrl; ?>f/i/default/corpo-default/<?php echo $status ?>.gif" alt="icone"></a></td>
									<td class="botoes"><a style="padding:0px;" href='<?php echo $configUrl; ?>atendimento/clientes/alterar/<?php echo $dadosClientes['codCliente'] ?>/' title='Deseja alterar o cliente <?php echo $dadosClientes['nomeCliente'] ?>?' ><img src="<?php echo $configUrl;?>f/i/default/corpo-default/icones-alterar.gif" alt="icone" /></a></td>
									<td class="botoes"><a style="padding:0px;" href='javascript: confirmaExclusao(<?php echo $dadosClientes['codCliente'] ?>, "<?php echo htmlspecialchars($dadosClientes['nomeCliente']) ?>");' title='Deseja excluir o cliente <?php echo $dadosClientes['nomeCliente'] ?>?' ><img src='<?php echo $configUrl; ?>f/i/default/corpo-default/excluir.gif' alt="icone"></a></td>
								</tr>

<?php
	}
?>
								<script>
									function confirmaExclusao(cod, nome){
										if(confirm("Deseja excluir o cliente "+nome+"?")){
											window.location='<?php echo $configUrlGer; ?>atendimento/clientes/excluir/'+cod+'/';
										}
									}

									function resetarSenha(cod, nome){
										$tg = jQuery.noConflict();
										if(confirm("Deseja resetar a senha do cliente "+nome+"?")){
											$tg("#html"+cod).html("<img src='<?php echo $configUrlGer;?>f/i/loading.svg' width='50'/>");
											$tg.post("<?php echo $configUrlGer;?>atendimento/clientes/reseta-senha.php", {codCliente: cod},function(data){
												$tg("#html"+cod).html("Senha Padrão");											
											});
										}
									}								
								</script>						 
							</table>	
