<?php

namespace php_api_doc;

class APIDoc {

	var $path = '';

	public function saveSample($url, $query, $params, $jsonSend, $jsonResponse, $method = 'POST') {

		$path = $this->path . $url;
		$this->recursive_mkdir($path);
		for ($i = 0; $i, 100; $i++) {
			$pathTemp = $path . DIRECTORY_SEPARATOR . str_pad($i, 2, '0', STR_PAD_LEFT);
			if (!is_dir($pathTemp)) {
				$this->recursive_mkdir($pathTemp);

				$params = print_r($params, true);
				$fp = fopen($pathTemp . DIRECTORY_SEPARATOR . 'parameters.txt', 'w+');
				//echo $pathTemp.'/parameters.txt'; exit;
				fputs($fp, $params, strlen($params));
				fclose($fp);

				//$data = json_decode($data,true);
				if (is_array($jsonSend)) 
					$jsonSend = json_encode($jsonSend);
				$fp = fopen($pathTemp . DIRECTORY_SEPARATOR . 'send.json', 'w+');
				fputs($fp, $jsonSend, strlen($data));
				fclose($fp);

				$fp = fopen($pathTemp . DIRECTORY_SEPARATOR . 'query.txt', 'w+');
				fputs($fp, $query, strlen($query));
				fclose($fp);

				if (is_array($jsonResponse)) 
					$jsonResponse = json_encode($jsonResponse);
				$fp = fopen($pathTemp . DIRECTORY_SEPARATOR . 'response.json', 'w+');
				fputs($fp, $jsonResponse, strlen($jsonResponse));
				fclose($fp);

				return true;
			}
		}
		return false;
	}

	//Criar pastas em diretório caso não exista de forma recursiva
	private function recursive_mkdir($path, $mode = 0775, $diretorio_separador = DIRECTORY_SEPARATOR) {
		$old = umask(0);
		$dirs = explode($diretorio_separador, $path);
		$count = count($dirs);
		if ($diretorio_separador == '/') {
			$path = '';
			$start = 1;
		} else {
			$path = $dirs[0];
			$start = 1;
		}
		for ($i = $start; $i < $count; ++$i) {
			$path .= $diretorio_separador . $dirs[$i];
			if (!is_dir($path) && !mkdir($path, $mode)) {
				umask($old);
				return false;
			}
		}
		umask($old);
		return true;
	}

}
