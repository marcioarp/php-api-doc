<?php

use \php_api_doc\APIDoc;

require '../vendor/autoload.php';

$a = new APIDoc();

$a->compileDocsFromSample(
	'C:\\xampp7\\htdocs\\sw3Documentacao\\DocVVS\\doc\\', 
	'C:\\xampp7\\htdocs\\sw3Documentacao\\DocVVS\\samples\\'
);