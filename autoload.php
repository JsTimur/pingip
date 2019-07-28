<?php 
spl_autoload_register(function ($className) {
    $prefix    = 'App\\';
    $prefixLen = strlen($prefix);

    if (strncmp($className, $prefix, $prefixLen) !== 0) {
        throw new Exception('Class not found');
    }

    $classWithoutPrefix = substr($className, $prefixLen);

    $baseDir = __DIR__ . '/src/';
    $classPathWithoutPrefix = str_replace(array('/', '\\'), DIRECTORY_SEPARATOR, $classWithoutPrefix) . '.php';
    $file = $baseDir . $classPathWithoutPrefix;

    if (file_exists($file)) {
        require_once $file;
    } else {
        throw new Exception('Class not found');
    }
});