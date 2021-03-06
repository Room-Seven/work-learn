<?php
/**
 * @package     Work-Learn
 * @author      Ron Tayler
 * @copyright   2020
 */

// Дополнительная проверка запроса после .htaccess
if(preg_match("/\.(php|html|ico|png|jpg|jpeg|css|js|svg)$/",$_GET['route'])){
    header('HTTP/1.0 404 Not Found');
    exit();
}

// Version / Версия
define('VERSION','1.0.0');

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Configuration / Конфигурации
if (!is_file('config.php')) trigger_error("Отсутствует файл конфигураций: config.php",E_USER_ERROR);
require_once('config.php');


// Startup / Запуск движка
if(!defined('DIR_SYSTEM')) trigger_error("Глобальная переменная DIR_SYSTEM не указанна в config.php",E_USER_ERROR);
require_once(DIR_SYSTEM . 'startup.php');

// Registry
$registry = new Registry();

// Config
$config = config::getInst();
$config->load(DIR_SYSTEM.'config/default.php');
$registry->set('config',$config);

// Log
$err_log = new Log(DIR_LOGS . $config->get('error_filename'));
$debug_log = new Log(DIR_LOGS . $config->get('debug_filename'));
$registry->set('err_log',$err_log);
$registry->set('debug_log',$debug_log);

date_default_timezone_set($config->get('date_timezone'));

set_error_handler(function($code, $message, $file, $line) use($err_log, $config) {
    // error suppressed with @
    if (error_reporting() === 0) {
        return false;
    }

    switch ($code) {
        case E_NOTICE:
        case E_USER_NOTICE:
            $error = 'Notice';
            break;
        case E_WARNING:
        case E_USER_WARNING:
            $error = 'Warning';
            break;
        case E_ERROR:
        case E_USER_ERROR:
            $error = 'Fatal Error';
            break;
        default:
            $error = 'Unknown';
            break;
    }

    if ($config->get('error_display')) {
        echo '<b>' . $error . '</b>: ' . $message . ' in <b>' . $file . '</b> on line <b>' . $line . '</b>';
    }

    if ($config->get('error_log')) {
        $err_log->write('PHP ' . $error . ':  ' . $message . ' in ' . $file . ' on line ' . $line);
    }

    return true;
});

// Event
$event = new Event($registry);
$registry->set('event', $event);

// Event Register
if ($config->has('action_event')) {
    foreach ($config->get('action_event') as $key => $value) {
        foreach ($value as $priority => $action) {
            $event->register($key, new Action($action), $priority);
        }
    }
}

// Loader
$loader = new Loader($registry);
$registry->set('load', $loader);

// Request
$registry->set('request', new Request());

// Response
$response = new Response();
$response->addHeader('Content-Type: text/html; charset=utf-8');
$response->setCompression($config->get('config_compression'));
$registry->set('response', $response);

// Database
if ($config->get('db_autostart')) {
    $registry->set('db', new DB($config->get('db_engine'), $config->get('db_hostname'), $config->get('db_username'), $config->get('db_password'), $config->get('db_database'), $config->get('db_port')));
}

// Session
$session = new Session($config->get('session_engine'), $registry);
$registry->set('session', $session);

if ($config->get('session_autostart')) {
    /*
    We are adding the session cookie outside of the session class as I believe
    PHP messed up in a big way handling sessions. Why in the hell is it so hard to
    have more than one concurrent session using cookies!

    Is it not better to have multiple cookies when accessing parts of the system
    that requires different cookie sessions for security reasons.

    Also cookies can be accessed via the URL parameters. So why force only one cookie
    for all sessions!
    */

    if (isset($_COOKIE[$config->get('session_name')])) {
        $session_id = $_COOKIE[$config->get('session_name')];
    } else {
        $session_id = '';
    }

    $session->start($session_id);

    setcookie($config->get('session_name'), $session->getId(), ini_get('session.cookie_lifetime'), ini_get('session.cookie_path'), ini_get('session.cookie_domain'));
}

// Cache
$registry->set('cache', new Cache($config->get('cache_engine'), $config->get('cache_expire')));

// Url
if ($config->get('url_autostart')) {
    $registry->set('url', new Url($config->get('site_url'), $config->get('site_ssl')));
}

// Language
$language = new Language($config->get('language_directory'));
$registry->set('language', $language);

// Document
$registry->set('document', new Document());

// Config Autoload
if ($config->has('config_autoload')) {
    foreach ($config->get('config_autoload') as $value) {
        $loader->config($value);
    }
}

// Language Autoload
if ($config->has('language_autoload')) {
    foreach ($config->get('language_autoload') as $value) {
        $loader->language($value);
    }
}

// Library Autoload
if ($config->has('library_autoload')) {
    foreach ($config->get('library_autoload') as $value) {
        $loader->library($value);
    }
}

// Model Autoload
if ($config->has('model_autoload')) {
    foreach ($config->get('model_autoload') as $value) {
        $loader->model($value);
    }
}

// Route
$route = new Router($registry);

// Pre Actions
if ($config->has('action_pre_action')) {
    foreach ($config->get('action_pre_action') as $value) {
        $route->addPreAction(new Action($value));
    }
}

// Dispatch
$route->dispatch(new Action($config->get('action_router')), new Action($config->get('action_error')));

// Output
$response->output();








