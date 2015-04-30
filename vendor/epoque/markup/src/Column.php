<?php
namespace Epoque\Markup;


class Column extends BStrapElement
{
    protected $class        = 'col-md-4';
    protected $html_element = [];

    public function __construct($spec=[])
    {
        if (array_key_exists('class', $spec)) {
            $this->class = $spec['class'];
        }
    }


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
