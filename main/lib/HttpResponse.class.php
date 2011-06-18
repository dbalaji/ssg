<?php

class HttpResponse
{
    private static $_instance= null;

    private $_statusCode= 200, $_isJSON= false;
    private $_data, $_errmsg;

    private function __construct(){

    }

    public function setInternalServerError(){
        $this->_statusCode= 500;
    }

    public function setNotFound(){
        $this->_statusCode= 404;
    }

    public function setMediaTypeUnsupported(){
        $this->_statusCode= 415;
    }

    public function setBadRequest(){
        $this->_statusCode= 400;
    }

    public function setErrorMessage($message){
        $this->_errmsg= $message;
    }

    public function setJSONData($data){
        $this->_isJSON= true;
        $this->_data= json_encode($data);
    }

    public function send(){
        if ($this->_statusCode >= 400) {
            $httpHeader= "";
            $errorUrl= "";
            switch($this->_statusCode){
            case 400:
                $httpHeader= "HTTP/1.1 400 Bad Request";
                $errorUrl= "/error/HTTP_BAD_REQUEST.html.var";
                break;
            case 404:
                $httpHeader= "HTTP/1.1 404 Not Found";
                $errorUrl= "/error/HTTP_NOT_FOUND.html.var"; 
                break;
            case 415:
                $httpHeader= "HTTP/1.1 415 Media type unsupported";
                $errorUrl= "/error/HTTP_UNSUPPORTED_MEDIA_TYPE.html.var"; 
                break;
            case 500:
                $httpHeader= "HTTP/1.1 500 Internal Server Error";
                $errorUrl= "/error/HTTP_INTERNAL_SERVER_ERROR.html.var";
                break;
            }
            header($httpHeader);
            virtual($errorUrl);
        }
        else {
            if ($this->_isJSON) {
                //TODO: set JSON header
            }
            echo $this->_data;
        }
        exit;
    }

    public static function getInstance(){
        if(self::$_instance === null) {
            self::$_instance= new HttpResponse();
        }
        return self::$_instance;
    }

}

?>
