<?php

namespace Lw\Contentory\Agent\TableTools\Repository;

use Lw\Contentory\Agent\TableTools\Repository\QueryHandler as QueryHandler;

class Repository
{

    public function __construct()
    {
        $this->QueryHandler = new QueryHandler(\lw_registry::getInstance()->getEntry("db"), \lw_registry::getInstance()->getEntry("auth"));
    }

    public function getLineCountByTableName($value)
    {
        return $this->QueryHandler->getLineCountByTableName($value);
    }

}
