<?php

namespace php_api_doc;

class APIDoc {

	var $path = '';

	public function saveSample($package, $class, $query, $params, $jsonSend, $jsonResponse, $method = 'POST', $version=false) {
		if ($version) {
			$path = $this->path .$version.DIRECTORY_SEPARATOR;
		} else {
			$path = $this->path;
		}
		$path .=  
			str_replace('/', DIRECTORY_SEPARATOR, $package).DIRECTORY_SEPARATOR.
			$class.DIRECTORY_SEPARATOR.
			$method.DIRECTORY_SEPARATOR
		;
		

		
		$this->recursive_mkdir($path);
		for ($i = 0; $i, 100; $i++) {
			$pathTemp = $path . DIRECTORY_SEPARATOR . str_pad($i, 2, '0', STR_PAD_LEFT);
			if (!is_dir($pathTemp)) {
				$this->recursive_mkdir($pathTemp);

				if (is_array($params))
					$params = implode('/',$params);
				$fp = fopen($pathTemp . DIRECTORY_SEPARATOR . 'parameters.txt', 'w+');
				//echo $pathTemp.'/parameters.txt'; exit;
				fputs($fp, $params, strlen($params));
				fclose($fp);

				//$data = json_decode($data,true);
				if (isset($jsonSend)) {
					if (is_array($jsonSend)) 
						$jsonSend = json_encode($jsonSend);
					
					$fp = fopen($pathTemp . DIRECTORY_SEPARATOR . 'send.json', 'w+');
					fputs($fp, $jsonSend, strlen($jsonSend));
					fclose($fp);
				}

				if (isset($query)) {
					$fp = fopen($pathTemp . DIRECTORY_SEPARATOR . 'query.txt', 'w+');
					fputs($fp, $query, strlen($query));
					fclose($fp);
				}

				if (isset($jsonResponse)) {
					if (is_array($jsonResponse)) 
						$jsonResponse = json_encode($jsonResponse);
					$fp = fopen($pathTemp . DIRECTORY_SEPARATOR . 'response.json', 'w+');
					fputs($fp, $jsonResponse, strlen($jsonResponse));
					fclose($fp);
				}

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
	
	public function compileDocsFromSample($pathSample, $pathDestDoc, $version='all') {
		echo $pathDestDoc;
	}

}
