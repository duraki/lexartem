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
    
    public function analyze($file);

    // xxx: impl language guesser
    // xxx: scandir will have results of each file, meassure the scale of
    // xxx: filenames or file syntax and compare results against each other
}
