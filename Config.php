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
        $etcDir = $this->getOptions()->getEtcDir();
        $moduleFiles = glob($etcDir . DS . 'modules' . DS . '*.xml');
        $moduleFiles = array_merge($moduleFiles, PathResolver::getPathsToModuleFiles());

        if (!$moduleFiles) {
            return false;
        }

        $collectModuleFiles = array(
            'base'   => array(),
            'mage'   => array(),
            'custom' => array()
        );

        foreach ($moduleFiles as $v) {
            $name = explode(DIRECTORY_SEPARATOR, $v);
            $name = substr($name[count($name) - 1], 0, -4);

            if ($name == 'Mage_All') {
                $collectModuleFiles['base'][] = $v;
            } else if (substr($name, 0, 5) == 'Mage_') {
                $collectModuleFiles['mage'][] = $v;
            } else {
                $collectModuleFiles['custom'][] = $v;
            }
        }

        return array_merge(
            $collectModuleFiles['base'],
            $collectModuleFiles['mage'],
            $collectModuleFiles['custom']
        );
    }
    
    /**
     * {@inheritdoc}
     */
    protected function _isAllowedModule($name)
    {
        return parent::_isAllowedModule($name) && !in_array($name, PathResolver::getDisabledModules());
    }
}
