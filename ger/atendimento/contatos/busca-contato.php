<?php
	ini_set('display_errors', '0');
	error_reporting(E_ALL | E_STRICT);

	include('../../f/conf/config.php');
	include('../../f/conf/conexao.php');
	include('../../f/conf/functions.php');
	include('../../f/conf/validaAcesso.php');

	$busca = $_GET['busca'];
		
	$busca = mysql_real_escape_string($busca);
	
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
									<th class="canto-esq" >Nome</th>
									<th>Celular</th>
									<th>Corretor</th>
									<th>Data</th>
									<th>Status</th>
									<th>Alterar</th>
									<th class="canto-dir">Excluir</th>
								</tr>						
<?php
	if($numero >= 1){
		$sqlContatos = "SELECT * FROM contatos WHERE codContato != ''".$filtraUsuario." and nomeContato LIKE '%".$order[0]."%' and nomeContato LIKE '%".$order[1]."%' and nomeContato LIKE '%".$order[2]."%' and nomeContato LIKE '%".$order[3]."%' and nomeContato LIKE '%".$order[4]."%' ORDER BY locate('".$order[0]."',nomeContato), locate('".$order[1]."',nomeContato), locate('".$order[2]."',nomeContato), locate('".$order[3]."',nomeContato), locate('".$order[4]."',nomeContato), dataContato ASC, codContato DESC LIMIT 0,30";		
	}
	
	if($busca == ""){
		$sqlContatos = "SELECT * FROM contatos WHERE codContato != ''".$filtraUsuario." ORDER BY statusContato ASC, dataContato ASC, codContato DESC";
	}
	$resultContatos = $conn->query($sqlContatos);
	while($dadosContatos = $resultContatos->fetch_assoc()){
				
		if($dadosContatos['statusContato'] == "T"){
			$status = "status-ativo";
			$statusIcone = "ativado";
			$statusPergunta = "desativar";
		}else{
			$status = "status-desativado";
			$statusIcone = "desativado";
			$statusPergunta = "ativar";
		}	
		
		if($dadosContatos['codUsuario'] == 0){
			$corretor = "Atendimento";
		}else{					
			$sqlUsuario = "SELECT nomeUsuario FROM usuarios WHERE codUsuario = ".$dadosContatos['codUsuario']." LIMIT 0,1";
			$resultUsuario = $conn->query($sqlUsuario);
			$dadosUsuario = $resultUsuario->fetch_assoc();
			
			$corretor = $dadosUsuario['nomeUsuario'];
		}			
?>
								<tr class="tr">
									<td class="sessenta"><a href='<?php echo $configUrlGer; ?>atendimento/contatos/detalhes/<?php echo $dadosContatos['codContato'] ?>/' title='Veja os detalhes do contato <?php echo $dadosContatos['nomeContato'] ?>'><?php echo $dadosContatos['nomeContato'];?></a></td>
									<td class="vinte" style="text-align:center;"><a href='<?php echo $configUrlGer; ?>atendimento/contatos/detalhes/<?php echo $dadosContatos['codContato'] ?>/' title='Veja os detalhes do contato <?php echo $dadosContatos['nomeContato'] ?>'><?php echo $dadosContatos['celularContato'];?></a></td>
									<td class="vinte" style="text-align:center;"><a href='<?php echo $configUrlGer; ?>atendimento/contatos/detalhes/<?php echo $dadosContatos['codContato'] ?>/' title='Veja os detalhes do contato <?php echo $dadosContatos['nomeContato'] ?>'><?php echo $corretor;?></a></td>
									<td class="dez" style="text-align:center;"><a href='<?php echo $configUrlGer; ?>atendimento/contatos/detalhes/<?php echo $dadosContatos['codContato'] ?>/' title='Veja os detalhes do contato <?php echo $dadosContatos['nomeContato'] ?>'><?php echo data($dadosContatos['dataContato']);?></a></td>
									<td class="botoes"><a href='<?php echo $configUrl; ?>atendimento/contatos/ativacao/<?php echo $dadosContatos['codContato'] ?>/' title='Deseja <?php echo $statusPergunta ?> o contato <?php echo $dadosContatos['nomeContato'] ?>?' ><img src="<?php echo $configUrl; ?>f/i/default/corpo-default/<?php echo $status ?>.gif" alt="icone"></a></td>
									<td class="botoes"><a href='<?php echo $configUrl; ?>atendimento/contatos/alterar/<?php echo $dadosContatos['codContato'] ?>/' title='Deseja alterar o contato <?php echo $dadosContatos['nomeContato'] ?>?' ><img src="<?php echo $configUrl;?>f/i/default/corpo-default/icones-alterar.gif" alt="icone" /></a></td>
									<td class="botoes"><a href='javascript: confirmaExclusao(<?php echo $dadosContatos['codContato'] ?>, "<?php echo htmlspecialchars($dadosContatos['nomeContato']) ?>");' title='Deseja excluir o contato <?php echo $dadosContatos['nomeContato'] ?>?' ><img src='<?php echo $configUrl; ?>f/i/default/corpo-default/excluir.gif' alt="icone"></a></td>
								</tr>
<?php
	}
?>
								<script>
									 function confirmaExclusao(cod, nome){

										if(confirm("Deseja excluir o contato "+nome+"?")){
											window.location='<?php echo $configUrlGer; ?>atendimento/contatos/excluir/'+cod+'/';
										}
									  }
								</script>
								 
							</table>	
