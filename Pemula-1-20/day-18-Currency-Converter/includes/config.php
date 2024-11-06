<?php
require_once __DIR__ . '/../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/..');
$dotenv->load();

define('API_KEY', $_ENV['EXCHANGE_RATE_API_KEY']);
define('CACHE_FILE', __DIR__ . '/../cache/exchange_rates.json');
define('CACHE_EXPIRY', 43200); // 12 hours