<?php
/**
 * A base class available for use within Chameleon framework.
 */

abstract class Chameleon
{
    /**
     * Prints a given error as a [class]-warning.
     *
     * @return void
     */

    protected function printWarning($error)
    {
        $calling_class = debug_backtrace()[1]['class'];
        print 
        '<div class="alert alert-warning alert-dismissible '.lcfirst($calling_class).'-warning" role="alert">
        <b>'.$calling_class.' warning</b>: '.$error.'
        <button type="button" class="close" data-dismiss="alert">
        <span aria-hidden="true">&times;</span>
        <span class="sr-only">Close</span>
        </button>
        </div>';
    }


    /**
     * Prints a given error as a [class]-error.
     *
     * @return void
     */

    protected function printError($error)
    {
        $calling_class = debug_backtrace()[1]['class'];
        print 
        '<div class="alert alert-danger alert-dismissible '.lcfirst($calling_class).'-error" role="alert">
        <b>'.$calling_class.' error</b>: '.$error.'
        <button type="button" class="close" data-dismiss="alert">
        <span aria-hidden="true">&times;</span>
        <span class="sr-only">Close</span>
        </button>
        </div>';
    }
}
