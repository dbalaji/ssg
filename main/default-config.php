<?php
/*
 * @brief: This contains the deployment server settings.
 */
global $CFG;
$CFG= new StdClass;
$CFG->baseDir= dirname(__FILE__). "/";

//============== Editable Configuration ===============//
//NOTE: All the directory paths must end with a slash.

//Create a directory with rw permissions to apache to cache swf files
//Make sure this is not directly accessible from client side
$CFG->cacheDir= "/home/balaji/.tmp/cache/";

//Create a directory with rw permissions to apache to save screenshots of swf
//files
$CFG->screenShotsDir= "/home/balaji/htdocs/thumbdata/";

//The base url to access the tumbnails from the client
$CFG->screenShotsBaseUrl= "http://localhost/~balaji/thumbdata/";

//Command name or binary path of dump-gnash, which is used to create snapshot
$CFG->frameCaptureBinaryPath= "/home/balaji/htdocs/swfdecoders/gnash-0.8.8/gui/dump-gnash";

?>
