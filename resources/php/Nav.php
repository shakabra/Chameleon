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
     * default_page
     *
     * The file name of the page you want displayed by default.
     */

    private $default_page = 0;

    /**
     * nav_root
     *
     * @property string $nav_root The root directory of where navigation
     *                            will be created for.
     */

    private $nav_root  = 0;

    /**
     * @property array $nav_point Stores strings representing items in the
     *                            $nav_root that will become html navigation.
     */

    private $nav_point = [];


    /**
     *
     */

    public function __construct($config)
    {

        if ($this->check_config($config))
        {
            $this->nav_root = $config['nav_root'];
            $raw_nav_point = scandir($this->nav_root);

            if ($config['files']) {
                $this->get_files($this->nav_root, $this->nav_point);
            }

            if ($config['dirs']) {
                $this->get_subdirs($this->nav_root, $this->nav_point);
            }

            $this->remove_hidden($this->nav_point);
            $this->unset_by_list($config['ignore'], $this->nav_point);

            !$config['default_page'] ?  : $this->default_page = $config['default_page'];
        }
        else {
            print("<pre><b>Nav error</b>: Nav config is invalid.</pre>");
        }
    }


    /**
     * Checks the $config array to make sure required items exist and
     * are of the correct type (logs errors).
     *
     * @param array $config The configuration to be checked.
     *
     * @returns bool $code True if passes configuration check, False
     * otherwise.
     *
     */

    private function check_config($config) {
        $err = 0;
        $code = bool;
        $valid_item = ['nav_root'=>'dir', 'files'=>'bool', 'dirs'=>'bool'];

        foreach ($valid_item as $item => $type)
        {
            if (!array_key_exists($item, $config)) {
                $e = 'No '.$item.' in Nav config array';
                print("<pre><b>Nav configuration error</b>: $e</pre>");
                unset($valid_item[$item]);
                $err++;
            }
        }

        foreach ($valid_item as $item => $type) {
            $e = '';

            if ($type === 'dir')
            {
                if (!is_dir($config[$item])) {
                    $e = $item.' not a valid directory.';
                    $err++;
                }
            }
            else if ($type === 'bool')
            {
                if (!is_bool($config[$item])) {
                    $e = $item.' of wrong type, it is '.gettype($item).' should be '.$type;
                    $err++;
                }
            }

            if ($e != '') {
                print("<pre><b>Nav configuration error</b>: $e</pre>");
            }
        }

        $err === 0 ? $code = True : $code = False;
        return $code;
    }


    /**
     * Scans a given directory for files and pushes any to the given
     * array.
     *
     * @return int $num_files The number of files found.
     *
     */

    private function get_files(&$dir, &$_array)
    {
        $num_files = 0;

        foreach (scandir($dir) as $file) {
            if (is_file("$dir/$file")) {
                array_push($_array, $file);
                ++$num_files;
            }
        }

        return $num_files;
    }


    /**
     * Scans a given directory for directories and pushes any to the
     * given array.
     *
     * @return int $num_files The number of files found.
     *
     */

    private function get_dirs(&$dir, &$_array)
    {
        $num_dirs = 0;

        foreach (scandir($dir) as $file) {
            if (is_dir("$dir/$file")) {
                array_push($_array, $file);
                ++$num_dirs;
            }
        }

        return $num_dirs;
    }


    /**
     * Takes an array of  directory contents and unsets any items in
     * that array that begin with a '.' .
     *
     * @param array $dir_contents The contents of a directory (from
     * scandir function).
     *
     * @return int $num_unset The number of hidden files unset.
     */

    private function remove_hidden(&$dir_contents)
    {
        $num_unset = 0;

        for ($i = count($dir_contents)-1; $i >= 0; $i--) {
            if ($dir_contents[$i][0] == '.') {
                unset($dir_contents[$i]);
                ++$num_unset;
            }
        }

        return $num_unset;
    }


    /**
     * From an array of given files, remove those files from the
     * $nav_point property (array).
     *
     * @param $ignore_list array Listing of the files to remove from the
     * $nav_points array.
     *
     * @return int $num_unset
     */

    private function unset_by_list(&$unset_list, &$_array)
    {
        $num_unset = 0;

        foreach ($unset_list as $item) {
            unset($_array[array_search($item, $this->nav_point)]);
            ++$num_unset;
        }

        return $num_unset;
    }


    public function get_nav_points()
    {
        return $this->nav_point();
    }


    public function __toString()
    {
        $string = "[ ";
        foreach ($this->nav_point as $pt) {
            $string .= "(pt: $pt), ";
        }
        return rtrim($string, ' ,') . ' ]';
    }


    public function get_nav_root()
    {
        return $this->nav_root;
    }


    public function get_default_page()
    {
        return $this->default_page;
    }

    
    /**
     * Returns nav points as HTML list items (<li>).
     *
     * @param array $config The configuration to be checked.
     *
     * @returns string $html HTML list items for each nav point.
     */

    public function toHtml() {
        $html = "";
        foreach ($this->nav_point as $pt) {
            $pt = preg_replace('`.(\w+)$`','',$pt);
            $html .= "<li><a href=\"$pt\">".ucfirst($pt)."</a></li>\n";
        }
        return $html;
    }
}
