<?php

namespace Upgrade;

class Process 
{
    private $previousVersionLib;

    private $namespace;

    /**
     * @var \Upgrade\MapperInterface
     */
    private $mapper;

    public function __construct($previousVersionLib, $namespace, $mapper)
    {
        $this->previousVersionLib = rtrim($previousVersionLib, '/');
        $this->namespace = $namespace;
        $this->mapper = $mapper;
    }

    /**
     * @param \Storage $storage
     */
    public function doUpgrade($storage)
    {
        spl_autoload_register(array($this, 'autoloader'));

        foreach ($this->readDir($this->previousVersionLib) as $relativePath) {
            $className = str_replace('/', '\\', substr($relativePath, 2, -4));


            $statement = $storage->querySerializedData($className);
            while ($row = $statement->fetch()) {

                $previousVersionInstance = $this->instantiatePreviousVersion(
                    $row['serialized'], $this->namespace . '\\' . $className
                );

                $currentVersionInstance = $this->mapper->map($previousVersionInstance);
                $currentVersionInstance->persisted($row['id']);
                $storage->save($currentVersionInstance);
            }
        }
        spl_autoload_unregister(array($this, 'autoloader'));
    }

    public function autoloader($className)
    {
        if (strpos($className, $this->namespace . '\\') === 0) {
            $classPath = $this->previousVersionLib
                . '/' . str_replace('\\', '/', substr($className, strlen($this->namespace) + 1)) . '.php';

            if (is_file($classPath)) {
                include $classPath;
            }
        }
    }

//----------------------------------------------------------------------------------------------------------------------

    /**
     * @param string $serializedObject previous version
     * @param string $className
     * @return \PersistedInterface instance of previous version
     */
    private function instantiatePreviousVersion($serializedObject, $className)
    {
        return unserialize(sprintf(
                'O:%d:"%s"%s',
                strlen($className),
                $className,
                strstr(strstr($serializedObject, '"'), ':')
            ));
    }

    private function readDir($path, $exclude = ".|..", $relativePart = '.') {
        $path = rtrim($path, "/") . "/";
        $folder_handle = opendir($path);
        $exclude_array = explode("|", $exclude);
        $result = array();
        while(false !== ($filename = readdir($folder_handle))) {
            if(!in_array(strtolower($filename), $exclude_array)) {
                if(is_dir($path . $filename . "/")) {
                    // Need to include full "path" or it's an infinite loop
                    $result = array_merge(
                        $result,
                        $this->readDir($path . $filename . "/", $exclude, $relativePart . '/' . $filename)
                    );
                } else {
                    $result[] = $relativePart . '/' . $filename;
                }
            }
        }
        return $result;
    }

}