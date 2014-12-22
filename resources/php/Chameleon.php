<?php
/**
 * A base class available for use within Chameleon framework.
 */

class Chameleon
{
    /**
     * Prints a given error as a nav-error.
     *
     * @return void
     */

    protected function print_error($error)
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
