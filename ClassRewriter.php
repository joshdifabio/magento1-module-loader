<?php
namespace MagentoModuleLoader;

class ClassRewriter
{
    /**
     * @param string $className
     * @param string $renameTo
     * @throws \RuntimeException
     */
    public static function loadClassAs($className, $renameTo)
    {
        if (!$file = $this->getComposerAutoloader()->findFile($className)) {
            throw new \RuntimeException("Failed to find $className.");
        }
        
        $code = file_get_contents($file);
        $code = preg_replace("{^(\s*)class\s+$className(\s|$)}mi", "$1class $renameTo$2", $code);
        eval('?>' . $code);

        if (!class_exists($renameTo, false)) {
            throw new \RuntimeException("Failed to load $className as $renameTo.");
        }
    }
    
    /**
     * @return \Composer\Autoload\ClassLoader
     */
    private static function getComposerAutoloader()
    {
        if (!$this->composerAutoloader) {
            $this->composerAutoloader = require __DIR__ . '/vendor-autoload.php';
        }
        
        return $this->composerAutoloader;
    }
}
