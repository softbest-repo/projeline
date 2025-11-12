<div id="conteudo-interno">
   <div id="conteudo-duvidas">
      <div id="bloco-titulo">
         <p class="titulo">DÚVIDAS FREQUENTES</p>
      </div>
      <div id="mostra-duvidas">
<?php 
		$sqlDuvidas = "SELECT * FROM duvidas WHERE statusDuvida = 'T' ORDER BY codOrdenacaoDuvida ASC ";
		$resultDuvidas = $conn->query($sqlDuvidas);
		while ($dadosDuvidas = $resultDuvidas->fetch_assoc()) {
?>
         <div class="bloco-duvidas">
            <p class="titulo">
               <?php echo $dadosDuvidas['nomeDuvida']; ?> 
               <img  class="icone" src="<?php echo $configUrl.'f/i/quebrado/plus.svg' ?>" width="15" alt="mais">
            </p>
            <div class="descricao"><?php echo $dadosDuvidas['descricaoDuvida']; ?></div>
         </div>
<?php 
		}                            
?>
		</div>
   </div>
</div>
<script>
   document.addEventListener('DOMContentLoaded', function () {
      const blocos = document.querySelectorAll('#conteudo-duvidas #mostra-duvidas .bloco-duvidas');

      blocos.forEach(bloco => {
         bloco.addEventListener('click', function () {
            const descricao = this.querySelector('.descricao');
            const icone = this.querySelector('.icone');

            blocos.forEach(outroBloco => {
               const outraDescricao = outroBloco.querySelector('.descricao');
               const outroIcone = outroBloco.querySelector('.icone');
               if (outraDescricao !== descricao) {
                  outraDescricao.classList.remove('show');
                  outroIcone.src = "<?php echo $configUrl.'f/i/quebrado/plus.svg' ?>";
                  outroIcone.style.width = '';
                  outroIcone.style.height = '';
               }
            });

            descricao.classList.toggle('show');
            
            if (descricao.classList.contains('show')) {
               icone.src = "<?php echo $configUrl.'f/i/quebrado/seta.svg' ?>";
               icone.style.width = '10px';
            } else {
               icone.src = "<?php echo $configUrl.'f/i/quebrado/plus.svg' ?>";
               icone.style.width = '';
               icone.style.height = '';
            }
         });
      });
   });
</script>