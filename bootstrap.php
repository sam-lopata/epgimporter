<?php
define('DISPLAY_ERRORS', TRUE);
define('ERROR_REPORTING', E_ALL | E_STRICT);
define('LOG_ERRORS', FALSE);

set_time_limit(0);
date_default_timezone_set("UTC");

require __DIR__.'/vendor/autoload.php';

use Symfony\Component\Config\FileLocator;
use Symfony\Component\Console\Application;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;

set_error_handler(static function($errno, $errstr, $errfile, $errline) {
    echo sprintf('Error: [%s] %s, in file %s:%s ', $errno, $errstr, $errfile, $errline) . PHP_EOL;
    die;
});

// commands container & runner
$application = new Application('EPGParser');
// DI container
$containerBuilder = new ContainerBuilder();
$containerBuilder->setParameter('root_dir', __DIR__);

// load configuration
$loader = new YamlFileLoader($containerBuilder, new FileLocator(__DIR__.'/config'));
$loader->load('config.yaml');
$loader->load('services.yaml');
