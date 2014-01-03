<?php

namespace Lw\Contentory\Agent\TableTools\Repository;

class QueryHandler extends \Lw\Contentory\Repository\QueryHandler
{

    protected $db;

    public function __construct($db, $auth)
    {
        parent::__construct($db, $auth);
    }

    public function getLineCountByTableName($name)
    {
        $this->db->setStatement("SELECT COUNT(*) FROM :table ");
        $this->db->bindParameter("table", "t", $name);

        $result = $this->db->pselect1();

        return $result["COUNT(*)"];
    }

}