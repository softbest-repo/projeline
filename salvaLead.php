<?php
	$accepted_origins = array("https://markanimoveis.com.br", "http://192.168.1.200");
 
    if (isset($_SERVER['HTTP_ORIGIN'])) {
      if (in_array($_SERVER['HTTP_ORIGIN'], $accepted_origins)) {
        header('Access-Control-Allow-Origin: ' . $_SERVER['HTTP_ORIGIN']);
      } else {
        header("HTTP/1.1 403 Origin Denied");
        return;
      }
    }
    
	include('f/conf/config.php');
	
	// $nomeLead = $_POST['nomeLead'];
	// $celularLead = $_POST['celularLead'];
	// $siteLocal = $_POST['siteLocal'];
	// $token = $_POST['token'];
	// $action = $_POST['action'];
	
	// define("RECAPTCHA_V3_SECRET_KEY", $chaveSecreta);
	  
	// $ch = curl_init();
	// curl_setopt($ch, CURLOPT_URL,"https://www.google.com/recaptcha/api/siteverify");
	// curl_setopt($ch, CURLOPT_POST, 1);
	// curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query(array('secret' => RECAPTCHA_V3_SECRET_KEY, 'response' => $token)));
	// curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	// $response = curl_exec($ch);
	// curl_close($ch);
	// $arrResponse = json_decode($response, true);
	
	// if($arrResponse["success"] == '1' && $arrResponse["action"] == $action && $arrResponse["score"] >= 0.5){
								
		$sqlSalva =  "INSERT INTO leads VALUES(0, '".$siteLocal."', '".date('Y-m-d H:i:s')."', '".$nomeLead."', '".$celularLead."', 'T')";
		$resultSalva = $conn->query($sqlSalva);
		
		if($resultSalva == 1){
			echo "ok";
		}else{
			echo "erro sql";
		}
	// }else{
	// 	echo "erro captcha";
	// }
?>
	

