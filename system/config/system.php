<?php


try {
    // HTTP & HTTPS
    if(!defined('HTTP_SERVER')) throw new Exception('HTTP_SERVER');
    if(!defined('HTTP_FILE')) throw new Exception('HTTP_FILE');
    if(!defined('HTTP_IMAGE')) throw new Exception('HTTP_IMAGE');
    if(!defined('HTTPS_SERVER')) throw new Exception('HTTPS_SERVER');
    if(!defined('HTTPS_FILE')) throw new Exception('HTTPS_FILE');
    if(!defined('HTTPS_IMAGE')) throw new Exception('HTTPS_IMAGE');

    // DIR
    if(!defined('DIR_APP')) throw new Exception('DIR_APP');
    if(!defined('DIR_STORAGE')) throw new Exception('DIR_STORAGE');

    // DataBase
    if(!defined('DB_USERNAME')) throw new Exception('DB_USERNAME');
    if(!defined('DB_PASSWORD')) throw new Exception('DB_PASSWORD');
    if(!defined('DB_DATABASE')) throw new Exception('DB_DATABASE');
} catch (Exception $exc){
    trigger_error("Глобальная переменная ".$exc->getMessage()." не указанна в config.php",E_USER_ERROR);
}

// DIR / Директории
if(!defined('DIR_DOCS'))define('DIR_DOCS',DIR_STORAGE.'docs/');
if(!defined('DIR_CONTROLLER'))define('DIR_CONTROLLER',DIR_APP.'controller/');
if(!defined('DIR_MODEL'))define('DIR_MODEL',DIR_APP.'model/');
if(!defined('DIR_LANGUAGE'))define('DIR_LANGUAGE',DIR_APP.'language/');
if(!defined('DIR_VIEW'))define('DIR_VIEW',DIR_APP.'view/');
if(!defined('DIR_TEMPLATE'))define('DIR_TEMPLATE', DIR_VIEW . 'template/');
if(!defined('DIR_IMAGE'))define('DIR_IMAGE',DIR_STORAGE.'image/');
if(!defined('DIR_CACHE_FILE'))define('DIR_CACHE_FILE',DIR_APP.'file/');
if(!defined('DIR_CACHE_IMAGE'))define('DIR_CACHE_IMAGE',DIR_APP.'img/');
if(!defined('DIR_CACHE'))define('DIR_CACHE',DIR_STORAGE.'cache/');
if(!defined('DIR_DOWNLOAD'))define('DIR_DOWNLOAD',DIR_STORAGE.'download/');
if(!defined('DIR_LOGS'))define('DIR_LOGS',DIR_STORAGE.'logs/');
if(!defined('DIR_MODIFICATION'))define('DIR_MODIFICATION',DIR_STORAGE.'modification/');
if(!defined('DIR_SESSION'))define('DIR_SESSION',DIR_STORAGE.'session/');
if(!defined('DIR_UPLOAD'))define('DIR_UPLOAD',DIR_STORAGE.'upload/');

// DataBase
if(!defined('DB_DRIVER'))define('DB_DRIVER','mysqli');
if(!defined('DB_HOSTNAME'))define('DB_HOSTNAME', 'localhost');
if(!defined('DB_PORT'))define('DB_PORT', '3306');
if(!defined('DB_PREFIX'))define('DB_PREFIX', 'wl_');


