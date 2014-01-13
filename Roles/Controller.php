<?php

namespace Lw\Contentory\Agent\Roles;

use \Lw\Contentory\Library\Controller\Controller as BaseController;
use \Lw\Contentory\Library\I18n as I18n;
use \Lw\Library\DTO as DTO;
use \Lw\Contentory\Agent\UserProfil\Repository\Repository as Repository;

class Controller extends BaseController
{

    protected $Request;
    protected $Transporter;
    protected $Array;
    protected $Response;
    protected $I18n;
    protected $Repository;

    public function __construct($Id, $Configuration, $Language)
    {
        parent::__construct($Configuration, $Language);
        $this->I18n = I18n::getInstance($Language, "Lw/Contentory/Agent/Roles/View/I18n/");

        $this->ObjectIdentifier = 'roles';
        $this->Agent = 'Roles';

        $this->Request = \lw_registry::getInstance()->getEntry("request");
        $this->Repository = new Repository();
    }

    public function execute()
    {
        $this->Response->SetOutputByKey('navigation', "");
        $this->Response->SetOutputByKey('main', "");

        return $this->Response;
    }

    private function showNavigation()
    {
        $view = $this->getView('Navigation');
        return $view->render();
    }

    private function showForm($dto)
    {                
        $view = $this->getView('Form');
        
        $view->setShortcuts($this->Repository->getShortcuts());
        
        if ($this->hasError()) {
            $view->setError($this->getError());
        }
        $view->setUser($dto);
        
        return $view->render();
    }
    
    protected function buildDtoFromRequest()
    {
        $auth = \lw_registry::getInstance()->getEntry("auth");
        $array = $this->Request->getPostArray();
        $array["id"] = $auth->getUserdata("id");
        $array['lw_version'] = $array['version'];
        unset($array["version"]);
        return new DTO($array);
    }

}
