<?php

namespace Lexartem\Runtime;

use Lexartem\NamespaceVectorAnalyzer\NamespaceVectorAnalyzer;
use Lexartem\Analyzer;

class Kernel
{

    private $directory;

    private $syntax;

    // xxx: too tired :(
    //
    public function setDirectory($directory)
    {
        $this->directory = $directory;
    }

    public function setSyntax($syntax)
    {
        $this->syntax = $syntax;
    }

    private const PHP = [
        NamespaceVectorAnalyzer::class,
    ];

    public function execute()
    {
        foreach (self::PHP as $vector) {
            // xxx: reflection class? :/
            $vector = new $vector;
            $vector->analyze($this->directory);
        }
    }

}
