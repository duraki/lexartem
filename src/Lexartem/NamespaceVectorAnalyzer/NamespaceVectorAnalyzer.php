<?php

namespace Lexartem\NamespaceVectorAnalyzer;

use Lexartem\Analyzer;
use Lexartem\AbstractAnalyzer;

class NamespaceVectorAnalyzer extends AbstractAnalyzer implements Analyzer
{

    public function analyze($file)
    {
        $fh = $this->getFile($file);
        $namespace = null;

        while (!$fh->eof()) {
            if (strpos($fh->fgets(), 'namespace')) { // detected namespace *tag
                $this->getValueInterestFactor($line);
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

    /**
     * pvif is allocated for object Namespace
     *
     * @value namespace \ExLexartem\Object;
     * @param $line
     * @return string
     */
    protected function getValueInterestFactor($line)
    {
        $line = explode(' ', $line); // [namespace] [\ExLexartem\Object;]
        $line = rtrim( trim($line[1]), ';' ); // [\ExLexartem\Object]
        $line = str_replace('\\', '.', $line); // [.ExLexartem.Object] (translate to prefered object hierarchy)

        var_dump($line);die;
    }

}
