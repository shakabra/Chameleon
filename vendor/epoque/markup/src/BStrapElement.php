<?php
namespace Epoque\Markup;


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

