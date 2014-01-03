<?php

namespace Lw\Contentory\Agent\PageComments\View;

use Lw\Contentory\Library\View\View as View;

class CommentList extends View
{

    protected $view;

    public function __construct()
    {
        parent::__construct();
        if ($this->legacy) {
            $this->view = new \lw_view(dirname(__FILE__) . '/Templates/Legacy/CommentList.phtml');
        } else {
            $this->view = new \lw_view(dirname(__FILE__) . '/Templates/CommentList.phtml');
        }
    }
    
    public function setCommentList($commentList)
    {
        $this->view->commentList = $commentList;
    }

}
