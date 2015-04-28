<?php
namespace Epoque\Markup;


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

