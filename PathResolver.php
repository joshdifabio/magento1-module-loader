<?php
namespace MagentoModuleLoader;

/**
 * @author Josh Di Fabio <joshdifabio@gmail.com>
 */
class PathResolver
{
    private static $moduleDirPaths = array();
    private static $moduleFilePaths = array();
    private static $disabledModules = array();
    
    public static function addModule($moduleName, $pathToModule, $pathToModuleFile)
    {
        if (!self::isAbsolutePath($pathToModule)) {
            throw new \LogicException('dirPath must be an absolute path.');
        }
        
        if (!self::isAbsolutePath($pathToModuleFile)) {
            $pathToModuleFile = $pathToModule . DIRECTORY_SEPARATOR . $pathToModuleFile;
        }
        
        self::$moduleDirPaths[$moduleName] = $pathToModule;
        self::$moduleFilePaths[] = $pathToModuleFile;
    }
    
    public static function disableModule($moduleName)
    {
        self::$disabledModules[] = $moduleName;
    }
    
    public static function getPathToModule($moduleName)
    {
        return isset(self::$moduleDirPaths[$moduleName]) ? self::$moduleDirPaths[$moduleName] : null;
    }
    
    public static function getPathsToModuleFiles()
    {
        return self::$moduleFilePaths;
    }
    
    public static function getDisabledModules()
    {
        return self::$disabledModules;
    }
    
    private static function isAbsolutePath($path)
    {
        return '/' === $path{0};
    }
}
