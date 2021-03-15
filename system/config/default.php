<?php

// Site
$_['site_url']              = HTTP_SERVER;
$_['site_ssl']              = HTTPS_SERVER;
$_['url_autostart']         = true;

$_['yandex_API_key']        = 'ccb92ed7-0654-4f56-8df9-3e0eee76c06c';

$_['date_timezone']         = 'Europe/Moscow';

$_['limit_task_for_page']   = 3;

$_['debug_filename']        = 'debug.log';
$_['error_filename']        = 'error.log';
$_['error_display']         = false;
$_['error_log']             = true;

// Template
$_['template_engine']      = 'twig';
$_['template_cache']       = true;
$_['template_bootstrap']   = true;
$_['template_jquery']      = true;

// Autoload Configs
$_['config_autoload']      = array();

// Autoload Libraries
$_['library_autoload']     = array(
    'rtf'
);

// Autoload Libraries
$_['model_autoload']       = array();

// Language
$_['language_directory']   = 'ru-ru';
$_['language_autoload']    = array('ru-ru');

// Cache
$_['cache_engine']         = 'file'; // apc, file, mem or memcached
$_['cache_expire']         = 3600;

// Session
$_['session_engine']       = 'db';
$_['session_autostart']    = true;
$_['session_name']         = 'SESSION_ID';
$_['default_user_group_name'] = 1;

// Database
$_['db_autostart']         = true;
$_['db_engine']            = DB_DRIVER; // mpdo, mssql, mysql, mysqli or postgre
$_['db_hostname']          = DB_HOSTNAME;
$_['db_username']          = DB_USERNAME;
$_['db_password']          = DB_PASSWORD;
$_['db_database']          = DB_DATABASE;
$_['db_port']              = DB_PORT;

// Actions
$_['action_default']       = 'common/home';
$_['action_router']        = 'startup/route';
$_['action_error']         = 'error/not_found';
$_['action_pre_action']    = array(
    'startup/alias',
    'startup/startup',
    'user/permission'
);
$_['action_event']         = array();

/*/ Action Events
$_['action_event'] = array(
    'controller/* /before' => array(
        'event/language/before'
    ),
    'view/* /before' => array(
        1 => 'event/theme/override',
        2 => 'event/language',
        3 => 'event/theme'
    )
);
//*/