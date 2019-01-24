<?php

const APP_NAME = "MyRunner";
const APP_VERSION = '0.0.1';

// If we're running from phar load the phar autoload file.
$pharPath = \Phar::running(true);
if ($pharPath) {
    $autoloaderPath = "$pharPath/vendor/autoload.php";
} else {
    if (file_exists(__DIR__ . '/vendor/autoload.php')) {
        $autoloaderPath = __DIR__ . '/vendor/autoload.php';
    } else {
        die("Could not find autoloader. Run 'composer install'.");
    }
}
$classLoader = require_once $autoloaderPath;

$commandClasses = [\MyRunner\Commands\RoboFile::class];

$statusCode = (new \Robo\Runner($commandClasses))
    ->setClassLoader($classLoader)
    ->execute(
        $argv,
        APP_NAME,
        APP_VERSION,
        new \Symfony\Component\Console\Output\ConsoleOutput()
    );
exit($statusCode);