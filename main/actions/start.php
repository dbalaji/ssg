<?php
/*
 *  @brief: Kickoff the download of the swf file
 */
require_once("lib/Downloader.class.php");
$response= HttpResponse::getInstance();
$dlhandle= new Downloader(Config::cacheDir(), Config::contextUrl()); 
try {
    $dlhandle->download();
    $data= new StdClass;
    $data->status= "success";
    $response->setJSONData($data);
}
catch(Exception $e){
    switch($e->getCode()){
    case ERR_DL_HTTP_OTHER: //TODO: need to send the HTTP code as is
    case ERR_DL_HTTP_FILENOTFOUND:
        $response->setNotFound();
        break;
    case ERR_DL_SAVEFILE_FAILED:
    case ERR_DL_CURL_ERROR:
        $response->setInternalServerError();
        break;
    case ERR_DL_CONTENTTYPE_INVALID:
        $response->setMediaTypeUnsupported();
        break;
    }
}
$response->send();

?>
