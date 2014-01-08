<?php

namespace Lw\Contentory\Agent\PublishRequests;

use \Lw\Contentory\Library\Controller\Controller as BaseController;
use \Lw\Contentory\Library\I18n as I18n;
use \Lw\Contentory\Agent\PublishRequests\Repository\Repository as Repository;

class Controller extends BaseController
{

    protected $Request;
    protected $Transporter;
    protected $Array;
    protected $Response;
    protected $I18n;

    public function __construct($Id, $Configuration, $Language)
    {
        parent::__construct($Configuration, $Language);
        $this->I18n = I18n::getInstance($Language, "Lw/Contentory/Agent/PublishRequests/View/I18n/");

        $this->ObjectIdentifier = 'publishrequests';
        $this->Agent = 'PublishRequests';

        $this->Request = \lw_registry::getInstance()->getEntry("request");
    }

    public function execute()
    {
        $this->Response->SetOutputByKey('navigation', $this->showNavigation());
        $this->Response->SetOutputByKey('main', $this->showCommentList());

        return $this->Response;
    }

    private function showNavigation()
    {
        $view = $this->getView('Navigation');
        return $view->render();
    }

    private function showCommentList()
    {
        $repository = new Repository();
        
        $view = $this->getView('RequestList');
        $view->setRequests($repository->getAllPagesWithPublishRequests());
        return $view->render();

    }

}
