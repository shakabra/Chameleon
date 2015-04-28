<?php
namespace Epoque\Markup;


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
