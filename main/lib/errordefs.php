<?php

/*
 * @brief: This file contains all the error codes used across the application.
 */

//The "action" GET parameter is invalid
define("ERR_ACTION_INVALID", 1);

//One or more of the GET parameters required are not provided
define("ERR_INSUFFICIENT_PARAMS", 2);

//Some issue with the deployment like cache directory is not present or readonly
// send error 500
define("ERR_CONFIG_INIT_FAILED", 3);

define("ERR_DL_CURL_ERROR", 10);
define("ERR_DL_CONTENTTYPE_INVALID", 11);
define("ERR_DL_HTTP_FILENOTFOUND", 12);
define("ERR_DL_SAVEFILE_FAILED", 13);
define("ERR_DL_HTTP_OTHER", 14);

?>
