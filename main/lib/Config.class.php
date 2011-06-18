<?php


class Config
{
    private static  $_cacheDir, $_screenShotsDir, $_screenShotsBaseUrl,
                    $_frameCaptureBinaryPath;

    private static $_baseDir;

    private static $_url;   //varies based on the client's input

    public static function init($cfg, $url){
        self::$_cacheDir= $cfg->cacheDir;
        self::$_screenShotsDir= $cfg->screenShotsDir;
        self::$_screenShotsBaseUrl= $cfg->screenShotsBaseUrl;
        self::$_frameCaptureBinaryPath= $cfg->frameCaptureBinaryPath;
        self::$_baseDir= $cfg->baseDir;
        self::$_url= $url;

        $status= false;
        if (self::validateReadWriteDir(self::$_cacheDir)){
            if (self::validateReadWriteDir(self::$_screenShotsDir)){
                $status= true;
            }
        }

        return $status;
    }

    private static function validateReadWriteDir($dir){
        return file_exists($dir) && is_dir($dir) && is_writable($dir);
    }

    /*
     * The input url from the client, may be this is wron placement :(
     */
    public static function contextUrl() {
        return self::$_url;
    }

    /*
     * The rw directory, where curl downloads swf files
     */
    public static function cacheDir(){
        return self::$_cacheDir;
    }

    /*
     * The rw directory, where swf frame capture tool saves the frames
     */
    public static function screenShotsDir(){
        return self::$_screenShotsDir;
    }

    /*
     * The base url of the screenShotsDir for which filename of the image frame
     * has to be appended to display on the client side
     */
    public static function screenShotsBaseUrl(){
        return self::$_screenShotsBaseUrl;
    }

    /*
     * The binary path or command name which generates screenshot
     */
    public static function frameCaptureBinaryPath(){
        return self::$_frameCaptureBinaryPath;
    }

    /*
     * The shell script path which executes binary file or command which
     * actually generates screenshot
     */
    public static function frameCaptureShellScriptPath(){
        return self::$_baseDir . "bin/captureFrame.sh";
    }

}

?>
