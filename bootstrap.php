<?php
namespace MagentoModuleLoader;

// if Mage_Core_Model_Config has already been defined then exit as we can't redefine it
if (class_exists('Mage_Core_Model_Config', false)) {
    return;
}

// get a reference to Composer autoloader so we can find file containing Mage_Core_Model_Config
if (!$autoloader = @include dirname(dirname(__DIR__)) . '/autoload.php') {
    $autoloader = require __DIR__ . '/vendor/autoload.php';
}

/* @var $autoloader \Composer\Autoload\ClassLoader */

if (!$file = $autoloader->findFile('Mage_Core_Model_Config')) {
    throw new \RuntimeException('Unable to find Mage_Core_Model_Config.');
}

// include vanilla Mage_Core_Model_Config but rename class to Mage_Core_Model_Config__vanilla
$code = file_get_contents($file);
$code = preg_replace('{^(\s*)class\s+Mage_Core_Model_Config(\s|$)}mi', '$1class Mage_Core_Model_Config__vanilla$2', $code);
eval('?>' . $code);

// if Mage_Core_Model_Config__vanilla is not defined then something is wrong
if (!class_exists('Mage_Core_Model_Config__vanilla', false)) {
    throw new \RuntimeException('Failed to create Mage_Core_Model_Config__vanilla.');
}

require __DIR__ . '/Config.php';
