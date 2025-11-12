<?php
    header("Content-Type: application/xml; charset=UTF-8");
    echo '<?xml version="1.0" encoding="UTF-8"?>';
	
	include('f/conf/config.php');
 
	$hoje = date('Y-m-d');
?> 
	<urlset
		xmlns="https://www.sitemaps.org/schemas/sitemap/0.9"
		xmlns:xsi="https://www.w3.org/2001/XMLSchema-instance"
		xsi:schemaLocation="https://www.sitemaps.org/schemas/sitemap/0.9
		https://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd">
		<url>
			<loc>https://https://ediocorretor.com.br/</loc>
			<lastmod><?php echo $hoje;?></lastmod>		
			<changefreq>daily</changefreq>
			<priority>1.00</priority>
		</url>
		<url>
			<loc>https://https://ediocorretor.com.br/projeline/</loc>
			<lastmod><?php echo $hoje;?></lastmod>				
			<changefreq>daily</changefreq>
			<priority>0.8</priority>
		</url>	
		<url>
			<loc>https://https://ediocorretor.com.br/projeto-pronto/</loc>
			<lastmod><?php echo $hoje;?></lastmod>		
			<changefreq>daily</changefreq>
			<priority>0.8</priority>
		</url>
		<url>
			<loc>https://https://ediocorretor.com.br/projetos-personalizados/</loc>
			<lastmod><?php echo $hoje;?></lastmod>		
			<changefreq>daily</changefreq>
			<priority>0.8</priority>
		</url>	
		<url>
			<loc>https://https://ediocorretor.com.br/projetos-complementares/</loc>
			<lastmod><?php echo $hoje;?></lastmod>		
			<changefreq>daily</changefreq>
			<priority>0.8</priority>
		</url>		
		<url>
			<loc>https://https://ediocorretor.com.br/depoimentos/</loc>
			<lastmod><?php echo $hoje;?></lastmod>		
			<changefreq>daily</changefreq>
			<priority>0.8</priority>
		</url>
		<url>
			<loc>https://https://ediocorretor.com.br/duvidas/</loc>
			<lastmod><?php echo $hoje;?></lastmod>		
			<changefreq>daily</changefreq>
			<priority>0.8</priority>
		</url>
		<url>
			<loc>https://https://ediocorretor.com.br/contato/</loc>
			<lastmod><?php echo $hoje;?></lastmod>		
			<changefreq>daily</changefreq>
			<priority>0.8</priority>
		</url>

<?php
	$sqlProjeto = "SELECT codProjeto, urlProjeto FROM projetos WHERE statusProjeto = 'T' ORDER BY codProjeto DESC";
	$resultProjeto = $conn->query($sqlProjeto);
	while($dadosProjeto = $resultProjeto->fetch_assoc()){
			
		echo "<url>
				<loc>https://ihttps://ediocorretor.com.br/projeto-pronto/".$dadosProjeto['codProjeto']."-".$dadosProjeto['urlProjeto']."/</loc>
				<lastmod>".$hoje."</lastmod>
				<changefreq>daily</changefreq>
				<priority>0.80</priority>
			</url>";
	}
	
	$sqlProjeto = "SELECT codProjetoPersonalizado, urlProjetoPersonalizado FROM projetosPersonalizados WHERE statusProjetoPersonalizado = 'T' ORDER BY codProjetoPersonalizado DESC";
	$resultProjeto = $conn->query($sqlProjeto);
	while($dadosProjeto = $resultProjeto->fetch_assoc()){
			
		echo "<url>
				<loc>https://ihttps://ediocorretor.com.br/projetos-personalizados/".$dadosProjeto['codProjetoPersonalizado']."-".$dadosProjeto['urlProjetoPersonalizado']."/</loc>
				<lastmod>".$hoje."</lastmod>
				<changefreq>daily</changefreq>
				<priority>0.80</priority>
			</url>";
	}
	$sqlProjeto = "SELECT codProjetoComplementar, urlProjetoComplementar FROM projetosComplementares WHERE statusProjetoComplementar = 'T' ORDER BY codProjetoComplementar DESC";
	$resultProjeto = $conn->query($sqlProjeto);
	while($dadosProjeto = $resultProjeto->fetch_assoc()){
			
		echo "<url>
				<loc>https://ihttps://ediocorretor.com.br/projetos-complementares/".$dadosProjeto['codProjetoComplementar']."-".$dadosProjeto['urlProjetoComplementar']."/</loc>
				<lastmod>".$hoje."</lastmod>
				<changefreq>daily</changefreq>
				<priority>0.80</priority>
			</url>";
	}

?>			
	
	</urlset>
