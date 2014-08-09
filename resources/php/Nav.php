<?php
/**
 * Creates a new Nav object that can be used for Web site navigation.
 *
 * @param array $config Required and optional key => value pairs used 
 * to create the Nav object.
 *
 *     Required Keys                Optional Keys
 *     --------------               --------------
 *     ['nav_root'] => string       ['ignore'] => array
 *     ['dirs'] => boolean
 *     ['files'] => boolean
 *
 * * **nav_root**   The directory where navigation begins.
 * * **dirs**       Whether or not to have sub-directories of **nav_root**
 *                  as nav points.
 * * **files**      Whether or not to have files in **nav_root** as nav points.
 * * **ignore**     An array listing files and/or directories in **nav_root**
 *                  not to make into nav points.
 *
 * @author Jason Favrod
 */

class Nav {
    /**
     * @property string $nav_root The root directory of where navigation
     *                            will be created for.
     */
    private $nav_root  = "no root set";

    /**
     * @property array $nav_point Stores strings representing items in the
     *                            $nav_root that will become html navigation.
     */
    private $nav_point = [];

    public function __construct($config) {
        try {
            $this->check_config($config);
            $this->nav_root = $config['nav_root'];
        }
        catch (Exception $e) {
            print("<pre><b>Navigation Error</b></pre>");
            // @todo should this be a return statement?
            // this is going to be what's displayed instead of
            // navigation, because initial check of $config failed.
        }

        try {
            $raw_nav_point = scandir($this->nav_root);
            $this->nav_point = $this->remove_hidden($raw_nav_point);
        }
        catch (ErrorException $e) {
            return "Could not set initial nav_points";
        }

        try {
            if ($config['files'] && !$config['dirs']) {
                $this->nav_point = $this->get_files($this->nav_root, $this->nav_point);
            }
            if (!$config['files'] && $config['dirs']) {
                $this->nav_point = $this->get_subdirs($this->nav_root, $this->nav_point);
            }
        }
        catch (Exception $e) {
            return "Could not determine if navigation should contain files or directories";
        }

        if (!empty($config['ignore'])) {
            $this->remove_ignore($config['ignore']);
        }
    }

    /**
     * Checks the $config array to make sure required items exist and are
     * of the correct type. If the array is invalid, errors are logged and an
     * Exception is thrown.
     *
     * @param array $config The configuration to be checked.
     *
     * @returns void
     *
     * @todo Make this error handling go away and do it better; let's make it
     * useful: good feedback, easy and to find and fix the problem.
     */
    private function check_config($config) {
        $err = 0;

        if (!array_key_exists('nav_root', $config)) {
            $e = new Exception("No 'nav_root' in Nav configuration");
            error_log("Error in ".$e->getFile()." : Nav configuration error : ".$e->getMessage());
            $err++;
        }

        if (!array_key_exists('files', $config)) {
            $e = new Exception("No 'files' directive in Nav configuration");
            error_log("Error in ".$e->getFile()." : Nav configuration error : ".$e->getMessage());
            $err++;
        }

        if (!array_key_exists('dirs', $config)) {
            $e = new Exception("No 'dirs' directive in Nav configuration");
            error_log("Error in ".$e->getFile()." : Nav configuration error : ".$e->getMessage());
            $err++;
        }

        if (!is_dir($config['nav_root'])) {
            $e = new Exception("No 'nav_root' in Nav configuration");
            error_log("Error in ".$e->getFile()." : Nav configuration error : ".$e->getMessage());
            $err++;
        }

        if (!is_bool($config['files'])) {
            $e = new Exception("The configuration directive 'files' is not a boolean value");
            error_log("Error in ".$e->getFile()." : Nav configuration error : ".$e->getMessage());
            $err++;
        }

        if (!is_bool($config['dirs'])) {
            $e = new Exception("The configuration directive 'dirs' is not a boolean value");
            error_log("Error in ".$e->getFile()." : Nav configuration error : ".$e->getMessage());
            $err++;
        }

        if ($err > 0) {
            throw new Exception("The configuration of Nav is invalid; see error.log");
        }
    }

    /**
     * Takes an array of  directory contents and unsets any items in that array
     * that begin with a '.' .
     *
     * @param array $dir_contents The contents of a directory (from scandir
     * function).
     *
     * @return array The contents of the given (scandir) array with the hidden
     * files unset.
     */
    private function remove_hidden($dir_contents) {
        for ($i = count($dir_contents)-1; $i >= 0; $i--) {
            if ($dir_contents[$i][0] == '.') {
                unset($dir_contents[$i]);
            }
        }
        return $dir_contents;
    }

    /**
     * From an array of given files, remove those files from the
     * $nav_point property (array).
     *
     * @param $ignore_list array Listing of the files to remove from the
     * $nav_points array.
     *
     * @return void
     */
    private function remove_ignore($ignore_list) {
        foreach ($ignore_list as $item) {
            unset($this->nav_point[array_search($item, $this->nav_point)]);
        }
    }

    /**
     * Seprate out the files from the $nav_pts and return an array of the
     * with only the files.
     *
     * @return array 
     */
    private function get_files($dir, $nav_pts) {
        $file = [];
        foreach ($nav_pts as $item) {
            if (is_file("$dir/$item")) {
                array_push($file, $item);
            }
        }
        return $file;
    }

    private function get_subdirs($dir, $nav_pts) {
        $subdir = [];
        foreach ($nav_pts as $item) {
            if (is_dir("$dir/$item")) {
                array_push($subdir, $item);
            }
        }
        return $subdir;
    }

    public function get_nav_points() {
        return $this->nav_point();
    }

    public function __toString() {
        $string = "[ ";
        foreach ($this->nav_point as $pt) {
            $string .= "(pt: $pt), ";
        }
        return rtrim($string, ' ,') . ' ]';
    }
    
    public function toHtml() {
        $html = "";
        foreach ($this->nav_point as $pt) {
            $pt = preg_replace('`.(\w+)$`','',$pt);
            $html .= "<li><a href=\"$pt\">".ucfirst($pt)."</a></li>\n";
        }
        return $html;
    }
}
