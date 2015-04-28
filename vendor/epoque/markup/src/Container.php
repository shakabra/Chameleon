<?php
namespace Epoque\Markup;


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

