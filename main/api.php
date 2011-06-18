<?php

/*
 *  @brief: This acts as a controller. Entry point for all the ajax requests.
 */

$basedir= dirname(__FILE__) . "/";
if ( ! defined( "PATH_SEPARATOR" ) ) {
    if ( strpos( $_ENV[ "OS" ], "Win" ) !== false ) {
        define( "PATH_SEPARATOR", ";" );
    }
    else {
        define( "PATH_SEPARATOR", ":" );
    }
} 
set_include_path(get_include_path() . PATH_SEPARATOR . $basedir);
//The include path is set to the root directory of the deployement. This makes
//sure that all the subdirectories refer other scripts with reference to the
//root directory. For example a script at 3 dirs deep can easily refer file in
//lib folder by just specifying "lib/file.php" instead of confusing ../../../

require_once("lib/errordefs.php");
require_once("lib/HttpResponse.class.php");

$action= isset($_GET["action"]) ? trim($_GET["action"]) : "";
$inputUrl= isset($_GET["url"]) ? urldecode(trim($_GET["url"])): "";

try {
    if (empty($action) || empty($inputUrl)) {
        throw new Exception("Inssuficient params", ERR_INSUFFICIENT_PARAMS);
    }

    if (!ctype_alpha($action)) {
        throw new Exception("invalid/suspectable action", ERR_ACTION_INVALID);
    }

    $actionsdir= $basedir . "actions/";
    
    $actionPhpFile=  $actionsdir . $action . ".php";
    if (!file_exists($actionPhpFile)) {
        throw new Exception("invalid action", ERR_ACTION_INVALID);
    }

    $url= (strpos($inputUrl, "http://") === FALSE && 
                strpos($inputUrl, "https://") === FALSE )? "http://" . $inputUrl
                                                    : $inputUrl ;
    require_once("config.php");
    global $CFG;
    require_once("lib/Config.class.php");
    if (Config::init($CFG, $url)) {
        require_once($actionPhpFile);
    }
    else {
        throw new Exception("Config initialization failed", ERR_CONFIG_INIT_FAILED);
    }
}catch(Exception $e) {
    $response= HttpResponse::getInstance();
    switch($e->getCode()) {
    case ERR_CONFIG_INIT_FAILED:
        $response->setInternalServerError();
        break;
    case ERR_INSUFFICIENT_PARAMS:
    case ERR_ACTION_INVALID:
        $response->setBadRequest();
        break;
    }
    $response->setErrorMessage($e->getMessage());
    $response->send();
}

?>
