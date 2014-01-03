<?php

namespace Lw\Contentory\Agent\PageComments\Repository;

class QueryHandler extends \Lw\Contentory\Repository\QueryHandler
{

    protected $db;

    public function __construct($db, $auth)
    {
        parent::__construct($db, $auth);
    }

    public function getAllPagesWithComments()
    {
        $this->db->setStatement("SELECT id, name, published, changed, pagecomment FROM t:lw_pages WHERE pagecomment IS NOT NULL ");
        return $this->db->pselect();
    }

}