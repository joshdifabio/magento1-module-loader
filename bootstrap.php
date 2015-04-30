<?php
namespace MagentoModuleLoader;

if (!class_exists('Mage.php', false)) {
    require __DIR__ . '/mage-includes.php';
}

ClassRewriter::loadClassAs('Mage_Core_Model_Config', 'Mage_Core_Model_Config__vanilla');

require __DIR__ . '/Config.php';
