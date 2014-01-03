<?php

namespace Lw\Contentory\Agent\PublishRequests\Repository;

class QueryHandler extends \Lw\Contentory\Repository\QueryHandler
{

    protected $db;

    public function __construct($db, $auth)
    {
        parent::__construct($db, $auth);
    }

    public function getAllPagesWithPublishRequests()
    {        
        $this->db->setStatement("SELECT l.*, p.name as pagename, u.name as username FROM t:lw_slog l, t:lw_pages p, t:lw_user u WHERE l.item_type = 'content' AND l.action = 'request publish' AND l.item_id = p.id AND l.user_id = u.id ORDER BY l.timestamp ASC ");
        return $this->db->pselect();
    }

}