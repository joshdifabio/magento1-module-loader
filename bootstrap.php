<?php
namespace MagentoModuleLoader;

if (!$autoloader = @include dirname(dirname(__DIR__)) . '/autoload.php') {
    if (!$autoloader = @include __DIR__ . '/vendor/autoload.php') {
        throw new \RuntimeException('Failed to load Composer autoloader.');
    }
}

$autoloader->unregister();

if (!class_exists('Mage', false)) {
    require __DIR__ . '/mage-includes.php';
}

ClassRewriter::loadClassAs('Mage_Core_Model_Config', 'Mage_Core_Model_Config__vanilla');

require __DIR__ . '/Config.php';
