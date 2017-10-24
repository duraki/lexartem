<?php

namespace Lexartem;

/**
 * An interface for Lexartem analyzer. Allow different topics and depends on 
 * language only.
 *
 * @interface Analyzer
 */
interface Analyzer
{
    
    protected function analyze();

}
