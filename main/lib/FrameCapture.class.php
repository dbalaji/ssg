<?php

class FrameCapture
{
    private $_binaryPath, $_shellScriptPath;

    function __construct($binaryPath, $shellScriptPath){
        $this->_binaryPath= $binaryPath;
        $this->_shellScriptPath= $shellScriptPath;
    }

    function capture($srcFilePath, $frameNumber, $destFilePath){
        $shellScriptArgs= array(    $this->_binaryPath,
                                    $srcFilePath,
                                    $frameNumber,
                                    $destFilePath);
        $cmd= $this->_shellScriptPath ." ". implode(" ", $shellScriptArgs); 
        
        //TODO: replace this with exec or some better one
        system($cmd);
    }
}
?>
