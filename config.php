<?php
/**
 * @package     Work-Learn
 * @author      Ron Tayler
 * @copyright   2020
 */

// HTTP & HTTPS Ссылки
const DOMAIN = 'work-learn.room-seven.ru';

const HTTP_SERVER = 'http://'.DOMAIN.'/';
const HTTP_FILE = 'http://'.DOMAIN.'/file';
const HTTP_IMAGE = 'http://'.DOMAIN.'/image/';

const HTTPS_SERVER = 'https://'.DOMAIN.'/';
const HTTPS_FILE = 'https://'.DOMAIN.'/file/';
const HTTPS_IMAGE = 'https://'.DOMAIN.'/image/';

// DIR / Директории
const DIR_APP = __DIR__.'/';
const DIR_SYSTEM = DIR_APP.'system/';
const DIR_STORAGE = DIR_APP.'storage/';
const DIR_DOCS = DIR_STORAGE.'docs/';
const DIR_IMAGE = DIR_STORAGE.'image/';
const DIR_CACHE_FILE = DIR_APP.'file/';
const DIR_CACHE_IMAGE = DIR_APP.'image/';

// DB / База данных. Данные скрыты для безопастности
const DB_DRIVER = 'mysqli';
const DB_HOSTNAME = '***';
const DB_USERNAME = '***';
const DB_PASSWORD = '***';
const DB_DATABASE = '***';
const DB_PORT = '***';
const DB_PREFIX = '***';