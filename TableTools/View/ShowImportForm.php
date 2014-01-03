<?php

namespace Lw\Contentory\Agent\TableTools\View;

use Lw\Contentory\Library\View\View as View;

class ShowImportForm extends View
{

    protected $view;

    public function __construct()
    {
        parent::__construct();
        if ($this->legacy) {
            $this->view = new \lw_view(dirname(__FILE__) . '/Templates/Legacy/ShowImportForm.phtml');
        } else {
            $this->view = new \lw_view(dirname(__FILE__) . '/Templates/ShowImportForm.phtml');
        }
    }

    public function init($array)
    {
        if (isset($array["xml"])) {
            $this->view->xml = $array["xml"];
        }
    }

}
