<?php

namespace Lw\Contentory\Agent\PageComments;

use \Lw\Contentory\Library\Controller\Controller as BaseController;
use \Lw\Contentory\Library\I18n as I18n;
use \Lw\Contentory\Agent\PageComments\Repository\Repository as Repository;

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
        $this->I18n = I18n::getInstance($Language, "Lw/Contentory/Agent/PageComments/View/I18n/");

        $this->ObjectIdentifier = 'pagecomments';
        $this->Agent = 'PageComments';

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
        $comments = $this->prepareCommentList($repository->getAllPagesWithComments());

        $view = $this->getView('CommentList');
        $view->setCommentList($comments);
        return $view->render();
    }

    private function prepareCommentList($comments)
    {
        foreach ($comments as $nr => $comment) {
            foreach ($comment as $key => $value) {

                switch ($key) {
                    case "published":
                    case "changed":
                        $comments[$nr][$key] = substr($value, 6, 2) . "." . substr($value, 4, 2) . "." . substr($value, 0, 4);
                        break;

                    case "pagecomment":
                        $pc = $value;
                        $pc = preg_replace("^<!-- (.*?) -->^sm", "", html_entity_decode($pc));
                        $pc = trim(htmlspecialchars($pc));

                        $comments[$nr][$key] = $pc;
                        break;
                }
            }
        }

        return $comments;
    }

}
