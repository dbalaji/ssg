<?php

require_once("lib/Downloader.class.php");
require_once("lib/FrameCapture.class.php");

$dlHandle= new Downloader(Config::cacheDir(), Config::contextUrl()); 

$screenShotUrl= "";
if( $dlHandle->isDownloadComplete()){
    $srcFilePath= $dlHandle->getFilePath();
    $dstFileName=  $dlHandle->getUid() . ".png";
    $dstFilePath= Config::screenShotsDir() . $dstFileName;
    $fcHandle= new FrameCapture(Config::frameCaptureBinaryPath(),
                                Config::frameCaptureShellScriptPath());
    $fcHandle->capture($srcFilePath, 1, $dstFilePath);
    $screenShotUrl= Config::screenShotsBaseUrl() . $dstFileName;
}
echo $screenShotUrl;
?>
