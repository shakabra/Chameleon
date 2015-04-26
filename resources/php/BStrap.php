<?php
namespace BStrap;
require_once PHP_DIR.'/Html.php';


abstract class BStrapElement
{
    protected $tag   = null;
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
        }
    }


    public function setId($id)
    {
        $this->id = $id;
    }


    public function setClass($class)
    {
        $this->class = $class;
    }


    /**
     * openingTag
     *
     * Forms an opening div tag for a Bootstrap CSS row.
     *
     * @return string An HTML markup of a Bootstrap CSS row.
     */

    protected function openingTag()
    {
        if ($this->tag == null)
            $html  = '<div ';
        else
            $html  = '<'.$this->tag.' ';

        if ($this->id != null)
          $html .= 'id="'.$this->id.'" ';

        $html .= 'class="'.$this->type;

        if ($this->class != null)
          $html .= ' '.$this->class.'">';
        else
          $html .= '">';

        return $html;
    }


    protected function closingTag()
    {
        $html = '';

        if ($this->tag == null)
            $html  = '</div>';
        else
            $html  = '</'.$this->tag.'>';

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


    public function setType($type)
    {
        if ($type == 'container') {
            $this->type = 'container';
        }
        else {
            $this->type = 'container-fluid';
        }
    }


    /**
     * addRow
     *
     * Appends a Bootstrap CSS row to this object's row array.
     *
     * @param BStrap\Row $row The row to be appended to the row array.
     */

    public function addRow($row)
    {
        return array_push($this->row, $row);
    }


    /**
     * grabRow
     *
     * Grabs (and removes) a row from the row array.
     *
     * @return BStrap\Row A row from the front of the row array (queue).
     */

    protected function grabRow($row_id=null)
    {
        return array_shift($this->row);
    }


    public function toHtml()
    {
        $html  = $this->openingTag();

        foreach ($this->row as $r) {
            $html .= $r->toHtml();
        }

        $html .= $this->closingTag();;
        return $html;
    }
}


class Row extends BStrapElement
{
    protected $type = 'row';
    protected $col  = [];


    public function addColumn($col)
    {
        return array_push($this->col, $col);
    }

    public function toHtml()
    {
        $html  = $this->openingTag();

        foreach ($this->col as $column) {
            $html .= $column->toHtml();
        }
            
        $html .= $this->closingTag();;
        return $html;
    }
}


class Column extends BStrapElement
{
    protected $type         = 'col-md-4';
    protected $html_element = [];


    public function addElement($html_elem)
    {
        array_push($this->html_element, $html_elem);
    }

    public function toHtml()
    {
        $html  = $this->openingTag();

        foreach ($this->html_element as $html_elem) {
            $html .= $html_elem;
        }

        $html .= $this->closingTag();;
        return $html;
    }
}
