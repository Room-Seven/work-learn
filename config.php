<?php

// HTTP & HTTPS Ссылки
define('DOMEN', 'work-learn.room-seven.ru')

define('HTTP_SERVER','http://'.DOMEN.'/');
define('HTTP_FILE','http://'.DOMEN.'/file');
define('HTTP_IMAGE','http://'.DOMEN.'/image/');

define('HTTPS_SERVER','https://'.DOMEN.'/');
define('HTTPS_FILE','https://'.DOMEN.'/file/');
define('HTTPS_IMAGE','https://'.DOMEN.'/image/');

// DIR / Директории. Данные скрыты для безопастности
define('DIR_APP',__DIR__.'/');
define('DIR_SYSTEM','***');
define('DIR_STORAGE','***');
define('DIR_DOCS','***');
define('DIR_IMAGE','***');
define('DIR_CACHE_FILE','***');
define('DIR_CACHE_IMAGE','***');

// DB / База данных. Данные скрыты для безопастности
define('DB_DRIVER', 'mysqli');
define('DB_HOSTNAME', '***');
define('DB_USERNAME', '***');
define('DB_PASSWORD', '***');
define('DB_DATABASE', '***');
define('DB_PORT', '***');
define('DB_PREFIX', '***');