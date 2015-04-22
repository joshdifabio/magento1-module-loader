<?php
use MagentoModuleLoader\PathResolver;

/**
 * @author Josh Di Fabio <joshdifabio@gmail.com>
 */
class Mage_Core_Model_Config extends Mage_Core_Model_Config__vanilla
{
    /**
     * {@inheritdoc}
     */
    public function getModuleDir($type, $moduleName)
    {
        if (!$dir = PathResolver::getPathToModule($moduleName)) {
            return parent::getModuleDir($type, $moduleName);
        }
        
        $dir = str_replace('/', DS, $dir);
        
        switch ($type) {
            case 'etc':
                $dir .= DS . 'etc';
                break;

            case 'controllers':
                $dir .= DS . 'controllers';
                break;

            case 'sql':
                $dir .= DS . 'sql';
                break;
            
            case 'data':
                $dir .= DS . 'data';
                break;

            case 'locale':
                $dir .= DS . 'locale';
                break;
        }

        return $dir;
    }
    
    /**
     * {@inheritdoc}
     */
    protected function _getDeclaredModuleFiles()
    {
        $filesInAppEtcModules = parent::_getDeclaredModuleFiles() ?: array();
        $filePaths = array_merge($filesInAppEtcModules, PathResolver::getModuleFilePaths());
        
        return $filePaths ?: false;
    }
    
    /**
     * {@inheritdoc}
     */
    protected function _isAllowedModule($name)
    {
        return parent::_isAllowedModule($name) && !in_array($name, PathResolver::getDisabledModules());
    }
}
