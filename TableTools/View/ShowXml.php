<?php

namespace Lw\Contentory\Agent\TableTools\View;
use Lw\Contentory\Library\View\View as View;

class ShowXml extends View
{
    protected $view;

    public function __construct()
    {
        parent::__construct();
        if ($this->legacy) {
            $this->view = new \lw_view(dirname(__FILE__).'/Templates/Legacy/ShowXml.phtml');
        }
        else {
            $this->view = new \lw_view(dirname(__FILE__).'/Templates/ShowXml.phtml');
        }
    }
    
    public function setXml($xml)
    {
        $this->view->xml = $xml;
    }
}