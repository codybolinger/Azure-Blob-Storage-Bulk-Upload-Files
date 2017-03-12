<?php
require_once 'vendor/autoload.php';

use WindowsAzure\Common\ServicesBuilder;
use MicrosoftAzure\Storage\Common\ServiceException;

$connectionString = "DefaultEndpointsProtocol=https;AccountName=$ACCOUNT_NAME;AccountKey=$ACCOUNT_KEY";

$blobRestProxy = ServicesBuilder::getInstance()->createBlobService($connectionString);

$dir = new DirectoryIterator($FILE_DIRECTORY);
foreach ($dir as $fileinfo) {
    if (!$fileinfo->isDot()) {
		$content = fopen($fileinfo->getPathName(), "r");
		$blobName = $fileinfo->getFilename();

		try{
			$blobRestProxy->createBlockBlob("files", $blobName, $content);
	
		}
		catch(ServiceException $e){
			$code = $e->getCode();
			$error_message = $e->getMessage();
			echo $code.": ".$error_message."<br />";
		}
    }
}




