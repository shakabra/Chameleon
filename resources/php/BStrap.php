<?php
namespace BStrap;
require_once PHP_DIR.'/HTML.php';

class Container
{
    protected $id     = null;
    protected $class  = null;
    protected $type   = 'container-fluid';
    protected $row    = []; /* Used as a queue to load with bootstrap rows, */
                            /* and then unloaded onto a page.               */


    /**
     * construtor
     *
     * Sets specified container properties.
     *
     * @param array $spec Associative array with key value mappings of
     * container properties.
     */

    public function __construct($spec=[])
    {

    }


    public function set_id($id)
    {
        $this->id = $id;
    }


    public function set_class($class)
    {
        $this->class = $class;
    }


    public function set_type($type)
    {
        if ($type == 'container') {
            $this->type = 'container';
        }
    }


    /**
     * add_row
     *
     * Appends a Bootstrap CSS row to this object's row array.
     *
     * @param BStrap\Row $row The row to be appended to the row array.
     */

    public function add_row($row)
    {
        return array_push($this->row, $row);
    }


    /**
     * grab_row
     *
     * Grabs (and removes) a row from the row array.
     *
     * @return BStrap\Row A row from the front of the row array (queue).
     */

    protected function grab_row($row_id=null)
    {
        return array_shift($this->row);
    }


    /**
     * open_div_tag
     *
     * Forms an opening div tag for a Bootstrap CSS row.
     *
     * @return string An HTML markup of a Bootstrap CSS row.
     */

    protected function open_div_tag()
    {
        $html  = '<div ';

        if ($this->id != null)
          $html .= 'id="'.$this->id.'" ';

        $html .= 'class="'.$this->container_type;

        if ($this->class != null)
          $html .= $this->class.'">';
        else
          $html .= '">';

        return $html;
    }


    /**
     * toHtml
     *
     * Generates the HTML of a Bootstrap CSS container.
     *
     * @return String HTML markup of a Bootstrap CSS container.
     */

    public function toHtml()
    {
        $html  = $this->open_div_tag();

        $html .= '</div>';
        return $html;
    }
}
