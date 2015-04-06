<?php
namespace BStrap;
require_once PHP_DIR.'/HTML.php';


abstract class BStrapElement
{
    protected $type  = null;
    protected $id    = null;
    protected $class = null;


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
        if ($spec != [])
        {
            foreach ($spec as $property => $value) 
            {
                if (array_key_exists($property, get_class_vars(__CLASS__)))
                    $this->$property = $value;
            }
            $this->set_type($this->type);
        }
    }


    public function set_id($id)
    {
        $this->id = $id;
    }


    public function set_class($class)
    {
        $this->class = $class;
    }


    /**
     * open_div_tag
     *
     * Forms an opening div tag for a Bootstrap CSS row.
     *
     * @return string An HTML markup of a Bootstrap CSS row.
     */

    protected function opening_tag()
    {
        $html  = '<div ';

        if ($this->id != null)
          $html .= 'id="'.$this->id.'" ';

        $html .= 'class="'.$this->type;

        if ($this->class != null)
          $html .= ' '.$this->class.'">';
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
    abstract public function toHtml();
}


class Container extends BStrapElement
{
    protected $type   = 'container-fluid';
    protected $row    = []; /* Used as a queue to load with bootstrap rows, */
                            /* and then unloaded onto a page.               */


    public function set_type($type)
    {
        if ($type == 'container') {
            $this->type = 'container';
        }
        else {
            $this->type = 'container-fluid';
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


    public function toHtml()
    {
        $html  = $this->opening_tag();

        foreach ($this->row as $r) {
            $html .= $r->toHtml();
        }

        $html .= '</div>';
        return $html;
    }
}


class Row extends BStrapElement
{
    protected $type = 'row';
    protected $col  = [];


    public function add_col($col)
    {
        return array_push($this->col, $col);
    }

    public function toHtml()
    {
        $html  = $this->opening_tag();

        foreach ($this->col as $col) {
            $html .= $col->toHtml();
        }
            
        $html .= '</div>';
        return $html;
    }
}


class Column extends BStrapElement
{
    protected $type         = 'col-md-4';
    protected $html_element = [];

    public function toHtml()
    {
        $html  = $this->opening_tag();

        foreach ($this->html_element as $html_elem) {
            $html .= $html_elem;
        }

        $html .= '</div>';
        return $html;
    }
}
