<?php

namespace Lw\Contentory\Agent\UserProfil\View;

use Lw\Contentory\Library\View\View as View;
use \Lw\Library\DTO as DTO;

class Form extends View
{

    protected $view;

    public function __construct()
    {
        parent::__construct();
        if ($this->legacy) {
            $this->view = new \lw_view(dirname(__FILE__) . '/Templates/Legacy/Form.phtml');
        } else {
            $this->view = new \lw_view(dirname(__FILE__) . '/Templates/Form.phtml');
        }
        
        $config = \lw_registry::getInstance()->getEntry("config");
        if(isset($config["general"]["passwordStrength"])){
            $this->view->pwminstrength = $config["general"]["passwordStrength"];
            $this->view->checkPw = true;
        }
    }
    
    public function setShortcuts($shortcuts)
    {
        $this->view->shortcuts = $shortcuts;
    }
    
    public function setUser(DTO $userDto)
    {
        $this->view->user = $userDto;
    }

}
