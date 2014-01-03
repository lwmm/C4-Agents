<?php

namespace Lw\Contentory\Agent\TableTools\View;
use Lw\Contentory\Library\View\View as View;

class ShowList extends View
{
    protected $view;

    public function __construct()
    {
        parent::__construct();
        if ($this->legacy) {
            $this->view = new \lw_view(dirname(__FILE__).'/Templates/Legacy/ShowList.phtml');
        }
        else {
            $this->view = new \lw_view(dirname(__FILE__).'/Templates/ShowList.phtml');
        }
    }
    
    public function init($array)
    {
        $this->view->tables = $array["tables"];
        $this->view->tableLines = $array["tableLines"];
        $this->view->filter = $array["filter"];
        $this->view->selectedTables = $array["selectedTables"];
    }
}