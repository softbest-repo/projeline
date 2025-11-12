<?php
	include('../../f/conf/config.php');
	include('../../f/conf/controleAcesso.php');

	$busca = $_GET['busca'];
	$busca = str_replace("-", " ", $busca);
	$busca = str_replace("'", "&#39;", $busca);	
	$pedacos = explode(" ", $busca);	
	$numero = count($pedacos);
	$order = explode(" ", $busca);
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
	if($numero >= 1){
		$sqlProjeto = "SELECT * FROM projetos WHERE (codigoProjeto LIKE '%".$order[0]."%') or (nomeProjeto LIKE '%".$order[0]."%' and nomeProjeto LIKE '%".$order[1]."%' and nomeProjeto LIKE '%".$order[2]."%' and nomeProjeto LIKE '%".$order[3]."%' and nomeProjeto LIKE '%".$order[4]."%') or (enderecoProjeto LIKE '%".$order[0]."%' and enderecoProjeto LIKE '%".$order[1]."%' and enderecoProjeto LIKE '%".$order[2]."%' and enderecoProjeto LIKE '%".$order[3]."%' and enderecoProjeto LIKE '%".$order[4]."%') ORDER BY locate('".$order[0]."',codigoProjeto), locate('".$order[0]."',nomeProjeto), locate('".$order[1]."',nomeProjeto), locate('".$order[2]."',nomeProjeto), locate('".$order[3]."',nomeProjeto), locate('".$order[4]."',nomeProjeto), locate('".$order[0]."',enderecoProjeto), locate('".$order[1]."',enderecoProjeto), locate('".$order[2]."',enderecoProjeto), locate('".$order[3]."',enderecoProjeto), locate('".$order[4]."',enderecoProjeto) LIMIT 0,30";
	}
	
	if($busca == ""){
		$sqlProjeto = "SELECT * FROM projetos WHERE codProjeto != '' ORDER BY statusProjeto ASC, codigoProjeto DESC";
	}
	$resultProjeto = $conn->query($sqlProjeto);
	while($dadosProjeto = $resultProjeto->fetch_assoc()){
				
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
								<script>
									 function confirmaExclusao(cod, nome){

										if(confirm("Deseja excluir o imóvel "+nome+"?")){
											window.location='<?php echo $configUrlGer; ?>projetos/projetos/excluir/'+cod+'/';
										}
									  }
								</script>
								 
							</table>	
