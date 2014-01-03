<?php

namespace Lw\Contentory\Agent\PublishRequests\View;

use Lw\Contentory\Library\View\View as View;

class RequestList extends View
{

    protected $view;

    public function __construct()
    {
        parent::__construct();
        if ($this->legacy) {
            $this->view = new \lw_view(dirname(__FILE__) . '/Templates/Legacy/RequestList.phtml');
        } else {
            $this->view = new \lw_view(dirname(__FILE__) . '/Templates/RequestList.phtml');
        }
    }
    
    public function setRequests($requests)
    {
        $this->view->requests = $requests;
    }

}
