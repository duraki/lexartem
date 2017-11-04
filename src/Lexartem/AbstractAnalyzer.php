<?php

namespace Lexartem;

abstract class AbstractAnalyzer 
{

    /**
     * Defines a project structure.
     *
     * @var $structure
     */
    private $structure;

    /**
     * Defines a project path directory & language.
     *
     * @var $directory
     * @var $language
     */
    private $directory;
    private $language;

    /**
     * A single file handle.
     *
     * @var $file
     */
    private $file;

    /**
     * @inherit
     */
    abstract protected function analyze($file);

    function __construct($directory, $language)
    {
        $this->directory    = $directory;
        $this->language     = $language;
        $this->structure    = $this->getFilesInDirectory($directory);
    }

    // xxx: impl free alloc mem
    // xxx: impl on deconstruct or when must (locks)
    private function free()
    {
        // xxx: check globals too
        $this->file = null;
    }

    /**
     * Open file and return file handler for future usage
     *
     * xxx: possible optimization for this is to load buffer till exact point
     * xxx: for example, namespace is usually allocated after phptag val `<?php
     * xxx: (irrelevant are comments), and is oneliner. 
     *
     * xxx: all such handling could be decoupled from here, but with a proper
     * xxx: abstraction point, (pe: depends on language)
     *
     * @param $filename
     * @return SplFileObject
     */
    private function getFile($filename)
    {
        // xxx: exit with proper exception
        if (empty($filename)) throw new \Exception();  
        $this->file = SplFileObject($filename);

        return $this->file;
    }

    /**
     * Get files in directory
     *
     * @param $directory
     * @param $filter
     * @param $results +ref
     * @retun array
     */
    private function getFilesInDirectory($directory, $filter = '', &$results = array()) 
    {
        $files = scandir($directory);

        foreach ($files as $file => $f) {
            $path = realpath($directory.DIRECTORY_SEPARATOR.$f);
            $this->extract($path, $filter, $results);
        }

        return $results;
    }

    private function extract($path, $filter, &$results)
    {
        if (!is_dir($path)) {
            if (empty($filter) || preg_match($filter, $path)) $results[] = $path;
            return;
        }

        if ($path == '.' || $path == '..') {
            return;
        }

        var_dump($path);
        var_dump($filter);
        var_dump($results);

        $file = str_replace($this->directory, '', $path);
        $file = ltrim(str_replace('/', '.', $path), '.'); // remove left slashes

        $this->structure[] = $file;

        var_dump($file);die;
        $path = realpath($this->directory.DIRECTORY_SEPARATOR.$file);
        var_dump($path);die;
        $this->getFilesInDirectory($path, $filter, $results);
        var_dump("F",$file);

        /**
        if (!is_dir($path)) {
            if (empty($filter) || preg_match($filter, $path)) $results[] = $path;

        } elseif ($path != '.' && $path != '..') { // skip backdir

            var_dump($path);
            //var_dump($this->directory);die;
    
            $file = str_replace($this->directory, '', $path); // extract file from path
            var_dump($file);
            $file = str_replace('/', '.', $file); // replace path slashes with dots
            $file = ltrim($file, '.'); // remove all left trailing dots (if any)

            $this->structure[] = $file;
            //$this->getFilesInDirectory($path, $filter, $results);
        }
        **/
    }

}
