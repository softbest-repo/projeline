<?php 
    ob_start();
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['logout'])) { 
        setcookie("loginAprovado" . $cookie, "", time() - 3600, "/");
        setcookie("codAprovado" . $cookie, "", time() - 3600, "/");
?>
            <div id="conteudo-interno" style="display: flex; justify-content: center; align-items: center; height: 60vh;">
                <img src="<?php echo $configUrl.'f/i/quebrado/loading.svg'; ?>" width="100px" alt="">
            </div>
<?php 
        echo "<meta HTTP-EQUIV='Refresh' CONTENT='0;URL=" . $configUrl . "minha-conta/login/'>";
    }
?>
