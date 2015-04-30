<?php
if (!$autoloader = @include dirname(dirname(__DIR__)) . '/autoload.php') {
    if (!$autoloader = @include __DIR__ . '/vendor/autoload.php') {
        throw new \RuntimeException('Failed to load Composer autoloader.');
    }
}

return $autoloader;
