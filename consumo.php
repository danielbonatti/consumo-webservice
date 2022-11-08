<?php
	// Pega conteúdo do arquivo
	$text = file_get_contents('exemplo.rtf');

	// ==========================
	
	// Cria o JSON
	$postParameter = json_encode( array(
		'conteudo' => $text
	) );

	// Prepara a requisição/solicitação/envio
	$curlHandle = curl_init('http://127.0.0.1/rtf-to-txt/convert.php');
	curl_setopt($curlHandle, CURLOPT_POSTFIELDS, $postParameter);
	curl_setopt($curlHandle, CURLOPT_RETURNTRANSFER, true);

	// Requisita e obtem o resultado
	$curlResponse = curl_exec($curlHandle);
	curl_close($curlHandle);

	// Exibe o resultado
	//echo $curlResponse;

	// ==========================

	$arquivo = fopen('resultado.txt','w'); 
	if ($arquivo == false) 
		die ('Não foi possível criar o arquivo.');

	$filename = 'resultado.txt';
	$somecontent = $curlResponse;

	// Verifica se o arquivo existe
	if (is_writable($filename)) {

		// Abre o arquivo com o ponteiro na parte inferior
		if (!$fp = fopen($filename, 'a')) {
			echo "Não foi possível abrir o arquivo ($filename)";
			exit;
		}

		// Escreve no arquivo
		if (fwrite($fp, $somecontent) === FALSE) {
			echo "Não foi possível escrever no arquivo ($filename)";
			exit;
		}

		//echo "Success, wrote ($somecontent) to file ($filename)";
		echo "Sucesso, escrito no arquivo ($filename)";

		fclose($fp);

	} else {
		echo "O arquivo $filename tem alguma restrição";
	}
?>
