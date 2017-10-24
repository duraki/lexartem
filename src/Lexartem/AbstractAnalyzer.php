<?php

namespace Lexartem;

abstract class AbstractAnalyzer 
{

    /**
     * Defines a project structure.
     * @var $structure
     */
    private $structure;

    /**
     * Defines a project path directory.
     * @var $projectDirectory
     */
    private $projectDirectory;

    abstract protected function analyze();

    // xxx: impl free alloc mem
    // xxx: impl on deconstruct
    private function free()
    {
        // xxx: check globals too
    }

    /**
     * Open file and return file handler for future usage
     *
     * @param $filename
     * @return FileHandler
     */
    private function getFile($filename)
    {
        // xxx: exit with proper exception
        if (empty($filename)) throw new \Exception();  

        return new SplFileObject($filename);
    }

    private function getFilesInDirectory(
        $directory,
        $filter = '',
        &$results = array()
    ) {

        $files = scandir($directory);

        foreach ($files as $key => $f) {

            $path = realpath($directory.DIRECTORY_SEPARATOR.$value);
            $this->extract($path, $filter, $results);
        }

        return $results;
    }

    private function extract($path, $filter, &$results)
    {
        if (!is_dir($path)) {
            if (empty($filter) || preg_match($filter, $path)) $results[] = $path;

        } elseif ($value != '.' && $value != '..') {
    
            $file = str_replace($this->projectDirectory, '', $path); // extract file from path
            $file = str_replace('/', '.', $file); // replace path slashes with dots
            $file = ltrim($file, '.'); // remove all left trailing dots (if any)

            $this->structure[] = $file;
            $this->getFilesInDirectory($path, $filter, $results);
        }
    }

}
