<?php

namespace Lw\Contentory\Agent\TableTools\View;
use Lw\Contentory\Library\View\View as View;

class Navigation extends View
{
    protected $view;

    public function __construct()
    {
        parent::__construct();
        if ($this->legacy) {
            $this->view = new \lw_view(dirname(__FILE__).'/Templates/Legacy/Navigation.phtml');
        }
        else {
            $this->view = new \lw_view(dirname(__FILE__).'/Templates/Navigation.phtml');
        }
    }
    
    public function setCmd($cmd)
    {
        $this->view->command = $cmd;
    }
}
