<?php
namespace MagentoModuleLoader;

if (!class_exists('Mage', false)) {
    return;
}

if (!$autoloader = @include dirname(dirname(__DIR__)) . '/autoload.php') {
    if (!$autoloader = @include __DIR__ . '/vendor/autoload.php') {
        throw new \RuntimeException('Failed to load Composer autoloader.');
    }
}

$autoloader->unregister();

ClassRewriter::loadClassAs('Mage_Core_Model_Config', 'Mage_Core_Model_Config__vanilla');

require __DIR__ . '/Config.php';
