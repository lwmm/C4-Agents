<?php

namespace Lw\Contentory\Agent\TableTools\View;

use Lw\Contentory\Library\View\View as View;

class ShowImportInfo extends View
{

    protected $view;

    public function __construct()
    {
        parent::__construct();
        if ($this->legacy) {
            $this->view = new \lw_view(dirname(__FILE__) . '/Templates/Legacy/ShowImportInfo.phtml');
        } else {
            $this->view = new \lw_view(dirname(__FILE__) . '/Templates/ShowImportInfo.phtml');
        }
    }

    public function init($array)
    {
        if (isset($array["debugOutput"])) {
            $this->view->debugOutput = $array["debugOutput"];
        }
        if (isset($array["debug"])) {
            $this->view->debug = $array["debug"];
        }
    }

}
