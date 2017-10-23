<?php

namespace Lexartem\NamespaceVectorAnalyzer;

use Lexartem\Analyzer;
use Lexartem\AbstractAnalyzer;

class NamespaceVectorAnalyzer extends AbstractAnalyzer implements Analyzer
{

    protected function analyze($file)
    {
        if (empty($file)) throw new \Exception();  

        $namespace = null; $fh = fopen($file, 'r');
        if (!$fh) throw new \Exception(); 

        while (($line = fgets($fh)) !== false) {
            if (strpos($line, 'namespace') === 0) {
                $p = explode(' ', $line);
                $namespace = rtrim(trim($p[1]), ';');
                $namespace = str_replace('\\', '.', $ns);
                $namespace .= '.'.basename($file, '.php');

                $this->structure[] = $namespace;
                break;
            }
        }

        fclose($fh);
    }

}
