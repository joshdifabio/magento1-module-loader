<?php
namespace MagentoModuleLoader;

use Varien_Autoload;

class ClassRewriter
{
    /**
     * @param string $className
     * @param string $renameTo
     * @throws \RuntimeException
     */
    public static function loadClassAs($className, $renameTo)
    {
        if (!$file = Varien_Autoload::instance()->findFile($className)) {
            throw new \RuntimeException("Failed to find $className.");
        }
        
        $code = file_get_contents($file);
        $code = preg_replace("{^(\s*)class\s+$className(\s|$)}mi", "$1class $renameTo$2", $code);
        eval('?>' . $code);

        if (!class_exists($renameTo, false)) {
            throw new \RuntimeException("Failed to load $className as $renameTo.");
        }
    }
}
