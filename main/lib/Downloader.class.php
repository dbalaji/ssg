<?php
require_once(dirname(__FILE__) ."/errordefs.php");
define("DL_MAX_REDIRECTS", 5);
class Downloader
{
    private $_uid;
    private $_url;
    private $_downloadDir;

    function __construct($dir, $url){
        $this->_url= $url;
        $this->_uid= md5($url);
        $this->_downloadDir= $dir . $this->_uid . "/";
    }

    function isDownloadComplete() {
        return file_exists($this->getFilePath());
    }

    function getFilePath(){
        return $this->_downloadDir . "movie.swf";
    }

    function getUid(){
        return $this->_uid;
    }

    function download(){
        if (!$this->isDownloadComplete()) {
            @mkdir($this->_downloadDir);
            $saveFilePath= $this->_downloadDir .'movie.swf';
            $fp = fopen($saveFilePath, 'w');
            if (!$fp){
                throw new Exception("Unable to open file for writing", ERR_DL_SAVEFILE_FAILED);
            }

            $ch = curl_init();
            if ($ch === FALSE){
                fclose($fp);
                @unlink($saveFilePath);
                throw new Exception("Curl init failed", ERR_DL_CURL_ERROR);
            }

            try {
                curl_setopt($ch, CURLOPT_URL, $this->_url);
                curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
                curl_setopt($ch, CURLOPT_MAXREDIRS, DL_MAX_REDIRECTS);
                //set useragent same as what the client sends
                curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
                curl_setopt($ch, CURLOPT_FILE, $fp);
                if (curl_exec($ch) === FALSE){
                    throw new Exception(curl_error($ch), ERR_DL_CURL_ERROR);
                }
                $info= curl_getinfo($ch);
                switch($info["http_code"]){
                case 200:
                    if (!self::hasValdiContentType($info)) {
                        throw new Exception($message, ERR_DL_CONTENTTYPE_INVALID);
                    }
                    break;
                case 404:
                    throw new Exception("File not found", ERR_DL_HTTP_FILENOTFOUND);
                    break;
                default:
                    break;
                }
                echo "<pre>";
                print_r($info);
                echo "</pre>";
                curl_close ($ch);
                fclose($fp);
            }
            catch(Exception $e) {
                curl_close ($ch);
                fclose($fp);
                @unlink($saveFilePath);
                throw new Exception($e->getMessage(), $e->getCode());
            }
        }
    }

    public static function hasValdiContentType($info){
        return (isset($info["content_type"]) && $info["content_type"] == "application/x-shockwave-flash");
    }

    function getProgress(){
    }

    function cancelDownload() {
    }
}

?>
